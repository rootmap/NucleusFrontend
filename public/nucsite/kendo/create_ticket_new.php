<?php
include('class/auth.php');
$table="ticket";
if (isset($_GET['newticket'])) {
    $obj->newcart_ticket(@$_SESSION['SESS_CART_TICKET']);
    $obj->Success("New Ticket Token Has Been Created Successfully", $obj->filename()."?cid=".$_GET['cid']);
}
$cart = $obj->cart_ticket(@$_SESSION['SESS_CART_TICKET']);
if(isset($_POST['create']))
{
	extract($_POST);
	if(!empty($title))
	{
		
		if($problem_type!=0)
		{
			$prob_type=$problem_type;	
		}
		else
		{
			$exists=$obj->exists_multiple("problem_type",array("name"=>$new_problem));
			if($exists!=0)
			{
				$prob_type=$obj->SelectAllByVal("problem_type","name",$new_problem,"id");
			}
			else
			{
				$obj->insert("problem_type",array("name"=>$new_problem,"date"=>date('Y-m-d'),"status"=>1));
				$prob_type=$obj->SelectAllByVal("problem_type","name",$new_problem,"id");
			}
			
		}
		
		$product_name=$title." - ".$ticket_id;
		$obj->insert("product",array("name"=>$product_name,"description"=>"Product Added From Ticket","barcode"=>time(),"price_cost"=>$our_cost,"price_retail"=>$retail_cost,"maintain_stock"=>0,"quantity"=>1,"warranty"=>90,"reorder"=>1,"input_by"=>$input_by,"access_id"=>$access_id,"date"=>date('Y-m-d'), "status"=>2));
		
		if($obj->insert($table,array("cid"=>$cid,
		"ticket_id"=>$ticket_id,
		"uid"=>$input_by,
		"title"=>$title,
		"problem_type"=>$prob_type,
		"our_cost"=>$our_cost,
		"retail_cost"=>$retail_cost,
		"work_approved"=>$work_approved,
		"type_color"=>$type_color, 
		"password"=>$password,"carrier"=>$carrier,
		"imei"=>$imei,
		"even_been"=>$ever_been,
		"tested_before"=>$tested_before,
		"tested_after"=>$tested_after,
		"tech_notes"=>$tech_notes, 
                "hdyhau"=>$hdyhau,     
                "isdropoff"=>$isdropoff,      
		"input_by"=>$input_by,"access_id"=>$access_id,
		"date"=>date('Y-m-d'),
		"status"=>1))==1)
		{
			$cus=0;
			if($_POST['custom'])
			foreach($_POST['custom'] as $ff):
				if($obj->insert("ticket_custom_selection",array("ticket_id"=>$ticket_id,"access_id"=>$access_id,"fid"=>$ff))==1)
				{
					$cus+=1;
				}
				else
				{
					$cus+=0;	
				}
			endforeach;
			$obj->newcart_ticket(@$_SESSION['SESS_CART_TICKET']);
			$obj->Success("Successfully Saved","view_ticket.php?ticket_id=".$ticket_id."&amp;custom=".$cus);
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
                            <h5><i class="font-home"></i>Create New Ticket Info</h5>
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
                                    <a href="<?php echo $obj->filename(); ?>?newticket=1&amp;cid=<?php echo $_GET['cid']; ?>" class="btn btn-danger"><i class="icon-ok-sign"></i>New Ticket</a>
                                </div>

                                <form class="form-horizontal" method="post" name="invoice" action="">
                                    <fieldset>


                                        <div class="row-fluid block well">
                                            <div class="navbar">
                                                <div class="navbar-inner">
                                                    <h5><i class="icon-plus"></i> Create Ticket | Ticket ID : <?php echo $cart; ?> </h5>
                                                </div>
                                            </div>
                                            <!-- General form elements -->
                                            <div class="clearfix"></div>
                                            <div class="span6" style="margin: 0;">
                                                <div class="control-group">
                                                    <label class="control-label" style="width: 175px;">* Ticket Title (short description) </label>
                                                    <div class="controls"><input type="text" name="title" class="span8" placeholder="Ticket Title" />
                                                    <input type="hidden" name="ticket_id" value="<?php echo $cart; ?>" class="span8" >
                                                    <input type="hidden" name="cid" value="<?php echo $_GET['cid']; ?>" class="span8" >
                                                    </div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label" style="width: 175px;">* Problem type </label>
                                                    <div class="controls" id="new_problem">
                                                    
                                                    <select name="problem_type" onChange="new_problem(this.value,'new_problem')" id="problem_type" data-placeholder="Choose a Problem..." class="select-search select2-offscreen" tabindex="-1">
                                                        <option value=""></option> 
                                                        <?php
                                                     $sqlpdata=$obj->SelectAll("problem_type");
                                                     if(!empty($sqlpdata))
                                                     foreach($sqlpdata as $row):
                                                    ?>
                                                    <option value="<?php  echo $row->id; ?>">
                                                    <?php echo $row->name; ?>
                                                    </option> 
                                                    <?php endforeach; ?> 
                                                    <option value="0">Add New Problem</option> 
                                                    </select>
                                                    
                                                    </div>
                                                    
                                                </div>

                                                <div class="control-group">
                                 <label class="control-label" style="width: 175px;">* Our Cost </label>
                                                    <div class="controls">
                                                    <input type="text" name="our_cost" class="span8" placeholder="Our Cost" />
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                 <label class="control-label" style="width: 175px;">* Retail Cost For Customer </label>
                                                    <div class="controls">
                                                    <input type="text" name="retail_cost" class="span8" placeholder="Retail Cost For Customer" />
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label" style="width: 175px;">Type and Color </label>
                                                    <div class="controls">
                                                    <input type="text" name="type_color" class="span8" placeholder="Please Type Color" />
                                                    </div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label" style="width: 175px;">Password </label>
                                                    <div class="controls">
                                                    <input type="text" name="password" class="span8" placeholder="Type Ticket Password" />
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
                                                    <label class="control-label" style="width: 175px;">How did you hear about us ?</label>
                                                    <div class="controls">
                                                    <input type="text" name="hdyhau" class="span8" placeholder="How did you hear about us ?" />
                                                    </div>
                                                </div>
                                                
                                                <div class="control-group">
                                                    <label class="control-label" style="width: 175px;">Items Dropped Off ?</label>
                                                    <div class="controls">
                                                    <label class="radio inline"><input type="radio" name="isdropoff" checked="checked" value="Yes" class="style" id="isdropoff_0"><strong>Yes</strong></label>
                                                    <label class="radio inline"><input type="radio" name="isdropoff" value="No" class="style" id="isdropoff_1"><strong>No</strong></label>
                                                    </div>
                                                </div>
                                                
                                                <div class="control-group">
                                                        <a data-toggle="modal" href="#myModal1" class="btn btn-primary"><i class="icon-retweet"></i> Asset</a>                  </div>
                                                <br>
                                                <br>
                                                
                                            </div>
                                            <!-- /general form elements -->
                                            
                                            <!-- Dialog 1 content -->
                                                <div id="myModal1" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                        <h5 id="myModalLabel">Assets</h5>
                                                    </div>
                                                    <div class="modal-body">
                                                    		<p>Here you can create new assets, view existing assets, and attach them to the ticket.</p>
                                                            
                                                            <div class="row-fluid">
                                                            
                                                            	<b id="msg_pro"></b>
                                                            	<div class="control-group">
                                                                    <label class="control-label">Existing Asset</label>
                                                                    <div class="controls">
                                                                        <select id="allexasset" onChange="ticket_asset(this.value,'<?php echo $cart; ?>')" name="select2" data-placeholder="Choose a Existing Asset..." class="select-search select2-offscreen" tabindex="-1">											
                                                                        	<option value=""></option>
                                                                        	<?php 
														$sqlassettype=$obj->SelectAll("asset");
																			if(!empty($sqlassettype))
																			foreach($sqlassettype as $assettype):
																			$exx=$obj->exists_multiple("ticket_asset",array("ticket_id"=>$cart,"asset_id"=>$assettype->id));
																			if($exx==0){
																			?>
                                                                            <option value="<?php echo $assettype->id; ?>">
                                                                            <?php echo $assettype->name; ?>
                                                                            </option>
                                                                            <?php  
																			}
																			endforeach;
																			?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            
                                                                <div class="control-group" id="asset_ticket_list">
                                                                <?php 
											$sqlassetlist=$obj->SelectAllByID_Multiple("ticket_asset",array("ticket_id"=>$cart));
																if(!empty($sqlassetlist))
																foreach($sqlassetlist as $assetlist): ?>
                                                                <label class="label"><?php echo $obj->SelectAllByVal("asset","id",$assetlist->asset_id,"name"); ?> 
                                                                    <button onClick="delete_ticket_asset('<?php echo $assetlist->id; ?>','<?php echo $cart; ?>')" style="border:none; background:none;" type="button">
                                                                        <i class="icon-remove"></i>
                                                                    </button>
                                                                </label>
                                                                <?php endforeach; ?>
                                                                </div>
                                                                
                                                                
                                                            </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                    	<a data-toggle="modal" href="#myModal2" class="btn btn-info"><i class="icon-ok"></i> Create Asset</a>
                                                        <button type="button" class="btn btn-danger"  data-dismiss="modal"><i class="icon-remove"></i> Back To Ticket</button>
                                                    </div>
                                                </div>
                                                <!-- /dialog 1 content -->
                                            
                                            <!-- Dialog 2 content -->
                                                <div id="myModal2" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                        <h5 id="myModalLabel">Create Assets</h5>
                                                    </div>
                                                    <div class="modal-body">
                                                    		<p>Here you can create new assets, view existing assets, and attach them to the ticket.</p>
                                                            <b id="msg_pros"></b>
                                                            <div class="row-fluid">
                                                            
                                                            	<b id="create_asset">
                                                            	<div class="control-group">
                                                                    <label class="control-label">Asset Type</label>
                                                                    <div class="controls">
                                                                        <select id="type_id" onChange="asset_type(this.value)" name="select2" class="style" >
                                                                        	<?php 
														$sqlassettype=$obj->SelectAll("asset_type");
																			if(!empty($sqlassettype))
																			foreach($sqlassettype as $assettype):
																			?>
                                                                            <option value="<?php echo $assettype->id; ?>">
                                                                            <?php echo $assettype->name; ?>
                                                                            </option>
                                                                            <?php  
																			endforeach;
																			?>
                                                                            <option value="0">Add New</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            
                                                                <div class="control-group">
                                                                    <label class="control-label">Asset Name:</label>
                                                                    <div class="controls"><input id="asset_name" type="text" name="regular" class="span12" /></div>
                                                                </div>
                                                                
                                                                <div class="control-group">
                                                                    <label class="control-label">Serial Number:</label>
                                                                    <div class="controls"><input id="serial_number" type="text" name="regular" class="span12" /></div>
                                                                </div>
                                                                
                                                                <div class="control-group">
                                                                    <label class="control-label">Make:</label>
                                                                    <div class="controls"><input id="make" type="text" name="regular" class="span12" /></div>
                                                                </div>
                                                                
                                                                <div class="control-group">
                                                                    <label class="control-label">Model:</label>
                                                                    <div class="controls"><input id="model" type="text" name="regular" class="span12" /></div>
                                                                </div>
                                                                
                                                                <div class="control-group">
                                                                    <label class="control-label">Service Tag:</label>
                                                                    <div class="controls"><input id="service_tag" type="text" name="regular" class="span12" /></div>
                                                                </div>
                                                                </b>
                                                                <div class="control-group" id="asset_list">
                                                               <?php 
															   $sqlasset=$obj->SelectAll("asset");
                                                                if(!empty($sqlasset))
                                                                foreach($sqlasset as $asset): 
																$ex=$obj->exists_multiple("ticket_asset",array("ticket_id"=>$cart,"asset_id"=>$asset->id));
																if($ex==0){
																?>
                                                                <div class="label" style="margin-top:5px;"><?php echo $asset->name; ?>
                                                                    <button onClick="edit_asset('<?php echo $asset->id; ?>')" style="border:none; background:none;" type="button">
                                                                    <i class="icon-edit"></i>
                                                                    </button> 
                                                                    <button onClick="delete_asset('<?php echo $asset->id; ?>')" style="border:none; background:none;" type="button">
                                                                    <i class="icon-remove"></i>
                                                                    </button>
                                                                </div>
                                                                <?php 
																}
																endforeach; ?>
                                                                </div>
                                                                
                                                            </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn" type="button" data-dismiss="modal">Close</button>
                                                        <button type="button" onClick="save_asset()" class="btn btn-primary">Save Asset</button>
                                                    </div>
                                                </div>
                                                <!-- /dialog 2 content -->
                                            
                                            
                                            
                                            
                                            
                                            <!-- General form elements -->
                                            <div class="span6">
                                                <div class="control-group">
                                                    <label><div id="uniform-undefined" class="checker"><span><input style="opacity: 0;" value="1" name="work_approved" class="style" type="checkbox"></span></div> Is work approved to proceed?</label>
                                                    <div class="gap"></div>

                                                </div>

                                                

                                                
                                                <div class="control-group">
                                                    

                                                    <label class="control-label" style="width: 175px;">Tested Before By</label>
                                                    <input type="text" name="tested_before" class="span8" placeholder="Tested Before Yes,No, Name" />
                                                    <br>
                                                    <br>
                                                    <br>
                                                    <label class="checkbox"><div id="uniform-undefined" class="checker"><span><input style="opacity: 0;" value="1" name="ever_been" class="style" type="checkbox"></span></div> Ever Been Wet</label>
                                                    <div class="gap"></div>
                                                    
                                                    <?php
										$sqlshowcustomfields=$obj->SelectAll("ticket_custom_field");
										if(!empty($sqlshowcustomfields))
										foreach($sqlshowcustomfields as $fields):
										?>
                                        <label><div id="uniform-undefined" class="checker">
                                                <span><input style="opacity: 0;" name="custom[]" class="style" type="checkbox" value="<?php echo $fields->id; ?>"></span>
                                            </div> <?php echo $fields->name; ?>
                                        </label>
                                        <div class="gap"></div>
                                        <?php endforeach; ?>
                                                    
                                                    

                                                </div>
                                                
                                                
                                                <div class="control-group">
                                                    <label class="control-label" style="width: 175px;">Tested After By</label>
                                                    <input type="text" name="tested_after" class="span8" placeholder="Tested After By Yes, No, Name" />
                                                </div>
                                                
                                                <div class="control-group">
                                                    <label class="control-label" style="width: 175px;">Tech Notes</label>
                                                    <input type="text" name="tech_notes" class="span8" placeholder="Tech Notes" />
                                                </div>
                                                
                                                <div class="control-group">
                                                    <label class="control-label">&nbsp;</label>
                                                    <div class="controls">
                  <button type="submit" name="create" class="btn btn-success"><i class="icon-ok"></i> Create Ticket </button> 
                  <button type="reset" class="btn btn-danger"><i class="icon-ban-circle"></i> Reset Form</button>
                                                    </div>
                                                </div>
                                                <br>
                                                <br>
                                            </div>
                                            <!-- /general form elements -->


                                        </div>
                                        <!-- /general form elements -->     


                                        <div class="clearfix"></div>



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
            <?php include('include/footer.php'); ?>
            <!-- Right sidebar -->
            <?php //include('include/sidebar_right.php'); ?>
            <!-- /right sidebar -->

        </div>
        <!-- /main wrapper -->

    </body>
</html>
