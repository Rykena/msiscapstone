<?php
	
$title = "Finalize Key Checkout";
$auth = array('Admin','User','View');

require_once "logincheck.php";
require_once './common/login.php';
require_once './common/functions.php';

$conn = new mysqli($hn, $un, $pw, $db);

if($conn->connect_error) die($conn->connect_error);

$hold_id = $_SESSION['keyholdid'];

$holder = selectKeyholder($conn,$hold_id);
	
require_once "./common/header.php";

	if(isset($_SESSION['cart']) && (array_count_values($_SESSION['cart']))){
?>
	<!-- page is very similar to checkoutcart.php page, but acts as a checkout verification page. $cart session array used alot -->
<div class="container-fluid">
	<div class="row">
	</div>
	<br>
	<div class="row">
		<div class="col-sm-1">
		</div>
		<div class="col-sm-10">
			<table class="table">
				<tr>
					<th>Key Number</th>
					<th>Description</th>
					<th>Quantity</th>
					<th>Checkout Date</th>
				</tr>
					<?php
						foreach($_SESSION['cart'] as $keyid => $qty){
							$row = selectKey($conn, $keyid);
					?>
				<tr>
					<td><?php echo $row['key_number']; ?></td>
					<td><?php echo $row['key_name']; ?></td>
					<td><?php echo $qty; ?></td>
					<td><?php echo date("m\/d\/Y"); ?></td>
				</tr>
				<?php } ?>
			</table>
		</div>
	</div>

<form method="post" action="processcheckout.php" class="form-horizontal">
	<div class="row">
		<div class="col-sm-1">
		</div>
		<div class="col-sm-10">
			<b>Pick Due Date For Key Return:&nbsp;&nbsp;</b><input type="date" id="duedate" name="duedt" min="2000-01-01"><br>
			(leave date blank if no end date <br>is needed)
		</div>
	</div><br>
	<div class="row" style="margin: 20px;">
		<div class="col-sm-1">
		</div>
		<div class="col-sm-3">
		</div>
		<div class="col-sm-6">
			<h4><u>Keyholder Information</u></h4>
		</div>
	</div>
	<div class="row" style="margin: 20px;">
		<div class="col-sm-1">
		</div>
		<div class="col-sm-4 text-right">
			<b>Org/Company Name:</b>
		</div>
		<div class="col-sm-4">
		<?php echo $holder['hold_name']; ?>
		</div>
	</div>
	<div class="row" style="margin: 20px;">
		<div class="col-sm-1">
		</div>
		<div class="col-sm-4 text-right">
			<b>Person Name:</b>
		</div>
		<div class="col-sm-4">
		<?php echo $holder['hold_fname']." ".$holder['hold_lname']; ?>
		</div>
	</div>
	<div class="row" style="margin: 20px;">
		<div class="col-sm-1">
		</div>
		<div class="col-sm-4 text-right">
			<b>ID Number:</b>
		</div>
		<div class="col-sm-4">
			<?php echo $holder['hold_ident']; ?>
		</div>
	</div>
	<div class="row" style="margin: 20px;">
		<div class="col-sm-1">
		</div>
		<div class="col-sm-4 text-right">
			<b>Email Address:</b>
		</div>
		<div class="col-sm-4">
			<?php echo $holder['hold_email']; ?>
		</div>
	</div>
	<div class="row" style="margin: 20px;">
		<div class="col-sm-1">
		</div>
		<div class="col-sm-4 text-right">
			<b>Phone:</b>
		</div>
		<div class="col-sm-4">
			<?php echo $holder['hold_phone']; ?>
		</div>
	</div>
	<div class="row" style="margin: 20px;">
		<div class="col-sm-1">
		</div>
		<div class="col-sm-8">
			<br><br><p><b>Please press Complete Checkout to finish this key checkout.</b></p>
		</div>
	</div>
	<div class="row" style="margin: 20px;">
		<div class="col-sm-1">
		</div>
		<div class="col-sm-3">
				<input type="submit" name="redeem" value="Complete Checkout" class="btn btn-default">
</form>
		</div>
		<div class="col-sm-2">
			<a href="checkoutcart.php" class="btn btn-default pull-left">Return to Cart</a>	
		</div>
	</div>
<?php
	} else {
		unset($_SESSION['cart']);
		unset($_SESSION['keyholdid']);
		unset($_SESSION['total_items']); 
		?>
	<div class="container-fluid">
		<div class="row">
		</div>
		<br>
		<div class="row">
			<div class="col-sm-1">
			</div>
			<div class="col-sm-10">
				<h2>No Keys in Checkout Basket - Use Navigation Above to Start a New Checkout</h2>
			</div>
		</div>
<?php } ?>
</div>
<script language="javascript" type="text/javascript">
	var today = new Date();
	today.setDate(today.getDate() + 1);
	var dd = today.getDate();
	var mm = today.getMonth()+1; //January is 0!
	var yyyy = today.getFullYear();
	 if(dd<10){
			dd='0'+dd
		} 
		if(mm<10){
			mm='0'+mm
		} 

	today = yyyy+'-'+mm+'-'+dd;
	document.getElementById("duedate").setAttribute("min", today);
</script>	
<?php
	$conn->close(); 
	require_once './common/footer.php';
?>