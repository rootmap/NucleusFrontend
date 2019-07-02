<?php
include('class/auth.php');
if ($input_status == 3 || $input_status == 4) {
    $obj->Error("Invalid Page Request.", "index.php");
}
$store = $input_by;
$table = "store_currency";
if (isset($_GET['del'])) {
    $obj->deletesing("id", $_GET['del'], $table);
}

if (isset($_POST['save'])) {
    if ($obj->exists_multiple($table, array("currency_id" => $currency)) == 0) {

        if ($obj->insert($table, array("store_id" => $store, "currency_id" => $_POST['currency'], "status" => 0, "date" => date('Y-m-d'))) == 1) {
            $obj->Success("Currency Succesfully Saved", $obj->filename());
        } else {
            $obj->Error("Currency Saved Failed", $obj->filename());
        }
    } else {
        $obj->Error("Currency Already Exists", $obj->filename());
    }
}
if (isset($_GET['status'])) {
    $obj->update("store_currency",array("`store_id`"=>$input_by,"`status`"=>0));
    $obj->update("store_currency", array("id" => $_GET['status'],"status" =>1));
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
                            <h5><i class="font-cogs"></i> Store Currency Info </h5>
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
                                    <div class="span5" style="padding:0px; margin:0px;">
                                        <form class="form-horizontal" method="post" name="invoice" action="">
                                            <fieldset>
                                                <!--                                                <div class="control-group">
                                                                                                    <label class="span12"> Currency Name <input class="span5 k-textbox" type="text" name="name" /> </label>
                                                                                                        
                                                                                                </div>-->
                                                <div class="control-group">
                                                    <label style="width: 150px;" class="control-label">Select Currency:</label>
                                                    <div class="controls" id="newcus">
                                                        <select name="currency" id="currency_set">
                                                            <?php
                                                            $sqlpdata = $obj->FlyQuery("SELECT * FROM currency");

                                                            if (!empty($sqlpdata))
                                                                foreach ($sqlpdata as $row):
                                                                    ?>
                                                                    <option value="<?php echo $row->id; ?>"><?php echo $row->name; ?> - (<?php echo $row->sign; ?>)</option> 
                                                                    <?php
                                                                endforeach;
                                                            ?> 
                                                            <!--                                                                        <option value="0">Add Currency To Store</option>-->
                                                        </select>

                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <button type="submit" name="save" class="k-button"><i class="icon-cog"></i> Save Store Currency </button>
                                                </div>
                                            </fieldset>                     

                                        </form>
                                    </div>
                                    <!-- /selects, dropdowns -->



                                    <!-- Selects, dropdowns -->
                                    <div class="span7" style="padding:0px; margin:0px; float:right;">


                                        <div class="table-overflow">


                                            <div id="grid" style="margin-left: 10px;margin-right: 10px;"></div>
                                            <script id="action_template" type="text/x-kendo-template">
                                                <a class="k-button k-button-icontext k-grid-delete" onclick="javascript:deleteClick(#=id#);" ><span class="k-icon k-delete"></span> Delete</a>
                                            </script>
                                            <script id="default_template" type="text/x-kendo-template">
                                                #if(status==0){
                                                    #<a class="k-button" href="<?php echo $obj->filename(); ?>?status=#=id#">Disabled</a>#
                                                }else if(status==1){
                                                    #<a class="k-button" href="<?php echo $obj->filename(); ?>?status=#=id#">Enabled</a>#
                                                }#
                                            </script>
                                            <script type="text/javascript">
                                                function deleteClick(id) {
                                                    var c = confirm("Do you want to delete?");
                                                    if (c === true) {
                                                        $.ajax({
                                                            type: "POST",
                                                            dataType: "json",
                                                            url: "./controller/store_currency.php",
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
                                                                url: "./controller/store_currency.php",
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
                                                                    currency: {type: "string"},
                                                                    currency_sign: {type: "string"}
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
                                                            {field: "currency", title: "Currency Name ", width: "80px", filterable: false},
                                                            {field: "currency_sign", title: "Currency Sign ", width: "80px", filterable: false},
                                                            {
                                                                title: "Default", width: "80px",
                                                                template: kendo.template($("#default_template").html())
                                                            },
                                                            {
                                                                title: "Action", width: "80px",
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
                                              <th> Currency Name </th>
                                              <th> Date </th>
                                              <th width="60">Action</th>
                                              </tr>
                                              </thead>
                                              <tbody>
                                              <?php
                                              $data=$obj->SelectAll($table);
                                              $i=1;
                                              if(!empty($data))
                                              foreach($data as $row): ?>
                                              <tr>
                                              <td><?php echo $i; ?></td>
                                              <td><?php echo $row->name; ?></td>
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
                nucleus("#currency_set").kendoDropDownList({
                    optionLabel: " -- Select A Currency -- "
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
