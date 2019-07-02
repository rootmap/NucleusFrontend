<?php
include('class/auth.php');
include('class/pos_class.php');
$obj_pos = new pos();
$table = "product";
$table2 = "sales";
$table3 = "invoice";
//Cell 2 Repair
//
$table4 = "invoice_payment";
$cashier_id = $obj_pos->cashier_id(@$_SESSION['SESS_CASHIER_ID']);
$cashiers_id = $obj_pos->cashier_actual_id(@$_SESSION['SESS_CASHIER_ID']);
$cart = $obj->cart(@$_SESSION['SESS_CART']);

if (isset($_POST['payall'])) {
    extract($_POST);
    include('include/customer_pay_all.php');
    exit();
}

if (@$_GET['lfwspcs']) {
    include('include/pos_lfwspcs.php');
}
if (isset($_GET['caslogoutfrompage'])) {
    $obj->Error("Cashier Can Logout Using This Page .. ", $obj->filename());
}
if (isset($_GET['caslogout'])) {
    $obj_pos->cashier_logout_without_return(@$_SESSION['SESS_CASHIER_ID']);
    header("location:logout.php");
}
if (isset($_GET['logout'])) {
    $obj_pos->cashier_logout(@$_SESSION['SESS_CASHIER_ID']);
}
if (isset($_POST['cashier_login'])) {
    include('include/pos_cashier_login.php');
}
if (isset($_POST['savecus'])) {
    include('include/pos_savecus.php');
}
if (isset($_POST['store_open'])) {
    include('include/pos_store_open.php');
}
if (isset($_POST['storecloseing'])) {
    include('include/pos_storecloseing.php');
}
if (isset($_GET['storecloseingmm'])) {
    include('include/pos_storecloseingmm.php');
}
if (isset($_POST['store_payout'])) {
    include('include/pos_store_payout.php');
}
if (isset($_GET['action'])) {
    include('include/pos_invoice_pdf.php');
}
if (isset($_POST['paidnprint'])) {
    include('include/pos_pay_paidprint.php');
}
if (isset($_POST['onlypaid'])) {
    include('include/pos_pay_onlypaid.php');
}
if (isset($_GET['newsales'])) {
    include('include/pos_newsales.php');
}
if (isset($_GET['newsales_two'])) {
    include('include/pos_newsales_two.php');
}
if (isset($_GET['clearsales'])) {
    include('include/pos_clearsales.php');
}
include('include/pos_taxninvoice_check.php');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
        include './plugin/plugin.php';
        $cms = new CmsRootPlugin();
        echo $cms->GeneralCss(array("kendo", "modal"));
        ?>
        <script src="ajax/ajax.js"></script>
        <script src="ajax/pos_ajax.js"></script>
        <script>

            $.ajaxSetup({cache: false});
            function cusid(cid, cart)
            {
                if (cid == "")
                {
                    document.getElementById("mss").innerHTML = "";
                    return;
                }
                if (window.XMLHttpRequest) {
                    // code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp = new XMLHttpRequest();
                } else { // code for IE6, IE5
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function () {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        $("#mss").fadeOut();
                        $("#mss").fadeIn();
                        document.getElementById("mss").innerHTML = xmlhttp.responseText;
                    }
                }
                st = 3;
                xmlhttp.open("GET", "ajax/setversion.php?st=" + st + "&cid=" + cid + "&cart=" + cart, true);
                xmlhttp.send();
            }



            function reload_pos_page() {
                location.reload();
            }

        </script>

        <script>
            function paid_method(method, paid, total_amount)
            {
                //alert('Payment Method');
                if (method == 6)
                {
                    /*var cash=$('#pam').val();
                     var credit=$('#pamc').val();
                     
                     $('#ddue').val()=total_amount-(cash+credit);*/
                    cash = document.getElementById('pam').value;
                    credit = document.getElementById('pamc').value;
                    document.getElementById('ddue').value = total_amount - ((cash - 0) + (credit - 0) + (paid - 0));
                }
                else
                {
                    cash = document.getElementById('pam').value;
                    document.getElementById('ddue').value = total_amount - ((cash - 0) + (paid - 0));
                }
            }
        </script>

        <script>
            function loadblankpage(invoice)
            {
<?php
$chk = $obj->exists_multiple("invoice_payment", array("invoice_id" => $cart));
if ($chk != 0) {
    ?>
                    setTimeout(window.open("pos.php?newsales=1"), 5000);
    <?php
} else {
    ?>
                    setTimeout(window.open("pos.php?refresh"), 5000);
    <?php
}
?>
            }



        </script>
        <?php
        if (isset($_GET['refresh'])) {
            ?>
            <meta http-equiv="refresh" content="5;url=<?php echo $obj->baseUrl($obj->filename()); ?>">
            <?php
        }
        ?>
        <script language="javascript" type="text/javascript">

        </script>
        <script>
            function store_close_report()
            {

                //alert("Cart ID : ");
                var dfs = "<img src='images/loader-big.gif' />";
                $('#store_close_report').html(dfs);

                param1 = {'fetch': 1};
                $.post('store_close.php', param1, function (res1) {
                    $('#store_close_report').html(res1);
                });
            }
        </script>
        <script type="text/javascript">
            function salesRowLiveEdit(sales_string_id)
            {
                var sales_id = $('#' + sales_string_id).closest('td').attr('id');
                var sales_invoice_id = $('#' + sales_string_id).closest('td').attr('class');
                var sales_amount = $('#' + sales_string_id).attr('title');
                //alert(sales_id);
                var getquantity = $('#quantity' + sales_id).html();
                $('#' + sales_id).html('<input size="5"  class=' + sales_invoice_id + ' type="text" name="' + sales_id + '" value="' + sales_amount + '" id="sales_price' + sales_id + '" >');
                $('#quantity' + sales_id).html('<input size="5"  class=' + sales_invoice_id + ' type="text" name="' + sales_id + '" value="' + getquantity + '" id="sales_quantity' + sales_id + '" >');
                $('#update' + sales_id).fadeIn('slow');

            }

            function updateSalesData(sales_id, sales_invoice_id)
            {
                var new_sales_amount = $('#sales_price' + sales_id).val();
                var new_sales_quantity = $('#sales_quantity' + sales_id).val();
                parama = {'sales_id': sales_id, 'sales_amount': new_sales_amount, 'sales_quantity': new_sales_quantity};
                $.post('ajax/update_sales_row.php', parama, function (data) {
                    if (data == 0)
                    {
                        location.refresh();
                    }
                    else
                    {
                        $("#msg").fadeOut();
                        $("#msg").fadeIn();
                        document.getElementById("msg").innerHTML = data;
                    }
                });

                param1 = {'sales_id': sales_invoice_id};
                $.get('ajax/load_sales_list.php', param1, function (data) {
                    $("#sales_list").fadeOut();
                    $("#sales_list").fadeIn();
                    document.getElementById("sales_list").innerHTML = data;
                });

                param2 = {'sales_id': sales_invoice_id};
                $.get('ajax/load_sales_list_cal.php', param2, function (data) {
                    $("#subtotal_list").fadeOut();
                    $("#subtotal_list").fadeIn();
                    document.getElementById("subtotal_list").innerHTML = data;
                });

                alert('Price Changed Successfully');


            }

            function PrintFromPos(id)
            {
                if (id == 1)
                {
                    $("#paidnprint").click();
                }
                else if (id == 2)
                {
                    $("#paidnprint").click();
                }
                else if (id == 3)
                {
                    $("#paidnprint").click();
                }
            }


        </script>
    </head>

    <bod
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
                            <h5><i class="font-money"></i>POS  (Sales - <?php echo $cart; ?> ) : Cashier Id - <?php echo $cashiers_id; ?> <span id="msg" style="float:right; margin-left:50px;"></span></h5>
                            <ul class="icons">
                                <li><a href="<?php echo $obj->filename(); ?>" class="hovertip" title="Reload"><i class="font-refresh"></i></a></li>
                            </ul>
                        </div><!-- /page header -->

                        <div class="body">

                            <!-- Middle navigation standard -->
                            <?php //include('include/quicklink.php');     ?>
                            <!-- /middle navigation standard -->

                            <!-- Content container -->
                            <div class="container">




                                <!-- Content Start from here customized -->
                                <div class="block span6">

                                    <!--<a href="#" class="btn btn-success"><i class="icon-ok-sign"></i>Save Invoice</a>
                                    <a href="#" class="btn btn-danger"><i class="icon-trash"></i> Delete Invoice & All Record</a>
                                    <a href="#" class="btn btn-primary"><i class="icon-edit"></i> Edit Invoice</a>
                                    <a href="#" class="btn btn-warning"><i class="icon-print"></i> Print Invoice</a>
                                    <a href="#" class="btn btn-info"><i class="icon-bell"></i >Clone</a>
                                    <a href="#" class="btn btn-success"><i class="icon-screenshot"></i> Quick Payment</a>
                                    <a href="#" class="btn btn-success"><i class="icon-screenshot"></i> Payment</a>

                                    -->

                                    <!-- Action buttons -->
                                    <div class="row-fluid">

                                        <!-- button pos settings-->
                                        <div class="btn-group" style="margin-top: -3px;">
                                            <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Pos Page Setting <span class="caret dd-caret"></span></button>
                                            <ul class="dropdown-menu">
                                                <li><a onclick="javascript:return confirm('Are your sure to regenerate new sales ID# ?')"  href="<?php echo $obj->filename(); ?>?newsales_two"><i class="font-barcode"></i> Make New Sales ID</a></li>
                                                <li><a onclick="javascript:return confirm('Are your sure to clear POS screen with new sales ID# ?')"  href="<?php echo $obj->filename(); ?>?newsales_two"><i class="font-refresh"></i> Clear POS Screen</a></li>
                                                <?php if ($cashier_id == 1) { ?>
                                                    <li><a  data-toggle="modal" href="#myModal4"><i class="font-time"></i> Time Clock </a></li>
                                                    <li><a  data-toggle="modal" href="#logout"><i class="font-lock"></i> Logout From Pos</a></li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                        <!-- buttons pos settings end-->

<!--                                        <a href="<?php //echo $obj->filename();                                      ?>?newsales_two" class="btn btn-danger"><i class="icon-ok-sign"></i> Make New Sales</a>
                                        <a href="<?php //echo $obj->filename();                                     ?>?newsales_two" class="btn btn-success"><i class="icon-check"></i> Clear POS</a>-->

                                        <?php
                                        if ($cashiers_id != 0) {
                                            $chkopenstore = $obj->exists_multiple("store_open", array("sid" => $input_by, "status" => 1));
                                            if ($chkopenstore == 1) {
                                                ?>
                                                <span id="stccash">
                                                    <!--                                                <a data-toggle="modal" href="#logout_store_close" class="btn btn-danger">
                                                                                                        <i class="icon-off"></i> Close Store
                                                                                                    </a>-->

                                                    <a  onClick="store_close_confirm(<?php echo $cashiers_id; ?>)"  href="#" class="btn btn-warning">
                                                        <i class="icon-off"></i> Close Store Detail
                                                    </a>

                                                </span>
                                                <!-- Dialog content -->
                                                <!-- href="#logout_store_close"  myModal3-->
                                                <div id="logout_store_close" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                        <h5 id="myModalLabel"> <i class="icon-inbox"></i> Cashier Login to confirm | Close Store </h5>
                                                    </div>
                                                    <div class="modal-body">

                                                        <div class="row-fluid">

                                                            <div class="control-group">
                                                                <label class="control-label"> Username  </label>
                                                                <div class="controls">
                                                                    <input type="text" id="strurs" placeholder="Username" class="span6" name="username">
                                                                </div>
                                                            </div>

                                                            <div class="control-group">
                                                                <label class="control-label"> Password  </label>
                                                                <div class="controls">
                                                                    <input type="password" id="strpass" placeholder="Password" class="span6" name="password">
                                                                </div>
                                                            </div>
                                                            <div class="control-group" id="mss"></div>
                                                        </div>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="reset" style="float:left;" class="btn btn-warning"  name="reset">Clear </button>
                                                        <button type="button" style="float:left;" onClick="store_close_confirm2('<?php echo $cashiers_id; ?>', '1')" class="btn btn-info"  name="cashier_login">Login </button>
                                                    </div>
                                                </div>

                                                <div id="logout_store_close_n_p" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                        <h5 id="myModalLabel"> <i class="icon-inbox"></i> Cashier Login to confirm | Close Store & Print </h5>
                                                    </div>
                                                    <div class="modal-body">

                                                        <div class="row-fluid">

                                                            <div class="control-group">
                                                                <label class="control-label"> Username  </label>
                                                                <div class="controls">
                                                                    <input type="text" id="strurs_n_p" placeholder="Username" class="span6" name="username">
                                                                </div>
                                                            </div>

                                                            <div class="control-group">
                                                                <label class="control-label"> Password  </label>
                                                                <div class="controls">
                                                                    <input type="password" id="strpass_n_p" placeholder="Password" class="span6" name="password">
                                                                </div>
                                                            </div>
                                                            <div class="control-group" id="mss_n_p"></div>
                                                        </div>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="reset" style="float:left;" class="btn btn-warning"  name="reset">Clear </button>
                                                        <button type="button" style="float:left;" onClick="store_close_confirm2('<?php echo $cashiers_id; ?>', '2')" class="btn btn-info"  name="cashier_login">Login </button>
                                                    </div>
                                                </div>
                                                <!-- /dialog content -->
                                                <!-- Dialog content -->
                                                <?php
                                                include('include/store_close.php');
                                                ?>




                                                <a  data-toggle="modal" href="#myModal44" class="btn btn-info"><i class="icon-tags"></i> Payout </a>
                                                <!-- Dialog content -->
                                                <div id="myModal44" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                    <form class="form-horizontal" method="post" action="">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                            <h5 id="myModalLabel"> <i class="icon-inbox"></i> Payout/Drop Deatil <span id="mss"></span></h5>
                                                        </div>
                                                        <div class="modal-body">

                                                            <div class="row-fluid">

                                                                <div class="control-group">
                                                                    <label class="control-label"> Amount </label>
                                                                    <div class="controls">
                                                                        <input class="span6" type="text" id="cash" name="cash" placeholder="Amount" /></div>
                                                                </div>
                                                                <div class="control-group">
                                                                    <label class="control-label"> Reason </label>
                                                                    <div class="controls">
                                                                        <textarea class="span6" type="text" id="reason" name="reason" placeholder="Reason"></textarea></div>
                                                                </div>
                                                                <div class="control-group">
                                                                    Enter a negative amount if removing cash from the drawer, enter a positive amount if adding cash to the drawer.
                                                                </div>

                                                            </div>

                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary"  name="store_payout">Save</button>
                                                        </div>
                                                    </form>
                                                </div>
                                                <!-- /dialog content -->
                                                <?php
                                            } else {
                                                ?>
                                                 <!--<a  data-toggle="modal" href="#myModal3" class="btn btn-success"><i class="icon-inbox"></i> Open Store </a>-->
                                                <span id="oopencash">
                                                    <a  onClick="store_open_confirm(<?php echo $cashiers_id; ?>)"  href="#" class="btn btn-warning">
                                                        <i class="icon-inbox"></i> Open Store
                                                    </a>
                                                </span>

                                                <!-- href="#logout_store_close"  myModal3-->
                                                <div id="login_store_open" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                        <h5 id="myModalLabel"> <i class="icon-inbox"></i> Cashier Login to confirm | Store Open </h5>
                                                    </div>
                                                    <div class="modal-body">

                                                        <div class="row-fluid">

                                                            <div class="control-group">
                                                                <label class="control-label"> Username  </label>
                                                                <div class="controls">
                                                                    <input type="text" id="stturs" placeholder="Username" class="span6" name="username">
                                                                </div>
                                                            </div>

                                                            <div class="control-group">
                                                                <label class="control-label"> Password  </label>
                                                                <div class="controls">
                                                                    <input type="password" id="sttpass" placeholder="Password" class="span6" name="password">
                                                                </div>
                                                            </div>
                                                            <div class="control-group" id="tss"></div>
                                                        </div>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="reset" style="float:left;" class="btn btn-warning"  name="reset">Clear </button>
                                                        <button type="button" style="float:left;" onClick="store_open_confirm(<?php echo $cashiers_id; ?>)" class="btn btn-info"  name="cashier_login">Login </button>
                                                    </div>
                                                </div>
                                                <!-- /dialog content -->

                                                <!-- Dialog content -->
                                                <div id="myModal3" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                    <form class="form-horizontal" method="post" action="">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                            <h5 id="myModalLabel"> <i class="icon-inbox"></i> Open Store <span id="mss"></span></h5>
                                                        </div>
                                                        <div class="modal-body">

                                                            <div class="row-fluid">

                                                                <span> <strong>Store Opening Amount</strong> </span>

                                                                <div class="control-group">
                                                                    <label class="control-label"> Cash </label>
                                                                    <div class="controls">

                                                                        <input class="span6" type="text" id="cash" name="cash" placeholder="Cash Amount" /></div>
                                                                </div>
                                                                <div class="control-group">
                                                                    <label class="control-label"> Credit Card </label>
                                                                    <div class="controls">
                                                                        <input class="span6" type="text" id="square" name="square" placeholder="Credit Card Amount" /></div>
                                                                </div>



                                                            </div>

                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary" name="store_open"> Open Store </button>
                                                        </div></form>
                                                </div>
                                                <!-- /dialog content -->
                                                <?php
                                            }
                                        }
                                        ?>
                                        <?php if ($cashiers_id == 0) { ?><a  data-toggle="modal" href="#myModal4" class="btn btn-info"><i class="icon-unlock"></i>  Cashier Login Here </a><?php } ?>


                                        <!-- Dialog content -->
                                        <div id="myModal4" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <form class="form-horizontal" method="post" action="">
                                                <?php if ($obj_pos->cashier_login(@$_SESSION['SESS_CASHIER_ID']) == 1) { ?>
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                        <h5 id="myModalLabel"> <i class="icon-inbox"></i> Time Clock <span id="mss"></span></h5>
                                                    </div>
                                                    <div class="modal-body">

                                                        <div class="row-fluid">

                                                            <div class="control-group">
                                                                <label class="control-label"> Date Time </label>
                                                                <div class="controls">
                                                                    <input size="10" readonly id="indate"  value="<?php echo date('Y-m-d'); ?>" class="datepicker" type="text"> 
                                                                    <button type="button" style="margin-left: 20px;" class="btn btn-primary" onClick="punchin()"  name="store_open">Punch</button>
                                                                </div>
                                                                
                                                               
                                                        
                                                            </div>
                                                            <div class="clearfix"></div>
                                                        </div>
                                                        <div class="row-fluid">

                                                            <div id="cashiergrid" style="margin-left: 10px;margin-right: 10px;"></div>

                                                            <script type="text/javascript">
                                                                var gridElement = $("#cashiergrid");
                                                                function showLoading(e) {
                                                                    kendo.ui.progress(gridElement, true);
                                                                }
                                                                function restoreSelection(e) {
                                                                    kendo.ui.progress(gridElement, false);
                                                                }
                                                                jQuery(document).ready(function () {
                                                                    var dataSource = new kendo.data.DataSource({
                                                                        requestStart: showLoading,
                                                                        transport: {
                                                                            read: {
                                                                                url: "./controller/punch_in_out.php?cashier_id=<?php echo $_SESSION['SESS_CASHIER_ID']; ?>",
                                                                                type: "GET",
                                                                                datatype: "json"
                                                                            }
                                                                        },
                                                                        autoSync: false,
                                                                        schema: {
                                                                            data: "data",
                                                                            total: "total",
                                                                            model: {
                                                                                id: "id",
                                                                                fields: {
                                                                                    id: {nullable: true, editable: false},
                                                                                    cashier_id: {type: "number"},
                                                                                    cashier: {type: "string"},
                                                                                    indate: {type: "string"},
                                                                                    intime: {type: "string"},
                                                                                    outdate: {type: "string"},
                                                                                    outtime: {type: "string"},
                                                                                    elapsed_time: {type: "string", editable: false},
                                                                                    status: {type: "number"}
                                                                                }
                                                                            }



                                                                        },
                                                                        pageSize: 10,
                                                                        serverPaging: true,
                                                                        serverFiltering: true,
                                                                        serverSorting: true
                                                                    });



                                                                    jQuery("#cashiergrid").kendoGrid({
                                                                        dataSource: dataSource,
                                                                        filterable: true,
                                                                        dataBound: restoreSelection,
                                                                        pageable: {
                                                                            refresh: true,
                                                                            input: true,
                                                                            numeric: false,
                                                                            pageSizes: true,
                                                                            pageSizes:[10, 50, 200, 500, 1000, 5000, 10000]
                                                                        },
                                                                        sortable: true,
                                                                        groupable: true,
                                                                        columns: [
                                                                            {field: "indate", title: "indate"},
                                                                            {field: "intime", title: "intime", format: "{0:hh:mm:ss tt}"},
                                                                            {field: "outdate", title: "outdate"},
                                                                            {title: "outtime", field: "outtime", format: "{0:hh:mm:ss tt}"},
                                                                            {field: "elapsed_time", title: "Elapsed Time"}
                                                                        ]
                                                                    });
                                                                });

                                                            </script>


                                                            <?php /* $chkpunch = $obj->exists_multiple("store_punch_time", array("sid" => $input_by, "date" => date('Y-m-d')));
                                                              if ($chkpunch != 0) {
                                                              ?>
                                                              <div class="table-overflow">
                                                              <table class="table table-striped">
                                                              <thead>
                                                              <tr>
                                                              <th>Date IN</th>
                                                              <th>Time In</th>
                                                              <th>Date Out</th>
                                                              <th>Time Out</th>
                                                              <th>Elapsed Time (HH:MM)</th>
                                                              </tr>
                                                              </thead>
                                                              <tbody>
                                                              <?php
                                                              $sql_product = $obj->SelectAllByID_Multiple("store_punch_time", array("sid" => $input_by, "date" => date('Y-m-d'), "cashier_id" => $cashier_id));
                                                              $i = 1;
                                                              if (!empty($sql_product))
                                                              foreach ($sql_product as $product):
                                                              ?>
                                                              <tr>
                                                              <td><?php echo $product->indate; ?></td>
                                                              <td><?php echo $product->intime; ?></td>
                                                              <td><?php echo $product->outdate; ?></td>
                                                              <td><?php echo $product->outtime; ?></td>
                                                              <td>
                                                              <?php
                                                              if ($product->outdate != '') {
                                                              echo $obj->durations($product->indate . " " . $product->intime, $product->outdate . " " . $product->outtime);
                                                              }
                                                              ?>
                                                              </td>
                                                              </tr>
                                                              <?php
                                                              $i++;
                                                              endforeach;
                                                              ?>
                                                              </tbody>
                                                              </table>
                                                              </div>
                                                              <?php } */ ?>
                                                        </div>

                                                    </div>
                                                    <div class="modal-footer">
                                                        
                                                    </div>
                                                    <?php } else { ?>
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                        <h5 id="myModalLabel"> <i class="icon-inbox"></i> Cashier Login <span id="mss"></span></h5>
                                                    </div>
                                                    <div class="modal-body">

                                                        <div class="row-fluid">

                                                            <div class="control-group">
                                                                <label class="control-label"> Username  </label>
                                                                <div class="controls">
                                                                    <input type="text" placeholder="Username" class="span6" name="username">
                                                                </div>
                                                            </div>

                                                            <div class="control-group">
                                                                <label class="control-label"> Password  </label>
                                                                <div class="controls">
                                                                    <input type="password" placeholder="Password" class="span6" name="password">
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="reset" style="float:left;" class="btn btn-warning"  name="reset">Clear </button>
                                                        <button type="Submit" style="float:left;" class="btn btn-info"  name="cashier_login">Login </button>
                                                    </div>
<?php } ?>
                                            </form>
                                        </div>
                                        <!-- /dialog content -->


                                        <!-- Dialog content -->

                                        <!-- /dialog content -->

                                        <!-- Dialog content -->
                                        <div id="logout" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <form class="form-horizontal" method="post" action="">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    <h5 id="myModalLabel"> <i class="icon-inbox"></i> Please Login To Logout From Cash Counter  <span id="mss"></span></h5>
                                                </div>
                                                <div class="modal-body">

                                                    <div class="row-fluid">

                                                        <div class="control-group">
                                                            <label class="control-label"> Username  </label>
                                                            <div class="controls">
                                                                <input type="text" placeholder="Username" class="span6" name="username">
                                                            </div>
                                                        </div>

                                                        <div class="control-group">
                                                            <label class="control-label"> Password  </label>
                                                            <div class="controls">
                                                                <input type="password" placeholder="Password" class="span6" name="password">
                                                                <input type="hidden" name="logval" value="2">
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="reset" style="float:left;" class="btn btn-warning"  name="reset">Clear </button>
                                                    <button type="Submit" style="float:left;" class="btn btn-info"  name="cashier_login">Login </button>
                                                </div>
                                            </form>
                                        </div>
<?php
$invoice_cid = $obj->SelectAllByVal($table3, "invoice_id", $cart, "cid");
?>
                                        <?php if ($cashier_id == 1) { ?>

                                            <a data-toggle="modal" href="#myModal1" class="btn btn-danger"><i class="icon-list-alt"></i> Change Tax </a>
                                            <div class="pull-right">
                                                <label class="label label-info">  Change Customer   
                                                    <span class="controls" id="NCP" style="margin-left:20px;">
                                                        <select name="custo" style="width:170px;" onChange="new_customer(this.value, '<?php echo $cart; ?>')" id="customername">
    <?php
    if ($input_status == 1) {
        $sqlpdata = $obj->FlyQuery("SELECT id,firstname,lastname FROM coustomer");
    } else {
        $sqlpdata = $obj->FlyQuery("SELECT id,firstname,lastname FROM coustomer WHERE input_by='$input_by'");
    }
//$sqlpdata = $obj->SelectAll("coustomer");
    if (!empty($sqlpdata))
        foreach ($sqlpdata as $row):
            ?>
                                                                    <option <?php if ($invoice_cid == $row->id) { ?> selected <?php } ?> onclick="cusid(this.value, '<?php echo $cart; ?>')" value="<?php echo $row->id; ?>">
                                                                    <?php echo $row->firstname . " " . $row->lastname; ?>
                                                                    </option>
                                                                    <?php endforeach; ?>
                                                            <option value="0">Add New Customers</option>
                                                        </select>

                                                    </span>
                                                </label>
                                            </div>    
<?php } ?>

                                        <!-- /dialog content -->
                                    </div>



                                    <!-- /action buttons -->

                                </div>
                                <fieldset>
                                    <div id="store_close_message"></div>


                                    <div class="well row-fluid span12">

                                        <div class="row-fluid">
                                            <div style="padding: 5px;" class="span4 pull-left">
                                                <div action="#" class="search-block">
                                                    <button type="button" name="find" value="" class="btn"><span class="icon-barcode"></span></button>
                                                    <input  onkeyup="DelayedSubmissionBarcode()" type="text" name="searchb" class="jquery-autocomplete" placeholder="Search with Barcode" />
                                                    <ul id="searchBResult" class="typeahead dropdown-menu" style="top: 30px; left: 0px; display: none; width:91%;">
                                                    </ul>
                                                </div>
                                            </div> 

                                            <div style="padding: 5px;" class="span5 pull-right">
                                                <div  class="search-block">
                                                    <input  onkeyup="DelayedSubmission()" type="text" name="searchp" placeholder="Search with Product Name" />
                                                    <button type="button" name="find" value="" class="btn"><span class="search"></span></button>
                                                    <ul id="searchResult" class="typeahead dropdown-menu" style="top: 30px; left: 0px; display: none; width:91%;">
                                                    </ul>
                                                </div>
                                            </div> 
                                        </div>
                                    </div>



                                    <div class="clearfix"></div>

                                    <div class="row-fluid block">



                                        <div class="well row-fluid span12">
                                            <div class="tabbable">
                                                <!--start ul tabs -->
                                                <ul class="nav nav-tabs">
                                                    <li class="active"><a id="large" href="#tab1" data-toggle="tab">Main</a></li>
                                                    <li><a id="small" href="#tab2" data-toggle="tab">Page 2 ( 0 - 100 )</a></li>
                                                    <li><a id="small" href="#tab201" data-toggle="tab">Phone Inventory</a></li>
                                                    <li><a id="small" href="#tab3" data-toggle="tab">Barcode</a></li>
                                                    <li><a id="small" href="#tab4" data-toggle="tab"> Inventory </a></li>
                                                    <li><a id="small" href="#tab5" data-toggle="tab"> Manualy </a></li>
                                                    <li><a id="small" href="#tab6" data-toggle="tab"> Reoccurring Invoice </a></li>
                                                </ul>
                                                <!--end ul tabs -->
                                                <!--start data tabs -->
                                                <div class="tab-content">




                                                    <div style="width: 0px;" class="tab-pane active" id="tab1">
                                                        <!--tab 1 content start from here-->
                                                        <!-- Selects, dropdowns -->

                                                        <!-- /selects, dropdowns -->

                                                        <!--tab 1 content start from here-->
                                                    </div>
                                                    <div class="tab-pane" id="tab2">

                                                        <!-- Selects, dropdowns -->
                                                        <div class="span6 well" style="padding:0px; margin:0px;">
                                                            <div class="control-group">
                                                                <label class="control-label">Item :</label>
                                                                <div class="controls">
                                                                    <select name="snd_pids" id="snd_pids"  style="width:200px;">
<?php
if ($input_status == 1) {
    $sqlproduct_pos_nd = $obj_pos->SelectAllOnlyLimit("product_other_inventory", "0", "100");
} else {
    $sqlproduct_pos_nd = $obj_pos->SelectAllOnlyOneCondLimit("product_other_inventory", "input_by", $input_by, "0", "100");
}
if (!empty($sqlproduct_pos_nd))
    foreach ($sqlproduct_pos_nd as $row):
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
                                                                <div class="controls"><input class="span2" value="1" type="number" name="regular" id="snd_quan" /></div>
                                                            </div>
                                                            <div class="control-group">
                                                                <label class="control-label">&nbsp;</label>
                                                                <div class="controls"><button onClick="snd_inventory_sales('<?php echo $cart; ?>')" type="button" class="btn btn-success"><i class="icon-plus-sign"></i> Add To Invoice </button></div>
                                                            </div>
                                                        </div>

                                                        <!-- /selects, dropdowns -->




                                                        <!--tab 2 content start from here-->

                                                    </div>
                                                    <div class="tab-pane" id="tab201">

                                                        <!--tab 2 content start from here-->
                                                        <!-- Selects, dropdowns -->
                                                        <div class="span6 well" style="padding:0px; margin:0px;">
                                                            <div class="control-group">
                                                                <label class="control-label">Item :</label>
                                                                <div class="controls">
                                                                    <select name="phone_pids" id="phone_pids"  style="width:300px;">
<?php
if ($input_status == 1) {
    $sqlproduct_phone = $obj_pos->SelectAllOnlyLimit("product_phone_inventory", "0", "300");
} else {
    $sqlproduct_phone = $obj_pos->SelectAllOnlyOneCondLimit("product_phone_inventory", "input_by", $input_by, "0", "300");
}
if (!empty($sqlproduct_phone))
    foreach ($sqlproduct_phone as $row):
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
                                                                <div class="controls"><input class="span2" value="1" type="number" name="regular" id="phone_quan" /></div>
                                                            </div>
                                                            <div class="control-group">
                                                                <label class="control-label">&nbsp;</label>
                                                                <div class="controls"><button onClick="phone_inventory_sales('<?php echo $cart; ?>')" type="button" class="btn btn-success"><i class="icon-plus-sign"></i> Add To Invoice </button></div>
                                                            </div>
                                                        </div>
                                                        <!-- /selects, dropdowns -->


                                                        <!--tab 2 content start from here-->

                                                    </div>
                                                    <div class="tab-pane" id="tab3">
                                                        <!--barcode tab content start from here-->
                                                        <!-- Selects, dropdowns -->
                                                        <div class="span6 well" style="padding:0px; margin:15px 0px 0px 0px;">
                                                            <!--                                                            <div class="navbar">
                                                                                                                            <div class="navbar-inner">
                                                                                                                                <h5><i class="icon-barcode"></i> Add From Barcode</h5>
                                                                                                                            </div>
                                                                                                                        </div>-->
                                                            <div class="control-group">
                                                                <label class="control-label">UPC Code :</label>
                                                                <div class="controls"><input class="span4" id="barcode_reader_place" type="text" name="regular"  onKeydown="Javascript: if (event.keyCode == 13)
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
                                                        <div class="span6 well" style="padding:0px; margin:0px;">

                                                            <div class="control-group">
                                                                <label class="control-label">Item :</label>
                                                                <div class="controls">
                                                                    <select name="pids" id="pids"    style="width:300px;">
<?php
if ($input_status == 1) {
    $sqlpdata = $obj->SelectAll($table);
} else {
    $sqlpdata = $obj->SelectAllByID($table, array("input_by" => $input_by));
}
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
                                                        <div class="span6 well" style="padding:0px; margin:0px;">

                                                            <form method="get" action="" name="manual">
                                                                <fieldset>
                                                                    <div class="control-group">
                                                                        <label class="control-label">Item:</label>
                                                                        <div class="controls">
                                                                            <select name="pid" id="pid"   style="width:300px;">
<?php
if ($input_status == 1) {
    $sqlpdata = $obj->SelectAll($table);
} else {
    $sqlpdata = $obj->SelectAllByID($table, array("input_by" => $input_by));
}
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


                                                    <div class="tab-pane" id="tab6">
                                                        <!--form tab content start here-->
                                                        <!-- Selects, dropdowns -->
                                                        <div class="span6 well" style="padding:0px; margin:0px;">

                                                            <form method="get" action="" name="manual">
                                                                <fieldset>
                                                                    <div class="control-group">
                                                                        <label class="control-label">Item <span style="color: #F00;">*</span>:</label>
                                                                        <div class="controls">
                                                                            <select name="pid" id="pidi"   style="width:300px;">
<?php
if ($input_status == 1) {
    $sqlpdata = $obj->FlyQuery("SELECT id,name FROM product WHERE status='6'");
} else {
    $sqlpdata = $obj->FlyQuery("SELECT id,name FROM product WHERE status='6' AND input_by='" . $input_by . "'");
}
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
                                                                        <div class="controls">
                                                                            <textarea class="span12" name="descc" id="descc"></textarea>
                                                                        </div>
                                                                    </div>

                                                                    <div class="control-group">
                                                                        <label class="control-label">Frequency <span style="color: #F00;">*</span>:</label>
                                                                        <div class="controls">
                                                                            <select name="frequency" id="frequency"   style="width:300px;">
                                                                                <option value="1">Monthly</option>
                                                                                <option value="2">Weekly</option>
                                                                                <option value="3">Biweekly</option>
                                                                                <option value="4">Quarterly</option>
                                                                                <option value="5">Semi-Annually</option>
                                                                                <option value="6">Annually</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    <div class="control-group">
                                                                        <label class="control-label">Start Date <span style="color: #F00;">*</span>:</label>
                                                                        <div class="controls"><input  id="startdate" type="text" name="startdate" /></div>
                                                                    </div>

                                                                    <div class="control-group">
                                                                        <label class="control-label">Notes:</label>
                                                                        <div class="controls">
                                                                            <textarea class="span12" name="notes" id="notes"></textarea>
                                                                        </div>
                                                                    </div>

                                                                    <div class="control-group">
                                                                        <label class="control-label"><input  name="auto_charged" class="style" value="1" id="auto_charged" type="checkbox">  Auto Charged Card</label>
                                                                    </div>
                                                                    <div class="control-group">
                                                                        <label class="control-label">&nbsp;</label>
                                                                        <div class="controls"><button onClick="recurring_sales('<?php echo $cart; ?>')" type="button" class="btn btn-success"><i class="icon-plus-sign"></i> Add Reoccurring Invoice Item </button></div>
                                                                    </div>
                                                                </fieldset>
                                                            </form>
                                                        </div>
                                                        <!-- /selects, dropdowns -->
                                                        <!--form tab content end here-->
                                                    </div>



                                                    <div id="trsdiv" style="margin-left: 0px;" class="span12 row-fluid well">
<?php
include './include/transaction_page.php';
?>                                                            
                                                    </div>










                                                </div>
                                                <!--End data tabs -->
                                            </div>
                                        </div>
                                        <!-- General form elements -->






                                        <!-- General form elements -->

                                        <!-- /general form elements -->






                                        <div class="clearfix"></div>

                                        <!-- Default datatable -->

                                        <!-- /default datatable -->


                                </fieldset>



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

            <script language="javascript" type="text/javascript">
                function DelayedSubmission() {
                    var date = new Date();
                    initial_time = date.getTime();
                    if (typeof setInverval_Variable == 'undefined') {
                        setInverval_Variable = setInterval(DelayedSubmission_Check, 50);
                    }
                }

                function DelayedSubmissionBarcode() {
                    var date = new Date();
                    initial_time = date.getTime();
                    if (typeof setInverval_Variable == 'undefined') {
                        setInverval_Variable = setInterval(DelayedSubmission_CheckBarcode, 50);
                    }
                }

                function DelayedSubmission_Check() {
                    var date = new Date();
                    check_time = date.getTime();
                    var limit_ms = check_time - initial_time;
                    if (limit_ms > 800) { //Change value in milliseconds
                        clearInterval(setInverval_Variable);
                        delete setInverval_Variable;
                        //alert("insert your function"); //Insert your function
                        var cotainertxt = nucleus('input[name="searchp"]').val();
                        if (cotainertxt != "")
                        {
                            nucleus.get("./controller/product.php", {'search': cotainertxt}, function (dada) {

                                //console.log(cotainertxt);
                                var htmltxt = '';
                                jQuery.each(dada, function (index, key) {
                                    htmltxt += '<li data-value="' + key.id + '" class=""><a href="javascript:auto_sales(' + key.id + ',<?php echo $cart; ?>);">' + key.name + '</a></li>';
                                });
                                console.log(htmltxt);
                                if (htmltxt != '')
                                {
                                    nucleus("#searchResult").fadeIn('slow');
                                    nucleus("#searchResult").html(htmltxt);
                                }
                                else
                                {
                                    htmltxt = '<li data-value="" class=""><a href="javascript:void(0);">No Product Found</a></li>';
                                    nucleus("#searchResult").show();
                                    nucleus("#searchResult").html(htmltxt);
                                }
                            });
                        }
                    }
                }

                function DelayedSubmission_CheckBarcode() {
                    var date = new Date();
                    check_time = date.getTime();
                    var limit_ms = check_time - initial_time;
                    if (limit_ms > 800) { //Change value in milliseconds
                        clearInterval(setInverval_Variable);
                        delete setInverval_Variable;
                        //alert("insert your function"); //Insert your function
                        var cotainertxt = nucleus('input[name="searchb"]').val();
                        if (cotainertxt != "")
                        {
                            nucleus.get("./controller/product.php", {'search': cotainertxt}, function (dada) {

                                //console.log(cotainertxt);
                                var htmltxt = '';
                                jQuery.each(dada, function (index, key) {
                                    htmltxt += '<li data-value="' + key.id + '" class=""><a href="javascript:auto_sales(' + key.id + ',<?php echo $cart; ?>);">' + key.name + '</a></li>';
                                });
                                console.log(htmltxt);
                                if (htmltxt != '')
                                {
                                    nucleus("#searchBResult").fadeIn('slow');
                                    nucleus("#searchBResult").html(htmltxt);
                                }
                                else
                                {
                                    htmltxt = '<li data-value="" class=""><a href="javascript:void(0);">No Product Found</a></li>';
                                    nucleus("#searchBResult").show();
                                    nucleus("#searchBResult").html(htmltxt);
                                }
                            });
                        }
                    }
                }

            </script>

            <style type="text/css">
                .k-grid-content{ overflow: hidden; }
                .k-grouping-header{ display: none; }
            </style>
            <script>
                nucleus(document).ready(function () {
                    nucleus("#large,#tab1").click(function () {

                        $("#trsdiv").addClass("span12");
                        $("#trsdiv").css("margin-left", "0px");
                        //$("#trsdiv").css("padding-right","0px");
                        $("#trsdiv").removeClass("span6");
                    });

                    nucleus("#small,#tab2,#tab201,#tab3,#tab4,#tab5,#tab6").click(function () {

                        $("#trsdiv").addClass("span6");
                        $("#trsdiv").removeAttr("style");
                        $("#trsdiv").removeClass("span12");
                    });
                });

                nucleus("select").kendoDropDownList({
                    optionLabel: " -- Please Select -- "
                }).data("kendoDropDownList");




<?php
if (!empty($invoice_cid)) {
    ?>
                    nucleus.get("ajax/new_customer.php", {'st': '101', 'name': '<?php echo $invoice_cid; ?>', 'cart': '<?php echo $cart; ?>'}, function (data) {
                        console.log(data);
                    });
    <?php
} else {
    if (!empty($def_cus)) {
        ?>
                        nucleus.get("ajax/new_customer.php", {'st': '101', 'name': '<?php echo $def_cus; ?>', 'cart': '<?php echo $cart; ?>'}, function (data) {
                            console.log(data);
                        });
        <?php
    } else {
        ?>
                        nucleus("#customername").kendoDropDownList({
                            optionLabel: " -- Please Select -- "
                        }).data("kendoDropDownList").select(0);
        <?php
    }
}
?>
                //("#customername").click();
            </script> 
            <script>
                nucleus("#startdate").kendoDatePicker({
                    format: "yyyy-MM-dd",
                    animation: {
                        close: {
                            effects: "fadeOut zoom:out",
                            duration: 300
                        },
                        open: {
                            effects: "fadeIn zoom:in",
                            duration: 300
                        }
                    }
                });
            </script>
        </div>
        <!-- /main wrapper -->

    </body>
</html>
