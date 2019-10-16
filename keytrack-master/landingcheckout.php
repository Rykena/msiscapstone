<?php
$title = "Key Checkout Landing Page";
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
			<h2>Key Checkout Process Home</h2>
		</div>	
	</div>
	
	<!-- Checkout Links -->
	<div class="row">
		<div class="col-sm-1">
		</div>
		<div class="col-sm-8">
			<p>Please select from a menu option below to continue.</p><br>
			<span class="glyphicon glyphicon-list-alt red-icon"></span>&nbsp; <a href="retrievekeyholder.php">New Key Checkout / Keyholder Select</a><br><br>
			<span class="glyphicon glyphicon-search red-icon"></span>&nbsp; <a href="retrievecheckouts.php">View Current Checkouts</a><br><br><br>
			<span class="glyphicon glyphicon-chevron-left red-icon"></span>&nbsp; <a href="index.php">Return to Home Page</a>
			
		</div>
	</div>
</div>
<?php
	require_once "./common/footer.php";
?>