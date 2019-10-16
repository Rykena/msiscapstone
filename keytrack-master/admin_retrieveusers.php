<?php
$title = "Admin - Retrieve Users";
$auth = array('Admin');

require_once "logincheck.php";
require_once "./common/login.php";
require_once "./common/functions.php";

$conn = new mysqli($hn, $un, $pw, $db);

if($conn->connect_error) die($conn->connect_error);

$users = selectAllUsers($conn);

require_once "./common/header.php";
?>

	<!-- About -->
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<h2>Admin: System Users</h2>
			<p>Click on a username below to manage that account.</p>
		</div>
	</div>
	<p class="text-left text-muted">(<a href="admin_adduser.php">Create a New System User</a>)</p><br>
	<div class="row">
		
		<div class="col-sm-12">
	<!-- Table of Users -->
		<table id="usertable" class="table table-striped table-bordered">
			<thead>
				<tr>
					<th scope="col">Login/Username</th>
					<th scope="col">Full Name</th>
					<th scope="col">uNID</th>
					<th scope="col">User Type</th>
					<th scope="col">Account Creation Date</th>
					<th scope="col">Active/Disabled Account</th>
				</tr>
			</thead>
			<tbody>
		<?php foreach($users as $row){ ?>
				<tr>
					<td>
						<a href="admin_viewuser.php?id=<?php echo $row['user_id']; ?>"><?php echo $row['user_name']; ?></a>
					</td>
					<td>
						<?php echo $row['user_fname'].' '.$row['user_lname']; ?>
					</td>
					<td>
						<?php echo $row['user_unid']; ?>
					</td>	
					<td>
						<?php echo $row['user_type']; ?>
					</td>
					<td>
						<?php echo timeDisplay($row['user_insertdt']); ?>
					</td>
					<td>
						<?php if($row['user_is_act'] == 1){
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

<!-- script below manages the datatable jQuery logic for the table of users. It controls pagination, sorting, etc. -->
<script>
$(document).ready( function () {
    $('#usertable').DataTable({
		"autoWidth": false
	});
} );
</script>

<?php
	$conn->close();
	require_once "./common/footer.php";
?>