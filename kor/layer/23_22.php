<?@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
?>
<script src="/kor/js/jquery-1.11.3.min.js"></script>
<script src="/include/function.js"></script>
<script>ready();
	$("input[name=rqst_amt]").keyup(function(){
		if ($(this).val()=="")
		{
			
			$(".layer-content .btn-area span").show();
			$(".layer-content .btn-area button").hide();
		}else{
			$(".layer-content .btn-area span").hide();
			$(".layer-content .btn-area button").show();
		}
	});
</script>
<div class="layer-hd">
	<h1>인출</h1>
	<a href="#" class="btn-close btn-remittance"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>
</div>
<div class="layer-content">
	<form>

<?	$sum = SumMyBank2($session_mem_idx, $session_rel_idx);
	$possible_amt = $sum;
?>	<input type="hidden" name="psb" id="psb" value="<?=$possible_amt?>">
		<p class="txt-warning c-blue t-ct" lang="en">My Bank US$ <?=$sum?></p>
		<p class="mr-t20 mr-l50 txt-warning">당신이 송금 받고자 하는 금액을 입력하여 주십시오. </p>
		<?if($_SESSION["NATION"]=="1") {?>
			<p class="mr-t20 mr-l50"> (<span lang="en">Escrow fee</span>:  요청금액의 <span lang="en">1%</span>) </p>
		<?}else{?>
			<p class="mr-t20 mr-l50"> (<span lang="en">Escrow fee</span>: 1. 요청금액이 US$3,000.00미만 일 때 :  <span lang="en">US$30.00</span></p>
			<p style="padding-left:115px">2. 요청금액이 US$3,000.00이상 일 때 : <span lang="en">1%</span>)</p>
		<?}?>
		

		<div class="mr-tb15 t-ct">
			<label class="c-red2">요청 금액<span lang="en"> </span><input type="text" name="rqst_amt" id="rqst_amt" class="i-txt2 c-blue t-rt onlynum numfmt" value="" style="width:67px" maxlength="10"></label>
		</div>
		<div class="btn-area t-rt">
			<span><img src="/kor/images/btn_invoice_confirm_1.gif" alt="송장 확인"></span>
			<button type="button" style="display:none;"  class="btn-view-sheet-0120"><img src="/kor/images/btn_invoice_confirm.gif" alt="송장 확인"></button>
		</div>
	</form>
</div>

