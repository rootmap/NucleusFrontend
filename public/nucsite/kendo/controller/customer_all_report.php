<?php

include '../class/auth.php';
header("Content-type: application/json");
$verb = $_SERVER["REQUEST_METHOD"];
$table = "coustomer";
if ($verb == "GET") {

    $cond = " WHERE ";

    if ($input_status == 1) {
        $migratecond = $cond;
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

    if (isset($_GET['report_cid'])) {
        if (!empty($migratecond)) {
            $migratecond .=" AND customer.id='" . $_GET['report_cid'] . "'";
        } else {
            $migratecond .=" WHERE customer.id='" . $_GET['report_cid'] . "'";
        }
    }


    $sql_coustomer = $obj->FlyQuery("SELECT 
                                        customer.id,
                                        CONCAT(customer.firstname,' ',customer.lastname) AS full_name,
                                        customer.email,
                                        customer.phone,
                                        customer.city,
                                        customer.address1,
                                        (SELECT count(id) FROM invoice WHERE invoice.cid=customer.id) as total_invoice,
                                        (SELECT count(id) FROM invoice WHERE invoice.cid=customer.id AND invoice.status='2') as total_estimate,
                                        (SELECT count(id) FROM checkin_request_ticket WHERE checkin_request_ticket.cid=customer.id) as total_checkin_ticket,
                                        (select COUNT(parts_order.id) from checkin_request_ticket 
                                        INNER JOIN parts_order ON parts_order.ticket_id=checkin_request_ticket.checkin_id
                                        WHERE checkin_request_ticket.cid=customer.id) as total_parts_order FROM 
                                        `coustomer` as customer 
                                        ".$migratecond."
                                        order by `customer`.`id` DESC");



    $totalrows = $obj->FlyQuery("SELECT 
                                    customer.id,
                                    CONCAT(customer.firstname,' ',customer.lastname) AS full_name,
                                    customer.email,
                                    customer.phone,
                                    customer.city,
                                    customer.address1,
                                    (SELECT count(id) FROM invoice WHERE invoice.cid=customer.id) as total_invoice,
                                    (SELECT count(id) FROM invoice WHERE invoice.cid=customer.id AND invoice.status='2') as total_estimate,
                                    (SELECT count(id) FROM checkin_request_ticket WHERE checkin_request_ticket.cid=customer.id) as total_checkin_ticket,
                                    (select COUNT(parts_order.id) from checkin_request_ticket 
                                    INNER JOIN parts_order ON parts_order.ticket_id=checkin_request_ticket.checkin_id
                                    WHERE checkin_request_ticket.cid=customer.id) as total_parts_order FROM 
                                    `coustomer` as customer 

                                    ".$migratecond."    
                                    order by `customer`.`id` DESC", 1);

    $sqlCity = $sql_coustomer;
    //$totalrows = $obj->totalrows($table);
    echo "{\"data\":" . json_encode($sqlCity) . ",\"total\":" . $totalrows . "}";
    exit();
}
?>
