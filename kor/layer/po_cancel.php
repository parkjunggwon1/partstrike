<?
/************************************************************************************************************************
**** 판매자 : 송장(30_08) 화면에서 품목 선택 후 '취소' 버튼 시 안내 및 사유, 종료 - 2016-04-12 신규작성
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
	//alert("check");
	var det_cnt = $(".po-cancel input[name^=odr_det_idx]").length;
	var sqty = 0;
	//필수 값 체크

	$("input[name^=reason]").each(function(e){ //사유
		if($(this).val().length>0) sqty++;
	});
	if(sqty == det_cnt){
		$("#btn_po_cancel").css("cursor","pointer").addClass("btn-po-cancel").attr("src","/kor/images/btn_end.gif");
	}else{
		$("#btn_po_cancel").css("cursor","").removeClass("btn-po-cancel").attr("src","/kor/images/btn_end_1.gif");
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
  $modify_in_odr = QRY_CNT("odr_history", "and odr_idx = $odr_idx  and status in (3)") > 0 ? "Y": "N";  //수정발주서인지 확인
?>
<div class="layer-hd">
	<h1>취소</h1>
	<a href="#" class="btn-close po-cancel"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>
</div>
<div class="layer-content po-cancel">
	<form name="f_pocancel" id="f_pocancel" method="post" >
	<input type="hidden" name="actty" value="POCS">	
	<input type="hidden" name="odr_idx" id="odr_idx_30_08" value="<?=$odr_idx?>">
	<input type="hidden" name="cancel_det_idx" id="cancel_det_idx" value="<?=$cancel_det_idx?>">
	<input type="hidden" name="load_page" id="load_page_30_08" value="<?=$load_page?>">
		<!-- layer-file -->
		<?if($load_page == "30_08" || $load_page == "30_16"){?>
		<div class="layer-file">
			<table>
				<tbody>
					<tr>
						<td class="company">
						<img src="/kor/images/nation_title_<?=$b_nation?>.png" alt="<?=GF_Common_GetSingleList("NA",$b_nation)?>"> <span class="name">
						<a href="javascript:layer_company_det('<?=$buy_com_idx?>');" style="color:#00759e;"><?=$b_mem[mem_nm_en]?></a></span>
						</td>
						<td class="c-red2" style="font-size:14px;">
							취소 시 해당 품목은 당신의 재고 목록에서 삭제됩니다. <br>
							만약 해당 품목을 판매하고 싶다면 재 등록해 주시기 바랍니다.
						
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
						<th scope="col" class="t-no">No. </th>
						<?if($load_page == "09_01"){?>
						<th scope="col" class="t-nation">Nation</th>
						<?}?>
						<th scope="col" class="t-lt" Style="width:280px;">Part No.</th>
						<th scope="col" class="t-Manufacturer" Style="width:210px;">Manufacturer</th>
						<th scope="col" class="t-Package">Package</th>
						<th scope="col" class="t-dc">D/C</th>
						<th scope="col" class="t-rohs">RoHS</th>
						<th scope="col" class="t-oty" style="width:66px;">O'ty</th>
						<th scope="col" class="t-unitprice" style="width:66px;">Unit Price</th>
						<th scope="col" class="t-orderoty t-rt" lang="ko" style="width:66px;">발주수량</th>
						<?if($load_page == "09_01" || $load_page == "30_08" ){?>
						<th scope="col" class="t-supplyoty t-rt" style="width:66px;" lang="ko">공급수량</th>
						<?}?>
						<th scope="col" lang="ko" class="t-period">납기</th>
						<?if($load_page == "09_01"){?>
						<th scope="col" class="t-company">Company</th>
						<?}?>
					</tr>
				</thead>
				<?	for ($i = 1; $i<=7; $i++){
						//echo GET_ODR_DET_LIST("30_08", $i," and odr_idx=$odr_idx ", $det_cnt); //기존 30_08
						//맨 처음인걸 가리기 위해... 2016-04-28
						$q_cnt = QRY_CNT("odr_det a left outer join part b on  a.part_idx = b.part_idx "," and odr_det_idx IN ($cancel_det_idx) and b.part_type =$i ");
						if($q_cnt>0) $first_yn++;
						echo GET_ODR_DET_LIST("po_cancel", $i," and odr_det_idx IN ($cancel_det_idx) ", $det_cnt, $first_yn);
						if($q_cnt>0) $first_yn++;
				}?>
			</table>
		</div>
		
		<div class="btn-area t-rt">
			<img src="/kor/images/btn_end_1.gif" id="btn_po_cancel" alt="완료">
		</div>
	</form>
</div>

