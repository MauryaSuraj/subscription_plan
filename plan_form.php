<?php

require_once("$CFG->libdir/formslib.php");

class local_plan_form extends moodleform {

    public function definition() {

        global $CFG, $DB, $COURSE, $OUTPUT, $USER;

        $mform = $this->_form;
        $id = isset($this->_customdata['id']) ? $this->_customdata['id'] : null;
       
        $mform->addElement('html', '<div class="custom-apply-form p-25 mt-20">');
        $mform->addElement('html', '<div class="overlay-bg-internpost"></div>');
       //id	plantype	grade			priceperhours	discount	totalprice	subjectid
        $studentlevel = ['beginners' => 'Beginners', 'intermediate' => 'Intermediate', 'advance' => 'Advance','exclusive'=>'Exclusive'];
        //$paymenttype = ['single' => 'Singlecourse', 'combocourse' => 'Combo course'];
        $select = $mform->addElement('select', 'studentlevel', get_string('studentlevel', 'local_subscription_plan'), $studentlevel);
        $select->setSelected(1);
        
         $grade = ['elementory' => 'Elementory', 'upper' => 'Middle/High Students'];
        //$paymenttype = ['single' => 'Singlecourse', 'combocourse' => 'Combo course'];
        $select = $mform->addElement('select', 'grade', get_string('grade', 'local_subscription_plan'), $grade);
        $select->setSelected(1);
        
        
        $plantype = ['single' => 'Single course', 'combocourse' => 'Combo course'];
        $select = $mform->addElement('select', 'plantype', get_string('plantype', 'local_subscription_plan'), $plantype);
        $select->setSelected(1);
        
        $noofsubuject = ['1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5'];
        $select = $mform->addElement('select', 'noofsubuject', get_string('noofsubuject', 'local_subscription_plan'), $noofsubuject);
        $select->setSelected(1);
        
        $mform->addElement('text', 'priceperhours', get_string('priceperhours', 'local_subscription_plan'), ['size' => '100']);
        $mform->addRule('priceperhours', 'required', 'required', null, 'client');
        $mform->setType('priceperhours', PARAM_RAW);
        
//        $mform->addElement('text', 'price', get_string('price', 'local_subscription_plan'), ['size' => '100']);
//        $mform->addRule('price', 'required', 'required', null, 'client');
        
        $mform->addElement('text', 'discount', get_string('discount', 'local_subscription_plan'), ['size' => '100']);
        $mform->addRule('discount', 'required', 'required', null, 'client');
        $mform->setType('discount', PARAM_RAW);
        
        $sql = 'SELECT * from {course} where id <> 1 and visible = 1';
        $courses = $DB->get_records_sql($sql);
        $carray = array();
        foreach($courses as $course){
            $carray[$course->id] = $course->fullname;
        }
        $select = $mform->addElement('select', 'course', get_string('course', 'local_subscription_plan'), $carray);
        $select->setSelected(1);
       // $select->setMultiple(true);
       
         $mform->addElement('editor', 'description', get_string('description', 'local_subscription_plan'));
        // $mform->addRule('intvenue', get_string('jint_venue', 'local_paytm'), 'required', null, 'client', false, false);  
        $mform->setType('description', PARAM_RAW);
        $mform->setDefault('description', '');

        $mform->addElement('hidden', 'id', $id);
        $mform->setType('id', PARAM_INT);
        
        // Submit Button
        $buttonarray = array();
        $buttonarray[] = &$mform->createElement('submit', 'submitbutton1', get_string('submit'));
        $mform->addGroup($buttonarray, 'buttonar', '', '', false);
        $mform->closeHeaderBefore('buttonar');

        $mform->addElement('html', '</div>');
    }

    function validation($data, $files) {
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
