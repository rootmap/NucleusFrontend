<?php
include('class/auth.php');
if ($input_status == 3 || $input_status == 4) {
    $obj->Error("Invalid Page Request.", "index.php");
}
$table = "customer_wallet";
$table2 = "customer_deposit_log";
$table3 = "customer_withdrawal _log";
if (isset($_GET['del'])) {
    $obj->deletesing("id", $_GET['del'], $table);
}

if (isset($_POST['save'])) {
    if ($obj->exists_multiple($table, array("cid" => $_POST['cid'])) == 0) {
        $newbl = ($_POST['diposit_amount'] - $_POST['withdrawal_amount']);
        if ($_POST['cid'] != 0) {
            if (empty($_POST['diposit_amount']) && empty($_POST['diposit_amount']) && empty($_POST['withdrawal_amount']) && empty($_POST['pending_amount'])) {
                $obj->Error("Fields Can't Be Empty.", $obj->filename());
            } else {
                if ($obj->insert($table, array("cid" => $_POST['cid'], "diposit_amount" => $_POST['diposit_amount'], "withdrawal_amount" => $_POST['withdrawal_amount'], "pending_amount" => $_POST['pending_amount'], "balance_amount" => $newbl, "status" => 1, "date" => date('Y-m-d'))) == 1) {
                    $wid = $obj->SelectAllByVal($table, 'cid', $_POST['cid'], 'id');
                    $exdep = $obj->SelectAllByVal($table, 'cid', $_POST['cid'], 'diposit_amount');
                    $exwid = $obj->SelectAllByVal($table, 'cid', $_POST['cid'], 'withdrawal_amount');

                    if ($wid != 0) {
                        if ($obj->insert($table2, array("cid" => $_POST['cid'], "wid" => $wid, "deposit" => $exdep, "date" => date('Y-m-d'), "status" => 1)) == 1) {
                            if ($exwid != 0) {
                                if ($obj->insert($table3, array("cid" => $_POST['cid'], "wid" => $wid, "withdrawal" => $exwid, "date" => date('Y-m-d'), "status" => 1)) == 1) {
                                    $obj->Success("Customer Wallet Succesfully Saved", $obj->filename() . "?cid=" . $_POST['cid']);
                                    //$obj->Success("Customer withdrawal Succesfully Saved", $obj->filename());
                                }
                            }
                        } else {
                            $obj->Error("Customer Wallet Saving Failed", $obj->filename());
                        }
                    }
                } else {
                    $obj->Error("Customer Wallet Saved Failed", $obj->filename());
                }
            }
        } else {
            $obj->Error("Customer Can't Be Empty. Please Select Customer & Try Again!", $obj->filename());
        }
    } elseif ($obj->exists_multiple($table, array("cid" => $_POST['cid'])) >= 1) {
        $wid = $obj->SelectAllByVal($table, 'cid', $_POST['cid'], 'id');
        $exdep = $obj->SelectAllByVal($table, 'cid', $_POST['cid'], 'diposit_amount');
        $exwidm = $obj->SelectAllByVal($table, 'cid', $_POST['cid'], 'withdrawal_amount');
        $expenm = $obj->SelectAllByVal($table, 'cid', $_POST['cid'], 'pending_amount');
        $exblnm = $obj->SelectAllByVal($table, 'cid', $_POST['cid'], 'balance_amount');

        $new_dep = $exdep + $_POST['diposit_amount'];
        $new_widm = $exwidm + $_POST['withdrawal_amount'];
        $new_penm = $expenm + $_POST['pending_amount'];
        $new_blnpm = ($exblnm + $_POST['diposit_amount']) - $_POST['withdrawal_amount'];
//        echo $new_blnpm;
//        exit();
        if ($_POST['cid'] != 0) {
            if (empty($_POST['diposit_amount']) && empty($_POST['diposit_amount']) && empty($_POST['withdrawal_amount']) && empty($_POST['pending_amount'])) {

                $obj->Error("Fields Can't Be Empty.", $obj->filename());
            } else {
                if ($_POST['diposit_amount'] != 0) {
                    $obj->update($table, array("id" => $wid, "cid" => $_POST['cid'], "diposit_amount" => $new_dep));
                    $obj->update($table, array("id" => $wid, "cid" => $_POST['cid'], "balance_amount" => $new_blnpm));
                }
                if ($_POST['withdrawal_amount'] != 0) {
                    $obj->update($table, array("id" => $wid, "cid" => $_POST['cid'], "withdrawal_amount" => $new_widm));
                    $obj->update($table, array("id" => $wid, "cid" => $_POST['cid'], "balance_amount" => $new_blnpm));
                }
                if ($_POST['pending_amount'] != 0) {
                    $obj->update($table, array("id" => $wid, "cid" => $_POST['cid'], "pending_amount" => $new_penm));
                }
                if ($_POST['diposit_amount'] != 0) {
                    $obj->insert($table2, array("cid" => $_POST['cid'], "wid" => $wid, "deposit" => $_POST['diposit_amount'], "date" => date('Y-m-d'), "status" => 1));
                }
                if ($_POST['withdrawal_amount'] != 0) {
                    $obj->insert($table3, array("cid" => $_POST['cid'], "wid" => $wid, "withdrawal" => $_POST['withdrawal_amount'], "date" => date('Y-m-d'), "status" => 1));
                }
                $obj->Success("Customer Wallet Succesfully Updated", $obj->filename() . "?cid=" . $_POST['cid']);
            }
        } else {
            $obj->Error("Customer Can't Be Empty. Please Select Customer & Try Again!", $obj->filename());
        }
    }
}




//if (isset($_POST['update'])) {
//    extract($_POST);
//    if (!empty($cid) && !empty($diposit_amount) && !empty($withdrawal_amount) && !empty($pending_amount) && !empty($balance_amount)) {
//
//        if ($obj->update($table, array("id" => $edit, "cid" => $cid, "diposit_amount" => $diposit_amount, "withdrawal_amount" => $withdrawal_amount, "pending_amount" => $pending_amount, "balance_amount" => $balance_amount)) == 1) {
//            $obj->Success("Successfully Updated Customer Wallet Detail", $obj->filename() . "?edit=" . $edit);
//        } else {
//            $obj->Error("Something is wrong, Try again.", $obj->filename() . "?edit=" . $edit);
//        }
//    } else {
//        $obj->Error("Failed, Fill up required field", $obj->filename() . "?edit=" . $edit);
//        
//    }
//}
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
                                <h5><i class="icon-edit"></i> Edit Customer Wallet Detail </h5>
                            <?php } else { ?>
                                <h5><i class="font-plus-sign"></i> Add New Customer Wallet </h5>
                            <?php } ?>
                            <ul class="icons">
                                <li><a href="<?php echo $obj->filename(); ?>" class="hovertip" title="Reload"><i class="font-refresh"></i></a></li>
                            </ul>
                        </div><!-- /page header -->

                        <div class="body">

                            <!-- Middle navigation standard -->
                            <?php //include('include/quicklink.php');          ?>
                            <!-- /middle navigation standard -->

                            <!-- Content container -->
                            <div class="container">
                                <?php if (isset($_GET['edit'])) { ?>
                                    <form class="form-horizontal" method="post" enctype="multipart/form-data" name="invoice" action="">
                                        <fieldset>
                                            <input type="hidden" name="edit" value="<?php echo $_GET['edit']; ?>">


                                            <!-- General form elements -->
                                            <div class="row-fluid  span12 well">     
                                                <!-- Selects, dropdowns -->
                                                <div class="span12" style="padding:0px; margin:0px;">
                                                    <div class="control-group">
                                                        <label class="control-label"><span style="color:red;"> *</span> Select Customer </label>
                                                        <div class="controls"><input value="<?php echo $obj->SelectAllByVal($table, "id", $_GET['edit'], "cid"); ?>" class="span12 k-textbox" type="number" name="cid" /></div>
                                                    </div>

                                                    <div class="control-group">
                                                        <label class="control-label"><span style="color:red;"> *</span> Diposit Amount </label>
                                                        <div class="controls"><input value="<?php echo $obj->SelectAllByVal($table, "id", $_GET['edit'], "diposit_amount"); ?>" class="span12 k-textbox" type="number" name="diposit_amount" /></div>
                                                    </div>

                                                    <div class="control-group">
                                                        <label class="control-label"><span style="color:red;"> *</span> Withdrawal Amount </label>
                                                        <div class="controls"><input value="<?php echo $obj->SelectAllByVal($table, "id", $_GET['edit'], "withdrawal_amount"); ?>" class="span12 k-textbox" type="number" name="withdrawal_amount" /></div>
                                                    </div>

                                                    <div class="control-group">
                                                        <label class="control-label"><span style="color:red;"> *</span> Pending Amount </label>
                                                        <div class="controls"><input value="<?php echo $obj->SelectAllByVal($table, "id", $_GET['edit'], "pending_amount"); ?>" class="span12 k-textbox" type="number" name="pending_amount" /></div>
                                                    </div>

                                                    <div class="control-group">
                                                        <label class="control-label"><span style="color:red;"> *</span> Balance Amount </label>
                                                        <div class="controls">
                                                            <input value="<?php echo $obj->SelectAllByVal($table, "id", $_GET['edit'], "balance_amount"); ?>" class="span12 k-textbox" type="number" name="balance_amount" />
                                                        </div>
                                                    </div>

                                                    <div class="control-group">
                                                        <label class="control-label">&nbsp;</label>
                                                        <div class="controls"><button type="submit" name="update" class="k-button">
                                                                <i class="icon-plus-sign"></i> Update Customer Wallet Detail </button></div>
                                                    </div>

                                                </div>
                                                <!-- /selects, dropdowns -->




                                                <!-- /selects, dropdowns -->



                                            </div>
                                            <!-- /general form elements -->     


                                            <div class="clearfix"></div>

                                            <!-- Default datatable -->

                                            <!-- /default datatable -->


                                        </fieldset>                     

                                    </form>

                                <?php } else { ?>


                                    <!-- /middle navigation standard -->
                                    <!--                                    -->

                                    <!-- Content container -->




                                    <!-- Content Start from here customized -->


                                    <form class="form-horizontal" enctype="multipart/form-data" method="post" name="invoice" action="">
                                        <fieldset>
                                            <!-- General form elements -->
                                            <div class="row-fluid  span12 well">
                                                <div class="k-toolbar k-grid-toolbar">
                                                    <a href="customer_wallet.php" class="k-button"><i class="icon-plus-sign"></i> New Customer Wallet Info</a>
                                                    <a href="customer_wallet_list.php" class="k-button"><i class="icon-tasks"></i> Customer Wallet List</a>
                                                </div>
                                                <!-- Selects, dropdowns -->
                                                <div class="span12" style="padding:0px; margin:0px;">
                                                    <div class="span6">
                                                        <div class="control-group">
                                                            <label style="width:120px;" class="control-label"><span style="color:red;"> *</span> Select Customer </label>
                                                            <div class="controls" id="newcus">
                                                                <select name="cid" id="customer" style="width: 300px;">
                                                                    <?php
                                                                    if (isset($_GET['cid'])) {
                                                                        $cur_cid = $_GET['cid'];
                                                                    } else {
                                                                        $cur_cid = 0;
                                                                    }
                                                                    $sqlscdata = $obj->FlyQuery("SELECT
                                                                                                id,
                                                                                                CONCAT(firstname, ' ', lastname) AS name,
                                                                                                input_by
                                                                                                FROM coustomer
                                                                                                WHERE input_by='$input_by'");

                                                                    if (!empty($sqlscdata))
                                                                        foreach ($sqlscdata as $row):
                                                                            ?>
                                                                            <option <?php if ($cur_cid == $row->id) { ?> selected="selected" <?php } ?> value="<?php echo $row->id; ?>"><?php echo $row->name; ?> - (<?php echo $row->id; ?>)</option> 
                                                                            <?php
                                                                        endforeach;
                                                                    ?> 
                                                                    <!--<option value="0">Add Currency To Store</option>-->
                                                                </select>

                                                            </div>
                                                        </div>
                                                        <div class="control-group">
                                                            <label style="width:120px;" class="control-label"><span style="color:red;"> *</span> Diposit Amount </label>
                                                            <div class="controls">
                                                                <input style="width:150px;" class="span12 k-textbox" type="number" name="diposit_amount" />
                                                                <span style="margin-left: 10px;">Total Diposit : </span><strong id="ttldp">0</strong>
                                                            </div>


                                                        </div>
                                                        <div class="control-group">
                                                            <label style="width:120px;" class="control-label"><span style="color:red;"> *</span> Withdrawal Amount </label>
                                                            <div class="controls"><input style="width: 150px;" class="span12 k-textbox" type="number" name="withdrawal_amount" />
                                                                <span style="margin-left: 10px;">Total Withdrawal : </span><strong id="ttlwd">0</strong>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="span6">
                                                        <div class="control-group">
                                                            <label style="width:120px;" class="control-label"><span style="color:red;"> *</span> Pending Amount </label>
                                                            <div class="controls"><input style="width: 150px;" class="span12 k-textbox" type="number" name="pending_amount" />
                                                                <span style="margin-left: 10px;">Total Pending : </span><strong id="ttlpn">0</strong>
                                                            </div>
                                                        </div>
                                                        <div class="control-group">
                                                            <label style="width:120px;" class="control-label"><span style="color:red;"> *</span> Balance Amount </label>
                                                            <div class="controls"><input id="ttlbl" style="width: 150px;" class="span12 k-textbox" type="number" name="balance_amount" readonly="readonly"/>
    <!--                                                                <span style="margin-left: 10px;">Total Balance : </span><strong id="ttlbl">0</strong>-->
                                                            </div>
                                                        </div>
                                                        <div class="control-group">
                                                            <label style="width:120px;" class="control-label">&nbsp;</label>
                                                            <div class="controls">
                                                                <button type="submit" name="save" class="k-button">
                                                                    <i class="icon-plus-sign"></i> Save Customer Wallet 
                                                                </button>
                                                            </div>
                                                        </div>
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
                nucleus("#customer").kendoDropDownList({
                    optionLabel: " -- Select A Customer -- "
                }).data("kendoDropDownList").select(0);

                nucleus('#customer').on('change', function (e) {
                    //alert(this.value); // or $(this).val()
                    var cid = this.value;
                    nucleus.post('ajax/customer_wallet.php', {cid: cid}, function (data) {
                        var datacl = jQuery.parseJSON(data);
                        $("#ttldp").html(datacl[0].ttl_dep);
                        $("#ttlwd").html(datacl[0].ttl_wid);
                        $("#ttlpn").html(datacl[0].ttl_pen);
                        $("#ttlbl").val(datacl[0].ttl_bln);

                    });
                });
            </script> 
            <!-- Right sidebar -->
            <?php //include('include/sidebar_right.php');           ?>
            <!-- /right sidebar -->

        </div>
        <!-- /main wrapper -->

    </body>
</html>
