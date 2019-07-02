<?php

include('../class/auth.php');
extract($_GET);
$table = "sales";
$success = "<label class='label label-success'>Item Has Been Added to Cart</label>";
$updated = "<label class='label label-success'>Shopping Cart Updated</label>";
$error = "<label class='label label-danger'>Please Contact to Your System Provider</label>";
$error3 = "<label class='label label-danger'>Please Select A Customer.</label>";
//print_r($_GET);
//exit();
$error2 = "<label class='label label-danger'>Cashier Not Logged IN, Please Login Cashier First</label>";
if (isset($_SESSION['SESS_CASHIER_ID'])) {
    $cashier_id = $_SESSION['SESS_CASHIER_ID'];
    if (!empty($pid)) {
        if (!empty($cid)) {
            if (!empty($pid) && !empty($frequency) && !empty($startdate)) {
                $single_cost = $obj->SelectAllByVal("product", "id", $pid, "price_cost");
                $totalcost = 1 * $single_cost;
                //echo $obj->exists_multiple("reccurring_invoice", array("sales_id" => $sales_id, "pid" => $pid, "input_by" => $input_by));
                if ($obj->exists_multiple("reccurring_invoice", array("sales_id" => $sales_id, "pid" => $pid, "input_by" => $input_by)) == 0) {
                    $email = $obj->SelectAllByVal("coustomer", "id", $cid, "email");
                    $obj->insert("reccurring_invoice", array("cid" => $cid,
                        "frequency" => $frequency,
                        "sales_id" => $sales_id,
                        "start_date" => $startdate,
                        "price" => $totalcost,
                        "pid" => $pid,
                        "quantity" => 1,
                        "total_price"=>$totalcost,
                        "email" => $email,
                        "description" => $des,
                        "input_by"=>$input_by,
                        "notes" => $notes,
                        "date" => date('Y-m-d'),
                        "status" => $auto_charged));
                    if ($obj->insert($table, array("uid" => $input_by,
                                "sales_id" => $sales_id,
                                "pid" => $pid,
                                "quantity" => 1,
                                "single_cost" => $single_cost,
                                "cashier_id" => $cashier_id,
                                "totalcost" => $totalcost,
                                "input_by" => $input_by,
                                "date" => date('Y-m-d'),
                                "status" => 1)) == 1) {
                        echo $success;
                    } else {
                        echo $error;
                    }
                } else {
                    $sqlrid=$obj->FlyQuery("SELECT * FROM reccurring_invoice WHERE sales_id='".$sales_id."' AND pid='".$pid."'");
                        $sqlsid=$obj->FlyQuery("SELECT * FROM sales WHERE sales_id='".$sales_id."' AND pid='".$pid."'");
                        $email = $obj->SelectAllByVal("coustomer", "id", $cid, "email");
                        
                        $totalcostr=$single_cost*($sqlrid[0]->quantity+1);
                        $totalquantity=$sqlrid[0]->quantity+1;
                        
                        
                        $obj->update("reccurring_invoice", array("id"=>$sqlrid[0]->id,"cid" => $cid,
                        "frequency" => $frequency,
                        "sales_id" => $sales_id,
                        "start_date" => $startdate,
                        "price" => $totalcost,
                        "pid" => $pid,
                        "quantity" =>$totalquantity,
                        "total_price"=>$totalcostr,
                        "email" => $email,
                        "description" => $des,
                        "input_by"=>$input_by,
                        "notes" => $notes,
                        "date" => date('Y-m-d'),
                        "status" => $auto_charged));
                        
                        
                        $obj->update($table, array("id"=>$sqlsid[0]->id,"uid" => $input_by,
                                "sales_id" => $sales_id,
                                "pid" => $pid,
                                "quantity" =>$totalquantity,
                                "single_cost" => $single_cost,
                                "cashier_id" => $cashier_id,
                                "totalcost" => $totalcostr,
                                "input_by" => $input_by,
                                "date" => date('Y-m-d'),
                                "status" => 1));
                        
                        echo $success;
                }
            } else {
                echo 'emt';
            }
        } else {
            echo 0;
        }
    } else {
        echo $error;
    }
} else {
    echo $error2;
}
?>