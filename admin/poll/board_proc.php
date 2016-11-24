<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<?
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include $_SERVER["DOCUMENT_ROOT"]."/admin/include/admin.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.board.php";
include $_SERVER["DOCUMENT_ROOT"]."/include/fileuploader.php";

$mode=strtoupper(replace_in($mode));
$name=replace_in($name);
$title=replace_in($title);


$list_url="board_list.php";



if ($typ=="write"){

	$sql = " insert lotto_poll
                    ( po_subject, po_poll1, po_poll2, po_poll3, po_poll4, po_poll5, po_poll6, po_poll7, po_poll8, po_poll9, po_cnt1, po_cnt2, po_cnt3, po_cnt4, po_cnt5, po_cnt6, po_cnt7, po_cnt8, po_cnt9, po_etc, po_level, po_point, po_date )
             values ( '$_POST[po_subject]', '$_POST[po_poll1]', '$_POST[po_poll2]', '$_POST[po_poll3]', '$_POST[po_poll4]', '$_POST[po_poll5]', '$_POST[po_poll6]', '$_POST[po_poll7]', '$_POST[po_poll8]', '$_POST[po_poll9]', '$_POST[po_cnt1]', '$_POST[po_cnt2]', '$_POST[po_cnt3]', '$_POST[po_cnt4]', '$_POST[po_cnt5]', '$_POST[po_cnt6]', '$_POST[po_cnt7]', '$_POST[po_cnt8]', '$_POST[po_cnt9]', '$_POST[po_etc]', '$_POST[po_level]', '$_POST[po_point]', '$log_date' ) ";

		//echo $sql;

	$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
	if($result){
		Page_Msg_Url("정상적으로 등록되었습니다.","/admin/poll/board_list.php?mode=$mode");
	}

}

if ($typ == "edit"){

	$sql = " update lotto_poll
                set po_subject = '$_POST[po_subject]',
                    po_poll1   = '$_POST[po_poll1]',
                    po_poll2   = '$_POST[po_poll2]',
                    po_poll3   = '$_POST[po_poll3]',
                    po_poll4   = '$_POST[po_poll4]',
                    po_poll5   = '$_POST[po_poll5]',
                    po_poll6   = '$_POST[po_poll6]',
                    po_poll7   = '$_POST[po_poll7]',
                    po_poll8   = '$_POST[po_poll8]',
                    po_poll9   = '$_POST[po_poll9]',
                    po_cnt1    = '$_POST[po_cnt1]',
                    po_cnt2    = '$_POST[po_cnt2]',
                    po_cnt3    = '$_POST[po_cnt3]',
                    po_cnt4    = '$_POST[po_cnt4]',
                    po_cnt5    = '$_POST[po_cnt5]',
                    po_cnt6    = '$_POST[po_cnt6]',
                    po_cnt7    = '$_POST[po_cnt7]',
                    po_cnt8    = '$_POST[po_cnt8]',
                    po_cnt9    = '$_POST[po_cnt9]',
                    po_etc     = '$_POST[po_etc]', 
                    po_level   = '$_POST[po_level]',
                    po_point   = '$_POST[po_point]',
                    po_date    = '$_POST[po_date]'
              where po_id      = '$_POST[idx]' ";

	//echo $sql;
	$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
	if($result){
		Page_Msg_Url("정상적으로 등록되었습니다.","/admin/poll/$list_url?$param&idx=$idx");	
	}
}

if($typ=="del"){
	
	$sql="
		delete from lotto_poll where po_id='$idx'
		";
	//echo $sql;
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	if($result){
		Page_Msg_Url("삭제되었습니다.","/admin/poll/board_list.php?mode=$mode");
	}
}

if($typ=="alldel"){
	 $no = $_POST[delchk];
	 for($i=0; $i<count($no); $i++){
		//인서트 처리
		$sql="
			delete from lotto_poll where po_id in($no[$i])
			";
			//echo $no[$i];
		$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	 }
	
	if($result){
		Page_Msg_Url("삭제되었습니다.","/admin/poll/board_list.php?mode=$mode");
	}
}

?>
