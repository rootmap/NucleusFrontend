<?php
include('class/auth.php');
$table="payment";
if(isset($_POST['create']))
{
	extract($_POST);
	if(!empty($name) && !empty($email) && !empty($street) && !empty($city) && !empty($state) && !empty($zip) && 
	!empty($country) && !empty($phone) && !empty($website) &&  !empty($subdomain))
	{
		if(!empty($_FILES['image']['name']))
		{
			$image=$obj->upload_fiximage($destination,"image","store");
		}
		else
		{
			$image="";	
		}
		
		if($obj->insert($table,array("name"=>$name, "email"=>$email, "image"=>$image, "street"=>$street, "city"=>$city, "state"=>$state, "zip"=>$zip, 
		"country"=>$country, "phone"=>$phone, "website"=>$website, "subdomain"=>$subdomain, "date"=>date('Y-m-d'), "status"=>1))==1)
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
                            <h5><i class="font-plus-sign"></i> Add New Store </h5>
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

                                <!-- /middle navigation standard -->
                            <a href="payment.php" class="btn btn-success"><i class="icon-plus-sign"></i> Add New Payment</a>
                            <a href="setting_paymentmethod.php" class="btn btn-success"><i class="icon-tasks"></i> Payment List</a>
                            <!-- Content container -->
                            
                            <br><br>


                                <!-- Content Start from here customized -->
                                

                                <form class="form-horizontal" method="post" name="invoice" action="<?php /*?>create_invoice.php<?php */?>">
                                    <fieldset>
                                        <!-- General form elements -->
                                        <div class="row-fluid  span12 well">     
                                           <!-- Selects, dropdowns -->
                                            <div class="span6" style="padding:0px; margin:0px;">
                                                <div class="control-group">
                                                    <label class="control-label"> * Name :</label>
                                                    <div class="controls"><input class="span12" type="text" name="name" /></div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label"> * Email </label>
                                                    <div class="controls"><input class="span12" type="text" name="email" /></div>
                                                </div>
                                                
                                                <div class="control-group">
                                                    <label class="control-label"> New Logo: </label>
                                                    <div class="controls"><input class="span12" type="file" name="image" /></div>
                                                </div>
                                                
                                                <div class="control-group">
                                                    <label class="control-label"> Street </label>
                                                    <div class="controls"><input class="span12" type="text" name="street" /></div>
                                                </div>
                                                
                                                <div class="control-group">
                                                    <label class="control-label"> City </label>
                                                    <div class="controls"><input class="span12" type="text" name="city" /></div>
                                                </div>
                                                
                                                <div class="control-group">
                                                    <label class="control-label"> State </label>
                                                    <div class="controls">
                                                        <input type="text" class="span12" name="state" /></span>
                                                    </div>
                                                </div>
                                                
                                                
                                                
                                            </div>
                                            <!-- /selects, dropdowns -->



                                            <!-- Selects, dropdowns -->
                                            <div class="span6" style="padding:0px; margin:0px; float:right;">
                                                <div class="control-group">
                                                    <label class="control-label"> Zip </label>
                                                    <div class="controls">
                                                        <input class="span6" type="number" name="zip" />
                                                    </div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label"> Country </label>
                                                    <div class="controls">
                                                        <select name="country" data-placeholder="Please Select..." class="select-search" tabindex="2">
                                                            <option value="1"></option> 
                                                            <?php
                                                             for($i=1; $i<=99; $i++): ?>
                                                            <option  value="<?php echo $i; ?>"><?php echo $i; ?></option> 
                                                            <?php endfor; ?>
                                                       </select>
                                                    </div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label"> Phone </label>
                                                    <div class="controls"><input class="span4" type="number" name="phone" /></div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label"> Website </label>
                                                    <div class="controls"><input class="span12" type="text" name="website" /></div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label"> * Subdomain </label>
                                                    <div class="controls"><input class="span12" type="text" name="subdomain" /></div>
                                                </div>

                                                
                                                
                                                
                                                
                                                <div class="control-group">
                                                    <label class="control-label">&nbsp;</label>
                                                    <div class="controls"><button type="submit" name="create" class="btn btn-success">
                                                    <i class="icon-plus-sign"></i> Add Line Item </button></div>
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
