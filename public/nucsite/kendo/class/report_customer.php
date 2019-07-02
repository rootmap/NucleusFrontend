<?php 
class report
{
	function count_invoice_report($cid,$table,$status)
	{
		$obj=new db_class();
		$count=$obj->exists_multiple($table,array("cid"=>$cid,"doc_type"=>$status));
		return $count;
	}
	
	function count_ticket_report($cid,$table)
	{
		$obj=new db_class();
		$count=$obj->exists_multiple($table,array("cid"=>$cid));
		return $count;
	}
	
	function count_parts_report($cid,$table)
	{
		$obj=new db_class();
		$datapart=$obj->SelectAll($table);
		$order=0;
		if(!empty($datapart))
		{
		foreach($datapart as $part):
			$count=$obj->exists_multiple("ticket",array("ticket_id"=>$part->ticket_id,"cid"=>$cid));
			if($count==0)
			{
				$order+=0;	
			}
			else
			{
				$order+=$count;	
			}
		endforeach;
		}
		else
		{
			$order+=0;
		}
		return $order;
	}
	
	
	//report datewise
	
	function ReportQuery_Datewise($object, $object_array,$date1,$date2,$st) {
        $obj=new db_class();
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

        $query = "SELECT * FROM `$object` r WHERE $fields and r.date >= '$date1' and r.date <= '$date2'";
        $result = mysqli_query($con, $query);
        if ($result) 
		{
            $count = mysqli_num_rows($result);

            if ($count >= 1) 
			{
				if($st==1)
				{
					while ($rows = $result->fetch_object()) 
					{
						$objects[] = $rows;
					}
					$obj->close($con);
					return $objects;
				}
				else
				{
					$obj->close($con);
					return $count;	
				}
            }
			else
			{
				$obj->close($con);
            	return 0;
			}
        } else {
            $obj->close($con);
            return 0;
        }
    }
	
	function ReportQuery_Datewise_single($object,$date1,$date2,$st) {
        $obj=new db_class();
		$count = 0;
        $fields = '';
        $con = $obj->open();

        $query = "SELECT * FROM `$object` r WHERE r.date >= '$date1' and r.date <= '$date2'";
        $result = mysqli_query($con, $query);
        if ($result) 
		{
            $count = mysqli_num_rows($result);

            if ($count >= 1) 
			{
				if($st==1)
				{
					while ($rows = $result->fetch_object()) 
					{
						$objects[] = $rows;
					}
					$obj->close($con);
					return $objects;
				}
				else
				{
					$obj->close($con);
					return $count;	
				}
            }
			else
			{
				$obj->close($con);
            	return 0;
			}
        } else {
            $obj->close($con);
            return 0;
        }
    }
	
	function count_invoice_report_single_date_sales($cid,$table,$status,$date1)
	{
		$obj=new db_class();
		$count=0;
		$countsql=$obj->SelectAllByID_Multiple($table,array("cid"=>$cid,"doc_type"=>$status,"date"=>$date1));
		if(!empty($countsql))
		{
			foreach($countsql as $ssdata):
				$sqlsales=$obj->exists_multiple("sales",array("sales_id"=>$ssdata->invoice_id));
				$count+=$sqlsales;
			endforeach;
		}
		else
		{
			$count=0;
		}
		return $count;
	}
	
	function count_invoice_report_single_date_invoice($cid,$table,$date1)
	{
		$obj=new db_class();
		$count=0;
		$countsql=$obj->SelectAllByID_Multiple($table,array("cid"=>$cid,"date"=>$date1));
		if(!empty($countsql))
		{
			foreach($countsql as $ssdata):
				$sqlsales=$obj->exists_multiple("sales",array("sales_id"=>$ssdata->invoice_id));
				if($sqlsales!=0)
				{
					$count+=1;
				}
				else
				{
					$count+=0;
				}
			endforeach;
		}
		else
		{
			$count=0;
		}
		return $count;
	}
	
	
	
	
	function count_invoice_report_date($cid,$table,$status,$date1,$date2)
	{
		$obj=new db_class();
		$count=$this->ReportQuery_Datewise($table,array("cid"=>$cid,"doc_type"=>$status),$date1,$date2,2);
		return $count;
	}
	
	function count_invoice_report_single_date($cid,$table,$status,$date1)
	{
		$obj=new db_class();
		$count=$obj->exists_multiple($table,array("cid"=>$cid,"doc_type"=>$status,"date"=>$date1));
		return $count;
	}
	
	
	function count_ticket_report_date($cid,$table,$date1,$date2)
	{
		$obj=new db_class();
		$count=$this->ReportQuery_Datewise($table,array("cid"=>$cid),$date1,$date2,2);
		return $count;
	}
	
	function count_ticket_report_single_date($cid,$table,$date1)
	{
		$obj=new db_class();
		$count=$obj->exists_multiple($table,array("cid"=>$cid,"date"=>$date1));
		return $count;
	}
	
	function count_parts_report_single_date($cid,$table,$date1)
	{
		$obj=new db_class();
		$datapart=$obj->SelectAllByID_Multiple($table,array("date"=>$date1));
		$order=0;
		if(!empty($datapart))
		{
		foreach($datapart as $part):
			$count=$obj->exists_multiple("ticket",array("ticket_id"=>$part->ticket_id,"cid"=>$cid,"date"=>$date1));
			if($count==0)
			{
				$order+=0;	
			}
			else
			{
				$order+=$count;	
			}
		endforeach;
		}
		else
		{
			$order+=0;
		}
		return $order;
	}
	
	function count_parts_report_date($cid,$table,$date1,$date2)
	{
		$obj=new db_class();
		$datapart=$this->ReportQuery_Datewise_single($table,$date1,$date2,1);
		$order=0;
		if(!empty($datapart))
		{
		foreach($datapart as $part):
			$count=$obj->ReportQuery_Datewise("ticket",array("ticket_id"=>$part->ticket_id,"cid"=>$cid),$date1,$date2,"2");
			if($count==0)
			{
				$order+=0;	
			}
			else
			{
				$order+=$count;	
			}
		endforeach;
		}
		else
		{
			$order+=0;
		}
		return $order;
	}
	
	
	function SelectAllDate($object,$from,$to,$status) 
	{
        $obj_pos = new db_class();
		$count = 0;
        $fields = '';
        $con = $obj_pos->open();
        $query = "SELECT * FROM `$object` t where t.date>='$from' and t.date<='$to' ORDER BY id DESC";
        $result = mysqli_query($con, $query);
        if ($result) {
            $count = mysqli_num_rows($result);

            if($status==1) 
			{
				$objects=array();
                while($rows = $result->fetch_object()) 
				{
                    $objects[] = $rows;
                }
				
                $obj_pos->close($con);
                return $objects;
            }
			else
			{
				$obj_pos->close($con);
                return $count;
			}
        }
    }
	
	function checkinlistdate($object,$v1,$v2,$status) 
	{
        $obj_pos = new db_class();
		$count = 0;
        $fields = '';
        $con = $obj_pos->open();
        $query = "SELECT * FROM `$object` where `date`='$v1' and `input_by`='$v2' ORDER BY id DESC";
        $result = mysqli_query($con, $query);
        if ($result) {
            $count = mysqli_num_rows($result);

            if($status==1) 
			{
				$objects=array();
                while($rows = $result->fetch_object()) 
				{
                    $objects[] = $rows;
                }
				
                $obj_pos->close($con);
                return $objects;
            }
			else
			{
				$obj_pos->close($con);
                return $count;
			}
        }
    }
	
	function SelectAllDate_Store($object,$from,$to,$status,$store_field,$store_value) 
	{
        $obj_pos = new db_class();
		$count = 0;
        $fields = '';
        $con = $obj_pos->open();
        $query = "SELECT * FROM `$object` t where `$store_field`='$store_value' AND t.date>='$from' AND t.date<='$to' ORDER BY id DESC";
        $result = mysqli_query($con, $query);
        if ($result) {
            $count = mysqli_num_rows($result);

            if($status==1) 
			{
				$objects=array();
                while($rows = $result->fetch_object()) 
				{
                    $objects[] = $rows;
                }
				
                $obj_pos->close($con);
                return $objects;
            }
			else
			{
				$obj_pos->close($con);
                return $count;
			}
        }
    }
	
	
	
	function SelectAllLimit_store($object,$limit,$storef,$input_by) 
	{
        $obj_pos = new db_class();
		$count = 0;
        $fields = '';
        $con = $obj_pos->open();
        $query = "SELECT * FROM `$object` WHERE `$storef`='$input_by' LIMIT $limit ORDER BY id DESC";
        $result = mysqli_query($con, $query);
        if ($result) {
            $count = mysqli_num_rows($result);
			
				$objects=array();
                while($rows = $result->fetch_object()) 
				{
                    $objects[] = $rows;
                }
				
                $obj_pos->close($con);
                return $objects;
        }
    }
	
	function SelectAllDateCond($object,$id,$val,$from,$to,$status) 
	{
        $obj_pos = new db_class();
		$count = 0;
        $fields = '';
        $con = $obj_pos->open();
        $query = "SELECT * FROM `$object` t where `$id`='$val' and t.date>='$from' and t.date<='$to' ORDER BY id DESC";
        $result = mysqli_query($con, $query);
        if ($result) {
            $count = mysqli_num_rows($result);

            if($status==1) 
			{
				$objects=array();
                while($rows = $result->fetch_object()) 
				{
                    $objects[] = $rows;
                }
				
                $obj_pos->close($con);
                return $objects;
            }
			else
			{
				$obj_pos->close($con);
                return $count;
			}
        }
    }
	
	function SelectAllDateCond_store2($object,$id,$val,$id2,$val2,$from,$to,$status) 
	{
        $obj_pos = new db_class();
		$count = 0;
        $fields = '';
        $con = $obj_pos->open();
        $query = "SELECT * FROM `$object` t where `$id`='$val' AND `$id2`='$val2' AND t.date>='$from' AND t.date<='$to' ORDER BY id DESC";
        $result = mysqli_query($con, $query);
        if ($result) {
            $count = mysqli_num_rows($result);

            if($status==1) 
			{
				$objects=array();
                while($rows = $result->fetch_object()) 
				{
                    $objects[] = $rows;
                }
				
                $obj_pos->close($con);
                return $objects;
            }
			else
			{
				$obj_pos->close($con);
                return $count;
			}
        }
    }
	
	function SelectAllDateCond_Store($object,$id,$val,$from,$to,$status) 
	{
        $obj_pos = new db_class();
		$count = 0;
        $fields = '';
        $con = $obj_pos->open();
        $query = "SELECT * FROM `$object` t where `$id`='$val' and t.date>='$from' and t.date<='$to' ORDER BY id DESC";
        $result = mysqli_query($con, $query);
        if ($result) {
            $count = mysqli_num_rows($result);

            if($status==1) 
			{
				$objects=array();
                while($rows = $result->fetch_object()) 
				{
                    $objects[] = $rows;
                }
				
                $obj_pos->close($con);
                return $objects;
            }
			else
			{
				$obj_pos->close($con);
                return $count;
			}
        }
    }
	
	
	
	function Product_report($object,$id,$val,$id1,$val1,$status) 
	{
        $obj_pos = new db_class();
		$count = 0;
        $fields = '';
        $con = $obj_pos->open();
        $query = "SELECT * FROM `$object` where `$id`='$val' || `$id1`='$val1'";
        $result = mysqli_query($con, $query);
        if ($result) {
            $count = mysqli_num_rows($result);

            if($status==1) 
			{
				$objects=array();
                while($rows = $result->fetch_object()) 
				{
                    $objects[] = $rows;
                }
				
                $obj_pos->close($con);
                return $objects;
            }
			else
			{
				$obj_pos->close($con);
                return $count;
			}
        }
    }
	
	function SelectAllDateCond2($object,$id,$val,$id1,$val1,$from,$to,$status) 
	{
        $obj_pos = new db_class();
		$count = 0;
        $fields = '';
        $con = $obj_pos->open();
        $query = "SELECT * FROM `$object` t where `$id`='$val' and `$id1`='$val1' and t.date>='$from' and t.date<='$to' ORDER BY id DESC";
        $result = mysqli_query($con, $query);
        if ($result) {
            $count = mysqli_num_rows($result);

            if($status==1) 
			{
				$objects=array();
                while($rows = $result->fetch_object()) 
				{
                    $objects[] = $rows;
                }
				
                $obj_pos->close($con);
                return $objects;
            }
			else
			{
				$obj_pos->close($con);
                return $count;
			}
        }
    }
	
	
	function SelectAllDateCondTimeStamp($object,$id,$val,$id1,$val1,$from,$to,$status) 
	{
        $obj_pos = new db_class();
		$count = 0;
        $fields = '';
        $con = $obj_pos->open();
		$query="SELECT * FROM `$object` WHERE `$id1`='$val1' AND `$id`='$val' AND timestamp BETWEEN '$from' AND '$to'";
        $result = mysqli_query($con, $query);
        if ($result) {
            $count = mysqli_num_rows($result);

            if($status==1) 
			{
				$objects=array();
                while($rows = $result->fetch_object()) 
				{
                    $objects[] = $rows;
                }
				
                $obj_pos->close($con);
                return $objects;
            }
			else
			{
				$obj_pos->close($con);
                return $count;
			}
        }
    }
	
	function SelectAllDateCondTime($object,$id,$val,$id1,$val1,$from,$to,$status) 
	{
        $obj_pos = new db_class();
		$count = 0;
        $fields = '';
        $con = $obj_pos->open();
		$query="SELECT * FROM `$object` WHERE `$id1`='$val1' and `$id`='$val' and datetime>='$from' AND datetime<='$to' ORDER BY id DESC";
        $result = mysqli_query($con, $query);
        if ($result) {
            $count = mysqli_num_rows($result);

            if($status==1) 
			{
				$objects=array();
                while($rows = $result->fetch_object()) 
				{
                    $objects[] = $rows;
                }
				
                $obj_pos->close($con);
                return $objects;
            }
			else
			{
				$obj_pos->close($con);
                return $count;
			}
        }
    }
	
	function SelectAllDateCondTime1($object,$id,$val,$from,$to,$status) 
	{
        $obj_pos = new db_class();
		$count = 0;
        $fields = '';
        $con = $obj_pos->open();
		$query="SELECT * FROM `$object` WHERE `$id`='$val' and datetime>='$from' AND datetime<='$to' ORDER BY id DESC";
        $result = mysqli_query($con, $query);
        if ($result) {
            $count = mysqli_num_rows($result);

            if($status==1) 
			{
				$objects=array();
                while($rows = $result->fetch_object()) 
				{
                    $objects[] = $rows;
                }
				
                $obj_pos->close($con);
                return $objects;
            }
			else
			{
				$obj_pos->close($con);
                return $count;
			}
        }
    }
	
	function SelectAllDateCondNot($object,$id,$val,$from,$to,$status) 
	{
        $obj_pos = new db_class();
		$count = 0;
        $fields = '';
        $con = $obj_pos->open();
        $query = "SELECT * FROM `$object` t where `$id`!='$val' and t.date>='$from' and t.date<='$to' ORDER BY id DESC";
        $result = mysqli_query($con, $query);
        if ($result) {
            $count = mysqli_num_rows($result);

            if($status==1) 
			{
				$objects=array();
                while($rows = $result->fetch_object()) 
				{
                    $objects[] = $rows;
                }
				
                $obj_pos->close($con);
                return $objects;
            }
			else
			{
				$obj_pos->close($con);
                return $count;
			}
        }
    }
	
	function SelectAllDateCondNot_Store($object,$id,$val,$from,$to,$status,$store_field,$store_value) 
	{
        $obj_pos = new db_class();
		$count = 0;
        $fields = '';
        $con = $obj_pos->open();
        $query = "SELECT * FROM `$object` t where `$id`!='$val' AND `$store_field`='$store_value' AND t.date>='$from' AND t.date<='$to' ORDER BY id DESC";
        $result = mysqli_query($con, $query);
        if ($result) {
            $count = mysqli_num_rows($result);

            if($status==1) 
			{
				$objects=array();
                while($rows = $result->fetch_object()) 
				{
                    $objects[] = $rows;
                }
				
                $obj_pos->close($con);
                return $objects;
            }
			else
			{
				$obj_pos->close($con);
                return $count;
			}
        }
    }
	
	function DeleteAllDateCondNot($object,$id,$val,$from,$to) 
	{
        $obj_pos = new db_class();
		$count = 0;
        $fields = '';
        $con = $obj_pos->open();
        $query = "DELETE FROM `$object` where `$id`!='$val' and date>='$from' and date<='$to' ORDER BY id DESC";
        $result = mysqli_query($con, $query);
        if ($result) 
		{
			$obj_pos->close($con);
			return 1;
        }
		else
		{
			$obj_pos->close($con);
			return 0;			
		}
    }
	
	function DeleteAllDateCondNot_Store($object,$id,$val,$from,$to,$store_field,$store_value) 
	{
        $obj_pos = new db_class();
		$count = 0;
        $fields = '';
        $con = $obj_pos->open();
        $query = "DELETE FROM `$object` where `$id`!='$val' AND `$store_field`='$store_value' AND date>='$from' AND date<='$to' ORDER BY id DESC";
        $result = mysqli_query($con, $query);
        if ($result) 
		{
			$obj_pos->close($con);
			return 1;
        }
		else
		{
			$obj_pos->close($con);
			return 0;			
		}
    }
	
	
	
	function SelectAllCondNot($object,$id,$val,$status) 
	{
        $obj_pos = new db_class();
		$count = 0;
        $fields = '';
        $con = $obj_pos->open();
        $query = "SELECT * FROM `$object` where `$id`!='$val' ORDER BY id DESC";
        $result = mysqli_query($con, $query);
        if ($result) {
            $count = mysqli_num_rows($result);

            if($status==1) 
			{
				$objects=array();
                while($rows = $result->fetch_object()) 
				{
                    $objects[] = $rows;
                }
				
                $obj_pos->close($con);
                return $objects;
            }
			else
			{
				$obj_pos->close($con);
                return $count;
			}
        }
    }
	
	function SelectAllCondNot_Store($object,$id,$val,$status,$store_field,$store_id) 
	{
        $obj_pos = new db_class();
		$count = 0;
        $fields = '';
        $con = $obj_pos->open();
        $query = "SELECT * FROM `$object` where `$id`!='$val' AND `$store_field`='$store_id' ORDER BY id DESC";
        $result = mysqli_query($con, $query);
        if ($result) {
            $count = mysqli_num_rows($result);

            if($status==1) 
			{
				$objects=array();
                while($rows = $result->fetch_object()) 
				{
                    $objects[] = $rows;
                }
				
                $obj_pos->close($con);
                return $objects;
            }
			else
			{
				$obj_pos->close($con);
                return $count;
			}
        }
    }
	
	function SelectAllCond_Store($object,$id,$val,$status,$store_field,$store_value) 
	{
        $obj_pos = new db_class();
		$count = 0;
        $fields = '';
        $con = $obj_pos->open();
        $query = "SELECT * FROM `$object` where `$id`='$val' AND `$store_field`='$store_value' ORDER BY id DESC";
        $result = mysqli_query($con, $query);
        if ($result) {
            $count = mysqli_num_rows($result);

            if($status==1) 
			{
				$objects=array();
                while($rows = $result->fetch_object()) 
				{
                    $objects[] = $rows;
                }
				
                $obj_pos->close($con);
                return $objects;
            }
			else
			{
				$obj_pos->close($con);
                return $count;
			}
        }
    }
	
	function DeleteAllCond($object,$id,$val) 
	{
        $obj_pos = new db_class();
		$count = 0;
        $fields = '';
        $con = $obj_pos->open();
        $query = "DELETE FROM `$object` where `$id`!='$val' ORDER BY id DESC";
        $result = mysqli_query($con, $query);
        if($result) 
		{

                $obj_pos->close($con);
                return 1;
		}
		else
		{
			$obj_pos->close($con);
			return 0;
		}
     
    }
	
	function DeleteAllCond_Store($object,$id,$val,$store_field,$store_value) 
	{
        $obj_pos = new db_class();
		$count = 0;
        $fields = '';
        $con = $obj_pos->open();
        $query = "DELETE FROM `$object` where `$id`!='$val' AND `$store_field`='$store_value' ORDER BY id DESC";
        $result = mysqli_query($con, $query);
        if($result) 
		{

                $obj_pos->close($con);
                return 1;
		}
		else
		{
			$obj_pos->close($con);
			return 0;
		}
     
    }
	//sum((select quantity from sales where sales.pid=product.id)) as soldquantity,
	
	function SelectAllOrder($object,$id,$asc) 
	{
		$obj=new db_class();
        $count = 0;
        $fields = '';
        $con = $obj->open();
        $query = "SELECT * FROM `$object` order by `$id` $asc";
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
	
	function SelectAllOrderCond1($object,$id,$asc,$id,$val) 
	{
		$obj=new db_class();
        $count = 0;
        $fields = '';
        $con = $obj->open();
        $query = "SELECT * FROM `$object` WHERE `$id`='$val' order by `$id` $asc";
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
	
	function SearchTrack($object,$st,$search,$pam1,$pam2,$pam3,$pam4,$pam5) 
	{
		$obj=new db_class();
        $count = 0;
        $fields = '';
        $con = $obj->open();
        $query = "SELECT * FROM `$object` WHERE `$pam1` LIKE '%" . $search . "%' OR `$pam2` LIKE '%" . $search ."%' OR `$pam3` LIKE '%" . $search ."%' OR `$pam4` LIKE '%" . $search ."%' OR `$pam5` LIKE '%" . $search ."%'";
        $result = mysqli_query($con, $query);
        if ($result) {
            $count = mysqli_num_rows($result);
			if($st==1)
			{
					$obj->close($con);
					return $count;
			}
			else
			{
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
    }
	
	function SearchTrack_Store($object,$st,$search,$pam1,$pam2,$pam3,$pam4,$pam5,$storef,$inputby) 
	{
		$obj=new db_class();
        $count = 0;
        $fields = '';
        $con = $obj->open();
        $query = "SELECT * FROM `$object` WHERE `$storef`='$inputby' AND `$pam1` LIKE '%" . $search . "%' OR `$pam2` LIKE '%" . $search ."%' OR `$pam3` LIKE '%" . $search ."%' OR `$pam4` LIKE '%" . $search ."%' OR `$pam5` LIKE '%" . $search ."%'";
        $result = mysqli_query($con, $query);
        if ($result) {
            $count = mysqli_num_rows($result);
			if($st==1)
			{
					$obj->close($con);
					return $count;
			}
			else
			{
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
    }
	
	function SearchTrackDateWise($object,$st,$search,$pam1,$pam2,$pam3,$pam4,$pam5,$from,$to) 
	{
		$obj=new db_class();
        $count = 0;
        $fields = '';
        $con = $obj->open();
        $query = "SELECT * FROM `$object` t WHERE `$pam1` LIKE '%" . $search . "%' OR `$pam2` LIKE '%" . $search ."%' OR `$pam3` LIKE '%" . $search ."%' OR `$pam4` LIKE '%" . $search ."%' OR `$pam5` LIKE '%" . $search ."%' and t.date>='$from' and t.date<='$to'";
        $result = mysqli_query($con, $query);
        if ($result) {
            $count = mysqli_num_rows($result);
			if($st==1)
			{
					$obj->close($con);
					return $count;
			}
			else
			{
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
    }
	
	function SearchTrackDateWise_store($object,$st,$search,$pam1,$pam2,$pam3,$pam4,$pam5,$from,$to,$storef,$inputby) 
	{
		$obj=new db_class();
        $count = 0;
        $fields = '';
        $con = $obj->open();
        $query = "SELECT * FROM `$object` t WHERE `$pam1` LIKE '%" . $search . "%' OR `$pam2` LIKE '%" . $search ."%' OR `$pam3` LIKE '%" . $search ."%' OR `$pam4` LIKE '%" . $search ."%' OR `$pam5` LIKE '%" . $search ."%' and t.date>='$from' and t.date<='$to' AND `$storef`='$inputby'";
        $result = mysqli_query($con, $query);
        if ($result) {
            $count = mysqli_num_rows($result);
			if($st==1)
			{
					$obj->close($con);
					return $count;
			}
			else
			{
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
    }
	
	
}
?>