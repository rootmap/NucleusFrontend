<?php
include('class/auth.php');
include('class/report_customer.php');
$report = new report();
$obj_report = new report();

$table = "warrenty";
if (isset($_GET['del'])) {
    $obj->deletesing("id", $_GET['del'], $table);
}
if (@$_GET['export'] == "excel") {


    $record_label = "Warrenty List Report";
    header('Content-type: application/excel');
    $filename = "Warrenty_list_" . date('Y_m_d') . '.xls';
    header('Content-Disposition: attachment; filename=' . $filename);

    $data = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">
<head>
    <!--[if gte mso 9]>
    <xml>
        <x:ExcelWorkbook>
            <x:ExcelWorksheets>
                <x:ExcelWorksheet>
                    <x:Name>Warrenty List : Wireless Geeks Inc.</x:Name>
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
    $data .="<h5>Warrenty List Generate Date : " . date('d-m-Y H:i:s') . "</h5>";

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


    if ($input_status == 1) {
        $sqlinvoice = $obj->SelectAll("warrenty");
    } elseif ($input_status == 5) {

        $sqlchain_store_ids = $obj->SelectAllByID("store_chain_admin", array("sid" => $input_by));
        if (!empty($sqlchain_store_ids)) {
            $array_ch = array();
            foreach ($sqlchain_store_ids as $ch):
                array_push($array_ch, $ch->store_id);
            endforeach;

            include('class/report_chain_admin.php');
            $obj_report_chain = new chain_report();
            $sqlinvoice = $obj_report_chain->SelectAllByID_Multiple_Or("warrenty", $array_ch, "uid", "1");
        }
        else {
            //echo "Not Work";
            $sqlinvoice = "";
        }
    } else {
        $sqlinvoice = $obj->SelectAllByID("warrenty", array("uid" => $input_by));
    }
    $i = 1;
    if (!empty($sqlinvoice))
        foreach ($sqlinvoice as $invoice):

            $daysgone2 = $obj->daysgone($invoice->date, date('Y-m-d'));
            $have2 = $invoice->warrenty - $daysgone2;

            if ($invoice->type == "ticket") {
                $pp = number_format($obj->SelectAllByVal("ticket_list", "ticket_id", $invoice->warrenty_id, "retail_cost"), 2);
            }

            if ($invoice->type == "checkin") {
                $pp = number_format($obj->SelectAllByVal("checkin_list", "checkin_id", $invoice->warrenty_id, "retail_cost"), 2);
            }

            $data.="<tr>
				<td>" . $i . "</td>
				<td>" . $invoice->warrenty_id . "</td>
				<td>" . $invoice->type . "</td>
				<td>" . $invoice->warrenty . " Days</td>
				<td>" . $have2 . " Days</td>
				<td>" . $invoice->date . "</td>
				<td>" . $pp . "</td>
				<td>" . $invoice->note . "</td>
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

    $data .='</body></html>';

    echo $data;
}

if (@$_GET['export'] == "pdf") {
    $record_label = "Warrenty List Report";
    include("pdf/MPDF57/mpdf.php");
    extract($_GET);
    $html.="<table id='sample-table-2' class='table table-hover' border='0'><tbody>";
    $html .="<tr>
			<td valign='top' style='margin:0; padding:0; width:100%;'>
				<table style='width:100%; height:40px; border:0px;'>
					<tr>
						<td width='87%' style='background:rgba(0,51,153,1);  color:#FFF; font-size:25px;'>
						Warrenty List Report
						</td>
					</tr>
				</table>
			
				
				<table style='width:100%; height:40px; border:0px; font-size:18px;'>
					<tr>
						<td> Warrenty List Generate Date : " . date('d-m-Y H:i:s') . "</td>
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

    if ($input_status == 1) {
        $sqlinvoice = $obj->SelectAll("warrenty");
    } elseif ($input_status == 5) {

        $sqlchain_store_ids = $obj->SelectAllByID("store_chain_admin", array("sid" => $input_by));
        if (!empty($sqlchain_store_ids)) {
            $array_ch = array();
            foreach ($sqlchain_store_ids as $ch):
                array_push($array_ch, $ch->store_id);
            endforeach;

            include('class/report_chain_admin.php');
            $obj_report_chain = new chain_report();
            $sqlinvoice = $obj_report_chain->SelectAllByID_Multiple_Or("warrenty", $array_ch, "uid", "1");
        }
        else {
            //echo "Not Work";
            $sqlinvoice = "";
        }
    } else {
        $sqlinvoice = $obj->SelectAllByID("warrenty", array("uid" => $input_by));
    }
    $i = 1;
    if (!empty($sqlinvoice))
        foreach ($sqlinvoice as $invoice):

            $daysgone2 = $obj->daysgone($invoice->date, date('Y-m-d'));
            $have2 = $invoice->warrenty - $daysgone2;

            if ($invoice->type == "ticket") {
                $pp = number_format($ourcost = $obj->SelectAllByVal("ticket_list", "ticket_id", $invoice->warrenty_id, "retail_cost"), 2);
            }

            if ($invoice->type == "checkin") {
                $pp = number_format($ourcost = $obj->SelectAllByVal("checkin_list", "checkin_id", $invoice->warrenty_id, "retail_cost"), 2);
            }

            $html.="<tr>
				<td>" . $i . "</td>
				<td>" . $invoice->warrenty_id . "</td>
				<td>" . $invoice->type . "</td>
				<td>" . $invoice->warrenty . " Days</td>
				<td>" . $have2 . " Days</td>
				<td>" . $invoice->date . "</td>
				<td>" . $pp . "</td>
				<td>" . $invoice->note . "</td>
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
                            ?>
                            <h5><i class="font-home"></i>
                                <span style="border-right:2px #333 solid; padding-right:10px;"> Warranty Report </span>
                                <span><a data-toggle="modal" href="#myModal"> Generate Warranty Report</a></span>

                            </h5>
                        </div><!-- /page header -->

                        <div class="body">

                            <!-- Middle navigation standard -->
                            <?php //include('include/quicklink.php');  ?>
                            <!-- /middle navigation standard -->

                            <!-- Content container -->
                            <div class="container">

                                <!-- Content Start from here customized -->

                                <!-- Dialog content -->
                                <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h5 id="myModalLabel">Generate Warranty Report <span id="mss"></span></h5>
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
                                    <div class="modal-footer">
                                        <form class="form-horizontal" method="get" action="">
                                            <button class="btn btn-primary" name="all" type="submit">Show All Warranty</button>
                                        </form>
                                    </div>
                                </div>
                                <!-- /dialog content -->


                                <!-- General form elements -->
                                <div class="row-fluid block">
                                    <div class="table-overflow">
<?php
                                        /* if ($invoice->type == "ticket") {
                                          ?>
                                          <a href="view_ticket.php?ticket_id=////<?php echo $invoice->warrenty_id; ?>"  target="_blank" onclick="javascript:return confirm('Are you absolutely sure to View This <?php echo $invoice->type; ?> ?')"  class="label label-important"> <?php echo $invoice->warrenty_id; ?></a>
                                          <?php } elseif ($invoice->type == "checkin") { ?>
                                          <a href="view_checkin.php?ticket_id=////<?php echo $invoice->warrenty_id; ?>"  target="_blank" onclick="javascript:return confirm('Are you absolutely sure to View This <?php echo $invoice->type; ?> ?')"  class="label label-important"> <?php echo $invoice->warrenty_id; ?></a>
                                          <?php } */
                                        ?>

                                        <div id="grid" style="margin-left: 10px;margin-right: 10px;"></div>

                                        <script id="warrenty_type" type="text/x-kendo-template">
                                            #if (type=="ticket") 
                                            {# <a  class="k-button"  target="_blank" onclick="javascript:return confirm('Are you absolutely sure to View This Ticket ?')"  href="view_ticket.php?ticket_id=#=warrenty_id#"> #=warrenty_id#</a> #}
                                            else 
                                            {# <a  class="k-button"  target="_blank" onclick="javascript:return confirm('Are you absolutely sure to View This Checkin ?')" href="view_checkin.php?ticket_id=#=warrenty_id#"> #=warrenty_id#</a> #}#
                                        </script>
                                        <script id="edit_client" type="text/x-kendo-template">
                                            <a class="k-button k-button-icontext k-grid-delete" href="warrenty_print.php?warrenty_id=#= warrenty_id #&print_invoice=yes" target="_blank" onclick="javascript:return confirm('Are you absolutely sure to Print This Invoice ?')"><i class="icon-print"></i> Print</a> 
                                            <a class="k-button k-button-icontext k-grid-delete" onclick="javascript:deleteClick(#= id #);" ><span class="k-icon k-delete"></span> Delete</a>
                                        </script>
                                        <script type="text/javascript">
                                            function deleteClick(id) {
                                                var c = confirm("Do you want to delete?");
                                                if (c === true) {
                                                    $.ajax({
                                                        type: "POST",
                                                        dataType: "json",
                                                        url: "./controller/warrenty.php",
                                                        data: {id: id},
                                                        success: function (result) {
                                                            $(".k-i-refresh").click();
                                                        }
                                                    });
                                                }
                                            }

                                        </script>
                                        <?php
                                        $cond = $cms->FrontEndDateSearch('from', 'to');
                                        ?>
                                        <script type="text/javascript">
                                            jQuery(document).ready(function () {
                                                var dataSource = new kendo.data.DataSource({
                                                    transport: {
                                                        read: {
                                                            url: "./controller/warrenty.php<?php echo $cond; ?>",
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
                                                                id: {nullable: true},
                                                                warrenty_id: {type: "number"},
                                                                service: {type: "string"},
                                                                warrenty: {type: "string"},
                                                                warrenty_left: {type: "string"},
                                                                retail_cost: {type: "number"},
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
                                                        {field: "id", title: "W.ID", width: "80px"},
                                                        {template: kendo.template($("#warrenty_type").html()), title: "Warranty-ID", width: "100px"},
                                                        {field: "service", title: "Service", width: "150px"},
                                                        {field: "warrenty", title: "Warrenty", width: "100px"},
                                                        {field: "warrenty_left", title: "W.Left", width: "150px"},
                                                        {field: "date", title: "Date", width: "150px"},
                                                        {field: "retail_cost", title: "Retail Cost", width: "150px"},
                                                        {field: "note", title: "Reason for Warranty", width: "150px"},
                                                        {
                                                            title: "Action", width: "160px",
                                                            template: kendo.template($("#edit_client").html())
                                                        }
                                                    ],
                                                });
                                            });

                                        </script>


                                        








                                    </div>



                                </div>
                                <!-- /general form elements -->



                                <!-- Content End from here customized -->




                                <div class="separator-doubled"></div> 

                                <a href="<?php echo $obj->filename(); ?>?export=excel"><img src="pos_image/file_excel.png"></a>
                                <a href="<?php echo $obj->filename(); ?>?export=pdf"><img src="pos_image/file_pdf.png"></a> 


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