<?
/************************************************************************************************************************
**** 판매자 : 송장(30_08) 화면
**** 2016-04-12 : Option(Checkbox) 추가, '취소' 버튼 추가(선택 송장확인, 취소)
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
	var btnConfirm = false; //버튼 상태
	var selCnt=0, opCond=0, opCond1=0, opCond2=0, sqty=0;
	var sel_box;
	var det_cnt = $("#det_cnt_30_08").val();
	//지속적 갯수 카운팅 해보자...
	var part2 = $("#layerPop3 .stock-list-table input[name^=part_type]").length;

	if(det_cnt>1){ //-- 여러개 일때 --------------------------
		sel_box = $("input[name^=odr_det_idx]:checked");
		selCnt = sel_box.length;
	}else{	//-- 한개일때 ---------------------------------------
		sel_box = $("input[name^=odr_det_idx]");
		selCnt=1;
		cntOK = true;
	}
	//지속적공급... 일때, 부품상태 생략
	//필수 값 체크
	$("select[name^=part_condition]").each(function(e){ //부품상태
		if($(this).val().length>0) opCond++;
	});
	$("select[name^=pack_condition1]").each(function(e){ //포장상태1
		if($(this).val().length>0) opCond1++;
	});
	$("select[name^=pack_condition2]").each(function(e){ //포장상태2
		if($(this).val().length>0) opCond2++;
	});
	//부품상태 및 포장상태 - 지속적 갯수 추가
	opCond = opCond + part2;
	opCond1 = opCond1 + part2;
	opCond2 = opCond2 + part2;
	//공급수량 체크
	$("input[name^=supply_quantity]").each(function(e){ //포장상태2
		if($(this).val().replace(/,/gi,"")>0) sqty++;
	});
	//alert("selCnt:"+selCnt);
	//송장확인 버튼
	if(selCnt == det_cnt && opCond==det_cnt && opCond1==det_cnt && opCond2==det_cnt && sqty==det_cnt) btnConfirm = true;
	if(btnConfirm){
		$("#btn_confirm_3008").css("cursor","pointer").addClass("btn-view-sheet-3009").attr("src","/kor/images/btn_invoice_confirm.gif");
	}else{
		$("#btn_confirm_3008").css("cursor","").removeClass("btn-view-sheet-3009").attr("src","/kor/images/btn_invoice_confirm_1.gif");
	}
	//취소 버튼
	if(selCnt>0){
		$("#btn_cancel_3008").css("cursor","pointer").addClass("btn-cancel-3008").attr("src","/kor/images/btn_cancel.gif");
	}else{
		$("#btn_cancel_3008").css("cursor","").removeClass("btn-cancel-3008").attr("src","/kor/images/btn_cancel_1.gif");
	}
}
$(document).ready(function(){
	$("#layerPop3 .stock-list-table tbody:eq(0) tr:eq(0) td").addClass("first");
	//-- 옵션(체크박스) 클릭
	$("#layerPop3 .stock-list-table input[name^=odr_det_idx]").click(function(e){
		checkActive();
	});
	//-- 부품상태 변경
	$("select[name^=part_condition]").change(function(e){
		checkActive();
	});
	//-- 포장상태1 변경
	$("select[name^=pack_condition1]").change(function(e){
		checkActive();
	});
	//-- 포장상태2 변경
	$("select[name^=pack_condition]").change(function(e){
		checkActive();
	});
	checkActive();
	//공급수량 키업~
	$("input[name^=supply_quantity]").keyup(function(e){
		//2016-11-13 : 턴키는 제외..
		if($(this).attr("part_type")!="7"){
			maskoff();
			var supply_quantity = $(this).attr("origin_qty");
			//alert(quantity);
			if(parseInt($(this).val()) > parseInt(supply_quantity)){
				$(this).val("");
			}
			maskon();
			checkActive();
		}
	});
});

</SCRIPT>
<?
  $det_cnt = QRY_CNT("odr_det"," and odr_idx=$odr_idx ");  //odr_det 수량
  $odr = get_odr($odr_idx);
  $buy_com_idx = $odr["rel_idx"]>0?$odr["rel_idx"] : $odr["mem_idx"];
  $sell_com_idx = $odr["sell_rel_idx"]>0?$odr["sell_rel_idx"] : $odr["sell_mem_idx"];
  $odr_period = $odr["period"];
  $b_mem = get_mem($buy_com_idx);
  $s_mem = get_mem($sell_com_idx);

  $b_nation = $b_mem[nation];
  $s_nation = $s_mem[nation];
?>
<div class="layer-hd">
	<h1>송장(3008)-<?=$odr_idx;?></h1>
	<a href="#" class="btn-close"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>
</div>
<div class="layer-content">
	<form name="f" id="f" method="post" >
	<input type="hidden" name="typ" value="invreg">	
	<input type="hidden" name="odr_idx" id="odr_idx_30_08" value="<?=$odr_idx?>">	
	<input type="hidden" name="det_cnt" id="det_cnt_30_08" value="<?=$det_cnt?>">
	<input type="hidden" name="odr_period" id="odr_period" value="<?=$odr_period?>">
	<input type="hidden" name="load_page" id="load_page" value="30_08">
		<!-- layer-file -->
		<div class="layer-file">
			<table>
				<tbody>
					<tr>
						<td class="company"><img src="/kor/images/nation_title_<?=$b_nation?>.png" alt="<?=GF_Common_GetSingleList("NA",$b_nation)?>"> <span class="name">&nbsp&nbsp<?=$b_mem[mem_nm_en]?></span></td>
					</tr>
				</tbody>
			</table>
		</div>
		<!-- //layer-file -->
		
		<div class="layer-data">
			<table class="stock-list-table bg-type2">
				<thead>
					<tr>
						<?if($det_cnt>1){?>
						<th scope="col" style="width:50px">Option</th>
						<?}?>
						<th scope="col" class="t-no">No. </th>
						<th scope="col" class="t-partno" Style="width:<?=($det_cnt>1)? "170":"170";?>px;">Part No.</th>
						<th scope="col" class="t-Manufacturer" Style="width:160">Manufacturer</th>
						<th scope="col" class="t-Package">Package</th>
						<th scope="col" class="t-dc">D/C</th>
						<th scope="col" class="t-rohs">RoHS</th>
						<th scope="col" class="t-oty">O'ty</th>
						<th scope="col" class="t-unitprice">Unit Price</th>
						<th scope="col" lang="ko" class="t-orderoty" >발주수량</th>
						<th scope="col" lang="ko" class="t-supplyoty" Style="whdth:66px;">공급수량</th>
						<th scope="col" lang="ko" class="t-period">납기</th>
					</tr>
				</thead>

				<?	for ($i = 1; $i<=7; $i++){
						echo GET_ODR_DET_LIST("30_08", $i," and odr_idx=$odr_idx ", $det_cnt);
				}?>

				
				<tbody >
					<tr <?if (QRY_CNT("odr_det", "and odr_idx = $odr_idx and part_type =2") > 0){echo "disabled";}?>  class="bg-none">
						<td></td>
						<td colspan="11" style="padding:0">
							<table class="detail-table mr-t0">
								<tbody>									
									<?if ($b_nation ==$s_nation){
									$tax = get_any("tax", "tax_percent", "nation=$b_nation ");
									$tax_name = get_any("tax", "tax_name", "nation=$b_nation");
									?>
									<tr>
										<td colspan="4" style="padding-left:3px"><label class="ipt-chk chk2"><input type="checkbox" disabled="disabled" <?if ($tax){?>checked class="checked"<?}?>><span></span> <?=$tax_name?>  <input type="text" class="i-txt5" name="tax" value="<?=$tax?>" style="width:50px;text-align:right;margin-bottom:5px;" <?if (QRY_CNT("odr_det", "and odr_idx = $odr_idx and part_type =2") > 0){echo "readonly";}?>> %</label></td>
									</tr>
									<?}?>
									<tr>
										<td colspan="4">
										<?$assign = get_any("assign", "o_company_idx", "rel_idx = (SELECT case when sell_rel_idx = 0 then sell_mem_idx else sell_rel_idx end as com_idx FROM `odr` WHERE odr_idx =$odr_idx) and assign_type = 1");
										if ($assign) { ?>
											<label class="ipt-chk chk2 c-red"><input type="checkbox" class="btn-pop-1504 checked" loadPage="30_08" checked odr_idx="<?=$odr_idx?>" name="appoint_yn" value="Y"><span></span> 판매자 지정 운송회사 <span id="appoint"> : <img src='/kor/images/icon_<?=strtolower(GF_Common_GetSingleList("DLVR",$assign))?>.gif' height='15'></span></label>
										<?}else{?>
										&nbsp;<label class="ipt-chk chk2"><input type="checkbox" class="btn-pop-1504" loadPage="30_08" odr_idx="<?=$odr_idx?>" name="appoint_yn" value="Y"><span></span> 판매자 지정 운송회사 <span id="appoint"></span></label>
										<?}?>
										</td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		
		<div class="btn-area t-rt">
			<img src="/kor/images/btn_invoice_confirm_1.gif" id="btn_confirm_3008" alt="송장 확인">
			<!--button type="button" class="btn-view-sheet-3009"><img src="/kor/images/btn_invoice_confirm_1.gif" alt="송장 확인"></button-->
			<img src="/kor/images/btn_cancel_1.gif" id="btn_cancel_3008" alt="취소">
		</div>
	</form>
</div>

