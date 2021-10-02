<?php
/**
 * Class deals with Subscription plans.
 */

namespace local_subscription_plan\util;

defined('MOODLE_INTERNAL') || die();

class SusbcriptionsPlans
{
	
	private $db;
	private $user;
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

		$dataObject              = new \stdClass;
		$dataObject->plan_name   = $name;
		$dataObject->created_by	 = $this->user->id;
		$dataObject->createdtime = time();	

		return $this->db->insert_record($this->table_sp_name, $dataObject);
	}

	public function get_subscription_plan_name(){
		return "HELLO";
	}

	public function update_subscription_plan_name(){

	}
	

}