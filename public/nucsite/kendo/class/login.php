<?php

class login {

    function GetPcAddress($st) {
        if ($st == 1) {
            $host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
            return $host;
        }elseif ($st == 2) {
            $host=gethostbyaddr($_SERVER['REMOTE_ADDR']);
            return $host;
        }
    }

    function quote_smart($value) {
        $obj=new db_class();
        $con=$obj->open();
        if (get_magic_quotes_gpc()) {
            $value=stripslashes($value);
        }

        if (!is_numeric($value)) {
            $value=mysqli_real_escape_string($con, $value);
        }
        return $value;
    }

    function login_user_not_email($username, $password) {
        $success="index.php";
        $obj=new db_class();
        $falpc=array();
        $pcfal=$obj->SelectAll("autorized_pc_false");
        if (!empty($pcfal)) {
            foreach ($pcfal as $fal):
                $falpc[]=$fal->store_id;
            endforeach;
        }

        if (empty($username) or empty($password)) {
            return $obj->Error("Failed, Login Info Should Not Be Empty", $obj->filename());
        }else {
            $ex=array("username"=>$username, "password"=>$obj->password($password));
            if ($obj->exists_multiple("store", $ex) == 1) {
                if ($obj->exists_multiple("store", array("username"=>$username, "password"=>$obj->password($password), "status"=>1)) == 1) {
                    session_regenerate_id();
                    $_SESSION['SESS_AMSIT_APPS_ID']=$obj->SelectAllByVal("store", "username", $username, "id");
                    $_SESSION['SESS_AMSIT_APPS_SHOP_NAME']=$obj->SelectAllByVal("store", "username", $username, "name");
                    session_write_close();
                    return $obj->Success("Thank You For Login As A Shop Owner,Welcome To Your Account.", $success);
                }elseif ($obj->exists_multiple("store", array("username"=>$username, "password"=>$obj->password($password), "status"=>2)) == 1) {
                    session_regenerate_id();
                    $_SESSION['SESS_AMSIT_APPS_ID']=$obj->SelectAllByVal("store", "username", $username, "id");
                    $_SESSION['SESS_AMSIT_APPS_SHOP_NAME']=$obj->SelectAllByVal("store", "username", $username, "name");
                    session_write_close();
                    return $obj->Success("Thank You For Login As a Admin,Welcome To Your Account.", $success);
                }elseif ($obj->exists_multiple("store", array("username"=>$username, "password"=>$obj->password($password), "status"=>3)) == 1) {
                    $user_address=$this->GetPcAddress(1);
                    $chk=$obj->exists_multiple("autorized_pc", array("pc_address"=>$user_address));
                    $store_id=$obj->SelectAllByVal("store", "username", $username, "store_id");
                    if ($chk != 0 || in_array($store_id, $falpc)) {
                        session_regenerate_id();
                        $_SESSION['SESS_AMSIT_APPS_ID']=$obj->SelectAllByVal("store", "username", $username, "id");
                        $_SESSION['SESS_AMSIT_APPS_SHOP_NAME']=$obj->SelectAllByVal("store", "username", $username, "name");
                        $_SESSION['SESS_CASHIER_ID']=$obj->SelectAllByVal("store", "username", $username, "id");
                        session_write_close();
                        $inp=$obj->SelectAllByVal("store", "id", $_SESSION['SESS_CASHIER_ID'], "store_id");
                        $chkrep=$obj->exists_multiple("setting_report", array("store_id"=>$inp));
                        if ($chkrep == 0) {
                            $obj->insert("setting_report", array("store_id"=>$inp));
                        }
                        return $obj->Success("Thank You For Login As a Admin,Welcome To Your Account.", $success);
                    }else {
                        return $obj->Success(" Cashier / Manager PC Not Authorized. ", "login.php");
                    }
                }elseif ($obj->exists_multiple("store", array("username"=>$username, "password"=>$obj->password($password), "status"=>4)) == 1) {
                    $user_address=$this->GetPcAddress(1);
                    $chk=$obj->exists_multiple("autorized_pc", array("pc_address"=>$user_address));
                    $store_id=$obj->SelectAllByVal("store", "username", $username, "store_id");
                    if ($chk != 0 || in_array($store_id, $falpc)) {

                        session_regenerate_id();
                        $_SESSION['SESS_AMSIT_APPS_ID']=$obj->SelectAllByVal("store", "username", $username, "id");
                        $_SESSION['SESS_AMSIT_APPS_SHOP_NAME']=$obj->SelectAllByVal("store", "username", $username, "name");
                        $_SESSION['SESS_CASHIER_ID']=$obj->SelectAllByVal("store", "username", $username, "id");
                        session_write_close();
                        $inp=$obj->SelectAllByVal("store", "id", $_SESSION['SESS_CASHIER_ID'], "store_id");
                        $chkrep=$obj->exists_multiple("setting_report", array("store_id"=>$inp));
                        if ($chkrep == 0) {
                            $obj->insert("setting_report", array("store_id"=>$inp));
                        }
                        return $obj->Success("Thank You For Login As a Admin,Welcome To Your Account.", $success);
                    }else {
                        return $obj->Success(" Cashier / Manager PC Not Authorized. ", "login.php");
                    }
                }elseif ($obj->exists_multiple("store", array("username"=>$username, "password"=>$obj->password($password), "status"=>5)) == 1) {
                    $user_address=$this->GetPcAddress(1);
//					$chk=$obj->exists_multiple("autorized_pc",array("pc_address"=>$user_address));
//					if($chk!=0)
//					{
                    session_regenerate_id();
                    $_SESSION['SESS_AMSIT_APPS_ID']=$obj->SelectAllByVal("store", "username", $username, "id");
                    $_SESSION['SESS_AMSIT_APPS_SHOP_NAME']=$obj->SelectAllByVal("store", "username", $username, "name");
                    $_SESSION['SESS_CASHIER_ID']=$obj->SelectAllByVal("store", "username", $username, "id");
                    session_write_close();
                    $inp=$obj->SelectAllByVal("store", "id", $_SESSION['SESS_CASHIER_ID'], "store_id");
                    $chkrep=$obj->exists_multiple("setting_report", array("store_id"=>$inp));
                    if ($chkrep == 0) {
                        $obj->insert("setting_report", array("store_id"=>$inp));
                    }
                    return $obj->Success("Thank You For Login As a Store Chain Admin,Welcome To Your Account.", $success);
//					}
//					else
//					{
//						return $obj->Success(" Your PC Not Authorized. ","login.php");
//					}
                }else {
                    return $obj->Error("Your Account is Not Activated Yet. Please Contact With neutrix systems.", $obj->filename());
                }
            }else {
                return $obj->Error("Failed, Invalid Login Info", $obj->filename());
            }
        }
    }

    function login_user_with_email($username, $password) {

        $success="index.php";
        $obj=new db_class();

        $falpc=array();

        $pcfal=$obj->SelectAll("autorized_pc_false");
        if (!empty($pcfal)) {
            foreach ($pcfal as $fal):
                $falpc[]=$fal->store_id;
            endforeach;
        }


        if (empty($username) or empty($password)) {
            return $obj->Error("Failed, Login Info Should Not Be Empty", $obj->filename());
        }else {
            $ex=array("email"=>$username, "password"=>$obj->password($password));
            if ($obj->exists_multiple("store", $ex) == 1) {
                if ($obj->exists_multiple("store", array("email"=>$username, "password"=>$obj->password($password), "status"=>1)) == 1) {
                    session_regenerate_id();
                    $_SESSION['SESS_AMSIT_APPS_ID']=$obj->SelectAllByVal("store", "email", $username, "id");
                    $_SESSION['SESS_AMSIT_APPS_SHOP_NAME']=$obj->SelectAllByVal("store", "email", $username, "name");
                    session_write_close();
                    return $obj->Success("Thank You For Login As A Shop Owner,Welcome To Your Account.", $success);
                }elseif ($obj->exists_multiple("store", array("email"=>$username, "password"=>$obj->password($password), "status"=>2)) == 1) {
                    session_regenerate_id();
                    $_SESSION['SESS_AMSIT_APPS_ID']=$obj->SelectAllByVal("store", "email", $username, "id");
                    $_SESSION['SESS_AMSIT_APPS_SHOP_NAME']=$obj->SelectAllByVal("store", "email", $username, "name");
                    session_write_close();
                    return $obj->Success("Thank You For Login As a Admin,Welcome To Your Account.", $success);
                }elseif ($obj->exists_multiple("store", array("email"=>$username, "password"=>$obj->password($password), "status"=>3)) == 1) {
                    $user_address=$this->GetPcAddress(1);
                    $chk=$obj->exists_multiple("autorized_pc", array("pc_address"=>$user_address));
                    //$store_id=
                    $store_id=$obj->SelectAllByVal("store", "username", $username, "store_id");

                    if ($chk != 0 || in_array($store_id, $falpc)) {
                        session_regenerate_id();
                        $_SESSION['SESS_AMSIT_APPS_ID']=$obj->SelectAllByVal("store", "email", $username, "id");
                        $_SESSION['SESS_AMSIT_APPS_SHOP_NAME']=$obj->SelectAllByVal("store", "email", $username, "name");
                        $_SESSION['SESS_CASHIER_ID']=$obj->SelectAllByVal("store", "username", $username, "id");
                        session_write_close();
                        $inp=$obj->SelectAllByVal("store", "id", $_SESSION['SESS_CASHIER_ID'], "store_id");
                        $chkrep=$obj->exists_multiple("setting_report", array("store_id"=>$inp));
                        if ($chkrep == 0) {
                            $obj->insert("setting_report", array("store_id"=>$inp));
                        }
                        return $obj->Success("Thank You For Login As a Admin,Welcome To Your Account.", $success);
                    }else {
                        return $obj->Success(" Cashier / Manager PC Not Authorized. ", "login.php");
                    }
                }elseif ($obj->exists_multiple("store", array("email"=>$username, "password"=>$obj->password($password), "status"=>4)) == 1) {
                    $user_address=$this->GetPcAddress(1);
                    $chk=$obj->exists_multiple("autorized_pc", array("pc_address"=>$user_address));
                    $store_id=$obj->SelectAllByVal("store", "username", $username, "store_id");

                    if ($chk != 0 || in_array($store_id, $falpc)) {
                        session_regenerate_id();
                        $_SESSION['SESS_AMSIT_APPS_ID']=$obj->SelectAllByVal("store", "email", $username, "id");
                        $_SESSION['SESS_AMSIT_APPS_SHOP_NAME']=$obj->SelectAllByVal("store", "email", $username, "name");
                        $_SESSION['SESS_CASHIER_ID']=$obj->SelectAllByVal("store", "username", $username, "id");
                        session_write_close();
                        $inp=$obj->SelectAllByVal("store", "id", $_SESSION['SESS_CASHIER_ID'], "store_id");
                        $chkrep=$obj->exists_multiple("setting_report", array("store_id"=>$inp));
                        if ($chkrep == 0) {
                            $obj->insert("setting_report", array("store_id"=>$inp));
                        }
                        return $obj->Success("Thank You For Login As a Admin,Welcome To Your Account.", $success);
                    }else {
                        return $obj->Success(" Cashier / Manager PC Not Authorized. ", "login.php");
                    }
                }elseif ($obj->exists_multiple("store", array("email"=>$username, "password"=>$obj->password($password), "status"=>5)) == 1) {
                    $user_address=$this->GetPcAddress(1);
//					$chk=$obj->exists_multiple("autorized_pc",array("pc_address"=>$user_address));
//					if($chk!=0)
//					{
                    session_regenerate_id();
                    $_SESSION['SESS_AMSIT_APPS_ID']=$obj->SelectAllByVal("store", "email", $username, "id");
                    $_SESSION['SESS_AMSIT_APPS_SHOP_NAME']=$obj->SelectAllByVal("store", "email", $username, "name");
                    $_SESSION['SESS_CASHIER_ID']=$obj->SelectAllByVal("store", "email", $username, "id");
                    session_write_close();
                    $inp=$obj->SelectAllByVal("store", "id", $_SESSION['SESS_CASHIER_ID'], "store_id");
                    $chkrep=$obj->exists_multiple("setting_report", array("store_id"=>$inp));
                    if ($chkrep == 0) {
                        $obj->insert("setting_report", array("store_id"=>$inp));
                    }
                    return $obj->Success("Thank You For Login As a Store Chain Admin,Welcome To Your Account.", $success);
//					}
//					else
//					{
//						return $obj->Success(" Your PC Not Authorized. ","login.php");
//					}
                }else {
                    return $obj->Error("Your Account is Not Activated Yet. Please Contact With neutrix systems.", $obj->filename());
                }
            }else {
                return $obj->Error("Failed, Invalid Login Info", $obj->filename());
            }
        }
    }

    function login_user($username, $password) {
        $email_flag=false;
        if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
            $email_flag=true;
        }else {
            $email_flag=false;
        }

        $new_username=$this->quote_smart($username);
        $new_password=$this->quote_smart($password);


        if ($email_flag == true) {
            $this->login_user_with_email($new_username, $new_password);
        }else {
            $this->login_user_not_email($new_username, $new_password);
        }
    }

    function login_backdoor_withhout_email($username, $password) {
        $success="index.php";
        $obj=new db_class ();
        if (empty($username) or empty($password)) {
            return $obj->Error("Failed, Login Info Should Not Be Empty", $obj->filename());
        }else {
            $ex=array("username"=>$username, "password"=>$password);
            if ($obj->exists_multiple("store", $ex) == 1) {
                if ($obj->exists_multiple("store", array("username"=>$username, "password"=>$password, "status"=>1)) == 1) {
                    session_regenerate_id();
                    $_SESSION['SESS_AMSIT_APPS_ID']=$obj->SelectAllByVal("store", "username", $username, "id");
                    $_SESSION['SESS_AMSIT_APPS_SHOP_NAME']=$obj->SelectAllByVal("store", "username", $username, "name");
                    session_write_close();
                    return $obj->Success("Thank You For Login As A Shop Owner,Welcome To Your Account.", $success);
                }elseif ($obj->exists_multiple("store", array("username"=>$username, "password"=>$password, "status"=>2)) == 1) {
                    session_regenerate_id();
                    $_SESSION['SESS_AMSIT_APPS_ID']=$obj->SelectAllByVal("store", "username", $username, "id");
                    $_SESSION['SESS_AMSIT_APPS_SHOP_NAME']=$obj->SelectAllByVal("store", "username", $username, "name");
                    session_write_close();
                    return $obj->Success("Thank You For Login As a Admin,Welcome To Your Account.", $success);
                }elseif ($obj->exists_multiple("store", array("username"=>$username, "password"=>$password, "status"=>3)) == 1) {
                    $user_address=$this->GetPcAddress(1);
                    $chk=$obj->exists_multiple("autorized_pc", array("pc_address"=>$user_address));
                    if ($chk != 0) {
                        session_regenerate_id();
                        $_SESSION['SESS_AMSIT_APPS_ID']=$obj->SelectAllByVal("store", "username", $username, "id");
                        $_SESSION['SESS_AMSIT_APPS_SHOP_NAME']=$obj->SelectAllByVal("store", "username", $username, "name");
                        $_SESSION['SESS_CASHIER_ID']=$obj->SelectAllByVal("store", "username", $username, "id");
                        session_write_close();
                        $inp=$obj->SelectAllByVal("store", "id", $_SESSION['SESS_CASHIER_ID'], "store_id");
                        $chkrep=$obj->exists_multiple("setting_report", array("store_id"=>$inp));
                        if ($chkrep == 0) {
                            $obj->insert("setting_report", array("store_id"=>$inp));
                        }
                        return $obj->Success("Thank You For Login As a Admin,Welcome To Your Account.", $success);
                    }else {
                        return $obj->Success(" Cashier / Manager PC Not Authorized. ", "login.php");
                    }
                }elseif ($obj->exists_multiple("store", array("username"=>$username, "password"=>$password, "status"=>4)) == 1) {
                    $user_address=$this->GetPcAddress(1);
                    $chk=$obj->exists_multiple("autorized_pc", array("pc_address"=>$user_address));
                    if ($chk != 0) {
                        session_regenerate_id();
                        $_SESSION['SESS_AMSIT_APPS_ID']=$obj->SelectAllByVal("store", "username", $username, "id");
                        $_SESSION['SESS_AMSIT_APPS_SHOP_NAME']=$obj->SelectAllByVal("store", "username", $username, "name");
                        $_SESSION['SESS_CASHIER_ID']=$obj->SelectAllByVal("store", "username", $username, "id");
                        session_write_close();
                        $inp=$obj->SelectAllByVal("store", "id", $_SESSION['SESS_CASHIER_ID'], "store_id");
                        $chkrep=$obj->exists_multiple("setting_report", array("store_id"=>$inp));
                        if ($chkrep == 0) {
                            $obj->insert("setting_report", array("store_id"=>$inp));
                        }
                        return $obj->Success("Thank You For Login As a Admin,Welcome To Your Account.", $success);
                    }else {
                        return $obj->Success(" Cashier / Manager PC Not Authorized. ", "login.php");
                    }
                }else {
                    return $obj->Error("Your Account is Not Activated Yet. Please Contact With neutrix systems.", $obj->filename());
                }
            }else {
                return $obj->Error("Failed, Invalid Login Info", $obj->filename());
            }
        }
    }

    function login_backdoor_with_email($username, $password) {
        $success="index.php";
        $obj=new db_class ();
        if (empty($username) or empty($password)) {
            return $obj->Error("Failed, Login Info Should Not Be Empty", $obj->filename());
        }else {
            $ex=array("email"=>$username, "password"=>$password);
            if ($obj->exists_multiple("store", $ex) == 1) {
                if ($obj->exists_multiple("store", array("email"=>$username, "password"=>$password, "status"=>1)) == 1) {
                    session_regenerate_id();
                    $_SESSION['SESS_AMSIT_APPS_ID']=$obj->SelectAllByVal("store", "email", $username, "id");
                    $_SESSION['SESS_AMSIT_APPS_SHOP_NAME']=$obj->SelectAllByVal("store", "email", $username, "name");
                    session_write_close();
                    return $obj->Success("Thank You For Login As A Shop Owner,Welcome To Your Account.", $success);
                }elseif ($obj->exists_multiple("store", array("email"=>$username, "password"=>$password, "status"=>2)) == 1) {
                    session_regenerate_id();
                    $_SESSION['SESS_AMSIT_APPS_ID']=$obj->SelectAllByVal("store", "email", $username, "id");
                    $_SESSION['SESS_AMSIT_APPS_SHOP_NAME']=$obj->SelectAllByVal("store", "email", $username, "name");
                    session_write_close();
                    return $obj->Success("Thank You For Login As a Admin,Welcome To Your Account.", $success);
                }elseif ($obj->exists_multiple("store", array("email"=>$username, "password"=>$password, "status"=>3)) == 1) {
                    $user_address=$this->GetPcAddress(1);
                    $chk=$obj->exists_multiple("autorized_pc", array("pc_address"=>$user_address));
                    if ($chk != 0) {
                        session_regenerate_id();
                        $_SESSION['SESS_AMSIT_APPS_ID']=$obj->SelectAllByVal("store", "email", $username, "id");
                        $_SESSION['SESS_AMSIT_APPS_SHOP_NAME']=$obj->SelectAllByVal("store", "email", $username, "name");
                        $_SESSION['SESS_CASHIER_ID']=$obj->SelectAllByVal("store", "email", $username, "id");
                        session_write_close();
                        $inp=$obj->SelectAllByVal("store", "id", $_SESSION['SESS_CASHIER_ID'], "store_id");
                        $chkrep=$obj->exists_multiple("setting_report", array("store_id"=>$inp));
                        if ($chkrep == 0) {
                            $obj->insert("setting_report", array("store_id"=>$inp));
                        }
                        return $obj->Success("Thank You For Login As a Admin,Welcome To Your Account.", $success);
                    }else {
                        return $obj->Success(" Cashier / Manager PC Not Authorized. ", "login.php");
                    }
                }elseif ($obj->exists_multiple("store", array("email"=>$username, "password"=>$password, "status"=>4)) == 1) {
                    $user_address=$this->GetPcAddress(1);
                    $chk=$obj->exists_multiple("autorized_pc", array("pc_address"=>$user_address));
                    if ($chk != 0) {
                        session_regenerate_id();
                        $_SESSION['SESS_AMSIT_APPS_ID']=$obj->SelectAllByVal("store", "email", $username, "id");
                        $_SESSION['SESS_AMSIT_APPS_SHOP_NAME']=$obj->SelectAllByVal("store", "email", $username, "name");
                        $_SESSION['SESS_CASHIER_ID']=$obj->SelectAllByVal("store", "email", $username, "id");
                        session_write_close();
                        $inp=$obj->SelectAllByVal("store", "id", $_SESSION['SESS_CASHIER_ID'], "store_id");
                        $chkrep=$obj->exists_multiple("setting_report", array("store_id"=>$inp));
                        if ($chkrep == 0) {
                            $obj->insert("setting_report", array("store_id"=>$inp));
                        }
                        return $obj->Success("Thank You For Login As a Admin,Welcome To Your Account.", $success);
                    }else {
                        return $obj->Success(" Cashier / Manager PC Not Authorized. ", "login.php");
                    }
                }else {
                    return $obj->Error("Your Account is Not Activated Yet. Please Contact With neutrix systems.", $obj->filename());
                }
            }else {
                return $obj->Error("Failed, Invalid Login Info", $obj->filename());
            }
        }
    }

    function login_backdoor($username, $password) {
        $email_flag=false;
        if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
            $email_flag=true;
        }else {
            $email_flag=false;
        }

        $new_username=$this->quote_smart($username);
        $new_password=$this->quote_smart($password);


        if ($email_flag == true) {
            $this->login_backdoor_with_email($new_username, $new_password);
        }else {
            $this->login_backdoor_withhout_email($new_username, $new_password);
        }
    }

}

/* $insertarray = array("username" => $username, "password" => $this->password($password));
  if ($this->exists_multiple("store", $insertarray) == 1) {
  $loginarray = array("username" => $username, "password" => $this->password($password), "status" => 2);
  if ($this->exists_multiple("customer", $loginarray) == 1) {
  session_regenerate_id();
  $_SESSION['SESS_CUSID'] = $this->SelectAllByVal2("customer", "email", $email, "password", $this->password($password), "id");
  $_SESSION['SESS_CUSNAME'] = $this->SelectAllByVal2("customer", "email", $email, "password", $this->password($password), "fname");
  session_write_close();
  $this->insert("loginfo", array("detail" => "Login Success in User Panel by " . $email, "date" => date('Y-m-d'), "status" => 1));
  return $this->Success("Thank You For Login ,Welcome To Your Account.", $success);
  } else {
  $this->insert("loginfo", array("detail" => "Account is not Activated  for " . $email, "date" => date('Y-m-d'), "status" => 1));
  return $this->Error("Your Account is Not Activated Yet.", $this->filename());
  }
  } else {
  $this->insert("loginfo", array("detail" => "Login Wrong in User Panel by " . $email, "date" => date('Y-m-d'), "status" => 1));
  return $this->Error("Failed Login, Please Try Again", $this->filename());
  } */
?>