<?php

//page processes the rekey and then moves to the complete page - protects the logic from refreshed browsers
$title = "Rekey Process";
$auth= array('Admin','User');

require_once "logincheck.php";
require_once './common/login.php';
require_once './common/functions.php';

$conn = new mysqli($hn, $un, $pw, $db);

if($conn->connect_error) die($conn->connect_error);

if(isset($_POST['rekeyprocess']))
{
	$loc_id = mysql_entities_fix_string($conn, $_POST['loc_id']);
	$key_id = mysql_entities_fix_string($conn, $_POST['key_id']);
	$key_qty = mysql_entities_fix_string($conn, $_POST['key_qty']);
	$old_key_loc_id = mysql_entities_fix_string($conn, $_POST['old_key_loc_id']);
	$user_id = mysql_entities_fix_string($conn, $_SESSION['userid']);
	$change_dt = mysql_entities_fix_string($conn, $_POST['changedt']);
	
	if(!$old_key_loc_id || $old_key_loc_id == ''){
		
	}else{
		$query = "UPDATE key_loc set key_loc_enddt= '".$change_dt."' where key_loc_id = '$old_key_loc_id'";
		$result = $conn->query($query);
		if(!$result) die($conn->error);
	}
	
	$query2 = "INSERT into key_loc (key_loc_startdt, key_loc_qty, key_id, loc_id, user_id) 
		values ('".$change_dt."','$key_qty','$key_id','$loc_id','$user_id')";
	$result2 = $conn->query($query2);

	if(!$result2) die($conn->error);
	
	$key_loc_id = mysqli_insert_id($conn);
	
	$conn->close();
	
	unset($_POST['rekeyprocess']);
	unset($_POST['loc_id']);
	unset($_POST['key_id']);
	unset($_POST['key_qty']);
	unset($_POST['old_key_loc_id']);
	unset($_POST['changedt']);
	
	header("Location: rekey_complete.php?id=$key_loc_id");
}else{
	$conn->close();
	header("Location: retrievelocations.php");
}

?>