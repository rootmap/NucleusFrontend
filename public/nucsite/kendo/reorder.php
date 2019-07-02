<?php
include('class/auth.php');
if ($input_status == 1) {
    $sqlproduct=$obj->FlyQuery("SELECT a.id,
    a.pid as pid,
    p.name,
    a.store_id,
    p.barcode,
    p.price_cost,
    p.price_retail,
    a.stock as quantity FROM `reorder` as a
    LEFT JOIN product as p on p.id=a.pid 
    ORDER BY p.name ASC");
}elseif ($input_status == 5) {

    $sqlchain_store_ids=$obj->SelectAllByID("store_chain_admin", array("sid"=>$input_by));
    if (!empty($sqlchain_store_ids)) {

        $sqlstring="SELECT a.id,
        a.pid as pid,
        p.name,
        a.store_id,
        p.barcode,
        p.price_cost,
        p.input_by,
        p.price_retail,
        a.stock as quantity FROM `reorder` as a
        LEFT JOIN product as p on p.id=a.pid ";

        $countstore=count($sqlchain_store_ids);
        $s=1;
        foreach ($sqlchain_store_ids as $ch):
            if ($s == $countstore) {
                $sqlstring .="a.store_id='" . $ch->store_id . "'";
            }else {
                $sqlstring .="a.store_id='" . $ch->store_id . "' AND ";
            }
            $s++;
        endforeach;

        $sqlstring .=" ORDER BY p.name ASC";

        $sqlproduct=$obj->FlyQuery($sqlstring);
        //echo "Work";
    }else {
        //echo "Not Work";
        $sqlproduct=array();
    }
}else {
    $sqlproduct=$obj->FlyQuery("SELECT a.id,
    a.pid as pid,
    p.name,
    a.store_id,
    p.barcode,
    p.price_cost,
    p.input_by,
    p.price_retail,
    a.stock as quantity FROM `reorder` as a
    LEFT JOIN product as p on p.id=a.pid
    WHERE a.store_id='" . $input_by . "' ORDER BY p.name ASC");
}
if (@$_GET['export'] == "excel") {


    $record_label="Reorder List Report";
    header('Content-type: application/excel');
    $filename="Reorder_list_" . date('Y_m_d') . '.xls';
    header('Content-Disposition: attachment; filename=' . $filename);

    $data='<html xmlns:x="urn:schemas-microsoft-com:office:excel">
<head>
    <!--[if gte mso 9]>
    <xml>
        <x:ExcelWorkbook>
            <x:ExcelWorksheets>
                <x:ExcelWorksheet>
                    <x:Name>Reorder List : Wireless Geeks Inc.</x:Name>
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
    $data .="<h5>Reorder List Generate Date : " . date('d-m-Y H:i:s') . "</h5>";

    $data .="<table>
    <thead>
        <tr style='background:#09f; color:#fff;'>
			<th>#</th>
                        <th>PID</th>
                        <th>Name</th>
                        <th>Barcode</th>
                        <th>Price Cost</th>
                        <th>Price Retail</th>
                        <th>Stock</th>
		</tr>
</thead>
<tbody>";



    $i=1;
    if (!empty($sqlproduct)) {
        foreach ($sqlproduct as $product):
            $data .='<tr>
                        <td>' . $i . '</td>
                        <td>' . $product->pid . '</td>
                        <td>' . $product->name . '</td>
                        <td>' . $product->barcode . '</td>
                        <td>' . $product->price_cost . '</td>
                        <td>' . $product->price_retail . '</td>
                        <td>' . $product->quantity . '</td>
                    </tr>';
            $i++;
        endforeach;
    }

    $data .="</tbody><tfoot><tr>
			<th>#</th>
                        <th>PID</th>
                        <th>Name</th>
                        <th>Barcode</th>
                        <th>Price Cost</th>
                        <th>Price Retail</th>
                        <th>Stock</th>
		</tr></tfoot></table>";

    $data .='</body></html>';

    echo $data;
    exit();
}

if (@$_GET['export'] == "pdf") {
    $record_label="CheckIn List Report";
    include("pdf/MPDF57/mpdf.php");
    extract($_GET);
    $html="<table id='sample-table-2' class='table table-hover' border='0'><tbody>";
    $html .="<tr>
			<td valign='top' style='margin:0; padding:0; width:100%;'>
				<table style='width:100%; height:40px; border:0px;'>
					<tr>
						<td width='87%' style='background:rgba(0,51,153,1);  color:#FFF; font-size:25px;'>
						Reorder List Report
						</td>
					</tr>
				</table>


				<table style='width:100%; height:40px; border:0px; font-size:18px;'>
					<tr>
						<td> Reorder List Generate Date : " . date('d-m-Y H:i:s') . "</td>
					</tr>
				</table>
				<table style='width:960px;border:1px; font-size:12px; background:#ccc;'>";
    $html .="<thead>
        <tr style='background:#09f; color:#fff;'>
			<th>#</th>
                        <th>PID</th>
                        <th>Name</th>
                        <th>Barcode</th>
                        <th>Price Cost</th>
                        <th>Price Retail</th>
                        <th>Stock</th>
		</tr>
</thead>
<tbody>";


    $i=1;
    if (!empty($sqlproduct)) {
        foreach ($sqlproduct as $product):
            $html .='<tr>
                        <td>' . $i . '</td>
                        <td>' . $product->pid . '</td>
                        <td>' . $product->name . '</td>
                        <td>' . $product->barcode . '</td>
                        <td>' . $product->price_cost . '</td>
                        <td>' . $product->price_retail . '</td>
                        <td>' . $product->quantity . '</td>
                    </tr>';
            $i++;
        endforeach;
    }

    $html .="</tbody><tfoot><tr>
			<th>#</th>
                        <th>PID</th>
                        <th>Name</th>
                        <th>Barcode</th>
                        <th>Price Cost</th>
                        <th>Price Retail</th>
                        <th>Stock</th>
		</tr></tfoot></table>";

    $html .="</td></tr>";
    $html .="</tbody></table>";

    $mpdf=new mPDF('c', 'A4', '', '', 32, 25, 27, 25, 16, 13);

    $mpdf->SetDisplayMode('fullpage');

    $mpdf->list_indent_first_level=0; // 1 or 0 - whether to indent the first level of a list
// LOAD a stylesheet
    $stylesheet=file_get_contents('pdf/MPDF57/examples/mpdfstyletables.css');
    $mpdf->WriteHTML($stylesheet, 1); // The parameter 1 tells that this is css/style only and no body/html/text

    $mpdf->WriteHTML($html, 2);

    $mpdf->Output('mpdf.pdf', 'I');
    exit();
}

if (isset($_GET['del'])) {
    $obj->deletesing("id", $_GET['del'], "reorder");
}

if (isset($_GET['delall'])) {
    if($input_status==1)
    {
        $obj->deletesingAll("reorder");
    }
    else
    {
        $obj->deletesing("store_id", $input_by, "reorder");
    }
    
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
        <?php include ('include/header.php'); ?>
        <!-- Main wrapper -->
        <div class="wrapper three-columns">

            <!-- Left sidebar -->
            <?php include ('include/sidebar_left.php'); ?>
            <!-- /left sidebar -->


            <!-- Main content -->
            <div class="content">

                <!-- Info notice -->
                <?php echo $obj->ShowMsg(); ?>
                <!-- /info notice -->

                <div class="outer">
                    <div class="inner">
                        <div class="page-header"><!-- Page header -->
                            <h5><i class="icon-arrow-up"></i>
                                <span style=" padding-right:10px;">Reorder List Info </span> <a href="<?php echo $obj->filename(); ?>?delall=yes">Delete All Re-Order Record</a>
                            </h5>
                            <ul class="icons">
                                <li><a href="<?php echo $obj->filename(); ?>" class="hovertip" title="Reload"><i class="font-refresh"></i></a></li>
                            </ul>
                        </div><!-- /page header -->

                        <div class="body">

                            <!-- Content container -->
                            <div class="container">
                                
                                <div class="block">
                                    <div class="table-overflow">

                                        <div id="grid" style="margin-left: 10px;margin-right: 10px;">

                                        </div>
                                        <script id="edit_client" type="text/x-kendo-template">
                                            <a class="btn" href="inventory.php?edit=#=pid#&reor=#=id#" title="StockIn Inventory" onclick="javascript:return confirm('Do You Want To Upgrade Your Inventory?')">Stock In <i class="icon-arrow-up"></i></a>
                                            <a href="javascript:void(0);" class="btn hovertip" title="Delete Product" onclick="deleteClick(#=id#)"><i class="icon-trash"></i></a>
                                        </script>
                                        <script type="text/javascript">
                                            function deleteClick(id) {
                                                var c = confirm("Do you want to delete?");
                                                if (c === true) {
                                                    $.ajax({
                                                        type: "POST",
                                                        dataType: "json",
                                                        url: "./controller/reorder.php",
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
                                                            url: "./controller/reorder.php<?php echo $cond; ?>",
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
                                                                pid: {type: "string"},
                                                                name: {type: "string"},
                                                                barcode: {type: "string"},
                                                                price_cost: {type: "string"},
                                                                price_retail: {type: "string"},
                                                                quantity: {type: "string"}
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
                                                        pageSizes:[10, 50, 200, 500, 1000, 5000,10000]
                                                    },
                                                    sortable: true,
                                                    groupable: true,
                                                    columns: [
                                                        {field: "id", title: "R.ID", width: "50px"},
                                                        {title: "Barcode", width: "60px",
                                                        template: kendo.template('<a href="./inventory.php?edit=#=pid#">#=barcode#</a>')},
                                                        {title: "Product/Item", width: "100px",
                                                        template: kendo.template('<a href="./inventory.php?edit=#=pid#">#=name#</a>')},
                                                        {field: "price_cost", title: "Cost", width: "50px"},
                                                        {field: "price_retail", title: "Retail", width: "50px"},
                                                        {field: "quantity", title: "Quantity", width: "50px"}
                                                        <?php if ($input_status == 1 || $input_status == 2 || $input_status == 5) { ?>
                                                        ,{
                                                            title: "Action", width: "80px",
                                                            template: kendo.template($("#edit_client").html())
                                                        }
                                                        <?php } ?>
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
                                            JSONToCSVConvertor(json_data, "Recorder List", true);

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
                                            var fileName = "recorder_list_";
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
                                </div>
                                
                                <!-- Default datatable -->
                               <?php /*<div class="table-overflow">
                                    <table class="table table-striped" id="data-table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>PID</th>
                                                <th>Name</th>
                                                <th>Barcode</th>
                                                <th>Price Cost</th>
                                                <th>Price Retail</th>
                                                <th>Stock</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i=1;
                                            if (!empty($sqlproduct)) {
                                                foreach ($sqlproduct as $product):
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $i; ?></td>
                                                        <td><?php echo $product->pid; ?></td>
                                                        <td><?php echo $product->name; ?></td>
                                                        <td><?php echo $product->barcode; ?></td>
                                                        <td><?php echo $product->price_cost; ?></td>
                                                        <td><?php echo $product->price_retail; ?></td>
                                                        <td><?php echo $product->quantity; ?></td>
                                                        <td>
                                                            <?php if ($input_status == 1 || $input_status == 2 || $input_status == 5) { ?>
                                                                <a class="btn" href="inventory.php?edit=<?php echo $product->pid; ?>&AMP;reor=<?php echo $product->id; ?>" title="StockIn Inventory" onclick="javascript:return confirm('Do You Want To Upgrade Your Inventory?')">Stock In <i class="icon-arrow-up"></i></a>
                                                                <a class="btn btn-warning" href="<?php echo $obj->filename(); ?>?del=<?php echo $product->id; ?>" title="Delete" onclick="javascript:return confirm('Are you sure to delete This Reorder Detail?')"><i class="icon-trash"></i></a>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    $i++;
                                                endforeach;
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /default datatable -->
                                */ ?>

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

