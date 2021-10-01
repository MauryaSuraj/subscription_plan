<?php

require(dirname(dirname(dirname(__FILE__))) . '/config.php');
require_once ('lib.php');
require_once('plan_form.php');

global $PAGE, $DB, $USER;

$id = optional_param('id', null, PARAM_INT);

/// Start making page
require_login();
$context = context_system::instance();
$PAGE->set_context(context_system::instance());
$PAGE->set_pagelayout('admin');
$PAGE->set_url('/local/subscription_plan/plan.php', ['id' => $id]);

$addnewpromo = get_string('payment', 'local_subscription_plan');
//$navlist = get_string('product_list', 'local_paytm');
//$navlisturl = new moodle_url('/local/subscription/product_list.php');
$nav = get_string('plan', 'local_subscription_plan');
$nameErr = '';

//$PAGE->navbar->add($navlist, $navlisturl);
//$PAGE->navbar->add($nav);
$PAGE->set_title($addnewpromo);
$PAGE->set_heading('Subscriptions Plan');

// $PAGE->requires->js_call_amd('local_subscription/select2', 'init');

echo $OUTPUT->header();
//
//$data = $DB->get_record('subscription_plan',array('id'=>1));
if(!empty($id)){
$mform = new local_plan_form($CFG->wwwroot . '/local/subscription_plan/plan.php', ['id' => $id]);
}else{
   $mform = new local_plan_form(); 
}
// --------------------------------------------- End Form Set data ----------------------------------

if (!empty($data)) {
    // set data into form
    $setdata = new stdClass();
    $setdata->id = $data->id;
    //id	plantype	grade	noofsubuject	studentlevel	priceperhours	discount	totalprice	subjectid	createdtime	descriptions	timemodified	createdby

    $mform->set_data($setdata);
}

// --------------------------------------------- End Form Set data ----------------------------------
if ($mform->is_cancelled()) {
    redirect(new moodle_url('/local/subscription_plan/plan.php'));
} else if ($data = $mform->get_data(false)) {
   
    //    [id] => 2
    $formdata = new stdClass();
    //$formdata->id = $data->id;
    $formdata->plantype = $data->plantype;
    $formdata->grade = $data->grade;
    $formdata->studentlevel = $data->studentlevel;
    $formdata->noofsubuject = $data->noofsubuject;
    $formdata->priceperhours = $data->priceperhours;
    $formdata->discount = $data->discount;
    $formdata->totalprice = $data->price * $data->priceperhours;
    $formdata->subjectid = $data->course;
    $formdata->descriptions = $data->description['text'];
    $formdata->cretedby = $USER->id;
    $formdata->createdtime = time();
    
    if (!empty($data->id)) {
        $sub_data = $DB->get_records('subscriptions_plan', array('id' => $data->id));
    }
    if (count($sub_data) > 0) {
        
        $formdata->createdby = $USER->id;
        $formdata->createddate = time();
        $formdata->modifieddate = time();

        $DB->update_record('subscriptions_plan', $formdata);
    } else {
        $DB->insert_record('subscriptions_plan', $formdata);
    }
    // Product  image.
} else {
    $mform->display();
}


echo $OUTPUT->footer();
