<?php
/**
 * Class deals with Subscription plans.
 */
namespace local_subscription_plan\util;

defined('MOODLE_INTERNAL') || die();

use html_writer;
use stdClass;
use html_table;

class Plans extends SusbcriptionsPlans
{
	
	private $table_sp = 'subscriptions_plan';

	public function __construct() {
		parent::__construct();
	}

	public function add_subscription_plans(stdClass $formdata) : int {

		
		$dataObject              	= new stdClass;
		$dataObject->plan_name_id 	= $formdata->plan_name;
		$dataObject->course_id 		= $formdata->course;
		$dataObject->descriptions 	= $formdata->description['text'];  
		$dataObject->created_by	 	= $this->user->id;
		$dataObject->createdtime 	= time();

		$dataObject->subject  		= $formdata->subject;
		$dataObject->no_of_student  = $formdata->no_of_student;

	    $dataObject->studentlevel1 	= $formdata->studentlevel1;
	    $dataObject->noofclasses1 	= $formdata->noofclasses1;
	    $dataObject->priceperhours1 = $formdata->priceperhours1;
	    $dataObject->discount1 		= $formdata->discount1;
	    $dataObject->actural_price1 = $formdata->actural_price1;
	    $dataObject->class_hours1 	= $formdata->class_hours1;

	    $dataObject->studentlevel2 	= $formdata->studentlevel2;
	    $dataObject->noofclasses2 	= $formdata->noofclasses2;
	    $dataObject->priceperhours2 = $formdata->priceperhours2;
	    $dataObject->discount2 		= $formdata->discount2;
	    $dataObject->actural_price2 = $formdata->actural_price2;
	    $dataObject->class_hours2 	= $formdata->class_hours2;
	    
	    $dataObject->studentlevel3 	= $formdata->studentlevel3;
	    $dataObject->noofclasses3 	= $formdata->noofclasses3;
	    $dataObject->priceperhours3 = $formdata->priceperhours3;
	    $dataObject->discount3 		= $formdata->discount3;
	    $dataObject->actural_price3 = $formdata->actural_price3;
	    $dataObject->class_hours3 	= $formdata->class_hours3;
	    
	    $dataObject->studentlevel4 	= $formdata->studentlevel4;
	    $dataObject->noofclasses4 	= $formdata->noofclasses4;
	    $dataObject->priceperhours4 = $formdata->priceperhours4;
	    $dataObject->discount4 		= $formdata->discount4; 
	    $dataObject->actural_price4 = $formdata->actural_price4; 
	    $dataObject->class_hours4 	= $formdata->class_hours4; 

		return $this->db->insert_record($this->table_sp, $dataObject);
	}

	private function get_subscription_plans(){
		if ($this->db->record_exists($this->table_sp, array())) {
			$plans = $this->db->get_records($this->table_sp);
			foreach ($plans  as $key => $plan) {

				// $plan->plan_type 		= get_string($plan->plan_type, 'local_subscription_plan');
				
				// $plan->student_level 	=  get_string($plan->student_level, 'local_subscription_plan');
				
				$plan->plan_name 		= isset($this->get_single_subscription_plan_name($plan->plan_name_id)->plan_name) ? $this->get_single_subscription_plan_name($plan->plan_name_id)->plan_name : '';
				
				$plan->course 			= isset(parent::single_course($plan->course_id)->fullname) ? parent::single_course($plan->course_id)->fullname : '';

				$plan->createdtime  = parent::get_date($plan->createdtime);
	    		$plan->manageurl 	= parent::manage_url($plan->id);
			}
			return $plans;
		}
		return false;
	}

	public function subscription_planss_select_list()  {
		if ($names = $this->get_subscription_plans()) {
			$ids   = array_map( fn ($value) => $value->id , $names);
			$name  = array_map( fn ($value) => $value->plan_name, $names );			
			return array_combine($ids, $name);
		}
		return array();
	}

	public function get_single_subscription_plans($id = null) : object {
		if (is_null($id)) {
			return false;
		}

		if ($this->db->record_exists($this->table_sp, array('id' => $id ))) {
			$dataObject = $this->db->get_record($this->table_sp, array('id' => $id ));
			
			$formdata 					= new stdClass;	
			$formdata->plantype 		= $dataObject->plan_type;
		 	$formdata->plan_name 		= $dataObject->plan_name_id;
		 	$formdata->studentlevel 	= $dataObject->student_level;
		 	$formdata->noofsubject 		= $dataObject->no_of_subject;
		 	$formdata->class_hours 		= $dataObject->class_hours;
		 	$formdata->discount 		= $dataObject->discount;
		 	$formdata->actural_price	= $dataObject->total_price;
		 	$formdata->course 			= $dataObject->course_id;
		 	$formdata->description 		= $dataObject->descriptions; 
			$formdata->priceperhours	= $dataObject->priceperhours;
		 	$formdata->noofclasses 		= $dataObject->noofclasses;

		 	return $formdata;
		}

		return false;
	}

	public function update_subscription_plans(stdClass $formdata, $id) : int {

		if (is_null($id)) {
			return 0;
		}

		$dataObject              	= new stdClass;
		$dataObject->id 		 	= $id; 
		$dataObject->plan_name_id 	= $formdata->plan_name;
		$dataObject->course_id 		= $formdata->course;
		$dataObject->descriptions 	= $formdata->description['text'];  
		$dataObject->created_by	 	= $this->user->id;
		$dataObject->createdtime 	= time();
		$dataObject->subject  		= $formdata->subject;
		$dataObject->no_of_student  = $formdata->no_of_student;
		
	    $dataObject->studentlevel1 	= $formdata->studentlevel1;
	    $dataObject->noofclasses1 	= $formdata->noofclasses1;
	    $dataObject->priceperhours1 = $formdata->priceperhours1;
	    $dataObject->discount1 		= $formdata->discount1;
	    $dataObject->actural_price1 = $formdata->actural_price1;
	    $dataObject->class_hours1 	= $formdata->class_hours1;

	    $dataObject->studentlevel2 	= $formdata->studentlevel2;
	    $dataObject->noofclasses2 	= $formdata->noofclasses2;
	    $dataObject->priceperhours2 = $formdata->priceperhours2;
	    $dataObject->discount2 		= $formdata->discount2;
	    $dataObject->actural_price2 = $formdata->actural_price2;
	    $dataObject->class_hours2 	= $formdata->class_hours2;
	    
	    $dataObject->studentlevel3 	= $formdata->studentlevel3;
	    $dataObject->noofclasses3 	= $formdata->noofclasses3;
	    $dataObject->priceperhours3 = $formdata->priceperhours3;
	    $dataObject->discount3 		= $formdata->discount3;
	    $dataObject->actural_price3 = $formdata->actural_price3;
	    $dataObject->class_hours3 	= $formdata->class_hours3;
	    
	    $dataObject->studentlevel4 	= $formdata->studentlevel4;
	    $dataObject->noofclasses4 	= $formdata->noofclasses4;
	    $dataObject->priceperhours4 = $formdata->priceperhours4;
	    $dataObject->discount4 		= $formdata->discount4; 
	    $dataObject->actural_price4 = $formdata->actural_price4; 
	    $dataObject->class_hours4 	= $formdata->class_hours4; 

		return $this->db->update_record($this->table_sp, $dataObject);
	}

	public function plan_table_data($datas = array()){

		$datas = $this->get_subscription_plans();

		$table = new html_table(array('class' => 'table-responsive' ));
		
		$table->head = [
			'#',
			get_string('plantype', 'local_subscription_plan'),
			get_string('studentlevel', 'local_subscription_plan'),
			get_string('noofsubuject', 'local_subscription_plan'),
			get_string('class_hours', 'local_subscription_plan'),
			get_string('discount', 'local_subscription_plan'),
			get_string('actural_price', 'local_subscription_plan'),
			get_string('priceperhours', 'local_subscription_plan'),
			get_string('noofclasses', 'local_subscription_plan'),
			get_string('created_at', 'local_subscription_plan'),
			get_string('plan_name', 'local_subscription_plan'),
			get_string('course', 'local_subscription_plan'), 
			get_string('manage_setting', 'local_subscription_plan')
		];
		
		if (empty($datas)) {
			$table->data[] = array();
		}else{
		    foreach ($datas as $key => $value) {
		    	unset($value->plan_name_id);  
		    	unset($value->course_id);
		    	unset($value->created_by);
		 		unset($value->descriptions);
		    	$table->data[] 	=  (array)$value;
		    }
		}

		return html_writer::table($table);
	}

	public function delete_plan($id = null) {
		if (is_null($id)) {
			return false;
		}
		return $this->db->delete_records($this->table_sp, array('id' => $id ));
	}

	public function get_select_plans(){

		$plan_names = $this->get_subscription_plan_names();
		
		$datas = new stdClass;
		$datas->hasplanname = !empty($plan_names) ? true : false;
		$datas->plannames 	=  parent::toArray($plan_names);

		return $datas;		
	}

}