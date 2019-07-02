<?php

include '../class/auth.php';
header("Content-type: application/json");
$verb = $_SERVER["REQUEST_METHOD"];
$table = "store";
if ($verb == "GET") {

    if ($input_status == 1) {
            $migratecond ="";
        } elseif ($input_status == 5) {

            $sqlchain_store_ids = $obj->SelectAllByID("store_chain_admin", array("sid" => $input_by));
            if (!empty($sqlchain_store_ids)) {

                    $inner_cond = ' AND (';
                    $i = 1;
                    foreach ($sqlchain_store_ids as $ch):
                        if ($i == 1) {
                            $inner_cond .= "`c`.`store_id`='" . $ch->store_id . "'";
                        } else {
                            $inner_cond .= " OR `c`.`store_id`='" . $ch->store_id . "'";
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
            
            $newcond = " AND `c`.`store_id`='" . $input_by . "'";
            $migratecond =$newcond;
            
        }


    $sql_coustomer = $obj->FlyQuery("SELECT
                                        c.id,
                                        c.store_id,
                                        c.name,
                                        c.email,
                                        c.phone,
                                        c.username,
                                        c.date
                                        FROM store AS c
                                        WHERE c.status='3' 
                                        " . $migratecond . " 
                                        ORDER BY c.id DESC");



    $sqlCity = $sql_coustomer;
    //$totalrows = $obj->totalrows($table);
    echo "{\"data\":" . json_encode($sqlCity) . "}";
}


if ($verb == "POST") {
    $id = $_POST['id'];
    if ($obj->delete($table, array("id" => $id)) == 1) {
        echo true;
    } else {
        echo 0;
    }
}
?>
