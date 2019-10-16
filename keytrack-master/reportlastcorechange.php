<?php
$title = "Last Core Change Report";
$auth = array('User','Admin','View');

require_once "logincheck.php";
require_once "./common/login.php";
require_once "./common/functions.php";

$conn = new mysqli($hn, $un, $pw, $db);
if($conn->connect_error) die($conn->connect_error);

$locations = selectAllCurrentCores($conn);

require_once "./common/header.php";
?>

	<!-- About -->
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<h2>Last Core Change Date for Units</h2>
			<p>Click on a location unit number below to view that location record.<br>
			(<a href="landingreports.php">Return to Reports Homepage</a>)</p>
		</div>
	</div>
	<div class="row">
		
		<div class="col-sm-12">
	<!-- Table of Locations -->
		<table id="loctable" class="table table-striped table-bordered">
			<thead>
				<tr>
	
					<th scope="col">Location/Unit Number</th>
					<th scope="col">Description</th>
					<th scope="col">Location Type</th>
					<th scope="col">Building Number</th>
					<th scope="col">Property</th>
					<th scope="col">Current Core</th>
					<th scope="col">Last Change Date</th>
				</tr>
			</thead>
			<tbody>
		<?php foreach($locations as $row){ ?>
				<tr>
					
					<td>
						<a href="viewlocation.php?id=<?php echo $row['loc_id']; ?>"><?php echo $row['loc_unit_num']; ?></a>
					</td>
					<td>
						<?php echo $row['loc_desc']; ?>
					</td>
					<td>
						<?php echo $row['loc_type']; ?>
					</td>
					<td>
						<?php echo $row['bldg_num']; ?>
					</td>
					<td>
						<?php echo $row['bldg_prop']; ?>
					</td>
					<td>
						<?php 
							if(!$row['core_num'] || $row['core_num'] == ''){
								echo "N/A";
							}else{
								echo $row['core_num'];
							}
						?>
					</td>
					<td>
						<?php if(!$row['key_loc_startdt'] || $row['key_loc_startdt'] == ''){
							echo "N/A";
						}else{
							echo dateDisplay($row['key_loc_startdt']);
						} ?>
					</td>
				</tr>
		<?php } ?>
			</tbody>
		</table>
		</div>
	</div>
	
	
</div>

<!-- script below manages the datatable jQuery logic for the table of locations. It controls pagination, sorting, etc. -->
<script>
$(document).ready( function () {
	$.fn.dataTable.moment('MM/DD/YYYY');
    $('#loctable').DataTable({
		"autoWidth": false
	});
} );
</script>

<?php
	$conn->close();
	require_once "./common/footer.php";
?>