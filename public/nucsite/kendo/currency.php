<?php
include('class/auth.php');
if ($input_status == 3 || $input_status == 4) {
    $obj->Error("Invalid Page Request.", "index.php");
}
$table = "currency";
if (isset($_GET['del'])) {
    $obj->deletesing("id", $_GET['del'], $table);
}

if (isset($_POST['save'])) {
    if ($obj->exists_multiple($table, array("name" => $name)) == 0) {

        if ($obj->insert($table, array("name" => $_POST['name'], "sign" => $_POST['sign'], "status" => 1, "date" => date('Y-m-d'))) == 1) {
            $obj->Success("Currency Succesfully Saved", $obj->filename());
        } else {
            $obj->Error("Currency Saved Failed", $obj->filename());
        }
    } else {
        $obj->Error("Currency Already Exists", $obj->filename());
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
                            <h5><i class="font-cogs"></i> Currency Info </h5>
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
                                            <fieldset>
                                                <div class="control-group">
                                                    <label class="span12"> Currency Name <input class="span5 k-textbox" type="text" name="name" /> </label>
                                                </div>
                                                <div class="control-group">
                                                    <label class="span12"> Currency Sign <input class="span5 k-textbox" type="text" name="sign" /> </label>
                                                </div>
                                                <div class="control-group">
                                                    <button type="submit" name="save" class="k-button"><i class="icon-cog"></i> Save Currency </button>
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
                                                <a class="k-button k-button-icontext k-grid-delete" onclick="javascript:deleteClick(#=id#);" ><span class="k-icon k-delete"></span> Delete</a>
                                            </script>

                                            <script type="text/javascript">
                                                function deleteClick(id) {
                                                    var c = confirm("Do you want to delete?");
                                                    if (c === true) {
                                                        $.ajax({
                                                            type: "POST",
                                                            dataType: "json",
                                                            url: "./controller/currency.php",
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
                                                                url: "./controller/currency.php",
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
                                                                    name: {type: "string"},
                                                                    sign: {type: "string"},
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
                                                            {field: "name", title: "Currency Name ", width: "110px"},
                                                            {field: "sign", title: "Currency Sign ", width: "100px"},
                                                            {field: "date", title: "Created ", width: "70px", filterable: false},
                                                            {
                                                                title: "Action", width: "90px",
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
<?php //include('include/footer.php');  ?>
            <!-- Right sidebar -->
<?php //include('include/sidebar_right.php');   ?>
            <!-- /right sidebar -->

        </div>
        <!-- /main wrapper -->

    </body>
</html>
