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
	<?if ($whole_part_type=="E"){?>
	이 제품은 NCNR(취소 불가, 반품 불가)제품 입니다.<br>
	구매자는 계약금 10%를 지불하고 나머지 대금 90%는 판매자에게 물품 도착 통보를 받은 후 지불하시면 됩니다. 대금 지불을 안 할 경우 구매자의 계약금은 판매자에게 지급할 것이며 회사는 구매자에게 경고조치를 할 것입니다.<br>
	판매자도 계약금 10%를 지불해야 합니다. 거래 종료 후 이 계약금은 판매자의 My Bank로 충전됩니다.<br>
	만약 판매자가 납기일을 지키지 못하면, 한 주는 자동으로 연장될 것입니다.<br>
	연장된 주가 지난 후에도 납기가 이루어지지 않으면, 판매자는 다시 연장요청을 할 수 있고 구매자는 수락하거나 거래를 취소할 수 있습니다. 거래 취소 시 판매자의 계약금은 구매자에게 지급할 것입니다.<br>
	단, 판매자는 납기보다 빠르게 입고되었다는 이유로 구매자에게 납기 기간 이전에 나머지 대금의 지불을 강요할 수 없습니다.<br><br>
	<hr>
	<br>
	<p class="txt-warning">
	'발주서 확인'시 '확정 발주서'만 선택할 수 있으며 미 선택시에도 자동 전송됩니다.
	<?}else{?>
	'발주서 확인'시 '확정 발주서'만 선택할 수 있으며 미 선택시에도 자동 전송됩니다.
	<?}?>
	</p>

	<input type="hidden" name="odr_idx" id="odr_idx_30_06" value="<?=$odr_idx?>">
	<input type="hidden" name="new_odr_idx" id="new_odr_idx" value="<?=$new_odr_idx?>">
	<input type="hidden" name="odr_idx" id="odr_idx_30_06" value="<?=$odr_idx?>">
	<input type="hidden" name="new_odr_idx" id="new_odr_idx" value="<?=$new_odr_idx?>">
	<input type="hidden" name="delivery_addr_idx" id="delivery_addr_idx" value="<?=$delivery_addr_idx?>">
	<input type="hidden" name="session_mem_idx" id="session_mem_idx" value="<?=$session_mem_idx?>">
	<input type="hidden" name="sell_mem_idx" id="sell_mem_idx" value="<?=$sell_mem_idx?>">
	<input type="hidden" name="delivery_save_yn" id="delivery_save_yn" value="<?=$delivery_save_yn?>">
	<input type="hidden" name="nation" id="nation" value="<?=$nation?>">
	<input type="hidden" name="com_name" id="com_name" value="<?=$com_name?>">
	<input type="hidden" name="manager" id="manager" value="<?=$manager?>">
	<input type="hidden" name="pos_nm" id="pos_nm" value="<?=$pos_nm?>">
	<input type="hidden" name="depart_nm" id="depart_nm" value="<?=$depart_nm?>">
	<input type="hidden" name="com_type" id="com_type" value="<?=$com_type?>">
	<input type="hidden" name="tel" id="tel" value="<?=$tel?>">
	<input type="hidden" name="fax" id="fax" value="<?=$fax?>">
	<input type="hidden" name="hp" id="hp" value="<?=$hp?>">
	<input type="hidden" name="email" id="email" value="<?=$email?>">
	<input type="hidden" name="homepage" id="homepage" value="<?=$homepage?>">
	<input type="hidden" name="zipcode" id="zipcode" value="<?=$zipcode?>">
	<input type="hidden" name="dosi" id="dosi" value="<?=$dosi?>">
	<input type="hidden" name="dositxt" id="dositxt" value="<?=$dositxt?>">
	<input type="hidden" name="sigungu" id="sigungu" value="<?=$sigungu?>">
	<input type="hidden" name="addr_det" id="addr_det" value="<?=$addr_det?>">
	<input type="hidden" name="addr" id="addr" value="<?=$addr?>">
	<input type="hidden" name="log_date" id="log_date" value="<?=$log_date?>">
	<input type="hidden" name="log_ip" id="log_ip" value="<?=$log_ip?>">

	<div class="btn-area t-rt">
		<button type="button" class="btn-view-sheet" odr_idx = "<?=$odr_idx?>" new_odr_idx="<?=$new_odr_idx?>"><img src="/kor/images/btn_order_confirm.gif" alt="발주서 확인"></button>
	</div>
</div>

