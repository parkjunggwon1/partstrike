<?
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
echo "asdf";

$file_idx = replace_in($file_idx);
$file = replace_in($temp_file);
$mode = replace_in($mode);
$idx = replace_in($idx);
$path = replace_in($path);
$num = replace_in($num);	//포토게시판경우 몇번째 이미지인지 가져온다
$temp = replace_in($temp);	//구분값 (임시이므로 상황에 따라 변경가능함)
$gopath = replace_in($gopath);

if (!$gopath){$gopath = "board";}
If (substr($mode,0,2)=="YY"){
	$sql = "update member set mem_photo='' where mem_idx=$file_idx";
	if($temp=="user"){
		$gopage = "/mypage/m_modify.html";	
	}else{
		$gopage = "/admin/member/member_write.php";
	}
}
If (substr($mode,0,2)=="BB"){
	$sql = "update board set bd_file$num='' where bd_idx=$file_idx";
	if($temp=="user"){
		$gopage = "/cs/qna_write.php?idx=".$idx;	
	}else{
		$gopage = "/admin/".$gopath."/board_write.php";
	}
}
If (substr($mode,0,2)=="CC"){
	$sql = "update popup set file$num='' where idx=$file_idx";	
	$gopage = "/admin/other/popup_write.php";
}

If (substr($mode,0,2)=="NN"){
	$sql = "update banner set bn_file$num='' where bn_idx=$file_idx";	
	$gopage = "/admin/other/banner_write.php";
}
If ($mode=="DD003"){
	$sql = "update agency set agency_file1='' where idx=$file_idx";	
	$gopage = "/admin/agency/agency_write.php";
	
}

If ($file_idx and $sql) {
	$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());

	//파일삭제
	if($file!=""){
		if(file_exists("$path/$file")){
			unlink("$path/$file");
		}
	}
	
	?>
	<script type="text/javascript">		
		parent.location.href = "<?=$gopage?>?<?=$param?>&idx=<?=$idx?>&typ=edit"
	</script>
<? } ?>
