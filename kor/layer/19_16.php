<?
@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
?>
<div class="layer-hd">
	<h1>공지</h1>
	<a href="#" class="btn-close"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>
</div>
<div class="layer-content">
	<p class="txt-warning">판매자 귀책으로 추가선적이 일어난 것이므로, 선적 시 '운임'은 판매자가 지불해야만 합니다. </p>
	<p class="txt-warning">운송회사를 선택해 주시기 바랍니다. </p>
	<div class="btn-area t-ct">
		운송회사 
		<div class="select type4" lang="en" style="width:110px">									
		<label class="c-blue text_lang"><?
		if($assign_idx){  //판매자 지정...
			echo GF_Common_GetSingleList("DLVR",$assign_idx);
		}elseif($ship_info){
			echo GF_Common_GetSingleList("DLVR",$ship_info);
		}
		?></label>
			<?
			echo GF_Common_SetComboListSrch("ship_info", "DLVR", "", 1, "True",  "", $assign_idx?$assign_idx:$ship_info ,$assign_idx?"disabled":"onchange='chg_ship_info(this)'","");
			?>
		</div>
	</div>
	<div class="btn-area t-rt">
		<button type="button" class="btn-dialog-1917" odr_det_idx="<?=$odr_det_idx?>"><img src="/kor/images/btn_add_shipping.gif" alt="추가 선적"></button>
		
	</div>
</div>

