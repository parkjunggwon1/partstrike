<?
@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
?>
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
	<h1><span lang="en">My Bank</span> 충전</h1>
	<a href="#" class="btn-close btn-pop-3012"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>
</div>
<div class="layer-content">
	<form>
		<div class="mr-tb15 c-blue t-ct">My Bank US$ <?=SumMyBank2($_SESSION["MEM_IDX"], $_SESSION["REL_IDX"])?></div>
		<div class="txt-warning t-ct">충전하실 금액을 입력해주시기 바랍니다. </div>
		<div class="mr-tb15 t-ct">
			<label class="c-red2" lang="en"><span>US$ : </span><input type="text" name="rqst_amt" id="rqst_amt" class="i-txt2 c-blue t-rt onlynum numfmt" value="" style="width:67px"></label>
		</div>
		<div class="btn-area t-rt">
			<span><img src="/kor/images/btn_invoice_confirm_1.gif" alt="송장 확인"></span>
			<button type="button" style="display:none;" class="btn-view-sheet-0120-r"><img src="/kor/images/btn_invoice_confirm.gif" alt="송장 확인"></button>
		</div>
	</form>
</div>

