<?php
$title = "Edit Mail Data for Unit";
$auth = array('Admin','User');

require_once "logincheck.php";
require_once "./common/login.php";
require_once "./common/functions.php";
require_once "./common/dropdowns.php";

if(!isset($_POST['updatemail']) && !isset($_POST['applyupdate'])){
	header("Location: retrievelocations.php");
}

$conn = new mysqli($hn, $un, $pw, $db);

if($conn->connect_error) die($conn->connect_error);

if(isset($_POST['applyupdate']))
{
	$loc_id = mysql_entities_fix_string($conn, $_POST['locid']);
	$loc_mailbox = mysql_entities_fix_string($conn, $_POST['locmailbox']);
	$loc_mail_core = mysql_entities_fix_string($conn, $_POST['locmailcore']);
	
	mailUpdate($conn,$loc_id,$loc_mailbox,$loc_mail_core);
	
	$conn->close();
	
	header("Location: viewlocation.php?id=$loc_id");
}

if(isset($_POST['updatemail']))
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
				<h2>Update Mailbox Details for Location/Unit "<?php echo $row['loc_unit_num'].' - '.$row['loc_desc']; ?>"</h2>
				<p>Use this page to update the mailbox info for this unit. (<a href="viewlocation.php?id=<?php echo $row['loc_id']; ?>">cancel and return to View Location/Unit Record</a>)</p>
			</div>
		</div>
		<br>
	  <div class="row">
		<form action="editunitmaildata.php" method="post">
		<div class="col-sm-6">
			<div class="row">
				<div class="col-sm-6 text-right">
					<b>Location/Unit Number - Bldg - Property:</b>
				</div>
				<div class="col-sm-5 form-group">
					<?php echo $row['loc_unit_num'].' - '.$row['bldg_num'].' - '.$row['bldg_prop']; ?>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6 text-right">
					<b>Description:</b>
				</div>
				<div class="col-sm-5 form-group">
					<?php echo $row['loc_desc']; ?>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6 text-right">
					<b>Mailbox Number:</b>
				</div>
				<div class="col-sm-5 form-group">
					<input class="form-control" label="locmailbox" id="locmailbox" name="locmailbox" type="text"
					maxlength="32" value="<?php echo $row['loc_mailbox']; ?>" placeholder="mailbox # (00-00)" >
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6 text-right">
					<b>Mailbox Core:</b>
				</div>
				<div class="col-sm-5 form-group">
					<input class="form-control" label="locmailcore" id="locmailcore" name="locmailcore" type="text"
					maxlength="32" value="<?php echo $row['loc_mail_core']; ?>" placeholder="mailbox core #" >
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-sm-6 text-right">
				</div>
				<div class="col-sm-5 form-group">
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