<?

Function QRY_BOARD_LISTNO($cnt,$searchand){

	$conn = dbconn();

	$sql = "
			SELECT * FROM
				board2
			WHERE
				1=1 $searchand  
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
				board2
			WHERE
				1=1 $searchand
			order by
				bd_idx DESC
			LIMIT $startno,$recordcnt
			";

			mysql_query( "SET NAMES utf8");

	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());

	return $result;
}

Function QRY_BOARD_LIST_CLIENT($recordcnt,$searchand,$page){

	$conn = dbconn();

	$startno = ($page-1) * $recordcnt;

	$sql = "
			SELECT * FROM
				board2
			WHERE
				1=1 $searchand
			order by
				bd_sort asc, bd_idx desc
			LIMIT $startno,$recordcnt
			";

	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());

	return $result;
}


Function QRY_BOARD_VIEW($idx){

	$conn = dbconn();

	$sql = "
			SELECT * FROM
				board2
			WHERE
				1=1 and bd_idx='$idx'
			";


			mysql_query( "SET NAMES utf8");

	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());

	return $result;
}

Function QRY_BOARD_VIEW_TOP($searchand,$idx){

	$conn = dbconn();

	$sql = "
			SELECT * FROM
				board2
			WHERE
				1=1 $searchand
			order by bd_idx DESC
			LIMIT 1
			";
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());

	return $result;
}


//기본설정=================================================================


//기본설정=================================================================


/*Function QRY_BOARD_LIST()

	'데이터 추출====================================================================
	strsql = "SELECT top "&page * recordcnt & " * from "&tbl&" where 1=1 "& searchand
	strsql =  strsql & orderby
	sqlrs.Open strsql,DBConn,1

End Function

Function QRY_BOARD_LIST()

	orderby = " order by reg_date DESC"

	'데이터 추출====================================================================
	strsql = "SELECT top "&page * recordcnt & " * from "&tbl&" where 1=1 "& searchand
	strsql =  strsql & orderby
	'strsql = "select top 3 * from board where bd_gubun='AA002' order by bd_idx DESC "
	sqlrs.Open strsql,DBConn,1
	'데이터 추출 끝====================================================================
	'response.write strsql

End Function

Function QRY_BOARD_LIST_NO()

	'===========  공지글만 불러오기 ================================================
	strsql_no="select top 10 * from "&tbl&" where bd_gubun='"&mode&"' and bd_notice='y' order by reg_date DESC"
	sqlrs_no.Open strsql_no,DBConn,1
	'===============================================================================

End Function

Function QRY_BOARD_VIEW()
	sql = " select * from  "&tbl&"  where bd_idx = "&idx
	rs.Open sql,DBConn,1
End Function

Function QRY_BOARD_INSERT()
	sql = "insert into "&tbl&"( "&_
			" bd_gubun "&_
			" , bd_cate "&_
			" , bd_mem_idx "&_
			" , bd_mem_name "&_
			" , bd_tel "&_
			" , bd_email "&_
			" , bd_pwd "&_
			" , bd_title "&_
			" , bd_title_sub "&_
			" , bd_content "&_
			" , bd_file1 "&_
			" , bd_file2 "&_
			" , bd_file3 "&_
			" , bd_file4 "&_
			" , bd_file5 "&_
			" , bd_notice "&_
			" , bd_secret "&_
			" , bd_admin "&_
			" , bd_hit "&_
			" , bd_comment_num "&_
			" , bd_ref "&_
			" , bd_lev "&_
			" , bd_step "&_
			" , bd_start_date "&_
			" , bd_end_date "&_
			" , bd_recom "&_
			" , reg_date "&_
			" , reg_ip) "&_
			" values( "&_
			" N'"&mode&"' "&_
			" , N'"&bd_cate&"' "&_
			" , N'"&bd_mem_idx&"' "&_
			" , N'"&bd_mem_name&"' "&_
			" , N'"&bd_tel&"' "&_
			" , N'"&bd_email&"' "&_
			" , N'"&bd_pwd&"' "&_
			" , N'"&bd_title&"' "&_
			" , N'"&bd_title_sub&"' "&_
			" , N'"&bd_content&"' "&_
			" , N'"&file_name1(1)&"' "&_
			" , N'"&file_name1(2)&"' "&_
			" , N'"&file_name1(3)&"' "&_
			" , N'"&file_name1(4)&"' "&_
			" , N'"&file_name1(5)&"' "&_
			" , N'"&bd_notice&"' "&_
			" , N'"&bd_secret&"' "&_
			" , N'"&bd_admin&"' "&_
			" , 0 "&_
			" , 0 "&_
			" , N'"&bd_ref&"' "&_
			" , N'"&bd_lev&"' "&_
			" , N'"&bd_step&"' "&_
			" , N'"&bd_start_date&"' "&_
			" , N'"&bd_end_date&"' "&_
			" , N'"&bd_recom&"' "&_
			" , N'"&log_date&"' "&_
			" , N'"&log_ip&"') "
	DBconn.execute(sql)
End Function

Function QRY_BOARD_UPDATE()
	sql = "update "&tbl&" set "&_
			" bd_cate='"&bd_cate&"' "&_
			" ,bd_mem_name='"&bd_mem_name&"' "&_
			" ,bd_tel='"&bd_tel&"' "&_
			" ,bd_email='"&bd_email&"' "&_
			" ,bd_pwd='"&bd_pwd&"' "&_
			" ,bd_title='"&bd_title&"' "&_
			" ,bd_title_sub='"&bd_title_sub&"' "&_
			" ,bd_content='"&bd_content&"' "&_
			" ,bd_file1='"&file_name1(1)&"' "&_
			" ,bd_file2='"&file_name1(2)&"' "&_
			" ,bd_file3='"&file_name1(3)&"' "&_
			" ,bd_file4='"&file_name1(4)&"' "&_
			" ,bd_file5='"&file_name1(5)&"' "&_
			" ,bd_notice='"&bd_notice&"' "&_
			" ,bd_admin='"&bd_admin&"' "&_
			" ,bd_start_date='"&bd_start_date&"' "&_
			" ,bd_end_date='"&bd_end_date&"' "&_
			" ,bd_recom='"&bd_recom&"' "&_
			" ,edit_date='"&log_date&"' "&_
			" ,edit_ip='"&log_ip&"' "&_
			" where bd_idx='"&idx&"' "
	dbconn.execute(sql)
End Function

Function QRY_BOARD_COMM_WRITE()

	sql = "insert into  board_comment (bc_bd_idx, bc_mem_idx, bc_mem_name,  bc_content, reg_date, reg_ip)"
	sql = sql & " values("&idx&","&comm_mem_idx&",N'"&comm_mem_name&"',N'"&comment&"',N'"&log_date&"',N'"&log_ip&"')"
	'response.write sql
	DBconn.Execute(sql)

	Call plushit("board","bd_comment_num","bd_idx",idx)

End function


Function QRY_BOARD_COMM_DELETE()

	sql = "delete from board_comment where bc_idx='"&comm_idx&"'"
	dbconn.execute(sql)

	Call minushit("board","bd_comment_num","bd_idx",idx)

End Function

Function QRY_BOARD_DELETE()
	for i=1 to filecnt
		if trim(len(uploadform("file_o"&i)))>3 then
			filepath1 = uploadform.DefaultPath & "\" & uploadform("file_o"&i)
			uploadform.DeleteFile filepath1
		end If
	Next


	sql = "delete from board where bd_idx="&idx
	dbconn.execute(sql)

End Function

Function QRY_BOARD_DELETE_ALL()

	delchk = replace_in(UploadForm("delchk"))
	sql = "delete from board where bd_idx in ("&delchk&")"
	dbconn.execute(sql)

End Function

Function QRY_BOARD_SEND_UPDATE()
	sql = "update board_send set "&_
			" read_date='"&log_date&"' "&_
			" where bd_idx='"&idx&"' and mem_idx='"&session("admin_idx")&"' "
			response.write sql
	dbconn.execute(sql)
End Function

*/
?>
