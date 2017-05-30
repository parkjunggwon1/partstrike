<?
Function QRY_PART_LIST($recordcnt,$searchand,$page,$ord='price'){
	$conn = dbconn();	
	if ($recordcnt > 0) {  //$recordcnt가 넘어오면 그만큼씩 끊어서 페이징 처리. recordcnt가 0으로 넘어오면 전체 다 출력 하겠다는 의미 (엑셀 다운로드 등에서 쓰임)
		$startno = ($page-1) * $recordcnt;
		$limit = "LIMIT $startno,$recordcnt";
	}else{
		$limit = "";
	}

	switch($ord){
		case "part_idx":
			$s_ord=" order by part_idx desc";
			break;
		default:
			$s_ord=" order by price";
			break;
	}
	//2016-12-20 : 삭제됨 품목은 어느 목록에도 비 노출(삭제=>del_chk:0)
	$sql = "
			SELECT * FROM 
				part	
			WHERE
				del_chk='1' $searchand
			$s_ord
			$limit
			";
			
	mysql_query( "SET NAMES utf8");	

	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	return $result;
}

Function QRY_PART_LIST2($recordcnt,$searchand,$page,$ord='price'){
	$conn = dbconn();	
	if ($recordcnt > 0) {  //$recordcnt가 넘어오면 그만큼씩 끊어서 페이징 처리. recordcnt가 0으로 넘어오면 전체 다 출력 하겠다는 의미 (엑셀 다운로드 등에서 쓰임)
		$startno = ($page-1) * $recordcnt;
		$limit = "LIMIT $startno,$recordcnt";
	}else{
		$limit = "";
	}

	switch($ord){
		case "part_idx":
			$s_ord=" order by part_idx desc";
			break;
		default:
			$s_ord=" order by price";
			break;
	}
	//2016-12-20 : 삭제됨 품목은 어느 목록에도 비 노출(삭제=>del_chk:0)
	$sql = "
			SELECT * FROM 
				part	
			WHERE
				1=1 $searchand
			$s_ord
			$limit
			";
	mysql_query( "SET NAMES utf8");	

	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	return $result;
}

Function QRY_TURNKEY_LIST($recordcnt,$searchand,$page){
	$conn = dbconn();	
	if ($recordcnt > 0) {  //$recordcnt가 넘어오면 그만큼씩 끊어서 페이징 처리. recordcnt가 0으로 넘어오면 전체 다 출력 하겠다는 의미 (엑셀 다운로드 등에서 쓰임)
		$startno = ($page-1) * $recordcnt;
		$limit = "LIMIT $startno,$recordcnt";
	}else{
		$limit = "";
	}

	$sql = "
			SELECT * FROM 
				part 
			WHERE
				1=1 $searchand
				order by part_idx desc
			$limit
			";
	mysql_query( "SET NAMES utf8");	
//echo "<tr><td>$sql</td></tr>";
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	return $result;
}

function QRY_PART_CHECK($part_idx)
{
	$conn = dbconn();
	$sql = "select price,quantity,del_chk,part_type from part where part_idx = $part_idx";
			//echo $sql;
	mysql_query( "SET NAMES utf8");	

	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	$part_info = mysql_fetch_object($result);
	return $part_info;
}

?>
