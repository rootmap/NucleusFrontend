<?php
$phone = "8801728414480";
$sender = "AMS IT";
$message = "HHHHHHH";

$smsuid = 'AMSIT'; // your userid
$smspass = '123456'; // your password

$link ="http://sms.creativeitsoft.com/multismsapi.php?sender=".$sender."&userid=".$smsuid."&password=".$smspass."&type=0&dlr=1&destination=".$phone."&message=".$message."";

$api_status=file_get_contents($link);

echo $api_status;

?>