<?php 
include('class/auth.php');
if($input_status==3 || $input_status==4)
{
	$obj->Error("Invalid Page Request.","index.php");
}
include('class/db_Class2.php');
$obj_site=new db_class_site();
$table="store";
$destination="store";
if(isset($_POST['create']))
{
	extract($_POST);
	if(!empty($store_name) && !empty($email) && !empty($password) && !empty($phone))
	{

			$image="";	
		
		$chk=$obj->exists_multiple($table,array("username"=>$store_name));
		if($chk==0)
		{
			$chks=$obj->exists_multiple($table,array("email"=>$email));
			if($chks==0)
			{
				if($input_status==1)
				{
					$store_id=time();
				}
				elseif($input_status==2)
				{
					$store_id=$input_by;
				}
				elseif($input_status==4)
				{
					$store_id=$input_by;
				}
				elseif($input_status==3)
				{
					$store_id=0;
				}
				
				if($store_id!=0)
				{
					$obj_site->update($table,array("email"=>$email,"phone"=>$phone,"f_name"=>$f_name,"l_name"=>$l_name,"store_name"=>$store_name,"password"=>$password,"business_type_id"=>$business_type_id,"approved_by"=>$input_by,"approved_date"=>$approved_date,"package_type"=>$package_type,"status"=>$status));
					if($status==1)
					{
						$obj->insert("setting_customer",array("store_id"=>$input_by,"no_email"=>0,"sms_default"=>0,"multiple_contacts"=>0,"email_activation"=>0,"date"=>date('Y-m-d'),"status"=>1));
						
						$obj->insert("setting_estimates",array("store_id"=>$input_by,"enable_estimates"=>0,"donot_inven"=>0,"date"=>date('Y-m-d'),"status"=>1));
						
						if($obj->insert($table,array("name"=>$store_name, "store_id"=>$store_id,"email"=>$email,"username"=>$store_name,"password"=>$obj->password($password), "phone"=>$phone,"date"=>date('Y-m-d'), "status"=>2))==1)
						{
							$obj->Success("Successfully Store Saved", $obj->filename()."?edit=".$edit);
						}
						else
						{
							$obj->Error("Something is wrong, Try again.", $obj->filename()."?edit=".$edit);
						}
						
					}
					else
					{
						$obj->Success("Info Saved", $obj->filename()."?edit=".$edit);
					}
				}
				else
				{
					$obj->Error("You Are Not Authorized.", $obj->filename()."?edit=".$edit);	
				}
				
			}
			else
			{
				$obj_site->update($table,array("email"=>$email,"phone"=>$phone,"f_name"=>$f_name,"l_name"=>$l_name,"store_name"=>$store_name,"password"=>$password,"business_type_id"=>$business_type_id,"approved_by"=>$input_by,"approved_date"=>$approved_date,"package_type"=>$package_type,"status"=>$status));
				if($status==1)
				{
					$obj->update($table,array("email"=>$email,"name"=>$store_name,"username"=>$store_name,"password"=>$obj->password($password), "phone"=>$phone));
					$obj->Success("Store Successfully  Updated", $obj->filename()."?edit=".$edit);	
				}
				else
				{
					$obj->Success("Info Updated", $obj->filename()."?edit=".$edit);
				}
				
			}
		}
		else
		{
			$obj_site->update($table,array("email"=>$email,"phone"=>$phone,"f_name"=>$f_name,"l_name"=>$l_name,"store_name"=>$store_name,"password"=>$password,"business_type_id"=>$business_type_id,"approved_by"=>$input_by,"approved_date"=>$approved_date,"package_type"=>$package_type,"status"=>$status));
			if($status==1)
			{
				$obj->update($table,array("email"=>$email,"name"=>$store_name,"username"=>$store_name,"password"=>$obj->password($password),"phone"=>$phone));
				$obj->Success("Store Successfully  Updated", $obj->filename()."?edit=".$edit);	
			}
			else
			{
				$obj->Success("Info Updated", $obj->filename()."?edit=".$edit);
			}
				
		}
	}
	else
	{
		$obj->Error("Failed, Fill up required field", $obj->filename()."?edit=".$edit);
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
                        	<?php if(isset($_GET['edit'])){ ?>
                            <h5><i class="icon-edit"></i> Edit Store Request Detail </h5>
                            <?php }else{ ?>
                            <h5><i class="font-plus-sign"></i> Add New Store </h5>
                            <?php } ?>
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
							
                            <form class="form-horizontal" method="post" enctype="multipart/form-data" name="invoice" action="">
                                    <fieldset>
                                    <input type="hidden" name="edit" value="<?php echo $_GET['edit']; ?>">
                                        <!-- General form elements -->
                                        <div class="row-fluid  span12 well">     
                                           <!-- Selects, dropdowns -->
                                            <div class="span6" style="padding:0px; margin:0px;">
                                                
                                                <div class="control-group">
                                                    <label class="control-label"> * Store Name :</label>
                                                    <div class="controls"><input value="<?php echo $obj_site->SelectAllByVal("store","id",$_GET['edit'],"store_name"); ?>" class="span12" type="text" name="store_name" /></div>
                                                </div>
                                                
                                                <div class="control-group">
                                                    <label class="control-label"> * First Name :</label>
                                                    <div class="controls"><input value="<?php echo $obj_site->SelectAllByVal("store","id",$_GET['edit'],"f_name"); ?>" class="span12" type="text" name="f_name" /></div>
                                                </div>
                                                
                                                <div class="control-group">
                                                    <label class="control-label"> * Last Name :</label>
                                                    <div class="controls"><input value="<?php echo $obj_site->SelectAllByVal("store","id",$_GET['edit'],"l_name"); ?>" class="span12" type="text" name="l_name" /></div>
                                                </div>
												<div class="control-group">
                                                    <label class="control-label"> Phone </label>
                                                    <div class="controls"><input  value="<?php echo $obj_site->SelectAllByVal("store","id",$_GET['edit'],"phone"); ?>" class="span4" type="number" name="phone" /></div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label"> * Email </label>
                                                    <div class="controls">
                                                    	<input value="<?php echo $obj_site->SelectAllByVal("store","id",$_GET['edit'],"email"); ?>" class="span12" type="text" name="email" />
                                                    </div>
                                                </div>
                                                
                                                
                                                
                                                <div class="control-group">
                                                    <label class="control-label"> * Password </label>
                                                    <div class="controls"><input value="<?php echo $obj_site->SelectAllByVal("store","id",$_GET['edit'],"password"); ?>" class="span12" type="text" name="password" /></div>
                                                </div>
                                                
                                                
                                            </div>
                                            <!-- /selects, dropdowns -->



                                            <!-- Selects, dropdowns -->
                                            <div class="span6" style="padding:0px; margin:0px; float:right;">
                                                
                                                <div class="control-group">
                                                    <label class="control-label"> * Approve Date </label>
                                                    <div class="controls">
                                                    	<input value="<?php echo $obj_site->SelectAllByVal("store","id",$_GET['edit'],"approved_date"); ?>" class="datepicker" type="text" name="approved_date" />
                                                    </div>
                                                </div>
                                                
                                                <div class="control-group">
                                                    <label class="control-label"> Expire Date </label>
                                                    <div class="controls">
                                                    <?php  
													$pack=$obj_site->SelectAllByVal("store","id",$_GET['edit'],"package_type");
													$availableday=$obj_site->SelectAllByVal("package_type","id",$pack,"available_day");
													$apdate=$obj_site->SelectAllByVal("store","id",$_GET['edit'],"approved_date");
													if($apdate!="0000-00-00")
													{
														if($pack!=0)
														{
															$datenews=date_create($apdate);
															date_modify($datenews,"+".$availableday." days");
															$expireon=date_format($datenews,"Y-m-d");
															$availabdd=$obj->daysgone($expireon,date('Y-m-d'));
														}
														else
														{
															$expireon="Package Not Selected Yet";
															$availabdd="nil";
														}
													}
													else
													{
														$expireon="Approve Date Not Selected Yet";
														$availabdd="nil";
													}
													?>
                                                    	<input disabled value="<?php echo $expireon; ?>" class="span6" type="text" name="expire_date" />
                                                    </div>
                                                </div>
                                                <?php  
												if($availabdd!="nil")
												{
												?>
                                                <div class="control-group">
                                                    <label class="control-label"> Day Left </label>
                                                    <div class="controls">
                                                    <input disabled value="<?php echo $availabdd; ?> Day" class="span6" type="text" name="abd" />
                                                    </div>
                                                </div>
                                                <?php } ?>
                                                <div class="control-group">
                                                    <label class="control-label"> Business Type </label>
                                                    <div class="controls">
                                                        <select name="business_type_id" data-placeholder="Business Type" class="select-search" tabindex="2">
                                                            <option value=""></option> 
                                                            <?php 
															$cc=$obj_site->SelectAllByVal("store","id",$_GET['edit'],"business_type_id");
															$sqlcountry=$obj_site->SelectAll("business_type");
															if(!empty($sqlcountry))
															foreach($sqlcountry as $country):
															?>
                                                            <option  <?php if($cc==$country->id){ ?> selected <?php } ?> value="<?php echo $country->id; ?>"><?php echo $country->name; ?></option> 
                                                            <?php endforeach; ?>
                                                       </select> <a href="business_type.php" class="label label-info" style="margin-top:3px; margin-left:4px; position:absolute;"><i class="icon-plus"></i></a>
                                                    </div>
                                                </div>


												<div class="control-group">
                                                    <label class="control-label"> Package Type </label>
                                                    <div class="controls">
                                                        <select name="package_type" data-placeholder="Package Type" class="select-search" tabindex="2">
                                                            <option value=""></option> 
                                                            <?php 
															
															$sqlcountry=$obj_site->SelectAll("package_type");
															if(!empty($sqlcountry))
															foreach($sqlcountry as $country):
															?>
                                                            <option  <?php if($pack==$country->id){ ?> selected <?php } ?> value="<?php echo $country->id; ?>"><?php echo $country->name; ?> - <?php echo $country->available_day; ?> Days</option> 
                                                            <?php endforeach; ?>
                                                       </select>  <a href="package_type.php" class="label label-info" style="margin-top:3px; margin-left:4px; position:absolute;"><i class="icon-plus"></i></a>
                                                    </div>
                                                </div>
                                                
                                                <div class="control-group">
                                                    <label class="control-label"> Choose Category </label>
                                                    <div class="controls">
                                                    	<?php 
														$reqst=$obj_site->SelectAllByVal($table,"id",$_GET['edit'],"status");
														?>
                                                        <select name="status" data-placeholder="status" class="select-search" tabindex="2">
                                                            <option value=""></option> 
                                                            <option <?php if($reqst==1){ ?> selected <?php } ?> value="1">Setup</option>
                                                            <option <?php if($reqst==2){ ?> selected <?php } ?> value="2">Not Setup</option>
                                                            <option <?php if($reqst==3){ ?> selected <?php } ?> value="3">Cancel</option> 
                                                            </select> 
                                                    </div>
                                                </div>


                                                
                                                                                        
                                                
                                                <div class="control-group">
                                                    <label class="control-label">&nbsp;</label>
                                                    <div class="controls"><button type="submit" name="create" class="btn btn-success">
                                                    <i class="icon-plus-sign"></i> Update Store Request Detail </button></div>
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
