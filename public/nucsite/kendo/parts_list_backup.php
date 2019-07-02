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
        <?php echo $obj->bodyhead(); ?>
    </head>

    <body>
        <?php include('include/header.php'); ?>
        <!-- Main wrapper -->
        <div class="wrapper">

            <!-- Left sidebar -->
            <?php //include('include/sidebar_left.php'); ?>
            <!-- /left sidebar -->
            <!-- Main content -->
            <div class="content" style="margin-left:0;">

                <!-- Info notice -->
                <?php echo $obj->ShowMsg(); ?>
                <!-- /info notice -->
 <?php include('include/quicklink.php'); ?>
                <div class="outer">
                    <div class="inner">
                        <div class="page-header"><!-- Page header -->
                            <h5><i class="font-home"></i> <span style="border-right:2px #333 solid; padding-right:10px;">Parts Order Info</span>
                            <span><a data-toggle="modal" href="#myModal"> Generate Parts Order Report</a></span>
                            </h5>
                            <ul class="icons">
                                <li><a href="<?php echo $obj->filename(); ?>" class="hovertip" title="Reload"><i class="font-refresh"></i></a></li>
                            </ul>
                        </div><!-- /page header -->

                        <div class="body">

                            <!-- Middle navigation standard -->
                           <!-- Dialog content -->
                        <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h5 id="myModalLabel">Generate Parts Order Report <span id="mss"></span></h5>
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
                                    <button class="btn btn-primary" name="all" type="submit">Show All Parts Order</button>
                                    </form>
                                </div>
                        </div>
                        <!-- /dialog content -->
                            <!-- /middle navigation standard -->

                            <!-- Content container -->
                            <div class="container">
                                
                                
                                <!-- Content Start from here customized -->
                                
                                
                                <!-- Default datatable -->
                            <div class="table-overflow">
                                <table class="table table-striped" id="data-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>ID</th>
                                            <th>Entered </th>
                                            <th>Ticket </th>
                                            <th>Customer </th><th>Parturl</th>
                                            <th>Description</th>
                                            <th>Price</th>                                            
                                            <th>Bought</th>
                                            <th>Tracking</th>
                                            <th>Arrived</th>
                                            
                                            
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
										if($input_status==1)
										{
											if(isset($_GET['from']))
											{
												$sql_coustomer=$obj->SelectAll_ddate($table,"date",$_GET['from'],$_GET['to']);
											}
											elseif(isset($_GET['all']))
											{
												$sql_coustomer=$obj->SelectAll($table);
											}
											else
											{
												$sql_coustomer=$obj->SelectAllByID($table,array("date"=>date('Y-m-d')));
											}
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
												
												if(isset($_GET['from']))
												{
													include('class/report_chain_admin.php');	
													$obj_report_chain = new chain_report();
													$sql_coustomer=$obj_report_chain->ReportQuery_Datewise_Or($table,$array_ch,"input_by",$_GET['from'],$_GET['to'],"1");
												}
												elseif(isset($_GET['all']))
												{
													include('class/report_chain_admin.php');	
													$obj_report_chain = new chain_report();
													$sql_coustomer=$obj_report_chain->SelectAllByID_Multiple_Or($table,$array_ch,"input_by","1");
												}
												else
												{
													include('class/report_chain_admin.php');	
													$obj_report_chain = new chain_report();
													$sql_coustomer=$obj_report_chain->SelectAllByID_Multiple2_Or($table,array("date"=>date('Y-m-d')),$array_ch,"input_by","1");
												}
												//echo "Work";
											}
											else
											{
												//echo "Not Work";
												$sql_coustomer="";
											}
										}
										else
										{
											if(isset($_GET['from']))
											{
												include('class/report_customer.php');	
												$obj_report = new report();
												$sql_coustomer=$obj_report->ReportQuery_Datewise($table,array("input_by"=>$input_by),$_GET['from'],$_GET['to'],"1");
											}
											elseif(isset($_GET['all']))
											{
												$sql_coustomer=$obj->SelectAllByID($table,array("input_by"=>$input_by));
											}
											else
											{
												$sql_coustomer=$obj->SelectAllByID_Multiple($table,array("input_by"=>$input_by,"date"=>date('Y-m-d')));
											}
										}
										/*if($input_status==1){
                                        	$sql_parts_order=$obj->SelectAll($table);
										}
										else
										{
											$sql_parts_order=$obj->SelectAllByID_Multiple($table,array("input_by"=>$input_by));
										}*/
										
										$i=1;
										if(!empty($sql_coustomer))
										foreach($sql_coustomer as $row):
										?>
                                        <tr>
                                            <td><?php echo $i; $cid=$obj->SelectAllByVal("ticket","ticket_id",$row->ticket_id,"cid"); ?></td>
                                            <td> <?php echo $row->id; ?> </td>
                                            <td> <?php echo $row->date; ?> </td>
                                            
                                            <td><a href="view_ticket.php?ticket_id=<?php echo $row->ticket_id; ?>"><?php echo $row->ticket_id; ?></a></td>
                                            <td><a href="customer.php?edit=<?php echo $cid; ?>">
											<?php echo $obj->SelectAllByVal("coustomer","id",$cid,"businessname"); ?>
                                            </a></td>
                                            <td><a href="<?php echo $row->part_url; ?>" target="_blank"><?php echo substr($row->part_url,0,25); ?></a></td>
                                            <td><label class="label label-success"> <?php echo $row->description; ?>  </label></td>
                                            <td> <?php echo $row->cost; ?> </td>
                                            <td><?php echo $row->ordered; ?></td>
                                            <td><a target="_blank" href="http://www.google.com/search?&amp;q=<?php echo $row->trackingnum; ?>"><?php echo $row->trackingnum; ?></a></td>
                                            <td><?php echo $row->received; ?></td>
                                            <td>
                                            <?php if($input_status==1 || $input_status==2 || $input_status==5){ ?> 
                                            	<a href="parts.php?edit=<?php echo $row->id; ?>" class="btn btn-info hovertip" title="Edit"><i class="icon-edit"></i></a> 
                                                <a href="<?php echo $obj->filename(); ?>?del=<?php echo $row->id; ?>" class="btn btn-danger hovertip" title="Delete"><i class="icon-remove"></i></a>
                                            <?php 
											}
											else
											{
											 ?>
                                             <a href="parts.php?edit=<?php echo $row->id; ?>" class="btn btn-info hovertip" title="Edit"><i class="icon-edit"></i></a> 
                                             <?php } ?>    
                                            </td>
                                        </tr>
                                        <?php 
										$i++;
										endforeach; 
										?>
                                    </tbody>
                                </table>
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
