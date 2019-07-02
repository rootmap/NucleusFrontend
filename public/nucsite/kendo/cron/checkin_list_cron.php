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

    $sqlpars = "SELECT alldata.*,
                            IFNULL((SELECT SUM(amount) FROM invoice_payment WHERE invoice_id=alldata.invoice_id GROUP BY invoice_id),0) as paid
                            #alldata.invoice_id as inid 
                    FROM (select
                    r.id,
                    r.first_name,
                    r.phone,
                    r.checkin_id,
                    CONCAT(replace(c.`name`,' ',''),',',cv.`name`,',',cvc.`name`,',',cn.`name`) as `detail`,      
                    r.problem_id,
                    cp.`name` as problem,
                    (SELECT COUNT(*) FROM check_user_price as cup WHERE cup.ckeckin_id=r.checkin_id)  AS pricechk,
                    #define product cost by case
                    CASE (SELECT COUNT(*) FROM check_user_price as cup WHERE cup.ckeckin_id=r.checkin_id)
                            WHEN 0 THEN 

                                    CASE (SELECT price_cost FROM product WHERE name=concat(replace(c.`name`,' ',''),'-',cp.`name`))
                                            WHEN '' THEN 
                                             (SELECT name FROM checkin_price WHERE ";
    $sqlpars .="#only applicable if not admin ";


    $sqlpars .=" store_id='" . $str->store_id . "' AND ";


    $sqlpars .="#only applicable if not admin
                                             checkin_id=r.device_id AND 
                                             checkin_version_id=r.model_id AND 
                                             checkin_problem_id=r.problem_id ORDER BY id DESC LIMIT 1)
                                        ELSE 
                                             (SELECT price_cost FROM product WHERE name=concat(replace(c.`name`,' ',''),'-',cp.`name`))
                                    END

                        ELSE 
                            CASE (SELECT price FROM check_user_price as cup WHERE cup.ckeckin_id=r.checkin_id)
                                    WHEN '' THEN 
                                                    (SELECT name FROM checkin_price WHERE ";
    $sqlpars .="#only applicable if not admin ";


    $sqlpars .=" store_id='" . $str->store_id . "' AND ";


    $sqlpars .="#only applicable if not admin
                                             checkin_id=r.device_id AND 
                                             checkin_version_id=r.model_id AND 
                                             checkin_problem_id=r.problem_id ORDER BY id DESC LIMIT 1)
                                ELSE (SELECT price FROM check_user_price as cup WHERE cup.ckeckin_id=r.checkin_id)
                            END    
                    END AS checkin_price,    
                    #define product cost by case end

                    #get pid by concat device detail
                    IFNULL((SELECT id FROM product WHERE ";
    $sqlpars .="#if not admin ";


    $sqlpars .=" store_id='" . $str->store_id . "' AND ";

    $sqlpars .="#if not admin                    
                    name=concat(replace(c.`name`,' ',''),', ',cv.`name`,' - ',cp.`name`) ORDER BY id DESC LIMIT 1),(SELECT id FROM product WHERE ";
    $sqlpars .="#if not admin ";


    $sqlpars .=" store_id='" . $str->store_id . "' AND ";


    $sqlpars .="#if not admin  
                    name=concat(replace(c.`name`,' ',''),' , ',cv.`name`,' - ',cp.`name`) ORDER BY id DESC LIMIT 1)) AS pid,
                    #get pid by concat device detail END
                    IFNULL((SELECT id FROM coustomer as cus WHERE cus.firstname=r.first_name AND cus.phone=r.phone LIMIT 1),0) as cid,
                    #pc.invoice_id as invoice_id,
                    IFNULL((SELECT invoice_id FROM pos_checkin WHERE checkin_id=r.checkin_id LIMIT 1),0) as invoice_id,
                    #(SELECT count(id) FROM invoice WHERE invoice_id=IFNULL((SELECT invoice_id FROM pos_checkin WHERE checkin_id=r.checkin_id),0) LIMIT 1) AS invoice_status,
                    #ip.amount as paid,
                    #(SELECT SUM(amount) FROM invoice_payment WHERE invoice_id= GROUP BY invoice_id) as paid,
                    r.date,
                    r.input_by,
                    r.status from checkin_request as r
                    #INNER JOIN pos_checkin as pc on pc.checkin_id=r.checkin_id
                    #INNER JOIN (SELECT SUM(amount) as amount,invoice_id FROM invoice_payment GROUP BY invoice_id) as ip on ip.invoice_id=pc.invoice_id
                    INNER JOIN checkin as c ON c.id=r.device_id
                    INNER JOIN checkin_version as cv ON cv.id=r.model_id
                    INNER JOIN checkin_version_color as cvc ON cvc.id=r.color_id
                    INNER JOIN checkin_network as cn ON cn.id=r.network_id
                    INNER JOIN checkin_problem as cp ON cp.id=r.problem_id 
                    WHERE r.checkin_id IN (SELECT crt.checkin_id FROM checkin_request_ticket as crt) 
                    AND r.input_by='" . $str->store_id . "' 
                    ORDER BY id DESC) AS alldata";

    $sqlcheckin = $obj->FlyQuery($sqlpars);
    if (!empty($sqlcheckin)) {

        $i = 1;
        foreach ($sqlcheckin AS $checkin):

            $chkcheckinid = $obj->FlyQuery("SELECT `chid` FROM `checkin_cron` WHERE `chid`='" . $checkin->id . "'", 1);
            if ($chkcheckinid == 0) {
                $obj->FlyPrepare("INSERT INTO `checkin_cron` SET `chid`='" . $checkin->id . "',`checkin_id`='" . $checkin->checkin_id . "', `detail`='" . $checkin->detail . "', `problem`='" . $checkin->problem . "', `checkin_price`='" . $checkin->checkin_price . "', `paid`='" . $checkin->paid . "', `date`='" . $checkin->date . "', `input_by`='" . $checkin->input_by . "', `invoice_id`='" . $checkin->invoice_id . "', `pid`='" . $checkin->pid . "', `cid`='" . $checkin->cid . "'");
                //echo $i . "-" . $checkin->checkin_id . "-" . $checkin->input_by . "<br>";
            } else {
                $obj->FlyPrepare("UPDATE `checkin_cron` SET `checkin_id`='" . $checkin->checkin_id . "', `detail`='" . $checkin->detail . "', `problem`='" . $checkin->problem . "', `checkin_price`='" . $checkin->checkin_price . "', `paid`='" . $checkin->paid . "', `date`='" . $checkin->date . "', `input_by`='" . $checkin->input_by . "', `invoice_id`='" . $checkin->invoice_id . "', `pid`='" . $checkin->pid . "', `cid`='" . $checkin->cid . "' WHERE `chid`='" . $checkin->id . "'");
                 //echo $i."-".$checkin->checkin_id."<br>";
            }
            $i++;
        endforeach;
    }


endforeach;
?>
