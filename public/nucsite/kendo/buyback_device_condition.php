<?php 
include('class/auth.php');
if($input_status!=1)
{
	$obj->Error("Invalid Page Request.","index.php");
}
$table2="checkin";
$table="buyback_device_condition";

if(@$_GET['del'])
{
	$obj->deletesing("id",$_GET['del'],$table);
}

if(isset($_POST['save']))
{
	extract($_POST);
	if(!empty($name))
	{
		if($obj->exists_multiple($table,array("store_id"=>$input_by,"name"=>$name))==0)
		{
			if($obj->insert($table,array("store_id"=>$input_by,"name"=>$name,"date"=>date('Y-m-d'),"status"=>1))==1)
			{
				$obj->Success($name." is Saved Successfully.",$obj->filename());	
			}
			else
			{
				$obj->Error("Failed, Sql Error",$obj->filename());		
			}
		}
		else
		{
			$obj->Error("Failed, Already Exists",$obj->filename());
		}
	}
	else
	{
		$obj->Error("Failed, Some field is Empty",$obj->filename());	
	}
}

if(isset($_POST['edit']))
{
	extract($_POST);
	if(!empty($name))
	{
			
			if($obj->update($table,array("id"=>$id,"store_id"=>$input_by,"name"=>$name,"date"=>date('Y-m-d'),"status"=>1))==1)
			{
				$obj->Success($name." is Saved Changed.",$obj->filename());	
			}
			else
			{
				$obj->Error("Failed, Sql Error",$obj->filename());		
			}
	}
	else
	{
		$obj->Error("Failed, Some field is Empty",$obj->filename());	
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
                            <h5><i class="font-cogs"></i> BuyBack Device Condition Setting </h5>
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
                                
								<?php if(@$_GET['edit']){ ?>
                                <h3 class="subtitle"> Edit Detail</h3>
                                <form class="form-horizontal" method="post" enctype="multipart/form-data" name="invoice" action="">
                                    <fieldset>
                                        <!-- General form elements -->
                                        <div class="row-fluid  span6 well">     
                                            <!-- Selects, dropdowns -->
                                                
                                                <div class="control-group">
                                                    <label class="span12"> Device Condition  </label>
	<input class="span6 k-textbox" value="<?php echo $obj->SelectAllByVal($table,"id",$_GET['edit'],"name"); ?>" type="text" name="name" />
    <input type="hidden" value="<?php echo $_GET['edit']; ?>" name="id">
                                                </div>
                                                <div class="control-group">
                                                    <button type="submit" name="edit" class="k-button"><i class="icon-cog"></i> Save Changes </button>
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
								else
								{
								?>
                                <form class="form-horizontal" method="post" enctype="multipart/form-data" name="invoice" action="">
                                    <fieldset>
                                        <!-- General form elements -->
                                        <div class="row-fluid  span6 well">     
                                            <!-- Selects, dropdowns -->
                                                
                                                <div class="control-group">
                                                    <label class="span12"> Device Condition  </label>
                                                        <input class="span6 k-textbox" placeholder="Put Here Device Condition Name" type="text" name="name" />
                                                </div>
                                                
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
                                    <h5><i class="icon-list-alt"></i>Buyback Device Condition List</h5>
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
                                                <a class="k-button k-button-icontext k-grid-delete" href="buyback_device_condition.php?edit=#=id#"><i class="icon-edit"></i> Edit</a> 
                                                <a class="k-button k-button-icontext k-grid-delete" onclick="javascript:deleteClick(#=id#);" ><span class="k-icon k-delete"></span> Delete</a>
                                            </script>
                                            <script type="text/javascript">
                                                function deleteClick(id) {
                                                var c = confirm("Do you want to delete?");
                                                        if (c === true) {
                                                $.ajax({
                                                type: "POST",
                                                        dataType: "json",
                                                        url: "./controller/buyback_device_condition.php",
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
                                                url: "./controller/buyback_device_condition.php",
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
                                                        {field: "id", title: "Buyback Network-ID", width: "100px", filterable: false},
                                                        {field: "name", title: "Network Name", width: "140px"},
                                                        {field: "date", title: "Created", width: "40px"},
                                                        {
                                                        title: "Action", width: "70px",
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
                                            <th>Buyback Device Condition-ID</th>
                                            <th>Device Condition Name</th>
                                            <th>Date Added</th>
                                            <th width="140">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
										//if($input_status==1){
										$sql_checkin_network=$obj->SelectAll($table);
										//}else{
										//$sql_checkin_network=$obj->SelectAllByID($table,array("store_id"=>$input_by));	
										//}
										$i=1;
										if(!empty($sql_checkin_network))
										foreach($sql_checkin_network as $checkin_network): ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $checkin_network->id; ?></td>
                                            <td><?php echo $checkin_network->name; ?></td>
        									<td><?php echo $checkin_network->date; ?></td>
                                            <td>
                                                <a href="<?php echo $obj->filename(); ?>?edit=<?php echo $checkin_network->id; ?>" class="btn btn-primary hovertip" title="Edit Detail"><i class="icon-edit"></i></a> 
                                                <a href="<?php echo $obj->filename(); ?>?del=<?php echo $checkin_network->id; ?>" class="btn btn-danger hovertip" title="Delete"><i class="icon-remove"></i></a>
                                            </td>
                                        </tr>
                                        <?php 
										$i++;
										endforeach; ?>
                                    </tbody>
                                </table>*/?>
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
            <?php //include('include/footer.php'); ?>
            <!-- Right sidebar -->
            <?php //include('include/sidebar_right.php');  ?>
            <!-- /right sidebar -->

        </div>
        <!-- /main wrapper -->

    </body>
</html>
