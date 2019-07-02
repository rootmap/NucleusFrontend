<?php
include('class/auth.php');
include('class/pos_class.php');
$obj_pos = new pos();
$cashier_id=$obj_pos->cashier_id(@$_SESSION['SESS_CASHIER_ID']);
$cashiers_id=$obj_pos->cashier_actual_id(@$_SESSION['SESS_CASHIER_ID']);
if($_POST)
{
	if($_POST["fetch"]=='1')
	{
	?>
    
                   <div class="modal-body">
    
                	<div class="row-fluid" id='storeprint'>
                
                        <span> <strong>Store Closing Detail | <?php echo date('m/d/Y'); ?></strong> </span>
                            <?php
                            include('class/report_customer.php');
                            $report=new report(); 
                            $opcdatetime=$obj->SelectAllByVal2("store_open","sid",$input_by,"status",1,"datetime");
                            //$opcdatetime="2014-09-30 21:31";
                            $sqlamountsales=$report->SelectAllDateCondTime("sales_list","input_by",$input_by,"payment_method","3",$opcdatetime,date('Y-m-d H:i'),1);
                            $amounts=0;
                            $cashtax=0;
                            if(!empty($sqlamountsales))
                            foreach($sqlamountsales as $sl):
                                $taxst2 = $obj->SelectAllByVal("pos_tax","invoice_id",$sl->sales_id,"status");
                                if ($taxst2 == 1) { $tax_charge2 = $tax_per_product; }
                                elseif ($taxst2 == 2) { $tax_charge2 = $tax_per_product; } 
                                else { $tax_charge2 = 0; }
                                $tax_charge2 = $tax_per_product;
                                
                                if($taxst2 == 2) {
                                     $taxrate=$obj->SelectAllByVal("tax","uid",$input_by,"tax");
                                     /*$tax=($sl->totalcost*$taxrate)/100;
                                     $cashtax+=$tax;
                                     $amounts+=$sl->totalcost+$tax;*/
                                    
                                     $pid=$obj->SelectAllByVal("sales","id",$sl->id,"pid");
                                     $store_cost=$obj->SelectAllByVal("product","id",$pid,"price_cost");	
                                     $tax = ($store_cost * $tax_charge2) / 100;
                                     $cashtax+=$tax;
                                     $amounts+=$sl->totalcost+$tax;
                                } 
                                elseif($taxst2 == 1) 
                                {
                                     $taxrate=$obj->SelectAllByVal("tax","uid",$input_by,"tax");
                                     $tax=($sl->totalcost*$taxrate)/100;
                                     $cashtax+=$tax;
                                     $amounts+=$sl->totalcost+$tax;
                                     
                                     /*$pid=$sl->pid;
                                     $store_cost=$obj->SelectAllByVal("product","id",$pid,"price_cost");	
                                     $tax = ($store_cost * $tax_charge2) / 100;
                                     $cashtax+=$tax;
                                     $amounts+=$sl->totalcost+$tax;*/
                                } 
                                else
                                {
                                     $cashtax+=0;
                                     $amounts+=$sl->totalcost;
                                }
                                
                            endforeach;
                            
                            
                            $sqlamountsales_cc=$report->SelectAllDateCondTime("transaction_log","input_by",$input_by,"sales_track","3",$opcdatetime,date('Y-m-d H:i'),1);
                            if(!empty($sqlamountsales_cc))
                            foreach($sqlamountsales_cc as $sl):
                                $taxst2 = $obj->SelectAllByVal("pos_tax","invoice_id",$sl->transaction,"status");
                                if ($taxst2 == 1) { $tax_charge2 = $tax_per_product; }
                                elseif ($taxst2 == 2) { $tax_charge2 = $tax_per_product; } 
                                else { $tax_charge2 = 0; }
                                $tax_charge2=$tax_per_product;
                                
                                if($taxst2==2) 
                                {
                                     $taxrate=$obj->SelectAllByVal("tax","uid",$input_by,"tax");								
                                     $pid=$obj->SelectAllByVal2("sales","sales_id",$sl->transaction,"payment_method",6,"pid");
                                     $store_cost=$obj->SelectAllByVal("product","id",$pid,"price_cost");	
                                     $tax =($store_cost * $tax_charge2) / 100;
                                     //algorithm
                                     $amounttaxtotal=$store_cost+$tax;
                                     $p1=($sl->amount*$tax)/$amounttaxtotal;
                                     $amountmintax=$sl->amount-$tax;
                                     $actual_amount_with_tax=$amountmintax+$p1;
                                     //algorithm
                                     
                                     $cashtax+=$p1;
                                     $amounts+=$actual_amount_with_tax;
                                } 
                                elseif($taxst2==1) 
                                {
                                     $taxrate=$obj->SelectAllByVal("tax","uid",$input_by,"tax");								
                                     $pid=$obj->SelectAllByVal2("sales","sales_id",$sl->transaction,"payment_method",6,"pid");
                                     $store_cost=$obj->SelectAllByVal("product","id",$pid,"price_retail");	
                                     $tax =($store_cost * $tax_charge2) / 100;
                                     //algorithm
                                     $amounttaxtotal=$store_cost+$tax;
                                     $p1=($sl->amount*$tax)/$amounttaxtotal;
                                     $amountmintax=$sl->amount-$tax;
                                     $actual_amount_with_tax=$amountmintax+$p1;
                                     //algorithm
                                     
                                     $cashtax+=$p1;
                                     $amounts+=$actual_amount_with_tax;
                                } 
                                else
                                {
                                     $cashtax+=0;
                                     $amounts+=$sl->amount;
                                }
                            endforeach;
                            
                            $sqlamountpayout=$report->SelectAllDateCondTime1("payout","uid",$input_by,$opcdatetime,date('Y-m-d H:i'),1);
                            $pam=0;
                            if(!empty($sqlamountpayout))
                            foreach($sqlamountpayout as $pa):
                                $pam+=$pa->amount;
                            endforeach;
                            
                            $sqlbuybackam=$report->SelectAllDateCondTime("buyback","input_by",$input_by,"payment_method","3",$opcdatetime,date('Y-m-d H:i'),1);
                            $backbcash=0;
                            if(!empty($sqlbuybackam))
                            foreach($sqlbuybackam as $buy):
                                $backbcash+=$buy->price;
                            endforeach;
                            
                            $sqlbuybackamc=$report->SelectAllDateCondTime("buyback","input_by",$input_by,"payment_method","4",$opcdatetime,date('Y-m-d H:i'),1);
                            $backbcradit=0;
                            if(!empty($sqlbuybackamc))
                            foreach($sqlbuybackamc as $buyc):
                                $backbcradit+=$buyc->price;
                            endforeach;
                            
    
                            
                            $sqlamountsalesp=$report->SelectAllDateCondTime("sales_list","input_by",$input_by,"payment_method","4",$opcdatetime,date('Y-m-d H:i'),1);
                            $amountsp=0;
                            $cratax=0;
                            if(!empty($sqlamountsalesp))
                            foreach($sqlamountsalesp as $slp):
                                $taxst2 = $obj->SelectAllByVal("pos_tax","invoice_id",$sl->sales_id,"status");
                                if ($taxst2 == 1) { $tax_charge2 = $tax_per_product; }
                                elseif ($taxst2 == 2) { $tax_charge2 = $tax_per_product; } 
                                else { $tax_charge2 = 0; }
                                $tax_charge2 = $tax_per_product;
                                
                                if($taxst2 == 2) {
                                     $taxrate=$obj->SelectAllByVal("tax","uid",$input_by,"tax");
                                     /*$tax=($sl->totalcost*$taxrate)/100;
                                     $cashtax+=$tax;
                                     $amounts+=$sl->totalcost+$tax;*/
                                    
                                     $pid=$obj->SelectAllByVal("sales","id",$sl->id,"pid");
                                     $store_cost=$obj->SelectAllByVal("product","id",$pid,"price_cost");	
                                     $tax = ($store_cost * $tax_charge2) / 100;
                                     $cratax+=$tax;
                                     $amountsp+=$sl->totalcost+$tax;
                                } 
                                elseif($taxst2 == 1) 
                                {
                                     $taxrate=$obj->SelectAllByVal("tax","uid",$input_by,"tax");
                                     $tax=($sl->totalcost*$taxrate)/100;
                                     $cratax+=$tax;
                                     $amountsp+=$sl->totalcost+$tax;
                                     
                                     /*$pid=$sl->pid;
                                     $store_cost=$obj->SelectAllByVal("product","id",$pid,"price_cost");	
                                     $tax = ($store_cost * $tax_charge2) / 100;
                                     $cashtax+=$tax;
                                     $amounts+=$sl->totalcost+$tax;*/
                                } 
                                else
                                {
                                     $cratax+=0;
                                     $amountsp+=$sl->totalcost;
                                }
                                /*if($obj->exists_multiple("pos_tax",array("invoice_id"=>$slp->sales_id,"status"=>2))==1)
                                {
                                    $cratax+=0;
                                    $amountsp+=$slp->totalcost;
                                }
                                else
                                {
                                    $taxrate=$obj->SelectAllByVal("tax","uid",$input_by,"tax");
                                    $tax=($slp->totalcost*$taxrate)/100;
                                    $cratax+=$tax;
                                    
                                    $amountsp+=$slp->totalcost+$tax;
                                }*/
                            endforeach;
                            
                            
                            $sqlamountsales_ccp=$report->SelectAllDateCondTime("transaction_log","input_by",$input_by,"sales_track","4",$opcdatetime,date('Y-m-d H:i'),1);
                            if(!empty($sqlamountsales_ccp))
                            foreach($sqlamountsales_ccp as $sl):
                                $taxst2 = $obj->SelectAllByVal("pos_tax","invoice_id",$sl->transaction,"status");
                                if ($taxst2 == 1) { $tax_charge2 = $tax_per_product; }
                                elseif ($taxst2 == 2) { $tax_charge2 = $tax_per_product; } 
                                else { $tax_charge2 = 0; }
                                $tax_charge2=$tax_per_product;
                                
                                if($taxst2==2) 
                                {
                                     $taxrate=$obj->SelectAllByVal("tax","uid",$input_by,"tax");								
                                     $pid=$obj->SelectAllByVal2("sales","sales_id",$sl->transaction,"payment_method",6,"pid");
                                     $store_cost=$obj->SelectAllByVal("product","id",$pid,"price_cost");	
                                     $tax =($store_cost * $tax_charge2) / 100;
                                     //algorithm
                                     $amounttaxtotal=$store_cost+$tax;
                                     $p1=($sl->amount*$tax)/$amounttaxtotal;
                                     $amountmintax=$sl->amount-$tax;
                                     $actual_amount_with_tax=$amountmintax+$p1;
                                     //algorithm
                                     
                                     $cratax+=$p1;
                                     $amountsp+=$actual_amount_with_tax;
                                } 
                                elseif($taxst2==1) 
                                {
                                     $taxrate=$obj->SelectAllByVal("tax","uid",$input_by,"tax");								
                                     $pid=$obj->SelectAllByVal2("sales","sales_id",$sl->transaction,"payment_method",6,"pid");
                                     $store_cost=$obj->SelectAllByVal("product","id",$pid,"price_retail");	
                                     $tax =($store_cost * $tax_charge2) / 100;
                                     //algorithm
                                     $amounttaxtotal=$store_cost+$tax;
                                     $p1=($sl->amount*$tax)/$amounttaxtotal;
                                     $amountmintax=$sl->amount-$tax;
                                     $actual_amount_with_tax=$amountmintax+$p1;
                                     //algorithm
                                     
                                     $cratax+=$p1;
                                     $amountsp+=$actual_amount_with_tax;
                                } 
                                else
                                {
                                     $cratax+=0;
                                     $amountsp+=$sl->amount;
                                }
                            endforeach;
                            
                            
                            $opc=$obj->SelectAllByVal2("store_open","sid",$input_by,"status",1,"opening_cash");
                            $totalclosinga=$amounts;
                            $paysback=$backbcash+$backbcradit;
                            $taxtotal=$cashtax+$cratax; 
                            $totalclosing=$totalclosinga-$opc-$pam-$paysback-$taxtotal;
                            $opcs=$obj->SelectAllByVal2("store_open","sid",$input_by,"status",1,"opening_sqaure");
                            $totalclosingpa=$amountsp;
                            $totalclosingp=$totalclosingpa-$opcs;
                            
                            $totalcl=$totalclosing+$totalclosingp;
                            $totalcashcollected=$amounts+$amountsp;
                            
                            
                            ?>
                        <div class="control-group">
                        <div class="table-overflow">
                                        
                             <table class="table table-striped" style="width:250px;">
                              <tr>
                            <td>Total Collection Cash/Credit Card :  </td><td>$<?php 
                            $tccc=$amounts+$amountsp; echo number_format($tccc,2); ?>  
                            
                            </td>
                            </tr>
                            <tr>
                            <td colspan="2"><div style="background:rgba(51,51,51,1); display:block; height:1px;"></div> </td>
                            </tr>
                            <tr>
                            <td>Cash Collected (+) :  </td><td>$<?php echo number_format($amounts,2); ?>  
                            
                            </td>
                            </tr>
                            <tr>
                            <td>Credit Card Collected (+) :  </td><td>$<?php echo number_format($amountsp,2); ?>  
                            
                            </td>
                            </tr>
                            <tr>
                            <td>Opening Cash (+) :  </td><td>$<?php if($opc==''){ $ddf=0; }else{ $ddf=$opc; } echo number_format($ddf,2); ?>  
                            
                            </td>
                            </tr>
                            <tr>
                            <td>Opening Credit Card (+) :  </td><td>$<?php if($opcs==''){ $ddfs=0; }else{ $ddfs=$opcs; } echo number_format($ddfs,2); ?>  
                            
                            </td>
                            </tr>
                           
    
                            <tr>
                            <td>Payout (+)(-) :  </td><td>$<?php echo number_format($pam,2); ?>  
                            
                            </td>
                            </tr>
                            <tr>
                            <td>BuyBack ( - )  :  </td><td>$<?php echo number_format($paysback,2); ?>  
                            
                            </td>
                            </tr>
                            <tr>
                            <td>Tax (-)  :  </td><td>$<?php echo number_format($taxtotal,2); ?>  
                            
                            </td>
                            </tr>
                            <tr>
                            <td colspan="2"><div style="background:rgba(51,51,51,1); display:block; height:1px;"></div> </td>
                            </tr>
                            
                            
                            
                            <tr>
                            <td>Current Cash :  </td><td>$<?php 
                            
                            
                            //$amounts
                            //$pam
                            
                            
                            if(substr($pam,0,1)=="-")
                            {
                                $min_pam=substr($pam,1,10000);
                                $plus_pam=0;	
                            }
                            elseif(substr($pam,0,1)=="+")
                            {
                                $min_pam=0;
                                $plus_pam=$pam;
                            }
                            else
                            {
                                $min_pam=0;
                                $plus_pam=$pam;
                            }
                            
                            $current_cash_collected=$amounts-$paysback-$min_pam+$plus_pam+$ddf;
                            $current_credit_card_collection=$amountsp+$ddfs;
                            
                            
                            
                            
                            
                            if(substr($pam,0,1)=="-")
                            {
                                $dam=substr($pam,1,100);
                                $pamm=0;	
                            }
                            else
                            {
                                $dam=0;
                                $pamm=$pam;
                            }
                            
                            $currentcash=$amounts+$amountsp+$ddf+$ddfs+$pamm;
                            $mincurcash=$dam+$paysback+$taxtotal;
                            $curcash=$currentcash-$mincurcash;
                            
                            
                            $pos_cash_alone=$amounts+$ddf+$pamm;
                            $pos_cash_alonet=$paysback+$dam;
                            $pos_current_cash=$pos_cash_alone-$pos_cash_alonet;
                            
                            $pos_cre_alone=$amountsp+$ddfs;
                            $pos_current_cre=$pos_cre_alone;
                            
                            //echo $pos_current_cash;
                            
                            echo number_format($current_cash_collected,2);
                             ?>  
                             </td>
                            </tr>
                            <tr>
                            <td>Current Credit Card :  </td><td>$<?php //echo $pos_current_cre; 
                            echo number_format($current_credit_card_collection,2);
                            ?>  
                            
                            </td>
                            </tr>
                            
                            
                            </table>
                            
                            </div>
                        </div>
                        <div class="control-group">
                             <h4> Current Total  : $<?php 
                             ///$totalcur=$pos_current_cash+$pos_current_cre;
                             $totalcur=$current_cash_collected+$current_credit_card_collection; 
                             echo number_format($totalcur,2); 
                             $stid=$obj->SelectAllByVal("cashier_list","id",$cashiers_id,"store_id");
                             ?> </h4>
                             
                             <input type="hidden" id="total_collection_cash_credit_card" name="total_collection_cash_credit_card" value="<?php echo number_format($tccc,2); ?>">
                             <input type="hidden" id="cash_collected_plus" name="cash_collected_plus" value="<?php echo number_format($amounts,2); ?>">
                             <input type="hidden" id="credit_card_collected_plus" name="credit_card_collected_plus" value="<?php echo number_format($amountsp,2); ?>">
                             <input type="hidden" id="opening_cash_plus" name="opening_cash_plus" value="<?php echo number_format($ddf,2); ?>">
                             <input type="hidden" id="opening_credit_card_plus" name="opening_credit_card_plus" value="<?php echo number_format($ddfs,2); ?>">
                             <input type="hidden" id="payout_plus_min" name="payout_plus_min" value="<?php echo number_format($pam,2); ?>">
                             <input type="hidden" id="buyback_min" name="buyback_min" value="<?php echo number_format($paysback,2); ?>">
                             <input type="hidden" id="tax_min" name="tax_min" value="<?php echo number_format($taxtotal,2); ?>">
                             <input type="hidden" id="current_cash" name="current_cash" value="<?php 
                             //echo $pos_current_cash;
                             echo number_format($current_cash_collected,2); 
                             ?>">
                             <input type="hidden" id="current_credit_card" name="current_credit_card" value="<?php 
                             //echo $pos_current_cre; 
                             echo number_format($current_credit_card_collection,2);
                             ?>">
                             <input class="span6" id="stcv" value="<?php echo number_format($totalcur,2);  ?>" type="hidden" name="totalcl" />
                        </div>
                        <!--"total_collection_cash_credit_card"+total_collection_cash_credit_card+"cash_collected_plus"+cash_collected_plus+"credit_card_collected_plus"+credit_card_collected_plus+"opening_cash_plus"+opening_cash_plus+"opening_credit_card_plus"+opening_credit_card_plus+"payout_plus_min"+payout_plus_min+"buyback_min"+buyback_min+"tax_min"+tax_min+"current_cash"+current_cash+"current_credit_card"+current_credit_card;-->
                </div>
    
            </div>
            <div class="modal-footer">
            <div class="span6" style="position:absolute; top:50px; right:10px;">
                <button class="btn btn-info" type="button" onClick="reload_pos_page()"><i class="icon-random"></i> Reload Page</button>
                <button type="submit" class="btn btn-primary"  name="storecloseing">Close Store</button>
                <!--<button type="button" class="btn btn-success"  onclick="javascript:printDiv('storeprint','<?php //echo $totalcur; ?>','<?php //echo $tccc; ?>','<?php //echo $amounts; ?>','<?php //echo $amountsp; ?>','<?php //echo $ddf; ?>','<?php //echo $ddfs; ?>','<?php //echo $pam; ?>','<?php //echo $paysback; ?>','<?php //echo $taxtotal; ?>','<?php //echo $pos_current_cash; ?>','<?php //echo $pos_current_cre; ?>','<?php //echo $cashiers_id; ?>','<?php //echo $stid; ?>')"  name="storecloseing_print">Close Store &amp; Print</button>-->
                <button type="button" class="btn btn-success"  onclick="javascript:printDiv('storeprint','<?php echo number_format($totalcur,2); ?>','<?php echo number_format($tccc,2); ?>','<?php echo number_format($amounts,2); ?>','<?php echo number_format($amountsp,2); ?>','<?php echo number_format($ddf,2); ?>','<?php echo number_format($ddfs,2); ?>','<?php echo number_format($pam,2); ?>','<?php echo number_format($paysback,2); ?>','<?php echo number_format($taxtotal,2); ?>','<?php echo number_format($current_cash_collected,2); ?>','<?php echo number_format($current_credit_card_collection,2); ?>','<?php echo number_format($cashiers_id,2); ?>','<?php echo $stid; ?>')"  name="storecloseing_print">Close Store &amp; Print</button>
            
            </div>
            </div>

        <?php
	}
	else
	{
		header('HTTP/1.1 500 Are you kiddin me? Empty Not Allowed To Submit');
    	exit();
	}
}
$obj->close($obj->open());