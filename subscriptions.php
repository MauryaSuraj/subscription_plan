<?php

require(dirname(dirname(dirname(__FILE__))) . '/config.php');
require_once ('lib.php');
//require_once('index_form.php');

global $PAGE, $DB, $USER;

$id = optional_param('id', null, PARAM_INT);

$context = context_system::instance();
$PAGE->set_context(context_system::instance());
$PAGE->set_pagelayout('admin');

$addnewpromo = 'Subscription Plan';
$PAGE->requires->css(new moodle_url($CFG->wwwroot . '/local/subscription_plan/css/style.css'));
$PAGE->requires->js(new moodle_url($CFG->wwwroot . '/local/subscription_plan/js/script.js'));
$nameErr = '';
$PAGE->set_title($addnewpromo);
$PAGE->set_heading($addnewpromo);

// $PAGE->requires->js_call_amd('local_subscription/select2', 'init');

echo $OUTPUT->header();

$hash = [
	'book_demo_image' => new moodle_url($CFG->wwwroot . '/local/subscription_plan/pix/book-demo-class.jpg'),
	'dates' =>'',
	'js_date_default' => '',
	'slot' => 'subscription_plan',
];

echo $OUTPUT->render_from_template('local_subscription_plan/subscriptions', $hash);
echo $OUTPUT->footer();
