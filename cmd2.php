<?php 
session_start();	
error_reporting(E_ALL);

//@todo delete debug page after work done
ini_set("display_error", 1);
include("file_with_errors.php");
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

if( is_null($_SESSION['username']) ) {
	die("Login Required!");	
}

	//display schedules
	echo "Schedules:";
	
	$result = mysql_query("SELECT * FROM schedule ORDER BY endtime DESC LIMIT 10", $connection);

	echo "<table border='1' align='left'>
	<tr>
	<th><font color=\"#FFFFFF\">User Name</font></th>
	<th><font color=\"#FFFFFF\">Start Time</font></th>
	<th><font color=\"#FFFFFF\">End Time</font></th>
	<th><font color=\"#FFFFFF\">Node ID</font></th>
	</tr>";
	
	while($row = mysql_fetch_array($result)) {
	  echo "<tr>";
	  echo "<td><font color=\"#FFFFFF\">" . $row['username'] . "</font></td>";
	  echo "<td><font color=\"#FFFFFF\">" . $row['starttime'] . "</font></td>";
	  echo "<td><font color=\"#FFFFFF\">" . $row['endtime'] . "</font></td>";
	  echo "<td><font color=\"#FFFFFF\">" . $row['node'] . "</font></td>";
	  echo "</tr>";
	}
	
	echo "</table><br><a href=\"schedule_user.php\">more</a><br><br><br><br><br><br><br><br>";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Send Cmd</title>
<script>
function refresh(){
window.scrollBy(0, 5000);
}

function send_cmd(frm)
{
	xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function()
	{
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			console.log("remote:"+xmlhttp.responseText);
			if(xmlhttp.responseText.indexOf("Permission denied") > -1) {
				alert("Permission denied. Please ask administrator for next avaialble time slots.");
			}
		}
	}
	cmd=frm.command.value;
	xmlhttp.open("GET","cmd_request.php?q="+cmd,true);
	xmlhttp.send();
	
	setTimeout(function(){window.location.href="cmd2.php"}, 4000);
}

function keyPressed(e, frm)
{
	if(e.keyCode == 13){
	      send_cmd(frm);
		  return false;
	}
}
</script>

</head>
<body marginwidth="0" marginheight="0" onload="refresh()" bgcolor="#000000">
          <form>
          <table width="200" border="0" align="left" cellpadding="2" cellspacing="2">  
            <tr>  
                <td width="100"><div align="left"><font color="#FFFFFF">User Name:</font></div></td>  
                <td width="100"><div align="left"><font color="#FFFFFF"><?php echo $_SESSION['username'];?></font></div></td>
            </tr> 
            <tr>  
                <td><div align="left"><font color="#FFFFFF">User Level(0:admin,2:user)</font></div></td> 
                <td><div align="left"><font color="#FFFFFF"><?php echo $_SESSION['userflag'];?></font></div></td>
            </tr>
            
          </table>
          <?php
			echo "<br><br><br><br><br>";
			echo "<font color=\"#FFFFFF\">";
			
			$file = "/home/xiaoyan/result2.txt";
			$file = escapeshellarg($file); // for the security concious (should be everyone!)
			$line100 = `tail -n 300 $file | grep -v 'tail -n 1 logfile' | grep -v 'bathroom' `;
			
			$dictionary = array(
				'[0m' => '',
				'[01;34m' => '',
				']0;'   => '' ,
			);
			$htmlString = str_replace(array_keys($dictionary), $dictionary, $line100);
			
			echo nl2br(htmlspecialchars($htmlString));
			echo "</font>";s
		  ?>		  
          <div><input autofocus id="command" type="command" name="command" style="border-style:hidden;background-color:#000;color:white" onkeypress="return keyPressed(event, this.form)"></div>
          <br /><br /><br />
          <div id="bottom"><font color="#FFFFFF">Copyright @UWSN Laboratory University of Connecticut. Author <a href="http://ubinet.engr.uconn.edu/~xiaoyan">Xiaoyan Lu</a></font><div>
          </form>
          
          
</body>
</html>
<?php
	//-----------5 close connection
	mysql_close($connection);
?>
