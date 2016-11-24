<?
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include $_SERVER["DOCUMENT_ROOT"]."/admin/include/admin.php";
include $_SERVER["DOCUMENT_ROOT"]."/include/fileuploader.php";
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?
$mode=strtoupper(replace_in($mode));
$name=replace_in($name);
$title=replace_in($title);

$dir_dest = "../..".$file_path; //파일 저장 폴더 지정
if ($mode !="BB001" && $mode != "BB002"){
	$content=replace_in(str_replace("\r\n", "<br/>" ,$content));
}
$comment_comment= replace_in(str_replace("\r\n", "<br>" , $comment_comment));

function get_board_send($mode,$bd_idx,$no){	 
	 for($i=0; $i<count($no); $i++){
		//인서트 처리
		$sql2="
			INSERT INTO board_send SET
				bd_gubun ='$mode'
				, bd_idx ='$bd_idx'
				, mem_idx = '$no[$i]'
			";
		$result2=mysql_query($sql2);
	 }
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
		
	if($mode=="EE002" or $mode=="EE003"){
		$imsi_mode = $mode;
		$mode="EE001";
		if($mem_type=="99"){
			$searchand=" ";
		}else{
			 $mem_type = $_POST[mem_type];
			 for($i=0; $i<count($mem_type); $i++){
				 if($i==0){
					$mem_type_arr = $mem_type[$i];
				 }else{
					$mem_type_arr .= ",".$mem_type[$i];
				 }
			 }
			$searchand=" and mem_type in ($mem_type_arr)";
		}
		$result_mem =QRY_LIST("member","all",$page,$searchand," mem_idx DESC");
		while($row_mem= mysql_fetch_array($result_mem)){
			$send_idx = replace_out($row_mem["mem_idx"]);
			
			$sql="
				INSERT INTO board SET
					bd_gubun ='$mode'
					, bd_cate		= '$cate'
					, bd_mem_name ='$name'
					, bd_send_idx ='$send_idx'
					, bd_title	= '$title'
					, bd_title_sub	= '$bd_title_sub'
					, bd_content = '$content'
					, bd_file0	= '$filename0'
					, bd_file1	= '$filename1'
					, bd_file2	= '$filename2'
					, bd_file3	= '$filename3'
					, bd_notice	= '$notice'
					, bd_admin	= 'Y'
					, bd_hit	= '0'
					, bd_company	= '$company'
					, bd_tel	= '$tel'
					, bd_day	= '$bd_day'
					, bd_secret		= '$secret'
					, reg_date		= '$log_date'
					, reg_ip		= '$log_ip'			
				";
				
			$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
			$max_idx = mysql_insert_id();
			//update_want("board", " bd_ref='$max_idx' ", " and bd_idx='$max_idx' ");	
		}
		$mode=$imsi_mode;
	}else{
		$send_idx=0;
		$sql="
			INSERT INTO board SET
				bd_gubun ='$mode'
				, bd_cate		= '$cate'
				, bd_mem_name ='$name'
				, bd_send_idx ='$send_idx'
				, bd_title	= '$title'
				, bd_title_sub	= '$bd_title_sub'
				, bd_content = '$content'
				, bd_file0	= '$filename0'
				, bd_file1	= '$filename1'
				, bd_file2	= '$filename2'
				, bd_file3	= '$filename3'
				, bd_notice	= '$notice'
				, bd_admin	= 'Y'
				, bd_hit	= '0'
				, bd_company	= '$company'
				, bd_tel	= '$tel'
				, bd_day	= '$bd_day'
				, bd_secret		= '$secret'
				, reg_date		= '$log_date'
				, reg_ip		= '$log_ip'			
			";
		$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
		$max_idx = mysql_insert_id();
	}
	update_want("board", " bd_ref='$max_idx' ", " and bd_idx='$max_idx' ");	
	if($result){
		if($mode=="XX002"){
			$no = $_POST[delchk];
			get_board_send($mode,$max_idx,$no);	
		}
		Page_Msg_Url("정상적으로 등록되었습니다.","$list_url?mode=$mode");
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
			,bd_day='$bd_day'
			,edit_date='$log_date'
			,edit_ip='$log_ip'
			,bd_sort='$bd_sort'
		WHERE
			bd_idx=$idx
	";
	//echo $sql;
	$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
	if($result){
		Page_Msg_Url("정상적으로 수정되었습니다.","$list_url?$param&idx=$idx");	
	}
}
if($typ=="del"){
	if($b_file1!=""){
		if(file_exists("$dir_dest/$b_file1")){
			unlink("$dir_dest/$b_file1");
		}
	}
	if ($mode=="XX002" and $_SESSION["ADMIN_GUBUN"]=="member"){
		$sql="	delete from board_send where bd_idx='$idx' and mem_idx='".$_SESSION["ADMIN_IDX"]."' ";
	}else{
		$sql="	delete from board where bd_idx='$idx'";
	}
	//echo $sql;
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	if($result){
		$sql="delete from board where bd_ref='$idx' ";
		$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());

		Page_Msg_Url("삭제되었습니다.","/admin/board/board_list.php?mode=$mode");
	}
}

if($typ=="alldel"){
	 $no = $_POST[delchk];
	 for($i=0; $i<count($no); $i++){
		//인서트 처리
		if ($mode=="XX002" and $_SESSION["ADMIN_GUBUN"]=="member"){
			$sql="	delete from board_send where bd_idx in($no[$i]) and mem_idx='".$_SESSION["ADMIN_IDX"]."'";
		}else{
			$sql="	delete from board where bd_idx in($no[$i]) ";
		}
		//echo $sql;
		//exit;
		$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());

		$sql="delete from board where bd_ref in($no[$i]) ";
		$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
	 }
	
	if($result){
		
		Page_Msg_Url("삭제되었습니다.","/admin/board/board_list.php?mode=$mode");
	}
}

if($typ=="allpartdel"){
	 $no = $_POST[delchk];
	 for($i=0; $i<count($no); $i++){
		//인서트 처리
			$sql="	delete from part where part_idx in($no[$i]) and part_idx not in (select part_idx from odr_det)";
		//echo $sql;
		//exit;
		$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	 }
	
	if($result){
		
		Page_Msg_Url("삭제되었습니다.","/admin/board/part_list.php?$param");
	}
}

if($typ=="comm_write"){
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
	$lev = $lev+1;
	$step = $step+1;
	$upsql= "UPDATE board SET bd_lev = bd_lev+1 Where bd_ref ='$ref' and bd_lev >=$lev ";
	$upresult = mysql_query($upsql,$conn);
	$sql="
		INSERT INTO board set 
			bd_gubun ='".$mode."'
			, bd_mem_name ='$comment_name'
			, bd_title= '$comment_title'
			, bd_content= '$comment_comment'
			, bd_file1= '$filename1'
			, bd_file2= '$filename2'
			, bd_send_idx= '$send_idx'
			, bd_ref= '$ref'
			, bd_ref2= '$ref2'
			, bd_lev= '$lev'
			, bd_step= '$step'
			, reg_date= '$log_date'
			, reg_ip= '$log_ip'
		";

		$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
		if($result){
			plushit("board","bd_comment_num","bd_idx",$ref);
			if($typ2=="popup"){
				Page_Opener_Url("board_view.php?$param&idx=$ref");
			}
			Page_Url("board_view.php?$param&idx=$ref");
		}

}
if($typ=="comm_del"){
	
	$cnt =QRY_CNT("board"," and bd_ref='$ref' and bd_ref2='$comm_idx' ");

	$sql="delete from board where bd_idx='$comm_idx' ";
	$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());

	$sql="delete from board where bd_ref2='$comm_idx' ";
	$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());

	if($result){		
		minusvalue("board","bd_comment_num","bd_idx",$ref,$cnt+1);
		Page_Url("board_view.php?$param&idx=$ref");
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
		Page_Url("board_view.php?$param&idx=$ref");
	}
}
?>
