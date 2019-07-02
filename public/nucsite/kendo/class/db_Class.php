<?php

class db_class {

    //77d5d7b77bb86c84273f770a398a2e2f
    function invoice_edit_row($table, $id, $val, $pre, $show_pre, $cid) {
        ?>
        <b id="<?php echo $show_pre; ?>">
            <?php
            $cus_data = $this->SelectAllByVal($table, $id, $val, $pre);
            if ($cus_data == '') {
                ?>
                <span  onclick="get_data_cus_invoice('<?php echo $table; ?>', '<?php echo $id; ?>', '<?php echo $val; ?>', '<?php echo $pre; ?>', '<?php echo $show_pre; ?>', '<?php echo $cid; ?>')"><i class="icon-edit"></i> Add Your <?php echo $show_pre; ?> </span>

                <?php
            } else {
                echo $this->invoice_tax_status($cus_data);
                ?>
                <span onclick="get_data_cus_invoice('<?php echo $table; ?>', '<?php echo $id; ?>', '<?php echo $val; ?>', '<?php echo $pre; ?>', '<?php echo $show_pre; ?>', '<?php echo $cid; ?>')"><i class="icon-edit"></i> </span>
            <?php } ?>
        </b>
        <?php
    }

    function customer_edit($table, $val, $pre, $show_pre) {
        ?>
        <b id="<?php echo $pre; ?>">
            <?php
            $cus_data = $this->SelectAllByVal($table, "id", $val, $pre);
            if ($cus_data == '') {
                ?>
                <span  onclick="get_data_cus('<?php echo $table; ?>', 'id', '<?php echo $val; ?>', '<?php echo $pre; ?>')"><i class="icon-edit"></i> Add Your <?php echo $show_pre; ?> </span>

                <?php
            } else {
                echo $cus_data;
                ?>
                <span onclick="get_data_cus('<?php echo $table; ?>', 'id', '<?php echo $val; ?>', '<?php echo $pre; ?>')"><i class="icon-edit"></i> </span>
            <?php } ?>
        </b>
        <?php
    }

    function invoice_edit($table, $id, $val, $pre, $show_pre) {
        ?>
        <b id="<?php echo $pre; ?>">
            <?php
            $cus_data = $this->SelectAllByVal($table, $id, $val, $pre);
            if ($cus_data == '') {
                ?>
                <span  onclick="get_data_cus('<?php echo $table; ?>', '<?php echo $id; ?>', '<?php echo $val; ?>', '<?php echo $pre; ?>')"><i class="icon-edit"></i> Add Your <?php echo $show_pre; ?> </span>

                <?php
            } else {
                echo $cus_data;
                ?>
                <span onclick="get_data_cus('<?php echo $table; ?>', '<?php echo $id; ?>', '<?php echo $val; ?>', '<?php echo $pre; ?>')"><i class="icon-edit"></i> </span>
            <?php } ?>
        </b>
        <?php
    }

    function invoice_edit_two($table, $id, $val, $pre, $show_pre) {
        ?>
        <b id="<?php echo $pre; ?>">
            <?php
            $cus_data = $this->SelectAllByVal($table, $id, $val, $pre);
            if ($cus_data == '') {
                ?>
                <span  onclick="get_data_cus_two('<?php echo $table; ?>', '<?php echo $id; ?>', '<?php echo $val; ?>', '<?php echo $pre; ?>')"><i class="icon-edit"></i> Add Your <?php echo $show_pre; ?> </span>

                <?php
            } else {
                echo $this->invoice_paid_status($cus_data);
                ?>
                <span onclick="get_data_cus_two('<?php echo $table; ?>', '<?php echo $id; ?>', '<?php echo $val; ?>', '<?php echo $pre; ?>')"><i class="icon-edit"></i> </span>
            <?php } ?>
        </b>
        <?php
    }

    function excel($filup, $name, $destination) {
        if (is_uploaded_file($_FILES[$filup]['tmp_name'])) {
            $extension = $this->getExtension($_FILES['file']['name']);
            if ($extension == "xls") {
                $filename = $name . "." . $extension;
                $result = move_uploaded_file($_FILES[$filup]['tmp_name'], $destination . "/" . $filename);
                if ($result == 1) {
                    return $filename;
                } else {
                    return 0;
                }
            } else {
                return 0;
            }
        }
    }

    function CountDate($exdate) {
        $date1 = new DateTime($exdate);
        $date2 = new DateTime(date('Y-m-d'));

        $diff = $date2->diff($date1)->format("%a");
        if ($diff == 0) {
            return "Today";
        } else {
            return $diff . " Days Ago.";
        }
    }

    function escapesql($col) {
        $con = $this->open();
        $coll = mysqli_real_escape_string($con, $col);
        $this->close($con);
        return $coll;
    }

    function dates($value) {
        //2015-02-28
        $date = substr($value, 8, 2);
        $month = substr($value, 5, 2);
        $year = substr($value, 0, 4);
        return $date . "/" . $month . "/" . $year;
    }

    function escape_empty($value) {
        if ($value == '') {
            return 0;
        } else {
            return $value;
        }
    }

    public function open() {
    	if ($_SERVER['HTTP_HOST'] == "localhost") {
        	$con = mysqli_connect("localhost", "root", "", "pos_multi");
    	}
    	else
    	{
        	$con = mysqli_connect("localhost", "nucleusp_pos", "8vxs~(o(1Q{+", "nucleusp_pos");
    	}
        return $con;
    }

    public function close($con) {
        mysqli_close($con);
    }

    function selected($chk, $val) {
        if ($chk == $val) {
            return "selected='selected'";
        } else {
            return "";
        }
    }

    function baseUrl($suffix = '') {
        $protocol = strpos($_SERVER['SERVER_SIGNATURE'], '443') !== false ? 'https://' : 'http://';
        if ($_SERVER['HTTP_HOST'] == "localhost") {
            $web_root = $protocol . $_SERVER['HTTP_HOST'] . "/" . "Dropbox/account_nucleus/";
        } else {
            $web_root = $protocol . $_SERVER['HTTP_HOST'] . "/" . "kendo/";
        }
        //$web_root = $protocol . $_SERVER['HTTP_HOST'] . "/" . "Dropbox/odesk/pos/";
        //$web_root = $protocol . $_SERVER['HTTP_HOST'] . "/" . "Dropbox/account_nucleus/";
        $suffix = ltrim($suffix, '/');
        return $web_root . trim($suffix);
    }

    public function SiteUrl($suffix = '') {
        $protocol = strpos($_SERVER['SERVER_SIGNATURE'], '443') !== false ? 'https://' : 'http://';
        //$web_root = $protocol . $_SERVER['HTTP_HOST'] . "/" . "Dropbox/odesk/pos/";
        if ($_SERVER['HTTP_HOST'] == "localhost") {
            $web_root = $protocol . $_SERVER['HTTP_HOST'] . "/" . "Dropbox/account_nucleus/";
        } else {
            $web_root = $protocol . $_SERVER['HTTP_HOST'] . "/" . "kendo/";
        }

        $suffix = ltrim($suffix, '/');
        return $web_root . trim($suffix);
    }

    function order_status($status) {
        if ($status == 1) {
            return "Pending";
        } elseif ($status == 2) {
            return "Payment Completed";
        } elseif ($status == 0) {
            return "pending";
        }
    }

    function invoice_paid_status($status) {
        if ($status == 0) {
            return "Not Yet";
        } elseif ($status == 1) {
            return "Paid";
        } elseif ($status == 2) {
            return "Paid";
        } elseif ($status == 3) {
            return "Partial";
        }
    }

    function invoice_took_payment($status) {
        if ($status == 0) {
            return "Not Yet";
        } elseif ($status == 1) {
            return "Yes";
        } elseif ($status == 2) {
            return "Yes";
        }
    }

    function invoice_tax_status($status) {
        if ($status == 0) {
            return "No";
        } elseif ($status == 1) {
            return "Yes";
        } else {
            return "No";
        }
    }

    function ticket_status($status) {
        if ($status == 1) {
            return "New";
        } elseif ($status == 2) {
            return "In Progress";
        } elseif ($status == 3) {
            return "Resolved";
        } elseif ($status == 4) {
            return "Invoiced";
        } elseif ($status == 5) {
            return "Waiting For Parts";
        } elseif ($status == 6) {
            return "Waiting on Customer";
        } elseif ($status == 7) {
            return "Scheduled";
        } elseif ($status == 8) {
            return "Customer Reply";
        }
    }

    function ticket_payment_status($status) {
        if ($status == 0) {
            return "Not Paid";
        } elseif ($status == 1) {
            return "Paid";
        } elseif ($status == 2) {
            return "Not Paid";
        } elseif ($status == 3) {
            return "Partial";
        }
    }

    function Error($msg, $location) {
        $errmsg_arr[] = "<div class='notice outer'>
                            <div class='note note-danger'>
                            <button type='button' class='close'>×</button>
                            <strong>Notice!</strong> " . $msg . "</div>
                        </div>";
        $error_flag = true;
        if ($error_flag) {
            $_SESSION['ERRMSG_ARR'] = $errmsg_arr;
            session_write_close();
            header("location:" . $location);
            exit();
        }
    }

    function Success($msg, $location) {
        $errmsg_arr[] = "<div class='notice outer'>
                            <div class='note note-success'>
                            <button type='button' class='close'>×</button>
                            <strong>Notice!</strong> " . $msg . "</div>
                        </div>";
        $error_flag = true;
        if ($error_flag) {
            $_SESSION['SMSG_ARR'] = $errmsg_arr;
            session_write_close();
            header("location:" . $location);
            exit();
        }
    }

    function ShowMsg() {
        if (isset($_SESSION['ERRMSG_ARR']) && is_array($_SESSION['ERRMSG_ARR']) && count($_SESSION['ERRMSG_ARR']) > 0) {
            foreach ($_SESSION['ERRMSG_ARR'] as $msg) {
                unset($_SESSION['ERRMSG_ARR']);
                return $msg;
            }
        }

        if (isset($_SESSION['SMSG_ARR']) && is_array($_SESSION['SMSG_ARR']) && count($_SESSION['SMSG_ARR']) > 0) {
            foreach ($_SESSION['SMSG_ARR'] as $msgs) {
                unset($_SESSION['SMSG_ARR']);
                return $msgs;
            }
        }
    }

    function checklogin() {
        if ($_SESSION['SESS_CUSID'] == '') {
            return $this->Error("Session Exipred, Please Login ... ", "login.php");
        }
    }

    function checkmenu() {
        if ($_SESSION['SESS_CUSID'] == '') {
            return $this->Error("Please Login, access These Page... ", "login.php");
        }
    }

    function authprice($price) {
        if (@$_SESSION['SESS_CUSID'] == '') {
            return "<a href='login.php' class='button' style='margin-right:5px;'> <span>Login For Price</span> </a>";
        } else {
            return "$" . $price;
        }
    }

    function bodyhead() {
        return '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
				<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
				<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
				<link rel="icon" href="/favicon.ico" type="image/x-icon">
				<title> Nucleus  </title>
				<link  type="text/css"  href=' . $this->baseUrl("css/main.css") . ' rel="stylesheet" />
				<script type="text/javascript" src=' . $this->baseUrl("js/jquery-1.9.1.js") . '></script>
				<script type="text/javascript" src=' . $this->baseUrl("js/jquery-migrate-1.0.0.js") . '></script>
				<script type="text/javascript" src=' . $this->baseUrl("js/jquery_ui_custom.js") . '></script>
				<script type="text/javascript" src=' . $this->baseUrl("js/plugins/charts/excanvas.min.js") . '></script>
				<script type="text/javascript" src=' . $this->baseUrl("js/plugins/charts/jquery.flot.js") . '></script>
				<script type="text/javascript" src=' . $this->baseUrl("js/plugins/charts/jquery.flot.resize.js") . '></script>
				<script type="text/javascript" src=' . $this->baseUrl("js/plugins/charts/jquery.sparkline.min.js") . '></script>
				<script type="text/javascript" src=' . $this->baseUrl("js/plugins/forms/jquery.tagsinput.min.js") . '></script>
				<script type="text/javascript" src=' . $this->baseUrl("js/plugins/forms/jquery.inputlimiter.min.js") . '></script>
				<script type="text/javascript" src=' . $this->baseUrl("js/plugins/forms/jquery.maskedinput.min.js") . '></script>
				<script type="text/javascript" src=' . $this->baseUrl("js/plugins/forms/jquery.autosize.js") . '></script>
				<script type="text/javascript" src=' . $this->baseUrl("js/plugins/forms/jquery.ibutton.js") . '></script>
				<script type="text/javascript" src=' . $this->baseUrl("js/plugins/forms/jquery.dualListBox.js") . '></script>
				<script type="text/javascript" src=' . $this->baseUrl("js/plugins/forms/jquery.validate.js") . '></script>
				<script type="text/javascript" src=' . $this->baseUrl("js/plugins/forms/jquery.uniform.min.js") . '></script>
				<script type="text/javascript" src=' . $this->baseUrl("js/plugins/forms/jquery.select2.min.js") . '></script>
				<script type="text/javascript" src=' . $this->baseUrl("js/plugins/forms/jquery.cleditor.js") . '></script>
				<script type="text/javascript" src=' . $this->baseUrl("js/plugins/uploader/plupload.js") . '></script>

				<script type="text/javascript" src=' . $this->baseUrl("js/plugins/uploader/jquery.plupload.queue.js") . '></script>
				<script type="text/javascript" src=' . $this->baseUrl("js/plugins/wizard/jquery.form.wizard.js") . '></script>
				<script type="text/javascript" src=' . $this->baseUrl("js/plugins/wizard/jquery.form.js") . '></script>
				<script type="text/javascript" src=' . $this->baseUrl("js/plugins/ui/jquery.collapsible.min.js") . '></script>
				<script type="text/javascript" src=' . $this->baseUrl("js/plugins/ui/jquery.timepicker.min.js") . '></script>
				<script type="text/javascript" src=' . $this->baseUrl("js/plugins/ui/jquery.jgrowl.min.js") . '></script>
				<script type="text/javascript" src=' . $this->baseUrl("js/plugins/ui/jquery.pie.chart.js") . '></script>
				<script type="text/javascript" src=' . $this->baseUrl("js/plugins/ui/jquery.fullcalendar.min.js") . '></script>
				<script type="text/javascript" src=' . $this->baseUrl("js/plugins/ui/jquery.elfinder.js") . '></script>
				<script type="text/javascript" src=' . $this->baseUrl("js/plugins/ui/jquery.fancybox.js") . '></script>
				<script type="text/javascript" src=' . $this->baseUrl("js/plugins/tables/jquery.dataTables.min.js") . '></script>
				<script type="text/javascript" src=' . $this->baseUrl("js/plugins/bootstrap/bootstrap.min.js") . '></script>
				<script type="text/javascript" src=' . $this->baseUrl("js/plugins/bootstrap/bootstrap-bootbox.min.js") . '></script>
				<script type="text/javascript" src=' . $this->baseUrl("js/plugins/bootstrap/bootstrap-progressbar.js") . '></script>
				<script type="text/javascript" src=' . $this->baseUrl("js/plugins/bootstrap/bootstrap-colorpicker.js") . '></script>
				<script type="text/javascript" src=' . $this->baseUrl("js/functions/custom.js") . '></script>
				<script type="text/javascript" src=' . $this->baseUrl("js/charts/chart.js") . '></script>';
    }

    /**
     * Insert query for Object
     * @param type $object
     * @param type $object_array
     * @return string/Exception
     */
    function insert($object, $object_array) {
        $count = 0;
        $fields = '';
        $con = $this->open();
        foreach ($object_array as $col => $val) {
            if ($count++ != 0)
                $fields .= ', ';
            $col = mysqli_real_escape_string($con, $col);
            $val = mysqli_real_escape_string($con, $val);
            $fields .= "`$col` = '$val'";
        }
        $query = "INSERT INTO `$object` SET $fields";
        //exit();
        if (mysqli_query($con, $query)) {
            $this->close($con);
            return 1;
        } else {
            return 0;
        }
    }

    function cart_ticket($getcart) {
        if ($getcart != '') {
            return $cart = $getcart;
        } else {
            $_SESSION['SESS_CART_TICKET'] = time();
            session_write_close();
            return $cart = $_SESSION['SESS_CART_TICKET'];
        }
    }

    function newcart_ticket($getcart) {
        unset($_SESSION['SESS_CART_TICKET']);
        if ($getcart != '') {
            $_SESSION['SESS_CART_TICKET'] = time();
            session_write_close();
            return $cart = $_SESSION['SESS_CART_TICKET'];
        } else {
            $_SESSION['SESS_CART_TICKET'] = time();
            session_write_close();
            return $cart = $_SESSION['SESS_CART_TICKET'];
        }
    }

    function cart_unlock($getcart) {
        if ($getcart != '') {
            return $cart = $getcart;
        } else {
            $_SESSION['SESS_CART_UNLOCK'] = time();
            session_write_close();
            return $cart = $_SESSION['SESS_CART_UNLOCK'];
        }
    }

    function newcart_unlock($getcart) {
        unset($_SESSION['SESS_CART_UNLOCK']);
        if ($getcart != '') {
            $_SESSION['SESS_CART_UNLOCK'] = time();
            session_write_close();
            return $cart = $_SESSION['SESS_CART_UNLOCK'];
        } else {
            $_SESSION['SESS_CART_UNLOCK'] = time();
            session_write_close();
            return $cart = $_SESSION['SESS_CART_UNLOCK'];
        }
    }

    function cart_buyback($getcart) {
        if ($getcart != '') {
            return $cart = $getcart;
        } else {
            $_SESSION['SESS_CART_BUYBACK'] = time();
            session_write_close();
            return $cart = $_SESSION['SESS_CART_BUYBACK'];
        }
    }

    function newcart_buyback($getcart) {
        unset($_SESSION['SESS_CART_BUYBACK']);
        if ($getcart != '') {
            $_SESSION['SESS_CART_BUYBACK'] = time();
            session_write_close();
            return $cart = $_SESSION['SESS_CART_BUYBACK'];
        } else {
            $_SESSION['SESS_CART_BUYBACK'] = time();
            session_write_close();
            return $cart = $_SESSION['SESS_CART_BUYBACK'];
        }
    }

    function cartdata_ticket($pid, $cart) {
        if (isset($_SESSION['SESS_CUSID']) != '') {
            if ($this->exists_multiple("cart_invoice", array("pid" => $pid, "cart_id" => $cart)) == 0) {
                $this->insert("cart_invoice", array("pid" => $pid, "cart_id" => $cart, "quantity" => 1, "status" => 1));
            } else {
                $this->SelectAllByVal2incre("cart_invoice", "pid", $pid, "cart_id", $cart, "quantity");
            }

            return $this->exists_multiple("cart_invoice", array("cart_id" => $cart));
        } else {
            return 0;
        }
    }

    function cartdataupdate_ticket($pid, $cart, $quantity) {
        if (isset($_SESSION['SESS_CUSID']) != '') {
            $this->update("cart_invoice", array("pid" => $pid, "cart_id" => $cart, "quantity" => $quantity, "status" => 1));
            return 1;
        } else {
            return 0;
        }
    }

    //ticket id generated


    function cart_estimates($getcart) {
        if ($getcart != '') {
            return $cart = $getcart;
        } else {
            $_SESSION['SESS_CART_ESTIMATES'] = time();
            session_write_close();
            return $cart = $_SESSION['SESS_CART_ESTIMATES'];
        }
    }

    function newcart_estimates($getcart) {
        unset($_SESSION['SESS_CART_ESTIMATES']);
        if ($getcart != '') {
            $_SESSION['SESS_CART_ESTIMATES'] = time();
            session_write_close();
            return $cart = $_SESSION['SESS_CART_ESTIMATES'];
        } else {
            $_SESSION['SESS_CART_ESTIMATES'] = time();
            session_write_close();
            return $cart = $_SESSION['SESS_CART_ESTIMATES'];
        }
    }

    function cartdata_estimates($pid, $cart) {
        if (isset($_SESSION['SESS_CUSID']) != '') {
            if ($this->exists_multiple("cart_invoice", array("pid" => $pid, "cart_id" => $cart)) == 0) {
                $this->insert("cart_invoice", array("pid" => $pid, "cart_id" => $cart, "quantity" => 1, "status" => 1));
            } else {
                $this->SelectAllByVal2incre("cart_invoice", "pid", $pid, "cart_id", $cart, "quantity");
            }

            return $this->exists_multiple("cart_invoice", array("cart_id" => $cart));
        } else {
            return 0;
        }
    }

    function cartdataupdate_estimates($pid, $cart, $quantity) {
        if (isset($_SESSION['SESS_CUSID']) != '') {
            $this->update("cart_invoice", array("pid" => $pid, "cart_id" => $cart, "quantity" => $quantity, "status" => 1));
            return 1;
        } else {
            return 0;
        }
    }

    //cart invoice

    function cart_invoice($getcart) {
        if ($getcart != '') {
            return $cart = $getcart;
        } else {
            $_SESSION['SESS_CART_INVOICE'] = time();
            session_write_close();
            return $cart = $_SESSION['SESS_CART_INVOICE'];
        }
    }

    function newcart_invoice($getcart) {
        unset($_SESSION['SESS_CART_INVOICE']);
        if ($getcart != '') {
            $_SESSION['SESS_CART_INVOICE'] = time();
            session_write_close();
            return $cart = $_SESSION['SESS_CART_INVOICE'];
        } else {
            $_SESSION['SESS_CART_INVOICE'] = time();
            session_write_close();
            return $cart = $_SESSION['SESS_CART_INVOICE'];
        }
    }

    function cartdata_invoice($pid, $cart) {
        if (isset($_SESSION['SESS_CUSID']) != '') {
            if ($this->exists_multiple("cart_invoice", array("pid" => $pid, "cart_id" => $cart)) == 0) {
                $this->insert("cart_invoice", array("pid" => $pid, "cart_id" => $cart, "quantity" => 1, "status" => 1));
            } else {
                $this->SelectAllByVal2incre("cart_invoice", "pid", $pid, "cart_id", $cart, "quantity");
            }

            return $this->exists_multiple("cart_invoice", array("cart_id" => $cart));
        } else {
            return 0;
        }
    }

    function cartdataupdate_invoice($pid, $cart, $quantity) {
        if (isset($_SESSION['SESS_CUSID']) != '') {
            $this->update("cart_invoice", array("pid" => $pid, "cart_id" => $cart, "quantity" => $quantity, "status" => 1));
            return 1;
        } else {
            return 0;
        }
    }

    function cart($getcart) {
        if ($getcart != '') {
            return $cart = $getcart;
        } else {
            $_SESSION['SESS_CART'] = time();
            session_write_close();
            return $cart = $_SESSION['SESS_CART'];
        }
    }

    function newcart($getcart) {
        unset($_SESSION['SESS_CART']);
        if ($getcart != '') {
            $_SESSION['SESS_CART'] = time();
            session_write_close();
            return $cart = $_SESSION['SESS_CART'];
        } else {
            $_SESSION['SESS_CART'] = time();
            session_write_close();
            return $cart = $_SESSION['SESS_CART'];
        }
    }

    function cartdata($pid, $cart) {
        if (isset($_SESSION['SESS_CUSID']) != '') {
            if ($this->exists_multiple("cart", array("pid" => $pid, "cart_id" => $cart)) == 0) {
                $this->insert("cart", array("pid" => $pid, "cart_id" => $cart, "quantity" => 1, "status" => 1));
            } else {
                $this->SelectAllByVal2incre("cart", "pid", $pid, "cart_id", $cart, "quantity");
            }

            return $this->exists_multiple("cart", array("cart_id" => $cart));
        } else {
            return 0;
        }
    }

    function cartdataupdate($pid, $cart, $quantity) {
        if (isset($_SESSION['SESS_CUSID']) != '') {
            $this->update("cart", array("pid" => $pid, "cart_id" => $cart, "quantity" => $quantity, "status" => 1));
            return 1;
        } else {
            return 0;
        }
    }

    function lastid($object) {
        $count = 0;
        $fields = '';
        $con = $this->open();
        $query = "SELECT * FROM `$object` ORDER BY id DESC LIMIT 1";
        $result = mysqli_query($con, $query);
        if ($result) {
            $count = mysqli_num_rows($result);

            if ($count >= 1) {
                //$object[]=array();
                while ($rows = $result->fetch_object()) {
                    $objects[] = $rows;
                }
                $this->close($con);
                return $objects;
            }
        }
    }

    /**
     * if the object is exists
     * @param type $object
     * @param type $object_array
     * @return int
     */
    function exists_multiple($object, $object_array) {
        $count = 0;
        $fields = '';
        $con = $this->open();
        foreach ($object_array as $col => $val) {
            if ($count++ != 0)
                $fields .= ' AND ';
            $col = mysqli_real_escape_string($con, $col);
            $val = mysqli_real_escape_string($con, $val);
            $fields .= "`$col` = '$val' ";
        }
        $query = "SELECT * FROM `$object` WHERE $fields";
        $result = mysqli_query($con, $query);
        if ($result) {
            $count = mysqli_num_rows($result);
            $this->close($con);
            if ($count != 0) {
                return $count;
            } else {
                return 0;
            }
        } else {
            $this->close($con);
            return 0;
        }
    }

    function totalrows($object) {
        $count = 0;
        $fields = '';
        $con = $this->open();
        $query = "SELECT * FROM `$object`";
        $result = mysqli_query($con, $query);
        if ($result) {
            $count = mysqli_num_rows($result);
            $this->close($con);
            return $count;
        } else {
            $this->close($con);
            return 0;
        }
    }

    function MakePassword($pass) {
        $bytes = 555000;
        $salt = base64_encode($bytes);
        $hash = hash('sha512', $salt . $pass);
        return md5($hash);
    }

    /**
     * Select all the objects
     * @param type $object
     * @return array
     */
    function FlyQuery($query, $st = 0) {
        $count = 0;
        $fields = '';
        $con = $this->open();
        $result = mysqli_query($con, $query);
        //var_dump($result);
        if ($result) {
            $count = mysqli_num_rows($result);
            if ($st == 0) {
                if ($count >= 1) {
                    //$object[]=array();
                    while ($rows = $result->fetch_object()) {
                        $objects[] = $rows;
                    }
                    $this->close($con);
                    return $objects;
                }
            }elseif ($st=="debug") {
                return $query;
                exit();
            } else {
                $this->close($con);
                return $count;
            }
        }
    }

    function FlyPrepare($query) {
        $count = 0;
        $fields = '';
        $con = $this->open();
        $result = mysqli_query($con, $query);
        if ($result) {
            $this->close($con);
            return true;
        } else {
            return mysqli_error($con);
            $this->close($con);
        }
    }

    //echo $filtercount;




    function SelectAll($object) {
        $count = 0;
        $fields = '';
        $con = $this->open();
        $query = "SELECT * FROM `$object` ORDER BY id DESC";
        $result = mysqli_query($con, $query);
        if ($result) {
            $count = mysqli_num_rows($result);

            if ($count >= 1) {
                //$object[]=array();
                while ($rows = $result->fetch_object()) {
                    $objects[] = $rows;
                }
                $this->close($con);
                return $objects;
            }
        }
    }

    function SelectAllNOASC($object) {
        $count = 0;
        $fields = '';
        $con = $this->open();
        $query = "SELECT * FROM `$object`";
        $result = mysqli_query($con, $query);
        if ($result) {
            $count = mysqli_num_rows($result);

            if ($count >= 1) {
                //$object[]=array();
                while ($rows = $result->fetch_object()) {
                    $objects[] = $rows;
                }
                $this->close($con);
                return $objects;
            }
        }
    }

    function Product_report($object, $id, $val, $id1, $val1, $status) {
        $count = 0;
        $fields = '';
        $con = $this->open();
        $query = "SELECT * FROM `$object` where `$id`='$val' || `$id1`='$val1'";
        $result = mysqli_query($con, $query);
        if ($result) {
            $count = mysqli_num_rows($result);

            if ($status == 1) {
                $objects = array();
                while ($rows = $result->fetch_object()) {
                    $objects[] = $rows;
                }

                $this->close($con);
                return $objects;
            } else {
                $this->close($con);
                return $count;
            }
        }
    }

    function Product_report_Store($object, $id, $val, $id1, $val1, $status, $store_field, $store_value) {
        $count = 0;
        $fields = '';
        $con = $this->open();
        //$query = "SELECT * FROM `$object` where `$store_field`='$store_value' AND `$id`='$val' AND `$id1`='$val1'";
        $query = "SELECT * FROM `$object` where `$store_field`='$store_value'";
        $result = mysqli_query($con, $query);
        if ($result) {
            $count = mysqli_num_rows($result);

            if ($status == 1) {
                $objects = array();
                while ($rows = $result->fetch_object()) {
                    $objects[] = $rows;
                }

                $this->close($con);
                return $objects;
            } else {
                $this->close($con);
                return $count;
            }
        }
    }

    function SelectAll_Set_Limit($object, $stlimit, $endlimit) {
        $count = 0;
        $fields = '';
        $con = $this->open();
        $query = "SELECT * FROM `$object` LIMIT $stlimit,$endlimit  ORDER BY id DESC";
        $result = mysqli_query($con, $query);
        if ($result) {
            $count = mysqli_num_rows($result);

            if ($count >= 1) {
                //$object[]=array();
                while ($rows = $result->fetch_object()) {
                    $objects[] = $rows;
                }
                $this->close($con);
                return $objects;
            }
        }
    }

    function SelectAllMax($st) {
        $count = 0;
        $fields = '';
        $con = $this->open();
        if ($st == 0) {
            $query = "SELECT cashier_id,MAX(totalcost) as totalcost,count(totalcost) as totalcount FROM sales_list LIMIT 1";
        } else {
            $query = "SELECT cashier_id,MAX(totalcost) as totalcost,count(totalcost) as totalcount FROM sales_list WHERE input_by='$st' LIMIT 1";
        }
        $result = mysqli_query($con, $query);
        if ($result) {

            $count = mysqli_num_rows($result);
            if ($count >= 1) {
                //$object[]=array();
                while ($rows = $result->fetch_object()) {
                    $objects[] = $rows;
                }
                $this->close($con);
                return $objects;
            }
        }
    }

    /**
     * Select object by ID
     * @param type $object
     * @param type $object_array
     * @return int
     */
    function SelectAllByID($object, $object_array) {
        $count = 0;
        $fields = '';
        $con = $this->open();
        if (count($object_array) <= 1) {
            foreach ($object_array as $col => $val) {
                if ($count++ != 0)
                    $fields .= ', ';
                $col = mysqli_real_escape_string($con, $col);
                $val = mysqli_real_escape_string($con, $val);
                $fields .= "`$col` = '$val'";
            }
        }
        $query = "SELECT * FROM `$object` WHERE $fields ORDER BY id DESC";
        $result = mysqli_query($con, $query);
        if ($result) {
            $count = mysqli_num_rows($result);

            if ($count >= 1) {
                //$object[]=array();
                while ($rows = $result->fetch_object()) {
                    $objects[] = $rows;
                }
                $this->close($con);
                return $objects;
            }
        } else {
            $this->close($con);
            return 0;
        }
    }

    function SelectAllByID_Multiple($object, $object_array) {
        $count = 0;
        $fields = '';
        $con = $this->open();
        foreach ($object_array as $col => $val) {
            if ($count++ != 0)
                $fields .= ' AND ';
            $col = mysqli_real_escape_string($con, $col);
            $val = mysqli_real_escape_string($con, $val);
            $fields .= "`$col` = '$val' ";
        }

        $query = "SELECT * FROM `$object` WHERE $fields ORDER BY id DESC";
        $result = mysqli_query($con, $query);
        if ($result) {
            $count = mysqli_num_rows($result);

            if ($count >= 1) {
                //$object[]=array();
                while ($rows = $result->fetch_object()) {
                    $objects[] = $rows;
                }
                $this->close($con);
                return $objects;
            }
        } else {
            $this->close($con);
            return 0;
        }
    }

    function SelectAllByID_Multiple_limit($object, $object_array, $limit) {
        $count = 0;
        $fields = '';
        $con = $this->open();
        foreach ($object_array as $col => $val) {
            if ($count++ != 0)
                $fields .= ' AND ';
            $col = mysqli_real_escape_string($con, $col);
            $val = mysqli_real_escape_string($con, $val);
            $fields .= "`$col` = '$val' ";
        }

        $query = "SELECT * FROM `$object` WHERE $fields ORDER BY id DESC LIMIT $limit";
        $result = mysqli_query($con, $query);
        if ($result) {
            $count = mysqli_num_rows($result);

            if ($count >= 1) {
                //$object[]=array();
                while ($rows = $result->fetch_object()) {
                    $objects[] = $rows;
                }
                $this->close($con);
                return $objects;
            }
        } else {
            $this->close($con);
            return 0;
        }
    }

    function SelectAllByID_Multiple_Inventory($object, $object_array) {
        $count = 0;
        $fields = '';
        $con = $this->open();
        foreach ($object_array as $col => $val) {
            if ($count++ != 0)
                $fields .= ' AND ';
            $col = mysqli_real_escape_string($con, $col);
            $val = mysqli_real_escape_string($con, $val);
            $fields .= "`$col` = '$val' ";
        }

        $query = "SELECT * FROM `$object` WHERE $fields";
        $result = mysqli_query($con, $query);
        if ($result) {
            $count = mysqli_num_rows($result);

            if ($count >= 1) {
                //$object[]=array();
                while ($rows = $result->fetch_object()) {
                    $objects[] = $rows;
                }
                $this->close($con);
                return $objects;
            }
        } else {
            $this->close($con);
            return 0;
        }
    }

    function SelectAllByID_Multiple_site($object, $object_array, $pid, $order, $limit) {
        $count = 0;
        $fields = '';
        $con = $this->open();
        foreach ($object_array as $col => $val) {
            if ($count++ != 0)
                $fields .= ' AND ';
            $col = mysqli_real_escape_string($con, $col);
            $val = mysqli_real_escape_string($con, $val);
            $fields .= "`$col` = '$val' ";
        }

        $query = "SELECT * FROM `$object` WHERE $fields AND id!='$pid' ORDER BY id $order LIMIT $limit";
        $result = mysqli_query($con, $query);
        if ($result) {
            $count = mysqli_num_rows($result);

            if ($count >= 1) {
                //$object[]=array();
                while ($rows = $result->fetch_object()) {
                    $objects[] = $rows;
                }
                $this->close($con);
                return $objects;
            }
        } else {
            $this->close($con);
            return 0;
        }
    }

    function SelectAllByID_site($object, $object_array, $order, $limit) {
        $count = 0;
        $fields = '';
        $con = $this->open();
        if (count($object_array) <= 1) {
            foreach ($object_array as $col => $val) {
                if ($count++ != 0)
                    $fields .= ', ';
                $col = mysqli_real_escape_string($con, $col);
                $val = mysqli_real_escape_string($con, $val);
                $fields .= "`$col` = '$val'";
            }
        }
        $query = "SELECT * FROM `$object` WHERE $fields ORDER BY id $order LIMIT $limit";
        $result = mysqli_query($con, $query);
        if ($result) {
            $count = mysqli_num_rows($result);

            if ($count >= 1) {
                //$object[]=array();
                while ($rows = $result->fetch_object()) {
                    $objects[] = $rows;
                }
                $this->close($con);
                return $objects;
            }
        } else {
            $this->close($con);
            return 0;
        }
    }

    function SelectAllByVal($object, $field, $fval, $value) {
        $count = 0;
        $fields = '';
        $con = $this->open();
        $query = "SELECT `$object`.`$value` FROM `$object` WHERE `$field`='$fval'";
        $result = mysqli_query($con, $query);
        if ($result) {
            $count = mysqli_num_rows($result);

            if ($count >= 1) {
                //$object[]=array();
                $rows = mysqli_fetch_array($result);
                $objects = $rows[$value];
                $this->close($con);
                return $objects;
            }
        } else {
            $this->close($con);
            return 0;
        }
    }

    function SelectAllByVal2($object, $field, $fval, $field2, $fval2, $value) {
        $count = 0;
        $fields = '';
        $con = $this->open();
        $query = "SELECT `$object`.`$value` FROM `$object` WHERE `$field`='$fval' AND `$field2`='$fval2'";
        $result = mysqli_query($con, $query);
        if ($result) {
            $count = mysqli_num_rows($result);

            if ($count >= 1) {
                //$object[]=array();
                $rows = mysqli_fetch_array($result);
                $objects = $rows[$value];
                $this->close($con);
                return $objects;
            }
        } else {
            $this->close($con);
            return 0;
        }
    }

    function SelectAllByVal3($object, $field, $fval, $field2, $fval2, $field3, $fval3, $value) {
        $count = 0;
        $fields = '';
        $con = $this->open();
        $query = "SELECT `$object`.`$value` FROM `$object` WHERE `$field`='$fval' AND `$field2`='$fval2' AND `$field3`='$fval3'";
        $result = mysqli_query($con, $query);
        if ($result) {
            $count = mysqli_num_rows($result);

            if ($count >= 1) {
                //$object[]=array();
                $rows = mysqli_fetch_array($result);
                $objects = $rows[$value];
                $this->close($con);
                return $objects;
            }
        } else {
            $this->close($con);
            return 0;
        }
    }

    function SelectAllByVal4($object, $field, $fval, $field2, $fval2, $field3, $fval3, $field4, $fval4, $value) {
        $count = 0;
        $fields = '';
        $con = $this->open();
        $query = "SELECT `$object`.`$value` FROM `$object` WHERE `$field`='$fval' AND `$field2`='$fval2' AND `$field3`='$fval3' AND `$field4`='$fval4'";
        $result = mysqli_query($con, $query);
        if ($result) {
            $count = mysqli_num_rows($result);

            if ($count >= 1) {
                //$object[]=array();
                $rows = mysqli_fetch_array($result);
                $objects = $rows[$value];
                $this->close($con);
                return $objects;
            }
        } else {
            $this->close($con);
            return 0;
        }
    }

    function SelectAllByVal2incre($object, $field, $fval, $field2, $fval2, $fetch) {
        $link = $this->open();
        $sql = "UPDATE `$object` SET $fetch=$fetch+1 WHERE `$field`='$fval' AND `$field2`='$fval2'";
        $result = mysqli_query($link, $sql);
        if ($result) {
            $this->close($link);
            return 1;
        } else {
            return 0;
        }
    }

    function SelectAll_Site($object, $order, $limit) {
        $count = 0;
        $fields = '';
        $con = $this->open();
        $query = "SELECT * FROM `$object` order by id $order LIMIT $limit";
        $result = mysqli_query($con, $query);
        if ($result) {
            $count = mysqli_num_rows($result);

            if ($count >= 1) {
                //$object[]=array();
                while ($rows = $result->fetch_object()) {
                    $objects[] = $rows;
                }
                $this->close($con);
                return $objects;
            }
        }
    }

    function SelectAll_sdate($object, $field, $date) {
        $count = 0;
        $fields = '';
        $con = $this->open();
        $query = "SELECT * FROM `$object` WHERE `$field`='$date' ORDER BY id DESC";
        $result = mysqli_query($con, $query);
        if ($result) {
            $count = mysqli_num_rows($result);

            if ($count >= 1) {
                //$object[]=array();
                while ($rows = $result->fetch_object()) {
                    $objects[] = $rows;
                }
                $this->close($con);
                return $objects;
            }
        }
    }

    function SelectAll_ddate($object, $field, $startdate, $enddate) {
        $count = 0;
        $fields = '';
        $con = $this->open();
        $query = "SELECT * FROM `$object` WHERE `$field` >= '$startdate' AND `$field` <= '$enddate' ORDER BY id DESC";
        $result = mysqli_query($con, $query);
        if ($result) {
            $count = mysqli_num_rows($result);

            if ($count >= 1) {
                //$object[]=array();
                while ($rows = $result->fetch_object()) {
                    $objects[] = $rows;
                }
                $this->close($con);
                return $objects;
            }
        }
    }

    function filename() {
        return basename($_SERVER['PHP_SELF']);
    }

    function status($status) {
        if ($status == 1) {
            return "New";
        } elseif ($status == 2) {
            return "Lost";
        } elseif ($status == 3) {
            return "Stolen";
        }
    }

    function password($password) {
        $st = "TotalSales";
        $newpassword = $st . "-" . $password;
        $convert = md5($newpassword);
        return $convert;
    }

    /**
     * Delete the object from database
     * @param type $object
     * @param type $object_array
     * @return string|\Exception
     */
    function delete($object, $object_array) {
        $count = 0;
        $fields = '';
        $con = $this->open();
        if (count($object_array) <= 1) {
            foreach ($object_array as $col => $val) {
                if ($count++ != 0)
                    $fields .= ', ';
                $col = mysqli_real_escape_string($con, $col);
                $val = mysqli_real_escape_string($con, $val);
                $fields .= "`$col` = '$val'";
            }
        }

        $query = "DELETE FROM `$object` WHERE $fields";
        if (mysqli_query($con, $query)) {
            $this->close($con);
            return 1;
        } else {
            return 0;
        }
    }

    function deleteAll($object) {
        $count = 0;
        $fields = '';
        $con = $this->open();
        $query = "DELETE FROM `$object`";
        if (mysqli_query($con, $query)) {
            $this->close($con);
            return 1;
        } else {
            return 0;
        }
    }

    function deletesing($field, $id, $table) {

        if ($this->delete($table, array($field => $id)) == 1) {
            //$obj->Success();
            $this->Success("Successfully Deleted From System", $this->filename());
        } else {
            $this->Error("Failed to delete", $this->filename());
        }
    }

    function deletesingAll($table) {

        if ($this->deleteAll($table) == 1) {
            $this->Success("Successfully All Deleted From System", $this->filename());
        } else {
            $this->Error("Failed to delete", $this->filename());
        }
    }

    /**
     * Delete the object
     * @param type $object
     * @param type $object_array
     */
    function update($object, $object_array) {
        $con_key_from_arr = array_keys($object_array);
        $key = $con_key_from_arr[0];
        $value = array_shift($object_array);
        $fields = array();
        $con = $this->open();
        foreach ($object_array as $field => $val) {
            $fields[] = "$field = '" . mysqli_real_escape_string($con, $val) . "'";
        }
        $query = "UPDATE `$object` SET " . join(', ', $fields) . " WHERE $key = '$value'";

        if (mysqli_query($con, $query)) {

            $this->close($con);
            return 1;
        } else {
            return 0;
        }
    }

    function Update_product_incre($object, $f1, $val1, $f2, $val2) {
        $count = 0;
        $fields = '';
        $con = $this->open();
        $curquantity = $this->SelectAllByVal($object, $f2, $val2, $f1);
        $totalquantity = $curquantity + $val1;
        $query = "UPDATE `$object` SET `$f1`='$totalquantity' WHERE `$f2`='$val2'";
        $result = mysqli_query($con, $query);
        if ($result) {
            $this->close($con);
            return 1;
        } else {
            $this->close($con);
            return 0;
        }
    }

    /* 	function getExtension($str) {
      $i = strrpos($str, ".");
      if (!$i) {
      return "";
      }
      $l = strlen($str) - $i;
      $ext = substr($str, $i + 1, $l);
      return $ext;
      } */

    function upload_image($width, $height, $destination, $img_name, $pre) {
        list($w, $h) = getimagesize($_FILES[$img_name]['tmp_name']);
        $ret_name = $pre . '_' . time() . '' . $_FILES[$img_name]['name'];
        $path = $destination . '/' . $ret_name;
        $imgString = file_get_contents($_FILES[$img_name]['tmp_name']);
        $image = imagecreatefromstring($imgString);
        $tmp = imagecreatetruecolor($width, $height);

        imagealphablending($tmp, false);
        imagesavealpha($tmp, true);
        $transparent = imagecolorallocatealpha($tmp, 255, 255, 255, 127);
        imagefilledrectangle($tmp, 0, 0, $width, $height, $transparent);

        imagecopyresized($tmp, $image, 0, 0, 0, 0, $width, $height, $w, $h);

        switch ($_FILES[$img_name]['type']) {
            case 'image/jpeg':
                imagejpeg($tmp, $path, 100);
                break;
            case 'image/png':
                imagepng($tmp, $path, 0);
                break;
            case 'image/gif':
                imagegif($tmp, $path);
                break;
            default:
                exit;
                break;
        }
        return $ret_name;
        imagedestroy($image);
        imagedestroy($tmp);
    }

    function upload_fiximage($destination, $img_name, $pre) {
        list($w, $h) = getimagesize($_FILES[$img_name]['tmp_name']);
        $ret_name = $pre . '_' . time() . '' . $_FILES[$img_name]['name'];
        $path = $destination . '/' . $ret_name;
        $imgString = file_get_contents($_FILES[$img_name]['tmp_name']);
        $image = imagecreatefromstring($imgString);
        $tmp = imagecreatetruecolor($w, $h);

        imagealphablending($tmp, false);
        imagesavealpha($tmp, true);
        $transparent = imagecolorallocatealpha($tmp, 255, 255, 255, 127);
        imagefilledrectangle($tmp, 0, 0, $w, $h, $transparent);

        imagecopyresized($tmp, $image, 0, 0, 0, 0, $w, $h, $w, $h);

        switch ($_FILES[$img_name]['type']) {
            case 'image/jpeg':
                imagejpeg($tmp, $path, 100);
                break;
            case 'image/png':
                imagepng($tmp, $path, 0);
                break;
            case 'image/gif':
                imagegif($tmp, $path);
                break;
            default:
                exit;
                break;
        }
        return $ret_name;
        imagedestroy($image);
        imagedestroy($tmp);
    }

    function clean($str) {
        $str = @trim($str);
        if (get_magic_quotes_gpc()) {
            $str = stripslashes($str);
        }
        return mysql_real_escape_string($str);
    }

    function RandNumber($e) {
        for ($i = 0; $i < $e; $i++) {
            @$rand = $rand . rand(0, 9);
        }
        return $rand;
    }

    function carrier($st) {
        if ($st == 1) {
            $power = "Verizon";
        } elseif ($st == 2) {
            $power = "US IMEI Blacllist";
        } elseif ($st == 3) {
            $power = "Canada IMEI Blacklist";
        } elseif ($st == 4) {
            $power = "Telus";
        } elseif ($st == 5) {
            $power = "Metro PCS";
        } elseif ($st == 6) {
            $power = "Straight Talk";
        } elseif ($st == 7) {
            $power = "Net10";
        } elseif ($st == 8) {
            $power = "Tracfone";
        } elseif ($st == 9) {
            $power = "Cricket";
        } else {
            $power = "Not Selected Yet";
        }
        return $power;
    }

    function dmy($month) {
        $chkj = strlen($month);
        if ($chkj == 1) {
            return $chkjval = "0" . $month;
        } else {
            return $chkjval = $month;
        }
    }

    function randomPassword() {
        $alphabet = "EF+GHI234WXYZ567+89@(0-=1){<>/\_+$}[]%$*ABCD";
        $pass = array();
        for ($i = 0; $i < 6; $i++) {
            $n = rand(0, strlen($alphabet) - 1);
            $pass[$i] = $alphabet[$n];
        }
        return implode($pass);
    }

    function color() {
        $alphabet = "ABCDEF0123456789";
        $pass = array();
        for ($i = 0; $i < 2; $i++) {
            $n = rand(0, strlen($alphabet) - 1);
            $pass[$i] = $alphabet[$n];
        }
        return implode($pass);
    }

    function cleanQuery($string) {
        if (get_magic_quotes_gpc())
            $string = stripslashes($string);
        return mysql_escape_string($string);
    }

    function limit_words($string, $word_limit) {
        $words = explode(" ", $string);
        return implode(" ", array_splice($words, 0, $word_limit)) . "...";
    }

    function today() {
        return date('Y-m-d');
    }

    function getExtension($str) {
        $i = strrpos($str, ".");
        if (!$i) {
            return "";
        }
        $l = strlen($str) - $i;
        $ext = substr($str, $i + 1, $l);
        return $ext;
    }

    function duration($d1, $d2) {
        $d1 = new DateTime($d1);
        $d2 = new DateTime($d2);
        $interval = $d2->diff($d1);
        if ($interval->format('%d') == 0) {
            return "Today";
        } else {
            return $interval->format('%d days');
        }
        //return $interval->format('%d days, %H hours, %I minutes, %S seconds');
    }

    function daysgone($d1, $d2) {
        $d1 = new DateTime($d1);
        $d2 = new DateTime($d2);
        $interval = $d2->diff($d1);
        if ($interval->format('%d') == 0) {
            return "0";
        } else {
            return $interval->format('%d');
        }
        //return $interval->format('%d days, %H hours, %I minutes, %S seconds');
    }

    function durations($d1, $d2) {
        $d1 = new DateTime($d1);
        $d2 = new DateTime($d2);
        $interval = $d2->diff($d1);
        if ($interval->format('%d') == '00') {
            if ($interval->format('%H') == '00') {
                if ($interval->format('%I') == '00') {

                    if ($interval->format('%S') == '00') {
                        return $interval->format('%S ');
                    } else {
                        return $interval->format('%S ');
                    }
                } else {
                    return $interval->format('%I : %S Seconds');
                }
            } else {
                return $interval->format('%H : %I : %S Seconds');
            }
        } else {
            return $interval->format('%d , %H : %I : %S Seconds');
        }
    }

    function punchtimetotal($d1, $d2) {
        $d1 = new DateTime($d1);
        $d2 = new DateTime($d2);
        $interval = $d2->diff($d1);
        if ($interval->format('%d') == '00') {
            if ($interval->format('%H') == '00') {
                if ($interval->format('%I') == '00') {

                    if ($interval->format('%S') == '00') {
                        return $interval->format('00:00:%S');
                    } else {
                        return $interval->format('00:00:%S');
                    }
                } else {
                    return $interval->format('00:%I:%S');
                }
            } else {
                return $interval->format('%H:%I:%S');
            }
        } else {
            return $interval->format('%H:%I:%S');
        }
    }

    function ReportQuery_Datewise($object, $object_array, $date1, $date2, $st) {
        $obj = new db_class();
        $count = 0;
        $fields = '';
        $con = $obj->open();
        foreach ($object_array as $col => $val) {
            if ($count++ != 0)
                $fields .= ' AND ';
            $col = mysqli_real_escape_string($con, $col);
            $val = mysqli_real_escape_string($con, $val);
            $fields .= "`$col` = '$val' ";
        }

        $query = "SELECT * FROM `$object` r WHERE $fields and r.date >= '$date1' and r.date <= '$date2' ORDER BY id DESC";
        $result = mysqli_query($con, $query);
        if ($result) {
            $count = mysqli_num_rows($result);

            if ($count >= 1) {
                if ($st == 1) {
                    while ($rows = $result->fetch_object()) {
                        $objects[] = $rows;
                    }
                    $obj->close($con);
                    return $objects;
                } else {
                    $obj->close($con);
                    return $count;
                }
            } else {
                $obj->close($con);
                return 0;
            }
        } else {
            $obj->close($con);
            return 0;
        }
    }

}
?>
