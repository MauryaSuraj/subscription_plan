<?php

/**
 * Subscription Helper class.
 */

namespace local_subscription_plan\util;

use html_writer;
use moodle_url;

abstract class SubsHelper
{
	protected static function get_date($timestamp = null) {
		return date('m/d/Y', $timestamp);
	}

	protected static function manage_url($id = null, $html = ''){

		$actionurl_edit = new moodle_url("", array('id' => $id ));
		$actionurl_delete = new moodle_url("", array('deleteid' => $id ));

		$html .= html_writer::link($actionurl_edit, get_string('edit', 'local_subscription_plan') , array('class' => 'actionlink'));
		$html .= '&nbsp;&nbsp;';
		$html .= html_writer::link($actionurl_delete, get_string('delete', 'local_subscription_plan') , array('class' => 'actionlink', 'onlick' => 'return confirm("Are you sure?")' ));

		return $html;
	}

	public static function all_courses() : array {
		global $DB;
        $courses = $DB->get_records_sql('SELECT * from {course} where id <> 1 and visible = 1');
        $carray = array();
        foreach($courses as $course){
            $carray[$course->id] = $course->fullname;
        }
        return $carray;
	}

}