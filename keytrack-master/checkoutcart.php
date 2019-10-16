<?php
	
$title = "Shopping Cart";
$auth= array('Admin','User','View');

require_once "logincheck.php";
require_once './common/login.php';
require_once './common/functions.php';

$conn = new mysqli($hn, $un, $pw, $db);

if($conn->connect_error) die($conn->connect_error);

if(isset($_POST['key_id'])){
	$key_id = mysql_entities_fix_string($conn, $_POST['key_id']);
}

if(isset($key_id)){
	
	if(!isset($_SESSION['cart'])){
		$_SESSION['cart'] = array();

		$_SESSION['total_items'] = 0;
	}

	if(!isset($_SESSION['cart'][$key_id])){
		$_SESSION['cart'][$key_id] = 1;
	} elseif(isset($_POST['cart'])){
		$_SESSION['cart'][$key_id]++;
		unset($_POST);
	}
}

if(isset($_SESSION['cart']) && isset($_POST['save_change'])){
	
	foreach($_SESSION['cart'] as $keyid =>$qty){
		if($_POST[$keyid] == '0'){
			unset($_SESSION['cart']["$keyid"]);
		} else {
			$_SESSION['cart']["$keyid"] = $_POST["$keyid"];
		}
	}
	
}


require_once "./common/header.php";

if(isset($_SESSION['cart']) && (array_count_values($_SESSION['cart']))){
	$_SESSION['total_items'] = total_items($_SESSION['cart']);
?>
<!-- page is the shopping cart for the site. Uses a $cart session array to track what the user has added/removed. very busy page -->
<div class="container-fluid">
	<div class="row">
	</div>
	<br>
	<div class="row">
		<div class="col-sm-1">
		</div>
		<div class="col-sm-10">
	<form action="checkoutcart.php" method="post">
	   	<table class="table">
	   		<tr>
	   			<th>Key Number</th>
	   			<th>Description</th>
	  			<th>Quantity</th>
				<th>Checkout Date</th>
	   		</tr>
	   		<?php
		    	foreach($_SESSION['cart'] as $keyid => $qty){
					$row = selectKey($conn,$keyid);
			?>
			<tr>
				<td><?php echo $row['key_number'];?></td>
				<td><?php echo $row['key_name']; ?></td>
				<td><input type="number" style="width: 3em" pattern="[0-9]{3}" min="0" value="<?php echo $qty; ?>" max="25" name="<?php echo $keyid; ?>" required></td>
				<td><?php echo date("m\/d\/Y"); ?></td>
			</tr>
			<?php } ?>
	   	</table>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-sm-1">
		</div>
		<div class="col-sm-2">
			<input type="submit" class="btn btn-default" name="save_change" value="Save Changes">
		</div>
	</form>
		<div class="col-sm-2">
			<a href="newcheckout.php" class="btn btn-default pull-left">Add Another Key</a>
		</div>
		<div class="col-sm-2">
			<a href="finishcheckout.php" class="btn btn-default pull left">Finalize Checkout</a>
		</div>
	</div>
	<br><br>
	<div class="row">
		<div class="col-sm-1">
		</div>
		<div class="col-sm-10">
			<p>To remove a key from the cart, set the quantity to zero and click "Save Changes". 
			<br>To empty the cart, set all quantities to zero and click "Save Changes".</p>
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
<?php
	$conn->close(); 
	require_once "./common/footer.php";
?>