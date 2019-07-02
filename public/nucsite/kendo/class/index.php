<?php
class index
{
	function sales_total_single($st,$table)
	{
		$obj=new db_class();
		$sqlsum=$obj->SelectAllByID_Multiple($table,array("doc_type"=>$st));
		$sum=0;
		if(!empty($sqlsum))
		{
			foreach($sqlsum as $sm):
			$sum+=1;
			endforeach;
		}
		else
		{
			$sum+=0;
		}
		return $sum;
	}
	
	
	function Ticket($table)
	{
		$obj=new db_class();
		$sqlsum=$obj->SelectAll($table);
		$sum=0;
		if(!empty($sqlsum))
		{
			foreach($sqlsum as $sm):
			$sum+=1;
			endforeach;
		}
		else
		{
			$sum+=0;
		}
		return $sum;
	}
	
	function SelectAllOrder($object,$id,$asc,$limit) 
	{
		$obj=new db_class();
        $count = 0;
        $fields = '';
        $con = $obj->open();
        $query = "SELECT * FROM `$object` order by `$id` $asc limit $limit ORDER BY id DESC";
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
	
	function FlyQuery($query) 
	{
		$obj=new db_class();
        $count = 0;
        $fields = '';
        $con = $obj->open();
        $result = mysqli_query($con, $query);
		//var_dump($result);
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
}
?>