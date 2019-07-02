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
/*@$from=@$fyear."-".@$fmonth."-".@$fdate;
@$to=@$tyear."-".@$tmonth."-".@$tdate;
$ofrom=@$fyear."-".@$fmonth."-".@$fdate-1;*/
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

$excel=new ExcelWriter("Asset_voucher.xls");
if($excel==false)	
echo $excel->error;
$myArr=array("");
$myArr=array("Asset Voucher");
$excel->writeLine($myArr);
$myArr=array("");
$excel->writeLine($myArr);
$myArr=array("S/N ","Date  ","Number  ","Vendor ","Amount Due ","Total ");
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
					$myArr=array("","","","","","");
					$excel->writeLine($myArr);		
							$obj->sql("SELECT * FROM asset_voucher");
							$a=1;
							$totaldue=0;
							$totalamount=0;
							$rec=0;
							while($row=mysql_fetch_array($obj->result))
							{
								$inid=$row['id']; 
									$getdutotal=mysql_query("SELECT * FROM asset_voucher_detail WHERE bill_id='$inid'");
										$totaldue=0;
										$total=0;
									while($due=mysql_fetch_array($getdutotal))
									{
										$totaldue+=$due['subtotal'];
										$total+=$due['subtotal'];
									}
									
									$sql_payment=mysql_query("SELECT * FROM asset_voucher_payment WHERE bill_id='$inid'");
									$p=0;
									while($ip=mysql_fetch_array($sql_payment))
									{
										$p+=$ip['amount'];
									}
									
									
									 $sql_leds1=mysql_query("select * from asset_voucher_detail WHERE bill_id='$inid'");
								 $qp1=0;
								 $p1=0;
								 $q1=0;
								 $tax1=0;
									while($fetled1=mysql_fetch_array($sql_leds1)){
										$qp1+=$fetled1['quantity']*$fetled1['price'];
										$p1+=$fetled1['price'];
										$q1+=$fetled1['quantity'];
										$taxid1=$fetled1['tax_id'];
										$sql_vat1=mysql_query("SELECT * FROM newtax WHERE id='$taxid1'");
										$fetvat1=mysql_fetch_array($sql_vat1);
										$tax1+=(($fetled1['quantity']*$fetled1['price'])*$fetvat1['rate'])/100;
									}
									
									
																
                                    
									$bid=$row['vendor_id'];
									$sql_bid=mysql_query("SELECT * FROM vendor WHERE id='$bid'");
									$fetbid=mysql_fetch_array($sql_bid);
									
									$totaldue+=$qp1+$tax1-$p;
									$totalamount+=$qp1+$tax1;
									$rec+=1;
									$myArr=array($a,$row['date'],"Voucher Number - ".$row['id'],$fetbid['company_name'],$qp1+$tax1-$p,$qp1+$tax1);
									$excel->writeLine($myArr);	
							 $a++;
							 }
							 
							 		
									$myArr=array("","","","","","");
									$excel->writeLine($myArr);
									
									$myArr=array("","","","","","");
									$excel->writeLine($myArr);
							 
									$myArr=array("Total Record",$rec,"Total Due ",$totaldue,"Total Amount ",$totalamount);
									$excel->writeLine($myArr);
							 
							 
							 ?> 
									
<meta http-equiv="refresh" content="2;url=Asset_voucher.xls">
</body>
</html>
  