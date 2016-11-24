<?/***************************************************************************************************
*** 납기품목 취소(06_01) : 기존화면 이며, 사유 입력 후 취소처리
*****************************************************************************************************/?>
<script src="/kor/js/jquery-1.11.3.min.js"></script>
<script>
$("#reason").keyup(function(e){
	var $this = $(this).parent().next().next();
	if($(this).val()==""){
		$this.find("button").hide();
		$this.find("span").show();
	}else{
		$this.find("span").hide();
		$this.find("button").show();	
	}
});
</script>
<div class="layer-hd">
	<h1>취소</h1>
	<a href="#" class="btn-close"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>
</div>
<div class="layer-content">
	<form class="t-ct">
		<p class="txt-warning">취소 시 해당 품목은 당신의 재고 목록에서 삭제됩니다. 만약 해당 품목을 판매하고 싶다면 재 등록해 주시기 바랍니다. </p>
		<p class="mr-b15"><img src="/kor/images/btn_img_rs.gif" alt="사유"></p>
		<p class="mr-b15"><input type="text"  id="reason" class="i-txt2 c-blue w100" value=""></p>
		<p><small>취소가 완료되면, ‘발주 취소’ 항목의 숫자가 증가할 것입니다.</small></p>
		<div class="btn-area t-rt">
		<span><img src="/kor/images/btn_end_1.gif" alt="종료"></span>
			<button style="display:none;" type="button" class="del_confirm"><img src="/kor/images/btn_end.gif" alt="종료"></button>
		</div>
	</form>
</div>

