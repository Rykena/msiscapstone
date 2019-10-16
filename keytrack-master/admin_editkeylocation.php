<?php
$title = "Admin: Edit Key-Location Dates";
$auth = array('Admin');

require_once "logincheck.php";
require_once "./common/login.php";
require_once "./common/functions.php";

if(!isset($_POST['key_loc_id']) && !isset($_POST['applyupdate'])){
	header("Location: admin_retrievekeylocations.php");
}

$conn = new mysqli($hn, $un, $pw, $db);

if($conn->connect_error) die($conn->connect_error);

if(isset($_POST['applyupdate']))
{
	$key_loc_id = mysql_entities_fix_string($conn, $_POST['keylocid']);
	$start_dt = mysql_entities_fix_string($conn, $_POST['startdt']);
	$end_dt = mysql_entities_fix_string($conn, $_POST['enddt']);
	
	updateKeyLocStartDate($conn,$key_loc_id,$start_dt);
	updateKeyLocEndDate($conn,$key_loc_id,$end_dt);
	
	$conn->close();
	unset($_POST['applyupdate']);
	
	header("Location: admin_retrievekeylocations.php");
}

if(isset($_POST['key_loc_id']))
{
	$key_loc_id = mysql_entities_fix_string($conn, $_POST['key_loc_id']);
	
	$row = selectKeyLoc($conn,$key_loc_id);

	if(!$row){
		echo "Empty Key-Loc Record";
		exit;
	}
	$conn->close();
	unset($_POST['key_loc_id']);
}

require_once "./common/header.php";	
?>
<?php if(isset($row)){?>
	<!-- Intro -->
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12">
				<h2>Admin: Update Key-Location Dates</h2>
				<p>Use this page to modify any dates for this key-location relationship record. (<a href="admin_retrievekeylocations.php">cancel and return to Admin Key-Location List Page</a>)</p>
			</div>
		</div>
		<br>
	  <div class="row">
		<form action="admin_editkeylocation.php" method="post">
		<div class="col-sm-6">
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>Location/Unit Number:</b>
				</div>
				<div class="col-sm-7 form-group">
					<?php if(!$row['loc_unit_num'] || $row['loc_unit_num'] == ''){
						echo "N/A";
					}else{
						echo $row['loc_unit_num'];
					} ?>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>Location Type:</b>
				</div>
				<div class="col-sm-7 form-group">
					<?php if(!$row['loc_type'] || $row['loc_type'] == ''){
						echo "N/A";
					}else{
						echo $row['loc_type'];
					} ?>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>Building:</b>
				</div>
				<div class="col-sm-7 form-group">
					<?php if(!$row['bldg_num'] || $row['bldg_num'] == ''){
						echo "N/A";
					}else{
						echo $row['bldg_num'];
					} ?>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>Property:</b>
				</div>
				<div class="col-sm-7 form-group">
					<?php if(!$row['bldg_prop'] || $row['bldg_prop'] == ''){
						echo "N/A";
					}else{
						echo $row['bldg_prop'];
					} ?>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>Key/Core Number:</b>
				</div>
				<div class="col-sm-7 form-group">
					<?php if(!$row['key_number'] || $row['key_number'] == ''){
						echo "N/A";
					}else{
						echo $row['key_number'];
					} ?>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>Start Date:</b>
				</div>
				<div class="col-sm-7 form-group">
					<input type="date" id="startdt" name="startdt" 
					<?php if(!$row['key_loc_startdt'] || $row['key_loc_startdt'] == ''){ ?>
					<?php }else{ ?>
					value="<?php echo date('Y-m-d', strtotime($row['key_loc_startdt'])); ?>"
					<?php } ?>
					required >
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>End Date:</b>
				</div>
				<div class="col-sm-7 form-group">
					<input type="date" id="enddt" name="enddt" 
					<?php if(!$row['key_loc_enddt'] || $row['key_loc_enddt'] == ''){ ?>
					<?php }else{ ?>
					value="<?php echo date('Y-m-d',strtotime($row['key_loc_enddt'])) ?>"
					<?php } ?>
					>
				</div>
			</div>
			<br>
			
			<div class="row">
				<div class="col-sm-4 text-right">
					<input type="submit" value="Submit Date Changes" name="submitedit" class="btn btn-default">
					<input type="hidden" name="applyupdate" value="Yes">
					<input type="hidden" name="keylocid" value="<?php echo $row['key_loc_id']; ?>">
		
				</div>
			</div>
		</div>
		</form>
	</div>
</div>	
<?php } ?>
<?php
	require_once "./common/footer.php";
?>