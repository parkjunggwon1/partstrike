<? include "dbopen.php" ?>
<?
$gubun = replace_in($gubun);			//테이블명 ex)board
$gubun_idx = replace_in($idx);			//주체의 인덱스값 숫자 ex)bd_idx 
$act = replace_in($act);				//like or report
$mem_idx = $session_mem_idx;			//회원 인덱스값 숫자
$parent = replace_in($parent);			//최상위인덱스(댓글신고시 부모 인덱스가 필요하다, cuz 관리자의 신고글관리)

If($act=="recom") {
	$title = "추천";
}Else If($act=="norecom") {
	$title = "비추천";
}else{
	$title = "신고";
}


$sql = " select * from report where gubun='$gubun' and gubun_idx='$gubun_idx' and act='$act' and mem_idx='$mem_idx' ";
echo $sql;
$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
$row=mysql_fetch_array($result);

If ($row) {	
	Page_Msg("게시글당 한번 만 $title 가능합니다");
} Else {
	$sql="
		INSERT INTO report (gubun, gubun_idx, parent_idx, act, mem_idx, reg_date, reg_ip)
			values('$gubun', '$gubun_idx', '$parent', '$act', '$mem_idx', '$log_date', '$log_ip')
		";
		
	$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
	if($result){

		If ($gubun=="board") {
			plushit($gubun,"bd_$act","bd_idx",$idx);
		} 
		If ($gubun=="board_comment") {
			plushit($gubun,"report","idx",$idx);
		} 

		Page_Msg("$title 하였습니다.");

		If ($act=="recom" or $act=="norecom") {
?>
			<script type="text/javascript">
			<!--		
				obj = parent.document.getElementById("<?=$act?>number<?=$idx?>");
				obj.innerHTML=parseInt(obj.innerHTML)+1;
			//-->
			</script>
<?		}
	}
}
?>
