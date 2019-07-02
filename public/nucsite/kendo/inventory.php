<?php
include('class/auth.php');

if ($input_status == 3 || $input_status == 4) {
    $obj->Error("Invalid Page Request.", "index.php");
}
$table = "product";
if (isset($_POST['create'])) {
    extract($_POST);
    if (!empty($price_cost) && !empty($price_retail) && !empty($quantity)) {
        if ($pid == 0) {
            if ($obj->insert($table, array("name" => $name,
                        "description" => $description,
                        "barcode" => $barcode,
                        "price_cost" => $price_cost,
                        "price_retail" => $price_retail,
                        "discount" => $discount,
                        "taxable" => $taxable,
                        "maintain_stock" => $maintain_stock,
                        "notes" => $notes,
                        "reorder" => $reorder,
                        "quantity" => $quantity,
                        "conditions" => $condition,
                        "physical_location" => $physical_location,
                        "warranty" => $warranty,
                        "vendor" => $vendor,
                        "sort_order" => $sort_order,
                        "input_by" => $input_by,
                        "access_id" => $access_id,
                        "store_id" => $input_by,
                        "date" => date('Y-m-d'),
                        "status" => 1)) == 1) {
                $obj->Success("Successfully Saved", $obj->filename());
            } else {
                $obj->Error("Something is wrong, Try again.", $obj->filename());
            }
        } else {
            if ($obj->Update_product_incre($table, "quantity", $quantity, "id", $pid) == 1) {
                $obj->insert("product_stockin", array("pid" => $pid,
                    "quantity" => $quantity,
                    "price_cost" => $price_cost,
                    "price_retail" => $price_retail,
                    "access_id" => $access_id,
                    "date" => date('Y-m-d'),
                    "status" => 1));
                $obj->Success("Product Quantity Successfully Updated", "inventory_list.php");
            } else {
                $obj->Error("Product Not Stock In, Try again.", $obj->filename());
            }
        }
    } else {
        $obj->Error("Failed, Fill up required field", $obj->filename());
    }
}

if (isset($_POST['update'])) {
    extract($_POST);
    if (isset($_POST['taxable'])) {
        $taxable = $_POST['taxable'];
    } else {
        $taxable = "";
    }

    if (isset($_POST['maintain_stock'])) {
        $maintain_stock = $_POST['maintain_stock'];
    } else {
        $maintain_stock = "";
    }
    if (!empty($price_cost) && !empty($price_retail)) {
        if ($input_status == 1) {
            if ($obj->update($table, array("id" => $id,
                        "name" => $name,
                        "description" => $description,
                        "barcode" => $barcode,
                        "price_cost" => $price_cost,
                        "price_retail" => $price_retail,
                        //"quantity"=>$instock,
                        "discount" => $discount,
                        "taxable" => $taxable,
                        "maintain_stock" => $maintain_stock,
                        "notes" => $notes,
                        "reorder" => $reorder,
                        "conditions" => $condition,
                        "physical_location" => $physical_location,
                        "warranty" => $warranty,
                        "vendor" => $vendor,
                        "sort_order" => $sort_order,
                        "input_by" => $input_by,
                        "access_id" => $access_id,
                        "store_id" => $input_by,
                        "date" => date('Y-m-d'))) == 1) {
                $obj->insert("product_stockin", array("pid" => $id, "price_cost" => $price_cost, "price_retail" => $price_retail, "quantity" => $instock, "access_id" => $input_by, "date" => date('Y-m-d'), "status" => 1));
                if (isset($_POST['sold_quantity'])) {
                    $newstock = $_POST['sold_quantity'] + $instock;
                    $obj->update($table, array("id" => $id, "quantity" => $newstock));
                } else {
                    $obj->Update_product_incre($table, "quantity", $instock, "id", $id);
                }

                $chk = $obj->exists_multiple("checkin_price", array("barcode" => $barcode));
                if ($chk != 0) {
                    $obj->update("checkin_price", array("barcode" => $barcode, "name" => $price_retail));
                }

                if ($lcdst == 1) {
                    foreach ($_POST['quant'] as $index => $qancode):
                        if (!empty($qancode)) {
                            $chkcolorpro = $obj->exists_multiple("inventory_lcd_color_product", array("store_id" => $input_by, "pid" => $id, "color_id" => $_POST['color_id'][$index]));
                            if ($chkcolorpro == 0) {
                                $obj->insert("inventory_lcd_color_product", array("store_id" => $input_by, "pid" => $id, "color_id" => $_POST['color_id'][$index], "quantity" => $qancode, "user_id" => $input_bys, "date" => date('Y-m-d'), "status" => 1));
                            } else {
                                $colstid = $obj->SelectAllByVal3("inventory_lcd_color_product", "store_id", $input_by, "pid", $id, "color_id", $_POST['color_id'][$index], "id");
                                $obj->update("inventory_lcd_color_product", array("id" => $colstid, "quantity" => $qancode, "user_id" => $input_bys, "date" => date('Y-m-d'), "status" => 1));
                            }
                        }
                    endforeach;
                }

                if (isset($_POST['reor'])) {
                    $obj->delete("reorder", array("id" => $_POST['reor']));
                    $reorder_link = "&reor=" . $_POST['reor'];
                } else {
                    $reorder_link = "";
                }

                $obj->Success("Successfully Saved", $obj->filename() . "?edit=" . $id . "" . $reorder_link);
            } else {
                if (isset($_POST['reor'])) {
                    $reorder_link = "&reor=" . $_POST['reor'];
                } else {
                    $reorder_link = "";
                }
                $obj->Error("Something is wrong, Try again.", $obj->filename() . "?edit=" . $id . "" . $reorder_link);
            }
        } else {
            if (isset($_POST['taxable'])) {
                $taxable = $_POST['taxable'];
            } else {
                $taxable = "";
            }

            if (isset($_POST['maintain_stock'])) {
                $maintain_stock = $_POST['maintain_stock'];
            } else {
                $maintain_stock = "";
            }

            $owner_id = $obj->SelectAllByVal($table, "id", $id, "input_by");
            $owner_id2 = $obj->SelectAllByVal($table, "id", $id, "input_by");
            if ($owner_id == $input_by || $owner_id2 == $input_by) {
                if ($obj->update($table, array("id" => $id, "name" => $name,
                            "description" => $description,
                            "barcode" => $barcode,
                            "price_cost" => $price_cost,
                            "price_retail" => $price_retail,
                            //"quantity"=>$instock,
                            "discount" => $discount,
                            "taxable" => $taxable,
                            "maintain_stock" => $maintain_stock,
                            "notes" => $notes,
                            "reorder" => $reorder,
                            "conditions" => $condition,
                            "physical_location" => $physical_location,
                            "warranty" => $warranty,
                            "vendor" => $vendor,
                            "sort_order" => $sort_order,
                            "input_by" => $input_by,
                            "access_id" => $access_id,
                            "store_id" => $input_by,
                            "date" => date('Y-m-d'))) == 1) {
                    $obj->insert("product_stockin", array("pid" => $id, "price_cost" => $price_cost, "price_retail" => $price_retail, "quantity" => $instock, "access_id" => $input_by, "date" => date('Y-m-d'), "status" => 1));
                    if (isset($_POST['sold_quantity'])) {
                        $newstock = $_POST['sold_quantity'] + $instock;
                        $obj->update($table, array("id" => $id, "quantity" => $newstock));
                    } else {
                        $obj->Update_product_incre($table, "quantity", $instock, "id", $id);
                    }
                    $chk = $obj->exists_multiple("checkin_price", array("barcode" => $barcode, "store_id" => $input_by));
                    if ($chk != 0) {
                        $pr_id = $obj->SelectAllByVal2("checkin_price", "barcode", $barcode, "store_id", $input_by, "id");
                        $obj->update("checkin_price", array("id" => $pr_id, "name" => $price_retail));
                    }

                    if ($lcdst == 1) {
                        foreach ($_POST['quant'] as $index => $qancode):
                            if (!empty($qancode)) {
                                $chkcolorpro = $obj->exists_multiple("inventory_lcd_color_product", array("store_id" => $input_by, "pid" => $id, "color_id" => $_POST['color_id'][$index]));
                                if ($chkcolorpro == 0) {
                                    $obj->insert("inventory_lcd_color_product", array("store_id" => $input_by, "pid" => $id, "color_id" => $_POST['color_id'][$index], "quantity" => $qancode, "user_id" => $input_bys, "date" => date('Y-m-d'), "status" => 1));
                                } else {
                                    $colstid = $obj->SelectAllByVal3("inventory_lcd_color_product", "store_id", $input_by, "pid", $id, "color_id", $_POST['color_id'][$index], "id");
                                    $obj->update("inventory_lcd_color_product", array("id" => $colstid, "quantity" => $qancode, "user_id" => $input_bys, "date" => date('Y-m-d'), "status" => 1));
                                }
                            }
                        endforeach;
                    }


                    if (isset($_POST['reor'])) {
                        $obj->delete("reorder", array("id" => $_POST['reor']));
                        $reorder_link = "&reor=" . $_POST['reor'];
                    } else {
                        $reorder_link = "";
                    }

                    $obj->Success("Successfully Saved", $obj->filename() . "?edit=" . $id . "" . $reorder_link);
                } else {
                    if (isset($_POST['reor'])) {
                        $reorder_link = "&reor=" . $_POST['reor'];
                    } else {
                        $reorder_link = "";
                    }
                    $obj->Error("Something is wrong, Try again.", $obj->filename() . "?edit=" . $id . "" . $reorder_link);
                }
            } else {
                $bbcode = time();
                if ($obj->insert($table, array("name" => $name, "store_id" => $input_by,
                            "description" => $description,
                            "barcode" => $bbcode,
                            "price_cost" => $price_cost,
                            "price_retail" => $price_retail,
                            //"quantity"=>$instock,
                            "discount" => $discount,
                            "taxable" => $taxable,
                            "maintain_stock" => $maintain_stock,
                            "notes" => $notes,
                            "reorder" => $reorder,
                            "conditions" => $condition,
                            "physical_location" => $physical_location,
                            "warranty" => $warranty,
                            "vendor" => $vendor,
                            "sort_order" => $sort_order,
                            "input_by" => $input_by,
                            "store_id" => $input_by,
                            "access_id" => $access_id,
                            "date" => date('Y-m-d'))) == 1) {
                    $obj->insert("product_stockin", array("pid" => $id, "price_cost" => $price_cost, "price_retail" => $price_retail, "quantity" => $instock, "access_id" => $input_by, "date" => date('Y-m-d'), "status" => 1));



                    if (isset($_POST['sold_quantity'])) {
                        $newstock = $_POST['sold_quantity'] + $instock;
                        $obj->update($table, array("id" => $id, "quantity" => $newstock));
                    } else {
                        $obj->Update_product_incre($table, "quantity", $instock, "id", $id);
                    }
                    $newpid = $obj->SelectAllByVal($table, "barcode", $bbcode, "id");
                    $chk = $obj->exists_multiple("checkin_price", array("barcode" => $bbcode));
                    if ($chk != 0) {
                        $obj->update("checkin_price", array("barcode" => $bbcode, "name" => $price_retail));
                        $obj->Success("Successfully Saved", $obj->filename() . "?edit=" . $newpid);
                    } else {
                        $checkin_id = $obj->SelectAllByVal("checkin_price", "barcode", $barcode, "checkin_id");
                        $checkin_version_id = $obj->SelectAllByVal("checkin_price", "barcode", $barcode, "checkin_version_id");
                        $checkin_problem_id = $obj->SelectAllByVal("checkin_price", "barcode", $barcode, "checkin_problem_id");
                        $obj->insert("checkin_price", array("barcode" => $bbcode, "name" => $price_retail, "checkin_id" => $checkin_id, "checkin_version_id" => $checkin_version_id, "checkin_problem_id" => $checkin_problem_id, "input_by" => $input_by, "date" => date('Y-m-d'), "status" => 1));
                        $obj->Success("Successfully Saved", $obj->filename() . "?edit=" . $newpid);
                    }
                } else {
                    $obj->Error("Something is wrong, Try again.", $obj->filename() . "?edit=" . $newpid);
                }
            }
        }
    } else {
        $obj->Error("Failed, Fill up required field", $obj->filename() . "?edit=" . $id);
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
            function product(pid)
            {


                if (pid == 0)
                {

                    if (pid == "") {
                        document.getElementById('ppid').innerHTML = "";
                        return;
                    }
                    if (window.XMLHttpRequest) {
                        xmlhttp = new XMLHttpRequest();
                    } else {
                        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    xmlhttp.onreadystatechange = function () {
                        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                            document.getElementById('ppid').innerHTML = xmlhttp.responseText;
                        }
                    }
                    st = 1;
                    xmlhttp.open("GET", "ajax/product.php?st=" + st, true);
                    xmlhttp.send();
                }
                else
                {
                    if (pid == "") {
                        document.getElementById('instock').innerHTML = "";
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
                            //load description
                            xmlhttp3 = new XMLHttpRequest();
                            xmlhttp3.onreadystatechange = function ()
                            {
                                if (xmlhttp3.readyState == 4 && xmlhttp3.status == 200)
                                {
                                    document.getElementById('description').value = xmlhttp3.responseText;
                                }
                            }
                            st = 3;
                            xmlhttp3.open("GET", "ajax/product.php?pid=" + pid + "&st=" + st, true);
                            xmlhttp3.send();
                            //load description
                            //load description
                            xmlhttp4 = new XMLHttpRequest();
                            xmlhttp4.onreadystatechange = function ()
                            {
                                if (xmlhttp4.readyState == 4 && xmlhttp4.status == 200)
                                {
                                    document.getElementById('barcode').value = xmlhttp4.responseText;
                                }
                            }
                            st = 4;
                            xmlhttp4.open("GET", "ajax/product.php?pid=" + pid + "&st=" + st, true);
                            xmlhttp4.send();
                            //load description

                            //load description
                            xmlhttp5 = new XMLHttpRequest();
                            xmlhttp5.onreadystatechange = function ()
                            {
                                if (xmlhttp5.readyState == 4 && xmlhttp5.status == 200)
                                {
                                    document.getElementById('price_cost').value = xmlhttp5.responseText;
                                }
                            }
                            st = 5;
                            xmlhttp5.open("GET", "ajax/product.php?pid=" + pid + "&st=" + st, true);
                            xmlhttp5.send();
                            //load description

                            //load description
                            xmlhttp6 = new XMLHttpRequest();
                            xmlhttp6.onreadystatechange = function ()
                            {
                                if (xmlhttp6.readyState == 4 && xmlhttp6.status == 200)
                                {
                                    document.getElementById('price_retail').value = xmlhttp6.responseText;
                                }
                            }
                            st = 6;
                            xmlhttp6.open("GET", "ajax/product.php?pid=" + pid + "&st=" + st, true);
                            xmlhttp6.send();
                            //load description

                            //load description
                            xmlhttp7 = new XMLHttpRequest();
                            xmlhttp7.onreadystatechange = function ()
                            {
                                if (xmlhttp7.readyState == 4 && xmlhttp7.status == 200)
                                {
                                    document.getElementById('discount').value = xmlhttp7.responseText;
                                }
                            }
                            st = 7;
                            xmlhttp7.open("GET", "ajax/product.php?pid=" + pid + "&st=" + st, true);
                            xmlhttp7.send();
                            //load description



                            document.getElementById('reorder').value = xmlhttp.responseText;
                        }
                    }
                    st = 8;
                    xmlhttp.open("GET", "ajax/product.php?pid=" + pid + "&st=" + st, true);
                    xmlhttp.send();
                }
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
                            <?php if (isset($_GET['edit'])) { ?>
                                <h5><i class="icon-edit"></i> Edit Inventory Product </h5>
                            <?php } else { ?>
                                <h5><i class="font-plus-sign"></i> Add Inventory Product </h5>
                            <?php } ?>
                            <ul class="icons">
                                <li><a href="<?php echo $obj->filename(); ?>" class="hovertip" title="Reload"><i class="font-refresh"></i></a></li>
                            </ul>
                        </div><!-- /page header -->

                        <div class="body">

                            <!-- Middle navigation standard -->
                            <?php //include('include/quicklink.php');       ?>
                            <!-- /middle navigation standard -->

                            <!-- Content container -->
                            <div class="container">




                                <!-- Content Start from here customized -->


                                <form class="form-horizontal" method="post" name="invoice" action="">
                                    <fieldset>
                                        <!-- General form elements -->
                                        <?php
                                        if (isset($_GET['edit'])) {
                                            if (isset($_GET['reor'])) {
                                                ?>
                                                <input type="hidden" name="reor" value="<?php echo $_GET['reor']; ?>">
                                                <?php
                                            }
                                            ?>
                                            <input type="hidden" name="id" value="<?php echo $_GET['edit']; ?>">
                                            <div class="row-fluid  span12 well">
                                                <!-- Selects, dropdowns -->
                                                <div class="span6" style="padding:0px; margin:0px;">
                                                    <div class="control-group">
                                                        <label class="control-label">* Name :</label>
                                                        <div class="controls"><input value="<?php
                                                            $name = $obj->SelectAllByVal("product", "id", $_GET['edit'], "name");
                                                            echo $name;
                                                            ?>" class="span12" type="text" name="name" /></div>
                                                    </div>
                                                    <?php
                                                    $lcdst = 0;
                                                    if (strpos(strtolower($name), 'lcd') !== false) {
                                                        $lcdst = 1;
                                                    }
                                                    ?>
                                                    <input type="hidden" name="lcdst" value="<?php echo $lcdst; ?>"/>
                                                    <div class="control-group">
                                                        <label class="control-label"> Description</label>
                                                        <div class="controls"><input  value="<?php echo $obj->SelectAllByVal("product", "id", $_GET['edit'], "description"); ?>"  class="span12" type="text" name="description" /></div>
                                                    </div>

                                                    <div class="control-group">
                                                        <label class="control-label"> UPC/Barcode </label>
                                                        <div class="controls"><input readonly  value="<?php echo $obj->SelectAllByVal("product", "id", $_GET['edit'], "barcode"); ?>"  class="span12" type="text" name="barcode" /></div>
                                                    </div>

                                                    <div class="control-group">
                                                        <label class="control-label">* Price cost</label>
                                                        <div class="controls"><input  value="<?php echo $obj->SelectAllByVal("product", "id", $_GET['edit'], "price_cost"); ?>"  class="span12" type="text" name="price_cost" /></div>
                                                    </div>

                                                    <div class="control-group">
                                                        <label class="control-label">* Price retail</label>
                                                        <div class="controls"><input  value="<?php echo $obj->SelectAllByVal("product", "id", $_GET['edit'], "price_retail"); ?>"  class="span12" type="text" name="price_retail" /></div>
                                                    </div>

                                                    <div class="control-group">
                                                        <label class="control-label">Discount</label>
                                                        <div class="controls">
                                                            <input type="text"  value="<?php echo $obj->SelectAllByVal("product", "id", $_GET['edit'], "discount"); ?>"   name="discount" class="maskPct span4"  /></span>
                                                        </div>
                                                    </div>

                                                    <div class="control-group">
                                                        <label class="control-label"></label>
                                                        <div class="controls">
                                                            <label class="checkbox"><div id="uniform-undefined" class="checker">
                                                                    <span class="checked"><input style="opacity: 0;" value="1" name="taxable" class="style" <?php
                                                                        $taxable = $obj->SelectAllByVal("product", "id", $_GET['edit'], "taxable");
                                                                        if ($taxable == 1) {
                                                                            ?> checked="checked" <?php } ?> type="checkbox"></span>
                                                                </div> Taxable
                                                            </label>

                                                            <label class="checkbox"><div id="uniform-undefined" class="checker">
                                                                    <span class="checked"><input style="opacity: 0;" value="1" name="maintain_stock" class="style" <?php
                                                                        $maintain_stock = $obj->SelectAllByVal("product", "id", $_GET['edit'], "maintain_stock");
                                                                        if ($maintain_stock == 1) {
                                                                            ?> checked="checked" <?php } ?>  type="checkbox"></span>
                                                                </div> Maintain Stock
                                                            </label>
                                                        </div>
                                                    </div>


                                                    <div class="control-group">
                                                        <label class="control-label">Notes</label>
                                                        <div class="controls"><input  value="<?php echo $obj->SelectAllByVal("product", "id", $_GET['edit'], "notes"); ?>"  class="span12" type="text" name="notes" /></div>
                                                    </div>

                                                </div>
                                                <!-- /selects, dropdowns -->



                                                <!-- Selects, dropdowns -->
                                                <div class="span6" style="padding:0px; margin:0px; float:right;">
                                                    <div class="control-group">
                                                        <label class="control-label" style="width:100px;">* Stock Quantity:</label>
                                                        <div class="controls">
                                                            <?php
                                                            $sqlsalesproduct = $obj->SelectAllByID_Multiple("sales", array("pid" => $_GET['edit']));
                                                            $sold = 0;
                                                            if (!empty($sqlsalesproduct))
                                                                foreach ($sqlsalesproduct as $soldproduct):

                                                                    $checkin_id = $obj->SelectAllByVal("invoice", "invoice_id", $soldproduct->sales_id, "checkin_id");
                                                                    $salvage_status = $obj->exists_multiple("checkin_request_ticket", array("checkin_id" => $checkin_id, "salvage_part" => 1));
                                                                    if ($salvage_status == 1) {
                                                                        $sold+=0;
                                                                    } else {
                                                                        $sold+=$soldproduct->quantity;
                                                                    }

                                                                endforeach;

                                                            $instock = $obj->SelectAllByVal("product", "id", $_GET['edit'], "quantity") - $sold;
                                                            ?>
                                                            <input class="span6"  value="<?php echo $instock; ?>"  type="number" name="instock" />
                                                            <input type="hidden" name="sold_quantity" value="<?php echo $sold; ?>" />
                                                        </div>
                                                    </div>

                                                    <div class="control-group">
                                                        <label class="control-label">Reorder at:</label>
                                                        <div class="controls"><input  value="<?php echo $obj->SelectAllByVal("product", "id", $_GET['edit'], "reorder"); ?>"  class="span4" type="number" name="reorder" /></div>
                                                    </div>

                                                    <div class="control-group">
                                                        <label class="control-label">Condition:</label>
                                                        <div class="controls"><input  value="<?php echo $obj->SelectAllByVal("product", "id", $_GET['edit'], "conditions"); ?>"  class="span12" type="text" name="condition" /></div>
                                                    </div>

                                                    <div class="control-group">
                                                        <label class="control-label">Physical location:</label>
                                                        <div class="controls"><input  value="<?php echo $obj->SelectAllByVal("product", "id", $_GET['edit'], "physical_location"); ?>"  class="span12" type="text" name="physical_location" /></div>
                                                    </div>

                                                    <?php
                                                    if ($lcdst == 1) {
                                                        ?>

                                                        <div class="control-group">
                                                            <label class="span4">Select Color & Quantity</label>
                                                            <div class="span6">
                                                                <?php
                                                                $sqlcc = $obj->FlyQuery("SELECT a.*,IFNULL(cp.quantity,0) as quantity FROM product_lcd_color as a 
                                                                LEFT JOIN inventory_lcd_color_product as cp ON cp.color_id=a.id AND cp.pid='".$_GET['edit']."' ORDER BY a.id ASC");
                                                                if (!empty($sqlcc)) {
                                                                    $i = 1;
                                                                    foreach ($sqlcc as $cc):
                                                                        ?>
                                                                        <div class="span12" style="padding-left: 0px; margin-left: 0px;">
                                                                            <button class="btn" style="width: 100px;"><?php echo $cc->name; ?></button> 
                                                                            <input class="span4" type="text" name="quant[]" value="<?php echo $cc->quantity; ?>" />
                                                                            <input class="span4" type="hidden" name="color_id[]" value="<?php echo $cc->id; ?>" />
                                                                        </div>
                                                                        <?php
                                                                        $i++;
                                                                    endforeach;
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>

                                                        <?php
                                                    }
                                                    ?>

                                                    <div class="control-group">
                                                        <label class="control-label">Warranty Length:</label>
                                                        <div class="controls">
                                                            <select name="warranty" data-placeholder="Please Select..." class="select-search" tabindex="2">
                                                                <option value="1"></option>
                                                                <?php
                                                                $wid = $obj->SelectAllByVal("product", "id", $_GET['edit'], "warranty");
                                                                for ($i = 1; $i <= 600; $i++):
                                                                    ?>
                                                                    <option <?php if ($wid == $i) { ?> selected <?php } ?> value="<?php echo $i; ?>"><?php echo $i; ?> Days</option>
                                                                <?php endfor; ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="control-group">
                                                        <label class="control-label">Vendor:</label>
                                                        <div class="controls">
                                                            <select name="vendor" data-placeholder="Please Select..." class="select-search" tabindex="2">
                                                                <option value="0"></option>
                                                                <?php
                                                                $vid = $obj->SelectAllByVal("product", "id", $_GET['edit'], "vendor");
                                                                if ($input_status == 1) {
                                                                    $sqlvendor = $obj->SelectAll("vendor");
                                                                } else {
                                                                    $sqlvendor = $obj->SelectAllByID("vendor", array("store_id" => $input_by));
                                                                }
                                                                if (!empty($sqlvendor))
                                                                    foreach ($sqlvendor as $vendor):
                                                                        ?>
                                                                        <option <?php if ($vid == $vendor->id) { ?> selected <?php } ?> value="<?php echo $vendor->id; ?>"><?php echo $vendor->name; ?></option>
                                                                    <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="control-group">
                                                        <label class="control-label">Sort order:</label>
                                                        <div class="controls"><input  value="<?php echo $obj->SelectAllByVal("product", "id", $_GET['edit'], "sort_order"); ?>"  class="span2" type="number" name="sort_order" /></div>
                                                    </div>
                                                    <?php if ($input_status == 1 || $input_status == 2) { ?>
                                                        <div class="control-group">
                                                            <label class="control-label">&nbsp;</label>
                                                            <div class="controls"><button type="submit" name="update" class="btn btn-success"><i class="icon-check"></i> Update Item Info </button></div>

                                                        </div>
                                                    <?php } ?>
                                                </div>
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

                                                        <div class="controls" id="ppid">
                                                            <input name="pid" onChange="product(this.value)" style="width: 250px;">                                                                
                                                        </div>
                                                    </div>

                                                    <div class="control-group">
                                                        <label class="control-label"> Description</label>
                                                        <div class="controls"><input  placeholder="Please Type Product Description" class="span12" type="text" name="description" id="description" /></div>
                                                    </div>

                                                    <div class="control-group">
                                                        <label class="control-label"> Barcode </label>
                                                        <div class="controls"><input placeholder="Please Type Product UPC / Barcode" class="span12" type="text" name="barcode" id="barcode" /></div>
                                                    </div>

                                                    <div class="control-group">
                                                        <label class="control-label">* Price cost</label>
                                                        <div class="controls"><input placeholder="Please Type Price Cost" class="span12" type="text" name="price_cost" id="price_cost" /></div>
                                                    </div>

                                                    <div class="control-group">
                                                        <label class="control-label">* Price retail</label>
                                                        <div class="controls"><input placeholder="Please Type Price Retail" class="span12" type="text" name="price_retail" id="price_retail" /></div>
                                                    </div>

                                                    <div class="control-group">
                                                        <label class="control-label">Discount</label>
                                                        <div class="controls">
                                                            <input type="text" placeholder="Product Discount" name="discount" id="discount" class="maskPct span4" /></span>
                                                        </div>
                                                    </div>

                                                    <div class="control-group">
                                                        <label class="control-label"></label>
                                                        <div class="controls">
                                                            <label class="checkbox"><div id="uniform-undefined" class="checker">
                                                                    <span class="checked"><input style="opacity: 0;" value="1" name="taxable" class="style" checked="" type="checkbox"></span>
                                                                </div> Taxable
                                                            </label>

                                                            <label class="checkbox"><div id="uniform-undefined" class="checker">
                                                                    <span class="checked"><input style="opacity: 0;" value="1" name="maintain_stock" class="style" checked="" type="checkbox"></span>
                                                                </div> Maintain Stock
                                                            </label>
                                                        </div>
                                                    </div>


                                                    <div class="control-group">
                                                        <label class="control-label"> Notes</label>
                                                        <div class="controls"><input placeholder="Please Type Product Notes" class="span12" type="text" name="notes" /></div>
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
                                                    <input class="span6"  placeholder="Instock Quantity"  readonly type="hidden" id="instock" name="instock" />
                                                    <div class="control-group">
                                                        <label class="control-label">Reorder at:</label>
                                                        <div class="controls"><input  placeholder="Product Re-Order"  class="span4" type="number" name="reorder" id="reorder" /></div>
                                                    </div>

                                                    <div class="control-group">
                                                        <label class="control-label">* Quantity:</label>
                                                        <div class="controls"><input placeholder="Product Current Quantity"  class="span4" type="number" name="quantity" id="quantity" /></div>
                                                    </div>

                                                    <div class="control-group">
                                                        <label class="control-label">Condition:</label>
                                                        <div class="controls"><input  placeholder="Product Condition"  class="span12" type="text" name="condition" /></div>
                                                    </div>

                                                    <div class="control-group">
                                                        <label class="control-label">Physical location:</label>
                                                        <div class="controls"><input  placeholder="Product Physical Location"  class="span12" type="text" name="physical_location" /></div>
                                                    </div>

                                                    <div class="control-group">
                                                        <label class="control-label">Warranty Length:</label>
                                                        <div class="controls">
                                                            <select name="warranty">
                                                                <?php for ($i = 1; $i <= 600; $i++): ?>
                                                                    <option  value="<?php echo $i; ?>"><?php echo $i; ?> Days</option>
                                                                <?php endfor; ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="control-group">
                                                        <label class="control-label">Vendor:</label>
                                                        <div class="controls">
                                                            <select name="vendor">
                                                                <?php
                                                                if ($input_status == 1) {
                                                                    $sqlvendor = $obj->SelectAll("vendor");
                                                                } else {
                                                                    $sqlvendor = $obj->SelectAllByID("vendor", array("store_id" => $input_by));
                                                                }
                                                                if (!empty($sqlvendor))
                                                                    foreach ($sqlvendor as $vendor):
                                                                        ?>
                                                                        <option  value="<?php echo $vendor->id; ?>"><?php echo $vendor->name; ?></option>
                                                                    <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="control-group">
                                                        <label class="control-label">Sort order:</label>
                                                        <div class="controls"><input class="span4" type="number" name="sort_order" /></div>
                                                    </div>

                                                    <div class="control-group">
                                                        <label class="control-label">&nbsp;</label>
                                                        <div class="controls"><button type="submit" name="create" class="btn btn-success"><i class="icon-plus-sign"></i> Add Line Item </button></div>
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
            <script>
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

                
            </script> 
            <!-- /right sidebar -->

        </div>
        <!-- /main wrapper -->

    </body>
</html>
