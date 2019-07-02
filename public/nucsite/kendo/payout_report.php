<?php
include('class/auth.php');
include('class/report_customer.php');
$report = new report();
$table = "payout";

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
    $obj->delete("payout", array("track_id" => $_GET['track_id']));
    $obj->deletesing("track_id", $_GET['track_id'], "transaction_log");
}
if (@$_GET['export'] == "excel") {
    if ($input_status == 1) {
        if (isset($_GET['from'])) {
            $from = $_GET['from'];
            $to = $_GET['to'];
            $sqlticket = $report->SelectAllDate("payout", $from, $to, "1");
            $record = $report->SelectAllDate("payout", $from, $to, "2");
            $record_label = "Report Generate Between " . $from . " - " . $to;
        } else {
            $sqlticket = $obj->SelectAll("payout");
            $record = $obj->totalrows("payout");
            $record_label = "";
        }
    } elseif ($input_status == 2) {
        if (isset($_GET['from'])) {
            $from = $_GET['from'];
            $to = $_GET['to'];
            $sqlticket = $report->SelectAllDate_Store("payout", $from, $to, "1", "uid", $input_by);
            $record = $report->SelectAllDate_Store("payout", $from, $to, "2", "uid", $input_by);
            $record_label = "Report Generate Between " . $from . " - " . $to;
        } else {
            $sqlticket = $obj->SelectAllByID("payout", array("uid" => $input_by));
            $record = $obj->exists_multiple("payout", array("uid" => $input_by));
            $record_label = "";
        }
    } elseif ($input_status == 3) {
        include('class/pos_class.php');
        $obj_pos = new pos();
        $cashiers_id = $obj_pos->cashier_actual_id(@$_SESSION['SESS_CASHIER_ID']);
        if (isset($_GET['from'])) {
            $from = $_GET['from'];
            $to = $_GET['to'];
            $sqlticket = $report->SelectAllDate_Store("payout", $from, $to, "1", "cashier_id", $cashiers_id);
            $record = $report->SelectAllDate_Store("payout", $from, $to, "2", "cashier_id", $cashiers_id);
            $record_label = "| Report Generate Between " . $from . " - " . $to;
        } else {
            $sqlticket = $obj->SelectAllByID("payout", array("cashier_id" => $cashiers_id));
            $record = $obj->exists_multiple("payout", array("cashier_id" => $cashiers_id));
            $record_label = "";
        }
    } elseif ($input_status == 4) {
        if (isset($_GET['from'])) {
            $from = $_GET['from'];
            $to = $_GET['to'];
            $sqlticket = $report->SelectAllDate_Store("payout", $from, $to, "1", "uid", $input_by);
            $record = $report->SelectAllDate_Store("payout", $from, $to, "2", "uid", $input_by);
            $record_label = "| Report Generate Between " . $from . " - " . $to;
        } else {
            $sqlticket = $obj->SelectAllByID("payout", array("uid" => $input_by));
            $record = $obj->exists_multiple("payout", array("uid" => $input_by));
            $record_label = "";
        }
    } elseif ($input_status == 5) {
        if (isset($_GET['from'])) {
            $from = $_GET['from'];
            $to = $_GET['to'];

            $sqlticket = $obj_report_chain->ReportQuery_Datewise_Or("payout", $array_ch, "uid", $from, $to, "1");
            $record = $obj_report_chain->ReportQuery_Datewise_Or("payout", $array_ch, "uid", $from, $to, "2");
            $record_label = "| Report Generate Between " . $from . " - " . $to;
        } else {
            $sqlticket = $obj_report_chain->SelectAllByID_Multiple2_Or("payout", array("date" => date('Y-m-d')), $array_ch, "uid", "1");
            $record = $obj_report_chain->SelectAllByID_Multiple2_Or("payout", array("date" => date('Y-m-d')), $array_ch, "uid", "2");
            $record_label = "";
        }
    }

    header('Content-type: application/excel');
    $filename = "Payout_list_" . date('Y_m_d') . '.xls';
    header('Content-Disposition: attachment; filename=' . $filename);

    $data = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">
<head>
    <!--[if gte mso 9]>
    <xml>
        <x:ExcelWorkbook>
            <x:ExcelWorksheets>
                <x:ExcelWorksheet>
                    <x:Name>Payout List : Wireless Geeks Inc.</x:Name>
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
    $data .="<h5>Payout List Generate Date : " . date('d-m-Y H:i:s') . "</h5>";

    $data .="<table>
    <thead>
        <tr style='background:#09f; color:#fff;'>
			<th>#</th>
			<th>Store</th>
			<th>Cashier</th>
			<th>Amount</th>
			<th>Reason</th>
			<th>Date</th>
		</tr>
</thead>        
<tbody>";

    $i = 1;
    $a = 0;
    $a1 = 0;
    $a2 = 0;
    //$dd3=0;
    //$dd4=0;
    //$dd5=0;
    if (!empty($sqlticket))
        foreach ($sqlticket as $ticket):
            ///$a1+=1;
            //$a2+=$ticket->amount;
            if (substr($ticket->amount, 0, 1) == "+") {
                $am = substr($ticket->amount, 1, 100);
                $a1+=$am;
            } elseif (substr($ticket->amount, 0, 1) == "-") {
                $am = substr($ticket->amount, 1, 100);
                $a2+=$am;
            } else {
                $am = $ticket->amount;
                $a1+=$am;
            }
            $a+=1;

            $data.="<tr>
				<td>" . $i . "</td>
				<td>" . $obj->SelectAllByVal("store", "store_id", $ticket->uid, "name") . "</td>
				<td>" . $obj->SelectAllByVal("store", "id", $ticket->cashier_id, "name") . "</td>
				<td>" . number_format($ticket->amount, 2) . "</td>
				<td>" . $ticket->reason . "</td>
				<td>" . $ticket->date . "</td>
			</tr>";
            $i++;
        endforeach;

    $data .="</tbody><tfoot><tr>
			<th>#</th>
			<th>Store</th>
			<th>Cashier</th>
			<th>Amount</th>
			<th>Reason</th>
			<th>Date</th>
		</tr></tfoot></table>";


    $tot = $a1 - $a2;

    $data.="<table border='0' width='250' style='width:200px;'>
					<tbody>
						<tr>
							<td>1. Total Quantity = <strong>" . $a . "</strong></td>
						</tr>
						<tr>
							<td>2. Total Payout (+)(-) = <strong> $" . number_format($tot, 2) . "</strong></td>
						</tr>
						<tr>
							<td>3. Total Payout (+) = <strong> $" . number_format($a1, 2) . "</strong></td>
						</tr>
						<tr>
							<td>4. Total Payout (-) = <strong> $" . number_format($a2, 2) . "</strong></td>
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
            $sqlticket = $report->SelectAllDate("payout", $from, $to, "1");
            $record = $report->SelectAllDate("payout", $from, $to, "2");
            $record_label = "Report Generate Between " . $from . " - " . $to;
        } else {
            $sqlticket = $obj->SelectAll("payout");
            $record = $obj->totalrows("payout");
            $record_label = "";
        }
    } elseif ($input_status == 2) {
        if (isset($_GET['from'])) {
            $from = $_GET['from'];
            $to = $_GET['to'];
            $sqlticket = $report->SelectAllDate_Store("payout", $from, $to, "1", "uid", $input_by);
            $record = $report->SelectAllDate_Store("payout", $from, $to, "2", "uid", $input_by);
            $record_label = "Report Generate Between " . $from . " - " . $to;
        } else {
            $sqlticket = $obj->SelectAllByID("payout", array("uid" => $input_by));
            $record = $obj->exists_multiple("payout", array("uid" => $input_by));
            $record_label = "";
        }
    } elseif ($input_status == 3) {
        include('class/pos_class.php');
        $obj_pos = new pos();
        $cashiers_id = $obj_pos->cashier_actual_id(@$_SESSION['SESS_CASHIER_ID']);
        if (isset($_GET['from'])) {
            $from = $_GET['from'];
            $to = $_GET['to'];
            $sqlticket = $report->SelectAllDate_Store("payout", $from, $to, "1", "cashier_id", $cashiers_id);
            $record = $report->SelectAllDate_Store("payout", $from, $to, "2", "cashier_id", $cashiers_id);
            $record_label = "| Report Generate Between " . $from . " - " . $to;
        } else {
            $sqlticket = $obj->SelectAllByID("payout", array("cashier_id" => $cashiers_id));
            $record = $obj->exists_multiple("payout", array("cashier_id" => $cashiers_id));
            $record_label = "";
        }
    } elseif ($input_status == 4) {
        if (isset($_GET['from'])) {
            $from = $_GET['from'];
            $to = $_GET['to'];
            $sqlticket = $report->SelectAllDate_Store("payout", $from, $to, "1", "uid", $input_by);
            $record = $report->SelectAllDate_Store("payout", $from, $to, "2", "uid", $input_by);
            $record_label = "| Report Generate Between " . $from . " - " . $to;
        } else {
            $sqlticket = $obj->SelectAllByID("payout", array("uid" => $input_by));
            $record = $obj->exists_multiple("payout", array("uid" => $input_by));
            $record_label = "";
        }
    } elseif ($input_status == 5) {
        if (isset($_GET['from'])) {
            $from = $_GET['from'];
            $to = $_GET['to'];

            $sqlticket = $obj_report_chain->ReportQuery_Datewise_Or("payout", $array_ch, "uid", $from, $to, "1");
            $record = $obj_report_chain->ReportQuery_Datewise_Or("payout", $array_ch, "uid", $from, $to, "2");
            $record_label = "| Report Generate Between " . $from . " - " . $to;
        } else {
            $sqlticket = $obj_report_chain->SelectAllByID_Multiple2_Or("payout", array("date" => date('Y-m-d')), $array_ch, "uid", "1");
            $record = $obj_report_chain->SelectAllByID_Multiple2_Or("payout", array("date" => date('Y-m-d')), $array_ch, "uid", "2");
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
						Payout List Report
						</td>
					</tr>
				</table>
				

				
				<table style='width:100%; height:40px; border:0px; font-size:18px;'>
					<tr>
						<td> Payout List Generate Date : " . date('d-m-Y H:i:s') . "</td>
					</tr>
				</table>
				<table style='width:960px;border:1px; font-size:12px; background:#ccc;'>";
    $html.="<thead>
        <tr style='background:#09f; color:#fff;'>
			<th>#</th>
			<th>Store</th>
			<th>Cashier</th>
			<th>Amount</th>
			<th>Reason</th>
			<th>Date</th>
		</tr>
</thead>        
<tbody>";


    $i = 1;
    $a = 0;
    $a1 = 0;
    $a2 = 0;
    //$dd3=0;
    //$dd4=0;
    //$dd5=0;
    if (!empty($sqlticket))
        foreach ($sqlticket as $ticket):
            ///$a1+=1;
            //$a2+=$ticket->amount;
            if (substr($ticket->amount, 0, 1) == "+") {
                $am = substr($ticket->amount, 1, 100);
                $a1+=$am;
            } elseif (substr($ticket->amount, 0, 1) == "-") {
                $am = substr($ticket->amount, 1, 100);
                $a2+=$am;
            } else {
                $am = $ticket->amount;
                $a1+=$am;
            }
            $a+=1;

            $html.="<tr>
				<td>" . $i . "</td>
				<td>" . $obj->SelectAllByVal("store", "store_id", $ticket->uid, "name") . "</td>
				<td>" . $obj->SelectAllByVal("store", "id", $ticket->cashier_id, "name") . "</td>
				<td>" . number_format($ticket->amount, 2) . "</td>
				<td>" . $ticket->reason . "</td>
				<td>" . $ticket->date . "</td>
			</tr>";
            $i++;
        endforeach;

    $html.="</tbody><tfoot><tr>
			<th>#</th>
			<th>Store</th>
			<th>Cashier</th>
			<th>Amount</th>
			<th>Reason</th>
			<th>Date</th>
		</tr></tfoot></table>";

    $tot = $a1 + $a2;
    $html.="<table border='0'  width='250' style='width:200px;'>
					<tbody>
					<tr>
						<td>1. Total Quantity = <strong>" . $a . "</strong></td>
					</tr>
					<tr>
						<td>2. Total Payout (+)(-) = <strong> $" . number_format($tot, 2) . "</strong></td>
					</tr>
					<tr>
						<td>3. Total Payout (+) = <strong> $" . number_format($a1, 2) . "</strong></td>
					</tr>
					<tr>
						<td>4. Total Payout (-) = <strong> $" . number_format($a2, 2) . "</strong></td>
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
        <?php //echo $obj->bodyhead();  ?>
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
                <?php
                echo $obj->ShowMsg();
                if ($input_status == 1) {
                    if (isset($_GET['from'])) {
                        $from = $_GET['from'];
                        $to = $_GET['to'];
                        $sqlticket = $report->SelectAllDate("payout", $from, $to, "1");
                        $record = $report->SelectAllDate("payout", $from, $to, "2");
                        $record_label = "| Report Generate Between " . $from . " - " . $to;
                    } else {
                        $sqlticket = $obj->SelectAllByID("payout", array("date" => date('Y-m-d')));
                        $record = $obj->exists_multiple("payout", array("date" => date('Y-m-d')));
                        $record_label = "";
                    }
                } elseif ($input_status == 2) {
                    if (isset($_GET['from'])) {
                        $from = $_GET['from'];
                        $to = $_GET['to'];
                        $sqlticket = $report->SelectAllDate_Store("payout", $from, $to, "1", "uid", $input_by);
                        $record = $report->SelectAllDate_Store("payout", $from, $to, "2", "uid", $input_by);
                        $record_label = "| Report Generate Between " . $from . " - " . $to;
                    } else {
                        $sqlticket = $obj->SelectAllByID_Multiple("payout", array("uid" => $input_by, "date" => date('Y-m-d')));
                        $record = $obj->exists_multiple("payout", array("uid" => $input_by, "date" => date('Y-m-d')));
                        $record_label = "";
                    }
                } elseif ($input_status == 3) {
                    include('class/pos_class.php');
                    $obj_pos = new pos();
                    $cashiers_id = $obj_pos->cashier_actual_id(@$_SESSION['SESS_CASHIER_ID']);
                    if (isset($_GET['from'])) {
                        $from = $_GET['from'];
                        $to = $_GET['to'];
                        $sqlticket = $report->SelectAllDate_Store("payout", $from, $to, "1", "cashier_id", $cashiers_id);
                        $record = $report->SelectAllDate_Store("payout", $from, $to, "2", "cashier_id", $cashiers_id);
                        $record_label = "| Report Generate Between " . $from . " - " . $to;
                    } else {
                        $sqlticket = $obj->SelectAllByID_Multiple("payout", array("cashier_id" => $cashiers_id, "date" => date('Y-m-d')));
                        $record = $obj->exists_multiple("payout", array("cashier_id" => $cashiers_id, "date" => date('Y-m-d')));
                        $record_label = "";
                    }
                } elseif ($input_status == 4) {
                    if (isset($_GET['from'])) {
                        $from = $_GET['from'];
                        $to = $_GET['to'];
                        $sqlticket = $report->SelectAllDate_Store("payout", $from, $to, "1", "uid", $input_by);
                        $record = $report->SelectAllDate_Store("payout", $from, $to, "2", "uid", $input_by);
                        $record_label = "| Report Generate Between " . $from . " - " . $to;
                    } else {
                        $sqlticket = $obj->SelectAllByID_Multiple("payout", array("uid" => $input_by, "date" => date('Y-m-d')));
                        $record = $obj->exists_multiple("payout", array("uid" => $input_by, "date" => date('Y-m-d')));
                        $record_label = "";
                    }
                } elseif ($input_status == 5) {
                    if (isset($_GET['from'])) {
                        $from = $_GET['from'];
                        $to = $_GET['to'];

                        $sqlticket = $obj_report_chain->ReportQuery_Datewise_Or("payout", $array_ch, "uid", $from, $to, "1");
                        $record = $obj_report_chain->ReportQuery_Datewise_Or("payout", $array_ch, "uid", $from, $to, "2");
                        $record_label = "| Report Generate Between " . $from . " - " . $to;
                    } else {
                        $sqlticket = $obj_report_chain->SelectAllByID_Multiple2_Or("payout", array("date" => date('Y-m-d')), $array_ch, "uid", "1");
                        $record = $obj_report_chain->SelectAllByID_Multiple2_Or("payout", array("date" => date('Y-m-d')), $array_ch, "uid", "2");
                        $record_label = "";
                    }
                }
                ?>
                <!-- /info notice -->

                <div class="outer">
                    <div class="inner">
                        <div class="page-header"><!-- Page header -->
                            <h5><i class="icon-tag"></i> Payout Report <?php echo $record_label; ?> | <a  data-toggle="modal" href="#myModal"> Search Datewise </a></h5>
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
                                        <h5 id="myModalLabel"><i class="font-calendar"></i> Generate Payout Report <span id="mss"></span></h5>
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




                                <!-- General form elements -->
                                <div class="row-fluid block">



                                    <div class="table-overflow">




                                        <div id="grid" style="margin-left: 10px;margin-right: 10px;"></div>

                                        <?php
                                        $cond = $cms->FrontEndDateSearch('from', 'to');
                                        ?>
<!--                                        <script id="action_template" type="text/x-kendo-template">
                                            <a class="k-button k-button-icontext k-grid-delete" href="payout_report.php?edit=#=id#"><i class="icon-edit"></i> Edit</a> 
                                            <a class="k-button k-button-icontext k-grid-delete" onclick="javascript:deleteClick(#=id#);" ><span class="k-icon k-delete"></span> Delete</a>
                                        </script>-->
                                        <script type="text/javascript">
                                            function deleteClick(id) {
                                                var c = confirm("Do you want to delete?");
                                                if (c === true) {
                                                    $.ajax({
                                                        type: "POST",
                                                        dataType: "json",
                                                        url: "./controller/payout_report.php",
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
                                                            url: "./controller/payout_report.php",
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
                                                                track_id: {type: "number"},
                                                                store_name: {type: "string"},
                                                                cashier_name: {type: "string"},
                                                                amount: {type: "string"},
                                                                reason: {type: "string"},
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
                                                        {field: "id", title: "#", width: "30px", filterable: false},
                                                        {field: "track_id", title: "Track ID", width: "70px"},
                                                        {field: "store_name", title: "Store Name", width: "60px"},
                                                        {field: "cashier_name", title: "Cashier Name", width: "60px"},
                                                        {template: "<?php echo $currencyicon; ?>#=amount#", title: "Amount", width: "50px"},
                                                        {field: "reason", title: "Reason", width: "70px"},
                                                        {field: "date", title: "Created", width: "50px"},
//                                                        {
//                                                            title: "Action", width: "80px",
//                                                            template: kendo.template($("#action_template").html())
//                                                        }
                                                    ],
                                                });
                                            });

                                        </script>






                                        <?php /* <table class="table table-striped" id="data-table">
                                          <thead>
                                          <tr>
                                          <th>#</th>
                                          <th>Track ID</th>
                                          <th>Store</th>
                                          <th>Cashier</th>
                                          <th>Amount</th>
                                          <th>Reason</th>

                                          <th>Date</th>
                                          <th></th>
                                          </tr>
                                          </thead>
                                          <tbody>
                                          <?php
                                          $i=1;
                                          $a=0;
                                          $a1=0;
                                          $a2=0;
                                          //$dd3=0;
                                          //$dd4=0;
                                          //$dd5=0;
                                          if(!empty($sqlticket))
                                          foreach($sqlticket as $ticket):
                                          ///$a1+=1;
                                          //$a2+=$ticket->amount;
                                          if(substr($ticket->amount,0,1)=="+")
                                          {
                                          $am=substr($ticket->amount,1,100);
                                          $a1+=$am;
                                          }
                                          elseif(substr($ticket->amount,0,1)=="-")
                                          {
                                          $am=substr($ticket->amount,1,100);
                                          $a2+=$am;
                                          }
                                          else
                                          {
                                          $am=$ticket->amount;
                                          $a1+=$am;
                                          }
                                          $a+=1;
                                          ?>
                                          <tr>
                                          <td><?php echo $i; ?></td>
                                          <td><?php echo $ticket->track_id; ?></td>
                                          <td><?php echo $obj->SelectAllByVal("store","store_id",$ticket->uid,"name"); ?></td>
                                          <td><i class="icon-user"></i> <?php echo $obj->SelectAllByVal("store","id",$ticket->cashier_id,"name"); ?></td>
                                          <td><?php

                                          echo @number_format($ticket->amount,2); ?></td>
                                          <td><?php echo $ticket->reason; ?></td>
                                          <td><?php echo $ticket->date; ?></td>
                                          <td>
                                          <?php
                                          if($input_status==1 || $input_status==2) { ?>
                                          <a href="<?php echo $obj->filename(); ?>?del=<?php echo $ticket->id; ?>&amp;track_id=<?php echo $ticket->track_id; ?>&amp;payout=1" class="hovertip" title="Delete" onclick="javascript:return confirm('Are you absolutely sure to delete This?')"><i class="icon-trash"></i></a>
                                          <?php }

                                          ?>
                                          </td>


                                          </tr>
                                          <?php $i++; endforeach; ?>
                                          </tbody>
                                          </table> */ ?>
                                    </div>


                                    <!-- Table condensed -->

                                    <div class="block well span4" style="margin-left:0; margin-top:20px;">
                                        <div class="navbar">
                                            <div class="navbar-inner">
                                                <h5> Payout Short Report</h5>
                                            </div>
                                        </div>
                                        <div class="table-overflow">

                                            <?php /* <table class="table table-condensed">
                                              <tbody>
                                              <tr>
                                              <td>1. Total Quantity = <strong> <?php echo $a; ?></strong></td>
                                              </tr>
                                              <tr>
                                              <td>2. Total Payout (+)(-) = <strong> $<?php
                                              $tot=$a1+$a2;
                                              echo number_format($tot,2); ?></strong></td>
                                              </tr>
                                              <tr>
                                              <td>3. Total Payout (+) = <strong> $<?php echo number_format($a1,2); ?></strong></td>
                                              </tr>
                                              <tr>
                                              <td>4. Total Payout (-) = <strong> $<?php echo number_format($a2,2); ?></strong></td>
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

                                <?php /*
                                  if (isset($_GET['from'])) {
                                  $from = $_GET['from'];
                                  $to = $_GET['to'];
                                  ?>
                                  <a href="<?php echo $obj->filename(); ?>?export=excel&amp;from=<?php echo $from; ?>&amp;to=<?php echo $to; ?>">
                                  <img src="pos_image/file_excel.png">
                                  </a>
                                  <a href="<?php echo $obj->filename(); ?>?export=pdf&amp;from=<?php echo $from; ?>&amp;to=<?php echo $to; ?>">
                                  <img src="pos_image/file_pdf.png">
                                  </a>
                                  <?php
                                  } else {
                                  ?>
                                  <a href="<?php echo $obj->filename(); ?>?export=excel">
                                  <img src="pos_image/file_excel.png">
                                  </a>
                                  <a href="<?php echo $obj->filename(); ?>?export=pdf">
                                  <img src="pos_image/file_pdf.png">
                                  </a>
                                  <?php
                                  }
                                 */ ?>

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
            <?php //include('include/footer.php');  ?>
            <!-- Right sidebar -->
            <?php //include('include/sidebar_right.php');  ?>
            <!-- /right sidebar -->

        </div>
        <!-- /main wrapper -->

    </body>
</html>
