<?php 
include('class/auth.php');
if($input_status==3 || $input_status==4)
{
	$obj->Error("Invalid Page Request.","index.php");
}
$table3="checkin";
$table2="checkin_version";
$table="checkin_version_color";

if(@$_GET['del'])
{
	if($input_status==1)
	{
		$obj->deletesing("id",$_GET['del'],$table);
	}
	else
	{
		$obj->delete("store_checkin_version_color",array("sid"=>$_GET['sid']));
		$owner_id=$obj->SelectAllByVal($table,"id",$_GET['del'],"store_id");
		if($owner_id==$input_by)
		{
			$obj->deletesing("id",$_GET['del'],$table);
		}
	}
}

if(isset($_POST['save']))
{
	extract($_POST);
	if(!empty($name) && !empty($checkin))
	{
		if($input_status==1)
		{
			if($obj->exists_multiple($table,array("store_id"=>$input_by,"name"=>$name,"checkin_id"=>$checkin,"checkin_version_id"=>$checkin_version))==0)
			{
				if($obj->insert($table,array("store_id"=>$input_by,"name"=>$name,"checkin_id"=>$checkin,"checkin_version_id"=>$checkin_version,"date"=>date('Y-m-d'),"status"=>1))==1)
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
			if($obj->exists_multiple("checkin_version_color_store",array("store_id"=>$input_by,"name"=>$name,"checkin_id"=>$checkin,"checkin_version_id"=>$checkin_version))==0)
			{
				if($obj->insert($table,array("store_id"=>$input_by,"name"=>$name,"checkin_id"=>$checkin,"checkin_version_id"=>$checkin_version,"date"=>date('Y-m-d'),"status"=>1))==1)
				{
					$new_version_color_id=$obj->SelectAllByVal4($table,"name",$name,"store_id",$input_by,"checkin_id",$checkin,"checkin_version_id",$checkin_version,"id");
					$obj->insert("store_checkin_version_color",array("id"=>$new_version_color_id,"store_id"=>$input_by,"date"=>date('Y-m-d'),"status"=>1));
					
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
			
			if($obj->update($table,array("id"=>$id,"store_id"=>$input_by,"name"=>$name,"checkin_id"=>$checkin,"checkin_version_id"=>$checkin_version,"date"=>date('Y-m-d'),"status"=>1))==1)
			{
				$obj->Success($name." is Changed Successfully.",$obj->filename());	
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
        <script>
            function version(str)
            {
                if (str == "")
                {
                    document.getElementById("checkin_version").innerHTML = "";
                    return;
                }
                if (window.XMLHttpRequest)
                {// code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp = new XMLHttpRequest();
                }
                else
                {// code for IE6, IE5
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function()
                {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
                    {
                        document.getElementById("checkin_version").innerHTML = xmlhttp.responseText;
                    }
                }
                xmlhttp.open("GET", "ajax/version.php?v="+str, true);
                xmlhttp.send();
            }
        </script>
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
                            <h5><i class="font-cogs"></i> Check In Version Color Setting </h5>
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
                                                    <label class="span12"> Name / Title </label>
	<input class="span6 k-textbox" value="<?php echo $obj->SelectAllByVal($table,"id",$_GET['edit'],"name"); ?>" type="text" name="name" />
    <input type="hidden" value="<?php echo $_GET['edit']; ?>" name="id">
                                                </div>
                                                
                                                <div class="control-group">
                                                    <label class="span12"> Checkin Version </label>
                                                    <select name="checkin_version" tabindex="2" style="width: 200px;">
                                                        <option value=""></option> 
                                                        <?php
														$chkidv=$obj->SelectAllByVal($table,"id",$_GET['edit'],"checkin_version_id");
														if($input_status==1){
														$sql_checkin_version=$obj->SelectAll($table2);
														}else{
														$sql_checkin_version=$obj->SelectAllByID("checkin_store",array("store_id"=>$input_by));	
														}
														if(!empty($sql_checkin_version))
														foreach($sql_checkin_version as $checkin_version): 
														?>
                                                        <option <?php if($chkidv==$checkin_version->id){ ?> selected  <?php } ?> value="<?php echo $checkin_version->id; ?>"><?php echo $checkin_version->name; ?></option> 
                                                        <?php endforeach; ?>
                                                   </select>
                                                </div>
                                                
                                                
                                                <div class="control-group">
                                                    <label class="span12"> Checkin </label>
                                                    <select name="checkin" tabindex="2" style="width: 200px;">
                                                        <option value=""></option> 
                                                        <?php
														$chkid=$obj->SelectAllByVal($table,"id",$_GET['edit'],"checkin_id");
														if($input_status==1){
														$sql_checkin=$obj->SelectAll($table3);
														}else{
														$sql_checkin=$obj->SelectAllByID("checkin_version_store",array("store_id"=>$input_by));	
														}
														if(!empty($sql_checkin))
														foreach($sql_checkin as $checkin): 
														?>
                                                        <option <?php if($chkid==$checkin->id){ ?> selected  <?php } ?> value="<?php echo $checkin->id; ?>"><?php echo $checkin->name; ?></option> 
                                                        <?php endforeach; ?>
                                                   </select>
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
                                                    <label class="span12"> Name / Title </label>
                                                        <input class="span6 k-textbox" placeholder="Put Your CheckIn Title" type="text" name="name" />
                                                </div>
                                                

                                                
                                                <div class="control-group">
                                                    <label class="span12"> Choose Checkin </label>
                                                    <select onChange="version(this.value)" name="checkin"  tabindex="2" style="width: 200px;">
                                                        <option value=""></option> 
                                                        <?php
														if($input_status==1){
														$sql_checkin=$obj->SelectAll($table3);
														}else{
														$sql_checkin=$obj->SelectAllByID("checkin_store",array("store_id"=>$input_by));	
														}
														if(!empty($sql_checkin))
														foreach($sql_checkin as $checkin): 
														?>
                                                        <option  value="<?php echo $checkin->id; ?>"><?php echo $checkin->name; ?></option> 
                                                        <?php endforeach; ?>
                                                   </select>
                                                </div>
                                                
                                                
                                                <div class="control-group">
                                                    <label class="span12"> Choose Checkin Version </label>
                                                    <select name="checkin_version"  id="checkin_version" tabindex="2" style="width: 200px;">
                                                        <option value=""></option> 
                                                   </select>
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
<!--                        	<div class="navbar">
                            	<div class="navbar-inner">
                                    <h5><i class="icon-list-alt"></i>CheckIn Version Color List</h5>
                                        <ul class="icons">
                                            <li><a data-original-title="Tooltip on left" data-placement="left" href="customer.php" class="hovertip" title="Add New Customer"><i class="icon-plus"></i></a></li>
                                            <li><a data-original-title="Tooltip on left" data-placement="left" href="<?php //echo $obj->filename(); ?>" class="hovertip" title="FAQ?"><i class="icon-fire"></i></a></li>
                                            <li><a data-original-title="Tooltip on right" data-placement="right" href="<?php //echo $obj->filename(); ?>" class="hovertip" title="Reload Data"><i class="icon-refresh"></i></a></li>
                                        </ul>
                                </div>
                            </div>-->
                            <div class="table-overflow">
                              
                                 <div id="grid" style="margin-left: 10px;margin-right: 10px;"></div>

                                        <script id="action_template" type="text/x-kendo-template">
                                            <a class="k-button k-button-icontext k-grid-delete" href="checkin_name_version_color_setting.php?edit=#=id#"><i class="icon-edit"></i> Edit</a> 
                                            <a class="k-button k-button-icontext k-grid-delete" onclick="javascript:deleteClick(#=id #);" ><span class="k-icon k-delete"></span> Delete</a>
                                        </script>
                                        <script type="text/javascript">
                                            function deleteClick(id) {
                                                var c = confirm("Do you want to delete?");
                                                if (c === true) {
                                                    $.ajax({
                                                        type: "POST",
                                                        dataType: "json",
                                                        url: "./controller/checkin_name_version_color_setting.php",
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
                                                            url: "./controller/checkin_name_version_color_setting.php",
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
                                                                checkin_version_id: {type: "number"},
                                                                checkin_version: {type: "string"},
                                                                checkin_name: {type: "string"},
                                                                checkin: {type: "string"},
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
                                                        {field: "checkin_version_id", title: "Checkin Version ID", filterable: false},
                                                        {field: "checkin_version", title: "Checkin Version"},
                                                        {field: "checkin_name", title: "Checkin Name"},
                                                        {field: "checkin", title: "Checkin"},
                                                        {field: "date", title: "Created"},
                                                        {
                                                            title: "Action", width: "180px",
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
                                            <th>CheckIn Version-ID</th>
                                            <th>CheckIn Name</th>
                                            <th>CheckIn Version</th>
                                            <th>CheckIn</th>
                                            <?php if($input_status==1){ ?>
                                            <th>Added By</th>
                                            <?php } ?>
                                            <th width="140">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
										if($input_status==1){
											//$sql_checkin_version_color=$obj->SelectAll($table);
											$sql_checkin_version_color=$obj->SelectAllByID($table,array("store_id"=>$input_by));
										}
										elseif($input_status==5)
										{
												$sqlchain_store_ids=$obj->SelectAllByID("store_chain_admin",array("sid"=>$input_by));
												if(!empty($sqlchain_store_ids))
												$array_ch = array();
												foreach($sqlchain_store_ids as $ch):
													array_push($array_ch,$ch->store_id);
												endforeach;
												
												include('class/report_chain_admin.php');	
												$obj_report_chain = new chain_report();
												$sql_checkin_version_color=$obj_report_chain->SelectAllByID_Multiple_Or("checkin_version_color_store",$array_ch,"store_id","1");
										}
										else{
											$sql_checkin_version_color=$obj->SelectAllByID("checkin_version_color_store",array("store_id"=>$input_by));	
										}
										$i=1;
										if(!empty($sql_checkin_version_color))
										foreach($sql_checkin_version_color as $checkin_version_color): ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $checkin_version_color->id; ?></td>
                                            <td><?php echo $checkin_version_color->name; ?></td>
        <td><?php echo $obj->SelectAllByVal($table2,"id",$checkin_version_color->checkin_version_id,"name"); ?></td>
        <td><?php echo $obj->SelectAllByVal($table3,"id",$checkin_version_color->checkin_id,"name"); ?></td>
                                            <?php if($input_status==1){ ?>
                                            <td><?php $owner_status=$obj->SelectAllByVal("store","id",$checkin->store_id,"status");
											if($owner_status==1)
											{
												echo "Super Admin";	
											}
											elseif($owner_status==5)
											{
												echo "Store Chain Admin";	
											}
											else
											{
												echo "Shop Admin";	
											}
											 ?></td>
                                            <?php } ?>
                                            <td>
                                                <a href="<?php echo $obj->filename(); ?>?edit=<?php echo $checkin_version_color->id; ?>" class="btn btn-primary hovertip" title="Edit Detail"><i class="icon-edit"></i></a> 
                                                <?php if($input_status==1 || $input_status==5){ ?>
                                                <a href="<?php echo $obj->filename(); ?>?del=<?php echo $checkin_version_color->id; ?>" class="btn btn-danger hovertip" title="Delete"><i class="icon-remove"></i></a>
                                            	<?php }else{ ?>
                                                <a href="<?php echo $obj->filename(); ?>?del=<?php echo $checkin_version_color->id; ?>&amp;sid=<?php echo $checkin_version_color->sid; ?>" class="btn btn-danger hovertip" title="Delete"><i class="icon-remove"></i></a>
                                            	<?php } ?>
                                            </td>
                                        </tr>
                                        <?php 
										$i++;
										endforeach; ?>
                                    </tbody>
                                </table> */ ?>
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
            
            
            <script>
                nucleus("select[name='checkin']").kendoDropDownList({
                    optionLabel: " Please Select Checkin  "
                }).data("kendoDropDownList").select(0);
                
                
                nucleus("select[name='checkin_version']").kendoDropDownList({
                    optionLabel: " Please Select Checkin Version  "
                }).data("kendoDropDownList").select(0);
                
            </script>
            
            
            <?php //include('include/footer.php'); ?>
            <!-- Right sidebar -->
            <?php //include('include/sidebar_right.php');  ?>
            <!-- /right sidebar -->

        </div>
        <!-- /main wrapper -->

    </body>
</html>
