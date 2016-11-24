<?
@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
$winner = ($testresult=="OK")? "S":"B";
$fty_his = get_fty_history($fty_history_idx);
//$tTy : 현재 접속자
?>
<div class="layer-hd red">
	<h1>종료</h1>
	<a href="#" class="btn-close"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>
</div>
<div class="layer-content">
	<p class="txt-warning t-lt">
		<?if($winner=="S"){?>
		총 금액, 운임, 재 작업 비용, 테스트 비용 (<span class="c-blue">US$0,000.00 – 은행송금</span>)을 My Bank로 충전합니다.
		<?}else{?>
		위로금, 테스트 비용 (<span class="c-blue">US$0,000.00 – 은행송금</span>)을 My Bank로 충전합니다.
		<?}?>
	</p>
	<div class="btn-area t-rt">
		<button type="button" class="btn-end-proc" faulty_delivery_fee="<?=$faulty_delivery_fee?>"  tTy="<?=$tTy?>" testresult="<?=$testresult?>" fty_history_idx="<?=$fty_history_idx?>">
			<img src="/kor/images/btn_complete.gif" alt="완료">
		</button>
	</div>
</div>

