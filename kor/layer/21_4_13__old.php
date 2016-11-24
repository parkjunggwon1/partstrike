<?
@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
$winner = $testresult=="OK"? "S":"B";
$fty_his = get_fty_history($fty_history_idx);
if ($winner == $tTy) {	//tTy:행위자(판매자:S, 구매자:B)
	$layername="결제완료";
	if($tTy =="S"){
		$mybank_idx = get_any("mybank", "mybank_idx", "odr_idx=".$fty_his[odr_idx]." and odr_det_idx=".$fty_his[odr_det_idx]." and charge_type=11 and mem_idx=".$fty_his[buy_mem_idx]);
		$mybank = get_mybank($mybank_idx);
		$layer_txt = "부대비용, 위로금, 테스트 비용 (US$".number_format(-$mybank[charge_amt],2)." – ".$mybank[charge_method]=="1"?"신용카드":($mybank[charge_method]=="2"?"입금":"My Bank")." 결제가 완료되었습니다.";
	}else{
		$mybank_idx = get_any("mybank", "mybank_idx", "odr_idx=".$fty_his[odr_idx]." and odr_det_idx=".$fty_his[odr_det_idx]." and charge_type=13 and mem_idx=".$fty_his[sell_mem_idx]);
		$mybank = get_mybank($mybank_idx);
		$layer_txt = "총 금액, 부대비용, 재 작업 비용, 테스트 비용 (US$".number_format(-$mybank[charge_amt],2)." – ".($mybank[charge_method]=="1"?"신용카드":($mybank[charge_method]=="2"?"입금":"My Bank")).") 결제가 완료되었습니다.";
	}
}else{
	$layername="종료";
	$layer_txt = "모든 처리가 완료되었습니다.";
}
?>

<div class="layer-hd red">
	<h1><?=$layername?></h1>
	<a href="#" class="btn-close"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>
</div>



<div class="layer-content">
	<div class="layer-data">
		<div class="layer-file">
			<table>
				<tbody>
					<tr>
						<?if ($tTy=="S"){?><td class="company"></td>
						<?}?>
						<td class="c-red2 w100 t-ct"><?=$layer_txt?></td>
					</tr>
				</tbody>
			</table>
		</div>
		<table class="stock-list-table" id="list_21_4_13">
		</table>
	</div>
	
	<div class="btn-area t-rt">
		<button type="button" class="btn-pop-21-4-14" tTy="<?=$tTy?>" testresult="<?=$testresult?>" fty_history_idx="<?=$fty_history_idx?>"><img alt="종료" src="/kor/images/btn_end.gif"></button>
	</div>
</div>



<SCRIPT LANGUAGE="JavaScript">
<!--

$(document).ready(function(){
	$("#list_21_4_13").html($("#list_<?=$loadPage?>").html());
	$("#list_21_4_13 tr.bg-none").css("display","none");	
	if($("#list_21_4_13").prev().find(".company").length>0){
		$("#list_21_4_13").prev().find(".company").html($("#list_<?=$loadPage?>").parent().prev().find(".company").html());
	}
	
});
-->
</SCRIPT>