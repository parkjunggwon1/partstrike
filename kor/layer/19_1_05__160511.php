<?
@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include  $_SERVER["DOCUMENT_ROOT"]."/include/class/class.odrinfo.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.member.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.record.php";
?>
<div class="layer-hd">
	<h1>환불</h1>
	<?if ($ty == ""){ $ty = "succEnd";}?>
	<a href="#" class="btn-close"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>
</div>
<div class="layer-content">
	<form name="f" id="f">
		<!-- form1 -->
		<input type="hidden" name="typ" id="typ" value="<?=$ty?>">
		<input type="hidden" name="odr_idx" id="odr_idx" value="<?=$odr_idx?>">		
		<input type="hidden" name="odr_det_idx" id="odr_det_idx" value="<?=$odr_det_idx?>">		
		<!-- //form1 -->
	</form>
	<?
	//member
	$buy_com_idx = get_any("odr", "mem_idx", "odr_idx = $odr_idx");
	$result_mem =QRY_MEMBER_VIEW("idx",$buy_com_idx);
	$row_mem = mysql_fetch_array($result_mem);
	$buy_com_nation = $row_mem["nation"];
	$buy_com_name = $row_mem["mem_nm_en"];					  
	//odr_det
	$result =QRY_ODR_DET_LIST(0,"and a.odr_idx=$odr_idx and a.odr_det_idx=$odr_det_idx",0,"","asc");
	//history
	$fault_select = get_any("odr_history", "fault_select", "odr_history_idx=$odr_history_idx");
	$amt = get_any("odr_det a INNER JOIN part b ON a.part_idx = b.part_idx", "(a.fault_quantity * b.price)", "odr_idx = $odr_idx AND odr_det_idx = $odr_det_idx");
	?>
	<div class="layer-file" id="file_19_1_05">
		<table>
			<tbody>
				<tr>
					<td class="company" colspan="2"><img src="/kor/images/nation_title_<?=$buy_com_nation?>.png" alt="<?=GF_Common_GetSingleList("NA",$buy_com_nation)?>"> <span class="name"><?=$buy_com_name?></span></td>
					<td class="c-red2 t-ct">환불(<span class="c-blue" lang="en">US$<?=number_format($amt,2);?> - MyBank</span>)이 완료되었습니다.</td>
					<td class="t-rt"><div class="re-select"><strong>선택</strong><?if ($fault_select=="1"){?><em>교환</em><?}else{?><em>반품</em><?}?></div></td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="layer-data" id="data_<?=$loadPage?>">
		<table class="stock-list-table" id="list_<?=$loadPage?>">
			<thead>
				<tr>
					<th scope="col" class="t-no">No.</th>
					<th scope="col" class="t-partno">Part No.</th>
					<th scope="col" class="t-Manufacturer">Manufacturer</th>
					<th scope="col" class="t-Package">Package</th>
					<th scope="col" class="t-dc">D/C</th>
					<th scope="col" class="t-rohs">RoHS</th>
					<th scope="col" class="t-unitprice">Unit Price</th>
					<th scope="col" lang="ko" class="t-orderoty">반품수량</th>
					<th scope="col" lang="ko" class="t-supplyoty">공급수량</th>
					<th scope="col" lang="en" class="t-amount">Amount</th>
				</tr>
			</thead>
			<?while($row = mysql_fetch_array($result)){
				$odr_det_idx = replace_out($row["odr_det_idx"]);
				$part_no= replace_out($row["part_no"]);
				$part_type= replace_out($row["part_type"]);
				$nation= replace_out($row["nation"]);
				$sell_mem_idx= replace_out($row["mem_idx"]);
				$manufacturer= replace_out($row["manufacturer"]);
				$package= replace_out($row["package"]);
				$dc= replace_out($row["dc"]);
				$rhtype= replace_out($row["rhtype"]);
				$quantity= replace_out($row["quantity"]);
				$odr_quantity= replace_out($row["odr_quantity"]);
				$supply_quantity= replace_out($row["supply_quantity"]);
				$fault_quantity= replace_out($row["fault_quantity"]);
				$rel_idx= replace_out($row["rel_idx"]);
				$price= replace_out($row["price"]);			
				$odr_idx = replace_out($row["odr_idx"]);			
				$ship_idx= replace_out($row["ship_idx"]);
				$odr_status= replace_out($row["odr_status"]);
				$det_reason= replace_out($row["reason"]);
				//반품 합계금액 계산
				$fault_sum = $price * $fault_quantity;
			?>
				<tr>
					<td colspan="10" class="title-box first">
						<h3 class="title"><img src="/kor/images/stock_title0<?=$part_type?>.gif" alt="<?=GF_Common_GetSingleList("PART",$part_type)?>"></h3>
					</td>
				</tr>
				<tr>
					<td class="t-ct">1</td>
					<td class="t-lt"><?=$part_no;?></td>
					<td class="t-lt"><?=$manufacturer;?></td>
					<td class="t-ct"><?=$package;?></td>
					<td class="t-ct"><?=$dc;?></td>
					<td class="t-ct"><?=$rhtype;?></td>
					<td class="t-rt">$<?=number_format($price,2);?></td>
					<td class="t-rt"><?=number_format($fault_quantity);?></td>
					<td class="t-rt"><?=number_format($supply_quantity);?></td>
					<td class="t-rt">$<?=number_format($fault_sum,2);?></td>
				</tr>
				<?}?>
		</table>        
	</div>
	<div class="btn-area t-rt">
		<button type="button" onclick="location.href='/kor/';"><img src="/kor/images/btn_end.gif" alt="종료"></button>
	</div>
</div>



<SCRIPT LANGUAGE="JavaScript">
<!--

$(document).ready(function(){
	//2016-05-11 추가
	$("#data_19_1_05 .stock-list-table tbody:eq(0) tr:eq(0) td").addClass("first");
	$(".layer-file").css("border-top","0px").css("margin-bottom","0px").css("margin-top","-6px");
	//기존
	$("#file_30_21").html($("#file_<?=$forgenl=="Y"?"18R_19":"19_06"?>").html());
	$("#data_30_21").html($("#data_<?=$forgenl=="Y"?"18R_19":"19_06"?>").html());
	$("#data_30_21 .bg-none").hide();
	$("#file_30_21 .t-rt").remove();
	<?if ($forgenl=="Y"){?>
		$("#file_30_21 .t-ct").html("환불(<strong class='c-blue'><span lang='en'>US$ "+$("input[id^=tot_]").val()+" - My Bank</span></strong>)이 완료되었습니다.");
	<?}else{?>
		$("#file_30_21 .file-memo").addClass("c-red2 w100 t-ct").removeClass("file-memo").html("환불(<strong class='c-blue'><span lang='en'>US$ "+$("input[id^=tot_]").val()+" - My Bank</span></strong>)이 완료되었습니다.");
	<?}?>

});
-->
</SCRIPT>