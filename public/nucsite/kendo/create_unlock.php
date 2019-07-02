<?php
include('class/auth.php');
$table = "unlock_request";
if (isset($_GET['newticket'])) {
    $obj->newcart_unlock(@$_SESSION['SESS_CART_UNLOCK']);
    $obj->Success("New Unlock Token Has Been Created Successfully", $obj->filename() . "?cid=" . $_GET['cid']);
}
$cart = $obj->cart_unlock(@$_SESSION['SESS_CART_UNLOCK']);
/* if(isset($_POST['create']))
  {
  extract($_POST);
  if(!empty($service_id) && !empty($our_cost) && !empty($retail_cost))
  {
  $unlock_id=$cart;

  $product_name=$service_id.":".$obj->SelectAllByVal("unlock_service","id",$service_id,"name");
  $obj->insert("product",array("name"=>$product_name,"description"=>"Product Added From Unlock","barcode"=>time(),"price_cost"=>$our_cost,"price_retail"=>$retail_cost,"maintain_stock"=>0,"quantity"=>1,"warranty"=>3,"reorder"=>1,"input_by"=>$input_by,"access_id"=>$access_id,"date"=>date('Y-m-d'), "status"=>4));

  if($obj->insert($table,array(
  "cid"=>$cid,
  "unlock_id"=>$unlock_id,
  "uid"=>$input_by,
  "service_id"=>$service_id,
  "our_cost"=>$our_cost,
  "retail_cost"=>$retail_cost,
  "type_color"=>$type_color,
  "password"=>$password,
  "carrier"=>$carrier,
  "imei"=>$imei,
  "note"=>$note,
  "comment"=>$comment,"access_id"=>$access_id,
  "respond_email"=>$respond_email,
  "input_by"=>$input_by,"access_id"=>$access_id,
  "date"=>date('Y-m-d'),
  "status"=>1))==1)
  {
  $obj->newcart_unlock(@$_SESSION['SESS_CART_UNLOCK']);
  $obj->Success("Successfully Saved","view_unlock.php?unlock_id=".$unlock_id."&cid=".$cid);
  }
  else
  {
  $obj->Error("Something wrong, Try again.", $obj->filename()."?cid=".$cid);
  }
  }
  else
  {
  $obj->Error("Failed, Fill up required field.", $obj->filename()."?cid=".$cid);
  }
  } */
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
        include './plugin/plugin.php';
        $cms = new CmsRootPlugin();
        echo $cms->GeneralCss(array("kendo"));
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
                            <h5><i class="font-unlock"></i> Create New Unlock Request</h5>
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
                                <div class="block span6">
                                    <a href="<?php echo $obj->filename(); ?>?newticket=1&amp;cid=<?php echo $_GET['cid']; ?>" class="btn btn-danger"><i class="icon-ok-sign"></i>New Unlock Request</a>
                                    <span id="msg"></span>
                                </div>

                                <form class="form-horizontal" method="post" name="invoice" action="#">
                                    <fieldset>


                                        <div class="row-fluid block well">
                                            <div class="navbar">
                                                <div class="navbar-inner">
                                                    <h5><i class="icon-plus"></i> Create Unlock | Unlock ID : <?php echo $cart; ?> </h5>
                                                </div>
                                            </div>
                                            <!-- General form elements -->
                                            <div class="clearfix"></div>
                                            <div class="span6" style="margin: 0;">
                                                <div class="control-group">
                                                    <label class="control-label" style="width: 175px;">* Choose Service </label>
                                                    <div class="controls">

                                                        <select name="service_id" onChange="Unlock_Service(this.value)" id="service_id" style="width:210px;">
                                                            <?php
                                                            $sqlpdata = $obj->SelectAll("unlock_service");
                                                            if (!empty($sqlpdata))
                                                                foreach ($sqlpdata as $row):
                                                                    ?>
                                                                    <option value="<?php echo $row->id; ?>">
                                                                        <?php echo $row->name; ?>
                                                                    </option> 
                                                                <?php endforeach; ?> 
                                                        </select>
                                                        <input type="hidden" name="cid" value="<?php echo $_GET['cid']; ?>">
                                                    </div>

                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label" style="width: 175px;">* Our Cost </label>
                                                    <div class="controls">
                                                        <input type="text" name="our_cost" id="our_cost" class="span8" placeholder="Our Cost" />
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label" style="width: 175px;">* Retail Cost For Customer </label>
                                                    <div class="controls">
                                                        <input type="text" name="retail_cost" id="retail_cost" class="span8" placeholder="Retail Cost For Customer" />
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label" style="width: 175px;">Type and Color </label>
                                                    <div class="controls">
                                                        <input type="text" name="type_color" id="type_color" class="span8" placeholder="Please Type Color" />
                                                    </div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label" style="width: 175px;">Password </label>
                                                    <div class="controls">
                                                        <input type="text" name="password" id="password" class="span8" placeholder="Type Ticket Password" />
                                                    </div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label" style="width: 175px;">Carrier </label>
                                                    <div class="controls">
                                                        <input type="text" name="carrier"  id="carrier" class="span8" placeholder="Type Carrier Name" />
                                                    </div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label" style="width: 175px;">IMEI</label>
                                                    <div class="controls">
                                                        <input type="text" name="imei" id="imei" class="span8" placeholder="Put Device IMEI Number" />
                                                    </div>
                                                </div>
                                                <br>
                                                <br>

                                            </div>
                                            <!-- /general form elements -->



                                            <!-- General form elements -->
                                            <div class="span6">

                                                <div class="span11" id="detail_service"></div>

                                                <div class="control-group">


                                                    <label class="control-label" style="width: 175px;">Notes</label>
                                                    <div class="controls">
                                                        <input type="text" name="note" id="note" class="span8" placeholder="Note" />
                                                    </div>





                                                </div>


                                                <div class="control-group">
                                                    <label class="control-label" style="width: 175px;">Comment</label>
                                                    <div class="controls">
                                                        <input type="text" name="comment" id="comment" class="span8" placeholder="Comment" />
                                                    </div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label" style="width: 175px;">Respond Email</label>
                                                    <div class="controls">
                                                        <input type="text" name="respond_email" id="respond_email" class="span8" placeholder="Respond Email" />
                                                    </div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label">&nbsp;</label>
                                                    <div class="controls">
                                                        <button type="button" onClick="UnlockDataSave('<?php echo $cart; ?>', '<?php echo $_GET['cid']; ?>')" name="create" class="btn btn-success">
                                                            <i class="icon-ok"></i> Submit Request &amp; Pay 
                                                        </button> 
                                                        <button type="reset" class="btn btn-danger"><i class="icon-ban-circle"></i> Reset Form</button>
                                                    </div>
                                                </div>
                                                <br>
                                                <br>
                                            </div>
                                            <!-- /general form elements -->


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
            echo $cms->KendoFotter();
            ?>
            <script>
                nucleus("#service_id").kendoDropDownList({
                    optionLabel: "       -- Choose a Service -- "
                }).data("kendoDropDownList").select(0);
            </script> 
            <!-- Right sidebar -->
            <?php //include('include/sidebar_right.php'); ?>
            <!-- /right sidebar -->

        </div>
        <!-- /main wrapper -->

    </body>
</html>
