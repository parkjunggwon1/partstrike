<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<?
	echo $mode."asdf";

include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include $_SERVER["DOCUMENT_ROOT"]."/admin/include/admin.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.board.php";

$mode=replace_in($mode);
$title=replace_in($title);
$display=replace_in($display);
$sort=replace_in($sort);

if ($typ=="write"){
	

	$sql="
		INSERT INTO board_cate
			(gubun
			, title
			, display
			, sort
			)
		VALUES
			('$mode'
			,'$title'
			,'$display'
			,'$sort'
			)
		";
		//echo $sql;

		$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
		if($result){
			Page_Msg_Url("정상적으로 등록되었습니다.","/admin/board/cate_list.php?mode=$mode");
		}

}
if ($typ == "edit"){
	
	$sql="
		UPDATE
			board_cate
		SET
			title='$title',
			display='$display',
			sort='$sort'
		WHERE
			idx=$idx
	";

	$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
	if($result){
		Page_Msg_Url("정상적으로 등록되었습니다.","/admin/board/cate_list.php?$param&idx=$idx");	
	}
}
if($typ=="del"){
	//$selsql = " select * from "
	$sql="
		delete from board_cate where idx='$idx'
		";
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	if($result){
		Page_Msg_Url("삭제되었습니다.","/admin/board/cate_list.php?mode=$mode");
	}
}

if($typ=="alldel"){
	 $no = $_POST[delchk];
	 for($i=0; $i<count($no); $i++){
		//인서트 처리
		$sql="
			delete from board where bd_idx in($no[$i])
			";
			//echo $no[$i];
		$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	 }
	
	if($result){
		Page_Msg_Url("삭제되었습니다.","/admin/board/board_list.php?mode=$mode");
	}
}

if($typ=="sort"){
	$sql="
		UPDATE
			board_cate
		SET
			sort='$values'
		WHERE
			idx=$idx
	";
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	Page_Msg("정상적으로 변경되었습니다.");
}

if($typ=="display"){
	$sql="
		UPDATE
			board_cate
		SET
			display='$values'
		WHERE
			idx=$idx
	";
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	Page_Msg("정상적으로 변경되었습니다.");
}

?>
