<?php
include('class/auth.php');
//if($input_status!=1)
//{
//	$obj->Error("Invalid Page Request.","index.php");
//}
$table = "pos_print_setting";
if (isset($_POST['create'])) {
    extract($_POST);
    $chk = $obj->exists_multiple($table, array("store_id" => $input_by));
    if ($chk == 0) {
        if ($obj->insert($table, array("store_id" => $input_by,"width"=>$width,"height"=>$height,"date" => date('Y-m-d'), "status" => 1)) == 1) {
            $obj->Success("Successfully Set.", $obj->filename());
        } else {
            $obj->Error("Something is wrong, Try again.", $obj->filename());
        }
    } else {
        if ($obj->update($table, array("store_id" => $input_by,"width"=>$width,"height"=>$height,"date" => date('Y-m-d'), "status" => 1)) == 1) {
            $obj->Success("Successfully Updated.", $obj->filename());
        } else {
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
                            <h5><i class="font-cogs"></i> Pos Paper Print Setting </h5>
                            <ul class="icons">
                                <li><a href="<?php echo $obj->filename(); ?>" class="hovertip" title="Reload"><i class="font-refresh"></i></a></li>
                            </ul>
                        </div><!-- /page header -->

                        <div class="body">
                            <!--Middle navigation standard-->

                            <!--Middle navigation standard-->
                            <!--Content container-->
                            <div class="container">
                                <?php 
                                $possetting=$obj->FlyQuery("SELECT * FROM `".$table."` WHERE store_id='".$input_by."'");
                                ?>
                                <!-- Content Start from here customized -->
                                <form class="form-horizontal" method="post" name="invoice" action="">
                                    <fieldset>
                                        <!-- General form elements -->    
                                        <!-- Selects, dropdowns -->
                                        <div class="control-group">
                                            <label class="control-label" style="width: 175px;">* Set Printer Page Width </label>
                                            <div class="controls">
                                                <input type="text" name="width" id="width" value="<?php echo @$possetting[0]->width; ?>" class="span8 k-textbox" placeholder="Set Printer Page Width" />
                                            </div>
                                        </div>
                                        
                                        <div class="control-group">
                                            <label class="control-label" style="width: 175px;">* Set Printer Page Height </label>
                                            <div class="controls">
                                                <input type="text" name="height" id="height" value="<?php echo @$possetting[0]->height; ?>"  class="span8 k-textbox" placeholder="Set Printer Page Height" />
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label">&nbsp;</label>
                                            <div class="controls"><button type="submit" name="create" class="k-button"><i class="icon-cog"></i> Set Printer Setting </button></div>
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
<?php //include('include/sidebar_right.php');   ?>
            <!-- /right sidebar -->

        </div>
        <!-- /main wrapper -->

    </body>
</html>
