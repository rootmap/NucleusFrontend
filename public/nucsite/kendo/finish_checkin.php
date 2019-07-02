<?php
include('class/auth.php');
include('class/checkin_class.php');
$obj_checkin = new checkin_class();
$table = "checkin_request_ticket";


if (isset($_GET['newticket'])) {
    $obj_checkin->newcart(@$_SESSION['SESS_CART_CHECKIN']);
    $obj->Success("New Ticket Token Has Been Created Successfully", $obj->filename() . "?cid=" . $_GET['cid']);
}
$cart = $obj_checkin->cart(@$_SESSION['SESS_CART_CHECKIN']);


$chkcheckinprice=$obj->exists_multiple("check_user_price", array("ckeckin_id" => $cart));

if($chkcheckinprice==0)
{
    $problemft = $obj->FlyQuery("SELECT cr.`device_id`,cr.model_id,cr.color_id,cr.network_id,cr.`problem_id` FROM `checkin_request` as cr
WHERE cr.`checkin_id`='" . $cart . "'");
    $obj->Error("Failed, Please Set Reapir Price Again.","checkin6.php?id=".$problemft[0]->device_id."&version=".$problemft[0]->model_id."&color=".$problemft[0]->color_id."&network=".$problemft[0]->network_id."&problem=".$problemft[0]->problem_id."");
}

//$chkdeviceid=$obj->SelectAllByVal("checkin_request","checkin_id",$_GET['cart'],"device_id");
//$chkdeviceproblem=$obj->SelectAllByVal("checkin_request","checkin_id",$_GET['cart'],"problem_id");
if (!isset($_POST['create'])) {
    $problemft = $obj->FlyQuery("SELECT cr.`device_id`,cr.`problem_id`,cp.name FROM `checkin_request` as cr
LEFT JOIN `checkin_problem` as cp ON cp.id=cr.`problem_id`
WHERE cr.`checkin_id`='" . $_GET['cart'] . "'");

    $chkdeviceid = $problemft[0]->device_id;
    $chkdeviceproblem = $problemft[0]->problem_id;
    $deviceproblem = strtolower($problemft[0]->name);

    preg_match("/lcd/s", $deviceproblem, $matches);

    $lcdpattern = 0;
    if (!empty($matches)) {
        $lcdpattern = 1;
    }
}
if (isset($_POST['create'])) {
    //lcdstatus
    extract($_POST);
    $ticket_id = $cart;
    if (isset($_POST['salvage_part'])) {
        $sal_val = 1;
    } else {
        $sal_val = 0;
    }


    /* if($sal_val==1)
      {
      $chkx = $obj->delete("check_user_price", array("ckeckin_id"=>$ticket_id));
      $newpr=0;
      $obj->insert("check_user_price", array("ckeckin_id"=>$ticket_id,"store_id"=>$input_by,"access_id"=>$input_by,"price"=>$newpr,"date"=>date('Y-m-d'),"status"=>1));
      } */

    if (!empty($lcdstatus)) {
        $insert = array("cid" => $cid,
            "checkin_id" => $ticket_id,
            "uid" => $input_by,
            "work_approved" => $work_approved,
            "password" => $password,
            "imei" => $imei,
            "even_been" => $ever_been,
            "tested_before" => $tested_before,
            "tested_after" => $tested_after,
            "tech_notes" => $tech_notes,
            "hdyhau" => $hdyhau,
            "start_time" => $start_time,
            "end_time" => $end_time,
            "lcdstatus" => $lcdstatus,
            "salvage_part" => $sal_val,
            "access_id" => $access_id,
            "date" => date('Y-m-d'),
            "status" => 1);
    } else {
        $insert = array("cid" => $cid,
            "checkin_id" => $ticket_id,
            "uid" => $input_by,
            "lcdstatus" => 0,
            "work_approved" => $work_approved,
            "password" => $password,
            "imei" => $imei,
            "even_been" => $ever_been,
            "tested_before" => $tested_before,
            "tested_after" => $tested_after,
            "tech_notes" => $tech_notes,
            "hdyhau" => $hdyhau,
            "start_time" => $start_time,
            "end_time" => $end_time,
            "salvage_part" => $sal_val,
            "access_id" => $access_id,
            "date" => date('Y-m-d'),
            "status" => 1);
    }

    if ($obj->insert($table, $insert) == 1) {
        $cus = 0;
        $countpos = count($_POST['custom2']);
        if ($countpos != 0) {
            foreach ($_POST['custom2'] as $ff) {
                $cus+=1;
                @$obj->insert("ticket_custom_selection", array("ticket_id" => $ticket_id, "access_id" => $access_id, "fid" => $ff));
            }
        }
        //$obj_checkin->cart(@$_SESSION['SESS_CART_CHECKIN']);
        @$obj->Success("Successfully Saved", "view_checkin.php?ticket_id=" . $ticket_id . "&custom=" . $cus);
    } else {
        $obj->Error("Failed, Fill up required field.", $obj->filename() . "?cid=" . $cid . "&amp;cart=" . $ticket_id);
    }

    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
<?php
include './plugin/plugin.php';
$cms = new CmsRootPlugin();
echo $cms->GeneralCss(array("color", "form", "button"));
?>


        <script src="ajax/ticket_ajax.js"></script>
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
                            <h5><i class="icon-check"></i> Finish CheckIn</h5>
                            <ul class="icons">
                                <li><a href="<?php echo $obj->filename(); ?>?cid=<?php echo $_GET['cid']; ?>" class="hovertip" title="Reload"><i class="font-refresh"></i></a></li>
                            </ul>
                        </div><!-- /page header -->

                        <div class="body">

                            <!-- Middle navigation standard -->
<?php
//include('include/quicklink.php'); 
//id=1&version=2&color=17&network=1&problem=1
?>
                            <!-- /middle navigation standard -->

                            <!-- Content container -->
                            <div class="container">




                                <!-- Content Start from here customized -->

                                <!-- Line chart -->
                                <div class="row-fluid">

                                    <div class="span12">
                                        <div class="semi-block">
                                            <div class="well-white body">
                                                <div class="table-overflow">

                                                    <strong class="span1 label label-success" style="width:90px; padding-left:1px; padding-right:1px; margin-left:0; margin-right:0; display:inline-block;">Device : Step 1</strong> 

                                                    <strong class="span1 label label-success"  style="width:90px; padding-left:1px; padding-right:1px; margin-left:3px; margin-right:0; display:inline-block;">Model : Step 2</strong>
                                                    <strong class="span1 label label-success"  style="width:90px; padding-left:1px; padding-right:1px; margin-left:3px; margin-right:0; display:inline-block;">Color : Step 3</strong>
                                                    <strong class="span1 label label-success"  style="width:98px; padding-left:1px; padding-right:1px; margin-left:3px; margin-right:0; display:inline-block;">Network : Step 4</strong>
                                                    <strong class="span1 label label-success"  style="width:85px; padding-left:1px; padding-right:1px; margin-left:3px; margin-right:0; display:inline-block;">Problem! : 5</strong>
                                                    <strong class="span1 label label-success"  style="width:60px; padding-left:1px; padding-right:1px; margin-left:3px; margin-right:0; display:inline-block;">Price : 6</strong>
                                                    <strong class="span1 label label-success"  style="width:86px; padding-left:1px; padding-right:1px; margin-left:3px; margin-right:0; display:inline-block;">Customer : 7</strong>
                                                    <strong class="span1 label label-success"  style="width:60px; padding-left:1px; padding-right:1px; margin-left:3px; margin-right:5px; display:inline-block;">Info : 8</strong>

                                                    <div  class="progress progress-success value"><div class="bar" data-percentage="8" data-amount-part="8" data-amount-total="8">8/8</div></div>




                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <form class="form-horizontal" method="post" name="invoice" action="">
                                    <fieldset>
                                        <!-- /general form elements -->


                                        <input type="hidden" name="cid" value="<?php echo $_GET['cid']; ?>" />
                                        <input type="hidden" name="cart" value="<?php echo $_GET['cart']; ?>" />           



                                        <div class="row-fluid" style="margin-top:20px;">
                                            <div class="clear"></div>
                                            <div class="span12">

                                                <!-- General form elements -->
                                                <div class="span6">
                                                    <div class="control-group">
                                                        <label class="control-label" style="width: 175px;">Password </label>
                                                        <input type="text" name="password" class="span8" placeholder="Type Ticket Password" />
                                                    </div>

                                                    <div class="control-group">
                                                        <label class="control-label" style="width: 175px;">IMEI</label>
                                                        <input type="text" name="imei" class="span8" placeholder="Put Device IMEI Number" />
                                                    </div>


                                                    <div class="control-group">


                                                        <label class="control-label" style="width: 175px;">Tested Before By</label>
                                                        <input type="text" name="tested_before" class="span8" placeholder="Tested Before Yes,No, Name" />



                                                    </div>


                                                    <div class="control-group">
                                                        <label class="control-label" style="width: 175px;">Tested After By</label>
                                                        <input type="text" name="tested_after" class="span8" placeholder="Tested After By Yes, No, Name" />
                                                    </div>

                                                    <div class="control-group">
                                                        <label class="control-label" style="width: 175px;">Tech Notes</label>
                                                        <textarea name="tech_notes" class="span8" placeholder="Tech Notes"></textarea>
                                                    </div>

                                                    <div class="control-group">
                                                        <label class="control-label" style="width: 175px;">How did you hear about us ?</label>
                                                        <textarea name="hdyhau" class="span8" placeholder="How did you hear about us ?"></textarea>
                                                    </div>

                                                    <div class="control-group">
                                                        <label class="control-label">Start Time</label>
                                                        <input type="text" id="time" name="start_time" placeholder="Start Time" />
                                                    </div>

                                                    <div class="control-group">
                                                        <label class="control-label">End Time</label>
                                                        <input type="text" id="time" name="end_time" placeholder="End Time" />
                                                    </div>

<?php if ($lcdpattern == 1) { ?>

                                                        <div class="control-group">
                                                            <label class="control-label" style="width: 105px;"> LCD Condition </label>
                                                            <label class="radio inline"><input type="radio" name="lcdstatus" value="1" class="style" id="lcdstatus_0"><strong>Good</strong></label>
                                                            <label class="radio inline"><input type="radio" name="lcdstatus" value="2" class="style" id="lcdstatus_1"><strong>Bad</strong></label>
                                                        </div>

<?php } ?>

                                                    <div class="control-group">
                                                        <div class="gap"></div>
                                                        <label class="checkbox"><input value="1" name="salvage_part" class="style" type="checkbox"> Salvage Part</label>
                                                        <div class="gap"></div>
                                                    </div>   

                                                </div>
                                                <!-- /general form elements -->


                                                <!-- General form elements -->
                                                <div class="span6">
                                                    <label class="checkbox"><input  value="1" name="work_approved" class="style" type="checkbox"> Is work approved to proceed?</label>
                                                    <div class="gap"></div>

                                                    <label class="checkbox"><input value="1" name="ever_been" class="style" type="checkbox"> Ever Been Wet</label>
                                                    <div class="gap"></div>
<?php
$sqlshowcustomfields = $obj->SelectAll("ticket_custom_field");
if (!empty($sqlshowcustomfields))
    foreach ($sqlshowcustomfields as $fields):
        ?>
                                                            <label class="checkbox"><input  name="custom2[]"  id="custom2[]" class="style" type="checkbox" value="<?php echo $fields->id; ?>"> <?php echo $fields->name; ?>
                                                            </label>
                                                            <div class="gap"></div>
    <?php endforeach; ?>





                                                    <div class="control-group">
                                                        <label class="control-label">&nbsp;</label>
                                                        <div class="controls">
                                                            <button type="submit" name="create" class="btn btn-success"><i class="icon-ok"></i> Finish Checkin</button> 
                                                            <button type="reset" class="btn btn-danger"><i class="icon-ban-circle"></i> Reset Form</button>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <br>
                                                </div>
                                                <!-- /general form elements -->
                                            </div>
                                        </div>

                                        <!-- /general form elements -->     


                                        <div class="clearfix"></div>



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
<?php
include('include/footer.php');
?>

        </div>
        <!-- /main wrapper -->

    </body>
</html>
