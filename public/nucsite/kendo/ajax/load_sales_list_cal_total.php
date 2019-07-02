<?php
include('../class/auth.php');
extract($_GET);
$table="sales";
$success="<label class='label label-success'>Item Has Been Added to Cart</label>";
$updated="<label class='label label-success'>Shopping Cart Updated</label>";
$error="<label class='label label-danger'>Please Select A Customer Before Payment</label>";
	
	/*if($obj->exists_multiple("pos_tax",array("invoice_id"=>$sales_id,"status"=>2))==0)
	{
		$tax_per_product_new=$tax_per_product;
		
	}
	else
	{
		$tax_per_product_new=0;
	}*/
		
	$taxst = $obj->SelectAllByVal("pos_tax","invoice_id",$sales_id,"status");
	
	$sqlsaleslist=$obj->SelectAllByID($table,array("sales_id"=>$sales_id));
	$subtotal=0;
	$tax=0;
	if(!empty($sqlsaleslist))
	foreach($sqlsaleslist as $saleslist):
	//$caltax=($saleslist->single_cost*$tax_per_product_new)/100;
	if ($taxst == 1) {
		$tax_charge = $tax_per_product;
	}
	elseif ($taxst == 2) {
		$tax_charge = $tax_per_product;
	} 
	else {
		$tax_charge = 0;
	}
	$tax_charge = $tax_per_product;
	
	if($taxst == 2) 
	{
		 $pid=$saleslist->pid;
		 $store_cost=$obj->SelectAllByVal("product","id",$pid,"price_cost");	
		 $caltax = ($store_cost * $tax_charge) / 100;
	} 
	else
	{
		 $caltax = ($saleslist->single_cost * $tax_charge) / 100;
	}
	$tax+=$caltax*$saleslist->quantity;
	$procost=$saleslist->quantity*$saleslist->single_cost;
	$subtotal+=$procost;
	endforeach;
	if ($taxst == 1) {
		$taa = $tax;
	}elseif ($taxst == 2) {
		$taa = $tax;	
	} else {
		$taa = 0;
	}
	
	$sqlbuyback=$obj->exists_multiple("buyback",array("pos_id"=>$sales_id));
	if($sqlbuyback==0)
	{
		$tradein=0;
	}
	else
	{
		$tradein=$obj->SelectAllByVal("buyback","pos_id",$sales_id,"price");
	} 
	
	$total=($subtotal+$taa)-$tradein; 
	//echo number_format($total,2); 
	$cid=$obj->SelectAllByVal("invoice","invoice_id",$sales_id,"cid");
	if($cid==0){ echo $error; }else{
		
		$paid=0;
		$sqlpp=$obj->SelectAllByID_Multiple("invoice_payment",array("invoice_id"=>$sales_id));
		if(!empty($sqlpp))
		{
			foreach($sqlpp as $pp):
				$paid+=$pp->amount;
			endforeach;	
		}
		else
		{
			$paid+=0;
		}
		
		$due=$total-$paid;
		
		$obj->update("invoice",array("invoice_id"=>$sales_id,"payment_type"=>$dd));
?>
<div class="control-group">
    <label class="span4"> Total Amount</label>
    <div class="span8">
	<input readonly="readonly" value="<?php echo number_format($due,2); ?>" type="text" name="totam" id="totam" placeholder="Total Amount..." />
    <input value="<?php echo $sales_id; ?>" type="hidden" name="sidd" />
    <input value="<?php echo $cid; ?>" type="hidden" name="cid" />
    <input value="<?php echo $paid; ?>" type="hidden" name="pppp" id="pppp" />
    </div>
</div>
<?php if($dd==6){ ?>
<div class="control-group">
    <label class="span4"> Paid Amount - Cash </label>
    <div class="span8">
<input value="<?php echo $due; ?>" onkeyup="paid_method('<?php echo $dd; ?>','<?php echo $paid; ?>','<?php echo number_format($total,2); ?>')" type="text"  name="pam" id="pam" placeholder="Cash Paid Amount..." />
	</div>
</div>

<div class="control-group">
    <label class="span4"> Paid Amount - Credit Card </label>
    <div class="span8">
<input type="text" onkeyup="paid_method('<?php echo $dd; ?>','<?php echo $paid; ?>','<?php echo number_format($total,2); ?>')" name="pamc" id="pamc" placeholder="Credit Card Paid Amount..." />
	</div>
</div>

<div class="control-group">
    <label  class="span4"> Due Amount </label>
    <div class="span8">
	<input type="text" value="0" id="ddue" name="ddue" readonly placeholder="Due Amount..." />
    </div>
</div>
<?php }else{ ?>
<div class="control-group">
    <label  class="span4"> Paid Amount </label>
    <div class="span8">
<input type="text"  name="pam" onkeyup="paid_method('<?php echo $dd; ?>','<?php echo $paid; ?>','<?php echo number_format($total,2); ?>')" id="pam" placeholder="Paid Amount..." />
	</div>
</div>

<div class="control-group">
    <label class="span4"> Due Amount </label>
    <div class="span8">
	<input type="text" value="0" id="ddue" name="ddue" readonly placeholder="Due Amount..." />
	</div>
</div>
<?php } ?>

<?php } ?>