<?php

include '../class/auth.php';
header("Content-type: application/json");
if (isset($_GET['inventory'])) {
    $comnewadd=array("id"=>0,"name"=>"Add New Product");
    if (isset($_GET['filter'])) {
        $filter_result = array();
        $filter_data = $_GET["filter"];
        $filtercount = count($_GET["filter"]['filters']);

        $confilter = '';
        include '../plugin/plugin.php';
        $plugin = new CmsRootPlugin();

        for ($i = 0; $i <= $filtercount - 1; $i++):
            if ($i == 0) {
                $confilter = $plugin->KendoFilter($filter_data, "AllKenduData.", $i);
            } else {
                $confilter .=" AND " . $plugin->KendoFilter($filter_data, "AllKenduData.", $i);
            }
        endfor;
        
        if ($input_status == 1) {
            $sqlpar ="SELECT id,name FROM product";
        } else {
            $sqlpar ="SELECT id,name FROM product WHERE input_by='" . $input_by . "'";
        }

        $sqlparamgen = $plugin->KenduFilterParam($sqlpar, $confilter) . " LIMIT 100";
        //$sqlparamgen;
        //  LIMIT $start,$pagesize
        $excsql=$obj->FlyQuery($sqlparamgen);
        
        array_push($excsql, $comnewadd);
        
        echo json_encode($excsql);
        //print_r($_GET);
        exit();
    } else {
        if ($input_status == 1) {
            $sqlproduct = $obj->FlyQuery("SELECT id,name FROM product LIMIT 1000");
        } else {
            $sqlproduct = $obj->FlyQuery("SELECT id,name FROM product WHERE input_by='" . $input_by . "'");
        }
        
        array_push($sqlproduct, $comnewadd);
       
        
        echo json_encode($sqlproduct);
    }
}
elseif (isset($_GET['inventory_phone'])) {
    $comnewadd=array("id"=>0,"name"=>"Add New Product");
    if (isset($_GET['filter'])) {
        $filter_result = array();
        $filter_data = $_GET["filter"];
        $filtercount = count($_GET["filter"]['filters']);

        $confilter = '';
        include '../plugin/plugin.php';
        $plugin = new CmsRootPlugin();

        for ($i = 0; $i <= $filtercount - 1; $i++):
            if ($i == 0) {
                $confilter = $plugin->KendoFilter($filter_data, "AllKenduData.", $i);
            } else {
                $confilter .=" AND " . $plugin->KendoFilter($filter_data, "AllKenduData.", $i);
            }
        endfor;
        
        if ($input_status == 1) {
            $sqlpar ="SELECT id,name FROM product";
        } else {
            $sqlpar ="SELECT id,name FROM product WHERE input_by='" . $input_by . "'";
        }

        $sqlparamgen = $plugin->KenduFilterParam($sqlpar, $confilter) . " LIMIT 100";
        //$sqlparamgen;
        //  LIMIT $start,$pagesize
        $excsql=$obj->FlyQuery($sqlparamgen);
        array_push($excsql, $comnewadd);
        echo json_encode($excsql);
        //print_r($_GET);
        exit();
    } else {
        if ($input_status == 1) {
            $sqlproduct = $obj->FlyQuery("SELECT id,name FROM product LIMIT 1000");
        } else {
            $sqlproduct = $obj->FlyQuery("SELECT id,name FROM product WHERE input_by='" . $input_by . "'");
        }
        array_push($sqlproduct, $comnewadd);
        echo json_encode($sqlproduct);
    }
}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

