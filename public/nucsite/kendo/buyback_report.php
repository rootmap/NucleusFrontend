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
            $sqlticket = $report->SelectAllDate("buyback", $from, $to, "1");
            $record = $report->SelectAllDate("buyback", $from, $to, "2");
            $record_label = "| Report Generate Between " . $from . " - " . $to;
        } else {
            $sqlticket = $obj->SelectAll("buyback");
            $record = $obj->totalrows("buyback");
            $record_label = "";
        }
    } else {
        if (isset($_GET['from'])) {
            $from = $_GET['from'];
            $to = $_GET['to'];
            $sqlticket = $report->SelectAllDate_Store("buyback", $from, $to, "1", "input_by", $input_by);
            $record = $report->SelectAllDate_Store("buyback", $from, $to, "2", "input_by", $input_by);
            $record_label = "| Report Generate Between " . $from . " - " . $to;
        } else {
            $sqlticket = $obj->SelectAllByID("buyback", array("input_by" => $input_by));
            $record = $obj->exists_multiple("buyback", array("input_by" => $input_by));
            $record_label = "";
        }
    }

    header('Content-type: application/excel');
    $filename = "Buyback_Report_list_" . date('Y_m_d') . '.xls';
    header('Content-Disposition: attachment; filename=' . $filename);

    $data = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">
<head>
    <!--[if gte mso 9]>
    <xml>
        <x:ExcelWorkbook>
            <x:ExcelWorksheets>
                <x:ExcelWorksheet>
                    <x:Name>Buyback Report List : Wireless Geeks Inc.</x:Name>
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
    $data .="<h5>Buyback Report List Generate Date : " . date('d-m-Y H:i:s') . "</h5>";

    $data .="<table>
    <thead>
        <tr style='background:#09f; color:#fff;'>
		<th>#</th>
		<th>BuyBack ID</th>
		<th>Customer</th>
		<th>Model</th>
		<th>Carrier</th>
		<th>IMEI</th>
		<th>Price</th>
		<th>Payment Method</th>
		<th>Date</th>
		</tr>
</thead>
<tbody>";

    $i = 1;
    $a1 = 0;
    $a2 = 0;
    $dd3 = 0;
    $dd4 = 0;
    $dd5 = 0;
    if (!empty($sqlticket))
        foreach ($sqlticket as $ticket):
            $a1+=1;
            $a2+=$ticket->price;
            if ($ticket->payment_method == 3) {
                $dd3+=$ticket->price;
            } elseif ($ticket->payment_method == 4) {
                $dd4+=$ticket->price;
            } elseif ($ticket->payment_method == 5) {
                $dd5+=$ticket->price;
            }
            $data.="<tr>
				<td>" . $i . "</td>
				<td>" . $ticket->buyback_id . "</td>
				<td>" . $obj->SelectAllByVal("coustomer", "id", $ticket->uid, "firstname") . " " . $obj->SelectAllByVal("coustomer", "id", $ticket->uid, "lastname") . "</td>
				<td>" . $ticket->model . "</td>
				<td>" . $ticket->carrier . "</td>
				<td>" . $ticket->imei . "</td>
				<td>" . $ticket->price . "</td>
				<td>" . $obj->SelectAllByVal("payment_method", "id", $ticket->payment_method, "meth_name") . "</td>
				<td>" . $ticket->date . "</td>
			</tr>";

            $i++;
        endforeach;

    $data .="</tbody><tfoot><tr>
		<th>#</th>
		<th>BuyBack ID</th>
		<th>Customer</th>
		<th>Model</th>
		<th>Carrier</th>
		<th>IMEI</th>
		<th>Price</th>
		<th>Payment Method</th>
		<th>Date</th>
		</tr></tfoot></table>";

    $data.="<table border='0' width='250' style='width:200px;'>
					<tbody>
						<tr>
							<td>1. Total Quantity = <strong> " . $a1 . "</strong></td>
						</tr>
						<tr>
							<td>2. Total Price = <strong> $" . number_format($a2, 2) . "</strong></td>
						</tr>
						<tr>
							<td>3. In Cash = <strong> $" . number_format($dd3, 2) . "</strong></td>
						</tr>
						<tr>
							<td>4. In Cradit Card = <strong> $" . number_format($dd4, 2) . "</strong></td>
						</tr>
						<tr>
							<td>5. In Check  = <strong> $" . number_format($dd5, 2) . "</strong></td>
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
            $sqlticket = $report->SelectAllDate("buyback", $from, $to, "1");
            $record = $report->SelectAllDate("buyback", $from, $to, "2");
            $record_label = "| Report Generate Between " . $from . " - " . $to;
        } else {
            $sqlticket = $obj->SelectAll("buyback");
            $record = $obj->totalrows("buyback");
            $record_label = "";
        }
    } else {
        if (isset($_GET['from'])) {
            $from = $_GET['from'];
            $to = $_GET['to'];
            $sqlticket = $report->SelectAllDate_Store("buyback", $from, $to, "1", "input_by", $input_by);
            $record = $report->SelectAllDate_Store("buyback", $from, $to, "2", "input_by", $input_by);
            $record_label = "| Report Generate Between " . $from . " - " . $to;
        } else {
            $sqlticket = $obj->SelectAllByID("buyback", array("input_by" => $input_by));
            $record = $obj->exists_multiple("buyback", array("input_by" => $input_by));
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
						Buyback Report List Report
						</td>
					</tr>
				</table>


				<table style='width:100%; height:40px; border:0px; font-size:18px;'>
					<tr>
						<td>Buyback Report List Generate Date : " . date('d-m-Y H:i:s') . "</td>
					</tr>
				</table>
				<table style='width:960px;border:1px; font-size:12px; background:#ccc;'>";
    $html.="<thead>

        <tr style='background:#09f; color:#fff;'>
		<th>#</th>
		<th>BuyBack ID</th>
		<th>Customer</th>
		<th>Model</th>
		<th>Carrier</th>
		<th>IMEI</th>
		<th>Price</th>
		<th>Payment Method</th>
		<th>Date</th>
		</tr>
</thead>
<tbody>";


    $i = 1;
    $a1 = 0;
    $a2 = 0;
    $dd3 = 0;
    $dd4 = 0;
    $dd5 = 0;
    if (!empty($sqlticket))
        foreach ($sqlticket as $ticket):
            $a1+=1;
            $a2+=$ticket->price;
            if ($ticket->payment_method == 3) {
                $dd3+=$ticket->price;
            } elseif ($ticket->payment_method == 4) {
                $dd4+=$ticket->price;
            } elseif ($ticket->payment_method == 5) {
                $dd5+=$ticket->price;
            }
            $html.="<tr>
				<td>" . $i . "</td>
				<td>" . $ticket->buyback_id . "</td>
				<td>" . $obj->SelectAllByVal("coustomer", "id", $ticket->uid, "firstname") . " " . $obj->SelectAllByVal("coustomer", "id", $ticket->uid, "lastname") . "</td>
				<td>" . $ticket->model . "</td>
				<td>" . $ticket->carrier . "</td>
				<td>" . $ticket->imei . "</td>
				<td>" . $ticket->price . "</td>
				<td>" . $obj->SelectAllByVal("payment_method", "id", $ticket->payment_method, "meth_name") . "</td>
				<td>" . $ticket->date . "</td>
			</tr>";

            $i++;
        endforeach;

    $html.="</tbody><tfoot><tr>
		<th>#</th>
		<th>BuyBack ID</th>
		<th>Customer</th>
		<th>Model</th>
		<th>Carrier</th>
		<th>IMEI</th>
		<th>Price</th>
		<th>Payment Method</th>
		<th>Date</th>
		</tr></tfoot></table>";

    $html.="<table border='0'  width='250' style='width:200px;'>
					<tbody>
						<tr>
							<td>1. Total Quantity = <strong> " . $a1 . "</strong></td>
						</tr>
						<tr>
							<td>2. Total Price = <strong> $" . number_format($a2, 2) . "</strong></td>
						</tr>
						<tr>
							<td>3. In Cash = <strong> $" . number_format($dd3, 2) . "</strong></td>
						</tr>
						<tr>
							<td>4. In Cradit Card = <strong> $" . number_format($dd4, 2) . "</strong></td>
						</tr>
						<tr>
							<td>5. In Check  = <strong> $" . number_format($dd5, 2) . "</strong></td>
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
                <?php
                echo $obj->ShowMsg();
                ?>
                <!-- /info notice -->

                <div class="outer">
                    <div class="inner">
                        <div class="page-header"><!-- Page header -->
                            <h5>
                                <i class="font-share"></i> 
                                <span style="border-right:2px #333 solid; padding-right:10px;"> BuyBack Report </span>
                                <span><i class="font-calendar"></i> <a data-toggle="modal" href="#myModal"> Generate BuyBack Custom Date Report</a></span>
                            </h5>
                        </div><!-- /page header -->

                        <!-- Dialog content -->
                        <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h5 id="myModalLabel"><i class="font-calendar"></i> Generate BuyBack Report <span id="mss"></span></h5>
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

                        <div class="body">

                            <!-- Middle navigation standard -->
                            <?php //include('include/quicklink.php'); ?>
                            <!-- /middle navigation standard -->

                            <!-- Content container -->
                            <div class="container">

                                <!-- Content Start from here customized -->




                                <!-- General form elements -->
                                <div class="row-fluid block">


                                    <div class="table-overflow">

                                        <div id="grid" style="margin-left: 10px;margin-right: 10px;"></div>
                                        <script id="buyback_link" type="text/x-kendo-template">
                                            <a class="k-button k-button-icontext k-grid-delete" href="view_buyback.php?buyback_id=#=buyback_id#">#=buyback_id#</a>
                                        </script>
                                        <script id="edit_client" type="text/x-kendo-template">
                                            <a class="k-button k-button-icontext k-grid-delete" href="view_buyback.php?print_invoice=#=buyback_id#"><i class="icon-print"></i> Print</a> 
                                        </script>
                                        <script type="text/javascript">
                                            function deleteClick(id) {
                                                var c = confirm("Do you want to delete?");
                                                if (c === true) {
                                                    $.ajax({
                                                        type: "POST",
                                                        dataType: "json",
                                                        url: "./controller/buyback.php",
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
                                                            url: "./controller/buyback_report.php<?php echo $cond; ?>",
                                                            type: "GET",
                                                            datatype: "json",
                                                            complete: function (response) {
                                                                var page_quantity=0;
                                                                var page_amount=0;
                                                                var page_cash=0;
                                                                var page_creditcard=0;
                                                                var page_check=0;
                                                                jQuery.each(response, function (index, key) {
                                                                    if (index == 'responseJSON')
                                                                    {
                                                                        //console.log(key.data);
                                                                        jQuery.each(key.data, function (datagr, keyg) {
                                                                            console.log(keyg.lcdcondition);
                                                                            page_quantity += (1 - 0);
                                                                            page_amount +=(parseFloat(keyg.price)-0);
                                                                            if(keyg.payment_method=="Cash")
                                                                            {
                                                                                page_cash +=(parseFloat(keyg.price)-0);
                                                                            }
                                                                            
                                                                            if(keyg.payment_method=="Credit Card")
                                                                            {
                                                                                page_creditcard +=(parseFloat(keyg.price)-0);
                                                                            }
                                                                            
                                                                            if(keyg.payment_method=="Check")
                                                                            {
                                                                                page_check +=(parseFloat(keyg.price)-0);
                                                                            }
                                                                            
                                                                            
                                                                            
                                                                        });
                                                                        //console.log(page_ourcost);
                                                                        jQuery("#a1").html(page_quantity + "  of  " + key.total);
                                                                        jQuery("#a2").html("<?php echo $currencyicon; ?>"+page_amount);
                                                                        jQuery("#a3").html("<?php echo $currencyicon; ?>"+page_cash);
                                                                        jQuery("#a4").html("<?php echo $currencyicon; ?>"+page_creditcard);
                                                                        jQuery("#a5").html("<?php echo $currencyicon; ?>"+page_check);

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
                                                                buyback_id: {type: "string"},
                                                                customer: {type: "string"},
                                                                model: {type: "string"},
                                                                carrier: {type: "string"},
                                                                imei: {type: "string"},
                                                                price: {type: "string"},
                                                                payment_method: {type: "string"},
                                                                date: {type: "string"},
                                                                process: {type: "string"}
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
                                                        {field: "id", title: "B.ID", width: "60px"},
                                                        {template: kendo.template($("#buyback_link").html()), title: "Buyback ID", width: "100px"},
                                                        {field: "customer", title: "Customer", width: "100px"},
                                                        {field: "model", title: "Model", width: "100px"},
                                                        {field: "carrier", title: "Carrier", width: "100px"},
                                                        {field: "imei", title: "Imei", width: "100px"},
                                                        {template: "<?php echo $currencyicon; ?>#=price#", title: "Price", width: "60px"},
                                                        {field: "payment_method", title: "Payment", width: "70px"},
                                                        {field: "date", title: "Date", width: "90px"},
                                                        {
                                                            title: "Action", width: "100px",
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
                                            JSONToCSVConvertor(json_data, "BuyBack Report List", true);

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
                                            var fileName = "buyback_report_list_";
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
                                      <th>BuyBack ID</th>
                                      <?php if ($input_status == 1 || $input_status == 5) { ?>
                                      <th>Store</th>
                                      <?php } ?>
                                      <th>Customer</th>
                                      <th>Model</th>
                                      <th>Carrier</th>
                                      <th>IMEI</th>
                                      <th>Price</th>
                                      <th>Payment Method</th>
                                      <th>Date</th>
                                      </tr>
                                      </thead>
                                      <tbody>
                                      <?php
                                      $i = 1;
                                      $a1 = 0;
                                      $a2 = 0;
                                      $dd3 = 0;
                                      $dd4 = 0;
                                      $dd5 = 0;
                                      if (!empty($sqlticket))
                                      foreach ($sqlticket as $ticket):
                                      $a1+=1;
                                      $a2+=$ticket->price;
                                      ?>
                                      <tr>
                                      <td><?php echo $i; ?></td>
                                      <td><a class="label label-success" href="view_buyback.php?buyback_id=<?php echo $ticket->buyback_id; ?>"><i class="icon-tags"></i> <?php echo $ticket->buyback_id; ?></a></td>
                                      <?php if ($input_status == 1 || $input_status == 5) { ?>
                                      <td><?php echo $obj->SelectAllByVal("store", "store_id", $ticket->input_by, "name"); ?></td>
                                      <?php } ?>
                                      <td><i class="icon-user"></i> <?php echo $obj->SelectAllByVal("coustomer", "id", $ticket->uid, "firstname") . " " . $obj->SelectAllByVal("coustomer", "id", $ticket->uid, "lastname"); ?></td>
                                      <td><?php echo $ticket->model; ?></td>
                                      <td><?php echo $ticket->carrier; ?></td>
                                      <td><?php echo $ticket->imei; ?></td>
                                      <td><?php
                                      echo $ticket->price;
                                      if ($ticket->payment_method == 3) {
                                      $dd3+=$ticket->price;
                                      } elseif ($ticket->payment_method == 4) {
                                      $dd4+=$ticket->price;
                                      } elseif ($ticket->payment_method == 5) {
                                      $dd5+=$ticket->price;
                                      }
                                      ?></td>
                                      <td><?php echo $obj->SelectAllByVal("payment_method", "id", $ticket->payment_method, "meth_name"); ?></td>
                                      <td><label class="label label-info"><i class="icon-calendar"></i> <?php echo $ticket->date; ?></label></td>

                                      </tr>
                                      <?php
                                      $i++;
                                      endforeach;
                                      ?>
                                      </tbody>
                                      </table>
                                      </div> */ ?>


                                    <!-- Table condensed -->

                                    <div class="block well span12" style="margin-left:0; margin-top:20px;">
                                        <div class="navbar">
                                            <div class="navbar-inner">
                                                <h5> BuyBack Report Summary</h5>
                                            </div>
                                        </div>
                                        <div class="table-overflow">
                                            <table class="table table-condensed">
                                                <tbody>
                                                    <tr>
                                                        <td>1. Total Quantity = <strong id="a1"> <?php echo 0; ?></strong></td>
                                                    
                                                        <td>2. Total Price = <strong id="a2"> $<?php echo 0; ?></strong></td>
                                                    
                                                        <td>3. In Cash = <strong id="a3"> $<?php echo 0; ?></strong></td>
                                                    
                                                        <td>4. In Cradit Card = <strong id="a4"> $<?php echo 0; ?></strong></td>
                                                    
                                                        <td>5. In Check  = <strong id="a5"> $<?php echo 0; ?></strong></td>
                                                    </tr>
                                                    <?php ?>

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

        </div>
        <!-- /main wrapper -->

    </body>
</html>
