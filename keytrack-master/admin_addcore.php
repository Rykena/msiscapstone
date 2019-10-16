<?php
$title = "Admin - Add Core";
$auth = array('Admin');

require_once "logincheck.php";
require_once "./common/login.php";
require_once "./common/functions.php";
require_once "./common/dropdowns.php";

$conn = new mysqli($hn, $un, $pw, $db);

if($conn->connect_error) die($conn->connect_error);

if(isset($_POST['addcore']))
{
	$core_num = mysql_entities_fix_string($conn, $_POST['corenum']);
	$core_cut = mysql_entities_fix_string($conn, $_POST['corecut']);
	$core_desc = mysql_entities_fix_string($conn, $_POST['coredesc']);
	$core_manf = mysql_entities_fix_string($conn, $_POST['coremanf']);
	$core_notes = mysql_entities_fix_string($conn, $_POST['corenotes']);
	$core_type = mysql_entities_fix_string($conn, $_POST['coretype']);
	
	$core_id = coreCreate($conn,$core_num,$core_cut,$core_desc,$core_manf,$core_notes,$core_type);
	
	$conn->close();
	
	header("Location: admin_viewcore.php?id=$core_id");
}

require_once "./common/header.php";	
?>
	<!-- Intro -->
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12">
				<h2>Admin: Create New Core Record</h2>
				<p>Use this page to create a new Core Record (<a href="admin_retrievecores.php">cancel and return to Core List Page</a>)</p>
			</div>
		</div>
		<br>
	  <div class="row">
		<form action="admin_addcore.php" method="post">
		<div class="col-sm-6">
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>Core Number:</b>
				</div>
				<div class="col-sm-7 form-group">
					<input class="form-control" label="corenum" id="corenum" name="corenum" type="text"
					maxlength="16" placeholder="core number" required>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>Core Cut:</b>
				</div>
				<div class="col-sm-7 form-group">
					<input class="form-control" label="corecut" id="corecut" name="corecut" type="text"
					maxlength="32" placeholder="core cut - example: 0-000-0000 ">
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>Core Type:</b>
				</div>
				<div class="col-sm-7 form-group">
					<select name="coretype" size="1" required>
						<option disabled="disabled" value="" selected="selected">Select core type..</option>
					<?php foreach($coretypedd as $coredd){ ?>
						<option value="<?php echo $coredd; ?>"><?php echo $coredd; ?></option>
					<?php } ?>
					</select>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>Description:</b>
				</div>
				<div class="col-sm-7 form-group">
					<input class="form-control" label="coredesc" id="coredesc" name="coredesc" type="text"
					maxlength="128" placeholder="core description">
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>Manufacturer:</b>
				</div>
				<div class="col-sm-7 form-group">
					<input class="form-control" label="coremanf" id="coremanf" name="coremanf" type="text"
					maxlength="32" placeholder="core manufacturer">
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>Notes:</b>
				</div>
				<div class="col-sm-7 form-group">
					<textarea name="corenotes" rows="5" placeholder="Add any notes here" style="width:100%"></textarea>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-sm-4">
				</div>
				<div class="col-sm-7 form-group">
					<input type="submit" value="Create Core" name="submitnewcore" class="btn btn-default pull-left">
					<input type="hidden" name="addcore" value="Yes">
				</div>
			</div>
		</div>
		</form>
	</div>
</div>
<?php
	require_once "./common/footer.php";
?>