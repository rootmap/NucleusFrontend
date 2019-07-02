<?php
include('class/auth.php');
extract($_GET);
//echo $cart_id;
$chk=$obj->exists_multiple("invoice",array("invoice_id"=>$cart_id,"status"=>3));
if($chk!=0)
{
	unset($_SESSION['SESS_CART']);
	$_SESSION['SESS_CART']=$cart_id;
	$obj->Success("Invoice Re-Loaded To POS.","pos.php");
}
else
{
	$obj->Error("No Due Record Found, Related This Invoice.","sales_list.php");	
}
?>