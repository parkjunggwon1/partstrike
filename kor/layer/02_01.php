<script src="/kor/js/jquery-1.11.3.min.js"></script>
<script>
$("#reason").keyup(function(e){
	var $this = $(this).parent().next();
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
	<h1>삭제</h1>
	<a href="#" class="btn-close"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>
</div>
<div class="layer-content">
	<form class="t-ct">
		<p class="mr-b15"><img src="/kor/images/btn_img_rs.gif" alt="사유"></p>
		<p><input type="text" id="reason" class="i-txt2 c-blue w100" value=""></p>
		<div class="btn-area t-rt">
		<span><img src="/kor/images/btn_end_1.gif" alt="종료"></span>
			<button style="display:none;" type="button" class="del_confirm"><img src="/kor/images/btn_end.gif" alt="종료"></button>
		</div>
	</form>
</div>

