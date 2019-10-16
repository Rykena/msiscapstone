<?php
$auth = array('Admin');

require_once "logincheck.php";
require_once "./common/login.php";
require_once "./common/functions.php";

if(isset($_POST['activateuser']) || isset($_POST['deactivateuser'])){
	$conn = new mysqli($hn, $un, $pw, $db);

	if($conn->connect_error) die($conn->connect_error);
	
	$user_id = mysql_entities_fix_string($conn, $_POST['userid']);
	
	$act_val = mysql_entities_fix_string($conn, $_POST['useract']);
	
	userActiveSet($conn,$user_id,$act_val);
	
	$conn->close();
	
	header("Location: admin_viewuser.php?id=$user_id");
	
}else{
	header("Location: admin_retrieveusers.php");
}

?>