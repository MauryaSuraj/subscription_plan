<?php
require_once dirname( dirname( dirname(dirname(dirname(__FILE__)))) ) . '/config.php';
global $CFG;
require_once("$CFG->libdir/formslib.php");

/**
 * Moodle form to add subscription data.
 */

class SubscriptionPlan_form extends moodleform {

    public function definition() {
		global $CFG, $DB, $COURSE, $OUTPUT, $USER;

        $mform = $this->_form;
        $id = isset($this->_customdata['id']) ? $this->_customdata['id'] : null;

        $mform->addElement('text', 'plan_name', get_string('plan_name_field', 'local_subscription_plan')); 
        $mform->setType('plan_name', PARAM_NOTAGS);                   
       	$mform->addHelpButton('plan_name', 'plan_name', 'local_subscription_plan');
       	$mform->addRule('plan_name', get_string('plan_name_validate', 'local_subscription_plan'), 'required', null, 'client');

        $sp_submit = array();
		$sp_submit[] =& $mform->createElement('submit', 'submitbutton', get_string('add_plan_name', 'local_subscription_plan'));
		$sp_submit[] =& $mform->createElement('submit', 'cancel', get_string('cancel'));
		$mform->addGroup($sp_submit, 'buttonar', '', array(' '), false);        
    
	}

    public  function validation($data, $files) {
        global $DB;
        $errors = parent::validation($data, $files);
       
        if (empty($data['plan_name'])) {
            $errors['plan_name'] = get_string('plan_name_validate', 'local_subscription_plan');
        }

        return $errors;
    }
}