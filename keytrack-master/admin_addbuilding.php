<?php
$title = "Admin - Add Building";
$auth = array('Admin');

require_once "logincheck.php";
require_once "./common/login.php";
require_once "./common/functions.php";
require_once "./common/dropdowns.php";

$conn = new mysqli($hn, $un, $pw, $db);

if($conn->connect_error) die($conn->connect_error);

if(isset($_POST['addbuilding']))
{
	$bldg_num = mysql_entities_fix_string($conn, $_POST['bldgnum']);
	$bldg_desc = mysql_entities_fix_string($conn, $_POST['bldgdesc']);
	$bldg_prop = mysql_entities_fix_string($conn, $_POST['bldgprop']);
	$bldg_notes = mysql_entities_fix_string($conn, $_POST['bldgnotes']);
	
	$bldg_id = buildCreate($conn,$bldg_num,$bldg_desc,$bldg_prop,$bldg_notes);
	
	$conn->close();
	
	header("Location: admin_viewbuilding.php?id=$bldg_id");
}

require_once "./common/header.php";	
?>
	<!-- Intro -->
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12">
				<h2>Admin: Create New Building Record</h2>
				<p>Use this page to create a new USA Building (<a href="admin_retrievebuildings.php">cancel and return to Building List Page</a>)</p>
			</div>
		</div>
		<br>
	  <div class="row">
		<form action="admin_addbuilding.php" method="post">
		<div class="col-sm-6">
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>Building Number:</b>
				</div>
				<div class="col-sm-7 form-group">
					<input class="form-control" label="bldgnum" id="bldgnum" name="bldgnum" type="text"
					maxlength="16" placeholder="building number - example: 700A" required>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>Description:</b>
				</div>
				<div class="col-sm-7 form-group">
					<input class="form-control" label="bldgdesc" id="bldgdesc" name="bldgdesc" type="text"
					maxlength="128" placeholder="building description" required>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>Property:</b>
				</div>
				<div class="col-sm-7 form-group">
					<select name="bldgprop" size="1" required>
						<option disabled="disabled" value="" selected="selected">Select property..</option>
					<?php foreach($buildpropdd as $propdd){ ?>
						<option value="<?php echo $propdd; ?>"><?php echo $propdd; ?></option>
					<?php } ?>
					</select>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>Notes:</b>
				</div>
				<div class="col-sm-7 form-group">
					<textarea name="bldgnotes" rows="5" placeholder="Add any notes here" style="width:100%"></textarea>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-sm-4">
				</div>
				<div class="col-sm-7 form-group">
					<input type="submit" value="Create Building" name="submitnewbuilding" class="btn btn-default pull-left">
					<input type="hidden" name="addbuilding" value="Yes">
				</div>
			</div>
		</div>
		</form>
	</div>
</div>
<?php
	require_once "./common/footer.php";
?>