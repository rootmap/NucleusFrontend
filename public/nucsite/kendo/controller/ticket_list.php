<?php
include '../class/auth.php';
header("Content-type: application/json");
$verb = $_SERVER["REQUEST_METHOD"];
$table = "ticket";
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
                        $inner_cond = "`t`.`input_by`='" . $ch->store_id . "'";
                    } else {
                        $inner_cond = " OR `t`.`input_by`='" . $ch->store_id . "'";
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
                    (SELECT SUM(amount) FROM invoice_payment WHERE invoice_id=alldata.invoice_id GROUP BY invoice_id) as paid
                    FROM (select 
                    t.id,
                    t.ticket_id,
                    t.title,
                    t.date,
                    t.status,
                    t.problem_type,
                    pt.name as problem,
                    CASE (SELECT count(id) FROM product WHERE name=concat(t.title,' - ',t.ticket_id)) 
                            WHEN 0 THEN 0
                        ELSE (SELECT id FROM product WHERE name=concat(t.title,' - ',t.ticket_id) ORDER BY id DESC LIMIT 1)
                    END AS pid,
                    CASE (SELECT count(id) FROM product WHERE name=concat(t.title,' - ',t.ticket_id)) 
                            WHEN 0 THEN 0
                        ELSE (SELECT price_retail FROM product WHERE name=concat(t.title,' - ',t.ticket_id) ORDER BY id DESC LIMIT 1)
                    END AS price,
                    IFNULL((SELECT invoice_id FROM pos_checkin WHERE checkin_id=t.ticket_id LIMIT 1),0) as invoice_id,
                    t.retail_cost AS pricee,
                    t.input_by
                    from ticket as t 
                    LEFT JOIN problem_type as pt ON pt.id=t.problem_type 
                    WHERE t.id!='0'     
                    " . $migratecond . " 
                    ORDER BY t.id DESC 
                    LIMIT ".$start.",".$pagesize.") AS alldata";

        

        $sqlparss = "select 
                    t.id,
                    t.ticket_id,
                    t.title,
                    t.date,
                    t.input_by
                    from ticket as t 
                    WHERE t.id!='0'   
                    " . $migratecond." 
                    ORDER BY id DESC ";

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
        $cond = $plugin->BackEndDateSearch('from', 'to', 'date', 't.', ' AND ');

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
                        $inner_cond .= "`t`.`input_by`='" . $ch->store_id . "'";
                    } else {
                        $inner_cond .= " OR `t`.`input_by`='" . $ch->store_id . "'";
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

            $newcond = " ".$conds_operate." `t`.`input_by`='" . $input_by . "'";
            $migratecond = $cond . $newcond;
        }


        $sqlpars = "SELECT alldata.*,
                    (SELECT SUM(amount) FROM invoice_payment WHERE invoice_id=alldata.invoice_id GROUP BY invoice_id) as paid
                    FROM (select 
                    t.id,
                    t.ticket_id,
                    t.title,
                    t.date,
                    t.status,
                    t.problem_type,
                    pt.name as problem,
                    CASE (SELECT count(id) FROM product WHERE name=concat(t.title,' - ',t.ticket_id)) 
                            WHEN 0 THEN 0
                        ELSE (SELECT id FROM product WHERE name=concat(t.title,' - ',t.ticket_id) ORDER BY id DESC LIMIT 1)
                    END AS pid,
                    CASE (SELECT count(id) FROM product WHERE name=concat(t.title,' - ',t.ticket_id)) 
                            WHEN 0 THEN 0
                        ELSE (SELECT price_retail FROM product WHERE name=concat(t.title,' - ',t.ticket_id) ORDER BY id DESC LIMIT 1)
                    END AS price,
                    IFNULL((SELECT invoice_id FROM pos_checkin WHERE checkin_id=t.ticket_id LIMIT 1),0) as invoice_id,
                    t.retail_cost AS pricee,
                    t.input_by
                    from ticket as t 
                    LEFT JOIN problem_type as pt ON pt.id=t.problem_type 
                    WHERE t.id!='0'     
                    " . $migratecond . " 
                    ORDER BY t.id DESC 
                    LIMIT ".$start.",".$pagesize.") AS alldata";
       // echo $sqlpars;
        

        $sql_coustomer = $obj->FlyQuery($sqlpars);



        $totalrows = $obj->FlyQuery("select 
                                    t.id,
                                    t.ticket_id,
                                    t.title,
                                    t.date,
                                    t.input_by
                                    from ticket as t 
                                    WHERE t.id!='0'      
                                    ".$migratecond." 
                                    ORDER BY id DESC", 1);

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
