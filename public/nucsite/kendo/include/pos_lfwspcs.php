<?php 
	extract($_GET);
	$obj->insert("transaction_log",array("transaction"=>$_SESSION['SESS_CART'],"sid"=>$input_by,"cashier_id"=>$cashiers_id,"date"=>date('Y-m-d'),"time"=>date('H:i:s'),"input_by"=>$input_by,"access_id"=>$access_id,"amount"=>"-".$_GET['lfwspcs'],"type"=>7,"tender"=>3,"status"=>1));
	$id=$obj->SelectAllByVal2("store_open","sid",$input_by,"status",1,"id");	
	$obj->update("store_open",array("id"=>$id,"status"=>2));
	$obj_pos->cashier_logout_without_return(@$_SESSION['SESS_CASHIER_ID']);
	header("location:logout.php");	
?>