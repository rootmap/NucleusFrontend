<?php
include('../class/db_Class.php');	
$obj = new db_class();



         $sqlpar = "SELECT 
                    count(a.id) AS total_buyback, 
                    a.input_by FROM buyback as a 
                    GROUP BY a.input_by";
         
        $sql_coustomer = $obj->FlyQuery($sqlpar);
        
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
                    $obj->FlyPrepare("INSERT INTO dashboard_report (store_id,total_buyback) VALUES ('".$sales->input_by."','".$sales->total_buyback."')");
                }
                else
                {
                    $obj->FlyPrepare("UPDATE dashboard_report SET total_buyback='".$sales->total_buyback."' WHERE store_id='".$sales->input_by."'");
                }
            endforeach;
        }
?>
