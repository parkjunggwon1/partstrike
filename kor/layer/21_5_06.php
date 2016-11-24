<?
/*********************************************************************************************
*** 반품석적(불량통보)
**********************************************************************************************/
@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include  $_SERVER["DOCUMENT_ROOT"]."/include/class/class.record.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.member.php";

//21_2_03과 같은 반품 선적(21_2_03 : 일반 반품 선적용, 21_5_06 : rnd request용으로 연구소에 반품 선적용)
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
	$(document).ready(function(){
		$("#layerPop3 .stock-list-table tbody:eq(0) tr:eq(0) td").addClass("first");
	});
	function show_msg(idx){
		$("#msg_cont_"+idx).toggle("fast");
	}
	function shipping(){
		var f =  document.f21506;
		if (nullchk(f.delivery_no,"운송장 번호를 입력해주세요.")== false) return ;			
		f.typ.value="shipping";
		 f.target = "proc";
		 f.action = "/kor/proc/record_proc.php";
		 f.submit();		
	}
	
	 $(document).ready(function(){
		 $(".editimgbtn").click(function () {
				$(this).prev().click();
			});
		 $("input[type=file]").change(function(){	
			 if ($(this).val()){
				 var f =  document.f21506; 
				 f.typ.value="imgfileup";
				 f.no.value = $(this).attr("name").replace("file","");
				 f.target = "proc";
				 f.action = "/kor/proc/odr_proc.php";
				 f.submit();						 
			 }
		 });

		 $(".delimgbtn").click(function () {
					var f = document.f21506;
					var no_val = $(this).prev().prev().attr("name").replace("file","");
					f.no.value = no_val;
					f.typ.value="imgfiledel";
					var formData = $("#f21506").serialize(); 
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

<div class="layer-hd red">
	<h1>반품 선적 </h1>
	<a href="#" class="btn-close"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>
</div>
<div class="layer-content">
	<?$odr = get_odr($odr_idx);
	  $odr_det = get_odr_det_each($odr_det_idx);
	  $ship = get_ship($odr_det[ship_idx]);
	  $fty_his = get_fty_history(get_any("fty_history", "fty_history_idx", "odr_det_idx = $odr_det_idx and status= 29" ));   //status = 29 : 선적정보
	  $sell_mem_idx = $odr[sell_mem_idx];
	  $buy_mem_idx = $odr[mem_idx];
	  $buy_com_idx = $odr[rel_idx]==0 ? $odr[mem_idx] : $odr[rel_idx];
	  $result_mem =QRY_MEMBER_VIEW("idx",$buy_com_idx);
	  $row_mem = mysql_fetch_array($result_mem);
	  $buy_com_nation = $row_mem["nation"];
	  $buy_com_name = $row_mem["mem_nm_en"];
	?>

		<form name="f21506" id="f21506"  method="post" enctype="multipart/form-data">

		<input type="hidden" name="typ" id="typ" value="shipping">		
		<input type="hidden" name="status" value="25">
		<input type="hidden" name="status_name" value="반품선적완료">
		<input type="hidden" name="fault_yn" value="">
		<input type="hidden" name="fault_method" value="">  <!--교환1/환불2/수량부족3-->
		<input type="hidden" name="sell_mem_idx" value="<?=$sell_mem_idx?>">
		<input type="hidden" name="buy_mem_idx" value="<?=$buy_mem_idx?>">
		<input type="hidden" name="odr_idx" id="odr_idx" value="<?=$odr_idx?>">		
		<input type="hidden" name="odr_det_idx" id="odr_det_idx" value="<?=$odr_det_idx?>">		
		<input type="hidden" name="ship_idx" id="ship_idx" value="<?=$ship[ship_idx]?>">		
		<input type="hidden" name="ship_info" id="ship_info" value="<?=$ship[ship_info]?>">		
		<input type="hidden" name="reason_ty" id="reason_ty" value="6">		

		<!-- layer-file -->
		<div class="layer-file">
			<table>
				<tbody>
					<tr>
						<td class="c-red2 t-rt">							
							운송회사&nbsp;<img src="/kor/images/icon_<?=strtolower(GF_Common_GetSingleList("DLVR",$ship[ship_info]))?>.gif" alt=""> &nbsp;&nbsp;&nbsp;
							<span>운송장번호 &nbsp;<input type="text" class="i-txt2 c-blue" name="delivery_no" value="" style="width:96px"></span>
						</td>
					</tr>
					<tr>
						<td class="c-red2 t-rt">
							반품 선적 서류 - <span lang="en">Download</span>&nbsp;<a href="#" class="btn-view-sheet-18-1-05" odr_idx="<?=$odr_idx?>" odr_det_idx="<?=$odr_det_idx?>" for_readonly=""><img src="/kor/images/btn_none_commercial_invoice.gif" alt="Non-Commercial Invoice"></a> <a href="#" class="btn-pop-3018"><img src="/kor/images/btn_packing_list.gif" alt="Packing List"></a> <a href="#" class="btn-pop-18-1-08"  ship_idx="<?=$ship[ship_idx]?>" ship_type="<?=$ship[ship_type]?>"><img src="/kor/images/btn_return_statment.gif" alt="반품 사유서"></a>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<!-- //layer-file -->
		<?echo layerListData("21_2_03" ,$odr_idx,$odr_det_idx,"fty",$fty_his[fty_history_idx]);?>
		
		
		<div class="btn-area t-rt">
			<button type="button" onclick="shipping();"><img src="/kor/images/btn_transmit.gif" alt="전송"></button>
		</div>
	</form>
</div>

