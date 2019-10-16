<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $title; ?></title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" href="./css/styles.css" >
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.js"></script>
		<script type='text/javascript' src='./common/jquery.form.min.js'></script>
		<script type='text/javascript' src='./common/bootstrap.file-input.js'></script>
		<script type='text/javascript' src='./common/validate.js'></script>
		<script type="text/javascript" src="./common/autocomplete.js"></script>	
		<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.js"></script>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js"></script>
		<script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.10.19/sorting/datetime-moment.js"></script>
		<?php if($title == "Admin - Edit User" || $title == "Admin - Add User" || $title == "Update My Profile"){ ?>
		
			<script>
				function validate(form){
				var fail = ""
				fail += comparePasswords(form.password1.value, form.password2.value)	
							
				if (fail=="") return true
				else { alert(fail); return false}
				}
			</script>
			
		<?php } ?>
		
	</head>
	
	<body>
	<main class="wrapper">

	<!-- Navbar On All Pages -->
	<nav class="navbar navbar-default">
	  <div class="container">
		<div class="navbar-header">
		   <div class="brand"><a href="index.php"><img class="img-fluid" src='./img/keytrackwht.png' style="width: 180px;"></img></a></div>
		</div>
		<div class="nav navbar-nav pull-right" id="myNavbar">
		  <ul class="nav navbar-nav navbar-right">
			<li><a href="landingviewkc.php"><span class="glyphicon glyphicon-lock"></span>Cores/Keys</a></li>
			<li><a href="retrievelocations.php"><span class="glyphicon glyphicon glyphicon-home"></span>Locations</a></li>
			<li><a href="retrievekeyholder.php"><span class="glyphicon glyphicon-user"></span>Keyholders</a></li>
			<li><a href="landingcheckout.php"><span class="glyphicon glyphicon-list-alt"></span>Key Checkout</a></li>
			<li><a href="landingrekey.php"><span class="glyphicon glyphicon-transfer"></span>Rekey</a></li>
			<li><a href="landingreports.php"><span class="glyphicon glyphicon-folder-open"></span>Reports</a></li>
			<?php 
				if(isset($_SESSION['username'])){ ?>
					<li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span>Logout</a></li>
			<?php }else{ ?>
					<li><a href="index.php"><span class="glyphicon glyphicon-log-in"></span>Login</a></li>
			<?php } ?>		
		  </ul>
		</div>
	  </div>
	</nav>
	<!-- rest of content for each page defined in its own php file - starting with a boot strap fluid container in most cases --> 
	
	