<?php 
include('class/auth.php');
if($input_status!=1)
{
	$obj->Error("Invalid Page Request.","index.php");
}
$table="payment";
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
                            <h5><i class="font-cogs"></i> Payment Method Setting </h5>
                            <ul class="icons">
                                <li><a href="<?php echo $obj->filename(); ?>" class="hovertip" title="Reload"><i class="font-refresh"></i></a></li>
                            </ul>
                        </div><!-- /page header -->

                        <div class="body">

                            <!-- Middle navigation standard -->
                            <?php //include('include/quicklink.php');  ?>
                            <!-- /middle navigation standard -->
                            <a href="payment.php" class="btn btn-success"><i class="icon-plus-sign"></i> Add New Payment</a>
                            <a href="setting_paymentmethod.php" class="btn btn-success"><i class="icon-tasks"></i> Payment List</a>
                            <!-- Content container -->
                            <div class="container">




                                <!-- Content Start from here customized -->


                                <form class="form-horizontal" method="post" name="invoice" action="<?php /*?>create_invoice.php<?php */?>">
                                    <fieldset>
                                        <!-- General form elements -->
                                        <div class="row-fluid  span12 well">     
                                            <!-- Selects, dropdowns -->
                                            <!-- /selects, dropdowns -->
                                                <div class="table-overflow">
                                                    <table class="table table-striped" id="data-table">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th> Method Name </th>
                                                                <th> Status </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php 
															$sql_payment=$obj->SelectAll($table);
															$i = 1;
															foreach ($sql_payment as $row): ?>
                                                                <tr>
                                                                    <td><?php echo $i; ?></td>
                                                                    <td><?php echo $row->name; ?> </td>
                                                                    <td> Active </td>
                                                                </tr>
                                                            <?php 
															$i++;
															endforeach; ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <!-- /selects, dropdowns -->

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
            <?php include('include/footer.php'); ?>
            <!-- Right sidebar -->
            <?php //include('include/sidebar_right.php');  ?>
            <!-- /right sidebar -->

        </div>
        <!-- /main wrapper -->

    </body>
</html>
