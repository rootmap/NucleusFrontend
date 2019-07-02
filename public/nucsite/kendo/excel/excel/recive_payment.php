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

$excel=new ExcelWriter("billreport.xls");
if($excel==false)	
echo $excel->error;
$myArr=array("");
$myArr=array("Receive Payment Statement");
$excel->writeLine($myArr);
$myArr=array("");
$excel->writeLine($myArr);
$myArr=array("Particulars ","Amount");
$excel->writeLine($myArr);
/*$from=1;
$to=3;*/
/*$qry=mysql_query("select * from journal_description");
if($qry!=false)
{
	$i=1;
	while($res=mysql_fetch_array($qry))
	{			
		$myArr=array($res['id'],$res['jd'],$res['jddate']);
		$excel->writeLine($myArr);
		$i++;
	}
}*/
					$myArr=array("","");
		$excel->writeLine($myArr);		
							$myArr=array("Receive","");
		$excel->writeLine($myArr);	
							$myArr=array("","");
		$excel->writeLine($myArr);
$myArr=array("Opening Balance","");
		$excel->writeLine($myArr);
$opfrom="1990-02-02";														   
@$opto=date("Y-m-d", mktime(0,0,0,date($fmonth, $time),date($fdate,$time)- 1 ,date($fyear, $time))); 
                                                    
$chkfourcountled=mysql_query("SELECT * FROM head_sub_list WHERE list_of_head_accounts_id='1' AND list_of_sub_head_accounts_id='1'");
							$opening=0;
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
										$getdutotal=mysql_query("SELECT * FROM ladger WHERE ladger_id='$inid' AND ladger_date='$curda'");
									}
									else
									{
										
										$getdutotal=mysql_query("SELECT * FROM ladger WHERE ladger_id='$inid' AND ladger_date BETWEEN '$opfrom' AND '$opto'");	
									}
											$debit=0;
											$cradit=0;
										
										while($due=mysql_fetch_array($getdutotal))
										{
											$debit+=$due['debit'];
											$cradit+=$due['cradit'];
										}
										$netm=$debit-$cradit;
										$opening+=$netm;
										if($netm!=0)
										{
							
											
                                            
                                            
                                            $getch=substr($netm,0,1);
                                            if($getch!='-')
                                            {  $pp=number_format($netm,2); }
                                            else
                                            {  $pp="(".number_format(substr($netm,1,200),2).")"; }  
                                            //echo $pp;
                                            $myArr=array($row['head_sub_list_name'],$pp);
											$excel->writeLine($myArr);
                                            }
                                     } 
							}
							
							}
							 
                              $myArr=array("Sub Total",$opening);
							  $excel->writeLine($myArr);
							  
                                                        $sqlrp=mysql_query("SELECT * FROM  ladger_list_properties");
														$cashin=0;
                                                        while($rp=mysql_fetch_array($sqlrp))
                                                        {
                                                            $inid=$rp['id'];
															if(@$fdate=='')
															{
                                                           		$sqlled=mysql_query("SELECT * FROM rpstatement WHERE ledger_id='$inid' AND rpdate='$curda'");	
															}
															else
															{
																$sqlled=mysql_query("SELECT * FROM rpstatement WHERE ledger_id='$inid' AND rpdate BETWEEN '$from' AND '$to'");	
															}
															
                                                            $led=0;
                                                            while($lld=mysql_fetch_array($sqlled))
                                                            {
                                                                
                                                                $led+=$lld['debitamount'];
                                                                
                                                            }
															$cashin+=$led;
                                                            if($led!=0)
                                                            {
                                                            
                                                       
																$myArr=array($rp['head_sub_list_name'],$led);
																$excel->writeLine($myArr);
                                                         
                                                            }
                                                        }
                                                        
														$myArr=array("Total Received",$cashin);
														$myArr=array("Total",$cashin+$opening);
														$excel->writeLine($myArr);
														
														
														
														
					$myArr=array("","");
		$excel->writeLine($myArr);		
							$myArr=array("Payment","");
		$excel->writeLine($myArr);	
							$myArr=array("","");
		$excel->writeLine($myArr);	
		$myArr=array("Particulars","Amount");
		$excel->writeLine($myArr);

                                                        $sqlrpc=mysql_query("SELECT * FROM head_list WHERE id='40' or id='41' or id='42'");
														$cashout=0;
                                                        while($rpc=mysql_fetch_array($sqlrpc))
                                                        {
                                                            $inids=$rpc['id'];
															
															if(@$fdate=='')
															{
                                                            $sqlleds=mysql_query("SELECT * FROM assetmoneyrp WHERE led_id='$inids' AND pdate='$curda'");
															}
															else
															{
															$sqlleds=mysql_query("SELECT * FROM assetmoneyrp WHERE led_id='$inids' AND pdate BETWEEN '$from' AND '$to'");
															}
                                                            $ledc=0;
                                                            while($llds=mysql_fetch_array($sqlleds))
                                                            {
                                                                
                                                                $ledc+=$llds['craditamount'];
                                                                
                                                            }
															
															$cashout+=$ledc;
                                                            if($ledc!=0)
                                                            {
                                                            
                                                        		$myArr=array($rpc['head_title'],$ledc);
																$excel->writeLine($myArr);  
                                                   
                                                            }
                                                        }
                                                        
														$ssd=mysql_query("SELECT * FROM  ladger_list_properties");
														$jj=0;
														while($rssd=mysql_fetch_array($ssd))
														{
															$ddid=$rssd['id'];
															if(@$fdate=='')
															{
                                                            $sqlleds=mysql_query("SELECT * FROM bill_rec_pay WHERE led_id='$ddid' AND pdate='$curda'");
															}
															else
															{
															$sqlleds=mysql_query("SELECT * FROM bill_rec_pay WHERE led_id='$ddid' AND pdate BETWEEN '$from' AND '$to'");
															}
															$cass=0;
                                                            while($llds=mysql_fetch_array($sqlleds))
                                                            {
																 $cass+=$llds['amount'];
                                                            }
															if($cass!=0)
															{
                                                        		$myArr=array($rssd['head_sub_list_name'],$cass);
																$excel->writeLine($myArr);   
																$jj+=$cass;
															
                                                            
														}
														}
                                                        $myArr=array("Total Payment",$cashout+$jj);
														$excel->writeLine($myArr);
                                                		$myArr=array("Closing Balance",($cashin+$opening)-($cashout+$jj));
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
															$getdutotal=mysql_query("SELECT * FROM ladger WHERE ladger_id='$inid' AND ladger_date='$curda'");
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
																$myArr=array($row['head_sub_list_name'],$netm);
																$excel->writeLine($myArr); 
							
                                           						 $total_revenue+=$netm;
                                          
                                            }
                                     } 
							}
							
							}
							 								$myArr=array("Total",$total_revenue);
															$excel->writeLine($myArr); 
                                                        
                                                    												
														
?>
<meta http-equiv="refresh" content="2;url=billreport.xls">
</body>
</html>
  