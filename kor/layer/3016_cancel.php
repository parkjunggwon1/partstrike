<?
/************************************************************************************************************************
**** 판매자 : 선적(30_16) 화면에서 품목 선택 후 '취소' 버튼 시
************************************************************************************************************************/
@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include $_SERVER["DOCUMENT_ROOT"]."/include/class/class.odrinfo.php";
?>

<script src="/kor/js/jquery-1.11.3.min.js"></script>
<script src="/include/function.js"></script>
<script>ready();</script>
<SCRIPT LANGUAGE="JavaScript">
function checkActive(){
	var det_cnt = $(".po-cancel input[name^=odr_det_idx]").length;
	var selCnt = 0;
	var sqty = 0;

	sel_box = $("input[name^=odr_det_idx]:checked");
	selCnt = sel_box.length;
	//필수 값 체크

	$("input[name^=reason]").each(function(e){ //사유
		if($(this).val().length>0) sqty++;
	});

	if((sqty == selCnt && selCnt>0) || det_cnt==1){
		$("#btn_refund_cancel").css("cursor","pointer").addClass("btn-refund-cancel").attr("src","/kor/images/btn_refund.gif");
	}else{
		$("#btn_refund_cancel").css("cursor","").removeClass("btn-refund-cancel").attr("src","/kor/images/btn_refund_1.gif");
	}
}
$(document).ready(function(){
	$("#layerPop3 .stock-list-table tbody:eq(0) tr:eq(0) td").addClass("first");
	//-- 사유 항목 이벤트
	$("input[name^=reason]").keyup(function(e){
		checkActive();
	});
	$("input[name^=reason]").change(function(e){
		checkActive();
	});
	$("input[name^=reason]").click(function(e){
		checkActive();
	});
	//-- 옵션(체크박스) 클릭
	$("#layerPop3 .stock-list-table input[name^=odr_det_idx]").click(function(e){
		var det_idx = $(this).val();
		if($(this).is(':checked')){
			$("#desc_"+det_idx).show();
		}else{
			$("#desc_"+det_idx).hide();
		}
		checkActive();
	});
	checkActive();
});
</SCRIPT>
<?
  $det_cnt = QRY_CNT("odr_det"," and odr_idx=$odr_idx ");  //odr_det 수량
  $odr = get_odr($odr_idx);
  $buy_com_idx = $odr["rel_idx"]>0?$odr["rel_idx"] : $odr["mem_idx"];
  $sell_com_idx = $odr["sell_rel_idx"]>0?$odr["sell_rel_idx"] : $odr["sell_mem_idx"];
  $b_mem = get_mem($buy_com_idx);
  $s_mem = get_mem($sell_com_idx);

  $b_nation = $b_mem[nation];
  $s_nation = $s_mem[nation];
?>
<div class="layer-hd">
	<h1>취소</h1>
	<a href="#" class="btn-close 3016_cancel"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>
</div>
<div class="layer-content po-cancel">
	<form name="f_pocancel" id="f_pocancel" method="post" >
	<input type="hidden" name="actty" value="POCS">	
	<input type="hidden" name="odr_idx" id="odr_idx_3016_cancel" value="<?=$odr_idx?>">
	<input type="hidden" name="cancel_det_idx" id="cancel_det_idx" value="<?=$cancel_det_idx?>">
	<input type="hidden" name="load_page" id="load_page_3016_cancel" value="<?=$load_page?>">
		<!-- layer-file -->
		<?if($load_page == "30_08" || $load_page == "30_16"){?>
		<div class="layer-file">
			<table>
				<tbody>
					<tr>
						<td class="company">
						<img src="/kor/images/nation_title_<?=$b_nation?>.png" alt="<?=GF_Common_GetSingleList("NA",$b_nation)?>"> <span class="name"><?=$b_mem[mem_nm_en]?></span>
						</td>
						<td class="c-red2" style="font-size:14px;">
							<?if($det_cnt>1){	//여러개?>
							아래의 모든 품목이 일괄 취소됩니다.<br>
							선택한 품목은 당신의 재고 목록에서 삭제됩니다. <br>
							<?}else{	//한개?>
							취소 시 해당 품목은 당신의 재고 목록에서 삭제됩니다. <br>
							<?}?>
							만약 해당 품목을 판매하고 싶다면 재 등록해 주시기 바랍니다
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<?}?>
		<!-- //layer-file -->
		
		<div class="layer-data">
			<table class="stock-list-table bg-type2">
				<thead>
					<tr>
						<th scope="col" style="width:20px">No. </th>
						<th scope="col" class="t-lt" style="width:280px;">Part No.</th>
						<th scope="col" class="t-lt">Manufacturer</th>
						<th scope="col" style="width:80px;">Package</th>
						<th scope="col" style="width:36px;">D/C</th>
						<th scope="col" style="width:36px;">RoHS</th>
						<th scope="col" style="width:60px;" class="t-rt">O'ty</th>
						<th scope="col" class="t-rt" style="width:61px;">Unit Price</th>
						<th scope="col" class="t-rt" style="width:80px;">Amount</th>
						<th scope="col" lang="ko"style="width:36px;">납기</th>
						<?if($det_cnt>1){?>
						<th scope="col" class="t-ct" style="width:30px">취소</th>
						<?}?>
					</tr>
				</thead>
				<?	for ($i = 1; $i<=7; $i++){
						echo GET_ODR_DET_LIST("3016_cancel",$i," and odr_idx=$odr_idx ", $det_cnt);
				}?>
			</table>
		</div>
		
		<div class="btn-area t-rt">
			<img src="/kor/images/btn_refund_1.gif" id="btn_refund_cancel" alt="환불">
		</div>
	</form>
</div>

