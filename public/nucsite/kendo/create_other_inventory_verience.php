<?php
include('class/auth.php');
$table="product_verience";
$cashman=0;
if ($input_status == 1 || $input_status == 2 || $input_status == 5) {
    $cashman=1;
}
if (isset($_POST['create'])) {
    extract($_POST);
    $lotno=time();
    $obj->insert($table, array("store_id"=>$input_by,
        "pid"=>$pid,
        "lotno"=>$lotno,
        "white"=>$white,
        "black"=>$black,
        "warranty"=>$warranty,
        "system_quantity"=>$system_quantity,
        "quantity"=>$quantity,
        "date"=>date('Y-m-d'),
        "status"=>3));
    $obj->insert("varience", array("store_id"=>$input_by, "input_by"=>$input_bys, "lotno"=>$lotno, "date"=>date('Y-m-d'), "status"=>3));
    //$obj->Success("Your Other Inventory Variance Report has been generated", "other_inventory_verience.php?lotno=" . $lotno);

    if ($cashman == 1) {
        $obj->Success("Thank You, Verience Created Successfully.", "other_inventory_verience.php?lotno=" . $lotno);
    }else {
        $obj->Success("Thank You, Your Verience Created Successfully.", $obj->filename() . "?pid=" . $pid);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php echo $obj->bodyhead(); ?>
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
                            <h5><i class="icon-random"></i> <?php if (!isset($_GET['ac'])) { ?> Create Other Inventory Variance <?php }else { ?> Other Inventory Variance Report <?php } ?> </h5>
                            <ul class="icons">
                                <li><a href="<?php echo $obj->filename(); ?>?pid=<?php echo $_GET['pid']; ?>" class="hovertip" title="Reload"><i class="font-refresh"></i></a></li>
                            </ul>
                        </div><!-- /page header -->

                        <div class="body">

                            <!-- Middle navigation standard -->
                            <?php //include('include/quicklink.php');   ?>
                            <!-- /middle navigation standard -->

                            <!-- Content container -->
                            <div class="container">




                                <!-- Content Start from here customized -->

                                <?php if (!isset($_GET['ac'])) { ?>
                                    <form class="form-horizontal" method="post" action="">
                                        <fieldset>

                                            <!-- General form elements -->
                                            <div class="well row-fluid block">
                                                <div class="control-group">
                                                    <label class="control-label"> Product Name </label>
                                                    <div class="controls"><input class="span8" readonly value="<?php echo $obj->SelectAllByVal("product", "id", $_GET['pid'], "name"); ?>" type="text" name="pname" />
                                                        <?php
                                                        $pq=$obj->SelectAllByVal("product", "id", $_GET['pid'], "quantity");
                                                        $sqlsalesproduct=$obj->SelectAllByID_Multiple("sales", array("pid"=>$_GET['pid']));
                                                        $sold=0;
                                                        if (!empty($sqlsalesproduct))
                                                            foreach ($sqlsalesproduct as $soldproduct):
                                                                $sold+=$soldproduct->quantity;
                                                            endforeach;
                                                        $actinstock=$pq - $sold;
                                                        ?>
                                                        <input type="hidden" value="<?php echo $actinstock; ?>" name="system_quantity"  style="width:70px;" />
                                                        <input type="hidden" name="pid" value="<?php echo $_GET['pid']; ?>"/>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label">White</label>
                                                    <div class="controls"><input class="span8" type="text" name="white" /></div>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label">Black</label>
                                                    <div class="controls"><input class="span8" type="text" name="black" /></div>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label">Warranty</label>
                                                    <div class="controls"><input class="span8" type="text" name="warranty" /></div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label">Your Quantity</label>
                                                    <div class="controls"><input class="span8" type="text" name="quantity" /></div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label">&nbsp;</label>
                                                    <div class="controls">
                                                        <button type="submit" name="create" class="btn btn-success"><i class="icon-ok"></i> Create Variance Report </button>
                                                        <button type="reset" name="reset" class="btn btn-danger"><i class="icon-ban-circle"></i> Reset Form </button>
                                                    </div>
                                                </div>


                                            </div>
                                            <!-- /general form elements -->
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
            <?php include('include/footer.php'); ?>
            <!-- Right sidebar -->
            <?php //include('include/sidebar_right.php');   ?>
            <!-- /right sidebar -->

        </div>
        <!-- /main wrapper -->

    </body>
</html>
