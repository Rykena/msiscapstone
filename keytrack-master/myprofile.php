<?php
$title = "My Profile";
$auth = array('Admin','User','View');

require_once "logincheck.php";
require_once "./common/login.php";
require_once "./common/functions.php";

if(isset($_SESSION['userid'])){
	$conn = new mysqli($hn, $un, $pw, $db);

	if($conn->connect_error) die($conn->connect_error);
	
	$user_id = mysql_entities_fix_string($conn, $_SESSION['userid']);
	$row = selectUser($conn,$user_id);
	
}else{
	header("Location: index.php");
}

require_once "./common/header.php";
?>

	<!-- About -->
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<h2>My Profile: Account Details for "<?php echo $row['user_fname'].' '.$row['user_lname']; ?>"</h2>
			<p>Use this page to administrate your KeyTrack user account. (<a href="index.php">Return to Home Page</a>)</p>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-sm-3 text-right">
			<b>Username:</b>
		</div>
		<div class="col-sm-9 form-group">
			<?php echo $row['user_name']; ?>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-3 text-right">
			<b>First Name:</b>
		</div>
		<div class="col-sm-9 form-group">
			<?php echo $row['user_fname']; ?>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-3 text-right">
			<b>Last Name:</b>
		</div>
		<div class="col-sm-9 form-group">
			<?php echo $row['user_lname']; ?>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-3 text-right">
			<b>Email address:</b>
		</div>
		<div class="col-sm-9 form-group">
			<?php echo $row['user_email']; ?>
		</div>
	</div>			
	
	<div class="row">
		<div class="col-sm-3 text-right">
			<b>Phone:</b>
		</div>
		<div class="col-sm-9 form-group">
			<?php echo $row['user_phone']; ?>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-3 text-right">
			<b>uNID:</b>
		</div>
		<div class="col-sm-9 form-group">
			<?php echo $row['user_unid']; ?>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-3 text-right">
			<b>User Type:</b>
		</div>
		<div class="col-sm-9 form-group">
			<?php echo $row['user_type']; ?>
		</div>
	</div>
	
	<br>
	<div class="row">
		<div class="col-sm-3 form-group">
		</div>
		<div class="col-sm-3 form-group">
		<form method="post" action="updatemyprofile.php">
			<input type="submit" value="Edit Your Details" name="updateprofile" class="btn btn-default pull-left">
		</form>
		</div>
	</div>
	
</div>

<?php
	$conn->close();
	require_once "./common/footer.php";
?>