<?php
$title = "Admin: Manage Key-Location Relationships ";
$auth = array('Admin');

require_once "logincheck.php";
require_once "./common/login.php";
require_once "./common/functions.php";

$conn = new mysqli($hn, $un, $pw, $db);

if($conn->connect_error) die($conn->connect_error);

$is_act = 2;
$assignments = selectAllKeyLoc($conn,$is_act);

require_once "./common/header.php";
?>

	<!-- About -->
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<h2>Admin: Manage Key-Location Relationships</h2>
			<p>Click on the "Edit Dates" button next to the desired record to edit dates for that relationship.</p>
		</div>
	</div>
	<br>
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
					<th scope="col">Start Date</th>
					<th scope="col">End Date</th>
					<th scope="col">Edit Dates</th>
					
				</tr>
			</thead>
			<tbody>
		<?php foreach($assignments as $row){ ?>
				<tr>
					<td>
						<?php if(!$row['loc_unit_num'] || $row['loc_unit_num'] == ''){
							echo "N/A";
						}else{
							echo $row['loc_unit_num'];
						} ?>
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
							
					<td>
						<form method='post' action='admin_editkeylocation.php'>
							<input type="hidden" name='key_loc_id' value='<?php echo $row['key_loc_id'];?>'>
							<input type='submit' value='Edit Dates' class="btn btn-default">
						</form>
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