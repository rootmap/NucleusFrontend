<?php
include('../class/db_Class.php');	
$obj = new db_class();


        $sqlpars = "select
                    count(r.id) AS total_repair,
                    r.input_by from checkin_request as r
                    GROUP BY r.input_by";
       // echo $sqlpars;
        

        $sql_coustomer = $obj->FlyQuery($sqlpars);




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
                    $obj->FlyPrepare("INSERT INTO dashboard_report (store_id,total_repair) VALUES ('".$sales->input_by."','".$sales->total_repair."')");
                }
                else
                {
                    $obj->FlyPrepare("UPDATE dashboard_report SET total_repair='".$sales->total_repair."' WHERE store_id='".$sales->input_by."'");
                }
            endforeach;
        }
     
   
?>
