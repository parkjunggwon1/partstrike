<?
/*********************************************************************************************
** [사용자정의 메세지창] 타이틀, 메세지, 버튼이미지명 pram 받고, 닫기(X) 클릭 시 단순 닫기
** 호출하는 화면 : 31_05(판매자 납기 답변)
** menu.js : layer6, alert3(title,msg,btn,btncss,close_yn)
** 2016-04-07 : 닫기 버튼에 class 추가하여, 이번트처리 각각 다르게
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
	<?if($close_yn=="Y"){?>
	<a href="#" class="btn-close"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>
	<?}?>
</div>
<div class="layer-content">
	<p class="txt-warning t-lt"><?=$alert_msg?></p>
	<div class="btn-area t-rt"> <!-- periodreq-->
		<button class="btn-alert3 <?=$btncss;?>" type="button"><img alt="button" src="/kor/images/<?=$btn;?>.gif"></button>
	</div>
</div>

