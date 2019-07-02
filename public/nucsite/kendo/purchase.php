<?php
include('class/auth.php');
if ($input_status == 3 || $input_status == 4) {
    if (!isset($_GET['edit'])) {
        $obj->Error("Invalid Request.", "purchase_list_order.php");
    }
}
$table="purchase";
if (isset($_POST['create'])) {
    extract($_POST);
    if (!empty($vendor) && !empty($expect_date) && !empty($ship_notes) && !empty($gener_notes)) {
        $order_id=time();
        $issued=0;
        $count_order_product=count($_POST['product_ids']);
        if ($count_order_product != 0) {
            foreach ($_POST['product_ids'] as $index=> $key):
                if ($_POST['quantity'][$index] != 0 || empty($_POST['quantity'][$index])) {
                    $obj->insert("purchase_order_issue", array("order_id"=>$order_id, "pid"=>$key, "quantity"=>$_POST['quantity'][$index], "unit_price"=>$_POST['unitprice'][$index], "retail_price"=>$_POST['retailprice'][$index], "store_id"=>$input_by, "date"=>date('Y-m-d'), "status"=>1));
                    $issued+=1;
                }
            endforeach;
        }

        if ($issued != 0) {

            if ($obj->insert($table, array("order_id"=>$order_id, "vendor"=>$vendor, "store_id"=>$input_by, "expec_date"=>$expect_date, "ship_notes"=>$ship_notes, "gene_notes"=>$gener_notes, "total"=>$total, "date"=>date('Y-m-d'), "status"=>1)) == 1) {
                $obj->Success("Successfully Saved.", $obj->filename());
            }else {
                $obj->Error("Failed To Store Order Record, Try again.", $obj->filename());
            }
        }else {
            $obj->Error("Something is wrong, Try again.", $obj->filename());
        }
    }else {
        $obj->Error("Failed, Please Make Sure You Selected Minimum 1 Product and it's quantity.", $obj->filename());
    }
}


if (isset($_POST['editcreate'])) {
    extract($_POST);
    if (!empty($vendor) && !empty($expect_date) && !empty($ship_notes) && !empty($gener_notes)) {
        if ($obj->update($table, array("id"=>$id, "vendor"=>$vendor, "store_id"=>$input_by, "expec_date"=>$expect_date, "ship_notes"=>$ship_notes, "gene_notes"=>$gener_notes, "total"=>$total, "date"=>date('Y-m-d'), "status"=>$status)) == 1) {
            $obj->Success("Successfully Updated.", $obj->filename() . "?edit=" . $id);
        }else {
            $obj->Error("Something is wrong, Try again.", $obj->filename() . "?edit=" . $id);
        }
    }else {
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
        <?php //echo $obj->bodyhead(); ?>

    </head>
    <script src="js/jquery.min.js"></script>
    <script>
        var nucleuspos = $.noConflict();
        function SaveCustomer()
        {

            var emptyflag = false;
            //var formdata = nucleus('#myForm, #myForms').serializeArray();
            var product = nucleuspos('.product_id').serializeArray();
            var quantity = nucleuspos('.quantity').serializeArray();
            var unitprice = nucleuspos('.unitprice').serializeArray();
            var rowtotal = nucleuspos('.rowtotal').serializeArray();

            var description = nucleuspos('.description').serializeArray();

            jQuery.each(product, function (i, val) {
                if (val.value == "") {
                    emptyflag = true;
                }
            });
            jQuery.each(quantity, function (i, val) {
                if (val.value == "" || val.value == 0) {
                    emptyflag = true;
                }
            });
            jQuery.each(unitprice, function (i, val) {
                if (val.value == "" || val.value == 0) {
                    emptyflag = true;
                }
            });
            jQuery.each(rowtotal, function (i, val) {
                if (val.value == "" || val.value == 0) {
                    emptyflag = true;
                }
            });

            //console.log(emptyflag);

            var invoice_date = $('#invoice_date').val();
            var paid_date = $('#paid_date').val();
            var customer_id = $('#customer_id').val();
            var subheading = $('#subheading').val();
            var shop_id = $('#shop_id').val();
            var memo = $('#memo').val();

            if (invoice_date != "" && paid_date != "" && customer_id != "" && shop_id != "" && emptyflag == false)
            {

                /*					if(journal_entry_check()==0)
                 {
                 $.jGrowl('Invalid Journal Entry.', { sticky: false, theme: 'growl-error', header: 'Invalid Journal Entry!' });
                 }
                 else
                 {*/
                $.jGrowl('Your Sales Invoice is Processing now, Please Wait....', {sticky: false, theme: 'growl-info', header: 'Processing!'});
                $.post("lib/sales.php", {'st': 2,
                    'invoice_date': invoice_date,
                    'paid_date': paid_date,
                    'customer_id': customer_id,
                    'subheading': subheading,
                    'shop_id': shop_id,
                    'memo': memo, 'description': description, 'product': product, 'quantity': quantity, 'unitprice': unitprice, 'rowtotal': rowtotal}, function (data)
                {
                    if (data == 1)
                    {
                        clear();
                        $.jGrowl('Saved, Successfully.', {sticky: false, theme: 'growl-success', header: 'success!'});
                    }
                    else if (data == 2)
                    {
                        $.jGrowl('Failed, Already Exists.', {sticky: false, theme: 'growl-warning', header: 'Error!'});
                    }
                    else
                    {
                        $.jGrowl('Failed, Try Again.', {sticky: false, theme: 'growl-error', header: 'Error!'});
                    }
                });
                /*}*/
            }
            else
            {
                $.jGrowl('Failed, Some Field is Empty.', {sticky: false, theme: 'growl-error', header: 'Error!'});
            }
        }

        function clear()
        {
            $('#invoice_date').val("");
            $('#paid_date').val("");
            $('#customer_id').val("");
            $('#subheading').val("");
            $('#shop_id').val("");
            $('#memo').val("");

            $(".quantity").val("");
            $(".unitprice").val("");
            $(".rowtotal").val("");

            $('.clonerow').hide('slow');
            $('.clonerow').remove();

            checksum(0);

        }


        function checksum(st)
        {
            var quantity = 0.00;
            var unitprice = 0.00;
            var rowtotal = 0.00;
            var aa, bb, cc;

            $(".quantity").each(function () {
                quantity += parseFloat($(this).val().replace(/\s/g, '').replace(',', '.'));
            });

            $(".unitprice").each(function () {
                unitprice += parseFloat($(this).val().replace(/\s/g, '').replace(',', '.'));
            });

            $(".rowtotal").each(function () {
                rowtotal += parseFloat($(this).val().replace(/\s/g, '').replace(',', '.'));
            });

            document.getElementById('total_quantity').value = quantity;
            document.getElementById('totalunitprice').value = unitprice;
            document.getElementById('totalrowtotal').value = rowtotal;
            aa = quantity;
            bb = unitprice;
            cc = rowtotal;
            if (st == 1)
            {
                if (aa == 0 || aa == "" || bb == 0 || bb == "" || cc == 0 || cc == "")
                {
                    return 0;
                }
                else
                {
                    return 1;
                }
            }
        }

        //$().closest(

        nucleuspos(document).ready(function ()
        {
            nucleuspos('#select-customer-id').find('.select2-input').keyup(function () {
                var getvalue = nucleuspos(this).val();
                var getlength = getvalue.length;
                var place = nucleuspos('#select-customer-id').find('select').attr('id');
                nucleuspos('#' + place).html("");
                if (getlength >= 4)
                {
                    $(".select2-no-results").html("wait your data is loading...");
                    $.post("ajax/search_controller.php", {'st': 1, 'table': "account_module_customer", 'search': getvalue, 'field_a': "id", 'field_b': "concat(fname,' ',lname)"}, function (fetch) {
                        var datacl = jQuery.parseJSON(fetch);
                        var opt = datacl.data;
                        nucleuspos('#' + place).html(opt);
                    });
                    checksum(0);
                }
            });

            nucleuspos('#select-customer-id-0').find('.select2-input').keyup(function () {
                var getvalue = nucleuspos(this).val();
                var getlength = getvalue.length;
                var place = nucleuspos('#select-customer-id-0').find('select').attr('id');
                nucleuspos('#' + place).html("");
                if (getlength >= 4)
                {
                    $(".select2-no-results").html("wait your data is loading...");
                    $.post("ajax/search_controller.php", {'st': 1, 'table': "product", 'search': getvalue, 'field_a': "id", 'field_b': "name"}, function (fetch) {
                        var datacl = jQuery.parseJSON(fetch);
                        var opt = datacl.data;
                        nucleuspos('#' + place).html(opt);
                    });
                    checksum(0);
                }
            });



        });

    </script>
    <script>

//        function data(id)
//        {
//            nucleuspos(document).find('.select2-input').keyup(function () {
//                var vald = nucleuspos(this).val();
//                var getvalue = vald;
//                var getlength = getvalue.length;
//                nucleuspos('#select-customer-id-' + id).find('select').html("");
//                if (getlength >= 4)
//                {
//                    $(".select2-no-results").html("wait your data is loading...");
//                    $.post("ajax/search_controller.php", {'st': 1, 'table': "product", 'search': getvalue, 'field_a': "id", 'field_b': "name"}, function (fetch) {
//                        var datacl = jQuery.parseJSON(fetch);
//                        var opt = datacl.data;
//                        nucleuspos('#select-customer-id-' + id).find('select').html(opt);
//                    });
//                    checksum(0);
//                }
//            });
//        }

        function autoselectdata(id, place0, place1, place2, place3, place4)
        {
            //console.log(id+", "+place1+", "+place2+", "+place3+", "+place4);
            $.jGrowl('Please wait, Your Product data is processing now.', {sticky: false, theme: 'growl-success', header: 'Processing!'});
            $.post("ajax/sales.php", {'st': 1, 'id': id}, function (fetch) {
                //console.log(fetch);
                var datacl = nucleuspos.parseJSON(fetch);
                var status = datacl.status;
                var quantity = datacl.quantity;
                var price = datacl.price;
                var description = datacl.description;

                if (status == 1)
                {
                    $.jGrowl('Done, Now you can modify your quantity or price.', {sticky: false, theme: 'growl-success', header: 'Processing!'});
                    nucleuspos("#" + place0).val(id);
                    //console.log(description,quantity,price);
                    //nucleuspos("#" + place1).val(description);
                    nucleuspos("#" + place2).val(quantity);
                    nucleuspos("#" + place3).val(price);
                    checksum(0);
                }
                else
                {
                    $.jGrowl('Failed, Field quantity is empty please select another product.', {sticky: false, theme: 'growl-error', header: 'Error!'});
                }
                checksum(0);
            });
        }

        function autoquantitydata(id, place1, place2, place3, place4)
        {
            //console.log(id+", "+place1+", "+place2+", "+place3+", "+place4);
            $.jGrowl('Please wait, data is processing.', {sticky: false, theme: 'growl-warning', header: 'Processing!'});
            var quantity = id;
            var unitpriceex = nucleuspos("#" + place3).val();
            var qp = quantity * unitpriceex;
            if (quantity != "" || quantity != 0)
            {
                $.jGrowl('Total Row Total, [ ' + quantity + ' X ' + unitpriceex + ' =  ' + qp + '].', {sticky: false, theme: 'growl-success', header: 'Done'});
                nucleuspos("#" + place4).val(qp);
            }
            checksum(0);
        }
        //autounitdata
        function autounitdata(id, place1, place2, place3, place4)
        {
            //console.log(id+", "+place1+", "+place2+", "+place3+", "+place4);
            $.jGrowl('Please wait, data is processing.', {sticky: false, theme: 'growl-warning', header: 'Processing!'});
            var quantity = nucleuspos("#" + place2).val();
            var unitpriceex = id;
            var qp = quantity * unitpriceex;
            if (unitpriceex != "" || quantity != 0)
            {
                $.jGrowl('Total Row Total, [ ' + quantity + ' X ' + unitpriceex + ' =  ' + qp + '].', {sticky: false, theme: 'growl-success', header: 'Done'});
                nucleuspos("#" + place4).val(qp);
            }
            checksum(0);
        }

        function autorowdata(id, place1, place2, place3, place4)
        {
            //console.log(id+", "+place1+", "+place2+", "+place3+", "+place4);
            $.jGrowl('Please wait, data is processing.', {sticky: false, theme: 'growl-warning', header: 'Processing!'});
            var quantity = nucleuspos("#" + place2).val();
            //var unitpriceex=nucleuspos("#"+place3).val();;
            var rowtotal = id;
            var devideacualunit = rowtotal / quantity;
            var newunit = devideacualunit.toFixed(2);
            //console.log(newunit);

            if (rowtotal != "" || rowtotal != 0)
            {
                $.jGrowl('New product unit price, [ ' + rowtotal + ' / ' + quantity + ' =  ' + newunit + '].', {sticky: false, theme: 'growl-success', header: 'Done'});
                nucleuspos("#" + place3).val(newunit);
            }
            checksum(0);
        }


    </script>
    <script>
        function hiderow(id)
        {
            var chkclass = id;
            //alert(chkclass);
            if (chkclass == 'class0')
            {
                alert("You Cann't Remove Table 1st & 2nd Rows");
            }
            else
            {
                var c = confirm("are you sure to Delete this Row From Table ?.");
                if (c)
                {
                    $('.' + id).closest('tr').remove();
                    var increval = cloneCount--;
                    var increvald = cloneCountd--;
                }
            }
        }
    </script>
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
                            <h5><i class="font-cogs"></i> New Purchase Order </h5>
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

                                <?php
                                $editst=FALSE;
                                if ($input_status == 1 || $input_status == 2 || $input_status == 5) {
                                    $editst=FALSE;
                                    ?>
                                    <a href="purchase.php" class="k-button"> <i class="icon-plus-sign"></i> New Purchase Order  </a>
                                    <a href="purchase_list_order.php" class="k-button"> <i class="icon-tasks"></i> List Purchase Order  </a>
                                    <?php
                                }else {
                                    $editst=TRUE;
                                    ?>
                                    <a href="purchase_list_order.php" style="margin-bottom: 10px;" class="k-button"> <i class="icon-tasks"></i> Back To Purchase Order List  </a>
                                    <?php
                                }
                                ?>

                                <!-- Content Start from here customized -->


                                <form class="form-horizontal" method="post" name="invoice" action="">
                                    <fieldset>
                                        <!-- General form elements -->
                                        <?php if (isset($_GET['edit'])) { ?>
                                            <div class="row-fluid  span12 well">
                                                <!-- Selects, dropdowns -->
                                                <div class="span6" style="padding:0px; margin:0px;">

                                                    <div class="control-group">
                                                        <label class="span12"> Vendor </label>
                                                        <input class="span10 k-textbox" <?php if ($editst == TRUE) { ?> readonly="readonly" <?php } ?> value="<?php echo $obj->SelectAllByVal($table, "id", $_GET['edit'], "vendor"); ?>" type="text" name="vendor" />
                                                        <input class="span10 k-textbox" <?php if ($editst == TRUE) { ?> readonly="readonly" <?php } ?>  value="<?php echo $_GET['edit']; ?>" type="hidden" name="id" />
                                                        <input class="span10 k-textbox" <?php if ($editst == TRUE) { ?> readonly="readonly" <?php } ?>  value="<?php echo $_GET['edit']; ?>" type="hidden" name="edit" />
                                                    </div>

                                                    <div class="control-group">
                                                        <label class="span12"> Expected date </label>
                                                        <input size="10"  <?php if ($editst == TRUE) { ?> readonly="readonly" <?php }else { ?>  class="k-datepicker"  <?php } ?>  value="<?php echo $obj->SelectAllByVal($table, "id", $_GET['edit'], "expec_date"); ?>" name="expect_date" type="text">
                                                    </div>


                                                    <div class="control-group">
                                                        <label class="span12"> Shipping notes </label>
                                                        <textarea rows="5"  <?php if ($editst == TRUE) { ?> readonly="readonly" <?php } ?>  cols="5"  name="ship_notes" class="span10 k-textbox"><?php echo $obj->SelectAllByVal($table, "id", $_GET['edit'], "ship_notes"); ?></textarea>
                                                    </div>


                                                </div>
                                                <!-- /selects, dropdowns -->



                                                <!-- Selects, dropdowns -->
                                                <div class="span6" style="padding:0px; margin:0px; float:right;">


                                                    <div class="control-group">
                                                        <label class="span12"> General notes </label>
                                                        <textarea  <?php if ($editst == TRUE) { ?> readonly="readonly" <?php } ?>  rows="5" cols="5" name="gener_notes" class="span10 k-textbox"><?php echo $obj->SelectAllByVal($table, "id", $_GET['edit'], "gene_notes"); ?></textarea>
                                                    </div>

                                                    <div class="control-group">
                                                        <label class="span12"> Total Cost </label>
                                                        <input class="span10 k-textbox"  <?php if ($editst == TRUE) { ?> readonly="readonly" <?php } ?>  type="text" name="total"   value="<?php echo $obj->SelectAllByVal($table, "id", $_GET['edit'], "total"); ?>"  />
                                                    </div>

                                                    <div class="control-group">
                                                        <label class="span12"> Order Status </label>
                                                        <?php $order_status=$obj->SelectAllByVal($table, "id", $_GET['edit'], "status"); ?>
                                                        <select name="status" style="width: 180px;">
                                                            <option <?php if ($order_status == 1) { ?> selected <?php } ?> value="1">Pending</option>
                                                            <option <?php if ($order_status == 2) { ?> selected <?php } ?> value="2">Partial</option>
                                                            <option <?php if ($order_status == 3) { ?> selected <?php } ?> value="3">Completed</option>
                                                        </select>
                                                    </div>

                                                    <div class="control-group">
                                                        <label class="control-label">&nbsp;</label>
                                                        <div class="controls"><button type="submit" name="editcreate" class="k-button"><i class="icon-cog"></i> Update Changes </button></div>
                                                    </div>
                                                </div>
                                                <!-- /selects, dropdowns -->



                                            </div>
                                            <!-- /general form elements -->

                                        <?php }else { ?>
                                            <div class="row-fluid  span12 well">
                                                <!-- Selects, dropdowns -->
                                                <div class="span6" style="padding:0px; margin:0px;">

                                                    <div class="control-group">
                                                        <label class="span12"> Vendor </label>
                                                        <input class="span10 k-textbox" type="text" name="vendor" />
                                                    </div>

                                                    <div class="control-group">
                                                        <label class="span12"> Expected date </label>
                                                        <input type="text" class="k-datepicker"  name="expect_date" />
                                                    </div>


                                                    <div class="control-group">
                                                        <label class="span12"> Shipping notes </label>
                                                        <textarea rows="5" cols="5" name="ship_notes" class="span10 k-textbox"></textarea>
                                                    </div>


                                                </div>
                                                <!-- /selects, dropdowns -->



                                                <!-- Selects, dropdowns -->
                                                <div class="span6" style="padding:0px; margin:0px; float:right;">


                                                    <div class="control-group">
                                                        <label class="span12"> General notes </label>
                                                        <textarea rows="5" cols="5" name="gener_notes" class="span10 k-textbox"></textarea>
                                                    </div>

                                                    <div class="control-group">
                                                        <label class="span12"> Total Cost </label>
                                                        <input class="span10 k-textbox" type="text" name="total" />
                                                    </div>
                                                </div>
                                                <div class="clearfix"></div>

                                                <table class="table table-striped table-bordered"  id="productmore">
                                                    <thead>
                                                        <tr>
                                                            <th>Product</th>
                                                            <th style="text-align:right;">Quantity</th>
                                                            <th style="text-align:right;">Unite Price</th>
                                                            <th style="text-align:right;">Retail Price</th>
                                                            <th style="text-align:right;">Total Price</th>
                                                            <th style="text-align:right;"><input type="hidden" id="currentId"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="POITable">
                                                        <tr class="class0" id="0">
                                                            <td>
                                                                <div class="control-group" id="select-customer-id-0">
                                                                    <input type="hidden" class="product_id" name="product_id[]" id="product_id_0" />
                                                                    <select name="product_ids[]" id="customer_id_0" data-placeholder="Select Product"  onchange="autoselectdata(this.value, 'product_id_0', 'select-description-0', 'select-quantity-0', 'select-unit-0', 'select-rt-0')">
                                                                        <?php
                                                                        if ($input_status == 1) {
                                                                            $sqlproduct=$obj->FlyQuery("SELECT `id`,`name` FROM `product_checkin_inventory`
                                                                                        UNION
                                                                                        SELECT `id`,`name` FROM `product_phone_inventory`
                                                                                        UNION
                                                                                        SELECT `id`,`name` FROM `product_other_inventory`");
                                                                        }else {
                                                                            $sqlproduct=$obj->FlyQuery("SELECT * FROM (SELECT `id`,`name`,`input_by` FROM `product_checkin_inventory`
UNION
SELECT `id`,`name`,`input_by` FROM `product_phone_inventory`
UNION
SELECT `id`,`name`,`input_by` FROM `product_other_inventory`) as alldata WHERE alldata.`input_by`='" . $input_by . "' GROUP BY alldata.`id`");
                                                                        }
                                                                        if (!empty($sqlproduct)) {
                                                                            foreach ($sqlproduct as $product):
                                                                                ?>
                                                                                <option value="<?php echo $product->id; ?>"><?php echo $product->name; ?></option>
                                                                                <?php
                                                                            endforeach;
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </td>
                                                            <td style="text-align:right;">

                                                                <input type="text" class="k-textbox" name="quantity[]" class="quantity"  style="width:50px; text-align:right;font-weight:bolder; "  onkeyup="autoquantitydata(this.value, 'select-description-0', 'select-quantity-0', 'select-unit-0', 'select-rt-0')" name="quantity[]" id="select-quantity-0" value="0">
                                                            </td>
                                                            <td style="text-align:right;">

                                                                <input type="text" class="k-textbox" name="unitprice[]" class="unitprice"  style="width:100px; text-align:right;font-weight:bolder; "  onkeyup="autounitdata(this.value, 'select-description-0', 'select-quantity-0', 'select-unit-0', 'select-rt-0')"  name="opt_a_debit[]" id="select-unit-0" value="0">
                                                            </td>
                                                            <td style="text-align:right;">

                                                                <input type="text" class="k-textbox" name="retailprice[]" class="unitprice"  style="width:100px; text-align:right;font-weight:bolder; "  onkeyup="autounitdata(this.value, 'select-description-0', 'select-quantity-0', 'select-unit-0', 'select-rt-0')"  name="opt_a_debit[]" id="select-unit-0" value="0">
                                                            </td>
                                                            <td style="text-align:right;">
                                                                <input type="text"  class="rowtotal k-textbox" style="width:100px; text-align:right;font-weight:bolder; " name="rowtotal[]"  onkeyup="autorowdata(this.value, 'select-description-0', 'select-quantity-0', 'select-unit-0', 'select-rt-0')" id="select-rt-0"  value="0">
                                                            </td>                                                                 <td><label><a href="#" class="hhdrow" onClick="hiderow('class0')"><i class="icon-remove"></i></a></label></td>
                                                        </tr>
                                                    </tbody>
                                                    <tbody>
                                                        <tr>
                                                            <td align="center">
                                                                <button type="button"  onclick="return addTableRow('#productmore');
                                                                        return false;" id="btn2" class="k-button" ><i class="icon-plus"></i> ADD MORE</button>
                                                            </td>
                                                            <td><input id="total_quantity"  type="text" class="required equalTo small" style="font-weight:bolder; width:100px; background:none; border:0px; text-align:right;" readonly value="0.00" name="total_quantity" /></td>
                                                            <td style="text-align:right;">
                                                                <input type="text" class="required equalTo small" style="font-weight:bolder; width:100px; background:none; border:0px; text-align:right;" readonly value="0.00" name="totalunitprice" id="totalunitprice">
                                                            </td>
                                                            <td style="text-align:right;">
                                                                <input type="text" class="required equalTo small" style="font-weight:bolder; width:100px; background:none; border:0px; text-align:right;" readonly value="0.00" name="totalretailprice" id="totalretailprice">
                                                            </td>
                                                            <td style="text-align:right;">
                                                                <input type="text" class="required equalTo small" style="font-weight:bolder; width:100px; background:none; border:0px; text-align:right;" readonly value="0.00" name="totalrowtotal" id="totalrowtotal">
                                                            </td>                                                               <td></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <div class="control-group">
                                                    <button type="submit" name="create" class="k-button"><i class="icon-cog"></i> Issue Order Now </button>
                                                </div>
                                            </div>
                                            <!-- /general form elements -->
                                        <?php } ?>


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
                
                
                
                nucleus(".k-datepicker").kendoDatePicker({
                    format: "yyyy/MM/dd",
                    animation: false
                  });
                  
                nucleus("select[name='status']").kendoDropDownList({
                    optionLabel: " Please Select Order Status "
                }).data("kendoDropDownList").select(0);
            </script>
            
            
            
            <?php //include('include/footer.php'); ?>
            <!-- Right sidebar -->
            <?php //include('include/sidebar_right.php');        ?>
            <!-- /right sidebar -->

        </div>
        <!-- /main wrapper -->
        <script type="text/javascript">

            var cloneCount = 1;
            var cloneCountd = 0;
            function addTableRow(table)
            {
                var increval = cloneCount++;
                var increvald = cloneCountd++;
                var $tr = $(table + ' tbody:first').children("tr:last").clone().attr("class", 'class' + increval);

                $tr.find("input[type!='hidden'][name*=first_name],select,button").clone();
                $tr.find(".hhdrow").attr("onClick", "hiderow('class" + increval + "')");
                $tr.find("#s2id_customer_id_" + increvald).hide();
                //$tr.find('select').select2();
                $tr.find(".quantity").attr("id", "select-quantity-" + increval);
                $tr.find(".unitprice").attr("id", "select-unit-" + increval);
                $tr.find(".rowtotal").attr("id", "select-rt-" + increval);
                //$(table+' tbody:first').children("tr:last").after($tr);
                $(table + ' tbody:first').children("tr:last").after($tr);
                customize('class' + increval, increval);
            }

            //$().addClass(
            function customize(idclass, incre)
            {
                nucleuspos('.' + idclass).addClass("clonerow");
                nucleuspos('.' + idclass + ' div[0]').attr("id", "select-customer-id-" + incre);
                nucleuspos("#select-customer-id-" + incre).hide();
                nucleuspos('.' + idclass).find('div:first').attr("id", "select-customer-id-" + incre);
                nucleuspos('.' + idclass).find('#select-customer-id-' + incre).find('div').attr("id", "s2id_customer_id_" + incre);
                nucleuspos('.' + idclass).find('.product_id').attr("id", "product_id_" + incre);
                nucleuspos('.' + idclass).find('select').attr("onChange", "autoselectdata(this.value,'product_id_" + incre + "','select-description-" + incre + "','select-quantity-" + incre + "','select-unit-" + incre + "','select-rt-" + incre + "')");
                nucleuspos('.' + idclass).find('.quantity').attr("onKeyUp", "autoquantitydata(this.value,'select-description-" + incre + "','select-quantity-" + incre + "','select-unit-" + incre + "','select-rt-" + incre + "')");
                nucleuspos('.' + idclass).find('.unitprice').attr("onKeyUp", "autounitdata(this.value,'select-description-" + incre + "','select-quantity-" + incre + "','select-unit-" + incre + "','select-rt-" + incre + "')");
                nucleuspos('.' + idclass).find('.rowtotal').attr("onKeyUp", "autorowdata(this.value,'select-description-" + incre + "','select-quantity-" + incre + "','select-unit-" + incre + "','select-rt-" + incre + "')");
                nucleuspos('.' + idclass).bind('click', data(incre));
                //nucleuspos('.'+idclass).find('.select2-container .minimum-select').attr("id","s2id_customer_id_"+incre);
                //nucleuspos('.'+idclass+' div[0]').attr("id","select-customer-id-"+incre);
                //alert(newdaat);
                //
            }


        </script>
    </body>
</html>
