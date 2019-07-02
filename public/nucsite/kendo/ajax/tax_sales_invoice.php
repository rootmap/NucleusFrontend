<?php
include('../class/auth.php');
extract($_GET);
$table="invoice_detail";
$success="<label class='label label-success'>Item Has Been Added to Cart</label>";
$updated="<label class='label label-success'>Shopping Cart Updated</label>";
$error="<label class='label label-danger'>Please Contact to Your System Provider</label>";
if($q!='')
{
		if($obj->update($table,array("id"=>$pid,"tax"=>$tax))==1)
		{
			echo $updated;
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