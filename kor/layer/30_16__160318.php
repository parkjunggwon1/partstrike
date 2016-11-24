<?@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include  $_SERVER["DOCUMENT_ROOT"]."/include/class/class.odrinfo.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.member.php";
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
	function shipping(){
		var f =  document.f;
		if (nullchk(f.delivery_no,"운송장 번호를 입력해주세요.")== false) return ;
			f.typ.value="shipping";
			f.target = "proc";
			f.action = "/kor/proc/odr_proc.php";
			f.submit();		
	}
	
	 $(document).ready(function(){
		 $(".editimgbtn").click(function () {
				$(this).prev().click();
			});
		 $("input[type=file]").change(function(){	
			 if ($(this).val()){
				 var f =  document.f6; 
				 f.typ.value="imgfileup";
				 f.no.value = $(this).attr("name").replace("file","");
				 f.target = "proc";
				 f.action = "/kor/proc/odr_proc.php";
				 f.submit();						 
			 }
		 });

		 $(".delimgbtn").click(function () {
					var f = document.f6;
					var no_val = $(this).prev().prev().attr("name").replace("file","");
					f.no.value = no_val;
					f.typ.value="imgfiledel";
					var formData = $("#f").serialize(); 
					$.ajax({
						url: "/kor/proc/odr_proc.php", 
						data: formData,
						encType:"multipart/form-data",
						success: function (data) {	
							if (trim(data) == "SUCCESS"){									
								$("#fileimg"+no_val).attr("src", "/kor/images/file_pt.gif");
							    $("#file_o"+no_val).val("");
							}else{
								alert(data);
							}
						}
				});		
            });
	 });
//-->
</SCRIPT>

<div class="layer-hd">
	<h1>선적-3016</h1>
	<a href="#" class="btn-close"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>
</div>
<div class="layer-content">
<?$odr = get_odr($odr_idx);
  $sell_mem_idx = $odr[sell_mem_idx];
  $buy_mem_idx = $odr[mem_idx];
  $buy_com_idx = $odr[rel_idx]==0 ? $odr[mem_idx] : $odr[rel_idx];
  $sell_com_idx = $odr[sell_rel_idx]==0 ? $odr[sell_mem_idx] : $odr[sell_rel_idx];
  $result_mem =QRY_MEMBER_VIEW("idx",$buy_com_idx);
  $row_mem = mysql_fetch_array($result_mem);
  $row_ship = get_ship($odr[ship_idx]);
  $buy_com_nation = $row_mem["nation"];
  $sell_com_nation = get_any("member", "nation" , "mem_idx = $sell_com_idx");
  $buy_com_name = $row_mem["mem_nm_en"];
  $ship_idx = $odr[ship_idx];
  $ship = get_ship($ship_idx,'ship_weight');
  $ship_weight = $ship[ship_weight];
?>

		<form name="f6" name="f" id="f"  method="post" enctype="multipart/form-data">
		<input type="hidden" name="typ" id="typ" value="shipping">	
		<input type="hidden" name="weight_yn" id="weight_yn" value="<?=$ship_weight;?>">	
		<input type="hidden" name="status" value="21">
		<input type="hidden" name="status_name" value="선적완료">
		<input type="hidden" name="fault_yn" value="">
		<input type="hidden" name="fault_method" value="">  <!--교환1/환불2/수량부족3-->
		<input type="hidden" name="sell_mem_idx" value="<?=$sell_mem_idx?>">
		<input type="hidden" name="buy_mem_idx" value="<?=$buy_mem_idx?>">
		<input type="hidden" name="odr_idx" id="odr_idx" value="<?=$odr_idx?>">		
		<input type="hidden" name="odr_history_idx" id="odr_history_idx" value="">		
		<input type="hidden" name="no" value="">

		<!-- layer-file -->
		<div class="layer-file">
			<table>
				<tbody>
					<tr>
						<td class="company" rowspan="2"><img src="/kor/images/nation_title_<?=$buy_com_nation?>.png" alt="<?=GF_Common_GetSingleList("NA",$buy_com_nation)?>"> <span class="name"><?=$buy_com_name?></span></td>
						<td class="c-red2 t-rt">
						<?switch ($row_ship["ship_info"]) {
						   case "5":  ?>							 
								운송회사 : <input type="text" class="i-txt2 c-blue" name="delivery_no" value="<?=$row_ship["memo"]?>" readonly  style="width:96px">
								운송장번호 : <input type="text" class="i-txt2 t-rt c-blue" name="delivery_no" maxlength="18" value="" style="width:96px">
						<? break;
						   case "6":?>
								직접수령
						<?break;
						  default:?>
						  운송회사 : <img src="/kor/images/icon_<?=strtolower(GF_Common_GetSingleList("DLVR",$row_ship["ship_info"]))?>.gif" alt="" height="15"> &nbsp;&nbsp;&nbsp;
						  운송장번호 : <input type="text" class="i-txt2 t-rt c-blue" name="delivery_no" maxlength="18" value="" style="width:96px">
						<?break;
						}?>
						</td>
					</tr>
					<?if($buy_com_nation!= $sell_com_nation){ //국제간의 거래일 경우에만 노출?>
					<tr>
						<td class="c-red2 t-rt">선적서류 <span lang="en"><!--Download--></span> : <a href="#" class="btn-view-sheet-3011" for_readonly="Y"><img src="/kor/images/btn_commercial_invoice.gif" alt="Commercial Invoice"></a> 
						<a href="#" class="btn-pop-3018"><img src="/kor/images/btn_packing_list.gif" alt="Packing List"></a></td>
					</tr>
					<?}?>
				</tbody>
			</table>
		</div>
		<!-- //layer-file -->
		
		<div class="layer-data">
			<table class="stock-list-table">
				<thead>
					<tr>
						<th scope="col">No. </th>
						<th scope="col" class="t-lt">Part No.</th>
						<th scope="col" class="t-lt">Manufacture</th>
						<th scope="col">Package</th>
						<th scope="col">D/C</th>
						<th scope="col">RoHS</th>
						<th scope="col" class="t-rt">O'ty</th>
						<th scope="col" class="t-rt">Unit Price</th>
						<th scope="col" lang="ko">발주수량</th>
						<th scope="col" lang="ko">공급수량</th>
						<th scope="col" lang="ko">납기</th>
					</tr>
				</thead>
				<?	for ($i = 1; $i<=7; $i++){
						echo GET_ODR_DET_LIST("30_16",$i," and odr_idx=$odr_idx ");
				}?>
			</table>
		</div>
		
		<div class="btn-area t-rt">
			<!--button type="button" onclick="shipping();"><img src="/kor/images/btn_transmit.gif" alt="전송"></button-->
			<button type="button" onclick="shipping();"><img src="/kor/images/btn_transmit.gif" alt="전송"></button>
		</div>
	</form>
</div>

