<?php include('class/auth.php');  

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php echo $obj->bodyhead(); ?>
        <script src="ajax/customer_ajax.js"></script>
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
                            <h5><i class="font-home"></i>Invoice Info</h5>
                            <ul class="icons">
                                <li><a href="<?php echo $obj->filename(); ?>" class="hovertip" title="Reload"><i class="font-refresh"></i></a></li>
                            </ul>
                        </div><!-- /page header -->

                        <div class="body">

                            <!-- Middle navigation standard -->
                            <?php include('include/quicklink.php'); ?>
                            <!-- /middle navigation standard -->

                            <!-- Content container -->
                            <div class="container">

                                <div class="separator-doubled"></div> 



                                <!-- Content Start from here customized -->


                                <form class="form-horizontal">
                                    <fieldset>

                                        <!-- General form elements -->
                                        <div class="well row-fluid block">
                                            <div class="navbar">
                                                <div class="navbar-inner">
                                                    <h5><i class="icon-plus"></i>New Invoice</h5>
                                                    <ul class="icons">
                                                        <li><a data-original-title="Tooltip on left" data-placement="left" href="invoice_list.php" class="hovertip" title="Invoice List"><i class="icon-th-large"></i></a></li>
                                                        <li><a data-original-title="Tooltip on left" data-placement="left" href="<?php echo $obj->filename(); ?>" class="hovertip" title="FAQ?"><i class="icon-fire"></i></a></li>
                                                        <li><a data-original-title="Tooltip on right" data-placement="right" href="<?php echo $obj->filename(); ?>" class="hovertip" title="Reload Page"><i class="icon-refresh"></i></a></li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <div class="control-group">
                                                <label class="control-label">Select Customer:</label>
                                                <div class="controls" id="newcus">
                                                <select name="customername" onChange="new_customer(this.value)" id="customername" data-placeholder="Choose a Customer..." class="select-search select2-offscreen" tabindex="-1">
                                                        <option value=""></option> 
                                                        <?php
														 $sqlpdata=$obj->SelectAll("coustomer");
														 if(!empty($sqlpdata))
														 foreach($sqlpdata as $row):
														?>
															<option value="<?php  echo $row->id; ?>">
														<?php echo $row->firstname." ".$row->lastname; ?>
															</option> 
														<?php endforeach; ?> 
															<option value="0">Add New Customer</option> 
                                                    </select>
                                                
                                                </div>
                                            </div>

                                            <div class="control-group">
                                                <label class="control-label">&nbsp;</label>
                                                <div class="controls" id="but">
                                                    
                                                </div>
                                            </div>


                                        </div>
                                        <!-- /general form elements -->
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
            <?php //include('include/sidebar_right.php'); ?>
            <!-- /right sidebar -->

        </div>
        <!-- /main wrapper -->

    </body>
</html>
