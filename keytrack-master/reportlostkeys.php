<?php
$title = "Currently Lost Keys";
$auth = array('User','Admin','View');

require_once "logincheck.php";
require_once "./common/login.php";
require_once "./common/functions.php";

$conn = new mysqli($hn, $un, $pw, $db);

if($conn->connect_error) die($conn->connect_error);

$lost_keys = selectLostKeys($conn);

require_once "./common/header.php";
?>

	<!-- About -->
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<h2>Currently Lost Keys</h2>
			<p>Click on the "View Keyholder" link next to the desired record to manage the lost key record.<br>
			(<a href="landingreports.php">Return to Reports Homepage</a>)</p>
		</div>
	</div>
	<br>
	<div class="row">
		
		<div class="col-sm-12">
		
	<!-- Table of lost keys -->
		<table id="keytable" class="table table-striped table-bordered">
			<thead>
				<tr>
	
					<th scope="col">Key Number</th>
					<th scope="col">First Name</th>
					<th scope="col">Last Name</th>
					<th scope="col">Checkout Date</th>
					<th scope="col">Due Date</th>
					<th scope="col">Date Marked as Lost</th>
					<th scope="col">View Keyholder Details</th>					
				</tr>
			</thead>
			<tbody>
		<?php foreach($lost_keys as $row){ ?>
				<tr>
					<td>
						<?php echo $row['key_number']; ?>
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
						<?php if(!$row['key_check_lostdt'] || $row['key_check_lostdt'] == ''){
							echo "N/A";
						}else{
							echo dateDisplay($row['key_check_lostdt']);
						} ?>
					</td>		
					<td>
						<a href="viewkeyholder.php?id=<?php echo $row['hold_id']; ?>">View Keyholder</a>
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
    $('#keytable').DataTable({
		"autoWidth": false
	});
} );
</script>

<?php
	$conn->close();
	require_once "./common/footer.php";
?>