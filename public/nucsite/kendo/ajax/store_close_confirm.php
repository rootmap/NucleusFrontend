<?php
include('../class/auth.php');
include('../class/pos_class.php');
$obj_pos = new pos();
extract($_GET);
$table="sales";
$success="<label class='label label-success'>Cashier Confirmed You Can Close Store Now</label>";
$updated="<label class='label label-warning'>Shopping Cart Updated</label>";
$error="<label class='label label-danger'>Login Failed, Retry Login Again</label>";
if($str==1)
{
	//cashier_login_process_to_logout_for_store($username,$password,$loginid) 
	echo $obj_pos->cashier_login_process_to_logout_for_store($username,$password,$loginid);
	//echo 1;
}
else
{
	echo 2;	
}
?>