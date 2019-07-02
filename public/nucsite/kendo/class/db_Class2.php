<?php
class db_class_site {
	
    public function open() {
      $con = mysqli_connect("localhost", "nucleusp_pos", "8vxs~(o(1Q{+", "nucleusp_posdemo");
       //$con = mysqli_connect("localhost", "nucleusp_pos", "8vxs~(o(1Q{+", "nucleusp_pos");
        return $con;
    }

    public function close($con) {
        mysqli_close($con);
    }
	
    function baseUrl($suffix = '') {
        $protocol = strpos($_SERVER['SERVER_SIGNATURE'], '443') !== false ? 'https://' : 'http://';
        $web_root = $protocol . $_SERVER['HTTP_HOST'] . "/" . "Dropbox/odesk/pos/";
		//$web_root = $protocol . $_SERVER['HTTP_HOST'] . "/" . "";
        $suffix = ltrim($suffix, '/');
        return $web_root . trim($suffix);
    }

    

    function Error($msg, $location) 
	{
       $errmsg_arr[] = "<div class='notice outer'>
                            <div class='note note-danger'>
                            <button type='button' class='close'>×</button>
                            <strong>Notice!</strong> " . $msg . "</div>
                        </div>";
       $error_flag= true;
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
        if (mysqli_query($con, $query)) {
            $this->close($con);
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
    function SelectAll($object) 
	{
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
	
	function SelectAllByID_Multiple_limit($object, $object_array,$limit) {
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
        $query = "SELECT * FROM `$object` WHERE `$field`='$fval'";
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
        $query = "SELECT * FROM `$object` WHERE `$field`='$fval' AND `$field2`='$fval2'";
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
	
	function SelectAllByVal3($object, $field, $fval, $field2, $fval2,$field3, $fval3, $value) {
        $count = 0;
        $fields = '';
        $con = $this->open();
        $query = "SELECT * FROM `$object` WHERE `$field`='$fval' AND `$field2`='$fval2' AND `$field3`='$fval3'";
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
	
	function SelectAllByVal4($object, $field, $fval, $field2, $fval2,$field3, $fval3,$field4, $fval4, $value) {
        $count = 0;
        $fields = '';
        $con = $this->open();
        $query = "SELECT * FROM `$object` WHERE `$field`='$fval' AND `$field2`='$fval2' AND `$field3`='$fval3' AND `$field4`='$fval4'";
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
        $query = "Delete FROM `$object` WHERE $fields";
        if (mysqli_query($con, $query)) {

            $this->close($con);
            return 1;
        } else {
            return 0;
        }
    }
	
	function deletesing($field,$id,$table) 
	{
     	
		if($this->delete($table,array($field=>$id))==1)
		{
			//$obj->Success();
			$this->Success("Successfully Deleted From System",$this->filename());	
		}
		else
		{
			$this->Error("Failed to delete",$this->filename());	
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
	
	function Update_product_incre($object,$f1,$val1,$f2,$val2) {
        $count = 0;
        $fields = '';
        $con = $this->open();
		$curquantity=$this->SelectAllByVal($object,$f2,$val2,$f1);
		$totalquantity=$curquantity+$val1;
        $query = "UPDATE `$object` SET `$f1`='$totalquantity' WHERE `$f2`='$val2'";
        $result = mysqli_query($con, $query);
        if ($result) 
		{
           $this->close($con);
           return 1;
        }
		else
		{
			$this->close($con);
            return 0;
		}
    }


/*	function getExtension($str) {
        $i = strrpos($str, ".");
        if (!$i) {
            return "";
        }
        $l = strlen($str) - $i;
        $ext = substr($str, $i + 1, $l);
        return $ext;
    }*/
	
	function upload_image($width, $height, $destination,$img_name,$pre) {
        list($w, $h) = getimagesize($_FILES[$img_name]['tmp_name']);
		$ret_name=$pre.'_'.time().''. $_FILES[$img_name]['name'];
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
	
	function upload_fiximage($destination,$img_name,$pre) {
        list($w, $h) = getimagesize($_FILES[$img_name]['tmp_name']);
		$ret_name=$pre.'_'.time().''. $_FILES[$img_name]['name'];
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

    

    function cleanQuery($string) {
        if (get_magic_quotes_gpc())
            $string = stripslashes($string);
        return mysql_escape_string($string);
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
	
	function duration($d1,$d2)
    {
        $d1 = new DateTime($d1);
        $d2 = new DateTime($d2);
        $interval = $d2->diff($d1);
		if($interval->format('%d')==0)
		{
			return "Today";
		}
		else
		{
			return $interval->format('%d days');
		}
        //return $interval->format('%d days, %H hours, %I minutes, %S seconds');
    }
	
	function daysgone($d1,$d2)
    {
        $d1 = new DateTime($d1);
        $d2 = new DateTime($d2);
        $interval = $d2->diff($d1);
		if($interval->format('%d')==0)
		{
			return "0";
		}
		else
		{
			return $interval->format('%d');
		}
        //return $interval->format('%d days, %H hours, %I minutes, %S seconds');
    }
	
	function durations($d1,$d2)
	{
		$d1 = new DateTime($d1);
		$d2 = new DateTime($d2);
		$interval = $d2->diff($d1);
					if($interval->format('%d')=='00')
					{
						if($interval->format('%H')=='00')
						{
							if($interval->format('%I')=='00')
							{
								
								if($interval->format('%S')=='00')
								{
									return $interval->format('%S ');
								}
								else
								{
									return $interval->format('%S ');
								}
							}
							else
							{
								return $interval->format('%I : %S Seconds');
							}
						}
						else
						{
							return $interval->format('%H : %I : %S Seconds');
						}
					}
					else
					{
						return $interval->format('%d , %H : %I : %S Seconds');
					}
	}
	
	
	

}


?>
