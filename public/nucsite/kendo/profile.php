<?php
include('class/auth.php');
if (isset($_GET['newsales'])) {
    $obj->newcart(@$_SESSION['SESS_CART']);
    $obj->Success("New Sales Receipt Has Been Created Successfully", $obj->filename());
}

$cart = $obj->cart(@$_SESSION['SESS_CART']);
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
                            <h5><i class="font-plus-sign"></i> Edit Profile </h5>
                            <ul class="icons">
                                <li><a href="<?php echo $obj->filename(); ?>" class="hovertip" title="Reload"><i class="font-refresh"></i></a></li>
                            </ul>
                        </div><!-- /page header -->

                        <div class="body">

                            <!-- Middle navigation standard -->
<?php //include('include/quicklink.php');  ?>
                            <!-- /middle navigation standard -->

                            <!-- Content container -->
                            <div class="container">




                                <!-- Content Start from here customized -->
                                

                                <form class="form-horizontal" method="get" name="invoice" action="create_invoice.php">
                                    <fieldset>
                                        <!-- General form elements -->
                                        <div class="row-fluid  span12 well">     
                                           <!-- Selects, dropdowns -->
                                            <div class="span6" style="padding:0px; margin:0px;">
                                                <div class="control-group">
                                                    <label class="control-label"> * Name :</label>
                                                    <div class="controls"><input class="span12" type="text" name="regular" /></div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label"> * Email </label>
                                                    <div class="controls"><input class="span12" type="text" name="regular" /></div>
                                                </div>
                                                
                                                <div class="control-group">
                                                    <label class="control-label"> New Logo: </label>
                                                    <div class="controls"><input class="span12" type="file" name="regular" /></div>
                                                </div>
                                                
                                                <div class="control-group">
                                                    <label class="control-label"> Street </label>
                                                    <div class="controls"><input class="span12" type="text" name="regular" /></div>
                                                </div>
                                                
                                                <div class="control-group">
                                                    <label class="control-label"> City </label>
                                                    <div class="controls"><input class="span12" type="text" name="regular" /></div>
                                                </div>
                                                
                                                <div class="control-group">
                                                    <label class="control-label"> State </label>
                                                    <div class="controls">
                                                        <input type="text" class="maskPct span4" value="" /></span>
                                                    </div>
                                                </div>
                                                
                                                
                                                
                                            </div>
                                            <!-- /selects, dropdowns -->



                                            <!-- Selects, dropdowns -->
                                            <div class="span6" style="padding:0px; margin:0px; float:right;">
                                                <div class="control-group">
                                                    <label class="control-label"> Zip </label>
                                                    <div class="controls">
                                                        <input class="span6" type="number" name="number" />
                                                    </div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label"> Country </label>
                                                    <div class="controls">
                                                        <select name="vendor" data-placeholder="Please Select..." class="select-search" tabindex="2">
                                                            <option value=""></option> 
                                                            <?php
                                                             for($i=1; $i<=99; $i++): ?>
                                                            <option  value="<?php echo $i; ?>"><?php echo $i; ?></option> 
                                                            <?php endfor; ?>
                                                       </select>
                                                    </div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label"> Phone </label>
                                                    <div class="controls"><input class="span4" type="number" name="number" /></div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label"> Website </label>
                                                    <div class="controls"><input class="span12" type="text" name="regular" /></div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label"> * Subdomain </label>
                                                    <div class="controls"><input class="span12" type="text" name="regular" /></div>
                                                </div>

                                                
                                                
                                                
                                                
                                                <div class="control-group">
                                                    <label class="control-label">&nbsp;</label>
                                                    <div class="controls"><button type="button" class="btn btn-success"><i class="icon-plus-sign"></i> Add Line Item </button></div>
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
