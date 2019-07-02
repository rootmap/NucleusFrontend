<?php
include('class/auth.php');
include('class/pos_class.php');
$obj_pos = new pos();
$table = "product";
$table2 = "sales";
$table3 = "invoice";
$table4 = "invoice_payment";
$cashier_id=$obj_pos->cashier_id(@$_SESSION['SESS_CASHIER_ID']);
$cashiers_id=$obj_pos->cashier_actual_id(@$_SESSION['SESS_CASHIER_ID']);
$cart = $obj->cart(@$_SESSION['SESS_CART']);
if(@$_GET['lfwspcs'])
{
		extract($_GET);
		$obj->insert("transaction_log",array("transaction"=>$_SESSION['SESS_CART'],"sid"=>$input_by,"cashier_id"=>$cashiers_id,"date"=>date('Y-m-d'),"time"=>date('H:i:s'),"input_by"=>$input_by,"access_id"=>$access_id,"amount"=>"-".$_GET['lfwspcs'],"type"=>7,"tender"=>3,"status"=>1));
		$id=$obj->SelectAllByVal2("store_open","sid",$input_by,"status",1,"id");	
		$obj->update("store_open",array("id"=>$id,"status"=>2));
		$obj_pos->cashier_logout_without_return(@$_SESSION['SESS_CASHIER_ID']);
		header("location:logout.php");	
}

if(isset($_GET['caslogoutfrompage']))
{
	$obj->Error("Cashier Can Logout Using This Page .. ", $obj->filename());
}

if(isset($_GET['caslogout']))
{
	$obj_pos->cashier_logout_without_return(@$_SESSION['SESS_CASHIER_ID']);
	header("location:logout.php");
}

if(isset($_GET['logout']))
{
	$obj_pos->cashier_logout(@$_SESSION['SESS_CASHIER_ID']);
}

if(isset($_POST['cashier_login'])) 
{	
	extract($_POST);
	if($logval==2)
	{
    	$obj_pos->cashier_login_process_to_logout($username,$password);
	}
	else
	{
		$obj_pos->cashier_login_process($username,$password);
	}
}



if(isset($_POST['savecus'])) 
{
	if($cashier_id==1)
	{
    	$obj->update($table3, array("invoice_id" =>$_SESSION['SESS_CART'],"cid"=>$_POST['cuss'],"input_by"=>$input_by));
		$obj->Success("Customer Added Succeessfully. ", $obj->filename());
	}
	else
	{
		$obj->Error("Cashier Not Looged In, Please Login First. ", $obj->filename());
	}
	//echo $_POST['cuss'];
	exit();
}

if(isset($_POST['store_open']))
{
	$chk=$obj->exists_multiple("store_open",array("sid" =>$input_by,"status"=>1));
	if($chk==0)
	{
		$obj->insert("store_open",array("sid"=>$input_by,"opening_cash"=>$_POST['cash'],"opening_sqaure"=>$_POST['square'],"date"=>date('Y-m-d'),"datetime"=>date('Y-m-d H:i'),"access_id"=>$access_id,"status"=>1));
		
		if(!empty($_POST['cash']))
		{
			$tender="Store Open";
			$amount=$_POST['cash'];	
		}
		elseif(!empty($_POST['square']))
		{
			$tender="Store Open";
			$amount=$_POST['square'];
		}
		else
		{
			$tender=0;	
			$amount=0;
		}
		$obj->insert("transaction_log",array("transaction"=>$_SESSION['SESS_CART'],"sid"=>$input_by,"cashier_id"=>$cashiers_id,"date"=>date('Y-m-d'),"input_by"=>$input_by,"access_id"=>$access_id,"time"=>date('H:i:s'),"amount"=>$amount,"type"=>1,"tender"=>3,"status"=>1));
		$obj->Success("Store Open Successfully",$obj->filename());		
	}
	else
	{
		$id=$obj->SelectAllByVal2("store_open","sid",$input_by,"status",1,"id");	
		$obj->update("store_open",array("id"=>$id,"status"=>2));
		$obj->Success("Store Closed Successfully",$obj->filename());	
	}
}



if(isset($_POST['storecloseing']))
{
		extract($_POST);
		$obj->insert("transaction_log",array("transaction"=>$_SESSION['SESS_CART'],"sid"=>$input_by,"cashier_id"=>$cashiers_id,"date"=>date('Y-m-d'),"time"=>date('H:i:s'),"input_by"=>$input_by,"access_id"=>$access_id,"amount"=>"-".$_POST['totalcl'],"type"=>7,"tender"=>3,"status"=>1));
		$id=$obj->SelectAllByVal2("store_open","sid",$input_by,"status",1,"id");	
		$obj->update("store_open",array("id"=>$id,"status"=>2));
		
		//
		//closeing store data
		$stid=$obj->SelectAllByVal("cashier_list","id",$cashiers_id,"store_id");
		$obj->insert("close_store_detail",array("store_id"=>$stid,"cashier_id"=>$cashiers_id,"total_collection_cash_credit_card"=>$total_collection_cash_credit_card,"cash_collected_plus"=>$cash_collected_plus,"credit_card_collected_plus"=>$credit_card_collected_plus,"opening_cash_plus"=>$opening_cash_plus,"opening_credit_card_plus"=>$opening_credit_card_plus,"payout_plus_min"=>$payout_plus_min,"buyback_min"=>$buyback_min,"tax_min"=>$tax_min,"current_cash"=>$current_cash,"current_credit_card"=>$current_credit_card,"current_total"=>$_POST['totalcl'],"access_id"=>$access_id,"date"=>date('Y-m-d'),"status"=>1));
		//$obj->insert("close_store_detail",array("date"=>date('Y-m-d'),"status"=>1));
		//closeing store data	
		$obj->Success("Store Closed Successfully",$obj->filename());
}

if(isset($_GET['storecloseingmm']))
{
		extract($_GET);
		$obj->insert("transaction_log",array("transaction"=>$_SESSION['SESS_CART'],"sid"=>$input_by,"cashier_id"=>$cashiers_id,"date"=>date('Y-m-d'),"time"=>date('H:i:s'),"input_by"=>$input_by,"access_id"=>$access_id,"amount"=>"-".$_GET['storecloseingmm'],"type"=>7,"tender"=>3,"status"=>1));
		$id=$obj->SelectAllByVal2("store_open","sid",$input_by,"status",1,"id");	
		$obj->update("store_open",array("id"=>$id,"status"=>2));
		
		//closeing store data
		$stid=$obj->SelectAllByVal("cashier_list","id",$cashiers_id,"store_id");
		$obj->insert("close_store_detail",array("store_id"=>$stid,"cashier_id"=>$cashiers_id,"total_collection_cash_credit_card"=>$total_collection_cash_credit_card,"cash_collected_plus"=>$cash_collected_plus,"credit_card_collected_plus"=>$credit_card_collected_plus,"opening_cash_plus"=>$opening_cash_plus,"opening_credit_card_plus"=>$opening_credit_card_plus,"payout_plus_min"=>$payout_plus_min,"buyback_min"=>$buyback_min,"tax_min"=>$tax_min,"current_cash"=>$current_cash,"current_credit_card"=>$current_credit_card,"current_total"=>$_GET['storecloseingmm'],"access_id"=>$access_id,"date"=>date('Y-m-d'),"status"=>1));
		//$obj->insert("close_store_detail",array("date"=>date('Y-m-d'),"status"=>1));
		//closeing store data	
		$obj->Success("Store Closed Successfully",$obj->filename());
}



if(isset($_POST['store_payout']))
{
	if($cashiers_id!=0)
	{
		$chkopenstore=$obj->exists_multiple("store_open",array("sid"=>$input_by,"status"=>1)); 
		if($chkopenstore!=0)
		{
			$track_id=time(); 
			$obj->insert("payout",array("uid"=>$input_by,"track_id"=>$track_id,"cashier_id"=>$cashiers_id,"amount"=>$_POST['cash'],"date"=>date('Y-m-d'),"datetime"=>date('Y-m-d H:i'),"reason"=>$_POST['reason'],"input_by"=>$input_by,"access_id"=>$access_id,"status"=>1));
			$obj->insert("transaction_log",array("transaction"=>$_SESSION['SESS_CART'],"track_id"=>$track_id,"sid"=>$input_by,"cashier_id"=>$cashiers_id,"date"=>date('Y-m-d'),"time"=>date('H:i:s'),"input_by"=>$input_by,"access_id"=>$access_id,"amount"=>$_POST['cash'],"type"=>5,"tender"=>3,"status"=>1));
			$obj->Success("Payout Amount Saved",$obj->filename());	
		}
		else
		{
			$obj->Error("Store Is Not Open, To Made Any Transaction Please Open Store", $obj->filename());
		}
	}
	else
	{
		$obj->Error("Cashier Not Logged IN. PLease Login As A Cashier", $obj->filename());
	}
				
}

if (isset($_GET['action'])) {

    $cart = $_GET['invoice'];
    $cid = $obj->SelectAllByVal("invoice", "invoice_id", $cart, "cid");
    $creator = $obj->SelectAllByVal("invoice", "invoice_id", $cart, "invoice_creator");
	$salrep_id = $obj->SelectAllByVal("invoice", "invoice_id", $cart, "access_id");
    $pt = $obj->SelectAllByVal("invoice", "invoice_id", $cart, "payment_type");
    $ckid = $obj->SelectAllByVal("invoice", "invoice_id", $cart, "checkin_id");
    $tax_statuss = $obj->SelectAllByVal("pos_tax", "invoice_id", $cart, "status");
    if($tax_statuss==0){ $taxs=0; }else{ $taxs=$tax_per_product; }
    include("pdf/MPDF57/mpdf.php");
    $html.="<table id='sample-table-2' class='table table-hover' border='1'><tbody>";

	$report_cpmpany_name=$obj->SelectAllByVal("setting_report","store_id",$input_by,"name");
	$report_cpmpany_address=$obj->SelectAllByVal("setting_report","store_id",$input_by,"address");
	$report_cpmpany_phone=$obj->SelectAllByVal("setting_report","store_id",$input_by,"phone");
	$report_cpmpany_email=$obj->SelectAllByVal("setting_report","store_id",$input_by,"email");
	$report_cpmpany_fotter=$obj->SelectAllByVal("setting_report","store_id",$input_by,"fotter");

	function limit_words($string, $word_limit){
		$words = explode(" ",$string);
		return implode(" ",array_splice($words,0,$word_limit));
	}
	
	$addressfline=limit_words($report_cpmpany_address,3);
	$lengthaddress=strlen($addressfline);
	$lastaddress=substr($report_cpmpany_address,$lengthaddress,30000);


    $html .="<tr>
			<td style='height:40px; background:rgba(0,51,153,1);'>
				<table style='width:100%; height:40px; border:0px;'>
					<tr>
						<td width='87%' style='background:rgba(0,51,153,1);  color:#FFF; font-size:30px;'>".$report_cpmpany_name."</td><td width='13%' style='background:rgba(0,51,153,1);  color:#FFF; font-size:30px;'><span style='float:left; text-align:left;'>Invoice</span></td>
					</tr>
				</table>
			</td>
		  </tr>
		  <tr>
			<td style='height:40px;' valign='top'>
				<table style='width:960px; height:40px; font-size:12px; border:0px;'>
					<tr>
						<td width='69%'>
						".$addressfline."<br>
						".$lastaddress."
						</td>
						<td width='31%'>
						DIRECT ALL INQUIRIES TO:<br />
						".$report_cpmpany_name."<br />
						".$report_cpmpany_phone."<br />
						".$report_cpmpany_email."<br />
						</td>
					</tr>
				</table>
			</td>
		  </tr>
		  <tr>
			<td style='height:30px;' valign='top'>
				<table style='width:100%; height:40px; border:0px; font-size:18px;'>
					<tr>
						<td> Sold To : </td>
					</tr>
				</table>
			</td>
		  </tr>
		  <tr>
			<td style='height:40px;' valign='top'>
				<table style='width:960px; height:40px; border:0px;'>
					<tr>
						<td width='69%'>
						Name : " . $obj->SelectAllByVal("customer_list", "id", $cid, "fullname") . "<br />
						Phone : " . $obj->SelectAllByVal("coustomer", "id", $cid, "phone") . "<br />
						</td>
					</tr>
				</table>
			</td>
		  </tr>
		  
		  <tr>
			<td style='height:40px;' valign='top'>
				<table style='width:960px; height:40px; border:0px;'>
					<tr>
						<td width='69%'>
						Phone Repair Center <br />
						We Repair | We Buy | We Sell <br />
						</td>
						<td width='31%'>
						INVOICE DATE  : " . $obj->SelectAllByVal("invoice", "invoice_id", $cart, "invoice_date") . "<br />
						ORDER NO. : " . $cart . "<br />
						SALES REP : " . $obj->SelectAllByVal("store","id",$salrep_id,"name") . "<br />
						</td>
					</tr>
				</table>
			</td>
		  </tr>
		  
		  <tr>
			<td style='height:40px;' valign='top'>
				<table style='width:100%; height:40px; border:0px;'>
					<tr>
						<td width='79%'>
						Sales Tax Rate:  " . $taxs . "%
						</td>
					</tr>
				</table>
			</td>
		  </tr>
		  
		  <tr>
			<td valign='top' style='margin:0; padding:0; width:100%;'>
				<table style='width:960px;border:1px; font-size:12px; background:#ccc;'>";
    $html.="<thead><tr>
						<td>S/L</td>
						<td>Product</td>
						<td>Description</td>
						
						<td>Quantity</td>
						<td>Unit Cost</td>
						<td>Tax</td>
						<td>Extended</td>
					</tr></thead>";
    $sqlsaleslist = $obj->SelectAllByID($table2, array("sales_id" =>$cart));
    $sss = 1;
    $subtotal = 0;
    $tax = 0;
    if (!empty($sqlsaleslist))
        foreach($sqlsaleslist as $saleslist):
            $caltax = ($saleslist->single_cost * $tax_per_product) / 100;
            $procost = $saleslist->quantity * $saleslist->single_cost;
            $subtotal+=$procost;
            $tax_status = $obj->SelectAllByVal("pos_tax", "invoice_id", $cart, "status");
            if ($tax_status == 0) {
                $tax+=0;
                $taxst = "No";
                $taxstn = "1";
                $extended = $procost;
            } else {
                $tax+=$caltax * $saleslist->quantity;
                $taxst = "Yes";
                $taxstn = "0";
                $extended = $procost + $caltax;
            }
            $html.="<thead><tr>
						<td>" . $sss . "</td>
						<td>" . $obj->SelectAllByVal($table, "id", $saleslist->pid, "name") . "</td>
						<td>" . $obj->SelectAllByVal($table, "id", $saleslist->pid, "name") . "</td>
						
						<td>" . $saleslist->quantity . "</td>
						<td><button type='button' class='btn'>$" . $saleslist->single_cost . "</button></td>
						<td>$" . $caltax . "</td>
						<td>
							<button type='button' class='btn'>$" . $extended . "</button>
						</td>
					</tr></thead>";

            $sss++;
        endforeach;
    if ($pt == 0) {
        $pp = "Not Paid";
    } else {
        $pp = $obj->SelectAllByVal("payment_method", "id", $pt, "meth_name");
    }
	
	
	$sqlbuyback=$obj->exists_multiple("buyback",array("pos_id"=>$cart));
	if($sqlbuyback==0)
	{
		$tradein=0;
	}
	else
	{
		$tradein=$obj->SelectAllByVal("buyback","pos_id",$cart,"price");
	} 
	
    $total =($subtotal+$tax)-$tradein;
    if ($paid != 0) {
        $dd = number_format($total, 2);
    } else {
        $dd = "$0.00";
    }

    if ($paid != 0) {
        $ff = "$0.00";
    } else {

        $ff = number_format($total, 2);
    }

    $paid = 0;
    $sqlpp = $obj->SelectAllByID_Multiple("invoice_payment", array("invoice_id" => $cart));
    if (!empty($sqlpp)) {
        foreach ($sqlpp as $pps):
            $paid+=$pps->amount;
        endforeach;
    }
    else {
        $paid+=0;
    }

    $due = $total - $paid;
    $html.="</table></td></tr>";
    if ($ckid != 0) {

        $html.="<tr><td><table style='width:960px;'>
					<thead>
						<tr>
							<td width='350' valign='top'>";
		  if($obj->exists_multiple("checkin_request_ticket",array("checkin_id"=>$ckid))==0)
		  {
		  		$html.="<table style='width:300px;border:1px; margin-left:-4px; font-size:12px; background:#ccc;'>
					<thead>
						<tr>
							<th>IMEI of Device being repair : </th>
							<th>".$obj->SelectAllByVal("ticket","ticket_id",$ckid,"imei")."</th>
						</tr>

						<tr>
							<th>Carrier :  </th>
							<th>".$obj->SelectAllByVal("ticket","ticket_id",$ckid,"carrier")."</th>
						</tr>
						<tr>
							<th>Color :  </th>
							<th>".$obj->SelectAllByVal("ticket","ticket_id",$ckid,"type_color")."</th>
						</tr>
						<tr>
							<th>Problem :  </th>
							<th>".$obj->SelectAllByVal("problem_type","id",$obj->SelectAllByVal("ticket","ticket_id",$ckid,"problem_type"),"name")."</th>
						</tr>
					</thead>
				</table>";
		  }
		  else
		  {
			  $html.="<table style='width:300px;border:1px; margin-left:-4px; font-size:12px; background:#ccc;'>
					<thead>
						<tr>
							<th>IMEI of Device being repair: </th>
							<th>" . $obj->SelectAllByVal("checkin_request_ticket", "checkin_id", $ckid, "imei") . "</th>
						</tr>";
				
				if($input_by=="1430934079")
				{
					$html.="<tr>
								<th>Password : </th>
								<th>".$obj->SelectAllByVal("checkin_request_ticket","checkin_id",$ckid,"password")."</th>
							</tr>";
				}
				
				$html.="<tr>
							<th>Carrier:  </th>
							<th>" . $obj->SelectAllByVal("checkin_list", "checkin_id", $ckid, "network") . "</th>
						</tr>
						<tr>
							<th>Color:  </th>
							<th>" . $obj->SelectAllByVal("checkin_list", "checkin_id", $ckid, "color") . "</th>
						</tr>
						<tr>
							<th>Problem:  </th>
							<th>" . $obj->SelectAllByVal("checkin_list", "checkin_id", $ckid, "problem") . "</th>
						</tr>
					</thead>
				</table>";
		  }
				$html.="</td>
				<td>
					<table style='width:250px;border:1px; font-size:12px; background:#ccc;'>
						<thead>
							<tr>
								<th>Payment Type: </th>
								<th>" . $pp . "</th>
							</tr>
							<tr>
								<th>Sub - Total: </th>
								<th>" . number_format($subtotal, 2) . "</th>
							</tr>
							<tr>
								<th>Tax: </th>
								<th>" . number_format($tax, 2) . "</th>
							</tr>";
				
				$sqlbuybackpdf=$obj->exists_multiple("buyback",array("pos_id"=>$cart));
				if($sqlbuybackpdf==0)
				{
					$tradeinpdf=0;
				}
				else
				{
					$tradeinpdf=$obj->SelectAllByVal("buyback","pos_id",$cart,"price");
					$html.="<tr>
								<th>Buyback: </th>
								<th>" . number_format($tradeinpdf, 2) . "</th>
							</tr>";
				} 
							
				$html.="<tr>
								<th>Total: </th>
								<th>" . number_format($total, 2) . "</th>
							</tr>
							<tr>
								<th>Payments: </th>
								<th>" . $paid . "</th>
							</tr>
							<tr>
								<th>Balance Due: </th>
								<th>" . $due . "</th>
							</tr>
						</thead>
					</table>
				</td>
				</tr>
				</thead>
				</table>
		  </td>
		  </tr>
		  <tr>
		  <td>
				
		  </td>
		  </tr>";
    } else {

        $html.="<tr><td><table style='width:250px;border:1px; font-size:12px; background:#ccc;'><thead>
							<tr>
								<th>Payment Type: </th>
								<th>" . $pp . "</th>
							</tr>
							<tr>
								<th>Sub - Total: </th>
								<th>" . number_format($subtotal, 2) . "</th>
							</tr>
							<tr>
								<th>Tax: </th>
								<th>" . number_format($tax, 2) . "</th>
							</tr>";
		$sqlbuybackpdf=$obj->exists_multiple("buyback",array("pos_id"=>$cart));
		if($sqlbuybackpdf==0)
		{
			$tradeinpdf=0;
		}
		else
		{
			$tradeinpdf=$obj->SelectAllByVal("buyback","pos_id",$cart,"price");
			$html.="<tr>
						<th>Buyback: </th>
						<th>" . number_format($tradeinpdf, 2) . "</th>
					</tr>";
		} 		
					
		$html.="<tr>
								<th>Total: </th>
								<th>" . number_format($total, 2) . "</th>
							</tr>
							<tr>
								<th>Payments: </th>
								<th>" . $paid . "</th>
							</tr>
							<tr>
								<th>Balance Due: </th>
								<th>" . $due . "</th>
							</tr>
						</thead></table></td></tr>";
    }

    if ($obj->exists_multiple("invoice_payment", array("invoice_id" => $cart)) != 0) {
        $html.="<tr><td>
				<br />
				<h3> Transaction Detail </h3>
				<table style='width:100%;border:1px; font-size:12px; background:#ccc;'>";
        $html.="<thead><tr>
						<td> S/L </td>
						<td>Payment Method</td>
						<td>Amount</td>
						<td>Date</td>
					</tr></thead>";
        $sqlsaleslist = $obj->SelectAllByID("invoice_payment", array("invoice_id" => $cart));
        $sss = 1;
        if (!empty($sqlsaleslist))
            foreach ($sqlsaleslist as $saleslist):
                $html.="<thead><tr>
						<td>" . $sss . "</td>
						<td>" . $obj->SelectAllByVal("payment_method", "id", $saleslist->payment_type, "meth_name") . "</td>
						<td>$" . $saleslist->amount . "</td>
						<td>" . $saleslist->date . "</td></tr></thead>";

                $sss++;
            endforeach;
        $html.="</table></td></tr>";
    }

    $html.="<tr>
			<td align='center' style='font-size:8px;'>".$report_cpmpany_fotter."</td>
		  </tr>
		  <tr>
			<td align='center'>Thank You For Your Business</td>
		  </tr>";
    $html.="</tbody></table>";

    $mpdf = new mPDF('c', 'A4', '', '', 32, 25, 27, 25, 16, 13);

    $mpdf->SetDisplayMode('fullpage');

    $mpdf->list_indent_first_level = 0; // 1 or 0 - whether to indent the first level of a list
    // LOAD a stylesheet
    $stylesheet = file_get_contents('pdf/MPDF57/examples/mpdfstyletables.css');
    $mpdf->WriteHTML($stylesheet, 1); // The parameter 1 tells that this is css/style only and no body/html/text

    $mpdf->WriteHTML($html, 2);

    $mpdf->Output('mpdf.pdf', 'I');
}

if (isset($_POST['paidnprint'])) 
{
	
	if($cashier_id==1){
		if(empty($_POST['pam']) || $_POST['pam']==0)
		{
			$obj->Error("Your Payment is Empty Please Check Your Paid Amount.","pos_redirect.php");
		}
		else
		{
			if($_POST['customername']==6)
			{
				$obj->insert("transaction_log",array("transaction"=>$_POST['sidd'],"sid"=>$input_by,"date"=>date('Y-m-d'),
				"time"=>date('H:i:s'),"cashier_id"=>$cashiers_id,"customer_id"=>$_POST['cid'],
				"amount"=>$_POST['pam'],"type"=>1,"tender"=>$_POST['customername'],
				"input_by"=>$input_by,"sales_track"=>3,"datetime"=>date('Y-m-d H:i:s'),"access_id"=>$access_id,"status"=>1));
				
				$obj->insert("transaction_log",array("transaction"=>$_POST['sidd'],"sid"=>$input_by,"date"=>date('Y-m-d'),
				"time"=>date('H:i:s'),"cashier_id"=>$cashiers_id,"customer_id"=>$_POST['cid'],
				"amount"=>$_POST['pamc'],"type"=>1,"tender"=>$_POST['customername'],
				"input_by"=>$input_by,"sales_track"=>4,"datetime"=>date('Y-m-d H:i:s'),"access_id"=>$access_id,"status"=>1));
				
				if ($obj->insert($table4, array("invoice_id" => $_POST['sidd'], "payment_type" => $_POST['customername'], "cid" => $_POST['cid'], "invoice_creator" => $input_by,"input_by"=>$input_by,"access_id"=>$access_id, "amount" => $_POST['pam'], "date" => date('Y-m-d'), "status" => 1)) == 1) {
					
					$obj->insert($table4, array("invoice_id" => $_POST['sidd'], "payment_type" => $_POST['customername'], "cid" => $_POST['cid'], "invoice_creator" => $input_by,"input_by"=>$input_by,"access_id"=>$access_id, "amount" => $_POST['pamc'], "date" => date('Y-m-d'), "status" => 1));
					
					$obj->update("sales",array("sales_id"=>$_POST['sidd'],"payment_method"=>$_POST['customername'],"datetime"=>date('Y-m-d H:i'),"access_id"=>$access_id,"input_by"=>$input_by));
					//$obj->Success("Payment Recored Saved",$obj->filename()); save payment and exit sales
					$obj->newcart(@$_SESSION['SESS_CART']);
					$obj->insert($table3, array("invoice_id" => $_SESSION['SESS_CART'], "invoice_creator" => $input_by, "invoice_date" => date('d-m-Y'), "date" => date('Y-m-d'), "status" => 1, "checkin_id" => $_GET['checkin_id'], "doc_type" => 3,"access_id"=>$access_id,"input_by"=>$input_by));
					$obj->Success("Payment Record Saved","pos.php?action=pdf&invoice=".$_POST['sidd']);
			
					//save payment and exit sales	
				} else {
					$obj->Error("Payment Recored Failed to Save","pos.php");
				}
			}
			else
			{
				$obj->insert("transaction_log",array("transaction"=>$_POST['sidd'],"sid"=>$input_by,"date"=>date('Y-m-d'),
				"time"=>date('H:i:s'),"cashier_id"=>$cashiers_id,"customer_id"=>$_POST['cid'],
				"amount"=>$_POST['pam'],"type"=>1,"tender"=>$_POST['customername'],
				"input_by"=>$input_by,"access_id"=>$access_id,"status"=>1));
				
				if ($obj->insert($table4, array("invoice_id" => $_POST['sidd'], "payment_type" => $_POST['customername'], "cid" => $_POST['cid'], "invoice_creator" => $input_by,"input_by"=>$input_by,"access_id"=>$access_id, "amount" => $_POST['pam'], "date" => date('Y-m-d'), "status" => 1)) == 1) {
					$obj->update("sales",array("sales_id"=>$_POST['sidd'],"payment_method"=>$_POST['customername'],"datetime"=>date('Y-m-d H:i'),"access_id"=>$access_id,"input_by"=>$input_by));
					//$obj->Success("Payment Recored Saved",$obj->filename()); save payment and exit sales
					$obj->newcart(@$_SESSION['SESS_CART']);
					$obj->insert($table3, array("invoice_id" => $_SESSION['SESS_CART'], "invoice_creator" => $input_by, "invoice_date" => date('d-m-Y'), "date" => date('Y-m-d'), "status" => 1, "checkin_id" => $_GET['checkin_id'], "doc_type" => 3,"access_id"=>$access_id,"input_by"=>$input_by));
					$obj->Success("Payment Record Saved","pos.php?action=pdf&invoice=".$_POST['sidd']);
			
					//save payment and exit sales	
				} else {
					$obj->Error("Payment Recored Failed to Save","pos.php");
				}
			}
		}
		
	}
	else
	{
		$obj->Error("Cashier Not Looged In, Please Login First. ","pos.php");
	}
}

if (isset($_POST['onlypaid'])) {
	
 if($cashier_id==1){	
 
 
 		if(empty($_POST['pam']) || $_POST['pam']==0)
		{
			$obj->Error("Your Payment is Empty / less than Full Amount Please Check Your Paid Amount.","pos_redirect.php");
		}
		else
		{
			if($_POST['ddue']!=0)
			{
				$obj->Error("Your Payment is Empty / less than Full Amount Please Check Your Paid Amount.","pos_redirect.php");
			}
			else
			{
				if($_POST['customername']==6)
				{
					$obj->insert("transaction_log",array("transaction"=>$_POST['sidd'],"sid"=>$input_by,"date"=>date('Y-m-d'),
					"time"=>date('H:i:s'),"customer_id"=>$_POST['cid'],"cashier_id"=>$cashiers_id,
					"amount"=>$_POST['pam'],"type"=>4,"input_by"=>$input_by,"access_id"=>$access_id,
					"tender"=>$_POST['customername'],"sales_track"=>3,"datetime"=>date('Y-m-d H:i:s'),"status"=>1));
					
					$obj->insert("transaction_log",array("transaction"=>$_POST['sidd'],"sid"=>$input_by,"date"=>date('Y-m-d'),
					"time"=>date('H:i:s'),"customer_id"=>$_POST['cid'],"cashier_id"=>$cashiers_id,
					"amount"=>$_POST['pamc'],"type"=>4,"input_by"=>$input_by,"access_id"=>$access_id,
					"tender"=>$_POST['customername'],"sales_track"=>4,"datetime"=>date('Y-m-d H:i:s'),"status"=>1));
					
					if ($obj->insert($table4, array("invoice_id" => $_POST['sidd'], "payment_type" => $_POST['customername'], "cid" => $_POST['cid'], "invoice_creator" => $input_by,"input_by"=>$input_by,"access_id"=>$access_id,"amount" => $_POST['pam'], "date" => date('Y-m-d'), "status" =>1))==1){
						
						$obj->insert($table4, array("invoice_id" => $_POST['sidd'], "payment_type" => $_POST['customername'], "cid" => $_POST['cid'], "invoice_creator" => $input_by,"input_by"=>$input_by,"access_id"=>$access_id,"amount" => $_POST['pamc'], "date" => date('Y-m-d'), "status" => 1));
						
						$obj->update("sales",array("sales_id"=>$_POST['sidd'],"payment_method"=>$_POST['customername'],"datetime"=>date('Y-m-d H:i'),"input_by"=>$input_by));
						
						
						//$obj->Success("Payment Recored Saved",$obj->filename()); save payment and exit sales
						$obj->newcart(@$_SESSION['SESS_CART']);
						$obj->insert($table3, array("invoice_id" => $_SESSION['SESS_CART'], "invoice_creator" => $input_by, "invoice_date" => date('d-m-Y'), "date" => date('Y-m-d'), "status" => 1, "checkin_id" => $_GET['checkin_id'], "doc_type" => 3,"access_id"=>$access_id,"input_by"=>$input_by));
						$obj->Success("Payment Record Saved","pos_redirect.php");
				
						//save payment and exit sales	
					} else {
						$obj->Error("Payment Recored Failed to Save","pos_redirect.php");
					}

				}
				else
				{
					$obj->insert("transaction_log",array(
					"transaction"=>$_POST['sidd'],
					"sid"=>$input_by,
					"date"=>date('Y-m-d'),
					"time"=>date('H:i:s'),
					"customer_id"=>$_POST['cid'],
					"cashier_id"=>$cashiers_id,
					"amount"=>$_POST['pam'],
					"type"=>4,
					"input_by"=>$input_by,
					"access_id"=>$access_id,
					"tender"=>$_POST['customername'],
					"status"=>1
					));
					if ($obj->insert($table4, array("invoice_id" => $_POST['sidd'], "payment_type" => $_POST['customername'], "cid" => $_POST['cid'], "invoice_creator" => $input_by,"input_by"=>$input_by,"access_id"=>$access_id,"amount" => $_POST['pam'], "date" => date('Y-m-d'), "status" => 1)) == 1) {
						$obj->update("sales",array("sales_id"=>$_POST['sidd'],"payment_method"=>$_POST['customername'],"datetime"=>date('Y-m-d H:i'),"input_by"=>$input_by));
						//$obj->Success("Payment Recored Saved",$obj->filename()); save payment and exit sales
						$obj->newcart(@$_SESSION['SESS_CART']);
						$obj->insert($table3, array("invoice_id" => $_SESSION['SESS_CART'], "invoice_creator" => $input_by, "invoice_date" => date('d-m-Y'), "date" => date('Y-m-d'), "status" => 1, "checkin_id" => $_GET['checkin_id'], "doc_type" => 3,"access_id"=>$access_id,"input_by"=>$input_by));
						$obj->Success("Payment Record Saved","pos_redirect.php");
				
						//save payment and exit sales	
					} else {
						$obj->Error("Payment Recored Failed to Save","pos_redirect.php");
					}
				}
				
			}
		}
		
	}
	else
	{
		$obj->Error("Cashier Not Looged In, Please Login First. ","pos_redirect.php");
	}
	
}

if(isset($_GET['newsales'])) {
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
					
						$obj->insert($table3, array("invoice_id" => $_SESSION['SESS_CART'],"cid" => $_GET['cid'], "invoice_creator" => $input_by, "invoice_date" => date('d-m-Y'), "date" => date('Y-m-d'), "status" => 1, "checkin_id" => $_GET['checkin_id'], "doc_type" => 3,"access_id"=>$access_id,"input_by"=>$input_by));
					}
					else
					{
						$obj->update($table3,array("invoice_id"=>$_SESSION['SESS_CART'],"cid"=>$_GET['cid'],"checkin_id" =>$_GET['checkin_id'],"access_id"=>$access_id,"input_by"=>$input_by));
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
				
				$obj->insert($table3, array("invoice_id" => $_SESSION['SESS_CART'], "invoice_creator" => $input_by, "invoice_date" => date('d-m-Y'), "date" => date('Y-m-d'), "status" => 1, "checkin_id" => $_GET['checkin_id'], "doc_type" => 3,"access_id"=>$access_id,"input_by"=>$input_by));
				}
				else
				{
					$obj->update($table3,array("invoice_id"=>$_SESSION['SESS_CART'],"checkin_id" =>$_GET['checkin_id'],"access_id"=>$access_id,"input_by"=>$input_by));
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
				/*$obj->insert("transaction_log",array(
				"transaction"=>$_SESSION['SESS_CART'],
				"sid"=>$input_by,
				"date"=>date('Y-m-d'),
				"time"=>date('H:i:s'),
				"amount"=>$totalcost,
				"cashier_id"=>$cashiers_id,
				"type"=>3,
				"input_by"=>$input_by,"access_id"=>$access_id,
				"tender"=>1,
				"status"=>2
				));	*/
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
}

if (isset($_GET['clearsales'])) {
    if($obj->delete("sales",array("sales_id"=>$_GET['sales_id']))==1)
	{
        $obj->Success("Sales Product Deleted","pos_redirect.php");
    } else {
        $obj->Success("Failed","pos_redirect.php");
    }
}

	

$obj_pos->tax_check($cart);

$chk_invoice_cart=$obj->exists_multiple($table3,array("invoice_id" =>$cart));
if($chk_invoice_cart==0)
{
	$obj->insert($table3,array("invoice_id" =>$cart,"invoice_creator"=>$input_by,"invoice_date"=>date('d-m-Y'),"date"=>date('Y-m-d'),"status"=>1,"doc_type"=>3,"access_id"=>$access_id,"input_by"=>$input_by));
	$obj->Success("New Sales ID Generated.","pos_redirect.php");
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
		<?php echo $obj->bodyhead(); ?>
		<script type="text/javascript" src="js/functions/custom.js"></script>
        <script src="ajax/ajax.js"></script>
        <script src="ajax/pos_ajax.js"></script>
        <script>
		$.ajaxSetup({ cache: false });
            function cusid(cid, cart)
            {
                if (cid == "")
                {
                    document.getElementById("mss").innerHTML = "";
                    return;
                }
                if (window.XMLHttpRequest) {
                    // code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp = new XMLHttpRequest();
                } else { // code for IE6, IE5
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function() {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        $("#mss").fadeOut();
                        $("#mss").fadeIn();
                        document.getElementById("mss").innerHTML = xmlhttp.responseText;
                    }
                }
                st = 3;
                xmlhttp.open("GET", "ajax/setversion.php?st=" + st + "&cid=" + cid + "&cart=" + cart, true);
                xmlhttp.send();
            }
			
			function reload_pos_page() {
				location.reload();
			}
			
        </script>
        
        <script>
            function paid_method(method,paid,total_amount)
            {
				//alert('Payment Method');
				if(method==6)
				{
					/*var cash=$('#pam').val();
					var credit=$('#pamc').val();
					
					$('#ddue').val()=total_amount-(cash+credit);*/	
					cash=document.getElementById('pam').value;
					credit=document.getElementById('pamc').value;
					document.getElementById('ddue').value=total_amount-((cash-0)+(credit-0)+(paid-0));
				}
				else
				{
					cash=document.getElementById('pam').value;					
					document.getElementById('ddue').value=total_amount-((cash-0)+(paid-0));
				}
            }
        </script>
        
        <script>
		function loadblankpage(invoice)
		{
			<?php 
			$chk=$obj->exists_multiple("invoice_payment",array("invoice_id"=>$cart));
			if($chk!=0)
			{
			?>
			setTimeout(window.open("pos.php?newsales=1"),5000);	
			<?php
			}
			else
			{
			?>
			setTimeout(window.open("pos.php?refresh"),5000);	
			<?php
			}
			 ?>
		}
		
		
		
		</script>
        <?php
		if(isset($_GET['refresh']))
		{
			?>
            <meta http-equiv="refresh" content="5;url=<?php echo $obj->baseUrl($obj->filename()); ?>">
            <?php
		}
		?>
        <script language="javascript" type="text/javascript">
        function printDiv(divID,amount,total_collection_cash_credit_card,cash_collected_plus,credit_card_collected_plus,opening_cash_plus,opening_credit_card_plus,payout_plus_min,buyback_min,tax_min,current_cash,current_credit_card) {
            //Get the HTML of div
            var divElements = document.getElementById(divID).innerHTML;
            //Get the HTML of whole page
            var oldPage = document.body.innerHTML;
			
            //Reset the page's HTML with div's HTML only
            document.body.innerHTML = 
              "<html><head><title></title></head><body>" + 
              divElements + "</body>";
			//setTimeout(window.open("pos.php?storecloseingmm="+amount),5000);	
			window.open("pos.php?storecloseingmm="+amount+"&total_collection_cash_credit_card="+total_collection_cash_credit_card+"&cash_collected_plus="+cash_collected_plus+"&credit_card_collected_plus="+credit_card_collected_plus+"&opening_cash_plus="+opening_cash_plus+"&opening_credit_card_plus="+opening_credit_card_plus+"&payout_plus_min="+payout_plus_min+"&buyback_min="+buyback_min+"&tax_min="+tax_min+"&current_cash="+current_cash+"&current_credit_card="+current_credit_card);
            //Print Page
            window.print();
            //Restore orignal HTML
			 //window.location="pos.php?storecloseingmm="+amount;
        }
    </script>
    <script>
		function store_close_report()
		{
			
			//alert("Cart ID : ");
			var dfs="<img src='images/loader-big.gif' />";   
			$('#store_close_report').html(dfs);
			
			param1 = {'fetch':1}; $.post('store_close.php', param1,  function(res1) { $('#store_close_report').html(res1); });
		}
	</script>
    
    </head>

    <bod
<?php include('include/header.php'); ?>
        <!-- Main wrapper -->
        <div class="wrapper three-columns">
            <!-- Left sidebar -->
<?php include('include/sidebar_left.php'); ?>
            <!-- /left sidebar -->
            <!-- Main content -->
            <div class="content">

                <!-- Info notice -->
<?php echo $obj->ShowMsg(); ?>
                <!-- /info notice -->

                <div class="outer">
                    <div class="inner">
                        <div class="page-header"><!-- Page header -->
                            <h5><i class="font-money"></i>POS  (Sales - <?php echo $cart; ?> ) : Cashier Id - <?php echo $cashiers_id;  ?> <span id="msg" style="float:right; margin-left:50px;"></span></h5>
                            <ul class="icons">
                                <li><a href="<?php echo $obj->filename(); ?>" class="hovertip" title="Reload"><i class="font-refresh"></i></a></li>
                            </ul>
                        </div><!-- /page header -->

                        <div class="body">

                            <!-- Middle navigation standard -->
<?php //include('include/quicklink.php');   ?>
                            <!-- /middle navigation standard -->

                            <!-- Content container -->
                            <div class="container">




                                <!-- Content Start from here customized -->
                                <div class="block span6">

                                    <!--<a href="#" class="btn btn-success"><i class="icon-ok-sign"></i>Save Invoice</a>
                                    <a href="#" class="btn btn-danger"><i class="icon-trash"></i> Delete Invoice & All Record</a>
                                    <a href="#" class="btn btn-primary"><i class="icon-edit"></i> Edit Invoice</a>
                                    <a href="#" class="btn btn-warning"><i class="icon-print"></i> Print Invoice</a>
                                    <a href="#" class="btn btn-info"><i class="icon-bell"></i >Clone</a>
                                    <a href="#" class="btn btn-success"><i class="icon-screenshot"></i> Quick Payment</a>
                                    <a href="#" class="btn btn-success"><i class="icon-screenshot"></i> Payment</a>

                                    -->                                    
<a href="<?php echo $obj->filename(); ?>?newsales" class="btn btn-danger"><i class="icon-ok-sign"></i> Make New Sales</a>
<a href="<?php echo $obj->filename(); ?>?newsales" class="btn btn-success"><i class="icon-check"></i> Clear POS</a>
<?php 
if($cashiers_id!=0){
$chkopenstore=$obj->exists_multiple("store_open",array("sid"=>$input_by,"status"=>1)); 
if($chkopenstore==1){ ?>
<span id="stccash">
	<a data-toggle="modal" href="#logout_store_close" class="btn btn-danger">
    	<i class="icon-off"></i> Close Store 
    </a>
</span>
<!-- Dialog content -->
<!-- href="#logout_store_close"  myModal3-->
<div id="logout_store_close" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h5 id="myModalLabel"> <i class="icon-inbox"></i> Cashier Login to confirm | Close Store </h5>
        </div>
        <div class="modal-body">

            <div class="row-fluid">
                          
                    <div class="control-group">
                        <label class="control-label"> Username  </label>
                        <div class="controls">
                            <input type="text" id="strurs" placeholder="Username" class="span6" name="username">
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label class="control-label"> Password  </label>
                        <div class="controls">
                            <input type="password" id="strpass" placeholder="Password" class="span6" name="password">
                        </div>
                    </div>
                    <div class="control-group" id="mss"></div>
            </div>
			
        </div>
        <div class="modal-footer">
            <button type="reset" style="float:left;" class="btn btn-warning"  name="reset">Clear </button>
<button type="button" style="float:left;" onClick="store_close_confirm(<?php echo $cashiers_id;  ?>)" class="btn btn-info"  name="cashier_login">Login </button>
        </div>
</div>
<!-- /dialog content --> 
 <!-- Dialog content -->
<?php 
include('include/store_close.php');
?>



<!-- /dialog content -->
<a  data-toggle="modal" href="#myModal46" class="btn btn-info"><i class="icon-tags"></i> Hour Worked </a>



 <!-- Dialog content -->
<div id="myModal46" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form class="form-horizontal" method="post" action="">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h5 id="myModalLabel"> <i class="icon-inbox"></i>  Hour Worked  <span id="mss"></span></h5>
        </div>
        <div class="modal-body">

            <div class="row-fluid">
                
                    <div class="table-overflow">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>S/L</th>
                            <th>Date</th>
							<th>Working Hour</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$sql_product=$obj->SelectAllByID_Multiple_limit("store_punch_time",array("cashier_id"=>$cashiers_id,"sid"=>$input_by),"10");
						$i=1;
						$caltimearray=array();
						if(!empty($sql_product))
						foreach($sql_product as $product):
						?>
						<tr>
							<td><?php echo $i; ?></td>
							<td><?php echo $product->date; ?></td>
							<td>
							<?php
							if($product->outdate!='')
							{
					   echo $obj->punchtimetotal($product->indate." ".$product->intime,$product->outdate." ".$product->outtime);	
					   		$caltimearray[]=$obj->punchtimetotal($product->indate." ".$product->intime,$product->outdate." ".$product->outtime);	
							}
							else
							{
								echo "Still Working...";
							}
							
							
							?>
							</td>
						</tr>
						<?php 
						$i++;
						endforeach; ?>
					</tbody>
				</table>
			</div>
				<h4> Total Working Hour : 
                <?php 
				$hour = 0;    
				$min = 0;
				$sec = 0;    
				foreach($caltimearray as $shift) {
					$hourar=explode(':',$shift);
					$hour+=$hourar[0];
					$min+=$hourar[1];
					$sec+=$hourar[2];
				}
				
				if($min!=0)
				{
					if($min>59)
					{
						$getnewhour=intval($min/60);
						$hours=$hour+$getnewhour;
						$minmin=$getnewhour*60;
						$actualmin=$min-$minmin;
						if(strlen($actualmin)==1)
						{
							echo $hours." : 0".$actualmin." : 00 Second";	
						}
						else
						{
							echo $hours." : ".$actualmin." : 00 Second";
						}
					}
					else
					{
						if(strlen($min)==1)
						{
							echo $hour." : 0".$min." : 00 Second";
						}
						else
						{
							echo $hour." : ".$min." : 00 Second";
						}
					}
				}
				else
				{
					echo $hour." : ".$min." : 00 Second";	
				}
				?>
                 </h4>
            </div>

        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary"  name="store_payout">Save</button>
        </div>
        </form>
</div>
<!-- /dialog content -->
<a  data-toggle="modal" href="#myModal44" class="btn btn-info"><i class="icon-tags"></i> Payout </a>
 <!-- Dialog content -->
<div id="myModal44" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form class="form-horizontal" method="post" action="">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h5 id="myModalLabel"> <i class="icon-inbox"></i> Payout/Drop Deatil <span id="mss"></span></h5>
        </div>
        <div class="modal-body">

            <div class="row-fluid">
                
                    <div class="control-group">
                        <label class="control-label"> Amount </label>
                        <div class="controls">
                            <input class="span6" type="text" id="cash" name="cash" placeholder="Amount" /></div>
                    </div>
                    <div class="control-group">
                        <label class="control-label"> Reason </label>
                        <div class="controls">
                            <textarea class="span6" type="text" id="reason" name="reason" placeholder="Reason"></textarea></div>
                    </div>
                    <div class="control-group">
                    Enter a negative amount if removing cash from the drawer, enter a positive amount if adding cash to the drawer.
                    </div>

            </div>

        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary"  name="store_payout">Save</button>
        </div>
        </form>
</div>
<!-- /dialog content -->
 <?php }
 else
 { ?>
 <!--<a  data-toggle="modal" href="#myModal3" class="btn btn-success"><i class="icon-inbox"></i> Open Store </a>-->
<span id="oopencash">
	<a data-toggle="modal" href="#login_store_open" class="btn btn-success">
    	<i class="icon-inbox"></i> Open Store 
    </a>
</span>
 
<!-- href="#logout_store_close"  myModal3-->
<div id="login_store_open" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h5 id="myModalLabel"> <i class="icon-inbox"></i> Cashier Login to confirm | Store Open </h5>
        </div>
        <div class="modal-body">

            <div class="row-fluid">
                          
                    <div class="control-group">
                        <label class="control-label"> Username  </label>
                        <div class="controls">
                            <input type="text" id="stturs" placeholder="Username" class="span6" name="username">
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label class="control-label"> Password  </label>
                        <div class="controls">
                            <input type="password" id="sttpass" placeholder="Password" class="span6" name="password">
                        </div>
                    </div>
                    <div class="control-group" id="tss"></div>
            </div>
			
        </div>
        <div class="modal-footer">
            <button type="reset" style="float:left;" class="btn btn-warning"  name="reset">Clear </button>
<button type="button" style="float:left;" onClick="store_open_confirm(<?php echo $cashiers_id;  ?>)" class="btn btn-info"  name="cashier_login">Login </button>
        </div>
</div>
<!-- /dialog content -->  
 
 <!-- Dialog content -->
<div id="myModal3" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form class="form-horizontal" method="post" action="">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h5 id="myModalLabel"> <i class="icon-inbox"></i> Open Store <span id="mss"></span></h5>
        </div>
        <div class="modal-body">

            <div class="row-fluid">
            
                    <span> <strong>Store Opening Amount</strong> </span>
                
                    <div class="control-group">
                        <label class="control-label"> Cash </label>
                        <div class="controls">
                        	
                            <input class="span6" type="text" id="cash" name="cash" placeholder="Cash Amount" /></div>
                    </div>
                    <div class="control-group">
                        <label class="control-label"> Credit Card </label>
                        <div class="controls">
                            <input class="span6" type="text" id="square" name="square" placeholder="Credit Card Amount" /></div>
                    </div>
                    


            </div>

        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary" name="store_open"> Open Store </button>
        </div></form>
</div>
<!-- /dialog content -->
<?php }
}
 ?>
<a  data-toggle="modal" href="#myModal4" class="btn btn-info"><i class="icon-time"></i> <?php if($cashiers_id!=0){ ?>Time Clock <?php }else{ ?> Cashier Login Here <?php } ?></a> 
<?php if($cashier_id==1){ ?>
<!--<a href="<?php //echo $obj->filename(); ?>?logout=1" class="btn btn-danger"><i class="icon-off"></i> Logout </a>-->
<a  data-toggle="modal" href="#logout" class="btn btn-danger"><i class="icon-off"></i> Logout </a>
<?php } ?>

 <!-- Dialog content -->
<div id="myModal4" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form class="form-horizontal" method="post" action="">
    <?php if($obj_pos->cashier_login(@$_SESSION['SESS_CASHIER_ID'])==1){ ?>
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h5 id="myModalLabel"> <i class="icon-inbox"></i> Time Clock <span id="mss"></span></h5>
        </div>
        <div class="modal-body">

            <div class="row-fluid">
                          
                    <div class="control-group">
                        <label class="control-label"> Date Time </label>
                        <div class="controls">
                            <input size="10" readonly id="indate"  value="<?php echo date('Y-m-d'); ?>" class="datepicker" type="text">
                        </div>
                    </div>
            </div>
            <div class="row-fluid" id="punchtime">
            	<?php
				$chkpunch=$obj->exists_multiple("store_punch_time",array("sid"=>$input_by,"date"=>date('Y-m-d')));
				if($chkpunch!=0)
				{
				?>
                 <div class="table-overflow">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Date IN</th>
                                <th>Time In</th>
                                <th>Date Out</th>
                                <th>Time Out</th>
                                <th>Elapsed Time (HH:MM)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql_product=$obj->SelectAllByID_Multiple("store_punch_time",array("sid"=>$input_by,"date"=>date('Y-m-d'),"cashier_id"=>$cashier_id));
                            $i=1;
                            if(!empty($sql_product))
                            foreach($sql_product as $product):
                            ?>
                            <tr>
                                <td><?php echo $product->indate; ?></td>
                                <td><?php echo $product->intime; ?></td>
                                <td><?php echo $product->outdate; ?></td>
                                <td><?php echo $product->outtime; ?></td>
                                <td>
                                <?php
								if($product->outdate!='')
								{
									echo $obj->durations($product->indate." ".$product->intime,$product->outdate." ".$product->outtime);	
								}
								?>
                                </td>
                            </tr>
                            <?php 
                            $i++;
                            endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php } ?>         
            </div>

        </div>
        <div class="modal-footer">
        	<?php 
			if($chkpunch==1){ $sssave="Punch  In | Out"; }else{ $sssave="Punch In | Out"; }
			?>
            <button type="button" class="btn btn-primary" onClick="punchin()"  name="store_open"><?php echo $sssave; ?></button>
        </div>
        <?php }else{ ?>
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h5 id="myModalLabel"> <i class="icon-inbox"></i> Cashier Login <span id="mss"></span></h5>
        </div>
        <div class="modal-body">

            <div class="row-fluid">
                          
                    <div class="control-group">
                        <label class="control-label"> Username  </label>
                        <div class="controls">
                            <input type="text" placeholder="Username" class="span6" name="username">
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label class="control-label"> Password  </label>
                        <div class="controls">
                            <input type="password" placeholder="Password" class="span6" name="password">
                        </div>
                    </div>
            </div>

        </div>
        <div class="modal-footer">
            <button type="reset" style="float:left;" class="btn btn-warning"  name="reset">Clear </button>
            <button type="Submit" style="float:left;" class="btn btn-info"  name="cashier_login">Login </button>
        </div>
        <?php } ?>
        </form>
</div>
<!-- /dialog content -->


<!-- Dialog content -->

<!-- /dialog content -->

 <!-- Dialog content -->
<div id="logout" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form class="form-horizontal" method="post" action="">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h5 id="myModalLabel"> <i class="icon-inbox"></i> Please Login To Logout From Cash Counter  <span id="mss"></span></h5>
        </div>
        <div class="modal-body">

            <div class="row-fluid">
                          
                    <div class="control-group">
                        <label class="control-label"> Username  </label>
                        <div class="controls">
                            <input type="text" placeholder="Username" class="span6" name="username">
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label class="control-label"> Password  </label>
                        <div class="controls">
                            <input type="password" placeholder="Password" class="span6" name="password">
                            <input type="hidden" name="logval" value="2">
                        </div>
                    </div>
            </div>

        </div>
        <div class="modal-footer">
            <button type="reset" style="float:left;" class="btn btn-warning"  name="reset">Clear </button>
            <button type="Submit" style="float:left;" class="btn btn-info"  name="cashier_login">Login </button>
        </div>
        </form>
</div>
<!-- /dialog content -->
                                </div>
                                <fieldset>
								<div id="store_close_message"></div>

                                    <div class="row-fluid block">
                                        <div class="well row-fluid span7">
                                            <div class="tabbable">
                                                <!--start ul tabs -->
                                                <ul class="nav nav-tabs">
                                                    <li class="active"><a href="#tab1" data-toggle="tab">Main ( 0 - 49 )</a></li>
                                                    <li><a href="#tab2" data-toggle="tab">Page 2 ( 50 - 300 )</a></li>
                                                    <li><a href="#tab201" data-toggle="tab">Phone Inventory</a></li>
                                                    <li><a href="#tab3" data-toggle="tab">Barcode</a></li>
                                                    <li><a href="#tab4" data-toggle="tab"> Inventory </a></li>
                                                    <li><a href="#tab5" data-toggle="tab"> Manualy </a></li>
                                                </ul>
                                                <!--end ul tabs -->  
                                                <!--start data tabs --> 
                                                <div class="tab-content">
                                                    <div class="tab-pane active" id="tab1">
                                                        <!--tab 1 content start from here-->
														<!-- Selects, dropdowns -->
                                                        <div class="span12" style="padding:0px; margin:0px;">
                                                            <div class="control-group">
                                                                <label class="control-label">Item :</label>
                                                                <div class="controls">
                                                                    <select name="fst_pids" id="fst_pids"  style="width:80%;" data-placeholder="Choose a Item..." class="select-search select2-offscreen" tabindex="-1">
                                                                        <option value=""></option> 
																			<?php
                                                                            if($input_status==1){
																			$sqlproduct_pos = $obj_pos->SelectAllOnlyLimit("product_other_inventory","0","50");
																			}else{
																			$sqlproduct_pos =$obj_pos->SelectAllOnlyOneCondLimit("product_other_inventory","input_by",$input_by,"0","50");	
																			}
                                                                            if (!empty($sqlproduct_pos))
                                                                                foreach ($sqlproduct_pos as $row):
                                                                                    ?>
                                                                                <option value="<?php echo $row->id; ?>">
        																			<?php echo $row->name; ?>
                                                                                </option> 
    																			<?php endforeach; ?> 
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="control-group">
                                                                <label class="control-label">Quantity:</label>
                                                                <div class="controls"><input class="span2" value="1" type="number" name="regular" id="fst_quan" /></div>
                                                            </div>
                                                            <div class="control-group">
                                                                <label class="control-label">&nbsp;</label>
                                                                <div class="controls"><button onClick="fst_inventory_sales('<?php echo $cart; ?>')" type="button" class="btn btn-success"><i class="icon-plus-sign"></i> Add To Invoice </button></div>
                                                            </div>
                                                        </div>
                                                        <!-- /selects, dropdowns -->

                                                        <!--tab 1 content start from here-->
                                                    </div>
                                                    <div class="tab-pane" id="tab2">

														<!-- Selects, dropdowns -->
                                                        <div class="span12" style="padding:0px; margin:0px;">
                                                            <div class="control-group">
                                                                <label class="control-label">Item :</label>
                                                                <div class="controls">
                                                                    <select name="snd_pids" id="snd_pids"  style="width:80%;" data-placeholder="Choose a Item..." class="select-search select2-offscreen" tabindex="-1">
                                                                        <option value=""></option> 
																			<?php
                                                                            if($input_status==1){
																			$sqlproduct_pos_nd = $obj_pos->SelectAllOnlyLimit("product_other_inventory","50","300");
																			}else{
																			$sqlproduct_pos_nd =$obj_pos->SelectAllOnlyOneCondLimit("product_other_inventory","input_by",$input_by,"50","300");	
																			}
                                                                            if (!empty($sqlproduct_pos_nd))
                                                                                foreach ($sqlproduct_pos_nd as $row):
                                                                                    ?>
                                                                                <option value="<?php echo $row->id; ?>">
        																			<?php echo $row->name; ?>
                                                                                </option> 
    																			<?php endforeach; ?> 
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="control-group">
                                                                <label class="control-label">Quantity:</label>
                                                                <div class="controls"><input class="span2" value="1" type="number" name="regular" id="snd_quan" /></div>
                                                            </div>
                                                            <div class="control-group">
                                                                <label class="control-label">&nbsp;</label>
                                                                <div class="controls"><button onClick="snd_inventory_sales('<?php echo $cart; ?>')" type="button" class="btn btn-success"><i class="icon-plus-sign"></i> Add To Invoice </button></div>
                                                            </div>
                                                        </div>
                                                        <!-- /selects, dropdowns -->
                                                        

                                                        

                                                        <!--tab 2 content start from here-->

                                                    </div>
                                                    <div class="tab-pane" id="tab201">

                                                        <!--tab 2 content start from here-->
                                                        <!-- Selects, dropdowns -->
                                                        <div class="span12" style="padding:0px; margin:0px;">
                                                            <div class="control-group">
                                                                <label class="control-label">Item :</label>
                                                                <div class="controls">
                                                                    <select name="phone_pids" id="phone_pids"  style="width:80%;" data-placeholder="Choose a Item..." class="select-search select2-offscreen" tabindex="-1">
                                                                        <option value=""></option> 
																			<?php
                                                                            if($input_status==1){
																			$sqlproduct_phone= $obj_pos->SelectAllOnlyLimit("product_phone_inventory","0","300");
																			}else{
																			$sqlproduct_phone=$obj_pos->SelectAllOnlyOneCondLimit("product_phone_inventory","input_by",$input_by,"0","300");	
																			}
                                                                            if (!empty($sqlproduct_phone))
                                                                                foreach ($sqlproduct_phone as $row):
                                                                                    ?>
                                                                                <option value="<?php echo $row->id; ?>">
        																			<?php echo $row->name; ?>
                                                                                </option> 
    																			<?php endforeach; ?> 
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="control-group">
                                                                <label class="control-label">Quantity:</label>
                                                                <div class="controls"><input class="span2" value="1" type="number" name="regular" id="phone_quan" /></div>
                                                            </div>
                                                            <div class="control-group">
                                                                <label class="control-label">&nbsp;</label>
                                                                <div class="controls"><button onClick="phone_inventory_sales('<?php echo $cart; ?>')" type="button" class="btn btn-success"><i class="icon-plus-sign"></i> Add To Invoice </button></div>
                                                            </div>
                                                        </div>
                                                        <!-- /selects, dropdowns -->
                                                        

                                                        <!--tab 2 content start from here-->

                                                    </div>
                                                    <div class="tab-pane" id="tab3">
                                                        <!--barcode tab content start from here-->
                                                        <!-- Selects, dropdowns -->
                                                        <div class="span12" style="padding:0px; margin:15px 0px 0px 0px;">
                                                            <div class="navbar">
                                                                <div class="navbar-inner">
                                                                    <h5><i class="icon-barcode"></i> Add From Barcode</h5>
                                                                </div>
                                                            </div>
                                                            <div class="control-group">
                                                                <label class="control-label">UPC Code :</label>
                                                                <div class="controls"><input class="span4" id="barcode_reader_place" type="text" name="regular"  onKeydown="Javascript: if (event.keyCode == 13)
                                                                            barcode_sales(this.value, '<?php echo $cart; ?>');"  /> Type &amp; Press Enter / Use Your Barcode Reader</div>
                                                            </div>

                                                            <div class="control-group">
                                                                <label class="control-label">Quantity:</label>
                                                                <div class="controls"><input class="span4" type="number" value="1" /></div>
                                                            </div>
                                                            <!--<div class="control-group">
                                                                <label class="control-label">&nbsp;</label>
                                                                <div class="controls"><button type="button" class="btn btn-success"><i class="icon-plus-sign"></i> Create Line Item </button></div>
                                                            </div>-->
                                                        </div>
                                                        <!-- /selects, dropdowns -->
                                                        <!--barcode tab Start from here-->
                                                    </div>
                                                    <div class="tab-pane" id="tab4">
                                                        <!--form tab content start here-->
                                                        <!-- Selects, dropdowns -->
                                                        <div class="span12" style="padding:0px; margin:0px;">
                                                            <div class="navbar">
                                                                <div class="navbar-inner">
                                                                    <h5><i class="icon-tag"></i> Add From Inventory</h5>
                                                                </div>
                                                            </div>
                                                            <div class="control-group">
                                                                <label class="control-label">Item :</label>
                                                                <div class="controls">
                                                                    <select name="pids" id="pids"  style="width:80%;" data-placeholder="Choose a Item..." class="select-search select2-offscreen" tabindex="-1">
                                                                        <option value=""></option> 
<?php
if($input_status==1){
$sqlpdata = $obj->SelectAll($table);
}else{
$sqlpdata = $obj->SelectAllByID($table,array("input_by"=>$input_by));	
}
if (!empty($sqlpdata))
    foreach ($sqlpdata as $row):
        ?>
                                                                                <option value="<?php echo $row->id; ?>">
        <?php echo $row->name; ?>
                                                                                </option> 
    <?php endforeach; ?> 
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="control-group">
                                                                <label class="control-label">Quantity:</label>
                                                                <div class="controls"><input class="span2" value="1" type="number" name="regular" id="quan" /></div>
                                                            </div>
                                                            <div class="control-group">
                                                                <label class="control-label">&nbsp;</label>
                                                                <div class="controls"><button onClick="inventory_sales('<?php echo $cart; ?>')" type="button" class="btn btn-success"><i class="icon-plus-sign"></i> Create Line Item </button></div>
                                                            </div>
                                                        </div>
                                                        <!-- /selects, dropdowns -->
                                                        <!--form tab content end here-->
                                                    </div>
                                                    <div class="tab-pane" id="tab5">
                                                        <!--form tab content start here-->
                                                        <!-- Selects, dropdowns -->
                                                        <div class="span12" style="padding:0px; margin:0px;">
                                                            <div class="navbar">
                                                                <div class="navbar-inner">
                                                                    <h5><i class="icon-cog"></i> Add Manual Item</h5>
                                                                </div>
                                                            </div>
                                                            <form method="get" action="" name="manual">
                                                                <fieldset>
                                                                    <div class="control-group">
                                                                        <label class="control-label">Item:</label>
                                                                        <div class="controls">
                                                                            <select name="pid" id="pid" style="width:80%;" data-placeholder="Choose a Item..." class="select-search select2-offscreen" tabindex="-1">
                                                                                <option value=""></option> 
<?php
if($input_status==1){
$sqlpdata = $obj->SelectAll($table);
}else{
$sqlpdata = $obj->SelectAllByID($table,array("input_by"=>$input_by));	
}
if (!empty($sqlpdata))
    foreach ($sqlpdata as $row):
        ?>
                                                                                        <option value="<?php echo $row->id; ?>">
                                                                                <?php echo $row->name; ?>
                                                                                        </option> 
                                                                                <?php endforeach; ?> 
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    <div class="control-group">
                                                                        <label class="control-label">Description :</label>
                                                                        <div class="controls"><input class="span12" type="text" name="des" /></div>
                                                                    </div>

                                                                    <div class="control-group">
                                                                        <label class="control-label">Price:</label>
                                                                        <div class="controls"><input  class="span12" type="text" name="price" id="price" /></div>
                                                                    </div>

                                                                    <div class="control-group">
                                                                        <label class="control-label">Cost:</label>
                                                                        <div class="controls"><input  class="span12" type="text" name="cost" id="cost" /></div>
                                                                    </div>

                                                                    <div class="control-group">
                                                                        <label class="control-label">Quantity:</label>
                                                                        <div class="controls"><input class="span12" type="text" name="quantity" id="quantity" /></div>
                                                                    </div>

                                                                    <div class="control-group">
                                                                        <label class="control-label">Taxable:</label>
                                                                        <div class="controls"><label class="checkbox inline"><div id="uniform-undefined" class="checker"><span class="checked"><input style="opacity: 0;" name="taxable" class="style" value="1" id="tax" type="checkbox"></span></div>Checked</label></div>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label class="control-label">&nbsp;</label>
                                                                        <div class="controls"><button onClick="manual_sales('<?php echo $cart; ?>')" type="button" class="btn btn-success"><i class="icon-plus-sign"></i> Add Line Item </button></div>
                                                                    </div>
                                                                </fieldset>
                                                            </form>
                                                        </div>
                                                        <!-- /selects, dropdowns -->
                                                        <!--form tab content end here-->
                                                    </div>
                                                </div>
                                                <!--End data tabs -->   
                                            </div>
                                        </div>
                                        <!-- General form elements -->


                                        <!-- General form elements -->
                                        <div class="well row-fluid span5">
                                            <div class="navbar">
                                                <div class="navbar-inner">
                                                    <h5><i class="font-money"></i> Transaction 
                                                    	<span class="controls" style="margin-left:20px;">
                                                                    <select name="custo" style="width:170px;" onChange="new_customer(this.value, '<?php echo $cart; ?>')" id="customername"  data-placeholder="Choose a Customer" class="select-search select2-offscreen" tabindex="-2">
                                                                        <option value=""></option> 
																		<?php
																		$invoice_cid=$obj->SelectAllByVal($table3,"invoice_id",$_SESSION['SESS_CART'],"cid");
																		if($input_status==1)
																		{
																			$sqlpdata=$obj->SelectAll("coustomer");
																		}
																		else
																		{
																			$sqlpdata=$obj->SelectAllByID("coustomer",array("input_by"=>$input_by));
																		}
                                                                        //$sqlpdata = $obj->SelectAll("coustomer");
                                                                        if (!empty($sqlpdata))
                                                                        foreach ($sqlpdata as $row):
                                                                        ?>
                                                                        <option <?php if($invoice_cid==$row->id){ ?> selected <?php } ?> onclick="cusid(this.value, '<?php echo $cart; ?>')" value="<?php echo $row->id; ?>">
                                                                        <?php echo $row->firstname . " " . $row->lastname; ?>
                                                                        </option> 
                                                                        <?php endforeach; ?> 
                                                                        <option value="0">Add New Customer</option> 
                                                                    </select>

                                                                </span>
                                                        <!--<a style="margin-left:60px;" data-toggle="modal" href="#myModal"> <i class="icon-user"></i>  Customer Info </a>-->
                                                        <a data-toggle="modal" href="#myModal1"> <i class="icon-tasks"></i> Tax </a>
                                                    </h5>
                                                </div>
                                            </div>


                                            <!-- Dialog content -->
                                            <div id="myModal" class="modal hide fade" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <form class="form-horizontal" method="post" action="">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                        <h5 id="myModalLabel">Customer Detail <span id="mss"></span></h5>
                                                    </div>
                                                    <div class="modal-body">

                                                        <div class="row-fluid">

                                                            <div class="control-group" id="newcus_block">
                                                                <label class="control-label" style="display:none;" id="newcus_label">Choose Customer:</label>
                                                                <div class="controls" id="newcus" style="display:none;">
                                                                    <select name="custo" onChange="new_customer(this.value, '<?php echo $cart; ?>')" id="customername"  data-placeholder="Choose a Customer" class="select-search select2-offscreen" tabindex="-2">
                                                                        <option value=""></option> 
                                                                        <option value="<?php echo $def_cus; ?>"><?php echo $obj->SelectAllByVal("customer_list","id",$def_cus,"fullname"); ?></option> 
																		<?php
																		if($input_status==1)
																		{
																			$sqlpdata=$obj->SelectAll("coustomer");
																		}
																		else
																		{
																			$sqlpdata=$obj->SelectAllByID("coustomer",array("input_by"=>$input_by));
																		}
                                                                        //$sqlpdata = $obj->SelectAll("coustomer");
                                                                        if (!empty($sqlpdata))
                                                                        foreach ($sqlpdata as $row):
																		if($row->id!=$def_cus)
														 				{
                                                                        ?>
                                                                        <option <?php if($invoice_cid==$row->id){ ?> selected <?php } ?> onclick="cusid(this.value, '<?php echo $cart; ?>')" value="<?php echo $row->id; ?>">
                                                                        <?php echo $row->firstname . " " . $row->lastname; ?>
                                                                        </option> 
                                                                        <?php 
																		}
																		endforeach; ?> 
                                                                        <option value="0">Add New Customer</option> 
                                                                    </select>

                                                                </div>
                                                            </div>
                                                            <span id="cus_sel">
                                                                <div class="control-group" id="new_business">
                                                                    <label class="control-label">Business Name :</label>
                                                                    <div class="controls">
                                                                        <input class="span6" type="text" id="businessname" placeholder="Customer Business here..." /></div>
                                                                </div>
                                                                <div class="control-group">
                                                                    <label class="control-label">Phone Number </label>
                                                                    <div class="controls">
                                                                        <input class="span6" type="text" id="phonenumber" placeholder="Customer Phone here..." /></div>
                                                                </div>
                                                            </span>


                                                        </div>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn" data-dismiss="modal">Close</button>
                                                        <button class="btn btn-primary" name="savecus"  type="submit">Save changes</button>
                                                    </div></form>
                                            </div>
                                            <!-- /dialog content -->


                                            <!-- Dialog content -->
                                            <div id="myModal1" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    <h5 id="myModalLabel"> <?php
                                                                        $taxst = $obj->SelectAllByVal("pos_tax","invoice_id",$cart,"status");
                                                                        echo $obj_pos->tax_status($taxst);
                                                                        ?> </h5>
                                                </div>
                                                <div class="modal-body">
                                                    <form class="form-horizontal">
                                                        <div class="row-fluid">

                                                            <div class="control-group">
                                                                <label class="control-label">You Can Change </label>
                                                                <div class="controls">
                                                                    <label class="radio inline"><input type="radio" name="radio3" value="2" <?php if ($taxst == 2) { ?> checked="checked" <?php } ?> onClick="pos_tax('<?php echo $cart; ?>', '2')" class="style">Part Tax</label>
                                                                    <label class="radio inline"><input type="radio" name="radio3" value="1" <?php if ($taxst == 1) { ?> checked="checked" <?php } ?> onClick="pos_tax('<?php echo $cart; ?>', '1')" class="style">Full Tax</label>
                                                                    <label class="radio inline"><input type="radio" name="radio3" value="0" <?php if ($taxst == 0) { ?> checked="checked" <?php } ?>  onClick="pos_tax('<?php echo $cart; ?>', '0')" class="style" >No Tax</label> 

                                                                </div>
                                                            </div>

                                                            <div class="control-group">
                                                                <div class="controls" id="pos_tax"> 

                                                                </div>
                                                            </div>

                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn" data-dismiss="modal">Close</button>
                                                    <button class="btn btn-primary">Save changes</button>
                                                </div>
                                            </div>
                                            <!-- /dialog content -->




                                            <div class="span12" style="padding:0px; margin:0px;">
                                                <div class="table-overflow">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Item</th>

                                                                <th>QTY</th>
                                                                <th>U.Price</th>

                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="sales_list">
<?php
$sqlsaleslist = $obj->SelectAllByID($table2, array("sales_id" => $cart));
$sss = 1;
$subtotal = 0;
$tax = 0;
if (!empty($sqlsaleslist))
    foreach ($sqlsaleslist as $saleslist):
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
       
        $tax+=$caltax * $saleslist->quantity;
        $procost = $saleslist->quantity * $saleslist->single_cost;
        $subtotal+=$procost;
        ?>
                                                                    <tr>
                                                                        <td><?php echo $sss; ?></td>
                                                                        <td><?php echo $obj->SelectAllByVal($table, "id", $saleslist->pid, "name"); ?></td>

                                                                        <td><?php echo $saleslist->quantity; ?></td>
                                                                        <td><button type="button" class="btn">$<?php echo $saleslist->single_cost; ?></button></td>

                                                                        <td><button type="button" name="trash" onClick="delete_sales('<?php echo $saleslist->pid; ?>',<?php echo $cart; ?>)"><i class="icon-trash"></i></button></td>
                                                                    </tr>
        <?php
        $sss++;
    endforeach;
?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>



                                            <div class="span6" style="padding:0px; margin:0px; float:right;">
                                                <div class="table-overflow">
                                                    <table class="table table-striped">
                                                        <thead id="subtotal_list">
                                                            <tr>
                                                                <th>Sub - Total: </th>
                                                                <th><?php echo number_format($subtotal, 2); ?></th>
                                                            </tr>
                                                            <tr>
                                                                <th>Tax: </th>
                                                                <th><?php
                                                            if($taxst==1){
                                                                $taa=$tax;
															}elseif($taxst==2) {
                                                                $taa=$tax;	
                                                            }else{
                                                                $taa=0;
                                                            }
                                                            echo number_format($taa, 2);
                                                            ?></th>
                                                            </tr>
                                                            <?php 
															$sqlbuyback=$obj->exists_multiple("buyback",array("pos_id"=>$_SESSION['SESS_CART']));
															if($sqlbuyback==0)
															{
																$tradein=0;
															}
															else
															{
															?>
                                                            <tr>
                                                                <th>Buyback: </th>
                                                                <th><?php
																	$tradein=$obj->SelectAllByVal("buyback","pos_id",$_SESSION['SESS_CART'],"price");
																	echo number_format($tradein,2);
                                                                    ?></th>
                                                            </tr>
                                                            <?php
																
															 } 
															 ?>
                                                            <tr>
                                                                <th>Total: </th>
                                                                <th><?php $total=($subtotal+$taa)-$tradein;
                                                            echo number_format($total, 2); ?></th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                                <br>
                                                <div class="clear"></div>
                                            </div>        
												<div class="span8" style="float:right;" id="paymentoption">
                                                <a  data-toggle="modal" href="#tradein" class="btn btn-primary "><i class="font-credit-card"></i> Trade - in </a> 
                                                <a  data-toggle="modal" href="#paid" class="btn btn-success "><i class="font-credit-card"></i> Pay </a> 
                                                <a href="<?php echo $obj->filename(); ?>?clearsales=1&amp;sales_id=<?php echo $cart; ?>" class="btn btn-danger"><i class="font-trash"></i>  Clear </a>
                                                
                                                <div class="clear"></div>
                                                <a href="checkin.php" class="btn btn-warning"><i class="icon-check"></i> Add Repair </a> 
                                                <a href="ticket.php" class="btn btn-info"><i class="icon-tags"></i> Add Ticket </a> 
                                                <div class="clear"></div>
                                                </div>
                                                <br>
                                                <div class="clear"></div>
                                                <br>
                                            <br>
                                        </div>
                                        <!-- /general form elements -->
                                        
                                        
                                        <!-- Dialog paid -->
                                        <div id="paid" class="modal hide fade" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                                                <h5 id="myModalLabel"> Payment Detail</h5>
                                            </div>
                                            <form class="form-horizontal" action="" method="post">
                                                <div class="modal-body">

                                                    <div class="row-fluid">

                                                        <div class="control-group">
                                                            <label class="span4">Payment Method </label>
                                                            <div class="span8" id="newcus">
                                                                <select name="customername" id="customername" data-placeholder="Choose a Payment..." onChange="paytotal('<?php echo $cart; ?>', this.value)" class="select-search select2-offscreen" tabindex="-1">
                                                                    <option value=""></option> 
																	<?php
                                                                    $sqlpdata = $obj->SelectAll("payment_method");
                                                                    if (!empty($sqlpdata))
                                                                    foreach ($sqlpdata as $row):
                                                                    ?>
                                                                    <option value="<?php echo $row->id; ?>">
                                                                    <?php echo $row->meth_name; ?>
                                                                    </option> 
                                                                    <?php 
																	endforeach; 
																	?>  
                                                                </select>

                                                            </div>
                                                        </div>
                                                        <span id="ss">

                                                        </span>


                                                    </div>

                                                </div>
                                                <div class="modal-footer" id="buttonshow"></div>
                                            </form>
                                        </div>
                                        
                                        <!-- /dialog paid -->
                                        
                                        
                                        
                                        
                                        
                                        <!-- Dialog content -->
                                            <div id="tradein" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <form class="form-horizontal" method="post" action="create_buyback.php">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                        <h5 id="myModalLabel"><i class="icon-random"></i> Create Buyback For Trade-in <span id="mss"></span></h5>
                                                    </div>
                                                    <div class="modal-body">
                                                    
                                                    <?php 
													if(!isset($_SESSION['SESS_CART_BUYBACK'])) 
													{
														$obj->newcart_buyback(@$_SESSION['SESS_CART_BUYBACK']);
														$cart_trade_in = $obj->cart_buyback(@$_SESSION['SESS_CART_BUYBACK']);
													}
													else
													{
														$cart_trade_in = $obj->cart_buyback(@$_SESSION['SESS_CART_BUYBACK']);
													}
													?>
														<?php
														$getcid=$obj->SelectAllByVal("invoice","invoice_id",$_SESSION['SESS_CART'],"cid");
														if($getcid!='')
														{
														?>
                                                        <div class="row-fluid">
															
                                                            <div class="span6" style="margin: 0;">
                                                               <div class="control-group">
                                                                    <input type="text" name="model" class="span12" placeholder="Model " />
                                                                    <input type="hidden" name="buyback_id" value="<?php echo $cart_trade_in; ?>">
                                                                    <input type="hidden" name="cid" value="<?php echo $getcid; ?>">
                                                                </div>
                                                                
                                                                <div class="control-group">
                                                                    <input type="text" name="carrier" class="span12" placeholder="Type Carrier Name" />
                                                                </div>
                                                                
                                                                <div class="control-group">
                                                                    <input type="text" name="imei" class="span12" placeholder="Put Device IMEI Number" />
                                                                </div>
                                                                
                                                                <div class="control-group">
                                                                    <input type="text" name="type_color" class="span12" placeholder="Please Type Color" />
                                                                </div>
                                                                
                                                                
                                                                
                                                            </div>
                                                            
                                                            <div class="span6">
                                                            	
                                                                <div class="control-group">
                                                                    <input type="text" name="gig" class="span12" placeholder="Please Type Gig" />
                                                                </div>
                                                  
                                                                <div class="control-group">
                                                                    <input type="text" name="condition" class="span12" placeholder="Please Type Your Device Condition" />
                                                                </div>
                                                                
                                                                <div class="control-group">
                                                                    <input type="text" name="price" class="span12" placeholder="Please Type Price" />
                                                                </div>
                                                                
                                                                <div class="control-group">
                                                                    <?php 
                                                                    $sqlpm=$obj->SelectAll("payment_method");
                                                                    $i=1;
                                                                    if(!empty($sqlpm))
                                                                    foreach($sqlpm as $pm):
                                                                    if($i==1)
                                                                    {
                                                                    ?>
                                                                    <label class="radio inline"><input type="radio" checked name="payment_method" value="<?php echo $pm->id; ?>" class="style" id="pm_<?php echo $pm->id; ?>"><strong><?php echo $pm->meth_name; ?> </strong></label>
                                                                    <?php
                                                                    }
                                                                    else
                                                                    {
                                                                    ?>
                                                                    <label class="radio inline"><input type="radio" name="payment_method" value="<?php echo $pm->id; ?>" class="style" id="pm_<?php echo $pm->id; ?>"><strong><?php echo $pm->meth_name; ?> </strong></label>
                                                                    <?php	
                                                                    }
                                                                    $i++;
                                                                    endforeach; ?>
                                                                </div>
                                                                
                                                            
                                                            
                                                            
                                                        </div>
														
                                                        
                                                    </div>
													<?php }else{ ?>
                                                    <div class="row-fluid">
                                                    <label class="label label-warning">Please Select A Customer First</label>
                                                    </div>
                                                    <?php } ?>
                                                    <div class="modal-footer">
                                                    	<input type="hidden" name="pos_id" value="<?php echo $_SESSION['SESS_CART']; ?>">
                                                        <button class="btn" data-dismiss="modal">Close</button>
                                                        <?php if($getcid!=''){ ?>
                                                        <button type="submit" name="create_tradein" class="btn btn-success"><i class="icon-ok"></i> Create BuyBack </button>
                                                    	<?php } ?>
                                                    </div>
                                                    </form>
                                            </div>
                                            <!-- /dialog content -->
                                            
                                        
                                        

                                    </div>



                                    <!-- General form elements -->

                                    <!-- /general form elements -->






                                    <div class="clearfix"></div>

                                    <!-- Default datatable -->

                                    <!-- /default datatable -->


                                </fieldset>                     



                                <!-- Content End from here customized -->




                                <div class="separator-doubled"></div> 



                            </div>
                            <!-- /content container -->

                        </div>
                    </div>
                </div>
            </div>
            <!-- /main content -->
<?php include('include/footer.php'); ?>
            <!-- Right sidebar -->
<?php //include('include/sidebar_right.php');   ?>
            <!-- /right sidebar -->

        </div>
        <!-- /main wrapper -->

    </body>
</html>
