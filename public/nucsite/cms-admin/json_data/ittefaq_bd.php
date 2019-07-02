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
   // 'content' => $postdata;
    )
);

$context = stream_context_create($opts);
//step1
$result = file_get_contents('http://www.ittefaq.com.bd/wholecountry', false, $context);
// print_r($content);
//echo $result;
//bot 1st step complete
//bot grab text start
//$sPattern="/<div class=\"homeTopLeadSlider\">(.*?)<\/div>/s";
$sPattern = '{<div\s+class="menuNewsLead"\s*>((?:(?:(?!<div[^>]*>|</div>).)++|<div[^>]*>(?1)</div>)*)</div>}si';
$sText = $result;
preg_match_all($sPattern, $sText, $aMatch);

//print_r($aMatch);
//exit();

//step1  News Headding
$headingPattern = '{<div\s+class="headline"\s*>((?:(?:(?!<div[^>]*>|</div>).)++|<div[^>]*>(?1)</div>)*)</div>}si';
$headingtext = $aMatch[0][0];
preg_match_all($headingPattern, $headingtext, $headingMatch);

$news_heading = trim(strip_tags(html_entity_decode($headingMatch[0][0])));
//print_r($news_heading);
//exit();

//step2 news image
$imgsPattern = "/<img src=\"(.*?)\" alt=\"(.*?)\" width=\"(.*?)\" height=\"(.*?)\"\/>/s";
$imgtext = $aMatch[0][0];
preg_match_all($imgsPattern, $imgtext, $imgMatch);


$imgurl = $imgMatch[1][0];
//print_r($imgurl);
//exit();
$img_alt = $imgMatch[0][0];

$stortdetail = str_replace("বিস্তারিত", "", str_replace($img_alt, "", strip_tags($aMatch[0][0])));
//print_r($stortdetail);
//exit();

//step3

$detailPattern = "/<a\s[^>]*href=(\"??)(http[^\" >]*?)\\1[^>]*>(.*)<\/a>/siU";
$detailtext = $aMatch[0][0];
preg_match_all($detailPattern, $detailtext, $detailMatch);

$detailpagelik = $detailMatch[2][0];
//print_r($detailpagelik);
//exit();

//step4

$detailPatternlink = '{<div\s+class="details"\s*>((?:(?:(?!<div[^>]*>|</div>).)++|<div[^>]*>(?1)</div>)*)</div>}si';
$detaillinktext = file_get_contents($detailMatch[2][0], false, $context);
preg_match_all($detailPatternlink, $detaillinktext, $detaillinkMatch);

$detail_content = trim(strip_tags(html_entity_decode($detaillinkMatch[0][0])));
//print_r($detail_content);
//exit();

//insert system
$exists_array = array("news_headding" =>$news_heading);
if ($obj->exists_multiple("compose_news", $exists_array) == 0) {


    //echo $imgurl;
    $img = explode(".", basename($imgurl));

    $extension=$img['1'];
    $newname_image="ittefaq_bd_".time().".".$extension;
    
    copy($imgurl, '../../news_thumble/'.$newname_image);
    
    $insertarray = array("news_headding" => $news_heading,
        "reporter" => 2,
        "news_thumble" => $newname_image,
        "news_short_details" => $stortdetail,
        "news_long_details" => $detail_content,
        "news_status" => 0,
        "news_date_time" => date('D d M Y'),
        "news_robot" => 1,
		"select_subcategory_news"=>2,
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