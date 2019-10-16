<?php
$auth = array('Admin','User','View');

require_once "logincheck.php";
require_once "./common/login.php";
require_once "./common/functions.php";

if(isset($_POST['activatekeyholder']) || isset($_POST['deactivatekeyholder'])){
	$conn = new mysqli($hn, $un, $pw, $db);

	if($conn->connect_error) die($conn->connect_error);
	
	$hold_id = mysql_entities_fix_string($conn, $_POST['holdid']);
	
	$act_val = mysql_entities_fix_string($conn, $_POST['holdact']);
	
	keyholderActiveSet($conn,$hold_id,$act_val);
	
	$conn->close();
	
	header("Location: viewkeyholder.php?id=$hold_id");
	
}else{
	header("Location: retrievekeyholder.php");
}

?>