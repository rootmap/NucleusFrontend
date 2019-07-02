<?php 
include('class/auth.php');
include('class/function.php');
$ops=new pos();
extract($_GET);

if (isset($_GET['print_invoice'])) {

    $cart = $_GET['print_invoice'];
    $cid = $obj->SelectAllByVal("unlock_request", "unlock_id", $cart, "cid");
    $creator = $obj->SelectAllByVal("unlock_request", "unlock_id", $cart, "uid");
    $pt = $obj->SelectAllByVal("unlock_request", "unlock_id", $cart, "payment_type");
    $ckid =$cart;
    $tax_statuss =0;
    if($tax_statuss==0){ $taxs=0; }else{ $taxs=$tax_per_product; }
    include("pdf/MPDF57/mpdf.php");
    $html.="<table id='sample-table-2' class='table table-hover' border='1'><tbody>";

	$report_cpmpany_name=$obj->SelectAllByVal("setting_report","store_id",$input_by,"name");
	$report_cpmpany_address=$obj->SelectAllByVal("setting_report","store_id",$input_by,"address");
	$report_cpmpany_phone=$obj->SelectAllByVal("setting_report","store_id",$input_by,"phone");
	$report_cpmpany_email=$obj->SelectAllByVal("setting_report","store_id",$input_by,"email");
	$report_cpmpany_fotter=$obj->SelectAllByVal("setting_report","store_id",$input_by,"fotter");

	function limit_words($string, $word_limit){
		$words = explode(" ",$string);
		return implode(" ",array_splice($words,0,$word_limit));
	}
	
	$addressfline=limit_words($report_cpmpany_address,3);
	$lengthaddress=strlen($addressfline);
	$lastaddress=substr($report_cpmpany_address,$lengthaddress,30000);



    $html .="<tr>
			<td style='height:40px; background:rgba(0,51,153,1);'>
				<table style='width:100%; height:40px; border:0px;'>
					<tr>
						<td width='87%' style='background:rgba(0,51,153,1);  color:#FFF; font-size:25px;'>&ldquo;Unlock Service&rdquo; by ".$report_cpmpany_name."</td><td width='13%' style='background:rgba(0,51,153,1);  color:#FFF; font-size:30px;'><span style='float:left; text-align:left;'>Invoice</span></td>
					</tr>
				</table>
			</td>
		  </tr>
		  <tr>
			<td style='height:40px;' valign='top'>
				<table style='width:960px; height:40px; font-size:12px; border:0px;'>
					<tr>
						<td width='69%'>
						".$addressfline."<br>
						".$lastaddress."
						</td>
						<td width='31%'>
						DIRECT ALL INQUIRIES TO:<br />
						".$report_cpmpany_name."<br />
						".$report_cpmpany_phone."<br />
						".$report_cpmpany_email."<br />
						</td>
					</tr>
				</table>
			</td>
		  </tr>
		  <tr>
			<td style='height:30px;' valign='top'>
				<table style='width:100%; height:40px; border:0px; font-size:18px;'>
					<tr>
						<td> Customer Info: </td>
					</tr>
				</table>
			</td>
		  </tr>
		  <tr>
			<td style='height:40px;' valign='top'>
				<table style='width:960px; height:40px; border:0px;'>
					<tr>
						<td width='69%'>
						Name : " . $obj->SelectAllByVal("coustomer", "id", $cid, "firstname") . "<br />
						Address : " . $obj->SelectAllByVal("coustomer", "id", $cid, "address") . "<br />
						City, State, Zip : " . $obj->SelectAllByVal("coustomer", "id", $cid, "address") . "<br />
						Phone : " . $obj->SelectAllByVal("coustomer", "id", $cid, "phone") . "<br />
						</td>
					</tr>
				</table>
			</td>
		  </tr>
		  
		  <tr>
			<td style='height:40px;' valign='top'>
				<table style='width:960px; height:40px; border:0px;'>
					<tr>
						<td width='69%'>
						Phone Repair Center <br />
						We Repair | We Buy | We Sell <br />
						</td>
						<td width='31%'>
						INVOICE DATE  : " . $obj->SelectAllByVal("unlock_request", "unlock_id", $cart, "date") . "<br />
						ORDER NO. : " . $cart . "<br />
						SALES REP : " . $obj->SelectAllByVal("store","id",$obj->SelectAllByVal("unlock_request","unlock_id",$cart,"access_id"),"name") . "<br />
						</td>
					</tr>
				</table>
			</td>
		  </tr>
		  
		  <tr>
			<td style='height:40px;' valign='top'>
				<table style='width:100%; height:40px; border:0px;'>
					<tr>
						<td width='79%'>
						Sales Tax Rate:  " . $taxs . "%
						</td>
					</tr>
				</table>
			</td>
		  </tr>
		  
		  <tr>
			<td valign='top' style='margin:0; padding:0; width:100%;'>
				<table style='width:960px;border:1px; font-size:12px; background:#ccc;'>";
    $html.="<thead><tr>
						<td>S/L</td>
						<td>Quantity</td>
						<td>Description</td>
						<td>Unit Price</td>
						<td>Amount</td>
					</tr></thead>";
            $html.="<thead><tr>
						<td>1.</td>
						<td>1</td>
						<td>" . $obj->SelectAllByVal("unlock_service","id",$obj->SelectAllByVal("unlock_request", "unlock_id", $cart,"service_id"),"name") . "</td>
						
						<td>" . $obj->SelectAllByVal("unlock_request", "unlock_id", $cart,"retail_cost") . "</td>
						<td>" . $obj->SelectAllByVal("unlock_request", "unlock_id", $cart,"retail_cost") . "</td>
					</tr></thead>";

        $pp = $obj->SelectAllByVal("payment_method", "id", $obj->SelectAllByVal("unlock_request", "unlock_id",$cart,"payment_method"), "meth_name");
    $total = $obj->SelectAllByVal("unlock_request", "unlock_id", $cart,"retail_cost");
        $dd = number_format($total, 2);
    $paid = number_format($total, 2);
        $ff = number_format($total, 2);

    $due =0;
    $html.="</table></td></tr>";

        $html.="<tr><td><table style='width:960px;'>
					<thead>
						<tr>
							<td width='350' valign='top'>";
		  		$html.="<table style='width:300px;border:1px; margin-left:-4px; font-size:12px; background:#ccc;'>
					<thead>
						<tr>
							<th>IMEI of Device being repair : </th>
							<th>".$obj->SelectAllByVal("unlock_request", "unlock_id",$cart,"imei")."</th>
						</tr>
						<tr>
							<th>Carrier :  </th>
							<th>".$obj->SelectAllByVal("unlock_request", "unlock_id",$cart,"carrier")."</th>
						</tr>
						<tr>
							<th>Type &amp; Color :  </th>
							<th>".$obj->SelectAllByVal("unlock_request", "unlock_id",$cart,"type_color")."</th>
						</tr>
						<tr>
							<th>Password :  </th>
							<th>".$obj->SelectAllByVal("unlock_request", "unlock_id",$cart,"password")."</th>
						</tr>
						<tr>
							<th>Note :  </th>
							<th>".$obj->SelectAllByVal("unlock_request", "unlock_id",$cart,"note")."</th>
						</tr>
						<tr>
							<th>Comment :  </th>
							<th>".$obj->SelectAllByVal("unlock_request", "unlock_id",$cart,"comment")."</th>
						</tr>
						<tr>
							<th>Respond Email :  </th>
							<th>".$obj->SelectAllByVal("unlock_request", "unlock_id",$cart,"respond_email")."</th>
						</tr>
					</thead>
					
				</table>";
		  
				$html.="</td>
				<td valign='top'>
					<table style='width:250px;border:1px; font-size:12px; background:#ccc;'>
						<thead>
							<tr>
								<th>Payment Type: </th>
								<th>" . $pp . "</th>
							</tr>
							<tr>
								<th>Sub - Total: </th>
								<th>" . number_format($total, 2) . "</th>
							</tr>
							<tr>
								<th>Tax: </th>
								<th>" . number_format($tax, 2) . "</th>
							</tr>
							<tr>
								<th>Total: </th>
								<th>" . number_format($total, 2) . "</th>
							</tr>";
						if($pp=='')
						{
							$html.="<tr>
								<th>Payments: </th>
								<th>" . $due . "</th>
							</tr>
							<tr>
								<th>Balance Due: </th>
								<th>" . $paid . "</th>
							</tr>";
						}
						else
						{
							$html.="<tr>
								<th>Payments: </th>
								<th>" . $paid . "</th>
							</tr>
							<tr>
								<th>Balance Due: </th>
								<th>" . $due . "</th>
							</tr>";
						}
						$html.="</thead>
					</table>
				</td>
				</tr>
				</thead>
				</table>
		  </td>
		  </tr>
		  <tr>
		  <td>
				
		  </td>
		  </tr>";
    $html.="<tr>
			<td align='center' style='font-size:8px;'>".$report_cpmpany_fotter."</td>
		  </tr>
		  <tr>
			<td align='center'>Thank You For Your Business</td>
		  </tr>";
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
        <script src="ajax/ticket_ajax.js"></script>
        <!--scroll script-->
			<script type="text/javascript" src="js/jquery_ui_min_1_8_8.js"></script>
            <script type="text/javascript" src="js/facescroll.js"></script>
        <!-- scroll script-->
        <style type="text/css">
			button{ background:none; border:none; }
		</style>
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
                            <h5><i class="font-home"></i>Unlock Request ID : <?php echo $unlock_id; ?></h5>
                            <ul class="icons">
                                <li><a href="<?php echo $obj->filename(); ?>?unlock_id=<?php echo $unlock_id; ?>&amp;cid=<?php echo $cid; ?>" class="hovertip" title="Reload"><i class="font-refresh"></i></a></li>
                            </ul>
                        </div><!-- /page header -->

                        <div class="body">

                            <!-- Middle navigation standard -->
                            <?php //include('include/quicklink.php'); ?>
                            <!-- /middle navigation standard -->

                            <!-- Content container -->
                            <div class="container">

										<a href="<?php echo $obj->filename(); ?>?print_invoice=<?php echo $_GET['unlock_id']; ?>" target="_blank" class="btn btn-success" onclick="javascript:return confirm('Are you absolutely sure to Print This Request Invoice : <?php echo $_GET['unlock_id']; ?> ?')"> Print Unlock Request Invoice</a>


                                <!-- Content Start from here customized -->
								

                                <!--<form class="form-horizontal" method="get" name="invoice" action="create_invoice.php">-->
                                    <fieldset>
                                    
                                    
                                        <div class="row-fluid block">
											
                                            <!-- General form elements -->
                                            <div class="well row-fluid span6">
                                                <div class="navbar">
                                                    <div class="navbar-inner">
                                                        <h5><i class="icon-tag"></i> Unlock Service Request Info</h5>
                                                    </div>
                                                </div>

                                                <br>
                                                <div class="span12">
                                                    <label class="span12"> <strong class="span5">Status: </strong> 
                                                    <?php echo $ops->TicketStatusAjax("unlock_request","unlock_id",$unlock_id,"status","status"); ?>  </label>
                                                </div>
                                               <div class="span12">
                                                    <label class="span12"> <strong class="span5">Created By: </strong> <?php echo $obj->SelectAllByVal("store","id",$obj->SelectAllByVal("unlock_request","unlock_id",$unlock_id,"access_id"),"name"); ?> </label>
                                                </div>
                                                <div class="span12">
                                                    <label class="span12"> <strong class="span5">Created: </strong> <?php echo $obj->SelectAllByVal("unlock_request","unlock_id",$unlock_id,"date"); ?> </label>
                                                </div>
                                                <div class="span12">
                                                    <label class="span12"> <strong class="span5">Service Requested: </strong> <?php echo $obj->SelectAllByVal("unlock_service","id",$obj->SelectAllByVal("unlock_request","unlock_id",$unlock_id,"service_id"),"name"); ?> </label>
                                                </div>
                                                
                                                <div class="span12">
                                                    <label class="span12"> <strong class="span5">Our Cost: </strong> <?php echo $ops->SingleFieldEdit("unlock_request","unlock_id",$unlock_id,"our_cost","our_cost","Our Cost"); ?> </label>
                                                </div>
                                                
                                                <div class="span12">
                                                    <label class="span12"> <strong class="span5">Retail Cost: </strong> <?php echo $ops->SingleFieldEdit("unlock_request","unlock_id",$unlock_id,"retail_cost","retail_cost","Retail Cost"); ?> </label>
                                                </div>
                                                
                                                <div class="clearfix"></div>
                                                <br>
                                            </div>
                                            <!-- /general form elements -->

                                            <!-- General form elements -->
                                           <!-- <div class="well row-fluid span4">
                                                <div class="navbar">
                                                    <div class="navbar-inner">
                                                        <h5><i class="icon-signal"></i> Progress </h5>
                                                    </div>
                                                </div>
                                                <div class="span12" style="margin-top: 5px;">
                                                    <label class="btn btn-warning span10"> 
                                                    1. Diagnostic: <?php /*echo $ops->TicketWorkAjax("unlock_request", "unlock_id",$buyback_id,"diagnostic","diagnostic"); ?></label>
                                                </div>                                                
                                                
                                                
                                                <div class="clearfix"></div>
                                                <div class="span12">
                                                    <label class="btn btn-danger span10"> 2. Work Completed: <?php echo $ops->TicketWorkAjax("unlock_request", "unlock_id",$buyback_id,"work_completed","work_completed"); ?> </label>
                                                </div>
                                                <div class="clearfix"></div>
                                                
                                                <div class="clearfix"></div>
                                                <div class="span12">
                                                    <label class="btn btn-primary span10"> 3. Invoiced: <?php echo $ops->TicketWorkAjax("unlock_request", "unlock_id",$buyback_id,"invoice","invoice");*/ ?>  </label>
                                                </div>
                                                <div class="clearfix"></div>
                                                
                                                
                                                <br>
                                                <br>
                                            </div>-->
                                            <!-- /general form elements -->
                                            
                                             <!-- General form elements -->
                                            <div class="well row-fluid span6">
                                                <div class="navbar">
                                                    <div class="navbar-inner">
                                                        <h5><i class="font-user"></i> Customer </h5>
                                                    </div>
                                                </div>
												<?php $cid=$obj->SelectAllByVal("unlock_request","unlock_id",$unlock_id,"cid"); ?>
                                                <div class="span12" style="margin-top:7px; clear:both;">
                                                    <label class="span12"> <strong class="span5">Customer: </strong> 
                	<?php echo $ops->SingleFieldEdit("coustomer","id",$cid,"firstname","firstname","Customer Name"); ?>
                                                    </label>
                                                </div>

                                                <div class="clearfix"></div>
                                                <div class="span12">
                                                    <label class="span12"> <strong class="span5">Company :  </strong> 
                    <?php echo $ops->SingleFieldEdit("coustomer","id",$cid,"businessname","businessname","Customer Name"); ?>
                                                    </label>
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="span12">
                                                    <label class="span12"> <strong class="span5">Email:  </strong> 
                   <?php echo $ops->SingleFieldEdit("coustomer","id",$cid,"email","email","Email"); ?>
                                                    </label>
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="span12">
                                                    <label class="span12"> <strong class="span5">Invoice Email:  </strong> 
                   <?php echo $ops->SingleFieldEdit("coustomer","id",$cid,"invoice_email","invoice_email","Invoice Email"); ?>
                                                    </label>
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="span12">
                                                    <label class="span12"> <strong class="span5">Phone: </strong> 
                   <?php echo $ops->SingleFieldEdit("coustomer","id",$cid,"phone","phone","Phone Number"); ?> 
                                                    </label>
                                                </div>
                                                
                                                <div class="clearfix"></div>
                                                <br>
                           
                                            </div>
                                            <!-- /general form elements -->
                                            <!-- General form elements -->
                                            <div class="well row-fluid span12" style="margin-left:0px; margin-top:20px;">
                                                <div class="navbar">
                                                    <div class="navbar-inner">
                                                        <h5><i class="icon-tag"></i> Unlock Service Detail</h5>
                                                    </div>
                                                </div>

                                                <br>                                                
                                                <div class="span5">
                                                    <label class="span12"> <strong class="span5">Carrier: </strong> <?php echo $ops->SingleFieldEdit("unlock_request","unlock_id",$unlock_id,"carrier","carrier","Device Carrier"); ?>  </label>
                                                </div>
                                                
                                                
                                                
                                                <div class="span5">
                                                    <label class="span12"> <strong class="span5">IMEI: </strong> 
													<?php echo $ops->SingleFieldEdit("unlock_request","unlock_id",$unlock_id,"imei","imei","Device IMEI"); ?> </label>
                                                </div>
                                                
                                                <div class="span5">
                                                    <label class="span12"> <strong class="span5">Type & Color: </strong> <?php echo $ops->SingleFieldEdit("unlock_request","unlock_id",$unlock_id,"type_color","type_color","Device Type &amp; Color"); ?> </label>
                                                </div>
                                                
                                                <div class="span5">
                                                    <label class="span12"> <strong class="span5">Password: </strong> 
													<?php echo $ops->SingleFieldEdit("unlock_request","unlock_id",$unlock_id,"password","password","Device Password"); ?> </label>
                                                </div>
                                                
                                                <div class="span5">
                                                    <label class="span12"> <strong class="span5">Note : </strong> <?php echo $ops->SingleFieldEdit("unlock_request","unlock_id",$unlock_id,"note","note","Device Note"); ?> </label>
                                                </div>
                                                
                                                <div class="span5">
                                                    <label class="span12"> <strong class="span5">Comment : </strong> 
													<?php echo $ops->SingleFieldEdit("unlock_request","unlock_id",$unlock_id,"comment","comment","Comment Here"); ?> </label>
                                                </div>
                                                
                                                <div class="span5">
                                                    <label class="span12"> <strong class="span5">Respond Email: </strong> <?php echo $ops->SingleFieldEdit("unlock_request","unlock_id",$unlock_id,"respond_email","respond_email","Type Respond Email Here"); ?> </label>
                                                </div>
                                                
                                                
                                                <div class="clearfix"></div>
                                                <br>
                                            </div>
                                            <!-- /general form elements -->

                                        </div>

                                        


                                        
                                        
                             


							<div class="clearfix"></div>

									 <!-- Default datatable -->
                        
                        <!-- /default datatable -->
									

                                    </fieldset>                     

                                <!--</form>-->


                                <!-- Content End from here customized -->




                                <div class="separator-doubled"></div> 



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
