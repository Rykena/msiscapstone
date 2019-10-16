<?php
$title = "Admin - Retrieve Locations";
$auth = array('Admin');

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
			<h2>Admin: Locations/Units</h2>
			<p>Click on a location unit number below to manage that location record.</p>
		</div>
	</div>
	<p class="text-left text-muted">(<a href="admin_addlocation.php">Create a New Location/Unit</a>)</p><br>
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
					<th scope="col">Active/Disabled Location</th>
				</tr>
			</thead>
			<tbody>
		<?php foreach($locations as $row){ ?>
				<tr>
					<td>
						<a href="admin_viewlocation.php?id=<?php echo $row['loc_id']; ?>"><?php echo $row['loc_unit_num']; ?></a>
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
						<?php if($row['loc_is_act'] == 1){
							echo "Active";
						}else{
							echo "Disabled";
						} 
						?>
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
    $('#loctable').DataTable({
		"autoWidth": false
	});
} );
</script>

<?php
	$conn->close();
	require_once "./common/footer.php";
?>