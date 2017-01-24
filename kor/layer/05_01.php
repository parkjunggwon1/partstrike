<?
/*********************************************************************************
화면 : 발주추가(검색 및 추가)
닫기버튼(X) 클릭 하면...fromLoadPage 를 odr_idx 로 다시 연다.
**********************************************************************************/
@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include $_SERVER["DOCUMENT_ROOT"]."/include/class/class.partinfo.php";
if (!$_SESSION["MEM_IDX"]){ReopenLayer("layer6","alert","?alert=sessionend");exit;}
?>
<script src="/kor/js/jquery-1.11.3.min.js"></script>
<script src="/include/function.js"></script>
<script src="/kor/js/menu.js"></script>
<script>ready();</script>
<SCRIPT LANGUAGE="JavaScript">
<!--
$(document).ready(function(){
	
	$("#addsearch_part_no").focus();
	if($("#addsearch_part_no").val()){
		var ary = new Array();
		var idx, newidx;
		$("#layerPop3 tbody[id^=adtb]").each(function(e){						
			if (typeof($(this).find("tr:eq(1) td:eq(7)").html())=="string")
			{
				ary.push($(this).find("tr:eq(1) td:eq(7)").html());
			}else{
				ary.push("$99999999");
			}
		});

		
		var aryIdx = new Array();
		var temp1 , temp2;
		for (i=0;i<6;i++ )	{aryIdx.push(i);}

		for(i = 0; i < ary.length; i++) {
		   for(j = 0; j < (ary.length - i-1); j++) {
			 if((ary[j]) > (ary[j + 1])) {
			   temp1 = ary[j];
			   ary[j] = ary[j + 1];
			   ary[j + 1] = temp1;
			   temp2 = aryIdx[j];
			   aryIdx[j] = aryIdx[j + 1];
			   aryIdx[j + 1] = temp2;
			 }
		   }
		 }

		 var $sel, totsel="";
		 for (i=0;i<6 ;i++)
		 {										 
			idx =aryIdx[i];						
			newidx = idx+1;
			
			$sel = $("#layerPop3 .stock-list-table #adtb_"+newidx);		
			totsel = totsel + "<tbody id= 'adtb_"+newidx+"'>"+$sel.html()+"</tbody>\n";
		 }
		$("#layerPop3 .stock-list-table tbody").remove();
		$("#layerPop3 .stock-list-table").append($(totsel).fadeIn(300)).show();
		$("#layerPop3 .stock-list-table tbody td").removeClass("first");
		$("#layerPop3 .stock-list-table tbody td:eq(0)").addClass("first");
	
		if($("#layerPop3 tbody[id^=adtb] input[name=odr_quantity]").length>0){
			//대표님 요청으로 삭제 2016-11-23
			//$("#layerPop3 .stock-list-table tbody td:eq(0)").append("<div class='txt_stock' style=' float:right; width:136px; margin-right:10px; padding:0 0 0 0;'><img src='/kor/images/txt_stock_r1.gif' alt='재고수량 이하로 입력'></div>");
		}
	}
	//수량 키 입력 이벤트 ---------------------------------------
	$("#f_add .layer-content input:text").keyup(function(e){
		if(window.event.keyCode==13){
			$(this).parent().next().find("button").click();
		}else{
			var $this = $(this).parent().next();
			if ($(this).val()!="")
			{
				$this.find("span").hide();
				$this.find("button").show();
			}else{
				$this.find("button").hide();
				$this.find("span").show();		
			}
		}
	});


});
//-->
</script>
<?$odr=get_odr($odr_idx);
	$sell_mem_idx = $odr[sell_mem_idx];
	$sell_rel_idx = $odr[sell_rel_idx];
	$odr_status = $odr[odr_status];
?>
<!----------- Stock parts --------------------------------->
<form name="f_addproc" id = "f_addproc">
	<input type="hidden" name="odr_idx" value="<?=$odr_idx?>">
	<input type="hidden" name="part_idx" value="">	
	<input type="hidden" name="part_type" value="">	
	<input type="hidden" name="odr_quantity" id="odr_quantity_0501" value="">	
	<input type="hidden" name="typ" value="">
	<input type="hidden" name="sell_mem_idx" id="sell_mem_idx" value="<?=$sell_mem_idx?>">
	<input type="hidden" name="fromPage" value="add">
	<input type="hidden" id="fromLoadPage" name="fromLoadPage" value="<?=$fromLoadPage?>">
	<input type="hidden" name="addsearch_part_no" value="<?=$addsearch_part_no?>">
</form>
<!----------- Period parts --------------------------------->
<form name="f_add" id="f_add">
	<input type="hidden" name="odr_idx" id="odr_idx_05_01" value="<?=$odr_idx?>">
	<input type="hidden" name="part_idx" value="">	
	<input type="hidden" name="part_type" value="">	
	<input type="hidden" name="odr_quantity" value="">	
	<input type="hidden" name="typ" value="">
	<input type="hidden" name="sell_mem_idx" id="sell_mem_idx" value="<?=$sell_mem_idx?>">
	<input type="hidden" name="fromPage" value="add">
	<input type="hidden" name="fromLoadPage" value="<?=$fromLoadPage?>">
	
<div class="layer-hd has-srch">
	<h1>발주 추가</h1>
	
	<section class="box-type5 srch1">
		<table>
			<tbody>
				<tr>
					<th scope="row" style="width:40px"><label lang="en">Part No.</label></th>
					<td>
						<input type="text" style="width:205px; ime-mode:disabled" maxlength="30" name="addsearch_part_no" id="addsearch_part_no" value="<?=$addsearch_part_no?>" onkeypress="if(window.event.keyCode==13){	btn_addSearch();return false;}" >
					</td>
					<td><button type="button" class="btn-addsearch"><img src="/kor/images/btn_srch.gif" alt="검색"></button></td>
				</tr>
			</tbody>
		</table>
	</section>
	<a href="#" class="btn-close btn-order-periodconfirm 0501"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>
</div>
<div class="layer-content">
	
	<table class="stock-list-table" style="display:<?if ($addsearch_part_no){?>none<?}?>;">
		<thead>
			<tr>
				<th scope="col" class="t-no">No. </th>
				<th scope="col" class="t-partno" Style="width:270px;">Part No.</th>
				<th scope="col" class="t-Manufacturer">Manufacturer</th>
				<th scope="col" class="t-Package">Package</th>
				<th scope="col" class="t-dc">D/C</th>
				<th scope="col" class="t-rohs">RoHS</th>
				<th scope="col" class="t-oty">O'ty</th>
				<th scope="col" class="t-unitprice">Unit Price</th>
				<th scope="col" lang="ko" class="t-orderoty">발주수량</th>
				<th scope="col" lang="ko" style="width:50px">납기</th>
			</tr>
		</thead>
		<?	for ($i = 1; $i<=6; $i++){							
				if($fromLoadPage != "09_01" || ( $fromLoadPage =="09_01" && ($i ==1 || $i == 3 || $i == 4))){
				$searchand = "and mem_idx = $sell_mem_idx and part_idx not in (select part_idx from odr_det where odr_idx = $odr_idx) ";
				if ($addsearch_part_no){
						$searchand .= "and part_no like '%$addsearch_part_no%' "; 
				}else{
						$searchand .= "and part_no = '' and manufacturer = '' and rhtype = ''";
				}
				echo GET_ADDPART_LIST($i , $searchand);
			}
		}?>
		
	</table>
	<!--
	<div class="btn-area t-rt">
		<button type="button" class="btn-order-periodconfirm"><img src="/kor/images/btn_close.gif" alt="닫음"></button>
	</div>-->
</div>

</form>   


