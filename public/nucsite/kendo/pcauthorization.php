<?php
include('class/auth.php');
if ($input_status != 1) {
    $obj->Error("Invalid Page Request.", "index.php");
}
include('class/login.php');
$log = new login();
$table = "setting_user_pc";
$table2 = "autorized_pc";
if (isset($_GET['del'])) {
    $obj->deletesing("id", $_GET['del'], $table);
}

if (isset($_POST['save'])) {
    extract($_POST);
    $pc_address = $log->GetPcAddress(1);
    $pc_name = $log->GetPcAddress(2);
    if ($obj->exists_multiple($table, array("pc_address" => $pc_address)) == 0) {

        if ($obj->insert($table, array("store_id" => $input_by, "pc_name" => $name2, "pc_address" => $pc_address, "status" => 1, "date" => date('Y-m-d'))) == 1) {
            $obj->Success("This PC Succesfully Authorized", $obj->filename());
        } else {
            $obj->Error("This PC Authorized Failed", $obj->filename());
        }
    } else {
        $obj->Error("This PC Authorized Already Exists", $obj->filename());
    }
}

if (isset($_POST['deletemac'])) {
    $pc_address = $log->GetPcAddress(1);
    $pc_name = $log->GetPcAddress(2);
    if ($obj->delete($table, array("pc_address" => $pc_address)) == 1) {
        $obj->Success("This PC Authorization Successfully Deleted.", $obj->filename());
    } else {
        $obj->Error("This PC Authorization Delete Failed.", $obj->filename());
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
        <?php //echo $obj->bodyhead();  ?>

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
                            <h5><i class="font-cogs"></i> PC Authorization </h5>
                            <ul class="icons">
                                <li>
                                    <a href="<?php echo $obj->filename(); ?>" class="hovertip" title="Reload">
                                        <i class="font-refresh"></i>
                                    </a>
                                </li>
                            </ul>
                        </div><!-- /page header -->

                        <div class="body">

                            <!-- Middle navigation standard -->
                            <?php //include('include/quicklink.php');   ?>
                            <!-- /middle navigation standard -->

                            <!-- Content container -->
                            <div class="container">
                                <!-- Content Start from here customized -->



                                <!-- General form elements -->
                                <div class="row-fluid  span12 well">     
                                    <!-- Selects, dropdowns -->
                                    <div class="span4" style="padding:0px; margin:0px;">
                                        <?php $pc_addresss = $log->GetPcAddress(1); ?>
                                        <form class="form-horizontal" method="post" name="invoice" action="">
                                            <fieldset>
                                                <div class="control-group">
                                                    <label class="span12"> This PC Name <input style="margin-left:10px;" disabled class="span5 k-textbox" value="<?php echo $log->GetPcAddress(2); ?>"  type="text" name="name" /> </label>

                                                </div>

                                                <div class="control-group">
                                                    <label class="span12"> Give A Name <input style="margin-left:10px;" class="span5 k-textbox" value="<?php echo $obj->SelectAllByVal($table, "pc_address", $pc_addresss, "pc_name"); ?>" placeholder="Provide a name for identify" type="text" name="name2" /> </label>

                                                </div>

                                                <div class="control-group">
                                                    <?php
                                                    if ($obj->exists_multiple($table, array("pc_address" => $pc_addresss)) == 0) {
                                                        ?>
                                                        <button type="submit" name="save" class="k-button"><i class="icon-cog"></i> Authorized This PC </button>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <button type="submit" name="deletemac" class="k-button"><i class="icon-cog"></i> Delete This Authorized PC  </button>
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                            </fieldset>                     

                                        </form>
                                    </div>
                                    <!-- /selects, dropdowns -->



                                    <!-- Selects, dropdowns -->
                                    <div class="span8" style="padding:0px; margin:0px; float:right;">


                                        <div class="table-overflow">




                                            <div id="grid" style="margin-left: 10px;margin-right: 10px;"></div>
                                            <script id="action_template" type="text/x-kendo-template">
                                                <a class="k-button k-button-icontext k-grid-delete" onclick="javascript:deleteClick(#=id#);" ><span class="k-icon k-delete"></span> Delete</a>
                                            </script>
                                            <script type="text/javascript">
                                                jQuery(document).ready(function () {
                                                    var dataSource = new kendo.data.DataSource({
                                                        transport: {
                                                            read: {
                                                                url: "./controller/pcauthorization.php",
                                                                type: "GET",
                                                                datatype: "json"

                                                            }
                                                        },
                                                        autoSync: false,
                                                        schema: {
                                                            data: "data",
                                                            total: "total",
                                                            model: {
                                                                id: "id",
                                                                fields: {
                                                                    id: {type: "number"},
                                                                    pc_name: {type: "string"},
                                                                    pc_address: {type: "string"},
                                                                    date: {type: "string"}
                                                                }
                                                            }
                                                        },
                                                        pageSize: 10,
                                                        serverPaging: true,
                                                        serverFiltering: true,
                                                        serverSorting: true
                                                    });
                                                    jQuery("#grid").kendoGrid({
                                                        dataSource: dataSource,
                                                        filterable: true,
                                                        pageable: {
                                                            refresh: true,
                                                            input: true,
                                                            numeric: false,
                                                            pageSizes: true,
                                                            pageSizes:[10, 20, 50, 100, 200, 400]
                                                        },
                                                        sortable: true,
                                                        groupable: true,
                                                        columns: [
                                                            {field: "id", title: "#", width: "40px", filterable: false},
                                                            {field: "pc_name", title: "PC Name ", width: "100px"},
                                                            {field: "pc_address", title: "Mac/Address ", width: "70px", filterable: false},
                                                            {field: "date", title: "Created ", width: "70px", filterable: false},
                                                            {
                                                                title: "Action", width: "70px",
                                                                template: kendo.template($("#action_template").html())
                                                            }
                                                        ],
                                                    });
                                                });

                                            </script>









                                            <?php /* <table class="table table-striped" id="data-table">
                                              <thead>
                                              <tr>
                                              <th>#</th>

                                              <th> PC Name </th>
                                              <th> Mac/Address </th>
                                              <th> Date </th>
                                              <th width="60">Action</th>
                                              </tr>
                                              </thead>
                                              <tbody>
                                              <?php
                                              $data=$obj->SelectAll($table2);
                                              $i=1;
                                              if(!empty($data))
                                              foreach($data as $row): ?>
                                              <tr>
                                              <td><?php echo $i; ?></td>
                                              <td><?php echo $row->pc_name; ?></td>
                                              <td><?php echo $row->pc_address; ?></td>
                                              <td><?php echo $row->date; ?></td>
                                              <td>
                                              <a href="<?php echo $obj->filename(); ?>?del=<?php echo $row->id; ?>" class="btn btn-danger hovertip" title="Delete"><i class="icon-remove"></i></a>
                                              </td>
                                              </tr>
                                              <?php $i++; endforeach; ?>
                                              </tbody>
                                              </table> */ ?>
                                        </div>



                                    </div>
                                    <!-- /selects, dropdowns -->



                                </div>
                                <!-- /general form elements -->     


                                <div class="clearfix"></div>

                                <!-- Default datatable -->

                                <!-- /default datatable -->





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
            <?php //include('include/footer.php');  ?>
            <!-- Right sidebar -->
            <?php //include('include/sidebar_right.php');   ?>
            <!-- /right sidebar -->

        </div>
        <!-- /main wrapper -->

    </body>
</html>
