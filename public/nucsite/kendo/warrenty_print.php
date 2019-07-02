<?php

include('class/auth.php');
$table = "warrenty";

if (isset($_GET['print_invoice'])) {

    $cart = $_GET['warrenty_id'];
    $string_query = "SELECT 
                    a.id,
                    a.uid,
                    a.warrenty_id,
                    a.type,
                    #retail cost are define here
                     CASE type WHEN 'ticket' THEN (SELECT retail_cost FROM ticket WHERE ticket.ticket_id=a.warrenty_id)
                     ELSE CASE type WHEN 'checkin' THEN (SELECT price FROM check_user_price WHERE check_user_price.ckeckin_id=a.warrenty_id)
                     ELSE 0 END END AS retail_cost,
                    CONCAT(IFNULL(a.warrenty,0),' Days') AS warrenty,

                    #customer info generate from here
                     CASE type WHEN 'ticket' THEN (SELECT concat(firstname,' ',lastname,',',phone,',',IFNULL(address1,'Not Mention')) FROM coustomer WHERE id=(SELECT cid FROM ticket WHERE ticket.ticket_id=a.warrenty_id))
                     ELSE CASE type WHEN 'checkin' THEN (SELECT concat(first_name,' ',last_name,',',phone,', Not Mention') FROM checkin_request WHERE checkin_request.checkin_id=a.warrenty_id)
                     ELSE CASE type WHEN 'unlock' THEN (SELECT concat(firstname,' ',lastname,',',phone,',',IFNULL(address1,'Not Mention')) FROM coustomer WHERE id=(SELECT cid FROM unlock_request WHERE unlock_request.unlock_id=a.warrenty_id))
                     ELSE 
                            (SELECT concat(first_name,' ',last_name,',',phone,', Not Mention') FROM checkin_request WHERE checkin_request.checkin_id=a.warrenty_id)
                     END END END AS cid,

                     #description start here
                     CASE type WHEN 'ticket' THEN 

                            (SELECT concat(title,' ,Problem - ',pt.name) FROM ticket LEFT JOIN problem_type as pt on pt.id=ticket.problem_type WHERE ticket.ticket_id=a.warrenty_id)

                    ELSE CASE type WHEN 'checkin' THEN (SELECT concat(c.name,',',cv.name,',',cvc.name,',',cn.name,', Problem - ',cp.name)  FROM `checkin_request` as aa 
                        LEFT JOIN checkin as c ON c.id=aa.device_id 
                        LEFT JOIN checkin_version as cv ON cv.id=aa.model_id 
                        LEFT JOIN checkin_version_color as cvc ON cvc.id=aa.color_id 
                        LEFT JOIN checkin_network as cn ON cn.id=aa.network_id
                        LEFT JOIN checkin_problem as cp ON cp.id=aa.problem_id WHERE aa.checkin_id=a.warrenty_id)
                     ELSE CASE type WHEN 'unlock' THEN 'Not Mention'
                     ELSE 'Not Mention'
                     END END END AS description,

                    #ticket_checkin start here
                     CASE type WHEN 'ticket' THEN 

                            (SELECT concat(imei,',',carrier,',',pt.name) FROM ticket 
                    LEFT JOIN problem_type as pt on pt.id=ticket.problem_type WHERE ticket.ticket_id=a.warrenty_id)

                    ELSE CASE type WHEN 'checkin' THEN (SELECT concat(c.name,',',cv.name,',',cvc.name,',',cn.name,', Problem - ',cp.name)  FROM `checkin_request` as aa 
                        LEFT JOIN checkin as c ON c.id=aa.device_id 
                        LEFT JOIN checkin_version as cv ON cv.id=aa.model_id 
                        LEFT JOIN checkin_version_color as cvc ON cvc.id=aa.color_id 
                        LEFT JOIN checkin_network as cn ON cn.id=aa.network_id
                        LEFT JOIN checkin_problem as cp ON cp.id=aa.problem_id WHERE aa.checkin_id=a.warrenty_id)
                     ELSE CASE type WHEN 'unlock' THEN 'Not Mention'
                     ELSE 'Not Mention'
                     END END END AS ct_description,

                    a.note,
                    a.access_id,
                    a.date,
                    a.status,
                    DATEDIFF(CURDATE(),a.date) as `daysgone`,
                    CONCAT(IFNULL((a.warrenty-DATEDIFF(CURDATE(),a.date)),0),' Days') as `warrenty_left`,
                    s.name as rname,
                    s.address as raddress,
                    s.phone as rphone,
                    s.email as remail,
                    s.fotter as rfotter,
                    store.name as sales_rep
                    FROM `warrenty` as a                    
                    LEFT JOIN setting_report as s on s.store_id='5'
                    LEFT JOIN store as store on store.id=a.access_id
                    WHERE 
                    a.warrenty_id='".$cart."'";
    $sqldetail=$obj->FlyQuery($string_query);
    $creator = $sqldetail[0]->uid;
    $pt = "Cash";
    $ckid = $cart;
    $tax_statuss = 0;
    if ($tax_statuss == 0) {
        $taxs = 0;
    } else {
        $taxs = 0;
    }

    include("pdf/MPDF57/mpdf.php");
    extract($_GET);
    $html.="<table id='sample-table-2' class='table table-hover' border='1'><tbody>";

    $report_cpmpany_name = $sqldetail[0]->rname;
    $report_cpmpany_address = $sqldetail[0]->raddress;
    $report_cpmpany_phone = $sqldetail[0]->rphone;
    $report_cpmpany_email = $sqldetail[0]->remail;
    $report_cpmpany_fotter = $sqldetail[0]->rfotter;

    function limit_words($string, $word_limit) {
        $words = explode(" ", $string);
        return implode(" ", array_splice($words, 0, $word_limit));
    }

    $addressfline = limit_words($report_cpmpany_address, 3);
    $lengthaddress = strlen($addressfline);
    $lastaddress = substr($report_cpmpany_address, $lengthaddress, 30000);


    $html .="<tr>
			<td style='height:40px; background:rgba(0,51,153,1);'>
				<table style='width:100%; height:40px; border:0px;'>
					<tr>
						<td width='87%' style='background:rgba(0,51,153,1);  color:#FFF; font-size:25px;'>" . $report_cpmpany_name . " : Warranty Exchange</td><td width='13%' style='background:rgba(0,51,153,1);  color:#FFF; font-size:30px;'><span style='float:left; text-align:left;'>Invoice</span></td>
					</tr>
				</table>
			</td>
		  </tr>
		  <tr>
			<td style='height:40px;' valign='top'>
				<table style='width:960px; height:40px; font-size:12px; border:0px;'>
					<tr>
						<td width='69%'>
						" . $addressfline . "<br>
						" . $lastaddress . "
						</td>
						<td width='31%'>
						DIRECT ALL INQUIRIES TO:<br />
						" . $report_cpmpany_name . "<br />
						" . $report_cpmpany_phone . "<br />
						" . $report_cpmpany_email . "<br />
						</td>
					</tr>
				</table>
			</td>
		  </tr>
		  <tr>
			<td style='height:30px;' valign='top'>
				<table style='width:100%; height:40px; border:0px; font-size:18px;'>
					<tr>
						<td> Warranty From: </td>
					</tr>
				</table>
			</td>
		  </tr>
		  <tr>
			<td style='height:40px;' valign='top'>";
    $type = $sqldetail[0]->type;
    if ($type == "ticket") {
        $cid = explode(",",$sqldetail[0]->cid);
        $html .="<table style='width:960px; height:40px; border:0px;'>
	<tr>
		<td width='69%'>
		Name : " . $cid[0] . "<br />
		Address : " . $cid[2] . "<br />
		City, State, Zip : " . $cid[2] . "<br />
		Phone : " . $cid[1] . "<br />
		</td>
	</tr>
</table>";
    } elseif ($type == "checkin") {
        $cid = explode(",",$sqldetail[0]->cid);
        $html .="<table style='width:960px; height:40px; border:0px;'>
	<tr>
		<td width='69%'>
		Name : " . $cid[0] . "<br />
		Address : " . $cid[2] . "<br />
		City, State, Zip : " . $cid[2] . "<br />
		Phone : " . $cid[1] . "<br />
		</td>
	</tr>
</table>";
    } elseif ($type == "unlock") {
        $cid = explode(",",$sqldetail[0]->cid);
        $html .="<table style='width:960px; height:40px; border:0px;'>
	<tr>
		<td width='69%'>
		Name : " . $cid[0] . "<br />
		Email : " . $cid[2] . "<br />
		Phone : " . $cid[1] . "<br />
		</td>
	</tr>
</table>";
    }
    $html .="</td>
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
						INVOICE DATE  : " . $sqldetail[0]->date . "<br />
						ORDER NO. : " . $cart . "<br />
						SALES REP : " . $sqldetail[0]->sales_rep . "<br />
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
						<td>Quantity</td>
						<td>Description</td>
						<td>Reason</td>
						<td>Warrenty</td>
					</tr></thead>";
    $html.="<thead><tr>
						<td>1.</td>
						<td>1</td>
						<td>";
    $html.=$sqldetail[0]->description;
    $html.="</td>
						 <td>" . $sqldetail[0]->note . "</td>
						<td>" . $sqldetail[0]->warrenty . "</td>
					</tr></thead>";

    $pp = "Cash";


    $due = 0;
    $html.="</table></td></tr>";

    $html.="<tr><td><table style='width:960px;'>
					<thead>
						<tr>
							<td width='350' valign='top'>";
    if ($type == "ticket") {
        $ct_desc = explode(",",$sqldetail[0]->ct_description);
        $html.="<table style='width:300px;border:1px; margin-left:-4px; font-size:12px; background:#ccc;'>
					<thead>
						<tr>
							<th>IMEI : </th>
							<th>" . $ct_desc[0] . "</th>
						</tr>
						<tr>
							<th>Carrier :  </th>
							<th>" . $ct_desc[1] . "</th>
						</tr>
						<tr>
							<th>Problem:  </th>
							<th>" . $ct_desc[2] . "</th>
						</tr>
					</thead>
				</table>";
    } elseif ($type == "checkin") {
        $ct_desc = explode(",",$sqldetail[0]->ct_description);
        $html.="<table style='width:300px;border:1px; margin-left:-4px; font-size:12px; background:#ccc;'>
					<thead>
						<tr>
							<th>IMEI : </th>
							<th>" . $ct_desc[0] . "</th>
						</tr>
						<tr>
							<th>Color :  </th>
							<th>" . $ct_desc[1] . "</th>
						</tr>
						<tr>
							<th>Device:  </th>
							<th>" . $ct_desc[2] . "</th>
						</tr>
						<tr>
							<th>Model:  </th>
							<th>" . $ct_desc[3] . "</th>
						</tr>
						<tr>
							<th>Problem:  </th>
							<th>" . $ct_desc[4] . "</th>
						</tr>
					</thead>
				</table>";
    }

    $html.="</td>
				<td>
					
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
    $html.="<tr>
			<td align='center' style='font-size:8px;'>" . $report_cpmpany_fotter . "</td>
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
?>