<?
/***************************************************************************************************************
**** 선적 : 30_16
**** 2016-03-08 : '전송' 버튼 활성 비활성
**************************************************************************************************************/
@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include  $_SERVER["DOCUMENT_ROOT"]."/include/class/class.odrinfo.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.member.php";

$det_cnt = QRY_CNT("odr_det"," and odr_idx=$odr_idx ");  //odr_det 수량
$odr = get_odr($odr_idx);
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
//$ship = get_ship($ship_idx,'ship_weight');
$ship = get_ship($ship_idx);
$ship_weight = $ship[ship_weight];
if($ship[delivery_addr_idx] > 0){
   $addr_row = get_delivery_addr($ship[delivery_addr_idx]);
}

?>
<SCRIPT LANGUAGE="JavaScript">
<!--
	function shipping(){
		var f =  document.f;
		var det_cnt = $("#det_cnt_30_16").val();
		if(det_cnt>1){ //-- 여러개 일때 --------------------------
			sel_box = $("input[name^=odr_det_idx]:checked");
			selCnt = sel_box.length;
		}else{	//-- 한개일때 ---------------------------------------
			sel_box = $("input[name^=odr_det_idx]");
			selCnt=1;
		}
		//if (nullchk(f.delivery_no,"운송장 번호를 입력해주세요.")== false) return ;
		//새로운 방법 : 일부일때는 복제하는 ajax 처리 후 new_idx 로 폼 전송.
		if(det_cnt > selCnt){  //일부일때 ajax로 복제 처리 하자
			//alert("복제처리...");
			var $chked_odr_det = sel_box;
			var ch_odr_det_idx = [];
			$chked_odr_det.each(function(e){
				ch_odr_det_idx.push($(this).val());
			});
			//alert("ch_odr_det_idx"+ch_odr_det_idx);
			$.ajax({ 
				type: "GET", 
				url: "/ajax/proc_ajax.php?det_idx="+ch_odr_det_idx, 
				data: { actty : "ODRCP", //주문 복제
						odr_idx : $("#odr_idx_30_16").val()
						//det_idx : ch_odr_det_idx
						},
				dataType : "html" ,
				async : false ,
				success: function(data){
							//alert("data"+trim(data));
					$("#odr_idx_30_16").val(trim(data));
					//document.location.href="/kor/";
					//Refresh_Right();
					//closeCommLayer("layer6"); //현재 메시지 창
					//closeCommLayer("layer3"); //납기확인 창
					//closeCommLayer("layer"); //what's New 창
				}
			});
		}
		/*
		f.typ.value="shipping";
		f.target = "proc";
		f.action = "/kor/proc/odr_proc.php";
		f.submit();		*/

		openCommLayer("layer6","alert2","?btn=btn_transmit&alert_title="+encodeURIComponent('선적')+"&alert_msg="+encodeURIComponent('선적이 완료되었습니다.')+"")
	}
	function checkActive(){
	
		//alert("check");
		var det_cnt = $("#det_cnt_30_16").val();
		var selCnt=0;

		if(det_cnt>1){ //-- 여러개 일때 --------------------------
			sel_box = $("input[name^=odr_det_idx]:checked");
			selCnt = sel_box.length;
		}else{	//-- 한개일때 ---------------------------------------
			sel_box = $("input[name^=odr_det_idx]");
			selCnt=1;
		}

		//취소 버튼
		if(selCnt > 0){
			$("#btn_cancel_3016").css("cursor","pointer").addClass("btn-cancel-3016").attr("src","/kor/images/btn_cancel.gif");
		}else{
			$("#btn_cancel_3016").css("cursor","").removeClass("btn-cancel-3016").attr("src","/kor/images/btn_cancel_1.gif");
		}
		//선적 버튼
		var delv_no = $("#layerPop3 #delivery_no").val();
		var delv_shop = "none";
		<?if ($row_ship['ship_info']==5)
		{
		?>
			delv_shop = $("#layerPop3 #delivery_shop").val();
		<?
		}
		?>

		if ($("#ship_info").val() == 6)
		{
			$("#btn_submit_3016").attr("src","/kor/images/btn_shipping.gif");
			$("#btn_submit_3016").attr("onclick","shipping();");
			$("#btn_submit_3016").css("cursor","pointer");
			return;
		}

		//alert("delv_no.length:"+delv_no.length);
		if(delv_no.length>0 && selCnt>0 && delv_shop != ""){  //활성
			$("#btn_submit_3016").attr("src","/kor/images/btn_shipping.gif");
			$("#btn_submit_3016").attr("onclick","shipping();");
			$("#btn_submit_3016").css("cursor","pointer");
		}else{	//비활성
			$("#btn_submit_3016").attr("src","/kor/images/btn_shipping_1.gif");
			$("#btn_submit_3016").attr("onclick","");
			$("#btn_submit_3016").css("cursor","");
		}
		
		/** JSJ
		var delv_no = $("#layerPop3 #delivery_no").val();
		if(delv_no.length>0){  //활성
			$("#btn_3016").attr("src","/kor/images/btn_transmit.gif");
			$("#btn_3016").attr("onclick","shipping();");
			$("#btn_3016").css("cursor","pointer");
		}else{	//비활성
			$("#btn_3016").attr("src","/kor/images/btn_transmit_1.gif");
			$("#btn_3016").attr("onclick","");
			$("#btn_3016").css("cursor","");
		}
		**/
	}

	function fileChange(){
		$("input[type=file]").change(function(){	
			 var no_val = $(this).attr("name").replace("file","");
			 var file_nm = $(this).attr("f_number");
			 var odr_det_idx_val = $(this).attr("odr_det_idx"); 
			 if ($(this).val()){
				 var f =  document.f; 
				 f.typ.value="imgfileup";
				 f.no.value = $(this).attr("name").replace("file","");
				 f.target = "proc";
				 f.action = "/kor/proc/odr_proc.php";
				 f.submit();						 
			 }
			 
			if(file_nm ==3)
			{
				$(".minus_chk"+file_nm+"_"+odr_det_idx_val).show();
			}
			else
			{
				$(".plus_chk"+file_nm+"_"+odr_det_idx_val).show();
				$(".minus_chk"+file_nm+"_"+odr_det_idx_val).show();
			}				
			
		 });			
	}
	
	 $(document).ready(function(){
		 $("#layerPop3 .stock-list-table tbody:eq(0) tr:eq(0) td").addClass("first");
		 checkActive();
		 $(".editimgbtn").click(function () {
				$(this).prev().click();
			});
		 

		 $(".img-wrap").click(function () {
                $(this).next().next().click();
            });

		fileChange();

		$(".arrow_top").click(function(){
			
			var num_file = $(this).prev().attr("f_number");
			var odr_det_idx = $(this).prev().attr("odr_det_idx");

			num_file = Number(num_file) + 1;

			$(".img_tap"+num_file+"_"+odr_det_idx).show();				
			$(".minus_chk"+num_file+"_"+odr_det_idx).show();
		});
		
		<?if ($row_ship['ship_info']==5)
		{
		?>
			//운송회사
			$("#layerPop3 #delivery_shop").keyup(function(e){
				//alert(e.key);
				
				if($.trim($("#delivery_shop").val()) != ""){  //활성					
					$(".btn-view-sheet-3017no img").attr("src","/kor/images/btn_commercial_invoice.gif");
					$(".btn-view-sheet-3017no").attr("class","btn-view-sheet-3017a");
					$(".btn-view-sheet-3017a").css("cursor","pointer");

					$(".btn-pop-3018no img").attr("src","/kor/images/btn_packing_list.gif");
					$(".btn-pop-3018no").attr("class","btn-pop-3018");
					$(".btn-view-sheet-3017a").css("cursor","pointer");

				}else{	//비활성					
					$(".btn-view-sheet-3017a img").attr("src","/kor/images/btn_commercial_invoice_1.gif");
					$(".btn-view-sheet-3017a").attr("class","btn-view-sheet-3017no");
					$(".btn-view-sheet-3017no").css("cursor","");

					$(".btn-pop-3018 img").attr("src","/kor/images/btn_packing_list_1.gif");
					$(".btn-pop-3018").attr("class","btn-pop-3018no");
					$(".btn-pop-3018no").css("cursor","pointer");

					$(".delivery_shop").val("");
				}
				checkActive();
			});
		<?
		}
		?>
		
		//운송장번호
		$("#layerPop3 #delivery_no").keyup(function(e){
			checkActive();
		});
		//-- 옵션(체크박스) 클릭
		$("#layerPop3 .stock-list-table input[name^=odr_det_idx]").click(function(e){
			checkActive();
		});

		 $(".arrow_bottom").click(function () {
					var f = document.f;
					var no_val = $(this).attr("f_idx");
					var file_no = $(this).attr("class").replace("arrow_bottom minus_chk","");
			
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
								if(Number(file_no) > 1)
								{									
									$(".img_tap"+file_no).hide();
								}
								else
								{
									$(".plus_chk"+file_no).hide();
									$(".minus_chk"+file_no).hide();
								}
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

		<form name="f" id="f"  method="post" enctype="multipart/form-data">
		<!--<input type="hidden" name="typ" id="typ" value="shipping">	JSJ-->
		<input type="hidden" name="typ" id="typ" value="">
		<input type="hidden" name="weight_yn" id="weight_yn" value="<?=$ship_weight;?>">	
		<input type="hidden" name="status" id="status" value="21">
		<input type="hidden" name="status_name" id="status_name" value="선적완료">
		<input type="hidden" name="fault_yn" id="fault_yn" value="">
		<input type="hidden" name="fault_method" id="fault_method" value="">  <!--교환1/환불2/수량부족3-->
		<input type="hidden" name="sell_mem_idx" id="sell_mem_idx" value="<?=$sell_mem_idx?>">
		<input type="hidden" name="buy_mem_idx" id="buy_mem_idx" value="<?=$buy_mem_idx?>">
		<input type="hidden" name="odr_idx" id="odr_idx_30_16" value="<?=$odr_idx?>">	
		<input type="hidden" id="odr_idx" value="<?=$odr_idx?>">	
		<input type="hidden" name="odr_history_idx" id="odr_history_idx" value="">		
		<input type="hidden" name="no" id="no" value="">
		<input type="hidden" name="det_cnt" id="det_cnt_30_16" value="<?=$det_cnt;?>">
		<input type="hidden" name="load_page" id="load_page" value="30_16">
		<input type="hidden" name="ship_info" id="ship_info" value="<?=$row_ship['ship_info']?>">

		<!-- layer-file -->
		<div class="layer-file">
			<table>
				<tbody>
					<tr>
						<td class="company" rowspan="2"><img src="/kor/images/nation_title_<?=$buy_com_nation?>.png" alt="<?=GF_Common_GetSingleList("NA",$buy_com_nation)?>">
						<span class="name" >
							<a href="javascript:layer_company_det('<?=$buy_mem_idx?>');" class="c-blue"><?=$buy_com_name?></a>
						</span></td>
						<td class="c-red2 t-rt" style="font-size: 14px;">
						<?switch ($row_ship["ship_info"]) {
						   case "5":  ?>							 
								운송회사&nbsp;&nbsp;<input type="text" class="i-txt2 c-blue" id="delivery_shop" name="delivery_shop" value="" style="width:96px">&nbsp;
								운송장번호&nbsp;&nbsp;<input type="text" class="i-txt2 t-rt c-blue" name="delivery_no" id="delivery_no" maxlength="19" value="" style="width:145px">
						<? break;
						   case "6":?>
								직접수령
						<?break;
						  default:?>
						  운송회사  <img src="/kor/images/icon_<?=strtolower(GF_Common_GetSingleList("DLVR",$row_ship["ship_info"]))?>.gif" alt="" height="18" style="margin-bottom:3px;"> &nbsp;&nbsp;&nbsp;
						  운송장번호&nbsp;&nbsp;<input type="text" class="i-txt2 t-rt c-blue" name="delivery_no" id="delivery_no" maxlength="19" value="" style="width:145px">
						<?break;
						}?>
						</td>
					</tr>
					<?
					$ship_idx = get_any("ship","delivery_addr_idx","odr_idx=$odr_idx");
					if($ship_idx == 0)
					{
						$ship_nation = get_any("member","nation","mem_idx=$buy_mem_idx");
					}
					else
					{
						$ship_nation = get_any("delivery_addr","nation","delivery_addr_idx=$ship_idx");
					}					

					if($ship_nation != $sell_com_nation){ //국제간의 거래일 경우에만 노출?>
					<tr><!-- 2016-04-25 송장 class변경 'btn-view-sheet-3011' -> 'btn-view-sheet-3017' --->
						<?if ($row_ship['ship_info']==5)
						{
							$delivery_shop_val = "btn-view-sheet-3017no";
							$btn_img1 = "btn_commercial_invoice_1";

							$paking_val = "btn-pop-3018no";
							$btn_img2 = "btn_packing_list_1";
						}
						else
						{
							$delivery_shop_val = "btn-view-sheet-3017a";
							$btn_img1 = "btn_commercial_invoice";

							$paking_val = "btn-pop-3018";
							$btn_img2 = "btn_packing_list";
						}
						?>
						<td class="c-red2 t-rt" style="font-size: 14px;">선적서류<span lang="en"><!--Download--></span>&nbsp;&nbsp;<a href="#" class="<?=$delivery_shop_val?>" for_readonly="Y"><img src="/kor/images/<?=$btn_img1?>.gif" alt="Commercial Invoice"></a> 
						<a href="#" class="<?=$paking_val?>"><img src="/kor/images/<?=$btn_img2?>.gif" alt="Packing List"></a></td>
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
						<?if ($det_cnt>1){ ?>
						<th scope="col" style="width:20px">
							Option 
						</th>
						<?}?>
						<th scope="col" style="width:20px">No. </th>
						<th scope="col" class="t-lt" style="width:280px;">Part No.</th>
						<th scope="col" class="t-lt">Manufacturer</th>
						<th scope="col" style="width:80px;">Package</th>
						<th scope="col" style="width:36px;">D/C</th>
						<th scope="col" style="width:36px;">RoHS</th>
						<th scope="col" style="width:60px;" class="t-rt">O'ty</th>
						<th scope="col" class="t-rt" style="width:61px;">Unit Price</th>
						<th scope="col" class="t-rt" style="width:80px;">Amount</th>
						<th scope="col" lang="ko"style="width:36px;">납기</th>
					</tr>
				</thead>
				<?	for ($i = 1; $i<=7; $i++){
						echo GET_ODR_DET_LIST("30_16",$i," and odr_idx=$odr_idx ", $det_cnt);
				}?>
				<tr>
					<td style="height:20px;border: 0;">
					</td>
				</tr>
				<tr>					
					<?=($det_cnt>=1)? "<td></td>":"";?>
					
					<td colspan="6" style="text-align:left;" bgcolor="#FFFFCC">				
						<strong class="c-red2">선적정보 : </strong> 
						<?							
							if($ship[ship_info]==5)
							{
						?>
							 <span class="c-blue">다른 운송업체</span>
						<?
							}
							elseif($ship[ship_info]==6)
							{
						?>
							 <span class="c-blue">직접수령</span>
						<?
							}
							else
							{
						?>
							운송회사 <img src="/kor/images/icon_<?=strtolower(GF_Common_GetSingleList("DLVR",$ship[ship_info]))?>.gif" alt="" height="18" style="margin-bottom:3px;">&nbsp;&nbsp;&nbsp;&nbsp;
							<span lang="en">Account No. :&nbsp;&nbsp;<span class="c-blue"><?=$ship[ship_account_no]?></span></span>
						<?
							}
						?>
					</td>
					<td colspan="6">
					</td>
				</tr>
				<!--<tr>
					<td></td>
					<td lang="ko" class="c-black" colspan="10" style="text-align:left;">
						운송회사 <img src="/kor/images/icon_<?=strtolower(GF_Common_GetSingleList("DLVR",$ship[ship_info]))?>.gif" alt="" height="18" style="margin-bottom:1px;">&nbsp;&nbsp;&nbsp;&nbsp;
						<span lang="en">Account No. :&nbsp;&nbsp;<span class="c-blue"><?=$ship[ship_account_no]?></span></span>
					</td>
				</tr>-->
				<?
				
				if(strlen($ship[memo])>0){?>
				<tr>
					<td></td>
					<td colspan="6" style="text-align:left;" bgcolor="#FFFFCC"><strong class="c-black ">Memo :&nbsp;&nbsp;</strong> <span class="c-blue"><?=$ship[memo]?></span></td>
					<td colspan="6">
					</td>
				</tr>
				<?}?>
				<?
				if($ship[insur_yn] == "o")
				{
					$ship_insur = "Yes";	
				}
				else
				{
					$ship_insur = "No";
				}
				?>				<tr>
					<td></td>
					<td class="c-black" colspan="6" bgcolor="#FFFFCC" style="text-align:left;margin-bottom:1px;">
						운송보험 :&nbsp;&nbsp;<span class="c-red" lang="en"><?=$ship_insur?></span>
					</td>
					<td colspan="8">
					</td>
				</tr>
				
				<?if($ship[delivery_addr_idx] > 0){?>
				<tr>
					<td></td>
					<td scope="row" colspan="6" bgcolor="#FFFFCC" style="text-align:left;">배송지 변경</td>
					<td colspan="6">
					</td>
				</tr>
				<tr>
					<td></td>
					<td lang="ko" colspan="6" bgcolor="#FFFFCC" style="text-align:left;">
						<?=GET_ODR_DELIVERY_ADDR($ship[delivery_addr_idx]);?>
						<!--
						<table class="table-type1-1" lang="ko">
							<tr>
								<td class="t-lt"><img src="/kor/images/nation_title_<?=$addr_row[nation];?>.png" alt="<?=GF_Common_GetSingleList("NA",$addr_row[nation])?>"></td>
							</tr>
							<tr>
								<td class="t-lt">회사명 : <?=$addr_row[com_name];?></td>
							</tr>
							<tr>
								<td class="t-lt">Tel : <?=$addr_row[tel];?></td>
							</tr>
							<tr>
								<td class="t-lt">우편번호 : <?=$addr_row[zipcode];?></td>
							</tr>
							<tr>
								<td>주소 : <?=$addr_row[addr];?></td>
							</tr>
						</table>
						-->
					</td>
					<td colspan="8">
					</td>
				</tr>
				<?}?>							
					
			</table>
		</div>
		
		<div class="btn-area t-rt">
			<!--button type="button" onclick="shipping();"><img src="/kor/images/btn_transmit.gif" alt="전송"></button JSJ-->
			<img id="btn_submit_3016" src="/kor/images/btn_shipping_1.gif" alt="선적">
			<img id="btn_cancel_3016" src="/kor/images/btn_cancel_1.gif" alt="취소">
		</div>
	</form>
</div>

