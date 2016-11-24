<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<?
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include $_SERVER["DOCUMENT_ROOT"]."/admin/include/admin.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.board.php";
include $_SERVER["DOCUMENT_ROOT"]."/include/fileuploader.php";

$dir_dest = "../..".$file_path; //파일 저장 폴더 지정

if ($typ=="write"){
	/** 파일 업로드 ******************************************/
	For ($i=0;$i<=0;$i++){
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
		INSERT INTO member
			(
			mem_name
			,mem_sex
			,mem_birthday
			,mem_id
			,mem_pwd
			,mem_nickname 
			,mem_mail1
			,mem_mail2 
			,mem_email 
			,mem_photo
			,mem_level
			,mem_class
			,reg_date
			,reg_ip
			)
		VALUES
			(
			'$mem_name'
			,'$mem_sex'
			,'$mem_birthday'
			,'$mem_id'
			,'$mem_pwd'	
			,'$mem_nickname' 
			,'$mem_mail1' 
			,'$mem_mail2'
			,'$mem_mail1@$mem_mail2'
			,'$filename0'
			,'$mem_level'
			,'$mem_class'
			,'$log_date'
			,'$log_ip'
			)
		";
		echo $sql;
		$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
		if($result){
			Page_Msg_Url("정상적으로 등록되었습니다.","/admin/member/member_list.php?mode=$mode");
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
			member
		SET
			mem_name = '$mem_name'
			,mem_sex = '$mem_sex'
			,mem_birthday = '$mem_birthday'
			,mem_pwd = '$mem_pwd'
			,mem_nickname = '$mem_nickname' 
			,mem_mail1 = '$mem_mail1' 
			,mem_mail2 = '$mem_mail2' 
			,mem_email = '$mem_email'  
			,mem_level = '$mem_level' 
			,mem_class = '$mem_class' 
			,mem_photo = '$filename0'
			,edit_date='$log_date'
			WHERE
			mem_idx = '$idx'
	";

	$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
	if($result){
		Page_Msg_Url("정상적으로 등록되었습니다.","/admin/member/member_list.php?$param&idx=$idx");	
	}
}
if($typ=="del"){
	if($b_file1!=""){
		if(file_exists("$dir_dest/$b_file1")){
			unlink("$dir_dest/$b_file1");
		}
	}
	
	$sql="
		delete from member where mem_idx='$idx'
		";
	//echo $sql;
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	if($result){
		Page_Msg_Url("삭제되었습니다.","/admin/member/member_list.php?mode=$mode");
	}
}

if($typ=="alldel"){
	 $no = $_POST[delchk];
	 for($i=0; $i<count($no); $i++){
		//인서트 처리
		$sql="
			delete from member where mem_idx in($no[$i])
			";
			//echo $no[$i];
		$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	 }
	
	if($result){
		Page_Msg_Url("삭제되었습니다.","/admin/member/member_list.php?mode=$mode");
	}
}

?>
