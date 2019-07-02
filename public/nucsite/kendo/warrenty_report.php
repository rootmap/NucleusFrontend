<?php
include('class/auth.php');
include('class/report_customer.php');
$report = new report();
$table = "coustomer";
if (isset($_GET['del'])) {
    $obj->deletesing("id", $_GET['del'], "sales");
}
if (@$_GET['export'] == "excel") {
    if ($input_status == 1) {
        if (isset($_GET['from'])) {
            $from = $_GET['from'];
            $to = $_GET['to'];
            $sqlinvoice = $report->SelectAllDate("warrenty", $from, $to, "1");
            $record = $report->SelectAllDate("warrenty", $from, $to, "2");
            $record_label = "Total record Found ( " . $record . " ). | Report Generate Between " . $from . " - " . $to;
        } else {
            $sqlinvoice = $obj->SelectAll("warrenty");
            $record = $obj->totalrows("warrenty");
            $record_label = "Total Record Found ( " . $record . " )";
        }
    } else {
        if (isset($_GET['from'])) {
            $from = $_GET['from'];
            $to = $_GET['to'];
            $sqlinvoice = $report->SelectAllDate_Store("warrenty", $from, $to, "1", "uid", $input_by);
            $record = $report->SelectAllDate_Store("warrenty", $from, $to, "2", "uid", $input_by);
            $record_label = "Total record Found ( " . $record . " ). | Report Generate Between " . $from . " - " . $to;
        } else {
            $sqlinvoice = $obj->SelectAllByID("warrenty", array("uid" => $input_by));
            $record = $obj->exists_multiple("warrenty", array("uid" => $input_by));
            $record_label = "Total Record Found ( " . $record . " )";
        }
    }


    header('Content-type: application/excel');
    $filename = "Warrenty_Report_list_" . date('Y_m_d') . '.xls';
    header('Content-Disposition: attachment; filename=' . $filename);

    $data = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">
<head>
    <!--[if gte mso 9]>
    <xml>
        <x:ExcelWorkbook>
            <x:ExcelWorksheets>
                <x:ExcelWorksheet>
                    <x:Name>Warrenty Report List : Wireless Geeks Inc.</x:Name>
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
    $data .="<h5>Warrenty Report List Generate Date : " . date('d-m-Y H:i:s') . "</h5>";

    $data .="<table>
    <thead>
        <tr style='background:#09f; color:#fff;'>
		<th>#</th>
		<th>Warranty-ID</th>
		<th>Service</th>
		<th>Warrenty </th>
		<th>W.Left </th>
		<th>Date</th>
		<th>Retail Cost</th>
		<th>Reason for Warranty</th>
		</tr>
</thead>
<tbody>";

    $i = 1;
    $a = 0;
    $bb = 0;
    if (!empty($sqlinvoice))
        foreach ($sqlinvoice as $invoice):
            $a+=$i;
            $daysgone2 = $obj->daysgone($invoice->date, date('Y-m-d'));
            //echo $wd." Days";
            $have2 = $invoice->warrenty - $daysgone2;

            if ($invoice->type == "ticket") {
                $ourcost = $obj->SelectAllByVal("ticket_list", "ticket_id", $invoice->warrenty_id, "our_cost");
                $bb+=$ourcost = $obj->SelectAllByVal("ticket_list", "ticket_id", $invoice->warrenty_id, "our_cost");
            }

            if ($invoice->type == "checkin") {
                $ourcost = $obj->SelectAllByVal("checkin_list", "checkin_id", $invoice->warrenty_id, "retail_cost");
                $bb+=$ourcost = $obj->SelectAllByVal("checkin_list", "checkin_id", $invoice->warrenty_id, "retail_cost");
            }

            $data.="<tr>
				<td>" . $i . "</td>
				<td>" . $invoice->warrenty_id . "</td>
				<td>" . $invoice->type . "</td>
				<td>" . $invoice->warrenty . " Days</td>
				<td>" . $have2 . " Days</td>
				<td>" . $invoice->date . "</td>
				<td>" . $ourcost . "</td>
				<td>" . $invoice->note . "</td>
				<td>" . $ticket->date . "</td>
			</tr>";

            $i++;
        endforeach;

    $data .="</tbody><tfoot><tr>
		<th>#</th>
		<th>Warranty-ID</th>
		<th>Service</th>
		<th>Warrenty </th>
		<th>W.Left </th>
		<th>Date</th>
		<th>Retail Cost</th>
		<th>Reason for Warranty</th>
		</tr></tfoot></table>";

    $data.="<table border='0' width='250' style='width:200px;'>
					<tbody>
						<tr>
							<td>1. Total Quantity = <strong> " . $record . "</strong></td>
						</tr>
						<tr>
							<td>2. Our Total Cost = <strong> $" . number_format($bb, 2) . "</strong></td>
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
            $sqlinvoice = $report->SelectAllDate("warrenty", $from, $to, "1");
            $record = $report->SelectAllDate("warrenty", $from, $to, "2");
            $record_label = "Total record Found ( " . $record . " ). | Report Generate Between " . $from . " - " . $to;
        } else {
            $sqlinvoice = $obj->SelectAll("warrenty");
            $record = $obj->totalrows("warrenty");
            $record_label = "Total Record Found ( " . $record . " )";
        }
    } else {
        if (isset($_GET['from'])) {
            $from = $_GET['from'];
            $to = $_GET['to'];
            $sqlinvoice = $report->SelectAllDate_Store("warrenty", $from, $to, "1", "uid", $input_by);
            $record = $report->SelectAllDate_Store("warrenty", $from, $to, "2", "uid", $input_by);
            $record_label = "Total record Found ( " . $record . " ). | Report Generate Between " . $from . " - " . $to;
        } else {
            $sqlinvoice = $obj->SelectAllByID("warrenty", array("uid" => $input_by));
            $record = $obj->exists_multiple("warrenty", array("uid" => $input_by));
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
						Warrenty Report List Report
						</td>
					</tr>
				</table>


				<table style='width:100%; height:40px; border:0px; font-size:18px;'>
					<tr>
						<td>Warrenty Report List Generate Date : " . date('d-m-Y H:i:s') . "</td>
					</tr>
				</table>
				<table style='width:960px;border:1px; font-size:12px; background:#ccc;'>";
    $html.="<thead>

        <tr style='background:#09f; color:#fff;'>
		<th>#</th>
		<th>Warranty-ID</th>
		<th>Service</th>
		<th>Warrenty </th>
		<th>W.Left </th>
		<th>Date</th>
		<th>Retail Cost</th>
		<th>Reason for Warranty</th>
		</tr>
</thead>
<tbody>";


    $i = 1;
    $a = 0;
    $bb = 0;
    if (!empty($sqlinvoice))
        foreach ($sqlinvoice as $invoice):
            $a+=$i;
            $daysgone2 = $obj->daysgone($invoice->date, date('Y-m-d'));
            //echo $wd." Days";
            $have2 = $invoice->warrenty - $daysgone2;

            if ($invoice->type == "ticket") {
                $ourcost = $obj->SelectAllByVal("ticket_list", "ticket_id", $invoice->warrenty_id, "our_cost");
                $bb+=$ourcost = $obj->SelectAllByVal("ticket_list", "ticket_id", $invoice->warrenty_id, "our_cost");
            }

            if ($invoice->type == "checkin") {
                $ourcost = $obj->SelectAllByVal("checkin_list", "checkin_id", $invoice->warrenty_id, "retail_cost");
                $bb+=$ourcost = $obj->SelectAllByVal("checkin_list", "checkin_id", $invoice->warrenty_id, "retail_cost");
            }

            $html.="<tr>
				<td>" . $i . "</td>
				<td>" . $invoice->warrenty_id . "</td>
				<td>" . $invoice->type . "</td>
				<td>" . $invoice->warrenty . " Days</td>
				<td>" . $have2 . " Days</td>
				<td>" . $invoice->date . "</td>
				<td>" . $ourcost . "</td>
				<td>" . $invoice->note . "</td>
				<td>" . $ticket->date . "</td>
			</tr>";

            $i++;
        endforeach;

    $html.="</tbody><tfoot><tr>
		<th>#</th>
		<th>Warranty-ID</th>
		<th>Service</th>
		<th>Warrenty </th>
		<th>W.Left </th>
		<th>Date</th>
		<th>Retail Cost</th>
		<th>Reason for Warranty</th>
		</tr></tfoot></table>";

    $html.="<table border='0'  width='250' style='width:200px;'>
					<tbody>
						<tr>
							<td>1. Total Quantity = <strong> " . $record . "</strong></td>
						</tr>
						<tr>
							<td>2. Our Total Cost = <strong> $" . number_format($bb, 2) . "</strong></td>
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
                        <div class="page-header">
                            <!-- Page header -->
                            <?php
                            echo $obj->ShowMsg();
//                            if ($input_status == 1) {
//                                if (isset($_GET['from'])) {
//                                    $from = $_GET['from'];
//                                    $to = $_GET['to'];
//                                    $sqlinvoice = $report->SelectAllDate("warrenty", $from, $to, "1");
//                                    $record = $report->SelectAllDate("warrenty", $from, $to, "2");
//                                    $record_label = "Total record Found ( " . $record . " ). | Report Generate Between " . $from . " - " . $to;
//                                } else {
//                                    $sqlinvoice = $obj->SelectAllByID("warrenty", array("date" => date('Y-m-d')));
//                                    $record = $obj->exists_multiple("warrenty", array("date" => date('Y-m-d')));
//                                    $record_label = "Total Record Found ( " . $record . " )";
//                                }
//                            } elseif ($input_status == 5) {
//                                $sqlchain_store_ids = $obj->SelectAllByID("store_chain_admin", array("sid" => $input_by));
//                                if (!empty($sqlchain_store_ids)) {
//                                    $array_ch = array();
//                                    foreach ($sqlchain_store_ids as $ch):
//                                        array_push($array_ch, $ch->store_id);
//                                    endforeach;
//
//                                    if (isset($_GET['from'])) {
//                                        include('class/report_chain_admin.php');
//                                        $obj_report_chain = new chain_report();
//                                        $sqlinvoice = $obj_report_chain->ReportQuery_Datewise_Or("warrenty", $array_ch, "uid", $_GET['from'], $_GET['to'], "1");
//                                        $record = $obj_report_chain->ReportQuery_Datewise_Or("warrenty", $array_ch, "uid", $_GET['from'], $_GET['to'], "2");
//                                        $record_label = "Total record Found ( " . $record . " ). | Report Generate Between " . $from . " - " . $to;
//                                    } else {
//                                        include('class/report_chain_admin.php');
//                                        $obj_report_chain = new chain_report();
//                                        $sqlinvoice = $obj_report_chain->SelectAllByID_Multiple2_Or("warrenty", array("date" => date('Y-m-d')), $array_ch, "uid", "1");
//                                        $record = $obj_report_chain->SelectAllByID_Multiple2_Or("warrenty", array("date" => date('Y-m-d')), $array_ch, "uid", "2");
//                                        $record_label = "Total record Found ( " . $record . " ).";
//                                    }
//                                    //echo "Work";
//                                } else {
//                                    //echo "Not Work";
//                                    $sqlinvoice = "";
//                                    $record = 0;
//                                    $record_label = "Total record Found ( " . $record . " ).";
//                                }
//                            } else {
//                                if (isset($_GET['from'])) {
//                                    $from = $_GET['from'];
//                                    $to = $_GET['to'];
//                                    $sqlinvoice = $report->SelectAllDate_Store("warrenty", $from, $to, "1", "uid", $input_by);
//                                    $record = $report->SelectAllDate_Store("warrenty", $from, $to, "2", "uid", $input_by);
//                                    $record_label = "Total record Found ( " . $record . " ). | Report Generate Between " . $from . " - " . $to;
//                                } else {
//                                    $sqlinvoice = $obj->SelectAllByID_Multiple("warrenty", array("uid" => $input_by, "date" => date('Y-m-d')));
//                                    $record = $obj->exists_multiple("warrenty", array("uid" => $input_by, "date" => date('Y-m-d')));
//                                    $record_label = "Total Record Found ( " . $record . " )";
//                                }
//                            }
                            ?>
                            <h5><i class="font-money"></i> Warranty Report | <a  data-toggle="modal" href="#myModal"> Search Datewise </a></h5>
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
                                            <h5 id="myModalLabel"><i class="font-calendar"></i> Generate Warrenty Report <span id="mss"></span></h5>
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

                                        <?php
                                        $cond = $cms->FrontEndDateSearch('from', 'to');
                                        ?>

                                        <script type="text/javascript">
                                            function deleteClick(id) {
                                                var c = confirm("Do you want to delete?");
                                                if (c === true) {
                                                    $.ajax({
                                                        type: "POST",
                                                        dataType: "json",
                                                        url: "./controller/warrenty_report.php",
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
                                                            url: "./controller/warrenty_report.php",
                                                            type: "GET",
                                                            datatype: "json",
                                                            complete: function (response) {
                                                                var page_quantity = 0;
                                                                var page_amount = 0;
                                                                jQuery.each(response, function (index, key) {
                                                                    if (index == 'responseJSON')
                                                                    {
                                                                        //console.log(key.data);
                                                                        jQuery.each(key.data, function (datagr, keyg) {
                                                                            page_quantity += (1 - 0);
                                                                            page_amount += (parseFloat(keyg.our_cost) - 0);


                                                                        });
                                                                        //console.log(page_ourcost);
                                                                        jQuery("#a1").html(page_quantity + "  of  " + key.total);
                                                                        jQuery("#a2").html(page_amount);


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
                                                                id: {type: "number"},
                                                                warrenty_id: {type: "number"},
                                                                name: {type: "string"},
                                                                type: {type: "string"},
                                                                our_cost: {type: "string"},
                                                                warrenty: {type: "string"},
                                                                w_left: {type: "string"},
                                                                note: {type: "string"},
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
                                                        {field: "id", title: "#", width: "40px", filterable: false},
                                                        {field: "warrenty_id", title: "Warranty-ID ", width: "80px"},
                                                        {field: "name", title: "Store Name ", width: "100px"},
                                                        {field: "type", title: "Service", width: "60px"},
                                                        {template: "<?php echo $currencyicon; ?>#=our_cost#", title: "Our Cost", width: "60px"},
                                                        {field: "warrenty", title: "Warrenty", width: "60px"},
                                                        {template: "#=w_left# Days", title: "W.Left", width: "60px"},
                                                        {field: "note", title: "Reason for Warranty", width: "120px"},
                                                        {field: "date", title: "Created", width: "70px"}
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
                                            JSONToCSVConvertor(json_data, "Warrenty Report", true);

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
                                            var fileName = "warrenty_report_";
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
                                          <th>Warranty-ID</th>
                                          <?php if ($input_status == 1 || $input_status == 5) { ?>
                                          <th>Store Name</th>
                                          <?php } ?>
                                          <th>Service</th>
                                          <th>Warrenty </th>
                                          <th>W.Left </th>
                                          <th>Date</th>
                                          <th>Retail Cost</th>
                                          <th>Reason for Warranty</th>
                                          <th width="80">Print</th>
                                          </tr>
                                          </thead>
                                          <tbody>
                                          <?php
                                          $i=1;
                                          $a=0;
                                          $bb=0;
                                          if (!empty($sqlinvoice))
                                          foreach ($sqlinvoice as $invoice):
                                          $a+=$i;
                                          ?>
                                          <tr>
                                          <td><?php echo $i; ?></td>
                                          <td>

                                          <?php
                                          if ($invoice->type == "ticket") {
                                          ?>
                                          <a href="view_ticket.php?ticket_id=<?php echo $invoice->warrenty_id; ?>"  target="_blank" onclick="javascript:return confirm('Are you absolutely sure to View This <?php echo $invoice->type; ?> ?')"  class="label label-important"> <?php echo $invoice->warrenty_id; ?></a>
                                          <?php }elseif ($invoice->type == "checkin") { ?>
                                          <a href="view_checkin.php?ticket_id=<?php echo $invoice->warrenty_id; ?>"  target="_blank" onclick="javascript:return confirm('Are you absolutely sure to View This <?php echo $invoice->type; ?> ?')"  class="label label-important"> <?php echo $invoice->warrenty_id; ?></a>
                                          <?php } ?>

                                          </td>
                                          <?php if ($input_status == 1 || $input_status == 5) { ?>
                                          <td><?php echo $obj->SelectAllByVal("store", "store_id", $invoice->uid, "name"); ?></td>
                                          <?php } ?>
                                          <td><label class="label label-success"> <?php echo $invoice->type; ?> </label></td>
                                          <td><label class="label label-warning"> <?php echo $invoice->warrenty; ?> Days </label></td>
                                          <td><label class="label label-warning"> <?php
                                          $daysgone2=$obj->daysgone($invoice->date, date('Y-m-d'));
                                          //echo $wd." Days";
                                          $have2=$invoice->warrenty - $daysgone2;
                                          echo $have2 . " Days";
                                          ?></label></td>


                                          <td><?php echo $invoice->date; ?></td>
                                          <td>$
                                          <?php
                                          if ($invoice->type == "ticket") {
                                          echo number_format($ourcost=$obj->SelectAllByVal("ticket_list", "ticket_id", $invoice->warrenty_id, "our_cost"), 2);
                                          $bb+=$ourcost=$obj->SelectAllByVal("ticket_list", "ticket_id", $invoice->warrenty_id, "our_cost");
                                          }

                                          if ($invoice->type == "checkin") {
                                          echo number_format($ourcost=$obj->SelectAllByVal("checkin_list", "checkin_id", $invoice->warrenty_id, "retail_cost"), 2);
                                          $bb+=$ourcost=$obj->SelectAllByVal("checkin_list", "checkin_id", $invoice->warrenty_id, "retail_cost");
                                          }
                                          ?>
                                          </td>
                                          <td><?php echo $invoice->note; ?></td>
                                          <td><a href="warrenty_print.php?warrenty_id=<?php echo $invoice->warrenty_id; ?>&print_invoice=yes"  target="_blank" onclick="javascript:return confirm('Are you absolutely sure to Print This Invoice ?')"  class="label label-important"><i class="icon-print"></i></a></td>
                                          </tr>
                                          <?php
                                          $i++;
                                          endforeach;
                                          ?>
                                          </tbody>
                                          </table> */ ?>
                                    </div>
                                    <!-- Table condensed -->
                                    <div class="block well span4" style="margin-left:10px; margin-top: 10px;">
                                        <div class="navbar">
                                            <div class="navbar-inner">
                                                <h5> Report</h5>
                                            </div>
                                        </div>
                                        <div class="table-overflow">
                                            <table class="table table-striped" style="width:250px;">
                                                <tbody>
                                                    <tr>
                                                        <td>1. Total Quantity = <strong id="a1"> <?php echo 0; ?></strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td>2. Total Price = <?php echo $currencyicon; ?><strong id="a2"> $<?php echo 0; ?></strong></td>

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
            <?php //include('include/footer.php'); ?>
            <!-- Right sidebar -->
            <?php //include('include/sidebar_right.php');  ?>
            <!-- /right sidebar -->

        </div>
        <!-- /main wrapper -->

    </body>
</html>
