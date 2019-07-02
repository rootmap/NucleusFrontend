<?php
include('class/auth.php');
if (isset($_GET['del'])) {
    $obj->deletesing("id", $_GET['del'], "invoice");
}

if (isset($_GET['action'])) {

    $cart = $_GET['invoice'];
    $cid = $obj->SelectAllByVal("invoice", "invoice_id", $cart, "cid");
    $creator = $obj->SelectAllByVal("invoice", "invoice_id", $cart, "invoice_creator");
    $salrep_id = $obj->SelectAllByVal("invoice", "invoice_id", $cart, "access_id");
    $pt = $obj->SelectAllByVal("invoice", "invoice_id", $cart, "payment_type");
    $ckid = $obj->SelectAllByVal("invoice", "invoice_id", $cart, "checkin_id");
    $tax_statuss = $obj->SelectAllByVal("pos_tax", "invoice_id", $cart, "status");
    if ($tax_statuss == 0) {
        $taxs = 0;
    } else {
        $taxs = $tax_per_product;
    }
    include("pdf/MPDF57/mpdf.php");
    $html.="<table id='sample-table-2' class='table table-hover' border='1'><tbody>";

    $report_cpmpany_name = $obj->SelectAllByVal("setting_report", "store_id", $input_by, "name");
    $report_cpmpany_address = $obj->SelectAllByVal("setting_report", "store_id", $input_by, "address");
    $report_cpmpany_phone = $obj->SelectAllByVal("setting_report", "store_id", $input_by, "phone");
    $report_cpmpany_email = $obj->SelectAllByVal("setting_report", "store_id", $input_by, "email");
    $report_cpmpany_fotter = $obj->SelectAllByVal("setting_report", "store_id", $input_by, "fotter");

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
						<td width='87%' style='background:rgba(0,51,153,1);  color:#FFF; font-size:30px;'>" . $report_cpmpany_name . "</td><td width='13%' style='background:rgba(0,51,153,1);  color:#FFF; font-size:30px;'><span style='float:left; text-align:left;'>Estimate Detail</span></td>
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
						<td> Estimate To : </td>
					</tr>
				</table>
			</td>
		  </tr>
		  <tr>
			<td style='height:40px;' valign='top'>
				<table style='width:960px; height:40px; border:0px;'>
					<tr>
						<td width='69%'>
						Name : " . $obj->SelectAllByVal("coustomer", "id", $cid, "firstname") . "<br />
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
						Estimate DATE  : " . $obj->SelectAllByVal("invoice", "invoice_id", $cart, "invoice_date") . "<br />
						Estimate NO. : " . $cart . "<br />
						Estimate REP : " . $obj->SelectAllByVal("store", "id", $salrep_id, "name") . "<br />
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
						Estimate Tax Rate:  " . $taxs . "%
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
    $sqlsaleslist = $obj->SelectAllByID("invoice_detail", array("invoice_id" => $cart));
    $sss = 1;
    $subtotal = 0;
    $tax = 0;
    if (!empty($sqlsaleslist))
        foreach ($sqlsaleslist as $saleslist):
            $caltax = ($saleslist->single_cost * $tax_per_product) / 100;
            $procost = $saleslist->quantity * $saleslist->single_cost;
            $subtotal+=$procost;
            $tax_status = $saleslist->tax;
            if ($tax_status == 0 || $tax_status == "") {
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
						<td>" . $obj->SelectAllByVal("product", "id", $saleslist->pid, "name") . "</td>
						<td>" . $obj->SelectAllByVal("product", "id", $saleslist->pid, "description") . "</td>
						
						<td>" . $saleslist->quantity . "</td>
						<td><button type='button' class='btn'>$" . $saleslist->single_cost . "</button></td>
						<td>$" . $tax . "</td>
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
    $total = $subtotal + $tax;
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
        if ($obj->exists_multiple("checkin_request_ticket", array("checkin_id" => $ckid)) == 0) {
            $html.="<table style='width:300px;border:1px; margin-left:-4px; font-size:12px; background:#ccc;'>
					<thead>
						<tr>
							<th>IMEI of Device being repair : </th>
							<th>" . $obj->SelectAllByVal("ticket", "ticket_id", $ckid, "imei") . "</th>
						</tr>
						<tr>
							<th>Carrier :  </th>
							<th>" . $obj->SelectAllByVal("ticket", "ticket_id", $ckid, "carrier") . "</th>
						</tr>
						<tr>
							<th>Color :  </th>
							<th>" . $obj->SelectAllByVal("ticket", "ticket_id", $ckid, "type_color") . "</th>
						</tr>
						<tr>
							<th>Problem :  </th>
							<th>" . $obj->SelectAllByVal("problem_type", "id", $obj->SelectAllByVal("ticket", "ticket_id", $ckid, "problem_type"), "name") . "</th>
						</tr>
					</thead>
				</table>";
        } else {
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
							</tr>
							<tr>
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


if (@$_GET['export'] == "excel") {


    $record_label = "Estimate List Report";
    header('Content-type: application/excel');
    $filename = "Estimate_list_" . date('Y_m_d') . '.xls';
    header('Content-Disposition: attachment; filename=' . $filename);

    $data = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">
<head>
    <!--[if gte mso 9]>
    <xml>
        <x:ExcelWorkbook>
            <x:ExcelWorksheets>
                <x:ExcelWorksheet>
                    <x:Name>Estimate List : Wireless Geeks Inc.</x:Name>
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
    $data .="<h5>Estimate List Generate Date : " . date('d-m-Y H:i:s') . "</h5>";

    $data .="<table>
    <thead>
        <tr style='background:#09f; color:#fff;'>
			<th>#</th>
			<th>Estimate-ID</th>
			<th>Customer</th>
			<th>Status</th>
			<th>Took Payment</th>
			<th>Date</th>
			<th>Item</th>
			<th>Total</th>
		</tr>
</thead>        
<tbody>";


    if ($input_status == 1) {
        $sqlinvoice = $obj->SelectAllByID_Multiple("invoice", array("doc_type" => 2));
    } elseif ($input_status == 5) {

        $sqlchain_store_ids = $obj->SelectAllByID("store_chain_admin", array("sid" => $input_by));
        if (!empty($sqlchain_store_ids)) {
            $array_ch = array();
            foreach ($sqlchain_store_ids as $ch):
                array_push($array_ch, $ch->store_id);
            endforeach;

            include('class/report_chain_admin.php');
            $obj_report_chain = new chain_report();
            $sqlinvoice = $obj_report_chain->SelectAllByID_Multiple_Or_array("invoice", array("doc_type" => 2), $array_ch, "input_by", "1");
        }
        else {
            //echo "Not Work";
            $sqlinvoice = "";
        }
    } else {
        $sqlinvoice = $obj->SelectAllByID_Multiple("invoice", array("doc_type" => 2, "input_by" => $input_by));
    }
    $i = 1;
    if (!empty($sqlinvoice))
        foreach ($sqlinvoice as $invoice):
            $sqlitem = $obj->SelectAllByID_Multiple("invoice_detail", array("invoice_id" => $invoice->invoice_id));
            $item_q = 0;
            $total = 0;
            if (!empty($sqlitem))
                foreach ($sqlitem as $item):
                    $rr = $item->quantity * $item->single_cost;
                    if ($item->tax != 0) {
                        $tax = 0;
                    } else {
                        $tax = ($rr * $tax_per_product) / 100;
                    }

                    $tot = $rr + $tax;
                    $total+=$tot;
                    $item_q+=$item->quantity;
                endforeach;
            if ($total != 0) {
                $data.="<tr>
				<td>" . $i . "</td>
				<td>" . $invoice->invoice_id . "</td>
				<td>" . $obj->SelectAllByVal("coustomer", "id", $invoice->cid, "businessname") . "-" . $obj->SelectAllByVal("coustomer", "id", $invoice->cid, "firstname") . "" . $obj->SelectAllByVal("coustomer", "id", $invoice->cid, "lastname") . "</td>
				<td>" . $obj->invoice_paid_status($invoice->status) . "</td>
				<td>" . $obj->invoice_took_payment($invoice->status) . "</td>
				<td>" . $invoice->date . "</td>
				<td>" . $item_q . "</td>
				<td>" . number_format($total, 2) . "</td>
			</tr>";
                $i++;
            }
        endforeach;

    $data .="</tbody><tfoot><tr>
			<th>#</th>
			<th>Estimate-ID</th>
			<th>Customer</th>
			<th>Status</th>
			<th>Took Payment</th>
			<th>Date</th>
			<th>Item</th>
			<th>Total</th>
		</tr></tfoot></table>";

    $data .='</body></html>';

    echo $data;
}

if (@$_GET['export'] == "pdf") {
    $record_label = "Parts List Report";
    include("pdf/MPDF57/mpdf.php");
    extract($_GET);
    $html.="<table id='sample-table-2' class='table table-hover' border='0'><tbody>";
    $html .="<tr>
			<td valign='top' style='margin:0; padding:0; width:100%;'>
				<table style='width:100%; height:40px; border:0px;'>
					<tr>
						<td width='87%' style='background:rgba(0,51,153,1);  color:#FFF; font-size:25px;'>
						Estimate List Report
						</td>
					</tr>
				</table>
				
				
				<table style='width:100%; height:40px; border:0px; font-size:18px;'>
					<tr>
						<td> Estimate List Generate Date : " . date('d-m-Y H:i:s') . "</td>
					</tr>
				</table>
				<table style='width:960px;border:1px; font-size:12px; background:#ccc;'>";
    $html.="<thead>
        <tr style='background:#09f; color:#fff;'>
			<th>#</th>
			<th>Estimate-ID</th>
			<th>Customer</th>
			<th>Status</th>
			<th>Took Payment</th>
			<th>Date</th>
			<th>Item</th>
			<th>Total</th>
		</tr>
</thead>        
<tbody>";

    if ($input_status == 1) {
        $sqlinvoice = $obj->SelectAllByID_Multiple("invoice", array("doc_type" => 2));
    } elseif ($input_status == 5) {

        $sqlchain_store_ids = $obj->SelectAllByID("store_chain_admin", array("sid" => $input_by));
        if (!empty($sqlchain_store_ids)) {
            $array_ch = array();
            foreach ($sqlchain_store_ids as $ch):
                array_push($array_ch, $ch->store_id);
            endforeach;

            include('class/report_chain_admin.php');
            $obj_report_chain = new chain_report();
            $sqlinvoice = $obj_report_chain->SelectAllByID_Multiple_Or_array("invoice", array("doc_type" => 2), $array_ch, "input_by", "1");
        }
        else {
            //echo "Not Work";
            $sqlinvoice = "";
        }
    } else {
        $sqlinvoice = $obj->SelectAllByID_Multiple("invoice", array("doc_type" => 2, "input_by" => $input_by));
    }
    $i = 1;
    if (!empty($sqlinvoice))
        foreach ($sqlinvoice as $invoice):
            $sqlitem = $obj->SelectAllByID_Multiple("invoice_detail", array("invoice_id" => $invoice->invoice_id));
            $item_q = 0;
            $total = 0;
            if (!empty($sqlitem))
                foreach ($sqlitem as $item):
                    $rr = $item->quantity * $item->single_cost;
                    if ($item->tax != 0) {
                        $tax = 0;
                    } else {
                        $tax = ($rr * $tax_per_product) / 100;
                    }

                    $tot = $rr + $tax;
                    $total+=$tot;
                    $item_q+=$item->quantity;
                endforeach;
            if ($total != 0) {
                $html.="<tr>
				<td>" . $i . "</td>
				<td>" . $invoice->invoice_id . "</td>
				<td>" . $obj->SelectAllByVal("coustomer", "id", $invoice->cid, "businessname") . "-" . $obj->SelectAllByVal("coustomer", "id", $invoice->cid, "firstname") . "" . $obj->SelectAllByVal("coustomer", "id", $invoice->cid, "lastname") . "</td>
				<td>" . $obj->invoice_paid_status($invoice->status) . "</td>
				<td>" . $obj->invoice_took_payment($invoice->status) . "</td>
				<td>" . $invoice->date . "</td>
				<td>" . $item_q . "</td>
				<td>" . number_format($total, 2) . "</td>
			</tr>";
                $i++;
            }
        endforeach;

    $html.="</tbody><tfoot><tr>
			<th>#</th>
			<th>Estimate-ID</th>
			<th>Customer</th>
			<th>Status</th>
			<th>Took Payment</th>
			<th>Date</th>
			<th>Item</th>
			<th>Total</th>
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
                            <h5><i class="font-paper-clip"></i> <span style="border-right:2px #333 solid; padding-right:10px;">Estimate Info</span>
                                <span><i class="font-calendar"></i> <a data-toggle="modal" href="#myModal"> Generate Estimate Report</a></span>
                            </h5>
                            <ul class="icons">
                                <li><a href="<?php echo $obj->filename(); ?>" class="hovertip" title="Reload"><i class="font-refresh"></i></a></li>
                            </ul>
                        </div><!-- /page header -->

                        <div class="body">

                            <!-- Middle navigation standard -->
                            <?php //include('include/quicklink.php'); ?>
                            <!-- Dialog content -->
                            <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h5 id="myModalLabel"><i class="font-calendar"></i> Generate Estimate Report <span id="mss"></span></h5>
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
                            <!-- /middle navigation standard -->

                            <!-- Content container -->
                            <div class="container">

                                <!--                                <div class="separator-doubled"></div> -->



                                <!-- Content Start from here customized -->


                                <!-- Default datatable -->
                                <div class="block">
                                    <div class="table-overflow">
                                        <div id="grid" style="margin-left: 10px;margin-right: 10px;"></div>


                                        <script id="edit_client" type="text/x-kendo-template">
                                            <a class="k-button k-button-icontext k-grid-delete" onclick="javascript:deleteClick(#= invoice_id #);" ><span class="k-icon k-delete"></span>Delete</a>
                                        </script>
                                        <script type="text/javascript">
                                            function deleteClick(id) {
                                                var c = confirm("Do you want to delete?");
                                                if (c === true) {
                                                    $.ajax({
                                                        type: "POST",
                                                        dataType: "json",
                                                        url: "./controller/estimate.php",
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
                                            jQuery(document).ready(function () {
                                                var dataSource = new kendo.data.DataSource({
                                                    transport: {
                                                        read: {
                                                            url: "./controller/estimate.php<?php echo $cond; ?>",
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
                                                                invoice_id: {type: "string"},
                                                                businessname: {type: "string"},
                                                                quantity: {type: "number"},
                                                                row_total: {type: "number"},
                                                                tax_total: {type: "number"},
                                                                total: {type: "number"},
                                                                date: {type: "string"},
                                                                status: {type: "string"}
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
                                                    pageable: {
                                                        refresh: true,
                                                        input: true,
                                                        numeric: false,
                                                        pageSizes: true,
                                                        pageSizes:[10, 20, 50, 100, 200, 400]
                                                    },
                                                    sortable: true,
                                                    groupable: true,
                                                    columns: [
                                                        {field: "id", title: "#", width: "70px"},
                                                        {field: "invoice_id",
                                                           title: "Estimate ID",
                                                            template: "<a target='_blank' href='view_estimate.php?estimate=#=invoice_id#'>#=invoice_id#</a>"
                                                        },
                                                        {field: "businessname", title: "Customer"},
                                                        {field: "quantity", title: "Quantity"},
                                                        {template: "<?php echo $currencyicon; ?>#=row_total#", title: "Sub Total"},
                                                        {template: "<?php echo $currencyicon; ?>#=tax_total#", title: "Tax"},
                                                        {template: "<?php echo $currencyicon; ?>#=total#", title: "Total"},
                                                        {field: "date", title: "Date"},
                                                        {
                                                            title: "Action", width: "100px",
                                                            template: kendo.template($("#edit_client").html())
                                                        }
                                                    ],
                                                });
                                            });

                                        </script>
                                        <script type="text/javascript">
                                            $(document).ready(function () {
                                                $('.k-grid-delete').click(function () {
                                                    $.ajax({
                                                        type: 'POST',
                                                        url: "./controller/estimate.php",
                                                        data: "",
                                                        success: function () {

                                                        }
                                                    });
                                                });

                                                // CSV file export code
                                                jQuery("#export-grid").click(function (e) {
                                                    e.preventDefault();
                                                    var dataSource = jQuery("#grid").data("kendoGrid").dataSource;
                                                    var filters = dataSource.filter();
                                                    var allData = dataSource.data();
                                                    var query = new kendo.data.Query(allData);
                                                    var data = query.filter(filters).data;

                                                    var json_data = JSON.stringify(data);
                                                    console.log(json_data);
                                                    JSONToCSVConvertor(json_data, "Estimate List", true);

                                                });



                                                function JSONToCSVConvertor(JSONData, ReportTitle, ShowLabel) {
                                                    //If JSONData is not an object then JSON.parse will parse the JSON string in an Object
                                                    var arrData = typeof JSONData != 'object' ? JSON.parse(JSONData) : JSONData;

                                                    var CSV = '';
                                                    //Set Report title in first row or line

                                                    CSV += ReportTitle + '\r\n\n';

                                                    //This condition will generate the Label/Header
                                                    if (ShowLabel) {
                                                        var row = "";

                                                        //This loop will extract the label from 1st index of on array
                                                        for (var index in arrData[0]) {

                                                            //Now convert each value to string and comma-seprated
                                                            var regexUnderscore = new RegExp("_", "g");
                                                            row += index.replace(regexUnderscore, " ").toUpperCase() + ',';
                                                            //  row += index + ',';
                                                        }

                                                        row = row.slice(0, -1);

                                                        //append Label row with line break
                                                        CSV += row + '\r\n';
                                                    }
                                                    //1st loop is to extract each row
                                                    for (var i = 0; i < arrData.length; i++) {
                                                        var row = "";

                                                        //2nd loop will extract each column and convert it in string comma-seprated
                                                        for (var index in arrData[i]) {
                                                            row += '"' + arrData[i][index] + '",';
                                                        }

                                                        row.slice(0, row.length - 1);

                                                        //add a line break after each row
                                                        CSV += row + '\r\n';
                                                    }

                                                    if (CSV == '') {
                                                        alert("Invalid data");
                                                        return;
                                                    }

                                                    //Generate a file name
                                                    var fileName = "estimate_list_";
                                                    //this will remove the blank-spaces from the title and replace it with an underscore
                                                    fileName += ReportTitle.replace(/ /g, "_");

                                                    //Initialize file format you want csv or xls
                                                    var uri = 'data:text/csv;charset=utf-8,' + escape(CSV);

                                                    // Now the little tricky part.
                                                    // you can use either>> window.open(uri);
                                                    // but this will not work in some browsers
                                                    // or you will not get the correct file extension    

                                                    // this trick will generate a temp <a /> tag
                                                    var link = document.createElement("a");
                                                    link.href = uri;

                                                    //set the visibility hidden so it will not effect on your web-layout
                                                    link.style = "visibility:hidden";
                                                    link.download = fileName + ".csv";

                                                    //this part will append the anchor tag and remove it after automatic click
                                                    document.body.appendChild(link);
                                                    link.click();
                                                    document.body.removeChild(link);
                                                }

                                                //javascript CSV output end

                                            });
                                        </script>

                                    </div>
                                </div>
                                <!-- /default datatable -->


                                <!-- Content End from here customized -->




                                <div class="separator-doubled"></div> 

                                <a id="export-grid" href="javascript:void(0);"><img src="pos_image/file_excel.png"></a>
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
            <!-- Right sidebar -->
            <?php //include('include/sidebar_right.php');   ?>
            <!-- /right sidebar -->

        </div>
        <!-- /main wrapper -->

    </body>
</html>
