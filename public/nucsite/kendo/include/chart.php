

<?php

function makedate($str) {
    $ddf=date('Y-m-d');
    $datenews=date_create($ddf);
    date_modify($datenews, "-" . $str . " days");
    return $datenews=date_format($datenews, "Y-m-d");
}

function randomColor($r) {
    $possibilities=array(1, 2, 3, 4, 5, 6, 7, 8, 9, "A", "B", "C", "D", "E", "F");
    shuffle($possibilities);
    $color="#";
    for ($i=1; $i <= $r; $i++) {
        $color .= $possibilities[rand(0, 14)];
    }
    return $color;
}

include('./class/chart.php');
$chart=new chart();
$sqlinvoice='';
if ($input_status == 1) {
    $sqlinvoice .="SELECT IFNULL(SUM(s.profit),0) as profit from sales_list as s WHERE s.date='" . date('Y-m-d') . "';";
}else {
    $sqlinvoice .="SELECT IFNULL(SUM(s.profit),0) as profit from sales_list as s WHERE s.date='" . date('Y-m-d') . "' AND s.input_by='" . $input_by . "';";
}

if ($input_status == 1) {
    $sqlinvoice .="SELECT IFNULL(count(s.id),0) as totalrows from ticket_list as s WHERE s.date='" . date('Y-m-d') . "';";
}else {
    $sqlinvoice .="SELECT IFNULL(count(s.id),0) as totalrows from ticket_list as s WHERE s.date='" . date('Y-m-d') . "' AND s.input_by='" . $input_by . "';";
}

if ($input_status == 1) {
    $sqlinvoice .="SELECT IFNULL(count(s.id),0) as totalrows from checkin_list as s WHERE s.date='" . date('Y-m-d') . "';";
}else {
    $sqlinvoice .="SELECT IFNULL(count(s.id),0) as totalrows from checkin_list as s WHERE s.date='" . date('Y-m-d') . "' AND s.input_by='" . $input_by . "';";
}


if ($input_status == 1) {
    for ($a=1; $a <= 15; $a++):
        $sqlinvoice .="SELECT IFNULL(SUM(s.profit),0) as profit from sales_list as s WHERE s.date='" . makedate($a) . "';";
    endfor;
}else {
    for ($a=1; $a <= 15; $a++):
        $sqlinvoice .="SELECT IFNULL(SUM(s.profit),0) as profit from sales_list as s WHERE s.date='" . makedate($a) . "' AND s.input_by='" . $input_by . "';";
    endfor;
}

if ($input_status == 1) {
    $sqlinvoice .="SELECT c.id,c.name,IFNULL(SUM(s.profit),0) as profit FROM cashier_list as c LEFT JOIN sales_list as s ON s.cashier_id=c.id GROUP BY c.id;";
}else {
    $sqlinvoice .="SELECT c.id,c.name, IFNULL(SUM(s.profit), 0) as profit FROM cashier_list as c LEFT JOIN sales_list as s ON s.cashier_id=c.id WHERE c.store_id='" . $input_by . "' GROUP BY c.id;";
}

if ($input_status == 1) {
    for ($a=1; $a <= 15; $a++):
        $sqlinvoice .="SELECT IFNULL(count(s.id),0) as totalrows from ticket_list as s WHERE date='" . makedate($a) . "';";
    endfor;
}else {
    for ($a=1; $a <= 15; $a++):
        $sqlinvoice .="SELECT IFNULL(count(s.id),0) as totalrows from ticket_list as s WHERE date='" . makedate($a) . "' AND input_by='" . $input_by . "';";
    endfor;
}


if ($input_status == 1) {
    for ($a=1; $a <= 15; $a++):
        $sqlinvoice .="SELECT IFNULL(count(s.id),0) as totalrows from checkin_list as s WHERE date='" . makedate($a) . "';";
    endfor;
}else {
    for ($a=1; $a <= 15; $a++):
        $sqlinvoice .="SELECT IFNULL(count(s.id),0) as totalrows from checkin_list as s WHERE date='" . makedate($a) . "' AND input_by='" . $input_by . "';";
    endfor;
}

if ($input_status == 1) {
    $sqlinvoice .="SELECT s.date,IFNULL(SUM(s.totalcost),0) as totalcost FROM sales_list as s WHERE s.date='" . date('Y-m-d') . "';";
}else {
    $sqlinvoice .="SELECT s.input_by,s.date,IFNULL(SUM(s.totalcost),0) as totalcost FROM sales_list as s WHERE s.date='" . date('Y-m-d') . "' AND s.input_by='" . $input_by . "';";
}


$sqlinvoice1='';
$sqlinvoice2='';
$sqlinvoice3='';
$sqlinvoice4='';

if ($input_status == 1) {
    for ($g=0; $g <= 66; $g++):
        $sqlinvoice .="select b.payment_method,b.date,IFNULL(SUM(b.price),0) as price FROM buyback as b WHERE b.payment_method='3' AND date='" . makedate($g) . "' GROUP BY b.payment_method;";
        $sqlinvoice .="select b.payment_method,b.date,IFNULL(SUM(b.price),0) as price FROM buyback as b WHERE b.payment_method='4' AND date='" . makedate($g) . "' GROUP BY b.payment_method;";

        $sqlinvoice .="select b.date,IFNULL(SUM(b.amount),0) as price FROM payout as b WHERE b.date='" . makedate($g) . "' GROUP BY b.date;";
        $sqlinvoice .="select b.date,IFNULL(SUM(b.amount),0) as price FROM payout as b WHERE b.date='" . makedate($g) . "' GROUP BY b.date;";
    endfor;
}else {
    for ($g=0; $g <= 66; $g++):
        $sqlinvoice .="select b.payment_method,b.date,IFNULL(SUM(b.price),0) as price FROM buyback as b WHERE b.payment_method='3' AND b.date='" . makedate($g) . "' AND input_by='" . $input_by . "' GROUP BY b.payment_method;";
        $sqlinvoice .="select b.payment_method,b.date,IFNULL(SUM(b.price),0) as price FROM buyback as b WHERE b.payment_method='4' AND b.date='" . makedate($g) . "' AND input_by='" . $input_by . "' GROUP BY b.payment_method;";

        $sqlinvoice .="select b.date,IFNULL(SUM(b.amount),0) as price FROM payout as b WHERE b.date='" . makedate($g) . "' AND input_by='" . $input_by . "' GROUP BY b.date;";
        $sqlinvoice .="select b.date,IFNULL(SUM(b.amount),0) as price FROM payout as b WHERE b.date='" . makedate($g) . "' AND input_by='" . $input_by . "' GROUP BY b.date;";
    endfor;
}


for ($a=1; $a <= 15; $a++):
    if ($input_status == 1) {
        $sqlinvoice .="SELECT s.date,IFNULL(SUM(s.totalcost),0) as totalcost FROM sales_list as s WHERE s.date='" . makedate($a) . "';";
    }else {
        $sqlinvoice .="SELECT s.input_by,s.date,IFNULL(SUM(s.totalcost),0) as totalcost FROM sales_list as s WHERE s.date='" . makedate($a) . "' AND s.input_by='" . $input_by . "';";
    }
endfor;


if ($input_status == 1) {
    $sqlinvoice .="SELECT s.date,IFNULL(SUM(s.quantity),0) as quantity FROM sales_list as s WHERE s.date='" . date('Y-m-d') . "';";
}else {
    $sqlinvoice .="SELECT s.input_by,s.date,IFNULL(SUM(s.quantity),0) as quantity FROM sales_list as s WHERE s.date='" . date('Y-m-d') . "' AND s.input_by='" . $input_by . "';";
}
//333
for ($a=1; $a <= 15; $a++):
    if ($input_status == 1) {
        $sqlinvoice .="SELECT s.date,IFNULL(SUM(s.quantity),0) as quantity FROM sales_list as s WHERE s.date='" . makedate($a) . "';";
    }else {
        $sqlinvoice .="SELECT s.input_by,s.date,IFNULL(SUM(s.quantity),0) as quantity FROM sales_list as s WHERE s.date='" . makedate($a) . "' AND s.input_by='" . $input_by . "';";
    }
endfor;

if ($input_status == 1) {
    $sqlinvoice .="SELECT s.date,IFNULL(SUM(s.total_collection_cash_credit_card),0) as total_collection_cash_credit_card FROM close_store_detail as s WHERE s.date='" . date('Y-m-d') . "';";
}else {
    $sqlinvoice .="SELECT s.store_id,s.date,IFNULL(SUM(s.total_collection_cash_credit_card),0) as total_collection_cash_credit_card FROM close_store_detail as s WHERE s.date='" . date('Y-m-d') . "' AND s.store_id='" . $input_by . "';";
}

for ($a=1; $a <= 5; $a++):
    if ($input_status == 1) {
        $sqlinvoice .="SELECT s.date,IFNULL(SUM(s.total_collection_cash_credit_card),0) as total_collection_cash_credit_card FROM close_store_detail as s WHERE s.date='" . makedate($a) . "';";
    }else {
        $sqlinvoice .="SELECT s.store_id,s.date,IFNULL(SUM(s.total_collection_cash_credit_card),0) as total_collection_cash_credit_card FROM close_store_detail as s WHERE s.date='" . makedate($a) . "' AND s.store_id='" . $input_by . "';";
    }
endfor;
//354
if ($input_status == 1) {
    $sqlinvoice .="SELECT s.date,IFNULL(SUM(s.total_collection_cash_credit_card),0) as total_collection_cash_credit_card FROM close_store_detail as s WHERE s.date='" . date('Y-m-d') . "';";
}else {
    $sqlinvoice .="SELECT s.store_id,s.date,IFNULL(SUM(s.total_collection_cash_credit_card),0) as total_collection_cash_credit_card FROM close_store_detail as s WHERE s.date='" . date('Y-m-d') . "' AND s.store_id='" . $input_by . "';";
}
//355
for ($a=1; $a <= 5; $a++):
    if ($input_status == 1) {
        $sqlinvoice .="SELECT s.date,IFNULL(SUM(s.cash_collected_plus),0) as cash_collected_plus FROM close_store_detail as s WHERE s.date='" . makedate($a) . "';";
    }else {
        $sqlinvoice .="SELECT s.store_id,s.date,IFNULL(SUM(s.cash_collected_plus),0) as cash_collected_plus FROM close_store_detail as s WHERE s.date='" . makedate($a) . "' AND s.store_id='" . $input_by . "';";
    }
endfor;
//360
$query=$chart->AllInOne($sqlinvoice);
//$query1=$chart->AllInOne($sqlinvoice1);
//$query2=$chart->AllInOne($sqlinvoice2);
//$query3=$chart->AllInOne($sqlinvoice3);
//$query4=$chart->AllInOne($sqlinvoice4);
//echo var_dump($query[34]);
//foreach ($query[18] as $row):
//    echo $row->profit;
//endforeach;
//exit();
?>
<div class="row-fluid block">

    <div class="semi-block" style="margin-top:-20px;">
        <div class="body">
            <!--bar chart start-->
            <div class="span6 well-white ">

                <div style="width:100%">
                    <h3 style="padding-left:30px; border-bottom:3px #666 solid;">Profit Report <?php ?> </h3>
                    <canvas id="canvas" height="450" width="600"></canvas>

                    <script>
                        //var randomScalingFactor = function(){ return Math.round(Math.random()*100)};

                        var barChartData = {
                        labels : ["<?php echo date('Y-m-d'); ?>",
<?php
for ($b=1; $b <= 15; $b++):
    if ($b == 15) {
        ?>"<?php echo makedate($b); ?>"<?php }else {
        ?>"<?php echo makedate($b); ?>",<?php
    }
endfor;
?>
                        ],
                                datasets : [
                                {
                                fillColor : "rgba(134,179,0,1)",
                                        strokeColor : "rgba(134,179,0,0)",
                                        highlightFill: "rgba(134,179,0,1)",
                                        highlightStroke: "rgba(134,179,0,0)",
                                        data : [<?php
if (!empty($query[0])) {
    $pp=$query[0][0]->profit;
    echo $pp;
}else {
    echo $pp=0;
}
?>,<?php
$param=2;
for ($a=1; $a <= 15; $a++):
    $param+=$a;
    if ($a == 15) {
        if (!empty($query[$param])) {
            $pp=$query[$param][0]->profit;

            echo $pp;
        }else {
            echo $pp=0;
        }
    }else {

        if (!empty($query[$param])) {
            $pp=$query[$param][0]->profit;

            echo $pp;
        }else {
            echo $pp=0;
        }
        echo ",";
    }

endfor;
?>]
                                }
                                ]

                        }

                    </script><div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
            </div>
            <!--Bar chart end-->
            <!--Dought chart start-->
            <div class="span6 well-white ">

                <div style="width:100%">
                    <h3 style="padding-left:30px; border-bottom:3px #666 solid;">Employee Wise Sales </h3>
                    <div id="canvas-holder" style="width:75%; margin-left:auto; margin-right:auto;">
                        <canvas id="chart-areas" width="100%" height="100%"/>
                    </div>


                    <script>

                        var doughnutData = [
<?php
//cashier
$countccc=count($query[18]);
$fp=1;
if (!empty($query[18]))
    foreach ($query[18] as $cashier):

        $cp=$cashier->profit;
        if ($countccc == $fp) {
            ?>
                                    {
                                    value:<?php echo $cp; ?>,
                                            color:"#<?php echo dechex(rand(0x000000, 0xFFFFFF)); ?>",
                                            highlight: "#<?php echo dechex(rand(0x000000, 0xFFFFFF)); ?>",
                                            label: "<?php echo $cashier->name; ?>"
                                    }
            <?php
        }else {
            ?>
                                    {
                                    value:<?php echo $cp; ?>,
                                            color:"#<?php echo dechex(rand(0x000000, 0xFFFFFF)); ?>",
                                            highlight: "#<?php echo dechex(rand(0x000000, 0xFFFFFF)); ?>",
                                            label: "<?php echo $cashier->name; ?>"
                                    },
            <?php
        }
        $fp++;
    endforeach;
?>];
                                /*			window.onload = function()
                                 {

                                 };
                                 */


                    </script>

                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
            </div>
            <!--Dought chart end-->



            <div class="clearfix"></div>

            <!--Line chart start-->
            <div class="span6 well-white" style="margin-left:0px; margin-top:10px;">

                <div style="width:100%">
                    <h3 style="padding-left:30px; border-bottom:3px #666 solid;">Checkin &amp; Ticket Report <?php ?> </h3>
                    <canvas id="canvas_line" height="450" width="600"></canvas>

                    <script>
                                var randomScalingFactor = function(){ return Math.round(Math.random() * 100)};
                                var lineChartData = {
                                labels : ["<?php echo date('Y-m-d'); ?>",<?php
for ($b=1; $b <= 15; $b++):
    if ($b == 15) {
        ?>"<?php echo makedate($b); ?>"<?php }else {
        ?>"<?php echo makedate($b); ?>",<?php
    }
endfor;
?>
                                ],
                                        datasets : [
                                        {
                                        label: "My First dataset",
                                                fillColor : "rgba(220,220,220,0.2)",
                                                strokeColor : "rgba(220,220,220,1)",
                                                pointColor : "rgba(220,220,220,1)",
                                                pointStrokeColor : "#fff",
                                                pointHighlightFill : "#fff",
                                                pointHighlightStroke : "rgba(220,220,220,1)",
                                                data : [<?php
if (!empty($query[1])) {
    $pp=$query[1][0]->totalrows;
    echo $pp;
}else {
    echo $pp=0;
}
?>,<?php
$param=18;
for ($a=1; $a <= 15; $a++):
    $param+=$a;
    if ($a == 15) {
        if (!empty($query[$param])) {
            $pp=$query[$param][0]->totalrows;
            echo $pp;
        }else {
            echo $pp=0;
        }
    }else {
        if (!empty($query[$param])) {
            $pp=$query[$param][0]->totalrows;
            echo $pp;
        }else {
            echo $pp=0;
        }
        echo ",";
    }
endfor;
?>]
                                        },
                                        {
                                        label: "My Second dataset",
                                                fillColor : "rgba(151,187,205,0.2)",
                                                strokeColor : "rgba(151,187,205,1)",
                                                pointColor : "rgba(151,187,205,1)",
                                                pointStrokeColor : "#fff",
                                                pointHighlightFill : "#fff",
                                                pointHighlightStroke : "rgba(151,187,205,1)",
                                                data : [<?php
if (!empty($query[2])) {
    $pp=$query[2][0]->totalrows;

    echo $pp;
}else {
    echo $pp=0;
}
?>,<?php
$param=33;
for ($a=1; $a <= 15; $a++):
    $param+=$a;
    if ($a == 15) {
        if (!empty($query[$param])) {
            $pp=$query[$param][0]->totalrows;
            echo $pp;
        }else {
            echo $pp=0;
        }
    }else {
        if (!empty($query[$param])) {
            $pp=$query[$param][0]->totalrows;
            echo $pp;
        }else {
            echo $pp=0;
        }
        echo ",";
    }
endfor;
?>]
                                        }
                                        ]

                                }


                    </script><div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
            </div>
            <!--Line chart end-->

            <!--Pie chart start-->
            <div class="span6 well-white" style="margin-top:10px;">

                <div style="width:100%">
                    <h3 style="padding-left:30px; border-bottom:3px #666 solid;">Cash, Credit, buyback Report <?php ?> </h3>
                    <div id="canvas-holder" style="margin-left:auto; margin-right:auto; width:75%;">
                        <canvas id="chart-area_pie" width="100%" height="100%"/>
                    </div>
                    <?php ?>
                    <script>
                        var pieData = [
<?php
//49
$param=49;
for ($g=0; $g <= 66; $g++):
    $param1=$param + 1;
    $param2=$param + 2;
    if ($input_status == 1) {
        $cash=$query[$param1][0]->price;
        $credit=$query[$param2][0]->price;
    }else {
        $cash=$query[$param1][0]->price;
        $credit=$query[$param2][0]->price;
    }
    $param+=4;
    $total=$cash + $credit;
    if ($g == 66) {
        ?>
                                {
                                value:<?php echo $total; ?>,
                                        color:"#<?php echo dechex(rand(0x010000, 0xFFF0FF)); ?>",
                                        highlight: "#<?php echo dechex(rand(0x000000, 0xFFFFFF)); ?>",
                                        label: "<?php echo makedate($g); ?> - Cash = <?php echo $cash; ?>, Credit Card = <?php echo $credit; ?>"
                                            }
        <?php
    }else {
        ?>
                                            {
                                            value:<?php echo $total; ?>,
                                                    color:"#<?php echo dechex(rand(0x0F0000, 0xFFF1FF)); ?>",
                                                    highlight: "#<?php echo dechex(rand(0x00A000, 0xFFF0FF)); ?>",
                                                    label: "<?php echo makedate($g); ?> - Cash = <?php echo $cash; ?>, Credit Card = <?php echo $credit; ?>"
                                                        },
        <?php
    }
endfor;
?>
                                                ];</script>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
            </div>
            <!--Pie chart end-->


            <!--Pie chart start-->
            <div class="span6 well-white" style="margin-top:10px; margin-left:0px;">

                <div style="width:100%">
                    <h3 style="padding-left:30px; border-bottom:3px #666 solid;">Payout Datewise Report <?php ?> </h3>
                    <div id="canvas-holder" style="margin-left:auto; margin-right:auto; width:75%;">
                        <canvas id="chart-area_pie2" width="100%" height="100%"/>
                    </div>
                    <script>
                                var pieData2 = [
<?php
$param=49;
for ($h=0; $h <= 66; $h++):
    $param3=$param + 3;
    $param4=$param + 4;
    if ($input_status == 1) {
        $cashplus=$query[$param3][0]->price;
        $cashmin=$query[$param4][0]->price;
    }else {
        $cashplus=$query[$param3][0]->price;
        $cashmin=$query[$param4][0]->price;
    }
    $total=$cashplus + $cashmin;
    $param+=4;
    if ($h == 66) {
        ?>
                                        {
                                        value:<?php echo $total; ?>,
                                                color:"#<?php echo dechex(rand(0x010000, 0xFFF0FF)); ?>",
                                                highlight: "#<?php echo dechex(rand(0x000000, 0xFFFFFF)); ?>",
                                                label: "<?php echo makedate($h); ?> : (+) = <?php echo $cashplus; ?>, (-) = <?php echo $cashmin; ?>"
                                                            }
        <?php
    }else {
        ?>
                                                            {
                                                            value:<?php echo $total; ?>,
                                                                    color:"#<?php echo dechex(rand(0x010000, 0xFFF0FF)); ?>",
                                                                    highlight: "#<?php echo dechex(rand(0x000000, 0xFFFFFF)); ?>",
                                                                    label: "<?php echo makedate($h); ?> : (+) = <?php echo $cashplus; ?>, (-) = <?php echo $cashmin; ?>"
                                                                                },
        <?php
    }
endfor;
?>
                                                                        ];</script>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
            </div>
            <!--Pie chart end-->
            <!--bar chart start-->
            <div class="span6 well-white" style="margin-top:10px;">

                <div style="width:100%">
                    <h3 style="padding-left:30px; border-bottom:3px #666 solid;">Sales Report <div class="clearfix"></div><span style="font-size:18px;"><span style="background:rgba(134,179,0,1); width:20px; height:20px; display:inline-block;"></span> Sales Amount   <span style="background:rgba(151,187,205,0.5); width:20px; height:20px; display:inline-block;"></span> Sales Quantity  </span></h3>
                    <canvas id="canvas_sales" height="430" width="600"></canvas>

                    <script>
                                //var randomScalingFactor = function(){ return Math.round(Math.random()*100)};

                                var barChartData_sales = {
                                labels : ["<?php echo date('Y-m-d'); ?>",
<?php
for ($b=1; $b <= 15; $b++):
    if ($b == 15) {
        ?>"<?php echo makedate($b); ?>"<?php }else {
        ?>"<?php echo makedate($b); ?>",<?php
    }
endfor;
?>
                                ],
                                        datasets : [
                                        {
                                        fillColor : "rgba(134,179,0,1)",
                                                strokeColor : "rgba(134,179,0,0)",
                                                highlightFill: "rgba(134,179,0,1)",
                                                highlightStroke: "rgba(134,179,0,0)",
                                                data : [<?php
//if ($input_status == 1) {
//    $sqlinvoice=$obj->FlyQuery("SELECT s.date,IFNULL(SUM(s.totalcost),0) as totalcost FROM sales_list as s WHERE s.date='" . date('Y-m-d') . "'");
//}else {
//    $sqlinvoice=$obj->FlyQuery("SELECT s.input_by,s.date,IFNULL(SUM(s.totalcost),0) as totalcost FROM sales_list as s WHERE s.date='" . date('Y-m-d') . "' AND s.input_by='" . $input_by . "'");
//}
if (!empty($query[49])) {
    $pp=$query[49][0]->totalcost;
    echo $pp;
}else {
    echo $pp=0;
}
?>,<?php
$param=317;
for ($a=1; $a <= 15; $a++):
    $param+=$a;
    if ($a == 15) {
        if (!empty($query[$param])) {
            $pp=$query[$param][0]->totalcost;
            echo $pp;
        }else {
            echo $pp=0;
        }
    }else {
        if (!empty($query[$param])) {
            $pp=$query[$param][0]->totalcost;
            echo $pp;
        }else {
            echo $pp=0;
        }
        echo ",";
    }
endfor;
?>]
                                        },
                                        {
                                        fillCo lor : "rgba(151,187,205,0.5)",
                                                strokeColor : "rgba(151,187,205,0.8)",
                                                highlightFill : "rgba(151,187,205,0.75)",
                                                highlightStroke : "rgba(151,187,205,1)",
                                                data : [<?php
if (!empty($query[333])) {
    $pp=$query[333][0]->quantity;
    echo $pp;
}else {
    echo $pp=0;
}
?>,<?php
$param=333;
for ($a=1; $a <= 15; $a++):
    $param+=1;
    if ($a == 15) {
        if (!empty($query[$param])) {
            $pp=$query[$param][0]->quantity;
            echo $pp;
        }else {
            echo $pp=0;
        }
    }else {
        if (!empty($query[$param])) {
            $pp=$query[$param][0]->quantity;
            echo $pp;
        }else {
            echo $pp=0;
        }
        echo ",";
    }
endfor;
?>]
                                        }
                                        ]

                                }

                    </script><div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
            </div>
            <!--Bar chart end-->
            <div class="clearfix"></div>
            <!--bar chart start-->
            <div class="span12 well-white" style="margin-top:10px; margin-left:0;">

                <div style="width:100%">

                    <h3 style="padding-left:30px; border-bottom:3px #666 solid;">Store Closing Report </h3>
                    <div class="clearfix"></div>
                    <img style="position:absolute; right:0;" src="images/chart_store_close.png">
                    <canvas id="canvas_store_close" height="430" width="600"></canvas>

                    <script>
                        //var randomScalingFactor = function(){ return Math.round(Math.random()*100)};

                        var barChartData_store_close = {
                        labels : ["<?php echo date('Y-m-d'); ?>",
<?php
for ($b=1; $b <= 5; $b++):
    if ($b == 5) {
        ?>"<?php echo makedate($b); ?>"<?php }else {
        ?>"<?php echo makedate($b); ?>",<?php
    }
endfor;
?>
                        ],
                                datasets : [
                                {
                                fillColor : "rgba(134,179,0,1)",
                                        strokeColor : "rgba(134,179,0,0)",
                                        highlightFill: "rgba(134,179,0,1)",
                                        highlightStroke: "rgba(134,179,0,0)",
                                        data : [<?php
//if ($input_status == 1) {
//    $sqlinvoice=$obj->FlyQuery("SELECT s.date,IFNULL(SUM(s.total_collection_cash_credit_card),0) as total_collection_cash_credit_card FROM close_store_detail as s WHERE s.date='" . date('Y-m-d') . "'");
//}else {
//    $sqlinvoice=$obj->FlyQuery("SELECT s.store_id,s.date,IFNULL(SUM(s.total_collection_cash_credit_card),0) as total_collection_cash_credit_card FROM close_store_detail as s WHERE s.date='" . date('Y-m-d') . "' AND s.store_id='" . $input_by . "'");
//}
if (!empty($query[349])) {
    $pp=$query[349][0]->total_collection_cash_credit_card;
    echo $pp;
}else {
    echo $pp=0;
}
?>,<?php
$param=349;
for ($a=1; $a <= 5; $a++):
    $param+=$a;
    if ($a == 5) {
        if (!empty($query[$a])) {
            $pp=$query[$a][0]->total_collection_cash_credit_card;
            echo $pp;
        }else {
            echo $pp=0;
        }
    }else {
        if (!empty($query[$a])) {
            $pp=$query[$a][0]->total_collection_cash_credit_card;
            echo $pp;
        }else {
            echo $pp=0;
        }
        echo ",";
    }
endfor;
?>]
                                }, {
                                fillColor : "rgba(151,187,205,0.5)",
                                        strokeColor : "rgba(151,187,205,0.8)",
                                        highlightFill : "rgba(151,187,205,0.75)",
                                        highlightStroke : "rgba(151,187,205,1)",
                                        data : [<?php
//if ($input_status == 1) {
//    $sqlinvoice=$obj->FlyQuery("SELECT s.date,IFNULL(SUM(s.total_collection_cash_credit_card),0) as total_collection_cash_credit_card FROM close_store_detail as s WHERE s.date='" . date('Y-m-d') . "'");
//}else {
//    $sqlinvoice=$obj->FlyQuery("SELECT s.store_id,s.date,IFNULL(SUM(s.total_collection_cash_credit_card),0) as total_collection_cash_credit_card FROM close_store_detail as s WHERE s.date='" . date('Y-m-d') . "' AND s.store_id='" . $input_by . "'");
//}
if (!empty($query[355])) {
    $pp=$query[355][0]->total_collection_cash_credit_card;
    echo $pp;
}else {
    echo $pp=0;
}
?>,<?php
$param=355;
for ($a=1; $a <= 5; $a++):
    $param+=$a;
    if ($a == 5) {
        if (!empty($query[$param])) {
            $pp=$query[$param][0]->cash_collected_plus;
            echo $pp;
        }else {
            echo $pp=0;
        }
    }else {
        if (!empty($query[$param])) {
            $pp=$query[$param][0]->cash_collected_plus;
            echo $pp;
        }else {
            echo $pp=0;
        }
        echo ",";
    }
endfor;
?>]
                                }, {
                                fillColor : "rgba(255,197,120,1)",
                                        strokeColor : "rgba(255,197,120,1)",
                                        highlightFill : "rgba(255,197,120,1)",
                                        highlightStroke : "rgba(255,197,120,1)",
                                        data : [<?php
if ($input_status == 1) {
    $sqlinvoice=$obj->FlyQuery("SELECT s.date,IFNULL(SUM(s.credit_card_collected_plus),0) as credit_card_collected_plus FROM close_store_detail as s WHERE s.date='" . date('Y-m-d') . "'");
}else {
    $sqlinvoice=$obj->FlyQuery("SELECT s.store_id,s.date,IFNULL(SUM(s.credit_card_collected_plus),0) as credit_card_collected_plus FROM close_store_detail as s WHERE s.date='" . date('Y-m-d') . "' AND s.store_id='" . $input_by . "'");
}
if (!empty($sqlinvoice)) {
    $pp=$sqlinvoice[0]->credit_card_collected_plus;
    echo $pp;
}else {
    echo $pp=0;
}
?>,<?php
for ($a=1; $a <= 5; $a++):
    if ($a == 5) {

        if ($input_status == 1) {
            $sqlinvoice=$obj->FlyQuery("SELECT s.date,IFNULL(SUM(s.credit_card_collected_plus),0) as credit_card_collected_plus FROM close_store_detail as s WHERE s.date='" . makedate($a) . "'");
        }else {
            $sqlinvoice=$obj->FlyQuery("SELECT s.store_id,s.date,IFNULL(SUM(s.credit_card_collected_plus),0) as credit_card_collected_plus FROM close_store_detail as s WHERE s.date='" . makedate($a) . "' AND s.store_id='" . $input_by . "'");
        }
        if (!empty($sqlinvoice)) {
            $pp=$sqlinvoice[0]->credit_card_collected_plus;
            echo $pp;
        }else {
            echo $pp=0;
        }
    }else {
        if ($input_status == 1) {
            $sqlinvoice=$obj->FlyQuery("SELECT s.date,IFNULL(SUM(s.credit_card_collected_plus),0) as credit_card_collected_plus FROM close_store_detail as s WHERE s.date='" . makedate($a) . "'");
        }else {
            $sqlinvoice=$obj->FlyQuery("SELECT s.store_id,s.date,IFNULL(SUM(s.credit_card_collected_plus),0) as credit_card_collected_plus FROM close_store_detail as s WHERE s.date='" . makedate($a) . "' AND s.store_id='" . $input_by . "'");
        }
        if (!empty($sqlinvoice)) {
            $pp=$sqlinvoice[0]->credit_card_collected_plus;
            echo $pp;
        }else {
            echo $pp=0;
        }


        echo ",";
    }
endfor;
?>]
                                }
                                , {
                                fillColor : "rgba(73,155,234,1)",
                                        strokeColor : "rgba(73,155,234,1)",
                                        highlightFill : "rgba(73,155,234,1)",
                                        highlightStroke : "rgba(73,155,234,1)",
                                        data : [<?php
if ($input_status == 1) {
    $sqlinvoice=$obj->FlyQuery("SELECT s.date,IFNULL(SUM(s.opening_cash_plus),0) as opening_cash_plus FROM close_store_detail as s WHERE s.date='" . date('Y-m-d') . "'");
}else {
    $sqlinvoice=$obj->FlyQuery("SELECT s.store_id,s.date,IFNULL(SUM(s.opening_cash_plus),0) as opening_cash_plus FROM close_store_detail as s WHERE s.date='" . date('Y-m-d') . "' AND s.store_id='" . $input_by . "'");
}
if (!empty($sqlinvoice)) {
    $pp=$sqlinvoice[0]->opening_cash_plus;
    echo $pp;
}else {
    echo $pp=0;
}
?>,<?php
for ($a=1; $a <= 5; $a++):
    if ($a == 5) {
        if ($input_status == 1) {
            $sqlinvoice=$obj->FlyQuery("SELECT s.date,IFNULL(SUM(s.opening_cash_plus),0) as opening_cash_plus FROM close_store_detail as s WHERE s.date='" . makedate($a) . "'");
        }else {
            $sqlinvoice=$obj->FlyQuery("SELECT s.store_id,s.date,IFNULL(SUM(s.opening_cash_plus),0) as opening_cash_plus FROM close_store_detail as s WHERE s.date='" . makedate($a) . "' AND s.store_id='" . $input_by . "'");
        }
        if (!empty($sqlinvoice)) {
            $pp=$sqlinvoice[0]->opening_cash_plus;
            echo $pp;
        }else {
            echo $pp=0;
        }
    }else {
        if ($input_status == 1) {
            $sqlinvoice=$obj->FlyQuery("SELECT s.date,IFNULL(SUM(s.opening_cash_plus),0) as opening_cash_plus FROM close_store_detail as s WHERE s.date='" . makedate($a) . "'");
        }else {
            $sqlinvoice=$obj->FlyQuery("SELECT s.store_id,s.date,IFNULL(SUM(s.opening_cash_plus),0) as opening_cash_plus FROM close_store_detail as s WHERE s.date='" . makedate($a) . "' AND s.store_id='" . $input_by . "'");
        }
        if (!empty($sqlinvoice)) {
            $pp=$sqlinvoice[0]->opening_cash_plus;
            echo $pp;
        }else {
            echo $pp=0;
        }
        echo ",";
    }
endfor;
?>]
                                }
                                , {
                                fillColor : "rgba(229,112,231,1)",
                                        strokeColor : "rgba(229,112,231,1)",
                                        highlightFill : "rgba(229,112,231,1)",
                                        highlightStroke : "rgba(229,112,231,1)",
                                        data : [<?php
if ($input_status == 1) {
    $sqlinvoice=$obj->FlyQuery("SELECT s.date,IFNULL(SUM(s.opening_credit_card_plus),0) as opening_credit_card_plus FROM close_store_detail as s WHERE s.date='" . date('Y-m-d') . "'");
}else {
    $sqlinvoice=$obj->FlyQuery("SELECT s.store_id,s.date,IFNULL(SUM(s.opening_credit_card_plus),0) as opening_credit_card_plus FROM close_store_detail as s WHERE s.date='" . date('Y-m-d') . "' AND s.store_id='" . $input_by . "'");
}
if (!empty($sqlinvoice)) {
    $pp=$sqlinvoice[0]->opening_credit_card_plus;
    echo $pp;
}else {
    echo $pp=0;
}
?>,<?php
for ($a=1; $a <= 5; $a++):
    if ($a == 5) {
        if ($input_status == 1) {
            $sqlinvoice=$obj->FlyQuery("SELECT s.date,IFNULL(SUM(s.opening_credit_card_plus),0) as opening_credit_card_plus FROM close_store_detail as s WHERE s.date='" . makedate($a) . "'");
        }else {
            $sqlinvoice=$obj->FlyQuery("SELECT s.store_id,s.date,IFNULL(SUM(s.opening_credit_card_plus),0) as opening_credit_card_plus FROM close_store_detail as s WHERE s.date='" . makedate($a) . "' AND s.store_id='" . $input_by . "'");
        }
        if (!empty($sqlinvoice)) {
            $pp=$sqlinvoice[0]->opening_cash_plus;
            echo $pp;
        }else {
            echo $pp=0;
        }
    }else {
        if ($input_status == 1) {
            $sqlinvoice=$obj->FlyQuery("SELECT s.date,IFNULL(SUM(s.opening_credit_card_plus),0) as opening_credit_card_plus FROM close_store_detail as s WHERE s.date='" . makedate($a) . "'");
        }else {
            $sqlinvoice=$obj->FlyQuery("SELECT s.store_id,s.date,IFNULL(SUM(s.opening_credit_card_plus),0) as opening_credit_card_plus FROM close_store_detail as s WHERE s.date='" . makedate($a) . "' AND s.store_id='" . $input_by . "'");
        }
        if (!empty($sqlinvoice)) {
            $pp=$sqlinvoice[0]->opening_cash_plus;
            echo $pp;
        }else {
            echo $pp=0;
        }

        echo ",";
    }
endfor;
?>]
                                }
                                , {
                                fillColor : "rgba(169,3,41,1)",
                                        strokeColor : "rgba(169,3,41,1)",
                                        highlightFill : "rgba(169,3,41,1)",
                                        highlightStroke : "rgba(169,3,41,1)",
                                        data : [<?php
if ($input_status == 1) {
    $sqlinvoice=$obj->FlyQuery("SELECT s.date,IFNULL(SUM(s.payout_plus_min),0) as payout_plus_min FROM close_store_detail as s WHERE s.date='" . date('Y-m-d') . "'");
}else {
    $sqlinvoice=$obj->FlyQuery("SELECT s.store_id,s.date,IFNULL(SUM(s.payout_plus_min),0) as payout_plus_min FROM close_store_detail as s WHERE s.date='" . date('Y-m-d') . "' AND s.store_id='" . $input_by . "'");
}
if (!empty($sqlinvoice)) {
    $pp=$sqlinvoice[0]->payout_plus_min;
    echo $pp;
}else {
    echo $pp=0;
}
?>,<?php
for ($a=1; $a <= 5; $a++):
    if ($a == 5) {


        if ($input_status == 1) {
            $sqlinvoice=$obj->FlyQuery("SELECT s.date,IFNULL(SUM(s.payout_plus_min),0) as payout_plus_min FROM close_store_detail as s WHERE s.date='" . makedate($a) . "'");
        }else {
            $sqlinvoice=$obj->FlyQuery("SELECT s.store_id,s.date,IFNULL(SUM(s.payout_plus_min),0) as payout_plus_min FROM close_store_detail as s WHERE s.date='" . makedate($a) . "' AND s.store_id='" . $input_by . "'");
        }
        if (!empty($sqlinvoice)) {
            $pp=$sqlinvoice[0]->payout_plus_min;
            echo $pp;
        }else {
            echo $pp=0;
        }
    }else {
        if ($input_status == 1) {
            $sqlinvoice=$obj->FlyQuery("SELECT s.date,IFNULL(SUM(s.payout_plus_min),0) as payout_plus_min FROM close_store_detail as s WHERE s.date='" . makedate($a) . "'");
        }else {
            $sqlinvoice=$obj->FlyQuery("SELECT s.store_id,s.date,IFNULL(SUM(s.payout_plus_min),0) as payout_plus_min FROM close_store_detail as s WHERE s.date='" . makedate($a) . "' AND s.store_id='" . $input_by . "'");
        }
        if (!empty($sqlinvoice)) {
            $pp=$sqlinvoice[0]->payout_plus_min;
            echo $pp;
        }else {
            echo $pp=0;
        }
        echo ",";
    }
endfor;
?>]
                                }
                                , {
                                fillColor : "rgba(255,255,136,1)",
                                        strokeColor : "rgba(255,255,136,1)",
                                        highlightFill : "rgba(255,255,136,1)",
                                        highlightStroke : "rgba(255,255,136,1)",
                                        data : [<?php
if ($input_status == 1) {
    $sqlinvoice=$obj->FlyQuery("SELECT s.date,IFNULL(SUM(s.buyback_min),0) as buyback_min FROM close_store_detail as s WHERE s.date='" . date('Y-m-d') . "'");
}else {
    $sqlinvoice=$obj->FlyQuery("SELECT s.store_id,s.date,IFNULL(SUM(s.buyback_min),0) as buyback_min FROM close_store_detail as s WHERE s.date='" . date('Y-m-d') . "' AND s.store_id='" . $input_by . "'");
}
if (!empty($sqlinvoice)) {
    $pp=$sqlinvoice[0]->buyback_min;
    echo $pp;
}else {
    echo $pp=0;
}
?>,<?php
for ($a=1; $a <= 5; $a++):
    if ($a == 5) {
        if ($input_status == 1) {
            $sqlinvoice=$obj->FlyQuery("SELECT s.date,IFNULL(SUM(s.buyback_min),0) as payout_plus_min FROM close_store_detail as s WHERE s.date='" . makedate($a) . "'");
        }else {
            $sqlinvoice=$obj->FlyQuery("SELECT s.store_id,s.date,IFNULL(SUM(s.buyback_min),0) as payout_plus_min FROM close_store_detail as s WHERE s.date='" . makedate($a) . "' AND s.store_id='" . $input_by . "'");
        }
        if (!empty($sqlinvoice)) {
            $pp=$sqlinvoice[0]->buyback_min;
            echo $pp;
        }else {
            echo $pp=0;
        }
    }else {
        if ($input_status == 1) {
            $sqlinvoice=$obj->FlyQuery("SELECT s.date,IFNULL(SUM(s.buyback_min),0) as buyback_min FROM close_store_detail as s WHERE s.date='" . makedate($a) . "'");
        }else {
            $sqlinvoice=$obj->FlyQuery("SELECT s.store_id,s.date,IFNULL(SUM(s.buyback_min),0) as buyback_min FROM close_store_detail as s WHERE s.date='" . makedate($a) . "' AND s.store_id='" . $input_by . "'");
        }
        if (!empty($sqlinvoice)) {
            $pp=$sqlinvoice[0]->buyback_min;
            echo $pp;
        }else {
            echo $pp=0;
        }
        echo ",";
    }
endfor;
?>]
                                }
                                , {
                                fillColor : "rgba(69,72,77,1)",
                                        strokeColor : "rgba(69,72,77,1)",
                                        highlightFill : "rgba(69,72,77,1)",
                                        highlightStroke : "rgba(69,72,77,1)",
                                        data : [<?php
if ($input_status == 1) {
    $sqlinvoice=$obj->FlyQuery("SELECT s.date,IFNULL(SUM(s.tax_min),0) as tax_min FROM close_store_detail as s WHERE s.date='" . date('Y-m-d') . "'");
}else {
    $sqlinvoice=$obj->FlyQuery("SELECT s.store_id,s.date,IFNULL(SUM(s.tax_min),0) as tax_min FROM close_store_detail as s WHERE s.date='" . date('Y-m-d') . "' AND s.store_id='" . $input_by . "'");
}
if (!empty($sqlinvoice)) {
    $pp=$sqlinvoice[0]->tax_min;
    echo $pp;
}else {
    echo $pp=0;
}
?>,<?php
for ($a=1; $a <= 5; $a++):
    if ($a == 5) {
        if ($input_status == 1) {
            $sqlinvoice=$obj->FlyQuery("SELECT s.date,IFNULL(SUM(s.tax_min),0) as tax_min FROM close_store_detail as s WHERE s.date='" . makedate($a) . "'");
        }else {
            $sqlinvoice=$obj->FlyQuery("SELECT s.store_id,s.date,IFNULL(SUM(s.tax_min),0) as tax_min FROM close_store_detail as s WHERE s.date='" . makedate($a) . "' AND s.store_id='" . $input_by . "'");
        }
        if (!empty($sqlinvoice)) {
            $pp=$sqlinvoice[0]->tax_min;
            echo $pp;
        }else {
            echo $pp=0;
        }
    }else {
        if ($input_status == 1) {
            $sqlinvoice=$obj->FlyQuery("SELECT s.date,IFNULL(SUM(s.tax_min),0) as tax_min FROM close_store_detail as s WHERE s.date='" . makedate($a) . "'");
        }else {
            $sqlinvoice=$obj->FlyQuery("SELECT s.store_id,s.date,IFNULL(SUM(s.tax_min),0) as tax_min FROM close_store_detail as s WHERE s.date='" . makedate($a) . "' AND s.store_id='" . $input_by . "'");
        }
        if (!empty($sqlinvoice)) {
            $pp=$sqlinvoice[0]->tax_min;
            echo $pp;
        }else {
            echo $pp=0;
        }

        echo ",";
    }
endfor;
?>]
                                }
                                , {
                                fillColor : "rgba(180,227,145,1)",
                                        strokeColor : "rgba(180,227,145,1)",
                                        highlightFill : "rgba(180,227,145,1)",
                                        highlightStroke : "rgba(180,227,145,1)",
                                        data : [<?php
if ($input_status == 1) {
    $sqlinvoice=$obj->FlyQuery("SELECT s.date,IFNULL(SUM(s.current_cash),0) as current_cash FROM close_store_detail as s WHERE s.date='" . date('Y-m-d') . "'");
}else {
    $sqlinvoice=$obj->FlyQuery("SELECT s.store_id,s.date,IFNULL(SUM(s.current_cash),0) as current_cash FROM close_store_detail as s WHERE s.date='" . date('Y-m-d') . "' AND s.store_id='" . $input_by . "'");
}
if (!empty($sqlinvoice)) {
    $pp=$sqlinvoice[0]->current_cash;
    echo $pp;
}else {
    echo $pp=0;
}
?>,<?php
for ($a=1; $a <= 5; $a++):
    if ($a == 5) {

        if ($input_status == 1) {
            $sqlinvoice=$obj->FlyQuery("SELECT s.date,IFNULL(SUM(s.current_cash),0) as current_cash FROM close_store_detail as s WHERE s.date='" . makedate($a) . "'");
        }else {
            $sqlinvoice=$obj->FlyQuery("SELECT s.store_id,s.date,IFNULL(SUM(s.current_cash),0) as current_cash FROM close_store_detail as s WHERE s.date='" . makedate($a) . "' AND s.store_id='" . $input_by . "'");
        }
        if (!empty($sqlinvoice)) {
            $pp=$sqlinvoice[0]->current_cash;
            echo $pp;
        }else {
            echo $pp=0;
        }
    }else {
        if ($input_status == 1) {
            $sqlinvoice=$obj->FlyQuery("SELECT s.date,IFNULL(SUM(s.current_cash),0) as current_cash FROM close_store_detail as s WHERE s.date='" . makedate($a) . "'");
        }else {
            $sqlinvoice=$obj->FlyQuery("SELECT s.store_id,s.date,IFNULL(SUM(s.current_cash),0) as current_cash FROM close_store_detail as s WHERE s.date='" . makedate($a) . "' AND s.store_id='" . $input_by . "'");
        }
        if (!empty($sqlinvoice)) {
            $pp=$sqlinvoice[0]->current_cash;
            echo $pp;
        }else {
            echo $pp=0;
        }
        echo ",";
    }
endfor;
?>]
                                }
                                , {
                                fillColor : "rgba(255,26,0,1)",
                                        strokeColor : "rgba(255,26,0,1)",
                                        highlightFill : "rgba(255,26,0,1)",
                                        highlightStroke : "rgba(255,26,0,1)",
                                        data : [<?php
if ($input_status == 1) {
    $sqlinvoice=$obj->FlyQuery("SELECT s.date,IFNULL(SUM(s.current_credit_card),0) as current_credit_card FROM close_store_detail as s WHERE s.date='" . date('Y-m-d') . "'");
}else {
    $sqlinvoice=$obj->FlyQuery("SELECT s.store_id,s.date,IFNULL(SUM(s.current_credit_card),0) as current_credit_card FROM close_store_detail as s WHERE s.date='" . date('Y-m-d') . "' AND s.store_id='" . $input_by . "'");
}
if (!empty($sqlinvoice)) {
    $pp=$sqlinvoice[0]->current_credit_card;
    echo $pp;
}else {
    echo $pp=0;
}
?>,<?php
for ($a=1; $a <= 5; $a++):
    if ($a == 5) {

        if ($input_status == 1) {
            $sqlinvoice=$obj->FlyQuery("SELECT s.date,IFNULL(SUM(s.current_credit_card),0) as current_credit_card FROM close_store_detail as s WHERE s.date='" . makedate($a) . "'");
        }else {
            $sqlinvoice=$obj->FlyQuery("SELECT s.store_id,s.date,IFNULL(SUM(s.current_credit_card),0) as current_credit_card FROM close_store_detail as s WHERE s.date='" . makedate($a) . "' AND s.store_id='" . $input_by . "'");
        }
        if (!empty($sqlinvoice)) {
            $pp=$sqlinvoice[0]->current_credit_card;
            echo $pp;
        }else {
            echo $pp=0;
        }
    }else {

        if ($input_status == 1) {
            $sqlinvoice=$obj->FlyQuery("SELECT s.date,IFNULL(SUM(s.current_credit_card),0) as current_credit_card FROM close_store_detail as s WHERE s.date='" . makedate($a) . "'");
        }else {
            $sqlinvoice=$obj->FlyQuery("SELECT s.store_id,s.date,IFNULL(SUM(s.current_credit_card),0) as current_credit_card FROM close_store_detail as s WHERE s.date='" . makedate($a) . "' AND s.store_id='" . $input_by . "'");
        }
        if (!empty($sqlinvoice)) {
            $pp=$sqlinvoice[0]->current_credit_card;
            echo $pp;
        }else {
            echo $pp=0;
        }
        echo ",";
    }
endfor;
?>]
                                }
                                , {
                                fillColor : "rgba(98,125,77,1)",
                                        strokeColor : "rgba(98,125,77,1)",
                                        highlightFill : "rgba(98,125,77,1)",
                                        highlightStroke : "rgba(98,125,77,1)",
                                        data : [<?php
if ($input_status == 1) {
    $sqlinvoice=$obj->FlyQuery("SELECT s.date,IFNULL(SUM(s.current_total),0) as current_total FROM close_store_detail as s WHERE s.date='" . date('Y-m-d') . "'");
}else {
    $sqlinvoice=$obj->FlyQuery("SELECT s.store_id,s.date,IFNULL(SUM(s.current_total),0) as current_total FROM close_store_detail as s WHERE s.date='" . date('Y-m-d') . "' AND s.store_id='" . $input_by . "'");
}
if (!empty($sqlinvoice)) {
    $pp=$sqlinvoice[0]->current_total;
    echo $pp;
}else {
    echo $pp=0;
}
?>,<?php
for ($a=1; $a <= 5; $a++):
    if ($a == 5) {

        if ($input_status == 1) {
            $sqlinvoice=$obj->FlyQuery("SELECT s.date,IFNULL(SUM(s.current_total),0) as current_total FROM close_store_detail as s WHERE s.date='" . makedate($a) . "'");
        }else {
            $sqlinvoice=$obj->FlyQuery("SELECT s.store_id,s.date,IFNULL(SUM(s.current_total),0) as current_total FROM close_store_detail as s WHERE s.date='" . makedate($a) . "' AND s.store_id='" . $input_by . "'");
        }
        if (!empty($sqlinvoice)) {
            $pp=$sqlinvoice[0]->current_total;
            echo $pp;
        }else {
            echo $pp=0;
        }
    }else {
        if ($input_status == 1) {
            $sqlinvoice=$obj->FlyQuery("SELECT s.date,IFNULL(SUM(s.current_total),0) as current_total FROM close_store_detail as s WHERE s.date='" . makedate($a) . "'");
        }else {
            $sqlinvoice=$obj->FlyQuery("SELECT s.store_id,s.date,IFNULL(SUM(s.current_total),0) as current_total FROM close_store_detail as s WHERE s.date='" . makedate($a) . "' AND s.store_id='" . $input_by . "'");
        }
        if (!empty($sqlinvoice)) {
            $pp=$sqlinvoice[0]->current_total;
            echo $pp;
        }else {
            echo $pp=0;
        }
        echo ",";
    }
endfor;
?>]
                                }
                                ]

                        }
                    </script><div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
            </div>
            <!--Bar chart end-->






            <script>
                window.onload = function()
                {
                var ctx = document.getElementById("canvas").getContext("2d");
                        window.myBar = new Chart(ctx).Bar(barChartData, { responsive : true });
                        var ctxx = document.getElementById("chart-areas").getContext("2d"); window.myDoughnut = new Chart(ctxx).Doughnut(doughnutData, {responsive : true});
                        var ctx_line = document.getElementById("canvas_line").getContext("2d");
                        window.myLine = new Chart(ctx_line).Line(lineChartData, { responsive: true });
                        var ctx_pie = document.getElementById("chart-area_pie").getContext("2d");
                        window.myPie = new Chart(ctx_pie).Pie(pieData, { responsive : true });
                        var ctx_pie2 = document.getElementById("chart-area_pie2").getContext("2d");
                        window.myPie = new Chart(ctx_pie2).Pie(pieData2, { responsive : true });
                        var ctx_sales = document.getElementById("canvas_sales").getContext("2d");
                        window.myBar = new Chart(ctx_sales).Bar(barChartData_sales, { responsive : true });
                        var ctx_store_close = document.getElementById("canvas_store_close").getContext("2d");
                        window.myBar = new Chart(ctx_store_close).Bar(barChartData_store_close, { responsive : true });
                }
            </script>
        </div>
    </div>


</div>
<?php ?>
<div class="separator-doubled"></div>