<?php
include('class/auth.php');
include('class/pos_class.php');
$obj_pos = new pos();
$cashier_id=$obj_pos->cashier_id(@$_SESSION['SESS_CASHIER_ID']);
$cashiers_id=$obj_pos->cashier_actual_id(@$_SESSION['SESS_CASHIER_ID']);
if($cashier_id==0)
{
	$obj->Error("Cashier Not Logged IN. Please Login as a Cashier First","pos.php");	
}
$table="buyback";
if (isset($_GET['newticket'])) {
    $obj->newcart_buyback(@$_SESSION['SESS_CART_BUYBACK']);
    $obj->Success("New Buyback Token Has Been Created Successfully", $obj->filename()."?cid=".$_GET['cid']);
}
$cart = $obj->cart_buyback(@$_SESSION['SESS_CART_BUYBACK']);
if(isset($_POST['find']))
{
	extract($_POST); 
	if(!empty($amounts))
	{
		if($obj->exists_multiple("buyback_estimate",array("store_id"=>$input_by,"customer_id"=>$customer_id,"manufacture"=>$manufacture,"model"=>$model,"nid"=>$nid,"dtid"=>$dtid,"cid"=>$cid,"dtoid"=>$dtoid,"wdid"=>$wdid,"msid"=>$msid))==0)
		{
			if($obj->insert("buyback_estimate",array("store_id"=>$input_by,"customer_id"=>$customer_id,"manufacture"=>$manufacture,"model"=>$model,"nid"=>$nid,"dtid"=>$dtid,"cid"=>$cid,"dtoid"=>$dtoid,"wdid"=>$wdid,"msid"=>$msid,"amount"=>$amounts,"detail"=>$detail,"access_id"=>$access_id,"date"=>date('Y-m-d'),"status"=>1))==1)
			{
				$obj->Success("Request Saved Successfully.",$obj->filename()."?cid=".$customer_id);	
			}
			else
			{
				$obj->Error("Failed, Sql Error",$obj->filename()."?cid=".$customer_id);		
			}
		}
		else
		{
			$obj->Error("Failed, Already Exists",$obj->filename()."?cid=".$customer_id);
		}
	}
	else
	{
		$obj->Error("Failed, Some field is Empty",$obj->filename()."?cid=".$customer_id);	
	}
}

if(isset($_POST['create']))
{
	extract($_POST);
	if(!empty($model))
	{
		if($obj->insert($table,array("cid"=>$cid,
		"buyback_id"=>$buyback_id,
		"uid"=>$input_bys,
		"cashier_id"=>$cashiers_id,
		"model"=>$model,
		"carrier"=>$carrier,
		"imei"=>$imei,
		"type_color"=>$type_color,
		"gig"=>$gig,
		"conditions"=>$condition, 
		"price"=>$price,
		"payment_method"=>$payment_method,
		"input_by"=>$input_by,"access_id"=>$access_id,
		"date"=>date('Y-m-d'),
		"datetime"=>date('Y-m-d H:i'),
		"status"=>1))==1)
		{
			
			$obj->insert("transaction_log",array("transaction"=>$buyback_id,"sid"=>$input_by,"customer_id"=>$cid,"date"=>date('Y-m-d'),"time"=>date('H:i:s'),"amount"=>"-".$price,"type"=>6,"tender"=>$payment_method,"access_id"=>$access_id,"status"=>1));
			$cus=0;
			$obj->newcart_buyback(@$_SESSION['SESS_CART_BUYBACK']);
			$obj->Success("Successfully Saved","view_buyback.php?buyback_id=".$buyback_id."&custom=".$cus);
		}
		else
		{
			$obj->Error("Something wrong, Try again.", $obj->filename()."?cid=".$cid);
		}	
	}
	else
	{
		$obj->Error("Failed, Fill up required field.", $obj->filename()."?cid=".$cid);
	}
}

if(isset($_POST['create_tradein']))
{
	extract($_POST);
	if(!empty($model))
	{
		if($obj->insert($table,array("cid"=>$cid,
		"buyback_id"=>$buyback_id,
		"pos_id"=>$pos_id,
		"uid"=>$input_bys,
		"cashier_id"=>$cashiers_id,
		"model"=>$model,
		"carrier"=>$carrier,
		"imei"=>$imei,
		"type_color"=>$type_color,
		"gig"=>$gig,
		"conditions"=>$condition, 
		"price"=>$price,
		"payment_method"=>$payment_method,
		"input_by"=>$input_by,"access_id"=>$access_id,
		"date"=>date('Y-m-d'),
		"datetime"=>date('Y-m-d H:i'),
		"status"=>1))==1)
		{
			
			$obj->insert("transaction_log",array("transaction"=>$buyback_id,"sid"=>$input_by,"customer_id"=>$cid,"date"=>date('Y-m-d'),"time"=>date('H:i:s'),"amount"=>"-".$price,"type"=>6,"tender"=>$payment_method,"access_id"=>$access_id,"status"=>1));
			$cus=0;
			$obj->newcart_buyback(@$_SESSION['SESS_CART_BUYBACK']);
			$obj->Success("Successfully Saved","pos.php");
		}
		else
		{
			$obj->Error("Something wrong, Try again.","pos.php");
		}	
	}
	else
	{
		$obj->Error("Failed, Fill up required field.","pos.php");
	}
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php echo $obj->bodyhead(); ?>
        <script src="ajax/ticket_ajax.js"></script>
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
                            <h5><i class="font-home"></i>Create New BuyBack Info</h5>
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




                                <!-- Content Start from here customized -->
                                <div class="block span6">
                                    <a href="<?php echo $obj->filename(); ?>?newticket=1&amp;cid=<?php echo $_GET['cid']; ?>" class="btn btn-danger"><i class="icon-ok-sign"></i>New BuyBack ID</a>
                                </div>

                                <form class="form-horizontal" method="post" name="invoice" action="">
                                    <fieldset>


                                        <div class="row-fluid block well">
                                            <div class="navbar">
                                                <div class="navbar-inner">
                                                    <h5><i class="icon-plus"></i> Create BuyBack | BuyBack ID : <?php echo $cart; ?> </h5>
                                                </div>
                                            </div>
                                            <!-- General form elements -->
                                            <div class="clearfix"></div>
                                            <div class="span6" style="margin: 0;">
                                               <div class="control-group">
                                                    <label class="control-label" style="width: 175px;">* Model </label>
                                                    <div class="controls"><input type="text" name="model" class="span8" placeholder="Model " />
                                                    <input type="hidden" name="buyback_id" value="<?php echo $cart; ?>" class="span8" >
                                                    <input type="hidden" name="cid" value="<?php echo $_GET['cid']; ?>" class="span8" >
                                                    </div>
                                                </div>
                                                
                                                <div class="control-group">
                                                    <label class="control-label" style="width: 175px;">Carrier </label>
                                                    <div class="controls">
                                                    <input type="text" name="carrier" class="span8" placeholder="Type Carrier Name" />
                                                    </div>
                                                </div>
                                                
                                                <div class="control-group">
                                                    <label class="control-label" style="width: 175px;">IMEI</label>
                                                    <div class="controls">
                                                    <input type="text" name="imei" class="span8" placeholder="Put Device IMEI Number" />
                                                    </div>
                                                </div>
                                                
                                                <div class="control-group">
                                                    <label class="control-label" style="width: 175px;">Type and Color </label>
                                                    <div class="controls">
                                                    <input type="text" name="type_color" class="span8" placeholder="Please Type Color" />
                                                    </div>
                                                </div>
                                                
                                                <div class="control-group">
                                                    <label class="control-label" style="width: 175px;">Memory </label>
                                                    <div class="controls">
                                                    <input type="text" name="gig" class="span8" placeholder="Please Type Gig" />
                                                    </div>
                                                </div>
                                              
                                                

                                                
                                                <br>
                                                <br>
                                                
                                            </div>
                                            <!-- /general form elements -->
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            <!-- General form elements -->
                                            <div class="span6">
                                                  
                                                <div class="control-group">
                                                    <label class="control-label" style="width: 175px;">Condition </label>
                                                    <div class="controls">
                                                    <input type="text" name="condition" class="span8" placeholder="Please Type Your Device Condition" />
                                                    </div>
                                                </div>
                                                
                                                <div class="control-group">
                                                    <label class="control-label" style="width: 175px;">Price </label>
                                                    <div class="controls">
                                                    <input type="text" name="price" class="span8" placeholder="Please Type Price" />
                                                    </div>
                                                </div>
                                                
                                                <div class="control-group">
                                                    <label class="control-label" style="width: 175px;">Payment Method </label>
                                                    <div class="controls">
                                                    <?php 
													$sqlpm=$obj->SelectAll("payment_method");
													$i=1;
													if(!empty($sqlpm))
													foreach($sqlpm as $pm):
													if($i==1)
													{
													?>
                                                    <label class="radio inline"><input type="radio" checked name="payment_method" value="<?php echo $pm->id; ?>" class="style" id="pm_<?php echo $pm->id; ?>"><strong><?php echo $pm->meth_name; ?> </strong></label>
                                                    <?php
													}
													else
													{
													?>
                                                    <label class="radio inline"><input type="radio" name="payment_method" value="<?php echo $pm->id; ?>" class="style" id="pm_<?php echo $pm->id; ?>"><strong><?php echo $pm->meth_name; ?> </strong></label>
                                                    <?php	
													}
													$i++;
													endforeach; ?>
                                                    </div>
                                                </div>
                                                
                                                
                                                
                                                <div class="control-group">
                                                    <label class="control-label">&nbsp;</label>
                                                    <div class="controls">
                  <button type="submit" name="create" class="btn btn-success"><i class="icon-ok"></i> Create BuyBack </button> 
                  <button type="reset" class="btn btn-danger"><i class="icon-ban-circle"></i> Reset Form</button>
                                                    </div>
                                                </div>
                                                
                                                <div class="control-group" style="display:block; text-align:center; border:2px #333 solid; width:60%; margin-left:auto; margin-right:auto; margin-top:5px; border:1px #CCC ridge;">
                  <a data-toggle="modal" href="#myModal44" class="btn btn-success"><i class="icon-screenshot"></i> Find Device </a>
                  </fieldset>                     

                                </form>
 <!-- Dialog content -->
<div id="myModal44" class="modal hide fade" style="top:30%;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form class="form-horizontal" method="post" action="">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h5 id="myModalLabel"> <i class="icon-screenshot"></i> Find Device </h5>
        </div>
        <div class="modal-body">

            <div class="row-fluid">
                
                <table class="table">
                	<thead>
                    	<tr>
                        	<th align="left" colspan="4"><strong>Contact Information</strong></th>
                        </tr>
                    </thead>
                	<tbody>
                    	<tr>
                        	<td colspan="2" width="20%" align="left">
                            <input class="span12" type="hidden" value="<?php echo $_GET['cid']; ?>" id="customer_id" name="customer_id" />
                            <input class="span12" value="<?php echo $obj->SelectAllByVal("customer_list","id",$_GET['cid'],"fullname"); ?>" type="text" id="cash" name="cash" placeholder="Your Name" /></td>
                            <td width="25%" colspan="2" align="left">
                            <input class="span12" type="text" value="<?php echo $obj->SelectAllByVal("customer_list","id",$_GET['cid'],"email"); ?>" id="cash" name="cash" placeholder="Email Address" /></td>
                        </tr>
                        <tr>
                        	<td align="left" colspan="2">
                            <input class="span12" value="<?php echo $obj->SelectAllByVal("customer_list","id",$_GET['cid'],"phone"); ?>" type="text" id="cash" name="cash" placeholder="Your Phone Number" /></td>
                            <td align="left" colspan="2">
                            <input class="span12" value="<?php echo $obj->SelectAllByVal("customer_list","id",$_GET['cid'],"address"); ?>" type="text" id="cash" name="cash" placeholder="Preferred Contact" /></td>
                        </tr>                        
                    </tbody>
                    <thead>
                    	<tr>
                        	<th align="left" colspan="4"><strong>Device Information</strong></th>
                        </tr>
                    </thead>
                	<tbody>
                    	<tr>
                        	<td width="27%" align="left">Carrier </td>
                            <td>
                            <select name="nid" id="nid" style="width:100px;" data-placeholder="Choose a Carrier..." class="select-search">
                            <?php 
							$sqlcarrier=$obj->SelectAll("buyback_network");
							if(!empty($sqlcarrier))
							foreach($sqlcarrier as $carrier):
							?>
                               <option value="<?php echo $carrier->id; ?>"><?php echo $carrier->name; ?></option>
                               <?php endforeach; ?>
                            </select>
                             </td>
                            <td width="25%" align="left">Device Type</td>
                            <td>
                            <select name="dtid" id="dtid" style="width:130px;" data-placeholder="Choose a Device..." class="select-search">
                            <?php 
							$sqlcarrier=$obj->SelectAll("buyback_device_type");
							if(!empty($sqlcarrier))
							foreach($sqlcarrier as $carrier):
							?>
                               <option value="<?php echo $carrier->id; ?>"><?php echo $carrier->name; ?></option>
                               <?php endforeach; ?>
                            </select>
                            </td>
                        </tr>
                        <tr>
                        	<td align="left" colspan="2">
                            <input class="span12" type="text" id="manufacture" name="manufacture" placeholder="Device Manufacture" />
                            </td>
                            <td align="left">
                            Device Model
                            </td>
                            <td align="left">
                            <select name="model" id="model" style="width:130px;" data-placeholder="Choose a Device..." class="select-search">
                            <?php 
							$sqlcarrier=$obj->SelectAll("buyback_model");
							if(!empty($sqlcarrier))
							foreach($sqlcarrier as $carrier):
							?>
                               <option value="<?php echo $carrier->id; ?>"><?php echo $carrier->name; ?></option>
                               <?php endforeach; ?>
                            </select>
                            </td>
                        </tr>  
                        <tr>
                        	<td align="left">Condition   </td>
                            <td>
                            <select name="cid" id="cid" style="width:100px;" data-placeholder="Choose a Carrier..." class="select-search">
                            <?php 
							$sqlcarrier=$obj->SelectAll("buyback_device_condition");
							if(!empty($sqlcarrier))
							foreach($sqlcarrier as $carrier):
							?>
                               <option value="<?php echo $carrier->id; ?>"><?php echo $carrier->name; ?></option>
                               <?php endforeach; ?>
                            </select>
                            </td>
                            <td align="left">Device Turn On </td>
                            <td>
                            <select name="dtoid" id="dtoid" style="width:100px;" data-placeholder="Choose a Carrier..." class="select-search">
                            <?php 
							$sqlcarrier=$obj->SelectAll("buyback_device_turn_on");
							if(!empty($sqlcarrier))
							foreach($sqlcarrier as $carrier):
							?>
                               <option value="<?php echo $carrier->id; ?>"><?php echo $carrier->name; ?></option>
                               <?php endforeach; ?>
                            </select>
                            </td>
                        </tr>
                        <tr>
                        	<td align="left">Any Water Damage   </td>
                            <td>
                            <select name="wdid" id="wdid" style="width:100px;" data-placeholder="Choose a Device..." class="select-search">
                            <?php 
							$sqlcarrier=$obj->SelectAll("buyback_water_damage");
							if(!empty($sqlcarrier))
							foreach($sqlcarrier as $carrier):
							?>
                               <option value="<?php echo $carrier->id; ?>"><?php echo $carrier->name; ?></option>
                               <?php endforeach; ?>
                            </select>
                            </td>
                            <td align="left">Memory Size </td>
                            <td>
                            <select name="msid" id="msid" style="width:100px;" data-placeholder="Choose a Device..." class="select-search">
                            <?php 
							$sqlcarrier=$obj->SelectAll("buyback_memory_size");
							if(!empty($sqlcarrier))
							foreach($sqlcarrier as $carrier):
							?>
                               <option value="<?php echo $carrier->id; ?>"><?php echo $carrier->name; ?></option>
                               <?php endforeach; ?>
                            </select>
                            </td>
                        </tr>
                        <tr>
                        	<td align="left" colspan="4">Describe Your Any Issues With Your Device
                            <br>
                            <textarea class="span12" type="text" id="detail" name="detail" placeholder="
Describe Your Any Issues With Your Device"></textarea>
                            </td>
                        </tr>                      
                    </tbody>
                </table>
            </div>

        </div>
        <div class="modal-footer">
            <span id="show_estimate"><button type="button" class="btn btn-primary" onClick="find_estimate('1','show_estimate')"  name="get_estimate">Get Estimate</button></span>
        </div>
        </form>
</div>
<!-- /dialog content -->
                                                </div>
                                                <br>
                                                <br>
                                            </div>
                                            <!-- /general form elements -->


                                        </div>
                                        <!-- /general form elements -->     


                                        <div class="clearfix"></div>



                                    


                                <!-- Content End from here customized -->




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
