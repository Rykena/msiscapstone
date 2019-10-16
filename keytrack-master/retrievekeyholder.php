<?php
$title = "Retrieve Keyholders";
$auth = array('Admin','User','View');

require_once "logincheck.php";
require_once "./common/login.php";
require_once "./common/functions.php";

$conn = new mysqli($hn, $un, $pw, $db);

if($conn->connect_error) die($conn->connect_error);

$keyholders = selectAllKeyholders($conn);

require_once "./common/header.php";
?>

	<!-- About -->
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<h2>Keyholders</h2>
			<p>Click on a keyholder's first name below to manage that person's record
			, or the "New Key Checkout" button to issue a key to that person.<br>
			If the person is not listed, click on the "Create a New Keyholder" link to create the new account.
			</p>
		</div>
	</div>
		<p class="text-left text-muted">(<a href="addkeyholder.php">Create a New Keyholder</a>)</p>
	<br>
	<div class="row">
		
		<div class="col-sm-12">
	<!-- Table of Cores -->
		<table id="khtable" class="table table-striped table-bordered">
			<thead>
				<tr>
					<th scope="col">Company Name</th>
					<th scope="col">First Name</th>
					<th scope="col">Last Name</th>
					<th scope="col">Email</th>
					<th scope="col">Phone</th>
					<th scope="col">Keyholder Type</th>
					<th scope="col">New Checkout</th>
				</tr>
			</thead>
			<tbody>
		<?php foreach($keyholders as $row){ ?>
				<tr>
					<td>
						<?php echo $row['hold_name']; ?></a>
					</td>
					<td>
						<a href="viewkeyholder.php?id=<?php echo $row['hold_id']; ?>"><?php echo $row['hold_fname']; ?></a>
					</td>
					<td>
						<?php echo $row['hold_lname']; ?>
					</td>
					<td>
						<?php echo $row['hold_email']; ?>
					</td>
					<td>
						<?php echo $row['hold_phone']; ?>
					</td>
					<td>
						<?php echo $row['hold_type']; ?>
					</td>
					<!--Creates a new checkout with the keyholder ID automatically sent to the new checkout page; new checkout page should have functionality to accept the variable-->
					<td>
					<form method='post' action='newcheckout.php'>
						<input type="hidden" name="new">
						<input type="hidden" name='hold_id' value='<?php echo $row['hold_id'];?>'>
						<input type='submit' value='New Key Checkout' class="btn btn-default">
					</form>
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
    $('#khtable').DataTable({
		"autoWidth": false
	});
} );
</script>

<?php
	$conn->close();
	require_once "./common/footer.php";
?>