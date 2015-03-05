<?php 
session_start();	
?>

<?php
if( is_null($_SESSION['username']) ) {
	die("Login Required!");	
}

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
<title>Schedule</title>
</head>

<body>
			<?php
			//display schedules
			$result = mysql_query("SELECT * FROM schedule ORDER BY starttime DESC", $connection);
		
			echo "<table border='1' align='center'>
			<tr>
			<th>User Name</th>
			<th>Start Time</th>
			<th>End Time</th>
			<th>Node ID</th>
			</tr>";
			
			while($row = mysql_fetch_array($result)) {
			  echo "<tr>";
			  echo "<td>" . $row['username'] . "</td>";
			  echo "<td>" . $row['starttime'] . "</td>";
			  echo "<td>" . $row['endtime'] . "</td>";
			  echo "<td>" . $row['node'] . "</td>";
			  echo "</tr>";
			}
			
			echo "</table>";
			?>
</body>
</html>

<?php
	//-----------5 close connection
	mysql_close($connection);
?>