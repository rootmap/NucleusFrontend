<?php
date_default_timezone_set('UTC');
//define the receiver of the email
$to = 'f.bhuyian@gmail.com';
//define the subject of the email
$subject = 'Backup Nucleus POS';
//create a boundary string. It must be unique
//so we use the MD5 algorithm to generate a random hash
$random_hash = md5(date('r', time()));
//define the headers we want passed. Note that they are separated with \r\n
$headers = "From: backup@neutrix.systems\r\nReply-To: contact@neutrix.systems";
//add boundary string and mime type specification
$headers .= "\r\nContent-Type: multipart/mixed; boundary=\"PHP-mixed-".$random_hash."\"";
//read the atachment file contents into a string,
//encode it with MIME base64,
//and split it into smaller chunks
$attachment = chunk_split(base64_encode(file_get_contents('backup_Fri_04_09_2015.sql.gz')));

$header .= "Content-Type: application/octet-stream; name=\"backup_Fri_04_09_2015.sql.gz\"\r\n"; // use different content types here
$header .= "Content-Transfer-Encoding: base64\r\n";
$header .= "Content-Disposition: attachment; filename=\"".$attachment."\"\r\n\r\n";

//define the body of the message.
ob_start(); //Turn on output buffering
//copy current buffer contents into $message variable and delete current output buffer
$message = ob_get_clean();
//send the email
$mail_sent = @mail( $to, $subject, $message, $headers );
//if the message is sent successfully print "Mail sent". Otherwise print "Mail failed"
echo $mail_sent ? "Mail sent" : "Mail failed";
?> 