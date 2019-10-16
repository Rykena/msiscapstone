<?php
$auth = array('Admin');

require_once "logincheck.php";
require_once "./common/login.php";
require_once "./common/functions.php";

if(isset($_POST['activatebuild']) || isset($_POST['deactivatebuild'])){
	$conn = new mysqli($hn, $un, $pw, $db);

	if($conn->connect_error) die($conn->connect_error);
	
	$bldg_id = mysql_entities_fix_string($conn, $_POST['bldgid']);
	
	$act_val = mysql_entities_fix_string($conn, $_POST['buildact']);
	
	buildActiveSet($conn,$bldg_id,$act_val);
	
	$conn->close();
	
	header("Location: admin_viewbuilding.php?id=$bldg_id");
	
}else{
	header("Location: admin_retrievebuildings.php");
}

?>