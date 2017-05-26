<?
@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.part.php";
$part=get_part($part_idx);
$sell_mem_idx = $part[mem_idx];
$sell_rel_idx = $part[rel_idx];
$part_type = $part[part_type];
$part_ty = ($part_type == "1" || $part_type == "3" || $part_type=="4")?"S":$part_idx; //S: stock은 한번에 같이 order 그 외는 개별 odr

?>	
<!-------- layer:30_03 -------------------------->
<div class="layer-hd">
	<h1>납기</h1>
	<a href="#" class="btn-close"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>
</div>
<form name="f" id="f">
<input type="hidden" name="typ" value="periodreq">
<input type="hidden" name="sell_mem_idx" id="sell_mem_idx" value="<?=$sell_mem_idx?>">
<input type="hidden" name="sell_rel_idx" id="sell_rel_idx" value="<?=$sell_rel_idx?>">
<input type="hidden" name="session_mem_idx" id="session_mem_idx" value="<?=$session_mem_idx?>">
<input type="hidden" name="session_rel_idx" id="session_rel_idx" value="<?=$session_rel_idx?>">
<input type="hidden" name="odr_idx" id="odr_idx" value="<?=$odr_idx?>">
<input type="hidden" name="part_idx" id="part_idx" value="<?=$part_idx?>">
<input type="hidden" name="odr_quantity" id="odr_quantity" value="<?=$odr_quantity?>">
<input type="hidden" name="fromPage" value="<?=$fromPage?>">
<input type="hidden" name="fromLoadPage" value="<?=$fromLoadPage?>">
<input type="hidden" name="addsearch_part_no" value="<?=$addsearch_part_no?>">
<input type="hidden" name="txt_addsearch_part_no" value="<?=$txt_addsearch_part_no?>">
</form>
<div class="layer-content">
	<p class="txt-warning t-ct">납기 확인 바랍니다. </p>
	<div class="btn-area t-rt  <?=$callfrom;?>" >
		<button class="periodreq" type="button" part_idx="<?=$part_idx?>" price="<?=$price?>" qty="<?=$odr_quantity?>" fromLoadPage="<?=$fromLoadPage?>"><img  src="/kor/images/btn_transmit.gif" alt="전송"></button>
	</div>
</div>
