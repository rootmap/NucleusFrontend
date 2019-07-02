<?php
include('../auth.php');


$addsname=cleanQuery($_POST['addsname']);
$imgh=cleanQuery($_POST['imgh']);
	
		if($addsname==''){
			$error_data[]="<div class='alert alert-danger'>Company Name Must Be Filled</div>";
			$error_flag=true;
						}
						
		if($imgh==''){
			$error_data[]="<div class='alert alert-danger'>Image Position Should Be Selected</div>";
			$error_flag=true;
						}
		
		if(empty($_FILES['image']['name'])){
			$error_data[]="<div class='alert alert-danger'>Upload A Image</div>";
			$error_flag=true;
										}
		if($error_flag){
			$_SESSION['ERRMSG_ARR'] = $error_data;
			session_write_close();
			header("location: ../../adds.php");
			exit();
						}
		
		
		$sqlimgdef=mysql_query("SELECT * FROM space WHERE id='$imgh'");
		$fetimg=mysql_fetch_array($sqlimgdef);
		$h=$fetimg['h'];
		$w=$fetimg['w'];
		$destination_thumb="../../../publish_images/adds/";
		$status=$fetimg['status'];
		$floatvalue="left";
		$files =image_caption($w,$h,$destination_thumb);			
		$timg=substr($files,29,30000);
		
		$joining=bn_date(date('d M Y H:i'));
		
		$sql=mysql_query("INSERT INTO adds VALUES ('','$addsname','','$imgh','0','$w','$h','$timg','$input_datetime','$joining','$status')");
		if($sql)
		{ 		
			$error_data[]="<div class='alert alert-success'>Adds Image Successfully Saved</div>";
			$error_flag=true;
			if($error_flag){
							$access="A Adds Has Been Added ";
							mysql_query("INSERT INTO accesslist VALUES ('','$u_fullname','$access','$input_datetime','$joining')");
							$_SESSION['ERRMSG_ARR'] = $error_data;
							session_write_close();
							header("location: ../../adds.php");
							exit();
						}
		
		} 
		else 
		{ 
			$error_data[]="<div class='alert alert-danger'>Adds Save Failed,Try Again</div>";
			$error_flag=true;
			if($error_flag){
							$_SESSION['ERRMSG_ARR'] = $error_data;
							session_write_close();
							header("location: ../../adds.php");
							exit();
							}
		
		}
?>