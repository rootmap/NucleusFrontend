<?php 

	//$to=$report_cpmpany_email;
	$TO = array("f.bhuyian@gmail.com",$report_cpmpany_email);
	$sender ="Renad Bhuyian";
	$user_email="contact@amsitsoft.com";
	$message = '<!DOCTYPE HTML><head><meta http-equiv="content-type" content="text/html">
	<title>Email notification From NucleusPos</title>';
	 $message .= "</head>";
	 $message .= "<body>";
	 

   $message .= "<style type='text/css'>
	 .email_table {
	margin:0px;padding:0px;
	width:100%;
	height:auto;
	clear:both;
	border:1px solid #0057af;
	
	-moz-border-radius-bottomleft:0px;
	-webkit-border-bottom-left-radius:0px;
	border-bottom-left-radius:0px;
	
	-moz-border-radius-bottomright:0px;
	-webkit-border-bottom-right-radius:0px;
	border-bottom-right-radius:0px;
	
	-moz-border-radius-topright:0px;
	-webkit-border-top-right-radius:0px;
	border-top-right-radius:0px;
	
	-moz-border-radius-topleft:0px;
	-webkit-border-top-left-radius:0px;
	border-top-left-radius:0px;
}.email_table table{
    border-collapse: collapse;
        border-spacing: 0;
	width:100%;
	margin:0px;padding:0px;
}.email_table tr:last-child td:last-child {
	-moz-border-radius-bottomright:0px;
	-webkit-border-bottom-right-radius:0px;
	border-bottom-right-radius:0px;
}
.email_table table tr:first-child td:first-child {
	-moz-border-radius-topleft:0px;
	-webkit-border-top-left-radius:0px;
	border-top-left-radius:0px;
}
.email_table table tr:first-child td:last-child {
	-moz-border-radius-topright:0px;
	-webkit-border-top-right-radius:0px;
	border-top-right-radius:0px;
}.email_table tr:last-child td:first-child{
	-moz-border-radius-bottomleft:0px;
	-webkit-border-bottom-left-radius:0px;
	border-bottom-left-radius:0px;
}.email_table tr:hover td{
	background-color:#d3e9ff;
		

}
.email_table td{
	vertical-align:middle;
	
	background-color:#ffffff;

	border:1px solid #0057af;
	border-width:0px 1px 1px 0px;
	text-align:left;
	padding:7px;
	font-size:10px;
	font-family:Arial;
	font-weight:normal;
	color:#000000;
}.email_table tr:last-child td{
	border-width:0px 1px 0px 0px;
}.email_table tr td:last-child{
	border-width:0px 0px 1px 0px;
}.email_table tr:last-child td:last-child{
	border-width:0px 0px 0px 0px;
}
.email_table tr:first-child td{
		background:-o-linear-gradient(bottom, #0057af 5%, #0057af 100%);	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #0057af), color-stop(1, #0057af) );
	background:-moz-linear-gradient( center top, #0057af 5%, #0057af 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#0057af', endColorstr='#0057af');	background: -o-linear-gradient(top,#0057af,0057af);

	background-color:#0057af;
	border:0px solid #0057af;
	text-align:center;
	border-width:0px 0px 1px 1px;
	font-size:14px;
	font-family:Arial;
	font-weight:bold;
	color:#ffffff;
}
.email_table tr:first-child:hover td{
	background:-o-linear-gradient(bottom, #0057af 5%, #0057af 100%);	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #0057af), color-stop(1, #0057af) );
	background:-moz-linear-gradient( center top, #0057af 5%, #0057af 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#0057af', endColorstr='#0057af');	background: -o-linear-gradient(top,#0057af,0057af);

	background-color:#0057af;
}
.email_table tr:first-child td:first-child{
	border-width:0px 0px 1px 0px;
}
.email_table tr:first-child td:last-child{
	border-width:0px 0px 1px 1px;
}
</style>";

	 $message .="<h3>Your Store : Added New Customer This Month. From : 1/".date('m/Y')." To ".date('d/m/Y')." </h3>";
	 $message .="<div class='email_table'><table border='1' width='400' cellpadding='2' cellspacing='2'>";
	 $message .="<tr><td>#</td><td> First Name </td><td> Last Name </td><td> Phone </td><td> Email </td></tr>";
	 $message .="<tr><td colspan=5>No New Customer Record Found For Notify You.</td></tr>";	 
	 /*$sqlcustomer=$obj->SelectAllByID("coustomer",array("input_by"=>$list->store_id));
	 $x=1;
	 if(!empty($sqlcustomer))
	 {
	 foreach($sqlcustomer as $cus):
	 	if($obj->exists_multiple("email_deliver",array("cid"=>$cus->id))==0)
		{
			$message .="<tr><td>".$x."</td><td>".$cus->firstname."</td><td>".$cus->lastname."</td><td>".$cus->phone."</td><td>".$cus->email."</td></tr>";
			$obj->insert("email_deliver",array("cid"=>$cus->id,"date"=>date('Y-m-d'),"status"=>1));
			$d+=1;
		}
		else
		{
			$d+=0;		
		}
	 $x++;
	 endforeach;
	 	if($d==0)
		{
			$message .="<tr><td colspan=5>No New Customer Record Found For Notify You.</td></tr>";	 
		}
	 }
	 else
	 {
		$message .="<tr><td colspan=5>No New Customer Record Found For Notify You.</td></tr>";	 
	 }*/
	 //echo "<tr><td>#</td><td> First Name </td><td> Last Name </td><td> Phone </td><td> Email </td></tr>";
	 $message .="</table></div>";
	//$message .="Your Account is Succesfully Created On Nucleuspos.com<br>";
	
	$message .= "</body>";
	$message .= "</html>";
	$subject="AMS IT CRON JOB";
	$headers  = "From: " . $sender . "\r\n";
	$headers .= "Reply-To: ". $user_email . "\r\n";
	//$headers .= "CC: \r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	//@mail($to,$subject,$message, $headers);
	
	$emo=0;
	if(!empty($TO))
	foreach($TO as $em):
			$se=mail($em,$subject,$message,$headers);
			if($se)
			{
					$emo+=1;
			}
			else
			{
					$emo+=0;	
			}
	endforeach;
	
exit();
?>