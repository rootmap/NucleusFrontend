<?php 
class report
{
	
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
	
	
}
?>