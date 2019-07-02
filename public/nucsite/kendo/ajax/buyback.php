<style type="text/css">
select {
    padding:3px;
    margin: 0;
    -webkit-border-radius:4px;
    -moz-border-radius:4px;
    border-radius:4px;
    -webkit-box-shadow: 0 3px 0 #ccc, 0 -1px #fff inset;
    -moz-box-shadow: 0 3px 0 #ccc, 0 -1px #fff inset;
    box-shadow: 0 3px 0 #ccc, 0 -1px #fff inset;
    background: #f8f8f8;
    color:#888;
    border:none;
    outline:none;
    display: inline-block;
    -webkit-appearance:none;
    -moz-appearance:none;
    appearance:none;
    cursor:pointer;
	width:120px;
	height:20px;
}

/* Targetting Webkit browsers only. FF will show the dropdown arrow with so much padding. */
@media screen and (-webkit-min-device-pixel-ratio:0) {
    select {padding-right:18px}
}

</style>
<?php
include('../class/auth.php');
$table="ticket_custom_selection";
$table2="ticket_custom_field";
extract($_GET);
if($st==1)
{
	if($obj->insert($table,array("ticket_id"=>$ticket_id,"fid"=>$fid))==1)
	{
		?>
        <div class="clear block"></div>
        <?php
		$sqllist=$obj->SelectAllByID_Multiple($table,array("ticket_id"=>$ticket_id));
		if(!empty($sqllist)){
		foreach($sqllist as $list): ?>
        <span class="span4">
            <label class="checkbox" onClick="custom_field_select_delete(<?php echo $list->id; ?>,<?php echo $ticket_id; ?>,<?php echo $list->id; ?>,'all_selected_custom','lastnewsscroll')">
                <div id="uniform-undefined" class="checker">
                    <span class="checked"><input style="opacity: 0;" name="<?php echo $list->id; ?>" id="<?php echo $list->id; ?>" class="style" type="checkbox" value="<?php echo $list->id; ?>" checked></span>
                </div> 
                <?php echo $obj->SelectAllByVal($table2,"id",$list->fid,"name"); ?>
            </label>
        </span>
        <?php
		endforeach;	
		}
		else
		{
			echo "<h1 class='pull-center'>No Data Found</h1>";
		}
	}
	else
	{
		echo "Please, Reload Page";	
	}
}
elseif($st==2)
{
	?>
	<?php
	$sqlshowcustomfields=$obj->SelectAllByID_Multiple($table2,array("uid"=>1));
	if(!empty($sqlshowcustomfields))
	foreach($sqlshowcustomfields as $fields):
	$exfields=$obj->exists_multiple("ticket_custom_selection",array("fid"=>$fields->id,"ticket_id"=>$ticket_id));
	if($exfields==0){
	?>
	<label onClick="custom_field_select(<?php echo $ticket_id; ?>,<?php echo $fields->id; ?>,'all_selected_custom','lastnewsscroll')" class="checkbox"><div id="uniform-undefined" class="checker">
			<span><input style="opacity: 0;"  class="style" type="checkbox" value="<?php echo $fields->id; ?>"></span>
		</div> <?php echo $fields->name; ?>
	</label>
	<?php 
	}
	endforeach;
}
elseif($st==3)
{
	if($obj->delete($table,array("id"=>$sid))==1)
	{
		?>
        <div class="clear block"></div>
        <?php
		$sqllist=$obj->SelectAllByID_Multiple($table,array("ticket_id"=>$ticket_id));
		if(!empty($sqllist)){
			foreach($sqllist as $list): ?>
			<span class="span4">
				<label class="checkbox" onClick="custom_field_select_delete(<?php echo $list->id; ?>,<?php echo $ticket_id; ?>,<?php echo $list->id; ?>,'all_selected_custom','lastnewsscroll')">
					<div id="uniform-undefined" class="checker">
						<span class="checked"><input style="opacity: 0;" name="<?php echo $list->id; ?>" id="<?php echo $list->id; ?>" class="style" type="checkbox" value="<?php echo $list->id; ?>" checked></span>
					</div> 
					<?php echo $obj->SelectAllByVal($table2,"id",$list->fid,"name"); ?>
				</label>
			</span>
			<?php
			endforeach;	
		}
		else
		{
			echo "<h1 class='pull-center'>No Data Found</h1>";	
		}
	}
	else
	{
		echo "Please, Reload Page";	
	}
}
elseif($st==4)
{
	$auto_id=time();
	$chk=$obj->SelectAllByVal($table,$field,$ticket_id,$status);
	?>
    <select name="<?php echo $auto_id; ?>" id="<?php echo $auto_id; ?>" onchange="TicketStatusChange('<?php echo $table; ?>','<?php echo $field; ?>','<?php echo $ticket_id; ?>','status','<?php echo $auto_id; ?>','<?php echo $fetchplace; ?>')">
    	<option <?php echo $obj->selected($chk,1); ?> value="1">New</option>
        <option <?php echo $obj->selected($chk,2); ?> value="2">In Progress</option>
        <option <?php echo $obj->selected($chk,3); ?> value="3">Resolved</option>
        <option <?php echo $obj->selected($chk,4); ?> value="4">Invoiced</option>
        <option <?php echo $obj->selected($chk,5); ?> value="5">Waiting For Parts</option>
        <option <?php echo $obj->selected($chk,6); ?> value="6">Waiting on Customer</option>
        <option <?php echo $obj->selected($chk,7); ?> value="7">Scheduled</option>
        <option <?php echo $obj->selected($chk,8); ?> value="8">Customer Reply</option>
    </select>
    <?php
}
elseif($st==5)
{
	?>
	<span onclick="TicketStatus('<?php echo $table; ?>','<?php echo $field; ?>','<?php echo $val; ?>','<?php echo $uval; ?>','			<?php echo $fetchplace; ?>')">
	<?php
	if($obj->update($table,array($field=>$val,$ufield=>$uval))==1)
	{
		echo "<label class='label label-success'>".$obj->ticket_status($uval)."</label>";
	}
	else
	{
		echo "<label class='label label-success'>".$obj->ticket_status($uval)."</label>";
	}
	?>
	</span>
	<?php
}
elseif($st==404)
{
	$auto_id=time();
	$chk=$obj->SelectAllByVal($table,$field,$ticket_id,$status);
	?>
    <select name="<?php echo $auto_id; ?>" id="<?php echo $auto_id; ?>" onchange="TicketPaymentChange('<?php echo $table; ?>','<?php echo $field; ?>','<?php echo $ticket_id; ?>','payment','<?php echo $auto_id; ?>','<?php echo $fetchplace; ?>')">
    	<option <?php echo $obj->selected($chk,1); ?> value="1">Paid</option>
        <option <?php echo $obj->selected($chk,2); ?> value="2">Not Paid</option>
        <option <?php echo $obj->selected($chk,3); ?> value="3">Partial</option>
    </select>
    <?php
}
elseif($st==505)
{
	?>
	<span onclick="TicketPayment('<?php echo $table; ?>','<?php echo $field; ?>','<?php echo $val; ?>','<?php echo $uval; ?>','			<?php echo $fetchplace; ?>')">
	<?php
	
	if($obj->update($table,array($field=>$val,$ufield=>$uval))==1)
	{
		echo "<label class='label label-success'>".$obj->ticket_payment_status($uval)."</label>";
		if($uval==3)
		{ 
			?>
            <div class="clear"></div>
            <form method="post" action="view_ticket.php">
            <label id="partial_payment"> <strong>Partial Amount </strong> 
            <input name="amount" type="text" style="padding-top:2px; padding-bottom:2px; width:100px; margin-left:10px;" placeholder="Type Partial Paid Amount " />
            <input name="ticket_id" type="hidden" value="<?php echo $val; ?>"  />
            
            <button name="partial" style="margin-top:-1px; margin-left:10px;" class="btn btn-info" type="submit" onclick="TicketPaymentChangeSave('<?php echo $val; ?>')"><i class="icon-check"></i></button></label>
            </form>
            <?php
		}
		
	}
	else
	{
		echo "<label class='label label-success'>".$obj->ticket_payment_status($uval)."</label>";
		if($uval==3)
		{ 
			?>
            <div class="clear"></div>
            <form method="post" action="view_ticket.php">
            <label id="partial_payment"> <strong>Partial Amount </strong> 
            <input name="amount" type="text" style="padding-top:2px; padding-bottom:2px; width:100px; margin-left:10px;" placeholder="Type Partial Paid Amount " />
            <input name="ticket_id" type="hidden" value="<?php echo $val; ?>"  />
            
            <button name="partial" style="margin-top:-1px; margin-left:10px;" class="btn btn-info" type="submit" onclick="TicketPaymentChangeSave('<?php echo $val; ?>')"><i class="icon-check"></i></button></label>
            </form>
            <?php
		}
		
	}
	?>
	</span>
	<?php
}
elseif($st==6)
{
	$auto_id=time();
	$chk=$obj->SelectAllByVal($table,$field,$ticket_id,$status);
	?>
    <select name="<?php echo $auto_id; ?>" id="<?php echo $auto_id; ?>"  onchange="TicketProblemChange('<?php echo $table; ?>','<?php echo $field; ?>','<?php echo $ticket_id; ?>','status','<?php echo $auto_id; ?>','<?php echo $fetchplace; ?>')">
    	<?php 
		$sqlproblem=$obj->SelectAll("problem_type");
		if(!empty($sqlproblem))
		foreach($sqlproblem as $problem): ?>
    	<option <?php echo $obj->selected($chk,$problem->id); ?> value="<?php echo $problem->id; ?>"><?php echo $problem->name; ?></option>
        <?php endforeach; ?>
    </select>
    <?php
}
elseif($st==7)
{
	?>
<span onclick="TicketProblem('<?php echo $table; ?>','<?php echo $field; ?>','<?php echo $val; ?>','<?php echo $uval; ?>','<?php echo $fetchplace; ?>')">
	<?php
	if($obj->update($table,array($field=>$val,"problem_type"=>$uval))==1)
	{
		echo "<label class='label label-success'>".$obj->SelectAllByVal("problem_type","id",$uval,"name")."</label>"; 
	}
	else
	{
		echo "<label class='label label-success'>".$obj->SelectAllByVal("problem_type","id",$uval,"name")."</label>"; 
	}
	?>
	</span>
	<?php
}
elseif($st==8)
{
	$auto_id=time();
	$chk=$obj->SelectAllByVal($table,$field,$ticket_id,$status);
	?>
    <select name="<?php echo $auto_id; ?>" onchange="TicketWorkChange('<?php echo $table; ?>','<?php echo $field; ?>','<?php echo $ticket_id; ?>','<?php echo $status; ?>','<?php echo $auto_id; ?>','<?php echo $fetchplace; ?>')" id="<?php echo $auto_id; ?>">
    	<option <?php echo $obj->selected($chk,1); ?> value="1">Yes</option>
        <option <?php echo $obj->selected($chk,0); ?> value="0">No</option>
    </select>
    <?php
}
elseif($st==18)
{
	$auto_id=time();
	$chk=$obj->SelectAllByVal($table,$field,$ticket_id,$status);
	?>
    <select name="<?php echo $auto_id; ?>" onchange="LcdWorkChange('<?php echo $table; ?>','<?php echo $field; ?>','<?php echo $ticket_id; ?>','<?php echo $status; ?>','<?php echo $auto_id; ?>','<?php echo $fetchplace; ?>')" id="<?php echo $auto_id; ?>">
    	<option <?php echo $obj->selected($chk,1); ?> value="1">Good</option>
        <option <?php echo $obj->selected($chk,2); ?> value="2">Bad</option>
    </select>
    <?php
}
elseif($st==80)
{
	$auto_id=time();
	$chk=$obj->SelectAllByVal($table,$field,$ticket_id,$status);
	?>
    <select name="<?php echo $auto_id; ?>" onchange="WarrentyChange('<?php echo $table; ?>','<?php echo $field; ?>','<?php echo $ticket_id; ?>','<?php echo $status; ?>','<?php echo $auto_id; ?>','<?php echo $fetchplace; ?>','<?php echo $pid; ?>')" id="<?php echo $auto_id; ?>">
    	<?php 
		$warrenty=$obj->SelectAllByVal("product","id",$pid,"warranty");
		for($i=0; $i<=$warrenty; $i++):
		?>
    	<option value="<?php echo $i; ?>"> <?php echo $i; ?> Month</option>
        <?php 
		endfor; ?>
    </select>
    <?php
}
elseif($st==9)
{
	?>
	<span onclick="TicketWork('<?php echo $table; ?>','<?php echo $field; ?>','<?php echo $val; ?>','<?php echo $uval; ?>','<?php echo $fetchplace; ?>')">
	<?php
	if($uval==1){ $ff="Yes"; }else{ $ff="No"; }
	if($obj->update($table,array($field=>$val,$ufield=>$uval))==1)
	{
		echo "<label>".$ff."</label>";
	}
	else
	{
		echo "<label>".$ff."</label>";
	}
	?>
	</span>
	<?php
}
elseif($st==19)
{
	?>
	<span onclick="LcdWork('<?php echo $table; ?>','<?php echo $field; ?>','<?php echo $val; ?>','<?php echo $uval; ?>','<?php echo $fetchplace; ?>')">
	<?php
	if($uval==1){ $ff="Good"; }else{ $ff="Bad"; }
	if($obj->update($table,array($field=>$val,$ufield=>$uval))==1)
	{
		echo "<label>".$ff."</label>";
	}
	else
	{
		echo "<label>".$ff."</label>";
	}
	?>
	</span>
	<?php
}
elseif($st==99)
{
	?>
	<span onclick="Warrenty('<?php echo $table; ?>','<?php echo $field; ?>','<?php echo $val; ?>','<?php echo $uval; ?>','<?php echo $fetchplace; ?>','<?php echo $pid; ?>')">
	<?php
	$warrenty=$obj->SelectAllByVal("product","id",$pid,"warranty");
	if($obj->update($table,array($field=>$val,$ufield=>$uval))==1)
	{
		echo "<label>".$uval." Month</label>";
	}
	else
	{
		echo "<label>".$uval." Month</label>";
	}
	?>
	</span>
	<?php
}
else
{
	echo "Error, Please Reload Page";	
}
?>