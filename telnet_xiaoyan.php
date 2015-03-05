<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>

<script type="text/javascript" src="public/js/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="public/js/node.js"></script>

</head>

<body>

<div id="wrapper" class="outter" >
		<label for='address' class="labels">IP Address: </label>
        <span id='span_address' class="span_setting">166.241.213.110</span>
        <input type="text" name='address' id='input_address' style="display:none" />
        <label for='port' class="labels">Port: </label>
        <span id='span_port' class="span_setting">12345</span>
        <input type="text" name='port' id='input_port' style="display:none" value="12345" />
</div>

<script>
connectModem(1);
</script>


</body>
</html>