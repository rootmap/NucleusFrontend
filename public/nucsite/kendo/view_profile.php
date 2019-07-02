<?php 
include('class/auth.php');
$table="store";
$destination="store";
if(isset($_POST['update']))
{
	extract($_POST);
	if(!empty($name) && !empty($email) && !empty($password) && !empty($city) && !empty($state) && !empty($zip) && 
	!empty($country) && !empty($phone))
	{
		if(!empty($_FILES['image']['name']))
		{
			$image=$obj->upload_image(28,28,$destination,"image","store");
		}
		else
		{
			$image=$eximg;	
		}
		
		if($expass==$password)
		{
			$pass=$expass;
		}
		else
		{
			$pass=$obj->password($password);	
		}
		
		if($exemail==$email)
		{
			$em=$exemail;
		}
		else
		{
			$em=$email;	
		}
		
				if($obj->update($table,array("id"=>$edit,"name"=>$name, "email"=>$email,"username"=>$username,"password"=>$pass, "image"=>$image, "street"=>$street, "city"=>$city, "state"=>$state, "zip"=>$zip, 
				"country"=>$country, "phone"=>$phone, "website"=>$website, "subdomain"=>$subdomain, "date"=>date('Y-m-d')))==1)
				{
					$obj->Success("Successfully Saved", $obj->filename()."?edit=".$edit);
				}
				else
				{
					$obj->Error("Something is wrong, Try again.", $obj->filename()."?edit=".$edit);
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
                            <h5><i class="icon-edit"></i> Edit Store/Profile Detail </h5>
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
							<?php if(isset($_GET['edit'])){ ?>
                            <form class="form-horizontal" method="post" enctype="multipart/form-data" name="invoice" action="">
                                    <fieldset>
                                    <input type="hidden" name="edit" value="<?php echo $_GET['edit']; ?>">
                                    <input type="hidden" name="eximg" value="<?php echo $obj->SelectAllByVal("store","id",$_GET['edit'],"image"); ?>">
                                    <input type="hidden" name="expass" value="<?php echo $obj->SelectAllByVal("store","id",$_GET['edit'],"password"); ?>">
                                    <input type="hidden" name="exemail" value="<?php echo $obj->SelectAllByVal("store","id",$_GET['edit'],"email"); ?>">
                                        <!-- General form elements -->
                                        <div class="row-fluid  span12 well">     
                                           <!-- Selects, dropdowns -->
                                            <div class="span6" style="padding:0px; margin:0px;">
                                                <div class="control-group">
                                                    <label class="control-label"> * Name :</label>
                                                    <div class="controls"><input value="<?php echo $obj->SelectAllByVal("store","id",$_GET['edit'],"name"); ?>" class="span12" type="text" name="name" /></div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label"> * Email </label>
                                                    <div class="controls"><input value="<?php echo $obj->SelectAllByVal("store","id",$_GET['edit'],"email"); ?>" class="span12" type="text" name="email" /></div>
                                                </div>
                                                
                                                <div class="control-group">
                                                    <label class="control-label"> * Username </label>
                                                    <div class="controls"><input value="<?php echo $obj->SelectAllByVal("store","id",$_GET['edit'],"username"); ?>" class="span12" readonly type="text" name="username" /></div>
                                                </div>
                                                
                                                <div class="control-group">
                                                    <label class="control-label"> * Password </label>
                                                    <div class="controls"><input value="<?php echo $obj->SelectAllByVal("store","id",$_GET['edit'],"password"); ?>" class="span12" type="password" name="password" /></div>
                                                </div>
                                                
                                                <div class="control-group">
                                                    <label class="control-label"> New Logo: </label>
                                                    <div class="controls">
                                                    <div class="span7"><input class="span12" type="file" name="image" /></div>
                                                    <div class="span5"><img src="store/<?php echo $obj->SelectAllByVal("store","id",$_GET['edit'],"image"); ?>"></div>
                                                    </div>
                                                </div>
                                                
                                                <div class="control-group">
                                                    <label class="control-label"> Street </label>
                                                    <div class="controls">
                                                    	<input value="<?php echo $obj->SelectAllByVal("store","id",$_GET['edit'],"street"); ?>" class="span12" type="text" name="street" />
                                                    </div>
                                                </div>
                                                
                                                <div class="control-group">
                                                    <label class="control-label"> City </label>
                                                    <div class="controls"><input  value="<?php echo $obj->SelectAllByVal("store","id",$_GET['edit'],"city"); ?>" class="span12" type="text" name="city" /></div>
                                                </div>
                                                
                                                
                                                
                                                
                                                
                                            </div>
                                            <!-- /selects, dropdowns -->



                                            <!-- Selects, dropdowns -->
                                            <div class="span6" style="padding:0px; margin:0px; float:right;">
                                                <div class="control-group">
                                                    <label class="control-label"> State </label>
                                                    <div class="controls">
                                                        <input type="text"  value="<?php echo $obj->SelectAllByVal("store","id",$_GET['edit'],"state"); ?>" class="span12" name="state" /></span>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label"> Zip </label>
                                                    <div class="controls">
                                                        <input  value="<?php echo $obj->SelectAllByVal("store","id",$_GET['edit'],"zip"); ?>" class="span6" type="number" name="zip" />
                                                    </div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label"> Country </label>
                                                    <div class="controls">
                                                        <select name="country" data-placeholder="Select Country" class="select-search" tabindex="2">
                                                            <option value=""></option> 
                                                            <?php 
															$cc=$obj->SelectAllByVal("store","id",$_GET['edit'],"country");
															$sqlcountry=$obj->SelectAll("country");
															if(!empty($sqlcountry))
															foreach($sqlcountry as $country):
															?>
                                                            <option  <?php if($cc==$country->id){ ?> selected <?php } ?> value="<?php echo $country->id; ?>"><?php echo $country->name; ?></option> 
                                                            <?php endforeach; ?>
                                                       </select>
                                                    </div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label"> Phone </label>
                                                    <div class="controls"><input  value="<?php echo $obj->SelectAllByVal("store","id",$_GET['edit'],"phone"); ?>" class="span4" type="number" name="phone" /></div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label"> Website </label>
                                                    <div class="controls"><input  value="<?php echo $obj->SelectAllByVal("store","id",$_GET['edit'],"website"); ?>" class="span12" type="text" name="website" /></div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label"> * Subdomain </label>
                                                    <div class="controls"><input  value="<?php echo $obj->SelectAllByVal("store","id",$_GET['edit'],"subdomain"); ?>" class="span12" type="text" name="subdomain" /></div>
                                                </div>

                                                
                                                
                                                
                                                
                                                <div class="control-group">
                                                    <label class="control-label">&nbsp;</label>
                                                    <div class="controls"><button type="submit" name="update" class="btn btn-success">
                                                    <i class="icon-plus-sign"></i> Update Store Detail </button></div>
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

                            <?php } ?>
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
