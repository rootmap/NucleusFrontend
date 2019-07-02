<?php
include('class/auth.php');
if ($input_status == 3) {
    $obj->Error("Access Denied", "index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php //echo $obj->bodyhead();  ?>
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
                            <h5><i class="icon-th-list"></i>
                                <span style="border-right:2px #333 solid; padding-right:10px;"> Setting Punch In/Out Setting List </span>
                                <span><i class="font-calendar"></i> <a data-toggle="modal" href="#myModal"> Generate Punch In/Out Report</a></span>

                            </h5>
                            <ul class="icons">
                                <li><a href="<?php echo $obj->filename(); ?>" class="hovertip" title="Reload"><i class="font-refresh"></i></a></li>
                            </ul>
                        </div><!-- /page header -->

                        <div class="body">

                            <!-- Middle navigation standard -->
                            <?php //include('include/quicklink.php');     ?>
                            <!-- /middle navigation standard -->
                            <!-- Dialog content -->
                            <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h5 id="myModalLabel"><i class="font-calendar"></i> Generate Punch In/Out Report <span id="mss"></span></h5>
                                </div>
                                <div class="modal-body">

                                    <div class="row-fluid">
                                        <form class="form-horizontal" method="get" action="">
                                            <div class="control-group">
                                                <label class="control-label"><strong>Date Search:</strong></label>
                                                <div class="controls">
                                                    <ul class="dates-range">
                                                        <li><input type="text" id="fromDate" name="from" placeholder="From" /></li>
                                                        <li class="sep">-</li>
                                                        <li><input type="text" id="toDate" name="to" placeholder="To" /></li>
                                                        <li class="sep">&nbsp;</li>
                                                        <li><button class="btn btn-primary" type="submit">Search Report</button></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </form>


                                    </div>

                                </div>

                            </div>
                            <!-- /dialog content -->
                            <!-- Content container -->
                            <div class="container">
                                <!-- Content Start from here customized -->
                                <!-- Default datatable -->
                                <div class="block">





                                    <?php
                                    $cond = $cms->FrontEndDateSearch('from', 'to');
                                    ?>


                                    <div id="grid" style="margin-left: 10px;margin-right: 10px;"></div>

                                    <script type="text/javascript">
                                        var gridElement = $("#grid");
                                        function showLoading(e) {
                                            kendo.ui.progress(gridElement, true);
                                        }
                                        function restoreSelection(e) {
                                            kendo.ui.progress(gridElement, false);
                                        }
                                        jQuery(document).ready(function () {
                                            var dataSource = new kendo.data.DataSource({
                                                requestStart: showLoading,
                                                transport: {
                                                    read: {
                                                        url: "./controller/punch_in_out.php<?php echo $cond; ?>",
                                                        type: "GET",
                                                        datatype: "json"
                                                    }, update: {
                                                        url: "./controller/punch_in_out.php",
                                                        type: "POST",
                                                        datatype: "json",
                                                        complete: function (response) {
                                                            jQuery(".k-i-refresh").click();
                                                        }
                                                    }
                                                },
                                                autoSync: false,
                                                schema: {
                                                    data: "data",
                                                    total: "total",
                                                    model: {
                                                        id: "id",
                                                        fields: {
                                                            id: {nullable: true, editable: false},
                                                            cashier_id: {type: "number"},
                                                            cashier: {type: "string"},
                                                            indate: {type: "string"},
                                                            intime: {type: "string"},
                                                            outdate: {type: "string"},
                                                            outtime: {type: "string"},
                                                            elapsed_time: {type: "string", editable: false},
                                                            status: {type: "number"}
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
                                                dataBound: restoreSelection,
                                                pageable: {
                                                    refresh: true,
                                                    input: true,
                                                    numeric: false,
                                                    pageSizes: true,
                                                    pageSizes:[10, 50, 200, 500, 1000, 5000, 10000]
                                                },
                                                sortable: true,
                                                groupable: true,
                                                columns: [
                                                    {field: "id", title: "S.ID"},
                                                    {field: "cashier_id",
                                                        title: "Cashier Name", width: "120px",
                                                        editor: CashierDropDownEditor,
                                                        template: "#=cashier#"
                                                    },
                                                    {field: "indate", title: "indate"},
                                                    {field: "intime", title: "intime", format: "{0:hh:mm:ss tt}", editor: timeEditor},
                                                    {field: "outdate", title: "outdate"},
                                                    {title: "outtime", field: "outtime", format: "{0:hh:mm:ss tt}", editor: timeEditor},
                                                    {field: "elapsed_time", title: "Elapsed Time"},
                                                    {command: ["edit"], title: "&nbsp;", width: "200px"}
                                                ],
                                                editable: "inline"
                                            });
                                        });

                                        function timeEditor(container, options) {

                                            jQuery('<input data-text-field="' + options.field + '" data-value-field="' + options.field + '" data-bind="value:' + options.field + '" data-format="' + options.format + '"/>')
                                                    .appendTo(container)
                                                    .kendoTimePicker({});
                                        }

                                        jQuery('.k-i-clock').css("margin-top", "0px !important");


                                        function CashierDropDownEditor(container, options) {
                                            jQuery('<input required data-text-field="name" data-value-field="id" data-bind="value:' + options.field + '"/>')
                                                    .appendTo(container)
                                                    .kendoDropDownList({
                                                        autoBind: false,
                                                        dataTextField: "name",
                                                        dataValueField: "id",
                                                        dataSource: {
                                                            transport: {
                                                                read: {
                                                                    url: "controller/cashier.php",
                                                                    type: "GET",
                                                                    datatype: "json"
                                                                }
                                                            },
                                                            schema: {
                                                                data: "data"
                                                            }
                                                        },
                                                        optionLabel: "Select Cashier"
                                                    });
                                        }

                                    </script>













                                </div> 



                                <!-- /default datatable -->


                                <!-- Content End from here customized -->




                                <div class="separator-doubled"></div>


                                <a href="<?php echo $obj->filename(); ?>?export=excel"><img src="pos_image/file_excel.png"></a>
                                <a href="<?php echo $obj->filename(); ?>?export=pdf"><img src="pos_image/file_pdf.png"></a>


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
            <?php
//include('include/footer.php');
//echo $cms->KendoFotter();
            ?>

        </div>
        <!-- /main wrapper -->

    </body>
</html>
