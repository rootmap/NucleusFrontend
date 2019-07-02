<?php

if ($cashier_id == 1) {

    $printopt = $_POST['printopt'];

    if (empty($_POST['pam']) || $_POST['pam'] == 0) {
        $obj->Error("Your Payment is Empty Please Check Your Paid Amount.", "pos_redirect.php");
    } else {
        if ($_POST['customername'] == 6) {

            $totam_paid = $_POST['pam'] + $_POST['pamc'];

            $checkinid = $obj->SelectAllByVal("pos_checkin", "invoice_id", $_SESSION['SESS_CART'], "checkin_id");
            if (!empty($checkinid)) {
                $obj->update("checkin_cron", array("checkin_id" => $checkinid, "paid" => $totam_paid, "invoice_id" => $_SESSION['SESS_CART']));
            }

            if ($_POST['totam'] == $totam_paid) {
                $sales_status = 1;
            } elseif ($_POST['totam'] <= $totam_paid) {
                $sales_status = 1;
            } else {
                $sales_status = 3;
            }
            $obj->insert("transaction_log", array("transaction" => $_POST['sidd'], "sid" => $input_by, "date" => date('Y-m-d'),
                "time" => date('H:i:s'), "cashier_id" => $cashiers_id, "customer_id" => $_POST['cid'],
                "amount" => $_POST['pam'], "type" => 1, "tender" => $_POST['customername'],
                "input_by" => $input_by, "sales_track" => 3, "datetime" => date('Y-m-d H:i:s'), "access_id" => $access_id, "status" => 1));

            $obj->insert("transaction_log", array("transaction" => $_POST['sidd'], "sid" => $input_by, "date" => date('Y-m-d'),
                "time" => date('H:i:s'), "cashier_id" => $cashiers_id, "customer_id" => $_POST['cid'],
                "amount" => $_POST['pamc'], "type" => 1, "tender" => $_POST['customername'],
                "input_by" => $input_by, "sales_track" => 4, "datetime" => date('Y-m-d H:i:s'), "access_id" => $access_id, "status" => 1));

            if ($obj->insert($table4, array("invoice_id" => $_POST['sidd'], "payment_type" => $_POST['customername'], "cid" => $_POST['cid'], "invoice_creator" => $input_by, "input_by" => $input_by, "access_id" => $access_id, "amount" => $_POST['pam'], "date" => date('Y-m-d'), "datetime" => date('Y-m-d h:i'), "time" => time(), "status" => 1)) == 1) {

                $obj->insert($table4, array("invoice_id" => $_POST['sidd'], "payment_type" => $_POST['customername'], "cid" => $_POST['cid'], "invoice_creator" => $input_by, "input_by" => $input_by, "access_id" => $access_id, "amount" => $_POST['pamc'], "date" => date('Y-m-d'), "datetime" => date('Y-m-d h:i'), "time" => time(), "status" => 1));

                $obj->update("sales", array("sales_id" => $_POST['sidd'], "payment_method" => $_POST['customername'], "datetime" => date('Y-m-d H:i'), "access_id" => $access_id, "input_by" => $input_by));
                $obj->update($table3, array("invoice_id" => $_SESSION['SESS_CART'], "invoice_creator" => $input_by, "invoice_date" => date('d-m-Y'), "date" => date('Y-m-d'), "status" => $sales_status, "access_id" => $access_id, "input_by" => $input_by));

                
                /* sales cron excutive */
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
                    WHERE i.doc_type='3' AND i.invoice_id='".$_SESSION['SESS_CART']."'
                     order by `i`.`id` DESC");
                $sqlcheckin = $sql_coustomer;
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
                /* sales cron excute end */

                //$obj->Success("Payment Recored Saved",$obj->filename()); save payment and exit sales
                $obj->newcart(@$_SESSION['SESS_CART']);
                $obj->insert($table3, array("invoice_id" => $_SESSION['SESS_CART'], "invoice_creator" => $input_by, "invoice_date" => date('d-m-Y'), "date" => date('Y-m-d'), "status" => 1, "checkin_id" => $_GET['checkin_id'], "doc_type" => 3, "access_id" => $access_id, "input_by" => $input_by));
                $obj->Success("Payment Record Saved", "pos.php?action=pdf&invoice=" . $_POST['sidd'] . "&print=" . $printopt);

                //save payment and exit sales	
            } else {
                $obj->Error("Payment Recored Failed to Save", "pos.php");
            }
        } else {

            $totam_paid = $_POST['pam'];
            
            $checkinid=$obj->SelectAllByVal("pos_checkin", "invoice_id", $_SESSION['SESS_CART'], "checkin_id");
            if (!empty($checkinid)) {
                $obj->update("checkin_cron", array("checkin_id" =>$checkinid,"paid" => $totam_paid,"invoice_id" =>$_SESSION['SESS_CART']));
            }
            
            if ($_POST['totam'] == $totam_paid) {
                $sales_status = 1;
            } elseif ($_POST['totam'] <= $totam_paid) {
                $sales_status = 1;
            } else {
                $sales_status = 3;
            }
            $obj->insert("transaction_log", array("transaction" => $_POST['sidd'], "sid" => $input_by, "date" => date('Y-m-d'),
                "time" => date('H:i:s'), "cashier_id" => $cashiers_id, "customer_id" => $_POST['cid'],
                "amount" => $_POST['pam'], "type" => 1, "tender" => $_POST['customername'],
                "input_by" => $input_by, "access_id" => $access_id, "status" => 1));

            if ($obj->insert($table4, array("invoice_id" => $_POST['sidd'], "payment_type" => $_POST['customername'], "cid" => $_POST['cid'], "invoice_creator" => $input_by, "input_by" => $input_by, "access_id" => $access_id, "amount" => $_POST['pam'], "date" => date('Y-m-d'), "datetime" => date('Y-m-d h:i'), "status" => 1)) == 1) {
                $obj->update("sales", array("sales_id" => $_POST['sidd'], "payment_method" => $_POST['customername'], "datetime" => date('Y-m-d H:i'), "access_id" => $access_id, "input_by" => $input_by));
                $obj->update($table3, array("invoice_id" => $_SESSION['SESS_CART'], "invoice_creator" => $input_by, "invoice_date" => date('d-m-Y'), "date" => date('Y-m-d'), "status" => $sales_status, "access_id" => $access_id, "input_by" => $input_by));

                /* sales cron excutive */
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
                    WHERE i.doc_type='3' AND i.invoice_id='".$_SESSION['SESS_CART']."'
                     order by `i`.`id` DESC");
                $sqlcheckin = $sql_coustomer;
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
                /* sales cron excute end */
                
                //$obj->Success("Payment Recored Saved",$obj->filename()); save payment and exit sales
                $obj->newcart(@$_SESSION['SESS_CART']);
                $obj->insert($table3, array("invoice_id" => $_SESSION['SESS_CART'], "invoice_creator" => $input_by, "invoice_date" => date('d-m-Y'), "date" => date('Y-m-d'), "status" => 1, "checkin_id" => $_POST['checkin_id'], "doc_type" => 3, "access_id" => $access_id, "input_by" => $input_by));
                $obj->Success("Payment Record Saved", "pos.php?action=pdf&invoice=" . $_POST['sidd'] . "&print=" . $printopt);

                //save payment and exit sales	
            } else {
                $obj->Error("Payment Recored Failed to Save", "pos.php");
            }
        }
    }
} else {
    $obj->Error("Cashier Not Looged In, Please Login First. ", "pos.php");
}
?>