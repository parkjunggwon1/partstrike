<?
/****************************************************************************************************
*** 반품선적(18_1_04)
****************************************************************************************************/
@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include  $_SERVER["DOCUMENT_ROOT"]."/include/class/class.odrinfo.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.member.php";

//18_1_04 : 일반 반품 선적용.(Black version)
//21_5_06과 같은 반품 선적(21_2_03 : 일반 반품 선적용, 21_5_06 : rnd request용으로 연구소에 반품 선적용) (Red version)
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
	function shipping(){
		var f =  document.f;
		//if (nullchk(f.delivery_no,"운송장 번호를 입력해주세요.")== false) return ;			
		f.typ.value="return_submit";
		 f.target = "proc";
		 f.action = "/kor/proc/odr_proc.php";
		 f.submit();		
	}
	function check_btn(){
		var fault_quantity = $("#fault_quantity").val();
		var delivery_no = $("#delivery_no").val();
		if(fault_quantity>0 && delivery_no.length >0){
			$("#btn_img").css("cursor","pointer").attr("onclick","shipping();").attr("src","/kor/images/btn_transmit.gif");
		}else{
			$("#btn_img").css("cursor","").attr("onclick","").attr("src","/kor/images/btn_transmit_1.gif");
		}
	}
	
	 $(document).ready(function(){
		 $("#data_18_1_04 .stock-list-table tbody:eq(0) tr:eq(0) td").addClass("first");
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

		 $("#fault_quantity").keyup(function(e){
			 check_btn();
		 });
		 $("#delivery_no").keyup(function(e){
			 check_btn();
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
	<h1>반품 선적 </h1>
	<a href="#" class="btn-close"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>
</div>
<div class="layer-content">
	<?$odr = get_odr($odr_idx);
	  $odr_det = get_odr_det_each($odr_det_idx);
	  $ship = get_ship($odr_det[ship_idx]);
	  $odr_his = get_odr_history(get_any("odr_history", "odr_history_idx", "odr_det_idx = $odr_det_idx and status= 22" ));   //status = 22 : 선적정보
	  $sell_mem_idx = $odr[sell_mem_idx];
	  $buy_mem_idx = $odr[mem_idx];
	  $buy_com_idx = $odr[rel_idx]==0 ? $odr[mem_idx] : $odr[rel_idx];
	  $result_mem =QRY_MEMBER_VIEW("idx",$buy_com_idx);
	  $row_mem = mysql_fetch_array($result_mem);
	  $buy_com_nation = $row_mem["nation"];
	  $buy_com_name = $row_mem["mem_nm_en"];
		if($ship[delivery_addr_idx] > 0){
		   $addr_row = get_delivery_addr($ship[delivery_addr_idx]);
		}
	?>

		<form name="f6" id="f"  method="post" enctype="multipart/form-data">

		<input type="hidden" name="typ" id="typ" value="shipping">		
		<input type="hidden" name="status" value="11">
		<input type="hidden" name="status_name" value="반품선적완료">
		<input type="hidden" name="fault_yn" value="">
		<input type="hidden" name="fault_method" value="">  <!--교환1/환불2/수량부족3-->
		<input type="hidden" name="fault_select" value="<?=$fault_select?>">
		<input type="hidden" name="sell_mem_idx" value="<?=$sell_mem_idx?>">
		<input type="hidden" name="buy_mem_idx" value="<?=$buy_mem_idx?>">
		<input type="hidden" name="odr_idx" id="odr_idx" value="<?=$odr_idx?>">		
		<input type="hidden" name="odr_det_idx" id="odr_det_idx" value="<?=$odr_det_idx?>">		
		<input type="hidden" name="ship_idx" id="ship_idx" value="<?=$ship[ship_idx]?>">		
		<input type="hidden" name="ship_info" id="ship_info" value="<?=$ship[ship_info]?>">		

		<!-- layer-file -->
		<div class="layer-file">
			<table>
				<tbody>
					<tr>
						<td class="c-red2 t-lt" Style="width:600px;">
							운송회사 : <img src="/kor/images/icon_<?=strtolower(GF_Common_GetSingleList("DLVR",$ship[ship_info]))?>.gif" alt=""> &nbsp;&nbsp;&nbsp;<span lang="en">Account No.</span> <span lang="en" class="c-blue"><?=$ship[ship_account_no]?></span>
						</td>
						<td rowspan="2">
							<table>
								<?if($ship[insur_yn] == "Y"){?><tr><td colspan="2">운송보험 : <span class="c-red">Yes</span></td></tr><?}?>
								<?if($ship[delivery_addr_idx] > 0){?>
									<tr><td Style="width:75px; vertical-align:top;">
										배송지변경 : 
									</td>
									<td>
										<table class="table-type1-1" lang="ko">
											<tr>
												<td class="t-lt">우편번호 : <?=$addr_row[zipcode];?></td>
											</tr>
											<tr>
												<td>도/시 : <?=$addr_row[dositxt];?></td>
											</tr>
											<tr>
												<td>시/구/군 : <?=$addr_row[sigungu];?></td>
											</tr>
											<tr>
												<td>주소 : <?=$addr_row[addr];?></td>
											</tr>
										</table>
									</td></tr>
								<?}?>
								<?if(strlen($ship[memo])>0){?><tr><td colspan="2">Memo : <span class="c-red"><?=$ship[memo];?></span></td></tr><?}?>
							</table>
						</td>
					</tr>
					<tr>
						<td><div class="re-select"><strong>선택</strong><em><?if ($fault_select=="2"){?>반품<?}else{?>교환<?}?></em></div></td>
					</tr>
				</tbody>
			</table>
		</div>
		<!-- //layer-file -->
		
		<?echo layerInvListData("18_1_04" ,$odr_idx,$odr_det_idx);?>
		
		<div class="btn-area t-rt">
			<img id="btn_img" src="/kor/images/btn_transmit_1.gif" alt="전송">
		</div>
	</form>
</div>

