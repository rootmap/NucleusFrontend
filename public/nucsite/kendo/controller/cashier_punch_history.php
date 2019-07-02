<?php

include '../class/auth.php';
header("Content-type: application/json");
$verb = $_SERVER["REQUEST_METHOD"];
$table = "store_punch_time";
if ($verb == "GET") {
    if (isset($_GET['filter'])) {
        $filter_result = array();
        $filter_data = $_GET["filter"];
        $pagesize = $_GET['pageSize'];
        $start = $_GET['skip'];
        $filtercount = count($_GET["filter"]['filters']);
        $confilter = '';
        include '../plugin/plugin.php';
        $plugin = new CmsRootPlugin();
        $cond = $plugin->BackEndDateSearch('from', 'to', 'date', 'spt.', ' AND ');

        if (empty($cond)) {
            $cond = " WHERE ";
        }

        if ($input_status == 1) {
            for ($i = 0; $i <= $filtercount - 1; $i++):
                if ($i == 0) {
                    $confilter = $plugin->KendoFilter($filter_data, "AllKenduData.", $i);
                } else {
                    $confilter .=" AND " . $plugin->KendoFilter($filter_data, "AllKenduData.", $i);
                }
            endfor;

            $migratecond = $cond;
        } elseif ($input_status == 5) {
            $sqlchain_store_ids = $obj->FlyQuery("SELECT sid,store_id FROM store_chain_admin WHERE sid='" . $input_by . "'");
            if (!empty($sqlchain_store_ids)) {

                $inner_cond = ' AND (';
                $i = 1;
                foreach ($sqlchain_store_ids as $ch):
                    if ($i == 1) {
                        $inner_cond = "`spt`.`store_id`='" . $ch->store_id . "'";
                    } else {
                        $inner_cond = " OR `spt`.`store_id`='" . $ch->store_id . "'";
                    }
                    $i++;
                endforeach;
                $inner_cond .=')';



                for ($i = 0; $i <= $filtercount - 1; $i++):
                    if ($i == 0) {
                        $confilter = $plugin->KendoFilter($filter_data, "AllKenduData.", $i);
                    } else {
                        $confilter .=" AND " . $plugin->KendoFilter($filter_data, "AllKenduData.", $i);
                    }
                endfor;

                $migratecond = $cond . $inner_cond;
            } else {
                $confilter = '';
                $migratecond = " WHERE ur.id='0' ";
            }
        } else {

            $confilter = '';
            for ($i = 0; $i <= $filtercount - 1; $i++):
                if ($i == 0) {
                    $confilter = $plugin->KendoFilter($filter_data, "AllKenduData.", $i);
                } else {
                    $confilter .=" AND " . $plugin->KendoFilter($filter_data, "AllKenduData.", $i);
                }
            endfor;

            $migratecond = $cond;
        }

        if (isset($_GET['today'])) {
            if (!empty($migratecond)) {
                $migratecond .=" AND (spt.indate='" . date('Y-m-d') . "' OR spt.outdate='" . date('Y-m-d') . "')";
            } else {
                $migratecond .=" WHERE (spt.indate='" . date('Y-m-d') . "' OR spt.outdate='" . date('Y-m-d') . "')";
            }
        }


        $sqlpar = "SELECT
                    spt.id,
                    spt.cashier_id,
                    s.name AS cashier,
                    spt.indate,
                    spt.intime,
                    spt.outdate,
                    spt.outtime,
                    CONCAT(spt.indate, ' ', IF(LOCATE('PM',spt.intime) > 0, ADDTIME(TIME(REPLACE(spt.intime, ' PM','')), '12:00:00'),  TIME(REPLACE(spt.intime, ' AM','')))) as new_indatetime,
                    CONCAT(spt.outdate, ' ', IF(LOCATE('PM',spt.outtime) > 0, ADDTIME(TIME(REPLACE(spt.outtime, ' PM','')), '12:00:00'),  TIME(REPLACE(spt.outtime, ' AM','')))) as new_outdatetime,
                    IFNULL(TIME_FORMAT(TIMEDIFF(CONCAT(spt.outdate, ' ', IF(LOCATE('PM',spt.outtime) > 0, ADDTIME(TIME(REPLACE(spt.outtime, ' PM','')), '12:00:00'),  TIME(REPLACE(spt.outtime, ' AM','')))),CONCAT(spt.indate, ' ', IF(LOCATE('PM',spt.intime) > 0, ADDTIME(TIME(REPLACE(spt.intime, ' PM','')), '12:00:00'),  TIME(REPLACE(spt.intime, ' AM',''))))),'%H:%i:%s'),'00:00:00') AS elapsed_time
                    FROM store_punch_time AS spt
                    LEFT JOIN store AS s ON spt.cashier_id=s.id
                    " . $migratecond . " 
                    ORDER BY spt.id DESC LIMIT $start,$pagesize";


        /*
         * 
         * Introduce New Table 
         * CREATE TABLE IF NOT EXISTS `sold_salvage` (
          `id` int(20) AUTO_INCREMENT PRIMARY KEY,
          `sales_id` int(20)
          )

         * Introducce new field in            */

        $sqlpars = "SELECT
                    spt.id,
                    spt.cashier_id,
                    s.name AS cashier,
                    spt.indate,
                    spt.intime,
                    spt.outdate,
                    spt.outtime,
                    CONCAT(spt.indate, ' ', IF(LOCATE('PM',spt.intime) > 0, ADDTIME(TIME(REPLACE(spt.intime, ' PM','')), '12:00:00'),  TIME(REPLACE(spt.intime, ' AM','')))) as new_indatetime,
                    CONCAT(spt.outdate, ' ', IF(LOCATE('PM',spt.outtime) > 0, ADDTIME(TIME(REPLACE(spt.outtime, ' PM','')), '12:00:00'),  TIME(REPLACE(spt.outtime, ' AM','')))) as new_outdatetime,
                    IFNULL(TIME_FORMAT(TIMEDIFF(CONCAT(spt.outdate, ' ', IF(LOCATE('PM',spt.outtime) > 0, ADDTIME(TIME(REPLACE(spt.outtime, ' PM','')), '12:00:00'),  TIME(REPLACE(spt.outtime, ' AM','')))),CONCAT(spt.indate, ' ', IF(LOCATE('PM',spt.intime) > 0, ADDTIME(TIME(REPLACE(spt.intime, ' PM','')), '12:00:00'),  TIME(REPLACE(spt.intime, ' AM',''))))),'%H:%i:%s'),'00:00:00') AS elapsed_time
                    FROM store_punch_time AS spt
                    LEFT JOIN store AS s ON spt.cashier_id=s.id
                    " . $migratecond . " 
                    ORDER BY spt.id DESC";

        $sqlparamgen = $plugin->KenduFilterParam($sqlpar, $confilter);
        $filter_result = $obj->FlyQuery($sqlparamgen);
        $total_in_filter = $obj->FlyQuery($plugin->KenduFilterParam($sqlpars, $confilter), "1");


        if ($total_in_filter >= 1) {
            echo "{\"data\":" . json_encode($filter_result) . ",\"total\":" . $total_in_filter . "}";
        } else {
            echo "{\"data\":" . "[]" . ",\"total\":" . $total_in_filter . "}";
        }
        //print_r($_GET);
        exit();
    } else {
        $pagesize = $_GET['pageSize'];
        $start = $_GET['skip'];
        include '../plugin/plugin.php';
        $plugin = new CmsRootPlugin();
        $cond = $plugin->BackEndDateSearch('from', 'to', 'date', 'spt.', ' AND ');

        if (empty($cond)) {
            $cond = " WHERE ";
        }

        if ($input_status == 1) {
            $migratecond = "";
        } elseif ($input_status == 5) {

            $sqlchain_store_ids = $obj->SelectAllByID("store_chain_admin", array("sid" => $input_by));
            if (!empty($sqlchain_store_ids)) {

                $inner_cond = ' AND (';
                $i = 1;
                foreach ($sqlchain_store_ids as $ch):
                    if ($i == 1) {
                        $inner_cond .= "`spt`.`store_id`='" . $ch->store_id . "'";
                    } else {
                        $inner_cond .= " OR `spt`.`store_id`='" . $ch->store_id . "'";
                    }
                    $i++;
                endforeach;
                $inner_cond .=')';

                $migratecond = $cond . $inner_cond;


                //echo "Work";
            } else {
                //echo "Not Work";
                $migratecond = " WHERE a.id='0'";
            }
        } else {

            $newcond = " `spt`.`store_id`='" . $input_by . "'";
            $migratecond = $cond . $newcond;
        }

        if (isset($_GET['today'])) {
            if (!empty($migratecond)) {
                $migratecond .=" AND (spt.indate='" . date('Y-m-d') . "' OR spt.outdate='" . date('Y-m-d') . "')";
            } else {
                $migratecond .=" WHERE (spt.indate='" . date('Y-m-d') . "' OR spt.outdate='" . date('Y-m-d') . "')";
            }
        }

        $sql_coustomer = $obj->FlyQuery("SELECT
                                        spt.id,
                                        spt.cashier_id,
                                        s.name AS cashier,
                                        spt.indate,
                                        spt.intime,
                                        spt.outdate,
                                        spt.outtime,
                                        CONCAT(spt.indate, ' ', IF(LOCATE('PM',spt.intime) > 0, ADDTIME(TIME(REPLACE(spt.intime, ' PM','')), '12:00:00'),  TIME(REPLACE(spt.intime, ' AM','')))) as new_indatetime,
                                        CONCAT(spt.outdate, ' ', IF(LOCATE('PM',spt.outtime) > 0, ADDTIME(TIME(REPLACE(spt.outtime, ' PM','')), '12:00:00'),  TIME(REPLACE(spt.outtime, ' AM','')))) as new_outdatetime,
                                        IFNULL(TIME_FORMAT(TIMEDIFF(CONCAT(spt.outdate, ' ', IF(LOCATE('PM',spt.outtime) > 0, ADDTIME(TIME(REPLACE(spt.outtime, ' PM','')), '12:00:00'),  TIME(REPLACE(spt.outtime, ' AM','')))),CONCAT(spt.indate, ' ', IF(LOCATE('PM',spt.intime) > 0, ADDTIME(TIME(REPLACE(spt.intime, ' PM','')), '12:00:00'),  TIME(REPLACE(spt.intime, ' AM',''))))),'%H:%i:%s'),'00:00:00') AS elapsed_time
                                        FROM store_punch_time AS spt
                                        LEFT JOIN store AS s ON spt.cashier_id=s.id 
                                        " . $migratecond . " 
                                        ORDER BY spt.id DESC LIMIT $start,$pagesize");



        $totalrows = $obj->FlyQuery("SELECT
                                    spt.id,
                                    spt.cashier_id,
                                    s.name AS cashier,
                                    spt.indate,
                                    spt.intime,
                                    spt.outdate,
                                    spt.outtime,
                                    CONCAT(spt.indate, ' ', IF(LOCATE('PM',spt.intime) > 0, ADDTIME(TIME(REPLACE(spt.intime, ' PM','')), '12:00:00'),  TIME(REPLACE(spt.intime, ' AM','')))) as new_indatetime,
                                    CONCAT(spt.outdate, ' ', IF(LOCATE('PM',spt.outtime) > 0, ADDTIME(TIME(REPLACE(spt.outtime, ' PM','')), '12:00:00'),  TIME(REPLACE(spt.outtime, ' AM','')))) as new_outdatetime,
                                    IFNULL(TIME_FORMAT(TIMEDIFF(CONCAT(spt.outdate, ' ', IF(LOCATE('PM',spt.outtime) > 0, ADDTIME(TIME(REPLACE(spt.outtime, ' PM','')), '12:00:00'),  TIME(REPLACE(spt.outtime, ' AM','')))),CONCAT(spt.indate, ' ', IF(LOCATE('PM',spt.intime) > 0, ADDTIME(TIME(REPLACE(spt.intime, ' PM','')), '12:00:00'),  TIME(REPLACE(spt.intime, ' AM',''))))),'%H:%i:%s'),'00:00:00') AS elapsed_time
                                    FROM store_punch_time AS spt
                                    LEFT JOIN store AS s ON spt.cashier_id=s.id 
                                    " . $migratecond . " 
                                    ORDER BY spt.id DESC", 1);

        $sqlCity = $sql_coustomer;
        //$totalrows = $obj->totalrows($table);
        echo "{\"data\":" . json_encode($sqlCity) . ",\"total\":" . $totalrows . "}";
    }
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
