<?
if (substr($mode,0,2)=="BB") {
	$cv_sql = "
			SELECT * FROM 
				board_create	
			WHERE
				1=1 and gubun='$mode' 
			";                        
			
	$cv_result=mysql_query($cv_sql,$conn) or die ("SQL ERROR : ".mysql_error());

	$cv_row = mysql_fetch_array($cv_result);
	$cv_idx = replace_out($cv_row["idx"]);		
	$cv_gubun = replace_out($cv_row["gubun"]);
	$cv_cate = replace_out($cv_row["cate"]);
	$cv_title = replace_out($cv_row["title"]);
	$cv_list_type = replace_out($cv_row["list_type"]);	
	$cv_write_level = replace_out($cv_row["write_level"]);
	$cv_view_level = replace_out($cv_row["view_level"]);
	$cv_secret = replace_out($cv_row["secret"]);
	$cv_fileup = replace_out($cv_row["fileup"]);	
	$cv_comm = replace_out($cv_row["comm"]);
	$cv_point = replace_out($cv_row["point"]);
	$cv_display = replace_out($cv_row["display"]);
	$cv_sort = replace_out($cv_row["sort"]);
	$cv_headyn = replace_out($cv_row["headyn"]);
	$cv_headtext = replace_out($cv_row["headtext"]);

	$title_text = $cv_title;
	if($session_mem_class>=$cv_write_level and $cv_write_level>0){
		$write_yn = "Y";
	}
	if(($session_mem_class>=$cv_view_level and $cv_view_level>0) or $cv_view_level==3){
		$view_yn = "Y";
	}

	if($cv_secret=="Y" ){
		$secret_yn = "Y";
	}
}
?>