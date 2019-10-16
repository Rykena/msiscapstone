<?php
$title = "Admin - Edit Key";
$auth = array('Admin');

require_once "logincheck.php";
require_once "./common/login.php";
require_once "./common/functions.php";
require_once "./common/dropdowns.php";

if(!isset($_POST['updatekey']) && !isset($_POST['applyupdate'])){
	header("Location: admin_retrievekeys.php");
}

$conn = new mysqli($hn, $un, $pw, $db);

if($conn->connect_error) die($conn->connect_error);

if(isset($_POST['applyupdate']))
{
	$key_id = mysql_entities_fix_string($conn, $_POST['keyid']);
	$key_number = mysql_entities_fix_string($conn, $_POST['keynum']);
	$key_name = mysql_entities_fix_string($conn, $_POST['keydesc']);
	$key_notes = mysql_entities_fix_string($conn, $_POST['keynotes']);
	$key_type = mysql_entities_fix_string($conn, $_POST['keytype']);
	$core_num = mysql_entities_fix_string($conn, $_POST['core_id']);
	
	keyUpdate($conn,$key_id,$key_number,$key_name,$key_notes,$key_type,$core_num);
	
	$conn->close();
	
	header("Location: admin_viewkey.php?id=$key_id");
}

if(isset($_POST['updatekey']))
{
	$key_id = mysql_entities_fix_string($conn, $_POST['updkeyid']);
	
	$row = selectKey($conn,$key_id);

	if(!$row){
		echo "Empty Key Record";
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
				<h2>Admin: Update Details for Key "<?php echo $row['key_number'];
				if($row['key_name'] == '' or !$row['key_name']){
					
				}else{
					echo ' - '.$row['key_name']; 
				}?>"</h2>
				<p>Use this page to update this key information. (<a href="admin_viewkey.php?id=<?php echo $row['key_id']; ?>">cancel and return to View Key Record</a>)</p>
			</div>
		</div>
		<br>
	  <div class="row">
		<form action="admin_editkey.php" method="post">
		<div class="col-sm-8">
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>Key Number:</b>
				</div>
				<div class="col-sm-7 form-group">
					<input class="form-control" label="keynum" id="keynum" name="keynum" type="text"
					maxlength="8" value="<?php echo $row['key_number']; ?>" required>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>Description:</b>
				</div>
				<div class="col-sm-7 form-group">
					<input class="form-control" label="keydesc" id="keydesc" name="keydesc" type="text"
					maxlength="64" value="<?php echo $row['key_name']; ?>" >
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>Notes:</b>
				</div>
				<div class="col-sm-7 form-group">
					<textarea name="keynotes" rows="5" placeholder="Add any notes here" style="width:100%"><?php echo $row['key_notes']; ?></textarea>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>Key Type:</b>
				</div>
				<div class="col-sm-7 form-group">
					<select name="keytype" size="1">
					<?php foreach($keytypedd as $keydd){ ?>
						<option value="<?php echo $keydd; ?>" <?php if($row['key_type'] == $keydd) echo "selected" ?>><?php echo $keydd; ?></option>
					<?php } ?>
					</select>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4 text-right">
					<h6 class="text-muted">&nbsp;</h6>
					<b>Core Number (if required):</b>
				</div>
				<div id="auto" class="col-sm-7 form-group">
					<h6 class="text-muted">Type in core number to get matches to select from</h6>
					<input class="form-control" id="core_id" name="core_id" placeholder="core number - if needed" 
					type="text" maxlength="16" autocomplete="off" value="<?php if((isset($row['core_num'])) || ($row['core_num'] != "")){echo $row['core_num'];} ?>" onkeyup="coreauto()">
					<div id="core_list_id" class="list-group"></div>
				</div>
			</div><br>
			
			<div class="row">
				<div class="col-sm-4 text-right">
				</div>
				<div class="col-sm-7 form-group">
					<input type="submit" value="Submit Changes" name="submitedit" class="btn btn-default pull-left">
					<input type="hidden" name="applyupdate" value="Yes">
					<input type="hidden" name="keyid" value="<?php echo $row['key_id']; ?>">
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