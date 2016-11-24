<?
@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include  $_SERVER["DOCUMENT_ROOT"]."/include/class/class.odrinfo.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.member.php";
if (!$charge_type){$charge_type = "3";}
?>
<script src="/kor/js/jquery-1.11.3.min.js"></script>
<script src="/include/function.js"></script>

<div class="layer-hd">
	<h1>은행 송금</h1>
	<a href="#" class="btn-close btn-pop-3012"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>
</div>
<div class="layer-content">
	<form class="t-ct" name="f6" id="f6" method="post" enctype="multipart/form-data">
		<input type="hidden" name="typ" value="bankfileup">
		<input type="hidden" name="mybank_idx" value="">
		<input type="hidden" name="mem_idx" value="<?=$_SESSION["MEM_IDX"]?>">
		<input type="hidden" name="rel_idx" value="<?=$_SESSION["REL_IDX"]?>">
		<input type="hidden" name="charge_type" value="<?=$charge_type?>">
		<input type="hidden" name="tot_amt" value="<?=$tot_amt?>">
		<input type="hidden" name="charge_method" value="2">
		<input type="hidden" name="odr_idx" value="<?=$odr_idx?>">
		<input type="hidden" name="odr_det_idx" value="<?=$odr_det_idx?>">
		<input type="hidden" name="deposit_yn" value="<?=$deposit_yn?>">
		<input type="hidden" name="no" value="">	
		<div class="txt-warning t-lt"><!--송금 영수증을 첨부 바랍니다.-->은행 송금 시 수수료는 구매자 부담입니다.<br>
수수료가 적을 경우 당신의 My Bank에서 차감되며 My Bank에 금액이 없을 시 보증금에서 차감되며 다음 거래 시 청구 됩니다.<br>
수수료가 많을 경우 당신의 My Bank로 입금 됩니다.</div>
		<?if ($_SESSION["MEM_IDX"]!="1" && $_SESSION["NATION"]!="1"){?>
		<p class="mr-tb15 t-lt">
			<span class="c-red">T/T Copy</span>
			<span class="img-wrap">
				<input id="file_o1" name="file_o1" type="hidden">
				<input name="file1" style="display:none;" onchange="javascript: document.getElementById('file_o1').value = this.value" type="file">
				<img src="/kor/images/file_pt.gif" id="fileimg1" class="fileimg1" alt="" width="72" height="58">
			</span>
		</p>
		<?}?>
		<div class="btn-area t-rt">
			<?if ($_SESSION["MEM_IDX"]=="1" || $_SESSION["NATION"]=="1"){?>
				<button type="button" style="display:;" class="remit_submit2"><img src="/kor/images/btn_transmit.gif" alt="전송"></button>
			<?}else{?>
				<span><img src="/kor/images/btn_transmit_1.gif" alt="전송"></span>
				<button type="button" style="display:none;" class="remit_submit"><img src="/kor/images/btn_transmit.gif" alt="전송"></button>
			<?}?>
		</div>
	</form>	
</div>

<SCRIPT LANGUAGE="JavaScript">
<!--

$(document).ready(function(){
	$(".fileimg1").click(function () {
		$(this).prev().click();
	});
	$("input[type=file]").change(function(){	
		if ($(this).val()){
			$("#f6 .btn-area span").hide()
			$("#f6 .btn-area button").show();
			var f =  document.f6; 
			f.typ.value="bankfileup";
			f.no.value = $(this).attr("name").replace("file","");
			f.target = "proc";
			f.action = "/kor/proc/odr_proc.php";
			f.submit();						 
		}
	});
});


-->
</SCRIPT>