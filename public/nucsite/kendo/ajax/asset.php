<?php
include('../class/auth.php');
extract($_GET);
$table="asset";
$table2="ticket_asset";
$success="<label class='label label-success'>Successfully Saved</label>";
$success2="<label class='label label-success'>Success Deleted</label>";
$updated="<label class='label label-success'>Shopping Cart Updated</label>";
$error="<label class='label label-danger'>Failed, Please Reload Page</label>";
$error2="<label class='label label-danger'>Already Exists</label>";
if($st==1)
{
	$ex=$obj->exists_multiple($table,array("uid"=>$input_by,"asset_type_id"=>$type_id,"name"=>$asset_name));
	if($ex==0)
	{
		if($obj->insert($table,array("uid"=>$input_by,"asset_type_id"=>$type_id,"name"=>$asset_name,"serial_number"=>$serial_number,"make"=>$make,"model"=>$model,"service_tag"=>$service_tag,"date"=>date('Y-m-d'),"status"=>1))==1)
		{
			echo $success;
		}
		else
		{
			echo $error;
		}
	}
	else
	{
		echo $error2;	
	}
}
elseif($st==2)
{
	$sqlasset=$obj->SelectAll($table);
	if(!empty($sqlasset))
	foreach($sqlasset as $asset):
	?>
    <div class="label" style="margin-top:5px;"><?php echo $asset->name; ?>
    	<button onClick="edit_asset('<?php echo $asset->id; ?>')" style="border:none; background:none;" type="button">
       	 <i class="icon-edit"></i>
        </button> 
        <button onClick="delete_asset('<?php echo $asset->id; ?>')" style="border:none; background:none;" type="button">
            <i class="icon-remove"></i>
        </button>
    </div>
    <?php
	endforeach;
}
elseif($st==22)
{
	?>
    <option value=""></option>
	<?php 
	$sqlassettype=$obj->SelectAll("asset");
    if(!empty($sqlassettype))
    foreach($sqlassettype as $assettype):
    ?>
    <option value="<?php echo $assettype->id; ?>">
    <?php echo $assettype->name; ?>
    </option>
    <?php  
    endforeach;
}
elseif($st==8)
{
	?>
    <option value=""></option>
	<?php 
	$sqlassettype=$obj->SelectAll("asset");
    if(!empty($sqlassettype))
    foreach($sqlassettype as $assettype):
	$ex=$obj->exists_multiple("ticket_asset",array("ticket_id"=>$tid,"asset_id"=>$assettype->id));
	if($ex==0){
		?>
		<option value="<?php echo $assettype->id; ?>">
		<?php echo $assettype->name; ?>
		</option>
		<?php  
	}
    endforeach;
}
elseif($st==3)
{
	if($obj->delete($table,array("id"=>$id))==1)
	{
		echo $success2;
	}
	else
	{
		echo $error;
	}
}
elseif($st==9)
{
	if($obj->delete($table2,array("id"=>$id))==1)
	{
		echo $success2;
	}
	else
	{
		echo $error;
	}
}
elseif($st==4)
{
	?>
    <div class="control-group">
        <label class="control-label">Asset Type</label>
        <div class="controls">
            <select id="type_id" onChange="asset_type(this.value)" name="select2" class="style" >
                <?php
				$assettype_id=$obj->SelectAllByVal("asset","id",$id,"asset_type_id"); 
$sqlassettype=$obj->SelectAll("asset_type");
                if(!empty($sqlassettype))
                foreach($sqlassettype as $assettype):
                ?>
                <option <?php if($assettype_id==$assettype->id){ ?> selected="selected" <?php } ?> value="<?php echo $assettype->id; ?>">
                <?php echo $assettype->name; ?>
                </option>
                <?php  
                endforeach;
                ?>
                <option value="0">Add New</option>
            </select>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label">Asset Name:</label>
        <div class="controls"><input id="asset_name" value="<?php echo $obj->SelectAllByVal("asset","id",$id,"name"); ?>" type="text" name="regular" class="span12" /></div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Serial Number:</label>
        <div class="controls"><input id="serial_number"  value="<?php echo $obj->SelectAllByVal("asset","id",$id,"serial_number"); ?>" type="text" name="regular" class="span12" /></div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Make:</label>
        <div class="controls"><input id="make" value="<?php echo $obj->SelectAllByVal("asset","id",$id,"make"); ?>" type="text" name="regular" class="span12" /></div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Model:</label>
        <div class="controls"><input id="model" value="<?php echo $obj->SelectAllByVal("asset","id",$id,"model"); ?>" type="text" name="regular" class="span12" /></div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Service Tag:</label>
        <div class="controls"><input id="service_tag" type="text" value="<?php echo $obj->SelectAllByVal("asset","id",$id,"service_tag"); ?>" name="regular" class="span12" /></div>
    </div>
    
    <div class="control-group">
        <button type="button" class="btn btn-info" onclick="update_asset(<?php echo $id; ?>)"><i class="icon-edit"></i> Update</button>
    </div>
    <?php
}
elseif($st==5)
{
	$ex=$obj->exists_multiple($table,array("uid"=>$input_by,"asset_type_id"=>$type_id,"name"=>$asset_name));
	if($ex==0)
	{
		if($obj->update($table,array("id"=>$id,"uid"=>$input_by,"asset_type_id"=>$type_id,"name"=>$asset_name,"serial_number"=>$serial_number,"make"=>$make,"model"=>$model,"service_tag"=>$service_tag,"date"=>date('Y-m-d'),"status"=>1))==1)
		{
			echo $success2;
		}
		else
		{
			echo $error;
		}
	}
	else
	{
		echo $error2;	
	}
}
elseif($st==6)
{
	$ex=$obj->exists_multiple($table2,array("uid"=>$input_by,"ticket_id"=>$tid,"asset_id"=>$id));
	if($ex==0)
	{
		if($obj->insert($table2,array("uid"=>$input_by,"ticket_id"=>$tid,"asset_id"=>$id,"date"=>date('Y-m-d'),"status"=>1))==1)
		{
			echo $success;
		}
		else
		{
			echo $error;
		}
	}
	else
	{
		echo $error2;	
	}
}
elseif($st==7)
{
	$sqlassetlist=$obj->SelectAllByID_Multiple("ticket_asset",array("ticket_id"=>$tid));
	if(!empty($sqlassetlist))
	foreach($sqlassetlist as $assetlist): ?>
	<label class="label"><?php echo $obj->SelectAllByVal("asset","id",$assetlist->asset_id,"name"); ?> 
		<button onClick="delete_ticket_asset('<?php echo $assetlist->id; ?>','<?php echo $tid; ?>')"  style="border:none; background:none;" type="button">
			<i class="icon-remove"></i>
		</button>
	</label>
	<?php 
	endforeach;
}
else
{
	echo $error;	
}
?>