<?php
$title = "View Location";
$auth = array('Admin','User','View');

require_once "logincheck.php";
require_once "./common/login.php";
require_once "./common/functions.php";

if(isset($_GET['id'])){
	$conn = new mysqli($hn, $un, $pw, $db);

	if($conn->connect_error) die($conn->connect_error);
	
	$loc_id = mysql_entities_fix_string($conn, $_GET['id']);
	$row = selectLocation($conn,$loc_id);
	
	$is_act = 2;
	$assignments = selectLocAssignments($conn,$is_act,$loc_id);
	
}else{
	header("Location: retrievelocations.php");
}

require_once "./common/header.php";
?>

	<!-- About -->
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<h2>Details for Location "<?php echo $row['loc_unit_num'].' - '.$row['loc_desc']; ?>"</h2>
			<p>Use this page to view a location record. (<a href="retrievelocations.php">Return to Location/Unit List Page</a>)</p>
		</div>
	</div>
	<br>
<div class="col-sm-6">
	<div class="row">
		<div class="col-sm-5 text-right">
			<b>Location/Unit Number:</b>
		</div>
		<div class="col-sm-7 form-group">
			<?php if($row['loc_unit_num'] ==''){
				echo "<i>No Location/Unit Number Added</i>";
			}else{
				echo $row['loc_unit_num']; 
			}
			?>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-5 text-right">
			<b>Description:</b>
		</div>
		<div class="col-sm-7 form-group">
			<?php if($row['loc_desc'] ==''){
				echo "<i>No Description Added</i>";
			}else{
				echo $row['loc_desc']; 
			}
			?>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-5 text-right">
			<b>Notes:</b>
		</div>
		<div class="col-sm-7 form-group">
			<?php if($row['loc_notes'] ==''){
				echo "<i>No Notes Added</i>";
			}else{
				echo $row['loc_notes']; 
			}
			?>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-5 text-right">
			<b>Location Type:</b>
		</div>
		<div class="col-sm-7 form-group">
			<?php echo $row['loc_type']; ?>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-5 text-right">
			<b>Building Number:</b>
		</div>
		<div class="col-sm-7 form-group">
			<?php if($row['bldg_num'] ==''){
				echo "<i>N/A</i>";
			}else{
				echo $row['bldg_num']; 
			}
			?>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-5 text-right">
			<b>Property:</b>
		</div>
		<div class="col-sm-7 form-group">
			<?php if($row['bldg_prop'] ==''){
				echo "<i>N/A</i>";
			}else{
				echo $row['bldg_prop']; 
			}
			?>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-5 text-right">
			<b>Mailbox Number:</b>
		</div>
		<div class="col-sm-7 form-group">
			<?php if($row['loc_mailbox'] ==''){
				echo "<i>N/A</i>";
			}else{
				echo $row['loc_mailbox']; 
			}
			?>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-5 text-right">
			<b>Mailbox Core:</b>
		</div>
		<div class="col-sm-7 form-group">
			<?php if($row['loc_mail_core'] ==''){
				echo "<i>N/A</i>";
			}else{
				echo $row['loc_mail_core']; 
			}
			?>
		</div>
	</div>
	<br>
	<?php if($_SESSION['usertype'] == 'View'){ 
	}else{ ?>
	<div class="row">
		<div class="col-sm-5 form-group">
		<form method='post' action='rekeyunit.php'>
			<input type="hidden" name="new">
			<input type="hidden" name='loc_id' value='<?php echo $row['loc_id'];?>'>
			<input type='submit' value='Rekey This Unit' class="btn btn-default pull-right">
		</form>
		</div>
		<div class="col-sm-5 form-group">
		<form method="post" action="editunitmaildata.php">
			<input type="submit" value="Update Mailbox Data" name="updatemail" class="btn btn-default">
			<input type="hidden" value="<?php echo $row['loc_id']; ?>" name="updlocid">
		</form>
		</div>
	</div>
	<?php } ?>
</div>	
<!-- this side has the panel that shows core assignments for this location -->
<div class="col-sm-6 panel panel-default">
	<div class="panel-body">
		<div class="panel-title">
		Key/Core Assignments
		</div>
		<div class="row">
			<div class="col-sm-12">
				<span class="small">Key/Core History</span>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
			<table class="table table-striped table-bordered">
				<tr>
					<th scope="col">Key/Core</th>
					<th scope="col">Assign Date</th>
					<th scope="col">End Date</th>
				</tr>
				<?php foreach($assignments as $core){ ?>
				<tr>
					<td>
						<a href="viewkey.php?id=<?php echo $core['key_id']; ?>"><?php echo $core['key_number']; ?></a>
					</td>
					<td><?php echo dateDisplay($core['key_loc_startdt']);?></td>
					<td><?php if(!$core['key_loc_enddt'] || $core['key_loc_enddt'] == ''){
							echo "<b>CURRENT</b>";
						}else{
							echo dateDisplay($core['key_loc_enddt']);
						} ?>
					</td>
				</tr>
				<?php } ?>
			</table>
			</div>
		</div>
	</div>
</div>	
	
</div>

<?php
	$conn->close();
	require_once "./common/footer.php";
?>