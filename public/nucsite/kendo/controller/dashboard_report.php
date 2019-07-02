<?php

include '../class/auth.php';

if ($input_status == 1) {
    $migratecond = "";
} elseif ($input_status == 5) {

    $sqlchain_store_ids = $obj->SelectAllByID("store_chain_admin", array("sid" => $input_by));
    if (!empty($sqlchain_store_ids)) {

        $inner_cond = ' WHERE (';
        $i = 1;
        foreach ($sqlchain_store_ids as $ch):
            if ($i == 1) {
                $inner_cond .= "`dr`.`store_id`='" . $ch->store_id . "'";
            } else {
                $inner_cond .= " OR `dr`.`store_id`='" . $ch->store_id . "'";
            }
            $i++;
        endforeach;
        $inner_cond .=')';

        $migratecond =$inner_cond;


        //echo "Work";
    } else {
        //echo "Not Work";
        $migratecond = " WHERE a.id='0'";
    }
} else {

    $newcond = " WHERE `dr`.`store_id`='" . $input_by . "'";
    $migratecond =$newcond;
}


$chkstore = $obj->FlyQuery("SELECT 
                            SUM(dr.`total_sales`) AS total_sales,
                            SUM(dr.`total_ticket`) AS total_ticket,
                            SUM(dr.`total_repair`) AS total_repair,
                            SUM(dr.`total_buyback`) AS total_buyback,
                            SUM(dr.`total_estimate`) AS total_estimate,
                            SUM(dr.`total_unlock`) AS total_unlock
                            FROM `dashboard_report` as dr 
                            " . $migratecond . "
                            GROUP BY dr.`store_id`", "0");





$sqlCity = $chkstore;
//$totalrows = $obj->totalrows($table);
//echo "<pre>";
//print_r($sqlCity);

echo json_encode($sqlCity);
?>
