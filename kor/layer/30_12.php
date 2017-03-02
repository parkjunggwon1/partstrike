<div class="layer-hd">
	<h1>결제</h1>
	<a href="#" class="btn-close"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>
</div>
<div class="layer-content">
	<div class="t-ct"><a href="#" class="btn-pop-0119"><img src="/kor/images/btn_mybank_chrg.gif" alt=""></a></div>
	<div class="btn-area t-ct" odr_idx="<?=$odr_idx?>" odr_det_idx="<?=$odr_det_idx?>" tot_amt="<?=$tot_amt?>" fromLoadPage="<?=$fromLoadPage?>" deposit_yn="<?=$deposit_yn?>" charge_type="<?=$charge_type?>"  >
		<a href="#" class="f-lt btn-pop-18-2-11"  odr_idx="<?=$odr_idx?>" odr_det_idx="<?=$odr_det_idx?>" fromLoadPage="<?=$fromLoadPage?>" charge_type="<?=$charge_type?>" memfee_id="<?=$memfee_id?>" tot_amt="<?=$tot_amt?>" deposit_yn="<?=$deposit_yn?>"><img src="/kor/images/btn_mybank.gif" alt="my bank"></a>
		<a href="#" class="btn-dialog-18-2-12"><img src="/kor/images/btn_card.gif" alt="신용카드"></a>
		<a href="#" class="f-rt btn-pop-3013"><img src="/kor/images/btn_remittance.gif" alt="은행송금"></a>
	</div>
</div>
<?$typ = $typ==""?"pay":$typ;?>
<form name="payform">
	<input type="hidden" name="typ" value="<?=$typ?>">
	<input type="hidden" name="memfee_id" value="<?=$memfee_id?>">
	<input type="hidden" name="odr_idx" value="<?=$odr_idx?>">
	<input type="hidden" name="odr_det_idx" value="<?=$odr_det_idx?>">
	<input type="hidden" name="tot_amt" value="<?=$tot_amt?>">
	<input type="hidden" name="fromLoadPage" value="<?=$fromLoadPage?>">
	<input type="hidden" name="deposit_yn" value="<?=$deposit_yn?>">
	<input type="hidden" name="charge_type" value="<?=$charge_type?>">
</form>

<SCRIPT LANGUAGE="JavaScript">
<!--
//alert($("#tot_"+$("#odr_idx_30_09").val()).val());
-->
</SCRIPT>