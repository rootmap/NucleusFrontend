<?php
include('class/auth.php');
if ($input_status == 3 || $input_status == 4) {
    $obj->Error("Invalid Page Request.", "index.php");
}
$table = "tax";
if (isset($_GET['del'])) {
    $obj->deletesing("id", $_GET['del'], $table);
}

function tax_status($status) {
    if ($status == 0) {
        return "Disable";
    } elseif ($status == 1) {
        return "Enable";
    } elseif ($status == 2) {
        return "Disable";
    } else {
        return "Disable";
    }
}

if (isset($_POST['save'])) {
    if ($obj->exists_multiple($table, array("uid" => $input_by, "store_id" => $input_by)) == 0) {

        if ($input_status == 1) {
            if ($obj->insert($table, array("tax" => $_POST['name'], "uid" => $input_by, "store_id" => $input_by, "status" => 1, "date" => date('Y-m-d'))) == 1) {
                $obj->Success("Tax Succesfully Saved", $obj->filename());
            } else {
                $obj->Error("Tax Saved Failed", $obj->filename());
            }
        } else {
            if ($obj->insert($table, array("tax" => $_POST['name'], "uid" => $input_by, "store_id" => $input_by, "status" => 1, "date" => date('Y-m-d'))) == 1) {
                $obj->Success("Tax Succesfully Saved", $obj->filename());
            } else {
                $obj->Error("Tax Saved Failed", $obj->filename());
            }
        }
    } else {
        $obj->Error("Tax Already Exists", $obj->filename());
    }
}

if (isset($_POST['tax_status'])) {
    if ($_POST['status'] != 0) {
        if ($input_status == 1) {
            $chk = $obj->exists_multiple("tax_status", array("store_id" => $input_by));
            if ($chk == 1) {
                if ($obj->update("tax_status", array("store_id" => $input_by, "status" => $_POST['status'])) == 1) {
                    $obj->Success("Tax Status Has Been Changed Successfully", $obj->filename());
                } else {
                    $obj->Error("Tax Status Not Changed", $obj->filename());
                }
            } else {
                if ($obj->insert("tax_status", array("store_id" => $input_by, "status" => $_POST['status'])) == 1) {
                    $obj->Success("Tax Status Has Been Changed Successfully", $obj->filename());
                } else {
                    $obj->Error("Tax Status Not Changed", $obj->filename());
                }
            }
        } else {
            $chk = $obj->exists_multiple("tax_status", array("store_id" => $input_by));
            if ($chk == 1) {
                if ($obj->update("tax_status", array("store_id" => $input_by, "status" => $_POST['status'])) == 1) {
                    $obj->Success("Tax Status Has Been Changed Successfully", $obj->filename());
                } else {
                    $obj->Error("Tax Status Not Changed", $obj->filename());
                }
            } else {
                if ($obj->insert("tax_status", array("store_id" => $input_by, "status" => $_POST['status'])) == 1) {
                    $obj->Success("Tax Status Has Been Changed Successfully", $obj->filename());
                } else {
                    $obj->Error("Tax Status Not Changed", $obj->filename());
                }
            }
        }
    } else {
        $obj->Error("Tax Status Not Changed", $obj->filename());
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
                            <h5><i class="font-cogs"></i>  Tax Setting </h5>
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



                                <!-- General form elements -->
                                <div class="row-fluid  span12 well">     
                                    <!-- Selects, dropdowns -->
                                    <div class="span6" style="padding:0px; margin:0px;">
                                        <form class="form-horizontal" method="post" name="invoice" action="">
                                            <h5 style="padding-left:10px;">Set Tax Rate</h5>
                                            <fieldset>
                                                <div class="control-group">
                                                    <label class="span12"> Tax Rate <input class="span3 k-textbox" style="width: 60px;" type="text" name="name" /> %</label>

                                                </div>
                                                <div class="control-group">
                                                    <button type="submit" name="save" class="k-button"><i class="icon-cog"></i> Save Tax </button>
                                                </div>
                                            </fieldset>                     

                                        </form>
                                        <div class="separator-doubled"></div>
                                        <br>
                                        <form class="form-horizontal" method="post" name="invoice" action="">
                                            <h5 style="padding-left:10px;">Set Tax Status | Status is <?php
                                                $st = $obj->SelectAllByVal("tax_status", "store_id", $input_by, "status");
                                                echo tax_status($st);
                                                ?> Now </h5>
                                            <fieldset>
                                                <div class="control-group">
                                                    <label class="span12"> Change Tax Status 
                                                        <select name="status" style="width: 150px;" tabindex="2">
                                                            <option value="0">Change Status</option>
                                                            <option value="1">Enable</option>
                                                            <option value="2">Disable</option>
                                                        </select>
                                                    </label>    
                                                </div>
                                                <div class="control-group">
                                                    <button type="submit" name="tax_status" class="k-button"><i class="icon-cog"></i> Change Tax Status </button>
                                                </div>
                                            </fieldset>                     

                                        </form>
                                    </div>
                                    <!-- /selects, dropdowns -->



                                    <!-- Selects, dropdowns -->
                                    <div class="span6" style="padding:0px; margin:0px; float:right;">


                                        <div class="table-overflow">

                                            <div id="grid" style="margin-left: 10px;margin-right: 10px;"></div>

                                            <script id="action_template" type="text/x-kendo-template">
                                                <a class="k-button k-button-icontext k-grid-delete" onclick="javascript:deleteClick(#=id #);" ><span class="k-icon k-delete"></span> Delete</a>
                                            </script>
                                            <script type="text/javascript">
                                                function deleteClick(id) {
                                                    var c = confirm("Do you want to delete?");
                                                    if (c === true) {
                                                        $.ajax({
                                                            type: "POST",
                                                            dataType: "json",
                                                            url: "./controller/tax.php",
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
                                                                url: "./controller/tax.php",
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
                                                                    tax_name: {type: "string"},
                                                                    status: {type: "string"},
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
                                                            {field: "id", title: "#", width: "60px", filterable: false},
                                                            {field: "tax_name", title: "Tax Name"},
                                                            {field: "status", title: "Status"},
                                                            {field: "date", title: "Date"},
                                                            {
                                                                title: "Action", width: "100px",
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
                                              <th> Tax Name </th>
                                              <th> Status </th>
                                              <th> Date </th>
                                              <th width="60">Action</th>
                                              </tr>
                                              </thead>
                                              <tbody>
                                              <?php
                                              if($input_status==1){
                                              $data=$obj->SelectAll($table);
                                              }
                                              elseif($input_status==5)
                                              {
                                              $sqlchain_store_ids=$obj->SelectAllByID("store_chain_admin",array("sid"=>$input_by));
                                              if(!empty($sqlchain_store_ids))
                                              {
                                              $array_ch = array();
                                              foreach($sqlchain_store_ids as $ch):
                                              array_push($array_ch,$ch->store_id);
                                              endforeach;
                                              include('class/report_chain_admin.php');
                                              $obj_report_chain = new chain_report();
                                              $data=$obj_report_chain->SelectAllByID_Multiple_Or($table,$array_ch,"store_id","1");
                                              }
                                              else
                                              {
                                              $data="";
                                              }
                                              }
                                              else
                                              {
                                              $data=$obj->SelectAllByID_Multiple($table,array("uid"=>$input_by,"store_id"=>$input_by));
                                              }
                                              $i=1;
                                              if(!empty($data))
                                              foreach($data as $row): ?>
                                              <tr>
                                              <td><?php echo $i; ?></td>
                                              <td><?php echo $row->tax; ?>%</td>
                                              <td><?php echo $row->status; ?></td>
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
            
            
            
            <script>
                nucleus("select[name='status']").kendoDropDownList({
                    optionLabel: " Please Select Status  "
                }).data("kendoDropDownList").select(0);
                
            </script>
            
            
            
            
            
            
            
            
            
            
            
            
            
            <?php //include('include/footer.php'); ?>
            <!-- Right sidebar -->
            <?php //include('include/sidebar_right.php');  ?>
            <!-- /right sidebar -->

        </div>
        <!-- /main wrapper -->

    </body>
</html>
