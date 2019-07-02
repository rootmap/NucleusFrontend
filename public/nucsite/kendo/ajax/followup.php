<?php
include('../class/auth.php');
extract($_GET);
if($st==1)
{
    $chk=$obj->exists_multiple("customer_follow_up",array("store_id"=>$store_id,"cid"=>$cid));
    if($chk!=0)
	{ 
		 $fid=$obj->SelectAllByVal2("customer_follow_up","store_id",$store_id,"cid",$cid,"id");
		 $obj->delete("customer_follow_up",array("id"=>$fid));
	}
	else
	{
		$obj->insert("customer_follow_up",array("store_id"=>$store_id,"cid"=>$cid,"date"=>date('Y-m-d')));
    }
	 
}
else
{
	echo "No";	
}
?>