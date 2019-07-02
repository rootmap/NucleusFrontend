<?php  
session_start();
include('../db_Class.php');	
$obj = new db_class();
extract($_POST);
if($st==2)
{
	if($obj->exists_multiple("store",array("email"=>$email))!=0)
	{
		$user_id=$obj->SelectAllByVal("store","email",$email,"id");
		
		$chkreset=$obj->exists_multiple("reset_code_view",array("user_id"=>$user_id));
		$newreset_code=substr($obj->MakePassword(time()),0,4);
			if($chkreset==0)
			{
				
				$obj->insert("reset_code",array("user_id"=>$user_id,"reset_code"=>$newreset_code,"date"=>date('Y-m-d'),"status"=>1));	
				session_regenerate_id();
				$_SESSION['SESS_NUC_RESET_APPS_ID'] = $user_id;
				session_write_close();
			}
			else
			{
				$obj->update("reset_code",array("user_id"=>$user_id,"reset_code"=>$newreset_code,"date"=>date('Y-m-d'),"status"=>1));
				session_regenerate_id();
				$_SESSION['SESS_NUC_RESET_APPS_ID'] = $user_id;
				session_write_close();
			}
			
			$user_fullname=$obj->SelectAllByVal("store","id",$user_id,"name");
			$my_name = "Nucleuspos Reset Password";
			$my_mail = "reset@nucleuspos.com";
			$my_replyto = "contact@nucleuspos.com";
			$my_subject = "Nucleus Reset Password.";
			
			$my_message = "Hallo Sir, Please Reset Your Password using this code : ".$newreset_code.". Using this email address : ".$email;
			
			include("../../phpmail/class.phpmailer.php");
			$email = new PHPMailer();
			$email->From      = $my_mail;
			$email->FromName  = $my_name;
			$email->Subject   = $my_subject;
			$email->Body      = $my_message;
			$email->AddAddress($email,$user_fullname);
			if($email->Send()==1){ echo 1; }
			else{ echo 3; }
			
			
	}
	else
	{
		echo 2;
		$errmsg_arr[] = "<div class='notice outer'>
                            <div class='note note-danger'>
                            <button type='button' class='close'>×</button>
                            <strong>Notice!</strong> Invalid Email, Please Try Again. </div>
                        </div>";
		$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
        session_write_close();				
	}
	
	
}
elseif($st==3)
{
	$reset_user_id=$_SESSION['SESS_NUC_RESET_APPS_ID'];
	if(empty($password))
	{
		echo 0;
	}
	else
	{
		//$signup_ip=$login->GetPcAddress();
		//$user_id=$obj->SelectAllByVal("dostums_user_view",,"reset_code",$reset_code,"id");
		$chkreset=$obj->exists_multiple("store",array("id"=>$reset_user_id));
		if($chkreset==1)
		{	
			$obj->update("store",array("id"=>$reset_user_id,"password"=>$obj->password($password)));
			echo 1;
		}
		else
		{
			echo 2;	
		}
	}
	
}
elseif($st==4)
{
	$reset_user_id=$_SESSION['SESS_NUC_RESET_APPS_ID'];
	if(empty($reset_code))
	{
		echo 0;
	}
	else
	{
		$chkreset=$obj->exists_multiple("reset_code_view",array("user_id"=>$reset_user_id,"reset_code"=>$reset_code));
		if($chkreset==1)
		{	
			echo 1;
		}
		else
		{
			echo 2;	
		}
	}
	
}
else
{
	echo 0;	
}
?>








