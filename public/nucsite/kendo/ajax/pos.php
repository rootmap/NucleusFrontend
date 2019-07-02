<?php
include('../class/auth.php');
include('../class/pos_class.php');
$obj_pos = new pos();
extract($_GET);
$error="<label class='label label-danger'>Failed Reload Page</label>";
if($st==1)
{
	if($obj->update("pos_tax",array("invoice_id"=>$invoice_id,"status"=>$status))==1)
	{ echo "Success";	}
	else
	{ echo "Error";	}
}
elseif($st==2)
{
	echo  "";
}
elseif($st==3)
{
	if($obj_pos->cashier_login(@$_SESSION['SESS_CASHIER_ID'])==1)
	{
		$cashier_id=$_SESSION['SESS_CASHIER_ID'];
		$time=date('g:i:s A');
		$chkpunch=$obj->exists_multiple("store_punch_time",array("sid"=>$input_by,"status"=>1));
		if($chkpunch==1)
		{
			
			$punchid=$obj->SelectAllByVal2("store_punch_time","sid",$input_by,"status",1,"id");
			$obj->update("store_punch_time",array("id"=>$punchid,"cashier_id"=>$cashier_id,"store_id"=>$input_by,"outdate"=>$date,"outtime"=>$time,"status"=>2));
			?>
			<div class="table-overflow">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Date IN</th>
						<th>Time In</th>
						<th>Date Out</th>
						<th>Time Out</th>
						<th>Elapsed Time (HH:MM)</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$sql_product=$obj->SelectAllByID_Multiple("store_punch_time",array("date"=>date('Y-m-d'),"cashier_id"=>$cashier_id));
					$i=1;
					if(!empty($sql_product))
					foreach($sql_product as $product):
					?>
					<tr>
						<td><label class="label"> <?php echo $product->indate; ?> </label></td>
						<td><label class="label"> <?php echo $product->intime; ?> </label></td>
						<td><label class="label"> <?php echo $product->outdate; ?> </label></td>
						<td><label class="label"> <?php echo $product->outtime; ?> </label></td>
						<td><?php echo $obj->durations($product->indate." ".$product->intime,$product->outdate." ".$product->outtime); ?></td>
					</tr>
					<?php 
					$i++;
					endforeach; ?>
				</tbody>
			</table>
			</div>
			<?php
		}
		else
		{
			$obj->insert("store_punch_time",array("sid"=>$input_by,"store_id"=>$input_by,"indate"=>$date,"cashier_id"=>$cashier_id,"intime"=>$time,"status"=>1,"date"=>date('Y-m-d')));
			?>
			<div class="table-overflow">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Date IN</th>
							<th>Time In</th>
							<th>Date Out</th>
							<th>Time Out</th>
							<th>Elapsed Time (HH:MM)</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$sql_product=$obj->SelectAllByID_Multiple("store_punch_time",array("sid"=>$input_by,"date"=>date('Y-m-d'),"cashier_id"=>$cashier_id));
						$i=1;
						if(!empty($sql_product))
						foreach($sql_product as $product):
						?>
						<tr>
							<td><?php echo $product->indate; ?></td>
							<td><?php echo $product->intime; ?></td>
							<td><?php echo $product->outdate; ?></td>
							<td><?php echo $product->outtime; ?></td>
							<td>
							<?php
							if($product->outdate!='')
							{
					   echo $obj->durations($product->indate." ".$product->intime,$product->outdate." ".$product->outtime);	
							}
							?>
							</td>
						</tr>
						<?php 
						$i++;
						endforeach; ?>
					</tbody>
				</table>
			</div>
			<?php
		}
	}
	else
	{
		echo $obj_pos->cashier_login(@$_SESSION['SESS_CASHIER_ID']);	
	}
}
else
{
	echo $error;	
}
?>