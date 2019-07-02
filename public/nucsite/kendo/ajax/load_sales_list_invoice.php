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
	$sss=1;
	$tax=0;
	$subtotal=0;
	if(!empty($sqlsaleslist))
	foreach($sqlsaleslist as $saleslist):
		$caltax=($saleslist->single_cost*$tax_per_product)/100;
		$tax_status=$saleslist->tax;
		
		$procost=$saleslist->quantity*$saleslist->single_cost;
		$subtotal+=$procost;
		
		if($tax_status==0)
		{
			$tax+=0;
			$taxst="No";	
			$taxstn="1";
			$extended=$procost;
		}
		else
		{
			$tax+=$caltax*$saleslist->quantity;
			$taxst="Yes";
			$taxstn="0";
			$extended=$procost+$caltax;
		}
	?>
	<tr>
		<td><?php echo $sss; ?></td>
		<td><?php echo $obj->SelectAllByVal("product","id",$saleslist->pid,"name"); ?></td>
		<td><?php echo $obj->SelectAllByVal("product","id",$saleslist->pid,"name"); ?></td>
		<td><?php echo $saleslist->quantity; ?></td>
		<td><button type="button" class="btn">$<?php echo $saleslist->single_cost; ?></button></td>
        <?php 
		$cid=$obj->SelectAllByVal("invoice","invoice_id",$sales_id,"cid");
		?>
		<td><?php echo $obj->invoice_edit_row($table,"id",$saleslist->id,"tax","tax_invoice".$saleslist->id,$cid); ?></td>
        <td><button type="button" class="btn">$<?php echo $extended; ?></button></td>
		<td><button type="button" name="trash" onClick="delete_sales('<?php echo $saleslist->pid; ?>',<?php echo $sales_id; ?>)"><i class="icon-trash"></i></button></td>
	</tr>
	<?php 
	$sss++;
	endforeach;

}
else
{
	echo $error;	
}
?>