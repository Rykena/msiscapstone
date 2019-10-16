<?php
$title = "Retrieve Cores";
$auth = array('Admin','User','View');

require_once "logincheck.php";
require_once "./common/login.php";
require_once "./common/functions.php";

$conn = new mysqli($hn, $un, $pw, $db);

if($conn->connect_error) die($conn->connect_error);

$cores = selectAllCore($conn);

require_once "./common/header.php";
?>

	<!-- About -->
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<h2>Cores</h2>
			<p>Click on a core number below to view that core record.</p>
		</div>
	</div>
	
	<div class="row">
		
		<div class="col-sm-12">
	<!-- Table of Cores -->
		<table id="coretable" class="table table-striped table-bordered">
			<thead>
				<tr>
					<th scope="col">Core Number</th>
					<th scope="col">Core Cut</th>
					<th scope="col">Core Type</th>
					<th scope="col">Description</th>
					<th scope="col">Manufacturer</th>
					
				</tr>
			</thead>
			<tbody>
		<?php foreach($cores as $row){ ?>
				<tr>
					<td>
						<a href="viewcore.php?id=<?php echo $row['core_id']; ?>"><?php echo $row['core_num']; ?></a>
					</td>
					<td>
						<?php echo $row['core_cut']; ?>
					</td>
					<td>
						<?php echo $row['core_type']; ?>
					</td>
					<td>
						<?php echo $row['core_desc']; ?>
					</td>
					<td>
						<?php echo $row['core_manf']; ?>
					</td>	
					
				</tr>
		<?php } ?>
			</tbody>
		</table>
		</div>
	</div>
	
	
</div>

<!-- script below manages the datatable jQuery logic for the table of cores. It controls pagination, sorting, etc. -->
<script>
$(document).ready( function () {
    $('#coretable').DataTable({
		"autoWidth": false
	});
} );
</script>

<?php
	$conn->close();
	require_once "./common/footer.php";
?>