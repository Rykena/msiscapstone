<?php
$title = "Admin - Retrieve Buildings";
$auth = array('Admin');

require_once "logincheck.php";
require_once "./common/login.php";
require_once "./common/functions.php";

$conn = new mysqli($hn, $un, $pw, $db);

if($conn->connect_error) die($conn->connect_error);

$buildings = selectAllBuild($conn);

require_once "./common/header.php";
?>

	<!-- About -->
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<h2>Admin: Buildings</h2>
			<p>Click on a building number below to manage that building record.</p>
		</div>
	</div>
	<p class="text-left text-muted">(<a href="admin_addbuilding.php">Create a New Building</a>)</p><br>
	<div class="row">
		
		<div class="col-sm-12">
	<!-- Table of Buildings -->
		<table id="buildtable" class="table table-striped table-bordered">
			<thead>
				<tr>
					<th scope="col">Building Number</th>
					<th scope="col">Description</th>
					<th scope="col">Property</th>
					<th scope="col">Active/Disabled Building</th>
				</tr>
			</thead>
			<tbody>
		<?php foreach($buildings as $row){ ?>
				<tr>
					<td>
						<a href="admin_viewbuilding.php?id=<?php echo $row['bldg_id']; ?>"><?php echo $row['bldg_num']; ?></a>
					</td>
					<td>
						<?php echo $row['bldg_desc']; ?>
					</td>
					<td>
						<?php echo $row['bldg_prop']; ?>
					</td>	
					<td>
						<?php if($row['bldg_is_act'] == 1){
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

<!-- script below manages the datatable jQuery logic for the table of buildings. It controls pagination, sorting, etc. -->
<script>
$(document).ready( function () {
    $('#buildtable').DataTable({
		"autoWidth": false
	});
} );
</script>

<?php
	$conn->close();
	require_once "./common/footer.php";
?>