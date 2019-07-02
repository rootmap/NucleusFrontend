<?php

include('../class/auth.php');
extract($_POST);
$table = "sales";
$success = "<label class='label label-success'>Item Has Been Added to Cart</label>";
$updated = "<label class='label label-success'>Shopping Cart Updated</label>";
$error = "<label class='label label-danger'>Please Contact to Your System Provider</label>";
$error2 = "<label class='label label-danger'>Cashier Not Logged IN, Please Login Cashier First</label>";
if (@$_SESSION['SESS_CASHIER_ID'] != '') {
    $cashier_id = $_SESSION['SESS_CASHIER_ID'];

    $exproduct = $obj->exists_multiple($table, array("uid" => $input_by, "id" => $sales_pid));
    if ($exproduct == 1) {
        $pid = $obj->SelectAllByVal($table, "id", $sales_pid, "pid");
        $sales_pro_quantity = $obj->SelectAllByVal($table, "id", $sales_pid, "quantity");
        $sales_pro_cost = $new_sales_amount;


        $totalquantity = $sales_pro_quantity;
        $totalcost = $totalquantity * $sales_pro_cost;

        if ($obj->update($table, array("id" => $sales_pid,
                    "uid" => $input_by,
                    "sales_id" => $sales_id,
                    "cashier_id" => $cashier_id,
                    "pid" => $pid,
                    "quantity" => $totalquantity,
                    "input_by" => $input_by,
                    "single_cost" => $sales_pro_cost,
                    "totalcost" => $totalcost)) == 1) {
            echo $updated;
        } else {
            echo $error;
        }
    } else {
        echo 0;
    }
} else {
    echo $error2;
}
?>