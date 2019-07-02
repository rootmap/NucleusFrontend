<?php 
if($obj->delete("sales",array("sales_id"=>$_GET['sales_id']))==1)
{
	$obj->delete("pos_checkin",array("invoice_id"=>$_GET['sales_id']));
	$obj->Success("Sales Product Deleted","pos_redirect.php");
} else {
	$obj->Success("Failed","pos_redirect.php");
}
?>