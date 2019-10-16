<?php
$title = "View Core";
$auth = array('Admin','User','View');
require_once "logincheck.php";
require_once "./common/login.php";
require_once "./common/functions.php";
if(isset($_GET['id'])){
	$conn = new mysqli($hn, $un, $pw, $db);
	if($conn->connect_error) die($conn->connect_error);
	
	$core_id = mysql_entities_fix_string($conn, $_GET['id']);
	$row = selectCore($conn,$core_id);
	
	$is_act = 2;
	$assignments = selectCoreAssignments($conn,$is_act,$core_id);
	
}else{
	header("Location: retrievecores.php");
}
require_once "./common/header.php";
?>

	<!-- About -->
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<h2>Details for Core Number: <?php echo $row['core_num']; ?></h2>
			<p>Use this page to view this core record. (<a href="retrievecores.php">Return to Core List Page</a>)</p>
		</div>
	</div>
	<br>
<div class="col-sm-6">
	<div class="row">
		<div class="col-sm-5 text-right">
			<b>Core Number:</b>
		</div>
		<div class="col-sm-7 form-group">
			<?php echo $row['core_num']; ?>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-5 text-right">
			<b>Core Cut:</b>
		</div>
		<div class="col-sm-7 form-group">
			<?php if($row['core_cut'] ==''){
				echo "<i>No Core Cut Added</i>";
			}else{
				echo $row['core_cut']; 
			}
			?>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-5 text-right">
			<b>Core Type:</b>
		</div>
		<div class="col-sm-7 form-group">
			<?php echo $row['core_type']; ?>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-5 text-right">
			<b>Description:</b>
		</div>
		<div class="col-sm-7 form-group">
			<?php if($row['core_desc'] ==''){
				echo "<i>No Description Added</i>";
			}else{
				echo $row['core_desc']; 
			}
			?>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-5 text-right">
			<b>Manufacturer:</b>
		</div>
		<div class="col-sm-7 form-group">
			<?php if($row['core_manf'] ==''){
				echo "<i>No Manufacturer Added</i>";
			}else{
				echo $row['core_manf']; 
			}
			?>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-5 text-right">
			<b>Notes:</b>
		</div>
		<div class="col-sm-7 form-group">
			<?php if($row['core_notes'] ==''){
				echo "<i>No Notes Added</i>";
			}else{
				echo $row['core_notes']; 
			}
			?>
		</div>
	</div>			
	<?php if($_SESSION['usertype'] == 'View'){ 
	}else{ ?>
	<div class="row">
		<div class="col-sm-5 text-right">
			<b>Core Diagram:</b>
		</div>
		<div class="col-sm-7 form-group">
			<?php if($row['core_diagram'] ==''){ ?>
				<i>No Diagram Loaded</i>
			<?php }else{ ?>
				<a data-fancybox="images" data-caption="Diagram for Core: <?php echo $row['core_num']; ?>" href="<?php echo $row['core_diagram']; ?>">View Diagram</a>
			<?php } ?>
		</div>
	</div>
	<?php } ?>
</div>	


<!-- this side has the panel that shows location assignments for this core -->

<div class="col-sm-6 panel panel-default pull-right">
	<div class="panel-body">
		<div class="panel-title">
		Location Assignments
		</div>
		<div class="row">
			<div class="col-sm-12">
				<span class="small">Location History</span>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
			<table class="table table-striped table-bordered">
				<tr>
					<th scope="col">Location</th>
					<th scope="col">Description</th>
					<th scope="col">Assign Date</th>
					<th scope="col">End Date</th>
				</tr>
				<?php foreach($assignments as $location){ ?>
				<tr>
					<td>
						<a href="viewlocation.php?id=<?php echo $location['loc_id']; ?>"><?php echo $location['loc_unit_num']; ?></a>
					</td>
					<td>
						<?php echo $location ['loc_desc'];?>
					</td>
					<td><?php echo dateDisplay($location['key_loc_startdt']);?>
					</td>
					<td><?php if(!$location['key_loc_enddt'] || $location['key_loc_enddt'] == ''){
							echo "<b>CURRENT</b>";
						}else{
							echo dateDisplay($location['key_loc_enddt']);
						} ?>
					</td>
				</tr>
				<?php } ?>
			</table>
			</div>
		</div>
	</div>
</div>	
</div>



<?php
	$conn->close();
	require_once "./common/footer.php";
?>