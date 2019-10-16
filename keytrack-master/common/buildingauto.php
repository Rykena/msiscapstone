<?php
	require_once "login.php";
	require_once "functions.php";

	$conn = new mysqli($hn, $un, $pw, $db);
	if($conn->connect_error) die($conn->connect_error);
	
	$request = mysqli_real_escape_string($conn, $_POST["keyword"]);
	
	if($request != ""){
		$query = "SELECT * FROM building WHERE bldg_num LIKE '%".$request."%' LIMIT 10";

		$result = mysqli_query($conn, $query);

		$data = array();

		if(mysqli_num_rows($result) > 0)
		{
		 while($row = mysqli_fetch_assoc($result))
		 {
		  $building = strtoupper(str_replace($_POST["keyword"], '<b>'.$_POST["keyword"].'</b>', $row['bldg_num']));
		  echo '<a href="javascript:;" class="list-group-item" style="height: 30px; padding: 0px 10px;" onclick="set_building_item(\''.str_replace("'", "\'", $row['bldg_num']).'\')">'.$building.'</a>';
		 }
		}
	}

?>