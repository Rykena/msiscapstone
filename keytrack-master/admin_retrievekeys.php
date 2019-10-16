<?php
$title = "Admin - Retrieve Keys";
$auth = array('Admin');

require_once "logincheck.php";
require_once "./common/login.php";
require_once "./common/functions.php";

$conn = new mysqli($hn, $un, $pw, $db);

if($conn->connect_error) die($conn->connect_error);

$keys = selectAllKeys($conn);

require_once "./common/header.php";
?>

	<!-- About -->
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<h2>Admin: Keys</h2>
			<p>Click on a key number below to manage that key record.</p>
		</div>
	</div>
	<p class="text-left text-muted">(<a href="admin_addkey.php">Create a New Key</a>)</p><br>
	<div class="row">
		
		<div class="col-sm-12">
	<!-- Table of Keys -->
		<table id="keytable" class="table table-striped table-bordered">
			<thead>
				<tr>
					<th scope="col">Key Number</th>
					<th scope="col">Description</th>
					<th scope="col">Key Type</th>
					<th scope="col">Core Number</th>
					<th scope="col">Core Type</th>
					<th scope="col">Active/Disabled Key</th>
				</tr>
			</thead>
			<tbody>
		<?php foreach($keys as $row){ ?>
				<tr>
					<td>
						<a href="admin_viewkey.php?id=<?php echo $row['key_id']; ?>"><?php echo $row['key_number']; ?></a>
					</td>
					<td>
						<?php echo $row['key_name']; ?>
					</td>
					<td>
						<?php echo $row['key_type']; ?>
					</td>
					<td>
						<?php 
						if((!isset($row['core_num'])) || ($row['core_num'] == "")){
							echo "N/A";
						}else{
							echo $row['core_num']; 
						}
						?>
					</td>
					<td>
						<?php 
						if((!isset($row['core_type'])) || ($row['core_type'] == "")){
							echo "N/A";
						}else{
							echo $row['core_type']; 
						}
						?>
					</td>						
					<td>
						<?php if($row['key_is_act'] == 1){
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

<!-- script below manages the datatable jQuery logic for the table of keys. It controls pagination, sorting, etc. -->
<script>
$(document).ready( function () {
    $('#keytable').DataTable({
		"autoWidth": false
	});
} );
</script>

<?php
	$conn->close();
	require_once "./common/footer.php";
?>