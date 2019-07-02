<?php

class chain_report {

    function ReportQuery_Datewise_Or_array($object, $object_array, $object_array2, $fid, $date1, $date2, $st) {
        $obj = new db_class();
        $count = 0;
        $fields = '';

        $count2 = 0;
        $fields2 = '';
        $con = $obj->open();
        foreach ($object_array as $col => $val) {
            if ($count++ != 0)
                $fields .= ' AND ';
            $col = mysqli_real_escape_string($con, $col);
            $val = mysqli_real_escape_string($con, $val);
            $fields .= "r.`$col` = '$val' ";
        }

        foreach ($object_array2 as $val2) {
            if ($count2++ != 0)
                $fields2 .= ' OR ';
            $val2 = mysqli_real_escape_string($con, $val2);
            $fields2 .= "alldata.`$fid` = '$val2'";
        }

        $query = "SELECT alldata.* 
        FROM (SELECT 
              * 
              FROM 
              `$object` AS r 
              WHERE $fields AND
              r.date >= '$date1' AND 
              r.date <= '$date2' 
              ORDER BY r.id DESC) as alldata 
        WHERE $fields2";

        //$query = "SELECT * FROM `$object` r WHERE $fields OR $fields2 and r.date >= '$date1' and r.date <= '$date2' ORDER BY id DESC";
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

    function ReportQuery_Datewise_Or($object, $object_array, $fid, $date1, $date2, $st) {
        $obj = new db_class();
        $count = 0;
        $fields = '';
        $con = $obj->open();
        foreach ($object_array as $val) {
            if ($count++ != 0)
                $fields .= ' OR ';
            $val = mysqli_real_escape_string($con, $val);
            $fields .= "alldata.`$fid` = '$val' ";
        }

        $query = "SELECT alldata.* 
        FROM (SELECT 
              * 
              FROM 
              `$object` AS r 
              WHERE 
              r.date >= '$date1' AND 
              r.date <= '$date2' 
              ORDER BY r.id DESC) as alldata 
        WHERE $fields";

        //$query = "SELECT * FROM `$object` r WHERE $fields and r.date >= '$date1' and r.date <= '$date2' ORDER BY id DESC";
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

    function SelectAllByID_Multiple_Or($object, $object_array, $fid, $st) {
        if (!isset($st)) {
            $obj_pos = new db_class();
            $count = 0;
            $fields = '';
            $con = $obj_pos->open();
            foreach ($object_array as $val) {
                if ($count++ != 0)
                    $fields .= ' OR ';
                $val = mysqli_real_escape_string($con, $val);
                $fields .= "`$fid` = '$val' ";
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
                    $obj_pos->close($con);
                    return $objects;
                }
            } else {
                $obj_pos->close($con);
                return 0;
            }
        } else {
            $obj_pos = new db_class();
            $count = 0;
            $fields = '';
            $con = $obj_pos->open();
            foreach ($object_array as $val) {
                if ($count++ != 0)
                    $fields .= ' OR ';
                $val = mysqli_real_escape_string($con, $val);
                $fields .= "`$fid` = '$val' ";
            }

            $query = "SELECT * FROM `$object` WHERE $fields ORDER BY id DESC";
            $result = mysqli_query($con, $query);
            if ($result) {
                $count = mysqli_num_rows($result);
                if ($st == 1) {
                    if ($count >= 1) {
                        //$object[]=array();
                        while ($rows = $result->fetch_object()) {
                            $objects[] = $rows;
                        }
                        $obj_pos->close($con);
                        return $objects;
                    }
                } else {
                    $obj_pos->close($con);
                    return $count;
                }
            } else {
                $obj_pos->close($con);
                return 0;
            }
        }
    }

    function SelectAllByID_Multiple_Or_array($object, $object_array, $object_array2, $fid, $st) {
        $obj_pos = new db_class();
        $count = 0;
        $fields = '';

        $count2 = 0;
        $fields2 = '';
        $con = $obj_pos->open();
        foreach ($object_array as $col => $val) {
            if ($count++ != 0)
                $fields .= ' AND ';
            $col = mysqli_real_escape_string($con, $col);
            $val = mysqli_real_escape_string($con, $val);
            $fields .= "`$col` = '$val' ";
        }

        foreach ($object_array2 as $val2) {
            if ($count2++ != 0)
                $fields2 .= ' OR ';
            $val2 = mysqli_real_escape_string($con, $val2);
            $fields2 .= "alldata.`$fid` = '$val2' ";
        }
        
        $query="SELECT alldata.* FROM 
        (SELECT 
         * 
         FROM 
         `$object` 
         WHERE 
         $fields) as alldata 
        WHERE $fields2
        ORDER BY alldata.id DESC";

        //$query = "SELECT * FROM `$object` WHERE $fields OR $fields2 ORDER BY id DESC";
        $result = mysqli_query($con, $query);
        if ($result) {
            $count = mysqli_num_rows($result);
            if ($st == 1) {
                if ($count >= 1) {
                    //$object[]=array();
                    while ($rows = $result->fetch_object()) {
                        $objects[] = $rows;
                    }
                    $obj_pos->close($con);
                    return $objects;
                }
            } else {
                $obj_pos->close($con);
                return $count;
            }
        } else {
            $obj_pos->close($con);
            return 0;
        }
    }

    function SelectAllByID_Multiple2_Or($object, $object_array, $object_array2, $fid, $st) {
        $obj_pos = new db_class();
        $count = 0;
        $fields = '';
        $count2 = 0;
        $fields2 = '';
        $con = $obj_pos->open();
        foreach ($object_array as $col => $val) {
            if ($count++ != 0)
                $fields .= ' AND ';
            $col = mysqli_real_escape_string($con, $col);
            $val = mysqli_real_escape_string($con, $val);
            $fields .= "`$col` = '$val' ";
        }

        foreach ($object_array2 as $val2) {
            if ($count2++ != 0)
                $fields2 .= ' OR ';
            $val2 = mysqli_real_escape_string($con, $val2);
            $fields2 .= "alldata.`$fid` = '$val2' ";
        }
        
        $query="SELECT alldata.* FROM 
        (SELECT 
         * 
         FROM 
         `$object` 
         WHERE 
         $fields) as alldata 
        WHERE $fields2
        ORDER BY alldata.id DESC";

        //return $query = "SELECT * FROM `$object` WHERE $fields OR $fields2 ORDER BY id DESC";
        $result = mysqli_query($con, $query);
        if ($result) {
            $count = mysqli_num_rows($result);
            if ($st == 1) {
                if ($count >= 1) {
                    //$object[]=array();
                    while ($rows = $result->fetch_object()) {
                        $objects[] = $rows;
                    }
                    $obj_pos->close($con);
                    return $objects;
                }
            } else {
                $obj_pos->close($con);
                return $count;
            }
        } else {
            $obj_pos->close($con);
            return 0;
        }
    }

    function SelectAllByID_Multiple2_Or_limit($object, $object_array, $object_array2, $fid, $st, $limit) {
        $obj_pos = new db_class();
        $count = 0;
        $fields = '';
        $count2 = 0;
        $fields2 = '';
        $con = $obj_pos->open();
        foreach ($object_array as $col => $val) {
            if ($count++ != 0)
                $fields .= ' AND ';
            $col = mysqli_real_escape_string($con, $col);
            $val = mysqli_real_escape_string($con, $val);
            $fields .= "`$col` = '$val' ";
        }

        foreach ($object_array2 as $val2) {
            if ($count2++ != 0)
                $fields2 .= ' OR ';
            $val2 = mysqli_real_escape_string($con, $val2);
            $fields2 .= "alldata.`$fid` = '$val2' ";
        }
        
        $query="SELECT alldata.* FROM 
        (SELECT 
         * 
         FROM 
         `$object` 
         WHERE 
         $fields) as alldata 
        WHERE $fields2
        ORDER BY alldata.id DESC LIMIT $limit";

        //$query = "SELECT * FROM `$object` WHERE $fields OR $fields2 ORDER BY id DESC LIMIT $limit";
        $result = mysqli_query($con, $query);
        if ($result) {
            $count = mysqli_num_rows($result);
            if ($st == 1) {
                if ($count >= 1) {
                    //$object[]=array();
                    while ($rows = $result->fetch_object()) {
                        $objects[] = $rows;
                    }
                    $obj_pos->close($con);
                    return $objects;
                }
            } else {
                $obj_pos->close($con);
                return $count;
            }
        } else {
            $obj_pos->close($con);
            return 0;
        }
    }

}

?>