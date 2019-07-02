<?php
include('../class/auth.php');
extract($_GET);
$table="sales";
$success="<label class='label label-success'>Item Has Been Added to Cart</label>";
$updated="<label class='label label-success'>Shopping Cart Updated</label>";
$error="<label class='label label-danger'>Please Contact to Your System Provider</label>";
if($sales_id!='')
{

	$sqlsaleslist=$obj->SelectAllByID($table,array("sales_id"=>$sales_id));
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
    <?php 
	$sqlbuyback=$obj->exists_multiple("buyback",array("pos_id"=>$sales_id));
	if($sqlbuyback==0)
	{
		$tradein=0;
	}
	else
	{
	?>
	<tr>
		<th>Buyback: </th>
		<th><?php
			$tradein=$obj->SelectAllByVal("buyback","pos_id",$sales_id,"price");
			echo number_format($tradein,2);
			?></th>
	</tr>
	<?php
		
	 } 
	 ?>
    <tr>
        <th>Total: </th>
        <th><?php $total=($subtotal+$tax)-$tradein; echo number_format($total,2); ?></th>
    </tr>
    <?php

}
else
{
	echo $error;	
}
?>