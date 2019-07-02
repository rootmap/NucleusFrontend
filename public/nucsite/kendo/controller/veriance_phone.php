<?php
include '../class/auth.php';
header("Content-type: application/json");
$verb = $_SERVER["REQUEST_METHOD"];
$table = "varience";
$table1 = "product_verience";
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
        if (isset($_GET['lotno'])) {
            $conds = $plugin->BackEndDateSearch('from', 'to', 'date', 'p.', ' WHERE ');
            if (!empty($conds)) {
                $cond = $conds . " AND lotno='" . $_GET['lotno'] . "'";
            } else {
                $cond = " WHERE lotno='" . $_GET['lotno'] . "'";
            }
        } else {
            $cond = $plugin->BackEndDateSearch('from', 'to', 'date', 'p.', ' AND ');
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
                        $inner_cond = "`p`.`store_id`='" . $ch->store_id . "'";
                    } else {
                        $inner_cond = " OR `p`.`store_id`='" . $ch->store_id . "'";
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


        if (isset($_GET['lotno'])) {
            $sqlpar = "SELECT 
                    p.*,
                    s.name as input_bys 
                    FROM varience as p 
                    LEFT JOIN store as s on s.id=p.input_by 
                    WHERE p.status='2' 
                    " . $migratecond . " 
                    order by `p`.`id` DESC LIMIT $start,$pagesize";


            /*
             * 
             * Introduce New Table 
             * CREATE TABLE IF NOT EXISTS `sold_salvage` (
              `id` int(20) AUTO_INCREMENT PRIMARY KEY,
              `sales_id` int(20)
              )

             * Introducce new field in            */

            $sqlpars = "SELECT p.*,
                     s.name as input_bys 
                     FROM varience as p 
                     LEFT JOIN store as s on s.id=p.input_by 
                     WHERE p.status='2'  
                     " . $migratecond;
        } else {
            $sqlpar = "SELECT 
                        p.id,
                        p.store_id,
                        p.pid,
                        pro.name as pname,
                        IFNULL(pro.price_cost,0) AS price_cost,
                        p.white,
                        p.black,
                        p.warranty,
                        IFNULL(p.system_quantity,0) AS system_quantity,
                        p.quantity,
                        (IFNULL(p.quantity,0)-IFNULL(p.system_quantity,0)) AS varience,
                        ((IFNULL(p.quantity,0)-IFNULL(p.system_quantity,0))*IFNULL(pro.price_cost,0)) AS varianceprice,
                        p.lotno,
                        p.date,
                        p.status
                        FROM `product_verience` as p 
                        LEFT JOIN product as pro ON pro.id=p.pid 
                    " . $migratecond . " 
                    order by `p`.`id` DESC LIMIT $start,$pagesize";


            /*
             * 
             * Introduce New Table 
             * CREATE TABLE IF NOT EXISTS `sold_salvage` (
              `id` int(20) AUTO_INCREMENT PRIMARY KEY,
              `sales_id` int(20)
              )

             * Introducce new field in            */

            $sqlpars = "SELECT 
                        p.id,
                        p.store_id,
                        p.pid,
                        pro.name as pname,
                        IFNULL(pro.price_cost,0) AS price_cost,
                        p.white,
                        p.black,
                        p.warranty,
                        IFNULL(p.system_quantity,0) AS system_quantity,
                        p.quantity,
                        (IFNULL(p.quantity,0)-IFNULL(p.system_quantity,0)) AS varience,
                        ((IFNULL(p.quantity,0)-IFNULL(p.system_quantity,0))*IFNULL(pro.price_cost,0)) AS varianceprice,
                        p.lotno,
                        p.date,
                        p.status
                        FROM `product_verience` as p 
                        LEFT JOIN product as pro ON pro.id=p.pid  
                     " . $migratecond;
        }
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
        if (isset($_GET['lotno'])) {
            $conds = $plugin->BackEndDateSearch('from', 'to', 'date', 'p.', ' WHERE ');
            if (!empty($conds)) {
                $cond = $conds . " AND lotno='" . $_GET['lotno'] . "'";
            } else {
                $cond = " WHERE lotno='" . $_GET['lotno'] . "'";
            }
        } else {
            $cond = $plugin->BackEndDateSearch('from', 'to', 'date', 'p.', ' AND ');
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
                        $inner_cond .= "`p`.`store_id`='" . $ch->store_id . "'";
                    } else {
                        $inner_cond .= " OR `p`.`store_id`='" . $ch->store_id . "'";
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

            $newcond = " AND `p`.`store_id`='" . $input_by . "'";
            $migratecond = $cond . $newcond;
        }


        if (isset($_GET['lotno'])) {
            $sql_coustomer = $obj->FlyQuery("SELECT 
                                            p.id,
                                            p.store_id,
                                            p.pid,
                                            pro.name as pname,
                                            IFNULL(pro.price_cost,0) AS price_cost,
                                            p.white,
                                            p.black,
                                            p.warranty,
                                            IFNULL(p.system_quantity,0) AS system_quantity,
                                            p.quantity,
                                            (IFNULL(p.quantity,0)-IFNULL(p.system_quantity,0)) AS varience,
                                            ((IFNULL(p.quantity,0)-IFNULL(p.system_quantity,0))*IFNULL(pro.price_cost,0)) AS varianceprice,
                                            p.lotno,
                                            p.date,
                                            p.status
                                            FROM `product_verience` as p 
                                            LEFT JOIN product as pro ON pro.id=p.pid 
                                            " . $migratecond . " 
                                            order by `p`.`id` DESC LIMIT $start,$pagesize");



            $totalrows = $obj->FlyQuery("SELECT 
                                        p.id,
                                        p.store_id,
                                        p.pid,
                                        pro.name as pname,
                                        IFNULL(pro.price_cost,0) AS price_cost,
                                        p.white,
                                        p.black,
                                        p.warranty,
                                        IFNULL(p.system_quantity,0) AS system_quantity,
                                        p.quantity,
                                        (IFNULL(p.quantity,0)-IFNULL(p.system_quantity,0)) AS varience,
                                        ((IFNULL(p.quantity,0)-IFNULL(p.system_quantity,0))*IFNULL(pro.price_cost,0)) AS varianceprice,
                                        p.lotno,
                                        p.date,
                                        p.status
                                        FROM `product_verience` as p 
                                        LEFT JOIN product as pro ON pro.id=p.pid
                                        " . $migratecond, 1);
        } else {
            $sql_coustomer = $obj->FlyQuery("select 
                                        p.*,
                                        s.name as input_bys 
                                        FROM varience as p 
                                        LEFT JOIN store as s on s.id=p.input_by 
                                        WHERE p.status='2' 
                                        " . $migratecond . " 
                                        order by `p`.`id` DESC LIMIT $start,$pagesize");



            $totalrows = $obj->FlyQuery("select 
                                    p.*,
                                    s.name as input_bys 
                                    FROM varience as p 
                                    LEFT JOIN store as s on s.id=p.input_by 
                                    WHERE p.status='2' 
                                    " . $migratecond, 1);
        }
        $sqlCity = $sql_coustomer;
        //$totalrows = $obj->totalrows($table);
        echo "{\"data\":" . json_encode($sqlCity) . ",\"total\":" . $totalrows . "}";
    }
}


if ($verb == "POST") {
    $id = $_POST['id'];
    $table = $_POST['table'];
    if ($obj->delete($table, array("id" => $id)) == 1) {
        echo true;
    } else {
        echo 0;
    }
}
?>
