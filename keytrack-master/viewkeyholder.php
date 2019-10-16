<?php
$title = "View KeyHolder";
$auth = array('Admin','User','View');

require_once "logincheck.php";
require_once "./common/login.php";
require_once "./common/functions.php";

if(isset($_GET['id'])){
	$conn = new mysqli($hn, $un, $pw, $db);

	if($conn->connect_error) die($conn->connect_error);
	
	$hold_id = mysql_entities_fix_string($conn, $_GET['id']);
	$is_act = 1;
	
	$row = selectKeyholder($conn,$hold_id);
	$checkouts = selectPersonCheckouts($conn,$is_act,$hold_id);
	$possible_lost = holderLostKeys($conn,$hold_id);
	
	if((array_key_exists('key_id',$possible_lost)) || (!empty($possible_lost))){
		$lost_keys = $possible_lost;
	}
	
}else{
	header("Location: retrievekeyholder.php");
}

require_once "./common/header.php";
?>

	<!-- About -->
<div class="container-fluid">
<div class="row">
		<div class="col-sm-12">
			<h2>Details for Keyholder: <?php echo $row['hold_fname'].' '.$row['hold_lname']; ?></h2>
			<p>Use this page to view this keyholder record. (<a href="retrievekeyholder.php">Return to Keyholder List Page</a>)</p>
		</div>
</div><br>
<div class="col-sm-6">
	<div class="row">
		<div class="col-sm-5 text-right">
			<b>Org/Company Name:</b>
		</div>
		<div class="col-sm-7 form-group">
			<?php echo $row['hold_name']; ?>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-5 text-right">
			<b>First Name:</b>
		</div>
		<div class="col-sm-7 form-group">
			<?php if($row['hold_fname'] ==''){
				echo "<i>No First Name Added</i>";
			}else{
				echo $row['hold_fname']; 
			}
			?>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-5 text-right">
			<b>Last Name:</b>
		</div>
		<div class="col-sm-7 form-group">
			<?php echo $row['hold_lname']; ?>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-5 text-right">
			<b>ID Number:</b>
		</div>
		<div class="col-sm-7 form-group">
			<?php if($row['hold_ident'] ==''){
				echo "<i>No ID Number Added</i>";
			}else{
				echo $row['hold_ident']; 
			}
			?>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-5 text-right">
			<b>Email Address:</b>
		</div>
		<div class="col-sm-7 form-group">
			<?php if($row['hold_email'] ==''){
				echo "<i>No Email Address Added</i>";
			}else{
				echo $row['hold_email']; 
			}
			?>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-5 text-right">
			<b>Phone Number:</b>
		</div>
		<div class="col-sm-7 form-group">
			<?php if($row['hold_phone'] ==''){
				echo "<i>No Phone Number Added</i>";
			}else{
				echo $row['hold_phone']; 
			}
			?>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-5 text-right">
			<b>Keyholder Type:</b>
		</div>
		<div class="col-sm-7 form-group">
			<?php if($row['hold_type'] ==''){
				echo "<i>No Keyholder Type Added</i>";
			}else{
				echo $row['hold_type']; 
			}
			?>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-5 text-right">
			<b>Notes:</b>
		</div>
		<div class="col-sm-7 form-group">
			<?php if($row['hold_notes'] ==''){
				echo "<i>No Notes Added</i>";
			}else{
				echo $row['hold_notes']; 
			}
			?>
		</div>
	</div>

	<br>
	<div class="row">
		<div class="col-sm-5 form-group">
		<form method="post" action="editkeyholder.php">
			<input type="submit" value="Edit Keyholder Details" name="updatekeyholder" class="btn btn-default pull-right">
			<input type="hidden" value="<?php echo $row['hold_id']; ?>" name="updholdid">
		</form>
		</div>
		<div class="col-sm-5 form-group">
		<form method="post" action="newcheckout.php">
			<input type="submit" value="New Key Checkout for This Person" name="newkey" class="btn btn-default">
			<input type="hidden" value="<?php echo $row['hold_id']; ?>" name="hold_id">
		</form>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-sm-5 form-group">
		<form method="post" action="keyholderkeys.php">
			<input type="submit" value="Report a Lost Key" name="reportlost" class="btn btn-default pull-right">
			<input type="hidden" value="<?php echo $row['hold_id']; ?>" name="hold_id">
		</form>
		</div>
	</div>
</div>
<!-- this side has the panel that shows key checkouts for this person -->
<div class="col-sm-6 panel panel-default">
	<div class="panel-body">
		<div class="panel-title">
		Key Checkouts
		</div>
		<div class="row">
			<div class="col-sm-12">
				<span class="small">Active Key Checkouts for This Person</span>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
			<table class="table table-striped table-bordered">
				<tr>
					<th scope="col">Key(s)</th>
					<th scope="col">Checkout Date</th>
					<th scope="col">Due Date</th>
					<th scope="col">Edit Checkout</th>
				</tr>
				<?php foreach($checkouts as $chk){ ?>
				<tr>
					<td>
						<?php $keys = selectActiveCheckoutKeys($conn,$chk['checkout_id']);
							$keyout = '';
							foreach($keys as $key){
								$keyout = $keyout.$key['key_number'].', ';
							}
							echo substr($keyout, 0, -2); ?>
					</td>
					<td><?php echo dateDisplay($chk['checkout_startdt']);?></td>
					<td><?php if(!$chk['checkout_duedt'] || $chk['checkout_duedt'] == ''){
							echo "N/A";
						}else{
							echo dateDisplay($chk['checkout_duedt']);
						} ?>
					</td>
					<td>
						<form method='post' action='editcheckout.php'>
							<input type="hidden" name='checkout_id' value='<?php echo $chk['checkout_id'];?>'>
							<input type="hidden" name='holder_id' value='<?php echo $chk['hold_id'];?>'>
							<input type='submit' value='Edit/Return' class="btn btn-default">
						</form>
					</td>
				</tr>
				<?php } ?>
			</table>
			(<a href="historicalcheckouts.php?id=<?php echo $row['hold_id']; ?>">View Person's Returned Keys</a>)
			</div>
		</div>
	</div>
</div>
</div>
<!-- this section shows any lost keys for this person, if any - otherwise it is hidden -->
<?php if(isset($lost_keys)){
		if((array_key_exists('key_id',$lost_keys)) || (!empty($lost_keys))){ ?>
<div class="container-fluid">
<div class="row">
		<div class="col-sm-1">
		</div>
		<div class="col-sm-10 panel panel-default">
	<div class="panel-body">
		<div class="panel-title">
		Lost Key History for <?php echo $row['hold_fname'].' '.$row['hold_lname']; ?>
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
					<th scope="col">Key</th>
					<th scope="col">Checkout Date</th>
					<th scope="col">Date Reported Lost</th>
					<th scope="col">Date Key Found</th>
					<th scope="col">Mark as Found</th>
				</tr>
				<?php foreach($lost_keys as $lkey){ ?>
				<tr>
					<td>
						<?php echo $lkey['key_number']; ?>
					</td>
					<td><?php echo dateDisplay($lkey['checkout_startdt']);?></td>
					<td><?php if(!$lkey['key_check_lostdt'] || $lkey['key_check_lostdt'] == ''){
							echo "N/A";
						}else{
							echo dateDisplay($lkey['key_check_lostdt']);
						} ?>
					</td>
					<td><?php if(!$lkey['key_check_lost_return'] || $lkey['key_check_lost_return'] == ''){
							echo "Not Yet Returned";
						}else{
							echo dateDisplay($lkey['key_check_lost_return']);
						} ?>
					</td>
				<td><?php if((!$lkey['key_check_lost_return'] || $lkey['key_check_lost_return'] == '') && !$lkey['key_return_dt']){ ?>
							<form method='post' action='processreturnkey.php'>
							<input type="hidden" name='key_check_id' value='<?php echo $lkey['key_check_id'];?>'>
							<input type="hidden" name='key_id' value='<?php echo $lkey['key_id'];?>'>
							<input type="hidden" name='hold_id' value='<?php echo $lkey['hold_id'];?>'>
							<input type='submit' value='Mark as Found' class="btn btn-default">
						</form>
						<?php }else{
							echo "Key Reported as Found";
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
<?php } }?>
</div>

<?php
	$conn->close();
	require_once "./common/footer.php";
?>
