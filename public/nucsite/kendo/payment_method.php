<?php 
include('class/auth.php');
if($input_status!=1)
{
	$obj->Error("Invalid Page Request.","index.php");
}
$table="payment_method";
if(isset($_GET['del']))
{
	$obj->deletesing("id",$_GET['del'],$table);	
}

if(isset($_POST['create']))
{
	extract($_POST);
	if(!empty($meth_name))
	{
		if($obj->insert($table,array("meth_name"=>$meth_name, "date"=>date('Y-m-d'), "status"=>1))==1)
		{
			$obj->Success("successfully Saved.", $obj->filename());
		}
		else
		{
			$obj->Error("Something is wrong, Try again.", $obj->filename());
		}
	}
	else
	{
		$obj->Error("Failed, Fill up required field.", $obj->filename());
	}
}

if(isset($_POST['updates']))
{
	extract($_POST);
	if(!empty($meth_name))
	{
		if($obj->update($table,array("id"=>$id,"meth_name"=>$meth_name, "date"=>date('Y-m-d'), "status"=>1))==1)
		{
			$obj->Success("successfully Saved.", $obj->filename());
		}
		else
		{
			$obj->Error("Something is wrong, Try again.", $obj->filename());
		}
	}
	else
	{
		$obj->Error("Failed, Fill up required field.", $obj->filename());
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
                            <h5><i class="font-cogs"></i> Payment Method </h5>
                            <ul class="icons">
                                <li><a href="<?php echo $obj->filename(); ?>" class="hovertip" title="Reload"><i class="font-refresh"></i></a></li>
                            </ul>
                        </div><!-- /page header -->

                        <div class="body">

                            <!-- Middle navigation standard -->
                            <?php //include('include/quicklink.php');  ?>
                            <!-- /middle navigation standard -->

                            <!-- Content container -->
                            <div class="container">




                                <!-- Content Start from here customized -->


                                <form class="form-horizontal" method="post" name="invoice" action="">
                                    <fieldset>
                                        <!-- General form elements -->
                                        <div class="row-fluid  span12 well">     
                                            <!-- Selects, dropdowns -->
                                            <?php  
											if(isset($_GET['edit']))
											{
												?>
                                               
                                                <div class="span6" style="padding:0px; margin:0px;">
                                                <div class="control-group">
                                                    <h3>Update Detail</h3>
                                                </div>
                                                <div class="control-group">
                                                    <label class="span12"> * Method Name </label>
                                                    <input class="span10 k-textbox" type="text" name="meth_name" value="<?php echo $obj->SelectAllByVal($table,"id",$_GET['edit'],"meth_name"); ?>" />
                                                    <input class="span10" type="hidden"  value="<?php echo $_GET['edit']; ?>" name="id" />
                                                </div>


                                                <div class="control-group">
                                                    <button type="submit" name="updates" class="k-button"><i class="icon-cog"></i> Change Method Name </button>
                                                </div>



                                            </div>
                                            <!-- /selects, dropdowns -->
                                                <?php
											}
											else
											{
											
											?>
                                            <div class="span6" style="padding:0px; margin:0px;">
                                                <div class="control-group">
                                                    <label class="span12"> * Method Name </label>
                                                    <input class="span10 k-textbox" type="text" name="meth_name" />
                                                </div>


                                                <div class="control-group">
                                                    <button type="submit" name="create" class="k-button"><i class="icon-cog"></i> Save Method </button>
                                                </div>



                                            </div>
                                            <!-- /selects, dropdowns -->

											<?php } ?>

                                            <!-- Selects, dropdowns -->
                                            <div class="span6" style="padding:0px; margin:0px; float:right;">
                                                <div class="table-overflow">
                                                    
                                                    <div id="grid" style="margin-left: 10px;margin-right: 10px;"></div>
                                                    <script id="action_template" type="text/x-kendo-template">
                                                        <a class="k-button k-button-icontext k-grid-delete" href="payment_method.php?edit=#=id#"><i class="icon-edit"></i> Edit</a> 
                                                        <a class="k-button k-button-icontext k-grid-delete" onclick="javascript:deleteClick(#=id#);" ><span class="k-icon k-delete"></span> Delete</a>
                                                    </script>

                                                    <script id="status_template" type="text/x-kendo-template">
                                                                 #if(id==1){
                                                                     #Active#
                                                                 }else{
                                                                     #Active#
                                                                 }#
                                                    </script>
                                                    <script type="text/javascript">
                                                        function deleteClick(id) {
                                                            var c = confirm("Do you want to delete?");
                                                            if (c === true) {
                                                                $.ajax({
                                                                    type: "POST",
                                                                    dataType: "json",
                                                                    url: "./controller/payment_method.php",
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
                                                                        url: "./controller/payment_method.php",
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
                                                                            meth_name: {type: "string"},
                                                                            status: {type: "string"}
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
                                                                    {field: "meth_name", title: "Method Name ", width: "80px"},
                                                                    {
                                                                        title: "Status", width: "50px",
                                                                        template: kendo.template($("#status_template").html())
                                                                    },
                                                                    {
                                                                        title: "Action", width: "130px",
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
                                                                <th> Method Name </th>
                                                                <th> Status </th>
                                                                <th width="60">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php 
															$sql_payment_method=$obj->SelectAll($table);
															$i=1;
															if(!empty($sql_payment_method))
															foreach ($sql_payment_method as $row): 
															?>
                                                                <tr>
                                                                    <td><?php echo $i; ?></td>
                                                                    <td><?php echo $row->meth_name; ?> </td>
                                                                    <td> Active </td>
                                                                    <td>
                                                                    	<a href="<?php echo $obj->filename(); ?>?edit=<?php echo $row->id; ?>" class="hovertip"  onclick="javascript:return confirm('Are you absolutely sure to Edit This?')"  title="Delete"><i class="icon-edit"></i></a>
                                                                        <a href="<?php echo $obj->filename(); ?>?del=<?php echo $row->id; ?>"  onclick="javascript:return confirm('Are you absolutely sure to delete This?')"  class=" hovertip" title="Delete"><i class="icon-remove"></i></a>
                                                                    </td>
                                                                </tr>
                                                            <?php 
															$i++;
															endforeach; 
															?>
                                                        </tbody>
                                                    </table>*/?>
                                                </div>
                                            </div>
                                            <!-- /selects, dropdowns -->



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
            <?php //include('include/sidebar_right.php');  ?>
            <!-- /right sidebar -->

        </div>
        <!-- /main wrapper -->

    </body>
</html>
