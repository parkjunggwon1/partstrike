<?
@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include $_SERVER["DOCUMENT_ROOT"]."/include/class/class.odrinfo.php";
?>
<script src="/kor/js/jquery-1.11.3.min.js"></script>
<script src="/include/function.js"></script>
<script type="text/javascript">
<!--
	$(document).ready(function(){
		var $first = $("#layerPop3 .title-box:eq(0)");
		if (!$first.hasClass("first"))
		{
			$("#layerPop3 .title-box:eq(0)").addClass("first");
		}
	});
//-->
</script>
<?if (!$odr_idx){
	$part=get_part($part_idx);
	$sell_mem_idx = $part[mem_idx];
	$sell_rel_idx = $part[rel_idx];
	$part_type = $part[part_type];
	$session_mem_idx = $_SESSION["MEM_IDX"];
	$odr_idx = get_any("odr a left outer join odr_det b", "odr_idx", "part_idx = $part_idx and imsi_odr_no <> ''");	
	if ($odr_idx){
		$odr=get_odr($odr_idx);
		$imsi_odr_no = $odr[imsi_odr_no];
	}
}else{
	$odr=get_odr($odr_idx);
	$sell_mem_idx = $odr[sell_mem_idx];
	$sell_rel_idx = $odr[sell_rel_idx];
	$delivery_addr_idx= $odr[delivery_addr_idx];
	$ship_info= $odr[ship_info];
	$ship_account_no= $odr[ship_account_no];
	$insur_yn= $odr[insur_yn];
	$memo= $odr[memo];
	$imsi_odr_no = $odr[imsi_odr_no];
}
?>

<div class="layer-hd">
	<h1>발주서</h1>
	<a href="#" class="btn-close" ><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>
</div>
<div class="layer-content">
	<form name="f" id="f">
	<input type="hidden" name="odr_idx" id="odr_idx_05_04" value="<?=$odr_idx?>">	
	<input type="hidden" name="typ" id="typ" value="">
	<input type="hidden" name="sell_mem_idx" id="sell_mem_idx" value="<?=$sell_mem_idx?>">
	<input type="hidden" name="sell_rel_idx" id="sell_rel_idx" value="<?=$sell_rel_idx?>">
	<input type="hidden" name="session_mem_idx" id="session_mem_idx" value="<?=$session_mem_idx?>">
	<input type="hidden" name="session_rel_idx" id="session_rel_idx" value="<?=$session_rel_idx?>">
	<input type="hidden" name="chked_cnt" id="chked_cnt" value="0">
	<input type="hidden" name="new_odr_idx" id="new_odr_idx" value="">
	<input type="hidden" name="save_yn" id="save_yn" value="">
	<input type="hidden" name="whole_part_type" id="whole_part_type" value="">

	<table class="stock-list-table">
		<thead>
			<tr>
				<th scope="col" class="t-no">No. </th>
				<th scope="col" class="t-nation"><?if($sell_mem_idx != $_SESSION["MEM_IDX"]){?>Nation<?}?></th>
				<th scope="col" class="t-partno">Part No.</th>
				<th scope="col" class="t-Manufacturer">Manufacturer</th>
				<th scope="col" class="t-Package">Package</th>
				<th scope="col" class="t-dc">D/C</th>
				<th scope="col" class="t-rohs">RoHS</th>
				<th scope="col" class="t-oty">O'ty</th>
				<th scope="col" class="t-unitprice">Unit Price</th>
				<th scope="col" lang="ko" class="t-orderoty">발주수량</th>
				<!--<th scope="col" lang="ko"  class="t-supplyoty">공급수량 </th>-->
				<th scope="col" lang="ko" class="t-period">납기</th>
				<th scope="col" class="t-company"><?if($sell_mem_idx != $_SESSION["MEM_IDX"]){?>Company<?}?></th>
			</tr>
		</thead>
	<?
	//for ($i = 1; $i<=7; $i++){
				echo GET_ODR_DET_LIST("05_04_1", $i," and odr_idx=$odr_idx ");
	//	}
		echo shipping_info($odr[odr_idx],"05_04_1");
		?>		
	</table>
	</form>
	<div class="btn-area t-rt">
		<!--<img src="/kor/images/btn_order_add.gif" class="btn-dialog-0501" alt="발주 추가" style="cursor:pointer">-->
		<a class="btn-view-sheet-forread" forread="Y" href="#" odr_idx="<?=$odr_idx?>"><img src="/kor/images/btn_order_confirm.gif" alt="발주서 확인"></a><!--class="btn-order-confirm" -->
		<!--<img src="/kor/images/btn_order_save_1.gif" alt="발주 저장" style="cursor:pointer"><!--class="btn-dialog-save" -->
	</div>
</div>

