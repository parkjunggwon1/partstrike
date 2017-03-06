<?
/*********************************************************************************************
** MyBank 입금완료 메세지
** 2016-10-02 : 보증금 반환 정보가 있을 경우 메세지창 처리.
**********************************************************************************************/
@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";

//$(".btn-area.t-rt button").attr("onclick","alert_msg('처리중입니다.')"); 버튼 클릭시 한번 이상 안눌리게.
if ($alert =="sessionend"){
	$alert_msg = "세션이 종료되었습니다. 다시 로그인이 필요합니다.";
}
?>	
<Script Language="javascript">
$(document).ready(function(){
	$("body").on("click",".btn-close-payment",function(){
		document.location.href="/kor/";
	});
});
</script>
<div class="layer-hd">
	<h1>입금</h1>
	<!--a href="#" class="btn-close payment"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a-->
</div>
<div class="layer-content">
	<p class="txt-warning t-ct"><span class="c-blue">My Bank  - $<?=round_down($amt,4)?></span> 충전 되었습니다.</p>
	<div class="btn-area t-rt">
		<button class="btn-close-payment" type="button"><img alt="button" src="/kor/images/btn_complete.gif"></button>
	</div>
</div>

