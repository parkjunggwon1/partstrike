<?  @header("Content-Type: text/html; charset=utf-8");
	include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
?>
<div class="layer-hd">
	<h1>창고</h1>
	<a href="#" class="btn-close"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>
</div>
<div class="layer-content">
	<div class="btn-area t-ct">
	
		<a href="#" class="btn-dialog-0136"><img src="/kor/images/btn_arrival.gif" alt="도착"></a>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<? // 첫 지연이면 1주 자동 연장, 아니면 지연 주수 팝업으로 연결
			$cnt = QRY_CNT("odr_history" , "and odr_idx = $odr_idx and status = 20");
			
		?>
		<a href="#" class="<?if ($cnt == 0){?>btn-dialog-3021_D<?}else{?>btn-dialog-1001<?}?>"><img src="/kor/images/btn_delay.gif" alt="지연"></a>
		<input type="hidden" id="autoExtension" value="<?if ($cnt == 0){?>Y<?}?>">
	</div>
</div>

