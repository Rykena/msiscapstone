<?php
$title = "Admin - View Key";
$auth = array('Admin');

require_once "logincheck.php";
require_once "./common/login.php";
require_once "./common/functions.php";

if(isset($_GET['id'])){
	$conn = new mysqli($hn, $un, $pw, $db);

	if($conn->connect_error) die($conn->connect_error);
	
	$key_id = mysql_entities_fix_string($conn, $_GET['id']);
	$row = selectKey($conn,$key_id);
	
}else{
	header("Location: admin_retrievekeys.php");
}

require_once "./common/header.php";
?>

	<!-- About -->
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<h2>Admin: Details for Key "<?php echo $row['key_number'];
				if($row['key_name'] == '' or !$row['key_name']){
					
				}else{
					echo ' - '.$row['key_name']; 
				}?>"
			</h2>
			<p>Use this page to administrate this key record. (<a href="admin_retrievekeys.php">Return to Key List Page</a>)</p>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-sm-3 text-right">
			<b>Key Number:</b>
		</div>
		<div class="col-sm-9 form-group">
			<?php echo $row['key_number']; ?>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-3 text-right">
			<b>Description:</b>
		</div>
		<div class="col-sm-9 form-group">
			<?php if($row['key_name'] ==''){
				echo "<i>No Description Added</i>";
			}else{
				echo $row['key_name']; 
			}
			?>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-3 text-right">
			<b>Notes:</b>
		</div>
		<div class="col-sm-9 form-group">
			<?php if($row['key_notes'] ==''){
				echo "<i>No Notes Added</i>";
			}else{
				echo $row['key_notes']; 
			}
			?>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-3 text-right">
			<b>Key Type:</b>
		</div>
		<div class="col-sm-9 form-group">
			<?php echo $row['key_type']; ?>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-3 text-right">
			<b>Core Number:</b>
		</div>
		<div class="col-sm-9 form-group">
			<?php 
			if((!isset($row['core_num'])) || ($row['core_num'] == "")){
				echo "N/A";
			}else{
				echo $row['core_num']; 
			}
			?>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-3 text-right">
			<b>Core Type:</b>
		</div>
		<div class="col-sm-9 form-group">
			<?php 
			if((!isset($row['core_type'])) || ($row['core_type'] == "")){
				echo "N/A";
			}else{
				echo $row['core_type']; 
			}
			?>
		</div>
	</div>		
	
	<div class="row">
		<div class="col-sm-3 text-right">
			<b>Active/Disabled Key:</b>
		</div>
		<div class="col-sm-9 form-group">
			<?php if($row['key_is_act'] == 1){
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
		<form method="post" action="admin_editkey.php">
			<input type="submit" value="Edit Key Details" name="updatekey" class="btn btn-default pull-right">
			<input type="hidden" value="<?php echo $row['key_id']; ?>" name="updkeyid">
		</form>
		</div>
	<?php if($row['key_is_act'] == 0){ ?>	
		<div class="col-sm-2 form-group">
		<form method="post" action="admin_keyactiveset.php">
			<input type="submit" value="Activate Key Record" name="activatekey" class="btn btn-default">
			<input type="hidden" value="<?php echo $row['key_id']; ?>" name="keyid">
			<input type="hidden" value="<?php echo $row['key_is_act']; ?>" name="keyact">
		</form>
		</div>
	<?php }else{ ?>	
		<div class="col-sm-2 form-group">
		<form method="post" action="admin_keyactiveset.php">
			<input type="submit" value="Disable Key Record" name="deactivatekey" class="btn btn-default">
			<input type="hidden" value="<?php echo $row['key_id']; ?>" name="keyid">
			<input type="hidden" value="<?php echo $row['key_is_act']; ?>" name="keyact">
		</form>
		</div>
	<?php } ?>	
	</div>
	
</div>

<?php
	$conn->close();
	require_once "./common/footer.php";
?>