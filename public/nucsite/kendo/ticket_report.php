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
            $sql_parts_order = $report->SelectAllDate("ticket_list", $from, $to, "1");
            $record = $report->SelectAllDate("ticket_list", $from, $to, "2");
            $record_label = "Total record Found ( " . $record . " ). | Report Generate Between " . $from . " - " . $to;
        } else {
            $sql_parts_order = $obj->SelectAll("ticket_list");
            $record = $obj->totalrows("ticket_list");
            $record_label = "Total Record Found ( " . $record . " )";
        }
    } else {
        if (isset($_GET['from'])) {
            $from = $_GET['from'];
            $to = $_GET['to'];
            $sql_parts_order = $report->SelectAllDate_Store("ticket_list", $from, $to, "1", "uid", $input_by);
            $record = $report->SelectAllDate_Store("ticket_list", $from, $to, "2", "uid", $input_by);
            $record_label = "Total record Found ( " . $record . " ). | Report Generate Between " . $from . " - " . $to;
        } else {
            $sql_parts_order = $obj->SelectAllByID("ticket_list", array("uid" => $input_by));
            $record = $obj->exists_multiple("ticket_list", array("uid" => $input_by));
            $record_label = "Total Record Found ( " . $record . " )";
        }
    }
    header('Content-type: application/excel');
    $filename = "Ticket_Report_list_" . date('Y_m_d') . '.xls';
    header('Content-Disposition: attachment; filename=' . $filename);

    $data = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">
<head>
    <!--[if gte mso 9]>
    <xml>
        <x:ExcelWorkbook>
            <x:ExcelWorksheets>
                <x:ExcelWorksheet>
                    <x:Name>Ticket Request Order Report List : Wireless Geeks Inc.</x:Name>
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
    $data .="<h5>Ticket Report List Generate Date : " . date('d-m-Y H:i:s') . "</h5>";

    $data .="<table>
    <thead>
        <tr style='background:#09f; color:#fff;'>
			<th>#</th>
			<th>Ticket ID</th>
			<th>Problem</th>
			<th>Our Cost</th>
			<th>Retail Cost</th>
			<th>Profit</th>
			<th>Date</th>
		</tr>
</thead>
<tbody>";

    $i = 1;
    $a = 0;
    $b = 0;
    $c = 0;
    $d = 0;
    if (!empty($sql_parts_order))
        foreach ($sql_parts_order as $ticket):

            $chkcheckin = $obj->exists_multiple("invoice", array("doc_type" => 3, "checkin_id" => $ticket->ticket_id));
            $getsales_id = $obj->SelectAllByVal("invoice", "checkin_id", $ticket->ticket_id, "invoice_id");
            $curcheck = $obj->exists_multiple("sales", array("sales_id" => $getsales_id));
            if ($curcheck != 0)
                $b+=$ticket->our_cost;
            $c+=$ticket->retail_cost;
            $prof = $ticket->retail_cost - $ticket->our_cost;
            $d+=$prof;
            $data.="<tr>
				<td>" . $i . "</td>
				<td>" . $ticket->ticket_id . "</td>
				<td>" . $ticket->problem . "</td>
				<td>" . $ticket->our_cost . "</td>
				<td>" . $ticket->retail_cost . "</td>
				<td>" . $prof . "</td>
				<td>" . $ticket->date . "</td>
			</tr>";

            $i++;
        endforeach;

    $data .="</tbody><tfoot><tr>
			<th>#</th>
			<th>Ticket ID</th>
			<th>Problem</th>
			<th>Our Cost</th>
			<th>Retail Cost</th>
			<th>Profit</th>
			<th>Date</th>
		</tr></tfoot></table>";



    $data .='</body></html>';

    echo $data;
}

if (@$_GET['export'] == "pdf") {
    if ($input_status == 1) {
        if (isset($_GET['from'])) {
            $from = $_GET['from'];
            $to = $_GET['to'];
            $sql_parts_order = $report->SelectAllDate("ticket_list", $from, $to, "1");
            $record = $report->SelectAllDate("ticket_list", $from, $to, "2");
            $record_label = "Total record Found ( " . $record . " ). | Report Generate Between " . $from . " - " . $to;
        } else {
            $sql_parts_order = $obj->SelectAll("ticket_list");
            $record = $obj->totalrows("ticket_list");
            $record_label = "Total Record Found ( " . $record . " )";
        }
    } else {
        if (isset($_GET['from'])) {
            $from = $_GET['from'];
            $to = $_GET['to'];
            $sql_parts_order = $report->SelectAllDate_Store("ticket_list", $from, $to, "1", "uid", $input_by);
            $record = $report->SelectAllDate_Store("ticket_list", $from, $to, "2", "uid", $input_by);
            $record_label = "Total record Found ( " . $record . " ). | Report Generate Between " . $from . " - " . $to;
        } else {
            $sql_parts_order = $obj->SelectAllByID("ticket_list", array("uid" => $input_by));
            $record = $obj->exists_multiple("ticket_list", array("uid" => $input_by));
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
						Ticket Report List Report
						</td>
					</tr>
				</table>

				<table style='width:100%; height:40px; border:0px; font-size:18px;'>
					<tr>
						<td>Ticket Report List Generate Date : " . date('d-m-Y H:i:s') . "</td>
					</tr>
				</table>
				<table style='width:960px;border:1px; font-size:12px; background:#ccc;'>";
    $html.="<thead>

        <tr style='background:#09f; color:#fff;'>
			<th>#</th>
			<th>Ticket ID</th>
			<th>Problem</th>
			<th>Our Cost</th>
			<th>Retail Cost</th>
			<th>Profit</th>
			<th>Date</th>
		</tr>
</thead>
<tbody>";


    $i = 1;
    $a = 0;
    $b = 0;
    $c = 0;
    $d = 0;
    if (!empty($sql_parts_order))
        foreach ($sql_parts_order as $ticket):

            $chkcheckin = $obj->exists_multiple("invoice", array("doc_type" => 3, "checkin_id" => $ticket->ticket_id));
            $getsales_id = $obj->SelectAllByVal("invoice", "checkin_id", $ticket->ticket_id, "invoice_id");
            $curcheck = $obj->exists_multiple("sales", array("sales_id" => $getsales_id));
            if ($curcheck != 0)
                $b+=$ticket->our_cost;
            $c+=$ticket->retail_cost;
            $prof = $ticket->retail_cost - $ticket->our_cost;
            $d+=$prof;
            $html.="<tr>
				<td>" . $i . "</td>
				<td>" . $ticket->ticket_id . "</td>
				<td>" . $ticket->problem . "</td>
				<td>" . $ticket->our_cost . "</td>
				<td>" . $ticket->retail_cost . "</td>
				<td>" . $prof . "</td>
				<td>" . $ticket->date . "</td>
			</tr>";

            $i++;
        endforeach;

    $html.="</tbody><tfoot><tr>
			<th>#</th>
			<th>Ticket ID</th>
			<th>Problem</th>
			<th>Our Cost</th>
			<th>Retail Cost</th>
			<th>Profit</th>
			<th>Date</th>
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
//                            if ($input_status == 1) {
//                                if (isset($_GET['from'])) {
//                                    $from = $_GET['from'];
//                                    $to = $_GET['to'];
//                                    $sql_parts_order = $report->SelectAllDate("ticket_list", $from, $to, "1");
//                                    $record = $report->SelectAllDate("ticket_list", $from, $to, "2");
//                                    $record_label = "Total record Found ( " . $record . " ). | Report Generate Between " . $from . " - " . $to;
//                                } else {
//                                    $sql_parts_order = $obj->SelectAllByID("ticket_list", array("date" => date('Y-m-d')));
//                                    $record = $obj->exists_multiple("ticket_list", array("date" => date('Y-m-d')));
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
//                                    include('class/report_chain_admin.php');
//                                    $obj_report_chain = new chain_report();
//
//                                    if (isset($_GET['from'])) {
//                                        $from = $_GET['from'];
//                                        $to = $_GET['to'];
//                                        $sqlticket = $obj_report_chain->SelectAllByID_Multiple_Or("unlock_request", $array_ch, "uid", "1");
//                                        $record = $obj_report_chain->SelectAllByID_Multiple_Or("unlock_request", $array_ch, "uid", "2");
//                                        $record_label = "| Report Generate Between " . $from . " - " . $to;
//                                    } else {
//                                        $sqlticket = $obj_report_chain->SelectAllByID_Multiple2_Or("unlock_request", array("date" => date('Y-m-d')), $array_ch, "uid", "1");
//                                        $record = $obj_report_chain->SelectAllByID_Multiple2_Or("unlock_request", array("date" => date('Y-m-d')), $array_ch, "uid", "2");
//                                        $record_label = "Total Record ( " . $record . " )";
//                                    }
//                                } else {
//                                    //echo "Not Work";
//                                    $sqlticket = "";
//                                    $record = 0;
//                                    $record_label = "Total Record ( " . $record . " )";
//                                }
//                            } else {
//                                if (isset($_GET['from'])) {
//                                    $from = $_GET['from'];
//                                    $to = $_GET['to'];
//                                    $sql_parts_order = $report->SelectAllDate_Store("ticket_list", $from, $to, "1", "uid", $input_by);
//                                    $record = $report->SelectAllDate_Store("ticket_list", $from, $to, "2", "uid", $input_by);
//                                    $record_label = "Total record Found ( " . $record . " ). | Report Generate Between " . $from . " - " . $to;
//                                } else {
//                                    $sql_parts_order = $obj->SelectAllByID_Multiple("ticket_list", array("uid" => $input_by, "date" => date('Y-m-d')));
//                                    $record = $obj->exists_multiple("ticket_list", array("uid" => $input_by, "date" => date('Y-m-d')));
//                                    $record_label = "Total Record Found ( " . $record . " )";
//                                }
//                            }
                            ?>
                            <h5><i class="font-money"></i> Ticket Report List  | <a  data-toggle="modal" href="#myModal"> Search Datewise </a></h5>
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
                                            <h5 id="myModalLabel"><i class="font-calendar"></i> Generate Ticket Report <span id="mss"></span></h5>
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
                                            jQuery(document).ready(function () {
                                                var dataSource = new kendo.data.DataSource({
                                                    transport: {
                                                        read: {
                                                            url: "./controller/ticket_report.php<?php echo $cond; ?>",
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
                                                                            page_countitem += (1 - 0);
                                                                            page_total_our_cost += (keyg.price - 0);
                                                                            page_total_retail_cost += (keyg.paid - 0);

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
                                                                id: {type: "number"},
                                                                ticket_id: {type: "number"},
                                                                date: {type: "string"},
                                                                status: {type: "string"},
                                                                problem_type: {type: "string"},
                                                                problem: {type: "string"},
                                                                price: {type: "string"},
                                                                invoice_id: {type: "number"},
                                                                pricee: {type: "string"},
                                                                paid: {type: "string"},
                                                                input_by: {type: "string"}
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
                                                        {field: "ticket_id", title: "Ticket ID ", width: "100px"},
                                                        {field: "problem", title: "Problem ", width: "80px", filterable: false},
                                                        {template: "<?php echo $currencyicon; ?>#=price#", title: "Our Cost ", width: "50px"},
                                                        {template: "<?php echo $currencyicon; ?>#=pricee#", title: "Retail Cost ", width: "100px", filterable: false},
                                                        {field: "status", title: "Profit ", width: "70px", filterable: false},
                                                        {template: "<?php echo $currencyicon; ?>#=paid#", title: "Paid ", width: "70px", filterable: false},
                                                        {field: "date", title: "Date ", width: "80px", filterable: false}
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
                                            JSONToCSVConvertor(json_data, "Ticket Report", true);

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
                                            var fileName = "ticket_report_";
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
                                          <th>Ticket ID</th>
                                          <?php if ($input_status == 1 || $input_status == 5) { ?>
                                          <th>Store Name</th>
                                          <?php } ?>
                                          <th>Problem</th>
                                          <th>Our Cost</th>
                                          <th>Retail Cost</th>
                                          <th>Profit</th>
                                          <th>Date</th>
                                          </tr>
                                          </thead>
                                          <tbody>
                                          <?php
                                          $i=1;
                                          $a=0;
                                          $b=0;
                                          $c=0;
                                          $d=0;
                                          if (!empty($sql_parts_order))
                                          foreach ($sql_parts_order as $ticket):

                                          $chkcheckin=$obj->exists_multiple("invoice", array("doc_type"=>3, "checkin_id"=>$ticket->ticket_id));
                                          $getsales_id=$obj->SelectAllByVal("invoice", "checkin_id", $ticket->ticket_id, "invoice_id");
                                          $curcheck=$obj->exists_multiple("sales", array("sales_id"=>$getsales_id));
                                          if ($curcheck != 0) {
                                          ?>
                                          <tr>
                                          <td><?php
                                          echo $i;
                                          $a+=1;
                                          ?></td>
                                          <td><a class="label label-success" href="view_tickets.php?ticket_id=<?php echo $ticket->ticket_id; ?>"><i class="icon-tags"></i> <?php echo $ticket->ticket_id; ?></a></td>
                                          <?php if ($input_status == 1 || $input_status == 5) { ?>
                                          <td><?php echo $obj->SelectAllByVal("store", "store_id", $ticket->input_by, "name"); ?></td>
                                          <?php } ?>
                                          <td><label class="label label-warning"><i class="icon-tint"></i> <?php echo $ticket->problem; ?></label></td>
                                          <td>$<?php
                                          echo $ticket->our_cost;
                                          $b+=$ticket->our_cost;
                                          ?></td>
                                          <td>$<?php
                                          echo $ticket->retail_cost;
                                          $c+=$ticket->retail_cost;
                                          ?></td>
                                          <td>$<?php
                                          $prof=$ticket->retail_cost - $ticket->our_cost;
                                          echo $prof;
                                          $d+=$prof;
                                          ?></td>
                                          <td><i class="icon-calendar"></i> <?php echo $ticket->date; ?></td>

                                          </tr>
                                          <?php
                                          $i++;
                                          }
                                          endforeach;
                                          ?>
                                          </tbody>
                                          </table> */ ?>
                                    </div>
                                    <!-- Default datatable -->
                                    <div style="margin-top:10px;" class="table-overflow">

                                        <table class="table table-striped" style="width:250px;">
                                            <tbody>
                                                <tr>
                                                    <td>1. Total Ticket Quantity : <strong id="a1"><?php //echo $a; ?></strong></td>
                                                </tr>
                                                <tr>
                                                    <td>2. Our Total Cost : <?php echo $currencyicon; ?><strong id="a2">$<?php //echo $b; ?></strong></td>
                                                </tr>
                                                <tr>
                                                    <td>3. Retail Total Cost : <?php echo $currencyicon; ?><strong id="a3">$<?php ///echo $c; ?></strong></td>
                                                </tr>
                                                <tr>
                                                    <td>4. Profit : <?php echo $currencyicon; ?><strong id="a4">$<?php //echo $d; ?></strong></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /default datatable -->


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
            <?php //include('include/sidebar_right.php'); ?>
            <!-- /right sidebar -->

        </div>
        <!-- /main wrapper -->

    </body>
</html>
