<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<?
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include $_SERVER["DOCUMENT_ROOT"]."/admin/include/admin.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.board.php";
include $_SERVER["DOCUMENT_ROOT"]."/include/fileuploader.php";

$mode=strtoupper(replace_in($mode));

$sql = " update config_ip set cf_intercept_ip = '".trim($_POST['cf_intercept_ip'])."' ";

$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
if($result){
	Page_Msg_Url("정상적으로 등록되었습니다.","/admin/config_ip/ip_write.php");
}

?>
