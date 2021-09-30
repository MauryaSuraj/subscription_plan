<?php

// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

require_once(__DIR__ . '/../../config.php');
require_once($CFG->dirroot . '/local/paytm/lib.php');
require_once($CFG->dirroot . '/local/paytm/PaytmChecksum.php');

class local_paytm_external extends external_api {

    public static function create_payment_link_parameters() {
        return new external_function_parameters(
                array(
            'amount' => new external_value(PARAM_TEXT, 'amount'),
            'emails' => new external_value(PARAM_TEXT, 'emails'),
            'phone' => new external_value(PARAM_INT, 'phone')
         )
        );
    }
//generate payment link
        
    public static function create_payment_link($amount, $emails, $phone) {
        global $DB, $CFG, $USER;
        //  print_r($USER);die;
        $paytmParams = array();
        $MIN_SESSION_ID = 1000000000;
        $MAX_SESSION_ID = 9999999999;

        $mrid = mt_rand($MIN_SESSION_ID, $MAX_SESSION_ID);
        $linkid = mt_rand($MIN_SESSION_ID, $MAX_SESSION_ID);
        
        $paytmconf = get_paytm_config(); // paytm configuration 
        
        if($paytmconf->sendsms == 1){
            $smsflag = true;
        }else{
            $smsflag = false;
        }
        
        if($paytmconf->sendemail == 1){
            $emailflag = true;
        }else{
            $emailflag = false;
        }
        
         if($paytmconf->parcialpayment == 1){
            $parcialpayment = true;
        }else{
            $parcialpayment = false;
        }
        
        
        
        if($paytmconf->productionenabled == 1){
            $mid = $paytmconf->prodmid;
            $secratekey = $paytmconf->prodsecratekey;
        }else{
            $mid = $paytmconf->mid;
            $secratekey = $paytmconf->secratekey;
        }
        
      
        //qWzfEp10614896611074
        //"linkType" => $paytmconf->paymenttype,
        $paytmParams["body"] = array(
            "merchantRequestId" =>$mrid,
            "mid" => $mid,
            "linkType" => $paytmconf->paymenttype,
            "linkDescription" =>$paytmconf->linkdescription,
            "linkName" => $paytmconf->linkname,
            "websiteName" => "WEBSTAGING",
            "sendSms" => $smsflag,
            "sendEmail" => $emailflag,
            "amount" => $amount,
            "customerContact" => array("customerName" => $USER->firstname . " " . $USER->lastname,
                "customerEmail" => $emails,
                "customerMobile" => $phone),
            "statusCallbackUrl" =>$paytmconf->callbackurl,
            "invoiceId" => "MKS-" > time(),
            "linkId" => time(),
            "partialPayment" => $parcialpayment,
        );


//"https://smiletutoring.com.au/returnurl.php"
        /*
         * Generate checksum by parameters we have in body
         * Find your Merchant Key in your Paytm Dashboard at https://dashboard.paytm.com/next/apikeys 
         */
//$checksum = PaytmChecksum::generateSignature(json_encode($paytmParams["body"], JSON_UNESCAPED_SLASHES), "YOUR_MERCHANT_KEY");
        //"ovK4zlB!TLyRwwnC"
        $checksum = PaytmChecksum::generateSignature(json_encode($paytmParams["body"], JSON_UNESCAPED_SLASHES), $secratekey);

        $paytmParams["head"] = array(
            "tokenType" => "AES",
            "signature" => $checksum,
            "channelId" => "WEB",
            "timestamp" => time(),
            "clientId" => "qWzfEp10614896611074",
            "version" => "v2"
        );

        $post_data = json_encode($paytmParams, JSON_UNESCAPED_SLASHES);
      // echo "<pre>"; 
      // print_r($post_data);die;
        /* for Staging */
        $url = "https://securegw-stage.paytm.in/link/create";

        /* for Production */
        // $url = "https://securegw.paytm.in/link/create";

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
        $response = curl_exec($ch);

        $data = json_decode($response);

       //print_object($data);
       //  $table = new stdClass();

        $expiredate = strtotime(str_replace('/', '-', $data->body->expiryDate));
        $createdDate = strtotime(str_replace('/', '-', $data->body->createdDate));
        $table->userid = $USER->id;
        $table->merchantrequestid = $data->body->merchantRequestId;
        $table->merchantrequestid = $data->body->merchantRequestId;
        $table->linkid = $data->body->linkId;
        $table->amount = $amount;
        $table->linktype = $data->body->linkType;
        $table->longurl = $data->body->longUrl;
        $table->shorturl = $data->body->shortUrl;
        $table->expirydate = $expiredate;
        $table->isactive = $data->body->isActive;
        $table->createddate = $createdDate;
        $table->resultjson = $response;
        $table->notifycontact = $phone;
        $table->notifyemail = $emails;
       
                
        $insetedid = $DB->insert_record('paytm_link_info', $table);
        
        //$updatedid = update_order($orderid, $insetedid);
        //send_sms($data->body->shortUrl,$emails,$phone);

        $update = new stdClass();
       
        foreach ($data->body as $cdata) {
            foreach ($cdata as $notificationsdetails) {
                $update->id = $insetedid;               
                $update->notifyname = $notificationsdetails->customerName;
                $update->notifystatusmobile = $notificationsdetails->notifyStatus;
                $update->notifystatusemail = $notificationsdetails->notifyStatus;
                $update->notifytime = strtotime(str_replace('/', '-', $notificationsdetails->timestamp));

                $updated = $DB->update_record('paytm_link_info', $update);
                
            }
//           
        }
      
       if($data->body->resultInfo->resultCode == 200){
           $result = 'success';
       }else{
             $result = 'fail';
       }
       // echo $result;
        return $result;
    }

    public static function create_payment_link_returns() {
        return new external_value(PARAM_TEXT, 'Link generate');
    }

}
