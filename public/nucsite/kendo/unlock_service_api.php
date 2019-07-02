<?php 
include('class/auth.php');
if($input_status==3 || $input_status==4)
{
	$obj->Error("Invalid Page Request.","index.php");
}
$table="unlock_service";
//$apilink="../template2";
$apilink="http://wirelessgeekswholesale.com";
if(isset($_GET['editservice']))
{
	extract($_GET);
	if(!empty($name))
	{
			if($obj->update($table,array("id"=>$id,"name"=>$name,"label"=>$label,"price"=>$price,"delivery_time"=>$delivery_time,"date"=>date('Y-m-d'),"status"=>1))==1)
			{
				header("location: ".$apilink."/product-admin/".$backurlpage."?server=1");	
				exit();
			}
			else
			{
				header("location: ".$apilink."/product-admin/".$backurlpage."?server=2");	
				exit();		
			}
	}
	else
	{
		header("location: ".$apilink."/product-admin/".$backurlpage."?server=1");	
		exit();
	}
}
?>