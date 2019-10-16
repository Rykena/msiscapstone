<?php

//page is the landing page after a rekey is done - protects the actual rekey page from refresh issues.
$title = "Rekey Complete";
$auth= array('Admin','User');

require_once "logincheck.php";
require_once './common/login.php';
require_once './common/functions.php';

if(isset($_GET['id']))
{
	$conn = new mysqli($hn, $un, $pw, $db);
	if($conn->connect_error) die($conn->connect_error);
	
	$key_loc_id = mysql_entities_fix_string($conn, $_GET['id']);
	
	$row = selectKeyLoc($conn,$key_loc_id);
	
}else{
	header("Location: index.php");
}

require_once './common/header.php';
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<h2>Rekey Complete for Unit/Location: "<?php echo $row['loc_unit_num'].($row['bldg_num'] != '' ? ' - '.$row['bldg_num'] :'').($row['bldg_prop'] != '' ? ' - '.$row['bldg_prop'] : ''); ?>"</h2>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-1">
		</div>
		<div class="col-sm-11">
			<p>The unit/location has had a new key/core assigned. (<a href="retrievelocations.php">Return to Location List Page</a>)</p>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-sm-5 text-right">
			<b>Location/Unit Number - Bldg - Property:</b>
		</div>
		<div class="col-sm-7 form-group">
			<?php echo $row['loc_unit_num'].($row['bldg_num'] != '' ? ' - '.$row['bldg_num'] :'').($row['bldg_prop'] != '' ? ' - '.$row['bldg_prop'] : ''); ?>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-5 text-right">
			<b>Newly Installed Key/Core and Install Date:</b>
		</div>
		<div class="col-sm-7 form-group">
			<?php echo $row['key_number'].' -- '.dateDisplay($row['key_loc_startdt']); ?>
		</div>
	</div>
	<br><br>
	<div class="row">
		<div class="col-sm-1">
		</div>
		<div class="col-sm-11">
			<h4>Use the Navigation above to leave this page, or <a href="index.php">click here</a> to return home.</h4>
		</div>
	</div>
</div>

<?php
	require_once './common/footer.php';
?>