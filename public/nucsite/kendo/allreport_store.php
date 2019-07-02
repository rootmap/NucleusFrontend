<?php
include('class/auth.php');
include('class/report_customer.php');
$report = new report();
$table = "coustomer";

if ($input_status == 5) {
    include('class/report_chain_admin.php');
    $obj_report_chain = new chain_report();
    $array_ch = array();
    $sqlchain_store_ids = $obj->SelectAllByID("store_chain_admin", array("sid" => $input_by));
    if (!empty($sqlchain_store_ids))
        foreach ($sqlchain_store_ids as $ch):
            array_push($array_ch, $ch->store_id);
        endforeach;
}

if (isset($_GET['print_invoice'])) {
    if (isset($_GET['start'])) {
        $start = $_GET['start'];
        $countdown = $_GET['countdown'];
        $link = $obj->filename() . "?print_invoice=excel&start=" . $start . "&countdown=" . $countdown;
        $record_label = "Report Generate For " . $start . " And It&rsquo;s Showing Last " . $countdown . " Days Records.";
    } else {
        $link = $obj->filename() . "?print_invoice=excel";
        $record_label = "Report Generate For " . date('d/m/Y') . " And Showing Last 4 Days Records.";
    }
    header('Content-type: application/excel');
    $filename = date('Y_m_d') . '.xls';
    header('Content-Disposition: attachment; filename=' . $filename);

    $data = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">
<head>
    <!--[if gte mso 9]>
    <xml>
        <x:ExcelWorkbook>
            <x:ExcelWorksheets>
                <x:ExcelWorksheet>
                    <x:Name>Report : Wireless Geeks Inc.</x:Name>
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
    $data .="<h3>" . $record_label . "</h3>";
    $data .="<h5>Report Generate Date : " . date('d-m-Y H:i:s') . "</h5>";

    $data .="<table>
    <thead>
        <tr>
			<th>Date</th>
			<th>Checkin</th>
			<th>Checkin{Q}</th>
			<th>Checkin{PC}</th>
			<th>Ticket</th>
			<th>Ticket{Q}</th>
			<th>Ticket{PC}</th>
			<th>Unlock</th>
			<th>Unlock{Q}</th>
			<th>Unlock{PC}</th>
			<th>Payout [+]</th>
			<th>Payout [-]</th>
			<th>Cash</th>
			<th>Credit</th>
			<th>Cash Collected</th>
			<th>Credit Collected</th>
			<th>BuyBack</th>
			<th>BuyBack{Q}</th>
			<th>Total Daily Cash</th>
			<th>Total Monthly Cash</th>
			<th>Total{Q}</th>
			<th>Total Part Cost</th>
			<th>Total</th>
			<th>Profit</th>
		</tr>
</thead>        
<tbody>";

    $c = 0;
    $cq = 0;
    $cpc = 0;
    $t = 0;
    $tq = 0;
    $tpc = 0;
    $u = 0;
    $uq = 0;
    $upc = 0;
    $apoutp = 0;
    $apoutm = 0;
    $cashq = 0;
    $creditq = 0;
    $daycash = 0;
    $daycredit = 0;
    $b = 0;
    $bq = 0;
    //$alldaycash=0; $allmonthcash=0;
    $tttqqq = 0;
    $tttpppccc = 0;
    $tttccc = 0;
    $pppp = 0;

    $monthlycash = 0;
    if (isset($_GET['start'])) {
        $count = $obj->daysgone($_GET['start'], $_GET['end']);
        $ai = $count;
        //$ai=$_GET['countdown']-1;
    } else {
        $ai = 3;
    }


    for ($i = $ai; $i >= 0; $i--):
        if (@$_GET['start']) {
            $datenews = date_create($_GET['end']);
            date_modify($datenews, "-" . $i . " days");
            $datenew = date_format($datenews, "Y-m-d");
        } else {
            $ddf = date('Y-m-d');
            $datenews = date_create($ddf);
            date_modify($datenews, "-" . $i . " days");
            $datenew = date_format($datenews, "Y-m-d");

            //$datenew=date('Y-m-d', strtotime('-'.$i.' day')); 
        }


        if ($input_status == 5) {
            $sqlcheckinprice = $obj_report_chain->SelectAllByID_Multiple2_Or("checkin_list", array("date" => $datenew), $array_ch, "input_by", "1");
        } else {
            $sqlcheckinprice = $obj->SelectAllByID_Multiple("checkin_list", array("date" => $datenew, "input_by" => $input_by));
        }
        $checkinprice = 0;
        $checkinourprice = 0;
        $checkinquantity = 0;

        if (!empty($sqlcheckinprice))
            foreach ($sqlcheckinprice as $scp):

                $chkx = $obj->exists_multiple("check_user_price", array("ckeckin_id" => $scp->checkin_id));
                if ($chkx == 0) {
                    $estp = $obj->SelectAllByVal("product", "name", $scp->device . "-" . $scp->problem, "price_cost");
                    if ($estp == '') {
                        $devid = $obj->SelectAllByVal("checkin_request", "checkin_id", $scp->checkin_id, "device_id");
                        $modid = $obj->SelectAllByVal("checkin_request", "checkin_id", $scp->checkin_id, "model_id");
                        $probid = $obj->SelectAllByVal("checkin_request", "checkin_id", $scp->checkin_id, "problem_id");
                        $pp = $obj->SelectAllByVal3("checkin_price", "checkin_id", $devid, "checkin_version_id", $modid, "checkin_problem_id", $probid, "name");
                    } else {
                        $pp = $estp;
                    }
                } else {

                    $estp = $obj->SelectAllByVal("check_user_price", "ckeckin_id", $scp->checkin_id, "price");
                    if ($estp == '') {
                        $devid = $obj->SelectAllByVal("checkin_request", "checkin_id", $scp->checkin_id, "device_id");
                        $modid = $obj->SelectAllByVal("checkin_request", "checkin_id", $scp->checkin_id, "model_id");
                        $probid = $obj->SelectAllByVal("checkin_request", "checkin_id", $scp->checkin_id, "problem_id");
                        $pp = $obj->SelectAllByVal3("checkin_price", "checkin_id", $devid, "checkin_version_id", $modid, "checkin_problem_id", $probid, "name");
                    } else {
                        $pp = $estp;
                    }
                }


                $pid = $obj->SelectAllByVal("product", "name", $scp->device . ", " . $scp->model . " - " . $scp->problem, "id");
                $cid = $obj->SelectAllByVal2("coustomer", "firstname", $obj->SelectAllByVal("checkin_request", "checkin_id", $scp->checkin_id, "first_name"), "phone", $obj->SelectAllByVal("checkin_request", "checkin_id", $scp->checkin_id, "phone"), "id");
                $ourcost = $obj->SelectAllByVal("product", "name", $scp->device . ", " . $scp->model . " - " . $scp->problem, "price_cost");


                //$pp=$scp->retail_cost;
                if ($pp == '') {
                    $checkinpriceb = $obj->SelectAllByVal("product", "name", $scp->device . ", " . $scp->model . " - " . $scp->problem, "price_retail");
                } else {
                    $checkinpriceb = $pp;
                }
                $chkcheckin = $obj->exists_multiple("invoice", array("doc_type" => 3, "checkin_id" => $scp->checkin_id));
                $chkcheckin_id = $obj->SelectAllByVal("invoice", "checkin_id", $scp->checkin_id, "invoice_id");
                $curcheckcheckin = $obj->exists_multiple("sales", array("sales_id" => $chkcheckin_id));
                $curcheckcheckintax = $obj->exists_multiple("pos_tax", array("invoice_id" => $chkcheckin_id, "status" => 2));

                if ($curcheckcheckin == 0) {
                    $checkinprice+=0;
                    $checkinourprice+=0;
                    $checkinquantity+=0;
                } else {
                    if ($curcheckcheckintax == 0) {
                        $taxget = $tax_per_product;
                    } else {
                        $taxget = 0;
                    }

                    $rrprice = ($checkinpriceb * $taxget) / 100;

                    $checkinprice+=$checkinpriceb + $rrprice;
                    $checkinourprice+=$ourcost;
                    $checkinquantity+=1;
                }

            endforeach;
        $data .="<tr>
                                <td>" . $datenew . "</td>
                                <td>";
        $data .="$" . $checkinprice . "</td>
                                <td>" . $checkinquantity . "</td>";
        $c+=$checkinprice;
        $cq+=$checkinquantity;
        $data .="<td>$" . $checkinourprice . "</td>";
        $cpc+=$checkinourprice;
        if ($input_status == 5) {
            $sqlticketprice = $obj_report_chain->SelectAllByID_Multiple2_Or("ticket_list", array("date" => $datenew), $array_ch, "input_by", "1");
        } else {
            $sqlticketprice = $obj->SelectAllByID_Multiple("ticket_list", array("date" => $datenew, "input_by" => $input_by));
        }

        $ticketprice = 0;
        $ticketourprice = 0;
        $ticketquantity = 0;
        if (!empty($sqlticketprice))
            foreach ($sqlticketprice as $stp):
                $chkticket = $obj->exists_multiple("invoice", array("doc_type" => 3, "checkin_id" => $stp->ticket_id));
                $chkticket_id = $obj->SelectAllByVal("invoice", "checkin_id", $stp->ticket_id, "invoice_id");
                $curcheckticket = $obj->exists_multiple("sales", array("sales_id" => $chkticket_id));
                $curchecktickettax = $obj->exists_multiple("pos_tax", array("invoice_id" => $chkticket_id, "status" => 2));
                if ($curcheckticket == 0) {
                    $ticketprice+=0;
                    $ticketourprice+=0;
                    $ticketquantity+=0;
                } else {
                    if ($curchecktickettax == 0) {
                        $taxget = $tax_per_product;
                    } else {
                        $taxget = 0;
                    }

                    $rrpricet = ($stp->retail_cost * $taxget) / 100;


                    $ticketprice+=$stp->retail_cost + $rrpricet;
                    $ticketourprice+=$stp->our_cost;
                    $ticketquantity+=1;
                }
            endforeach;
        $t+=$ticketprice;

        $data .="<td>$" . $ticketprice . "</td>";
        $data .="<td>" . $ticketquantity . "</td>";
        $tq+=$ticketquantity;

        $data .="<td>$" . $ticketourprice . "</td>";
        $tpc+=$ticketourprice;

        if ($input_status == 5) {
            $sqlunlockprice = $obj_report_chain->SelectAllByID_Multiple2_Or("unlock_list", array("date" => $datenew), $array_ch, "input_by", "1");
        } else {
            $sqlunlockprice = $obj->SelectAllByID_Multiple("unlock_list", array("date" => $datenew, "input_by" => $input_by));
        }

        $unlockprice = 0;
        $unlockourprice = 0;
        $unlockquantity = 0;
        if (!empty($sqlunlockprice))
            foreach ($sqlunlockprice as $sup):
                $chkcheckin = $obj->exists_multiple("invoice", array("doc_type" => 3, "unlock_id" => $sup->unlock_id));
                $getsales_id = $obj->SelectAllByVal("invoice", "unlock_id", $sup->unlock_id, "invoice_id");
                $curcheck = $obj->exists_multiple("sales", array("sales_id" => $getsales_id));
                $curcheckunlocktax = $obj->exists_multiple("pos_tax", array("invoice_id" => $getsales_id, "status" => 2));
                if ($curcheck == 0) {
                    $unlockprice+=0;
                    $unlockourprice+=0;
                    $unlockquantity+=0;
                } else {
                    if ($curcheckunlocktax == 0) {
                        $taxget = $tax_per_product;
                    } else {
                        $taxget = 0;
                    }

                    $rrpricetu = ($sup->retail_cost * $taxget) / 100;

                    $unlockprice+=$sup->retail_cost + $rrpricetu;
                    $unlockourprice+=$sup->our_cost;
                    $unlockquantity+=1;
                }
            endforeach;
        $u+=$unlockprice;

        $data .="<td>$" . $unlockprice . "</td>";
        $data .="<td>" . $unlockquantity . "</td>";
        $uq+=$unlockquantity;

        $data .="<td>$" . $unlockourprice . "</td>";
        $upc+=$unlockourprice;
        if ($input_status == 5) {
            $sqlpayoutprice = $obj_report_chain->SelectAllByID_Multiple2_Or("payout", array("date" => $datenew), $array_ch, "input_by", "1");
        } else {
            $sqlpayoutprice = $obj->SelectAllByID_Multiple("payout", array("date" => $datenew, "input_by" => $input_by));
        }
        $payoutpriceplus = 0;
        $payoutpricemin = 0;
        if (!empty($sqlpayoutprice))
            foreach ($sqlpayoutprice as $spayoutp):
                $defineplus = substr($spayoutp->amount, 0, 1);
                if ($defineplus == "-") {
                    $payoutpricemin+=substr($spayoutp->amount, 1, 100);
                } elseif ($defineplus == "+") {
                    //$payoutpricemin+=substr($spayoutp->amount,1,100);
                    $payoutpriceplus+=substr($spayoutp->amount, 1, 100);
                } else {
                    $payoutpriceplus+=$spayoutp->amount;
                }
            endforeach;

        $data .="<td>$" . $payoutpriceplus . "</td>";
        $data .="<td>$" . $payoutpricemin . "</td>";
        $apoutp+=$payoutpriceplus;
        if ($input_status == 5) {
            $sqlcash = $obj_report_chain->SelectAllByID_Multiple2_Or("invoice_payment", array("date" => $datenew, "payment_type" => 3), $array_ch, "input_by", "1");
        } else {
            $sqlcash = $obj->SelectAllByID_Multiple("invoice_payment", array("date" => $datenew, "payment_type" => 3, "input_by" => $input_by));
        }

        $cash = 0;
        $cashquantity = 0;
        if (!empty($sqlcash))
            foreach ($sqlcash as $cases):
                $cash+=$cases->amount;
                $cashquantity+=1;
            endforeach;

        $data .="<td>" . $cashquantity . "</td>";

        if ($input_status == 5) {
            $sqlcredit = $obj_report_chain->SelectAllByID_Multiple2_Or("invoice_payment", array("date" => $datenew, "payment_type" => 4), $array_ch, "input_by", "1");
        } else {
            $sqlcredit = $obj->SelectAllByID_Multiple("invoice_payment", array("date" => $datenew, "payment_type" => 4, "input_by" => $input_by));
        }
        $credit = 0;
        $creditquantity = 0;
        if (!empty($sqlcredit))
            foreach ($sqlcredit as $cret):
                $credit+=$cret->amount;
                $creditquantity+=1;
            endforeach;
        $data .="<td>" . $creditquantity . "</td>";

        $data .="<td>$" . $cash . "</td>";

        $data .="<td>$" . $credit . "</td>";
        $daycash+=$cash;
        $daycredit+=$credit;

        if ($input_status == 5) {
            $sqlbuyback = $obj_report_chain->SelectAllByID_Multiple2_Or("buyback", array("date" => $datenew), $array_ch, "input_by", "1");
        } else {
            $sqlbuyback = $obj->SelectAllByID_Multiple("buyback", array("date" => $datenew, "input_by" => $input_by));
        }

        $buyback = 0;
        $buybackquantity = 0;
        if (!empty($sqlbuyback))
            foreach ($sqlbuyback as $buyb):
                $buyback+=$buyb->price;
                $buybackquantity+=1;
            endforeach;
        $data .="<td>$" . $buyback . "</td>";

        $data .="<td>" . $buybackquantity . "</td>";
        $b+=$buyback;
        $bq+=$buybackquantity;
        $totaldailycash = $cash - $payoutpricemin - $buyback;
        $data .="<td>$" . $totaldailycash . "</td>";
        $monthlycash+=$totaldailycash;
        $data .="<td>$" . $monthlycash . "</td>";
        $quantity = $checkinquantity + $ticketquantity + $unlockquantity;
        $data .="<td>" . $quantity . "</td>";
        $ourcost = $checkinourprice + $ticketourprice + $unlockourprice;
        $data .="<td>$" . $ourcost . "</td>";
        $priceretail = $checkinprice + $ticketprice + $unlockprice;
        $data .="<td>$" . $priceretail . "</td>";
        $profit = $priceretail - $ourcost;
        $data .="<td>$" . $profit . "</td>
                            </tr>";

        $tttqqq+=$quantity;
        $tttpppccc+=$ourcost;
        $tttccc+=$priceretail;
        $pppp+=$profit;
    endfor;

    $data .="</tbody><tfoot><tr>
			<th>Date</th>
			<th>Checkin { $" . $c . " }</th>
			<th>Checkin{ Q : " . $cq . " }</th>
			<th>Checkin{ PC : $" . $cpc . " }</th>
			
			<th>Ticket { $" . $t . " } </th>
			<th>Ticket{ Q : " . $tq . " }</th>
			<th>Ticket{ PC : $" . $tpc . " }</th>
			<th>Unlock { $" . $u . " } </th>
			<th>Unlock{ Q : " . $uq . " }</th>
			<th>Unlock{ PC : $" . $upc . " }</th>
			<th>Payout[+] { $" . $apoutp . " } </th>
			<th>Payout[-] { $" . $apoutm . " }</th>
			<th>Cash { $" . $cashq . " } </th>
			<th>Credit { $" . $creditq . " }</th>
			<th>Cash Collected { $" . $daycash . " } </th>
			<th>Credit Collected { $" . $daycredit . " } </th>
			<th>BuyBack { $" . $b . " } </th>
			<th>BuyBack{ Q : " . $bq . " }</th>
			<th>Total Daily Cash</th>
			<th>Total Monthly Cash</th>
			<th>Total{ Q : " . $tttqqq . " }</th>
			<th>Total Part Cost { $" . $tttpppccc . " } </th>
			<th>Total { $" . $tttccc . " } </th>
			<th>Profit { $" . $pppp . " } </th>
		</tr></tfoot></table>";

    $data .='</body></html>';

    echo $data;
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php echo $obj->bodyhead(); ?>
        <script src="ajax/customer_ajax.js"></script>
    </head>
    <body style="width:3100px;">
        <?php include('include/header.php'); ?>
        <!-- Main wrapper -->
        <!-- Left sidebar -->
        <?php //include('include/sidebar_left.php');  ?>
        <!-- /left sidebar -->
        <!-- Main content -->

        <!-- Info notice -->
        <?php echo $obj->ShowMsg(); ?>
        <!-- /info notice -->
        <div class="inner">
            <div class="page-header"><!-- Page header -->
                <?php
                echo $obj->ShowMsg();
                if (isset($_GET['start'])) {
                    $start = $_GET['start'];
                    $countdowns = $obj->daysgone($_GET['start'], $_GET['end']) + 1;
                    $link = $obj->filename() . "?print_invoice=excel&start=" . $start . "&end=" . $_GET['end'] . "&countdown=" . $countdowns;
                    $record_label = "Report Generate For " . $start . " And It&rsquo;s Showing Last " . $countdowns . " Days Records.";
                } else {
                    $link = $obj->filename() . "?print_invoice=excel";
                    $record_label = "Report Generate For " . date('d/m/Y') . " And Showing Last 4 Days Records.";
                }
                ?>
                <h5><i class="font-home"></i> Report  | <a href="<?php echo $link; ?>"> Export in Excel </a>  | <a  data-toggle="modal" href="#myModal"> Search Datewise </a>  | <a  href="index.php"> Back To Home </a></h5>
            </div><!-- /page header -->

            <div class="body" style="width:3000px;">

                <!-- Middle navigation standard -->
                <?php //include('include/quicklink.php');  ?>
                <!-- /middle navigation standard -->

                <!-- Content container -->
                <div class="container" style="width:3000px;">

                    <!-- Content Start from here customized -->




                    <!-- General form elements -->
                    <div class="row-fluid block" style="width:3000px;">

                        <!-- Dialog content -->
                        <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <form action="" method="get">
                                <div class="modal-header" style="height:25px;">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h5 id="myModalLabel"><i class="icon-calendar"></i> Search Datewise</h5>
                                </div>
                                <div class="modal-body">
                                    <div class="row-fluid">
                                        <div class="control-group">
                                            <label class="control-label">Date range:</label>
                                            <div class="controls">
                                                <!--<input type="text" name="start" readonly class="datepicker" />-->
                                                <ul class="dates-range">
                                                    <li><input type="text" id="fromDate" style="cursor:pointer;"  name="start" placeholder="From" /></li>
                                                    <li class="sep">-</li>
                                                    <li><input type="text" style="cursor:pointer;"   id="toDate" name="end" placeholder="To" /></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-primary"  type="submit" name="search_date"><i class="icon-screenshot"></i> Search</button>
                                </div>
                            </form>
                        </div>
                        <!-- /dialog content -->

                        <div class="table-overflow">
                            <h2><?php echo $record_label; ?></h2>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Date <?php echo $input_status; ?></th>
                                        <th>Checkin</th>
                                        <th>Checkin{Q}</th>
                                        <th>Checkin{PC}</th>
                                        <th>Ticket</th>
                                        <th>Ticket{Q}</th>
                                        <th>Ticket{PC}</th>
                                        <th>Unlock</th>
                                        <th>Unlock{Q}</th>
                                        <th>Unlock{PC}</th>
                                        <th>Payout [+]</th>
                                        <th>Payout [-]</th>
                                        <th>Cash</th>
                                        <th>Credit</th>
                                        <th>Cash Collected</th>
                                        <th>Credit Collected</th>
                                        <th>BuyBack</th>
                                        <th>BuyBack{Q}</th>
                                        <th>Total Daily Cash</th>
                                        <th>Total Monthly Cash</th>
                                        <th>Total{Q}</th>
                                        <th>Total Part Cost</th>
                                        <th>Total</th>
                                        <th>Profit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $c = 0;
                                    $cq = 0;
                                    $cpc = 0;
                                    $t = 0;
                                    $tq = 0;
                                    $tpc = 0;
                                    $u = 0;
                                    $uq = 0;
                                    $upc = 0;
                                    $apoutp = 0;
                                    $apoutm = 0;
                                    $cashq = 0;
                                    $creditq = 0;
                                    $daycash = 0;
                                    $daycredit = 0;
                                    $b = 0;
                                    $bq = 0;
//$alldaycash=0; $allmonthcash=0;
                                    $tttqqq = 0;
                                    $tttpppccc = 0;
                                    $tttccc = 0;
                                    $pppp = 0;

                                    $monthlycash = 0;
                                    $loopi = 1;
                                    if (isset($_GET['start'])) {
                                        $count = $obj->daysgone($_GET['start'], $_GET['end']);
                                        $ai = $count;
                                    } else {
                                        $ai = 3;
                                    }


                                    for ($i = $ai; $i >= 0; $i--):
                                        ?>
                                        <tr>
                                            <td><?php
                                                if (@$_GET['start']) {
                                                    $datenews = date_create($_GET['end']);
                                                    date_modify($datenews, "-" . $i . " days");
                                                    $datenew = date_format($datenews, "Y-m-d");
                                                } else {
                                                    $ddf = date('Y-m-d');
                                                    $datenews = date_create($ddf);
                                                    date_modify($datenews, "-" . $i . " days");
                                                    $datenew = date_format($datenews, "Y-m-d");

                                                    //$datenew=date('Y-m-d', strtotime('-'.$i.' day')); 
                                                }

                                                echo $datenew;
                                                ?></td>
                                            <td>
                                                <?php
                                                $checkinprice = 0;
                                                $checkinquantity = 0;
                                                $checkinourprice = 0;
                                                if ($input_status == 5) {
                                                    $sqlcheckinprice = $obj_report_chain->SelectAllByID_Multiple2_Or("checkin_list", array("date" => $datenew), $array_ch, "input_by", "1");
                                                } else {
                                                    //new chinlist query start
                                                    $sqlpars = "SELECT alldata.*,
                                                            IFNULL((SELECT SUM(amount) FROM invoice_payment WHERE invoice_id=alldata.invoice_id GROUP BY invoice_id),0) as paid,p.price_cost as checkin_our_cost
                                                            #alldata.invoice_id as inid 
                                                    FROM (select
                                                    r.id,
                                                    r.first_name,
                                                    r.phone,
                                                    r.checkin_id,
                                                    CONCAT(replace(c.`name`,' ',''),',',cv.`name`,',',cvc.`name`,',',cn.`name`) as `detail`,      
                                                    r.problem_id,
                                                    cp.`name` as problem,
                                                    (SELECT COUNT(*) FROM check_user_price as cup WHERE cup.ckeckin_id=r.checkin_id)  AS pricechk,
                                                    #define product cost by case
                                                    CASE (SELECT COUNT(*) FROM check_user_price as cup WHERE cup.ckeckin_id=r.checkin_id)
                                                            WHEN 0 THEN 

                                                                    CASE (SELECT price_cost FROM product WHERE name=concat(replace(c.`name`,' ',''),'-',cp.`name`))
                                                                            WHEN '' THEN 
                                                                             (SELECT name FROM checkin_price WHERE ";
                                                    $sqlpars .="#only applicable if not admin ";

                                                    if ($input_status != 1) {
                                                        if ($input_status != 5) {
                                                            $sqlpars .=" store_id='" . $input_by . "' AND ";
                                                        }
                                                    }

                                                    $sqlpars .="#only applicable if not admin
                                                                             checkin_id=r.device_id AND 
                                                                             checkin_version_id=r.model_id AND 
                                                                             checkin_problem_id=r.problem_id ORDER BY id DESC LIMIT 1)
                                                                        ELSE 
                                                                             (SELECT price_cost FROM product WHERE name=concat(replace(c.`name`,' ',''),'-',cp.`name`))
                                                                    END

                                                        ELSE 
                                                            CASE (SELECT price FROM check_user_price as cup WHERE cup.ckeckin_id=r.checkin_id)
                                                                    WHEN '' THEN 
                                                                                    (SELECT name FROM checkin_price WHERE ";
                                                    $sqlpars .="#only applicable if not admin ";

                                                    if ($input_status != 1) {
                                                        if ($input_status != 5) {
                                                            $sqlpars .=" store_id='" . $input_by . "' AND ";
                                                        }
                                                    }

                                                    $sqlpars .="#only applicable if not admin
                                                                             checkin_id=r.device_id AND 
                                                                             checkin_version_id=r.model_id AND 
                                                                             checkin_problem_id=r.problem_id ORDER BY id DESC LIMIT 1)
                                                                ELSE (SELECT price FROM check_user_price as cup WHERE cup.ckeckin_id=r.checkin_id)
                                                            END    
                                                    END AS checkin_price,    
                                                    #define product cost by case end

                                                    #get pid by concat device detail
                                                    IFNULL((SELECT id FROM product WHERE ";
                                                    $sqlpars .="#if not admin ";

                                                    if ($input_status != 1) {
                                                        if ($input_status != 5) {
                                                            $sqlpars .=" store_id='" . $input_by . "' AND ";
                                                        }
                                                    }

                                                    $sqlpars .="#if not admin                    
                                                    name=concat(replace(c.`name`,' ',''),', ',cv.`name`,' - ',cp.`name`) ORDER BY id DESC LIMIT 1),(SELECT id FROM product WHERE ";
                                                    $sqlpars .="#if not admin ";

                                                    if ($input_status != 1) {
                                                        if ($input_status != 5) {
                                                            $sqlpars .=" store_id='" . $input_by . "' AND ";
                                                        }
                                                    }

                                                    $sqlpars .="#if not admin  
                                                    name=concat(replace(c.`name`,' ',''),' , ',cv.`name`,' - ',cp.`name`) ORDER BY id DESC LIMIT 1)) AS pid,
                                                    #get pid by concat device detail END
                                                    IFNULL((SELECT id FROM coustomer as cus WHERE cus.firstname=r.first_name AND cus.phone=r.phone LIMIT 1),0) as cid,
                                                    #pc.invoice_id as invoice_id,
                                                    IFNULL((SELECT invoice_id FROM pos_checkin WHERE checkin_id=r.checkin_id LIMIT 1),0) as invoice_id,
                                                    #(SELECT count(id) FROM invoice WHERE invoice_id=IFNULL((SELECT invoice_id FROM pos_checkin WHERE checkin_id=r.checkin_id),0) LIMIT 1) AS invoice_status,
                                                    #ip.amount as paid,
                                                    #(SELECT SUM(amount) FROM invoice_payment WHERE invoice_id= GROUP BY invoice_id) as paid,
                                                    r.date,
                                                    r.input_by,
                                                    r.status from checkin_request as r
                                                    #INNER JOIN pos_checkin as pc on pc.checkin_id=r.checkin_id
                                                    #INNER JOIN (SELECT SUM(amount) as amount,invoice_id FROM invoice_payment GROUP BY invoice_id) as ip on ip.invoice_id=pc.invoice_id
                                                    INNER JOIN checkin as c ON c.id=r.device_id
                                                    INNER JOIN checkin_version as cv ON cv.id=r.model_id
                                                    INNER JOIN checkin_version_color as cvc ON cvc.id=r.color_id
                                                    INNER JOIN checkin_network as cn ON cn.id=r.network_id
                                                    INNER JOIN checkin_problem as cp ON cp.id=r.problem_id 
                                                    WHERE r.checkin_id IN (SELECT crt.checkin_id FROM checkin_request_ticket as crt) AND 
                                                    r.date ='$datenew' AND r.input_by='$input_by' ORDER BY id DESC) AS alldata 
                                                    LEFT JOIN product as p on p.id=alldata.pid";
                                                    // echo $sqlpars;


                                                    $sqlcheckinprice = $obj->FlyQuery($sqlpars);
                                                    //new checkinlist query end
                                                    //$sqlcheckinprice = $obj->SelectAllByID_Multiple("checkin_list", array("date" => $datenew, "input_by" => $input_by));

                                                    if (!empty($sqlcheckinprice)) {
                                                        foreach ($sqlcheckinprice as $cpcd):
                                                            if ($cpcd->checkin_our_cost == 0) {
                                                                $checkinprice += 0;
                                                                $checkinquantity += 0;
                                                                $checkinourprice += 0;
                                                            } else {
                                                                $checkinprice += $cpcd->checkin_price;
                                                                $checkinquantity += 1;
                                                                $checkinourprice += $cpcd->checkin_our_cost;
                                                            }

                                                        endforeach;
                                                    }
                                                }

                                                echo $currencyicon . $checkinprice;
                                                $c+=$checkinprice;
                                                ?>
                                            </td>
                                            <td><?php
                                                echo $currencyicon . $checkinquantity;
                                                $cq+=$checkinquantity;
                                                ?></td>
                                            <td><?php
                                                echo $currencyicon . $checkinourprice;
                                                $cpc+=$checkinourprice;
                                                ?></td>

                                            <td>
                                                <?php
                                                if ($input_status == 5) {
                                                    $sqlticketprice = $obj_report_chain->SelectAllByID_Multiple2_Or("ticket_list", array("date" => $datenew), $array_ch, "input_by", "1");
                                                } else {
                                                    //NEW TICKET QUERY START HERE 
                                                    $sqlpars = "SELECT alldata.*,
                                                                (SELECT SUM(amount) FROM invoice_payment WHERE invoice_id=alldata.invoice_id GROUP BY invoice_id) as paid
                                                                FROM (select 
                                                                t.id,
                                                                t.ticket_id,
                                                                t.title,
                                                                t.date,
                                                                t.status,
                                                                t.problem_type,
                                                                pt.name as problem,
                                                                CASE (SELECT count(id) FROM product WHERE name=concat(t.title,' - ',t.ticket_id)) 
                                                                        WHEN 0 THEN 0
                                                                    ELSE (SELECT id FROM product WHERE name=concat(t.title,' - ',t.ticket_id) ORDER BY id DESC LIMIT 1)
                                                                END AS pid,
                                                                CASE (SELECT count(id) FROM product WHERE name=concat(t.title,' - ',t.ticket_id)) 
                                                                        WHEN 0 THEN 0
                                                                    ELSE (SELECT price_retail FROM product WHERE name=concat(t.title,' - ',t.ticket_id) ORDER BY id DESC LIMIT 1)
                                                                END AS price,
                                                                IFNULL((SELECT invoice_id FROM pos_checkin WHERE checkin_id=t.ticket_id LIMIT 1),0) as invoice_id,
                                                                t.retail_cost AS pricee,
                                                                t.our_cost AS our_cost,
                                                                t.input_by
                                                                from ticket as t 
                                                                LEFT JOIN problem_type as pt ON pt.id=t.problem_type 
                                                                WHERE t.date='$datenew' AND t.input_by='$input_by') AS alldata";
                                                    // echo $sqlpars;


                                                    $sqlticketprice = $obj->FlyQuery($sqlpars);
                                                    //NEW TICKET QUERY END HERE 
                                                    //$sqlticketprice = $obj->SelectAllByID_Multiple("ticket_list", array("date" => $datenew, "input_by" => $input_by));
                                                }
                                                //echo $sqlpars;
                                                $ticketprice = 0;
                                                $ticketourprice = 0;
                                                $ticketquantity = 0;
                                                if (!empty($sqlticketprice))
                                                    foreach ($sqlticketprice as $stp):

                                                        if ($stp->paid == 0) {
                                                            $ticketprice+=0;
                                                            $ticketourprice+=0;
                                                            $ticketquantity+=0;
                                                        } else {
                                                            $ticketprice+=$stp->paid;
                                                            $ticketourprice+=$stp->our_cost;
                                                            $ticketquantity+=1;
                                                        }
                                                    endforeach;
                                                echo $currencyicon . $ticketprice;
                                                $t+=$ticketprice;
                                                ?>
                                            </td>
                                            <td><?php
                                                echo $ticketquantity;
                                                $tq+=$ticketquantity;
                                                ?></td>
                                            <td>
                                                <?php
                                                echo $currencyicon . $ticketourprice;
                                                $tpc+=$ticketourprice;
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                if ($input_status == 5) {
                                                    $sqlunlockprice = $obj_report_chain->SelectAllByID_Multiple2_Or("unlock_list", array("date" => $datenew), $array_ch, "input_by", "1");
                                                } else {
                                                    //new unlock request
                                                    
                                                    
                                                    //new unlock requst query
                                                    $sqlunlockprice = $obj->SelectAllByID_Multiple("unlock_list", array("date" => $datenew, "input_by" => $input_by));
                                                }


                                                $unlockprice = 0;
                                                $unlockourprice = 0;
                                                $unlockquantity = 0;
                                                if (!empty($sqlunlockprice))
                                                    foreach ($sqlunlockprice as $sup):
                                                        $chkcheckin = $obj->exists_multiple("invoice", array("doc_type" => 3, "unlock_id" => $sup->unlock_id));
                                                        $getsales_id = $obj->SelectAllByVal("invoice", "unlock_id", $sup->unlock_id, "invoice_id");
                                                        $curcheck = $obj->exists_multiple("sales", array("sales_id" => $getsales_id));
                                                        $curcheckunlocktax = $obj->exists_multiple("pos_tax", array("invoice_id" => $getsales_id, "status" => 2));
                                                        if ($curcheck == 0) {
                                                            $unlockprice+=0;
                                                            $unlockourprice+=0;
                                                            $unlockquantity+=0;
                                                        } else {
                                                            if ($curcheckunlocktax == 0) {
                                                                $taxget = $tax_per_product;
                                                            } else {
                                                                $taxget = 0;
                                                            }

                                                            $rrpricetu = ($sup->retail_cost * $taxget) / 100;

                                                            $unlockprice+=$sup->retail_cost + $rrpricetu;
                                                            $unlockourprice+=$sup->our_cost;
                                                            $unlockquantity+=1;
                                                        }
                                                    endforeach;
                                                echo $unlockprice;
                                                $u+=$unlockprice;
                                                ?>
                                            </td>
                                            <td><?php
                                                echo $unlockquantity;
                                                $uq+=$unlockquantity;
                                                ?></td>
                                            <td>
                                                <?php
                                                echo $currencyicon . $unlockourprice;
                                                $upc+=$unlockourprice;
                                                ?>
                                            </td>
                                            <td><?php
                                                if ($input_status == 5) {
                                                    $sqlpayoutprice = $obj_report_chain->SelectAllByID_Multiple2_Or("payout", array("date" => $datenew), $array_ch, "input_by", "1");
                                                } else {
                                                    $sqlpayoutprice = $obj->SelectAllByID_Multiple("payout", array("date" => $datenew, "input_by" => $input_by));
                                                }


                                                $payoutpriceplus_store = 0;
                                                $payoutpricemin_store = 0;
                                                if (!empty($sqlpayoutprice))
                                                    foreach ($sqlpayoutprice as $spayoutp_store):
                                                        $defineplus_store = substr($spayoutp_store->amount, 0, 1);
                                                        if ($defineplus_store == "-") {
                                                            $payoutpricemin_store+=substr($spayoutp_store->amount, 1, 100);
                                                        } elseif ($defineplus_store == "+") {
                                                            //$payoutpricemin_store+=substr($spayoutp_store->amount,1,100);
                                                            $payoutpriceplus_store+=substr($spayoutp_store->amount, 1, 100);
                                                        } else {
                                                            $payoutpriceplus_store+=$spayoutp_store->amount;
                                                        }
                                                    endforeach;
                                                echo $currencyicon . $payoutpriceplus_store;
                                                ?>
                                            </td>
                                            <td><?php
                                                //echo $payoutpricemin; 
                                                $padfg = $payoutpriceplus_store + $payoutpricemin_store;
                                                echo $currencyicon . $payoutpricemin_store;
                                                $apoutp+=$payoutpriceplus_store;
                                                $apoutm+=$payoutpricemin_store;
                                                ?></td>
                                            <td>
                                                <?php
                                                if ($input_status == 5) {
                                                    $sqlcash = $obj_report_chain->SelectAllByID_Multiple2_Or("invoice_payment", array("date" => $datenew, "payment_type" => 3), $array_ch, "input_by", "1");
                                                } else {
                                                    $sqlcash = $obj->SelectAllByID_Multiple("invoice_payment", array("date" => $datenew, "payment_type" => 3, "input_by" => $input_by));
                                                }


                                                $cash = 0;
                                                $cashquantity = 0;
                                                if (!empty($sqlcash))
                                                    foreach ($sqlcash as $cases):
                                                        $cash+=$cases->amount;
                                                        $cashquantity+=1;
                                                    endforeach;
                                                echo $cashquantity;
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                if ($input_status == 5) {
                                                    $sqlcredit = $obj_report_chain->SelectAllByID_Multiple2_Or("invoice_payment", array("date" => $datenew, "payment_type" => 4), $array_ch, "input_by", "1");
                                                } else {
                                                    $sqlcredit = $obj->SelectAllByID_Multiple("invoice_payment", array("date" => $datenew, "payment_type" => 4, "input_by" => $input_by));
                                                }



                                                $credit = 0;
                                                $creditquantity = 0;
                                                if (!empty($sqlcredit))
                                                    foreach ($sqlcredit as $cret):
                                                        $credit+=$cret->amount;
                                                        $creditquantity+=1;
                                                    endforeach;
                                                echo $creditquantity;
                                                ?>
                                            </td>
                                            <td><?php echo $currencyicon . $cash; ?></td>
                                            <td><?php
                                                echo $currencyicon . $credit;
                                                $daycash+=$cash;
                                                $daycredit+=$credit;
                                                ?></td>
                                            <td>
                                                <?php
                                                if ($input_status == 5) {
                                                    $sqlbuyback = $obj_report_chain->SelectAllByID_Multiple2_Or("buyback", array("date" => $datenew), $array_ch, "input_by", "1");
                                                } else {
                                                    $sqlbuyback = $obj->SelectAllByID_Multiple("buyback", array("date" => $datenew, "input_by" => $input_by));
                                                }



                                                $buyback = 0;
                                                $buybackquantity = 0;
                                                if (!empty($sqlbuyback))
                                                    foreach ($sqlbuyback as $buyb):
                                                        $buyback+=$buyb->price;
                                                        $buybackquantity+=1;
                                                    endforeach;
                                                echo $currencyicon . $buyback;
                                                ?>
                                            </td>
                                            <td><?php
                                                echo $currencyicon . $buybackquantity;
                                                $b+=$buyback;
                                                $bq+=$buybackquantity;
                                                ?></td>
                                            <td><?php
                                                @$totaldailycash = $cash - $payoutpricemin - $buyback;
                                                echo $currencyicon . $totaldailycash;
                                                ?></td>
                                            <td><?php
                                                $monthlycash+=$totaldailycash;
                                                echo $currencyicon . $monthlycash;
                                                ?></td>
                                            <td>
                                                <?php
                                                $quantity = $checkinquantity + $ticketquantity + $unlockquantity;
                                                echo $quantity;
                                                ?>
                                            </td>
                                            <td><?php
                                                $ourcost = $checkinourprice + $ticketourprice + $unlockourprice;
                                                echo $currencyicon . $ourcost;
                                                ?></td>
                                            <td><?php
                                                $priceretail = $checkinprice + $ticketprice + $unlockprice;
                                                echo $currencyicon . $priceretail;
                                                ?></td>
                                            <td>
                                                <?php
                                                $profit = $priceretail - $ourcost;
                                                echo $currencyicon . $profit;
                                                $tttqqq+=$quantity;
                                                $tttpppccc+=$ourcost;
                                                $tttccc+=$priceretail;
                                                $pppp+=$profit;
                                                ?>
                                            </td>
                                        </tr>
                                        <?php
                                        $loopi++;
                                    endfor;
                                    ?>            
                                </tbody>
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Checkin { <?php echo $currencyicon . $c; ?> }</th>
                                        <th>Checkin{ Q : <?php echo $cq; ?> }</th>
                                        <th>Checkin{ PC : <?php echo $currencyicon . $cpc; ?> }</th>

                                        <th>Ticket { <?php echo $currencyicon . $t; ?> } </th>
                                        <th>Ticket{ Q : <?php echo $tq; ?> }</th>
                                        <th>Ticket{ PC : <?php echo $currencyicon . $tpc; ?> }</th>
                                        <th>Unlock { <?php echo $currencyicon . $u; ?> } </th>
                                        <th>Unlock{ Q : <?php echo $uq; ?> }</th>
                                        <th>Unlock{ PC : <?php echo $currencyicon . $upc; ?> }</th>
                                        <th>Payout[+] { <?php echo $currencyicon . $apoutp; ?> } </th>
                                        <th>Payout[-] { <?php echo $currencyicon . $apoutm; ?> }</th>
                                        <th>Cash { <?php echo $currencyicon . $cashq; ?> } </th>
                                        <th>Credit { <?php echo $currencyicon . $creditq; ?> }</th>
                                        <th>Cash Collected { <?php echo $currencyicon . $daycash; ?> } </th>
                                        <th>Credit Collected { <?php echo $currencyicon . $daycredit; ?> } </th>
                                        <th>BuyBack { <?php echo $currencyicon . $b; ?> } </th>
                                        <th>BuyBack{ Q : <?php echo $bq; ?> }</th>
                                        <th>Total Daily Cash</th>
                                        <th>Total Monthly Cash</th>
                                        <th>Total{ Q : <?php echo $tttqqq; ?> }</th>
                                        <th>Total Part Cost { <?php echo $currencyicon . $tttpppccc; ?> } </th>
                                        <th>Total { <?php echo $currencyicon . $tttccc; ?> } </th>
                                        <th>Profit { <?php echo $currencyicon . $pppp; ?> } </th>
                                    </tr>
                                </thead>
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
        <!-- /main content -->
        <?php include('include/footer.php'); ?>
        <!-- Right sidebar -->
        <?php //include('include/sidebar_right.php');       ?>
        <!-- /right sidebar -->

        <!-- /main wrapper -->

    </body>
</html>
