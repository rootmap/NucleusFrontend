<?php

class pos {

    function tax_status($status) {
        if ($status == 1) {
            return "Full Tax Charge for these product";
        } elseif ($status == 2) {
            return "Part Tax Charge for these product";
        } else {
            return "No Tax charge.";
        }
    }

    function SelectAll_Set_Limit($object, $id, $val, $stlimit, $endlimit) {
        $obj = new db_class();
        $count = 0;
        $fields = '';
        $con = $obj->open();
        $query = "SELECT * FROM `$object` WHERE `$id`='$val' LIMIT $stlimit,$endlimit ORDER BY id DESC";
        $result = mysqli_query($con, $query);
        if ($result) {
            $count = mysqli_num_rows($result);

            if ($count >= 1) {
                //$object[]=array();
                while ($rows = $result->fetch_object()) {
                    $objects[] = $rows;
                }
                $obj->close($con);
                return $objects;
            }
        }
    }

    function SelectAllOnlyLimit($object, $stlimit, $endlimit) {
        $obj = new db_class();
        $count = 0;
        $fields = '';
        $con = $obj->open();
        $query = "SELECT * FROM `$object` LIMIT $stlimit,$endlimit";
        $result = mysqli_query($con, $query);
        if ($result) {
            $count = mysqli_num_rows($result);

            if ($count >= 1) {
                //$object[]=array();
                while ($rows = $result->fetch_object()) {
                    $objects[] = $rows;
                }
                $obj->close($con);
                return $objects;
            }
        }
    }

    function SelectAllOnlyOneCondLimit($object, $fid, $val, $stlimit, $endlimit) {
        $obj = new db_class();
        $count = 0;
        $fields = '';
        $con = $obj->open();
        $query = "SELECT * FROM `$object` WHERE `$fid`='$val' LIMIT $stlimit,$endlimit";
        $result = mysqli_query($con, $query);
        if ($result) {
            $count = mysqli_num_rows($result);

            if ($count >= 1) {
                //$object[]=array();
                while ($rows = $result->fetch_object()) {
                    $objects[] = $rows;
                }
                $obj->close($con);
                return $objects;
            }
        }
    }

    function SelectAll_Set_LimitCondNot($object, $f1, $v1, $v2, $v3, $stlimit, $endlimit) {
        $obj = new db_class();
        $count = 0;
        $fields = '';
        $con = $obj->open();
        $query = "SELECT * FROM `$object` WHERE `$f1`!='$v1' AND `$f1`!='$v2' AND `$f1`!='$v3' LIMIT $stlimit,$endlimit ORDER BY id DESC";
        $result = mysqli_query($con, $query);
        if ($result) {
            $count = mysqli_num_rows($result);

            if ($count >= 1) {
                //$object[]=array();
                while ($rows = $result->fetch_object()) {
                    $objects[] = $rows;
                }
                $obj->close($con);
                return $objects;
            }
        }
    }

    function SelectAll_Set_LimitCondNot_Store($object, $store, $f1, $v1, $v2, $v3, $stlimit, $endlimit) {
        $obj = new db_class();
        $count = 0;
        $fields = '';
        $con = $obj->open();
        $query = "SELECT * FROM `$object` WHERE input_by!='$store' AND `$f1`!='$v1' AND `$f1`!='$v2' AND `$f1`!='$v3' LIMIT $stlimit,$endlimit ORDER BY id DESC";
        $result = mysqli_query($con, $query);
        if ($result) {
            $count = mysqli_num_rows($result);

            if ($count >= 1) {
                //$object[]=array();
                while ($rows = $result->fetch_object()) {
                    $objects[] = $rows;
                }
                $obj->close($con);
                return $objects;
            }
        }
    }

    function SelectAll_Set_Limit_condition($object, $id, $val, $id1, $val1, $stlimit, $endlimit) {
        $obj = new db_class();
        $count = 0;
        $fields = '';
        $con = $obj->open();
        $query = "SELECT * FROM `$object` WHERE `$id`='$val' AND `$id1`='$val1' LIMIT $stlimit,$endlimit ORDER BY id DESC";
        $result = mysqli_query($con, $query);
        if ($result) {
            $count = mysqli_num_rows($result);

            if ($count >= 1) {
                //$object[]=array();
                while ($rows = $result->fetch_object()) {
                    $objects[] = $rows;
                }
                $obj->close($con);
                return $objects;
            }
        }
    }

    function tax_check($invoice_id) {
        $obj_pos = new db_class();
        $st = $obj_pos->SelectAllByVal("tax_status", "id", "1", "status");
        if ($st == 1) {
            $chk = $obj_pos->exists_multiple("pos_tax", array("invoice_id" => $invoice_id));
            if ($chk == 0) {
                $obj_pos->insert("pos_tax", array("invoice_id" => $invoice_id, "status" => 1, "date" => date('Y-m-d')));
                return 1;
            } else {
                return $obj_pos->SelectAllByVal("pos_tax", "invoice_id", $invoice_id, "status");
            }
        } elseif ($st == 2) {
            $chk = $obj_pos->exists_multiple("pos_tax", array("invoice_id" => $invoice_id));
            if ($chk == 0) {
                $obj_pos->insert("pos_tax", array("invoice_id" => $invoice_id, "status" => 2, "date" => date('Y-m-d')));
                return 2;
            } else {
                return $obj_pos->SelectAllByVal("pos_tax", "invoice_id", $invoice_id, "status");
            }
        } elseif ($st == 0) {
            $chk = $obj_pos->exists_multiple("pos_tax", array("invoice_id" => $invoice_id));
            if ($chk == 0) {
                $obj_pos->insert("pos_tax", array("invoice_id" => $invoice_id, "status" => 2, "date" => date('Y-m-d')));
                return 2;
            } else {
                return $obj_pos->SelectAllByVal("pos_tax", "invoice_id", $invoice_id, "status");
            }
        } else {
            $chk = $obj_pos->exists_multiple("pos_tax", array("invoice_id" => $invoice_id));
            if ($chk == 0) {
                $obj_pos->insert("pos_tax", array("invoice_id" => $invoice_id, "status" => 2, "date" => date('Y-m-d')));
                return 2;
            } else {
                return $obj_pos->SelectAllByVal("pos_tax", "invoice_id", $invoice_id, "status");
            }
        }
    }

    function cashier_login($getcart) {

        if ($getcart == '') {
            return "Please Login As Cashier";
        } else {
            return 1;
        }
    }

    function cashier_id($getcart) {

        if ($getcart == '') {
            return 0;
        } else {
            return 1;
        }
    }

    function cashier_actual_id($getcart) {

        if ($getcart == '') {
            return 0;
        } else {
            return $getcart;
        }
    }

    function cashier_login_process($username, $password) {
        $obj_pos = new db_class();
        if ($obj_pos->exists_multiple("cashier_list", array("username" => $username, "password" => $obj_pos->password($password))) == 1) {
            session_regenerate_id();
            $_SESSION['SESS_CASHIER_ID'] = $obj_pos->SelectAllByVal("cashier_list", "username", $username, "id");
            session_write_close();
            
            $cashier_id = $_SESSION['SESS_CASHIER_ID'];
            $time = date('g:i:s A');
            $chkpunch = $obj_pos->exists_multiple("store_punch_time", array("sid" => $input_by, "status" => 1));
            if ($chkpunch == 1) {

                $punchid = $obj_pos->SelectAllByVal2("store_punch_time", "sid", $input_by, "status", 1, "id");
                $obj_pos->update("store_punch_time", array("id" => $punchid, "cashier_id" => $cashier_id, "store_id" => $input_by, "outdate" => $date, "outtime" => $time, "status" => 2));
            } else {
                $obj_pos->insert("store_punch_time", array("sid" => $input_by, "store_id" => $input_by, "indate" => $date, "cashier_id" => $cashier_id, "intime" => $time, "status" => 1, "date" => date('Y-m-d')));
            }
            
            return $obj_pos->Success("Cashier Successfully Logged IN.", $obj_pos->filename());
        } else {
            return $obj_pos->Error("Cashier Login Failed.", $obj_pos->filename());
        }
    }

    function cashier_login_process_to_logout($username, $password) {
        $obj_pos = new db_class();
        if ($obj_pos->exists_multiple("cashier_list", array("username" => $username, "password" => $obj_pos->password($password))) == 1) {
            session_regenerate_id();
            $_SESSION['SESS_CASHIER_ID'] = $obj_pos->SelectAllByVal("cashier_list", "username", $username, "id");
            session_write_close();


            $cashier_id = $_SESSION['SESS_CASHIER_ID'];
            $time = date('g:i:s A');
            $chkpunch = $obj_pos->exists_multiple("store_punch_time", array("sid" => $input_by, "status" => 1));
            if ($chkpunch == 1) {

                $punchid = $obj->SelectAllByVal2("store_punch_time", "sid", $input_by, "status", 1, "id");
                $obj_pos->update("store_punch_time", array("id" => $punchid, "cashier_id" => $cashier_id, "store_id" => $input_by, "outdate" => $date, "outtime" => $time, "status" => 2));
            } else {
                $obj_pos->insert("store_punch_time", array("sid" => $input_by, "store_id" => $input_by, "indate" => $date, "cashier_id" => $cashier_id, "intime" => $time, "status" => 1, "date" => date('Y-m-d')));
            }


            return $obj_pos->Success("Cashier Successfully Logged IN.", "pos.php?logout=1");
        } else {
            return $obj_pos->Error("Cashier Logout Failed Please Login Properly.", $obj_pos->filename());
        }
    }

    function cashier_login_process_to_logout_for_store($username, $password, $loginid) {
        $obj_pos = new db_class();
        if ($obj_pos->exists_multiple("cashier_list", array("username" => $username, "password" => $obj_pos->password($password))) == 1) {
            $chklogin_id = $obj_pos->SelectAllByVal("cashier_list", "username", $username, "password", $obj_pos->password($password), "id");
            if ($chklogin_id == $loginid) {
                return 1;
            } else {
                return 1;
            }
        } else {
            return 3;
        }
    }

    function cashier_logout($session) {
        $obj_pos = new db_class();
        unset($session);
        session_regenerate_id();
        $_SESSION['SESS_CASHIER_ID'] = '';
        session_write_close();
        $obj_pos->Success("Cashier Logged Out", $obj_pos->filename());
    }

    function cashier_logout_without_return($session) {
        $obj_pos = new db_class();
        unset($session);
        session_regenerate_id();
        $_SESSION['SESS_CASHIER_ID'] = '';
        session_write_close();
    }

}

?>