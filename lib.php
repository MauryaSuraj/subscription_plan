<?php

function get_recent_courses_images(): string {
    global $CFG, $DB;
    require_once($CFG->dirroot . '/local/paradiso_coursewizard/classes/recent_files.php');
    $html = '';
    $html .= html_writer::start_tag('div', array('class' => 'content-img pt-4'));
    $html .= html_writer::start_tag('div', array('class' => 'row'));
    $html .= html_writer::start_tag('div', array('class' => 'col-sm-12 col-md-12 col-lg-4'));
    $html .= html_writer::start_tag('label');
    $html .= get_string('select_image', 'local_paradiso_coursewizard');
    $html .= html_writer::end_tag('label');
    $html .= html_writer::end_tag('div');
    $html .= html_writer::start_div('col-sm-12 col-md-12 col-lg-7 col-xl-7 coursewizard-list-images');
    $html .= html_writer::start_div('row');
    if ($repo = $DB->get_record('repository', ['type' => 'recent'])) {
        $files = new repository_recent_cw($repo->type);
        $recent_files = $files->print_login();
        // No empty
        if (count($recent_files['list']) > 0) {
            foreach ($recent_files['list'] as $data) {
                if (array_key_exists('realicon', $data)) {
                    //is image
                    $url = preg_replace('/\?.*/', '', $data['realicon']);

                    $html .= html_writer::start_div('col-sm-6 col-md-4 col-lg-4 col-xl-4 d-sm-flex content-card');

                    $html .= html_writer::start_div('card card-img-wizard mr-1 ml-1');
                    //$html .=html_writer::start_tag('div', array('class' => 'card-header card-header-image'));
                    $html .= html_writer::start_tag('a', array('href' => '#', 'onclick' => 'return false', 'class' => 'img-courseswizard d-inline-block'));
                    $html .= html_writer::tag('img', '', ['src' => $url, 'alt' => '', 'class' => 'card-img wizard-img img-fluid',
                                'data-contextid' => $data['finfo']['contextid'],
                                'data-itemid' => $data['finfo']['itemid'],
                                'data-filearea' => $data['finfo']['filearea'],
                                'data-component' => $data['finfo']['component'],
                                'data-filepath' => $data['finfo']['filepath'],
                                'data-filename' => $data['finfo']['filename'],
                    ]);
                    $html .= html_writer::end_tag('a');
                    //$html .= html_writer::end_tag('div');
                    $html .= html_writer::end_div();
                    $html .= html_writer::end_div();
                }
            }
        }
    }
    $html .= html_writer::end_div();
    $html .= html_writer::end_tag('div');
    $html .= html_writer::end_tag('div');
    return $html;
}

function create_order($pid, $price, $pname) {
    global $PAGE, $DB, $USER;

    $insert = new stdClass();

    $insert->productid = $pid;
    $insert->amount = $price;
    $insert->subscriptionid = '0';
    $insert->subscriptiontype = $pname;
    $insert->timecreated = time();
    $insert->timemodified = time();
    $insert->createdby = $USER->id;
    $insetedid = $DB->insert_record('order_details', $insert);
    return $insetedid;
}

function update_order($orderid, $link_ref_id) {
    global $PAGE, $DB, $USER;
    if (!empty($orderid)) {
        $param = array('id' => $orderid);
        $status = 0;
    } else {
        $param = array('linkreferenceid' => $link_ref_id);
        $status = 1;
    }

    $orderdata = $DB->get_record('order_details', $param);
    $update = new stdClass();
    $update->id = $orderdata->id;
    $update->linkreferenceid = $link_ref_id;
    $update->status = $status;
    $uid = $DB->update_record('order_details', $update);
    
    $ins_subscriptions = new stdClass();
    $ins_subscriptions->userid = $orderdata->createdby;
    $ins_subscriptions->productid = $orderdata->productid;
    $ins_subscriptions->orderid = $orderdata->id;
    
    $DB->insert_record('subscriptions', $ins_subscriptions);
    
    return $uid;
}

function get_total_paid_amount($userid) {
    global $PAGE, $DB, $USER;
    $userid = $USER->id;
    $totalcoins = $DB->get_records_sql('select * from {paytm_link_info} where userid = ' . $USER->id);
   // print_object($totalcoins);
    $total = '';

    if (!empty($totalcoins)) {
        foreach ($totalcoins as $tdata) {
           $total = $total + $tdata->amount;
        }
    } else {
        $total = 0;
    }
 
    //array_sum((array)$totalcoins);die;
    return $total;
}
function get_wallet($userid) {
    global $PAGE, $DB, $USER;
    $userid = $USER->id;
    $totalcoins = $DB->get_record('user_wallet', ['userid'=>$userid]);
   // print_object($totalcoins);
  

    if (!empty($totalcoins)) {
       $total = $totalcoins->totalamount;
    } else {
        $total = 0;
    }
 
    //array_sum((array)$totalcoins);die;
    return $total;
}


function get_paytm_config() {
    global $PAGE, $DB, $USER;
    $paytmconf = $DB->get_record_sql('select * from {paytm_config} where 1');
    return $paytmconf;
}

function get_product($itemid){
    global $PAGE, $DB, $USER;
    $productdetails = $DB->get_record_sql('select * from {product} where itemid='. $itemid);
    //print_object($productdetails);
    if(!empty($productdetails)){
       return $productdetails;
    }else{
        return false;
    }
   
}

/**
 * Handle the Views here
 */

use local_subscription_plan\util\Plans;

final class SusbcriptionsPlansViews extends Plans
{
    public static function select_plans() {
        global $OUTPUT;
        $data = new \stdClass;
        return $OUTPUT->render_from_template('local_subscription_plan/select-plan', $data);
    }

    public static function plans () {
        global $OUTPUT;
        $data = new stdClass;
        return $OUTPUT->render_from_template('local_subscription_plan/plans', $data);
    }

    public static function checkout(){
        global $OUTPUT;
        $data = new stdClass;
        return $OUTPUT->render_from_template('local_subscription_plan/sub-checkout', $data);
    }

}