<?
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.part.php";
function GF_GET_PART_LIST($page, $part_type,$part_no){
	global $viewpagecnt;
	?>			
	
<SCRIPT LANGUAGE="JavaScript">

	$(document).ready(function(){
		$(".pagination a.link").click(function(){
				showajaxParam("#f3 #partlist", "partlist", "page="+$(this).attr("num")+"&part_type="+$("#part_type").val()+"&part_no="+document.f3.srch_part_no.value);
		});
		$("#partlist input:text").keyup(function(){		
			if ($(this).attr("name") !="mod_part_no[]" && $(this).attr("name")!="mod_manufacturer[]" && $(this).attr("name")!="mod_package[]" && $(this).attr("name")!="mod_dc[]" && $(this).attr("name")!="mod_rhtype[]" && $(this).attr("name")!="quantity_tmp[]" && $(this).attr("name")!="mod_price[]")
			{
				$("#partlist .save span").hide();
				$("#partlist .save button").show();
			}
			else
			{
				
					$("#partlist .save span").show();
					$("#partlist .save button").hide();	
				
			}
			
			
		});
		
		$("#partlist input[name^=delchk]").click(function(e){
			if($("#partlist input[name^=delchk].checked").length==1){
				if ($(this).hasClass("checked")==true)
				{
					$("#partlist .save span").show();
					$("#partlist .save button").hide();
				}	
			}else{
				if ($(this).hasClass("checked")==false)
				{
					$("#partlist .save span").hide();
					$("#partlist .save button").show();
				}

			}
		});

		

	 });
function doller_add(nm)
{
	//$문자 검증  start
	var str = $("#mod_price_"+nm).val();
	//정규표현식
	var regExp = /[\{\}\[\]\/?.;:|\)*~`!^\$\\\=\(\'\"]/gi

	if(regExp.test(str)){

	}else{
		$("#mod_price_"+nm).val("$"+$("#mod_price_"+nm).val());
	}

	//$문자 검증 end
}

function change_select()
{
	$("#partlist .save span").hide();
	$("#partlist .save button").show();
}

</SCRIPT>

					<table class="stock-list-table">
						<thead>
							<tr>
								<th scope="col" class="pd-0"><!--No.--></th>
								<th scope="col" class="t-lt">Part No.</th>
								<th scope="col" class="t-lt">Manufacturer</th>
								<th scope="col">Package</th>
								<th scope="col">D/C</th>
								<th scope="col">RoHS</th>
								<th scope="col" class="t-rt">O'ty</th>
								<th scope="col" class="t-rt">Unit Price</th>
								<th scope="col" lang="ko" style="width:50px"><a href="javascript:alldel_chk('');" class="c-yellow">제거</a></th>
							</tr>
						</thead>
						<tbody>
						<?
							$recordcnt = 17;
							$searchand .= "and mem_idx = ".$_SESSION["MEM_IDX"]." and rel_idx = ".$_SESSION["REL_IDX"]." and part_type =$part_type and del_yn = 'N' "; 
							if ($part_no){
								$searchand .= "and part_no like '%$part_no%'";
							}
							$cnt = QRY_CNT("part",$searchand);							
							$totalpage = QRY_TOTALPAGE($cnt,$recordcnt);
							$result =QRY_PART_LIST($recordcnt,$searchand,$page,"part_idx");
							$i = 0;
							$ListNO=$cnt-(($page-1)*$recordcnt);
							if ($cnt > 0){
								while($row = mysql_fetch_array($result)){
									$i++;				
									$part_idx= replace_out($row["part_idx"]);
									$part_no= replace_out($row["part_no"]);
									$manufacturer= replace_out($row["manufacturer"]);
									$package= replace_out($row["package"]);
									$dc= replace_out($row["dc"]);
									$rhtype= replace_out($row["rhtype"]);
									$quantity= replace_out($row["quantity"]);
									$price= replace_out($row["price"]);
									$turnkey_idx= replace_out($row["turnkey_idx"]);
									$del_chk= replace_out($row["del_chk"]);
									//$dc = substr($dc, 2,2);
									if ($part_type =="2"){
										$dc = "NEW";
										$quantity="";
									}
									$invreg_chk= replace_out($row["invreg_chk"]);

									if ($invreg_chk == 1)
									{
										$no_modify = "readonly";
										$no_modify_border="border:0;";
									}			
									else
									{
										$no_modify = "";
										$no_modify_border="";
									}
									?>
								<tr>
									<td class="pd-0"><input type="hidden" name="mod_part_idx[]" value="<?=$part_idx?>"><!--<?=$ListNO?>--></td>
									<td class="pd-l0 t-lt"><input type="text" name="mod_part_no[]" class="i-txt2 t-lt" <?=$no_modify?> maxlength="24" style="<?=$no_modify_border?>width:190px; ime-mode:disabled;" value="<?=$part_no?>"></td>
									<td class="t-lt"><input type="text" name="mod_manufacturer[]" class="i-txt2  t-lt"  <?=$no_modify?> maxlength="20" style="<?=$no_modify_border?>width:155px; ime-mode:disabled;" value="<?=$manufacturer?>"></td>
									<td><input type="text" name="mod_package[]" class="i-txt2  t-ct" <?=$no_modify?> style="<?=$no_modify_border?>width:76px; ime-mode:disabled;" maxlength="10" value="<?=$package?>"></td>
									<td><input type="text" name="mod_dc[]" class="i-txt<?=$part_type=="2"?"6":"2"?>" <?=$no_modify?> style="<?=$no_modify_border?>width:45px" maxlength="4" value="<?=$dc?>"></td>
									<?if ($no_modify !="readonly"){?>
									<td>
										<div class="select type4" lang="en" style="width:60px">
											<label><?=$rhtype==""?"None":$rhtype?></label>
											<select name="mod_rhtype[]" onchange="change_select();" >
											<option lang="en" <?if($rhtype==""){echo "selected";}?>>None</option>
												<option lang="en" <?if($rhtype=="RoHS"){echo "selected";}?>>RoHS</option>
												<option lang="en" <?if($rhtype=="HF"){echo "selected";}?>>HF</option>
											</select>
										</div>
									</td>
									<?
									}
									else
									{
									?>
									<td class="t-ct" style="padding-left:10px;">
										<?=$rhtype?>
										<input type="hidden" name="mod_rhtype[]" value="<?=$rhtype?>" />
									</td>
									<?
									}

									$test= "";

									if(strpos($price, ".") == false)  
									{
										$price_val= number_format($price,2);
									}
									else
									{
										$price_val= $price;
									}
									?>									
									<td class="t-rt"><?=$test?><?if ($part_type==2){?><input type="text" name="quantity_tmp" readonly class="i-txt6 onlynum numfmt t-rt" maxlength="10" style="width:66px" value="I"><?}else{?><input type="text" name="mod_quantity[]" class="i-txt2 onlynum numfmt t-rt" maxlength="10" style="width:66px" value="<?echo number_format($quantity);?>"> <?}?></td>
									
									<td class="t-rt"><input type="text" name="mod_price[]" id="mod_price_<?=$i?>" onkeyup="javascript:doller_add('<?=$i?>');" class="i-txt2 onlynum numfmt t-rt price_fmt" style="width:76px" maxlength="9" value="<?if($price){echo "$".$price_val;}?>"></td>
									<td class="td_c"><label class="ipt-chk chk2"><input type="checkbox" name="delchk[]" value="<?=$part_idx?>" <?if ($del_chk=="0"){echo "disabled";}?>><span></span></label></td>

								</tr>	
								<?
									$ListNO--;	
								}
								?></tbody>					
					</table>
					<div class="btn-area save pos_ab">
						<span class="f-rt"><img src="/kor/images/btn_stock_save_1.gif" alt="저장"></span>
						<button type="button" class="f-rt" onclick="del();" style="display:none;"><img src="/kor/images/btn_stock_save.gif" alt="저장"></button>
					</div>
					<?
							}else{
							?></tbody>					
					</table>
					<div class="btn-area save" >
						<span class="f-rt" style="display:none;"><img src="/kor/images/btn_stock_save_1.gif" alt="저장"></span>
						<button type="button" class="f-rt" onclick="del();" style="display:none;"><img src="/kor/images/btn_stock_save.gif" alt="저장"></button>
					</div>
						  <?}?>

						
					<div class="pagination">
						<? include $_SERVER["DOCUMENT_ROOT"]."/include/paging2.php"; ?>									
					</div>
<?}				
						
function GF_GET_TURNKEY_EDIT($page){
	global $viewpagecnt?>

	<SCRIPT LANGUAGE="JavaScript">

	$(document).ready(function(){
		$(".pagination a.link").click(function(){
				showajaxParam("#turnkeyManageTop", "turnkeyedit", "page="+$(this).attr("num"));
		});


		$("input[name^=price_]").keydown(function(e){
			if($(this).val()==""){
				$(this).val("$");
			}else if($(this).val()=="$"){
				$(this).val("");
			}

		
		});

	$("input[name^=price_]").keyup(function(e){
		var $this = $(this).parent().next().next();
		if($(this).val()==""){
				$this.find("span.reg").show();
				$this.find("button.reg").hide();
		}else{
				$this.find("span.reg").hide();
				$this.find("button.reg").show();
		}
	});

	$("#turnkeyManageTop input[name^=delchk]").click(function(e){
		chgSavebtn($(this).parents("form").attr("name").replace("form_",""));
	});

	$("#turnkeyManageTop input").keyup(function(e){		
		if ($(this).attr("name").indexOf("[]")>0)
		{		
			chgSavebtn($(this).parents("form").attr("name").replace("form_",""));
		}
	});

	$("#turnkeyManageTop select").change(function(e){
		chgSavebtn($(this).parents("form").attr("name").replace("form_",""));
	});

	function chgSavebtn(id){	
		$("#turnkeyManageTop #maintr_"+id).find("span.reg").hide();
		$("#turnkeyManageTop #maintr_"+id).find("button.reg").show();
	}
	
	 });
</SCRIPT>


					<div class="box-top bg2">
						<h2>내 턴키 편집</h2>
					</div>
					<table class="stock-list-table">
						<thead>
							<tr>
								<th scope="col" style="width:23px">No.</th>
								<th scope="col" class="t-lt">Title</th>
								<th scope="col" class="t-rt" style="width:90px">Price</th>
								<th scope="col" style="width:50px"></th>
								<th scope="col" style="width:50px"></th>
							</tr>
						</thead>
						<tbody>
						<?  $recordcnt = 3;
							$searchand .= "and part_type = 7 and turnkey_idx = 0 and mem_idx = ".$_SESSION["MEM_IDX"]." and rel_idx = ".$_SESSION["REL_IDX"]." "; 	
							$cnt = QRY_CNT("part",$searchand);				
							//echo "<tr><td>$cnt</td></tr>";
							
							$totalpage = QRY_TOTALPAGE($cnt,$recordcnt);
							$result =QRY_TURNKEY_LIST($recordcnt,$searchand,$page);
							$i = 0;
							$ListNO=$cnt-(($page-1)*$recordcnt);
							if ($cnt > 0){
								while($row = mysql_fetch_array($result)){
									$i++;				
									$turnkey_idx= replace_out($row["part_idx"]);
									$title= replace_out($row["part_no"]);
									$nation= replace_out($row["nation"]);
									$price= replace_out($row["price"]);
									?>				
							<tr id="maintr_<?=$turnkey_idx?>" <?if ($ListNO %2 ==1){?>style="background-color:#f7f7f7;"<?}?>>							
								<td><?=$ListNO?></td>
								<td class="t-lt"><a  href="javascript:showtr(<?=$turnkey_idx?>);"><?=get_cut($title,80)?></a></td>
								<td class="t-rt"><span class="c-blue"></span> <input type="text" name="price_<?=$turnkey_idx?>" class="i-txt2 onlynum numfmt t-rt" maxlength="11" style="width:76px" value="<?if($price){echo "$".number_format($price,2);}?>"></td>
								<td><span class="del" style="display:none;"><img src="/kor/images/btn_turn_del_1.gif" alt="삭제"></span><button type="button" class="del" onclick="delturnkey('<?=$turnkey_idx?>');"  ><img src="/kor/images/btn_turn_del.gif" alt="삭제"></button></td>
								<td class="pd-0"><span class="reg"><img src="/kor/images/btn_turn_save_1.gif" alt="저장"></span><button class="reg" type="button" onclick="del('<?=$turnkey_idx?>');" style="display:none;"><img src="/kor/images/btn_turn_save.gif" alt="저장"></button></td>
							</tr>
							
							<tr class="subtr" id="subtr_<?=$turnkey_idx?>" style="display:none;">
								<td></td>
								<td colspan="4" class="pd-0">
									<form name="form_<?=$turnkey_idx?>" id="form_<?=$turnkey_idx?>"  method="post">
									<input type="hidden" name="typ" value="">
									<input type="hidden" name="part_type" value="7">
									<input type="hidden" name="turnkey_idx" value="<?=$turnkey_idx?>">
									<input type="hidden" name="price" value="">
									<table class="stock-list-table">
										<thead>
											<tr>
												<th scope="col" style="width:23px">No. </th>
												<th scope="col" class="t-lt">Part No.</th>
												<th scope="col" class="t-lt">Manufacturer</th>
												<th scope="col">Package</th>
												<th scope="col">D/C</th>
												<th scope="col">RoHS</th>
												<th scope="col" class="t-rt">O'ty</th>
												<th scope="col" lang="ko"><a href="javascript:alldel_chk('');" class="c-yellow">제거</a></th>
												<th class="down pd-0"><a href="javascript:excelDown(<?=$turnkey_idx?>);"><img src="/kor/images/btn_stock_list_down.gif" alt=""></a></th>
											</tr>
										</thead>
										<tbody>
										<?
										$searchand = "";
										$searchand .= "and part_type = 7 and turnkey_idx =$turnkey_idx "; 
										$cnt2 = QRY_CNT("part",$searchand);				
										$result2 =QRY_PART_LIST(0,$searchand,$page,"part_idx");
										$j = 0;
										if ($cnt2 > 0){
											while($row2 = mysql_fetch_array($result2)){
												$j++;				
												$part_idx= replace_out($row2["part_idx"]);
												$part_no= replace_out($row2["part_no"]);
												$manufacturer= replace_out($row2["manufacturer"]);
												$package= replace_out($row2["package"]);
												$dc= replace_out($row2["dc"]);
												$rhtype= replace_out($row2["rhtype"]);
												$quantity= replace_out($row2["quantity"]);
												$price= replace_out($row2["price"]);
												$turnkey_idx= replace_out($row2["turnkey_idx"]);
												$dc = substr($dc, 2,2);
												if ($part_type =="2"){
													$dc = "NEW";
													$quantity="";
												}
												?>

											<tr <?if ($j %2 ==1){?>style="background-color:#f7f7f7;"<?}?>>
													<td><input type="hidden" name="mod_part_idx[]" value="<?=$part_idx?>"><?=$j?></td>
													<td><input type="text" name="mod_part_no[]" class="i-txt2 t-lt" style="width:180px; ime-mode:disabled;" maxlength="24" value="<?=$part_no?>"></td>
													<td><input type="text" name="mod_manufacturer[]" class="i-txt2 t-lt" style="width:140px;ime-mode:disabled;" maxlength="20" value="<?=$manufacturer?>"></td>
													<td><input type="text" name="mod_package[]" class="i-txt2 w-50" style="width:65px;ime-mode:disabled;" maxlength="10" value="<?=$package?>"></td>
													<td><input type="text" name="mod_dc[]" class="i-txt2 onlynum" style="width:36px" value="<?=$dc?>" maxlength="4" ></td>
													<td>
														<div class="select type4" lang="en" style="width:60px">
															<label><?=$rhtype?></label>
															<select name="mod_rhtype[]">
																<option lang="en" <?if($rhtype==""){echo "selected";}?>>None</option>
																<option lang="en" <?if($rhtype=="RoHS"){echo "selected";}?>>RoHS</option>
																<option lang="en" <?if($rhtype=="HF"){echo "selected";}?>>HF</option>
															</select>
														</div>
													</td>
													<td><input type="text" name="mod_quantity[]" class="i-txt2 onlynum numfmt t-rt" maxlength="10" style="width:58px" value="<?echo number_format($quantity);?>"></td>
													<td class="td_c" style="width:60px"><label class="ipt-chk chk3"><input type="checkbox" name="delchk[]" value="<?=$part_idx?>"><span></span></label></td>
												</tr>	
												<?
												}
											}else{
											?>
										  <?}?>
										</tbody>
									</table>
									</form>
								</td>
								
							</tr>
							
							<?
											$ListNO--;		
								}
											
							}else{
								
							}?>
						</tbody>
					</table>
					<div class="pagination not_pos">
						<? include $_SERVER["DOCUMENT_ROOT"]."/include/paging2.php"; ?>									
					</div>
				</form>
<?}

function GF_GET_TURNKEY_LIST($page,$part_no){
	global $viewpagecnt;
	?>	
	<SCRIPT LANGUAGE="JavaScript">
	$(document).ready(function(){
		$(".pagination a.link").click(function(){
				showajaxParam("#stockManage", "turnkeylist", "page="+$(this).attr("num"));
		});		

		$('.onlyEngNum').css("ime-mode","disabled").keydown(function(event){ 		//ENG, 숫자만 입력하게.(.도 포함) 	
		  if (event.which && (event.which == 13 || event.which == 190 || event.which == 110 || event.which > 45 && event.which < 58 || event.which == 8 || event.which > 64 && event.which < 91|| event.which > 95 && event.which < 123)) {			
		   } else { 
		   event.preventDefault(); 
		  } 
		 });

	 });
	$(".board-list tbody a").on("click",function(){
		$(".board-list tbody a").removeClass("c-blue");
		$(this).addClass("c-blue");
	});
	</SCRIPT>
					<form name="f3" id="f3" method="post">
					<input type="hidden" name="part_type" value="7">
					<input type="hidden" name="typ" value="">
					<div class="box-top srch-box bg2">
						<div class="srch-block1"><label lang="en">Part No. <input type="text" class="onlyEngNum" style="ime-mode:disabled" maxlength="30" onkeypress="check_key(part_sch);" name="srch_part_no" value="<?=$part_no?>" ></label><button type="button" onclick="part_sch();"><img src="/kor/images/btn_srch2.gif" alt="검색"></button></div>
						<h2 class="srch-block2" style="padding-right:30px;">턴키 목록</h2>
					</div>
					<table class="stock-list-table  board-list">
						<thead>
							<tr>
								<th scope="col" style="width:23px">No. </th>
								<th scope="col" style="width:80px">Nation</th>
								<th scope="col" class="t-lt">Title</th>
								<th scope="col" class="t-rt" style="width:110px">Price</th>
								<th scope="col" style="width:50px">&nbsp;</th>
								<th scope="col" lang="ko" style="width:50px">&nbsp;</th>
							</tr>
						</thead>
						<tbody>
						<?
							$recordcnt = 10;
							$searchand = "and part_type = 7 and turnkey_idx = 0 ";
							
							if ($part_no){
								$searchand .= " and part_no like '%$part_no%'";
							}
							

							$cnt = QRY_CNT("part",$searchand);				
							
							$totalpage = QRY_TOTALPAGE($cnt,$recordcnt);
							$result =QRY_TURNKEY_LIST($recordcnt,$searchand,$page);
							$i = 0;
							$ListNO=$cnt-(($page-1)*$recordcnt);
							if ($cnt > 0){
								while($row = mysql_fetch_array($result)){
									$i++;		
									$turnkey_idx= replace_out($row["part_idx"]);
									$mem_idx= replace_out($row["mem_idx"]);
									$rel_idx= replace_out($row["rel_idx"]);
									$title= replace_out($row["part_no"]);
									$nation= replace_out($row["nation"]);
									$price= replace_out($row["price"]);
									$sell_com_idx = $rel_idx ==0?$mem_idx:$rel_idx;

									$already_idx = get_want("mybox","idx"," AND part_type ='7' and mem_idx = '".$_SESSION["MEM_IDX"]."' and part_idx = '$turnkey_idx'");
									if($already_idx){$already="1";}else{$already="";}
									?>

							<tr <?if ($ListNO %2 ==0){?>style="background-color:#f7f7f7;"<?}?>>
								<td><?=$ListNO?></td>
								<td><img src="/kor/images/nation_title2_<?=$nation?>.png" alt=""/></td>
								<td class="t-lt"><a href="javascript:turnkey_det(<?=$turnkey_idx?>);"><?=get_cut($title,65)?></a></td>
								<td class="t-rt">$<?=number_format($price,2)?></td>
								<?if ($_SESSION["COM_IDX"]==$sell_com_idx) { ?>
								<td><img src="/kor/images/btn_order_1.gif" title="My Stock">
								<?}else{?>
								<td class="btn-turnkey" sell_com_idx="<?=$mem_idx?>" sell_mem_idx="<?=$_SESSION["MEM_IDX"]?>"  id="<?=$turnkey_idx?>" part_type="7"><a href="javascript:;"><img src="/kor/images/btn_order.gif" alt="발주"></a>
								<?}?>
								
								</td> 
								<td class="delivery"><a href="javascript:;" class="btn-mybox" sell_com_idx="<?=$mem_idx?>" sell_mem_idx="<?=$_SESSION["MEM_IDX"]?>" id="<?=$turnkey_idx?>" part_type="7"><img src="/kor/images/btn_mybox<?=$already?>.gif" alt="My box" id='mybox_<?=$turnkey_idx?>'></a></td>
							</tr>
							<?
											$ListNO--;		
								}
											
							}else{
								?><?
							}?>
							
						</tbody>					
					</table>
					<div class="pagination">
						<? include $_SERVER["DOCUMENT_ROOT"]."/include/paging2.php"; ?>									
					</div>
				</form>
<?}

/********************************************** 메인 리스트(검색결과) **********************************************************************************/
function GET_MAIN_LIST($titleyn, $part_type, $page, $searchand , $area =""){   //$titleyn : 처음 랜더링 할때에는 tbody부분이 필요하고 5개씩 slidedown 추가하는 경우에는 tbody 타이틀바가 필요 없다.
	$recordcnt = 5;
	$searchandsin = $searchand;

	if ($searchand == ""){
		$searchand = "and part_no = '' and manufacturer = '' and rhtype = ''";
	}
	$searchand .= "and part_type =$part_type "; 
	$searchand .= "and del_yn='N' and price>0 "; //2016-04-08 : 삭제되지 않아고, 단가 있는것만
	if ($part_type !="2"){
		$searchand .= "and quantity > 0 "; //2016-11-10 : 지속적 공급가능 품목외에 모든 품목은 수량 0 이상인 것만 노출
	}
	$cnt = QRY_CNT("part",$searchand);
	$totalpage = QRY_TOTALPAGE($cnt,$recordcnt);
	$result =QRY_PART_LIST($recordcnt,$searchand,$page);
	$i = 0;
	$ListNO=$cnt-(($page-1)*$recordcnt);


	
	$smb=get_part($part_idx);   //smb : sell_member
	$sell_mem_idx = $smb[mem_idx];
	$sell_rel_idx = $smb[rel_idx];
	$odr_idx = get_any("odr", "odr_idx", "odr_idx='".$_SESSION["IMSI_".$sell_mem_idx."_".$session_mem_idx]."'");
		if ($titleyn =="Y"){
		?>	
			<tbody id="tbd_<?=$part_type?>">
			<tr>
				<td colspan="11" class="title-box <?if ($part_type=="1"){?>first<?}?>">
					<h3 class="title"><img src="/kor/images/stock_title0<?=$part_type?>.gif" alt="<?=GF_Common_GetSingleList("PART",$part_type)?>"></h3>
					<?if ($cnt > 5){?>
					<div class="stock-ctr">						
						<input type="hidden" id="page_<?=$part_type?>" value="<?=$page?>">
						<span><?=$cnt?></span>
						<a href="javascript:;" class="ctr-up" part_type="<?=$part_type?>"><img src="/kor/images/btn_list_up.png" alt=""></a>
						<a href="javascript:slidedown('<?=$part_type?>');" class="ctr-dwn"><img src="/kor/images/btn_list_down.png" alt=""></a>						
					</div>
					<?}?>
				</td>
			</tr>
		<?
		}


		if ($cnt > 0){


			while($row = mysql_fetch_array($result)){
				$i++;				
				$part_idx= replace_out($row["part_idx"]);
				$part_type= replace_out($row["part_type"]);
				$part_no= replace_out($row["part_no"]);
				$sell_mem_idx= replace_out($row["mem_idx"]);
				$rel_idx= replace_out($row["rel_idx"]);
				$sell_com_idx = $rel_idx==0?$sell_mem_idx:$rel_idx;
				$nation= replace_out($row["nation"]);
				$dosi= replace_out($row["dosi"]);
				$manufacturer= replace_out($row["manufacturer"]);
				$package= replace_out($row["package"]);
				$dc= replace_out($row["dc"]);
				$rhtype= replace_out($row["rhtype"]);
				$quantity= replace_out($row["quantity"]);
				$price= replace_out($row["price"]);	
				
				if( ($price == (int)$price) )
				{					

					$price_val = round_down($price,2);
					$price_val = number_format($price,2);
				}
				else {			
					$price_val = $price;
					$price_val = $price;
				}
				
				$already_idx = get_want("mybox","idx"," and mem_idx = '".$_SESSION["MEM_IDX"]."' and part_idx = '$part_idx'");
				if(($already_idx and $_SESSION["MEM_IDX"] ) ){$already="1";}else{$already="";}
				if ($part_type =="2"){
						$dc = "NEW";
						$quantity="I";
					}
				$nation_nm = ($area == "on" || strpos($searchand,"nation")==true)?$nation."_".$dosi:$nation;
				//지속적 공급가능 품목외에 모든 품목은 수량 0 이상인 것만 노출 - 2016-04-08 ->개수를 위에서 계산해 놨는데, 여기에서 제약하면 출력 되는 개수가 줄어들어 버림. searchand 조건에 걸었음. (2016-11-10)
				if($part_type == "2" || ($part_type != "2" && $quantity>0)){
				?>
				<tr>
					<td><?=$cnt-$ListNO+1?></td>
					<td><img src="/kor/images/nation_title2_<?=$nation_nm?>.png" alt="<?=GF_Common_GetSingleList("NA",strpos($searchand,"nation")==true?$dosi:$nation)?>"></td>
					<td class="t-lt"><?=cut_len($part_no,22,".")?></td>
					<td class="t-lt"><?=cut_len($manufacturer,18,".")?></td>
					<td><?=$package?></td>
					<td><?=$dc?></td>
					<td><?=$rhtype?></td>
					<?if($part_type == "2"){?>
						<td class="t-rt"><?=$quantity?></td>
					<?}else{?>
						<td class="t-rt"><?=$quantity==0?"":number_format($quantity)?></td>
					<?}?>
					<td class="t-rt">$<?=$price_val?></td>
					<td class="delivery t-ct">
					<?if ($part_type=="2" || $part_type=="5" || $part_type=="6"){?>
						<?if ($_SESSION["COM_IDX"]==$sell_com_idx) { ?>
						<img src="/kor/images/btn_ok_1.gif" title="My Stock">
						<?}else{?>
							<a class="btn-dialog-3102" href="javascript:;" sell_com_idx="<?=$sell_com_idx?>" sell_mem_idx="<?=$sell_mem_idx?>" id="<?=$part_idx?>" ><img alt="확인" src="/kor/images/btn_ok.gif" ></a>
						<?}?>
					<?}else{?>
						<?if ($_SESSION["COM_IDX"]==$sell_com_idx) { ?>
						<img src="/kor/images/btn_order_1.gif" title="My Stock">
						<?}else{?>
						<a href="#layerPop3" class="btn-order" sell_com_idx="<?=$sell_com_idx?>" sell_mem_idx="<?=$sell_mem_idx?>" id="<?=$part_idx?>"><img src="/kor/images/btn_order.gif" ></a>
						<?}?>
					<?}?>
					</td>
					<td class="delivery">
						<?if ($_SESSION["COM_IDX"]==$sell_com_idx) { ?>
						<img src="/kor/images/btn_mybox1.gif" title="My Stock">
						<?}else{?>
						<a href="javascript:;" class="btn-mybox" sell_com_idx="<?=$sell_com_idx?>" sell_mem_idx="<?=$sell_mem_idx?>" id="<?=$part_idx?>" part_type="<?=$part_type?>"><img src="/kor/images/btn_mybox<?=$already?>.gif" title="<?=$already=="1"?"Aleady Saved":""?>" id='mybox_<?=$part_idx?>'></a>
						<?}?>
					</td>
				</tr>
				<?
				$ListNO--;	
				} //end of 노출 제약(수량)

			}  //end of while
	
	} //end if ($cnt > 0)
	if ($titleyn =="Y"){
		echo "</tbody>";
	}
}
//---- [발주 추가] 검색 목록(From:05_01) ------------------------------------------------------------------------------------------------------------------------------------------
function GET_ADDPART_LIST($part_type,$searchand){  
	$recordcnt = 5;
	$searchand .="and part_type =$part_type ";
	$searchand .= "and del_yn='N' and price>0"; //2016-04-08 : 삭제되지 않아고, 단가 있는것만
	
	$cnt = QRY_CNT("part",$searchand);							
	$result =QRY_PART_LIST(0,$searchand,"");
	$i = 0;	
	
		?>	

		<script type="text/javascript">
		<!--
			$(document).ready(function(){
				$('.onlynum').css("ime-mode","disabled").keypress(function(event){ 		//숫자만 입력하게.(.도 포함) 
				  if (event.which && (event.which > 45 && event.which < 58 || event.which == 8)) {			
				   } else { 
				   event.preventDefault(); 
				  } 
				 });
					 
				 $('.numfmt').css("ime-mode","disabled").keyup( function(event){   // 숫자 입력 하면 ,로 단위 끊어 표시하게.
						check_value(this);
				 });

				 $("input[name=odr_quantity]").keyup(function(e){
					 maskoff();
					 var stock_qty = parseInt($(this).attr("stock_qty"));
					 if(parseInt($(this).val()) > stock_qty){
						 $(this).val("");
					 }
					 maskon();
				 });
			});
		//-->
		</script>
			<tbody id="adtb_<?=$part_type?>">
			<tr>
				<td colspan="10" class="title-box <?if ($part_type=="1"){?>first<?}?>">
					<h3 class="title"><img src="/kor/images/stock_title0<?=$part_type?>.gif" alt="<?=GF_Common_GetSingleList("PART",$part_type)?>"></h3>					
				</td>
			</tr>

			<?
			if ($cnt > 0){		
			while($row = mysql_fetch_array($result)){
				$part_idx= replace_out($row["part_idx"]);
				$part_type= replace_out($row["part_type"]);
				$part_no= replace_out($row["part_no"]);
				$sell_mem_idx= replace_out($row["mem_idx"]);
				$rel_idx= replace_out($row["rel_idx"]);
				$sell_com_idx = $rel_idx==0?$sell_mem_idx:$rel_idx;
				$nation= replace_out($row["nation"]);
				$manufacturer= replace_out($row["manufacturer"]);
				$package= replace_out($row["package"]);
				$dc= replace_out($row["dc"]);
				$rhtype= replace_out($row["rhtype"]);
				$quantity= replace_out($row["quantity"]);
				$price= replace_out($row["price"]);			
				if ($part_type =="2"){
						$dc = "NEW";
						$quantity="";
				}

				if( ($price == (int)$price) )
				{					

					$price_val = round_down($price,2);
					$price_val = number_format($price,2);
				}
				else {			
					$price_val = $price;
					$price_val = $price;
				}

				//지속적 공급가능 품목외에 모든 품목은 수량 있는 것만 노출 - 2016-04-08
				if($part_type == "2" || ($part_type != "2" && $quantity>0)){
					$i++;
					?>
					<tr>
						<td><?=$i?></td>
						<td class="t-lt"><?=$part_no?></td>
						<td class="t-lt"><?=$manufacturer?></td>
						<td><?=$package?></td>
						<td><?=$dc?></td>
						<td><?=$rhtype?></td>
						<td class="t-rt"><?=$quantity=="" || $quantity==0 ?"-":number_format($quantity)?></td>
						<td class="t-rt">$<?=$price_val?></td>
						<td style="width:60px;">
							<input type="text" class="i-txt2 c-blue onlynum numfmt t-rt" name="odr_quantity"  id="odr_quantity" stock_qty="<?=$quantity;?>" value="" style="width:58px;" maxlength="10">
							<input type="hidden" class="i-txt2 c-blue onlynum t-rt" name="quantity" value="<?=$quantity?>" maxlength="10">
							<input type="hidden" name="part_idx" value="<?=$part_idx?>">
							<input type="hidden" name="part_type" value="<?=$part_type?>">
							<input type="hidden" name="price" value="<?=$price?>">
						</td>
						<td style="width:50px; padding-right:0px;">
							<?if($part_type =="2" || $part_type == "5" || $part_type =="6"){?><span><img src="/kor/images/btn_ok2_1.gif" alt="확인"></span><button type="button"  class="btn-dialog-addperiodreq" style="display:none;"><img src="/kor/images/btn_ok2.gif" alt="확인"></button>
							<?}else{?><span><img src="/kor/images/btn_add_1.gif" alt="추가"></span><button type="button" class="btn-dialog-add" style="display:none;"><img src="/kor/images/btn_add.gif" alt="추가"></button><?}?>
						</td>
						
					</tr>
					<?
					$ListNO--;	
				} //end of 수량 있는 것만..
			} //end of while
	}
}

function GET_SEl_BOX($CheckBoxName, $IsBlank, $BlankString, $CheckValue, $StyleOption, $searchand,$area){		
		$GET_SEl_BOX .="<select ".$StyleOption." name='".$CheckBoxName."' id='".$CheckBoxName."'>\n";
		If($IsBlank=="True"){			
			$GET_SEl_BOX .="<option value='' ".($CheckValue==null?"selected":"").">" .$BlankString ."</option>\n";
		}
		$conn = dbconn();		
		if($CheckBoxName=="opt2"){
		$sql = "SELECT DISTINCT manufacturer
				FROM part where part_type <>'7' $searchand
				ORDER BY manufacturer";
		//		echo $sql;
			$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
			while($row = mysql_fetch_array($result)){
				$manufacturer = replace_out($row["manufacturer"]);			
				If(strcmp($CheckValue,$manufacturer)==0){
					$GET_SEl_BOX .="<option value='".$manufacturer."' selected>".$manufacturer."</option>\n";
				}else{
					$GET_SEl_BOX .="<option value='".$manufacturer."'>".$manufacturer."</option>\n";
				}
			}			
		}else{
			if($area=="on"){
				//dosi 출력
				$Depth = 2;
				$Nname = "dosi";
				$remain = "and dtl_code in (select $Nname from part where 1=1 $searchand)";
			}else{
				$Depth = 1;
				$Nname = "nation";
				$remain = "and dtl_code in (select $Nname from part where 1=1 $searchand)";
			}

			$sql = "select dtl_code, code_desc".($area=="on"?"_en":"")."  as code_desc
		   FROM code_group_detail 
		   where grp_code ='NA' and code_depth ='".$Depth."' $remain";
		 //  echo $sql;
			$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
			
				while($row = mysql_fetch_array($result)){
				$dtl_code = replace_out($row["dtl_code"]);	
				$code_desc = replace_out($row["code_desc"]);	
				If(strcmp($CheckValue,$dtl_code)==0){
					$GET_SEl_BOX .="<option value='".$dtl_code."' selected>".$code_desc."</option>\n";
				}else{
					$GET_SEl_BOX .="<option value='".$dtl_code."'>".$code_desc."</option>\n";
				}
			}
		}
		
		$GET_SEl_BOX .="</select>\n";	
		return $GET_SEl_BOX;
}


?>
