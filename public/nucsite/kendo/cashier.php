<?php
include('class/auth.php');
if ($input_status == 3 || $input_status == 4) {
    $obj->Error("Invalid Page Request.", "index.php");
}
$table = "cashier_list";
$table2 = "store";
if (isset($_POST['create'])) {
    extract($_POST);
    if (!empty($name) && !empty($email) && !empty($username) && !empty($password)) {
        $chk = $obj->exists_multiple($table2, array("store_id" => $input_by, "username" => $username));
        if ($chk == 0) {
            $chks = $obj->exists_multiple($table2, array("store_id" => $input_by, "email" => $email));
            if ($chks == 0) {

                if ($input_status == 1) {
                    $store_id = time();
                } elseif ($input_status == 2) {
                    $store_id = $input_by;
                } elseif ($input_status == 3) {
                    $store_id = 0;
                }

                if ($store_id != 0) {

                    if ($obj->insert($table2, array("name" => $name, "store_id" => $store_id, "email" => $email, "phone" => $phone, "username" => $username, "password" => $obj->password($password), "date" => date('Y-m-d'), "status" => 3)) == 1) {
                        $obj->Success("Successfully Saved Cashier { " . $name . " }", $obj->filename());
                    } else {
                        $obj->Error("Something is wrong, Try again.", $obj->filename());
                    }
                } else {
                    $obj->Error("You Are Not Authorized.", $obj->filename());
                }
            } else {
                $obj->Error("Failed, Email Already Exists", $obj->filename());
            }
        } else {
            $obj->Error("Failed, Username Already Exists", $obj->filename());
        }
    } else {
        $obj->Error("Failed, Fill up required field", $obj->filename());
    }
}

if (isset($_POST['update'])) {
    extract($_POST);
    if (!empty($name) && !empty($email) && !empty($password)) {
        if ($expass == $password) {
            $pass = $expass;
        } else {
            $pass = $obj->password($password);
        }

        if ($exemail == $email) {
            $em = $exemail;
        } else {
            $em = $email;
        }

        if ($obj->update($table2, array("id" => $edit, "name" => $name, "phone" => $phone, "email" => $email, "password" => $pass, "date" => date('Y-m-d'), "status" => 3)) == 1) {
            $obj->Success("Successfully Updated Cashier Detail", $obj->filename() . "?edit=" . $edit);
        } else {
            $obj->Error("Something is wrong, Try again.", $obj->filename() . "?edit=" . $edit);
        }
    } else {
        $obj->Error("Failed, Fill up required field", $obj->filename() . "?edit=" . $edit);
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
                            <?php if (isset($_GET['edit'])) { ?>
                                <h5><i class="icon-edit"></i> Edit Cashier Detail </h5>
                            <?php } else { ?>
                                <h5><i class="font-plus-sign"></i> Add New Cashier </h5>
                            <?php } ?>
                            <ul class="icons">
                                <li><a href="<?php echo $obj->filename(); ?>" class="hovertip" title="Reload"><i class="font-refresh"></i></a></li>
                            </ul>
                        </div><!-- /page header -->

                        <div class="body">

                            <!-- Middle navigation standard -->
                            <?php //include('include/quicklink.php');   ?>
                            <!-- /middle navigation standard -->

                            <!-- Content container -->
                            <div class="container">
                                <?php if (isset($_GET['edit'])) { ?>
                                    <form class="form-horizontal" method="post" enctype="multipart/form-data" name="invoice" action="">
                                        <fieldset>
                                            <input type="hidden" name="edit" value="<?php echo $_GET['edit']; ?>">

                                            <input type="hidden" name="expass" value="<?php echo $obj->SelectAllByVal($table, "id", $_GET['edit'], "password"); ?>">
                                            <input type="hidden" name="exemail" value="<?php echo $obj->SelectAllByVal($table, "id", $_GET['edit'], "email"); ?>">
                                            <!-- General form elements -->
                                            <div class="row-fluid  span12 well">     
                                                <!-- Selects, dropdowns -->
                                                <div class="span12" style="padding:0px; margin:0px;">
                                                    <div class="control-group">
                                                        <label class="control-label"> * Name :</label>
                                                        <div class="controls"><input value="<?php echo $obj->SelectAllByVal($table, "id", $_GET['edit'], "name"); ?>" class="span12 k-textbox" type="text" name="name" /></div>
                                                    </div>

                                                    <div class="control-group">
                                                        <label class="control-label"> * Email </label>
                                                        <div class="controls"><input value="<?php echo $obj->SelectAllByVal($table, "id", $_GET['edit'], "email"); ?>" class="span12 k-textbox" type="text" name="email" /></div>
                                                    </div>

                                                    <div class="control-group">
                                                        <label class="control-label"> * Username </label>
                                                        <div class="controls"><input value="<?php echo $obj->SelectAllByVal($table, "id", $_GET['edit'], "username"); ?>" class="span12 k-textbox" readonly type="text" name="username" /></div>
                                                    </div>

                                                    <div class="control-group">
                                                        <label class="control-label"> * Password </label>
                                                        <div class="controls"><input value="<?php echo $obj->SelectAllByVal($table, "id", $_GET['edit'], "password"); ?>" class="span12 k-textbox" type="password" name="password" /></div>
                                                    </div>

                                                    <div class="control-group">
                                                        <label class="control-label"> Phone </label>
                                                        <div class="controls">
                                                            <input value="<?php echo $obj->SelectAllByVal($table, "id", $_GET['edit'], "phone"); ?>" class="span12 k-textbox" type="text" name="phone" />
                                                        </div>
                                                    </div>

                                                    <div class="control-group">
                                                        <label class="control-label">&nbsp;</label>
                                                        <div class="controls"><button type="submit" name="update" class="k-button">
                                                                <i class="icon-plus-sign"></i> Update Cashier Detail </button></div>
                                                    </div>

                                                </div>
                                                <!-- /selects, dropdowns -->




                                                <!-- /selects, dropdowns -->



                                            </div>
                                            <!-- /general form elements -->     


                                            <div class="clearfix"></div>

                                            <!-- Default datatable -->

                                            <!-- /default datatable -->


                                        </fieldset>                     

                                    </form>

                                <?php } else { ?>


                                    <!-- /middle navigation standard -->
                                    <!--                                    -->

                                    <!-- Content container -->




                                    <!-- Content Start from here customized -->


                                    <form class="form-horizontal" enctype="multipart/form-data" method="post" name="invoice" action="">
                                        <fieldset>
                                            <!-- General form elements -->
                                            <div class="row-fluid  span12 well">
                                                <div class="k-toolbar k-grid-toolbar">
                                                    <a href="cashier.php" class="k-button"><i class="icon-plus-sign"></i> New Cashier Info</a>
                                                    <a href="cashier_list.php" class="k-button"><i class="icon-tasks"></i> Cashier List</a>
                                                </div>
                                                <!-- Selects, dropdowns -->
                                                <div class="span12" style="padding:0px; margin:0px;">
                                                    <div class="span6">
                                                        <div class="control-group">
                                                            <label class="control-label"> * Name :</label>
                                                            <div class="controls"><input class="span12 k-textbox" type="text" name="name" /></div>
                                                        </div>
                                                        <div class="control-group">
                                                            <label class="control-label"> * Username </label>
                                                            <div class="controls"><input class="span12 k-textbox" type="text" name="username" /></div>
                                                        </div>
                                                        <div class="control-group">
                                                            <label class="control-label"> Phone </label>
                                                            <div class="controls">
                                                                <input class="span12 k-textbox" type="text" name="phone" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="span6">
                                                        <div class="control-group">
                                                            <label class="control-label"> * Email </label>
                                                            <div class="controls"><input class="span12 k-textbox" type="text" name="email" /></div>
                                                        </div>
                                                        <div class="control-group">
                                                            <label class="control-label"> * Password </label>
                                                            <div class="controls"><input class="span12 k-textbox" type="password" name="password" /></div>
                                                        </div>
                                                        <div class="control-group">
                                                            <label class="control-label">&nbsp;</label>
                                                            <div class="controls">
                                                                <button type="submit" name="create" class="k-button">
                                                                    <i class="icon-plus-sign"></i> Save Cashier Detail 
                                                                </button>
                                                            </div>
                                                        </div>
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
            <!-- Right sidebar -->
            <?php //include('include/sidebar_right.php');   ?>
            <!-- /right sidebar -->

        </div>
        <!-- /main wrapper -->

    </body>
</html>
