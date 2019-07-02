<?php
include('class/auth.php');
$table="parts_order";
if(isset($_GET['del']))
{
	$obj->deletesing("id",$_GET['del'],$table);	
}

if(@$_GET['export']=="excel") 
{


$record_label="Parts List Report"; 
header('Content-type: application/excel');
$filename ="Parts_list_".date('Y_m_d').'.xls';
header('Content-Disposition: attachment; filename='.$filename);

$data = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">
<head>
    <!--[if gte mso 9]>
    <xml>
        <x:ExcelWorkbook>
            <x:ExcelWorksheets>
                <x:ExcelWorksheet>
                    <x:Name>Parts List : Wireless Geeks Inc.</x:Name>
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
$data .="<h3>".$record_label."</h3>";
$data .="<h5>Parts List Generate Date : ".date('d-m-Y H:i:s')."</h5>";

$data .="<table>
    <thead>
        <tr style='background:#09f; color:#fff;'>
			<th>#</th>
			<th>ID</th>
			<th>Entered </th>
			<th>Ticket </th>
			<th>Customer </th>
			<th>Parturl</th>
			<th>Description</th>
			<th>Price</th>                                            
			<th>Bought</th>
			<th>Tracking</th>
			<th>Arrived</th>
		</tr>
</thead>        
<tbody>";


		if($input_status==1){
			$sql_parts_order=$obj->SelectAll($table);
		}
		elseif($input_status==5)
		{
			
			$sqlchain_store_ids=$obj->SelectAllByID("store_chain_admin",array("sid"=>$input_by));
			if(!empty($sqlchain_store_ids))
			{
				$array_ch = array();
				foreach($sqlchain_store_ids as $ch):
					array_push($array_ch,$ch->store_id);
				endforeach;
				
				
					include('class/report_chain_admin.php');	
					$obj_report_chain = new chain_report();
					$sql_parts_order=$obj_report_chain->SelectAllByID_Multiple_Or($table,$array_ch,"store");
				
			}
			else
			{
				//echo "Not Work";
				$sql_parts_order="";
			}
		}
		else
		{
			$sql_parts_order=$obj->SelectAllByID_Multiple($table,array("store"=>$input_by));
		}
		
		$i=1;
		if(!empty($sql_parts_order))
		foreach($sql_parts_order as $row): 
		$cid=$obj->SelectAllByVal("ticket","ticket_id",$row->ticket_id,"cid");
			
			$data.="<tr>
				<td>".$i."</td>
				<td>".$row->id."</td>
				<td>".$row->date."</td>
				<td>".$row->ticket_id."</td>
				<td>".$obj->SelectAllByVal("coustomer","id",$cid,"businessname")."</td>
				<td>".$row->part_url."</td>
				<td>".$row->description."</td>
				<td>".$row->cost."</td>
				
				<td>".$row->ordered."</td>
				<td>".$row->trackingnum."</td>
				<td>".$row->received."</td>
			</tr>";
			$i++;
			endforeach;
			
$data .="</tbody><tfoot><tr>
			<th>#</th>
			<th>ID</th>
			<th>Entered </th>
			<th>Ticket </th>
			<th>Customer </th>
			<th>Parturl</th>
			<th>Description</th>
			<th>Price</th>                                            
			<th>Bought</th>
			<th>Tracking</th>
			<th>Arrived</th>
		</tr></tfoot></table>";

$data .='</body></html>';

echo $data;
}

if(@$_GET['export']=="pdf") 
{
	$record_label="Parts List Report"; 
    include("pdf/MPDF57/mpdf.php");
	extract($_GET);
    $html.="<table id='sample-table-2' class='table table-hover' border='0'><tbody>";
    $html .="<tr>
			<td valign='top' style='margin:0; padding:0; width:100%;'>
				<table style='width:100%; height:40px; border:0px;'>
					<tr>
						<td width='87%' style='background:rgba(0,51,153,1);  color:#FFF; font-size:25px;'>
						Parts List Report
						</td>
					</tr>
				</table>
				
				
				
				<table style='width:100%; height:40px; border:0px; font-size:18px;'>
					<tr>
						<td> Parts List Generate Date : ".date('d-m-Y H:i:s')."</td>
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
			<th>Parturl</th>
			<th>Description</th>
			<th>Price</th>                                            
			<th>Bought</th>
			<th>Tracking</th>
			<th>Arrived</th>
		</tr>
</thead>        
<tbody>";

		if($input_status==1){
			$sql_parts_order=$obj->SelectAll($table);
		}
		elseif($input_status==5)
		{
			
			$sqlchain_store_ids=$obj->SelectAllByID("store_chain_admin",array("sid"=>$input_by));
			if(!empty($sqlchain_store_ids))
			{
				$array_ch = array();
				foreach($sqlchain_store_ids as $ch):
					array_push($array_ch,$ch->store_id);
				endforeach;
				
				
					include('class/report_chain_admin.php');	
					$obj_report_chain = new chain_report();
					$sql_parts_order=$obj_report_chain->SelectAllByID_Multiple_Or($table,$array_ch,"store");
				
			}
			else
			{
				//echo "Not Work";
				$sql_parts_order="";
			}
		}
		else
		{
			$sql_parts_order=$obj->SelectAllByID_Multiple($table,array("store"=>$input_by));
		}
		
		$i=1;
		if(!empty($sql_parts_order))
		foreach($sql_parts_order as $row): 
		$cid=$obj->SelectAllByVal("ticket","ticket_id",$row->ticket_id,"cid");
			
			$html.="<tr>
				<td>".$i."</td>
				<td>".$row->id."</td>
				<td>".$row->date."</td>
				<td>".$row->ticket_id."</td>
				<td>".$obj->SelectAllByVal("coustomer","id",$cid,"businessname")."</td>
				<td>".$row->part_url."</td>
				<td>".$row->description."</td>
				<td>".$row->cost."</td>
				<td>".$row->ordered."</td>
				<td>".$row->trackingnum."</td>
				<td>".$row->received."</td>
			</tr>";
			$i++;
			endforeach;
			
	$html.="</tbody><tfoot><tr>
			<th>#</th>
			<th>ID</th>
			<th>Entered </th>
			<th>Ticket </th>
			<th>Customer </th>
			<th>Parturl</th>
			<th>Description</th>
			<th>Price</th>                                            
			<th>Bought</th>
			<th>Tracking</th>
			<th>Arrived</th>
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
        echo $cms->GeneralCss(array("kendo","modal"));
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
                            <h5><i class="font-cogs"></i> <span style="border-right:2px #333 solid; padding-right:10px;">Parts Order List</span> 
                                <span><i class="font-calendar"></i> <a data-toggle="modal" href="#myModal"> Generate Parts Order Report</a></span></h5>
                            <ul class="icons">
                                <li><a href="<?php echo $obj->filename(); ?>" class="hovertip" title="Reload"><i class="font-refresh"></i></a></li>
                            </ul>
                        </div><!-- /page header -->


                        <!-- Dialog content -->
                        <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h5 id="myModalLabel"><i class="font-calendar"></i> Generate Parts Order Report <span id="mss"></span></h5>
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
                            <?php //include('include/quicklink.php');  ?>
                            <!-- /middle navigation standard -->
                            <!-- Content container -->
                            <div class="container">                               
                                <!-- Content Start from here customized -->
                                
                                    <!-- Content Start Here -->
                                    <div id="grid" style="margin-left: 10px;margin-right: 10px;"></div>


                                    <script id="edit_client" type="text/x-kendo-template">
                                        <a class="k-button k-button-icontext k-grid-delete" href="parts.php?edit=#= id #"><span class="k-icon k-edit"></span>Edit</a> 
                                        <a class="k-button k-button-icontext k-grid-delete" onclick="javascript:deleteClick(#= id #);" ><span class="k-icon k-delete"></span>Delete</a>
                                    </script>
                                    <script type="text/javascript">
                                        function deleteClick(id) {
                                            var c = confirm("Do you want to delete?");
                                            if (c === true) {
                                                $.ajax({
                                                    type: "POST",
                                                    dataType: "json",
                                                    url: "./controller/parts.php",
                                                    data: {id: id},
                                                    success: function (result) {
                                                            $(".k-i-refresh").click();
                                                    }
                                                });
                                            }
                                        }

                                    </script>
                                    <?php
                                    $cond=$cms->FrontEndDateSearch('from','to');
                                    ?>
                                    <script type="text/javascript">
                                        jQuery(document).ready(function () {
                                            var dataSource = new kendo.data.DataSource({
                                                transport: {
                                                    read: {
                                                        url: "./controller/parts.php<?php echo $cond; ?>",
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
                                                            ticket_id: {type: "string"},
                                                            cid: {type: "number"},
                                                            name: {type: "string"},
                                                            part_url: {type: "string"},
                                                            description: {type: "string"},
                                                            cost: {type: "string"},
                                                            ordered: {type: "string"},
                                                            trackingnum: {type: "string"},
                                                            received: {type: "string"}
                                                        }
                                                    }
                                                },
                                                pageSize:10,
                                                serverPaging:true,
                                                serverFiltering:true,
                                                serverSorting:true
                                            });
                                            jQuery("#grid").kendoGrid({
                                                dataSource:dataSource,
                                                filterable:true,
                                                pageable: {
                                                    refresh:true,
                                                    input:true,
                                                    numeric:false,
                                                    pageSizes:true,
                                                    pageSizes:[10, 20, 50, 100, 200, 400]
                                                },
                                                sortable: true,
                                                groupable: true,
                                                columns: [
                                                    {field: "id", title: "PO.ID", width: "70px"},
                                                    {field: "ticket_id", 
                                                        title: "Ticket ID", 
                                                        width: "90px",
                                                        template: "<a target='_blank' href='view_ticket.php?ticket_id=#=ticket_id#'>#=ticket_id#</a>"
                                                    },
                                                    {field: "name", title: "Customer Name", width: "120px"},
                                                    {field: "part_url", title: "Parts URL", width: "500px"},
                                                    {field: "description", title: "Description", width: "150px"},
                                                    {field: "cost", title: "Cost", width: "50px"},
                                                    {field: "ordered", title: "Ordered Date", width: "100px"},
                                                    {field: "trackingnum", 
                                                        title: "Trackingnum", 
                                                        width: "100px",
                                                        template: "<a target='_blank' href='http://www.google.com/search?&amp;q=#=trackingnum#'>#=trackingnum#</a>"
                                                    },
                                                    {field: "received", title: "Received Date", width: "100px"},
                                                    {
                                                        title: "Action", width: "180px",
                                                        template: kendo.template($("#edit_client").html())
                                                    }
                                                ],
                                            });
                                        });

                                    </script>
                                    <script type="text/javascript">
                                        $(document).ready(function () {
                                            $('.k-grid-delete').click(function () {
                                                $.ajax({
                                                    type: 'POST',
                                                    url: "./controller/parts.php",
                                                    data: "",
                                                    success: function () {

                                                    }
                                                });
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
                                            JSONToCSVConvertor(json_data, "Parts List", true);

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
                                            var fileName = "parts_list_";
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
















                                    <!-- Default datatable -->


                                
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
            <!-- Right sidebar -->
            <?php //include('include/sidebar_right.php');   ?>
            <!-- /right sidebar -->
        </div>
        <!-- /main wrapper -->
    </body>
</html>
