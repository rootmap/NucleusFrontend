<?php

include '../class/auth.php';
header("Content-type: application/json");
$verb = $_SERVER["REQUEST_METHOD"];
$table = "payout";
if ($verb == "GET") {
    if (isset($_GET['filter'])) {
        $filter_result = array();
        $filter_data = $_GET["filter"];
        $pagesize = $_GET['pageSize'];
        $start = $_GET['skip'];
        $filtercount = count($_GET["filter"]['filters']);
        $confilter = '';
        include '../plugin/plugin.php';
        $plugin = new CmsRootPlugin();
        $cond = $plugin->BackEndDateSearch('from', 'to', 'date', 'p.', ' WHERE ');

        if (empty($cond)) {
            $cond = " WHERE ";
        }

        if ($input_status == 1) {
            for ($i = 0; $i <= $filtercount - 1; $i++):
                if ($i == 0) {
                    $confilter = $plugin->KendoFilter($filter_data, "AllKenduData.", $i);
                } else {
                    $confilter .=" AND " . $plugin->KendoFilter($filter_data, "AllKenduData.", $i);
                }
            endfor;

            $migratecond = $cond;
        } elseif ($input_status == 5) {
            $sqlchain_store_ids = $obj->FlyQuery("SELECT sid,store_id FROM store_chain_admin WHERE sid='" . $input_by . "'");
            if (!empty($sqlchain_store_ids)) {

                $inner_cond = ' AND (';
                $i = 1;
                foreach ($sqlchain_store_ids as $ch):
                    if ($i == 1) {
                        $inner_cond = "s.`input_by`='" . $ch->store_id . "'";
                    } else {
                        $inner_cond = " OR s.`input_by`='" . $ch->store_id . "'";
                    }
                    $i++;
                endforeach;
                $inner_cond .=')';



                for ($i = 0; $i <= $filtercount - 1; $i++):
                    if ($i == 0) {
                        $confilter = $plugin->KendoFilter($filter_data, "AllKenduData.", $i);
                    } else {
                        $confilter .=" AND " . $plugin->KendoFilter($filter_data, "AllKenduData.", $i);
                    }
                endfor;

                $migratecond = $cond . $inner_cond;
            } else {
                $confilter = '';
                $migratecond = " WHERE ur.id='0' ";
            }
        } else {

            $confilter = '';
            for ($i = 0; $i <= $filtercount - 1; $i++):
                if ($i == 0) {
                    $confilter = $plugin->KendoFilter($filter_data, "AllKenduData.", $i);
                } else {
                    $confilter .=" AND " . $plugin->KendoFilter($filter_data, "AllKenduData.", $i);
                }
            endfor;

            $migratecond = $cond;
        }


        $sqlpar = "SELECT 
                s.`id` ,
                s.`cashier_id`,
                s.`sales_id`,
                s.`pid`,
                p.name as product_name,
                s.`quantity`,
                s.`single_cost`,
                p.price_cost,
                (p.price_cost*s.`quantity`) as `our_total_cost`,
                s.`totalcost`,
                (s.`totalcost`-(p.price_cost*s.`quantity`)) as `profit`,
                s.`input_by`,
                (SELECT ss.name FROM store as ss WHERE ss.store_id=p.input_by AND ss.status='2') as store_name,
                s.`date`
                FROM `sales` as s 
                INNER JOIN product as p ON p.id=s.pid 
                " . $migratecond . " 
                ORDER BY s.id DESC LIMIT $start,$pagesize";


        /*
         * 
         * Introduce New Table 
         * CREATE TABLE IF NOT EXISTS `sold_salvage` (
          `id` int(20) AUTO_INCREMENT PRIMARY KEY,
          `sales_id` int(20)
          )

         * Introducce new field in            */

        $sqlpars = "SELECT 
                    s.`id` ,
                    s.`cashier_id`,
                    s.`sales_id`,
                    s.`pid`,
                    p.name as product_name,
                    s.`quantity`,
                    s.`single_cost`,
                    p.price_cost,
                    (p.price_cost*s.`quantity`) as `our_total_cost`,
                    s.`totalcost`,
                    (s.`totalcost`-(p.price_cost*s.`quantity`)) as `profit`,
                    s.`input_by`,
                    (SELECT ss.name FROM store as ss WHERE ss.store_id=p.input_by AND ss.status='2') as store_name,
                    s.`date`
                    FROM `sales` as s 
                    INNER JOIN product as p ON p.id=s.pid 
                    " . $migratecond . " 
                    ORDER BY s.id DESC";

        $sqlparamgen = $plugin->KenduFilterParam($sqlpar, $confilter);
        $filter_result = $obj->FlyQuery($sqlparamgen);
        $total_in_filter = $obj->FlyQuery($plugin->KenduFilterParam($sqlpars, $confilter), "1");


        if ($total_in_filter >= 1) {
            echo "{\"data\":" . json_encode($filter_result) . ",\"total\":" . $total_in_filter . "}";
        } else {
            echo "{\"data\":" . "[]" . ",\"total\":" . $total_in_filter . "}";
        }
        //print_r($_GET);
        exit();
    } else {
        $pagesize = $_GET['pageSize'];
        $start = $_GET['skip'];
        include '../plugin/plugin.php';
        $plugin = new CmsRootPlugin();
        $cond = $plugin->BackEndDateSearch('from', 'to', 'date', 'p.', ' WHERE ');

        if (empty($cond)) {
            if ($input_status != 1) {
                $cond = " WHERE ";
            }
        }

        if ($input_status == 1) {
            $migratecond = $cond;
        } elseif ($input_status == 5) {

            $sqlchain_store_ids = $obj->SelectAllByID("store_chain_admin", array("sid" => $input_by));
            if (!empty($sqlchain_store_ids)) {

                $inner_cond = ' AND (';
                $i = 1;
                foreach ($sqlchain_store_ids as $ch):
                    if ($i == 1) {
                        $inner_cond .= "s.`input_by`='" . $ch->store_id . "'";
                    } else {
                        $inner_cond .= " OR s.`input_by`='" . $ch->store_id . "'";
                    }
                    $i++;
                endforeach;
                $inner_cond .=')';

                $migratecond = $cond . $inner_cond;


                //echo "Work";
            } else {
                //echo "Not Work";
                $migratecond = " WHERE a.id='0'";
            }
        } else {

            $newcond = " s.`input_by`='" . $input_by . "'";
            $migratecond = $cond . $newcond;
        }



        $sql_coustomer = $obj->FlyQuery("SELECT 
                                        s.`id` ,
                                        s.`cashier_id`,
                                        s.`sales_id`,
                                        s.`pid`,
                                        p.name as product_name,
                                        s.`quantity`,
                                        s.`single_cost`,
                                        p.price_cost,
                                        (p.price_cost*s.`quantity`) as `our_total_cost`,
                                        s.`totalcost`,
                                        (s.`totalcost`-(p.price_cost*s.`quantity`)) as `profit`,
                                        s.`input_by`,
                                        (SELECT ss.name FROM store as ss WHERE ss.store_id=p.input_by AND ss.status='2') as store_name,
                                        s.`date`
                                        FROM `sales` as s 
                                        INNER JOIN product as p ON p.id=s.pid 
                                        " . $migratecond . " 
                                        ORDER BY s.id DESC LIMIT $start,$pagesize");





        $totalrows = $obj->FlyQuery("SELECT 
                                    s.`id` ,
                                    s.`cashier_id`,
                                    s.`sales_id`,
                                    s.`pid`,
                                    p.name as product_name,
                                    s.`quantity`,
                                    s.`single_cost`,
                                    p.price_cost,
                                    (p.price_cost*s.`quantity`) as `our_total_cost`,
                                    s.`totalcost`,
                                    (s.`totalcost`-(p.price_cost*s.`quantity`)) as `profit`,
                                    s.`input_by`,
                                    (SELECT ss.name FROM store as ss WHERE ss.store_id=p.input_by AND ss.status='2') as store_name,
                                    s.`date`
                                    FROM `sales` as s 
                                    INNER JOIN product as p ON p.id=s.pid 
                                    " . $migratecond . " 
                                    ORDER BY s.id DESC", 1);

        if (empty($migratecond)) {
            $migrateconds = " WHERE s.date>='".date('Y-m') . "-1' AND s.date<='date('Y-m-d')'";
        } else {
            $migrateconds=$migratecond." AND s.date>='".date('Y-m') . "-1' AND s.date<='date('Y-m-d')'";
        }


        $sqltrend = $obj->FlyQuery("SELECT 
                                    s.`id` ,
                                    (p.price_cost*s.`quantity`) as `our_total_cost`,
                                    s.`totalcost`,
                                    IFNULL((SELECT IFNULL((SELECT salvage_part FROM checkin_request_ticket as crt WHERE crt.checkin_id=pc.checkin_id LIMIT 1),0) AS salvage_part FROM pos_checkin as pc WHERE pc.invoice_id=s.sales_id LIMIT 1),0) AS salvage_part
                                    FROM `sales` as s 
                                    " . $migrateconds . " 
                                    ORDER BY s.id DESC");

        $fff = 0;
        $asiftodayprofit = 0;
        if (!empty($sqltrend)) {

            foreach ($sqltrend as $trend):
                if ($trend->salvage_part == 1) {
                    $fff = 0;
                } else {
                    $fff = $trend->our_total_cost;
                }
                $aitp = $trend->totalcost - $fff;
                $asiftodayprofit+=$aitp;
            endforeach;
        }

        @$individual_day_profit = $asiftodayprofit / date('d');
        $month = date('m');
        $year = date('Y');
        $d = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        @$summerizethismonthprofittotal = $individual_day_profit * $d;


        $tenpr = '';

        $tenpr .='<div class="block well span12">
                                        <div class="navbar">
                                            <div class="navbar-inner">
                                                <h5> Trend To (<storng><font color="#09f">' . date('F') . '</font></storng>) Profit Report</h5>
                                            </div>
                                        </div>
                                        <div class="table-overflow">
                                            <table class="table table-condensed table-bordered">
                                                <tbody>
                                                    <tr>
                                                        <td>1. As if today this (<storng><font color="#09f">' . date('F') . '</font></storng>) profit = </td><td><strong>' . $currencyicon . @number_format($asiftodayprofit, 2) . '</strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td>2. Individual day profit = </td><td><strong>' . $currencyicon . @number_format($individual_day_profit, 2) . '</strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td>3. Profit become End of month = </td><td><strong>' . $currencyicon . @number_format($summerizethismonthprofittotal, 2) . '</strong></td>
                                                    </tr>


                                                </tbody>
                                            </table>
                                        </div>
                                    </div>';


        $sqlCity = $sql_coustomer;
        //$totalrows = $obj->totalrows($table);
        echo "{\"data\":" . json_encode($sqlCity) . ",\"total\":" . $totalrows . ",\"trend\":". json_encode($tenpr) . "}";
    }
}
?>
