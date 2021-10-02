<?php

require(dirname(dirname(dirname(__FILE__))) . '/config.php');
require_once dirname(__FILE__).'/classes/forms/SubscriptionPlans_form.php';

global $PAGE;

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

$subscriptionplans_form = new SubscriptionPlans_form;
$subscription_plan      = new SusbcriptionsPlans;

if ($subscriptionplans_form->is_cancelled()) {

    $manageurl = new moodle_url('/local/subscription_plan/plan.php');
    redirect($manageurl);

} else if ($fromspf = $subscriptionplans_form->get_data()) {
    
    if (isset($fromspf->plan_name) && $fromspf->plan_name != "" && isset($fromspf->id) && $fromspf->id !="" ) {
        
        if ($subscription_plan->update_subscription_plan_name($fromspf->plan_name, $fromspf->id)) {
            
            $manageurl = new moodle_url('/local/subscription_plan/plan.php');

            redirect($manageurl, get_string('plan_name_updated', 'local_subscription_plan') , 0, \core\output\notification::NOTIFY_SUCCESS);
    
        }

    }elseif (isset($fromspf->plan_name)) {
        if ($subscription_plan->add_subscription_plan_name($fromspf->plan_name)) {
            $manageurl = new moodle_url('/local/subscription_plan/plan.php');
           redirect($manageurl, get_string('plan_name_added', 'local_subscription_plan') , 0, \core\output\notification::NOTIFY_SUCCESS);
        }
    }    
    
} else {  

   if (isset($_GET['id']) && $_GET['id'] != "") {
        $formdata = $subscription_plan->get_single_subscription_plan_name($_GET['id']);
        $subscriptionplans_form->set_data($formdata);  
    } 
    
   $subscriptionplans_form->display();
}

if (isset($_GET['deleteid']) && $_GET['deleteid'] != "" ) {
    $subscription_plan->delete_plan_name($_GET['deleteid']);
    redirect(new moodle_url('/local/subscription_plan/plan.php'));
}

// echo $subscription_plan->plan_name_table_data();

echo $OUTPUT->footer();