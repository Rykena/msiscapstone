<?php
$title = "View Keyholder Historical Checkouts";
$auth = array('User','Admin','View');

require_once "logincheck.php";
require_once "./common/login.php";
require_once "./common/functions.php";

$conn = new mysqli($hn, $un, $pw, $db);

if($conn->connect_error) die($conn->connect_error);

if(isset($_GET['id'])){
	$hold_id = mysql_entities_fix_string($conn, $_GET['id']);
	$is_act = 0;
	
	$kh = selectKeyholder($conn,$hold_id);
	$checkouts = selectPersonKeys($conn,$is_act,$hold_id);
}else{
	header("Location: retrievekeyholder.php");
}

require_once "./common/header.php";
?>

	<!-- About -->
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<h2>Historical/Returned Key Checkouts for <?php echo $kh['hold_fname'].' '.$kh['hold_lname']; ?></h2>
			<p>Table shows all returned keys for this person. (<a href="viewkeyholder.php?id=<?php echo $hold_id; ?>">Return to Keyholder Record</a>)</p>
		</div>
	</div>
	<br>
	<div class="row">
		
		<div class="col-sm-12">
		
	<!-- Table of Checkouts -->
		<table id="checktable" class="table table-striped table-bordered">
			<thead>
				<tr>
					<th scope="col">Key Number</th>
					<th scope="col">Checkout Date</th>
					<th scope="col">Due Date</th>
					<th scope="col">Returned Date</th>
				</tr>
			</thead>
			<tbody>
		<?php foreach($checkouts as $row){ ?>
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
						<?php if(!$row['key_return_dt'] || $row['key_return_dt'] == ''){
							echo "N/A";
						}else{
							echo dateDisplay($row['key_return_dt']);
						} ?>
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