<?php
$title = "Admin - View Location";
$auth = array('Admin');

require_once "logincheck.php";
require_once "./common/login.php";
require_once "./common/functions.php";

if(isset($_GET['id'])){
	$conn = new mysqli($hn, $un, $pw, $db);

	if($conn->connect_error) die($conn->connect_error);
	
	$loc_id = mysql_entities_fix_string($conn, $_GET['id']);
	$row = selectLocation($conn,$loc_id);
	
}else{
	header("Location: admin_retrievelocations.php");
}

require_once "./common/header.php";
?>

	<!-- About -->
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<h2>Admin: Details for Location "<?php echo $row['loc_unit_num'].' - '.$row['loc_desc']; ?>"</h2>
			<p>Use this page to administrate this location record. (<a href="admin_retrievelocations.php">Return to Location/Unit List Page</a>)</p>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-sm-3 text-right">
			<b>Location/Unit Number:</b>
		</div>
		<div class="col-sm-9 form-group">
			<?php if($row['loc_unit_num'] ==''){
				echo "<i>No Location/Unit Number Added</i>";
			}else{
				echo $row['loc_unit_num']; 
			}
			?>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-3 text-right">
			<b>Description:</b>
		</div>
		<div class="col-sm-9 form-group">
			<?php if($row['loc_desc'] ==''){
				echo "<i>No Description Added</i>";
			}else{
				echo $row['loc_desc']; 
			}
			?>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-3 text-right">
			<b>Notes:</b>
		</div>
		<div class="col-sm-9 form-group">
			<?php if($row['loc_notes'] ==''){
				echo "<i>No Notes Added</i>";
			}else{
				echo $row['loc_notes']; 
			}
			?>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-3 text-right">
			<b>Location Type:</b>
		</div>
		<div class="col-sm-9 form-group">
			<?php echo $row['loc_type']; ?>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-3 text-right">
			<b>Building Number:</b>
		</div>
		<div class="col-sm-9 form-group">
			<?php if($row['bldg_num'] ==''){
				echo "<i>N/A</i>";
			}else{
				echo $row['bldg_num']; 
			}
			?>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-3 text-right">
			<b>Property:</b>
		</div>
		<div class="col-sm-9 form-group">
			<?php if($row['bldg_prop'] ==''){
				echo "<i>N/A</i>";
			}else{
				echo $row['bldg_prop']; 
			}
			?>
		</div>
	</div>	

	<div class="row">
		<div class="col-sm-3 text-right">
			<b>Mailbox Number:</b>
		</div>
		<div class="col-sm-9 form-group">
			<?php if($row['loc_mailbox'] ==''){
				echo "<i>N/A</i>";
			}else{ 
				echo $row['loc_mailbox']; 
			} ?>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-3 text-right">
			<b>Mailbox Core:</b>
		</div>
		<div class="col-sm-9 form-group">
			<?php if($row['loc_mail_core'] ==''){
				echo "<i>N/A</i>";
			}else{ 
				echo $row['loc_mail_core']; 
			} ?>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-3 text-right">
			<b>Active/Disabled Location:</b>
		</div>
		<div class="col-sm-9 form-group">
			<?php if($row['loc_is_act'] == 1){
					echo "Active";
				}else{
					echo "Disabled";
				} 
			?>
		</div>
	</div>
	
	<br>
	<div class="row">
		<div class="col-sm-3 form-group">
		<form method="post" action="admin_editlocation.php">
			<input type="submit" value="Edit Location Details" name="updatelocation" class="btn btn-default pull-right">
			<input type="hidden" value="<?php echo $row['loc_id']; ?>" name="updlocid">
		</form>
		</div>
	<?php if($row['loc_is_act'] == 0){ ?>	
		<div class="col-sm-2 form-group">
		<form method="post" action="admin_locactiveset.php">
			<input type="submit" value="Activate Building Record" name="activateloc" class="btn btn-default">
			<input type="hidden" value="<?php echo $row['loc_id']; ?>" name="locid">
			<input type="hidden" value="<?php echo $row['loc_is_act']; ?>" name="locact">
		</form>
		</div>
	<?php }else{ ?>	
		<div class="col-sm-2 form-group">
		<form method="post" action="admin_locactiveset.php">
			<input type="submit" value="Disable Location Record" name="deactivateloc" class="btn btn-default">
			<input type="hidden" value="<?php echo $row['loc_id']; ?>" name="locid">
			<input type="hidden" value="<?php echo $row['loc_is_act']; ?>" name="locact">
		</form>
		</div>
	<?php } ?>	
	</div>
	
</div>

<?php
	$conn->close();
	require_once "./common/footer.php";
?>