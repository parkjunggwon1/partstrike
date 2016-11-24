<?
session_start();

require  $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";

$real_id = $_SESSION["ADMIN_ID"];

//로그인처리
	$sql = "select * from admin WHERE admin_id = '$real_id'";
	$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
	$row=mysql_fetch_array($result);

	if($row){
		$real_admin_idx = $row["admin_idx"];
		$real_admin_pwd = $row["admin_pwd"];

		if ($now_pwd!=$real_admin_pwd){
			Page_Msg("현재 비밀번호를 확인해주세요.");
		}else{
			$sql="
				UPDATE
					admin
				SET
					admin_id='$id',
					admin_pwd='$chg_pwd',
					admin_tel='$tel',
					admin_mail='$mail',
					admin_name='$name',
					ship_info='$ship_info',
					ship_account_no='$ship_account_no'
				WHERE
					admin_idx = '$real_admin_idx'
			";
			$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
			if($result){
				$_SESSION["ADMIN_ID"]=	$id;
				$_SESSION["ADMIN_NAME"]=	$name;
				$_SESSION["ADMIN_TEL"]=	$tel;
				$_SESSION["ADMIN_MAIL"]=	$mail;
				Page_Parent_Msg_Url("정상적으로 처리되었습니다.","/admin/change/change.php?mode=ZZ010");
			}
		}
		
	}
	
?>