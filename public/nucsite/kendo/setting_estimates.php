<?php 
include('class/auth.php');
if($input_status==3 || $input_status==4)
{
	$obj->Error("Invalid Page Request.","index.php");
}
$table="setting_estimates";
if(isset($_POST['create']))
{
	extract($_POST);
	$chk=$obj->insert($table,array("store_id"=>$input_by));
	if($chk==0)
	{
		if($obj->insert($table,array("store_id"=>$input_by,"enable_estimates"=>$enable_estimates, "donot_inven"=>$donot_inven, "last_est_num"=>$last_est_num, 
		"date"=>date('Y-m-d'), "status"=>1))==1)
		{
			$obj->Success("Successfully Changed", $obj->filename());
		}
		else
		{
			$obj->Error("Something is wrong, Try again.", $obj->filename());
		}
	}
	else
	{
		if($obj->update($table,array("store_id"=>$input_by,"enable_estimates"=>$enable_estimates, "donot_inven"=>$donot_inven, "last_est_num"=>$last_est_num, 
		"date"=>date('Y-m-d'), "status"=>1))==1)
		{
			$obj->Success("Successfully Changed", $obj->filename());
		}
		else
		{
			$obj->Error("Something is wrong, Try again.", $obj->filename());
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
        <?php //echo $obj->bodyhead(); ?>
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
                            <h5><i class="font-cogs"></i> Estimates Setting </h5>
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
                                                            <span class="checked"><input style="opacity: 0;" name="enable_estimates" value="1" class="style" <?php $enable_estimates=$obj->SelectAllByVal($table,"store_id",$input_by,"enable_estimates"); if($enable_estimates!=0){ echo "checked"; } ?> type="checkbox"></span>
                                                        </div> Enable Estimates Module
                                                    </label>
                                                    <div class="gap"></div>
                                                    <label class="checkbox"><div id="uniform-undefined" class="checker">
                                                            <span class="checked"><input style="opacity: 0;" name="donot_inven" value="1" class="style" <?php $donot_inven=$obj->SelectAllByVal($table,"store_id",$input_by,"donot_inven"); if($donot_inven!=0){ echo "checked"; } ?> type="checkbox"></span>
                                                        </div> Do not pull inventory for estimates
                                                    </label>
                                                    <div class="gap"></div>
                                                    
                                                </div>

                                                
                                                
                                                
                                                
                                            </div>
                                            <!-- /selects, dropdowns -->



                                            <!-- Selects, dropdowns -->
                                            <div class="span6" style="padding:0px; margin:0px; float:right;">
                                                
                                                <div class="control-group">
                                                    <label class="control-label">&nbsp;</label>
                                                    <div class="controls"><button type="submit" name="create" class="k-button"><i class="icon-cog"></i> Save Changes </button></div>
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
            <?php
            include('include/footer.php');
            echo $cms->KendoFotter();
            ?>
            <?php //include('include/footer.php'); ?>
            <!-- Right sidebar -->
            <?php //include('include/sidebar_right.php');  ?>
            <!-- /right sidebar -->

        </div>
        <!-- /main wrapper -->

    </body>
</html>
