<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<?php

/*
	$to      = 'chunxia.bai@gmail.com';
$subject = 'the subject';
$message = 'hello';
$headers = "From: " . $email . PHP_EOL;
$headers .= "Reply-To: ". $email . PHP_EOL;
$headers .= "MIME-Version: 1.0" . PHP_EOL;
$headers .= "Content-Type: text/html; charset=ISO-8859-1" . PHP_EOL;

if(mail($to, $subject, $message, $headers))
echo "successfully sent email out!";
else
echo "failed to send email out";
*/

ini_set("sendmail_from", "do-not-reply@gmail.com");

ini_set('SMTP', 'gmail-smtp-in.l.google.com');

if(mail('chunxia.bai@engr.uconn.edu', 'test mail in uwsn server', 'hello', "FROM: no-reply@gmail.com"))
echo "successfully sent email out!";
else
echo "failed to send email out";

$today = getdate(time());
print_r($today['mon'].'/'.$today['mday'].'/'.$today['year'].' '.$today['hours'].':'.$today['minutes'].":".$today['seconds']);
?>
<body>
</body>
</html>
