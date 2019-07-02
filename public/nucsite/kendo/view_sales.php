<?php
include('class/auth.php');
$table = "product";
$table2 = "sales";
$table3 = "invoice";
$cart = $_GET['invoice'];
$cid = $obj->SelectAllByVal("invoice", "invoice_id", $cart, "cid");
$creator = $obj->SelectAllByVal("invoice", "invoice_id", $cart, "invoice_creator");
$pt = $obj->SelectAllByVal("invoice", "invoice_id", $cart, "payment_type");
$ckid = $obj->SelectAllByVal("invoice", "invoice_id", $cart, "checkin_id");
$unid = $obj->SelectAllByVal("invoice", "invoice_id", $cart, "unlock_id");
include('class/invoice_class.php');
$ops = new invoice_view();

if (@$_GET['action'] == 'pdf') {
    $tax_statuss = $obj->SelectAllByVal("pos_tax", "invoice_id", $cart, "status");
    if ($tax_statuss == 0) {
        $taxs = 0;
    } else {
        $taxs = $tax_per_product;
    }
    include("pdf/MPDF57/mpdf.php");
    $html.="<table id='sample-table-2' class='table table-hover' border='1'><tbody>";
    $report_cpmpany_name = $obj->SelectAllByVal("setting_report", "store_id", $input_by, "name");
    $report_cpmpany_address = $obj->SelectAllByVal("setting_report", "store_id", $input_by, "address");
    $report_cpmpany_phone = $obj->SelectAllByVal("setting_report", "store_id", $input_by, "phone");
    $report_cpmpany_email = $obj->SelectAllByVal("setting_report", "store_id", $input_by, "email");
    $report_cpmpany_fotter = $obj->SelectAllByVal("setting_report", "store_id", $input_by, "fotter");

    function limit_words($string, $word_limit) {
        $words = explode(" ", $string);
        return implode(" ", array_splice($words, 0, $word_limit));
    }

    $addressfline = limit_words($report_cpmpany_address, 3);
    $lengthaddress = strlen($addressfline);
    $lastaddress = substr($report_cpmpany_address, $lengthaddress, 30000);



    $html .="<tr>
    <td style='height:40px; background:rgba(0,51,153,1);'>
    	<table style='width:100%; height:40px; border:0px;'>
					<tr>
						<td width='87%' style='background:rgba(0,51,153,1);  color:#FFF; font-size:25px;'>" . $report_cpmpany_name . " : Warranty Exchange</td><td width='13%' style='background:rgba(0,51,153,1);  color:#FFF; font-size:30px;'><span style='float:left; text-align:left;'>Invoice</span></td>
					</tr>
				</table>
    </td>
  </tr>
  <tr>
    <td style='height:40px;' valign='top'>
    	<table style='width:960px; height:40px; font-size:12px; border:0px;'>
					<tr>
						<td width='69%'>
						" . $addressfline . "<br>
						" . $lastaddress . "
						</td>
						<td width='31%'>
						DIRECT ALL INQUIRIES TO:<br />
						" . $report_cpmpany_name . "<br />
						" . $report_cpmpany_phone . "<br />
						" . $report_cpmpany_email . "<br />
						</td>
					</tr>
				</table>
    </td>
  </tr>
  <tr>
    <td style='height:30px;' valign='top'>
    	<table style='width:100%; height:40px; border:0px; font-size:18px;'>
        	<tr>
            	<td> Sold To : </td>
            </tr>
        </table>
    </td>
  </tr>
  <tr>
    <td style='height:40px;' valign='top'>
    	<table style='width:960px; height:40px; border:0px;'>
        	<tr>
            	<td width='69%'>
                Name : " . $obj->SelectAllByVal("coustomer", "id", $cid, "firstname") . "<br />
                Phone : " . $obj->SelectAllByVal("coustomer", "id", $cid, "phone") . "<br />
                </td>
            </tr>
        </table>
    </td>
  </tr>
  
  <tr>
    <td style='height:40px;' valign='top'>
    	<table style='width:960px; height:40px; border:0px;'>
        	<tr>
            	<td width='69%'>
                Phone Repair Center <br />
                We Repair | We Buy | We Sell <br />
                </td>
				<td width='31%'>
                INVOICE DATE  : " . $obj->SelectAllByVal("invoice", "invoice_id", $cart, "invoice_date") . "<br />
                ORDER NO. : " . $cart . "<br />
				SALES REP : " . $obj->SelectAllByVal("store", "id", $creator, "name") . "<br />
                </td>
            </tr>
        </table>
    </td>
  </tr>
  
  <tr>
    <td style='height:40px;' valign='top'>
    	<table style='width:100%; height:40px; border:0px;'>
        	<tr>
            	<td width='79%'>
                Sales Tax Rate:  " . $taxs . "%
                </td>
            </tr>
        </table>
    </td>
  </tr>
  
  <tr>
    <td valign='top' style='margin:0; padding:0; width:100%;'>
    	<table style='width:960px;border:1px; font-size:12px; background:#ccc;'>";
    $html.="<thead><tr>
				<td>S/L</td>
				<td>Product</td>
				<td>Description</td>
				
				<td>Quantity</td>
				<td>Unit Cost</td>
				<td>Tax</td>
				<td>Extended</td>
			</tr></thead>";
    $sqlsaleslist = $obj->SelectAllByID($table2, array("sales_id" => $cart));
    $sss = 1;
    $subtotal = 0;
    $tax = 0;
    if (!empty($sqlsaleslist))
        foreach ($sqlsaleslist as $saleslist):

            $caltax = ($saleslist->single_cost * $tax_per_product) / 100;
            //$tax_status=$saleslist->tax;

            $procost = $saleslist->quantity * $saleslist->single_cost;
            $subtotal+=$procost;

            $tax_status = $obj->SelectAllByVal("pos_tax", "invoice_id", $cart, "status");
            if ($tax_status == 0) {
                $tax+=0;
                $taxst = "No";
                $taxstn = "1";
                $extended = $procost;
            } else {
                $tax+=$caltax * $saleslist->quantity;
                $taxst = "Yes";
                $taxstn = "0";
                $extended = $procost + $caltax;
            }
            $html.="<thead><tr>
				<td>" . $sss . "</td>
				<td>" . $obj->SelectAllByVal($table, "id", $saleslist->pid, "name") . "</td>
				<td>" . $obj->SelectAllByVal($table, "id", $saleslist->pid, "name") . "</td>
				
				<td>" . $saleslist->quantity . "</td>
				<td><button type='button' class='btn'>$" . $saleslist->single_cost . "</button></td>
				<td>$" . $caltax . "</td>
				<td>
					<button type='button' class='btn'>$" . $extended . "</button>
				</td>
			</tr></thead>";

            $sss++;
        endforeach;
    if ($pt == 0) {
        $pp = "Not Paid";
    } else {
        $pp = $obj->SelectAllByVal("payment_method", "id", $pt, "meth_name");
    }
    $total = $subtotal + $tax;
    if ($paid != 0) {
        $dd = number_format($total, 2);
    } else {
        $dd = "$0.00";
    }

    if ($paid != 0) {
        $ff = "$0.00";
    } else {

        $ff = number_format($total, 2);
    }

    $paid = 0;
    $sqlpp = $obj->SelectAllByID_Multiple("invoice_payment", array("invoice_id" => $cart));
    if (!empty($sqlpp)) {
        foreach ($sqlpp as $pps):
            $paid+=$pps->amount;
        endforeach;
    }
    else {
        $paid+=0;
    }

    $due = $total - $paid;
    $html.="</table></td></tr>";
    if ($ckid != 0) {

        $html.="<tr><td><table style='width:960px;'>
			<thead>
				<tr>
					<td width='350' valign='top'>
  
	  <table style='width:300px;border:1px; margin-left:-4px; font-size:12px; background:#ccc;'>
			<thead>
				<tr>
					<th>IMEI of Device being repair: </th>
					<th>" . $obj->SelectAllByVal("checkin_request_ticket", "checkin_id", $ckid, "imei") . "</th>
				</tr>
				<tr>
					<th>Carrier:  </th>
					<th>" . $obj->SelectAllByVal("checkin_list", "checkin_id", $ckid, "network") . "</th>
				</tr>
				<tr>
					<th>Color:  </th>
					<th>" . $obj->SelectAllByVal("checkin_list", "checkin_id", $ckid, "color") . "</th>
				</tr>
				<tr>
					<th>Problem:  </th>
					<th>" . $obj->SelectAllByVal("checkin_list", "checkin_id", $ckid, "problem") . "</th>
				</tr>
			</thead>
		</table>
		</td>
		<td>
			<table style='width:250px;border:1px; font-size:12px; background:#ccc;'>
				<thead>
					<tr>
						<th>Payment Type: </th>
						<th>" . $pp . "</th>
					</tr>
					<tr>
						<th>Sub - Total: </th>
						<th>" . number_format($subtotal, 2) . "</th>
					</tr>
					<tr>
						<th>Tax: </th>
						<th>" . number_format($tax, 2) . "</th>
					</tr>
					<tr>
						<th>Total: </th>
						<th>" . number_format($total, 2) . "</th>
					</tr>
					<tr>
						<th>Payments: </th>
						<th>" . $paid . "</th>
					</tr>
					<tr>
						<th>Balance Due: </th>
						<th>";

        if (substr($due, 0, 1) == "-") {
            $html.="0";
        } else {
            $html.=$due;
        }

        $html.="</th>
					</tr>
				</thead>
			</table>
		</td>
		</tr>
		</thead>
		</table>
  </td>
  </tr>
  <tr>
  <td>
		
  </td>
  </tr>";
    } elseif ($unid != 0) {
        $html.="<tr><td><table style='width:960px;'>
			<thead>
				<tr>
					<td width='350' valign='top'>
  
	  <table style='width:300px;border:1px; margin-left:-4px; font-size:12px; background:#ccc;'>
			<thead>
				<tr>
					<th>IMEI of Device being repair: </th>
					<th>" . $obj->SelectAllByVal("unlock_request", "unlock_id", $unid, "imei") . "</th>
				</tr>
				<tr>
					<th>Carrier:  </th>
					<th>" . $obj->SelectAllByVal("unlock_request", "unlock_id", $unid, "carrier") . "</th>
				</tr>
				<tr>
					<th>Color:  </th>
					<th>" . $obj->SelectAllByVal("unlock_request", "unlock_id", $unid, "type_color") . "</th>
				</tr>
				<tr>
					<th>Password:  </th>
					<th>" . $obj->SelectAllByVal("unlock_request", "unlock_id", $unid, "password") . "</th>
				</tr>
				<tr>
					<th>Note:  </th>
					<th>" . $obj->SelectAllByVal("unlock_request", "unlock_id", $unid, "note") . "</th>
				</tr>
				<tr>
					<th>Comment:  </th>
					<th>" . $obj->SelectAllByVal("unlock_request", "unlock_id", $unid, "comment") . "</th>
				</tr>
				<tr>
					<th>Respond Email:  </th>
					<th>" . $obj->SelectAllByVal("unlock_request", "unlock_id", $unid, "respond_email") . "</th>
				</tr>
			</thead>
		</table>
		</td>
		<td>
			<table style='width:250px;border:1px; font-size:12px; background:#ccc;'>
				<thead>
					<tr>
						<th>Payment Type: </th>
						<th>" . $pp . "</th>
					</tr>
					<tr>
						<th>Sub - Total: </th>
						<th>" . number_format($subtotal, 2) . "</th>
					</tr>
					<tr>
						<th>Tax: </th>
						<th>" . number_format($tax, 2) . "</th>
					</tr>
					<tr>
						<th>Total: </th>
						<th>" . number_format($total, 2) . "</th>
					</tr>
					<tr>
						<th>Payments: </th>
						<th>" . $paid . "</th>
					</tr>
					<tr>
						<th>Balance Due: </th>
						<th>";

        if (substr($due, 0, 1) == "-") {
            $html.="0";
        } else {
            $html.=$due;
        }

        $html.="</th>
					</tr>
				</thead>
			</table>
		</td>
		</tr>
		</thead>
		</table>
  </td>
  </tr>
  <tr>
  <td>
		
  </td>
  </tr>";
    } else {

        $html.="<tr><td><table style='width:250px;border:1px; font-size:12px; background:#ccc;'><thead>
					<tr>
						<th>Payment Type: </th>
						<th>" . $pp . "</th>
					</tr>
					<tr>
						<th>Sub - Total: </th>
						<th>" . number_format($subtotal, 2) . "</th>
					</tr>
					<tr>
						<th>Tax: </th>
						<th>" . number_format($tax, 2) . "</th>
					</tr>
					<tr>
						<th>Total: </th>
						<th>" . number_format($total, 2) . "</th>
					</tr>
					<tr>
						<th>Payments: </th>
						<th>" . $paid . "</th>
					</tr>
					<tr>
						<th>Balance Due: </th>
						<th>";

        if (substr($due, 0, 1) == "-") {
            $html.="0";
        } else {
            $html.=$due;
        }

        $html.="</th>
					</tr>
				</thead></table></td></tr>";
    }

    if ($obj->exists_multiple("invoice_payment", array("invoice_id" => $cart)) != 0) {
        $html.="<tr><td>
		<br />
		<h3> Transaction Detail </h3>
		<table style='width:100%;border:1px; font-size:12px; background:#ccc;'>";
        $html.="<thead><tr>
				<td> S/L </td>
				<td>Payment Method</td>
				<td>Amount</td>
				<td>Date</td>
			</tr></thead>";
        $sqlsaleslist = $obj->SelectAllByID("invoice_payment", array("invoice_id" => $cart));
        $sss = 1;
        if (!empty($sqlsaleslist))
            foreach ($sqlsaleslist as $saleslist):
                $html.="<thead><tr>
				<td>" . $sss . "</td>
				<td>" . $obj->SelectAllByVal("payment_method", "id", $saleslist->payment_type, "meth_name") . "</td>
				<td>$" . $saleslist->amount . "</td>
				<td>" . $saleslist->date . "</td></tr></thead>";

                $sss++;
            endforeach;
        $html.="</table></td></tr>";
    }

    $html.="<tr>
    <td align='center' style='font-size:8px;'>" . $report_cpmpany_fotter . "</td>
  </tr>
  <tr>
    <td align='center'>Thank You For Your Business</td>
  </tr>";
    $html.="</tbody></table>";

    $mpdf = new mPDF('c', 'A4', '', '', 32, 25, 27, 25, 16, 13);

    $mpdf->SetDisplayMode('fullpage');

    $mpdf->list_indent_first_level = 0; // 1 or 0 - whether to indent the first level of a list
// LOAD a stylesheet
    $stylesheet = file_get_contents('pdf/MPDF57/examples/mpdfstyletables.css');
    $mpdf->WriteHTML($stylesheet, 1); // The parameter 1 tells that this is css/style only and no body/html/text

    $mpdf->WriteHTML($html, 2);

    $mpdf->Output('mpdf.pdf', 'I');
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
<?php //echo $obj->bodyhead();  ?>
<?php
include './plugin/plugin.php';
$cms = new CmsRootPlugin();
echo $cms->GeneralCss(array("kendo", "modal"));
?>
        <script src="ajax/customer_ajax.js"></script>
        <script src="ajax/invoice_ajax.js"></script>
        <script type="text/javascript">

            function PrintElem(elem)
            {
                Popup($(elem).html());
            }

            function Popup(data)
            {
                var mywindow = window.open('', 'my div', 'height=1000,width=960px');
                mywindow.document.write('<html><head><title>my div</title>');
                /*optional stylesheet*/ //mywindow.document.write('<link rel="stylesheet" href="main.css" type="text/css" />');
                mywindow.document.write('</head><body >');
                mywindow.document.write(data);
                mywindow.document.write('</body></html>');

                mywindow.print();
                mywindow.close();

                return true;
            }


            function followup(cid, store_id, msg, invoice) {
                if (window.XMLHttpRequest) {
                    // code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp = new XMLHttpRequest();
                } else { // code for IE6, IE5
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function () {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        url = "view_sales.php?invoice=" + invoice;
                        window.location.replace(url);
                        //document.getElementById(msg).innerHTML=xmlhttp.responseText;
                    }
                }
                st = 1;

                xmlhttp.open("GET", "ajax/followup.php?st=" + st + "&cid=" + cid + "&store_id=" + store_id, true);
                xmlhttp.send();
            }

        </script>
    </head>

    <body <?php if (isset($_GET['print_doc'])) { ?> onLoad="PrintElem('#mydiv')" <?php } ?>>
<?php include('include/header.php'); ?>
        <!-- Main wrapper -->
        <div class="wrapper three-columns">
            <!-- Left sidebar -->
<?php include('include/sidebar_left.php'); ?>
            <!-- /left sidebar -->
            <!-- Main content -->
            <div class="content">

                <!-- Info notice -->
        <?php echo $obj->ShowMsg(); ?>
                <!-- /info notice -->

                <div class="outer">
                    <div class="inner">
                        <div class="page-header"><!-- Page header -->
                            <h5><i class="icon-file"></i> View Pos Invoice - <?php echo $cart; ?>  </span> 
                                <label style="margin-left: 30px;">
                                    <i onclick="printnuc('3')" class="icon-print"></i> 
                                    <select onchange="printnuc(this.value)" name="printopt" id="printopt"  style="width:260px;" >
                                        <option value="1">Pos Print</option> 
                                        <option value="2">Barcode Print</option> 
                                        <option value="3">Thermal Print</option> 
                                    </select> </label>
                                <script>
                                    function printnuc(getval) {
                                        if (getval == 1)
                                        {
                                            window.open("pos.php?action=pdf&invoice=<?php echo $_GET['invoice']; ?>&print=1", "_blank");
                                            win.focus();
                                        }
                                        else if (getval == 2)
                                        {
                                            $('#printopt option[value=0]').prop('selected', 'selected').change();
                                            window.open("pos.php?action=pdf&invoice=<?php echo $_GET['invoice']; ?>&print=2", "_blank");

                                        }
                                        else if (getval == 3)
                                        {
                                            $('#printopt option[value=0]').prop('selected', 'selected').change();
                                            window.open("pos.php?action=pdf&invoice=<?php echo $_GET['invoice']; ?>&print=3", "_blank");

                                        }
                                        //$('#printopt option[value=0]').attr('selected', 'selected');

                                    }
                                </script>
<!--                                <a target="_blank" href="pos.php?action=pdf&invoice=<?php //echo $_GET['invoice'];  ?>"><i class="icon-print"></i></a>--></h5>
                            <ul class="icons">
                                <li><a href="<?php echo $obj->filename(); ?>" class="hovertip" title="Reload"><i class="font-refresh"></i></a></li>
                            </ul>
                        </div><!-- /page header -->

                        <div class="body">

                            <!-- Middle navigation standard -->
<?php //include('include/quicklink.php');   ?>
                            <!-- /middle navigation standard -->

                            <!-- Content container -->
                            <div class="container"  id="mydiv">

                                <form class="form-horizontal" method="get" name="invoice" action="create_invoice.php">
                                    <fieldset>
<?php ?>

                                        <div class="row-fluid block">

                                            <!-- General form elements -->
                                            <div class="well row-fluid span6">
                                                <div class="navbar">
                                                    <div class="navbar-inner">
                                                        <h5><i class="icon-user"></i> Customer</h5>
                                                    </div>
                                                </div>

                                                <br>
                                                <div class="span12">
                                                    <label class="span12"> <strong class="span4">Business Name: </strong> 

                                                        <span class="span8">  
<?php echo $ops->customer_edit("coustomer", $cid, "businessname", "Business Name"); ?> </span>
                                                    </label>
                                                </div>

                                                <div class="clearfix"></div>
                                                <div class="span12">
                                                    <label class="span12"> <strong class="span4">Name: </strong><span class="span8">
<?php echo $ops->customer_edit("coustomer", $cid, "firstname", "Full Name"); ?> </span>
                                                    </label>
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="span12">
                                                    <label class="span12"> <strong class="span4">Email: </strong><span class="span8">
<?php echo $ops->customer_edit("coustomer", $cid, "email", "Email Address"); ?></span> 
                                                    </label>
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="span12">
                                                    <label class="span12"> <strong class="span4">Invoice Email: </strong><span class="span8">
<?php echo $ops->customer_edit("coustomer", $cid, "invoice_email", "Invoice Email Address"); ?> </span> 
                                                    </label>
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="span12">
                                                    <label class="span12"> <strong class="span4">Address: </strong><span class="span8">
<?php echo $ops->customer_edit("coustomer", $cid, "address1", "Address"); ?>  </span>
                                                    </label>
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="span12">
                                                    <label class="span12"> <strong class="span4">Phone: </strong><span class="span8">
<?php echo $ops->customer_edit("coustomer", $cid, "phone", "Phone Number"); ?> </span> 
                                                    </label>
                                                </div>

                                                <br>
                                                <br>
                                            </div>
                                            <!-- /general form elements -->





<?php $paid = $obj->SelectAllByVal("invoice", "invoice_id", $cart, "paid"); ?>
                                            <!-- General form elements -->
                                            <div class="well row-fluid span6" <?php if ($paid != 0) { ?>style="background:url(images/paid.png) no-repeat center;"<?php } ?>>
                                                <div class="navbar">
                                                    <div class="navbar-inner">
                                                        <h5><i class="font-money"></i> Invoice Detail</h5>
                                                    </div>
                                                </div>

                                                <br>
                                                <div class="span12">
                                                    <label class="span12"> <strong class="span3">Invoice Number: </strong> 
<?php echo $cart; ?> </label>
                                                </div>

                                                <div class="clearfix"></div>
                                                <div class="span12">
                                                    <label class="span12"> <strong class="span3">Created By: </strong>
                                                        <b id="creator">
<?php
$store_id = $obj->SelectAllByVal("invoice", "invoice_id", $cart, "access_id");
echo $obj->SelectAllByVal("store", "id", $store_id, "name");
?>

                                                        </b>



                                                    </label>
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="span12">
                                                    <label class="span12"> <strong class="span3">Invoice Date: </strong>
                                                            <?php echo $ops->invoice_edit("invoice", "invoice_id", $cart, "invoice_date", "INVOICE Date"); ?> 
                                                    </label>
                                                </div>
                                                <div class="clearfix"></div>
                                                <br>
                                                <div class="span12">
                                                    <div class="btn btn-info"  style="display: block; line-height:22px;  position: static; width: 50%">
                                                        <label class="checkbox" style="background:none;" id="customer_follow_up">
<?php
$chk = $obj->exists_multiple("customer_follow_up", array("store_id" => $input_by, "cid" => $cid));
if ($chk == 0) {
    ?>
                                                                <input onClick="followup('<?php echo $cid; ?>', '<?php echo $input_by; ?>', 'customer_follow_up', '<?php echo $_GET['invoice']; ?>')" type="checkbox" name="checkbox1" style="background:none; position:absolute !important;" class="style"> Follow up customer
<?php } else { ?>
                                                                <input onClick="followup('<?php echo $cid; ?>', '<?php echo $input_by; ?>', 'customer_follow_up', '<?php echo $_GET['invoice']; ?>')" type="checkbox" name="checkbox1" style="background:none; position:absolute !important;" class="style"  checked="checked"> Customer has follow up 
<?php } ?>
                                                        </label>

                                                    </div>
                                                </div>
                                                <div class="clearfix"></div>


                                                <br>
                                            </div>
                                            <!-- /general form elements -->

                                        </div>



                                        <!-- General form elements -->
                                        <div class="row-fluid  span12 well" style="margin-top: 5px;">     
                                            <div class="navbar">
                                                <div class="navbar-inner">
                                                    <h5><i class="font-money"></i> Line Item <span id="msg" style="float:right; margin-left:50px; margin-top:-8px;"></span></h5>
                                                </div>
                                            </div>
                                            <!-- Selects, dropdowns -->
                                            <div class="span12" style="padding:0px; margin:0px;">
                                                <div class="table-overflow">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Item</th>
                                                                <th>Description</th>
                                                                <th>QTY</th>
                                                                <th>Rate</th>
                                                                <th width="70">Tax</th>
                                                                <th width="100">Extended</th>
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

        $caltax = ($saleslist->single_cost * $tax_per_product) / 100;
        //$tax_status=$saleslist->tax;

        $procost = $saleslist->quantity * $saleslist->single_cost;
        $subtotal+=$procost;

        $tax_status = $obj->SelectAllByVal("pos_tax", "invoice_id", $cart, "status");
        if ($tax_status == 0) {
            $tax+=0;
            $taxst = "No";
            $taxstn = "1";
            $extended = $procost;
        } else {
            $tax+=$caltax * $saleslist->quantity;
            $taxst = "Yes";
            $taxstn = "0";
            $extended = $procost + $caltax;
        }
        ?>
                                                                    <tr>
                                                                        <td><?php echo $sss; ?></td>
                                                                        <td><?php echo $obj->SelectAllByVal($table, "id", $saleslist->pid, "name"); ?></td>
                                                                        <td><?php echo $obj->SelectAllByVal($table, "id", $saleslist->pid, "name"); ?></td>

                                                                        <td><?php echo $saleslist->quantity; ?></td>
                                                                        <td><button type="button" class="btn">$<?php echo $saleslist->single_cost; ?></button></td>
                                                                        <td>$ <?php echo $caltax; ?></td>
                                                                        <td>
                                                                            <button type="button" class="btn">$
                                                                    <?php echo $extended; ?>
                                                                            </button>
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
                                            <!-- /selects, dropdowns -->
<?php if ($ckid != 0) { ?>
                                                <!-- Selects, dropdowns -->
                                                <div class="span5" style="padding:0px; margin:0px; float:left;">
                                                    <div class="table-overflow">
                                                                <?php if ($obj->exists_multiple("checkin_request_ticket", array("checkin_id" => $ckid)) == 0) { ?>
                                                            <table class="table table-striped">
                                                                <thead id="subtotal_list">
                                                                    <tr>
                                                                        <th>IMEI of Device being repair : </th>
                                                                        <th><?php echo $obj->SelectAllByVal("ticket", "ticket_id", $ckid, "imei"); ?></th>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Carrier : </th>
                                                                        <th><?php echo $obj->SelectAllByVal("ticket", "ticket_id", $ckid, "carrier"); ?></th>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Color : </th>
                                                                        <th><?php echo $obj->SelectAllByVal("ticket", "ticket_id", $ckid, "type_color"); ?></th>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Problem : </th>
                                                                        <th><?php echo $obj->SelectAllByVal("problem_type", "id", $obj->SelectAllByVal("ticket", "ticket_id", $ckid, "problem_type"), "name"); ?></th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
        <?php
    } else {
        ?>

                                                            <table class="table table-striped">
                                                                <thead id="subtotal_list">
                                                                    <tr>
                                                                        <th>IMEI of Device being repair: </th>
                                                                        <th><?php echo $obj->SelectAllByVal("checkin_request_ticket", "checkin_id", $ckid, "imei"); ?></th>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Carrier: </th>
                                                                        <th><?php echo $obj->SelectAllByVal("checkin_list", "checkin_id", $ckid, "network"); ?></th>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Color: </th>
                                                                        <th><?php echo $obj->SelectAllByVal("checkin_list", "checkin_id", $ckid, "color"); ?></th>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Problem: </th>
                                                                        <th><?php echo $obj->SelectAllByVal("checkin_list", "checkin_id", $ckid, "problem"); ?></th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
    <?php } ?>
                                                    </div>
                                                </div>
    <?php
} elseif ($unid != 0) {
    ?>
                                                <div class="span5" style="padding:0px; margin:0px; float:left;">
                                                    <div class="table-overflow">
                                                        <table class="table table-striped">
                                                            <thead id="subtotal_list">
                                                                <tr>
                                                                    <th>IMEI of Device being repair : </th>
                                                                    <th><?php echo $obj->SelectAllByVal("unlock_request", "unlock_id", $unid, "imei"); ?></th>
                                                                </tr>
                                                                <tr>
                                                                    <th>Carrier : </th>
                                                                    <th><?php echo $obj->SelectAllByVal("unlock_request", "unlock_id", $unid, "carrier"); ?></th>
                                                                </tr>
                                                                <tr>
                                                                    <th>Color : </th>
                                                                    <th><?php echo $obj->SelectAllByVal("unlock_request", "unlock_id", $unid, "type_color"); ?></th>
                                                                </tr>
                                                                <tr>
                                                                    <th>Password : </th>
                                                                    <th><?php echo $obj->SelectAllByVal("unlock_request", "unlock_id", $unid, "password"); ?></th>
                                                                </tr>
                                                                <tr>
                                                                    <th>Note : </th>
                                                                    <th><?php echo $obj->SelectAllByVal("unlock_request", "unlock_id", $unid, "note"); ?></th>
                                                                </tr>
                                                                <tr>
                                                                    <th>Comment : </th>
                                                                    <th><?php echo $obj->SelectAllByVal("unlock_request", "unlock_id", $unid, "comment"); ?></th>
                                                                </tr>
                                                                <tr>
                                                                    <th>Respond Email : </th>
                                                                    <th><?php echo $obj->SelectAllByVal("unlock_request", "unlock_id", $unid, "respond_email"); ?></th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>
    <?php
}
?>
                                            <div class="span4" style="padding:0px; margin:0px; float:right;">
                                                <div class="table-overflow">
<?php
$total = $subtotal + $tax;
$paid = 0;
$sqlpp = $obj->SelectAllByID_Multiple("invoice_payment", array("invoice_id" => $cart));
if (!empty($sqlpp)) {
    foreach ($sqlpp as $pps):
        $paid+=$pps->amount;
    endforeach;
}
else {
    $paid+=0;
}

$due = $total - $paid;
?>
                                                    <table class="table table-striped">
                                                        <thead id="subtotal_list">
                                                            <tr>
                                                                <th>Sub - Total: </th>
                                                                <th><?php echo number_format($subtotal, 2); ?></th>
                                                            </tr>
                                                            <tr>
                                                                <th>Tax: </th>
                                                                <th><?php echo number_format($tax, 2); ?></th>
                                                            </tr>
                                                            <tr>
                                                                <th>Total: </th>
                                                                <th><?php echo number_format($total, 2); ?></th>
                                                            </tr>
                                                            <tr>
                                                                <th>Paid Amount: </th>
                                                                <th><?php echo $paid; ?></th>
                                                            </tr>
                                                            <tr>
                                                                <th>Balance Due: </th>
                                                                <th>
<?php
if (substr($due, 0, 1) == "-") {
    echo 0;
} else {
    echo $due;
}
?>
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>
                                            <!-- /selects, dropdowns -->
                                        </div>
                                        <!-- /general form elements -->


                                        <!-- /general form elements -->     


                                        <div class="clearfix"></div>

                                        <!-- Default datatable -->

                                        <!-- /default datatable -->


                                    </fieldset>                     

                                </form>


                                <!-- Content End from here customized -->




                                <div class="separator-doubled"></div> 



                            </div>
                            <!-- /content container -->

                        </div>
                    </div>
                </div>
            </div>
            <!-- /main content -->
<?php
include('include/footer.php');
echo $cms->KendoFotter();
?>
            <script>
                nucleus("#printopt").kendoDropDownList({
                    optionLabel: " -- Please Select a Print option -- "
                }).data("kendoDropDownList").select(0);


            </script> 
            <!-- Right sidebar -->
<?php //include('include/sidebar_right.php');   ?>
            <!-- /right sidebar -->

        </div>
        <!-- /main wrapper -->

    </body>
</html>
