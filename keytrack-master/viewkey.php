<?php
$title = "View Key";
$auth = array('Admin','User','View');

require_once "logincheck.php";
require_once "./common/login.php";
require_once "./common/functions.php";

if(isset($_GET['id'])){
	$conn = new mysqli($hn, $un, $pw, $db);

	if($conn->connect_error) die($conn->connect_error);
	
	$key_id = mysql_entities_fix_string($conn, $_GET['id']);
	$row = selectKey($conn,$key_id);
	
	$is_act = 1;
	$assignments = selectKeyAssignments($conn,$is_act,$key_id);
	$keyholders = keyActiveHolders($conn,$key_id);
	
}else{
	header("Location: retrievekeys.php");
}

require_once "./common/header.php";
?>

	<!-- About -->
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<h2>Details for Key "<?php echo $row['key_number'];
			if($row['key_name'] == '' or !$row['key_name']){
					
				}else{
					echo ' - '.$row['key_name']; 
				}?>"
			</h2>
			<p>Use this page to view this key record. (<a href="retrievekeys.php">Return to Key List Page</a>)</p>
		</div>
	</div>
	<br>
<div class="col-sm-6">
	<div class="row">
		<div class="col-sm-5 text-right">
			<b>Key Number:</b>
		</div>
		<div class="col-sm-7 form-group">
			<?php echo $row['key_number']; ?>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-5 text-right">
			<b>Description:</b>
		</div>
		<div class="col-sm-7 form-group">
			<?php if($row['key_name'] ==''){
				echo "<i>No Description Added</i>";
			}else{
				echo $row['key_name']; 
			}
			?>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-5 text-right">
			<b>Notes:</b>
		</div>
		<div class="col-sm-7 form-group">
			<?php if($row['key_notes'] ==''){
				echo "<i>No Notes Added</i>";
			}else{
				echo $row['key_notes']; 
			}
			?>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-5 text-right">
			<b>Key Type:</b>
		</div>
		<div class="col-sm-7 form-group">
			<?php echo $row['key_type']; ?>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-5 text-right">
			<b>Core Number:</b>
		</div>
		<div class="col-sm-7 form-group">
			<?php 
			if((!isset($row['core_num'])) || ($row['core_num'] == "")){
				echo "N/A";
			}else{ ?>
				<a href="viewcore.php?id=<?php echo $row['core_id']; ?>"><?php echo $row['core_num']; ?></a>
			<?php }?>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-5 text-right">
			<b>Core/Key Cut:</b>
		</div>
		<div class="col-sm-7 form-group">
			<?php 
			if((!isset($row['core_cut'])) || ($row['core_cut'] == "")){
				echo "N/A";
			}else{
				echo $row['core_cut'];
			}?>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-5 text-right">
			<b>Core Type:</b>
		</div>
		<div class="col-sm-7 form-group">
			<?php 
			if((!isset($row['core_type'])) || ($row['core_type'] == "")){
				echo "N/A";
			}else{
				echo $row['core_type']; 
			}
			?>
		</div>
	</div>		
</div>	
<!-- this side has the panel that shows location and keyholder assignments for this location -->
<div class="col-sm-6">
<div class="col-sm-12 panel panel-default">
	<div class="panel-body">
		<div class="panel-title">
		Current Location Relationships
		</div>
		<div class="row">
			<div class="col-sm-12">
				<span class="small">Key is Currently Related to these Locations</span>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
			<table class="table table-striped table-bordered">
				<tr>
					<th scope="col">Loc/Unit Num</th>
					<th scope="col">Location Type</th>
					<th scope="col">Begin Date</th>
				</tr>
				<?php foreach($assignments as $loc){ ?>
				<tr>
					<td>
						<a href="viewlocation.php?id=<?php echo $loc['loc_id']; ?>"><?php echo $loc['loc_unit_num']; ?></a>
					</td>
					<td><?php echo $loc['loc_type'];?></td>
					<td><?php if(!$loc['key_loc_startdt'] || $loc['key_loc_startdt'] == ''){
							echo "N/A";
						}else{
							echo dateDisplay($loc['key_loc_startdt']);
						} ?>
					</td>
				</tr>
				<?php } ?>
			</table>
			</div>
		</div>
	</div>
</div>
<div class="col-sm-12 panel panel-default">
	<div class="panel-body">
		<div class="panel-title">
		Current Keyholder Relationships
		</div>
		<div class="row">
			<div class="col-sm-12">
				<span class="small">Key is Currently Related to these People</span>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
			<table class="table table-striped table-bordered">
				<tr>
					<th scope="col">Name</th>
					<th scope="col">Org</th>
					<th scope="col">Person Type</th>
					<th scope="col">Key Issue Date</th>
				</tr>
				<?php foreach($keyholders as $keyh){ ?>
				<tr>
					<td>
						<a href="viewkeyholder.php?id=<?php echo $keyh['hold_id']; ?>"><?php echo $keyh['hold_fname'].' '.$keyh['hold_lname']; ?></a>
					</td>
					<td>
						<?php echo $keyh['hold_name']; ?>
					</td>
					<td>
						<?php echo $keyh['hold_type']; ?>
					</td>
					<td><?php if(!$keyh['checkout_startdt'] || $keyh['checkout_startdt'] == ''){
							echo "N/A";
						}else{
							echo dateDisplay($keyh['checkout_startdt']);
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
	
</div>

<?php
	$conn->close();
	require_once "./common/footer.php";
?>