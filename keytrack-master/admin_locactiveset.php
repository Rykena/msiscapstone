<?php
$auth = array('Admin');

require_once "logincheck.php";
require_once "./common/login.php";
require_once "./common/functions.php";

if(isset($_POST['activateloc']) || isset($_POST['deactivateloc'])){
	$conn = new mysqli($hn, $un, $pw, $db);

	if($conn->connect_error) die($conn->connect_error);
	
	$loc_id = mysql_entities_fix_string($conn, $_POST['locid']);
	
	$act_val = mysql_entities_fix_string($conn, $_POST['locact']);
	
	locationActiveSet($conn,$loc_id,$act_val);
	
	$conn->close();
	
	header("Location: admin_viewlocation.php?id=$loc_id");
	
}else{
	header("Location: admin_retrievelocations.php");
}

?>