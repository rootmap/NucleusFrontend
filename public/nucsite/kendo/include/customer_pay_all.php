<?php
//creating new sales to pos by customer repair pay all	
if ($cashiers_id != 0) {
    $chkopenstore = $obj->exists_multiple("store_open", array("sid" => $input_by, "status" => 1));
    if ($chkopenstore != 0) {
        if ($cashier_id == 1) {

            $chk_invoice_check_cart = $obj->exists_multiple($table3, array("invoice_id" => $cart, "cid" => $cid));
            $chk_invoice_check_carts = $obj->exists_multiple($table3, array("invoice_id" => $cart));
            $chk_invoice_check_sales = $obj->exists_multiple($table2, array("sales_id" => $cart));
            if (!empty($cid) && $chk_invoice_check_cart == 0 && $chk_invoice_check_sales==0) {
                $obj->insert($table3, array("invoice_id" => $_SESSION['SESS_CART'], "cid" => $cid, "invoice_creator" => $input_by, "invoice_date" => date('d-m-Y'), "date" => date('Y-m-d'), "status" => 1, "doc_type" => 3, "access_id" => $access_id, "input_by" => $input_by));
                $a = 0;
                foreach ($_POST['pid'] as $index => $pd):
                    $obj->insert("pos_checkin", array("invoice_id" => $cart, "checkin_id" => $_POST['checkinid'][$index], "cid" => $cid, "date" => date('Y-m-d'), "status" => 1));
                    $single_cost = $_POST['price'][$index];
                    $quantity = 1;
                    $totalcost = $quantity * $single_cost;
                    $obj->insert($table2, array("uid" => $input_by,
                        "sales_id" =>$cart,
                        "pid" => $pd,
                        "quantity" =>$quantity,
                        "cashier_id" =>$_SESSION['SESS_CASHIER_ID'],
                        "single_cost" =>$single_cost,
                        "totalcost" =>$totalcost,
                        "input_by" =>$input_by, "access_id"=>$access_id,
                        "date" => date('Y-m-d'),
                        "status" =>1));
                    $a+=1;
                endforeach;

                if ($a != 0) {
                    $obj->Success("New Sales Receipt Has Been Created Successfully", "pos_redirect.php");
                } else {
                    $obj->Error("Failed To Add New Sales Item In POS.", "pos_redirect.php");
                }
                exit();
            } elseif (!empty($cid) && $chk_invoice_check_carts != 0 && $chk_invoice_check_sales==0) {
                $obj->update($table3, array("invoice_id" => $_SESSION['SESS_CART'], "cid" => $cid, "invoice_creator" => $input_by, "invoice_date" => date('d-m-Y'), "date" => date('Y-m-d'), "status" => 1, "doc_type" => 3, "access_id" => $access_id, "input_by" => $input_by));
                $a = 0;
                foreach ($_POST['pid'] as $index => $pd):
                    $obj->insert("pos_checkin", array("invoice_id" => $cart, "checkin_id" => $_POST['checkinid'][$index], "cid" => $cid, "date" => date('Y-m-d'), "status" => 1));
                    $single_cost = $_POST['price'][$index];
                    $quantity = 1;
                    $totalcost = $quantity * $single_cost;
                    $obj->insert($table2, array("uid" => $input_by,
                        "sales_id" =>$cart,
                        "pid" => $pd,
                        "quantity" =>$quantity,
                        "cashier_id" =>$_SESSION['SESS_CASHIER_ID'],
                        "single_cost" =>$single_cost,
                        "totalcost" =>$totalcost,
                        "input_by" =>$input_by, "access_id"=>$access_id,
                        "date" => date('Y-m-d'),
                        "status" =>1));
                    $a+=1;
                endforeach;

                if ($a != 0) {
                    $obj->Success("New Sales Receipt Has Been Created Successfully", "pos_redirect.php");
                } else {
                    $obj->Error("Failed To Add New Sales Item In POS.", "pos_redirect.php");
                }
                exit();
            } elseif (!empty($cid) && $chk_invoice_check_carts != 0) {
                $obj->Error("Failed, Please Clear Pos Screen/Click on New Sales.", "pos_redirect.php");
            }
            
        } else {
            $obj->Error("Cashier Not Looged In, Please Login First. ", "pos_redirect.php");
        }
    } else {
        $obj->Error("Store Is Not Open, To Made Any Transaction Please Open Store", "pos_redirect.php");
    }
} else {
    $obj->Error("Cashier Not Logged IN. PLease Login As A Cashier", "pos_redirect.php");
}
?>