<?@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
?>
<script src="/kor/js/jquery-1.11.3.min.js"></script>
<script src="/include/function.js"></script>
<script>ready();</script>
<div class="layer-hd <?if ($ver!=""){echo "red";}?>">
	<h1>선적중량</h1>
	<a href="#" class="btn-close"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>
</div>
<?
if ($odr_det_idx){
	$odr_det = get_odr_det_each($odr_det_idx);
	$ship_idx = $odr_det[ship_idx];	
	$ship = get_ship($ship_idx);
	$ship_weight = $ship[ship_weight];
	$weight_type = $ship[weight_type];
}else{
	$odr = get_odr($odr_idx);
	$ship = get_ship($odr[ship_idx]);
	$ship_weight=$odr[ship_weight];
	$weight_type=$odr[weight_type];
}
?>
<div class="layer-content">
	<form class="t-ct">
		<div class="txt-warning">선적 중량을 입력 바랍니다.</div>
		<input type="hidden" name="ship_idx" id="ship_idx" value="<?=$ship_idx?>">
		<div class="mr-tb15">
			<label class="c-red2">무게 <input type="text" id="ship_weight" class="i-txt2 c-blue onlynum numfmt" value="<?=($ship_weight)?number_format($ship_weight,2):""?>" style="width:67px;margin-top:1px;"></label>
			<div class="select type4" lang="en" style="width:67px">
				<label class="c-blue"><?=GF_Common_GetSingleList("WEIGHT",($weight_type)?$weight_type:"1")?></label>
				<?=GF_Common_SetComboList("weight_type", "WEIGHT", "", 1, "True",  "WEIGHT", "1" , $weight_type);?>
			</div>
		</div>
		<div class="btn-area t-rt">
			<button type="button" class="<?if($odr_det_idx){echo "btn-pop-21-2-06";}else{echo "btn-view-sheet-3019";}?>" <?if ($odr_det_idx){echo "ship_idx='$ship_idx'";}?>><img src="/kor/images/btn_packing_list.gif" alt="Packing List"></button><button class="btn-view-sheet-3011" type="button" for_readonly="P"></button>
		</div>
	</form>
</div>

