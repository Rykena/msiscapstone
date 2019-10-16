<?php
$title = "Admin: Edit Checkout Dates";
$auth = array('Admin');

require_once "logincheck.php";
require_once "./common/login.php";
require_once "./common/functions.php";

if(!isset($_POST['checkout_id']) && !isset($_POST['applyupdate'])){
	header("Location: admin_retrievekeykeyholders.php");
}

$conn = new mysqli($hn, $un, $pw, $db);

if($conn->connect_error) die($conn->connect_error);

if(isset($_POST['applyupdate']))
{
	$checkout_id = mysql_entities_fix_string($conn, $_POST['checkoutid']);
	$start_dt = mysql_entities_fix_string($conn, $_POST['startdt']);
	$due_dt = mysql_entities_fix_string($conn, $_POST['duedt']);
	$return_dt = mysql_entities_fix_string($conn, $_POST['returndt']);
	
	updateCheckoutStartDate($conn,$checkout_id,$start_dt);
	updateCheckoutDueDate($conn,$checkout_id,$due_dt);
	updateCheckoutReturnDate($conn,$checkout_id,$return_dt);
	
	$conn->close();
	unset($_POST['applyupdate']);
	
	header("Location: admin_retrievekeykeyholders.php");
}

if(isset($_POST['checkout_id']))
{
	$checkout_id = mysql_entities_fix_string($conn, $_POST['checkout_id']);
	
	$row = selectCheckout($conn,$checkout_id);
	$keys = selectCheckoutKeys($conn,$checkout_id);

	if(!$row){
		echo "Empty Checkout Record";
		exit;
	}
	$conn->close();
	unset($_POST['checkout_id']);
}

require_once "./common/header.php";	
?>
<?php if(isset($row)){?>
	<!-- Intro -->
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12">
				<h2>Admin: Update Key Checkout Dates</h2>
				<p>Use this page to modify any dates for this checkout record. (<a href="admin_retrievekeykeyholders.php">cancel and return to Admin Key-Keyholder List Page</a>)</p>
			</div>
		</div>
		<br>
	  <div class="row">
		<form action="admin_editcheckout.php" method="post">
		<div class="col-sm-6">
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>Org/Company Name:</b>
				</div>
				<div class="col-sm-7 form-group">
					<?php echo $row['hold_name']; ?>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>First Name:</b>
				</div>
				<div class="col-sm-7 form-group">
					<?php echo $row['hold_fname']; ?>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>Last Name:</b>
				</div>
				<div class="col-sm-7 form-group">
					<?php echo $row['hold_lname']; ?>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>Checkout Date:</b>
				</div>
				<div class="col-sm-7 form-group">
					<input type="date" id="startdt" name="startdt" 
					<?php if(!$row['checkout_startdt'] || $row['checkout_startdt'] == ''){ ?>
					<?php }else{ ?>
					value="<?php echo date('Y-m-d', strtotime($row['checkout_startdt'])); ?>"
					<?php } ?>
					required >
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>Due Date:</b>
				</div>
				<div class="col-sm-7 form-group">
					<input type="date" id="duedt" name="duedt" 
					<?php if(!$row['checkout_duedt'] || $row['checkout_duedt'] == ''){ ?>
					<?php }else{ ?>
					value="<?php echo date('Y-m-d',strtotime($row['checkout_duedt'])) ?>"
					<?php } ?>
					>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>Return Date:</b>
				</div>
				<div class="col-sm-7 form-group">
					<input type="date" id="returndt" name="returndt" 
					<?php if(!$row['checkout_enddt'] || $row['checkout_enddt'] == ''){ ?>
					<?php }else{ ?>
					value="<?php echo date('Y-m-d',strtotime($row['checkout_enddt'])) ?>"
					<?php } ?>
					>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>Key(s) In This Checkout:</b>
				</div>
				<div class="col-sm-7 form-group">
					<?php $keyout = '';
							foreach($keys as $key){
								$keyout = $keyout.$key['key_number'].', ';
							}
							echo substr($keyout, 0, -2); 
					?>
				</div>
			</div>
			<br>
			
			<div class="row">
				<div class="col-sm-4 text-right">
					<input type="submit" value="Submit Date Changes" name="submitedit" class="btn btn-default">
					<input type="hidden" name="applyupdate" value="Yes">
					<input type="hidden" name="checkoutid" value="<?php echo $row['checkout_id']; ?>">
		
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