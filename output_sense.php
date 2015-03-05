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

<style>
#customers
{
font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
width:100%;
border-collapse:collapse;
}
#customers td, #customers th 
{
font-size:1em;
border:1px solid #98bf21;
padding:3px 7px 2px 7px;
}
#customers th 
{
font-size:1.1em;
text-align:left;
padding-top:5px;
padding-bottom:4px;
background-color:#A7C942;
color:#ffffff;
}
#customers tr.alt td 
{
color:#000000;
background-color:#EAF2D3;
}
</style>

<link rel="stylesheet" href="http://cdn.oesmith.co.uk/morris-0.4.3.min.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="http://cdn.oesmith.co.uk/morris-0.4.3.min.js"></script>

</head>

<body>

<div id="myfirstchart" style="height: 250px;"></div>
<script>
(new Morris.Line({
  // ID of the element in which to draw the chart.
  element: 'myfirstchart',
  // Chart data records -- each entry in this array corresponds to a point on
  // the chart.
  //data: [
//    { year: '2008', value: 20 },
//    { year: '2009', value: 10 },
//    { year: '2010', value: 5 },
//    { year: '2011', value: 5 },
//    { year: '2012', value: 20 }
//  ],
  data: [
	<?php	
	/* draw figure */
	$result = mysql_query("SELECT Pressure, Time FROM sense_data WHERE NodeName='".$_REQUEST['name']."' ORDER BY Date DESC LIMIT 30", $connection);
	while ( $row = mysql_fetch_array($result)) {
			echo '{ year:\''.$row["Time"].'\', value:'.$row["Pressure"].'},';
	}
	?> 
  ],
  
  // The name of the data record attribute that contains x-values.
  xkey: 'year',
  // A list of names of data record attributes that contain y-values.
  ykeys: ['value'],
  // Labels for the ykeys -- will be displayed when you hover over the
  // chart.
  labels: ['Value']
}))();
</script>


<?php	
	/* show tables */
	$table = "sense_data";
	
	//echo '<h3>',$table,'</h3>';
	$result2 = mysql_query("SELECT * FROM sense_data WHERE NodeName='".$_REQUEST['name']."' ORDER BY Date DESC LIMIT 30", $connection);
	
	if(mysql_num_rows($result2)) {
		echo '<table cellpadding="1" cellspacing="1" class="db-table" id="customers">';
		echo '<tr><th>NodeName</th><th>Temperature(Celsius)</th><th>Conductivity(S/m)</th><th>Pressure(Decibars)</th><th>Salinity(PSU)</th><th>Date</th><th>  Time</th><th>  Source Node</th></tr>';
		$trigger = 0;
		while($row2 = mysql_fetch_row($result2)) {
			
			if($trigger==1) echo "<tr class=\"alt\">";
			else echo '<tr>';
			
			$trigger = 1 - $trigger;
			
			foreach($row2 as $key=>$value) {
				echo '<td>',$value,'</td>';
			}
			echo '</tr>';
		}
		echo '</table><br />';
	}
?>


</body>
</html>

<?php
	//-----------5 close connection
	mysql_close($connection);
?>