<?php
class invoice_view
{
    function invoice_edit_row($table,$id,$val,$pre,$show_pre,$cid)
	{
		$obj_pos = new db_class();
		?>		
		<b id="<?php echo $show_pre; ?>">
	   <?php $cus_data=$obj_pos->SelectAllByVal($table,$id,$val,$pre); 
		 echo $obj_pos->invoice_tax_status($cus_data); ?>
		</b>
		<?php
	}

	function customer_edit($table,$val,$pre,$show_pre)
	{
		$obj_pos = new db_class();
		?>
		<b id="<?php echo $pre; ?>">
	   <?php $cus_data=$obj_pos->SelectAllByVal($table,"id",$val,$pre); 
		echo $cus_data; ?>
		</b>
		<?php
	}
	
	function invoice_edit($table,$id,$val,$pre,$show_pre)
	{ 
		$obj_pos = new db_class();
	?>
		<b id="<?php echo $pre; ?>">
	   <?php 
		echo $cus_data=$obj_pos->SelectAllByVal($table,$id,$val,$pre); 
		?>
		</b>
		<?php
	}
	
	function invoice_edit_two($table,$id,$val,$pre,$show_pre)
	{ 
	$obj_pos = new db_class();
	?>
		<b id="<?php echo $pre; ?>">
	   <?php 
		$cus_data=$obj_pos->SelectAllByVal($table,$id,$val,$pre); 
		echo $obj_pos->invoice_paid_status($cus_data);
		?>
		</b>
		<?php
	}	
    
}
?>
