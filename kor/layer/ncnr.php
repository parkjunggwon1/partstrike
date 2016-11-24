<?@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";?>
<div class="layer-hd">
	<h1>공지</h1>
	<a href="#" class="btn-close"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>
</div>
<div class="layer-content">
	<?	
//	$part_type=get_any("odr_det", "part_type", "odr_idx=$odr_idx");
	?>
	<p class="txt-warning">
	이 제품은 NCNR(취소 불가, 반품 불가)제품 입니다.<br>
	구매자는 계약금 10%를 지불하고 나머지 대금 90%는 판매자에게 물품 도착 통보를 받은 후 지불하시면 됩니다. 대금 지불을 안 할 경우 구매자의 계약금은 판매자에게 지급할 것이며 회사는 구매자에게 경고조치를 할 것입니다.<br>
	판매자도 계약금 10%를 지불해야 합니다. 거래 종료 후 이 계약금은 판매자의 My Bank로 충전됩니다.<br>
	만약 판매자가 납기일을 지키지 못하면, 한 주는 자동으로 연장될 것입니다.<br>
	연장된 주가 지난 후에도 납기가 이루어지지 않으면, 판매자는 다시 연장요청을 할 수 있고 구매자는 수락하거나 거래를 취소할 수 있습니다. 거래 취소 시 판매자의 계약금은 구매자에게 지급할 것입니다.<br>
	단, 판매자는 납기보다 빠르게 입고되었다는 이유로 구매자에게 납기 기간 이전에 나머지 대금의 지불을 강요할 수 없습니다.<br><br>
	</p>
	<div class="btn-area t-rt">
		<button type="button" class="btn-3008-ncnr" ><img src="/kor/images/btn_invoice_confirm.gif" alt="송장확인"></button>
	</div>
</div>

