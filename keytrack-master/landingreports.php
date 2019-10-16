<?php
$title = "Reports Landing Page";
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
			<h2>Reports Home</h2>
		</div>	
	</div>
	
	<!-- Reports Links -->
	<div class="row">
		<div class="col-sm-1">
		</div>
		<div class="col-sm-8">
			<p>Please select from a report option below to view.</p><br>
			<span class="glyphicon glyphicon-exclamation-sign red-icon"></span>&nbsp; <a href="reportoverduekeys.php">Overdue Key Checkouts</a><br><br>
			<span class="glyphicon glyphicon-flag red-icon"></span>&nbsp; <a href="reportupcomingkeysdue.php">Keys Due within Given # of Days</a><br><br>
			<span class="glyphicon glyphicon-search red-icon"></span>&nbsp; <a href="reportfindakey.php">Found a Key/Where Does Key Belong?</a><br><br>
			<span class="glyphicon glyphicon-exclamation-sign red-icon"></span>&nbsp; <a href="reportlostkeys.php">Current Lost Keys</a><br><br>
			<span class="glyphicon glyphicon-calendar red-icon"></span>&nbsp; <a href="reportlastcorechange.php">Date Current Core Installed in Unit</a><br><br>
			<span class="glyphicon glyphicon-envelope red-icon"></span>&nbsp; <a href="reportmailboxes.php">Unit Mailbox Assignments</a><br><br><br>
			<span class="glyphicon glyphicon-chevron-left red-icon"></span>&nbsp; <a href="index.php">Return to Home Page</a>
			
		</div>
	</div>
</div>
<?php
	require_once "./common/footer.php";
?>