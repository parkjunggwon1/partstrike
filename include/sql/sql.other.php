<?

Function QRY_POPUP_LIST($recordcnt,$searchand,$page){

	$conn = dbconn();	
	$startno = ($page-1) * $recordcnt;
	$sql = "
			SELECT * FROM 
				popup	
			WHERE
				1=1 $searchand
			order by
				idx DESC
			LIMIT $startno,$recordcnt
			";
	mysql_query( "SET NAMES utf8");	
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	return $result;
}

Function QRY_POPUP_VIEW($idx){

	$conn = dbconn();	
	$sql = "
			SELECT * FROM 
				popup	
			WHERE
				1=1 and idx='$idx' 
			";                      
	mysql_query( "SET NAMES utf8");		
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	return $result;
}

Function QRY_BANNER_LIST($recordcnt,$searchand,$page){

	$conn = dbconn();	
	$startno = ($page-1) * $recordcnt;
	$sql = "
			SELECT * FROM 
				banner	
			WHERE
				1=1 $searchand
			order by
				bn_idx DESC
			LIMIT $startno,$recordcnt
			";
	mysql_query( "SET NAMES utf8");	
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	return $result;
}

Function QRY_BANNER_VIEW($mode){

	$conn = dbconn();	
	$sql = "
			SELECT * FROM 
				banner	
			WHERE
				1=1 and bn_gubun='$mode' 
			";                      
	mysql_query( "SET NAMES utf8");		
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	return $result;
}

?>