<?php
$title = "Rekey Date Entry and Verify";
$auth = array('Admin','User');

require_once "logincheck.php";
require_once "./common/login.php";
require_once "./common/functions.php";

if(isset($_POST['verifyrekey'])){
	$conn = new mysqli($hn, $un, $pw, $db);

	if($conn->connect_error) die($conn->connect_error);
	
	$key_id = mysql_entities_fix_string($conn, $_POST['key_id']);
	$loc_id = mysql_entities_fix_string($conn, $_POST['loc_id']);
	
	$key = selectKey($conn,$key_id);
	$loc = selectLocation($conn,$loc_id);
	$current = selectCurrentCore($conn,$loc_id);
	
}else{
	header("Location: retrievelocations.php");
}

require_once "./common/header.php";
?>

	<!-- About -->
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<h2>Verify Rekey for Location: "<?php echo $loc['loc_unit_num'].($loc['bldg_num'] != '' ? ' - '.$loc['bldg_num'] :'').($loc['bldg_prop'] != '' ? ' - '.$loc['bldg_prop'] : ''); ?>"</h2>
			<p>Use this page to verify the information for the new key/core being assigned. (<a href="retrievelocations.php">Cancel and Return to Location List Page</a>)</p>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-sm-4 text-right">
			<b>Location Number - Bldg - Property:</b>
		</div>
		<div class="col-sm-8 form-group">
			<?php echo $loc['loc_unit_num'].($loc['bldg_num'] != '' ? ' - '.$loc['bldg_num'] :'').($loc['bldg_prop'] != '' ? ' - '.$loc['bldg_prop'] : ''); ?>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-4 text-right">
			<b>Previous Core and Install Date (if any):</b>
		</div>
		<div class="col-sm-8 form-group">
			<?php if($current['core_num'] ==''){
				echo "<i>No Core Currently Installed</i>";
			}else{
				echo $current['core_num'].' - '.timeDisplay($current['key_loc_startdt']); 
			}
			?>
		</div>
	</div>
	<br><br>
	
	<div class="row">
		<div class="col-sm-4 text-right">
			<b>New Core/Key Being Installed to Assign to Unit:</b>
		</div>
		<div class="col-sm-8 form-group">
			<?php if(!$key['core_num'] || $key['core_num'] == ''){
				echo "Key Change Only - No Core Required";
			}else{
				echo $key['core_num'];
			} ?>
		</div>
	</div>
	
	<form action='processrekey.php' method='post'>
	<div class="row">
		<div class="col-sm-4 text-right">
			<b>Date the New Core was Installed:</b>
		</div>
		<div class="col-sm-8 form-group">
			<input type="date" id="changedt" name="changedt" required >
		</div>
	</div>
	
	
	<div class="row">
				<div class="col-sm-4 text-right">
				</div>
				<div class="col-sm-8 form-group">
				
					<input type="submit" value="Complete the Rekey Process" name="completerekey" class="btn btn-default pull-left">
					<input type="hidden" name="rekeyprocess" value="Yes">
					<input type="hidden" name="loc_id" value="<?php echo $loc['loc_id']; ?>">
					<input type="hidden" name="key_id" value="<?php echo $key['key_id']; ?>">
					<input type="hidden" name="key_qty" value="1">
					<input type="hidden" name="old_key_loc_id" value="<?php echo $current['key_loc_id']; ?>">
				
				</div>
			</div>
	</form>
	
	
</div>
<script language="javascript" type="text/javascript">
	var today = new Date();
	today.setDate(today.getDate());
	var dd = today.getDate();
	var mm = today.getMonth()+1; //January is 0!
	var yyyy = today.getFullYear();
	 if(dd<10){
			dd='0'+dd
		} 
		if(mm<10){
			mm='0'+mm
		} 

	today = yyyy+'-'+mm+'-'+dd;
	document.getElementById("changedt").setAttribute("max", today);
</script>
<?php
	$conn->close();
	require_once "./common/footer.php";
?>