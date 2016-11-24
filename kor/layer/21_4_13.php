<?
@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
$winner = $testresult=="OK"? "S":"B";
$fty_his = get_fty_history($fty_history_idx);
if ($winner == $tTy) {	//내가 이겼다!! tTy:행위자(판매자:S, 구매자:B)
	$layername="결제완료";
	if($tTy =="S"){	//내가(승리자) 판매자 일때...
		//$mybank_idx = get_any("mybank", "mybank_idx", "odr_idx=".$fty_his[odr_idx]." and odr_det_idx=".$fty_his[odr_det_idx]." and charge_type=11 and mem_idx=".$fty_his[buy_mem_idx]);
		$mybank_idx = get_any("mybank", "mybank_idx", "odr_idx=".$fty_his[odr_idx]." and odr_det_idx=".$fty_his[odr_det_idx]." and charge_type=12 and mem_idx=".$fty_his[buy_mem_idx]);
		$mybank = get_mybank($mybank_idx);
		$pay = -($mybank[charge_amt]) - 1000;	//위로금 계산
		$pay_method = $mybank[charge_method]=="1"?"신용카드":($mybank[charge_method]=="2"?"은행송금":"My Bank");
		$layer_txt = "위로금 <span class='c-blue'>(US$".number_format($pay,2)." – ".$pay_method.")</span> 결제가 완료되었습니다.";
	}else{		//내가(승리자) 구매자 일때...
		//$mybank_idx = get_any("mybank", "mybank_idx", "odr_idx=".$fty_his[odr_idx]." and odr_det_idx=".$fty_his[odr_det_idx]." and charge_type=13 and mem_idx=".$fty_his[sell_mem_idx]);
		$mybank_idx = get_any("mybank", "mybank_idx", "odr_idx=".$fty_his[odr_idx]." and odr_det_idx=".$fty_his[odr_det_idx]." and charge_type=12 and mem_idx=".$fty_his[sell_mem_idx]);
		$mybank = get_mybank($mybank_idx);
		$pay = -($mybank[charge_amt]) - 1000;	//비용
		$pay_method = $mybank[charge_method]=="1"?"신용카드":($mybank[charge_method]=="2"?"은행송금":"My Bank");
		$layer_txt = "총 금액, 부대비용, 재 작업 비용 <span class='c-blue'>(US$".number_format($pay,2)." – ".$pay_method.")</span> 결제가 완료되었습니다.";
	}
}else{	//내가 졌다.
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
	<?if(($tTy =="B" && $winner=="S") || ($tTy =="S" && $winner=="B")){?>
		<button type="button" class="btn-end-proc" tTy="<?=$tTy?>" testresult="<?=$testresult?>" fty_history_idx="<?=$fty_history_idx?>" pay="<?=number_format($pay,2)?>" faulty_delivery_fee="<?=$faulty_delivery_fee;?>">
			<img alt="종료" src="/kor/images/btn_end.gif">
		</button>
	<?}else{?>
		<button type="button" class="btn-pop-21-4-14" tTy="<?=$tTy?>" testresult="<?=$testresult?>" fty_history_idx="<?=$fty_history_idx?>" pay="<?=number_format($pay,2)?>">
			<img alt="입금" src="/kor/images/btn_deposit3.gif">
		</button>
	<?}?>
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
	$("#layerPop3 .stock-list-table tbody:eq(0) tr:eq(0) td").addClass("first");
	
});
-->
</SCRIPT>