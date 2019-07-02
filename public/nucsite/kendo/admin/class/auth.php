<?php 
@session_start();
$error_data[]='';
$error_flag=false;

if(!isset($_SESSION['SESS_ID']) || (trim($_SESSION['SESS_ID']) == '')) 
{
		$error_data[] = 'Login Session Expired Please Login';
		$error_flag = true;
		if($error_flag) {
			$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
			session_write_close();
			header("location: login.php");
			exit();
					}
}

include('db_Class.php');	
$obj = new db_class();
$obj->MySQL();
$input_by=$_SESSION['SESS_ID'];
$input_datetime=date('Y-m-d');

$sqluserinfoquery=mysql_query("SELECT * FROM userlist WHERE id='$input_by'");
$fetdata=mysql_fetch_array($sqluserinfoquery);
$u_fullname=$fetdata['fullname'];	
$u_dob=$fetdata['dob'];
$u_sex=$fetdata['sex'];	
$u_address=$fetdata['address'];
$u_email=$fetdata['email'];
$u_username=$fetdata['username'];
$u_password=$fetdata['password'];
$u_joining=$fetdata['joining'];
$status=$fetdata['status'];


function usertype($type)
{
    if($type==1)
    {
       $result="Content Writer";                
    }
    elseif ($type==2) 
    {
     $result="Content Publisher";
    }
    elseif($type==3)
    {
     $result="SEO Developer";
    }
    elseif ($type==4) 
    {
     $result="Full Access Administrator";
    }
    return $result;
}


if($status==1)
{
	$power="Site Administration";	
}
elseif($status==2)
{
	$power="Super Admin";	
}
elseif($status==3)
{
	$power="Partial Admin";	
}

if(!isset($_SESSION['timezone']))
{
    if(!isset($_REQUEST['offset']))
    {
    ?>
    <script>
    var d = new Date()
    var offset= -d.getTimezoneOffset()/60;
    location.href = "<?php echo $_SERVER['PHP_SELF']; ?>?offset="+offset;
    </script>
    <?php   
    }
    else
    {
        $zonelist = array('Kwajalein' => -12.00, 'Pacific/Midway' => -11.00, 'Pacific/Honolulu' => -10.00, 'America/Anchorage' => -9.00, 'America/Los_Angeles' => -8.00, 'America/Denver' => -7.00, 'America/Tegucigalpa' => -6.00, 'America/New_York' => -5.00, 'America/Caracas' => -4.30, 'America/Halifax' => -4.00, 'America/St_Johns' => -3.30, 'America/Argentina/Buenos_Aires' => -3.00, 'America/Sao_Paulo' => -3.00, 'Atlantic/South_Georgia' => -2.00, 'Atlantic/Azores' => -1.00, 'Europe/Dublin' => 0, 'Europe/Belgrade' => 1.00, 'Europe/Minsk' => 2.00, 'Asia/Kuwait' => 3.00, 'Asia/Tehran' => 3.30, 'Asia/Muscat' => 4.00, 'Asia/Yekaterinburg' => 5.00, 'Asia/Kolkata' => 5.30, 'Asia/Katmandu' => 5.45, 'Asia/Dhaka' => 6.00, 'Asia/Rangoon' => 6.30, 'Asia/Krasnoyarsk' => 7.00, 'Asia/Brunei' => 8.00, 'Asia/Seoul' => 9.00, 'Australia/Darwin' => 9.30, 'Australia/Canberra' => 10.00, 'Asia/Magadan' => 11.00, 'Pacific/Fiji' => 12.00, 'Pacific/Tongatapu' => 13.00);
        $index = array_keys($zonelist, $_REQUEST['offset']);
        $_SESSION['timezone'] = $index[0];
    }
}

date_default_timezone_set($_SESSION['timezone']);
?>