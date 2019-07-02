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
                        				<?php 
										echo $obj->ShowMsg();
										if(isset($_GET['search']))
										{
$sqlinvoice = $report->SearchTrack("unlock_list",0,$_GET['search'],"fullname","unlock_id","service","imei","email");
$record =$report->SearchTrack("unlock_list",1,$_GET['search'],"fullname","unlock_id","service","imei","email");

$sqlinvoice1 = $report->SearchTrack("ticket_list",0,$_GET['search'],"fullname","ticket_id","problem","imei","email");
$record1 =$report->SearchTrack("ticket_list",1,$_GET['search'],"fullname","ticket_id","problem","imei","email");

$sqlinvoice2 = $report->SearchTrack("checkin_list",0,$_GET['search'],"fullname","checkin_id","problem","imei","email");
$record2 =$report->SearchTrack("checkin_list",1,$_GET['search'],"fullname","checkin_id","problem","imei","email");


$trec=$record+$record1+$record2;
$record_label=" | Total Record : ".$trec;

										}
										elseif(isset($_GET['from']))
										{
											
											$from=$_GET['from'];
											$to=$_GET['to'];
											/*$sqlinvoice = $report->SelectAllDateCond("invoice","doc_type","3",$from,$to,"1");
											$record = $report->SelectAllDateCond("invoice","doc_type","3",$from,$to,"2");
											$record_label="Report Generate Between ".$from." - ".$to;*/
											
$sqlinvoice = $report->SearchTrackDateWise("unlock_list",0,$_GET['searchs'],"fullname","unlock_id","service","imei","email",$from,$to);
$record =$report->SearchTrackDateWise("unlock_list",1,$_GET['searchs'],"fullname","unlock_id","service","imei","email",$from,$to);

$sqlinvoice1 = $report->SearchTrackDateWise("ticket_list",0,$_GET['searchs'],"fullname","ticket_id","problem","imei","email",$from,$to);
$record1 =$report->SearchTrackDateWise("ticket_list",1,$_GET['searchs'],"fullname","ticket_id","problem","imei","email",$from,$to);

$sqlinvoice2 = $report->SearchTrackDateWise("checkin_list",0,$_GET['searchs'],"fullname","checkin_id","problem","imei","email",$from,$to);
$record2 =$report->SearchTrackDateWise("checkin_list",1,$_GET['searchs'],"fullname","checkin_id","problem","imei","email",$from,$to);


$trec=$record+$record1+$record2;
$record_label=" | Generate Between ".$from." - ".$to." | Total Record Found : ".$trec;


										}
										else
										{
											$sqlinvoice = $obj->SelectAll("unlock_list");
											$record = $obj->totalrows("unlock_list");
											
											$sqlinvoice1 = $obj->SelectAll("ticket_list");
											$record1 = $obj->totalrows("ticket_list");
											
											$sqlinvoice2 = $obj->SelectAll("checkin_list");
											$record2 = $obj->totalrows("checkin_list");
											
											$record_label=""; 
										}
										?>
                            <h5><i class="font-home"></i> Search Report <?php echo $record_label; ?> | <a  data-toggle="modal" href="#myModal"> Search Datewise </a></h5>
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
                                        
<!-- Dialog content -->
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <form action="" method="get">
            <div class="modal-header" style="height:25px;">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h5 id="myModalLabel"><i class="icon-calendar"></i> Search Anything With Datewise</h5>
            </div>
            <div class="modal-body">
                <div class="row-fluid">
                	<div class="control-group">
                        <label class="control-label">Search Key : </label>
                        <div class="controls">
                        	<input type="text" class="span6" id="searchs" name="searchs" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Date range:</label>
                        <div class="controls">
                            <ul class="dates-range">
                                <li><input type="text" id="fromDate" readonly value="<?php echo date('Y-m-d'); ?>" name="from" placeholder="From" /></li>
                                <li class="sep">-</li>
                                <li><input type="text" id="toDate" readonly value="<?php echo date('Y-m-d'); ?>"  name="to" placeholder="To" /></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary"  type="submit" name="search_date"><i class="icon-screenshot"></i> Search</button>
            </div>
            </form>
            <form action="" method="get">
            <div class="modal-header" style="height:25px;">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h5 id="myModalLabel"><i class="icon-calendar"></i> Search Anything</h5>
            </div>
            <div class="modal-body">
                <div class="row-fluid">
                    <div class="control-group">
                        <label class="control-label">Search Key: </label>
                        <div class="controls">
                        	<input type="text" class="span6" id="search" name="search" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary"  type="submit" name="searchd"><i class="icon-screenshot"></i> Search</button>
            </div>
        </form>
</div>
<!-- /dialog content -->
                                        
                                            <div class="table-overflow">
                                                <?php 
												$i = 1;
                                                if (!empty($sqlinvoice)){
												?>
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Unlock-ID</th>
                                                            <th>Customer</th>
                                                            <th>Service </th>
        													<th>Imei</th>
                                                            <th>Carrier</th>
                                                            <th>Retail Cost</th>
                                                            <th>Date</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        
                                                            foreach ($sqlinvoice as $invoice):
                                                                
                                                                    ?>
                                                                    <tr>
                                                                        <td><?php echo $i; ?></td>
                                                                        <td><a href="view_unlock.php?unlock_id=<?php echo $invoice->unlock_id; ?>" class="label label-important"><i class="font-money"></i> <?php echo $invoice->unlock_id; ?></a></td>
                                                                        <td><?php echo $invoice->fullname; ?></td>
                                                                        <td><label class="label label-success"> <?php echo $invoice->service; ?> </label></td>
                                                                        <td><label class="label label-warning"> <?php echo $invoice->imei; ?> </label></td>
        
                                                                        <td><label class="label label-primary"><i class="icon-calendar"></i> <?php echo $invoice->carrier; ?></label></td>
                                                                        <td>$<?php echo $invoice->retail_cost; ?></td>
                                                                        <td><?php echo $invoice->date; ?></td>                                            
                                                                    </tr>
                                                                    <?php 
																	$i++;
                                                                 endforeach;
                                                        ?>
                                                    </tbody>
                                                    </table>
                                                    <?php 
													}
													$ii =$i;
                                                        if (!empty($sqlinvoice1)){
													?>
                                                    <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Ticket-ID</th>
                                                            <th>Customer</th>
                                                            <th>Problem </th>
        													<th>Imei</th>
                                                            <th>Warrenty</th>
                                                            <th>Retail Cost</th>
                                                            
                                                            <th>Date</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        
                                                            foreach ($sqlinvoice1 as $invoice1):
                                                                
                                                                    ?>
                                                                    <tr>
                                                                        <td><?php echo $ii; ?></td>
                                                                        <td><a href="view_ticket.php?ticket_id=<?php echo $invoice1->ticket_id; ?>" class="label label-important"><i class="font-money"></i> <?php echo $invoice1->ticket_id; ?></a></td>
                                                                        <td><?php echo $invoice1->fullname; ?></td>
                                                                        <td><label class="label label-success"> <?php echo $invoice1->problem; ?> </label></td>
                                                                        <td><label class="label label-warning"> <?php echo $invoice1->imei; ?> </label></td>
        
                                                                        <td><?php echo $invoice1->warrenty; ?></td>
                                                                        <td>$<?php echo $invoice1->retail_cost; ?></td>
                                                                        
                                                                        <td><?php echo $invoice1->date; ?></td>                                            
                                                                    </tr>
                                                                    <?php 
																	$ii++;
                                                                 endforeach;
                                                        ?>
                                                    </tbody>
                                                </table>
                                                <?php 
													}
													$iii =$ii;
                                                    if (!empty($sqlinvoice2)){
													?>
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>CheckIn-ID</th>
                                                            <th>Customer</th>
                                                            <th>Problem </th>
        													<th>Imei</th>
                                                            <th>Warrenty</th>
                                                            <th>Retail Cost</th>
                                                            
                                                            <th>Date</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $iii =$ii;
                                                        if (!empty($sqlinvoice2))
                                                            foreach ($sqlinvoice2 as $invoice2):
                                                                
                                                                    ?>
                                                                    <tr>
                                                                        <td><?php echo $iii; ?></td>
                                                                        <td><a href="view_checkin.php?ticket_id=<?php echo $invoice2->checkin_id; ?>" class="label label-important"><i class="font-money"></i> <?php echo $invoice2->checkin_id; ?></a></td>
                                                                        <td><?php echo $invoice2->fullname; ?></td>
                                                                        <td><label class="label label-success"> <?php echo $invoice2->problem; ?> </label></td>
                                                                        <td><label class="label label-warning"> <?php echo $invoice2->imei; ?> </label></td>
        
                                                                        <td><?php echo $invoice2->warrenty; ?></td>
                                                                        <td>$<?php echo $invoice2->retail_cost; ?></td>
                                                                        
                                                                        <td><?php echo $invoice2->date; ?></td>                                            
                                                                    </tr>
                                                                    <?php 
																	$iii++;
                                                                 endforeach;
                                                        ?>
                                                    </tbody>
                                                </table>
                                                <?php } ?>
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
