<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<?
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include $_SERVER["DOCUMENT_ROOT"]."/admin/include/admin.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.board.php";

$gubun=replace_in($gubun);
$cate=replace_in($cate);
$title=replace_in($title);
$list_type=replace_in($list_type);
$write_level=replace_in($write_level);
$view_level=replace_in($view_level);
$secret=replace_in($secret);
$fileup=replace_in($fileup);
$comm=replace_in($comm);
$point=replace_in($point);
$display=replace_in($display);
$sort=replace_in($sort);
$headyn = replace_in($headyn);
$headtext = replace_in($headtext);

if ($typ=="write"){
	$sql="
		INSERT INTO board_create
			(gubun
			, cate
			, title
			, list_type
			, write_level
			, view_level
			, secret
			, fileup
			, comm
			, point
			, display
			, sort
			, headyn
			, headtext
			, reg_date
			, reg_ip
			)
		VALUES
			('$gubun'
			,'$cate'
			,'$title'
			,'$list_type'
			,'$write_level'
			,'$view_level'
			,'$secret'
			,'$fileup'
			,'$comm'
			,'$point'
			,'$display'
			,'$sort'
			,'$headyn'
			,'$headtext'
			,'$log_date'
			,'$log_ip'
			)
		";
		//echo $sql;
		$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
		if($result){
			Page_Msg_Url("정상적으로 등록되었습니다.","/admin/board/create_list.php?mode=$mode");
		}
}

if ($typ == "edit"){
	
	$sql="
		UPDATE
			board_create
		SET
			gubun='$gubun'
			,cate='$cate'
			,title='$title'
			,list_type='$list_type'
			,write_level='$write_level'
			,view_level='$view_level'
			,secret='$secret'
			,fileup='$fileup'
			,comm='$comm'
			,point='$point'
			,display='$display'
			,sort='$sort'
			,headyn='$headyn'
			,headtext='$headtext'
		WHERE
			idx=$idx
	";

	$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
	if($result){
		Page_Msg_Url("정상적으로 등록되었습니다.","/admin/board/create_list.php?$param&idx=$idx");	
	}
}

if($typ=="del"){
	$selsql = "select count(*) as cnt from board where bd_gubun='$gubun' ";
	$selresult=mysql_query($selsql,$conn) or die ("SQL ERROR : ".mysql_error());	
	$selrow = mysql_fetch_array($selresult);
	$cnt = $selrow["cnt"];

	if($cnt=="0"){
		$sql="
			delete from board_create where idx='$idx'
			";
		//echo $sql;
		$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
		if($result){
			Page_Msg_Url("삭제되었습니다.","/admin/board/create_list.php?$param");
		}
	}else{
		Page_Msg_Url("해당 게시판에 게시글이 있습니다. 삭제 할 수 없는 게시판입니다.","/admin/board/create_list.php?$param&idx=$idx");
	}
}
if($typ=="that"){
	$sql="
		UPDATE
			board_create
		SET
			$flag='$values'
		WHERE
			idx=$idx
	";
	echo $sql;
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	Page_Msg("정상적으로 변경되었습니다.");
}

?>
