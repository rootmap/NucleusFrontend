<?php 
class estimate
{
	function BuybackEstimate($object,$id1,$id2,$id3,$id4,$id5,$id6,$id7,$fetch,$status) 
	{
        $obj_pos = new db_class();
		$count = 0;
        $fields = '';
        $con = $obj_pos->open();
        $query = "SELECT * FROM `$object` where `nid`='$id1' AND `dtid`='$id2' AND `cid`='$id3' AND `dtoid`='$id4' AND `wdid`='$id5' AND `msid`='$id6' AND `model`='$id7' ORDER BY id DESC";
        $result = mysqli_query($con, $query);
        if ($result) {
            $count = mysqli_num_rows($result);

            if($status==1) 
			{
				$objects=array();
                $rows =mysqli_fetch_array($result); 
					$objects=$rows[$fetch];
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