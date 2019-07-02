<?php include('class/auth.php'); 
$table="checkin_version";
$table2="checkin";

include('class/pos_class.php');
$obj_pos = new pos();
$cashier_id=$obj_pos->cashier_id(@$_SESSION['SESS_CASHIER_ID']);
$cashiers_id=$obj_pos->cashier_actual_id(@$_SESSION['SESS_CASHIER_ID']);
if($cashier_id==0)
{
	$obj->Error("Cashier Not Logged IN. Please Login as a Cashier First","pos.php");	
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
       <?php
        include './plugin/plugin.php';
        $cms = new CmsRootPlugin();
        echo $cms->GeneralCss(array("color"));
        ?>
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
                            <h5><i class="icon-check"></i>Check In</h5>
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
                                                    <strong class="span1"  style="width:90px; padding-left:1px; padding-right:1px; margin-left:3px; margin-right:0; display:inline-block;">Color : Step 3</strong>
                                                    <strong class="span1"  style="width:98px; padding-left:1px; padding-right:1px; margin-left:3px; margin-right:0; display:inline-block;">Network : Step 4</strong>
                                                    <strong class="span1"  style="width:98px; padding-left:1px; padding-right:1px; margin-left:3px; margin-right:0; display:inline-block;">Problem! : 5</strong>
                                                    <strong class="span1"  style="width:60px; padding-left:1px; padding-right:1px; margin-left:3px; margin-right:0; display:inline-block;">Price : 6</strong>
                                                    <strong class="span1"  style="width:98px; padding-left:1px; padding-right:1px; margin-left:3px; margin-right:0; display:inline-block;">Customer : 7</strong>
                                                    <strong class="span1"  style="width:60px; padding-left:1px; padding-right:1px; margin-left:3px; margin-right:0; display:inline-block;">Info : 8</strong>
                                                    
                                        <div  class="progress progress-success value"><div class="bar" data-percentage="2" data-amount-part="2" data-amount-total="8">2/8</div></div>
                                        
                                        
                                                    
                           						 </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row-fluid">

                                    <div class="span12">
                                        <div class="semi-block">
                                            <div class="well-white body">
                                                    <h5 class="subtitle align-center"> Your Device : <?php echo $obj->SelectAllByVal($table2,"id",$_GET['id'],"name"); ?>  </h5>
                                                    <div class="separator"><span></span></div>
                                                    <h3 class="subtitle align-center"> Select Model  </h3>
                                                    <div class="align-center" style="margin-top:30px;">
                                                    <?php
													if($input_status==1){
													$data=$obj->SelectAllByID($table,array("checkin_id"=>$_GET['id']));
													}else{
													$data=$obj->SelectAllByID_Multiple("checkin_version_store",array("checkin_id"=>$_GET['id'],"store_id"=>$input_by));	
													}
													if(!empty($data))
													foreach($data as $row):
													
													?>
                                        <a href="checkin3.php?id=<?php echo $_GET['id']; ?>&amp;version=<?php echo $row->id; ?>" style="height:30px; padding-left:20px; padding-right:20px; line-height:30px; font-size:18px;" class="btn"> <?php echo $row->name; ?> </a>
                                                    <?php  
													endforeach;
													?>
                                                    </div>
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
