<?php
include('class/auth.php');
include('class/index.php');
$index = new index();
if (isset($_GET['del'])) {
    $obj->deletesing("id", $_GET['del'], "checkin_request");
}

function checkin_status($st) {
    if ($st == 1) {
        return "Completed";
    } else {
        return "Not Completed";
    }
}

function checkin_paid($st) {
    if ($st == 0) {
        return "<label class='label label-danger'>Not Paid</label>";
    } elseif ($st == 33) {
        return "<label class='label label-warning'>Partial</label>";
    } else {
        return "<label class='label label-success'>Paid</label>";
    }
}

function checkin_paid2($st) {
    if ($st == 0) {
        return "UNPAID";
    } else {
        return "Paid";
    }
}

if (isset($_GET['actionthermal'])) {

    $cart = $_GET['invoice'];
    //$cid = $obj->SelectAllByVal("ticket", "ticket_id", $cart, "cid");

    $sqlgetgi = $obj->FlyQuery("SELECT
    a.id,
    a.checkin_id,
    a.input_by,
    a.access_id,
    sto.name as sales_rep,
    a.first_name,
    a.last_name,
    a.phone as customer_phone,
    IFNULL(i.payment_type,0) as payment_type,
    IFNULL(s.status,0) as `status`,
    r.name,
    r.address,
    r.phone,
    r.email,
    r.fotter,
    t.imei as t_imei,
    t.carrier as t_carrier,
    t.type_color as t_type_color,
    t.problem_type as t_problem_type,
    cn.name as network,
    cvc.name as color,
    pt.name as problem,
    crt.imei,
    a.date
    FROM `checkin_request` as a
    LEFT JOIN (SELECT payment_type,invoice_id FROM invoice) as i ON i.invoice_id=a.checkin_id
    LEFT JOIN (SELECT store_id,`status` FROM tax_status) as s ON s.store_id=a.input_by
    LEFT JOIN (SELECT store_id,name,address,phone,email,fotter FROM setting_report) as r on r.store_id=a.input_by
    LEFT JOIN (SELECT id,name FROM store) as sto on sto.id=a.access_id
    LEFT JOIN (SELECT ticket_id,imei,carrier,type_color,problem_type FROM ticket) as t ON t.ticket_id=a.checkin_id
    LEFT JOIN (SELECT id,name FROM problem_type) as tp ON tp.id=t.problem_type
    LEFT JOIN (SELECT id,name FROM checkin_network) as cn ON cn.id=a.network_id
    LEFT JOIN (SELECT id,name FROM checkin_version_color) as cvc ON cvc.id=a.color_id
    LEFT JOIN (SELECT id,name FROM problem_type) as pt ON pt.id=a.problem_id
    LEFT JOIN (SELECT checkin_id,imei FROM checkin_request_ticket) as crt ON crt.checkin_id=a.checkin_id
    WHERE a.checkin_id='" . $cart . "'");

    $creator = $sqlgetgi[0]->input_by;

    $pt = $sqlgetgi[0]->payment_type;
    $ckid = $sqlgetgi[0]->checkin_id;
    $tax_statuss = $sqlgetgi[0]->status;
    if ($tax_statuss == 0) {
        $taxs = 0;
    } else {
        if ($sqlgetgi[0]->tax == '') {
            $taxs = 0;
        } else {
            $taxs = $sqlgetgi[0]->tax;
        }
    }



    $html = '';

    $html.="<table>
           <tbody>";

    $report_cpmpany_name = $sqlgetgi[0]->name;
    $report_cpmpany_address = $sqlgetgi[0]->address;
    $report_cpmpany_phone = $sqlgetgi[0]->phone;
    $report_cpmpany_email = $sqlgetgi[0]->email;
    $report_cpmpany_fotter = $sqlgetgi[0]->fotter;

    function limit_words($string, $word_limit) {
        $words = explode(" ", $string);
        return implode(" ", array_splice($words, 0, $word_limit));
    }

    $addressfline = limit_words($report_cpmpany_address, 3);
    $lengthaddress = strlen($addressfline);
    $lastaddress = substr($report_cpmpany_address, $lengthaddress, 30000);

    if ($_GET['payment_status'] == "Paid" || $_GET['payment_status'] == " Paid") {
        $font_size_pdf = "16";
    } else {
        $font_size_pdf = "20";
    }

    $html .="<tr><td style='color:rgba(0,51,153,1); text-align:center; font-size:" . $font_size_pdf . "px;'>
                        <h2>" . $report_cpmpany_name . "</h2><br>
						" . $addressfline . "<br>
						" . $lastaddress . "
			</td>
            </tr>
            <tr><td style='text-align:center; font-size:" . $font_size_pdf . "px;'>
                    CONTACT : " . $report_cpmpany_phone . ", EMAIL : " . $report_cpmpany_email . "
                </td>
            </tr>
            <tr><td style='text-align:left;'>
                <hr style='margin-top:0px;'>
                    
                    <table align='center' style='margin-top:-15px; margin-bottom:-15px; font-size:" . $font_size_pdf . "px; font-weight:bolder;'>
                        <tr>
                            <td>Name</td>
                            <td>:</td>
                            <td>" . $sqlgetgi[0]->first_name . "</td>
                        </tr>
                        <tr>
                            <td>ORDER NO</td>
                            <td> : </td>
                            <td>" . $cart . "</td>
                            
                        </tr>
                        <tr>
                            <td>Phone</td>
                            <td>:</td>
                            <td>" . $sqlgetgi[0]->customer_phone . "</td>
                        </tr>
                        <tr>
                            <td>Date & Time</td>
                            <td> : </td>
                            <td>" . date('Y-m-d h:i', $cart) . " </td>
                            
                        </tr>
                        <tr>
                            <td>Sales Tax</td>
                            <td>:</td>
                            <td>" . $taxs . "%</td>
                        </tr>
                        <tr>        
                            <td>SALES REP</td>
                            <td> : </td>
                            <td>" . $sqlgetgi[0]->sales_rep . "</td>
                            
                        </tr>
                    </table>
                    <hr>
                    <table style='width:100%; margin-top:-18px; font-size:" . $font_size_pdf . "px; margin-bottom:-15px;' align='center'>
                        <tr>
                            <td align='center'>
                            Phone Repair Center <br />
                            We Repair | We Buy | We Sell
                            </td>
                        <tr>
                    </table>
                    <hr>
                </td>
            </tr>";

    $html .="<tr>
            <td valign='top' style='margin:0; padding:0; width:100%;'>
            <table class='table table-bordered' cellpadding='1' cellspacing='1'  style='width:100%; font-size:" . $font_size_pdf . "px;'>";
    $html.="<tbody>";

    //$sqlsaleslist = $obj->SelectAllByID("checkin_list", array("checkin_id" => $cart));
    $saleslist = $obj->FlyQuery("SELECT alldata.*,
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
          (SELECT name FROM checkin_price WHERE 
            store_id=r.input_by AND 
           #only applicable if not admin
           checkin_id=r.device_id AND 
           checkin_version_id=r.model_id AND 
           checkin_problem_id=r.problem_id ORDER BY id DESC LIMIT 1)
           ELSE 
           (SELECT price_cost FROM product WHERE name=concat(replace(c.`name`,' ',''),'-',cp.`name`))
           END

           ELSE 
           CASE (SELECT price FROM check_user_price as cup WHERE cup.ckeckin_id=r.checkin_id)
           WHEN '' THEN 
           (SELECT name FROM checkin_price WHERE 
           store_id=r.input_by AND 
           #only applicable if not admin
           checkin_id=r.device_id AND 
           checkin_version_id=r.model_id AND 
           checkin_problem_id=r.problem_id ORDER BY id DESC LIMIT 1)
           ELSE (SELECT price FROM check_user_price as cup WHERE cup.ckeckin_id=r.checkin_id)
           END    
           END AS checkin_price,    
           #define product cost by case end

           #get pid by concat device detail
           IFNULL((SELECT id FROM product WHERE 
            store_id=r.input_by AND 
           #if not admin                    
           name=concat(replace(c.`name`,' ',''),', ',cv.`name`,' - ',cp.`name`) ORDER BY id DESC LIMIT 1),(SELECT id FROM product WHERE 
          #if not admin 

            store_id=r.input_by AND 
           #if not admin  
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
           WHERE r.checkin_id='" . $cart . "'
           ORDER BY id DESC) AS alldata");


    $sss = 1;
    $subtotal = 0;
    $curcheck = 0;
    $tax = 0;
    $total = 0;
    $total = 0;
    $sales_invoice = 0;
//    if (!empty($saleslist))
//        foreach ($saleslist as $saleslist):
    $caltax = ($saleslist[0]->checkin_price * $tax_per_product) / 100;
    $procost = 1 * $saleslist[0]->checkin_price;
    $subtotal+=$procost;
    $html.="<tr><td colspan='2'>Ticket Detail</td></tr><tr><td colspan='2'>" . $saleslist->problem . " - " . $saleslist->detail . "</td></tr>";



//            $chkx = $obj->exists_multiple("check_user_price", array("ckeckin_id" => $saleslist->checkin_id));
//            if ($chkx == 0) {
//                $estp = $obj->SelectAllByVal("product", "name", $saleslist->device . "-" . $saleslist->problem, "price_cost");
//                if ($estp == '') {
//                    $devid = $obj->SelectAllByVal("checkin_request", "checkin_id", $saleslist->checkin_id, "device_id");
//                    $modid = $obj->SelectAllByVal("checkin_request", "checkin_id", $saleslist->checkin_id, "model_id");
//                    $probid = $obj->SelectAllByVal("checkin_request", "checkin_id", $saleslist->checkin_id, "problem_id");
//
//                    if ($input_status == 1) {
//                        $pp = $obj->SelectAllByVal3("checkin_price", "checkin_id", $devid, "checkin_version_id", $modid, "checkin_problem_id", $probid, "name");
//                    } else {
//                        $pp = $obj->SelectAllByVal4("checkin_price", "checkin_id", $devid, "checkin_version_id", $modid, "checkin_problem_id", $probid, "store_id", $input_by, "name");
//                    }
//                } else {
//                    $pp = $estp;
//                }
//            } else {
//
//                $estp = $obj->SelectAllByVal("check_user_price", "ckeckin_id", $saleslist->checkin_id, "price");
//                if ($estp == '') {
//                    $devid = $obj->SelectAllByVal("checkin_request", "checkin_id", $saleslist->checkin_id, "device_id");
//                    $modid = $obj->SelectAllByVal("checkin_request", "checkin_id", $saleslist->checkin_id, "model_id");
//                    $probid = $obj->SelectAllByVal("checkin_request", "checkin_id", $saleslist->checkin_id, "problem_id");
//
//                    if ($input_status == 1) {
//                        $pp = $obj->SelectAllByVal3("checkin_price", "checkin_id", $devid, "checkin_version_id", $modid, "checkin_problem_id", $probid, "name");
//                    } else {
//                        $pp = $obj->SelectAllByVal4("checkin_price", "checkin_id", $devid, "checkin_version_id", $modid, "checkin_problem_id", $probid, "store_id", $input_by, "name");
//                    }
//                } else {
//                    $pp = $estp;
//                }
//            }
    $pid = $saleslist[0]->pid;
    $cid = $saleslist[0]->cid;
    $chkcheckin = $sqlsaleslist[0]->invoice_id;
    $getsales_id = $sqlsaleslist[0]->invoice_id;
    if (!empty($chkcheckin)) {
        $curcheck+=1;
    } else {
        $curcheck+=0;
    }


    $sales_invoice = $getsales_id;


    $price = $saleslist[0]->checkin_price;


    //$subtotal+=$price;

    $caltaxs = ($price * $taxs) / 100;
    $extended = $price + $caltaxs;
    $tax+=$caltaxs;
    $total+=$extended;

    $html.="<tr><td>Quantity</td><td align='center'>1</td></tr>
            <tr><td>Unit Cost</td><td align='center'>$" . $price . "</td></tr>
            <tr><td>Tax</td><td align='center'>$" . $caltaxs . "</td></tr>
            <tr><td>Extended</td><td align='center'>$" . $extended . "</td></tr>";

    $sss++;
//        endforeach;
//echo $html;
//exit();
    $html.="</tbody></table></td></tr>";
    $ckid = $cart;
    if ($ckid != 0) {

        $html.="<tr><td>";
        if ($obj->exists_multiple("checkin_request_ticket", array("checkin_id" => $ckid)) == 0) {
            $html.="<table class='table table-bordered' cellpadding='1' cellspacing='1'   style=' width:100%; margin-left:-4px; width:100%; font-size:" . $font_size_pdf . "px;'>
            <tbody>
            <tr>
            <td>IMEI No: </td>
            <td>" . $sqlgetgi[0]->t_imei . "</td>
            </tr>
            <tr>
            <td>Carrier : </td>
            <td>" . $sqlgetgi[0]->t_carrier . "</td>
            </tr>
            <tr>
            <td>Color : </td>
            <td>" . $sqlgetgi[0]->t_type_color . " </td>
            </tr>
            <tr>
            <td>Problem : </td>
            <td>" . $sqlgetgi[0]->t_problem_type . " </td>
            </tr>
            </tbody>
            </table>";
        } else {
            $html.="<table class='table table-bordered' cellpadding='1' cellspacing='1'  style=' width:100%; border:1px; margin-left:-4px; font-size:" . $font_size_pdf . "px;'>
                    <tbody>
                    <tr>
                    <td>IMEI No: </td>
                    <td>" . $sqlgetgi[0]->imei . " </td>
                    </tr>
                    <tr>
                    <td>Carrier: </td>
                    <td>" . $sqlgetgi[0]->network . " </td>
                    </tr>
                    <tr>
                    <td>Color: </td>
                    <td>" . $sqlgetgi[0]->color . " </td>
                    </tr>
                    <tr>
                    <td>Problem: </td>
                    <td>" . $sqlgetgi[0]->problem . " </td>
                    </tr>
                    </tbody>
                    </table>";
        }

        $chk_invoice_status = $obj->exists_multiple("invoice ", array("invoice_id" => $sales_invoice, "status" => 3));
        $html.="<table class='table table-bordered' cellpadding='1' cellspacing='1'  style='border:1px; width:100%;  font-size:" . $font_size_pdf . "px;'>
                    <tbody>
                    <tr>
                    <td>Payment : </td>
                    <td>" . checkin_paid($curcheck) . "</td>
                    </tr>
                    <tr>
                    <td>Sub - Total: </td>
                    <td>$" . number_format($subtotal, 2) . "</td>
                    </tr>
                    <tr>
                    <td>Tax: </td>
                    <td>$" . number_format($tax, 2) . "</td>
                    </tr>
                    <tr>
                    <td>Total: </td>
                    <td>$" . number_format($total, 2) . "</td>
                    </tr>";

        $expaid = $saleslist[0]->paid;
        if (!empty($expaid)) {
//            $sqlexpaid = $obj->SelectAllByID_Multiple("invoice_payment", array("invoice_id" => $sales_invoice));
//            $expaid = 0;
//            if (!empty($sqlexpaid))
//                foreach ($sqlexpaid as $pd):
//                    $expaid+=$pd->amount;
//                endforeach;
            $exdue = $total - $expaid;
            $html.="<tr>
                    <td>Payments: </td>
                    <td>$";
            if (empty($expaid)) {
                $html.="0";
            } else {
                $html.=number_format($expaid, 2);
            }
            $html.="</td>
                    </tr>
                    <tr>
                    <td>Balance Due: </td>
                    <td>$";

            if ($exdue > 0) {
                if (empty($expaid)) {
                    $html.=$exdue;
                } else {
                    $html.=$exdue;
                }
            } else {
                $html.="0";
            }
        } else {
            $html.="<tr>
                    <td>Payments: </td>
                    <td>$";
            if (empty($expaid)) {
                $html.="0";
            } else {
                $html.=$total;
            }
            $html.="</td>
                    </tr>
                    <tr>
                    <td>Balance Due: </td>
                    <td>$";
            if ($exdue > 0) {
                if (empty($expaid)) {
                    $html.=$total;
                } else {
                    $html.="0";
                }
            } else {
                $html.="0";
            }
        }

        $html.="</td>
                    </tr>
                    </tbody>
                    </table>
                    ";
    } else {

        $html.="<table class='table table-bordered' cellpadding='1' cellspacing='1' style='border:1px; width:100%;  font-size:" . $font_size_pdf . "px;'><tbody>
                    <tr>
                    <td>Payment Type: </td>
                    <td>" . checkin_paid($curcheck) . "</td>
                    </tr>
                    <tr>
                    <td>Sub - Total: </td>
                    <td>$" . number_format($subtotal, 2) . "</td>
                    </tr>
                    <tr>
                    <td>Tax: </td>
                    <td>$" . number_format($tax, 2) . "</td>
                    </tr>
                    <tr>
                    <td>Total: </td>
                    <td>$" . number_format($total, 2) . "</td>
                    </tr>
                    <tr>
                    <td>Payments: </td>
                    <td>$";
        if (empty($expaid)) {
            $html.="0";
        } else {
            $html.=$total;
        }
        $html.="</td>
                    </tr>
                    <tr>
                    <td>Balance Due: </td>
                    <td>$";
        if ($exdue > 0) {
            if (empty($expaid)) {
                $html.=$total;
            } else {
                $html.="0";
            }
        } else {
            $html.="0";
        }
        $html.="</td>
                    </tr>
                    </tbody></table>";
    }




    $html.="</td></tr><tr>
                    <td align='center' style='font-size:8px;'>" . $report_cpmpany_fotter . "</td>
                    </tr>
                    <tr>
                    <td align='center'>Thank You For Your Business</td>
                    </tr>";
    if ($_GET['payment_status'] == " Paid" || $_GET['payment_status'] == "Paid") {
        $color = "#09f;";
    } elseif ($_GET['payment_status'] == "Partial") {
        $color = "#FF8C00;";
    } else {
        $color = "#f00";
    }

    $html.= "<tr><td align='center' style='color:" . $color . "'><h1 style='width:60%; font-size:100px; display:block; margin-left:auto; margin-right:auto; border:3px " . $color . " solid;'>" . $_GET['payment_status'] . "</h1></td></tr>";

    $html.="</tbody></table>";
    include ("pdf/MPDF57/mpdf.php");
    $possetting = $obj->FlyQuery("SELECT * FROM `pos_print_setting` WHERE store_id='" . $input_by . "'");
    if (empty($possetting[0]->thermal_width)) {
        $pw = "58";
    } else {
        $pw = $possetting[0]->thermal_width;
    }

    if (empty($possetting[0]->thermal_height)) {
        $ph = "240";
    } else {
        $ph = $possetting[0]->thermal_height;
    }
    $mpdf = new mPDF('utf-8', array($pw, $ph));
    $mpdf->SetDisplayMode('fullpage');
    $mpdf->list_indent_first_level = 0;
    $stylesheet = file_get_contents('pdf/MPDF57/examples/mpdfstyletables.css');
    $mpdf->WriteHTML($stylesheet, 1);
    $mpdf->WriteHTML($html, 2);
    $mpdf->Output('mpdf.pdf', 'I');
    exit();
}

if (isset($_GET['actionpos'])) {

    $cart = $_GET['invoice'];
    //$cid = $obj->SelectAllByVal("ticket", "ticket_id", $cart, "cid");

    $sqlgetgi = $obj->FlyQuery("SELECT
    a.id,
    a.checkin_id,
    a.input_by,
    a.access_id,
    sto.name as sales_rep,
    a.first_name,
    a.last_name,
    a.phone as customer_phone,
    IFNULL(i.payment_type,0) as payment_type,
    IFNULL(s.status,0) as `status`,
    r.name,
    r.address,
    r.phone,
    r.email,
    r.fotter,
    t.imei as t_imei,
    t.carrier as t_carrier,
    t.type_color as t_type_color,
    t.problem_type as t_problem_type,
    cn.name as network,
    cvc.name as color,
    pt.name as problem,
    crt.imei,
    a.date
    FROM `checkin_request` as a
    LEFT JOIN (SELECT payment_type,invoice_id FROM invoice) as i ON i.invoice_id=a.checkin_id
    LEFT JOIN (SELECT store_id,`status` FROM tax_status) as s ON s.store_id=a.input_by
    LEFT JOIN (SELECT store_id,name,address,phone,email,fotter FROM setting_report) as r on r.store_id=a.input_by
    LEFT JOIN (SELECT id,name FROM store) as sto on sto.id=a.access_id
    LEFT JOIN (SELECT ticket_id,imei,carrier,type_color,problem_type FROM ticket) as t ON t.ticket_id=a.checkin_id
    LEFT JOIN (SELECT id,name FROM problem_type) as tp ON tp.id=t.problem_type
    LEFT JOIN (SELECT id,name FROM checkin_network) as cn ON cn.id=a.network_id
    LEFT JOIN (SELECT id,name FROM checkin_version_color) as cvc ON cvc.id=a.color_id
    LEFT JOIN (SELECT id,name FROM problem_type) as pt ON pt.id=a.problem_id
    LEFT JOIN (SELECT checkin_id,imei FROM checkin_request_ticket) as crt ON crt.checkin_id=a.checkin_id
    WHERE a.checkin_id='" . $cart . "'");

    $creator = $sqlgetgi[0]->input_by;

    $pt = $sqlgetgi[0]->payment_type;
    $ckid = $sqlgetgi[0]->checkin_id;
    $tax_statuss = $sqlgetgi[0]->status;
    if ($tax_statuss == 0) {
        $taxs = 0;
    } else {
        if ($sqlgetgi[0]->tax == '') {
            $taxs = 0;
        } else {
            $taxs = $sqlgetgi[0]->tax;
        }
    }



    $html = '';

    $html.="<table>
           <tbody>";

    $report_cpmpany_name = $sqlgetgi[0]->name;
    $report_cpmpany_address = $sqlgetgi[0]->address;
    $report_cpmpany_phone = $sqlgetgi[0]->phone;
    $report_cpmpany_email = $sqlgetgi[0]->email;
    $report_cpmpany_fotter = $sqlgetgi[0]->fotter;

    function limit_words($string, $word_limit) {
        $words = explode(" ", $string);
        return implode(" ", array_splice($words, 0, $word_limit));
    }

    $addressfline = limit_words($report_cpmpany_address, 3);
    $lengthaddress = strlen($addressfline);
    $lastaddress = substr($report_cpmpany_address, $lengthaddress, 30000);


    $sqlsaleslist = $obj->FlyQuery("select `cr`.`id` AS `id`,
                                    `cr`.`checkin_id` AS `checkin_id`,
                                    `cup`.`price` AS `retail_cost`,concat(`cr`.`first_name`,' ',`cr`.`last_name`) AS `fullname`,
                                    `cr`.`email` AS `email`,`cr`.`phone` AS `phone`,
                                    `c`.`name` AS `device`,`cv`.`name` AS `model`,
                                    `cvc`.`name` AS `color`,`cn`.`name` AS `network`,
                                    `cp`.`name` AS `problem`,`cr`.`warrenty` AS `warrenty`,
                                    `crt`.`imei` AS `imei`,`crt`.`salvage_part` AS `salvage_part`,
                                    `crt`.`lcdstatus` AS `lcdstatus`,`cr`.`date` AS `date`,
                                    `cr`.`input_by` AS `input_by`,`cr`.`status` AS `status` from (((((((`checkin_request` `cr` 
                                    left join `check_user_price` `cup` on((`cup`.`ckeckin_id` = `cr`.`checkin_id`))) 
                                    left join `checkin` `c` on((`c`.`id` = `cr`.`device_id`))) 
                                    left join `checkin_version` `cv` on((`cv`.`id` = `cr`.`model_id`))) 
                                    left join `checkin_version_color` `cvc` on((`cvc`.`id` = `cr`.`color_id`))) 
                                    left join `checkin_network` `cn` on((`cn`.`id` = `cr`.`network_id`))) 
                                    left join `checkin_problem` `cp` on((`cp`.`id` = `cr`.`problem_id`))) 
                                    left join `checkin_request_ticket` `crt` on((`crt`.`checkin_id` = `cr`.`checkin_id`))) WHERE cr.checkin_id='" . $cart . "'  group by `cr`.`checkin_id`");






    $ckid = $cart;


    $html.="<tr>
                    <td align='center'><img src='class/barcode/test_1D.php?text=" . $cart . "' style='margin-top:-20px;' alt='barcode' height='65' /> </td>
                    </tr><tr><td>";
    if ($obj->exists_multiple("checkin_request_ticket", array("checkin_id" => $ckid)) == 0) {
        $html.="<table class='table table-bordered' cellpadding='1' cellspacing='1' style='border:1px; width:600px'>
            <tbody>
            <tr>
            <td colspan='2'>IMEI No: </td>
            </tr>
            <tr>
            <td colspan='2'>" . $sqlgetgi[0]->t_imei . "</td>
            </tr>
            <tr>
            <td colspan='2'>Customer Name: </td>
            </tr>
            <tr>
            <td colspan='2'>" . $sqlgetgi[0]->first_name . " </td>
            </tr>
            <tr>
            <td colspan='2'>Customer Phone: </td>
            </tr>
            <tr>
            <td colspan='2'>" . $sqlgetgi[0]->customer_phone . " </td>
            </tr>
            <tr>
            <td colspan='2'>Carrier : </td>
            </tr>
            <tr>
            <td colspan='2'>" . $sqlgetgi[0]->t_carrier . "</td>
            </tr>
            <tr>
            <td colspan='2'>Color : </td>
            </tr>
            <tr>
            <td colspan='2'>" . $sqlgetgi[0]->t_type_color . " </td>
            </tr>
            <tr>
            <td colspan='2'>Problem : </td>
            </tr>
            <tr>
            <td colspan='2'>" . $sqlsaleslist[0]->problem . " </td>
            </tr>
            </tbody>
            </table>";
    } else {
        $html.="<table class='table table-bordered' cellpadding='1' cellspacing='1'  style='border:1px; width:600px;'>
                    <tbody>
                    
                    <tr>
                    <td colspan='2'>IMEI No: </td>
                    </tr>
                    <tr>
                    <td colspan='2'>" . $sqlgetgi[0]->imei . " </td>
                    </tr>
                    <tr>
                    <td colspan='2'>Customer Name: </td>
                    </tr>
                    <tr>
                    <td colspan='2'>" . $sqlgetgi[0]->first_name . " </td>
                    </tr>
                    <tr>
                    <td colspan='2'>Customer Phone: </td>
                    </tr>
                    <tr>
                    <td colspan='2'>" . $sqlgetgi[0]->customer_phone . " </td>
                    </tr>
                    <tr>
                    <td colspan='2'>Carrier: </td>
                    </tr>
                    <tr>
                    <td colspan='2'>" . $sqlgetgi[0]->network . " </td>
                    </tr>
                    <tr>
                    <td colspan='2'>Color: </td>
                    </tr>
                    <tr>
                    <td colspan='2'>" . $sqlgetgi[0]->color . " </td>
                    </tr>
                    <tr>
                    <td colspan='2'>Problem: </td>
                    </tr>
                    <tr>
                    <td colspan='2'>" . $sqlsaleslist[0]->problem . " </td>
                    </tr>
                    </tbody>
                    </table>";
    }


    $html.="</td>
                    
                    </tr>";





    $html.="<tr>
                    <td align='center'>Thank You For Your Business</td>
                    </tr>";
    if ($_GET['payment_status'] == " Paid") {
        $color = "#09f;";
    } elseif ($_GET['payment_status'] == "Partial") {
        $color = "#FF8C00;";
    } else {
        $color = "#f00";
    } $html.= "<tr><td align='center' style='color:" . $color . "'><h1 style='width:100%; font-size:50px; display:block; margin-left:auto; margin-right:auto; border:3px " . $color . " solid;'>" . $_GET['payment_status'] . "</h1></td></tr>";

    $html.="</tbody></table>";
    include ("pdf/MPDF57/mpdf.php");
    $possetting = $obj->FlyQuery("SELECT * FROM `pos_print_setting` WHERE store_id='" . $input_by . "'");
    if (empty($possetting[0]->bar_width)) {
        $pw = "58";
    } else {
        $pw = $possetting[0]->bar_width;
    }

    if (empty($possetting[0]->bar_height)) {
        $ph = "200";
    } else {
        $ph = $possetting[0]->bar_height;
    }
    $mpdf = new mPDF('utf-8', array($pw, $ph));
    $mpdf->SetDisplayMode('fullpage');
    $mpdf->list_indent_first_level = 0;
    $stylesheet = file_get_contents('pdf/MPDF57/examples/mpdfstyletables.css');
    $mpdf->WriteHTML($stylesheet, 1);
    $mpdf->WriteHTML($html, 2);
    $mpdf->Output('mpdf.pdf', 'I');
    exit();
}

if (@$_GET['export'] == "excel") {


    $record_label = "CheckIn List Report";
    header('Content-type: application/excel');
    $filename = "CheckIn_list_" . date('Y_m_d') . '.xls';
    header('Content-Disposition: attachment; filename=' . $filename);

    $data = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">
<head>
    <!--[if gte mso 9]>
    <xml>
        <x:ExcelWorkbook>
            <x:ExcelWorksheets>
                <x:ExcelWorksheet>
                    <x:Name>CheckIn List : Wireless Geeks Inc.</x:Name>
                    <x:WorksheetOptions>
                        <x:Print>
                            <x:ValidPrinterInfo/>
                        </x:Print>
                    </x:WorksheetOptions>
                </x:ExcelWorksheet>
            </x:ExcelWorksheets>
        </x:ExcelWorkbook>
    </xml>
    <![endif]-->
</head>';

    $data .="<body>";
//$data .="<h1>Wireless Geeks Inc.</h1>";
    $data .="<h3>" . $record_label . "</h3>";
    $data .="<h5>CheckIn List Generate Date : " . date('d-m-Y H:i:s') . "</h5>";

    $data .="<table>
    <thead>
        <tr style='background:#09f; color:#fff;'>
			<th>#</th>
			<th>Checkin ID</th>
			<th>Detail</th>
			<th>Problem</th>
			<th>CheckIn Price</th>
			<th>Created</th>
			<th>Status</th>
		</tr>
</thead>
<tbody>";


    if ($input_status == 1) {
        $sqlticket = $obj->SelectAll("checkin_list");
    } elseif ($input_status == 5) {

        $sqlchain_store_ids = $obj->SelectAllByID("store_chain_admin", array("sid" => $input_by));
        if (!empty($sqlchain_store_ids)) {
            $array_ch = array();
            foreach ($sqlchain_store_ids as $ch):
                array_push($array_ch, $ch->store_id);
            endforeach;

            include('class/report_chain_admin.php');
            $obj_report_chain = new chain_report();
            $sqlticket = $obj_report_chain->SelectAllByID_Multiple_Or("checkin_list", $array_ch, "input_by", "1");
        }
        else {
            //echo "Not Work";
            $sqlticket = "";
        }
    } else {
        $sqlticket = $obj->SelectAllByID("checkin_list", array("input_by" => $input_by));
    }
    $i = 1;
    if (!empty($sqlticket)) {
        foreach ($sqlticket as $ticket):
            if ($obj->exists_multiple("checkin_request_ticket", array("checkin_id" => $ticket->checkin_id)) != 0) {
                $ticket_device = str_replace(' ', '', $ticket->device);

                $data.="<tr>
				<td>" . $i . "</td>
				<td>" . $ticket->checkin_id . "</td>
				<td>" . $ticket_device . "," . $ticket->color . "," . $ticket->network . "</td>
				<td>" . $ticket->problem . "</td>";

                $chkx = $obj->exists_multiple("check_user_price", array("ckeckin_id" => $ticket->checkin_id));
                if ($chkx == 0) {
                    $estp = $obj->SelectAllByVal("product", "name", $ticket_device . "-" . $ticket->problem, "price_cost");
                    if ($estp == '') {
                        $devid = $obj->SelectAllByVal("checkin_request", "checkin_id", $ticket->checkin_id, "device_id");
                        $modid = $obj->SelectAllByVal("checkin_request", "checkin_id", $ticket->checkin_id, "model_id");
                        $probid = $obj->SelectAllByVal("checkin_request", "checkin_id", $ticket->checkin_id, "problem_id");
                        $pp = $obj->SelectAllByVal3("checkin_price", "checkin_id", $devid, "checkin_version_id", $modid, "checkin_problem_id", $probid, "name");
                    } else {
                        $pp = $estp;
                    }
                } else {

                    $estp = $obj->SelectAllByVal("check_user_price", "ckeckin_id", $ticket->checkin_id, "price");
                    if ($estp == '') {
                        $devid = $obj->SelectAllByVal("checkin_request", "checkin_id", $ticket->checkin_id, "device_id");
                        $modid = $obj->SelectAllByVal("checkin_request", "checkin_id", $ticket->checkin_id, "model_id");
                        $probid = $obj->SelectAllByVal("checkin_request", "checkin_id", $ticket->checkin_id, "problem_id");
                        $pp = $obj->SelectAllByVal3("checkin_price", "checkin_id", $devid, "checkin_version_id", $modid, "checkin_problem_id", $probid, "name");
                    } else {
                        $pp = $estp;
                    }
                }
                $pid = $obj->SelectAllByVal("product", "name", $ticket_device . ", " . $ticket->model . " - " . $ticket->problem, "id");
                $cid = $obj->SelectAllByVal2("coustomer", "firstname", $obj->SelectAllByVal("checkin_request", "checkin_id", $ticket->checkin_id, "first_name"), "phone", $obj->SelectAllByVal("checkin_request", "checkin_id", $ticket->checkin_id, "phone"), "id");
                $chkcheckin = $obj->exists_multiple("invoice", array("doc_type" => 3, "checkin_id" => $ticket->checkin_id));
                $getsales_id = $obj->SelectAllByVal("invoice", "checkin_id", $ticket->checkin_id, "invoice_id");
                $curcheck = $obj->exists_multiple("sales", array("sales_id" => $getsales_id));
                if ($curcheck == 0) {
                    if ($pp == '' || $pp == 0) {
                        $app = 0;
                    } else {
                        $app = number_format($pp, 2);
                    }
                    $data.="<td>" . $app . " Send To Pos</td>";
                } else {
                    if ($pp == '' || $pp == 0) {
                        $ssd = 0;
                    } else {
                        $ssd = number_format($pp, 2);
                    }
                    $data.="<td>" . $ssd . "</td>";
                }
                $data.="<td>" . $obj->CountDate($ticket->date) . "</td>
				<td>" . checkin_paid($curcheck) . "</td>
			</tr>";
                $i++;
            }
        endforeach;
    }

    $data .="</tbody><tfoot><tr>
			<th>#</th>
			<th>Checkin ID</th>
			<th>Detail</th>
			<th>Problem</th>
			<th>CheckIn Price</th>
			<th>Created</th>
			<th>Status</th>
		</tr></tfoot></table>";

    $data .='</body></html>';

    echo $data;
}

if (@$_GET['export'] == "pdf") {
    $record_label = "CheckIn List Report";
    include("pdf/MPDF57/mpdf.php");
    extract($_GET);
    $html.="<table id='sample-table-2' class='table table-hover' border='0'><tbody>";
    $html .="<tr>
			<td valign='top' style='margin:0; padding:0; width:100%;'>
				<table style='width:100%; height:40px; border:0px;'>
					<tr>
						<td width='87%' style='background:rgba(0,51,153,1);  color:#FFF; font-size:25px;'>
						CheckIn List Report
						</td>
					</tr>
				</table>


				<table style='width:100%; height:40px; border:0px; font-size:18px;'>
					<tr>
						<td> CheckIn List Generate Date : " . date('d-m-Y H:i:s') . "</td>
					</tr>
				</table>
				<table style='width:960px;border:1px; font-size:12px; background:#ccc;'>";
    $html.="<thead>
        <tr style='background:#09f; color:#fff;'>
			<th>#</th>
			<th>Checkin ID</th>
			<th>Detail</th>
			<th>Problem</th>
			<th>CheckIn Price</th>
			<th>Created</th>
			<th>Status</th>
		</tr>
</thead>
<tbody>";

    if ($input_status == 1) {
        $sqlticket = $obj->SelectAll("checkin_list");
    } else {
        $sqlticket = $obj->SelectAllByID("checkin_list", array("input_by" => $input_by));
    }
    $i = 1;
    if (!empty($sqlticket)) {
        foreach ($sqlticket as $ticket):
            if ($obj->exists_multiple("checkin_request_ticket", array("checkin_id" => $ticket->checkin_id)) != 0) {

                $html.="<tr>
				<td>" . $i . "</td>
				<td>" . $ticket->checkin_id . "</td>
				<td>" . $ticket_device . "," . $ticket->color . "," . $ticket->network . "</td>
				<td>" . $ticket->problem . "</td>";

                $chkx = $obj->exists_multiple("check_user_price", array("ckeckin_id" => $ticket->checkin_id));
                if ($chkx == 0) {
                    $estp = $obj->SelectAllByVal("product", "name", $ticket_device . "-" . $ticket->problem, "price_cost");
                    if ($estp == '') {
                        $devid = $obj->SelectAllByVal("checkin_request", "checkin_id", $ticket->checkin_id, "device_id");
                        $modid = $obj->SelectAllByVal("checkin_request", "checkin_id", $ticket->checkin_id, "model_id");
                        $probid = $obj->SelectAllByVal("checkin_request", "checkin_id", $ticket->checkin_id, "problem_id");
                        $pp = $obj->SelectAllByVal3("checkin_price", "checkin_id", $devid, "checkin_version_id", $modid, "checkin_problem_id", $probid, "name");
                    } else {
                        $pp = $estp;
                    }
                } else {

                    $estp = $obj->SelectAllByVal("check_user_price", "ckeckin_id", $ticket->checkin_id, "price");
                    if ($estp == '') {
                        $devid = $obj->SelectAllByVal("checkin_request", "checkin_id", $ticket->checkin_id, "device_id");
                        $modid = $obj->SelectAllByVal("checkin_request", "checkin_id", $ticket->checkin_id, "model_id");
                        $probid = $obj->SelectAllByVal("checkin_request", "checkin_id", $ticket->checkin_id, "problem_id");
                        $pp = $obj->SelectAllByVal3("checkin_price", "checkin_id", $devid, "checkin_version_id", $modid, "checkin_problem_id", $probid, "name");
                    } else {
                        $pp = $estp;
                    }
                }
                $pid = $obj->SelectAllByVal("product", "name", $ticket_device . ", " . $ticket->model . " - " . $ticket->problem, "id");
                $cid = $obj->SelectAllByVal2("coustomer", "firstname", $obj->SelectAllByVal("checkin_request", "checkin_id", $ticket->checkin_id, "first_name"), "phone", $obj->SelectAllByVal("checkin_request", "checkin_id", $ticket->checkin_id, "phone"), "id");
                $chkcheckin = $obj->exists_multiple("invoice", array("doc_type" => 3, "checkin_id" => $ticket->checkin_id));
                $getsales_id = $obj->SelectAllByVal("invoice", "checkin_id", $ticket->checkin_id, "invoice_id");
                $curcheck = $obj->exists_multiple("sales", array("sales_id" => $getsales_id));
                if ($curcheck == 0) {
                    if ($pp == '' || $pp == 0) {
                        $app = 0;
                    } else {
                        $app = number_format($pp, 2);
                    }
                    $html.="<td>" . $app . " Send To Pos</td>";
                } else {
                    if ($pp == '' || $pp == 0) {
                        $ssd = 0;
                    } else {
                        $ssd = number_format($pp, 2);
                    }
                    $html.="<td>" . $ssd . "</td>";
                }
                $html.="<td>" . $obj->CountDate($ticket->date) . "</td>
				<td>" . checkin_paid($curcheck) . "</td>
			</tr>";
                $i++;
            }
        endforeach;
    }

    $html.="</tbody><tfoot><tr>
			<th>#</th>
			<th>Checkin ID</th>
			<th>Detail</th>
			<th>Problem</th>
			<th>CheckIn Price</th>
			<th>Created</th>
			<th>Status</th>
		</tr></tfoot></table>";

    $html.="</td></tr>";
    $html.="</tbody></table>";

    $mpdf = new mPDF('c', 'A4', '', '', 32, 25, 27, 25, 16, 13);

    $mpdf->SetDisplayMode('fullpage');

    $mpdf->list_indent_first_level = 0; // 1 or 0 - whether to indent the first level of a list
    // LOAD a stylesheet
    $stylesheet = file_get_contents('pdf/MPDF57/examples/mpdfstyletables.css');
    $mpdf->WriteHTML($stylesheet, 1); // The parameter 1 tells that this is css/style only and no body/html/text

    $mpdf->WriteHTML($html, 2);

    $mpdf->Output('mpdf.pdf', 'I');
}

if (isset($_GET['action'])) {

    $cart = $_GET['invoice'];
    //$cid = $obj->SelectAllByVal("ticket", "ticket_id", $cart, "cid");

    $sqlgetgi = $obj->FlyQuery("SELECT
    a.id,
    a.checkin_id,
    a.input_by,
    a.access_id,
    sto.name as sales_rep,
    a.first_name,
    a.last_name,
    a.phone as customer_phone,
    IFNULL(i.payment_type,0) as payment_type,
    IFNULL(s.status,0) as `status`,
    r.name,
    r.address,
    r.phone,
    r.email,
    r.fotter,
    t.imei as t_imei,
    t.carrier as t_carrier,
    t.type_color as t_type_color,
    t.problem_type as t_problem_type,
    cn.name as network,
    cvc.name as color,
    pt.name as problem,
    crt.imei,
    a.date
    FROM `checkin_request` as a
    LEFT JOIN (SELECT payment_type,invoice_id FROM invoice) as i ON i.invoice_id=a.checkin_id
    LEFT JOIN (SELECT store_id,`status` FROM tax_status) as s ON s.store_id=a.input_by
    LEFT JOIN (SELECT store_id,name,address,phone,email,fotter FROM setting_report) as r on r.store_id=a.input_by
    LEFT JOIN (SELECT id,name FROM store) as sto on sto.id=a.access_id
    LEFT JOIN (SELECT ticket_id,imei,carrier,type_color,problem_type FROM ticket) as t ON t.ticket_id=a.checkin_id
    LEFT JOIN (SELECT id,name FROM problem_type) as tp ON tp.id=t.problem_type
    LEFT JOIN (SELECT id,name FROM checkin_network) as cn ON cn.id=a.network_id
    LEFT JOIN (SELECT id,name FROM checkin_version_color) as cvc ON cvc.id=a.color_id
    LEFT JOIN (SELECT id,name FROM problem_type) as pt ON pt.id=a.problem_id
    LEFT JOIN (SELECT checkin_id,imei FROM checkin_request_ticket) as crt ON crt.checkin_id=a.checkin_id
    WHERE a.checkin_id='" . $cart . "'");

    $creator = $sqlgetgi[0]->input_by;

    $pt = $sqlgetgi[0]->payment_type;
    $ckid = $sqlgetgi[0]->checkin_id;
    $tax_statuss = $sqlgetgi[0]->status;
    if ($tax_statuss == 0) {
        $taxs = 0;
    } else {
        $taxs = $sqlgetgi[0]->tax;
    }



    $html = '';

    $html.="<table id='sample-table-2' class='table table-hover' border='1'><tbody>";

    $report_cpmpany_name = $sqlgetgi[0]->name;
    $report_cpmpany_address = $sqlgetgi[0]->address;
    $report_cpmpany_phone = $sqlgetgi[0]->phone;
    $report_cpmpany_email = $sqlgetgi[0]->email;
    $report_cpmpany_fotter = $sqlgetgi[0]->fotter;

    function limit_words($string, $word_limit) {
        $words = explode(" ", $string);
        return implode(" ", array_splice($words, 0, $word_limit));
    }

    $addressfline = limit_words($report_cpmpany_address, 3);
    $lengthaddress = strlen($addressfline);
    $lastaddress = substr($report_cpmpany_address, $lengthaddress, 30000);

    $html .="<tr>
			<td style='height:40px; background:rgba(0,51,153,1);'>
				<table style='width:100%; height:40px; border:0px;'>
					<tr>
						<td width='87%' style='background:rgba(0,51,153,1);  color:#FFF; font-size:30px;'>" . $report_cpmpany_name . "</td><td width='13%' style='background:rgba(0,51,153,1);  color:#FFF; font-size:30px;'><span style='float:left; text-align:left;'>" . $_GET['payment_status'] . " Invoice</span></td>
					</tr>
				</table>
			</td>
		  </tr>
		  <tr>
			<td style='height:40px;' valign='top'>
				<table style='width:960px; height:40px; font-size:12px; border:0px;'>
					<tr>
						<td width='69%'>
						" . $addressfline . "<br>
						" . $lastaddress . "
						</td>
						<td width='31%'>
						DIRECT ALL INQUIRIES TO:<br />
						" . $report_cpmpany_name . "<br />
						" . $report_cpmpany_phone . "<br />
						" . $report_cpmpany_email . "<br />
						</td>
					</tr>
				</table>
			</td>
		  </tr>
		  <tr>
			<td style='height:30px;' valign='top'>
				<table style='width:100%; height:40px; border:0px; font-size:18px;'>
					<tr>
						<td> Sold To : </td>
					</tr>
				</table>
			</td>
		  </tr>
		  <tr>
			<td style='height:40px;' valign='top'>
				<table style='width:960px; height:40px; border:0px;'>
					<tr>
						<td width='69%'>
						Name : " . $sqlgetgi[0]->first_name . " " . $sqlgetgi[0]->last_name . "<br />
						Phone : " . $sqlgetgi[0]->customer_phone . "<br />
            </td>
            </tr>
            </table>
            </td>
            </tr>

            <tr>
            <td style='height:40px;' valign='top'>
            <table style='width:960px; height:40px; border:0px;'>
            <tr>
            <td width='69%'>
            Phone Repair Center <br />
            We Repair | We Buy | We Sell <br />
            </td>
            <td width='31%'>
            INVOICE DATE : " . $sqlgetgi[0]->date . "<br />
            ORDER NO. : " . $cart . "<br />
            SALES REP : " . $sqlgetgi[0]->sales_rep . "<br />
            </td>
            </tr>
            </table>
            </td>
            </tr>

            <tr>
            <td style='height:40px;' valign='top'>
            <table style='width:100%; height:40px; border:0px;'>
            <tr>
            <td width='79%'>
            Sales Tax Rate: " . $taxs . "%
            </td>
            </tr>
            </table>
            </td>
            </tr>

            <tr>
            <td valign='top' style='margin:0; padding:0; width:100%;'>
            <table style='width:960px;border:1px; font-size:12px; background:#ccc;'>";
    $html.="<thead><tr>
            <td>S/L</td>
            <td>Ticket ID</td>
            <td>Ticket Detail</td>

            <td>Quantity</td>
            <td>Unit Cost</td>
            <td>Tax</td>
            <td>Extended</td>
            </tr></thead>";

    $sqlsaleslist = $obj->FlyQuery("select `cr`.`id` AS `id`,
                                    `cr`.`checkin_id` AS `checkin_id`,
                                    `cup`.`price` AS `retail_cost`,concat(`cr`.`first_name`,' ',`cr`.`last_name`) AS `fullname`,
                                    `cr`.`email` AS `email`,`cr`.`phone` AS `phone`,
                                    `c`.`name` AS `device`,`cv`.`name` AS `model`,
                                    `cvc`.`name` AS `color`,`cn`.`name` AS `network`,
                                    `cp`.`name` AS `problem`,`cr`.`warrenty` AS `warrenty`,
                                    `crt`.`imei` AS `imei`,`crt`.`salvage_part` AS `salvage_part`,
                                    `crt`.`lcdstatus` AS `lcdstatus`,`cr`.`date` AS `date`,
                                    `cr`.`input_by` AS `input_by`,`cr`.`status` AS `status` from (((((((`checkin_request` `cr` 
                                    left join `check_user_price` `cup` on((`cup`.`ckeckin_id` = `cr`.`checkin_id`))) 
                                    left join `checkin` `c` on((`c`.`id` = `cr`.`device_id`))) 
                                    left join `checkin_version` `cv` on((`cv`.`id` = `cr`.`model_id`))) 
                                    left join `checkin_version_color` `cvc` on((`cvc`.`id` = `cr`.`color_id`))) 
                                    left join `checkin_network` `cn` on((`cn`.`id` = `cr`.`network_id`))) 
                                    left join `checkin_problem` `cp` on((`cp`.`id` = `cr`.`problem_id`))) 
                                    left join `checkin_request_ticket` `crt` on((`crt`.`checkin_id` = `cr`.`checkin_id`))) WHERE cr.checkin_id='" . $cart . "'  group by `cr`.`checkin_id`");

    $sss = 1;
    $subtotal = 0;
    $curcheck = 0;
    $tax = 0;
    $total = 0;
    $total = 0;
    $expaid = 0;
    $sales_invoice = 0;
    if (!empty($sqlsaleslist))
        foreach ($sqlsaleslist as $saleslist):
            $caltax = ($saleslist->single_cost * $tax_per_product) / 100;
            $procost = $saleslist->quantity * $saleslist->single_cost;
            $subtotal+=$procost;
            $html.="<thead><tr>
            <td>" . $sss . "</td>
            <td>" . $saleslist->checkin_id . "</td>
            <td>" . $saleslist->problem . " - " . $saleslist->device . ", " . $saleslist->model . ", " . $saleslist->color . ", " . $saleslist->network . "</td>";

            
            $chkcron = $obj->exists_multiple("checkin_cron", array("ckeckin_id" => $saleslist->checkin_id));
            if ($chkcron == 0) {
                $chkx = $obj->exists_multiple("check_user_price", array("ckeckin_id" => $saleslist->checkin_id));
                if ($chkx == 0) {
                    $estp = $obj->SelectAllByVal("product", "name", $saleslist->device . "-" . $saleslist->problem, "price_cost");
                    if ($estp == '') {
                        $devid = $obj->SelectAllByVal("checkin_request", "checkin_id", $saleslist->checkin_id, "device_id");
                        $modid = $obj->SelectAllByVal("checkin_request", "checkin_id", $saleslist->checkin_id, "model_id");
                        $probid = $obj->SelectAllByVal("checkin_request", "checkin_id", $saleslist->checkin_id, "problem_id");

                        if ($input_status == 1) {
                            $pp = $obj->SelectAllByVal3("checkin_price", "checkin_id", $devid, "checkin_version_id", $modid, "checkin_problem_id", $probid, "name");
                        } else {
                            $pp = $obj->SelectAllByVal4("checkin_price", "checkin_id", $devid, "checkin_version_id", $modid, "checkin_problem_id", $probid, "store_id", $input_by, "name");
                        }
                    } else {
                        $pp = $estp;
                    }
                } else {

                    $estp = $obj->SelectAllByVal("check_user_price", "ckeckin_id", $saleslist->checkin_id, "price");
                    if ($estp == '') {
                        $devid = $obj->SelectAllByVal("checkin_request", "checkin_id", $saleslist->checkin_id, "device_id");
                        $modid = $obj->SelectAllByVal("checkin_request", "checkin_id", $saleslist->checkin_id, "model_id");
                        $probid = $obj->SelectAllByVal("checkin_request", "checkin_id", $saleslist->checkin_id, "problem_id");

                        if ($input_status == 1) {
                            $pp = $obj->SelectAllByVal3("checkin_price", "checkin_id", $devid, "checkin_version_id", $modid, "checkin_problem_id", $probid, "name");
                        } else {
                            $pp = $obj->SelectAllByVal4("checkin_price", "checkin_id", $devid, "checkin_version_id", $modid, "checkin_problem_id", $probid, "store_id", $input_by, "name");
                        }
                    } else {
                        $pp = $estp;
                    }
                }
            } else {
                $sqlcheckincron=$obj->FlyQuery("SELECT checkin_id,checkin_price,paid FROM checkin_cron WHERE checkin_id='".$saleslist->checkin_id."'");
                if(!empty($sqlcheckincron))
                {
                    $pp=$sqlcheckincron[0]->checkin_price;
                    $expaid=$sqlcheckincron[0]->paid;
                }
            }

            $pid = $obj->SelectAllByVal("product", "name", $saleslist->device . ", " . $saleslist->model . " - " . $saleslist->problem, "id");
            $cid = $obj->SelectAllByVal2("coustomer", "firstname", $obj->SelectAllByVal("checkin_request", "checkin_id", $ticket->checkin_id, "first_name"), "phone", $obj->SelectAllByVal("checkin_request", "checkin_id", $saleslist->checkin_id, "phone"), "id");
            $chkcheckin = $obj->exists_multiple("invoice", array("doc_type" => 3, "checkin_id" => $saleslist->checkin_id));
            $getsales_id = $obj->SelectAllByVal("invoice", "checkin_id", $saleslist->checkin_id, "invoice_id");
            $curcheck+=$obj->exists_multiple("sales", array("sales_id" => $getsales_id));
            $sales_invoice = $getsales_id;
            if ($pp == '') {
                $price = 0;
            } else {
                $price = $pp;
            }

            $subtotal+=$price;

            $caltaxs = ($price * $taxs) / 100;
            $extended = $price + $caltaxs;
            $tax+=$caltaxs;
            $total+=$extended;
            $html.="<td>1</td>
            <td><button type='button' class='btn'>$" . $price . "</button></td>
            <td>$" . $caltaxs . "</td>
            <td>
            <button type='button' class='btn'>$" . $extended . "</button>
            </td>
            </tr></thead>";

            $sss++;
        endforeach;


    //echo $html;
    //exit();
    $html.="</table></td></tr>";
    $ckid = $cart;
    if ($ckid != 0) {

        $html.="<tr><td><table style='width:960px;'>
            <thead>
            <tr>
            <td width='350' valign='top'>";
        if ($obj->exists_multiple("checkin_request_ticket", array("checkin_id" => $ckid)) == 0) {
            $html.="<table style='width:300px;border:1px; margin-left:-4px; font-size:12px; background:#ccc;'>
            <thead>
            <tr>
            <th>IMEI of Device being repair : </th>
            <th>" . $sqlgetgi[0]->t_imei . "</th>
            </tr>
            <tr>
            <th>Carrier : </th>
            <th>" . $sqlgetgi[0]->t_carrier . "</th>
                    </tr>
                    <tr>
                    <th>Color : </th>
                    <th>" . $sqlgetgi[0]->t_type_color . " </th>
                    </tr>
                    <tr>
                    <th>Problem : </th>
                    <th>" . $sqlgetgi[0]->t_problem_type . " </th>
                    </tr>
                    </thead>
                    </table>";
        } else {
            $html.="<table style='width:300px;border:1px; margin-left:-4px; font-size:12px; background:#ccc;'>
                    <thead>
                    <tr>
                    <th>IMEI of Device being repair: </th>
                    <th>" . $sqlgetgi[0]->imei . " </th>
                    </tr>
                    <tr>
                    <th>Carrier: </th>
                    <th>" . $sqlgetgi[0]->network . " </th>
                    </tr>
                    <tr>
                    <th>Color: </th>
                    <th>" . $sqlgetgi[0]->color . " </th>
                    </tr>
                    <tr>
                    <th>Problem: </th>
                    <th>" . $sqlgetgi[0]->problem . " </th>
                    </tr>
                    </thead>
                    </table>";
        }

        $chk_invoice_status = $obj->exists_multiple("invoice ", array("invoice_id" => $sales_invoice, "status" => 3));
        $html.="</td>
                    <td>
                    <table style='width:250px;border:1px; font-size:12px; background:#ccc;'>
                    <thead>
                    <tr>
                    <th>Payment : </th>
                    <th>" . checkin_paid($curcheck) . "</th>
                    </tr>
                    <tr>
                    <th>Sub - Total: </th>
                    <th>$" . number_format($subtotal, 2) . "</th>
                    </tr>
                    <tr>
                    <th>Tax: </th>
                    <th>$" . number_format($tax, 2) . "</th>
                    </tr>
                    <tr>
                    <th>Total: </th>
                    <th>$" . number_format($total, 2) . "</th>
                    </tr>";
        if ($chk_invoice_status == 1) {
            //$sqlexpaid = $obj->SelectAllByID_Multiple("invoice_payment", array("invoice_id" => $sales_invoice));
            
//            if (!empty($sqlexpaid))
//                foreach ($sqlexpaid as $pd):
//                    $expaid+=$pd->amount;
//                endforeach;
            $exdue = $total - $expaid;
            $html.="<tr>
                    <th>Payments: </th>
                    <th>$";
            if ($curcheck == 0) {
                $html.="0";
            } else {
                $html.=number_format($expaid, 2);
            }
            $html.="</th>
                    </tr>
                    <tr>
                    <th>Balance Due: </th>
                    <th>$";
            if ($curcheck == 0) {
                $html.=$exdue;
            } else {
                $html.=$exdue;
            }
        } else {
            $html.="<tr>
                    <th>Payments: </th>
                    <th>$";
            if ($curcheck == 0) {
                $html.="0";
            } else {
                $html.=$total;
            }
            $html.="</th>
                    </tr>
                    <tr>
                    <th>Balance Due: </th>
                    <th>$";
            if ($curcheck == 0) {
                $html.=$total;
            } else {
                $html.="0";
            }
        }

        $html.="</th>
                    </tr>
                    </thead>
                    </table>
                    </td>
                    </tr>
                    </thead>
                    </table>
                    </td>
                    </tr>
                    <tr>
                    <td>

                    </td>
                    </tr>";
    } else {

        $html.="<tr><td><table style='width:250px;border:1px; font-size:12px; background:#ccc;'><thead>
                    <tr>
                    <th>Payment Type: </th>
                    <th>" . checkin_paid($curcheck) . "</th>
                    </tr>
                    <tr>
                    <th>Sub - Total: </th>
                    <th>$" . number_format($subtotal, 2) . "</th>
                    </tr>
                    <tr>
                    <th>Tax: </th>
                    <th>$" . number_format($tax, 2) . "</th>
                    </tr>
                    <tr>
                    <th>Total: </th>
                    <th>$" . number_format($total, 2) . "</th>
                    </tr>
                    <tr>
                    <th>Payments: </th>
                    <th>$";
        if ($curcheck == 0) {
            $html.="0";
        } else {
            $html.=$total;
        }
        $html.="</th>
                    </tr>
                    <tr>
                    <th>Balance Due: </th>
                    <th>$";
        if ($curcheck == 0) {
            $html.=$total;
        } else {
            $html.="0";
        }
        $html.="</th>
                    </tr>
                    </thead></table></td></tr>";
    }




    $html.="<tr>
                    <td align='center' style='font-size:8px;'>" . $report_cpmpany_fotter . "</td>
                    </tr>
                    <tr>
                    <td align='center'>Thank You For Your Business</td>
                    </tr>";
    if ($_GET['payment_status'] == " Paid") {
        $color = "#09f;";
    } elseif ($_GET['payment_status'] == "Partial") {
        $color = "#FF8C00;";
    } else {
        $color = "#f00";
    } $html.= "<tr><td align='center' style='color:" . $color . "'><h1 style='width:60%; font-size:100px; display:block; margin-left:auto; margin-right:auto; border:3px " . $color . " solid;'>" . $_GET['payment_status'] . "</h1></td></tr>";

    $html.="</tbody></table>";
    include ("pdf/MPDF57/mpdf.php");


    $mpdf = new mPDF('c', 'A4', '', '', 32, 25, 27, 25, 16, 13);

    $mpdf->SetDisplayMode('fullpage');
    $mpdf->list_indent_first_level = 0;
    $stylesheet = file_get_contents('pdf/MPDF57/examples/mpdfstyletables.css');
    $mpdf->WriteHTML($stylesheet, 1);
    $mpdf->WriteHTML($html, 2);
    $mpdf->Output('mpdf.pdf', 'I');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
        include './plugin/plugin.php';
        $cms = new CmsRootPlugin();
        echo $cms->GeneralCss(array("kendo", "modal"));
        ?>
    </head>

    <body>
        <?php include ('include/header.php'); ?>
        <!-- Main wrapper -->
        <div class="wrapper three-columns">

            <!-- Left sidebar -->
            <?php include ('include/sidebar_left.php'); ?>
            <!-- /left sidebar -->


            <!-- Main content -->
            <div class="content">

                <!-- Info notice -->
                <?php echo $obj->ShowMsg(); ?>
                <!-- /info notice -->

                <div class="outer">
                    <div class="inner">
                        <div class="page-header"><!-- Page header -->
                            <h5><i class="icon-ok-circle"></i>
                                <span style="border-right:2px #333 solid; padding-right:10px;">In-Store Repair List Info </span>
                                <span><i class="font-calendar"></i> <a data-toggle="modal" href="#myModal"> Generate Customer Report</a></span> 
                            </h5>
                            <ul class="icons">
                                <li><a href="<?php echo $obj->filename(); ?>" class="hovertip" title="Reload"><i class="font-refresh"></i></a></li>
                            </ul>
                        </div><!-- /page header -->

                        <div class="body">

                            <!-- Middle navigation standard -->

                            <?php //include('include/quicklink.php');             ?>
                            <!-- /middle navigation standard -->

                            <!-- Content container -->
                            <div class="container">
                                <!-- Dialog content -->
                                <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h5 id="myModalLabel"><i class="font-calendar"></i> Generate Customer Report <span id="mss"></span></h5>
                                    </div>
                                    <div class="modal-body">

                                        <div class="row-fluid">
                                            <form class="form-horizontal" method="get" action="">
                                                <div class="control-group">
                                                    <label class="control-label"><strong>Date Search:</strong></label>
                                                    <div class="controls">
                                                        <ul class="dates-range">
                                                            <li><input type="text" id="fromDate" name="from" placeholder="From" /></li>
                                                            <li class="sep">-</li>
                                                            <li><input type="text" id="toDate" name="to" placeholder="To" /></li>
                                                            <li class="sep">&nbsp;</li>
                                                            <li><button class="btn btn-primary" type="submit">Search Report</button></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </form>


                                        </div>

                                    </div>
                                </div>
                                <!-- /dialog content -->


                                <!-- Content Start from here customized -->

                                <div class="block">
                                    <div class="table-overflow">

                                        <div id="grid" style="margin-left: 10px;margin-right: 10px;"></div>
                                        <script id="checkin_link" type="text/x-kendo-template">
                                            <a href="view_checkin.php?ticket_id=#=checkin_id#">#=checkin_id#</a>
                                        </script>
                                        <script id="checkin_status" type="text/x-kendo-template">
                                            #if (paid == 0)
                                            {#
                                            <label class='label label-danger'>Not Paid</label>
                                            #} else { 
                                            if(paid!=0 && checkin_price>paid)
                                            {
                                            #
                                            <label class='label label-warning'>Partial</label>
                                            #}
                                            else
                                            {#
                                            <label class='label label-success'>Paid</label>
                                            #}
                                            }#
                                        </script>
                                        <script id="checkin_price" type="text/x-kendo-template">
                                            #if (paid == 0) 
                                            {# 
                                            <a class="btn btn-info" href="pos.php?newsales=1&amp;pid=#=pid#&amp;price=#=checkin_price#&amp;checkin_id=#=checkin_id#&AMP;cid=#=cid#"><?php echo $currencyicon; ?> #=checkin_price# Send To Pos</a> 
                                            #} else { 
                                            if(paid!=0 && checkin_price>paid)
                                            {#
                                            <a href="pos_make_new_cart.php?cart_id=#=invoice_id#" class="btn btn-warning"><?php echo $currencyicon; ?> #=checkin_price-paid# Send To POS</a>
                                            #}
                                            else
                                            {#
                                            <span class="label label-info"><?php echo $currencyicon; ?> #=checkin_price# Paid</span>
                                            #}
                                            }#
                                        </script>
                                        <script id="edit_client" type="text/x-kendo-template">
                                            <a href="<?php echo $obj->filename(); ?>?action=pdf&amp;invoice=#=checkin_id#&amp;payment_status=#if (paid == 0)
                                            {#Unpaid#} else { 
                                            if(paid!=0 && checkin_price>paid)
                                            {#Partial#}
                                            else
                                            {#Paid#}
                                            }#" target="_blank" class="hovertip" title="Print"  onclick="javascript:return confirm('Are you absolutely sure to Print This Checkin Request ?')"><i class="icon-print"></i></a>
                                            <a href="javascript:void(0);" class="hovertip" title="Delete Product" onclick="deleteClick(#=id#)"><i class="icon-trash"></i></a>
                                        </script>
                                        <script type="text/javascript">
                                            function deleteClick(id) {
                                                var c = confirm("Do you want to delete?");
                                                if (c === true) {
                                                    $.ajax({
                                                        type: "POST",
                                                        dataType: "json",
                                                        url: "./controller/checkin_list.php",
                                                        data: {id: id},
                                                        success: function (result) {
                                                            $(".k-i-refresh").click();
                                                        }
                                                    });
                                                }
                                            }

                                        </script>
                                        <?php
                                        $cond = $cms->FrontEndDateSearch('from', 'to');
                                        ?>
                                        <script type="text/javascript">
                                            var gridElement = $("#grid");

                                            function showLoading(e) {
                                                kendo.ui.progress(gridElement, true);
                                            }

                                            function restoreSelection(e) {
                                                kendo.ui.progress(gridElement, false);
                                            }

                                            jQuery(document).ready(function () {

                                                var dataSource = new kendo.data.DataSource({
                                                    requestStart: showLoading,
                                                    transport: {
                                                        read: {
                                                            url: "./controller/checkin_list.php<?php echo $cond; ?>",
                                                            type: "GET",
                                                            datatype: "json"
                                                        }
                                                    },
                                                    autoSync: false,
                                                    schema: {
                                                        data: "data",
                                                        total: "total",
                                                        model: {
                                                            id: "id",
                                                            fields: {
                                                                id: {nullable: true},
                                                                checkin_id: {type: "string"},
                                                                detail: {type: "string"},
                                                                problem: {type: "string"},
                                                                checkin_price: {type: "string"},
                                                                date: {type: "string"},
                                                                status: {type: "number"},
                                                                cid: {type: "number"},
                                                                paid: {type: "string"},
                                                                pid: {type: "number"}
                                                            }
                                                        }



                                                    },
                                                    pageSize: 10,
                                                    serverPaging: true,
                                                    serverFiltering: true,
                                                    serverSorting: true
                                                });



                                                jQuery("#grid").kendoGrid({
                                                    dataSource: dataSource,
                                                    filterable: true,
                                                    dataBound: restoreSelection,
                                                    pageable: {
                                                        refresh: true,
                                                        input: true,
                                                        numeric: false,
                                                        pageSizes: true,
                                                        pageSizes:[10, 50, 200, 500, 1000, 5000, 10000]
                                                    },
                                                    sortable: true,
                                                    groupable: true,
                                                    columns: [
                                                        {field: "id", title: "S.ID", width: "60px"},
                                                        {title: "Checkin Id", width: "90px", template: kendo.template($("#checkin_link").html())},
                                                        {field: "detail", title: "Detail", width: "90px"},
                                                        {field: "problem", title: "problem", width: "80px"},
                                                        {title: "Checkin Price", width: "90px", template: kendo.template($("#checkin_price").html())},
                                                        {field: "date", title: "Created", width: "50px"},
                                                        {title: "status", width: "50px", template: kendo.template($("#checkin_status").html())},
                                                        {
                                                            title: "Action", width: "60px",
                                                            template: kendo.template($("#edit_client").html())
                                                        }
                                                    ],
                                                });
                                            });

                                        </script>













                                    </div>
                                </div>
                                <!-- Default datatable -->
                                <?php /*   <div class="table-overflow">
                                  <table class="table table-striped" id="data-table">
                                  <thead>
                                  <tr>
                                  <th>#</th>
                                  <th>Checkin ID</th>
                                  <th>Detail</th>
                                  <th>Problem</th>
                                  <th>CheckIn Price</th>
                                  <th>Created</th>
                                  <th>Status</th>
                                  <th></th>
                                  </tr>
                                  </thead>
                                  <tbody>
                                  <?php
                                  if ($input_status == 1) {
                                  if (isset($_GET['from'])) {
                                  //$sql_coustomer=$obj->SelectAll_ddate("checkin_list","date",$_GET['from'],$_GET['to']);
                                  $sql_coustomer = $index->FlyQuery("select
                                  r.id,
                                  r.first_name,
                                  r.phone,
                                  r.checkin_id,
                                  r.device_id,
                                  c.`name` as device,
                                  r.model_id,
                                  cv.`name` as model,
                                  r.color_id,
                                  cvc.`name` as color,
                                  r.network_id,
                                  cn.`name` as network,
                                  r.problem_id,
                                  cp.`name` as problem,
                                  r.date,
                                  status from checkin_request as r
                                  LEFT JOIN (SELECT id,name FROM checkin) as c ON c.id=r.device_id
                                  LEFT JOIN (SELECT id,name FROM checkin_version) as cv ON cv.id=r.model_id
                                  LEFT JOIN (SELECT id,name FROM checkin_version_color) as cvc ON cvc.id=r.color_id
                                  LEFT JOIN (SELECT id,name FROM checkin_network) as cn ON cn.id=r.network_id
                                  LEFT JOIN (SELECT id,name FROM checkin_problem) as cp ON cp.id=r.problem_id
                                  WHERE r.date >= '" . $_GET['from'] . "' and r.date <= '" . $_GET['to'] . "' order by id desc ");
                                  } elseif (isset($_GET['all'])) {
                                  //$sql_coustomer=$obj->SelectAll("checkin_list");
                                  $sql_coustomer = $index->FlyQuery("select
                                  r.id,
                                  r.first_name,
                                  r.phone,
                                  r.checkin_id,
                                  r.device_id,
                                  c.`name` as device,
                                  r.model_id,
                                  cv.`name` as model,
                                  r.color_id,
                                  cvc.`name` as color,
                                  r.network_id,
                                  cn.`name` as network,
                                  r.problem_id,
                                  cp.`name` as problem,
                                  r.date,
                                  status from checkin_request as r
                                  LEFT JOIN (SELECT id,name FROM checkin) as c ON c.id=r.device_id
                                  LEFT JOIN (SELECT id,name FROM checkin_version) as cv ON cv.id=r.model_id
                                  LEFT JOIN (SELECT id,name FROM checkin_version_color) as cvc ON cvc.id=r.color_id
                                  LEFT JOIN (SELECT id,name FROM checkin_network) as cn ON cn.id=r.network_id
                                  LEFT JOIN (SELECT id,name FROM checkin_problem) as cp ON cp.id=r.problem_id order by r.id desc");
                                  } else {
                                  //$sql_coustomer=$obj->SelectAllByID("checkin_list",array("date"=>date('Y-m-d')));
                                  $sql_coustomer = $index->FlyQuery("select
                                  r.id,
                                  r.first_name,
                                  r.phone,
                                  r.checkin_id,
                                  r.device_id,
                                  c.`name` as device,
                                  r.model_id,
                                  cv.`name` as model,
                                  r.color_id,
                                  cvc.`name` as color,
                                  r.network_id,
                                  cn.`name` as network,
                                  r.problem_id,
                                  cp.`name` as problem,
                                  r.date,
                                  status from checkin_request as r
                                  LEFT JOIN (SELECT id,name FROM checkin) as c ON c.id=r.device_id
                                  LEFT JOI N (SELECT id,name FROM checkin_version) as cv ON cv.id=r.model_id
                                  LEFT JOIN (SELECT id,name FROM checkin_version_color) as cvc ON cvc.id=r.color_id
                                  LEFT JOIN (SELECT id,name FROM checkin_network) as cn ON cn.id=r.network_id
                                  LEFT JOIN (SELECT id,name FROM checkin_problem) as cp ON cp.id=r.problem_id
                                  WHERE r.date='" . date('Y-m-d') . "' order by r.id desc");
                                  }
                                  } elseif ($input_status == 5) {

                                  $sqlchain_store_ids = $obj->SelectAllByID("store_chain_admin", array("sid" => $input_by));
                                  if (!empty($sqlchain_store_ids)) {
                                  $array_ch = array();
                                  foreach ($sqlchain_store_ids as $ch):
                                  array_push($array_ch, $ch->store_id);
                                  endforeach;

                                  if (isset($_GET['from'])) {
                                  include( 'class/report_chain_admin.php');
                                  $obj_report_chain = new chain_report();
                                  $sql_coustomer = $obj_report_chain->ReportQuery_Datewise_Or("checkin_list", $array_ch, "input_by", $_GET ['from'], $_GET['to'], "1");
                                  } elseif (isset($_GET['all'])) {
                                  include('class/report_chain_admin.php');
                                  $obj_report_chain = new chain_report();
                                  $sql_coustomer = $obj_report_chain->SelectAllByID_Multiple_Or("checkin_list", $array_ch, "input_by", "1");
                                  } else {
                                  include('class/report_chain_admin.php');
                                  $obj_report_chain = new chain_report();
                                  $sql_coustomer = $obj_report_chain->SelectAllByID_Multiple2_Or("checkin_list", array("date" => date('Y-m-d')), $array_ch, "input_by", "1");
                                  }
                                  //echo "Work";
                                  } else {
                                  //echo "Not Work";
                                  $sql_coustomer = "";
                                  }
                                  } else {
                                  if (isset($_GET['from'])) {
                                  //include('class/report_customer.php');
                                  //$obj_report = new report();
                                  //$sql_coustomer=$obj_report->ReportQuery_Datewise("checkin_list",array("input_by"=>$input_by),$_GET['from'],$_GET['to'],"1");
                                  $sql_coustomer = $index->FlyQuery("select
                                  r.id,
                                  r.first_name,
                                  r.phone,
                                  r.checkin_id,
                                  r.device_id,
                                  c.`name` as device,
                                  r.model_id,
                                  cv.`name` as model,
                                  r.color_id,
                                  cvc.`name` as color,
                                  r.network_id,
                                  cn.`name` as network,
                                  r.problem_id,
                                  cp.`name` as problem,
                                  r.date,
                                  r.input_by
                                  status from checkin_request as r
                                  LEFT JOIN (SELECT id,name FROM checkin) as c ON c.id=r.device_id
                                  LEFT JOIN (SELECT id,name FROM checkin_version) as cv ON cv.id=r.model_id
                                  LEFT JOIN (SELECT id,name FROM checkin_version_color) as cvc ON cvc.id=r.color_id
                                  LEFT JOIN (SELECT id,name FROM checkin_network) as cn ON cn.id=r.network_id
                                  LEFT JOIN (SELECT id,name FROM checkin_problem) as cp ON cp.id=r.problem_id
                                  WHERE r.input_by='" . $input_by . "' AND r.date >= '" . $_GET['from'] . "' and r.date <= '" . $_GET['to'] . "' order by r.id desc ");
                                  } elseif (isset($_GET['all'])) {
                                  //$sql_coustomer=$obj->SelectAllByID("checkin_list",array("input_by"=>$input_by));
                                  $sql_coustomer = $index->FlyQuery("select
                                  r.id,
                                  r.first_name,
                                  r.phone,
                                  r.checkin_id,
                                  r.device_id,
                                  c.`name` as device,
                                  r.model_id,
                                  cv.`name` as model,
                                  r.color_id,
                                  cvc.`name` as color,
                                  r.network_id,
                                  cn.`name` as network,
                                  r.problem_id,
                                  cp.`name` as problem,
                                  r.date,
                                  r.input_by
                                  status from checkin_request as r
                                  LEFT JOIN (SELECT id,name FROM checkin) as c ON c.id=r.device_id
                                  LEFT JOIN (SELECT id,name FROM checkin_version) as cv ON cv.id=r.model_id
                                  LEFT JOIN (SELECT id,name FROM checkin_version_color) as cvc ON cvc.id=r.color_id
                                  LEFT JOIN (SELECT id,name FROM checkin_network) as cn ON cn.id=r.network_id
                                  LEFT JOIN (SELECT id,name FROM checkin_problem) as cp ON cp.id=r.problem_id
                                  WHERE r.input_by='" . $input_by . "' order by r.id desc");
                                  } else {
                                  //$sql_coustomer=$obj->SelectAllByID_Multiple("checkin_list",array("input_by"=>$input_by,"date"=>date('Y-m-d')));
                                  $sql_coustomer = $index->FlyQuery("select
                                  r.id,
                                  r.first_name,
                                  r.phone,
                                  r.checkin_id,
                                  r.device_id,
                                  c.`name` as device,
                                  r.model_id,
                                  cv.`name` as model,
                                  r.color_id,
                                  cvc.`name` as color,
                                  r.network_id,
                                  cn.`name` as network,
                                  r.problem_id,
                                  cp.`name` as problem,
                                  r.date,
                                  r.input_by
                                  status from checkin_request as r
                                  LEFT JOIN (SELECT id,name FROM checkin) as c ON c.id=r.device_id
                                  LEFT JOIN (SELECT id,name FROM checkin_version) as cv ON cv.id=r.model_id
                                  LEFT JOIN (SELECT id,name FROM checkin_version_color) as cvc ON cvc.id=r.color_id
                                  LEFT JOIN (SELECT id,name FROM checkin_network) as cn ON cn.id=r.network_id
                                  LEFT JOIN (SELECT id,name FROM checkin_problem) as cp ON cp.id=r.problem_id
                                  WHERE r.input_by='" . $input_by . "' AND r.date='" . date('Y-m-d') . "' order by r.id desc");
                                  }
                                  }






                                  $i = 1;
                                  if (!empty($sql_coustomer)) {
                                  foreach ($sql_coustomer as $ticket):
                                  if ($obj->exists_multiple("checkin_request_ticket", array("checkin_id" => $ticket->checkin_id)) != 0) {
                                  $ticket_device = str_replace(' ', '', $ticket->device);
                                  ?>
                                  <tr>
                                  <td><?php echo $i; ?></td>
                                  <td><a href="view_checkin.php?ticket_id=<?php echo $ticket->checkin_id; ?>"><?php echo $ticket->checkin_id; ?></a></td>

                                  <td><?php echo $ticket_device; ?>,
                                  <?php echo $ticket->model; ?>,
                                  <?php echo $ticket->color; ?>,
                                  <?php echo $ticket->network; ?></td>
                                  <td><?php
                                  echo $ticket->problem;
                                  $chkx = $obj->exists_multiple("check_user_price", array("ckeckin_id" => $ticket->checkin_id));
                                  if ($chkx == 0) {
                                  $estp = $obj->SelectAllByVal("product", "name", $ticket_device . "-" . $ticket->problem, "price_cost");
                                  if ($estp == '') {
                                  $devid = $ticket->device_id;
                                  $modid = $ticket->model_id;
                                  $probid = $ticket->problem_id;
                                  if ($input_status == 1)
                                  {
                                  $pp = $obj->SelectAllByVal3("checkin_price", "checkin_id", $devid, "checkin_version_id", $modid, "checkin_problem_id", $probid, "name");
                                  }
                                  else
                                  {
                                  $pp = $obj->SelectAllByVal4("checkin_price", "checkin_id", $devid, "checkin_version_id", $modid, "checkin_problem_id", $probid, "store_id", $input_by, "name");
                                  }
                                  } else {
                                  $pp = $estp;
                                  }
                                  } else {

                                  $estp = $obj->SelectAllByVal("check_user_price", "ckeckin_id", $ticket->checkin_id, "price");
                                  if ($estp == '') {
                                  $devid = $ticket->device_id;
                                  $modid = $ticket->model_id;
                                  $probid = $ticket->problem_id;
                                  if ($input_status == 1) {
                                  $pp = $obj->SelectAllByVal3("checkin_price", "checkin_id", $devid, "checkin_version_id", $modid, "checkin_problem_id", $probid, "name");
                                  } else {
                                  $pp = $obj->SelectAllByVal4("checkin_price", "checkin_id", $devid, "checkin_version_id", $modid, "checkin_problem_id", $probid, "store_id", $input_by, "name");
                                  }
                                  } else {
                                  $pp = $estp;
                                  }
                                  }
                                  if ($input_status == 1) {
                                  $pid = 0;
                                  $piddd = $obj->SelectAllByVal("product", "name", $ticket_device . ", " . $ticket->model . " - " . $ticket->problem, "id");
                                  if ($piddd != '' || $piddd != 0) {
                                  $pid = $piddd;
                                  } else {
                                  $pid = $obj->SelectAllByVal("product", "name", $ticket_device . " , " . $ticket->model . " - " . $ticket->problem, "id");
                                  }
                                  } else {
                                  $pid = 0;
                                  $piddd = $obj->SelectAllByVal2("product", "name", $ticket_device . ", " . $ticket->model . " - " . $ticket->problem, "store_id", $input_by, "id");
                                  if ($piddd != '' || $piddd != 0) {
                                  $pid = $piddd;
                                  } else {
                                  $pid = $obj->SelectAllByVal2("product", "name", $ticket_device . " , " . $ticket->model . " - " . $ticket->problem, "store_id", $input_by, "id");
                                  }
                                  }
                                  //$pin = $obj->SelectAllByVal("product", "name", $ticket_device . ", " . $ticket->model . " - " . $ticket->problem, "name");
                                  $cid = $obj->SelectAllByVal2("coustomer", "firstname", $ticket->first_name, "phone", $ticket->phone, "id");
                                  $getsales_id = $obj->SelectAllByVal("pos_checkin", "checkin_id", $ticket->checkin_id, "invoice_id");
                                  $curcheck = $obj->exists_multiple("sales", array("sales_id" => $getsales_id));
                                  $invoice_status = $obj->exists_multiple("invoice", array("invoice_id" => $getsales_id, "status" => 3));
                                  ?></td>

                                  <td>
                                  <?php if ($curcheck == 0) { ?>
                                  <a class="btn btn-info" href="pos.php?newsales=1&amp;pid=<?php echo $pid; ?>&amp;price=<?php echo number_format($pp, 2); ?>&amp;checkin_id=<?php echo $ticket->checkin_id; ?>&AMP;cid=<?php echo $cid; ?>">$<?php
                                  if ($pp == '' || $pp == 0) {
                                  echo 0;
                                  } else {
                                  echo number_format($pp, 2);
                                  }
                                  ?> Send To Pos</a>
                                  <?php
                                  } else {
                                  $expaidamountquery = $obj->SelectAllByID_Multiple("invoice_payment", array("invoice_id" => $getsales_id));
                                  $expaid = 0;
                                  if (!empty($expaidamountquery))
                                  foreach ($expaidamountquery as $paidamount):
                                  $expaid+=$paidamount->amount;
                                  endforeach;
                                  if ($expaid < $pp && $invoice_status == 1) {

                                  $duepp = $pp - $expaid;
                                  ?>
                                  <a href="pos_make_new_cart.php?cart_id=<?php echo $getsales_id; ?> " class="btn btn-warning">$ <?php echo $duepp; ?> Send To POS</a>
                                  <?php
                                  } else {
                                  ?>
                                  <span class="label label-info">$<?php
                                  if ($pp == '' || $pp == 0) {
                                  echo 0;
                                  } else {
                                  echo number_format($pp, 2);
                                  }
                                  ?> Paid</span>
                                  <?php
                                  }
                                  }
                                  ?>
                                  </td>
                                  <td><?php echo $obj->CountDate($ticket->date); //echo $pin;                                                                      ?></td>
                                  <td>
                                  <?php
                                  if ($invoice_status == 1) {
                                  echo checkin_paid(33);
                                  } else {
                                  echo checkin_paid($curcheck);
                                  }
                                  ?>
                                  </td>
                                  <td>
                                  <a href="<?php echo $obj->filename(); ?>?action=pdf&amp;invoice=<?php echo $ticket->checkin_id; ?>&amp;payment_status=<?php
                                  if ($invoice_status == 1) {
                                  echo "Partial";
                                  } else {
                                  echo checkin_paid2($curcheck);
                                  }
                                  ?>" target="_blank" class="hovertip" title="Print"  onclick="javascript:return confirm('Are you absolutely sure to Print This Checkin Request ?')"><i class="icon-print"></i></a>

                                  <?php if ($input_status == 1 || $input_status == 2 || $input_status == 5) { ?>
                                  <a href="<?php echo $obj->filename(); ?>?del=<?php echo $ticket->id; ?>" title="Delete" onclick="javascript:return confirm('Are you absolutely sure to delete This?')"><i class="icon-trash"></i></a>
                                  <?php } ?>
                                  </td>
                                  </tr>
                                  <?php
                                  $i++;
                                  }
                                  endforeach;
                                  }
                                  ?>
                                  </tbody>
                                  </table>
                                  </div> */ ?>
                                <!-- /default datatable -->


                                <!-- Content End from here customized -->



                                <div class="separator-doubled"></div>

                                <a href="<?php echo $obj->filename(); ?>?export=excel"><img src="pos_image/file_excel.png"></a>
                                <a href="<?php echo $obj->filename(); ?>?export=pdf"><img src="pos_image/file_pdf.png"></a>


                            </div>
                            <!-- /content container -->

                        </div>
                    </div>
                </div>
            </div>
            <!-- /main content -->
            <?php
            include('include/footer.php');
            echo $cms->KendoFotter();
            ?>
            <!-- /right sidebar -->

        </div>
        <!-- /main wrapper -->

    </body>
</html>
