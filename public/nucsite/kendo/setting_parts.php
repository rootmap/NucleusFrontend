<?php 
include('class/auth.php');
if($input_status==3 || $input_status==4)
{
	$obj->Error("Invalid Page Request.","index.php");
}
$table="setting_parts";
if(isset($_POST['create']))
{
	extract($_POST);
	$chk=$obj->insert($table,array("store_id"=>$input_by));
	if($chk==0)
	{
		if($obj->insert($table,array("store_id"=>$input_by,"parts_email"=>$parts_email, "date"=>date('Y-m-d'), "status"=>1))==1)
		{
			$obj->Success("Successfully Saved", $obj->filename());
		}
		else
		{
			$obj->Error("Something is wrong, Try again.", $obj->filename());
		}
	}
	else
	{
		if($obj->update($table,array("store_id"=>$input_by,"parts_email"=>$parts_email, "date"=>date('Y-m-d'), "status"=>1))==1)
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
                            <h5><i class="font-cogs"></i> Parts Setting </h5>
                            <ul class="icons">
                                <li><a href="<?php echo $obj->filename(); ?>" class="hovertip" title="Reload"><i class="font-refresh"></i></a></li>
                            </ul>
                        </div><!-- /page header -->

                        <div class="body">
                            <!--Middle navigation standard-->
                            
                            <!--Middle navigation standard-->
                            <!--Content container-->
                            <div class="container">




                                <!-- Content Start from here customized -->
                                

                                <form class="form-horizontal" method="post" name="invoice" action="">
                                    <fieldset>
                                        <!-- General form elements -->
                                        <div class="row-fluid  span6 well">     
                                            <!-- Selects, dropdowns -->
                                                
                                                <div class="control-group">
                                                    <label class="span12"> Parts Email (for internal notifications of a new part order request) </label>
                                                        <input value="<?php echo $obj->SelectAllByVal($table,"store_id",$input_by,"parts_email"); ?>" class="span6 k-textbox" type="text" name="parts_email" />
                                                </div>
                                                
                                                <div class="control-group">
                                                    <label class="control-label">&nbsp;</label>
                                                    <div class="controls"><button type="submit" name="create" class="k-button"><i class="icon-cog"></i> Save Changes </button></div>
                                                </div>
                                            </div>
                                            <!-- /selects, dropdowns -->

                                           
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
