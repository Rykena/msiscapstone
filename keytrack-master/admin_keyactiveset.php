<?php
$auth = array('Admin');

require_once "logincheck.php";
require_once "./common/login.php";
require_once "./common/functions.php";

if(isset($_POST['activatekey']) || isset($_POST['deactivatekey'])){
	$conn = new mysqli($hn, $un, $pw, $db);

	if($conn->connect_error) die($conn->connect_error);
	
	$key_id = mysql_entities_fix_string($conn, $_POST['keyid']);
	
	$act_val = mysql_entities_fix_string($conn, $_POST['keyact']);
	
	keyActiveSet($conn,$key_id,$act_val);
	
	$conn->close();
	
	header("Location: admin_viewkey.php?id=$key_id");
	
}else{
	header("Location: admin_retrievekeys.php");
}

?>