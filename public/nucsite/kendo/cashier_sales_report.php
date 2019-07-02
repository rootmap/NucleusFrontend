<?php
include('class/auth.php');
include('class/report_customer.php');
$report = new report();
$table = "coustomer";

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

if ($input_status == 1) {
    $sqlcashier = $obj->SelectAll("cashier_list");
} elseif ($input_status == 5) {
    $sqlstring = "SELECT * FROM cashier_list WHERE ";
    $sqlstring .= "(";
    $h = 1;

    $counth = count($array_ch);
    foreach ($array_ch as $ach):
        if ($h == $counth) {
            $sqlstring .= " store_id='" . $ach . "'";
        } else {
            $sqlstring .= " store_id='" . $ach . "' OR";
        }
        $h++;
    endforeach;
    $sqlstring .= ") AND ";
    $sqlstring .= "status='3'";

    $sqlcashier = $obj->FlyQuery($sqlstring);
} else {
    $sqlcashier = $obj->FlyQuery("SELECT * FROM cashier_list WHERE store_id='" . $input_by . "' AND status='3'");
}



if (@$_GET['export'] == "excel") {
//    if ($input_status == 1) {
//        if (isset($_GET['from'])) {
//            $from=$_GET['from'];
//            $to=$_GET['to'];
//            $cashier_id=$_GET['cashier_id'];
//            $sqlinvoice=$report->SelectAllDateCond("sales_list", "cashier_id", $cashier_id, $from, $to, "1");
//            $record=$report->SelectAllDateCond("sales_list", "cashier_id", $cashier_id, $from, $to, "2");
//            $record_label="Total record Found ( " . $record . " ). | Report Generate Between " . $from . " - " . $to;
//        }else {
//            $sqlinvoice=$obj->SelectAll("sales_list");
//            $record=$obj->totalrows("sales_list");
//            $record_label="Total Record Found ( " . $record . " )";
//        }
//    }else {
//        if (isset($_GET['from'])) {
//            $from=$_GET['from'];
//            $to=$_GET['to'];
//            $cashier_id=$_GET['cashier_id'];
//            $sqlinvoice=$report->SelectAllDateCond_store2("sales_list", "cashier_id", $cashier_id, "input_by", $input_by, $from, $to, "1");
//            $record=$report->SelectAllDateCond_store2("sales_list", "cashier_id", $cashier_id, "input_by", $input_by, $from, $to, "2");
//            $record_label="Total record Found ( " . $record . " ). | Report Generate Between " . $from . " - " . $to;
//        }else {
//            $sqlinvoice=$obj->SelectAllByID("sales_list", array("input_by"=>$input_by));
//            $record=$obj->exists_multiple("sales_list", array("input_by"=>$input_by));
//            $record_label="Total Record Found ( " . $record . " )";
//        }
//    }
    if ($input_status == 1) {
        if (isset($_GET['from'])) {
            $from = $_GET['from'];
            $to = $_GET['to'];
            $cashier_id = $_GET['cashier_id'];
            $sqlinvoicestring = "SELECT * FROM sales_list as s WHERE ";
            $sqlinvoicestring .="s.cashier_id='" . $cashier_id . "' AND ";
            $sqlinvoicestring .="s.date>='" . $from . "' AND ";
            $sqlinvoicestring .="s.date<='" . $to . "' ";
            $sqlinvoicestring .="ORDER BY s.id DESC";
            $sqlinvoice = $obj->FlyQuery($sqlinvoicestring);
            $record = count($sqlinvoice);
            $record_label = "Total Record Found(" . $record . ")";
        } else {
            if (!empty($sqlcashier)) {
                $countcs = count($sqlcashier);
                $sqlinvoicestring = "SELECT * FROM sales_list WHERE ";
                $cs = 1;
                foreach ($sqlcashier as $cas):
                    if ($cs == $countcs) {
                        $sqlinvoicestring .="cashier_id='" . $cas->id . "' ";
                    } else {
                        $sqlinvoicestring .="cashier_id='" . $cas->id . "' AND ";
                    }
                    $cs++;
                endforeach;
                $sqlinvoicestring .="ORDER BY id DESC";
                $sqlinvoice = $obj->FlyQuery($sqlinvoicestring);
                $record = count($sqlinvoice);
                $record_label = "Total Record Found(" . $record . ")";
            } else {
                $sqlinvoice = array();
                $record = 0;
                $record_label = "Total Record Found(" . $record . ")";
            }
        }
    } elseif ($input_status == 5) {
        if (isset($_GET['from'])) {
            $from = $_GET['from'];
            $to = $_GET['to'];
            $cashier_id = $_GET['cashier_id'];

            $sqlinvoicestring = "SELECT * FROM sales_list as s WHERE ";
            $sqlinvoicestring .="s.cashier_id='" . $cashier_id . "' AND ";
            $sqlinvoicestring .="s.date>='" . $from . "' AND ";
            $sqlinvoicestring .="s.date<='" . $to . "' ";
            $sqlinvoicestring .="ORDER BY s.id DESC";
            $sqlinvoice = $obj->FlyQuery($sqlinvoicestring);
            $record = count($sqlinvoice);
            $record_label = "Total Record Found(" . $record . ")";
        } else {
            if (!empty($sqlcashier)) {
                $countcs = count($sqlcashier);
                $sqlinvoicestring = "SELECT * FROM sales_list WHERE ";
                $cs = 1;
                foreach ($sqlcashier as $cas):
                    if ($cs == $countcs) {
                        $sqlinvoicestring .="cashier_id='" . $cas->id . "' ";
                    } else {
                        $sqlinvoicestring .="cashier_id='" . $cas->id . "' AND ";
                    }
                    $cs++;
                endforeach;
                $sqlinvoicestring .="ORDER BY id DESC";
                $sqlinvoice = $obj->FlyQuery($sqlinvoicestring);
                $record = count($sqlinvoice);
                $record_label = "Total Record Found(" . $record . ")";
            } else {
                $sqlinvoice = array();
                $record = 0;
                $record_label = "Total Record Found(" . $record . ")";
            }
        }
    } else {
        if (isset($_GET['from'])) {
            $from = $_GET['from'];
            $to = $_GET['to'];
            $cashier_id = $_GET['cashier_id'];

            $sqlinvoicestring = "SELECT * FROM sales_list as s WHERE ";
            $sqlinvoicestring .="s.cashier_id='" . $cashier_id . "' AND ";
            $sqlinvoicestring .="s.date>='" . $from . "' AND ";
            $sqlinvoicestring .="s.date<='" . $to . "' ";
            $sqlinvoicestring .="ORDER BY s.id DESC";
            $sqlinvoice = $obj->FlyQuery($sqlinvoicestring);
            $record = count($sqlinvoice);
            $record_label = "Total Record Found(" . $record . ")";
        } else {
            if (!empty($sqlcashier)) {
                $countcs = count($sqlcashier);
                $sqlinvoicestring = "SELECT * FROM sales_list WHERE ";
                $cs = 1;
                foreach ($sqlcashier as $cas):
                    if ($cs == $countcs) {
                        $sqlinvoicestring .="cashier_id='" . $cas->id . "' ";
                    } else {
                        $sqlinvoicestring .="cashier_id='" . $cas->id . "' AND ";
                    }
                    $cs++;
                endforeach;
                $sqlinvoicestring .="ORDER BY id DESC";
                $sqlinvoice = $obj->FlyQuery($sqlinvoicestring);
                $record = count($sqlinvoice);
                $record_label = "Total Record Found(" . $record . ")";
            } else {
                $sqlinvoice = array();
                $record = 0;
                $record_label = "Total Record Found(" . $record . ")";
            }
        }
    }

    header('Content-type: application/excel');
    $filename = "Cashier_Sales_list_" . date('Y_m_d') . '.xls';
    header('Content-Disposition: attachment; filename=' . $filename);

    $data = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">
<head>
    <!--[if gte mso 9]>
    <xml>
        <x:ExcelWorkbook>
            <x:ExcelWorksheets>
                <x:ExcelWorksheet>
                    <x:Name>Cashier Sales List : Wireless Geeks Inc.</x:Name>
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
    $data .="<h5>Cashier Sales List Generate Date : " . date('d-m-Y H:i:s') . "</h5>";

    $data .="<table>
    <thead>
        <tr style='background:#09f; color:#fff;'>
			<th>#</th>
			<th>Sales-ID</th>
			<th>Cashier</th>
			<th>Product Name</th>
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
            $data.="<tr>
				<td>" . $i . "</td>
				<td>" . $invoice->sales_id . "</td>
				<td>" . $invoice->cashier . "</td>
				<td>" . $invoice->product . "</td>
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
			<th>Sales-ID</th>
			<th>Cashier</th>
			<th>Product Name</th>
			<th>Quantity</th>
			<th>Retail</th>
			<th>Our Cost</th>
			<th>Total Retail</th>
			<th>Our Total Cost</th>
			<th>Profit</th>
			<th>Date</th>
		</tr></tfoot></table>";




    $data.="<table border='0' width='250' style='width:200px;'>
					<tbody>
						<tr>
							<td>1. Total Quantity = <strong>" . $dd . "</strong></td>
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
					</tbody>
				</table>";

    $data .='</body></html>';

    echo $data;
}

if (@$_GET['export'] == "pdf") {
//    if ($input_status == 1) {
//        if (isset($_GET['from'])) {
//            $from=$_GET['from'];
//            $to=$_GET['to'];
//            $cashier_id=$_GET['cashier_id'];
//            $sqlinvoice=$report->SelectAllDateCond("sales_list", "cashier_id", $cashier_id, $from, $to, "1");
//            $record=$report->SelectAllDateCond("sales_list", "cashier_id", $cashier_id, $from, $to, "2");
//            $record_label="Total record Found ( " . $record . " ). | Report Generate Between " . $from . " - " . $to;
//        }else {
//            $sqlinvoice=$obj->SelectAll("sales_list");
//            $record=$obj->totalrows("sales_list");
//            $record_label="Total Record Found ( " . $record . " )";
//        }
//    }else {
//        if (isset($_GET['from'])) {
//            $from=$_GET['from'];
//            $to=$_GET['to'];
//            $cashier_id=$_GET['cashier_id'];
//            $sqlinvoice=$report->SelectAllDateCond_store2("sales_list", "cashier_id", $cashier_id, "input_by", $input_by, $from, $to, "1");
//            $record=$report->SelectAllDateCond_store2("sales_list", "cashier_id", $cashier_id, "input_by", $input_by, $from, $to, "2");
//            $record_label="Total record Found ( " . $record . " ). | Report Generate Between " . $from . " - " . $to;
//        }else {
//            $sqlinvoice=$obj->SelectAllByID("sales_list", array("input_by"=>$input_by));
//            $record=$obj->exists_multiple("sales_list", array("input_by"=>$input_by));
//            $record_label="Total Record Found ( " . $record . " )";
//        }
//    }


    if ($input_status == 1) {
        if (isset($_GET['from'])) {
            $from = $_GET['from'];
            $to = $_GET['to'];
            $cashier_id = $_GET['cashier_id'];
            $sqlinvoicestring = "SELECT * FROM sales_list as s WHERE ";
            $sqlinvoicestring .="s.cashier_id='" . $cashier_id . "' AND ";
            $sqlinvoicestring .="s.date>='" . $from . "' AND ";
            $sqlinvoicestring .="s.date<='" . $to . "' ";
            $sqlinvoicestring .="ORDER BY s.id DESC";
            $sqlinvoice = $obj->FlyQuery($sqlinvoicestring);
            $record = count($sqlinvoice);
            $record_label = "Total Record Found(" . $record . ")";
        } else {
            if (!empty($sqlcashier)) {
                $countcs = count($sqlcashier);
                $sqlinvoicestring = "SELECT * FROM sales_list WHERE ";
                $cs = 1;
                foreach ($sqlcashier as $cas):
                    if ($cs == $countcs) {
                        $sqlinvoicestring .="cashier_id='" . $cas->id . "' ";
                    } else {
                        $sqlinvoicestring .="cashier_id='" . $cas->id . "' AND ";
                    }
                    $cs++;
                endforeach;
                $sqlinvoicestring .="ORDER BY id DESC";
                $sqlinvoice = $obj->FlyQuery($sqlinvoicestring);
                $record = count($sqlinvoice);
                $record_label = "Total Record Found(" . $record . ")";
            } else {
                $sqlinvoice = array();
                $record = 0;
                $record_label = "Total Record Found(" . $record . ")";
            }
        }
    } elseif ($input_status == 5) {
        if (isset($_GET['from'])) {
            $from = $_GET['from'];
            $to = $_GET['to'];
            $cashier_id = $_GET['cashier_id'];

            $sqlinvoicestring = "SELECT * FROM sales_list as s WHERE ";
            $sqlinvoicestring .="s.cashier_id='" . $cashier_id . "' AND ";
            $sqlinvoicestring .="s.date>='" . $from . "' AND ";
            $sqlinvoicestring .="s.date<='" . $to . "' ";
            $sqlinvoicestring .="ORDER BY s.id DESC";
            $sqlinvoice = $obj->FlyQuery($sqlinvoicestring);
            $record = count($sqlinvoice);
            $record_label = "Total Record Found(" . $record . ")";
        } else {
            if (!empty($sqlcashier)) {
                $countcs = count($sqlcashier);
                $sqlinvoicestring = "SELECT * FROM sales_list WHERE ";
                $cs = 1;
                foreach ($sqlcashier as $cas):
                    if ($cs == $countcs) {
                        $sqlinvoicestring .="cashier_id='" . $cas->id . "' ";
                    } else {
                        $sqlinvoicestring .="cashier_id='" . $cas->id . "' AND ";
                    }
                    $cs++;
                endforeach;
                $sqlinvoicestring .="ORDER BY id DESC";
                $sqlinvoice = $obj->FlyQuery($sqlinvoicestring);
                $record = count($sqlinvoice);
                $record_label = "Total Record Found(" . $record . ")";
            } else {
                $sqlinvoice = array();
                $record = 0;
                $record_label = "Total Record Found(" . $record . ")";
            }
        }
    } else {
        if (isset($_GET['from'])) {
            $from = $_GET['from'];
            $to = $_GET['to'];
            $cashier_id = $_GET['cashier_id'];

            $sqlinvoicestring = "SELECT * FROM sales_list as s WHERE ";
            $sqlinvoicestring .="s.cashier_id='" . $cashier_id . "' AND ";
            $sqlinvoicestring .="s.date>='" . $from . "' AND ";
            $sqlinvoicestring .="s.date<='" . $to . "' ";
            $sqlinvoicestring .="ORDER BY s.id DESC";
            $sqlinvoice = $obj->FlyQuery($sqlinvoicestring);
            $record = count($sqlinvoice);
            $record_label = "Total Record Found(" . $record . ")";
        } else {
            if (!empty($sqlcashier)) {
                $countcs = count($sqlcashier);
                $sqlinvoicestring = "SELECT * FROM sales_list WHERE ";
                $cs = 1;
                foreach ($sqlcashier as $cas):
                    if ($cs == $countcs) {
                        $sqlinvoicestring .="cashier_id='" . $cas->id . "' ";
                    } else {
                        $sqlinvoicestring .="cashier_id='" . $cas->id . "' AND ";
                    }
                    $cs++;
                endforeach;
                $sqlinvoicestring .="ORDER BY id DESC";
                $sqlinvoice = $obj->FlyQuery($sqlinvoicestring);
                $record = count($sqlinvoice);
                $record_label = "Total Record Found(" . $record . ")";
            } else {
                $sqlinvoice = array();
                $record = 0;
                $record_label = "Total Record Found(" . $record . ")";
            }
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
						Cashier Sales List Report
						</td>
					</tr>
				</table>


				<table style='width:100%; height:40px; border:0px; font-size:18px;'>
					<tr>
						<td> Cashier Sales List Generate Date : " . date('d-m-Y H:i:s') . "</td>
					</tr>
				</table>
				<table style='width:960px;border:1px; font-size:12px; background:#ccc;'>";
    $html.="<thead>
        <tr style='background:#09f; color:#fff;'>
			<th>#</th>
			<th>Sales-ID</th>
			<th>Cashier</th>
			<th>Product Name</th>
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
				<td>" . $invoice->sales_id . "</td>
				<td>" . $invoice->cashier . "</td>
				<td>" . $invoice->product . "</td>
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
			<th>Sales-ID</th>
			<th>Cashier</th>
			<th>Product Name</th>
			<th>Quantity</th>
			<th>Retail</th>
			<th>Our Cost</th>
			<th>Total Retail</th>
			<th>Our Total Cost</th>
			<th>Profit</th>
			<th>Date</th>
		</tr></tfoot></table>";

    $html.="<table border='0'  width='250' style='width:250px;'>
					<tbody>
						<tr>
							<td>1. Total Quantity = <strong>" . $dd . "</strong></td>
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
                <?php echo $obj->ShowMsg(); ?>
                <!-- /info notice -->

                <div class="outer">
                    <div class="inner">
                        <div class="page-header"><!-- Page header -->
                            <?php
                            echo $obj->ShowMsg();
                            /* if ($input_status == 1) {
                              if (isset($_GET['from'])) {
                              $from=$_GET['from'];
                              $to=$_GET['to'];
                              $cashier_id=$_GET['cashier_id'];

                              //                                    $sqlinvoice=$obj_report_chain->ReportQuery_Datewise_Or_array("sales_list", array("cashier_id"=>$cashier_id), $array_ch, "input_by", $_GET['from'], $_GET['to'], "1");
                              //                                    $record=$obj_report_chain->ReportQuery_Datewise_Or_array("sales_list", array("cashier_id"=>$cashier_id), $array_ch, "input_by", $_GET['from'], $_GET['to'], "2");
                              //                                    $record_label="Total record Found ( " . $record . " ). | Report Generate Between " . $from . " - " . $to;

                              $sqlinvoicestring="SELECT * FROM sales_list as s WHERE ";
                              $sqlinvoicestring .="s.cashier_id='" . $cashier_id . "' AND ";
                              $sqlinvoicestring .="s.date>='" . $from . "' AND ";
                              $sqlinvoicestring .="s.date<='" . $to . "' ";
                              $sqlinvoicestring .="ORDER BY s.id DESC";
                              $sqlinvoice=$obj->FlyQuery($sqlinvoicestring);
                              $record=count($sqlinvoice);
                              $record_label="Total Record Found(" . $record . ")";
                              }else {
                              //                                    $sqlinvoice=$obj_report_chain->SelectAllByID_Multiple_Or("sales_list", $array_ch, "input_by", "1");
                              //                                    $record=$obj_report_chain->SelectAllByID_Multiple_Or("sales_list", $array_ch, "input_by", "2");
                              //                                    $record_label="Total Record Found ( " . $record . " )";

                              if (!empty($sqlcashier)) {
                              $countcs=count($sqlcashier);
                              $sqlinvoicestring="SELECT * FROM sales_list WHERE ";
                              $cs=1;
                              foreach ($sqlcashier as $cas):
                              if ($cs == $countcs) {
                              $sqlinvoicestring .="cashier_id='" . $cas->id . "' ";
                              }else {
                              $sqlinvoicestring .="cashier_id='" . $cas->id . "' AND ";
                              }
                              $cs++;
                              endforeach;
                              $sqlinvoicestring .="ORDER BY id DESC";
                              $sqlinvoice=$obj->FlyQuery($sqlinvoicestring);
                              $record=count($sqlinvoice);
                              $record_label="Total Record Found(" . $record . ")";
                              }else {
                              $sqlinvoice=array();
                              $record=0;
                              $record_label="Total Record Found(" . $record . ")";
                              }
                              }
                              }elseif ($input_status == 5) {
                              if (isset($_GET['from'])) {
                              $from=$_GET['from'];
                              $to=$_GET['to'];
                              $cashier_id=$_GET['cashier_id'];

                              //                                    $sqlinvoice=$obj_report_chain->ReportQuery_Datewise_Or_array("sales_list", array("cashier_id"=>$cashier_id), $array_ch, "input_by", $_GET['from'], $_GET['to'], "1");
                              //                                    $record=$obj_report_chain->ReportQuery_Datewise_Or_array("sales_list", array("cashier_id"=>$cashier_id), $array_ch, "input_by", $_GET['from'], $_GET['to'], "2");
                              //                                    $record_label="Total record Found ( " . $record . " ). | Report Generate Between " . $from . " - " . $to;

                              $sqlinvoicestring="SELECT * FROM sales_list as s WHERE ";
                              $sqlinvoicestring .="s.cashier_id='" . $cashier_id . "' AND ";
                              $sqlinvoicestring .="s.date>='" . $from . "' AND ";
                              $sqlinvoicestring .="s.date<='" . $to . "' ";
                              $sqlinvoicestring .="ORDER BY s.id DESC";
                              $sqlinvoice=$obj->FlyQuery($sqlinvoicestring);
                              $record=count($sqlinvoice);
                              $record_label="Total Record Found(" . $record . ")";
                              }else {
                              //                                    $sqlinvoice=$obj_report_chain->SelectAllByID_Multiple_Or("sales_list", $array_ch, "input_by", "1");
                              //                                    $record=$obj_report_chain->SelectAllByID_Multiple_Or("sales_list", $array_ch, "input_by", "2");
                              //                                    $record_label="Total Record Found ( " . $record . " )";

                              if (!empty($sqlcashier)) {
                              $countcs=count($sqlcashier);
                              $sqlinvoicestring="SELECT * FROM sales_list WHERE ";
                              $cs=1;
                              foreach ($sqlcashier as $cas):
                              if ($cs == $countcs) {
                              $sqlinvoicestring .="cashier_id='" . $cas->id . "' ";
                              }else {
                              $sqlinvoicestring .="cashier_id='" . $cas->id . "' AND ";
                              }
                              $cs++;
                              endforeach;
                              $sqlinvoicestring .="ORDER BY id DESC";
                              $sqlinvoice=$obj->FlyQuery($sqlinvoicestring);
                              $record=count($sqlinvoice);
                              $record_label="Total Record Found(" . $record . ")";
                              }else {
                              $sqlinvoice=array();
                              $record=0;
                              $record_label="Total Record Found(" . $record . ")";
                              }
                              }
                              }else {
                              if (isset($_GET['from'])) {
                              $from=$_GET['from'];
                              $to=$_GET['to'];
                              $cashier_id=$_GET['cashier_id'];

                              $sqlinvoicestring="SELECT * FROM sales_list as s WHERE ";
                              $sqlinvoicestring .="s.cashier_id='" . $cashier_id . "' AND ";
                              $sqlinvoicestring .="s.date>='" . $from . "' AND ";
                              $sqlinvoicestring .="s.date<='" . $to . "' ";
                              $sqlinvoicestring .="ORDER BY s.id DESC";
                              $sqlinvoice=$obj->FlyQuery($sqlinvoicestring);
                              $record=count($sqlinvoice);
                              $record_label="Total Record Found(" . $record . ")";
                              }else {
                              if (!empty($sqlcashier)) {
                              $countcs=count($sqlcashier);
                              $sqlinvoicestring="SELECT * FROM sales_list WHERE ";
                              $cs=1;
                              foreach ($sqlcashier as $cas):
                              if ($cs == $countcs) {
                              $sqlinvoicestring .="cashier_id='" . $cas->id . "' ";
                              }else {
                              $sqlinvoicestring .="cashier_id='" . $cas->id . "' AND ";
                              }
                              $cs++;
                              endforeach;
                              $sqlinvoicestring .="ORDER BY id DESC";
                              $sqlinvoice=$obj->FlyQuery($sqlinvoicestring);
                              $record=count($sqlinvoice);
                              $record_label="Total Record Found(" . $record . ")";
                              }else {
                              $sqlinvoice=array();
                              $record=0;
                              $record_label="Total Record Found(" . $record . ")";
                              }
                              }
                              } */
                            ?>
                            <h5><i class="font-money"></i> Cashier Sales Report | <?php //echo $record_label;      ?> | <a  data-toggle="modal" href="#myModal"> Search Datewise </a></h5>
                        </div><!--/page header -->

                        <div class="body">

                            <!--Middle navigation standard -->
                            <?php //include('include/quicklink.php');
                            ?>
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
                                            <h5 id="myModalLabel"><i class="font-calendar"></i> Generate Cashier Sales Report <span id="mss"></span></h5>
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
                                        <script id="sales_link" type="text/x-kendo-template">
                                            <a class="k-button k-button-icontext k-grid-delete" href="view_sales.php?invoice=#=sales_id#">#=sales_id#</a>
                                        </script>
                                        <?php
                                        $cond = $cms->FrontEndDateSearch('from', 'to');
                                        ?>
                                        <script type="text/javascript">
                                            jQuery(document).ready(function () {
                                                var dataSource = new kendo.data.DataSource({
                                                    transport: {
                                                        read: {
                                                            url: "./controller/cashier_sales_report.php<?php echo $cond; ?>",
                                                            type: "GET",
                                                            datatype: "json",
                                                            complete: function (response) {
                                                                var page_countitem = 0;
                                                                var page_item = 0;
                                                                var page_total_our_cost = 0;
                                                                var page_total_retail_cost = 0;
                                                                jQuery.each(response, function (index, key) {
                                                                    if (index == 'responseJSON')
                                                                    {
                                                                        //console.log(key.data);
                                                                        jQuery.each(key.data, function (datagr, keyg) {
                                                                            //console.log(keyg.our_cost);
                                                                            page_item += (1-0);
                                                                            page_countitem += (keyg.quantity - 0);
                                                                            page_total_our_cost += (keyg.total_our_cost - 0);
                                                                            page_total_retail_cost += (keyg.total_retail_cost - 0);

                                                                        });
                                                                        //console.log(page_ourcost);
                                                                        jQuery("#a1").html(page_countitem+" Quantity in "+page_item+" Item ");
                                                                        jQuery("#a2").html(parseFloat(page_total_our_cost).toFixed(2));
                                                                        jQuery("#a3").html(parseFloat(page_total_retail_cost).toFixed(2));
                                                                        jQuery("#a4").html(parseFloat((page_total_retail_cost - page_total_our_cost)).toFixed(2));
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
                                                                sales_id: {type: "string"},
                                                                cashier: {type: "string"},
                                                                product_name: {type: "string"},
                                                                quantity: {type: "string"},
                                                                retail_cost: {type: "string"},
                                                                our_cost: {type: "string"},
                                                                total_retail_cost: {type: "string"},
                                                                total_our_cost: {type: "string"},
                                                                date: {type: "string"},
                                                                profit: {type: "string"}
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
                                                        {template: kendo.template($("#sales_link").html()), title: "Sales ID"},
                                                        {field: "cashier", title: "Cashier"},
                                                        {field: "product_name", title: "Product"},
                                                        {field: "quantity", title: "Quantity",width:"60px", filterable: false},
                                                        {template: "<?php echo $currencyicon; ?>#=retail_cost#", title: "Retail",width:"60px", filterable: false},
                                                        {template: "<?php echo $currencyicon; ?>#=our_cost#", title: "Our Cost",width:"60px", filterable: false},
                                                        {template: "<?php echo $currencyicon; ?>#=total_retail_cost#", title: "Total Retail",width:"80px", filterable: false},
                                                        {template: "<?php echo $currencyicon; ?>#=total_our_cost#", title: "Our Total Cost",width:"80px", filterable: false},
                                                        {template: "<?php echo $currencyicon; ?>#=profit#", title: "Profit",width:"60px", filterable: false},
                                                        {field: "date", title: "Created"}
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
                                            JSONToCSVConvertor(json_data, "Cashier Sales Report List", true);

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
                                            var fileName = "cashier_sales_report_list_";
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

                                    <?php /*
                                      <div class="table-overflow">
                                      <table class="table table-striped" id="data-table">
                                      <thead>

                                      <tr>
                                      <th>#</th>
                                      <th>Sales-ID</th>
                                      <?php if ($input_status == 1 || $input_status == 5) { ?>
                                      <th>Store</th>
                                      <?php } ?>
                                      <th>Cashier</th>
                                      <th>Product Name</th>
                                      <th>Quantity</th>
                                      <th>Retail</th>
                                      <th>Our Cost</th>
                                      <th>Total Retail</th>
                                      <th>Our Total Cost</th>
                                      <th>Profit</th>
                                      <th>Date</th>
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
                                      <?php if ($input_status == 1 || $input_status == 5) { ?>
                                      <td><?php echo $obj->SelectAllByVal("store", "store_id", $invoice->input_by, "name"); ?></td>
                                      <?php } ?>
                                      <td><?php echo $invoice->cashier; ?></td>
                                      <td><?php echo $invoice->product; ?></td>
                                      <td><label class="label label-success"><?php
                                      $dd+=$invoice->quantity;
                                      echo $invoice->quantity;
                                      ?></label></td>
                                      <td><label class="label label-success"> $<?php echo $invoice->single_cost; ?> </label></td>
                                      <td><label class="label label-warning"> $<?php echo $invoice->our_cost; ?> </label></td>

                                      <td><label class="label label-success"> $<?php
                                      $aa+=$invoice->totalcost;
                                      echo $invoice->totalcost;
                                      ?></label></td>
                                      <td><label class="label label-warning"> $<?php
                                      $bb+=$invoice->our_totalcost;
                                      echo $invoice->our_totalcost;
                                      ?></label></td>
                                      <td><label class="label label-danger"> $<?php
                                      $cc+=$invoice->profit;
                                      echo $invoice->profit;
                                      ?></label></td>
                                      <td><?php echo $invoice->date; ?></td>
                                      </tr>
                                      <?php
                                      $i++;
                                      endforeach;
                                      ?>
                                      </tbody>
                                      </table>
                                      </div>
                                     */ ?>


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
                                                        <td>1. Page Total Quantity = <strong id="a1"> <?php //echo $dd;      ?></strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td>2. Our Total Cost = <?php echo $currencyicon; ?><strong id="a2"> <?php //echo number_format($bb, 2);      ?></strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td>3. Total Retail Cost = <?php echo $currencyicon; ?><strong id="a3"> <?php //echo number_format($aa, 2);      ?></strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td>4. Total Profit = <?php echo $currencyicon; ?><strong id="a4"> <?php //echo number_format($cc, 2);      ?></strong></td>
                                                    </tr>

                                                </tbody>
                                            </table>
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
            include ('include/footer.php');
            echo $cms->KendoFotter();
            ?>
            <!-- Right sidebar -->
            <?php //include('include/sidebar_right.php');           ?>
            <!-- /right sidebar -->

        </div>
        <!-- /main wrapper -->

    </body>
</html>
