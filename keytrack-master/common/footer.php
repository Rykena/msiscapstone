	<!-- Footer -->
	<div class="push"></div>
	</main>
	<hr style="border-width: 3px; color:#CC0000; border-color:#CC0000;">
	<footer class="container-fluid-footer">
	
	<div class="row">
		<div class="col-sm-6 pull-left">
		<?php
			if(isset($_SESSION['username'])){ ?>
			<p><span class="glyphicon glyphicon-user"></span>&nbsp;<a href="myprofile.php">My Profile</a>&nbsp;&nbsp;&nbsp;&nbsp;
		<?php if($_SESSION['usertype'] == 'Admin'){ ?>
			<span class="glyphicon glyphicon-cog"></span>&nbsp;<a href="admin_tools.php">Admin Tools</a></p>
		<?php } 
		} ?>	
		</div>
		<div class="col-sm-3">
			
		</div>
		<div class="col-sm-3 pull-right">
			<img class="image-fluid" src="./img/logo.png" style="width: 250px;" align="right"></img>
		</div>
	</div>
	</footer>
	</body>	
	
</html>
