<?php

include('class/db_Class.php');
$obj = new db_class();
include './email/mail_helper_functions.php';
$table = "reccurring_invoice";

$sql_product = $obj->FlyQuery("SELECT 
                                                    r.`id`, 
                                                    r.`cid`, 
                                                    IFNULL(CONCAT(c.firstname,' ',c.lastname),'Nucleuspos') as `customer_name`,
                                                    r.`frequency` as frequencyst,
                                                    CASE r.`frequency` 
                                                            WHEN 1 THEN 'Monthly'
                                                            ELSE CASE r.`frequency` WHEN 2 THEN 'Weekly' 
                                                            ELSE CASE r.`frequency` WHEN 3 THEN 'Biweekly' 
                                                            ELSE CASE r.`frequency` WHEN 4 THEN 'Quarterly' 
                                                            ELSE CASE r.`frequency` WHEN 5 THEN 'Semi-Annually' 
                                                            ELSE CASE r.`frequency` WHEN 6 THEN 'Annually' 
                                                            ELSE 'No Mention'
                                                            END END END END END 
                                                    END AS `frequency`, 
                                                    r.`sales_id`, 
                                                    r.`start_date`, 
                                                    r.`price`, 
                                                    r.`total_price`,
                                                    r.`email`, 
                                                    IFNULL(r.`cradit_card`,'Not Added') AS cradit_card, 
                                                    r.`notes`,
                                                    IFNULL(r.`input_by`,0) AS input_by,
                                                    r.`date`, 
                                                    CASE r.`status`
                                                            WHEN 1 THEN 'Active' 
                                                            ELSE CASE r.`status` WHEN 2 THEN 'Cancel'
                                                            ELSE CASE r.`status` WHEN 0 THEN 'Pause'
                                                            ELSE 'Not Mention' 
                                                    END END
                                                    END AS `status` 
                                                    FROM 
                                                    `reccurring_invoice` AS r 
                                                    LEFT JOIN coustomer as c ON c.id=r.cid
                                                    where `r`.`id` != '0' AND r.id NOT IN (SELECT rid FROM reccurring_invoice_cron)");

function NextDueDate($stdate, $st) {
    if ($st == 1) {
        return date('Y-m-d', strtotime('+1 month', strtotime($stdate)));
    } elseif ($st == 2) {
        return date('Y-m-d', strtotime('+1 week', strtotime($stdate)));
    } elseif ($st == 3) {
        return date('Y-m-d', strtotime('+4 day', strtotime($stdate)));
    } elseif ($st == 4) {
        return date('Y-m-d', strtotime('+3 month', strtotime($stdate)));
    } elseif ($st == 5) {
        return date('Y-m-d', strtotime('+6 month', strtotime($stdate)));
    } elseif ($st == 6) {
        return date('Y-m-d', strtotime('+1 year', strtotime($stdate)));
    } else {
        return "0000-00-00";
    }
}

function NextDueDateEmailDate($stdate, $st) {
    if ($st == 1) {
        return date('Y-m-d', strtotime('-1 week', strtotime($stdate)));
    } elseif ($st == 2) {
        return date('Y-m-d', strtotime('-4 day', strtotime($stdate)));
    } elseif ($st == 3) {
        return date('Y-m-d', strtotime('-2 day', strtotime($stdate)));
    } elseif ($st == 4) {
        return date('Y-m-d', strtotime('-1 week', strtotime($stdate)));
    } elseif ($st == 5) {
        return date('Y-m-d', strtotime('-2 week', strtotime($stdate)));
    } elseif ($st == 6) {
        return date('Y-m-d', strtotime('-3 week', strtotime($stdate)));
    } else {
        return "0000-00-00";
    }
}

if (!empty($sql_product)) {
    foreach ($sql_product as $product):
        //echo NextDueDate($product->start_date, $product->frequencyst)."-".date('Y-m-d')."<br>";
        $duedate = NextDueDate($product->start_date, $product->frequencyst);
        //NextDueDateEmailDate($duedate, $product->frequencyst)."<br>";
        if (NextDueDateEmailDate($duedate, $product->frequencyst) == date('Y-m-d')) {
            // echo NextDueDateEmailDate($duedate, $product->frequencyst);
            $EmailSubject = "Nucleuspos Upcoming Due Bill Reminder";
            $EmailBody = file_get_contents($obj->baseUrl('email/email/body/reccuring_bill_reminder.php?date=' . $duedate . '&bill=' . $product->total_price));
            //echo sendEmailFunctionReccurring($product->email, $product->customer_name, 'support@nucleuspos.com', $EmailSubject, $EmailBody);
            
            $sendMailStatus=sendEmailFunctionReccurring($product->email, $product->customer_name, 'support@nucleuspos.com', $EmailSubject, $EmailBody);
            if ($sendMailStatus == true) {
                //echo "---1-------------------";
                echo $obj->insert("reccurring_invoice_cron", array("rid" => $product->id,"customer_name"=>$product->customer_name,"email" =>$product->email, "date" => date('Y-m-d'), "status" => 1));
            } else {
                echo "Failed To Send Mail";
            }
        }
    endforeach;
}
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    