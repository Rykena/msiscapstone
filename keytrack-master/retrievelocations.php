<?php
$title = "View All Locations";
$auth = array('User','Admin','View');

require_once "logincheck.php";
require_once "./common/login.php";
require_once "./common/functions.php";

$conn = new mysqli($hn, $un, $pw, $db);

if($conn->connect_error) die($conn->connect_error);

$locations = selectAllLocations($conn);

require_once "./common/header.php";
?>

	<!-- About -->
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<h2>Locations/Units</h2>
			<p>Click on a location unit number below to view that location record.</p>
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
					<th scope="col">Current Key/Core</th>
					<?php if($_SESSION['usertype'] == 'View'){ 
					}else{ ?>
					<th scope="col">Rekey Location</th>
					<?php } ?>
				</tr>
			</thead>
			<tbody>
		<?php foreach($locations as $row){ ?>
				<tr>
					
					<td>
						<a href="viewlocation.php?id=<?php echo $row['loc_id']; ?>"><?php echo $row['loc_unit_num']; ?></a>
					</td>
					<td>
						<?php if(!$row['loc_desc'] || $row['loc_desc'] == ''){
							echo "N/A";
						}else{
							echo $row['loc_desc'];
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
						<?php $current = selectCurrentCore($conn,$row['loc_id']);
							if(!$current['key_number'] || $current['key_number'] == ''){
								echo "N/A";
							}else{
								echo $current['key_number'];
							}
						?>
					</td>
					<?php if($_SESSION['usertype'] == 'View'){ 
					}else{ ?>
					<td>
						<form method='post' action='rekeyunit.php'>
							<input type="hidden" name="new">
							<input type="hidden" name='loc_id' value='<?php echo $row['loc_id'];?>'>
							<input type='submit' value='Rekey Location' class="btn btn-default">
						</form>
					</td>
					<?php } ?>
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
    $('#loctable').DataTable({
		"autoWidth": false
	});
} );
</script>

<?php
	$conn->close();
	require_once "./common/footer.php";
?>