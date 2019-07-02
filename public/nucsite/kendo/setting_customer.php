<?php 
include('class/auth.php');
if($input_status==3 || $input_status==4)
{
	$obj->Error("Invalid Page Request.","index.php");
}
$table="setting_customer";
if(isset($_POST['create']))
{
	extract($_POST);
	$chk=$obj->exists_multiple($table,array("store_id"=>$input_by));
	if($chk==0)
	{
		if($obj->insert($table,array("store_id"=>$input_by,"no_email"=>$no_email,"customer_default"=>$customer_default,"sms_default"=>$sms_default, "multiple_contacts"=>$multiple_contacts,"email_activation"=>$email_activation, "date"=>date('Y-m-d'), "status"=>1))==1)
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
		if($obj->update($table,array("store_id"=>$input_by,"no_email"=>$no_email,"customer_default"=>$customer_default,"sms_default"=>$sms_default, "multiple_contacts"=>$multiple_contacts,"email_activation"=>$email_activation, "date"=>date('Y-m-d'), "status"=>1))==1)
		{
			$obj->Success("Successfully Saved",$obj->filename());
		}
		else
		{
			$obj->Error("Something is wrong, Try again.",$obj->filename());
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
        echo $cms->GeneralCss(array("kendo", "modal"));
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
                            <h5><i class="font-cogs"></i> Customer Setting </h5>
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
                                                            <span class="checked"><input style="opacity: 0;" name="no_email" value="1" class="style" <?php $noemail=$obj->SelectAllByVal($table,"store_id",$input_by,"no_email"); if($noemail!=0){ echo "checked"; } ?> type="checkbox"></span>
                                                        </div> Allow Customer with No Email
                                                    </label>
                                                    <div class="gap"></div>
                                                    <label class="checkbox"><div id="uniform-undefined" class="checker">
                                                            <span class="checked"><input style="opacity: 0;" name="sms_default" value="1" class="style" <?php $sms_default=$obj->SelectAllByVal($table,"store_id",$input_by,"sms_default"); if($sms_default!=0){ echo "checked"; } ?> type="checkbox"></span>
                                                        </div> Turn on SMS By Default
                                                    </label>
                                                    <div class="gap"></div>
                                                    <label class="checkbox"><div id="uniform-undefined" class="checker">
                                                            <span class="checked"><input style="opacity: 0;" name="multiple_contacts" value="1" class="style" <?php $multiple_contacts=$obj->SelectAllByVal($table,"store_id",$input_by,"multiple_contacts"); if($multiple_contacts!=0){ echo "checked"; } ?> type="checkbox"></span>
                                                        </div> Enable Multiple Contacts on Customers
                                                    </label>
                                                    <div class="gap"></div>
                                                    <label class="checkbox"><div id="uniform-undefined" class="checker">
                                                            <span class="checked"><input style="opacity: 0;" name="email_activation" value="1" class="style" <?php $email_activation=$obj->SelectAllByVal($table,"store_id",$input_by,"email_activation"); if($email_activation!=0){ echo "checked"; } ?> type="checkbox"></span>
                                                        </div> Enable Account Email link Activation
                                                    </label>
                                                    
                                                    
                                                    
                                                    <div class="gap"></div>
                                                    
                                                    <div class="control-group" style="margin-left:0px; padding-left:0px;">
                                                        <select name="customer_default" id="customer_default" data-placeholder="Please Select Defult Customer" style="width:300px;" class="select-search select2-offscreen" tabindex="-1">
                                                                <option value=""></option>                                                        		<?php
										$customer_default=$obj->SelectAllByVal($table,"store_id",$input_by,"customer_default"); 
                                                                 if($input_status==1)
                                                                 {
                                                                    $sqlpdata=$obj->SelectAll("coustomer");
                                                                 }
                                                                 else
                                                                 {
                                                                    $sqlpdata=$obj->SelectAllByID_Multiple("coustomer",array("input_by"=>$input_by)); 
                                                                 }
                                                                 if(!empty($sqlpdata))
                                                                 foreach($sqlpdata as $row):
                                                                 ?>
                           <option <?php if($row->id==$customer_default){ ?> selected <?php } ?> value="<?php  echo $row->id; ?>">
                                                                <?php echo $row->firstname." ".$row->lastname; ?>
                                                                    </option> 
                                                                <?php 
                                                                endforeach; ?> 
                                                                    <option value="0">Add New Customer</option> 
                                                            </select>
                                                    </div>
                                                    
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label">&nbsp;</label>
                                                    <div class="controls"><button type="submit" name="create" class="k-button"><i class="icon-cog"></i> Save Changes </button></div>
                                                </div>
                                                
                                                
                                            </div>
                                            <!-- /selects, dropdowns -->



                                            <!-- Selects, dropdowns -->
                                            
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
