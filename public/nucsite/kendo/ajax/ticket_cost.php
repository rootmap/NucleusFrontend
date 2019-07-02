<?php
include('../class/auth.php');
extract($_GET);
if($st==1)
{
	echo $obj->SelectAllByVal("ticket","ticket_id",$tid,"our_cost");	
}
elseif($st==2)
{
	echo $obj->SelectAllByVal("ticket","ticket_id",$tid,"retail_cost");		
}
elseif($st==3)
{
	if($obj->SelectAllByVal("ticket","ticket_id",$tid,"payment")==3)
	{
		echo $obj->ticket_payment_status($obj->SelectAllByVal("ticket","ticket_id",$tid,"payment"))." - Amount Paid : $".$obj->SelectAllByVal("ticket","ticket_id",$tid,"partial_amount");
	}
	else
	{
		echo $obj->ticket_payment_status($obj->SelectAllByVal("ticket","ticket_id",$tid,"payment"));
	}
}
?>