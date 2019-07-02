<?php 
include('class/auth.php');
if($input_status==3 || $input_status==4)
{
	$obj->Error("Invalid Page Request.","index.php");
}
$table="unlock_service";
$subserverlink="http://wirelessgeekswholesale.com";
if(@$_GET['del'])
{
	$obj->deletesing("id",$_GET['del'],$table);
}

if(isset($_POST['save']))
{
	extract($_POST);
	if(!empty($name) && !empty($price) && !empty($detail) && !empty($delivery_time))
	{
		if($obj->exists_multiple($table,array("name"=>$name))==0)
		{
			if($obj->insert($table,array("name"=>$name,"price"=>$price,"delivery_time"=>$delivery_time,"detail"=>$detail,"date"=>date('Y-m-d'),"status"=>1))==1)
			{
				header("location: ".$subserverlink."/product-admin/addservice_api.php?id=".$id."&name=".$name."&price=".$price."&delivery_time=".$delivery_time."&backurlpage=unlock_service.php&addservice=yes");
                exit();
				//$obj->Success($name." is Saved Successfully.",$obj->filename());	
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

if(isset($_GET['serverst'])==1)
{
	$obj->Success("Both System Successfully Updated.",$obj->filename());	
}

if(isset($_GET['serverst'])==3)
{
	$obj->Success("Both System Successfully Saves Service Detail.",$obj->filename());	
}

if(isset($_GET['serverst'])==2)
{
	$obj->Success("Both System Not Updated.",$obj->filename());	
}

if(isset($_POST['edit']))
{
	extract($_POST);
	if(!empty($name))
	{
			if($obj->update($table,array("id"=>$id,"name"=>$name,"price"=>$price,"delivery_time"=>$delivery_time,"detail"=>$detail,"date"=>date('Y-m-d'),"status"=>1))==1)
			{
				header("location: ".$subserverlink."/product-admin/addservice_api.php?id=".$id."&name=".$name."&price=".$price."&delivery_time=".$delivery_time."&backurlpage=unlock_service.php&editservice=yes");
                exit();
				//$obj->Success($name." is Saved Successfully.",$obj->filename());	
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
        <script src="ckeditor/ckeditor.js"></script>
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
                            <h5><i class="font-cogs"></i> Unlock Service Setting </h5>
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
                                <h3 class="subtitle"> Edit Unlock Service Detail</h3>
                                <form class="form-horizontal" method="post" enctype="multipart/form-data" name="invoice" action="">
                                    <fieldset>
                                        <!-- General form elements -->
                                        <div class="row-fluid  span6 well">     
                                            <!-- Selects, dropdowns -->
                                                
                                                    <input type="hidden" value="<?php echo $_GET['edit']; ?>" name="id">
												
                                                <div class="control-group">
                                                    <label class="span12"> Unlock Service  </label>
                                                        <input class="span6 k-textbox"  value="<?php echo $obj->SelectAllByVal($table,"id",$_GET['edit'],"name"); ?>"  placeholder="Put Your Service Name" type="text" name="name" />
                                                </div>
                                                <div class="control-group">
                                                    <label class="span12"> Unlock Price  </label>
                                                        <input class="span6 k-textbox"  value="<?php echo $obj->SelectAllByVal($table,"id",$_GET['edit'],"price"); ?>"  placeholder="Unlock Price" type="text" name="price" />
                                                </div>
                                                <div class="control-group">
                                                    <label class="span12"> Delivery Time  </label>
                                                        <input class="span6"  value="<?php echo $obj->SelectAllByVal($table,"id",$_GET['edit'],"delivery_time"); ?>"  placeholder="Delivery Time" type="text" name="delivery_time" />
                                                </div>
                                                <div class="control-group">
                                                        <textarea class="span6 k-textbox" id="article" placeholder="Detail Here"  name="detail"><?php echo $obj->SelectAllByVal($table,"id",$_GET['edit'],"detail"); ?></textarea>
                                                        <script>

                                                    // This call can be placed at any point after the
                                                    // <textarea>, or inside a <head><script> in a
                                                    // window.onload event handler.

                                                    CKEDITOR.replace( 'article', {
                                                            extraPlugins: 'magicline',	// Ensure that magicline plugin, which is required for this sample, is loaded.
                                                            allowedContent: true		// Switch off the ACF, so very complex content created to
                                                                                                                    // show magicline's power isn't filtered.
                                                    } );

                                            </script> 
                                                </div>                                                

                                                
                                                
                                                <div class="control-group">
                                                    <button type="submit" name="edit" class="k-button"><i class="icon-cog"></i> Update Changes </button>
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
                                                    <label class="span12"> Unlock Service  </label>
                                                        <input class="span6 k-textbox" placeholder="Put Your Service Name" type="text" name="name" />
                                                </div>
                                                <div class="control-group">
                                                    <label class="span12"> Unlock Price  </label>
                                                        <input class="span6 k-textbox" placeholder="Unlock Price" type="text" name="price" />
                                                </div>
                                                <div class="control-group">
                                                    <label class="span12"> Delivery Time  </label>
                                                        <input class="span6 k-textbox" placeholder="Delivery Time" type="text" name="delivery_time" />
                                                </div>
                                                <div class="control-group"> 
                                                        <textarea class="span6 k-textbox" id="article" placeholder="Detail Here"  name="detail"></textarea>
                                                        <script>

                                                    // This call can be placed at any point after the
                                                    // <textarea>, or inside a <head><script> in a
                                                    // window.onload event handler.

                                                    CKEDITOR.replace( 'article', {
                                                            extraPlugins: 'magicline',	// Ensure that magicline plugin, which is required for this sample, is loaded.
                                                            allowedContent: true		// Switch off the ACF, so very complex content created to
                                                                                                                    // show magicline's power isn't filtered.
                                                    } );

                                            </script>
                                                </div>
                                                
                                                <div class="control-group">
                                                    <button type="submit" name="save" class="k-button"><i class="icon-cog"></i> Save Unlock Service </button>
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
                                    <h5><i class="icon-list-alt"></i>Unlock Service List</h5>
                                        <ul class="icons">
                                            <li><a data-original-title="Tooltip on left" data-placement="left" href="customer.php" class="hovertip" title="Add New Customer"><i class="icon-plus"></i></a></li>
                                            <li><a data-original-title="Tooltip on left" data-placement="left" href="<?php echo $obj->filename(); ?>" class="hovertip" title="FAQ?"><i class="icon-fire"></i></a></li>
                                            <li><a data-original-title="Tooltip on right" data-placement="right" href="<?php echo $obj->filename(); ?>" class="hovertip" title="Reload Data"><i class="icon-refresh"></i></a></li>
                                        </ul>
                                </div>
                            </div>
                            <div class="table-overflow">
                                
                                
                             <div id="grid" style="margin-left: 10px;margin-right: 10px;"></div>

                                        
                                            <script id="action_template" type="text/x-kendo-template">
                                                <a class="k-button k-button-icontext k-grid-delete" href="unlock_service.php?edit=#=id#"><i class="icon-edit"></i> Edit</a> 
                                                <a class="k-button k-button-icontext k-grid-delete" onclick="javascript:deleteClick(#=id#);" ><span class="k-icon k-delete"></span> Delete</a>
                                            </script>
                                            <script type="text/javascript">
                                                function deleteClick(id) {
                                                var c = confirm("Do you want to delete?");
                                                        if (c === true) {
                                                $.ajax({
                                                type: "POST",
                                                        dataType: "json",
                                                        url: "./controller/unlock_service.php",
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
                                                url: "./controller/unlock_service.php",
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
                                                                        price: {type: "string"},
                                                                        delivery_time: {type: "string"}
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
                                                        {field: "id", title: "#", width: "20px", filterable: false},
                                                        {field: "name", title: "Unlock Service", width: "160px"},
                                                        {field: "price", title: "Price", width: "30px"},
                                                        {field: "delivery_time", title: "Delivery Time", width: "40px"},
                                                        {
                                                        title: "Action", width: "50px",
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
                                            <th>Unlock Service</th>
                                            <th>Price</th>
                                            <th>Delivery Time</th>
                                            <th width="140">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
										$sql_checkin=$obj->SelectAll($table);
										$i=1;
										if(!empty($sql_checkin))
										foreach($sql_checkin as $checkin): ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $checkin->name; ?></td>
                                            <td>$<?php echo $checkin->price; ?></td>
                                            <td><?php echo $checkin->delivery_time; ?></td>
                                            <td>
                                                <a href="<?php echo $obj->filename(); ?>?edit=<?php echo $checkin->id; ?>" class="btn btn-primary hovertip" title="Edit Detail"><i class="icon-edit"></i></a> 
                                                <a href="<?php echo $obj->filename(); ?>?del=<?php echo $checkin->id; ?>" class="btn btn-danger hovertip" title="Delete"><i class="icon-remove"></i></a>
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
