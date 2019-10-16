<?php
$title = "Rekey Location";
$auth = array('Admin','User');

require_once "logincheck.php";
require_once "./common/login.php";
require_once "./common/functions.php";

if(isset($_POST['loc_id'])){
	$conn = new mysqli($hn, $un, $pw, $db);

	if($conn->connect_error) die($conn->connect_error);
	
	$loc_id = mysql_entities_fix_string($conn, $_POST['loc_id']);
	
	$loc = selectLocation($conn,$loc_id);

	$keys = selectAllActiveKeys($conn);
}else{
	header("Location: retrievelocations.php");
}
	
require_once "./common/header.php";
?>

	<!-- About -->
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<h2>Select New Key/Core for Location: "<?php echo $loc['loc_unit_num'].($loc['bldg_num'] != '' ? ' - '.$loc['bldg_num'] :'').($loc['bldg_prop'] != '' ? ' - '.$loc['bldg_prop'] : ''); ?>"</h2>
			<p>Click on a the "Select This Key/Core" button to assign that key/core to the location. (<a href="retrievelocations.php">Cancel and Return to Location List Page</a>)</p>
		</div>
	</div>
	<br>
	<div class="row">
		
		<div class="col-sm-12">
	<!-- Table of Keys -->
		<table id="keytable" class="table table-striped table-bordered">
			<thead>
				<tr>
					<th scope="col">Key Number</th>
					<th scope="col">Description</th>
					<th scope="col">Key Type</th>
					<th scope="col">Core Number</th>
					<th scope="col">Core Type</th>
					<th scope="col">Select Key/Core</th>
					
				</tr>
			</thead>
			<tbody>
		<?php foreach($keys as $row){ ?>
				<tr>
					<td>
						<?php echo $row['key_number']; ?>
					</td>
					<td>
						<?php 
						if((!isset($row['key_name'])) || ($row['key_name'] == "")){
							echo "N/A";
						}else{
							echo $row['key_name']; 
						}
						?>
					</td>
					<td>
						<?php echo $row['key_type']; ?>
					</td>
					<td>
						<?php 
						if((!isset($row['core_num'])) || ($row['core_num'] == "")){
							echo "N/A";
						}else{
							echo $row['core_num']; 
						}
						?>
					</td>
					<td>
						<?php 
						if((!isset($row['core_type'])) || ($row['core_type'] == "")){
							echo "N/A";
						}else{
							echo $row['core_type']; 
						}
						?>
					</td>
					<td>
						<form action='rekeyverify.php' method='post'>
							<input type="hidden" name="verifyrekey" value="yes">
							<input type="hidden" name="key_id" value="<?php echo $row['key_id']; ?>">
							<input type="hidden" name="loc_id" value="<?php echo $loc['loc_id']; ?>">
							<input type='submit' value='Select This Key/Core' class="btn btn-default">
						</form>
					</td>
					
				</tr>
		<?php } ?>
			</tbody>
		</table>
		</div>
	</div>
	
	
</div>

<!-- script below manages the datatable jQuery logic for the table of keys. It controls pagination, sorting, etc. -->
<script>
$(document).ready( function () {
    $('#keytable').DataTable({
		"autoWidth": false
	});
} );
</script>

<?php
	$conn->close();
	require_once "./common/footer.php";
?>