<?php

include '../class/auth.php';
header("Content-type: application/json");
$verb = $_SERVER["REQUEST_METHOD"];
$table = "buyback_estimate";
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
        $cond = $plugin->BackEndDateSearch('from', 'to', 'date', 'be.', ' AND ');

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
                        $inner_cond = "`be`.`store_id`='" . $ch->store_id . "'";
                    } else {
                        $inner_cond = " OR `be`.`store_id`='" . $ch->store_id . "'";
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
        

        $sqlpar = "SELECT 
                    be.id,
                    CONCAT(c.firstname,' ',c.lastname) AS customer_name,
                    bn.name AS carrier,
                    bdt.name AS device,
                    bdc.name AS d_condition,
                    bdto.name AS device_turn_on,
                    bwd.name AS water_damage,
                    bms.name AS memory_size,
                    be.amount

                    FROM buyback_estimate AS be
                    LEFT JOIN coustomer AS c ON c.id=be.customer_id
                    LEFT JOIN buyback_network AS bn ON bn.id=be.nid
                    LEFT JOIN buyback_device_type AS bdt ON bdt.id=be.dtid
                    LEFT JOIN buyback_device_condition AS bdc ON bdc.id=be.cid
                    LEFT JOIN buyback_device_turn_on AS bdto ON bdto.id=be.dtoid
                    LEFT JOIN buyback_water_damage AS bwd ON bwd.id=be.wdid
                    LEFT JOIN buyback_memory_size AS bms ON bms.id=be.msid
                    ORDER BY be.id DESC LIMIT $start,$pagesize";


        /*
         * 
         * Introduce New Table 
         * CREATE TABLE IF NOT EXISTS `sold_salvage` (
          `id` int(20) AUTO_INCREMENT PRIMARY KEY,
          `sales_id` int(20)
          )

         * Introducce new field in            */

        $sqlpars = "SELECT 
                    be.id,
                    CONCAT(c.firstname,' ',c.lastname) AS customer_name,
                    bn.name AS carrier,
                    bdt.name AS device,
                    bdc.name AS d_condition,
                    bdto.name AS device_turn_on,
                    bwd.name AS water_damage,
                    bms.name AS memory_size,
                    be.amount

                    FROM buyback_estimate AS be
                    LEFT JOIN coustomer AS c ON c.id=be.customer_id
                    LEFT JOIN buyback_network AS bn ON bn.id=be.nid
                    LEFT JOIN buyback_device_type AS bdt ON bdt.id=be.dtid
                    LEFT JOIN buyback_device_condition AS bdc ON bdc.id=be.cid
                    LEFT JOIN buyback_device_turn_on AS bdto ON bdto.id=be.dtoid
                    LEFT JOIN buyback_water_damage AS bwd ON bwd.id=be.wdid
                    LEFT JOIN buyback_memory_size AS bms ON bms.id=be.msid
                    ORDER BY be.id DESC";

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
        $cond = $plugin->BackEndDateSearch('from', 'to', 'date', 'be.', ' AND ');

        if (empty($cond)) {
            $cond = " WHERE ";
        }

        if ($input_status == 1) {
            $migratecond = $cond;
        } elseif ($input_status == 5) {

            $sqlchain_store_ids = $obj->SelectAllByID("store_chain_admin", array("sid" => $input_by));
            if (!empty($sqlchain_store_ids)) {

                $inner_cond = ' AND (';
                $i = 1;
                foreach ($sqlchain_store_ids as $ch):
                    if ($i == 1) {
                        $inner_cond .= "`be`.`store_id`='" . $ch->store_id . "'";
                    } else {
                        $inner_cond .= " OR `be`.`store_id`='" . $ch->store_id . "'";
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

            $newcond = " `be`.`store_id`='" . $input_by . "'";
            $migratecond = $cond . $newcond;
        }

        $sql_coustomer = $obj->FlyQuery("SELECT 
                                        be.id,
                                        CONCAT(c.firstname,' ',c.lastname) AS customer_name,
                                        bn.name AS carrier,
                                        bdt.name AS device,
                                        bdc.name AS d_condition,
                                        bdto.name AS device_turn_on,
                                        bwd.name AS water_damage,
                                        bms.name AS memory_size,
                                        be.amount

                                        FROM buyback_estimate AS be
                                        LEFT JOIN coustomer AS c ON c.id=be.customer_id
                                        LEFT JOIN buyback_network AS bn ON bn.id=be.nid
                                        LEFT JOIN buyback_device_type AS bdt ON bdt.id=be.dtid
                                        LEFT JOIN buyback_device_condition AS bdc ON bdc.id=be.cid
                                        LEFT JOIN buyback_device_turn_on AS bdto ON bdto.id=be.dtoid
                                        LEFT JOIN buyback_water_damage AS bwd ON bwd.id=be.wdid
                                        LEFT JOIN buyback_memory_size AS bms ON bms.id=be.msid
                                        ORDER BY be.id DESC LIMIT $start,$pagesize");



        $totalrows = $obj->FlyQuery("SELECT 
                                    be.id,
                                    CONCAT(c.firstname,' ',c.lastname) AS customer_name,
                                    bn.name AS carrier,
                                    bdt.name AS device,
                                    bdc.name AS d_condition,
                                    bdto.name AS device_turn_on,
                                    bwd.name AS water_damage,
                                    bms.name AS memory_size,
                                    be.amount

                                    FROM buyback_estimate AS be
                                    LEFT JOIN coustomer AS c ON c.id=be.customer_id
                                    LEFT JOIN buyback_network AS bn ON bn.id=be.nid
                                    LEFT JOIN buyback_device_type AS bdt ON bdt.id=be.dtid
                                    LEFT JOIN buyback_device_condition AS bdc ON bdc.id=be.cid
                                    LEFT JOIN buyback_device_turn_on AS bdto ON bdto.id=be.dtoid
                                    LEFT JOIN buyback_water_damage AS bwd ON bwd.id=be.wdid
                                    LEFT JOIN buyback_memory_size AS bms ON bms.id=be.msid
                                    ORDER BY be.id DESC", 1);

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
