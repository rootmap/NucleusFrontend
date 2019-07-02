<?php
date_default_timezone_set('UTC');
include('class/mysql_backup_import.php');
$dir  = dirname(__file__); // directory files
$name = 'backup_'.date('D_d_m_Y'); // name sql backup
//backup_database( $dir, $name, 'localhost', 'root', '', 'pos_multi'); // execute
//backup_database( $dir, $name, 'localhost', 'wirelev6_dz', 'l9c!KExO+A5x', 'wirelev6_dz'); // execute
backup_database( $dir, $name, 'localhost', 'nucleusp_pos', '8vxs~(o(1Q{+', 'nucleusp_pos'); // execute
//$con = mysqli_connect("localhost", "nucleusp_pos", "8vxs~(o(1Q{+", "nucleusp_pos");

$zipfilename=$name.".sql.gz";
$my_file =$zipfilename;
$my_path = dirname(__file__)."/";
$my_name = "Backup System";
$my_mail = "backup@nucleuspos.com";
$my_replyto = "contact@neutrix.systems";
$my_subject = "Nucleus POS System Full DB Backup Until ".date('m/d/Y');
$my_message = "Hallo Sir,\r\nYour Nucleus POS Backup Syetem,  Has been taken Backup - date : ".date('m/d/Y')." and time : ".date('H:i:s').".\r\n\r\n";


$file_to_attach = $my_path."/".$my_file;
include("./phpmail/class.phpmailer.php");
$email = new PHPMailer();
$email->From      = 'backup@nucleuspos.com';
$email->FromName  = 'NucleusPOS Backup';
$email->Subject   = $my_subject;
$email->Body      = $my_message;
$email->AddAddress('justindabish@gmail.com');
$email->AddAttachment($file_to_attach,$my_file);
if($email->Send()==1){ echo "Mail Sent."; }
else{ echo "Mail Sent Fail. "; }


$email_backup = new PHPMailer();
$email_backup->From      = 'backup@nucleuspos.com';
$email_backup->FromName  = 'NucleusPOS Backup';
$email_backup->Subject   = $my_subject;
$email_backup->Body      = $my_message;
$email_backup->AddAddress('f.bhuyian@gmail.com');
$email_backup->AddAttachment($file_to_attach,$my_file);
if($email_backup->Send()==1){ echo "Mail Sent."; }
else{ echo "Mail Sent Fail. "; }




//echo mail_attachment($my_file, $my_path, "justindabish@gmail.com", $my_mail, $my_name, $my_replyto, $my_subject, $my_message);
//echo mail_attachment($my_file, $my_path, "f.bhuyian@gmail.com", $my_mail, $my_name, $my_replyto, $my_subject, $my_message);
?>