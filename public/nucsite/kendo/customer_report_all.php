<?php
include('class/auth.php');
extract($_GET);

function checkin_status($st) {
    if ($st == 1) {
        return "Completed";
    } else {
        return "Not Completed";
    }
}

function checkin_paid($st) {
    if ($st == 0) {
        return "<label class='label label-danger'>Not Paid</label>";
    } elseif ($st == 33) {
        return "<label class='label label-warning'>Partial</label>";
    } else {
        return "<label class='label label-success'>Paid</label>";
    }
}

function checkin_paid2($st) {
    if ($st == 0) {
        return "UNPAID";
    } else {
        return "Paid";
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
        <?php include ('include/header.php'); ?>
        <!-- Main wrapper -->
        <div class="wrapper three-columns">

            <!-- Left sidebar -->
            <?php include ('include/sidebar_left.php'); ?>
            <!-- /left sidebar -->


            <!-- Main content -->
            <div class="content">

                <!-- Info notice -->
                <?php echo $obj->ShowMsg(); ?>
                <!-- /info notice -->

                <div class="outer">
                    <div class="inner">
                        <div class="page-header"><!-- Page header -->
                            <h5><i class="icon-ok-circle"></i>
                                <span>Customer Report </span>
                            </h5>
                            <ul class="icons">
                                <li><a href="<?php echo $obj->filename(); ?>?cid=<?php echo $_GET['cid']; ?>" class="hovertip" title="Reload"><i class="font-refresh"></i></a></li>
                            </ul>
                        </div><!-- /page header -->

                        <div class="body">

                            <!-- Middle navigation standard -->

                            <?php //include('include/quicklink.php');              ?>
                            <!-- /middle navigation standard -->

                            <!-- Content container -->
                            <div class="container">


                                <div class="block">
                                    <div class="table-overflow">
                                        <div class="row-fluid span8">
                                            <div class="span12">
                                                <h3 class="span12" style="padding-left: 20px;">Customer Detail </h3>
                                            </div>

                                            <div class="clear"></div>
                                            <div class="span12">
                                                <label class="span12"> 
                                                    <strong class="span2">Business Name: </strong> 

                                                    <span class="span8">  
                                                        <?php echo $obj->SelectAllByVal("coustomer", "id", $cid, "businessname"); ?> </span>
                                                </label>
                                            </div>

                                            <div class="clearfix"></div>
                                            <div class="span12">
                                                <label class="span12"> <strong class="span2">Name: </strong><span class="span8">
                                                        <?php echo $obj->SelectAllByVal("coustomer", "id", $cid, "firstname"); ?> <?php echo $obj->SelectAllByVal("coustomer", "id", $cid, "lastname"); ?> </span>
                                                </label>
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="span12">
                                                <label class="span12"> <strong class="span2">Email: </strong><span class="span8">
                                                        <?php echo $obj->SelectAllByVal("coustomer", "id", $cid, "email"); ?></span> 
                                                </label>
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="span12">
                                                <label class="span12"> <strong class="span2">Invoice Email: </strong><span class="span8">
                                                        <?php echo $obj->SelectAllByVal("coustomer", "id", $cid, "invoice_email"); ?> </span> 
                                                </label>
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="span12">
                                                <label class="span12"> <strong class="span2">Address: </strong><span class="span8">
                                                        <?php echo $obj->SelectAllByVal("coustomer", "id", $cid, "address1"); ?>  </span>
                                                </label>
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="span12">
                                                <label class="span12"> <strong class="span2">Phone: </strong><span class="span8">
                                                        <?php echo $obj->SelectAllByVal("coustomer", "id", $cid, "phone"); ?> </span> 
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Content Start from here customized -->

                                <div class="block">
                                    <div class="table-overflow">
                                        <div class="k-grid  k-secondary" data-role="grid" style="margin-left: 10px;margin-right: 10px;">
                                            <form method="post" action="pos.php" name="multisales">
                                                <div class="k-toolbar k-grid-toolbar" style="padding: 10px;">
                                                    You Can Pay All Invoice BY Click On Pay All
                                                    <button type="submit" class="k-button k-button-icontext k-grid-add" name="payall">
                                                        <span class="k-icon k-add"></span>
                                                        Pay All
                                                    </button>
                                                    <input type="hidden" name="cid" value="<?php echo $_GET['cid']; ?>">
                                                    <span id="hiddendatastrig"></span>
                                                </div>
                                            </form>
                                        </div>
                                        <div id="grid" style="margin-left: 10px;margin-right: 10px;"></div>
                                        <script id="checkin_link" type="text/x-kendo-template">
                                            <a href="view_checkin.php?ticket_id=#=checkin_id#">#=checkin_id#</a>
                                        </script>
                                        <script id="checkin_status" type="text/x-kendo-template">
                                            <label class='label label-danger'>Not Paid</label>

                                        </script>
                                        <script id="checkin_price" type="text/x-kendo-template">

                                            <a class="btn btn-info" href="pos.php?newsales=1&amp;pid=#=pid#&amp;price=#=checkin_price#&amp;checkin_id=#=checkin_id#&AMP;cid=#=cid#">$ #=checkin_price# Send To Pos</a>

                                        </script>

                                        <script type="text/javascript">
                                            function deleteClick(id) {
                                                var c = confirm("Do you want to delete?");
                                                if (c === true) {
                                                    $.ajax({
                                                        type: "POST",
                                                        dataType: "json",
                                                        url: "./controller/checkin_list_unpaid.php",
                                                        data: {id: id},
                                                        success: function (result) {
                                                            $(".k-i-refresh").click();
                                                        }
                                                    });
                                                }
                                            }

                                        </script>
                                        <?php
                                        $cond = $cms->FrontEndDateSearch('from', 'to');
                                        if (empty($cond)) {
                                            $cond .="?cid=" . $_GET['cid'];
                                        } else {
                                            $cond .="&cid=" . $_GET['cid'];
                                        }
                                        ?>
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
                                                            url: "./controller/checkin_list_unpaid.php<?php echo $cond; ?>",
                                                            type: "GET",
                                                            datatype: "json",
                                                            complete: function (returndata) {
                                                                var htmlString = '';
                                                                jQuery.each(returndata, function (index, key) {
                                                                    if (index == "responseJSON") {
                                                                        //console.log(key.data);
                                                                        jQuery.each(key.data, function (indexk, keyk) {
                                                                            console.log(keyk.id);
                                                                            htmlString += '<input type="hidden" name="pid[]" value="' + keyk.pid + '">';
                                                                            htmlString += '<input type="hidden" name="price[]" value="' + keyk.checkin_price + '">';
                                                                            htmlString += '<input type="hidden" name="checkinid[]" value="' + keyk.checkin_id + '">';
                                                                        });
                                                                    }
                                                                });
                                                                jQuery("#hiddendatastrig").html(htmlString);
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
                                                                id: {nullable: true},
                                                                checkin_id: {type: "string"},
                                                                detail: {type: "string"},
                                                                problem: {type: "string"},
                                                                checkin_price: {type: "string"},
                                                                date: {type: "string"},
                                                                status: {type: "number"},
                                                                cid: {type: "string"},
                                                                pid: {type: "number"}
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
                                                        {field: "id", title: "S.ID", width: "60px"},
                                                        {title: "Checkin Id", width: "90px", template: kendo.template($("#checkin_link").html())},
                                                        {field: "detail", title: "Detail", width: "90px"},
                                                        {field: "problem", title: "problem", width: "80px"},
                                                        {title: "Checkin Price", width: "90px", template: kendo.template($("#checkin_price").html())},
                                                        {field: "date", title: "Created", width: "50px"},
                                                        {title: "status", width: "50px", template: kendo.template($("#checkin_status").html())}
                                                    ],
                                                });
                                            });

                                        </script>













                                    </div>
                                </div> 
                                <!-- Default datatable -->


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
            <!-- /right sidebar -->

        </div>
        <!-- /main wrapper -->

    </body>
</html>
