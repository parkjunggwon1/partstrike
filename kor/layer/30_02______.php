<?
@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.part.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.member.php";?>

<script src="/kor/js/jquery-1.11.3.min.js"></script>
<script src="/include/function.js"></script>
<script>ready();</script>
<div class="layer-hd">
	<h1>발주서</h1>
	<a href="#" class="btn-close"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>
</div>
<div class="layer-content">
<?
$part=get_part($part_idx);
$sell_mem_idx = $part[mem_idx];
$sell_rel_idx = $part[rel_idx];
$part_type = $part[part_type];
$odr_idx = get_any("odr", "odr_idx", "imsi_odr_no ='IM-".$sell_mem_idx."-".$session_mem_idx."'");	
if ($odr_idx){
	//$result 가져와서 memo값 밑에다 뿌려주기.

}
?>	
	<!-- 발주서 30-02 -->
	<form name="f" id="f">
	<input type="hidden" name="typ" value="<?=$odr_idx?"odredit":"write"?>">
	<input type="hidden" name="sell_mem_idx" id="sell_mem_idx" value="<?=$sell_mem_idx?>">
	<input type="hidden" name="sell_rel_idx" id="sell_rel_idx" value="<?=$sell_rel_idx?>">
	<input type="hidden" name="session_mem_idx" id="session_mem_idx" value="<?=$session_mem_idx?>">
	<input type="hidden" name="session_rel_idx" id="session_rel_idx" value="<?=$session_rel_idx?>">
	<input type="hidden" name="odr_idx" id="odr_idx" value="<?=$odr_idx?>">
	<input type="hidden" name="save_yn" id="save_yn" value="<?=$save_yn?>">
	<div class="layer-data">
		<table class="stock-list-table">
			<thead>
				<tr>
					<th scope="col" style="width:50px"><!--<span lang="ko">선적</span><br>-->Option</th>
					<th scope="col">No. </th>
					<th scope="col">Nation</th>
					<th scope="col">Part No.</th>
					<th scope="col">Manufacture</th>
					<th scope="col">Package</th>
					<th scope="col">D/C</th>
					<th scope="col">RoHS</th>
					<th scope="col">O'ty</th>
					<th scope="col">Unit Price</th>
					<th scope="col" lang="ko">발주수량</th>
					<th scope="col" lang="ko">납기</th>
				</tr>
			</thead>
			<tbody>
			<?
			if ($part_idx){
				$result =QRY_PART_LIST(0,"and part_idx in ($part_idx)","");
				while($row = mysql_fetch_array($result)){
				$i++;			
				$part_type= replace_out($row["part_type"]);
				$part_idx= replace_out($row["part_idx"]);
				$part_no= replace_out($row["part_no"]);
				$nation= replace_out($row["nation"]);
				$manufacturer= replace_out($row["manufacturer"]);
				$package= replace_out($row["package"]);
				$dc= replace_out($row["dc"]);
				$rhtype= replace_out($row["rhtype"]);
				$quantity= replace_out($row["quantity"]);
				$price= replace_out($row["price"]);			
				$rel_idx = get_any("part","case when rel_idx = 0 then mem_idx else rel_idx end ","part_idx = $part_idx");
				?>
				<tr>
					<td colspan="12" class="title-box first">
						<h3 class="title"><img src="/kor/images/stock_title0<?=$part_type?>.gif" alt="<?=GF_Common_GetSingleList("PART",$part_type)?>"></h3>
					</td>
				</tr>
				<tr>
					<td><label class="ipt-chk chk2"><input type="hidden" id="part_idx" name="part_idx" value="<?=$part_idx?>"><span></span></label></td>
					<td><?=$i?></td>
					<td><img src="/kor/images/nation_title2_<?=$nation?>.png" alt="<?=GF_Common_GetSingleList("NA",$nation)?>"></td>
					<td><?=$part_no?></td>
					<td><?=$manufacturer?></td>
					<td><?=$package?></td>
					<td><?=$dc?></td>
					<td><?=$rhtype?></td>
					<td><?=$quantity==0?"":$quantity?><input type="hidden" name="quantity" id = "quantity"  value="<?=$quantity?>"></td>
					<td>$<?=number_format($price,2)?></td>
					<td><input type="text" class="i-txt2 c-blue onlynum numfmt" id = "odr_quantity" name="odr_quantity" value="" style="width:56px"></td>
					<td>Stock</td>
				</tr>
				<?}
				}
				
				$assign_result1 = QRY_ASSIGN_LIST($rel_idx, "1");					
				$assign_result2 = QRY_ASSIGN_LIST($rel_idx, "2");					
				$assign_cnt1=mysql_num_rows($assign_result1);	
				$assign_cnt2=mysql_num_rows($assign_result2);	
				?>
				<?if ($assign_cnt2 == 0 ){
					?>
				<tr class="bg-none">
					<td></td>
					<td colspan="11">
						<?=GET_ASSIGN_TYPE1_TABLE($assign_result1, $nation)?>
					</td>
				</tr>
				<?}else{?>
					<tr class="bg-none">
						<td colspan="12">
							<!-- 선불 -->
							<div class="delivery-check">
								<strong class="check-title"><label class="ipt-chk chk4" lang="ko"><input type="checkbox"><span></span> 선불</label></strong>
								<div class="check-wrap">
									<table class="detail-table">
										<tbody>
											<tr>
												<th scope="row" class="va-t">운송회사:</th>
												<td colspan="3">
													<ul lang="en" class="list-type3">
													<?while($row2 = mysql_fetch_array($assign_result2)){
														$i++;				
														$assign_idx= replace_out($row2["assign_idx"]);
														$nation= replace_out($row2["nation"]);
														$o_company_idx= replace_out($row2["o_company_idx"]);
														$i_company_idx= replace_out($row2["i_company_idx"]);
														$o_cost= replace_out($row2["o_cost"])==0?"":replace_out($row2["o_cost"]);
														$i_cost= replace_out($row2["i_cost"])==0?"":replace_out($row2["i_cost"]);
														$sort= replace_out($row2["sort"]);
														?>								
														<li><label class="ipt-chk chk2 c-blue"><input type="radio" name="$o_company_idx"><span></span> <?=($o_company_idx)?GF_Common_GetSingleList("DLVR",$o_company_idx):"선택"?> :  US $<?=$o_cost?></label></li>
													<?}?>
													</ul>
												</td>
											</tr>
											<tr>
											
												<th scope="row">선적정보:</th>
												<td><span class="c-grey2">운송회사</span> <span lang="en"><?=($o_company_idx)?GF_Common_GetSingleList("DLVR",$o_company_idx):"선택";?> US $ <?=$o_cost?></span></td>
												<th scope="row" class="c-red"><span lang="en">Account No.</span></th>
												<td><input type="text" class="i-txt2 c-blue" value="" style="width:92px"></td>
											</tr>
											<tr>
												<td colspan="4" lang="en"><strong class="c-red">Memo</strong> <input type="text" name="memo" class="i-txt2 c-blue" value="<?=$memo?>" style="width:310px"></td>
											</tr>
											<tr>
												<td colspan="4"><label class="ipt-chk chk2"><input type="checkbox"><span></span> 배송지 변경</label></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
							<!-- //선불 -->
							
							<!-- 착불 -->
							<div class="delivery-check">
								<strong class="check-title"><label class="ipt-chk chk4" lang="ko"><input type="checkbox"><span></span> 착불</label></strong>
								<div class="check-wrap">
									<?=GET_ASSIGN_TYPE1_TABLE($assign_result1,$nation)?>
								</div>
							</div>
							<!-- //착불 -->
						</td>
					</tr>
				<?}?>
			</tbody>
		</table>
	</div>
	</form>
	<div class="btn-area t-rt">
		<button type="button" class="btn-dialog-0501"><img src="/kor/images/btn_order_add.gif" alt="발주 추가"></button>
		<!--<button type="button" class="btn-order-confirm"><img src="/kor/images/btn_order_confirm.gif" alt="발주서 확인"></button>-->
		<button type="button" class="btn-dialog-0504"><img src="/kor/images/btn_order_save.gif" alt="발주 저장"></button>
	</div>
</div>


<?function GET_ASSIGN_TYPE1_TABLE($assign_result1,$nation){	
?>
<table class="detail-table">
	<tbody>
		<tr>
			<th scope="row">선적정보:</th>
			<td>
				<span class="c-grey2">운송회사</span>
				<div class="select type4" lang="en" style="width:70px">

					<label class="c-blue">
					<?if ($assign_result1){    //운송회사를 등록 했으면 등록한 업체 하나만 보이기
						$row = mysql_fetch_array($assign_result1);
						$o_company_idx = replace_out($row["o_company_idx"]);
						$i_company_idx = replace_out($row["i_company_idx"]);
						
						if ($nation ==$_SESSION["NATION"]) { //국가가 같으면 국내 배송, 다르면 국제 배송
							echo ($i_company_idx)?GF_Common_GetSingleList("DLDO",$i_company_idx):"선택";
							echo "</label>";
							echo GF_Common_SetComboList("i_company_idx1", "DLDO", $nation, 2, "True",  "선택", $i_company_idx , "");
						}else{
							echo ($o_company_idx)?GF_Common_GetSingleList("DLVR",$o_company_idx):"선택";
							echo "</label>";
							echo GF_Common_SetComboList("o_company_idx1", "DLVR", "", 1, "True",  "선택", $o_company_idx , "");
						}

					}else{   //운송회사 등록 안했으면 모든 운송 업체 다 보이기
						echo "선택</label>";	
						echo GF_Common_SetComboList("o_company_idx1", "DLVR", "", 1, "True",  "선택", $o_company_idx , "");
						
					}?>
					
					
				</div>
			</td>
			<th scope="row"><span lang="en">Account No.</span></th>
			<td><input type="text" class="i-txt2 c-blue" value="" style="width:92px"></td>
		</tr>
		<tr>
			<td colspan="4" lang="en"><strong class="c-red">Memo</strong> <input type="text" name="memo" class="i-txt2 c-blue" value="" style="width:323px"></td>
		</tr>
		<tr>
			<td colspan="4"><label class="ipt-chk chk2"><input type="checkbox" name="insu_chk"><span></span> 운송보험</label></td>
		</tr>
		<tr>
			<td colspan="4"><label class="ipt-chk chk2"><input type="checkbox"  name="del_chg_chk"><span></span> 배송지 변경</label></td>
		</tr>
	</tbody>
</table>
<?}?>

<script>
$(document).ready(function() {
	var f =  document.f;
	 f.target = "proc";
	 f.action = "/kor/proc/odr_proc.php";
	 f.submit();			
});
</script>
