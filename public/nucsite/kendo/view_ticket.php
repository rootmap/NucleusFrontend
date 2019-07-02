<?php
include('class/auth.php');

function checkin_paid($st) {
    if ($st == 0) {
        return "Unpaid";
    } else {
        return "Paid";
    }
}

if (isset($_POST['partial'])) {
    extract($_POST);
    if ($obj->update("ticket", array("ticket_id" => $ticket_id, "partial_amount" => $amount)) == 1) {
        $obj->Success("Ticket Partial Payment Sucessfully Saved", $obj->filename() . "?ticket_id=" . $ticket_id);
    } else {
        $obj->Error("Failed, Ticket Partial Payment Not Saved", $obj->filename() . "?ticket_id=" . $ticket_id);
    }
}
include('class/function.php');
$ops = new pos();
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
        <script type="text/javascript">
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
        </script>
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
                echo $obj->ShowMsg();
//$chkcheckin=$obj->exists_multiple("invoice",array("doc_type"=>3,"checkin_id"=>$ticket_id));
//$getsales_id=$obj->SelectAllByVal("invoice","checkin_id",$ticket_id,"invoice_id");
                $getsales_id = $obj->SelectAllByVal("pos_checkin", "checkin_id", $ticket_id, "invoice_id");

                $curcheck = $obj->exists_multiple("sales", array("sales_id" => $getsales_id));

                $invoice_status = $obj->exists_multiple("invoice", array("invoice_id" => $getsales_id, "status" => 3));

                $sqlpagecheckinrequest = $ops->FlyQuery("select signature as signature from setting_report WHERE store_id='" . $input_by . "'");
                $sqlpagecheckinrequest2 = $ops->FlyQuery("select signature as signature from signatures WHERE checkin_id='" . $ticket_id . "'");
                if ($invoice_status == 1) {
                    $pfff = "Partial";
                } else {
                    $pfff = checkin_paid($curcheck);
                }
                ?>
                <!-- /info notice -->

                <div class="outer">
                    <div class="inner">
                        <div class="page-header"><!-- Page header -->
                            <h5><i class="font-tags"></i>Ticket ID : <?php echo $ticket_id; ?> 
                                <label style="margin-left: 30px;"><i class="icon-print"></i> 
                                    <select onchange="printnuc(this.value)" name="printopt" id="printopt" class="select select2-offscreen" style="width:230px;" tabindex="-1">
                                        <option value="0">Select A Print Method</option> 
                                        <option value="1">Pos Print</option> 
                                        <option value="2">Barcode Print</option> 
                                    </select> </label>
                                <script>
                                    function printnuc(getval) {
                                        if (getval == 1)
                                        {
                                            window.open("ticket_list.php?action=pdf&invoice=<?php echo $ticket_id; ?>&payment_status=<?php echo $pfff; ?>", "_blank");
                                            win.focus();
                                        }
                                        else if (getval == 2)
                                        {
                                            $('#printopt option[value=0]').prop('selected', 'selected').change();
                                            window.open("ticket_list.php?actionpos=pdf&invoice=<?php echo $ticket_id; ?>&payment_status=<?php echo $pfff; ?>", "_blank");

                                        }
                                        //$('#printopt option[value=0]').attr('selected', 'selected');

                                    }
                                </script>
                            </h5>
                            <ul class="icons">
                                <li><a href="<?php echo $obj->filename(); ?>" class="hovertip" title="Reload"><i class="font-refresh"></i></a></li>
                            </ul>
                        </div><!-- /page header -->

                        <div class="body">

                            <!-- Middle navigation standard -->
                            <?php //include('include/quicklink.php');   ?>
                            <!-- /middle navigation standard -->

                            <!-- Content container -->
                            <div class="container">




                                <!-- Content Start from here customized -->


                                <!--<form class="form-horizontal" method="get" name="invoice" action="create_invoice.php">-->
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
                                                    <?php echo $ops->TicketStatusAjax("ticket", "ticket_id", $ticket_id, "status", "status"); ?>  </label>
                                            </div>



                                            <div class="span12">
                                                <label class="span12"> <strong class="span5">Problem type: </strong>
                                                    <?php echo $ops->TicketProblemAjax("ticket", "ticket_id", $ticket_id, "problem_type", "problem_type"); ?>
                                                </label>
                                            </div>
                                            <div class="span12">
                                                <label class="span12"> <strong class="span5">Created By: </strong> <?php echo $obj->SelectAllByVal("store", "id", $obj->SelectAllByVal("ticket", "ticket_id", $ticket_id, "access_id"), "name"); ?> </label>
                                            </div>
                                            <div class="span12">
                                                <label class="span12"> <strong class="span5">Created: </strong> <?php echo $obj->SelectAllByVal("ticket_list", "ticket_id", $ticket_id, "date"); ?> </label>
                                            </div>

                                            <div class="span12">
                                                <label class="span12"> <strong class="span5">Pre-Approved: </strong> Approved </label>
                                            </div>

                                            <div class="span12">
                                                <label class="span12"> <strong class="span5">Price: </strong> $<?php echo $obj->SelectAllByVal("ticket_list", "ticket_id", $ticket_id, "retail_cost"); ?> </label>
                                                <?php
                                                $product_name = $obj->SelectAllByVal("ticket_list", "ticket_id", $ticket_id, "title") . " - " . $ticket_id;
                                                $chkx = $obj->exists_multiple("product", array("name" => $product_name));
                                                if ($chkx != 0) {
                                                    $pid = $obj->SelectAllByVal("product", "name", $product_name, "id");
                                                    $price = $obj->SelectAllByVal("product", "name", $product_name, "price_retail");
                                                } else {
                                                    $pid = 0;
                                                    $price = 0;
                                                }
                                                ?>
                                                <?php $cidd = $obj->SelectAllByVal("ticket_list", "ticket_id", $ticket_id, "cid"); ?>
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
                                                    1. Diagnostic: <?php echo $ops->TicketWorkAjax("ticket", "ticket_id", $ticket_id, "diagnostic", "diagnostic"); ?></label>
                                            </div>


                                            <div class="clearfix"></div>
                                            <div class="span12">
                                                <label class="btn btn-danger span10"> 2. Work Completed: <?php echo $ops->TicketWorkAjax("ticket", "ticket_id", $ticket_id, "work_completed", "work_completed"); ?> </label>
                                            </div>
                                            <div class="clearfix"></div>

                                            <div class="clearfix"></div>
                                            <div class="span12">
                                                <label class="btn btn-primary span10"> 3. Invoiced: <?php echo $ops->TicketWorkAjax("ticket", "ticket_id", $ticket_id, "invoice", "invoice"); ?>  </label>
                                            </div>
                                            <div class="clearfix"></div>

                                            <div class="clearfix"></div>
                                            <div class="span12">
                                                <?php
                                                $prn = $obj->SelectAllByVal("ticket", "ticket_id", $ticket_id, "title") . " - " . $ticket_id;
                                                $pid = $obj->SelectAllByVal("product", "name", $prn, "id");
                                                ?>
                                                <label class="btn btn-primary span10"> 4. Warrenty Template: <?php echo $ops->WarrentyWorkAjax("ticket", "ticket_id", $ticket_id, "warrenty", "warrenty", $pid); ?>  </label>
                                            </div>
                                            <div class="clearfix"></div>

                                            <div class="clearfix"></div>
                                            <div class="span12">
                                                <a class="btn btn-success span11" href="parts.php?fromticket=<?php echo $_GET['ticket_id']; ?>"> Need to order a part for this repair? Click here  </a>
                                            </div>

                                            <br>
                                            <br>
                                        </div>
                                        <!-- /general form elements -->
                                        <?php $pay = $obj->SelectAllByVal("ticket", "ticket_id", $ticket_id, "payment"); ?>
                                        <!-- General form elements -->
                                        <div class="well row-fluid span4" <?php if ($pay == 1) { ?>style="background:url(images/paid.png) no-repeat center;"<?php } ?>>
                                            <div class="navbar">
                                                <div class="navbar-inner">
                                                    <h5><i class="font-user"></i> Customer </h5>
                                                </div>
                                            </div>
                                            <?php $cid = $obj->SelectAllByVal("ticket", "ticket_id", $ticket_id, "cid"); ?>
                                            <div class="span12" style="margin-top:7px; clear:both;">
                                                <label class="span12"> <strong class="span5">Customer: </strong>
                                                    <?php echo $ops->SingleFieldEdit("coustomer", "id", $cid, "firstname", "firstname", "Customer Name"); ?>
                                                </label>
                                            </div>

                                            <div class="clearfix"></div>
                                            <div class="span12">
                                                <label class="span12"> <strong class="span5">Company :  </strong>
                                                    <?php echo $ops->SingleFieldEdit("coustomer", "id", $cid, "businessname", "businessname", "Customer Name"); ?>
                                                </label>
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="span12">
                                                <label class="span12"> <strong class="span5">Email:  </strong>
                                                    <?php echo $ops->SingleFieldEdit("coustomer", "id", $cid, "email", "email", "Email"); ?>
                                                </label>
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="span12">
                                                <label class="span12"> <strong class="span5">Invoice Email:  </strong>
                                                    <?php echo $ops->SingleFieldEdit("coustomer", "id", $cid, "invoice_email", "invoice_email", "Invoice Email"); ?>
                                                </label>
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="span12">
                                                <label class="span12"> <strong class="span5">Phone: </strong>
                                                    <?php echo $ops->SingleFieldEdit("coustomer", "id", $cid, "phone", "phone", "Phone Number"); ?>
                                                </label>
                                            </div>

                                            <div class="clearfix"></div>
                                            <div class="span12">
                                                <div class="span12"> <strong class="span5">Payment: </strong>

                                                    <?php
                                                    if ($curcheck == 0) {
                                                        ?>
                                                        <a href="pos.php?newsales=1&amp;pid=<?php echo $pid; ?>&amp;price=<?php echo $price; ?>&AMP;cid=<?php echo $cid; ?>&amp;checkin_id=<?php echo $ticket_id; ?>" class="btn btn-success"><i class="font-money"></i> <?php echo @number_format($price, 2); ?> To POS</a>
                                                        <?php
                                                    } else {

                                                        $expaidamountquery = $obj->SelectAllByID_Multiple("invoice_payment", array("invoice_id" => $getsales_id));
                                                        $expaid = 0;
                                                        if (!empty($expaidamountquery))
                                                            foreach ($expaidamountquery as $paidamount):
                                                                $expaid+=$paidamount->amount;
                                                            endforeach;
                                                        if ($expaid < $price && $invoice_status == 1) {
                                                            $duepp = $price - $expaid;
                                                            ?>
                                                            <a href="pos_make_new_cart.php?cart_id=<?php echo $getsales_id; ?>" class="btn btn-warning">$<?php echo $duepp; ?> Send To POS</a>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <span class="label label-info">$<?php
                                                                if ($price == '' || $price == 0) {
                                                                    echo 0;
                                                                } else {
                                                                    echo number_format($price, 2);
                                                                }
                                                                ?> Paid</span>
                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                                    <?php //echo $ops->TicketpaymentAjax("ticket","ticket_id",$ticket_id,"payment","payment");  ?>  </div>
                                            </div>                                                <div class="clearfix"></div>
                                            <div class="clearfix"></div>
                                            <div class="span12">
                                                <a  data-toggle="modal" href="#signature" class="btn btn-primary "><i class="font-credit-card"></i> Capture Signature </a>
                                                <?php
                                                $terms = $sqlpagecheckinrequest[0]->signature;

                                                if (!$sqlpagecheckinrequest[0]->signature) {
                                                    $terms = $sqlpagecheckinrequest[0]->signature;
                                                } else {
                                                    $terms = $sqlpagecheckinrequest2[0]->signature;
                                                }
                                                ?>
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
                                                        <?php echo $ops->common_edit('ticket', 'ticket_id', $ticket_id, 'type_color', 'type_color', 'id', "Type And Color"); ?>
                                                    </label>
                                                    <label class="checkbox span3"> <strong>Password:</strong>
                                                        <?php echo $ops->common_edit('ticket', 'ticket_id', $ticket_id, 'password', 'password', 'id', "Password"); ?>
                                                    </label>
                                                    <label class="checkbox span3"> <strong>IMEI:</strong>
                                                        <?php echo $ops->common_edit('ticket', 'ticket_id', $ticket_id, 'imei', 'imei', 'id', "IMEI Code"); ?>
                                                    </label>
                                                    <label class="checkbox span3"> <strong>Tested Before By :</strong>
                                                        <?php echo $ops->common_edit('ticket', 'ticket_id', $ticket_id, 'tested_before', 'tested_before', 'id', "Tested By"); ?>
                                                    </label>
                                                </div>
                                                <div class="span12" style="margin-left:-10px;">
                                                    <label class="checkbox span3 pull-left">
                                                        <strong>Carrier : </strong>
                                                        <?php echo $ops->common_edit('ticket', 'ticket_id', $ticket_id, 'carrier', 'carrier', 'id', "Carrier"); ?>
                                                    </label>
                                                    <label class="checkbox span3 pull-left">
                                                        <strong>Tested After By : </strong>
                                                        <?php echo $ops->common_edit('ticket', 'ticket_id', $ticket_id, 'tested_after', 'tested_after', 'id', "Tested After By"); ?>
                                                    </label>
                                                    <label class="checkbox span5"> <strong>Tech Notes :</strong>
                                                        <?php echo $ops->common_edit('ticket', 'ticket_id', $ticket_id, 'tech_notes', 'tech_notes', 'id', "Tech Notes"); ?>
                                                    </label>
                                                    <label class="checkbox span12" style="margin-left: 0px;"> <strong>How did you hear about us ?</strong>
                                                        <?php echo $ops->common_edit('ticket', 'ticket_id', $ticket_id, 'hdyhau', 'hdyhau', 'id', "How did you hear about us ?"); ?>
                                                    </label>
                                                    <label class="checkbox span12" style="margin-left: 0px;"> <strong>Items Dropped Off ?</strong>
                                                        <?php echo $ops->common_edit('ticket','ticket_id',$ticket_id,'isdropoff','isdropoff','id',"Please Type Yes or No"); ?>
                                                    </label>
                                                    <div class="clear" style="margin-bottom:30px;"></div>
                                                </div>
                                                <div class="span3" id="lastnewsscroll" style="height:220px; margin-right:20px; margin-left:-10px; margin-top:20px; overflow:scroll;">
                                                    <?php
                                                    $sqlshowcustomfields = $obj->SelectAll("ticket_custom_field");
                                                    if (!empty($sqlshowcustomfields))
                                                        foreach ($sqlshowcustomfields as $fields):
                                                            $exfields = $obj->exists_multiple("ticket_custom_selection", array("fid" => $fields->id, "ticket_id" => $ticket_id));
                                                            if ($exfields == 0) {
                                                                ?>
                                                                <label onClick="custom_field_select(<?php echo $ticket_id; ?>,<?php echo $fields->id; ?>, 'all_selected_custom', 'lastnewsscroll')" class="checkbox"><div id="uniform-undefined" class="checker">
                                                                        <span><input style="opacity: 0;" name="custom[]" class="style" type="checkbox" value="<?php echo $fields->id; ?>"></span>
                                                                    </div> <?php echo $fields->name; ?>
                                                                </label>
                                                                <?php
                                                            }
                                                        endforeach;
                                                    ?>
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
                                            <!-- Dialog 1 content -->
                                            <div id="myModal1" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    <h5 id="myModalLabel">Assets</h5>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Here you can create new assets, view existing assets, and attach them to the ticket.</p>

                                                    <div class="row-fluid">

                                                        <b id="msg_pro"></b>
                                                        <div class="control-group">
                                                            <label class="control-label">Existing Asset</label>
                                                            <div class="controls">
                                                                <select id="allexasset" onChange="ticket_asset(this.value, '<?php echo $ticket_id; ?>')" name="select2" data-placeholder="Choose a Existing Asset..." class="select-search select2-offscreen" tabindex="-1">
                                                                    <option value=""></option>
                                                                    <?php
                                                                    $sqlassettype = $obj->SelectAll("asset");
                                                                    if (!empty($sqlassettype))
                                                                        foreach ($sqlassettype as $assettype):
                                                                            $exx = $obj->exists_multiple("ticket_asset", array("ticket_id" => $ticket_id, "asset_id" => $assettype->id));
                                                                            if ($exx == 0) {
                                                                                ?>
                                                                                <option value="<?php echo $assettype->id; ?>">
                                                                                    <?php echo $assettype->name; ?>
                                                                                </option>
                                                                                <?php
                                                                            }
                                                                        endforeach;
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="control-group" id="asset_ticket_list">
                                                            <?php
                                                            $sqlassetlist = $obj->SelectAllByID_Multiple("ticket_asset", array("ticket_id" => $ticket_id));
                                                            if (!empty($sqlassetlist))
                                                                foreach ($sqlassetlist as $assetlist):
                                                                    ?>
                                                                    <label class="label"><?php echo $obj->SelectAllByVal("asset", "id", $assetlist->asset_id, "name"); ?>
                                                                        <button onClick="delete_ticket_asset('<?php echo $assetlist->id; ?>', '<?php echo $ticket_id; ?>')" style="border:none; background:none;" type="button">
                                                                            <i class="icon-remove"></i>
                                                                        </button>
                                                                    </label>
                                                                <?php endforeach; ?>
                                                        </div>


                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <a data-toggle="modal" href="#myModal2" class="btn btn-info"><i class="icon-ok"></i> Create Asset</a>
                                                    <button type="button" class="btn btn-danger"  data-dismiss="modal"><i class="icon-remove"></i> Back To Ticket</button>
                                                </div>
                                            </div>
                                            <!-- /dialog 1 content -->

                                            <!-- Dialog 2 content -->
                                            <div id="myModal2" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    <h5 id="myModalLabel">Create Assets</h5>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Here you can create new assets, view existing assets, and attach them to the ticket.</p>
                                                    <b id="msg_pros"></b>
                                                    <div class="row-fluid">

                                                        <b id="create_asset">
                                                            <div class="control-group">
                                                                <label class="control-label">Asset Type</label>
                                                                <div class="controls">
                                                                    <select id="type_id" onChange="asset_type(this.value)" name="select2" class="style" >
                                                                        <?php
                                                                        $sqlassettype = $obj->SelectAll("asset_type");
                                                                        if (!empty($sqlassettype))
                                                                            foreach ($sqlassettype as $assettype):
                                                                                ?>
                                                                                <option value="<?php echo $assettype->id; ?>">
                                                                                    <?php echo $assettype->name; ?>
                                                                                </option>
                                                                                <?php
                                                                            endforeach;
                                                                        ?>
                                                                        <option value="0">Add New</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="control-group">
                                                                <label class="control-label">Asset Name:</label>
                                                                <div class="controls"><input id="asset_name" type="text" name="regular" class="span12" /></div>
                                                            </div>

                                                            <div class="control-group">
                                                                <label class="control-label">Serial Number:</label>
                                                                <div class="controls"><input id="serial_number" type="text" name="regular" class="span12" /></div>
                                                            </div>

                                                            <div class="control-group">
                                                                <label class="control-label">Make:</label>
                                                                <div class="controls"><input id="make" type="text" name="regular" class="span12" /></div>
                                                            </div>

                                                            <div class="control-group">
                                                                <label class="control-label">Model:</label>
                                                                <div class="controls"><input id="model" type="text" name="regular" class="span12" /></div>
                                                            </div>

                                                            <div class="control-group">
                                                                <label class="control-label">Service Tag:</label>
                                                                <div class="controls"><input id="service_tag" type="text" name="regular" class="span12" /></div>
                                                            </div>
                                                        </b>
                                                        <div class="control-group" id="asset_list">
                                                            <?php
                                                            $sqlasset = $obj->SelectAll("asset");
                                                            if (!empty($sqlasset))
                                                                foreach ($sqlasset as $asset):
                                                                    $ex = $obj->exists_multiple("ticket_asset", array("ticket_id" => $ticket_id, "asset_id" => $asset->id));
                                                                    if ($ex == 0) {
                                                                        ?>
                                                                        <div class="label" style="margin-top:5px;"><?php echo $asset->name; ?>
                                                                            <button onClick="edit_asset('<?php echo $asset->id; ?>')" style="border:none; background:none;" type="button">
                                                                                <i class="icon-edit"></i>
                                                                            </button>
                                                                            <button onClick="delete_asset('<?php echo $asset->id; ?>')" style="border:none; background:none;" type="button">
                                                                                <i class="icon-remove"></i>
                                                                            </button>
                                                                        </div>
                                                                        <?php
                                                                    }
                                                                endforeach;
                                                            ?>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn" type="button" data-dismiss="modal">Close</button>
                                                    <button type="button" onClick="save_asset()" class="btn btn-primary">Save Asset</button>
                                                </div>
                                            </div>
                                            <!-- /dialog 2 content -->

                                            <div class="navbar">
                                                <div class="navbar-inner" style="background: none; border-bottom: 1px #CCC dotted;">
                                                    <h5><i class="icon-screenshot"></i> Asset For This Ticket </h5>
                                                    <a data-toggle="modal" href="#myModal1" class="btn btn-primary" style="float:right;"><i class="icon-retweet"></i> Asset Edit</a>
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
                                                        $sqlasset = $obj->SelectAllByID_Multiple("ticket_asset", array("ticket_id" => $ticket_id));
                                                        $i = 1;
                                                        if (!empty($sqlasset))
                                                            foreach ($sqlasset as $asset):
                                                                ?>
                                                                <tr>
                                                                    <td><?php echo $i; ?></td>

                                                                    <td><?php echo $obj->SelectAllByVal("asset", "id", $asset->asset_id, "name"); ?></td>
                                                                    <td><?php echo $obj->SelectAllByVal("coustomer", "id", $cid, "businessname"); ?></td>
                                                                    <td><?php echo $obj->SelectAllByVal("asset", "id", $asset->asset_id, "serial_number"); ?></td>
                                                                    <td><?php
                                                                        $asset_type = $obj->SelectAllByVal("asset", "id", $asset->asset_id, "asset_type_id");
                                                                        echo $obj->SelectAllByVal("asset_type", "id", $asset_type, "name");
                                                                        ?></td>
                                                                    <td>
                                                                        <label><strong>Make : </strong><?php echo $obj->SelectAllByVal("asset", "id", $asset->asset_id, "make"); ?></label>,
                                                                        <label><strong>Model : </strong><?php echo $obj->SelectAllByVal("asset", "id", $asset->asset_id, "model"); ?></label>,
                                                                        <label><strong>Service Tag : </strong><?php echo $obj->SelectAllByVal("asset", "id", $asset->asset_id, "service_tag"); ?></label>
                                                                    </td>
                                                                </tr>
                                                                <?php
                                                                $i++;
                                                            endforeach;
                                                        ?>
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


            <?php //include('include/sidebar_right.php');      ?>
            <!-- /right sidebar -->

        </div>
        <!-- /main wrapper -->

    </body>
</html>
