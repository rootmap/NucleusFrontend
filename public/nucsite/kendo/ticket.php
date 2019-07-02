<?php include('class/auth.php'); ?>
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
                            <h5><i class="font-tag"></i> Ticket Info</h5>
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


                                <form class="form-horizontal">
                                    <fieldset>

                                        <!-- General form elements -->
                                        <span id="mess"></span>
                                        <div class="control-group" id="newcus">
                                            <label class="control-label">Select Customer:</label>
                                            <div class="controls">
                                                <select name="customername" onChange="newcustomerticket(this.value)" id="customername" style="width: 210px;">
                                                    <option value="0">Add New Customer</option> 
                                                    <option value="<?php echo $def_cus; ?>"><?php echo $obj->SelectAllByVal("customer_list", "id", $def_cus, "fullname"); ?></option>
                                                    <?php
                                                    if ($input_status == 1) {
                                                        $sqlpdata = $obj->SelectAll("coustomer");
                                                    } else {
                                                        $sqlpdata = $obj->SelectAllByID("coustomer", array("input_by" => $input_by));
                                                    }
                                                    if (!empty($sqlpdata))
                                                        foreach ($sqlpdata as $row):
                                                            if ($row->id != $def_cus) {
                                                                ?>
                                                                <option value="<?php echo $row->id; ?>">
                                                                    <?php echo $row->firstname . " " . $row->lastname; ?>
                                                                </option> 
                                                                <?php
                                                            }
                                                        endforeach;
                                                    ?> 

                                                </select>

                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label">&nbsp;</label>
                                            <div class="controls" id="but">

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
            <script>
                nucleus("#customername").kendoDropDownList({
                    optionLabel: " -- Select A Customer For Ticket -- "
                }).data("kendoDropDownList").select(0);

                
            </script> 

        </div>
        <!-- /main wrapper -->

    </body>
</html>