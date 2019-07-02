<?php
include('../class/db_Class.php');	
$obj = new db_class();


       $sql_coustomer = $obj->FlyQuery("SELECT 
                    i.id, 
                    count(i.invoice_id) as sales_total, 
                    i.input_by
                    FROM invoice as i 
                    WHERE i.doc_type='3' AND i.cid!='0' 
                    GROUP BY i.input_by order by `i`.`id`");
        
        $sqlCity = $sql_coustomer;
        //$totalrows = $obj->totalrows($table);
        
        if(!empty($sqlCity))
        {
            foreach ($sqlCity as $sales):
                $chkstore=$obj->FlyQuery("SELECT * FROM dashboard_report WHERE store_id='".$sales->input_by."'","1");
                if($chkstore==0)
                {
                    $obj->FlyPrepare("INSERT INTO dashboard_report (store_id,total_sales) VALUES ('".$sales->input_by."','".$sales->sales_total."')");
                }
                else
                {
                    $obj->FlyPrepare("UPDATE dashboard_report SET total_sales='".$sales->sales_total."' WHERE store_id='".$sales->input_by."'");
                }
            endforeach;
        }
    

?>
