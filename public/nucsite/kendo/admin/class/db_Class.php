<?php
class db_class
{
	var $conn;
	var $result;
	var $result_id;
       
	//function MySQL($host='localhost', $user='newscrim_amsit', $pass='amsitsoft',$bd='newscrim_amsit')
      function MySQL($host='localhost', $user='root', $pass='',$bd='destimes')
	{
		$this->conn = mysql_connect($host,$user, $pass) or die(mysql_error()) 
				or die('Could not connect: ' . mysql_error());
				
		$this->select_db($bd);
	}
	
        
        
	function select_db($bd)
	{
				$db=mysql_select_db($bd,$this->conn) or die(mysql_error())
						or die('Could not connect to '. $bd .' ' . mysql_error());
	}
	
	function close_con()
        {
            return mysql_close($this->conn);
        }
        
        
	//sql mysql query function with last inserted id
	function sql($SQL)
	{

		$this->result = mysql_query($SQL)
					or die('SQL Error<br>' .$SQL.' '. mysql_error());
		$this->result_id = mysql_insert_id();
		
		
	}
	
        

        
        
	public function close()
	    {
	        return mysql_close($this->conn);
	    }
	//sql funcrtion end
	
	function clean($str) {//clean functioin for aboiding sql injection 
		$str = @trim($str);
		if(get_magic_quotes_gpc()) {
			$str = stripslashes($str);
		}
		return mysql_real_escape_string($str);
	}
	
	function RandNumber($e){//random number in fixed length
		for($i=0;$i<$e;$i++){
		@$rand =  $rand .  rand(0, 9); 
		}
		return $rand;
		}
	
		function randomPassword() //random number genarator with chacter and number and syntex
			{
				$alphabet = "EF+GHI234WXYZ567+89@(0-=1){<>/\_+$}[]%$*ABCD";
				$pass = array();
				for ($i = 0; $i < 6; $i++) {
					$n = rand(0, strlen($alphabet)-1); 
					$pass[$i] = $alphabet[$n];
											}
				return implode($pass); 
			}

}
//db class for connection string
//other functions

function filename()
{
    return basename($_SERVER['PHP_SELF']);
}

function cleanQuery($string){
    if(get_magic_quotes_gpc())  // prevents duplicate backslashes
        $string = stripslashes($string);
    return mysql_escape_string($string);
}

function limit_words($string, $word_limit){
    $words = explode(" ",$string);
    return implode(" ",array_splice($words,0,$word_limit));
}

function bn_date($str)
 {
     $en = array(1,2,3,4,5,6,7,8,9,0);
    $bn = array('১','২','৩','৪','৫','৬','৭','৮','৯','০');
    $str = str_replace($en, $bn, $str);
    $en = array( 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December' );
    $en_short = array( 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'July', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec' );
    $bn = array( 'জানুয়ারী', 'ফেব্রুয়ারী', 'মার্চ', 'এপ্রিল', 'মে', 'জুন', 'জুলাই', 'অগাস্ট', 'সেপ্টেম্বর', 'অক্টোবর', 'নভেম্বর', 'ডিসেম্বর' );
    $str = str_replace( $en, $bn, $str );
    $str = str_replace( $en_short, $bn, $str );
    $en = array('Saturday','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday');
     $en_short = array('Sat','Sun','Mon','Tue','Wed','Thu','Fri');
     $bn_short = array('শনি', 'রবি','সোম','মঙ্গল','বুধ','বৃহঃ','শুক্র');
     $bn = array('শনিবার','রবিবার','সোমবার','মঙ্গলবার','বুধবার','বৃহস্পতিবার','শুক্রবার');
     $str = str_replace( $en, $bn, $str );
     $str = str_replace( $en_short, $bn_short, $str );
     $en = array( 'am', 'pm' );
    $bn = array( 'পূর্বাহ্ন', 'অপরাহ্ন' );
    $str = str_replace( $en, $bn, $str );
     return $str;
 }
 
function getExtension($str) 
{
	$i = strrpos($str,".");
	if (!$i) { return ""; }
	$l = strlen($str) - $i;
	$ext = substr($str,$i+1,$l);
	return $ext;
 }
 
  function thumb($width, $height,$destination){
	/* Get original image x y*/
        $actualfile=$_FILES['image']['name'];
        $tmpfile=$_FILES['image']['tmp_name'];
	list($w, $h) = getimagesize($tmpfile);
        
        $filename = stripslashes($actualfile);
        $extension = getExtension($filename);
        $extension = strtolower($extension);
        $fggf=date('M_Y').'_desh'.time();
	$image_name=$fggf.'.'.$extension;
	$path = $destination.''.$image_name;
	$imgString = file_get_contents($tmpfile);
	$image = imagecreatefromstring($imgString);
                //setImageResolution(500, 500);
	$tmp = imagecreatetruecolor($width, $height);
	
	imagecopyresized($tmp, $image,0, 0,0, 0,$width, $height,$w, $h);
	switch ($_FILES['image']['type']) {
		case 'image/jpeg':
			imagejpeg($tmp, $path, 100);
			break;
		case 'image/png':
			imagepng($tmp, $path, 0);
			break;
		case 'image/gif':
			imagegif($tmp, $path);
			break;
		default:
			exit;
			break;
	}
	return $image_name;
	imagedestroy($image);
	imagedestroy($tmp);
}

 
  
 function image_caption($width, $height,$destination){
        
	list($w, $h) = getimagesize($_FILES['image']['tmp_name']);
	$path = $destination.'thumb_'.time().'_'.$_FILES['image']['name'];
	$imgString = file_get_contents($_FILES['image']['tmp_name']);
	$image = imagecreatefromstring($imgString);
	$tmp = imagecreatetruecolor($width, $height);
	imagecopyresized($tmp, $image,0, 0,0, 0,$width, $height,$w, $h);
	switch ($_FILES['image']['type']) 
	{
		case 'image/jpeg':
			imagejpeg($tmp, $path, 100);
			break;
		case 'image/png':
			imagepng($tmp, $path, 0);
			break;
		case 'image/gif':
			imagegif($tmp, $path);
			break;
		default:
			exit;
			break;
	}
	return $path; imagedestroy($image); imagedestroy($tmp);
}


function image_bigcaption($width, $height,$destination)
{
        $actualfile=$_FILES['image']['name'];
        $tmpfile=$_FILES['image']['tmp_name'];
	list($w, $h) = getimagesize($tmpfile);
        
        $filename = stripslashes($actualfile);
        $extension = getExtension($filename);
        $extension = strtolower($extension);
        $fggf=date('M_Y').'_desh'.time();
	$image_name=$fggf.'.'.$extension;
	$path = $destination.''.$image_name;
	$imgString = file_get_contents($tmpfile);
	$image = imagecreatefromstring($imgString);
                //setImageResolution(500, 500);
	$tmp = imagecreatetruecolor($width, $height);
	
	imagecopyresized($tmp, $image,0, 0,0, 0,$width, $height,$w, $h);

	switch ($_FILES['image']['type']) 
	{
		case 'image/jpeg':
			imagejpeg($tmp, $path, 100);
			break;
		case 'image/png':
			imagepng($tmp, $path, 0);
			break;
		case 'image/gif':
			imagegif($tmp, $path);
			break;
		default:
			exit;
			break;
	}
	return $image_name; imagedestroy($image); imagedestroy($tmp);
}

function getrowstotal($table)
{
	$sql=mysql_num_rows(mysql_query("SELECT * FROM ".$table));
	return $sql;	
}

function getdatabyid($table,$id,$cell)
{
	$sql=mysql_query("SELECT * FROM ".$table." WHERE id='$id'");
	$data=mysql_fetch_array($sql);
	$value=$data[$cell];
	return $value;
}

function getdatabydid($table,$id,$idval,$cell)
{
	$sql=mysql_query("SELECT * FROM ".$table." WHERE `$id`='$idval'");
	$data=mysql_fetch_array($sql);
	$value=$data[$cell];
	return $value;
}

function getfrontnews($table,$pid,$cell)
{
	$sql=mysql_query("SELECT * FROM ".$table." WHERE pid='$pid' AND status!='5' ORDER BY id DESC LIMIT 1");
	$data=mysql_fetch_array($sql);
	$value=$data[$cell];
	return $value;
}

function getimg($table,$aid,$cell)
{
	$sql=mysql_query("SELECT * FROM ".$table." WHERE aid='$aid' LIMIT 1");
	$data=mysql_fetch_array($sql);
	$value=$data[$cell];
	return $value;
}

function onlineservey($table,$cell)
{
	$sql=mysql_query("SELECT * FROM ".$table." ORDER BY id DESC LIMIT 1");
	$data=mysql_fetch_array($sql);
	$value=$data[$cell];
	return $value;
}


function getquerydata($status,$hw)
{
	if($status==1){ $stval="Banner Adds Site Top ".$hw; }
	elseif($status==2){ $stval="Top Six Upper Adds ".$hw; }
	elseif($status==3){ $stval="Top Six Down Adds ".$hw; }
	elseif($status==4){ $stval="Top of Online Servey Adds ".$hw; }
	elseif($status==5){ $stval="Top of Play Section Adds ".$hw; }
	elseif($status==6){ $stval="Top of Entertainment Section Adds ".$hw; }
	elseif($status==7){ $stval="Top of Life-Style and Gallery Section Adds ".$hw; }
	elseif($status==8){ $stval="Right Side - Top Six Section Adds ".$hw; }
	elseif($status==9){ $stval="Right Side - International Section Adds ".$hw; }
	elseif($status==10){ $stval="Right Side - Play Section Adds ".$hw; }
	return $stval;
}
?>