<?php
include('../class/auth.php');
extract($_GET);
$error = "<label class='label label-danger'>Failed Reload Page</label>";
if ($st == 1) {
    $chk = $obj->SelectAllByVal($table, $field, $value, $fetch);
    $idval = $obj->SelectAllByVal($table, $field, $value, $id);
    $autoid = time();
    if ($fetchplace == "tech_notes") {
        ?>
        <textarea name="<?php echo $autoid; ?>" id="<?php echo $autoid; ?>" value="<?php echo $chk; ?>" class="span8"></textarea>
    <?php } else { ?>
        <input type="text" name="<?php echo $autoid; ?>" id="<?php echo $autoid; ?>" value="<?php echo $chk; ?>" class="span6"  />
    <?php } ?>
    <button class="btnedit" type="button" name="tc" onClick="common_field_done('<?php echo $table; ?>', '<?php echo $field; ?>', '<?php echo $value; ?>', '<?php echo $fetch; ?>', '<?php echo $fetchplace; ?>', '<?php echo $id; ?>', '<?php echo $idval; ?>', '<?php echo $autoid; ?>')"><i class="icon-check"></i></button>

    <?php
} elseif ($st == 2) {
    if ($update = $obj->update($table, array($id => $idval, $fetch => $auto_val)) == 1) {
        ?>
        <?php echo $auto_val; ?>
        <button class="btnedit" type="button" name="tc" onClick="common_field_edit('<?php echo $table; ?>', '<?php echo $field; ?>', '<?php echo $value; ?>', '<?php echo $fetch; ?>', '<?php echo $fetchplace; ?>', '<?php echo $id; ?>')"><i class="icon-edit"></i></button>
        <div class="clear"></div>
        <?php
    } else {
        echo $error;
    }
} elseif ($st == 3) {
    $chk = $obj->SelectAllByVal($table, $field, $value, $fetch);
    $idval = $obj->SelectAllByVal($table, $field, $value, $id);
    $autoid = time();
    if ($chk == 0) {
        $checked = "";
    } else {
        $checked = "checked";
    }
    ?>
    <span class="checked">

        <input style="opacity: 0;" name="<?php echo $autoid; ?>" id="<?php echo $autoid; ?>"  value="1" class="style" checked="<?php echo $checked; ?>" type="checkbox" onClick="common_field_done('<?php echo $table; ?>', '<?php echo $field; ?>', '<?php echo $value; ?>', '<?php echo $fetch; ?>', '<?php echo $fetchplace; ?>', '<?php echo $id; ?>', '<?php echo $idval; ?>', 'this.value')"></span>
    <?php
} elseif ($st == 4) {
    if ($update = $obj->update($table, array($id => $idval, $fetch => $auto_val)) == 1) {
        $chk = $obj->SelectAllByVal($table, $field, $value, $fetch);
        if ($chk == 0) {
            $checked = "";
        } else {
            $checked = "checked";
        }
        ?>
        <span class="checked">
            <input style="opacity: 0;" name="<?php echo $autoid; ?>" id="<?php echo $autoid; ?>"  value="1" class="style" checked="<?php echo $checked; ?>" type="checkbox" onClick="common_field_edit('<?php echo $table; ?>', '<?php echo $field; ?>', '<?php echo $value; ?>', '<?php echo $fetch; ?>', '<?php echo $fetchplace; ?>', '<?php echo $id; ?>')"></span>
        <div class="clear"></div>
        <?php
    } else {
        echo $error;
    }
} elseif ($st == 5) {
    $chk = $obj->SelectAllByVal($table, $field, $value, $fetch);
    $autoid = time();
    if ($fetchplace == "tech_notes") {
        ?>
        <textarea name="<?php echo $autoid; ?>" id="<?php echo $autoid; ?>" class="span6"><?php echo $chk; ?></textarea>
    <?php }else{ ?>
        <input type="text" name="<?php echo $autoid; ?>" id="<?php echo $autoid; ?>" value="<?php echo $chk; ?>" class="span6"  />
    <?php } ?>
    <button class="btnedit" type="button" name="tc" onClick="SingleFieldDone('<?php echo $table; ?>', '<?php echo $field; ?>', '<?php echo $value; ?>', '<?php echo $fetch; ?>', '<?php echo $fetchplace; ?>', '<?php echo $autoid; ?>')"><i class="icon-check"></i></button>

    <?php
} elseif ($st == 6) {

    if ($obj->update($table, array($field => $value, $fetch => $auto_id)) == 1) {
        echo $auto_id;
        ?>
        <button class="btnedit" type="button" name="tc" onClick="SingleFieldEdit('<?php echo $table; ?>', '<?php echo $field; ?>', '<?php echo $value; ?>', '<?php echo $fetch; ?>', '<?php echo $fetchplace; ?>')"><i class="icon-edit"></i></button>

        <?php
    } else {
        "Reload Page";
    }
} else {
    echo $error;
}
?>