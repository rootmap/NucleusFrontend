<?php
include('class/auth.php');
include('class/report_customer.php');
$report = new report();
$table = "parts_order";
if (@$_GET['export'] == "excel") {
    if ($input_status == 1) {
        if (isset($_GET['from'])) {
            $from = $_GET['from'];
            $to = $_GET['to'];
            $sql_parts_order = $report->SelectAllDate("parts_order", $from, $to, "1");
            $record = $report->SelectAllDate("parts_order", $from, $to, "2");
            $record_label = "Total record Found ( " . $record . " ). | Report Generate Between " . $from . " - " . $to;
        } else {
            $sql_parts_order = $obj->SelectAll("parts_order");
            $record = $obj->totalrows("parts_order");
            $record_label = "Total Record Found ( " . $record . " )";
        }
    } else {
        if (isset($_GET['from'])) {
            $from = $_GET['from'];
            $to = $_GET['to'];
            $sql_parts_order = $report->SelectAllDate_Store("parts_order", $from, $to, "1", "input_by", $input_by);
            $record = $report->SelectAllDate_Store("parts_order", $from, $to, "2", "input_by", $input_by);
            $record_label = "Total record Found ( " . $record . " ). | Report Generate Between " . $from . " - " . $to;
        } else {
            $sql_parts_order = $obj->SelectAllByID("parts_order", array("input_by" => $input_by));
            $record = $obj->exists_multiple("parts_order", array("input_by" => $input_by));
            $record_label = "Total Record Found ( " . $record . " )";
        }
    }

    header('Content-type: application/excel');
    $filename = "Parts_Order_Report_list_" . date('Y_m_d') . '.xls';
    header('Content-Disposition: attachment; filename=' . $filename);

    $data = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">
<head>
    <!--[if gte mso 9]>
    <xml>
        <x:ExcelWorkbook>
            <x:ExcelWorksheets>
                <x:ExcelWorksheet>
                    <x:Name>Parts Order Report List : Wireless Geeks Inc.</x:Name>
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
    $data .="<h5>Parts Order Report List Generate Date : " . date('d-m-Y H:i:s') . "</h5>";

    $data .="<table>
    <thead>
        <tr style='background:#09f; color:#fff;'>
		<th>#</th>
		<th>ID</th>
		<th>Entered </th>
		<th>Ticket </th>
		<th>Customer </th>
		<th>Description</th>
		<th>Price</th>                                                            
		<th>Store</th>
		<th>Bought</th>
		<th>Tracking</th>
		<th>Arrived</th>
		</tr>
</thead>        
<tbody>";

    $i = 1;
    if (!empty($sql_parts_order))
        foreach ($sql_parts_order as $row):
            $cids = $obj->SelectAllByVal("ticket", "ticket_id", $row->ticket_id, "cid");

            $data.="<tr>
				<td>" . $i . "</td>
				<td>" . $row->id . "</td>
				<td>" . $row->date . "</td>
				<td>" . $row->ticket_id . "</td>
				<td>" . $obj->SelectAllByVal("coustomer", "id", $cids, "businessname") . "</td>
				<td>" . $row->description . "</td>
				<td>" . $row->cost . "</td>
				<td>" . $row->store . "</td>
				<td>" . $row->ordered . "</td>
				<td>" . $row->trackingnum . "</td>
				<td>" . $row->received . "</td>
			</tr>";

            $i++;
        endforeach;

    $data .="</tbody><tfoot><tr>
		<th>#</th>
		<th>ID</th>
		<th>Entered </th>
		<th>Ticket </th>
		<th>Customer </th>
		<th>Description</th>
		<th>Price</th>                                                            
		<th>Store</th>
		<th>Bought</th>
		<th>Tracking</th>
		<th>Arrived</th>
		</tr></tfoot></table>";



    $data .='</body></html>';

    echo $data;
}

if (@$_GET['export'] == "pdf") {
    if ($input_status == 1) {
        if (isset($_GET['from'])) {
            $from = $_GET['from'];
            $to = $_GET['to'];
            $sql_parts_order = $report->SelectAllDate("parts_order", $from, $to, "1");
            $record = $report->SelectAllDate("parts_order", $from, $to, "2");
            $record_label = "Total record Found ( " . $record . " ). | Report Generate Between " . $from . " - " . $to;
        } else {
            $sql_parts_order = $obj->SelectAll("parts_order");
            $record = $obj->totalrows("parts_order");
            $record_label = "Total Record Found ( " . $record . " )";
        }
    } else {
        if (isset($_GET['from'])) {
            $from = $_GET['from'];
            $to = $_GET['to'];
            $sql_parts_order = $report->SelectAllDate_Store("parts_order", $from, $to, "1", "input_by", $input_by);
            $record = $report->SelectAllDate_Store("parts_order", $from, $to, "2", "input_by", $input_by);
            $record_label = "Total record Found ( " . $record . " ). | Report Generate Between " . $from . " - " . $to;
        } else {
            $sql_parts_order = $obj->SelectAllByID("parts_order", array("input_by" => $input_by));
            $record = $obj->exists_multiple("parts_order", array("input_by" => $input_by));
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
						Parts Order Report List Report
						</td>
					</tr>
				</table>
				
				
				<table style='width:100%; height:40px; border:0px; font-size:18px;'>
					<tr>
						<td>Parts Order Report List Generate Date : " . date('d-m-Y H:i:s') . "</td>
					</tr>
				</table>
				<table style='width:960px;border:1px; font-size:12px; background:#ccc;'>";
    $html.="<thead>

        <tr style='background:#09f; color:#fff;'>
		<th>#</th>
		<th>ID</th>
		<th>Entered </th>
		<th>Ticket </th>
		<th>Customer </th>
		<th>Description</th>
		<th>Price</th>                                                            
		<th>Store</th>
		<th>Bought</th>
		<th>Tracking</th>
		<th>Arrived</th>
		</tr>
</thead>        
<tbody>";


    $i = 1;
    if (!empty($sql_parts_order))
        foreach ($sql_parts_order as $row):
            $cids = $obj->SelectAllByVal("ticket", "ticket_id", $row->ticket_id, "cid");

            $html.="<tr>
				<td>" . $i . "</td>
				<td>" . $row->id . "</td>
				<td>" . $row->date . "</td>
				<td>" . $row->ticket_id . "</td>
				<td>" . $obj->SelectAllByVal("coustomer", "id", $cids, "businessname") . "</td>
				<td>" . $row->description . "</td>
				<td>" . $row->cost . "</td>
				<td>" . $row->store . "</td>
				<td>" . $row->ordered . "</td>
				<td>" . $row->trackingnum . "</td>
				<td>" . $row->received . "</td>
			</tr>";

            $i++;
        endforeach;

    $html.="</tbody><tfoot><tr>
		<th>#</th>
		<th>ID</th>
		<th>Entered </th>
		<th>Ticket </th>
		<th>Customer </th>
		<th>Description</th>
		<th>Price</th>                                                            
		<th>Store</th>
		<th>Bought</th>
		<th>Tracking</th>
		<th>Arrived</th>
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
                                    $sql_parts_order = $report->SelectAllDate("parts_order", $from, $to, "1");
                                    $record = $report->SelectAllDate("parts_order", $from, $to, "2");
                                    $record_label = "Total record Found ( " . $record . " ). | Report Generate Between " . $from . " - " . $to;
                                } else {
                                    $sql_parts_order = $obj->SelectAllByID("parts_order", array("date" => date('Y-m-d')));
                                    $record = $obj->exists_multiple("parts_order", array("date" => date('Y-m-d')));
                                    $record_label = "Total Record Found ( " . $record . " )";
                                }
                            }
                            if ($input_status == 5) {
                                $sqlchain_store_ids = $obj->SelectAllByID("store_chain_admin", array("sid" => $input_by));
                                if (!empty($sqlchain_store_ids)) {
                                    $array_ch = array();
                                    foreach ($sqlchain_store_ids as $ch):
                                        array_push($array_ch, $ch->store_id);
                                    endforeach;

                                    if (isset($_GET['from'])) {
                                        include('class/report_chain_admin.php');
                                        $obj_report_chain = new chain_report();
                                        $sql_parts_order = $obj_report_chain->ReportQuery_Datewise_Or("parts_order", $array_ch, "input_by", $_GET['from'], $_GET['to'], "1");
                                        $record = $obj_report_chain->ReportQuery_Datewise_Or("parts_order", $array_ch, "input_by", $_GET['from'], $_GET['to'], "2");
                                        $record_label = "Total record Found ( " . $record . " ). | Report Generate Between " . $from . " - " . $to;
                                    } else {
                                        include('class/report_chain_admin.php');
                                        $obj_report_chain = new chain_report();
                                        $sql_parts_order = $obj_report_chain->SelectAllByID_Multiple2_Or("parts_order", array("date" => date('Y-m-d')), $array_ch, "input_by", "1");
                                        $record = $obj_report_chain->SelectAllByID_Multiple2_Or("parts_order", array("date" => date('Y-m-d')), $array_ch, "input_by", "2");
                                        $record_label = "Total record Found ( " . $record . " ).";
                                    }
                                    //echo "Work";
                                } else {
                                    //echo "Not Work";
                                    $sqlinvoice = "";
                                    $record = 0;
                                    $record_label = "Total record Found ( " . $record . " ).";
                                }
                            } else {
                                if (isset($_GET['from'])) {
                                    $from = $_GET['from'];
                                    $to = $_GET['to'];
                                    $sql_parts_order = $report->SelectAllDate_Store("parts_order", $from, $to, "1", "input_by", $input_by);
                                    $record = $report->SelectAllDate_Store("parts_order", $from, $to, "2", "input_by", $input_by);
                                    $record_label = "Total record Found ( " . $record . " ). | Report Generate Between " . $from . " - " . $to;
                                } else {
                                    $sql_parts_order = $obj->SelectAllByID_Multiple("parts_order", array("input_by" => $input_by, "date" => date('Y-m-d')));
                                    $record = $obj->exists_multiple("parts_order", array("input_by" => $input_by, "date" => date('Y-m-d')));
                                    $record_label = "Total Record Found ( " . $record . " )";
                                }
                            }
                            ?>
                            <h5><i class="font-money"></i> Parts Order List | <?php echo $record_label; ?> | <a  data-toggle="modal" href="#myModal"> Search Datewise </a></h5>
                        </div><!-- /page header -->

                        <div class="body">

                            <!-- Middle navigation standard -->
                            <?php //include('include/quicklink.php'); ?>
                            <!-- /middle navigation standard -->

                            <!-- Content container -->
                            <div class="container">

                                <!-- Content Start from here customized -->


                                <!-- Dialog content -->
                                <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h5 id="myModalLabel"><i class="font-calendar"></i> Generate Special Part Order Report <span id="mss"></span></h5>
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

                                <!-- General form elements -->
                                <div class="row-fluid block">



                                    <div class="table-overflow">




                                        <div id="grid" style="margin-left: 10px;margin-right: 10px;"></div>

                                        <?php
                                        $cond = $cms->FrontEndDateSearch('from', 'to');
                                        ?>
<!--                                        <script id="action_template" type="text/x-kendo-template">
                                            <a class="k-button k-button-icontext k-grid-delete" href="part_report.php?edit=#=id#"><i class="icon-edit"></i> Edit</a> 
                                            <a class="k-button k-button-icontext k-grid-delete" onclick="javascript:deleteClick(#=id#);" ><span class="k-icon k-delete"></span> Delete</a>
                                        </script>-->
                                        <script type="text/javascript">
                                            function deleteClick(id) {
                                                var c = confirm("Do you want to delete?");
                                                if (c === true) {
                                                    $.ajax({
                                                        type: "POST",
                                                        dataType: "json",
                                                        url: "./controller/part_report.php",
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
                                                            url: "./controller/part_report.php",
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
                                                                cid: {type: "number"},
                                                                date: {type: "string"},
                                                                ticket_id: {type: "number"},
                                                                customer: {type: "string"},
                                                                description: {type: "string"},
                                                                cost: {type: "string"},
                                                                store: {type: "string"},
                                                                ordered: {type: "string"},
                                                                trackingnum: {type: "string"},
                                                                received: {type: "number"}
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
                                                        {field: "cid", title: "Entered"},
                                                        {field: "date", title: "Created", width: "100px"},
                                                        {field: "ticket_id", title: "Ticket", width: "100px"},
                                                        {field: "customer", title: "customer", width: "160px"},
                                                        {field: "description", title: "description", width: "160px"},
                                                        {field: "cost", title: "Price"},
                                                        {field: "store", title: "Store", width: "100px"},
                                                        {field: "ordered", title: "Bought", width: "100px"},
                                                        {field: "trackingnum", title: "Tracking", width: "140px"},
                                                        {field: "received", title: "Arrived", width: "100px"},
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
                                            JSONToCSVConvertor(json_data, "Part Report", true);

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
                                            var fileName = "part_report_";
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
                                          <th>ID</th>
                                          <th>Entered </th>
                                          <th>Ticket </th>
                                          <th>Customer </th>
                                          <th>Description</th>
                                          <th>Price</th>
                                          <th>Store</th>
                                          <th>Bought</th>
                                          <th>Tracking</th>
                                          <th>Arrived</th>
                                          </tr>
                                          </thead>
                                          <tbody>
                                          <?php
                                          $i=1;
                                          if(!empty($sql_parts_order))
                                          foreach($sql_parts_order as $row):
                                          $cids=$obj->SelectAllByVal("ticket","ticket_id",$row->ticket_id,"cid");
                                          ?>
                                          <tr>
                                          <td><?php echo $i; ?></td>
                                          <td> <?php echo $row->id; ?> </td>
                                          <td> <?php echo $row->date; ?> </td>

                                          <td><a href="view_tickets.php?ticket_id=<?php echo $row->ticket_id; ?>"><?php echo $row->ticket_id; ?></a></td>
                                          <td><a href="customer.php?edit=<?php echo $cids; ?>">
                                          <?php echo $obj->SelectAllByVal("coustomer","id",$cids,"businessname"); ?>
                                          </a></td>
                                          <td><label class="label label-success"> <?php echo $row->description; ?>  </label></td>
                                          <td> <?php echo $row->cost; ?> </td>
                                          <td><?php echo $row->store; ?></td>
                                          <td><?php echo $row->ordered; ?></td>
                                          <td><a target="_blank" href="http://www.google.com/search?&amp;q=<?php echo $row->trackingnum; ?>"><?php echo $row->trackingnum; ?></a></td>
                                          <td><?php echo $row->received; ?></td>
                                          </tr>
                                          <?php
                                          $i++;
                                          endforeach;
                                          ?>
                                          </tbody>
                                          </table> */ ?>
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
            <?php //include('include/footer.php'); ?>
            <!-- Right sidebar -->
            <?php //include('include/sidebar_right.php'); ?>
            <!-- /right sidebar -->

        </div>
        <!-- /main wrapper -->

    </body>
</html>
