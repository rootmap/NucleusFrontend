<?php
include('class/auth.php');
include('class/pos_class.php');
$obj_pos=new pos();
$cashier_id=$obj_pos->cashier_id(@$_SESSION['SESS_CASHIER_ID']);
$cashiers_id=$obj_pos->cashier_actual_id(@$_SESSION['SESS_CASHIER_ID']);
if ($_POST)
{
    if ($_POST["fetch"] == '1') {
        ?>
        <div class="modal-body">

            <div class="row-fluid" id='storeprint'>

                <span> <strong>Store Closing Detail | <?php echo date('m/d/Y'); ?></strong> </span>
                <?php
                include('class/report_customer.php');
                $report=new report();
                include('class/index.php');
                $index=new index();
                $opcdatetime=$obj->SelectAllByVal2("store_open", "sid", $input_by, "status", 1, "timestamp");
                //echo $input_by;
                echo "<br><br><br>";
                //$sqlamountsales=$report->SelectAllDateCondTimeStamp("invoice_payment","input_by",$input_by,"payment_type","3",$opcdatetime,date('Y-m-d H:i:s'),1);
                $sqlamountsales=$index->FlyQuery("SELECT A.* FROM
(SELECT id,invoice_id,amount,timestamp,(select b.`timestamp` from `store_open` as b where b.`sid`='" . $input_by . "' and b.`status`='1' LIMIT 1) as newtime FROM `invoice_payment` WHERE `input_by`='" . $input_by . "' AND `payment_type`='3') as A   WHERE timestamp BETWEEN A.newtime AND '" . date('Y-m-d H:i:s') . "'");
                $amounts=0;
                $cashtax=0;
                //echo count($sqlamountsales);
                if (!empty($sqlamountsales))
                    foreach ($sqlamountsales as $sl):
                        $taxst2=$obj->SelectAllByVal("pos_tax", "invoice_id", $sl->invoice_id, "status");
                        if ($taxst2 == 1) {
                            $tax_charge2=$tax_per_product;
                        }elseif ($taxst2 == 2) {
                            $tax_charge2=$tax_per_product;
                        }else {
                            $tax_charge2=0;
                        }
                        $tax_charge2=$tax_per_product;

                        $invoice_total_amount_three=$obj->SelectAllByID_Multiple("sales", array("sales_id"=>$sl->invoice_id));
                        $fullamount_three=0;
                        $fullamount_three_quantity=0;
                        if (!empty($invoice_total_amount_three))
                            foreach ($invoice_total_amount_three as $am):
                                $fullamount_three_quantity+=1;
                                $fullamount_three+=$am->totalcost;
                            endforeach;


                        if ($taxst2 == 2) {
                            $taxrate=$obj->SelectAllByVal("tax", "uid", $input_by, "tax");
                            $acttax=($fullamount_three * $taxrate) / 100;
                            $actcostndtax=$fullamount_three + $acttax;
                            if ($actcostndtax != $sl->amount) {
                                $cur_av_tax=($sl->amount * $taxrate) / $actcostndtax;
                                $cur_av_cost=$sl->amount - $cur_av_tax;
                                $cashtax+=$cur_av_tax; //view
                                $amounts+=$sl->amount; //view
                            }else {
                                $taxrate=$obj->SelectAllByVal("tax", "uid", $input_by, "tax");
                                $pidquery=$obj->SelectAllByID_Multiple("sales", array("sales_id", $sl->invoice_id));
                                if (!empty($pidquery))
                                    foreach ($pidquery as $piddata):
                                        $store_cost=$obj->SelectAllByVal("product", "id", $piddata->pid, "price_cost");
                                        $tax=($store_cost * $tax_charge2) / 100;
                                        $cashtax+=$tax;
                                    endforeach;
                                $amounts+=$sl->amount;
                            }
                        }
                        elseif ($taxst2 == 1) {

                            $taxrate=$obj->SelectAllByVal("tax", "uid", $input_by, "tax");
                            $acttax=($fullamount_three * $taxrate) / 100;
                            $actcostndtax=$fullamount_three + $acttax;
                            if ($actcostndtax != $sl->amount) {
                                @$cur_av_tax=($sl->amount * $taxrate) / $actcostndtax;
                                $cur_av_cost=$sl->amount - $cur_av_tax;
                                $cashtax+=$cur_av_tax; //view
                                $amounts+=$sl->amount; //view
                            }else {
                                $cashtax+=$acttax;
                                $amounts+=$sl->amount;
                            }
                            /* $taxrate=$obj->SelectAllByVal("tax","uid",$input_by,"tax");
                              $tax=($sl->amount*$taxrate)/100;
                              $cashtax+=$tax;
                              $amounts+=$sl->amount+$tax; */
                        }else {
                            $cashtax+=0;
                            $amounts+=$sl->amount;
                        }

                    endforeach;


                $sqlamountsales_cc=$index->FlyQuery("SELECT A.* FROM
(SELECT id,invoice_id,amount,concat(date,time) as timestamp,(select b.`timestamp` from `store_open` as b where b.`sid`='" . $input_by . "' and b.`status`='1' LIMIT 1) as newtime FROM `transaction_log` WHERE `input_by`='" . $input_by . "' AND `sales_track`='3') as A   WHERE timestamp BETWEEN A.newtime AND '" . date('Y-m-d H:i:s') . "'");

                //$report->SelectAllDateCondTime("transaction_log","input_by",$input_by,"sales_track","3",$opcdatetime,date('Y-m-d h:i:s'),1);
                if (!empty($sqlamountsales_cc))
                    foreach ($sqlamountsales_cc as $sl):
                        $taxst2=$obj->SelectAllByVal("pos_tax", "invoice_id", $sl->transaction, "status");
                        if ($taxst2 == 1) {
                            $tax_charge2=$tax_per_product;
                        }elseif ($taxst2 == 2) {
                            $tax_charge2=$tax_per_product;
                        }else {
                            $tax_charge2=0;
                        }
                        $tax_charge2=$tax_per_product;

                        if ($taxst2 == 2) {
                            $taxrate=$obj->SelectAllByVal("tax", "uid", $input_by, "tax");
                            $pid=$obj->SelectAllByVal2("sales", "sales_id", $sl->transaction, "payment_method", 6, "pid");
                            $store_cost=$obj->SelectAllByVal("product", "id", $pid, "price_cost");
                            $tax=($store_cost * $tax_charge2) / 100;
                            //algorithm
                            $amounttaxtotal=$store_cost + $tax;
                            $p1=($sl->amount * $tax) / $amounttaxtotal;
                            $amountmintax=$sl->amount - $tax;
                            $actual_amount_with_tax=$amountmintax + $p1;
                            //algorithm

                            $cashtax+=$p1;
                            $amounts+=$actual_amount_with_tax;
                        }elseif ($taxst2 == 1) {
                            $taxrate=$obj->SelectAllByVal("tax", "uid", $input_by, "tax");
                            $pid=$obj->SelectAllByVal2("sales", "sales_id", $sl->transaction, "payment_method", 6, "pid");
                            $store_cost=$obj->SelectAllByVal("product", "id", $pid, "price_retail");
                            $tax=($store_cost * $tax_charge2) / 100;
                            //algorithm
                            $amounttaxtotal=$store_cost + $tax;
                            $p1=($sl->amount * $tax) / $amounttaxtotal;
                            $amountmintax=$sl->amount - $tax;
                            $actual_amount_with_tax=$amountmintax + $p1;
                            //algorithm

                            $cashtax+=$p1;
                            $amounts+=$actual_amount_with_tax;
                        }else {
                            $cashtax+=0;
                            $amounts+=$sl->amount;
                        }
                    endforeach;

                $sqlamountpayout=$report->SelectAllDateCondTime1("payout", "uid", $input_by, $opcdatetime, date('Y-m-d H:i'), 1);
                $pam=0;
                if (!empty($sqlamountpayout))
                    foreach ($sqlamountpayout as $pa):
                        $pam+=$pa->amount;
                    endforeach;

                $sqlbuybackam=$report->SelectAllDateCondTime("buyback", "input_by", $input_by, "payment_method", "3", $opcdatetime, date('Y-m-d H:i'), 1);
                $backbcash=0;
                if (!empty($sqlbuybackam))
                    foreach ($sqlbuybackam as $buy):
                        $backbcash+=$buy->price;
                    endforeach;

                $sqlbuybackamc=$report->SelectAllDateCondTime("buyback", "input_by", $input_by, "payment_method", "4", $opcdatetime, date('Y-m-d H:i'), 1);
                $backbcradit=0;
                if (!empty($sqlbuybackamc))
                    foreach ($sqlbuybackamc as $buyc):
                        $backbcradit+=$buyc->price;
                    endforeach;




                $sqlamountsalesp=$index->FlyQuery("SELECT A.* FROM
(SELECT id,invoice_id,amount,timestamp,(select b.`timestamp` from `store_open` as b where b.`sid`='" . $input_by . "' and b.`status`='1' LIMIT 1) as newtime FROM `invoice_payment` WHERE `input_by`='" . $input_by . "' AND `payment_type`='4') as A   WHERE timestamp BETWEEN A.newtime AND '" . date('Y-m-d H:i:s') . "'");

                //$report->SelectAllDateCondTimeStamp("invoice_payment","input_by",$input_by,"payment_type","4",$opcdatetime,date('Y-m-d H:i:s'),1);
                $amountsp=0;
                $cratax=0;
                if (!empty($sqlamountsalesp))
                    foreach ($sqlamountsalesp as $slp):
                        $taxst2=$obj->SelectAllByVal("pos_tax", "invoice_id", $slp->invoice_id, "status");
                        if ($taxst2 == 1) {
                            $tax_charge2=$tax_per_product;
                        }elseif ($taxst2 == 2) {
                            $tax_charge2=$tax_per_product;
                        }else {
                            $tax_charge2=0;
                        }
                        $tax_charge2=$tax_per_product;

                        $invoice_total_amount_four=$obj->SelectAllByID_Multiple("sales", array("sales_id"=>$slp->invoice_id));
                        $fullamount_four=0;
                        $fullamount_four_quantity=0;
                        if (!empty($invoice_total_amount_four))
                            foreach ($invoice_total_amount_four as $am):
                                $fullamount_four_quantity+=1;
                                $fullamount_four+=$am->totalcost;
                            endforeach;

                        if ($taxst2 == 2) {

                            $taxrate=$obj->SelectAllByVal("tax", "uid", $input_by, "tax");
                            $acttax=($fullamount_four * $taxrate) / 100;
                            $actcostndtax=$fullamount_four + $acttax;
                            if ($actcostndtax != $slp->amount) {
                                $cur_av_tax=($sl->amount * $taxrate) / $actcostndtax;
                                $cur_av_cost=$sl->amount - $cur_av_tax;
                                $cratax+=$cur_av_tax; //view
                                $amountsp+=$slp->amount; //view
                            }else {
                                $taxrate=$obj->SelectAllByVal("tax", "uid", $input_by, "tax");
                                $pidquery=$obj->SelectAllByID_Multiple("sales", array("sales_id", $slp->invoice_id));
                                if (!empty($pidquery))
                                    foreach ($pidquery as $piddata):
                                        $store_cost=$obj->SelectAllByVal("product", "id", $piddata->pid, "price_cost");
                                        $tax=($store_cost * $tax_charge2) / 100;
                                        $cratax+=$tax;
                                    endforeach;
                                $amountsp+=$slp->amount;
                            }
                            /* $taxrate=$obj->SelectAllByVal("tax","uid",$input_by,"tax");
                              $pid=$obj->SelectAllByVal("sales","id",$sl->id,"pid");
                              $store_cost=$obj->SelectAllByVal("product","id",$pid,"price_cost");
                              $tax = ($store_cost * $tax_charge2) / 100;
                              $cratax+=$tax;
                              $amountsp+=$sl->amount+$tax; */
                        }
                        elseif ($taxst2 == 1) {
                            $taxrate=$obj->SelectAllByVal("tax", "uid", $input_by, "tax");
                            $acttax=($fullamount_four * $taxrate) / 100;
                            $actcostndtax=$fullamount_four + $acttax;
                            if ($actcostndtax != $slp->amount) {
                                $cur_av_tax=($sl->amount * $taxrate) / $actcostndtax;
                                $cur_av_cost=$sl->amount - $cur_av_tax;
                                $cratax+=$cur_av_tax; //view
                                $amountsp+=$slp->amount; //view
                            }else {
                                $cratax+=$acttax;
                                $amountsp+=$slp->amount;
                            }
                            /* $taxrate=$obj->SelectAllByVal("tax","uid",$input_by,"tax");
                              $tax=($sl->amount*$taxrate)/100;
                              $cratax+=$tax;
                              $amountsp+=$sl->amount+$tax; */
                        }else {
                            $cratax+=0;
                            $amountsp+=$slp->amount;
                        }
                    endforeach;


                $sqlamountsales_ccp=$index->FlyQuery("SELECT A.* FROM
(SELECT id,invoice_id,amount,concat(date,time) as timestamp,(select b.`timestamp` from `store_open` as b where b.`sid`='" . $input_by . "' and b.`status`='1' LIMIT 1) as newtime FROM `transaction_log` WHERE `input_by`='" . $input_by . "' AND `sales_track`='4') as A   WHERE timestamp BETWEEN A.newtime AND '" . date('Y-m-d H:i:s') . "'");


                //$report->SelectAllDateCondTime("transaction_log","input_by",$input_by,"sales_track","4",$opcdatetime,date('Y-m-d H:i'),1);


                if (!empty($sqlamountsales_ccp))
                    foreach ($sqlamountsales_ccp as $sl):
                        $taxst2=$obj->SelectAllByVal("pos_tax", "invoice_id", $sl->transaction, "status");
                        if ($taxst2 == 1) {
                            $tax_charge2=$tax_per_product;
                        }elseif ($taxst2 == 2) {
                            $tax_charge2=$tax_per_product;
                        }else {
                            $tax_charge2=0;
                        }
                        $tax_charge2=$tax_per_product;

                        if ($taxst2 == 2) {
                            $taxrate=$obj->SelectAllByVal("tax", "uid", $input_by, "tax");
                            $pid=$obj->SelectAllByVal2("sales", "sales_id", $sl->transaction, "payment_method", 6, "pid");
                            $store_cost=$obj->SelectAllByVal("product", "id", $pid, "price_cost");
                            $tax=($store_cost * $tax_charge2) / 100;
                            //algorithm
                            $amounttaxtotal=$store_cost + $tax;
                            $p1=($sl->amount * $tax) / $amounttaxtotal;
                            $amountmintax=$sl->amount - $tax;
                            $actual_amount_with_tax=$amountmintax + $p1;
                            //algorithm

                            $cratax+=$p1;
                            $amountsp+=$actual_amount_with_tax;
                        }elseif ($taxst2 == 1) {
                            $taxrate=$obj->SelectAllByVal("tax", "uid", $input_by, "tax");
                            $pid=$obj->SelectAllByVal2("sales", "sales_id", $sl->transaction, "payment_method", 6, "pid");
                            $store_cost=$obj->SelectAllByVal("product", "id", $pid, "price_retail");
                            $tax=($store_cost * $tax_charge2) / 100;
                            //algorithm
                            $amounttaxtotal=$store_cost + $tax;
                            $p1=($sl->amount * $tax) / $amounttaxtotal;
                            $amountmintax=$sl->amount - $tax;
                            $actual_amount_with_tax=$amountmintax + $p1;
                            //algorithm

                            $cratax+=$p1;
                            $amountsp+=$actual_amount_with_tax;
                        }else {
                            $cratax+=0;
                            $amountsp+=$sl->amount;
                        }
                    endforeach;


                $opc=$obj->SelectAllByVal2("store_open", "sid", $input_by, "status", 1, "opening_cash");
                $totalclosinga=$amounts;
                $paysback=$backbcash + $backbcradit;
                $taxtotal=$cashtax + $cratax;
                $totalclosing=$totalclosinga - $opc - $pam - $paysback - $taxtotal;
                $opcs=$obj->SelectAllByVal2("store_open", "sid", $input_by, "status", 1, "opening_sqaure");
                $totalclosingpa=$amountsp;
                $totalclosingp=$totalclosingpa - $opcs;

                $totalcl=$totalclosing + $totalclosingp;
                $totalcashcollected=$amounts + $amountsp;
                ?>
                <div class="control-group">
                    <div class="table-overflow">
                        <?php //echo $; ?>
                        <table class="table table-striped" style="width:250px; margin-top:-50px;">
                            <tr>
                                <td>Total Collection Cash/Credit Card :  </td><td>$<?php
                                    $tccc=$amounts + $amountsp;
                                    echo number_format($tccc, 2);
                                    ?>

                                </td>
                            </tr>
                            <tr>
                                <td colspan="2"><div style="background:rgba(51,51,51,1); display:block; height:1px;"></div> </td>
                            </tr>
                            <tr>
                                <td>Cash Collected (+) :  </td><td>$<?php echo number_format($amounts, 2); ?>

                                </td>
                            </tr>
                            <tr>
                                <td>Credit Card Collected (+) :  </td><td>$<?php echo number_format($amountsp, 2); ?>

                                </td>
                            </tr>
                            <tr>
                                <td>Opening Cash (+) :  </td><td>$<?php
                                    if (empty($opc)) {
                                        $ddf=0;
                                        echo 0;
                                    }else {
                                        $ddf=  floatval($opc);
                                        echo number_format($ddf, 2);
                                    } 
                                    
                                    
                                    ?>

                                </td>
                            </tr>
                            <tr>
                                <td>Opening Credit Card (+) :  </td><td>$<?php
                                    if (empty($opcs)) {
                                        $ddfs=0;
                                        echo 0;
                                    }else {
                                        $ddfs=floatval($opcs);
                                        echo number_format($ddfs, 2);
                                    } 
                                    
                                    
                                    ?>

                                </td>
                            </tr>


                            <tr>
                                <td>Payout (+)(-) :  </td><td>$<?php echo number_format($pam, 2); ?>

                                </td>
                            </tr>
                            <tr>
                                <td>BuyBack ( - )  :  </td><td>$<?php echo number_format($paysback, 2); ?>

                                </td>
                            </tr>
                            <tr>
                                <td>Tax (-)  :  </td><td>$<?php echo number_format($taxtotal, 2); ?>

                                </td>
                            </tr>
                            <tr>
                                <td colspan="2"><div style="background:rgba(51,51,51,1); display:block; height:1px;"></div> </td>
                            </tr>



                            <tr>
                                <td>Current Cash :  </td><td>$<?php
                                    //$amounts
                                    //$pam


                                    if (substr($pam, 0, 1) == "-") {
                                        $min_pam=substr($pam, 1, 10000);
                                        $plus_pam=0;
                                    }elseif (substr($pam, 0, 1) == "+") {
                                        $min_pam=0;
                                        $plus_pam=$pam;
                                    }else {
                                        $min_pam=0;
                                        $plus_pam=$pam;
                                    }

                                    $current_cash_collected=$amounts - $paysback - $min_pam + $plus_pam + $ddf;
                                    $current_credit_card_collection=$amountsp + $ddfs;





                                    if (substr($pam, 0, 1) == "-") {
                                        $dam=substr($pam, 1, 100);
                                        $pamm=0;
                                    }else {
                                        $dam=0;
                                        $pamm=$pam;
                                    }

                                    $currentcash=$amounts + $amountsp + $ddf + $ddfs + $pamm;
                                    $mincurcash=$dam + $paysback + $taxtotal;
                                    $curcash=$currentcash - $mincurcash;


                                    $pos_cash_alone=$amounts + $ddf + $pamm;
                                    $pos_cash_alonet=$paysback + $dam;
                                    $pos_current_cash=$pos_cash_alone - $pos_cash_alonet;

                                    $pos_cre_alone=$amountsp + $ddfs;
                                    $pos_current_cre=$pos_cre_alone;

                                    //echo $pos_current_cash;

                                    echo number_format($current_cash_collected, 2);
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Current Credit Card :  </td><td>$<?php
                                    //echo $pos_current_cre;
                                    echo number_format($current_credit_card_collection, 2);
                                    ?>

                                </td>
                            </tr>


                        </table>

                    </div>
                </div>
                <div class="control-group" style="margin-top:-20px;">
                    <h4> Current Total  : $<?php
                        ///$totalcur=$pos_current_cash+$pos_current_cre;
                        $totalcur=$current_cash_collected + $current_credit_card_collection;
                        echo number_format($totalcur, 2);
                        $stid=$obj->SelectAllByVal("cashier_list", "id", $cashiers_id, "store_id");
                        ?> </h4>

                    <input type="hidden" id="total_collection_cash_credit_card" name="total_collection_cash_credit_card" value="<?php echo number_format($tccc, 2); ?>">
                    <input type="hidden" id="cash_collected_plus" name="cash_collected_plus" value="<?php echo number_format($amounts, 2); ?>">
                    <input type="hidden" id="credit_card_collected_plus" name="credit_card_collected_plus" value="<?php echo number_format($amountsp, 2); ?>">
                    <input type="hidden" id="opening_cash_plus" name="opening_cash_plus" value="<?php echo number_format($ddf, 2); ?>">
                    <input type="hidden" id="opening_credit_card_plus" name="opening_credit_card_plus" value="<?php echo number_format($ddfs, 2); ?>">
                    <input type="hidden" id="payout_plus_min" name="payout_plus_min" value="<?php echo number_format($pam, 2); ?>">
                    <input type="hidden" id="buyback_min" name="buyback_min" value="<?php echo number_format($paysback, 2); ?>">
                    <input type="hidden" id="tax_min" name="tax_min" value="<?php echo number_format($taxtotal, 2); ?>">
                    <input type="hidden" id="current_cash" name="current_cash" value="<?php
                    //echo $pos_current_cash;
                    echo number_format($current_cash_collected, 2);
                    ?>">
                    <input type="hidden" id="current_credit_card" name="current_credit_card" value="<?php
                    //echo $pos_current_cre;
                    echo number_format($current_credit_card_collection, 2);
                    ?>">
                    <input class="span6" id="stcv" value="<?php echo number_format($totalcur, 2); ?>" type="hidden" name="totalcl" />
                </div>
                <!--"total_collection_cash_credit_card"+total_collection_cash_credit_card+"cash_collected_plus"+cash_collected_plus+"credit_card_collected_plus"+credit_card_collected_plus+"opening_cash_plus"+opening_cash_plus+"opening_credit_card_plus"+opening_credit_card_plus+"payout_plus_min"+payout_plus_min+"buyback_min"+buyback_min+"tax_min"+tax_min+"current_cash"+current_cash+"current_credit_card"+current_credit_card;-->
            </div>

        </div>
        <div class="modal-footer">
            <div class="span6" id="clstst" style="position:absolute; top:50px; right:10px; display: none;">
                <button type="submit" class="btn btn-primary"  name="storecloseing">Close Store</button>
                <!--<button type="button" class="btn btn-success"  onclick="javascript:printDiv('storeprint','<?php //echo $totalcur;            ?>','<?php //echo $tccc;            ?>','<?php //echo $amounts;            ?>','<?php //echo $amountsp;            ?>','<?php //echo $ddf;            ?>','<?php //echo $ddfs;            ?>','<?php //echo $pam;            ?>','<?php //echo $paysback;            ?>','<?php //echo $taxtotal;            ?>','<?php //echo $pos_current_cash;            ?>','<?php //echo $pos_current_cre;            ?>','<?php //echo $cashiers_id;            ?>','<?php //echo $stid;            ?>')"  name="storecloseing_print">Close Store &amp; Print</button>-->
                <button type="button" class="btn btn-success"  onclick="javascript:printDiv('storeprint', '<?php echo number_format($totalcur, 2); ?>', '<?php echo number_format($tccc, 2); ?>', '<?php echo number_format($amounts, 2); ?>', '<?php echo number_format($amountsp, 2); ?>', '<?php echo number_format($ddf, 2); ?>', '<?php echo number_format($ddfs, 2); ?>', '<?php echo number_format($pam, 2); ?>', '<?php echo number_format($paysback, 2); ?>', '<?php echo number_format($taxtotal, 2); ?>', '<?php echo number_format($current_cash_collected, 2); ?>', '<?php echo number_format($current_credit_card_collection, 2); ?>', '<?php echo number_format($cashiers_id, 2); ?>', '<?php echo $stid; ?>')"  name="storecloseing_print">Close Store &amp; Print</button>

            </div>

            <div class="span6" id="dfgd" style="position:absolute; top:50px; right:10px;">

                <a data-toggle="modal" onclick="hideex('myModal3')" href="#logout_store_close"  class="btn btn-primary">
                    <i class="icon-off"></i> Close Store
                </a>
                <a data-toggle="modal" onclick="hideex('myModal3')" href="#logout_store_close_n_p"  class="btn btn-success">
                    <i class="icon-off"></i> Close Store &amp; Print
                </a>

            </div>

        </div>

        <?php
    }else {
        header('HTTP/1.1 500 Are you kiddin me? Empty Not Allowed To Submit');
        exit();
    }
}
$obj->close($obj->open());
