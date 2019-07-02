<?php 
	$chk=$obj->exists_multiple("store_open",array("sid" =>$input_by,"status"=>1));
	if($chk==0)
	{
		$obj->insert("store_open",array("sid"=>$input_by,"opening_cash"=>$_POST['cash'],"opening_sqaure"=>$_POST['square'],"date"=>date('Y-m-d'),"datetime"=>date('Y-m-d H:i'),"access_id"=>$access_id,"status"=>1));
		
		if(!empty($_POST['cash']))
		{
			$tender="Store Open";
			$amount=$_POST['cash'];	
		}
		elseif(!empty($_POST['square']))
		{
			$tender="Store Open";
			$amount=$_POST['square'];
		}
		else
		{
			$tender=0;	
			$amount=0;
		}
		$obj->insert("transaction_log",array("transaction"=>$_SESSION['SESS_CART'],"sid"=>$input_by,"cashier_id"=>$cashiers_id,"date"=>date('Y-m-d'),"input_by"=>$input_by,"access_id"=>$access_id,"time"=>date('H:i:s'),"amount"=>$amount,"type"=>1,"tender"=>3,"status"=>1));
		$obj->Success("Store Open Successfully",$obj->filename());		
	}
	else
	{
		$id=$obj->SelectAllByVal2("store_open","sid",$input_by,"status",1,"id");	
		$obj->update("store_open",array("id"=>$id,"status"=>2));
		$obj->Success("Store Closed Successfully",$obj->filename());	
	}
?>