<?php

include '../class/auth.php';
header("Content-type: application/json");
$verb = $_SERVER["REQUEST_METHOD"];
$table = "product";

if ($input_status == 1) {
    $migratecond = "";
} elseif ($input_status == 5) {

    $sqlchain_store_ids = $obj->SelectAllByID("store_chain_admin", array("sid" => $input_by));
    if (!empty($sqlchain_store_ids)) {

        $inner_cond = ' WHERE (';
        $i = 1;
        foreach ($sqlchain_store_ids as $ch):
            if ($i == 1) {
                $inner_cond .= "`p`.`input_by`='" . $ch->store_id . "'";
            } else {
                $inner_cond .= " OR `p`.`input_by`='" . $ch->store_id . "'";
            }
            $i++;
        endforeach;
        $inner_cond .=')';

        $migratecond = $cond . $inner_cond;


        //echo "Work";
    } else {
        //echo "Not Work";
        $migratecond = " WHERE a.id='0'";
    }
} else {

    $newcond = " WHERE `p`.`input_by`='" . $input_by . "'";
    $migratecond = $newcond;
}

if(empty($migratecond))
{
    $migratecond .=" AND p.`barcode` LIKE '%".$_GET['search']."%' ";
}
else
{
    $migratecond=" WHERE p.`barcode` LIKE '%".$_GET['search']."%' ";
}

$sql_coustomer = $obj->FlyQuery("select 
                    p.`id`,
                    p.`name`
                    from `product` as p 
                    " . $migratecond . " 
                    order by `p`.`name` DESC LIMIT 5");

$sqlCity = $sql_coustomer;
//$totalrows = $obj->totalrows($table);
echo json_encode($sqlCity);
?>
