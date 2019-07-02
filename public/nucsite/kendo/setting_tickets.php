<?php 
include('class/auth.php');
if($input_status==3 || $input_status==4)
{
	$obj->Error("Invalid Page Request.","index.php");
}
$table="setting_tickets";
if(isset($_POST['create']))
{
	extract($_POST);
		if($obj->insert($table,array("send_diag_daily"=>$send_diag_remind, "send_diag_hourly"=>$send_diag_hourly, 
		"copy_pri_tic_update"=>$copy_pri_tic_update, "required_in_form"=>$require_in_form, "tic_donot_email"=>$tic_donot_email, 
		"enable_due_date"=>$enable_due_date, "enable_tic_assi"=>$enable_tic_assig, "enable_tic_form"=>$cre_tic_form, 
		"enable_tic_time"=>$enable_tic_time, "enable_recur_tic"=>$enable_recurr_tic,"hide_tic_status"=>$hide_tic_status, 
		"show_tic_type"=>$show_tic_type, "enable_tic_priori"=>$enable_tic_priori, "sub_tic_com_email"=>$sub_tic_com_email, 
		"private_sta_email"=>$pri_staf_email, "inbo_email_alias"=>$inbo_email_alias, "tech_rem_email"=>$tech_rem_email, 
		"tic_prob_type"=>$tic_prob_type,"tic_sta_list"=>$tic_sta_list, "date"=>date('Y-m-d'), "status"=>1))==1)
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
                            <h5><i class="font-cogs"></i> Tickets Setting </h5>
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
                                        <div class="row-fluid  span12 well">     
                                           <!-- Selects, dropdowns -->
                                            <div class="span6" style="padding:0px; margin:0px;">
                                                <div class="control-group">
                                                    <label class="checkbox"><div id="uniform-undefined" class="checker">
                                                            <span class="checked"><input style="opacity: 0;" name="send_diag_remind" value="1" class="style" checked="" type="checkbox"></span>
                                                        </div> Send Diagnosis Reminders: Daily
                                                    </label>
                                                    <div class="gap"></div>
                                                    <label class="checkbox"><div id="uniform-undefined" class="checker">
                                                            <span class="checked"><input style="opacity: 0;" name="send_diag_hourly" value="1" class="style" checked="" type="checkbox"></span>
                                                        </div> Send Diagnosis Reminders: Hourly
                                                    </label>
                                                    <div class="gap"></div>
                                                    
                                                    <label class="checkbox"><div id="uniform-undefined" class="checker">
                                                            <span class="checked"><input style="opacity: 0;" name="copy_pri_tic_update" value="1" class="style" checked="" type="checkbox"></span>
                                                        </div> Copy private Ticket update emails to hidden comment email
                                                    </label>
                                                    <div class="gap"></div>
                                                    
                                                    <label class="checkbox"><div id="uniform-undefined" class="checker">
                                                            <span class="checked"><input style="opacity: 0;" name="require_in_form" value="1" class="style" checked="" type="checkbox"></span>
                                                        </div> Require Intake Form with Ticket
                                                    </label>
                                                    <div class="gap"></div>
                                                    
                                                    <label class="checkbox"><div id="uniform-undefined" class="checker">
                                                            <span class="checked"><input style="opacity: 0;" name="tic_donot_email" value="1" class="style" checked="" type="checkbox"></span>
                                                        </div> Tickets do not email initial problem by default
                                                    </label>
                                                    <div class="gap"></div>
                                                    
                                                    <label class="checkbox"><div id="uniform-undefined" class="checker">
                                                            <span class="checked"><input style="opacity: 0;" name="enable_due_date" value="1" class="style" checked="" type="checkbox"></span>
                                                        </div> Enable Due Dates
                                                    </label>
                                                    <div class="gap"></div>
                                                    
                                                    <label class="checkbox"><div id="uniform-undefined" class="checker">
                                                            <span class="checked"><input style="opacity: 0;" name="enable_tic_assig" value="1" class="style" checked="" type="checkbox"></span>
                                                        </div> Enable Ticket Assignment
                                                    </label>
                                                    <div class="gap"></div>
                                                    
                                                    <label class="checkbox"><div id="uniform-undefined" class="checker">
                                                            <span class="checked"><input style="opacity: 0;" name="cre_tic_form" value="1" class="style" checked="" type="checkbox"></span>
                                                        </div> Create Tickets from Leads (if valid)
                                                    </label>
                                                    <div class="gap"></div>
                                                    
                                                    <label class="checkbox"><div id="uniform-undefined" class="checker">
                                                            <span class="checked"><input style="opacity: 0;" name="enable_tic_time" value="1" class="style" checked="" type="checkbox"></span>
                                                        </div> Enable Ticket Time Tracking module
                                                    </label>
                                                    <div class="gap"></div>
                                                    
                                                    <label class="checkbox"><div id="uniform-undefined" class="checker">
                                                            <span class="checked"><input style="opacity: 0;" name="enable_recurr_tic" value="1" class="style" checked="" type="checkbox"></span>
                                                        </div> Enable Recurring Tickets
                                                    </label>
                                                    <div class="gap"></div>
                                                    
                                                    
                                                    <label class="checkbox"><div id="uniform-undefined" class="checker">
                                                            <span class="checked"><input style="opacity: 0;" name="hide_tic_status" value="1" class="style" checked="" type="checkbox"></span>
                                                        </div> Hide Ticket Status in Customer Portal
                                                    </label>
                                                    <div class="gap"></div>
                                                    
                                                    
                                                    <label class="checkbox"><div id="uniform-undefined" class="checker">
                                                            <span class="checked"><input style="opacity: 0;" name="show_tic_type" value="1" class="style" checked="" type="checkbox"></span>
                                                        </div> Show Ticket Types in Tickets List Page
                                                    </label>
                                                    <div class="gap"></div>
                                                    
                                                    
                                                    <label class="checkbox"><div id="uniform-undefined" class="checker">
                                                            <span class="checked"><input style="opacity: 0;" name="enable_tic_priori" value="1" class="style" checked="" type="checkbox"></span>
                                                        </div> Enable Ticket Priorities
                                                    </label>
                                                    <div class="gap"></div>
                                                    
                                                </div>

                                                
                                                
                                                
                                                
                                            </div>
                                            <!-- /selects, dropdowns -->



                                            <!-- Selects, dropdowns -->
                                            <div class="span6" style="padding:0px; margin:0px; float:right;">
                                                
                                                <div class="control-group">
                                                    <label class="span12"> Subject for Ticket Comment Emails </label>
                                                        <input class="span10" type="text" name="sub_tic_com_email" />
                                                </div>
                                                
                                                <div class="control-group">
                                                    <label class="span12"> Private Staff Email (we send many notifications here) </label>
                                                        <input class="span10" type="text" name="pri_staf_email" />
                                                </div>
                                                
                                                <div class="control-group">
                                                    <label class="span12"> Inbound Email Alias (defaults to: fixaphone@reply.repairshopr.com) </label>
                                                        <input class="span10" type="text" name="inbo_email_alias" />
                                                </div>
                                                
                                                <div class="control-group">
                                                    <label class="span12"> Tech Reminder Email (We send some reminder notifications here that are meant to go to all your technicians) </label>
                                                        <input class="span10" type="text" name="tech_rem_email" />
                                                </div>
                                                
                                                <div class="control-group">
                                                    <label class="span12"> Ticket problem types </label>
                                                        <input class="span10" type="text" name="tic_prob_type" />
                                                </div>
                                                
                                                <div class="control-group">
                                                    <label class="span12"> Ticket status list </label>
                                                        <input class="span10" type="text" name="tic_sta_list" />
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
