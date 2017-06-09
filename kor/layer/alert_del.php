<?
/*********************************************************************************************
**[사용자정의 메세지창] 타이틀, 메세지, 버튼이미지명 pram 받고, 버튼 클릭 시 페이지 새로고침
**********************************************************************************************/
@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";

//$(".btn-area.t-rt button").attr("onclick","alert_msg('처리중입니다.')"); 버튼 클릭시 한번 이상 안눌리게.
if ($alert =="sessionend"){
	$alert_msg = "세션이 종료되었습니다. 다시 로그인이 필요합니다.";
}
?>	
<div class="layer-hd">
	<h1><?=$alert_title;?></h1>
	<a href="#" class="btn-close del_close"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>
</div>
<div class="layer-content">
	<p class="txt-warning t-ct"><?=$alert_msg?></p>
	<div class="btn-area t-rt"> <!-- periodreq-->
		<!--<button class="btn-del-confirm" onClick="del_delv();" type="button"><img alt="button" id="del_img" src="/kor/images/<?=$btn;?>.gif"></button>-->
		<button class="btn-del-confirm" onClick="del_delv();" type="button"><img alt="button" id="del_img" src="/kor/images/btn_end.gif"></button>
	</div>
</div>

