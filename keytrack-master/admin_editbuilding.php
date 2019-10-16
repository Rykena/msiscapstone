<?php
$title = "Admin - Edit Building";
$auth = array('Admin');

require_once "logincheck.php";
require_once "./common/login.php";
require_once "./common/functions.php";
require_once "./common/dropdowns.php";

if(!isset($_POST['updatebuilding']) && !isset($_POST['applyupdate'])){
	header("Location: admin_retrievebuildings.php");
}

$conn = new mysqli($hn, $un, $pw, $db);

if($conn->connect_error) die($conn->connect_error);

if(isset($_POST['applyupdate']))
{
	$bldg_id = mysql_entities_fix_string($conn, $_POST['bldgid']);
	$bldgdesc = mysql_entities_fix_string($conn, $_POST['bldgdesc']);
	$bldgprop = mysql_entities_fix_string($conn, $_POST['prop']);
	$bldgnotes = mysql_entities_fix_string($conn, $_POST['bldgnotes']);
	
	buildUpdate($conn,$bldg_id,$bldgdesc,$bldgprop,$bldgnotes);
	
	$conn->close();
	
	header("Location: admin_viewbuilding.php?id=$bldg_id");
}

if(isset($_POST['updatebuilding']))
{
	$bldg_id = mysql_entities_fix_string($conn, $_POST['updbuildid']);
	
	$row = selectBuild($conn,$bldg_id);

	if(!$row){
		echo "Empty Building Record";
		exit;
	}
	$conn->close();
}

require_once "./common/header.php";	
?>
<?php if(isset($row)){?>
	<!-- Intro -->
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12">
				<h2>Admin: Update Details for Building "<?php echo $row['bldg_num']; ?>"</h2>
				<p>Use this page to update this building information. (<a href="admin_viewbuilding.php?id=<?php echo $row['bldg_id']; ?>">cancel and return to View Building Record</a>)</p>
			</div>
		</div>
		<br>
	  <div class="row">
		<form action="admin_editbuilding.php" method="post">
		<div class="col-sm-6">
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>Building Number:</b>
				</div>
				<div class="col-sm-7 form-group">
					<?php echo $row['bldg_num']; ?>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>Description:</b>
				</div>
				<div class="col-sm-7 form-group">
					<input class="form-control" label="bldgdesc" id="bldgdesc" name="bldgdesc" type="text"
					maxlength="128" value="<?php echo $row['bldg_desc']; ?>" required>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>Property:</b>
				</div>
				<div class="col-sm-7 form-group">
					<select name="prop" size="1">
					<?php foreach($buildpropdd as $propdd){ ?>
						<option value="<?php echo $propdd; ?>" <?php if($row['bldg_prop'] == $propdd) echo "selected" ?>><?php echo $propdd; ?></option>
					<?php } ?>
					</select>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>Notes:</b>
				</div>
				<div class="col-sm-7 form-group">
					<textarea name="bldgnotes" rows="5" placeholder="Add any notes here" style="width:100%"><?php echo $row['bldg_notes']; ?></textarea>
				</div>
			</div><br>
			
			<div class="row">
				<div class="col-sm-4 text-right">
				</div>
				<div class="col-sm-7 form-group">
					<input type="submit" value="Submit Changes" name="submitedit" class="btn btn-default pull-left">
					<input type="hidden" name="applyupdate" value="Yes">
					<input type="hidden" name="bldgid" value="<?php echo $row['bldg_id']; ?>">
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