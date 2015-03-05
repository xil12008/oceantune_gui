<?php 
session_start();	
if(is_null($_SESSION['username'])) $_SESSION['username'] = "nobody";
if(is_null($_SESSION['userflag'])) $_SESSION['userflag'] = "99";  
?>

<?php
//------1. create a connection
$connection = mysql_connect("localhost", "oceantune_wui","ChunXia&2012");
if(!$connection) {
      die("Database connection fail! ".mysql_error());
}

//-------2 select a database
$db_select = mysql_select_db("oceantune_wui", $connection);
if(!$db_select) {
      die("Database selection fail! ".mysql_error());
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="keywords" content="jquery,ui,easy,easyui,web">
	<meta name="description" content="easyui help you build your web page easily!">
	<title>TESTBED GUI</title>
    <link rel="shortcut icon" href="favicon.ico" />
	<link rel="stylesheet" type="text/css" href="http://www.jeasyui.com/easyui/themes/default/easyui.css">
	<link rel="stylesheet" type="text/css" href="http://www.jeasyui.com/easyui/themes/icon.css">
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.6.1.min.js"></script>
	<script type="text/javascript" src="http://www.jeasyui.com/easyui/jquery.easyui.min.js"></script>
    <link rel="stylesheet" type="text/css" href="./application/media/js/envision.min.css">
    <script type="text/javascript" src="./application/media/js/envision.min.js"></script>
    
    
	<script>
		function addTab(title, url){
			if ($('#tt').tabs('exists', title)){
				$('#tt').tabs('select', title);
			} else {
				var content = '<iframe scrolling="auto" id="myIFrame" frameborder="0" src="'+url+'" style="width:100%;height:100%;"></iframe>';
				$('#tt').tabs('add',{
					title:title,
					//href:url,
					content:content,
					closable:true
				});
			}
		}
	</script>
	
    
    <!--Pop up Dialogs-->
    <script>
		function jLoginForm()
		{
		   //window.open('login.php', 'login', 'height=230,width=220');
		   $('#dd').dialog({  
    		title: 'Login',  
    		width: 500,  
    		height: 300,  
    		closed: false,  
    		cache: false,  
    		href: 'login.php',  
    		modal: true  
			});	   
		}
    </script>
    
    <script>
		function jTimeseriesForm()
		{
		   //window.open('login.php', 'login', 'height=230,width=220');
		   $('#timeseries-box').dialog({  
    		title: 'Timeseries',  
    		width: 500,  
    		height: 300,  
    		closed: false,  
    		cache: false,  
    		href: 'timeseries.php',  
    		modal: true  
			});	   
		}
    </script>
    
    <script>
		function jNewNode()
		{
			$('#ll').dialog({  
    		title: 'New Node',  
    		width: 400,  
    		height: 500,  
    		closed: false,  
    		cache: false,  
    		href: 'new_node.php',  
    		modal: true  
			});	
			
		   //window.open('new_node.php', 'new_node', 'height=600,width=250');
		}
    </script>
    
    <script>
		function jHelp()
		{
		   window.open('help.php', 'help', 'height=300,width=300');
		}
    </script>
    <script>
		function jRemoveNode()
		{
		   window.open('remove_node.php', 'remove_node', 'height=300,width=800');
		}
    </script>
    
	<!--Google Map-->
	<script
		src="http://maps.googleapis.com/maps/api/js?key=AIzaSyAuO8nH4GlE5hR4GajIXwyZYtAiXcckjmc&sensor=false">
	</script>
	<script>
		var map;
		var myCenter=new google.maps.LatLng(41.308, -72.06037);
		var uconn = new google.maps.LatLng(41.807405,-72.253182);

		// Add a Home control that returns the user to uconn
		function HomeControl(controlDiv, map) {
		  controlDiv.style.padding = '5px';
		  var controlUI = document.createElement('div');
		  controlUI.style.backgroundColor = 'yellow';
		  controlUI.style.border='1px solid';
		  controlUI.style.cursor = 'pointer';
		  controlUI.style.textAlign = 'center';
		  controlUI.title = 'Set map to uconn';
		  controlDiv.appendChild(controlUI);
		  var controlText = document.createElement('div');
		  controlText.style.fontFamily='Arial,sans-serif';
		  controlText.style.fontSize='12px';
		  controlText.style.paddingLeft = '4px';
		  controlText.style.paddingRight = '4px';
		  controlText.innerHTML = '<b>uconn<b>'
		  controlUI.appendChild(controlText);

		  // Setup click-event listener: simply set the map to uconn
		  google.maps.event.addDomListener(controlUI, 'click', function() {
			map.setCenter(uconn)
		  });
		}

		// Add a Home control that returns the user to uconn
		function HomeControl2(controlDiv, map) {
		  controlDiv.style.padding = '5px';
		  var controlUI = document.createElement('div');
		  controlUI.style.backgroundColor = 'yellow';
		  controlUI.style.border='1px solid';
		  controlUI.style.cursor = 'pointer';
		  controlUI.style.textAlign = 'center';
		  controlUI.title = 'Set map to lake';
		  controlDiv.appendChild(controlUI);
		  var controlText = document.createElement('div');
		  controlText.style.fontFamily='Arial,sans-serif';
		  controlText.style.fontSize='12px';
		  controlText.style.paddingLeft = '4px';
		  controlText.style.paddingRight = '4px';
		  controlText.innerHTML = '<b>lake<b>'
		  controlUI.appendChild(controlText);

		  // Setup click-event listener: simply set the map to uconn
		  google.maps.event.addDomListener(controlUI, 'click', function() {
			map.setCenter(myCenter)
		  });
		}

		function initialize()
		{
			
		var mapProp = {
		  center:myCenter,
		  zoom:15,
		  mapTypeId:google.maps.MapTypeId.ROADMAP
		  };

		var infowindow = new google.maps.InfoWindow({
				content:"welcome"
			}); 

		  map = new google.maps.Map(document.getElementById("googleMap"),mapProp);
			
			<?php
				//----------3 perform database query
				$result_node = mysql_query("SELECT * FROM testbed_node", $connection);
				if(!$result_node) {
					  die("database query fail! ".mysql_error());
					  //echo "Console.log(".$result_node");"
				}
				
				//----------4 use returned data (if any)
				while ( $row_node = mysql_fetch_array($result_node)) {
					echo "var point = new google.maps.LatLng(".$row_node["latitude"].",".$row_node["longitude"].");";
					//echo "Console.log(".$row_node["latitude"].");";
					echo "placeMarker(point,'".$row_node["node_name"]."',".$row_node["node_id"].",'".$row_node["IP_addr"]."','".$row_node["port_NUM"]."',".$row_node["status"].");";
				}
			?>
		  
		  //google.maps.event.addListener(map, 'click', function(event) {
			//placeMarker(event.latLng);
			//Console.log(event);
		  //});
		  
		  // Create a DIV to hold the control and call HomeControl()
		  var homeControlDiv = document.createElement('div');
		  var homeControl = new HomeControl(homeControlDiv, map);
		  //homeControlDiv.index = 1;
		  map.controls[google.maps.ControlPosition.TOP_RIGHT].push(homeControlDiv);
		  
		  // Create a DIV to hold the control and call HomeControl()
		  var homeControlDiv = document.createElement('div');
		  var homeControl = new HomeControl2(homeControlDiv, map);
		  //homeControlDiv.index = 1;
		  map.controls[google.maps.ControlPosition.TOP_CENTER].push(homeControlDiv);
		  
		  	//------------------------------------------------------------
		      // Define a symbol using a predefined path (an arrow)
			  // supplied by the Google Maps JavaScript API.
			  var lineSymbol = {
				path: google.maps.SymbolPath.FORWARD_CLOSED_ARROW
			  };
			
			  // Create the polyline and add the symbol via the 'icons' property.
			
			  var lineCoordinates = [
				new google.maps.LatLng(41.30732833, -72.061795),
				new google.maps.LatLng(41.30732, -72.05165)
			  ];
			
			  line = new google.maps.Polyline({
				path: lineCoordinates,
				icons: [{
				  icon: lineSymbol,
				  offset: '100%'
				}],
				geodesic: true,
				strokeColor: '#FF0000',
				strokeOpacity: 1.0,
				strokeWeight: 2,
				map: map
			  });
			  
			  
			  //---------------------------------------------------------------
			  // Define a symbol using a predefined path (an arrow)
			  // supplied by the Google Maps JavaScript API.
			  var lineSymbol2 = {
				path: google.maps.SymbolPath.FORWARD_CLOSED_ARROW
			  };
			
			  // Create the polyline and add the symbol via the 'icons' property.
			
			  var lineCoordinates2 = [
				new google.maps.LatLng(41.302611, -72.064378),
				new google.maps.LatLng(41.30732, -72.05165)
			  ];
			
			  line2 = new google.maps.Polyline({
				path: lineCoordinates2,
				icons: [{
				  icon: lineSymbol2,
				  offset: '100%'
				}],
				geodesic: true,
				strokeColor: '#00FF00',
				strokeOpacity: 1.0,
				strokeWeight: 2,
				map: map
			  });
			  
		}
		
		var line;
		var line2;
		
		function hide_line(){
			line.setMap(null);
			line2.setMap(null);	
		}


		function show_line(){
			line.setMap(map);
			line2.setMap(map);	
		}
		
		function placeMarker(location,name,id,IP,port,st) {
		  var marker = new google.maps.Marker({
			position: location,
			map: map,
		  });
		  
		  var sbutton = '<a href="#" class="easyui-linkbutton" onclick="addTab(\'[' + id+']:'+name + '\',\'http://uwsn.engr.uconn.edu/OceanTune/telnet/index.php?id='+ id + '&name=' + name + '&ip='+ IP + '&port=' + port + '\')">telnet</a>';			
		  var sbutton2 = '<a href="#" class="easyui-linkbutton" onclick="addTab(\'[' + id+']:'+name + '\',\'http://uwsn.engr.uconn.edu/OceanTune/telnet2/xiaoyan_index.php?id='+ id + '&name=' + name + '&ip='+ IP + '&port=' + port + '\')">Details</a>';
		   
		  var sbutton22 = '<a href="#" class="easyui-linkbutton" onclick="addTab(\'[' + id+']:'+name + '\',\'http://uwsn.engr.uconn.edu/OceanTune/telnet2/xiaoyan_index.php?id='+ id + '&name=' + name + '&ip='+ IP + '&port=' + port + '\')">'+name+'</a>';
		  
		  var status = 'etc.';
		  if(st==0){
			status = 'Online';  
		  }
		  else if (st==1){
			status = 'Offline';  
		  }
		  
		  var infowindow = new google.maps.InfoWindow({
			content: <?php //if(($_SESSION['username'] == "nobody")) {echo "sbutton+"; } ?> 
						'Node Name: ' + sbutton22+
						'<br>Latitude: ' + location.lat()+ '<br>'
						+ 'Longitude: ' + location.lng() + '<br>'
						+ "IP: "+IP+":"+port+"<br>"
						+ "Status: "+status+"<br>"
		  });
		  
		  infowindow.open(map,marker);
		  
		  setTimeout(function () {
        		update_infowindow(infowindow,name,sbutton2)
		  }, (Math.random()*8000));
		  
		  setTimeout(function () {
        		var int=self.setInterval(function(){update_infowindow(infowindow,name,sbutton2)},20000);
		  }, (Math.random()*20000));
		 
		  var lng = location.lng();
		  var la = location.lat();
		  
		  // add listener for each marker.
		  google.maps.event.addListener(marker, 'click', function() {
			infowindow.open(map,marker);
		  });
		  
		  //google.maps.event.addListener(marker, "rightclick", function() {
			//marker.setMap(null);  });
		  
		}

		function update_infowindow(infowindow,name,sbutton2){
			var d = new Date();
			var t = d.toLocaleTimeString();
			
			console.log("update_infowindow");
			console.log("local:"+name);
			
			showUser(infowindow,name,sbutton2);
			
		}
		
		function showUser(infowindow,str,sbutton2)
		{
			 xmlhttp=new XMLHttpRequest();
			 xmlhttp.onreadystatechange=function()
			  {
				  if (xmlhttp.readyState==4 && xmlhttp.status==200)
					{
						console.log("remote:"+xmlhttp.responseText);
						infowindow.setContent(xmlhttp.responseText+"<br>"+sbutton2);
					}
			  }
			xmlhttp.open("GET","ajax_php.php?q="+str,true);
			xmlhttp.send();
		}

		google.maps.event.addDomListener(window, 'load', initialize);
		</script>

	<style type="text/css">
		  html { height: 100% }
		  body { height: 100%; margin: 0; padding: 0 }
		  #googleMap{ height: 100% }
	</style>
</head>

<body>
    

    <div style="background:#fafafa;padding:5px;width:100%;border:1px solid #ccc">  
        <a href="#" class="easyui-menubutton" menu="#mm1" iconCls="icon-edit">Account</a>  
        <a href="#" class="easyui-menubutton" menu="#mm2" iconCls="icon-edit">Map</a>  
        <a href="#" class="easyui-menubutton" menu="#mm3" iconCls="icon-help">Help</a>  
    </div>  
    <div id="mm1" style="width:100px;">  
        <div onclick="jLoginForm()">Login</div>  
        <div onclick="location.href='logout.php'">Logout</div>
        <div onclick="location.href='timeseries.php'">Monitor</div>
        <div onClick="location.href='admin_page.php'">Admin Page</div>
        <div class="menu-sep"></div>  
        <div>Register</div>  
        <div class="menu-sep"></div>  
        <div>Exit</div>  
    </div>  
    <div id="mm2" style="width:100px;"> 
    	<div onclick="jNewNode()">New Node</div>
        <div onclick="jRemoveNode()">Remove Node</div>
     	<div class="menu-sep"></div> 
        <div>Zoom-in</div>  
        <div>Zoom-out</div> 
        <div class="menu-sep"></div>  
        <div onClick="document.location.reload(true)">Reload Page</div>  
        <div onClick="initialize()">Reload Map</div>
        <div onClick="addTab('[28]:33','http://uwsn.engr.uconn.edu/OceanTune/telnet/index.php?id=28&name=33&ip=166.241.213.110&port=12345')">
        Test
        </div>
    </div>  
	<div id="mm3" style="width:100px;"> 
    	<div onclick="jHelp()">Help</div> 
    </div>
	
    <div id="container" style="width:auto;height:auto;margin-left:15px;">
		
        	<div class="easyui-layout" style="width:auto; height:700px">
                <div region="west" split="true" title="Navigator" style="width:150px">
                	
                    <div id="west-container" style="width:auto;height:auto;margin-left:8px;">
                        <?php
                        //----------3 perform database query
                        $result = mysql_query("SELECT * FROM testbed_user", $connection);
                        if(!$result) {
                              die("database query fail! ".mysql_error());
                        }
                        
                        
                        //----------4 use returned data (if any)
                        /*while ( $row = mysql_fetch_array($result)) {
                            //echo $row["user_id"]." ".$row["user_name"]." <br />";
                            
                            //user login~~~
                            if(!($_REQUEST['username']=== NULL) ){	
                                // check if name and password are both correct
								if($row["user_name"]==$_REQUEST['username']){
                                    if($row["passcode"]==$_REQUEST['passcode']){
										$_SESSION['username'] = $_REQUEST['username'];
                                        $_SESSION['userflag'] = $row["privilege"];
										//echo "Log in sec!!!"
                                    }
                                }
                            }
                        }*/
                        
                        
                        // insert new nodes
                        if( $_REQUEST['update']!=NULL and $_REQUEST['nodename']!=NULL){
                            if($_SESSION['userflag']==0){
                                mysql_query("INSERT INTO testbed_node (node_name, IP_addr, port_NUM, longitude, latitude, status)
                                VALUES ('".$_REQUEST['nodename']."', '".$_REQUEST['ipaddr']."','".$_REQUEST['port']."',".$_REQUEST['long'].",".$_REQUEST['lat'].",".$_REQUEST['nodestat'].")");
                                
                                echo "INSERT INTO testbed_node (node_name, IP_addr, port_NUM, longitude, latitude, status)
                                VALUES ('".$_REQUEST['nodename']."', '".$_REQUEST['ipaddr']."','".$_REQUEST['port']."',".$_REQUEST['long'].",".$_REQUEST['lat'].",".$_REQUEST['nodestat'].")";
                                echo "<script language=javascript>initialize()</script>";
                            }
                            else{
                                echo "Permission Denied! Please contact administraters!";
                            }
                        }
                        
                        ?>
                        
                        <!--<script language=javascript>
                        //	var point = new google.maps.LatLng(41.7745, -72.1806);
                        //	placeMarker(point);
                        //</script>
                        -->
                        
                        <!--
                        <div region="north">Welcome! <br></div>
                        
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
                        </form> -->
                        
                        <input type="button" value="Reload Page" onClick="document.location.reload(true)">
                        <input type="button" value="Reload Map" onClick="initialize()">
                        <input type="button" value="Remove Node" onClick="jRemoveNode()">
                        <input type="button" value="Create Node" onClick="jNewNode()">
                        <input type="button" value="Hide Line" onClick="hide_line()">
                        <input type="button" value="Show Line" onClick="show_line()">
                        <?php
                        /* Output Nodes Situation*/
                        
                        //----------3 perform database query
                        
                            $result = mysql_query("SELECT * FROM testbed_user", $connection);
                            if(!$result) {
                                  die("database query fail! ".mysql_error());
                            }
                            
                            //----------4 use returned data (if any)
                            if(!($_REQUEST['username']=== NULL) ){//login~~~
                            	echo "<br>Request ".$_REQUEST['username']."!<br>";
							
                                while ( $row = mysql_fetch_array($result)) {
                                    //echo $row["user_id"]." ".$row["user_name"]." <br />";
                                    if($row["user_name"]==$_REQUEST['username']){
                                        if($row["passcode"]==$_REQUEST['passcode']){
                                            $_SESSION['username'] = $_REQUEST['username'];
                                            $_SESSION['userflag'] = $row["privilege"];
                                            //echo "SUCESS!Welcome ";
                                            //if($_SESSION['userflag'] == '0') echo "Admin ";
                                            
											break;
                                        }
                                    }
                                }         
								echo "<br>Welcome ".$_SESSION['username']."!<br>";
                            }
                            else{
                                echo "<br>Please Login!<br>";	
                            }
                        	
							echo '<br>Username : '.$_SESSION['username']."<br>";
                            //echo '<br>userflag '.$_SESSION['userflag'];
                                
                        ?>
                        
                        <?php /* Continue*/
                        //display nodes
                        $result = mysql_query("SELECT * FROM testbed_node", $connection);
						echo "<br>";
                        while ( $row = mysql_fetch_array($result)) {
                                echo $row["node_name"]." is at (".$row["latitude"].",".$row["longitude"].") <br />";
                        }
                        
                        // insert new nodes
                        if( $_REQUEST['nodename']!=NULL){
                            if($_SESSION['userflag']==0){
                                mysql_query("INSERT INTO testbed_node (node_name, IP_addr, port_NUM, longitude, latitude, status)
                                VALUES ('".$_REQUEST['nodename']."', '".$_REQUEST['ipaddr']."','".$_REQUEST['port']."',".$_REQUEST['long'].",".$_REQUEST['lat'].",".$_REQUEST['nodestat'].")");
                                
                                echo "You have added a new node.<br />";
                                
                                echo "<script>document.location.reload(true)</script>";
                            }
                            else if($_SESSION['userflag']!=99){
                                echo "<font size=\"3\" color=\"red\">Permission Denied! Please contact administraters! </font><br />";
                            }
                        }
                        ?>
                        
                        
                        
                        <div id="ll"></div>
                        <div id="dd"></div>
                        <div id="timeseries-box"></div>
                        
                        <!--ll and dd are used as empty div for pop-up forms-->
                        
                        
                        <!--
                        
                        <form name="form2" method="post" action="index.php"> 
                        <table width="200" border="0" align="center" cellpadding="2" cellspacing="2">  
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
                                <td><div align="left"><input type="text" name="lat"></div></td>
                            </tr>
                            <tr>  
                                <td><div align="left">Longitude:</div></td> 
                            </tr>
                            <tr>
                                <td><div align="left"><input type="text" name="long"></div></td>
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
                                <td width = "40" ><div align="left"><input type="checkbox" name="update" />insert/update nodes</div></td>
                            </tr>
                            <tr>
                                <td width = "40"><div align="left"><input type="submit" name="Submit" value="Submit" />GO</div></td>
                            </tr>
                        </table> 
                        </form>
                        
                        -->
                    </div>
				</div><!--west end-->                    
                
                <div id="content" region="center" title="TESTBED GUI" style="width:100%; height:100%">
                    <div id="tt" class="easyui-tabs" style="width:auto; height:640px">
                        <div title="Map" style="width:100%; height:100%">
                            <div id="googleMap" style="width:100%; height:100%"></div>
                        </div>
                    </div>
                </div><!--content end-->
            
        	</div> <!--Easy Layout-->
        </div>
        <div id="footer" style="clear:both;text-align:center;">
		Copyright © UWSN Lab</div>
	</div>
</body>
</html>

<?php
//-----------5 close connection
mysql_close($connection);
?>