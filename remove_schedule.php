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
			
			// remove new users
			if( $_REQUEST['schedule_id']!=NULL){
				if($_SESSION['userflag']==0){
					echo "Permitted to remove schedule.<br />";
					mysql_query("DELETE FROM schedule WHERE ID='".$_REQUEST['schedule_id']."'");
				}
				else{
					echo "Permission Denied! Please contact administraters! <br />";
				}
			}
			
			//display users
			$result = mysql_query("SELECT * FROM schedule", $connection);
			if( ($result==NULL)){
				echo "No schedule! <br>";
			}else{
				echo "<form name=\"form2\" method=\"post\" action=\"remove_schedule.php\"> 
					<table width=\"800\" border=\"0\" align=\"center\" cellpadding=\"2\" cellspacing=\"2\"> 
						";
						
						while ( $row = mysql_fetch_array($result)) {
						 
						echo"
						<tr>
							<td>
								<div align=\"left\">
									<input type=\"radio\" name=\"schedule_id\" value=\"".$row["ID"]."\">
										".$row['username'] ." from ". $row['starttime'] ." to ". $row['endtime'] ." at Node ". $row['node'] . " <br />"."
									</input>
								</div>
							</td>
						</tr>";
						
						};
						
						
				echo "
						<tr>
							<td width = \"40\"><div align=\"left\"><input type=\"submit\" name=\"Submit\" value=\"Remove\" /></div></td>
						</tr>
					</table> 
				</form>";
			}
			
			?>
            
</body>
</html>

<?php
	//-----------5 close connection
	mysql_close($connection);
?>