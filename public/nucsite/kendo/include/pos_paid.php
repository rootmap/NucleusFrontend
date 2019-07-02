
<div class="span12" style="margin: 0px; padding: 0px;">
    <div class="table-overflow">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Item</th>

                    <th>QTY</th>
                    <th>U.Price</th>

                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="sales_list">
                <?php
                $sqlsaleslist = $obj->SelectAllByID($table2, array("sales_id" => $cart));
                $sss = 1;
                $subtotal = 0;
                $tax = 0;
                if (!empty($sqlsaleslist))
                    foreach ($sqlsaleslist as $saleslist):
                        if ($taxst == 1) {
                            $tax_charge = $tax_per_product;
                        } elseif ($taxst == 2) {
                            $tax_charge = $tax_per_product;
                        } else {
                            $tax_charge = 0;
                        }
                        $tax_charge = $tax_per_product;

                        if ($taxst == 2) {
                            $pid = $saleslist->pid;
                            $store_cost = $obj->SelectAllByVal("product", "id", $pid, "price_cost");
                            $caltax = ($store_cost * $tax_charge) / 100;
                        } else {
                            $caltax = ($saleslist->single_cost * $tax_charge) / 100;
                        }

                        $tax+=$caltax * $saleslist->quantity;
                        $procost = $saleslist->quantity * $saleslist->single_cost;
                        $subtotal+=$procost;
                        ?>
                        <tr>
                            <td><?php echo $sss; ?></td>
                            <td><?php echo $obj->SelectAllByVal($table, "id", $saleslist->pid, "name"); ?></td>

                            <td id="quantity<?php echo $saleslist->id; ?>"><?php echo $saleslist->quantity; ?></td>
                            <td id="<?php echo $saleslist->id; ?>" class="<?php echo $saleslist->sales_id; ?>"><button type="button" title="<?php echo $saleslist->single_cost; ?>" onclick="salesRowLiveEdit('sales_edit_<?php echo $saleslist->id; ?>')" id="sales_edit_<?php echo $saleslist->id; ?>" class="btn">$<?php echo $saleslist->single_cost; ?></button></td>

                            <td>
                                <button id="update<?php echo $saleslist->id; ?>" style="display: none;" type="button" name="trash" onClick="updateSalesData('<?php echo $saleslist->id; ?>',<?php echo $cart; ?>)"><i class="icon-edit"></i></button>
                                <button type="button" name="trash" onClick="delete_sales('<?php echo $saleslist->pid; ?>',<?php echo $cart; ?>)"><i class="icon-trash"></i></button>
                            </td>
                        </tr>
                        <?php
                        $sss++;
                    endforeach;
                ?>
            </tbody>
        </table>
    </div>
</div>

<div class="clearfix"></div>

<div class="span6 pull-right">
    <div class="table-overflow">
        <table class="table table-striped">
            <thead id="subtotal_list">
                <tr>
                    <th>Sub - Total: </th>
                    <th><?php echo number_format($subtotal, 2); ?></th>
                </tr>
                <tr>
                    <th>Tax: </th>
                    <th><?php
                        if ($taxst == 1) {
                            $taa = $tax;
                        } elseif ($taxst == 2) {
                            $taa = $tax;
                        } else {
                            $taa = 0;
                        }
                        echo number_format($taa, 2);
                        ?></th>
                </tr>
                <?php
                $sqlbuyback = $obj->exists_multiple("buyback", array("pos_id" => $_SESSION['SESS_CART']));
                if ($sqlbuyback == 0) {
                    $tradein = 0;
                } else {
                    ?>
                    <tr>
                        <th>Buyback: </th>
                        <th><?php
                            $tradein = $obj->SelectAllByVal("buyback", "pos_id", $_SESSION['SESS_CART'], "price");
                            echo number_format($tradein, 2);
                            ?></th>
                    </tr>
                    <?php
                }
                ?>
                <tr>
                    <th>Total: </th>
                    <th><?php
                        $total = ($subtotal + $taa) - $tradein;
                        echo number_format($total, 2);
                        $sqlexpayment = $obj->SelectAllByID_Multiple("invoice_payment", array("invoice_id" => $_SESSION['SESS_CART']));
                        $expaid_amount = 0;
                        if (!empty($sqlexpayment))
                            foreach ($sqlexpayment as $payments):
                                $expaid_amount+=$payments->amount;
                            endforeach;
                        ?></th>

                    <?php
                    if ($expaid_amount != 0 && $expaid_amount < $total) {
                        $exdue = $total - $expaid_amount;
                        ?>
                    <tr>
                        <th>Paid: </th>
                        <th><?php echo number_format($expaid_amount, 2); ?></th>
                    </tr>
                    <tr>
                        <th>Due: </th>
                        <th><?php echo number_format($exdue, 2); ?></th>
                    </tr>

                <?php } ?>
                </tr>
            </thead>
        </table>
    </div>
    <br>
    <div class="clear"></div>
</div>
<div class="clear"></div>
<div class="span12" style="float:right; padding: 5px; text-align: right;" id="paymentoption">
    <a  data-toggle="modal" href="#tradein" class="btn btn-primary "><i class="font-credit-card"></i> Trade - in </a> 
   


    <!--                                                <div class="clear"></div>-->
    <a href="checkin.php" class="btn btn-warning"><i class="icon-check"></i> Add Repair </a> 
    <a href="ticket.php" class="btn btn-info"><i class="icon-tags"></i> Add Ticket </a> 
     <a  data-toggle="modal" href="#paid" class="btn btn-success "><i class="font-credit-card"></i> Pay </a> 
    <div class="clear"></div>
</div>
<br>
<div class="clear"></div>
<br>
<br>
