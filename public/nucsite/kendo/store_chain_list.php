<?php
include('class/auth.php');
$table="store_chain_admin";
if(isset($_GET['del']))
{
	if($obj->delete($table,array("id"=>$_GET['del']))==1)
	{
		$obj->Success("Store Successfully Deleted From Chain Admin List.",$obj->filename());	
	}
	else
	{
		$obj->Error("Failed, Store Deletion Failed From Chain Admin List.",$obj->filename());
	}
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
	elseif($st==5)
	{
		return "Store Chain Admin";	
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
                            <h5><i class="icon-tasks"></i> Your Store List </h5>
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
                                
                                        <!-- General form elements -->    
                                                
                                                <div class="table-overflow">
                                                    <table class="table table-striped" id="data-table">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th> Store - ID </th>
                                                                <th> Store Name </th>
                                                                <th> Username </th>
                                                                <th> Email </th>
                                                                <th> Phone </th>
                                                                <th width="60">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
															if($input_status==1)
															{
                                                            	$sql_store=$obj->SelectAllByID("store_chain_admin",array("sid"=>$input_by));
															}
															else
															{
																$sql_store=$obj->SelectAllByID("store_chain_admin",array("sid"=>$input_by));
															}
															$i=1;
															if(!empty($sql_store))
															foreach($sql_store as $row):
															?>
                                                                <tr>
                                                                    <td><?php echo $i; ?></td>
                                                                    <td> <?php echo $row->store_id; ?> </td>
                                                                    <td><?php echo $obj->SelectAllByVal("shop_admin","store_id",$row->store_id,"name"); ?> </td>
                                                                    <td><?php echo $obj->SelectAllByVal("shop_admin","store_id",$row->store_id,"username"); ?> </td>
                                                                    <td> <?php echo $obj->SelectAllByVal("shop_admin","store_id",$row->store_id,"email"); ?> </td>
                                                                    <td> <?php echo $obj->SelectAllByVal("shop_admin","store_id",$row->store_id,"phone"); ?> </td>
                                                                    <td>
                                                                    <a href="<?php echo $obj->filename(); ?>?del=<?php echo $row->id; ?>" class="hovertip btn" title="Access Store" onclick="javascript:return confirm('Are you absolutely sure to access This?')"><i class="icon-trash"></i></a>
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
