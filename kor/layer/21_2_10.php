<?@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include  $_SERVER["DOCUMENT_ROOT"]."/include/class/class.record.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.member.php";
$odr_det= get_odr_det_each($odr_det_idx);

?>
<div class="layer-hd red">
	<h1>수령</h1>
	<a href="#" class="btn-close"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>
</div>
<div class="layer-content">
	<form>
		<?echo layerListData("21_2_10" ,$odr_idx,$odr_det_idx ,"fty" );?>
		<div class="btn-area t-rt">
			<button class="btn-view-sheet-21-1-10" type="button" odr_idx="<?=$odr_idx?>" odr_det_idx="<?=$odr_det_idx?>"><img alt="송장확인" src="/kor/images/btn_invoice_confirm.gif"></button>
		</div>
	</form>
</div>

