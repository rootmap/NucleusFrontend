<?php 
include('class/auth.php');
if($input_status==3 || $input_status==4)
{
	$obj->Error("Invalid Page Request.","index.php");
}
$table="setting_invoice";
if(isset($_POST['create']))
{
	extract($_POST);
		if($obj->insert($table,array("disable_tax"=>$disable_tax, "disable_payments"=>$disable_payment, "enable_diposits"=>$enable_deposits, 
		"enable_multiple"=>$enable_multi_tax, "save_invoices"=>$save_invoices, "enable_elec_signatures"=>$enable_electro, 
		"enable_topaz_signature"=>$enable_topaz, "donot_pdf"=>$donot_pdf, "donot_excel"=>$donot_excel, "vat_reg_num"=>$vat_reg_num, 
		"last_invo_num"=>$last_invo_num, "local_tax"=>$local_tax, "date"=>date('Y-m-d'), "status"=>1))==1)
		{
			$obj->Success("Successfully Saved", $obj->filename());
		}
		else
		{
			$obj->Error("Something is wrong, Try again.", $obj->filename());
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
                            <h5><i class="font-cogs"></i> Invoice Setting </h5>
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
                                

                                <form class="form-horizontal" method="post" name="invoice" action="">
                                    <fieldset>
                                        <!-- General form elements -->
                                        <div class="row-fluid  span12 well">     
                                           <!-- Selects, dropdowns -->
                                            <div class="span6" style="padding:0px; margin:0px;">
                                                <div class="control-group">
                                                    <label class="checkbox"><div id="uniform-undefined" class="checker">
                                                            <span class="checked"><input style="opacity: 0;" name="disable_tax" value="1" class="style" checked="" type="checkbox"></span>
                                                        </div> Disable Tax
                                                    </label>
                                                    <div class="gap"></div>
                                                    <label class="checkbox"><div id="uniform-undefined" class="checker">
                                                            <span class="checked"><input style="opacity: 0;" name="disable_payment" value="1" class="style" checked="" type="checkbox"></span>
                                                        </div> Disable Quick Payments button
                                                    </label>
                                                    <div class="gap"></div>
                                                    <label class="checkbox"><div id="uniform-undefined" class="checker">
                                                            <span class="checked"><input style="opacity: 0;" name="enable_deposits" value="1" class="style" checked="" type="checkbox"></span>
                                                        </div> Enable the Deposits feature
                                                    </label>
                                                    <div class="gap"></div>
                                                    <label class="checkbox"><div id="uniform-undefined" class="checker">
                                                            <span class="checked"><input style="opacity: 0;" name="enable_multi_tax" value="1" class="style" checked="" type="checkbox"></span>
                                                        </div> Enable Multiple Tax Rates
                                                    </label>
                                                    <div class="gap"></div>
                                                    <label class="checkbox"><div id="uniform-undefined" class="checker">
                                                            <span class="checked"><input style="opacity: 0;" name="save_invoices" value="1" class="style" checked="" type="checkbox"></span>
                                                        </div> Save Invoices to Dropbox
                                                    </label>
                                                    <div class="gap"></div>
                                                    <label class="checkbox"><div id="uniform-undefined" class="checker">
                                                            <span class="checked"><input style="opacity: 0;" name="enable_electro" value="1" class="style" checked="" type="checkbox"></span>
                                                        </div> Enable electronic signatures on Payment screen
                                                    </label>
                                                    <div class="gap"></div>
                                                    <label class="checkbox"><div id="uniform-undefined" class="checker">
                                                            <span class="checked"><input style="opacity: 0;" name="enable_topaz" value="1" class="style" checked="" type="checkbox"></span>
                                                        </div> Enable Topaz Signature Pad
                                                    </label>
                                                    <div class="gap"></div>
                                                    
                                                    <label class="checkbox"><div id="uniform-undefined" class="checker">
                                                            <span class="checked"><input style="opacity: 0;" name="donot_pdf" value="1" class="style" checked="" type="checkbox"></span>
                                                        </div> Do not include the Ticket details on the Invoice PDF
                                                    </label>
                                                    <div class="gap"></div>
                                                    
                                                    <label class="checkbox"><div id="uniform-undefined" class="checker">
                                                            <span class="checked"><input style="opacity: 0;" name="donot_excel" value="1" class="style" checked="" type="checkbox"></span>
                                                        </div> Do not include the Ticket details on the Invoice Excel
                                                    </label>
                                                    <div class="gap"></div>
                                                </div>

                                                
                                                
                                                
                                                
                                            </div>
                                            <!-- /selects, dropdowns -->



                                            <!-- Selects, dropdowns -->
                                            <div class="span6" style="padding:0px; margin:0px; float:right;">
                                                
                                                <div class="control-group">
                                                    <label class="span12"> VAT Registration Number </label>
                                                        <input class="span10" type="text" name="vat_reg_num" />
                                                </div>
                                                
                                                <div class="control-group">
                                                    <label class="span12"> Last Invoice Number </label>
                                                        <input class="span3" type="number" name="last_invo_num" />
                                                </div>
                                                
                                                <div class="control-group">
                                                    <label class="span12"> Local tax rate </label>
                                                        <input class="span3" type="text" name="local_tax" />
                                                </div>

                                                
                                                <div class="control-group">
                                                    <label class="control-label">&nbsp;</label>
                                                    <div class="controls"><button type="submit" name="create" class="btn btn-success"><i class="icon-cog"></i> Save Changes </button></div>
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
