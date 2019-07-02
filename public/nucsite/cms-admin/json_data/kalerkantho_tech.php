<?php
ini_set("allow_url_fopen", 1);
//include("../class/auth.php");
$input_datetime = date('Y-m-d');
include('../class/db_Class.php');
$obj = new db_class();
extract($_POST);
//bot engine
$postdata = http_build_query(
        array(
            'EID' => 1,
            'ID' => 1
        )
);

$opts = array('http' =>
    array(
        'method' => 'POST',
        'header' => 'Content-type: application/x-www-form-urlencoded'
    //'content' => $postdata
    )
);

$context = stream_context_create($opts);
//step1
$result = file_get_contents('http://www.kalerkantho.com/online/info-tech', false, $context);

//Find out website Name
//$titlePattern = "/<title>(.*)<\/title>/iU";
//preg_match_all($titlePattern, $result, $titleMatch);

//$sitetitle=$titleMatch[1][0];
//print_r($titleMatch[1][0]);
//exit();




//echo $result;
//bot 1st step complete
//bot grab text start
//$sPattern="/<div class=\"homeTopLeadSlider\">(.*?)<\/div>/s";
//$sPattern = "/<div class=\"home_page_left\">(.*?)<\/div>/s";
$sPattern='{<div\s+class="col-xs-12 top_news"\s*>((?:(?:(?!<div[^>]*>|</div>).)++|<div[^>]*>(?1)</div>)*)</div>}si';
$sText = $result;
preg_match_all($sPattern, $sText, $aMatch);

//print_r($aMatch[0][0]);
//exit();



//Find out New Headding
//step2
$headingPattern =  '/<a .*?\>(.*?)<\/a>/si';
$headingtext = $aMatch[0][0];
preg_match_all($headingPattern, $headingtext, $headingMatch);

$news_heading = trim(strip_tags(html_entity_decode($headingMatch[0][0])));

//print_r($news_heading);
//exit();


//Find out News Link
//step3

$detailPattern = "#href=\"(.*?)\"#";
$detailtext = $aMatch[0][0];
preg_match_all($detailPattern, $detailtext, $detailMatch);


$detailpagelik_re = str_replace("href=","",$detailMatch[0][0]);
$detailpagelik_rep = str_replace('"',"",$detailpagelik_re);
$detailpagelik = str_replace('./',"http://www.kalerkantho.com/",$detailpagelik_rep);
//$detailpagelik = $detailMatch[0][0];
//print_r($detailpagelik);
//exit();



//Find out image
//step4
$imgsPattern ='/<img(.*?)src=("|\'|)(.*?)("|\'| )(.*?)>/s';
$imgtext = $aMatch[0][0];
preg_match_all($imgsPattern, $imgtext, $imgMatch);
$imgurltag = $imgMatch[0][0];
//print_r($imgurltag);
//exit();
//step1.0
$imgsPatternget ='/src=([\'"])?(.*?)\\1/';

preg_match_all($imgsPatternget, $imgurltag, $imgMatchsrc);

$img_link_re=str_replace("src=","",strip_tags($imgMatchsrc[0][0]));
$img_link=str_replace('"',"",$img_link_re);
//$img_alt = $imgMatch[2][0];
//print_r($img_link);
//exit();
//$stortdetail = str_replace("বিস�?তারিত", "", str_replace($img_alt, "", strip_tags($aMatch[0][0])));







//Find out News Short Details
//step4

//$detailPatternlink = '{<div\s+id="dtl"\s*>((?:(?:(?!<div[^>]*>|</div>).)++|<div[^>]*>(?1)</div>)*)</div>}si';
//$detaillinktext = file_get_contents($detailMatch[1][0], false, $context);
//preg_match_all($detailPatternlink, $detaillinktext, $detaillinkMatch);
//
//$detail_content = $detaillinkMatch[1][0];


$detailPatternlink = '/<p .*?\>(.*?)<\/p>/si';
$detaillinktext = $aMatch[0][0];
preg_match_all($detailPatternlink, $detaillinktext, $detaillinkMatch);

$shortdetailpage =trim(strip_tags(html_entity_decode($detaillinkMatch[0][0])));
//$shortdetailpage = str_replace("....","",strip_tags($detaillinkMatch[0][0]));
//print_r($shortdetailpage);
//exit();



//Find out News Long Details
//step4

//$detailPatternlink = '{<div\s+id="dtl"\s*>((?:(?:(?!<div[^>]*>|</div>).)++|<div[^>]*>(?1)</div>)*)</div>}si';
//$detaillinktext = file_get_contents($detailMatch[1][0], false, $context);
//preg_match_all($detailPatternlink, $detaillinktext, $detaillinkMatch);
//
//$detail_content = $detaillinkMatch[1][0];


$longdetailPatternlink = "/<div class=\"some-class-name2\">(.*?)<\/div>/s";
$longdetaillinktext = file_get_contents($detailpagelik, false, $context);
preg_match_all($longdetailPatternlink, $longdetaillinktext, $longdetaillinkMatch);

$longdetail_content = trim(strip_tags(html_entity_decode($longdetaillinkMatch[0][0])));


//print_r($longdetail_content);
//exit();

//insert system
$exists_array = array("news_headding" =>$news_heading);
if ($obj->exists_multiple("compose_news", $exists_array) == 0) {

   
    //echo $imgurl;
    $img = explode(".", basename($img_link));

    $extension=$img['1'];
    $newname_image="kalerkantho_tech_".time().".".$extension;
    
    copy($img_link, '../../news_thumble/'.$newname_image);
    
    $insertarray = array("news_headding" => $news_heading,
        "reporter" => 4,
        "news_thumble" => $newname_image,
        "news_short_details" => $shortdetailpage,
        "news_long_details" => $longdetail_content,
        "news_status" => 0,
        "news_date_time" => date('D d M Y'),
        "news_robot" => 1,
        "select_category_news" =>8,
        "news_publish" =>'Pending',
            "news_source" => $detailpagelik,
        "date" => date('Y-m-d'),
        "status" => 1);
    $obj->insert("compose_news", $insertarray);

    echo "Grab Done";
} else {
    echo "Grab Failed";
}
?>