<?
@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";

//$(".btn-area.t-rt button").attr("onclick","alert_msg('처리중입니다.')"); 버튼 클릭시 한번 이상 안눌리게.
if ($alert =="sessionend"){
	$alert_msg = "세션이 종료되었습니다. 다시 로그인이 필요합니다.";
}
?>	
<script>
	function pay_ok()
	{
		var f =  document.f;
		var formData = $("#f").serialize(); 

		$.ajax({
				url: "/kor/proc/odr_proc.php", 
				data: formData,
				encType:"multipart/form-data",
				success: function (data) {	
				
					//var splData = data.split(":");
					if (trim(data) == "SUCCESS"){			
						<?if ($typ=="pay_access"){?>
							openCommLayer("layer3","18_2_12","?odr_idx=<?=$odr_idx?>&odr_det_idx=<?=$odr_det_idx?>&tot_amt=<?=$tot_amt?>");
						<?}else{?>
							//alert_msg("결제가 완료되었습니다.");
							closeCommLayer("layer4");
							closeCommLayer("layer5");
							location.href='/kor/';						
						<?}?>
						
					}else if (trim(data) == "SUCCESS-Deposit")
					{	
						closeCommLayer("layer4");
						closeCommLayer("layer5");
						openCommLayer("layer","17_16","?mn=05&odr_idx=<?=$odr_idx?>");
					}else{
						alert(data);
					}
				}
		});		
	}
</script>
<div class="layer-hd">
	<h1>결제완료</h1>
	<a href="#" class="btn-close"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>
</div>
<div class="layer-content">
	<p class="txt-warning t-ct"><?=$alert_msg?></p>
	<div class="btn-area t-rt"> <!-- periodreq-->
		<a href="javascript:pay_ok()"><img alt="확인" src="/kor/images/btn_ok.gif"></a>
	</div>
</div>

