<?
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
/////파츠에서는 아이디 체크만 함.
$error_count = 0;
$error_desc = "";
$val = $val;	//넘어오는 값
$typ = $typ;	//아이디,패스워드,이메일 같은 타입
$txt = $txt;    //결과에 나올 텍스트
$m_idx = $m_idx;    //회원인덱스

if ($typ=="id") {
	$valid = validId($val,5,15);	
}else if($typ=="pwd"){
	$valid = validPwd($val,6,12);
}else if($typ=="nickname") {
	$valid = validNickname($val,2,10);
}else if($typ=="email") {
	$valid = validEmail($val);
}else if($typ=="admin_id") {
	$valid = validId($val,4,12);
}

if ($val=="") {
	$error_count = $error_count + 1;
	//$error_desc = $error_desc . "필수항목입니다. 입력하세요";
}else if ($valid=="false") {
	$error_count = $error_count + 1;
	$error_desc = $error_desc . "잘못된 $txt 형식입니다";
}Else{
	if ($typ=="id" or $typ=="nickname" or $typ=="email" or $typ=="admin_id") {
		if($typ=="admin_id"){
			$tbl = "admin";
			$whereqry= " $typ ='$val' ";
		}else{
			$tbl = "member";
			$whereqry= " mem_$typ='$val' ";
			//IF($rel_idx){
			$sql = $sql. " and rel_idx='$rel_idx'";
			//}
		}
		$sql = "Select count(*) as cnt from $tbl where $whereqry $sql";
		
			
		

		//echo $sql;
		$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
		$row = mysql_fetch_array($result);

		If ($row["cnt"] > 0) {
			$error_count = $error_count + 1;
			$error_desc = $error_desc . "사용중인 $txt 입니다. $m_idx";
		}
	} 

	
}

if ($error_count == 0) {
	echo "0";
}else{
	echo $error_desc;
}
?>
