<?

Function QRY_MEMBER_LIST($recordcnt,$searchand,$page){
	$conn = dbconn();
	if ($recordcnt && $page){
		$startno = ($page-1) * $recordcnt;
		$limit = "LIMIT $startno,$recordcnt";
	}
	$sql = "
			SELECT * FROM 
				member	
			WHERE
				1=1 $searchand
			order by
				mem_idx asc
			$limit 
			";
			
			mysql_query( "SET NAMES utf8");
			
		//	echo $sql;
	
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());

	return $result;
}

Function QRY_MEMBER_VIEW($col,$val){
	$conn = dbconn();	
	$sql = "
			SELECT * FROM 
				member	
			WHERE
				1=1 and mem_$col = '$val' 
			";                        
//		echo $sql;
			
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());

	return $result;
}

function QRY_ODR_MEMBER_VIEW($odr_idx, $col, $val){
	$conn = dbconn();
	$cnt =QRY_CNT( "odr_member"," and odr_idx = $odr_idx and mem_$col = '$val'");
	
	if ($cnt == 0 ) {
		$sql = "insert into odr_member  (mem_idx, odr_idx , nation, mem_nm, mem_nm_en, pos_nm, pos_nm_en, depart_nm, depart_nm_en, rel_nm,rel_nm_en, birthday,tel , fax,hp,zipcode,dosi,dosi_en,dositxt,dositxt_en,sigungu,sigungu_en,addr,addr_en,addr_det,addr_det_en,email,homepage,homepage_rel,skypeId,rel_idx,rel_id,filelogo,filesign,filereg_no,filecerti1,filecerti2,filecerti3,filecerti4,certi1open_yn,certi2open_yn,filestore1,filestore2,filestore3,filestore4,bank_name,bank_account,bank_user_name,bank_addr,bank_tel,swift_code,rout_no,iban_code,memfee,deposit ) 
				select mem_idx, $odr_idx , nation, mem_nm, mem_nm_en, pos_nm, pos_nm_en, depart_nm, depart_nm_en, rel_nm,rel_nm_en, birthday,tel , fax,hp,zipcode,dosi,dosi_en,dositxt,dositxt_en,sigungu,sigungu_en,addr,addr_en,addr_det,addr_det_en,email,homepage,homepage_rel,skypeId,rel_idx,rel_id,filelogo,filesign,filereg_no,filecerti1,filecerti2,filecerti3,filecerti4,certi1open_yn,certi2open_yn,filestore1,filestore2,filestore3,filestore4,bank_name,bank_account,bank_user_name,bank_addr,bank_tel,swift_code,rout_no,iban_code,memfee,deposit 
				from member 
				where 1=1 and mem_$col = '$val'";	
			$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	}
	
	$sql = "
			SELECT * FROM 
				odr_member	
			WHERE
				1=1 and odr_idx = $odr_idx and mem_$col = '$val' 
			";                        
	//	echo $sql;			
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	return $result;
}

Function QRY_IMPSHIP_LIST($recordcnt,$searchand,$page){
	$conn = dbconn();	
	$startno = ($page-1) * $recordcnt;
	$sql = "
			SELECT * FROM 
				impship	
			WHERE
				1=1 $searchand
			order by
				impship_idx
			LIMIT $startno,$recordcnt
			";			
			mysql_query( "SET NAMES utf8");			
	//		echo $sql;	
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	return $result;
}

Function QRY_IMPSHIP_VIEW($idx){
	$conn = dbconn();	
	$sql = "
			SELECT * FROM 
				impship	
			WHERE
				1=1 and impship_idx = '$idx' 
			";                        
//		echo $sql;
			
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());

	return $result;
}

Function QRY_AGENCY_VIEW($idx){
	$conn = dbconn();	
	$sql = "
			SELECT * FROM 
				agency	
			WHERE
				1=1 and agency_idx = '$idx' 
			";                        
//		echo $sql;
			
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());

	return $result;
}

function QRY_ASSIGN_LIST($rel_idx, $assign_type){
	$conn = dbconn();	
	$sql = "
				SELECT * FROM 
					assign	
				WHERE
					rel_idx = $rel_idx and assign_type = $assign_type
					order by sort
				";               
		//echo $sql;
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	return $result;
}

//2016-06-22 ccolle
//회원정보 : 국제 배송비의 '국가' 목록(추가된것 제외)
function QRY_FREIGHT_NATION($rel_idx){
	$conn = dbconn();
	//국가목록
	$sql = "SELECT f_dest_idx FROM freight_charge WHERE trade_type = 0 AND rel_idx=$rel_idx";
	$result=mysql_query($sql,$conn) or die ("SQL ERROR(QRY_COMMON_LIST) : ".mysql_error());
	for ($i=0; $row = mysql_fetch_array($result); $i++) {
		$a_nation = $row["f_dest_idx"];
		($i==0)? $na_data = $a_nation : $na_data .= ",".$a_nation;
	}
	$sql = "select dtl_code, code_desc 
		   FROM code_group_detail 
		   where grp_code ='NA' and code_depth=1 and use_yn='Y'";
	if($i>0){
		$sql .= " AND dtl_code NOT IN($na_data)";
	}
	$sql.= "ORDER BY code_seq ";	
	$result=mysql_query($sql,$conn) or die ("SQL ERROR(QRY_COMMON_LIST) : ".mysql_error());
	return $result;
}
//2016-07-07 : 국제 배송비 '국가'목록(추가된것 포함 전체)
function QRY_FREIGHT_NATION2($rel_idx){
	$conn = dbconn();
	//국가목록
	$sql = "select dtl_code, code_desc 
		   FROM code_group_detail 
		   where grp_code ='NA' and code_depth=1 and use_yn='Y' ORDER BY code_seq";
	$result=mysql_query($sql,$conn) or die ("SQL ERROR(QRY_COMMON_LIST) : ".mysql_error());
	return $result;
}

//2016-06-22
function QRY_FREIGHT_DLVR($rel_idx, $trade_type){
	$conn = dbconn();	
	$sql = "
				SELECT * FROM 
					freight_charge	
				WHERE
					rel_idx = $rel_idx and trade_type = $trade_type
					order by freight_idx ASC
				";               
		//echo $sql;
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	return $result;
}

//2016-07-06
//회원정보 : 국내 배송비의 '도시' 목록(기 추가 제외)
function QRY_FREIGHT_CITY($rel_idx, $nation){
	$conn = dbconn();

	//도시목록
	$sql = "SELECT f_dest_idx FROM freight_charge WHERE trade_type = 1 AND rel_idx=$rel_idx";
	$result=mysql_query($sql,$conn) or die ("SQL ERROR(QRY_COMMON_LIST) : ".mysql_error());
	for ($i=0; $row = mysql_fetch_array($result); $i++) {
		$a_citi = $row["f_dest_idx"];
		($i==0)? $ct_data = $a_citi : $ct_data .= ",".$a_citi;
	}
	$sql = "select dtl_code, code_desc 
		   FROM code_group_detail 
		   where grp_code ='NA' and dtl_par_code=$nation and code_depth=2 and use_yn='Y'";
	if($i>0){
		$sql .= " AND dtl_code NOT IN($ct_data)";
	}
	$sql.= "ORDER BY code_seq ";	

	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	return $result;
}

//2016-07-17 회원정보 : 국내 배송비의 '도시' 목록(기 추가 포함)
function QRY_FREIGHT_CITY2($rel_idx, $nation){
	$conn = dbconn();

	$sql = "select dtl_code, code_desc 
		   FROM code_group_detail 
		   where grp_code ='NA' and dtl_par_code=$nation and code_depth=2 and use_yn='Y' ORDER BY code_seq";

	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	return $result;
}
?>
