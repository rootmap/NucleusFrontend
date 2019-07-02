<?php
include('../class/auth.php');
extract($_GET);
$table="invoice_detail";
$success="<label class='label label-success'>Item Has Been Added to Cart</label>";
$updated="<label class='label label-success'>Shopping Cart Updated</label>";
$error="<label class='label label-danger'>Wrong Barcode Number</label>";
if($barcode!='')
{
	$jid=$obj->SelectAllByVal("product","barcode",$barcode,"id");
	if($jid!='')
	{
		$pid=$jid;
		$exproduct=$obj->exists_multiple($table,array("uid"=>$input_by,"invoice_id"=>$sales_id,"pid"=>$pid));
		if($exproduct==0)
		{
			$single_cost=$obj->SelectAllByVal("product","id",$pid,"price_retail");
			$quantity='1';
			$totalcost=$quantity*$single_cost;
			if($obj->insert($table,array("uid"=>$input_by,
			"invoice_id"=>$sales_id,
			"pid"=>$pid,
			"quantity"=>$quantity,
			"single_cost"=>$single_cost,
			"totalcost"=>$totalcost,
			"input_by"=>$input_by,
			"date"=>date('Y-m-d'),
			"status"=>1))==1)
			{
				echo $success;
			}
			else
			{
				echo $error;	
			}
		}
		else
		{
			$sales_pro_id=$obj->SelectAllByVal3($table,"uid",$input_by,"invoice_id",$sales_id,"pid",$pid,"id");
			$sales_pro_quantity=$obj->SelectAllByVal3($table,"uid",$input_by,"invoice_id",$sales_id,"pid",$pid,"quantity");
			$sales_pro_cost=$obj->SelectAllByVal3($table,"uid",$input_by,"invoice_id",$sales_id,"pid",$pid,"single_cost");
			
			$quantity='1';
			
			$totalquantity=$sales_pro_quantity+$quantity;
			$totalcost=$totalquantity*$sales_pro_cost;
			
			if($obj->update($table,array("id"=>$sales_pro_id,
			"uid"=>$input_by,
			"invoice_id"=>$sales_id,
			"pid"=>$pid,
			"quantity"=>$totalquantity,
			"single_cost"=>$sales_pro_cost,
			"input_by"=>$input_by,
			"totalcost"=>$totalcost))==1)
			{
				echo $updated;
			}
			else
			{
				echo $error;	
			}
		}
	}
	else
	{
		echo $error;
	}
}
else
{
	echo $error;	
}
?>