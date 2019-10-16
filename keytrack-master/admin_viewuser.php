<?php
$title = "Admin - View User";
$auth = array('Admin');

require_once "logincheck.php";
require_once "./common/login.php";
require_once "./common/functions.php";

if(isset($_GET['id'])){
	$conn = new mysqli($hn, $un, $pw, $db);

	if($conn->connect_error) die($conn->connect_error);
	
	$user_id = mysql_entities_fix_string($conn, $_GET['id']);
	$row = selectUser($conn,$user_id);
	
}else{
	header("Location: admin_retrieveusers.php");
}

require_once "./common/header.php";
?>

	<!-- About -->
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<h2>Admin: Account Details for "<?php echo $row['user_fname'].' '.$row['user_lname']; ?>"</h2>
			<p>Use this page to administrate this user account. (<a href="admin_retrieveusers.php">Return to User Accounts Page</a>)</p>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-sm-3 text-right">
			<b>Username:</b>
		</div>
		<div class="col-sm-9 form-group">
			<?php if($row['user_name'] ==''){
				echo "<i>No Username Added</i>";
			}else{
				echo $row['user_name']; 
			}
			?>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-3 text-right">
			<b>First Name:</b>
		</div>
		<div class="col-sm-9 form-group">
			<?php if($row['user_fname'] ==''){
				echo "<i>No First Name Added</i>";
			}else{
				echo $row['user_fname']; 
			}
			?>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-3 text-right">
			<b>Last Name:</b>
		</div>
		<div class="col-sm-9 form-group">
			<?php if($row['user_lname'] ==''){
				echo "<i>No Last Name Added</i>";
			}else{
				echo $row['user_lname']; 
			}
			?>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-3 text-right">
			<b>Email address:</b>
		</div>
		<div class="col-sm-9 form-group">
			<?php if($row['user_email'] ==''){
				echo "<i>No Email Added</i>";
			}else{
				echo $row['user_email']; 
			}
			?>
		</div>
	</div>			
	
	<div class="row">
		<div class="col-sm-3 text-right">
			<b>Phone:</b>
		</div>
		<div class="col-sm-9 form-group">
			<?php if($row['user_phone'] ==''){
				echo "<i>No Description Added</i>";
			}else{
				echo $row['user_phone']; 
			}
			?>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-3 text-right">
			<b>uNID:</b>
		</div>
		<div class="col-sm-9 form-group">
			<?php if($row['user_unid'] ==''){
				echo "<i>No UNID Added</i>";
			}else{
				echo $row['user_unid']; 
			}
			?>
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
	
	<div class="row">
		<div class="col-sm-3 text-right">
			<b>Active/Disabled Account:</b>
		</div>
		<div class="col-sm-9 form-group">
			<?php if($row['user_is_act'] == 1){
					echo "Active";
				}else{
					echo "Disabled";
				} 
			?>
		</div>
	</div>
	
	<br>
	<div class="row">
		<div class="col-sm-3 form-group">
		<form method="post" action="admin_edituser.php">
			<input type="submit" value="Edit User Details" name="updateaccount" class="btn btn-default pull-right">
			<input type="hidden" value="<?php echo $row['user_id']; ?>" name="upduserid">
		</form>
		</div>
	<?php if($row['user_is_act'] == 0){ ?>	
		<div class="col-sm-2 form-group">
		<form method="post" action="admin_useractiveset.php">
			<input type="submit" value="Activate User Account" name="activateuser" class="btn btn-default">
			<input type="hidden" value="<?php echo $row['user_id']; ?>" name="userid">
			<input type="hidden" value="<?php echo $row['user_is_act']; ?>" name="useract">
		</form>
		</div>
	<?php }else{ ?>	
		<div class="col-sm-2 form-group">
		<form method="post" action="admin_useractiveset.php">
			<input type="submit" value="Disable User Account" name="deactivateuser" class="btn btn-default">
			<input type="hidden" value="<?php echo $row['user_id']; ?>" name="userid">
			<input type="hidden" value="<?php echo $row['user_is_act']; ?>" name="useract">
		</form>
		</div>
	<?php } ?>	
	</div>
	
</div>

<?php
	$conn->close();
	require_once "./common/footer.php";
?>