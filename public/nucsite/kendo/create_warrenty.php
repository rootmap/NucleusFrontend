<?php
include('class/auth.php');
$table="warrenty";
if(isset($_POST['create']))
{
	extract($_POST);
	if(!empty($warrenty) && !empty($note) && !empty($warrenty_id))
	{
		$arra=array(
		"warrenty_id"=>$warrenty_id,
		"warrenty"=>$warrenty,
		"note"=>$note,
		"type"=>$type, 
		"uid"=>$input_by,"access_id"=>$access_id, 
		"date"=>date('Y-m-d'),
		"status"=>1);
		if($obj->exists_multiple($table,array("warrenty_id"=>$warrenty_id,"type"=>$type))!=0)
		{
			if($obj->update($table,$arra)==1)
			{	
		$obj->Success("Successfully updated","warrenty_print.php?print_invoice=yes&warrenty_id=".$warrenty_id);
			}
			else
			{
		$obj->Error("Something wrong, Try again.", $obj->filename()."?warrenty_id=".$warrenty_id."&type=".$type);
			}
		}
		else
		{
			if($obj->insert($table,$arra)==1)
			{
				$obj->Success("Successfully Saved","search_report.php?search=".$warrenty_id);
			}
			else
			{
				$obj->Error("Something wrong, Try again.", $obj->filename()."?warrenty_id=".$warrenty_id."&type=".$type);
			}
		}
	}
	else
	{
		$obj->Error("Failed, Fill up required field.", $obj->filename()."?warrenty_id=".$warrenty_id."&type=".$type);
	}
}
extract($_GET);
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
                            <h5>
                            <?php
							if($obj->exists_multiple($table,array("warrenty_id"=>$warrenty_id,"type"=>$type))!=0){
							?>
                            <i class="font-edit"></i> Update Warrenty
                            <?php }else{ ?>
                            <i class="font-plus"></i> Create New Warrenty
                            <?php } ?>
                            </h5>
                            <ul class="icons">
                                <li><a href="<?php echo $obj->filename()."?warrenty_id=".$warrenty_id."&type=".$type; ?>" class="hovertip" title="Reload"><i class="font-refresh"></i></a></li>
                            </ul>
                        </div><!-- /page header -->

                        <div class="body">

                            <!-- Middle navigation standard -->
                            <?php //include('include/quicklink.php'); ?>
                            <!-- /middle navigation standard -->

                            <!-- Content container -->
                            <div class="container">




                                <!-- Content Start from here customized -->
								<?php
								if($obj->exists_multiple($table,array("warrenty_id"=>$warrenty_id,"type"=>$type))!=0){
								?>
                                <form class="form-horizontal" target="_blank" method="post" name="invoice" action="#">
                                    <fieldset>
										

                                        <div class="row-fluid block">
                                            <!-- General form elements -->
                                            <div class="clearfix"></div>
                                            <div class="span6" style="margin: 0;">
                                                <div class="control-group">
                                                    <label class="control-label" style="width: 175px;">* Change Warranty  </label>
                                                    <div class="controls">
                                                    
                                                    <select name="warrenty" id="warrenty" data-placeholder="Choose Warranty ..." class="select-search select2-offscreen" style="width:230px;" tabindex="-1">
                                                        <option value=""></option> 
                                                    <?php 
													
													$dd=$obj->SelectAllByVal2("warrenty","warrenty_id",$warrenty_id,"type",$type,"warrenty");
													for($i=0; $i<=465; $i++): ?>
                                                    <option <?php if($dd==$i){ ?> selected <?php } ?> value="<?php echo $i; ?>">
                                                    <?php echo $i; ?> Days
                                                    </option> 
                                                    <?php endfor; ?> 
                                                    </select>
                                                    <input type="hidden" name="warrenty_id" value="<?php echo $warrenty_id; ?>">
                                                    <input type="hidden" name="type" value="<?php echo $type; ?>">
                                                    </div>
                                                    
                                                </div>

                                                <div class="control-group">
                                 <label class="control-label" style="width: 175px;"> Change Note </label>
                                                    <div class="controls">
                                                    <textarea type="text" name="note" id="note" class="span8" placeholder="Leave a Note"><?php echo $obj->SelectAllByVal2("warrenty","warrenty_id",$warrenty_id,"type",$type,"note"); ?></textarea>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label">&nbsp;</label>
                                                    <div class="controls">
     <button type="submit"  name="create" onClick="pagerelocate('search_report.php?search=<?php echo $warrenty_id; ?>')" class="btn btn-success">
     	<i class="icon-ok"></i> Save Warranty
     </button> 
                  <button type="reset" class="btn btn-danger"><i class="icon-ban-circle"></i> Reset Form</button>
                                                    </div>
                                                <br>
                                                <br>
                                                
                                            </div>
                                            <!-- /general form elements -->
                                            
                                            
                                            
                                            <!-- General form elements -->
                                            
                                            <!-- /general form elements -->


                                        </div>
                                        <!-- /general form elements -->     


                                        <div class="clearfix"></div>



                                    </fieldset>                     

                                </form>
                                <?php }else{ ?>
                                <form class="form-horizontal" method="post" name="invoice" action="#">
                                    <fieldset>
										

                                        <div class="row-fluid block">
                                            <!-- General form elements -->
                                            <div class="clearfix"></div>
                                            <div class="span6" style="margin: 0;">
                                                <div class="control-group">
                                                    <label class="control-label" style="width: 175px;">* Warranty </label>
                                                    <div class="controls">
                                                    
                                                    <select name="warrenty" id="warrenty" data-placeholder="Choose Warranty ..." class="select-search select2-offscreen" style="width:230px;" tabindex="-1">
                                                        <option value=""></option> 
                                                    <?php for($i=0; $i<=465; $i++): ?>
                                                    <option <?php if(@$_GET['wd']==$i){ ?> selected <?php } ?> value="<?php echo $i; ?>">
                                                    <?php echo $i; ?> Days
                                                    </option> 
                                                    <?php endfor; ?> 
                                                    </select>
                                                    <input type="hidden" name="warrenty_id" value="<?php echo $_GET['warrenty_id']; ?>">
                                                    <input type="hidden" name="type" value="<?php echo $_GET['type']; ?>">
                                                    </div>
                                                    
                                                </div>

                                                <div class="control-group">
                                 <label class="control-label" style="width: 175px;"> Note </label>
                                                    <div class="controls">
                                                    <textarea type="text" name="note" id="note" class="span8" placeholder="Leave a Note"></textarea>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label">&nbsp;</label>
                                                    <div class="controls">
     <button type="submit"  name="create" class="btn btn-success">
     	<i class="icon-ok"></i> Save Warranty
     </button> 
                  <button type="reset" class="btn btn-danger"><i class="icon-ban-circle"></i> Reset Form</button>
                                                    </div>
                                                <br>
                                                <br>
                                                
                                            </div>
                                            <!-- /general form elements -->
                                            
                                            
                                            
                                            <!-- General form elements -->
                                            
                                            <!-- /general form elements -->


                                        </div>
                                        <!-- /general form elements -->     


                                        <div class="clearfix"></div>



                                    </fieldset>                     

                                </form>
                                <?php } ?>


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
