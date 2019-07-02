<!-- General form elements -->
<!--    <div class="navbar">
        <div class="navbar-inner">
            <h5><i class="font-money"></i> POS Item Detail &AMP; Transaction 

            </h5>
        </div>
    </div>-->
    <a style="height: 0px; width: 0px;" id="NcM" data-toggle="modal" href="#myModal"></a>
    <script type="text/javascript">
        function Savecusid()
        {
            var cart = '<?php echo $cart; ?>';

            var options = {
                url: 'ajax/new_customer.php',
                type: 'get',
                dataType: 'json',
                success: function (response) {
                    new_customer(response, cart);
                    $("#closeModalNC").click();
                    $("#NCP").html(" : " + $("input[name='f_customer']").val() + " ");
                    window.refresh();
                }
            };
            $('#newposcustomer').ajaxSubmit(options);


        }
    </script>
    <!-- Dialog content -->
    <div id="myModal" class="modal hide fade" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <form id="newposcustomer" class="form-horizontal" method="post" action="">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h5 id="myModalLabel">Customer Detail <span id="mss"></span></h5>
            </div>
            <div class="modal-body">

                <div class="row-fluid">
                    <input type="hidden" name="st" value="9999" />
                    <div class="control-group">
                        <label class="control-label">Full Name :</label>
                        <div class="controls">
                            <input type="text"  name="f_customer" id="fristname" class="span6" placeholder="Customer name" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Business :</label>
                        <div class="controls">
                            <input class="span6" type="text" name="businessname" placeholder="Customer Business Name..." /></div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Phone Number </label>
                        <div class="controls">
                            <input class="span6" type="text" name="phonenumber" placeholder="Customer Phone" /></div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Email </label>
                        <div class="controls">
                            <input class="span6" type="text" name="email" placeholder="Customer Email here..." /></div>
                    </div>


                </div>

            </div>
            <div class="modal-footer">
                <button class="btn" id="closeModalNC" data-dismiss="modal">Close</button>
                <button class="btn btn-primary" type="button" onclick="Savecusid()">Save changes</button>
            </div></form>
    </div>
    <!-- /dialog content -->


    <!-- Dialog content -->
    <div id="myModal1" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h5 id="myModalLabel"> <?php
                $taxst = $obj->SelectAllByVal("pos_tax", "invoice_id", $cart, "status");
                echo $obj_pos->tax_status($taxst);
                ?> </h5>
        </div>
        <div class="modal-body">
            <form class="form-horizontal">
                <div class="row-fluid">

                    <div class="control-group">
                        <label class="control-label">You Can Change </label>
                        <div class="controls">
                            <label class="radio inline"><input type="radio" name="radio3" value="2" <?php if ($taxst == 2) { ?> checked="checked" <?php } ?> onClick="pos_tax('<?php echo $cart; ?>', '2')" class="style">Part Tax</label>
                            <label class="radio inline"><input type="radio" name="radio3" value="1" <?php if ($taxst == 1) { ?> checked="checked" <?php } ?> onClick="pos_tax('<?php echo $cart; ?>', '1')" class="style">Full Tax</label>
                            <label class="radio inline"><input type="radio" name="radio3" value="0" <?php if ($taxst == 0) { ?> checked="checked" <?php } ?>  onClick="pos_tax('<?php echo $cart; ?>', '0')" class="style" >No Tax</label>

                        </div>
                    </div>

                    <div class="control-group">
                        <div class="controls" id="pos_tax">

                        </div>
                    </div>

                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal">Close</button>
            <button class="btn btn-primary">Save changes</button>
        </div>
    </div>
    <!-- /dialog content -->






    <?php include('include/pos_paid.php'); ?>



    <!-- /general form elements -->


    <!-- Dialog paid -->
    <div id="paid" class="modal hide fade" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

            <h5 id="myModalLabel"> Payment Detail</h5>
        </div>
        <form class="form-horizontal" action="" method="post">
            <div class="modal-body">

                <div class="row-fluid">

                    <div class="control-group">
                        <label class="span4">Payment Method </label>
                        <div class="span8" id="newcus">
                            <select name="customername" id="customername" onChange="paytotal('<?php echo $cart; ?>', this.value)">
                                <?php
                                $sqlpdata = $obj->SelectAll("payment_method");
                                if (!empty($sqlpdata))
                                    foreach ($sqlpdata as $row):
                                        ?>
                                        <option value="<?php echo $row->id; ?>">
                                            <?php echo $row->meth_name; ?>
                                        </option>
                                        <?php
                                    endforeach;
                                ?>
                            </select>

                        </div>
                    </div>
                    <span id="ss">

                    </span>


                </div>

            </div>
            <div class="modal-footer" id="buttonshow"></div>
        </form>
    </div>

    <!-- /dialog paid -->





    <!-- Dialog content -->
    <div id="tradein" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <form class="form-horizontal" method="post" action="create_buyback.php">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h5 id="myModalLabel"><i class="icon-random"></i> Create Buyback For Trade-in <span id="mss"></span></h5>
            </div>
            <div class="modal-body">

                <?php
                if (!isset($_SESSION['SESS_CART_BUYBACK'])) {
                    $obj->newcart_buyback(@$_SESSION['SESS_CART_BUYBACK']);
                    $cart_trade_in = $obj->cart_buyback(@$_SESSION['SESS_CART_BUYBACK']);
                } else {
                    $cart_trade_in = $obj->cart_buyback(@$_SESSION['SESS_CART_BUYBACK']);
                }
                ?>
                <?php
                $getcid = $obj->SelectAllByVal("invoice", "invoice_id", $_SESSION['SESS_CART'], "cid");
                if ($getcid != '') {
                    ?>
                    <div class="row-fluid">

                        <div class="span6" style="margin: 0;">
                            <div class="control-group">
                                <input type="text" name="model" class="span12" placeholder="Model " />
                                <input type="hidden" name="buyback_id" value="<?php echo $cart_trade_in; ?>">
                                <input type="hidden" name="cid" value="<?php echo $getcid; ?>">
                            </div>

                            <div class="control-group">
                                <input type="text" name="carrier" class="span12" placeholder="Type Carrier Name" />
                            </div>

                            <div class="control-group">
                                <input type="text" name="imei" class="span12" placeholder="Put Device IMEI Number" />
                            </div>

                            <div class="control-group">
                                <input type="text" name="type_color" class="span12" placeholder="Please Type Color" />
                            </div>



                        </div>

                        <div class="span6">

                            <div class="control-group">
                                <input type="text" name="gig" class="span12" placeholder="Please Type Gig" />
                            </div>

                            <div class="control-group">
                                <input type="text" name="condition" class="span12" placeholder="Please Type Your Device Condition" />
                            </div>

                            <div class="control-group">
                                <input type="text" name="price" class="span12" placeholder="Please Type Price" />
                            </div>

                            <div class="control-group">
                                <?php
                                $sqlpm = $obj->SelectAll("payment_method");
                                $i = 1;
                                if (!empty($sqlpm))
                                    foreach ($sqlpm as $pm):
                                        if ($i == 1) {
                                            ?>
                                            <label class="radio inline"><input type="radio" checked name="payment_method" value="<?php echo $pm->id; ?>" class="style" id="pm_<?php echo $pm->id; ?>"><strong><?php echo $pm->meth_name; ?> </strong></label>
                                            <?php
                                        } else {
                                            ?>
                                            <label class="radio inline"><input type="radio" name="payment_method" value="<?php echo $pm->id; ?>" class="style" id="pm_<?php echo $pm->id; ?>"><strong><?php echo $pm->meth_name; ?> </strong></label>
                                            <?php
                                        }
                                        $i++;
                                    endforeach;
                                ?>
                            </div>




                        </div>


                    </div>
                <?php } else { ?>
                    <div class="row-fluid">
                        <label class="label label-warning">Please Select A Customer First</label>
                    </div>
                <?php } ?>
                <div class="modal-footer">
                    <input type="hidden" name="pos_id" value="<?php echo $_SESSION['SESS_CART']; ?>">
                    <button class="btn" data-dismiss="modal">Close</button>
                    <?php if ($getcid != '') { ?>
                        <button type="submit" name="create_tradein" class="btn btn-success"><i class="icon-ok"></i> Create BuyBack </button>
                    <?php } ?>
                </div>
        </form>
    </div>
    <!-- /dialog content -->




</div>

