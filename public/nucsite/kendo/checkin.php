<?php include('class/auth.php'); 
$table="checkin";
include('class/checkin_class.php');	
$obj_checkin = new checkin_class();
$obj_checkin->newcart(@$_SESSION['SESS_CART_CHECKIN']);
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
                            <h5><i class="icon-check"></i> Check In</h5>
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
                                                    
                                                    <strong class="span1"  style="width:90px; padding-left:1px; padding-right:1px; margin-left:3px; margin-right:0; display:inline-block;">Model : Step 2</strong>
                                                    <strong class="span1"  style="width:90px; padding-left:1px; padding-right:1px; margin-left:3px; margin-right:0; display:inline-block;">Color : Step 3</strong>
                                                    <strong class="span1"  style="width:98px; padding-left:1px; padding-right:1px; margin-left:3px; margin-right:0; display:inline-block;">Network : Step 4</strong>
                                                    <strong class="span1"  style="width:98px; padding-left:1px; padding-right:1px; margin-left:3px; margin-right:0; display:inline-block;">Problem! : 5</strong>
                                                    <strong class="span1"  style="width:60px; padding-left:1px; padding-right:1px; margin-left:3px; margin-right:0; display:inline-block;">Price : 6</strong>
                                                    <strong class="span1"  style="width:98px; padding-left:1px; padding-right:1px; margin-left:3px; margin-right:0; display:inline-block;">Customer : 7</strong>
                                                    <strong class="span1"  style="width:60px; padding-left:1px; padding-right:1px; margin-left:3px; margin-right:0; display:inline-block;">Info : 8</strong>
                                                    
                                        <div  class="progress progress-success value"><div class="bar" data-percentage="1" data-amount-part="1" data-amount-total="8">1/8</div></div>
                                        
                                        
                                                    
                           						 </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row-fluid">

                                    <div class="span12">
                                        <div class="semi-block">
                                            <div class="well-white body">
                                                    <h2 class="subtitle align-center"> What Type of Device Do You Have </h2>
                                                    <?php
													if($input_status==1)
													{
													$data=$obj->SelectAllByID_Multiple($table,array("store_id"=>$input_by));
													}else{
													$data=$obj->SelectAllByID("checkin_store",array("store_id"=>$input_by));	
													}
													$i=1;
													if(!empty($data))
													foreach($data as $row):
													if($i==1)
													{
														$kopa="style='margin-left:50px;'";	
														$class="span2";	
													}
													elseif($i==4)
													{
														$kopa="";	
														$class="span3";	
														$i=0;
													}
													else
													{
														$kopa="";	
														$class="span3";		
													}
													?>
                                                    <div class="<?php echo $class; ?>" <?php echo $kopa; ?>>
                    <div class="align-center"><img src="checkin/<?php echo $row->photo; ?>" width="85" /></div>
                    <div class="align-center"><a href="checkin2.php?id=<?php echo $row->id; ?>" class="btn"><?php echo $row->name; ?></a></div>
                                                    </div>
                                                    <?php
													$i++; 
													endforeach;
													?>
                                                    
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
           <?php
            include('include/footer.php');
            ?>

        </div>
        <!-- /main wrapper -->

    </body>
</html>
