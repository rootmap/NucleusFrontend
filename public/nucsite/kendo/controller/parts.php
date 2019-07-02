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

        if ($input_status == 1) {
            $cond = $plugin->BackEndDateSearch('from', 'to', 'date', 'customer.', ' AND ');
            for ($i = 0; $i <= $filtercount - 1; $i++):
                if ($i == 0) {
                    $confilter = $plugin->KendoFilter($filter_data, "AllKenduData.", $i);
                } else {
                    $confilter .=" AND " . $plugin->KendoFilter($filter_data, "AllKenduData.", $i);
                }
            endfor;
            
            
            if (isset($_GET['report_cid'])) {
                    if (!empty($cond)) {
                        $cond .=" AND t.cid='" . $_GET['report_cid'] . "'";
                    } else {
                        $cond .=" AND t.cid='" . $_GET['report_cid'] . "'";
                    }
                }
            
            $sqlpar = "select a.*,IFNULL(t.cid,0) as cid,IFNULL(c.name,'') as name from `" . $table . "` as a 
                                    LEFT JOIN (SELECT cid,ticket_id FROM ticket) as t ON t.ticket_id=a.ticket_id 
                                    LEFT JOIN (SELECT id,concat(firstname,' ',lastname) as name FROM coustomer) as c ON c.id=t.cid ORDER BY a.id DESC";
            $sqlparamgen = $plugin->KenduFilterParam($sqlpar, $confilter . "" . $cond) . " LIMIT $start,$pagesize";
            $filter_result = $obj->FlyQuery($sqlparamgen);
            $total_in_filter = $obj->FlyQuery($plugin->KenduFilterParam($sqlpar, $confilter . "" . $cond), "1");
        } elseif ($input_status == 5) {

            $sqlchain_store_ids = $obj->FlyQuery("SELECT sid,store_id FROM store_chain_admin WHERE sid='" . $input_by . "'");
            if (!empty($sqlchain_store_ids)) {
                $array_ch = array();
                $inner_cond = ' WHERE (';
                $i = 1;
                foreach ($sqlchain_store_ids as $ch):
                    if ($i == 1) {
                        $inner_cond = "input_by='" . $ch->store_id . "'";
                    } else {
                        $inner_cond = " OR input_by='" . $ch->store_id . "'";
                    }
                    array_push($array_ch, $ch->store_id);
                    $i++;
                endforeach;
                $inner_cond .=')';


                $cond = $plugin->BackEndDateSearch('from', 'to', 'date', 'customer.', ' AND ');
                for ($i = 0; $i <= $filtercount - 1; $i++):
                    if ($i == 0) {
                        $confilter = $plugin->KendoFilter($filter_data, "AllKenduData.", $i);
                    } else {
                        $confilter .=" AND " . $plugin->KendoFilter($filter_data, "AllKenduData.", $i);
                    }
                endfor;
                
                if (isset($_GET['report_cid'])) {
                    if (!empty($cond)) {
                        $cond .=" AND t.cid='" . $_GET['report_cid'] . "'";
                    } else {
                        $cond .=" AND t.cid='" . $_GET['report_cid'] . "'";
                    }
                }
                
                $sqlpar = "select a.*,IFNULL(t.cid,0) as cid,IFNULL(c.name,'') as name from `" . $table . "` as a 
                                    LEFT JOIN (SELECT cid,ticket_id FROM ticket) as t ON t.ticket_id=a.ticket_id 
                                    LEFT JOIN (SELECT id,concat(firstname,' ',lastname) as name FROM coustomer) as c ON c.id=t.cid " . $inner_cond . " ORDER BY a.id DESC";

                $sqlparamgen = $plugin->KenduFilterParam($sqlpar, $confilter . "" . $cond) . " LIMIT $start,$pagesize";
                $filter_result = $obj->FlyQuery($sqlparamgen);
                $total_in_filter = $obj->FlyQuery($plugin->KenduFilterParam($sqlpar, $confilter . "" . $cond), "1");
            } else {
                $filter_result = "";
                $total_in_filter = 0;
            }
        } else {

            $confilter = '';
            $cond = $plugin->BackEndDateSearch('from', 'to', 'date', 'customer.', ' AND ');
            for ($i = 0; $i <= $filtercount - 1; $i++):
                if ($i == 0) {
                    $confilter = $plugin->KendoFilter($filter_data, "AllKenduData.", $i);
                } else {
                    $confilter .=" AND " . $plugin->KendoFilter($filter_data, "AllKenduData.", $i);
                }
            endfor;

            if (isset($_GET['report_cid'])) {
                if (!empty($cond)) {
                    $cond .=" AND t.cid='" . $_GET['report_cid'] . "'";
                } else {
                    $cond .=" AND t.cid='" . $_GET['report_cid'] . "'";
                }
            }

            $sqlpar = "select a.*,IFNULL(t.cid,0) as cid,IFNULL(c.name,'') as name from `" . $table . "` as a 
                                    LEFT JOIN (SELECT cid,ticket_id FROM ticket) as t ON t.ticket_id=a.ticket_id 
                                    LEFT JOIN (SELECT id,concat(firstname,' ',lastname) as name FROM coustomer) as c ON c.id=t.cid 
                                    WHERE input_by='" . $input_by . "' ORDER BY a.id DESC";
            $sqlparamgen = $plugin->KenduFilterParam($sqlpar, $confilter . "" . $cond) . " LIMIT $start,$pagesize";
            $filter_result = $obj->FlyQuery($sqlparamgen);
            $total_in_filter = $obj->FlyQuery($plugin->KenduFilterParam($sqlpar, $confilter . "" . $cond), "1");
        }


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
            
            if (isset($_GET['report_cid'])) {
                    if (!empty($cond)) {
                        $cond .=" AND t.cid='" . $_GET['report_cid'] . "'";
                    } else {
                        $cond .=" WHERE t.cid='" . $_GET['report_cid'] . "'";
                    }
                }
            
            $sql_coustomer = $obj->FlyQuery("select a.*,IFNULL(t.cid,0) as cid,IFNULL(c.name,'') as name from `" . $table . "` as a 
                                LEFT JOIN (SELECT cid,ticket_id FROM ticket) as t ON t.ticket_id=a.ticket_id 
                                LEFT JOIN (SELECT id,concat(firstname,' ',lastname) as name FROM coustomer) as c ON c.id=t.cid " . $cond . " ORDER BY a.id DESC LIMIT $start,$pagesize");

            $totalrows = $obj->FlyQuery("select a.*,IFNULL(t.cid,0) as cid,IFNULL(c.name,'') as name from `" . $table . "` as a 
                                LEFT JOIN (SELECT cid,ticket_id FROM ticket) as t ON t.ticket_id=a.ticket_id 
                                LEFT JOIN (SELECT id,concat(firstname,' ',lastname) as name FROM coustomer) as c ON c.id=t.cid " . $cond, 1);
        } elseif ($input_status == 5) {

            $sqlchain_store_ids = $obj->SelectAllByID("store_chain_admin", array("sid" => $input_by));
            if (!empty($sqlchain_store_ids)) {

                if (!empty($cond)) {
                    foreach ($sqlchain_store_ids as $ch):
                        $inner_cond .= " OR a.input_by='" . $ch->store_id . "'";
                    endforeach;
                } else {
                    $inner_cond = ' WHERE (';
                    $i = 1;
                    foreach ($sqlchain_store_ids as $ch):
                        if ($i == 1) {
                            $inner_cond .= "a.input_by='" . $ch->store_id . "'";
                        } else {
                            $inner_cond .= " OR a.input_by='" . $ch->store_id . "'";
                        }
                        $i++;
                    endforeach;
                    $inner_cond .=')';
                }

                $migratecond = $cond . $inner_cond;

                if (isset($_GET['report_cid'])) {
                    if (!empty($migratecond)) {
                        $migratecond .=" AND t.cid='" . $_GET['report_cid'] . "'";
                    } else {
                        $migratecond .=" AND t.cid='" . $_GET['report_cid'] . "'";
                    }
                }

                $sql_coustomer = $obj->FlyQuery("select a.*,IFNULL(t.cid,0) as cid,IFNULL(c.name,'') as name from `" . $table . "` as a 
                                LEFT JOIN (SELECT cid,ticket_id FROM ticket) as t ON t.ticket_id=a.ticket_id 
                                LEFT JOIN (SELECT id,concat(firstname,' ',lastname) as name FROM coustomer) as c ON c.id=t.cid " . $migratecond . " ORDER BY a.id DESC LIMIT $start,$pagesize");

                $totalrows = $obj->FlyQuery("select a.*,IFNULL(t.cid,0) as cid,IFNULL(c.name,'') as name from `" . $table . "` as a 
                                LEFT JOIN (SELECT cid,ticket_id FROM ticket) as t ON t.ticket_id=a.ticket_id 
                                LEFT JOIN (SELECT id,concat(firstname,' ',lastname) as name FROM coustomer) as c ON c.id=t.cid " . $migratecond, 1);
                //echo "Work";
            } else {
                //echo "Not Work";
                $sql_coustomer = [];
                $totalrows = 0;
            }
        } else {
            if (!empty($cond)) {
                $newcond = " AND a.input_by='" . $input_by . "'";
            } else {
                $newcond = " WHERE a.input_by='" . $input_by . "'";
            }

            $migratecond = $cond . $newcond;
            
            if (isset($_GET['report_cid'])) {
                    if (!empty($migratecond)) {
                        $migratecond .=" AND t.cid='" . $_GET['report_cid'] . "'";
                    } else {
                        $migratecond .=" AND t.cid='" . $_GET['report_cid'] . "'";
                    }
                }
            
            $sql_coustomer = $obj->FlyQuery("select a.*,IFNULL(t.cid,0) as cid,IFNULL(c.name,'') as name from `" . $table . "` as a 
                                LEFT JOIN (SELECT cid,ticket_id FROM ticket) as t ON t.ticket_id=a.ticket_id 
                                LEFT JOIN (SELECT id,concat(firstname,' ',lastname) as name FROM coustomer) as c ON c.id=t.cid " . $migratecond . " ORDER BY a.id DESC LIMIT $start,$pagesize");

            
            
            $totalrows = $obj->FlyQuery("select a.*,IFNULL(t.cid,0) as cid,IFNULL(c.name,'') as name from `" . $table . "` as a 
                                LEFT JOIN (SELECT cid,ticket_id FROM ticket) as t ON t.ticket_id=a.ticket_id 
                                LEFT JOIN (SELECT id,concat(firstname,' ',lastname) as name FROM coustomer) as c ON c.id=t.cid " . $migratecond, 1);
        }


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
