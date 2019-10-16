<?php
$title = "Admin - View Core";
$auth = array('Admin');

require_once "logincheck.php";
require_once "./common/login.php";
require_once "./common/functions.php";

if(isset($_GET['id'])){
	$conn = new mysqli($hn, $un, $pw, $db);

	if($conn->connect_error) die($conn->connect_error);
	
	$core_id = mysql_entities_fix_string($conn, $_GET['id']);
	$row = selectCore($conn,$core_id);
	
}else{
	header("Location: admin_retrievecores.php");
}

require_once "./common/header.php";
?>

	<!-- About -->
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<h2>Admin: Details for Core Number: <?php echo $row['core_num']; ?></h2>
			<p>Use this page to administrate this core record. (<a href="admin_retrievecores.php">Return to Core List Page</a>)</p>	
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-sm-3 text-right">
			<b>Core Number:</b>
		</div>
		<div class="col-sm-9 form-group">
			<?php echo $row['core_num']; ?>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-3 text-right">
			<b>Core Cut:</b>
		</div>
		<div class="col-sm-9 form-group">
			<?php if($row['core_cut'] ==''){
				echo "<i>No Core Cut Added</i>";
			}else{
				echo $row['core_cut']; 
			}
			?>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-3 text-right">
			<b>Core Type:</b>
		</div>
		<div class="col-sm-9 form-group">
			<?php echo $row['core_type']; ?>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-3 text-right">
			<b>Description:</b>
		</div>
		<div class="col-sm-9 form-group">
			<?php if($row['core_desc'] ==''){
				echo "<i>No Description Added</i>";
			}else{
				echo $row['core_desc']; 
			}
			?>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-3 text-right">
			<b>Manufacturer:</b>
		</div>
		<div class="col-sm-9 form-group">
			<?php if($row['core_manf'] ==''){
				echo "<i>No Manufacturer Added</i>";
			}else{
				echo $row['core_manf']; 
			}
			?>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-3 text-right">
			<b>Notes:</b>
		</div>
		<div class="col-sm-9 form-group">
			<?php if($row['core_notes'] ==''){
				echo "<i>No Notes Added</i>";
			}else{
				echo $row['core_notes']; 
			}
			?>
		</div>
	</div>			
	
	<div class="row">
		<div class="col-sm-3 text-right">
			<b>Core Diagram:</b>
		</div>
		<div class="col-sm-9 form-group">
			<?php if($row['core_diagram'] ==''){ ?>
				<i>No Diagram Loaded</i> - <a href="admin_coreimage.php?id=<?php echo $row['core_id']; ?>">Click to upload image</a>
			<?php }else{ ?>
				<a data-fancybox="images" data-caption="Diagram for Core: <?php echo $row['core_num']; ?>" href="<?php echo $row['core_diagram']; ?>">View Diagram</a>
			<?php } ?>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-3 text-right">
			<b>Active/Disabled Core:</b>
		</div>
		<div class="col-sm-9 form-group">
			<?php if($row['core_is_act'] == 1){
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
		<form method="post" action="admin_editcore.php">
			<input type="submit" value="Edit Core Details" name="updatecore" class="btn btn-default pull-right">
			<input type="hidden" value="<?php echo $row['core_id']; ?>" name="updcoreid">
		</form>
		</div>
	<?php if($row['core_is_act'] == 0){ ?>	
		<div class="col-sm-2 form-group">
		<form method="post" action="admin_coreactiveset.php">
			<input type="submit" value="Activate Core Record" name="activatecore" class="btn btn-default">
			<input type="hidden" value="<?php echo $row['core_id']; ?>" name="coreid">
			<input type="hidden" value="<?php echo $row['core_is_act']; ?>" name="coreact">
		</form>
		</div>
	<?php }else{ ?>	
		<div class="col-sm-2 form-group">
		<form method="post" action="admin_coreactiveset.php">
			<input type="submit" value="Disable Core Record" name="deactivatecore" class="btn btn-default">
			<input type="hidden" value="<?php echo $row['core_id']; ?>" name="coreid">
			<input type="hidden" value="<?php echo $row['core_is_act']; ?>" name="coreact">
		</form>
		</div>
	<?php } ?>	
	</div>
	
</div>

<?php
	$conn->close();
	require_once "./common/footer.php";
?>