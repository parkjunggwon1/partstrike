<?

/**************************************************************************************
*** 교환 or 추가 선적(판매자) 18R_21
*** 2016-05-22 : 선적버튼 활성/비활성 처리
**************************************************************************************/
@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include  $_SERVER["DOCUMENT_ROOT"]."/include/class/class.odrinfo.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.member.php";
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
	function ActiveCheck(){
		
		var f = document.f6;
		var ck_ship=false, ch_delv=false, ck_dc=false, ck_qty=false, ck_pack=false, ck_photo=false;
		var img_cnt=0;
		
		if($("#ship_info").val().length>0) ck_ship=true;
		if($("#delivery_no").val().length>0) ch_delv=true;
		if($("input[name=fault_dc]").val() !="") ck_dc=true;
		if($("input[name=fault_quantity]").val() !="") ck_qty=true;

		/** 이미지 1개이상 필수
		img_file = $("input[name^=file_o<?=$odr_det_idx;?>_]");

		img_file.each(function(e){
			if($(this).val().length>0) img_cnt++;
		});

		alert("img_cnt:"+img_cnt);
		**/

		if(ck_ship && ch_delv && ck_dc && ck_qty){
			$("#btn_shipping").css("cursor","pointer").addClass("btn-ship-18R21").attr("src","/kor/images/btn_shipping.gif");
		}else{
			$("#btn_shipping").css("cursor","").removeClass("btn-ship-18R21").attr("src","/kor/images/btn_shipping_1.gif");
		}
	}
	function shipping(){
		//alert("shipping");
		var f =  document.f6;
		if (nullchk(f.delivery_no,"운송장 번호를 입력해주세요.")== false) return ;			
		//if (nullchk(f.memo,"메모를 입력해주세요.")== false) return ; //2016-05-16 : 메모는 필수사항이 아닌듯...;;
		maskoff();
		//f.typ.value="shipping";  //JSJ
		f.typ.value="shipping2";  //2016-05-17
		f.target = "proc";
		//f.target = "_blank";
		f.action = "/kor/proc/odr_proc.php";
		f.submit();		
	}

	$(document).ready(function(){
		ActiveCheck();
		$("#layerPop3 .stock-list-table tbody:eq(0) tr:eq(0) td").addClass("first");
		$(".yesinput").css("display","");
		$("body").on("click",".btn-ship-18R21",function(){
			shipping();
		});
		//운송회사
		$("#ship_info").change(function () {
			ActiveCheck();
		});
		//운송장번호
		$("#delivery_no").keyup(function () {
			ActiveCheck();
		});
		//DC
		$("input[name=fault_dc]").keyup(function(){
			ActiveCheck();
		});
		//수량
		$("input[name=fault_quantity]").keyup(function(){
			ActiveCheck();
		});
		//이미지
		$("input[name^=file_o]").change(function () {
			ActiveCheck();
		});
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
				ActiveCheck();
			}
		});
		//운송보험
		$("input[name=insur_yn]").click(function(){
			if($(this).hasClass("checked")){
				$(this).parent().next().html(" :&nbsp;&nbsp;No");
			}else{
				$(this).parent().next().html(" :&nbsp;&nbsp;Yes");
			}
		});
	});

//-->
</SCRIPT>
<script src="/kor/js/jquery-1.11.3.min.js"></script>
<script src="/include/function.js"></script>
<script>ready();</script>
<div class="layer-hd">
	<h1>선적</h1>
	<a href="#" class="btn-close"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>
</div>
<div class="layer-content">
<?$odr = get_odr($odr_idx);
  $sell_mem_idx = $odr[sell_mem_idx];
  $buy_mem_idx = $odr[mem_idx];
  $buy_com_idx = $odr[rel_idx]==0 ? $odr[mem_idx] : $odr[rel_idx];
  $result_mem =QRY_MEMBER_VIEW("idx",$buy_com_idx);
  $row_mem = mysql_fetch_array($result_mem);
  $buy_com_nation = $row_mem["nation"];
  $buy_com_name = $row_mem["mem_nm_en"];	
  $ship = get_ship($odr[ship_idx]);
  $ship_info = $ship[ship_info];  
  if ($odr_det_idx){
		$searchand = " and odr_det_idx = $odr_det_idx ";
		$odr_det = get_odr_det_each($odr_det_idx);
		$ship = get_ship($odr_det[ship_idx]);
		$ship_idx = $ship[ship_idx];
		if ($ship_idx==""){
			$odr = get_odr($odr_idx);	
			$ship = get_ship($odr[ship_idx]);
			update_val("odr_det","ship_idx",$odr[ship_idx], "odr_det_idx", $odr_det_idx);	
		}
	
		$ship_info = $ship[ship_info];
  }
?>

		<form name="f6" id="f"  method="post" enctype="multipart/form-data">
		<input type="hidden" name="typ" id="typ" value="shipping2">		
		<input type="hidden" name="status" value="21">
		<input type="hidden" name="fault_yn" value="Y">
		<input type="hidden" name="fault_method" value="<?=$fault_select == "3" ? "3":"1"?>">  <!--교환1/환불2/수량부족3-->
		<input type="hidden" name="fault_select" value="<?=$fault_select == "3" ? "3":"1"?>">  <!--교환1/반품2/추가선적3/환불4인지 선택1,2,3,4중 택일-->
		<input type="hidden" name="status_name" value="선적완료">
		<input type="hidden" name="sell_mem_idx" value="<?=$sell_mem_idx?>">
		<input type="hidden" name="buy_mem_idx" value="<?=$buy_mem_idx?>">
		<input type="hidden" name="odr_idx" id="odr_idx" value="<?=$odr_idx?>">		
		<input type="hidden" name="odr_det_idx" id="odr_det_idx" value="<?=$odr_det_idx?>">		
		<input type="hidden" name="odr_history_idx" id="odr_history_idx" value="">		
		<input type="hidden" name="no" value="">
		<!-- layer-file -->
		<div class="layer-file">
			<table>
				<tbody>
					<tr>
					<td class="company"><img src="/kor/images/nation_title2_<?=$buy_com_nation?>.png" alt="<?=GF_Common_GetSingleList("NA",$buy_com_nation)?>"> <span class="name"><?=$buy_com_name?></span></td>
						<td class="c-red2 t-rt">운송회사 : 
							<?
								$ship_idx = $_GET['ship_info'];
								$ship_img = $part_no= get_any("code_group_detail", "code_desc", "grp_idx=11 and grp_code='DLVR' and dtl_code='$ship_idx'");								
							?>
							<?if ($ship_idx=="1" || $ship_idx=="2" || $ship_idx=="3" || $ship_idx=="4"){?>
							<img src="/kor/images/icon_<?=$ship_img?>.gif" alt="">
							<?}else if($ship_idx=="5"){?>
								<span class='c-blue'>다른 운송업체</span>
							<?}else if($ship_idx=="6"){?>
								<span class='c-blue'>직접 수령</span>
							<?}?>
							<input type='hidden' id='ship_info' name='ship_info' value='<?=$ship_idx?>'/>
						&nbsp;&nbsp;&nbsp;운송장번호: <input type="text" class="i-txt2 c-blue" name="delivery_no" id="delivery_no" value="" style="width:96px"></td>
					</tr>
					<tr>
						<td><div class="re-select"><strong>선택</strong><em><?=$fault_select == "3" ? "추가선적":"교환"?></em></div></td>
						<td class="c-red2 t-rt">선적서류- <span lang="en">Download</span> : <a href="#" class="btn-view-sheet-3011"  for_readonly="Y"><img src="/kor/images/btn_commercial_invoice.gif" alt="Commercial Invoice"></a> <a href="#" class="btn-pop-3018"><img src="/kor/images/btn_packing_list.gif" alt="Packing List"></a></td>
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
						<th scope="col" class="t-unitprice">Unit Price</th>
						<th scope="col" class="t-orderoty" lang="ko"><?=$fault_select == "3" ? "부족":"교환"?>수량</th>
						<th scope="col" class="t-period" lang="ko">납기</th>
					</tr>
				</thead>
				<?	for ($i = 1; $i<=7; $i++){
						echo GET_ODR_DET_LIST("18R_21",$i," and odr_idx=$odr_idx $searchand");
				}
				echo shipping_info($odr_idx,"18R_21");
				?>
			</table>
		</div>
		
		<div class="btn-area t-rt">
			<img id="btn_shipping" src="/kor/images/btn_shipping_1.gif" alt="선적">
		</div>
	</form>
</div>

