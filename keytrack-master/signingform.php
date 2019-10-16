<?php
$title = "Signature Form";
$auth = array('Admin','User','View');

require_once "logincheck.php";
require_once "./common/login.php";
require_once "./common/functions.php";

if(isset($_GET['id'])){
	$checkout_id = htmlentities($_GET['id']);
	$conn = new mysqli($hn, $un, $pw, $db);

	if($conn->connect_error) die($conn->connect_error);
	
	$checkout = selectCheckout($conn,$checkout_id);
	
	$keys = selectCheckoutKeys($conn,$checkout_id);
	
	$conn->close();
}else{
	echo <<<__END
	<script>
		window.close();
	</script>
__END;
}

?>
<html>
<head>
	<title>
		University Student Apartments Key Checkout Signature Form
	</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="./css/styles.css" >
</head>
<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-10">
				<h3>USA Key Checkout Signature Form For Checkout # <?php echo $checkout['checkout_id']; ?></h3><br><br>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-10">
				Org/Department: <b>
				<?php if($checkout['hold_name'] == '' || $checkout['hold_name'] == ' '){
							echo "N/A";
						}else{
							echo $checkout['hold_name'];
						} 
				?></b>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-10">
				Person's Name: <b>
				<?php if($checkout['hold_fname'] == '' || $checkout['hold_fname'] == ' '){
							echo "N/A";
						}else{
							echo $checkout['hold_fname'].' '.$checkout['hold_lname'];
						} 
				?></b>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-10">
				Email: <b>
				<?php if($checkout['hold_email'] == '' || $checkout['hold_email'] == ' '){
							echo "N/A";
						}else{
							echo $checkout['hold_email'];
						} 
				?></b>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-10">
				Phone: <b>
				<?php if($checkout['hold_phone'] == '' || $checkout['hold_phone'] == ' '){
							echo "N/A";
						}else{
							echo $checkout['hold_phone'];
						} 
				?></b>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-10">
				Key Issue Date: <b>
				<?php if($checkout['checkout_startdt'] == '' || $checkout['checkout_startdt'] == ' '){
							echo "N/A";
						}else{
							echo dateDisplay($checkout['checkout_startdt']);
						} 
				?></b>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-10">
				Keys Due By Date: <b>
				<?php if($checkout['checkout_duedt'] == '' || $checkout['checkout_duedt'] == ' '){
							echo "N/A";
						}else{
							echo dateDisplay($checkout['checkout_duedt']);
						} 
				?></b>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-10">
				<br><b><u>Keys in this Checkout</u></b><br>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-10">
				<table class="table table-bordered">
					<thead>
						<tr>
							<th scope="col">Key Number</th>
							<th scope="col">Description</th>
							<th scope="col">Key Type</th>
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
						</tr>
				<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
		<br><br>
		<div class="row">
			<div class="col-sm-10">
				Signature of Keyholder: <span style="border-bottom: 1px solid black; padding-left: 280px">&nbsp;</span><br><br><br>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-10">
				Signature of USA Employee: <span style="border-bottom: 1px solid black; padding-left: 250px">&nbsp;</span>
			</div>
		</div>
	</div>
	<script>
		$(document).ready(function () {
			window.print();
			window.close();
		});
	</script>
</body>
</html>

