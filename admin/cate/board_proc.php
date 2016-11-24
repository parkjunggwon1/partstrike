<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<?
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include $_SERVER["DOCUMENT_ROOT"]."/admin/include/admin.php";
include $_SERVER["DOCUMENT_ROOT"]."/include/fileuploader.php";

$mode=strtoupper(replace_in($mode));
$name=replace_in($name);
$title=replace_in($title);

$dir_dest = "../..".$file_path; //파일 저장 폴더 지정
$content=replace_in(str_replace("\r\n", "<br/>" ,$content));
$comment= str_replace("\r\n", "<br/>" , $comment);


if ($mode=="ZZ001"){
	$list_url="board_write.php";
} else {
	$list_url="board_list.php";
}
if ($typ=="write"){
	/** 파일 업로드 ******************************************/
	For ($i=0;$i<=5;$i++){
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
		INSERT INTO board
			(bd_gubun
			, bd_cate
			, bd_mem_name
			, bd_site
			, bd_title
			, bd_title_sub
			, bd_content
			, bd_file0
			, bd_file1
			, bd_file2
			, bd_file3
			, bd_notice
			, bd_admin
			, bd_hit
			, bd_company
			, bd_tel
			, bd_email
			, bd_day
			, reg_date
			, reg_ip
			, bd_sort
			, bd_address
			, bd_fax
			)
		VALUES
			('$mode'
			,'$cate'
			,'$name'
			,'$site'
			,'$title'
			,'$title_sub'
			,'$content'
			,'$filename0'
			,'$filename1'
			,'$filename2'
			,'$filename3'
			,'$notice'
			,'Y'
			,0
			,'$company'
			,'$tel'
			,'$email'
			,'$bd_day'
			,'$log_date'
			,'$log_ip'
			,'$bd_sort'
			,'$address'
			,'$fax'
			)
		";
		//echo $sql;

		$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
		if($result){
			Page_Msg_Url("정상적으로 등록되었습니다.","/admin/store/board_list.php?mode=$mode");
		}


}
if ($typ == "edit"){
	/** 파일 업로드 ******************************************/
	For ($i=0;$i<=5;$i++){
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
			board
		SET
			bd_cate='$cate'
			,bd_mem_name='$name'
			,bd_site='$site'
			,bd_title='$title'
			,bd_title_sub='$title_sub'
			,bd_content='$content'
			,bd_file0='$filename0'
			,bd_file1='$filename1'
			,bd_file2='$filename2'
			,bd_file3='$filename3'
			,bd_notice='$notice'
			,bd_company='$company'
			,bd_tel='$tel'
			,bd_email='$email'
			,bd_day='$bd_day'
			,edit_date='$log_date'
			,edit_ip='$log_ip'
			,bd_sort='$bd_sort'
			,bd_address='$address'			
			,bd_fax='$fax'
		WHERE
			bd_idx=$idx
	";
	echo $sql;
	$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
	if($result){
		Page_Msg_Url("정상적으로 등록되었습니다.","/admin/store/$list_url?$param&idx=$idx");	
	}
}
if($typ=="del"){
	if($b_file1!=""){
		if(file_exists("$dir_dest/$b_file1")){
			unlink("$dir_dest/$b_file1");
		}
	}
	
	$sql="
		delete from board where bd_idx='$idx'
		";
	//echo $sql;
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	if($result){
		Page_Msg_Url("삭제되었습니다.","/admin/store/board_list.php?mode=$mode");
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
		Page_Msg_Url("삭제되었습니다.","/admin/store/board_list.php?mode=$mode");
	}
}

if($typ == "saveorder"){
	$no = $_POST[delchk];
	
	for($i=0; $i<count($no); $i++){
		$query_name = "sortorder_".$no[$i]; //input 파라메터 이름
		$ordernum = $_POST[$query_name];
		$sql = "update board set bd_sort = '$ordernum' where bd_idx =$no[$i]";
		//echo $sql."<br>";
		$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	}	

	if($result){
		Page_Msg_Url("저장되었습니다.","/admin/store/board_list.php?mode=$mode");
	}
}

if($typ=="comm_write"){
	$lev = $lev+1;
	$step = $step+1;
	$upsql= "UPDATE board_comment SET lev = lev+1 Where gubun_idx ='$gubun_idx' and lev >=$lev ";
	$upresult = mysql_query($upsql,$conn);
	$sql="
		INSERT INTO board_comment
			(gubun
			, gubun_idx
			, mem_idx
			, mem_id
			, mem_name
			, mem_level
			, title
			, comment
			, ref
			, lev
			, step
			, reg_date
			, reg_ip
			)
		VALUES
			('board'
			,'$gubun_idx'
			,'0'
			,'admin'
			,'$comment_name'
			,'100'
			,'$title'
			,'$comment'
			,'$ref'
			,'$lev'
			,'$step'
			,'$log_date'
			,'$log_ip'
			)
		";

		$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
		if($result){
			plushit("board","bd_comment_num","bd_idx",$ref);
			Page_Url("board_view.php?$param&idx=$gubun_idx");
		}

}
if($typ=="comm_del"){
	if($step=="1"){
		$cntsql=" select count(*) as cnt from board_comment where ref='$comm_idx' ";
		$cntresult = mysql_query($cntsql,$conn) or die ("SQL Error : ". mysql_error());
		$cntrow = mysql_fetch_array($cntresult);
		$cnt = $cntrow["cnt"];
		$otherand= " or ref='$comm_idx' ";
	}
	$cnt = $cnt+1;
	
	$sql="delete from board_comment where idx='$comm_idx' $otherand ";
	$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());

	$sql2="delete from report where gubun='board_comment' and gubun_idx='$comm_idx' ";
	$result2 = mysql_query($sql2,$conn) or die ("SQL Error : ". mysql_error());

	if($result){
		
		minusvalue("board","bd_comment_num","bd_idx",$gubun_idx,$cnt);
		Page_Url("board_view.php?$param&idx=$gubun_idx");
	}

}
if ($typ == "comm_edit"){
	

	$sql="
		UPDATE
			board_comment
		SET
			comment='$comment'			
		WHERE
			idx=$comm_idx
	";
	//echo $sql;
	$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
	if($result){
		Page_Url("board_view.php?$param&idx=$gubun_idx");
	}
}
?>
