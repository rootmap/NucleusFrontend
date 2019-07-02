<?php
include('../class/auth.php');
$table="checkin_version";
extract($_GET);
if($v!='')
{
	?>
    <option value=""></option> 
    <?php
	if($input_status==1)
	{
		$data=$obj->SelectAllByID_Multiple($table,array("checkin_id"=>$v,"store_id"=>$input_by));
	}
	else
	{
		$data=$obj->SelectAllByID_Multiple("checkin_version_store",array("checkin_id"=>$v,"store_id"=>$input_by));
	}
	if(!empty($data))
	foreach($data as $rr)
	{
		?>
        <option value="<?php echo $rr->id; ?>"><?php echo $rr->name; ?></option>
        <?php	
	}
}
else
{
	echo "wrong";	
}

?>