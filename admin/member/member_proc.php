<?
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include $_SERVER["DOCUMENT_ROOT"]."/admin/include/admin.php";
include $_SERVER["DOCUMENT_ROOT"]."/include/fileuploader.php";
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<?
$mem_email_yn = r_null($mem_email_yn,"N");
$mem_sms_yn = r_null($mem_sms_yn,"N");
$dir_dest = "../..".$file_path; //파일 저장 폴더 지정
$param .= "&start1=$start1&end1=$end1&start2=$start2&end2=$end2&search1=$search1&search2=$search2&search3=$search3&search4=$search4";

if ($typ=="write"){

	//아이디 중복확인
	$use_email=get_want("member","mem_email"," and mem_email = '$mem_email'");
	if ($use_email) {
		Page_Msg_Back("\'$mem_email\' 은(는) 이미 다른분이 사용중인 이메일이므로 사용이 불가합니다.");
		exit;
	}
	/** 파일 업로드 ******************************************/
	For ($i=1;$i<=1;$i++){
		$query_name = "file".$i; //input 파라메터 이름
		
		if($_FILES[$query_name]) {
			$FILE_1			= RequestFile("file".$i);
			
			$FILE_1_size	= $FILE_1[size];
			$maxSize = '5242880'; //5mb, 파일 용량 제한
			${"filename".$i} = uploadProc( $query_name, $dir_dest, $maxSize);
			
		}
	}

	/*******************************************************/
	$sql = " insert into member set 
			mem_email =  '$mem_email'
			,mem_name =  '$mem_name'
			,mem_photo =  '$filename1'
			,mem_pwd =  '$mem_pwd'
			,mem_tel1 =  '$mem_tel1'
			,mem_tel2 =  '$mem_tel2'
			,mem_tel3 =  '$mem_tel2'
			,mem_hp1 =  '$mem_hp1'
			,mem_hp2 =  '$mem_hp2'
			,mem_hp3 =  '$mem_hp3'
			,mem_how =  '$mem_how'
			,mem_email_yn =  '$mem_email_yn'
			,mem_sms_yn =  '$mem_sms_yn'
			,mem_sns =  '3DMAC'
			,reg_date =  '$log_date'
			,reg_ip =  '$log_ip'				
		";
	$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
	if($result){
		Page_Msg_Url("정상적으로 등록되었습니다.","/admin/member/member_list.php?mode=$mode");
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
			member
		SET
			mem_name =  '$mem_name'
			,mem_photo =  '$filename1'
			,mem_pwd =  '$mem_pwd'
			,mem_tel1 =  '$mem_tel1'
			,mem_tel2 =  '$mem_tel2'
			,mem_tel3 =  '$mem_tel2'
			,mem_hp1 =  '$mem_hp1'
			,mem_hp2 =  '$mem_hp2'
			,mem_hp3 =  '$mem_hp3'
			,mem_how =  '$mem_how'
			,mem_email_yn =  '$mem_email_yn'
			,mem_sms_yn =  '$mem_sms_yn'
			,edit_date =  '$log_date'
			,edit_ip =  '$log_ip'				
		WHERE
			mem_idx='$idx'
	";
	
	$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
	if($result){
		Page_Msg_Url("정상적으로 수정되었습니다.","/admin/member/member_write.php?$param&idx=$idx");
	}
}
if($typ=="del"){
	$sql="
		update member set del='1', del_status='Y' , del_memo='$del_memo', del_date='$log_date' where mem_idx='$idx'
		";
	//echo $sql;
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	if($result){
		Page_Msg_Url("탈퇴되었습니다.","./member_list.php?$param");
	}
}

if($typ=="black"){
	plushit("member","black","mem_idx",$idx); 
	Page_Msg("블랙리스트 추가되었습니다.");
}
?>
