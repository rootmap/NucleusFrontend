<?php
include('../class/auth.php');
extract($_GET);
$table="invoice_detail";
$success="<label class='label label-success'>Item Has Been Added to Cart</label>";
$updated="<label class='label label-success'>Shopping Cart Updated</label>";
$error="<label class='label label-danger'>Please Contact to Your System Provider</label>";
if($sales_id!='')
{

	$sqlsaleslist=$obj->SelectAllByID($table,array("invoice_id"=>$sales_id));
	$subtotal=0;
	$tax=0;
	if(!empty($sqlsaleslist))
	foreach($sqlsaleslist as $saleslist):
	$caltax=($saleslist->single_cost*$tax_per_product)/100;
	$tax+=$caltax*$saleslist->quantity;
	$procost=$saleslist->quantity*$saleslist->single_cost;
	$subtotal+=$procost;
	endforeach;
	?>
     <tr>
        <th>Sub - Total: </th>
        <th><?php echo number_format($subtotal,2); ?></th>
    </tr>
    <tr>
        <th>Tax: </th>
        <th><?php echo number_format($tax,2); ?></th>
    </tr>
    <tr>
        <th>Total: </th>
        <th><?php $total=$subtotal+$tax; echo number_format($total,2); ?></th>
    </tr>
    <tr>
        <th>Payments: </th>
        <th>0.00</th>
    </tr>
    <tr>
        <th>Balance Due: </th>
        <th>0.00</th>
    </tr>
    <?php

}
else
{
	echo $error;	
}
?>