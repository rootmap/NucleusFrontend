<?php
include('../class/db_Class.php');	
$obj = new db_class();




            $sql_coustomer = $obj->FlyQuery("SELECT 
            count(i.invoice_id) AS total_estimate,
            i.invoice_creator as input_by
            FROM `invoice_detail` as a 
            LEFT JOIN invoice as i on i.invoice_id=a.invoice_id
            WHERE i.doc_type='2' GROUP BY i.invoice_creator");





        $sqlCity = $sql_coustomer;
        //$totalrows = $obj->totalrows($table);
        
        
        
        //echo "<pre>";
        //print_r($sqlCity);
        
        if(!empty($sqlCity))
        {
            foreach ($sqlCity as $sales):
                $chkstore=$obj->FlyQuery("SELECT * FROM dashboard_report WHERE store_id='".$sales->input_by."'","1");
                if($chkstore==0)
                {
                    $obj->FlyPrepare("INSERT INTO dashboard_report (store_id,total_estimate) VALUES ('".$sales->input_by."','".$sales->total_estimate."')");
                }
                else
                {
                    $obj->FlyPrepare("UPDATE dashboard_report SET total_estimate='".$sales->total_estimate."' WHERE store_id='".$sales->input_by."'");
                }
            endforeach;
        }
        
?>
