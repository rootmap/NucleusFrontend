<?php
include('../class/auth.php');
include('../class/report_buyback.php');	
$obj_estimate = new estimate();
$table="checkin_version";
extract($_GET);
if($id!='')
{
	$chk=$obj_estimate->BuybackEstimate("buyback_estimate_price",$nid,$dtid,$cid,$dtoid,$wdid,$msid,$model,"amount","2");
	if($chk==0)
	{	
		?>
        <button type="button" class="btn btn-primary" onClick="find_estimate('1','show_estimate')"  name="get_estimate">Re-Check Estimate</button>
        <input type="hidden" name="amounts" value="" />
        <label class="btn btn-warning"> Estimate Price Not Set </label>
        <button type="submit" name="find" class="btn btn-success"> Submit Request To Find </button>
        <?php
	}
	else
	{
		//echo "Estimate Price Set ";	
		//echo $obj_estimate->BuybackEstimate("buyback_estimate_price",$nid,$dtid,$cid,$dtoid,$wdid,$msid,"amount","1");
		?>
        <button type="button" class="btn btn-primary" onClick="find_estimate('1','show_estimate')"  name="get_estimate">Re-Check Estimate</button>
        <input type="hidden" name="amounts" value="<?php echo $obj_estimate->BuybackEstimate("buyback_estimate_price",$nid,$dtid,$cid,$dtoid,$wdid,$msid,$model,"amount","1"); ?>" />
        <label class="btn btn-info"> Estimate Price $<?php echo $obj_estimate->BuybackEstimate("buyback_estimate_price",$nid,$dtid,$cid,$dtoid,$wdid,$msid,$model,"amount","1"); ?> </label>
        <button type="submit" name="find" class="btn btn-success"> Submit Request To Find </button>
        <?php
	}
}
else
{
	echo "wrong";	
}

?>