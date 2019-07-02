<?php
include('class/auth.php');
include('class/pos_class.php');
$obj_pos = new pos();
$table = "product";
$table2 = "invoice_detail";
$table3 = "invoice";

if (isset($_GET['cid'])) {
    $cid=$_GET['cid'];
}  else {
    $cid='0';
}
if (isset($_GET['newsales'])) {
    $obj->newcart_estimates(@$_SESSION['SESS_CART_ESTIMATES']);
    $obj->insert($table3, array("invoice_id" => $_SESSION['SESS_CART_ESTIMATES'], "cid" => $cid, "invoice_creator" => $input_by, "access_id" => $access_id, "invoice_date" => date('d-m-Y'), "date" => date('Y-m-d'), "status" => 2, "doc_type" => 2));
    $obj->Success("New Estimate Format Has Been Created Successfully", $obj->filename() . "?cid=" . $cid);
}
$cart = $obj->cart_estimates(@$_SESSION['SESS_CART_ESTIMATES']);

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
        include './plugin/plugin.php';
        $cms = new CmsRootPlugin();
        echo $cms->GeneralCss(array("kendo"));
        ?>
        <?php //echo $obj->bodyhead(); ?>
        <script src="ajax/customer_estimate_ajax.js"></script>
        <script src="ajax/invoice_estimate_ajax.js"></script>
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
                            <h5><i class="font-home"></i>Create New Estimate Info (Estimate No : - <?php echo $cart; ?> ) </span></h5>
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

<!--<a href="#" class="btn btn-success"><i class="icon-ok-sign"></i>Save Invoice</a>
<a href="#" class="btn btn-danger"><i class="icon-trash"></i> Delete Invoice</a>
<a href="#" class="btn btn-primary"><i class="icon-edit"></i> Edit Invoice</a>
<a href="#" class="btn btn-warning"><i class="icon-print"></i> Print Invoice</a>
<a href="#" class="btn btn-info"><i class="icon-bell"></i >Clone</a>
<a href="#" class="btn btn-success"><i class="icon-screenshot"></i> Quick Payment</a>
<a href="#" class="btn btn-success"><i class="icon-screenshot"></i> Payment</a>-->
                                    <a href="<?php echo $obj->filename(); ?>?newsales&amp;cid=<?php echo $cid; ?>" class="btn btn-danger"><i class="icon-ok-sign"></i>Make New Estimates</a>
                                </div>

                                <form class="form-horizontal" method="get" name="invoice" action="create_invoice.php">
                                    <fieldset>
                                        <?php
                                        ?>

                                        <div class="row-fluid block">

                                            <!-- General form elements -->
                                            <div class="well row-fluid span6">
                                                <div class="navbar">
                                                    <div class="navbar-inner">
                                                        <h5><i class="icon-user"></i> Customer</h5>
                                                    </div>
                                                </div>

                                                <br>
                                                <div class="span12">
                                                    <label class="span12"> <strong class="span4">Business Name: </strong> 

                                                        <span class="span8">  
                                                            <?php //echo $obj->customer_edit("coustomer",$_GET['cid'],"businessname","Business Name");  ?> 
                                                            <!--                                                            <div class="controls" id="newcus"></div>-->
                                                            <select name="customername" onChange="new_customer_estimate(this.value)" id="customername" class="select-search" tabindex="2">
                                                                <?php
                                                                if ($input_status == 1) {
                                                                    $sqlpdata = $obj->FlyQuery("SELECT id,concat(firstname,' ',lastname) as name FROM coustomer LIMIT 100");
                                                                } else {
                                                                    $sqlpdata = $obj->FlyQuery("SELECT id,concat(firstname,' ',lastname) as name,input_by FROM coustomer WHERE input_by='" . $input_by . "'");
                                                                }
                                                                if (!empty($sqlpdata))
                                                                    foreach ($sqlpdata as $row):
                                                                        if ($row->id != $def_cus) {
                                                                            ?>
                                                                            <option value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option> 
                                                                            <?php
                                                                        }
                                                                    endforeach;
                                                                ?> 
                                                                <option value="0">Add New Customer</option> 
                                                            </select>
                                                        </span>
                                                    </label>
                                                </div>

                                                <div class="clearfix"></div>
                                                <div class="span12">
                                                    <label class="span12"> <strong class="span4">Name: </strong><span class="span8">
                                                            <?php echo $obj->customer_edit("coustomer", $cid, "firstname", "Full Name"); ?> </span>
                                                    </label>
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="span12">
                                                    <label class="span12"> <strong class="span4">Email: </strong><span class="span8">
                                                            <?php echo $obj->customer_edit("coustomer", $cid, "email", "Email Address"); ?></span> 
                                                    </label>
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="span12">
                                                    <label class="span12"> <strong class="span4">Invoice Email: </strong><span class="span8">
                                                            <?php echo $obj->customer_edit("coustomer", $cid, "invoice_email", "Invoice Email Address"); ?> </span> 
                                                    </label>
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="span12">
                                                    <label class="span12"> <strong class="span4">Address: </strong><span class="span8">
                                                            <?php echo $obj->customer_edit("coustomer", $cid, "address1", "Address"); ?>  </span>
                                                    </label>
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="span12">
                                                    <label class="span12"> <strong class="span4">Phone: </strong><span class="span8">
                                                            <?php echo $obj->customer_edit("coustomer", $cid, "phone", "Phone Number"); ?> </span> 
                                                    </label>
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="span12">
                                                    <label class="span12"> <strong class="span4">Mobile Phone (SMS): </strong>
                                                        <span class="span8"><?php echo $obj->customer_edit("coustomer", $cid, "phonesms", "Phone Number For SMS"); ?>  </span>
                                                    </label>
                                                </div>
                                                <br>
                                                <br>
                                            </div>
                                            <!-- /general form elements -->





                                            <?php $paid = $obj->SelectAllByVal("invoice", "invoice_id", $cart, "paid"); ?>
                                            <!-- General form elements -->
                                            <div class="well row-fluid span6" <?php if ($paid != 0) { ?>style="background:url(images/paid.png) no-repeat center;"<?php } ?>>
                                                <div class="navbar">
                                                    <div class="navbar-inner">
                                                        <h5><i class="font-money"></i> Invoice Detail</h5>
                                                    </div>
                                                </div>

                                                <br>
                                                <div class="span12">
                                                    <label class="span12"> <strong class="span3">Invoice Number: </strong> 
                                                        <?php echo $cart; ?> </label>
                                                </div>

                                                <div class="clearfix"></div>
                                                <div class="span12">
                                                    <label class="span12"> <strong class="span3">Created By: </strong>
                                                        <b id="creator">
                                                            <?php
                                                            $store_id = $obj->SelectAllByVal("invoice", "invoice_id", $cart, "invoice_creator");
                                                            echo $obj->SelectAllByVal("store", "id", $store_id, "name");
                                                            ?>
                                                            <span  onclick="invoice_creator('<?php echo $cart; ?>')"><i class="icon-edit"></i> </span>
                                                        </b>



                                                    </label>
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="span12">
                                                    <label class="span12"> <strong class="span3">Invoice Date: </strong>
                                                        <?php echo $obj->invoice_edit("invoice", "invoice_id", $cart, "invoice_date", "INVOICE Date"); ?> 
                                                    </label>
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="span12">
                                                    <label class="span12"> <strong class="span3">Due Date: </strong>
                                                        <?php echo $obj->invoice_edit("invoice", "invoice_id", $cart, "due_date", "Due Date"); ?>  
                                                    </label>
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="span12">
                                                    <label class="span12"> <strong class="span3">PO Number: </strong>
                                                        <?php echo $obj->invoice_edit("invoice", "invoice_id", $cart, "po_number", "Po Number"); ?>  
                                                    </label>
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="span12">
                                                    <label class="span12"> <strong class="span3">Paid: </strong>
                                                        <?php echo $obj->invoice_edit_two("invoice", "invoice_id", $cart, "paid", "Paid"); ?></label>
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="span12">
                                                    <label class="span12"> <strong class="span3">Date paid: </strong>
                                                        <?php echo $obj->invoice_edit("invoice", "invoice_id", $cart, "paid_date", "Paid Date"); ?>  
                                                    </label>
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="span12">
                                                    <label class="span12"> <strong class="span3">Tax: </strong>
                                                        <span id="tax">$0</span> 
                                                    </label>
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="span12">
                                                    <label class="span12"> <strong class="span3">Subtotal: </strong>
                                                        <span id="subtotal">$0</span> 
                                                    </label>
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="span12">
                                                    <label class="span12"> <strong class="span3">Total: </strong>
                                                        <span id="subtotal">$0</span> 
                                                    </label>
                                                </div>
                                                <br>
                                                <br>
                                            </div>
                                            <!-- /general form elements -->

                                        </div>



                                        <!-- General form elements -->
                                        <div class="row-fluid  span12 well" style="margin-top: 5px;">     
                                            <div class="navbar">
                                                <div class="navbar-inner">
                                                    <h5><i class="font-money"></i> Line Item <span id="msg" style="float:right; margin-left:50px; margin-top:-8px;"></span></h5>
                                                </div>
                                            </div>
                                            <!-- Selects, dropdowns -->
                                            <div class="span12" style="padding:0px; margin:0px;">
                                                <div class="table-overflow">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Item</th>
                                                                <th>Description</th>
                                                                <th>QTY</th>
                                                                <th>Rate</th>
                                                                <th>Tax</th>
                                                                <th>Extended</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="sales_list">
                                                            <?php
                                                            $sqlsaleslist = $obj->SelectAllByID($table2, array("invoice_id" => $cart));
                                                            $sss = 1;
                                                            $subtotal = 0;
                                                            $tax = 0;
                                                            if (!empty($sqlsaleslist))
                                                                foreach ($sqlsaleslist as $saleslist):

                                                                    $caltax = ($saleslist->single_cost * $tax_per_product) / 100;
                                                                    $tax_status = $saleslist->tax;

                                                                    $procost = $saleslist->quantity * $saleslist->single_cost;
                                                                    $subtotal+=$procost;

                                                                    if ($tax_status == 0) {
                                                                        $tax+=0;
                                                                        $taxst = "No";
                                                                        $taxstn = "1";
                                                                        $extended = $procost;
                                                                    } else {
                                                                        $tax+=$caltax * $saleslist->quantity;
                                                                        $taxst = "Yes";
                                                                        $taxstn = "0";
                                                                        $extended = $procost + $caltax;
                                                                    }
                                                                    ?>
                                                                    <tr>
                                                                        <td><?php echo $sss; ?></td>
                                                                        <td><?php echo $obj->SelectAllByVal($table, "id", $saleslist->pid, "name"); ?></td>
                                                                        <td><?php echo $obj->SelectAllByVal($table, "id", $saleslist->pid, "name"); ?></td>

                                                                        <td><?php echo $saleslist->quantity; ?></td>
                                                                        <td><button type="button" class="btn">$<?php echo $saleslist->single_cost; ?></button></td>
                                                                        <td>
                                                                            <?php echo $obj->invoice_edit_row($table2, "id", $saleslist->id, "tax", "tax_invoice" . $saleslist->id, $cid); ?>  
                                                                        </td>
                                                                        <td>
                                                                            <button type="button" class="btn">$
                                                                                <?php echo $extended; ?>
                                                                            </button>
                                                                        </td>

                                                                        <td><button type="button" name="trash" onClick="delete_sales('<?php echo $saleslist->pid; ?>',<?php echo $cart; ?>)"><i class="icon-trash"></i></button></td>
                                                                    </tr>
                                                                    <?php
                                                                    $sss++;
                                                                endforeach;
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <!-- /selects, dropdowns -->

                                            <!-- Selects, dropdowns -->
                                            <div class="span4" style="padding:0px; margin:0px; float:right;">
                                                <div class="table-overflow">
                                                    <table class="table table-striped">
                                                        <thead id="subtotal_list">
                                                            <tr>
                                                                <th>Sub - Total: </th>
                                                                <th><?php echo number_format($subtotal, 2); ?></th>
                                                            </tr>
                                                            <tr>
                                                                <th>Tax: </th>
                                                                <th><?php echo number_format($tax, 2); ?></th>
                                                            </tr>
                                                            <tr>
                                                                <th>Total: </th>
                                                                <th><?php
                                                                    $total = $subtotal + $tax;
                                                                    echo number_format($total, 2);
                                                                    ?></th>
                                                            </tr>
                                                            <tr>
                                                                <th>Payments: </th>
                                                                <th><?php
                                                                    if ($paid != 0) {
                                                                        echo number_format($total, 2);
                                                                    } else {
                                                                        echo "$0.00";
                                                                    }
                                                                    ?></th>
                                                            </tr>
                                                            <tr>
                                                                <th>Balance Due: </th>
                                                                <th><?php
                                                                    if ($paid != 0) {
                                                                        echo "$0.00";
                                                                    } else {

                                                                        echo number_format($total, 2);
                                                                    }
                                                                    ?></th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>
                                            <!-- /selects, dropdowns -->
                                        </div>
                                        <!-- /general form elements -->

                                        <!--product pos interface start from here-->

                                        <div class="row-fluid block">
                                            <div class="well row-fluid span12">
                                                <div class="tabbable">
                                                    <!--start ul tabs -->
                                                    <ul class="nav nav-tabs">
                                                        <li class="active"><a href="#tab1" data-toggle="tab">Main ( 0 - 49 )</a></li>
                                                        <li><a href="#tab2" data-toggle="tab">Page 2 ( 50 - 300 )</a></li>
                                                        <li><a href="#tab3" data-toggle="tab">Barcode</a></li>
                                                        <li><a href="#tab4" data-toggle="tab"> Inventory </a></li>
                                                        <li><a href="#tab5" data-toggle="tab"> Manualy </a></li>
                                                    </ul>
                                                    <!--end ul tabs -->  
                                                    <!--start data tabs --> 
                                                    <div class="tab-content">
                                                        <div class="tab-pane active" id="tab1">
                                                            <!--tab 1 content start from here-->
                                                            <?php
                                                            $a = 1;
                                                            if ($input_status == 1) {
                                                                $sqlproduct = $obj_pos->SelectAllOnlyLimit("product_other_inventory", "1", "49");
                                                            } else {
                                                                $sqlproduct = $obj_pos->SelectAllOnlyOneCondLimit("product_other_inventory", "input_by", $input_by, "1", "49");
                                                            }
                                                            if (!empty($sqlproduct))
                                                                foreach ($sqlproduct as $product):
                                                                    if ($a == 1) {
                                                                        $class = "info";
                                                                    } elseif ($a == 2) {
                                                                        $class = "success";
                                                                    } elseif ($a == 3) {
                                                                        $class = "warning";
                                                                    } elseif ($a == 4) {
                                                                        $class = "dander";
                                                                        $a = 0;
                                                                    }
                                                                    ?>

                                                                    <button type="button" 
                                                                            onClick="auto_sales('<?php echo $product->id; ?>', '<?php echo $cart; ?>')" 
                                                                            class="btn btn-<?php echo $class; ?>">
                                                                        Product <?php echo $product->name; ?>
                                                                    </button>
                                                                    <?php
                                                                    $a++;
                                                                endforeach;
                                                            ?>

                                                            <!--tab 1 content start from here-->
                                                        </div>
                                                        <div class="tab-pane" id="tab2">

                                                            <!--tab 2 content start from here-->
                                                            <?php
                                                            $a = 1;
                                                            if ($input_status == 1) {
                                                                $sqlproduct2 = $obj_pos->SelectAllOnlyLimit("product_other_inventory", "50", "300");
                                                            } else {
                                                                $sqlproduct2 = $obj_pos->SelectAllOnlyOneCondLimit("product_other_inventory", "input_by", $input_by, "50", "300");
                                                            }
                                                            if (!empty($sqlproduct2))
                                                                foreach ($sqlproduct2 as $product):
                                                                    if ($a == 1) {
                                                                        $class = "info";
                                                                    } elseif ($a == 2) {
                                                                        $class = "success";
                                                                    } elseif ($a == 3) {
                                                                        $class = "warning";
                                                                    } elseif ($a == 4) {
                                                                        $class = "dander";
                                                                        $a = 0;
                                                                    }
                                                                    ?>

                                                                    <button type="button" 
                                                                            onClick="auto_sales('<?php echo $product->id; ?>', '<?php echo $cart; ?>')" 
                                                                            class="btn btn-<?php echo $class; ?>">
                                                                        Product <?php echo $product->name; ?>
                                                                    </button>
                                                                    <?php
                                                                    $a++;
                                                                endforeach;
                                                            ?>

                                                            <!--tab 2 content start from here-->

                                                        </div>
                                                        <div class="tab-pane" id="tab3">
                                                            <!--barcode tab content start from here-->
                                                            <!-- Selects, dropdowns -->
                                                            <div class="span12" style="padding:0px; margin:15px 0px 0px 0px;">
                                                                <div class="navbar">
                                                                    <div class="navbar-inner">
                                                                        <h5><i class="icon-barcode"></i> Add From Barcode</h5>
                                                                    </div>
                                                                </div>
                                                                <div class="control-group">
                                                                    <label class="control-label">UPC Code :</label>
                                                                    <div class="controls"><input class="span4" type="text" name="regular"  onKeydown="Javascript: if (event.keyCode == 13)
                                                                                barcode_sales(this.value, '<?php echo $cart; ?>');"  /> Type &amp; Press Enter / Use Your Barcode Reader</div>
                                                                </div>

                                                                <div class="control-group">
                                                                    <label class="control-label">Quantity:</label>
                                                                    <div class="controls"><input class="span4" type="number" value="1" /></div>
                                                                </div>
                                                                <!--<div class="control-group">
                                                                    <label class="control-label">&nbsp;</label>
                                                                    <div class="controls"><button type="button" class="btn btn-success"><i class="icon-plus-sign"></i> Create Line Item </button></div>
                                                                </div>-->
                                                            </div>
                                                            <!-- /selects, dropdowns -->
                                                            <!--barcode tab Start from here-->
                                                        </div>
                                                        <div class="tab-pane" id="tab4">
                                                            <!--form tab content start here-->
                                                            <!-- Selects, dropdowns -->
                                                            <div class="span12" style="padding:0px; margin:0px;">
                                                                <div class="navbar">
                                                                    <div class="navbar-inner">
                                                                        <h5><i class="icon-tag"></i> Add From Inventory</h5>
                                                                    </div>
                                                                </div>
                                                                <div class="control-group">
                                                                    <label class="control-label">Item :</label>
                                                                    <div class="controls">
                                                                        <select name="pids" id="pids"  style="width:80%;" data-placeholder="Choose a Item..." class="select-search select2-offscreen" tabindex="-1">
                                                                            <option value=""></option> 
                                                                            <?php
                                                                            $sqlpdata = $obj->SelectAll($table);
                                                                            if (!empty($sqlpdata))
                                                                                foreach ($sqlpdata as $row):
                                                                                    ?>
                                                                                    <option value="<?php echo $row->id; ?>">
                                                                                    <?php echo $row->name; ?>
                                                                                    </option> 
    <?php endforeach; ?> 
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="control-group">
                                                                    <label class="control-label">Quantity:</label>
                                                                    <div class="controls"><input class="span2" value="1" type="number" name="regular" id="quan" /></div>
                                                                </div>
                                                                <div class="control-group">
                                                                    <label class="control-label">&nbsp;</label>
                                                                    <div class="controls"><button onClick="inventory_sales('<?php echo $cart; ?>')" type="button" class="btn btn-success"><i class="icon-plus-sign"></i> Create Line Item </button></div>
                                                                </div>
                                                            </div>
                                                            <!-- /selects, dropdowns -->
                                                            <!--form tab content end here-->
                                                        </div>
                                                        <div class="tab-pane" id="tab5">
                                                            <!--form tab content start here-->
                                                            <!-- Selects, dropdowns -->
                                                            <div class="span12" style="padding:0px; margin:0px;">
                                                                <div class="navbar">
                                                                    <div class="navbar-inner">
                                                                        <h5><i class="icon-cog"></i> Add Manual Item</h5>
                                                                    </div>
                                                                </div>
                                                                <form method="get" action="" name="manual">
                                                                    <fieldset>
                                                                        <div class="control-group">
                                                                            <label class="control-label">Item:</label>
                                                                            <div class="controls">
                                                                                <select name="pid" id="pid" style="width:80%;" data-placeholder="Choose a Item..." class="select-search select2-offscreen" tabindex="-1">
                                                                                    <option value=""></option> 
                                                                                    <?php
                                                                                    $sqlpdata = $obj->SelectAll($table);
                                                                                    if (!empty($sqlpdata))
                                                                                        foreach ($sqlpdata as $row):
                                                                                            ?>
                                                                                            <option value="<?php echo $row->id; ?>">
                                                                                            <?php echo $row->name; ?>
                                                                                            </option> 
    <?php endforeach; ?> 
                                                                                </select>
                                                                            </div>
                                                                        </div>

                                                                        <div class="control-group">
                                                                            <label class="control-label">Description :</label>
                                                                            <div class="controls"><input class="span12" type="text" name="des" /></div>
                                                                        </div>

                                                                        <div class="control-group">
                                                                            <label class="control-label">Price:</label>
                                                                            <div class="controls"><input  class="span12" type="text" name="price" id="price" /></div>
                                                                        </div>

                                                                        <div class="control-group">
                                                                            <label class="control-label">Cost:</label>
                                                                            <div class="controls"><input  class="span12" type="text" name="cost" id="cost" /></div>
                                                                        </div>

                                                                        <div class="control-group">
                                                                            <label class="control-label">Quantity:</label>
                                                                            <div class="controls"><input class="span12" type="text" name="quantity" id="quantity" /></div>
                                                                        </div>

                                                                        <div class="control-group">
                                                                            <label class="control-label">Taxable:</label>
                                                                            <div class="controls"><label class="checkbox inline"><div id="uniform-undefined" class="checker"><span class="checked"><input style="opacity: 0;" name="taxable" class="style" value="1" id="tax" type="checkbox"></span></div>Checked</label></div>
                                                                        </div>
                                                                        <div class="control-group">
                                                                            <label class="control-label">&nbsp;</label>
                                                                            <div class="controls"><button onClick="manual_sales('<?php echo $cart; ?>')" type="button" class="btn btn-success"><i class="icon-plus-sign"></i> Add Line Item </button></div>
                                                                        </div>
                                                                    </fieldset>
                                                                </form>
                                                            </div>
                                                            <!-- /selects, dropdowns -->
                                                            <!--form tab content end here-->
                                                        </div>
                                                    </div>
                                                    <!--End data tabs -->   

                                                    <!-- General form elements -->


                                                    <!-- General form elements -->
                                                    <!-- /general form elements -->

                                                </div>
                                            </div>
                                        </div>


                                        <!-- General form elements -->

                                        <!--product pos interface end from here-->   




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
            <script type="text/javascript">
                nucleus("select[name='customername']").kendoDropDownList({
                    optionLabel: " -- Select Customer -- "
                }).data("kendoDropDownList").select(0);
            </script>
            <!-- Right sidebar -->
<?php //include('include/sidebar_right.php');    ?>
            <!-- /right sidebar -->

        </div>
        <!-- /main wrapper -->

    </body>
</html>
