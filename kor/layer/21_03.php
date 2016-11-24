<?@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";?>
<script>ready();</script>
<div class="layer-hd red">
	<h1>운임</h1>
	<a href="#" class="btn-close"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>
</div>
<div class="layer-content">
	<form>
		<div class="txt-warning">운임을 입력해 주시기 바랍니다. 문제가 발생했을 때, 운임이 입력되어 있지 않다면 운임을 환불받으실 수 없습니다. </div>
		<div class="mr-tb15 t-ct">
			<label class="c-red2">운임 <span lang="en">US$</span> : <input type="text" class="i-txt2 c-blue onlynum numfmt" name="faulty_delivery_fee" id="faulty_delivery_fee" value="" style="width:67px"></label>
		</div>
		<div class="btn-area t-rt">
			<button type="button" odr_idx="<?=get_any("odr_det","odr_idx", "odr_det_idx=$odr_det_idx")?>" odr_det_idx="<?=$odr_det_idx?>" class="btn-dialog-2104"><img src="/kor/images/btn_ok.gif" alt="확인"></button>
		</div>
	</form>
</div>



