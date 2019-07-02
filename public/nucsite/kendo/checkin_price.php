<?php 
include('class/auth.php');
if($input_status==3 || $input_status==4)
{
	$obj->Error("Invalid Page Request.","index.php");
}
$table2 = "checkin";
$table = "checkin_price";
$tables = "checkin_version";

if (@$_GET['del']) 
{
	if($input_status==1)
	{
		if ($obj->delete($table, array("barcode" =>$_GET['barcode']))) {
			$obj->deletesing("barcode",$_GET['barcode'],"product");
		} else {
			$obj->Error("Failed to Delete", $obj->filename());
		}
	}
	else
	{
		$owner_id=$obj->SelectAllByVal($table,"id",$_GET['del'],"store_id");
		if($owner_id==$input_by)
		{
			if ($obj->delete($table, array("id" =>$_GET['del']))) {
				$product_id_2=$obj->SelectAllByVal2("product","barcode",$_GET['barcode'],"store_id",$input_by,"id");
				
				if($obj->delete("product", array("id" =>$product_id_2))==1)
				{
					$obj->Success("Successfully Deleted", $obj->filename());
				}
				else
				{
					$obj->Error("Failed to Delete", $obj->filename());
				}
			} else {
				$obj->Error("Failed to Delete", $obj->filename());
			}
		}
		else
		{
			$obj->Error("You are not authorized to Delete", $obj->filename());
		}
	}
}

$barcode=time();

if (isset($_POST['save'])) {
    extract($_POST);
    if (!empty($name) && !empty($checkin_id)) {
        if ($obj->exists_multiple($table, array("store_id" =>$input_by,"checkin_id" => $checkin_id, "checkin_problem_id" => $checkin_problem_id,"checkin_version_id"=>$checkin_version_id)) == 0) {
			
            if ($obj->insert($table, array("store_id" =>$input_by,"name" => $name, "checkin_id" => $checkin_id, "checkin_problem_id" => $checkin_problem_id,"checkin_version_id"=>$checkin_version_id,"barcode"=>$barcode, "date" => date('Y-m-d'), "status" => 1)) == 1) 
			{
				$prname = $obj->SelectAllByVal($table2,"id",$checkin_id,"name").", ".$obj->SelectAllByVal($tables,"id",$checkin_version_id,"name")." - ".$obj->SelectAllByVal("checkin_problem","id",$checkin_problem_id,"name");
           		if ($obj->insert("product", array("input_by" =>$input_by,"name" => $prname,"description"=>"Product Added From Checkin","barcode"=>$barcode,"price_cost"=>$name,"price_retail"=>$name,"maintain_stock"=>0,"quantity"=>1,"warranty"=>3,"reorder"=>1,"date"=>date('Y-m-d'),"status"=>3))==1) 
				{ 
					$obj->Success("Saved Price Successfully.", $obj->filename()); 
				} 
				else 
				{ 
					$obj->Error("Failed, Sql Error..", $obj->filename()); 
				}
            } 
			else 
			{ $obj->Error("Failed, Sql Error..", $obj->filename()); }
        } 
		else 
		{ $obj->Error("Failed, Already Exists 3", $obj->filename()); }
    } 
	else 
	{ $obj->Error("Failed, Some field is Empty", $obj->filename()); }
}

if (isset($_POST['update'])) {
    extract($_POST);
    if (!empty($name)) {
		
        if ($obj->update($table, array("id" => $fid,"name" => $name)) == 1) 
		{
			$chks=$obj->exists_multiple("product",array("barcode"=>$barcode,"input_by"=>$input_by));
			if($chks!=0)
			{
				$pid=$obj->SelectAllByVal2("product","barcode",$barcode,"input_by",$input_by,"id");
				$obj->update("product",array("id"=>$pid,"price_cost"=>$name,"price_retail"=>$name));
				$obj->Success("Price is Updated Successfully.", $obj->filename());
			}
			else
			{
				$obj->Success("Price is Updated Successfully.", $obj->filename());
			}
			
        } else {
            $obj->Error("Failed, Sql Error", $obj->filename());
        }
    } else {
        $obj->Error("Failed, Some field is Empty", $obj->filename());
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
            function version(check_id)
            {
                if (check_id == "") {
                    document.getElementById("checkin_version_id").innerHTML = "";
                    return;
                }
				
                if (window.XMLHttpRequest) {
                    xmlhttp = new XMLHttpRequest();
                } else { 
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function() {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        $("#checkin_version_id").fadeOut();
                        $("#checkin_version_id").fadeIn();
                        //load checkin problem id
							xmlhttps = new XMLHttpRequest();
							xmlhttps.onreadystatechange = function() {
								if (xmlhttps.readyState == 4 && xmlhttps.status == 200) 
								{
									$("#checkin_problem_id").fadeOut();
									$("#checkin_problem_id").fadeIn();
									document.getElementById("checkin_problem_id").innerHTML = xmlhttps.responseText;
								}
							}
							st=2;
							xmlhttps.open("GET", "ajax/setversion.php?check_id="+check_id+"&st="+st,true);
							xmlhttps.send();
                        //checkin problem id
                        document.getElementById("checkin_version_id").innerHTML = xmlhttp.responseText;
                    }
                }
                st=1;
                xmlhttp.open("GET", "ajax/setversion.php?check_id="+check_id+"&st="+st,true);
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
                            <h5><i class="font-cogs"></i> Check In Price Setting </h5>
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


                                <form class="form-horizontal" method="post" enctype="multipart/form-data" name="invoice" action="">
                                <?php if(isset($_GET['edit'])){ ?>
                                    <fieldset>
                                        <!-- General form elements -->
                                        <div class="row-fluid  span6 well">     
                                            <!-- Selects, dropdowns -->

                                            <div class="control-group">
                                                <label class="span12"> Check In Price </label>
                                                <input value="<?php echo $obj->SelectAllByVal("checkin_price","barcode",$_GET['edit'],"name"); ?>" class="span2 k-textbox" type="number" name="name" />
                                                <input type="hidden" name="barcode" value="<?php echo $_GET['edit']; ?>">
                                                <input type="hidden" name="fid" value="<?php echo $_GET['fid']; ?>">
                                            </div>
											
                                            <div class="control-group">
                                                <button type="submit" name="update" class="k-button"><i class="icon-edit"></i> Update Detail </button>
                                            </div>
                                        </div>
                                        <!-- /selects, dropdowns -->


                                        <!-- /general form elements -->     


                                        <div class="clearfix"></div>

                                        <!-- Default datatable -->

                                        <!-- /default datatable -->


                                    </fieldset>                     
									<?php }else{ ?>
                                    <fieldset>
                                        <!-- General form elements -->
                                        <div class="row-fluid  span6 well">     
                                            <!-- Selects, dropdowns -->

                                            <div class="control-group">
                                                <label class="span12"> Check In Price </label>
                                                <input class="span4 k-textbox" style="width: 220px;" placeholder="Put Your CheckIn Device Problem Price" type="number" name="name" />
                                            </div>

                                            <div class="control-group">
                                                <label class="span12"> Checkin Type </label>
                                                <select name="checkin_id" onchange="version(this.value)" style="width: 200px;" tabindex="2">
                                                    <option value=""></option> 
                                                    <?php
														if($input_status==1)
														{
															$sql_checkin=$obj->SelectAll($table2);
														}
														else
														{
															$sql_checkin=$obj->SelectAllByID("checkin_store",array("store_id"=>$input_by));
														}														
                                                    	if (!empty($sql_checkin))
                                                        foreach ($sql_checkin as $checkin):
                                                            ?>
                                                            <option  value="<?php echo $checkin->id; ?>"><?php echo $checkin->name; ?></option> 
                                                        <?php endforeach; ?>
                                                </select>
                                            </div>


                                            <div class="control-group">
                                                <label class="span12"> Checkin Version </label>
                                                <select name="checkin_version_id"  id="checkin_version_id" style="width: 200px;" tabindex="2">
                                                    <option value=""></option> 
                                                </select>
                                            </div>


                                            <div class="control-group">
                                                <label class="span12"> Problem </label>
                                                <select name="checkin_problem_id" id="checkin_problem_id" style="width: 220px;" tabindex="2">
                                                    <option value=""></option> 
                                                </select>
                                            </div>


                                            <div class="control-group">
                                                <button type="submit" name="save" class="k-button"><i class="icon-cog"></i> Save Detail </button>
                                            </div>
                                        </div>
                                        <!-- /selects, dropdowns -->


                                        <!-- /general form elements -->     


                                        <div class="clearfix"></div>

                                        <!-- Default datatable -->

                                        <!-- /default datatable -->


                                    </fieldset> 
                                    <?php } ?>
                                </form>

                                <div class="block well">
                                    <div class="navbar">
                                        <div class="navbar-inner">
                                            <h5><i class="icon-list-alt"></i>CheckIn Price List</h5>

                                        </div>
                                    </div>
                                    <div class="table-overflow">
                                        
                                        <div id="grid" style="margin-left: 10px;margin-right: 10px;"></div>

                                        <script id="action_template" type="text/x-kendo-template">
                                            <a class="k-button k-button-icontext k-grid-delete" href="checkin_price.php?edit=#=id#"><i class="icon-edit"></i> Edit</a> 
                                            <a class="k-button k-button-icontext k-grid-delete" onclick="javascript:deleteClick(#=id #);" ><span class="k-icon k-delete"></span> Delete</a>
                                        </script>
                                        <script type="text/javascript">
                                            function deleteClick(id) {
                                                var c = confirm("Do you want to delete?");
                                                if (c === true) {
                                                    $.ajax({
                                                        type: "POST",
                                                        dataType: "json",
                                                        url: "./controller/checkin_price.php",
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
                                                            url: "./controller/checkin_price.php",
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
                                                                barcode: {type: "string"},
                                                                checkin_device: {type: "string"},
                                                                checkin_version: {type: "string"},
                                                                checkin_problem: {type: "string"},
                                                                checkin_price: {type: "string"},
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
                                                        {field: "barcode", title: "Barcode"},
                                                        {field: "checkin_device", title: "Checkin Device"},
                                                        {field: "checkin_version", title: "Checkin Version"},
                                                        {field: "checkin_problem", title: "Checkin Problem"},
                                                        {field: "checkin_price", title: "Checkin Price"},
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
                                                    <th>Barcode</th>
                                                    <th>CheckIn Device</th>
                                                    <th>CheckIn Version</th>
                                                    <th>CheckIn Problem</th>
                                                    <th>CheckIn Price</th>
                                                    <th>Generated</th>
                                                    <?php if($input_status==1){ ?>
                                                    <th>Added By</th>
                                                    <?php } ?>
                                                    <th width="140">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
												if($input_status==1)
												{
                                                	//$sql_checkin_version = $obj->SelectAll("checkin_price");
													$sql_checkin_version=$obj->SelectAllByID($table,array("store_id"=>$input_by));
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
														$sql_checkin_version=$obj_report_chain->SelectAllByID_Multiple_Or("checkin_price",$array_ch,"store_id","1");
												}
												else
												{
													$sql_checkin_version = $obj->SelectAllByID_Multiple("checkin_price",array("store_id"=>$input_by));	
												}
                                                $i = 1;
                                                if (!empty($sql_checkin_version))
                                                    foreach ($sql_checkin_version as $checkin_version):
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $i; ?></td>
                                                            <td><?php echo $checkin_version->barcode; ?></td>
                                                            <td><?php $dev = $obj->SelectAllByVal($table2, "id", $checkin_version->checkin_id, "name");  echo $dev; ?></td>
                                                            <td><?php $ver = $obj->SelectAllByVal("checkin_version", "id", $checkin_version->checkin_version_id, "name"); echo $ver; ?></td>
                                                            <td><?php $pro = $obj->SelectAllByVal("checkin_problem", "id", $checkin_version->checkin_problem_id, "name"); echo $pro; ?></td>
                                                            
                                                            <td>$<?php echo $checkin_version->name; ?></td>
                                                            <td><?php echo $checkin_version->date; ?></td>
                                                            <?php if($input_status==1 || $input_status==5){ ?>
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
                                                                <?php
                                                                $pid = $obj->SelectAllByVal("product", "name", $dev . "-" . $pro, "id");
                                                                if ($input_status == 1 || $input_status==5) {
                                                                ?>
                                                                    <a href="<?php echo $obj->filename(); ?>?edit=<?php echo $checkin_version->barcode; ?>&amp;fid=<?php echo $checkin_version->id; ?>" class="btn btn-info hovertip" title="Delete"><i class="icon-edit"></i></a>
                                                                    <a href="<?php echo $obj->filename(); ?>?del=<?php echo $checkin_version->id; ?>&amp;pid=<?php echo $pid; ?>&amp;barcode=<?php echo $checkin_version->barcode; ?>" class="btn btn-danger hovertip" title="Delete"><i class="icon-remove"></i></a>
                                                                <?php }elseif ($input_status == 2) {
                                                                ?>
                                                                    <a href="<?php echo $obj->filename(); ?>?edit=<?php echo $checkin_version->barcode; ?>&amp;fid=<?php echo $checkin_version->id; ?>" class="btn btn-info hovertip" title="Delete"><i class="icon-edit"></i></a>
                                                                    <a href="<?php echo $obj->filename(); ?>?del=<?php echo $checkin_version->id; ?>&amp;pid=<?php echo $pid; ?>&amp;barcode=<?php echo $checkin_version->barcode; ?>" class="btn btn-danger hovertip" title="Delete"><i class="icon-remove"></i></a>
                                                                <?php } ?>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                        $i++;
                                                    endforeach;
                                                ?>
                                            </tbody>
                                        </table> */?>
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
                nucleus("select[name='checkin_id']").kendoDropDownList({
                    optionLabel: " Please Select Checkin  "
                }).data("kendoDropDownList").select(0);
                
                nucleus("select[name='checkin_version_id']").kendoDropDownList({
                    optionLabel: " Please Select Checkin Version  "
                }).data("kendoDropDownList").select(0);
                
                nucleus("select[name='checkin_problem_id']").kendoDropDownList({
                    optionLabel: " Please Select Checkin Problem  "
                }).data("kendoDropDownList").select(0);
            
            </script>
            
            <?php //include('include/footer.php'); ?>
            <!-- Right sidebar -->
<?php //include('include/sidebar_right.php');    ?>
            <!-- /right sidebar -->

        </div>
        <!-- /main wrapper -->

    </body>
</html>
