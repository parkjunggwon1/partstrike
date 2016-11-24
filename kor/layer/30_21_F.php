<?
/***************************************************************************************************************
**** 수령(fault) POP : 30_21_F
**************************************************************************************************************/
@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include  $_SERVER["DOCUMENT_ROOT"]."/include/class/class.odrinfo.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.member.php";
?>
<div class="layer-hd">
	<h1>수령</h1>
	<a href="#" class="btn-close"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>
</div>
<?
$det_cnt = QRY_CNT("odr_det"," and odr_idx=$odr_idx ");  //odr_det 수량
$fault_select = get_any("odr_history", "fault_select", "odr_history_idx=$odr_history_idx");
?>
<div class="layer-content">
	<form name="f" id="f">
		<!-- form1 -->
		<input type="hidden" name="typ" id="typ_3021" value="faultEnd">
		<input type="hidden" name="odr_idx" id="odr_idx_3021" value="<?=$odr_idx?>">		
		<input type="hidden" name="odr_det_idx" id="odr_det_idx" value="<?=$odr_det_idx?>">
		<input type="hidden" name="odr_history_idx" id="odr_history_idx" value="<?=$odr_history_idx?>">
		<input type="hidden" name="det_cnt" id="det_cnt_3021" value="<?=$det_cnt?>">
		<input type="hidden" name="fault_select" id="fault_select_3021" value="<?=$fault_select;?>">
		<input type="hidden" name="fault_yn" id="fault_select_3021" value="Y">
		<!-- //form1 -->
	</form>
	<div class="layer-data">
		<table class="stock-list-table">
			<thead>
				<tr>
					<th scope="col" class="t-no">No. </th>
					<th scope="col" class="t-nation">Nation</th>
					<th scope="col" class="t-partno" Style="width:<?=$partno_width;?>px;">Part No.</th>
					<th scope="col" class="t-Manufacturer">Manufacturer</th>
					<th scope="col" class="t-Package">Package</th>
					<th scope="col" class="t-dc">D/C</th>
					<th scope="col" class="t-rohs">RoHS</th>
					<th scope="col" class="t-unitprice">Unit Price</th>
					<th scope="col" lang="ko" class="t-orderoty">
						<?
						echo ($fault_select=="1")? "교환수량":"부족수량";
						?>
					</th>
					<th scope="col" lang="ko" class="t-period">납기</th>
					<th scope="col" class="t-company">Company</th>
				</tr>
			</thead>
		<?
		for ($i = 1; $i<=7; $i++){
					echo GET_ODR_DET_LIST("30_21_F", $i," and odr_idx=$odr_idx and odr_det_idx=$odr_det_idx ");
		}
		?>		
		</table>
	</div>
	
	<div class="btn-area t-rt">
		<button type="button" class="faultEnd" odr_idx="<?=$odr_idx?>"><img src="/kor/images/btn_end.gif" alt="종료"></button>
	</div>
	
</div>



<SCRIPT LANGUAGE="JavaScript">
<!--

$(document).ready(function(){
	$("#layerPop3 .stock-list-table tbody:eq(0) tr:eq(0) td").addClass("first");
});
-->
</SCRIPT>