<?php

//pos function start from here
class pos {

    function common_edit($table, $field1, $fval1, $fetch1, $fetchplace, $id, $emptytitle) {
        ?>
        <span id="<?php echo $fetchplace; ?>">
            <?php
            $obj_pos=new db_class();
            $tc=$obj_pos->SelectAllByVal($table, $field1, $fval1, $fetch1);
            if ($tc != '') {
                echo $tc;
                ?>
                <button class="btnedit" type="button" name="tc" onClick="common_field_edit('<?php echo $table; ?>', '<?php echo $field1; ?>', '<?php echo $fval1; ?>', '<?php echo $fetch1; ?>', '<?php echo $fetchplace; ?>', '<?php echo $id; ?>')"><i class="icon-edit"></i></button>
                <?php
            }else {
                echo $tc;
                ?>
                <button class="btnedit" type="button" name="tc" onClick="common_field_edit('<?php echo $table; ?>', '<?php echo $field1; ?>', '<?php echo $fval1; ?>', '<?php echo $fetch1; ?>', '<?php echo $fetchplace; ?>', '<?php echo $id; ?>')"><i class="icon-edit"></i> <?php echo $emptytitle; ?></button>
                <?php
            }
            ?>
        </span>
        <?php
    }

    function common_edit_view($table, $field1, $fval1, $fetch1, $fetchplace, $id, $emptytitle) {
        ?>
        <span id="<?php echo $fetchplace; ?>">
            <?php
            $obj_pos=new db_class();
            $tc=$obj_pos->SelectAllByVal($table, $field1, $fval1, $fetch1);
            if ($tc != '') {
                echo $tc;
            }else {
                echo $tc;
            }
            ?>
        </span>
        <?php
    }

    function common_edit_check($table, $field1, $fval1, $fetch1, $fetchplace, $id, $emptytitle) {
        ?>
        <span id="<?php echo $fetchplace; ?>">
            <?php
            $obj_pos=new db_class();
            $tc=$obj_pos->SelectAllByVal($table, $field1, $fval1, $fetch1);
            if ($tc != '') {
                $checked="checked";
                ?>
                <span class="checked"><input style="opacity: 0;" name="<?php echo $autoid; ?>" id="<?php echo $autoid; ?>"  value="1" class="style" checked="<?php echo $checked; ?>" type="checkbox"></span> <?php echo $emptytitle; ?>
                <button class="btnedit" type="button" name="tc" onClick="common_field_edit('<?php echo $table; ?>', '<?php echo $field1; ?>', '<?php echo $fval1; ?>', '<?php echo $fetch1; ?>', '<?php echo $fetchplace; ?>', '<?php echo $id; ?>')"><i class="icon-edit"></i></button>
                <?php
            }else {
                $checked="";
                ?>
                <span class="checked"><input style="opacity: 0;" name="<?php echo $autoid; ?>" id="<?php echo $autoid; ?>"  value="1" class="style" checked="<?php echo $checked; ?>" type="checkbox"></span>  <?php echo $emptytitle; ?>
                <button class="btnedit" type="button" name="tc" onClick="common_field_edit('<?php echo $table; ?>', '<?php echo $field1; ?>', '<?php echo $fval1; ?>', '<?php echo $fetch1; ?>', '<?php echo $fetchplace; ?>', '<?php echo $id; ?>')"><i class="icon-edit"></i></button>
                <?php
            }
            ?>
        </span>
        <?php
    }

    function SingleFieldEdit($table, $field1, $fval1, $fetch1, $fetchplace, $emptytitle) {
        ?>
        <span id="<?php echo $fetchplace; ?>">
            <?php
            $obj_pos=new db_class();
            $tc=$obj_pos->SelectAllByVal($table, $field1, $fval1, $fetch1);
            if ($tc != '') {
                echo $tc;
                ?>
                <button class="btnedit" type="button" name="tc" onClick="SingleFieldEdit('<?php echo $table; ?>', '<?php echo $field1; ?>', '<?php echo $fval1; ?>', '<?php echo $fetch1; ?>', '<?php echo $fetchplace; ?>')"><i class="icon-edit"></i></button>
                <?php
            }else {
                echo $tc;
                ?>
                <button class="btnedit" type="button" name="tc" onClick="SingleFieldEdit('<?php echo $table; ?>', '<?php echo $field1; ?>', '<?php echo $fval1; ?>', '<?php echo $fetch1; ?>', '<?php echo $fetchplace; ?>')"><i class="icon-edit"></i> <?php echo $emptytitle; ?></button>
                <?php
            }
            ?>
        </span>
        <?php
    }

    function SingleFieldEdit_view($table, $field1, $fval1, $fetch1, $fetchplace, $emptytitle) {
        ?>
        <span id="<?php echo $fetchplace; ?>">
            <?php
            $obj_pos=new db_class();
            $tc=$obj_pos->SelectAllByVal($table, $field1, $fval1, $fetch1);
            if ($tc != '') {
                echo $tc;
            }else {
                echo $tc;
            }
            ?>
        </span>
        <?php
    }

    function TicketStatusAjax($table, $field, $ticketId, $status, $fetchplace) {
        ?><span id="<?php echo $fetchplace; ?>">
            <span onclick="TicketStatus('<?php echo $table; ?>', '<?php echo $field; ?>', '<?php echo $ticketId; ?>', '<?php echo $status; ?>', '<?php echo $fetchplace; ?>')">
                <?php
                $obj_pos=new db_class();
                $tc=$obj_pos->SelectAllByVal($table, $field, $ticketId, $status);
                if ($tc != '') {
                    echo "<label class='label label-success'>" . $obj_pos->ticket_status($tc) . "</label>";
                }else {
                    echo "<label class='label label-success'>" . $obj_pos->ticket_status($tc) . "</label>";
                }
                ?>
            </span>	</span>
        <?php
    }

    function TicketStatusAjax_view($table, $field, $ticketId, $status, $fetchplace) {
        ?><span id="<?php echo $fetchplace; ?>">
            <span>
                <?php
                $obj_pos=new db_class();
                $tc=$obj_pos->SelectAllByVal($table, $field, $ticketId, $status);
                if ($tc != '') {
                    echo "<label class='label label-success'>" . $obj_pos->ticket_status($tc) . "</label>";
                }else {
                    echo "<label class='label label-success'>" . $obj_pos->ticket_status($tc) . "</label>";
                }
                ?>
            </span>	</span>
        <?php
    }

    function TicketProblemAjax($table, $field, $ticketId, $status, $fetchplace) {
        ?><span id="<?php echo $fetchplace; ?>">
            <span onclick="TicketProblem('<?php echo $table; ?>', '<?php echo $field; ?>', '<?php echo $ticketId; ?>', '<?php echo $status; ?>', '<?php echo $fetchplace; ?>')">
                <?php
                $obj_pos=new db_class();
                $tc=$obj_pos->SelectAllByVal($table, $field, $ticketId, $status);
                if ($tc != '') {
                    echo "<label class='label label-success'>" . $obj_pos->SelectAllByVal("problem_type", "id", $tc, "name") . "</label>";
                }else {
                    echo "<label class='label label-success'>" . $obj_pos->SelectAllByVal("problem_type", "id", $tc, "name") . "</label>";
                }
                ?>
            </span>	</span>
        <?php
    }

    function TicketProblemAjax_view($table, $field, $ticketId, $status, $fetchplace) {
        ?><span id="<?php echo $fetchplace; ?>">
            <span>
                <?php
                $obj_pos=new db_class();
                $tc=$obj_pos->SelectAllByVal($table, $field, $ticketId, $status);
                if ($tc != '') {
                    echo "<label class='label label-success'>" . $obj_pos->SelectAllByVal("problem_type", "id", $tc, "name") . "</label>";
                }else {
                    echo "<label class='label label-success'>" . $obj_pos->SelectAllByVal("problem_type", "id", $tc, "name") . "</label>";
                }
                ?>
            </span>	</span>
        <?php
    }

    function TicketWorkAjax($table, $field, $ticketId, $status, $fetchplace) {
        ?><span id="<?php echo $fetchplace; ?>">
            <span onclick="TicketWork('<?php echo $table; ?>', '<?php echo $field; ?>', '<?php echo $ticketId; ?>', '<?php echo $status; ?>', '<?php echo $fetchplace; ?>')">
                <?php
                $obj_pos=new db_class();
                $tc=$obj_pos->SelectAllByVal($table, $field, $ticketId, $status);
                if ($tc == 1) {
                    echo "<label>Yes</label>";
                }else {
                    echo "<label>No</label>";
                }
                ?>
            </span>	</span>
        <?php
    }

    function BuyBackWorkAjax($table, $field, $ticketId, $status, $fetchplace) {
        ?><span id="<?php echo $fetchplace; ?>">
            <span onclick="PaymentMethod('<?php echo $table; ?>', '<?php echo $field; ?>', '<?php echo $ticketId; ?>', '<?php echo $status; ?>', '<?php echo $fetchplace; ?>')">
                <?php
                $obj_pos=new db_class();
                $tc=$obj_pos->SelectAllByVal($table, $field, $ticketId, $status);
                if ($tc == 1) {
                    echo "<label>" . $obj_pos->SelectAllByVal("payment_method", "id", $tc, "meth_name") . "</label>";
                }else {
                    echo "<label>" . $obj_pos->SelectAllByVal("payment_method", "id", $tc, "meth_name") . "</label>";
                }
                ?>
            </span>	</span>
        <?php
    }

    function TicketWorkAjax_view($table, $field, $ticketId, $status, $fetchplace) {
        ?>
        <span id="<?php echo $fetchplace; ?>">
            <span>
                <?php
                $obj_pos=new db_class();
                $tc=$obj_pos->SelectAllByVal($table, $field, $ticketId, $status);
                if ($tc == 1) {
                    echo "<label>Yes</label>";
                }else {
                    echo "<label>No</label>";
                }
                ?>
            </span>
        </span>
        <?php
    }

    function TicketpaymentAjax($table, $field, $ticketId, $status, $fetchplace) {
        ?><span id="<?php echo $fetchplace; ?>">
            <span onclick="TicketPayment('<?php echo $table; ?>', '<?php echo $field; ?>', '<?php echo $ticketId; ?>', '<?php echo $status; ?>', '<?php echo $fetchplace; ?>')">
                <?php
                $obj_pos=new db_class();
                $tc=$obj_pos->SelectAllByVal($table, $field, $ticketId, $status);
                if ($tc != '') {
                    echo "<label class='label label-success'>" . $obj_pos->ticket_payment_status($tc) . "</label>";
                    if ($tc == 3) {
                        ?>
                        <div class="clear"></div>
                        <label id="partial_payment"> <strong>Partial Paid Amount :</strong> $<?php
                            $pramount=$obj_pos->SelectAllByVal("ticket", "ticket_id", $ticketId, "partial_amount");
                            if ($pramount == '') {
                                echo "0";
                            }else {
                                echo $pramount;
                            }
                            ?></label>
                        <?php
                    }
                }else {
                    echo "<label class='label label-success'>" . $obj_pos->ticket_payment_status($tc) . "</label>";
                    if ($tc == 3) {
                        ?>
                        <div class="clear"></div>
                        <label id="partial_payment"> <strong>Partial Paid Amount :</strong> $<?php
                            $pramount=$obj_pos->SelectAllByVal("ticket", "ticket_id", $ticketId, "partial_amount");
                            if ($pramount == '') {
                                echo "0";
                            }else {
                                echo $pramount;
                            }
                            ?></label>
                <?php
            }
        }
        ?>
            </span>	</span>
            <?php
        }

        function TicketpaymentAjax_view($table, $field, $ticketId, $status, $fetchplace) {
            ?><span id="<?php echo $fetchplace; ?>">
            <span>
                <?php
                $obj_pos=new db_class();
                $tc=$obj_pos->SelectAllByVal($table, $field, $ticketId, $status);
                if ($tc != '') {
                    echo "<label class='label label-success'>" . $obj_pos->ticket_payment_status($tc) . "</label>";
                    if ($tc == 3) {
                        ?>
                        <div class="clear"></div>
                        <label id="partial_payment"> <strong>Partial Paid Amount :</strong> $<?php
                            $pramount=$obj_pos->SelectAllByVal("ticket", "ticket_id", $ticketId, "partial_amount");
                            if ($pramount == '') {
                                echo "0";
                            }else {
                                echo $pramount;
                            }
                            ?></label>
                <?php
            }
        }else {
            echo "<label class='label label-success'>" . $obj_pos->ticket_payment_status($tc) . "</label>";
            if ($tc == 3) {
                ?>
                        <div class="clear"></div>
                        <label id="partial_payment"> <strong>Partial Paid Amount :</strong> $<?php
                        $pramount=$obj_pos->SelectAllByVal("ticket", "ticket_id", $ticketId, "partial_amount");
                        if ($pramount == '') {
                            echo "0";
                        }else {
                            echo $pramount;
                        }
                        ?></label>
                <?php
            }
        }
        ?>
            </span>	</span>
                <?php
            }

            function WarrentyWorkAjax($table, $field, $ticketId, $status, $fetchplace, $pid) {
                ?>
        <span id="<?php echo $fetchplace; ?>">
            <span onclick="Warrenty('<?php echo $table; ?>', '<?php echo $field; ?>', '<?php echo $ticketId; ?>', '<?php echo $status; ?>', '<?php echo $fetchplace; ?>', '<?php echo $pid; ?>')">
                <?php
                $obj_pos=new db_class();
                $tc=$obj_pos->SelectAllByVal($table, $field, $ticketId, $status);
                if (!empty($tc)) {
                    echo "<label>" . $tc . " Days</label>";
                }else {
                    $warrentys=$obj_pos->SelectAllByVal("product", "id", $pid, "warranty");


                    $war=$obj_pos->SelectAllByVal("warrenty", "warrenty_id", $ticketId, "warrenty");
                    $wardate=$obj_pos->SelectAllByVal("warrenty", "warrenty_id", $ticketId, "date");
                    if (empty($war)) {
                        if ($warrentys == '') {
                            $warrenty=0;
                        }else {
                            $warrenty=$warrentys;
                        }
                    }else {
                        $daysgone2=$obj_pos->daysgone($wardate, date('Y-m-d'));
                        $warrenty=$war - $daysgone2;
                    }

                    echo "<label>" . $warrenty . " Days Remain</label>";
                }
                ?>
            </span>
        </span>
                <?php
            }

            function LcdWorkAjax($table, $field, $ticketId, $status, $fetchplace) {
                ?><span id="<?php echo $fetchplace; ?>">
            <span onclick="LcdWork('<?php echo $table; ?>', '<?php echo $field; ?>', '<?php echo $ticketId; ?>', '<?php echo $status; ?>', '<?php echo $fetchplace; ?>')">
                <?php
                $obj_pos=new db_class();
                $tc=$obj_pos->SelectAllByVal($table, $field, $ticketId, $status);
                if ($tc == 1) {
                    echo "<label>Good</label>";
                }else {
                    echo "<label>Bad</label>";
                }
                ?>
            </span>	</span>
        <?php
    }

    function FlyQuery($query) {
        $obj=new db_class();
        $count=0;
        $fields='';
        $con=$obj->open();
        $result=mysqli_query($con, $query);
        //var_dump($result);
        if ($result) {
            $count=mysqli_num_rows($result);

            if ($count >= 1) {
                //$object[]=array();
                while ($rows=$result->fetch_object()) {
                    $objects[]=$rows;
                }
                $obj->close($con);
                return $objects;
            }
        }
    }

}

//pos function end here
?>