<?php
include('class/auth.php');
include('class/db_Class2.php');
$obj_site=new db_class_site();
$table="business_type";
$destination="store";
if(isset($_POST['create']))
{
	extract($_POST);
	if(!empty($name))
	{
			$chks=$obj_site->exists_multiple($table,array("name"=>$name));
			if($chks==0)
			{

					if($obj_site->insert($table,array("name"=>$name,"date"=>date('Y-m-d'),"status"=>1))==1)
					{
						$obj_site->Success("Business Type Name Successfully Saved", $obj->filename());
					}
					else
					{
						$obj_site->Error("Something is wrong,Please Try again.", $obj->filename());
					}
			}
			else
			{
				$obj_site->Error("Already, Exists ", $obj->filename());		
			}
	}
	else
	{
		$obj_site->Error("Failed, Fill up required field", $obj->filename());
	}
}

if(isset($_POST['editcreate']))
{
	extract($_POST);
	if(!empty($name))
	{
			$chks=$obj_site->exists_multiple($table,array("id"=>$id));
			if($chks==1)
			{

					if($obj_site->update($table,array("id"=>$id,"name"=>$name))==1)
					{
						$obj_site->Success("Business Type Name Successfully Saved", $obj->filename()."?edit=".$_GET['edit']);
					}
					else
					{
						$obj_site->Error("Something is wrong,Please Try again.", $obj->filename()."?edit=".$_GET['edit']);
					}
			}
			else
			{
				$obj_site->Error("Already, Exists ", $obj->filename()."?edit=".$_GET['edit']);		
			}
	}
	else
	{
		$obj_site->Error("Failed, Fill up required field", $obj->filename()."?edit=".$_GET['edit']);
	}
}

if(isset($_GET['del']))
{
	$obj_site->deletesing("id",$_GET['del'],"business_type");	
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
                            <h5><i class="font-plus-sign"></i> Business Type Info </h5>
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
							
                            <form class="form-horizontal" method="post" enctype="multipart/form-data" name="invoice" action="">
                                    <fieldset>
                                        <!-- General form elements -->
                                        <div class="row-fluid  span12 well">     
                                           <!-- Selects, dropdowns -->
                                            <div class="span6" style="padding:0px; margin:0px;">
                                                <?php if(isset($_GET['edit'])){ ?>
                                                <input type="hidden" name="id" value="<?php echo $_GET['edit']; ?>">
                                                <div class="control-group">
                                                    <label class="span4"> * Business Type Name:</label>
                                                    <div class="span8"><input value="<?php echo $obj_site->SelectAllByVal("business_type","id",$_GET['edit'],"name"); ?>" placeholder="Business Type Name" class="span12" type="text" name="name" /></div>
                                                </div>
                                                
                                                <div class="control-group">
                                                    <button type="submit" name="editcreate" class="btn btn-success">
                                                    <i class="icon-plus-sign"></i>Save Business Type </button>
                                                </div>
                                                <?php }else{ ?>
                                                <div class="control-group">
                                                    <label class="span4"> * Business Type Name:</label>
                                                    <div class="span8"><input placeholder="Business Type Name" class="span12" type="text" name="name" /></div>
                                                </div>
                                                
                                                <div class="control-group">
                                                    <button type="submit" name="create" class="btn btn-success">
                                                    <i class="icon-plus-sign"></i>Save Business Type </button>
                                                </div>
                                                <?php } ?>
                                            </div>
                                            <!-- /selects, dropdowns -->



                                            <!-- Selects, dropdowns -->
                                            <div class="span6" style="padding:0px; margin:0px; float:right;">
                                                
                                                <div class="table-overflow">
                                                    <table class="table table-striped" id="data-table">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th> Name </th>
                                                                <th> Date </th>
                                                                <th width="60">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $sql_store=$obj_site->SelectAll("business_type");
															$i=1;
															if(!empty($sql_store))
															foreach($sql_store as $row):
															?>
                                                                <tr>
                                                                    <td><?php echo $i; ?></td>
                                                                    <td> <?php echo $row->name; ?> </td>
                                                                    <td><?php echo $row->date; ?> </td>
                                                                    <td>
                                                                    
                                                                    	<a href="<?php echo $obj->filename(); ?>?edit=<?php echo $row->id; ?>" class="hovertip" title="Delete" onclick="javascript:return confirm('Are you absolutely sure to Edit This Detail?')"><i class="icon-edit"></i></a>
                                                                        <a href="<?php echo $obj->filename(); ?>?del=<?php echo $row->id; ?>" class="hovertip" title="Delete" onclick="javascript:return confirm('Are you absolutely sure to delete This?')"><i class="icon-trash"></i></a>
                                                                    </td>
                                                                </tr>
                                                            <?php 
															$i++;
															endforeach; ?>
                                                        </tbody>
                                                    </table>
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
<?php include('include/footer.php'); ?>
            <!-- Right sidebar -->
<?php //include('include/sidebar_right.php');  ?>
            <!-- /right sidebar -->

        </div>
        <!-- /main wrapper -->

    </body>
</html>
