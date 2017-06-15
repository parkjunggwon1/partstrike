<?
@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.part.php";
include $_SERVER["DOCUMENT_ROOT"]."/include/class/class.odrinfo.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.member.php";
?>

<script src="/kor/js/jquery-1.11.3.min.js"></script>
<script src="/include/function.js"></script>
<SCRIPT LANGUAGE="JavaScript">
$(document).ready(function(){
	$("#layerPop3 .stock-list-table tbody:eq(0) tr:eq(0) td").addClass("first");
});
</SCRIPT>

<div class="layer-hd">
	<h1>계약금</h1>
	<a href="#" class="btn-close"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>
</div>
<div class="layer-content">
	<form>
	<input id="odr_idx_30_10" value="<?=$odr_idx?>" type="hidden">
	<input id="for_downpay_fr_seller" value="Y" type="hidden">

	<?
			$part_idx = get_any("odr_det", "part_idx", "odr_idx =$odr_idx");
			$odr = get_odr_det($odr_idx);
			if ($part_idx){
				$result =QRY_PART_LIST(0,"and part_idx in ($part_idx)","");
				$row = mysql_fetch_array($result);		
				$part_type= replace_out($row["part_type"]);
				$part_idx= replace_out($row["part_idx"]);
				$part_no= replace_out($row["part_no"]);
				$nation= replace_out($row["nation"]);
				$manufacturer= replace_out($row["manufacturer"]);
				$package= replace_out($row["package"]);
				$dc= replace_out($row["dc"]);
				$rhtype= replace_out($row["rhtype"]);
				$quantity= replace_out($row["quantity"]);
				$price= replace_out($row["price"]);			
				$rel_idx = get_any("part","case when rel_idx = 0 then mem_idx else rel_idx end ","part_idx = $part_idx");
			}
			//2016-09-18
					  $buy_rel_idx = get_any("odr", "rel_idx", "odr_idx = $odr_idx");
					  $buy_com_idx = $buy_rel_idx == 0 ? get_any("odr", "mem_idx", "odr_idx = $odr_idx") : $buy_rel_idx;
					  $result_mem =QRY_MEMBER_VIEW("idx",$buy_com_idx);
					  $row_mem = mysql_fetch_array($result_mem);
					  $buy_com_nation = $row_mem["nation"];
					  $buy_com_name = $row_mem["mem_nm_en"];					
	?>				
		<!-- layer-file -->
		<div class="layer-file">
			<table>
				<tbody>
					<tr>
						<td class="company">
							<img src="/kor/images/nation_title_<?=$buy_com_nation?>.png" alt="<?=GF_Common_GetSingleList("NA",$buy_com_nation)?>">
							<span class="name"><a href="javascript:layer_company_det('<?=$buy_com_idx?>');" class="c-blue"><?=$buy_com_name?></a></span>
						</td>
						<td rowspan="2" class="c-red2"  style="font-size:14px;">거래를 계속하시려면 계약금을 지불하셔야 합니다.<br>
						계약금은 보증 용도로서 사용될 것입니다. <br>
						거래 종료 후 이 계약금은 당신의 My Bank로 충전됩니다. </td>
					</tr>
				</tbody>
			</table>
		</div>
		<!-- //layer-file -->

		<div class="layer-data">
			<table class="stock-list-table">
				<thead>
					<tr>
						<th scope="col" class="t-no">No. </th>
						<th scope="col" class="t-partno">Part No.</th>
						<th scope="col" class="t-Manufacturer">Manufacture</th>
						<th scope="col" class="t-Package">Package</th>
						<th scope="col" class="t-dc">D/C</th>
						<th scope="col" class="t-rohs">RoHS</th>
						<th scope="col" class="t-oty">O'ty</th>
						<th scope="col" class="t-unitprice">Unit Price</th>
						<th scope="col" lang="en" class="t-orderoty">Amount</th>
						<th scope="col" lang="ko" class="t-period">납기</th>
					</tr>
				</thead>
				<?	for ($i = 1; $i<=6; $i++){
						echo GET_ODR_DET_LIST("01_29", $i," and odr_idx=$odr_idx ");
				}?>				
			</table>
		</div>
		
		<div class="btn-area t-rt">
			<a class="btn-view-sheet-3011" href="#"  for_readonly=""><img alt="송장확인" src="/kor/images/btn_invoice_confirm.gif"></a>
		</div>
	</form>
</div>