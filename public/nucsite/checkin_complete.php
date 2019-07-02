<?php include('class/auth.php');
include('class/checkin_class.php');	
$obj_checkin = new checkin_class();
$bbcode=time();
$table="checkin_problem"; 
$table2="checkin_network";
$table3="checkin_version_color";
$table4="checkin_version";
$table5="checkin";

include('class/pos_class.php');
$obj_pos = new pos();
$cashier_id=$obj_pos->cashier_id(@$_SESSION['SESS_CASHIER_ID']);
$cashiers_id=$obj_pos->cashier_actual_id(@$_SESSION['SESS_CASHIER_ID']);
if($cashier_id==0)
{
	$obj->Error("Cashier Not Logged IN. Please Login as a Cashier First","pos.php");	
}

if(isset($_POST['save']))
{
	extract($_POST);
	if(!empty($firstname) && !empty($lastname) && !empty($phone))
	{
		if($cid==0)
		{
			$obj->insert("coustomer",array("input_by"=>$input_by,"firstname"=>$firstname,"lastname"=>$lastname,"email"=>$email,"access_id"=>$access_id,"phone"=>$phone));
			if($obj->insert("checkin_request",array("checkin_id"=>$cart,"first_name"=>$firstname,"last_name"=>$lastname,"email"=>$email,"phone"=>$phone,"device_id"=>$device_id,"model_id"=>$model_id,"color_id"=>$color_id,"network_id"=>$network_id,"problem_id"=>$problem_id,"input_by"=>$input_by,"access_id"=>$access_id,"date"=>date('Y-m-d'),"status"=>0))==1)
			{
				$ccid=$obj->SelectAllByVal4("coustomer","store_id",$input_by,"firstname",$firstname,"lastname",$lastname,"email",$email,"id");
				$obj->Success("Customer Checkin Request Successfully Submitted.","finish_checkin.php?cid=".$ccid."&cart=".$cart);	
			}
			else
			{
				$obj->Error("Some field is Empty, Please fillup all.",$obj->filename()."?id=".$device_id."&version=".$model_id."&color=".$color_id."&network=".$network_id."&problem=".$problem_id);		
			}
		}
		else
		{
			if($obj->insert("checkin_request",array("checkin_id"=>$cart,"first_name"=>$firstname,"last_name"=>$lastname,"email"=>$email,"phone"=>$phone,"device_id"=>$device_id,"model_id"=>$model_id,"color_id"=>$color_id,"network_id"=>$network_id,"problem_id"=>$problem_id,"input_by"=>$input_by,"access_id"=>$access_id,"date"=>date('Y-m-d'),"status"=>0))==1)
			{
					$obj->Success("Customer Checkin Request Successfully Submitted.","finish_checkin.php?cid=".$cid."&cart=".$cart);	
			}
			else
			{
					$obj->Error("Some field is Empty, Please fillup all.",$obj->filename()."?id=".$device_id."&version=".$model_id."&color=".$color_id."&network=".$network_id."&problem=".$problem_id);		
			}
		}
	}
	else
	{
		$obj->Error("Some field is Empty, Please fillup all.",$obj->filename()."?id=".$device_id."&version=".$model_id."&color=".$color_id."&network=".$network_id."&problem=".$problem_id);	
	}
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php echo $obj->bodyhead(); ?>
        <script src="ajax/customer_ajax.js"></script>
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
                            <h5><i class="font-home"></i>Check In</h5>
                            <ul class="icons">
                                <li><a href="<?php echo $obj->filename(); ?>" class="hovertip" title="Reload"><i class="font-refresh"></i></a></li>
                            </ul>
                        </div><!-- /page header -->

                        <div class="body">

                            <!-- Middle navigation standard -->
                            <?php //include('include/quicklink.php'); ?>
                            <!-- /middle navigation standard -->

                            <!-- Content container -->
                            <div class="container">

                                <!-- Line chart -->
                                <div class="row-fluid">

                                    <div class="span12">
                                        <div class="semi-block">
                                            <div class="well-white body">
                                                <div class="table-overflow">
                                                    
                                                    <strong class="span1 label label-success" style="width:90px; padding-left:1px; padding-right:1px; margin-left:0; margin-right:0; display:inline-block;">Device : Step 1</strong> 
                                                    
                                                    <strong class="span1 label label-success"  style="width:90px; padding-left:1px; padding-right:1px; margin-left:3px; margin-right:0; display:inline-block;">Model : Step 2</strong>
                                                    <strong class="span1 label label-success"  style="width:90px; padding-left:1px; padding-right:1px; margin-left:3px; margin-right:0; display:inline-block;">Color : Step 3</strong>
                                                    <strong class="span1 label label-success"  style="width:98px; padding-left:1px; padding-right:1px; margin-left:3px; margin-right:0; display:inline-block;">Network : Step 4</strong>
                                                    <strong class="span1 label label-success"  style="width:98px; padding-left:1px; padding-right:1px; margin-left:3px; margin-right:0; display:inline-block;">Problem! : 5</strong>
                                                    <strong class="span1 label label-success"  style="width:60px; padding-left:1px; padding-right:1px; margin-left:3px; margin-right:0; display:inline-block;">Price : 6</strong>
                                                    <strong class="span1 label label-success"  style="width:98px; padding-left:1px; padding-right:1px; margin-left:3px; margin-right:0; display:inline-block;">Customer : 7</strong>
                                                    <strong class="span1"  style="width:60px; padding-left:1px; padding-right:1px; margin-left:3px; margin-right:0; display:inline-block;">Info : 8</strong>
                                                    
                                        <div  class="progress progress-success value"><div class="bar" data-percentage="7" data-amount-part="7" data-amount-total="8">5/8</div></div>
                                        
                                                    
                                        
                                                    
                           						 </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                
                                <div class="row-fluid">

                                    <div class="span12">
                                        <div class="semi-block">
                                            <div class="well-white body">
                                                    
                                                    <div class="separator"><span></span></div>
                                                    <h5 class="subtitle align-center"> Your Device : <?php echo $obj->SelectAllByVal($table5,"id",$_GET['id'],"name"); ?>,<?php echo $obj->SelectAllByVal($table4,"id",$_GET['version'],"name"); ?>, Color - <?php echo $obj->SelectAllByVal($table3,"id",$_GET['color'],"name"); ?>, Network - <?php echo $obj->SelectAllByVal($table2,"id",$_GET['network'],"name"); ?> , Problem - <?php echo $obj->SelectAllByVal($table,"id",$_GET['problem'],"name"); ?>  </h5>
                                                    <div class="separator"><span></span></div>

                                                    <form class="form-horizontal" method="post" enctype="multipart/form-data" name="invoice" action="">
                                    <fieldset>
                                    <h3 class="subtitle align-center">Contact Information</h3>
                                        <!-- General form elements -->
                                        <div class="span11 well">     
                                            <!-- Selects, dropdowns -->
                                                <input type="hidden" name="device_id" value="<?php echo $_GET['id']; ?>" />
                                                <input type="hidden" name="model_id" value="<?php echo $_GET['version']; ?>" />
                                                <input type="hidden" name="color_id" value="<?php echo $_GET['color']; ?>" />
                                                <input type="hidden" name="network_id" value="<?php echo $_GET['network']; ?>" />
                                                <input type="hidden" name="problem_id" value="<?php echo $_GET['problem']; ?>" />
                                                <?php 
												$cart=$obj_checkin->cart(@$_SESSION['SESS_CART_CHECKIN']);
												?>
                                                <input type="hidden" name="cart" value="<?php echo $cart; ?>" />
                                                <?php 
												if(!empty($_GET['price']))
												{
													$obj->delete("check_user_price",array("ckeckin_id"=>$cart));
													$obj->insert("check_user_price",array("ckeckin_id"=>$cart,"store_id"=>$input_by,"access_id"=>$input_by,"price"=>$_GET['price'],"date"=>date('Y-m-d'),"status"=>1));
												}
												else
												{
														$chk=$obj->exists_multiple("check_user_price",array("ckeckin_id"=>$cart));
														if($chk==0)
														{
															$obj->insert("check_user_price",array("ckeckin_id"=>$cart,"store_id"=>$input_by,"access_id"=>$input_by,"price"=>$_GET['price2'],"date"=>date('Y-m-d'),"status"=>1));
														}
														else
														{
															$obj->update("check_user_price",array("ckeckin_id"=>$cart,"store_id"=>$input_by,"access_id"=>$input_by,"price"=>$_GET['price2'],"date"=>date('Y-m-d'),"status"=>1));
														}
												}
												
												
											$make_new_pr_name=$obj->SelectAllByVal("checkin","id",$_GET['id'],"name") . ", " . $obj->SelectAllByVal("checkin_version","id",$_GET['version'],"name") . " - " . $obj->SelectAllByVal("checkin_problem","id",$_GET['problem'],"name");											
										    $chkexpro=$obj->exists_multiple("product",array("name"=>$make_new_pr_name,"input_by"=>$input_by));
											
											if($chkexpro==0)
											{
													$obj->insert("product",array("name"=>$make_new_pr_name,"store_id"=>$input_by,"description"=>"Product Added From Checkin", 
																				"barcode"=>$bbcode, 
																				"price_cost"=>$_GET['price'],
																				"price_retail"=>$_GET['price'],
																				"quantity"=>1, 
																				"discount"=>0, 
																				"taxable"=>0, 
																				"maintain_stock"=>0, 
																				"notes"=>"Added from Manual Checkin",
																				"reorder"=>0,
																				"conditions"=>0, 
																				"physical_location"=>0,
																				"warranty"=>90, 
																				"vendor"=>0, 
																				"sort_order"=>0,
																				"input_by"=>$input_by, 
																				"access_id"=>$input_by,
																				"date"=>date('Y-m-d')));
												}
												
												?>
                                                <span id="newcus">
                                                <div class="control-group">
                                                    <label class="span3"> Choose Customer </label>
                                                    <div id="newcus">
                                                    <select name="customername" onChange="new_customer_checkin(this.value)" id="customername" data-placeholder="Choose a Customer..." class="select-search select2-offscreen" tabindex="-1">
                                                    <option value=""></option> 
                                                    <option value="<?php echo $def_cus; ?>"><?php echo $obj->SelectAllByVal("customer_list","id",$def_cus,"fullname"); ?></option> 
													<?php
													 if($input_status==1){
                                                     $sqlpdata=$obj->SelectAll("coustomer");
													 }else{
													 $sqlpdata=$obj->SelectAllByID("coustomer",array("input_by"=>$input_by));	 
													 }
                                                     if(!empty($sqlpdata))
                                                     foreach($sqlpdata as $row):
													 if($row->id!=$def_cus)
													 {
                                                    ?>
                                                        <option value="<?php  echo $row->id; ?>">
                                                    <?php echo $row->firstname." ".$row->lastname; ?>
                                                        </option> 
                                                    <?php 
													}
													endforeach; ?> 
                                                        <option value="0">Add New Customer</option> 
                                                </select>
                                                </div>
                                                </div>
                                                
                                                
                                                </span>
                                                
                                                <div class="control-group">
                                                    <button type="submit" name="save" class="btn btn-success"><i class="icon-cog"></i> Save Changes </button>
                                                </div>
                                            </div>
                                            <!-- /selects, dropdowns -->

                                           
                                        <!-- /general form elements -->     


                                        <div class="clearfix"></div>

                                        <!-- Default datatable -->

                                        <!-- /default datatable -->


                                    </fieldset>                     

                                </form>
                                                    <div class="clearfix"></div>
                           						 </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /line chart -->
                                



                                <div class="separator-doubled"></div> 



                            </div>
                            <!-- /content container -->

                        </div>
                    </div>
                </div>
            </div>
            <!-- /main content -->
            <?php include('include/footer.php'); ?>
            <!-- Right sidebar -->
            <?php //include('include/sidebar_right.php'); ?>
            <!-- /right sidebar -->

        </div>
        <!-- /main wrapper -->

    </body>
</html>
