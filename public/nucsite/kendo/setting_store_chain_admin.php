<?php
include('class/auth.php');
if ($input_status != 1) {
    $obj->Error("Invalid Page Request.", "index.php");
}
$table = "store_chain_admin";

if (isset($_GET['del'])) {
    if ($obj->delete($table, array("id" => $_GET['del'])) == 1) {
        $obj->Success("Store Successfully Deleted From Chain Admin List.", $obj->filename());
    } else {
        $obj->Error("Failed, Store Deletion Failed From Chain Admin List.", $obj->filename());
    }
}

if (isset($_POST['create'])) {
    extract($_POST);
    $a = 0;
    $b = 0;
    foreach ($_POST['store_id'] as $ff):
        $chkstore_chain = $obj->exists_multiple($table, array("sid" => $sid, "store_id" => $ff));
        if ($chkstore_chain != 0) {
            $b+=1;
        } else {
            if ($obj->insert($table, array("sid" => $sid, "store_id" => $ff, "date" => date('Y-m-d'), "status" => 1)) == 1) {
                $a+=1;
            } else {
                $a+=0;
            }
        }
    endforeach;
    if ($a != 0) {
        $obj->Success("Successfully Saved Store (" . $a . "), Exists Store (" . $b . ").", $obj->filename());
    } else {
        $obj->Error("Something is wrong, Try again.", $obj->filename());
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
                            <h5><i class="font-cogs"></i> Store Chain Admin Setting </h5>
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




                                <!-- Content Start from here customized -->


                                <form class="form-horizontal" method="post" name="invoice" action="">
                                    <fieldset>
                                        <!-- General form elements -->
                                        <div class="row-fluid" style="padding-top:0px; margin-top:0px;">     
                                            <div class="span6">

                                                <!-- Selects, dropdowns -->
                                                <div class="block well">
                                                    <div class="navbar"><div class="navbar-inner"><h5>Please Choose a Store Chain Admin</h5></div></div>

                                                    <div class="control-group">
                                                        <select name="sid" style="width: 220px;" tabindex="2">
                                                            <option value=""></option>
                                                            <?php
                                                            $sqlstore_chain_admin = $obj->SelectAll("shop_chain_admin");
                                                            if (!empty($sqlstore_chain_admin))
                                                                foreach ($sqlstore_chain_admin as $chain):
                                                                    ?> 
                                                                    <option value="<?php echo $chain->id; ?>"><?php echo $chain->name; ?></option> 
                                                                    <?php
                                                                endforeach;
                                                            ?>
                                                        </select>         
                                                    </div>

                                                    <div class="control-group">
                                                        <button type="submit" name="create" class="k-button"><i class="icon-check"></i> Save Changes </button>
                                                    </div>

                                                </div>
                                                <!-- /selects, dropdowns -->

                                            </div>


                                            <div class="span6">

                                                <!-- Selects, dropdowns -->
                                                <div class="block well">
                                                    <div class="navbar"><div class="navbar-inner"><h5>Please Choose Your Stores By Pressing Down (Ctrl)</h5></div></div>

                                                    <div class="control-group">
                                                        <select name="store_id[]"  multiple="multiple" class="multiple" title="Click to Select Stores">
                                                            <?php
                                                            $sqlstore_admin = $obj->SelectAll("shop_admin");
                                                            if (!empty($sqlstore_admin))
                                                                foreach ($sqlstore_admin as $admin):
                                                                    ?> 
                                                                    <option value="<?php echo $admin->store_id; ?>"><?php echo $admin->store_id; ?> - <?php echo $admin->name; ?></option> 
                                                                    <?php
                                                                endforeach;
                                                            ?>
                                                        </select>
                                                    </div>


                                                </div>
                                                <!-- /selects, dropdowns -->

                                            </div>























                                        </div>
                                        <!-- /general form elements -->     


                                        <div class="clearfix"></div>

                                        <!-- Default datatable -->

                                        <!-- /default datatable -->


                                    </fieldset>                     

                                </form>


                                <!-- Content End from here customized -->




                                <div class="separator-doubled"></div> 



                                <div class="row-fluid" style="margin-top:40px;">
                                    <div class="table-overflow">

                                        <?php
//print_r($array);
//echo count($array);
                                        ?>
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        <div id="grid" style="margin-left: 10px;margin-right: 10px;"></div>
                                    <script id="action_template" type="text/x-kendo-template">
                                         
                                        <a class="k-button k-button-icontext k-grid-delete" onclick="javascript:deleteClick(#=id#);" ><span class="k-icon k-delete"></span> Delete</a>
                                    </script>
                                    <script type="text/javascript">
                                        function deleteClick(id) {
                                            var c = confirm("Do you want to delete?");
                                            if (c === true) {
                                                $.ajax({
                                                    type: "POST",
                                                    dataType: "json",
                                                    url: "./controller/setting_store_chain_admin.php",
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
                                                        url: "./controller/setting_store_chain_admin.php",
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
                                                            shop_name: {type: "string"},
                                                            chain_admin_name: {type: "string"},
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
                                                    {field: "id", title: "#", width: "30px", filterable: false},
                                                    {field: "shop_name", title: "Store ID & Name  ", width: "100px", filterable: false},
                                                    {field: "chain_admin_name", title: "Store Chain Admin Name", width: "100px", filterable: false},
                                                    {
                                                        title: "Action", width: "40px",
                                                        template: kendo.template($("#action_template").html())
                                                    }
                                                ],
                                            });
                                        });

                                    </script>
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        <?php /*<table class="table table-striped" id="data-table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th> Store ID &amp; Name </th>
                                                    <th> Store Chain Admin Name </th>
                                                    <th width="60">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sql_store = $obj->SelectAll($table);
                                                $i = 1;
                                                foreach ($sql_store as $row):
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $i; ?></td>
                                                        <td> <?php echo $obj->SelectAllByVal("shop_admin", "store_id", $row->store_id, "name"); ?> </td>
                                                        <td><?php echo $obj->SelectAllByVal("shop_chain_admin", "id", $row->sid, "name"); ?> </td>
                                                        <td>
                                                            <a href="<?php echo $obj->filename(); ?>?del=<?php echo $row->id; ?>" class="hovertip" title="Delete" onclick="javascript:return confirm('Are you absolutely sure to delete This?')"><i class="icon-trash"></i></a>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    $i++;
                                                endforeach;
                                                ?>
                                            </tbody>
                                        </table>*/?>
                                    </div>
                                </div>


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
            
            <script>
                nucleus("select[name='sid']").kendoDropDownList({
                    optionLabel: " Please Select Store Chain Admin  "
                }).data("kendoDropDownList").select(0);
                
            </script>
            
            
            <?php //include('include/footer.php'); ?>
            <!-- Right sidebar -->
            <?php //include('include/sidebar_right.php');   ?>
            <!-- /right sidebar -->

        </div>
        <!-- /main wrapper -->

    </body>
</html>
