<?php

include '../class/auth.php';
header("Content-type: application/json");
$verb = $_SERVER["REQUEST_METHOD"];
$table = "parts_order";
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

        if ($input_status == 1) {
            $cond = $plugin->BackEndDateSearch('from', 'to', 'date', 'i.', ' AND ');
            for ($i = 0; $i <= $filtercount - 1; $i++):
                if ($i == 0) {
                    $confilter = $plugin->KendoFilter($filter_data, "AllKenduData.", $i);
                } else {
                    $confilter .=" AND " . $plugin->KendoFilter($filter_data, "AllKenduData.", $i);
                }
            endfor;

            if (isset($_GET['report_cid'])) {
                if (!empty($migratecond)) {
                    $cond .=" AND i.cid='" . $_GET['report_cid'] . "'";
                } else {
                    $cond .=" AND i.cid='" . $_GET['report_cid'] . "'";
                }
            }

            $sqlpar = "SELECT ff.id,ff.invoice_id,c.businessname,SUM(ff.quantity) as quantity,SUM(ff.row_total) as row_total,SUM(ff.tax_total) as tax_total,SUM(ff.row_total+ff.tax_total) as total,ff.date,ff.status FROM (SELECT i.id,i.invoice_id,a.pid,a.quantity,a.single_cost,(a.quantity*a.single_cost) AS `row_total`,
                        CASE a.tax WHEN '' THEN '0'
                        ELSE CASE a.tax WHEN 0 THEN '0'
                        ELSE 
                        (((a.quantity*a.single_cost) * 1)/100)
                        END END AS tax_total,i.cid,i.status as `status`,i.doc_type,a.input_by,i.date 
                        FROM `invoice_detail` as a 
                        LEFT JOIN invoice as i on i.invoice_id=a.invoice_id
                        WHERE i.doc_type='2' " . $cond . ") AS ff 
                        LEFT JOIN coustomer as c on c.id=ff.cid 
                        GROUP BY ff.invoice_id ORDER BY ff.id DESC";

            $sqlparamgen = $plugin->KenduFilterParam($sqlpar, $confilter) . " LIMIT $start,$pagesize";
            $filter_result = $obj->FlyQuery($sqlparamgen);
            $total_in_filter = $obj->FlyQuery($plugin->KenduFilterParam($sqlpar, $confilter . "" . $cond), "1");
        } elseif ($input_status == 5) {

            $sqlchain_store_ids = $obj->FlyQuery("SELECT sid,store_id FROM store_chain_admin WHERE sid='" . $input_by . "'");
            if (!empty($sqlchain_store_ids)) {
                $inner_cond = ' AND (';
                foreach ($sqlchain_store_ids as $ch):
                    $inner_cond = " OR a.input_by='" . $ch->store_id . "'";
                endforeach;
                $inner_cond .=')';


                $cond = $plugin->BackEndDateSearch('from', 'to', 'date', 'i.', ' AND ');
                for ($i = 0; $i <= $filtercount - 1; $i++):
                    if ($i == 0) {
                        $confilter = $plugin->KendoFilter($filter_data, "AllKenduData.", $i);
                    } else {
                        $confilter .=" AND " . $plugin->KendoFilter($filter_data, "AllKenduData.", $i);
                    }
                endfor;

                $migratecond = $inner_cond . $cond;

                if (isset($_GET['report_cid'])) {
                    if (!empty($migratecond)) {
                        $migratecond .=" AND i.cid='" . $_GET['report_cid'] . "'";
                    } else {
                        $migratecond .=" AND i.cid='" . $_GET['report_cid'] . "'";
                    }
                }



                $sqlpar = "SELECT ff.id,ff.invoice_id,c.businessname,SUM(ff.quantity) as quantity,SUM(ff.row_total) as row_total,SUM(ff.tax_total) as tax_total,SUM(ff.row_total+ff.tax_total) as total,ff.date,ff.status FROM (SELECT i.id,i.invoice_id,a.pid,a.quantity,a.single_cost,(a.quantity*a.single_cost) AS `row_total`,
                        CASE a.tax WHEN '' THEN '0'
                        ELSE CASE a.tax WHEN 0 THEN '0'
                        ELSE 
                        (((a.quantity*a.single_cost) * 1)/100)
                        END END AS tax_total,i.cid,i.status as `status`,i.doc_type,a.input_by,i.date 
                        FROM `invoice_detail` as a 
                        LEFT JOIN invoice as i on i.invoice_id=a.invoice_id
                        WHERE i.doc_type='2' " . $migratecond . ") AS ff 
                        LEFT JOIN coustomer as c on c.id=ff.cid 
                        GROUP BY ff.invoice_id ORDER BY ff.id DESC";
                $sqlparamgen = $plugin->KenduFilterParam($sqlpar, $confilter) . " LIMIT $start,$pagesize";
                $filter_result = $obj->FlyQuery($sqlparamgen);
                $total_in_filter = $obj->FlyQuery($plugin->KenduFilterParam($sqlpar, $confilter), "1");
            } else {
                $filter_result = "";
                $total_in_filter = 0;
            }
        } else {

            $confilter = '';
            $cond = $plugin->BackEndDateSearch('from', 'to', 'date', 'i.', ' AND ');
            for ($i = 0; $i <= $filtercount - 1; $i++):
                if ($i == 0) {
                    $confilter = $plugin->KendoFilter($filter_data, "AllKenduData.", $i);
                } else {
                    $confilter .=" AND " . $plugin->KendoFilter($filter_data, "AllKenduData.", $i);
                }
            endfor;

            $newcond = " AND a.input_by='" . $input_by . "'";
            $migratecond = $newcond . $cond;

            if (isset($_GET['report_cid'])) {
                if (!empty($migratecond)) {
                    $migratecond .=" AND i.cid='" . $_GET['report_cid'] . "'";
                } else {
                    $migratecond .=" AND i.cid='" . $_GET['report_cid'] . "'";
                }
            }

            $sqlpar = "SELECT ff.id,ff.invoice_id,c.businessname,SUM(ff.quantity) as quantity,SUM(ff.row_total) as row_total,SUM(ff.tax_total) as tax_total,SUM(ff.row_total+ff.tax_total) as total,ff.date,ff.status FROM (SELECT i.id,i.invoice_id,a.pid,a.quantity,a.single_cost,(a.quantity*a.single_cost) AS `row_total`,
                        CASE a.tax WHEN '' THEN '0'
                        ELSE CASE a.tax WHEN 0 THEN '0'
                        ELSE 
                        (((a.quantity*a.single_cost) * 1)/100)
                        END END AS tax_total,i.cid,i.status as `status`,i.doc_type,a.input_by,i.date 
                        FROM `invoice_detail` as a 
                        LEFT JOIN invoice as i on i.invoice_id=a.invoice_id
                        WHERE i.doc_type='2' " . $migratecond . ") AS ff 
                        LEFT JOIN coustomer as c on c.id=ff.cid 
                        GROUP BY ff.invoice_id ORDER BY ff.id DESC";
            $sqlparamgen = $plugin->KenduFilterParam($sqlpar, $confilter) . " LIMIT $start,$pagesize";
            $filter_result = $obj->FlyQuery($sqlparamgen);
            $total_in_filter = $obj->FlyQuery($plugin->KenduFilterParam($sqlpar, $confilter), "1");
        }


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
            if (isset($_GET['report_cid'])) {
                if (!empty($migratecond)) {
                    $migratecond .=" AND i.cid='" . $_GET['report_cid'] . "'";
                } else {
                    $migratecond .=" AND i.cid='" . $_GET['report_cid'] . "'";
                }
            }
            $sql_coustomer = $obj->FlyQuery("SELECT ff.id,ff.invoice_id,c.businessname,SUM(ff.quantity) as quantity,SUM(ff.row_total) as row_total,SUM(ff.tax_total) as tax_total,SUM(ff.row_total+ff.tax_total) as total,ff.date,ff.status FROM (SELECT i.id,i.invoice_id,a.pid,a.quantity,a.single_cost,(a.quantity*a.single_cost) AS `row_total`,
                                            CASE a.tax WHEN '' THEN '0'
                                            ELSE CASE a.tax WHEN 0 THEN '0'
                                            ELSE 
                                            (((a.quantity*a.single_cost) * 1)/100)
                                            END END AS tax_total,i.cid,i.status as `status`,i.doc_type,a.input_by,i.date 
                                            FROM `invoice_detail` as a 
                                            LEFT JOIN invoice as i on i.invoice_id=a.invoice_id
                                            WHERE i.doc_type='2' " . $migratecond . ") AS ff 
                                            LEFT JOIN coustomer as c on c.id=ff.cid 
                                            GROUP BY ff.invoice_id ORDER BY ff.id DESC LIMIT $start,$pagesize");

            $totalrows = $obj->FlyQuery("SELECT ff.id,ff.invoice_id,c.businessname,SUM(ff.quantity) as quantity,SUM(ff.row_total) as row_total,SUM(ff.tax_total) as tax_total,SUM(ff.row_total+ff.tax_total) as total,ff.date,ff.status FROM (SELECT i.id,i.invoice_id,a.pid,a.quantity,a.single_cost,(a.quantity*a.single_cost) AS `row_total`,
                                        CASE a.tax WHEN '' THEN '0'
                                        ELSE CASE a.tax WHEN 0 THEN '0'
                                        ELSE 
                                        (((a.quantity*a.single_cost) * 1)/100)
                                        END END AS tax_total,i.cid,i.status as `status`,i.doc_type,a.input_by,i.date 
                                        FROM `invoice_detail` as a 
                                        LEFT JOIN invoice as i on i.invoice_id=a.invoice_id
                                        WHERE i.doc_type='2' " . $migratecond . ") AS ff 
                                        LEFT JOIN coustomer as c on c.id=ff.cid 
                                        GROUP BY ff.invoice_id ORDER BY ff.id DESC", 1);
        } elseif ($input_status == 5) {

            $sqlchain_store_ids = $obj->SelectAllByID("store_chain_admin", array("sid" => $input_by));
            if (!empty($sqlchain_store_ids)) {

                if (!empty($cond)) {
                    $inner_cond = ' AND (';
                    foreach ($sqlchain_store_ids as $ch):
                        $inner_cond .= " OR a.input_by='" . $ch->store_id . "'";
                    endforeach;
                    $inner_cond .=')';
                } else {
                    $inner_cond = ' WHERE (';
                    $i = 1;
                    foreach ($sqlchain_store_ids as $ch):
                        if ($i == 1) {
                            $inner_cond .= "a.input_by='" . $ch->store_id . "'";
                        } else {
                            $inner_cond .= " OR a.input_by='" . $ch->store_id . "'";
                        }
                        $i++;
                    endforeach;
                    $inner_cond .=')';
                }

                $migratecond = $cond . $inner_cond;

                if (isset($_GET['report_cid'])) {
                    if (!empty($migratecond)) {
                        $migratecond .=" AND i.cid='" . $_GET['report_cid'] . "'";
                    } else {
                        $migratecond .=" AND i.cid='" . $_GET['report_cid'] . "'";
                    }
                }

                $sql_coustomer = $obj->FlyQuery("SELECT ff.id,ff.invoice_id,c.businessname,SUM(ff.quantity) as quantity,SUM(ff.row_total) as row_total,SUM(ff.tax_total) as tax_total,SUM(ff.row_total+ff.tax_total) as total,ff.date,ff.status FROM (SELECT i.id,i.invoice_id,a.pid,a.quantity,a.single_cost,(a.quantity*a.single_cost) AS `row_total`,
                                                CASE a.tax WHEN '' THEN '0'
                                                ELSE CASE a.tax WHEN 0 THEN '0'
                                                ELSE 
                                                (((a.quantity*a.single_cost) * 1)/100)
                                                END END AS tax_total,i.cid,i.status as `status`,i.doc_type,a.input_by,i.date 
                                                FROM `invoice_detail` as a 
                                                LEFT JOIN invoice as i on i.invoice_id=a.invoice_id
                                                WHERE i.doc_type='2' " . $migratecond . ") AS ff 
                                                LEFT JOIN coustomer as c on c.id=ff.cid 
                                                GROUP BY ff.invoice_id ORDER BY ff.id DESC LIMIT $start,$pagesize");

                $totalrows = $obj->FlyQuery("SELECT ff.id,ff.invoice_id,c.businessname,SUM(ff.quantity) as quantity,SUM(ff.row_total) as row_total,SUM(ff.tax_total) as tax_total,SUM(ff.row_total+ff.tax_total) as total,ff.date,ff.status FROM (SELECT i.id,i.invoice_id,a.pid,a.quantity,a.single_cost,(a.quantity*a.single_cost) AS `row_total`,
                                                CASE a.tax WHEN '' THEN '0'
                                                ELSE CASE a.tax WHEN 0 THEN '0'
                                                ELSE 
                                                (((a.quantity*a.single_cost) * 1)/100)
                                                END END AS tax_total,i.cid,i.status as `status`,i.doc_type,a.input_by,i.date 
                                                FROM `invoice_detail` as a 
                                                LEFT JOIN invoice as i on i.invoice_id=a.invoice_id
                                                WHERE i.doc_type='2' " . $migratecond . ") AS ff 
                                                LEFT JOIN coustomer as c on c.id=ff.cid 
                                                GROUP BY ff.invoice_id ORDER BY ff.id DESC", 1);
            } else {
                $sql_coustomer = [];
                $totalrows = 0;
            }
        } else {
            if (!empty($cond)) {
                $newcond = " AND a.input_by='" . $input_by . "'";
            } else {
                $newcond = " AND a.input_by='" . $input_by . "'";
            }

            $migratecond = $cond . $newcond;

            if (isset($_GET['report_cid'])) {
                if (!empty($migratecond)) {
                    $migratecond .=" AND i.cid='" . $_GET['report_cid'] . "'";
                } else {
                    $migratecond .=" AND i.cid='" . $_GET['report_cid'] . "'";
                }
            }

            $sql_coustomer = $obj->FlyQuery("SELECT ff.id,ff.invoice_id,c.businessname,SUM(ff.quantity) as quantity,SUM(ff.row_total) as row_total,SUM(ff.tax_total) as tax_total,SUM(ff.row_total+ff.tax_total) as total,ff.date,ff.status FROM (SELECT i.id,i.invoice_id,a.pid,a.quantity,a.single_cost,(a.quantity*a.single_cost) AS `row_total`,
                                                CASE a.tax WHEN '' THEN '0'
                                                ELSE CASE a.tax WHEN 0 THEN '0'
                                                ELSE 
                                                (((a.quantity*a.single_cost) * 1)/100)
                                                END END AS tax_total,i.cid,i.status as `status`,i.doc_type,a.input_by,i.date 
                                                FROM `invoice_detail` as a 
                                                LEFT JOIN invoice as i on i.invoice_id=a.invoice_id
                                                WHERE i.doc_type='2' " . $migratecond . ") AS ff 
                                                LEFT JOIN coustomer as c on c.id=ff.cid 
                                                GROUP BY ff.invoice_id ORDER BY ff.id DESC LIMIT $start,$pagesize");

            $totalrows = $obj->FlyQuery("SELECT ff.id,ff.invoice_id,c.businessname,SUM(ff.quantity) as quantity,SUM(ff.row_total) as row_total,SUM(ff.tax_total) as tax_total,SUM(ff.row_total+ff.tax_total) as total,ff.date,ff.status FROM (SELECT i.id,i.invoice_id,a.pid,a.quantity,a.single_cost,(a.quantity*a.single_cost) AS `row_total`,
                                        CASE a.tax WHEN '' THEN '0'
                                        ELSE CASE a.tax WHEN 0 THEN '0'
                                        ELSE 
                                        (((a.quantity*a.single_cost) * 1)/100)
                                        END END AS tax_total,i.cid,i.status as `status`,i.doc_type,a.input_by,i.date 
                                        FROM `invoice_detail` as a 
                                        LEFT JOIN invoice as i on i.invoice_id=a.invoice_id
                                        WHERE i.doc_type='2' " . $migratecond . ") AS ff 
                                        LEFT JOIN coustomer as c on c.id=ff.cid 
                                        GROUP BY ff.invoice_id ORDER BY ff.id DESC", 1);
        }


        $sqlCity = $sql_coustomer;
        //$totalrows = $obj->totalrows($table);
        echo "{\"data\":" . json_encode($sqlCity) . ",\"total\":" . $totalrows . "}";
    }
}


if ($verb == "POST") {
    $id = $_POST['id'];
    if ($obj->delete("invoice", array("invoice_id" => $id)) == 1) {
        $obj->delete("invoice_detail", array("invoice_id" => $id));
        echo true;
    } else {
        echo 0;
    }
}
?>
