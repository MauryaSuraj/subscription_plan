<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require(dirname(dirname(dirname(__FILE__))) . '/config.php');
require_once ('lib.php');
global $PAGE, $DB, $USER;
$postdata = '{"CURRENCY":"INR","LINKDESCRIPTION":"makershala payment","LINKCUSTOMEREMAIL":"santosh0282@gmail.com","PAYMENTMOBILENUMBER":"9643803789","GATEWAYNAME":"HDFC","RESPMSG":"Txn Success","BANKNAME":"ICICI","PAYMENTMODE":"DC","CUSTID":"1000712690","MID":"qWzfEp10614896611074","MERC_UNQ_REF":"LI_105251","LINKCUSTOMERNAME":"Nano gupta","RESPCODE":"01","LINKCUSTOMERMOBILE":"9643803789","TXNID":"20210620111212800110168647302737102","TXNAMOUNT":"200.00","ORDERID":"202106202057140030","STATUS":"TXN_SUCCESS","BANKTXNID":"777001784317951","TXNDATETIME":"2021-06-20 20:57:33.0","TXNDATE":"2021-06-20","CHECKSUMHASH":"SIN\/s2BREJVoe9VtQ\/sgJD5VcR321tj\/9fqa0xdOk9DLAMn7sYoHpOwPur\/IEThkSr9ihjC30+NWgAS7eE4rexvsvijOMKUbXOEr9bsf+M0=","MERCHANTLINKREFERENCEID":"6797078013"}';
$data = json_decode($postdata);

$table = new stdClass();
$table->paymobilenumber = $data->PAYMENTMOBILENUMBER;
$table->gatewayname = $data->GATEWAYNAME;
$table->responsemsg = $data->RESPMSG;
$table->bankname = $data->BANKNAME;
$table->customerid = $data->CUSTID;
$table->mid = $data->MID;
$table->merc_uni_ref = $data->MERC_UNQ_REF;
$table->respcode = $data->RESPCODE;
$table->txnid = $data->TXNID;
$table->txnamount = $data->TXNAMOUNT;
$table->orderid = $data->ORDERID;
$table->status = $data->STATUS;
$table->banktxid = $data->BANKTXNID;
$table->txndatetime = strtotime(str_replace('/', '-', $data->TXNDATETIME));
$table->merchantlinkrefid = $data->MERCHANTLINKREFERENCEID;
$table->jsondata = $postdata;

$insetedid = $DB->insert_record('payment_history', $table);
if (!empty($insetedid)) {
    $pid = $DB->get_record('paytm_link_info', array('merchantrequestid' => $data->MERCHANTLINKREFERENCEID));
    $updatepayment = new stdClass();
    $updatepayment->id = $pid->id;
    $updatepayment->paidamount = $data->TXNAMOUNT;
    $updatepayment->actualpaydate = time();
    $DB->update_record('paytm_link_info', $updatepayment);
}

if (!empty($insetedid)) {
    $wallet = $DB->get_record_sql('select * from {user_wallet} where userid=' . $USER->id);
    if (!empty($wallet)) {
      
        $remain_amout = $wallet->totalamount + $data->TXNAMOUNT;
        $update_wallet = new stdClass();
        $update_wallet->id = $wallet->id;
        $update_wallet->totalamount = $remain_amout;
        $update_wallet->timemodified = time();
        $wallet = $DB->update_record('user_wallet', $update_wallet);
    } else {
        $insert_wallet = new stdClass();
        $insert_wallet->userid = $USER->id;
        $insert_wallet->totalamount = $data->TXNAMOUNT;
        $insert_wallet->timecreated = time();
        
        $wallet = $DB->insert_record('user_wallet', $insert_wallet);
    }
}