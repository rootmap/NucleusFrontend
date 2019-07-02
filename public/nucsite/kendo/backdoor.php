<?php 
include('class/auth.php');
if($input_status!=1)
{
	$obj->Error("Invalid Page Request.","index.php");
}
$table="store";
if(@$_GET['export']=="excel") 
{
$record_label="Store User List Report"; 
header('Content-type: application/excel');
$filename ="backdoor_Store_user_list_".date('Y_m_d').'.xls';
header('Content-Disposition: attachment; filename='.$filename);

$data = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">
<head>
    <!--[if gte mso 9]>
    <xml>
        <x:ExcelWorkbook>
            <x:ExcelWorksheets>
                <x:ExcelWorksheet>
                    <x:Name>Store User List : Wireless Geeks Inc.</x:Name>
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
$data .="<h5>Store User List Generate Date : ".date('d-m-Y H:i:s')."</h5>";

$data .="<table>
    <thead>
        <tr style='background:#09f; color:#fff;'>
			<th>#</th>
			<th>Full Name</th>
			<th>Email</th>
			<th>Username</th>
			<th>Password</th>
		</tr>
</thead>        
<tbody>";


		if($input_status==1){
			$sql_coustomer=$obj->SelectAll($table);
		}
		$i=1;
		if(!empty($sql_coustomer))
		foreach($sql_coustomer as $customer): 
							
			$data .="<tr>
				<td>".$i."</td>
				<td>".$customer->name."</td>
				<td>".$customer->email."</td>
				<td>".$customer->username."</td>
				<td>".$customer->password."</td>
			</tr>";
			$i++;
			endforeach;
			
$data .="</tbody><tfoot><tr>
			<th>#</th>
			<th>Full Name</th>
			<th>Email</th>
			<th>Username</th>
			<th>Password</th>
		</tr></tfoot></table>";

$data .='</body></html>';

echo $data;
}

if(@$_GET['export']=="pdf") 
{
	$record_label="Customer List Report"; 
    include("pdf/MPDF57/mpdf.php");
	extract($_GET);
	
	/*<table style='width:960px; height:40px; font-size:12px; border:0px;'>
					<tr>
						<td width='69%'>Wireless Geeks Inc.<br>".$record_label."</td>
					</tr>
				</table>*/
    $html.="<table id='sample-table-2' class='table table-hover' border='0'><tbody>";
    $html .="<tr>
			<td valign='top' style='margin:0; padding:0; width:100%;'>
				<table style='width:100%; height:40px; border:0px;'>
					<tr>
						<td width='87%' style='background:rgba(0,51,153,1);  color:#FFF; font-size:25px;'>
						Store List Report
						</td>
					</tr>
				</table>
				
				
				
				<table style='width:100%; height:40px; border:0px; font-size:18px;'>
					<tr>
						<td> Store User List Generate Date : ".date('d-m-Y H:i:s')."</td>
					</tr>
				</table>
				<table style='width:960px;border:1px; font-size:12px; background:#ccc;'>";
				$html.="<thead>
        <tr style='background:#09f; color:#fff;'>
			<th>#</th>
			<th>Full Name</th>
			<th>Email</th>
			<th>Username</th>
			<th>Password</th>
		</tr>
</thead>        
<tbody>";

		if($input_status==1){
			$sql_coustomer=$obj->SelectAll($table);
		}
		$i=1;
		if(!empty($sql_coustomer))
		foreach($sql_coustomer as $customer): 
							
			$html.="<tr>
				<td>".$i."</td>
				<td>".$customer->name."</td>
				<td>".$customer->email."</td>
				<td>".$customer->username."</td>
				<td>".$customer->password."</td>
			</tr>";
			$i++;
			endforeach;
			
	$html.="</tbody><tfoot><tr>
			<th>#</th>
			<th>Full Name</th>
			<th>Email</th>
			<th>Username</th>
			<th>Password</th>
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
        echo $cms->GeneralCss(array("kendo"));
        ?>
        <?php //echo $obj->bodyhead(); ?>
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
                            <h5><i class="font-home"></i>Store User List</h5>
                            <ul class="icons">
                                <li><a href="<?php echo $obj->filename(); ?>" class="hovertip" title="Reload"><i class="font-refresh"></i></a></li>
                            </ul>
                        </div><!-- /page header -->
                        <div class="body">
                            <!-- Middle navigation standard -->
                            <?php //include('include/quicklink.php'); ?>
                            <!-- /middle navigation standard -->
                            <!-- Content container -->
                            <div class="container">                               
                                <!-- Content Start from here customized -->
                                <!-- Default datatable -->
                        <div class="block">
                            <div class="table-overflow">
                                
                                
                                <div id="grid" style="margin-left: 10px;margin-right: 10px;"></div>
                                    <script id="action_template" type="text/x-kendo-template">
                                        <a class="k-button k-button-icontext k-grid-delete" onclick="javascript:deleteClick(#=id#);" ><span class="k-icon k-delete"></span> Delete</a>
                                    </script>
                                    
                                    <script type="text/javascript">
                                        function deleteClick(id) {
                                            var c = confirm("Do you want to delete?");
                                            if (c === true) {
                                                $.ajax({
                                                    type: "POST",
                                                    dataType: "json",
                                                    url: "./controller/backdoor.php",
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
                                                        url: "./controller/backdoor.php",
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
                                                            name: {type: "string"},
                                                            email: {type: "string"},
                                                            username: {type: "string"},
                                                            password: {type: "string"}
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
                                                    {field: "name", title: "Full Name ", width: "80px"},
                                                    {field: "email", title: "Email ", width: "100px",},
                                                    {field: "username", title: "User Name ", width: "100px",},
                                                    {field: "password", title: "Password ", width: "100px",},
                                                    {
                                                        title: "Action", width: "80px",
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
                                            JSONToCSVConvertor(json_data, "BackDoor", true);

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
                                            var fileName = "backdoor_";
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
                                
                                
                                
                                
                                
                                
                                
                                <?php /*<table class="table table-striped" id="data-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Full Name</th>
                                            <th>Email</th>
                                            <th>User Name</th>
                                            <th>Password</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
										if($input_status==1){
											$sql_coustomer=$obj->SelectAll($table);
										}
										$i=1;
										if(!empty($sql_coustomer))
										foreach($sql_coustomer as $customer): 
										?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $customer->name; ?></td>
                                            <td><?php echo $customer->email; ?></td>
                                            <td><?php echo $customer->username; ?></td>
                                            <td><?php echo $customer->password; ?></td>
                                        </tr>
                                        <?php 
										$i++;
										endforeach; ?>
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
            <?php //include('include/footer.php'); ?>
            <!-- Right sidebar -->
            <?php //include('include/sidebar_right.php'); ?>
            <!-- /right sidebar -->
        </div>
        <!-- /main wrapper -->
    </body>
</html>
