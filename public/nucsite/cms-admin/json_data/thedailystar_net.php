<?php

//include("../class/auth.php");
$input_datetime=date('Y-m-d');
include('db_Class.php');	
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
$result = file_get_contents('http://www.thedailystar.net/', false, $context);
//echo $result;
//bot 1st step complete
//bot grab text start
//$sPattern="/<div class=\"homeTopLeadSlider\">(.*?)<\/div>/s";
//$sPattern = "/<div class=\"article \news-bn\ \first\ \default \">(.*?)<\/div>/s";
$sPattern='{<div\s+class="main-content"\s*>((?:(?:(?!<div[^>]*>|</div>).)++|<div[^>]*>(?1)</div>)*)</div>}si';
$sText = $result;
preg_match_all($sPattern, $sText, $aMatch);

//print_r($aMatch);
//exit();

//Find out image
///step1
$imgsPattern = "/<div class=\"highlight-feature\">(.*?)<\/div>/s";
$imgtext = $aMatch[0][0];
preg_match_all($imgsPattern, $imgtext, $imgMatch);


$imgurltag = $imgMatch[0][0];
//print_r($imgurltag);
//exit();

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
$headingPattern = "/<div class=\"highlight-text\">(.*?)<\/div>/s";
$headingtext = $aMatch[0][0];
preg_match_all($headingPattern, $headingtext, $headingMatch);

$NewsHeadding=$headingMatch[0][0];

$findheadding="/<h1>(.*?)<\/h1>/s";
preg_match_all($findheadding, $NewsHeadding, $headingMatchs);
$news_heading=strip_tags($headingMatchs[0][0]);

//print_r($news_heading);
//exit();


//Find out News Link
//step3

$detailPattern ="/<a href=\"([^\"]*)\">(.*)<\/a>/iU";
preg_match_all($detailPattern, $headingtext, $detailMatch);

$detailpagelik=str_replace("/frontpage","http://www.thedailystar.net/frontpage",strip_tags($detailMatch[1][0]));
//$detailtext_rep=str_replace("href=","http://www.thedailystar.net",$detailtext_re);
//$detailpagelik=str_replace('"',"",$detailtext_rep);
//$detailpagelik = strip_tags($detailMatch[0][0]);
//print_r($detailtext_re);
//exit();



//Find out News Short Details
//step4

//$detailPatternlink = '{<div\s+id="dtl"\s*>((?:(?:(?!<div[^>]*>|</div>).)++|<div[^>]*>(?1)</div>)*)</div>}si';
//$detaillinktext = file_get_contents($detailMatch[1][0], false, $context);
//preg_match_all($detailPatternlink, $detaillinktext, $detaillinkMatch);
//
//$detail_content = $detaillinkMatch[1][0];


$detailPatternlink = "/<p class=\"intro\">(.*?)<\/p>/s";
preg_match_all($detailPatternlink, $headingtext, $detaillinkMatch);

//$ddetailpagelik = $ddetailMatch[0][0];
//$shortdetailpage = str_replace("....","",strip_tags($detaillinkMatch[0][0]));
$shortdetailpage=strip_tags($detaillinkMatch[0][0]);

//print_r($shortdetailpage);
//exit();



//Find out News Long Details
//step4

//$detailPatternlink = '{<div\s+id="dtl"\s*>((?:(?:(?!<div[^>]*>|</div>).)++|<div[^>]*>(?1)</div>)*)</div>}si';
//$detaillinktext = file_get_contents($detailMatch[1][0], false, $context);
//preg_match_all($detailPatternlink, $detaillinktext, $detaillinkMatch);
//
//$detail_content = $detaillinkMatch[1][0];


$longdetailPatternlink ='/<div class=\"panel-pane pane-node-content clearfix no-title block\">(.*?)<\/div>/si';
$longdetaillinktext = file_get_contents($detailpagelik, false, $context);
preg_match_all($longdetailPatternlink, $longdetaillinktext, $longdetaillinkMatch);

//$longdetail_content = strip_tags($longdetaillinkMatch[0][0]);


print_r($longdetaillinkMatch);
exit();
//insert system
$exists_array = array("news_headding"=>$news_heading,"reporter"=>6,"news_thumble"=>$imgurltag);
if ($obj->exists_multiple("compose_news", $exists_array) == 0) {
    
    
    //echo $imgurl;
    $img = explode(".", basename($imgurltag));

    $extension=$img['1'];
    $newname_image="bdnews24_".time().".".$extension;
    
    copy($imgurltag, '../../news_thumble/'.$newname_image);
    
    $insertarray = array("news_headding" => $news_heading,
        "reporter" => 6,
        "news_thumble" => $newname_image,
        "news_short_details" => $shortdetailpage,
        "news_long_details" => $longdetail_content,
        "news_status" => 0,
        "news_date_time" => date('D d M Y'),
        "news_robot" => 1,
        "news_publish" =>'Pending',
        "date" => date('Y-m-d'),
        "status" => 1);
    $obj->insert("compose_news", $insertarray);

    echo "Grab Done";
} else {
    echo "Grab Failed";
}
?>