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

$excel=new ExcelWriter("view_bill.xls");
if($excel==false)	
echo $excel->error;
$myArr=array("");
$myArr=array("View Customer Bill");
$excel->writeLine($myArr);
$myArr=array("");
$excel->writeLine($myArr);
$myArr=array("S/N ","Item  ","Quantity  ","Price  ","Tax ","Amount ","Status ");
$excel->writeLine($myArr);


							$inrow=mysql_num_rows(mysql_query("SELECT * FROM bill_detail WHERE bill_id='$id'"));
							$sql_led=mysql_query("select * from bill_detail WHERE bill_id='$id'");
							$a=1;
							$v_tq=0;
							$v_tp=0;
							$v_ta=0;
							$rec=0;
							while($fetled=mysql_fetch_array($sql_led)){ 
                                    $pid=$fetled['pid'];
									$rec_id=$fetled['id'];
									$sql_pid=mysql_query("SELECT * FROM ladger_list_properties WHERE id='$pid'");
									$fetpid=mysql_fetch_array($sql_pid);
									
									
									
       								$totalprice=$fetled['quantity']*$fetled['price'];
									$tax=$fetled['tax_id'];
									$querytaxrate=mysql_query("SELECT * FROM newtax WHERE id='$tax'");
									$fetrate=mysql_fetch_array($querytaxrate);
									$rate=$fetrate['rate'];
									$name=$fetrate['name'];
									$vat=$totalprice*$rate/100;
									//echo $name."(".$rate."%)".number_format($vat);
									//echo number_format(($fetled['price']*$fetled['quantity'])+$vat);
									
							$chkpaid=mysql_num_rows(mysql_query("SELECT * FROM bill_rec_pay WHERE rec_id='$rec_id' AND bill_id='$id' AND led_id='$pid'"));
							if($chkpaid==0)
							{
									$sttt="Pending";
                             
                             }
                             else 
							 {
								 $chkamount=mysql_query("SELECT * FROM bill_rec_pay WHERE rec_id='$rec_id' AND bill_id='$id' AND led_id='$pid'");
								 $tt=0;
								 while($ttfet=mysql_fetch_array($chkamount))
								 {
									$tt+=$ttfet['amount']; 
								 }
								 $tm=($fetled['price']*$fetled['quantity'])+$vat;
								 if($tt==$tm)
								 {
									 $sttt="Paid";
								 }
								 else
								 {
									 $sttt="Partial";
								 }
							}
						 
						 $rec+=1;
						 $v_tq=$fetled['quantity'];
						 $v_tp=$fetled['price'];
						 $v_ta=($fetled['price']*$fetled['quantity'])+$vat;
						 
						 $myArr=array($a,$fetpid['head_sub_list_name'],$fetled['quantity'],$fetled['price'],$vat,($fetled['price']*$fetled['quantity'])+$vat,$sttt);
						 $excel->writeLine($myArr);

						 
						 
						 $a++;
						 }
							 
							 
									
									
							 
							 
							
							 
							 
									 $myArr=array("","","","","","","");
									$excel->writeLine($myArr);
									
									$myArr=array("","","","","","","");
									$excel->writeLine($myArr);
							 
									$myArr=array("Record-".$rec,"Quantity",$v_tq,"Price=",$v_tp,"Amount",$v_ta);
									$excel->writeLine($myArr);
							 ?> 
									
<meta http-equiv="refresh" content="2;url=view_bill.xls">
</body>
</html>
  