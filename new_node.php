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
<title>New node</title>
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
			//display nodes
			$result = mysql_query("SELECT * FROM testbed_node", $connection);
			while ( $row = mysql_fetch_array($result)) {
					echo $row["node_name"]." is at (".$row["latitude"].",".$row["longitude"].") <br />";
			}
			
			// insert new nodes
			if( $_REQUEST['nodename']!=NULL){
				if($_SESSION['userflag']==0){
					mysql_query("INSERT INTO testbed_node (node_name, IP_addr, port_NUM, longitude, latitude, status)
					VALUES ('".$_REQUEST['nodename']."', '".$_REQUEST['ipaddr']."','".$_REQUEST['port']."',".$_REQUEST['long'].",".$_REQUEST['lat'].",".$_REQUEST['nodestat'].")");
					
					echo "You have added a new node.<br />";
				}
				else{
					echo "Permission Denied! Please contact administraters! <br />";
				}
			}
			?>
            
			<form name="form2" method="post" action="new_node.php"> 
            <table width="600" border="0" align="center" cellpadding="2" cellspacing="2">  
				<tr>  
				    <td width="100"><div align="left">Node Name:</div></td>
				</tr>  
                <tr>
                	<td width="100"><div align="left"><input type="text" name="nodename"></div></td>  
                </tr>
				<tr>  
				    <td><div align="left">IP Address:</div></td> 
				</tr>
                <tr>
                	<td><div align="left"><input type="text" name="ipaddr"></div></td>
			  	</tr>
                <tr>  
				    <td><div align="left">Port Num:</div></td> 
				</tr>
                <tr>
                	<td><div align="left"><input type="text" name="port"></div></td>
			  	</tr>
                <tr>  
				    <td><div align="left">Latitude:</div></td> 
				</tr>
                <tr>
                	<td><div align="left"><input type="text" name="lat" VALUE="41.775"></div></td>
			  	</tr>
                <tr>  
				    <td><div align="left">Longitude:</div></td> 
				</tr>
                <tr>
                	<td><div align="left"><input type="text" name="long" VALUE="-72.181"></div></td>
			  	</tr>
                <tr>  
				    <td><div align="left">Status:</div></td> 
				</tr>
                <tr>
                	<td><div align="left">
                    <input type="radio" name="nodestat" value="0">
                        Online
                    </input>
                    <input type="radio" name="nodestat" value="1">
                        Offline
                    </input>
                    <input type="radio" name="nodestat" value="2" checked>
                        etc.
                    </input></div>
                    </td>
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