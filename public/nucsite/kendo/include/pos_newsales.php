<?php 
//check for existing item in invoice	
	$chk_invoice_check_cart=$obj->exists_multiple($table3,array("invoice_id"=>$cart));
	//if(!isset($_GET['checkin_id']))
	//{		
	//check for existing item in invoice		
	if($cashiers_id!=0)
		{
			$chkopenstore=$obj->exists_multiple("store_open",array("sid"=>$input_by,"status"=>1)); 
			if($chkopenstore!=0)
			{	
		if($cashier_id==1){
			
			
			if(isset($_GET['cid']))
			{
				if(isset($_GET['checkin_id']))
				{
					if($chk_invoice_check_cart==0)
					{
						$obj->newcart(@$_SESSION['SESS_CART']);	
						
						$obj->insert($table3, array("invoice_id" => $_SESSION['SESS_CART'],"cid" => $_GET['cid'], "invoice_creator" => $input_by, "invoice_date" => date('d-m-Y'), "date" => date('Y-m-d'), "status" => 1,"doc_type" => 3,"access_id"=>$access_id,"input_by"=>$input_by));
						
						$obj->insert("pos_checkin",array("invoice_id"=>$_SESSION['SESS_CART'],"checkin_id"=>$_GET['checkin_id'],"cid"=>$_GET['cid'],"date"=>date('Y-m-d'),"status"=>1));
						
					}
					else
					{
						$obj->update($table3,array("invoice_id"=>$_SESSION['SESS_CART'],"cid"=>$_GET['cid'],"access_id"=>$access_id,"input_by"=>$input_by));
						
						$obj->insert("pos_checkin",array("invoice_id"=>$_SESSION['SESS_CART'],"checkin_id"=>$_GET['checkin_id'],"cid"=>$_GET['cid'],"date"=>date('Y-m-d'),"status"=>1));
					}                                                                            
				}
				elseif(isset($_GET['unlock_id']))
				{
					if($chk_invoice_check_cart==0)
					{
						$obj->newcart(@$_SESSION['SESS_CART']);	
					
						$obj->insert($table3, array("invoice_id" => $_SESSION['SESS_CART'],"cid" => $_GET['cid'], "invoice_creator" => $input_by, "invoice_date" => date('d-m-Y'), "date" => date('Y-m-d'), "status" => 1, "unlock_id" => $_GET['unlock_id'], "doc_type" => 3,"access_id"=>$access_id,"input_by"=>$input_by));
					}
					else
					{
						$obj->update($table3,array("invoice_id"=>$_SESSION['SESS_CART'],"cid"=>$_GET['cid'],"unlock_id" =>$_GET['unlock_id'],"access_id"=>$access_id,"input_by"=>$input_by));
					} 
				}
				else
				{
					if($chk_invoice_check_cart==0)
					{
						$obj->newcart(@$_SESSION['SESS_CART']);	
					
					$obj->insert($table3, array("invoice_id" => $_SESSION['SESS_CART'],"cid" => $_GET['cid'], "invoice_creator" => $input_by, "invoice_date" => date('d-m-Y'), "date" => date('Y-m-d'), "status" => 1,"doc_type" => 3,"access_id"=>$access_id,"input_by"=>$input_by));
					}
				}
			}
			else
			{
				if($chk_invoice_check_cart==0)
				{
					$obj->newcart(@$_SESSION['SESS_CART']);	
				
				$obj->insert($table3, array("invoice_id" => $_SESSION['SESS_CART'], "invoice_creator" => $input_by, "invoice_date" => date('d-m-Y'), "date" => date('Y-m-d'), "status" => 1,"doc_type" => 3,"access_id"=>$access_id,"input_by"=>$input_by));
					$obj->insert("pos_checkin",array("invoice_id"=>$_SESSION['SESS_CART'],"checkin_id"=>$_GET['checkin_id'],"cid"=>$_GET['cid'],"date"=>date('Y-m-d'),"status"=>1));
				}
				else
				{
					$obj->update($table3,array("invoice_id"=>$_SESSION['SESS_CART'],"access_id"=>$access_id,"input_by"=>$input_by));
					$obj->insert("pos_checkin",array("invoice_id"=>$_SESSION['SESS_CART'],"checkin_id"=>$_GET['checkin_id'],"cid"=>$_GET['cid'],"date"=>date('Y-m-d'),"status"=>1));
				} 
				
			}
			if (isset($_GET['pid'])) {
				$single_cost = $_GET['price'];
				$quantity = '1';
				$totalcost = $quantity * $single_cost;
				$obj->insert($table2, array("uid" => $input_by,
					"sales_id" => $_SESSION['SESS_CART'],
					"pid" => $_GET['pid'],
					"quantity" => $quantity,
					"cashier_id" =>$_SESSION['SESS_CASHIER_ID'],
					"single_cost" => $single_cost,
					"totalcost" => $totalcost,
					"input_by"=>$input_by,"access_id"=>$access_id,
					"date" => date('Y-m-d'),
					"status" => 1));
				$obj->Success("New Sales Receipt Has Been Created Successfully","pos_redirect.php");
			} else {
				$obj->Success("New Sales Receipt Has Been Created Successfully","pos_redirect.php");
			}
		
		}
		else
		{
			$obj->Error("Cashier Not Looged In, Please Login First. ","pos_redirect.php");
		}
			}
			else
			{
				$obj->Error("Store Is Not Open, To Made Any Transaction Please Open Store","pos_redirect.php");
			}
		}
		else
		{
			$obj->Error("Cashier Not Logged IN. PLease Login As A Cashier","pos_redirect.php");
		}
?>