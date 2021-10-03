<?php
/*
 * create a payment link
 * send auto that link to related mobile number and email id
 * payment amount id optional
 *  */

require(dirname(dirname(dirname(__FILE__))) . '/config.php');
require_once ('lib.php');
global $PAGE, $DB, $USER;

$diyid = optional_param('diyid', null, PARAM_INT);

/// Start making page
if(!isloggedin() && !isguestuser()){
    redirect($CFG->wwwroot.'/signin/');
}

$context = context_system::instance();
$PAGE->set_context(context_system::instance());
$PAGE->set_pagelayout('admin');
$PAGE->set_url('/local/paytm/checkout.php');



$addnewpromo = get_string('add_amount', 'local_paytm');
$navlist = get_string('addamount', 'local_paytm');
//$navlisturl = new moodle_url('/local/subscription/product_list.php');
$nav = get_string('add_amount', 'local_paytm');
$nameErr = '';

$PAGE->navbar->add($navlist, $navlisturl);
$PAGE->navbar->add($nav);
$PAGE->set_title($addnewpromo);
$PAGE->set_heading($addnewpromo);

//$PAGE->requires->js_call_amd('local_subscription/select2', 'init');
$PAGE->requires->js_call_amd('local_paytm/payment', 'init');
$linkid = random_int(7, 10);
echo $OUTPUT->header();
$userid = $USER->id;
if(!empty($diyid)){
$product = get_product($diyid);
$orederid = create_order($product->id, $amount=$product->price, $diyname=$product->productname);
}

$userinfo = $DB->get_record('learner_details',array('user'=>$userid));
  
$hash = array(
    'userid'=>$userid,   
    'email'=>$userinfo->parentemail,
    'phone'=>$userinfo->parentmobile
);

echo $OUTPUT->render_from_template('local_paytm/checkout', $hash);
echo $OUTPUT->footer();
