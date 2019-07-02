<?php 
include('class/auth.php');
//include('class/index.php');
//$index=new index();
$tables="checkin_user_price"; 
$table="checkin_problem"; 
$table2="checkin_network";
$table3="checkin_version_color";
$table4="checkin_version";
$table5="checkin";
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
                                                    <strong class="span1 label label-success"  style="width:90px; padding-left:1px; padding-right:1px; margin-left:3px; margin-right:0; display:inline-block;">Color : Step 3</strong>
                                                    <strong class="span1 label label-success"  style="width:98px; padding-left:1px; padding-right:1px; margin-left:3px; margin-right:0; display:inline-block;">Network : Step 4</strong>
                                                    <strong class="span1 label label-success"  style="width:98px; padding-left:1px; padding-right:1px; margin-left:3px; margin-right:0; display:inline-block;">Problem! : 5</strong>
                                                    <strong class="span1 label label-success"  style="width:60px; padding-left:1px; padding-right:1px; margin-left:3px; margin-right:0; display:inline-block;">Price : 6</strong>
                                                    <strong class="span1"  style="width:98px; padding-left:1px; padding-right:1px; margin-left:3px; margin-right:0; display:inline-block;">Customer : 7</strong>
                                                    <strong class="span1"  style="width:60px; padding-left:1px; padding-right:1px; margin-left:3px; margin-right:0; display:inline-block;">Info : 8</strong>
                                                    
                                        <div  class="progress progress-success value"><div class="bar" data-percentage="6" data-amount-part="6" data-amount-total="8">5/8</div></div>
                                        
                                                    
                                        
                                                    
                           						 </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row-fluid">
									<form action="checkin_complete.php" method="get">
                                    <div class="span12">
                                        <div class="semi-block">
                                            <div class="well-white body">
                                                    <h5 class="subtitle align-center"> Your Device : 
													<?php echo $obj->SelectAllByVal($table5,"id",$_GET['id'],"name"); ?>,
													<?php echo $obj->SelectAllByVal($table4,"id",$_GET['version'],"name"); ?>,
                                                    Color - <?php echo $obj->SelectAllByVal($table3,"id",$_GET['color'],"name"); ?>, 
                                                    Network - <?php echo $obj->SelectAllByVal($table2,"id",$_GET['network'],"name"); ?>, 
                                                    Problem - <?php echo $obj->SelectAllByVal($table,"id",$_GET['problem'],"name"); ?>  </h5>
                                                    <div class="separator"><span></span></div>
                                                    <h3 class="subtitle align-center"> Device Recomended Price </h3>
                                                    <div class="align-center" style="margin-top:30px;">
                                                     <div style="height:130px; padding-top:10px; border-radius:6px; width:330px; background:rgba(255,255,204,1); margin:0 auto;">
                                                     <h4 class="subtitle align-left" style="padding-left:10px;"><i class="icon-eye-open"></i> Price : $
													 <?php 													 
													 $make_new_pr_name=str_replace(' ','',$obj->SelectAllByVal("checkin","id",$_GET['id'],"name")).", ".$obj->SelectAllByVal("checkin_version","id",$_GET['version'],"name")." - ".$obj->SelectAllByVal("checkin_problem","id",$_GET['problem'],"name");
													 										
													 
													 if($input_status==1)
													 {
													 	$ppr=$obj->SelectAllByVal("product","name",$make_new_pr_name,"price_retail");
														
													 }
													 else
													 {
														$pr=$obj->SelectAllByVal2("product","name",$make_new_pr_name,"input_by",$input_by,"price_retail");
														if($pr=="")
														{
															$make_new_pr_names=$obj->SelectAllByVal("checkin","id",$_GET['id'],"name").", ".$obj->SelectAllByVal("checkin_version","id",$_GET['version'],"name")." - ".$obj->SelectAllByVal("checkin_problem","id",$_GET['problem'],"name");	
															$newprname=$make_new_pr_names;
															$ppr=$obj->SelectAllByVal2("product","name",$newprname,"input_by",$input_by,"price_retail");
														}
														else
														{
															$ppr=$obj->SelectAllByVal2("product","name",$make_new_pr_name,"input_by",$input_by,"price_retail");
														}
													 }
													 
													 if($ppr=='')
													 {
														$newpr="0"; 
														
													 }
													 else
													 {
														$newpr=$ppr; 
													 }
													 echo $newpr;
													  ?> 
                                                     </h4>
                                                 <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
                                                 <input type="hidden" name="version" value="<?php echo $_GET['version']; ?>" />
                                                 <input type="hidden" name="color" value="<?php echo $_GET['color']; ?>" />
                                                 <input type="hidden" name="network" value="<?php echo $_GET['network']; ?>" />
                                                 <input type="hidden" name="problem" value="<?php echo $_GET['problem']; ?>" />
                                                 
                                                     <h4 class="subtitle align-left" style="padding-left:10px;"><i class="icon-eye-open"></i> Override Price : <input type="text" name="price" placeholder="Override Price" /> 
                                                     <input type="hidden" value="<?php echo $newpr; ?>" name="price2" placeholder="Override Price" />
                                                     </h4>
                                                     <h4 class="subtitle align-left" style="padding-left:10px;">
                   					<button type="submit" name="prr" class="btn btn-info"><i class="icon-chevron-right"></i>Next as Recomended</button>
             <button type="submit" name="pr" class="btn btn-success"><i class="icon-chevron-right"></i> Override Price </button>
                                                     </h4>
                                                     
                                                     </div>
                                        
                                                   
                                                    </div>
                                                    <div class="clearfix"></div>
                           						 </div>
                                        </div>
                                    </div>
                                    </form>
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
