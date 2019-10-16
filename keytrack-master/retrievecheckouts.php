<?php
$title = "View All Checkouts";
$auth = array('User','Admin','View');

require_once "logincheck.php";
require_once "./common/login.php";
require_once "./common/functions.php";

$conn = new mysqli($hn, $un, $pw, $db);

if($conn->connect_error) die($conn->connect_error);

if(!isset($_POST['is_act'])){
	$is_act = 1;
	$checkouts = selectAllKeyholderWithCheckout($conn,$is_act);
}

if(isset($_POST['is_act'])){
	$is_act = mysql_entities_fix_string($conn,$_POST['is_act']);
	$checkouts = selectAllKeyholderWithCheckout($conn,$is_act);
}

require_once "./common/header.php";
?>

	<!-- About -->
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<h2>Key Checkouts</h2>
			<p>Click on the keyholder's name to go to their account, where you can edit checkouts, issue new keys, and return keys.<br>
			Use the "View Historical/View Current" button at the top of the table to toggle between active key checkouts and historical keys that have been returned.</p>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-sm-4 form-group">
			<b>Currently Viewing <?php if($is_act == 1){echo "ACTIVE";}else{echo "HISTORICAL";} ?> Key Checkout Records</b>
		</div>
		<div class="col-sm-2 form-group">
			<form method="post" action="retrievecheckouts.php">
			<?php if($is_act == 1){ ?>
				<input type="submit" value="View Historical" name="activecheck" class="btn btn-default pull-left">
				<input type="hidden" value="0" name="is_act">
			<?php }else{ ?>
				<input type="submit" value="View Current" name="activecheck" class="btn btn-default pull-left">
				<input type="hidden" value="1" name="is_act">
			<?php } ?>
			</form>
		</div>
		<div class="col-sm-5 form-group">
			(<a href="retrievekeyholder.php">Start a New Key Checkout</a>)
		</div>
	</div>
	<div class="row">
		
		<div class="col-sm-12">
		
	<!-- Table of Checkouts -->
		<table id="checktable" class="table table-striped table-bordered">
			<thead>
				<tr>
					<th scope="col">Org/Company Name</th>
					<th scope="col">First Name</th>
					<th scope="col">Last Name</th>
					<th scope="col">Keyholder Type</th>
					<th scope="col">Phone</th>
					<th scope="col">Email</th>
					<th scope="col">
						<?php if($is_act == 1){ ?>
							Current Active Key Number(s)
						<?php }else{ ?>
							Returned Key Number(s)
						<?php } ?>
					</th>
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
						<?php echo $row['hold_type']; ?>
					</td>
					<td>
						<?php echo $row['hold_phone'];?>
					</td>
					<td>
						<?php echo $row['hold_email'];?>
					</td>
					<td>
						<?php 
							$hold_id = $row['hold_id'];
							$keys = selectPersonKeys($conn,$is_act,$hold_id);
							
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