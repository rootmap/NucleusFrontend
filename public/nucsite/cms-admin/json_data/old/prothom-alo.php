<?php

include("../class/auth.php");
extract($_POST);
//bot engine
$postdata = http_build_query(
        array(
            'EID' => 1,
            'ID' => 1
        )
);

$opts =array('http' =>
    array(
        'method'  => 'POST',
        'header'  => 'Content-type: application/x-www-form-urlencoded',
        'content' => $postdata
    )
);

$context = stream_context_create($opts);
//step1
$result = file_get_contents('http://www.prothom-alo.com/', false, $context);
//echo $result;
//bot 1st step complete
//bot grab text start
//$sPattern="/<div class=\"homeTopLeadSlider\">(.*?)<\/div>/s";
$sPattern='{<div\s+class="each_news mb20"\s*>((?:(?:(?!<div[^>]*>|</div>).)++|<div[^>]*>(?1)</div>)*)</div>}si';
$sText = $result;
preg_match_all($sPattern, $sText, $aMatch);

//print_r($aMatch[0][0]);
//exit();

//Find out image
//step1  /<img .*?(?=src)src=\"([^\"]+)\"/si   ----  !(https?:)?//\S+\.(?:jpe?g|jpg|png|gif)!Ui
$imgsPattern='/img src=["\']?([^"\' ]*)["\' ]/';
//$imgsPattern = "/<div class=\"newsTop\">(.*?)<\/div>/s";
$imgtext = $aMatch[0][0];
preg_match_all($imgsPattern, $imgtext, $imgMatch);

$imgurl= str_replace('img',"",$imgMatch[0][0]);
$imgurlt= str_replace('src',"",$imgurl);
$imgurlta= str_replace('=',"",$imgurlt);
$imgurltaa= str_replace('"',"",$imgurlta);
//$imgurltag= str_replace('//',"http://",$imgurltaa);

$explodelinkimage=  explode("?",$imgurltaa);
echo $imgurlactimage=$explodelinkimage[0];

//Get the file
echo $content = file_get_contents($imgurlactimage);
//
//
//
////Store in the filesystem.
//$fp = fopen( "../../news_thumble/image.jpg", "w");
//fwrite($fp, $content);
//fclose($fp);



exit();

//print_r($imgurltag);
//exit();



//step1.0
//$imgsPatternget = "/src=\"(.*?)\"/s";
//
//preg_match_all($imgsPatternget, $imgurltag, $imgMatchsrc);
//
//$img_link_re=str_replace("src=","",strip_tags($imgMatchsrc[0][0]));
//$img_link=str_replace('"//',"",$img_link_re);
//$img_alt = $imgMatch[2][0];
//print_r($img_link);
//exit();
//$stortdetail = str_replace("বিস�?তারিত", "", str_replace($img_alt, "", strip_tags($aMatch[0][0])));


//Find out New Headding
//step2
$headingPattern = "#<h2[^>]*>(.*?)<\/h2>#i";
$headingtext = $aMatch[0][0];
preg_match_all($headingPattern, $headingtext, $headingMatch);

$news_heading=strip_tags($headingMatch[0][0]);

//print_r($news_heading);
//exit();


//Find out News Link
//step3
//'/<a\s[^>]*href=\"([^\"]*)\"[^>]*>(.*)<\/a>/siU';
$detailPattern = "#href=\"(.*?)\"#";
$detailtext = $aMatch[0][0];
preg_match_all($detailPattern, $detailtext, $detailMatch);


$detailpagelik_re= str_replace("href=","http://www.prothom-alo.com/",$detailMatch[0][0]);
$detailpagelik= str_replace('"',"",$detailpagelik_re);
//print_r($detailpagelik);
//exit();




//Find out News Short Details
//step4

//$detailPatternlink = '{<div\s+id="dtl"\s*>((?:(?:(?!<div[^>]*>|</div>).)++|<div[^>]*>(?1)</div>)*)</div>}si';
//$detaillinktext = file_get_contents($detailMatch[1][0], false, $context);
//preg_match_all($detailPatternlink, $detaillinktext, $detaillinkMatch);
//
//$detail_content = $detaillinkMatch[1][0];

//content_right
$detailPatternlink = '/<a.*?\>(.*?)<\/a>/si';
$detaillinktext = $aMatch[0][0];
preg_match_all($detailPatternlink, $detaillinktext, $detaillinkMatch);

//$ddetailpagelik = $ddetailMatch[0][0];
//$shortdetailpage = str_replace("....","",strip_tags($detaillinkMatch[0][0]));
$shortdetailpage=strip_tags($detaillinkMatch[0][3]);
//print_r($shortdetailpage);
//exit();



//Find out News Long Details
//step4

//$detailPatternlink = '{<div\s+id="dtl"\s*>((?:(?:(?!<div[^>]*>|</div>).)++|<div[^>]*>(?1)</div>)*)</div>}si';
//$detaillinktext = file_get_contents($detailMatch[1][0], false, $context);
//preg_match_all($detailPatternlink, $detaillinktext, $detaillinkMatch);
//
//$detail_content = $detaillinkMatch[1][0];


$longdetailPatternlink ='/<div itemprop=\"articleBody\">(.*?)<\/div>/si';
$longdetaillinktext = file_get_contents($detailpagelik, false, $context);
preg_match_all($longdetailPatternlink, $longdetaillinktext, $longdetaillinkMatch);

$longdetail_content = strip_tags($longdetaillinkMatch[0][0]);


//print_r($longdetail_content);
//exit();
//insert system
$exists_array = array("news_headding"=>$news_heading,"reporter"=>7,"news_thumble"=>$imgurlactimage);
if ($obj->exists_multiple("compose_news", $exists_array) == 0) {
    
    
    //echo $imgurl;
    $img = explode(".", basename($imgurlactimage));

    $extension=$img['1'];
    $newname_image="prothom-alo_".time().".".$extension;
    
    copy($imgurlactimage, '../../news_thumble/'.$newname_image);
    
    $insertarray = array("news_headding" => $news_heading,
        "reporter" => 7,
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