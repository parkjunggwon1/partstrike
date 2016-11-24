<?

Function QRY_BOARD_LISTNO($cnt,$searchand){
	
	$conn = dbconn();
	$sql = "
			SELECT * FROM 
				board	
			WHERE
				1=1 $searchand and bd_notice='y'
			order by
				bd_idx DESC
			LIMIT $cnt
			";
		
	mysql_query( "SET NAMES utf8");	
	$resultno=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	return $resultno;
}



Function QRY_BOARD_LIST($recordcnt,$searchand,$page){

	$conn = dbconn();	
	$startno = ($page-1) * $recordcnt;
	$sql = "
			SELECT * FROM 
				board	
			WHERE
				1=1 $searchand
			order by
				bd_ref DESC,  bd_lev
			LIMIT $startno,$recordcnt
			";
//			echo $sql;
	mysql_query( "SET NAMES utf8");	
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	return $result;
}

Function QRY_BOARD_LIST_ORDER($recordcnt,$searchand,$page){

	$conn = dbconn();	
	$startno = ($page-1) * $recordcnt;
	$sql = "
			SELECT * FROM 
				board	
			WHERE
				1=1 $searchand
			order by 
			case bd_sort
			when 0 then 999
			else bd_sort
			end asc,bd_idx asc
			LIMIT $startno,$recordcnt
			";

//			echo $sql;
	mysql_query( "SET NAMES utf8");	
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	return $result;
}


Function QRY_BOARD_VIEW($idx){

	$conn = dbconn();	
	$sql = "
			SELECT * FROM 
				board	
			WHERE
				1=1 and bd_idx='$idx' 
			";                      
			
	mysql_query( "SET NAMES utf8");		
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	return $result;
}

Function QRY_BOARD_VIEW2($mode){

	$conn = dbconn();	
	$sql = "
			SELECT * FROM 
				board	
			WHERE
				1=1 and bd_gubun='$mode' 
			order by bd_idx DESC
			LIMIT 0,1
			";                      
	mysql_query( "SET NAMES utf8");		
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	return $result;
}


function QRY_PRODUCT_LIST($searchand){
	$conn = dbconn();	
	$sql = "select bd_idx, bd_gubun, bd_cate, bd_title, bd_title_sub, bd_mem_level, bd_content, bd_file0 from board 
			where 1=1 $searchand";
 //echo $sql;
	 $result=mysql_query($sql,$conn) or die ("SQL ERROR(QRY_PRODUCT_LIST) : ".mysql_error());

 return $result;
}

function QRY_SEARCH_LIST($searchand){
	$conn = dbconn();	
	$sql = "SELECT b.bd_idx, bd_gubun, bd_cate, bd_title, bd_title_sub, bd_mem_level, bd_day,bd_content, bd_file0 , bd_file1 FROM search_link a 
			left outer join board b on a.bd_idx = b.bd_idx WHERE 1=1 $searchand order by bd_sort, bd_idx DESC";
//echo $sql;
	 $result=mysql_query($sql,$conn) or die ("SQL ERROR(QRY_SEARCH_LIST) : ".mysql_error());

 return $result;
}




/************관리자 설문조사 리스트*************/
Function QRY_POLL_LIST($recordcnt,$searchand,$page){

	$conn = dbconn();	
	$startno = ($page-1) * $recordcnt;
	$sql = "
			SELECT * FROM 
				lotto_poll	
			WHERE
				1=1 $searchand
			order by
				po_id DESC
			LIMIT $startno,$recordcnt
			";
	mysql_query( "SET NAMES utf8");	
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	return $result;
}

/************설문조사 보기*************/
Function QRY_POLL_VIEW($idx){

	$conn = dbconn();	
	$sql = "
			SELECT * FROM 
				lotto_poll	
			WHERE
				1=1 and po_id='$idx' 
			";                      
			
	mysql_query( "SET NAMES utf8");		
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	return $result;
}

/************차단IP가져오기*************/
Function GET_INERCEPT_IP(){
	$conn = dbconn();	
	$sql = " SELECT * FROM config_ip ";                      
			
	mysql_query( "SET NAMES utf8");		
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	$row = mysql_fetch_array($result);
	return $row[cf_intercept_ip];
}


Function QRY_BOARD_VIEW_TOP($searchand,$idx){

	$conn = dbconn();	
	$sql = "
			SELECT * FROM 
				board	
			WHERE
				1=1 $searchand
			order by bd_idx DESC
			LIMIT 1
			";
	mysql_query( "SET NAMES utf8");	
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	return $result;
}

Function QRY_CATE_LIST($recordcnt,$searchand,$page){

	$conn = dbconn();	
	$startno = ($page-1) * $recordcnt;
	$sql = "
			SELECT * FROM 
				board_cate	
			WHERE
				1=1 $searchand
			order by
				sort,idx DESC
			LIMIT $startno,$recordcnt
			";

	mysql_query( "SET NAMES utf8");			
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	return $result;
}

Function QRY_CATE_VIEW($idx){
	
	$conn = dbconn();	
		
	$sql = "
			SELECT * FROM 
				board_cate	
			WHERE
				1=1 and idx='$idx' 
			
			";                        
			
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	return $result;
}

Function QRY_CREATE_LIST($recordcnt,$searchand,$page){

	$conn = dbconn();	
	$startno = ($page-1) * $recordcnt;

	if (!$create_orderby){
		$create_orderby = " order by cate,sort,idx DESC";
	}
	$sql = "
			SELECT * FROM 
				board_create	
			WHERE
				display='Y' $searchand
			$create_orderby
			
			";
		//LIMIT $startno,$recordcnt
	mysql_query( "SET NAMES utf8");			
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	return $result;
}

Function QRY_CREATE_VIEW($idx){

	$conn = dbconn();	
	$sql = "
			SELECT * FROM 
				board_create	
			WHERE
				1=1 and idx='$idx' 
			";                        
			
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	return $result;
}

Function QRY_CATE($idx){

	$conn = dbconn();	
	$sql = "
			SELECT title FROM 
				board_cate	
			WHERE
				1=1 and idx='$idx' 
			";                        
			
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	$row = mysql_fetch_array($result);
	$cate_title = $row["title"];
	return $cate_title;
}

Function QRY_COMM_LIST($recordcnt,$searchand,$page){

	$conn = dbconn();	
	$startno = ($page-1) * $recordcnt;
	$sql = "
			SELECT * FROM 
				board_comment	
			WHERE
				1=1 $searchand
			order by
				lev , step
			LIMIT $startno,$recordcnt
			";

	mysql_query( "SET NAMES utf8");			
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	return $result;
}

Function QRY_REPORT_CNT($searchand){
	$conn = dbconn();	
	$sql = "
			select count(*) as CNT from board a, (select distinct(parent_idx) from report where 1=1 $searchand) b
			where a.bd_idx=b.parent_idx
			";
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	$row=mysql_fetch_array($result);
	$total=$row[CNT];
	return $total;
}


Function QRY_REPORT_LIST($recordcnt,$searchand,$page){

	$conn = dbconn();	
	$startno = ($page-1) * $recordcnt;
	$sql = "
			select * from board a, (select distinct(parent_idx) from report where 1=1 $searchand) b
			where a.bd_idx=b.parent_idx order by reg_date DESC
			";
	mysql_query( "SET NAMES utf8");			
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	return $result;
}


Function QRY_CAR_LIST($company_idx){
	$conn = dbconn();
	$sql = "
			SELECT * FROM 
				car	
			WHERE
				company_idx = $company_idx
			order by
				car_name 
			";
		
	mysql_query( "SET NAMES utf8");	
	//echo $sql;
	$result=mysql_query($sql,$conn) or die ("SQL ERROR(QRY_CAR_LIST) : ".mysql_error());
	return $result;

}

Function QRY_CARYEAR_LIST($car_idx){
	$conn = dbconn();
	$sql = "
			SELECT start_year, end_year FROM 
				car	
			WHERE
				car_idx = $car_idx
			";
	mysql_query( "SET NAMES utf8");	
	$result=mysql_query($sql,$conn) or die ("SQL ERROR(QRY_CARYEAR_LIST) : ".mysql_error());
	return $result;

}
include $_SERVER["DOCUMENT_ROOT"]."/include/board_create_view.php";

?>
