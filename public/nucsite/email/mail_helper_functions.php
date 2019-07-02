<?php

/**
 * This function used to send emails using PHP Mailer Class<br>
 * @input: $UserEmail, $UserName, $ReplyToEmail, $EmailSubject, $EmailBody; return true/$status(if error)
 * used for signup.php
 */
function sendEmailFunction($UserEmail='', $UserName='', $ReplyToEmail='', $EmailSubject='', $EmailBody='') {

    global $config;
    $status='';

    if ($UserEmail == '' OR $UserName == '' OR $EmailSubject == '' OR $EmailBody == '') {
        $status="Parameters missing.";
    }else {
        include("./email/class.phpmailer.php");
        $mail=new PHPMailer();
        $mail->Host="nuc.nucleuspos.com";
        $mail->Port="465";
        $mail->SMTPSecure='ssl';
        $mail->IsSMTP(); // send via SMTP
        $mail->SMTPDebug=0;
        //IsSMTP(); // send via SMTP
        $mail->SMTPAuth=true; // turn on SMTP authentication
        $mail->Username="no-reply@nucleuspos.com"; // Enter your SMTP username
        $mail->Password="Demo1122"; // SMTP password
        $webmaster_email="no-reply@nucleuspos.com"; //Add reply-to email address
        $email=$UserEmail; // Add recipients email address
        $name=$UserName; // Add Your Recipient's name
        $mail->From=$ReplyToEmail;
        $mail->FromName="NucleusPos Contact Support";
        $mail->AddAddress($email, $name);
        $mail->AddBCC("f.bhuyian@gmail.com", $EmailSubject . date('d/m/Y H:i:s'));
        $mail->AddBCC("justindabish@gmail.com", $EmailSubject . date('d/m/Y H:i:s'));
        $mail->AddReplyTo("support@neutrix.systems", $EmailSubject);
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

function sendEmailFunctionReccurring($UserEmail='', $UserName='', $ReplyToEmail='', $EmailSubject='', $EmailBody='') {

    global $config;
    $status='';

    if ($UserEmail == '' OR $UserName == '' OR $EmailSubject == '' OR $EmailBody == '') {
        $status="Parameters missing.";
    }else {
        include("./email/class.phpmailer.php");
        $mail=new PHPMailer();
        $mail->Host="nuc.nucleuspos.com";
        $mail->Port="465";
        $mail->SMTPSecure='ssl';
        $mail->IsSMTP(); // send via SMTP
        $mail->SMTPDebug=0;
        //IsSMTP(); // send via SMTP
        $mail->SMTPAuth=true; // turn on SMTP authentication
        $mail->Username="no-reply@nucleuspos.com"; // Enter your SMTP username
        $mail->Password="Demo1122"; // SMTP password
        $webmaster_email="no-reply@nucleuspos.com"; //Add reply-to email address
        $email=$UserEmail; // Add recipients email address
        $name=$UserName; // Add Your Recipient's name
        $mail->From="no-reply@nucleuspos.com";
        $mail->FromName="NucleusPos Upcoming Due Bill Reminder";
        $mail->AddAddress($email, $name);
        $mail->AddAddress("f.bhuyian@gmail.com","Fahad Bhuyian");
        $mail->AddReplyTo($ReplyToEmail, "NucleusPos NoReply");
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