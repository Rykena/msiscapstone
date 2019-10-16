<?php
$title = "Admin - Add Core Diagram";
$auth = array('Admin');

require_once "logincheck.php";
require_once "./common/login.php";
require_once "./common/functions.php";

if(!isset($_POST['submitimage']) && !isset($_GET['id'])){
	header("Location: admin_retrievecores.php");
}

$conn = new mysqli($hn, $un, $pw, $db);

if($conn->connect_error) die($conn->connect_error);

if(isset($_POST['submit_image']))
{
	$uploadfile = $_FILES["upload_file"]["tmp_name"];
	$filename = $_FILES["upload_file"]["name"];
	$folder="./img/corediagrams/";
	$core_id = mysql_entities_fix_string($conn, $_POST['core_id']);
	
	move_uploaded_file($_FILES["upload_file"]["tmp_name"], "$folder".$_FILES["upload_file"]["name"]);
	$image_url = $folder.$filename;
	updateImage($conn,$core_id,$image_url);
	$conn->close();
	header("Location: admin_viewcore.php?id=$core_id");
}

if(isset($_GET['id']))
{
	$core_id = mysql_entities_fix_string($conn, $_GET['id']);
	
	$row = selectCore($conn,$core_id);

	if(!$row){
		echo "Empty Core Record";
		exit;
	}
	$conn->close();
}

require_once "./common/header.php";
?>
<script>
$(document).ready(function() {
	$('#done').hide();
	$('#subbut').hide();
	
	$('input[type=file]').bootstrapFileInput();
	$('.file-inputs').bootstrapFileInput();
	
	$('input[type=file]').change(function(e){
			$('#subbut').show();
			exit();
        });
	
	$('input[type=submit]').click(function(e){
			$('#filepick').hide();
			$('#subbut').hide();
			$('#done').show();
        });

});
</script>
<?php if(isset($row)){?>
	<!-- About -->
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<h2>Admin: Insert Core Diagram for Core Number: <?php echo $row['core_num']; ?></h2>
			<p>Use this page to upload the digram for this core. (<a href="admin_viewcore.php?id=<?php echo $row['core_id']; ?>">cancel and return to View Core Record</a>)</p>
		</div>
	</div>
	<br>
	<form action="admin_coreimage.php" method="post" id="imgform" enctype="multipart/form-data">
	<div id="filepick" class="row">
		<div class="col-sm-12 form-group">
			<input type="file" id="upload_file" name="upload_file" title="Search for the file to upload" class="btn btn-file">
		</div>
	</div><br>
	
	<div id="subbut" class="row">
		<div class="col-sm-12 form-group">
			<input type="submit" name="submit_image" value="Upload Image" class="btn btn-default">
			<input type="hidden" name="core_id" value="<?php echo $row['core_id']; ?>">
		</div>
	</div>
	</form>
	<div id="done" class="row">
		<div class="col-sm-12 form-group">
			File uploaded successfully - redirecting to core record.
		</div>
	</div>
	
</div>
<?php } ?>
<?php
	require_once "./common/footer.php";
?>