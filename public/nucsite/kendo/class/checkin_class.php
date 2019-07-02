<?php
class checkin_class {
	function cart($getcart) {
        if ($getcart != '') {
            return $cart = $getcart;
        } else {
            $_SESSION['SESS_CART_CHECKIN'] = time();
            session_write_close();
            return $cart = $_SESSION['SESS_CART_CHECKIN'];
        }
    }
	
	function newcart($getcart) {
        unset($_SESSION['SESS_CART_CHECKIN']);
        if ($getcart != '') {
            $_SESSION['SESS_CART_CHECKIN'] = time();
            session_write_close();
            return $cart = $_SESSION['SESS_CART_CHECKIN'];
        } else {
            $_SESSION['SESS_CART_CHECKIN'] = time();
            session_write_close();
            return $cart = $_SESSION['SESS_CART_CHECKIN'];
        }
    }
	
}

?>
