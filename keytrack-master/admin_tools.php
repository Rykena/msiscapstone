<?php
$title = "Admin Home";
$auth = array('Admin');

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
			<h2>Admin Tools Home</h2>
		</div>	
	</div>
	
	<!-- Admin Links -->
<div class="col-sm-4">
	<div class="row">
		<div class="col-sm-2">
		</div>
		<div class="col-sm-10">
			<span class="glyphicon glyphicon-user red-icon"></span>&nbsp; <a href="admin_retrieveusers.php">Manage System Users</a>
		</div>	
	</div><br>
	<div class="row">
		<div class="col-sm-2">
		</div>
		<div class="col-sm-10">
			<span class="glyphicon glyphicon-wrench red-icon"></span>&nbsp; <a href="admin_retrievecores.php">Manage Cores</a>
		</div>	
	</div><br>
	<div class="row">
		<div class="col-sm-2">
		</div>
		<div class="col-sm-10">
			<span class="glyphicon glyphicon-filter red-icon"></span>&nbsp; <a href="admin_retrievekeys.php">Manage Keys</a>
		</div>	
	</div><br>
	<div class="row">
		<div class="col-sm-2">
		</div>
		<div class="col-sm-10">
			<span class="glyphicon glyphicon-home red-icon"></span>&nbsp; <a href="admin_retrievelocations.php">Manage Locations/Units</a>
		</div>	
	</div><br>
	<div class="row">
		<div class="col-sm-2">
		</div>
		<div class="col-sm-10">
			<span class="glyphicon glyphicon-object-align-bottom red-icon"></span>&nbsp; <a href="admin_retrievebuildings.php">Manage Buildings</a>
		</div>	
	</div><br><br><br>
	<div class="row">
		<div class="col-sm-2">
		</div>
		<div class="col-sm-10">
			<span class="glyphicon glyphicon-chevron-left red-icon"></span>&nbsp; <a href="index.php">Return to Home Page</a>
		</div>	
	</div>
</div>
<div class="col-sm-6">
	<div class="row">
		<div class="col-sm-2">
		</div>
		<div class="col-sm-10">
			<span class="glyphicon glyphicon-filter red-icon"></span>/<span class="glyphicon glyphicon-user red-icon"></span>&nbsp; 
			<a href="admin_retrievekeykeyholders.php">Manage Existing Key-Keyholder Relationships</a>
		</div>	
	</div><br>
	<div class="row">
		<div class="col-sm-2">
		</div>
		<div class="col-sm-10">
			<span class="glyphicon glyphicon-filter red-icon"></span>/<span class="glyphicon glyphicon-home red-icon"></span>&nbsp; 
			<a href="admin_retrievekeylocations.php">Manage Existing Key-Location Relationships</a>
		</div>	
	</div><br>
</div>
	
	
</div>

<?php
	require_once "./common/footer.php";
?>