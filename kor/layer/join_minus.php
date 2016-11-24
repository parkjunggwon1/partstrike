<?
/*********************************************************************************************
** 회원탈퇴  메세지 2
** 2016-10-10 : 회원탈퇴 메세지창2 처리.
**********************************************************************************************/
@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";

if ($alert =="sessionend"){
	$alert_msg = "세션이 종료되었습니다. 다시 로그인이 필요합니다.";
}
?>	
<Script Language="javascript">
$(document).ready(function(){
	$("body").on("click",".btn-close-payment",function(){
		document.location.href="/kor/";
	});
});
</script>

<div class="layer-hd">
	<h1>인출</h1>
	<a href="#" class="btn-close payment"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>
</div>
<div class="layer-content">
<?

  $last_buy_date = get_any("odr" , "max(reg_date)", "mem_idx = $session_mem_idx");
  $last_sell_date = get_any("odr" , "max(reg_date)", "sell_mem_idx = $session_mem_idx");
  $datetime_now = date("Y-m-d");
  
 //  $last_buy_date = date("Y-m-d",strtotime("2016-04-11"));
 //  $last_sell_date = date("Y-m-d",strtotime("2016-04-11"));
  
   $DateDiff_buy = date_diff(date("Y-m-d",strtotime($last_buy_date)), $datetime_now);
   $DateDiff_sell = date_diff(date("Y-m-d",strtotime($last_sell_date)), $datetime_now);

   $remain_buy = 180- $DateDiff_buy;
   $remain_sell = 180- $DateDiff_sell;

if ($remain_buy > 0 ){
?>
당신의 마지막 구매는 <?=date("Y년 m월 d일",strtotime($last_buy_date))?>입니다. <br/>
보증기간 180일 중 <span style="color:blue"><?=$remain_buy?></span>일 남았습니다. <br/><br/>
<?}

if ($remain_sell > 0 ){
?>
당신의 마지막 판매는 <?=date("Y년 m월 d일",strtotime($last_sell_date))?>입니다.<br/> 
보증기간 180일중 <span style="color:red"><?=$remain_sell?></span>일 남았습니다.<br/><br/>
<?}?>
<?if ($remain_buy> 0 || $remain_sell > 0){?>
보증기간 이후에 인출 가능합니다.

	<div class="btn-area t-rt">
		<img src="/kor/images/btn_invoice_confirm_1.gif" alt="송장 확인">
	</div>
<?}else{
$sum = SumMyBank2($session_mem_idx, $session_rel_idx);
?>

인출 가능합니다. 
	<div class="btn-area t-rt">
		<input type="hidden" name="psb" id="psb" value="<?=$sum?>">
		<input type="hidden" name="rqst_amt" id="rqst_amt" value="<?=$sum?>">
		<input type="hidden" name="remitTy" id="remitTy" value="Y">
		
		<button class="btn-view-sheet-0120" type="button"><img src="/kor/images/btn_invoice_confirm.gif" alt="송장 확인"></button>
	</div>
<?	}?>
</div>

<?function date_diff($d1, $d2){
    return floor( strtotime($d2 ) - strtotime( $d1 ) ) / 86400;
}
?>