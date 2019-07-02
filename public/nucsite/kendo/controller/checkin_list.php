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

        $sqlpars = "SELECT r.`chid` AS id, r.`checkin_id`, r.`detail`, r.`problem`, r.`checkin_price`, r.`paid`, r.`date`, r.`input_by`, r.`invoice_id`, r.`pid`, r.`cid` FROM `checkin_cron` as r
                    WHERE r.checkin_id!='0'  
                    " . $migratecond . " 
                    ORDER BY r.chid DESC 
                    LIMIT ".$start.",".$pagesize;

                  // echo $sqlpars;


        /*
         * 
         * Introduce New Table 
         * CREATE TABLE IF NOT EXISTS `sold_salvage` (
          `id` int(20) AUTO_INCREMENT PRIMARY KEY,
          `sales_id` int(20)
          )

         * Introducce new field in            */

        $sqlparss = "SELECT r.`chid` AS id, r.`checkin_id`, r.`detail`, r.`problem`, r.`checkin_price`, r.`paid`, r.`date`, r.`input_by`, r.`invoice_id`, r.`pid`, r.`cid` FROM `checkin_cron` as r
                    WHERE r.checkin_id!='0'  
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


        $sqlpars = "SELECT r.`chid` AS id, r.`checkin_id`, r.`detail`, r.`problem`, r.`checkin_price`, r.`paid`, r.`date`, r.`input_by`, r.`invoice_id`, r.`pid`, r.`cid` FROM `checkin_cron` as r
                    WHERE r.checkin_id!='0'  
                    " . $migratecond . " 
                    ORDER BY r.chid DESC 
                    LIMIT ".$start.",".$pagesize;
        //echo $sqlpars;
        

        $sql_coustomer = $obj->FlyQuery($sqlpars);



        $totalrows = $obj->FlyQuery("SELECT r.`chid` AS id, r.`checkin_id`, r.`detail`, r.`problem`, r.`checkin_price`, r.`paid`, r.`date`, r.`input_by`, r.`invoice_id`, r.`pid`, r.`cid` FROM `checkin_cron` as r
                    WHERE r.checkin_id!='0'  " . $migratecond, 1);

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
