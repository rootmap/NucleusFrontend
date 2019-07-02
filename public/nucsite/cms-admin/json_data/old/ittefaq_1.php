
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

$opts = array(
    "ssl" => array(
        "verify_peer" => false,
        "verify_peer_name" => false,
    ),
);

$context = stream_context_create($opts);
//step1
//$result = file_get_contents('http://www.ittefaq.com.bd', false, $context);






$lurl = get_fcontent("http://www.ittefaq.com.bd/");
echo"cid:" . $lurl[0] . "<BR>";

function get_fcontent($url, $javascript_loop = 0, $timeout = 5) {
    $url = str_replace("&amp;", "&", urldecode(trim($url)));

    $cookie = tempnam("/tmp", "CURLCOOKIE");
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1");
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_ENCODING, "");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_AUTOREFERER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);    # required for https urls
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
    curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
    $content = curl_exec($ch);
    $response = curl_getinfo($ch);
    curl_close($ch);

    if ($response['http_code'] == 301 || $response['http_code'] == 302) {
        ini_set("user_agent", "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1");

        if ($headers = get_headers($response['url'])) {
            foreach ($headers as $value) {
                if (substr(strtolower($value), 0, 9) == "location:")
                    return get_url(trim(substr($value, 9, strlen($value))));
            }
        }
    }

    if (( preg_match("/>[[:space:]]+window\.location\.replace\('(.*)'\)/i", $content, $value) || preg_match("/>[[:space:]]+window\.location\=\"(.*)\"/i", $content, $value) ) && $javascript_loop < 5) {
        return get_url($value[1], $javascript_loop + 1);
    } else {
        return array($content, $response);
    }
}

//print_r($response);
//exit();









$context = [
    'http' => [
        'method' => 'GET',
        'header' => null,
        'content' => null,
        'protocol_version' => 1,
        'ignore_errors' => 1,
        'follow_location' => 1,
        'max_redirects' => 6,
        'timeout' => 5,
    ],
    'ssl' => [
        'verify+peer' => 1
    ]
];
$content = file_get_contents("http://www.ittefaq.com.bd", 0, stream_context_create($context));














// 
//
// print_r($content);
//echo $result;
//bot 1st step complete
//bot grab text start
//$sPattern="/<div class=\"homeTopLeadSlider\">(.*?)<\/div>/s";
$sPattern = "/<li class=\"sitewidthleft\">(.*?)<\/li>/s";
$sText = $result;
preg_match_all($sPattern, $sText, $aMatch);

//print_r($aMatch);
//exit();

//step1
$headingPattern = '{<div\s+class="headline"\s*>((?:(?:(?!<div[^>]*>|</div>).)++|<div[^>]*>(?1)</div>)*)</div>}si';
$headingtext = $aMatch[0][0];
preg_match_all($headingPattern, $headingtext, $headingMatch);

$news_heading = strip_tags($headingMatch[0][0]);


//step2
$imgsPattern = "/<img src=\"(.*?)\" alt=\"(.*?)\" width=\"(.*?)\" height=\"(.*?)\"\/>/s";
$imgtext = $aMatch[0][0];
preg_match_all($imgsPattern, $imgtext, $imgMatch);


$imgurl = $imgMatch[1][0];
$img_alt = $imgMatch[2][0];

$stortdetail = str_replace("বিস্তারিত", "", str_replace($img_alt, "", strip_tags($aMatch[0][0])));


//step3

$detailPattern = "/<a\s[^>]*href=(\"??)(http[^\" >]*?)\\1[^>]*>(.*)<\/a>/siU";
$detailtext = $aMatch[0][0];
preg_match_all($detailPattern, $detailtext, $detailMatch);

$detailpagelik = $detailMatch[2][0];


//step4

$detailPatternlink = '{<div\s+class="details"\s*>((?:(?:(?!<div[^>]*>|</div>).)++|<div[^>]*>(?1)</div>)*)</div>}si';
$detaillinktext = file_get_contents($detailMatch[2][0], false, $context);
preg_match_all($detailPatternlink, $detaillinktext, $detaillinkMatch);

$detail_content = $detaillinkMatch[0][0];


//insert system
//$exists_array = array("news_headding"=>$news_heading,"reporter"=>2,"news_thumble"=>$imgurl);
//if ($obj->exists_multiple("compose_news", $exists_array) == 0) {
//    
//    
//    //echo $imgurl;
//    $img = explode(".", basename($imgurl));
//
//    $extension=$img['1'];
//    $newname_image="ittefaq_".time().".".$extension;
//    
//    copy($imgurl, '../../news_thumble/'.$newname_image);
//    
//    $insertarray = array("news_headding" => $news_heading,
//        "reporter" => 2,
//        "news_thumble" => $newname_image,
//        "news_short_details" => $stortdetail,
//        "news_long_details" => $detail_content,
//        "news_status" => 0,
//        "news_date_time" => date('D d M Y'),
//        "news_robot" => 1,
//        "news_publish" =>'Pending',
//        "date" => date('Y-m-d'),
//        "status" => 1);
//    $obj->insert("compose_news", $insertarray);
//
//    echo "Grab Done";
//} else {
//    echo "Grab Failed";
//}
?>