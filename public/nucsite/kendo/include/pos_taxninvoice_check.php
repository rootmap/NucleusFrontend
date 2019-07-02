<?php 
$obj_pos->tax_check($cart);

$chk_invoice_cart=$obj->exists_multiple($table3,array("invoice_id" =>$cart));
if($chk_invoice_cart==0)
{
	$obj->insert($table3,array("invoice_id" =>$cart,"invoice_creator"=>$input_by,"invoice_date"=>date('d-m-Y'),"date"=>date('Y-m-d'),"status"=>1,"doc_type"=>3,"access_id"=>$access_id,"input_by"=>$input_by));
	$obj->Success("New Sales ID Generated.","pos_redirect.php");
}

?>