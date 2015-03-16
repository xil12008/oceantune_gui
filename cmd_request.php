<?php
	session_start();	

	//very basic checking. we should only allow valid user inserting at valid time slots.
    //if ($_SESSION['userflag']!=0 && $_SESSION['userflag']!=2) {
	//	die("Permission denied. Please ask administrator for avaialble time slots.");
	//}
	if( is_null($_SESSION['username']) ) {
		die("Login Required!");	
	}
	
	echo "User Flag="+$_SESSION['userflag'];
	echo " q="+$_GET['q'];
	echo " n="+$_GET['n'];
	
	$n = $_GET['n'];
	$q = $_GET['q'];
	//------1. create a connection
	$connection = mysql_connect("localhost", "oceantune_wui","ChunXia&2012");
	if(!$connection) {
		  die("database connection fail! ".mysql_error());
	}
	
	//-------2 select a database
	$db_select = mysql_select_db("oceantune_wui", $connection);
	if(!$db_select) {
		  die("database selection fail! ".mysql_error());
	}
    
	// insert new command
	if( !is_null($q) ){ 
			if($q=="clear"){
				`echo welcome > /home/xiaoyan/result2.txt`;
			}
			else if($q=="exit"){
				die("It's not cool.");
			}
			
			if(true) {
				// this a valid user and this is his time slot. @TODO
				
				$insert_cmd_result = mysql_query("INSERT INTO command_list (command, create_time, username, node_id)
				VALUES ('".$q."', '".date('Y-m-d H:i:s', strtotime("now"))."','".$_SESSION['username']."',".$n.")");
				
				
				echo "INSERT INTO command_list (command, create_time, username, node_id)
				VALUES ('".$q."', '".date('Y-m-d H:i:s', strtotime("now"))."','".$_SESSION['username']."'".$n.")";
				
				if(!$insert_cmd_result) {
					die("Insert cmd failed! ".mysql_error());
				} else {
				    echo "Succeed";	
				}
			} else {
				//echo "Permission Denied! Please contact administraters! <br />";
				echo "Please contact administraters! <br />";
			}
	}
	
	//-----------5 close connection
	mysql_close($connection);
?>