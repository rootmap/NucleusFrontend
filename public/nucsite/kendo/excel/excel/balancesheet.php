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

$sql_icpa=mysql_query("SELECT * FROM ladger_list_properties WHERE main_head_id='6'");
$ipca_current_liability=0;
$ipca_current_asset=0;
while($row_ipca=mysql_fetch_array($sql_icpa))
{
	$inid_row_ipca=$row_ipca['id']; 
		$getdutotal_ipca=mysql_query("SELECT * FROM ladger WHERE ladger_id='$inid_row_ipca'");
			$ipca_debit=0;
			$ipca_cradit=0;
		while($due_ipca=mysql_fetch_array($getdutotal_ipca))
		{
			$ipca_debit+=$due_ipca['debit'];
			$ipca_cradit+=$due_ipca['cradit'];
		}
	$ipca_current_liability+=$ipca_cradit;
	$ipca_current_asset+=$ipca_debit;
}
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
$myArr=array("INCOME STATEMENT","");
$excel->writeLine($myArr);
/*$myArr=array("","");
$excel->writeLine($myArr);
$myArr=array("Account ","Taka ");
$excel->writeLine($myArr);*/


					$myArr=array("","");
					$excel->writeLine($myArr);		
					
					$myArr=array("Expected","");
					$excel->writeLine($myArr);		
					
					
					$myArr=array("","");
					$excel->writeLine($myArr);	
					
					$myArr=array("From ".$fdate."/".$fmonth."/".$fyear."To ".$tdate."/".$tmonth."/".$tyear);
					$excel->writeLine($myArr);	
					
					$myArr=array("","");
					$excel->writeLine($myArr);	
					$myArr=array("Account "," Taka");
						$excel->writeLine($myArr);		
							
						$myArr=array("Asset","");
						$excel->writeLine($myArr);
								$myArr=array("Bank & Cash","");
								$excel->writeLine($myArr);


							$chkfourcountled=mysql_query("SELECT * FROM head_sub_list WHERE list_of_head_accounts_id='1' AND list_of_sub_head_accounts_id='1'");
							$cogs=0;
							$total_revenue=0;
							while($cogsexpense=mysql_fetch_array($chkfourcountled))
							{
							$cogsid=$cogsexpense['id'];
								$chkvisibleledgeraccount=mysql_num_rows(mysql_query("SELECT * FROM ladger_list_properties WHERE main_head_id='1' AND head_sub_list_id='$cogsid'"));
							if($chkvisibleledgeraccount!=0)
							{
								
								$ld=mysql_query("SELECT * FROM ladger_list_properties WHERE main_head_id='1' AND head_sub_list_id='$cogsid'");
								
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
										$netm=$debit-$cradit;
										if($netm!=0)
										{
							
                                            
                                            
                                            $getch=substr($netm,0,1);
                                            /*if($getch!='-')
                                            { echo number_format($netm,2); }
                                            else
                                            { echo "(".number_format(substr($netm,1,200),2).")"; }*/  
                                            $total_revenue+=$netm;
												
												$myArr=array($row['head_sub_list_name'],$netm);
												$excel->writeLine($myArr);
												                                          
                                            }
                                     } 
							}
							
							}
							
							
							
							$myArr=array("Total for Bank & Cash",$total_revenue);
							$excel->writeLine($myArr);

							
								
								//echo $total_revenue;
								$chktr=substr($total_revenue,0,1);
								if($chktr!='-')
								{ 
									$totalforbank=$total_revenue;
								//echo number_format($totalforbank,2);
								}
								else
								{
									$totalforbank=substr($total_revenue,1,200);
								//echo "(".number_format($totalforbank,2).")"; 
								}
								
								$myArr=array("Current Asset","");
								$excel->writeLine($myArr);
								$myArr=array("Inter Project Current Asset",$ipca_current_asset);
								$excel->writeLine($myArr);

								
								
								
							$chkfourcountled=mysql_query("SELECT * FROM head_sub_list WHERE list_of_head_accounts_id='1' AND list_of_sub_head_accounts_id='2'");
							$currentasset=0;
							while($cogsexpense=mysql_fetch_array($chkfourcountled))
							{
							$cogsid=$cogsexpense['id'];
								$chkvisibleledgeraccount=mysql_num_rows(mysql_query("SELECT * FROM ladger_list_properties WHERE main_head_id='1' AND head_sub_list_id='$cogsid'"));
							if($chkvisibleledgeraccount!=0)
							{
								
								$ld=mysql_query("SELECT * FROM ladger_list_properties WHERE main_head_id='1' AND head_sub_list_id='$cogsid'");
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
										$netm1=$debit-$cradit;
										if($netm1!=0)
										{
							 
                                            
                                            
                                            $getch=substr($netm1,0,1);
                                            /*if($getch!='-')
                                            { echo number_format($netm1,2); }
                                            else
                                            { echo "(".number_format(substr($netm1,1,200),2).")"; }  */
                                           $currentasset+=$netm1;
                                            
												$myArr=array($row['head_sub_list_name'],$netm1);
								 				$excel->writeLine($myArr);
									 
									 
									 
									 
                                            }
                                     } 
							}
							
							}
																				
							
								$chktr=substr($currentasset,0,1);
								if($chktr!='-'){ 
									$currentassettotal=$currentasset+$ipca_current_asset; 
								}else{ 
								$currentassettotal=substr($currentasset,1,200)+$ipca_current_asset; 
								
								}
								$myArr=array("Total for Current Asset",$currentassettotal);
								$excel->writeLine($myArr);
								$myArr=array("","");
								$excel->writeLine($myArr);
								$myArr=array("Long Term Investment","");
								$excel->writeLine($myArr);
								
								
							$chkfourcountledlong=mysql_query("SELECT * FROM head_sub_list WHERE list_of_head_accounts_id='1' AND list_of_sub_head_accounts_id='3' AND list_of_sub_head_list_id='5'");
							$longterminvestment=0;
							while($cogsexpenselong=mysql_fetch_array($chkfourcountledlong))
							{
							$cogsidlong=$cogsexpenselong['id'];
								$chkvisibleledgeraccountlong=mysql_num_rows(mysql_query("SELECT * FROM ladger_list_properties WHERE main_head_id='1' AND head_sub_list_id='$cogsidlong'"));
							if($chkvisibleledgeraccountlong!=0)
							{
								
								$ldlong=mysql_query("SELECT * FROM ladger_list_properties WHERE main_head_id='1' AND head_sub_list_id='$cogsidlong'");
								while($rowlong=mysql_fetch_array($ldlong))
								{
									
									$inidlong=$rowlong['id']; 
									//$getdutotallong=mysql_query("SELECT * FROM ladger WHERE ladger_id='$inidlong'");
									if(@$fdate=='')
									{
										$getdutotallong=mysql_query("SELECT * FROM ladger WHERE ladger_id='$inidlong' AND ladger_date='".date('Y-m-d')."'");
									}
									else
									{
										$getdutotallong=mysql_query("SELECT * FROM ladger WHERE ladger_id='$inidlong' AND ladger_date BETWEEN '$from' AND '$to'");
									}
											$debitlong=0;
											$craditlong=0;
										while($duelong=mysql_fetch_array($getdutotallong))
										{
											$debitlong+=$duelong['debit'];
											$craditlong+=$duelong['cradit'];
										}
										$netm2long=$debitlong-$craditlong;
										if($netm2long!=0)
										{ 
											
                                            
                                            $getchlong=substr($netm2long,0,1);
/*                                            if($getchlong!='-')
                                            { echo number_format($netm2long,2); }
                                            else
                                            { echo "(".number_format(substr($netmlong,1,200),2).")"; }*/  
                                            $longterminvestment+=$debitlong-$craditlong;
                                            
											
											$myArr=array($rowlong['head_sub_list_name'],$netm2long);
											$excel->writeLine($myArr);

                                           
                                        }
                                     } 
							}
							
							}
							
								$myArr=array("Total For Long Term Investment",$longterminvestment);
								$excel->writeLine($myArr);
								$myArr=array("Fixed Asset","");
								$excel->writeLine($myArr);
							
                            $chkfourcountled=mysql_query("SELECT * FROM head_sub_list WHERE list_of_head_accounts_id='1' AND list_of_sub_head_accounts_id='3'");
							$fixedasset=0;
							while($cogsexpense=mysql_fetch_array($chkfourcountled))
							{
							$cogsid=$cogsexpense['id'];
								$chkvisibleledgeraccount=mysql_num_rows(mysql_query("SELECT * FROM ladger_list_properties WHERE main_head_id='1' AND head_sub_list_id='$cogsid'"));
							if($chkvisibleledgeraccount!=0)
							{
								
								$ld=mysql_query("SELECT * FROM ladger_list_properties WHERE main_head_id='1' AND head_sub_list_id='$cogsid' AND  head_sub_list_name!='Acumulated Depriciation'");
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
										$netm2=$debit-$cradit;
										if($netm2!=0)
										{ 
										
											$fixedasset+=$debit-$cradit;
                                           
                                        }
                                     } 
							}
							
							}
							
							$myArr=array("Fixed Assets at cost",$fixedasset);
							$excel->writeLine($myArr);
							 
                                    
								$llphl=mysql_query("SELECT * FROM ladger_list_properties WHERE head_sub_list_name='Acumulated Depriciation'");
								$fixedassetllphl=0;
								while($rowllphl=mysql_fetch_array($llphl))
								{
									
									$inidllphl=$rowllphl['id']; 
									//$getdutotalllphl=mysql_query("SELECT * FROM ladger WHERE ladger_id='$inidllphl'");
									if(@$fdate=='')
									{
										$getdutotalllphl=mysql_query("SELECT * FROM ladger WHERE ladger_id='$inidllphl' AND ladger_date='".date('Y-m-d')."'");
									}
									else
									{
										$getdutotalllphl=mysql_query("SELECT * FROM ladger WHERE ladger_id='$inidllphl' AND ladger_date BETWEEN '$from' AND '$to'");
									}
											$debitllphl=0;
											$craditllphl=0;
										while($duellphl=mysql_fetch_array($getdutotalllphl))
										{
											$debitllphl+=$duellphl['debit'];
											$craditllphl+=$duellphl['cradit'];
										}
										$netm2llphl=$debitllphl-$craditllphl;
										if($netm2llphl!=0)
										{ 
											$fixedassetllphl+=$debitllphl-$craditllphl;
										}
                                     } 
									 
									 $chkminus=substr($fixedassetllphl,0,1);
									 
									/* if($chkminus=="-")
									 {
										echo "(".number_format(substr($fixedassetllphl,1,100),2).")";
									 }
									 else
									 {
										 echo number_format($fixedassetllphl,2);
									 }*/
									$myArr=array("(-) Accumulated Depriciation",$fixedassetllphl);
							 		$excel->writeLine($myArr);
							 
								//echo number_format($fixedasset+$fixedassetllphl,2);
								$tptotalfixxedassets=$fixedasset+$fixedassetllphl;
								$myArr=array("Total for Fixed Asset",$tptotalfixxedassets);
								$excel->writeLine($myArr);
								$myArr=array("","");
								$excel->writeLine($myArr);
								
								$myArr=array("Intangible Assets","");
								$excel->writeLine($myArr);
								
                            
							$chkfourcountledinten=mysql_query("SELECT * FROM head_sub_list WHERE list_of_head_accounts_id='1' AND list_of_sub_head_accounts_id='3' AND list_of_sub_head_list_id='43'");
							$intenterminvestment=0;
							while($cogsexpenseinten=mysql_fetch_array($chkfourcountledinten))
							{
							$cogsidinten=$cogsexpenseinten['id'];
								$chkvisibleledgeraccountinten=mysql_num_rows(mysql_query("SELECT * FROM ladger_list_properties WHERE main_head_id='1' AND head_sub_list_id='$cogsidinten'"));
							if($chkvisibleledgeraccountinten!=0)
							{
								
								$ldinten=mysql_query("SELECT * FROM ladger_list_properties WHERE main_head_id='1' AND head_sub_list_id='$cogsidinten'");
								while($rowinten=mysql_fetch_array($ldinten))
								{
									
									$inidinten=$rowinten['id']; 
										//$getdutotalinten=mysql_query("SELECT * FROM ladger WHERE ladger_id='$inidinten'");
									if(@$fdate=='')
									{
										$getdutotalinten=mysql_query("SELECT * FROM ladger WHERE ladger_id='$inidinten' AND ladger_date='".date('Y-m-d')."'");
									}
									else
									{
										$getdutotalinten=mysql_query("SELECT * FROM ladger WHERE ladger_id='$inidinten' AND ladger_date BETWEEN '$from' AND '$to'");
									}
											$debitinten=0;
											$craditinten=0;
										while($dueinten=mysql_fetch_array($getdutotalinten))
										{
											$debitinten+=$dueinten['debit'];
											$craditinten+=$dueinten['cradit'];
										}
										$netm2inten=$debitinten-$craditinten;
										if($netm2inten!=0)
										{ 
										
                                            
                                            $getchinten=substr($netm2inten,0,1);
                                            /*if($getchinten!='-')
                                            { echo number_format($netm2inten,2); }
                                            else
                                            { echo "(".number_format(substr($netminten,1,200),2).")"; } */ 
                                            $intenterminvestment+=$debitinten-$craditinten;
                                            
                                           $myArr=array($rowinten['head_sub_list_name'],$netm2inten);
										   $excel->writeLine($myArr);
                                        }
                                     } 
							}
							
							}
							$myArr=array("Total For Intangible Assets",$intenterminvestment);
							$excel->writeLine($myArr);
							$myArr=array("","");
							$excel->writeLine($myArr);
							
                            $totalasset=$total_revenue+$currentasset+$ipca_current_asset+$tptotalfixxedassets+$longterminvestment+$intenterminvestment; 
							$myArr=array("Total Asset",$totalasset); 
							$excel->writeLine($myArr);
							$myArr=array("",""); 
							$excel->writeLine($myArr);
							$myArr=array("Liability","");
							$excel->writeLine($myArr); 
							$myArr=array("Current Liability","");
							$excel->writeLine($myArr); 
							$myArr=array("Inter Current Project Account",$ipca_current_liability);
							$excel->writeLine($myArr); 
							
							$chkfourcountledcurrentliability=mysql_query("SELECT * FROM head_sub_list WHERE list_of_head_accounts_id='2' AND list_of_sub_head_accounts_id='1'");
							$currentliability=0;
							while($cogsexpensecurrentliability=mysql_fetch_array($chkfourcountledcurrentliability))
							{
							$cogsidcurrentliability=$cogsexpensecurrentliability['id'];
								$chkvisibleledgeraccountcurrentliability=mysql_num_rows(mysql_query("SELECT * FROM ladger_list_properties WHERE main_head_id='2' AND head_sub_list_id='$cogsidcurrentliability'"));
							if($chkvisibleledgeraccountcurrentliability!=0)
							{
								
								$ldcurrentliability=mysql_query("SELECT * FROM ladger_list_properties WHERE main_head_id='2' AND head_sub_list_id='$cogsidcurrentliability'");
								while($rowcurrentliability=mysql_fetch_array($ldcurrentliability))
								{
									
									$inidcurrentliability=$rowcurrentliability['id']; 
										//$getdutotalcurrentliability=mysql_query("SELECT * FROM ladger WHERE ladger_id='$inidcurrentliability'");
									if(@$fdate=='')
									{
										$getdutotalcurrentliability=mysql_query("SELECT * FROM ladger WHERE ladger_id='$inidcurrentliability' AND ladger_date='".date('Y-m-d')."'");
									}
									else
									{
										$getdutotalcurrentliability=mysql_query("SELECT * FROM ladger WHERE ladger_id='$inidcurrentliability' AND ladger_date BETWEEN '$from' AND '$to'");
									}
										
											$debitcurrentliability=0;
											$craditcurrentliability=0;
										while($duecurrentliability=mysql_fetch_array($getdutotalcurrentliability))
										{
											$debitcurrentliability+=$duecurrentliability['debit'];
											$craditcurrentliability+=$duecurrentliability['cradit'];
										}
										$netm2currentliability=$debitcurrentliability-$craditcurrentliability;
										if($netm2currentliability!=0)
										{ 
										                         
                                            
                                            $getchcurrentliability=substr($netm2currentliability,0,1);
                                            /*if($getchcurrentliability!='-')
                                            { echo number_format($netm2currentliability,2); }
                                            else
                                            { echo number_format(substr($netm2currentliability,1,200),2); } */ 
                                            $currentliability+=$debitcurrentliability-$craditcurrentliability;
                                            
											$myArr=array($rowcurrentliability['head_sub_list_name'],$netm2currentliability);
											$excel->writeLine($myArr); 
                                           
                                        }
                                     } 
							}
							
							}
							
							
								
							 
							  	$liabilitycurrent=$currentliability;
								
								$myArr=array("Total for Current Liability",$liabilitycurrent);
								$excel->writeLine($myArr);
								/*$chktr=substr($liabilitycurrent,0,1);
								if($chktr!="-")
								{ echo number_format($liabilitycurrenttotal=$liabilitycurrent,2); }
								else
								{ echo number_format($liabilitycurrenttotal=substr($liabilitycurrent,1,200),2); }*/
								$myArr=array("Long Term Liability","");
								$excel->writeLine($myArr);
								
							$chkfourcountledliablity=mysql_query("SELECT * FROM head_sub_list WHERE list_of_head_accounts_id='2' AND list_of_sub_head_accounts_id='2' AND list_of_sub_head_list_id='10'");
							$liablityterminvestment=0;
							while($cogsexpenseliablity=mysql_fetch_array($chkfourcountledliablity))
							{
							$cogsidliablity=$cogsexpenseliablity['id'];
								$chkvisibleledgeraccountliablity=mysql_num_rows(mysql_query("SELECT * FROM ladger_list_properties WHERE main_head_id='2' AND head_sub_list_id='$cogsidliablity'"));
							if($chkvisibleledgeraccountliablity!=0)
							{
								
								$ldliablity=mysql_query("SELECT * FROM ladger_list_properties WHERE main_head_id='2' AND head_sub_list_id='$cogsidliablity'");
								while($rowliablity=mysql_fetch_array($ldliablity))
								{
									
									$inidliablity=$rowliablity['id']; 
										//$getdutotalliablity=mysql_query("SELECT * FROM ladger WHERE ladger_id='$inidliablity'");
									if(@$fdate=='')
									{
										$getdutotalliablity=mysql_query("SELECT * FROM ladger WHERE ladger_id='$inidliablity' AND ladger_date='".date('Y-m-d')."'");
									}
									else
									{
										$getdutotalliablity=mysql_query("SELECT * FROM ladger WHERE ladger_id='$inidliablity' AND ladger_date BETWEEN '$from' AND '$to'");
									}
											$debitliablity=0;
											$craditliablity=0;
										while($dueliablity=mysql_fetch_array($getdutotalliablity))
										{
											$debitliablity+=$dueliablity['debit'];
											$craditliablity+=$dueliablity['cradit'];
										}
										$netm2liablity=$debitliablity-$craditliablity;
										if($netm2liablity!=0)
										{ 
										
                                            $getchliablity=substr($netm2liablity,0,1);
                                            /*if($getchliablity!='-')
                                            { echo number_format($netm2liablity,2); }
                                            else
                                            { echo number_format(substr($netm2liablity,1,200),2); } */ 
                                            $liablityterminvestment+=$debitliablity-$craditliablity;
                                            
                                           $myArr=array($rowliablity['head_sub_list_name'],$netm2liablity);
										   $excel->writeLine($myArr);
                                        }
                                     } 
							}
							
							}
							
							
							 $myArr=array("Total For Long Term Liability ",$liablityterminvestment);
							 $excel->writeLine($myArr);
							
							  $mkltl=substr($liablityterminvestment,0,1);
							  $fullmkltl=substr($liablityterminvestment,1,200);
							  /*if($mkltl!="-")
							  {
								  echo number_format($liablityterminvestment,2);
							  }
							  else
							  {
								  echo number_format($fullmkltl,2);
							  }*/
							  
							
								$sdh=substr($liabilitycurrent,0,1);
								
								$absliablity=substr($liabilitycurrent,1,200);
								
								$chkmltin=substr($liablityterminvestment,0,1);
								
								$fullmltin=substr($liablityterminvestment,1,200);
								
							
								
								if($sdh=="-")
								{
									
									if($chkmltin=="-")
									{
										$mkli=$fullmltin;
									}
									else
									{
										$mkli=$liablityterminvestment;
									}
									
									$ttliabilities=$absliablity+$ipca_current_liability+$mkli;	
								}
								else
								{
									
									if($chkmltin=="-")
									{
										$mkli=$fullmltin;
									}
									else
									{
										$mkli=$liablityterminvestment;
									}
									$ttliabilities=$liabilitycurrent+$ipca_current_liability+$mkli;
								}
								//echo number_format($ttliabilities,2);
								//if($sdh)
								
								//$ipca_current_liability;
								//echo $liabilitycurrent;								
								$myArr=array("Total Liabilities",$ttliabilities);
								$excel->writeLine($myArr);	
								$myArr=array("","");	
								$excel->writeLine($myArr);
								$myArr=array("Equity","");
								$excel->writeLine($myArr);	
                            
							$chkfourcountled=mysql_query("SELECT * FROM head_sub_list WHERE list_of_head_accounts_id='5'");
							$totalequity=0;
							while($cogsexpense=mysql_fetch_array($chkfourcountled))
							{
							$cogsid=$cogsexpense['id'];
								$chkvisibleledgeraccount=mysql_num_rows(mysql_query("SELECT * FROM ladger_list_properties WHERE main_head_id='5' AND head_sub_list_id='$cogsid'"));
							if($chkvisibleledgeraccount!=0)
							{
								
								$ld=mysql_query("SELECT * FROM ladger_list_properties WHERE main_head_id='5' AND head_sub_list_id='$cogsid'");
								while($row=mysql_fetch_array($ld))
								{
									
									$inid=$row['id']; 
										//$getdutotal=mysql_query("SELECT * FROM ladger WHERE ladger_id='$inid'");
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
										$netm4=$debit-$cradit;
										if($netm4!=0)
										{
							
                                            
                                            $getch=substr($netm4,0,1);
                                            /*if($getch!='-')
                                            { echo number_format($netm4,2); }
                                            else
                                            { echo number_format(substr($netm4,1,200),2); } */ 
                                            $totalequity+=$netm4;
                                            
									 			$myArr=array($row['head_sub_list_name'],$netm4);
												$excel->writeLine($myArr);	
									 
									 
                                            }
                                     } 
							}
							
							}
							 
							 
							 
							
							 
							 
							 
							  $preyear=date('Y');
							  $previousyear=$preyear-1;
							  $chkpredata=mysql_num_rows(mysql_query("SELECT * FROM  income_statement WHERE year='$previousyear'"));
							  if($chkpredata==0)
							  {
								 $ffg="0"; 
							  }
							  else
							  {
								  $querypre=mysql_query("SELECT * FROM income_statement WHERE year='$previousyear'");
								  $fetpre=mysql_fetch_array($querypre);
								  $ffg=$fetpre['amount'];
							  }
							  
							   $myArr=array("Retained Earnings",$ffg);
							   $excel->writeLine($myArr);	
							  
							 
							$inyear=date('Y');
							$netprofit_query=mysql_query("SELECT * FROM  income_statement WHERE year='$inyear'");
							$fetnet=mysql_fetch_array($netprofit_query);
							$netprofit=$fetnet['amount'];
							$chknp=substr($netprofit,0,1);
							$chknpp=substr($netprofit,1,200);
							/*
							if($chknp!="-")
							{
								echo number_format($netprofit,2);
							}
							else
							{
								echo number_format(substr($netprofit,1,200),2);
							}
							*/
							$myArr=array("Current Year Earnings",$netprofit);	
							$excel->writeLine($myArr);
							
							  $feq=$totalequity+$netprofit;
							  
							  $chknp1=substr($feq,0,1);
							
							/*if($chknp1!="-")
							{
								echo number_format($feq,2);
							}
							else
							{
								echo number_format(substr($feq,1,200),2);
							}*/
							$myArr=array("Total Equity",$feq);
							$excel->writeLine($myArr);
							$totalasset=$ttliabilities+$feq;
							$myArr=array("Total Liabilities and Equity",$totalasset);
							$excel->writeLine($myArr);
					
					
					
					
					
					
																?>
                                
									
<meta http-equiv="refresh" content="2;url=incomestatement.xls">
</body>
</html>
  