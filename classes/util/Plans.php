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
		$dataObject->plan_type	 	= $formdata->plantype;
		$dataObject->plan_name_id 	= $formdata->plan_name;
		$dataObject->student_level 	= $formdata->studentlevel;
		$dataObject->no_of_subject 	= $formdata->noofsubject;
		$dataObject->class_hours 	= $formdata->class_hours;
		$dataObject->discount 		= $formdata->discount;
		$dataObject->total_price 	= $formdata->actural_price;
		$dataObject->course_id 		= $formdata->course;
		$dataObject->descriptions 	= $formdata->description['text'];  
		$dataObject->priceperhours	= $formdata->priceperhours;
		$dataObject->noofclasses 	= $formdata->noofclasses;
		$dataObject->created_by	 	= $this->user->id;
		$dataObject->createdtime 	= time();	

		return $this->db->insert_record($this->table_sp, $dataObject);
	}

	private function get_subscription_plans(){
		if ($this->db->record_exists($this->table_sp, array())) {
			$plans = $this->db->get_records($this->table_sp);
			foreach ($plans  as $key => $plan) {

				$plan->plan_type 		= get_string($plan->plan_type, 'local_subscription_plan');
				
				$plan->student_level 	=  get_string($plan->student_level, 'local_subscription_plan');
				
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
		$dataObject->plan_type	 	= $formdata->plantype;
		$dataObject->plan_name_id 	= $formdata->plan_name;
		$dataObject->student_level 	= $formdata->studentlevel;
		$dataObject->no_of_subject 	= $formdata->noofsubject;
		$dataObject->class_hours 	= $formdata->class_hours;
		$dataObject->discount 		= $formdata->discount;
		$dataObject->total_price 	= $formdata->actural_price;
		$dataObject->course_id 		= $formdata->course;
		$dataObject->descriptions 	= $formdata->description['text'];  
		$dataObject->priceperhours	= $formdata->priceperhours;
		$dataObject->noofclasses 	= $formdata->noofclasses;
		$dataObject->created_by	 	= $this->user->id;
		$dataObject->createdtime 	= time();	

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
		    
	    foreach ($datas as $key => $value) {
	    	unset($value->plan_name_id);  
	    	unset($value->course_id);
	    	unset($value->created_by);
	 		unset($value->descriptions);
	    	$table->data[] 	=  (array)$value;
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