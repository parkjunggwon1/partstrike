<?
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include $_SERVER["DOCUMENT_ROOT"]."/admin/include/admin.php";
include $_SERVER["DOCUMENT_ROOT"]."/include/fileuploader.php";
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?
if ($typ=="write"){	
		$sql="
			INSERT INTO exchange SET
				exchange_out ='$exchange_out'
				, exchange_in = '$exchange_in'
				, admin_idx ='".$_SESSION["ADMIN_IDX"]."'
				, reg_date = '$log_date'
			";
		$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());


		if($result){
			Page_Msg_Url("정상적으로 등록되었습니다.","exchange.php?mode=$mode");
		}


}
?>
