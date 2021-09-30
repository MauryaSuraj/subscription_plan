<?php
require(dirname(dirname(dirname(__FILE__))) . '/config.php');
require_once ('lib.php');
global $PAGE, $DB, $USER;

require_login();
//require_capability('local/usermanagment:jobposting', context_system::instance());
$id = optional_param('id', null, PARAM_INT);

/// Start making page
$PAGE->set_context(context_system::instance());
$PAGE->set_pagelayout('admin');
$PAGE->set_url('/local/paytm/product_list.php', ['id' => $id]);
$addnewpromo = get_string('product_list', 'local_paytm');
$PAGE->navbar->add(get_string('add_product', 'local_paytm'), new moodle_url('/local/paytm/index.php', ['type' => 1]));
$PAGE->navbar->add(get_string('product_list', 'local_paytm'));
$PAGE->set_title($addnewpromo);
$PAGE->set_heading($addnewpromo);

?>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<?php
$PAGE->requires->jquery();

echo $OUTPUT->header();
echo '<a href="index.php" style="float: right">
<button class="btn btn-primary" type="submit">'. get_string('add_product', 'local_paytm') .'</button>
</a>';

// if admin show all jobs.

$all_users = array();
$products = $DB->get_records_sql("SELECT * FROM {product} WHERE deleted = 0");
//print_r($products);
//die;




$applicants = 0;

if (!empty($products)) {
	$tabledata = '
	<table id="emoticonsetting" class="admintable generaltable">
	<thead>
	<tr>
	<th>'. get_string('product_tabh1', 'local_paytm') .'</th>
	<th>'. get_string('product_tabh2', 'local_paytm') .'</th>
	<th>'. get_string('product_tabh3', 'local_paytm') .'</th>
	<th>'. get_string('product_tabh4', 'local_paytm') .'</th>
	<th>'. get_string('product_tabh5', 'local_paytm') .'</th>
	<th>'. get_string('product_tabh6', 'local_paytm') .'</th>
	</tr>
	</thead>
	<tbody>';

	foreach ($products as $jobval) {

		$jobtabval1 = $jobval->productname;
		$jobtabval2 = $jobval->price;
		$jobtabval3 = $jobval->type;
		$jobtabval4 = $jobval->component;
		$jobtabval5 = $jobval->area;

		// $companyi = get_parent_user_IA($USER->id);
		$jappCount = $DB->get_records('product', ['id' => $jobval->id]);
		$applicants = !empty($jappCount) ? count($jappCount) : '0';

		$jobtabval7 = $applicants;
		$jobtabval9 = '<a href="index.php?type=1&id='.$jobval->id.'">
		<button class="btn btn-warning" type="submit">'. get_string('edit', 'local_patytm') .'</button>
		</a>';
		// if(has_capability('local/usermanagment:industrysuperadmin', context_system::instance())) {
		// 	$jobtabval9 .= '<span>
		// 	<button class="btn btn-danger delete_job_internship" id="'.$jobval->id.'">Delete</button>
		// 	</span>';	
		// } 
                // $jobtabval9 .= '<a href="delete.php?type=1&jid='.$jobval->id.'">
                //                     <button class="btn btn-danger" type="submit">'. get_string('delete', 'local_subscription') .'</button>
                //                 </a>';
		$jobtabval10 = '<a href="index.php?id='. $jobval->id .'">
		<button class="btn btn-success" type="submit">'. get_string('edit', 'local_paytm') .'</button>
		</a>';
		$jobtabval10 .= '<button class="btn btn-danger delete_product" id="1-'.$jobval->id.'">'. get_string('delete', 'local_paytm') .'</button>';

		$tabledata .= 
		'<tr>
		<td class="c0">'. $jobtabval1 .'</td>
		<td class="c5">'. $jobtabval2 .'</td>
		<td class="c6">'. $jobtabval3 .'</td>
		<td class="c7">'. $jobtabval4 .'</td>
		<td class="c8">'. $jobtabval5 .'</td>
		<td class="c9">'. $jobtabval10 .'</td>
		</tr>';
	}

	$tabledata .= '</tbody>
	</table>
	';
	echo $tabledata;
	echo '</div>
	</div>';

} else {
	echo '<div class="label label-warning btn-block p-10">'. get_string('no_product', 'local_patytm');
}

echo '
<div id="jobDetails" class="modal" style="background-color: #000000;">
<div class="modal-dialog modal-lg  modal-dialog-centered">

<!-- Modal content-->
<div class="modal-content">
<div class="modal-body" id="">
<div class="popup-content" id="jobModal">

</div>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
</div>

</div>
</div>
';
// $PAGE->requires->js_call_amd('local_subscription/select2', 'init');
$PAGE->requires->js_call_amd('local_patytm/delete', 'init');

echo $OUTPUT->footer();
?>

<script>
	var page = {url: '<?php echo $CFG->wwwroot;?>'};
</script>