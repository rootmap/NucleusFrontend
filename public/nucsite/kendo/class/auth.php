<?php
set_time_limit(900000000000000000000000000);
ini_set('memory_limit', '-1');
session_set_cookie_params(0);
if (session_id() == '') {
    //session has not started
    @session_start();
}
$errmsg_arr[] = '';
$error_flag = false;
if (!isset($_SESSION['SESS_AMSIT_APPS_ID']) || (trim($_SESSION['SESS_AMSIT_APPS_ID']) == '')) {
    $error_data[] = 'Login Session Expired Please Login';
    $error_flag = true;
    if ($error_flag) {
        $_SESSION['ERRMSG_ARR'] = $errmsg_arr;
        session_write_close();
        header("location: login.php");
        exit();
    }
}

@$input_datetime = date('Y-m-d');
include('db_Class.php');
$obj = new db_class();
$access_id = $_SESSION['SESS_AMSIT_APPS_ID'];
$input_status = $obj->SelectAllByVal("store", "id", $_SESSION['SESS_AMSIT_APPS_ID'], "status");
if ($input_status == 1) {
    $input_by = $_SESSION['SESS_AMSIT_APPS_ID'];
} elseif ($input_status == 2) {
    $input_bys = $_SESSION['SESS_AMSIT_APPS_ID'];
    $input_by = $obj->SelectAllByVal("store", "id", $input_bys, "store_id");
} elseif ($input_status == 3) {
    $input_bys = $_SESSION['SESS_AMSIT_APPS_ID'];
    $input_by = $obj->SelectAllByVal("store", "id", $input_bys, "store_id");
} elseif ($input_status == 4) {
    $input_bys = $_SESSION['SESS_AMSIT_APPS_ID'];
    $input_by = $obj->SelectAllByVal("store", "id", $input_bys, "store_id");
} elseif ($input_status == 5) {
    $input_by = $_SESSION['SESS_AMSIT_APPS_ID'];
}

$gettav = $obj->SelectAllByVal("tax", "store_id", $input_by, "tax");
if ($gettav != '') {
    $tax_per_product = $gettav;
} else {
    $tax_per_product = 0;
}
/*@$chktimezones = $obj->SelectAllByVal($table, "store_id", $input_by, "time_zone");
if ($chktimezones == '') {
    if (!isset($_SESSION['timezone'])) {
        if (!isset($_REQUEST['offset'])) {
            ?>
            <script>
                var d = new Date()
                var offset = -d.getTimezoneOffset() / 60;
                location.href = "<?php echo $_SERVER['PHP_SELF']; ?>?offset=" + offset;
            </script>
            <?php
        } else {
            $zonelist = array('Kwajalein' => -12.00, 'Pacific/Midway' => -11.00, 'Pacific/Honolulu' => -10.00, 'America/Anchorage' => -9.00, 'America/Los_Angeles' => -8.00, 'America/Denver' => -7.00, 'America/Tegucigalpa' => -6.00, 'America/New_York' => -5.00, 'America/Caracas' => -4.5, 'America/Halifax' => -4.00, 'America/St_Johns' => -3.5, 'America/Argentina/Buenos_Aires' => -3.00, 'America/Sao_Paulo' => -3.00, 'Atlantic/South_Georgia' => -2.00, 'Atlantic/Azores' => -1.00, 'Europe/Dublin' => 0, 'Europe/Belgrade' => 1.00, 'Europe/Minsk' => 2.00, 'Asia/Kuwait' => 3.00, 'Asia/Tehran' => 3.5, 'Asia/Muscat' => 4.00, 'Asia/Yekaterinburg' => 5.00, 'Asia/Kolkata' => 5.5, 'Asia/Katmandu' => 5.45, 'Asia/Dhaka' => 6.00, 'Asia/Rangoon' => 6.5, 'Asia/Krasnoyarsk' => 7.00, 'Asia/Brunei' => 8.00, 'Asia/Seoul' => 9.00, 'Australia/Darwin' => 9.5, 'Australia/Canberra' => 10.00, 'Asia/Magadan' => 11.00, 'Pacific/Fiji' => 12.00, 'Pacific/Tongatapu' => 13.00);
            @$timezones = $obj->SelectAllByVal($table, "store_id", $input_by, "time_zone");
            if ($timezones == "") {
                $index = array_keys($zonelist, $_REQUEST['offset']);
                $_SESSION['timezone'] = $index[0];
            } else {
                $_SESSION['timezone'] = $timezones;
            }
        }
    }
} else {
    $_SESSION['timezone'] = $timezones;
}
date_default_timezone_set($_SESSION['timezone']);*/
date_default_timezone_set('America/Los_Angeles');

$def_cus = $obj->SelectAllByVal("setting_customer", "store_id", $input_by, "cutomer_default");
//set session with currency
$def_currency = $obj->FlyQuery("SELECT c.sign FROM store_currency AS sc LEFT JOIN currency AS c ON c.id=sc.currency_id WHERE sc.store_id='$input_by' AND sc.status='1'");
if (!empty($def_currency)) {
    $_SESSION["currency"] = $def_currency[0]->sign;
} else {
    $_SESSION["currency"] = "^";
}

$currencyicon=$_SESSION["currency"];
?>