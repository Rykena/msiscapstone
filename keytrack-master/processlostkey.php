<?php

//page processes a lost key record and returns to the keyholder
$title = "Process Lost Key";
$auth= array('Admin','User','View');

require_once "logincheck.php";
require_once './common/login.php';
require_once './common/functions.php';

$conn = new mysqli($hn, $un, $pw, $db);

if($conn->connect_error) die($conn->connect_error);

if(isset($_POST['key_check_id']))
{
	$hold_id = mysql_entities_fix_string($conn, $_POST['hold_id']);
	$key_check_id = mysql_entities_fix_string($conn, $_POST['key_check_id']);
	
	$query = "UPDATE key_checkout set key_check_lostdt= now(), key_check_lost_return=NULL where key_check_id = '$key_check_id'";
	
	$result = $conn->query($query);
	
	if(!$result) die($conn->error);
	
	$conn->close();
	
	unset($_POST['key_check_id']);
	unset($_POST['hold_id']);
	
	header("Location: viewkeyholder.php?id=$hold_id");
}else{
	$conn->close();
	header("Location: retrievekeyholder.php");
}

?>