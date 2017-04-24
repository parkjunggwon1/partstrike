<?@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";?>
<div class="layer-hd">
	<h1>Alarm</h1>
	<!--<a href="#" class="btn-close"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>-->
</div>
<div class="layer-content">
	<?	
	$part_no=get_any("part", "part_no", "part_idx=$part_idx");
	$part_cnt = QRY_CNT("odr_det"," and odr_idx=$odr_idx and part_idx=$part_idx ");  //odr_det 수량

	if ($part_cnt==0)
	{
		$btn_type="btn-refresh";
	}
	else
	{
		$btn_type="btn-close";
	}
	?>
	<p class="txt-warning t-ct">
	판매자가 해당 품목을 삭제하였습니다.
	</p>
	<p class="txt-warning t-ct" style="margin-top:10px;">
		<span class='c-blue'><?=$part_no?></span>
	</p>

	<input type="hidden" name="odr_idx" id="odr_idx_30_06" value="<?=$odr_idx?>">
	<input type="hidden" name="new_odr_idx" id="new_odr_idx" value="<?=$new_odr_idx?>">
	<div class="btn-area t-rt">
		<button type="button" class="<?=$btn_type?>" >
		<img src="/kor/images/btn_ok.gif" alt="확인">
		</button>
	</div>
</div>

