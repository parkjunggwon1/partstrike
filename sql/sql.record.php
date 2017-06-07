<?
function QRY_MYMEMBER_LIST($session_mem_idx, $session_rel_idx){
	if ($session_rel_idx == "0"){
		$searchand = "mem_idx= $session_mem_idx or rel_idx = $session_mem_idx";
	}else{
		$searchand = "mem_idx= $session_mem_idx";
	}
	$conn = dbconn();	
	$sql = "SELECT mem_idx, case when rel_idx = 0 then mem_nm_en else concat(mem_nm_en,'/',pos_nm_en) end as name  FROM member where $searchand
				order by mem_idx";
	
	mysql_query( "SET NAMES utf8");	
//	echo $sql;
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	return $result;

}


Function QRY_RCD_DET_LIST($recordcnt,$searchand,$page,$ord='odr_det_idx'){
	$conn = dbconn();	
	if ($recordcnt > 0) {  //$recordcnt가 넘어오면 그만큼씩 끊어서 페이징 처리. recordcnt가 0으로 넘어오면 전체 다 출력 하겠다는 의미 (엑셀 다운로드 등에서 쓰임)
		$startno = ($page-1) * $recordcnt;
		$limit = "LIMIT $startno,$recordcnt";
	}else{
		$limit = "";
	}

	switch($ord){
		case "odr_det_idx":
			$s_ord=" order by odr_det_idx desc";
			break;
		default:
			$s_ord=" order by a.reg_date desc,c.part_type,(select ifnull(max(reg_date),0) from odr_history where odr_history.odr_det_idx = b.odr_det_idx limit 1) desc";
			break;
	}
	$sql = "
			SELECT *,a.odr_status as order_status,c.quantity as part_stock,c.price as part_price,b.odr_status as odr_det_status, a.period as a_period, b.period as b_period FROM odr a 
			left outer join odr_det b on a.odr_idx = b.odr_idx
			left outer join part c on b.part_idx = c.part_idx 
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

function QRY_RCD_HISTORY_LIST($recordcnt, $searchand, $page, $his_ty , $ord){
	$conn = dbconn();	
	if ($recordcnt > 0) {  //$recordcnt가 넘어오면 그만큼씩 끊어서 페이징 처리. recordcnt가 0으로 넘어오면 전체 다 출력 하겠다는 의미 (엑셀 다운로드 등에서 쓰임)
		$startno = ($page-1) * $recordcnt;
		$limit = " LIMIT $startno,$recordcnt ";
	}else{
		$limit = "";
	}
	$sql = "SELECT a.* , DATE_FORMAT(reg_date,'%d, %b, %Y') reg_date_fmt FROM ".$his_ty."_history a
 			 WHERE 1=1 $searchand
			 ORDER BY $ord
			 $limit
			";      
		//	echo $sql;
	mysql_query( "SET NAMES utf8");		
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	return $result;
}

//거절, 수량부족 메세지 가져오기(해당 건의 주고 받은 내역 전체)
function QRY_RCD_MSG_LIST($odr_det_idx, $stat){
	$conn = dbconn();
	//$sql = "SELECT * FROM odr_history WHERE odr_det_idx = $odr_det_idx AND status = $stat ORDER BY odr_history_idx"; //2016-05-22
	$sql = "SELECT * FROM odr_history WHERE odr_det_idx = $odr_det_idx AND status IN(9,10) ORDER BY odr_history_idx"; //2016-05-22
	mysql_query( "SET NAMES utf8");		
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	return $result;
}

//불량통보 메세지 가져오기(해당 건의 주고 받은 내역 전체) 2016-10-06
function QRY_FTY_MSG_LIST($odr_det_idx){
	$conn = dbconn();
	//$sql = "SELECT * FROM fty_history WHERE odr_det_idx = $odr_det_idx AND status IN(12) ORDER BY fty_history_idx";
	$sql = "SELECT * FROM fty_history WHERE odr_det_idx = '$odr_det_idx' AND length(reason_title) > 0 ORDER BY fty_history_idx";
	mysql_query( "SET NAMES utf8");		
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	return $result;
}

?>