<?php
include('../class/auth.php');
extract($_GET);
$table = "sales";
$success = "<label class='label label-success'>Item Has Been Added to Cart</label>";
$updated = "<label class='label label-success'>Shopping Cart Updated</label>";
$error = "<label class='label label-danger'>Please Contact to Your System Provider</label>";
if ($sales_id != '') {

    $sqlsaleslist = $obj->SelectAllByID($table, array("sales_id" => $sales_id));
    $sss = 1;
    if (!empty($sqlsaleslist))
        foreach ($sqlsaleslist as $saleslist):
            ?>
            <tr>
                <td><?php echo $sss; ?></td>

                <td><?php echo $obj->SelectAllByVal("product", "id", $saleslist->pid, "name"); ?></td>

                <td id="quantity<?php echo $saleslist->id; ?>"><?php echo $saleslist->quantity; ?></td>
                <td id="<?php echo $saleslist->id; ?>" class="<?php echo $saleslist->sales_id; ?>"><button type="button" title="<?php echo $saleslist->single_cost; ?>" onclick="salesRowLiveEdit('sales_edit_<?php echo $saleslist->id; ?>')" id="sales_edit_<?php echo $saleslist->id; ?>" class="btn">$<?php echo $saleslist->single_cost; ?></button></td>

                <td>
                    <button id="update<?php echo $saleslist->id; ?>" style="display: none;" type="button" name="trash" onClick="updateSalesData('<?php echo $saleslist->id; ?>',<?php echo $sales_id; ?>)"><i class="icon-edit"></i></button>
                    <button type="button" name="trash" onClick="delete_sales('<?php echo $saleslist->pid; ?>',<?php echo $sales_id; ?>)"><i class="icon-trash"></i></button>
                </td>

            </tr>
            <?php
            $sss++;
        endforeach;
}
else {
    echo $error;
}
?>