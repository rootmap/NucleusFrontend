<?php
include('../class/db_Class.php');	
$obj = new db_class();



        $sqlpars = "select 
                    count(t.id) AS total_ticket,
                    t.input_by
                    from ticket as t GROUP BY t.input_by";
       // echo $sqlpars;
        

        $sql_coustomer = $obj->FlyQuery($sqlpars);

        $sqlCity = $sql_coustomer;
        //$totalrows = $obj->totalrows($table);
        
        if(!empty($sqlCity))
        {
            foreach ($sqlCity as $sales):
                $chkstore=$obj->FlyQuery("SELECT * FROM dashboard_report WHERE store_id='".$sales->input_by."'","1");
                if($chkstore==0)
                {
                    $obj->FlyPrepare("INSERT INTO dashboard_report (store_id,total_ticket) VALUES ('".$sales->input_by."','".$sales->total_ticket."')");
                }
                else
                {
                    $obj->FlyPrepare("UPDATE dashboard_report SET total_ticket='".$sales->total_ticket."' WHERE store_id='".$sales->input_by."'");
                }
            endforeach;
        }
     
?>
