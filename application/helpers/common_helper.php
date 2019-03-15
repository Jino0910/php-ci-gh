<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Debug Interface
*
* @access	public
*/

if(isset($_REQUEST['debug'])){
	define('isDebug',true);
}
else{
	define('isDebug',false);
}

function fail($array){
	echo json_encode($array);
	$this->db->close();
	exit;
}

function res($array){
	echo json_encode($array);
}

function return_data($result = '',$array = '',$description = ''){
	
	$data['result'] = ($result == true) ? 'yes' : 'no';
	
	if($description)
		$data['description'] = $description;
	
	$data['data'] = $array;
	
	exit (json_encode($data));
}

function query_debug($msg){
	if( isDebug )
		echo ">>> $msg\n";
}

function check($key,$canNull = false){
	if(!isset($_REQUEST[$key])){
		if($canNull==true){
			return "";
		}else{
			fail(array('result' => 'no','description' => 'invalid parameter : '.$key));
		}
	}else{
		return $_REQUEST[$key];
	}
}

function check_param($key,$canNull = false){
	if(!isset($_REQUEST[$key])){
		if($canNull==true){
			return "";
		}else{
			return_data(false,'','해당값을 입력해주세요 => '.$key);
			$this->db->close();
			exit;
		}
	}else{
		return $_REQUEST[$key];
	}
}

function GlistThumb($target,$saveIMG,$thumbX,$thumbY = 0){
	global $targetIMG,$sX,$sY,$srcW,$srcH;

	$targetIMG=getimagesize($target);

	if($thumbX > $targetIMG[0]) {
		$thumbY = intval(($targetIMG[0] * $thumbY) / $thumbX);
		$thumbX = $targetIMG[0];
	}

	$thumbY = $thumbY ? $thumbY : intval(($targetIMG[1] * $thumbX) / $targetIMG[0]);

	if( $targetIMG[0]/$targetIMG[1] >= $thumbX/$thumbY )
		$ratio = ($targetIMG[1]/$thumbY);
	else
		$ratio = ($targetIMG[0]/$thumbX);

	$ratio = $ratio < 1 ? 1 : $ratio;

	$sX = ( $targetIMG[0] - $ratio*$thumbX)/2;
	$sY = ( $targetIMG[1] - $ratio*$thumbY)/2;
	$srcW = $ratio*$thumbX;
	$srcH = $ratio*$thumbY;

	if($targetIMG[2]==2 and imagetypes() & IMG_JPG) $im = imagecreatefromjpeg($target);
	elseif($targetIMG[2]==3 and imagetypes() & IMG_PNG) $im = ImageCreateFromPNG($target);
	elseif($targetIMG[2]==1) $im = ImageCreateFromGIF($target);
	elseif($targetIMG[2]==6) $im = ImageCreateFromWBMP($target);

	if($im){
		$check_gd = get_extension_funcs("gd");
		if($check_gd){
			$thumb = imagecreatetruecolor($thumbX,$thumbY);
			if(!$thumb) $thumb = ImageCreate($thumbX,$thumbY);

			$test_check=imagecopyresampled($thumb,$im,0,0,$sX,$sY,$thumbX,$thumbY,$srcW,$srcH);
			if(!$test_check) ImageCopyResized($thumb,$im,0,0,$sX,$sY,$thumbX,$thumbY,$srcW,$srcH);

			if(imagetypes() & IMG_PNG) ImagePNG($thumb,$saveIMG);
			else ImageJPEG($thumb,$saveIMG, 100);

			imagedestroy($thumb);
		}
	}
}

function ktm_con_wgs84($base_url, $api_key, $param_url){
	
	$query_string = "?apikey={$api_key}&";
	$query_string .= urldecode($param_url);
	$query_string = $query_string;
	
	$full_url = $base_url . $query_string;
	$xml_data = curl_get_file_contents($full_url);
	
// 	$xml_data = json_encode($xml_data);
	$xml_data = json_decode($xml_data,true);

	
	return $xml_data;
}

function address_con_wgs84($base_url, $api_key, $param_url){

	$query_string = "?apikey={$api_key}&";
	$query_string .= $param_url;

	$full_url = $base_url . $query_string;
	$json_data = curl_get_file_contents($full_url);

	$json_data = json_decode($json_data,true);

	return $json_data;
}

function curl_get_file_contents($URL) {
	$c = curl_init ();
	curl_setopt ( $c, CURLOPT_RETURNTRANSFER, 1 );
	curl_setopt ( $c, CURLOPT_URL, $URL );
	$contents = curl_exec ( $c );
	curl_close ( $c );

	if ($contents)
		return $contents;
	else
		return FALSE;
}

function random_string($length) {
	error_reporting(0);
	
	$randomcode = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '0', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');

	$Rstring = '';
	mt_srand((double)microtime()*1000000);
	for($i=1;$i<=$length;$i++) 
		$Rstring .= $randomcode[mt_rand(1, count($randomcode))];
	
	return $Rstring;
}

if ( ! function_exists('debug'))
{
	function debug($variable, $type = 'echo')
	{
		$message  = "\n============================================\n";
		$debugging = var_export($variable, true);
		
		if( !empty($debugging) && $debugging != 'NULL') {
		        $message .= $debugging;
		} else {
		        $message .= sprintf($variable);
		}
		$message .= "\n";
		$message .= "============================================\n";
		switch($type) {
			case 'echo':
				echo '<pre style="text-align:left">';
				echo $message;
				echo "</pre>";
				break;
			case 'exit':
				echo '<pre style="text-align:left">';
				echo $message;
				echo "</pre>";
				exit;
				break;
			case 'log' :
				log_message('debug', $message);
		}
	}
}

/**
 * UTF-8 占쏙옙占쏙옙占쏙옙 占쏙옙占썸묾占�+占쏙옙占썼�억옙 疫뀐옙占쏙옙占� 占쏙옙占썹����용┛
 *
 * @author ks-park
 * @param 疫뀐옙占쏙옙占� 占쏙옙占썹��占� 占쏙옙占쏙옙占썬�쏙옙占� $text
 * @param 占쏙옙占썹��占� 占쏙옙��占쎈��占쏙옙 $cutSize
 * @param 占쏙옙占썹�깍옙 占쏙옙占쏙옙占썬�쏙옙占� 占쏙옙占쏙옙占쏙옙 ��븝옙占쏙옙占� 占쏙옙占쏙옙占썬�쏙옙占� $endText
 * @param 占쏙옙占썸묾占쏙옙占쏙옙 占쏙옙占썼�억옙 2疫뀐옙占쏙옙占썸에占� 筌ｏ옙��깍옙 $toAlphabet
 * @return String
 */
if ( ! function_exists('utf8Cut'))
{
	function utf8Cut($text, $cutSize, $endText = ".", $toAlphabet = true) {
		@preg_match_all('/[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]{2}|./', $text, $matchs);
	
	 	$textLength 	= strlen($text);
	 	
		if ($textLength <= $cutSize) {
			return $text;
		}
		
		$match 			= $matchs[0];
		$matchCount 	= count($match);
		if (!$toAlphabet && $matchCount < $cutSize) {
			return $text;
		}
	   
		$returnText 		= "";
	 	$endTextLength		= strlen($endText);
	 	$returnTextLength	= 0;
		$allTextLength		= 0;
		$i = 0;
		for($i = 0; $i < $matchCount; $i++) {
			$returnTextLength += ($toAlphabet && strlen($match[$i]) > 1) ? 2 : 1;
			$allTextLength = $returnTextLength + $endTextLength;
			if($allTextLength <= $cutSize) { 
				$returnText .= $match[$i];
			} else {
				return $returnText.$endText;
			}
		}
		return $returnText;
	}
}

if ( ! function_exists('time_diff'))
{
	function time_diff($time, $option = '')
	{
	// 占쏙옙占썲��占� ��⑨옙占쏙옙占�
		$cur_time = time();
	    $ref_time = $time;
		
		$cur_date = floor($cur_time / 86400);
		$ref_date = floor($ref_time / 86400);
	
		$datetimediff = $cur_time - $ref_time;
		$datedist = $cur_date - $ref_date;
		$datediff = floor($datetimediff / 86400);
		$weekdiff = floor($datediff / 7);
		$timediff = $datetimediff % 86400;
	
		$hour = floor($timediff / 3600);
		$min = floor($timediff % 3600 / 60);
	
		$result = "";
		if ($datedist>34) {
			$result = date("Y占쏙옙占� n占쏙옙占� j占쏙옙占�", $ref_time);
		} else if ($weekdiff>0) {
			$result = $weekdiff . "雅�占� 占쏙옙占�";
		} else {
			if ($datediff>0) {
				$result = $datedist . "占쏙옙占� 占쏙옙占�";
			} else if ($timediff<=0) {
				$result = "1��ο옙 占쏙옙占�";
			} else {
				if ($hour) $result = $hour . "占쏙옙占썲��占�";
				else if ($min) $result = $min . "��븝옙";
				if ($result) $result .= " 占쏙옙占�";
			}
		}
		if ($option=='ALL') {
			$result = "";
			if ($datediff) $result .= ($result?" ":"") . $datediff."占쏙옙占�";
			if ($hour) $result .= ($result?" ":"") . $hour."占쏙옙占썲��占�";
			if ($min) $result .= ($result?" ":"") . $min ."��븝옙";
			$result .= " 占쏙옙占�";
		}
		$timediff = $result;
		
		return $timediff;
	}
}

// ��얜��占쏙옙占쏙옙占� 野�占쏙옙占쏙옙占쏙옙占� UTF8 ��얜��占쏙옙揶�占� 占쏙옙占쏙옙占쏙옙筌�占� UTF8��얜��占쏙옙嚥∽옙 癰�占쏙옙占쏙옙 占쏙옙占썼�놂옙雅���곤옙占� function
if ( ! function_exists('ChkCng2UTF'))
{
	function ChkCng2UTF($utfStr) {
	  if (iconv("UTF-8","UTF-8",$utfStr) == $utfStr) {
	    return $utfStr; 
	  }
	  else {
	  	//return mb_convert_encoding($utfStr,"UTF-8","EUC-KR");
	    return iconv("EUC-KR","UTF-8",$utfStr); 
	  }
	}
}
// ��얜��占쏙옙占쏙옙占� 野�占쏙옙占쏙옙占쏙옙占� UTF8 ��얜��占쏙옙揶�占� 占쏙옙占쏙옙占쏙옙筌�占� UTF8��얜��占쏙옙嚥∽옙 癰�占쏙옙占쏙옙 占쏙옙占썼�놂옙雅���곤옙占� function
if ( ! function_exists('ChkCng2EUC'))
{
	function ChkCng2EUC($utfStr) {
	  if (iconv("EUC-KR","EUC-KR",$utfStr) == $utfStr) {
	    return $utfStr; 
	  }
	  else {
	  	//return mb_convert_encoding($utfStr,"UTF-8","EUC-KR");
	    return iconv("UTF-8","EUC-KR",$utfStr); 
	  }
	}
}


function date_to_timeline($datatime)
{
	$timeDiff_sec = (mktime() - strtotime($datatime));

	if($timeDiff_sec < 60)
		$timeDiff_sec = "鈺곌��占쏙옙 占쏙옙占�";
	elseif($timeDiff_sec < 3600)
		$timeDiff_sec = sprintf("%d",$timeDiff_sec/60)." ��븝옙 占쏙옙占�";
	elseif($timeDiff_sec < 86400)
		$timeDiff_sec = sprintf("%d",$timeDiff_sec/60/60)." 占쏙옙占썲��占� 占쏙옙占�";
	else
		$timeDiff_sec = sprintf("%d",$timeDiff_sec/86400)."占쏙옙占� 占쏙옙占�";
		
	return $timeDiff_sec;
}

//占쏙옙占쏙옙占쏙옙甕곤옙占쏙옙占� 占쏙옙���占쎈��占쏙옙占쏙옙占쏙옙占쎈��占쏙옙 獄�占쏙옙占쏙옙占쏙옙占쏙옙占쏙옙 占쏙옙��ο옙占�
function phone_number_format_ck($str='') {

	$number = preg_replace('/[^0-9]/','',$str);
	switch(strlen($number)){
		case 7:;
		case 8:;
			$pattern = '/^(.{4})(.*)$/';
			$replace = '$1-$2';
			break;
		case 9:;
		case 10:;
		case 11:;
		case 12:
			$pattern = '/^(02|0.{2}|.{4})(.*)(.{4})$/';
			$replace = '$1-$2-$3';
			break;
	}
	if(!isset($pattern)){ return false; }
	return preg_replace($pattern,$replace,$number);
}
