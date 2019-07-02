<?php

/**
 * This function used to send emails using PHP Mailer Class<br>
 * @input: $UserEmail, $UserName, $ReplyToEmail, $EmailSubject, $EmailBody; return true/$status(if error)
 * used for signup.php
 */
function SinglesendEmailFunction($UserEmail='', $UserName='', $ReplyToEmail='', $EmailSubject='', $EmailBody='') {

    global $config;
    $status='';

    if ($UserEmail == '' OR $UserName == '' OR $EmailSubject == '' OR $EmailBody == '') {
        $status="Parameters missing.";
    }else {
        require_once("class.phpmailer.php");
        $mail=new PHPMailer();
        $mail->Host="bh-13.webhostbox.net";
        $mail->Port="465";
        $mail->SMTPSecure='ssl';
        $mail->IsSMTP(); // send via SMTP
        $mail->SMTPDebug=0;
        //IsSMTP(); // send via SMTP
        $mail->SMTPAuth=true; // turn on SMTP authentication
        $mail->Username="test@skeletonit.com"; // Enter your SMTP username
        $mail->Password="123456"; // SMTP password
        $webmaster_email="test@skeletonit.com"; //Add reply-to email address
        $email=$UserEmail; // Add recipients email address
        $name=$UserName; // Add Your Recipient's name
        $mail->From="test@skeletonit.com";
        $mail->FromName="BdNewsRobot";
        $mail->AddAddress($email, $name);
        $mail->AddReplyTo("test@skeletonit.com", "BdNewsRobot");
        //$mail->extension=php_openssl.dll;
        $mail->WordWrap=50; // set word wrap
        // $mail->AddAttachment("/var/tmp/file.tar.gz"); // attachment
        // $mail->AddAttachment("/tmp/image.jpg", "new.jpg"); // attachment
        $mail->IsHTML(true); // send as HTML
        $mail->Subject=$EmailSubject;
        $mail->Body=$EmailBody;
        $mail->AltBody=$mail->Body;

        if (!$mail->Send()) {

            $status="Email sending failed.";
        }else {
            $status='';
        }
    }

    if ($status == '') {
        return true;
    }else {
        return $status;
    }
}

function RoorMapMailer($emaillist,$EmailSubject='',$EmailBody='') {

    global $config;
    $status='';

    if ($EmailSubject == '' OR $EmailBody == '') {
        $status="Parameters missing.";
    }else {
        require_once("class.phpmailer.php");
        $mail=new PHPMailer();
 	$mail->Host="bh-13.webhostbox.net";
        $mail->Port="465";
        $mail->SMTPSecure='ssl';
        $mail->IsSMTP(); // send via SMTP
        $mail->SMTPDebug=0;
        //IsSMTP(); // send via SMTP
        $mail->SMTPAuth=true; // turn on SMTP authentication
        $mail->Username="test@skeletonit.com"; // Enter your SMTP username
        $mail->Password="123456"; // SMTP password
        $webmaster_email="test@skeletonit.com"; //Add reply-to email address
        //$email=$UserEmail; // Add recipients email address
        //$name=$UserName; // Add Your Recipient's name
        $mail->From="test@skeletonit.com";
        $mail->FromName="BdNewsRobot";
		foreach($emaillist as $em):
        	$mail->AddAddress($em);
		endforeach;
        $mail->AddReplyTo("test@skeletonit.com", "BdNewsRobot");
        //$mail->extension=php_openssl.dll;
        $mail->WordWrap=50; // set word wrap
        // $mail->AddAttachment("/var/tmp/file.tar.gz"); // attachment
        // $mail->AddAttachment("/tmp/image.jpg", "new.jpg"); // attachment
        $mail->IsHTML(true); // send as HTML
        $mail->Subject=$EmailSubject;
        $mail->Body=$EmailBody;
        $mail->AltBody=$mail->Body;

        if (!$mail->Send()) {

            $status="Email sending failed.";
        }else {
            $status='';
        }
    }

    if ($status == '') {
        return true;
    }else {
        return $status;
    }
}
?>