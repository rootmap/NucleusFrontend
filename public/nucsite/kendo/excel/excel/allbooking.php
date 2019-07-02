<?php
session_start();

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

$excel=new ExcelWriter("allbooking.xls");
if($excel==false)	
echo $excel->error;
$myArr=array("","","","","","");
$myArr=array("All Booking Detail","","","","","");
$excel->writeLine($myArr);
$myArr=array("","","","","","");

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

$myArr=array("Expected","","","","","");
$excel->writeLine($myArr);		


$myArr=array("From ".$fdate."/".$fmonth."/".$fyear." To ".$tdate."/".$tmonth."/".$tyear);
$excel->writeLine($myArr);	

$myArr=array("","","","","","");
$excel->writeLine($myArr);	

$myArr=array("S/N ","Project Name ","Client Name ","Due/Paid Installment ","Booking Money","Due Time");
$excel->writeLine($myArr);		


                if(@$fdate=='')
                {
                        $obj->sql("SELECT * FROM booking");
                }
                else
                {
                        $obj->sql("SELECT * FROM booking WHERE b_date BETWEEN '$from' AND '$to'");
                }

                $a=1;
                $ddd=0;
                $ppp=0;
                $totbook=0;
                while($row=mysql_fetch_array($obj->result))
                {

                 $proid=$row['pro_id']; $sql=mysql_query("SELECT * FROM project WHERE id='$proid'"); $fep=mysql_fetch_array($sql); 
                                $pro=$row['id'];
                                $chkd=mysql_num_rows(mysql_query("SELECT * FROM  flat_installment WHERE pro_id='$proid' AND booking_id='$pro' AND status='0'"));
                                //echo $chkd;

                                //echo $row['totalflat']-$chkd;
                                $ddd+=$chkd;

$chkds=mysql_num_rows(mysql_query("SELECT * FROM  flat_installment WHERE pro_id='$proid' AND booking_id='$pro' AND status='1'"));
                                //echo $chkds;
                                $ppp+=$chkds;

                                $totbook+=$row['bookingmoney'];

                                 $sqlduedate=mysql_query("SELECT * FROM  flat_installment WHERE pro_id='$proid' AND booking_id='$pro' AND status='0' ORDER BY id ASC LIMIT 1");
                                 $fetduedate=mysql_fetch_array($sqlduedate);

                                                        $myArr=array($a,$fep['pname'],$row['clientname'],$chkd."/".$chkds,$row['bookingmoney'],$fetduedate['dateofpayment']);
                                                        $excel->writeLine($myArr);	





                 $a++;
                 } 



                                                        $myArr=array("Total Due Insallment ",$ddd);
                                                        $excel->writeLine($myArr);
                                                        $myArr=array("Total Paid Insallment ",$ppp);
                                                        $excel->writeLine($myArr);
                                                        $myArr=array("Total Booking Money ",$totbook);
                                                        $excel->writeLine($myArr);

                 ?>
							
							
<meta http-equiv="refresh" content="2;url=allbooking.xls">
</body>
</html>
  