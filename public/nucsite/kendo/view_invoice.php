<?php 
include('class/auth.php'); 
$table="product";
$table2="invoice_detail";
$table3="invoice";
$cart=$_GET['invoice'];
$cid=$obj->SelectAllByVal("invoice","invoice_id",$cart,"cid");
include('class/invoice_class.php');	
$ops = new invoice_view();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php echo $obj->bodyhead(); ?>
        <script src="ajax/customer_ajax.js"></script>
        <script src="ajax/invoice_ajax.js"></script>
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
                            <h5><i class="icon-file"></i> View Invoice - <?php echo $cart; ?>  </span></h5>
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
								
                                <form class="form-horizontal" method="get" name="invoice" action="create_invoice.php">
                                    <fieldset>
                                    <?php
									
									 ?>
                                    
                                        <div class="row-fluid block">
											
                                            <!-- General form elements -->
                                            <div class="well row-fluid span6">
                                                <div class="navbar">
                                                    <div class="navbar-inner">
                                                        <h5><i class="icon-user"></i> Customer</h5>
                                                    </div>
                                                </div>

                                                <br>
                                                <div class="span12">
                                                    <label class="span12"> <strong class="span4">Business Name: </strong> 
                                                    
                                                     <span class="span8">  
                                                    <?php echo $ops->customer_edit("coustomer",$cid,"businessname","Business Name"); ?> </span>
                                                    </label>
                                                </div>

                                                <div class="clearfix"></div>
                                                <div class="span12">
                                                    <label class="span12"> <strong class="span4">Name: </strong><span class="span8">
                                                     <?php echo $ops->customer_edit("coustomer",$cid,"firstname","Full Name"); ?> </span>
                                                     </label>
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="span12">
                                                    <label class="span12"> <strong class="span4">Email: </strong><span class="span8">
                                                     <?php echo $ops->customer_edit("coustomer",$cid,"email","Email Address"); ?></span> 
                                                     </label>
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="span12">
                                                    <label class="span12"> <strong class="span4">Invoice Email: </strong><span class="span8">
                                                     <?php echo $ops->customer_edit("coustomer",$cid,"invoice_email","Invoice Email Address"); ?> </span> 
                                                     </label>
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="span12">
                                                    <label class="span12"> <strong class="span4">Address: </strong><span class="span8">
                                                     <?php echo $ops->customer_edit("coustomer",$cid,"address1","Address"); ?>  </span>
                                                     </label>
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="span12">
                                                    <label class="span12"> <strong class="span4">Phone: </strong><span class="span8">
                                                     <?php echo $ops->customer_edit("coustomer",$cid,"phone","Phone Number"); ?> </span> 
                                                     </label>
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="span12">
                                                    <label class="span12"> <strong class="span4">Mobile Phone (SMS): </strong>
                                                     <span class="span8"><?php echo $ops->customer_edit("coustomer",$cid,"phonesms","Phone Number For SMS"); ?>  </span>
                                                     </label>
                                                </div>
                                                <br>
                                                <br>
                                            </div>
                                            <!-- /general form elements -->
											
                                            
                                            
                                            
                                            
                                            <?php $paid=$obj->SelectAllByVal("invoice","invoice_id",$cart,"paid");  ?>
                                            <!-- General form elements -->
                                            <div class="well row-fluid span6" <?php if($paid!=0){ ?>style="background:url(images/paid.png) no-repeat center;"<?php } ?>>
                                                <div class="navbar">
                                                    <div class="navbar-inner">
                                                        <h5><i class="font-money"></i> Invoice Detail</h5>
                                                    </div>
                                                </div>

                                                <br>
                                                <div class="span12">
                                                    <label class="span12"> <strong class="span3">Invoice Number: </strong> 
													<?php echo $cart; ?> </label>
                                                </div>

                                                <div class="clearfix"></div>
                                                <div class="span12">
                                                    <label class="span12"> <strong class="span3">Created By: </strong>
                                                     <b id="creator">
                                                     <?php $store_id=$obj->SelectAllByVal("invoice","invoice_id",$cart,"invoice_creator"); 
													 echo $obj->SelectAllByVal("store","id",$store_id,"name");
													 ?>
                                                     
                                                     </b>
                                                     
                                                     
                                                    
                                                     </label>
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="span12">
                                                    <label class="span12"> <strong class="span3">Invoice Date: </strong>
                                                     <?php echo $ops->invoice_edit("invoice","invoice_id",$cart,"invoice_date","INVOICE Date"); ?> 
                                                     </label>
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="span12">
                                                    <label class="span12"> <strong class="span3">Due Date: </strong>
                                                    <?php echo $ops->invoice_edit("invoice","invoice_id",$cart,"due_date","Due Date"); ?>  
                                                    </label>
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="span12">
                                                    <label class="span12"> <strong class="span3">PO Number: </strong>
                                                     <?php echo $ops->invoice_edit("invoice","invoice_id",$cart,"po_number","Po Number"); ?>  
                                                     </label>
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="span12">
                                                    <label class="span12"> <strong class="span3">Paid: </strong>
                                                     <?php echo $ops->invoice_edit_two("invoice","invoice_id",$cart,"paid","Paid"); ?></label>
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="span12">
                                                    <label class="span12"> <strong class="span3">Date paid: </strong>
                                                     <?php echo $ops->invoice_edit("invoice","invoice_id",$cart,"paid_date","Paid Date"); ?>  
                                                     </label>
                                                </div>
                                                
                                                <br>
                                                <br>
                                            </div>
                                            <!-- /general form elements -->

                                        </div>

                                        

                                        <!-- General form elements -->
                                        <div class="row-fluid  span12 well" style="margin-top: 5px;">     
                                    			<div class="navbar">
                                                    <div class="navbar-inner">
                                                        <h5><i class="font-money"></i> Line Item <span id="msg" style="float:right; margin-left:50px; margin-top:-8px;"></span></h5>
                                                    </div>
                                                </div>
                                    	<!-- Selects, dropdowns -->
                                    	<div class="span12" style="padding:0px; margin:0px;">
                                        	<div class="table-overflow">
                                                <table class="table table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Item</th>
                                                                    <th>Description</th>
                                                                    <th>QTY</th>
                                                                    <th>Rate</th>
                                                                    <th>Tax</th>
                                                                    <th>Extended</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="sales_list">
																<?php 
																$sqlsaleslist=$obj->SelectAllByID($table2,array("invoice_id"=>$cart));
																$sss=1;
																$subtotal=0;
																$tax=0;
																if(!empty($sqlsaleslist))
																foreach($sqlsaleslist as $saleslist):
																
																$caltax=($saleslist->single_cost*$tax_per_product)/100;
																$tax_status=$saleslist->tax;
																
																$procost=$saleslist->quantity*$saleslist->single_cost;
																$subtotal+=$procost;
																
																if($tax_status==0)
																{
																	$tax+=0;
																	$taxst="No";	
																	$taxstn="1";
																	$extended=$procost;
																}
																else
																{
																	$tax+=$caltax*$saleslist->quantity;
																	$taxst="Yes";
																	$taxstn="0";
																	$extended=$procost+$caltax;
																}
																
																?>
                                                                <tr>
                                                                    <td><?php echo $sss; ?></td>
                                                                    <td><?php echo $obj->SelectAllByVal($table,"id",$saleslist->pid,"name"); ?></td>
                                                                    <td><?php echo $obj->SelectAllByVal($table,"id",$saleslist->pid,"name"); ?></td>
                                                                    
                                                                    <td><?php echo $saleslist->quantity; ?></td>
                                                                    <td><button type="button" class="btn">$<?php echo $saleslist->single_cost; ?></button></td>
                                                                    <td>
                                                                   <?php echo $ops->invoice_edit_row($table2,"id",$saleslist->id,"tax","tax_invoice".$saleslist->id,$cid); ?>  
                                                                    </td>
                                                                    <td>
                                 										<button type="button" class="btn">$
																		<?php echo $extended; ?>
                                                                        </button>
                                                                    </td>
                                                                </tr>
																<?php 
																$sss++;
																endforeach;
																?>
                                                            </tbody>
                                                        </table>
                                            </div>
                                        </div>
                                        <!-- /selects, dropdowns -->
                                        
                                        <!-- Selects, dropdowns -->
                                    	<div class="span4" style="padding:0px; margin:0px; float:right;">
                                        	<div class="table-overflow">
                                                <table class="table table-striped">
                                                            <thead id="subtotal_list">
                                                                <tr>
                                                                    <th>Sub - Total: </th>
                                                                    <th><?php echo number_format($subtotal,2); ?></th>
                                                                </tr>
                                                                <tr>
                                                                    <th>Tax: </th>
                                                                    <th><?php echo number_format($tax,2); ?></th>
                                                                </tr>
                                                                <tr>
                                                                    <th>Total: </th>
                                                                    <th><?php $total=$subtotal+$tax; echo number_format($total,2); ?></th>
                                                                </tr>
                                                                <tr>
                                                                    <th>Payments: </th>
                                                                    <th><?php 
																	if($paid!=0)
																	{
																		echo number_format($total,2);	
																	}
																	else
																	{
																		echo "$0.00";	
																	}
																	 ?></th>
                                                                </tr>
                                                                <tr>
                                                                    <th>Balance Due: </th>
                                                                    <th><?php 
																	if($paid!=0)
																	{
																		echo "$0.00";	
																	}
																	else
																	{
																		
																		echo number_format($total,2);	
																	}
																	 ?></th>
                                                                </tr>
                                                            </thead>
                                                 </table>
                                            </div>
                                        </div>
                                        <!-- /selects, dropdowns -->
                                    </div>
                                        <!-- /general form elements -->
                                        
                                     
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
