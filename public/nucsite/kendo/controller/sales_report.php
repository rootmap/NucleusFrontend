<?php

include '../class/auth.php';
header("Content-type: application/json");
$verb = $_SERVER["REQUEST_METHOD"];
$table = "product";
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
        $cond = $plugin->BackEndDateSearch('from', 'to', 'date', 'i.', ' AND ');
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
                        $inner_cond = "`i`.`input_by`='" . $ch->store_id . "'";
                    } else {
                        $inner_cond = " OR `i`.`input_by`='" . $ch->store_id . "'";
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

        if (isset($_GET['report_cid'])) {
            if (!empty($migratecond)) {
                $migratecond .=" AND i.cid='".$_GET['report_cid']."'";
            } else {
                $migratecond .=" AND i.cid='".$_GET['report_cid']."'";
            }
        }

        $sqlpar = "SELECT 
        i.id, 
        i.invoice_id, 
        i.cid, 
        CASE (SELECT ip.payment_type FROM invoice_payment as ip WHERE ip.invoice_id=i.invoice_id LIMIT 1)
        WHEN 0 THEN 0 
        ELSE (SELECT pm.meth_name FROM payment_method as pm WHERE pm.id=(SELECT ip.payment_type FROM invoice_payment as ip WHERE ip.invoice_id=i.invoice_id LIMIT 1) LIMIT 1)
        END
        as pty,
        CASE (SELECT count(s.quantity) FROM sales as s WHERE s.sales_id=i.invoice_id GROUP BY i.invoice_id) 
        WHEN 0 THEN 0 
        ELSE 
        CASE (SELECT pt.status FROM pos_tax as pt WHERE pt.invoice_id=i.invoice_id LIMIT 1)  
        WHEN 0 THEN 
        (SELECT SUM(s.single_cost*s.quantity) FROM sales as s WHERE s.sales_id=i.invoice_id GROUP BY i.invoice_id) 
        ELSE
        (((((SELECT SUM(s.single_cost*s.quantity) FROM sales as s WHERE s.sales_id=i.invoice_id GROUP BY i.invoice_id)) * 1)/100)+((SELECT SUM(s.single_cost*s.quantity) FROM sales as s WHERE s.sales_id=i.invoice_id GROUP BY i.invoice_id)))
        END
        END
        as sales_amount,
        (SELECT SUM(s.quantity) FROM sales as s WHERE s.sales_id=i.invoice_id GROUP BY i.invoice_id) as quantity,
        (SELECT SUM(amount) FROM invoice_payment as ip WHERE ip.invoice_id=i.invoice_id GROUP BY i.invoice_id) as paid_amount,
        (SELECT concat(c.firstname,' ',c.lastname,' - ',c.businessname) FROM coustomer as c WHERE c.id=i.cid) as customer,
        i.date, 
        i.status, 
        i.doc_type, 
        i.input_by, 
        i.payment_type
        FROM invoice as i 
        WHERE i.doc_type='3' AND i.cid!='0' 
        " . $migratecond . " 
        order by `i`.`id` DESC LIMIT $start,$pagesize";


        /*
         * 
         * Introduce New Table 
         * CREATE TABLE IF NOT EXISTS `sold_salvage` (
          `id` int(20) AUTO_INCREMENT PRIMARY KEY,
          `sales_id` int(20)
          )

         * Introducce new field in            */

        $sqlpars = "SELECT 
        i.id, 
        i.invoice_id, 
        i.cid, 
        i.date, 
        i.status, 
        i.doc_type, 
        i.input_by, 
        i.payment_type
        FROM invoice as i 
        WHERE i.doc_type='3' AND i.cid!='0' 
        " . $migratecond . " 
        order by `i`.`id` DESC";


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
        $cond = $plugin->BackEndDateSearch('from', 'to', 'date', 'i.', ' AND ');


        if ($input_status == 1) {
            $migratecond = $cond;
        } elseif ($input_status == 5) {

            $sqlchain_store_ids = $obj->SelectAllByID("store_chain_admin", array("sid" => $input_by));
            if (!empty($sqlchain_store_ids)) {

                $inner_cond = ' AND (';
                $i = 1;
                foreach ($sqlchain_store_ids as $ch):
                    if ($i == 1) {
                        $inner_cond .= "`i`.`input_by`='" . $ch->store_id . "'";
                    } else {
                        $inner_cond .= " OR `i`.`input_by`='" . $ch->store_id . "'";
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

            $newcond = " AND `i`.`input_by`='" . $input_by . "'";
            $migratecond = $cond . $newcond;
        }

        if (isset($_GET['report_cid'])) {
            if (!empty($migratecond)) {
                $migratecond .=" AND i.cid='".$_GET['report_cid']."'";
            } else {
                $migratecond .=" AND i.cid='".$_GET['report_cid']."'";
            }
        }

        $sql_coustomer = $obj->FlyQuery("SELECT 
                                        i.id, 
                                        i.invoice_id, 
                                        i.cid, 
                                        CASE (SELECT ip.payment_type FROM invoice_payment as ip WHERE ip.invoice_id=i.invoice_id LIMIT 1)
                                        WHEN 0 THEN 0 
                                        ELSE (SELECT pm.meth_name FROM payment_method as pm WHERE pm.id=(SELECT ip.payment_type FROM invoice_payment as ip WHERE ip.invoice_id=i.invoice_id LIMIT 1) LIMIT 1)
                                        END
                                        as pty,
                                        CASE (SELECT count(s.quantity) FROM sales as s WHERE s.sales_id=i.invoice_id GROUP BY i.invoice_id) 
                                        WHEN 0 THEN 0 
                                        ELSE 
                                        CASE (SELECT pt.status FROM pos_tax as pt WHERE pt.invoice_id=i.invoice_id LIMIT 1)  
                                        WHEN 0 THEN 
                                        (SELECT SUM(s.single_cost*s.quantity) FROM sales as s WHERE s.sales_id=i.invoice_id GROUP BY i.invoice_id) 
                                        ELSE
                                        (((((SELECT SUM(s.single_cost*s.quantity) FROM sales as s WHERE s.sales_id=i.invoice_id GROUP BY i.invoice_id)) * 1)/100)+((SELECT SUM(s.single_cost*s.quantity) FROM sales as s WHERE s.sales_id=i.invoice_id GROUP BY i.invoice_id)))
                                        END
                                        END
                                        as sales_amount,
                                        (SELECT SUM(s.quantity) FROM sales as s WHERE s.sales_id=i.invoice_id GROUP BY i.invoice_id) as quantity,
                                        (SELECT SUM(amount) FROM invoice_payment as ip WHERE ip.invoice_id=i.invoice_id GROUP BY i.invoice_id) as paid_amount,
                                        (SELECT concat(c.firstname,' ',c.lastname,' - ',c.businessname) FROM coustomer as c WHERE c.id=i.cid) as customer,
                                        i.date, 
                                        i.status, 
                                        i.doc_type, 
                                        i.input_by, 
                                        i.payment_type
                                        FROM invoice as i 
                                        WHERE i.doc_type='3' AND i.cid!='0' 
                                        " . $migratecond . " 
                                        order by `i`.`id` DESC LIMIT $start,$pagesize");



        $totalrows = $obj->FlyQuery("SELECT 
                                    i.id, 
                                    i.invoice_id, 
                                    i.cid, 
                                    i.date, 
                                    i.status, 
                                    i.doc_type, 
                                    i.input_by, 
                                    i.payment_type
                                    FROM invoice as i 
                                    WHERE i.doc_type='3' AND i.cid!='0' 
                                    " . $migratecond . " 
                                    ORDER BY `i`.`id` DESC", 1);

        $sqlCity = $sql_coustomer;
        //$totalrows = $obj->totalrows($table);
        echo "{\"data\":" . json_encode($sqlCity) . ",\"total\":" . $totalrows . "}";
    }
}


if ($verb == "POST") {
    $id = $_POST['id'];
    if ($obj->delete($table, array("id" => $id)) == 1) {
        echo true;
    } else {
        echo 0;
    }
}
?>
