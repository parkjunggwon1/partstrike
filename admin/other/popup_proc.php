<?
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include $_SERVER["DOCUMENT_ROOT"]."/admin/include/admin.php";
include $_SERVER["DOCUMENT_ROOT"]."/include/fileuploader.php";
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<?

$dir_dest = "../..".$file_path; //파일 저장 폴더 지정
$content=replace_in(str_replace("\r\n", "<br/>" ,$content));


if ($typ=="write"){
	/** 파일 업로드 ******************************************/
	For ($i=1;$i<=1;$i++){
		$query_name = "file".$i; //input 파라메터 이름
		
		if($_FILES[$query_name]) {
			$FILE_1			= RequestFile("file".$i);
			
			$FILE_1_size	= $FILE_1[size];
			$maxSize = '5242880'; //5mb, 파일 용량 제한
			${"filename".$i} = uploadProc( $query_name, $dir_dest, $maxSize);
			//echo $filename1;
		}
	}
	/*******************************************************/

	$sql="
		INSERT INTO popup
			(title
			, content
			, gubun
			, p_top
			, p_left
			, p_wid
			, p_hei
			, use_yn
			, lay_yn
			, scr_yn
			, img_yn
			, url1
			, file1
			, start_date
			, start_time
			, end_date
			, end_time
			, log_date
			, log_ip
			)
		VALUES
			('$title'
			,'$content'
			,'$mode'
			,'$p_top'
			,'$p_left'
			,'$p_wid'
			,'$p_hei'
			,'$use_yn'
			,'$lay_yn'
			,'$scr_yn'
			,'$img_yn'
			,'$url1'
			,'$filename1'
			,'$start_date'
			,'$start_time'
			,'$end_date'
			,'$end_time'
			,'$log_date'
			,'$log_ip'
			)
		";
		//echo $sql;

		$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
		if($result){
			Page_Msg_Url("정상적으로 등록되었습니다.","/admin/other/popup_list.php?mode=$mode");
		}


}
if ($typ == "edit"){
	/** 파일 업로드 ******************************************/
	For ($i=1;$i<=1;$i++){
		if (${"file".$i}){
			$query_name = "file".$i; //input 파라메터 이름
			
			if($_FILES[$query_name]) {
				$FILE_1			= RequestFile("file".$i);
				
				$FILE_1_size	= $FILE_1[size];
				$maxSize = '5242880'; //5mb, 파일 용량 제한
				${"filename".$i} = uploadProc( $query_name, $dir_dest, $maxSize);
				//echo $filename1;
			}

			if(${"file_o".$i}){
				$old_file=${"file_o".$i};
				if(file_exists("$file_path/$old_file")){
					unlink("$file_path/$old_file");
				}
			}
		}else{
			${"filename".$i} = ${"file_o".$i};
		}
	}
	/*******************************************************/

	$sql="
		UPDATE
			popup
		SET
			title='$title'
			, content='$content'
			, p_top='$p_top'
			, p_left='$p_left'
			, p_wid='$p_wid'
			, p_hei='$p_hei'
			, use_yn='$use_yn'
			, lay_yn='$lay_yn'
			, scr_yn='$scr_yn'
			, img_yn='$img_yn'
			, url1='$url1'
			, file1='$filename1'
			, start_date='$start_date'
			, start_time='$start_time'
			, end_date='$end_date'
			, end_time='$end_time'
			, log_date='$log_date'
			, log_ip='$log_ip'			
		WHERE
			idx=$idx
	";
	//echo $sql;
	$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
	if($result){
		Page_Msg_Url("정상적으로 등록되었습니다.","/admin/other/popup_write.php?$param&idx=$idx");	
	}
}
if($typ=="del"){
	if($b_file1!=""){
		if(file_exists("$dir_dest/$b_file1")){
			unlink("$dir_dest/$b_file1");
		}
	}
	
	$sql="
		delete from popup where bd_idx='$idx'
		";
	//echo $sql;
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	if($result){
		Page_Msg_Url("삭제되었습니다.","/admin/other/popup_list.php?mode=$mode");
	}
}

if($typ=="alldel"){
	 $no = $_POST[delchk];
	 for($i=0; $i<count($no); $i++){
		//인서트 처리
		$sql="
			delete from board where bd_idx in($no[$i])
			";
			//echo $no[$i];
		$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	 }
	
	if($result){
		Page_Msg_Url("삭제되었습니다.","/admin/board/board_list.php?mode=$mode");
	}
}


?>
