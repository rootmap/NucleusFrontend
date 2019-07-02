<?php 
		extract($_POST);
		$obj->insert("transaction_log",array("transaction"=>$_SESSION['SESS_CART'],"sid"=>$input_by,"cashier_id"=>$cashiers_id,"date"=>date('Y-m-d'),"time"=>date('H:i:s'),"input_by"=>$input_by,"access_id"=>$access_id,"amount"=>"-".$_POST['totalcl'],"type"=>7,"tender"=>3,"status"=>1));
		$id=$obj->SelectAllByVal2("store_open","sid",$input_by,"status",1,"id");	
		$obj->update("store_open",array("id"=>$id,"status"=>2));
		
		//
		//closeing store data
		$stid=$obj->SelectAllByVal("cashier_list","id",$cashiers_id,"store_id");
		$obj->insert("close_store_detail",array("store_id"=>$stid,"cashier_id"=>$cashiers_id,"total_collection_cash_credit_card"=>$total_collection_cash_credit_card,"cash_collected_plus"=>$cash_collected_plus,"credit_card_collected_plus"=>$credit_card_collected_plus,"opening_cash_plus"=>$opening_cash_plus,"opening_credit_card_plus"=>$opening_credit_card_plus,"payout_plus_min"=>$payout_plus_min,"buyback_min"=>$buyback_min,"tax_min"=>$tax_min,"current_cash"=>$current_cash,"current_credit_card"=>$current_credit_card,"current_total"=>$_POST['totalcl'],"access_id"=>$access_id,"date"=>date('Y-m-d'),"status"=>1));
		//$obj->insert("close_store_detail",array("date"=>date('Y-m-d'),"status"=>1));
		//closeing store data	
		$obj->Success("Store Closed Successfully",$obj->filename());
?>