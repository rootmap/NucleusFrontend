<?php
include('class/auth.php');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
				<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
				<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
				<link rel="icon" href="/favicon.ico" type="image/x-icon">
				<title> Nucleus Event Calender </title>
				<link  type="text/css"  href="css/main.css" rel="stylesheet" />
				<script type="text/javascript" src="js/jquery-1.9.1.js"></script>
				<script type="text/javascript" src="js/jquery-migrate-1.0.0.js"></script>
				<script type="text/javascript" src="js/jquery_ui_custom.js"></script>
				<script type="text/javascript" src="js/plugins/charts/excanvas.min.js"></script>
				<script type="text/javascript" src="js/plugins/charts/jquery.flot.js"></script>
				<script type="text/javascript" src="js/plugins/charts/jquery.flot.resize.js"></script>
				<script type="text/javascript" src="js/plugins/charts/jquery.sparkline.min.js"></script>
				<script type="text/javascript" src="js/plugins/forms/jquery.tagsinput.min.js"></script>
				<script type="text/javascript" src="js/plugins/forms/jquery.inputlimiter.min.js"></script>
				<script type="text/javascript" src="js/plugins/forms/jquery.maskedinput.min.js"></script>
				<script type="text/javascript" src="js/plugins/forms/jquery.autosize.js"></script>
				<script type="text/javascript" src="js/plugins/forms/jquery.ibutton.js"></script>
				<script type="text/javascript" src="js/plugins/forms/jquery.dualListBox.js"></script>
				<script type="text/javascript" src="js/plugins/forms/jquery.validate.js"></script>
				<script type="text/javascript" src="js/plugins/forms/jquery.uniform.min.js"></script>
				<script type="text/javascript" src="js/plugins/forms/jquery.select2.min.js"></script>
				<script type="text/javascript" src="js/plugins/forms/jquery.cleditor.js"></script>
				<script type="text/javascript" src="js/plugins/uploader/plupload.js"></script>

				<script type="text/javascript" src="js/plugins/uploader/jquery.plupload.queue.js"></script>
				<script type="text/javascript" src="js/plugins/wizard/jquery.form.wizard.js"></script>
				<script type="text/javascript" src="js/plugins/wizard/jquery.form.js"></script>
				<script type="text/javascript" src="js/plugins/ui/jquery.collapsible.min.js"></script>
				<script type="text/javascript" src="js/plugins/ui/jquery.timepicker.min.js"></script>
				<script type="text/javascript" src="js/plugins/ui/jquery.jgrowl.min.js"></script>
				<script type="text/javascript" src="js/plugins/ui/jquery.pie.chart.js"></script>
				<script type="text/javascript" src="js/plugins/ui/jquery.fullcalendar.min.js"></script>
				<script type="text/javascript" src="js/plugins/ui/jquery.elfinder.js"></script>
				<script type="text/javascript" src="js/plugins/ui/jquery.fancybox.js"></script>
				<script type="text/javascript" src="js/plugins/tables/jquery.dataTables.min.js"></script>
				<script type="text/javascript" src="js/plugins/bootstrap/bootstrap.min.js"></script>
				<script type="text/javascript" src="js/plugins/bootstrap/bootstrap-bootbox.min.js"></script>
				<script type="text/javascript" src="js/plugins/bootstrap/bootstrap-progressbar.js"></script>
				<script type="text/javascript" src="js/plugins/bootstrap/bootstrap-colorpicker.js"></script>
                <?php include('js/functions/custom.php'); ?>
				<script type="text/javascript" src="js/charts/chart.js"></script>
        
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
                            <h5><span><i class="font-cogs"></i> Store/Employee Events/Schedule Calender</span><span style="float:right;"><a href="add_event_calender.php"><i class="icon-plus"></i>Add New Event</a></span> </h5>
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
                                
                                <div class="block">
                        	  
                           
                            <div id='calendar'></div>                            <!-- /date picker -->

                            
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
            <?php include('include/footer.php'); ?>
            <!-- Right sidebar -->
            <?php //include('include/sidebar_right.php');  ?>
            <!-- /right sidebar -->

        </div>
        <!-- /main wrapper -->

    </body>
</html>
