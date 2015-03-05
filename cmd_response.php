<?php
	echo "<br><br><br><br><br>";
	$file = file_get_contents('/home/xiaoyan/result.txt', true);
	echo nl2br($file);
	echo ">"
?>