<?php
include('class/auth.php');
include('class/function.php');
$ops = new pos();
function checkin_paid($st) {
	if ($st == 0) {
		return "Unpaid";
	} else {
		return "Paid";
	}
}
extract($_GET);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php echo $obj->bodyhead(); ?>
        <script src="ajax/ticket_ajax.js"></script>
        <!--scroll script-->
        <script type="text/javascript" src="js/jquery_ui_min_1_8_8.js"></script>
        <script type="text/javascript" src="js/facescroll.js"></script>
        <script>
		printDivCSS = new String ('<link href="<?=$obj->baseUrl("css/main.css")?>" rel="stylesheet">')
		function printDiv() {
			
			var rows=document.getElementById('showtextarea').scrollHeight;
			//var cols=document.getElementById('showtextarea').scrollWidth;
			
			$('#printtextarea').height(rows);
			//$('#printtextarea').width(cols);
			
			var canvas=document.getElementById("canvas");
			var image = canvas.toDataURL("image/png");
			document.getElementById('signature-body').innerHTML='<img src="'+image+'"/>';
			
			window.frames["print_frame"].document.body.innerHTML = '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
			window.frames["print_frame"].document.body.innerHTML += printDivCSS;
			window.frames["print_frame"].document.body.innerHTML += document.getElementById('terms-print').innerHTML;
			
			var signaturebody = $("#print_frame").contents().find("#signature-body")
			$(signaturebody).css('border','1px solid black');
			//signaturebody.style.border = "thick solid #0000FF";
			
    		window.frames["print_frame"].window.focus();
    		window.frames["print_frame"].window.print();
			
		}
		</script>
        <!-- scroll script-->
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
                <?php echo $obj->ShowMsg(); 
				if($input_status==1)
				{
					//for admin view checkin
					$chkx = $obj->exists_multiple("check_user_price", array("ckeckin_id"=>$ticket_id));
					if ($chkx == 0) {
						$estp = $obj->SelectAllByVal("product", "name", $obj->SelectAllByVal("checkin_list","checkin_id",$ticket_id,"device") . "-" . $obj->SelectAllByVal("checkin_list","checkin_id",$ticket_id,"problem"), "price_cost");
						if ($estp == '') {
							$devid = $obj->SelectAllByVal("checkin_request", "checkin_id", $ticket_id, "device_id");
							$modid = $obj->SelectAllByVal("checkin_request", "checkin_id", $ticket_id, "model_id");
							$probid = $obj->SelectAllByVal("checkin_request", "checkin_id", $ticket_id, "problem_id");
							$pp = $obj->SelectAllByVal3("checkin_price", "checkin_id", $devid, "checkin_version_id", $modid, "checkin_problem_id", $probid,"name");
						} else {
							$pp = $estp;
						}
					} else {
			
						$estp = $obj->SelectAllByVal("check_user_price", "ckeckin_id", $ticket_id, "price");
						if ($estp == '') {
							$devid = $obj->SelectAllByVal("checkin_request", "checkin_id", $ticket_id, "device_id");
							$modid = $obj->SelectAllByVal("checkin_request", "checkin_id", $ticket_id, "model_id");
							$probid = $obj->SelectAllByVal("checkin_request", "checkin_id", $ticket_id, "problem_id");
							$pp = $obj->SelectAllByVal3("checkin_price", "checkin_id", $devid, "checkin_version_id", $modid, "checkin_problem_id", $probid, "name");
						} else {
							$pp = $estp;
						}
					}
					$pid = $obj->SelectAllByVal("product", "name",$obj->SelectAllByVal("checkin_list","checkin_id",$ticket_id,"device").", " . $obj->SelectAllByVal("checkin_list","checkin_id",$ticket_id,"model") . " - " . $obj->SelectAllByVal("checkin_list","checkin_id",$ticket_id,"problem"), "id");
					$cid=$obj->SelectAllByVal2("coustomer","firstname",$obj->SelectAllByVal("checkin_request","checkin_id",$ticket_id,"first_name"),"phone",$obj->SelectAllByVal("checkin_request","checkin_id",$ticket_id,"phone"),"id");
					$chkcheckin=$obj->exists_multiple("invoice",array("doc_type"=>3,"checkin_id"=>$ticket_id));
					$getsales_id=$obj->SelectAllByVal("invoice","checkin_id",$ticket_id,"invoice_id");
					$curcheck=$obj->exists_multiple("sales",array("sales_id"=>$getsales_id));	
					//for admin view checkin
				}
				else
				{
					//for store view checkin
					$chkx = $obj->exists_multiple("check_user_price", array("ckeckin_id"=>$ticket_id,"store_id"=>$input_by));
					if ($chkx == 0) {
						$estp = $obj->SelectAllByVal2("product", "name", $obj->SelectAllByVal("checkin_list","checkin_id",$ticket_id,"device") . "-" . $obj->SelectAllByVal("checkin_list","checkin_id",$ticket_id,"problem"),"store_id",$input_by, "price_cost");
						if ($estp == '') {
							$devid = $obj->SelectAllByVal("checkin_request", "checkin_id", $ticket_id, "device_id");
							$modid = $obj->SelectAllByVal("checkin_request", "checkin_id", $ticket_id, "model_id");
							$probid = $obj->SelectAllByVal("checkin_request", "checkin_id", $ticket_id, "problem_id");
							$pp = $obj->SelectAllByVal4("checkin_price", "checkin_id", $devid, "checkin_version_id", $modid, "checkin_problem_id", $probid,"store_id",$input_by,"name");
						} else {
							$pp = $estp;
						}
					} else {
			
						$estp = $obj->SelectAllByVal2("check_user_price","ckeckin_id",$ticket_id,"store_id",$input_by,"price");
						if ($estp == '') {
							$devid = $obj->SelectAllByVal("checkin_request", "checkin_id", $ticket_id, "device_id");
							$modid = $obj->SelectAllByVal("checkin_request", "checkin_id", $ticket_id, "model_id");
							$probid = $obj->SelectAllByVal("checkin_request", "checkin_id", $ticket_id, "problem_id");
							$pp = $obj->SelectAllByVal4("checkin_price", "checkin_id", $devid, "checkin_version_id", $modid, "checkin_problem_id", $probid,"store_id",$input_by, "name");
						} else {
							$pp = $estp;
						}
					}
					$pid = $obj->SelectAllByVal2("product", "name",$obj->SelectAllByVal("checkin_list","checkin_id",$ticket_id,"device").", " . $obj->SelectAllByVal("checkin_list","checkin_id",$ticket_id,"model") . " - " . $obj->SelectAllByVal("checkin_list","checkin_id",$ticket_id,"problem"),"store_id",$input_by, "id");
					$cid=$obj->SelectAllByVal2("coustomer","firstname",$obj->SelectAllByVal("checkin_request","checkin_id",$ticket_id,"first_name"),"phone",$obj->SelectAllByVal("checkin_request","checkin_id",$ticket_id,"phone"),"id");
					$chkcheckin=$obj->exists_multiple("invoice",array("doc_type"=>3,"checkin_id"=>$ticket_id));
					$getsales_id=$obj->SelectAllByVal("invoice","checkin_id",$ticket_id,"invoice_id");
					$curcheck=$obj->exists_multiple("sales",array("sales_id"=>$getsales_id));	
					//for store view checkin
				}
				?>
                <!-- /info notice -->

                <div class="outer">
                    <div class="inner">
                        <div class="page-header"><!-- Page header -->
                        	<form>
                            <h5><i class="font-home"></i> Checkin ID : <?php echo $ticket_id; ?> | <a href="checkin_list.php?action=pdf&amp;invoice=<?php echo $ticket_id; ?>&amp;payment_status=<?php echo checkin_paid($curcheck); ?>" target="_blank" class="hovertip" title="Print"  onclick="javascript:return confirm('Are you absolutely sure to Print This Checkin Request ?')"><i class="icon-print"></i></a></h5>
                            <ul class="icons">
                                <li><a href="<?php echo $obj->filename(); ?>" class="hovertip" title="Reload"><i class="font-refresh"></i></a></li>
                            </ul>
                            </form>
                        </div><!-- /page header -->

                        <div class="body">

                            <!-- Middle navigation standard -->
                            <?php //include('include/quicklink.php'); ?>
                            <!-- /middle navigation standard -->

                            <!-- Content container -->
                            <div class="container">
                                <!-- Content Start from here customized -->
                                <form class="form-horizontal" method="get" name="invoice" action="create_invoice.php">
                                    <fieldset>


                                        <div class="row-fluid block">

                                            <!-- General form elements -->
                                            <div class="well row-fluid span4">
                                                <div class="navbar">
                                                    <div class="navbar-inner">
                                                        <h5><i class="icon-tag"></i> Device Checkin Info</h5>
                                                    </div>
                                                </div>

                                                <br>
                                                <div id="checkin_full_detail">
                                                 	<div class="span12">
                                                        <label class="span12"> <strong class="span5">&nbsp; Device : </strong> 
                                                           &nbsp; <?php
                                                            echo $obj->SelectAllByVal("checkin_list", "checkin_id", $ticket_id, "device");
                                                            $device=$obj->SelectAllByVal("checkin_list", "checkin_id", $ticket_id, "device");
                                                            ?>  </label>
                                                    </div>
                                            
                                                    <div class="span12">
                                                        <label class="span12"> <strong class="span5">Model : </strong> 
                                                            <?php
                                                            echo $obj->SelectAllByVal("checkin_list", "checkin_id", $ticket_id, "model");
                                                            $version=$obj->SelectAllByVal("checkin_list", "checkin_id", $ticket_id, "model");
                                                            ?> </label>
                                                    </div>
                                            
                                                    <div class="span12">
                                                        <label class="span12"> <strong class="span5">Color: </strong> 
                                                            <?php
                                                            echo $obj->SelectAllByVal("checkin_list", "checkin_id", $ticket_id, "color");
                                                            ?>
                                                        </label>
                                                    </div>
                                            
                                                    <div class="span12">
                                                        <label class="span12"> <strong class="span5">Network : </strong> 
                                                            <?php
                                                            echo $obj->SelectAllByVal("checkin_list", "checkin_id", $ticket_id, "network");
                                                            ?> </label>
                                                    </div>
                                            
                                                    <div class="span12">
                                                        <label class="span12"> <strong class="span5">Problem: </strong> 
                                                            <?php
                                                            echo $obj->SelectAllByVal("checkin_list", "checkin_id", $ticket_id, "problem");
                                                            $problem=$obj->SelectAllByVal("checkin_list", "checkin_id", $ticket_id, "problem");
                                                            ?> 
                                                        </label>
                                                    </div>
                                            
                                                    <div class="span12">
                                                        <label class="span12"> <strong class="span5">Est. Price: </strong> 
                                                            <?php
                                                                
                                                            ?> 
                                                            <?php if($curcheck==0){ ?>
                                                            <a class="btn btn-info" href="pos.php?newsales=1&amp;pid=<?php echo $pid; ?>&amp;price=<?php echo number_format($pp,2); ?>&amp;checkin_id=<?php echo $ticket_id; ?>&AMP;cid=<?php echo $cid; ?>">$<?php
                                                                if ($pp == '' || $pp == 0) {
                                                                    echo 0;
                                                                } else {
                                                                    echo number_format($pp,2);
                                                                }
                                                                ?> Send To Pos</a>
                                                                <?php }else{ ?>
                                                                <span class="label label-info" href="pos.php?newsales=1&amp;pid=<?php echo $pid; ?>&amp;price=<?php echo number_format($pp,2); ?>&amp;checkin_id=<?php echo $ticket_id; ?>&AMP;cid=<?php echo $cid; ?>">$<?php
                                                                if ($pp == '' || $pp == 0) {
                                                                    echo 0;
                                                                } else {
                                                                    echo number_format($pp,2);
                                                                }
                                                                ?> Paid</span>
                                                            <?php } ?>
                                                        </label>
                                                    </div>
												</div>
                                                <div class="clearfix"></div>
                                                <br>
                                            </div>
                                            <!-- /general form elements -->

                                            <!-- General form elements -->
                                            <div class="well row-fluid span4">
                                                <div class="navbar">
                                                    <div class="navbar-inner">
                                                        <h5><i class="icon-signal"></i> Progress </h5>
                                                    </div>
                                                </div>
                                                <div id="checkin_progress">
                                                	<div class="span12" style="margin-top: 5px; padding-left:7px;">
                                                        <label class="btn btn-warning span10"> 
                                                            1. Diagnostic: <?php echo $ops->TicketWorkAjax("checkin_request_ticket", "checkin_id", $ticket_id, "diagnostic", "diagnostic"); ?></label>
                                                    </div>
                                            
                                                    <!--<div class="clearfix"></div>
                                                    <div class="span12">
                                                        <label class="btn btn-success span10"> 2. Work Approved: <?php // echo $ops->TicketWorkAjax("checkin_request_ticket", "checkin_id", $ticket_id, "work_approved", "work_approved"); ?>  </label>
                                                    </div>-->
                                            
                                            
                                                    <div class="clearfix"></div>
                                                    <div class="span12">
                                                        <label class="btn btn-success span10"> 2. Status Complete: <?php echo $ops->TicketWorkAjax("checkin_request", "checkin_id", $ticket_id, "status", "status"); ?> </label>
                                                    </div>
                                                    
                                                    
                                                    <div class="clearfix"></div>
                                                    <div class="span12">
                                                        <label class="btn btn-info span10"> 3. Warranty Length: 
                                                        <?php
                                                        
                                                        $prn=$device.", ".$version." - ".$problem;
                                                        $pid=$obj->SelectAllByVal("product","name",$prn,"id");
                                                        echo $ops->WarrentyWorkAjax("checkin_request","checkin_id",$ticket_id,"warrenty","warrenty",$pid); ?> 
                                                        </label>
                                                    </div>
                                                    <?php 
                                                    $sqlchklcd=$obj->SelectAllByVal("checkin_request_ticket","checkin_id",$ticket_id,"lcdstatus");
                                                    if($sqlchklcd!=0){
                                                    ?>
                                                    <div class="clearfix"></div>
                                                    <div class="span12" style="padding-bottom:4px;">
                                                        <label class="btn btn-success span10"> 4. LCD Status: 
                                                        <?php 
                                                        echo $ops->LcdWorkAjax("checkin_request_ticket","checkin_id",$ticket_id,"lcdstatus","lcdstatus"); ?> 
                                                        </label>
                                                    </div>
                                                    <?php }else{ ?> <br> <?php } ?>
													
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="clearfix"></div>
                                                <br>
                                            </div>
                                            <!-- /general form elements -->

                                            <!-- General form elements -->
                                            <div class="well row-fluid span4">
                                                <div class="navbar">
                                                    <div class="navbar-inner">
                                                        <h5><i class="font-user"></i> Customer Info </h5>
                                                    </div>
                                                </div>
                                                <div id="checkin_customer_info">
                                                	
                                                    <?php ?>
                                                    <div class="span12" style="margin-top:7px; clear:both;">
                                                        <label class="span12"> <strong class="span5">&nbsp; First Name : </strong> 
                                                           &nbsp; <?php echo $obj->SelectAllByVal("checkin_request", "checkin_id", $ticket_id, "first_name"); ?>
                                                        </label>
                                                    </div>
                                            
                                                    <div class="clearfix"></div>
                                                    <div class="span12">
                                                        <label class="span12"> <strong class="span5">Last Name :  </strong> 
                                                            <?php echo $obj->SelectAllByVal("checkin_request", "checkin_id", $ticket_id, "last_name"); ?>
                                                        </label>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                    <div class="span12">
                                                        <label class="span12"> <strong class="span5">Email :  </strong> 
                                                            <?php echo $obj->SelectAllByVal("checkin_request", "checkin_id", $ticket_id, "email"); ?>
                                                        </label>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                    <div class="span12">
                                                        <label class="span12"> <strong class="span5">Phone :  </strong> 
                                                            <?php echo $obj->SelectAllByVal("checkin_request", "checkin_id", $ticket_id, "phone"); ?>
                                                        </label>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                    <div class="span12">
                                                        <label class="span12"> <strong class="span5">Created By : </strong> 
                                                            <?php echo $obj->SelectAllByVal("store","id",$obj->SelectAllByVal("checkin_request", "checkin_id", $ticket_id, "access_id"),"name"); ?>
                                                        </label>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                    <div class="span12">
                                                        <label class="span12"> <strong class="span5">Checkin Created : </strong> 
                                                            <?php echo $obj->SelectAllByVal("checkin_request", "checkin_id", $ticket_id, "date"); ?>
                                                        </label>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                    <div class="span12">
                                                        <a  data-toggle="modal" href="#signature" class="btn btn-primary "><i class="font-credit-card"></i> Capture Signature </a>
                                                    </div>
                                                    <div class="clearfix"></div>
													
                                                </div>
                                                <div class="clearfix"></div>
                                                <br>

                                            </div>
                                            <!-- /general form elements -->

                                        </div>
                                        
                                        
										


                                        <!-- General form elements -->
                                        <div class="row-fluid  span12 well" style="margin-top: 5px;">     
                                            <div class="navbar">
                                                <div class="navbar-inner">
                                                    <h5><i class="icon-book"></i> Device Additional Information</h5>
                                                </div>
                                            </div>
                                            <!-- Selects, dropdowns -->
                                            <div class="span12" style="padding:0px; margin:0px;">
                                                <div class="navbar">
                                                    <div class="navbar-inner" style="background: none; border-bottom: 1px #CCC dotted;">
                                                        <h5><i class="icon-eye-open"></i> Custom Fields</h5>
                                                    </div>
                                                </div>
                                                <style type="text/css">
                                                    .btnedit
                                                    {
                                                        background:none; 
                                                        border:none;
                                                    }
                                                </style>
                                                <div class="span12" style="margin-bottom: 10px; margin-top: 10px;">
                                                <div id="checkin_custom_fields">
                                                    
													<div class="span12" style="margin-left:-10px;">
                                                    <label class="checkbox span3"> <strong>Password:</strong> 
                                                        <?php echo $ops->common_edit('checkin_request_ticket', 'checkin_id', $ticket_id, 'password', 'password', 'id', "Password"); ?>
                                                    </label>
                                                    <label class="checkbox span3"> <strong>IMEI:</strong> 
                                                        <?php echo $ops->common_edit('checkin_request_ticket', 'checkin_id', $ticket_id, 'imei', 'imei', 'id', "IMEI Code"); ?> 
                                                    </label>
                                                    <label class="checkbox span3"> <strong>Tested Before By :</strong> 
                                                        <?php echo $ops->common_edit('checkin_request_ticket', 'checkin_id', $ticket_id, 'tested_before', 'tested_before', 'id', "Tested By"); ?> 
                                                    </label>
                                                </div>
                                                <div class="span12" style="margin-left:-10px;">
                                                    <label class="checkbox span6 pull-left">
                                                        <strong>Tested After By : </strong>
                                                        <?php echo $ops->common_edit('checkin_request_ticket', 'checkin_id', $ticket_id, 'tested_after', 'tested_after', 'id', "Tested After By"); ?>
                                                    </label>
                                                    <label class="checkbox span6"> <strong>Tech Notes :</strong> 
                                                        <?php echo $ops->common_edit('checkin_request_ticket', 'checkin_id', $ticket_id, 'tech_notes', 'tech_notes', 'id', "Tech Notes"); ?>
                                                    </label>
                                                    <div class="clear" style="margin-bottom:30px;"></div>
                                                </div>
                                    
                                                <div class="span8" id="all_selected_custom">
                                                    <div class="clear block"></div>
                                                    <?php
                                                    $sqlticussel = $obj->SelectAllByID_Multiple("ticket_custom_selection", array("ticket_id" => $ticket_id));
                                                    if (!empty($sqlticussel))
                                                        foreach ($sqlticussel as $sel):
                                                            ?>
                                                            <span class="span4">
                                                                <label class="checkbox" onClick="custom_field_select_delete(<?php echo $sel->id; ?>,<?php echo $ticket_id; ?>,<?php echo $fields->id; ?>, 'all_selected_custom', 'lastnewsscroll')"><div id="uniform-undefined" class="checker">
                                                                        <span class="checked"><input style="opacity: 0;" name="<?php echo $sel->id; ?>" id="<?php echo $sel->id; ?>" class="style" type="checkbox" value="<?php echo $sel->id; ?>" checked></span>
                                                                    </div> 
                                                                    <?php echo $obj->SelectAllByVal("ticket_custom_field", "id", $sel->fid, "name"); ?>
                                                                </label>
                                                            </span>
                                                            <?php
                                                        endforeach;
                                                    ?>
                                                </div>
                                    
                                    
                                    
                                    
                                    
                                    
                                                <div class="clearfix"></div>

                                                </div>







                                                <div class="clearfix"></div>

                                                <!-- Default datatable -->

                                                <!-- /default datatable -->


                                                </fieldset>                     

                                                </form>


                                                <!-- Content End from here customized -->




                                                <div class="separator-doubled"></div> 



                                            </div>
                                            <!-- /content container -->

                                        </div>
                                        </div>
                                        </div>
                                        </div>
                                        <!-- /main content -->
                                        
                                        <!-- Dialog signature -->
                                        <?php
											require_once 'lib/save-signature.php';
											$getSign=$obj->SelectAllByVal("signatures", "checkin_id", $ticket_id, "signature");
											$_SESSION['getSign']=$getSign;
										?>
                                        <div id="signature" class="modal hide fade" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                                                <h5 id="myModalLabel"> Capture Signature</h5>
                                            </div>
                                            
                                                <div class="modal-body">

                                                    <div class="row-fluid">

                                                        <div class="control-group">
                                                            <label class="span4">Terms & Conditions: </label>
                                                        </div>
                                                        <div class="control-group">
                                                        <textarea class="span12" rows="12" cols="100" id="showtextarea" readonly style="resize: none;">
                                                        <?php
															$store_id = $obj->SelectAllByVal("store","id",$_SESSION['SESS_AMSIT_APPS_ID'],"store_id");
															$terms='';
															if($getSign==''){
																$terms=$obj->SelectAllByVal("setting_report","store_id",$store_id,"fotter");
															}else{
																$terms=$obj->SelectAllByVal("signatures", "checkin_id", $ticket_id, "terms");
															}
															$_SESSION['terms']=$terms;
															echo $terms;
															
														?>
                                                        </textarea>
                                                        </div>
                                                        
                                                        <div class="control-group">
                                                        <?php
															include('signature.php');
														?>
                                                        </div>
                                                        
                                                    </div>

                                                </div>
                                                
                                                <div class="modal-footer" id="buttonshow">
                                                <?php
													if($getSign!=''){
														?>
														<div class="control-group">
															<button class="btn btn-success" onclick="printDiv()"> <span class="glyphicon glyphicon-print"></span> Print</button>
														</div>
														<?php
														}
												?>
                                                </div>
                                           
                                        </div>
                                        
                                        <div class="modal-body" id="terms-print" style="display:none">

                                            <div class="row-fluid">

                                                <div class="control-group">
                                                    <label class="span4">Terms & Conditions: </label>
                                                </div>
                                                <div class="control-group">
                                                <textarea class="span12" id="printtextarea" readonly cols="100">
                                                <?php
                                                    echo $terms;
                                                ?>
                                                </textarea>
                                                </div>
                                                
                                                <div class="control-group">
                                                    <label class="span4">Customer Signature: </label>
                                                </div>
                                                <div class="control-group" id="signature-body" style="border:#000 1px">
                                                </div>
                                                
                                                <div class="control-group" id="signature-body">
                                                Customer Name: <?php echo $obj->SelectAllByVal("checkin_request", "checkin_id", $ticket_id, "first_name").' '.$obj->SelectAllByVal("checkin_request", "checkin_id", $ticket_id, "last_name"); ?>
                                                </div>
                                                
                                            </div>

                                        </div>
                                        
                                        <!--for print-->
                                        <iframe name="print_frame" id="print_frame" width="0" height="0" frameborder="0" src="about:blank">
                                        </iframe>
                                        <!--for print-->
                                        
                                        <!-- /dialog signature -->
                                        
                                        <?php include('include/footer.php'); ?>
                                        <!-- Right sidebar -->
                                        <?php //include('include/sidebar_right.php');  ?>
                                        <!-- /right sidebar -->

                                        </div>
                                        <!-- /main wrapper -->

                                        </body>
                                        </html>
