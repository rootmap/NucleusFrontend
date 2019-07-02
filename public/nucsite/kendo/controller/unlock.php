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
        $cond = $plugin->BackEndDateSearch('from', 'to', 'date', 'ur.', ' WHERE ');
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
                            $inner_cond = "ur.uid='" . $ch->store_id . "'";
                        } else {
                            $inner_cond = " OR ur.uid='" . $ch->store_id . "'";
                        }
                        $i++;
                    endforeach;
                    $inner_cond .=')';
                } else {
                    $inner_cond = ' WHERE (';
                    $i = 1;
                    foreach ($sqlchain_store_ids as $ch):
                        if ($i == 1) {
                            $inner_cond = "ur.uid='" . $ch->store_id . "'";
                        } else {
                            $inner_cond = " OR ur.uid='" . $ch->store_id . "'";
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


         $sqlpar = "select ur.id,ur.cid,concat(cl.firstname,' ',cl.lastname) as fullname,
                    ur.unlock_id,us.name AS service,ur.our_cost,ur.retail_cost,ur.imei,
                    ur.carrier,ur.respond_email,ur.uid,ur.date,
                    concat(ur.service_id,':',us.name) as product_name,
                    p.id as pid,
                    i.invoice_id,
                    s.sales_id as sales_id

                    from unlock_request as ur
                    left join coustomer as cl on cl.id=ur.cid 
                    left join unlock_service as us on us.id=ur.service_id 
                    LEFT JOIN product as p ON p.store_id=ur.uid AND p.name=concat(ur.service_id,':',us.name)
                    LEFT JOIN invoice as i ON i.unlock_id=ur.unlock_id
                    LEFT JOIN sales as s ON s.sales_id=i.invoice_id
                    " . $migratecond . "
                    group by ur.unlock_id ORDER BY ur.id DESC";
         
         $countspr="select ur.id,ur.unlock_id,ur.cid,ur.uid,ur.date from unlock_request as ur " . $migratecond . "
                    group by ur.unlock_id ORDER BY ur.id DESC";
         
        $sqlparamgen = $plugin->KenduFilterParam($sqlpar, $confilter) . " LIMIT $start,$pagesize";
        $filter_result = $obj->FlyQuery($sqlparamgen);
        $total_in_filter = $obj->FlyQuery($plugin->KenduFilterParam($countspr, $confilter), "1");


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
        $cond = $plugin->BackEndDateSearch('from', 'to', 'date', 'ur.', 'WHERE ');


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
                            $inner_cond .= "ur.uid='" . $ch->store_id . "'";
                        } else {
                            $inner_cond .= " OR ur.uid='" . $ch->store_id . "'";
                        }
                        $i++;
                    endforeach;
                    $inner_cond .=')';
                } else {
                    $inner_cond = ' WHERE (';
                    $i = 1;
                    foreach ($sqlchain_store_ids as $ch):
                        if ($i == 1) {
                            $inner_cond .= "ur.uid='" . $ch->store_id . "'";
                        } else {
                            $inner_cond .= " OR ur.uid='" . $ch->store_id . "'";
                        }
                        $i++;
                    endforeach;
                    $inner_cond .=')';
                }

                $migratecond = $cond . $inner_cond;


                //echo "Work";
            } else {
                //echo "Not Work";
                $migratecond = " WHERE ur.id='0'";
            }
        } else {
            if (!empty($cond)) {
                $newcond = " AND ur.uid='" . $input_by . "'";
            } else {
                $newcond = " WHERE ur.uid='" . $input_by . "'";
            }

            $migratecond = $cond . $newcond;
        }


        $sql_coustomer = $obj->FlyQuery("select ur.id,ur.cid,concat(cl.firstname,' ',cl.lastname) as fullname,
                                        ur.unlock_id,us.name AS service,ur.our_cost,ur.retail_cost,ur.imei,
                                        ur.carrier,ur.respond_email,ur.uid,ur.date,
                                        concat(ur.service_id,':',us.name) as product_name,
                                        p.id as pid,
                                        i.invoice_id,
                                        s.sales_id as sales_id

                                        from unlock_request as ur
                                        left join coustomer as cl on cl.id=ur.cid 
                                        left join unlock_service as us on us.id=ur.service_id 
                                        LEFT JOIN product as p ON p.store_id=ur.uid AND p.name=concat(ur.service_id,':',us.name)
                                        LEFT JOIN invoice as i ON i.unlock_id=ur.unlock_id
                                        LEFT JOIN sales as s ON s.sales_id=i.invoice_id 
                                        " . $migratecond . "
                                        group by ur.unlock_id ORDER BY ur.id DESC LIMIT $start,$pagesize");
        
        
        $countspr="select ur.id,ur.unlock_id,ur.cid,ur.uid,ur.date from unlock_request as ur " . $migratecond . "
                    group by ur.unlock_id ORDER BY ur.id DESC";
        $totalrows = $obj->FlyQuery($countspr, 1);
        
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
