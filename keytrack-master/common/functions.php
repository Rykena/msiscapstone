<?php
	
	// functions will be added here
	
	// function to hash entered password and return token
	function tokenizePW($string){
		$salt1 = 'qm&h*';
		$salt2 = 'pg!@';
		$token = hash('ripemd128',"$salt1$string$salt2");
		return $token;
	}
	
	// data cleaning function one
	function mysql_entities_fix_string($conn, $string){
		return htmlentities(mysql_fix_string($conn, $string));	
	}
	
	// data cleaning function two
	function mysql_fix_string($conn, $string){
		if(get_magic_quotes_gpc()) $string = stripslashes($string);
		return $conn->real_escape_string($string);
	}
	
	// session ending function for logout
	function destroy_session_and_data(){
		$_SESSION = array(); 
		setCookie(session_name(), '', time()-2592000, '/');
		session_destroy(); 
	}
	
	// reformat datetime to more appealing view
	function timeDisplay($timefromdb){
		$time = strtotime($timefromdb);
		$myFormatForView = date("m/d/Y g:i A", $time);
		return $myFormatForView;
	}
	
	// reformat date to more appealing view - minus timestamp
	function dateDisplay($timefromdb){
		$time = strtotime($timefromdb);
		$myFormatForView = date("m/d/Y", $time);
		return $myFormatForView;
	}
	
	// select all info on specified account
	function selectUser($conn,$user_id){
		$query = "SELECT * FROM ktuser WHERE user_id = '$user_id' ";
		$result = mysqli_query($conn, $query);
		if(!$result){
		    echo "Record not found" . mysqli_error($conn);
		    exit;
		}
		$row = $result->fetch_array(MYSQLI_ASSOC);
		return $row;
	}
	
	// select all users from ktuser table and return in array
	function selectAllUsers($conn){
		$users = array();
		$query = "SELECT * FROM ktuser";
		$result = mysqli_query($conn, $query);
		if(!$result){
		    echo "Records not found" . mysqli_error($conn);
		    exit;
		}
		$rows = $result->num_rows;
		for($j=0; $j<$rows; $j++){
			while($row = $result->fetch_array(MYSQLI_ASSOC)){
				array_push($users, $row);
			}
		}
		return $users;
	}
	
	// toggle active status on user account
	function userActiveSet($conn,$user_id,$act_val){
		if($act_val == 0){
			$newact_val = 1;
		}else{
			$newact_val = 0;
		}
		$query = "UPDATE ktuser set user_is_act='$newact_val' where user_id='$user_id' ";
		$result = mysqli_query($conn, $query);
		if(!$result){
		    echo "Update Failed" . mysqli_error($conn);
		    exit;
		}
	}
	
	// update user account
	function userUpdate($conn,$user_id,$fname,$lname,$phone,$email,$password,$unid,$type){
		if($password == ""){
			$query = "UPDATE ktuser set user_fname='$fname', user_lname='$lname', user_phone='$phone', user_email='$email', user_unid='$unid', user_type='$type'
			where user_id='$user_id'";
		}else{
			$token = tokenizePW($password);
			$query = "UPDATE ktuser set user_fname='$fname', user_lname='$lname', user_phone='$phone', user_email='$email', user_unid='$unid', user_type='$type', user_pass='$token'
			where user_id='$user_id'";
		}
		$result = mysqli_query($conn, $query);
		if(!$result){
		    echo "Update Failed" . mysqli_error($conn);
		    exit;
		}
	}
	
	// create new user record in ktuser table
	function userCreate($conn,$user_name,$fname,$lname,$phone,$email,$password,$unid,$type){
		$token = tokenizePW($password);
		$query = "INSERT into ktuser (user_name,user_pass,user_fname,user_lname,user_email,user_phone,user_unid,user_type)
		values ('$user_name','$token','$fname','$lname','$email','$phone','$unid','$type')";
		$result = mysqli_query($conn, $query);
		if(!$result){
		    echo "Creation Failed" . mysqli_error($conn);
		    exit;
		}
		$last_id = mysqli_insert_id($conn);
		return $last_id;
	}
	
	// select all buildings from building table and return in array
	function selectAllBuild($conn){
		$buildings = array();
		$query = "SELECT * FROM building";
		$result = mysqli_query($conn, $query);
		if(!$result){
		    echo "Records not found" . mysqli_error($conn);
		    exit;
		}
		$rows = $result->num_rows;
		for($j=0; $j<$rows; $j++){
			while($row = $result->fetch_array(MYSQLI_ASSOC)){
				array_push($buildings, $row);
			}
		}
		return $buildings;
	}
	
	// select all info on specified building
	function selectBuild($conn,$bldg_id){
		$query = "SELECT * FROM building WHERE bldg_id = '$bldg_id' ";
		$result = mysqli_query($conn, $query);
		if(!$result){
		    echo "Record not found" . mysqli_error($conn);
		    exit;
		}
		$row = $result->fetch_array(MYSQLI_ASSOC);
		return $row;
	}
	
	// toggle active status on buildings
	function buildActiveSet($conn,$bldg_id,$act_val){
		if($act_val == 0){
			$newact_val = 1;
		}else{
			$newact_val = 0;
		}
		$query = "UPDATE building set bldg_is_act='$newact_val' where bldg_id='$bldg_id' ";
		$result = mysqli_query($conn, $query);
		if(!$result){
		    echo "Update Failed" . mysqli_error($conn);
		    exit;
		}
	}
	
	// update building record
	function buildUpdate($conn,$bldg_id,$bldgdesc,$bldgprop,$bldgnotes){
		$query = "UPDATE building set bldg_desc='$bldgdesc', bldg_prop='$bldgprop', bldg_notes='$bldgnotes' where bldg_id='$bldg_id'";
		$result = mysqli_query($conn, $query);
		if(!$result){
		    echo "Update Failed" . mysqli_error($conn);
		    exit;
		}
	}
	
	// create new building record in building table
	function buildCreate($conn,$bldg_num,$bldg_desc,$bldg_prop,$bldg_notes){
		$query = "INSERT into building (bldg_num,bldg_desc,bldg_prop,bldg_notes)
		values ('$bldg_num','$bldg_desc','$bldg_prop','$bldg_notes')";
		$result = mysqli_query($conn, $query);
		if(!$result){
		    echo "Creation Failed" . mysqli_error($conn);
		    exit;
		}
		$last_id = mysqli_insert_id($conn);
		return $last_id;
	}
	
	// select all locations from location table with building number and property from building table and return in array
	function selectAllLocations($conn){
		$locations = array();
		$query = "SELECT l.loc_id, l.loc_unit_num,l.loc_desc,l.loc_insertdt,l.loc_notes,l.loc_is_act,l.loc_type,l.bldg_id,l.loc_mailbox,l.loc_mail_core, b.bldg_num, b.bldg_prop 
			FROM location l LEFT OUTER JOIN building b ON l.bldg_id = b.bldg_id";
		$result = mysqli_query($conn, $query);
		if(!$result){
		    echo "Records not found" . mysqli_error($conn);
		    exit;
		}
		$rows = $result->num_rows;
		for($j=0; $j<$rows; $j++){
			while($row = $result->fetch_array(MYSQLI_ASSOC)){
				array_push($locations, $row);
			}
		}
		return $locations;
	}
	
	// select all info on specified location including building number and property
	function selectLocation($conn,$loc_id){
		$query = "SELECT l.loc_id, l.loc_unit_num,l.loc_desc,l.loc_insertdt,l.loc_notes,l.loc_is_act,l.loc_type,l.bldg_id,l.loc_mailbox,l.loc_mail_core, b.bldg_num, b.bldg_prop 
			FROM location l LEFT OUTER JOIN building b ON l.bldg_id = b.bldg_id WHERE l.loc_id = '$loc_id' ";
		$result = mysqli_query($conn, $query);
		if(!$result){
		    echo "Record not found" . mysqli_error($conn);
		    exit;
		}
		$row = $result->fetch_array(MYSQLI_ASSOC);
		return $row;
	}
	
	// toggle active status on locations
	function locationActiveSet($conn,$loc_id,$act_val){
		if($act_val == 0){
			$newact_val = 1;
		}else{
			$newact_val = 0;
		}
		$query = "UPDATE location set loc_is_act='$newact_val' where loc_id='$loc_id' ";
		$result = mysqli_query($conn, $query);
		if(!$result){
		    echo "Update Failed" . mysqli_error($conn);
		    exit;
		}
	}
	
	// update location record - also finds bldg_id based on bldg_num input
	function locUpdate($conn,$loc_id,$loc_unit_num,$loc_desc,$loc_notes,$loc_type,$bldg_num,$loc_mailbox,$loc_mail_core){
		if($bldg_num != ''){
			$query = "SELECT bldg_id FROM building WHERE bldg_num = '$bldg_num' ";
			$result = mysqli_query($conn, $query);
			if(!$result){
				echo "Record not found" . mysqli_error($conn);
				exit;
			}
			$row = $result->fetch_array(MYSQLI_ASSOC);
			$bldg_id = $row['bldg_id'];
		}else{
			
		}
		if($bldg_num != ''){
			$query2 = "UPDATE location set loc_unit_num='$loc_unit_num', loc_desc='$loc_desc', loc_notes='$loc_notes', loc_type='$loc_type',bldg_id='$bldg_id',loc_mailbox='$loc_mailbox',loc_mail_core='$loc_mail_core' 
						where loc_id='$loc_id'";
			$result2 = mysqli_query($conn, $query2);
			if(!$result2){
				echo "Update Failed" . mysqli_error($conn);
				exit;
			}
		}else{
			$query2 = "UPDATE location set loc_unit_num='$loc_unit_num', loc_desc='$loc_desc', loc_notes='$loc_notes', loc_type='$loc_type', loc_mailbox='$loc_mailbox',loc_mail_core='$loc_mail_core' 
						where loc_id='$loc_id'";
			$result2 = mysqli_query($conn, $query2);
			if(!$result2){
				echo "Update Failed" . mysqli_error($conn);
				exit;
			}
		}
	}
	
	// create new location record in location table, reference building table to get bldg_id
	function locationCreate($conn,$loc_unit_num,$loc_desc,$loc_notes,$loc_type,$bldg_num,$loc_mailbox,$loc_mail_core){
		if($bldg_num != ''){
			$query = "SELECT bldg_id FROM building WHERE bldg_num = '$bldg_num' ";
			$result = mysqli_query($conn, $query);
			if(!$result){
				echo "Record not found" . mysqli_error($conn);
				exit;
			}
			$row = $result->fetch_array(MYSQLI_ASSOC);
			$bldg_id = $row['bldg_id'];
		}else{
			
		}
		if($bldg_num != ''){
			$query2 = "INSERT into location (loc_unit_num,loc_desc,loc_notes,loc_type,bldg_id,loc_mailbox,loc_mail_core)
			values ('$loc_unit_num','$loc_desc','$loc_notes','$loc_type','$bldg_id','$loc_mailbox','$loc_mail_core') ";
			$result2 = mysqli_query($conn, $query2);
			if(!$result2){
				echo "Creation Failed" . mysqli_error($conn);
				exit;
			}
			$last_id = mysqli_insert_id($conn);
			return $last_id;
		}else{
			$query2 = "INSERT into location (loc_unit_num,loc_desc,loc_notes,loc_type,loc_mailbox,loc_mail_core)
			values ('$loc_unit_num','$loc_desc','$loc_notes','$loc_type','$loc_mailbox','$loc_mail_core') ";
			$result2 = mysqli_query($conn, $query2);
			if(!$result2){
				echo "Creation Failed" . mysqli_error($conn);
				exit;
			}
			$last_id = mysqli_insert_id($conn);
			return $last_id;
		}
	}
	
	// select all cores from core table and return in array
	function selectAllCore($conn){
		$cores = array();
		$query = "SELECT * FROM core";
		$result = mysqli_query($conn, $query);
		if(!$result){
		    echo "Records not found" . mysqli_error($conn);
		    exit;
		}
		$rows = $result->num_rows;
		for($j=0; $j<$rows; $j++){
			while($row = $result->fetch_array(MYSQLI_ASSOC)){
				array_push($cores, $row);
			}
		}
		return $cores;
	}
	
	// select all info on specified core
	function selectCore($conn,$core_id){
		$query = "SELECT * FROM core WHERE core_id = '$core_id' ";
		$result = mysqli_query($conn, $query);
		if(!$result){
		    echo "Record not found" . mysqli_error($conn);
		    exit;
		}
		$row = $result->fetch_array(MYSQLI_ASSOC);
		return $row;
	}
	
	// toggle active status on cores
	function coreActiveSet($conn,$core_id,$act_val){
		if($act_val == 0){
			$newact_val = 1;
		}else{
			$newact_val = 0;
		}
		$query = "UPDATE core set core_is_act='$newact_val' where core_id='$core_id' ";
		$result = mysqli_query($conn, $query);
		if(!$result){
		    echo "Update Failed" . mysqli_error($conn);
		    exit;
		}
	}
	
	// update core record - except image link
	function coreUpdate($conn,$core_id,$core_cut,$core_desc,$core_manf,$core_notes,$core_type){
		$query = "UPDATE core set core_cut='$core_cut', core_desc='$core_desc', core_manf='$core_manf', core_notes='$core_notes', core_type='$core_type' where core_id='$core_id'";
		$result = mysqli_query($conn, $query);
		if(!$result){
		    echo "Update Failed" . mysqli_error($conn);
		    exit;
		}
	}
	
	// create new core record in core table - except image link
	function coreCreate($conn,$core_num,$core_cut,$core_desc,$core_manf,$core_notes,$core_type){
		$query = "INSERT into core (core_num,core_cut,core_desc,core_manf,core_notes,core_type)
		values ('$core_num','$core_cut','$core_desc','$core_manf','$core_notes','$core_type')";
		$result = mysqli_query($conn, $query);
		if(!$result){
		    echo "Creation Failed" . mysqli_error($conn);
		    exit;
		}
		$last_id = mysqli_insert_id($conn);
		return $last_id;
	}
	
	// select all keys from key table with core number and core type from core table and return in array
	function selectAllKeys($conn){
		$keys = array();
		$query = "SELECT k.key_id,k.key_name,k.key_number,k.key_insertdt,k.key_notes,k.key_is_act,k.key_type,c.core_id,c.core_num,c.core_type 
			FROM ktkey k LEFT OUTER JOIN core c ON k.core_id = c.core_id";
		$result = mysqli_query($conn, $query);
		if(!$result){
		    echo "Records not found" . mysqli_error($conn);
		    exit;
		}
		$rows = $result->num_rows;
		for($j=0; $j<$rows; $j++){
			while($row = $result->fetch_array(MYSQLI_ASSOC)){
				array_push($keys, $row);
			}
		}
		return $keys;
	}
	
	// select all ACTIVE keys from key table with core number and core type from core table and return in array
	function selectAllActiveKeys($conn){
		$keys = array();
		$query = "SELECT k.key_id,k.key_name,k.key_number,k.key_insertdt,k.key_notes,k.key_is_act,k.key_type,c.core_id,c.core_num,c.core_type 
			FROM ktkey k LEFT OUTER JOIN core c ON k.core_id = c.core_id WHERE k.key_is_act = 1";
		$result = mysqli_query($conn, $query);
		if(!$result){
		    echo "Records not found" . mysqli_error($conn);
		    exit;
		}
		$rows = $result->num_rows;
		for($j=0; $j<$rows; $j++){
			while($row = $result->fetch_array(MYSQLI_ASSOC)){
				array_push($keys, $row);
			}
		}
		return $keys;
	}
	
	// select all info on specified key including core number and type
	function selectKey($conn,$key_id){
		$query = "SELECT k.key_id,k.key_name,k.key_number,k.key_insertdt,k.key_notes,k.key_is_act,k.key_type,c.core_id,c.core_num,c.core_cut,c.core_type 
			FROM ktkey k LEFT OUTER JOIN core c ON k.core_id = c.core_id WHERE k.key_id = '$key_id' ";
		$result = mysqli_query($conn, $query);
		if(!$result){
		    echo "Record not found" . mysqli_error($conn);
		    exit;
		}
		$row = $result->fetch_array(MYSQLI_ASSOC);
		return $row;
	}
	
	// toggle active status on keys
	function keyActiveSet($conn,$key_id,$act_val){
		if($act_val == 0){
			$newact_val = 1;
		}else{
			$newact_val = 0;
		}
		$query = "UPDATE ktkey set key_is_act='$newact_val' where key_id='$key_id' ";
		$result = mysqli_query($conn, $query);
		if(!$result){
		    echo "Update Failed" . mysqli_error($conn);
		    exit;
		}
	}
	
	// update key record - also finds core_id based on core_num input
	function keyUpdate($conn,$key_id,$key_number,$key_name,$key_notes,$key_type,$core_num){
		$core_needed = '';
		if((!isset($core_num)) || ($core_num == "")){
			$core_needed = false;
		}else{	
			$query = "SELECT core_id FROM core WHERE core_num = '$core_num' ";
			$result = mysqli_query($conn, $query);
			if(!$result){
				echo "Record not found" . mysqli_error($conn);
				exit;
			}
			$row = $result->fetch_array(MYSQLI_ASSOC);
			$core_id = $row['core_id'];
			$core_needed = true;
		}
		if($core_needed == true){
			$query2 = "UPDATE ktkey set key_number='$key_number', key_name='$key_name', key_notes='$key_notes', key_type='$key_type',core_id='$core_id' 
						where key_id='$key_id'";
		}else{
			$query2 = "UPDATE ktkey set key_number='$key_number', key_name='$key_name', key_notes='$key_notes', key_type='$key_type',core_id= NULL 
						where key_id='$key_id'";
		}
		$result2 = mysqli_query($conn, $query2);
		if(!$result2){
		    echo "Update Failed" . mysqli_error($conn);
		    exit;
		}
	}
	
	// create new key record in ktkey table, reference core table to get core_id if needed
	function keyCreate($conn,$key_number,$key_name,$key_notes,$key_type,$core_num){
		$core_needed = '';
		if((!isset($core_num)) || ($core_num == "")){
			$core_needed = false;
		}else{	
			$query = "SELECT core_id FROM core WHERE core_num = '$core_num' ";
			$result = mysqli_query($conn, $query);
			if(!$result){
				echo "Record not found" . mysqli_error($conn);
				exit;
			}
			$row = $result->fetch_array(MYSQLI_ASSOC);
			$core_id = $row['core_id'];
			$core_needed = true;
		}
		if($core_needed == true){
			$query2 = "INSERT into ktkey (key_number,key_name,key_notes,key_type,core_id)
			values ('$key_number','$key_name','$key_notes','$key_type','$core_id')";
		}else{
			$query2 = "INSERT into ktkey (key_number,key_name,key_notes,key_type)
			values ('$key_number','$key_name','$key_notes','$key_type')";
		}
		$result2 = mysqli_query($conn, $query2);
		if(!$result2){
		    echo "Creation Failed" . mysqli_error($conn);
		    exit;
		}
		$last_id = mysqli_insert_id($conn);
		return $last_id;
	}
	
	// function that updates the URL in the core table for its diagram image
	function updateImage($conn,$core_id,$image_url){
		$query = "UPDATE core set core_diagram='$image_url' where core_id='$core_id'";
		$result = mysqli_query($conn, $query);
		if(!$result){
		    echo "Update Failed" . mysqli_error($conn);
		    exit;
		}
	}
	
	// select all keyholders from keyholder table and return in array
	function selectAllKeyholders($conn){
		$keyholders = array();
		$query = "SELECT *
			FROM keyholder";
		$result = mysqli_query($conn, $query);
		if(!$result){
		    echo "Records not found" . mysqli_error($conn);
		    exit;
		}
		$rows = $result->num_rows;
		for($j=0; $j<$rows; $j++){
			while($row = $result->fetch_array(MYSQLI_ASSOC)){
				array_push($keyholders, $row);
			}
		}
		return $keyholders;
	}
	
	// select desired keyholder data from keyholder table
	function selectKeyholder($conn,$hold_id){
		$query = "SELECT * FROM keyholder WHERE hold_id = '$hold_id' ";
		$result = mysqli_query($conn, $query);
		if(!$result){
		    echo "Record not found" . mysqli_error($conn);
		    exit;
		}
		$row = $result->fetch_array(MYSQLI_ASSOC);
		return $row;
	}
	
	// function used to manage "checkout cart" contents
	function total_items($cart){
		$items = 0;
		if(is_array($cart)){
			foreach($cart as $key_id => $qty){
				$items += $qty;
			}
		}
		return $items;
	}
	
	// select all info on specified key checkout order - including data on keyholder
	function selectCheckout($conn,$checkout_id){
		$query = "SELECT c.checkout_id,c.checkout_startdt,c.checkout_duedt,c.checkout_enddt,k.hold_id,k.hold_name,k.hold_fname,k.hold_lname,k.hold_ident,k.hold_email,k.hold_phone 
			FROM checkout c INNER JOIN keyholder k ON c.hold_id = k.hold_id WHERE c.checkout_id = '$checkout_id' ";
		$result = mysqli_query($conn, $query);
		if(!$result){
		    echo "Record not found" . mysqli_error($conn);
		    exit;
		}
		$row = $result->fetch_array(MYSQLI_ASSOC);
		return $row;
	}
	
	// select all keys from a specified checkout and return in array
	function selectCheckoutKeys($conn,$checkout_id){
		$keys = array();
		$query = "SELECT c.key_check_qty,k.key_name,k.key_number,k.key_type,k.key_id,c.key_check_id
			FROM key_checkout c INNER JOIN ktkey k ON c.key_id = k.key_id WHERE c.checkout_id = '$checkout_id' ";
		$result = mysqli_query($conn, $query);
		if(!$result){
		    echo "Records not found" . mysqli_error($conn);
		    exit;
		}
		$rows = $result->num_rows;
		for($j=0; $j<$rows; $j++){
			while($row = $result->fetch_array(MYSQLI_ASSOC)){
				array_push($keys, $row);
			}
		}
		return $keys;
	}
	
	// select all keys THAT ARE NOT RETURNED from a specified checkout and return in array
	function selectActiveCheckoutKeys($conn,$checkout_id){
		$keys = array();
		$query = "SELECT c.key_check_qty,k.key_name,k.key_number,k.key_type,k.key_id,c.key_check_id
			FROM key_checkout c INNER JOIN ktkey k ON c.key_id = k.key_id WHERE c.checkout_id = '$checkout_id' AND c.key_return_dt IS NULL";
		$result = mysqli_query($conn, $query);
		if(!$result){
		    echo "Records not found" . mysqli_error($conn);
		    exit;
		}
		$rows = $result->num_rows;
		for($j=0; $j<$rows; $j++){
			while($row = $result->fetch_array(MYSQLI_ASSOC)){
				array_push($keys, $row);
			}
		}
		return $keys;
	}
	
	// toggle active status on keyholders
	function keyholderActiveSet($conn,$hold_id,$act_val){
		if($act_val == 0){
			$newact_val = 1;
		}else{
			$newact_val = 0;
		}
		$query = "UPDATE keyholder set hold_is_act='$newact_val' where hold_id='$hold_id' ";
		$result = mysqli_query($conn, $query);
		if(!$result){
		    echo "Update Failed" . mysqli_error($conn);
		    exit;
		}
	}
	
	// update keyholder record
	function keyholderUpdate($conn,$hold_id,$hold_name,$hold_fname,$hold_lname,$hold_ident,$hold_email,$hold_phone,$hold_type,$hold_notes){
		$query = "UPDATE keyholder set hold_name='$hold_name', hold_fname='$hold_fname', hold_lname='$hold_lname', hold_ident='$hold_ident', 
		hold_email='$hold_email', hold_phone='$hold_phone', hold_type='$hold_type', hold_notes='$hold_notes' where hold_id='$hold_id' ";
		$result = mysqli_query($conn, $query);
		if(!$result){
		    echo "Update Failed" . mysqli_error($conn);
		    exit;
		}
	}
	
	// create new keyholder record in keyholder table
	function keyholderCreate($conn,$hold_name,$hold_fname,$hold_lname,$hold_ident,$hold_email,$hold_phone,$hold_type,$hold_notes){
		$query = "INSERT into keyholder (hold_name,hold_fname,hold_lname,hold_ident,hold_email,hold_phone,hold_type,hold_notes)
		values ('$hold_name','$hold_fname','$hold_lname','$hold_ident','$hold_email','$hold_phone','$hold_type','$hold_notes')";
		$result = mysqli_query($conn, $query);
		if(!$result){
		    echo "Creation Failed" . mysqli_error($conn);
		    exit;
		}
		$last_id = mysqli_insert_id($conn);
		return $last_id;
	}
	
	// select all info on key/core location relationship - including data on location, bldg, property, key, core BASED on LOCATION ID
	function selectCurrentCore($conn,$loc_id){
		$query = "SELECT kl.key_loc_id, kl.key_loc_startdt, kl.key_loc_enddt, kl.key_loc_qty, kl.key_loc_lost_qty, kl.key_loc_lostdt, kl.key_loc_lost_return,
		l.loc_id, l.loc_unit_num, l.loc_desc, l.loc_type, b.bldg_num, b.bldg_prop, k.key_number, k.key_type, c.core_num, c.core_type FROM key_loc kl INNER JOIN
		location l ON kl.loc_id = l.loc_id LEFT OUTER JOIN building b ON l.bldg_id = b.bldg_id INNER JOIN ktkey k ON kl.key_id = k.key_id LEFT OUTER JOIN core c ON k.core_id = c.core_id
		WHERE kl.key_loc_enddt IS NULL AND kl.loc_id = '$loc_id' ";
		$result = mysqli_query($conn, $query);
		if(!$result){
		    echo "Record not found" . mysqli_error($conn);
		    exit;
		}
		$row = $result->fetch_array(MYSQLI_ASSOC);
		return $row;
	}
	
	// select all info on a key/core location relationship - including data on location, bldg, property, key, core BASED on KEY_LOC ID
	function selectKeyLoc($conn,$key_loc_id){
		$query = "SELECT kl.key_loc_id, kl.key_loc_startdt, kl.key_loc_enddt, kl.key_loc_qty, kl.key_loc_lost_qty, kl.key_loc_lostdt, kl.key_loc_lost_return,
		l.loc_id, l.loc_unit_num, l.loc_desc, l.loc_type, b.bldg_num, b.bldg_prop, k.key_number, k.key_type, c.core_num, c.core_type FROM key_loc kl INNER JOIN
		location l ON kl.loc_id = l.loc_id LEFT OUTER JOIN building b ON l.bldg_id = b.bldg_id INNER JOIN ktkey k ON kl.key_id = k.key_id LEFT OUTER JOIN core c ON k.core_id = c.core_id
		WHERE kl.key_loc_id = '$key_loc_id' ";
		$result = mysqli_query($conn, $query);
		if(!$result){
		    echo "Record not found" . mysqli_error($conn);
		    exit;
		}
		$row = $result->fetch_array(MYSQLI_ASSOC);
		return $row;
	}
	
	// select all checkout information - $is_act allows toggle between active (1) and returned (historical) checkouts (0)
	function selectAllCheckouts($conn,$is_act){
		$checkouts = array();
		if($is_act == 0){
			$query = "SELECT c.checkout_id,c.checkout_startdt,c.checkout_duedt,c.checkout_enddt,k.hold_id,k.hold_name,k.hold_fname,k.hold_lname,k.hold_ident,k.hold_email,k.hold_phone
				FROM checkout c INNER JOIN keyholder k ON c.hold_id = k.hold_id WHERE c.checkout_enddt IS NOT NULL";
		}elseif($is_act == 1){	
			$query = "SELECT c.checkout_id,c.checkout_startdt,c.checkout_duedt,c.checkout_enddt,k.hold_id,k.hold_name,k.hold_fname,k.hold_lname,k.hold_ident,k.hold_email,k.hold_phone
				FROM checkout c INNER JOIN keyholder k ON c.hold_id = k.hold_id WHERE c.checkout_enddt IS NULL";
		}elseif($is_act == 2){	
			$query = "SELECT c.checkout_id,c.checkout_startdt,c.checkout_duedt,c.checkout_enddt,k.hold_id,k.hold_name,k.hold_fname,k.hold_lname,k.hold_ident,k.hold_email,k.hold_phone
				FROM checkout c INNER JOIN keyholder k ON c.hold_id = k.hold_id";
		}
		$result = mysqli_query($conn, $query);
		if(!$result){
		    echo "Record not found" . mysqli_error($conn);
		    exit;
		}
		$rows = $result->num_rows;
		for($j=0; $j<$rows; $j++){
			while($row = $result->fetch_array(MYSQLI_ASSOC)){
				array_push($checkouts, $row);
			}
		}
		return $checkouts;
	}
	
	// function that updates the due date for a key checkout
	function updateCheckoutDue($conn,$checkout_id,$due_dt){
		$query = "UPDATE checkout set checkout_duedt='".$due_dt."' where checkout_id='$checkout_id'";
		$result = mysqli_query($conn, $query);
		if(!$result){
		    echo "Update Failed" . mysqli_error($conn);
		    exit;
		}
	}
	
	// function that updates the return date for a key checkout - returning the keys
	function updateCheckoutReturn($conn,$checkout_id){
		$query = "UPDATE checkout set checkout_enddt=now() where checkout_id='$checkout_id'";
		$result = mysqli_query($conn, $query);
		if(!$result){
		    echo "Update Failed" . mysqli_error($conn);
		    exit;
		}
		$keys = array();
		$query2 = "SELECT kc.key_id FROM key_checkout kc INNER JOIN checkout c ON kc.checkout_id = c.checkout_id WHERE c.checkout_id = '$checkout_id'
			AND kc.key_return_dt IS NULL";
		$result2 = mysqli_query($conn, $query2);
		if(!$result2){
		    echo "Update Failed" . mysqli_error($conn);
		    exit;
		}
		$rows = $result2->num_rows;
		for($j=0; $j<$rows; $j++){
			while($row = $result2->fetch_array(MYSQLI_ASSOC)){
				array_push($keys, $row);
			}
		}
		if($keys){
			foreach($keys as $key){
				$id = $key['key_id'];
				$query3 = "UPDATE key_checkout set key_return_dt = now() WHERE checkout_id = '$checkout_id' AND key_id = '$id'";
				$result3 = mysqli_query($conn, $query3);
				if(!$result3){
					echo "Update Failed" . mysqli_error($conn);
					exit;
				}
			}
		}	
			
	}
	
	// select all checkout information FOR A SPECIFIC PERSON - $is_act allows toggle between active (1) and returned (historical) checkouts (0)
	function selectPersonCheckouts($conn,$is_act,$hold_id){
		$checkouts = array();
		if($is_act == 0){
			$query = "SELECT c.checkout_id,c.checkout_startdt,c.checkout_duedt,c.checkout_enddt,k.hold_id,k.hold_name,k.hold_fname,k.hold_lname,k.hold_ident,k.hold_email,k.hold_phone
				FROM checkout c INNER JOIN keyholder k ON c.hold_id = k.hold_id WHERE c.hold_id='$hold_id' AND c.checkout_enddt IS NOT NULL";
		}elseif($is_act == 1){	
			$query = "SELECT c.checkout_id,c.checkout_startdt,c.checkout_duedt,c.checkout_enddt,k.hold_id,k.hold_name,k.hold_fname,k.hold_lname,k.hold_ident,k.hold_email,k.hold_phone
				FROM checkout c INNER JOIN keyholder k ON c.hold_id = k.hold_id WHERE c.hold_id='$hold_id' AND c.checkout_enddt IS NULL";
		}
		$result = mysqli_query($conn, $query);
		if(!$result){
		    echo "Record not found" . mysqli_error($conn);
		    exit;
		}
		$rows = $result->num_rows;
		for($j=0; $j<$rows; $j++){
			while($row = $result->fetch_array(MYSQLI_ASSOC)){
				array_push($checkouts, $row);
			}
		}
		return $checkouts;
	}
	
	// select all checkout information for overdue checkouts, based on the system date
	function selectAllOverdueCheckouts($conn){
		$checkouts = array();
		$query = "SELECT c.checkout_id,c.checkout_startdt,c.checkout_duedt,c.checkout_enddt,k.hold_id,k.hold_name,k.hold_fname,k.hold_lname,k.hold_ident,k.hold_email,k.hold_phone
			FROM checkout c INNER JOIN keyholder k ON c.hold_id = k.hold_id WHERE (c.checkout_duedt <= CURRENT_DATE - INTERVAL 1 DAY) AND c.checkout_enddt IS NULL";
		$result = mysqli_query($conn, $query);
		if(!$result){
		    echo "Record not found" . mysqli_error($conn);
		    exit;
		}
		$rows = $result->num_rows;
		for($j=0; $j<$rows; $j++){
			while($row = $result->fetch_array(MYSQLI_ASSOC)){
				array_push($checkouts, $row);
			}
		}
		return $checkouts;
	}
	
	// select all checkout information for checkouts due within X days, based on the system date
	function selectAllCheckoutsByDueDate($conn,$due_dt){
		$checkouts = array();
		$query = "SELECT c.checkout_id,c.checkout_startdt,c.checkout_duedt,c.checkout_enddt,k.hold_id,k.hold_name,k.hold_fname,k.hold_lname,k.hold_ident,k.hold_email,k.hold_phone
			FROM checkout c INNER JOIN keyholder k ON c.hold_id = k.hold_id WHERE (c.checkout_duedt <= CURRENT_DATE + INTERVAL '$due_dt' DAY) 
			AND (c.checkout_duedt >= CURRENT_DATE) AND c.checkout_enddt IS NULL";
		$result = mysqli_query($conn, $query);
		if(!$result){
		    echo "Record not found" . mysqli_error($conn);
		    exit;
		}
		$rows = $result->num_rows;
		for($j=0; $j<$rows; $j++){
			while($row = $result->fetch_array(MYSQLI_ASSOC)){
				array_push($checkouts, $row);
			}
		}
		return $checkouts;
	}
	
	// select all key_location assignments information - $is_act allows toggle between active (1) and returned (historical) key assignments (0)
	function selectAllKeyLoc($conn,$is_act){
		$assignments = array();
		if($is_act == 0){
			$query = "SELECT kl.key_loc_id,kl.key_loc_startdt,kl.key_loc_enddt,kl.key_id,kl.loc_id,l.loc_unit_num,l.loc_type,k.key_id,k.key_number,b.bldg_num,b.bldg_prop,c.core_num,c.core_id
				FROM key_loc kl INNER JOIN location l ON kl.loc_id = l.loc_id INNER JOIN ktkey k ON kl.key_id = k.key_id LEFT OUTER JOIN core c ON k.core_id = c.core_id
				LEFT OUTER JOIN building b ON l.bldg_id = b.bldg_id
				WHERE kl.key_loc_enddt IS NOT NULL";
		}elseif($is_act == 1){	
			$query = "SELECT kl.key_loc_id,kl.key_loc_startdt,kl.key_loc_enddt,kl.key_id,kl.loc_id,l.loc_unit_num,l.loc_type,k.key_id,k.key_number,b.bldg_num,b.bldg_prop,c.core_num,c.core_id
				FROM key_loc kl INNER JOIN location l ON kl.loc_id = l.loc_id INNER JOIN ktkey k ON kl.key_id = k.key_id LEFT OUTER JOIN core c ON k.core_id = c.core_id
				LEFT OUTER JOIN building b ON l.bldg_id = b.bldg_id
				WHERE kl.key_loc_enddt IS NULL";
		}elseif($is_act == 2){	
			$query = "SELECT kl.key_loc_id,kl.key_loc_startdt,kl.key_loc_enddt,kl.key_id,kl.loc_id,l.loc_unit_num,l.loc_type,k.key_id,k.key_number,b.bldg_num,b.bldg_prop,c.core_num,c.core_id
				FROM key_loc kl INNER JOIN location l ON kl.loc_id = l.loc_id INNER JOIN ktkey k ON kl.key_id = k.key_id LEFT OUTER JOIN core c ON k.core_id = c.core_id
				LEFT OUTER JOIN building b ON l.bldg_id = b.bldg_id";
		}
		$result = mysqli_query($conn, $query);
		if(!$result){
		    echo "Record not found" . mysqli_error($conn);
		    exit;
		}
		$rows = $result->num_rows;
		for($j=0; $j<$rows; $j++){
			while($row = $result->fetch_array(MYSQLI_ASSOC)){
				array_push($assignments, $row);
			}
		}
		return $assignments;
	}
	
	// select all key_location assignments information FOR a specific location - $is_act allows toggle between active (1) and returned (historical) key assignments (0)
	function selectLocAssignments($conn,$is_act,$loc_id){
		$assignments = array();
		if($is_act == 0){
			$query = "SELECT kl.key_loc_id,kl.key_loc_startdt,kl.key_loc_enddt,kl.key_id,kl.loc_id,l.loc_unit_num,l.loc_type,k.key_id,k.key_number,b.bldg_num,b.bldg_prop,c.core_num,c.core_id
				FROM key_loc kl INNER JOIN location l ON kl.loc_id = l.loc_id INNER JOIN ktkey k ON kl.key_id = k.key_id LEFT OUTER JOIN core c ON k.core_id = c.core_id
				LEFT OUTER JOIN building b ON l.bldg_id = b. bldg_id
				WHERE kl.key_loc_enddt IS NOT NULL AND kl.loc_id = '$loc_id' ORDER BY kl.key_loc_id DESC";
		}elseif($is_act == 1){	
			$query = "SELECT kl.key_loc_id,kl.key_loc_startdt,kl.key_loc_enddt,kl.key_id,kl.loc_id,l.loc_unit_num,l.loc_type,k.key_id,k.key_number,b.bldg_num,b.bldg_prop,c.core_num,c.core_id
				FROM key_loc kl INNER JOIN location l ON kl.loc_id = l.loc_id INNER JOIN ktkey k ON kl.key_id = k.key_id LEFT OUTER JOIN core c ON k.core_id = c.core_id
				LEFT OUTER JOIN building b ON l.bldg_id = b. bldg_id
				WHERE kl.key_loc_enddt IS NULL AND kl.loc_id = '$loc_id' ORDER BY kl.key_loc_id DESC";
		}elseif($is_act == 2){
			$query = "SELECT kl.key_loc_id,kl.key_loc_startdt,kl.key_loc_enddt,kl.key_id,kl.loc_id,l.loc_unit_num,l.loc_type,k.key_id,k.key_number,b.bldg_num,b.bldg_prop,c.core_num,c.core_id
				FROM key_loc kl INNER JOIN location l ON kl.loc_id = l.loc_id INNER JOIN ktkey k ON kl.key_id = k.key_id LEFT OUTER JOIN core c ON k.core_id = c.core_id
				LEFT OUTER JOIN building b ON l.bldg_id = b. bldg_id
				WHERE kl.loc_id = '$loc_id' ORDER BY kl.key_loc_id DESC";
		}
		$result = mysqli_query($conn, $query);
		if(!$result){
		    echo "Record not found" . mysqli_error($conn);
		    exit;
		}
		$rows = $result->num_rows;
		for($j=0; $j<$rows; $j++){
			while($row = $result->fetch_array(MYSQLI_ASSOC)){
				array_push($assignments, $row);
			}
		}
		return $assignments;
	}
	
	// select all keyholders or locations CURRENTLY associated to the given key number
	function findKey($conn,$key_num){
		$keys = array();
		$query = "SELECT k.key_id,k.key_number,c.checkout_id as res_id,c.checkout_startdt as res_start,kh.hold_id as res_entid,kh.hold_fname as res_name, 'chk' as res_type 
		FROM ktkey k INNER JOIN key_checkout kc ON k.key_id = kc.key_id INNER JOIN checkout c ON kc.checkout_id = c.checkout_id 
		INNER JOIN keyholder kh ON c.hold_id = kh.hold_id WHERE k.key_number LIKE '%$key_num%' AND c.checkout_enddt IS NULL AND kc.key_return_dt IS NULL
		UNION
		SELECT k.key_id,k.key_number,kl.key_loc_id as res_id,kl.key_loc_startdt as res_start,l.loc_id as res_entid,l.loc_unit_num as res_name, 'unit' as res_type 
		FROM ktkey k INNER JOIN key_loc kl ON k.key_id = kl.key_id INNER JOIN location l ON kl.loc_id = l.loc_id WHERE k.key_number LIKE '%$key_num%' AND kl.key_loc_enddt IS NULL";
		$result = mysqli_query($conn, $query);
		if(!$result){
		    echo "Record not found" . mysqli_error($conn);
		    exit;
		}
		$rows = $result->num_rows;
		for($j=0; $j<$rows; $j++){
			while($row = $result->fetch_array(MYSQLI_ASSOC)){
				array_push($keys, $row);
			}
		}
		return $keys;
	}
	
	// select all keys from an active checkout that have been marked lost and not returned yet for a specific keyholder
	function holderLostKeys($conn,$hold_id){
		$lostkeys = array();	
		$query = "SELECT k.key_id,k.key_number,kc.key_check_id,kc.key_check_lostdt,kc.key_check_lost_return,kc.key_return_dt,c.checkout_id,c.checkout_startdt,c.checkout_duedt,c.checkout_enddt,kh.hold_id
			FROM ktkey k INNER JOIN key_checkout kc ON k.key_id = kc.key_id INNER JOIN checkout c ON kc.checkout_id = c.checkout_id INNER JOIN keyholder kh ON c.hold_id = kh.hold_id 
			WHERE c.hold_id='$hold_id' AND kc.key_check_lostdt IS NOT NULL";
		
		$result = mysqli_query($conn, $query);
		if(!$result){
		    echo "Record not found" . mysqli_error($conn);
		    exit;
		}
		$rows = $result->num_rows;
		for($j=0; $j<$rows; $j++){
			while($row = $result->fetch_array(MYSQLI_ASSOC)){
				array_push($lostkeys, $row);
			}
		}
		return $lostkeys;
	}
	
	// select all keys from an active checkout are not lost or returned for a specific keyholder
	function holderActiveKeys($conn,$hold_id){
		$holdkeys = array();	
		$query = "SELECT k.key_id,k.key_number,kc.key_check_id,kc.key_check_lostdt,kc.key_check_lost_return,c.checkout_id,c.checkout_startdt,c.checkout_duedt,c.checkout_enddt,kh.hold_id
			FROM ktkey k INNER JOIN key_checkout kc ON k.key_id = kc.key_id INNER JOIN checkout c ON kc.checkout_id = c.checkout_id INNER JOIN keyholder kh ON c.hold_id = kh.hold_id 
			WHERE c.hold_id='$hold_id' AND c.checkout_enddt IS NULL AND (kc.key_check_lostdt IS NULL OR (kc.key_check_lostdt IS NOT NULL AND kc.key_check_lost_return IS NOT NULL)) AND 
			kc.key_return_dt IS NULL";
		
		$result = mysqli_query($conn, $query);
		if(!$result){
		    echo "Record not found" . mysqli_error($conn);
		    exit;
		}
		$rows = $result->num_rows;
		for($j=0; $j<$rows; $j++){
			while($row = $result->fetch_array(MYSQLI_ASSOC)){
				array_push($holdkeys, $row);
			}
		}
		return $holdkeys;
	}
	
	// select all keys from all active checkouts that have been marked lost and not returned yet
	function selectLostKeys($conn){
		$lostkeys = array();	
		$query = "SELECT k.key_id,k.key_number,kc.key_check_id,kc.key_check_lostdt,kc.key_check_lost_return,c.checkout_id,c.checkout_startdt,c.checkout_duedt,c.checkout_enddt,kh.hold_id,kh.hold_fname,kh.hold_lname
			FROM ktkey k INNER JOIN key_checkout kc ON k.key_id = kc.key_id INNER JOIN checkout c ON kc.checkout_id = c.checkout_id INNER JOIN keyholder kh ON c.hold_id = kh.hold_id 
			WHERE c.checkout_enddt IS NULL AND kc.key_return_dt IS NULL AND kc.key_check_lostdt IS NOT NULL AND kc.key_check_lost_return IS NULL ";
		
		$result = mysqli_query($conn, $query);
		if(!$result){
		    echo "Record not found" . mysqli_error($conn);
		    exit;
		}
		$rows = $result->num_rows;
		for($j=0; $j<$rows; $j++){
			while($row = $result->fetch_array(MYSQLI_ASSOC)){
				array_push($lostkeys, $row);
			}
		}
		return $lostkeys;
	}
	
	// select all info on all current key/core location relationships - including data on location, bldg, property, key, core
	function selectAllCurrentCores($conn){
		$currentcores = array();
		$query = "SELECT kl.key_loc_id, kl.key_loc_startdt, kl.key_loc_enddt, kl.key_loc_qty, kl.key_loc_lost_qty, kl.key_loc_lostdt, kl.key_loc_lost_return,
		l.loc_id, l.loc_unit_num, l.loc_desc, l.loc_type, b.bldg_num, b.bldg_prop, k.key_number, k.key_type, c.core_num, c.core_type FROM key_loc kl INNER JOIN
		location l ON kl.loc_id = l.loc_id INNER JOIN building b ON l.bldg_id = b.bldg_id INNER JOIN ktkey k ON kl.key_id = k.key_id INNER JOIN core c ON k.core_id = c.core_id
		WHERE kl.key_loc_enddt IS NULL ";
		$result = mysqli_query($conn, $query);
		if(!$result){
		    echo "Record not found" . mysqli_error($conn);
		    exit;
		}
		$rows = $result->num_rows;
		for($j=0; $j<$rows; $j++){
			while($row = $result->fetch_array(MYSQLI_ASSOC)){
				array_push($currentcores, $row);
			}
		}
		return $currentcores;
	}
	
	// select all key_core location assignments information FOR a specific core - $is_act allows toggle between active (1) and returned (historical) key assignments (0)
	function selectCoreAssignments($conn,$is_act,$core_id){
		$assignments = array();
		if($is_act == 0){
			$query = "SELECT kl.key_loc_id,kl.key_loc_startdt,kl.key_loc_enddt,kl.key_id,kl.loc_id,l.loc_unit_num,l.loc_desc,l.loc_type,b.bldg_num,b.bldg_prop,c.core_num,c.core_id
				FROM key_loc kl INNER JOIN location l ON kl.loc_id = l.loc_id INNER JOIN ktkey k ON kl.key_id = k.key_id INNER JOIN core c ON k.core_id = c.core_id
				INNER JOIN building b ON l.bldg_id = b. bldg_id
				WHERE kl.key_loc_enddt IS NOT NULL AND c.core_id = '$core_id' ORDER BY kl.key_loc_id DESC";
		}elseif($is_act == 1){	
			$query = "SELECT kl.key_loc_id,kl.key_loc_startdt,kl.key_loc_enddt,kl.key_id,kl.loc_id,l.loc_unit_num,l.loc_desc,l.loc_type,b.bldg_num,b.bldg_prop,c.core_num,c.core_id
				FROM key_loc kl INNER JOIN location l ON kl.loc_id = l.loc_id INNER JOIN ktkey k ON kl.key_id = k.key_id INNER JOIN core c ON k.core_id = c.core_id
				INNER JOIN building b ON l.bldg_id = b. bldg_id
				WHERE kl.key_loc_enddt IS NULL AND c.core_id = '$core_id' ORDER BY kl.key_loc_id DESC";
		}elseif($is_act == 2){
			$query = "SELECT kl.key_loc_id,kl.key_loc_startdt,kl.key_loc_enddt,kl.key_id,kl.loc_id,l.loc_unit_num,l.loc_desc,l.loc_type,b.bldg_num,b.bldg_prop,c.core_num,c.core_id
				FROM key_loc kl INNER JOIN location l ON kl.loc_id = l.loc_id INNER JOIN ktkey k ON kl.key_id = k.key_id INNER JOIN core c ON k.core_id = c.core_id
				INNER JOIN building b ON l.bldg_id = b. bldg_id
				WHERE c.core_id = '$core_id' ORDER BY kl.key_loc_id DESC";
		}
		$result = mysqli_query($conn, $query);
		if(!$result){
		    echo "Record not found" . mysqli_error($conn);
		    exit;
		}
		$rows = $result->num_rows;
		for($j=0; $j<$rows; $j++){
			while($row = $result->fetch_array(MYSQLI_ASSOC)){
				array_push($assignments, $row);
			}
		}
		return $assignments;
	}
	
	// select all locations a key is actively assigned to - $is_act allows toggle between active (1) and returned (historical) location assignments(0) or all (2)
	function selectKeyAssignments($conn,$is_act,$key_id){
		$assignments = array();
		if($is_act == 0){
			$query = "SELECT kl.key_loc_id,kl.key_loc_startdt,kl.key_loc_enddt,kl.key_id,kl.loc_id,l.loc_unit_num,l.loc_type,b.bldg_num,b.bldg_prop,c.core_num,c.core_id
				FROM key_loc kl INNER JOIN location l ON kl.loc_id = l.loc_id INNER JOIN ktkey k ON kl.key_id = k.key_id LEFT OUTER JOIN core c ON k.core_id = c.core_id
				LEFT OUTER JOIN building b ON l.bldg_id = b. bldg_id
				WHERE kl.key_loc_enddt IS NOT NULL AND kl.key_id = '$key_id' ORDER BY kl.key_loc_id DESC";
		}elseif($is_act == 1){	
			$query = "SELECT kl.key_loc_id,kl.key_loc_startdt,kl.key_loc_enddt,kl.key_id,kl.loc_id,l.loc_unit_num,l.loc_type,b.bldg_num,b.bldg_prop,c.core_num,c.core_id
				FROM key_loc kl INNER JOIN location l ON kl.loc_id = l.loc_id INNER JOIN ktkey k ON kl.key_id = k.key_id LEFT OUTER JOIN core c ON k.core_id = c.core_id
				LEFT OUTER JOIN building b ON l.bldg_id = b. bldg_id
				WHERE kl.key_loc_enddt IS NULL AND kl.key_id = '$key_id' ORDER BY kl.key_loc_id DESC";
		}elseif($is_act == 2){
			$query = "SELECT kl.key_loc_id,kl.key_loc_startdt,kl.key_loc_enddt,kl.key_id,kl.loc_id,l.loc_unit_num,l.loc_type,b.bldg_num,b.bldg_prop,c.core_num,c.core_id
				FROM key_loc kl INNER JOIN location l ON kl.loc_id = l.loc_id INNER JOIN ktkey k ON kl.key_id = k.key_id LEFT OUTER JOIN core c ON k.core_id = c.core_id
				LEFT OUTER JOIN building b ON l.bldg_id = b. bldg_id
				WHERE kl.key_id = '$key_id' ORDER BY kl.key_loc_id DESC";
		}
		$result = mysqli_query($conn, $query);
		if(!$result){
		    echo "Record not found" . mysqli_error($conn);
		    exit;
		}
		$rows = $result->num_rows;
		for($j=0; $j<$rows; $j++){
			while($row = $result->fetch_array(MYSQLI_ASSOC)){
				array_push($assignments, $row);
			}
		}
		return $assignments;
	}
	
	// select all keyholders from an active checkout related to the given key_id
	function keyActiveHolders($conn,$key_id){
		$keyholds = array();	
		$query = "SELECT k.key_id,k.key_number,kc.key_check_id,kc.key_check_lostdt,kc.key_check_lost_return,c.checkout_id,c.checkout_startdt,c.checkout_duedt,c.checkout_enddt,kh.hold_id,
			kh.hold_fname,kh.hold_lname,kh.hold_type,kh.hold_name
			FROM ktkey k INNER JOIN key_checkout kc ON k.key_id = kc.key_id INNER JOIN checkout c ON kc.checkout_id = c.checkout_id INNER JOIN keyholder kh ON c.hold_id = kh.hold_id 
			WHERE k.key_id='$key_id' AND c.checkout_enddt IS NULL AND (kc.key_check_lostdt IS NULL OR (kc.key_check_lostdt IS NOT NULL AND kc.key_check_lost_return IS NOT NULL)) AND
			kc.key_return_dt IS NULL";
		
		$result = mysqli_query($conn, $query);
		if(!$result){
		    echo "Record not found" . mysqli_error($conn);
		    exit;
		}
		$rows = $result->num_rows;
		for($j=0; $j<$rows; $j++){
			while($row = $result->fetch_array(MYSQLI_ASSOC)){
				array_push($keyholds, $row);
			}
		}
		return $keyholds;
	}
	
	// ADMIN function that updates the START date for a key checkout
	function updateCheckoutStartDate($conn,$checkout_id,$start_dt){
		if(!$start_dt || $start_dt == ''){
			$query = "UPDATE checkout set checkout_startdt= NULL where checkout_id='$checkout_id'";
		}else{
			$query = "UPDATE checkout set checkout_startdt= '".$start_dt."' where checkout_id='$checkout_id'";
		}
		$result = mysqli_query($conn, $query);
		if(!$result){
		    echo "Update Failed" . mysqli_error($conn);
		    exit;
		}
	}
	
	// ADMIN function that updates the DUE date for a key checkout
	function updateCheckoutDueDate($conn,$checkout_id,$due_dt){
		if(!$due_dt || $due_dt == ''){
			$query = "UPDATE checkout set checkout_duedt= NULL where checkout_id='$checkout_id'";
		}else{
			$query = "UPDATE checkout set checkout_duedt= '".$due_dt."' where checkout_id='$checkout_id'";
		}
		$result = mysqli_query($conn, $query);
		if(!$result){
		    echo "Update Failed" . mysqli_error($conn);
		    exit;
		}
	}
	
	// ADMIN function that updates the RETURN date for a key checkout
	function updateCheckoutReturnDate($conn,$checkout_id,$return_dt){
		if(!$return_dt || $return_dt == ''){
			$query = "UPDATE checkout set checkout_enddt= NULL where checkout_id='$checkout_id'";
			$result = mysqli_query($conn, $query);
			if(!$result){
				echo "Update Failed" . mysqli_error($conn);
				exit;
			}
		}else{
			$query = "UPDATE checkout set checkout_enddt= '".$return_dt."' where checkout_id='$checkout_id'";
			$result = mysqli_query($conn, $query);
			if(!$result){
				echo "Update Failed" . mysqli_error($conn);
				exit;
			}
			$keys = array();
			$query2 = "SELECT kc.key_id FROM key_checkout kc INNER JOIN checkout c ON kc.checkout_id = c.checkout_id WHERE c.checkout_id = '$checkout_id'
				AND kc.key_return_dt IS NULL";
			$result2 = mysqli_query($conn, $query2);
			if(!$result2){
				echo "Update Failed" . mysqli_error($conn);
				exit;
			}
			$rows = $result2->num_rows;
			for($j=0; $j<$rows; $j++){
				while($row = $result2->fetch_array(MYSQLI_ASSOC)){
					array_push($keys, $row);
				}
			}
			if($keys){
				foreach($keys as $key){
					$id = $key['key_id'];
					$query3 = "UPDATE key_checkout set key_return_dt = '".$return_dt."' WHERE checkout_id = '$checkout_id' AND key_id = '$id'";
					$result3 = mysqli_query($conn, $query3);
					if(!$result3){
						echo "Update Failed" . mysqli_error($conn);
						exit;
					}
				}
			}	
		}
		
	}
	
	// ADMIN function that updates the START date for a key location relationship
	function updateKeyLocStartDate($conn,$key_loc_id,$start_dt){
		if(!$start_dt || $start_dt == ''){
			$query = "UPDATE key_loc set key_loc_startdt= NULL where key_loc_id='$key_loc_id'";
		}else{
			$query = "UPDATE key_loc set key_loc_startdt= '".$start_dt."' where key_loc_id='$key_loc_id'";
		}
		$result = mysqli_query($conn, $query);
		if(!$result){
		    echo "Update Failed" . mysqli_error($conn);
		    exit;
		}
	}
	
	// ADMIN function that updates the RETURN date for a key location relationship
	function updateKeyLocEndDate($conn,$key_loc_id,$end_dt){
		if(!$end_dt || $end_dt == ''){
			$query = "UPDATE key_loc set key_loc_enddt= NULL where key_loc_id='$key_loc_id'";
		}else{
			$query = "UPDATE key_loc set key_loc_enddt= '".$end_dt."' where key_loc_id='$key_loc_id'";
		}
		$result = mysqli_query($conn, $query);
		if(!$result){
		    echo "Update Failed" . mysqli_error($conn);
		    exit;
		}
	}
	
	// update location mail key/core data
	function mailUpdate($conn,$loc_id,$loc_mailbox,$loc_mail_core){
		$query2 = "UPDATE location set loc_mailbox='$loc_mailbox',loc_mail_core='$loc_mail_core' 
					where loc_id='$loc_id'";
		$result2 = mysqli_query($conn, $query2);
		if(!$result2){
			echo "Update Failed" . mysqli_error($conn);
			exit;
		}
	}
	
	// select all mail locations from location table with building number and property from building table where location is apartment and return in array
	function selectAllMailLocations($conn){
		$locations = array();
		$query = "SELECT l.loc_id, l.loc_unit_num,l.loc_desc,l.loc_insertdt,l.loc_notes,l.loc_is_act,l.loc_type,l.bldg_id,l.loc_mailbox,l.loc_mail_core, b.bldg_num, b.bldg_prop 
			FROM location l LEFT OUTER JOIN building b ON l.bldg_id = b.bldg_id WHERE l.loc_type = 'Apartment' ";
		$result = mysqli_query($conn, $query);
		if(!$result){
		    echo "Records not found" . mysqli_error($conn);
		    exit;
		}
		$rows = $result->num_rows;
		for($j=0; $j<$rows; $j++){
			while($row = $result->fetch_array(MYSQLI_ASSOC)){
				array_push($locations, $row);
			}
		}
		return $locations;
	}
	
	// updates the return date for a single key return from a checkout
	function singleKeyCheckoutReturn($conn,$key_check_id){
		$query = "UPDATE key_checkout set key_return_dt = now() WHERE key_check_id = '$key_check_id'";
		$result = mysqli_query($conn, $query);
		if(!$result){
		    echo "Update of date failed" . mysqli_error($conn);
		    exit;
		}
	}
	
	// select all keys issued FOR A SPECIFIC PERSON - $is_act allows toggle between active (1) and returned (historical) keys (0)
	function selectPersonKeys($conn,$is_act,$hold_id){
		$keys = array();
		if($is_act == 0){
			$query = "SELECT c.checkout_id,c.checkout_startdt,c.checkout_duedt,c.checkout_enddt,k.hold_id,kt.key_id,kt.key_number,kc.key_return_dt
				FROM checkout c INNER JOIN keyholder k ON c.hold_id = k.hold_id INNER JOIN key_checkout kc ON c.checkout_id = kc.checkout_id INNER JOIN
				ktkey kt ON kc.key_id = kt.key_id WHERE c.hold_id='$hold_id' AND kc.key_return_dt IS NOT NULL";
		}elseif($is_act == 1){	
			$query = "SELECT c.checkout_id,c.checkout_startdt,c.checkout_duedt,c.checkout_enddt,k.hold_id,kt.key_id,kt.key_number,kc.key_return_dt
				FROM checkout c INNER JOIN keyholder k ON c.hold_id = k.hold_id INNER JOIN key_checkout kc ON c.checkout_id = kc.checkout_id INNER JOIN
				ktkey kt ON kc.key_id = kt.key_id WHERE c.hold_id='$hold_id' AND kc.key_return_dt IS NULL";
		}
		$result = mysqli_query($conn, $query);
		if(!$result){
		    echo "Record not found" . mysqli_error($conn);
		    exit;
		}
		$rows = $result->num_rows;
		for($j=0; $j<$rows; $j++){
			while($row = $result->fetch_array(MYSQLI_ASSOC)){
				array_push($keys, $row);
			}
		}
		return $keys;
	}
	
	// select all keyholders that have ever had a checkout - is_act will determine if the record should come back based on whether the person has ANY active or returned keys
	function selectAllKeyholderWithCheckout($conn,$is_act){
		$keyholders = array();
		if($is_act == 0){
			$query = "SELECT DISTINCT k.hold_id,k.hold_name,k.hold_fname,k.hold_lname,k.hold_ident,k.hold_email,k.hold_phone,k.hold_type FROM keyholder k 
				INNER JOIN checkout c ON k.hold_id = c.hold_id WHERE k.hold_id IN (SELECT c.hold_id FROM checkout c INNER JOIN key_checkout k ON 
				c.checkout_id = k.checkout_id WHERE k.key_return_dt IS NOT NULL)";
		}elseif($is_act == 1){
			$query = "SELECT DISTINCT k.hold_id,k.hold_name,k.hold_fname,k.hold_lname,k.hold_ident,k.hold_email,k.hold_phone,k.hold_type FROM keyholder k 
				INNER JOIN checkout c ON k.hold_id = c.hold_id WHERE k.hold_id IN (SELECT c.hold_id FROM checkout c INNER JOIN key_checkout k ON 
				c.checkout_id = k.checkout_id WHERE k.key_return_dt IS NULL)";
		}
		$result = mysqli_query($conn, $query);
		if(!$result){
		    echo "Record not found" . mysqli_error($conn);
		    exit;
		}
		$rows = $result->num_rows;
		for($j=0; $j<$rows; $j++){
			while($row = $result->fetch_array(MYSQLI_ASSOC)){
				array_push($keyholders, $row);
			}
		}
		return $keyholders;
	}
	
?>


