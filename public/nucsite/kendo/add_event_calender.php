<?php
include('class/auth.php');
$table="calender_event";
if(isset($_POST['create']))
{
	extract($_POST);
	if(!empty($code))
	{
		if($obj->insert($table,array("store_id"=>$input_by,"name"=>$code,"detail"=>$detail,"start_date"=>$start_date,"end_date"=>$end_date,"start_time"=>$start_time,"end_time"=>$end_time,"email"=>$email,"date"=>date('Y-m-d'),"status"=>1))==1)
		{
			$obj->Success("Successfully Saved", $obj->filename());
		}
		else
		{
			$obj->Error("Something is wrong, Try again.", $obj->filename());
		}
	}
	else
	{
		$obj->Error("Failed, Fill up required field", $obj->filename());
	}
}

if(isset($_POST['editcreate']))
{
	extract($_POST);
	if(!empty($code))
	{
		if($obj->update($table,array("id"=>$id,"store_id"=>$input_by,"name"=>$code,"detail"=>$detail,"start_date"=>$start_date,"end_date"=>$end_date,"start_time"=>$start_time,"end_time"=>$end_time,"email"=>$email,"date"=>date('Y-m-d'),"status"=>1))==1)
		{
			$obj->Success("Successfully Saved", $obj->filename());
		}
		else
		{
			$obj->Error("Something is wrong, Try again.", $obj->filename());
		}
	}
	else
	{
		$obj->Error("Failed, Fill up required field", $obj->filename());
	}
}


if(isset($_GET['del']))
{
	$obj->deletesing("id",$_GET['del'],$table);	
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
                            <h5><i class="font-barcode"></i>  Add Event / Schedule in Your Calender </h5>
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

                                <!-- /middle navigation standard -->

                            <!-- Content container -->
          

                                <!-- Content Start from here customized -->
                                

                                <form class="form-horizontal" method="post" name="invoice" action="<?php echo $obj->filename(); ?>">
                                    <fieldset>
                                        <!-- General form elements -->
                                        <div class="row-fluid  span12 well">     
                                           <!-- Selects, dropdowns -->
                                           <?php  
										   if(isset($_GET['edit'])){
										   ?>
                                            <div class="span6" style="padding:0px; margin:0px;">
                                                <div class="control-group">
                                                    <label  class="control-label"> * Event Name :</label>
                                                    <div class="controls">
                                                        <input class="k-textbox" style="width: 200px;" value="<?php echo $obj->SelectAllByVal($table,"id",$_GET['edit'],"name"); ?>" type="text" name="code" />
                                                        <input value="<?php echo $_GET['edit']; ?>" type="hidden" name="id" />
                                                    </div>
                                                </div>
                                                
                                                <div class="control-group">
                                                    <label  class="control-label"> Events Detail :</label>
                                                    <div class="controls">
                                                        <input class="k-textbox" style="width: 200px;" value="<?php echo $obj->SelectAllByVal($table,"id",$_GET['edit'],"detail"); ?>" type="text" name="detail" />
                                                   </div>
                                                </div>
                                                
                                                <div class="control-group">
                                                    <label  class="control-label"> Start Date :</label>
                                                    <div class="controls">
                                                    	<input  class="datepicker" readonly value="<?php echo $obj->SelectAllByVal($table,"id",$_GET['edit'],"start_date"); ?>" type="text" name="start_date" />
                                                    </div>
                                                </div>
                                                
                                                <div class="control-group">
                                                    <label class="control-label"> Start Time :</label>
                                                   <div class="controls">
                                                        <ul class="dates-range">
                                                            <li><input id="timeformatExample1" class="k-textbox" type="text" value="<?php echo $obj->SelectAllByVal($table,"id",$_GET['edit'],"start_time"); ?>" name="start_time" /></li>
                                                        </ul>
                                            		</div>
                                                </div>
                                                
                                              </div>
                                              <div class="span6" style="padding:0px; margin:0px;">  
                                                
                                                
                                                
                                                <div class="control-group">
                                                    <label  class="control-label"> End Date :</label>
                                                    <div class="controls">
                                                    	<input class="datepicker" type="text" readonly value="<?php echo $obj->SelectAllByVal($table,"id",$_GET['edit'],"end_date"); ?>" name="end_date" />
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label"> End Time :</label>
                                                   <div class="controls">
                                                        <ul class="dates-range">
                                                            <li><input id="timeformatExample11" class="k-textbox" type="text" value="<?php echo $obj->SelectAllByVal($table,"id",$_GET['edit'],"end_time"); ?>" name="end_time" /></li>
                                                        </ul>
                                            		</div>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label"> Email :</label>
                                                   <div class="controls">
                                                        <ul class="dates-range">
                                                            <li><input style="width: 200px;" class="span6 k-textbox" type="text" value="<?php echo $obj->SelectAllByVal($table,"id",$_GET['edit'],"email"); ?>" name="email" /></li>
                                                        </ul>
                                            		</div>
                                                </div>
                                                
                                                <div class="control-group">
                                                    <button type="submit" name="editcreate" class="k-button"><i class="icon-plus-sign"></i> Change Updates </button>
                                                </div>
                                                
                                            </div>
                                            <?php }else{ ?>
                                            <div class="span6" style="padding:0px; margin:0px;">
                                                <div class="control-group">
                                                    <label  class="control-label"> * Event Name :</label>
                                                    <div class="controls">
                                                        <input class="k-textbox" type="text" name="code" />
                                                    </div>
                                                </div>
                                                
                                                <div class="control-group">
                                                    <label  class="control-label">  Events Detail :</label>
                                                    <div class="controls">
                                                   		<input  class="k-textbox" type="text" name="detail" />
                                                   </div>
                                                </div>
                                                
                                                <div class="control-group">
                                                    <label  class="control-label">  Start Date :</label>
                                                    <div class="controls">
                                                    	<input  class="k-datepicker" readonly value="<?php echo date('Y-m-d'); ?>" type="text" name="start_date" />
                                                    </div>
                                                </div>
                                                 <div class="control-group">
                                                    <label class="control-label">  Start Time :</label>
                                                   <div class="controls">
                                                        <ul class="dates-range">
                                                            <li><input id="timeformatExample1" class="k-textbox" type="text" name="start_time" /></li>
                                                        </ul>
                                            		</div>
                                                </div>
                                                
                                                
                                              </div>
                                              <div class="span6" style="padding:0px; margin:0px;">  
                                                
                                               
                                                
                                                <div class="control-group">
                                                    <label  class="control-label">  End Date :</label>
                                                    <div class="controls">
                                                    	<input class="k-datepicker" type="text" readonly value="<?php echo date('Y-m-d'); ?>" name="end_date" />
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label">  End Time :</label>
                                                   <div class="controls">
                                                        <ul class="dates-range">
                                                            <li><input id="timeformatExample11" class="k-textbox" type="text" name="end_time" /></li>
                                                        </ul>
                                            		</div>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label"> Email :</label>
                                                   <div class="controls">
                                                        <ul class="dates-range">
                                                            <li><input style="width: 200px;" class="span6 k-textbox" type="text" placeholder="Please provide your email to remind you" name="email" /></li>
                                                        </ul>
                                            		</div>
                                                </div>
                                                <div class="control-group">
                                                    <button type="submit" name="create" class="k-button"><i class="icon-plus-sign"></i> Save </button>
                                                </div>
                                                
                                            </div>
                                            <?php } ?>
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
								
                                <div class="block well">
                        	<div class="navbar">
                            	<div class="navbar-inner">
                                    <h5><i class="icon-list-alt"></i>Event / Schedule</h5>
                                        <ul class="icons">
                                            <li><a data-original-title="Tooltip on right" data-placement="right" href="<?php echo $obj->filename(); ?>" class="hovertip" title="Reload Data"><i class="icon-refresh"></i></a></li>
                                        </ul>
                                </div>
                            </div>
                            <div class="table-overflow">
                                
                                
                                <div id="grid" style="margin-left: 10px;margin-right: 10px;"></div>

                                        <?php
                                        $cond = $cms->FrontEndDateSearch('from', 'to');
                                        ?>
                                        <script id="action_template" type="text/x-kendo-template">
                                            <a class="k-button k-button-icontext k-grid-delete" href="add_event_calender.php?edit=#=id#"><i class="icon-edit"></i> Edit</a> 
                                            <a class="k-button k-button-icontext k-grid-delete" onclick="javascript:deleteClick(#=id#);" ><span class="k-icon k-delete"></span> Delete</a>
                                        </script>
                                        <script type="text/javascript">
                                            function deleteClick(id) {
                                                var c = confirm("Do you want to delete?");
                                                if (c === true) {
                                                    $.ajax({
                                                        type: "POST",
                                                        dataType: "json",
                                                        url: "./controller/add_event_calender.php",
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
                                                            url: "./controller/add_event_calender.php",
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
                                                                name: {type: "number"},
                                                                detail: {type: "string"},
                                                                startdate: {type: "string"},
                                                                enddate: {type: "string"}
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
                                                        {field: "name", title: "Title"},
                                                        {field: "detail", title: "Detail"},
                                                        {field: "startdate", title: "Start Date - Start Time", filterable: false},
                                                        {field: "enddate", title: "End Date - End Time"},
                                                        {
                                                            title: "Action", width: "80px",
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
                                            <th>Title</th>
                                            <th>Detail</th>
                                            <th>Start Date - Start Time</th>
                                            <th>End Date - End Time</th>
                                            <th width="140">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
										if($input_status==1)
										{
											$sql_checkin=$obj->SelectAll($table);
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
												$sql_checkin=$obj_report_chain->SelectAllByID_Multiple_Or($table,$array_ch,"store_id","1");
											}
											else
											{
												//echo "Not Work";
												$sql_checkin="";
											}
										}
										else
										{
											$sql_checkin=$obj->SelectAllByID($table,array("store_id"=>$input_by));	
										}
										$i=1;
										if(!empty($sql_checkin))
										foreach($sql_checkin as $checkin): ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $checkin->name; ?></td>
                                            <td><?php echo $checkin->detail; ?></td>
                                            <td><?php echo $checkin->start_date." - ".$checkin->start_time; ?></td>
                                            <td><?php echo $checkin->end_date." - ".$checkin->end_time; ?></td>
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
                
                
                
                nucleus(".k-datepicker").kendoDatePicker({
                    format: "yyyy/MM/dd",
                    animation: false
                  });
                  
               
            </script>
            
            
            
<?php //include('include/footer.php'); ?>
            <!-- Right sidebar -->
<?php //include('include/sidebar_right.php');  ?>
            <!-- /right sidebar -->

        </div>
        <!-- /main wrapper -->

    </body>
</html>
