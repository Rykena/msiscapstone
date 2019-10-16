<?php
$title = "Logged Out";
require_once "./common/login.php";
require_once "./common/functions.php";

session_start();
if(isset($_SESSION['username']))
{	
	destroy_session_and_data();	
}

require_once "./common/header.php";
?>
	
	<!-- Signed Out -->
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-1">
			</div>
			<div class="col-sm-11">
				<h3>Logged Out</h3>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-sm-2">
			</div>
			<div class="col-sm-10">
				<h4>You have been successfully logged out.</h4>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-2">
			</div>
			<div class="col-sm-10">
				<h4><a href="index.php">Return to Homepage</a></h4>
			</div>
		</div>
	</div>
	
<?php
	require_once "./common/footer.php";
?>