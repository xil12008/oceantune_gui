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
<title>UWSN DEMO GUI Login</title>
</head>

<body>


			<?php
            //----------3 perform database query
            $result = mysql_query("SELECT * FROM testbed_user", $connection);
            if(!$result) {
                  die("database query fail! ".mysql_error());
            }
            
            //----------4 use returned data (if any)
			if(!($_REQUEST['username']=== NULL) ){//login~~~
			
				while ( $row = mysql_fetch_array($result)) {
					echo $row["user_id"]." ".$row["user_name"]." <br />";
					if($row["user_name"]==$_REQUEST['username']){
						if($row["passcode"]==$_REQUEST['passcode']){
							$_SESSION['username'] = $_REQUEST['username'];
							$_SESSION['userflag'] = $row["privilege"];
							echo "SUCESS!Welcome ";
							if($_SESSION['userflag'] == '0') echo "Admin ";
							echo $_SESSION['username'];
							break;
						}
					}
				}
			}
			else{
				echo "Please Login!";	
			}
			?>
            
        <form name="form1" method="post" action="index.php">  
          <table width="200" border="0" align="center" cellpadding="2" cellspacing="2">  
            <tr>  
                <td width="100"><div align="left">Username:</div></td>  
            </tr>  
            <tr>
                <td width="100"><div align="left"><input type="text" name="username"></div></td>  
            </tr>
            <tr>  
                <td><div align="left">Password:</div></td> 
            </tr>
            <tr>
                <td><div align="left"><input type="password" name="passcode"></div></td>
            </tr>
          </table>  
          
          <p align="center">  
				<input type="submit" name="Submit" value="Submit"> 
		  </p>   
        </form>
</body>
</html>

<?php
	//-----------5 close connection
	mysql_close($connection);
?>