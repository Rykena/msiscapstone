<?php
$title = "Edit Checkout";
$auth = array('Admin','User','View');

require_once "logincheck.php";
require_once "./common/login.php";
require_once "./common/functions.php";

if(!isset($_POST['checkout_id']) && !isset($_POST['applyupdate']) && !isset($_POST['returnkeys'])){
	header("Location: retrievecheckouts.php");
}

$conn = new mysqli($hn, $un, $pw, $db);

if($conn->connect_error) die($conn->connect_error);

if(isset($_POST['applyupdate']))
{
	$checkout_id = mysql_entities_fix_string($conn, $_POST['checkoutid']);
	$due_dt = mysql_entities_fix_string($conn, $_POST['duedt']);
	$hold_id = mysql_entities_fix_string($conn, $_POST['holdid']);
	
	updateCheckoutDue($conn,$checkout_id,$due_dt);
	
	$conn->close();
	unset($_POST['applyupdate']);
	
	header("Location: viewkeyholder.php?id=$hold_id");
}

if(isset($_POST['returnkeys']))
{
	$checkout_id = mysql_entities_fix_string($conn, $_POST['checkoutid']);
	$hold_id = mysql_entities_fix_string($conn, $_POST['holdid']);
	
	updateCheckoutReturn($conn,$checkout_id);
	
	$conn->close();
	
	unset($_POST['returnkeys']);
	header("Location: viewkeyholder.php?id=$hold_id");
}

if(isset($_POST['singlekey']))
{
	$key_check_id = mysql_entities_fix_string($conn, $_POST['key_check_id']);
	$hold_id = mysql_entities_fix_string($conn, $_POST['holdid']);
	
	singleKeyCheckoutReturn($conn,$key_check_id);
	
	$conn->close();
	
	unset($_POST['singlekey']);
	header("Location: viewkeyholder.php?id=$hold_id");
}

if(isset($_POST['checkout_id']))
{
	$checkout_id = mysql_entities_fix_string($conn, $_POST['checkout_id']);
	$holder_id = mysql_entities_fix_string($conn, $_POST['holder_id']);
	
	$row = selectCheckout($conn,$checkout_id);
	$keys = selectCheckoutKeys($conn,$checkout_id);
	$act_keys = selectActiveCheckoutKeys($conn,$checkout_id);

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
				<h2>Update Key Checkout: "<?php echo $row['hold_fname'].' '.$row['hold_lname']; ?>"</h2>
				<p>Use this page to extend the due date or return the entire checkout, or return individual keys using the table at the bottom of the page. (<a href="viewkeyholder.php?id=<?php echo $holder_id; ?>">cancel and return to Keyholder Page</a>)</p>
			</div>
		</div>
		<br>
	  <div class="row">
		<form action="editcheckout.php" method="post">
		<div class="col-sm-1">
		</div>
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
					<?php echo dateDisplay($row['checkout_startdt']); ?>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>Due Date:</b>
				</div>
				<div class="col-sm-7 form-group">
					<input type="date" id="duedate" name="duedt" min="2000-01-01" 
					<?php if(!$row['checkout_duedt'] || $row['checkout_duedt'] == ''){ ?>
					<?php }else{ ?>
					value="<?php echo date('Y-m-d',strtotime($row['checkout_duedt'])) ?>"
					<?php } ?>
					>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4 text-right">
					<b>Key(s) Originally In This Checkout:</b>
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
					<input type="submit" value="Submit Date Change" name="submitedit" class="btn btn-default">
					<input type="hidden" name="applyupdate" value="Yes">
					<input type="hidden" name="checkoutid" value="<?php echo $row['checkout_id']; ?>">
					<input type="hidden" name="holdid" value="<?php echo $row['hold_id']; ?>">
		</form>
				</div>
				<div class="col-sm-7 form-group">
				<form action="editcheckout.php" method="post">
					<input type="submit" value="Return Entire Checkout" name="returnkeys" class="btn btn-default pull-left">
					<input type="hidden" name="returnkeys" value="Yes">
					<input type="hidden" name="checkoutid" value="<?php echo $row['checkout_id']; ?>">
					<input type="hidden" name="holdid" value="<?php echo $row['hold_id']; ?>">
				</form>
				</div>
			</div>
		</div>
		</form>
	</div>
</div>
<?php if(isset($act_keys)){ ?>
<div class="container-fluid">
<div class="row">
		<div class="col-sm-1">
		</div>
		<div class="col-sm-8 panel panel-default">
	<div class="panel-body">
		<div class="panel-title">
		Keys Remaining in Checkout #<?php echo $row['checkout_id']; ?> - use this section to return an individual key
		</div>
		<div class="row">
			<div class="col-sm-12">
				<span class="small">&nbsp;</span>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
			<table class="table table-striped table-bordered">
				<tr>
					<th scope="col">Key Number</th>
					<th scope="col">Checkout Date</th>
					<th scope="col">Return Key</th>
				</tr>
				<?php foreach($act_keys as $akey){ ?>
				<tr>
					<td>
						<?php echo $akey['key_number']; ?>
					</td>
					<td><?php echo dateDisplay($row['checkout_startdt']);?></td>
					<td>
						<form method='post' action='editcheckout.php'>
							<input type="hidden" name="singlekey" value="Yes">
							<input type="hidden" name='key_check_id' value='<?php echo $akey['key_check_id'];?>'>
							<input type="hidden" name='key_id' value='<?php echo $akey['key_id'];?>'>
							<input type="hidden" name="checkoutid" value="<?php echo $row['checkout_id']; ?>">
							<input type="hidden" name="holdid" value="<?php echo $row['hold_id']; ?>">
							<input type='submit' value='Return This Key' class="btn btn-default">
						</form>
					</td>
				</tr>
				<?php } ?>
			</table>
			</div>
		</div>
	</div>
</div>
</div>
<?php }?>
</div>
<script language="javascript" type="text/javascript">
	var today = new Date();
	today.setDate(today.getDate() + 1);
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
	document.getElementById("duedate").setAttribute("min", today);
</script>	
<?php } ?>
<?php
	require_once "./common/footer.php";
?>