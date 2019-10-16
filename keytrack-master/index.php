<?php
$title = "USA KeyTrack Home";

require_once "./common/login.php";
require_once "./common/functions.php";

session_start();

if(isset($_POST['username']))
{
	$conn = new mysqli($hn, $un, $pw, $db);

	if($conn->connect_error) die($conn->connect_error);
	
	$username =  mysql_entities_fix_string($conn, $_POST['username']);
	$tmp_password = mysql_entities_fix_string($conn, $_POST['password']);
	
	$query = "SELECT user_id,user_name, user_fname, user_lname, user_pass, user_type, user_is_act from ktuser where user_name = '$username' ";
	
	$result = $conn->query($query);

	if(!$result) die($conn->error);
	
	$row = $result->fetch_array(MYSQLI_ASSOC);
	
	$conn->close();
	
	$db_password = $row['user_pass'];
	$user_type = $row['user_type'];
	$user_id = $row['user_id'];
	$user_fname = $row['user_fname'];
	$user_lname = $row['user_lname'];
	$is_active = $row['user_is_act'];
	
	$token = tokenizePW($tmp_password);
	
	if(!$row){
		header("Location: logincheck.php");
	}else{
		if($db_password == $token && $is_active == 1){
			
			$_SESSION['userid'] = $user_id;
			$_SESSION['username'] = $username;
			$_SESSION['userfname'] = $user_fname;
			$_SESSION['userlname'] = $user_lname;
			$_SESSION['usertype'] = $user_type;
			$_SESSION['LOGIN_TIME'] = $_SERVER['REQUEST_TIME'];
			
		}else{
			header("Location: logincheck.php");
		}
	}
	
}

require_once "./common/sessiontimeout.php";
	
require_once "./common/header.php";
?>
	
	<!-- About -->
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<h2>Welcome to University Student Apartments KeyTrack</h2>
		</div>	
	</div>
	
	<!-- Sign In -->
	<?php if(!isset($_SESSION['username'])){ ?>
	<form action="index.php" method="post">
	<div class="row">
		<div class="col-sm-6">
			<div class="row">
				<div class="col-sm-12">
					<h4>Login to Continue</h4>
				</div>
			</div>
			
			<div class="row">
				<div class="col-sm-2">
				</div>
				<div class="col-sm-8 form-group">
					<label for="username">Username</label>
					<input class="form-control" id="username" name="username" placeholder="username" 
					type="text" maxlength="32" required>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
				</div>
				<div class="col-sm-8 form-group">
					<label for="password">Password</label>
					<input class="form-control" id="password" name="password" placeholder="password" 
					type="password" pattern=".{8,16}" required>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2">
				</div>
				<div class="col-sm-8 form-group"><br>
					<input type="submit" value="Login to KeyTrack" name="userlogin" class="btn btn-default pull-right">
				</div>
			</div>
			
		</div>
		<div class="col-sm-1">
			<p>&nbsp;</p>
		</div>
		<div class="col-sm-4">
			<p>&nbsp;</p><br><br>
			<img src="img/redktlogo.png" alt="KeyTrack Logo" width="400">
		</div>		
	</div>
	</form>
</div>
	<?php }else{ ?>
	<div class="row">
		<div class="col-sm-8">
			<h4>Welcome <?php echo $_SESSION['userfname']." ".$_SESSION['userlname']; ?></h4>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-1">
		</div>
		<div class="col-sm-4">
			<p>Select from a menu option or a link below to continue</p><br>
			<span class="glyphicon glyphicon-list-alt red-icon"></span>&nbsp;<a href="landingcheckout.php">Key Checkout</a><br><br>
			<span class="glyphicon glyphicon-filter red-icon"></span>&nbsp;<a href="landingviewkc.php">View Keys/Cores</a><br><br>
			<span class="glyphicon glyphicon glyphicon-home red-icon"></span>&nbsp;<a href="retrievelocations.php">View Locations</a><br><br>
			<span class="glyphicon glyphicon glyphicon-transfer red-icon"></span>&nbsp;<a href="landingrekey.php">Rekey Location</a><br><br>
		</div>
		<div class="col-sm-2">
			<p>&nbsp;</p>
		</div>
		<div class="col-sm-4">
			<p>&nbsp;</p>
			<img src="img/redktlogo.png" alt="KeyTrack Logo" width="400">
		</div>
	</div>
</div>
<?php
	}
	require_once "./common/footer.php";
?>