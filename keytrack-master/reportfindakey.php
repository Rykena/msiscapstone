<?php
$title = "Found a Key";
$auth = array('User','Admin','View');

require_once "logincheck.php";
require_once "./common/login.php";
require_once "./common/functions.php";

$conn = new mysqli($hn, $un, $pw, $db);

if($conn->connect_error) die($conn->connect_error);

$key_num = 'N/A';

$keys = array();

if(isset($_POST['key_num'])){
	$key_num = $_POST['key_num'];
	$keys = findKey($conn,$key_num);
}

require_once "./common/header.php";
?>

	<!-- About -->
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<h2>Found a Key/Where Does Key Belong?</h2>
			<p>Enter a Key Number into the Search field to find locations and keyholders it might be assigned to.<br>
			(<a href="landingreports.php">Return to Reports Homepage</a>)</p>
		</div>
	</div>
	<br>
	<form method="post" action="reportfindakey.php">
	<div class="row">
		<div class="col-sm-1">
		</div>
		<div class="col-sm-2 text-right">
			<b>Enter Key Number:</b>
		</div>
		<div class="col-sm-2">
				<input type="search" style="width: 8em" name="key_num" placeholder="Enter key #" required>
		</div>
		<div class="col-sm-2">	
				<input type="submit" value="Search" name="search" class="btn btn-default pull-left">
		</div>
		<div class="col-sm-4">
			Current Key Number: <b><?php echo strtoupper($key_num); ?></b>
		</div>
	</div>
	</form>
	<br>
	<div class="row">
		
		<div class="col-sm-12">
		
	<!-- Table of keys -->
		<table id="keytable" class="table table-striped table-bordered">
			<thead>
				<tr>
					<th scope="col">Key Number</th>
					<th scope="col">Person or Location Info</th>
					<th scope="col">Assign or Checkout Date</th>
					<th scope="col">Link to Entity</th>
				</tr>
			</thead>
			<tbody>
		<?php foreach($keys as $row){ ?>
				<tr>
					<td>
						<?php echo $row['key_number']; ?>
					</td>
					<td>
						<?php if($row['res_type'] == 'chk'){
							$hold = selectKeyholder($conn,$row['res_entid']);
							echo 'Person: '.$hold['hold_fname'].' '.$hold['hold_lname'].' ('.$hold['hold_type'].')';
						}elseif($row['res_type'] == 'unit'){
							$loc = selectLocation($conn,$row['res_entid']);
							echo 'Location: '.$loc['loc_unit_num'].' ('.$loc['loc_type'].')';
						}else{
							echo "N/A";
						} ?>
					</td>
					<td>
						<?php if(!$row['res_start'] || $row['res_start'] == ''){
							echo "N/A";
						}else{
							echo dateDisplay($row['res_start']);
						} ?>
					</td>
					<td>
						<?php if($row['res_type'] == 'chk'){ ?>
							<a href="viewkeyholder.php?id=<?php echo $row['res_entid']; ?>">View this Keyholder</a>
						<?php }elseif($row['res_type'] == 'unit'){ ?>
							<a href="viewlocation.php?id=<?php echo $row['res_entid']; ?>">View this Location</a>
						<?php }else{ ?>
							"N/A"
						<?php } ?>
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
	$conn->close();
	require_once "./common/footer.php";
?>