<?php 
	if($cashier_id==1)
	{
		if(!empty($_POST['cuss']))
		{
    		echo $obj->update($table3, array("invoice_id" =>$_SESSION['SESS_CART'],"cid"=>$_POST['cuss'],"input_by"=>$input_by));
			$obj->Success("Customer Added Succeessfully. ", $obj->filename());
		}
		else
		{
			$obj->Success("Customer Added Succeessfully. ", $obj->filename());
		}
	}
	else
	{
		$obj->Error("Cashier Not Looged In, Please Login First. ", $obj->filename());
	}
	//echo $_POST['cuss'];
	exit();
?>