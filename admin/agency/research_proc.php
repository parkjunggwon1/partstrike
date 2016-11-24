<?
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include $_SERVER["DOCUMENT_ROOT"]."/admin/include/admin.php";
include $_SERVER["DOCUMENT_ROOT"]."/include/fileuploader.php";
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?
if ($typ=="write"){	
		$sql="
			INSERT INTO research SET
				delivery ='$delivery'
				, account_no = '$account_no'
				, email = '$email'
				, reg_date = '$log_date'
			";
		$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());


		if($result){
			Page_Msg_Url("정상적으로 등록되었습니다.","research.php?mode=$mode");
		}


}
if ($typ == "edit"){	

	$sql="
		UPDATE
			research
		SET
			delivery ='$delivery'
			, account_no = '$account_no'
			, email = '$email'
			, reg_date = '$log_date'
		WHERE
			idx=$idx
	";
	$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
	if($result){
		Page_Msg_Url("정상적으로 수정되었습니다.","research.php?$param&idx=$idx");	
	}
}
if($typ=="del"){
	
	$sql="
		delete from research where idx='$idx'
		";
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	if($result){
		Page_Msg_Url("삭제되었습니다.","research.php?mode=$mode");
	}
}

?>
