<?php
$title = "Admin - Edit Core";
$auth = array('Admin');

require_once "logincheck.php";
require_once "./common/login.php";
require_once "./common/functions.php";
require_once "./common/dropdowns.php";

if(!isset($_POST['updatecore']) && !isset($_POST['applyupdate'])){
	header("Location: admin_retrievecores.php");
}

$conn = new mysqli($hn, $un, $pw, $db);

if($conn->connect_error) die($conn->connect_error);

if(isset($_POST['applyupdate']))
{
	$core_id = mysql_entities_fix_string($conn, $_POST['coreid']);
	$core_cut = mysql_entities_fix_string($conn, $_POST['corecut']);
	$core_desc = mysql_entities_fix_string($conn, $_POST['coredesc']);
	$core_manf = mysql_entities_fix_string($conn, $_POST['coremanf']);
	$core_notes = mysql_entities_fix_string($conn, $_POST['corenotes']);
	$core_type = mysql_entities_fix_string($conn, $_POST['coretype']);
	
	coreUpdate($conn,$core_id,$core_cut,$core_desc,$core_manf,$core_notes,$core_type);
	
	$conn->close();
	
	header("Location: admin_viewcore.php?id=$core_id");
}

if(isset($_POST['updatecore']))
{
	$core_id = mysql_entities_fix_string($conn, $_POST['updcoreid']);
	
	$row = selectCore($conn,$core_id);

	if(!$row){
		echo "Empty Core Record";
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
				<h2>Admin: Update Details for Core Number: <?php echo $row['core_num']; ?></h2>
				<p>Use this page to update this core information. (<a href="admin_viewcore.php?id=<?php echo $row['core_id']; ?>">cancel and return to View Core Record</a>)</p>
			</div>
		</div>
		<br>
	  <div class="row">
		<form action="admin_editcore.php" method="post">
		<div class="col-sm-6">
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>Core Number:</b>
				</div>
				<div class="col-sm-7 form-group">
					<?php echo $row['core_num']; ?>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>Core Cut:</b>
				</div>
				<div class="col-sm-7 form-group">
					<input class="form-control" label="corecut" id="corecut" name="corecut" type="text"
					maxlength="32" value="<?php echo $row['core_cut']; ?>">
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>Core Type:</b>
				</div>
				<div class="col-sm-7 form-group">
					<select name="coretype" size="1">
					<?php foreach($coretypedd as $coredd){ ?>
						<option value="<?php echo $coredd; ?>" <?php if($row['core_type'] == $coredd) echo "selected" ?>><?php echo $coredd; ?></option>
					<?php } ?>
					</select>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>Description:</b>
				</div>
				<div class="col-sm-7 form-group">
					<input class="form-control" label="coredesc" id="coredesc" name="coredesc" type="text"
					maxlength="128" value="<?php echo $row['core_desc']; ?>">
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>Manufacturer:</b>
				</div>
				<div class="col-sm-7 form-group">
					<input class="form-control" label="coremanf" id="coremanf" name="coremanf" type="text"
					maxlength="32" value="<?php echo $row['core_manf']; ?>">
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>Notes:</b>
				</div>
				<div class="col-sm-7 form-group">
					<textarea name="corenotes" rows="5" placeholder="Add any notes here" style="width:100%"><?php echo $row['core_notes']; ?></textarea>
				</div>
			</div><br>
			
			<div class="row">
				<div class="col-sm-4 text-right">
				</div>
				<div class="col-sm-7 form-group">
					<input type="submit" value="Submit Changes" name="submitedit" class="btn btn-default pull-left">
					<input type="hidden" name="applyupdate" value="Yes">
					<input type="hidden" name="coreid" value="<?php echo $row['core_id']; ?>">
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