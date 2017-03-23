<?
@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include $_SERVER["DOCUMENT_ROOT"]."/include/class/class.odrinfo.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.member.php";
?>
<script src="/include/function.js"></script>
<script>ready();</script>
<SCRIPT LANGUAGE="JavaScript">
$(document).ready(function(){
	$("#layerPop3 .stock-list-table tbody:eq(0) tr:eq(0) td").addClass("first");
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
});
function checkActive(){
	var btnSubmit = false;
	if($("select[name^=part_condition]").val().length>0 && $("select[name^=pack_condition1]").val().length>0 && $("select[name^=pack_condition2]").val().length>0){
		btnSubmit = true;
	}
	if(btnSubmit){
		$("#btn_submit_0136").css("cursor","pointer").addClass("btn-submit-0136").attr("src","/kor/images/btn_transmit.gif");
	}else{
		$("#btn_submit_0136").css("cursor","").removeClass("btn-submit-0136").attr("src","/kor/images/btn_transmit_1.gif");
	}
}
</SCRIPT>
<div class="layer-hd">
	<h1>도착</h1>
	<a href="#" class="btn-close"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>
</div>
<?
$buy_rel_idx = get_any("odr", "rel_idx", "odr_idx = $odr_idx");
$buy_com_idx = $buy_rel_idx == 0 ? get_any("odr", "mem_idx", "odr_idx = $odr_idx") : $buy_rel_idx;
$result_mem =QRY_MEMBER_VIEW("idx",$buy_com_idx);
$row_mem = mysql_fetch_array($result_mem);
$buy_com_nation = $row_mem["nation"];
$buy_com_name = $row_mem["mem_nm_en"];					
?>
<div class="layer-content">
	<form name="f_01_36" id="f_01_36">
	<input type="hidden" name="typ" id="typ" value="arrival">
	<input id="odr_idx_30_10" name="odr_idx" value="<?=$odr_idx?>" type="hidden">
		<!-- layer-file -->
		<div class="layer-file">
			<table>
				<tbody>
					<tr>
						<td class="company">
							<img src="/kor/images/nation_title_<?=$buy_com_nation?>.png" alt="<?=GF_Common_GetSingleList("NA",$buy_com_nation)?>">
							<span class="name"><?=$buy_com_name?></span>
						</td>
						<td class="t-rt c-red2">추가 공급 가능 수량: <input type="text" class="i-txt2 c-blue t-rt onlynum numfmt" onfocus="if(this.value=='0'){this.value=''}" onblur="if(this.value==''){this.value='0'}" name="addcapa" id="addcapa" value="0" style="width:90px"> <span lang="en">EA</span></td>
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
						<th scope="col" class="t-partno" Style="width:240px;">Part No.</th>
						<th scope="col" class="t-Manufacturer">Manufacturer</th>
						<th scope="col" class="t-Package">Package</th>
						<th scope="col" class="t-dc">D/C</th>
						<th scope="col" class="t-rohs">RoHS</th>
						<th scope="col" class="t-oty">O'ty</th>
						<th scope="col" class="t-unitprice">Unit Price</th>
						<th scope="col" lang="ko" class="t-orderoty">Amount</th>
						<th scope="col" lang="ko" class="t-period">납기</th>
					</tr>
				</thead>
				<?
				for ($i = 1; $i<=7; $i++){
					echo GET_ODR_DET_LIST("01_36", $i," and odr_idx=$odr_idx ", $det_cnt);
				}
				?>		
			</table>
		</div>
		
		<div class="btn-area t-rt">
			<img src="/kor/images/btn_transmit_1.gif" id="btn_submit_0136" alt="전송">
		</div>
	</form>
</div>