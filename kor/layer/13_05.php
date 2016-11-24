<?@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include  $_SERVER["DOCUMENT_ROOT"]."/include/class/class.odrinfo.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.member.php";
$etc1 = get_any("odr_history" , "etc1" ,"odr_idx = $odr_idx and status = 5 and sell_mem_idx = reg_mem_idx");
?>
<div class="layer-hd">
	<h1>결제완료</h1>
	<a href="#" class="btn-close"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>
</div>
<div class="layer-content">

	<p class="txt-warning t-ct">계약금 ( <span class="c-blue"><strong lang="en">US$<?=$etc1?></strong> </span>) 지급이 완료되었습니다. </p>
	<div class="btn-area t-rt">
		<button type="button" class="downpay_return"><img src="/kor/images/btn_complete.gif" alt="완료"></button>
	</div>
</div>
