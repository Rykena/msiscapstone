<?php
$title = "Select Key to Checkout";
$auth = array('Admin','User','View');

require_once "logincheck.php";
require_once "./common/login.php";
require_once "./common/functions.php";

if(!isset($_SESSION['keyholdid'])){
	if(isset($_POST['hold_id'])){
		$_SESSION['keyholdid'] = htmlentities($_POST['hold_id']);
	}else{
		header("Location: retrievekeyholder.php");	
	}
}

if(isset($_SESSION['keyholdid'])){
	if(isset($_POST['hold_id'])){
		if($_SESSION['keyholdid'] != $_POST['hold_id']){
			unset($_SESSION['cart']);
			unset($_SESSION['total_items']);
			unset($_SESSION['keyholdid']);
			
			$_SESSION['keyholdid'] = htmlentities($_POST['hold_id']);
		}
	}
}

$conn = new mysqli($hn, $un, $pw, $db);

if($conn->connect_error) die($conn->connect_error);

$hold_id = $_SESSION['keyholdid'];

$holder = selectKeyholder($conn,$hold_id);

$keys = selectAllKeys($conn);

require_once "./common/header.php";
?>

	<!-- About -->
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-8">
			<h2>Select Key to Add to Checkout</h2>
			<p>Click on the "Add Key" button below to add the key to the checkout form.</p>
		</div>
	<?php if(isset($_SESSION['cart'])){ ?>
		<div class="col-sm-4">
			<h2><span class="glyphicon glyphicon-shopping-cart red-icon"></span>&nbsp;&nbsp;<a href='checkoutcart.php'>View Checkout Cart</a></h2>
		</div>
	<?php } ?>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<h3>Adding key to checkout for: <b>"<?php echo $holder['hold_fname'].' '.$holder['hold_lname']; ?>"</b></h3><br>
		</div>
	</div>
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
					<th scope="col">Add to Checkout</th>
				</tr>
			</thead>
			<tbody>
		<?php foreach($keys as $row){ ?>
				<tr>
					<td>
						<?php echo $row['key_number']; ?>
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
						<form action='checkoutcart.php' method='post'>
							<input type="hidden" name="addkey" value="yes">
							<input type="hidden" name="key_id" value="<?php echo $row['key_id']; ?>">
							<input type='submit' value='Add Key to Checkout' class="btn btn-default">
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
    $('#keytable').DataTable({
		"autoWidth": false
	});
} );
</script>

<?php
	$conn->close();
	require_once "./common/footer.php";
?>