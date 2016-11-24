<?
@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include $_SERVER["DOCUMENT_ROOT"]."/include/class/class.odrinfo.php";
?>

<script src="/kor/js/jquery-1.11.3.min.js"></script>
<script src="/include/function.js"></script>
<script>ready();</script>

<div class="layer-hd">
	<h1>송장(3008)</h1>
	<a href="#" class="btn-close"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>
</div>
<div class="layer-content">
	<form name="f" id="f" method="post" >
	<input type="hidden" name="typ" value="invreg">	
	<input type="hidden" name="odr_idx" id="odr_idx_30_08" value="<?=$odr_idx?>">	
	<?
	
	  $odr = get_odr($odr_idx);
	  $buy_com_idx = $odr["rel_idx"]>0?$odr["rel_idx"] : $odr["mem_idx"];
	  $sell_com_idx = $odr["sell_rel_idx"]>0?$odr["sell_rel_idx"] : $odr["sell_mem_idx"];
	  $b_mem = get_mem($buy_com_idx);
	  $s_mem = get_mem($sell_com_idx);

	  $b_nation = $b_mem[nation];
	  $s_nation = $s_mem[nation];
	?>
		<!-- layer-file -->
		<div class="layer-file">
			<table>
				<tbody>
					<tr>
						<td class="company"><img src="/kor/images/nation_title_<?=$b_nation?>.png" alt="<?=GF_Common_GetSingleList("NA",$b_nation)?>"> <span class="name"><?=$b_mem[mem_nm_en]?></span></td>
					</tr>
				</tbody>
			</table>
		</div>
		<!-- //layer-file -->
		
		<div class="layer-data">
			<table class="stock-list-table bg-type2">
				<thead>
					<tr>
						<th scope="col" style="width:50px">No. </th>
						<th scope="col" class="t-lt">Part No.</th>
						<th scope="col" class="t-lt">Manufacturer</th>
						<th scope="col">Package</th>
						<th scope="col">D/C</th>
						<th scope="col">RoHS</th>
						<th scope="col" class="t-rt">O'ty</th>
						<th scope="col" class="t-rt">Unit Price</th>
						<th scope="col" lang="ko">발주수량</th>
						<th scope="col" lang="ko">공급수량</th>
						<th scope="col" lang="ko" style="width:50px">납기</th>
					</tr>
				</thead>

				<?	for ($i = 1; $i<=7; $i++){
						echo GET_ODR_DET_LIST("30_08", $i," and odr_idx=$odr_idx ");
				}?>

				
				<tbody >
					<tr <?if (QRY_CNT("odr_det", "and odr_idx = $odr_idx and part_type =2") > 0){echo "disabled";}?>  class="bg-none">
						<td></td>
						<td colspan="10">
							<table class="detail-table mr-t0">
								<tbody>									
									<?if ($b_nation ==$s_nation){
									$tax = get_any("tax", "tax_percent", "nation=$b_nation and tax_name='VAT'");
									?>
									<tr>
										<td colspan="4"><label class="ipt-chk chk2"><input type="checkbox" <?if ($tax){?>checked class="checked"<?}?>><span></span> 부가세 : <input type="text" class="i-txt5" name="tax" value="<?=$tax?>" style="width:30px" <?if (QRY_CNT("odr_det", "and odr_idx = $odr_idx and part_type =2") > 0){echo "readonly";}?>> %</label></td>
									</tr>
									<?}?>
									<tr>
										<td colspan="4">
										<?$assign = get_any("assign", "o_company_idx", "rel_idx = (SELECT case when sell_rel_idx = 0 then sell_mem_idx else sell_rel_idx end as com_idx FROM `odr` WHERE odr_idx =$odr_idx) and assign_type = 1");
										if ($assign) { ?>
											<label class="ipt-chk chk2 c-red"><input type="checkbox" class="btn-pop-1504 checked" loadPage="30_08" checked odr_idx="<?=$odr_idx?>" name="appoint_yn" value="Y"><span></span> 판매자 지정 운송회사 <span id="appoint"> : <img src='/kor/images/icon_<?=strtolower(GF_Common_GetSingleList("DLVR",$assign))?>.gif' height='15'></span></label>
										<?}else{?>
										<label class="ipt-chk chk2"><input type="checkbox" class="btn-pop-1504" loadPage="30_08" odr_idx="<?=$odr_idx?>" name="appoint_yn" value="Y"><span></span> 판매자 지정 운송회사 <span id="appoint"></span></label>
										<?}?>
										</td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		
		<div class="btn-area t-rt">
			<button type="button" class="btn-view-sheet-3009"><img src="/kor/images/btn_invoice_confirm.gif" alt="송장 확인"></button>
		</div>
	</form>
</div>

