<?php
include('class/auth.php');
if ($input_status != 1) {
    $obj->Error("Invalid Page Request.", "index.php");
}
$table = "buyback_estimate_price";
if (@$_GET['del']) {
    $obj->deletesing("id", $_GET['del'], $table);
}

if (isset($_POST['save'])) {
    extract($_POST);
    if (!empty($amounts)) {
        if ($obj->exists_multiple($table, array("nid" => $nid, "dtid" => $dtid, "cid" => $cid, "dtoid" => $dtoid, "wdid" => $wdid, "msid" => $msid, "model" => $model)) == 0) {
            if ($obj->insert($table, array("nid" => $nid, "dtid" => $dtid, "cid" => $cid, "dtoid" => $dtoid, "wdid" => $wdid, "msid" => $msid, "amount" => $amounts, "model" => $model, "date" => date('Y-m-d'), "status" => 1)) == 1) {
                $obj->Success("Saved Successfully.", $obj->filename());
            } else {
                $obj->Error("Failed, Sql Error", $obj->filename());
            }
        } else {
            $obj->Error("Failed, Already Exists", $obj->filename());
        }
    } else {
        $obj->Error("Failed, Some field is Empty", $obj->filename());
    }
}

if (isset($_POST['edit'])) {
    extract($_POST);
    if (!empty($amounts)) {

        if ($obj->update($table, array("id" => $id, "nid" => $nid, "dtid" => $dtid, "cid" => $cid, "dtoid" => $dtoid, "wdid" => $wdid, "msid" => $msid, "amount" => $amounts, "model" => $model, "date" => date('Y-m-d'), "status" => 1)) == 1) {
            $obj->Success("Updated Successfully.", $obj->filename());
        } else {
            $obj->Error("Failed, Sql Error", $obj->filename());
        }
    } else {
        $obj->Error("Failed, Some field is Empty", $obj->filename());
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
                            <h5><i class="font-cogs"></i> BuyBack Device Estimated Price Setting </h5>
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

                                <?php if (@$_GET['edit']) { ?>
                                    <h3 class="subtitle"> Estimated Price Edit Detail</h3>
                                    <form class="form-horizontal" method="post" enctype="multipart/form-data" name="invoice" action="">
                                        <fieldset>
                                            <input type="hidden" name="id" value="<?php echo $_GET['edit']; ?>">
                                            <!-- General form elements -->
                                            <div class="row-fluid  span6 well">     
                                                <!-- Selects, dropdowns -->
                                                <?php
                                                $nid = $obj->SelectAllByVal($table, "id", $_GET['edit'], "nid");
                                                $dtid = $obj->SelectAllByVal($table, "id", $_GET['edit'], "dtid");
                                                $cid = $obj->SelectAllByVal($table, "id", $_GET['edit'], "cid");
                                                $dtoid = $obj->SelectAllByVal($table, "id", $_GET['edit'], "dtoid");
                                                $wdid = $obj->SelectAllByVal($table, "id", $_GET['edit'], "wdid");
                                                $msid = $obj->SelectAllByVal($table, "id", $_GET['edit'], "msid");
                                                $model = $obj->SelectAllByVal($table, "id", $_GET['edit'], "model");
                                                $amount = $obj->SelectAllByVal($table, "id", $_GET['edit'], "amount");
                                                ?>
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th align="left" colspan="4"><strong>Device Information</strong></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td align="left">Carrier </td>
                                                            <td>
                                                                <select name="nid" style="width:200px;">
                                                                    <?php
                                                                    $sqlcarrier = $obj->SelectAll("buyback_network");
                                                                    if (!empty($sqlcarrier))
                                                                        foreach ($sqlcarrier as $carrier):
                                                                            ?>
                                                                            <option <?php if ($nid == $carrier->id) { ?> selected <?php } ?> value="<?php echo $carrier->id; ?>"><?php echo $carrier->name; ?></option>
                                                                        <?php endforeach; ?>
                                                                </select>
                                                            </td>
                                                            <td align="left">Device Type</td>
                                                            <td>
                                                                <select name="dtid" style="width:200px;">
                                                                    <?php
                                                                    $sqlcarrier = $obj->SelectAll("buyback_device_type");
                                                                    if (!empty($sqlcarrier))
                                                                        foreach ($sqlcarrier as $carrier):
                                                                            ?>
                                                                            <option <?php if ($dtid == $carrier->id) { ?> selected <?php } ?> value="<?php echo $carrier->id; ?>"><?php echo $carrier->name; ?></option>
                                                                        <?php endforeach; ?>
                                                                </select>
                                                            </td>
                                                            
                                                        </tr>
                                                        <td align="left">Device Model</td>
                                                            <td>
                                                                <select name="model" style="width:200px;">
                                                                    <?php
                                                                    $sqlcarrier = $obj->SelectAll("buyback_model");
                                                                    if (!empty($sqlcarrier))
                                                                        foreach ($sqlcarrier as $carrier):
                                                                            ?>
                                                                            <option <?php if ($model == $carrier->id) { ?> selected <?php } ?> value="<?php echo $carrier->id; ?>"><?php echo $carrier->name; ?></option>
                                                                        <?php endforeach; ?>
                                                                </select>
                                                            </td>
                                                            
                                                            <td align="left">Condition   </td>
                                                            <td>
                                                                <select name="cid" style="width:200px;" >
                                                                    <?php
                                                                    $sqlcarrier = $obj->SelectAll("buyback_device_condition");
                                                                    if (!empty($sqlcarrier))
                                                                        foreach ($sqlcarrier as $carrier):
                                                                            ?>
                                                                            <option <?php if ($cid == $carrier->id) { ?> selected <?php } ?> value="<?php echo $carrier->id; ?>"><?php echo $carrier->name; ?></option>
                                                                        <?php endforeach; ?>
                                                                </select>
                                                            </td>
                                                        <tr>
                                                            
                                                        </tr>
                                                        
                                                        <tr>
                                                            

                                                            <td align="left">Device Turn On </td>
                                                            <td>
                                                                <select name="dtoid" style="width:200px;" >
                                                                    <?php
                                                                    $sqlcarrier = $obj->SelectAll("buyback_device_turn_on");
                                                                    if (!empty($sqlcarrier))
                                                                        foreach ($sqlcarrier as $carrier):
                                                                            ?>
                                                                            <option <?php if ($dtoid == $carrier->id) { ?> selected <?php } ?> value="<?php echo $carrier->id; ?>"><?php echo $carrier->name; ?></option>
                                                                        <?php endforeach; ?>
                                                                </select>
                                                            </td>
                                                            <td align="left">Any Water Damage   </td>
                                                            <td>
                                                                <select name="wdid" style="width:200px;" >
                                                                    <?php
                                                                    $sqlcarrier = $obj->SelectAll("buyback_water_damage");
                                                                    if (!empty($sqlcarrier))
                                                                        foreach ($sqlcarrier as $carrier):
                                                                            ?>
                                                                            <option <?php if ($wdid == $carrier->id) { ?> selected <?php } ?> value="<?php echo $carrier->id; ?>"><?php echo $carrier->name; ?></option>
                                                                        <?php endforeach; ?>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td align="left">Memory Size </td>
                                                            <td>
                                                                <select name="msid" style="width:200px;" >
                                                                    <?php
                                                                    $sqlcarrier = $obj->SelectAll("buyback_memory_size");
                                                                    if (!empty($sqlcarrier))
                                                                        foreach ($sqlcarrier as $carrier):
                                                                            ?>
                                                                            <option <?php if ($msid == $carrier->id) { ?> selected <?php } ?> value="<?php echo $carrier->id; ?>"><?php echo $carrier->name; ?></option>
                                                                        <?php endforeach; ?>
                                                                </select>
                                                            </td>

                                                            <td align="left">Set Price</td>
                                                            <td align="left" style="width:200px;">
                                                                <input type="text" class="span12" value="<?php echo $amount; ?>" type="text" id="amounts" name="amounts" placeholder="Set Price">
                                                            </td>
                                                            <td align="left"></td>
                                                            <td align="left" colspan="2"></td>
                                                        </tr>                      
                                                    </tbody>
                                                </table>
                                                <div class="control-group">
                                                    <button type="submit" name="edit" class="btn btn-success"><i class="icon-cog"></i> Save Changes </button>
                                                </div>
                                            </div>
                                            <!-- /selects, dropdowns -->


                                            <!-- /general form elements -->     


                                            <div class="clearfix"></div>

                                            <!-- Default datatable -->

                                            <!-- /default datatable -->


                                        </fieldset>                     

                                    </form>
                                    <?php
                                } else {
                                    ?>
                                    <form class="form-horizontal" method="post" enctype="multipart/form-data" name="invoice" action="">
                                        <fieldset>
                                            <!-- General form elements -->
                                            <div class="row-fluid  span6 well">     
                                                <!-- Selects, dropdowns -->
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th align="left" colspan="4"><strong>Device Information</strong></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td align="left">Carrier </td>
                                                            <td>
                                                                <select name="nid" style="width:200px;">
                                                                    <?php
                                                                    $sqlcarrier = $obj->SelectAll("buyback_network");
                                                                    if (!empty($sqlcarrier))
                                                                        foreach ($sqlcarrier as $carrier):
                                                                            ?>
                                                                            <option value="<?php echo $carrier->id; ?>"><?php echo $carrier->name; ?></option>
                                                                        <?php endforeach; ?>
                                                                </select>
                                                            </td>
                                                            <td align="left">Device Type</td>
                                                            <td>
                                                                <select name="dtid" style="width:200px;">
                                                                    <?php
                                                                    $sqlcarrier = $obj->SelectAll("buyback_device_type");
                                                                    if (!empty($sqlcarrier))
                                                                        foreach ($sqlcarrier as $carrier):
                                                                            ?>
                                                                            <option value="<?php echo $carrier->id; ?>"><?php echo $carrier->name; ?></option>
                                                                        <?php endforeach; ?>
                                                                </select>
                                                            </td>
                                                            
                                                        </tr>
                                                        
                                                        
                                                        <tr>
                                                           <td align="left">Device Model</td>
                                                            <td>
                                                                <select name="model" style="width:200px;">
                                                                    <?php
                                                                    $sqlcarrier = $obj->SelectAll("buyback_model");
                                                                    if (!empty($sqlcarrier))
                                                                        foreach ($sqlcarrier as $carrier):
                                                                            ?>
                                                                            <option value="<?php echo $carrier->id; ?>"><?php echo $carrier->name; ?></option>
                                                                        <?php endforeach; ?>
                                                                </select>
                                                            </td> 
                                                            
                                                            <td align="left">Condition   </td>
                                                            <td>
                                                                <select name="cid" style="width:200px;">
                                                                    <?php
                                                                    $sqlcarrier = $obj->SelectAll("buyback_device_condition");
                                                                    if (!empty($sqlcarrier))
                                                                        foreach ($sqlcarrier as $carrier):
                                                                            ?>
                                                                            <option value="<?php echo $carrier->id; ?>"><?php echo $carrier->name; ?></option>
                                                                        <?php endforeach; ?>
                                                                </select>
                                                            </td>
                                                            
                                                        </tr>
                                                        
                                                        
                                                        <tr>
                                                            

                                                            <td align="left">Device Turn On </td>
                                                            <td>
                                                                <select name="dtoid" style="width:200px;">
                                                                    <?php
                                                                    $sqlcarrier = $obj->SelectAll("buyback_device_turn_on");
                                                                    if (!empty($sqlcarrier))
                                                                        foreach ($sqlcarrier as $carrier):
                                                                            ?>
                                                                            <option value="<?php echo $carrier->id; ?>"><?php echo $carrier->name; ?></option>
                                                                        <?php endforeach; ?>
                                                                </select>
                                                            </td>
                                                            <td align="left">Any Water Damage   </td>
                                                            <td>
                                                                <select name="wdid" style="width:200px;">
                                                                    <?php
                                                                    $sqlcarrier = $obj->SelectAll("buyback_water_damage");
                                                                    if (!empty($sqlcarrier))
                                                                        foreach ($sqlcarrier as $carrier):
                                                                            ?>
                                                                            <option value="<?php echo $carrier->id; ?>"><?php echo $carrier->name; ?></option>
                                                                        <?php endforeach; ?>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td align="left">Memory Size </td>
                                                            <td>
                                                                <select name="msid" style="width:200px;">
                                                                    <?php
                                                                    $sqlcarrier = $obj->SelectAll("buyback_memory_size");
                                                                    if (!empty($sqlcarrier))
                                                                        foreach ($sqlcarrier as $carrier):
                                                                            ?>
                                                                            <option value="<?php echo $carrier->id; ?>"><?php echo $carrier->name; ?></option>
                                                                        <?php endforeach; ?>
                                                                </select>
                                                            </td>

                                                            <td align="left">Set Price</td>
                                                            <td align="left" style="width: 200px;">
                                                                <input type="text" class="span12 k-textbox" type="text" id="amounts" name="amounts" placeholder="Set Price">
                                                            </td>
                                                            <td align="left"></td>
                                                            <td align="left" colspan="2"></td>
                                                        </tr>                      
                                                    </tbody>
                                                </table>    




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
                                    <?php
                                }
                                ?>

                                <div class="block well">
                                    <div class="navbar">
                                        <div class="navbar-inner">
                                            <h5><i class="icon-list-alt"></i>Buyback Device Estimated Price List</h5>
                                            <ul class="icons">
                                                <li><a data-original-title="Tooltip on left" data-placement="left" href="#" class="hovertip" title="Add New Customer"><i class="icon-plus"></i></a></li>
                                                <li><a data-original-title="Tooltip on left" data-placement="left" href="<?php echo $obj->filename(); ?>" class="hovertip" title="FAQ?"><i class="icon-fire"></i></a></li>
                                                <li><a data-original-title="Tooltip on right" data-placement="right" href="<?php echo $obj->filename(); ?>" class="hovertip" title="Reload Data"><i class="icon-refresh"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="table-overflow">
                                        <div id="grid" style="margin-left: 10px;margin-right: 10px;"></div>
                                        <script id="action_template" type="text/x-kendo-template">
                                            <a class="k-button k-button-icontext k-grid-delete" href="buyback_estimate_price.php?edit=#=id#"><i class="icon-edit"></i> Edit</a> 
                                            <a class="k-button k-button-icontext k-grid-delete" onclick="javascript:deleteClick(#=id#);" ><span class="k-icon k-delete"></span> Delete</a>
                                        </script>
                                        <script type="text/javascript">
                                            function deleteClick(id) {
                                                var c = confirm("Do you want to delete?");
                                                if (c === true) {
                                                    $.ajax({
                                                        type: "POST",
                                                        dataType: "json",
                                                        url: "./controller/buyback_estimate_price.php",
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
                                                            url: "./controller/buyback_estimate_price.php",
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
                                                                amount: {type: "number"},
                                                                career: {type: "string"},
                                                                device_type: {type: "string"},
                                                                device_condition: {type: "string"},
                                                                model: {type: "string"},
                                                                device_turn_on: {type: "string"},
                                                                water_damage: {type: "string"},
                                                                memory_size: {type: "string"}
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
                                                        {field: "career", title: "Carrier", width: "100px"},
                                                        {field: "device_type", title: "Device Type", width: "100px"},
                                                        {field: "model", title: "Model", width: "100px"},
                                                        {field: "device_condition", title: "Condition", width: "100px", filterable: false},
                                                        {field: "device_turn_on", title: "Device Turn On", width: "100px", filterable: false},
                                                        {field: "water_damage", title: "Water Damage", width: "100px", filterable: false},
                                                        {field: "memory_size", title: "Memory Size", width: "100px", filterable: false},
                                                        {field: "amount", title: "Amount", width: "80px", filterable: false},
                                                        {
                                                            title: "Action", width: "170px",
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
                                          <th>Carrier </th>
                                          <th>Device Type</th>
                                          <th>Model</th>
                                          <th>Condition</th>
                                          <th>Device Turn On</th>
                                          <th>Water Damage</th>
                                          <th>Memory Size</th>
                                          <th>Amount</th>
                                          <th width="130">Action</th>
                                          </tr>
                                          </thead>
                                          <tbody>
                                          <?php
                                          //if($input_status==1){
                                          $sql_checkin_network = $obj->SelectAll($table);
                                          //}else{
                                          //$sql_checkin_network=$obj->SelectAllByID($table,array("store_id"=>$input_by));
                                          //}
                                          $i = 1;
                                          if (!empty($sql_checkin_network))
                                          foreach ($sql_checkin_network as $row):
                                          ?>
                                          <tr>
                                          <td><?php echo $i; ?></td>
                                          <td><?php echo $obj->SelectAllByVal("buyback_network", "id", $row->nid, "name"); ?></td>
                                          <td><?php echo $obj->SelectAllByVal("buyback_device_type", "id", $row->dtid, "name"); ?></td>
                                          <td><?php echo $obj->SelectAllByVal("buyback_model", "id", $row->model, "name"); ?></td>
                                          <td><?php echo $obj->SelectAllByVal("buyback_device_condition", "id", $row->cid, "name"); ?></td>
                                          <td><?php echo $obj->SelectAllByVal("buyback_device_turn_on", "id", $row->dtoid, "name"); ?></td>
                                          <td><?php echo $obj->SelectAllByVal("buyback_water_damage", "id", $row->wdid, "name"); ?></td>
                                          <td><?php echo $obj->SelectAllByVal("buyback_memory_size", "id", $row->msid, "name"); ?></td>
                                          <td><?php echo $row->amount; ?></td>
                                          <td>
                                          <a href="<?php echo $obj->filename(); ?>?edit=<?php echo $row->id; ?>" class="btn btn-primary hovertip" title="Edit Detail"><i class="icon-edit"></i></a>
                                          <a href="<?php echo $obj->filename(); ?>?del=<?php echo $row->id; ?>" class="btn btn-danger hovertip" title="Delete"><i class="icon-remove"></i></a>
                                          </td>
                                          </tr>
                                          <?php
                                          $i++;
                                          endforeach;
                                          ?>
                                          </tbody>
                                          </table> */ ?>
                                    </div>
                                </div>
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
            <script>
                nucleus("select[name='nid']").kendoDropDownList({
                    optionLabel: " Please Select Carrier "
                }).data("kendoDropDownList").select(0);
                
                nucleus("select[name='dtid']").kendoDropDownList({
                    optionLabel: " Please Select Device Type "
                }).data("kendoDropDownList").select(0);
                
                
                nucleus("select[name='model']").kendoDropDownList({
                    optionLabel: " Please Select Device Model "
                }).data("kendoDropDownList").select(0);
                
                
                nucleus("select[name='cid']").kendoDropDownList({
                    optionLabel: " Please Select Condition "
                }).data("kendoDropDownList").select(0);
                
                
                
                nucleus("select[name='dtoid']").kendoDropDownList({
                    optionLabel: " Please Select Device Turn On "
                }).data("kendoDropDownList").select(0);
                
                
                nucleus("select[name='wdid']").kendoDropDownList({
                    optionLabel: " Please Select Any Water Damage "
                }).data("kendoDropDownList").select(0);
                
                
                nucleus("select[name='msid']").kendoDropDownList({
                    optionLabel: " Please Select Memory Size "
                }).data("kendoDropDownList").select(0);
                
                
                
            </script>    
            <!-- Right sidebar -->
            <?php //include('include/sidebar_right.php');   ?>
            <!-- /right sidebar -->

        </div>
        <!-- /main wrapper -->

    </body>
</html>
