<?php

include('../class/db_Class.php');	
$obj = new db_class();



        $sql_coustomer = $obj->FlyQuery("select 
                                        count(ur.id) AS total_unlock,
                                        ur.uid as input_by
                                        from unlock_request as ur
                                        group by ur.uid");
        

        
        $sqlCity = $sql_coustomer;
        
        echo "<pre>";
        print_r($sqlCity);
        
        if(!empty($sqlCity))
        {
            foreach ($sqlCity as $sales):
                $chkstore=$obj->FlyQuery("SELECT * FROM dashboard_report WHERE store_id='".$sales->input_by."'","1");
                if($chkstore==0)
                {
                    $obj->FlyPrepare("INSERT INTO dashboard_report (store_id,total_unlock) VALUES ('".$sales->input_by."','".$sales->total_unlock."')");
                }
                else
                {
                    $obj->FlyPrepare("UPDATE dashboard_report SET total_unlock='".$sales->total_unlock."' WHERE store_id='".$sales->input_by."'");
                }
            endforeach;
        }
       
?>
