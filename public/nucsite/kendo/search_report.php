<?php
include('class/auth.php');
include('class/report_customer.php');
$report = new report();
$table = "coustomer";

if (@$_GET['search'] == '') {
    $obj->Error("Empty Search Not Allowed", "search_report.php?search=empty");
}
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
                            if (isset($_GET['search'])) {
                                if ($input_status == 1) {
                                    $sqlinvoice = $report->SearchTrack("unlock_list", 0, $_GET['search'], "fullname", "unlock_id", "service", "imei", "email");
                                    $record = $report->SearchTrack("unlock_list", 1, $_GET['search'], "fullname", "unlock_id", "service", "imei", "email");

                                    $sqlinvoice1 = $report->SearchTrack("ticket_list", 0, $_GET['search'], "fullname", "ticket_id", "problem", "imei", "email");
                                    $record1 = $report->SearchTrack("ticket_list", 1, $_GET['search'], "fullname", "ticket_id", "problem", "imei", "email");

                                    $sqlinvoice2 = $report->SearchTrack("checkin_list", 0, $_GET['search'], "fullname", "checkin_id", "problem", "imei", "email");
                                    $record2 = $report->SearchTrack("checkin_list", 1, $_GET['search'], "fullname", "checkin_id", "problem", "imei", "email");
                                } else {
                                    $sqlinvoice = $report->SearchTrack_Store("unlock_list", 0, $_GET['search'], "fullname", "unlock_id", "service", "imei", "email", "input_by", $input_by);
                                    $record = $report->SearchTrack_Store("unlock_list", 1, $_GET['search'], "fullname", "unlock_id", "service", "imei", "email", "input_by", $input_by);

                                    $sqlinvoice1 = $report->SearchTrack_Store("ticket_list", 0, $_GET['search'], "fullname", "ticket_id", "problem", "imei", "email", "input_by", $input_by);
                                    $record1 = $report->SearchTrack_Store("ticket_list", 1, $_GET['search'], "fullname", "ticket_id", "problem", "imei", "email", "input_by", $input_by);

                                    $sqlinvoice2 = $report->SearchTrack_Store("checkin_list", 0, $_GET['search'], "fullname", "checkin_id", "problem", "imei", "email", "input_by", $input_by);
                                    $record2 = $report->SearchTrack_Store("checkin_list", 1, $_GET['search'], "fullname", "checkin_id", "problem", "imei", "email", "input_by", $input_by);
                                }

                                @$trec = $record + $record1 + $record2;
                                $record_label = " | Total Record : " . $trec;
                            } elseif (isset($_GET['from'])) {

                                $from = $_GET['from'];
                                $to = $_GET['to'];

                                if ($input_status == 1) {
                                    $sqlinvoice = $report->SearchTrackDateWise("unlock_list", 0, $_GET['searchs'], "fullname", "unlock_id", "service", "imei", "email", $from, $to);
                                    $record = $report->SearchTrackDateWise("unlock_list", 1, $_GET['searchs'], "fullname", "unlock_id", "service", "imei", "email", $from, $to);

                                    $sqlinvoice1 = $report->SearchTrackDateWise("ticket_list", 0, $_GET['searchs'], "fullname", "ticket_id", "problem", "imei", "email", $from, $to);
                                    $record1 = $report->SearchTrackDateWise("ticket_list", 1, $_GET['searchs'], "fullname", "ticket_id", "problem", "imei", "email", $from, $to);

                                    $sqlinvoice2 = $report->SearchTrackDateWise("checkin_list", 0, $_GET['searchs'], "fullname", "checkin_id", "problem", "imei", "email", $from, $to);
                                    $record2 = $report->SearchTrackDateWise("checkin_list", 1, $_GET['searchs'], "fullname", "checkin_id", "problem", "imei", "email", $from, $to);
                                } else {

                                    $sqlinvoice = $report->SearchTrackDateWise_store("unlock_list", 0, $_GET['searchs'], "fullname", "unlock_id", "service", "imei", "email", $from, $to, "input_by", $input_by);
                                    $record = $report->SearchTrackDateWise_store("unlock_list", 1, $_GET['searchs'], "fullname", "unlock_id", "service", "imei", "email", $from, $to, "input_by", $input_by);

                                    $sqlinvoice1 = $report->SearchTrackDateWise_store("ticket_list", 0, $_GET['searchs'], "fullname", "ticket_id", "problem", "imei", "email", $from, $to, "input_by", $input_by);
                                    $record1 = $report->SearchTrackDateWise_store("ticket_list", 1, $_GET['searchs'], "fullname", "ticket_id", "problem", "imei", "email", $from, $to, "input_by", $input_by);

                                    $sqlinvoice2 = $report->SearchTrackDateWise_store("checkin_list", 0, $_GET['searchs'], "fullname", "checkin_id", "problem", "imei", "email", $from, $to, "input_by", $input_by);
                                    $record2 = $report->SearchTrackDateWise_store("checkin_list", 1, $_GET['searchs'], "fullname", "checkin_id", "problem", "imei", "email", $from, $to, "input_by", $input_by);
                                }
                                $trec = $record + $record1 + $record2;
                                $record_label = " | Generate Between " . $from . " - " . $to . " | Total Record Found : " . $trec;
                            } else {
                                if ($input_status == 1) {
                                    $sqlinvoice = $report->SelectAllLimit("unlock_list", 3);
                                    $record = $obj->totalrows("unlock_list");

                                    $sqlinvoice1 = $report->SelectAllLimit("ticket_list", 3);
                                    $record1 = $obj->totalrows("ticket_list");

                                    $sqlinvoice2 = $report->SelectAllLimit("checkin_list", 3);
                                    $record2 = $obj->totalrows("checkin_list");
                                } elseif ($input_status == 2) {
                                    $sqlinvoice = $report->SelectAllLimit_store("unlock_list", 3, "input_by", $input_by);
                                    $sqlinvoice1 = $report->SelectAllLimit_store("ticket_list", 3, "input_by", $input_by);
                                    $sqlinvoice2 = $report->SelectAllLimit_store("checkin_list", 3, "input_by", $input_by);
                                } elseif ($input_status == 3) {
                                    $sqlinvoice = $report->SelectAllLimit_store("unlock_list", 3, "input_by", $input_by);
                                    $sqlinvoice1 = $report->SelectAllLimit_store("ticket_list", 3, "input_by", $input_by);
                                    $sqlinvoice2 = $report->SelectAllLimit_store("checkin_list", 3, "input_by", $input_by);
                                }

                                $record_label = "";
                            }
                            ?>
                            <h5><i class="font-tags"></i> Search Report <?php echo $record_label; ?> | <a  data-toggle="modal" href="#myModal"> Search Datewise </a></h5>
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
                                        if (!empty($sqlinvoice)) {
                                            ?>
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Unlock-ID</th>
                                                        <th>Customer</th>
                                                        <th>Service </th>
                                                        <th>Imei</th>

                                                        <th>Retail Cost</th>
                                                        <th>Warranty</th>
                                                        <th>Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if ($input_status == 1) {
                                                        foreach ($sqlinvoice as $invoice):
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $i; ?></td>
                                                                <td><a href="view_unlock.php?unlock_id=<?php echo $invoice->unlock_id; ?>" class="label label-important"><i class="font-money"></i> <?php echo $invoice->unlock_id; ?></a></td>
                                                                <td><?php echo $invoice->fullname; ?></td>
                                                                <td><?php echo $invoice->service; ?></td>
                                                                <td><label class="label label-warning"> <?php echo $invoice->imei; ?> </label></td>


                                                                <td>$<?php echo $invoice->retail_cost; ?></td>
                                                                <td><?php
                                                                    if ($obj->exists_multiple("warrenty", array("warrenty_id" => $invoice->unlock_id, "type" => "unlock")) != 0) {
                                                                        echo $obj->SelectAllByVal2("warrenty", "warrenty_id", $invoice->unlock_id, "type", "unlock", "warrenty") . " Days";
                                                                    } else {
                                                                        echo "0 Days";
                                                                    }
                                                                    ?></td>
                                                                <td><?php echo $invoice->date; ?></td>

                                                            </tr>
                                                            <?php
                                                            $i++;
                                                        endforeach;
                                                    } else {
                                                        foreach ($sqlinvoice as $invoice):
                                                            if ($invoice->input_by == $input_by) {
                                                                ?>
                                                                <tr>
                                                                    <td><?php echo $i; ?></td>
                                                                    <td><a href="view_unlock.php?unlock_id=<?php echo $invoice->unlock_id; ?>" class="label label-important"><i class="font-money"></i> <?php echo $invoice->unlock_id; ?></a></td>
                                                                    <td><?php echo $invoice->fullname; ?></td>
                                                                    <td><?php echo $invoice->service; ?></td>
                                                                    <td><label class="label label-warning"> <?php echo $invoice->imei; ?> </label></td>


                                                                    <td>$<?php echo $invoice->retail_cost; ?></td>
                                                                    <td><?php
                                                                        if ($obj->exists_multiple("warrenty", array("warrenty_id" => $invoice->unlock_id, "type" => "unlock")) != 0) {
                                                                            echo $obj->SelectAllByVal2("warrenty", "warrenty_id", $invoice->unlock_id, "type", "unlock", "warrenty") . " Days";
                                                                        } else {
                                                                            echo "0 Days";
                                                                        }
                                                                        ?></td>
                                                                    <td><?php echo $invoice->date; ?></td>

                                                                </tr>
                                                                <?php
                                                                $i++;
                                                            }
                                                        endforeach;
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                            <?php
                                        }
                                        $ii = $i;
                                        if (!empty($sqlinvoice1)) {
                                            ?>
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Ticket-ID</th>
                                                        <th>Problem </th>
                                                        <th>Imei</th>
                                                        <th>Warrenty</th>
                                                        <th>W.Left</th>
                                                        <th>Retail Cost</th>

                                                        <th>Date</th>
                                                        <th width="180"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if ($input_status == 1) {
                                                        foreach ($sqlinvoice1 as $invoice1):
                                                            if ($invoice1->input_by == $input_by) {
                                                                ?>
                                                                <tr>
                                                                    <td><?php echo $ii; ?></td>
                                                                    <td><a href="view_ticket.php?ticket_id=<?php echo $invoice1->ticket_id; ?>" class="label label-important"><i class="font-money"></i> <?php echo $invoice1->ticket_id; ?></a></td>

                                                                    <td><label class="label label-success"> <?php echo $invoice1->problem; ?> </label></td>
                                                                    <td><label class="label label-warning"> <?php echo $invoice1->imei; ?> </label></td>

                                                                    <td><?php
                                                                        if ($obj->exists_multiple("warrenty", array("warrenty_id" => $invoice1->ticket_id, "type" => "ticket")) != 0) {
                                                                            $wd2 = $obj->SelectAllByVal2("warrenty", "warrenty_id", $invoice1->ticket_id, "type", "ticket", "warrenty");
                                                                        } else {
                                                                            $wd2 = $invoice1->warrenty;
                                                                        }
                                                                        echo $wd2 . " Days";
                                                                        ?></td>
                                                                    <td><?php
                                                                        $daysgone2 = $obj->daysgone($invoice1->date, date('Y-m-d'));
                                                                        //echo $wd." Days";
                                                                        $have2 = $wd2 - $daysgone2;
                                                                        echo $have2 . " Days Remaining";
                                                                        ?></td>
                                                                    <td>$<?php echo $invoice1->retail_cost; ?></td>

                                                                    <td><?php echo $invoice1->date; ?></td>                                            							<td>
                                                                        <?php if ($obj->exists_multiple("warrenty", array("warrenty_id" => $invoice1->ticket_id, "type" => "ticket")) != 0) { ?>
                                                                            <a href="create_warrenty.php?warrenty_id=<?php echo $invoice1->ticket_id; ?>&type=ticket&wd=<?php echo $have2; ?>" class="btn btn-info"><i class="icon-edit"></i> Edit Warrenty</a>
                                                                            <a href="warrenty_print.php?warrenty_id=<?php echo $invoice1->ticket_id; ?>&print_invoice=yes"  target="_blank"  onclick="javascript:return confirm('Are you absolutely sure to Print This Invoice ?')" class="btn btn-success"> <i class="icon-print"></i></a>
                                                                        <?php } else { ?>    

                                                                            <a href="create_warrenty.php?warrenty_id=<?php echo $invoice1->ticket_id; ?>&type=ticket&wd=<?php echo $have2; ?>" class="btn btn-info"> <i class="icon-plus"></i> Add Warrenty</a>
                                                                        <?php } ?>  
                                                                    </td>
                                                                </tr>
                                                                <?php
                                                                $ii++;
                                                            }
                                                        endforeach;
                                                    } else {
                                                        foreach ($sqlinvoice1 as $invoice1):
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $ii; ?></td>
                                                                <td><a href="view_ticket.php?ticket_id=<?php echo $invoice1->ticket_id; ?>" class="label label-important"><i class="font-money"></i> <?php echo $invoice1->ticket_id; ?></a></td>

                                                                <td><label class="label label-success"> <?php echo $invoice1->problem; ?> </label></td>
                                                                <td><label class="label label-warning"> <?php echo $invoice1->imei; ?> </label></td>

                                                                <td><?php
                                                                    if ($obj->exists_multiple("warrenty", array("warrenty_id" => $invoice1->ticket_id, "type" => "ticket")) != 0) {
                                                                        $wd22 = $obj->SelectAllByVal2("warrenty", "warrenty_id", $invoice1->ticket_id, "type", "ticket", "warrenty");
                                                                    } else {
                                                                        $wd22 = $invoice1->warrenty;
                                                                    }

                                                                    if ($wd22 == 0 || $wd22 == "") {
                                                                        $wd2 = 90;
                                                                    } else {
                                                                        $wd2 = $wd22;
                                                                    }

                                                                    echo $wd2 . " Days";
                                                                    ?></td>
                                                                <td><?php
                                                                    $daysgone2 = $obj->daysgone($invoice1->date, date('Y-m-d'));
                                                                    //echo $wd." Days";
                                                                    $have2 = $wd2 - $daysgone2;
                                                                    echo $have2 . " Days Remaining";
                                                                    ?></td>
                                                                <td>$<?php echo $invoice1->retail_cost; ?></td>

                                                                <td><?php echo $invoice1->date; ?></td>                                            							<td>
                                                                    <?php if ($obj->exists_multiple("warrenty", array("warrenty_id" => $invoice1->ticket_id, "type" => "ticket")) != 0) { ?>
                                                                        <a href="create_warrenty.php?warrenty_id=<?php echo $invoice1->ticket_id; ?>&type=ticket&wd=<?php echo $have2; ?>" class="btn btn-info"><i class="icon-edit"></i> Edit Warrenty</a>
                                                                        <a href="warrenty_print.php?warrenty_id=<?php echo $invoice1->ticket_id; ?>&print_invoice=yes"  target="_blank"  onclick="javascript:return confirm('Are you absolutely sure to Print This Invoice ?')" class="btn btn-success"> <i class="icon-print"></i></a>
                                                                    <?php } else { ?>    

                                                                        <a href="create_warrenty.php?warrenty_id=<?php echo $invoice1->ticket_id; ?>&type=ticket&wd=<?php echo $have2; ?>" class="btn btn-info"> <i class="icon-plus"></i> Add Warrenty</a>
                                                                    <?php } ?>  
                                                                </td>
                                                            </tr>
                                                            <?php
                                                            $ii++;
                                                        endforeach;
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                            <?php
                                        }
                                        $iii = $ii;
                                        if (!empty($sqlinvoice2)) {
                                            ?>
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>CheckIn-ID</th>
                                                        <th>Problem </th>
                                                        <th>Imei</th>
                                                        <th>W.Provide</th>
                                                        <th>W.Left</th>
                                                        <th>Retail Cost</th>

                                                        <th>Date</th>
                                                        <th width="150"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $iii = $ii;
                                                    if (!empty($sqlinvoice2))
                                                        if ($input_status == 1) {
                                                            foreach ($sqlinvoice2 as $invoice2):
                                                                ?>
                                                                <tr>
                                                                    <td><?php echo $iii; ?></td>
                                                                    <td><a href="view_checkin.php?ticket_id=<?php echo $invoice2->checkin_id; ?>" class="label label-important"><i class="font-money"></i> <?php echo $invoice2->checkin_id; ?></a></td>
                                                                    <td><label class="label label-success"> <?php echo $invoice2->problem; ?> </label></td>
                                                                    <td><label class="label label-warning"> <?php echo $invoice2->imei; ?> </label></td>

                                                                    <td><?php
                                                                        if ($obj->exists_multiple("warrenty", array("warrenty_id" => $invoice2->checkin_id, "type" => "checkin")) != 0) {
                                                                            $wd33 = $obj->SelectAllByVal2("warrenty", "warrenty_id", $invoice2->checkin_id, "type", "checkin", "warrenty");
                                                                        } else {
                                                                            $wd33 = $invoice2->warrenty;
                                                                        }

                                                                        if ($wd33 == 0 || $wd33 == "") {
                                                                            $wd3 = 90;
                                                                        } else {
                                                                            $wd3 = $wd33;
                                                                        }
                                                                        echo $wd3 . " Days";
                                                                        ?></td>
                                                                    <td><?php
                                                                        $ttd = date('Y-m-d');
                                                                        $daysgone3 = $obj->daysgone($invoice2->date, $ttd);
                                                                        //echo $wd." Days";
                                                                        $have3 = $wd3 - $daysgone3;
                                                                        echo $have3 . " Days Remaining";
                                                                        ?></td>
                                                                    <td>$<?php
                                                                        $rc33 = $invoice2->retail_cost;
                                                                        if ($rc33 == '') {
                                                                            $devid = $obj->SelectAllByVal("checkin_request", "checkin_id", $invoice2->checkin_id, "device_id");
                                                                            $modid = $obj->SelectAllByVal("checkin_request", "checkin_id", $invoice2->checkin_id, "model_id");
                                                                            $probid = $obj->SelectAllByVal("checkin_request", "checkin_id", $invoice2->checkin_id, "problem_id");
                                                                            $rc3 = $obj->SelectAllByVal3("checkin_price", "checkin_id", $devid, "checkin_version_id", $modid, "checkin_problem_id", $probid, "name");
                                                                        } else {
                                                                            $rc3 = $rc33;
                                                                        }
                                                                        echo $rc3;
                                                                        ?></td>

                                                                    <td><?php echo $invoice2->date; ?></td>                                            <td><?php if ($obj->exists_multiple("warrenty", array("warrenty_id" => $invoice2->checkin_id, "type" => "checkin")) != 0) { ?>
                                                                            <a href="create_warrenty.php?warrenty_id=<?php echo $invoice2->checkin_id; ?>&type=checkin&wd=<?php echo $have3; ?>" class="btn btn-info"><i class="icon-edit"></i> Edit Warrenty</a>
                                                                            <a href="warrenty_print.php?warrenty_id=<?php echo $invoice2->checkin_id; ?>&print_invoice=yes"  target="_blank" onclick="javascript:return confirm('Are you absolutely sure to Print This Invoice ?')" class="btn btn-success"> <i class="icon-print"></i></a>
                                                                        <?php } else { ?>    

                                                                            <a href="create_warrenty.php?warrenty_id=<?php echo $invoice2->checkin_id; ?>&type=checkin&wd=<?php echo $have3; ?>" class="btn btn-info"> <i class="icon-plus"></i> Add Warrenty</a>
                                                                        <?php } ?>
                                                                    </td>
                                                                </tr>
                                                                <?php
                                                                $iii++;
                                                            endforeach;
                                                        } else {
                                                            foreach ($sqlinvoice2 as $invoice2):
                                                                if ($invoice2->input_by == $input_by) {
                                                                    ?>
                                                                    <tr>
                                                                        <td><?php echo $iii; ?></td>
                                                                        <td><a href="view_checkin.php?ticket_id=<?php echo $invoice2->checkin_id; ?>" class="label label-important"><i class="font-money"></i> <?php echo $invoice2->checkin_id; ?></a></td>
                                                                        <td><label class="label label-success"> <?php echo $invoice2->problem; ?> </label></td>
                                                                        <td><label class="label label-warning"> <?php echo $invoice2->imei; ?> </label></td>

                                                                        <td><?php
                                                                            if ($obj->exists_multiple("warrenty", array("warrenty_id" => $invoice2->checkin_id, "type" => "checkin")) != 0) {
                                                                                $wd33 = $obj->SelectAllByVal2("warrenty", "warrenty_id", $invoice2->checkin_id, "type", "checkin", "warrenty");
                                                                            } else {
                                                                                $wd33 = $invoice2->warrenty;
                                                                            }

                                                                            if ($wd33 == 0 || $wd33 == "") {
                                                                                $wd3 = 90;
                                                                            } else {
                                                                                $wd3 = $wd33;
                                                                            }

                                                                            echo $wd3 . " Days";
                                                                            ?></td>
                                                                        <td><?php
                                                                            $daysgone3 = $obj->daysgone($invoice2->date, date('Y-m-d'));
                                                                            //echo $wd." Days";
                                                                            $have3 = $wd3 - $daysgone3;
                                                                            echo $have3 . " Days Remaining";
                                                                            ?></td>
                                                                        <td>$<?php
                                                                            $rc33 = $invoice2->retail_cost;
                                                                            if ($rc33 == '') {
                                                                                $devid = $obj->SelectAllByVal("checkin_request", "checkin_id", $invoice2->checkin_id, "device_id");
                                                                                $modid = $obj->SelectAllByVal("checkin_request", "checkin_id", $invoice2->checkin_id, "model_id");
                                                                                $probid = $obj->SelectAllByVal("checkin_request", "checkin_id", $invoice2->checkin_id, "problem_id");
                                                                                $rc3 = $obj->SelectAllByVal3("checkin_price", "checkin_id", $devid, "checkin_version_id", $modid, "checkin_problem_id", $probid, "name");
                                                                            } else {
                                                                                $rc3 = $rc33;
                                                                            }
                                                                            echo $rc3;
                                                                            ?></td>

                                                                        <td><?php echo $invoice2->date; ?></td>                                            <td><?php if ($obj->exists_multiple("warrenty", array("warrenty_id" => $invoice2->checkin_id, "type" => "checkin")) != 0) { ?>
                                                                                <a href="create_warrenty.php?warrenty_id=<?php echo $invoice2->checkin_id; ?>&type=checkin&wd=<?php echo $have3; ?>" class="btn btn-info"><i class="icon-edit"></i> Edit Warrenty</a>
                                                                                <a href="warrenty_print.php?warrenty_id=<?php echo $invoice2->checkin_id; ?>&print_invoice=yes"  target="_blank" onclick="javascript:return confirm('Are you absolutely sure to Print This Invoice ?')" class="btn btn-success"> <i class="icon-print"></i></a>
                                                                            <?php } else { ?>    

                                                                                <a href="create_warrenty.php?warrenty_id=<?php echo $invoice2->checkin_id; ?>&type=checkin&wd=<?php echo $have3; ?>" class="btn btn-info"> <i class="icon-plus"></i> Add Warrenty</a>
                                                                            <?php } ?>
                                                                        </td>
                                                                    </tr>
                                                                    <?php
                                                                    $iii++;
                                                                }
                                                            endforeach;
                                                        }
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
            <?php //include('include/sidebar_right.php');  ?>
            <!-- /right sidebar -->

        </div>
        <!-- /main wrapper -->

    </body>
</html>
