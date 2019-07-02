<?php
include('../class/auth.php');
extract($_GET);
$table = "checkin_version";
if ($st==1){
	if($input_status==1)
	{
    	$sql_checkin = $obj->SelectAllByID_Multiple("checkin_version",array("checkin_id"=>$check_id));
	}
	else
	{
		$sql_checkin = $obj->SelectAllByID_Multiple("checkin_version_store",array("checkin_id"=>$check_id,"store_id"=>$input_by));
	}
    if (!empty($sql_checkin))
    foreach ($sql_checkin as $checkin):
        ?>
        <option  value="<?php echo $checkin->id; ?>"><?php echo $checkin->name; ?></option> 
        <?php
    endforeach;
}
elseif($st==2){
	if($input_status==1)
	{
    	$sql_checkin = $obj->SelectAllByID_Multiple("checkin_problem",array("checkin_id"=>$check_id));
	}
	else
	{
		$sql_checkin = $obj->SelectAllByID_Multiple("checkin_problem_store",array("checkin_id"=>$check_id,"store_id"=>$input_by));
	}
	if (!empty($sql_checkin))
    foreach ($sql_checkin as $checkin):
        ?>
        <option  value="<?php echo $checkin->id; ?>"><?php echo $checkin->name; ?></option> 
        <?php
    endforeach;
}
elseif($st==3){
    if($obj->update("invoice",array("invoice_id"=>$cart,"cid"=>$cid))==1)
    {
        echo "Customer Saved";
    }
    else 
    {
        echo "Customer Not Saved";
    }
}
else
{
    ?>
        <option value="">Select Option</option>    
    <?php
}
?>