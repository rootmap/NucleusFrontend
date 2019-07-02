<?php include('class/auth.php');   ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
        include './plugin/plugin.php';
        $cms = new CmsRootPlugin();
        echo $cms->GeneralCss(array("kendo"));
        ?>
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
                            <h5><i class="icon-th"></i> Warranty Search Info</h5>
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


                                <form class="form-horizontal" action="search_report.php" method="get">
                                    <fieldset>

                                        <!-- General form elements -->
                                        <div class="well row-fluid block">
                                            <div class="navbar">
                                                <div class="navbar-inner">
                                                    <h5><i class="icon-plus"></i>Search Ticket / CheckIn / Unlock Service</h5>
                                                </div>
                                            </div>

                                            <div class="control-group">
                                                <label class="control-label">Search Anything You Like :</label>
                                                <div class="controls" id="newcus">
                                                <input type="text" class="span6 k-textbox" id="search" name="search" />
                                                
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
            <?php
            include('include/footer.php');
            echo $cms->KendoFotter();
            ?>
            <!-- Right sidebar -->
            <?php //include('include/sidebar_right.php'); ?>
            <!-- /right sidebar -->

        </div>
        <!-- /main wrapper -->

    </body>
</html>
