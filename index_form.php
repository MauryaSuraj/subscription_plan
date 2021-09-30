<?php

require_once("$CFG->libdir/formslib.php");

class add_product_form extends moodleform {

    public function definition() {

        global $CFG, $DB, $COURSE, $OUTPUT, $USER;

        $mform = $this->_form;
    
        $id = $this->_customdata['id'];
       
        $diy = $DB->get_records_sql('Select * from {local_tested}');
        $diyarray = array();
        
        foreach($diy as $diydata){
            $diyarray[$diydata->id] = $diydata->title;
        }
        
       // $DB->get_records('local_tested', , $sort='', $fields='*', $limitfrom=0, $limitnum=0);
        $mform->addElement('html', '<div class="custom-apply-form p-25 mt-20">');
        $mform->addElement('html', '<div class="overlay-bg-internpost"></div>');

        $mform->addElement('text', 'product_name', get_string('product_name', 'local_paytm'), ['size' => '100']);
        // $mform->addRule('product_name', get_string('product_name_r', 'product_name'), 'required', null, 'client');
        $mform->addRule('product_name', 'required', 'required', null, 'client');

        $mform->setType('product_name', PARAM_RAW);
        

        $productSel = ['1' => 'DIY', '2' => 'Course'];
        $select = $mform->addElement('select', 'producttype', get_string('producttype', 'local_paytm'), $productSel);
//        //$select->setMultiple(true);
//        $select->setSelected(2);
        
    
        $select = $mform->addElement('select', 'product', get_string('product', 'local_paytm'), $diyarray);
//        $select->setMultiple(true);
        $select->setSelected(2);
        

        $mform->addElement('text', 'component', get_string('component', 'local_paytm'), ['size' => '100']);
        $mform->setType('component', PARAM_RAW);

        $mform->addElement('text', 'area', get_string('area', 'local_paytm'), ['size' => '100']);
        $mform->setType('area', PARAM_RAW);

        $mform->addElement('text', 'price', get_string('price', 'local_paytm'), ['size' => '100']);
        $mform->setType('price', PARAM_RAW);
        $mform->addRule('price', 'required', 'required', null, 'client');

        // $mform->addElement('date_time_selector', 'validity', get_string('validity', 'local_paytm'), ['size' => '100']);
        // $mform->setType('validity', PARAM_RAW);

        $mform->addElement('duration', 'validity', get_string('validity', 'local_paytm'));
        $mform->setDefault('validity', 240);
        // $mform->addRule('validity', get_string('validity', 'local_paytm'), 'required', null, 'client');
        $mform->addHelpButton('validity', 'validity', 'local_paytm');

        $mform->addElement('filemanager', 'product_image', get_string('product_image', 'local_paytm'), null, array('subdirs' => false, 'maxbytes' => '10000000', 'accepted_types' => '*', 'maxfiles' => 1));
        // $mform->addRule('product_image', 'required', 'required', null, 'client');
        // $mform->addHelpButton('product_image', 'product_image', 'local_paytm');

        $mform->addElement('editor', 'product_description', get_string('product_description', 'local_paytm'));
        // $mform->addRule('intvenue', get_string('jint_venue', 'local_paytm'), 'required', null, 'client', false, false);  
        $mform->setType('product_description', PARAM_RAW);
        $mform->setDefault('product_description', '');

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
       
        return $errors;
      
    }
}
