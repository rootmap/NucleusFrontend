<?php
include('class/auth.php');
include('class/report_customer.php');
$report = new report();
$table = "invoice_payment";
if (isset($_GET['del'])) {
    $obj->deletesing("id", $_GET['del'], "invoice_payment");
}

if (@$_GET['export'] == "excel") {
    if (isset($_GET['from'])) {
        $from = $_GET['from'];
        $to = $_GET['to'];
        if ($input_status == 1) {
            $sqlinvoice = $report->SelectAllDate("tender_payment", $from, $to, "1");
            $record = $report->SelectAllDate("tender_payment", $from, $to, "2");
            $record_label = "Total record Found ( " . $record . " ). | Report Generate Between " . $from . " - " . $to;
        } else {
            $sqlinvoice = $report->ReportQuery_Datewise("tender_payment", array("creator" => $input_by), $from, $to, "1");
            $record = $report->ReportQuery_Datewise("tender_payment", array("creator" => $input_by), $from, $to, "2");
            $record_label = "Total record Found ( " . $record . " ). | Report Generate Between " . $from . " - " . $to;
        }
    } else {
        if ($input_status == 1) {
            $sqlinvoice = $obj->SelectAll("tender_payment");
            $record = $obj->totalrows("tender_payment");
            $record_label = "Total Record Found ( " . $record . " )";
        } else {
            $sqlinvoice = $obj->SelectAllByID("tender_payment", array("creator" => $input_by));
            $record = $obj->exists_multiple("tender_payment", array("creator" => $input_by));
            $record_label = "Total Record Found ( " . $record . " )";
        }
    }

    header('Content-type: application/excel');
    $filename = "Tender_Report_list_" . date('Y_m_d') . '.xls';
    header('Content-Disposition: attachment; filename=' . $filename);

    $data = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">
<head>
    <!--[if gte mso 9]>
    <xml>
        <x:ExcelWorkbook>
            <x:ExcelWorksheets>
                <x:ExcelWorksheet>
                    <x:Name>Tender Report List : Wireless Geeks Inc.</x:Name>
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
    $data .="<h5>Tender Report List Generate Date : " . date('d-m-Y H:i:s') . "</h5>";

    $data .="<table>
    <thead>
        <tr style='background:#09f; color:#fff;'>
		<th>#</th>
		<th>Sales-ID</th>
		<th>Tender Name</th>
		<th>Customer</th>
		<th>Amount</th>
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
            $aa+=1;
            $bb+=$invoice->amount;

            $data.="<tr>
				<td>" . $i . "</td>
				<td>" . $invoice->invoice_id . "</td>
				<td>" . $invoice->name . "</td>
				<td>" . $invoice->customer . "</td>
				<td>" . $invoice->amount . "</td>
				<td>" . $invoice->date . "</td>
			</tr>";

            $i++;
        endforeach;

    $data .="</tbody><tfoot><tr>
		<th>#</th>
		<th>Sales-ID</th>
		<th>Tender Name</th>
		<th>Customer</th>
		<th>Amount</th>
		<th>Date</th>
		</tr></tfoot></table>";




    $data.="<table border='0' width='250' style='width:200px;'>
					<tbody>
						<tr>
							<td>1. Total Quantity = <strong> " . $aa . "</strong></td>
						</tr>
						<tr>
							<td>2. Total Amount = <strong> $" . number_format($bb, 2) . "</strong></td>
						</tr>
					</tbody>
				</table>";

    $data .='</body></html>';

    echo $data;
}

if (@$_GET['export'] == "pdf") {
    if (isset($_GET['from'])) {
        $from = $_GET['from'];
        $to = $_GET['to'];
        if ($input_status == 1) {
            $sqlinvoice = $report->SelectAllDate("tender_payment", $from, $to, "1");
            $record = $report->SelectAllDate("tender_payment", $from, $to, "2");
            $record_label = "Total record Found ( " . $record . " ). | Report Generate Between " . $from . " - " . $to;
        } else {
            $sqlinvoice = $report->ReportQuery_Datewise("tender_payment", array("creator" => $input_by), $from, $to, "1");
            $record = $report->ReportQuery_Datewise("tender_payment", array("creator" => $input_by), $from, $to, "2");
            $record_label = "Total record Found ( " . $record . " ). | Report Generate Between " . $from . " - " . $to;
        }
    } else {
        if ($input_status == 1) {
            $sqlinvoice = $obj->SelectAll("tender_payment");
            $record = $obj->totalrows("tender_payment");
            $record_label = "Total Record Found ( " . $record . " )";
        } else {
            $sqlinvoice = $obj->SelectAllByID("tender_payment", array("creator" => $input_by));
            $record = $obj->exists_multiple("tender_payment", array("creator" => $input_by));
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
						Tender Report List Report
						</td>
					</tr>
				</table>


				<table style='width:100%; height:40px; border:0px; font-size:18px;'>
					<tr>
						<td> Tender Report List Generate Date : " . date('d-m-Y H:i:s') . "</td>
					</tr>
				</table>
				<table style='width:960px;border:1px; font-size:12px; background:#ccc;'>";
    $html.="<thead>

        <tr style='background:#09f; color:#fff;'>
		<th>#</th>
		<th>Sales-ID</th>
		<th>Tender Name</th>
		<th>Customer</th>
		<th>Amount</th>
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
            $aa+=1;
            $bb+=$invoice->amount;

            $html.="<tr>
				<td>" . $i . "</td>
				<td>" . $invoice->invoice_id . "</td>
				<td>" . $invoice->name . "</td>
				<td>" . $invoice->customer . "</td>
				<td>" . $invoice->amount . "</td>
				<td>" . $invoice->date . "</td>
			</tr>";

            $i++;
        endforeach;

    $html.="</tbody><tfoot><tr>
		<th>#</th>
		<th>Sales-ID</th>
		<th>Tender Name</th>
		<th>Customer</th>
		<th>Amount</th>
		<th>Date</th>
		</tr></tfoot></table>";

    $html.="<table border='0'  width='250' style='width:200px;'>
					<tbody>
						<tr>
							<td>1. Total Quantity = <strong> " . $aa . "</strong></td>
						</tr>
						<tr>
							<td>2. Total Amount = <strong> $" . number_format($bb, 2) . "</strong></td>
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
                        <div class="page-header"><!-- Page header -->
                            <?php
                            echo $obj->ShowMsg();
                            if (isset($_GET['from'])) {
                                $from = $_GET['from'];
                                $to = $_GET['to'];
                                if ($input_status == 1) {
                                    $sqlinvoice = $report->SelectAllDate("tender_payment", $from, $to, "1");
                                    $record = $report->SelectAllDate("tender_payment", $from, $to, "2");
                                    $record_label = "Total record Found ( " . $record . " ). | Report Generate Between " . $from . " - " . $to;
                                } elseif ($input_status == 5) {

                                    $sqlchain_store_ids = $obj->SelectAllByID("store_chain_admin", array("sid" => $input_by));
                                    if (!empty($sqlchain_store_ids)) {
                                        $array_ch = array();
                                        foreach ($sqlchain_store_ids as $ch):
                                            array_push($array_ch, $ch->store_id);
                                        endforeach;

                                        include('class/report_chain_admin.php');
                                        $obj_report_chain = new chain_report();
                                        $sqlinvoice = $obj_report_chain->ReportQuery_Datewise_Or("tender_payment", $array_ch, "creator", $from, $to, "1");
                                        $record = $obj_report_chain->ReportQuery_Datewise_Or("tender_payment", $array_ch, "creator", $from, $to, "2");
                                        $record_label = "Total record Found ( " . $record . " ). | Report Generate Between " . $from . " - " . $to;
                                        //echo "Work";
                                    }
                                    else {
                                        //echo "Not Work";
                                        $sqlinvoice = "";
                                        $record = 0;
                                        $record_label = "Total record Found ( " . $record . " ).";
                                    }
                                } else {
                                    $sqlinvoice = $report->ReportQuery_Datewise("tender_payment", array("creator" => $input_by), $from, $to, "1");
                                    $record = $report->ReportQuery_Datewise("tender_payment", array("creator" => $input_by), $from, $to, "2");
                                    $record_label = "Total record Found ( " . $record . " ). | Report Generate Between " . $from . " - " . $to;
                                }
                            } else {
                                if ($input_status == 1) {
                                    $sqlinvoice = $obj->SelectAll("tender_payment");
                                    $record = $obj->totalrows("tender_payment");
                                    $record_label = "Total Record Found ( " . $record . " )";
                                } elseif ($input_status == 5) {

                                    $sqlchain_store_ids = $obj->SelectAllByID("store_chain_admin", array("sid" => $input_by));
                                    if (!empty($sqlchain_store_ids)) {
                                        $array_ch = array();
                                        foreach ($sqlchain_store_ids as $ch):
                                            array_push($array_ch, $ch->store_id);
                                        endforeach;

                                        include('class/report_chain_admin.php');
                                        $obj_report_chain = new chain_report();
                                        $sqlinvoice = $obj_report_chain->SelectAllByID_Multiple_Or("tender_payment", $array_ch, "creator", "1");
                                        $record = $obj_report_chain->SelectAllByID_Multiple_Or("tender_payment", $array_ch, "creator", "2");
                                        $record_label = "Total record Found ( " . $record . " ).";
                                        //echo "Work";
                                    }
                                    else {
                                        //echo "Not Work";
                                        $sqlinvoice = "";
                                        $record = 0;
                                        $record_label = "Total record Found ( " . $record . " ).";
                                    }
                                } else {
                                    $sqlinvoice = $obj->SelectAllByID("tender_payment", array("creator" => $input_by));
                                    $record = $obj->exists_multiple("tender_payment", array("creator" => $input_by));
                                    $record_label = "Total Record Found ( " . $record . " )";
                                }
                            }
                            ?>
                            <h5><i class="font-money"></i> Tender Report | <?php echo $record_label; ?> | <a  data-toggle="modal" href="#myModal"> Search Datewise </a></h5>
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
                                            <h5 id="myModalLabel"><i class="font-calendar"></i> Generate Tender Report <span id="mss"></span></h5>
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
<!--                                        <script id="action_template" type="text/x-kendo-template">
                                            <a class="k-button k-button-icontext k-grid-delete" href="tender_report.php?edit=#=id#"><i class="icon-edit"></i> Edit</a> 
                                            <a class="k-button k-button-icontext k-grid-delete" onclick="javascript:deleteClick(#=id#);" ><span class="k-icon k-delete"></span> Delete</a>
                                        </script>-->
                                        <script type="text/javascript">
                                            function deleteClick(id) {
                                                var c = confirm("Do you want to delete?");
                                                if (c === true) {
                                                    $.ajax({
                                                        type: "POST",
                                                        dataType: "json",
                                                        url: "./controller/tender_report.php",
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
                                                            url: "./controller/tender_report.php",
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
                                                                sales_id: {type: "number"},
                                                                tender_name: {type: "string"},
                                                                customer: {type: "string"},
                                                                amount: {type: "string"},
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
                                                        {field: "id", title: "#", width: "60px", filterable: false},
                                                        {field: "sales_id", title: "Sales-ID"},
                                                        {field: "tender_name", title: "Tender Name"},
                                                        {field: "customer", title: "Customer"},
                                                        {template: "<?php echo $currencyicon; ?>#=amount#", title: "Amount"},
                                                        {field: "date", title: "Created"},
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
                                            JSONToCSVConvertor(json_data, "Tender Report", true);

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
                                            var fileName = "tender_report_";
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
                                          <th>Sales-ID</th>
                                          <?php
                                          if ($input_status == 5) {
                                          ?>
                                          <th>Store</th>
                                          <?php
                                          }
                                          ?>
                                          <th>Tender Name</th>
                                          <th>Customer</th>
                                          <th>Amount</th>
                                          <th>Date</th>
                                          <?php if ($input_status == 1 || $input_status == 2) { ?>
                                          <th></th>
                                          <?php } ?>
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
                                          $aa+=1;
                                          $bb+=$invoice->amount;
                                          ?>
                                          <tr>
                                          <td><?php echo $i; ?></td>
                                          <td><a href="view_sales.php?invoice=<?php echo $invoice->invoice_id; ?>"><?php echo $invoice->invoice_id; ?></a></td>
                                          <?php
                                          if ($input_status == 5) {
                                          ?>
                                          <td><?php echo $obj->SelectAllByVal("store", "store_id", $invoice->creator, "name"); ?></td>
                                          <?php
                                          }
                                          ?>
                                          <td><?php echo $invoice->name; ?></td>
                                          <td><label class="label label-success"><?php
                                          //$dd+=$invoice->quantity;
                                          echo $invoice->customer;
                                          ?></label></td>
                                          <td><label class="label label-success"> $<?php echo $invoice->amount; ?> </label></td>
                                          <td><label class="label label-warning"><?php echo $invoice->date; ?> </label></td>

                                          <?php if ($input_status == 1 || $input_status == 2) { ?>
                                          <td> <a href="<?php echo $obj->filename(); ?>?del=<?php echo $invoice->id; ?>" class="hovertip" title="Delete" onclick="javascript:return confirm('Are you absolutely sure to delete This?')"><i class="icon-trash"></i></a>
                                          </td><?php } ?>

                                          </tr>
                                          <?php
                                          $i++;
                                          endforeach;
                                          ?>
                                          </tbody>
                                          </table> */ ?>
                                    </div>
                                    <!-- Table condensed -->
                                    <div class="block well span4" style="margin-left:0;">
                                        <div class="navbar">
                                            <div class="navbar-inner">
                                                <h5> Profit Report</h5>
                                            </div>
                                        </div>
                                        <div class="table-overflow">
                                            <?php /* <table class="table table-condensed">
                                              <tbody>
                                              <tr>
                                              <td>1. Total Quantity = <strong> <?php echo $aa; ?></strong></td>
                                              </tr>
                                              <tr>
                                              <td>2. Total Amount = <strong> $<?php echo number_format($bb, 2); ?></strong></td>
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
            <?php //include('include/sidebar_right.php');    ?>
            <!-- /right sidebar -->

        </div>
        <!-- /main wrapper -->

    </body>
</html>
