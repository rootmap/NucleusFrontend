<?php 
	if($cashiers_id!=0)
	{
		$chkopenstore=$obj->exists_multiple("store_open",array("sid"=>$input_by,"status"=>1)); 
		if($chkopenstore!=0)
		{
			$track_id=time(); 
			$obj->insert("payout",array("uid"=>$input_by,"track_id"=>$track_id,"cashier_id"=>$cashiers_id,"amount"=>$_POST['cash'],"date"=>date('Y-m-d'),"datetime"=>date('Y-m-d H:i'),"reason"=>$_POST['reason'],"input_by"=>$input_by,"access_id"=>$access_id,"status"=>1));
			$obj->insert("transaction_log",array("transaction"=>$_SESSION['SESS_CART'],"track_id"=>$track_id,"sid"=>$input_by,"cashier_id"=>$cashiers_id,"date"=>date('Y-m-d'),"time"=>date('H:i:s'),"input_by"=>$input_by,"access_id"=>$access_id,"amount"=>$_POST['cash'],"type"=>5,"tender"=>3,"status"=>1));
			$obj->Success("Payout Amount Saved",$obj->filename());	
		}
		else
		{
			$obj->Error("Store Is Not Open, To Made Any Transaction Please Open Store", $obj->filename());
		}
	}
	else
	{
		$obj->Error("Cashier Not Logged IN. PLease Login As A Cashier", $obj->filename());
	}
?>