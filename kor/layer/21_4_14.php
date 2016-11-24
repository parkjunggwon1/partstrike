<?
@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
$winner = $testresult=="OK"? "S":"B";
$fty_his = get_fty_history($fty_history_idx);
?>
<div class="layer-hd red">
	<h1>입금</h1>
	<a href="#" class="btn-close"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>
</div>
<div class="layer-content">
	<p class="txt-warning t-ct"><span lang="en" class="c-blue">My Bank - US$<?=$pay;?></span>
	<?if ($winner == $tTy) {?>	
	충전 되었습니다.
	<?}else{
		if ($tTy== "S"){
			$faulty_delivery_fee =get_any("odr","faulty_delivery_fee", "odr_idx =$fty_his[odr_idx]");
	?>
	에서 운임 <span class="c-blue" lang="en">US<?=number_format($faulty_delivery_fee,2)?></span>을 차감합니다.	 
	<?	}else{
			$faulty_delivery_fee ="";?>
			로 위로금 지불이 완료되었습니다.
		<?}
	}?>
	
	</p>
	<div class="btn-area t-rt">
		<button type="button" class="btn-end-pop" faulty_delivery_fee="<?=$faulty_delivery_fee?>"  tTy="<?=$tTy?>" testresult="<?=$testresult?>" fty_history_idx="<?=$fty_history_idx?>">
			<img src="/kor/images/btn_end.gif" alt="종료">
		</button>
	</div>
</div>

