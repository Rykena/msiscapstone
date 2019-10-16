<?php
$title = "Admin - View Building";
$auth = array('Admin');

require_once "logincheck.php";
require_once "./common/login.php";
require_once "./common/functions.php";

if(isset($_GET['id'])){
	$conn = new mysqli($hn, $un, $pw, $db);

	if($conn->connect_error) die($conn->connect_error);
	
	$bldg_id = mysql_entities_fix_string($conn, $_GET['id']);
	$row = selectBuild($conn,$bldg_id);
	
}else{
	header("Location: admin_retrieveusers.php");
}

require_once "./common/header.php";
?>

	<!-- About -->
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<h2>Admin: Details for Building "<?php echo $row['bldg_num']; ?>"</h2>
			<p>Use this page to administrate this building record. (<a href="admin_retrievebuildings.php">Return to Building List Page</a>)</p>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-sm-3 text-right">
			<b>Building Number:</b>
		</div>
		<div class="col-sm-9 form-group">
			<?php echo $row['bldg_num']; ?>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-3 text-right">
			<b>Description:</b>
		</div>
		<div class="col-sm-9 form-group">
			<?php if($row['bldg_desc'] ==''){
				echo "<i>No Description Added</i>";
			}else{
				echo $row['bldg_desc']; 
			}
			?>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-3 text-right">
			<b>Property:</b>
		</div>
		<div class="col-sm-9 form-group">
			<?php echo $row['bldg_prop']; ?>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-3 text-right">
			<b>Notes:</b>
		</div>
		<div class="col-sm-9 form-group">
			<?php if($row['bldg_notes'] ==''){
				echo "<i>No Notes Added</i>";
			}else{
				echo $row['bldg_notes']; 
			}
			?>
		</div>
	</div>			
	
	<div class="row">
		<div class="col-sm-3 text-right">
			<b>Active/Disabled Building:</b>
		</div>
		<div class="col-sm-9 form-group">
			<?php if($row['bldg_is_act'] == 1){
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
		<form method="post" action="admin_editbuilding.php">
			<input type="submit" value="Edit Building Details" name="updatebuilding" class="btn btn-default pull-right">
			<input type="hidden" value="<?php echo $row['bldg_id']; ?>" name="updbuildid">
		</form>
		</div>
	<?php if($row['bldg_is_act'] == 0){ ?>	
		<div class="col-sm-2 form-group">
		<form method="post" action="admin_buildactiveset.php">
			<input type="submit" value="Activate Building Record" name="activatebuild" class="btn btn-default">
			<input type="hidden" value="<?php echo $row['bldg_id']; ?>" name="bldgid">
			<input type="hidden" value="<?php echo $row['bldg_is_act']; ?>" name="buildact">
		</form>
		</div>
	<?php }else{ ?>	
		<div class="col-sm-2 form-group">
		<form method="post" action="admin_buildactiveset.php">
			<input type="submit" value="Disable Building Record" name="deactivatebuild" class="btn btn-default">
			<input type="hidden" value="<?php echo $row['bldg_id']; ?>" name="bldgid">
			<input type="hidden" value="<?php echo $row['bldg_is_act']; ?>" name="buildact">
		</form>
		</div>
	<?php } ?>	
	</div>
	
</div>

<?php
	$conn->close();
	require_once "./common/footer.php";
?>