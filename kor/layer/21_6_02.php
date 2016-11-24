<div class="layer-hd red">
	<h1>거절</h1>
	<a href="#" class="btn-close"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>
</div>
<div class="layer-content">
	<p class="txt-warning t-ct">구매자의 ‘종료’ 요청을 거절합니다. </p>
	<div class="btn-area t-rt">
		<button type="button" onclick="refuse()"><img src="/kor/images/btn_ok.gif" alt="확인"></button>
	</div>

	<form name="f6" id="f"  method="post" enctype="multipart/form-data">
		<input type="hidden" name="typ" id="typ" value="refuse">		
		<input type="hidden" name="status" value="26">
		<input type="hidden" name="status_name" value="거절">
		<input type="hidden" name="odr_idx" id="odr_idx" value="<?=$odr_idx?>">		
		<input type="hidden" name="odr_det_idx" id="odr_det_idx" value="<?=$odr_det_idx?>">		
	</form>
</div>


<SCRIPT LANGUAGE="JavaScript">
<!--
	function refuse(){
		var f =  document.f6;		 
		 f.target = "proc";
		 f.action = "/kor/proc/record_proc.php";
		 f.submit();		
	}
-->
</SCRIPT>