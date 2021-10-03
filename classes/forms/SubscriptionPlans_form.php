<?php

/**
 * Form To add all files 
 * */

require_once("$CFG->libdir/formslib.php");

use local_subscription_plan\util\SusbcriptionsPlans;

class SubscriptionPlans_form extends moodleform {

    public function definition() {

        global $CFG, $DB, $COURSE, $OUTPUT, $USER;

        $mform = $this->_form;
        $id = isset($this->_customdata['id']) ? $this->_customdata['id'] : null;
       
        $sb = new SusbcriptionsPlans;
        $paln_names = $sb->subscription_plan_names_select_list();

        $mform->addElement('html', '<div class="custom-apply-form p-25 mt-20">');
        $mform->addElement('html', '<div class="overlay-bg-internpost"> </div>');
    

        $select = $mform->addElement('select', 'plan_name', 
                                    get_string('plan_name', 'local_subscription_plan'), 
                                    $paln_names);
        $select->setSelected(1);

        $studentlevel = [
            'beginners'     => get_string('beginners', 'local_subscription_plan'), 
            'intermediate'  => get_string('intermediate', 'local_subscription_plan'), 
            'advance'       => get_string('advance', 'local_subscription_plan'),
            'exclusive'     => get_string('exclusive', 'local_subscription_plan')
        ];

        $select = $mform->addElement('select', 'studentlevel', get_string('studentlevel', 'local_subscription_plan'), $studentlevel);
        $select->setSelected(1);
        
        $grade = [
            'elementory'    => get_string('elementory', 'local_subscription_plan'), 
            'upper'         => get_string('upper', 'local_subscription_plan')
        ];
        
        $plantype = [
            'single'        => get_string('single', 'local_subscription_plan'), 
            'combocourse'   => get_string('combocourse', 'local_subscription_plan')
        ];
        
        $select = $mform->addElement('select', 'plantype', get_string('plantype', 'local_subscription_plan'), $plantype);
        $select->setSelected(1);
        
        $noofsubject = [ '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5' ];
        
        $select = $mform->addElement('select', 'noofsubject', get_string('noofsubject', 'local_subscription_plan'), $noofsubject);
        $select->setSelected(1);
        
        $mform->addElement('text', 'priceperhours', get_string('priceperhours', 'local_subscription_plan'), ['size' => '100']);
        $mform->addRule('priceperhours', 'required', 'required', null, 'client');
        $mform->setType('priceperhours', PARAM_RAW);
        
        
        $mform->addElement('text', 'discount', get_string('discount', 'local_subscription_plan'), ['size' => '100']);
        $mform->addRule('discount', 'required', 'required', null, 'client');
        $mform->setType('discount', PARAM_INT);

        $mform->addElement('text', 'noofclasses', get_string('noofclasses', 'local_subscription_plan'), ['size' => '100']);
        $mform->addRule('noofclasses', 'required', 'required', null, 'client');
        $mform->setType('noofclasses', PARAM_INT);

        $mform->addElement('text', 'actural_price', get_string('actural_price', 'local_subscription_plan'), ['size' => '100']);
        $mform->addRule('actural_price', 'required', 'required', null, 'client');
        $mform->setType('actural_price', PARAM_INT);

        $mform->addElement('text', 'class_hours', get_string('class_hours', 'local_subscription_plan'), ['size' => '100']);
        $mform->addRule('class_hours', 'required', 'required', null, 'client');
        $mform->setType('class_hours', PARAM_INT);

        
        $carray = SusbcriptionsPlans::all_courses();
        
        $select = $mform->addElement('select', 'course', get_string('course', 'local_subscription_plan'), $carray);
        $select->setSelected(1);
       
        $mform->addElement('editor', 'description', get_string('description', 'local_subscription_plan'));
        $mform->setType('description', PARAM_RAW);
        $mform->setDefault('description', '');

        $mform->addElement('hidden', 'id', $id);
        $mform->setType('id', PARAM_INT);
        
        $buttonarray = array();
        $buttonarray[] = &$mform->createElement('submit', 'submitbutton1', get_string('submit'));
        $mform->addGroup($buttonarray, 'buttonar', '', '', false);
        $mform->closeHeaderBefore('buttonar');

        $mform->addElement('html', '</div>');
    
    }

    public function validation($data, $files) {
        
        global $DB;
        $errors = parent::validation($data, $files);
       
        if (!empty($data['maxpaymentsallowed'])) {
            if ($data['maxpaymentsallowed'] <= 0) {
                $errors['maxpaymentsallowed'] = "Enter some amount for max payment";
            } else if (!is_number($data['maxpaymentsallowed'])) {
                $errors['maxpaymentsallowed'] = "Only number value allowed";
            }
        }

        if (!empty($data['minpaymentsallowed'])) {
            if ($data['minpaymentsallowed'] <= 0) {
                $errors['minpaymentsallowed'] = "Enter minimum value.";
            } else if (!is_number($data['minpaymentsallowed'])) {
                $errors['minpaymentsallowed'] = "Only number value allowed";
            }
        }
        return $errors;
    }

}
