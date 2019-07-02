<?php 
session_start();
include_once ('class/db_Class.php');
$obj = new db_class();
$id=$_SESSION['SESS_AMSIT_APPS_ID'];
$inputstatus=$_SESSION['SESS_AMSIT_EMP_STATUS'];
		if($id==!"")
	{
	unset($_SESSION['SESS_AMSIT_APPS_ID']);
	unset($_SESSION['SESS_AMSIT_EMP_NAME']);
	unset($_SESSION['SESS_AMSIT_EMP_STATUS']);
	unset($_SESSION['timezone']);
	unset($_SESSION['SESS_CASHIER_ID']);
	unset($_SESSION['SESS_CART']);
	unset($_SESSION['SESS_CUSID']);
	unset($_SESSION['SESS_CART_TICKET']);
	unset($_SESSION['SESS_CART_UNLOCK']);
	unset($_SESSION['SESS_CART_BUYBACK']);
	unset($_SESSION['SESS_CART_ESTIMATES']);
	unset($_SESSION['SESS_CART_INVOICE']);
			
			$errmsg_arr[] ='Account Has Been logged Out';
			$errflag = true;
			
			if($errflag) 
					{
						$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
						session_write_close();
						header("location: login.php");
						exit();
					}
	}
	else
	{
	unset($_SESSION['SESS_AMSIT_APPS_ID']);
	unset($_SESSION['SESS_AMSIT_EMP_NAME']);
	unset($_SESSION['SESS_AMSIT_EMP_STATUS']);
	unset($_SESSION['timezone']);
	unset($_SESSION['SESS_CASHIER_ID']);
	unset($_SESSION['SESS_CART']);
	unset($_SESSION['SESS_CUSID']);
	unset($_SESSION['SESS_CART_TICKET']);
	unset($_SESSION['SESS_CART_UNLOCK']);
	unset($_SESSION['SESS_CART_BUYBACK']);
	unset($_SESSION['SESS_CART_ESTIMATES']);
	unset($_SESSION['SESS_CART_INVOICE']);
			$errmsg_arr[] ='Account Has Been logged Out';
			$errflag = true;
			
			if($errflag) 
					{
						$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
						session_write_close();
						header("location: login.php");
						exit();
					}
	
	}
?>