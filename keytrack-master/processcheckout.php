<?php

//page processes an order and then moves to the complete page - protects the logic from refreshed browsers
$title = "Shopping Cart";
$auth= array('Admin','User','View');

require_once "logincheck.php";
require_once './common/login.php';
require_once './common/functions.php';

$conn = new mysqli($hn, $un, $pw, $db);

if($conn->connect_error) die($conn->connect_error);

if(isset($_POST['redeem']))
{
	$hold_id = mysql_entities_fix_string($conn, $_SESSION['keyholdid']);
	$duedt = mysql_entities_fix_string($conn, $_POST['duedt']);
	$user_id = mysql_entities_fix_string($conn, $_SESSION['userid']);
	
	if(!$duedt || $duedt == '' || $duedt == ' '){
		$query = "INSERT into checkout (checkout_startdt, hold_id, user_id) 
		values (now(),'$hold_id','$user_id')";
	}else{
		$query = "INSERT into checkout (checkout_startdt, checkout_duedt, hold_id, user_id) 
		values (now(),'".$duedt."','$hold_id','$user_id')";
	}
	
	$result = $conn->query($query);

	if(!$result) die($conn->error);
	
	$checkout_id = mysqli_insert_id($conn);
	
	foreach($_SESSION['cart'] as $key => $qty){
		
		$query2 = "INSERT into key_checkout (key_check_qty, key_id, checkout_id) 
		values ('$qty','$key','$checkout_id')";
		$result2 = $conn->query($query2);
		if(!$result2) die($conn->error);
		
	}
	
	$conn->close();
	
	unset($_SESSION['cart']);
	unset($_SESSION['total_items']);
	unset($_SESSION['keyholdid']);
	unset($_POST['redeem']);
	
	header("Location: checkout_complete.php?id=$checkout_id");
}else{
	$conn->close();
	header("Location: checkoutcart.php");
}

?>