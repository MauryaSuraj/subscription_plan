<?php
require(dirname(dirname(dirname(__FILE__))) . '/config.php');
require_once('lib.php');

global $PAGE, $DB, $USER;

$id = optional_param('id', null, PARAM_INT);

/// Start making page
require_login();
$context = context_system::instance();
$PAGE->set_context(context_system::instance());
$PAGE->set_pagelayout('admin');
$PAGE->set_url('/local/paytm/index.php', ['id' => $id]);

// $addnewpromo = get_string('add_product', 'local_paytm');
// $navlist = get_string('product_list', 'local_paytm');
// //$navlisturl = new moodle_url('/local/subscription/product_list.php');
// $nav = get_string('add_product', 'local_paytm');
// $nameErr = '';

// $PAGE->navbar->add($navlist, $navlisturl);
// $PAGE->navbar->add($nav);
// $PAGE->set_title($addnewpromo);
// $PAGE->set_heading($addnewpromo);

// // $PAGE->requires->js_call_amd('local_paytm/select2', 'init');

echo $OUTPUT->header();

echo "Hello";
// if (!empty($id)) {
// 	$productRec = $DB->get_record('product', array('id' => $id));
// }

// $mform = new add_product_form($CFG->wwwroot . '/local/paytm/index.php', ['id' => $id ,'prodid'=>$productRec->productitems]);

// // --------------------------------------------- End Form Set data ----------------------------------

// if (!empty($productRec)) {
// 	$editData = new stdClass();
// 	$editData->product_name = $productRec->productname;
// 	$editData->producttype = $productRec->type;
// 	$editData->component = $productRec->component;
// 	$editData->product = $productRec->itemid;
// 	$editData->area = $productRec->area;
// 	$editData->price = $productRec->price;
// 	$editData->validity = $productRec->validity;
// 	$editData->product_description['text'] = $productRec->description;
// 		// product  image.
// 	$draftitemid = file_get_submitted_draft_itemid('product_image');
// 	file_prepare_draft_area($draftitemid, $context->id, 'local_paytm', 'content', $productRec->imagefile, array('subdirs' => 0, 'maxbytes' => 30485760, 'maxfiles' => 1));
// 	$editData->product_image = $draftitemid;
// 	$mform->set_data($editData);
// }

// 	// --------------------------------------------- End Form Set data ----------------------------------
// if ($mform->is_cancelled()) {
// 	redirect(new moodle_url('/local/paytm/product_list.php'));
// } else if ($data = $mform->get_data(false)) {
// 	if ($DB->record_exists('product', array('id' => $id))) {
// 		$updateRec = new stdClass();
// 		$updateRec->id =  $data->id;
// 		$updateRec->productname =  $data->product_name;
// 		$updateRec->type = $data->producttype;
// 		$updateRec->itemid = $data->product;
// 		$updateRec->component = $data->component;
// 		$updateRec->area = $data->area;
// 		$updateRec->price = $data->price;
// 		$updateRec->itemid = $data->product;
// 		$updateRec->validity = $data->validity;
// 		$updateRec->deleted = 0;
// 		$updateRec->timemodified = time();
// 		$updateRec->modifiedby = $USER->id;
// 		$descript = $data->product_description;
// 		$updateRec->description = $descript['text'];
// 		$updateRec->imagefile = $data->product_image;
// 		$DB->update_record('product', $updateRec);
// 	} else {
// 		$insertRec = new stdClass();
// 		$insertRec->productname =  $data->product_name;
// 		$insertRec->type = $data->producttype;
// 		$insertRec->component = $data->component;
// 		$insertRec->area = $data->area;
// 		$insertRec->price = $data->price;
//                 $insertRec->itemid = $data->product;
// 		$insertRec->validity = $data->validity;
// 		$insertRec->deleted = 0;
// 		$insertRec->timecreated = time();
// 		$insertRec->timemodified = time();
// 		$insertRec->modifiedby = $USER->id;
// 		$insertRec->createdby = $USER->id;
// 		$descript = $data->product_description;
// 		$insertRec->description = $descript['text'];
// 		$insertRec->imagefile = $data->product_image;
// 		$DB->insert_record('product', $insertRec);
// 	}
// 		// Product  image.
// 	file_save_draft_area_files($data->product_image, $context->id, 'local_paytm', 'content', $data->product_image, array('subdirs' => 0, 'maxbytes' => 30485760, 'maxfiles' => 1));
// 	if (isset($data->submitbutton1)) {
// 		if ($data->submitbutton1 == get_string('savechanges1', 'local_paytm')) {
// 			redirect(new moodle_url($CFG->wwwroot. '/local/paytm/product_list.php'));
// 		}
// 	}
// }

// $mform->display();
echo $OUTPUT->footer();