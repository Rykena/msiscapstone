<?php

/* This is where session timeout is checked and session ends if timeout duration is exceeded - forcing a new login. include on all main landing pages just 
	above header include call.
	
	Currently included on: index.php, admin_tools.php, 
*/

$time = $_SERVER['REQUEST_TIME'];
$timeout_duration = 43200; //12 hours

if(isset($_SESSION['LOGIN_TIME']) && ($time - $_SESSION['LOGIN_TIME']) > $timeout_duration){
	destroy_session_and_data();
	session_start();
}

?>