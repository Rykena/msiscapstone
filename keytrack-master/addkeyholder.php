<?php
$title = "Add Keyholder";
$auth = array('Admin','User','View');

require_once "logincheck.php";
require_once "./common/login.php";
require_once "./common/functions.php";
require_once "./common/dropdowns.php";

$conn = new mysqli($hn, $un, $pw, $db);

if($conn->connect_error) die($conn->connect_error);

if(isset($_POST['addkeyholder']))
{
	$hold_name = mysql_entities_fix_string($conn, $_POST['holdname']);
	$hold_fname = mysql_entities_fix_string($conn, $_POST['holdfname']);
	$hold_lname = mysql_entities_fix_string($conn, $_POST['holdlname']);
	$hold_ident = mysql_entities_fix_string($conn, $_POST['holdident']);
	$hold_email = mysql_entities_fix_string($conn, $_POST['holdemail']);
	$hold_phone = mysql_entities_fix_string($conn, $_POST['holdphone']);
	$hold_type = mysql_entities_fix_string($conn, $_POST['holdtype']);
	$hold_notes = mysql_entities_fix_string($conn, $_POST['holdnotes']);
	
	$hold_id = keyholderCreate($conn,$hold_name,$hold_fname,$hold_lname,$hold_ident,$hold_email,$hold_phone,$hold_type,$hold_notes);
	
	$conn->close();
	
	header("Location: viewkeyholder.php?id=$hold_id");
}

require_once "./common/header.php";	
?>
	<!-- Intro -->
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12">
				<h2>Create a New Keyholder</h2>
				<p>Use this page to create a new keyholder record (<a href="retrievekeyholder.php">cancel and return to Keyholder List Page</a>)</p>
			</div>
		</div>
		<br>
	  <div class="row">
		<form action="addkeyholder.php" method="post">
		<div class="col-sm-6">
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>Org/Company Name:</b>
				</div>
				<div class="col-sm-7 form-group">
					<input class="form-control" label="holdname" id="holdname" name="holdname" type="text"
					maxlength="128" placeholder="Org, Department, or Company Name">
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>First Name:</b>
				</div>
				<div class="col-sm-7 form-group">
					<input class="form-control" label="holdfname" id="holdfname" name="holdfname" type="text"
					maxlength="32" placeholder="First Name" required>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>Last Name:</b>
				</div>
				<div class="col-sm-7 form-group">
					<input class="form-control" label="holdlname" id="holdlname" name="holdlname" type="text"
					maxlength="32" placeholder="Last Name" required>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>ID Number:</b>
				</div>
				<div class="col-sm-7 form-group">
					<input class="form-control" label="holdident" id="holdident" name="holdident" type="text"
					maxlength="32" placeholder="ID number, uNID, DL, etc">
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>Email Address:</b>
				</div>
				<div class="col-sm-7 form-group">
					<input class="form-control" label="holdemail" id="holdemail" name="holdemail" type="text"
					maxlength="128" placeholder="Email Address">
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>Phone Number:</b>
				</div>
				<div class="col-sm-7 form-group">
					<input class="form-control" label="holdphone" id="holdphone" name="holdphone" type="text"
					maxlength="20" pattern="[0-9\/-.]*" placeholder="Phone Number">
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>Keyholder Type:</b>
				</div>
				<div class="col-sm-7 form-group">
					<select name="holdtype" size="1">
						<option disabled="disabled" value="" selected="selected">Select Person Type..</option>
					<?php foreach($holdtypedd as $holddd){ ?>
						<option value="<?php echo $holddd; ?>"><?php echo $holddd; ?></option>
					<?php } ?>
					</select>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>Notes:</b>
				</div>
				<div class="col-sm-7 form-group">
					<textarea name="holdnotes" rows="5" placeholder="Add any notes here" style="width:100%"></textarea>
				</div>
			</div><br>
			
			<div class="row">
				<div class="col-sm-4 text-right">
				</div>
				<div class="col-sm-7 form-group">
					<input type="submit" value="Create Keyholder" name="submitnewkeyholder" class="btn btn-default pull-left">
					<input type="hidden" name="addkeyholder" value="Yes">
				</div>
			</div>
		</div>
		</form>
	</div>
</div>
<?php
	require_once "./common/footer.php";
?>