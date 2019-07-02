<?php
include('class/auth.php');
if ($input_status != 1) {
    $obj->Error("Invalid Page Request.", "index.php");
}
$table = "general_setting";
if (isset($_POST['create'])) {
    extract($_POST);
    if (!empty($store_id)) {

        $a = 0;
        $sqldevice = $obj->SelectAllByID_Multiple("checkin", array("access_id" => $input_by));
        foreach ($sqldevice as $device):

            if ($obj->insert("store_checkin", array("id" => $device->id, "store_id" => $store_id, "date" => date('Y-m-d'), "status" => 1)) == 1) {
                echo $a+=1;
            } else {
                echo $a+=0;
            }

        endforeach;


        $sqlversion = $obj->SelectAllByID_Multiple("checkin_version", array("store_id" => $input_by));
        foreach ($sqlversion as $version):
            if ($obj->insert("store_checkin_version", array("id" => $version->id, "store_id" => $store_id, "date" => date('Y-m-d'), "status" => 1)) == 1) {
                $a+=1;
            } else {
                $a+=0;
            }
        endforeach;

        $sqlcolor = $obj->SelectAllByID_Multiple("checkin_version_color", array("store_id" => $input_by));
        foreach ($sqlcolor as $color):
            if ($obj->insert("store_checkin_version_color", array("id" => $color->id, "store_id" => $store_id, "date" => date('Y-m-d'), "status" => 1)) == 1) {
                $a+=1;
            } else {
                $a+=0;
            }
        endforeach;

        $sqlnetwork = $obj->SelectAllByID_Multiple("checkin_network", array("store_id" => $input_by));
        foreach ($sqlnetwork as $network):
            if ($obj->insert("store_checkin_network", array("id" => $network->id, "store_id" => $store_id, "date" => date('Y-m-d'), "status" => 1)) == 1) {
                $a+=1;
            } else {
                $a+=0;
            }
        endforeach;

        $sqlproblem = $obj->SelectAllByID_Multiple("checkin_problem", array("store_id" => $input_by));
        foreach ($sqlproblem as $problem):
            if ($obj->insert("store_checkin_problem", array("id" => $problem->id, "store_id" => $store_id, "date" => date('Y-m-d'), "status" => 1)) == 1) {
                $a+=1;
            } else {
                $a+=0;
            }
        endforeach;

        $sqlprice = $obj->SelectAllByID_Multiple("checkin_price", array("store_id" => $input_by));
        foreach ($sqlprice as $price):
            if ($obj->insert("checkin_price", array("store_id" => $store_id,
                        "checkin_id" => $price->checkin_id,
                        "barcode" => $price->barcode,
                        "checkin_version_id" => $price->checkin_version_id,
                        "checkin_problem_id" => $price->checkin_problem_id,
                        "input_by" => $store_id,
                        "name" => $price->name,
                        "date" => date('Y-m-d'), "status" => 1)) == 1) {
                $a+=1;
            } else {
                $a+=0;
            }
        endforeach;

        $sqlproduct = $obj->SelectAllByID_Multiple("product", array("input_by" => $input_by));
        foreach ($sqlproduct as $product):
            if ($obj->insert("product", array("store_id" => $store_id,
                        "barcode" => $product->barcode,
                        "input_by" => $store_id,
                        "name" => $product->name,
                        "description" => $product->description,
                        "price_cost" => $product->price_cost,
                        "price_retail" => $product->price_retail,
                        "discount" => $product->discount,
                        "taxable" => $product->taxable,
                        "maintain_stock" => $product->maintain_stock,
                        "notes" => $product->notes,
                        "instock" => $product->instock,
                        "reorder" => $product->reorder,
                        "quantity" => $product->quantity,
                        "conditions" => $product->conditions,
                        "physical_location" => $product->physical_location,
                        "warranty" => $product->warranty,
                        "vendor" => $product->vendor,
                        "sort_order" => $product->sort_order,
                        "date" => date('Y-m-d'), "status" => 1)) == 1) {
                $a+=1;
            } else {
                $a+=0;
            }
        endforeach;

        if ($a != 0) {
            $obj->Success("Successfully Send  ( <font color='#000000'>" . $a . "</font> ) Data To Store.", $obj->filename());
        } else {
            $obj->Error("Something is wrong, Try again.", $obj->filename());
        }
    } else {
        $obj->Error("Failed, Fill up required field", $obj->filename());
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
        <?php //echo $obj->bodyhead();  ?>
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
                            <h5><i class="font-cogs"></i> Set Up New Store </h5>
                            <ul class="icons">
                                <li><a href="<?php echo $obj->filename(); ?>" class="hovertip" title="Reload"><i class="font-refresh"></i></a></li>
                            </ul>
                        </div><!-- /page header -->

                        <div class="body">

                            <!-- Middle navigation standard -->
                            <?php //include('include/quicklink.php');  ?>
                            <!-- /middle navigation standard -->

                            <!-- Content container -->
                            <div class="container">




                                <!-- Content Start from here customized -->


                                <form class="form-horizontal" method="post" name="invoice" action="">
                                    <fieldset>
                                        <!-- General form elements -->
                                        <div class="row-fluid  span12 well">     
                                            <!-- Selects, dropdowns -->
                                            <div class="span6" style="padding:0px; margin:0px;">
                                                <div class="control-group">
                                                    <label class="span12"> <input type="checkbox" checked> Checkin Device </label>
                                                </div>
                                                <div class="control-group">
                                                    <label class="span12"> <input type="checkbox" checked> Checkin Device Version </label>
                                                </div>
                                                <div class="control-group">
                                                    <label class="span12"> <input type="checkbox" checked> Checkin Device Color </label>
                                                </div>







                                            </div>
                                            <!-- /selects, dropdowns -->



                                            <!-- Selects, dropdowns -->
                                            <div class="span6" style="padding:0px; margin:0px; float:right;">
                                                <div class="control-group">
                                                    <label class="span12"> <input type="checkbox" checked> Checkin Device Network </label>
                                                </div>

                                                <div class="control-group">
                                                    <label class="span12"> <input type="checkbox" checked> Checkin Device Problem </label>
                                                </div>

                                                <div class="control-group">
                                                    <!--<label> Select New Store </label>-->
                                                    <select name="store_id" style="width: 200px;" tabindex="2">
                                                        <option value=""></option> 
                                                        <?php
                                                        $sqlstore = $obj->SelectAllByID("store", array("status" => 2));
                                                        if (!empty($sqlstore))
                                                            foreach ($sqlstore as $store):
                                                                ?>
                                                                <option value="<?php echo $store->store_id; ?>"><?php echo $store->name; ?> - ( <?php echo $store->store_id; ?> )</option> 
                                                                <?php
                                                            endforeach;
                                                        ?>
                                                    </select>
                                                </div>


                                                <div class="control-group">

                                                    <button type="submit" name="create" class="k-button"><i class="icon-cog"></i> Save Changes </button>
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
                nucleus("select[name='store_id']").kendoDropDownList({
                    optionLabel: " Please Select Store  "
                }).data("kendoDropDownList").select(0);

            </script>



            <?php //include('include/footer.php');  ?>
            <!-- Right sidebar -->
            <?php //include('include/sidebar_right.php');   ?>
            <!-- /right sidebar -->

        </div>
        <!-- /main wrapper -->

    </body>
</html>
