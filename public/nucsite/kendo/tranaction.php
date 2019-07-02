<?php
include('class/auth.php');
include('class/report_customer.php');
$common = new report();
if ($input_status == 5) {
    include('class/report_chain_admin.php');
    $obj_report_chain = new chain_report();
    $array_ch = array();
    $sqlchain_store_ids = $obj->SelectAllByID("store_chain_admin", array("sid" => $input_by));
    if (!empty($sqlchain_store_ids))
        foreach ($sqlchain_store_ids as $ch):
            array_push($array_ch, $ch->store_id);
        endforeach;
}
if (isset($_GET['del'])) {
    if (@$_GET['payout']) {
        $obj->delete("payout", array("track_id" => $_GET['track_id']));
        $obj->deletesing("track_id", $_GET['track_id'], "transaction_log");
    } else {
        $obj->deletesing("id", $_GET['del'], "transaction_log");
    }
}

function tranaction_type($status) {
    if ($status == 1) {
        return "Store Opening Cash";
    } elseif ($status == 2) {
        return "Payout/Drop/Sales";
    } elseif ($status == 3) {
        return "Ticket/Checkin/Parts Order";
    } elseif ($status == 4) {
        return "Sales";
    } elseif ($status == 5) {
        return "Payout/Drop";
    } elseif ($status == 6) {
        return "BuyBack";
    } elseif ($status == 7) {
        return "Store Closing";
    }
}

function tender_type($status) {
    if ($status == 1) {
        return "Cash";
    } elseif ($status == 2) {
        return "Square";
    } elseif ($status == 3) {
        return "Cash";
    } elseif ($status == 4) {
        return "Credit Card";
    } elseif ($status == 5) {
        return "Cash";
    } elseif ($status == 6) {
        return "Cash &amp; Credit Card";
    } else {
        return $status;
    }
}

if (@$_GET['export'] == "excel") {


    if (isset($_GET['from'])) {
        if ($input_status == 1) {
            $from = $_GET['from'];
            $to = $_GET['to'];
            $sqlinvoice = $common->SelectAllDate("transaction_log", $from, $to, "1");
            $record = $common->SelectAllDate("transaction_log", $from, $to, "2");
            $record_label = "Total Record Found : " . $record . " | Report Generate Between " . $from . " - " . $to;
        } else {
            $from = $_GET['from'];
            $to = $_GET['to'];
            $sqlinvoice = $common->SelectAllDate_Store("transaction_log", $from, $to, "1", "input_by", $input_by);
            $record = $common->SelectAllDate_Store("transaction_log", $from, $to, "2", "input_by", $input_by);
            $record_label = "Total Record Found : " . $record . " | Report Generate Between " . $from . " - " . $to;
        }
    } elseif (isset($_GET['all'])) {
        if ($input_status == 1) {
            $sqlinvoice = $obj->SelectAll("transaction_log");
            $record = $obj->totalrows("transaction_log");
            $record_label = "Total Record Found : " . $record;
        } else {
            $sqlinvoice = $obj->SelectAllByID("transaction_log", array("input_by" => $input_by));
            $record = $obj->exists_multiple("transaction_log", array("input_by" => $input_by));
            $record_label = "Total Record Found : " . $record;
        }
    } else {
        if ($input_status == 1) {
            $sqlinvoice = $obj->SelectAllByID("transaction_log", array("date" => date('Y-m-d')));
            $record = $obj->exists_multiple("transaction_log", array("date" => date('Y-m-d')));
            $record_label = "Total Record Found : " . $record;
        } else {
            $sqlinvoice = $obj->SelectAllByID_Multiple("transaction_log", array("date" => date('Y-m-d'), "input_by" => $input_by));
            $record = $obj->exists_multiple("transaction_log", array("date" => date('Y-m-d'), "input_by" => $input_by));
            $record_label = "Total Record Found : " . $record;
        }
    }

    header('Content-type: application/excel');
    $filename = "Transaction_list_" . date('Y_m_d') . '.xls';
    header('Content-Disposition: attachment; filename=' . $filename);

    $data = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">
<head>
    <!--[if gte mso 9]>
    <xml>
        <x:ExcelWorkbook>
            <x:ExcelWorksheets>
                <x:ExcelWorksheet>
                    <x:Name>Transaction List : Wireless Geeks Inc.</x:Name>
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
    $data .="<h5>Transaction List Generate Date : " . date('d-m-Y H:i:s') . "</h5>";

    $data .="<table>
    <thead>
        <tr style='background:#09f; color:#fff;'>
			<th>#</th>
			<th>Transaction</th>
			<th>Shop</th>
			<th>Date</th>
			<th>Time</th>
			<th>Cashier</th>
			<th>Customer</th>
			<th>Amount</th>
			<th>Type</th>
			<th>Tender</th>
		</tr>
</thead>
<tbody>";





    $i = 1;
    $aa = 0;
    $bb = 0;
    if (!empty($sqlinvoice))
        foreach ($sqlinvoice as $invoice):
            if (substr($invoice->amount, 0, 1) == '-') {
                $bb+=substr($invoice->amount, 1, 1000);
                $ammm = number_format(substr($invoice->amount, 1, 1000), 2);
            } else {
                $aa+=$invoice->amount;
                $ammm = number_format($invoice->amount, 2);
            }

            $data.="<tr>
				<td>" . $i . "</td>
				<td>" . $invoice->transaction . "</td>
				<td>" . $obj->SelectAllByVal("store", "store_id", $invoice->sid, "name") . "</td>
				<td>" . $invoice->date . "</td>
				<td>" . $invoice->time . "</td>
				<td>" . $obj->SelectAllByVal("store", "id", $invoice->cashier_id, "name") . "</td>
				<td>" . $obj->SelectAllByVal("coustomer", "id", $invoice->customer_id, "firstname") . " " . $obj->SelectAllByVal("coustomer", "id", $invoice->customer_id, "lastname") . "</td>
				<td>" . $ammm . "</td>
				<td>" . tranaction_type($invoice->type) . "</td>
				<td>" . tender_type($invoice->tender) . "</td>
			</tr>";
            $i++;
        endforeach;

    $data .="</tbody><tfoot><tr>
			<th>#</th>
			<th>Transaction</th>
			<th>Shop</th>
			<th>Date</th>
			<th>Time</th>
			<th>Cashier</th>
			<th>Customer</th>
			<th>Amount</th>
			<th>Type</th>
			<th>Tender</th>
		</tr></tfoot></table>";


    $total = $aa - $bb;

    $data.="<table border='0' width='150' style='width:200px;'>
                                            <tbody>
												<tr>
													<td>1. Tranaction = </td>
													<td>$" . $aa . "</td>
												</tr>
                                                <tr>
													<td>2. Deduction ( - ) = </td>
													<td>$" . $bb . "</td>
												</tr>
                                                <tr>
													<td>3. Total = </td>
													<td>$" . $total . "</td>
												</tr>
                                            </tbody>
                                        </table>";

    $data .='</body></html>';

    echo $data;
}

if (@$_GET['export'] == "pdf") {
    if (isset($_GET['from'])) {
        if ($input_status == 1) {
            $from = $_GET['from'];
            $to = $_GET['to'];
            $sqlinvoice = $common->SelectAllDate("transaction_log", $from, $to, "1");
            $record = $common->SelectAllDate("transaction_log", $from, $to, "2");
            $record_label = "Total Record Found : " . $record . " | Report Generate Between " . $from . " - " . $to;
        } else {
            $from = $_GET['from'];
            $to = $_GET['to'];
            $sqlinvoice = $common->SelectAllDate_Store("transaction_log", $from, $to, "1", "input_by", $input_by);
            $record = $common->SelectAllDate_Store("transaction_log", $from, $to, "2", "input_by", $input_by);
            $record_label = "Total Record Found : " . $record . " | Report Generate Between " . $from . " - " . $to;
        }
    } elseif (isset($_GET['all'])) {
        if ($input_status == 1) {
            $sqlinvoice = $obj->SelectAll("transaction_log");
            $record = $obj->totalrows("transaction_log");
            $record_label = "Total Record Found : " . $record;
        } else {
            $sqlinvoice = $obj->SelectAllByID("transaction_log", array("input_by" => $input_by));
            $record = $obj->exists_multiple("transaction_log", array("input_by" => $input_by));
            $record_label = "Total Record Found : " . $record;
        }
    } else {
        if ($input_status == 1) {
            $sqlinvoice = $obj->SelectAllByID("transaction_log", array("date" => date('Y-m-d')));
            $record = $obj->exists_multiple("transaction_log", array("date" => date('Y-m-d')));
            $record_label = "Total Record Found : " . $record;
        } else {
            $sqlinvoice = $obj->SelectAllByID_Multiple("transaction_log", array("date" => date('Y-m-d'), "input_by" => $input_by));
            $record = $obj->exists_multiple("transaction_log", array("date" => date('Y-m-d'), "input_by" => $input_by));
            $record_label = "Total Record Found : " . $record;
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
						Transaction List Report
						</td>
					</tr>
				</table>

				<table style='width:100%; height:40px; border:0px; font-size:18px;'>
					<tr>
						<td> Transaction List Generate Date : " . date('d-m-Y H:i:s') . "</td>
					</tr>
				</table>
				<table style='width:960px;border:1px; font-size:12px; background:#ccc;'>";
    $html.="<thead>
        <tr style='background:#09f; color:#fff;'>
			<th>#</th>
			<th>Transaction</th>
			<th>Shop</th>
			<th>Date</th>
			<th>Time</th>
			<th>Cashier</th>
			<th>Customer</th>
			<th>Amount</th>
			<th>Type</th>
			<th>Tender</th>
		</tr>
</thead>
<tbody>";



    $i = 1;
    $aa = 0;
    $bb = 0;
    if (!empty($sqlinvoice))
        foreach ($sqlinvoice as $invoice):
            if (substr($invoice->amount, 0, 1) == '-') {
                $bb+=substr($invoice->amount, 1, 1000);
                $ammm = number_format(substr($invoice->amount, 1, 1000), 2);
            } else {
                $aa+=$invoice->amount;
                $ammm = number_format($invoice->amount, 2);
            }

            $html.="<tr>
				<td>" . $i . "</td>
				<td>" . $invoice->transaction . "</td>
				<td>" . $obj->SelectAllByVal("store", "store_id", $invoice->sid, "name") . "</td>
				<td>" . $invoice->date . "</td>
				<td>" . $invoice->time . "</td>
				<td>" . $obj->SelectAllByVal("store", "id", $invoice->cashier_id, "name") . "</td>
				<td>" . $obj->SelectAllByVal("coustomer", "id", $invoice->customer_id, "firstname") . " " . $obj->SelectAllByVal("coustomer", "id", $invoice->customer_id, "lastname") . "</td>
				<td>" . $ammm . "</td>
				<td>" . tranaction_type($invoice->type) . "</td>
				<td>" . tender_type($invoice->tender) . "</td>
			</tr>";
            $i++;
        endforeach;

    $html.="</tbody><tfoot><tr>
			<th>#</th>
			<th>Transaction</th>
			<th>Shop</th>
			<th>Date</th>
			<th>Time</th>
			<th>Cashier</th>
			<th>Customer</th>
			<th>Amount</th>
			<th>Type</th>
			<th>Tender</th>
		</tr></tfoot></table>";

    $total = $aa - $bb;

    $html.="<table border='0'  width='150' style='width:200px;'>
                                            <tbody>
												<tr>
													<td>1. Tranaction = </td>
													<td>$" . $aa . "</td>
												</tr>
                                                <tr>
													<td>2. Deduction ( - ) = </td>
													<td>$" . $bb . "</td>
												</tr>
                                                <tr>
													<td>3. Total = </td>
													<td>$" . $total . "</td>
												</tr>
                                            </tbody>
                                        </table>";

    $html.="</td></tr>";
    $html.="</tbody></table>";

    $mpdf = new mPDF('c', 'A4', '', '', 12, 25, 27, 25, 16, 13);

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
                <?php
                echo $obj->ShowMsg();
                if (isset($_GET['from'])) {
                    if ($input_status == 1) {
                        $from = $_GET['from'];
                        $to = $_GET['to'];
                        $sqlinvoice = $common->SelectAllDate("transaction_log", $from, $to, "1");
                        $record = $common->SelectAllDate("transaction_log", $from, $to, "2");
                        $record_label = "Total Record Found : " . $record . " | Report Generate Between " . $from . " - " . $to;
                    } elseif ($input_status == 5) {
                        $from = $_GET['from'];
                        $to = $_GET['to'];
                        $sqlinvoice = $obj_report_chain->ReportQuery_Datewise_Or("transaction_log", $array_ch, "input_by", $from, $to, "1");
                        $record = $obj_report_chain->ReportQuery_Datewise_Or("transaction_log", $array_ch, "input_by", $from, $to, "2");
                        $record_label = "Total Record Found : " . $record . " | Report Generate Between " . $from . " - " . $to;
                    } else {
                        $from = $_GET['from'];
                        $to = $_GET['to'];
                        $sqlinvoice = $common->SelectAllDate_Store("transaction_log", $from, $to, "1", "input_by", $input_by);
                        $record = $common->SelectAllDate_Store("transaction_log", $from, $to, "2", "input_by", $input_by);
                        $record_label = "Total Record Found : " . $record . " | Report Generate Between " . $from . " - " . $to;
                    }
                } elseif (isset($_GET['all'])) {
                    if ($input_status == 1) {
                        $sqlinvoice = $obj->SelectAll("transaction_log");
                        $record = $obj->totalrows("transaction_log");
                        $record_label = "Total Record Found : " . $record;
                    } elseif ($input_status == 5) {
                        $sqlinvoice = $obj_report_chain->SelectAllByID_Multiple_Or("transaction_log", $array_ch, "input_by", "1");
                        $record = $obj_report_chain->SelectAllByID_Multiple_Or("transaction_log", $array_ch, "input_by", "2");
                        $record_label = "Total Record Found : " . $record;
                    } else {
                        $sqlinvoice = $obj->SelectAllByID("transaction_log", array("input_by" => $input_by));
                        $record = $obj->exists_multiple("transaction_log", array("input_by" => $input_by));
                        $record_label = "Total Record Found : " . $record;
                    }
                } else {

                    if ($input_status == 1) {
                        $sqlinvoice = $obj->SelectAllByID("transaction_log", array("date" => date('Y-m-d')));
                        $record = $obj->exists_multiple("transaction_log", array("date" => date("Y-m-d")));
                        $record_label = "Total Record Found : " . $record;
                    } elseif ($input_status == 5) {
                        $sqlinvoice = $obj_report_chain->SelectAllByID_Multiple2_Or("transaction_log", array("date" => date('Y-m-d')), $array_ch, "input_by", "1");
                        $record = $obj_report_chain->SelectAllByID_Multiple2_Or("transaction_log", array("date" => date('Y-m-d')), $array_ch, "input_by", "2");
                        $record_label = "Total Record Found : " . $record;
                    } else {
                        $sqlinvoice = $obj->SelectAllByID_Multiple("transaction_log", array("input_by" => $input_by, "date" => date('Y-m-d')));
                        $record = $obj->exists_multiple("transaction_log", array("input_by" => $input_by, "date" => date('Y-m-d')));
                        $record_label = "Total Record Found : " . $record;
                    }
                }
                ?>
                <!-- /info notice -->
                <div class="outer">
                    <div class="inner">
                        <div class="page-header"><!-- Page header -->
                            <h5><i class="icon-shopping-cart"></i>Tranaction Log | <?php echo $record_label; ?> | <a  data-toggle="modal" href="#myModal"> Search Datewise </a>
                            </h5>
                            <ul class="icons">
                                <li><a href="<?php echo $obj->filename(); ?>" class="hovertip" title="Reload"><i class="font-refresh"></i></a></li>
                            </ul>
                        </div><!-- /page header -->

                        <div class="body">

                            <!-- Middle navigation standard -->
                            <?php //include('include/quicklink.php'); ?>
                            <!-- /middle navigation standard -->

                            <!-- Content container -->
                            <div class="container">
                                <!-- Dialog content -->
                                <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h5 id="myModalLabel"><i class="font-calendar"></i> Generate Transaction Log Report <span id="mss"></span></h5>
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
                                <!-- Content Start from here customized -->
                                <!-- Default datatable -->
                                <div class="block">
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
                                                        url: "./controller/tranaction.php",
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
                                                            url: "./controller/tranaction.php",
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
                                                                transaction: {type: "number"},
                                                                shop: {type: "string"},
                                                                date: {type: "string"},
                                                                time: {type: "string"},
                                                                cashier: {type: "string"},
                                                                customer: {type: "string"},
                                                                amount: {type: "string"},
                                                                type: {type: "string"},
                                                                tender: {type: "string"},
                                                                store_id: {type: "number"}
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
                                                        {field: "transaction", title: "Transaction"},
                                                        //{field: "store_id", title: "Store ID"},
                                                        //{field: "shop", title: "Shop"},
                                                        {field: "date", title: "Date"},
                                                        {field: "time", title: "Time", width: "60px", filterable: false},
                                                        {field: "cashier", title: "Cashier Name"},
                                                        {field: "customer", title: "Customer"},
                                                        {template: "<?php echo $currencyicon; ?>#=amount#", title: "Amount", filterable: false},
                                                        {field: "type", title: "Type", width: "60px"},
                                                        {field: "tender", title: "Tender"},
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
                                            JSONToCSVConvertor(json_data, "Tranaction", true);

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
                                            var fileName = "tranaction_";
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
                                          <th>Transaction</th>
                                          <th>Shop</th>
                                          <th>Date</th>
                                          <th>Time</th>
                                          <th>Cashier</th>
                                          <th>Customer</th>
                                          <th>Amount</th>
                                          <th>Type</th>
                                          <th>Tender</th>
                                          <th></th>
                                          </tr>
                                          </thead>
                                          <tbody>
                                          <?php
                                          $i=1;
                                          $aa=0;
                                          $bb=0;
                                          if (!empty($sqlinvoice))
                                          foreach ($sqlinvoice as $invoice):
                                          ?>
                                          <tr>
                                          <td><?php echo $i; ?></td>
                                          <td>
                                          <a href="view_sales.php?invoice=<?php echo $invoice->transaction; ?>" class="label label-important"><i class="font-money"></i> <?php echo $invoice->transaction; ?></a>
                                          </td>
                                          <td><?php echo $obj->SelectAllByVal("store", "store_id", $invoice->sid, "name"); ?></td>
                                          <td><?php echo $invoice->date; ?></td>
                                          <td><?php echo $invoice->time; ?></td>
                                          <td><?php echo $obj->SelectAllByVal("store", "id", $invoice->cashier_id, "name"); ?></td>
                                          <td><?php echo $obj->SelectAllByVal("coustomer", "id", $invoice->customer_id, "firstname") . " " . $obj->SelectAllByVal("coustomer", "id", $invoice->customer_id, "lastname"); ?></td>
                                          <td>$<?php
                                          if (substr($invoice->amount, 0, 1) == '-') {
                                          $bb+=substr($invoice->amount, 1, 1000);
                                          echo @number_format(substr($invoice->amount, 1, 1000), 2);
                                          }else {
                                          $aa+=$invoice->amount;
                                          echo @number_format($invoice->amount, 2);
                                          }
                                          ?></td>
                                          <td><?php echo tranaction_type($invoice->type); ?></td>                                            		<td><?php echo tender_type($invoice->tender); ?></td>
                                          <td>
                                          <?php
                                          if ($invoice->type == "5") {
                                          if ($input_status == 1 || $input_status == 2) {
                                          ?>
                                          <a href="<?php echo $obj->filename(); ?>?del=<?php echo $invoice->id; ?>&amp;track_id=<?php echo $invoice->track_id; ?>&amp;payout=1" class="hovertip" title="Delete" onclick="javascript:return confirm('Are you absolutely sure to delete This?')"><i class="icon-trash"></i></a>
                                          <?php
                                          }
                                          }else {
                                          if ($input_status == 1 || $input_status == 2) {
                                          ?>
                                          <a href="<?php echo $obj->filename(); ?>?del=<?php echo $invoice->id; ?>" class="hovertip" title="Delete" onclick="javascript:return confirm('Are you absolutely sure to delete This?')"><i class="icon-trash"></i></a>
                                          <?php
                                          }
                                          }
                                          ?>
                                          </td>
                                          </tr>
                                          <?php
                                          $i++;
                                          endforeach;
                                          ?>
                                          </tbody>
                                          </table> */ ?>
                                    </div>
                                </div>
                                <!-- /default datatable -->

                                <div class="block">
                                    <div class="table-overflow">
                                        <?php /* <table class="table span4" style="width:200px;">
                                          <tbody>
                                          <tr>
                                          <td>1. Tranaction = </td>
                                          <td>$<?php echo $aa; ?></td>
                                          </tr>
                                          <tr>
                                          <td>2. Deduction ( - ) = </td>
                                          <td>$<?php echo $bb; ?></td>
                                          </tr>
                                          <tr>
                                          <td>3. Total = </td>
                                          <td>$<?php
                                          $total=$aa - $bb;
                                          echo $total;
                                          ?></td>
                                          </tr>
                                          </tbody>
                                          </table> */ ?>
                                    </div>
                                </div>
                                <!-- /default datatable -->
                                <!-- Content End from here customized -->




                                <div class="separator-doubled"></div>
                                <?php
                                if (isset($_GET['from'])) {
                                    $from = $_GET['from'];
                                    $to = $_GET['to'];
                                    ?>
                                    <a id="export-grid" href="javascript:void(0);"><img src="pos_image/file_excel.png"></a>
                                    <a href="<?php echo $obj->filename(); ?>?export=pdf&amp;from=<?php echo $from; ?>&amp;to=<?php echo $to; ?>"><img src="pos_image/file_pdf.png"></a>
                                    <?php
                                } elseif (isset($_GET['all'])) {
                                    ?>
                                    <a id="export-grid" href="javascript:void(0);"><img src="pos_image/file_excel.png"></a>
                                    <a href="<?php echo $obj->filename(); ?>?export=pdf&amp;all=pdf"><img src="pos_image/file_pdf.png"></a>
                                    <?php
                                } else {
                                    ?>
                                    <a id="export-grid" href="javascript:void(0);"><img src="pos_image/file_excel.png"></a>
                                    <a href="<?php echo $obj->filename(); ?>?export=pdf"><img src="pos_image/file_pdf.png"></a>
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
            <?php //include('include/sidebar_right.php');       ?>
            <!-- /right sidebar -->

        </div>
        <!-- /main wrapper -->

    </body>
</html>
