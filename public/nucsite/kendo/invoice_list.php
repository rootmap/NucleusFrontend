<?php include('class/auth.php'); 
if(isset($_GET['del']))
{
	$obj->deletesing("id",$_GET['del'],"invoice");	
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
                            <h5><i class="font-home"></i>Invoice Info</h5>
                            <ul class="icons">
                                <li><a href="<?php echo $obj->filename(); ?>" class="hovertip" title="Reload"><i class="font-refresh"></i></a></li>
                            </ul>
                        </div><!-- /page header -->

                        <div class="body">

                            <!-- Middle navigation standard -->
                            <?php include('include/quicklink.php'); ?>
                            <!-- /middle navigation standard -->

                            <!-- Content container -->
                            <div class="container">

                                <div class="separator-doubled"></div> 
                                
                                
                                
                                <!-- Content Start from here customized -->
                                
                                
                                <!-- Default datatable -->
                        <div class="block well">
                        	<div class="navbar">
                            	<div class="navbar-inner">
                                    <h5><i class="font-money"></i> Invoice List</h5>
                                        <ul class="icons">
                                            <li><a data-original-title="Tooltip on left" data-placement="left" href="invoice.php" class="hovertip" title="Add New Invoice"><i class="icon-plus"></i></a></li>
                                            <li><a data-original-title="Tooltip on left" data-placement="left" href="<?php echo $obj->filename(); ?>" class="hovertip" title="FAQ?"><i class="icon-fire"></i></a></li>
                                            <li><a data-original-title="Tooltip on right" data-placement="right" href="<?php echo $obj->filename(); ?>" class="hovertip" title="Reload Data"><i class="icon-refresh"></i></a></li>
                                        </ul>
                                </div>
                            </div>
                            <div class="table-overflow">
                                <table class="table table-striped" id="data-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Invoice-ID</th>
                                            <th>Customer</th>
                                            <th>Status</th>
                                            
                                            <th>Took Payment</th>
                                            <th>Date</th>
                                            <th>Item</th>
                                            <th>Total</th>
                                            
                                            <th width="40">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
										$sqlinvoice=$obj->SelectAllByID_Multiple("invoice",array("doc_type"=>1));
										$i=1;
										if(!empty($sqlinvoice))
										foreach($sqlinvoice as $invoice): ?>
                                        <?php 
											$sqlitem=$obj->SelectAllByID_Multiple("invoice_detail",array("invoice_id"=>$invoice->invoice_id));
											$item_q=0;
											$total=0;
											if(!empty($sqlitem))
											foreach($sqlitem as $item):
												$rr=$item->quantity*$item->single_cost;
												if($item->tax!=0)
												{
													$tax=0;
												}
												else
												{
													$tax=($rr*$tax_per_product)/100;
												}
												
												$tot=$rr+$tax;
												$total+=$tot;
												$item_q+=$item->quantity;
											endforeach;
											if($total!=0)
											{
											?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><a href="view_invoice.php?invoice=<?php echo $invoice->invoice_id; ?>" class="label label-important"><i class="font-money"></i> <?php echo $invoice->invoice_id; ?></a></td>
                                            <td><?php echo $obj->SelectAllByVal("coustomer","id",$invoice->cid,"businessname")."-".$obj->SelectAllByVal("coustomer","id",$invoice->cid,"firstname")."".$obj->SelectAllByVal("coustomer","id",$invoice->cid,"lastname"); ?></td>
                                            <td><label class="label label-success"> <?php echo $obj->invoice_paid_status($invoice->status); ?> </label></td>
                                            <td><label class="label label-warning"> <?php echo $obj->invoice_took_payment($invoice->status); ?> </label></td>
                                            
                                            <td><label class="label label-primary"><i class="icon-calendar"></i> <?php echo $invoice->date; ?></label></td>
                                            <td>
                                            <?php echo $item_q; ?>
                                            </td>
                                            <td>$<?php echo $total; ?></td>                                            
                                            <td>
                                            <?php if($input_status==2 || $input_by==$invoice->invoice_creator){ ?>
                                                <a href="<?php echo $obj->filename(); ?>?del=<?php echo $invoice->id; ?>" class="btn btn-danger hovertip" title="Delete" onclick="javascript:return confirm('Are you absolutely sure to delete This?')"><i class="icon-remove"></i></a>
                                            <?php } ?>    
                                            </td>
                                        </tr>
                                        <?php $i++; 
											}
										endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /default datatable -->
                                
                                
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
