<?
/*********************************************************************************************
** MyBank 입금완료 메세지
** 2016-10-02 : 보증금 반환 정보가 있을 경우 메세지창 처리.
**********************************************************************************************/
@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";

//$(".btn-area.t-rt button").attr("onclick","alert_msg('처리중입니다.')"); 버튼 클릭시 한번 이상 안눌리게.
if ($alert =="sessionend"){
	$alert_msg = "세션이 종료되었습니다. 다시 로그인이 필요합니다.";
}
?>	
<Script Language="javascript">
$(document).ready(function(){
	$("body").on("click",".btn-close-payment",function(){
		var menu_type_chk = getCookie('menu');

		closeCommLayer("layer6");
		closeCommLayer("layer5");	//invoic 닫고
		closeCommLayer("layer3");	//송장(3008) 닫고
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
	});
});
</script>
<div class="layer-hd">
	<h1>입금</h1>
	<!--a href="#" class="btn-close payment"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a-->
</div>
<div class="layer-content">
	<p class="txt-warning t-ct"><span class="c-blue">My Bank  - $<?=round_down($amt,4)?></span> 충전 되었습니다.</p>
	<div class="btn-area t-rt">
		<button class="btn-close-payment" type="button"><img alt="button" src="/kor/images/btn_complete.gif"></button>
	</div>
</div>

