<?php
include('class/auth.php');
$table="product";
$cashman=0;
if ($input_status == 1 || $input_status == 2 || $input_status == 5) {
    $cashman=1;
}
if (isset($_POST['create'])) {
    $lotno=time();
    $s=0;
    foreach ($_POST['given_quantity'] as $index=> $nn):
        if ($nn != '') {
            $obj->insert("product_verience", array("store_id"=>$input_by,
                "pid"=>$_POST['pid'][$index],
                "white"=>$_POST['white'][$index],
                "black"=>$_POST['black'][$index],
                "warranty"=>$_POST['warranty'][$index],
                "system_quantity"=>$_POST['system_quantity'][$index],
                "quantity"=>$nn,
                "lotno"=>$lotno,
                "date"=>date('Y-m-d'),
                "status"=>1));
            $s+=1;
        }else {
            $s+=0;
        }
    endforeach;
    if ($s == 0) {
        $obj->Error("Verience Report Failed To Created.", $obj->filename());
    }else {
        $obj->insert("varience", array("store_id"=>$input_by, "input_by"=>$input_bys, "lotno"=>$lotno, "date"=>date('Y-m-d'), "status"=>1));
        if ($cashman == 1) {
            $obj->Success("Thank You, Verience Created Successfully.", "checkin_verience.php?lotno=" . $lotno);
        }else {
            $obj->Success("Thank You, Your Verience Created Successfully.", $obj->filename());
        }
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
                            <h5><i class="font-th"></i>Create Checkin Variance</h5>
                            <ul class="icons">
                                <li><a href="<?php echo $obj->filename(); ?>" class="hovertip" title="Reload"><i class="font-refresh"></i></a></li>
                            </ul>
                        </div><!-- /page header -->

                        <div class="body">

                            <!-- Middle navigation standard -->
                            <?php //include('include/quicklink.php');   ?>
                            <!-- /middle navigation standard -->

                            <!-- Content container -->
                            <div class="container">





                                <!-- Content Start from here customized -->


                                <!-- Default datatable -->
                                <div class="block">
                                    <form action="" method="post">
                                        <div class="table-overflow">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Barcode</th>
                                                        <th>Name</th>
                                                        <th>White</th>
                                                        <th>Black</th>
                                                        <th>Warranty</th>
                                                        <th>Given Quantity</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if (!isset($_POST['create'])) {
                                                        if ($input_status == 1) {
                                                            $sql_product=$obj->SelectAllNOASC("product_checkin_inventory");
                                                        }elseif ($input_status == 5) {

                                                            $sqlchain_store_ids=$obj->SelectAllByID("store_chain_admin", array("sid"=>$input_by));
                                                            if (!empty($sqlchain_store_ids)) {
                                                                $array_ch=array();
                                                                foreach ($sqlchain_store_ids as $ch):
                                                                    array_push($array_ch, $ch->store_id);
                                                                endforeach;


                                                                include('class/report_chain_admin.php');
                                                                $obj_report_chain=new chain_report();
                                                                $sql_product=$obj_report_chain->SelectAllByID_Multiple_Or("product_checkin_inventory", $array_ch, "input_by", "1");
                                                            }
                                                            else {
                                                                //echo "Not Work";
                                                                $sql_product="";
                                                            }
                                                        }else {
                                                            $sql_product=$obj->SelectAllByID_Multiple_Inventory("product_checkin_inventory", array("input_by"=>$input_by));
                                                        }
                                                    }
                                                    $i=1;
                                                    if (!empty($sql_product))
                                                        foreach ($sql_product as $product):
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $i; ?></td>
                                                                <td><?php echo $product->barcode; ?></td>
                                                                <td><label class="label label-success"> <?php echo $product->name; ?> </label></td>
                                                                <td>
                                                                    <input class="k-textbox" type="text" name="white[]"  style="width:70px;" />
                                                                </td>
                                                                <td>
                                                                    <input class="k-textbox" type="text" name="black[]"  style="width:70px;" />
                                                                </td>
                                                                <td>
                                                                    <input class="k-textbox" type="text" name="warranty[]"  style="width:70px;" />
                                                                </td>
                                                                <td>
                                                                    <input class="k-textbox" type="text" name="given_quantity[]"  style="width:70px;" />
                                                                    <?php
                                                                    $pq=$product->quantity;
                                                                    $sqlsalesproduct=$obj->SelectAllByID_Multiple("sales", array("pid"=>$product->id));
                                                                    $sold=0;
                                                                    if (!empty($sqlsalesproduct))
                                                                        foreach ($sqlsalesproduct as $soldproduct):
                                                                            $sold+=$soldproduct->quantity;
                                                                        endforeach;
                                                                    $actinstock=$pq - $sold;
                                                                    ?>
                                                                    <input type="hidden" value="<?php echo $actinstock; ?>" name="system_quantity[]"  style="width:70px;" />
                                                                    <input type="hidden" name="pid[]" value="<?php echo $product->id; ?>" />
                                                                </td>
                                                                <td>
                                                                    <a href="create_verience.php?pid=<?php echo $product->id; ?>" class="label label-info hovertip" title="Create a Verience">
                                                                        <i class="icon-random"></i>
                                                                    </a>
                                                                </td>

                                                            </tr>
                                                            <?php
                                                            $i++;
                                                        endforeach;
                                                    ?>
                                                </tbody>
                                            </table>
                                            <div class="control-group">
                                                <label class="control-label">&nbsp;</label>
                                                <div class="controls">
                                                    <button type="submit" name="create" class="k-button"><i class="icon-ok"></i> Create Variance Report </button>
                                                    <button type="reset" name="reset" class="k-button"><i class="icon-ban-circle"></i> Reset Form </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- /default datatable -->
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
            <!-- Right sidebar -->
            <?php //include('include/sidebar_right.php');   ?>
            <!-- /right sidebar -->

        </div>
        <!-- /main wrapper -->

    </body>
</html>
