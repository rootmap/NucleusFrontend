<?php
include '../class/auth.php';
header("Content-type: application/json");
$verb = $_SERVER["REQUEST_METHOD"];
$table = "checkin_request";
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
        
        if (empty($cond)) {
            $conds_operate = " AND ";
        } else {
            $conds_operate = " AND ";
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

                $inner_cond = ' '.$conds_operate.' (';
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

        $sqlpars = "SELECT alldata.*,
                            IFNULL((SELECT SUM(amount) FROM invoice_payment WHERE invoice_id=alldata.invoice_id GROUP BY invoice_id),0) as paid
                            #alldata.invoice_id as inid 
                    FROM (select
                    r.id,
                    r.checkin_id,
                    CONCAT(replace((SELECT name FROM checkin as c WHERE c.id=r.device_id),' ',''),',',(SELECT name FROM checkin_version as cv WHERE cv.id=r.model_id),',',(SELECT name FROM checkin_version_color as cvc WHERE cvc.id=r.color_id),',',(SELECT name FROM checkin_network as cn WHERE cn.id=r.network_id)) as `detail`,      
                    cp.`name` as problem,
                    #(SELECT COUNT(*) FROM check_user_price as cup WHERE cup.ckeckin_id=r.checkin_id)  AS pricechk,
                    #define product cost by case
                    CASE (SELECT price FROM check_user_price as cup WHERE cup.ckeckin_id=r.checkin_id)
                            WHEN 0 THEN 

                                    CASE (SELECT price_cost FROM product WHERE name=concat(replace((SELECT name FROM checkin as c WHERE c.id=r.device_id),' ',''),'-',cp.`name`))
                                            WHEN '' THEN 
                                             (SELECT name FROM checkin_price WHERE ";
                                 $sqlpars .="#only applicable if not admin ";
                                  
                                  if($input_status!=1)
                                  {
                                    if($input_status!=5)
                                    {
                                       $sqlpars .=" store_id='".$input_by."' AND ";
                                    }
                                  }
                                  
                                 $sqlpars .="#only applicable if not admin
                                             checkin_id=r.device_id AND 
                                             checkin_version_id=r.model_id AND 
                                             checkin_problem_id=r.problem_id ORDER BY id DESC LIMIT 1)
                                        ELSE 
                                             (SELECT price_cost FROM product WHERE name=concat(replace((SELECT name FROM checkin as c WHERE c.id=r.device_id),' ',''),'-',cp.`name`))
                                    END

                        ELSE 
                            CASE (SELECT price FROM check_user_price as cup WHERE cup.ckeckin_id=r.checkin_id)
                                    WHEN '' THEN 
                                                    (SELECT name FROM checkin_price WHERE ";
                                 $sqlpars .="#only applicable if not admin ";
                                  
                                  if($input_status!=1)
                                  {
                                    if($input_status!=5)
                                    {
                                       $sqlpars .=" store_id='".$input_by."' AND ";
                                    }
                                  }
                                  
                                  $sqlpars .="#only applicable if not admin
                                             checkin_id=r.device_id AND 
                                             checkin_version_id=r.model_id AND 
                                             checkin_problem_id=r.problem_id ORDER BY id DESC LIMIT 1)
                                ELSE (SELECT price FROM check_user_price as cup WHERE cup.ckeckin_id=r.checkin_id)
                            END    
                    END AS checkin_price,    
                    #define product cost by case end

                    #get pid by concat device detail
                    IFNULL((SELECT id FROM product WHERE ";
                   $sqlpars .="#if not admin ";

                    if($input_status!=1)
                    {
                      if($input_status!=5)
                      {
                         $sqlpars .=" store_id='".$input_by."' AND ";
                      }
                    }

                   $sqlpars .="#if not admin                    
                    name=concat(replace((SELECT name FROM checkin as c WHERE c.id=r.device_id),' ',''),', ',(SELECT name FROM checkin_version as cv WHERE cv.id=r.model_id),' - ',cp.`name`) ORDER BY id DESC LIMIT 1),(SELECT id FROM product WHERE ";
                   $sqlpars .="#if not admin ";

                    if($input_status!=1)
                    {
                      if($input_status!=5)
                      {
                         $sqlpars .=" store_id='".$input_by."' AND ";
                      }
                    }

                   $sqlpars .="#if not admin  
                    name=concat(replace((SELECT name FROM checkin as c WHERE c.id=r.device_id),' ',''),' , ',(SELECT name FROM checkin_version as cv WHERE cv.id=r.model_id),' - ',cp.`name`) ORDER BY id DESC LIMIT 1)) AS pid,
                    #get pid by concat device detail END
                    IFNULL((SELECT id FROM coustomer as cus WHERE cus.firstname=r.first_name AND cus.phone=r.phone LIMIT 1),0) as cid,
                    #pc.invoice_id as invoice_id,
                    IFNULL((SELECT invoice_id FROM pos_checkin WHERE checkin_id=r.checkin_id LIMIT 1),0) as invoice_id,
                    #(SELECT count(id) FROM invoice WHERE invoice_id=IFNULL((SELECT invoice_id FROM pos_checkin WHERE checkin_id=r.checkin_id),0) LIMIT 1) AS invoice_status,
                    #ip.amount as paid,
                    #(SELECT SUM(amount) FROM invoice_payment WHERE invoice_id= GROUP BY invoice_id) as paid,
                    r.date,
                    r.input_by,
                    r.status from checkin_request as r
                    #INNER JOIN pos_checkin as pc on pc.checkin_id=r.checkin_id
                    #INNER JOIN (SELECT SUM(amount) as amount,invoice_id FROM invoice_payment GROUP BY invoice_id) as ip on ip.invoice_id=pc.invoice_id
                    #INNER JOIN checkin as c ON c.id=r.device_id
                    #INNER JOIN checkin_version as cv ON cv.id=r.model_id
                    #INNER JOIN checkin_version_color as cvc ON cvc.id=r.color_id
                    #INNER JOIN checkin_network as cn ON cn.id=r.network_id
                    INNER JOIN checkin_problem as cp ON cp.id=r.problem_id 
                    WHERE r.checkin_id IN (SELECT crt.checkin_id FROM checkin_request_ticket as crt) 
                    " . $migratecond . " 
                    ORDER BY id DESC 
                    LIMIT ".$start.",".$pagesize.") AS alldata";

                  // echo $sqlpars;


        /*
         * 
         * Introduce New Table 
         * CREATE TABLE IF NOT EXISTS `sold_salvage` (
          `id` int(20) AUTO_INCREMENT PRIMARY KEY,
          `sales_id` int(20)
          )

         * Introducce new field in            */

        $sqlparss = "select
                    r.id,
                    r.checkin_id,
                    r.date,
                    r.input_by,
                    r.status from checkin_request as r
                    WHERE r.checkin_id IN (SELECT crt.checkin_id FROM checkin_request_ticket as crt)  
                    " . $migratecond;

        $sqlparamgen = $plugin->KenduFilterParam($sqlpars, $confilter);
        $filter_result = $obj->FlyQuery($sqlparamgen);
        $total_in_filter = $obj->FlyQuery($plugin->KenduFilterParam($sqlparss, $confilter), "1");


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

        if (empty($cond)) {
            $conds_operate = " AND ";
        } else {
            $conds_operate = " AND ";
        }

        if ($input_status == 1) {
            $migratecond = $cond;
        } elseif ($input_status == 5) {

            $sqlchain_store_ids = $obj->SelectAllByID("store_chain_admin", array("sid" => $input_by));
            if (!empty($sqlchain_store_ids)) {

                $inner_cond = ' '.$conds_operate.' (';
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
                $migratecond = " ".$conds_operate." a.id='0'";
            }
        } else {

            $newcond = " ".$conds_operate." `r`.`input_by`='" . $input_by . "'";
            $migratecond = $cond . $newcond;
        }


        $sqlpars = "SELECT alldata.*,
                            IFNULL((SELECT SUM(amount) FROM invoice_payment WHERE invoice_id=alldata.invoice_id GROUP BY invoice_id),0) as paid
                            
                    FROM (select
                    r.id,
                    r.checkin_id,
                    CONCAT(replace((SELECT name FROM checkin as c WHERE c.id=r.device_id),' ',''),',',(SELECT name FROM checkin_version as cv WHERE cv.id=r.model_id),',',(SELECT name FROM checkin_version_color as cvc WHERE cvc.id=r.color_id),',',(SELECT name FROM checkin_network as cn WHERE cn.id=r.network_id)) as `detail`,      
                    cp.`name` as problem,
                    #(SELECT COUNT(*) FROM check_user_price as cup WHERE cup.ckeckin_id=r.checkin_id)  AS pricechk,
                    
                    CASE (SELECT price FROM check_user_price as cup WHERE cup.ckeckin_id=r.checkin_id)
                            WHEN 0 THEN 

                                    CASE (SELECT price_cost FROM product WHERE name=concat(replace((SELECT name FROM checkin as c WHERE c.id=r.device_id),' ',''),'-',cp.`name`))
                                            WHEN '' THEN 
                                             (SELECT name FROM checkin_price WHERE ";
                                 $sqlpars .=" ";
                                  
                                  if($input_status!=1)
                                  {
                                    if($input_status!=5)
                                    {
                                       $sqlpars .=" store_id='".$input_by."' AND ";
                                    }
                                  }
                                  
                                 $sqlpars .="
                                             checkin_id=r.device_id AND 
                                             checkin_version_id=r.model_id AND 
                                             checkin_problem_id=r.problem_id ORDER BY id DESC LIMIT 1)
                                        ELSE 
                                             (SELECT price_cost FROM product WHERE name=concat(replace((SELECT name FROM checkin as c WHERE c.id=r.device_id),' ',''),'-',cp.`name`))
                                    END

                        ELSE 
                            CASE (SELECT price FROM check_user_price as cup WHERE cup.ckeckin_id=r.checkin_id)
                                    WHEN '' THEN 
                                                    (SELECT name FROM checkin_price WHERE ";
                                 $sqlpars .="#only applicable if not admin ";
                                  
                                  if($input_status!=1)
                                  {
                                    if($input_status!=5)
                                    {
                                       $sqlpars .=" store_id='".$input_by."' AND ";
                                    }
                                  }
                                  
                                  $sqlpars .="#only applicable if not admin
                                             checkin_id=r.device_id AND 
                                             checkin_version_id=r.model_id AND 
                                             checkin_problem_id=r.problem_id ORDER BY id DESC LIMIT 1)
                                ELSE (SELECT price FROM check_user_price as cup WHERE cup.ckeckin_id=r.checkin_id)
                            END    
                    END AS checkin_price,    
                    

                    
                    IFNULL((SELECT id FROM product WHERE ";
                   $sqlpars .="";

                    if($input_status!=1)
                    {
                      if($input_status!=5)
                      {
                         $sqlpars .=" store_id='".$input_by."' AND ";
                      }
                    }

                   $sqlpars .="                   
                    name=concat(replace((SELECT name FROM checkin as c WHERE c.id=r.device_id),' ',''),', ',(SELECT name FROM checkin_version as cv WHERE cv.id=r.model_id),' - ',cp.`name`) ORDER BY id DESC LIMIT 1),(SELECT id FROM product WHERE ";
                   $sqlpars .="";

                    if($input_status!=1)
                    {
                      if($input_status!=5)
                      {
                         $sqlpars .=" store_id='".$input_by."' AND ";
                      }
                    }

                   $sqlpars .="
                    name=concat(replace((SELECT name FROM checkin as c WHERE c.id=r.device_id),' ',''),' , ',(SELECT name FROM checkin_version as cv WHERE cv.id=r.model_id),' - ',cp.`name`) ORDER BY id DESC LIMIT 1)) AS pid,
                    
                    IFNULL((SELECT id FROM coustomer as cus WHERE cus.firstname=r.first_name AND cus.phone=r.phone LIMIT 1),0) as cid,
                    
                    IFNULL((SELECT invoice_id FROM pos_checkin WHERE checkin_id=r.checkin_id LIMIT 1),0) as invoice_id,
                    r.date,
                    r.input_by,
                    r.status from checkin_request as r
                    #INNER JOIN checkin as c ON c.id=r.device_id
                    #INNER JOIN checkin_version as cv ON cv.id=r.model_id
                    #INNER JOIN checkin_version_color as cvc ON cvc.id=r.color_id
                    #INNER JOIN checkin_network as cn ON cn.id=r.network_id
                    INNER JOIN checkin_problem as cp ON cp.id=r.problem_id 
                    WHERE r.checkin_id IN (SELECT crt.checkin_id FROM checkin_request_ticket as crt) 
                    " . $migratecond . " 
                    ORDER BY id DESC 
                    LIMIT ".$start.",".$pagesize.") AS alldata";
       // echo $sqlpars;
        

        $sql_coustomer = $obj->FlyQuery($sqlpars);



        $totalrows = $obj->FlyQuery("select
                                    r.id,
                                    r.checkin_id,
                                    r.date,
                                    r.input_by,
                                    r.status from checkin_request as r
                                    WHERE r.checkin_id IN (SELECT crt.checkin_id FROM checkin_request_ticket as crt) 
                                    " . $migratecond, 1);

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
