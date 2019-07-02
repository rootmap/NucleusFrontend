<?php 
include('class/auth.php');
if($input_status==3 || $input_status==4)
{
	$obj->Error("Invalid Page Request.","index.php");
}
if (isset($_GET['del'])) {
    $obj->deletesing("id", $_GET['del'], "vendor");
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
                            <h5><i class="font-home"></i>Vendor Info</h5>
                            <ul class="icons">
                                <li><a href="<?php echo $obj->filename(); ?>" class="hovertip" title="Reload"><i class="font-refresh"></i></a></li>
                            </ul>
                        </div><!-- /page header -->

                        <div class="body">

                            <!-- Middle navigation standard -->
                            <a href="vendor.php" class="k-button"> <i class="icon-plus-sign"></i> Add New Vendor </a>
                            <a href="vendor_list.php" class="k-button"> <i class="icon-tasks"></i> Vendor List </a>
                            <!-- /middle navigation standard -->

                            <!-- Content container -->
                            <div class="container">

                                <div class="separator-doubled"></div> 
                                
                                
                                
                                <!-- Content Start from here customized -->
                                
                                
                                <!-- Default datatable -->
                        <div class="block well">
<!--                        	<div class="navbar">
                            	<div class="navbar-inner">
                                    <h5><i class="icon-list-alt"></i>Vendor List</h5>
                                        <ul class="icons">
                                            <li><a data-original-title="Tooltip on left" data-placement="left" href="vendor.php" class="hovertip" title="Add New Vendor"><i class="icon-plus"></i></a></li>
                                            <li><a data-original-title="Tooltip on left" data-placement="left" href="<?php //echo $obj->filename(); ?>" class="hovertip" title="FAQ?"><i class="icon-fire"></i></a></li>
                                            <li><a data-original-title="Tooltip on right" data-placement="right" href="<?php //echo $obj->filename(); ?>" class="hovertip" title="Reload Data"><i class="icon-refresh"></i></a></li>
                                        </ul>
                                </div>
                            </div>-->
                            <div class="table-overflow">
                                
                                
                                
                                
                                <div id="grid" style="margin-left: 10px;margin-right: 10px;"></div>

                                        <script id="action_template" type="text/x-kendo-template">
                                            <a class="k-button k-button-icontext k-grid-delete" href="vendor.php?edit=#=id#"><i class="icon-edit"></i> Edit</a> 
                                            <a class="k-button k-button-icontext k-grid-delete" onclick="javascript:deleteClick(#=id#);" ><span class="k-icon k-delete"></span> Delete</a>
                                        </script>
                                        <script type="text/javascript">
                                            function deleteClick(id) {
                                                var c = confirm("Do you want to delete?");
                                                if (c === true) {
                                                    $.ajax({
                                                        type: "POST",
                                                        dataType: "json",
                                                        url: "./controller/vendor_list.php",
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
                                                            url: "./controller/vendor_list.php",
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
                                                                email: {type: "string"},
                                                                account_num: {type: "string"},
                                                                phone: {type: "string"}
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
                                                        {field: "name", title: "Name"},
                                                        {field: "email", title: "Email"},
                                                        {field: "account_num", title: "Account number"},
                                                        {field: "phone", title: "Phone"},
                                                        {
                                                            title: "Action", width: "160px",
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
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Account number</th>
                                            <th>Phone</th>
                                            <th width="60">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
										if($input_status==1)
										{
                                        	$sqlvendor=$obj->SelectAll("vendor");
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
												
												$sqlvendor=$obj_report_chain->SelectAllByID_Multiple_Or("vendor",$array_ch,"store_id","1");
												$record=$obj_report_chain->SelectAllByID_Multiple_Or("vendor",$array_ch,"store_id","2");
												$record_label="Total Record ( ".$record." )"; 
												
												
											}
											else
											{
												//echo "Not Work";
												$sqlvendor="";
												$record=0;
												$record_label="Total Record ( ".$record." )"; 
											}
										}
										else
										{
											$sqlvendor=$obj->SelectAllByID("vendor",array("store_id"=>$input_by));
										}
                                        $i=1;
                                        if(!empty($sqlvendor))
                                        foreach($sqlvendor as $vendor): ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $vendor->name; ?></td>
                                            <td><?php echo $vendor->email; ?></td>
                                            <td><?php echo $vendor->account_num; ?></td>
                                            <td><?php echo $vendor->phone; ?></td>
                                            <td width="100">
                                                <a href="vendor.php?edit=<?php echo $vendor->id; ?>" class="btn btn-info hovertip" title="Edit"><i class="icon-edit"></i></a>
                                                <a href="<?php echo $obj->filename(); ?>?del=<?php echo $vendor->id; ?>" class="btn btn-danger hovertip" title="Delete"><i class="icon-remove"></i></a>
                                            </td>
                                        </tr>
                                        <?php $i++; endforeach; ?>
                                    </tbody>
                                </table> */ ?>
                            </div>
                        </div>
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
            <?php //include('include/footer.php'); ?>
            <!-- Right sidebar -->
            <?php //include('include/sidebar_right.php'); ?>
            <!-- /right sidebar -->

        </div>
        <!-- /main wrapper -->

    </body>
</html>
