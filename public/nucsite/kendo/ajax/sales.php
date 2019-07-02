<?php

include('../class/auth.php');
extract($_POST);
if ($st == 1) {
    if ($obj->exists_multiple("product", array("id"=>$id)) == 0) {
        $productarray=array("id"=>$id, "name"=>"", "price"=>"", "description"=>"", "quantity"=>"", "status"=>2);
    }else {
        $sqlproduct=$obj->FlyQuery("SELECT id,name as name,price_cost as price,price_retail,description,quantity FROM product WHERE id='" . $id . "'");
        if (!empty($sqlproduct)) {
            $productarray=array("id"=>$id, "name"=>$sqlproduct[0]->name, "price"=>$sqlproduct[0]->price, "description"=>$sqlproduct[0]->description, "quantity"=>$sqlproduct[0]->quantity, "status"=>1);
        }else {
            $productarray=array("id"=>$id, "name"=>"", "price"=>"", "description"=>"", "quantity"=>"", "status"=>0);
        }
    }

    echo json_encode($productarray);
}elseif ($st == 2) {
    //sales invoice generate start here
    $date=$_POST['invoice_date'];
    $duedate=$_POST['paid_date'];

    $subheading=$_POST['subheading'];
    $currency=9;

    $footer="";
    $poso="";
    $notes=$_POST['memo'];
    $currentdate=date('Y-m-d');

    $link_id=time();
    $branch_id=$shop_id;

    $ladgername="Accounts Receivables"; //dr

    $ledgerid=$obj->SelectAllByVal("account_module_ladger_list_properties", "head_sub_list_name", $ladgername, "id");
    $time=time();
    $invoicenew_id=$obj->insertAndReturnID("account_module_invoice", array("invoice_id"=>$time, "link_id"=>$link_id, "customer_id"=>$customer_id, "date"=>$date, "duedate"=>$duedate, "subheading"=>$subheading, "currency"=>$currency, "footer"=>$footer, "poso"=>$poso, "notes"=>$notes, "status"=>0, "branch_id"=>$branch_id, "input_by"=>$input_bys));

    $jdid=$invoicenew_id;

    foreach ($_POST['product'] as $index=> $val) {
        $itemid=$val['value'];
        $quantity=$_POST['quantity'][$index]['value'];
        $price=$_POST['unitprice'][$index]['value'];
        $tax=0;
        $rate=$obj->SelectAllByVal("account_module_newtax", "id", $tax, "rate");
        $main_tax_id=$obj->SelectAllByVal("account_module_newtax", "id", $tax, "main_id");
        $totalprice=$quantity * $price;
        $totalvat=$totalprice * $rate / 100;
        $totalamount=$totalprice + $totalvat;

        $income_account_id=$obj->SelectAllByVal("account_module_product", "id", $itemid, "in_ac_id");
        $invoice_id="S" . $jdid;
        $obj->insert("account_module_ladger", array("ladger_id"=>$ledgerid, "link_id"=>$link_id, "invoice_id"=>$invoice_id, "ladger_date"=>$currentdate, "debit"=>$totalamount, "cradit"=>0, "branch_id"=>$branch_id));
        //dr value account reciveable
        $obj->insert("account_module_ladger", array("ladger_id"=>$income_account_id, "link_id"=>$link_id, "invoice_id"=>$invoice_id, "ladger_date"=>$currentdate, "debit"=>0, "cradit"=>$totalprice, "branch_id"=>$branch_id));
        //cr value Income Account
        $obj->insert("account_module_ladger", array("ladger_id"=>$main_tax_id, "link_id"=>$link_id, "invoice_id"=>$invoice_id, "ladger_date"=>$currentdate, "debit"=>0, "cradit"=>$totalvat, "branch_id"=>$branch_id));
        //cr value For Tax

        $obj->insert("account_module_invoice_detail", array("invoice_id"=>$jdid, "link_id"=>$link_id, "pid"=>$itemid, "quantity"=>$quantity, "price"=>$price, "tax_id"=>$tax, "tax_total"=>$totalvat, "subtotal"=>$totalprice, "totalamount"=>$totalamount, "status"=>0, "branch_id"=>$branch_id));

        if ($obj->insert("account_module_stockout", array("sales_id"=>$jdid, "cid"=>$customer_id, "branch_id"=>$branch_id, "link_id"=>$link_id, "pid"=>$itemid, "quantity"=>$quantity, "sales_date"=>$date, "note"=>$notes, "input_by"=>$input_bys, "date"=>$currentdate, "status"=>1)) == 1) {
            $obj->FlyQueryExcute("UPDATE account_module_product SET quantity=quantity-$quantity WHERE id='$itemid'");
        }
    }

    echo 1;
    //sales invoice end here
}elseif ($st == 3) {
    //Sales Record Destroy
    $link_id=$obj->SelectAllByVal("account_module_invoice", "id", $id, "link_id");

    $obj->delete("account_module_ladger", array("link_id"=>$link_id));
    $obj->delete("account_module_invoice_detail", array("link_id"=>$link_id));
    $obj->delete("account_module_invoice_payment", array("link_id"=>$link_id));
    $obj->delete("account_module_invoice", array("link_id"=>$link_id));
    echo 1;
    //Sales Record Destroy
}elseif ($st == 4) {
    //Sales Record
    $salesdata='';
    $sql=$obj->FlyQuery("select a.id,
        a.invoice_id,
        a.customer_id,
        a.branch_id,
        a.link_id,
        a.currency,
        a.date,
        concat(d.fname,' ',d.lname) as `company_name`,
        IFNULL(SUM(amid.`quantity`),0) as `quantity`,
        IFNULL(SUM(amid.`price`),0) as `price`,
        IFNULL(SUM(amid.`subtotal`),0) as `subtotal`,
        IFNULL(SUM(amip.`amount`),0) as `amount`
        from account_module_invoice as a
        LEFT JOIN account_module_customer as d ON d.id=a.customer_id
        LEFT JOIN account_module_invoice_detail as amid ON amid.invoice_id=a.id
        LEFT JOIN account_module_invoice_payment as amip ON amip.invoice_id=a.id
        GROUP BY amid.invoice_id,amip.invoice_id");
    $i=1;
    if (!empty($sql))
        foreach ($sql as $row):
            $inid=$row->id;
            $link_id=$row->link_id;
            $invoice_id=$row->invoice_id;
            $branch_id=$row->branch_id;
            $cid=$row->customer_id;
            $totaldue=$row->subtotal;
            $total=$row->subtotal;
            $p=$row->amount;
            $tax_invoice=0;


            $salesdata .='<tr id="tr' . $row->id . '">
		<td>' . $i . '</td>
		<td><a href="view_sales.php?id=' . $row->id . '&amp;cid=' . $cid . '&amp;branch_id=' . $branch_id . '&amp;link_id=' . $link_id . '&amp;currency=' . $row->currency . '">Invoice ' . $row->id . '</a></td>
		<td>' . $obj->dates($row->date) . '</td>
		<td>' . $row->company_name . '</td>
		<td>';
            $amt=$total + $tax_invoice;
            $salesdata .=$obj->amountconvert($amt, 2);
            $salesdata .=' ' . $obj->SelectAllByVal("account_module_currency", "id", $currency, "detail") . '</td>';
            $salesdata .='<td>' . $obj->amountconvert($p, 2);
            $salesdata .=' ' . $obj->SelectAllByVal("account_module_currency", "id", $currency, "detail") . '</td>
		<td>';
            $amd=($totaldue + $tax_invoice) - $p;
            $salesdata .=$obj->amountconvert($amd, 2);
            $salesdata .=' ' . $obj->SelectAllByVal("account_module_currency", "id", $currency, "detail") . '</td>
		<td>';

            $due_total+=$amd;
            $payment_total+=$amt;

            $status=$row->status;
            if ($status == 0) {
                $salesdata .='<button type="button" class="btn btn-small" disabled="disabled"><font color="#FF0000">Unpaid</font></button>';
            }elseif ($status == 1) {

                $salesdata .='<button type="button" class="btn btn-warning btn-small" disabled="disabled">Partial</button>';
            }elseif ($status == 2) {

                $salesdata .='<button type="button" class="btn btn-success btn-small" disabled="disabled">Paid</button>';
            }


            $salesdata .='</td>
		<td>
		<a href="#" onClick="deleteR(' . $row->id . ')"><i class="icon-trash" ></i></a>';


            $totalam=$totaldue + $tax_invoice;
            if ($totalam == $p) {
                $obj->update("account_module_invoice", array("id"=>$inid, "status"=>2));
            }elseif ($p != 0) {
                $obj->update("account_module_invoice", array("id"=>$inid, "status"=>1));
            }elseif ($p == 0) {
                $obj->update("account_module_invoice", array("id"=>$inid, "status"=>0));
            }

            $salesdata .='</td></tr>';
            $i++;
        endforeach;

    $salesd=array("status"=>1, "salesdata"=>$salesdata);
    echo json_encode($salesd);
    //Sales Record
}elseif ($st == 5) {
    $viewinvoice=$obj->FlyQuery("SELECT a.`id`,
        a.`invoice_id`,
        a.`link_id`,
        concat(b.`fname`,' ',b.`lname`) as `customer_id`,
        a.`date`,
        a.`duedate`,
        a.`subheading`,
        a.`notes`,
        IFNULL(SUM(amip.`amount`),0) as `amount`,
        c.`name` as `branch_id` FROM account_module_invoice as a
        left join account_module_customer as b on b.`id`=a.`customer_id`
        left join store as c on c.`id`=a.`branch_id`
        left join account_module_invoice_payment as amip ON amip.invoice_id=a.invoice_id
        GROUP BY a.invoice_id WHERE a.id='$view'");

    $customer=$viewinvoice[0]->customer_id;
    $subheading=$viewinvoice[0]->subheading;
    $shop_id=$viewinvoice[0]->branch_id;
    $invoicedate=$obj->dates($viewinvoice[0]->date);
    $paiddate=$obj->dates($viewinvoice[0]->duedate);
    $notes=$viewinvoice[0]->notes;
    $invoice_id=$viewinvoice[0]->invoice_id;
    $paidamount=$viewinvoice[0]->amount;
    $link_id=$viewinvoice[0]->link_id;
    $subtotal=0;
    $subquantity=0;
    $subprice=0;
    $d=1;
    $newtr='';

    $sqlinvoice_detail=$obj->FlyQuery("SELECT a.`pid`,b.`pname` as `name`,b.`description` as `description`,a.`quantity`,a.`price`,a.`subtotal` FROM `account_module_invoice_detail` as a
left JOIN account_module_product as b on b.`id`=a.`pid` WHERE a.`invoice_id`='$view'");
    foreach ($sqlinvoice_detail as $detail):
        $newtr .='<tr>';
        $newtr .='<td>' . $d . '</td>';
        $newtr .='<td>' . $detail->name . '</td>';
        $newtr .='<td>' . $detail->description . '</td>';
        $newtr .='<td style="text-align:right;">' . $obj->amountconvert($detail->quantity, 2) . '</td>';
        $subquantity+=$detail->quantity;
        $newtr .='<td style="text-align:right;">' . $obj->amountconvert($detail->price, 2) . '</td>';
        $subprice+=$detail->price;
        $newtr .='<td style="text-align:right;">' . $obj->amountconvert($detail->subtotal, 2) . '</td>';
        $subtotal+=$detail->subtotal;
        $newtr .='</tr>';
        $d++;
    endforeach;

    $newtrfoot='';
    $newtrfoot .='<tr>';
    $newtrfoot .='<td style="text-align:left;" rowspan="3" colspan="4">
		<strong>Invoice ID :</strong> ' . $invoice_id . '<br>
		<strong>Track ID :</strong> ' . $link_id . '<br>
		<strong>Total Quantity :</strong> ' . $obj->amountconvert($subquantity, 2) . '<br>
		<strong>Total Unit Price Total :</strong> ' . $obj->amountconvert($subprice, 2) . '<br>
		</td>';
    $newtrfoot .='<td style="text-align:right;"><strong>Sub Total Amount = </strong></td>';
    $newtrfoot .='<td style="text-align:right;">' . $obj->amountconvert($subtotal, 2) . '</td>';
    $newtrfoot .='</tr>';

    $newtrfoot .='<tr>';
    $newtrfoot .='<td style="text-align:right;"><strong>Paid Amount =</strong> </td>';
    $newtrfoot .='<td style="text-align:right;">' . $obj->amountconvert($paidamount, 2) . '</td>';
    $newtrfoot .='</tr>';

    $dueamount=$subtotal - $paidamount;

    $newtrfoot .='<tr>';
    $newtrfoot .='<td style="text-align:right;"><strong>Due Amount =</strong> </td>';
    $newtrfoot .='<td style="text-align:right;">' . $obj->amountconvert($dueamount, 2) . '</td>';
    $newtrfoot .='</tr>';

    $ss=array("status"=>1,
        "customer"=>$customer,
        "subheading"=>$subheading,
        "shop_id"=>$shop_id,
        "invoicedate"=>$invoicedate,
        "paiddate"=>$paiddate,
        "notes"=>$notes,
        "invoice_id"=>$invoice_id,
        "datatr"=>$newtr, "datafot"=>$newtrfoot);

    echo json_encode($ss);
}
elseif ($st == 6) {
    //Sales Record
    $salesdata='';
    $sql=$obj->FlyQuery("SELECT alldata.* FROM (select
        a.id,
        a.invoice_id,
        a.customer_id,
        a.branch_id,
        a.link_id,
        a.currency,
        a.date,
        concat(d.fname,' ',d.lname) as `company_name`,
        IFNULL(SUM(amid.`quantity`),0) as `quantity`,
        IFNULL(SUM(amid.`price`),0) as `price`,
        IFNULL(SUM(amid.`subtotal`),0) as `subtotal`,
        IFNULL(SUM(amip.`amount`),0) as `amount`
        from account_module_invoice as a
        LEFT JOIN account_module_customer as d ON d.id=a.customer_id
        LEFT JOIN account_module_invoice_detail as amid ON amid.invoice_id=a.id
        LEFT JOIN account_module_invoice_payment as amip ON amip.invoice_id=a.id
        GROUP BY amid.invoice_id,amip.invoice_id) as alldata WHERE alldata.customer_id='" . $customer . "'");
    $i=1;
    $totalinvoice_amount=0;
    $totalinvoice_due_amount=0;
    $totalinvoice_paid_amount=0;
    if (!empty($sql))
        foreach ($sql as $row):
            $inid=$row->id;
            $link_id=$row->link_id;
            $invoice_id=$row->invoice_id;
            $branch_id=$row->branch_id;
            $cid=$row->customer_id;
            $totaldue=$row->subtotal;
            $total=$row->subtotal;
            $p=$row->amount;
            $tax_invoice=0;


            $salesdata .='<tr id="tr' . $row->id . '">
		<td>' . $i . '</td>
		<td><a href="view_sales.php?id=' . $row->id . '&amp;cid=' . $cid . '&amp;branch_id=' . $branch_id . '&amp;link_id=' . $link_id . '&amp;currency=' . $row->currency . '">Invoice ' . $row->id . '</a></td>
		<td>' . $obj->dates($row->date) . '</td>
		<td>';
            $amt=$total + $tax_invoice;
            $salesdata .=$obj->amountconvert($amt, 2);
            $salesdata .=' ' . $obj->SelectAllByVal("account_module_currency", "id", $currency, "detail") . '</td>';
            $salesdata .='<td>' . $obj->amountconvert($p, 2);
            $salesdata .=' ' . $obj->SelectAllByVal("account_module_currency", "id", $currency, "detail") . '</td>
		<td>';
            $amd=($totaldue + $tax_invoice) - $p;
            $salesdata .=$obj->amountconvert($amd, 2);
            $salesdata .=' ' . $obj->SelectAllByVal("account_module_currency", "id", $currency, "detail") . '</td>';

            $due_total+=$amd;
            $payment_total+=$amt;

            $status=$row->status;




            $totalam=$totaldue + $tax_invoice;
            if ($totalam == $p) {
                $obj->update("account_module_invoice", array("id"=>$inid, "status"=>2));
            }elseif ($p != 0) {
                $obj->update("account_module_invoice", array("id"=>$inid, "status"=>1));
            }elseif ($p == 0) {
                $obj->update("account_module_invoice", array("id"=>$inid, "status"=>0));
            }

            $salesdata .='</tr>';
            $i++;

            $totalinvoice_amount+=$amt;
            $totalinvoice_due_amount+=$amd;
            $totalinvoice_paid_amount+=$p;

        endforeach;
    $salesdatafotter='';
    $salesdatafotter .='<tr><td colspan="5" style="text-align:right; font-weight:bolder;">Total Amount : </td><td>' . $obj->amountconvert($totalinvoice_amount) . '</td></tr>';
    $salesdatafotter .='<tr><td colspan="5" style="text-align:right; font-weight:bolder;">Total Paid : </td><td>' . $obj->amountconvert($totalinvoice_paid_amount) . '</td></tr>';
    $salesdatafotter .='<tr><td colspan="5" style="text-align:right; font-weight:bolder;">Total Due : </td><td>' . $obj->amountconvert($totalinvoice_due_amount) . '</td></tr>';
    $salesd=array("status"=>1, "salesdata"=>$salesdata, "fotterdata"=>$salesdatafotter);
    echo json_encode($salesd);
    //Sales Record
}else {
    echo 0;
}
?>














