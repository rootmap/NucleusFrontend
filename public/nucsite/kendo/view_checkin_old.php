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
$sqlpagecheckinrequest = $ops->FlyQuery("select id,checkin_id,first_name,last_name,email,phone,access_id,(SELECT name FROM store WHERE store.store_id=checkin_request.input_by AND store.`status`=2) as input_by,input_by as creator,date,
(select `name` from checkin where checkin.id = checkin_request.device_id limit 1) AS device,
(select `name` from checkin_version where checkin_version.id = checkin_request.model_id limit 1) AS model,
(select `name` from checkin_version_color where checkin_version_color.id = checkin_request.color_id limit 1) AS color,
(select `name` from checkin_network where checkin_network.id = checkin_request.network_id limit 1) AS network,
(select `name` from checkin_problem where checkin_problem.id = checkin_request.problem_id limit 1) AS problem,
warrenty AS warrenty,
(select `imei` from checkin_request_ticket where checkin_request_ticket.checkin_id = checkin_request.checkin_id ORDER BY id DESC limit 1) as imei,
(select salvage_part from checkin_request_ticket where checkin_request_ticket.checkin_id = checkin_request.checkin_id ORDER BY id DESC limit 1) as salvage_part,
(select lcdstatus from checkin_request_ticket where checkin_request_ticket.checkin_id = checkin_request.checkin_id ORDER BY id DESC limit 1) as lcdstatus,
(select signature from setting_report WHERE store_id='" . $input_by . "' LIMIT 1) as signature FROM checkin_request WHERE checkin_id='" . $ticket_id . "' LIMIT 1");

$sql_new_device = str_replace(' ', '', $sqlpagecheckinrequest[0]->device);
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
            printDivCSS = new String('<link href="<?= $obj->baseUrl("css/main.css") ?>" rel="stylesheet">')
            function printDiv() {

                var rows = document.getElementById('showtextarea').scrollHeight;
                //var cols=document.getElementById('showtextarea').scrollWidth;

                $('#printtextarea').height(rows);
                //$('#printtextarea').width(cols);

                var canvas = document.getElementById("canvas");
                var image = canvas.toDataURL("image/png");
                document.getElementById('signature-body').innerHTML = '<img src="' + image + '"/>';

                window.frames["print_frame"].document.body.innerHTML = '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
                window.frames["print_frame"].document.body.innerHTML += printDivCSS;
                window.frames["print_frame"].document.body.innerHTML += document.getElementById('terms-print').innerHTML;

                var signaturebody = $("#print_frame").contents().find("#signature-body")
                $(signaturebody).css('border', '1px solid black');
                //signaturebody.style.border = "thick solid #0000FF";

                window.frames["print_frame"].window.focus();
                window.frames["print_frame"].window.print();

            }

            function TicketWorkUpdate(table, field, ticket_id, status, fetchplace)
            {
                if (ticket_id == "")
                {
                    document.getElementById(fetchplace).innerHTML = "";
                    return;
                }
                if (window.XMLHttpRequest)
                {
                    xmlhttp = new XMLHttpRequest();
                }
                else
                {
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function ()
                {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
                    {
                        $("#" + fetchplace).fadeOut();
                        $("#" + fetchplace).fadeIn();
                        //document.getElementById(fetchplace).innerHTML=xmlhttp.responseText;
                        var newhtml_place = "";
                        if (fetchplace == "Diagnostic")
                        {
                            var newhtml_place = "1. Diagnostic : " + xmlhttp.responseText;
                            $("#" + fetchplace).html(newhtml_place);
                        }
                        else if (fetchplace == "Complete")
                        {
                            var newhtml_place = "2. Status Complete : " + xmlhttp.responseText;
                            $("#" + fetchplace).html(newhtml_place);
                        }
                        else if (fetchplace == "Warranty")
                        {
                            var newhtml_place = "3. Warranty Length : " + xmlhttp.responseText;
                            $("#" + fetchplace).html(newhtml_place);
                        }
                        else
                        {
                            window.location.replace('./<?php echo $obj->filename(); ?>');
                        }
                    }
                }
                st = 6915;
                xmlhttp.open("GET", "ajax/ticket.php?st=" + st + "&ticket_id=" + ticket_id + "&status=" + status + "&fetchplace=" + fetchplace + "&table=" + table + "&field=" + field, true);
                xmlhttp.send();
            }

            function TicketWorkChanged(table, field, val, ufield, uval, fetchplace)
            {
                if (fetchplace == "")
                {
                    document.getElementById(fetchplace).innerHTML = "";
                    return;
                }

                if (window.XMLHttpRequest)
                {
                    xmlhttp = new XMLHttpRequest();
                }
                else
                {
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }

                xmlhttp.onreadystatechange = function ()
                {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
                    {
                        $("#" + fetchplace).fadeOut();
                        $("#" + fetchplace).fadeIn();
                        //document.getElementById(fetchplace).innerHTML=xmlhttp.responseText;
                        var newhtml_place = "";
                        if (fetchplace == "Diagnostic")
                        {
                            var newhtml_place = "1. Diagnostic : " + xmlhttp.responseText;
                            $("#" + fetchplace).html(newhtml_place);
                        }
                        else if (fetchplace == "Complete")
                        {
                            var newhtml_place = "2. Status Complete : " + xmlhttp.responseText;
                            $("#" + fetchplace).html(newhtml_place);
                        }
                        else if (fetchplace == "Warranty")
                        {
                            var newhtml_place = "3. Warranty Length : " + xmlhttp.responseText;
                            $("#" + fetchplace).html(newhtml_place);
                        }
                        else
                        {
                            window.location.replace('./<?php echo $obj->filename(); ?>');
                        }
                    }
                }
                st = 3266;
                stt = document.getElementById(uval).value;
                xmlhttp.open("GET", "ajax/ticket.php?st=" + st + "&table=" + table + "&field=" + field + "&val=" + val + "&ufield=" + ufield + "&uval=" + stt + "&fetchplace=" + fetchplace, true);
                xmlhttp.send();
            }


            function Warrentys(table, field, ticket_id, status, fetchplace, pid)
            {
                if (ticket_id == "")
                {
                    document.getElementById(fetchplace).innerHTML = "";
                    return;
                }
                if (window.XMLHttpRequest)
                {
                    xmlhttp = new XMLHttpRequest();
                }
                else
                {
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function ()
                {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
                    {
                        $("#" + fetchplace).fadeOut();
                        $("#" + fetchplace).fadeIn();

                        //document.getElementById(fetchplace).innerHTML=xmlhttp.responseText;
                        var newhtml_place = "3. Warranty Length : " + xmlhttp.responseText;
                        $("#" + fetchplace).html(newhtml_place);

                    }
                }
                st = 2034; //80
                xmlhttp.open("GET", "ajax/ticket.php?st=" + st + "&ticket_id=" + ticket_id + "&status=" + status + "&fetchplace=" + fetchplace + "&table=" + table + "&field=" + field + "&pid=" + pid, true);
                xmlhttp.send();
            }


            function WarrentyChanged(table, field, val, ufield, uval, fetchplace, pid)
            {
                if (fetchplace == "")
                {
                    document.getElementById(fetchplace).innerHTML = "";
                    return;
                }

                if (window.XMLHttpRequest)
                {
                    xmlhttp = new XMLHttpRequest();
                }
                else
                {
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }

                xmlhttp.onreadystatechange = function ()
                {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
                    {
                        $("#" + fetchplace).fadeOut();
                        $("#" + fetchplace).fadeIn();
                        //document.getElementById(fetchplace).innerHTML=xmlhttp.responseText;
                        var newhtml_place = "3. Warranty Length : " + xmlhttp.responseText;
                        $("#" + fetchplace).html(newhtml_place);
                    }
                }
                st = 2371; //99
                stt = document.getElementById(uval).value;
                xmlhttp.open("GET", "ajax/ticket.php?st=" + st + "&table=" + table + "&field=" + field + "&val=" + val + "&ufield=" + ufield + "&uval=" + stt + "&fetchplace=" + fetchplace + "&pid=" + pid, true);
                xmlhttp.send();
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
                <?php
                $pid='0';
                echo $obj->ShowMsg();
                if ($input_status == 1) {
                    //for admin view checkin
                    $chkx = $obj->exists_multiple("check_user_price", array("ckeckin_id" => $ticket_id));
                    if ($chkx == 0) {
                        $estp = $obj->SelectAllByVal("product", "name", $sql_new_device . "-" . $sqlpagecheckinrequest[0]->problem, "price_cost");
                        if ($estp == '') {
                            $sqldevice_info = $obj->SelectAllByID_Multiple("checkin_request", array("checkin_id" => $ticket_id));

                            $pp = $obj->SelectAllByVal3("checkin_price", "checkin_id", $sqlpagecheckinrequest[0]->device_id, "checkin_version_id", $sqlpagecheckinrequest[0]->model_id, "checkin_problem_id", $sqlpagecheckinrequest[0]->problem_id, "name");
                        } else {
                            $pp = $estp;
                        }
                    } else {

                        $estp = $obj->SelectAllByVal("check_user_price", "ckeckin_id", $ticket_id, "price");
                        if ($estp == '') {
                            $pp = $obj->SelectAllByVal3("checkin_price", "checkin_id", $sqlpagecheckinrequest[0]->device_id, "checkin_version_id", $sqlpagecheckinrequest[0]->model_id, "checkin_problem_id", $sqlpagecheckinrequest[0]->problem_id, "name");
                        } else {
                            $pp = $estp;
                        }
                    }

                    $sqlcheckinlistdata_info = $obj->SelectAllByID_Multiple("checkin_list", array("checkin_id" => $ticket_id));

                    //@$pid=$obj->SelectAllByVal("product", "name", $sql_new_device . ", " . $sqlpagecheckinrequest[0]->model . " - " . $sqlpagecheckinrequest[0]->problem, "id");
                    //$sql_checkin_customer_info=$obj->SelectAllByID_Multiple("checkin_request",array("checkin_id"=>$ticket_id));

                    $pidd = $obj->SelectAllByVal("product", "name", $sqlpagecheckinrequest[0]->device . ", " . $sqlpagecheckinrequest[0]->model . " - " . $sqlpagecheckinrequest[0]->problem, "id");
                    if ($pidd != '' || $pidd != 0) {
                        $pids = $pidd;
                    } else {
                        $pids = $obj->SelectAllByVal("product", "name", $sqlpagecheckinrequest[0]->device . " , " . $sqlpagecheckinrequest[0]->model . " - " . $sqlpagecheckinrequest[0]->problem, "id");
                    }

                    if (empty($pids)) {
                        $pidds = $obj->SelectAllByVal("product", "name", $sql_new_device . ", " . $sqlpagecheckinrequest[0]->model . " - " . $sqlpagecheckinrequest[0]->problem, "id");
                        if ($pidds != '' || $pidds != 0) {
                            $pid = $pidds;
                        } else {
                            $pid = $obj->SelectAllByVal("product", "name", $sql_new_device . " , " . $sqlpagecheckinrequest[0]->model . " - " . $sqlpagecheckinrequest[0]->problem, "id");
                        }
                    } else {
                        $pid = $pids;
                    }





                    @$cid = $obj->SelectAllByVal2("coustomer", "firstname", $sqlpagecheckinrequest[0]->first_name, "phone", $sqlpagecheckinrequest[0]->phone, "id");

                    //$chkcheckin=$obj->exists_multiple("pos_checkin",array("checkin_id"=>$ticket->checkin_id));
                    $getsales_id = $obj->SelectAllByVal("pos_checkin", "checkin_id", $ticket_id, "invoice_id");
                    //$chkcheckin=$obj->exists_multiple("invoice",array("doc_type"=>3,"checkin_id"=>$ticket_id));
                    //$getsales_id=$obj->SelectAllByVal("invoice","checkin_id",$ticket_id,"invoice_id");
                    $curcheck = $obj->exists_multiple("sales", array("sales_id" => $getsales_id));

                    //for admin view checkin
                } else {
                    //for store view checkin
                    $chkx = $obj->exists_multiple("check_user_price", array("ckeckin_id" => $ticket_id, "store_id" => $input_by));
                    if ($chkx == 0) {
                        //$sqlestp_info=$obj->SelectAllByID_Multiple("checkin_list",array("checkin_id"=>$ticket_id));

                        $estp = $obj->SelectAllByVal2("product", "name", $sql_new_device . "-" . $sqlpagecheckinrequest[0]->problem, "store_id", $input_by, "price_cost");
                        if ($estp == '') {
                            //$sqlcheckinrequest_info=$obj->SelectAllByID_Multiple("checkin_request",array("checkin_id"=>$ticket_id));
                            @$pp = $obj->SelectAllByVal4("checkin_price", "checkin_id", $sqlpagecheckinrequest[0]->device_id, "checkin_version_id", $sqlpagecheckinrequest[0]->model_id, "checkin_problem_id", $sqlpagecheckinrequest[0]->problem_id, "store_id", $input_by, "name");
                        } else {
                            $pp = $estp;
                        }
                    } else {

                        $estp = $obj->SelectAllByVal2("check_user_price", "ckeckin_id", $ticket_id, "store_id", $input_by, "price");
                        if ($estp == '') {
                            //$sqlcheckinrequest_info=$obj->SelectAllByID_Multiple("checkin_request",array("checkin_id"=>$ticket_id));

                            @$pp = $obj->SelectAllByVal4("checkin_price", "checkin_id", $sqlpagecheckinrequest[0]->device_id, "checkin_version_id", $sqlpagecheckinrequest[0]->model_id, "checkin_problem_id", $sqlpagecheckinrequest[0]->problem_id, "store_id", $input_by, "name");
                        } else {
                            $pp = $estp;
                        }
                    }
                    //697619e6d9774d015c2faf11b9a712cd
                    //echo "SELECT id FROM product WHERE name='" . $sqlpagecheckinrequest[0]->device . ", " . $sqlpagecheckinrequest[0]->model . " - " . $sqlpagecheckinrequest[0]->problem . "' AND store_id='" . $input_by . "'";
                    $pidd = $obj->SelectAllByVal2("product", "name", $sqlpagecheckinrequest[0]->device . ", " . $sqlpagecheckinrequest[0]->model . " - " . $sqlpagecheckinrequest[0]->problem, "store_id", $input_by, "id");
                    if ($pidd != '' || $pidd != 0) {
                        $pids = $pidd;
                    } else {
                        $pids = $obj->SelectAllByVal2("product", "name", $sqlpagecheckinrequest[0]->device . " , " . $sqlpagecheckinrequest[0]->model . " - " . $sqlpagecheckinrequest[0]->problem, "store_id", $input_by, "id");
                    }

                    if (empty($pids)) {
                        $pidds = $obj->SelectAllByVal2("product", "name", $sql_new_device . ", " . $sqlpagecheckinrequest[0]->model . " - " . $sqlpagecheckinrequest[0]->problem, "store_id", $input_by, "id");
                        if ($pidds != '' || $pidd != 0) {
                            $pid = $pidds;
                        } else {
                            $pid = $obj->SelectAllByVal2("product", "name", $sql_new_device . " , " . $sqlpagecheckinrequest[0]->model . " - " . $sqlpagecheckinrequest[0]->problem, "store_id", $input_by, "id");
                        }
                    } else {
                        $pid = $pids;
                    }

                    $cid = $obj->SelectAllByVal2("coustomer", "firstname", $sqlpagecheckinrequest[0]->first_name, "phone", $sqlpagecheckinrequest[0]->phone, "id");
                    //$chkcheckin=$obj->exists_multiple("invoice",array("doc_type"=>3,"checkin_id"=>$ticket_id));
                    //$getsales_id=$obj->SelectAllByVal("invoice","checkin_id",$ticket_id,"invoice_id");
                    $getsales_id = $obj->SelectAllByVal("pos_checkin", "checkin_id", $ticket_id, "invoice_id");
                    $curcheck = $obj->exists_multiple("sales", array("sales_id" => $getsales_id));
                    //for store view checkin
                }
                ?>
                <!-- /info notice -->

                <div class="outer">
                    <div class="inner">
                        <div class="page-header"><!-- Page header -->
                            <form>
                                <h5><i class="font-home"></i> Checkin ID : <?php echo $ticket_id; ?>  <label style="margin-left: 30px;">

                                        <select onchange="printnuc(this.value)" name="printopt" id="printopt" class="select select2-offscreen" style="width:230px;" tabindex="-1">
                                            <option value="0">Select A Print Method</option> 
                                            <option value="1">Pos Print</option> 
                                            <option value="2">Barcode Print</option> 
                                            <option value="3">Thermal Print</option> 
                                        </select>
                                        <a href="#" style="display: none;" id="print_method_link"><i class="icon-print"></i>  Print Now</a>
                                    </label>
                                    <script>
                                        function printnuc(getval) {
                                            if (getval == 1)
                                            {
                                                $("#print_method_link").show("slow");
                                                $("#print_method_link").attr("href", "checkin_list.php?action=pdf&invoice=<?php echo $ticket_id; ?>&payment_status=<?php echo checkin_paid($curcheck); ?>");
                                                //window.open("checkin_list.php?action=pdf&invoice=<?php //echo $ticket_id;   ?>&payment_status=<?php //echo checkin_paid($curcheck);   ?>","_blank");
                                                //win.focus();
                                            }
                                            else if (getval == 2)
                                            {
                                                $("#print_method_link").show("slow");
                                                $("#print_method_link").attr("href", "checkin_list.php?actionpos=pdf&invoice=<?php echo $ticket_id; ?>&payment_status=<?php echo checkin_paid($curcheck); ?>");
                                                //$('#printopt option[value=0]').prop('selected', 'selected').change();
                                                //window.open("checkin_list.php?actionpos=pdf&invoice=<?php //echo $ticket_id;   ?>&payment_status=<?php //echo checkin_paid($curcheck);   ?>","_blank");

                                            }
                                            else if (getval == 3)
                                            {
                                                $("#print_method_link").show("slow");
                                                $("#print_method_link").attr("href", "checkin_list.php?actionthermal=pdf&invoice=<?php echo $ticket_id; ?>&payment_status=<?php echo checkin_paid($curcheck); ?>");
                                                //$('#printopt option[value=0]').prop('selected', 'selected').change();
                                                //window.open("checkin_list.php?actionthermal=pdf&invoice=<?php //echo $ticket_id;   ?>&payment_status=<?php //echo checkin_paid($curcheck);   ?>","_blank");

                                            }
                                            //$('#printopt option[value=0]').attr('selected', 'selected');

                                        }
                                    </script>
                                </h5>

                                <ul class="icons">
                                    <li><a href="<?php echo $obj->filename(); ?>" class="hovertip" title="Reload"><i class="font-refresh"></i></a></li>
                                </ul>
                            </form>
                        </div><!-- /page header -->

                        <div class="body">

                            <!-- Middle navigation standard -->
                            <?php //include('include/quicklink.php');      ?>
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
//$sqlpagecheckinlist_info=$obj->SelectAllByID_Multiple("checkin_list", array("checkin_id"=>$ticket_id));
                                                            echo $sql_new_device;
                                                            $device = $sql_new_device;
                                                            ?>  </label>
                                                    </div>

                                                    <div class="span12">
                                                        <label class="span12"> <strong class="span5">Model : </strong>
                                                            <?php
                                                            echo $sqlpagecheckinrequest[0]->model;
                                                            $version = $sqlpagecheckinrequest[0]->model;
                                                            ?> </label>
                                                    </div>

                                                    <div class="span12">
                                                        <label class="span12"> <strong class="span5">Color: </strong>
                                                            <?php
                                                            echo $sqlpagecheckinrequest[0]->color;
                                                            ?>
                                                        </label>
                                                    </div>

                                                    <div class="span12">
                                                        <label class="span12"> <strong class="span5">Network : </strong>
                                                            <?php
                                                            echo $sqlpagecheckinrequest[0]->network;
                                                            $device_detail=$sql_new_device.",".$sqlpagecheckinrequest[0]->model.",".$sqlpagecheckinrequest[0]->color.",".$sqlpagecheckinrequest[0]->network;
                                                            ?> </label>
                                                    </div>

                                                    <div class="span12">
                                                        <label class="span12"> <strong class="span5">Problem: </strong>
                                                            <?php
                                                            echo $sqlpagecheckinrequest[0]->problem;
                                                            $problem = $sqlpagecheckinrequest[0]->problem;
                                                            ?>
                                                        </label>
                                                    </div>

                                                    <div class="span12">
                                                        <label class="span12"> <strong class="span5">Est. Price: </strong>
                                                            <?php 
                                                            $paid_amount=0;
                                                            ?>
                                                            <?php if ($curcheck == 0) { 
                                                                
                                                                ?>
                                                                <a class="btn btn-info" href="pos.php?newsales=1&amp;pid=<?php echo $pid; ?>&amp;price=<?php echo number_format($pp, 2); ?>&amp;checkin_id=<?php echo $ticket_id; ?>&AMP;cid=<?php echo $cid; ?>">$<?php
                                                                    if ($pp == '' || $pp == 0) {
                                                                        echo 0;
                                                                    } else {
                                                                        echo number_format($pp, 2);
                                                                    }
                                                                    ?> Send To Pos</a>
                                                            <?php } else { ?>
                                                                <span class="label label-info" href="pos.php?newsales=1&amp;pid=<?php echo $pid; ?>&amp;price=<?php echo number_format($pp, 2); ?>&amp;checkin_id=<?php echo $ticket_id; ?>&AMP;cid=<?php echo $cid; ?>">$<?php
                                                                    if ($pp == '' || $pp == 0) {
                                                                        echo 0;
                                                                    } else {
                                                                        echo number_format($pp, 2);
                                                                        $paid_amount=$pp;
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
                                                        <label class="btn btn-warning span10" id="Diagnostic" onDblClick="TicketWorkUpdate('checkin_request_ticket', 'checkin_id', '<?php echo $ticket_id; ?>', 'diagnostic', 'Diagnostic')">
                                                            1. Diagnostic:
                                                            <?php
                                                            $tc = $obj->SelectAllByVal("checkin_request_ticket", "checkin_id", $ticket_id, "diagnostic");
                                                            if ($tc == 1) {
                                                                echo "<label>Yes</label>";
                                                            } else {
                                                                echo "<label>No</label>";
                                                            }
                                                            ?>
                                                        </label>
                                                    </div>

                                                    <!--<div class="clearfix"></div>
                                                    <div class="span12">
                                                        <label class="btn btn-success span10"> 2. Work Approved: <?php // echo $ops->TicketWorkAjax("checkin_request_ticket", "checkin_id", $ticket_id, "work_approved", "work_approved");                                              ?>  </label>
                                                    </div>-->


                                                    <div class="clearfix"></div>
                                                    <div class="span12">
                                                        <label class="btn btn-success span10" id="Complete" onDblClick="TicketWorkUpdate('checkin_request', 'checkin_id', '<?php echo $ticket_id; ?>', 'status', 'Complete')">

                                                            2. Status Complete:
                                                            <?php
                                                            $tc = $obj->SelectAllByVal("checkin_request", "checkin_id", $ticket_id, "status");
                                                            if ($tc == 1) {
                                                                echo "<label>Yes</label>";
                                                            } else {
                                                                echo "<label>No</label>";
                                                            }
                                                            ?>

                                                        </label>
                                                    </div>


                                                    <div class="clearfix"></div>

                                                    <?php
                                                    $prn = $device . ", " . $version . " - " . $problem;
                                                    $pid = $obj->SelectAllByVal("product", "name", $prn, "id");
                                                    ?>

                                                    <div class="span12">
                                                        <label class="btn btn-info span10" id="Warranty" onDblClick="Warrentys('checkin_request', 'checkin_id', '<?php echo $ticket_id; ?>', 'warrenty', 'Warranty', '<?php echo $pid; ?>')">
                                                            3. Warranty Length:
                                                            <?php
                                                            $tc = $obj->SelectAllByVal("checkin_request", "checkin_id", $ticket_id, "warrenty");
                                                            if (!empty($tc)) {
                                                                echo "<label>" . $tc . " Days</label>";
                                                            } else {
                                                                $warrentys = $obj->SelectAllByVal("product", "id", $pid, "warranty");


                                                                $war = $obj->SelectAllByVal("warrenty", "warrenty_id", $ticket_id, "warrenty");
                                                                $wardate = $obj->SelectAllByVal("warrenty", "warrenty_id", $ticket_id, "date");
                                                                if (empty($war)) {
                                                                    if ($warrentys == '') {
                                                                        $warrenty = 0;
                                                                    } else {
                                                                        $warrenty = $warrentys;
                                                                    }
                                                                } else {
                                                                    $daysgone2 = $obj->daysgone($wardate, date('Y-m-d'));
                                                                    $warrenty = $war - $daysgone2;
                                                                }

                                                                echo "<label>" . $warrenty . " Days Remain</label>";
                                                            }
                                                            ?>
                                                        </label>
                                                    </div>
                                                    <?php
                                                    $sqlchklcd = $obj->SelectAllByVal("checkin_request_ticket", "checkin_id", $ticket_id, "lcdstatus");
                                                    if ($sqlchklcd != 0) {
                                                        ?>
                                                        <div class="clearfix"></div>
                                                        <div class="span12" style="padding-bottom:4px;">
                                                            <label class="btn btn-success span10"> 4. LCD Status:
                                                                <?php echo $ops->LcdWorkAjax("checkin_request_ticket", "checkin_id", $ticket_id, "lcdstatus", "lcdstatus"); ?>
                                                            </label>
                                                        </div>
                                                    <?php } else { ?> <br> <?php } ?>

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
                                                            &nbsp; <?php echo $sqlpagecheckinrequest[0]->first_name; ?>
                                                        </label>
                                                    </div>

                                                    <div class="clearfix"></div>
                                                    <div class="span12">
                                                        <label class="span12"> <strong class="span5">Last Name :  </strong>
                                                            <?php echo $sqlpagecheckinrequest[0]->last_name; ?>
                                                        </label>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                    <div class="span12">
                                                        <label class="span12"> <strong class="span5">Email :  </strong>
                                                            <?php echo $sqlpagecheckinrequest[0]->email; ?>
                                                        </label>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                    <div class="span12">
                                                        <label class="span12"> <strong class="span5">Phone :  </strong>
                                                            <?php echo $sqlpagecheckinrequest[0]->phone; ?>
                                                        </label>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                    <div class="span12">
                                                        <label class="span12"> <strong class="span5">Created By : </strong>
                                                            <?php echo $sqlpagecheckinrequest[0]->input_by; ?>
                                                        </label>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                    <div class="span12">
                                                        <label class="span12"> <strong class="span5">Checkin Created : </strong>
                                                            <?php echo $sqlpagecheckinrequest[0]->date; ?>
                                                        </label>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                    <div class="span12">
                                                        <a  data-toggle="modal" href="#signature" class="btn btn-primary "><i class="font-credit-card"></i> Capture Signature </a>
                                                        <?php $terms = $sqlpagecheckinrequest[0]->signature; ?>
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

                                                            <div class="clear" style="margin-bottom:30px;"></div>
                                                        </div>

                                                        <div class="span12" style="margin-left:-10px;">
                                                            <label class="checkbox span12"> <strong>Tech Notes :</strong>
                                                                <?php echo $ops->common_edit('checkin_request_ticket', 'checkin_id', $ticket_id, 'tech_notes', 'tech_notes', 'id', "Tech Notes"); ?>
                                                            </label>
                                                            <div class="clear" style="margin-bottom:30px;"></div>
                                                        </div>

                                                        <div class="span12" style="margin-left:-10px;">
                                                            <label class="checkbox span12"> <strong>How did he/she hear about us ? :</strong>
                                                                <?php echo $ops->common_edit('checkin_request_ticket', 'checkin_id', $ticket_id, 'hdyhau', 'hdyhau', 'id', "How did he/she hear about us ?"); ?>
                                                            </label>
                                                            <div class="clear" style="margin-bottom:30px;"></div>
                                                        </div>

                                                        <div class="span12" style="margin-left:-10px;">
                                                            <label class="checkbox span12"> <strong>Items Dropped Off ? :</strong>
                                                                <?php echo $ops->common_edit('checkin_request_ticket', 'checkin_id', $ticket_id, 'isdropoff', 'isdropoff', 'id', "Please Type Yes or No"); ?>
                                                            </label>
                                                            <div class="clear" style="margin-bottom:30px;"></div>
                                                        </div>

                                                        <div class="span12" style="margin-left:-10px;">
                                                            <label class="checkbox span6 pull-left">
                                                                <strong>Start Time : </strong>
                                                                <?php echo $ops->common_edit('checkin_request_ticket', 'checkin_id', $ticket_id, 'start_time', 'start_time', 'id', "Start Time"); ?>
                                                            </label>
                                                            <label class="checkbox span6"> <strong>End Time :</strong>
                                                                <?php echo $ops->common_edit('checkin_request_ticket', 'checkin_id', $ticket_id, 'end_time', 'end_time', 'id', "End Time"); ?>
                                                            </label>
                                                            <div class="clear" style="margin-bottom:30px;"></div>
                                                        </div>

                                                        <div class="span8" id="all_selected_custom">
                                                            <div class="clear block"></div>
                                                            <?php
                                                            $sqlticussel = $ops->FlyQuery("select id,fid,(SELECT `name` from ticket_custom_field WHERE ticket_custom_field.id=ticket_custom_selection.fid) AS `name` from ticket_custom_selection WHERE ticket_id='" . $ticket_id . "'");
//$obj->SelectAllByID_Multiple("ticket_custom_selection", array("ticket_id" => $ticket_id));
                                                            if (!empty($sqlticussel))
                                                                foreach ($sqlticussel as $sel):
                                                                    ?>
                                                                    <span class="span4">
                                                                        <label class="checkbox" onClick="custom_field_select_delete(<?php echo $sel->id; ?>,<?php echo $ticket_id; ?>,<?php echo $fields->id; ?>, 'all_selected_custom', 'lastnewsscroll')"><div id="uniform-undefined" class="checker">
                                                                                <span class="checked"><input style="opacity: 0;" name="<?php echo $sel->id; ?>" id="<?php echo $sel->id; ?>" class="style" type="checkbox" value="<?php echo $sel->id; ?>" checked></span>
                                                                            </div>
                                                                            <?php echo $sel->name; ?>
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
                                        $getSign = $obj->SelectAllByVal("signatures", "checkin_id", $ticket_id, "signature");
                                        $_SESSION['getSign'] = $getSign;
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
                                                        <textarea class="span12" rows="12" cols="100" id="showtextarea" readonly style="resize: none;"><?php echo $terms; ?></textarea>
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
                                                if ($getSign != '') {
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
                                                        $_SESSION['terms'] = $terms;
                                                        ?>
                                                    </textarea>
                                                </div>

                                                <div class="control-group">
                                                    <label class="span4">Customer Signature: </label>
                                                </div>
                                                <div class="control-group" id="signature-body" style="border:#000 1px">
                                                </div>

                                                <div class="control-group" id="signature-body">
                                                    Customer Name: <?php echo $sqlpagecheckinrequest[0]->first_name . ' ' . $sqlpagecheckinrequest[0]->last_name; ?>
                                                </div>

                                            </div>

                                        </div>

                                        <!--for print-->
                                        <iframe name="print_frame" id="print_frame" width="0" height="0" frameborder="0" src="about:blank">
                                        </iframe>
                                        <!--for print-->

                                        <!-- /dialog signature -->

                                        <?php
                                        $chkcheckinid = $obj->FlyQuery("SELECT `chid` FROM `checkin_cron` WHERE `chid`='" . $sqlpagecheckinrequest[0]->id . "'", 1);
                                        if ($chkcheckinid == 0) {
                                            $obj->FlyPrepare("INSERT INTO `checkin_cron` SET `chid`='" . $sqlpagecheckinrequest[0]->id . "',`checkin_id`='" . $ticket_id . "', `detail`='" . $device_detail . "', `problem`='" . $problem . "', `checkin_price`='" .$pp. "', `paid`='" . $paid_amount . "', `date`='" . $sqlpagecheckinrequest[0]->date . "', `input_by`='" . $sqlpagecheckinrequest[0]->creator . "', `invoice_id`='" . $getsales_id . "', `pid`='" . $pid . "', `cid`='" . $cid . "'");
                                            //echo $i . "-" . $checkin->checkin_id . "-" . $checkin->input_by . "<br>";
                                        } else {
                                            $obj->FlyPrepare("UPDATE `checkin_cron` SET `checkin_id`='" . $ticket_id . "', `detail`='" . $device_detail . "', `problem`='" . $problem . "', `checkin_price`='" . $pp . "', `paid`='" . $paid_amount . "', `date`='" . $sqlpagecheckinrequest[0]->date . "', `input_by`='" . $sqlpagecheckinrequest[0]->creator . "', `invoice_id`='" . $getsales_id . "', `pid`='" . $pid . "', `cid`='" . $cid . "' WHERE `chid`='" . $sqlpagecheckinrequest[0]->id . "'");
                                            //echo $i."-".$checkin->checkin_id."<br>";
                                        }

                                        include('include/footer.php');
                                        ?>
                                        <!-- Right sidebar -->
                                        <?php //include('include/sidebar_right.php');      ?>
                                        <!-- /right sidebar -->

                                        </div>
                                        <!-- /main wrapper -->

                                        </body>
                                        </html>
