<?
	@header("Content-Type: text/html; charset=utf-8");
	include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
	$odr_idx =get_any("odr_det","odr_idx", "odr_det_idx=$odr_det_idx");
	$odr = get_odr($odr_idx);
	$sell_mem_idx = $odr[sell_mem_idx];
	$buy_mem_idx = $odr[mem_idx];
	$status = "15";
	$status_name= "종료";
?>
<div class="layer-hd red">
	<h1>종료</h1>
	<a href="#" class="btn-close"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>
</div>
<div class="layer-content">
	<form name="f2" id="f2" method="post" enctype="multipart/form-data">		
	<input type="hidden" name="typ" value="end">
	<input type="hidden" name="odr_idx" value="<?=$odr_idx?>">
	<input type="hidden" name="odr_det_idx" value="<?=$odr_det_idx?>">
	<input type="hidden" name="status" value="<?=$status?>">
	<input type="hidden" name="status_name" value="<?=$status_name?>">
	<input type="hidden" name="etc1" value="확인">
	<input type="hidden" name="fault_yn" value="N">
	<input type="hidden" name="sell_mem_idx" value="<?=$sell_mem_idx?>">
	<input type="hidden" name="buy_mem_idx" value="<?=$buy_mem_idx?>">
	</form>
	<p class="txt-warning t-ct">모든 처리가 완료되었습니다. </p>
	<div class="btn-area t-rt">
		<button type="button" onclick="check()"><img src="/kor/images/btn_end.gif" alt="종료"></button>
	</div>
</div>

<SCRIPT LANGUAGE="JavaScript">
<!--
	function check(){
		var formData = $("#f2").serialize(); 
		$.ajax({
				url: "/kor/proc/record_proc.php", 
				data: formData,
				encType:"multipart/form-data",
				success: function (data) {						
					if (trim(data) == "SUCCESS"){		
							location.href="/kor/";
					}else{
						alert_msg(data);
					}
				}
		});		
	}
-->
</SCRIPT>