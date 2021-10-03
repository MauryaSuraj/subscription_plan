<?php
/**
 * Class deals with Subscription plans.
 */
namespace local_subscription_plan\util;

defined('MOODLE_INTERNAL') || die();

use html_writer;
use stdClass;
use html_table;

class SusbcriptionsPlans extends SubsHelper
{
	
	protected $db;
	protected $user;
	private $table_sp_name = 'subscriptions_plan_name';

	function __construct() {
		global $DB, $USER;
		$this->db = $DB;
		$this->user = $USER;
	}

	public function add_subscription_plan_name($name) : int {
		
		if (is_null($name)) {
			return 0;
		}

		$dataObject              = new stdClass;
		$dataObject->plan_name   = $name;
		$dataObject->created_by	 = $this->user->id;
		$dataObject->createdtime = time();	

		return $this->db->insert_record($this->table_sp_name, $dataObject);
	}

	private function get_subscription_plan_names(){
		if ($this->db->record_exists($this->table_sp_name, array())) {
			return $this->db->get_records($this->table_sp_name);
		}
		return false;
	}

	public function subscription_plan_names_select_list() {
		if ($names = $this->get_subscription_plan_names()) {
			$ids   = array_map( fn ($value) => $value->id , $names);
			$name  = array_map( fn ($value) => $value->plan_name, $names );			
			return array_combine($ids, $name);
		}
		return array();
	}

	public function get_single_subscription_plan_name($id = null) : object {
		if (is_null($id)) {
			return false;
		}

		if ($this->db->record_exists($this->table_sp_name, array('id' => $id ))) {
			return $this->db->get_record($this->table_sp_name, array('id' => $id ));
		}

		return false;
	}

	public function update_subscription_plan_name($name, $id) : int {

		if (is_null($name)) {
			return 0;
		}

		if (is_null($id)) {
			return 0;
		}

		$dataObject              = new stdClass;
		$dataObject->id 		 = $id; 
		$dataObject->plan_name   = $name;

		return $this->db->update_record($this->table_sp_name, $dataObject);
	}

	public function plan_name_table_data($datas = array()){

		$datas = $this->get_subscription_plan_names();

		$table = new html_table(array('class' => 'table-responsive' ));
		
		$table->head = [
			get_string('plan_name', 'local_subscription_plan'), 
			get_string('created_at', 'local_subscription_plan'),
			get_string('manage_setting', 'local_subscription_plan')
		];
		    
	    foreach ($datas as $key => $value) {

	    	$v 				= new stdClass;
	    	$v->name 		= $value->plan_name;
	    	$v->createdate  = parent::get_date($value->createdtime);
	    	$v->manageurl 	= parent::manage_url($value->id);  
	    	$table->data[] 	=  (array)$v;
	    }

		return html_writer::table($table);
	}

	public function delete_plan_name($id = null) {
		if (is_null($id)) {
			return false;
		}
		return $this->db->delete_records($this->table_sp_name, array('id' => $id ));
	}

}