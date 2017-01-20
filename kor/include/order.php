<SCRIPT LANGUAGE="JavaScript">

	$(document).ready(function(){
		$("#this_mem_idx").change(function(){
				var f = document.fr;
				var odr_type = $("#odr_type").val();
				var this_mem_idx =$("#this_mem_idx option:selected").val();
				showajaxParam("#orderlist", "orderlist", "odr_type="+odr_type+"&this_mem_idx="+this_mem_idx);
				ChangeBackground();
		});

		
		ChangeBackground();

		function ChangeBackground(){
			var bgcolor ="<?=$odr_type=="S"?"#dce6f2":"#ffff99"?>";
			var criteria_idx ="";
			$("#fr .stock-list-table .criteria").each(function(e){
				if (criteria_idx != $(this).attr("criteria_idx"))
				{
					if (bgcolor =="#ffffff")
					{
						bgcolor = "<?=$odr_type=="S"?"#dce6f2":"#ffff99"?>";
					}else{
						bgcolor ="#ffffff";
					}
					criteria_idx = $(this).attr("criteria_idx");
					if(e>0){  //첫번째는 두고, 두번째부터 발주가 바뀔 때마다 간격조정
						$("<tr><td colspan='15' style='padding-top:20px; background-color:#FFFFFF;'></td></tr>").insertBefore($(this).prev());
					}
				}
				$(this).css("background-color",bgcolor);
				if ($(this).prev().find("td").hasClass("title-box")==true)
				{
					$(this).prev().find("td").css("background-color",bgcolor);
				}

			});
		}
	});
</SCRIPT>
<!-- table -->

			<section class="box-type1" style="min-height:359px">
			<form name="fr" id="fr" class="clear">
			<input type="hidden" name="odr_type" id = "odr_type" value="<?=$odr_type?>">
				<div class="hd-type-wrap">
					<table class="stock-list-table bg-type4">
						<thead>
							<tr>
								<th scope="col" style="width:23px">No.</th>								
								<?if ($odr_type == "B"){?>
								<!--구매-->
									<th scope="col" style="width:80px">Nation</th>
									<th scope="col" class="t-lt" style="width:120px;">Part No.</th>
									<th scope="col" class="t-lt" style="width:<? echo ($odr_type == "S") ? '80px' : '80px' ?>">Manufacturer</th>
									<th scope="col" style="width: 80px;">Package</th>
									<th scope="col" style="width: 36px;">D/C</th>
									<th scope="col" style="width: 36px;">RoHS</th>
									<th scope="col" class="t-rt" style="width:66px">Q'ty</th>
									<th scope="col" class="t-rt" style="width:62px">Unit Price</th>
									<th scope="col" class="t-rt" lang="ko" style="width:66px">발주수량</th>
									<th scope="col" class="t-rt" lang="ko" style="width:66px">공급수량</th>
									<th scope="col" lang="ko" style="width:35px">납기</th>
									<th scope="col" style="width:52px">Company</th>
								<?}else{?>
								<!--판매-->
									<th scope="col" class="t-lt" style="width:210px;">Part No.</th>
									<th scope="col" class="t-lt" style="width:<? echo ($odr_type == "S") ? '180px' : '120px' ?>">Manufacturer</th>
									<th scope="col" style="width: 80px;">Package</th>
									<th scope="col" style="width: 36px;">D/C</th>
									<th scope="col" style="width: 36px;">RoHS</th>
									<th scope="col" class="t-rt" style="width:66px">Q'ty</th>
									<th scope="col" class="t-rt" style="width:62px">Unit Price</th>
									<th scope="col" class="t-rt" lang="ko" style="width:66px">발주수량</th>
									<th scope="col" class="t-rt" lang="ko" style="width:66px">공급수량</th>
									<th scope="col" lang="ko" style="width:35px">납기</th>									
								<?}?>								
							</tr>


						</thead>
						<thead>
							<tr>
								<td class="title-box" colspan="<?=($odr_type=="B")?"13":"11"?>">
									<div class="select type2">
										<?if (!$this_mem_idx){$this_mem_idx = $_SESSION["MEM_IDX"];}?>
										<?=GET_MyMember($this_mem_idx)?>		
									</div>
								</td>
							</tr>
						</thead>
						<tbody id="orderlist">
						<?//	for ($i = 1; $i<=6; $i++){
							echo GET_RCD_DET_LIST($i , $odr_type, " and a.".($odr_type=="S"?"sell_":"")."mem_idx=$this_mem_idx AND (a.odr_status IN(1,2,3,7,8,16,18,19,20,31) or a.odr_status=0 and imsi_odr_no <> '') ", "S");
						//}?>							
						</tbody>
					</table>
				</div>
				<?//=GET_TURNKEY_ODRDET_LIST($odr_type, " and b.part_type=7 and a.".($odr_type=="S"?"sell_":"")."mem_idx=$this_mem_idx AND a.odr_status IN(1,2,16,18,19,20,31) ", "S")?>
				</form>
			</section>

			<section class="box-type1" style="min-height:358px">
			<form name="fr" id="fr" class="clear">
			<input type="hidden" name="odr_type" id = "odr_type" value="<?=$odr_type?>">
				<div class="hd-type-wrap">
					<table class="stock-list-table bg-type4">
						<thead>
							<tr>
								<th scope="col" style="width:23px">No.</th>								
								<?if ($odr_type == "B"){?>
								<!--구매-->
									<th scope="col" style="width:80px">Nation</th>
									<th scope="col" class="t-lt" style="width:120px;">Part No.</th>
									<th scope="col" class="t-lt" style="width:<? echo ($odr_type == "S") ? '80px' : '80px' ?>">Manufacturer</th>
									<th scope="col" style="width: 80px;">Package</th>
									<th scope="col" style="width: 36px;">D/C</th>
									<th scope="col" style="width: 36px;">RoHS</th>
									<th scope="col" class="t-rt" style="width:66px">Q'ty</th>
									<th scope="col" class="t-rt" style="width:62px">Unit Price</th>
									<th scope="col" class="t-rt" style="width:66px">Amount</th>
									<th scope="col" lang="ko" style="width:35px">납기</th>
									<th scope="col" style="width:52px">Company</th>
								<?}else{?>
								<!--판매-->
									<th scope="col" class="t-lt" style="width:210px;">Part No.</th>
									<th scope="col" class="t-lt" style="width:<? echo ($odr_type == "S") ? '180px' : '120px' ?>">Manufacturer</th>
									<th scope="col" style="width: 80px;">Package</th>
									<th scope="col" style="width: 36px;">D/C</th>
									<th scope="col" style="width: 36px;">RoHS</th>
									<th scope="col" class="t-rt" style="width:66px">Q'ty</th>
									<th scope="col" class="t-rt" style="width:62px">Unit Price</th>
									<th scope="col" class="t-rt" style="width:66px">Amount</th>
									<th scope="col" lang="ko" style="width:35px">납기</th>									
								<?}?>								
							</tr>


						</thead>
						<thead>
							<tr>
								<td class="title-box" colspan="<?=($odr_type=="B")?"13":"11"?>">
									<div class="select type2">
										<?if (!$this_mem_idx){$this_mem_idx = $_SESSION["MEM_IDX"];}?>
										<?=GET_MyMember($this_mem_idx)?>	
									</div>
								</td>
							</tr>
						</thead>
						<tbody id="orderlist">
						<?//	for ($i = 1; $i<=6; $i++){
							echo GET_RCD_DET_LIST($i , $odr_type, " and a.".($odr_type=="S"?"sell_":"")."mem_idx=$this_mem_idx AND a.odr_status NOT IN(0,1,2,3,7,8,16,18,19,20,31)", "S");
						//}?>							
						</tbody>
					</table>
				</div>
				<?//=GET_TURNKEY_ODRDET_LIST($odr_type, " and b.part_type=7 and a.".($odr_type=="S"?"sell_":"")."mem_idx=$this_mem_idx AND a.odr_status NOT IN(1,2,16,18,19,20,31) ", "S")?>
				</form>
			</section>
			<!--// table -->