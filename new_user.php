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
			//$result = mysql_query("SELECT * FROM testbed_user", $connection);
			//while ( $row = mysql_fetch_array($result)) {
			//		echo $row["node_name"]." is at (".$row["latitude"].",".$row["longitude"].") <br />";
			//}
			
			// insert new nodes
			if( $_REQUEST['user_name']!=NULL){
				if($_SESSION['userflag']==0){//check if we need to reset user password
					if($_REQUEST['reset']==3){
						$result = mysql_query("SELECT * FROM testbed_user", $connection);
						if(!($_REQUEST['user_name']=== NULL) ){//login~~~
							while ( $row = mysql_fetch_array($result)) {
								if($row["user_name"]==$_REQUEST['user_name']){
									mysql_query("UPDATE testbed_user SET passcode='".$_REQUEST['passcode']."',privilege='".$_REQUEST['privilege']."' WHERE user_name='".$_REQUEST['user_name']."'", $connection);
									echo "User password is updated.";
									break;
								}
							}
						}
					}
					else{
						$result2 = mysql_query("INSERT INTO testbed_user (user_name, passcode, privilege)
						VALUES ('".$_REQUEST['user_name']."', '".$_REQUEST['passcode']."','".$_REQUEST['privilege']."')");
						if(!$result2){
							echo "Failed.<br>";
						}
						else{
							echo "You have added a new user.<br />";
						}
					}
				}
				else{
					echo "Permission Denied! Please contact administraters! <br />";
				}
			}
			?>
            
            
			<form name="form2" method="post" action="new_user.php"> 
            <table width="600" border="0" align="center" cellpadding="2" cellspacing="2">  
				<tr>  
				    <td width="100"><div align="left">User Name:</div></td>
				</tr>  
                <tr>
                	<td width="100"><div align="left"><input type="text" name="user_name"></div></td>  
                </tr>
				<tr>  
				    <td><div align="left">passcode:</div></td> 
				</tr>
                <tr>
                	<td><div align="left"><input type="text" name="passcode"></div></td>
			  	</tr>
                <tr>  
				    <td><div align="left">Privilege:</div></td> 
				</tr>
                <tr>
                	<td><div align="left">
                    <input type="radio" name="privilege" value="2">
                        User
                    </input>
                    <input type="radio" name="privilege" value="0">
                        Admin
                    </input>
                    </div>
                    </td>
			  	</tr>
                <tr>  
				    <td><div align="left">Reset:</div></td> 
				</tr>
                <tr>
                	<td><div align="left">
                    <input type="radio" name="reset" value="3">
                        Reset user password and privilege
                    </input>
                    </div>
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