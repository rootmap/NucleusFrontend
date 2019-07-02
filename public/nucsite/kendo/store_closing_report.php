<?php
include('class/auth.php');
include('class/report_customer.php');
$report = new report();
$table = "close_store_detail";
if (@$_GET['export'] == "excel") {
    if ($input_status == 1) {
        if (isset($_GET['from'])) {
            $from = $_GET['from'];
            $to = $_GET['to'];
            $cashier_id = $_GET['cashier_id'];
            $sqlinvoice = $report->SelectAllDateCond("close_store_detail", "cashier_id", $cashier_id, $from, $to, "1");
            $record = $report->SelectAllDateCond("close_store_detail", "cashier_id", $cashier_id, $from, $to, "2");
            $record_label = "Total record Found ( " . $record . " ). | Report Generate Between " . $from . " - " . $to;
        } else {
            $sqlinvoice = $obj->SelectAll("close_store_detail");
            $record = $obj->totalrows("close_store_detail");
            $record_label = "Total Record Found ( " . $record . " )";
        }
    } else {
        if (isset($_GET['from'])) {
            $from = $_GET['from'];
            $to = $_GET['to'];
            $cashier_id = $_GET['cashier_id'];
            $sqlinvoice = $report->SelectAllDateCond_store2("close_store_detail", "cashier_id", $cashier_id, "store_id", $input_by, $from, $to, "1");
            $record = $report->SelectAllDateCond_store2("close_store_detail", "cashier_id", $cashier_id, "store_id", $input_by, $from, $to, "2");
            $record_label = "Total record Found ( " . $record . " ). | Report Generate Between " . $from . " - " . $to;
        } else {
            $sqlinvoice = $obj->SelectAllByID("close_store_detail", array("store_id" => $input_by));
            $record = $obj->exists_multiple("close_store_detail", array("store_id" => $input_by));
            $record_label = "Total Record Found ( " . $record . " )";
        }
    }

    header('Content-type: application/excel');
    $filename = "Store_Closing_Report_" . date('Y_m_d') . '.xls';
    header('Content-Disposition: attachment; filename=' . $filename);

    $data = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">
<head>
    <!--[if gte mso 9]>
    <xml>
        <x:ExcelWorkbook>
            <x:ExcelWorksheets>
                <x:ExcelWorksheet>
                    <x:Name>Store Closing Report : Wireless Geeks Inc.</x:Name>
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
    $data .="<h5>Store Closing Report Generate Date : " . date('d-m-Y H:i:s') . "</h5>";

    $data .="<table>
    <thead>
        <tr style='background:#09f; color:#fff;'>
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
		</tr>
</thead>
<tbody>";

    $i = 1;
    $aa = 0;
    $bb = 0;
    $cc = 0;
    $dd = 0;
    $ee = 0;
    $ff = 0;
    $gg = 0;
    $hh = 0;
    $ii = 0;
    $jj = 0;
    $kk = 0;
    if (!empty($sqlinvoice))
        foreach ($sqlinvoice as $invoice):

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
            $data.="<tr>
				<td>" . $i . "</td>
				<td>" . $invoice->date . "</td>
				<td>" . $invoice->store_id . "</td>
				<td>" . $invoice->total_collection_cash_credit_card . "</td>
				<td>" . $invoice->cash_collected_plus . "</td>
				<td>" . $invoice->credit_card_collected_plus . "</td>
				<td>" . $invoice->opening_cash_plus . "</td>
				<td>" . $invoice->opening_credit_card_plus . "</td>
				<td>" . $invoice->payout_plus_min . "</td>
				<td>" . $invoice->buyback_min . "</td>
				<td>" . $invoice->tax_min . "</td>
				<td>" . $invoice->current_cash . "</td>
				<td>" . $invoice->current_credit_card . "</td>
				<td>" . $invoice->current_total . "</td>
			</tr>";

            $i++;
        endforeach;

    $data .="</tbody><tfoot>
		<tr>
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
		</tr>
		</tfoot></table>";




    $data.="<table border='0' width='250' style='width:200px;'>
					<tbody>
						<tr>
							<td colspan='2'> Total Store Closing Report </td>
						</tr>
						<tr>
							<td>1. Total Report Found = </td>
							<td><strong> " . $dr . "</strong></td>
						</tr>
						<tr>
							<td>2. Total Collection Cash/Credit Card = </td>
							<td><strong> $" . number_format($aa, 2) . "</strong></td>
						</tr>
						<tr>
							<td>3. Cash Collected (+) = </td>
							<td><strong> $" . number_format($bb, 2) . "</strong></td>
						</tr>
						<tr>
							<td>4. Credit Card Collected (+) = </td>
							<td><strong> $" . number_format($cc, 2) . "</strong></td>
						</tr>
						<tr>
							<td>5. Opening Cash (+) = </td>
							<td><strong> $" . number_format($dd, 2) . "</strong></td>
						</tr>
						<tr>
							<td>6. Opening Credit Card (+) = </td>
							<td><strong> $" . number_format($ee, 2) . "</strong></td>
						</tr>
						<tr>
							<td>7. Payout (+)(-) = </td>
							<td><strong> $" . number_format($ff, 2) . "</strong></td>
						</tr>
						<tr>
							<td>8. BuyBack (-) = </td>
							<td><strong> $" . number_format($gg, 2) . "</strong></td>
						</tr>
						<tr>
							<td>9. Tax (-) = </td>
							<td><strong> $" . number_format($hh, 2) . "</strong></td>
						</tr>
						<tr>
							<td>10. Current Cash = </td>
							<td><strong> $" . number_format($ii, 2) . "</strong></td>
						</tr>
						<tr>
							<td>11. Current Credit Card = </td>
							<td><strong> $" . number_format($jj, 2) . "</strong></td>
						</tr>
						<tr>
							<td>12. Current Total = </td>
							<td><strong> $" . number_format($kk, 2) . "</strong></td>
						</tr>
					</tbody>
				</table>";

    $data .='</body></html>';

    echo $data;
}

if (@$_GET['export'] == "pdf") {
    if ($input_status == 1) {
        if (isset($_GET['from'])) {
            $from = $_GET['from'];
            $to = $_GET['to'];
            $cashier_id = $_GET['cashier_id'];
            $sqlinvoice = $report->SelectAllDateCond("close_store_detail", "cashier_id", $cashier_id, $from, $to, "1");
            $record = $report->SelectAllDateCond("close_store_detail", "cashier_id", $cashier_id, $from, $to, "2");
            $record_label = "Total record Found ( " . $record . " ). | Report Generate Between " . $from . " - " . $to;
        } else {
            $sqlinvoice = $obj->SelectAll("close_store_detail");
            $record = $obj->totalrows("close_store_detail");
            $record_label = "Total Record Found ( " . $record . " )";
        }
    } else {
        if (isset($_GET['from'])) {
            $from = $_GET['from'];
            $to = $_GET['to'];
            $cashier_id = $_GET['cashier_id'];
            $sqlinvoice = $report->SelectAllDateCond_store2("close_store_detail", "cashier_id", $cashier_id, "store_id", $input_by, $from, $to, "1");
            $record = $report->SelectAllDateCond_store2("close_store_detail", "cashier_id", $cashier_id, "store_id", $input_by, $from, $to, "2");
            $record_label = "Total record Found ( " . $record . " ). | Report Generate Between " . $from . " - " . $to;
        } else {
            $sqlinvoice = $obj->SelectAllByID("close_store_detail", array("store_id" => $input_by));
            $record = $obj->exists_multiple("close_store_detail", array("store_id" => $input_by));
            $record_label = "Total Record Found ( " . $record . " )";
        }
    }
    include("pdf/MPDF57/mpdf.php");
    extract($_GET);
    $html.="<table id='sample-table-2' class='table table-hover' border='0'><tbody>";
    $html .="<tr>
			<td valign='top' style='margin:0; padding:0; width:100%;'>
				<table style='width:100%; height:40px; border:0px;'>
					<tr>
						<td width='87%' style='background:rgba(0,51,153,1);  color:#FFF; font-size:25px;'>
						Store Closing Report
						</td>
					</tr>
				</table>


				<table style='width:100%; height:40px; border:0px; font-size:18px;'>
					<tr>
						<td> Store Closing Report Generate Date : " . date('d-m-Y H:i:s') . "</td>
					</tr>
				</table>
				<table style='width:960px;border:1px; font-size:12px; background:#ccc;'>";
    $html.="<thead>
        <tr style='background:#09f; color:#fff;'>
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
		</tr>
</thead>
<tbody>";


    $i = 1;
    $aa = 0;
    $bb = 0;
    $cc = 0;
    $dd = 0;
    $ee = 0;
    $ff = 0;
    $gg = 0;
    $hh = 0;
    $ii = 0;
    $jj = 0;
    $kk = 0;
    if (!empty($sqlinvoice))
        foreach ($sqlinvoice as $invoice):

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
            $html.="<tr>
				<td>" . $i . "</td>
				<td>" . $invoice->date . "</td>
				<td>" . $invoice->store_id . "</td>
				<td>" . $invoice->total_collection_cash_credit_card . "</td>
				<td>" . $invoice->cash_collected_plus . "</td>
				<td>" . $invoice->credit_card_collected_plus . "</td>
				<td>" . $invoice->opening_cash_plus . "</td>
				<td>" . $invoice->opening_credit_card_plus . "</td>
				<td>" . $invoice->payout_plus_min . "</td>
				<td>" . $invoice->buyback_min . "</td>
				<td>" . $invoice->tax_min . "</td>
				<td>" . $invoice->current_cash . "</td>
				<td>" . $invoice->current_credit_card . "</td>
				<td>" . $invoice->current_total . "</td>
			</tr>";

            $i++;
        endforeach;

    $html.="</tbody><tfoot><tr>
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
		</tr></tfoot></table>";
    $dr = $i - 1;
    $html.="<table border='0'  width='250' style='width:250px;'>
					<tbody>
						<tr>
							<td colspan='2'> Total Store Closing Report </td>
						</tr>
						<tr>
							<td>1. Total Report Found = </td>
							<td><strong> " . $dr . "</strong></td>
						</tr>
						<tr>
							<td>2. Total Collection Cash/Credit Card = </td>
							<td><strong> $" . number_format($aa, 2) . "</strong></td>
						</tr>
						<tr>
							<td>3. Cash Collected (+) = </td>
							<td><strong> $" . number_format($bb, 2) . "</strong></td>
						</tr>
						<tr>
							<td>4. Credit Card Collected (+) = </td>
							<td><strong> $" . number_format($cc, 2) . "</strong></td>
						</tr>
						<tr>
							<td>5. Opening Cash (+) = </td>
							<td><strong> $" . number_format($dd, 2) . "</strong></td>
						</tr>
						<tr>
							<td>6. Opening Credit Card (+) = </td>
							<td><strong> $" . number_format($ee, 2) . "</strong></td>
						</tr>
						<tr>
							<td>7. Payout (+)(-) = </td>
							<td><strong> $" . number_format($ff, 2) . "</strong></td>
						</tr>
						<tr>
							<td>8. BuyBack (-) = </td>
							<td><strong> $" . number_format($gg, 2) . "</strong></td>
						</tr>
						<tr>
							<td>9. Tax (-) = </td>
							<td><strong> $" . number_format($hh, 2) . "</strong></td>
						</tr>
						<tr>
							<td>10. Current Cash = </td>
							<td><strong> $" . number_format($ii, 2) . "</strong></td>
						</tr>
						<tr>
							<td>11. Current Credit Card = </td>
							<td><strong> $" . number_format($jj, 2) . "</strong></td>
						</tr>
						<tr>
							<td>12. Current Total = </td>
							<td><strong> $" . number_format($kk, 2) . "</strong></td>
						</tr>
					</tbody>
				</table>";

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
        <?php //echo $obj->bodyhead(); ?>
        <script src="ajax/customer_ajax.js"></script>
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
                <!-- /info notice -->

                <div class="outer">
                    <div class="inner">
                        <div class="page-header"><!-- Page header -->
                            <?php
                            echo $obj->ShowMsg();
                            if ($input_status == 1) {
                                if (isset($_GET['from'])) {
                                    $from = $_GET['from'];
                                    $to = $_GET['to'];
                                    $cashier_id = $_GET['cashier_id'];
                                    $sqlinvoice = $report->SelectAllDateCond("close_store_detail", "cashier_id", $cashier_id, $from, $to, "1");
                                    $record = $report->SelectAllDateCond("close_store_detail", "cashier_id", $cashier_id, $from, $to, "2");
                                    $record_label = "Total record Found ( " . $record . " ). | Report Generate Between " . $from . " - " . $to;
                                } else {
                                    $sqlinvoice = $obj->SelectAll("close_store_detail");
                                    $record = $obj->totalrows("close_store_detail");
                                    $record_label = "Total Record Found ( " . $record . " )";
                                }
                            } elseif ($input_status == 5) {

                                $sqlchain_store_ids = $obj->SelectAllByID("store_chain_admin", array("sid" => $input_by));
                                if (!empty($sqlchain_store_ids)) {
                                    $array_ch = array();
                                    foreach ($sqlchain_store_ids as $ch):
                                        array_push($array_ch, $ch->store_id);
                                    endforeach;

                                    if (isset($_GET['from'])) {
                                        $cashier_id = $_GET['cashier_id'];
                                        include('class/report_chain_admin.php');
                                        $obj_report_chain = new chain_report();
                                        $sqlinvoice = $obj_report_chain->ReportQuery_Datewise_Or_array("close_store_detail", array("cashier_id" => $cashier_id), $array_ch, "store_id", $_GET['from'], $_GET['to'], "1");
                                        $record = $obj_report_chain->ReportQuery_Datewise_Or_array("close_store_detail", array("cashier_id" => $cashier_id), $array_ch, "store_id", $_GET['from'], $_GET['to'], "2");
                                        $record_label = "Total record Found ( " . $record . " ). | Report Generate Between " . $from . " - " . $to;
                                    } else {
                                        include('class/report_chain_admin.php');
                                        $obj_report_chain = new chain_report();
                                        $sqlinvoice = $obj_report_chain->SelectAllByID_Multiple_Or("close_store_detail", $array_ch, "store_id", "1");
                                        $record = $obj_report_chain->SelectAllByID_Multiple_Or("close_store_detail", $array_ch, "store_id", "2");
                                        $record_label = "Total record Found ( " . $record . " )";
                                    }
                                    //echo "Work";
                                } else {
                                    //echo "Not Work";
                                    $sqlinvoice = "";
                                    $record = 0;
                                    $record_label = "Total record Found ( " . $record . " )";
                                }
                            } else {
                                if (isset($_GET['from'])) {
                                    $from = $_GET['from'];
                                    $to = $_GET['to'];
                                    $cashier_id = $_GET['cashier_id'];
                                    $sqlinvoice = $report->SelectAllDateCond_store2("close_store_detail", "cashier_id", $cashier_id, "store_id", $input_by, $from, $to, "1");
                                    $record = $report->SelectAllDateCond_store2("close_store_detail", "cashier_id", $cashier_id, "store_id", $input_by, $from, $to, "2");
                                    $record_label = "Total record Found ( " . $record . " ). | Report Generate Between " . $from . " - " . $to;
                                } else {
                                    $sqlinvoice = $obj->SelectAllByID("close_store_detail", array("store_id" => $input_by));
                                    $record = $obj->exists_multiple("close_store_detail", array("store_id" => $input_by));
                                    $record_label = "Total Record Found ( " . $record . " )";
                                }
                            }
                            ?>
                            <h5><i class="font-money"></i> Store Closing Report | <?php echo $record_label; ?> | <a  data-toggle="modal" href="#myModal"> Search Datewise </a></h5>
                        </div><!-- /page header -->

                        <div class="body">

                            <!-- Middle navigation standard -->
                            <?php //include('include/quicklink.php'); ?>
                            <!-- /middle navigation standard -->

                            <!-- Content container -->
                            <div class="container">

                                <!-- Content Start from here customized -->




                                <!-- General form elements -->
                                <div class="row-fluid block">
                                    <!-- Dialog content -->
                                    <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h5 id="myModalLabel"><i class="font-calendar"></i> Generate Store Closing Report <span id="mss"></span></h5>
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

                                    <!-- Dialog content -->
                                    <?php /* <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                      <form action="" method="get">
                                      <div class="modal-header" style="height:25px;">
                                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                      <h5 id="myModalLabel"><i class="icon-calendar"></i> Search Datewise</h5>
                                      </div>
                                      <div class="modal-body">
                                      <div class="row-fluid">
                                      <div class="control-group">
                                      <label class="control-label">Date range:</label>
                                      <div class="controls">
                                      <ul class="dates-range">
                                      <li><input type="text" id="fromDate" readonly value="<?php echo date('Y-m-d'); ?>" name="from" placeholder="From" /></li>
                                      <li class="sep">-</li>
                                      <li><input type="text" id="toDate" readonly value="<?php echo date('Y-m-d'); ?>"  name="to" placeholder="To" /></li>
                                      </ul>
                                      </div>
                                      </div>

                                      <div class="control-group">
                                      <label class="control-label">Cashier :</label>
                                      <div class="controls">
                                      <select name="cashier_id">
                                      <?php
                                      if ($input_status == 1) {
                                      $sqlcashier = $obj->SelectAll("cashier_list");
                                      } else {
                                      $sqlcashier = $obj->SelectAllByID("cashier_list", array("store_id" => $input_by));
                                      }
                                      if (!empty($sqlcashier))
                                      foreach ($sqlcashier as $cashier):
                                      ?>
                                      <option value="<?php echo $cashier->id; ?>"><?php echo $cashier->name; ?></option>
                                      <?php endforeach; ?>
                                      </select>
                                      </div>
                                      </div>

                                      </div>
                                      </div>
                                      <div class="modal-footer">
                                      <button class="btn btn-primary"  type="submit" name="search_date"><i class="icon-screenshot"></i> Search</button>
                                      </div>
                                      </form>
                                      </div> */ ?>
                                    <!-- /dialog content -->

                                    <div class="table-overflow">




                                        <div id="grid" style="margin-left: 10px;margin-right: 10px;"></div>

                                        <?php
                                        $cond = $cms->FrontEndDateSearch('from', 'to');
                                        ?>
<!--                                        <script id="action_template" type="text/x-kendo-template">
                                            <a class="k-button k-button-icontext k-grid-delete" href="tranaction.php?edit=#=id#"><i class="icon-edit"></i> Edit</a> 
                                            <a class="k-button k-button-icontext k-grid-delete" onclick="javascript:deleteClick(#=id#);" ><span class="k-icon k-delete"></span> Delete</a>
                                        </script>-->
                                        <script type="text/javascript">
                                            function deleteClick(id) {
                                                var c = confirm("Do you want to delete?");
                                                if (c === true) {
                                                    $.ajax({
                                                        type: "POST",
                                                        dataType: "json",
                                                        url: "./controller/store_closing_report.php",
                                                        data: {id: id},
                                                        success: function (result) {
                                                            $(".k-i-refresh").click();
                                                        }
                                                    });
                                                }
                                            }

                                        </script>
                                        <script type="text/javascript">
                                            jQuery(document).ready(function () {
                                                var dataSource = new kendo.data.DataSource({
                                                    transport: {
                                                        read: {
                                                            url: "./controller/store_closing_report.php",
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
                                                                id: {type: "number"},
                                                                store_id: {type: "number"},
                                                                credit_card_collected_plus: {type: "string"},
                                                                total_collection_cash_credit_card: {type: "string"},
                                                                cash_collected_plus: {type: "string"},
                                                                opening_cash_plus: {type: "string"},
                                                                opening_credit_card_plus: {type: "string"},
                                                                payout_plus_min: {type: "string"},
                                                                buyback_min: {type: "string"},
                                                                tax_min: {type: "string"},
                                                                current_cash: {type: "string"},
                                                                current_credit_card: {type: "string"},
                                                                current_total: {type: "string"},
                                                                date: {type: "string"}
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
                                                        {field: "id", title: "#", width: "60px", filterable: false},
                                                        {field: "store_id", title: "Store ID", width: "100px"},
                                                        {template: "<?php echo $currencyicon; ?>#=credit_card_collected_plus#", title: "Credit Card Collected Plus", width: "160px"},
                                                        {template: "<?php echo $currencyicon; ?>#=total_collection_cash_credit_card#", title: "Total Collection Cash Credit Card", width: "200px"},
                                                        {template: "<?php echo $currencyicon; ?>#=cash_collected_plus#", title: "Cash Collected Plus", width: "130px"},
                                                        {template: "<?php echo $currencyicon; ?>#=opening_cash_plus#", title: "Opening Cash Plus", width: "130px"},
                                                        {template: "<?php echo $currencyicon; ?>#=opening_credit_card_plus#", title: "Opening Credit Card Plus", width: "160px"},
                                                        {template: "<?php echo $currencyicon; ?>#=payout_plus_min#", title: "Payout Plus Min", width: "120px"},
                                                        {template: "<?php echo $currencyicon; ?>#=buyback_min#", title: "Buyback Min", width: "100px"},
                                                        {template: "<?php echo $currencyicon; ?>#=tax_min#", title: "Tax Min", width: "80px"},
                                                        {template: "<?php echo $currencyicon; ?>#=current_cash#", title: "Current Cash", width: "100px"},
                                                        {template: "<?php echo $currencyicon; ?>#=current_credit_card#", title: "Current Credit Card", width: "130px"},
                                                        {template: "<?php echo $currencyicon; ?>#=current_total#", title: "Current Total", width: "110px"},
                                                        {field: "date", title: "Created", width: "90px"},
//                                                        {
//                                                            title: "Action", width: "80px",
//                                                            template: kendo.template($("#action_template").html())
//                                                        }
                                                    ],
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
                                            JSONToCSVConvertor(json_data, "Store closing Report", true);

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
                                            var fileName = "store_closing_report_";
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




























                                        <?php /*  <table class="table table-striped" id="data-table">
                                          <thead>
                                          <tr>
                                          <th>#</th>
                                          <th>Date</th>
                                          <th>Store</th>
                                          <?php if ($input_status == 1 || $input_status == 5) { ?>
                                          <th>Store Name</th>
                                          <?php } ?>
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
                                          </tr>
                                          </thead>
                                          <tbody>
                                          <?php
                                          $i=1;
                                          $aa=0;
                                          $bb=0;
                                          $cc=0;
                                          $dd=0;
                                          $ee=0;
                                          $ff=0;
                                          $gg=0;
                                          $hh=0;
                                          $ii=0;
                                          $jj=0;
                                          $kk=0;
                                          if (!empty($sqlinvoice))
                                          foreach ($sqlinvoice as $invoice):
                                          ?>
                                          <tr>
                                          <td><?php echo $i; ?></td>
                                          <td><!--<a href="view_store_close.php?date=<?php //echo $invoice->date;      ?>">--><?php echo $invoice->date; ?><!--</a>--></td>
                                          <td><?php echo $invoice->store_id; ?></td>
                                          <?php if ($input_status == 1 || $input_status == 5) { ?>
                                          <td><?php echo $obj->SelectAllByVal("store", "store_id", $invoice->store_id, "name"); ?></td>
                                          <?php } ?>
                                          <td><?php
                                          echo $invoice->total_collection_cash_credit_card;
                                          $aa+=$invoice->total_collection_cash_credit_card;
                                          ?></td>
                                          <td><?php
                                          echo $invoice->cash_collected_plus;
                                          $bb+=$invoice->cash_collected_plus;
                                          ?></td>
                                          <td>$<?php
                                          echo $invoice->credit_card_collected_plus;
                                          $cc+=$invoice->credit_card_collected_plus;
                                          ?></td>
                                          <td>$<?php
                                          echo $invoice->opening_cash_plus;
                                          $dd+=$invoice->opening_cash_plus;
                                          ?></td>

                                          <td>$<?php
                                          echo $invoice->opening_credit_card_plus;
                                          $ee+=$invoice->opening_credit_card_plus;
                                          ?></td>
                                          <td>$<?php
                                          echo $invoice->payout_plus_min;
                                          $ff+=$invoice->payout_plus_min;
                                          ?></td>
                                          <td>$<?php
                                          echo $invoice->buyback_min;
                                          $gg+=$invoice->buyback_min;
                                          ?></td>
                                          <td><?php
                                          echo $invoice->tax_min;
                                          $hh+=$invoice->tax_min;
                                          ?></td>
                                          <td><?php
                                          echo $invoice->current_cash;
                                          $ii+=$invoice->current_cash;
                                          ?></td>
                                          <td><?php
                                          echo $invoice->current_credit_card;
                                          $jj+=$invoice->current_credit_card;
                                          ?></td>
                                          <td><?php
                                          echo $invoice->current_total;
                                          $kk+=$invoice->current_total;
                                          ?></td>
                                          </tr>
                                          <?php
                                          $i++;
                                          endforeach;
                                          ?>
                                          </tbody>
                                          </table>
                                          </div>
                                          <!-- Table condensed -->
                                          <div class="block well span5" style="margin-left:0;">
                                          <div class="navbar">
                                          <div class="navbar-inner">
                                          <h5> Total Store Closing Report</h5>
                                          </div>
                                          </div>
                                          <div class="table-overflow">
                                          <table class="table table-condensed">
                                          <tbody>
                                          <tr>
                                          <td>1. Total Report Found = </td>
                                          <td><strong> <?php echo $i - 1; ?></strong></td>
                                          </tr>
                                          <tr>
                                          <td>2. Total Collection Cash/Credit Card = </td>
                                          <td><strong> $<?php echo number_format($aa, 2); ?></strong></td>
                                          </tr>
                                          <tr>
                                          <td>3. Cash Collected (+) = </td>
                                          <td><strong> $<?php echo number_format($bb, 2); ?></strong></td>
                                          </tr>
                                          <tr>
                                          <td>4. Credit Card Collected (+) = </td>
                                          <td><strong> $<?php echo number_format($cc, 2); ?></strong></td>
                                          </tr>
                                          <tr>
                                          <td>5. Opening Cash (+) = </td>
                                          <td><strong> $<?php echo number_format($dd, 2); ?></strong></td>
                                          </tr>
                                          <tr>
                                          <td>6. Opening Credit Card (+) = </td>
                                          <td><strong> $<?php echo number_format($ee, 2); ?></strong></td>
                                          </tr>
                                          <tr>
                                          <td>7. Payout (+)(-) = </td>
                                          <td><strong> $<?php echo number_format($ff, 2); ?></strong></td>
                                          </tr>
                                          <tr>
                                          <td>8. BuyBack (-) = </td>
                                          <td><strong> $<?php echo number_format($gg, 2); ?></strong></td>
                                          </tr>
                                          <tr>
                                          <td>9. Tax (-) = </td>
                                          <td><strong> $<?php echo number_format($hh, 2); ?></strong></td>
                                          </tr>
                                          <tr>
                                          <td>10. Current Cash = </td>
                                          <td><strong> $<?php echo number_format($ii, 2); ?></strong></td>
                                          </tr>
                                          <tr>
                                          <td>11. Current Credit Card = </td>
                                          <td><strong> $<?php echo number_format($jj, 2); ?></strong></td>
                                          </tr>
                                          <tr>
                                          <td>12. Current Total = </td>
                                          <td><strong> $<?php echo number_format($kk, 2); ?></strong></td>
                                          </tr>
                                          </tbody>
                                          </table> */ ?>
                                    </div>
                                </div>
                                <!-- /table condensed -->


                            </div>
                            <!-- /general form elements -->



                            <!-- Content End from here customized -->




                            <div class="separator-doubled"></div>

                            <?php
                            if (isset($_GET['from'])) {
                                $from = $_GET['from'];
                                $to = $_GET['to'];
                                $cashier_id = $_GET['cashier_id'];
                                ?>
                                <a id="export-grid" href="javascript:void(0);">
                                    <img src="pos_image/file_excel.png">
                                </a>
                                <a href="<?php echo $obj->filename(); ?>?export=pdf&amp;from=<?php echo $from; ?>&amp;to=<?php echo $to; ?>&amp;cashier_id=<?php echo $_GET['cashier_id']; ?>">
                                    <img src="pos_image/file_pdf.png">
                                </a>
                                <?php
                            } else {
                                ?>
                                <a id="export-grid" href="javascript:void(0);">
                                    <img src="pos_image/file_excel.png">
                                </a>
                                <a href="<?php echo $obj->filename(); ?>?export=pdf">
                                    <img src="pos_image/file_pdf.png">
                                </a>
                                <?php
                            }
                            ?>

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
        <?php //include('include/footer.php'); ?>
        <!-- Right sidebar -->
        <?php //include('include/sidebar_right.php');    ?>
        <!-- /right sidebar -->

    </div>
    <!-- /main wrapper -->

</body>
</html>
