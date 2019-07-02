<?php
include('class/auth.php');
if ($input_status == 3 || $input_status == 4) {
    $obj->Error("Invalid Page Request.", "index.php");
}
include('class/report_customer.php');
$report = new report();
if (isset($_GET['del'])) {
    $obj->deletesing("id", $_GET['del'], "checkin_request");
}

if (isset($_GET['logdel'])) {
    $obj->deletesing("id", $_GET['logdel'], "access_log");
}

if (isset($_GET['delss'])) {
    if ($input_status == 1) {
        $totallcd = $report->SelectAllCondNot("checkin_list", "lcdstatus", "0", "2");
        $totalgoodlcd = $report->SelectAllCond("checkin_list", "lcdstatus", "1", "0");
        $totalbadlcd = $report->SelectAllCond("checkin_list", "lcdstatus", "2", "0");
        $detail = "Total Record ( " . $totallcd . " ) Deleted, Good LCD (" . $totalgoodlcd . "), Bad LCD (" . $totalbadlcd . ")";
        $obj->insert("access_log", array("store_id" => $input_by, "name" => $detail, "datetime" => date('Y-m-d g:i:s A'), "date" => date('Y-m-d'), "status" => 9));

        if ($report->DeleteAllCond("checkin_request_ticket", "lcdstatus", "0") == 1) {
            $obj->Success("All Deleted Succesfully", $obj->filename());
        } else {
            $obj->Error("All Are Not Deleted Succesfully", $obj->filename());
        }
    } else {
        $totallcd = $report->SelectAllCondNot_Store("checkin_list", "lcdstatus", "0", "2", "input_by", $input_by);
        $totalgoodlcd = $report->SelectAllCond_Store("checkin_list", "lcdstatus", "1", "0", "input_by", $input_by);
        $totalbadlcd = $report->SelectAllCond_Store("checkin_list", "lcdstatus", "2", "0", "input_by", $input_by);
        $detail = "Total Record ( " . $totallcd . " ) Deleted, Good LCD (" . $totalgoodlcd . "), Bad LCD (" . $totalbadlcd . ")";
        $obj->insert("access_log", array("store_id" => $input_by, "name" => $detail, "datetime" => date('Y-m-d g:i:s A'), "date" => date('Y-m-d'), "status" => 9));

        if ($report->DeleteAllCond_Store("checkin_request_ticket", "lcdstatus", "0", "store_id", $input_by) == 1) {
            $obj->Success("All Deleted Succesfully", $obj->filename());
        } else {
            $obj->Error("All Are Not Deleted Succesfully", $obj->filename());
        }
    }
}

if (isset($_GET['deletesearch'])) {
    extract($_GET);
    if ($input_status == 1) {
        $totallcd = $report->SelectAllDateCondNot("checkin_list", "lcdstatus", "0", $froms, $tos, "0");
        $totalgoodlcd = $report->SelectAllDateCond("checkin_list", "lcdstatus", "1", $froms, $tos, "0");
        $totalbadlcd = $report->SelectAllDateCond("checkin_list", "lcdstatus", "2", $froms, $tos, "0");
        $detail = "Total Record ( " . $totallcd . " ) Deleted, Good LCD (" . $totalgoodlcd . "), Bad LCD (" . $totalbadlcd . ")";
        $obj->insert("access_log", array("name" => $detail, "datetime" => date('Y-m-d g:i:s A'), "date" => date('Y-m-d'), "status" => 9));
        if ($report->DeleteAllDateCondNot("checkin_request_ticket", "lcdstatus", "0", $froms, $tos) == 1) {
//echo "All Deleted Succesfully";
            $obj->Success("All Deleted Succesfully", $obj->filename());
        } else {
            $obj->Error("All Are Not Deleted Succesfully", $obj->filename());
        }
    } else {
        $totallcd = $report->SelectAllDateCondNot_Store("checkin_list", "lcdstatus", "0", $froms, $tos, "0", "input_by", $input_by);
        $totalgoodlcd = $report->SelectAllDateCond_Store("checkin_list", "lcdstatus", "1", $froms, $tos, "0", "input_by", $input_by);
        $totalbadlcd = $report->SelectAllDateCond_Store("checkin_list", "lcdstatus", "2", $froms, $tos, "0", "input_by", $input_by);
        $detail = "Total Record ( " . $totallcd . " ) Deleted, Good LCD (" . $totalgoodlcd . "), Bad LCD (" . $totalbadlcd . ")";
        $obj->insert("access_log", array("name" => $detail, "datetime" => date('Y-m-d g:i:s A'), "date" => date('Y-m-d'), "status" => 9));
        if ($report->DeleteAllDateCondNot_Store("checkin_request_ticket", "lcdstatus", "0", $froms, $tos, "uid", $input_by) == 1) {
//echo "All Deleted Succesfully";
            $obj->Success("All Deleted Succesfully", $obj->filename());
        } else {
            $obj->Error("All Are Not Deleted Succesfully", $obj->filename());
        }
    }
}

function checkin_status($st) {
    if ($st == 1) {
        return "Completed";
    } else {
        return "Not Completed";
    }
}

function checkin_paid($st) {
    if ($st == 0) {
        return "<label class='label label-danger'>Not Paid</label>";
    } else {
        return "<label class='label label-success'>Paid</label>";
    }
}

function Lcd($st) {
    if ($st == 1) {
        return "Good";
    } elseif ($st == 2) {
        return "Bad";
    } elseif ($st == 0) {
        return "No Mention";
    } else {
        return "No Mention";
    }
}

if (@$_GET['export'] == "excel") {
    if (isset($_GET['from'])) {
        if ($input_status == 1) {
            $from = $_GET['from'];
            $to = $_GET['to'];
            $sqlticket = $report->SelectAllDateCondNot("checkin_list", "lcdstatus", "0", $from, $to, "1");
            $record = $report->SelectAllDateCondNot("checkin_list", "lcdstatus", "0", $from, $to, "2");
            $record_label = "| Report Generate Between " . $from . " - " . $to;
        } else {
            $from = $_GET['from'];
            $to = $_GET['to'];
            $sqlticket = $report->SelectAllDateCondNot_Store("checkin_list", "lcdstatus", "0", $from, $to, "1", "input_by", $input_by);
            $record = $report->SelectAllDateCondNot_Store("checkin_list", "lcdstatus", "0", $from, $to, "2", "input_by", $input_by);
            $record_label = "| Report Generate Between " . $from . " - " . $to;
        }
    } else {
        if ($input_status == 1) {
            $sqlticket = $report->SelectAllCondNot("checkin_list", "lcdstatus", "0", "1");
            $record = $report->SelectAllCondNot("checkin_list", "lcdstatus", "0", "2");
            $record_label = "";
        } else {
            $sqlticket = $report->SelectAllCondNot_Store("checkin_list", "lcdstatus", "0", "1", "input_by", $input_by);
            $record = $report->SelectAllCondNot_Store("checkin_list", "lcdstatus", "0", "2", "input_by", $input_by);
            $record_label = "";
        }
    }

    header('Content-type: application/excel');
    $filename = "Checkin_LCD_Report_list_" . date('Y_m_d') . '.xls';
    header('Content-Disposition: attachment; filename=' . $filename);

    $data = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">
<head>
    <!--[if gte mso 9]>
    <xml>
        <x:ExcelWorkbook>
            <x:ExcelWorksheets>
                <x:ExcelWorksheet>
                    <x:Name>Checkin LCD Report List : Wireless Geeks Inc.</x:Name>
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
    $data .="<h5>Checkin LCD Report List Generate Date : " . date('d-m-Y H:i:s') . "</h5>";

    $data .="<table>
    <thead>
        <tr style='background:#09f; color:#fff;'>
		<th>#</th>
		<th>Checkin ID</th>
		<th>Check IN Detail</th>
		<th>Lcd Status</th>
		<th>Date</th>
		</tr>
</thead>
<tbody>";

    $i = 1;
    $a = 0;
    $b = 0;
    $c = 0;
    $d = 0;
    if (!empty($sqlticket))
        foreach ($sqlticket as $ticket):

            $chkcheckin = $obj->exists_multiple("invoice", array("doc_type" => 3, "checkin_id" => $ticket->checkin_id));
            $getsales_id = $obj->SelectAllByVal("invoice", "checkin_id", $ticket->checkin_id, "invoice_id");
            $curcheck = $obj->exists_multiple("sales", array("sales_id" => $getsales_id));
            if ($curcheck != 0) {
                if ($ticket->lcdstatus == 1) {
                    $a+=1;
                } elseif ($ticket->lcdstatus == 2) {
                    $b+=1;
                }


                $data.="<tr>
				<td>" . $i . "</td>
				<td>" . $ticket->checkin_id . "</td>
				<td>" . $ticket->device . " " . $ticket->model . " " . $ticket->color . " " . $ticket->network . " " . $ticket->problem . "</td>
				<td>" . Lcd($ticket->lcdstatus) . "</td>
				<td>" . $ticket->date . "</td>
			</tr>";

                $i++;
            } endforeach;

    $data .="</tbody><tfoot><tr>
		<th>#</th>
		<th>Checkin ID</th>
		<th>Check IN Detail</th>
		<th>Lcd Status</th>
		<th>Date</th>
		</tr></tfoot></table>";




    $data.="<table border='0' width='250' style='width:200px;'>
					<tbody>
						<tr>
							<td colspan='2'> <strong>LCD Report</strong> </td>
						</tr>
						<tr>
							<td>1. Total Good LCD </td>
							<td>" . $a . "</td>
						</tr>
						<tr>
							<td>2. Total Bad LCD  </td>
							<td>" . $b . "</td>
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
            $sqlticket = $report->SelectAllDateCondNot("checkin_list", "lcdstatus", "0", $from, $to, "1");
            $record = $report->SelectAllDateCondNot("checkin_list", "lcdstatus", "0", $from, $to, "2");
            $record_label = "| Report Generate Between " . $from . " - " . $to;
        } else {
            $from = $_GET['from'];
            $to = $_GET['to'];
            $sqlticket = $report->SelectAllDateCondNot_Store("checkin_list", "lcdstatus", "0", $from, $to, "1", "input_by", $input_by);
            $record = $report->SelectAllDateCondNot_Store("checkin_list", "lcdstatus", "0", $from, $to, "2", "input_by", $input_by);
            $record_label = "| Report Generate Between " . $from . " - " . $to;
        }
    } else {
        if ($input_status == 1) {
            $sqlticket = $report->SelectAllCondNot("checkin_list", "lcdstatus", "0", "1");
            $record = $report->SelectAllCondNot("checkin_list", "lcdstatus", "0", "2");
            $record_label = "";
        } else {
            $sqlticket = $report->SelectAllCondNot_Store("checkin_list", "lcdstatus", "0", "1", "input_by", $input_by);
            $record = $report->SelectAllCondNot_Store("checkin_list", "lcdstatus", "0", "2", "input_by", $input_by);
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
						Checkin LCD Report List Report
						</td>
					</tr>
				</table>


				<table style='width:100%; height:40px; border:0px; font-size:18px;'>
					<tr>
						<td> Checkin LCD Report List Generate Date : " . date('d-m-Y H:i:s') . "</td>
					</tr>
				</table>
				<table style='width:960px;border:1px; font-size:12px; background:#ccc;'>";
    $html.="<thead>

        <tr style='background:#09f; color:#fff;'>
		<th>#</th>
		<th>Checkin ID</th>
		<th>Check IN Detail</th>
		<th>Lcd Status</th>
		<th>Date</th>
		</tr>
</thead>
<tbody>";


    $i = 1;
    $a = 0;
    $b = 0;
    $c = 0;
    $d = 0;
    if (!empty($sqlticket))
        foreach ($sqlticket as $ticket):

            $chkcheckin = $obj->exists_multiple("invoice", array("doc_type" => 3, "checkin_id" => $ticket->checkin_id));
            $getsales_id = $obj->SelectAllByVal("invoice", "checkin_id", $ticket->checkin_id, "invoice_id");
            $curcheck = $obj->exists_multiple("sales", array("sales_id" => $getsales_id));
            if ($curcheck != 0) {
                if ($ticket->lcdstatus == 1) {
                    $a+=1;
                } elseif ($ticket->lcdstatus == 2) {
                    $b+=1;
                }


                $html.="<tr>
				<td>" . $i . "</td>
				<td>" . $ticket->checkin_id . "</td>
				<td>" . $ticket->device . " " . $ticket->model . " " . $ticket->color . " " . $ticket->network . " " . $ticket->problem . "</td>
				<td>" . Lcd($ticket->lcdstatus) . "</td>
				<td>" . $ticket->date . "</td>
			</tr>";

                $i++;
            } endforeach;

    $html.="</tbody><tfoot><tr>
		<th>#</th>
		<th>Checkin ID</th>
		<th>Check IN Detail</th>
		<th>Lcd Status</th>
		<th>Date</th>
		</tr></tfoot></table>";

    $html.="<table border='0'  width='250' style='width:200px;'>
					<tbody>
						<tr>
							<td colspan='2'> <strong>LCD Report</strong> </td>
						</tr>
						<tr>
							<td>1. Total Good LCD </td>
							<td>" . $a . "</td>
						</tr>
						<tr>
							<td>2. Total Bad LCD  </td>
							<td>" . $b . "</td>
						</tr>
					</tbody>
				</table>";

    $html.="</td></tr>";
    $html.="</tbody></table>";
    $mpdf = new mPDF('c', 'A4', '', '', 32, 25, 27, 25, 16, 13);
    $mpdf->SetDisplayMode('fullpage');
    $mpdf->list_indent_first_level = 0;
    $stylesheet = file_get_contents('pdf/MPDF57/examples/mpdfstyletables.css');
    $mpdf->WriteHTML($stylesheet, 1);
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
//                if (isset($_GET['from'])) {
//                    if ($input_status == 1) {
//                        $from = $_GET['from'];
//                        $to = $_GET['to'];
//                        $sqlticket = $report->SelectAllDateCondNot("checkin_list", "lcdstatus", "0", $from, $to, "1");
//                        $record = $report->SelectAllDateCondNot("checkin_list", "lcdstatus", "0", $from, $to, "2");
//                        $record_label = "| Report Generate Between " . $from . " - " . $to;
//                    } else {
//                        $from = $_GET['from'];
//                        $to = $_GET['to'];
//                        $sqlticket = $report->SelectAllDateCondNot_Store("checkin_list", "lcdstatus", "0", $from, $to, "1", "input_by", $input_by);
//                        $record = $report->SelectAllDateCondNot_Store("checkin_list", "lcdstatus", "0", $from, $to, "2", "input_by", $input_by);
//                        $record_label = "| Report Generate Between " . $from . " - " . $to;
//                    }
//                } else {
//                    if ($input_status == 1) {
//                        $sqlticket = $report->SelectAllCondNot("checkin_list", "lcdstatus", "0", "1");
//                        $record = $report->SelectAllCondNot("checkin_list", "lcdstatus", "0", "2");
//                        $record_label = "";
//                    } else {
//                        $sqlticket = $report->SelectAllCondNot_Store("checkin_list", "lcdstatus", "0", "1", "input_by", $input_by);
//                        $record = $report->SelectAllCondNot_Store("checkin_list", "lcdstatus", "0", "2", "input_by", $input_by);
//                        $record_label = "";
//                    }
//                }
                ?>
                <!-- /info notice -->

                <div class="outer">
                    <div class="inner">
                        <div class="page-header"><!-- Page header -->
                            <h5><i class="icon-ok-circle"></i>
                                <span style="border-right:2px #333 solid; padding-right:10px;">CheckIn LCD Report Info </span>
                                <span><i class="font-calendar"></i> <a data-toggle="modal" href="#myModal"> Generate Checkin LCD Report</a></span> 
                            </h5>

                            <ul class="icons">
                                <li><a href="<?php echo $obj->filename(); ?>" class="hovertip" title="Reload"><i class="font-refresh"></i></a></li>
                            </ul>
                        </div><!-- /page header -->

                        <div class="body">
                            <?php
                            if (isset($_GET['dels'])) {
                                ?>
                                <!--<div class="span12">
                                <a class="btn btn-danger"  onclick="javascript:return confirm('Are you absolutely sure to Delete All Data ?')" style="border-radius:5px; margin-bottom:10px;" href="<?php //echo $obj->filename();    ?>?delss=all">Delete All Records</a>  <a  onclick="javascript:return confirm('Are you absolutely sure to Delete These Using Date?')" style="border-radius:5px; margin-bottom:10px;"  data-toggle="modal"  class="btn btn-danger" href="#myModal1"> Search Datewise Delete </a>
                                </div>-->
                            <?php } ?>
                            <!-- Dialog content -->

                            <!-- /dialog content -->

                            <!-- Dialog content -->
                            <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h5 id="myModalLabel"><i class="font-calendar"></i>  Generate Checkin LCD Report <span id="mss"></span></h5>
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

                            <?php //include('include/quicklink.php');   ?>
                            <!-- /middle navigation standard -->

                            <!-- Content container -->
                            <div class="container">



                                <!-- Content Start from here customized -->
                                <div class="row-fluid block">

                                    <div class="table-overflow">

                                        <div id="grid" style="margin-left: 10px;margin-right: 10px;"></div>
                                        <?php
                                        $cond = $cms->FrontEndDateSearch('from', 'to');
                                        ?>
                                        <script id="checkin_link" type="text/x-kendo-template">
                                            <a class="k-button" href="view_checkin.php?ticket_id=#=checkin_id#">#=checkin_id#</a>
                                        </script>
                                        <script type="text/javascript">
                                            jQuery(document).ready(function () {
                                                var dataSource = new kendo.data.DataSource({
                                                    transport: {
                                                        read: {
                                                            url: "./controller/checkin_lcd_report.php<?php echo $cond; ?>",
                                                            type: "GET",
                                                            datatype: "json",
                                                            complete: function (response) {
                                                                var page_lcd=0;
                                                                var page_goodlcd=0;
                                                                var page_badlcd=0;
                                                                jQuery.each(response, function (index, key) {
                                                                    if (index == 'responseJSON')
                                                                    {
                                                                        //console.log(key.data);
                                                                        jQuery.each(key.data, function (datagr, keyg) {
                                                                            console.log(keyg.lcdcondition);
                                                                            page_lcd += (1 - 0);
                                                                            var cond=keyg.lcdcondition;
                                                                            if(cond="Good")
                                                                            {
                                                                                page_goodlcd+=(1-0);
                                                                            }
                                                                            
                                                                            
                                                                            if(cond="Bad")
                                                                            {
                                                                                page_badlcd+=(1-0);
                                                                            }

                                                                        });
                                                                        //console.log(page_ourcost);
                                                                        jQuery("#a0").html(page_lcd + "  of  " + key.total);
                                                                        jQuery("#a2").html(page_goodlcd);
                                                                        jQuery("#a2").html(page_badlcd);

                                                                    }
                                                                })
                                                            }
//                                                            ,
//                                                            complete: function (response) {
//                                                                var page_countitem = 0;
//                                                                var page_sold = 0;
//                                                                var page_stock = 0;
//                                                                jQuery.each(response, function (index, key) {
//                                                                    if (index == 'responseJSON')
//                                                                    {
//                                                                        //console.log(key.data);
//                                                                        jQuery.each(key.data, function (datagr, keyg) {
//                                                                            //console.log(keyg.our_cost);
//                                                                            page_countitem += (1 - 0);
//                                                                            page_sold += (keyg.sold - 0);
//                                                                            page_stock += (keyg.stock - 0);
//
//                                                                        });
//                                                                        //console.log(page_ourcost);
//                                                                        jQuery("#a1").html(page_countitem + "  of  " + key.total);
//                                                                        jQuery("#a2").html("$" + page_sold);
//                                                                        jQuery("#a3").html("$" + page_stock);
//
//                                                                    }
//                                                                })
//                                                            }
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
                                                                checkin_id: {type: "string"},
                                                                detail: {type: "string"},
                                                                problem: {type: "string"},
                                                                checkin_price: {type: "string"},
                                                                date: {type: "string"},
                                                                status: {type: "number"},
                                                                lcdstatus: {type: "number"},
                                                                lcdcondition: {type: "string"}
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
                                                        {field: "id", title: "S.ID", width: "60px", filterable: false},
                                                        {title: "Checkin Id", width: "90px", template: kendo.template($("#checkin_link").html())},
                                                        {field: "detail", title: "Detail", width: "90px"},
                                                        {field: "lcdcondition", title: "LCD Status", width: "90px"},
                                                        {field: "date", title: "Created", width: "50px"}
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
                                            JSONToCSVConvertor(json_data, "Checkin Lcd Report", true);

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
                                            var fileName = "checkin_lcd_report_report_";
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

                                    <div style="margin-top:10px; margin-left: 10px;" class="table-overflow">

                                        <table class="table table-striped" style="width:250px;">
                                            <tbody>
                                                <tr>
                                                    <td colspan="2"> <strong>LCD Report Showing <span id="a0"></span></strong> </td>
                                                </tr>
                                                <tr>
                                                    <td>1. Total Good LCD </td>
                                                    <td id="a1"><?php //echo $a;   ?></td>
                                                </tr>
                                                <tr>
                                                    <td>2. Total Bad LCD  </td>
                                                    <td id="a2"><?php //echo $b;   ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>


                                <!-- Default datatable -->
                                <?php /*  <div class="table-overflow">
                                  <table class="table table-striped" id="data-table">
                                  <thead>
                                  <tr>
                                  <th>#</th>
                                  <th>Checkin ID</th>
                                  <?php if ($input_status == 1 || $input_status == 5) { ?>
                                  <th>Store Name</th>
                                  <?php } ?>
                                  <th>Check IN Detail</th>
                                  <th>Lcd Status</th>
                                  <th>Date</th>
                                  </tr>
                                  </thead>
                                  <tbody>
                                  <?php
                                  $i = 1;
                                  $a = 0;
                                  $b = 0;
                                  $c = 0;
                                  $d = 0;
                                  if (!empty($sqlticket))
                                  foreach ($sqlticket as $ticket):

                                  $chkcheckin = $obj->exists_multiple("invoice", array("doc_type" => 3, "checkin_id" => $ticket->checkin_id));
                                  $getsales_id = $obj->SelectAllByVal("invoice", "checkin_id", $ticket->checkin_id, "invoice_id");
                                  $curcheck = $obj->exists_multiple("sales", array("sales_id" => $getsales_id));
                                  if ($curcheck != 0) {
                                  if ($ticket->lcdstatus == 1) {
                                  $a+=1;
                                  } elseif ($ticket->lcdstatus == 2) {
                                  $b+=1;
                                  }
                                  ?>
                                  <tr>
                                  <td><?php echo $i; ?></td>
                                  <td><a href="view_checkin.php?ticket_id=<?php echo $ticket->checkin_id; ?>"><?php echo $ticket->checkin_id; ?></a></td>
                                  <?php if ($input_status == 1 || $input_status == 5) { ?>
                                  <td><?php echo $obj->SelectAllByVal("store", "store_id", $ticket->input_by, "name"); ?></td>
                                  <?php } ?>
                                  <td><?php echo $ticket->device . " " . $ticket->model . " " . $ticket->color . " " . $ticket->network . " " . $ticket->problem; ?></td>
                                  <td><?php echo Lcd($ticket->lcdstatus); ?></td>
                                  <!--<td>$<?php /* $chkx = $obj->exists_multiple("check_user_price", array("ckeckin_id" => $ticket->checkin_id));
                                  if ($chkx == 0) {
                                  $estp = $obj->SelectAllByVal("product", "name", $ticket->device . "-" . $ticket->problem, "price_cost");
                                  if ($estp == '') {
                                  $devid = $obj->SelectAllByVal("checkin_request", "checkin_id", $ticket->checkin_id, "device_id");
                                  $modid = $obj->SelectAllByVal("checkin_request", "checkin_id", $ticket->checkin_id, "model_id");
                                  $probid = $obj->SelectAllByVal("checkin_request", "checkin_id", $ticket->checkin_id, "problem_id");
                                  $pp = $obj->SelectAllByVal3("checkin_price", "checkin_id", $devid, "checkin_version_id", $modid, "checkin_problem_id", $probid,"name");
                                  } else {
                                  $pp = $estp;
                                  }
                                  } else {

                                  $estp = $obj->SelectAllByVal("check_user_price", "ckeckin_id", $ticket->checkin_id, "price");
                                  if ($estp == '') {
                                  $devid = $obj->SelectAllByVal("checkin_request", "checkin_id", $ticket->checkin_id, "device_id");
                                  $modid = $obj->SelectAllByVal("checkin_request", "checkin_id", $ticket->checkin_id, "model_id");
                                  $probid = $obj->SelectAllByVal("checkin_request", "checkin_id", $ticket->checkin_id, "problem_id");
                                  $pp = $obj->SelectAllByVal3("checkin_price", "checkin_id", $devid, "checkin_version_id", $modid, "checkin_problem_id", $probid, "name");
                                  } else {
                                  $pp = $estp;
                                  }
                                  }
                                  $pid = $obj->SelectAllByVal("product", "name", $ticket->device . ", " . $ticket->model . " - " . $ticket->problem, "id");
                                  $cid=$obj->SelectAllByVal2("coustomer","firstname",$obj->SelectAllByVal("checkin_request","checkin_id",$ticket->checkin_id,"first_name"),"phone",$obj->SelectAllByVal("checkin_request","checkin_id",$ticket->checkin_id,"phone"),"id");
                                  $ourcost=$obj->SelectAllByVal("product_report", "name", $ticket->device . ", " . $ticket->model . " - " . $ticket->problem, "ourcost");
                                  $b+=$ourcost;
                                  echo $ourcost;
                                  ?></td>

                                  <td>$<?php
                                  if($pp=='')
                                  {
                                  $retailcost=$obj->SelectAllByVal("product_report", "name", $ticket->device . ", " . $ticket->model . " - " . $ticket->problem, "retailcost");
                                  }
                                  else
                                  {
                                  $retailcost=$pp;
                                  }

                                  echo $retailcost;
                                  $c+=$retailcost;
                                  $profit=$retailcost-$ourcost;
                                  $d+=$profit;
                                  ?></a></td>
                                  <td>$<?php echo $profit;  ?></td>-->
                                  <td><?php echo $ticket->date; ?></td>


                                  </tr>
                                  <?php
                                  $i++;
                                  }
                                  endforeach;
                                  ?>
                                  </tbody>
                                  </table>
                                  </div> */ ?>
                                <!-- /default datatable -->
                                <!-- Default datatable -->

                                <!-- /default datatable -->
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


                                <div class="table-overflow" style="margin-top:10px;">
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    <div id="grid1" style="margin-left: 10px;margin-right: 10px;"></div>
                                            <script id="action_templates" type="text/x-kendo-template">
                                                <a class="k-button k-button-icontext k-grid-delete" onclick="javascript:deleteClick(#=id#);" ><span class="k-icon k-delete"></span> Delete</a>
                                            </script>
                                            <script type="text/javascript">
                                                jQuery(document).ready(function () {
                                                    var dataSource = new kendo.data.DataSource({
                                                        transport: {
                                                            read: {
                                                                url: "./controller/access_log.php",
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
                                                                    Details: {type: "string"},
                                                                    store_name: {type: "string"},
                                                                    datetime: {type: "string"},
                                                                    date: {type: "string"}
                                                                }
                                                            }
                                                        },
                                                        pageSize: 10,
                                                        serverPaging: true,
                                                        serverFiltering: true,
                                                        serverSorting: true
                                                    });
                                                    jQuery("#grid1").kendoGrid({
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
                                                            {field: "id", title: "#", width: "40px", filterable: false},
                                                            {field: "Details", title: "Details ", width: "100px"},
                                                            {field: "store_name", title: "Store Name ", width: "100px"},
                                                            {field: "datetime", title: "Date Time ", width: "70px", filterable: false},
                                                            {field: "date", title: "Created ", width: "70px", filterable: false},
                                                            {
                                                                title: "Action", width: "70px",
                                                                template: kendo.template($("#action_templates").html())
                                                            }
                                                        ],
                                                    });
                                                });

                                            </script>
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    <?php /*<table class="table table-striped" id="data-table">
                                        <thead>
                                            <tr>
                                                <th  <?php if ($input_status == 1 || $input_status == 5) { ?>
                                                        colspan="6"
                                                    <?php } else { ?>colspan="5"<?php } ?> ><h4>Delete Log History</h4></th>
                                        </tr>
                                        <tr>
                                            <th>#</th>
                                            <th>Detail</th>
                                            <?php if ($input_status == 1 || $input_status == 5) { ?>
                                                <th>Store Name</th>
                                            <?php } ?>
                                            <th>Date Time</th>
                                            <th>Date</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($input_status == 1) {
                                                $sqlaccesslog = $obj->SelectAllByID("access_log", array("status" => 9));
                                            } else {
                                                $sqlaccesslog = $obj->SelectAllByID_Multiple("access_log", array("status" => 9, "store_id" => $input_by));
                                            }
                                            $i = 1;
                                            if (!empty($sqlaccesslog))
                                                foreach ($sqlaccesslog as $accesslog):
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $i; ?></td>
                                                        <td><?php echo $accesslog->name; ?></td>
                                                        <?php if ($input_status == 1 || $input_status == 5) { ?>
                                                            <td><?php echo $obj->SelectAllByVal("store", "store_id", $accesslog->store_id, "name"); ?></td>
                                                        <?php } ?>
                                                        <td><?php echo $accesslog->datetime; ?></td>
                                                        <td><?php echo $accesslog->date; ?></td>
                                                        <td><a href="<?php echo $obj->filename(); ?>?logdel=<?php echo $accesslog->id; ?>"><i class="icon-trash"></i></a></td>
                                                    </tr>
                                                    <?php
                                                    $i++;
                                                endforeach;
                                            ?>
                                        </tbody>
                                    </table> */?>
                                </div>
                                <!-- /default datatable -->


                                <!-- Content End from here customized -->




                                <div class="separator-doubled"></div>




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
            <?php //include('include/sidebar_right.php');    ?>
            <!-- /right sidebar -->

        </div>
        <!-- /main wrapper -->

    </body>
</html>
