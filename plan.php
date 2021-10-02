<?php

require(dirname(dirname(dirname(__FILE__))) . '/config.php');
require_once dirname(__FILE__).'/classes/forms/SubscriptionPlan_form.php';

require_once ('lib.php');
require_once('plan_form.php');

global $PAGE, $DB, $USER;

$id = optional_param('id', null, PARAM_INT);

require_login();

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

    $manageurl = new moodle_url('/local/subscription_plan/plan.php');
    redirect($manageurl);

} else if ($fromspf = $subscription_plan_form->get_data()) {
    
    if (isset($fromspf->plan_name)) {
        if ($subscription_plan->add_subscription_plan_name($fromspf->plan_name)) {
            $manageurl = new moodle_url('/local/subscription_plan/plan.php');
           redirect($manageurl, get_string('plan_name_added', 'local_subscription_plan') , 0, \core\output\notification::NOTIFY_SUCCESS);
        }
    }    
    
} else {  

   if (isset($_GET['id']) && $_GET['id'] != "") {
        $formdata = $subscription_plan->get_single_subscription_plan_name($_GET['id']);
        $subscription_plan_form->set_data($formdata);  
    } 
    
  $subscription_plan_form->display();
}

echo $subscription_plan->plan_name_table_data();

echo $OUTPUT->footer();