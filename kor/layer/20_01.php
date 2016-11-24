<?@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include  $_SERVER["DOCUMENT_ROOT"]."/include/class/class.record.php";

	 $fty_his = $his_ty =="odr"? get_odr_history($history_idx) :get_fty_history($history_idx);
	 $odr_det = get_odr_det_each($fty_his[odr_det_idx]);
	 if ($invoice_no==""){
		 $ship = get_ship($odr_det[ship_idx]);
		 $invoice_no=$ship[invoice_no];
	 }


?>
<div class="layer-hd">
	<h1><span lang="en">PARTStrike</span></h1>
	<a href="#" class="btn-close"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>
</div>
	<div class="layer-content">
	<form name="writefrm"  id="writefrm"  method="post" class="msg-write-form">
		<input type="hidden" name="mode" value="EE001">
		<input type="hidden" name="typ" id="typ" value="write">
		<input type="hidden" name="idx" id="idx" value="<?=$idx?>">
		<input type="hidden" name="title"  value="제품 반품에 대한 문제 발생 : 반품 선적 서류 번호 [<?=$invoice_no?>]">
		<input type="hidden" name="address"  value="<?=$invoice_no?>">
		<input type="hidden" name="faultyYn" value="Y">
		<input type="hidden" name="ref" value="<?=$ref?>">
		<input type="hidden" name="ref2" value="<?=$ref2?>">
		<input type="hidden" name="lev" value="<?=$lev-1?>">
		<input type="hidden" name="step" value="<?=$step?>">
		<input type="hidden" name="no" value="">
		<div class="txt-warning">제품 반품에 대한 문제 발생 시 원만한 해결이 되지 않는다면 <span lang="en">‘PARTStrike’</span>로 메모를 보내주시기 바랍니다. </div>
		<div class="mr-tb15 t-ct">
			<label class="c-black"><span lang="en">Memo : </span> <input type="text" name="content" class="i-txt5" value="<?=$invoice_no?> 관련" style="width:280px"></label>
		</div>
		<div class="btn-area t-rt">
			<button type="button" onclick="board_check();"><img src="/kor/images/btn_transmit.gif" alt="전송"></button>
		</div>
	</form>
</div>

<script type="text/javascript">
<!--
	function board_check(){
		var f =  document.writefrm;
		if (trim(f.content.value)==""){
			alert_msg("Memo를 입력해주세요.");
			f.title.focus();
			return;
		}
		f.target="proc";
		f.action = "/kor/proc/board_proc.php";
		f.encoding = "multipart/form-data";
		f.submit();
	}


//-->
</script>

