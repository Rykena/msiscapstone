<?php
$title = "Admin - Add User";
$auth = array('Admin');

require_once "logincheck.php";
require_once "./common/login.php";
require_once "./common/functions.php";
require_once "./common/dropdowns.php";

$conn = new mysqli($hn, $un, $pw, $db);

if($conn->connect_error) die($conn->connect_error);

if(isset($_POST['adduser']))
{
	$user_name = mysql_entities_fix_string($conn, $_POST['username']);
	$fname = mysql_entities_fix_string($conn, $_POST['fname']);
	$lname = mysql_entities_fix_string($conn, $_POST['lname']);
	$phone = mysql_entities_fix_string($conn, $_POST['phone']);
	$email = mysql_entities_fix_string($conn, $_POST['email']);
	$password = mysql_entities_fix_string($conn, $_POST['password1']);
	$unid = mysql_entities_fix_string($conn, $_POST['unid']);
	$type = mysql_entities_fix_string($conn, $_POST['type']);
	
	$user_id = userCreate($conn,$user_name,$fname,$lname,$phone,$email,$password,$unid,$type);
	
	$conn->close();
	
	header("Location: admin_viewuser.php?id=$user_id");
}

require_once "./common/header.php";	
?>
	<!-- Intro -->
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12">
				<h2>Admin: Create New User Account</h2>
				<p>Use this page to create a new KeyTrack User (<a href="admin_retrieveusers.php">cancel and return to User Accounts Page</a>)</p>
			</div>
		</div>
		<br>
	  <div class="row">
		<form action="admin_adduser.php" method="post" onsubmit="return validate(this)">
		<div class="col-sm-4">
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>Username:</b>
				</div>
				<div class="col-sm-7 form-group">
					<input class="form-control" label="username" id="username" name="username" type="text"
					maxlength="16" placeholder="username - up to 16 digits" required>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>First Name:</b>
				</div>
				<div class="col-sm-7 form-group">
					<input class="form-control" label="fname" id="fname" name="fname" type="text"
					maxlength="32" placeholder="first name" required>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>Last Name:</b>
				</div>
				<div class="col-sm-7 form-group">
					<input class="form-control" label="lname" id="lname" name="lname" type="text"
					maxlength="32" placeholder="last name" required>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>Email:</b>
				</div>
				<div class="col-sm-7 form-group">
					<input class="form-control" label="email" id="email" name="email" type="text"
					maxlength="128" placeholder="youremail@email.com">
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>Phone:</b>
				</div>
				<div class="col-sm-7 form-group">
					<input class="form-control" label="phone" id="phone" name="phone" type="text"
					maxlength="20" pattern="[0-9\/-.]*" placeholder="555-555-5555">
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>uNID:</b>
				</div>
				<div class="col-sm-7 form-group">
					<input class="form-control" label="unid" id="unid" name="unid" type="text"
					maxlength="8" pattern="[0-9\/]*" placeholder="8 digit numerical UNID">
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>User Type:</b>
				</div>
				<div class="col-sm-7 form-group">
					<select name="type" size="1" required>
						<option disabled="disabled" value="" selected="selected">Select user type..</option>
					<?php foreach($usertypedd as $userdd){ ?>
						<option value="<?php echo $userdd; ?>"><?php echo $userdd; ?></option>
					<?php } ?>
					</select>
				</div>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="row">
				<div class="col-sm-5 text-right">
					<b>New Password:</b>
				</div>
				<div class="col-sm-6 form-group">
					<input class="form-control" label="password1" id="password1" name="password1" type="password"
					placeholder="8 character minimum" pattern=".{8,16}">
				</div>
			</div>
			<div class="row">
				<div class="col-sm-5 text-right">
					<b>Verify New Password:</b>
				</div>
				<div class="col-sm-6 form-group">
					<input class="form-control" label="password2" id="password2" name="password2" type="password"
					placeholder="enter new password again" pattern=".{8,16}">
				</div>
			</div><br>
			<div class="row">
				<div class="col-sm-11 form-group">
					<input type="submit" value="Create Account" name="submitnewuser" class="btn btn-default pull-right">
					<input type="hidden" name="adduser" value="Yes">
				</div>
			</div>
		</div>
		</form>
	</div>
</div>
<?php
	require_once "./common/footer.php";
?>