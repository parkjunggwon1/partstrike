<?@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";?>
<div class="layer-hd">
	<h1>입금</h1>
	<a href="#" class="btn-close"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>
</div>
<div class="layer-content">
	<?	
//	$part_type=get_any("odr_det", "part_type", "odr_idx=$odr_idx");
	?>
	<p class="txt-warning" style="text-align: center;">
	판매자, 구매자 계약금을 다시 복구 시킵니다.
	</p>

	<input type="hidden" name="actidx" id="actidx" value="<?=$actidx?>">
	<input type="hidden" name="pay_amt" id="pay_amt" value="<?=str_replace("$","",$down_payment)?>">


	<div class="btn-area t-rt">
		<button type="button" class="btn-confirm-1304_2_ok" odr_history_idx = "<?=$actidx?>" pay_amt="<?=str_replace("$","",$down_payment)?>" ><img src="/kor/images/btn_ok.gif" alt="확인"></button>
	</div>
</div>

