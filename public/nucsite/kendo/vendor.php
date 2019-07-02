<?php 
include('class/auth.php');
if($input_status==3 || $input_status==4)
{
	$obj->Error("Invalid Page Request.","index.php");
}
$table="vendor";
if(isset($_POST['create']))
{
    extract($_POST);
    if(!empty($name))
    {
        if($obj->insert("vendor",array("store_id"=>$input_by,"name"=>$name,"email"=>$email,"account_num"=>$account_num,"phone"=>$phone,"address"=>$address,"city"=>$city,"state_cun"=>$state_cun,"zip"=>$zip,"web"=>$web,"notes"=>$notes,"date"=>date('Y-m-d'),"status"=>1))==1)
        {
            $obj->Success("Vendor Successfully Added.",$obj->filename());
        }
        else 
        {
            $obj->Error("Failed, Vendor Addition Failed.",$obj->filename());
        }
    }
    else
    {
        $obj->Error("Failed, Name Should Not Be Empty.",$obj->filename());
    }
}

if(isset($_POST['update']))
{
    extract($_POST);
    if(!empty($name))
    {
        if($obj->update("vendor",array("id"=>$id,"store_id"=>$input_by,"name"=>$name,"email"=>$email,"account_num"=>$account_num,"phone"=>$phone,"address"=>$address,"city"=>$city,"state_cun"=>$state_cun,"zip"=>$zip,"web"=>$web,"notes"=>$notes,"date"=>date('Y-m-d'),"status"=>1))==1)
        {
            $obj->Success("Vendor Successfully Updated.",$obj->filename()."?edit".$id);
        }
        else 
        {
            $obj->Error("Failed, Vendor Update Failed.",$obj->filename()."?edit".$id);
        }
    }
    else
    {
        $obj->Error("Failed, Name Should Not Be Empty.",$obj->filename()."?edit".$id);
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
                            <?php if(isset($_GET['edit'])){ ?><h5><i class="icon-edit"></i> Edit Vendor </h5><?php }else{ ?><h5><i class="font-cogs"></i> Add New Vendor </h5><?php } ?>
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
                                
                               <?php if(isset($_GET['edit'])){ ?>
                                <form class="form-horizontal" method="post" name="invoice" action="">
                                    <fieldset>
                                        <!-- General form elements -->
                                        <div class="row-fluid  span12 well">     
                                           <!-- Selects, dropdowns -->
                                            <div class="span6" style="padding:0px; margin:0px;">
                                                <div class="control-group">
                                                    <label class="span12"> Name </label>
                                                    <input type="hidden" name="id" value="<?php echo $_GET['edit']; ?>" />
                                                    <input value="<?php echo $obj->SelectAllByVal("vendor","id",$_GET['edit'],"name"); ?>" class="span10 k-textbox" type="text" name="name" />
                                                </div>
                                                <div class="control-group">
                                                    <label class="span12"> Email </label>
                                                        <input value="<?php echo $obj->SelectAllByVal("vendor","id",$_GET['edit'],"email"); ?>" class="span10 k-textbox" type="text" name="email" />
                                                </div>
                                                
                                                <div class="control-group">
                                                    <label class="span12"> Account number </label>
                                                        <input value="<?php echo $obj->SelectAllByVal("vendor","id",$_GET['edit'],"account_num"); ?>" class="span10 k-textbox" type="text" name="account_num" />
                                                </div>
                                                
                                                <div class="control-group">
                                                    <label class="span12"> Phone </label>
                                                        <input value="<?php echo $obj->SelectAllByVal("vendor","id",$_GET['edit'],"phone"); ?>"  class=" k-textbox" type="text" name="phone" />
                                                </div>
                                                
                                                <div class="control-group">
                                                    <label class="span12"> Address </label>
                                                        <input  value="<?php echo $obj->SelectAllByVal("vendor","id",$_GET['edit'],"address"); ?>"  class="span10 k-textbox" type="text" name="address" />
                                                </div>
                                                <div class="control-group">
                                                    <label class="span12"> City </label>
                                                        <input value="<?php echo $obj->SelectAllByVal("vendor","id",$_GET['edit'],"city"); ?>" class="span10 k-textbox" type="text" name="city" />
                                                </div>
                                                
                                            </div>
                                            <!-- /selects, dropdowns -->



                                            <!-- Selects, dropdowns -->
                                            <div class="span6" style="padding:0px; margin:0px; float:right;">
                                                <div class="control-group">
                                                    <label class="span12"> State/County </label>
                                                        <input value="<?php echo $obj->SelectAllByVal("vendor","id",$_GET['edit'],"state_cun"); ?>"  class="span10 k-textbox" type="text" name="state_cun" />
                                                </div>
                                                
                                                <div class="control-group">
                                                    <label class="span12"> Zip/Postal Code </label>
                                                        <input value="<?php echo $obj->SelectAllByVal("vendor","id",$_GET['edit'],"zip"); ?>"  class="span10 k-textbox" type="text" name="zip" />
                                                </div>
                                                
                                                <div class="control-group">
                                                    <label class="span12"> Website </label>
                                                        <input value="<?php echo $obj->SelectAllByVal("vendor","id",$_GET['edit'],"web"); ?>"  class="span10 k-textbox" type="text" name="web" />
                                                </div>
                                                
                                                <div class="control-group">
                                                    <label class="span12"> Notes </label>
                                                        <textarea rows="5" cols="5" name="notes" class="span10 k-textbox"><?php echo $obj->SelectAllByVal("vendor","id",$_GET['edit'],"notes"); ?></textarea>
                                                </div>
                                                
                                                
                                                <div class="control-group">
                                                    <label class="control-label">&nbsp;</label>
                                                    <div class="controls"><button type="submit" name="update" class="k-button"><i class="icon-cog"></i> Update Changes </button></div>
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
                                <?php }else{ ?>
                                <form class="form-horizontal" method="post" name="invoice" action="">
                                    <fieldset>
                                        <!-- General form elements -->
                                        <div class="row-fluid  span12 well">     
                                           <!-- Selects, dropdowns -->
                                            <div class="span6" style="padding:0px; margin:0px;">
                                                <div class="control-group">
                                                    <label class="span12"> Name </label>
                                                        <input class="span10 k-textbox" type="text" name="name" />
                                                </div>
                                                <div class="control-group">
                                                    <label class="span12"> Email </label>
                                                        <input class="span10 k-textbox" type="text" name="email" />
                                                </div>
                                                
                                                <div class="control-group">
                                                    <label class="span12"> Account number </label>
                                                        <input class="span10 k-textbox" type="text" name="account_num" />
                                                </div>
                                                
                                                <div class="control-group">
                                                    <label class="span12"> Phone </label>
                                                        <input class="span10 k-textbox" type="text" name="phone" />
                                                </div>
                                                
                                                <div class="control-group">
                                                    <label class="span12"> Address </label>
                                                        <input class="span10 k-textbox" type="text" name="address" />
                                                </div>
                                                <div class="control-group">
                                                    <label class="span12"> City </label>
                                                        <input class="span10 k-textbox" type="text" name="city" />
                                                </div>
                                                
                                            </div>
                                            <!-- /selects, dropdowns -->



                                            <!-- Selects, dropdowns -->
                                            <div class="span6" style="padding:0px; margin:0px; float:right;">
                                                <div class="control-group">
                                                    <label class="span12"> State/County </label>
                                                        <input class="span10 k-textbox" type="text" name="state_cun" />
                                                </div>
                                                
                                                <div class="control-group">
                                                    <label class="span12"> Zip/Postal Code </label>
                                                        <input class="span10 k-textbox" type="text" name="zip" />
                                                </div>
                                                
                                                <div class="control-group">
                                                    <label class="span12"> Website </label>
                                                        <input class="span10 k-textbox" type="text" name="web" />
                                                </div>
                                                
                                                <div class="control-group">
                                                    <label class="span12"> Notes </label>
                                                        <textarea rows="5" cols="5" name="notes" class="span10 k-textbox"></textarea>
                                                </div>
                                                
                                                
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
