<?php
$auth = array('Admin');

require_once "logincheck.php";
require_once "./common/login.php";
require_once "./common/functions.php";

if(isset($_POST['activatecore']) || isset($_POST['deactivatecore'])){
	$conn = new mysqli($hn, $un, $pw, $db);

	if($conn->connect_error) die($conn->connect_error);
	
	$core_id = mysql_entities_fix_string($conn, $_POST['coreid']);
	
	$act_val = mysql_entities_fix_string($conn, $_POST['coreact']);
	
	coreActiveSet($conn,$core_id,$act_val);
	
	$conn->close();
	
	header("Location: admin_viewcore.php?id=$core_id");
	
}else{
	header("Location: admin_retrievecores.php");
}

?>