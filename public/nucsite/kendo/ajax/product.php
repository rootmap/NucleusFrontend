<?php
include('../class/auth.php');
extract($_GET);
$error="<label class='label label-danger'>Failed Reload Page</label>";
if($st==1)
{
	?>
    <input class="span12" type="text" name="name" placeholder="Please Type New Product Name" />
    <input value="0" type="hidden" name="pid" />
    <?php
}
elseif($st==2)
{
	echo $obj->SelectAllByVal("product","id",$pid,"quantity");
}
elseif($st==3)
{
	echo $obj->SelectAllByVal("product","id",$pid,"description");
}
elseif($st==4)
{
	echo $obj->SelectAllByVal("product","id",$pid,"barcode");
}
elseif($st==5)
{
	echo $obj->SelectAllByVal("product","id",$pid,"price_cost");
}
elseif($st==6)
{
	echo $obj->SelectAllByVal("product","id",$pid,"price_retail");
}
elseif($st==7)
{
	echo $obj->SelectAllByVal("product","id",$pid,"discount");
}
elseif($st==8)
{
	echo $obj->SelectAllByVal("product","id",$pid,"reorder");
}
else
{
	echo $error;	
}
?>