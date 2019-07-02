<?php
include '../class/auth.php';
header("Content-type: application/json");
$verb = $_SERVER["REQUEST_METHOD"];
$table = "parts_order";
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
        $cond = $plugin->BackEndDateSearch('from', 'to', 'date', 'a.', ' WHERE ');
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
                if (!empty($cond)) {
                    $inner_cond = ' AND (';
                    $i = 1;
                    foreach ($sqlchain_store_ids as $ch):
                        if ($i == 1) {
                            $inner_cond = "a.uid='" . $ch->store_id . "'";
                        } else {
                            $inner_cond = " OR a.uid='" . $ch->store_id . "'";
                        }
                        $i++;
                    endforeach;
                    $inner_cond .=')';
                } else {
                    $inner_cond = ' WHERE (';
                    $i = 1;
                    foreach ($sqlchain_store_ids as $ch):
                        if ($i == 1) {
                            $inner_cond = "a.uid='" . $ch->store_id . "'";
                        } else {
                            $inner_cond = " OR a.uid='" . $ch->store_id . "'";
                        }
                        $i++;
                    endforeach;
                    $inner_cond .=')';
                }

                
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
                    a.id,
                    a.uid,
                    a.warrenty_id,
                    a.type,
                    CASE type WHEN 'ticket' THEN (SELECT retail_cost FROM ticket WHERE ticket.ticket_id=a.warrenty_id)
                    ELSE CASE type WHEN 'checkin' THEN (SELECT price FROM check_user_price WHERE check_user_price.ckeckin_id=a.warrenty_id)
                    ELSE 0 END END AS retail_cost,
                    a.warrenty,
                    a.note,
                    a.access_id,
                    a.date,
                    a.status,
                    DATEDIFF(CURDATE(),a.date) as `daysgone`,
                    (a.warrenty-DATEDIFF(CURDATE(),a.date)) as `warrenty_left`
                    FROM `warrenty` as a 
                    " . $migratecond . "
                    ORDER BY a.id DESC";
         
        $sqlparamgen = $plugin->KenduFilterParam($sqlpar, $confilter) . " LIMIT $start,$pagesize";
        $filter_result = $obj->FlyQuery($sqlparamgen);
        $total_in_filter = $obj->FlyQuery($plugin->KenduFilterParam($sqlpar, $confilter), "1");


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
        $cond = $plugin->BackEndDateSearch('from', 'to', 'date', 'a.', 'WHERE ');


        if ($input_status == 1) {
            $migratecond = $cond;
        } elseif ($input_status == 5) {

            $sqlchain_store_ids = $obj->SelectAllByID("store_chain_admin", array("sid" => $input_by));
            if (!empty($sqlchain_store_ids)) {

                if (!empty($cond)) {
                    $inner_cond = ' AND (';
                    $i = 1;
                    foreach ($sqlchain_store_ids as $ch):
                        if ($i == 1) {
                            $inner_cond .= "a.uid='" . $ch->store_id . "'";
                        } else {
                            $inner_cond .= " OR a.uid='" . $ch->store_id . "'";
                        }
                        $i++;
                    endforeach;
                    $inner_cond .=')';
                } else {
                    $inner_cond = ' WHERE (';
                    $i = 1;
                    foreach ($sqlchain_store_ids as $ch):
                        if ($i == 1) {
                            $inner_cond .= "a.uid='" . $ch->store_id . "'";
                        } else {
                            $inner_cond .= " OR a.uid='" . $ch->store_id . "'";
                        }
                        $i++;
                    endforeach;
                    $inner_cond .=')';
                }

                $migratecond = $cond . $inner_cond;


                //echo "Work";
            } else {
                //echo "Not Work";
                $migratecond = " WHERE a.id='0'";
            }
        } else {
            if (!empty($cond)) {
                $newcond = " AND a.uid='" . $input_by . "'";
            } else {
                $newcond = " WHERE a.uid='" . $input_by . "'";
            }

            $migratecond = $cond . $newcond;
        }


        $sql_coustomer = $obj->FlyQuery("SELECT 
                                        a.id,
                                        a.uid,
                                        a.warrenty_id,
                                        a.type,
                                        CASE type WHEN 'ticket' THEN (SELECT retail_cost FROM ticket WHERE ticket.ticket_id=a.warrenty_id)
                                        ELSE CASE type WHEN 'checkin' THEN (SELECT price FROM check_user_price WHERE check_user_price.ckeckin_id=a.warrenty_id)
                                        ELSE 0 END END AS retail_cost,
                                        a.warrenty,
                                        a.note,
                                        a.access_id,
                                        a.date,
                                        a.status,
                                        DATEDIFF(CURDATE(),a.date) as `daysgone`,
                                        (a.warrenty-DATEDIFF(CURDATE(),a.date)) as `warrenty_left`
                                        FROM `warrenty` as a 
                                        " . $migratecond . " 
                                        ORDER BY a.id DESC LIMIT $start,$pagesize");
        $totalrows = $obj->FlyQuery("SELECT 
                                        a.id,
                                        a.uid,
                                        a.warrenty_id,
                                        a.type,
                                        CASE type WHEN 'ticket' THEN (SELECT retail_cost FROM ticket WHERE ticket.ticket_id=a.warrenty_id)
                                        ELSE CASE type WHEN 'checkin' THEN (SELECT price FROM check_user_price WHERE check_user_price.ckeckin_id=a.warrenty_id)
                                        ELSE 0 END END AS retail_cost,
                                        a.warrenty,
                                        a.note,
                                        a.access_id,
                                        a.date,
                                        a.status,
                                        DATEDIFF(CURDATE(),a.date) as `daysgone`,
                                        (a.warrenty-DATEDIFF(CURDATE(),a.date)) as `warrenty_left`
                                        FROM `warrenty` as a 
                                        " . $migratecond . " 
                                        ORDER BY a.id DESC", 1);
        
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
