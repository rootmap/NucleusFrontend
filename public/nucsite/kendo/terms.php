<?php
include('class/auth.php');
$store_id = $obj->SelectAllByVal("store","id",$_SESSION['SESS_AMSIT_APPS_ID'],"store_id");
$table="setting_report";
if(isset($_POST['editterms']))
{
	extract($_POST);
	if(!empty($fotter))
	{
		$updatedetails=array("store_id"=>$store_id,"fotter"=>$fotter);
		if($obj->update($table,$updatedetails)==1)
		{
			$obj->Success("Successfully Updated", $obj->filename());
		}
		else
		{
			$obj->Error("Something is wrong, Try again.", $obj->filename());
		}
	}
	else
	{
		$obj->Error("Failed, Fill up required field", $obj->filename());
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
                            <h5><i class="font-barcode"></i>  Terms & Conditions </h5>
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

								<?php
									$terms=$obj->SelectAllByVal("setting_report","store_id",$store_id,"fotter");
								?>
                                <form class="form-horizontal" method="post" name="invoice" action="<?php echo $obj->filename(); ?>">
                                    <fieldset>
                                        <!-- General form elements -->
                                        <div class="row-fluid  span12 well">     
                                           <!-- Selects, dropdowns -->
                                            <div class="span6" style="padding:0px; margin:0px;">
                                                <div class="control-group">
                                                    <label class="span12"> * Terms :</label>
                                                   <textarea class="span12" name="fotter" id="fotter" rows="15" cols="100"><?=$terms?></textarea>
                                                </div>
                                                
                                                <div class="control-group">
                                                    <button type="submit" name="editterms" class="btn btn-success"><i class="icon-plus-sign"></i> Update Terms </button>
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
