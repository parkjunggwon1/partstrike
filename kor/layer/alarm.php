<?@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";?>
<div class="layer-hd">
	<h1>Alarm</h1>
	<!--<a href="#" class="btn-close"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>-->
</div>
<div class="layer-content">
	<?	
//	$part_type=get_any("odr_det", "part_type", "odr_idx=$odr_idx");
	?>
	<p class="txt-warning t-ct">
	재고 수량이 변경되었습니다. 발주 수량을 수정하시기 바랍니다.
	</p>

	<input type="hidden" name="odr_idx" id="odr_idx_30_06" value="<?=$odr_idx?>">
	<input type="hidden" name="new_odr_idx" id="new_odr_idx" value="<?=$new_odr_idx?>">
	<div class="btn-area t-rt">
		<button type="button" class="btn-close" odr_idx = "<?=$odr_idx?>" new_odr_idx="<?=$new_odr_idx?>">
		<img src="/kor/images/btn_ok.gif" alt="확인">
		</button>
	</div>
</div>

