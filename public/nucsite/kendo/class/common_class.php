<?php
class common_view
{
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
		
    
}
?>
