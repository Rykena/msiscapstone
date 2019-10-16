<?php
$title = "Admin: Manage Key-Keyholder Relationships";
$auth = array('Admin');

require_once "logincheck.php";
require_once "./common/login.php";
require_once "./common/functions.php";

$conn = new mysqli($hn, $un, $pw, $db);

if($conn->connect_error) die($conn->connect_error);

$is_act = 2;
$checkouts = selectAllCheckouts($conn,$is_act);

require_once "./common/header.php";
?>

	<!-- About -->
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<h2>Admin: Manage Key Checkouts</h2>
			<p>Click on the "Edit Dates" button next to the desired record to edit dates for that key checkout.</p>
		</div>
	</div>
	<br>
	<div class="row">
		
		<div class="col-sm-12">
		
	<!-- Table of Checkouts -->
		<table id="checktable" class="table table-striped table-bordered">
			<thead>
				<tr>
	
					<th scope="col">Org/Company Name</th>
					<th scope="col">First Name</th>
					<th scope="col">Last Name</th>
					<th scope="col">Checkout Date</th>
					<th scope="col">Due Date</th>
					<th scope="col">Returned Date</th>
					<th scope="col">Key Number(s)</th>
					<th scope="col">Edit Dates</th>
				</tr>
			</thead>
			<tbody>
		<?php foreach($checkouts as $row){ ?>
				<tr>
					<td>
						<?php echo $row['hold_name']; ?>
					</td>
					<td>
						<?php echo $row['hold_fname']; ?>
					</td>
					<td>
						<?php echo $row['hold_lname']; ?>
					</td>
					<td>
						<?php if(!$row['checkout_startdt'] || $row['checkout_startdt'] == ''){
							echo "N/A";
						}else{
							echo dateDisplay($row['checkout_startdt']);
						} ?>
					</td>
					<td>
						<?php if(!$row['checkout_duedt'] || $row['checkout_duedt'] == ''){
							echo "N/A";
						}else{
							echo dateDisplay($row['checkout_duedt']);
						} ?>
					</td>
					<td>
						<?php if(!$row['checkout_enddt'] || $row['checkout_enddt'] == ''){
							echo "N/A";
						}else{
							echo dateDisplay($row['checkout_enddt']);
						} ?>
					</td>
					<td>
						<?php $keys = selectCheckoutKeys($conn,$row['checkout_id']);
							$keyout = '';
							foreach($keys as $key){
								$keyout = $keyout.$key['key_number'].', ';
							}
							echo substr($keyout, 0, -2); ?>
					</td>		
					<td>
						<form method='post' action='admin_editcheckout.php'>
							<input type="hidden" name='checkout_id' value='<?php echo $row['checkout_id'];?>'>
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

<!-- script below manages the datatable jQuery logic for the table of checkouts. It controls pagination, sorting, etc. -->
<script>
$(document).ready( function () {
	$.fn.dataTable.moment('MM/DD/YYYY');
    $('#checktable').DataTable({
		"autoWidth": false
	});
} );
</script>

<?php
	$conn->close();
	require_once "./common/footer.php";
?>