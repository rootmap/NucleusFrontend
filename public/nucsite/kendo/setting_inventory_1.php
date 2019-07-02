<?php
include('class/auth.php');
if ($input_status == 3 || $input_status == 2 || $input_status == 4) {
    $obj->Error("Invalid Page Request.", "index.php");
}
$table = "product_lcd_color";
if (isset($_POST['create'])) {
    extract($_POST);
//	$chk=$obj->exists_multiple($table,array("store_id"=>$input_by));
//	if($chk==0)
//	{
    if ($obj->insert("product_lcd_color", array("name" => $name,
                "code" => $code,
                "date" => date('Y-m-d'),
                "status" => 1)) == 1) {
        $obj->Success("Successfully Saved", $obj->filename());
    } else {
        $obj->Error("Something is wrong, Try again.", $obj->filename());
    }
//	}
//	else
//	{
//		if($obj->update($table,array("store_id"=>$input_by,
//		"send_daily_email"=>$send_daily_email, 
//		"enable_wholesale"=>$enable_wholesale, 
//		"enable_purchas_pub"=>$enable_purchas_pub, 
//		"list_product_category"=>$list_product_category, 
//		"date"=>date('Y-m-d'), 
//		"status"=>1))==1)
//		{
//			$obj->Success("Successfully Changed", $obj->filename());
//		}
//		else
//		{
//			$obj->Error("Something is wrong, Try again.", $obj->filename());
//		}
//	}
}
if (isset($_GET['del'])) {
    $obj->deletesing("id", $_GET['del'], $table);
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
                            <h5><i class="font-cogs"></i> Inventory Product Color Setting </h5>
                            <ul class="icons">
                                <li><a href="<?php echo $obj->filename(); ?>" class="hovertip" title="Reload"><i class="font-refresh"></i></a></li>
                            </ul>
                        </div><!-- /page header -->

                        <div class="body">

                            <!-- Middle navigation standard -->
                            <?php //include('include/quicklink.php');    ?>
                            <!-- /middle navigation standard -->

                            <!-- Content container -->
                            <div class="container">




                                <!-- Content Start from here customized -->


                                <form class="form-horizontal" method="post" name="invoice" action="">
                                    <fieldset>
                                        <!-- General form elements -->
                                        <div class="row-fluid span12">     
                                            <!-- Selects, dropdowns -->

                                            <!-- /selects, dropdowns -->


                                            <div class="span7 well">
                                                <!-- Selects, dropdowns -->

                                                <div class="control-group">
                                                    <label class="control-label"> Color Name:</label>
                                                    <div class="controls">
                                                        <input type="text" class="k-textbox" name="name" />
                                                    </div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label">Choose Color:</label>
                                                    <div class="controls">
                                                        <div class="input-append color" data-color="rgb(255, 146, 180)" data-color-format="rgb" id="cp3">
                                                            <input type="text" class="k-textbox" name="code" value="" readonly >
                                                            <span class="add-on" style="height: 10px; margin-top: 1px;"><i style="background-color: rgb(255, 146, 180); margin-top: -3px;"></i></span>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="control-group">
                                                    <button type="submit" name="create" class="k-button"><i class="icon-cog"></i> Save Changes </button>
                                                </div>

                                                <!-- /selects, dropdowns -->
                                            </div>
                                            <div class="span5 well">
                                                <!-- Selects, dropdowns -->
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
                                                                    url: "./controller/setting_inventory_1.php",
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
                                                                        url: "./controller/setting_inventory_1.php",
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
                                                                            code: {type: "string"}
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
                                                                    {field: "name", title: "Color Name ", width: "80px"},
                                                                    {field: "code", title: "Color Code ", width: "100px",},
                                                                    {
                                                                        title: "Action", width: "80px",
                                                                        template: kendo.template($("#action_template").html())
                                                                    }
                                                                ],
                                                            });
                                                        });

                                                    </script>
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                   <?php /* <table class="table table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Color Name </th>
                                                                <th>Color Code </th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $sqlcc = $obj->FlyQuery("SELECT * FROM product_lcd_color");
                                                            if (!empty($sqlcc)) {
                                                                $i=1;
                                                                foreach ($sqlcc as $cc):
                                                                    ?>
                                                                    <tr>
                                                                        <td><?php echo $i; ?></td>
                                                                        <td><?php echo $cc->name; ?></td>
                                                                        <td>
                                                                            <button type="button" class="btn" style="background:<?php echo $cc->code; ?>;"><?php echo $cc->code; ?></button>
                                                                        </td>
                                                                        <td>
                                                                            <a href="<?php echo $obj->filename(); ?>?del=<?php echo $cc->id; ?>"><i class="icon-trash"></i></button>
                                                                        </td>
                                                                    </tr>
                                                                    <?php
                                                                    $i++;
                                                                endforeach;
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>*/?>
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
