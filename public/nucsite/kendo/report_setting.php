<?php
include('class/auth.php');
if ($input_status == 3 || $input_status == 4) {
    $obj->Error("Invalid Page Request.", "index.php");
}
$table="setting_report";

if (@$_GET['del']) {
    $obj->deletesing("id", $_GET['del'], $table);
}

if (isset($_POST['save'])) {
    extract($_POST);
    if (!empty($name)) {
        if ($obj->exists_multiple($table, array("store_id"=>$input_by)) == 0) {
            if ($obj->insert($table, array("store_id"=>$input_by, "name"=>$name, "phone"=>$phone, "email"=>$email, "address"=>$address, "fotter"=>$fotter, "signature"=>$signature, "date"=>date('Y-m-d'), "status"=>1)) == 1) {
                $obj->Success($name . " is Saved Successfully.", $obj->filename());
            }else {
                $obj->Error("Failed, Sql Error", $obj->filename());
            }
        }else {
            if ($obj->update($table, array("store_id"=>$input_by, "name"=>$name, "phone"=>$phone, "email"=>$email, "address"=>$address, "fotter"=>$fotter, "signature"=>$signature, "date"=>date('Y-m-d'), "status"=>1)) == 1) {
                $obj->Success($name . " is Saved Successfully.", $obj->filename());
            }else {
                $obj->Error("Failed, Sql Error", $obj->filename());
            }
        }
    }else {
        $obj->Error("Failed, Some field is Empty", $obj->filename());
    }
}
include('class/index.php');
$report=new index();
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
                            <h5><i class="font-cogs"></i>  Report View Setting </h5>
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


                                <form class="form-horizontal" method="post" enctype="multipart/form-data" name="invoice" action="">
                                    <fieldset>
                                        <!-- General form elements -->

                                        <div class="row-fluid  span6 well">
                                            <!-- Selects, dropdowns -->
<?php
$sqlreportquery=$report->FlyQuery("select store_id,`name`,phone,email,address,fotter,signature from setting_report WHERE store_id='" . $input_by . "' LIMIT 1");
?>
                                            <div class="control-group">
                                                <label class="span12"> Company Name * </label>
                                                <input class="span6 k-textbox" placeholder="Company Name : " type="text" name="name" value="<?php echo @$sqlreportquery[0]->name; ?>" />
                                            </div>
                                            <div class="control-group">
                                                <label class="span12"> Phone * </label>
                                                <input class="span6 k-textbox" placeholder="Phone Number : " type="text" name="phone" value="<?php echo @$sqlreportquery[0]->phone; ?>"  />
                                            </div>
                                            <div class="control-group">
                                                <label class="span12"> E - Mail * </label>
                                                <input class="span6 k-textbox" placeholder="Email Address : " type="text" name="email" value="<?php echo @$sqlreportquery[0]->email; ?>"  />
                                            </div>

                                            <div class="control-group">
                                                <label class="span12"> Address * </label>
                                                <input class="span6 k-textbox" placeholder="Company Address : " type="text" name="address" value="<?php echo @$sqlreportquery[0]->address; ?>"  />
                                            </div>

                                            <div class="control-group">
                                                <label class="span12"> Fotter Detail* </label>
                                                <textarea placeholder="Fotter Detail" class="span8 k-textbox" name="fotter"><?php echo @$sqlreportquery[0]->fotter; ?></textarea>
                                            </div>

                                            <div class="control-group">
                                                <label class="span12"> Signature Content* </label>
                                                <textarea placeholder="Signature Detail Content" class="span8 k-textbox" name="signature"><?php echo @$sqlreportquery[0]->signature; ?></textarea>
                                            </div>

                                            <div class="control-group">
                                                <button type="submit" name="save" class="k-button"><i class="icon-cog"></i> Save Changes </button>
                                            </div>
                                        </div>
                                        <!-- /selects, dropdowns -->


                                        <!-- /general form elements -->


                                        <div class="clearfix"></div>

                                        <!-- Default datatable -->

                                        <!-- /default datatable -->


                                    </fieldset>

                                </form>

                                <!-- /default datatable -->


                                <!-- Content End from here customized -->



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
