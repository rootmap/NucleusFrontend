<?php
include('class/auth.php');
if($_POST)
{
	if($_POST["fetch"]==101)
	{
		?>
        successfully ajax work
        
		</div>
		<?php
		$obj->close($obj->open());
		exit();
	}
	elseif($_POST["fetch"]==1)
	{
		if($input_status==1){  echo $obj->totalrows("coustomer");  }
		elseif($input_status==5)
		{
			
			$sqlchain_store_ids=$obj->SelectAllByID("store_chain_admin",array("sid"=>$input_by));
			if(!empty($sqlchain_store_ids))
			{
				$array_ch = array();
				foreach($sqlchain_store_ids as $ch):
					array_push($array_ch,$ch->store_id);
				endforeach;
				
				
					include('class/report_chain_admin.php');	
					$obj_report_chain = new chain_report();
					echo $obj_report_chain->SelectAllByID_Multiple_Or("customer_list",$array_ch,"input_by","0");
				
			}
			else
			{
				//echo "Not Work";
				echo  0;
			}
		}
		else{ echo $obj->exists_multiple("coustomer",array("input_by"=>$input_by)); }
	}
	elseif($_POST["fetch"]==2)
	{
		if($input_status==1){ echo $obj->totalrows("ticket"); }
		elseif($input_status==5)
		{
			
			$sqlchain_store_ids=$obj->SelectAllByID("store_chain_admin",array("sid"=>$input_by));
			if(!empty($sqlchain_store_ids))
			{
				$array_ch = array();
				foreach($sqlchain_store_ids as $ch):
					array_push($array_ch,$ch->store_id);
				endforeach;
				
				
					include('class/report_chain_admin.php');	
					$obj_report_chain = new chain_report();
					echo $obj_report_chain->SelectAllByID_Multiple_Or("ticket",$array_ch,"input_by","0");
				
			}
			else
			{
				//echo "Not Work";
				echo  0;
			}
		}
		else{ echo $obj->exists_multiple("ticket",array("input_by"=>$input_by)); }
	}
	elseif($_POST["fetch"]==3)
	{
		if($input_status==1){ echo $obj->totalrows("checkin_list"); }
		elseif($input_status==5)
		{
			
			$sqlchain_store_ids=$obj->SelectAllByID("store_chain_admin",array("sid"=>$input_by));
			if(!empty($sqlchain_store_ids))
			{
				$array_ch = array();
				foreach($sqlchain_store_ids as $ch):
					array_push($array_ch,$ch->store_id);
				endforeach;
				
				
					include('class/report_chain_admin.php');	
					$obj_report_chain = new chain_report();
					echo $obj_report_chain->SelectAllByID_Multiple_Or("checkin_list",$array_ch,"input_by","0");
				
			}
			else
			{
				//echo "Not Work";
				echo  0;
			}
		}
		else{ echo $obj->exists_multiple("checkin_list",array("input_by"=>$input_by)); 	 }
	}
	elseif($_POST["fetch"]==4)
	{
		if($input_status==1){ $sqlinvoice = $obj->SelectAllByID_Multiple("invoice", array("doc_type" => 3)); }
		elseif($input_status==5)
		{
			
			$sqlchain_store_ids=$obj->SelectAllByID("store_chain_admin",array("sid"=>$input_by));
			if(!empty($sqlchain_store_ids))
			{
				$array_ch = array();
				foreach($sqlchain_store_ids as $ch):
					array_push($array_ch,$ch->store_id);
				endforeach;
				
				
					include('class/report_chain_admin.php');	
					$obj_report_chain = new chain_report();
					$sqlinvoice="";
				
			}
			else
			{
				//echo "Not Work";
				$sqlinvoice="";
			}
		}
	    else{ $sqlinvoice=$obj->SelectAllByID_Multiple("invoice",array("doc_type" =>3,"input_by"=>$input_by));  }
		
		$inv3 = 0;
		$i = 1;
		if (!empty($sqlinvoice))
			foreach ($sqlinvoice as $invoice):
			if($input_status==1){ $sqlitem = $obj->SelectAllByID_Multiple("sales", array("sales_id" => $invoice->invoice_id)); }
			else{ $sqlitem = $obj->SelectAllByID_Multiple("sales", array("sales_id" => $invoice->invoice_id,"input_by"=>$input_by)); }
				$item_q = 0;
				$total = 0;
				if (!empty($sqlitem))
					foreach ($sqlitem as $item):
						$rr = $item->quantity * $item->single_cost;
						$taxchk = $obj->SelectAllByVal("pos_tax", "invoice_id", $invoice->invoice_id, "status");
						if ($taxchk == 0) {	$tax = 0; } else { $tax = ($rr * $tax_per_product) / 100; }
						$tot = $rr + $tax;
						$total+=$tot;
						$item_q+=$item->quantity;
					endforeach;
				if ($total != 0) { $inv3+=1; $i++; }

			endforeach;

			echo $inv3;
	}
	elseif($_POST['fetch']==5)
	{
		$inv2=0;
	   if($input_status==1){ $sqlinvoice = $obj->SelectAllByID_Multiple("invoice", array("doc_type" => 2)); }
	   elseif($input_status==5)
		{
			
			$sqlchain_store_ids=$obj->SelectAllByID("store_chain_admin",array("sid"=>$input_by));
			if(!empty($sqlchain_store_ids))
			{
				$array_ch = array();
				foreach($sqlchain_store_ids as $ch):
					array_push($array_ch,$ch->store_id);
				endforeach;
				
				
					include('class/report_chain_admin.php');	
					$obj_report_chain = new chain_report();
					$sqlinvoice=$obj_report_chain->SelectAllByID_Multiple2_Or("invoice",array("doc_type" =>2),$array_ch,"input_by","1");
				
			}
			else
			{
				//echo "Not Work";
				$sqlinvoice="";
			}
		}
	   else{ $sqlinvoice = $obj->SelectAllByID_Multiple("invoice",array("doc_type" =>2,"input_by"=>$input_by)); }
                          
			$i = 1;
			if (!empty($sqlinvoice))
				foreach ($sqlinvoice as $invoice):
				$sqlitem = $obj->SelectAllByID_Multiple("invoice_detail", array("invoice_id" => $invoice->invoice_id));
				$item_q = 0;
				$total = 0;
				if (!empty($sqlitem))
					foreach ($sqlitem as $item):
						$rr = $item->quantity * $item->single_cost;
						if ($item->tax != 0) {
							$tax = 0;
						} else {
							$tax = ($rr * $tax_per_product) / 100;
						}

						$tot = $rr + $tax;
						$total+=$tot;
						$item_q+=$item->quantity;
					endforeach;
				if ($total != 0) { $inv2=1;  $i++;  } 
				endforeach;
			echo $inv2;
	}
	elseif($_POST["fetch"]==6)
	{
		if($input_status==1){ echo $obj->totalrows("buyback"); }
		elseif($input_status==5)
		{
			
			$sqlchain_store_ids=$obj->SelectAllByID("store_chain_admin",array("sid"=>$input_by));
			if(!empty($sqlchain_store_ids))
			{
				$array_ch = array();
				foreach($sqlchain_store_ids as $ch):
					array_push($array_ch,$ch->store_id);
				endforeach;
				
				
					include('class/report_chain_admin.php');	
					$obj_report_chain = new chain_report();
					echo $obj_report_chain->SelectAllByID_Multiple_Or("buyback",$array_ch,"input_by","0");
				
			}
			else
			{
				//echo "Not Work";
				echo  0;
			}
		}
		else{ echo $obj->exists_multiple("buyback",array("input_by"=>$input_by)); 	 }
	}
	elseif($_POST["fetch"]==7)
	{
		if($input_status==1){ echo $obj->totalrows("unlock_request"); }
		elseif($input_status==5)
		{
			
			$sqlchain_store_ids=$obj->SelectAllByID("store_chain_admin",array("sid"=>$input_by));
			if(!empty($sqlchain_store_ids))
			{
				$array_ch = array();
				foreach($sqlchain_store_ids as $ch):
					array_push($array_ch,$ch->store_id);
				endforeach;
				
				
					include('class/report_chain_admin.php');	
					$obj_report_chain = new chain_report();
					echo $obj_report_chain->SelectAllByID_Multiple_Or("unlock_request",$array_ch,"input_by","0");
				
			}
			else
			{
				//echo "Not Work";
				echo  0;
			}
		}
		else{ echo $obj->exists_multiple("unlock_request",array("input_by"=>$input_by)); 	 }
	}
	elseif($_POST["fetch"]==8)
	{
		$sqlhighestsales=$obj->SelectAll("payment_method");
		$i=1;
		if(!empty($sqlhighestsales))
		foreach($sqlhighestsales as $highestsales):
		?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $highestsales->meth_name; ?></td>
			<td>$<strong><?php 
			if($input_status==1)
			{												
				$sqlpm=$obj->SelectAllByID("invoice_payment",array("payment_type"=>$highestsales->id));
			}
			elseif($input_status==5)
			{
				
				$sqlchain_store_ids=$obj->SelectAllByID("store_chain_admin",array("sid"=>$input_by));
				if(!empty($sqlchain_store_ids))
				{
					$array_ch = array();
					foreach($sqlchain_store_ids as $ch):
						array_push($array_ch,$ch->store_id);
					endforeach;
					
					
						include('class/report_chain_admin.php');	
						$obj_report_chain = new chain_report();
						$sqlpm=$obj_report_chain->SelectAllByID_Multiple2_Or("invoice_payment",array("payment_type"=>$highestsales->id),$array_ch,"input_by","0");
					
				}
				else
				{
					//echo "Not Work";
					$sqlpm="";
				}
			}
			else
			{
				$sqlpm=$obj->SelectAllByID_Multiple("invoice_payment",array("payment_type"=>$highestsales->id,"input_by"=>$input_by));	
			}
			$pmamo=0;
			if(!empty($sqlpm))
				foreach($sqlpm as $pmo):
				$pmamo+=$pmo->amount;
				endforeach;
			echo $obj->escape_empty($pmamo); ?></strong></td>
		</tr>
		<?php 
		$i++;
		endforeach;
	}
	elseif($_POST["fetch"]==9)
	{
		if($input_status==1){ $sqlhighestsales=$obj->SelectAllMax(0); }
		else{ $sqlhighestsales=$obj->SelectAllMax(5); }
		$i=1;
		if(!empty($sqlhighestsales))
		foreach($sqlhighestsales as $highestsales):
		?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $obj->SelectAllByVal("cashier_list","id",$highestsales->cashier_id,"name"); ?></td>
			<td><strong><?php echo $highestsales->totalcount; ?></strong> Item Sold</td>
		</tr>
		<?php 
		$i++;
		endforeach;
	}
	elseif($_POST["fetch"]==10)
	{
		if($input_status==1){ echo $obj->exists_multiple("transaction_log", array("date" =>date('Y-m-d'))); }
		elseif($input_status==5)
		{
			
			$sqlchain_store_ids=$obj->SelectAllByID("store_chain_admin",array("sid"=>$input_by));
			if(!empty($sqlchain_store_ids))
			{
				$array_ch = array();
				foreach($sqlchain_store_ids as $ch):
					array_push($array_ch,$ch->store_id);
				endforeach;
				
				
					include('class/report_chain_admin.php');	
					$obj_report_chain = new chain_report();
					echo $obj_report_chain->SelectAllByID_Multiple2_Or("transaction_log",array("date"=>date('Y-m-d')),$array_ch,"input_by","0");
				
			}
			else
			{
				//echo "Not Work";
				echo 0;
			}
		}
		else{ echo $obj->exists_multiple("transaction_log", array("date" =>date('Y-m-d'),"input_by"=>$input_by));	 }
	}
	elseif($_POST["fetch"]==11)
	{
		function tranaction_type($status)
		{
			if($status==1)
			{
				return "Store Opening Cash";	
			}
			elseif($status==2)
			{
				return "Payout/Drop/Sales";	
			}
			elseif($status==3)
			{
				return "Ticket/Checkin/Parts Order";	
			}
			elseif($status==4)
			{
				return "Sales";	
			}
			elseif($status==5)
			{
				return "Payout/Drop";	
			}
			elseif($status==6)
			{
				return "BuyBack";	
			}
			elseif($status==7)
			{
				return "Store Closing";	
			}
		}
		
		function tender_type($status)
		{
			if($status==1)
			{
				return "Cash";	
			}
			elseif($status==2)
			{
				return "Square";	
			}
			elseif($status==3)
			{
				return "Cash";	
			}
			elseif($status==4)
			{
				return "Credit Card";	
			}
			else
			{
				return $status;	
			}
		}
		$i = 1;
		$aa=0;
		$bb=0;
		if($input_status==1){
		$sqlinvoice = $obj->SelectAllByID_Multiple_limit("transaction_log",array("date"=>date('Y-m-d')),10);
		}
		elseif($input_status==5)
		{
			
			$sqlchain_store_ids=$obj->SelectAllByID("store_chain_admin",array("sid"=>$input_by));
			if(!empty($sqlchain_store_ids))
			{
				$array_ch = array();
				foreach($sqlchain_store_ids as $ch):
					array_push($array_ch,$ch->store_id);
				endforeach;
				
				
					include('class/report_chain_admin.php');	
					$obj_report_chain = new chain_report();
					$sqlinvoice =$obj_report_chain->SelectAllByID_Multiple2_Or_limit("transaction_log",array("date"=>date('Y-m-d')),$array_ch,"input_by","1","10");
				
			}
			else
			{
				//echo "Not Work";
				$sqlinvoice ="";
			}
		}
		else
		{
			$sqlinvoice = $obj->SelectAllByID_Multiple_limit("transaction_log",array("date"=>date('Y-m-d'),"input_by"=>$input_by),10);
		}
		if (!empty($sqlinvoice))
		foreach ($sqlinvoice as $invoice):
		
		?>
		<tr>
			<td><?php echo $i; ?></td>
			<td>
			<a href="view_sales.php?invoice=<?php echo $invoice->transaction; ?>" class="label label-important"><i class="font-money"></i> <?php echo $invoice->transaction; ?></a>
			</td>
			<td><?php echo $obj->SelectAllByVal("store","store_id",$invoice->sid,"name"); ?></td>
			<td><?php echo $invoice->date; ?></td>
			<td><?php echo $invoice->time; ?></td>
			<td><?php echo $obj->SelectAllByVal("store","id",$invoice->cashier_id,"name"); ?></td>
			<td><?php echo $obj->SelectAllByVal("coustomer","id",$invoice->customer_id,"firstname")." ".$obj->SelectAllByVal("coustomer","id",$invoice->customer_id,"lastname"); ?></td>
			<td>$<?php 
			if(substr($invoice->amount,0,1)=='-')
			{
				$bb+=substr($invoice->amount,1,1000);
				echo @number_format(substr($invoice->amount,1,1000),2);
			}
			else
			{
				$aa+=$invoice->amount;
				echo @number_format($invoice->amount,2);
			}
			?></td>
			<td><?php echo tranaction_type($invoice->type); ?></td>                                            		<td><?php echo tender_type($invoice->tender); ?></td>
			<td>
			<?php if($input_status==1 || $input_status==2 || $input_status==5) { ?>
			<a href="<?php echo $obj->filename(); ?>?del=<?php echo $invoice->id; ?>" class="hovertip" title="Delete" onclick="javascript:return confirm('Are you absolutely sure to delete This?')"><i class="icon-trash"></i></a>
			<?php } ?>
			</td>
		</tr>
		<?php 
		$i++;
		endforeach;
	}
	elseif($_POST["fetch"]==12)
	{
		if($input_status==1){ echo $obj->exists_multiple("ticket", array("date" => date('Y-m-d'))); }
		elseif($input_status==5)
		{
			
			$sqlchain_store_ids=$obj->SelectAllByID("store_chain_admin",array("sid"=>$input_by));
			if(!empty($sqlchain_store_ids))
			{
				$array_ch = array();
				foreach($sqlchain_store_ids as $ch):
					array_push($array_ch,$ch->store_id);
				endforeach;
				
				
					include('class/report_chain_admin.php');	
					$obj_report_chain = new chain_report();
					echo $obj_report_chain->SelectAllByID_Multiple2_Or("ticket",array("date"=>date('Y-m-d')),$array_ch,"input_by","0");
				
			}
			else
			{
				//echo "Not Work";
				echo 0;
			}
		}
		else{ echo $obj->exists_multiple("ticket", array("date" => date('Y-m-d'),"input_by"=>$input_by));	 }
	}
	elseif($_POST["fetch"]==13)
	{
		
		if($input_status==1){ $sqlticket = $obj->SelectAllByID_Multiple_limit("ticket", array("date" => date('Y-m-d')),10); }
		elseif($input_status==5)
		{
			
			$sqlchain_store_ids=$obj->SelectAllByID("store_chain_admin",array("sid"=>$input_by));
			if(!empty($sqlchain_store_ids))
			{
				$array_ch = array();
				foreach($sqlchain_store_ids as $ch):
					array_push($array_ch,$ch->store_id);
				endforeach;
				
				
					include('class/report_chain_admin.php');	
					$obj_report_chain = new chain_report();
					$sqlticket=$obj_report_chain->SelectAllByID_Multiple2_Or_limit("ticket",array("date"=>date('Y-m-d')),$array_ch,"input_by","0","10");
				
			}
			else
			{
				//echo "Not Work";
				$sqlticket="";
			}
		}
		else{ $sqlticket=$obj->SelectAllByID_Multiple_limit("ticket", array("date"=>date('Y-m-d'),"input_by"=>$input_by),10);	}
			$i = 1;
			if (!empty($sqlticket))
			foreach ($sqlticket as $ticket):
				?>
				<tr>
					<td><?php echo $i; ?></td>
					<td><a class="label label-success" href="view_ticket.php?ticket_id=<?php echo $ticket->ticket_id; ?>"><?php echo $ticket->ticket_id; ?></a></td>
					<td><?php echo $ticket->title; ?></td>
					<td><i class="icon-calendar"></i> <?php echo $ticket->date; ?></td>

					<td><?php echo $obj->ticket_status($ticket->status); ?></td>
					<td><label class="label label-warning"><i class="icon-tint"></i> <?php echo $obj->SelectAllByVal("problem_type", "id", $ticket->problem_type, "name"); ?></label></td>
					<td><label class="label label-info"><i class="icon-calendar"></i> <?php echo $obj->duration($ticket->date, date('Y-m-d')); ?></label></td>

				</tr>
				<?php
				$i++;
			endforeach;
	}
	elseif($_POST["fetch"]==14)
	{
		if($input_status==1){ echo $obj->exists_multiple("buyback", array("date" => date('Y-m-d'))); }
		elseif($input_status==5)
		{
			
			$sqlchain_store_ids=$obj->SelectAllByID("store_chain_admin",array("sid"=>$input_by));
			if(!empty($sqlchain_store_ids))
			{
				$array_ch = array();
				foreach($sqlchain_store_ids as $ch):
					array_push($array_ch,$ch->store_id);
				endforeach;
				
					include('class/report_chain_admin.php');	
					$obj_report_chain = new chain_report();
					echo $obj_report_chain->SelectAllByID_Multiple2_Or("buyback",array("date"=>date('Y-m-d')),$array_ch,"input_by","0");
			}
			else
			{
				//echo "Not Work";
				echo 0;
			}
		}
		else{ echo $obj->exists_multiple("buyback",array("date"=>date('Y-m-d'),"input_by"=>$input_by));	 }
	}
	elseif($_POST["fetch"]==15)
	{
		if($input_status==1){ $sqlticket=$obj->SelectAllByID_Multiple_limit("buyback",array("date"=>date('Y-m-d')),10);  }
		elseif($input_status==5)
		{
			
			$sqlchain_store_ids=$obj->SelectAllByID("store_chain_admin",array("sid"=>$input_by));
			if(!empty($sqlchain_store_ids))
			{
				$array_ch = array();
				foreach($sqlchain_store_ids as $ch):
					array_push($array_ch,$ch->store_id);
				endforeach;
				
					include('class/report_chain_admin.php');	
					$obj_report_chain = new chain_report();
					echo $obj_report_chain->SelectAllByID_Multiple2_Or_limit("buyback",array("date"=>date('Y-m-d')),$array_ch,"input_by","0","10");
			}
			else
			{
				//echo "Not Work";
				echo 0;
			}
		}
		else{ $sqlticket=$obj->SelectAllByID_Multiple_limit("buyback",array("date"=>date('Y-m-d'),"input_by"=>$input_by),10);  }
		$i=1;
		$a1=0; $a2=0;
		if(!empty($sqlticket))
		foreach($sqlticket as $ticket): 
			$a1+=1;
			$a2+=$ticket->price;
			?>
				<tr>
					<td><?php echo $i; ?></td>
					<td><a class="label label-success" href="view_buyback.php?buyback_id=<?php echo $ticket->buyback_id; ?>"><i class="icon-tags"></i> <?php echo $ticket->buyback_id; ?></a></td>
					<td><i class="icon-user"></i> <?php echo $obj->SelectAllByVal("coustomer","id",$ticket->cid,"firstname")." ".$obj->SelectAllByVal("coustomer","id",$ticket->cid,"lastname"); ?></td>
					<td><?php echo $ticket->model; ?></td>
					<td><?php echo $ticket->carrier; ?></td>
					<td><?php echo $ticket->imei; ?></td>
					<td><?php echo $ticket->price; ?></td>
					 <td><?php echo $obj->SelectAllByVal("payment_method","id",$ticket->payment_method,"meth_name"); ?></td>
					<td><label class="label label-info"><i class="icon-calendar"></i> <?php echo $obj->duration($ticket->date,date('Y-m-d')); ?></label></td>                
				</tr>
			<?php $i++; 
		endforeach; 
	}
	elseif($_POST["fetch"]==16)
	{
		if($input_status==1){ echo $obj->exists_multiple("unlock_request", array("date" => date('Y-m-d'))); }
		elseif($input_status==5)
		{
			
			$sqlchain_store_ids=$obj->SelectAllByID("store_chain_admin",array("sid"=>$input_by));
			if(!empty($sqlchain_store_ids))
			{
				$array_ch = array();
				foreach($sqlchain_store_ids as $ch):
					array_push($array_ch,$ch->store_id);
				endforeach;
				
					include('class/report_chain_admin.php');	
					$obj_report_chain = new chain_report();
					echo $obj_report_chain->SelectAllByID_Multiple2_Or("unlock_request",array("date"=>date('Y-m-d')),$array_ch,"input_by","0");
			}
			else
			{
				//echo "Not Work";
				echo 0;
			}
		}
		else{ echo $obj->exists_multiple("unlock_request", array("date" => date('Y-m-d'),"input_by"=>$input_by));	 }
	}
	elseif($_POST["fetch"]==17)
	{
		if($input_status==1){ $sqlticket=$obj->SelectAllByID_Multiple_limit("unlock_request",array("date"=>date('Y-m-d')),10);  }
		elseif($input_status==5)
		{
			
			$sqlchain_store_ids=$obj->SelectAllByID("store_chain_admin",array("sid"=>$input_by));
			if(!empty($sqlchain_store_ids))
			{
				$array_ch = array();
				foreach($sqlchain_store_ids as $ch):
					array_push($array_ch,$ch->store_id);
				endforeach;
				
					include('class/report_chain_admin.php');	
					$obj_report_chain = new chain_report();
					$sqlticket=$obj_report_chain->SelectAllByID_Multiple2_Or_limit("unlock_request",array("date"=>date('Y-m-d')),$array_ch,"input_by","1","10");
			}
			else
			{
				//echo "Not Work";
				$sqlticket="";
			}
		}
		else{ $sqlticket=$obj->SelectAllByID_Multiple_limit("unlock_request",array("date"=>date('Y-m-d'),"input_by"=>$input_by),10);  }
		$i=1;
		if(!empty($sqlticket))
		foreach($sqlticket as $ticket): ?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><a class="label label-success" href="view_unlock.php?unlock_id=<?php echo $ticket->unlock_id; ?>"><i class="icon-tags"></i> <?php echo $ticket->unlock_id; ?></a></td>
				<!--<td><i class="icon-user"></i> <?php //echo $obj->SelectAllByVal("coustomer","id",$ticket->uid,"firstname")." ".$obj->SelectAllByVal("coustomer","id",$ticket->uid,"lastname"); ?></td>-->
				<td><?php echo $obj->SelectAllByVal("unlock_service","id",$ticket->service_id,"name"); ?></td>
				<td><i class="icon-calendar"></i> <?php echo $ticket->date; ?></td>

				<td><?php echo $obj->ticket_status($ticket->status); ?></td>
				<td><label class="label label-info"><i class="icon-calendar"></i> <?php echo $obj->duration($ticket->date,date('Y-m-d')); ?></label></td>
				<?php
				$product_name=$ticket->service_id.":".$obj->SelectAllByVal("unlock_service","id",$ticket->service_id,"name");
$chkx=$obj->exists_multiple("product", array("name" =>$product_name));
	if($chkx!=0){ $pid=$obj->SelectAllByVal("product","name",$product_name,"id");
		$price=$obj->SelectAllByVal("product","name",$product_name,"price_retail");
	 }
	else{ $pid=0; $price=0; }
				?>
				<td><a href="pos.php?newsales=1&amp;pid=<?php echo $pid; ?>&amp;price=<?php echo $price; ?>&AMP;cid=<?php echo $ticket->cid; ?>&amp;unlock_id=<?php echo $ticket->unlock_id; ?>" class="btn btn-success"><i class="font-money"></i> <?php echo number_format($price,2); ?> To POS</a></td>

			</tr>
		<?php $i++; 
		endforeach;
	}
	elseif($_POST["fetch"]==18)
	{
		if($input_status==1){ echo $obj->exists_multiple("checkin_list", array("date" => date('Y-m-d'))); }
		elseif($input_status==5)
		{
			
			$sqlchain_store_ids=$obj->SelectAllByID("store_chain_admin",array("sid"=>$input_by));
			if(!empty($sqlchain_store_ids))
			{
				$array_ch = array();
				foreach($sqlchain_store_ids as $ch):
					array_push($array_ch,$ch->store_id);
				endforeach;
				
					include('class/report_chain_admin.php');	
					$obj_report_chain = new chain_report();
					echo $obj_report_chain->SelectAllByID_Multiple2_Or("checkin_list",array("date"=>date('Y-m-d')),$array_ch,"input_by","0");
			}
			else
			{
				//echo "Not Work";
				echo 0;
			}
		}
		else{ echo $obj->exists_multiple("checkin_list", array("date" => date('Y-m-d'),"input_by"=>$input_by));	 }
	}
	elseif($_POST["fetch"]==19)
	{
		if($input_status==1){ $sqlticket = $obj->SelectAllByID_Multiple_limit("checkin_list", array("date" => date('Y-m-d')),10); }
		elseif($input_status==5)
		{
			
			$sqlchain_store_ids=$obj->SelectAllByID("store_chain_admin",array("sid"=>$input_by));
			if(!empty($sqlchain_store_ids))
			{
				$array_ch = array();
				foreach($sqlchain_store_ids as $ch):
					array_push($array_ch,$ch->store_id);
				endforeach;
				
					include('class/report_chain_admin.php');	
					$obj_report_chain = new chain_report();
					$sqlticket =$obj_report_chain->SelectAllByID_Multiple2_Or_limit("checkin_list",array("date"=>date('Y-m-d')),$array_ch,"input_by","1","10");
			}
			else
			{
				//echo "Not Work";
				$sqlticket ="";
			}
		}
		else{ $sqlticket = $obj->SelectAllByID_Multiple_limit("checkin_list", array("date" => date('Y-m-d'),"input_by"=>$input_status),10);	 }
		$i = 1;
		if (!empty($sqlticket))
			foreach ($sqlticket as $ticket):
				?>
				<tr>
					<td><?php echo $i; ?></td>
					<td><?php echo $ticket->fullname; ?></td>
					<td><?php echo $ticket->email; ?></td>
					<td><?php echo $ticket->phone; ?></td>

					<td><?php echo $ticket->device; ?></td>
					<td><?php echo $ticket->model; ?></td>
					<td><?php echo $ticket->color; ?></td>
					<td><?php echo $ticket->network; ?></td>
					<td><?php echo $ticket->problem; ?></td>
					<td><?php echo $obj->duration($ticket->date, date('Y-m-d')); ?></td>
				</tr>
				<?php
				$i++;
			endforeach;
	}
	elseif($_POST["fetch"]==20)
	{
		include('include/dashboard_system_summary.php');
	}
	elseif($_POST["fetch"]==21)
	{
		include('include/dashboard_tender_report.php');
	}
	elseif($_POST["fetch"]==22)
	{
		include('include/dashboard_highest_sales_cashier_report.php');
	}
	elseif($_POST["fetch"]==23)
	{
		include('include/dashboard_other_history.php');
	}
	elseif($_POST["fetch"]==24)
	{
		echo "<h3 class='subtitle align-center'>System Summary <i onClick='dashboard_system_summary(1)' class='icon-reload'></i></h3>";
	}
	else
	{
		header('HTTP/1.1 500 Are you kiddin me? Empty Not Allowed To Submit');
    	exit();
	}
}
$obj->close($obj->open());