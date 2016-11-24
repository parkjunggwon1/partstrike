<script type="text/javascript">
<!--
	$("#mem_pwd").keyup(function(e){
		if($(this).val()==""){
			$(".pass-form form span:eq(1)").show();
			$(".pass-form form button").hide();
		}else{
			$(".pass-form form span:eq(1)").hide();
			$(".pass-form form button").show();
		}

	});
//-->
</script>
			<section class="box-type1">
				<div class="pass-form">
					<h3 class="c-red" style="margin-bottom:8px">비밀번호 확인</h3>
					
					<p>고객님의 개인 정보 보호를 위해 비밀번호를 다시 한번 입력해주시기 바랍니다.</p>
					<form>
						<label><span lang="en">Password</span> <input type="password" id="mem_pwd" class="i-txt5" onkeypress="check_key(confirmPwd);" style="width:222px"></label>
						<span><img src="/kor/images/btn_ok2_1.gif" alt="확인"></span>
						<button style="display:none;" type="button" class="confirmpwd"><img src="/kor/images/btn_ok2.gif" alt="확인"></button>
					</form>
				</div>
			</section>