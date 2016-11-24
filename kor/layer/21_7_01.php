<?@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
?>
<div class="layer-hd red">
	<h1>거절</h1>
	<a href="#" class="btn-close"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>
</div>

<?if (QRY_CNT("fty_history","and status=26 and reason_ty = 6 and reg_mem_idx = '".$_SESSION["MEM_IDX"]."'")==0){?>
<div class="layer-content">
	<p class="txt-warning t-ct">상대방의 ‘연구소 의뢰’ 요청 동의를 거절합니다. </p>
	<div class="btn-area t-rt">
		<button type="button" onclick="javascript:check();"><img src="/kor/images/btn_ok.gif" alt="확인"></button>
	</div>
</div>
<?}else{?>
<div class="layer-content">
	<p class="txt-warning">당신이 ‘연구소로 의뢰’ 요청을 두 번 거절 할 시, ‘동의’ 밖에 선택이 불가합니다. 계속 하시겠습니까? </p>
	<div class="btn-area t-rt">
		<a class="btn-dialog-2108" href="#" odr_det_idx="<?=$odr_det_idx?>"><img alt="답변서" src="/kor/images/btn_reply.gif"></a>
	</div>
</div>
<?}?>


<form name="f6" id="f6" method="post" enctype="multipart/form-data">		
<input type="hidden" name="typ" value="refuse">
<input type="hidden" name="odr_idx" value="<?=$odr_idx?>">
<input type="hidden" name="odr_det_idx" value="<?=$odr_det_idx?>">
<input type="hidden" name="status" value="26">
<input type="hidden" name="status_name" value="거절">
<input type="hidden" name="reason_ty" value="6">
<input type="hidden" name="etc1" value="확인">
<input type="hidden" name="sell_mem_idx" value="<?=$sell_mem_idx?>">
<input type="hidden" name="buy_mem_idx" value="<?=$buy_mem_idx?>">
</form>

<SCRIPT LANGUAGE="JavaScript">
<!--
	function check(){
		 var f = document.f6;
		 f.target = "proc";
		 f.action = "/kor/proc/record_proc.php";
		 f.submit();		
	}

-->
</SCRIPT>