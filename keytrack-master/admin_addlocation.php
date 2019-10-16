<?php
$title = "Admin - Add Location";
$auth = array('Admin');

require_once "logincheck.php";
require_once "./common/login.php";
require_once "./common/functions.php";
require_once "./common/dropdowns.php";

$conn = new mysqli($hn, $un, $pw, $db);

if($conn->connect_error) die($conn->connect_error);

if(isset($_POST['addlocation']))
{
	$loc_unit_num = mysql_entities_fix_string($conn, $_POST['locnum']);
	$loc_desc = mysql_entities_fix_string($conn, $_POST['locdesc']);
	$loc_notes = mysql_entities_fix_string($conn, $_POST['locnotes']);
	$loc_type = mysql_entities_fix_string($conn, $_POST['loctype']);
	$bldg_num = mysql_entities_fix_string($conn, $_POST['building_id']);
	$loc_mailbox = mysql_entities_fix_string($conn, $_POST['locmailbox']);
	$loc_mail_core = mysql_entities_fix_string($conn, $_POST['locmailcore']);
	
	$loc_id = locationCreate($conn,$loc_unit_num,$loc_desc,$loc_notes,$loc_type,$bldg_num,$loc_mailbox,$loc_mail_core);
	
	$conn->close();
	
	header("Location: admin_viewlocation.php?id=$loc_id");
}

require_once "./common/header.php";	
?>
	<!-- Intro -->
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12">
				<h2>Admin: Create New Location/Unit Record</h2>
				<p>Use this page to create a new USA Location/Unit (<a href="admin_retrievelocations.php">cancel and return to Location/Unit List Page</a>)</p>
			</div>
		</div>
		<br>
	  <div class="row">
		<form action="admin_addlocation.php" method="post">
		<div class="col-sm-6">
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>Location/Unit Number:</b>
				</div>
				<div class="col-sm-7 form-group">
					<input class="form-control" label="locnum" id="locnum" name="locnum" type="text"
					maxlength="16" placeholder="location number (usually unit number)" required>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>Description:</b>
				</div>
				<div class="col-sm-7 form-group">
					<input class="form-control" label="locdesc" id="locdesc" name="locdesc" type="text"
					maxlength="128" placeholder="location description" required>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>Notes:</b>
				</div>
				<div class="col-sm-7 form-group">
					<textarea name="locnotes" rows="5" placeholder="Add any notes here" style="width:100%"></textarea>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>Location Type:</b>
				</div>
				<div class="col-sm-7 form-group">
					<select name="loctype" size="1" required>
						<option disabled="disabled" value="" selected="selected">Select location type..</option>
					<?php foreach($loctypedd as $locdd){ ?>
						<option value="<?php echo $locdd; ?>"><?php echo $locdd; ?></option>
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
					maxlength="32" placeholder="00-00" >
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>Mailbox Core:</b>
				</div>
				<div class="col-sm-7 form-group">
					<input class="form-control" label="locmailcore" id="locmailcore" name="locmailcore" type="text"
					maxlength="32" placeholder="mailbox core #" >
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4 text-right">
					<h6 class="text-muted">&nbsp;</h6>
					<b>Building Number:</b>
				</div>
				<div id="auto" class="col-sm-7 form-group">
					<h6 class="text-muted">Type in building number to get matches to select from</h6>
					<input class="form-control" id="building_id" name="building_id" placeholder="building number" 
					type="text" maxlength="16" autocomplete="off" onkeyup="buildingauto()">
					<div id="building_list_id" class="list-group" required></div>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-sm-4">
				</div>
				<div class="col-sm-7 form-group">
					<input type="submit" value="Create Location/Unit" name="submitnewloc" class="btn btn-default pull-left">
					<input type="hidden" name="addlocation" value="Yes">
				</div>
			</div>
		</div>
		</form>
	</div>
</div>
<?php
	require_once "./common/footer.php";
?>