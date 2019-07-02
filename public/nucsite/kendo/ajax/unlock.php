<?php
include('../class/auth.php');
extract($_GET);
if($st==1)
{
	?>
    <div class="span12" style="margin-bottom:20px; border-radius:3px; margin-top:20px; padding:5px; background: linear-gradient(to bottom, rgba(167, 199, 220, 0.43) 0%, rgba(133, 178, 211, 0.51) 100%) repeat scroll 0 0 rgba(0, 0, 0, 0); border:1px #090 solid;">
    	<?php echo $obj->SelectAllByVal("unlock_service","id",$sid,"name"); ?>
        <br /><br />
        Price : $<?php echo $obj->SelectAllByVal("unlock_service","id",$sid,"price"); ?>
        <br /><br />
        Delivery Time : <?php echo $obj->SelectAllByVal("unlock_service","id",$sid,"delivery_time"); ?>
        <br /><br />
        <div>
        <?php echo $obj->SelectAllByVal("unlock_service","id",$sid,"detail"); ?>
        </div>
    </div>
    <?php
}
elseif($st==2){ echo $obj->SelectAllByVal("unlock_service","id",$sid,"price"); }
elseif($st==3)
{ 
	//echo "success";
	if(!empty($service_id) && !empty($our_cost) && !empty($retail_cost))
	{	
		$product_name=$service_id.":".$obj->SelectAllByVal("unlock_service","id",$service_id,"name");
		$obj->insert("product",array("store_id"=>$input_by,"input_by"=>$input_by,"access_id"=>$input_bys,"name"=>$product_name,"description"=>"Product Added From Unlock","barcode"=>time(),"price_cost"=>$our_cost,"price_retail"=>$retail_cost,"maintain_stock"=>0,"quantity"=>1,"warranty"=>3,"reorder"=>1,"date"=>date('Y-m-d'),"status"=>4));
		
		if($obj->insert("unlock_request",array(
		"cid"=>$cid,
		"unlock_id"=>$unlock_id,
		"uid"=>$input_by,
		"service_id"=>$service_id,
		"our_cost"=>$our_cost,
		"retail_cost"=>$retail_cost,
		"type_color"=>$type_color, 
		"password"=>$password,
		"carrier"=>$carrier,
		"imei"=>$imei,
		"note"=>$note,
		"comment"=>$comment,
		"access_id"=>$access_id,
		"respond_email"=>$respond_email, 
		"date"=>date('Y-m-d'),
		"status"=>1))==1)
		{
			$obj->newcart_unlock(@$_SESSION['SESS_CART_UNLOCK']);
			echo $obj->SelectAllByVal("unlock_service","id",$service_id,"name");
		}
		else
		{
			echo "Something wrong, Try again.";
		}
	}
	else
	{
		echo "Failed, Fill up required field.";
	}
}
else
{
	echo "Error, Please Reload Page";	
}
?>