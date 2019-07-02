<?php
include('class/auth.php');
if (isset($_GET['del'])) {
    $sid = $obj->SelectAllByVal("invoice", "id", $_GET['del'], "invoice_id");
    if ($obj->delete("sales", array("sales_id" => $sid))) {
        $obj->deletesing("id", $_GET['del'], "invoice");
    } else {
        $obj->Error("Failed To Delete Sales Record", $obj->filename());
    }
}
if (@$_GET['export'] == "excel") {
    $record_label = "Sales List Report";
    header('Content-type: application/excel');
    $filename = "Sales_list_" . date('Y_m_d') . '.xls';
    header('Content-Disposition: attachment; filename=' . $filename);

    $data = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">
<head>
    <!--[if gte mso 9]>
    <xml>
        <x:ExcelWorkbook>
            <x:ExcelWorksheets>
                <x:ExcelWorksheet>
                    <x:Name>Sales List : Wireless Geeks Inc.</x:Name>
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
    $data .="<h5>Sales List Generate Date : " . date('d-m-Y H:i:s') . "</h5>";

    $data .="<table>
    <thead>
        <tr style='background:#09f; color:#fff;'>
			<th>#</th>
			<th>Invoice-ID</th>
			<th>Customer</th>
			<th>Tender</th>
			<th>Status</th>
			<th>Date</th>
			<th>Item</th>
			<th>Total</th>
		</tr>
</thead>
<tbody>";


    if ($input_status == 1) {
        $sqlinvoice = $obj->SelectAllByID_Multiple("invoice", array("doc_type" => 3));
    } elseif ($input_status == 5) {

        $sqlchain_store_ids = $obj->SelectAllByID("store_chain_admin", array("sid" => $input_by));
        if (!empty($sqlchain_store_ids)) {
            $array_ch = array();
            foreach ($sqlchain_store_ids as $ch):
                array_push($array_ch, $ch->store_id);
            endforeach;

            include('class/report_chain_admin.php');
            $obj_report_chain = new chain_report();
            $sqlinvoice = $obj_report_chain->SelectAllByID_Multiple_Or_array("invoice", array("doc_type" => 3), $array_ch, "input_by", "1");
        }
        else {
            //echo "Not Work";
            $sqlinvoice = "";
        }
    } else {
        $sqlinvoice = $obj->SelectAllByID_Multiple("invoice", array("doc_type" => 3, "input_by" => $input_by));
    }
    $i = 1;
    if (!empty($sqlinvoice))
        foreach ($sqlinvoice as $invoice):
            ?>
            <?php
            if ($input_status == 1) {
                $sqlitem = $obj->SelectAllByID_Multiple("sales", array("sales_id" => $invoice->invoice_id));
            } else {
                $sqlitem = $obj->SelectAllByID_Multiple("sales", array("sales_id" => $invoice->invoice_id, "input_by" => $input_by));
            }
            $item_q = 0;
            $total = 0;
            if (!empty($sqlitem))
                foreach ($sqlitem as $item):
                    $rr = $item->quantity * $item->single_cost;
                    $taxchk = $obj->SelectAllByVal("pos_tax", "invoice_id", $invoice->invoice_id, "status");
                    if ($taxchk == 0) {
                        $tax = 0;
                    } else {
                        $tax = ($rr * $tax_per_product) / 100;
                    }

                    $tot = $rr + $tax;
                    $total+=$tot;
                    $item_q+=$item->quantity;
                endforeach;
            if ($total != 0) {

                $chkpayment_id = $obj->SelectAllByVal("invoice_payment", "invoice_id", $invoice->invoice_id, "payment_type");

                $data.="<tr>
				<td>" . $i . "</td>
				<td>" . $invoice->invoice_id . "</td>
				<td>" . $obj->SelectAllByVal("coustomer", "id", $invoice->cid, "businessname") . "-" . $obj->SelectAllByVal("coustomer", "id", $invoice->cid, "firstname") . "" . $obj->SelectAllByVal("coustomer", "id", $invoice->cid, "lastname") . "</td>
				<td>" . $obj->SelectAllByVal("payment_method", "id", $chkpayment_id, "meth_name") . "</td>
				<td>" . $obj->invoice_paid_status($invoice->status) . "</td>
				<td>" . $invoice->date . "</td>
				<td>" . $item_q . "</td>
				<td>" . number_format($total, 2) . "</td>
			</tr>";
                $i++;
            }
        endforeach;

    $data .="</tbody><tfoot><tr>
			<th>#</th>
			<th>Invoice-ID</th>
			<th>Customer</th>
			<th>Tender</th>
			<th>Status</th>
			<th>Date</th>
			<th>Item</th>
			<th>Total</th>
		</tr></tfoot></table>";

    $data .='</body></html>';

    echo $data;
}

if (@$_GET['export'] == "pdf") {
    $record_label = "Sales List Report";
    include("pdf/MPDF57/mpdf.php");
    extract($_GET);
    $html.="<table id='sample-table-2' class='table table-hover' border='0'><tbody>";
    $html .="<tr>
			<td valign='top' style='margin:0; padding:0; width:100%;'>
				<table style='width:100%; height:40px; border:0px;'>
					<tr>
						<td width='87%' style='background:rgba(0,51,153,1);  color:#FFF; font-size:25px;'>
						Sales List Report
						</td>
					</tr>
				</table>


				<table style='width:100%; height:40px; border:0px; font-size:18px;'>
					<tr>
						<td> Sales List Generate Date : " . date('d-m-Y H:i:s') . "</td>
					</tr>
				</table>
				<table style='width:960px;border:1px; font-size:12px; background:#ccc;'>";
    $html.="<thead>
        <tr style='background:#09f; color:#fff;'>
			<th>#</th>
			<th>Invoice-ID</th>
			<th>Customer</th>
			<th>Tender</th>
			<th>Status</th>
			<th>Date</th>
			<th>Item</th>
			<th>Total</th>
		</tr>
</thead>
<tbody>";

    if ($input_status == 1) {
        $sqlinvoice = $obj->SelectAllByID_Multiple("invoice", array("doc_type" => 3));
    } elseif ($input_status == 5) {

        $sqlchain_store_ids = $obj->SelectAllByID("store_chain_admin", array("sid" => $input_by));
        if (!empty($sqlchain_store_ids)) {
            $array_ch = array();
            foreach ($sqlchain_store_ids as $ch):
                array_push($array_ch, $ch->store_id);
            endforeach;

            include('class/report_chain_admin.php');
            $obj_report_chain = new chain_report();
            $sqlinvoice = $obj_report_chain->SelectAllByID_Multiple_Or_array("invoice", array("doc_type" => 3), $array_ch, "input_by", "1");
        }
        else {
            //echo "Not Work";
            $sqlinvoice = "";
        }
    } else {
        $sqlinvoice = $obj->SelectAllByID_Multiple("invoice", array("doc_type" => 3, "input_by" => $input_by));
    }
    $i = 1;
    if (!empty($sqlinvoice))
        foreach ($sqlinvoice as $invoice):
            ?>
            <?php
            if ($input_status == 1) {
                $sqlitem = $obj->SelectAllByID_Multiple("sales", array("sales_id" => $invoice->invoice_id));
            } else {
                $sqlitem = $obj->SelectAllByID_Multiple("sales", array("sales_id" => $invoice->invoice_id, "input_by" => $input_by));
            }
            $item_q = 0;
            $total = 0;
            if (!empty($sqlitem))
                foreach ($sqlitem as $item):
                    $rr = $item->quantity * $item->single_cost;
                    $taxchk = $obj->SelectAllByVal("pos_tax", "invoice_id", $invoice->invoice_id, "status");
                    if ($taxchk == 0) {
                        $tax = 0;
                    } else {
                        $tax = ($rr * $tax_per_product) / 100;
                    }

                    $tot = $rr + $tax;
                    $total+=$tot;
                    $item_q+=$item->quantity;
                endforeach;
            if ($total != 0) {

                $chkpayment_id = $obj->SelectAllByVal("invoice_payment", "invoice_id", $invoice->invoice_id, "payment_type");

                $html.="<tr>
				<td>" . $i . "</td>
				<td>" . $invoice->invoice_id . "</td>
				<td>" . $obj->SelectAllByVal("coustomer", "id", $invoice->cid, "businessname") . "-" . $obj->SelectAllByVal("coustomer", "id", $invoice->cid, "firstname") . "" . $obj->SelectAllByVal("coustomer", "id", $invoice->cid, "lastname") . "</td>
				<td>" . $obj->SelectAllByVal("payment_method", "id", $chkpayment_id, "meth_name") . "</td>
				<td>" . $obj->invoice_paid_status($invoice->status) . "</td>
				<td>" . $invoice->date . "</td>
				<td>" . $item_q . "</td>
				<td>" . number_format($total, 2) . "</td>
			</tr>";
                $i++;
            }
        endforeach;

    $html.="</tbody><tfoot><tr>
			<th>#</th>
			<th>Invoice-ID</th>
			<th>Customer</th>
			<th>Tender</th>
			<th>Status</th>
			<th>Date</th>
			<th>Item</th>
			<th>Total</th>
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
                            <h5><i class="icon-th-list"></i>
                                <span style="border-right:2px #333 solid; padding-right:10px;">Pos Sales List </span>
                                <span><i class="font-calendar"></i> <a data-toggle="modal" href="#myModal"> Generate Parts Order Report</a></span>

                            </h5>
                            <ul class="icons">
                                <li><a href="<?php echo $obj->filename(); ?>" class="hovertip" title="Reload"><i class="font-refresh"></i></a></li>
                            </ul>
                        </div><!-- /page header -->

                        <div class="body">

                            <!-- Middle navigation standard -->
                            <?php //include('include/quicklink.php');   ?>
                            <!-- /middle navigation standard -->
                            <!-- Dialog content -->
                            <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h5 id="myModalLabel"><i class="font-calendar"></i> Generate Sales list Report <span id="mss"></span></h5>
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
                            <!-- Content container -->
                            <div class="container">
                                <!-- Content Start from here customized -->
                                <!-- Default datatable -->
                                <div class="block">

                                    <div class="table-overflow">

                                        <div id="grid" style="margin-left: 10px;margin-right: 10px;"></div>
                                        <script id="checkin_link" type="text/x-kendo-template">
                                            <a href="view_sales.php?invoice=#=invoice_id#">#=invoice_id#</a>
                                        </script>
                                        <script id="checkin_status" type="text/x-kendo-template">

                                        </script>
                                        <script id="status" type="text/x-kendo-template">
                                            #if(status==0){#
                                            <label class="label label-danger">Not Yet</label> 
                                            #}else if(status==1){#
                                            <label class="label label-success"> Paid </label> 
                                            #}else if(status==2){#
                                            <label class="label label-success"> Paid </label>
                                            #}else if(status==3){#
                                            <label class="label label-warning"> Partial </label>
                                            #}#
                                        </script>
                                        <script id="edit_client" type="text/x-kendo-template">
<?php if ($input_status == 1 || $input_status == 2 || $input_status == 5) { ?>
                                                <a target="_blank" href="pos.php?action=pdf&invoice=#=invoice_id#&print=1" class="hovertip" title="Print" onclick="javascript:return confirm('Are you absolutely sure to Print This Sales ?')"><i class="icon-print"></i></a>

                                                <a href="<?php echo $obj->filename(); ?>?del=#=id#" class="hovertip" title="Delete" onclick="javascript:return confirm('Are you absolutely sure to delete This Sales ?')"><i class="icon-trash"></i></a>
<?php } else { ?>
                                                <a target="_blank" href="pos.php?action=pdf&invoice=#=invoice_id#" class="hovertip" title="Print" onclick="javascript:return confirm('Are you absolutely sure to Print This Sales ?')"><i class="icon-print"></i></a>
<?php } ?>
                                        </script>
                                        <script type="text/javascript">
                                            function deleteClick(id) {
                                                var c = confirm("Do you want to delete?");
                                                if (c === true) {
                                                    $.ajax({
                                                        type: "POST",
                                                        dataType: "json",
                                                        url: "./controller/sales_list.php",
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
                                            var gridElement = $("#grid");

                                            function showLoading(e) {
                                                kendo.ui.progress(gridElement, true);
                                            }

                                            function restoreSelection(e) {
                                                kendo.ui.progress(gridElement, false);
                                            }

                                            jQuery(document).ready(function () {

                                                var dataSource = new kendo.data.DataSource({
                                                    requestStart: showLoading,
                                                    transport: {
                                                        read: {
                                                            url: "./controller/sales_list.php<?php echo $cond; ?>",
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
                                                                invoice_id: {type: "string"},
                                                                customer: {type: "string"},
                                                                pty: {type: "string"},
                                                                status: {type: "string"},
                                                                paid_amount: {type: "string"},
                                                                date: {type: "string"},
                                                                quantity: {type: "number"},
                                                                sales_amount: {type: "string"}
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
                                                    dataBound: restoreSelection,
                                                    pageable: {
                                                        refresh: true,
                                                        input: true,
                                                        numeric: false,
                                                        pageSizes: true,
                                                        pageSizes:[10, 50, 200, 500, 1000, 5000, 10000]
                                                    },
                                                    sortable: true,
                                                    groupable: true,
                                                    columns: [
                                                        {field: "id", title: "S.ID", width: "60px"},
                                                        {title: "Invoice-ID", width: "90px", template: kendo.template($("#checkin_link").html())},
                                                        {field: "customer", title: "Customer", width: "90px"},
                                                        {field: "pty", title: "Tender", width: "80px"},
                                                        {title: "Status", width: "90px", template: kendo.template($("#status").html())},
                                                        {field: "date", title: "Date", width: "50px"},
                                                        {title: "Item", width: "50px", field: "quantity"},
                                                        {template: "<?php echo $currencyicon; ?>#=sales_amount#", title: "Total", width: "50px"},
                                                        {
                                                            title: "Action", width: "60px",
                                                            template: kendo.template($("#edit_client").html())
                                                        }
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
                                            JSONToCSVConvertor(json_data, "Sales List", true);

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
                                            var fileName = "sales_list_";
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
                                      <th>Invoice-ID</th>
                                      <th>Customer</th>
                                      <th>Tender</th>
                                      <th>Status</th>
                                      <th>Date</th>
                                      <th>Item</th>
                                      <th>Total</th>

                                      <th>Action</th>
                                      </tr>
                                      </thead>
                                      <tbody>
                                      <?php
                                      if ($input_status == 1) {
                                      if (isset($_GET['from'])) {
                                      include('class/report_customer.php');
                                      $obj_report=new report();
                                      $sql_coustomer=$obj_report->ReportQuery_Datewise("invoice", array("doc_type"=>3), $_GET['from'], $_GET['to'], "1");
                                      }elseif (isset($_GET['all'])) {
                                      $sql_coustomer=$obj->SelectAllByID_Multiple("invoice", array("doc_type"=>3));
                                      }else {
                                      $sql_coustomer=$obj->SelectAllByID_Multiple("invoice", array("doc_type"=>3, "date"=>date('Y-m-d')));
                                      }
                                      }elseif ($input_status == 5) {

                                      $sqlchain_store_ids=$obj->SelectAllByID("store_chain_admin", array("sid"=>$input_by));
                                      if (!empty($sqlchain_store_ids)) {
                                      $array_ch=array();
                                      foreach ($sqlchain_store_ids as $ch):
                                      array_push($array_ch, $ch->store_id);
                                      endforeach;

                                      if (isset($_GET['from'])) {
                                      include('class/report_chain_admin.php');
                                      $obj_report_chain=new chain_report();
                                      $sql_coustomer=$obj_report_chain->ReportQuery_Datewise_Or_array("invoice", array("doc_type"=>3), $array_ch, "input_by", $_GET['from'], $_GET['to'], "1");
                                      }elseif (isset($_GET['all'])) {
                                      include('class/report_chain_admin.php');
                                      $obj_report_chain=new chain_report();
                                      $sql_coustomer=$obj_report_chain->SelectAllByID_Multiple_Or_array("invoice", array("doc_type"=>3), $array_ch, "input_by", "1");
                                      }else {
                                      include('class/report_chain_admin.php');
                                      $obj_report_chain=new chain_report();
                                      $sql_coustomer=$obj_report_chain->SelectAllByID_Multiple2_Or("invoice", array("doc_type"=>3, "date"=>date('Y-m-d')), $array_ch, "input_by", "1");
                                      }
                                      //echo "Work";
                                      }else {
                                      //echo "Not Work";
                                      $sql_coustomer="";
                                      }
                                      }else {
                                      if (isset($_GET['from'])) {
                                      include('class/report_customer.php');
                                      $obj_report=new report();
                                      $sql_coustomer=$obj_report->ReportQuery_Datewise("invoice", array("doc_type"=>3, "input_by"=>$input_by), $_GET['from'], $_GET['to'], "1");
                                      }elseif (isset($_GET['all'])) {
                                      $sql_coustomer=$obj->SelectAllByID_Multiple("invoice", array("doc_type"=>3, "input_by"=>$input_by));
                                      }else {
                                      $sql_coustomer=$obj->SelectAllByID_Multiple("invoice", array("doc_type"=>3, "input_by"=>$input_by, "date"=>date('Y-m-d')));
                                      }
                                      }

                                      $i=1;
                                      if (!empty($sql_coustomer)) {
                                      foreach ($sql_coustomer as $invoice):
                                      ?>
                                      <?php
                                      $sqlitem=$obj->SelectAllByID_Multiple("sales", array("sales_id"=>$invoice->invoice_id));
                                      $item_q=0;
                                      $total=0;
                                      if (!empty($sqlitem))
                                      foreach ($sqlitem as $item):
                                      $rr=$item->quantity * $item->single_cost;
                                      $taxchk=$obj->SelectAllByVal("pos_tax", "invoice_id", $invoice->invoice_id, "status");
                                      if ($taxchk == 0) {
                                      $tax=0;
                                      }else {
                                      $tax=($rr * $tax_per_product) / 100;
                                      }

                                      $tot=$rr + $tax;
                                      $total+=$tot;
                                      $item_q+=$item->quantity;
                                      endforeach;
                                      if ($total != 0) {

                                      $paidamountsql=$obj->SelectAllByID_Multiple("invoice_payment", array("invoice_id"=>$invoice->invoice_id));
                                      $paidamount_invoice=0;
                                      if (!empty($paidamountsql))
                                      foreach ($paidamountsql as $paiddata):
                                      $paidamount_invoice+=$paiddata->amount;
                                      endforeach;
                                      ?>
                                      <tr>
                                      <td><?php echo $i; ?></td>
                                      <td><a href="view_sales.php?invoice=<?php echo $invoice->invoice_id; ?>" class="label label-important"><i class="font-money"></i> <?php echo $invoice->invoice_id; ?></a></td>
                                      <td><?php echo $obj->SelectAllByVal("coustomer", "id", $invoice->cid, "businessname") . "-" . $obj->SelectAllByVal("coustomer", "id", $invoice->cid, "firstname") . "" . $obj->SelectAllByVal("coustomer", "id", $invoice->cid, "lastname"); ?></td>
                                      <td><label class="label label-info">
                                      <?php
                                      $chkpayment_id=$obj->SelectAllByVal("invoice_payment", "invoice_id", $invoice->invoice_id, "payment_type");
                                      echo $obj->SelectAllByVal("payment_method", "id", $chkpayment_id, "meth_name");
                                      ?>
                                      </label>
                                      </td>
                                      <td><label <?php if ($invoice->status == 1) { ?>  class="label label-success"<?php }elseif ($invoice->status == 3) { ?>   class="label label-warning" <?php } ?>> <?php echo $obj->invoice_paid_status($invoice->status); ?> </label></td>
                                      <td><label class="label label-primary"><i class="icon-calendar"></i> <?php echo $invoice->date; ?></label></td>
                                      <td><?php echo $item_q; ?></td>
                                      <td><?php
                                      if ($paidamount_invoice >= $total) {
                                      echo "$" . number_format($paidamount_invoice, 2);
                                      }else {
                                      $dueamin=$total - $paidamount_invoice;
                                      ?>
                                      <a href="pos_make_new_cart.php?cart_id=<?php echo $invoice->invoice_id; ?>" class="btn btn-info">$<?php echo $dueamin; ?> Send To Pos</a>
                                      <?php
                                      }
                                      ?></td>
                                      <td>
                                      <?php if ($input_status == 1 || $input_status == 2 || $input_status == 5) { ?>
                                      <a target="_blank" href="pos.php?action=pdf&invoice=<?php echo $invoice->invoice_id; ?>&print=1" class="hovertip" title="Print" onclick="javascript:return confirm('Are you absolutely sure to Print This Sales ?')"><i class="icon-print"></i></a>

                                      <a href="<?php echo $obj->filename(); ?>?del=<?php echo $invoice->id; ?>" class="hovertip" title="Delete" onclick="javascript:return confirm('Are you absolutely sure to delete This Sales ?')"><i class="icon-trash"></i></a>
                                      <?php }else { ?>
                                      <a target="_blank" href="pos.php?action=pdf&invoice=<?php echo $invoice->invoice_id; ?>" class="hovertip" title="Print" onclick="javascript:return confirm('Are you absolutely sure to Print This Sales ?')"><i class="icon-print"></i></a>
                                      <?php } ?>
                                      </td>
                                      </tr>
                                      <?php
                                      $i++;
                                      } endforeach;
                                      }
                                      ?>
                                      </tbody>
                                      </table>
                                      </div> */ ?>
                                </div>
                                <!-- /default datatable -->


                                <!-- Content End from here customized -->




                                <div class="separator-doubled"></div>


                                <a id="export-grid" href="javascript:void(0);"><img src="pos_image/file_excel.png"></a>
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

        </div>
        <!-- /main wrapper -->

    </body>
</html>
