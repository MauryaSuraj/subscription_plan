<?php

require(dirname(dirname(dirname(__FILE__))) . '/config.php');
require_once dirname(__FILE__).'/classes/forms/SubscriptionPlan_form.php';

require_once ('lib.php');
require_once('plan_form.php');

global $PAGE, $DB, $USER;

$id = optional_param('id', null, PARAM_INT);

require_login();

error_reporting(E_ALL);
ini_set('display_errors', '1');

$context = context_system::instance();
$PAGE->set_context(context_system::instance());
$PAGE->set_pagelayout('admin');
$PAGE->set_url('/local/subscription_plan/plan.php', ['id' => $id]);
$PAGE->set_title(get_string('payment', 'local_subscription_plan'));
$PAGE->set_heading('Subscriptions Plan');

echo $OUTPUT->header();

use local_subscription_plan\util\SusbcriptionsPlans;

$subscription_plan_form = new SubscriptionPlan_form;
$subscription_plan      = new SusbcriptionsPlans;

if ($subscription_plan_form->is_cancelled()) {

} else if ($fromspf = $subscription_plan_form->get_data()) {
    
    if (isset($fromspf->plan_name)) {
        if ($subscription_plan->add_subscription_plan_name($fromspf->plan_name)) {
            \core\flash::success(get_string('plan_name_added', 'local_subscription_plan'));
        }
    }    
    
} else {
  
  $subscription_plan_form->display();
}

// print_r($subscription_plan->get_subscription_plan_name());

if (!empty($data)) {

    $setdata = new stdClass();
    $setdata->id = $data->id;
    $mform->set_data($setdata);
}

// if ($mform->is_cancelled()) {

//     redirect(new moodle_url('/local/subscription_plan/plan.php'));

// } else if ($data = $mform->get_data(false)) {
   
//     $formdata = new stdClass();

//     $formdata->plantype = $data->plantype;
//     $formdata->grade = $data->grade;
//     $formdata->studentlevel = $data->studentlevel;
//     $formdata->noofsubuject = $data->noofsubuject;
//     $formdata->priceperhours = $data->priceperhours;
//     $formdata->discount = $data->discount;
//     $formdata->totalprice = $data->price * $data->priceperhours;
//     $formdata->subjectid = $data->course;
//     $formdata->descriptions = $data->description['text'];
//     $formdata->cretedby = $USER->id;
//     $formdata->createdtime = time();
    
//     if (!empty($data->id)) {
//         $sub_data = $DB->get_records('subscriptions_plan', array('id' => $data->id));
//     }
//     if (count($sub_data) > 0) {
        
//         $formdata->createdby = $USER->id;
//         $formdata->createddate = time();
//         $formdata->modifieddate = time();

//         $DB->update_record('subscriptions_plan', $formdata);

//     } else {
//         $DB->insert_record('subscriptions_plan', $formdata);
//     }

// } else {
//     // $mform->display();
// }

echo $OUTPUT->footer();