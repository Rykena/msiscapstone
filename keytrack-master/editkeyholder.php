<?php
$title = "Edit Keyholder";
$auth = array('Admin','User','View');

require_once "logincheck.php";
require_once "./common/login.php";
require_once "./common/functions.php";
require_once "./common/dropdowns.php";

if(!isset($_POST['updatekeyholder']) && !isset($_POST['applyupdate'])){
	header("Location: retrievekeyholder.php");
}

$conn = new mysqli($hn, $un, $pw, $db);

if($conn->connect_error) die($conn->connect_error);

if(isset($_POST['applyupdate']))
{
	$hold_id = mysql_entities_fix_string($conn, $_POST['holdid']);
	$hold_name = mysql_entities_fix_string($conn, $_POST['holdname']);
	$hold_fname = mysql_entities_fix_string($conn, $_POST['holdfname']);
	$hold_lname = mysql_entities_fix_string($conn, $_POST['holdlname']);
	$hold_ident = mysql_entities_fix_string($conn, $_POST['holdident']);
	$hold_email = mysql_entities_fix_string($conn, $_POST['holdemail']);
	$hold_phone = mysql_entities_fix_string($conn, $_POST['holdphone']);
	$hold_type = mysql_entities_fix_string($conn, $_POST['holdtype']);
	$hold_notes = mysql_entities_fix_string($conn, $_POST['holdnotes']);
	
	keyholderUpdate($conn,$hold_id,$hold_name,$hold_fname,$hold_lname,$hold_ident,$hold_email,$hold_phone,$hold_type,$hold_notes);
	
	$conn->close();
	
	header("Location: viewkeyholder.php?id=$hold_id");
}

if(isset($_POST['updatekeyholder']))
{
	$hold_id = mysql_entities_fix_string($conn, $_POST['updholdid']);
	
	$row = selectKeyholder($conn,$hold_id);

	if(!$row){
		echo "Empty Keyholder Record";
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
				<h2>Update Details for this Keyholder: "<?php echo $row['hold_fname'].' '.$row['hold_lname']; ?>"</h2>
				<p>Use this page to update this person's information. (<a href="viewkeyholder.php?id=<?php echo $row['hold_id']; ?>">cancel and return to View Keyholder Record</a>)</p>
			</div>
		</div>
		<br>
	  <div class="row">
		<form action="editkeyholder.php" method="post">
		<div class="col-sm-6">
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>Org/Company Name:</b>
				</div>
				<div class="col-sm-7 form-group">
					<input class="form-control" label="holdname" id="holdname" name="holdname" type="text"
					maxlength="128" value="<?php echo $row['hold_name']; ?>">
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>First Name:</b>
				</div>
				<div class="col-sm-7 form-group">
					<input class="form-control" label="holdfname" id="holdfname" name="holdfname" type="text"
					maxlength="32" value="<?php echo $row['hold_fname']; ?>" required>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>Last Name:</b>
				</div>
				<div class="col-sm-7 form-group">
					<input class="form-control" label="holdlname" id="holdlname" name="holdlname" type="text"
					maxlength="32" value="<?php echo $row['hold_lname']; ?>" required>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>ID Number:</b>
				</div>
				<div class="col-sm-7 form-group">
					<input class="form-control" label="holdident" id="holdident" name="holdident" type="text"
					maxlength="32" value="<?php echo $row['hold_ident']; ?>">
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>Email Address:</b>
				</div>
				<div class="col-sm-7 form-group">
					<input class="form-control" label="holdemail" id="holdemail" name="holdemail" type="text"
					maxlength="128" value="<?php echo $row['hold_email']; ?>">
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>Phone Number:</b>
				</div>
				<div class="col-sm-7 form-group">
					<input class="form-control" label="holdphone" id="holdphone" name="holdphone" type="text"
					maxlength="20" pattern="[0-9\/-.]*" value="<?php echo $row['hold_phone']; ?>">
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>Keyholder Type:</b>
				</div>
				<div class="col-sm-7 form-group">
					<select name="holdtype" size="1">
					<?php foreach($holdtypedd as $holddd){ ?>
						<option value="<?php echo $holddd; ?>" <?php if($row['hold_type'] == $holddd) echo "selected" ?>><?php echo $holddd; ?></option>
					<?php } ?>
					</select>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>Notes:</b>
				</div>
				<div class="col-sm-7 form-group">
					<textarea name="holdnotes" rows="5" placeholder="Add any notes here" style="width:100%"><?php echo $row['hold_notes']; ?></textarea>
				</div>
			</div><br>
			
			<div class="row">
				<div class="col-sm-4 text-right">
				</div>
				<div class="col-sm-7 form-group">
					<input type="submit" value="Submit Changes" name="submitedit" class="btn btn-default pull-left">
					<input type="hidden" name="applyupdate" value="Yes">
					<input type="hidden" name="holdid" value="<?php echo $row['hold_id']; ?>">
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