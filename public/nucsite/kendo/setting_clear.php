<?php
include('class/auth.php');
if(@$_GET['action']=='clear')
{
	extract($_GET);
	if($obj->delete($table,array("input_by"=>$id))==1)
	{
		$obj->Success("Data is Cleared Successfully", $obj->filename());
	}
	else
	{
		$obj->Error("Data isn't Cleared,Something is wrong, Try again.", $obj->filename());
	}
}

if(@$_GET['actions']=='clears')
{
	extract($_GET);
	$obj->delete("checkin_request",array("input_by"=>$id));
	$obj->delete("checkin_request_ticket",array("uid"=>$id));
	$obj->delete("invoice",array("invoice_creator"=>$id));
	$obj->delete("invoice_detail",array("uid"=>$id));
	$obj->delete("parts_order",array("input_by"=>$id));
	$obj->delete("payout",array("uid"=>$id));
	$obj->delete("sales",array("input_by"=>$id));
	$obj->delete("store_open",array("sid"=>$id));
	$obj->delete("store_punch_time",array("sid"=>$id));
	$obj->delete("ticket",array("uid"=>$id));
	$obj->delete("unlock_request",array("uid"=>$id));
	$obj->Success("Data is Cleared Successfully", $obj->filename());
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
                            <h5><i class="icon-remove"></i> Clear Data </h5>
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
                                           
                                            <div class="span12" style="padding:0px; margin:0px;">
                                                <div class="control-group">
      									<a href="<?php echo $obj->filename(); ?>?table=transaction_log&amp;id=<?php echo $input_by; ?>&amp;action=clear" class="k-button"><i class="font-remove-sign"></i> Clear Transaction Log </a>                                    			
                                                </div>
                                                <div class="control-group">
      									<a href="<?php echo $obj->filename(); ?>?table=invoice_payment&amp;id=<?php echo $input_by; ?>&amp;action=clear" class="k-button"><i class="font-remove-sign"></i> Clear Invoice Payment </a>                                    			
                                                </div>
                                                <div class="control-group">
      									<a href="<?php echo $obj->filename(); ?>?table=buyback&amp;id=<?php echo $input_by; ?>&amp;action=clear" class="k-button"><i class="font-remove-sign"></i> Clear Buyback </a>                                    			
                                                </div>
                                                <div class="control-group">
      									<a href="<?php echo $obj->filename(); ?>?id=<?php echo $input_by; ?>&amp;actions=clears" class="k-button"><i class="font-remove-sign"></i> Clear All Sales Rescord </a>                                    			
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
