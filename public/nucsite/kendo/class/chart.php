<?php

class chart {

    //77d5d7b77bb86c84273f770a398a2e2f
    function AllInOne($sql) {
        $obj_pos=new db_class();
        $con=$obj_pos->open();
        $myarray=array();
        $a=0;
        if (mysqli_multi_query($con, $sql)) {
            do {
                $new_array2=array();
                // Store first result set
                if ($result=mysqli_store_result($con)) {
                    // Fetch one and one row
                    while ($row=mysqli_fetch_object($result)) {
                        $new_array2[]=$row;
                    }
                    // Free result set
                    mysqli_free_result($result);
                    $myarray[$a]=$new_array2;
                }
                $a++;
            }while (mysqli_next_result($con));
        }

        $obj_pos->close($con);
        return $myarray;
    }

    function buyback_check($payment_id, $newdate) {
        $obj_pos=new db_class();
        $cpse=0;
        $sqlinvoicedde=$obj_pos->SelectAllByID_Multiple("buyback", array("payment_method"=>$payment_id, "date"=>$newdate));
        if (!empty($sqlinvoicedde))
            foreach ($sqlinvoicedde as $inse):
                $cpse+=$inse->price;
            endforeach;
        return $cpse;
    }

    function buyback_check_store($store_id, $payment_id, $newdate) {
        $obj_pos=new db_class();
        $cpse=0;
        $sqlinvoicedde=$obj_pos->SelectAllByID_Multiple("buyback", array("payment_method"=>$payment_id, "date"=>$newdate, "input_by"=>$store_id));
        if (!empty($sqlinvoicedde))
            foreach ($sqlinvoicedde as $inse):
                $cpse+=$inse->price;
            endforeach;
        return $cpse;
    }

    function payout_check_plus($newdate) {
        $obj_pos=new db_class();
        $cpse=0;
        $sqlinvoicedde=$obj_pos->SelectAllByID_Multiple("payout", array("date"=>$newdate));
        if (!empty($sqlinvoicedde))
            foreach ($sqlinvoicedde as $inse):
                $sign=substr($inse->amount, 0, 1);
                if ($sign == "+") {
                    $cpse+=substr($inse->amount, 0, 1);
                }elseif ($sign == "-") {
                    $cpse+=0;
                }elseif ($sign != "-") {
                    $cpse+=$inse->amount;
                }
            endforeach;
        return $cpse;
    }

    function payout_check_min($newdate) {
        $obj_pos=new db_class();
        $cpse=0;
        $sqlinvoicedde=$obj_pos->SelectAllByID_Multiple("payout", array("date"=>$newdate));
        if (!empty($sqlinvoicedde))
            foreach ($sqlinvoicedde as $inse):
                $sign=substr($inse->amount, 0, 1);
                if ($sign == "-") {
                    $cpse+=substr($inse->amount, 0, 1);
                }elseif ($sign == "+") {
                    $cpse+=0;
                }
            endforeach;
        return $cpse;
    }

    function payout_check_plus_store_id($store_id, $newdate) {
        $obj_pos=new db_class();
        $cpse=0;
        $sqlinvoicedde=$obj_pos->SelectAllByID_Multiple("payout", array("date"=>$newdate, "input_by"=>$store_id));
        if (!empty($sqlinvoicedde))
            foreach ($sqlinvoicedde as $inse):
                $sign=substr($inse->amount, 0, 1);
                if ($sign == "+") {
                    $cpse+=substr($inse->amount, 0, 1);
                }elseif ($sign == "-") {
                    $cpse+=0;
                }elseif ($sign != "-") {
                    $cpse+=$inse->amount;
                }
            endforeach;
        return $cpse;
    }

    function payout_check_min_store_id($store_id, $newdate) {
        $obj_pos=new db_class();
        $cpse=0;
        $sqlinvoicedde=$obj_pos->SelectAllByID_Multiple("payout", array("date"=>$newdate, "input_by"=>$store_id));
        if (!empty($sqlinvoicedde))
            foreach ($sqlinvoicedde as $inse):
                $sign=substr($inse->amount, 0, 1);
                if ($sign == "-") {
                    $cpse+=substr($inse->amount, 0, 1);
                }elseif ($sign == "+") {
                    $cpse+=0;
                }
            endforeach;
        return $cpse;
    }

}

?>