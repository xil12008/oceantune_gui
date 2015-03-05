<?php 
session_start();	
?>

<?php
//------1. create a connection
$connection = mysql_connect("localhost", "uwsn_web","ChunXia");
if(!$connection) {
      die("database connection fail! ".mysql_error());
}

//-------2 select a database
$db_select = mysql_select_db("uwsn_web", $connection);
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
			$result = mysql_query("SELECT * FROM testbed_node", $connection);
			while ( $row = mysql_fetch_array($result)) {
					echo $row["node_name"]." is at (".$row["latitude"].",".$row["longitude"].") <br />";
			}
?>

<?php
			//display nodes
			
			$result2 = mysql_query("SELECT * FROM sense_data ORDER BY Date DESC", $connection);
			while ( $row = mysql_fetch_array($result2)) {
					echo $row["NodeName"]." (".$row["Celsius"].",".$row["Conductivity"].",".$row["Pressure"].",".$row["Salinity"].",".$row["Date"].",".$row["Time"].") <br />";
			}
?>

</body>
</html>

<?php
	//-----------5 close connection
	mysql_close($connection);
?>