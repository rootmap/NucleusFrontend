<!DOCTYPE HTML>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    </head>
    <body>
        <table cellspacing="0" cellpadding="0" width="100%" border="0">
            <tbody>
                <tr>
                    <td valign="top" align="center">
                        <table cellspacing="0" cellpadding="10" width="600" border="0" bgcolor="#FFFFFF" style="border:1px solid #689F38;">
                            <tbody>
                                <tr>
                                    <td valign="top" class="ecxfirst" style="text-align: center;">
                                        <a target="_blank" href="http://www.ticketchai.com/" style="font-size:20px;color:#383838;text-decoration:none;" class="">
                                            <img border="0" style="width: 100px !important;" alt="" src="http://ticketchai.com/images/ticketchai_logo.png">
                                        </a>

                                    </td>
                                </tr>
                                <tr>
                                    <td valign="top">
                                        <h1 style="font-size:22px;font-weight:normal;line-height:22px;">Dear Admin,</h1>
                                        <p style="font-size:15px;line-height:16px;">
                                            A new order has been placed by <strong><?php echo $orderUserName; ?></strong> on <strong><?php echo $orderPlacedDate; ?></strong>. Below are the details of this order.
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="top">
                                        <h3 style="font-size:16px;font-weight:normal;">Order Number #&nbsp;<?php echo $orderNumber; ?></h3>
                                        <h3 style="font-size:16px;font-weight:normal;">Order Status #&nbsp;<?php echo $orderStatus; ?></h3>
                                        <h3 style="font-size:16px;font-weight:normal;">Payment Method #&nbsp;<?php echo $paymentMethod; ?></h3>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <table cellspacing="0" cellpadding="0" width="725" border="0">
                                            <thead>
                                                <tr>
                                                    <th width="325" bgcolor="#689F38" align="left" style="font-size:15px;padding:5px 9px 6px 9px;line-height:1em;">Delivery Address</th>
                                                    <th width="10"></th>
                                                    <th width="325" bgcolor="#689F38" align="left" style="font-size:15px;padding:5px 9px 6px 9px;line-height:1em;">Billing Address</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td valign="top" style="font-size:15px;padding:7px 9px 9px 9px;border-left:1px solid #EAEAEA;border-bottom:1px solid #EAEAEA;border-right:1px solid #EAEAEA;">
                                                        <?php echo $orderShippingAddress; ?><br/>
                                                        <?php echo $orderShippingZip; ?><?php echo " "; ?><?php echo $orderShippingCity; ?><br/>
                                                        <?php echo $orderShippingCountry; ?><br/>
                                                        <?php echo $orderShippingPhone; ?><br/>
                                                        <?php echo $orderShippingFirstName; ?><?php echo " "; ?><?php echo $orderShippingLastName; ?>
                                                    </td>
                                                    <td>&nbsp;</td>
                                                    <td valign="top" style="font-size:15px;padding:7px 9px 9px 9px;border-left:1px solid #EAEAEA;border-bottom:1px solid #EAEAEA;border-right:1px solid #EAEAEA;">
                                                        <?php echo $orderBillingAddress; ?><br/>
                                                        <?php echo $orderBillingZip; ?><?php echo " "; ?><?php echo $orderBillingCity; ?><br/>
                                                        <?php echo $orderBillingCountry; ?><br/>
                                                        <?php echo $orderBillingPhone; ?><br/>
                                                        <?php echo $orderBillingFirstName; ?><?php echo " "; ?><?php echo $orderBillingLastName; ?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <br>

                                        <table cellspacing="0" cellpadding="0" width="100%" border="0" style="border:1px solid #689F38;">
                                            <thead>
                                                <tr>
                                                    <th bgcolor="#689F38" align="left" style="font-size:15px;padding:3px 9px;">Event Title</th>
                                                    <th bgcolor="#689F38" align="center" style="font-size:15px;padding:3px 9px;">Unit Price</th>
                                                    <th bgcolor="#689F38" align="center" style="font-size:15px;padding:3px 9px;">Qty.</th>
                                                    <th bgcolor="#689F38" align="center" style="font-size:15px;padding:3px 9px;">Total Price</th>
                                                </tr>
                                            </thead>
                                            <?php $grandTotal=0; ?>
                                            <?php $grandDiscount=0; ?>
                                            <?php if (count($newArrTickets) >= 1) : ?>
                                                <?php foreach ($newArrTickets AS $itemTicket) : ?>
                                                    <?php $grandTotal += $itemTicket['totalPrice']; ?>
                                                    <tbody>
                                                        <tr>
                                                            <td valign="top" align="left" style="font-size:15px;padding:3px 9px;border-bottom:1px dotted #689F38;">
                                                                <h4 style="margin: 0px !important;"><?php echo $itemTicket['eventTitle']; ?></h4>
                                                                <small>
                                                                    Item Title: <span class="label label-default"><?php echo $itemTicket['itemTitle']; ?></span>
                                                                    | Item Type: <span class="label label-default"><?php echo $itemTicket['itemType']; ?></span>
                                                                </small>
                                                            </td>
                                                            <td valign="top" align="center" style="font-size:15px;padding:3px 9px;border-bottom:1px dotted #689F38;"><span><?php echo number_format($itemTicket['unitPrice'], 2); ?> </span></td>
                                                            <td valign="top" align="center" style="font-size:15px;padding:3px 9px;border-bottom:1px dotted #689F38;"><span><?php echo $itemTicket['totalQuantity']; ?></span></td>
                                                            <td valign="top" align="center" style="font-size:15px;padding:3px 9px;border-bottom:1px dotted #689F38;"><span><?php echo number_format($itemTicket['totalPrice'], 2); ?> </span></td>
                                                        </tr>
                                                    </tbody>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                            <?php if (count($newarrSeats) >= 1) : ?>
                                                <?php foreach ($newarrSeats AS $itemSeat) : ?>
                                                    <?php $grandTotal += $itemSeat['totalPrice']; ?>
                                                    <tbody>
                                                        <tr>
                                                            <td valign="top" align="left" style="font-size:15px;padding:3px 9px;border-bottom:1px dotted #689F38;">
                                                                <h4 style="margin: 0px !important;"><?php echo $itemSeat['eventTitle']; ?></h4>
                                                                <small>
                                                                    Item Title: <span class="label label-default"><?php echo $itemSeat['itemTitle']; ?></span>
                                                                    | Item Type: <span class="label label-default"><?php echo $itemSeat['itemType']; ?></span>
                                                                </small>
                                                            </td>
                                                            <td valign="top" align="center" style="font-size:15px;padding:3px 9px;border-bottom:1px dotted #689F38;"><span><?php echo number_format($itemSeat['unitPrice'], 2); ?> </span></td>
                                                            <td valign="top" align="center" style="font-size:15px;padding:3px 9px;border-bottom:1px dotted #689F38;"><span><?php echo $itemSeat['totalQuantity']; ?></span></td>
                                                            <td valign="top" align="center" style="font-size:15px;padding:3px 9px;border-bottom:1px dotted #689F38;"><span><?php echo number_format($itemSeat['totalPrice'], 2); ?> </span></td>
                                                        </tr>
                                                    </tbody>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                            <tbody>

                                                <tr class="ecxsubtotal">
                                                    <td colspan="2"> </td>
                                                    <td align="right">
                                                        Delivery Cost
                                                    </td>

                                                    <td align="right">
                                                        <span class="ecxprice"><?php echo $deliveryCost; ?></span>
                                                    </td>
                                                </tr>
                                                <tr class="ecxsubtotal">
                                                    <td colspan="2"> </td>
                                                    <td align="right">
                                                        Discount
                                                    </td>

                                                    <td align="right">
                                                        <span class="ecxprice"><?php echo $discountCost; ?></span>
                                                    </td>
                                                </tr>
                                                <tr class="ecxshipping">
                                                    <td colspan="2"> </td>
                                                    <td align="right">
                                                        Subtotal
                                                    </td>
                                                    <td align="right"><?php echo number_format($grandTotal + $grandDiscount + $deliveryCost, 2); ?></td>
                                                </tr>
                                                <?php if ($orderCouponDiscount > 0): ?>
                                                    <tr class="ecxshipping" style="color: #900;">
                                                        <td colspan="2"> </td>
                                                        <td align="right">
                                                            Coupon Code (<?php echo $orderCouponCode; ?>)
                                                        </td>
                                                        <td align="right"> - <?php echo number_format($orderCouponDiscount, 2); ?></td>
                                                    </tr>
                                                <?php endif; ?>
                                                <tr class="ecxgrand_total">
                                                    <td colspan="2"> </td>
                                                    <td align="right">
                                                        <strong>Grand Total</strong>
                                                    </td>
                                                    <td align="right">
                                                        <strong><span class="ecxprice"><?php echo number_format($totalCost - $orderCouponDiscount, 2); ?></span></strong>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                    </td>
                                </tr>
                                <tr><td bgcolor="#FFFFFF" align="center" class="ecxlast"><center><p style="font-size:15px;">&copy; 2014 ticketchai.com Ltd. All Rights Reserved</p></center></td></tr>
            </tbody>
        </table>
    </td>
</tr>

</tbody>
</table>
</body>
</html>