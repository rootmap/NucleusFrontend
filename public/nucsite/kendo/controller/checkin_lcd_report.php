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
        $cond = $plugin->BackEndDateSearch('from', 'to', 'date', 'r.', ' WHERE ');
        
        if (empty($cond)) {
            $conds_operate = " WHERE ";
        } else {
            $conds_operate =" AND ";
        }
        
        if ($input_status == 1) {
            for ($i = 0; $i <= $filtercount - 1; $i++):
                if ($i == 0) {
                    $confilter = $plugin->KendoFilter($filter_data, "AllKenduData.", $i);
                } else {
                    $confilter .=" AND " . $plugin->KendoFilter($filter_data, "AllKenduData.", $i);
                }
            endfor;

            $migratecond = $confilter;
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

                $migratecond = $cond . $inner_cond." crt.lcdstatus!='0'";
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
            $newcond = " ".$conds_operate." `r`.`input_by`='" . $input_by . "'";
            $migratecond = $cond." ".$newcond." crt.lcdstatus!='0'";
        }

        $sqlpars = "SELECT alldata.*,
                            IFNULL((SELECT SUM(amount) FROM invoice_payment WHERE invoice_id=alldata.invoice_id GROUP BY invoice_id),0) as paid,
                            #alldata.invoice_id as inid 
                            p.price_cost as our_cost
                    FROM (select
                    r.id,
                    r.checkin_id,
                    CONCAT(replace(c.`name`,' ',''),',',cv.`name`,',',cvc.`name`,',',cn.`name`) as `detail`,      
                    r.problem_id,
                    (SELECT COUNT(*) FROM check_user_price as cup WHERE cup.ckeckin_id=r.checkin_id)  AS pricechk,
                    #define product cost by case
                    CASE (SELECT COUNT(*) FROM check_user_price as cup WHERE cup.ckeckin_id=r.checkin_id)
                            WHEN 0 THEN 

                                    CASE (SELECT price_cost FROM product WHERE name=concat(replace(c.`name`,' ',''),'-',cp.`name`))
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
                                             (SELECT price_cost FROM product WHERE name=concat(replace(c.`name`,' ',''),'-',cp.`name`))
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
                    name=concat(replace(c.`name`,' ',''),', ',cv.`name`,' - ',cp.`name`) ORDER BY id DESC LIMIT 1),(SELECT id FROM product WHERE ";
                   $sqlpars .="#if not admin ";

                    if($input_status!=1)
                    {
                      if($input_status!=5)
                      {
                         $sqlpars .=" store_id='".$input_by."' AND ";
                      }
                    }

                   $sqlpars .="#if not admin  
                    name=concat(replace(c.`name`,' ',''),' , ',cv.`name`,' - ',cp.`name`) ORDER BY id DESC LIMIT 1)) AS pid,
                    pc.invoice_id,
                    r.date,
                    r.input_by,
                    crt.lcdstatus,
                    CASE crt.lcdstatus WHEN 1 THEN 'Good'
                    ELSE CASE crt.lcdstatus WHEN 2 THEN 'Bad'      
                    ELSE 'Not Mention'      
                    END END  AS lcdcondition,
                    r.status from checkin_request as r
                    INNER JOIN checkin as c ON c.id=r.device_id
                    INNER JOIN checkin_version as cv ON cv.id=r.model_id
                    INNER JOIN checkin_version_color as cvc ON cvc.id=r.color_id
                    INNER JOIN checkin_network as cn ON cn.id=r.network_id
                    INNER JOIN checkin_problem as cp ON cp.id=r.problem_id 
                    INNER JOIN pos_checkin as pc ON pc.checkin_id=r.checkin_id 
                    INNER JOIN checkin_request_ticket as crt ON crt.checkin_id=r.checkin_id 
                    " . $migratecond . "
                    GROUP BY r.id ORDER BY r.id DESC) AS alldata 
                    INNER JOIN product as p ON p.id=alldata.pid
                    WHERE alldata.invoice_id!='0' ";
                   
                   
                   $query_limit=" LIMIT ".$start.",".$pagesize;

                  // echo $sqlpars;


        /*
         * 
         * Introduce New Table 
         * CREATE TABLE IF NOT EXISTS `sold_salvage` (
          `id` int(20) AUTO_INCREMENT PRIMARY KEY,
          `sales_id` int(20)
          )

         * Introducce new field in            */

        $sqlparss = $sqlpars;

        $sqlparamgen = $plugin->KenduFilterParam($sqlpars.$query_limit, $confilter);
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
        $cond = $plugin->BackEndDateSearch('from', 'to', 'date', 'r.', ' WHERE ');

        if (empty($cond)) {
            $cond=" WHERE ";
            $conds_operate = " ";
        } else {
            $conds_operate = " AND ";
        }

        if ($input_status == 1) {
            $migratecond = " WHERE crt.lcdstatus!='0'";
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

                $migratecond = $cond . $inner_cond." AND crt.lcdstatus!='0'";


                //echo "Work";
            } else {
                //echo "Not Work";
                $migratecond = " ".$conds_operate." a.id='0'";
            }
        } else {

            $newcond = " ".$conds_operate." `r`.`input_by`='" . $input_by . "'";
            $migratecond = $cond . $newcond." AND crt.lcdstatus!='0'";
        }


        $sqlpars = "SELECT alldata.*,
                            IFNULL((SELECT SUM(amount) FROM invoice_payment WHERE invoice_id=alldata.invoice_id GROUP BY invoice_id),0) as paid,
                            #alldata.invoice_id as inid 
                            p.price_cost as our_cost
                    FROM (select
                    r.id,
                    r.checkin_id,
                    CONCAT(replace(c.`name`,' ',''),',',cv.`name`,',',cvc.`name`,',',cn.`name`) as `detail`,      
                    cp.`name` as problem,
                    #define product cost by case
                    CASE (SELECT COUNT(*) FROM check_user_price as cup WHERE cup.ckeckin_id=r.checkin_id)
                            WHEN 0 THEN 

                                    CASE (SELECT price_cost FROM product WHERE name=concat(replace(c.`name`,' ',''),'-',cp.`name`))
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
                                             (SELECT price_cost FROM product WHERE name=concat(replace(c.`name`,' ',''),'-',cp.`name`))
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
                    name=concat(replace(c.`name`,' ',''),', ',cv.`name`,' - ',cp.`name`) ORDER BY id DESC LIMIT 1),(SELECT id FROM product WHERE ";
                   $sqlpars .="#if not admin ";

                    if($input_status!=1)
                    {
                      if($input_status!=5)
                      {
                         $sqlpars .=" store_id='".$input_by."' AND ";
                      }
                    }

                   $sqlpars .="#if not admin  
                    name=concat(replace(c.`name`,' ',''),' , ',cv.`name`,' - ',cp.`name`) ORDER BY id DESC LIMIT 1)) AS pid,
                    pc.invoice_id,
                    r.date,
                    r.input_by,
                    crt.lcdstatus,
                    CASE crt.lcdstatus WHEN 1 THEN 'Good'
                    ELSE CASE crt.lcdstatus WHEN 2 THEN 'Bad'      
                    ELSE 'Not Mention'      
                    END END  AS lcdcondition,
                    r.status from checkin_request as r
                    INNER JOIN checkin as c ON c.id=r.device_id
                    INNER JOIN checkin_version as cv ON cv.id=r.model_id
                    INNER JOIN checkin_version_color as cvc ON cvc.id=r.color_id
                    INNER JOIN checkin_network as cn ON cn.id=r.network_id
                    INNER JOIN checkin_problem as cp ON cp.id=r.problem_id 
                    INNER JOIN pos_checkin as pc ON pc.checkin_id=r.checkin_id 
                    INNER JOIN checkin_request_ticket as crt ON crt.checkin_id=r.checkin_id
                    " . $migratecond . " 
                    GROUP BY r.id ORDER BY r.id DESC) AS alldata 
                    INNER JOIN product as p ON p.id=alldata.pid
                    WHERE alldata.invoice_id!='0' ";
                   
                   
                   $query_limit=" LIMIT ".$start.",".$pagesize;
                   
        //echo $sqlpars;
        

        $sql_coustomer = $obj->FlyQuery($sqlpars.$query_limit);



        $totalrows = $obj->FlyQuery($sqlpars, 1);

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
