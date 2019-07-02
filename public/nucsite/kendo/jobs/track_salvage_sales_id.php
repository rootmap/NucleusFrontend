<?php

include '../class/auth.php';
$sqlprepare = "SELECT 
s.sales_id,i.checkin_id 
FROM 
`sales` as s 
LEFT JOIN invoice as i ON i.invoice_id=s.sales_id 
WHERE 
s.sales_id 
NOT IN (SELECT sales_id FROM sold_salvage ORDER BY id DESC) ORDER BY s.id DESC LIMIT 10";
$sql = $obj->FlyQuery($sqlprepare);
//print_r($sql);
if (!empty($sql)) {
    foreach ($sql as $row):
        $sales_id = $row->sales_id;
        $checkin_id = $row->checkin_id;
        if ($checkin_id == 0) {
            $obj->FlyPrepare("INSERT INTO sold_salvage SET sales_id='" . $sales_id . "'");
            $obj->FlyPrepare("UPDATE sales SET salvage_part='0' WHERE sales_id='" . $sales_id . "'");
        } else {
            $chksql = "SELECT * FROM invoice AS i 
        WHERE 
        i.checkin_id IN (SELECT crt.checkin_id FROM checkin_request_ticket as crt WHERE crt.salvage_part='1') 
        AND i.invoice_id='" . $sales_id . "' AND checkin_id!='0'";
            $chk = $obj->FlyQuery($chksql, "1");
            if ($chk == 1) {
                $obj->FlyPrepare("INSERT INTO sold_salvage SET sales_id='" . $sales_id . "'");
                $obj->FlyPrepare("UPDATE sales SET salvage_part='1' WHERE sales_id='" . $sales_id . "'");
            } else {
                $obj->FlyPrepare("INSERT INTO sold_salvage SET sales_id='" . $sales_id . "'");
                $obj->FlyPrepare("UPDATE sales SET salvage_part='0' WHERE sales_id='" . $sales_id . "'");
            }
        }
    endforeach;
}
?>
