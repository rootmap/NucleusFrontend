<?php
include('../class/auth.php');
extract($_GET);
$table="sales";
$success="<label class='label label-warning'>Item Has Been Deleted From Cart</label>";
$updated="<label class='label label-success'>Shopping Cart Updated</label>";
$error="<label class='label label-danger'>Please Contact to Your System Provider</label>";
if($pid!='')
{
	$exproduct=$obj->exists_multiple($table,array("uid"=>$input_by,"sales_id"=>$sales_id,"pid"=>$pid));
	if($exproduct==0)
	{
		echo $error;
	}
	else
	{
		$pro_sales_id=$obj->SelectAllByVal3($table,"uid",$input_by,"sales_id",$sales_id,"pid",$pid,"id");
		if($obj->delete($table,array("id"=>$pro_sales_id))==1)
		{
			echo $success;
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
?>