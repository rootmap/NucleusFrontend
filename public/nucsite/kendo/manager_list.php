<?php
include('class/auth.php');
$table="manager_list";
if(isset($_GET['del']))
{
	$obj->deletesing("id",$_GET['del'],"store");	
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
                            <h5><i class="icon-tasks"></i> Manager List </h5>
                            <ul class="icons">
    <li><a href="<?php echo $obj->filename(); ?>" class="hovertip" title="Reload"><i class="font-refresh"></i></a></li>
                            </ul>
                        </div><!-- /page header -->

                        <div class="body">

                            <!-- Middle navigation standard -->
                            <?php //include('include/quicklink.php');  ?>
                            <!-- /middle navigation standard -->
                            <a href="manager.php" class="k-button"><i class="icon-plus-sign"></i> Add New Manager</a>
                            <a href="manager_list.php" class="k-button"><i class="icon-tasks"></i> Manager List</a>
                            <!-- Content container -->
                            
                            <div class="container">
                                <!-- Content Start from here customized -->
                                
                                        <!-- General form elements -->    
                                                
                                                <div class="table-overflow">
                                                    
                                                    
                                                    <div id="grid" style="margin-left: 10px;margin-right: 10px;"></div>

                                        <script id="action_template" type="text/x-kendo-template">
                                            <a class="k-button k-button-icontext k-grid-delete" href="manager.php?edit=#=id#"><i class="icon-edit"></i> Edit</a> 
                                            <a class="k-button k-button-icontext k-grid-delete" onclick="javascript:deleteClick(#=id#);" ><span class="k-icon k-delete"></span> Delete</a>
                                        </script>
                                        <script type="text/javascript">
                                            function deleteClick(id) {
                                                var c = confirm("Do you want to delete?");
                                                if (c === true) {
                                                    $.ajax({
                                                        type: "POST",
                                                        dataType: "json",
                                                        url: "./controller/manager_list.php",
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
                                                            url: "./controller/manager_list.php",
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
                                                                store_id: {type: "string"},
                                                                fullname: {type: "string"},
                                                                email: {type: "string"},
                                                                phone: {type: "string"},
                                                                username: {type: "string"},
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
                                                        {field: "store_id", title: "Store ID", width: "100px"},
                                                        {field: "fullname", title: "Full Name"},
                                                        {field: "email", title: "Email"},
                                                        {field: "phone", title: "Phone", width: "90px"},
                                                        {field: "username", title: "UserName", width: "110px"},
                                                        {field: "date", title: "Created",width: "80px"},
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
                                                                <th> Full Name </th>
                                                                <th> Email </th>
                                                                <th> Phone </th>
                                                                <th> Username </th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
															if($input_status==1)
															{
                                                            	$sql_store=$obj->SelectAllByID($table,array("status"=>4));
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
																	$sql_store=$obj_report_chain->SelectAllByID_Multiple2_Or($table,array("status"=>4),$array_ch,"store_id","1");
																}
																else
																{
																	$sql_store="";
																}
															}
															else
															{
                            									$sql_store=$obj->SelectAllByID_Multiple($table,array("store_id"=>$input_by,"status"=>4));															
															}
															$i=1;
															if(!empty($sql_store))
															foreach($sql_store as $row):
															?>
                                                                <tr>
                                                                    <td><?php echo $i; ?></td>
                                                                    <td><?php echo $row->name; ?> </td>
                                                                    <td> <?php echo $row->email; ?> </td>
                                                                    <td> <?php echo $row->phone; ?> </td>
                                                                    <td> <?php echo $row->username; ?> </td>

                                                                    <td>
                                                                    	<a href="<?php echo $obj->filename(); ?>?edit=<?php echo $row->id; ?>" class="hovertip"  onclick="javascript:return confirm('Are you absolutely sure to edit This?')" title="Edit"><i class="icon-edit"></i></a>
                                                                        <a href="<?php echo $obj->filename(); ?>?del=<?php echo $row->id; ?>" class="hovertip"  onclick="javascript:return confirm('Are you absolutely sure to delete This?')" title="Delete"><i class="icon-trash"></i></a>
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
            <?php //include('include/sidebar_right.php');  ?>
            <!-- /right sidebar -->

        </div>
        <!-- /main wrapper -->

    </body>
</html>
