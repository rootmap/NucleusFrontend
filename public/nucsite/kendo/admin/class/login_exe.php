<?php
	session_start();
	require_once('db_Class.php');
	$obj = new db_class();
	$obj->MySQL();
	
	$errmsg_arr = array();
	$errflag = false;
	
	$vvv=$_SERVER['REMOTE_ADDR'];
	$ddd=date('Y-m-d');
	$joining=bn_date(date('d M Y H:i'));
	extract($_GET);
	if($username == '') {
		$errmsg_arr[] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'><i class='icon-remove'></i></button>User Name Required </div>";
		$errflag = true;
	}
	
	if($password == '') {
		$errmsg_arr[] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'><i class='icon-remove'></i></button>Password Required </div>";
		$errflag = true;
	}
	
	if($errflag) {
		$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
		session_write_close();
		header("location: ../login.php");
		exit();
	}
	

	$newuser=cleanQuery($_GET['username']);
	$getpassword=cleanQuery($_GET['password']);
	$nnpass=md5($getpassword);
	//if($)
	//admin part start
	$qry="SELECT * FROM userlist WHERE username='$newuser' AND password='$nnpass' AND statusactive!='2'";
	$result=mysql_query($qry);
	if($result) {
			if(mysql_num_rows($result) == 1) {
					session_regenerate_id();
					$member = mysql_fetch_assoc($result);
					$_SESSION['SESS_ID'] = $member['id'];
					$_SESSION['SESS_USERNAME'] = $member['username'];
																	
					session_write_close();
					$access="Has Been Successfully Log in";
					mysql_query("INSERT INTO accesslist VALUES ('','".$_SESSION['SESS_USERNAME']."','$access','$ddd','$joining')");
					header("location: ../index.php");
					exit();
												}
												else 
												{
													$errmsg_arr[] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'><i class='icon-remove'></i></button>Login Failed Please Try Again </div>";
													$errflag = true;
														if($errflag) {
															$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
															session_write_close();
															header("location: ../login.php");
															exit();
														}
												
												}
			}
			else
			{
													$errmsg_arr[] = "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'><i class='icon-remove'></i></button>User name &amp; Password Could Not Match With Our System </div>";
													$errflag = true;
														if($errflag) {
															$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
															session_write_close();
															header("location: ../login.php");
															exit();
														}
			}
			mysql_close($con);
?>