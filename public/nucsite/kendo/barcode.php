<?php 
include('class/auth.php');
if($input_status!=1)
{
	$obj->Error("Invalid Page Request.","index.php");
}
$table="barcode";
if(isset($_POST['create']))
{
	extract($_POST);
	if(!empty($code))
	{
		if($obj->insert($table,array("name_code"=>$code))==1)
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
                            <h5><i class="font-barcode"></i>  Barcode System </h5>
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

                            <!-- Content container -->
                            
                            <br><br>


                                <!-- Content Start from here customized -->
                                

                                <form class="form-horizontal" method="get" name="invoice" action="<?php echo $obj->filename(); ?>">
                                    <fieldset>
                                        <!-- General form elements -->
                                        <div class="row-fluid  span12 well">     
                                           <!-- Selects, dropdowns -->
                                            <div class="span6" style="padding:0px; margin:0px;">
                                                <div class="control-group">
                                                    <label class="span12"> * Place Name / Code :</label>
                                                   <input class="span12 k-textbox" type="text" name="code" />
                                                </div>
                                                
                                                <div class="control-group">
                                                    <button type="submit" name="create" class="k-button"><i class="icon-plus-sign"></i> Add Line Item </button>
                                                </div>
                                                
                                            </div>
                                            <!-- /selects, dropdowns -->



                                            <!-- Selects, dropdowns -->
                                            <div class="span6" style="padding:0px; margin:0px; float:right;">
                                                <?php
                                                if(isset($_GET['code']))
                                                {
                                                    for($i=1; $i<=10; $i++):
                                                ?>
                                                    <img src="class/barcode/test_1D.php?text=<?php echo $_GET['code']; ?>" alt="barcode" height="55" style="margin-right:50px; margin-bottom:20px;" />
                                                <?php 
                                                    endfor;
                                                }
                                                ?>
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
