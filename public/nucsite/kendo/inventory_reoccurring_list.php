<?php
include('class/auth.php');
//if ($input_status == 3 || $input_status == 4) {
//    $obj->Error("Invalid Page Request.", "index.php");
//}
$table="product";
if (isset($_GET['del'])) {
    $obj->deletesing("id", $_GET['del'], $table);
}

if (isset($_GET['delbarcode'])) {
    $obj->delete("checkin_price", array("barcode"=>$_GET['delbarcode']));
    $obj->deletesing("barcode", $_GET['delbarcode'], $table);
}

if (@$_GET['export'] == "excel") {
    $record_label="Inventory List Report";
    header('Content-type: application/excel');
    $filename="Inventory_list_" . date('Y_m_d') . '.xls';
    header('Content-Disposition: attachment; filename=' . $filename);

    $data='<html xmlns:x="urn:schemas-microsoft-com:office:excel">
<head>
    <!--[if gte mso 9]>
    <xml>
        <x:ExcelWorkbook>
            <x:ExcelWorksheets>
                <x:ExcelWorksheet>
                    <x:Name>Inventory List : Wireless Geeks Inc.</x:Name>
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
    $data .="<h5>Inventory List Generate Date : " . date('d-m-Y H:i:s') . "</h5>";

    $data .="<table>
    <thead>
        <tr style='background:#09f; color:#fff;'>
			<th>#</th>
			<th>Barcode</th>
			<th>Name</th>
			<th>Description</th>
			<th>Cost</th>
			<th>Retail</th>
			<th>In Stock</th>
		</tr>
</thead>
<tbody>";


    if ($input_status == 1) {
        $sql_product=$obj->SelectAllNOASC("product_other_inventory");
    }elseif ($input_status == 5) {

        $sqlchain_store_ids=$obj->SelectAllByID("store_chain_admin", array("sid"=>$input_by));
        if (!empty($sqlchain_store_ids)) {
            $array_ch=array();
            foreach ($sqlchain_store_ids as $ch):
                array_push($array_ch, $ch->store_id);
            endforeach;


            include('class/report_chain_admin.php');
            $obj_report_chain=new chain_report();
            $sql_product=$obj_report_chain->SelectAllByID_Multiple_Or("product_other_inventory", $array_ch, "input_by", "1");
        }
        else {
            //echo "Not Work";
            $sql_product="";
        }
    }else {
        $sql_product=$obj->SelectAllByID_Multiple_Inventory("product_other_inventory", array("input_by"=>$input_by));
    }
    $i=1;
    if (!empty($sql_product))
        foreach ($sql_product as $product):
            $sqlsalesproduct=$obj->SelectAllByID_Multiple("sales", array("pid"=>$product->id));
            $sold=0;
            if (!empty($sqlsalesproduct)) {
                foreach ($sqlsalesproduct as $soldproduct):
                    $sold+=$soldproduct->quantity;
                endforeach;
            }
            else {
                $sold+=0;
            }

            $instock=$product->quantity - $sold;

            $data.="<tr>
				<td>" . $i . "</td>
				<td>" . $product->barcode . "</td>
				<td>" . $product->name . "</td>
				<td>" . $product->description . "</td>
				<td>" . $product->price_cost . "</td>
				<td>" . $product->price_retail . "</td>
				<td>" . $instock . "</td>
			</tr>";
            $i++;
        endforeach;

    $data .="</tbody><tfoot><tr>
			<th>#</th>
			<th>Barcode</th>
			<th>Name</th>
			<th>Description</th>
			<th>Cost</th>
			<th>Retail</th>
			<th>In Stock</th>
		</tr></tfoot></table>";

    $data .='</body></html>';

    echo $data;
}

if (@$_GET['export'] == "pdf") {
    $record_label="Inventory List Report";
    include("pdf/MPDF57/mpdf.php");
    extract($_GET);
    $html.="<table id='sample-table-2' class='table table-hover' border='0'><tbody>";
    $html .="<tr>
			<td valign='top' style='margin:0; padding:0; width:100%;'>
				<table style='width:100%; height:40px; border:0px;'>
					<tr>
						<td width='87%' style='background:rgba(0,51,153,1);  color:#FFF; font-size:25px;'>
						Inventory List Report
						</td>
					</tr>
				</table>


				<table style='width:100%; height:40px; border:0px; font-size:18px;'>
					<tr>
						<td> Inventory List Generate Date : " . date('d-m-Y H:i:s') . "</td>
					</tr>
				</table>
				<table style='width:960px;border:1px; font-size:12px; background:#ccc;'>";
    $html.="<thead>
        <tr style='background:#09f; color:#fff;'>
			<th>#</th>
			<th>Barcode</th>
			<th>Name</th>
			<th>Description</th>
			<th>Cost</th>
			<th>Retail</th>
			<th>In Stock</th>
		</tr>
</thead>
<tbody>";

    if ($input_status == 1) {
        $sql_product=$obj->SelectAllNOASC("product_other_inventory");
    }elseif ($input_status == 5) {

        $sqlchain_store_ids=$obj->SelectAllByID("store_chain_admin", array("sid"=>$input_by));
        if (!empty($sqlchain_store_ids)) {
            $array_ch=array();
            foreach ($sqlchain_store_ids as $ch):
                array_push($array_ch, $ch->store_id);
            endforeach;


            include('class/report_chain_admin.php');
            $obj_report_chain=new chain_report();
            $sql_product=$obj_report_chain->SelectAllByID_Multiple_Or("product_other_inventory", $array_ch, "input_by", "1");
        }
        else {
            //echo "Not Work";
            $sql_product="";
        }
    }else {
        $sql_product=$obj->SelectAllByID_Multiple_Inventory("product_other_inventory", array("input_by"=>$input_by));
    }
    $i=1;
    if (!empty($sql_product))
        foreach ($sql_product as $product):
            $sqlsalesproduct=$obj->SelectAllByID_Multiple("sales", array("pid"=>$product->id));
            $sold=0;
            if (!empty($sqlsalesproduct)) {
                foreach ($sqlsalesproduct as $soldproduct):
                    $sold+=$soldproduct->quantity;
                endforeach;
            }
            else {
                $sold+=0;
            }

            $instock=$product->quantity - $sold;

            $html.="<tr>
				<td>" . $i . "</td>
				<td>" . $product->barcode . "</td>
				<td>" . $product->name . "</td>
				<td>" . $product->description . "</td>
				<td>" . $product->price_cost . "</td>
				<td>" . $product->price_retail . "</td>
				<td>" . $instock . "</td>
			</tr>";
            $i++;
        endforeach;

    $html.="</tbody><tfoot><tr>
			<th>#</th>
			<th>Barcode</th>
			<th>Name</th>
			<th>Description</th>
			<th>Cost</th>
			<th>Retail</th>
			<th>In Stock</th>
		</tr></tfoot></table>";

    $html.="</td></tr>";
    $html.="</tbody></table>";

    $mpdf=new mPDF('c', 'A4', '', '', 32, 25, 27, 25, 16, 13);

    $mpdf->SetDisplayMode('fullpage');

    $mpdf->list_indent_first_level=0; // 1 or 0 - whether to indent the first level of a list
    // LOAD a stylesheet
    $stylesheet=file_get_contents('pdf/MPDF57/examples/mpdfstyletables.css');
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
        <?php //echo $obj->bodyhead(); ?>
       <?php
       
//        include './plugin/plugin.php';
//        $cms = new CmsRootPlugin();
//        echo $cms->GeneralCss(array("kendo", "modal"));
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
                            <h5><i class="font-download-alt"></i> Reoccurring Inventory List</h5>
                            <ul class="icons">
                                <li><a href="<?php echo $obj->filename(); ?>" class="hovertip" title="Reload"><i class="font-refresh"></i></a></li>
                            </ul>
                        </div><!-- /page header -->

                        <div class="body">

                            <!-- Middle navigation standard -->
                            <?php //include('include/quicklink.php');  ?>
                            <!-- /middle navigation standard -->

                            <!-- Content container -->
                            <div class="container">





                                <!-- Content Start from here customized -->


                                <!-- Default datatable -->
                                <div class="block">
<!--                                    <div class="table-overflow">

                                        <div id="grid" style="margin-left: 10px;margin-right: 10px;">

                                        </div>
                                        <script id="stock" type="text/x-kendo-template">
                                            <a href="inventory_stockout.php?pid=#=id#" class="label label-warning hovertip" title="StockOut Product"><i class="icon-download"></i></a> 
                                            <a href="inventory_stockin.php?pid=#=id#" class="label label-info hovertip" title="Stockin Product"><i class="icon-upload"></i></a>
                                        </script>
                                        
                                        <script id="edit_client" type="text/x-kendo-template">
                                            <a href="inventory_reoccurring.php?edit=#=id#" class="hovertip" title="Edit Product"><i class="icon-edit"></i></a>
                                            <a href="javascript:void(0);" class="hovertip" title="Delete Product" onclick="deleteClick(#=id#)"><i class="icon-trash"></i></a>
                                        </script>
                                        <script type="text/javascript">
                                            function deleteClick(id) {
                                                var c = confirm("Do you want to delete?");
                                                if (c === true) {
                                                    $.ajax({
                                                        type: "POST",
                                                        dataType: "json",
                                                        url: "./controller/inventory_reoccurring_list.php",
                                                        data: {id: id},
                                                        success: function (result) {
                                                            $(".k-i-refresh").click();
                                                        }
                                                    });
                                                }
                                            }

                                        </script>
                                        <?php
                                        //$cond = $cms->FrontEndDateSearch('from', 'to');
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
                                                            url: "./controller/inventory_reoccurring_list.php<?php echo $cond; ?>",
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
                                                                barcode: {type: "string"},
                                                                name: {type: "string"},
                                                                description: {type: "string"},
                                                                price_cost: {type: "string"},
                                                                price_retail: {type: "string"},
                                                                instock: {type: "string"},
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
                                                        {field: "id", title: "P.ID", width: "60px"},
                                                        {field: "barcode", title: "Barcode", width: "90px"},
                                                        {field: "name", title: "Name", width: "90px"},
                                                        {field: "description", title: "Description", width: "80px"},
                                                        {field: "price_cost", title: "Price", width: "50px"},
                                                        {field: "price_retail", title: "Cost", width: "50px"},
                                                        ///{field: "instock", title: "Instock", width: "50px"},
                                                       // {
                                                        //    title: "Stock - In/Out", width: "60px",
                                                     //       template: kendo.template($("#stock").html())
                                                       // },
                                                        {
                                                            title: "Action", width: "60px",
                                                            template: kendo.template($("#edit_client").html())
                                                        }
                                                    ],
                                                });
                                            });

                                        </script>













                                    </div>-->
                                    <div class="table-overflow">
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        <div id="grid" style="margin-left: 10px;margin-right: 10px;"></div>

                                        <script id="action_template" type="text/x-kendo-template">
                                            <a class="k-button k-button-icontext k-grid-delete" href="inventory_reoccurring_list.php?edit=#=id#"><i class="icon-edit"></i> Edit</a> 
                                            <a class="k-button k-button-icontext k-grid-delete" onclick="javascript:deleteClick(#=id#);" ><span class="k-icon k-delete"></span> Delete</a>
                                        </script>
                                        <script type="text/javascript">
                                            function deleteClick(id) {
                                                var c = confirm("Do you want to delete?");
                                                if (c === true) {
                                                    $.ajax({
                                                        type: "POST",
                                                        dataType: "json",
                                                        url: "./controller/inventory_reoccurring_list.php",
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
                                                            url: "./controller/inventory_reoccurring_list.php",
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
                                                                barcode: {type: "string"},
                                                                name: {type: "string"},
                                                                description: {type: "string"},
                                                                price_cost: {type: "string"},
                                                                price_retail: {type: "string"}
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
                                                        {field: "barcode", title: "Barcode", width: "100px"},
                                                        {field: "name", title: "Name", width: "120px"},
                                                        {field: "description", title: "Description", width: "250px"},
                                                        {field: "price_cost", title: "Price", width: "80px"},
                                                        {field: "price_retail", title: "Cost", width: "80px"},
                                                        {
                                                            title: "Action", width: "170px",
                                                            template: kendo.template($("#action_template").html())
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
                                            JSONToCSVConvertor(json_data, "Inventory Reoccurring List", true);

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
                                            var fileName = "inventory_reoccurring_list_";
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
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                      <?php /*  <table class="table table-striped" id="data-table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Barcode</th>
                                                    <th>Name</th>
                                                    <th>Description</th>
                                                    <th>Price</th>
                                                    <th>Cost</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if ($input_status == 1) {
                                                    $sql_product=$obj->FlyQuery("select 
                                                    p.`id`,
                                                    p.`store_id`,
                                                    p.`name`,
                                                    p.`description`,
                                                    p.`barcode`,
                                                    p.`price_cost`,
                                                    p.`price_retail`,
                                                    p.`quantity` AS `quantity`,
                                                    IFNULL((p.`quantity`-IFNULL(SUM(s.quantity),0)),0) AS instock,
                                                    p.`input_by` AS `input_by`,
                                                    p.`access_id` AS `access_id`,
                                                    p.`date` AS `date`,
                                                    p.`status` AS `status` 
                                                    from `product` as p 
                                                    LEFT JOIN sales as s on s.pid=p.id AND s.salvage_part='0'
                                                    where `p`.`status` = '6' GROUP BY p.id ");
                                                }elseif ($input_status == 5) {

                                                    $sqlchain_store_ids=$obj->SelectAllByID("store_chain_admin", array("sid"=>$input_by));
                                                    if (!empty($sqlchain_store_ids)) {
                                                        $array_ch=array();
                                                        foreach ($sqlchain_store_ids as $ch):
                                                            array_push($array_ch, $ch->store_id);
                                                        endforeach;

                                                        $count=0;
                                                        $fields='';
                                                        foreach ($array_ch as $val) {
                                                            if ($count++ != 0)
                                                                $fields .= ' OR ';
                                                            $fields .= "p.input_by = '" . $val . "' ";
                                                        }

                                                        if (empty($fields)) {
                                                            $fields .= "p.input_by = 'no_user' ";
                                                        }

                                                        $sql_product=$obj->FlyQuery("select 
                                                        p.`id`,
                                                        p.`store_id`,
                                                        p.`name`,
                                                        p.`description`,
                                                        p.`barcode`,
                                                        p.`price_cost`,
                                                        p.`price_retail`,
                                                        p.`quantity` AS `quantity`,
                                                        IFNULL((p.`quantity`-IFNULL(SUM(s.quantity),0)),0) AS instock,
                                                        p.`input_by` AS `input_by`,
                                                        p.`access_id` AS `access_id`,
                                                        p.`date` AS `date`,
                                                        p.`status` AS `status` 
                                                        from `product` as p 
                                                        LEFT JOIN sales as s on s.pid=p.id AND s.salvage_part='0'
                                                        where `p`.`status` = '6' AND ($fields) GROUP BY p.id ");

                                                        //include('class/report_chain_admin.php');
                                                        //$obj_report_chain=new chain_report();
                                                        //$sql_product=$obj_report_chain->SelectAllByID_Multiple_Or("product_other_inventory", $array_ch, "input_by", "1");
                                                    }else {
                                                        //echo "Not Work";
                                                        $sql_product="";
                                                    }
                                                }else {
                                                    $sql_product=$obj->FlyQuery("select 
                                                        p.`id`,
                                                        p.`store_id`,
                                                        p.`name`,
                                                        p.`description`,
                                                        p.`barcode`,
                                                        p.`price_cost`,
                                                        p.`price_retail`,
                                                        p.`quantity` AS `quantity`,
                                                        IFNULL((p.`quantity`-IFNULL(SUM(s.quantity),0)),0) AS instock,
                                                        p.`input_by` AS `input_by`,
                                                        p.`access_id` AS `access_id`,
                                                        p.`date` AS `date`,
                                                        p.`status` AS `status` 
                                                        from `product` as p 
                                                        LEFT JOIN sales as s on s.pid=p.id AND s.salvage_part='0'
                                                        where `p`.`status` = '6' AND p.input_by='" . $input_by . "' GROUP BY p.id");
                                                    //$sql_product=$obj->SelectAllByID_Multiple_Inventory("product_other_inventory", array("input_by"=>$input_by));
                                                    //490
                                                    //50
                                                    //40.5
                                                    //500
                                                    //130
                                                    //30
                                                //
                                                    //


                                                }
                                                $i=1;
                                                if (!empty($sql_product))
                                                    foreach ($sql_product as $product):
                                                        $instock=1;
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $i; ?></td>
                                                            <td><?php echo $product->barcode; ?></td>
                                                            <td><label class="label label-success"> <?php echo $product->name; ?> </label></td>
                                                            <td><?php echo $product->description; ?></td>
                                                            <td><?php echo $product->price_cost; ?></td>
                                                            <td><?php echo $product->price_retail; ?></td>
                                                            
                                                            <td>
                                                                <?php if ($input_status == 1 || $input_status == 2) { ?>
                                                                    <a href="inventory_reoccurring.php?edit=<?php echo $product->id; ?>" class="hovertip" title="Edit Product"><i class="icon-edit"></i></a>
                                                                    <?php if ($product->status == 3) { ?>
                                                                        <a href="<?php echo $obj->filename(); ?>?delbarcode=<?php echo $product->barcode; ?>" class="hovertip" title="Delete Product" onclick="javascript:return confirm('Are you absolutely sure to delete This Product ?')"><i class="icon-trash"></i></a>
                                                                    <?php }else { ?>
                                                                        <a href="<?php echo $obj->filename(); ?>?del=<?php echo $product->id; ?>" class="hovertip" title="Delete Product" onclick="javascript:return confirm('Are you absolutely sure to delete This Product ?')"><i class="icon-trash"></i></a>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                        $i++;
                                                    endforeach;
                                                ?>
                                            </tbody>
                                            
                                        </table>*/?>
                                    </div> 
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
             <?php
            //include('include/footer.php');
           //echo $cms->KendoFotter();
            ?>
        </div>
        <!-- /main wrapper -->

    </body>
</html>
