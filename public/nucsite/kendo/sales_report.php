<?php
include('class/auth.php');
include('class/report_customer.php');
$report = new report();
$table = "coustomer";
include('class/report_chain_admin.php');
$obj_report_chain = new chain_report();
if (@$_GET['export'] == "excel") {
    if ($input_status == 1) {
        if (isset($_GET['from'])) {
            $from = $_GET['from'];
            $to = $_GET['to'];
            $sqlinvoice = $report->SelectAllDateCond("invoice", "doc_type", "3", $from, $to, "1");
            $record = $report->SelectAllDateCond("invoice", "doc_type", "3", $from, $to, "2");
            $record_label = "Report Generate Between " . $from . " - " . $to;
        } else {
            $sqlinvoice = $obj->SelectAllByID_Multiple("invoice", array("doc_type" => 3));
            $record = $obj->exists_multiple("invoice", array("doc_type" => 3));
            $record_label = "";
        }
    } elseif ($input_status == 5) {

        $sqlchain_store_ids = $obj->SelectAllByID("store_chain_admin", array("sid" => $input_by));
        if (!empty($sqlchain_store_ids)) {
            $array_ch = array();
            foreach ($sqlchain_store_ids as $ch):
                array_push($array_ch, $ch->store_id);
            endforeach;

            if (isset($_GET['from'])) {

                $sqlinvoice = $obj_report_chain->ReportQuery_Datewise_Or_array("invoice", array("doc_type" => 3), $array_ch, "input_by", $_GET['from'], $_GET['to'], "1");
                $record = $obj_report_chain->ReportQuery_Datewise_Or_array("invoice", array("doc_type" => 3), $array_ch, "input_by", $_GET['from'], $_GET['to'], "2");
                $record_label = "Report Generate Between " . $_GET['from'] . " - " . $_GET['to'];
            } else {


                $sqlinvoice = $obj_report_chain->SelectAllByID_Multiple2_Or("invoice", array("doc_type" => 3, "date" => date('Y-m-d')), $array_ch, "input_by", "1");
                $record = $obj_report_chain->SelectAllByID_Multiple2_Or("invoice", array("doc_type" => 3, "date" => date('Y-m-d')), $array_ch, "input_by", "2");
                $record_label = "Report Generate Between " . date('Y-m-d');
            }
            //echo "Work";
        } else {
            //echo "Not Work";
            $sql_coustomer = "";
        }
    } else {
        if (isset($_GET['from'])) {
            $from = $_GET['from'];
            $to = $_GET['to'];
            $sqlinvoice = $report->SelectAllDateCond_store2("invoice", "doc_type", "3", "invoice_creator", $input_by, $from, $to, "1");
            $record = $report->SelectAllDateCond_store2("invoice", "doc_type", "3", "invoice_creator", $input_by, $from, $to, "2");
            $record_label = "Report Generate Between " . $from . " - " . $to;
        } else {
            $sqlinvoice = $obj->SelectAllByID_Multiple("invoice", array("doc_type" => 3, "invoice_creator" => $input_by));
            $record = $obj->exists_multiple("invoice", array("doc_type" => 3, "invoice_creator" => $input_by));
            $record_label = "";
        }
    }

    header('Content-type: application/excel');
    $filename = "Sales_Report_list_" . date('Y_m_d') . '.xls';
    header('Content-Disposition: attachment; filename=' . $filename);
//    header("Content-Type: application/vnd.ms-excel");
    //$data="<html>";
    //$data .="<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">";
    $data = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">
<head>
    <!--[if gte mso 9]>
    <xml>
        <x:ExcelWorkbook>
            <x:ExcelWorksheets>
                <x:ExcelWorksheet>
                    <x:Name>Sales Report List : Wireless Geeks Inc.</x:Name>
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
    $data .="<h5>Sales Report List Generate Date : " . date('d-m-Y H:i:s') . "</h5>";

    $data .="<table>
    <thead>
        <tr style='background:#09f; color:#fff;'>
			<th>#</th>
			<th>Invoice-ID</th>";
    if ($input_status == 5) {

        $data .="<th>Store</th>";
    }
    $data .="<th>Customer</th>
    <th>Status</th>
    <th>Tender</th>
    <th>Date</th>
    <th>Item</th>
    <th>Total</th>
    </tr>
    </thead>
    <tbody>";

    $a = 0;
    $a1 = 0;
    $a2 = 0;
    $i = 1;
    if (!empty($sqlinvoice))
        foreach ($sqlinvoice as $invoice):
            $sqlitem = $obj->SelectAllByID_Multiple("sales", array("sales_id" => $invoice->invoice_id));
            $item_q = 0;
            $total = 0;
            if (!empty($sqlitem))
                foreach ($sqlitem as $item):
                    $rr = $item->quantity * $item->single_cost;

                    if ($obj->exists_multiple("pos_tax", array("invoice_id" => $invoice->invoice_id, "status" => 2)) == 0) {
                        $taxchk = 1;
                    } else {
                        $taxchk = 0;
                    }
                    if ($taxchk == 0) {
                        $tax = 0;
                    } else {
                        $tax = ($rr * $tax_per_product) / 100;
                    }

                    $tot = $rr + $tax;
                    $total+=$tot;
                    $item_q+=$item->quantity;
                endforeach;
            if ($total != 0) {
                $a+=1;

                $chkpayment_id = $obj->SelectAllByVal("invoice_payment", "invoice_id", $invoice->invoice_id, "payment_type");
                $a1+=$item_q;
                $a2+=$total;
                $data .="<tr>
				<td>" . $i . "</td>
				<td>" . $invoice->invoice_id . "</td>";
                if ($input_status == 5) {

                    $data .="<td>" . $obj->SelectAllByVal("store", "store_id", $invoice->input_by, "name") . "</td>";
                }
                $data .="<td>" . $obj->SelectAllByVal("coustomer", "id", $invoice->cid, "businessname") . "-" . $obj->SelectAllByVal("coustomer", "id", $invoice->cid, "firstname") . "" . $obj->SelectAllByVal("coustomer", "id", $invoice->cid, "lastname") . "</td>
				<td>" . $obj->invoice_paid_status($invoice->status) . "</td>
				<td>" . $obj->SelectAllByVal("payment_method", "id", $chkpayment_id, "meth_name") . "</td>
				<td>" . $invoice->date . "</td>
				<td>" . $item_q . "</td>
				<td>" . number_format($total, 2) . "</td>
			</tr>";

                $i++;
            } endforeach;

    $data .="</tbody><tfoot><tr>
			<th>#</th>
			<th>Invoice-ID</th>";
    if ($input_status == 5) {

        $data .="<th>Store</th>";
    }
    $data .="<th>Customer</th>
			<th>Status</th>
			<th>Tender</th>
			<th>Date</th>
			<th>Item</th>
			<th>Total</th>
		</tr></tfoot></table>";




    $data .="<table border='0' width='250' style='width:200px;'>
					<tbody>
						<tr>
							<td>1. Total Quantity = <strong> " . $a . "</strong></td>
						</tr>
						<tr>
							<td>2. Total Quantity Sold  = <strong> " . $a1 . "</strong></td>
						</tr>
						<tr>
							<td>4. Total Sales = <strong> $" . number_format($a2, 2) . "</strong></td>
						</tr>
					</tbody>
				</table>";

    $data .='</body></html>';
    //header("Content-type: application/vnd.ms-excel");
    //header("Content-Disposition: attachment;Filename=document_name.xls");
    echo $data;
    exit();
}

if (@$_GET['export'] == "pdf") {
    if ($input_status == 1) {
        if (isset($_GET['from'])) {
            $from = $_GET['from'];
            $to = $_GET['to'];
            $sqlinvoice = $report->SelectAllDateCond("invoice", "doc_type", "3", $from, $to, "1");
            $record = $report->SelectAllDateCond("invoice", "doc_type", "3", $from, $to, "2");
            $record_label = "Report Generate Between " . $from . " - " . $to;
        } else {
            $sqlinvoice = $obj->SelectAllByID_Multiple("invoice", array("doc_type" => 3));
            $record = $obj->exists_multiple("invoice", array("doc_type" => 3));
            $record_label = "";
        }
    } elseif ($input_status == 5) {
        $sqlchain_store_ids = $obj->SelectAllByID("store_chain_admin", array("sid" => $input_by));
        if (!empty($sqlchain_store_ids)) {
            $array_ch = array();
            foreach ($sqlchain_store_ids as $ch):
                array_push($array_ch, $ch->store_id);
            endforeach;

            if (isset($_GET['from'])) {

                $sqlinvoice = $obj_report_chain->ReportQuery_Datewise_Or_array("invoice", array("doc_type" => 3), $array_ch, "input_by", $_GET['from'], $_GET['to'], "1");
                $record = $obj_report_chain->ReportQuery_Datewise_Or_array("invoice", array("doc_type" => 3), $array_ch, "input_by", $_GET['from'], $_GET['to'], "2");
                $record_label = "Report Generate Between " . $_GET['from'] . " - " . $_GET['to'];
            } else {


                $sqlinvoice = $obj_report_chain->SelectAllByID_Multiple2_Or("invoice", array("doc_type" => 3, "date" => date('Y-m-d')), $array_ch, "input_by", "1");
                $record = $obj_report_chain->SelectAllByID_Multiple2_Or("invoice", array("doc_type" => 3, "date" => date('Y-m-d')), $array_ch, "input_by", "2");
                $record_label = "Report Generate Between " . date('Y-m-d');
            }
            //echo "Work";
        } else {
            //echo "Not Work";
            $sql_coustomer = "";
        }
    } else {
        if (isset($_GET['from'])) {
            $from = $_GET['from'];
            $to = $_GET['to'];
            $sqlinvoice = $report->SelectAllDateCond_store2("invoice", "doc_type", "3", "invoice_creator", $input_by, $from, $to, "1");
            $record = $report->SelectAllDateCond_store2("invoice", "doc_type", "3", "invoice_creator", $input_by, $from, $to, "2");
            $record_label = "Report Generate Between " . $from . " - " . $to;
        } else {
            $sqlinvoice = $obj->SelectAllByID_Multiple("invoice", array("doc_type" => 3, "invoice_creator" => $input_by));
            $record = $obj->exists_multiple("invoice", array("doc_type" => 3, "invoice_creator" => $input_by));
            $record_label = "";
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
						Sales Report List Report
						</td>
					</tr>
				</table>


				<table style='width:100%; height:40px; border:0px; font-size:18px;'>
					<tr>
						<td> Sales Report List Generate Date : " . date('d-m-Y H:i:s') . "</td>
					</tr>
				</table>
				<table style='width:960px;border:1px; font-size:12px; background:#ccc;'>";
    $html .="<thead>
        <tr style='background:#09f; color:#fff;'>
			<th>#</th>
			<th>Invoice-ID</th>";
    if ($input_status == 5) {

        $html .="<th>Store</th>";
    }
    $html .="<th>Customer</th>
			<th>Status</th>
			<th>Tender</th>
			<th>Date</th>
			<th>Item</th>
			<th>Total</th>
		</tr>
</thead>
<tbody>";


    $a = 0;
    $a1 = 0;
    $a2 = 0;
    $i = 1;
    if (!empty($sqlinvoice))
        foreach ($sqlinvoice as $invoice):
            $sqlitem = $obj->SelectAllByID_Multiple("sales", array("sales_id" => $invoice->invoice_id));
            $item_q = 0;
            $total = 0;
            if (!empty($sqlitem))
                foreach ($sqlitem as $item):
                    $rr = $item->quantity * $item->single_cost;

                    if ($obj->exists_multiple("pos_tax", array("invoice_id" => $invoice->invoice_id, "status" => 2)) == 0) {
                        $taxchk = 1;
                    } else {
                        $taxchk = 0;
                    }
                    if ($taxchk == 0) {
                        $tax = 0;
                    } else {
                        $tax = ($rr * $tax_per_product) / 100;
                    }

                    $tot = $rr + $tax;
                    $total+=$tot;
                    $item_q+=$item->quantity;
                endforeach;
            if ($total != 0) {
                $a+=1;

                $chkpayment_id = $obj->SelectAllByVal("invoice_payment", "invoice_id", $invoice->invoice_id, "payment_type");
                $a1+=$item_q;
                $a2+=$total;
                $html .="<tr>
				<td>" . $i . "</td>
				<td>" . $invoice->invoice_id . "</td>";
                if ($input_status == 5) {

                    $html .="<td>" . $obj->SelectAllByVal("store", "store_id", $invoice->input_by, "name") . "</td>";
                }
                $html .="<td>" . $obj->SelectAllByVal("coustomer", "id", $invoice->cid, "businessname") . "-" . $obj->SelectAllByVal("coustomer", "id", $invoice->cid, "firstname") . "" . $obj->SelectAllByVal("coustomer", "id", $invoice->cid, "lastname") . "</td>
                        <td>" . $obj->invoice_paid_status($invoice->status) . "</td>
                        <td>" . $obj->SelectAllByVal("payment_method", "id", $chkpayment_id, "meth_name") . "</td>
                        <td>" . $invoice->date . "</td>
                        <td>" . $item_q . "</td>
                        <td>" . number_format($total, 2) . "</td>
                        </tr>";

                $i++;
            } endforeach;

    $html.="</tbody><tfoot><tr>
                                <th>#</th>
                                <th>Invoice-ID</th>";
    if ($input_status == 5) {

        $html .="<th>Store</th>";
    }
    $html .="<th>Customer</th>
                                <th>Status</th>
                                <th>Tender</th>
                                <th>Date</th>
                                <th>Item</th>
                                <th>Total</th>
                            </tr></tfoot></table>";

    $html.="<table border='0'  width='250' style='width:200px;'>
                            <tbody>
                                <tr>
                                    <td>1. Total Quantity = <strong> " . $a . "</strong></td>
                                </tr>
                                <tr>
                                    <td>2. Total Quantity Sold  = <strong> " . $a1 . "</strong></td>
                                </tr>
                                <tr>
                                    <td>4. Total Sales = <strong> $" . number_format($a2, 2) . "</strong></td>
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
        <script src="ajax/customer_ajax.js"></script>
    </head>
    <body>
        <?php include ('include/header.php'); ?>
        <!-- Main wrapper -->
        <div class="wrapper three-columns">
            <!-- Left sidebar -->
            <?php include ('include/sidebar_left.php'); ?>
            <!-- /left sidebar -->
            <!-- Main content -->
            <div class="content">

                <!-- Info notice -->
                <?php echo $obj->ShowMsg(); ?>
                <!-- /info notice -->

                <div class="outer">
                    <div class="inner">
                        <div class="page-header"><!-- Page header -->
                            <?php
                            echo $obj->ShowMsg();
//                            if ($input_status == 1) {
//                                if (isset($_GET['from'])) {
//                                    $from = $_GET['from'];
//                                    $to = $_GET['to'];
//                                    $sqlinvoice = $report->SelectAllDateCond("invoice", "doc_type", "3", $from, $to, "1");
//                                    $record = $report->SelectAllDateCond("invoice", "doc_type", "3", $from, $to, "2");
//                                    $record_label = "Report Generate Between " . $from . " - " . $to;
//                                } else {
//                                    $sqlinvoice = $obj->SelectAllByID_Multiple("invoice", array("doc_type" => 3, "date" => date('Y-m-d')));
//                                    $record = $obj->exists_multiple("invoice", array("doc_type" => 3, "date" => date('Y-m-d')));
//                                    $record_label = "";
//                                }
//                            } elseif ($input_status == 5) {
//
//                                $sqlchain_store_ids = $obj->SelectAllByID("store_chain_admin", array("sid" => $input_by));
//                                if (!empty($sqlchain_store_ids)) {
//                                    $array_ch = array();
//                                    foreach ($sqlchain_store_ids as $ch):
//                                        array_push($array_ch, $ch->store_id);
//                                    endforeach;
//                                    if (isset($_GET['from'])) {
//                                        $sqlinvoice = $obj_report_chain->ReportQuery_Datewise_Or_array("invoice", array("doc_type" => 3), $array_ch, "input_by", $_GET['from'], $_GET['to'], "1");
//                                        $record = $obj_report_chain->ReportQuery_Datewise_Or_array("invoice", array("doc_type" => 3), $array_ch, "input_by", $_GET['from'], $_GET['to'], "2");
//                                        $record_label = "Report Generate Between " . $_GET['from'] . " - " . $_GET['to'];
//                                    } else {
//
//
//                                        $sqlinvoice = $obj_report_chain->SelectAllByID_Multiple2_Or("invoice", array("doc_type" => 3, "date" => date('Y-m-d')), $array_ch, "input_by", "1");
//                                        $record = $obj_report_chain->SelectAllByID_Multiple2_Or("invoice", array("doc_type" => 3, "date" => date('Y-m-d')), $array_ch, "input_by", "2");
//                                        $record_label = "Report Generate Between " . date('Y-m-d');
//                                    }
//                                    //echo "Work";
//                                } else {
//                                    //echo "Not Work";
//                                    $sql_coustomer = "";
//                                }
//                            } else {
//                                if (isset($_GET['from'])) {
//                                    $from = $_GET['from'];
//                                    $to = $_GET['to'];
//                                    $sqlinvoice = $report->SelectAllDateCond_store2("invoice", "doc_type", "3", "invoice_creator", $input_by, $from, $to, "1");
//                                    $record = $report->SelectAllDateCond_store2("invoice", "doc_type", "3", "invoice_creator", $input_by, $from, $to, "2");
//                                    $record_label = "Report Generate Between " . $from . " - " . $to;
//                                } else {
//                                    $sqlinvoice = $obj->SelectAllByID_Multiple("invoice", array("doc_type" => 3, "invoice_creator" => $input_by, "date" => date('Y-m-d')));
//                                    $record = $obj->exists_multiple("invoice", array("doc_type" => 3, "invoice_creator" => $input_by, "date" => date('Y-m-d')));
//                                    $record_label = "";
//                                }
//                            }
                            ?>
                            <h5><i class="icon-shopping-cart"></i> Sales Report | <a  data-toggle="modal" href="#myModal"> Search Datewise </a></h5>
                        </div><!-- /page header -->

                        <div class="body">

                            <!-- Middle navigation standard -->
                            <?php //include('include/quicklink.php');         ?>
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
                                            <h5 id="myModalLabel"><i class="font-calendar"></i> Generate Sales Report <span id="mss"></span></h5>
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

                                    <div class="table-overflow">
                                        <div id="grid" style="margin-left: 10px;margin-right: 10px;"></div>

                                        <script type="text/javascript">
                                            jQuery(document).ready(function () {
                                                var dataSource = new kendo.data.DataSource({
                                                    transport: {
                                                        read: {
                                                            url: "./controller/sales_report.php",
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
                                                                customer: {type: "string"},
                                                                pty: {type: "string"},
                                                                status: {type: "string"},
                                                                paid_amount: {type: "string"},
                                                                date: {type: "string"},
                                                                quantity: {type: "number"},
                                                                sales_amount: {type: "string"}
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
                                                        {field: "id", title: "S.ID", width: "60px"},
                                                        {field: "invoice_id", title: "Invoice-ID", width: "90px"},
                                                        {field: "customer", title: "Customer", width: "90px"},
                                                        {field: "pty", title: "Tender", width: "80px"},
                                                        {field: "status", title: "Status", width: "90px"},
                                                        {field: "date", title: "Date", width: "50px"},
                                                        {title: "Item", width: "50px", field: "quantity"},
                                                        {template: "<?php echo $currencyicon; ?>#=sales_amount#", title: "Total", width: "50px"}
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
                                            JSONToCSVConvertor(json_data, "Sales Report", true);

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
                                            var fileName = "sales_report_";
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
                                        <?php /* <table class="table table-striped" id="data-table">
                                          <thead>
                                          <tr>
                                          <th>#</th>
                                          <th>Invoice-ID</th>
                                          <?php
                                          if ($input_status == 5) {
                                          ?>
                                          <th>Store</th>
                                          <?php
                                          }
                                          ?>
                                          <th>Customer</th>
                                          <th>Status</th>
                                          <th>Tender</th>
                                          <th>Date</th>
                                          <th>Item</th>
                                          <th>Total</th>
                                          <?php if ($input_status == 1) { ?>
                                          <th>Action</th>
                                          <?php } ?>
                                          </tr>
                                          </thead>
                                          <tbody>
                                          <?php
                                          $a = 0;
                                          $a1 = 0;
                                          $a2 = 0;
                                          $i = 1;
                                          if (!empty($sqlinvoice))
                                          foreach ($sqlinvoice as $invoice):
                                          ?>
                                          <?php
                                          $sqlitem = $obj->SelectAllByID_Multiple("sales", array("sales_id" => $invoice->invoice_id));
                                          $item_q = 0;
                                          $total = 0;
                                          if (!empty($sqlitem))
                                          foreach ($sqlitem as $item):

                                          $rr = $item->quantity * $item->single_cost;

                                          if ($obj->exists_multiple("pos_tax", array("invoice_id" => $invoice->invoice_id, "status" => 2)) == 0) {
                                          $taxchk = 1;
                                          } else {
                                          $taxchk = 0;
                                          }

                                          if ($taxchk == 0) {
                                          $tax = 0;
                                          } else {
                                          $tax = ($rr * $tax_per_product) / 100;
                                          }

                                          $tot = $rr + $tax;
                                          $total+=$tot;
                                          $item_q+=$item->quantity;
                                          endforeach;
                                          if ($total != 0) {
                                          $a+=1;
                                          ?>
                                          <tr>
                                          <td><?php echo $i; ?></td>
                                          <td><a href="view_sales.php?invoice=<?php echo $invoice->invoice_id; ?>" class="label label-important"><i class="font-money"></i> <?php echo $invoice->invoice_id; ?></a></td>
                                          <?php
                                          if ($input_status == 5) {
                                          ?>
                                          <td><?php echo $obj->SelectAllByVal("store", "store_id", $invoice->input_by, "name"); ?></td>
                                          <?php
                                          }
                                          ?>
                                          <td><?php echo $obj->SelectAllByVal("coustomer", "id", $invoice->cid, "businessname") . "-" . $obj->SelectAllByVal("coustomer", "id", $invoice->cid, "firstname") . "" . $obj->SelectAllByVal("coustomer", "id", $invoice->cid, "lastname"); ?></td>
                                          <td><label class="label label-success"> <?php echo $obj->invoice_paid_status($invoice->status); ?> </label></td>
                                          <td><label class="label label-warning">
                                          <?php
                                          $chkpayment_id = $obj->SelectAllByVal("invoice_payment", "invoice_id", $invoice->invoice_id, "payment_type");
                                          echo $obj->SelectAllByVal("payment_method", "id", $chkpayment_id, "meth_name");
                                          ?>
                                          </label></td>

                                          <td><label class="label label-primary"><i class="icon-calendar"></i> <?php echo $invoice->date; ?></label></td>
                                          <td><?php
                                          echo $item_q;
                                          $a1+=$item_q;
                                          ?></td>
                                          <td>$<?php
                                          echo number_format($total, 2);
                                          $a2+=$total;
                                          ?></td>



                                          <?php if ($input_status == 1) { ?>
                                          <td>  <a target="_blank" href="pos.php?action=pdf&invoice=<?php echo $invoice->invoice_id; ?>" class="hovertip" title="Print" onclick="javascript:return  confirm('Are you absolutely sure to Print This Sales ?')"><i class="icon-print"></i></a>

                                          <a href="<?php echo $obj->filename(); ?>?del=<?php echo $invoice->id; ?>" class="hovertip" title="Delete" onclick="javascript:return confirm('Are you absolutely sure to delete This Sales ?')"><i class="icon-remove"></i></a>
                                          </td> <?php } ?>

                                          </tr>
                                          <?php
                                          $i++;
                                          } endforeach;





                                          SELECT
                                          //                            inv.id,
                                          //                            inv.invoice_id,
                                          //                            CONCAT(cos.firstname,' ', cos.lastname) AS customer_name,
                                          //                            CASE inv.status WHEN 1 THEN 'Not Yet'
                                          //                            ELSE CASE inv.status WHEN 2 THEN 'Paid'
                                          //                            ELSE CASE inv.status WHEN 3 THEN 'Paid'
                                          //                            ELSE CASE inv.status WHEN 4 THEN 'Partial'
                                          //                            END END END END AS statuss,
                                          //                            pm.meth_name,
                                          //                            inv.date
                                          //                            FROM invoice AS inv
                                          //                            LEFT JOIN coustomer AS cos ON cos.id = inv.cid
                                          //                            LEFT JOIN payment_method AS pm ON pm.meth_name= inv.invoice_id
                                          ?>
                                          </tbody>
                                          </table>
                                          </div>
                                          <div class="block well span4" style="margin-left:0; margin-top:20px;">
                                          <div class="navbar">
                                          <div class="navbar-inner">
                                          <h5> Sales Short Report</h5>
                                          </div>
                                          </div>
                                          <div class="table-overflow">
                                          <table class="table table-condensed">
                                          <tbody>
                                          <tr>
                                          <td>1. Total Quantity = <strong> <?php echo $a; ?></strong></td>
                                          </tr>
                                          <tr>
                                          <td>2. Total Quantity Sold  = <strong> <?php echo $a1; ?></strong></td>
                                          </tr>
                                          <tr>
                                          <td>4. Total Sales = <strong> $<?php echo number_format($a2, 2); ?></strong></td>
                                          </tr>
                                          <?php ?>

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
                                ?>
                                <a id="export-grid" href="javascript:void(0);">
                                    <img src="pos_image/file_excel.png">
                                </a>
                                <a href="<?php echo $obj->filename(); ?>?export=pdf&amp;from=<?php echo $from; ?>&amp;to=<?php echo $to; ?>">
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
        <!-- Right sidebar -->
        <?php //include('include/sidebar_right.php');          ?>
        <!-- /right sidebar -->

    </div>
    <!-- /main wrapper -->

</body>
</html>
