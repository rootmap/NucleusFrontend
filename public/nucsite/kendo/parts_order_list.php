<?php 
include('class/auth.php'); 
$table="parts_order";
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php echo $obj->bodyhead(); ?>
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
                            <h5><i class="font-home"></i>Parts Order Tracker Info</h5>
                            <ul class="icons">
                                <li><a href="<?php echo $obj->filename(); ?>" class="hovertip" title="Reload"><i class="font-refresh"></i></a></li>
                            </ul>
                        </div><!-- /page header -->

                        <div class="body">

                            <!-- Middle navigation standard -->
                            <?php include('include/quicklink.php'); ?>
                            <!-- /middle navigation standard -->

                            <!-- Content container -->
                            <div class="container">

                                <div class="separator-doubled"></div> 
                                
                                
                                
                                <!-- Content Start from here customized -->
                                
                                
                                <!-- Default datatable -->
                        <div class="block well row-fluid">
                        	<div class="navbar">
                            	<div class="navbar-inner">
                                    <h5><i class="icon-list-alt"></i> Parts Order Tracker List</h5>
                                        <ul class="icons">
                                            <li><a data-original-title="Tooltip on left" data-placement="left" href="inventory.php" class="hovertip" title="Add New Products and Inventory"><i class="icon-plus"></i></a></li>
                                            <li><a data-original-title="Tooltip on left" data-placement="left" href="<?php echo $obj->filename(); ?>" class="hovertip" title="FAQ?"><i class="icon-fire"></i></a></li>
                                            <li><a data-original-title="Tooltip on right" data-placement="right" href="<?php echo $obj->filename(); ?>" class="hovertip" title="Reload Data"><i class="icon-refresh"></i></a></li>
                                        </ul>
                                </div>
                            </div>
                            <div class="table-overflow">
                                <table class="table table-striped" id="data-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>ID</th>
                                            <th>Entered</th>
                                            <th>Ticket</th>
                                            <th>Cust</th>
                                            <th>Parturl</th>
                                            <th>Desc</th>
                                            <th>Price</th>
                                            
                                             <th>Store</th>
                                              <th>Bought</th>
                                               <th>Tracking</th>
                                               <th>Arrived</th>
                                            
                                            
                                            <th width="60">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql_parts_order=$obj->SelectAll($table);
										$i=1;
										if(!empty($sql_parts_order))
										foreach($sql_parts_order as $row):
										?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td> <?php echo $row->id; ?> </td>
                                            <td><label class="label label-success"> Inventory product 1 </label></td>
                                            <td><label class="label"> $200.00 </label></td>
                                            <td> <?php echo $row->retail_customer; ?> </td>
                                            <td> <?php echo $row->part_url; ?> </td>
                                            <td> True </td>
                                            <td> <?php echo $row->cost; ?> </td>
                                            <td> True </td>
                                            <td> True</td>
                                            <td> True </td>
                                            <td> 20 </td>
                                            <td>
                                                <a href="#" class="btn btn-danger hovertip" title="Delete"><i class="icon-remove"></i></a>
                                            </td>
                                        </tr>
                                        <?php 
										$i++;
										endforeach; 
										?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /default datatable -->
                                
                                
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
