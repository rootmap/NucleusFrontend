<?php
include('class/auth.php');
if (isset($_GET['del'])) 
{
    $obj->deletesing("id", $_GET['del'], "checkin_request");
}

function checkin_status($st) {
    if ($st == 1) 
	{
        return "Completed";
    } 
	else 
	{
        return "Not Completed";
    }
}

function checkin_paid($st) 
{
    if ($st == 0) 
	{
        return "<label class='label label-danger'>Not Paid</label>";
    } 
	elseif($st==33) 
	{
        return "<label class='label label-warning'>Partial</label>";
    }
	else 
	{
        return "<label class='label label-success'>Paid</label>";
    }
}

function checkin_paid2($st) {
    if ($st == 0) {
        return "UNPAID";
    } else {
        return "Paid";
    }
}

if(@$_GET['export']=="excel") 
{


$record_label="CheckIn List Report"; 
header('Content-type: application/excel');
$filename ="CheckIn_list_".date('Y_m_d').'.xls';
header('Content-Disposition: attachment; filename='.$filename);

$data = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">
<head>
    <!--[if gte mso 9]>
    <xml>
        <x:ExcelWorkbook>
            <x:ExcelWorksheets>
                <x:ExcelWorksheet>
                    <x:Name>CheckIn List : Wireless Geeks Inc.</x:Name>
                    <x:WorksheetOptions>
                        <x:Print>
                            <x:ValidPrinterInfo/>
                        </x:Print>
                    </x:WorksheetOptions>
                </x:ExcelWorksheet>
            </x:ExcelWorksheets>
        </x:ExcelWorkbook>
    </xml>
    <![endif]-->
</head>';

$data .="<body>";
//$data .="<h1>Wireless Geeks Inc.</h1>";
$data .="<h3>".$record_label."</h3>";
$data .="<h5>CheckIn List Generate Date : ".date('d-m-Y H:i:s')."</h5>";

$data .="<table>
    <thead>
        <tr style='background:#09f; color:#fff;'>
			<th>#</th>
			<th>Checkin ID</th>
			<th>Detail</th>
			<th>Problem</th>
			<th>CheckIn Price</th>
			<th>Created</th>
			<th>Status</th>
		</tr>
</thead>        
<tbody>";


		if($input_status==1){
			$sqlticket = $obj->SelectAll("checkin_list");
			}
			elseif($input_status==5)
			{
				
				$sqlchain_store_ids=$obj->SelectAllByID("store_chain_admin",array("sid"=>$input_by));
				if(!empty($sqlchain_store_ids))
				{
					$array_ch = array();
					foreach($sqlchain_store_ids as $ch):
						array_push($array_ch,$ch->store_id);
					endforeach;
					
					include('class/report_chain_admin.php');	
						$obj_report_chain = new chain_report();
						$sqlticket=$obj_report_chain->SelectAllByID_Multiple_Or("checkin_list",$array_ch,"input_by","1");
					
				}
				else
				{
					//echo "Not Work";
					$sqlticket="";
				}
			}
			else{
		$sqlticket=$obj->SelectAllByID("checkin_list",array("input_by"=>$input_by));	
			}
			$i = 1;
			if (!empty($sqlticket))
			{
				foreach ($sqlticket as $ticket):
				if($obj->exists_multiple("checkin_request_ticket",array("checkin_id"=>$ticket->checkin_id))!=0)
				{
					$ticket_device=str_replace(' ','',$ticket->device);
		
			$data.="<tr>
				<td>".$i."</td>
				<td>".$ticket->checkin_id."</td>
				<td>".$ticket_device.",".$ticket->color.",".$ticket->network."</td>
				<td>".$ticket->problem."</td>";
			
			$chkx = $obj->exists_multiple("check_user_price", array("ckeckin_id" => $ticket->checkin_id));
                                                            if ($chkx == 0) {
                                                                $estp = $obj->SelectAllByVal("product", "name", $ticket_device . "-" . $ticket->problem, "price_cost");
                                                                if ($estp == '') {
                                                                    $devid = $obj->SelectAllByVal("checkin_request", "checkin_id", $ticket->checkin_id, "device_id");
                                                                    $modid = $obj->SelectAllByVal("checkin_request", "checkin_id", $ticket->checkin_id, "model_id");
                                                                    $probid = $obj->SelectAllByVal("checkin_request", "checkin_id", $ticket->checkin_id, "problem_id");
                                                                    $pp = $obj->SelectAllByVal3("checkin_price", "checkin_id", $devid, "checkin_version_id", $modid, "checkin_problem_id", $probid,"name");
                                                                } else {
                                                                    $pp = $estp;
                                                                }
                                                            } else {

                                                                $estp = $obj->SelectAllByVal("check_user_price", "ckeckin_id", $ticket->checkin_id, "price");
                                                                if ($estp == '') {
                                                                    $devid = $obj->SelectAllByVal("checkin_request", "checkin_id", $ticket->checkin_id, "device_id");
                                                                    $modid = $obj->SelectAllByVal("checkin_request", "checkin_id", $ticket->checkin_id, "model_id");
                                                                    $probid = $obj->SelectAllByVal("checkin_request", "checkin_id", $ticket->checkin_id, "problem_id");
                                                                    $pp = $obj->SelectAllByVal3("checkin_price", "checkin_id", $devid, "checkin_version_id", $modid, "checkin_problem_id", $probid, "name");
                                                                } else {
                                                                    $pp = $estp;
                                                                }
                                                            }
                                                            $pid = $obj->SelectAllByVal("product", "name", $ticket_device . ", " . $ticket->model . " - " . $ticket->problem, "id");
                                                            $cid=$obj->SelectAllByVal2("coustomer","firstname",$obj->SelectAllByVal("checkin_request","checkin_id",$ticket->checkin_id,"first_name"),"phone",$obj->SelectAllByVal("checkin_request","checkin_id",$ticket->checkin_id,"phone"),"id");
				$chkcheckin=$obj->exists_multiple("invoice",array("doc_type"=>3,"checkin_id"=>$ticket->checkin_id));
				$getsales_id=$obj->SelectAllByVal("invoice","checkin_id",$ticket->checkin_id,"invoice_id");
				$curcheck=$obj->exists_multiple("sales",array("sales_id"=>$getsales_id));
			if($curcheck==0){
				if ($pp == '' || $pp == 0) {
					$app=0;
				} else {
					$app=number_format($pp,2);
				}	
				$data.="<td>".$app." Send To Pos</td>";
			}
			else
			{
				if ($pp == '' || $pp == 0) {
					$ssd=0;
				} else {
					$ssd=number_format($pp,2);
				}
				$data.="<td>".$ssd."</td>";
			}
			$data.="<td>".$obj->duration($ticket->date, date('Y-m-d'))."</td>
				<td>".checkin_paid($curcheck)."</td>
			</tr>";
				$i++;
				}
						endforeach;
			}
			
$data .="</tbody><tfoot><tr>
			<th>#</th>
			<th>Checkin ID</th>
			<th>Detail</th>
			<th>Problem</th>
			<th>CheckIn Price</th>
			<th>Created</th>
			<th>Status</th>
		</tr></tfoot></table>";

$data .='</body></html>';

echo $data;
}

if(@$_GET['export']=="pdf") 
{
	$record_label="CheckIn List Report"; 
    include("pdf/MPDF57/mpdf.php");
	extract($_GET);
    $html.="<table id='sample-table-2' class='table table-hover' border='0'><tbody>";
    $html .="<tr>
			<td valign='top' style='margin:0; padding:0; width:100%;'>
				<table style='width:100%; height:40px; border:0px;'>
					<tr>
						<td width='87%' style='background:rgba(0,51,153,1);  color:#FFF; font-size:25px;'>
						CheckIn List Report
						</td>
					</tr>
				</table>

				
				<table style='width:100%; height:40px; border:0px; font-size:18px;'>
					<tr>
						<td> CheckIn List Generate Date : ".date('d-m-Y H:i:s')."</td>
					</tr>
				</table>
				<table style='width:960px;border:1px; font-size:12px; background:#ccc;'>";
				$html.="<thead>
        <tr style='background:#09f; color:#fff;'>
			<th>#</th>
			<th>Checkin ID</th>
			<th>Detail</th>
			<th>Problem</th>
			<th>CheckIn Price</th>
			<th>Created</th>
			<th>Status</th>
		</tr>
</thead>        
<tbody>";

		if($input_status==1){
			$sqlticket = $obj->SelectAll("checkin_list");
			}else{
		$sqlticket=$obj->SelectAllByID("checkin_list",array("input_by"=>$input_by));	
			}
			$i = 1;
			if (!empty($sqlticket))
			{
				foreach ($sqlticket as $ticket):
				if($obj->exists_multiple("checkin_request_ticket",array("checkin_id"=>$ticket->checkin_id))!=0)
				{
		
			$html.="<tr>
				<td>".$i."</td>
				<td>".$ticket->checkin_id."</td>
				<td>".$ticket_device.",".$ticket->color.",".$ticket->network."</td>
				<td>".$ticket->problem."</td>";
			
			$chkx = $obj->exists_multiple("check_user_price", array("ckeckin_id" => $ticket->checkin_id));
                                                            if ($chkx == 0) {
                                                                $estp = $obj->SelectAllByVal("product", "name", $ticket_device . "-" . $ticket->problem, "price_cost");
                                                                if ($estp == '') {
                                                                    $devid = $obj->SelectAllByVal("checkin_request", "checkin_id", $ticket->checkin_id, "device_id");
                                                                    $modid = $obj->SelectAllByVal("checkin_request", "checkin_id", $ticket->checkin_id, "model_id");
                                                                    $probid = $obj->SelectAllByVal("checkin_request", "checkin_id", $ticket->checkin_id, "problem_id");
                                                                    $pp = $obj->SelectAllByVal3("checkin_price", "checkin_id", $devid, "checkin_version_id", $modid, "checkin_problem_id", $probid,"name");
                                                                } else {
                                                                    $pp = $estp;
                                                                }
                                                            } else {

                                                                $estp = $obj->SelectAllByVal("check_user_price", "ckeckin_id", $ticket->checkin_id, "price");
                                                                if ($estp == '') {
                                                                    $devid = $obj->SelectAllByVal("checkin_request", "checkin_id", $ticket->checkin_id, "device_id");
                                                                    $modid = $obj->SelectAllByVal("checkin_request", "checkin_id", $ticket->checkin_id, "model_id");
                                                                    $probid = $obj->SelectAllByVal("checkin_request", "checkin_id", $ticket->checkin_id, "problem_id");
                                                                    $pp = $obj->SelectAllByVal3("checkin_price", "checkin_id", $devid, "checkin_version_id", $modid, "checkin_problem_id", $probid, "name");
                                                                } else {
                                                                    $pp = $estp;
                                                                }
                                                            }
                                                            $pid = $obj->SelectAllByVal("product", "name", $ticket_device . ", " . $ticket->model . " - " . $ticket->problem, "id");
                                                            $cid=$obj->SelectAllByVal2("coustomer","firstname",$obj->SelectAllByVal("checkin_request","checkin_id",$ticket->checkin_id,"first_name"),"phone",$obj->SelectAllByVal("checkin_request","checkin_id",$ticket->checkin_id,"phone"),"id");
				$chkcheckin=$obj->exists_multiple("invoice",array("doc_type"=>3,"checkin_id"=>$ticket->checkin_id));
				$getsales_id=$obj->SelectAllByVal("invoice","checkin_id",$ticket->checkin_id,"invoice_id");
				$curcheck=$obj->exists_multiple("sales",array("sales_id"=>$getsales_id));
			if($curcheck==0){
				if ($pp == '' || $pp == 0) {
					$app=0;
				} else {
					$app=number_format($pp,2);
				}	
				$html.="<td>".$app." Send To Pos</td>";
			}
			else
			{
				if ($pp == '' || $pp == 0) {
					$ssd=0;
				} else {
					$ssd=number_format($pp,2);
				}
				$html.="<td>".$ssd."</td>";
			}
			$html.="<td>".$obj->duration($ticket->date, date('Y-m-d'))."</td>
				<td>".checkin_paid($curcheck)."</td>
			</tr>";
				$i++;
				}
						endforeach;
			}
			
	$html.="</tbody><tfoot><tr>
			<th>#</th>
			<th>Checkin ID</th>
			<th>Detail</th>
			<th>Problem</th>
			<th>CheckIn Price</th>
			<th>Created</th>
			<th>Status</th>
		</tr></tfoot></table>";		
			
    $html.="</td></tr>";
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

if (isset($_GET['action'])) {

    $cart = $_GET['invoice'];
    //$cid = $obj->SelectAllByVal("ticket", "ticket_id", $cart, "cid");
    $creator = $obj->SelectAllByVal("checkin_list", "checkin_id", $cart, "input_by");
	
    $pt = $obj->SelectAllByVal("invoice", "invoice_id", $cart, "payment_type");
    $ckid = $obj->SelectAllByVal("invoice", "invoice_id", $cart, "checkin_id");
    $tax_statuss =$obj->SelectAllByVal("tax_status", "store_id", $creator, "status");
    if($tax_statuss==0){ $taxs=0; }else{ $taxs=$obj->SelectAllByVal("tax", "store_id", $creator, "tax"); }
    include("pdf/MPDF57/mpdf.php");
    $html.="<table id='sample-table-2' class='table table-hover' border='1'><tbody>";

	$report_cpmpany_name=$obj->SelectAllByVal("setting_report","store_id",$creator,"name");
	$report_cpmpany_address=$obj->SelectAllByVal("setting_report","store_id",$creator,"address");
	$report_cpmpany_phone=$obj->SelectAllByVal("setting_report","store_id",$creator,"phone");
	$report_cpmpany_email=$obj->SelectAllByVal("setting_report","store_id",$creator,"email");
	$report_cpmpany_fotter=$obj->SelectAllByVal("setting_report","store_id",$creator,"fotter");

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
						<td width='87%' style='background:rgba(0,51,153,1);  color:#FFF; font-size:30px;'>".$report_cpmpany_name."</td><td width='13%' style='background:rgba(0,51,153,1);  color:#FFF; font-size:30px;'><span style='float:left; text-align:left;'>".$_GET['payment_status']." Invoice</span></td>
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
						Name : " . $obj->SelectAllByVal("checkin_request", "checkin_id", $cart, "first_name") . " " . $obj->SelectAllByVal("checkin_request", "checkin_id", $cart, "last_name") . "<br />
						Phone : " . $obj->SelectAllByVal("checkin_request", "checkin_id", $cart, "phone") . "<br />
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
						INVOICE DATE  : " . $obj->SelectAllByVal("checkin_list", "checkin_id", $cart, "date") . "<br />
						ORDER NO. : " . $cart . "<br />
						SALES REP : " . $obj->SelectAllByVal("store","id",$obj->SelectAllByVal("checkin_request", "checkin_id", $cart, "access_id"),"name") . "<br />
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
						<td>Ticket ID</td>
						<td>Ticket Detail</td>
						
						<td>Quantity</td>
						<td>Unit Cost</td>
						<td>Tax</td>
						<td>Extended</td>
					</tr></thead>";
					
    $sqlsaleslist = $obj->SelectAllByID("checkin_list", array("checkin_id" => $cart));
    $sss = 1;
    $subtotal = 0;
	$curcheck=0;
    $tax = 0;
	$total=0;
	$total=0;
	$sales_invoice=0;
    if (!empty($sqlsaleslist))
        foreach($sqlsaleslist as $saleslist):
            $caltax = ($saleslist->single_cost * $tax_per_product) / 100;
            $procost = $saleslist->quantity * $saleslist->single_cost;
            $subtotal+=$procost;
            $html.="<thead><tr>
						<td>" . $sss . "</td>
						<td>" . $saleslist->checkin_id. "</td>
						<td>" . $saleslist->problem. " - " . $saleslist->device.", ".$saleslist->model.", ".$saleslist->color.", ".$saleslist->network. "</td>";
			
			
			
			$chkx = $obj->exists_multiple("check_user_price", array("ckeckin_id" => $saleslist->checkin_id));
			if ($chkx == 0) {
				$estp = $obj->SelectAllByVal("product", "name", $saleslist->device . "-" . $saleslist->problem, "price_cost");
				if ($estp == '') {
					$devid = $obj->SelectAllByVal("checkin_request", "checkin_id", $saleslist->checkin_id, "device_id");
					$modid = $obj->SelectAllByVal("checkin_request", "checkin_id", $saleslist->checkin_id, "model_id");
					$probid = $obj->SelectAllByVal("checkin_request", "checkin_id", $saleslist->checkin_id, "problem_id");
					
					if($input_status==1)
					{
						$pp = $obj->SelectAllByVal3("checkin_price", "checkin_id", $devid, "checkin_version_id", $modid, "checkin_problem_id", $probid,"name");
					}
					else
					{
						$pp = $obj->SelectAllByVal4("checkin_price", "checkin_id", $devid, "checkin_version_id", $modid, "checkin_problem_id",$probid,"store_id",$input_by,"name");
					}
				} else {
					$pp = $estp;
				}
			} else {

				$estp = $obj->SelectAllByVal("check_user_price", "ckeckin_id", $saleslist->checkin_id, "price");
				if ($estp == '') {
					$devid = $obj->SelectAllByVal("checkin_request", "checkin_id", $saleslist->checkin_id, "device_id");
					$modid = $obj->SelectAllByVal("checkin_request", "checkin_id", $saleslist->checkin_id, "model_id");
					$probid = $obj->SelectAllByVal("checkin_request", "checkin_id", $saleslist->checkin_id, "problem_id");
					
					if($input_status==1)
					{
						$pp = $obj->SelectAllByVal3("checkin_price", "checkin_id", $devid, "checkin_version_id", $modid, "checkin_problem_id", $probid, "name");
					}
					else
					{
						$pp = $obj->SelectAllByVal4("checkin_price", "checkin_id", $devid, "checkin_version_id", $modid, "checkin_problem_id",$probid,"store_id",$input_by,"name");
					}
				} else {
					$pp = $estp;
				}
			}
			$pid = $obj->SelectAllByVal("product", "name", $saleslist->device . ", " . $saleslist->model . " - " . $saleslist->problem, "id");
			$cid=$obj->SelectAllByVal2("coustomer","firstname",$obj->SelectAllByVal("checkin_request","checkin_id",$ticket->checkin_id,"first_name"),"phone",$obj->SelectAllByVal("checkin_request","checkin_id",$saleslist->checkin_id,"phone"),"id");
			$chkcheckin=$obj->exists_multiple("invoice",array("doc_type"=>3,"checkin_id"=>$saleslist->checkin_id));
			$getsales_id=$obj->SelectAllByVal("invoice","checkin_id",$saleslist->checkin_id,"invoice_id");
			$curcheck+=$obj->exists_multiple("sales",array("sales_id"=>$getsales_id));	
			$sales_invoice=$getsales_id;
			if($pp=='')
			{
				$price=0;	
			}
			else
			{
				$price=$pp;	
			}

			$subtotal+=$price;
			
			$caltaxs=($price*$taxs)/100;
			$extended=$price+$caltaxs;
			$tax+=$caltaxs;	
			$total+=$extended;	
			$html.="<td>1</td>
						<td><button type='button' class='btn'>$" . $price . "</button></td>
						<td>$" . $caltaxs . "</td>
						<td>
							<button type='button' class='btn'>$" . $extended . "</button>
						</td>
					</tr></thead>";

            $sss++;
        endforeach;
   
    $html.="</table></td></tr>";
	$ckid=$cart;
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
						</tr>
						<tr>
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
		  
		  		$chk_invoice_status=$obj->exists_multiple("invoice",array("invoice_id"=>$sales_invoice,"status"=>3));
				$html.="</td>
				<td>
					<table style='width:250px;border:1px; font-size:12px; background:#ccc;'>
						<thead>
							<tr>
								<th>Payment : </th>
								<th>" . checkin_paid($curcheck) . "</th>
							</tr>
							<tr>
								<th>Sub - Total: </th>
								<th>$" . number_format($subtotal, 2) . "</th>
							</tr>
							<tr>
								<th>Tax: </th>
								<th>$" . number_format($tax, 2) . "</th>
							</tr>
							<tr>
								<th>Total: </th>
								<th>$" . number_format($total, 2) . "</th>
							</tr>";
					if($chk_invoice_status==1)
					{
						$sqlexpaid=$obj->SelectAllByID_Multiple("invoice_payment",array("invoice_id"=>$sales_invoice));
						$expaid=0;
						if(!empty($sqlexpaid))
						foreach($sqlexpaid as $pd):
							$expaid+=$pd->amount;
						endforeach;
						$exdue=$total-$expaid;
						$html.="<tr>
								<th>Payments: </th>
								<th>$";  
							if($curcheck==0)
							{
								$html.="0";	
							}
							else
							{
								$html.=number_format($expaid,2);	
							}
								$html.="</th>
							</tr>
							<tr>
								<th>Balance Due: </th>
								<th>$";
							if($curcheck==0)
							{
								$html.=$exdue;	
							}
							else
							{
								$html.=$exdue;	
							}	
							
					}
					else
					{
							$html.="<tr>
								<th>Payments: </th>
								<th>$";  
							if($curcheck==0)
							{
								$html.="0";	
							}
							else
							{
								$html.=$total;	
							}
								$html.="</th>
							</tr>
							<tr>
								<th>Balance Due: </th>
								<th>$";
							if($curcheck==0)
							{
								$html.=$total;	
							}
							else
							{
								$html.="0";	
							}
					}
							
								$html.="</th>
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
								<th>" . checkin_paid($curcheck) . "</th>
							</tr>
							<tr>
								<th>Sub - Total: </th>
								<th>$" . number_format($subtotal, 2) . "</th>
							</tr>
							<tr>
								<th>Tax: </th>
								<th>$" . number_format($tax, 2) . "</th>
							</tr>
							<tr>
								<th>Total: </th>
								<th>$" . number_format($total, 2) . "</th>
							</tr>
							<tr>
								<th>Payments: </th>
								<th>$";  
							if($curcheck==0)
							{
								$html.="0";	
							}
							else
							{
								$html.=$total;	
							}
								$html.="</th>
							</tr>
							<tr>
								<th>Balance Due: </th>
								<th>$";
							if($curcheck==0)
							{
								$html.=$total;	
							}
							else
							{
								$html.="0";	
							}	
								$html.="</th>
							</tr>
						</thead></table></td></tr>";
    }




    $html.="<tr>
			<td align='center' style='font-size:8px;'>".$report_cpmpany_fotter."</td>
		  </tr>
		  <tr>
			<td align='center'>Thank You For Your Business</td>
		  </tr>";
    if($_GET['payment_status']=="Paid")
	{
		$color="#09f;";	
	}
	elseif($_GET['payment_status']=="Partial")
	{
		$color="#FF8C00;";	
	}
	else
	{
		$color="#f00";	
	}

    $html.="<tr><td align='center' style='color:".$color."'><h1 style='width:60%; font-size:100px; display:block; margin-left:auto; margin-right:auto; border:3px ".$color." solid;'>".$_GET['payment_status']."</h1></td></tr>";		  
		  
    $html.="</tbody></table>";
	
    $mpdf = new mPDF('c', 'A4', '', '', 32, 25, 27, 25, 16, 13);
    $mpdf->SetDisplayMode('fullpage');
    $mpdf->list_indent_first_level = 0; 
    $stylesheet = file_get_contents('pdf/MPDF57/examples/mpdfstyletables.css');
    $mpdf->WriteHTML($stylesheet, 1);
    $mpdf->WriteHTML($html, 2);
    $mpdf->Output('mpdf.pdf', 'I');
	exit();
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php echo $obj->bodyhead(); ?>
    </head>

    <body>
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
                            <h5><i class="icon-ok-circle"></i>
                            <span style="border-right:2px #333 solid; padding-right:10px;">Check In List Info </span>
                            <span><a data-toggle="modal" href="#myModal"> Generate Check In List Report</a></span>
                            
                            </h5>
                            <ul class="icons">
                                <li><a href="<?php echo $obj->filename(); ?>" class="hovertip" title="Reload"><i class="font-refresh"></i></a></li>
                            </ul>
                        </div><!-- /page header -->

                        <div class="body">

                            <!-- Middle navigation standard -->

                            <?php //include('include/quicklink.php');  ?>
                            <!-- /middle navigation standard -->

                            <!-- Content container -->
                            <div class="container">
<!-- Dialog content -->
                        <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h5 id="myModalLabel">Generate Check In List Report <span id="mss"></span></h5>
                                </div>
                                <div class="modal-body">

                                    <div class="row-fluid">
											<form class="form-horizontal" method="get" action="">
                                            <div class="control-group">
                                                <label class="control-label"><strong>Date Search:</strong></label>
                                                <div class="controls">
                                                    <ul class="dates-range">
                                                        <li><input type="text" id="fromDate" name="from" placeholder="From" /></li>
                                                        <li class="sep">-</li>
                                                        <li><input type="text" id="toDate" name="to" placeholder="To" /></li>
                                                        <li class="sep">&nbsp;</li>
                                                        <li><button class="btn btn-primary" type="submit">Search Report</button></li>
                                                    </ul>
                                                </div>
                                            </div>
											</form>
                                            
											
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <form class="form-horizontal" method="get" action="">
                                    <button class="btn btn-primary" name="all" type="submit">Show All Check In List</button>
                                    </form>
                                </div>
                        </div>
                        <!-- /dialog content -->


                                <!-- Content Start from here customized -->


                                <!-- Default datatable -->
                                <div class="table-overflow">
                                    <table class="table table-striped" id="data-table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Checkin ID</th>
												<th>Detail</th>
                                                <th>Problem</th>
                                                <th>CheckIn Price</th>
                                                <th>Created</th>
                                                <th>Status</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
											if($input_status==1)
											{
												if(isset($_GET['from']))
												{
													$sql_coustomer=$obj->SelectAll_ddate("checkin_list","date",$_GET['from'],$_GET['to']);
												}
												elseif(isset($_GET['all']))
												{
													$sql_coustomer=$obj->SelectAll("checkin_list");
												}
												else
												{
													$sql_coustomer=$obj->SelectAllByID("checkin_list",array("date"=>date('Y-m-d')));
												}
											}
											elseif($input_status==5)
											{
												
												$sqlchain_store_ids=$obj->SelectAllByID("store_chain_admin",array("sid"=>$input_by));
												if(!empty($sqlchain_store_ids))
												{
													$array_ch = array();
													foreach($sqlchain_store_ids as $ch):
														array_push($array_ch,$ch->store_id);
													endforeach;
													
													if(isset($_GET['from']))
													{
														include('class/report_chain_admin.php');	
														$obj_report_chain = new chain_report();
														$sql_coustomer=$obj_report_chain->ReportQuery_Datewise_Or("checkin_list",$array_ch,"input_by",$_GET['from'],$_GET['to'],"1");
													}
													elseif(isset($_GET['all']))
													{
														include('class/report_chain_admin.php');	
														$obj_report_chain = new chain_report();
														$sql_coustomer=$obj_report_chain->SelectAllByID_Multiple_Or("checkin_list",$array_ch,"input_by","1");
													}
													else
													{
														include('class/report_chain_admin.php');	
														$obj_report_chain = new chain_report();
														$sql_coustomer=$obj_report_chain->SelectAllByID_Multiple2_Or("checkin_list",array("date"=>date('Y-m-d')),$array_ch,"input_by","1");
													}
													//echo "Work";
												}
												else
												{
													//echo "Not Work";
													$sql_coustomer="";
												}
											}
											else
											{
												if(isset($_GET['from']))
												{
													include('class/report_customer.php');	
													$obj_report = new report();
													$sql_coustomer=$obj_report->ReportQuery_Datewise("checkin_list",array("input_by"=>$input_by),$_GET['from'],$_GET['to'],"1");
												}
												elseif(isset($_GET['all']))
												{
													$sql_coustomer=$obj->SelectAllByID("checkin_list",array("input_by"=>$input_by));
												}
												else
												{
													$sql_coustomer=$obj->SelectAllByID_Multiple("checkin_list",array("input_by"=>$input_by,"date"=>date('Y-m-d')));
												}
											}
											
											
											
											
											
											/*if($input_status==1){
                                            $sqlticket = $obj->SelectAll("checkin_list");
											}else{
										$sqlticket=$obj->SelectAllByID("checkin_list",array("input_by"=>$input_by));	
											}*/
                                            $i = 1;
                                            if(!empty($sql_coustomer))
											{
                                                foreach ($sql_coustomer as $ticket):
												if($obj->exists_multiple("checkin_request_ticket",array("checkin_id"=>$ticket->checkin_id))!=0)
												{
													$ticket_device=str_replace(' ','',$ticket->device);
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $i; ?></td>
                                                        <td><a href="view_checkin.php?ticket_id=<?php echo $ticket->checkin_id; ?>"><?php echo $ticket->checkin_id; ?></a></td>

                                                        <td><?php echo $ticket_device; ?>, 
                                                        <?php echo $ticket->model; ?>, 
                                                        <?php echo $ticket->color; ?>, 
                                                        <?php echo $ticket->network; ?></td>
                                                        <td><?php
                                                            echo $ticket->problem;
                                                            $chkx = $obj->exists_multiple("check_user_price", array("ckeckin_id" => $ticket->checkin_id));
                                                            if ($chkx == 0) {
                                                                $estp = $obj->SelectAllByVal("product", "name", $ticket_device . "-" . $ticket->problem, "price_cost");
                                                                if ($estp == '') {
                                                                    $devid = $obj->SelectAllByVal("checkin_request", "checkin_id", $ticket->checkin_id, "device_id");
                                                                    $modid = $obj->SelectAllByVal("checkin_request", "checkin_id", $ticket->checkin_id, "model_id");
                                                                    $probid = $obj->SelectAllByVal("checkin_request", "checkin_id", $ticket->checkin_id, "problem_id");
																	if($input_status==1)
																	{
                                                                    	$pp = $obj->SelectAllByVal3("checkin_price", "checkin_id", $devid, "checkin_version_id", $modid, "checkin_problem_id", $probid,"name");
																	}
																	else
																	{
																		$pp = $obj->SelectAllByVal4("checkin_price", "checkin_id", $devid, "checkin_version_id", $modid, "checkin_problem_id",$probid,"store_id",$input_by,"name");
																	}
                                                                } else {
                                                                    $pp = $estp;
                                                                }
                                                            } else {

                                                                $estp = $obj->SelectAllByVal("check_user_price", "ckeckin_id", $ticket->checkin_id, "price");
                                                                if ($estp == '') {
                                                                    $devid = $obj->SelectAllByVal("checkin_request", "checkin_id", $ticket->checkin_id, "device_id");
                                                                    $modid = $obj->SelectAllByVal("checkin_request", "checkin_id", $ticket->checkin_id, "model_id");
                                                                    $probid = $obj->SelectAllByVal("checkin_request", "checkin_id", $ticket->checkin_id, "problem_id");
																	if($input_status==1)
																	{
                                                                    	$pp = $obj->SelectAllByVal3("checkin_price", "checkin_id", $devid, "checkin_version_id", $modid, "checkin_problem_id", $probid, "name");
																	}
																	else
																	{
																		$pp = $obj->SelectAllByVal4("checkin_price", "checkin_id", $devid, "checkin_version_id", $modid, "checkin_problem_id",$probid,"store_id",$input_by,"name");	
																	}
                                                                } else {
                                                                    $pp = $estp;
                                                                }
                                                            }
															if($input_status==1)
															{
                                                           		$pid = $obj->SelectAllByVal("product", "name", $ticket_device . ", " . $ticket->model . " - " . $ticket->problem, "id");
															}
															else
															{
																$pid = $obj->SelectAllByVal2("product", "name", $ticket_device . ", " . $ticket->model . " - " . $ticket->problem,"store_id",$input_by, "id");
															}
															//$pin = $obj->SelectAllByVal("product", "name", $ticket_device . ", " . $ticket->model . " - " . $ticket->problem, "name");
                                                            $cid=$obj->SelectAllByVal2("coustomer","firstname",$obj->SelectAllByVal("checkin_request","checkin_id",$ticket->checkin_id,"first_name"),"phone",$obj->SelectAllByVal("checkin_request","checkin_id",$ticket->checkin_id,"phone"),"id");
				$chkcheckin=$obj->exists_multiple("pos_checkin",array("checkin_id"=>$ticket->checkin_id));
				$getsales_id=$obj->SelectAllByVal("pos_checkin","checkin_id",$ticket->checkin_id,"invoice_id");
				$curcheck=$obj->exists_multiple("sales",array("sales_id"=>$getsales_id));
				$invoice_status=$obj->exists_multiple("invoice",array("invoice_id"=>$getsales_id,"status"=>3));															                                                            ?></td>

                                                        <td>
                                                        <?php if($curcheck==0){ ?>
                                                        <a class="btn btn-info" href="pos.php?newsales=1&amp;pid=<?php echo $pid; ?>&amp;price=<?php echo number_format($pp,2); ?>&amp;checkin_id=<?php echo $ticket->checkin_id; ?>&AMP;cid=<?php echo $cid; ?>">$<?php
																if ($pp == '' || $pp == 0) {
																	echo 0;
																} else {
																	echo number_format($pp,2);
																}
                                                            ?> Send To Pos</a>
                                                            <?php 
															}else{ 
							$expaidamountquery=$obj->SelectAllByID_Multiple("invoice_payment",array("invoice_id"=>$getsales_id));
							$expaid=0;
							if(!empty($expaidamountquery))
							foreach($expaidamountquery as $paidamount):
								$expaid+=$paidamount->amount;
							endforeach;
																if($expaid<$pp && $invoice_status==1)
																{
																	$duepp=$pp-$expaid;
																	?>
																	<a href="pos_make_new_cart.php?cart_id=<?php echo $getsales_id; ?>" class="btn btn-warning">$<?php echo $duepp; ?> Send To POS</a>
																	<?php 
																}
																else
																{
																	?>
																	<span class="label label-info">$<?php
																	if ($pp == '' || $pp == 0) {
																		echo 0;
																	} else {
																		echo number_format($pp,2);
																	}
																	?> Paid</span>
																	<?php 
																}
															}
															?>
                                                            </td>
                                                        <td><?php echo $obj->duration($ticket->date, date('Y-m-d')); //echo $pin; ?></td>
                                                        <td>
														<?php 
														if($invoice_status==1)
														{
															echo checkin_paid(33);
															
														}
														else
														{
															echo checkin_paid($curcheck);
														}
														 ?>
                                                        </td>
                                                        <td>
                                                        <a href="<?php echo $obj->filename(); ?>?action=pdf&amp;invoice=<?php echo $ticket->checkin_id; ?>&amp;payment_status=<?php 
														if($invoice_status==1)
														{
														echo "Partial"; 
														}
														else
														{
														echo checkin_paid2($curcheck); 	
														}
														?>" target="_blank" class="hovertip" title="Print"  onclick="javascript:return confirm('Are you absolutely sure to Print This Checkin Request ?')"><i class="icon-print"></i></a>
                                                        
                                                        <?php if($input_status==1 || $input_status==2 || $input_status==5){ ?>
<a href="<?php echo $obj->filename(); ?>?del=<?php echo $ticket->id; ?>" title="Delete" onclick="javascript:return confirm('Are you absolutely sure to delete This?')"><i class="icon-trash"></i></a>
        												<?php } ?>    
                                                        </td>
                                                    </tr>
                                                            <?php 
															$i++;
												}
                                                        endforeach;
											}
                                                    ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /default datatable -->


                                <!-- Content End from here customized -->

							

                                <div class="separator-doubled"></div> 

<a href="<?php echo $obj->filename(); ?>?export=excel"><img src="pos_image/file_excel.png"></a>
                            <a href="<?php echo $obj->filename(); ?>?export=pdf"><img src="pos_image/file_pdf.png"></a> 


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
