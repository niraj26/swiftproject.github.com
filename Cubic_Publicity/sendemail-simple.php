<?php
//define the receiver of the email
$to = 'dyuri.sadaria@gmail.com';
//define the subject of the email
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
	}
}

//create a boundary string. It must be unique
//so we use the MD5 algorithm to generate a random hash
$random_hash = md5(date('r', time()));
//define the headers we want passed. Note that they are separated with \r\n
$headers = "From: " . $email . "\r\nReply-To: " . $email;
//add boundary string and mime type specification
$headers .= "\r\nContent-Type: multipart/mixed; boundary=\"PHP-mixed-".$random_hash."\"";
//read the atachment file contents into a string,
//encode it with MIME base64,
//and split it into smaller chunks
if($attach_file != "") {
	$attachment = chunk_split(base64_encode(file_get_contents("upload/" . $_FILES["attach_file"]["name"])));
}
//define the body of the message.
ob_start(); //Turn on output buffering
?>
--PHP-mixed-<?php echo $random_hash; ?> 
Content-Type: multipart/alternative; boundary="PHP-alt-<?php echo $random_hash; ?>"

--PHP-alt-<?php echo $random_hash; ?> 
Content-Type: text/html; charset="iso-8859-1"
Content-Transfer-Encoding: 7bit

<p><?php echo $my_message; ?></p>;

--PHP-alt-<?php echo $random_hash; ?>--

<?php if($attach_file != "") { ?>
    --PHP-mixed-<?php echo $random_hash; ?> 
    Content-Type: application/zip; name="<?php echo $attach_file; ?>" 
    Content-Transfer-Encoding: base64 
    Content-Disposition: attachment 
    
    <?php echo $attachment; ?>
    --PHP-mixed-<?php echo $random_hash; ?>--
<?php } ?>

<?php
//copy current buffer contents into $message variable and delete current output buffer
$message = ob_get_clean();
//send the email
$mail_sent = @mail( $to, $subject, $message, $headers );
//if the message is sent successfully print "Mail sent". Otherwise print "Mail failed"
echo $mail_sent ? "Mail sent" : "Mail failed";
?>