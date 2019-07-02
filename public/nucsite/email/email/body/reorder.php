<?php
include '../../../class/db_Class.php';
$obj=new db_class();
extract($_GET);
$sqlcurstore=$obj->FlyQuery("SELECT * FROM reorder_user WHERE rid='" . $session_id . "'");
if (!empty($sqlcurstore)) {
    ?>
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
                            <table cellspacing="0" cellpadding="10" width="800" border="0" bgcolor="#FFFFFF" style="border:1px solid #689F38;">
                                <tbody>
                                    <tr>
                                        <td valign="top" class="ecxfirst" style="text-align: center;">
                                            <a target="_blank" href="http://www.nucleuspos.com/" style="font-size:20px;color:#383838;text-decoration:none;" class="">
                                                <img border="0" style="width: 100px !important;" alt="" src="http://nucleuspos.com/nucleus/pos_image/nucleusfinal.png">
                                            </a>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="top" class="ecxfirst" style="text-align: center;">
                                            <h2 align="center">Your Store Re-Order Product Reminder</h2>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="top">
                                            <table align="center" width="100%">
                                                <thead>
                                                    <tr style="background:#689F38; ">
                                                        <th>#</th>
                                                        <th>PID</th>
                                                        <th>Name</th>
                                                        <th width="60">Barcode</th>
                                                        <th>Cost</th>
                                                        <th>Retail</th>
                                                        <th>Stock</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $sqlproduct=$obj->FlyQuery("SELECT a.id,
                                                p.id as pid,
                                                p.name,
                                                p.store_id,
                                                p.barcode,
                                                p.price_cost,
                                                p.price_retail,
                                                p.input_by,
                                                a.stock FROM `reorder` as a
                                                LEFT JOIN product as p on p.id=a.pid WHERE p.input_by='" . $sqlcurstore[0]->store_id . "'");
                                                    $i=1;
                                                    if (!empty($sqlproduct)) {
                                                        foreach ($sqlproduct as $product):
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $i; ?></td>
                                                                <td><?php echo $product->pid; ?></td>
                                                                <td><?php echo $product->name; ?></td>
                                                                <td><?php echo $product->barcode; ?></td>
                                                                <td><?php echo $product->price_cost; ?></td>
                                                                <td><?php echo $product->price_retail; ?></td>
                                                                <td><?php echo $product->stock; ?></td>
                                                            </tr>
                                                            <?php
                                                            $i++;
                                                        endforeach;
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr><td bgcolor="#FFFFFF" align="center" class="ecxlast"><center><p style="font-size:15px;">&copy; <?php echo date("Y"); ?> Nucleuspos.com Ltd. All Rights Reserved</p></center></td></tr>
                </tbody>
            </table>
        </td>
    </tr>

    </tbody>
    </table>
    </body>
    </html>
<?php } ?>

























