<?php
$title = "Admin - Add Key";
$auth = array('Admin');

require_once "logincheck.php";
require_once "./common/login.php";
require_once "./common/functions.php";
require_once "./common/dropdowns.php";

$conn = new mysqli($hn, $un, $pw, $db);

if($conn->connect_error) die($conn->connect_error);

if(isset($_POST['addkey']))
{
	$key_number = mysql_entities_fix_string($conn, $_POST['keynum']);
	$key_name = mysql_entities_fix_string($conn, $_POST['keydesc']);
	$key_notes = mysql_entities_fix_string($conn, $_POST['keynotes']);
	$key_type = mysql_entities_fix_string($conn, $_POST['keytype']);
	$core_num = mysql_entities_fix_string($conn, $_POST['core_id']);
	
	$key_id = keyCreate($conn,$key_number,$key_name,$key_notes,$key_type,$core_num);
	
	$conn->close();
	
	header("Location: admin_viewkey.php?id=$key_id");
}

require_once "./common/header.php";	
?>
	<!-- Intro -->
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12">
				<h2>Admin: Create New Key Record</h2>
				<p>Use this page to create a new USA Key Option (<a href="admin_retrievekeys.php">cancel and return to Key List Page</a>)</p>
			</div>
		</div>
		<br>
	  <div class="row">
		<form action="admin_addkey.php" method="post">
		<div class="col-sm-8">
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>Key Number:</b>
				</div>
				<div class="col-sm-7 form-group">
					<input class="form-control" label="keynum" id="keynum" name="keynum" type="text"
					maxlength="8" placeholder="key number" required>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>Description:</b>
				</div>
				<div class="col-sm-7 form-group">
					<input class="form-control" label="keydesc" id="keydesc" name="keydesc" type="text"
					maxlength="64" placeholder="key description">
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>Notes:</b>
				</div>
				<div class="col-sm-7 form-group">
					<textarea name="keynotes" rows="5" placeholder="Add any notes here" style="width:100%"></textarea>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>Key Type:</b>
				</div>
				<div class="col-sm-7 form-group">
					<select name="keytype" size="1" required>
						<option disabled="disabled" value="" selected="selected">Select key type..</option>
					<?php foreach($keytypedd as $keydd){ ?>
						<option value="<?php echo $keydd; ?>"><?php echo $keydd; ?></option>
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
					type="text" maxlength="16" autocomplete="off" onkeyup="coreauto()">
					<div id="core_list_id" class="list-group"></div>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-sm-4">
				</div>
				<div class="col-sm-7 form-group">
					<input type="submit" value="Create Key" name="submitnewkey" class="btn btn-default pull-left">
					<input type="hidden" name="addkey" value="Yes">
				</div>
			</div>
		</div>
		</form>
	</div>
</div>
<?php
	require_once "./common/footer.php";
?>