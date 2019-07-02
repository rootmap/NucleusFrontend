<?php 
include('auth.php');
$id=$_SESSION['SESS_ID'];
$joining=bn_date(date('d M Y H:i'));
$access="Has Been Successfully Logged Out";
							mysql_query("INSERT INTO accesslist VALUES ('','$u_fullname','$access','$input_datetime','$joining')");
if($id==!"")
{
unset($_SESSION['SESS_ID']);
		
		$errmsg_arr[] ='Account Has Been logged Out';
		$errflag = true;
		
		if($errflag) {
		$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
		session_write_close();
		header("location: ../login.php");
		exit();      }


}
else{
unset($_SESSION['SESS_ID']);
		$errmsg_arr[] ='Account Has Been logged Out';
		$errflag = true;
		
		if($errflag) {
		$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
		session_write_close();
		header("location: ../login.php");
		exit();      }

}



?>