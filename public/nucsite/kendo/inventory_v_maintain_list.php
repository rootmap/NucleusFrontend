<?php
include('class/auth.php');
$cashman=0;
if ($input_status == 1 || $input_status == 2 || $input_status == 5) {
    $cashman=1;
}

include('class/index.php');
$maintain=new index();
$table="product";

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
                "status"=>4));
            $s+=1;
        }else {
            $s+=0;
        }
    endforeach;
    if ($s == 0) {
        $obj->Error("Verience Report Failed To Created.", $obj->filename());
    }else {
        $obj->insert("varience", array("store_id"=>$input_by, "input_by"=>$input_bys, "lotno"=>$lotno, "date"=>date('Y-m-d'), "status"=>4));
        //$obj->Success("Verience Successfully Created / Updated.", "maintain_stock_varience.php?lotno=" . $lotno);
        if ($cashman == 1) {
            $obj->Success("Thank You, Verience Created Successfully.", "maintain_stock_varience.php?lotno=" . $lotno);
        }else {
            $obj->Success("Thank You, Your Verience Created Successfully.", $obj->filename());
        }
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
                            <h5><i class="font-hdd"></i> Create Maintain Inventory Stock Variance </h5>
                            <ul class="icons">
                                <li><a href="<?php echo $obj->filename(); ?>" class="hovertip" title="Reload"><i class="font-refresh"></i></a></li>
                            </ul>
                        </div><!-- /page header -->

                        <div class="body">

                            <!-- Middle navigation standard -->
                            <?php //include('include/quicklink.php');    ?>
                            <!-- /middle navigation standard -->

                            <!-- Content container -->
                            <div class="container">





                                <!-- Content Start from here customized -->


                                <!-- Default datatable -->
                                <div class="block">

                                    <div class="table-overflow">
                                        <form action="" method="post">
                                            <table class="table table-striped table-bordered">
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
                                                    if ($input_status == 1) {
                                                        $sql_product=$maintain->FlyQuery("select id,barcode,`name`,quantity,description,price_cost,price_retail,`status`,input_by FROM product WHERE maintain_stock='1'");
                                                        //$obj->SelectAllNOASC("product_checkin_inventory");
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
                                                        $sql_product=$maintain->FlyQuery("select id,barcode,`name`,description,price_cost,price_retail,quantity,`status`,input_by FROM product WHERE maintain_stock='1' AND input_by='" . $input_by . "'");
                                                        //$obj->SelectAllByID_Multiple_Inventory("product_checkin_inventory",array("input_by"=>$input_by));
                                                    }
                                                    $i=1;
                                                    $cost_total_inventory=0;
                                                    $retail_total_inventory=0;
                                                    $instock_total_inventory=0;
                                                    if (!empty($sql_product))
                                                        foreach ($sql_product as $product):
                                                            $instock=1;
                                                            if ($input_status == 1) {
                                                                ?>
                                                                <tr>
                                                                    <td><?php echo $i; ?></td>
                                                                    <td><?php echo $product->barcode; ?></td>
                                                                    <td><label class="label label-success"> <?php echo $product->name; ?> </label></td>
                                                                    <td>
                                                                        <input type="text" name="white[]"  style="width:70px;" />
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" name="black[]"  style="width:70px;" />
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" name="warranty[]"  style="width:70px;" />
                                                                    </td>
                                                                    <td>
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
                                                                        <input type="text" name="given_quantity[]" style="width:70px;" />
                                                                        <input type="hidden" name="pid[]" value="<?php echo $product->id; ?>" />
                                                                    </td>
                                                                    <td>
                                                                        <a href="create_maintain_stock_verience.php?pid=<?php echo $product->id; ?>" class="label label-info hovertip" title="Create a Variance">
                                                                            <i class="icon-random"></i>
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                                <?php
                                                                $i++;
                                                            }else {
                                                                if ($product->status != 2) {
                                                                    ?>
                                                                    <tr>
                                                                        <td><?php echo $i; ?></td>
                                                                        <td><?php echo $product->barcode; ?></td>
                                                                        <td><label class="label label-success"> <?php echo $product->name; ?> </label></td>
                                                                        <td>
                                                                            <input type="text" name="white[]"  style="width:70px;" />
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" name="black[]"  style="width:70px;" />
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" name="warranty[]"  style="width:70px;" />
                                                                        </td>

                                                                        <td>
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
                                                                            <input type="text" name="given_quantity[]" style="width:70px;" />
                                                                            <input type="hidden" name="pid[]" value="<?php echo $product->id; ?>" />
                                                                        </td>
                                                                        <td>
                                                                            <a href="create_maintain_stock_verience.php?pid=<?php echo $product->id; ?>" class="label label-info hovertip" title="Create a Variance">
                                                                                <i class="icon-random"></i>
                                                                            </a>
                                                                        </td>
                                                                    </tr>
                                                                    <?php
                                                                    $i++;
                                                                }
                                                            }

                                                        endforeach;
                                                    ?>
                                                </tbody>
                                            </table>

                                            <div class="control-group">
                                                <label class="control-label">&nbsp;</label>
                                                <div class="controls">
                                                    <button type="submit" name="create" class="btn btn-success"><i class="icon-ok"></i> Create Variance Report </button>
                                                    <button type="reset" name="reset" class="btn btn-danger"><i class="icon-ban-circle"></i> Reset Form </button>
                                                </div>
                                            </div>

                                        </form>

                                    </div>
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
            <?php include('include/footer.php'); ?>
            <!-- Right sidebar -->
            <?php //include('include/sidebar_right.php');       ?>
            <!-- /right sidebar -->
            <script type="text/javascript">
                function checksum()
                {
                    //alert('Success');
                    var price_cost = 0.00;
                    var price_retail = 0.00;
                    var quantity = 0.00;

                    $(".td_price_cost").each(function () {
                        price_cost += parseFloat($(this).html().replace(/\s/g, '').replace(',', '.'));
                    });
                    $(".td_price_retail").each(function () {
                        price_retail += parseFloat($(this).html().replace(/\s/g, '').replace(',', '.'));
                    });
                    $(".td_quantity").each(function () {
                        quantity += parseFloat($(this).html().replace(/\s/g, '').replace(',', '.'));
                    });

                    //alert(quantity);
                    $('#td_total_price_cost').html(price_cost);
                    $('#td_total_price_retail').html(price_retail);
                    $('#td_total_quantity').html(quantity);
                    //aa = quantity;
                }
            </script>
            <script>
                //$().keyup()
                nucleus(document).ready(function () {
                    nucleus('input[aria-controls="data-table"]').keyup(function () {
                        checksum();
                    });

                });
            </script>
        </div>
        <!-- /main wrapper -->

    </body>
</html>
