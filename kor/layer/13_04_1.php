<?@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";?>
<div class="layer-hd">
	<h1>취소</h1>
	<a href="#" class="btn-close"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>
</div>
<div class="layer-content">
	<?	
//	$part_type=get_any("odr_det", "part_type", "odr_idx=$odr_idx");
	?>
	<p class="txt-warning" style="text-align: center;">
	당신의 계약금이 구매자에게 지급됩니다.	
	</p>

	<input type="hidden" name="actidx" id="actidx" value="<?=$actidx?>">


	<div class="btn-area t-rt">
		<button type="button" class="btn-confirm-1304_1s" odr_idx = "<?=$odr_idx?>" odr_history_idx = "<?=$actidx?>" new_odr_idx="<?=$new_odr_idx?>"><img src="/kor/images/btn_end.gif" alt="종료"></button>
	</div>
</div>

