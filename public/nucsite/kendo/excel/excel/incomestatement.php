<?php
session_start();
class db_class
{
	var $conn;
	var $result;
	var $result_id;

	function MySQL($host='212.74.52.252', $user='amsit_accounts', $pass='@ccountS',$bd='amsit_tas')
	
	{
		$this->conn = mysql_connect($host,$user, $pass) or die(mysql_error()) 
				or die('Could not connect: ' . mysql_error());
				
		$this->select_db($bd);
	}
	
	function select_db($bd)
	{
				$db=mysql_select_db($bd,$this->conn) or die(mysql_error())
						or die('Could not connect to '. $bd .' ' . mysql_error());
	}
	
	
	//sql mysql query function with last inserted id
	function sql($SQL)
	{

		$this->result = mysql_query($SQL)
					or die('SQL Error<br>' .$SQL.' '. mysql_error());
		$this->result_id = mysql_insert_id();
		
		
	}
	//sql funcrtion end
	
	function clean($str) {//clean functioin for aboiding sql injection 
		$str = @trim($str);
		if(get_magic_quotes_gpc()) {
			$str = stripslashes($str);
		}
		return mysql_real_escape_string($str);
	}
	
	function RandNumber($e){//random number in fixed length
		for($i=0;$i<$e;$i++){
		@$rand =  $rand .  rand(0, 9); 
		}
		return $rand;
		}
	
		function randomPassword() //random number genarator with chacter and number and syntex
			{
				$alphabet = "EF+GHI234WXYZ567+89@(0-=1){<>/\_+$}[]%$*ABCD";
				$pass = array();
				for ($i = 0; $i < 6; $i++) {
					$n = rand(0, strlen($alphabet)-1); 
					$pass[$i] = $alphabet[$n];
											}
				return implode($pass); 
			}

}

//include('header_footer_file/header.php');
$obj = new db_class();
$obj->MySQL();
extract($_GET);
@$from=@$fyear."-".@$fmonth."-".@$fdate;
@$to=@$tyear."-".@$tmonth."-".@$tdate;
$ofrom=@$fyear."-".@$fmonth."-".@$fdate-1;
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /> 

<script type="text/javascript" src="js/autofill.js"></script>
<script language="JavaScript">
function Check(chk)
{ 
if(document.myform.Check_ctr.checked==true)
{
for (var i = 0; i < chk.length; i++)
{
chk[i].checked = true ;
}
}
else
{
for (i = 0; i < chk.length; i++)
chk[i].checked = false ;
}
}
</script>
</head>
<body>
<?php
error_reporting (E_ALL ^ E_NOTICE);
require_once("class_lib/excelwriter.class.php");

$excel=new ExcelWriter("incomestatement.xls");
if($excel==false)	
echo $excel->error;
$myArr=array("","");
$myArr=array("Comprehensive income statement for the year","");
$excel->writeLine($myArr);
/*$myArr=array("","");
$excel->writeLine($myArr);
$myArr=array("Account ","Taka ");
$excel->writeLine($myArr);*/


					$myArr=array("","");
					$excel->writeLine($myArr);		
	
					
					$myArr=array("From ".$fdate."/".$fmonth."/".$fyear,"To ".$tdate."/".$tmonth."/".$tyear);
					$excel->writeLine($myArr);	
					
					$myArr=array("","");
					$excel->writeLine($myArr);	
							
							
					$myArr=array("Revenue","");
					$excel->writeLine($myArr);	
							
							
							$ld=mysql_query("SELECT * FROM ladger_list_properties WHERE main_head_id='3' AND head_sub_list_id!='131' AND head_sub_list_id!='132' AND head_sub_list_id!='133' AND head_sub_list_id!='134' AND head_sub_list_id!='135' AND head_sub_list_id!='136' AND head_sub_list_id!='138'");
							$total_revenue=0;
							while($row=mysql_fetch_array($ld))
							{
								
								$inid=$row['id']; 
									if(@$fdate=='')
									{
										$getdutotal=mysql_query("SELECT * FROM ladger WHERE ladger_id='$inid' AND ladger_date='".date('Y-m-d')."'");
									}
									else
									{
										$getdutotal=mysql_query("SELECT * FROM ladger WHERE ladger_id='$inid' AND ladger_date BETWEEN '$from' AND '$to'");
									}
										$debit=0;
										$cradit=0;
									while($due=mysql_fetch_array($getdutotal))
									{
										$debit+=$due['debit'];
										$cradit+=$due['cradit'];
									}
								if($cradit!=0)
								{
									
									
							
									
									$netm=$debit-$cradit;
									$getch=substr($netm,0,1);
									/*if($getch!='-')
									{ echo number_format($netm,2); }
									else
									{ echo number_format(substr($netm,1,200),2); } */ 
									$total_revenue+=$debit-$cradit;
									
									$myArr=array($row['head_sub_list_name'],$netm);
									$excel->writeLine($myArr);
									
								}
							 } 
							 
							 $myArr=array("Gross Revenue",$total_revenue);
							 $excel->writeLine($myArr);
								//$chktr=substr($total_revenue,0,1);
								//if($chktr!='-'){ echo number_format($gettotalrevenue=$total_revenue,2); }else{ echo number_format($gettotalrevenue=substr($total_revenue,1,200),2); }
								$myArr=array("","");
							 $excel->writeLine($myArr);
								$myArr=array("(Less)","");
							 $excel->writeLine($myArr);
                               
							$ld_sales_discount=mysql_query("SELECT * FROM ladger_list_properties WHERE main_head_id='4' AND head_sub_list_id='380'");
							$sales_discount=0;
							while($row_sales_discount=mysql_fetch_array($ld_sales_discount))
							{
								
								$inid_sales_discount=$row_sales_discount['id'];
								if(@$fdate=='')
									{
										$getdutotal_sales_discount=mysql_query("SELECT * FROM ladger WHERE ladger_id='$inid_sales_discount' AND ladger_date='".date('Y-m-d')."'");
									}
									else
									{
										$getdutotal_sales_discount=mysql_query("SELECT * FROM ladger WHERE ladger_id='$inid_sales_discount' AND ladger_date BETWEEN '$from' AND '$to'");
										
									} 
									
										$debit_sales_discount=0;
										$cradit_sales_discount=0;
									while($due_sales_discount=mysql_fetch_array($getdutotal_sales_discount))
									{
										$debit_sales_discount+=$due_sales_discount['debit'];
										$cradit_sales_discount+=$due_sales_discount['cradit'];
										$sales_discount+=$due_sales_discount['debit']-$due_sales_discount['cradit'];
									}
								if($sales_discount!=0)
								{
									
									
									
							
									
									$netm_sales_discount=$debit_sales_discount-$cradit_sales_discount;
									$getch=substr($netm_sales_discount,0,1);
									/*if($getch!='-')
									{ echo number_format($netm_sales_discount,2); }
									else
									{ echo number_format(substr($netm_sales_discount,1,200),2); }*/ 
									 
									$myArr=array($row_sales_discount['head_sub_list_name'],$netm_sales_discount);
									$excel->writeLine($myArr);
									
								}
							 }
							 
							$ld_sales_return=mysql_query("SELECT * FROM ladger_list_properties WHERE main_head_id='4' AND head_sub_list_id='379'");
							
							while($row_sales_return=mysql_fetch_array($ld_sales_return))
							{
								
								$inid_sales_return=$row_sales_return['id']; 
									
									if(@$fdate=='')
									{
										$getdutotal_sales_return=mysql_query("SELECT * FROM ladger WHERE ladger_id='$inid_sales_return' AND ladger_date='".date('Y-m-d')."'");
									}
									else
									{
										$getdutotal_sales_return=mysql_query("SELECT * FROM ladger WHERE ladger_id='$inid_sales_return' AND ladger_date BETWEEN '$from' AND '$to'");
										
									}
										$debit_sales_return=0;
										$cradit_sales_return=0;
										$sales_return=0;
									while($due_sales_return=mysql_fetch_array($getdutotal_sales_return))
									{
										$debit_sales_return+=$due_sales_return['debit'];
										$cradit_sales_return+=$due_sales_return['cradit'];
										$sales_return=$due_sales_return['debit']-$due_sales_return['cradit'];
									}
								if($sales_return!=0)
								{
									
							
									
									$netm_sales_return=$debit_sales_return-$cradit_sales_return;
									 
									$myArr=array($row_sales_return['head_sub_list_name'],$netm_sales_return);
									$excel->writeLine($myArr);
									
								}
							 }
							
							
							
							$myArr=array("","");
							$excel->writeLine($myArr);
									
							
							$myArr=array("(Less)","");
							$excel->writeLine($myArr);
									
							
							$chkfourcountled=mysql_query("SELECT * FROM head_sub_list WHERE list_of_head_accounts_id='4' AND list_of_sub_head_accounts_id='2' AND list_of_sub_head_list_id='35'");
							$salesexpense=0;
							while($cogsexpense=mysql_fetch_array($chkfourcountled))
							{
								$cogsid=$cogsexpense['id'];
								$chkvisibleledgeraccount=mysql_num_rows(mysql_query("SELECT * FROM ladger_list_properties WHERE main_head_id='4' AND head_sub_list_id='$cogsid'"));
							if($chkvisibleledgeraccount!=0)
							{
							$ld=mysql_query("SELECT * FROM ladger_list_properties WHERE main_head_id='4' AND head_sub_list_id='$cogsid'");
							while($row=mysql_fetch_array($ld))
							{
								$inid=$row['id']; 
									if(@$fdate=='')
									{
										$getdutotal=mysql_query("SELECT * FROM ladger WHERE ladger_id='$inid' AND ladger_date='".date('Y-m-d')."'");
									}
									else
									{
										$getdutotal=mysql_query("SELECT * FROM ladger WHERE ladger_id='$inid' AND ladger_date BETWEEN '$from' AND '$to'");
									}
										$debit=0;
										$cradit=0;
									while($due=mysql_fetch_array($getdutotal))
									{
										$debit+=$due['debit'];
										$cradit+=$due['cradit'];
									}
								if($debit!=0)
								{
								
									$netm=$debit-$cradit; 
									$salesexpense+=$debit-$cradit;
									
									$myArr=array($row['head_sub_list_name'],$netm);
									$excel->writeLine($myArr);
									
								}
							 }
							}
							}
							
							
							$netrevenue=$gettotalrevenue-$salesexpense-$sales_discount-$sales_return;
							$myArr=array("Net Revenue",$netrevenue);
							$excel->writeLine($myArr);
							$myArr=array("","");
							$excel->writeLine($myArr);
							$myArr=array("Other Income","");
							$excel->writeLine($myArr);
							
							//	echo number_format($netrevenue,2);
							$sql_o_i=mysql_query("SELECT * FROM head_sub_list WHERE list_of_head_accounts_id='3' AND list_of_sub_head_accounts_id='1' AND  list_of_sub_head_list_id='16' AND id!='135' AND id!='137'");
							$other_income=0;
							$total_other_income=0;
							while($row_o_i=mysql_fetch_array($sql_o_i))
							{
								$get_o_i=$row_o_i['id'];
								
								$ld_other_income=mysql_query("SELECT * FROM ladger_list_properties WHERE head_sub_list_id='$get_o_i'");
								while($row_other_income=mysql_fetch_array($ld_other_income))
								{
									
									$inid_other_income=$row_other_income['id']; 
										
									if(@$fdate=='')
									{
										$getdutotal_other_income=mysql_query("SELECT * FROM ladger WHERE ladger_id='$inid_other_income' AND ladger_date='".date('Y-m-d')."'");
									}
									else
									{
										$getdutotal_other_income=mysql_query("SELECT * FROM ladger WHERE ladger_id='$inid_other_income' AND ladger_date BETWEEN '$from' AND '$to'");
									}
											$debit_other_income=0;
											$cradit_other_income=0;
										while($due_other_income=mysql_fetch_array($getdutotal_other_income))
										{
											$debit_other_income+=$due_other_income['debit'];
											$cradit_other_income+=$due_other_income['cradit'];
											
										}
										
										$db_other_income=$debit_other_income-$cradit_other_income;
									if($db_other_income!=0)
									{
										$netm_other_income=$debit_other_income-$cradit_other_income;
										$total_other_income+=$netm_other_income;
										$getch_other_income=substr($netm_other_income,0,1);
										 
										$other_income+=$netm_other_income;
										$myArr=array($row_other_income['head_sub_list_name'],$netm_other_income);
										$excel->writeLine($myArr);
									}
								 }
							}
							
							$myArr=array("","");
							$excel->writeLine($myArr);
							
							$myArr=array("Total Other Income",$total_other_income);
							$excel->writeLine($myArr);
							$chktoi=substr($total_other_income,0,1);
							
							$myArr=array("Total Income",$total_other_income);
							$excel->writeLine($myArr);
							$chkti=substr($total_other_income,0,1);
							  if($chkti!="-")
							  {
								  $tincome=$total_other_income+$netrevenue;
								  //echo number_format($tincome,2);
							  }
							  else
							  {
								  $tincome=substr($total_other_income,1,200)+$netrevenue;
								  //echo number_format($tincome,2);
							  }
							  
							  
							  $myArr=array("Cost of Goods Sold (COGS)","");
							  $excel->writeLine($myArr);
							  $myArr=array("Beginning Inventory Value","");
							  $excel->writeLine($myArr);
							  
							 $myArr=array("",$begininginventory);
							  $excel->writeLine($myArr);
							
							$iyear=date('Y')-1;
							
							$cy=date('Y');
							$from=date("Y-m-d", mktime(0, 0, 0, 12, 31,$cy-1));
							$to=date("Y-m-d", mktime(0, 0, 0, 12, 32,$cy-2));
							$endfrom=date("Y-m-d", mktime(0, 0, 0, 12, 31,$cy));
							$endto=date("Y-m-d", mktime(0, 0, 0, 12, 32,$cy-1));
                            /*
                            $sql_query=mysql_query("SELECT * FROM inventory WHERE year='$iyear'");
                            $fetiyear=mysql_fetch_array($sql_query);
                            echo number_format($begininginventory=$fetiyear['begging_value'],2);*/
							$ld_begining_inventory=mysql_query("SELECT * FROM ladger_list_properties WHERE main_head_id='1' AND head_sub_list_id='46'");
							
							while($row_begining_inventory=mysql_fetch_array($ld_begining_inventory))
							{
								
								$inid_begining_inventory=$row_begining_inventory['id']; 
									
									
									if(@$fdate=='')
									{
										@$getdutotal_begining_inventory=mysql_query("SELECT * FROM ladger WHERE ladger_id='$inid_begining_inventory' AND t.ladger_date >= '$to' and t.ladger_date <= '$from'");
									}
									else
									{
										@$getdutotal_begining_inventory=mysql_query("SELECT * FROM ladger WHERE ladger_id='$inid_begining_inventory' AND t.ladger_date >= '$to' and t.ladger_date <= '$from'");
									}
									
										$debit_begining_inventory=0;
										$cradit_begining_inventory=0;
									while(@$due_begining_inventory=mysql_fetch_array($getdutotal_begining_inventory))
									{
										$debit_begining_inventory+=$due_begining_inventory['debit'];
										$cradit_begining_inventory+=$due_begining_inventory['cradit'];
									}
							}
							$begininginventory=$debit_begining_inventory-$cradit_begining_inventory;
							
							
							
							$ld_ending_inventory=mysql_query("SELECT * FROM ladger_list_properties WHERE main_head_id='1' AND head_sub_list_id='46'");
							
							while($row_ending_inventory=mysql_fetch_array($ld_ending_inventory))
							{
								
								$inid_ending_inventory=$row_ending_inventory['id']; 
									
									if(@$fdate=='')
									{
										$getdutotal_ending_inventory=mysql_query("SELECT * FROM ladger WHERE ladger_id='$inid_ending_inventory' AND t.ladger_date >= '$endto' and t.ladger_date <= '$endfrom'");
									}
									else
									{
										$getdutotal_ending_inventory=mysql_query("SELECT * FROM ladger WHERE ladger_id='$inid_ending_inventory' AND t.ladger_date >= '$endto' and t.ladger_date <= '$endfrom'");
									}
										$debit_ending_inventory=0;
										$cradit_ending_inventory=0;
									while(@$due_ending_inventory=mysql_fetch_array($getdutotal_ending_inventory))
									{
										$debit_ending_inventory+=$due_ending_inventory['debit'];
										$cradit_ending_inventory+=$due_ending_inventory['cradit'];
									}
							}
							$endinventory=$debit_ending_inventory-$cradit_ending_inventory;
							
							
							
							 $myArr=array("Add : Direct Expense","");
							  $excel->writeLine($myArr);
                            
							$chkfourcountled=mysql_query("SELECT * FROM head_sub_list WHERE list_of_head_accounts_id='4' AND list_of_sub_head_accounts_id='1'");
							$cogs=0;
							while($cogsexpense=mysql_fetch_array($chkfourcountled))
							{
							$cogsid=$cogsexpense['id'];
								$chkvisibleledgeraccount=mysql_num_rows(mysql_query("SELECT * FROM ladger_list_properties WHERE main_head_id='4' AND head_sub_list_id='$cogsid'"));
							if($chkvisibleledgeraccount!=0)
							{
							$ld=mysql_query("SELECT * FROM ladger_list_properties WHERE main_head_id='4' AND head_sub_list_id='$cogsid' AND head_sub_list_id!='240'");
							$total_revenue=0;
							while($row=mysql_fetch_array($ld))
							{
								
								$inid=$row['id']; 
									if(@$fdate=='')
									{
										$getdutotal=mysql_query("SELECT * FROM ladger WHERE ladger_id='$inid' AND ladger_date='".date('Y-m-d')."'");
									}
									else
									{
										$getdutotal=mysql_query("SELECT * FROM ladger WHERE ladger_id='$inid' AND ladger_date BETWEEN '$from' AND '$to'");
									}
										$debit=0;
										$cradit=0;
									while($due=mysql_fetch_array($getdutotal))
									{
										$debit+=$due['debit'];
										$cradit+=$due['cradit'];
									}
								if($debit!=0)
								{
							
									$netm=$debit-$cradit;
									$sco=$debit-$cradit;
									
									$getch=substr($netm,0,1);
									/*if($getch!='-')
									{ echo number_format($netm,2); }
									else
									{ echo number_format(substr($netm,1,200),2); }*/  
									$cogs+=$debit-$cradit;
									
									$myArr=array($row['head_sub_list_name'],$netm);
							  		$excel->writeLine($myArr);
									
									
								}
							 }
							}
							}
							$ld=mysql_query("SELECT * FROM ladger_list_properties WHERE main_head_id='4' AND head_sub_list_id='240'");
							$fr=0;
							while($row=mysql_fetch_array($ld))

							{
								
								$inid=$row['id']; 
									if(@$fdate=='')
									{
										$getdutotal=mysql_query("SELECT * FROM ladger WHERE ladger_id='$inid' AND ladger_date='".date('Y-m-d')."'");
									}
									else
									{
										$getdutotal=mysql_query("SELECT * FROM ladger WHERE ladger_id='$inid' AND ladger_date BETWEEN '$from' AND '$to'");
									}
										$debit=0;
										$cradit=0;
									while($due=mysql_fetch_array($getdutotal))
									{
										$debit+=$due['debit'];
										$cradit+=$due['cradit'];
									}
								if($debit!=0)
								{
									
									
									
									
									
									$netm=$debit-$cradit;
									$getch=substr($netm,0,1);
									/*if($getch!='-')
									{ echo number_format($netm,2); }
									else
									{ echo number_format(substr($netm,1,200),2); } */ 
									$fr+=$netm;
									
									$myArr=array($row['head_sub_list_name'],$netm);
							  		$excel->writeLine($myArr);
								}
							 }
							 
							
							   $inventorypurchase=mysql_query("SELECT * FROM ladger_list_properties WHERE main_head_id='1' AND head_sub_list_id='46'");
							
							while($row_purchase_inventory=mysql_fetch_array($inventorypurchase))
							{
								
								$inid_purchase_inventory=$row_purchase_inventory['id']; 
									
									
									if(@$fdate=='')
									{
										$getdutotal_purchase_inventory=mysql_query("SELECT * FROM ladger WHERE ladger_id='$inid_ending_inventory' AND ladger_date='".date('Y-m-d')."'");
									}
									else
									{
										$getdutotal_purchase_inventory=mysql_query("SELECT * FROM ladger WHERE ladger_id='$inid_ending_inventory' AND ladger_date BETWEEN '$from' AND '$to'");
									}
									
										$debit_purchase_inventory=0;
									while($due_purchase_inventory=mysql_fetch_array($getdutotal_purchase_inventory))
									{
										$debit_purchase_inventory+=$due_purchase_inventory['debit'];
									}
							}
							$inventorypurchase_op=$debit_purchase_inventory;
							//echo number_format($inventorypurchase_op,2);
							 $myArr=array("Inventory Purchase",$inventorypurchase_op);
							 $excel->writeLine($myArr);
							 
							 
							 $myArr=array("Total Direct Expense",$begininginventory+$fr+$cogs+$inventorypurchase_op);
							 $excel->writeLine($myArr);
							 
							 $totaldirectexpense=$begininginventory+$fr+$cogs+$inventorypurchase_op;
							//echo number_format($begininginventory+$fr+$cogs+$inventorypurchase_op,2);
										  
							 $myArr=array("(Less)","");
							 $excel->writeLine($myArr);  
							  
							  
							$ld_purchase_discount=mysql_query("SELECT * FROM ladger_list_properties WHERE main_head_id='2' AND head_sub_list_id='382'");
							$purchase_discount=0;
							while($row_purchase_discount=mysql_fetch_array($ld_purchase_discount))
							{
								
								$inid_purchase_discount=$row_purchase_discount['id']; 
									
									if(@$fdate=='')
									{
										$getdutotal_purchase_discount=mysql_query("SELECT * FROM ladger WHERE ladger_id='$inid_purchase_discount' AND ladger_date='".date('Y-m-d')."'");
									}
									else
									{
										$getdutotal_purchase_discount=mysql_query("SELECT * FROM ladger WHERE ladger_id='$inid_purchase_discount' AND ladger_date BETWEEN '$from' AND '$to'");
									}
										$debit_purchase_discount=0;
										$cradit_purchase_discount=0;
									while($due_purchase_discount=mysql_fetch_array($getdutotal_purchase_discount))
									{
										$debit_purchase_discount+=$due_purchase_discount['debit'];
										$cradit_purchase_discount+=$due_purchase_discount['cradit'];
										$purchase_discount+=$due_purchase_discount['debit']-$due_purchase_discount['cradit'];
									}
								if($purchase_discount!=0)
								{
									
									 $myArr=array($row_purchase_discount['head_sub_list_name'],$netm_purchase_discount);
							 		 $excel->writeLine($myArr);  
							  
									$netm_purchase_discount=$debit_purchase_discount-$cradit_purchase_discount;
									$getch=substr($netm_purchase_discount,0,1);
									
							   }
							 }
							 
							$ld_purchase_return=mysql_query("SELECT * FROM ladger_list_properties WHERE main_head_id='2' AND head_sub_list_id='375'");
							
							while($row_purchase_return=mysql_fetch_array($ld_purchase_return))
							{
								
								$inid_purchase_return=$row_purchase_return['id']; 
									
									if(@$fdate=='')
									{
										$getdutotal_purchase_return=mysql_query("SELECT * FROM ladger WHERE ladger_id='$inid_purchase_return' AND ladger_date='".date('Y-m-d')."'");
									}
									else
									{
										$getdutotal_purchase_return=mysql_query("SELECT * FROM ladger WHERE ladger_id='$inid_purchase_return' AND ladger_date BETWEEN '$from' AND '$to'");
									}
										$debit_purchase_return=0;
										$cradit_purchase_return=0;
										$purchase_return=0;
									while($due_purchase_return=mysql_fetch_array($getdutotal_purchase_return))
									{
										$debit_purchase_return+=$due_purchase_return['debit'];
										$cradit_purchase_return+=$due_purchase_return['cradit'];
										$purchase_return=$due_purchase_return['debit']-$due_purchase_return['cradit'];
									}
								if($purchase_return!=0)
								{
									
									 $myArr=array($row_purchase_return['head_sub_list_name'],$netm_purchase_return);
							 		 $excel->writeLine($myArr);  
							
									
									$netm_purchase_return=$debit_purchase_return-$cradit_purchase_return;
									$getch=substr($netm_purchase_return,0,1);
									
								}
							 }
							 
							 $myArr=array("Net Direct Expense",$netm_purchase_return);
							 $excel->writeLine($myArr);
							 
							 
							 $myArr=array("Net Direct Expense",$netdiorectexpense);
							 $excel->writeLine($myArr);
							  
							   $netdiorectexpense=$totaldirectexpense+($purchase_discount+$purchase_return);
							   //echo number_format($netdiorectexpense,2);
							   $myArr=array("End Inventory Value",$endinventory);
							   $excel->writeLine($myArr);
                            
                            
								 $cogss=$netdiorectexpense-$endinventory;
								$myArr=array("Total Cost of Goods Sold (COGS)",$cogss);
							   $excel->writeLine($myArr); 
								 
								 
								$myArr=array("","");
							   $excel->writeLine($myArr);  
								//echo number_format($cogss,2);
							$myArr=array("Gross Profit/(Loss)",$gross_profit);
							   $excel->writeLine($myArr);
							
								
								$gross_profit=$tincome-$cogss;
								$lkj=substr($gross_profit,0,1);
								/*if($lkj!="-")
								{
									echo number_format($gross_profit,2);
								}
								else
								{
									echo "(".number_format(substr($gross_profit,1,200),2).")";
								}*/
								
								
							    $myArr=array("","");
							    $excel->writeLine($myArr);	
								
								
								$myArr=array("","");
							    $excel->writeLine($myArr);	
								
								$myArr=array("Operating Expenses","");
							    	$excel->writeLine($myArr);
							
							$chkfourcountled=mysql_query("SELECT * FROM head_sub_list WHERE list_of_head_accounts_id='4' AND list_of_sub_head_accounts_id='2' AND list_of_sub_head_list_id!='35'");
							$opex=0;
							while($cogsexpense=mysql_fetch_array($chkfourcountled))
							{
							$cogsid=$cogsexpense['id'];
								$chkvisibleledgeraccount=mysql_num_rows(mysql_query("SELECT * FROM ladger_list_properties WHERE main_head_id='4' AND head_sub_list_id='$cogsid'"));
							if($chkvisibleledgeraccount!=0)
							{
							$ld=mysql_query("SELECT * FROM ladger_list_properties WHERE main_head_id='4' AND head_sub_list_id='$cogsid'");
							while($row=mysql_fetch_array($ld))
							{
								
								$inid=$row['id']; 
									if(@$fdate=='')
									{
										$getdutotal=mysql_query("SELECT * FROM ladger WHERE ladger_id='$inid' AND ladger_date='".date('Y-m-d')."'");
									}
									else
									{
										$getdutotal=mysql_query("SELECT * FROM ladger WHERE ladger_id='$inid' AND ladger_date BETWEEN '$from' AND '$to'");
									}
										$debit=0;
										$cradit=0;
									while($due=mysql_fetch_array($getdutotal))
									{
										$debit+=$due['debit'];
										$cradit+=$due['cradit'];
									}
								if($debit!=0)
								{
									
									$netm=$debit-$cradit;
									$getch=substr($netm,0,1);
									/*if($getch!='-')
									{ echo number_format($netm,2); }
									else
									{ echo number_format(substr($netm,1,200),2); }*/  
									$opex+=$debit-$cradit;
									
									$myArr=array($row['head_sub_list_name'],$netm);
							    	$excel->writeLine($myArr);	
									
								}
							 }
							}
							}
									$myArr=array("Total Operating Expenses",$opex);
							    	$excel->writeLine($myArr);	
							 
									$myArr=array("","");
							    	$excel->writeLine($myArr);	
									
									
									$netprofit=$gross_profit-$opex;
								$akj=substr($netprofit,0,1);
								
								/*if($akj!="-")
								{
									echo number_format($netprofit,2);
								}
								else
								{
									echo "(".number_format(substr($netprofit,1,200),2).")";
								}*/
								$myArr=array("NET PROFIT/(LOSS)",$netprofit);
							    $excel->writeLine($myArr);
																?>
                                
									
<meta http-equiv="refresh" content="2;url=incomestatement.xls">
</body>
</html>
  