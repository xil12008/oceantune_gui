<?php 
session_start();	
?>

<?php
if( is_null($_SESSION['username']) ) {
	die("Login Required!");	
}

if ($_SESSION['userflag'] !=0 ) {
	die("Permission denied. Please ask administrator for avaialble time slots.");
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
			<a href="./index.php">Back</a>
			<a href="./schedule_admin.php">New Schedule</a>
            <a href="./remove_schedule.php">Remove Schedule</a>
			<a href="./new_node.php">New Node</a>
            <a href="./remove_node.php">Remove Node</a>
            <a href="./new_user.php">New User</a>
            <a href="./remove_user.php">Remove User</a>
            <a href="./logout.php">Log Out</a>
            </br>
            
			<?php
			// insert new nodes
			if (!is_null($_REQUEST['username']) && !is_null($_REQUEST['starttime']) && !is_null($_REQUEST['hours']) && !is_null($_REQUEST['node']) ) {
				if($_SESSION['userflag']==0) {
					
					$starttime = strtotime($_REQUEST['starttime']);
					
					$endtime = date( "Y-m-d H:i:s", strtotime($_REQUEST['starttime']) + $_REQUEST['hours'] * 3600 );
									
					$result2 = mysql_query("SELECT * FROM schedule WHERE node=".$_REQUEST['node'], $connection);
					while($row2 = mysql_fetch_array($result2)) {
						$starttime2 = strtotime($row2['starttime']);
						$endtime2 = strtotime($row2['endtime']);


						//var_dump($starttime>$endtime2);
						//echo "<br>";
						//var_dump(strtotime($_REQUEST['starttime']) + $_REQUEST['hours'] * 3600>$starttime2);
						//echo "<br>";

						if(($starttime-$endtime2)*(strtotime($_REQUEST['starttime']) + $_REQUEST['hours'] * 3600-$starttime2) <=0 ) {
							die("Invalid schedule. Time slot overlapped.");	
						}
					}
					
					$result3 = mysql_query("INSERT INTO schedule (username, starttime, endtime, node) VALUES ('".$_REQUEST['username']."', '".$_REQUEST['starttime']."','".$endtime."',".$_REQUEST['node'].")");	
					if(!$result3) {
						die('Invalid Query:'.mysql_error());	
					}
					echo "You have added a new time slot.<br />";
				}
				else{
					echo "Permission Denied! Please contact administraters! <br />";
				}
			}
			
			//display schedules
			$result = mysql_query("SELECT * FROM schedule", $connection);
			
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
            
			<form name="form2" method="post" action="schedule_admin.php"> 
            <table width="200" border="0" align="center" cellpadding="2" cellspacing="2">  
				<tr>  
				    <td width="100"><div align="left">User Name</div></td>
				</tr>  
                <tr>
                	<td width="100"><div align="left"><input type="text" name="username"></div></td>  
                </tr>
				<tr>  
				    <td><div align="left">Start Time (YYYY-MM-DD HH:MM:SS)</div></td> 
				</tr>
                <tr>
                	<td><div align="left"><input type="text" name="starttime" value="<?php echo date('Y-m-d H:i:s', strtotime("now"));?>"></div></td>
			  	</tr>

<tr>  
				    <td><div align="left">Period (hours)</div></td> 
				</tr>
<tr>  
<td>
<select name="hours">
  <option value="1">1 hour</option>
  <option value="2">2 hour</option>
  <option value="3">3 hour</option>
  <option value="4">4 hour</option>
  <option value="5">5 hour</option>
  <option value="6">6 hour</option>
  <option value="7">7 hour</option>
  <option value="8">8 hour</option>
  <option value="9">9 hour</option>
  <option value="24">24 hour</option>
</select></td>
    				</tr>


                <tr>  
				    <td><div align="left">Node ID:</div></td> 
				</tr>
                <tr>
           				  	
<?php
			//display nodes
			$result = mysql_query("SELECT * FROM testbed_node", $connection);
			if( ($result==NULL)){
				echo "No more nodes here! <br>";
			}else{
					
						while ( $row = mysql_fetch_array($result)) {
						 
						echo"
						
							<td>
								<div>
									<input type=\"radio\" name=\"node\" value=\"".$row["node_id"]."\">
										".$row["node_id"]."
									</input>
								</div>
							</td>
						";
						
						};
						
			}
			?>



				</tr>
                <tr>
                	<td width = "40"><div align="center"><input type="submit" name="Submit" value="Add" /></div></td>
                </tr>
            </table> 
            </form>
</body>
</html>

<?php
	//-----------5 close connection
	mysql_close($connection);
?>