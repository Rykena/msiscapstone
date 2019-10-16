<?php

//page is the landing page after a key checkout is done - protects the actual order page from refresh issues.
$title = "Checkout Complete";
$auth= array('Admin','User','View');

require_once "logincheck.php";
require_once './common/login.php';
require_once './common/functions.php';

if(isset($_GET['id']))
{
	$checkout_id = htmlentities($_GET['id']);
}else{
	header("Location: landingcheckout.php");
}

require_once './common/header.php';
?>
<?php if(isset($checkout_id)){?>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-10">
			<h2>Checkout Complete</h2>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-1">
		</div>
		<div class="col-sm-10">
			<h4><b>Key Checkout ID Number: <?php echo $checkout_id; ?> was successfully created</b></h4>
			 <p>Click the "Print Signature Form" button to generate a signature form.</p><br>	
		</div>
	</div>
	<div class="row">
		<div class="col-sm-2">
		</div>
		<div class="col-sm-2">
		<form action='checkout_complete.php' method='post'>
			<input type="submit" value="Print Signature Form" name="print" class="btn btn-default" onClick="popitup('signingform.php?id=<?php echo $checkout_id; ?>')">
		</form>
		</div>
	</div><br>
	<div class="row">
		<div class="col-sm-1">
		</div>
		<div class="col-sm-10">
			After printing the form, this page will return you to the checkout home screen.
		</div>
	</div>
</div>
<script>
	function popitup(url) {
		newwindow= popupwindow(url,'Signature Form',1200,600);
		if (window.focus) {newwindow.focus()}
		return false;
	}
	
	function popupwindow(url, title, w, h) {
		var y = window.outerHeight / 2 + window.screenY - ( h / 2);
		var x = window.outerWidth / 2 + window.screenX - ( w / 2);
		return window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=' + w + ', height=' + h + ', top=' + y + ', left=' + x);
	} 
</script>
<?php } ?>
<?php
	require_once './common/footer.php';
?>