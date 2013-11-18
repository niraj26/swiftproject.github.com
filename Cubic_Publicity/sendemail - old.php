<?php

// send e-mail to ...
$to="info@cubicpublicity.com";

// Your subject
$subject="Website Inquiry : " . $_POST['subject'];

// From
$name = $_POST['full_name'];
$email = $_POST['email'];

// Your message
$my_message= $_POST['message'];

// Your Attachment
$attach_file =  $_FILES["attach_file"]["tmp_name"];

if($attach_file != "") {
	if($_FILES["attach_file"]["size"] < 1000000) {
		move_uploaded_file($_FILES["attach_file"]["tmp_name"], "upload/" . $_FILES["attach_file"]["name"]);
		//unlink("upload/" . $_FILES["attach_file"]["name"]);
	}
}

require_once('class.phpmailer.php');
include("class.smtp.php");
		
//$to = $_POST['email'];

$mail = new PHPMailer();

$mail->IsSMTP();
$mail->SMTPAuth   = true; 
$mail->SMTPSecure = "http";                 
// $mail->SMTPSecure = "ssl";                 
$mail->Host       = "smtpout.europe.secureserver.net";   
$mail->Port       = 80;                   
$mail->Username   = "info@cubicpublicity.com";
$mail->Password   = "Cube@0129";

$mail->SetFrom("$email", "$name");

$mail->AddReplyTo('info@cubicpublicity.com', 'Cubic Publicity');

$mail->Subject    = "$subject";

if($_FILES["attach_file"]["name"] != "") {
	$mail->AddAttachment("upload/" . $_FILES["attach_file"]["name"]);
}

$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; 
		
$message = "<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />

</head>

<body style='font-family:Tahoma, Arial, Helvetica, verdana;'>

<p>" . $my_message . "</p>";

$message .= "</body>
</html>
	";
	
$mail->MsgHTML($message);

//$email_address = "pranav.ec@gmail.com";
//$mail->AddAddress($email_address);

$mail->AddAddress($to);
		
if(!$mail->Send()) {
	if($_FILES["attach_file"]["name"] != "") {
		unlink("upload/" . $_FILES["attach_file"]["name"]);
	}
  	header("location:contact-fail.html");
} else {
	if($_FILES["attach_file"]["name"] != "") {
		unlink("upload/" . $_FILES["attach_file"]["name"]);
	}
  	header("location:contact-success.html");
}

//$sendmail = $mail->Send();
//echo $sendmail;

?>