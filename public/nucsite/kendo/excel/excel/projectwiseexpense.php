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
	if(@$pid==0)
	{
		$pname="All Project";	
	}
	elseif(@$pid!=0)
	{
		$dd=mysql_query("SELECT * FROM project WHERE id='$pid'");
		$fc=mysql_fetch_array($dd);
		$pname=$fc['pname'];
	}
	else
	{
		$pname="All Project";	
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

$excel=new ExcelWriter("projectwiseexpense.xls");
if($excel==false)	
echo $excel->error;
$myArr=array("","");
$myArr=array($pname,"");
$excel->writeLine($myArr);
$myArr=array("","");
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
	
					
										$myArr=array("Expected","");
					$excel->writeLine($myArr);		
					
					
					$myArr=array("","");
					$excel->writeLine($myArr);	
					
					$myArr=array("From ".$fdate."/".$fmonth."/".$fyear." To ".$tdate."/".$tmonth."/".$tyear,"");
					$excel->writeLine($myArr);	
					
					$myArr=array("","");
					$excel->writeLine($myArr);	
					
			$myArr=array("Particulars ","Taka ");
$excel->writeLine($myArr);		
					
					
					$ld=mysql_query("SELECT * FROM ladger_list_properties");
							$tt=0;
							while($row=mysql_fetch_array($ld))
							{
								$inid=$row['id']; 
								$chk=mysql_num_rows(mysql_query("SELECT * FROM expense_report_via_voucher WHERE ledger_id='$inid'"));
								if($chk!=0)
								{
								if(@$pid!=0)
								{ $sqlchk=mysql_query("SELECT * FROM  expense_report_via_voucher WHERE ledger_id='$inid' AND project_id='$pid' AND edate BETWEEN '$from' AND '$to'"); }
								else
								{ $sqlchk=mysql_query("SELECT * FROM  expense_report_via_voucher WHERE ledger_id='$inid'"); }
								
									$taka=0;
									while($due=mysql_fetch_array($sqlchk))
									{
										$taka+=$due['taka'];
									}
										
										$tt+=$taka;
										$myArr=array($row['head_sub_list_name'],$taka);
										$excel->writeLine($myArr);	
							 
							 
							 }
							}
							$myArr=array("","");
							$excel->writeLine($myArr);
							$myArr=array("Total",$tt);
							$excel->writeLine($myArr);	
			
					
					
					
					
					
					
					
					
					
					
					
									
							 ?>
<meta http-equiv="refresh" content="2;url=projectwiseexpense.xls">
</body>
</html>
  