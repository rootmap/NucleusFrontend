<?php

include '../class/auth.php';
header("Content-type: application/json");
$verb = $_SERVER["REQUEST_METHOD"];
$table = "coustomer";
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

        $cond = $plugin->BackEndDateSearch('from', 'to', 'date', 'customer.', ' WHERE ');
        
        if(empty($cond))
        {
            if($input_status!=1)
            {
            $cond="WHERE ";
            }
        }
        
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
                
                    $inner_cond = ' (';
                    $i = 1;
                    foreach ($sqlchain_store_ids as $ch):
                        if ($i == 1) {
                            $inner_cond = "`customer`.`input_by`='" . $ch->store_id . "'";
                        } else {
                            $inner_cond = " OR `customer`.`input_by`='" . $ch->store_id . "'";
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
                    customer.id,
                    CONCAT(customer.firstname,' ',customer.lastname) AS full_name,
                    (SELECT count(id) FROM invoice WHERE invoice.cid=customer.id) as total_invoice,
                    (SELECT count(id) FROM invoice WHERE invoice.cid=customer.id AND invoice.status='2') as total_estimate,
                    (SELECT count(id) FROM checkin_request_ticket WHERE checkin_request_ticket.cid=customer.id) as total_checkin_ticket,
                    (select COUNT(parts_order.id) from checkin_request_ticket 
                    INNER JOIN parts_order ON parts_order.ticket_id=checkin_request_ticket.checkin_id
                    WHERE checkin_request_ticket.cid=customer.id) as total_parts_order FROM 
                    `coustomer` as customer 
                    " . $migratecond . "
                    # WHERE id='41882'     
                    order by `customer`.`id` DESC LIMIT $start,$pagesize";

        
          $sqlpars = "SELECT 
                    customer.id,
                    CONCAT(customer.firstname,' ',customer.lastname) AS full_name,
                    (SELECT count(id) FROM invoice WHERE invoice.cid=customer.id) as total_invoice,
                    (SELECT count(id) FROM invoice WHERE invoice.cid=customer.id AND invoice.status='2') as total_estimate,
                    (SELECT count(id) FROM checkin_request_ticket WHERE checkin_request_ticket.cid=customer.id) as total_checkin_ticket,
                    (select COUNT(parts_order.id) from checkin_request_ticket 
                    INNER JOIN parts_order ON parts_order.ticket_id=checkin_request_ticket.checkin_id
                    WHERE checkin_request_ticket.cid=customer.id) as total_parts_order FROM 
                    `coustomer` as customer 
                    " . $migratecond . "
                    # WHERE id='41882'     
                    order by `customer`.`id` DESC";
         
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
        $cond = $plugin->BackEndDateSearch('from', 'to', 'date', 'customer.', ' WHERE ');

        if(empty($cond))
        {
            if($input_status!=1)
            {
            $cond="WHERE ";
            }
        }

        if ($input_status == 1) {
            $migratecond =$cond;
        } elseif ($input_status == 5) {

            $sqlchain_store_ids = $obj->SelectAllByID("store_chain_admin", array("sid" => $input_by));
            if (!empty($sqlchain_store_ids)) {

                    $inner_cond = ' (';
                    $i = 1;
                    foreach ($sqlchain_store_ids as $ch):
                        if ($i == 1) {
                            $inner_cond .= "`customer`.`input_by`='" . $ch->store_id . "'";
                        } else {
                            $inner_cond .= " OR `customer`.`input_by`='" . $ch->store_id . "'";
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
            
            $newcond = "  `customer`.`input_by`='" . $input_by . "'";
            $migratecond = $cond . $newcond;
            
        }


       $sql_coustomer = $obj->FlyQuery("SELECT 
                    customer.id,
                    CONCAT(customer.firstname,' ',customer.lastname) AS full_name,
                    (SELECT count(id) FROM invoice WHERE invoice.cid=customer.id) as total_invoice,
                    (SELECT count(id) FROM invoice WHERE invoice.cid=customer.id AND invoice.status='2') as total_estimate,
                    (SELECT count(id) FROM checkin_request_ticket WHERE checkin_request_ticket.cid=customer.id) as total_checkin_ticket,
                    (select COUNT(parts_order.id) from checkin_request_ticket 
                    INNER JOIN parts_order ON parts_order.ticket_id=checkin_request_ticket.checkin_id
                    WHERE checkin_request_ticket.cid=customer.id) as total_parts_order FROM 
                    `coustomer` as customer 
                    " . $migratecond . "
                    # WHERE id='41882'     
                    order by `customer`.`id` DESC LIMIT $start,$pagesize");
        
  
                                        
        $totalrows = $obj->FlyQuery("SELECT 
                    customer.id,
                    CONCAT(customer.firstname,' ',customer.lastname) AS full_name,
                    (SELECT count(id) FROM invoice WHERE invoice.cid=customer.id) as total_invoice,
                    (SELECT count(id) FROM invoice WHERE invoice.cid=customer.id AND invoice.status='2') as total_estimate,
                    (SELECT count(id) FROM checkin_request_ticket WHERE checkin_request_ticket.cid=customer.id) as total_checkin_ticket,
                    (select COUNT(parts_order.id) from checkin_request_ticket 
                    INNER JOIN parts_order ON parts_order.ticket_id=checkin_request_ticket.checkin_id
                    WHERE checkin_request_ticket.cid=customer.id) as total_parts_order FROM 
                    `coustomer` as customer 
                    " . $migratecond . "
                    # WHERE id='41882'     
                    order by `customer`.`id` DESC", 1);
        
        $sqlCity = $sql_coustomer;
        //$totalrows = $obj->totalrows($table);
        echo "{\"data\":" . json_encode($sqlCity) . ",\"total\":" . $totalrows . "}";
        exit();
    }
}


if ($verb == "POST") {
    if (isset($_GET['input_by'])) {
        if ($input_status == 2) {
            $id = $_POST['id'];
            if ($obj->delete($table, array("input_by" => $id)) == 1) {
                echo true;
            } else {
                echo 0;
            }
        }
    } else {
        $id = $_POST['id'];
        if ($obj->delete($table, array("id" => $id)) == 1) {
            echo true;
        } else {
            echo 0;
        }
    }


    exit();
}
?>
