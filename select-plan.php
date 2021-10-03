<?php
require(dirname(dirname(dirname(__FILE__))) . '/config.php');
require_once 'lib.php';

global $PAGE;

$id = optional_param('id', null, PARAM_INT);

require_login();

$context = context_system::instance();
$PAGE->set_context(context_system::instance());
$PAGE->set_pagelayout('admin');
$PAGE->set_url('/local/subscription_plan/select-plan.php');
$PAGE->set_title(get_string('payment', 'local_subscription_plan'));
$PAGE->set_heading('Subscriptions Plan');
$PAGE->requires->css(new moodle_url($CFG->wwwroot . '/local/subscription_plan/css/style.css'));

echo $OUTPUT->header();
echo SusbcriptionsPlansViews::select_plans();
echo $OUTPUT->footer();