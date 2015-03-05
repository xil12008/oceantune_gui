<?php
	$q = $_GET['q'];
	
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

	if($q=="node_1"){
		$result_transfer = mysql_query("SELECT * FROM sense_data WHERE NodeName='".$q."' ORDER BY Date DESC LIMIT 2", $connection);
	}
	else if($q=="node_2"){
		$result2 = mysql_query("SELECT * FROM sense_data WHERE NodeName='".$q."'AND SourceID='N2' ORDER BY Date DESC LIMIT 1", $connection);
		$result_transfer = mysql_query("SELECT * FROM sense_data WHERE NodeName='".$q."' AND SourceID='N4' ORDER BY Date DESC LIMIT 1", $connection);
		
	}
	else if($q=="node_4"){
		$result2 = mysql_query("SELECT * FROM sense_data WHERE NodeName='".$q."'AND SourceID='N4' ORDER BY Date DESC LIMIT 1", $connection);
		$result_transfer = mysql_query("SELECT * FROM sense_data WHERE NodeName='".$q."' AND SourceID='N2' ORDER BY Date DESC LIMIT 1", $connection);
	}
	
	if(mysql_num_rows($result2)+mysql_num_rows($result_transfer)){
		echo '<table cellpadding="1" cellspacing="1">';
		echo '<tr><th>NodeName</th><th>Temperature(Celsius)</th><th>Conductivity(S/m)</th><th>Pressure(Decibars)</th><th>Salinity(PSU)</th><th>Date</th><th>  Time</th><th>  Source Node</th></tr>';
	
	
		if(mysql_num_rows($result2)) {
				while($row2 = mysql_fetch_row($result2)) {
					echo '<tr bgcolor="#ADD8E6">';
					foreach($row2 as $key=>$value) {
						echo '<td>',$value,'</td>';
					}
					echo '</tr>';
				}
		}
		else{
			//echo "No sense data yet.";	
		}
		
		if(mysql_num_rows($result_transfer)) {
				while($row2 = mysql_fetch_row($result_transfer)) {
					echo '<tr bgcolor="#F9966B">';
					foreach($row2 as $key=>$value) {
						echo '<td>',$value,'</td>';
					}
					echo '</tr>';
				}
		}
		else{
			//echo "No sense data yet.";	
		}
	
		echo '</table><br />';
	}
	else{
			echo "No data yet.";
	}
	//-----------5 close connection
	mysql_close($connection);
?>