<?php
include('class/auth.php');
include('class/report_customer.php');
$report = new report();
$table = "coustomer";
if (@$_GET['export'] == "excel") {
    if ($input_status == 1) {
        if (isset($_GET['from'])) {
            $from = $_GET['from'];
            $to = $_GET['to'];
            $sql_parts_order = $report->SelectAllDate("unlock_request", $from, $to, "1");
            $record = $report->SelectAllDate("unlock_request", $from, $to, "2");
            $record_label = "Total record Found ( " . $record . " ). | Report Generate Between " . $from . " - " . $to;
        } else {
            $sql_parts_order = $obj->SelectAll("unlock_request");
            $record = $obj->totalrows("unlock_request");
            $record_label = "Total Record Found ( " . $record . " )";
        }
    } else {
        if (isset($_GET['from'])) {
            $from = $_GET['from'];
            $to = $_GET['to'];
            $sql_parts_order = $report->SelectAllDate_Store("unlock_request", $from, $to, "1", "uid", $input_by);
            $record = $report->SelectAllDate_Store("unlock_request", $from, $to, "2", "uid", $input_by);
            $record_label = "Total record Found ( " . $record . " ). | Report Generate Between " . $from . " - " . $to;
        } else {
            $sql_parts_order = $obj->SelectAllByID("unlock_request", array("uid" => $input_by));
            $record = $obj->exists_multiple("unlock_request", array("uid" => $input_by));
            $record_label = "Total Record Found ( " . $record . " )";
        }
    }

    header('Content-type: application/excel');
    $filename = "Unlock_Request_Order_Report_list_" . date('Y_m_d') . '.xls';
    header('Content-Disposition: attachment; filename=' . $filename);

    $data = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">
<head>
    <!--[if gte mso 9]>
    <xml>
        <x:ExcelWorkbook>
            <x:ExcelWorksheets>
                <x:ExcelWorksheet>
                    <x:Name>Unlock Request Order Report List : Wireless Geeks Inc.</x:Name>
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
    $data .="<h5>Unlock Request Order Report List Generate Date : " . date('d-m-Y H:i:s') . "</h5>";

    $data .="<table>
    <thead>
        <tr style='background:#09f; color:#fff;'>
			<th>#</th>
			<th>Unlock ID</th>
			<th>Our Cost</th>
			<th>Retail Cost</th>
			<th>Profit</th>
			<th>Service</th>
			<th>Created</th>
			<th>Status</th>
			<th>Submit</th>
		</tr>
</thead>        
<tbody>";

    $i = 1;
    $our_cost = 0;
    $retail_cost = 0;
    $profit = 0;
    $tqq = 0;
    if (!empty($sql_parts_order))
        foreach ($sql_parts_order as $ticket):

            $chkcheckin = $obj->exists_multiple("invoice", array("doc_type" => 3, "unlock_id" => $ticket->unlock_id));
            $getsales_id = $obj->SelectAllByVal("invoice", "unlock_id", $ticket->unlock_id, "invoice_id");
            $curcheck = $obj->exists_multiple("sales", array("sales_id" => $getsales_id));
            if ($curcheck != 0)
                $tqq+=1;
            $a = $ticket->our_cost;
            $b = $ticket->retail_cost;
            $c = $b - $a;
            $our_cost+=$a;
            $retail_cost+=$b;
            $profit+=$c;

            $data.="<tr>
				<td>" . $i . "</td>
				<td>" . $ticket->unlock_id . "</td>
				<td>" . $ticket->our_cost . "</td>
				<td>" . $ticket->retail_cost . "</td>
				<td>" . $c . "</td>
				<td>" . $obj->SelectAllByVal("unlock_service", "id", $ticket->service_id, "name") . "</td>
				<td>" . $ticket->date . "</td>
				<td>" . $obj->ticket_status($ticket->status) . "</td>
				<td>" . $obj->duration($ticket->date, date('Y-m-d')) . "</td>
			</tr>";

            $i++;
        endforeach;

    $data .="</tbody><tfoot><tr>
			<th>#</th>
			<th>Unlock ID</th>
			<th>Our Cost</th>
			<th>Retail Cost</th>
			<th>Profit</th>
			<th>Service</th>
			<th>Created</th>
			<th>Status</th>
			<th>Submit</th>
		</tr></tfoot></table>";



    $data .='</body></html>';

    echo $data;
}

if (@$_GET['export'] == "pdf") {
    if ($input_status == 1) {
        if (isset($_GET['from'])) {
            $from = $_GET['from'];
            $to = $_GET['to'];
            $sql_parts_order = $report->SelectAllDate("unlock_request", $from, $to, "1");
            $record = $report->SelectAllDate("unlock_request", $from, $to, "2");
            $record_label = "Total record Found ( " . $record . " ). | Report Generate Between " . $from . " - " . $to;
        } else {
            $sql_parts_order = $obj->SelectAll("unlock_request");
            $record = $obj->totalrows("unlock_request");
            $record_label = "Total Record Found ( " . $record . " )";
        }
    } else {
        if (isset($_GET['from'])) {
            $from = $_GET['from'];
            $to = $_GET['to'];
            $sql_parts_order = $report->SelectAllDate_Store("unlock_request", $from, $to, "1", "uid", $input_by);
            $record = $report->SelectAllDate_Store("unlock_request", $from, $to, "2", "uid", $input_by);
            $record_label = "Total record Found ( " . $record . " ). | Report Generate Between " . $from . " - " . $to;
        } else {
            $sql_parts_order = $obj->SelectAllByID("unlock_request", array("uid" => $input_by));
            $record = $obj->exists_multiple("unlock_request", array("uid" => $input_by));
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
						Unlock Request Order Report List Report
						</td>
					</tr>
				</table>
				
				
				<table style='width:100%; height:40px; border:0px; font-size:18px;'>
					<tr>
						<td>Unlock Request Order Report List Generate Date : " . date('d-m-Y H:i:s') . "</td>
					</tr>
				</table>
				<table style='width:960px;border:1px; font-size:12px; background:#ccc;'>";
    $html.="<thead>

        <tr style='background:#09f; color:#fff;'>
		<th>#</th>
		<th>Unlock ID</th>
		<th>Our Cost</th>
		<th>Retail Cost</th>
		<th>Profit</th>
		<th>Service</th>
		<th>Created</th>
		<th>Status</th>
		<th>Submit</th>
		</tr>
</thead>        
<tbody>";


    $i = 1;
    $our_cost = 0;
    $retail_cost = 0;
    $profit = 0;
    $tqq = 0;
    if (!empty($sql_parts_order))
        foreach ($sql_parts_order as $ticket):

            $chkcheckin = $obj->exists_multiple("invoice", array("doc_type" => 3, "unlock_id" => $ticket->unlock_id));
            $getsales_id = $obj->SelectAllByVal("invoice", "unlock_id", $ticket->unlock_id, "invoice_id");
            $curcheck = $obj->exists_multiple("sales", array("sales_id" => $getsales_id));
            if ($curcheck != 0)
                $tqq+=1;
            $a = $ticket->our_cost;
            $b = $ticket->retail_cost;
            $c = $b - $a;
            $our_cost+=$a;
            $retail_cost+=$b;
            $profit+=$c;

            $html.="<tr>
				<td>" . $i . "</td>
				<td>" . $ticket->unlock_id . "</td>
				<td>" . $ticket->our_cost . "</td>
				<td>" . $ticket->retail_cost . "</td>
				<td>" . $c . "</td>
				<td>" . $obj->SelectAllByVal("unlock_service", "id", $ticket->service_id, "name") . "</td>
				<td>" . $ticket->date . "</td>
				<td>" . $obj->ticket_status($ticket->status) . "</td>
				<td>" . $obj->duration($ticket->date, date('Y-m-d')) . "</td>
			</tr>";

            $i++;
        endforeach;

    $html.="</tbody><tfoot><tr>
		<th>#</th>
		<th>Unlock ID</th>
		<th>Our Cost</th>
		<th>Retail Cost</th>
		<th>Profit</th>
		<th>Service</th>
		<th>Created</th>
		<th>Status</th>
		<th>Submit</th>
		</tr></tfoot></table>";


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
                            if ($input_status == 1) {
                                if (isset($_GET['from'])) {
                                    $from = $_GET['from'];
                                    $to = $_GET['to'];
                                    $sql_parts_order = $report->SelectAllDate("unlock_request", $from, $to, "1");
                                    $record = $report->SelectAllDate("unlock_request", $from, $to, "2");
                                    $record_label = "Total record Found ( " . $record . " ). | Report Generate Between " . $from . " - " . $to;
                                } else {
                                    $sql_parts_order = $obj->SelectAll("unlock_request");
                                    $record = $obj->totalrows("unlock_request");
                                    $record_label = "Total Record Found ( " . $record . " )";
                                }
                            } elseif ($input_status == 5) {
                                $sqlchain_store_ids = $obj->SelectAllByID("store_chain_admin", array("sid" => $input_by));
                                if (!empty($sqlchain_store_ids)) {
                                    $array_ch = array();
                                    foreach ($sqlchain_store_ids as $ch):
                                        array_push($array_ch, $ch->store_id);
                                    endforeach;

                                    include('class/report_chain_admin.php');
                                    $obj_report_chain = new chain_report();

                                    if (isset($_GET['from'])) {
                                        $from = $_GET['from'];
                                        $to = $_GET['to'];
                                        $sqlticket = $obj_report_chain->SelectAllByID_Multiple_Or("unlock_request", $array_ch, "uid", "1");
                                        $record = $obj_report_chain->SelectAllByID_Multiple_Or("unlock_request", $array_ch, "uid", "2");
                                        $record_label = "| Report Generate Between " . $from . " - " . $to;
                                    } else {
                                        $sqlticket = $obj_report_chain->SelectAllByID_Multiple2_Or("unlock_request", array("date" => date('Y-m-d')), $array_ch, "uid", "1");
                                        $record = $obj_report_chain->SelectAllByID_Multiple2_Or("unlock_request", array("date" => date('Y-m-d')), $array_ch, "uid", "2");
                                        $record_label = "Total Record ( " . $record . " )";
                                    }
                                } else {
                                    //echo "Not Work";
                                    $sqlticket = "";
                                    $record = 0;
                                    $record_label = "Total Record ( " . $record . " )";
                                }
                            } else {
                                if (isset($_GET['from'])) {
                                    $from = $_GET['from'];
                                    $to = $_GET['to'];
                                    $sql_parts_order = $report->SelectAllDate_Store("unlock_request", $from, $to, "1", "uid", $input_by);
                                    $record = $report->SelectAllDate_Store("unlock_request", $from, $to, "2", "uid", $input_by);
                                    $record_label = "Total record Found ( " . $record . " ). | Report Generate Between " . $from . " - " . $to;
                                } else {
                                    $sql_parts_order = $obj->SelectAllByID("unlock_request", array("uid" => $input_by));
                                    $record = $obj->exists_multiple("unlock_request", array("uid" => $input_by));
                                    $record_label = "Total Record Found ( " . $record . " )";
                                }
                            }
                            ?>
                            <h5><i class="font-money"></i> Unlock Request Report List | <?php echo $record_label; ?> | <a  data-toggle="modal" href="#myModal"> Search Datewise </a></h5>
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
                                            <h5 id="myModalLabel"><i class="font-calendar"></i> Generate Unlock Report <span id="mss"></span></h5>
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
                                                            url: "./controller/unlock_report.php",
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
                                                                unlock_id: {type: "string"},
                                                                our_cost: {type: "string"},
                                                                retail_cost: {type: "string"},
                                                                profit: {type: "string"},
                                                                service: {type: "string"},
                                                                date: {type: "string"},
                                                                status: {type: "string"},
                                                                submit: {type: "string"}
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
                                                        {field: "unlock_id", title: "Unlock ID ", width: "100px"},
                                                        {field: "our_cost", title: "Our Cost ", width: "70px", filterable: false},
                                                        {field: "retail_cost", title: "Retail Cost ", width: "70px", filterable: false},
                                                        {field: "profit", title: "Profit ", width: "80px", filterable: false},
                                                        {field: "service", title: "Service ", width: "230px"},
                                                        {field: "date", title: "Date ", width: "100px"},
                                                        {field: "status", title: "Status ", width: "100px", filterable: false},
                                                        {field: "submit", title: "Submit ", width: "80px", filterable: false}
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
                                            JSONToCSVConvertor(json_data, "Unlock Report", true);

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
                                            var fileName = "unlock_report_";
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

                                        <?php /* <table class="table table-striped">
                                          <thead>
                                          <tr>
                                          <th>#</th>
                                          <th>Unlock ID</th>
                                          <th>Our Cost</th>
                                          <th>Retail Cost</th>
                                          <th>Profit</th>
                                          <th>Service</th>
                                          <th>Created</th>
                                          <th>Status</th>
                                          <th>Submit</th>
                                          </tr>
                                          </thead>
                                          <tbody>
                                          <?php
                                          $i = 1;
                                          $our_cost = 0;
                                          $retail_cost = 0;
                                          $profit = 0;
                                          $tqq = 0;
                                          if (!empty($sql_parts_order))
                                          foreach ($sql_parts_order as $ticket):

                                          $chkcheckin = $obj->exists_multiple("invoice", array("doc_type" => 3, "unlock_id" => $ticket->unlock_id));
                                          $getsales_id = $obj->SelectAllByVal("invoice", "unlock_id", $ticket->unlock_id, "invoice_id");
                                          $curcheck = $obj->exists_multiple("sales", array("sales_id" => $getsales_id));
                                          if ($curcheck != 0) {
                                          $tqq+=1;
                                          $a = $ticket->our_cost;
                                          $b = $ticket->retail_cost;
                                          $c = $b - $a;
                                          $our_cost+=$a;
                                          $retail_cost+=$b;
                                          $profit+=$c;
                                          ?>
                                          <tr>
                                          <td><?php echo $i; ?></td>
                                          <td><a class="label label-success" href="view_unlock.php?unlock_id=<?php echo $ticket->unlock_id; ?>"><i class="icon-tags"></i> <?php echo $ticket->unlock_id; ?></a></td>
                                          <!--<td><i class="icon-user"></i> <?php //echo $obj->SelectAllByVal("coustomer","id",$ticket->cid,"firstname")." ".$obj->SelectAllByVal("coustomer","id",$ticket->cid,"lastname");     ?></td>-->
                                          <td>$<?php echo $ticket->our_cost; ?></td>
                                          <td>$<?php echo $ticket->retail_cost; ?></td>
                                          <td>$<?php echo $c; ?></td>
                                          <td><?php echo $obj->SelectAllByVal("unlock_service", "id", $ticket->service_id, "name"); ?></td>
                                          <td><i class="icon-calendar"></i> <?php echo $ticket->date; ?></td>

                                          <td><?php echo $obj->ticket_status($ticket->status); ?></td>
                                          <td><label class="label label-info"><i class="icon-calendar"></i> <?php echo $obj->duration($ticket->date, date('Y-m-d')); ?></label></td>

                                          </tr>
                                          <?php
                                          $i++;
                                          }
                                          endforeach;
                                          ?>
                                          </tbody>
                                          </table> */ ?>
                                    </div>
                                    <div class="table-overflow">
                                        <table style="width:300px; float:left; margin-top:10px;" class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th colspan="3">Unlock Short Report</th>
                                                </tr>
                                                <tr>
                                                    <th>1</th>
                                                    <th>Quantity</th>
                                                    <th><?php echo $tqq; ?></th>
                                                </tr>
                                                <tr>
                                                    <th>2</th>
                                                    <th>Our Total Cost</th>
                                                    <th>$<?php echo $our_cost; ?></th>
                                                </tr>
                                                <tr>
                                                    <th>3</th>
                                                    <th>Retail Total Cost</th>
                                                    <th>$<?php echo $retail_cost; ?></th>
                                                </tr>
                                                <tr>
                                                    <th>4</th>
                                                    <th>Profit Total</th>
                                                    <th>$<?php echo $profit; ?></th>
                                                </tr>
                                            </thead>

                                        </table>
                                    </div>



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
            <?php //include('include/sidebar_right.php');  ?>
            <!-- /right sidebar -->

        </div>
        <!-- /main wrapper -->

    </body>
</html>
