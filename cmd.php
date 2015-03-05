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

	$session_endtime = NULL;
	$cur_date = date('Y-m-d H:i:s');
	
	echo "<table border='1' align='left'>
	<tr>
	<th>User Name</th>
	<th>Start Time</th>
	<th>End Time</th>
	<th>Node ID</th>
	</tr>";

	while($row = mysql_fetch_array($result)) {
         $count==0;
	  if($count<2){
	  echo "<tr>";
	  echo "<td>" . $row['username'] . "</td>";
	  echo "<td>" . $row['starttime'] . "</td>";
	  echo "<td>" . $row['endtime'] . "</td>";
	  echo "<td>" . $row['node'] . "</td>";
	  echo "</tr>";
         $count = $count + 1;
	  }
	  if($row['username'] == $_SESSION['username']){
		if(($row['endtime'] > $cur_date) && ($row['starttime'] < $cur_date)){
		  $session_endtime = $row['endtime'];
		}
	  }
	  if (is_null($session_endtime)) {
	  	$session_endtime = "empty";
	  }
	}
	echo "</table><br><a href=\"schedule_user.php\">more</a><br><br><br>";	
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Send Cmd</title>

<style type="text/css">
body,td,th {
	color: #000000;
}
.stuck {
    left: 12px;
    max-height: 95%;
    overflow-x: auto;
}
.stuck2 {
	left: 12px;
	width: 700px;
}
</style>
</head>
<body marginwidth="0" marginheight="0" onload="refresh()" bgcolor="#FFFFFF">
			
          <form>
                    
          <table width="665" border="0" align="left" cellpadding="2" cellspacing="2"> 
            <tr>  
                <td width="80"><div align="left">User Name:</div></td>  
                <td width="125"><div align="left"><?php echo $_SESSION['username'];?></div></td>
                <td width="100"><div align="left">User Level
              (0:admin,2:user)</div></td> 
                <td width="125"><div align="left"><?php echo $_SESSION['userflag'];?></div></td>
                <td width="203"><p><font color="#FF0004">Your session will end in:</font></p>
                <p><font color="#FF0004"> <span id="countdown"></span></font></p></td>
          </table>


          <p><br />
            </p>
          <p style="line-height: 150%">&nbsp;</p>

          <table width="910" border="0">
            <tbody>
              <tr>
                <td width="720" height="390">
                    <table width="712" height="388" border="1" bordercolor="A1A1A1" cellpadding="5" cellspacing="0" bgcolor="#000000" >
                    <td width="698" height="354"> 
                    <div class="stuck" id="stuckwindow">
           <?php
			echo "<br><br><br><br>";
			//$file = file_get_contents('/home/xiaoyan/result2.txt', true);
			echo "<font color=\"#FFFFFF\">";
			
			$file = "/home/xiaoyan/result2.txt";
			$file = escapeshellarg($file); // for the security concious (should be everyone!)
			$line100 = `tail -n 300 $file | grep -v 'tail -n 1 logfile' | grep -v 'bathroom' | grep -v 'logfile' | grep -v 'oceantune' | grep -v 'clean'  `;
			
			$dictionary = array(
				'[0m' => '',
				'[01;34m' => '',
				'[30;42' => '',
				']0;'   => '' ,
				'[01;36m' => '' ,
			);
			$htmlString = str_replace(array_keys($dictionary), $dictionary, $line100);
			
			echo nl2br(htmlspecialchars($htmlString));
			echo "</font>";
		  ?>		
          </div>  
          <div class="stuck2"></div>
          		</td>
                    <tr>
                      <td height="31"><span class="stuck2">
                        <input size="80" autofocus id="command" type="command" name="command" disabled="disabled" style="border-style:hidden;background-color:#000;color:white; align-items:baseline" onkeypress="return keyPressed(event, this.form)" />
                      </span></td>
                </table></td>		
                <td width="180" valign="bottom" style="text-align: left; border-style: none; margin-top: 0px; margin-bottom: 5px;"><p>Additional Functions:</p>
                
                 <p style="line-height: 200%;"> 
                  <input type="button" name="crtlCButton" style="font-family: sans-serif; font-size: 15px;" id="crtlCButton" disabled="disabled" value="Crtl + C" onclick="send_cmd(this.form, true)" />
                  <input type="button" name="button2" style="font-family: sans-serif; font-size: 15px;" id="kermitCmdButton" disabled="disabled" value="Crtl+] + Shift+C" onclick="send_cmd(this.form, true)" />
                 <!-- <input type="button" name="button3" style="font-family: sans-serif; font-size: 15px;" id="clearButton" disabled="disabled" value="Clear" onclick="send_cmd(clear!)" />
                 </p>
                 -->
                 
                 <p>&nbsp;</p>
                </td>
              </tr>
            </tbody>
          </table>
          <p><br />
            <div id="bottom">
            Copyright @UWSN Laboratory University of Connecticut. Author <a href="http://ubinet.engr.uconn.edu/~xiaoyan">Xiaoyan Lu</a> & <a href="http://www.engr.uconn.edu/~rcm08005">Robert Martin</a></p>
          <div>
          </form>
          
          
</body>
<script>
function refresh(){
window.scrollBy(0, 5000);
var elem = document.getElementById('stuckwindow');
elem.scrollTop = elem.scrollHeight;  
}

function send_cmd(frm, kCmd)
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
	
	if(kCmd){
		cmd=""	//empty for now
	}
	else{
		cmd=frm.command.value;
	}
	xmlhttp.open("GET","cmd_request.php?q="+cmd,true);
	xmlhttp.send();
	
	setTimeout(function(){window.location.href="cmd.php"}, 1000);
}

function keyPressed(e, frm)
{
	if(e.keyCode == 13){
	      send_cmd(frm, false);
		  return false;
	}
}

var days, hours, minutes, seconds;
var countdown = document.getElementById("countdown");
var session_endtime = "<?php echo $session_endtime; ?>";
if (session_endtime == "empty") {session_endtime = -1;}
else {
	var session_endtime = new Date("<?php echo $session_endtime; ?>");
}
setInterval( function () {
	if (session_endtime == -1){
		countdown.innerHTML = "Expired";
		document.getElementById("command").disabled = true;
		document.getElementById("crtlCButton").disabled = true;
		document.getElementById("kermitCmdButton").disabled = true;
	}
	else {	
		document.getElementById("command").disabled = false;
		document.getElementById("crtlCButton").disabled = false;
		document.getElementById("kermitCmdButton").disabled = false;

		var current_time = new Date().getTime();
		var seconds_left = (session_endtime - current_time) / 1000;
	 
		days = parseInt(seconds_left / 86400);
		seconds_left = seconds_left % 86400;
		hours = parseInt(seconds_left / 3600);
		seconds_left = seconds_left % 3600;
		minutes = parseInt(seconds_left / 60);
		seconds = parseInt(seconds_left % 60);
	
		countdown.innerHTML = days + "d, " + hours + "h, " + minutes + "m, " + seconds + "s";  
	
		if(days == 0 && hours == 0 && minutes == 5 && seconds == 0){
			alert("Warning: You have 5 minutes left of your session.");
		}
		
		if(seconds < 0){
			//redirect();
			alert("Warning: Your session has ended. Functionality has been disabled.");
			session_endtime = -1;
		}
	}
}, 1000);

function redirect(){
	alert("Your session has ended.");
	window.location = "http://uwsn.engr.uconn.edu/OceanTune/"
}

</script>
</html>
<?php
	//-----------5 close connection
	mysql_close($connection);
?>
