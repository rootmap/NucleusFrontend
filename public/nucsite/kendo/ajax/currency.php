<?php

include('../class/auth.php');
extract($_POST);
//echo $cid;
$currency = $cid;
$obj->update("store_currency", array("`store_id`" => $input_by, "`status`" => 0));
$obj->update("store_currency", array("id" => $currency, "status" => 1));
echo 1;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

