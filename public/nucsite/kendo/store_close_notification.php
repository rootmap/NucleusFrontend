<?php 
include('class/db_Class.php');	
$obj = new db_class();

$sqlstorelist=$obj->SelectAll("setting_report");
if(!empty($sqlstorelist))
foreach($sqlstorelist as $list):
	
	$obj->update("setting_report",array("store_id"=>$list->store_id,"last_email_store_date"=>date('Y-m-d')));
$report_cpmpany_name=$obj->SelectAllByVal("setting_report","store_id",$list->store_id,"name");
$report_cpmpany_address=$obj->SelectAllByVal("setting_report","store_id",$list->store_id,"address");
$report_cpmpany_phone=$obj->SelectAllByVal("setting_report","store_id",$list->store_id,"phone");
$report_cpmpany_email=$obj->SelectAllByVal("setting_report","store_id",$list->store_id,"email");

	//$to=$report_cpmpany_email;
	$TO=array("f.bhuyian@gmail.com",$report_cpmpany_email);
	$sender =$report_cpmpany_name;
	$subject="NucleusPos Store Closing Report";
	$user_email=$email;
	$message = '<!DOCTYPE HTML><head><meta http-equiv="content-type" content="text/html">
	<title>NucleusPos Store Closing Report</title>';
	 $message .= "</head>";
	 $message .= "<body>";
	 

   $message .= "<style type='text/css'>
	 .email_table {
	margin:0px;padding:0px;
	width:100%;
	height:auto;
	clear:both;
	border:1px solid #0057af;
	
	-moz-border-radius-bottomleft:0px;
	-webkit-border-bottom-left-radius:0px;
	border-bottom-left-radius:0px;
	
	-moz-border-radius-bottomright:0px;
	-webkit-border-bottom-right-radius:0px;
	border-bottom-right-radius:0px;
	
	-moz-border-radius-topright:0px;
	-webkit-border-top-right-radius:0px;
	border-top-right-radius:0px;
	
	-moz-border-radius-topleft:0px;
	-webkit-border-top-left-radius:0px;
	border-top-left-radius:0px;
}.email_table table{
    border-collapse: collapse;
        border-spacing: 0;
	width:100%;
	margin:0px;padding:0px;
}.email_table tr:last-child td:last-child {
	-moz-border-radius-bottomright:0px;
	-webkit-border-bottom-right-radius:0px;
	border-bottom-right-radius:0px;
}
.email_table table tr:first-child td:first-child {
	-moz-border-radius-topleft:0px;
	-webkit-border-top-left-radius:0px;
	border-top-left-radius:0px;
}
.email_table table tr:first-child td:last-child {
	-moz-border-radius-topright:0px;
	-webkit-border-top-right-radius:0px;
	border-top-right-radius:0px;
}.email_table tr:last-child td:first-child{
	-moz-border-radius-bottomleft:0px;
	-webkit-border-bottom-left-radius:0px;
	border-bottom-left-radius:0px;
}.email_table tr:hover td{
	background-color:#d3e9ff;
		

}
.email_table td{
	vertical-align:middle;
	
	background-color:#ffffff;

	border:1px solid #0057af;
	border-width:0px 1px 1px 0px;
	text-align:left;
	padding:7px;
	font-size:10px;
	font-family:Arial;
	font-weight:normal;
	color:#000000;
}.email_table tr:last-child td{
	border-width:0px 1px 0px 0px;
}.email_table tr td:last-child{
	border-width:0px 0px 1px 0px;
}.email_table tr:last-child td:last-child{
	border-width:0px 0px 0px 0px;
}
.email_table tr:first-child td{
		background:-o-linear-gradient(bottom, #0057af 5%, #0057af 100%);	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #0057af), color-stop(1, #0057af) );
	background:-moz-linear-gradient( center top, #0057af 5%, #0057af 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#0057af', endColorstr='#0057af');	background: -o-linear-gradient(top,#0057af,0057af);

	background-color:#0057af;
	border:0px solid #0057af;
	text-align:center;
	border-width:0px 0px 1px 1px;
	font-size:14px;
	font-family:Arial;
	font-weight:bold;
	color:#ffffff;
}
.email_table tr:first-child:hover td{
	background:-o-linear-gradient(bottom, #0057af 5%, #0057af 100%);	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #0057af), color-stop(1, #0057af) );
	background:-moz-linear-gradient( center top, #0057af 5%, #0057af 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#0057af', endColorstr='#0057af');	background: -o-linear-gradient(top,#0057af,0057af);

	background-color:#0057af;
}
.email_table tr:first-child td:first-child{
	border-width:0px 0px 1px 0px;
}
.email_table tr:first-child td:last-child{
	border-width:0px 0px 1px 1px;
}
</style>";

	 $message .="<h3>Your Store Closing Report : Generated Store Closing Reports This Month. From : 1/".date('m/Y')." To ".date('d/m/Y')." </h3>";
	 $message .="<div class='email_table'><table border='1' cellpadding='2' cellspacing='2'>";
	 $message .="<tr>
					<th>#</th>
					<th>Date</th>
					<th>Store</th>
					<th>Total Collection Cash/Credit Card</th>
					<th>Cash Collected (+)</th>
					<th>Credit Card Collected (+)</th>
					<th>Opening Cash (+)</th>
					<th>Opening Credit Card (+)</th>
					<th>Payout (+)(-)</th>  
					<th>BuyBack (-)</th>  
					<th>Tax (-)</th>      
					<th>Current Cash</th>
					<th>Current Credit Card</th>
					<th>Current Total</th>
				</tr>";
	$sqlinvoice = $obj->SelectAllByID("close_store_detail",array("store_id"=>$list->store_id));
	//$record = $obj->exists_multiple("close_store_detail",array("store_id"=>$input_by));
	//$record_label="Total Record Found ( ".$record." )";			
	 $i=1;
    $aa=0; $bb=0;  $cc=0;  $dd=0;  $ee=0;  $ff=0;  $gg=0;  $hh=0;  $ii=0;  $jj=0;  $kk=0;
	$d=0;
    if(!empty($sqlinvoice))
	{
    foreach($sqlinvoice as $invoice):
		if($obj->exists_multiple("email_deliver_store_close",array("fid"=>$invoice->id))==0)
		{
		$aa+=$invoice->total_collection_cash_credit_card;
		$bb+=$invoice->cash_collected_plus;
		$cc+=$invoice->credit_card_collected_plus;
		$dd+=$invoice->opening_cash_plus;
		$ee+=$invoice->opening_credit_card_plus;
		$ff+=$invoice->payout_plus_min;
		$gg+=$invoice->buyback_min;
		$hh+=$invoice->tax_min;
		$ii+=$invoice->current_cash;
		$jj+=$invoice->current_credit_card;
		$kk+=$invoice->current_total; 
		
	$message.="<tr>
				<td>".$i."</td>
				<td>".$invoice->date."</td>
				<td>".$invoice->store_id."</td>
				<td>".$invoice->total_collection_cash_credit_card."</td>
				<td>".$invoice->cash_collected_plus."</td>
				<td>".$invoice->credit_card_collected_plus."</td>
				<td>".$invoice->opening_cash_plus."</td>
				<td>".$invoice->opening_credit_card_plus."</td>
				<td>".$invoice->payout_plus_min."</td>
				<td>".$invoice->buyback_min."</td>
				<td>".$invoice->tax_min."</td>
				<td>".$invoice->current_cash."</td>
				<td>".$invoice->current_credit_card."</td>
				<td>".$invoice->current_total."</td>
			</tr>";
			$obj->insert("email_deliver_store_close",array("fid"=>$invoice->id,"date"=>date('Y-m-d'),"status"=>1));
			$d+=1;
			
	$i++; 
		}
		else
		{
			$message.="<tr>
				<td colspan='14'>No Store Closing Report Found</td>
			</tr>";
		}
	endforeach;
	}
	else
	{
		$message.="<tr>
				<td colspan='14'>No Store Closing Report Found</td>
			</tr>";
	}
	$message .="<tr>
					<th>#</th>
					<th>Date</th>
					<th>Store</th>
					<th>Total Collection Cash/Credit Card</th>
					<th>Cash Collected (+)</th>
					<th>Credit Card Collected (+)</th>
					<th>Opening Cash (+)</th>
					<th>Opening Credit Card (+)</th>
					<th>Payout (+)(-)</th>  
					<th>BuyBack (-)</th>  
					<th>Tax (-)</th>      
					<th>Current Cash</th>
					<th>Current Credit Card</th>
					<th>Current Total</th>
				</tr>"; 
	 $message .="</table></div>";
	 
	 $message .="<div class='email_table'><table border='0' width='250' style='width:200px;'>
					<tbody>
						<tr>
							<td colspan='2'> Total Store Closing Report </td>
						</tr>
						<tr>
							<td>1. Total Report Found = </td>
							<td><strong> ".$dr."</strong></td>
						</tr>
						<tr>
							<td>2. Total Collection Cash/Credit Card = </td>
							<td><strong> $".number_format($aa,2)."</strong></td>
						</tr>
						<tr>
							<td>3. Cash Collected (+) = </td>
							<td><strong> $".number_format($bb,2)."</strong></td>
						</tr>
						<tr>
							<td>4. Credit Card Collected (+) = </td>
							<td><strong> $".number_format($cc,2)."</strong></td>
						</tr>
						<tr>
							<td>5. Opening Cash (+) = </td>
							<td><strong> $".number_format($dd,2)."</strong></td>
						</tr>
						<tr>
							<td>6. Opening Credit Card (+) = </td>
							<td><strong> $".number_format($ee,2)."</strong></td>
						</tr>
						<tr>
							<td>7. Payout (+)(-) = </td>
							<td><strong> $".number_format($ff,2)."</strong></td>
						</tr>
						<tr>
							<td>8. BuyBack (-) = </td>
							<td><strong> $".number_format($gg,2)."</strong></td>
						</tr>
						<tr>
							<td>9. Tax (-) = </td>
							<td><strong> $".number_format($hh,2)."</strong></td>
						</tr>
						<tr>
							<td>10. Current Cash = </td>
							<td><strong> $".number_format($ii,2)."</strong></td>
						</tr>
						<tr>
							<td>11. Current Credit Card = </td>
							<td><strong> $".number_format($jj,2)."</strong></td>
						</tr>
						<tr>
							<td>12. Current Total = </td>
							<td><strong> $".number_format($kk,2)."</strong></td>
						</tr>
					</tbody>
				</table></div>";
	 
	
	$message .= "</body>";
	$message .= "</html>";

	$headers  = "From: " . $sender . "\r\n";
	$headers .= "Reply-To: ". $user_email . "\r\n";
	//$headers .= "CC: \r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	//@mail($to,$subject,$message, $headers);
	
	$emo=0;
	if(!empty($TO))
	foreach($TO as $em):
			$se=mail($em,$subject,$message,$headers);
			if($se)
			{
					$emo+=1;
			}
			else
			{
					$emo+=0;	
			}
	endforeach;
	
endforeach;	
exit();
?>