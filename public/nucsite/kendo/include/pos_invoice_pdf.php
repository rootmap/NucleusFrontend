<?php

$cart = $_GET['invoice'];

$piqs = $obj->FlyQuery("select
a.id,
a.cid,
concat(c.firstname,' ',c.lastname) as fullname,
s.name,
c.phone,
a.invoice_creator,
a.access_id,
a.payment_type,
IFNULL(pc.checkin_id,a.checkin_id) as checkin_id,
a.invoice_id,
pt.status,
IFNULL(a.invoice_date,a.date) as invoice_date,
a.date
FROM invoice as a
LEFT JOIN (SELECT `invoice_id`,`status` FROM pos_tax) as pt on pt.invoice_id=a.invoice_id
LEFT JOIN (SELECT id,firstname,lastname,phone FROM coustomer) as c on c.id=a.cid
LEFT JOIN (SELECT id,name FROM store) as s ON s.id=a.access_id
LEFT JOIN (SELECT invoice_id,checkin_id FROM pos_checkin) as pc ON pc.invoice_id=a.invoice_id
WHERE a.invoice_id='" . $cart . "'");

$cid = $piqs[0]->cid;
$creator = $piqs[0]->invoice_creator;
$salrep_id = $piqs[0]->access_id;
$pt = $piqs[0]->payment_type;
$ckid = $piqs[0]->checkin_id;
$tax_statuss = $piqs[0]->status;
if ($tax_statuss == 0) {
    $taxs = 0;
} else {
    $taxs = $tax_per_product;
}
include("pdf/MPDF57/mpdf.php");
if ($_GET['print'] == 1) {
    $html.="<table id='sample-table-2' class='table table-hover' border='1'><tbody>";
} else {
    $html.="<table id='sample-table-2' class='table table-hover' width='100% !important'><tbody>";
}
$rcq = $obj->FlyQuery("select
a.id,
a.store_id,
a.name,
a.address,
a.phone,
a.email,
a.fotter
FROM setting_report as a
WHERE a.store_id='" . $input_by . "'");

$report_cpmpany_name = $rcq[0]->name;
$report_cpmpany_address = $rcq[0]->address;
$report_cpmpany_phone = $rcq[0]->phone;
$report_cpmpany_email = $rcq[0]->email;
$report_cpmpany_fotter = $rcq[0]->fotter;

function limit_words($string, $word_limit) {
    $words = explode(" ", $string);
    return implode(" ", array_splice($words, 0, $word_limit));
}

$addressfline = limit_words($report_cpmpany_address, 3);
$lengthaddress = strlen($addressfline);
$lastaddress = substr($report_cpmpany_address, $lengthaddress, 30000);

if ($_GET['print'] == 1) {
    $html .="<tr>
                <td style='height:40px; background:rgba(0,51,153,1);'>
                <table style='width:100%; height:40px; border:0px;'>
                <tr>
                <td width='87%' style='background:rgba(0,51,153,1);  color:#FFF; font-size:30px;'>" . $report_cpmpany_name . "</td><td width='13%' style='background:rgba(0,51,153,1);  color:#FFF; font-size:30px;'><span style='float:left; text-align:left;'>Invoice</span></td>
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
                Name : " . $piqs[0]->fullname . " <br />
                Phone : " . $piqs[0]->phone . " <br />
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
                INVOICE DATE : " . $piqs[0]->invoice_date . " <br />
                ORDER NO. : " . $cart . "<br />
                SALES REP : " . $piqs[0]->name . " <br />
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
                <td>Product</td>
                <td>Description</td>

                <td>Quantity</td>
                <td>Unit Cost</td>
                <td>Tax</td>
                <td>Extended</td>
                </tr></thead>";
    $sqlsaleslist = $obj->SelectAllByID($table2, array("sales_id" => $cart));
    $sss = 1;
    $subtotal = 0;
    $tax = 0;
    if (!empty($sqlsaleslist))
        foreach ($sqlsaleslist as $saleslist):
            $caltax = ($saleslist->single_cost * $tax_per_product) / 100;
            $procost = $saleslist->quantity * $saleslist->single_cost;
            $subtotal+=$procost;
            $tax_status = $obj->SelectAllByVal("pos_tax", "invoice_id", $cart, "status");

            if ($tax_status == 0) {
                $tax+=0;
                $taxst = "No";
                $taxstn = "1";
                $extended = $procost;
            } else {
                $tax+=$caltax * $saleslist->quantity;
                $taxst = "Yes";
                $taxstn = "0";
                $extended = $procost + $caltax;
            }

            $html.="<thead><tr>
                <td>" . $sss . "</td>
                <td>" . $obj->SelectAllByVal($table, "id", $saleslist->pid, "name") . "</td>
                <td>" . $obj->SelectAllByVal($table, "id", $saleslist->pid, "name") . "</td>

                <td>" . $saleslist->quantity . "</td>
                <td><button type='button' class='btn'>$" . $saleslist->single_cost . "</button></td>
                <td>$" . $caltax . "</td>
                <td>
                <button type='button' class='btn'>$" . $extended . "</button>
                </td>
                </tr></thead>";

            $sss++;
        endforeach;
    if ($pt == 0) {
        $pp = "Not Paid";
    } else {
        $pp = $obj->SelectAllByVal("payment_method", "id", $pt, "meth_name");
    }


    $sqlbuyback = $obj->exists_multiple("buyback", array("pos_id" => $cart));
    if ($sqlbuyback == 0) {
        $tradein = 0;
    } else {
        $tradein = $obj->SelectAllByVal("buyback", "pos_id", $cart, "price");
    }

    $total = ($subtotal + $tax) - $tradein;
    if ($paid != 0) {
        $dd = number_format($total, 2);
    } else {
        $dd = "$0.00";
    }

    if ($paid != 0) {
        $ff = "$0.00";
    } else {

        $ff = number_format($total, 2);
    }

    $paid = 0;
    $sqlpp = $obj->SelectAllByID_Multiple("invoice_payment", array("invoice_id" => $cart));
    if (!empty($sqlpp)) {
        foreach ($sqlpp as $pps):
            $paid+=$pps->amount;
        endforeach;
    }
    else {
        $paid+=0;
    }
    
    

    $dues = $total - $paid;
    if (substr($dues, 0, 1)=="-") {
        $due = 0;
    } else {
        $due = number_format($dues,2);
    }
    
    $html.="</table></td></tr>";
    if ($ckid != 0) {

        $html.="<tr><td><table style='width:960px;'>
                <thead>
                <tr>
                <td width='350' valign='top'>";


        if ($obj->exists_multiple("checkin_request_ticket", array("checkin_id" => $ckid)) == 0) {

            $cstq = $obj->FlyQuery("SELECT
                a.ticket_id,
                a.imei,
                a.carrier,
                a.type_color,
                a.problem_type,
                p.name as problem
                FROM `ticket` as a
                LEFT JOIN problem_type as p ON p.id=a.problem_type
                WHERE
                a.ticket_id='" . $ckid . "'");

            $html.="<table style='width:300px;border:1px; margin-left:-4px; font-size:12px; background:#ccc;'>
                <thead>
                <tr>
                <th>IMEI of Device being repair : </th>
                <th>" . $cstq[0]->imei . "</th>
                </tr>

                <tr>
                <th>Carrier : </th>
                <th>" . $cstq[0]->carrier . "</th>
                </tr>
                <tr>
                <th>Color : </th>
                <th>" . $cstq[0]->type_color . "</th>
                </tr>
                <tr>
                <th>Problem : </th>
                <th>" . $cstq[0]->problem . "</th>
                </tr>
                </thead>
                </table>";
        } else {

            $cscq = $obj->FlyQuery("SELECT
                a.checkin_id,
                n.name as network,
                v.name as color,
                p.name as problem,
                c.imei,
                c.password
                FROM
                checkin_request as a
                LEFT JOIN checkin_request_ticket as c on c.checkin_id=a.checkin_id
                LEFT JOIN checkin_network as n ON n.id=a.network_id
                LEFT JOIN checkin_version_color as v ON v.id=a.color_id
                LEFT JOIN checkin_problem as p ON p.id=a.problem_id
                WHERE a.checkin_id='" . $ckid . "'");

            $html.="<table style='width:300px;border:1px; margin-left:-4px; font-size:12px; background:#ccc;'>
                <thead>
                <tr>
                <th>IMEI of Device being repair: </th>
                <th>" . $cscq[0]->imei . "</th>
                </tr>";

            if ($input_by == "1430934079") {
                $html.="<tr>
                <th>Password : </th>
                <th>" . $cscq[0]->password . "</th>
                </tr>";
            }

            $html.="<tr>
                <th>Carrier: </th>
                <th>" . $cscq[0]->network . "</th>
                </tr>
                <tr>
                <th>Color: </th>
                <th>" . $cscq[0]->color . "</th>
                </tr>
                <tr>
                <th>Problem: </th>
                <th>" . $cscq[0]->problem . "</th>
                </tr>
                </thead>
                </table>";
        }
        $html.="</td>
                <td>
                <table style='width:250px;border:1px; font-size:12px; background:#ccc;'>
                <thead>
                <tr>
                <th>Payment Type: </th>
                <th>" . $pp . "</th>
                </tr>
                <tr>
                <th>Sub - Total: </th>
                <th>" . number_format($subtotal, 2) . "</th>
                </tr>
                <tr>
                <th>Tax: </th>
                <th>" . number_format($tax, 2) . "</th>
                </tr>";

        $sqlbuybackpdf = $obj->exists_multiple("buyback", array("pos_id" => $cart));
        if ($sqlbuybackpdf == 0) {
            $tradeinpdf = 0;
        } else {
            $tradeinpdf = $obj->SelectAllByVal("buyback", "pos_id", $cart, "price");
            $html.="<tr>
                <th>Buyback: </th>
                <th>" . number_format($tradeinpdf, 2) . "</th>
                </tr>";
        }

        $html.="<tr>
                <th>Total: </th>
                <th>" . number_format($total, 2) . "</th>
                </tr>
                <tr>
                <th>Payments: </th>
                <th>" . $paid . "</th>
                </tr>
                <tr>
                <th>Balance Due: </th>
                <th>";

        if (substr($due, 0, 1) == "-") {
            $html.="0";
        } else {
            $html.=number_format($due,2);
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
                <th>" . $pp . "</th>
                </tr>
                <tr>
                <th>Sub - Total: </th>
                <th>" . number_format($subtotal, 2) . "</th>
                </tr>
                <tr>
                <th>Tax: </th>
                <th>" . number_format($tax, 2) . "</th>
                </tr>";
        $sqlbuybackpdf = $obj->exists_multiple("buyback", array("pos_id" => $cart));
        if ($sqlbuybackpdf == 0) {
            $tradeinpdf = 0;
        } else {
            $tradeinpdf = $obj->SelectAllByVal("buyback", "pos_id", $cart, "price");
            $html.="<tr>
                <th>Buyback: </th>
                <th>" . number_format($tradeinpdf, 2) . "</th>
                </tr>";
        }

        $html.="<tr>
                <th>Total: </th>
                <th>" . number_format($total, 2) . "</th>
                </tr>
                <tr>
                <th>Payments: </th>
                <th>" . $paid . "</th>
                </tr>
                <tr>
                <th>Balance Due: </th>
                <th>";

        if (substr($due, 0, 1) == "-") {
            $html.="0";
        } else {
            $html.=number_format($due,2);
        }

        $html.="</th>
                </tr>
                </thead></table></td></tr>";
    }

    if ($obj->exists_multiple("invoice_payment", array("invoice_id" => $cart)) != 0) {
        $html.="<tr><td>
                <br />
                <h3> Transaction Detail </h3>
                <table style='width:100%;border:1px; font-size:12px; background:#ccc;'>";
        $html.="<thead><tr>
                <td> S/L </td>
                <td>Payment Method</td>
                <td>Amount</td>
                <td>Date</td>
                </tr></thead>";
        $sqlsaleslist = $obj->SelectAllByID("invoice_payment", array("invoice_id" => $cart));
        $sss = 1;
        if (!empty($sqlsaleslist))
            foreach ($sqlsaleslist as $saleslist):

                $html.="<thea d><tr>
                <td>" . $sss . "</td>
                <td>" . $obj->SelectAllByVal("payment_method", "id", $saleslist->payment_type, "meth_name") . "</td>
                <td>$" . $saleslist->amount . "</td>
                <td>" . $saleslist->date . "</td></tr></thead>";

                $sss++;
            endforeach;
        $html.="</table></td></tr>";
    }
    
    if (floatval ($paid) ==floatval ($total)) {
        $color = "#09f;";
        $invoicest="Paid";
    } elseif (floatval ($paid)<floatval ($total)) {
        $color = "#FF8C00;";
        $invoicest="Partial";
    } elseif (floatval ($paid)>floatval ($total)) {
        $color = "#09f;";
        $invoicest="Paid";      
    } else {
        $color = "#f00";
        $invoicest="Unpaid";
    } 
    
    $html.= "<tr><td align='center' style='color:" . $color . "'><h1 style='width:60%; font-size:100px; display:block; margin-left:auto; margin-right:auto; border:3px " . $color . " solid;'>" . $invoicest . "</h1></td></tr>";

    
}
elseif ($_GET['print'] == 2) {
    //barcode print
    $sqlsaleslist = $obj->SelectAllByID($table2, array("sales_id" => $cart));
    $sss = 1;
    $subtotal = 0;
    $tax = 0;


    //$obj->SelectAllByVal($table, "id", $saleslist->pid, "name");
    if (!empty($sqlsaleslist))
        foreach ($sqlsaleslist as $saleslist):
            $caltax = ($saleslist->single_cost * $tax_per_product) / 100;
            $procost = $saleslist->quantity * $saleslist->single_cost;
            $subtotal+=$procost;
            $tax_status = $obj->SelectAllByVal("pos_tax", "invoice_id", $cart, "status");

            if ($tax_status == 0) {
                $tax+=0;
                $taxst = "No";
                $taxstn = "1";
                $extended = $procost;
            } else {
                $tax+=$caltax * $saleslist->quantity;
                $taxst = "Yes";
                $taxstn = "0";
                $extended = $procost + $caltax;
            }
            $sss++;
        endforeach;

    $paid = 0;
    $sqlpp = $obj->SelectAllByID_Multiple("invoice_payment", array("invoice_id" => $cart));
    if (!empty($sqlpp)) {
        foreach ($sqlpp as $pps):
            $paid+=$pps->amount;
        endforeach;
    }
    else {
        $paid+=0;
    }

    if ($pt == 0) {
        $pp = "Not Paid";
    } else {
        $pp = $obj->SelectAllByVal("payment_method", "id", $pt, "meth_name");
    }


    $sqlbuyback = $obj->exists_multiple("buyback", array("pos_id" => $cart));
    if ($sqlbuyback == 0) {
        $tradein = 0;
    } else {
        $tradein = $obj->SelectAllByVal("buyback", "pos_id", $cart, "price");
    }

    if ($subtotal == 0) {
        $subtotal = $paid;
    }

    $total = ($subtotal + $tax) - $tradein;
    if ($paid != 0) {
        $dd = number_format($total, 2);
    } else {
        $dd = "$0.00";
    }

    if ($paid != 0) {
        $ff = "$0.00";
    } else {

        $ff = number_format($total, 2);
    }



    $dues = $total - $paid;
    if (substr($dues, 0, 1)=="-") {
        $due = 0;
    } else {
        $due = number_format($due,2);
    }






    if ($ckid != 0) {

        $html.="<tr>
                    <td align='center'><img src='class/barcode/test_1D.php?text=" . $cart . "' style='margin-top:-50px;' alt='barcode' height='155' /> </td>
                    </tr><tr><td>";




        if ($obj->exists_multiple("checkin_request_ticket", array("checkin_id" => $ckid)) == 0) {

            $cstq = $obj->FlyQuery("SELECT
                a.ticket_id,
                a.imei,
                a.carrier,
                a.type_color,
                a.problem_type,
                p.name as problem
                FROM `ticket` as a
                LEFT JOIN problem_type as p ON p.id=a.problem_type
                WHERE
                a.ticket_id='" . $ckid . "'");

            $html.="<table style='width:100% !important; border:1px; margin-left:-4px; font-size:20px; background:#ccc;'>
                <thead>
                

                <tr>
                <th colspan='2'>IMEI of Device being repair : </th>
                </tr>
                
                <tr>
                <th colspan='2'>" . $cstq[0]->imei . "</th>
                </tr>
                
                <tr>
                <th colspan='2'>Customer Name: </th>
                </tr>
                <tr>
                <th colspan='2'>" . $piqs[0]->fullname . " </th>
                </tr>
                <tr>
                <th colspan='2'>Customer Phone: </th>
                </tr>
                <tr>
                <th colspan='2'>" . $piqs[0]->phone . " </th>
                </tr>

                <tr>
                <th width='50%'>Carrier : </th>
                <th width='50%'>" . $cstq[0]->carrier . "</th>
                </tr>
                <tr>
                <th>Color : </th>
                <th>" . $cstq[0]->type_color . "</th>
                </tr>
                <tr>
                <th>Problem : </th>
                <th>" . $cstq[0]->problem . "</th>
                </tr>
                </thead>
                </table>";
        } else {

            $cscq = $obj->FlyQuery("SELECT
                a.checkin_id,
                n.name as network,
                v.name as color,
                p.name as problem,
                c.imei,
                c.password
                FROM
                checkin_request as a
                LEFT JOIN checkin_request_ticket as c on c.checkin_id=a.checkin_id
                LEFT JOIN checkin_network as n ON n.id=a.network_id
                LEFT JOIN checkin_version_color as v ON v.id=a.color_id
                LEFT JOIN checkin_problem as p ON p.id=a.problem_id
                WHERE a.checkin_id='" . $ckid . "'");

            $html.="<table style='width:100%;border:1px; margin-left:-4px; font-size:20px; background:#ccc;'>
                <thead>
                
                <tr>
                <th colspan='2'>IMEI of Device being repair : </th>
                </tr>
                
                <tr>
                <th colspan='2'>" . $cscq[0]->imei . "</th>
                </tr>
                
                <tr>
                <th colspan='2'>Customer Name: </th>
                </tr>
                <tr>
                <th colspan='2'>" . $piqs[0]->fullname . " </th>
                </tr>
                <tr>
                <th colspan='2'>Customer Phone: </th>
                </tr>
                <tr>
                <td colspan='2'>" . $piqs[0]->phone . " </td>
                </tr>";

            if ($input_by == "1430934079") {
                $html.="<tr>
                <th  width='50%'>Password : </th>
                <th  width='50%'>" . $cscq[0]->password . "</th>
                </tr>";
            }

            $html.="<tr>
                <th width='50%'>Carrier: </th>
                <th width='50%'>" . $cscq[0]->network . "</th>
                </tr>
                <tr>
                <th>Color: </th>
                <th>" . $cscq[0]->color . "</th>
                </tr>
                <tr>
                <th>Problem: </th>
                <th>" . $cscq[0]->problem . "</th>
                </tr>
                </thead>
                </table>";
        }
        $html.="<table style='width:100% !important; margin-top:10px; border:1px; font-size:20px; background:#ccc;'>
                <thead>
                <tr>
                <th width='50%'>Payment Type: </th>
                <th width='50%'>" . $pp . "</th>
                </tr>
                <tr>
                <th>Sub - Total: </th>
                <th>" . number_format($subtotal, 2) . "</th>
                </tr>
                <tr>
                <th>Tax: </th>
                <th>" . number_format($tax, 2) . "</th>
                </tr>";

        $sqlbuybackpdf = $obj->exists_multiple("buyback", array("pos_id" => $cart));
        if ($sqlbuybackpdf == 0) {
            $tradeinpdf = 0;
        } else {
            $tradeinpdf = $obj->SelectAllByVal("buyback", "pos_id", $cart, "price");
            $html.="<tr>
                <th>Buyback: </th>
                <th>" . number_format($tradeinpdf, 2) . "</th>
                </tr>";
        }

        $html.="<tr>
                <th>Total: </th>
                <th>" . number_format($total, 2) . "</th>
                </tr>
                <tr>
                <th>Payments: </th>
                <th>" . $paid . "</th>
                </tr>
                <tr>
                <th>Balance Due: </th>
                <th>";

        if (substr($due, 0, 1) == "-") {
            $html.="0";
        } else {
            $html.=number_format($due,2);
        }

        $html.="</th>
                </tr>
                </thead>
                </table>";
    } else {

        $html.="<h3>&nbsp;</h3><table style='width:100% !important; border:1px; margin-top:10px; font-size:20px; background:#ccc;'><thead>
                <tr>
                <th>Payment Type: </th>
                <th>" . $pp . "</th>
                </tr>
                <tr>
                <th>Sub - Total: </th>
                <th>" . number_format($subtotal, 2) . "</th>
                </tr>
                <tr>
                <th>Tax: </th>
                <th>" . number_format($tax, 2) . "</th>
                </tr>";
        $sqlbuybackpdf = $obj->exists_multiple("buyback", array("pos_id" => $cart));
        if ($sqlbuybackpdf == 0) {
            $tradeinpdf = 0;
        } else {
            $tradeinpdf = $obj->SelectAllByVal("buyback", "pos_id", $cart, "price");
            $html.="<tr>
                <th>Buyback: </th>
                <th>" . number_format($tradeinpdf, 2) . "</th>
                </tr>";
        }

        $html.="<tr>
                <th>Total: </th>
                <th>" . number_format($total, 2) . "</th>
                </tr>
                <tr>
                <th>Payments: </th>
                <th>" . $paid . "</th>
                </tr>
                <tr>
                <th>Balance Due: </th>
                <th>";

        if (substr($due, 0, 1) == "-") {
            $html.="0";
        } else {
            $html.=number_format($due,2);
        }

        $html.="</th></tr>
                </thead></table>";
    }

    $html.="</td></tr><tr><td>";

    if ($obj->exists_multiple("invoice_payment", array("invoice_id" => $cart)) != 0) {
        $html.="<h3> Transaction Detail </h3>
                <table style='width:100%;border:1px; font-size:20px; background:#ccc;'>";
        $html.="<tbody><tr>
                <td> S/L </td>
                <td>Payment</td>
                <td>Amount</td>
                <td>Date</td>
                </tr></tbody>";
        $sqlsaleslist = $obj->SelectAllByID("invoice_payment", array("invoice_id" => $cart));
        $sss = 1;
        if (!empty($sqlsaleslist))
            foreach ($sqlsaleslist as $saleslist):

                $html.="<tbody><tr>
                <td>" . $sss . "</td>
                <td>" . $obj->SelectAllByVal("payment_method", "id", $saleslist->payment_type, "meth_name") . "</td>
                <td>$" . $saleslist->amount . "</td>
                <td>" . $saleslist->date . "</td></tr></tbody>";

                $sss++;
            endforeach;
        $html.="</table>";
    }

    $html.="</td></tr>";
    
    if (floatval ($paid) ==floatval ($total)) {
        $color = "#09f;";
        $invoicest="Paid";
    } elseif (floatval ($paid)<floatval ($total)) {
        $color = "#FF8C00;";
        $invoicest="Partial";
    } elseif (floatval ($paid)>floatval ($total)) {
        $color = "#09f;";
        $invoicest="Paid";      
    } else {
        $color = "#f00";
        $invoicest="Unpaid";
    } 
    
    $html.= "<tr><td align='center' style='color:" . $color . "'><h1 style='width:60%; font-size:100px; display:block; margin-left:auto; margin-right:auto; border:3px " . $color . " solid;'>" . $invoicest . "</h1></td></tr>";

    
    //barcode print
}
elseif ($_GET['print'] == 3) {
    //thermal print opt
    
    $sqlsaleslist = $obj->SelectAllByID($table2, array("sales_id" => $cart));
    
    $sss = 1;
    $subtotal = 0;
    $tax = 0;

    //$obj->SelectAllByVal($table, "id", $saleslist->pid, "name");
    if (!empty($sqlsaleslist))
    {
        $html.="<tr><td><table style='width:100%; border:1px; font-size:20px; background:#ccc;'><tbody>";
        
        $html.="<tr>
                <th colspan='2'>Customer Name: </th>
                </tr>
                <tr>
                <th colspan='2'>" . $piqs[0]->fullname . " </th>
                </tr>
                <tr>
                <th colspan='2'>Customer Phone: </th>
                </tr>
                <tr>
                <th colspan='2'>" . $piqs[0]->phone . " </th>
                </tr>";
        
        foreach ($sqlsaleslist as $saleslist):
            $caltax = ($saleslist->single_cost * $tax_per_product) / 100;
            $procost = $saleslist->quantity * $saleslist->single_cost;
            $subtotal+=$procost;
            $tax_status = $obj->SelectAllByVal("pos_tax", "invoice_id", $cart, "status");

            if ($tax_status == 0) {
                $tax+=0;
                $taxst = "No";
                $taxstn = "1";
                $extended = $procost;
            } else {
                $tax+=$caltax * $saleslist->quantity;
                $taxst = "Yes";
                $taxstn = "0";
                $extended = $procost + $caltax;
            }
            
            $html.="<tr><th colspan='2'>Product Name </th></tr>
                    <tr><th colspan='2'>" . $obj->SelectAllByVal($table, "id", $saleslist->pid, "name") . "</th></tr>

                    <tr><th>Quantity</th><th>" . $saleslist->quantity . "</th></tr>
                    <tr><th>Unit Cost</th><th>$" . $saleslist->single_cost . "</th></tr>
                    <tr><th>Tax</th><th>$" . $caltax . "</th></tr>
                    <tr><th>Total</th><th>$" . $extended . "</th></tr>";
            
            
            $sss++;
        endforeach;
        
        $html.="</tbody></table>";
        
    }

    $paid = 0;
    $sqlpp = $obj->SelectAllByID_Multiple("invoice_payment", array("invoice_id" => $cart));
    if (!empty($sqlpp)) {
        foreach ($sqlpp as $pps):
            $paid+=$pps->amount;
        endforeach;
    }
    else {
        $paid+=0;
    }

    if ($pt == 0) {
        $pp = "Not Paid";
    } else {
        $pp = $obj->SelectAllByVal("payment_method", "id", $pt, "meth_name");
    }


    $sqlbuyback = $obj->exists_multiple("buyback", array("pos_id" => $cart));
    if ($sqlbuyback == 0) {
        $tradein = 0;
    } else {
        $tradein = $obj->SelectAllByVal("buyback", "pos_id", $cart, "price");
    }

    if ($subtotal == 0) {
        $subtotal = $paid;
    }

    $total = ($subtotal + $tax) - $tradein;
    if ($paid != 0) {
        $dd = number_format($total, 2);
    } else {
        $dd = "$0.00";
    }

    if ($paid != 0) {
        $ff = "$0.00";
    } else {

        $ff = number_format($total, 2);
    }



    $dues = $total - $paid;
    if (substr($dues, 0, 1)=="-") {
        $due = 0;
    } else {
        $due = number_format($due,2);
    }






    if ($ckid != 0) {

        $html.="<tr><th>";




        if ($obj->exists_multiple("checkin_request_ticket", array("checkin_id" => $ckid)) == 0) {

            $cstq = $obj->FlyQuery("SELECT
                a.ticket_id,
                a.imei,
                a.carrier,
                a.type_color,
                a.problem_type,
                p.name as problem
                FROM `ticket` as a
                LEFT JOIN problem_type as p ON p.id=a.problem_type
                WHERE
                a.ticket_id='" . $ckid . "'");

            $html.="<table style='width:100% !important; border:1px; margin-left:-4px; font-size:20px; background:#ccc;'>
                <tbody>
                

                <tr>
                <th colspan='2'>IMEI of Device being repair : </th>
                </tr>
                
                <tr>
                <th colspan='2'>" . $cstq[0]->imei . "</th>
                </tr>
                <tr>
                <th width='50%'>Carrier : </th>
                <th width='50%'>" . $cstq[0]->carrier . "</th>
                </tr>
                <tr>
                <th>Color : </th>
                <th>" . $cstq[0]->type_color . "</th>
                </tr>
                <tr>
                <th>Problem : </th>
                <th>" . $cstq[0]->problem . "</th>
                </tr>
                </tbody>
                </table>";
        } else {

            $cscq = $obj->FlyQuery("SELECT
                a.checkin_id,
                n.name as network,
                v.name as color,
                p.name as problem,
                c.imei,
                c.password
                FROM
                checkin_request as a
                LEFT JOIN checkin_request_ticket as c on c.checkin_id=a.checkin_id
                LEFT JOIN checkin_network as n ON n.id=a.network_id
                LEFT JOIN checkin_version_color as v ON v.id=a.color_id
                LEFT JOIN checkin_problem as p ON p.id=a.problem_id
                WHERE a.checkin_id='" . $ckid . "'");

            $html.="<table style='width:100%;border:1px; margin-left:-4px; font-size:20px; background:#ccc;'>
                <tbody>
                
                <tr>
                <th colspan='2'>IMEI of Device being repair : </th>
                </tr>
                
                <tr>
                <th colspan='2'>" . $cscq[0]->imei . "</th>
                </tr>";

            if ($input_by == "1430934079") {
                $html.="<tr>
                <th  width='50%'>Password : </th>
                <th  width='50%'>" . $cscq[0]->password . "</th>
                </tr>";
            }

            $html.="<tr>
                <th width='50%'>Carrier: </th>
                <th width='50%'>" . $cscq[0]->network . "</th>
                </tr>
                <tr>
                <th>Color: </th>
                <th>" . $cscq[0]->color . "</th>
                </tr>
                <tr>
                <th>Problem: </th>
                <th>" . $cscq[0]->problem . "</th>
                </tr>
                </tbody>
                </table>";
        }
        $html.="<table style='width:100% !important; margin-top:10px; border:1px; font-size:20px; background:#ccc;'>
                <tbody>
                <tr>
                <th width='50%'>Payment Type: </th>
                <th width='50%'>" . $pp . "</th>
                </tr>
                <tr>
                <th>Sub - Total: </th>
                <th>" . number_format($subtotal, 2) . "</th>
                </tr>
                <tr>
                <th>Tax: </th>
                <th>" . number_format($tax, 2) . "</th>
                </tr>";

        $sqlbuybackpdf = $obj->exists_multiple("buyback", array("pos_id" => $cart));
        if ($sqlbuybackpdf == 0) {
            $tradeinpdf = 0;
        } else {
            $tradeinpdf = $obj->SelectAllByVal("buyback", "pos_id", $cart, "price");
            $html.="<tr>
                <th>Buyback: </th>
                <th>" . number_format($tradeinpdf, 2) . "</th>
                </tr>";
        }

        $html.="<tr>
                <th>Total: </th>
                <th>" . number_format($total, 2) . "</th>
                </tr>
                <tr>
                <th>Payments: </th>
                <th>" . $paid . "</th>
                </tr>
                <tr>
                <th>Balance Due: </th>
                <th>";

        if (substr($due, 0, 1) == "-") {
            $html.="0";
        } else {
            $html.=number_format($due,2);
        }

        $html.="</th>
                </tr>
                </tbody>
                </table>";
    } else {

        $html.="<h3>&nbsp;</h3>
            <table style='width:100% !important; border:1px; margin-top:10px; font-size:20px; background:#ccc;'>
            <tbody>
                <tr>
                <th>Payment Type: </th>
                <th>" . $pp . "</th>
                </tr>
                <tr>
                <th>Sub - Total: </th>
                <th>" . number_format($subtotal, 2) . "</th>
                </tr>
                <tr>
                <th>Tax: </th>
                <th>" . number_format($tax, 2) . "</th>
                </tr>";
        $sqlbuybackpdf = $obj->exists_multiple("buyback", array("pos_id" => $cart));
        if ($sqlbuybackpdf == 0) {
            $tradeinpdf = 0;
        } else {
            $tradeinpdf = $obj->SelectAllByVal("buyback", "pos_id", $cart, "price");
            $html.="<tr>
                <th>Buyback: </th>
                <th>" . number_format($tradeinpdf, 2) . "</th>
                </tr>";
        }

        $html.="<tr>
                <th>Total: </th>
                <th>" . number_format($total, 2) . "</th>
                </tr>
                <tr>
                <th>Payments: </th>
                <th>" . $paid . "</th>
                </tr>
                <tr>
                <th>Balance Due: </th>
                <th>";

        if (substr($due, 0, 1) == "-") {
            $html.="0";
        } else {
            $html.=$due;
        }

        $html.="</th></tr></tbody></table>";
    }

    $html.="</th></tr><tr><th>";

    if ($obj->exists_multiple("invoice_payment", array("invoice_id" => $cart)) != 0) {
        $html.="<h3> Transaction Detail </h3>
                <table style='width:100%; border:1px; margin-bottom:20px; font-size:20px; background:#ccc;'>";
        $html.="<tbody><tr>
                <th> S/L </th>
                <th>Payment</th>
                <th>Amount</th>
                <th>Date</th>
                </tr></tbody>";
        $sqlsaleslist = $obj->SelectAllByID("invoice_payment", array("invoice_id" => $cart));
        $sss = 1;
        if (!empty($sqlsaleslist))
            foreach ($sqlsaleslist as $saleslist):

                $html.="<tbody><tr>
                <th>" . $sss . "</th>
                <th>" . $obj->SelectAllByVal("payment_method", "id", $saleslist->payment_type, "meth_name") . "</th>
                <th>$" . $saleslist->amount . "</th>
                <th>" . $saleslist->date . "</th></tr></tbody>";

                $sss++;
            endforeach;
        $html.="</table>";
    }
//E:\server\htdocs\Dropbox\account_nucleus\include\pos_invoice_pdf.php
    $html.="</th></tr>";
    
    if (floatval ($paid) ==floatval ($total)) {
        $color = "#09f;";
        $invoicest="Paid";
    } elseif (floatval ($paid)<floatval ($total)) {
        $color = "#FF8C00;";
        $invoicest="Partial";
    } elseif (floatval ($paid)>floatval ($total)) {
        $color = "#09f;";
        $invoicest="Paid";    
    } else {
        $color = "#f00";
        $invoicest="Unpaid";
    } 
    
    $html.= "<tr><td align='center' style='color:" . $color . "'><h1 style='width:60%; font-size:100px; display:block; margin-left:auto; margin-right:auto; border:3px " . $color . " solid;'>" . $invoicest . "</h1></td></tr>";

    
    //thermal print opt
}



if($_GET['print']=="1")
{
     
    
    $html.="<tr>
        <th align='center' style='font-size:8px; padding-top:10px;'>" . $report_cpmpany_fotter . "</th>
        </tr>";
}
$html.="<tr>
        <th align='center' style='font-size:20px;'>Thank You For Your Business</th>
        </tr>";
$html.="</tbody></table>";


$possetting = $obj->FlyQuery("SELECT * FROM `pos_print_setting` WHERE store_id='" . $input_by . "'");
if ($_GET['print'] == 1) {
//    if (empty($possetting[0]->width)) {
//        $pw = "150";
//    } else {
//        $pw = $possetting[0]->width;
//    }
//
//    if (empty($possetting[0]->height)) {
//        $ph = "230";
//    } else {
//        $ph = $possetting[0]->height;
//    }
    $mpdf = new mPDF('c', 'A4', '', '', 32, 25, 27, 25, 16, 13);
    //$mpdf = new mPDF('utf-8', array($pw, $ph));
    $mpdf->SetDisplayMode('fullpage');

    $mpdf->list_indent_first_level = 0; // 1 or 0 - whether to indent the first level of a list
    // LOAD a stylesheet
    $stylesheet = file_get_contents('pdf/MPDF57/examples/mpdfstyletables.css');
    $mpdf->WriteHTML($stylesheet, 1); // The parameter 1 tells that this is css/style only and no body/html/text

    $mpdf->WriteHTML($html,2);

    $mpdf->Output('invoicenucleuspos.pdf', 'I');
} elseif ($_GET['print'] == 2) {
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

    $mpdf->list_indent_first_level = 0; // 1 or 0 - whether to indent the first level of a list
    // LOAD a stylesheet
    $stylesheet = file_get_contents('pdf/MPDF57/examples/mpdfstyletables.css');
    $mpdf->WriteHTML($stylesheet, 1); // The parameter 1 tells that this is css/style only and no body/html/text

    $mpdf->WriteHTML($html, 2);

    $mpdf->Output('invoicenucleuspos.pdf', 'I');
} elseif ($_GET['print'] == 3) {
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

    $mpdf->list_indent_first_level = 0; // 1 or 0 - whether to indent the first level of a list
    // LOAD a stylesheet
    $stylesheet = file_get_contents('pdf/MPDF57/examples/mpdfstyletables.css');
    $mpdf->WriteHTML($stylesheet, 1); // The parameter 1 tells that this is css/style only and no body/html/text

    $mpdf->WriteHTML($html, 2);

    $mpdf->Output('invoicenucleuspos.pdf', 'I');
}




//$mpdf->SetDisplayMode('fullpage');
?>