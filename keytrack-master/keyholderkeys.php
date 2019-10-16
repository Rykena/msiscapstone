<?php
$title = "View Keys for Keyholder";
$auth = array('User','Admin','View');

require_once "logincheck.php";
require_once "./common/login.php";
require_once "./common/functions.php";

if(isset($_POST['hold_id'])){
	$conn = new mysqli($hn, $un, $pw, $db);
	
	if($conn->connect_error) die($conn->connect_error);
	
	$hold_id = $_POST['hold_id'];
	
	$hold = selectKeyholder($conn,$hold_id);
	$keys = holderActiveKeys($conn,$hold_id);
	
	$conn->close();
}else{
	header("Location: retrievekeyholder.php");
}

require_once "./common/header.php";
?>

	<!-- About -->
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<h2>Active Keys for <?php echo $hold['hold_fname'].' '.$hold['hold_lname'];?></h2>
			<p>Click on the "Mark as Lost" button next to the desired key to mark that key as lost.<br>
			(<a href="viewkeyholder.php?id=<?php echo $hold['hold_id']; ?>">Cancel and Return to Keyholder Page</a>)</p>
		</div>
	</div>
	<br>
	<div class="row">
		
		<div class="col-sm-12">
		
	<!-- Table of Keys -->
		<table id="keytable" class="table table-striped table-bordered">
			<thead>
				<tr>
	
					<th scope="col">Key Number</th>
					<th scope="col">Checkout Date</th>
					<th scope="col">Due Date</th>
					<th scope="col">Mark as Lost</th>
				</tr>
			</thead>
			<tbody>
		<?php foreach($keys as $row){ ?>
				<tr>
					<td>
						<?php echo $row['key_number']; ?>
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
						<form method='post' action='processlostkey.php'>
							<input type="hidden" name='key_check_id' value='<?php echo $row['key_check_id'];?>'>
							<input type="hidden" name='hold_id' value='<?php echo $row['hold_id'];?>'>
							<input type='submit' value='Mark as Lost' class="btn btn-default">
						</form>
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
	$.fn.dataTable.moment('MM/DD/YYYY');
    $('#keytable').DataTable({
		"autoWidth": false
	});
} );
</script>

<?php
	require_once "./common/footer.php";
?>