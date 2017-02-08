<?
@header("Content-Type: text/html; charset=utf-8");
//include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";

//$(".btn-area.t-rt button").attr("onclick","alert_msg('처리중입니다.')"); 버튼 클릭시 한번 이상 안눌리게.
if ($alert =="sessionend"){
	$alert_msg = "세션이 종료되었습니다. 다시 로그인이 필요합니다.";
}
?>	
<div class="layer-hd">
	<h1>수량부족</h1>
<!--	<a href="#" class="btn-close"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>-->
</div>
<div class="layer-content">
	<p class="txt-warning t-ct">상기 부품이 부족하게 입고되었습니다.</p>
	<div class="btn-area t-rt"> <!-- periodreq-->
		<button class="btn-close" type="button"><img alt="확인" src="/kor/images/btn_ok.gif"></button>
	</div>
</div>

