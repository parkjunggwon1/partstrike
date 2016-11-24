<?php


//SQL Injection 공격 방지
function addSlash() {
	if (!get_magic_quotes_gpc()) {

		foreach($_POST as $k => $v) {
			$_POST[$k] = addslashes($v);
		}

		foreach($_GET as $k => $v) {
			$_GET[$k] = addslashes($v);
		}

		foreach($_SERVER as $k => $v) {
			$_SERVER[$k] = addslashes($v);
		}

		foreach($_COOKIE as $k => $v) {
			$_COOKIE[$k] = addslashes($v);
		}

	}
}

//SQL Injection 공격 방지
function cleanQuery($string) {
	if(get_magic_quotes_gpc()) { // prevents duplicate backslashes
		$string = stripslashes($string);
	}

	if (phpversion() >= '4.3.0') {
		$string = mysql_real_escape_string($string);
	} else {
		$string = mysql_escape_string($string);
	}

	return $string;
}

function clean($input) {
	if(is_array($input)){
		foreach( $input as $key => $value) {
			$input[$key] = $this->clean($value);
		}
		return $input;
	} else {
		$input = addslashes(strip_tags(trim($input)));
		return $input;
	}
}


//경고창
function popupMsg($string) {
	$string = str_replace("'", "\'", $string);
	$string = "<script> alert('".$string."')</script>";

	echo $string;
}

//경고창
function popupMsgBack($string) {
	$string = str_replace("'", "\'", $string);
	$string = "<script> alert('".$string."')
				history.back();
				</script>";
	
	echo $string;
}
//비밀번호
function encPassword($string) {
	$string = sha1(md5(md5(sha1(md5(sha1(sha1(md5($string))))))));

	return $string;
}


function strCut($str, $len, $suffix) {
	$str = strip_tags($str);
	if ($len >= strlen($str)) return $str;
	$len2 = $len - 1;

	while(ord($str[$len2]) & 0x80) $len2--;

	$str = substr($str, 0, $len - (($len + $len2 + 1) % 2)) . $suffix;

	return $str;
}
?>