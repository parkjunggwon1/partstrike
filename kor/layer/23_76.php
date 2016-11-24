<form name="f4" method="post">
<input type="hidden" name="typ" value="">
<input type="hidden" name="memfee_id" value="<?=$memfee_id?>">
<div class="layer-hd">
	<h1>추가</h1>
	<a href="#" class="btn-close"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>
</div>
<div class="layer-content">
	<form class="fs13">
		<p><label class="ipt-chk chk2 c-red">
		<!--보증금추가-->
		<input type="checkbox" name="charge_type" value="14"><span></span>보증금: </label></p>
		<p class="pd-l20">판매자와 구매자 간의 첫 거래 시 회사에서는 부정행위 방지를 위해  보증금을 요구하고 있습니다. 회원 탈퇴 시<span lang="en">My Bank</span>로 전액  충전됩니다.</p>
		<p class="pd-t40"><label class="ipt-chk chk2 c-red">
		<!--마이뱅크충전-->
		<input type="checkbox"><span></span><span lang="en">My Bank</span>충전:</label> 
		<input type="text" class="i-txt2 c-blue t-rt" value="1,000,000.00" style="width:86px"></p>
		<p class="pd-l20">가상 계좌입니다.<span lang="en">My Bank</span> 로 결제 시 수수료는 0%입니다.</p>
		<div class="btn-area t-rt">
			<a href="javascript:check2();"><img alt="송장 확인" src="/kor/images/btn_invoice_confirm.gif"></a>
		</div>
	</form>
</div>
</form>
