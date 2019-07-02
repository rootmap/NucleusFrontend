<?php
include('class/auth.php');
$table="coustomer";
if(isset($_POST['create']))
{
	$xlfile=$obj->excel("file",time(),"exam");
	if($xlfile==0)
	{
		$obj->Error("This is not a Excel File PLease Upload excel file in 97/2003 format which has (.xls) extension",$obj->filename());	
	}
	
	include 'class/reader.php';
	$excel = new Spreadsheet_Excel_Reader();
	
	$excel->setOutputEncoding('CP1251');
	$excel->read('exam/'.$xlfile); 
	
	$s=0;
	$f=0;
	for($i=1; $i<=$excel->sheets[0]['numRows']; $i++)
	{

		if($i!=1)
		{
					/*@$exam_id=$excel->sheets[0]["cells"][$i][1];
					@$exam_name=$excel->sheets[0]["cells"][$i][2];	*/
					@$fval=$excel->sheets[0]["cells"][$i][2];
					
					if($fval!='')
						{
					
					$chk=$obj->exists_multiple("coustomer",array("firstname"=>@$excel->sheets[0]["cells"][$i][2],"lastname"=>@$excel->sheets[0]["cells"][$i][3], 
		"phone"=>@$excel->sheets[0]["cells"][$i][4], 
		"phonesms"=>@$excel->sheets[0]["cells"][$i][5], 
		"email"=>@$excel->sheets[0]["cells"][$i][6],
		"input_by"=>$input_by));
					if($chk==0)
					{
					//echo $exam_name."<br>";
					
						$s+=1;
						
						
						$obj->insert("coustomer",array("firstname"=>@$excel->sheets[0]["cells"][$i][2], 
		"lastname"=>@$excel->sheets[0]["cells"][$i][3], 
		"phone"=>@$excel->sheets[0]["cells"][$i][4], 
		"phonesms"=>@$excel->sheets[0]["cells"][$i][5], 
		"email"=>@$excel->sheets[0]["cells"][$i][6],
		"reffered"=>@$excel->sheets[0]["cells"][$i][7], 
		"businessname"=>@$excel->sheets[0]["cells"][$i][8], 
		"address1"=>@$excel->sheets[0]["cells"][$i][9], 
		"address2"=>@$excel->sheets[0]["cells"][$i][10], 
		"city"=>@$excel->sheets[0]["cells"][$i][11], 
		"country"=>1,
		"input_by"=>$input_by,
		"postalcode"=>@$excel->sheets[0]["cells"][$i][12], 
		"access_id"=>$access_id, 
		"date"=>date('Y-m-d'), 
		"status"=>1));
						
		/*	*/
					}
					else
					{
						$f+=1;
						$vid=$obj->SelectAllByVal4("coustomer","firstname",@$excel->sheets[0]["cells"][$i][2],
		"phone",@$excel->sheets[0]["cells"][$i][4], 
		"email",@$excel->sheets[0]["cells"][$i][6],
		"input_by",$input_by,"id");
						$obj->update("coustomer",array("id"=>$vid,"firstname"=>@$excel->sheets[0]["cells"][$i][2], 
		"lastname"=>@$excel->sheets[0]["cells"][$i][3], 
		"phone"=>@$excel->sheets[0]["cells"][$i][4], 
		"phonesms"=>@$excel->sheets[0]["cells"][$i][5], 
		"email"=>@$excel->sheets[0]["cells"][$i][6],
		"reffered"=>@$excel->sheets[0]["cells"][$i][7], 
		"businessname"=>@$excel->sheets[0]["cells"][$i][8], 
		"address1"=>@$excel->sheets[0]["cells"][$i][9], 
		"address2"=>@$excel->sheets[0]["cells"][$i][10], 
		"city"=>@$excel->sheets[0]["cells"][$i][11], 
		"country"=>1,
		"input_by"=>$input_by,
		"postalcode"=>@$excel->sheets[0]["cells"][$i][12]));	
					}	
						}
		}
		
	}
	//exit();
	$obj->Success($s."Customer Data imported Successfully, Inserted(".$s.") Updated (".$f.") ",$obj->filename());
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
                            <h5><i class="font-file"></i>Import Existing Customer Detail </h5>
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

                                
                                
                                
                                <!-- Content Start from here customized -->
                                
                           
                        <form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
                            <fieldset>

                            	<!-- General form elements -->
                                <div class="well row-fluid block">                                    
                                    <div class="control-group">
                                        <label class="control-label">Import File:</label>
                                        <div class="controls"><input class="style" type="file" name="file" /></div>
                                    </div>
                                    
                                    <div class="control-group">
                                       <label class="control-label">&nbsp;</label>
                                       <div class="controls">
                            <button type="submit" name="create" class="k-button"><i class="icon-ok"></i> Upload Excel File </button> 
                            <button type="reset" name="reset" class="k-button"><i class="icon-ban-circle"></i> Reset Form </button>
                            <a href="excelformat.xls" class="k-button"><i class="font-table"></i> Download Excel Format </a>
                                       </div>
                                    </div>
                                    
                                    
                                </div>
                                <!-- /general form elements -->
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
            <!-- Right sidebar -->
            <?php //include('include/sidebar_right.php'); ?>
            <!-- /right sidebar -->

        </div>
        <!-- /main wrapper -->

    </body>
</html>
