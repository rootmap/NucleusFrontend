<?php
set_time_limit(900000000000000000000000000);
ini_set('memory_limit', '-1');
include('../class/db_Class.php');
$obj = new db_class();

$sqlstore = $obj->FlyQuery("SELECT store_id FROM store WHERE status='2'");
//echo "<pre>";
//print_r($sqlstore);
//exit();

foreach ($sqlstore as $str):

    $sql_coustomer = $obj->FlyQuery("SELECT 
                    i.id, 
                    i.invoice_id, 
                    i.cid, 
                    CASE (SELECT ip.payment_type FROM invoice_payment as ip WHERE ip.invoice_id=i.invoice_id LIMIT 1)
                    WHEN 0 THEN 0 
                    ELSE (SELECT pm.meth_name FROM payment_method as pm WHERE pm.id=(SELECT ip.payment_type FROM invoice_payment as ip WHERE ip.invoice_id=i.invoice_id LIMIT 1) LIMIT 1)
                    END
                    as pty,
                    CASE (SELECT s.quantity FROM sales as s WHERE s.sales_id=i.invoice_id LIMIT 1) 
                    WHEN 0 THEN 0 
                    ELSE 
                    CASE (SELECT pt.status FROM pos_tax as pt WHERE pt.invoice_id=i.invoice_id LIMIT 1)  
                    WHEN 0 THEN 
                    (SELECT SUM(s.single_cost*s.quantity) FROM sales as s WHERE s.sales_id=i.invoice_id GROUP BY i.invoice_id) 
                    ELSE
                    (((((SELECT SUM(s.single_cost*s.quantity) FROM sales as s WHERE s.sales_id=i.invoice_id GROUP BY i.invoice_id)) * 1)/100)+((SELECT SUM(s.single_cost*s.quantity) FROM sales as s WHERE s.sales_id=i.invoice_id GROUP BY i.invoice_id)))
                    END
                    END
                    as sales_amount,
                    (SELECT SUM(s.quantity) FROM sales as s WHERE s.sales_id=i.invoice_id GROUP BY i.invoice_id) as quantity,
                    (SELECT SUM(amount) FROM invoice_payment as ip WHERE ip.invoice_id=i.invoice_id GROUP BY i.invoice_id) as paid_amount,
                    (SELECT concat(c.firstname,' ',c.lastname) FROM coustomer as c WHERE c.id=i.cid) as customer,
                    i.date, 
                    i.status, 
                    i.doc_type, 
                    i.input_by, 
                    i.payment_type
                    FROM invoice as i 
                    WHERE i.doc_type='3' AND i.input_by='".$str->store_id."' AND i.id NOT IN (SELECT sid FROM `sales_cron`) 
                     order by `i`.`id` DESC LIMIT 10");

    $sqlcheckin =$sql_coustomer;
    if (!empty($sqlcheckin)) {

        $i = 1;
        foreach ($sqlcheckin AS $checkin):

            $chkcheckinid = $obj->FlyQuery("SELECT `sid` FROM `sales_cron` WHERE `sid`='" . $checkin->id . "'", 1);
            if ($chkcheckinid == 0) {
                $obj->FlyPrepare("INSERT INTO `sales_cron` SET `sid`='" . $checkin->id . "',`invoice_id`='" . $checkin->invoice_id . "', `customer`='" . $checkin->customer . "', `tender`='" . $checkin->pty . "', `status`='" . $checkin->status . "', `date`='" . $checkin->date . "', `item`='" . $checkin->quantity . "', `input_by`='" . $checkin->input_by . "', `total`='" . $checkin->sales_amount . "'");
            } else {
                $obj->FlyPrepare("UPDATE `sales_cron` SET `invoice_id`='" . $checkin->invoice_id . "', `customer`='" . $checkin->customer . "', `tender`='" . $checkin->pty . "', `status`='" . $checkin->status . "', `date`='" . $checkin->date . "', `item`='" . $checkin->quantity . "', `input_by`='" . $checkin->input_by . "', `total`='" . $checkin->sales_amount . "' WHERE `sid`='" . $checkin->id . "'");
            }
            $i++;
        endforeach;
    }


endforeach;
?>
