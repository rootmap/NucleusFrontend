<?php 
$obj->newcart(@$_SESSION['SESS_CART']);	
$obj->insert($table3, array("invoice_id"=>$_SESSION['SESS_CART'],"invoice_creator"=>$input_by,"invoice_date" => date('d-m-Y'),"date"=>date('Y-m-d'),"status"=>0,"doc_type" =>3,"access_id"=>$access_id,"input_by"=>$input_by));

?>