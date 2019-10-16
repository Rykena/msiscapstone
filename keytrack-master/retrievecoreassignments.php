<?php
$title = "View All Key/Core Assignments";
$auth = array('User','Admin','View');

require_once "logincheck.php";
require_once "./common/login.php";
require_once "./common/functions.php";

$conn = new mysqli($hn, $un, $pw, $db);

if($conn->connect_error) die($conn->connect_error);

if(!isset($_POST['is_act'])){
	$is_act = 1;
	$assignments = selectAllKeyLoc($conn,$is_act);
}

if(isset($_POST['is_act'])){
	$is_act = mysql_entities_fix_string($conn,$_POST['is_act']);
	$assignments = selectAllKeyLoc($conn,$is_act);
}

require_once "./common/header.php";
?>

	<!-- About -->
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<h2>Key/Core Assignments</h2>
			<p>Click on the location number to view more details on the location, including key/core history.<br>
			Use the "View Historical/View Current" button at the top of the table to toggle between active key/core assignments and historical records.</p>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-sm-4 form-group">
			<b>Currently Viewing <?php if($is_act == 1){echo "ACTIVE";}else{echo "HISTORICAL";} ?> Key/Core Assigment Records</b>
		</div>
		<div class="col-sm-2 form-group">
			<form method="post" action="retrievecoreassignments.php">
			<?php if($is_act == 1){ ?>
				<input type="submit" value="View Historical" name="activecheck" class="btn btn-default pull-left">
				<input type="hidden" value="0" name="is_act">
			<?php }else{ ?>
				<input type="submit" value="View Current" name="activecheck" class="btn btn-default pull-left">
				<input type="hidden" value="1" name="is_act">
			<?php } ?>
			</form>
		</div>
		<?php if($_SESSION['usertype'] == 'View'){ 
		}else{ ?>
		<div class="col-sm-5 form-group">
			(<a href="retrievelocations.php">Rekey a Location</a>)
		</div>
		<?php } ?>
	</div>
	<div class="row">
		
		<div class="col-sm-12">
		
	<!-- Table of core assignments -->
		<table id="rekeytable" class="table table-striped table-bordered">
			<thead>
				<tr>
	
					<th scope="col">Loc/Unit Number</th>
					<th scope="col">Location Type</th>
					<th scope="col">Bldg</th>
					<th scope="col">Property</th>
					<th scope="col">Key/Core Number</th>
					<th scope="col">Assign Date</th>
					<th scope="col">End Date</th>
					
				</tr>
			</thead>
			<tbody>
		<?php foreach($assignments as $row){ ?>
				<tr>
					<td>
						<a href="viewlocation.php?id=<?php echo $row['loc_id']; ?>"><?php echo $row['loc_unit_num']; ?></a>
					</td>
					<td>
						<?php echo $row['loc_type']; ?>
					</td>
					<td>
						<?php if(!$row['bldg_num'] || $row['bldg_num'] == ''){
							echo "N/A";
						}else{
							echo $row['bldg_num'];
						} ?>
					</td>
					<td>
						<?php if(!$row['bldg_prop'] || $row['bldg_prop'] == ''){
							echo "N/A";
						}else{
							echo $row['bldg_prop'];
						} ?>
					</td>
					<td>
						<?php if(!$row['key_number'] || $row['key_number'] == ''){
							echo "N/A";
						}else{
							echo $row['key_number'];
						} ?>
					</td>
					<td>
						<?php if(!$row['key_loc_startdt'] || $row['key_loc_startdt'] == ''){
							echo "N/A";
						}else{
							echo dateDisplay($row['key_loc_startdt']);
						} ?>
					</td>
					<td>
						<?php if(!$row['key_loc_enddt'] || $row['key_loc_enddt'] == ''){
							echo "N/A";
						}else{
							echo dateDisplay($row['key_loc_enddt']);
						} ?>
					</td>
				</tr>
		<?php } ?>
			</tbody>
		</table>
		</div>
	</div>
	
	
</div>

<!-- script below manages the datatable jQuery logic for the table of core assignments. It controls pagination, sorting, etc. -->
<script>
$(document).ready( function () {
	$.fn.dataTable.moment('MM/DD/YYYY');
    $('#rekeytable').DataTable({
		"autoWidth": false
	});
} );
</script>

<?php
	$conn->close();
	require_once "./common/footer.php";
?>