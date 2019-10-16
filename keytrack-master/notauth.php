<?php
	
	$title = "Not Authorized";
	session_start();
	
	require "./common/header.php";
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-1">
		</div>
		<div class="col-sm-11">
			<h3><b>Not Authorized</b></h3>
		</div>
	
	</div>
	<br>
	<div class="row">
		<div class="col-sm-1">
		</div>
		<div class="col-sm-11">
			<p> The page you attempted to access is not authorized for your account. Please return to the <a href="index.php">home page</a>. </p>
		</div>
	</div>
</div>
<?php
	require_once "./common/footer.php";
?>