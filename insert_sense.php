<?php 
session_start();	
?>

<?php
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
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>

<?php
			//display nodes
			/*
			$result = mysql_query("SELECT * FROM testbed_node", $connection);
			while ( $row = mysql_fetch_array($result)) {
					echo $row["node_name"]." is at (".$row["latitude"].",".$row["longitude"].") <br />";
			}*/
?>

<?php
			//echo "Insert Page!";
			// insert new sense data
			if( $_REQUEST['nodename']!=NULL){
			//	if($_SESSION['userflag']==0){
				
				$raw_date = $_REQUEST['D'];
				if($raw_date[2]=='O'&&$raw_date[3]=='c'&&$raw_date[4]=='t'){
					$format_date = $raw_date[5].$raw_date[6].$raw_date[7].$raw_date[8].'-'.'10'.'-'.$raw_date[0].$raw_date[1];	
				}
				else if($raw_date[2]=='N'&&$raw_date[3]=='o'&&$raw_date[4]=='v'){
					$format_date = $raw_date[5].$raw_date[6].$raw_date[7].$raw_date[8].'-'.'11'.'-'.$raw_date[0].$raw_date[1];	
				}
				
				//$date=
				
				//echo $_REQUEST['nodename']."', '".$_REQUEST['Cel']."','".$_REQUEST['Cond']."',".$_REQUEST['P'].",".$_REQUEST['S'].",".$_REQUEST['D'].",".$_REQUEST['T'].")".$format_date;
				
				/*
					mysql_query("INSERT INTO sense_data (NodeName, Celsius, Conductivity, Pressure, Salinity, Date, Time)
					VALUES ('".$_REQUEST['nodename']."', '".$_REQUEST['Cel']."','".$_REQUEST['Cond']."',".$_REQUEST['P'].",".$_REQUEST['S'].",'".$_REQUEST['D']."','".$_REQUEST['T']."')");
					*/
					
					$query = "INSERT INTO sense_data (NodeName, Celsius, Conductivity, Pressure, Salinity, Date, Time, SourceID)
					VALUES ('".$_REQUEST['nodename']."', '".$_REQUEST['Cel']."','".$_REQUEST['Cond']."',".$_REQUEST['P'].",".$_REQUEST['S'].",'".$format_date."','".$_REQUEST['T']."','".$_REQUEST['Source']."')";
					//echo $query;
					//echo $_REQUEST['T']." ".$format_date."<br>";
					mysql_query($query);
					
				//	echo "You have added a new node.<br />";
				//}
				//else{
				//	echo "Permission Denied! Please contact administraters! <br />";
				//}
			}
?>

<?php
//Manually inserting

//echo "NodeName, Celsius, Conductivity, Pressure, Salinity, Date, Time<br>";
// insert from local txt file


/*if($_REQUEST['name']=="node_4"){
	$handle = @fopen("../sensefiles/N4.txt", "r");
}
else if($_REQUEST['name']=="node_2")
{
	$handle = @fopen("../sensefiles/N2.txt", "r");
}

if ($handle) {
    while (($buffer = fgets($handle, 4096)) !== false) {
        
		if($buffer[0]=='#')
		{			
			list($Cel, $Cond, $P, $S, $D, $T, $Source) = explode(",", $buffer);
			$Cel = substr($Cel, 3);
			$Cond = trim($Cond, " ");
			$P = trim($P, " ");
			$S = trim($S, " ");
			$D = trim($D, " ");
			$T = trim($T, " ");
			$T = substr($T, 0, -1);
			$Source = trim($Source, " ");
			
			//echo $Source;
			
			$raw_date = $D;
			if($raw_date[3]=='O'&&$raw_date[4]=='c'&&$raw_date[5]=='t'){
				$format_date = $raw_date[7].$raw_date[8].$raw_date[9].$raw_date[10].'-'.'10'.'-'.$raw_date[0].$raw_date[1];	
			}
			else if($raw_date[3]=='N'&&$raw_date[4]=='o'&&$raw_date[5]=='v'){
				$format_date = $raw_date[7].$raw_date[8].$raw_date[9].$raw_date[10].'-'.'11'.'-'.$raw_date[0].$raw_date[1];	
			}
			
			$query = "INSERT INTO sense_data (NodeName, Celsius, Conductivity, Pressure, Salinity, Date, Time, SourceID)
					VALUES ('".$_REQUEST['name']."', '".$Cel."','".$Cond."',".$P.",".$S.",'".$format_date."','".$T."','".$Source."')";
					//echo $query;
					mysql_query($query);
					//echo $Cel.", ".$Cond.", ".$P.", ".$S.", ".$format_date.", ".$T."<br>";
		}
    }
    if (!feof($handle)) {
        echo "Error: unexpected fgets() fail\n";
    }
    fclose($handle);
}*/
?>

</body>
</html>

<?php
	//-----------5 close connection
	mysql_close($connection);
?>