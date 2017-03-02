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

$vat_price = get_any("ship" ,"tax", "odr_idx=$odr_idx limit 1");    //부가세

if($vat_price==0)
{
    $vat_price = get_any("tax" ,"tax_percent", "nation=$ship_nation "); //부가세
}
//echo $vat_price."BBBBB";

$vat_val = $vat_price/100;
$vat_plus =  $amt*$vat_val;    

$buy_amt = $amt + $vat_plus;

?>	
<Script Language="javascript">
function pay_ok()
{
	var formData = $("#f_19_1_05R").serialize();
	
	$.ajax({
			url: "/kor/proc/odr_proc.php", 
			data: formData,
			encType:"multipart/form-data",
			success: function (data) {						
				if (trim(data) == "SUCCESS"){		
					//openCommLayer("layer3","19_1_05","?forgenl=<?=$forgenl?>");	
					document.location.href="/kor/";
				}else{
					alert(data);
				}
			}
	});
}

</script>
<div class="layer-hd">
	<h1>입금</h1>
	<a href="#" class="btn-close payment"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>
</div>
<div class="layer-content">
	<p class="txt-warning t-ct"><span class="c-blue">My Bank  - $<?=$buy_amt?></span> 충전 되었습니다.</p>
	<div class="btn-area t-rt">
		<button  type="button" onclick="pay_ok();"><img alt="button" src="/kor/images/btn_complete.gif"></button>
	</div>
</div>
<form name="f_19_1_05R" id="f_19_1_05R">
	<!-- form1 -->
	<input type="hidden" name="typ" id="typ" value="<?=$_GET['typ']?>">
	<input type="hidden" name="odr_idx" id="odr_idx" value="<?=$_GET['odr_idx']?>">		
	<input type="hidden" name="odr_det_idx" id="odr_det_idx" value="<?=$_GET['odr_det_idx']?>">
	<input type="hidden" name="typ" value="refund2">
	<input type="hidden" name="odr_history_idx" id="odr_history_idx" value="<?=$_GET['odr_history_idx']?>">
	<input type="hidden" name="mem_idx" value="<?=$_GET['mem_idx']?>">
	<input type="hidden" name="rel_idx" value="<?=$_GET['rel_idx']?>">
	<input type="hidden" name="sell_mem_idx" value="<?=$_GET['sell_mem_idx']?>">
	<input type="hidden" name="sell_rel_idx" value="<?=$_GET['sell_rel_idx']?>">
	<input type="hidden" name="tot_amt" value="<?=$_GET['fault_sum']?>">
	<input type="hidden" name="fault_select" value="<?=$_GET['fault_select']?>">
	<input type="hidden" name="charge_method" value="<?=$_GET['charge_method']?>">
	
	<input type="hidden" name="invoice_no" value="<?=$row_odr_det["invoice_no"]?>">		
	<!-- //form1 -->
</form>

