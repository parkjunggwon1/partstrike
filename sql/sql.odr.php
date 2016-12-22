<?
function QRY_ODR_LIST($recordcnt,$searchand,$page,$ord='odr_idx'){
	$conn = dbconn();	
	$sql = "
			SELECT * FROM odr a
			WHERE
				1=1 $searchand
			order by $ord 
			$limit
			";
	mysql_query( "SET NAMES utf8");	
	//echo $sql;
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	return $result;

}
Function QRY_ODR_DET_LIST($recordcnt,$searchand,$page,$ord='odr_det_idx',$odrby='desc'){
	$conn = dbconn();	
	if ($recordcnt > 0) {  //$recordcnt가 넘어오면 그만큼씩 끊어서 페이징 처리. recordcnt가 0으로 넘어오면 전체 다 출력 하겠다는 의미 (엑셀 다운로드 등에서 쓰임)
		$startno = ($page-1) * $recordcnt;
		$limit = "LIMIT $startno,$recordcnt";
	}else{
		$limit = "";
	}

	switch($ord){
		case "odr_det_idx":
			$s_ord=" order by odr_det_idx $odrby";
			break;
		default:
			$s_ord=" order by odr_det_idx $odrby";
			break;
	}

	$sql = "
			SELECT *,b.quantity as part_stock,a.odr_price as odr_price FROM odr_det a
			left outer join part b on a.part_idx = b.part_idx 
			WHERE
				1=1 $searchand
			$s_ord
			$limit
			";
	mysql_query( "SET NAMES utf8");	
	//echo $sql;
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	return $result;
}

Function QRY_ODR_VIEW($idx){

	$conn = dbconn();	
	$sql = "
			SELECT * ,DATE_FORMAT(reg_date,'%d, %b, %Y') as reg_date_fmt FROM 
				odr
			WHERE
				1=1 and odr_idx='$idx' 
			";                      
			
	mysql_query( "SET NAMES utf8");		
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	return $result;
}

//----------------- 히스토리(주문단계) ----------------------------------------------------------
function QRY_ODR_HISTORY_LIST($recordcnt, $searchand, $page, $ord){
	$conn = dbconn();	
	if ($recordcnt > 0) {  //$recordcnt가 넘어오면 그만큼씩 끊어서 페이징 처리. recordcnt가 0으로 넘어오면 전체 다 출력 하겠다는 의미 (엑셀 다운로드 등에서 쓰임)
		$startno = ($page-1) * $recordcnt;
		$limit = " LIMIT $startno,$recordcnt ";
	}else{
		$limit = "";
	}
	$sql = "SELECT a.* , DATE_FORMAT(reg_date,'%d, %b, %Y') reg_date_fmt FROM odr_history a
 			 WHERE 1=1 $searchand
			 ORDER BY $ord
			 $limit
			";      
		//	echo $sql;
	mysql_query( "SET NAMES utf8");		
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	return $result;
}

function QRY_ODR_DIST_LIST($recordcnt, $searchand, $page, $ord){
	$conn = dbconn();	
	if ($recordcnt > 0) {  //$recordcnt가 넘어오면 그만큼씩 끊어서 페이징 처리. recordcnt가 0으로 넘어오면 전체 다 출력 하겠다는 의미 (엑셀 다운로드 등에서 쓰임)
		$startno = ($page-1) * $recordcnt;
		$limit = " LIMIT $startno,$recordcnt ";
	}else{
		$limit = "";
	}
	$sql = "SELECT distinct odr_idx FROM odr_history a
 			 WHERE 1=1 $searchand
			 ORDER BY $ord
			 $limit
			";      
		//	echo $sql;
	mysql_query( "SET NAMES utf8");		
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	return $result;
}


function QRY_HISTORY_LIST($recordcnt, $searchand, $page, $ord){   //odr 쪽, rcd 쪽 둘다 union
$conn = dbconn();	
	if ($recordcnt > 0) {  //$recordcnt가 넘어오면 그만큼씩 끊어서 페이징 처리. recordcnt가 0으로 넘어오면 전체 다 출력 하겠다는 의미 (엑셀 다운로드 등에서 쓰임)
		$startno = ($page-1) * $recordcnt;
		$limit = " LIMIT $startno,$recordcnt ";
	}else{
		$limit = "";
	}
	$sql = "SELECT a.* , DATE_FORMAT(reg_date,'%d, %b, %Y') reg_date_fmt, 'odr' as  tb_type FROM odr_history a
 			 WHERE 1=1 $searchand
			 union all
			SELECT a . * , DATE_FORMAT( reg_date, '%d, %b, %Y' ) reg_date_fmt, 'rcd' as  tb_type FROM fty_history a
			WHERE 1 =1
			AND (
				CASE WHEN STATUS in (0)
				THEN buy_mem_idx='".$_SESSION["MEM_IDX"]."'
				else reg_mem_idx <> '".$_SESSION["MEM_IDX"]."' and (buy_mem_idx = '".$_SESSION["MEM_IDX"]."' or sell_mem_idx = '".$_SESSION["MEM_IDX"]."')
				END 
			)
			AND confirm_yn = 'N'
			 ORDER BY $ord
			 $limit
			";      
	//	echo $sql;
	mysql_query( "SET NAMES utf8");		
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	return $result;


}

//배송지 변경의 기 저장된 주소 목록
function QRY_DELIVERY_ADDR_LIST($recordcnt,$searchand,$page,$ord='delivery_addr_idx'){
	$conn = dbconn();	
	$sql = "
			SELECT * FROM delivery_addr a
			WHERE
				1=1 $searchand
			order by $ord 
			$limit
			";
	mysql_query( "SET NAMES utf8");	
//	echo $sql;
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	return $result;
}


function QRY_DELIVERY_ADDR_VIEW($idx){
	$conn = dbconn();	
	$sql = "
			SELECT * FROM 
				delivery_addr
			WHERE
				1=1 and delivery_addr_idx='$idx' 
			";                      
			
	mysql_query( "SET NAMES utf8");		
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	return $result;
}

// 저장 내역 중, 납기 받은 품목 발주 시 정상루트 데이터 삭제 proc_ajax.php case"MRO" 에서 사용
function DEL_ORIGIN_PERIOD($actkind){
	$conn = dbconn();
	$param = "
				(SELECT org.odr_idx FROM odr_det AS org
				LEFT JOIN odr_det AS temp
				ON(temp.rel_det_idx = org.odr_det_idx)
				WHERE temp.odr_det_idx IN($actkind) AND temp.odr_status=16)
				";
	//odr
	$sql = "DELETE FROM odr WHERE odr_idx IN ".$param;
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	//odr_history
	$sql = "DELETE FROM odr_history WHERE odr_idx IN ".$param;
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	//ship
	$sql = "DELETE FROM ship WHERE odr_idx IN ".$param;
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	//odr_det
	$sql = "DELETE FROM odr_det WHERE odr_status=16 AND odr_det_idx IN (SELECT rel_det_idx FROM (SELECT rel_det_idx FROM odr_det WHERE odr_det_idx IN ($actkind)) AS C)";
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	return $result;
}
?>