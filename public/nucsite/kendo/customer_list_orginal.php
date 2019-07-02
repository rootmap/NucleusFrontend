<?php
include('class/auth.php');

$table = "coustomer";
if (isset($_GET['del'])) {
    $obj->deletesing("id", $_GET['del'], $table);
}

if (isset($_GET['delall'])) {
    $obj->deletesing("input_by", $input_by, $table);
}

if (@$_GET['export'] == "excel") {


    $record_label = "Customer List Report";
    header('Content-type: application/excel');
    $filename = "customer_list_" . date('Y_m_d') . '.xls';
    header('Content-Disposition: attachment; filename=' . $filename);

    $data = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">
<head>
    <!--[if gte mso 9]>
    <xml>
        <x:ExcelWorkbook>
            <x:ExcelWorksheets>
                <x:ExcelWorksheet>
                    <x:Name>Customer List : Wireless Geeks Inc.</x:Name>
                    <x:WorksheetOptions>
                        <x:Print>
                            <x:ValidPrinterInfo/>
                        </x:Print>
                    </x:WorksheetOptions>
                </x:ExcelWorksheet>
            </x:ExcelWorksheets>
        </x:ExcelWorkbook>
    </xml>
    <![endif]-->
</head>';

    $data .="<body>";
//$data .="<h1>Wireless Geeks Inc.</h1>";
    $data .="<h3>" . $record_label . "</h3>";
    $data .="<h5>Customer List Generate Date : " . date('d-m-Y H:i:s') . "</h5>";

    $data .="<table>
    <thead>
        <tr style='background:#09f; color:#fff;'>
			<th>#</th>
			<th>Cus-ID</th>
			<th>First Name</th>
			<th>Last Name</th>
			<th>Email</th>
			<th>Phone</th>
			<th>Mobile: Required for SMS</th>
			<th>Address</th>
			<th>City</th>
			<th>State / Country</th>
			<th>Zip / Postal Code</th>
			<th>Register Since</th>
		</tr>
</thead>        
<tbody>";


    if ($input_status == 1) {
        $sql_coustomer = $obj->SelectAll($table);
    } elseif ($input_status == 5) {

        $sqlchain_store_ids = $obj->SelectAllByID("store_chain_admin", array("sid" => $input_by));
        if (!empty($sqlchain_store_ids)) {
            $array_ch = array();
            foreach ($sqlchain_store_ids as $ch):
                array_push($array_ch, $ch->store_id);
            endforeach;


            include('class/report_chain_admin.php');
            $obj_report_chain = new chain_report();
            $sql_coustomer = $obj_report_chain->SelectAllByID_Multiple_Or($table, $array_ch, "input_by", "1");
        }
        else {
            //echo "Not Work";
            $sql_coustomer = "";
        }
    } else {
        $sql_coustomer = $obj->SelectAllByID($table, array("input_by" => $input_by));
    }
    $i = 1;
    if (!empty($sql_coustomer))
        foreach ($sql_coustomer as $customer):

            $data .="<tr>
				<td>" . $i . "</td>
				<td>" . $customer->id . "</td>
				<td>" . $customer->firstname . "</td>
				<td>" . $customer->lastname . "</td>
				<td>" . $customer->email . "</td>
				<td>" . $customer->phone . "</td>
				<td>" . $customer->phonesms . "</td>
				<td>" . $customer->address1 . "</td>
				<td>" . $customer->city . "</td>
				<td>" . $obj->SelectAllByVal("country", "id", $customer->country, "name") . "</td>
				<td>" . $customer->postalcode . "</td>
				<td>" . $customer->date . "</td>
			</tr>";
            $i++;
        endforeach;

    $data .="</tbody><tfoot><tr>
			<th>#</th>
			<th>Cus-ID</th>
			<th>First Name</th>
			<th>Last Name</th>
			<th>Email</th>
			<th>Phone</th>
			<th>Mobile: Required for SMS</th>
			<th>Address</th>
			<th>City</th>
			<th>State / Country</th>
			<th>Zip / Postal Code</th>
			<th>Register Since</th>
		</tr></tfoot></table>";

    $data .='</body></html>';

    echo $data;
}

if (@$_GET['export'] == "pdf") {
    $record_label = "Customer List Report";
    include("pdf/MPDF57/mpdf.php");
    extract($_GET);

    /* <table style='width:960px; height:40px; font-size:12px; border:0px;'>
      <tr>
      <td width='69%'>Wireless Geeks Inc.<br>".$record_label."</td>
      </tr>
      </table> */
    $html.="<table id='sample-table-2' class='table table-hover' border='0'><tbody>";
    $html .="<tr>
			<td valign='top' style='margin:0; padding:0; width:100%;'>
				<table style='width:100%; height:40px; border:0px;'>
					<tr>
						<td width='87%' style='background:rgba(0,51,153,1);  color:#FFF; font-size:25px;'>
						Customer List Report
						</td>
					</tr>
				</table>
				
				
				
				<table style='width:100%; height:40px; border:0px; font-size:18px;'>
					<tr>
						<td> Customer List Generate Date : " . date('d-m-Y H:i:s') . "</td>
					</tr>
				</table>
				<table style='width:960px;border:1px; font-size:12px; background:#ccc;'>";
    $html.="<thead>
        <tr style='background:#09f; color:#fff;'>
			<th>#</th>
			<th>Cus-ID</th>
			<th>First Name</th>
			<th>Last Name</th>
			<th>Email</th>
			<th>Phone</th>
			<th>Mobile: Required for SMS</th>
			<th>Address</th>
			<th>City</th>
			<th>State / Country</th>
			<th>Zip / Postal Code</th>
			<th>Register Since</th>
		</tr>
</thead>        
<tbody>";

    if ($input_status == 1) {
        $sql_coustomer = $obj->SelectAll($table);
    } elseif ($input_status == 5) {

        $sqlchain_store_ids = $obj->SelectAllByID("store_chain_admin", array("sid" => $input_by));
        if (!empty($sqlchain_store_ids)) {
            $array_ch = array();
            foreach ($sqlchain_store_ids as $ch):
                array_push($array_ch, $ch->store_id);
            endforeach;


            include('class/report_chain_admin.php');
            $obj_report_chain = new chain_report();
            $sql_coustomer = $obj_report_chain->SelectAllByID_Multiple_Or($table, $array_ch, "input_by", "1");
        }
        else {
            //echo "Not Work";
            $sql_coustomer = "";
        }
    } else {
        $sql_coustomer = $obj->SelectAllByID($table, array("input_by" => $input_by));
    }
    $i = 1;
    if (!empty($sql_coustomer))
        foreach ($sql_coustomer as $customer):

            $html.="<tr>
				<td>" . $i . "</td>
				<td>" . $customer->id . "</td>
				<td>" . $customer->firstname . "</td>
				<td>" . $customer->lastname . "</td>
				<td>" . $customer->email . "</td>
				<td>" . $customer->phone . "</td>
				<td>" . $customer->phonesms . "</td>
				<td>" . $customer->address1 . "</td>
				<td>" . $customer->city . "</td>
				<td>" . $obj->SelectAllByVal("country", "id", $customer->country, "name") . "</td>
				<td>" . $customer->postalcode . "</td>
				<td>" . $customer->date . "</td>
			</tr>";
            $i++;
        endforeach;

    $html.="</tbody><tfoot><tr>
			<th>#</th>
			<th>Cus-ID</th>
			<th>First Name</th>
			<th>Last Name</th>
			<th>Email</th>
			<th>Phone</th>
			<th>Mobile: Required for SMS</th>
			<th>Address</th>
			<th>City</th>
			<th>State / Country</th>
			<th>Zip / Postal Code</th>
			<th>Register Since</th>
		</tr></tfoot></table>";

    $html.="</td></tr>";
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
        <?php echo $obj->bodyhead(); ?>
        <script>
            jQuery(window).load(function () {
                var dfs = "<img src='images/loader-big.gif' />";
                $('#customer_total').html(dfs);
                param0 = {'fetch': 1};
                $.post('shout.php', param0, function (res0) {
                    $('#customer_total').html("Total Customer : " + res0);
                });
                //param1 = {'fetch':1}; $.post('json/customer_json.php', param1,  function(res1) { $('#load_customer_list').html(res1); });
                //param3 = {'fetch':3}; $.post('shout.php', param3,  function(res3) { $('#checkin_total').html(res3); });
                //param4 = {'fetch':4}; $.post('shout.php', param4,  function(res4) { $('#sales_total_quantity').html(res4); });
                //param5 = {'fetch':5}; $.post('shout.php', param5,  function(res5) { $('#estimate_total').html(res5); });
                //param6 = {'fetch':6}; $.post('shout.php', param6,  function(res6) { $('#buyback_total').html(res6); });
                //param7 = {'fetch':7}; $.post('shout.php', param7,  function(res7) { $('#unlock_total').html(res7); });
            });
        </script>
    </head>

    <body>
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
                            <h5><i class="font-user"></i> <span style="border-right:2px #333 solid; padding-right:10px;">Customer List</span> 
                                <span><a data-toggle="modal" href="#myModal"> Generate Customer Report</a></span></h5>
                            <ul class="icons">
                                <li><a href="<?php echo $obj->filename(); ?>" class="hovertip" title="Reload"><i class="font-refresh"></i></a></li>
                            </ul>
                        </div><!-- /page header -->


                        <!-- Dialog content -->
                        <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h5 id="myModalLabel">Generate Customer Report <span id="mss"></span></h5>
                            </div>
                            <div class="modal-body">

                                <div class="row-fluid">
                                    <form class="form-horizontal" method="get" action="">
                                        <div class="control-group">
                                            <label class="control-label"><strong>Date Search:</strong></label>
                                            <div class="controls">
                                                <ul class="dates-range">
                                                    <li><input type="text" id="fromDate" name="from" placeholder="From" /></li>
                                                    <li class="sep">-</li>
                                                    <li><input type="text" id="toDate" name="to" placeholder="To" /></li>
                                                    <li class="sep">&nbsp;</li>
                                                    <li><button class="btn btn-primary" type="submit">Search Report</button></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </form>


                                </div>

                            </div>
                            <div class="modal-footer">
                                <form class="form-horizontal" method="get" action="">
                                    <button class="btn btn-primary" name="all" type="submit">Show All Customer</button>
                                </form>
                            </div>
                        </div>
                        <!-- /dialog content -->

                        <div class="body">
                            <!-- Middle navigation standard -->
                            <?php //include('include/quicklink.php');  ?>
                            <!-- /middle navigation standard -->
                            <!-- Content container -->
                            <div class="container">                               
                                <!-- Content Start from here customized -->
                                <!-- Default datatable -->
                                <div class="block">
                                    <h3 style="background:rgba(255,255,255,1); padding:5px 10px;">
                                        <span class="pull-left span4" id="customer_total"></span>
                                        <?php if ($input_status == 2) { ?>
                                            <span class="pull-right span4"><a   onclick="javascript:return confirm('Are you sure to delete all customer info?')"  class="btn btn-danger" href="<?php echo $obj->filename(); ?>?delall"><i class="icon-trash"></i> Delete All Customer</a></span>
                                        <?php } ?>
                                        <div class="clearfix"></div>
                                    </h3>
                                    <div class="table-overflow">
                                        <table class="table table-striped" id="data-table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>CUS-ID</th>
                                                    <th>Name/Business</th>
                                                    <th>Email</th>
                                                    <th>Phone</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if ($input_status == 1) {
                                                    if (isset($_GET['from'])) {
                                                        $sql_coustomer = $obj->SelectAll_ddate("customer_list", "date", $_GET['from'], $_GET['to']);
                                                    } elseif (isset($_GET['all'])) {
                                                        $sql_coustomer = $obj->SelectAll("customer_list");
                                                    } else {
                                                        $sql_coustomer = $obj->SelectAllByID("customer_list", array("date" => date('Y-m-d')));
                                                    }
                                                } elseif ($input_status == 5) {

                                                    $sqlchain_store_ids = $obj->SelectAllByID("store_chain_admin", array("sid" => $input_by));
                                                    if (!empty($sqlchain_store_ids)) {
                                                        $array_ch = array();
                                                        foreach ($sqlchain_store_ids as $ch):
                                                            array_push($array_ch, $ch->store_id);
                                                        endforeach;

                                                        if (isset($_GET['from'])) {
                                                            include('class/report_chain_admin.php');
                                                            $obj_report_chain = new chain_report();
                                                            $sql_coustomer = $obj_report_chain->ReportQuery_Datewise_Or("customer_list", $array_ch, "input_by", $_GET['from'], $_GET['to'], "1");
                                                        } elseif (isset($_GET['all'])) {
                                                            include('class/report_chain_admin.php');
                                                            $obj_report_chain = new chain_report();
                                                            $sql_coustomer = $obj_report_chain->SelectAllByID_Multiple_Or("customer_list", $array_ch, "input_by", "1");
                                                        } else {
                                                            include('class/report_chain_admin.php');
                                                            $obj_report_chain = new chain_report();
                                                            $sql_coustomer = $obj_report_chain->SelectAllByID_Multiple2_Or("customer_list", array("date" => date('Y-m-d')), $array_ch, "input_by", "1");
                                                        }
                                                        //echo "Work";
                                                    } else {
                                                        //echo "Not Work";
                                                        $sql_coustomer = "";
                                                    }
                                                } else {
                                                    if (isset($_GET['from'])) {
                                                        include('class/report_customer.php');
                                                        $obj_report = new report();
                                                        $sql_coustomer = $obj_report->ReportQuery_Datewise("customer_list", array("input_by" => $input_by), $_GET['from'], $_GET['to'], "1");
                                                    } elseif (isset($_GET['all'])) {
                                                        $sql_coustomer = $obj->SelectAllByID("customer_list", array("input_by" => $input_by));
                                                    } else {
                                                        $sql_coustomer = $obj->SelectAllByID_Multiple("customer_list", array("input_by" => $input_by, "date" => date('Y-m-d')));
                                                    }
                                                }

                                                $i = 1;
                                                if (!empty($sql_coustomer))
                                                    foreach ($sql_coustomer as $customer):
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $i; ?></td>
                                                            <td><?php echo $customer->id; ?></td>
                                                            <td><?php echo $customer->fullname; ?></td>
                                                            <td><?php echo $customer->email; ?></td>
                                                            <td><?php echo $customer->phone; ?></td>
                                                            <td>
                                                                <?php if ($input_status == 1 || $input_status == 2 || $input_status == 5) { ?>   
                                                                    <a href="customer.php?edit=<?php echo $customer->id; ?>" class="hovertip"   onclick="javascript:return confirm('Are you absolutely sure to Edit This?')" title="Edit Detail"><i class="icon-edit"></i></a> <a href="<?php echo $obj->filename(); ?>?del=<?php echo $customer->id; ?>" class="hovertip"  onclick="javascript:return confirm('Are you absolutely sure to delete This?')" title="Delete"><i class="icon-trash"></i></a>
                                                                <?php } ?>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                        $i++;
                                                    endforeach;
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- /default datatable -->
                                <!-- Content End from here customized -->
                                <div class="separator-doubled"></div>
                                <a href="<?php echo $obj->filename(); ?>?export=excel"><img src="pos_image/file_excel.png"></a>
                                <a href="<?php echo $obj->filename(); ?>?export=pdf"><img src="pos_image/file_pdf.png"></a> 
                            </div>
                            <!-- /content container -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- /main content -->
            <?php include('include/footer.php'); ?>
            <!-- Right sidebar -->
            <?php //include('include/sidebar_right.php'); ?>
            <!-- /right sidebar -->
        </div>
        <!-- /main wrapper -->
    </body>
</html>
