<?php

include('../class/auth.php');
extract($_POST);
if ($st == 1) {
    $dd='<option value=""></option>';
    $sql2=$obj->FlyQuery("SELECT " . $field_a . " as `id`," . $field_b . " as `show_name` from `" . $table . "` WHERE " . $field_b . " like '%" . $search . "%'");
    if (!empty($sql2)) {
        foreach ($sql2 as $rows):
            $dd .='<option value="' . $rows->id . '">' . $rows->show_name . '</option>';
        endforeach;
    }
    $makearray=array("data"=>$dd, "status"=>1);
    echo json_encode($makearray);
}
else {
    echo 0;
}
?>




















