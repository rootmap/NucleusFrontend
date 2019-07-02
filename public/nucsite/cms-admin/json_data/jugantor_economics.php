<?php
ini_set("allow_url_fopen", 1);
//include("../class/auth.php");
$input_datetime = date('Y-m-d');
include('../class/db_Class.php');
$obj = new db_class();	
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
$result = file_get_contents('http://www.jugantor.com/online/economics', false, $context);
//echo $result;
//bot 1st step complete
//bot grab text start
//$sPattern="/<div class=\"homeTopLeadSlider\">(.*?)<\/div>/s";
//$sPattern = "/<div class=\"home_page_left\">(.*?)<\/div>/s";
$sPattern='{<div\s+class="col-sm-6 col-md-6"\s*>((?:(?:(?!<div[^>]*>|</div>).)++|<div[^>]*>(?1)</div>)*)</div>}si';
$sText = $result;
preg_match_all($sPattern, $sText, $aMatch);

//print_r($aMatch);
//exit();

//Find out image
//step1
$imgsPattern = "/<div id=\"img\">(.*?)<\/div>/s";
$imgtext = $aMatch[0][0];
preg_match_all($imgsPattern, $imgtext, $imgMatch);


$imgurltag = $imgMatch[0][0];

//step1.0
$imgsPatternget = "/src=\"(.*?)\"/s";

preg_match_all($imgsPatternget, $imgurltag, $imgMatchsrc);

$img_link_re=str_replace("src=","",strip_tags($imgMatchsrc[0][0]));
$img_link=str_replace('"',"",$img_link_re);
//$img_alt = $imgMatch[2][0];
//print_r($img_link);
//exit();
//$stortdetail = str_replace("বিস্তারিত", "", str_replace($img_alt, "", strip_tags($aMatch[0][0])));


//Find out New Headding
//step2
$headingPattern = '{<div\s+id="newsHl200"\s*>((?:(?:(?!<div[^>]*>|</div>).)++|<div[^>]*>(?1)</div>)*)</div>}si';
$headingtext = $aMatch[0][0];
preg_match_all($headingPattern, $headingtext, $headingMatch);

$news_heading=trim(strip_tags(html_entity_decode($headingMatch[0][0])));

//print_r($news_heading);
//exit();


//Find out News Link
//step3

$detailPattern = "/<a\s[^>]*href=(\"??)(http[^\" >]*?)\\1[^>]*>(.*)<\/a>/siU";
$detailtext = $aMatch[0][0];
preg_match_all($detailPattern, $detailtext, $detailMatch);

$detailpagelik = $detailMatch[2][0];
//print_r($detailpagelik);
//exit();



//Find out News Short Details
//step4

//$detailPatternlink = '{<div\s+id="dtl"\s*>((?:(?:(?!<div[^>]*>|</div>).)++|<div[^>]*>(?1)</div>)*)</div>}si';
//$detaillinktext = file_get_contents($detailMatch[1][0], false, $context);
//preg_match_all($detailPatternlink, $detaillinktext, $detaillinkMatch);
//
//$detail_content = $detaillinkMatch[1][0];


$detailPatternlink = "/<div id=\"newsDtl\">(.*?)<\/div>/s";
$detaillinktext = $aMatch[0][0];
preg_match_all($detailPatternlink, $detaillinktext, $detaillinkMatch);

$shortdetailpage = trim(strip_tags(html_entity_decode($detaillinkMatch[0][0])));
//$shortdetailpage = str_replace("....","",strip_tags($detaillinkMatch[0][0]));
//print_r($shortdetailpage);
//exit();



//Find out News Long Details
//step4

//$detailPatternlink = '{<div\s+id="dtl"\s*>((?:(?:(?!<div[^>]*>|</div>).)++|<div[^>]*>(?1)</div>)*)</div>}si';
//$detaillinktext = file_get_contents($detailMatch[1][0], false, $context);
//preg_match_all($detailPatternlink, $detaillinktext, $detaillinkMatch);
//
//$detail_content = $detaillinkMatch[1][0];   dtl_pg_row  pull-right        /// "/<div id=\"myText\" style=\"(.*?)\">(.*?)<\/div>/s";
// '{<div\s+class="home_page_left_dtl"\s*>((?:(?:(?!<div[^>]*>|</div>).)++|<div[^>]*>(?1)</div>)*)</div>}si';

$longdetailPatternlink = "/<div id=\"myText\" style=\"(.*?)\">(.*?)<\/div>/s";
$longdetaillinktext = file_get_contents($detailpagelik);
preg_match_all($longdetailPatternlink, $longdetaillinktext, $longdetaillinkMatch);

$longdetail = trim(strip_tags(html_entity_decode($longdetaillinkMatch[0][0])));
$longdetail_content=  preg_replace('#^<div class="pull-right"  style="padding:5px">|</div>$#', "", $longdetail);

//print_r($longdetail_content);
//exit();
//insert system
$exists_array = array("news_headding" =>$news_heading);
if ($obj->exists_multiple("compose_news", $exists_array) == 0) {

  
    //echo $imgurl;
    $img = explode(".", basename($img_link));

    $extension=$img['1'];
    $newname_image="jugantor_economics_".time().".".$extension;
    
    copy($img_link, '../../news_thumble/'.$newname_image);
    
    $insertarray = array("news_headding" => $news_heading,
        "reporter" => 3,
        "news_thumble" => $newname_image,
        "news_short_details" => $shortdetailpage,
        "news_long_details" => $longdetail_content,
        "news_status" => 0,
        "news_date_time" => date('D d M Y'),
        "news_robot" => 1,
        "select_category_news"=>15,
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