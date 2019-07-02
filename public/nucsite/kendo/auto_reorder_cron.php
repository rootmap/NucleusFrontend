<?php

session_start();
date_default_timezone_set('America/Los_Angeles');
include('./class/db_Class.php');
$obj=new db_class();

@session_regenerate_id();
$session_id=session_id();

$sqlst="INSERT INTO reorder_user (rid,store_id,date)
SELECT '" . $session_id . "' as rid,store_id,CURDATE() as date FROM `shop_admin` WHERE store_id NOT IN (SELECT store_id FROM reorder_user WHERE date=CURDATE()) LIMIT 1";
$obj->FlyPrepare($sqlst);

$sqlcurstore=$obj->FlyQuery("SELECT a.rid,a.store_id,sa.name,sa.email FROM reorder_user as a
LEFT JOIN shop_admin as sa on sa.store_id=a.store_id WHERE rid='" . $session_id . "'");
if (!empty($sqlcurstore)) {
    $countrecord=count($sqlcurstore);
    if ($countrecord != 0) {

        $sqlproduct=$obj->FlyQuery("SELECT a.id,
        p.id as pid,
        p.name,
        p.store_id,
        p.barcode,
        p.price_cost,
        p.price_retail,
        p.input_by,
        a.stock FROM `reorder` as a
        LEFT JOIN product as p on p.id=a.pid WHERE p.input_by='" . $sqlcurstore[0]->store_id . "'");
        $chkcurstore=$obj->FlyQuery("reorder_user");
        if (count($sqlproduct) != 0) {
            include './email/mail_helper_functions.php';
            $EmailSubject="Inventory Re-Order Reminder details For " . $sqlcurstore[0]->name . "  From NucleusPos";
            $EmailBody=file_get_contents($obj->baseUrl('email/email/body/reorder.php?session_id=' . $session_id));
            if ($sendMailStatus=sendEmailFunction($sqlcurstore[0]->email, $sqlcurstore[0]->name, 'reorder@nucleuspos.com', $EmailSubject, $EmailBody) == true) {
                echo "Success";
            }
        }
    }else {
        echo "No Record Found.";
    }
}
?>
