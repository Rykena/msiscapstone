<?php

session_start();

if(!isset($_SESSION['username'])){
	header("Location: index.php");
	exit();
}else{
	
	$user_type = $_SESSION['usertype'];
	
	$found=0;
	foreach($auth as $pageauth){
		if($user_type == $pageauth) $found=1;
	}
	
	if(!$found){
		header("Location: notauth.php");
	}
	
}

?>
	