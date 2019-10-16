<?php
$title = "Admin - Edit User";
$auth = array('Admin');

require_once "logincheck.php";
require_once "./common/login.php";
require_once "./common/functions.php";
require_once "./common/dropdowns.php";

if(!isset($_POST['updateaccount']) && !isset($_POST['applyupdate'])){
	header("Location: admin_retrieveusers.php");
}

$conn = new mysqli($hn, $un, $pw, $db);

if($conn->connect_error) die($conn->connect_error);

if(isset($_POST['applyupdate']))
{
	$user_id = mysql_entities_fix_string($conn, $_POST['userid']);
	$fname = mysql_entities_fix_string($conn, $_POST['fname']);
	$lname = mysql_entities_fix_string($conn, $_POST['lname']);
	$phone = mysql_entities_fix_string($conn, $_POST['phone']);
	$email = mysql_entities_fix_string($conn, $_POST['email']);
	$password = mysql_entities_fix_string($conn, $_POST['password1']);
	$unid = mysql_entities_fix_string($conn, $_POST['unid']);
	$type = mysql_entities_fix_string($conn, $_POST['type']);
	
	userUpdate($conn,$user_id,$fname,$lname,$phone,$email,$password,$unid,$type);
	
	$conn->close();
	
	header("Location: admin_viewuser.php?id=$user_id");
}

if(isset($_POST['updateaccount']))
{
	$user_id = mysql_entities_fix_string($conn, $_POST['upduserid']);
	
	$row = selectUser($conn,$user_id);

	if(!$row){
		echo "Empty Account Record";
		exit;
	}
	$conn->close();
}

require_once "./common/header.php";	
?>
<?php if(isset($row)){?>
	<!-- Intro -->
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12">
				<h2>Admin: Update Account Details for "<?php echo $row['user_fname'].' '.$row['user_lname']; ?>"</h2>
				<p>Use this page to update this user's account information. (<a href="admin_viewuser.php?id=<?php echo $row['user_id']; ?>">cancel and return to View User's Account</a>)</p>
			</div>
		</div>
		<br>
	  <div class="row">
		<form action="admin_edituser.php" method="post" onsubmit="return validate(this)">
		<div class="col-sm-4">
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>Username:</b>
				</div>
				<div class="col-sm-7 form-group">
					<?php echo $row['user_name']; ?>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>First Name:</b>
				</div>
				<div class="col-sm-7 form-group">
					<input class="form-control" label="fname" id="fname" name="fname" type="text"
					maxlength="32" value="<?php echo $row['user_fname']; ?>" required>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>Last Name:</b>
				</div>
				<div class="col-sm-7 form-group">
					<input class="form-control" label="lname" id="lname" name="lname" type="text"
					maxlength="32" value="<?php echo $row['user_lname']; ?>" required>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>Email:</b>
				</div>
				<div class="col-sm-7 form-group">
					<input class="form-control" label="email" id="email" name="email" type="text"
					maxlength="128" value="<?php echo $row['user_email']; ?>">
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>Phone:</b>
				</div>
				<div class="col-sm-7 form-group">
					<input class="form-control" label="phone" id="phone" name="phone" type="text"
					maxlength="20" pattern="[0-9\/-.]*" value="<?php echo $row['user_phone']; ?>">
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>uNID:</b>
				</div>
				<div class="col-sm-7 form-group">
					<input class="form-control" label="unid" id="unid" name="unid" type="text"
					maxlength="8" pattern="[0-9\/]*" value="<?php echo $row['user_unid']; ?>">
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>User Type:</b>
				</div>
				<div class="col-sm-7 form-group">
					<select name="type" size="1">
					<?php foreach($usertypedd as $userdd){ ?>
						<option value="<?php echo $userdd; ?>" <?php if($row['user_type'] == $userdd) echo "selected" ?>><?php echo $userdd; ?></option>
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
					<input type="submit" value="Submit Changes" name="submitedit" class="btn btn-default pull-right">
					<input type="hidden" name="applyupdate" value="Yes">
					<input type="hidden" name="userid" value="<?php echo $row['user_id']; ?>">
				</div>
			</div>
		</div>
		</form>
	</div>
</div>
<?php } ?>
<?php
	require_once "./common/footer.php";
?>