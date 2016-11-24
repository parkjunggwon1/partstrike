<?@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include  $_SERVER["DOCUMENT_ROOT"]."/include/class/class.odrinfo.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.member.php";
?>
<script src="/kor/js/jquery-1.11.3.min.js"></script>
<script src="/include/function.js"></script>
<div class="layer-hd">
	<h1>보증금</h1>
	<a href="#" class="btn-close"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>
</div>
<div class="layer-content">
	<p class="txt-warning">당신의 첫 거래입니다. 판매자와 구매자 양측 모두 보증금(<span lang="en">US$1,000.00</span>)을 지불해야지만 다음 단계로 진행할 수 있습니다. 보증금은 탈퇴 시 은행 수수료를 제외하고 환불될 것입니다. 보증금은 당신의 권리 보호를 위해 요구하고 있습니다. </p>
	<div class="btn-area t-rt">
	<?$sell_mem_idx = get_any("odr", "sell_mem_idx", "odr_idx=$odr_idx");
	if ($sell_mem_idx == $_SESSION["MEM_IDX"]){
		$cls = "btn-view-sheet-1713";  //판매자용 보증금 sheet
	}else{
		$cls = "btn-view-sheet-3011";
	}
	?>
		<a class="<?=$cls?>" for_readonly="" href="#" ><img alt="송장확인" src="/kor/images/btn_invoice_confirm.gif"></a>
	</div>
</div>

