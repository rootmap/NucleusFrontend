<?php
include '../class/auth.php';
header("Content-type: application/json");
$verb = $_SERVER["REQUEST_METHOD"];
$table = "reccurring_invoice";
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
        $cond = $plugin->BackEndDateSearch('from', 'to', 'date', 'r.', ' AND ');
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
                            $inner_cond = "`r`.`input_by`='" . $ch->store_id . "'";
                        } else {
                            $inner_cond = " OR `r`.`input_by`='" . $ch->store_id . "'";
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


          $sqlpar = "SELECT 
                    r.`id`, 
                    r.`cid`, 
                    CONCAT(c.firstname,' ',c.lastname) as `customer_name`,
                    CASE r.`frequency` 
                            WHEN 1 THEN 'Monthly'
                            ELSE CASE r.`frequency` WHEN 2 THEN 'Weekly' 
                            ELSE CASE r.`frequency` WHEN 3 THEN 'Biweekly' 
                            ELSE CASE r.`frequency` WHEN 4 THEN 'Quarterly' 
                            ELSE CASE r.`frequency` WHEN 5 THEN 'Semi-Annually' 
                            ELSE CASE r.`frequency` WHEN 6 THEN 'Annually' 
                            ELSE 'No Mention'
                            END END END END END 
                    END AS `frequency`, 
                    r.`sales_id`, 
                    r.`start_date`, 
                    r.`price`, 
                    r.`email`, 
                    IFNULL(r.`cradit_card`,'Not Added') AS cradit_card, 
                    r.`notes`,
                    IFNULL(r.`input_by`,0) AS input_by,
                    r.`date`, 
                    CASE r.`status`
                            WHEN 1 THEN 'Active' 
                            ELSE CASE r.`status` WHEN 2 THEN 'Cancel'
                            ELSE CASE r.`status` WHEN 0 THEN 'Pause'
                            ELSE 'Not Mention' 
                    END END
                    END AS `status` 
                    FROM 
                    `reccurring_invoice` AS r 
                    LEFT JOIN coustomer as c ON c.id=r.cid
                    where `r`.`id` != '0' 
                    " . $migratecond . " 
                    order by `r`.`id` DESC LIMIT $start,$pagesize";
          
          
          /*
           * 
           * Introduce New Table 
           * CREATE TABLE IF NOT EXISTS `sold_salvage` (
  `id` int(20) AUTO_INCREMENT PRIMARY KEY,
  `sales_id` int(20)
) 

           * Introducce new field in            */
          
          $sqlpars = "SELECT 
                    r.`id`, 
                    r.`cid`, 
                    CONCAT(c.firstname,' ',c.lastname) as `customer_name`,
                    CASE r.`frequency` 
                            WHEN 1 THEN 'Monthly'
                            ELSE CASE r.`frequency` WHEN 2 THEN 'Weekly' 
                            ELSE CASE r.`frequency` WHEN 3 THEN 'Biweekly' 
                            ELSE CASE r.`frequency` WHEN 4 THEN 'Quarterly' 
                            ELSE CASE r.`frequency` WHEN 5 THEN 'Semi-Annually' 
                            ELSE CASE r.`frequency` WHEN 6 THEN 'Annually' 
                            ELSE 'No Mention'
                            END END END END END 
                    END AS `frequency`, 
                    r.`sales_id`, 
                    r.`start_date`, 
                    r.`price`, 
                    r.`email`, 
                    IFNULL(r.`cradit_card`,'Not Added') AS cradit_card, 
                    r.`notes`,
                    IFNULL(r.`input_by`,0) AS input_by,
                    r.`date`, 
                    CASE r.`status`
                            WHEN 1 THEN 'Active' 
                            ELSE CASE r.`status` WHEN 2 THEN 'Cancel'
                            ELSE CASE r.`status` WHEN 0 THEN 'Pause'
                            ELSE 'Not Mention' 
                    END END
                    END AS `status` 
                    FROM 
                    `reccurring_invoice` AS r 
                    LEFT JOIN coustomer as c ON c.id=r.cid
                    where `r`.`id` != '0' 
                    " . $migratecond . " 
                    order by `r`.`id` DESC";
         
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
        $cond = $plugin->BackEndDateSearch('from', 'to', 'date', 'r.', ' AND ');


        if ($input_status == 1) {
            $migratecond = $cond;
        } elseif ($input_status == 5) {

            $sqlchain_store_ids = $obj->SelectAllByID("store_chain_admin", array("sid" => $input_by));
            if (!empty($sqlchain_store_ids)) {

                    $inner_cond = ' AND (';
                    $i = 1;
                    foreach ($sqlchain_store_ids as $ch):
                        if ($i == 1) {
                            $inner_cond .= "`r`.`input_by`='" . $ch->store_id . "'";
                        } else {
                            $inner_cond .= " OR `r`.`input_by`='" . $ch->store_id . "'";
                        }
                        $i++;
                    endforeach;
                    $inner_cond .=')';

                $migratecond = $cond . $inner_cond;


                //echo "Work";
            } else {
                //echo "Not Work";
                $migratecond = " WHERE r.id='0'";
            }
        } else {
            
            $newcond = " AND `r`.`input_by`='" . $input_by . "'";
            $migratecond = $cond . $newcond;
            
        }

        

       $sql_coustomer = $obj->FlyQuery("SELECT 
                    r.`id`, 
                    r.`cid`, 
                    CONCAT(c.firstname,' ',c.lastname) as `customer_name`,
                    CASE r.`frequency` 
                            WHEN 1 THEN 'Monthly'
                            ELSE CASE r.`frequency` WHEN 2 THEN 'Weekly' 
                            ELSE CASE r.`frequency` WHEN 3 THEN 'Biweekly' 
                            ELSE CASE r.`frequency` WHEN 4 THEN 'Quarterly' 
                            ELSE CASE r.`frequency` WHEN 5 THEN 'Semi-Annually' 
                            ELSE CASE r.`frequency` WHEN 6 THEN 'Annually' 
                            ELSE 'No Mention'
                            END END END END END 
                    END AS `frequency`, 
                    r.`sales_id`, 
                    r.`start_date`, 
                    r.`price`, 
                    r.`email`, 
                    IFNULL(r.`cradit_card`,'Not Added') AS cradit_card, 
                    r.`notes`,
                    IFNULL(r.`input_by`,0) AS input_by,
                    r.`date`, 
                    CASE r.`status`
                            WHEN 1 THEN 'Active' 
                            ELSE CASE r.`status` WHEN 2 THEN 'Cancel'
                            ELSE CASE r.`status` WHEN 0 THEN 'Pause'
                            ELSE 'Not Mention' 
                    END END
                    END AS `status` 
                    FROM 
                    `reccurring_invoice` AS r 
                    LEFT JOIN coustomer as c ON c.id=r.cid
                    where `r`.`id` != '0' 
                    " . $migratecond . " 
                    order by `r`.`id` DESC LIMIT $start,$pagesize");
        
  
                                        
        $totalrows = $obj->FlyQuery("SELECT 
                                    r.`id`, 
                                    r.`cid`, 
                                    CONCAT(c.firstname,' ',c.lastname) as `customer_name`,
                                    CASE r.`frequency` 
                                            WHEN 1 THEN 'Monthly'
                                            ELSE CASE r.`frequency` WHEN 2 THEN 'Weekly' 
                                            ELSE CASE r.`frequency` WHEN 3 THEN 'Biweekly' 
                                            ELSE CASE r.`frequency` WHEN 4 THEN 'Quarterly' 
                                            ELSE CASE r.`frequency` WHEN 5 THEN 'Semi-Annually' 
                                            ELSE CASE r.`frequency` WHEN 6 THEN 'Annually' 
                                            ELSE 'No Mention'
                                            END END END END END 
                                    END AS `frequency`, 
                                    r.`sales_id`, 
                                    r.`start_date`, 
                                    r.`price`, 
                                    r.`email`, 
                                    IFNULL(r.`cradit_card`,'Not Added') AS cradit_card, 
                                    r.`notes`,
                                    IFNULL(r.`input_by`,0) AS input_by,
                                    r.`date`, 
                                    CASE r.`status`
                                            WHEN 1 THEN 'Active' 
                                            ELSE CASE r.`status` WHEN 2 THEN 'Cancel'
                                            ELSE CASE r.`status` WHEN 0 THEN 'Pause'
                                            ELSE 'Not Mention' 
                                    END END
                                    END AS `status` 
                                    FROM 
                                    `reccurring_invoice` AS r 
                                    LEFT JOIN coustomer as c ON c.id=r.cid
                                    where `r`.`id` != '0' 
                                    " . $migratecond . " 
                                    ORDER BY `r`.`id` DESC", 1);
        
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
