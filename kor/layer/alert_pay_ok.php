<?
@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";

//$(".btn-area.t-rt button").attr("onclick","alert_msg('처리중입니다.')"); 버튼 클릭시 한번 이상 안눌리게.
if ($alert =="sessionend"){
	$alert_msg = "세션이 종료되었습니다. 다시 로그인이 필요합니다.";
}
?>	
<script>
	function pay_ok(val)
	{
		var f =  document.f;
		var formData = $("#f").serialize(); 
		$(".pay_success").children("img").attr("src","/kor/images/loding_img.gif");
		$(".pay_success").attr("href","#");

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
							var menu_type_chk = getCookie('menu');

							closeCommLayer("layer6");	
							closeCommLayer("layer5");	//invoic 닫고
							closeCommLayer("layer4");	//송장(3008) 닫고
							closeCommLayer("layer");

							
							switch (menu_type_chk) {
								case "order_S"    : if(chkLogin()){order('S'); showajax(".col-right", "side_order");}
								           break;
								case "order_B"    : if(chkLogin()){order('B'); showajax(".col-right", "side_order");}
								           break;
								case "mybox"    : if(chkLogin()){showajax(".col-left", "mybox"); showajax(".col-right", "side_order");}
								           break;
								case "record_S"    : if(chkLogin()){record('S'); showajax(".col-right", "side_order");}
								           break;
								case "record_B"    : if(chkLogin()){record('B'); showajax(".col-right", "side_order");}
								           break;
								case "remit"    : if(chkLogin()){remit('C'); showajax(".col-right", "side_order");}
								           break;
								case "side_order"    : showajax(".col-right", "side_order");
				           					break;
							}				
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
		<a href="javascript:pay_ok(this)" class="pay_success"><img alt="확인" src="/kor/images/btn_ok.gif"></a>
	</div>
</div>

