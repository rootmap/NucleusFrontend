<?php
include('class/auth.php');
if ($input_status == 3 || $input_status == 4) {
    $obj->Error("Invalid Page Request.", "index.php");
}
$table = "store";
if (isset($_GET['del'])) {
    $obj->deletesing("id", $_GET['del'], $table);
}

function user_type($st) {
    if ($st == 1) {
        return "Super Admin";
    } elseif ($st == 2) {
        return "Shop Admin";
    } elseif ($st == 3) {
        return "Cashier";
    } elseif ($st == 4) {
        return "Store Manager";
    } elseif ($st == 5) {
        return "Shop Chain Manager";
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
                            <h5><i class="icon-tasks"></i> Store List </h5>
                            <ul class="icons">
                                <li><a href="<?php echo $obj->filename(); ?>" class="hovertip" title="Reload"><i class="font-refresh"></i></a></li>
                            </ul>
                        </div><!-- /page header -->

                        <div class="body">

                            <!-- Middle navigation standard -->
                            <?php //include('include/quicklink.php');   ?>
                            <!-- /middle navigation standard -->
<!--                            <a href="store.php" class="btn btn-success"><i class="icon-plus-sign"></i> Add New Store User</a>
                            <a href="super_admin_list.php" class="btn btn-success"><i class="icon-tasks"></i> Super Admin</a>
                            <a href="shop_chain_admin_list.php" class="btn btn-success"><i class="icon-tasks"></i> Shop Chain Admin</a>
                            <a href="shop_admin_list.php" class="btn btn-success"><i class="icon-tasks"></i> Shop Admin</a>
                            <a href="store_manager_list.php" class="btn btn-success"><i class="icon-tasks"></i> Store Manager</a>
                            <a href="store_cashier_list.php" class="btn btn-success"><i class="icon-tasks"></i> Cashier</a>
                            <a href="store_request_list.php" class="btn btn-success"><i class="icon-warning-sign"></i> Store Request List</a>-->
                            <!-- Content container -->

                            <div class="container">
                                <!-- Content Start from here customized -->

                                <!-- General form elements -->    

                                <div class="table-overflow">
                                    <div class="k-toolbar k-grid-toolbar" style="margin-left: 10px;margin-right: 10px;">
                                        <a href="store.php" class="k-button"><i class="icon-plus-sign"></i> Add New Store User</a>
                                        <a href="super_admin_list.php" class="k-button"><i class="icon-tasks"></i> Super Admin</a>
                                        <a href="shop_chain_admin_list.php" class="k-button"><i class="icon-tasks"></i> Shop Chain Admin</a>
                                        <a href="shop_admin_list.php" class="k-button"><i class="icon-tasks"></i> Shop Admin</a>
                                        <a href="store_manager_list.php" class="k-button"><i class="icon-tasks"></i> Store Manager</a>
                                        <a href="store_cashier_list.php" class="k-button"><i class="icon-tasks"></i> Cashier</a>
                                        <a href="store_request_list.php" class="k-button"><i class="icon-warning-sign"></i> Store Request List</a>
                                    </div>

                                    <div id="grid" style="margin-left: 10px;margin-right: 10px;"></div>
                                    <script id="action_template" type="text/x-kendo-template">
                                        <a class="k-button k-button-icontext k-grid-delete" href="store_manager_list.php?edit=#=id#"><i class="icon-edit"></i> Edit</a> 
                                        <a class="k-button k-button-icontext k-grid-delete" onclick="javascript:deleteClick(#=id#);" ><span class="k-icon k-delete"></span> Delete</a>
                                    </script>
                                    <script type="text/javascript">
                                        function deleteClick(id) {
                                            var c = confirm("Do you want to delete?");
                                            if (c === true) {
                                                $.ajax({
                                                    type: "POST",
                                                    dataType: "json",
                                                    url: "./controller/store_manager_list.php",
                                                    data: {id: id},
                                                    success: function (result) {
                                                        $(".k-i-refresh").click();
                                                    }
                                                });
                                            }
                                        }

                                    </script>
                                    <script type="text/javascript">
                                        jQuery(document).ready(function () {
                                            var dataSource = new kendo.data.DataSource({
                                                transport: {
                                                    read: {
                                                        url: "./controller/store_manager_list.php",
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
                                                            store_id: {type: "number"},
                                                            name: {type: "string"},
                                                            username: {type: "string"},
                                                            email: {type: "string"},
                                                            phone: {type: "string"},
                                                            status: {type: "string"}
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
                                                    {field: "store_id", title: "Store - ID ", width: "60px"},
                                                    {field: "name", title: "Store Name", width: "100px"},
                                                    {field: "username", title: "Username", width: "80px"},
                                                    {field: "email", title: "Email", width: "140px"},
                                                    {field: "phone", title: "Phone", width: "70px"},
                                                    {field: "status", title: "User Type", width: "90px"},
                                                    {
                                                        title: "Action", width: "130px",
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
                                      <th> Store - ID </th>
                                      <th> Store Name </th>
                                      <th> Username </th>
                                      <th> Email </th>
                                      <th> Phone </th>

                                      <th> User Type </th>
                                      <th width="60">Action</th>
                                      </tr>
                                      </thead>
                                      <tbody>
                                      <?php
                                      $sql_store=$obj->SelectAll("store_manager");
                                      $i=1;
                                      foreach($sql_store as $row):
                                      ?>
                                      <tr>
                                      <td><?php echo $i; ?></td>
                                      <td> <?php echo $row->store_id; ?> </td>
                                      <td><?php echo $row->name; ?> </td>
                                      <td><?php echo $row->username; ?> </td>
                                      <td> <?php echo $row->email; ?> </td>
                                      <td> <?php echo $row->phone; ?> </td>

                                      <td> <?php echo user_type($row->status); ?> </td>
                                      <td>

                                      <a href="store.php?edit=<?php echo $row->id; ?>" class="hovertip" title="Delete" onclick="javascript:return confirm('Are you absolutely sure to Edit This Store Detail?')"><i class="icon-edit"></i></a>
                                      <a href="<?php echo $obj->filename(); ?>?del=<?php echo $row->id; ?>" class="hovertip" title="Delete" onclick="javascript:return confirm('Are you absolutely sure to delete This?')"><i class="icon-trash"></i></a>
                                      </td>
                                      </tr>
                                      <?php
                                      $i++;
                                      endforeach; ?>
                                      </tbody>
                                      </table> */ ?>
                                </div>



                                <!-- Default datatable -->

                                <!-- /default datatable -->

                                <!-- /content container -->
                            </div>
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
