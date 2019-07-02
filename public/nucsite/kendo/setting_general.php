<?php 
include('class/auth.php');
if($input_status==3 || $input_status==4)
{
	$obj->Error("Invalid Page Request.","index.php");
}
$table="setting_general";
$timezoneIderntifiers = DateTimeZone::listIdentifiers();
if(isset($_POST['create']))
{
	extract($_POST);
	if(!empty($time_zone) && !empty($admin_email))
	{
		if($obj->exists_multiple($table,array("store_id"=>$input_by))==0)
		{
			if($obj->insert($table,array("time_zone"=>$time_zone,"store_id"=>$input_by,"admin_email"=>$admin_email, "date"=>date('Y-m-d'),"status"=>1))==1)
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
			if($obj->update($table,array("store_id"=>$input_by,"time_zone"=>$time_zone,"admin_email"=>$admin_email, "date"=>date('Y-m-d'),"status"=>1))==1)
			{
				$obj->Success("Successfully Saved", $obj->filename());
			}
			else
			{
				$obj->Error("Something is wrong, Try again.", $obj->filename());
			}

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
                            <h5><i class="font-cogs"></i> General Setting | Current Time : <?php echo date('h:i:s'); ?></h5>
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
                                           <?php
										   $chk=$obj->exists_multiple($table,array("store_id"=>$input_by));
										   if($chk!=0)
										   {
												$xtimezone=$obj->SelectAllByVal($table,"store_id",$input_by,"time_zone");
												$xemail=$obj->SelectAllByVal($table,"store_id",$input_by,"admin_email");   
										   }
										   else
										   {
											   $xtimezone="";
												$xemail="";
										   }
										   ?>
                                            <div class="span6" style="padding:0px; margin:0px;">
                                                <div class="control-group">
                                                    <label class="span12"> Time Zone :</label>
                                                    <select name="time_zone" style="width: 200px;" tabindex="2">
                                                            <option value=""></option> 
                                                            <?php
															//$sqltimezone=$obj->SelectAll("timezone");
															//if(!empty($sqltimezone))
                                                            foreach($timezoneIderntifiers as $timezone): 
															
															?>
                                                            <option <?php if($xtimezone==$timezone){ ?> selected <?php } ?>  value="<?php echo $timezone; ?>"><?php echo $timezone; ?></option> 
                                                            <?php endforeach; ?>
                                                       </select>
                                                </div>
                                                
                                                
                                                
                                                
                                            </div>
                                            <!-- /selects, dropdowns -->



                                            <!-- Selects, dropdowns -->
                                            <div class="span6" style="padding:0px; margin:0px; float:right;">
                                                <div class="control-group">
                                                    <label class="span12"> Admin Notification Email </label>
                                                        <input value="<?php echo $xemail; ?>" class="span10 k-textbox" type="text" name="admin_email" />
                                                </div>

                                                
                                                <div class="control-group">
            <button type="submit" name="create" class="k-button"><i class="icon-cog"></i> Save Changes </button>
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
            
            
            <script>
                nucleus("select[name='time_zone']").kendoDropDownList({
                    optionLabel: " Please Select Time Zone  "
                }).data("kendoDropDownList").select(0);
            
            </script>
            
            
            <?php //include('include/footer.php'); ?>
            <!-- Right sidebar -->
            <?php //include('include/sidebar_right.php');  ?>
            <!-- /right sidebar -->

        </div>
        <!-- /main wrapper -->

    </body>
</html>
