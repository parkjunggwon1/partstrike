<?
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include $_SERVER["DOCUMENT_ROOT"]."/admin/include/admin.php";
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?
if ($typ=="write"){

	//아이디 중복확인
	$use_id=get_want("admin","admin_id"," and admin_id = '$admin_id'");
	if ($use_email) {
		Page_Msg_Back("\'$admin_id' 은(는) 이미 다른분이 사용중인 아이디이므로 사용이 불가합니다.");
		exit;
	}
	$sql = " insert into admin set 
			admin_gubun =  'member'
			,admin_id =  '$admin_id'
			,admin_name =  '$admin_name'
			,admin_name_e =  '$admin_name_e'
			,admin_pwd =  '$admin_pwd'
			,admin_pos =  '$admin_pos'
			,admin_pos_e =  '$admin_pos_e'
			,admin_tel =  '$admin_tel'
			,admin_mail =  '$admin_mail'
			,admin_etc1 =  '$admin_etc1'
			,reg_date =  '$log_date'
		";
	$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
	if($result){
		Page_Msg_Url("정상적으로 등록되었습니다.","/admin/member/admin_list.php?mode=$mode");
	}
}
if ($typ == "edit"){
	$sql="
		UPDATE
			admin
		SET
			admin_name =  '$admin_name'
			,admin_name_e =  '$admin_name_e'
			,admin_pwd =  '$admin_pwd'
			,admin_pos =  '$admin_pos'
			,admin_pos_e =  '$admin_pos_e'
			,admin_tel =  '$admin_tel'
			,admin_mail =  '$admin_mail'
			,admin_etc1 =  '$admin_etc1'			
		WHERE
			admin_idx='$idx'
	";
	
	$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
	if($result){
		Page_Msg_Url("정상적으로 수정되었습니다.","/admin/member/admin_write.php?$param&idx=$idx");
	}
}
if($typ=="del"){
	$sql="
		delete from admin where admin_idx='$idx'
		";
	//echo $sql;
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	if($result){
		Page_Msg_Url("삭제되었습니다.","./admin_list.php?$param");
	}
}
?>
