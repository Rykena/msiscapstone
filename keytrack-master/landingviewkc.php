<?php
$title = "Key/Core Landing Page";
$auth = array('Admin','User','View');

require_once "logincheck.php";
require_once "./common/login.php";
require_once "./common/functions.php";

require_once "./common/sessiontimeout.php";
	
require_once "./common/header.php";
?>
	
	<!-- About -->
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<h2>Key/Core Home</h2>
		</div>	
	</div>
	
	<!-- Key/Core Links -->
	<div class="row">
		<div class="col-sm-1">
		</div>
		<div class="col-sm-8">
			<p>Please select from a menu option below to continue.</p><br>
			<span class="glyphicon glyphicon-filter red-icon"></span>&nbsp; <a href="retrievekeys.php">View Key Records</a><br><br>
			<span class="glyphicon glyphicon-wrench red-icon"></span>&nbsp; <a href="retrievecores.php">View Core Records</a><br><br><br>
			<span class="glyphicon glyphicon-chevron-left red-icon"></span>&nbsp; <a href="index.php">Return to Home Page</a>
			
		</div>
	</div>
</div>
<?php
	require_once "./common/footer.php";
?>