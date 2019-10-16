<?php
$title = "Admin - Edit Location";
$auth = array('Admin');

require_once "logincheck.php";
require_once "./common/login.php";
require_once "./common/functions.php";
require_once "./common/dropdowns.php";

if(!isset($_POST['updatelocation']) && !isset($_POST['applyupdate'])){
	header("Location: admin_retrievelocations.php");
}

$conn = new mysqli($hn, $un, $pw, $db);

if($conn->connect_error) die($conn->connect_error);

if(isset($_POST['applyupdate']))
{
	$loc_id = mysql_entities_fix_string($conn, $_POST['locid']);
	$loc_unit_num = mysql_entities_fix_string($conn, $_POST['locnum']);
	$loc_desc = mysql_entities_fix_string($conn, $_POST['locdesc']);
	$loc_notes = mysql_entities_fix_string($conn, $_POST['locnotes']);
	$loc_type = mysql_entities_fix_string($conn, $_POST['loctype']);
	$bldg_num = mysql_entities_fix_string($conn, $_POST['building_id']);
	$loc_mailbox = mysql_entities_fix_string($conn, $_POST['locmailbox']);
	$loc_mail_core = mysql_entities_fix_string($conn, $_POST['locmailcore']);
	
	locUpdate($conn,$loc_id,$loc_unit_num,$loc_desc,$loc_notes,$loc_type,$bldg_num,$loc_mailbox,$loc_mail_core);
	
	$conn->close();
	
	header("Location: admin_viewlocation.php?id=$loc_id");
}

if(isset($_POST['updatelocation']))
{
	$loc_id = mysql_entities_fix_string($conn, $_POST['updlocid']);
	
	$row = selectLocation($conn,$loc_id);

	if(!$row){
		echo "Empty Location Record";
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
				<h2>Admin: Update Details for Location/Unit "<?php echo $row['loc_unit_num'].' - '.$row['loc_desc']; ?>"</h2>
				<p>Use this page to update this location/unit information. (<a href="admin_viewlocation.php?id=<?php echo $row['loc_id']; ?>">cancel and return to View Location/Unit Record</a>)</p>
			</div>
		</div>
		<br>
	  <div class="row">
		<form action="admin_editlocation.php" method="post">
		<div class="col-sm-6">
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>Location/Unit Number:</b>
				</div>
				<div class="col-sm-7 form-group">
					<input class="form-control" label="locnum" id="locnum" name="locnum" type="text"
					maxlength="16" value="<?php echo $row['loc_unit_num']; ?>" required>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>Description:</b>
				</div>
				<div class="col-sm-7 form-group">
					<input class="form-control" label="locdesc" id="locdesc" name="locdesc" type="text"
					maxlength="128" value="<?php echo $row['loc_desc']; ?>" required>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>Notes:</b>
				</div>
				<div class="col-sm-7 form-group">
					<textarea name="locnotes" rows="5" placeholder="Add any notes here" style="width:100%"><?php echo $row['loc_notes']; ?></textarea>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>Location Type:</b>
				</div>
				<div class="col-sm-7 form-group">
					<select name="loctype" size="1">
					<?php foreach($loctypedd as $locdd){ ?>
						<option value="<?php echo $locdd; ?>" <?php if($row['loc_type'] == $locdd) echo "selected" ?>><?php echo $locdd; ?></option>
					<?php } ?>
					</select>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>Mailbox Number:</b>
				</div>
				<div class="col-sm-7 form-group">
					<input class="form-control" label="locmailbox" id="locmailbox" name="locmailbox" type="text"
					maxlength="32" value="<?php echo $row['loc_mailbox']; ?>" placeholder="00-00" >
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>Mailbox Core:</b>
				</div>
				<div class="col-sm-7 form-group">
					<input class="form-control" label="locmailcore" id="locmailcore" name="locmailcore" type="text"
					maxlength="32" value="<?php echo $row['loc_mail_core']; ?>" placeholder="mailbox core" >
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4 text-right">
					<h6 class="text-muted">&nbsp;</h6>
					<b>Building Number:</b>
				</div>
				<div id="auto" class="col-sm-7 form-group">
					<h6 class="text-muted">Type in building number to get matches to select from</h6>
					<input class="form-control" id="building_id" name="building_id" placeholder="building" 
					type="text" maxlength="16" autocomplete="off" value="<?php echo $row['bldg_num']; ?>" onkeyup="buildingauto()">
					<div id="building_list_id" class="list-group" required></div>
				</div>
			</div><br>
			
			<div class="row">
				<div class="col-sm-4 text-right">
				</div>
				<div class="col-sm-7 form-group">
					<input type="submit" value="Submit Changes" name="submitedit" class="btn btn-default pull-left">
					<input type="hidden" name="applyupdate" value="Yes">
					<input type="hidden" name="locid" value="<?php echo $row['loc_id']; ?>">
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