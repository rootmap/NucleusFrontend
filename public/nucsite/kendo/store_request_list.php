<?php 
include('class/auth.php');
if($input_status==3 || $input_status==4)
{
	$obj->Error("Invalid Page Request.","index.php");
}
include('class/db_Class2.php');	
$obj_site = new db_class_site();
$table="store";
if(isset($_GET['del'])) 
{
    $obj_site->deletesing("id", $_GET['del'],$table);
}

function user_type($st)
{
	if($st==1)
	{
		return "Super Admin";	
	}
	elseif($st==2)
	{
		return "Shop Admin";	
	}
	elseif($st==3)
	{
		return "Cashier";	
	}
	elseif($st==4)
	{
		return "Store Manager";	
	}
}
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
                            <h5><i class="icon-tasks"></i> Store Request List </h5>
                            <ul class="icons">
    <li><a href="<?php echo $obj->filename(); ?>" class="hovertip" title="Reload"><i class="font-refresh"></i></a></li>
                            </ul>
                        </div><!-- /page header -->

                        <div class="body">

                            <!-- Middle navigation standard -->
                            <?php //include('include/quicklink.php');  ?>
                            <!-- /middle navigation standard -->
                            <a href="store.php" class="btn btn-success"><i class="icon-plus-sign"></i> Add New Store User</a>
                            <a href="store_list.php" class="btn btn-success"><i class="icon-tasks"></i> Store User / Admin List</a>
                            <a href="store_request_list.php" class="btn btn-success"><i class="icon-warning-sign"></i> Store Request List</a>
                            <a href="setup_list.php" class="btn btn-success"><i class="icon-warning-sign"></i> Set up</a>
                            <a href="notsetup_list.php" class="btn btn-success"><i class="icon-warning-sign"></i> Not set up</a>
                            <a href="cancel_store_list.php" class="btn btn-success"><i class="icon-warning-sign"></i> Cancel</a>
                            <!-- Content container -->
                            
                            <div class="container">
                                <!-- Content Start from here customized -->
                                
                                        <!-- General form elements -->    
                                                
                                                <div class="table-overflow">
                                                    <table class="table table-striped" id="data-table">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th> Store Name </th>
                                                                <th> First Name </th>
                                                                <th> Last Name </th>
                                                                <th> Phone </th>
                                                                <th> Email </th>
                                                                
                                                                <th> Password </th>
                                                                <th> Business Type </th>
                                                                <th width="60">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $sql_store=$obj_site->SelectAll("store");
															$i=1;
															if(!empty($sql_store))
															foreach($sql_store as $row):
															?>
                                                                <tr>
                                                                    <td><?php echo $i; ?></td>
                                                                    <td> <?php echo $row->store_name; ?> </td>
                                                                    <td><?php echo $row->f_name; ?> </td>
                                                                    <td><?php echo $row->l_name; ?> </td>
                                                                    <td> <?php echo $row->phone; ?> </td>
                                                                    <td> <?php echo $row->email; ?> </td>
                                                                    
                                                                    <td> <?php echo $row->password; ?> </td>
                                                                    <td> <?php echo $obj_site->SelectAllByVal("business_type","id",$row->business_type_id,"name"); ?> </td>
                                                                    <td>
                                                                    
                                                                    	<a href="store_request.php?edit=<?php echo $row->id; ?>" class="hovertip" title="Delete" onclick="javascript:return confirm('Are you absolutely sure to Edit This Store Detail?')"><i class="icon-edit"></i></a>
                                                                        <a href="<?php echo $obj->filename(); ?>?del=<?php echo $row->id; ?>" class="hovertip" title="Delete" onclick="javascript:return confirm('Are you absolutely sure to delete This?')"><i class="icon-trash"></i></a>
                                                                    </td>
                                                                </tr>
                                                            <?php 
															$i++;
															endforeach; ?>
                                                        </tbody>
                                                    </table>
                                                </div>



                                        <!-- Default datatable -->

                                        <!-- /default datatable -->

                            <!-- /content container -->
</div>
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
