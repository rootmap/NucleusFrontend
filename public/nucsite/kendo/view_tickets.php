<?php 
include('class/auth.php');
include('class/function.php');
$ops=new pos();
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
                <?php echo $obj->ShowMsg(); ?>
                <!-- /info notice -->

                <div class="outer">
                    <div class="inner">
                        <div class="page-header"><!-- Page header -->
                            <h5><i class="font-home"></i>Ticket ID : <?php echo $ticket_id; ?></h5>
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
                                <form class="form-horizontal" method="get" name="invoice" action="create_invoice.php">
                                    <fieldset>
                                        <div class="row-fluid block">
											<!-- General form elements -->
                                            <div class="well row-fluid span4">
                                                <div class="navbar">
                                                    <div class="navbar-inner">
                                                        <h5><i class="icon-tag"></i> Ticket Info</h5>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="span12">
                                                    <label class="span12"> <strong class="span5">Status: </strong> 
                                                    <?php echo $ops->TicketStatusAjax_view("ticket","ticket_id",$ticket_id,"status","status"); ?>  </label>
                                                </div>
                                                
                                                <div class="span12">
                                                    <label class="span12"> <strong class="span5">Number: </strong> <?php echo $ticket_id; ?> </label>
                                                </div>
                                                
                                                <div class="span12">
                                                    <label class="span12"> <strong class="span5">Problem type: </strong> 
                    <?php echo $ops->TicketProblemAjax_view("ticket","ticket_id",$ticket_id,"problem_type","problem_type"); ?>
                                                    </label>
                                                </div>
                                                
                                                <div class="span12">
                                                    <label class="span12"> <strong class="span5">Created: </strong> <?php echo date('d-m-Y H:i:s'); ?> </label>
                                                </div>
                                                
                                                <div class="span12">
                                                    <label class="span12"> <strong class="span5">Pre-Approved: </strong> Approved </label>
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
                                                <div class="span12" style="margin-top: 5px;">
                                                    <label class="btn btn-warning span10"> 
                                                    1. Diagnostic: <?php echo $ops->TicketWorkAjax_view("ticket","ticket_id",$ticket_id,"diagnostic","diagnostic"); ?></label>
                                                </div>

                                                <div class="clearfix"></div>
                                                <div class="span12">
                                                    <label class="btn btn-success span10"> 2. Work Approved: <?php echo $ops->TicketWorkAjax_view("ticket","ticket_id",$ticket_id,"work_approved","work_approved"); ?>  </label>
                                                </div>
                                                
                                                <div class="clearfix"></div>
                                                <div class="span12">
                                                    <label class="btn btn-primary span10"> 3. Invoiced: <?php echo $ops->TicketWorkAjax_view("ticket","ticket_id",$ticket_id,"invoice","invoice"); ?>  </label>
                                                </div>
                                                
                                                <div class="clearfix"></div>
                                                <div class="span12">
                                                    <label class="btn btn-danger span10"> 4. Work Completed: <?php echo $ops->TicketWorkAjax_view("ticket","ticket_id",$ticket_id,"work_completed","work_completed"); ?> </label>
                                                </div>
                                                <div class="clearfix"></div>
                                                
                                                <br>
                                                <br>
                                            </div>
                                            <!-- /general form elements -->
                                            
                                             <!-- General form elements -->
                                            <div class="well row-fluid span4">
                                                <div class="navbar">
                                                    <div class="navbar-inner">
                                                        <h5><i class="font-user"></i> Customer </h5>
                                                    </div>
                                                </div>
												<?php $cid=$obj->SelectAllByVal("ticket","ticket_id",$ticket_id,"cid"); ?>
                                                <div class="span12" style="margin-top:7px; clear:both;">
                                                    <label class="span12"> <strong class="span5">Customer: </strong> 
                	<?php echo $ops->SingleFieldEdit_view("coustomer","id",$cid,"firstname","firstname","Customer Name"); ?>
                                                    </label>
                                                </div>

                                                <div class="clearfix"></div>
                                                <div class="span12">
                                                    <label class="span12"> <strong class="span5">Company :  </strong> 
                    <?php echo $ops->SingleFieldEdit_view("coustomer","id",$cid,"businessname","businessname","Customer Name"); ?>
                                                    </label>
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="span12">
                                                    <label class="span12"> <strong class="span5">Email:  </strong> 
                   <?php echo $ops->SingleFieldEdit_view("coustomer","id",$cid,"email","email","Email"); ?>
                                                    </label>
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="span12">
                                                    <label class="span12"> <strong class="span5">Invoice Email:  </strong> 
                   <?php echo $ops->SingleFieldEdit_view("coustomer","id",$cid,"invoice_email","invoice_email","Invoice Email"); ?>
                                                    </label>
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="span12">
                                                    <label class="span12"> <strong class="span5">Phone: </strong> 
                   <?php echo $ops->SingleFieldEdit_view("coustomer","id",$cid,"phone","phone","Phone Number"); ?> 
                                                    </label>
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="span12">
                                                    <label class="span12"> <strong class="span5">Phone (SMS): </strong> 
                   <?php echo $ops->SingleFieldEdit_view("coustomer","id",$cid,"phonesms","phonesms","Phone SMS"); ?>
                                                    </label>
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
                                                        <h5><i class="icon-book"></i> Additional Information</h5>
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
                                                <div class="span12" style="margin-left:-10px;">
                                                <label class="checkbox span3 pull-left"><strong>Type & Color :</strong>
                <?php echo $ops->common_edit_view('ticket','ticket_id',$ticket_id,'type_color','type_color','id',"Type And Color"); ?>
                                                </label>
                                                <label class="checkbox span3"> <strong>Password:</strong> 
                <?php echo $ops->common_edit_view('ticket','ticket_id',$ticket_id,'password','password','id',"Password"); ?>
                                                </label>
                                                <label class="checkbox span3"> <strong>IMEI:</strong> 
                <?php echo $ops->common_edit_view('ticket','ticket_id',$ticket_id,'imei','imei','id',"IMEI Code"); ?> 
                                                </label>
                                                <label class="checkbox span3"> <strong>Tested Before By :</strong> 
               <?php echo $ops->common_edit_view('ticket','ticket_id',$ticket_id,'tested_before','tested_before','id',"Tested By"); ?> 
                                                </label>
                                                </div>
                                                <div class="span12" style="margin-left:-10px;">
                                                <label class="checkbox span6 pull-left">
                                                <strong>Tested After By : </strong>
                <?php echo $ops->common_edit_view('ticket','ticket_id',$ticket_id,'tested_after','tested_after','id',"Tested After By"); ?>
                                                </label>
                                                <label class="checkbox span6"> <strong>Tech Notes :</strong> 
                <?php echo $ops->common_edit_view('ticket','ticket_id',$ticket_id,'tech_notes','tech_notes','id',"Tech Notes"); ?>
                                                </label>
                                                <div class="clear" style="margin-bottom:30px;"></div>
                                                </div>
                                                <?php
												$sqlticussel=$obj->SelectAllByID_Multiple("ticket_custom_selection",array("ticket_id"=>$ticket_id));
												if(!empty($sqlticussel))
												foreach($sqlticussel as $sel):
												?>
                                                <span class="span4">
                                                <label class="checkbox"><div id="uniform-undefined" class="checker">
															<span class="checked"><input style="opacity: 0;" name="<?php echo $sel->id; ?>" id="<?php echo $sel->id; ?>" class="style" type="checkbox" value="<?php echo $sel->id; ?>" checked></span>
														</div> 
														<?php echo $obj->SelectAllByVal("ticket_custom_field","id",$sel->fid,"name"); ?>
                                                </label>
                                                </span>
                                                <?php
												endforeach;
												?>                                           
                                                
                                                
                                                
                                                
                                                
                                                <div class="clearfix"></div>
                                                
                                                
                                                
                                            </div>
                                            
                                            <div class="navbar">
                                                    <div class="navbar-inner" style="background: none; border-bottom: 1px #CCC dotted;">
                                                        <h5><i class="icon-screenshot"></i> Asset For This Ticket </h5>
                                                    </div>
                                            </div>
                                                <div class="table-overflow">
                                                    <table class="table table-striped" id="data-table">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Asset Name</th>
                                                                <th>Name/Business</th>
                                                                <th>Assset Serial</th>
                                                                <th>Asset Type</th>
                                                                <th>Properties</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php 
															
															$sqlasset=$obj->SelectAllByID_Multiple("ticket_asset",array("ticket_id"=>$ticket_id));
															$i=1;
															if(!empty($sqlasset))
															foreach($sqlasset as $asset): ?>
                                                            <tr>
                                                                <td><?php echo $i; ?></td>
                                                                
                                                                <td><?php echo $obj->SelectAllByVal("asset","id",$asset->asset_id,"name"); ?></td>
                                                                <td><?php echo $obj->SelectAllByVal("coustomer","id",$cid,"businessname"); ?></td>
                                                                <td><?php echo $obj->SelectAllByVal("asset","id",$asset->asset_id,"serial_number"); ?></td>
                                                                <td><?php $asset_type=$obj->SelectAllByVal("asset","id",$asset->asset_id,"asset_type_id"); echo $obj->SelectAllByVal("asset_type","id",$asset_type,"name"); ?></td>
                                                                <td>
    <label><strong>Make : </strong><?php echo $obj->SelectAllByVal("asset","id",$asset->asset_id,"make"); ?></label>,
    <label><strong>Model : </strong><?php echo $obj->SelectAllByVal("asset","id",$asset->asset_id,"model"); ?></label>,
    <label><strong>Service Tag : </strong><?php echo $obj->SelectAllByVal("asset","id",$asset->asset_id,"service_tag"); ?></label>
                                                                </td>
                                                            </tr>
                                                            <?php $i++; endforeach; ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            
                                            
                                            
                                        </div>

                                    </div>
                                        <!-- /general form elements -->
                                        
                                        
                                        
                             


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
            <?php include('include/footer.php'); ?>
            <!-- Right sidebar -->
            <?php //include('include/sidebar_right.php'); ?>
            <!-- /right sidebar -->

        </div>
        <!-- /main wrapper -->

    </body>
</html>
