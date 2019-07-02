<?php
include('class/auth.php');
include('class/report_customer.php');
$report = new report();
$table = "coustomer";
if (isset($_GET['del'])) {
    $obj->deletesing("id", $_GET['del'], "sales");
}

if (isset($_GET['dels'])) {
    $obj->deletesing("id", $_GET['dels'], "unlock_request");
}


//if ($input_status == 1) {
//    $sqlinvoice_p = $report->SelectAllDate("sales_list", date('Y-m') . "-1", date('Y-m-d'), "1");
//} elseif ($input_status == 5) {
//    $sqlchain_store_ids = $obj->SelectAllByID("store_chain_admin", array("sid" => $input_by));
//    if (!empty($sqlchain_store_ids)) {
//        $array_ch = array();
//        foreach ($sqlchain_store_ids as $ch):
//            array_push($array_ch, $ch->store_id);
//        endforeach;
//        include('class/report_chain_admin.php');
//        $obj_report_chain = new chain_report();
//        $sqlinvoice_p = $obj_report_chain->ReportQuery_Datewise_Or("sales_list", $array_ch, "input_by", date('Y-m') . "-1", date('Y-m-d'), "1");
//    }
//    else {
//        $sqlinvoice_p = "";
//    }
//} else {
//    $sqlinvoice_p = $report->SelectAllDate_Store("sales_list", date('Y-m') . "-1", date('Y-m-d'), "1", "input_by", $input_by);
//}
//
//
//
//$fff = 0;
//$asiftodayprofit = 0;
//if (!empty($sqlinvoice_p))
//    foreach ($sqlinvoice_p as $invoice):
//        $checkin_id = $obj->SelectAllByVal("invoice", "invoice_id", $invoice->sales_id, "checkin_id");
//        $salvage_status = $obj->exists_multiple("checkin_request_ticket", array("checkin_id" => $checkin_id, "salvage_part" => 1));
//        if ($salvage_status == 1) {
//            $fff = 0;
//        } else {
//            $fff = $invoice->our_totalcost;
//        }
//        $aitp = $invoice->totalcost - $fff;
//        $asiftodayprofit+=$aitp;
//    endforeach;
//
//@$individual_day_profit = $asiftodayprofit / date('d');
//$month = date('m');
//$year = date('Y');
//$d = cal_days_in_month(CAL_GREGORIAN, $month, $year);
//@$summerizethismonthprofittotal = $individual_day_profit * $d;
//
//
//$tenpr = '';
//
//$tenpr .='<div class="block well span5" style="margin-top:10px;">
//                                        <div class="navbar">
//                                            <div class="navbar-inner">
//                                                <h5> Trend To (<storng><font color="#09f">' . date('F') . '</font></storng>) Profit Report</h5>
//                                            </div>
//                                        </div>
//                                        <div class="table-overflow">
//                                            <table class="table table-condensed table-bordered">
//                                                <tbody>
//                                                    <tr>
//                                                        <td>1. As if today this (<storng><font color="#09f">' . date('F') . '</font></storng>) profit = </td><td><strong>$ ' . @number_format($asiftodayprofit, 2) . '</strong></td>
//                                                    </tr>
//                                                    <tr>
//                                                        <td>2. Individual day profit = </td><td><strong>$ ' . @number_format($individual_day_profit, 2) . '</strong></td>
//                                                    </tr>
//                                                    <tr>
//                                                        <td>3. Profit become End of month = </td><td><strong>$ ' . @number_format($summerizethismonthprofittotal, 2) . '</strong></td>
//                                                    </tr>
//
//
//                                                </tbody>
//                                            </table>
//                                        </div>
//                                    </div>';


if (@$_GET['export'] == "excel") {
    if ($input_status == 1) {
        if (isset($_GET['from'])) {
            $from = $_GET['from'];
            $to = $_GET['to'];
            $sqlinvoice = $report->SelectAllDate("sales_list", $from, $to, "1");
            $record = $report->SelectAllDate("sales_list", $from, $to, "2");

            $totalrecord = $record;
            $record_label = "Total record Found ( " . $totalrecord . " ). | Report Generate Between " . $from . " - " . $to;
        } else {
            $sqlinvoice = $obj->SelectAll("sales_list");
            $record = $obj->totalrows("sales_list");

            $totalrecord = $record;
            $record_label = "Total Record Found ( " . $totalrecord . " )";
        }
    } elseif ($input_status == 5) {

        $sqlchain_store_ids = $obj->SelectAllByID("store_chain_admin", array("sid" => $input_by));
        if (!empty($sqlchain_store_ids)) {
            $array_ch = array();
            foreach ($sqlchain_store_ids as $ch):
                array_push($array_ch, $ch->store_id);
            endforeach;

//echo var_dump($array_ch);

            if (isset($_GET['from'])) {
                $obj_report_chain = new chain_report();
                $sqlinvoice = $obj_report_chain->ReportQuery_Datewise_Or("sales_list", $array_ch, "input_by", $_GET['from'], $_GET['to'], "1");
                $record = $obj_report_chain->ReportQuery_Datewise_Or("sales_list", $array_ch, "input_by", $_GET['from'], $_GET['to'], "2");
                $record_label = "Total Record Found ( " . $record . " )";
            } else {
                $obj_report_chain = new chain_report();
                $sqlinvoice = $obj_report_chain->SelectAllByID_Multiple2_Or("sales_list", array("date" => date('Y-m-d')), $array_ch, "input_by", "1");
                $record = $obj_report_chain->SelectAllByID_Multiple2_Or("sales_list", array("date" => date('Y-m-d')), $array_ch, "input_by", "2");
                $record_label = "Total Record Found ( " . $record . " )";
            }

            $totalrecord = $record;
//echo "Work";
        } else {
//echo "Not Work";
            $sqlinvoice = "";
            $record = 0;
            $record_label = "";
            $totalrecord = 0;
        }
    } else {
        if (isset($_GET['from'])) {
            $from = $_GET['from'];
            $to = $_GET['to'];
            $sqlinvoice = $report->SelectAllDate_Store("sales_list", $from, $to, "1", "input_by", $input_by);
            $record = $report->SelectAllDate_Store("sales_list", $from, $to, "2", "input_by", $input_by);

            $totalrecord = $record;
            $record_label = "Total record Found ( " . $totalrecord . " ). | Report Generate Between " . $from . " - " . $to;
        } else {
            $sqlinvoice = $obj->SelectAllByID("sales_list", array("input_by" => $input_by));
            $record = $obj->exists_multiple("sales_list", array("input_by" => $input_by));

            $totalrecord = $record;
            $record_label = "Total Record Found ( " . $totalrecord . " )";
        }
    }
    header('Content-type: application/excel');
    $filename = "Profit_list_" . date('Y_m_d') . '.xls';

    header('Content-Disposition: attachment; filename=' . $filename);

    $data = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">
    <head>
        <!--[if gte mso 9]>
        <xml>
            <x:ExcelWorkbook>
                <x:ExcelWorksheets>
                    <x:ExcelWorksheet>
                        <x:Name>Profit List : Wireless Geeks Inc.</x:Name>
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
    $data .="<h5>Profit List Generate Date : " . date('d-m-Y H:i:s') . "</h5>";

    $data .="<table>
            <thead>
                <tr style='background:#09f; color:#fff;'>
                    <th>#</th>
                    <th>Sales-ID</th>";
    if ($input_status == 5) {
        $data .="<th>Store</th>";
    }

    $data .="<th>Product Name</th>
                    <th>Quantity</th>
                    <th>Retail</th>
                    <th>Our Cost</th>
                    <th>Total Retail</th>
                    <th>Our Total Cost</th>
                    <th>Profit</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>";

    $i = 1;
    $aa = 0;
    $bb = 0;
    $cc = 0;
    $dd = 0;
    if (!empty($sqlinvoice))
        foreach ($sqlinvoice as $invoice):
            $dd+=$invoice->quantity;
            $aa+=$invoice->totalcost;
            $cc+=$invoice->profit;
            $bb+=$invoice->our_totalcost;
            $data .="<tr>
                    <td>" . $i . "</td>
                    <td>" . $invoice->sales_id . "</td>";
            if ($input_status == 5) {
                $data .="<td>" . $obj->SelectAllByVal("store", "store_id", $invoice->input_by, "name") . "</td>";
            }
            $data .="<td>" . $invoice->product . "</td>
                    <td>" . $invoice->quantity . "</td>
                    <td>" . $invoice->single_cost . "</td>
                    <td>" . $invoice->our_cost . "</td>
                    <td>" . $invoice->totalcost . "</td>
                    <td>" . $invoice->our_totalcost . "</td>
                    <td>" . $invoice->profit . "</td>
                    <td>" . $invoice->date . "</td>
                </tr>";

            $i++;
        endforeach;

    $data .="</tbody><tfoot><tr>
                    <th>#</th>
                    <th>Sales-ID</th>";
    if ($input_status == 5) {
        $data .="<th>Store</th>";
    }

    $data .="<th>Product Name</th>
                    <th>Quantity</th>
                    <th>Retail</th>
                    <th>Our Cost</th>
                    <th>Total Retail</th>
                    <th>Our Total Cost</th>
                    <th>Profit</th>
                    <th>Date</th>
                </tr></tfoot></table>";




    $data .="<table border='0' width='250' style='width:200px;'>
            <tbody>
                <tr>
                    <td>1. Total Quantity = <strong>" . $totalrecord . "</strong></td>
                </tr>
                <tr>
                    <td>2. Our Total Cost = <strong> $" . number_format($bb, 2) . "</strong></td>

                </tr>
                <tr>
                    <td>3. Total Retail Cost = <strong> $" . number_format($aa, 2) . "</strong></td>
                </tr>
                <tr>
                    <td>4. Total Profit = <strong> $" . number_format($cc, 2) . "</strong></td>
                </tr>
                <tr>
                    <td>5. Average Profit = <strong> $";
    $average_profit = $cc / $totalrecord;
    $data .=number_format(floatval($average_profit), 2) . "</strong></td>
                </tr>
            </tbody>
        </table>";

    $data .=$tenpr;

    $data .='</body></html>';

    echo $data;
    exit();
}

if (@$_GET['export'] == "pdf") {
    if ($input_status == 1) {
        if (isset($_GET['from'])) {
            $from = $_GET['from'];
            $to = $_GET['to'];
            $sqlinvoice = $report->SelectAllDate("sales_list", $from, $to, "1");
            $record = $report->SelectAllDate("sales_list", $from, $to, "2");

            $totalrecord = $record;
            $record_label = "Total record Found ( " . $totalrecord . " ). | Report Generate Between " . $from . " - " . $to;
        } else {
            $sqlinvoice = $obj->SelectAll("sales_list");
            $record = $obj->totalrows("sales_list");

            $totalrecord = $record;
            $record_label = "Total Record Found ( " . $totalrecord . " )";
        }
    } elseif ($input_status == 5) {

        $sqlchain_store_ids = $obj->SelectAllByID("store_chain_admin", array("sid" => $input_by));
        if (!empty($sqlchain_store_ids)) {
            $array_ch = array();
            foreach ($sqlchain_store_ids as $ch):
                array_push($array_ch, $ch->store_id);
            endforeach;

//echo var_dump($array_ch);

            if (isset($_GET['from'])) {
                $obj_report_chain = new chain_report();
                $sqlinvoice = $obj_report_chain->ReportQuery_Datewise_Or("sales_list", $array_ch, "input_by", $_GET['from'], $_GET['to'], "1");
                $record = $obj_report_chain->ReportQuery_Datewise_Or("sales_list", $array_ch, "input_by", $_GET['from'], $_GET['to'], "2");
                $record_label = "Total Record Found ( " . $record . " )";
            } else {
                $obj_report_chain = new chain_report();
                $sqlinvoice = $obj_report_chain->SelectAllByID_Multiple2_Or("sales_list", array("date" => date('Y-m-d')), $array_ch, "input_by", "1");
                $record = $obj_report_chain->SelectAllByID_Multiple2_Or("sales_list", array("date" => date('Y-m-d')), $array_ch, "input_by", "2");
                $record_label = "Total Record Found ( " . $record . " )";
            }

            $totalrecord = $record;
//echo "Work";
        } else {
//echo "Not Work";
            $sqlinvoice = "";
            $record = 0;
            $record_label = "";
            $totalrecord = 0;
        }
    } else {
        if (isset($_GET['from'])) {
            $from = $_GET['from'];
            $to = $_GET['to'];
            $sqlinvoice = $report->SelectAllDate_Store("sales_list", $from, $to, "1", "input_by", $input_by);
            $record = $report->SelectAllDate_Store("sales_list", $from, $to, "2", "input_by", $input_by);

            $totalrecord = $record;
            $record_label = "Total record Found ( " . $totalrecord . " ). | Report Generate Between " . $from . " - " . $to;
        } else {
            $sqlinvoice = $obj->SelectAllByID("sales_list", array("input_by" => $input_by));
            $record = $obj->exists_multiple("sales_list", array("input_by" => $input_by));

            $totalrecord = $record;
            $record_label = "Total Record Found ( " . $totalrecord . " )";
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
                            <th>Sales-ID</th>";
    if ($input_status == 5) {
        $html.="<th>Store</th>";
    }

    $html.="<th>Product Name</th>
                            <th>Quantity</th>
                            <th>Retail</th>
                            <th>Our Cost</th>
                            <th>Total Retail</th>
                            <th>Our Total Cost</th>
                            <th>Profit</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>";


    $i = 1;
    $aa = 0;
    $bb = 0;
    $cc = 0;
    $dd = 0;
    if (!empty($sqlinvoice))
        foreach ($sqlinvoice as $invoice):
            $dd+=$invoice->quantity;
            $aa+=$invoice->totalcost;
            $cc+=$invoice->profit;
            $bb+=$invoice->our_totalcost;
            $html.="<tr>
                            <td>" . $i . "</td>
                            <td>" . $invoice->sales_id . "</td>";
            if ($input_status == 5) {
                $html.="<td>" . $obj->SelectAllByVal("store", "store_id", $invoice->input_by, "name") . "</td>";
            }
            $html.="<td>" . $invoice->product . "</td>
                            <td>" . $invoice->quantity . "</td>
                            <td>" . $invoice->single_cost . "</td>
                            <td>" . $invoice->our_cost . "</td>
                            <td>" . $invoice->totalcost . "</td>
                            <td>" . $invoice->our_totalcost . "</td>
                            <td>" . $invoice->profit . "</td>
                            <td>" . $invoice->date . "</td>
                        </tr>";

            $i++;
        endforeach;

    $html.="</tbody><tfoot><tr>
                            <th>#</th>
                            <th>Sales-ID</th>";
    if ($input_status == 5) {
        $html.="<th>Store</th>";
    }

    $html.="<th>Product Name</th>
                            <th>Quantity</th>
                            <th>Retail</th>
                            <th>Our Cost</th>
                            <th>Total Retail</th>
                            <th>Our Total Cost</th>
                            <th>Profit</th>
                            <th>Date</th>
                        </tr></tfoot></table>";

    $html.="<table border='0'  width='250' style='width:200px;'>
                    <tbody>
                        <tr>
                            <td>1. Total Quantity = <strong>" . $totalrecord . "</strong></td>
                        </tr>
                        <tr>
                            <td>2. Our Total Cost = <strong> $" . number_format($bb, 2) . "</strong></td>

                        </tr>
                        <tr>
                            <td>3. Total Retail Cost = <strong> $" . number_format($aa, 2) . "</strong></td>
                        </tr>
                        <tr>
                            <td>4. Total Profit = <strong> $" . number_format($cc, 2) . "</strong></td>
                        </tr>
                        <tr>
                            <td>5. Average Profit = <strong> $";
    $average_profit = $cc / $totalrecord;
    $html.=number_format(floatval($average_profit), 2) . "</strong></td>
                        </tr>
                    </tbody>
                </table>";
    $html .=$tenpr;
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
        <?php //echo $obj->bodyhead(); ?>
        <?php
        include './plugin/plugin.php';
        $cms = new CmsRootPlugin();
        echo $cms->GeneralCss(array("kendo", "modal"));
        ?>
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
                <?php echo $obj->ShowMsg(); ?>
                <!-- /info notice -->

                <div class="outer">
                    <div class="inner">
                        <div class="page-header"><!-- Page header -->
                            <?php
                            echo $obj->ShowMsg();
//                            if ($input_status == 1) {
//                                if (isset($_GET['from'])) {
//
//                                    $from=$_GET['from'];
//                                    $to=$_GET['to'];
//                                    $sqlinvoice=$report->SelectAllDate("sales_list", $from, $to, "1");
//                                    $record=$report->SelectAllDate("sales_list", $from, $to, "2");
//
//                                    $totalrecord=$record;
//                                    $record_label="Total record Found ( " . $totalrecord . " ). | Report Generate Between " . $from . " - " . $to;
//                                }else {
//                                    $sqlinvoice=$obj->SelectAllByID("sales_list", array("date"=>date('Y-m-d')));
//                                    $record=$obj->exists_multiple("sales_list", array("date"=>date('Y-m-d')));
//
//
//                                    $totalrecord=$record;
//                                    $record_label="Total Record Found ( " . $totalrecord . " )";
//                                }
//                            }elseif ($input_status == 5) {
//
//                                $sqlchain_store_ids=$obj->SelectAllByID("store_chain_admin", array("sid"=>$input_by));
//                                if (!empty($sqlchain_store_ids)) {
//                                    $array_ch=array();
//                                    foreach ($sqlchain_store_ids as $ch):
//                                        array_push($array_ch, $ch->store_id);
//                                    endforeach;
//
//                                    //echo var_dump($array_ch);
//
//                                    if (isset($_GET['from'])) {
//                                        $obj_report_chain=new chain_report();
//                                        $sqlinvoice=$obj_report_chain->ReportQuery_Datewise_Or("sales_list", $array_ch, "input_by", $_GET['from'], $_GET['to'], "1");
//                                        echo $record=$obj_report_chain->ReportQuery_Datewise_Or("sales_list", $array_ch, "input_by", $_GET['from'], $_GET['to'], "2");
//                                        $record_label="Total Record Found ( " . $record . " )";
//                                    }else {
//                                        $obj_report_chain=new chain_report();
//                                        $sqlinvoice=$obj_report_chain->SelectAllByID_Multiple2_Or("sales_list", array("date"=>date('Y-m-d')), $array_ch, "input_by", "1");
//                                        $record=$obj_report_chain->SelectAllByID_Multiple2_Or("sales_list", array("date"=>date('Y-m-d')), $array_ch, "input_by", "2");
//                                        $record_label="Total Record Found ( " . $record . " )";
//                                    }
//
//                                    $totalrecord=$record;
//                                    //echo "Work";
//                                }else {
//                                    //echo "Not Work";
//                                    $sqlinvoice="";
//                                    $record=0;
//                                    $record_label="";
//                                    $totalrecord=0;
//                                }
//                            }else {
//                                if (isset($_GET['from'])) {
//                                    $from=$_GET['from'];
//                                    $to=$_GET['to'];
//                                    $sqlinvoice=$report->SelectAllDate_Store("sales_list", $from, $to, "1", "input_by", $input_by);
//                                    $record=$report->SelectAllDate_Store("sales_list", $from, $to, "2", "input_by", $input_by);
//
//                                    $totalrecord=$record;
//                                    $record_label="Total record Found ( " . $totalrecord . " ). | Report Generate Between " . $from . " - " . $to;
//                                }else {
//                                    $sqlinvoice=$obj->SelectAllByID_Multiple("sales_list", array("input_by"=>$input_by, "date"=>date('Y-m-d')));
//                                    $record=$obj->exists_multiple("sales_list", array("input_by"=>$input_by, "date"=>date('Y-m-d')));
//
//                                    $totalrecord=$record;
//                                    $record_label="Total Record Found ( " . $totalrecord . " )";
//                                }
//                            }
                            ?>
                            <h5><i class="font-money"></i> Profit Report  | <a  data-toggle="modal" href="#myModal"> Search Datewise </a></h5>
                        </div><!-- /page header -->

                        <div class="body">

                            <!-- Middle navigation standard -->
                            <?php //include('include/quicklink.php');    ?>
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
                                            <h5 id="myModalLabel"><i class="font-calendar"></i> Generate Profit Report <span id="mss"></span></h5>
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

                                        <div id="grid" style="margin-left: 10px; margin-right: 10px;"></div>
                                        <?php
                                        $cond = $cms->FrontEndDateSearch('from', 'to');
                                        ?>

                                        <script type="text/javascript">
                                            jQuery(document).ready(function () {
                                                var dataSource = new kendo.data.DataSource({
                                                    transport: {
                                                        read: {
                                                            url: "./controller/profit_report.php<?php echo $cond; ?>",
                                                            type: "GET",
                                                            datatype: "json",
                                                            complete: function (response) {
                                                                var page_countitem = 0;
                                                                var page_quantity = 0;
                                                                var page_our_cost = 0;
                                                                var page_retail_cost = 0;
                                                                var page_total_our_cost = 0;
                                                                var page_total_retail_cost = 0;
                                                                var page_profit = 0;
                                                                jQuery.each(response, function (index, key) {
                                                                    if (index == 'responseJSON')
                                                                    {
                                                                        //console.log(key.data);
                                                                        jQuery.each(key.data, function (datagr, keyg) {
                                                                            //console.log(keyg.our_cost);
                                                                            page_countitem += (1 - 0);
                                                                            page_quantity += (keyg.quantity - 0);
                                                                            page_our_cost += (keyg.price_cost - 0);
                                                                            page_retail_cost += (keyg.single_cost - 0);
                                                                            page_total_our_cost += (keyg.our_total_cost - 0);
                                                                            page_total_retail_cost += (keyg.totalcost - 0);
                                                                            page_profit += (keyg.profit - 0);

                                                                        });

                                                                        var averageproft = parseInt(page_profit / page_quantity);

                                                                        //console.log(page_ourcost);
                                                                        jQuery("#a1").html(page_countitem + "  of  " + key.total);
                                                                        jQuery("#a2").html(page_quantity);
                                                                        jQuery("#a3").html(page_our_cost);
                                                                        jQuery("#a4").html(page_retail_cost);
                                                                        jQuery("#a5").html(page_total_our_cost);
                                                                        jQuery("#a6").html(page_total_retail_cost);
                                                                        jQuery("#a7").html(page_profit);
                                                                        jQuery("#a8").html(averageproft);

                                                                        jQuery("#a9").html(key.trend);

                                                                    }
                                                                })
                                                            }
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
                                                                pid: {type: "string"},
                                                                store_name: {type: "string"},
                                                                product_name: {type: "string"},
                                                                quantity: {type: "string"},
                                                                single_cost: {type: "string"},
                                                                price_cost: {type: "string"},
                                                                our_total_cost: {type: "string"},
                                                                totalcost: {type: "string"},
                                                                profit: {type: "string"},
                                                                input_by: {type: "string"},
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
                                                        pageSizes:[10, 20, 50, 100, 200, 400, 1000, 10000, 50000]
                                                    },
                                                    sortable: true,
                                                    groupable: true,
                                                    columns: [
                                                        {field: "id", title: "P.ID", width: "60px"},
                                                        {field: "store_name", title: "Store Name", width: "100px"},
                                                        {field: "product_name", title: "Name", width: "200px"},
                                                        {title: "Quantity", template: "#=quantity#", filter: false},
                                                        {title: "Our Cost", template: "<?php echo $currencyicon; ?>#=price_cost#"},
                                                        {title: "Retail Price", template: "<?php echo $currencyicon; ?>#=single_cost#"},
                                                        {title: "Total Cost", template: "<?php echo $currencyicon; ?>#=our_total_cost#"},
                                                        {title: "Retail Total", template: "<?php echo $currencyicon; ?>#=totalcost#"},
                                                        {title: "Profit", template: "<?php echo $currencyicon; ?>#=profit#"},
                                                        {field: "date", title: "Date", width: "90px"}
                                                    ]
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
                                                    JSONToCSVConvertor(json_data, "Profit Report", true);

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
                                                    var fileName = "profit_report_";
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

                                    <?php /* <div class="table-overflow">
                                      <table class="table table-striped" id="data-table">
                                      <thead>
                                      <tr>
                                      <th>#</th>
                                      <th>Sales-ID</th>
                                      <?php
                                      if ($input_status == 5) {
                                      ?>
                                      <th>Store</th>
                                      <?php
                                      }
                                      ?>
                                      <th>Product Name</th>
                                      <th>Quantity</th>

                                      <th>Retail</th>
                                      <th>Our Cost</th>
                                      <th>Total Retail</th>
                                      <th>Our Total Cost</th>
                                      <th>Profit</th>
                                      <th>Date</th>
                                      <th></th>
                                      </tr>
                                      </thead>
                                      <tbody>
                                      <?php
                                      $i=1;
                                      $aa=0;
                                      $bb=0;
                                      $cc=0;
                                      $dd=0;
                                      if (!empty($sqlinvoice))
                                      foreach ($sqlinvoice as $invoice):
                                      ?>
                                      <tr>
                                      <td><?php echo $i; ?></td>
                                      <td><a href="view_sales.php?invoice=<?php echo $invoice->sales_id; ?>"><?php echo $invoice->sales_id; ?></a></td>
                                      <?php
                                      if ($input_status == 5) {
                                      ?>
                                      <td><?php echo $obj->SelectAllByVal("store", "store_id", $invoice->input_by, "name"); ?></td>
                                      <?php
                                      }
                                      ?>
                                      <td><?php echo $invoice->product; ?></td>
                                      <td><label class="label label-success"><?php
                                      $dd+=$invoice->quantity;
                                      echo $invoice->quantity;
                                      ?></label></td>
                                      <td><label class="label label-success"> $<?php echo $invoice->single_cost; ?> </label></td>
                                      <td><label class="label label-warning"> $
                                      <?php
                                      $checkin_id=$obj->SelectAllByVal("invoice", "invoice_id", $invoice->sales_id, "checkin_id");
                                      $salvage_status=$obj->exists_multiple("checkin_request_ticket", array("checkin_id"=>$checkin_id, "salvage_part"=>1));
                                      if ($salvage_status == 1) {
                                      echo 0;
                                      }else {
                                      echo $invoice->our_cost;
                                      }
                                      ?>
                                      </label></td>

                                      <td><label class="label label-success"> $<?php
                                      $aa+=$invoice->totalcost;
                                      echo $invoice->totalcost;
                                      ?></label></td>
                                      <td><label class="label label-warning"> $<?php
                                      if ($salvage_status == 1) {
                                      echo 0;
                                      $bb+=0;
                                      $bbb=0;
                                      }else {
                                      $bb+=$invoice->our_totalcost;
                                      echo $invoice->our_totalcost;
                                      $bbb=$invoice->our_totalcost;
                                      }
                                      ?></label></td>
                                      <td><label class="label label-danger"> $<?php
                                      $profit=$invoice->totalcost - $bbb;
                                      $cc+=$profit;
                                      echo $profit;
                                      ?></label></td>
                                      <td><?php echo $invoice->date; ?></td>
                                      <td>
                                      <?php if ($input_status == 1) { ?>
                                      <a href="<?php echo $obj->filename(); ?>?del=<?php echo $invoice->id; ?>" class="hovertip" title="Delete" onclick="javascript:return confirm('Are you absolutely sure to delete This?')"><i class="icon-trash"></i></a>
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
                                    <!-- Table condensed -->
                                    <div class="block well span4" style="margin-left:10px; margin-top: 10px;">
                                        <div class="navbar">
                                            <div class="navbar-inner">
                                                <h5> Profit Report</h5>
                                            </div>
                                        </div>
                                        <div class="table-overflow">
                                            <table class="table table-condensed">
                                                <tbody>
                                                    <tr>
                                                        <td>1. Total Quantity = <strong id="a1"> <?php echo @$totalrecord; ?></strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td>2. Page Total Quantity = <strong id="a2"> </strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td>3. Our Cost = <?php echo $currencyicon; ?><strong id="a3"> </strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td>4. Retail Cost = <?php echo $currencyicon; ?><strong id="a4"> </strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td>5. Our Total Cost = <?php echo $currencyicon; ?><strong id="a5"> </strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td>6. Total Retail Cost = <?php echo $currencyicon; ?><strong id="a6"> </strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td>7. Total Profit = <?php echo $currencyicon; ?><strong id="a7"> </strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td>8. Average Profit = <?php echo $currencyicon; ?><strong id="a8"> </strong></td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div id="a9" class="block well span4" style="margin-top: 10px;">

                                    </div>



                                    <?php //echo $tenpr; ?>
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
            <?php //include('include/sidebar_right.php');        ?>
            <!-- /right sidebar -->

        </div>
        <!-- /main wrapper -->

    </body>
</html>
