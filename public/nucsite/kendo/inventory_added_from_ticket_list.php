<?php
include('class/auth.php');
if($input_status==3 || $input_status==4)
{
	$obj->Error("Invalid Page Request.","index.php");
}
$table="product";
if(isset($_GET['del']))
{
	$obj->deletesing("id",$_GET['del'],$table);	
}

if(isset($_GET['delbarcode']))
{
	$obj->delete("checkin_price",array("barcode"=>$_GET['delbarcode']));
	$obj->deletesing("barcode",$_GET['delbarcode'],$table);	
}

if(@$_GET['export']=="excel") 
{
$record_label="Inventory List Report"; 
header('Content-type: application/excel');
$filename ="Inventory_list_".date('Y_m_d').'.xls';
header('Content-Disposition: attachment; filename='.$filename);

$data = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">
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
$data .="<h3>".$record_label."</h3>";
$data .="<h5>Inventory List Generate Date : ".date('d-m-Y H:i:s')."</h5>";

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


		if($input_status==1){
		   $sql_product=$obj->Product_report("product","status","1","status","3","1");
		}else{
$sql_product=$obj->Product_report_Store("product","status","1","status","3","1","input_by",$input_by);	
			//$sql_product=$obj->Product_report("product","status","1","status","3","1");
		}
		$i=1;
		if(!empty($sql_product))
		foreach($sql_product as $product):
		
		$sqlsalesproduct=$obj->SelectAllByID_Multiple("sales",array("pid"=>$product->id));
		$sold=0;
		if(!empty($sqlsalesproduct))
		{
			foreach($sqlsalesproduct as $soldproduct):
				$sold+=$soldproduct->quantity;
			endforeach;
		}
		else
		{
			$sold+=0;
		}
		
		$instock=$product->quantity-$sold;
		
			$data.="<tr>
				<td>".$i."</td>
				<td>".$product->barcode."</td>
				<td>".$product->name."</td>
				<td>".$product->description."</td>
				<td>".$product->price_cost." Days</td>
				<td>".$product->price_retail."</td>
				<td>".$instock."</td>
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

if(@$_GET['export']=="pdf") 
{
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
						<td> Inventory List Generate Date : ".date('d-m-Y H:i:s')."</td>
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

		if($input_status==1){
		   $sql_product=$obj->Product_report("product","status","1","status","3","1");
		}else{
$sql_product=$obj->Product_report_Store("product","status","1","status","3","1","input_by",$input_by);	
			//$sql_product=$obj->Product_report("product","status","1","status","3","1");
		}
		$i=1;
		if(!empty($sql_product))
		foreach($sql_product as $product):
		
		$sqlsalesproduct=$obj->SelectAllByID_Multiple("sales",array("pid"=>$product->id));
		$sold=0;
		if(!empty($sqlsalesproduct))
		{
			foreach($sqlsalesproduct as $soldproduct):
				$sold+=$soldproduct->quantity;
			endforeach;
		}
		else
		{
			$sold+=0;
		}
		
		$instock=$product->quantity-$sold;
		
			$html.="<tr>
				<td>".$i."</td>
				<td>".$product->barcode."</td>
				<td>".$product->name."</td>
				<td>".$product->description."</td>
				<td>".$product->price_cost." Days</td>
				<td>".$product->price_retail."</td>
				<td>".$instock."</td>
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
        <?php echo $obj->bodyhead(); ?>
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
                            <h5><i class="font-home"></i>Products and Inventory Added From Ticket Info</h5>
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
                                <table class="table table-striped" id="data-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Barcode</th>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Cost</th>
                                            <th>Retail</th>
                                            <th>In Stock</th>
                                            <!--<th>Quantity</th>-->
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
										if($input_status==1)
										{
                                        	$sql_product=$obj->SelectAllByID("product",array("status"=>2));
										}
										else
										{
											$sql_product=$obj->SelectAllByID_Multiple("product",array("status"=>2,"input_by"=>$input_by));	
										}
										$i=1;
										if(!empty($sql_product))
										foreach($sql_product as $product):
										?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $product->barcode; ?></td>
                                            <td><label class="label label-success"> <?php echo $product->name; ?> </label></td>
                                            <td><?php echo $product->description; ?></td>
                                            <td><?php echo $product->price_cost; ?></td>
                                            <td><?php echo $product->price_retail; ?></td>
                                            <td><?php 
											$sqlsalesproduct=$obj->SelectAllByID_Multiple("sales",array("pid"=>$product->id));
											$sold=0;
											if(!empty($sqlsalesproduct))
											{
												foreach($sqlsalesproduct as $soldproduct):
													$sold+=$soldproduct->quantity;
												endforeach;
											}
											else
											{
												$sold+=0;
											}
											
											$instock=$product->quantity-$sold;
											
											echo $instock; ?></td>
                                         <!--<td><label class="label label-primary"> <?php //echo $product->quantity; ?> </label></td>-->
                                         <td><a href="inventory_stockout.php?pid=<?php echo $product->id; ?>" class="label label-warning hovertip" title="StockOut Product"><i class="icon-download"></i></a> <a href="inventory_stockin.php?pid=<?php echo $product->id; ?>" class="label label-info hovertip" title="Stockin Product"><i class="icon-upload"></i></a></td>
                                         <td>
                                         <?php if($input_status==1 || $input_status==2) { ?>
                                         	<a href="inventory.php?edit=<?php echo $product->id; ?>" class="hovertip" title="Edit Product"><i class="icon-edit"></i></a> 
                                            <?php if($product->status==3){ ?>
                                         		<a href="<?php echo $obj->filename(); ?>?delbarcode=<?php echo $product->barcode; ?>" class="hovertip" title="Delete Product" onclick="javascript:return confirm('Are you absolutely sure to delete This Product ?')"><i class="icon-trash"></i></a>
                                            <?php }else{ ?>
                                            	<a href="<?php echo $obj->filename(); ?>?del=<?php echo $product->id; ?>" class="hovertip" title="Delete Product" onclick="javascript:return confirm('Are you absolutely sure to delete This Product ?')"><i class="icon-trash"></i></a>
                                            <?php } ?>
                                         <?php } ?>
                                         </td>
                                        </tr>
                                        <?php 
										$i++;
										
										endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /default datatable -->
                                
                                
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
            <?php include('include/footer.php'); ?>
            <!-- Right sidebar -->
            <?php //include('include/sidebar_right.php'); ?>
            <!-- /right sidebar -->

        </div>
        <!-- /main wrapper -->

    </body>
</html>
