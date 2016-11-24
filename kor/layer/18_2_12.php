<div class="layer-hd">
	<h1>결제완료</h1>
	<a href="#" class="btn-close"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>
</div>
<div class="layer-content">
	<form name="f" id="f">
		<!-- form1 -->
		<input type="hidden" name="typ" id="typ" value="<?=$ty?>">
		<input type="hidden" name="odr_idx" id="odr_idx" value="<?=$odr_idx?>">		
		<input type="hidden" name="odr_det_idx" id="odr_det_idx" value="<?=$odr_det_idx?>">
		<input type="hidden" name="tot_31" id="tot_31" value="<?=$tot_amt;?>">
		
		<!-- //form1 -->
	</form>
	<div class="layer-file" id="file_30_21"></div>
	<div class="layer-data" id="data_30_21"></div>		
	<div class="btn-area t-rt" odr_idx="<?=$odr_idx?>" odr_det_idx="<?=$odr_det_idx?>" forgenl="Y">
		<button type="button" class="btn-view-sheet-19-1-04"><img src="/kor/images/btn_refund.gif" alt="환불"></button>
	</div>
</div>



<SCRIPT LANGUAGE="JavaScript">
<!--

$(document).ready(function(){
	$("#file_30_21").html($("#file_18R_19").html());
	$("#data_30_21").html($("#data_18R_19").html());
	$("#file_30_21 .t-ct").html("부대비용(<strong class='c-blue'><span lang='en'>US$ "+$("#tot_31").val()+" - My Bank</span></strong>)이 완료되었습니다.");

});
-->
</SCRIPT>