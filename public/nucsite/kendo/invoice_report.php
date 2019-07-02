<?php 
include('class/auth.php');
include('class/report_customer.php');
$report=new report();  
$table="coustomer";
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php echo $obj->bodyhead(); ?>
        <script src="ajax/customer_ajax.js"></script>
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
                            <h5><i class="font-home"></i> Invoice Report </h5>
                        </div><!-- /page header -->
						
                        <div class="body">

                            <!-- Middle navigation standard -->
                            <?php //include('include/quicklink.php'); ?>
                            <!-- /middle navigation standard -->

                            <!-- Content container -->
                            <div class="container">

                                <!-- Content Start from here customized -->




                                        <!-- General form elements -->
                                        <div class="row-fluid block">
                                        
                                        <?php
						if(isset($_GET['from']))
						{
							if(!empty($_GET['to']))
							{
								$to=$_GET['to'];	
							}
							else
							{
								$to=date('Y-m-d');	
							}
								?>
								<h4>Invoice Report Generated For Date : <?php echo $_GET['from']; ?> To <?php echo $to; ?></h4>
                                <?php
						}
						else
						{
						?>
                        <!-- Dialog content -->
                            <div class="modal-body">
                                <form class="form-horizontal" action="<?php echo $obj->filename(); ?>" method="get">
                                    <div class="row-fluid">
                                        
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
                                        
                                        
                                    </div>
                                </form>
                            </div>
                        <!-- /dialog content -->
                        <?php } ?>
                                        
                                            <div class="table-overflow">
                                                <table class="table table-striped">
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
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
														if(isset($_GET['from']))
														{
															if(!empty($_GET['to']))
															{
																$to=$_GET['to'];	
															}
															else
															{
																$to=date('Y-m-d');	
															}
															$sqlinvoice=$report->ReportQuery_Datewise("invoice",array("doc_type"=>1),$_GET['from'],$to,1);
														}
														else
														{
                                                        	$sqlinvoice=$obj->SelectAllByID_Multiple("invoice",array("doc_type"=>1));
														}
                                                        $i=1;
                                                        if(!empty($sqlinvoice))
                                                        foreach($sqlinvoice as $invoice): ?>
                                                        <tr>
                                                            <td><?php echo $i; ?></td>
                                                            <td><a href="view_invoice.php?invoice=<?php echo $invoice->invoice_id; ?>" class="label label-important"><i class="font-money"></i> <?php echo $invoice->invoice_id; ?></a></td>
                                                            <td><?php echo $obj->SelectAllByVal("coustomer","id",$invoice->cid,"businessname")."-".$obj->SelectAllByVal("coustomer","id",$invoice->cid,"firstname")."".$obj->SelectAllByVal("coustomer","id",$invoice->cid,"lastname"); ?></td>
                                                            <td><label class="label label-success"> <?php echo $obj->invoice_paid_status($invoice->status); ?> </label></td>
                                                            <td><label class="label label-warning"> <?php echo $obj->invoice_took_payment($invoice->status); ?> </label></td>
                                                            
                                                            <td><label class="label label-primary"><i class="icon-calendar"></i> <?php echo $invoice->date; ?></label></td>
                                                            <td>
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
                                                            
                                                            echo $item_q;
                                                            ?>
                                                            </td>
                                                            <td>$<?php echo $total; ?></td>                                            
                                                        </tr>
                                                        <?php $i++; endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>



                                        </div>
                                        <!-- /general form elements -->



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
