<?
/*********************************************************************************************
**[사용자정의 메세지창] 타이틀, 메세지, 버튼이미지명 pram 받고, 버튼 클릭 시 페이지 새로고침
**********************************************************************************************/
@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";

//$(".btn-area.t-rt button").attr("onclick","alert_msg('처리중입니다.')"); 버튼 클릭시 한번 이상 안눌리게.
if ($alert =="sessionend"){
	$alert_msg = "세션이 종료되었습니다. 다시 로그인이 필요합니다.";
}

if ($load_page =="30_16")
{
?>
<script>
	function sunjuk()
	{
		var form_f =  document.form_f;
		
		//f.typ.value="shipping";
		form_f.target = "proc";
		form_f.action = "/kor/proc/odr_proc.php";
		form_f.submit();	
	}
</script>
	<form name="form_f" id="form_f"  method="post">
		<!--<input type="hidden" name="typ" id="typ" value="shipping">	JSJ-->
		<input type="hidden" name="typ" id="typ" value="shipping">
		<input type="hidden" name="weight_yn" id="weight_yn" value="<?=$ship_weight;?>">	
		<input type="hidden" name="status" id="status" value="21">
		<input type="hidden" name="status_name" id="status_name" value="선적완료">
		<input type="hidden" name="fault_yn" id="fault_yn" value="<?=$fault_yn?>">
		<input type="hidden" name="fault_method" id="fault_method" value="<?=$fault_method?>">  <!--교환1/환불2/수량부족3-->
		<input type="hidden" name="sell_mem_idx" id="sell_mem_idx" value="<?=$sell_mem_idx?>">
		<input type="hidden" name="buy_mem_idx" id="buy_mem_idx" value="<?=$buy_mem_idx?>">
		<input type="hidden" name="odr_idx" id="odr_idx_30_16" value="<?=$odr_idx?>">		
		<input type="hidden" name="odr_history_idx" id="odr_history_idx" value="<?=$odr_history_idx?>">		
		<input type="hidden" name="no" id="no" value="<?=$no?>">
		<input type="hidden" name="det_cnt" id="det_cnt_30_16" value="<?=$det_cnt;?>">
		<input type="hidden" name="load_page" id="load_page" value="30_16">
		<input type="hidden" name="ship_info" id="ship_info" value="<?=$ship_info?>">
		<input type="hidden" name="part_condition" id="part_condition" value="<?=$part_condition?>">
		<input type="hidden" name="pack_condition1" id="pack_condition1" value="<?=$pack_condition1?>">
		<input type="hidden" name="pack_condition2" id="pack_condition2" value="<?=$pack_condition2?>">
		<input type="hidden" name="memo" id="memo" value="<?=$memo?>">
		<input type="hidden" name="delivery_no" id="delivery_no" value="<?=$delivery_no?>">
		<input type="hidden" name="delivery_shop" id="delivery_shop" value="<?=$delivery_shop?>">

		<div class="layer-hd">
			<h1><?=$alert_title;?></h1>
			<a href="#" class="btn-close"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>
		</div>
		<div class="layer-content">
			<p class="txt-warning t-ct"><?=$alert_msg?></p>
			<div class="btn-area t-rt"> <!-- periodreq-->
				<a class="btn-refresh" href="javascript:sunjuk();"><img alt="확인" src="/kor/images/<?=$btn;?>.gif"></a>
			</div>
		</div>
	</form>
<?
}
else
{
?>	
	<div class="layer-hd">
		<h1><?=$alert_title;?></h1>
		<a href="#" class="btn-close"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>
	</div>
	<div class="layer-content">
		<p class="txt-warning t-ct"><?=$alert_msg?></p>
		<div class="btn-area t-rt"> <!-- periodreq-->
			<button class="btn-refresh" type="button"><img alt="확인" src="/kor/images/<?=$btn;?>.gif"></button>
		</div>
	</div>
<?
}
?>