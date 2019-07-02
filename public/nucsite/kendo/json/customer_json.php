<?php
include('../class/auth.php');
if($_POST)
{
	
	if($_POST["fetch"]==1)
	{
	    if($input_status==1)
	    {
			$sql_coustomer=$obj->SelectAll("coustomer");
		}
		else
		{
			$sql_coustomer=$obj->SelectAllByID("coustomer",array("input_by"=>$input_by));
		}
		$i=1;
		if(!empty($sql_coustomer))
		foreach($sql_coustomer as $customer): 
		?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $customer->id; ?></td>
			<td><?php echo $customer->firstname; ?> <?php echo $customer->lastname; ?></td>
			<td><?php echo $customer->email; ?></td>
			<td><?php echo $customer->phone; ?></td>
			<td>
			 <?php if($input_status==1 || $input_status==2){ ?>   
			 <a href="customer.php?edit=<?php echo $customer->id; ?>" class="hovertip"   onclick="javascript:return confirm('Are you absolutely sure to Edit This?')" title="Edit Detail"><i class="icon-edit"></i></a> <a href="<?php echo $obj->filename(); ?>?del=<?php echo $customer->id; ?>" class="hovertip"  onclick="javascript:return confirm('Are you absolutely sure to delete This?')" title="Delete"><i class="icon-trash"></i></a>
			 <?php } ?> 
				
			</td>
		</tr>
		<?php 
		$i++;
		endforeach;
	}
	else
	{
		header('HTTP/1.1 500 Are you kiddin me? Empty Not Allowed To Submit');
    	exit();
	}
}