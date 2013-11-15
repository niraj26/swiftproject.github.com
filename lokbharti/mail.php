<?

// ---------------- SEND MAIL FORM ----------------

// send e-mail to ...
$to="gbtc@lokbharti.org";

// Your subject
$subject="Feedback";

// From
$name = $_POST['name'];
$email = $_POST['email'];
$from_email = "$name" . " " . "$email";

$header="from: $from_email";

// Your message
$message= $_POST['comments'];

// send email
$sentmail = mail($to,$subject,$message,$header);

// if your email succesfully sent
if($sentmail){
	header("location: msg_sent.html");
}
else {
	header("location: msg_not_sent.html");
}

?>