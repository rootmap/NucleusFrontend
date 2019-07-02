<?php
include('class/auth.php');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
        include './plugin/plugin.php';
        $cms = new CmsRootPlugin();
        echo $cms->GeneralCss(array("kendo", "modal"));
        ?>
        <?php //echo $obj->bodyhead(); ?>
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
                <?php
                echo $obj->ShowMsg();

                /* if ($input_status == 1) {
                  if (isset($_GET['from'])) {
                  $from=$_GET['from'];
                  $to=$_GET['to'];
                  $sqlticket=$report->SelectAllDate("checkin_list", $from, $to, "1");
                  $record=$report->SelectAllDate("checkin_list", $from, $to, "2");
                  $record_label="| Report Generate Between " . $from . " - " . $to;
                  }else {
                  $sqlticket=$obj->SelectAllByID("checkin_list", array("date"=>date('Y-m-d')));
                  $record=$obj->exists_multiple("checkin_list", array("date"=>date('Y-m-d')));
                  $record_label="";
                  }
                  }elseif ($input_status == 5) {

                  $sqlchain_store_ids=$obj->SelectAllByID("store_chain_admin", array("sid"=>$input_by));
                  if (!empty($sqlchain_store_ids)) {
                  $array_ch=array();
                  foreach ($sqlchain_store_ids as $ch):
                  array_push($array_ch, $ch->store_id);
                  endforeach;

                  if (isset($_GET['from'])) {
                  include('class/report_chain_admin.php');
                  $obj_report_chain=new chain_report();
                  $sqlticket=$obj_report_chain->ReportQuery_Datewise_Or("checkin_list", $array_ch, "input_by", $_GET['from'], $_GET['to'], "1");
                  $record=$obj_report_chain->ReportQuery_Datewise_Or("checkin_list", $array_ch, "input_by", $_GET['from'], $_GET['to'], "2");
                  $record_label="";
                  }else {
                  include('class/report_chain_admin.php');
                  $obj_report_chain=new chain_report();
                  $sqlticket=$obj_report_chain->SelectAllByID_Multiple2_Or("checkin_list", array("date"=>date('Y-m-d')), $array_ch, "input_by", "1");
                  $record=$obj_report_chain->SelectAllByID_Multiple2_Or("checkin_list", array("date"=>date('Y-m-d')), $array_ch, "input_by", "2");
                  ;
                  $record_label="";
                  }
                  //echo "Work";
                  }else {
                  //echo "Not Work";
                  $sqlticket="";
                  $record=0;
                  $record_label="";
                  }
                  }else {
                  if (isset($_GET['from'])) {
                  $from=$_GET['from'];
                  $to=$_GET['to'];
                  $sqlticket=$report->SelectAllDate_Store("checkin_list", $from, $to, "1", "input_by", $input_by);
                  $record=$report->SelectAllDate_Store("checkin_list", $from, $to, "2", "input_by", $input_by);
                  $record_label="| Report Generate Between " . $from . " - " . $to;
                  }else {
                  $sqlticket=$obj->SelectAllByID_Multiple("checkin_list", array("input_by"=>$input_by, "date"=>date('Y-m-d')));
                  $record=$obj->exists_multiple("checkin_list", array("input_by"=>$input_by, "date"=>date('Y-m-d')));
                  $record_label="";
                  }
                  } */
                ?>
                <!-- /info notice -->

                <div class="outer">
                    <div class="inner">
                        <div class="page-header"><!-- Page header -->
                            <h5><i class="icon-ok-circle"></i>
                                <span style="border-right:2px #333 solid; padding-right:10px;">In-Store Repair Profit Report </span>
                                <span><i class="font-calendar"></i> <a data-toggle="modal" href="#myModal"> Generate In-Store Repair Report</a></span> 
                            </h5>
                            <ul class="icons">
                                <li><a href="<?php echo $obj->filename(); ?>" class="hovertip" title="Reload"><i class="font-refresh"></i></a></li>
                            </ul>
                        </div><!-- /page header -->

                        <div class="body">
                            <!-- Dialog content -->
                            <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h5 id="myModalLabel"><i class="font-calendar"></i> Generate In-Store Repair Profit Report <span id="mss"></span></h5>
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
                            </div>
                            <!-- /dialog content -->

                            <!-- Middle navigation standard -->

                            <?php //include('include/quicklink.php');   ?>
                            <!-- /middle navigation standard -->

                            <!-- Content container -->
                            <div class="container">



                                <!-- Content Start from here customized -->

                                <div class="table-overflow">

                                    <div id="grid" style="margin-left: 10px;margin-right: 10px;"></div>
                                    <?php
                                    $cond = $cms->FrontEndDateSearch('from', 'to');
                                    ?>
                                    <script id="profit" type="text/x-kendo-template">
                                        <?php echo $currencyicon; ?>#= kendo.toString(paid-our_cost, "n2")#
                                    </script>
                                    <script id="checkin_link" type="text/x-kendo-template">
                                            <a class="k-button" href="view_checkin.php?ticket_id=#=checkin_id#">#=checkin_id#</a>
                                        </script>
                                    <script type="text/javascript">
                                        jQuery(document).ready(function () {
                                            var dataSource = new kendo.data.DataSource({
                                                transport: {
                                                    read: {
                                                        url: "./controller/checkin_list_report.php<?php echo $cond; ?>",
                                                        type: "GET",
                                                        datatype: "json",
                                                        complete: function (response) {
                                                            var page_countitem=0;
                                                            var page_ourcost=0;
                                                             var page_paid=0;
                                                            jQuery.each(response, function (index, key) {
                                                                if (index == 'responseJSON')
                                                                {
                                                                    //console.log(key.data);
                                                                    jQuery.each(key.data, function (datagr, keyg) {
                                                                        //console.log(keyg.our_cost);
                                                                        page_countitem+=(1-0);
                                                                        page_ourcost+=(keyg.our_cost-0);
                                                                        page_paid+=(keyg.paid-0);
                                                                        
                                                                    });
                                                                    //console.log(page_ourcost);
                                                                    jQuery("#a1").html(page_countitem+"  of  "+key.total);
                                                                    jQuery("#a2").html(page_ourcost);
                                                                    jQuery("#a3").html(parseFloat(page_paid).toFixed(2));
                                                                    jQuery("#a4").html(parseFloat((page_paid-page_ourcost)).toFixed(2));
                                                                }
                                                            })
                                                        }
                                                    }
                                                },
                                                autoSync: false,
                                                schema: {
                                                    data: "data",
                                                    total: "total",
                                                    model: {
                                                        id: "id",
                                                        fields: {
                                                            id: {nullable: true},
                                                            checkin_id: {type: "string"},
                                                            detail: {type: "string"},
                                                            our_cost: {type:"number"},
                                                            paid: {type:"number"},
                                                            date: {type: "string"}
                                                        }
                                                    }
                                                },
                                                pageSize: 10,
                                                serverPaging: true,
                                                serverFiltering: true,
                                                serverSorting: true
                                            });
                                            jQuery("#grid").kendoGrid({
                                                dataSource: dataSource,
                                                filterable: true,
                                                pageable: {
                                                    refresh: true,
                                                    input: true,
                                                    numeric: false,
                                                    pageSizes: true,
                                                    pageSizes:[10, 20, 50, 100, 200, 400, 1000,10000,50000]
                                                },
                                                sortable: true,
                                                groupable: true,
                                                columns: [
                                                    {field: "id", title: "B.ID", width: "60px"},
                                                    {template: kendo.template($("#checkin_link").html()), title: "Checkin ID"},
                                                    {field: "detail", title: "Detail", width: "320px"},
                                                    {title: "Our Cost", template: "<?php echo $currencyicon; ?>#=our_cost#",filter:false},
                                                    {title: "Checkin Price", template: "<?php echo $currencyicon; ?>#=paid#"},
                                                    {template: kendo.template($("#profit").html()), title: "Profit"},
                                                    {field: "date", title: "Date", width: "90px"}
                                                ], group: {
                                                    field: "our_cost", aggregates: [
                                                        {field: "our_cost", aggregate: "sum"}
                                                    ]
                                                },
                                                aggregate: [{field: "our_cost", aggregate: "sum"}]
                                            });
                                            
                                            
                                            // CSV file export code
                                        jQuery("#export-grid").click(function (e) {
                                            e.preventDefault();
                                            var dataSource = jQuery("#grid").data("kendoGrid").dataSource;
                                            var filters = dataSource.filter();
                                            var allData = dataSource.data();
                                            var query = new kendo.data.Query(allData);
                                            var data = query.filter(filters).data;

                                            var json_data = JSON.stringify(data);
                                            console.log(json_data);
                                            JSONToCSVConvertor(json_data, "Checkin Report List", true);

                                        });



                                        function JSONToCSVConvertor(JSONData, ReportTitle, ShowLabel) {
                                            //If JSONData is not an object then JSON.parse will parse the JSON string in an Object
                                            var arrData = typeof JSONData != 'object' ? JSON.parse(JSONData) : JSONData;

                                            var CSV = '';
                                            //Set Report title in first row or line

                                            CSV += ReportTitle + '\r\n\n';

                                            //This condition will generate the Label/Header
                                            if (ShowLabel) {
                                                var row = "";

                                                //This loop will extract the label from 1st index of on array
                                                for (var index in arrData[0]) {

                                                    //Now convert each value to string and comma-seprated
                                                    var regexUnderscore = new RegExp("_", "g");
                                                    row += index.replace(regexUnderscore, " ").toUpperCase() + ',';
                                                    //  row += index + ',';
                                                }

                                                row = row.slice(0, -1);

                                                //append Label row with line break
                                                CSV += row + '\r\n';
                                            }
                                            //1st loop is to extract each row
                                            for (var i = 0; i < arrData.length; i++) {
                                                var row = "";

                                                //2nd loop will extract each column and convert it in string comma-seprated
                                                for (var index in arrData[i]) {
                                                    row += '"' + arrData[i][index] + '",';
                                                }

                                                row.slice(0, row.length - 1);

                                                //add a line break after each row
                                                CSV += row + '\r\n';
                                            }

                                            if (CSV == '') {
                                                alert("Invalid data");
                                                return;
                                            }

                                            //Generate a file name
                                            var fileName = "checkin_report_list";
                                            //this will remove the blank-spaces from the title and replace it with an underscore
                                            fileName += ReportTitle.replace(/ /g, "_");

                                            //Initialize file format you want csv or xls
                                            var uri = 'data:text/csv;charset=utf-8,' + escape(CSV);

                                            // Now the little tricky part.
                                            // you can use either>> window.open(uri);
                                            // but this will not work in some browsers
                                            // or you will not get the correct file extension    

                                            // this trick will generate a temp <a /> tag
                                            var link = document.createElement("a");
                                            link.href = uri;

                                            //set the visibility hidden so it will not effect on your web-layout
                                            link.style = "visibility:hidden";
                                            link.download = fileName + ".csv";

                                            //this part will append the anchor tag and remove it after automatic click
                                            document.body.appendChild(link);
                                            link.click();
                                            document.body.removeChild(link);
                                        }
                                        
                                        //javascript CSV output end
                                        
                                        });

                                    </script>













                                </div>

                                <!-- Default datatable -->
                                <?php /* <div class="table-overflow">
                                  <table class="table table-striped" id="data-table">
                                  <thead>
                                  <tr>
                                  <th>#</th>

                                  <th>Checkin ID</th>
                                  <?php if ($input_status == 1 || $input_status == 5) { ?>
                                  <th>Store</th>
                                  <?php } ?>

                                  <th>Check IN Detail</th>
                                  <th>Our Cost</th>
                                  <th>Retail Cost</th>
                                  <th>Profit</th>
                                  <th>Date</th>
                                  </tr>
                                  </thead>
                                  <tbody>
                                  <?php
                                  $i=1;
                                  $a=0;
                                  $b=0;
                                  $c=0;
                                  $d=0;
                                  if (!empty($sqlticket))
                                  foreach ($sqlticket as $ticket):

                                  $chkcheckin=$obj->exists_multiple("pos_checkin", array("checkin_id"=>$ticket->checkin_id));
                                  $getsales_id=$obj->SelectAllByVal("pos_checkin", "checkin_id", $ticket->checkin_id, "invoice_id");
                                  $curcheck=$obj->exists_multiple("sales", array("sales_id"=>$getsales_id));
                                  if ($curcheck != 0) {
                                  $a+=1;
                                  ?>
                                  <tr>
                                  <td><?php echo $i; ?></td>
                                  <td><a href="view_checkin.php?ticket_id=<?php echo $ticket->checkin_id; ?>"><?php echo $ticket->checkin_id; ?></a></td>
                                  <?php if ($input_status == 1 || $input_status == 5) { ?>
                                  <td><?php echo $obj->SelectAllByVal("store", "store_id", $ticket->input_by, "name"); ?></td>
                                  <?php } ?>
                                  <td><?php echo $ticket->device . " " . $ticket->model . " " . $ticket->color . " " . $ticket->network . " " . $ticket->problem; ?></td>
                                  <td>$<?php
                                  $chkx=$obj->exists_multiple("check_user_price", array("ckeckin_id"=>$ticket->checkin_id));
                                  if ($chkx == 0) {
                                  $estp=$obj->SelectAllByVal("product", "name", $ticket->device . "-" . $ticket->problem, "price_cost");
                                  if ($estp == '') {
                                  $devid=$obj->SelectAllByVal("checkin_request", "checkin_id", $ticket->checkin_id, "device_id");
                                  $modid=$obj->SelectAllByVal("checkin_request", "checkin_id", $ticket->checkin_id, "model_id");
                                  $probid=$obj->SelectAllByVal("checkin_request", "checkin_id", $ticket->checkin_id, "problem_id");
                                  $pp=$obj->SelectAllByVal3("checkin_price", "checkin_id", $devid, "checkin_version_id", $modid, "checkin_problem_id", $probid, "name");
                                  }else {
                                  $pp=$estp;
                                  }
                                  }else {

                                  $estp=$obj->SelectAllByVal("check_user_price", "ckeckin_id", $ticket->checkin_id, "price");
                                  if ($estp == '') {
                                  $devid=$obj->SelectAllByVal("checkin_request", "checkin_id", $ticket->checkin_id, "device_id");
                                  $modid=$obj->SelectAllByVal("checkin_request", "checkin_id", $ticket->checkin_id, "model_id");
                                  $probid=$obj->SelectAllByVal("checkin_request", "checkin_id", $ticket->checkin_id, "problem_id");
                                  $pp=$obj->SelectAllByVal3("checkin_price", "checkin_id", $devid, "checkin_version_id", $modid, "checkin_problem_id", $probid, "name");
                                  }else {
                                  $pp=$estp;
                                  }
                                  }
                                  $pid=$obj->SelectAllByVal("product", "name", $ticket->device . ", " . $ticket->model . " - " . $ticket->problem, "id");
                                  $cid=$obj->SelectAllByVal2("coustomer", "firstname", $obj->SelectAllByVal("checkin_request", "checkin_id", $ticket->checkin_id, "first_name"), "phone", $obj->SelectAllByVal("checkin_request", "checkin_id", $ticket->checkin_id, "phone"), "id");
                                  $ourcost=$obj->SelectAllByVal("product_report", "name", $ticket->device . ", " . $ticket->model . " - " . $ticket->problem, "ourcost");
                                  $b+=$ourcost;
                                  echo $ourcost;
                                  ?></td>

                                  <td>$<?php
                                  if ($pp == '') {
                                  $retailcost=$obj->SelectAllByVal("product_report", "name", $ticket->device . ", " . $ticket->model . " - " . $ticket->problem, "retailcost");
                                  }else {
                                  $retailcost=$pp;
                                  }

                                  echo $retailcost;
                                  $c+=$retailcost;
                                  $profit=$retailcost - $ourcost;
                                  $d+=$profit;
                                  ?></a></td>
                                  <td>$<?php echo $profit; ?></td>
                                  <td><?php echo $ticket->date; ?></td>


                                  </tr>
                                  <?php
                                  $i++;
                                  }
                                  endforeach;
                                  ?>
                                  </tbody>
                                  </table>
                                  </div>
                                 */ ?>



                                <!-- /default datatable -->
                                <!-- Default datatable -->
                                <div style="margin-top:10px; margin-left: 10px;" class="table-overflow">

                                    <table class="table table-striped" style="width:250px;">
                                        <tbody>
                                            <tr>
                                                <td>1. Total Check IN Quantity : <?php echo $currencyicon; ?><span id="a1"><?php //echo $a;    ?></span></td>
                                            </tr>
                                            <tr>
                                                <td>2. Our Total Cost : <?php echo $currencyicon; ?><span id="a2"><?php //echo $b;    ?></span></td>
                                            </tr>
                                            <tr>
                                                <td>3. Retail Total Cost : <?php echo $currencyicon; ?><span id="a3"><?php //echo $c;    ?></span></td>
                                            </tr>
                                            <tr>
                                                <td>4. Profit : <?php echo $currencyicon; ?><span id="a4"><?php //echo $d;    ?></span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /default datatable -->


                                <!-- Content End from here customized -->




                                <div class="separator-doubled"></div>


                                <a id="export-grid" href="javascript:void(0);">
                                    <img src="pos_image/file_excel.png">
                                </a>
                                <a href="<?php echo $obj->filename(); ?>?export=pdf">
                                    <img src="pos_image/file_pdf.png">
                                </a>


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
            <!-- Right sidebar -->
            <?php //include('include/sidebar_right.php');    ?>
            <!-- /right sidebar -->

        </div>
        <!-- /main wrapper -->

    </body>
</html>
