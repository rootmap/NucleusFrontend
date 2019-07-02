<?php
include('class/auth.php');
if ($input_status == 3 || $input_status == 4) {
    $obj->Error("Invalid Page Request.", "index.php");
}
$table = "product";
if (isset($_POST['create'])) {
    extract($_POST);
    if (!empty($name) && !empty($price_cost) && !empty($price_retail)) {
        if ($obj->insert($table, array("name" => $name,
                    "description" => $description,
                    "barcode" => $barcode,
                    "price_cost" => $price_cost,
                    "price_retail" => $price_retail,
                    "quantity" => 1,
                    "input_by" => $input_by,
                    "access_id" => $access_id,
                    "store_id" => $input_by,
                    "date" => date('Y-m-d'),
                    "status" =>6)) == 1) {
            $obj->Success("Successfully Saved", $obj->filename());
        } else {
            $obj->Error("Something is wrong, Try again.", $obj->filename());
        }
    }
    else
    {
        $obj->Error("Field is Empty, Please Fillup Name,Price,Cost.", $obj->filename());
    }
}

if (isset($_POST['editupdate'])) {
    extract($_POST);
    if (!empty($id) && !empty($name) && !empty($price_cost) && !empty($price_retail)) {
        if ($obj->update($table, array("id" => $id,"name" => $name,
                    "description" => $description,
                    "barcode" => $barcode,
                    "price_cost" => $price_cost,
                    "price_retail" => $price_retail,
                    "quantity" => 1,
                    "input_by" => $input_by,
                    "access_id" => $access_id,
                    "store_id" => $input_by,
                    "date" => date('Y-m-d'),
                    "status" =>6)) == 1) {
            $obj->Success("Successfully Saved", $obj->filename());
        } else {
            $obj->Error("Something is wrong, Try again.", $obj->filename());
        }
    }
    else
    {
        $obj->Error("Field is Empty, Please Fillup Name,Price,Cost.", $obj->filename());
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
                            <?php if (isset($_GET['edit'])) { ?>
                                <h5><i class="icon-edit"></i> Edit Reoccurring Inventory Product </h5>
                            <?php } else { ?>
                                <h5><i class="font-plus-sign"></i> Add Reoccurring Inventory Product </h5>
                            <?php } ?>
                            <ul class="icons">
                                <li><a href="<?php echo $obj->filename(); ?>" class="hovertip" title="Reload"><i class="font-refresh"></i></a></li>
                            </ul>
                        </div><!-- /page header -->

                        <div class="body">

                            <!-- Middle navigation standard -->
                            <?php //include('include/quicklink.php');        ?>
                            <!-- /middle navigation standard -->

                            <!-- Content container -->
                            <div class="container">




                                <!-- Content Start from here customized -->


                                <form class="form-horizontal" method="post" name="invoice" action="">
                                    <fieldset>
                                        <!-- General form elements -->
                                        <?php
                                        if (isset($_GET['edit'])) {
                                            $einfo=$obj->FlyQuery("SELECT * FROM product WHERE id='".$_GET['edit']."'");
                                            ?>
                                            <input type="hidden" name="id" value="<?php echo $_GET['edit']; ?>">
                                            <div class="row-fluid  span12 well">
                                                <!-- Selects, dropdowns -->
                                                <div class="span6" style="padding:0px; margin:0px;">
                                                    <div class="control-group">
                                                        <label class="control-label">* Name :</label>

                                                        <div class="controls">
                                                            <input value="<?php echo $einfo[0]->name; ?>" placeholder="Please Type Product Name" class="span12 k-textbox" type="text" name="name" id="name">                                                                
                                                        </div>
                                                    </div>

                                                    <div class="control-group">
                                                        <label class="control-label">* Price </label>
                                                        <div class="controls">
                                                            <input  value="<?php echo $einfo[0]->price_cost; ?>"  placeholder="Please Type Price Cost" class="span12 k-textbox" type="text" name="price_cost" id="price_cost" /></div>
                                                    </div>

                                                    <div class="control-group">
                                                        <label class="control-label">* Cost</label>
                                                        <div class="controls"><input  value="<?php echo $einfo[0]->price_retail; ?>"  placeholder="Please Type Price Retail" class="span12 k-textbox" type="text" name="price_retail" id="price_retail" /></div>
                                                    </div>

                                                </div>
                                                <!-- /selects, dropdowns -->


                                                <div class="span6" style="padding:0px; margin:0px; float:right;">
                                                <!--<div class="control-group">
                                                    <label class="control-label">In Stock:</label>
                                                    <div class="controls">
                                                        <input class="span6"  placeholder="Instock Quantity"  readonly type="number" id="instock" name="instock" />
                                                    </div>
                                                </div>-->
                                                <div class="control-group">
                                                    <label class="control-label"> Description</label>
                                                    <div class="controls"><input  value="<?php echo $einfo[0]->description; ?>"  placeholder="Please Type Product Description" class="span12 k-textbox" type="text" name="description" id="description" /></div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label"> Barcode </label>
                                                    <div class="controls"><input  value="<?php echo $einfo[0]->barcode; ?>"   placeholder="Please Type Product UPC / Barcode" class="span12 k-textbox" type="text" name="barcode" id="barcode" /></div>
                                                </div>

                                                <input type="hidden"  value="<?php echo $einfo[0]->quantity; ?>"  value="1" name="quantity" id="quantity" class="k-textbox"/>

                                                <div class="control-group">
                                                    <label class="control-label">&nbsp;</label>
                                                    <div class="controls"><button type="submit" name="editupdate" class="k-button"><i class="icon-plus-sign"></i> Update Inventory info </button></div>
                                                </div>
                                            </div>

                                                <!-- Selects, dropdowns -->

                                                <!-- /selects, dropdowns -->



                                            </div>

                                            
                                            <!-- /general form elements -->


                                            <div class="clearfix"></div>

                                            <!-- Default datatable -->

                                            <!-- /default datatable -->

                                        <?php } else { ?>
                                            <div class="row-fluid  span12 well">
                                                <!-- Selects, dropdowns -->
                                                <div class="span6" style="padding:0px; margin:0px;">
                                                    <div class="control-group">
                                                        <label class="control-label">* Name :</label>

                                                        <div class="controls">
                                                            <input placeholder="Please Type Product Name" class="span12 k-textbox" type="text" name="name" id="name">                                                                
                                                        </div>
                                                    </div>



                                                    <div class="control-group">
                                                        <label class="control-label">* Price </label>
                                                        <div class="controls"><input placeholder="Please Type Price" class="span12 k-textbox" type="text" name="price_cost" id="price_cost" /></div>
                                                    </div>

                                                    <div class="control-group">
                                                        <label class="control-label">* Cost</label>
                                                        <div class="controls"><input placeholder="Please Type Cost" class="span12 k-textbox" type="text" name="price_retail" id="price_retail" /></div>
                                                    </div>



                                                </div>
                                                <!-- /selects, dropdowns -->



                                                <!-- Selects, dropdowns -->
                                                <div class="span6" style="padding:0px; margin:0px; float:right;">
                                                    <!--<div class="control-group">
                                                        <label class="control-label">In Stock:</label>
                                                        <div class="controls">
                                                            <input class="span6"  placeholder="Instock Quantity"  readonly type="number" id="instock" name="instock" />
                                                        </div>
                                                    </div>-->
                                                    <div class="control-group">
                                                        <label class="control-label"> Description</label>
                                                        <div class="controls"><input value="Product Added From Reccurring Inventory"  placeholder="Please Type Product Description" class="span12 k-textbox" type="text" name="description" id="description" /></div>
                                                    </div>

                                                    <div class="control-group">
                                                        <label class="control-label"> Barcode </label>
                                                        <div class="controls"><input value="<?php echo time(); ?>" placeholder="Please Type Product UPC / Barcode" class="span12 k-textbox" type="text" name="barcode" id="barcode" /></div>
                                                    </div>

                                                    <input type="hidden" value="1" name="quantity" id="quantity" />

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

                                        <?php } ?>
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
<!--            <script>
                nucleus("input[name='pid']").kendoComboBox({
                    //optionLabel: " -- Select A Product -- "
                    placeholder: "Select Product.",
                    dataTextField: "name",
                    dataValueField: "id",
                    filter: "contains",
                    dataSource: {
                        type: "json",
                        serverFiltering: true,
                        transport: {
                            read: "./controller/dropdown.php?inventory=1"
                        }
                    }
                }).data("kendoComboBox").select(0);

                nucleus("select[name='warranty']").kendoDropDownList({
                    optionLabel: " -- Select Warranty -- "
                }).data("kendoDropDownList").select(0);

                nucleus("select[name='vendor']").kendoDropDownList({
                    optionLabel: " -- Select Vendor -- "
                }).data("kendoDropDownList").select(0);


            </script> -->
            <!-- /right sidebar -->

        </div>
        <!-- /main wrapper -->

    </body>
</html>
