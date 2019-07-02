<?php
include '../class/auth.php';
header("Content-type: application/json");
$verb = $_SERVER["REQUEST_METHOD"];
$table = "product";
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
        $cond = $plugin->BackEndDateSearch('from', 'to', 'date', 'p.', ' AND ');
        if ($input_status == 1) {
            for ($i = 0; $i <= $filtercount - 1; $i++):
                if ($i == 0) {
                    $confilter = $plugin->KendoFilter($filter_data, "AllKenduData.", $i);
                } else {
                    $confilter .=" AND " . $plugin->KendoFilter($filter_data, "AllKenduData.", $i);
                }
            endfor;
            
            $migratecond=$cond;
            
        } elseif ($input_status == 5) {
            $sqlchain_store_ids = $obj->FlyQuery("SELECT sid,store_id FROM store_chain_admin WHERE sid='" . $input_by . "'");
            if (!empty($sqlchain_store_ids)) {
                
                    $inner_cond = ' AND (';
                    $i = 1;
                    foreach ($sqlchain_store_ids as $ch):
                        if ($i == 1) {
                            $inner_cond = "`p`.`input_by`='" . $ch->store_id . "'";
                        } else {
                            $inner_cond = " OR `p`.`input_by`='" . $ch->store_id . "'";
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
                
                $migratecond=$cond.$inner_cond;
                
            } else {
                $confilter = '';
                $migratecond=" WHERE ur.id='0' ";
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
            
            $migratecond=$cond;
            
        }


          $sqlpar = "select 
                    p.`id`,
                    p.`store_id`,
                    p.`name`,
                    p.`description`,
                    p.`barcode`,
                    p.`price_cost`,
                    p.`price_retail`,
                    p.`quantity` AS `quantity`,
                    IFNULL((p.`quantity`-IFNULL(SUM(s.quantity),0)),0) AS instock,
                    p.`input_by` AS `input_by`,
                    p.`access_id` AS `access_id`,
                    p.`date` AS `date`,
                    p.`status` AS `status` 
                    from `product` as p 
                    LEFT JOIN sales as s on s.pid=p.id AND s.salvage_part='0'
                    where `p`.`description` = 'Product Added From Checkin' 
                    " . $migratecond . " 
                    GROUP BY `p`.`id` 
                    order by `p`.`name` DESC LIMIT $start,$pagesize";
          
          
          /*
           * 
           * Introduce New Table 
           * CREATE TABLE IF NOT EXISTS `sold_salvage` (
  `id` int(20) AUTO_INCREMENT PRIMARY KEY,
  `sales_id` int(20)
) 

           * Introducce new field in            */
          
          $sqlpars = "select 
                    p.`id`,
                    p.`store_id`,
                    p.`name`,
                    p.`description`,
                    p.`barcode`,
                    p.`price_cost`,
                    p.`price_retail`,
                    p.`quantity` AS `quantity`,
                    p.`input_by` AS `input_by`,
                    p.`access_id` AS `access_id`,
                    p.`date` AS `date`,
                    p.`status` AS `status` 
                    from `product` as p 
                    where `p`.`description` = 'Product Added From Checkin' 
                    " . $migratecond . " 
                    GROUP BY `p`.`id` 
                    order by `p`.`name` DESC";
         
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
        $cond = $plugin->BackEndDateSearch('from', 'to', 'date', 'p.', ' AND ');


        if ($input_status == 1) {
            $migratecond = $cond;
        } elseif ($input_status == 5) {

            $sqlchain_store_ids = $obj->SelectAllByID("store_chain_admin", array("sid" => $input_by));
            if (!empty($sqlchain_store_ids)) {

                    $inner_cond = ' AND (';
                    $i = 1;
                    foreach ($sqlchain_store_ids as $ch):
                        if ($i == 1) {
                            $inner_cond .= "`p`.`input_by`='" . $ch->store_id . "'";
                        } else {
                            $inner_cond .= " OR `p`.`input_by`='" . $ch->store_id . "'";
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
            
            $newcond = " AND `p`.`input_by`='" . $input_by . "'";
            $migratecond = $cond . $newcond;
            
        }

        

       $sql_coustomer = $obj->FlyQuery("select 
                    p.`id`,
                    p.`store_id`,
                    p.`name`,
                    p.`description`,
                    p.`barcode`,
                    p.`price_cost`,
                    p.`price_retail`,
                    p.`quantity` AS `quantity`,
                    IFNULL((p.`quantity`-IFNULL(SUM(s.quantity),0)),0) AS instock,
                    p.`input_by` AS `input_by`,
                    p.`access_id` AS `access_id`,
                    p.`date` AS `date`,
                    p.`status` AS `status` 
                    from `product` as p 
                    LEFT JOIN sales as s on s.pid=p.id AND s.salvage_part='0'
                    where `p`.`description` = 'Product Added From Checkin' 
                    " . $migratecond . " 
                    GROUP BY `p`.`id` 
                    order by `p`.`name` DESC LIMIT $start,$pagesize");
        
  
                                        
        $totalrows = $obj->FlyQuery("select 
                                    p.`id`,
                                    p.`store_id`,
                                    p.`name`,
                                    p.`description`,
                                    p.`barcode`,
                                    p.`input_by` AS `input_by`,
                                    p.`access_id` AS `access_id`,
                                    p.`date` AS `date`,
                                    p.`status` AS `status` 
                                    from `product` as p 
                                    where `p`.`description` = 'Product Added From Checkin' 
                                    " . $migratecond . " 
                                    GROUP BY `p`.`id` 
                                    ORDER BY `p`.`name` DESC", 1);
        
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
