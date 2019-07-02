<?php

include '../class/auth.php';
header("Content-type: application/json");
$verb = $_SERVER["REQUEST_METHOD"];
$table = "transaction_log";
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
        $cond = $plugin->BackEndDateSearch('from', 'to', 'date', 't.', ' AND ');

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
                        $inner_cond = "`ss`.`store_id`='" . $ch->store_id . "'";
                    } else {
                        $inner_cond = " OR `ss`.`store_id`='" . $ch->store_id . "'";
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
                    t.id,
                    t.transaction,
                    s.name AS shop,
                    t.date,
                    t.time,
                    ss.name AS cashier,
                    CONCAT(c.firstname,'',c.lastname) AS customer,
                    t.amount AS amount,

                    CASE t.type WHEN 1 THEN 'Store Opening Cash'
                    ELSE CASE t.type WHEN 2 THEN 'Payout/Drop/Sales' 
                    ELSE CASE t.type WHEN 3 THEN 'Ticket/Checkin/Parts Order' 
                    ELSE CASE t.type WHEN 4 THEN 'Sales' 
                    ELSE CASE t.type WHEN 5 THEN 'Payout/Drop'
                    ELSE CASE t.type WHEN 6 THEN 'BuyBack'
                    ELSE CASE t.type WHEN 7 THEN 'Store Closing'
                    ELSE 'Undefined'
                    END END END END END END END AS type,

                    CASE t.tender WHEN 1 THEN 'Cash'
                    ELSE CASE t.tender WHEN 2 THEN 'Square'
                    ELSE CASE t.tender WHEN 3 THEN 'Cash'
                    ELSE CASE t.tender WHEN 4 THEN 'Credit Card'
                    ELSE CASE t.tender WHEN 5 THEN 'Cash'
                    ELSE CASE t.tender WHEN 6 THEN 'Cash & Credit Card'
                    ELSE t.tender
                    END END END END END END AS tender,
                    ss.store_id
                    FROM transaction_log AS t
                    LEFT JOIN store AS ss ON ss.id=t.cashier_id
                    LEFT JOIN store AS s ON s.store_id=ss.store_id AND s.status='2'
                    LEFT JOIN coustomer AS c ON c.id=t.customer_id
                    " . $migratecond . " 
                    ORDER BY t.id DESC LIMIT $start,$pagesize";


        /*
         * 
         * Introduce New Table 
         * CREATE TABLE IF NOT EXISTS `sold_salvage` (
          `id` int(20) AUTO_INCREMENT PRIMARY KEY,
          `sales_id` int(20)
          )

         * Introducce new field in            */

        $sqlpars = "SELECT
                    t.id,
                    t.transaction,
                    s.name AS shop,
                    t.date,
                    t.time,
                    ss.name AS cashier,
                    CONCAT(c.firstname,'',c.lastname) AS customer,
                    t.amount AS amount,

                    CASE t.type WHEN 1 THEN 'Store Opening Cash'
                    ELSE CASE t.type WHEN 2 THEN 'Payout/Drop/Sales' 
                    ELSE CASE t.type WHEN 3 THEN 'Ticket/Checkin/Parts Order' 
                    ELSE CASE t.type WHEN 4 THEN 'Sales' 
                    ELSE CASE t.type WHEN 5 THEN 'Payout/Drop'
                    ELSE CASE t.type WHEN 6 THEN 'BuyBack'
                    ELSE CASE t.type WHEN 7 THEN 'Store Closing'
                    ELSE 'Undefined'
                    END END END END END END END AS type,

                    CASE t.tender WHEN 1 THEN 'Cash'
                    ELSE CASE t.tender WHEN 2 THEN 'Square'
                    ELSE CASE t.tender WHEN 3 THEN 'Cash'
                    ELSE CASE t.tender WHEN 4 THEN 'Credit Card'
                    ELSE CASE t.tender WHEN 5 THEN 'Cash'
                    ELSE CASE t.tender WHEN 6 THEN 'Cash & Credit Card'
                    ELSE t.tender
                    END END END END END END AS tender,
                    ss.store_id
                    FROM transaction_log AS t
                    LEFT JOIN store AS ss ON ss.id=t.cashier_id
                    LEFT JOIN store AS s ON s.store_id=ss.store_id AND s.status='2'
                    LEFT JOIN coustomer AS c ON c.id=t.customer_id

                    " . $migratecond . " 
                    ORDER BY t.id DESC";

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
        $cond = $plugin->BackEndDateSearch('from', 'to', 'date', 't.', ' AND ');

        if (empty($cond)) {
            $cond = " WHERE ";
        }

        if ($input_status == 1) {
            $migratecond ="";
        } elseif ($input_status == 5) {

            $sqlchain_store_ids = $obj->SelectAllByID("store_chain_admin", array("sid" => $input_by));
            if (!empty($sqlchain_store_ids)) {

                $inner_cond = ' AND (';
                $i = 1;
                foreach ($sqlchain_store_ids as $ch):
                    if ($i == 1) {
                        $inner_cond .= "`ss`.`store_id`='" . $ch->store_id . "'";
                    } else {
                        $inner_cond .= " OR `ss`.`store_id`='" . $ch->store_id . "'";
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

            $newcond = " `ss`.`store_id`='" . $input_by . "'";
            $migratecond = $cond . $newcond;
        }
        
        $sql_coustomer = $obj->FlyQuery("SELECT
                                        t.id,
                                        t.transaction,
                                        s.name AS shop,
                                        t.date,
                                        t.time,
                                        ss.name AS cashier,
                                        CONCAT(c.firstname,'',c.lastname) AS customer,
                                        t.amount AS amount,

                                        CASE t.type WHEN 1 THEN 'Store Opening Cash'
                                        ELSE CASE t.type WHEN 2 THEN 'Payout/Drop/Sales' 
                                        ELSE CASE t.type WHEN 3 THEN 'Ticket/Checkin/Parts Order' 
                                        ELSE CASE t.type WHEN 4 THEN 'Sales' 
                                        ELSE CASE t.type WHEN 5 THEN 'Payout/Drop'
                                        ELSE CASE t.type WHEN 6 THEN 'BuyBack'
                                        ELSE CASE t.type WHEN 7 THEN 'Store Closing'
                                        ELSE 'Undefined'
                                        END END END END END END END AS type,

                                        CASE t.tender WHEN 1 THEN 'Cash'
                                        ELSE CASE t.tender WHEN 2 THEN 'Square'
                                        ELSE CASE t.tender WHEN 3 THEN 'Cash'
                                        ELSE CASE t.tender WHEN 4 THEN 'Credit Card'
                                        ELSE CASE t.tender WHEN 5 THEN 'Cash'
                                        ELSE CASE t.tender WHEN 6 THEN 'Cash & Credit Card'
                                        ELSE t.tender
                                        END END END END END END AS tender,
                                        ss.store_id
                                        FROM transaction_log AS t
                                        LEFT JOIN store AS ss ON ss.id=t.cashier_id
                                        LEFT JOIN store AS s ON s.store_id=ss.store_id AND s.status='2'
                                        LEFT JOIN coustomer AS c ON c.id=t.customer_id

                                        " . $migratecond . " 
                                        ORDER BY t.id DESC LIMIT $start,$pagesize");



        $totalrows = $obj->FlyQuery("SELECT
                                    t.id,
                                    t.transaction,
                                    s.name AS shop,
                                    t.date,
                                    t.time,
                                    ss.name AS cashier,
                                    CONCAT(c.firstname,'',c.lastname) AS customer,
                                    t.amount AS amount,

                                    CASE t.type WHEN 1 THEN 'Store Opening Cash'
                                    ELSE CASE t.type WHEN 2 THEN 'Payout/Drop/Sales' 
                                    ELSE CASE t.type WHEN 3 THEN 'Ticket/Checkin/Parts Order' 
                                    ELSE CASE t.type WHEN 4 THEN 'Sales' 
                                    ELSE CASE t.type WHEN 5 THEN 'Payout/Drop'
                                    ELSE CASE t.type WHEN 6 THEN 'BuyBack'
                                    ELSE CASE t.type WHEN 7 THEN 'Store Closing'
                                    ELSE 'Undefined'
                                    END END END END END END END AS type,

                                    CASE t.tender WHEN 1 THEN 'Cash'
                                    ELSE CASE t.tender WHEN 2 THEN 'Square'
                                    ELSE CASE t.tender WHEN 3 THEN 'Cash'
                                    ELSE CASE t.tender WHEN 4 THEN 'Credit Card'
                                    ELSE CASE t.tender WHEN 5 THEN 'Cash'
                                    ELSE CASE t.tender WHEN 6 THEN 'Cash & Credit Card'
                                    ELSE t.tender
                                    END END END END END END AS tender,
                                    ss.store_id
                                    FROM transaction_log AS t
                                    LEFT JOIN store AS ss ON ss.id=t.cashier_id
                                    LEFT JOIN store AS s ON s.store_id=ss.store_id AND s.status='2'
                                    LEFT JOIN coustomer AS c ON c.id=t.customer_id

                                    " . $migratecond . " 
                                    ORDER BY t.id DESC", 1);

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
