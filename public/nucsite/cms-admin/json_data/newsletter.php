<?php

$input_datetime = date('Y-m-d');
include('../class/db_Class.php');
$obj = new db_class();
extract($_POST);

include('./email/mail_helper_functions.php');
$EmailSubject = 'BdNewsRobot Update News';
$EmailBody = file_get_contents($obj->baseUrl('json_data/newsletter_template.php'));

//echo $EmailBody;
//
//exit();
$sqluser = $obj->FlyQuery("SELECT `email` FROM `newsletter` WHERE `email` REGEXP '^[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$'");
if (!empty($sqluser)) {
    $emails = array();
    foreach ($sqluser as $user):
        $emails[] = $user->email;
    endforeach;

    if (RoorMapMailer($emails, $EmailSubject, $EmailBody)) {
        ?>
        <script>
        alert('Newsletter Successfully Send');
        window.location.href="../index.php";
        </script>
        <?php
    } else {
        ?>
        <script>
        var c=confirm('Failed To Send Newsletter, do you want to reload page.');
        if(c)
        {
            window.location.reload();
        }
        else
        {
            window.location.href="../index.php";
        }
        </script>
        <?php
    }

    //print_r($emails);
}

//bot engine
?>