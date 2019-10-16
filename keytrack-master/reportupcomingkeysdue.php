<?php
$title = "Keys Due Soon";
$auth = array('User','Admin','View');

require_once "logincheck.php";
require_once "./common/login.php";
require_once "./common/functions.php";

$conn = new mysqli($hn, $un, $pw, $db);

if($conn->connect_error) die($conn->connect_error);

$checkouts = array();

if(!isset($_POST['days'])){
	$due_dt = " 'N/A' ";
	
}elseif(isset($_POST['days'])){
	$due_dt = mysql_entities_fix_string($conn, $_POST['days']);
	
	if($due_dt == ''){
		$due_dt = " 'N/A' ";
		//$checkouts = array();
	}else{
		$checkouts = selectAllCheckoutsByDueDate($conn,$due_dt);
	}
	unset($_POST['days']);
}

require_once "./common/header.php";
?>
	<!-- About -->
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<h2>Key Checkouts Due within the next <?php echo $due_dt; ?> Days</h2>
			<p>Select the number of "days ahead" from today's date to look for keys that will be due between today and that date.</p>
		<?php if($checkouts){ ?>	
			<p>Click on the person's first name to view more information on their record, or to view all their keys.<br>
		<?php } ?>	
			(<a href="landingreports.php">Return to Reports Homepage</a>)</p>
		</div>
	</div>
	<br>
	<form action="reportupcomingkeysdue.php" method="post">
	<div class="row">
		<div class="col-sm-1">	
		</div>
		<div class="col-sm-3 text-right">
			Enter Number of Days to Look Ahead:&nbsp;
		</div>		
		<div class="col-sm-1">		
			<input type="number" style="width: 4em" pattern="[0-9]{3}" name="days">
		</div>
		<div class="col-sm-2">		
			<input type="submit" value="Run Report" name="selectdays" class="btn btn-default pull-left">
		</div>
	</div>
	</form>
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
					<th scope="col">Key Number(s)</th>					
				</tr>
			</thead>
			<tbody>
		<?php foreach($checkouts as $row){ ?>
				<tr>
					<td>
						<?php echo $row['hold_name']; ?>
					</td>
					<td>
						<a href="viewkeyholder.php?id=<?php echo $row['hold_id']; ?>"><?php echo $row['hold_fname']; ?></a>
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
						<?php $keys = selectActiveCheckoutKeys($conn,$row['checkout_id']);
							$keyout = '';
							foreach($keys as $key){
								$keyout = $keyout.$key['key_number'].', ';
							}
							echo substr($keyout, 0, -2); ?>
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