<?php
include('class/auth.php');
$table="product";
if(isset($_GET['del']))
{
	$obj->deletesing("id",$_GET['del'],$table);	
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
                            <h5><i class="font-home"></i>Products StockIn : <?php echo $obj->SelectAllByVal("product","id",$_GET['pid'],"name"); ?> Report</h5>
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
                                
                                
                                <!-- Default datatable -->
                        <div class="block">
                            <div class="table-overflow">
                                <table class="table table-striped" id="data-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>UPC / Barcode</th>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Cost</th>
                                            <th>Retail</th>
                                            <th>StockIn Date</th>
                                            <th>Quantity</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql_product=$obj->SelectAllByID("product_stockin",array("pid"=>$_GET['pid']));
										$i=1;
										if(!empty($sql_product))
										foreach($sql_product as $product):
										?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $obj->SelectAllByVal("product","id",$product->pid,"barcode"); ?></td>
                                            <td><label class="label label-success"> <?php echo $obj->SelectAllByVal("product","id",$product->pid,"name"); ?> </label></td>
                                            <td><?php echo $obj->SelectAllByVal("product","id",$product->pid,"description"); ?></td>
                                            <td><?php echo $product->price_cost; ?></td>
                                            <td><?php echo $product->price_retail; ?></td>
                                            <td><?php echo $obj->dates($product->date); ?></td>
                                            <td><label class="label label-warning"> <?php echo $product->quantity; ?>  </label></td>
                                            
                                        </tr>
                                        <?php 
										$i++;
										endforeach; ?>
                                    </tbody>
                                </table>
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
            <?php //include('include/sidebar_right.php'); ?>
            <!-- /right sidebar -->

        </div>
        <!-- /main wrapper -->

    </body>
</html>
