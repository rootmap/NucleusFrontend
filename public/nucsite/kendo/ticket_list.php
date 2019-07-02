<?php
include('class/auth.php');
if (isset($_GET['del'])) {
    $obj->deletesing("id", $_GET['del'], "ticket");
}

if (isset($_GET['actionpos'])) {
    $cart = $_GET['invoice'];

    $basicinfoq = $obj->FlyQuery("select 
    a.id,
    a.ticket_id,
    a.uid,
    a.cid,
    a.access_id,
    IFNULL(i.payment_type,0) as payment_type,
    a.ticket_id as checkin_id,
    IFNULL(ts.status,0) as `status`,
    IFNULL(t.tax,0) as tax,
    sr.name,
    sr.address,
    sr.phone,
    sr.email,
    sr.fotter,
    c.firstname,
    c.phone,
    IFNULL(i.invoice_date,a.date) as invoice_date,
    s.name as sales_rep,
    a.imei,
    a.carrier,
    a.type_color,
    pt.name as problem_type,
    pt.name as problem,
    a.carrier as network, 
    a.type_color as color
    from ticket as a 
    LEFT JOIN (SELECT invoice_id,payment_type,invoice_date FROM invoice) as i on i.invoice_id=a.ticket_id
    LEFT JOIN (SELECT store_id,`status` FROM tax_status) as ts on ts.store_id=a.uid
    LEFT JOIN (SELECT store_id,tax FROM tax) as t on t.store_id=a.uid
    LEFT JOIN setting_report as sr on sr.store_id=a.uid 
    LEFT JOIN coustomer as c on c.id=a.cid
    LEFT JOIN store as s on s.id=a.access_id
    LEFT JOIN problem_type as pt on pt.id=a.problem_type 
    WHERE a.ticket_id='" . $cart . "'");

    $cid = $basicinfoq[0]->cid;
    $creator = $basicinfoq[0]->uid;
    $access_ids = $basicinfoq[0]->access_id;

    $pt = $basicinfoq[0]->payment_type;
    $ckid = $basicinfoq[0]->checkin_id;
    $tax_statuss = $basicinfoq[0]->status;
    if ($tax_statuss == 0) {
        $taxs = 0;
    } else {
        $taxs = $basicinfoq[0]->tax;
    }
    include("pdf/MPDF57/mpdf.php");
    $html.="<table id='sample-table-2' class='table table-hover'><tbody>";

    $report_cpmpany_name = $basicinfoq[0]->name;
    $report_cpmpany_address = $basicinfoq[0]->address;
    $report_cpmpany_phone = $basicinfoq[0]->phone;
    $report_cpmpany_email = $basicinfoq[0]->email;
    $report_cpmpany_fotter = $basicinfoq[0]->fotter;

    function limit_words($string, $word_limit) {
        $words = explode(" ", $string);
        return implode(" ", array_splice($words, 0, $word_limit));
    }

    $addressfline = limit_words($report_cpmpany_address, 3);
    $lengthaddress = strlen($addressfline);
    $lastaddress = substr($report_cpmpany_address, $lengthaddress, 30000);




    $ckid = $cart;
    $html.="<tr>
                    <td align='center'><img src='class/barcode/test_1D.php?text=" . $cart . "' style='margin-top:-20px;' alt='barcode' height='65' /> </td>
                    </tr>";
    $html.="<tr><td>";
    if ($obj->exists_multiple("checkin_request_ticket", array("checkin_id" => $ckid)) == 0) {
        $html.="<table class='table table-bordered' cellpadding='1' cellspacing='1' style='border:1px; width:600px'>
					<thead>
						<tr>
							<th>IMEI of Device being repair : </th>
                                                        </tr><tr>
							<td>" . $basicinfoq[0]->imei . "</td>
                                                        </tr>
                                                        <tr>
                                                        <th>Customer Name: </th>
                                                        </tr>
                                                        <tr>
                                                        <td>" . $basicinfoq[0]->firstname . " </td>
                                                        </tr>
                                                        <tr>
                                                        <th>Customer Phone: </th>
                                                        </tr>
                                                        <tr>
                                                        <td>" . $basicinfoq[0]->phone . " </td>
                                                        </tr>
                                                        <tr>
							<th>Carrier :  </th>
                                                        </tr><tr>
							<td>" . $basicinfoq[0]->carrier . "</td>
						</tr>
						<tr>
							<th>Color :  </th>
                                                        </tr><tr>
							<td>" . $basicinfoq[0]->type_color . "</td>
						</tr>
						<tr>
							<th>Problem :  </th>
                                                        </tr><tr>
							<td>" . $basicinfoq[0]->problem_type . "</td>
						</tr>
					</thead>
				</table>";
    } else {
        $html.="<table class='table table-bordered' cellpadding='1' cellspacing='1' style='border:1px; width:600px'>
					<thead>
						<tr>
							<th>IMEI of Device being repair: </th>
                                                        </tr><tr>
							<td>" . $basicinfoq[0]->imei . "</td>
						</tr>
                                                <tr>
                                                        <th>Customer Name: </th>
                                                        </tr>
                                                        <tr>
                                                        <td>" . $basicinfoq[0]->firstname . " </td>
                                                        </tr>
                                                        <tr>
                                                        <th>Customer Phone: </th>
                                                        </tr>
                                                        <tr>
                                                        <td>" . $basicinfoq[0]->phone . " </td>
                                                        </tr>
						<tr>
							<th>Carrier:  </th>
                                                        </tr><tr>
							<td>" . $basicinfoq[0]->network . "</td>
						</tr>
						<tr>
							<th>Color:  </th>
                                                        </tr><tr>
							<td>" . $basicinfoq[0]->color . "</td>
						</tr>
						<tr>
							<th>Problem:  </th>
                                                        </tr><tr>
							<td>" . $basicinfoq[0]->problem . "</td>
						</tr>
					</thead>
				</table>";
    }

    $html.="</td>
		  </tr>";




    $html.="<tr>
			<td align='center'>Thank You For Your Business</td>
		  </tr>";

    if ($_GET['payment_status'] == "Paid") {
        $color = "#09f;";
    } elseif ($_GET['payment_status'] == "Partial") {
        $color = "#FF8C00;";
    } else {
        $color = "#f00";
    }

    $html.="<tr><td align='center' style='color:" . $color . "'><h1 style='width:60%; font-size:40px; display:block; margin-left:auto; margin-right:auto; border:3px " . $color . " solid;'>" . $_GET['payment_status'] . "</h1></td></tr>";

    $html.="</tbody></table>";

    $possetting = $obj->FlyQuery("SELECT * FROM `pos_print_setting` WHERE store_id='" . $input_by . "'");
    if (empty($possetting[0]->bar_width)) {
        $pw = "150";
    } else {
        $pw = $possetting[0]->bar_width;
    }

    if (empty($possetting[0]->bar_height)) {
        $ph = "230";
    } else {
        $ph = $possetting[0]->bar_height;
    }
    $mpdf = new mPDF('utf-8', array($pw, $ph));
    $mpdf->SetDisplayMode('fullpage');
    $mpdf->list_indent_first_level = 0;
    $stylesheet = file_get_contents('pdf/MPDF57/examples/mpdfstyletables.css');
    $mpdf->WriteHTML($stylesheet, 1);
    $mpdf->WriteHTML($html, 2);
    $mpdf->Output('mpdf.pdf', 'I');
    exit();
}

function checkin_paid($st) {
    if ($st == 0) {
        return "Unpaid";
    } else {
        return "Paid";
    }
}

if (@$_GET['export'] == "excel") {


    $record_label = "Ticket List Report";
    header('Content-type: application/excel');
    $filename = "Ticket_list_" . date('Y_m_d') . '.xls';
    header('Content-Disposition: attachment; filename=' . $filename);

    $data = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">
<head>
    <!--[if gte mso 9]>
    <xml>
        <x:ExcelWorkbook>
            <x:ExcelWorksheets>
                <x:ExcelWorksheet>
                    <x:Name>Ticket List : Wireless Geeks Inc.</x:Name>
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
    $data .="<h3>" . $record_label . "</h3>";
    $data .="<h5>Ticket List Generate Date : " . date('d-m-Y H:i:s') . "</h5>";

    $data .="<table>
    <thead>
        <tr style='background:#09f; color:#fff;'>
			<th>#</th>
			<th>Ticket ID</th>
			<th>Subject</th>
			<th>Created</th>
			<th>Status</th>
			<th>Problem type</th>
			<th>Last Updated</th>
			<th>Send To POS</th>
			<th>Paid</th>
		</tr>
</thead>        
<tbody>";


    if ($input_status == 1) {
        $sqlticket = $obj->SelectAll("ticket");
    } elseif ($input_status == 5) {

        $sqlchain_store_ids = $obj->SelectAllByID("store_chain_admin", array("sid" => $input_by));
        if (!empty($sqlchain_store_ids)) {
            $array_ch = array();
            foreach ($sqlchain_store_ids as $ch):
                array_push($array_ch, $ch->store_id);
            endforeach;

            include('class/report_chain_admin.php');
            $obj_report_chain = new chain_report();
            $sqlticket = $obj_report_chain->SelectAllByID_Multiple_Or("ticket", $array_ch, "input_by", "1");
        }
        else {
            //echo "Not Work";
            $sqlticket = "";
        }
    } else {
        $sqlticket = $obj->SelectAllByID("ticket", array("input_by" => $input_by));
    }

    $i = 1;
    if (!empty($sqlticket))
        foreach ($sqlticket as $ticket):

            $data.="<tr>
				<td>" . $i . "</td>
				<td>" . $ticket->ticket_id . "</td>
				<td>" . $ticket->title . "</td>
				<td>" . $ticket->date . "</td>
				<td>" . $obj->ticket_status($ticket->status) . "</td>
				<td>" . $obj->SelectAllByVal("problem_type", "id", $ticket->problem_type, "name") . "</td>
				<td>" . $obj->CountDate($ticket->date) . "</td>";

            $product_name = $ticket->title . " - " . $ticket->ticket_id;
            $chkx = $obj->exists_multiple("product", array("name" => $product_name));
            if ($chkx != 0) {
                $pid = $obj->SelectAllByVal("product", "name", $product_name, "id");
                $price = $obj->SelectAllByVal("product", "name", $product_name, "price_retail");
            } else {
                $pid = 0;
                $price = 0;
            }
            $chkcheckin = $obj->exists_multiple("invoice", array("doc_type" => 3, "checkin_id" => $ticket->ticket_id));
            $getsales_id = $obj->SelectAllByVal("invoice", "checkin_id", $ticket->ticket_id, "invoice_id");
            $curcheck = $obj->exists_multiple("sales", array("sales_id" => $getsales_id));

            if ($curcheck == 0) {
                $data.="<td>" . $price . " Send To Pos</td>";
            } else {
                $data.="<td>" . $price . " Paid</td>";
            }

            $data.="<td>" . checkin_paid($curcheck) . "</td></tr>";
            $i++;
        endforeach;

    $data .="</tbody><tfoot><tr>
			<th>#</th>
			<th>Ticket ID</th>
			<th>Subject</th>
			<th>Created</th>
			<th>Status</th>
			<th>Problem type</th>
			<th>Last Updated</th>
			<th>Send To POS</th>
			<th>Paid</th>
		</tr></tfoot></table>";

    $data .='</body></html>';

    echo $data;
}

if (@$_GET['export'] == "pdf") {
    $record_label = "Ticket List Report";
    include("pdf/MPDF57/mpdf.php");
    extract($_GET);
    $html.="<table id='sample-table-2' class='table table-hover' border='0'><tbody>";
    $html .="<tr>
			<td valign='top' style='margin:0; padding:0; width:100%;'>
				<table style='width:100%; height:40px; border:0px;'>
					<tr>
						<td width='87%' style='background:rgba(0,51,153,1);  color:#FFF; font-size:25px;'>
						Ticket List Report
						</td>
					</tr>
				</table>
				

				<table style='width:100%; height:40px; border:0px; font-size:18px;'>
					<tr>
						<td> Ticket List Generate Date : " . date('d-m-Y H:i:s') . "</td>
					</tr>
				</table>
				<table style='width:960px;border:1px; font-size:12px; background:#ccc;'>";
    $html.="<thead>
        <tr style='background:#09f; color:#fff;'>
			<th>#</th>
			<th>Ticket ID</th>
			<th>Subject</th>
			<th>Created</th>
			<th>Status</th>
			<th>Problem type</th>
			<th>Last Updated</th>
			<th>Send To POS</th>
			<th>Paid</th>
		</tr>
</thead>        
<tbody>";

    if ($input_status == 1) {
        $sqlticket = $obj->SelectAll("ticket");
    } else {
        $sqlticket = $obj->SelectAllByID("ticket", array("input_by" => $input_by));
    }

    $i = 1;
    if (!empty($sqlticket))
        foreach ($sqlticket as $ticket):

            $html.="<tr>
				<td>" . $i . "</td>
				<td>" . $ticket->ticket_id . "</td>
				<td>" . $ticket->title . "</td>
				<td>" . $ticket->date . "</td>
				<td>" . $obj->ticket_status($ticket->status) . "</td>
				<td>" . $obj->SelectAllByVal("problem_type", "id", $ticket->problem_type, "name") . "</td>
				<td>" . $obj->CountDate($ticket->date) . "</td>";

            $product_name = $ticket->title . " - " . $ticket->ticket_id;
            $chkx = $obj->exists_multiple("product", array("name" => $product_name));
            if ($chkx != 0) {
                $pid = $obj->SelectAllByVal("product", "name", $product_name, "id");
                $price = $obj->SelectAllByVal("product", "name", $product_name, "price_retail");
            } else {
                $pid = 0;
                $price = 0;
            }
            $chkcheckin = $obj->exists_multiple("invoice", array("doc_type" => 3, "checkin_id" => $ticket->ticket_id));
            $getsales_id = $obj->SelectAllByVal("invoice", "checkin_id", $ticket->ticket_id, "invoice_id");
            $curcheck = $obj->exists_multiple("sales", array("sales_id" => $getsales_id));

            if ($curcheck == 0) {
                $html.="<td>" . $price . " Send To Pos</td>";
            } else {
                $html.="<td>" . $price . " Paid</td>";
            }

            $html.="<td>" . checkin_paid($curcheck) . "</td>
			</tr>";
            $i++;
        endforeach;

    $html.="</tbody><tfoot><tr>
			<th>#</th>
			<th>Ticket ID</th>
			<th>Subject</th>
			<th>Created</th>
			<th>Status</th>
			<th>Problem type</th>
			<th>Last Updated</th>
			<th>Send To POS</th>
			<th>Paid</th>
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

    $basicinfoq = $obj->FlyQuery("select 
    a.id,
    a.ticket_id,
    a.uid,
    a.cid,
    a.access_id,
    IFNULL(i.payment_type,0) as payment_type,
    a.ticket_id as checkin_id,
    IFNULL(ts.status,0) as `status`,
    IFNULL(t.tax,0) as tax,
    sr.name,
    sr.address,
    sr.phone,
    sr.email,
    sr.fotter,
    c.firstname,
    c.phone,
    IFNULL(i.invoice_date,a.date) as invoice_date,
    s.name as sales_rep,
    a.imei,
    a.carrier,
    a.type_color,
    pt.name as problem_type,
    pt.name as problem,
    a.carrier as network, 
    a.type_color as color
    from ticket as a 
    LEFT JOIN (SELECT invoice_id,payment_type,invoice_date FROM invoice) as i on i.invoice_id=a.ticket_id
    LEFT JOIN (SELECT store_id,`status` FROM tax_status) as ts on ts.store_id=a.uid
    LEFT JOIN (SELECT store_id,tax FROM tax) as t on t.store_id=a.uid
    LEFT JOIN setting_report as sr on sr.store_id=a.uid 
    LEFT JOIN coustomer as c on c.id=a.cid
    LEFT JOIN store as s on s.id=a.access_id
    LEFT JOIN problem_type as pt on pt.id=a.problem_type 
    WHERE a.ticket_id='" . $cart . "'");

    $cid = $basicinfoq[0]->cid;
    $creator = $basicinfoq[0]->uid;
    $access_ids = $basicinfoq[0]->access_id;

    $pt = $basicinfoq[0]->payment_type;
    $ckid = $basicinfoq[0]->checkin_id;
    $tax_statuss = $basicinfoq[0]->status;
    if ($tax_statuss == 0) {
        $taxs = 0;
    } else {
        $taxs = $basicinfoq[0]->tax;
    }
    include("pdf/MPDF57/mpdf.php");
    $html.="<table id='sample-table-2' class='table table-hover' border='1'><tbody>";

    $report_cpmpany_name = $basicinfoq[0]->name;
    $report_cpmpany_address = $basicinfoq[0]->address;
    $report_cpmpany_phone = $basicinfoq[0]->phone;
    $report_cpmpany_email = $basicinfoq[0]->email;
    $report_cpmpany_fotter = $basicinfoq[0]->fotter;

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
						<td width='87%' style='background:rgba(0,51,153,1);  color:#FFF; font-size:30px;'>" . $report_cpmpany_name . "</td><td width='13%' style='background:rgba(0,51,153,1);  color:#FFF; font-size:30px;'><span style='float:left; text-align:left;'>" . $_GET['payment_status'] . " Invoice</span></td>
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
						Name : " . $basicinfoq[0]->firstname . "<br />
						Phone : " . $basicinfoq[0]->phone . "<br />
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
						INVOICE DATE  : " . $basicinfoq[0]->invoice_date . "<br />
						ORDER NO. : " . $cart . "<br />
						SALES REP : " . $basicinfoq[0]->sales_rep . "<br />
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

    $sqlsaleslist = $obj->SelectAllByID("ticket", array("ticket_id" => $cart));
    $sss = 1;
    $subtotal = 0;
    $curcheck = 0;
    $tax = 0;
    $total = 0;
    $sales_invoice = 0;
    if (!empty($sqlsaleslist))
        foreach ($sqlsaleslist as $saleslist):
            $caltax = ($saleslist->single_cost * $tax_per_product) / 100;
            $procost = $saleslist->quantity * $saleslist->single_cost;
            $subtotal+=$procost;
            $html.="<thead><tr>
						<td>" . $sss . "</td>
						<td>" . $saleslist->ticket_id . "</td>
						<td>" . $saleslist->title . "-" . $obj->SelectAllByVal("problem_type", "id", $saleslist->problem_type, "name") . "</td>";

            $product_name = $saleslist->title . " - " . $saleslist->ticket_id;
            $chkx = $obj->exists_multiple("product", array("name" => $product_name));
            if ($chkx != 0) {
                $pid = $obj->SelectAllByVal("product", "name", $product_name, "id");
                $price = $obj->SelectAllByVal("product", "name", $product_name, "price_retail");
            } else {
                $pid = 0;
                $price = 0;
            }
            $subtotal+=$price;
            $chkcheckin = $obj->exists_multiple("invoice", array("doc_type" => 3, "checkin_id" => $saleslist->ticket_id));
            $getsales_id = $obj->SelectAllByVal("invoice", "checkin_id", $saleslist->ticket_id, "invoice_id");
            $curcheck+=$obj->exists_multiple("sales", array("sales_id" => $getsales_id));
            $priceee = $obj->SelectAllByVal("ticket_list", "ticket_id", $saleslist->ticket_id, "retail_cost");
            $sales_invoice = $getsales_id;
            $caltaxs = ($price * $taxs) / 100;
            $extended = $price + $caltaxs;
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
    $ckid = $cart;
    if ($ckid != 0) {

        $html.="<tr><td><table style='width:960px;'>
					<thead>
						<tr>
							<td width='350' valign='top'>";
        if ($obj->exists_multiple("checkin_request_ticket", array("checkin_id" => $ckid)) == 0) {
            $html.="<table style='width:300px;border:1px; margin-left:-4px; font-size:12px; background:#ccc;'>
					<thead>
						<tr>
							<th>IMEI of Device being repair : </th>
							<th>" . $basicinfoq[0]->imei . "</th>
						</tr>
						<tr>
							<th>Carrier :  </th>
							<th>" . $basicinfoq[0]->carrier . "</th>
						</tr>
						<tr>
							<th>Color :  </th>
							<th>" . $basicinfoq[0]->type_color . "</th>
						</tr>
						<tr>
							<th>Problem :  </th>
							<th>" . $basicinfoq[0]->problem_type . "</th>
						</tr>
					</thead>
				</table>";
        } else {
            $html.="<table style='width:300px;border:1px; margin-left:-4px; font-size:12px; background:#ccc;'>
					<thead>
						<tr>
							<th>IMEI of Device being repair: </th>
							<th>" . $basicinfoq[0]->imei . "</th>
						</tr>
						<tr>
							<th>Carrier:  </th>
							<th>" . $basicinfoq[0]->network . "</th>
						</tr>
						<tr>
							<th>Color:  </th>
							<th>" . $basicinfoq[0]->color . "</th>
						</tr>
						<tr>
							<th>Problem:  </th>
							<th>" . $basicinfoq[0]->problem . "</th>
						</tr>
					</thead>
				</table>";
        }

        $chk_invoice_status = $obj->exists_multiple("invoice", array("invoice_id" => $sales_invoice, "status" => 3));
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
								<th>" . number_format($subtotal, 2) . "</th>
							</tr>
							<tr>
								<th>Tax: </th>
								<th>" . number_format($tax, 2) . "</th>
							</tr>
							<tr>
								<th>Total: </th>
								<th>" . number_format($total, 2) . "</th>
							</tr>";

        if ($chk_invoice_status == 1) {
            $sqlexpaid = $obj->SelectAllByID_Multiple("invoice_payment", array("invoice_id" => $sales_invoice));
            $expaid = 0;
            if (!empty($sqlexpaid))
                foreach ($sqlexpaid as $pd):
                    $expaid+=$pd->amount;
                endforeach;
            $exdue = $total - $expaid;
            $html.="<tr>
								<th>Payments: </th>
								<th>$";
            if ($curcheck == 0) {
                $html.="0";
            } else {
                $html.=number_format($expaid, 2);
            }
            $html.="</th>
							</tr>
							<tr>
								<th>Balance Due: </th>
								<th>$";
            if ($curcheck == 0) {
                $html.=$exdue;
            } else {
                $html.=$exdue;
            }
        } else {
            $html.="<tr>
								<th>Payments: </th>
								<th>$";
            if ($curcheck == 0) {
                $html.="0";
            } else {
                $html.=$total;
            }
            $html.="</th>
							</tr>
							<tr>
								<th>Balance Due: </th>
								<th>$";
            if ($curcheck == 0) {
                $html.=$total;
            } else {
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
								<th>" . number_format($subtotal, 2) . "</th>
							</tr>
							<tr>
								<th>Tax: </th>
								<th>" . number_format($tax, 2) . "</th>
							</tr>
							<tr>
								<th>Total: </th>
								<th>" . number_format($total, 2) . "</th>
							</tr>
							<tr>
								<th>Payments: </th>
								<th>";
        if ($curcheck == 0) {
            $html.="0";
        } else {
            $html.=$total;
        }
        $html.="</th>
							</tr>
							<tr>
								<th>Balance Due: </th>
								<th>";
        if ($curcheck == 0) {
            $html.=$total;
        } else {
            $html.="0";
        }
        $html.="</th>
							</tr>
						</thead></table></td></tr>";
    }



    $html.="<tr>
			<td align='center' style='font-size:8px;'>" . $report_cpmpany_fotter . "</td>
		  </tr>
		  <tr>
			<td align='center'>Thank You For Your Business</td>
		  </tr>";

    if ($_GET['payment_status'] == "Paid") {
        $color = "#09f;";
    } elseif ($_GET['payment_status'] == "Partial") {
        $color = "#FF8C00;";
    } else {
        $color = "#f00";
    }

    $html.="<tr><td align='center' style='color:" . $color . "'><h1 style='width:60%; font-size:100px; display:block; margin-left:auto; margin-right:auto; border:3px " . $color . " solid;'>" . $_GET['payment_status'] . "</h1></td></tr>";

    $html.="</tbody></table>";

    $possetting = $obj->FlyQuery("SELECT * FROM `pos_print_setting` WHERE store_id='" . $input_by . "'");
    if (!empty($possetting[0]->width)) {
        $pw = $possetting[0]->width;
    }

    if (!empty($possetting[0]->height)) {
        $ph = $possetting[0]->height;
    }

    if (!empty($pw) && !empty($ph)) {
        $mpdf = new mPDF('utf-8', array($pw, $ph));
    } else {
        $mpdf = new mPDF('c', 'A4', '', '', 32, 25, 27, 25, 16, 13);
    }
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
        <?php
        include './plugin/plugin.php';
        $cms = new CmsRootPlugin();
        echo $cms->GeneralCss(array("kendo", "modal"));
        ?>
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
                            <h5><i class="icon-bookmark"></i>
                                <span style="border-right:2px #333 solid; padding-right:10px;">Ticket Info</span>
                                <span><i class="font-calendar"></i> <a data-toggle="modal" href="#myModal"> Generate Customer Report</a></span> 
                            </h5>
                            <ul class="icons">
                                <li><a href="<?php echo $obj->filename(); ?>" class="hovertip" title="Reload"><i class="font-refresh"></i></a></li>
                            </ul>
                        </div><!-- /page header -->

                        <div class="body">
                            <!-- Dialog content -->
                            <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h5 id="myModalLabel"><i class="font-calendar"></i> Generate Customer Report <span id="mss"></span></h5>
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
                                </div>
                            <!-- /dialog content -->
                            <!-- Middle navigation standard -->

                            <?php //include('include/quicklink.php');  ?>
                            <!-- /middle navigation standard -->

                            <!-- Content container -->
                            <div class="container">



                                <!-- Content Start from here customized -->

                                <div class="block">
                                    <div class="table-overflow">

                                        <div id="grid" style="margin-left: 10px;margin-right: 10px;"></div>
                                        <script id="checkin_link" type="text/x-kendo-template">
                                            <a href="view_ticket.php?ticket_id=#=ticket_id#">#=ticket_id#</a>
                                        </script>
                                        <script id="checkin_status" type="text/x-kendo-template">
                                            #if (paid == 0)
                                            {#
                                                <label class='label label-danger'>Not Paid</label>
                                            #} else { 
                                                if(paid!=0 && price>paid)
                                                {#
                                                <label class='label label-warning'>Partial</label>
                                                #}
                                                else
                                                {#
                                                <label class='label label-success'>Paid</label>
                                                #}
                                            }#
                                        </script>
                                        <script id="checkin_price" type="text/x-kendo-template">
                                            #if (paid == 0) 
                                            {# 
                                                <a class="btn btn-info" href="pos.php?newsales=1&amp;pid=#=pid#&amp;price=#=price#&amp;checkin_id=#=ticket_id#"><?php echo $currencyicon; ?> #=price# Send To Pos</a> 
                                            #} else { 
                                                if(paid!=0 && price>paid)
                                                {
                                                    #
                                                     <a href="pos_make_new_cart.php?cart_id=#=invoice_id#" class="btn btn-warning"><?php echo $currencyicon; ?> #=price-paid# Send To POS</a>
                                                #}
                                                else
                                                {#
                                                    <span class="label label-info"><?php echo $currencyicon; ?> #=price# Paid</span>
                                                #}
                                            }#
                                        </script>
                                        <script id="edit_client" type="text/x-kendo-template">
                                            <a href="<?php echo $obj->filename(); ?>?action=pdf&amp;invoice=#=ticket_id#&amp;payment_status=#if (paid == 0)
                                            {#Unpaid#} else { 
                                                if(paid!=0 && price>paid)
                                                {#Partial#}
                                                else
                                                {#Paid#}
                                            }#" target="_blank" class="hovertip" title="Print"  onclick="javascript:return confirm('Are you absolutely sure to Print This Checkin Request ?')"><i class="icon-print"></i></a>
                                            <a href="javascript:void(0);" class="hovertip" title="Delete Product" onclick="deleteClick(#=id#)"><i class="icon-trash"></i></a>
                                        </script>
                                        <script type="text/javascript">
                                            function deleteClick(id) {
                                                var c = confirm("Do you want to delete?");
                                                if (c === true) {
                                                    $.ajax({
                                                        type: "POST",
                                                        dataType: "json",
                                                        url: "./controller/ticket_list.php",
                                                        data: {id: id},
                                                        success: function (result) {
                                                            $(".k-i-refresh").click();
                                                        }
                                                    });
                                                }
                                            }

                                        </script>
                                        <?php
                                        $cond = $cms->FrontEndDateSearch('from', 'to');
                                        ?>
                                        <script type="text/javascript">
                                            var gridElement = $("#grid");

                                            function showLoading(e) {
                                                kendo.ui.progress(gridElement, true);
                                            }

                                            function restoreSelection(e) {
                                                kendo.ui.progress(gridElement, false);
                                            }

                                            jQuery(document).ready(function () {

                                                var dataSource = new kendo.data.DataSource({
                                                    requestStart: showLoading,
                                                    transport: {
                                                        read: {
                                                            url: "./controller/ticket_list.php<?php echo $cond; ?>",
                                                            type: "GET",
                                                            datatype: "json"
                                                        }
                                                    },
                                                    autoSync: false,
                                                    schema: {
                                                        data: "data",
                                                        total: "total",
                                                        model: {
                                                            id: "id",
                                                            fields: {
                                                                id: {nullable: true},
                                                                ticket_id: {type: "string"},
                                                                title: {type: "string"},
                                                                problem: {type: "string"},
                                                                price: {type: "string"},
                                                                date: {type: "string"},
                                                                status: {type: "number"},
                                                                paid: {type: "string"},
                                                                pid: {type: "number"}
                                                            }
                                                        }



                                                    },
                                                    pageSize: 10,
                                                    serverPaging: true,
                                                    serverFiltering: true,
                                                    serverSorting: true
                                                });



                                                jQuery("#grid").kendoGrid({
                                                    dataSource: dataSource,
                                                    filterable: true,
                                                    dataBound: restoreSelection,
                                                    pageable: {
                                                        refresh: true,
                                                        input: true,
                                                        numeric: false,
                                                        pageSizes: true,
                                                        pageSizes:[10, 50, 200, 500, 1000, 5000, 10000]
                                                    },
                                                    sortable: true,
                                                    groupable: true,
                                                    columns: [
                                                        {field: "id", title: "S.ID", width: "60px"},
                                                        {title: "Ticket Id", width: "90px",template: kendo.template($("#checkin_link").html())},
                                                        {field: "title", title: "Subject", width: "90px"},
                                                        {field: "date", title: "Created", width: "80px"},
                                                        {field: "problem", title: "Problem", width: "80px"},
                                                        {title: "Ticket Price", width: "90px", template: kendo.template($("#checkin_price").html())},
                                                        {title: "Status", width: "50px",template: kendo.template($("#checkin_status").html())},
                                                        {
                                                            title: "Action", width: "60px",
                                                            template: kendo.template($("#edit_client").html())
                                                        }
                                                    ],
                                                });
                                            });

                                        </script>













                                    </div>
                                </div>

                                <!-- Default datatable -->
                               <?php /* <div class="table-overflow">
                                    <table class="table table-striped" id="data-table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Ticket ID</th>
                                                <th>Subject</th>
                                                <th>Created</th>
                                                <th>Status</th>
                                                <th>Problem type</th>
                                                <th>Last Updated</th>
                                                <th width="150">Send To POS</th>
                                                <th>Paid</th>
                                                <td>Action</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($input_status == 1) {
                                                if (isset($_GET['from'])) {
                                                    $sql_coustomer = $obj->SelectAll_ddate("ticket", "date", $_GET['from'], $_GET['to']);
                                                } elseif (isset($_GET['all'])) {
                                                    $sql_coustomer = $obj->SelectAll("ticket");
                                                } else {
                                                    $sql_coustomer = $obj->SelectAllByID("ticket", array("date" => date('Y-m-d')));
                                                }
                                            } elseif ($input_status == 5) {

                                                $sqlchain_store_ids = $obj->SelectAllByID("store_chain_admin", array("sid" => $input_by));
                                                if (!empty($sqlchain_store_ids)) {
                                                    $array_ch = array();
                                                    foreach ($sqlchain_store_ids as $ch):
                                                        array_push($array_ch, $ch->store_id);
                                                    endforeach;

                                                    if (isset($_GET['from'])) {
                                                        include('class/report_chain_admin.php');
                                                        $obj_report_chain = new chain_report();
                                                        $sql_coustomer = $obj_report_chain->ReportQuery_Datewise_Or("ticket", $array_ch, "input_by", $_GET['from'], $_GET['to'], "1");
                                                    } elseif (isset($_GET['all'])) {
                                                        include('class/report_chain_admin.php');
                                                        $obj_report_chain = new chain_report();
                                                        $sql_coustomer = $obj_report_chain->SelectAllByID_Multiple_Or("ticket", $array_ch, "input_by", "1");
                                                    } else {
                                                        include('class/report_chain_admin.php');
                                                        $obj_report_chain = new chain_report();
                                                        $sql_coustomer = $obj_report_chain->SelectAllByID_Multiple2_Or("ticket", array("date" => date('Y-m-d')), $array_ch, "input_by", "1");
                                                    }
                                                    //echo "Work";
                                                } else {
                                                    //echo "Not Work";
                                                    $sql_coustomer = "";
                                                }
                                            } else {
                                                if (isset($_GET['from'])) {
                                                    include('class/report_customer.php');
                                                    $obj_report = new report();
                                                    $sql_coustomer = $obj_report->ReportQuery_Datewise("ticket", array("input_by" => $input_by), $_GET['from'], $_GET['to'], "1");
                                                } elseif (isset($_GET['all'])) {
                                                    $sql_coustomer = $obj->SelectAllByID("ticket", array("input_by" => $input_by));
                                                } else {
                                                    $sql_coustomer = $obj->SelectAllByID_Multiple("ticket", array("input_by" => $input_by, "date" => date('Y-m-d')));
                                                }
                                            }

                                            $i = 1;
                                            if (!empty($sql_coustomer))
                                                foreach ($sql_coustomer as $ticket):
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $i; ?></td>
                                                        <td><a class="label label-success" href="view_ticket.php?ticket_id=<?php echo $ticket->ticket_id; ?>"><i class="icon-tags"></i> <?php echo $ticket->ticket_id; ?></a></td>
                                                        <!--<td><i class="icon-user"></i> <?php //echo $obj->SelectAllByVal("coustomer","id",$ticket->uid,"firstname")." ".$obj->SelectAllByVal("coustomer","id",$ticket->uid,"lastname");   ?></td>-->
                                                        <td><?php echo $ticket->title; ?></td>
                                                        <td><?php echo $ticket->date; ?></td>

                                                        <td><?php echo $obj->ticket_status($ticket->status); ?></td>
                                                        <td><label class="label label-warning"><i class="icon-tint"></i> <?php echo $obj->SelectAllByVal("problem_type", "id", $ticket->problem_type, "name"); ?></label></td>
                                                        <td><label class="label label-info"><i class="icon-calendar"></i> <?php echo $obj->CountDate($ticket->date); ?></label></td>
                                                        <?php
                                                        $product_name = $ticket->title . " - " . $ticket->ticket_id;
                                                        $chkx = $obj->exists_multiple("product", array("name" => $product_name));
                                                        if ($chkx != 0) {
                                                            $pid = $obj->SelectAllByVal("product", "name", $product_name, "id");
                                                            $price = $obj->SelectAllByVal("product", "name", $product_name, "price_retail");
                                                        } else {
                                                            $pid = 0;
                                                            $price = 0;
                                                        }
                                                        //$chkcheckin=$obj->exists_multiple("invoice",array("doc_type"=>3,"checkin_id"=>$ticket->ticket_id));
                                                        //$getsales_id=$obj->SelectAllByVal("invoice","checkin_id",$ticket->ticket_id,"invoice_id");

                                                        $getsales_id = $obj->SelectAllByVal("pos_checkin", "checkin_id", $ticket->ticket_id, "invoice_id");

                                                        $curcheck = $obj->exists_multiple("sales", array("sales_id" => $getsales_id));
                                                        $invoice_status = $obj->exists_multiple("invoice", array("invoice_id" => $getsales_id, "status" => 3));
                                                        $priceee = $obj->SelectAllByVal("ticket_list", "ticket_id", $ticket->ticket_id, "retail_cost");
                                                        ?>
                                                        <td>
                                                            <?php
                                                            if ($curcheck == 0) {
                                                                if ($price == '') {select 
                                                                    ?>
                                                                    <a href="pos.php?newsales=1&amp;pid=<?php echo $pid; ?>&amp;price=<?php echo $priceee; ?>&AMP;cid=<?php echo $ticket->cid; ?>&amp;checkin_id=<?php echo $ticket->ticket_id; ?>" class="btn btn-success"><i class="font-money"></i> <?php echo @number_format($priceee, 2); ?> To POS</a>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <a href="pos.php?newsales=1&amp;pid=<?php echo $pid; ?>&amp;price=<?php echo $price; ?>&AMP;cid=<?php echo $ticket->cid; ?>&amp;checkin_id=<?php echo $ticket->ticket_id; ?>" class="btn btn-success"><i class="font-money"></i> <?php echo @number_format($price, 2); ?> To POS</a>
                                                                    <?php
                                                                }
                                                            } else {
                                                                $expaidamountquery = $obj->SelectAllByID_Multiple("invoice_payment", array("invoice_id" => $getsales_id));
                                                                $expaid = 0;
                                                                if (!empty($expaidamountquery))
                                                                    foreach ($expaidamountquery as $paidamount):
                                                                        $expaid+=$paidamount->amount;
                                                                    endforeach;
                                                                if ($expaid < $price && $invoice_status == 1) {
                                                                    $duepp = $price - $expaid;
                                                                    ?>
                                                                    <a href="pos_make_new_cart.php?cart_id=<?php echo $getsales_id; ?>" class="btn btn-warning">$<?php echo $duepp; ?> Send To POS</a>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <span class="label label-info">$<?php
                                                                        if ($price == '' || $price == 0) {
                                                                            echo 0;
                                                                        } else {
                                                                            echo number_format($price, 2);
                                                                        }
                                                                        ?> Paid</span>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            if ($invoice_status == 1 && $expaid < $price) {
                                                                ?>
                                                                <span class="label label-warning">Partial</span>
                                                                <?php
                                                            } else {
                                                                echo checkin_paid($curcheck);
                                                            }
                                                            ?> 
                                                        </td>
                                                        <td>
                                                            <a href="<?php echo $obj->filename(); ?>?action=pdf&amp;invoice=<?php echo $ticket->ticket_id; ?>&amp;payment_status=<?php
                                                            if ($invoice_status == 1 && $expaid < $price) {
                                                                ?>Partial<?php
                                                               } else {
                                                                   echo checkin_paid($curcheck);
                                                               }
                                                               ?>" target="_blank" class="hovertip" title="Print"  onclick="javascript:return confirm('Are you absolutely sure to Print This Ticket ?')"><i class="icon-print"></i></a>
                                                               <?php if ($input_status == 1 || $input_status == 2 || $input_status == 5) { ?>
                                                                <a href="<?php echo $obj->filename(); ?>?del=<?php echo $ticket->id; ?>" class="hovertip" title="Delete"  onclick="javascript:return confirm('Are you absolutely sure to delete This Ticket ?')"><i class="icon-trash"></i></a>
                                                            <?php } ?> 
                                                        </td>

                                                    </tr>
                                                    <?php
                                                    $i++;
                                                endforeach;
                                            ?>
                                        </tbody>
                                    </table>
                                </div> */ ?>
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
            <?php
            include('include/footer.php');
            echo $cms->KendoFotter();
            ?>

        </div>
        <!-- /main wrapper -->

    </body>
</html>
