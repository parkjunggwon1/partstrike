<?
session_start();

require  $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";

// Database 연결
$id	= $adminid;
$pwd	= $adminpwd;
$gubun	= $admin_gubun;

	//로그인처리
	$sql = "SELECT * FROM admin WHERE admin_id = '$id' and admin_etc1 = 'Y'";
	$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
	$row=mysql_fetch_array($result);
	
	$real_admin_pwd = $row["admin_pwd"];
	$real_admin_idx = $row["admin_idx"];
	$real_admin_id = $row["admin_id"];
	$real_admin_name = $row["admin_name"];
	$real_admin_gubun = $row["admin_gubun"];
	$real_admin_etc1 = $row["admin_etc1"];
	$real_admin_tel = $row["admin_tel"];
	$real_admin_mail = $row["admin_mail"];
	if($real_admin_etc1!="Y"){
		Page_Msg("사용할 수 없는 아이디입니다.");
		exit;
	}
	if($real_admin_pwd==$pwd){
		// 쿠키 생성
		$_SESSION["ADMIN_IDX"]	=$real_admin_idx;			// idx
		$_SESSION["ADMIN_ID"]	=$real_admin_id;			// id
		$_SESSION["ADMIN_NAME"]	=$real_admin_name;				// 이름
		$_SESSION["ADMIN_GUBUN"]=$real_admin_gubun;				// 로그인 구분
		$_SESSION["ADMIN_TEL"]	=$real_admin_tel;	
		$_SESSION["ADMIN_ETC1"]	=$real_admin_etc1;	
		$_SESSION["ADMIN_MAIL"]	=$real_admin_mail;	
		if ($_SESSION["ADMIN_ID"]){
			Page_Parent_Url("/admin/cate/cate.php?mode=DD002");
		}
	} else {
		Page_Msg("아이디와 비밀번호를 정확하게 입력하세요.");
		exit;
	}
?>
