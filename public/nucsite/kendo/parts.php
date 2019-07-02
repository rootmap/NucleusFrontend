<?php
include('class/auth.php');
$table = "parts_order";
if (isset($_POST['create'])) {
    extract($_POST);
    if (!empty($quantity) && !empty($cost) && !empty($retail_customer)) {
        if ($obj->insert($table, array("ticket_id" => $ticket_id, "description" => $description, "part_url" => $parts_url, "quantity" => $quantity,
                    "cost" => $cost, "retail_customer" => $retail_customer, "store" => $input_by, "texable" => $taxable, "shipping" => $shipping, "trackingnum" => $trackingnum,
                    "notes" => $notes, "ordered" => $ordered, "received" => $received, "input_by" => $input_by, "access_id" => $access_id, "date" => date('Y-m-d'), "status" => 1)) == 1) {
            $obj->Success("Part Order Successfully Placed", "parts_list.php");
        } else {
            $obj->Error("Something is wrong, Try again.", $obj->filename());
        }
    } else {
        $obj->Error("Failed, Fill up required field", $obj->filename());
    }
} elseif (isset($_POST['update'])) {
    extract($_POST);
    if (!empty($quantity) && !empty($cost) && !empty($retail_customer) && !empty($taxable) && !empty($ordered) && !empty($received)) {
        if ($obj->update($table, array("id" => $edit, "ticket_id" => $ticket_id, "description" => $description, "part_url" => $parts_url, "quantity" => $quantity,
                    "cost" => $cost, "retail_customer" => $retail_customer, "texable" => $taxable, "shipping" => $shipping, "trackingnum" => $trackingnum,
                    "notes" => $notes, "ordered" => $ordered, "received" => $received, "store" => $input_by, "input_by" => $input_by, "access_id" => $access_id, "status" => 1)) == 1) {
            $obj->Success("Successfully Updated", $obj->filename() . "?edit=" . $edit);
        } else {
            $obj->Error("Something is wrong, Try again.", $obj->filename() . "?edit=" . $edit);
        }
    } else {
        $obj->Error("Failed, Fill up required field", $obj->filename() . "?edit=" . $edit);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
        include './plugin/plugin.php';
        $cms = new CmsRootPlugin();
        echo $cms->GeneralCss(array("kendo"));
        ?>
        <script>
            function Ticket_Cost(tid) {
                if (tid == "") {
                    document.getElementById('cost').innerHTML = "";
                    return;
                }
                if (window.XMLHttpRequest) {
                    xmlhttp = new XMLHttpRequest();
                } else {
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function ()
                {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
                    {
                        //load retail cost
                        xmlhttps = new XMLHttpRequest();
                        xmlhttps.onreadystatechange = function ()
                        {
                            if (xmlhttps.readyState == 4 && xmlhttps.status == 200)
                            {
                                document.getElementById('retail_cost').value = xmlhttps.responseText;
                            }
                        }
                        st = 2;
                        xmlhttps.open("GET", "ajax/ticket_cost.php?tid=" + tid + "&st=" + st, true);
                        xmlhttps.send();
                        //load retail cost

                        //load retail cost
                        xmlhttps3 = new XMLHttpRequest();
                        xmlhttps3.onreadystatechange = function ()
                        {
                            if (xmlhttps3.readyState == 4 && xmlhttps3.status == 200)
                            {
                                document.getElementById('ps').value = xmlhttps3.responseText;
                            }
                        }
                        st = 3;
                        xmlhttps3.open("GET", "ajax/ticket_cost.php?tid=" + tid + "&st=" + st, true);
                        xmlhttps3.send();
                        //load retail cost
                        document.getElementById('cost').value = xmlhttp.responseText;
                    }
                }
                st = 1;
                xmlhttp.open("GET", "ajax/ticket_cost.php?tid=" + tid + "&st=" + st, true);
                xmlhttp.send();
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
                <?php echo $obj->ShowMsg(); ?>
                <!-- /info notice -->

                <div class="outer">
                    <div class="inner">
                        <div class="page-header"><!-- Page header -->
                            <h5><?php if (@$_GET['edit']) { ?><i class="icon-edit"></i> Update Parts Order <?php } else { ?> <i class="font-plus-sign"></i> Add Parts Order<?php } ?> </h5>
                            <ul class="icons">
                                <li><a href="<?php echo $obj->filename(); ?>" class="hovertip" title="Reload"><i class="font-refresh"></i></a></li>
                            </ul>
                        </div><!-- /page header -->

                        <div class="body">

                            <!-- Middle navigation standard -->
                            <!-- /middle navigation standard -->

                            <!-- Content container -->




                            <!-- Content Start from here customized -->

                            <?php if (@$_GET['edit']) { ?>
                                <form class="form-horizontal" method="post" name="invoice" action="">
                                    <fieldset>
                                        <!-- General form elements -->
                                        <div class="row-fluid  span12 well">     
                                            <!-- Selects, dropdowns -->
                                            <div class="span6" style="padding:0px; margin:0px;">
                                                <div class="control-group">
                                                    <input type="hidden" name="edit" value="<?php echo $_GET['edit']; ?>">
                                                    <label class="span4">* Ticket :</label>
                                                    <div class="span5">
                                                        <select name="ticket_id" id="ticket_id" style="width:200px;">
                                                            <?php
                                                            if ($input_status == 1) {
                                                                $data = $obj->SelectAll("ticket");
                                                            } else {
                                                                $data = $obj->SelectAllByID_Multiple("ticket", array("input_by" => $input_by));
                                                            }
                                                            if (!empty($data))
                                                                foreach ($data as $row):
                                                                    $cid = $obj->SelectAllByVal("ticket", "ticket", $row->ticket_id, "cid");
                                                                    $fname = $obj->SelectAllByVal("coustomer", "id", $row->cid, "firstname");
                                                                    $lname = $obj->SelectAllByVal("coustomer", "id", $row->cid, "lastname");
                                                                    $tid = $obj->SelectAllByVal($table, "id", $_GET['edit'], "ticket_id");
                                                                    ?>
                                                                    <option <?php if ($tid == $row->ticket_id) { ?> selected <?php } ?> value="<?php echo $row->ticket_id; ?>"><?php echo $fname . " " . $lname . " - " . $row->ticket_id; ?></option> 
                                                                <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="span5"> Description</label>
                                                    <div class="span5"><input value="<?php echo $obj->SelectAllByVal($table, "id", $_GET['edit'], "description"); ?>" class="span12 k-textbox" type="text" name="description" /></div>
                                                </div>





                                                <div class="control-group">
                                                    <label class="span5"> Part URL </label>
                                                    <div class="span5"><input value="<?php echo $obj->SelectAllByVal($table, "id", $_GET['edit'], "part_url"); ?>" class="span12 k-textbox" type="text" name="parts_url" /></div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="span5">* Quantity</label>
                                                    <div class="span5"><input value="<?php echo $obj->SelectAllByVal($table, "id", $_GET['edit'], "quantity"); ?>" class="span12 k-textbox" type="number" name="quantity" /></div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="span5">* Our Cost </label>
                                                    <div class="span5"><input value="<?php echo $obj->SelectAllByVal($table, "id", $_GET['edit'], "cost"); ?>" class="span12 k-textbox" type="number" name="cost" /></div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="span5">* Retail For Your Customer</label>
                                                    <div class="span5">
                                                        <input type="number" value="<?php echo $obj->SelectAllByVal($table, "id", $_GET['edit'], "retail_customer"); ?>" id="retail_cost" name="retail_customer" class="span12 k-textbox" /></span>
                                                    </div>
                                                </div>

                                                <!--<div class="control-group">
                                                    <label class="span5">* Destination Store</label>
                                                    <div class="span4">
                                                        <select name="store" data-placeholder="Please Select..." class="select-search" tabindex="1" style="width:100%;">
                                                            <option value=""></option> 
                                                <?php
                                                /* if($input_status==1)
                                                  {												 										$store_x=$obj->SelectAllByVal($table,"id",$_GET['edit'],"store");
                                                  $data=$obj->SelectAllByID("store",array("status"=>2));
                                                  }
                                                  else
                                                  {
                                                  $data=$obj->SelectAllByID("store",array("store_id"=>$input_by));
                                                  }
                                                  foreach($data as $rows): */
                                                ?>
                                                            <option <?php //if($store_x==$rows->store_id){  ?> selected <?php //}  ?> value="<?php //echo $rows->store_id;  ?>"><?php //echo $rows->name;  ?></option> 
                                                <?php //endforeach; ?>
                                                       </select><?php //echo $store_x;  ?>
                                                    </div>
                                                </div>-->





                                            </div>
                                            <!-- /selects, dropdowns -->



                                            <!-- Selects, dropdowns -->
                                            <div class="span6" style="padding:0px; margin:0px; float:right;">

                                                <div class="control-group">
                                                    <label class="control-label"></label>
                                                    <div class="controls">
                                                        <?php $texable=$obj->SelectAllByVal($table, "id", $_GET['edit'], "texable"); ?>
                                                        <input value="1" <?php if($texable==1){ ?> checked="checked" <?php } ?>  class="k-checkbox"  name="taxable"  type="checkbox">
                                                           * Taxable
                                                    </div>
                                                </div>


                                                <div class="control-group">
                                                    <label class="span5"> Shipping </label>
                                                    <div class="span5"><input value="<?php echo $obj->SelectAllByVal($table, "id", $_GET['edit'], "shipping"); ?>" class="span12 k-textbox" type="text" name="shipping" /></div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="span5"> Tracking No. </label>
                                                    <div class="span5">
                                                        <input class="span12 k-textbox" value="<?php echo $obj->SelectAllByVal($table, "id", $_GET['edit'], "trackingnum"); ?>" type="text" name="trackingnum" />
                                                    </div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="span5"> Notes </label>
                                                    <div class="span5"><input value="<?php echo $obj->SelectAllByVal($table, "id", $_GET['edit'], "notes"); ?>" class="span12 k-textbox" type="text" name="notes" /></div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="span5">* Ordered </label>
                                                    <div class="span6"><input readonly value="<?php echo $obj->SelectAllByVal($table, "id", $_GET['edit'], "ordered"); ?>" type="text" class="k-datepicker" name="ordered" /></div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="span5">* Received </label>
                                                    <div class="span6"><input readonly value="<?php echo $obj->SelectAllByVal($table, "id", $_GET['edit'], "received"); ?>"  class="k-datepicker"  type="text" name="received" /></div>
                                                </div>


                                                <div class="control-group">
                                                    <label class="control-label">&nbsp;</label>
                                                    <div class="controls"><button type="submit" name="update" class="k-button"><i class="icon-check"></i> Update Parts Order </button> <button type="reset" name="reset" class="k-button"><i class="icon-ban-circle"></i> Clear Form </button></div>
                                                </div>
                                            </div>
                                            <!-- /selects, dropdowns -->



                                        </div>
                                        <!-- /general form elements -->     


                                        <div class="clearfix"></div>

                                        <!-- Default datatable -->

                                        <!-- /default datatable -->


                                    </fieldset>                     

                                </form>
                            <?php } else { ?>
                                <form class="form-horizontal" method="post" name="invoice" action="">
                                    <fieldset>
                                        <!-- General form elements -->
                                        <div class="row-fluid  span12 well">     
                                            <!-- Selects, dropdowns -->
                                            <div class="span6" style="padding:0px; margin:0px;">
                                                <div class="control-group">
                                                    <label class="span5">* Ticket :</label>
                                                    <div class="span5">
                                                        <select name="ticket_id" id="ticket_id" onChange="Ticket_Cost(this.value)" style="width: 180px;">
                                                            <?php
                                                            if ($input_status == 1) {
                                                                $data = $obj->SelectAll("ticket");
                                                            } else {
                                                                $data = $obj->SelectAllByID_Multiple("ticket", array("input_by" => $input_by));
                                                            }
                                                            if (!empty($data))
                                                                foreach ($data as $row):
                                                                    if (isset($_GET['fromticket'])) {
                                                                        ?>
                                                                        <option <?php if ($_GET['fromticket'] == $row->ticket_id) { ?> selected <?php } ?> value="<?php echo $row->ticket_id; ?>"><?php echo $row->ticket_id; ?> : <?php echo $row->date; ?></option> 
                                                                        <?php
                                                                    } else {
                                                                        ?>
                                                                        <option value="<?php echo $row->ticket_id; ?>"><?php echo $row->ticket_id; ?> : <?php echo $row->date; ?></option> 
                                                                        <?php
                                                                    }
                                                                endforeach;
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>


                                                <div class="control-group">
                                                    <label class="span5"> Ticket Payment Status </label>
                                                    <div class="span5"><input disabled class="span12 k-textbox" type="text" name="ps" id="ps" value=" " /></div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="span5"> Description</label>
                                                    <div class="span5"><input class="span12 k-textbox" type="text" name="description" /></div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="span5"> Part URL </label>
                                                    <div class="span5"><input class="span12 k-textbox" type="text" name="parts_url" /></div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="span5">* Quantity</label>
                                                    <div class="span5"><input class="span12 k-textbox" type="number" name="quantity" /></div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="span5">* Our Cost </label>
                                                    <div class="span5"><input class="span12 k-textbox" type="number" id="cost" name="cost" /></div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="span5">* Retail For Your Customer</label>
                                                    <div class="span5">
                                                        <input type="number" id="retail_cost" name="retail_customer" class="span12 k-textbox" /></span>
                                                    </div>
                                                </div>

                                                <!--<div class="control-group">
                                                    <label class="span5">* Destination Store</label>
                                                    <div class="span4">
                                                        <select name="store" data-placeholder="Please Select..." class="select-search" tabindex="1" style="width:100%;">
                                                            <option value=""></option> 
                                                <?php
                                                /* $data=$obj->SelectAllByID("store",array("status"=>2));
                                                  foreach($data as $rows): */
                                                ?>
                                <option value="<?php //echo $rows->store_id;   ?>"><?php //echo $rows->name;   ?></option> 
                                                <?php //endforeach;  ?>
                                                       </select>
                                                    </div>
                                                </div>-->





                                            </div>
                                            <!-- /selects, dropdowns -->



                                            <!-- Selects, dropdowns -->
                                            <div class="span6" style="padding:0px; margin:0px; float:right;">

                                                <div class="control-group">
                                                    <label class="control-label"></label>
                                                    <div class="controls">
                                                        <input value="1" name="taxable"  class="k-checkbox" type="checkbox">
                                                            * Taxable
                                                        
                                                    </div>
                                                </div>


                                                <div class="control-group">
                                                    <label class="span5"> Shipping </label>
                                                    <div class="span5"><input class="span12 k-textbox" type="text" name="shipping" /></div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="span5"> Tracking No. </label>
                                                    <div class="span5">
                                                        <input class="span12 k-textbox" type="text" name="trackingnum" />
                                                    </div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="span5"> Notes </label>
                                                    <div class="span5"><input class="span12 k-textbox" type="text" name="notes" /></div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="span5">* Ordered </label>
                                                    <div class="span6"><input type="text" class="k-datepicker" name="ordered" /></div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="span5">* Received </label>
                                                    <div class="span6"><input type="text" class="k-datepicker"  name="received" /></div>
                                                </div>


                                                <div class="control-group">
                                                    <label class="control-label">&nbsp;</label>
                                                    <div class="controls"><button type="submit" name="create" class="k-button"><i class="icon-plus-sign"></i> Add Line Item </button></div>
                                                </div>
                                            </div>
                                            <!-- /selects, dropdowns -->



                                        </div>
                                        <!-- /general form elements -->     


                                        <div class="clearfix"></div>

                                        <!-- Default datatable -->

                                        <!-- /default datatable -->


                                    </fieldset>                     

                                </form>
                            <?php } ?>




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
                <?php if(isset($_GET['edit'])){
                    ?>
                    nucleus("#ticket_id").kendoDropDownList({
                        optionLabel: " -- Select Ticket -- "
                    }).data("kendoDropDownList");    
                    
                    nucleus(".ui-datepicker-append").hide();
                    
                    
                    <?php
                }else{
                   ?>
                   nucleus("#ticket_id").kendoDropDownList({
                        optionLabel: " -- Select Ticket -- "
                   }).data("kendoDropDownList").select(0);    
                   <?php
                } ?>
                
                nucleus(".k-datepicker").kendoDatePicker({
                    format: "yyyy/MM/dd",
                    animation: false
                  });
//                nucleus("#sendemail").kendoDropDownList({
//                    optionLabel: "Send Email After Complete Account Creation"
//                }).data("kendoDropDownList").select(2);
            </script> 
            <!-- Right sidebar -->
            <?php //include('include/sidebar_right.php');   ?>
            <!-- /right sidebar -->

        </div>
        <!-- /main wrapper -->

    </body>
</html>
