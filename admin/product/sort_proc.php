<?
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include $_SERVER["DOCUMENT_ROOT"]."/admin/include/admin.php";
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?
	for($i=0; $i<$s_count; $i++){
		$sort = $i+1;
		$sql="
			UPDATE
				board
			SET
				bd_sort=$sort		
			WHERE
				bd_idx='$s[$i]' and bd_gubun='$mode'
		";
	//	echo $sql;
		$result = mysql_query($sql,$conn);
	}			
	
	
	if($result){
		Page_Msg_Url("정상적으로 수정되었습니다.","/admin/product/sort_list.php?mode=$mode");
	}	

?>