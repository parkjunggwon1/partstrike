<?
function dbconn(){
	$conn=mysql_connect("localhost","root","wjdrnjs1");  // 서버 /ID/pw
	mysql_select_db("pjg0319", $conn); // DB 명 수정
	mysql_query("SET NAMES UTF8");
	return $conn;
}

//갯수
function QRY_CNT($tbl,$searchand){

	$conn = dbconn();
	
	$sql="
			SELECT
				COUNT(*) AS CNT
			FROM
				$tbl	
			WHERE 1=1 
				$searchand 
		";
		mysql_query( "SET NAMES utf8");
		//echo "<tr><td>".$sql."</td></tr>";
//		echo $sql;
	$result=mysql_query($sql,$conn) or die ("SQL ERROR(QRY_CNT) : ".mysql_error());
	$row=mysql_fetch_array($result);
	$total=$row[CNT];
	return $total;
}

//갯수
function QRY_CNT_GROUP($tbl,$searchand,$grb){

	$conn = dbconn();
	
	$sql="
			SELECT
				COUNT(*) AS CNT
			FROM
				$tbl	
			WHERE 1=1 
				$searchand
			GROUP BY $grb
		";
		mysql_query( "SET NAMES utf8");
		//echo "<tr><td>".$sql."</td></tr>";
//		echo $sql;
	$result=mysql_query($sql,$conn) or die ("SQL ERROR(QRY_CNT) : ".mysql_error());
	$row=mysql_fetch_array($result);
	$total=$row[CNT];
	return $total;
}

//갯수
function QRY_CNT2($c,$tbl,$searchand){

	$conn = dbconn();	
	$sql="
			SELECT
				COUNT($c) AS CNT
			FROM
				$tbl	
			WHERE 1=1 
				$searchand 
		";
		mysql_query( "SET NAMES utf8");
	$result=mysql_query($sql,$conn) or die ("SQL ERROR(QRY_CNT) : ".mysql_error());
	$row=mysql_fetch_array($result);
	$total=$row[CNT];
	return $total;
}
//재고가 0 보다 작은 갯수 2016-04-03 ccolle
//2016-09-11 : 지속적...은 카운트에서 제외.
//2016-11-13 : 턴키도 제외..
function QRY_CNT_STOCK($arrDet){

	$conn = dbconn();	
	$sql="
			SELECT COUNT(a.part_idx) AS CNT FROM part AS a
			LEFT JOIN odr_det AS b
			ON(a.part_idx = b.part_idx)
			WHERE a.part_type NOT IN('2','7') AND b.odr_det_idx IN($arrDet) AND (a.quantity - b.odr_quantity) < 0
		";
		mysql_query( "SET NAMES utf8");
	$result=mysql_query($sql,$conn) or die ("SQL ERROR(QRY_CNT) : ".mysql_error());
	$row=mysql_fetch_array($result);
	$total=$row[CNT];
	return $total;
}

//2016-12-28 : 주문서에서 '가격변동'이 있는 품목 카운트
Function QRY_CNT_FLUC($arrDet){
	$conn = dbconn();	
	$sql="
			SELECT COUNT(a.part_idx) AS CNT FROM part AS a
			LEFT JOIN odr_det AS b
			ON(a.part_idx = b.part_idx)
			WHERE b.odr_det_idx IN($arrDet) AND a.price != b.odr_price
		";
	mysql_query( "SET NAMES utf8");
	$result=mysql_query($sql,$conn) or die ("SQL ERROR(QRY_CNT) : ".mysql_error());
	$row=mysql_fetch_array($result);
	$total=$row[CNT];
	return $total;
}

//2017-03-28 : 파트 존재 여부
Function QRY_CNT_PART($arrDet){
	$conn = dbconn();	
	$sql="
			SELECT COUNT(a.part_idx) AS CNT FROM part AS a
			LEFT JOIN odr_det AS b
			ON(a.part_idx = b.part_idx)
			WHERE b.odr_det_idx IN($arrDet) AND a.del_chk=0
		";
	mysql_query( "SET NAMES utf8");
	$result=mysql_query($sql,$conn) or die ("SQL ERROR(QRY_CNT) : ".mysql_error());
	$row=mysql_fetch_array($result);
	$total=$row[CNT];
	return $total;
}

//총페이지수
Function QRY_TOTALPAGE($cnt,$recordcnt){
	$total_page = (int)($cnt%$recordcnt);

	if ($total_page != 0){ 
		$totalpage = (int)($cnt/$recordcnt)+1;
	} else {
		$totalpage = (int)($cnt/$recordcnt);
	}
	return $totalpage;	
}


function QRY_COMMON_LIST($CommTy ,$ParCode, $Depth, $use_yn = 'Y'){
	$conn = dbconn();
	$sql = "select dtl_code, code_desc, code_desc_en 
		   FROM code_group_detail 
		   where grp_code ='".$CommTy."' and code_depth ".$Depth." and use_yn='$use_yn'";
//		   echo $sql;
  //  if (strlen($ParCode)>0) {
		$sql.= "and dtl_par_code = '".$ParCode."' ";
//	}
	$sql.= "ORDER BY code_seq ";	
	//echo $sql;
	$result=mysql_query($sql,$conn) or die ("SQL ERROR(QRY_COMMON_LIST) : ".mysql_error());
	return $result;

}

//2016-06-14 ccolle
function QRY_COMMON_LIST2($CommTy ,$Depth, $use_yn = 'Y'){
	$conn = dbconn();
	$sql = "select dtl_code, code_desc 
		   FROM code_group_detail 
		   where grp_code ='".$CommTy."' and code_depth=".$Depth." and use_yn='$use_yn'";
	$sql.= "ORDER BY code_seq ";	
	$result=mysql_query($sql,$conn) or die ("SQL ERROR(QRY_COMMON_LIST) : ".mysql_error());
	return $result;
}

function QRY_COMMON_LIST_LANG($CommTy ,$ParCode, $Depth,$lang, $use_yn = 'Y'){
	$conn = dbconn();
	$sql = "select dtl_code, code_desc$lang as code_desc
		   FROM code_group_detail 
		   where grp_code ='".$CommTy."' and code_depth ".$Depth." and use_yn='$use_yn'";
//		   echo $sql;
  //  if (strlen($ParCode)>0) {
		$sql.= "and dtl_par_code = '".$ParCode."' ";
//	}
	$sql.= "ORDER BY code_seq ";	
	//echo $sql;
	$result=mysql_query($sql,$conn) or die ("SQL ERROR(QRY_COMMON_LIST) : ".mysql_error());
	return $result;

}


function QRY_COMMON_LIST_SRCH($CommTy ,$ParCode, $Depth,$srch){
	$conn = dbconn();
	$sql = "select dtl_code, code_desc 
		   FROM code_group_detail 
		   where grp_code ='".$CommTy."' and code_depth ".$Depth." $srch";
//		   echo $sql;
  //  if (strlen($ParCode)>0) {
		$sql.= "and dtl_par_code = '".$ParCode."' ";
//	}
	$sql.= "ORDER BY code_seq ";	
	//echo $sql;
	$result=mysql_query($sql,$conn) or die ("SQL ERROR(QRY_COMMON_LIST) : ".mysql_error());
	return $result;

}
function QRY_COMMON_LIST_SRCH_LANG($CommTy ,$ParCode, $Depth,$srch, $lang){
	$conn = dbconn();
	$sql = "select dtl_code, code_desc$lang as code_desc
		   FROM code_group_detail 
		   where grp_code ='".$CommTy."' and code_depth ".$Depth." $srch ";
//		   echo $sql;
  //  if (strlen($ParCode)>0) {
		$sql.= "and dtl_par_code = '".$ParCode."' ";
//	}
	$sql.= "ORDER BY code_seq ";	
	//echo $sql;
	$result=mysql_query($sql,$conn) or die ("SQL ERROR(QRY_COMMON_LIST) : ".mysql_error());
	return $result;

}

function QRY_PRODUCTTY_LIST($CommTy){
	$conn = dbconn();
	$sql = "SELECT gubun, title FROM `board_create` 
			where substr(gubun,1,2) = 'BB' and substr(gubun,3,3)*1  <=8
			ORDER BY sort
			";
	//echo $sql;
	$result=mysql_query($sql,$conn) or die ("SQL ERROR(QRY_PRODUCT_LIST) : ".mysql_error());
	return $result;

}


function QRY_CATEGORY_LIST($mode, $searchand){
	$conn = dbconn();
	$sql = "SELECT product_type_idx, product_type_name FROM product_type
			where gubun = '$mode' $searchand 
			ORDER BY sort
			";
	//echo $sql;
	$result=mysql_query($sql,$conn) or die ("SQL ERROR(QRY_CATEGORY_LIST) : ".mysql_error());
	return $result;

}


function QRY_CATEGORY_SINGLELIST($mode, $CheckValue){
	$conn = dbconn();
	$sql = "select product_type_name 
		   FROM product_type 
		   where product_type_idx ='".$CheckValue."'  ";
// echo $sql;
	$result=mysql_query($sql,$conn) or die ("SQL ERROR(QRY_COMMON_SINGLELIST) : ".mysql_error());	
	$row = mysql_fetch_array($result);
	$product_type_name = replace_out($row["product_type_name"]);	
	return $product_type_name;
}


function QRY_COMMON_SINGLELIST($CommTy, $CheckValue){
	$conn = dbconn();
	$sql = "select code_desc 
		   FROM code_group_detail 
		   where grp_code ='".$CommTy."' and dtl_code = '".$CheckValue."' ";
// echo $sql;
	$result=mysql_query($sql,$conn) or die ("SQL ERROR(QRY_COMMON_SINGLELIST) : ".mysql_error());	
	$row = mysql_fetch_array($result);
	$code_desc = replace_out($row["code_desc"]);	
	return $code_desc;
}

function QRY_COMMON_SINGLELIST_LANG($CommTy, $CheckValue , $lang){
	$conn = dbconn();
	$sql = "select code_desc$lang as code_desc 
		   FROM code_group_detail 
		   where grp_code ='".$CommTy."' and dtl_code = '".$CheckValue."' ";
// echo $sql;
	$result=mysql_query($sql,$conn) or die ("SQL ERROR(QRY_COMMON_SINGLELIST) : ".mysql_error());	
	$row = mysql_fetch_array($result);
	$code_desc = replace_out($row["code_desc"]);	
	return $code_desc;
}



function QRY_COMMON_MULTILIST($CommTy, $CheckValue){
	$conn = dbconn();
	$sql = "select code_desc 
		   FROM code_group_detail 
		   where grp_code ='".$CommTy."' and dtl_code in (".get_each_single_quotation($CheckValue).") ";
//		   echo $sql;
	$result=mysql_query($sql,$conn) or die ("SQL ERROR(QRY_COMMON_SINGLELIST) : ".mysql_error());	
	return $result;
}

function QRY_WAREA_LIST($ParCode, $Depth){
	$conn = dbconn();
	$sql = "select WC_IDX, CATE_NAME 
		   FROM wcategory_t  
		   where CATE_DEP  ".$Depth." ";
    if ($ParCode!="") {
		$sql.= "and CATE_PARENT ".$ParCode." ";
	}
	$sql.= "ORDER BY cate_name ";	
//	echo $sql;
	$result=mysql_query($sql,$conn) or die ("SQL ERROR(QRY_WAREA_LIST) : ".mysql_error());
	return $result;

}

Function QRY_LIST($tbl,$cnt,$page,$searchand,$ord){
	
	$conn = dbconn();
	$startno = ($page-1) * $cnt;
	
	if($cnt!="all"){
		$limit = "LIMIT  $startno,$cnt ";
	}
	$sql = "
			SELECT * FROM 
				$tbl	
			WHERE
				1=1 $searchand 
			order by
				$ord
				$limit
			";
		//echo $sql;
	mysql_query( "SET NAMES utf8");	
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	return $result;
}

Function QRY_LIST_GROUP($tbl,$cnt,$page,$searchand,$grb){
	
	$conn = dbconn();
	$startno = ($page-1) * $cnt;
	
	if($cnt!="all"){
		$limit = "LIMIT  $startno,$cnt ";
	}
	$sql = "
			SELECT * FROM 
				$tbl	
			WHERE
				1=1 $searchand 
			group  by
				$grb
				$limit
			";
		//echo $sql;
	mysql_query( "SET NAMES utf8");	
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	return $result;
}


Function QRY_VIEW($tbl,$searchand){
	$conn = dbconn();	
	$sql = "
			SELECT * FROM 
				$tbl	
			WHERE
				1=1 $searchand
			";                      
	mysql_query( "SET NAMES utf8");		
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	return $result;
}

Function QRY_C_VIEW($c,$tbl,$searchand,$odrby){
	$conn = dbconn();	
	$sql = "
			SELECT $c FROM 
				$tbl	
			WHERE
				1=1 $searchand
			ORDER BY $odrby
			";                      
	mysql_query( "SET NAMES utf8");		
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	return $result;
}

Function QRY_C_LIST_GROUP($c,$tbl,$cnt,$page,$searchand,$grb){
	
	$conn = dbconn();
	$startno = ($page-1) * $cnt;
	
	if($cnt!="all"){
		$limit = "LIMIT  $startno,$cnt ";
	}
	$sql = "
			SELECT $c FROM 
				$tbl	
			WHERE
				1=1 $searchand 
			group by
				$grb
				$limit
			";
//		echo $sql;
	mysql_query( "SET NAMES utf8");	
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	return $result;
}
Function QRY_C_LIST($c,$tbl,$cnt,$page,$searchand,$ord){
	
	$conn = dbconn();
	$startno = ($page-1) * $cnt;
	
	if($cnt!="all"){
		$limit = "LIMIT  $startno,$cnt ";
	}
	$sql = "
			SELECT $c FROM 
				$tbl	
			WHERE
				1=1 $searchand 
			order by
				$ord
				$limit
			";
	//	echo $sql;
	mysql_query( "SET NAMES utf8");	
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	return $result;
}


Function QRY_DELETE($tbl,$deleteand){
	$conn = dbconn();	
	$sql = " DELETE FROM $tbl WHERE 1=1 $deleteand ";
	//echo $sql;
	mysql_query( "SET NAMES utf8");		
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
}

Function QRY_LIST2($tbl,$cnt,$page,$searchand,$ord){
	
	$conn = dbconn();
	$startno = ($page-1) * $cnt;
	
	if($cnt!="all"){
		$limit = "LIMIT  $startno,$cnt ";
	}
	$sql = "
			SELECT * FROM 
				$tbl	
			WHERE
				1=1 $searchand 			
				$ord
				$limit
			";
		//echo $sql;
	mysql_query( "SET NAMES utf8");	
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	return $result;
}

