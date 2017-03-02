<?
/*********************************************************************************************
*** 반품, 교환 수락 메세지창
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
	<a href="#" class="btn-close"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>
</div>
<div class="layer-content">
	<p class="txt-warning t-ct"><?=$alert_msg?></p>
	<div class="btn-area t-rt">
		<button class="btn-return-<?=$btncss;?>" type="button"><img alt="button" src="/kor/images/<?=$btn;?>.gif"></button>
	</div>
</div>
<?
  $odr = get_odr($odr_idx);
  $sell_mem_idx = $odr[sell_mem_idx];
  $buy_mem_idx = $odr[mem_idx];
  $status = "9";
  $status_name = "거절";
  $refuse_num = QRY_CNT("odr_history", "and odr_idx = $odr_idx and odr_det_idx = $odr_det_idx and status= $status and reg_mem_idx = $session_mem_idx");
?>
<form name="f6" id="f6" method="post">
<input type="hidden" name="typ" value="refuse">
<input type="hidden" name="odr_idx" value="<?=$odr_idx?>">
<input type="hidden" name="odr_det_idx" value="<?=$odr_det_idx?>">
<input type="hidden" name="status" value="<?=$status?>">
<input type="hidden" name="status_name" value="<?=$status_name?>">
<input type="hidden" name="fault_yn" value="Y">
<input type="hidden" name="fault_accept" value="Y">
<input type="hidden" name="etc1" value="<?=ordinal($refuse_num+1)?>">
<input type="hidden" name="sell_mem_idx" value="<?=$sell_mem_idx?>">
<input type="hidden" name="buy_mem_idx" value="<?=$buy_mem_idx?>">
<input type="hidden" name="fault_select" value="2">
<input type="hidden" name="title" value="승인">
<input type="hidden" name="memo" value="승인">
</form>
<SCRIPT LANGUAGE="JavaScript">
	$(document).ready(function(){
		$("body").on("click",".btn-return-buyer_ok",function(){
			var f =  document.f6;				
			f.typ.value="refuse";
			f.target = "proc";
			f.action = "/kor/proc/odr_proc.php";
			f.submit();	
			location.href="/kor/";
		});
	});
</SCRIPT>

