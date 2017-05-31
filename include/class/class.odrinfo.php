<?
	
/*******************************************************************************************************************************************
2016-03-21 : What's New 창에 품목 개별 History 삭제, [발주]창(05_04) 한 품목일 때 옵션 숨김
2016-03-23 : layerInvListData => 31_06(구매자 납기확인완료) '삭제'버튼 삭제
2016-04-12 : 30_08(판매자) 송장화면 옵션(checkbox) 추가, '취소'버튼 추가 - Line:298
2016-05-11 : 반품선적완료(18R_19) 화면에서 'PARTStruke' 버튼 관련부분 삭제
2016-06-02 : 'Memo' 항목에 값이 없을 때 항목자체 미표기 - 모든 화면에 적용
********************************************************************************************************************************************/
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.odr.php";
include $_SERVER["DOCUMENT_ROOT"]."/include/agency_won.php";
//include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.record.php";
$pay = "";
$bottom_30_20 = "";
//***************************************************** GET_ODR_DET_LIST *****************************************************************
function GET_ODR_DET_LIST($loadPage, $part_type, $searchand, $det_cnt = 0, $odr_history_idx=""){   //part_type별 odr list 출력 (05_04 ,30_06, 30_08,30_15등등 layer에서 사용)
	global $file_path;
	$per_cnt = QRY_CNT("odr_det"," and odr_status=16 ".$searchand);
	if ($part_type){
		//$searchand .= " and b.part_type =$part_type "; //2016-03-23
		$searchand .= " and b.part_type =$part_type "; //2016-03-23 삭제 odr_det 은 제외
	}
	if ($loadPage == "30_20")
	{
		$searchand .= " and odr_status <> '6' ";
	}
	$cnt = QRY_CNT("odr_det a left outer join part b on  a.part_idx = b.part_idx ",$searchand);
	
//	echo $searchand;
	/************* QRY_ODR_DET_LIST ***************************
	SELECT * FROM odr_det a
	left outer join part b on a.part_idx = b.part_idx 
	*************************************************************/
	$result =QRY_ODR_DET_LIST(0,$searchand,0,"","asc");
	$i = 0;
	global $session_mem_idx;

	switch ($loadPage) {
	   case "05_04":
		   $colspan= ($per_cnt>0)? "15":"14";
	   case "05_04_v":
			$colspan="14";
	   break;
	   case "30_22":
	   case "31_04":
       case "31_05":
		   $colspan="11";
       case "02_02":
	   case "01_29":
		   $colspan="11";
	   break;
	   case "30_08":
		   $colspan="12";
	   break;
	   case "18R_06":
 	   case "18R_08":	//What's New : 거절
		   $colspan="13";
	   break;
 	   case "19_08":
	   case "18R_16":	//What's New : 반품 방법(구매자)
		   $colspan="13";
	   break;
  	   case "19_06":
		   $colspan="12";
	   break;
   	   case "19_1_06":
	   case "18R_21":  //교환 선적(판매자)
		   $colspan="9";
	   break;
	   case "21_04":
	   case "30_16":  //선적
		   $colspan="12";
	   break;
	   case "30_14":  //결제완료(부대비용)
		   $colspan="12";
	   break;
	   case "30_06":	//What's New : 발주서(판매자)
		   $colspan="10";
	   break;
	   case "09_03":	 
		   $colspan="12";
	   break;	
	   case "18R_19":	//What's New : 반품 선적 완료(판매자)
		   $colspan="11";
	   break;	
	   case "19_1_05":	//환불 완료 메세지창
		   $colspan="11";
	   break;	
	   case "19_1_06":	//What's New : 환불(구매자)
		   $colspan="13";
	   break;	
	   case "04_01":
 	   case "08_02":
	   case "10_02":
	   case "10_04":
	   case "03_02":
	   case "13_02":
	   case "13_02s":
	   case "13_04": 
	   case "13_04s": 
	   case "31_06":
	   case "05_04_1":
	   
		   $colspan="15";
	   break;
	    case "30_10":
	    case "30_15":
		case "01_36":
		case "30_20":		//What's New : 선적완료(구매자)
		   $colspan="14";
	   break;
		case "30_20_F":		//What's New : 선적완료(Fault)
		case "30_22_F":		//What's New : 수령(Fault)
		   $colspan="11";
	   break;
		case "30_21_F":
		   $colspan="11";
	   break;
		case "01_37":	
		case "30_23":
		case "18R_05":
		case "18_1_04":
		case "09_01":
		   $colspan="13";
	   break;	 
		case "po_cancel":
		   $colspan="15";
	   break;	
	   case "1304_accept":
		   $colspan="15";
	   break;
		case "3016_cancel":
		   $colspan = ($det_cnt>1)? "12":"11";
	   break;	
	 }
	
	if ($cnt > 0){	
		while($row = mysql_fetch_array($result)){
			$i++;		
			$odr_det_idx = replace_out($row["odr_det_idx"]);
			$part_idx= replace_out($row["a.part_idx"]);
			$part_no= replace_out($row["part_no"]);
			$part_type= replace_out($row["part_type"]);
			$nation= replace_out($row["nation"]);
			$sell_mem_idx= replace_out($row["mem_idx"]);
			$manufacturer= replace_out($row["manufacturer"]);
			$package= replace_out($row["package"]);
			$dc= replace_out($row["dc"]);
			$rhtype= replace_out($row["rhtype"]);
			$quantity= replace_out($row["quantity"]);
			$period= replace_out($row["period"]);
			$odr_quantity= replace_out($row["odr_quantity"]);
			$supply_quantity= replace_out($row["supply_quantity"]);
			$fault_quantity= replace_out($row["fault_quantity"]);
			$part_condition= replace_out($row["part_condition"]);
			$pack_condition1= replace_out($row["pack_condition1"]);
			$pack_condition2= replace_out($row["pack_condition2"]);			 
			$memo= replace_out($row["memo"]);
			$file1= replace_out($row["file1"]);
			$file2= replace_out($row["file2"]);
			$file3= replace_out($row["file3"]);
			$file= replace_out($row["mem_idx"]);
			$rel_idx= replace_out($row["rel_idx"]);
			$part_price= replace_out($row["price"]); //2016-05-27 : price 를 odr_price 로 변경
			$odr_stock = replace_out($row["odr_stock"]); //2016-06-28 추가
			$price= replace_out($row["odr_price"]);
			$odr_idx = replace_out($row["odr_idx"]);			
			$amend_yn = replace_out($row["amend_yn"]);			
			$ship_idx= replace_out($row["ship_idx"]);
			$odr_status= replace_out($row["odr_status"]);
			$det_reason= replace_out($row["reason"]);
			$part_stock= replace_out($row["part_stock"]);
			$del_chk= replace_out($row["del_chk"]);
			$real_part_idx= replace_out($row["real_part_idx"]);

			if( ($price == (int)$price) )
			{					
				$price_val = round_down($price,2);
				$price_val = number_format($price,2);
			}
			else {			
				$price_val = $price;
				$price_val = $price;
			}

			if ($part_type =="2"){
					$dc = "NEW";
					$quantity="I";
				}

			$invoice_chk = get_any("odr_history","status_name", "odr_idx=$odr_idx  and (status_name='송장' or status_name='수정발주서' or status_name='발주서') order by odr_history_idx desc limit 1");

			if ($i == 1){
			?>
				<tbody id="tbd_<?=$part_type?>">
				<!------------------------------------- 아이템 종류 ------------------------------------------------------------------------>
				<tr>
					<td colspan="<?=$colspan;?>" class="title-box" style="padding-top:1px;">
						<h3 class="title"><img src="/kor/images/stock_title0<?=$part_type?>.gif" alt="<?=GF_Common_GetSingleList("PART",$part_type)?>"></h3>
						<?if ($loadPage=="05_04"){?>
						<!-- 2016-06-02 주석처리
						<div class="txt_stock" style="display: none; float:right; width:136px; padding:0 0 0 0;<?=($per_cnt>0)? " margin-right:54px;":" margin-right:-8px;";?>"><img src="/kor/images/txt_stock_r1.gif" alt="재고수량 이하로 입력"></div>
						-->
						<?}?>
					</td>
				</tr>
			<?}?>

			<?//if ($loadPage=="30_10" || $loadPage=="30_20" || $loadPage == "30_22" || $loadPage == "30_23" || $loadPage=="01_37" || $loadPage=="09_03") { //선적완료 , 도착 : history 안에다 껴넣기.
			  //-----------------------------------아이템 개별 HISTORY 영역 -----------------------------------------------------------------------------------------------------	
			  if (strpos($loadPage,"R")=="" && $loadPage!="19_06"&& $loadPage!="19_1_06"&& $loadPage!="18_1_04" && $loadPage!="31_05" && $loadPage!="30_16" &&$loadPage!="30_08" &&$loadPage!="01_29" && $loadPage!="05_04"&& $loadPage!="09_01") { //선적완료 , 도착 : history 안에다 껴넣기.
				$det_cnt = QRY_CNT("odr_det", "and odr_idx = $odr_idx");
				$det_his_cnt = QRY_CNT("odr_history", "and odr_idx = $odr_idx and odr_det_idx = $odr_det_idx");
				//$det_his_cnt : odr_det_idx가 대부분 null로 들어가는데, "납기","납기확인" ,"수령", "종료" 등과 같이 개별 history가 있는 경우에만 개별 history 끼워넣기를 한다.
				// 근데, 이게 필요 없단다... 2016-03-21
				if($det_cnt > 1 && $det_his_cnt >0){
					?>
					<!--tbody id="tbd_his">
					<tr>
						<td colspan="15" class="step-cell">
							<div class="layer-step" lang="ko">
								<ol>
									<?
											$amend_start =false;
											$result2 = QRY_ODR_HISTORY_LIST(0,"and odr_idx  = $odr_idx and (odr_det_idx = 0 or odr_det_idx is null or odr_det_idx = $odr_det_idx)" , 1 ,"odr_history_idx ");
											//$result2 = QRY_ODR_HISTORY_LIST(0,"and odr_idx  = $odr_idx and (odr_det_idx = $odr_det_idx)" , 1 ,"odr_history_idx ");
											while($row2 = mysql_fetch_array($result2)){											
											$reg_date_fmt2= replace_out($row2["reg_date_fmt"]);
											$status_name2 = replace_out($row2["status_name"]);
											$status2 = replace_out($row2["status"]);
											$reg_mem_idx2 = replace_out($row2["reg_mem_idx"]);
											$odr_det_idx2 = replace_out($row2["odr_det_idx"]);
											$etc12= replace_out($row2["etc1"]);
											$etc22= replace_out($row2["etc2"]);	

											if ($status2 == "3"){	$amend_start =true;}
											if (($amend_yn == "Y" && ($odr_det_idx2 =="" || $odr_det_idx2 =="0")) || ($amend_start ==true && $odr_det_idx2=="")){

												$reg_date_fmt2= "";
												$status_name2 = "";
												$reg_mem_idx2 = "";
												$etc12="";
												$etc22="";
											}
											if ($amend_start==true){$red=" red";}
											$cls2 = "class='$red'";

											if ($session_mem_idx != $reg_mem_idx2){$cls2 = "class='c1$red'";}											
											if ($status2== "9" || $status2== "10" || $status2== "22" || $status2 =="11"|| $status2 =="24"){
												$cls2 = "class='c2$red'";
												if ($session_mem_idx == $reg_mem_idx2){$cls2 = "";}
												$etc22 = ($etc22 == "1")? "-교환":(($etc22 == "2")? "-환불":($etc22==""?"":"-".$etc22));
											}
												if ($status_name2 !=""){?>
												<li <?=$cls2?>>
													<span class="date"><?=$reg_date_fmt2?></span>
													<strong <?if ($status_name2!=""){?>class="status"<?}?>><?=$status_name2?></strong>
													<span class="etc"><span lang="en"><?if ($etc12){?><?=$etc12?><?}?><?if ($etc22){?><?="-".$etc22?><?}?></span></span>
												</li>
											<?
												}
										}?>				
								</ol>
							</div>
							<br>
							</td>
					</tr>
					</tbody-->								
				<?}
			}
			?>

			<tr id="tr_<?=$odr_det_idx?>"><!------------ 내용 첫 번째 tr -------------->
				<?if ($loadPage== "30_06"|| $loadPage== "09_03" || $loadPage== "30_22" || $loadPage== "31_04" || $loadPage== "01_29" ){ //판매자 페이지에서 보여지는 내용(30_06 layer)?>
					<!-- 30_06, 09_03, 30_22, 31_04, 01_09 ---------------------------------------->
					<?if($loadPage== "30_22"){?><input type="hidden" name="odr_det_idx[]" value="<?=$odr_det_idx?>"><?}?>
					<td><?=$i?></td>
					<?if($part_type=="7"){?>
						<td class="t-lt" colspan="7"><?=$part_no?></td>
					<?}else{?>
						<td class="t-lt"><?=$part_no?></td>
						<td class="t-lt"><?=$manufacturer?></td>
						<td><?=$package?></td>
						<td><?=$dc?></td>
						<td><?=$rhtype?></td>
						<td class="t-rt">
							<?if ($loadPage == "30_22"){
								echo $supply_quantity==0?"":number_format($supply_quantity);
							}elseif($loadPage == "09_03" || $loadPage == "30_06"){	//What's New(판매자:수정발주서)
								
								if ($part_type =="2" && $del_chk ==1){									
									$quantity="I";		
									echo $quantity;		
								}
								else
								{

									$poa_cnt = get_any("odr_history","status_name", "odr_idx=$odr_idx  and (status_name='송장' or status_name='수정발주서' or status_name='발주서') order by odr_history_idx desc limit 1");	
									$qty = ($poa_cnt == "송장")? $part_stock+$supply_quantity : $part_stock+$odr_quantity;
								
									if ($del_chk==0)
									{	

										if ($part_type==2)
										{
											$qty=number_format($odr_quantity);
											//echo $qty;
										}
										else
										{

											if ($poa_cnt=="송장")
											{												
												$qty=number_format($supply_quantity);
											}
											else
											{												
												$qty=number_format($odr_quantity);
											}
										}
										
									}
									else
									{
										$qty=number_format($part_stock+$odr_quantity);
									}
									echo $qty;
									
								}
							}elseif($loadPage == "31_04"){	//What's New(판매자:수정발주서)
								if ($part_type =="2"){									
									$quantity="I";				
								}
								else
								{
									$quantity= $quantity==0?"":number_format($quantity);
								}
								if ($del_chk=="0")
								{
									$quantity="0";
								}
								echo $quantity;
							}else{
								if ($part_type =="2"){		
									if ($loadPage== "01_29")
									{
										echo $supply_quantity;
									}	
									else
									{
										echo "I";	
									}						
													
								}
								else
								{
									$odr_stock= $odr_stock==0?"":number_format($odr_stock);
									echo $odr_stock;
								}
								
							}
							?>
						</td>
						<td class="t-rt">$<?=$price_val?></td>
					<?}?>
					<?if ($loadPage == "30_06" || $loadPage== "09_03"|| $loadPage== "01_29" ){?>
						<?if ($loadPage!= "01_29"){?>
							<td class="c-blue t-rt"><?=($part_type=="7")?number_format($price,2):number_format($odr_quantity)?></td>
							<?if ($loadPage == "09_03" || $part_type == 2 || $part_type == 5 || $part_type == 6){?>
							<td class="c-red t-rt"><?=number_format($supply_quantity)?></td>
							<?}else{?>
							<?
							$part_chk = QRY_CNT("odr_det"," and odr_idx=$odr_idx and (part_type=2 or part_type=5 or part_type=6) ");  //지속적, 해외, 국내
							if (($part_chk >=1 && $loadPage != "31_04" && $loadPage != "02_02")){
							?>
								<td class="c-red t-rt"></td>
							<?
								}
							}?>
						<?}else{?>
							<?
								$price_sum = $price*$supply_quantity;
								$price_sum = round_down($price_sum,4);
							?>
							<td class="t-rt">$<?=number_format($price_sum,4)?></td>
						<?}?>
					<?
						if($part_type =="2")
						{
							$day_val = "WK";
						}
					?>
					<td class=""><?=($period)?""."<span class='c-red'>".str_replace("WK","",$period).$day_val."</span>":(($part_type=="2"||$part_type=="5"||$part_type=="6")?"<span lang='ko' class='c-red'>확인</span>":"Stock")?></td>					
					<?}elseif ($loadPage == "31_04"){?>
					<td class="c-blue t-rt"><?=number_format($odr_quantity)?></td>
					<td class="t-rt"<?=($period)? "":"style=\"padding-right:0px;\"";?>>
					<?if ($period){
						echo QRY_CNT("odr_history", "and  odr_idx = $odr_idx and status = 19 ")>0?"Stock":$period;
					}else{ 
							if ($part_type=="2"||$part_type=="5"||$part_type=="6"){?>
								<a href="#" class="btn-dialog-3105" part_type="<?=$part_type?>" odr_det_idx="<?=$odr_det_idx?>"><img src="/kor/images/btn_ok.gif" alt="확인"></a>
							<?}else{
								echo "Stock";
							}
					}?>
					</td>					
					<?}else{?>					
					<td class="c-blue t-rt">$<?=number_format(round_down($supply_quantity*$price,4),4)?></td>
					<?}?>
					</tr>
					
					<tr class="bg-none">
						<td></td>
						<td colspan="13" style="padding:0">
							<!-- 부품상태 ---------------->
							<table class="detail-table" >
								<tbody>
									<?if ($part_condition){?>
									<tr class="noinput">
										<td class="c-red" colspan="10" style="text-align:left;">	
											부품상태 : 
											<span class="c-blue"><?=GF_Common_GetSingleList("PARTCOND",$part_condition)?></span>&nbsp&nbsp
											포장상태 : 
											<span class="c-blue"><?=GF_Common_GetSingleList("PACKCOND1",$pack_condition1)?> / <?=GF_Common_GetSingleList("PACKCOND2",$pack_condition2)?> </span>
										</td>
									</tr>
									<?}?>
									<?if(strlen($memo) > 0){?>
									<tr class="noinput">
										<td colspan="4" ><strong class="c-black" >Memo : </strong><?=$memo?> </td>
									</tr>
									<?}?>									
								</tbody>
							</table>
							<!-- //부품상태 ---------------->
						</td>
					</tr>
					
				<?}elseif ($loadPage== "30_20_F" || $loadPage== "30_21_F"  || $loadPage== "30_22_F"){ //--------------------------- 선적(Fault), 수령(fault)-POP -----------------------------------------------------------
						$com_idx = $rel_idx==0 ? $sell_mem_idx : $rel_idx;
						$company_nm = get_any("member","mem_nm_en", "mem_idx=$com_idx");
						//history 정보가 필요하다.. D/C,사진 등등
						//$odr_history_idx = get_any("odr_history" , "odr_history_idx" , "odr_idx = $odr_idx AND odr_det_idx = $odr_det_idx AND status = 21 AND fault_yn='Y' ");
						//$odr_his = get_odr_history($odr_history_idx);
				?>
					<td><?=$i?><input type="hidden" name="odr_det_idx[]" value="<?=$odr_det_idx?>"></td>
					<td><img src="/kor/images/nation_title2_<?=$nation?>.png" alt="<?=GF_Common_GetSingleList("NA",$nation)?>"></td>
					<td class="t-lt"><?=$part_no?></td>
					<td class="t-lt"><?=$manufacturer?></td>
					<td><?=$package?></td>
					<td><?=$dc?></td>
					<td><?=$rhtype?></td>
					
					<?if ($loadPage== "30_20_F" ){?>
						<td class="c-red2 t-rt"><?=number_format($odr_quantity);?></td>
						<td class="t-rt">$<?=$price_val?></td>
					<?}else{?>
						<td class="t-rt">$<?=$price_val?></td>
						<td class="c-red2 t-rt"><?=number_format($fault_quantity);?></td>

					<?}?>
					
					<?
						$price_sum = $price*$fault_quantity;
						$price_sum = round_down($price_sum,4);
					?>
					<td class="t-rt">$<?=number_format($price_sum,4)?></td>
					<td>
					<?if ($period){
						echo QRY_CNT("odr_history", "and  odr_idx = $odr_idx and status = 19 ")>0?"Stock":$period;
					}else{ 
							if ($part_type=="2"||$part_type=="5"||$part_type=="6"){?>
								<a href="#" class="btn-dialog-3105" part_type="<?=$part_type?>" odr_det_idx="<?=$odr_det_idx?>"><img src="/kor/images/btn_ok.gif" alt="확인"></a>
							<?}else{
								echo "Stock";
							}
					}?>
					</td>
					<td class="c-blue"><a href="javascript:layer_company_det(<?=$com_idx?>);"><?=cut_len($company_nm,8,".");?></a></td>
					<?if($loadPage == "30_20_F" || $loadPage == "30_22_F"){?>
					<!-- 복사해온거 시작-->
					</tr>
					<tr class="bg-none">
						<td></td>
						<td colspan="13">
							<!-- 부품상태 ---------------->
							<table class="detail-table">
								<tbody>
									<tr class="noinput">
										<th scope="row" style="width:70px">부품상태  : </th>
										<td><span ><?=GF_Common_GetSingleList("PARTCOND",$part_condition)?></span></td>
										<th scope="row" style="width:70px">포장상태 : </th>
										<td><span ><?=GF_Common_GetSingleList("PACKCOND1",$pack_condition1)?> <?=GF_Common_GetSingleList("PACKCOND2",$pack_condition2)?> </span></td>
									</tr>
									<?if(strlen($memo) > 0){?>
									<tr class="noinput">
										<td colspan="4" ><strong class="c-black" >Memo : </strong><?=$memo?> </td>
									</tr>
									<?}?>
									<?if ($row['file1']){?>
									<tr>
										<td colspan="4"  class="img-cntrl-list">
											<strong class="c-red">라벨/부품사진 </strong>
											<?
											for ($j = 1;$j <= 3; $j++ ){
												$file = $row['file'.$i];	
												if ($file){										
												?>
												<div class="img-cntrl-wrap">
												<span class="img-wrap"><a href="<?=get_noimg($file_path,$file,"#")?>" <?if ($file){?>target="_blank"<?}?>><img <?=get_noimg_photo($file_path, $file, "/kor/images/file_pt.gif")?> alt="" style="border: 1px solid #00759e;"></a></span>											
												</div>
												<?}?>
											<?}?>
										</td>
									</tr>
									<?}?>
								</tbody>
							</table>
							<!-- //부품상태 ---------------->
						</td>
					</tr>
					<?
					$ship_idx = get_any("ship", "ship_idx", "odr_idx=$odr_idx and ship_type=5" );
					
					$ship = get_ship($ship_idx);
					$row_ship = get_ship($ship_idx);

					?>

					<tr class="bg-none">
						<td></td>
						<td colspan="12" style="padding:0;padding-top:20px;">
							<table class="detail-table">
								<tbody>									
									<?if(strlen($row_ship["memo"])>0){?>
									<tr>
										<td colspan="2" ><strong class="c-black" >Memo : </strong><span class="c-blue"><?=$row_ship["memo"]?></span></td>
									</tr>
									<?}?>
									<?if($row_ship["insur_yn"]=="o"){?>
									<tr>
										<th colspan="2" scope="row">
											<span class="c-black">운송보험 :</span> <span lang="en">Yes</span>
										</th>
									</tr>
									<?}?>
									<?
									
									?>
									<?if($ship[delivery_addr_idx] > 0){?>

									<tr>
										<td scope="row" colspan="2" bgcolor="#FFFFCC" style="text-align:left;color:#000000;">배송지 변경</td>								
									</tr>
									<tr>								
										<td lang="ko" colspan="2" bgcolor="#FFFFCC" style="text-align:left;">
											<?=GET_ODR_DELIVERY_ADDR($ship[delivery_addr_idx]);?>
											<!--
											<table class="table-type1-1" lang="ko">
												<tr>
													<td class="t-lt"><img src="/kor/images/nation_title_<?=$addr_row[nation];?>.png" alt="<?=GF_Common_GetSingleList("NA",$addr_row[nation])?>"></td>
												</tr>
												<tr>
													<td class="t-lt">회사명 : <?=$addr_row[com_name];?></td>
												</tr>
												<tr>l
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
									</tr>
									<?}?>	
								</tbody>
							</table>
						</td>
					</tr>

					
					<!-- 복사해온거 끝-->
					<?}?>
				<?}elseif ($loadPage== "31_05"){ //------------------------------------------------------------------------------------------------------?>
					<?
					$part_inv_chk =QRY_CNT("part", "and invreg_chk <> 1 and part_idx='$real_part_idx'"); 		
					// $part_inv_chk==0 시작
					if($part_inv_chk =='0')
					{
						$no_modify = "readonly";
						$no_modify_border = "border:0;";
					}

					$change_part_idx = $_GET['change_part_idx'];
					$change_style_price = "";
					$change_style_qty = "";
										
					?>
					<td><?=$i?><input type="hidden" name="odr_det_idx[]" value="<?=$odr_det_idx?>"></td>
					<td class="t-lt"><input type="text" class="i-txt4" id="part_no"  value="<?=$part_no?>" maxlength="24" style="<?=$no_modify_border?>ime-mode:disabled; width:100%" <?=$no_modify?>></td>
					<td class="t-lt"><input type="text" class="i-txt4" id="manufacturer" value="<?=$manufacturer?>" maxlength="20" style="<?=$no_modify_border?>width:100%" <?=$no_modify?>></td>
					<td><input type="text" class="i-txt4 t-ct" id="package" value="<?=$package?>" maxlength="10" style="<?=$no_modify_border?>width:83px" <?=$no_modify?>></td>
					<?if ($part_type==2){?>
						<td>
							<?=$dc?>
							<input type="hidden"  id="dc" name="dc" value="<?=$dc?>" />		
						</td>
					<?}else{?>
						<td><input type="text" class="i-txt4 t-ct" id="dc" value="<?=$dc?>" style="<?=$no_modify_border?>width:38px" maxlength="4" <?=$no_modify?>></td>
					<?}?>					
					<?if ($no_modify !="readonly"){?>
					<td>
						<div class="select type6" lang="en" style="width:60px; padding:0;" >
							<label style="padding:0;padding-left:2px;padding-top:2px;"><?=$rhtype==""?"":$rhtype?></label>
							<select name="rhtype[]">
								<option lang="en" <?if($rhtype=="None"){echo "selected";}?>>None</option>
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
					<td class="t-ct">
						<?=$rhtype?>
						<input type="hidden" name="rhtype[]" value="<?=$rhtype?>" />
					</td>
					<?}?>
					<?

					if ($part_type =="2"){
						$dc = "NEW";
						$quantity="I";
					}
					else
					{
						$quantity= $quantity==0?"0":number_format($quantity);

					}
					if ($del_chk=="0")
					{
						$quantity="0";
					}

					if ($_GET['change'] == "price" && $change_part_idx == $real_part_idx)
					{
						$change_style_price="style='border-bottom:1px solid red'";
					}
					else if ($_GET['change'] == "qty" && $change_part_idx == $real_part_idx)
					{
						$change_style_qty="style='border-bottom:1px solid red'";
					}
					else if ($_GET['change'] == "delete" && $change_part_idx == $real_part_idx)
					{
						$change_style_qty="style='border-bottom:1px solid red'";
						$quantity="0";
					}

					?>
					<td class="t-rt"><span <?=$change_style_qty?>><?=$quantity?></span><input type="hidden" name="qty" id="31_05_qty" value="<?=$quantity;?>"></td>
					<td class="t-rt">$<?=$price_val?></td>
					<td class="c-blue t-rt"><?=number_format($odr_quantity)?></td>
					<td>
						<input type="text" id = "supply_quantity" name="supply_quantity" class="i-txt4 c-red2 onlynum numfmt t-rt" maxlength="10" value="" style="width:58px">
						<input type="hidden" class="i-txt2 c-blue onlynum t-rt" name="quantity" value="<?=$quantity?>" maxlength="10">
						<input type="hidden" name="part_idx" value="<?=$real_part_idx?>">
						<input type="hidden" name="price" value="<?=$price?>">
					</td>
					<td><input type="text" class="i-txt4 c-red2 t-ct" id = "period" name="period" value="" style="width:38px" maxlength="4" readonly> <span class="c-red2"><?if ($part_type=="2"){echo "WK";}else{echo "Days";}?></span></td>
					<?
				}elseif ($loadPage== "09_01"){  //-------------------------------------- 09_01 : 수정 발주서 2016-04-14------------------------------------?>
					<?if($det_cnt>1){?>
					<td>
						<label class="ipt-chk chk2" style="padding-right: 0;">
							<input type="checkbox" name="odr_det_idx[]" odr_det_idx2 ="<?=$odr_det_idx?>" odr_status="<?=$odr_status;?>" quantity="<?=$quantity;?>" amend_yn="<?=$amend_yn?>" class="<?=($part_type=="2" && $period*1> 2 && QRY_CNT("odr_history", "and  odr_idx = $odr_idx and status = 19 ")<=0) ? "endure":"stock"?>" value="<?=$odr_det_idx?>" part_type="<?=$part_type?>"><span></span>
						</label>
					</td>
					<?}else{?>
							<input type="checkbox" style="margin-right: 0" name="odr_det_idx[]" odr_status="<?=$odr_status;?>" quantity="<?=$quantity;?>" amend_yn="<?=$amend_yn?>" class="<?=($part_type=="2" && $period*1> 2 && QRY_CNT("odr_history", "and  odr_idx = $odr_idx and status = 19 ")<=0) ? "endure":"stock"?>" value="<?=$odr_det_idx?>" part_type="<?=$part_type?>">
					<?}?>
					<td><?=$i?></td>
					<td><img src="/kor/images/nation_title2_<?=$nation?>.png" alt="<?=GF_Common_GetSingleList("NA",$nation)?>"></td>
					<?if ($part_type=="7"){?>
						<td colspan="6"><input type="text" class="i-txt4" value="<?=$part_no?>" style="width:560px; ime-mode:disabled" readonly></td>					
					<?}else{?>
					<td class="t-lt"><?=get_cut($part_no,20,".")?></td>
					<td class="t-lt"><?=get_cut($manufacturer,12,".")?></td>
					<td><?=get_cut($package,10,".")?></td>
					<td><?=$dc?></td>
					<td><?=$rhtype?></td>					
					<?}?>

					<?
					$poa_cnt = get_any("odr_history","status_name", "odr_idx=$odr_idx  and (status_name='송장' or status_name='수정발주서' or status_name='발주서') order by odr_history_idx desc limit 1");	
					$qty = ($poa_cnt == "송장")? $part_stock+$supply_quantity : $part_stock+$odr_quantity;
				
					if ($del_chk==0)
					{	
						$quantity = 0;
						if ($part_type==2)
						{
							$qty=number_format($odr_quantity);
						}
						else
						{
							if ($poa_cnt=="송장")
							{
								$qty=number_format($supply_quantity);
							}
							else
							{
								$qty=number_format($odr_quantity);
							}
						}
					}

					?>
					<?if($part_type=="2"){?>
						<?if ($del_chk=="0"){?>									
							<td class="t-rt" style="width:60px;"><?=number_format($supply_quantity)?></td>
						<?}else{?>
							<td class="t-rt" style="width:60px;">I</td>
						<?}?>
					<?}else{?>
						<td class="t-rt"><?=$qty?></td>
					<?}?>					
					<td class="t-rt">$<?=$price==0?"":$price_val?></td>
					<td>
						<?
						if ($amend_yn=="Y")
						{
							$odr_amend_qty = number_format($odr_quantity);
						}
						?>
						<input type="text" class="i-txt2 c-blue onlynum numfmt t-rt" maxlength="10" name="odr_quantity[]" odr_det_idx="<?=$odr_det_idx?>" supply_quantity="<?=$supply_quantity;?>" quantity="<?=$quantity + $supply_quantity;?>" amd_yn="Y" value="<?=$odr_amend_qty?>" part_type="<?=$part_type?>" style="width:56px;">
					</td>
					<td class="c-red t-rt"><?=$supply_quantity==0?"":number_format($supply_quantity)?></td>
					<?
					if ($part_type==2)
					{
						$day_val = "WK";
					}
					?>
					<?=($period)?"<td class=''>".(QRY_CNT("odr_history", "and  odr_idx = $odr_idx and status = 19 ")>0?"Stock":"<span class='c-red'>".str_replace("WK","",$period).$day_val."</span>"):(($part_type=="2"||$part_type=="5"||$part_type=="6")?"<td class='c-red'><span lang='ko'>확인</span>":"<td>Stock")?></td>
					<?
					$com_idx = ($rel_idx)? $rel_idx : $sell_mem_idx;
					$company_nm = get_any("member","mem_nm_en", "mem_idx=$com_idx"); 	
					?>
					<td class="c-blue"><a href="javascript:layer_company_det('<?=$com_idx?>');" style="color:#00759e;"><?=cut_len($company_nm,8,".")?></a></td>
					<!-- 복사해온거 시작-->
					</tr>
					<?if ($amend_yn=="N"){?>
					<tr class="bg-none">
						<td>

						</td>
						<?=($det_cnt>1)? "<td></td>":""?>
						<td colspan="12" style="padding:0;">
							<!-- 부품상태 ---------------->
							<table class="detail-table" style="margin:0">
								<tbody>
									<?if ($loadPage != "05_04_1" && $loadPage != "08_02" && $loadPage !="10_02" && $loadPage!="10_04" && $loadPage != "13_04" && $loadPage != "13_04s" && $loadPage != "03_02"){?>
										<?if ($loadPage=="09_01"){?>
											<?if ($part_condition){?>
												<tr class="noinput">
													<td class="c-red" colspan="10" style="text-align:left;">	
														부품상태 : 
														<span class="c-blue"><?=GF_Common_GetSingleList("PARTCOND",$part_condition)?></span>&nbsp&nbsp
														포장상태 : 
														<span class="c-blue"><?=GF_Common_GetSingleList("PACKCOND1",$pack_condition1)?> / <?=GF_Common_GetSingleList("PACKCOND2",$pack_condition2)?> </span>
													</td>
													<!--<th scope="row" style="width:170px">&nbsp;부품상태&nbsp;:&nbsp;&nbsp;<span class="c-blue"><?=GF_Common_GetSingleList("PARTCOND",$part_condition)?></span></th>
													<th scope="row" style="width:193px">포장상태&nbsp;:&nbsp;&nbsp;<span class="c-blue"><?=GF_Common_GetSingleList("PACKCOND1",$pack_condition1)?> / <?=GF_Common_GetSingleList("PACKCOND2",$pack_condition2)?> </span></th>-->
												</tr>
											<?}?>
										<?}else{?>
											<tr class="noinput">
												<td class="c-red" colspan="10" style="text-align:left;">	
													부품상태 : 
													<span class="c-blue"><?=GF_Common_GetSingleList("PARTCOND",$part_condition)?></span>&nbsp&nbsp
													포장상태 : 
													<span class="c-blue"><?=GF_Common_GetSingleList("PACKCOND1",$pack_condition1)?> / <?=GF_Common_GetSingleList("PACKCOND2",$pack_condition2)?> </span>
												</td>
												<!--<th scope="row" style="width:170px">&nbsp;부품상태&nbsp;:&nbsp;&nbsp;<span class="c-blue"><?=GF_Common_GetSingleList("PARTCOND",$part_condition)?></span></th>
												<th scope="row" style="width:193px">포장상태&nbsp;:&nbsp;&nbsp;<span class="c-blue"><?=GF_Common_GetSingleList("PACKCOND1",$pack_condition1)?> / <?=GF_Common_GetSingleList("PACKCOND2",$pack_condition2)?> </span></th>-->
											</tr>
										<?}?>
									<?}?>
									<?if ($loadPage != "03_02" && $loadPage!="05_04_1" && $loadPage!="13_04s" && strlen($memo)>0){?>
									<tr class="noinput">
										<td colspan="4" ><strong class="c-black" >Memo : </strong><?=$memo?> </td>
									</tr>
									<?}?>
								</tbody>
							</table>
							<!-- //부품상태 ---------------->
						</td>
					</tr>
					<?}?>
					<!-- 복사해온거 끝-->

					<?//-----------------------------------------------------------------------------------------------------------------------------------------------
					}elseif ($loadPage== "05_04" || $loadPage=="04_01"){  //구매자 페이지에서 보여지는 내용 (05_04, 09_01:기존에 여기 있었으나 위에 별도로 뺌 )?>
					<?
					$change_part_idx = $_GET['change_part_idx'];
					$change_style_price = "";
					$change_style_qty = "";

					if ($_GET['change'] == "price" && $change_part_idx == $real_part_idx)
					{
						$change_style_price="style='border-bottom:1px solid red'";
					}
					else if ($_GET['change'] == "qty" && $change_part_idx == $real_part_idx)
					{
						$change_style_qty="style='border-bottom:1px solid red'";
						$odr_quantity="";
					}
					else if ($_GET['change'] == "delete" && $change_part_idx == $real_part_idx)
					{
						$change_style_qty="style='border-bottom:1px solid red'";
						$quantity="0";
						$odr_quantity="";
					}
					?>
					<!--05_04-->
					<?if($loadPage== "05_04" && $det_cnt==1){?>
								<input type="hidden" name="odr_det_idx[]" odr_status="<?=$odr_status;?>" part_type="<?=$part_type?>" quantity="<?=$quantity;?>" amend_yn="<?=$amend_yn?>" class="<?=($part_type=="2" && $period*1> 2 && QRY_CNT("odr_history", "and  odr_idx = $odr_idx and status = 19 ")<=0) ? "endure":"stock"?>" value="<?=$odr_det_idx?>" <?if(($part_type=="2"||$part_type=="5"||$part_type=="6") && $period ==""){?>disabled<?}?> part_type="<?=$part_type?>"><span style="margin-right:0"></span>
							</label>
					<?}else{?>
						<td>
							<label class="ipt-chk chk2" >
								<input type="<?=($det_cnt>1)? "checkbox":"hidden";?>" style="margin-right:0" name="odr_det_idx[]" part_type="<?=$part_type?>" odr_status="<?=$odr_status;?>" quantity="<?=$quantity;?>" amend_yn="<?=$amend_yn?>" class="<?=($part_type=="2" && $period*1> 2 && QRY_CNT("odr_history", "and  odr_idx = $odr_idx and status = 19 ")<=0) ? "endure":"stock"?>" value="<?=$odr_det_idx?>" <?if( ($part_type=="2"||$part_type=="5"||$part_type=="6") && $period ==""){?>disabled<?}?> part_type="<?=$part_type?>"><span  style="margin-right:0"></span>
							</label>
						</td>
					<?}?>
					<td><?=$i?></td>
					<td><img src="/kor/images/nation_title2_<?=$nation?>.png" alt="<?=GF_Common_GetSingleList("NA",$nation)?>"></td>
					<?if ($part_type=="7"){	//턴키-------------?>
						<td colspan="7" class="t-lt">
							<?=$part_no;?>
							<!--input type="text" class="i-txt4" value="<?=$part_no?>" style="width:560px; ime-mode:disabled" readonly-->
						</td>
					<?}else{?>
					<?
						//$price = ($loadPage=="05_04")? $part_price:$price;  //2016-12-28 KSR
						if(strpos($price, ".") == false || strpos($part_price, ".") == false)  
						{
							$price_val= round_down($price,2);
							$price_val= number_format($price,2);
						}
						else
						{
							$price_val= $price;
						}
					?>
					<td class="t-lt"><?=($per_cnt>0)? cut_len($part_no,22,"."):$part_no?></td>
					<td class="t-lt"><?=($per_cnt>0)? cut_len($manufacturer,16,"."):$manufacturer?></td>
					<td><?=cut_len($package,10,".")?></td>
					<td><?=$dc?></td>
					<td><?=$rhtype?></td>
					<?					
					if ($del_chk=="0")
					{
						$quantity="0";
					}
					else
					{
						if ($part_type =="2"){
							$quantity="I";				
						}
						else
						{
							$quantity= $quantity==I?"I":number_format($quantity);
						}
					}
					
					?>
					<td class="t-rt"><input name="quantity[]" type="hidden" value="<?=$quantity;?>"> <span <?=$change_style_qty?>><?=$quantity?></span></td>
						<?if ($loadPage== "05_04"){?>
							<td class="t-rt"><span <?=$change_style_price?>>$<?=$price_val?></span></td>
						<?}else{?>
							<td class="t-rt">$<?=$price_val?></td>
						<?}?>
					<?}?>
					<td class="t-rt">
						<?if (($part_type=="2"||$part_type=="5"||$part_type=="6") && $period ==""){?>
						<input type="text" class="i-txt0 c-blue onlynum numfmt t-rt"  maxlength="10" onkeyup="this.value=this.value.replace(/[^(0-9)]/g,'')" name="odr_quantity[]" odr_det_idx="<?=$odr_det_idx?>" value="<?=$odr_quantity==0?"":number_format($odr_quantity)?>" style="width:58px;ime-mode:disabled;" readonly>
						<?}else if($part_type=="7"){?>
							$<?=$price==0?"":$price_val?>
							<input type="hidden" name="odr_quantity[]" value="1">
						<?}else{?>
							<?if ($loadPage== "05_04"){?>
								<?if ($part_type=="2"||$part_type=="5"||$part_type=="6"){?>
									<?if ($supply_quantity==$odr_quantity){?>
										<?if ($quantity=="0"){?>										
											<input type="text" class="i-txt2 c-blue onlynum numfmt t-rt" maxlength="10" onkeyup="this.value=this.value.replace(/[^(0-9)]/g,'')" name="odr_quantity[]" part_type="<?=$part_type?>" odr_det_idx="<?=$odr_det_idx?>" supp_qty="<?=$supply_quantity?>"  value="" style="width:58px;ime-mode:disabled;">		
										<?}else{?>
											<input type="text" class="i-txt2 c-blue onlynum numfmt t-rt" maxlength="10" onkeyup="this.value=this.value.replace(/[^(0-9)]/g,'')" name="odr_quantity[]" part_type="<?=$part_type?>" odr_det_idx="<?=$odr_det_idx?>" supp_qty="<?=$supply_quantity?>"  value="<?=$odr_quantity==0?"":number_format($odr_quantity)?>" style="width:58px;ime-mode:disabled;">
										<?}?>							
									<?}else{?>
										<?if ($supply_quantity>$quantity){?>
										<input type="text" class="i-txt2 c-blue onlynum numfmt t-rt" maxlength="10" onkeyup="this.value=this.value.replace(/[^(0-9)]/g,'')" name="odr_quantity[]" part_type="<?=$part_type?>" odr_det_idx="<?=$odr_det_idx?>" supp_qty="<?=$quantity?>"  value="" style="width:58px;ime-mode:disabled;">
										<?}else{?>
										<input type="text" class="i-txt2 c-blue onlynum numfmt t-rt" maxlength="10" onkeyup="this.value=this.value.replace(/[^(0-9)]/g,'')" name="odr_quantity[]" part_type="<?=$part_type?>" odr_det_idx="<?=$odr_det_idx?>" supp_qty="<?=$odr_quantity?>"  value="" style="width:58px;ime-mode:disabled;">
										<?}?>
									<?}?>
								<?}else{?>
								<input type="text" class="i-txt2 c-blue onlynum numfmt t-rt" maxlength="10" onkeyup="this.value=this.value.replace(/[^(0-9)]/g,'')" name="odr_quantity[]" part_type="<?=$part_type?>" odr_det_idx="<?=$odr_det_idx?>" supp_qty="<?=$supply_quantity?>"  value="<?=$odr_quantity==0?"":number_format($odr_quantity)?>" style="width:58px;ime-mode:disabled;">
								<?}?>
							<?}else{?>
								<input type="text" class="i-txt2 c-blue onlynum numfmt t-rt" maxlength="10" onkeyup="this.value=this.value.replace(/[^(0-9)]/g,'')" name="odr_quantity[]" part_type="<?=$part_type?>" odr_det_idx="<?=$odr_det_idx?>" supp_qty="<?=$supply_quantity?>"  value="" style="width:58px;ime-mode:disabled;">
							<?}?>
							
						<?}?>
					</td>
					<?if($loadPage== "05_04" && $per_cnt>0){ //-- 공급수량?>
					<td class="t-rt c-red"><?=$supply_quantity==0?"":number_format($supply_quantity)?></td>
					<?}?>
					<?if ($loadPage =="04_01"){?><td class="c-red"></td><?}?>
					<?
					if ($part_type==2)
					{
						$day_val = "WK";
					}
					?>
					<?=($period)?"<td class=''>".(QRY_CNT("odr_history", "and  odr_idx = $odr_idx and status = 19 ")>0?"Stock":"<span class='c-red'>".str_replace("WK","",$period).$day_val."</span>"):(($part_type=="2"||$part_type=="5"||$part_type=="6")?"<td class='c-red'><span lang='ko'>확인</span>":"<td>Stock")?></td>
					<?if ($loadPage=="09_01") {
					$com_idx = $rel_idx==0 ? $sell_mem_idx : $rel_idx;
					$company_nm = get_any("member","mem_nm_en", "mem_idx=$com_idx"); 	
					?>
					<td><a href="javascript:layer_company_det('<?=$com_idx?>');"><?=cut_len($company_nm,8,".")?></a>
					</td>
					<?}?>

					<?if ($loadPage =="05_04" || $loadPage =="09_01"){//-- odr_det 개별 삭제 버튼, 09_01:수정발주서?>
					<!--td class="c-red pd-0">
						<?$del_possible_yn = (($part_type=="2"||$part_type=="5"||$part_type=="6") && $period !="" ) || ($part_type !="2" && $part_type != "5" && $part_type != "6") ? "Y":"N";
						if ($del_possible_yn =="Y" && $loadPage=="09_01" && $amend_yn=="N"){
								$del_possible_yn="N";
						}
						?>						

						<span id="del_1_<?=$odr_det_idx?>" style="display:<?if($del_possible_yn=="Y"){?>none<?}?>;"><img src="/kor/images/btn_delete2_1.gif" alt="삭제"></span>
						<span id="del_<?=$odr_det_idx?>" style="display:<?if($del_possible_yn=="N"){?>none<?}?>;"><button type="button" onclick="del('odr_det',<?=$odr_det_idx?>)"><img src="/kor/images/btn_delete2.gif" alt="삭제"></button></span>
					
					</td-->
					<?}//------------- // 05_04, 09_01, 04_01 ------------------------------------?>
					
				<? //-------------- 송장(30_08) : 판매자 페이지에서 보여지는 송장 목록 -------------------------------
					}elseif  ($loadPage== "30_08"){
						//2016-05-27 : 재고 수량에서 현 거래의 주문 수량을 더해 재고로 잡는다.(PO 당시 재고에서 빠졌으므로...)
						if($part_type!="2"){
							$origin_qty = $quantity + $odr_quantity;	//2016-12-11 : 파츠대표님 요구대로 되어 있슴(실재고+발주수량)							
						}
					?>
					<?if($part_type=="2"){?>
					<input type="hidden" name="part_type[]" value="2">
					<?}?>
					<?if($det_cnt>1){?>
						<td>
							<label class="ipt-chk chk2">
								<input type="checkbox" name="odr_det_idx[]" class="stock" odr_quantity="<?=$odr_quantity;?>" part_type="<?=$part_type;?>" value="<?=$odr_det_idx?>"><span></span>
							</label>
						</td>
					<?}else{?>
								<input type="hidden" name="odr_det_idx[]" class="stock" odr_quantity="<?=$odr_quantity;?>" part_type="<?=$part_type;?>" value="<?=$odr_det_idx?>">
					<?}?>
					<td><?=$i?></td>
					<?if ($part_type=="7"){ //턴키--?>
						<td colspan="6"><input type="text" name="part_no[]" class="i-txt4" value="<?=$part_no?>" maxlength="30" style="width:584px; ime-mode:disabled" ></td>
					
					<?}else{?>
					<?					
						$part_inv_chk =QRY_CNT("part", "and invreg_chk <> 1 and part_idx='$real_part_idx'");
						// $part_inv_chk==0 시작
						if($part_inv_chk =='0')
						{
							$no_modify = "readonly";
							$no_modify_border = "border:0;";
						}
					?>
					<td class="t-lt"><input type="text" class="i-txt4" name="part_no[]" value="<?=$part_no?>" maxlength="24" <?=$no_modify?> style="<?=$no_modify_border?>width:<?=($det_cnt>1)? "190":"210";?>px; ime-mode:disabled" ></td>
					<td class="t-lt"><input type="text" class="i-txt4" name="manufacturer[]" value="<?=$manufacturer?>" maxlength="20" <?=$no_modify?> style="<?=$no_modify_border?>width:<?=($det_cnt>1)? "156":"170";?>px; ime-mode:disabled" ></td>
					<td><input type="text" class="i-txt4 t-ct" name="package[]" value="<?=$package?>" maxlength="10" <?=$no_modify?> style="<?=$no_modify_border?>width:80px; ime-mode:disabled" ></td>
					<td>
						<input type="text" name="rosh[]" maxlength="4" class="i-txt4 t-ct" <?=$no_modify?> style="<?=$no_modify_border?>width:36px; ime-mode:disabled" value="<?=$dc;?>">
					</td>
					<?if ($no_modify !="readonly"){?>
					<td>
						<div class="select type6 t-ct" lang="en" style="width:60px; padding:0;" >
							<label style="padding:0;padding-left:2px;padding-top:2px;"><?=$rhtype==""?"":$rhtype?></label>
							<select name="rhtype[]">
								<option lang="en" <?if($rhtype=="None"){echo "selected";}?>>None</option>
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
					<td class="t-ct">
						<?=$rhtype?>
						<input type="hidden" name="rhtype[]" value="<?=$rhtype?>" />
					</td>
					<?
					}
					?>
					<td class="t-rt" style="width:60px;">
						<?
							if ($part_type =="2" && $del_chk ==1){									
								$quantity="I";		
								echo $quantity;	
								$del_qty = "I";	
							}
							else
							{
								echo number_format($part_stock + $odr_quantity);
								$del_qty = $part_stock + $odr_quantity;
							}
						?>
					</td>											
					
					<?}	 //end of 턴키($part_type=="7")
					//금액이 정수면 ,2 실수면 ,4 포멧 20161202 박정권
					
					?>
					<td class="t-rt" style="width:61px;">$<?=$price_val?></td>
					<!--발주수량-->
					<td class="t-rt" style="width:66px;"><span class="c-blue"><?=$odr_quantity==0?"":number_format($odr_quantity)?></span></td>
					<!--공급수량-->
					<td class="t-rt">
						<input type="text" name="supply_quantity[]" class="i-txt4 c-red2 onlynum numfmt t-rt" value="" maxlength="10" style="width:70px" origin_qty="<?=$origin_qty;?>" del_qty="<?=$del_qty?>" part_type="<?=$part_type;?>">
					</td>
					<?
						if($part_type =="2")
						{
							$day_val = "WK";
						}
					?>
					<?=($period)?"<td class=''>"."<span class='c-red'>".str_replace("WK","",$period).$day_val."</span>":(($part_type=="2"||$part_type=="5"||$part_type=="6")?"<td class='c-red'><span lang='ko'>확인</span>":"<td>Stock")?></td>
					<??>
					</tr>
					<tr>
						<td></td>
						<td colspan="11" style="padding:0">
							<table class="detail-table">
								<tbody>
									<?
									if($part_type=="2"){
										$part_condition="1";
										$pack_condition1="1";
										if($part_condition){ $div_color="background-image:url(/kor/images/select5_bg.gif)"; }
										if($pack_condition1){ $div_color2="background-image:url(/kor/images/select5_bg.gif)"; }

									?>
										<input type="hidden" name="part_condition[]" value="1">
										<input type="hidden" name="pack_condition1[]" value="1">										
									<?}?>
									<tr >
										<th scope="row" style="width:230px">
											&nbsp;부품상태&nbsp;&nbsp;<div class="select type4" lang="en" style="width:150px;<?=$div_color?>">
											<label  class="c-blue"><?=($part_condition)?GF_Common_GetSingleList("PARTCOND",$part_condition):""?></label>
											<?
											if($part_type!="2"){
												echo GF_Common_SetComboList("part_condition[]", "PARTCOND", "", 1, "True",  "", $part_condition , "", "", "part_condition");
											}
											?>
											</div>
										</th>
										<th scope="row">
											&nbsp;포장상태&nbsp;&nbsp;<div class="select type4" lang="en" style="width:77px;<?=$div_color2?>">
											<label  class="c-blue"><?=($pack_condition1)?GF_Common_GetSingleList("PACKCOND1",$pack_condition1):""?></label>
											<?
											if($part_type!="2"){
												echo GF_Common_SetComboList("pack_condition1[]", "PACKCOND1", "", 1, "True",  "", $pack_condition1 , "");
											}
											?></div>
											<div class="select type4" lang="en" style="width:90px">
											<label  class="c-blue"><?=($pack_condition2)?GF_Common_GetSingleList("PACKCOND2",$pack_condition2):""?></label>
											<?=GF_Common_SetComboList("pack_condition2[]", "PACKCOND2", "", 1, "True",  "", $pack_condition2 , "");?></div>
										</th>
									</tr>
									<tr>
										<td colspan="2" ><strong class="c-black">&nbsp;Memo&nbsp;&nbsp;</strong> <input type="text" class="i-txt5" name="memo[]" value="" style="width:415px;color:#00759e;"></td>
									</tr>
								</tbody>
							</table>
						</td>
				<?}elseif  ($loadPage== "po_cancel"){ //-------------- 판매자 송장(30_08)화면 품목 취소?>
					<td>
						<?=$i?><input type="hidden" name="odr_det_idx[]" value="<?=$odr_det_idx;?>">
						<input type="hidden" name="part_idx[]" value="<?=$part_idx;?>">
					</td>
					<?if ($part_type=="7"){ //턴키--?>
						<td colspan="6"><input type="text" name="part_no[]" class="i-txt4" value="<?=$part_no?>" maxlength="30" style="width:584px; ime-mode:disabled" ></td>
					<?}else{?>
					<?if($sell_mem_idx != $_SESSION['MEM_IDX']){?>
					<td class="t-lt"><img src="/kor/images/nation_title2_<?=$nation?>.png" alt="<?=GF_Common_GetSingleList("NA",$nation)?>"></td>
					<?}?>
					<td class="t-lt"><?=$part_no?></td>
					<td class="t-lt"><?=$manufacturer?></td>
					<td><?=$package?></td>
					<td><?=$dc?></td>
					<td><?=$rhtype?></td>
					<td class="t-rt">
					<?
						$poa_cnt = get_any("odr_history","status_name", "odr_idx=$odr_idx  and (status_name='송장' or status_name='수정발주서' or status_name='발주서') order by odr_history_idx desc limit 1");	
						$qty = ($poa_cnt == "송장")? $part_stock+$supply_quantity : $part_stock+$odr_quantity;
					
						if ($del_chk==0)
						{	
							$quantity = 0;
							if ($part_type==2)
							{
								$qty=number_format($odr_quantity);
							}
							else
							{
								if ($poa_cnt=="송장")
								{
									$qty=number_format($supply_quantity);
								}
								else
								{
									$qty=number_format($odr_quantity);
								}
							}
						}
					?>
					<?if($part_type=="2"){?>
						<?if ($del_chk=="0"){?>									
							<?=number_format($part_stock + $odr_quantity)?>
						<?}else{?>
							I
						<?}?>
					<?}else{?>	
						<?=$qty==0?"":number_format($qty)?>	
					<?}?>					
					</td>
					<?}?>
					<td class="t-rt">$<?=$price_val?></td>					
					<td class="t-rt"><span class="c-blue"><?=$odr_quantity==0?"0":number_format($odr_quantity)?></span></td>
					<?
					global $load_page;					
					?>
					<?
						$modify_in_odr = QRY_CNT("odr_history", "and odr_idx = $odr_idx  and status in (3)") > 0 ? "Y": "N";  //판매자 취소인지 구매자 취소인지 확인
					?>
					<?if($sell_mem_idx != $_SESSION['MEM_IDX'] || ($load_page=="30_08" )){?>
					<td class="t-rt"><span class="c-red"><?=$supply_quantity==""?"":number_format($supply_quantity)?></span></td>		
					<?}?>			
					<?
						if ($part_type=="2")
						{
							$day_val = "WK";
						}
						?>
						
					<?=($period)?"<td class='c-red'>".str_replace("WK","",$period).$day_val."":"<td>Stock"?></td>
					<?if($sell_mem_idx != $_SESSION['MEM_IDX']){?>
					<td >
					<?
					$com_idx = $rel_idx==0 ? $sell_mem_idx : $rel_idx;
					$company_nm = get_any("member","mem_nm_en", "mem_idx=$com_idx"); 	
					?>
					<a class="c-blue" href="javascript:layer_company_det('<?=$com_idx?>');"><?=cut_len($company_nm,8,".")?></a>
					</td>
					<?}?>
					</tr>	
					<?$invoice_cnt = QRY_CNT("odr_history", "and odr_idx = $odr_idx  and status =18") > 0 ? "1": "0";  //첫번째 송장여부?>
					<?if ($invoice_cnt > 0){?>
						<?if($part_condition!=""){?>
							<tr class="bg-none">
								<td></td>
								<td class="c-red" colspan="10" style="text-align:left;">	
									부품상태 : 
									<span class="c-blue"><?=GF_Common_GetSingleList("PARTCOND",$part_condition)?></span>&nbsp&nbsp
									포장상태 : 
									<span class="c-blue"><?=GF_Common_GetSingleList("PACKCOND1",$pack_condition1)?> / <?=GF_Common_GetSingleList("PACKCOND2",$pack_condition2)?> </span>
								</td>
							</tr>						
						<?}?>		
						<?if(strlen($memo)>0){?>
							<tr class="noinput" >
								<td></td>
								<td colspan="10" style="text-align:left;"><strong class="c-black" >Memo : </strong><font color="#00759e"><?=$memo?></font> </td>
							</tr>	
						<?}?>	
					<?}?>		
					<tr>
						<td></td>
						<td colspan="15" style="padding:0">
							<table class="detail-table w100" style="margin:0;">
								<tbody>
									<tr>
										<td lang="en" class="t-lt">
											<strong lang="ko" class="c-black">&nbsp;사유&nbsp;&nbsp;</strong>
											<input type="text" class="i-txt2 c-blue" name="reason[]" value="" style="width:350px">
										</td>
									</tr>
									<tr>
										<td lang="ko" class="c-red2" style="padding-left:43px;padding-top:0;font-size:11px;" >취소 시 ‘발주 취소’ 항목의 숫자가 증가할 것입니다.</td>
									</tr>
								</tbody>
							</table>
						</td>
				<?}elseif  ($loadPage== "3016_cancel"){ //-------------- 판매자 선적(30_16)화면에서 취소?>
					<td>
						<?=$i?>
						<input type="hidden" name="part_idx[]" value="<?=$part_idx;?>">
					</td>
					<?if ($part_type=="7"){ //턴키--?>
						<td colspan="6"><input type="text" name="part_no[]" class="i-txt4" value="<?=$part_no?>" maxlength="30" style="width:584px; ime-mode:disabled" ></td>
					<?}else{?>
					<?if($sell_mem_idx != $_SESSION['MEM_IDX']){?>
					<td class="t-lt"><img src="/kor/images/nation_title2_<?=$nation?>.png" alt="<?=GF_Common_GetSingleList("NA",$nation)?>"></td>
					<?}?>
					<td class="t-lt"><?=$part_no?></td>
					<td class="t-lt"><?=$manufacturer?></td>
					<td><?=$package?></td>
					<td><?=$dc?></td>
					<td><?=$rhtype?></td>
					<td class="t-rt"><?=$odr_stock==0?"":number_format($odr_stock)?></td>
					<?}?>
					<td class="t-rt">$<?=$price_val?></td>					
					<td class="t-rt"><span class="c-blue"><?=$odr_quantity==0?"":number_format($odr_quantity)?></span></td>
					<?
					global $load_page;					
					?>
					<?
						$modify_in_odr = QRY_CNT("odr_history", "and odr_idx = $odr_idx  and status in (3)") > 0 ? "Y": "N";  //판매자 취소인지 구매자 취소인지 확인
					?>
					<?if($sell_mem_idx != $_SESSION['MEM_IDX'] || ($loadPage== "3016_cancel")){?>
					<td class="t-rt"><span class="c-red"><?=$supply_quantity==""?"0":number_format($supply_quantity)?></span></td>		
					<?}?>			
					<?=($period)?"<td class=''>".$period:(($part_type=="2"||$part_type=="5"||$part_type=="6")?"<td class='c-red'><span lang='ko'>확인</span>":"<td>Stock")?></td>
					<?if($loadPage== "3016_cancel" && $det_cnt>1){// 선적화면에서 취소시.... 재고삭제 선택?>
						<td class="t-ct">
							<label class="ipt-chk chk2 t-ct">
								<input type="checkbox" name="odr_det_idx[]" class="stock" value="<?=$odr_det_idx?>"><span></span>
							</label>
						</td>
					<?}else{?>
						<input type="hidden" name="odr_det_idx[]" value="<?=$odr_det_idx;?>">
					<?}?>

					<?if($sell_mem_idx != $_SESSION['MEM_IDX']){?>
					<td >
					<?
					$com_idx = $rel_idx==0 ? $sell_mem_idx : $rel_idx;
					$company_nm = get_any("member","mem_nm_en", "mem_idx=$com_idx"); 	
					?>
					<a class="c-blue" href="javascript:layer_company_det('<?=$com_idx?>');"><?=cut_len($company_nm,8,".")?></a>
					</td>
					<?}?>
					</tr>	
					<?$invoice_cnt = QRY_CNT("odr_history", "and odr_idx = $odr_idx  and status =18") > 0 ? "1": "0";  //첫번째 송장여부?>
					<?if ($invoice_cnt > 0){?>
						<?if($part_condition!=""){?>
							<tr class="bg-none">
								<td></td>
								<td class="c-red" colspan="<?=($colspan - 1)?>" style="text-align:left;">	
									부품상태 : 
									<span class="c-blue"><?=GF_Common_GetSingleList("PARTCOND",$part_condition)?></span>&nbsp&nbsp
									포장상태 : 
									<span class="c-blue"><?=GF_Common_GetSingleList("PACKCOND1",$pack_condition1)?> / <?=GF_Common_GetSingleList("PACKCOND2",$pack_condition2)?> </span>
								</td>
							</tr>						
						<?}?>		
						<?if(strlen($memo)>0){?>
							<tr class="noinput" >
								<td></td>
								<td colspan="10" style="text-align:left;"><strong class="c-black" >Memo : </strong><font color="#00759e"><?=$memo?></font> </td>
							</tr>	
						<?}?>	
					<?}?>		
					<tr>
						<td></td>
						<td colspan="15" style="padding:0">
							<table class="detail-table w100" style="margin:0; display:none;" id="desc_<?=$odr_det_idx?>">
								<tbody>
									<tr>
										<td lang="en" class="t-lt">
											<strong lang="ko" class="c-black">&nbsp;사유&nbsp;&nbsp;</strong>
											<input type="text" class="i-txt2 c-blue" name="reason[]" value="" style="width:350px">
										</td>
									</tr>
									<tr>
										<td lang="ko" class="c-red2" style="padding-left:43px;padding-top:0;font-size:11px;" >취소 시 ‘발주 취소’ 항목의 숫자가 증가할 것입니다.</td>
									</tr>
								</tbody>
							</table>
						</td>
						<!---------------------------------------------------------------------------------------------------------------------------------------------------->
					<?}elseif ($loadPage == "30_16" ||$loadPage=="18R_21"){ //[판매자] 선적(30_16)/교환선적시 보여지는 내용?>
						<?if($loadPage == "30_16"){?>
						<input type="hidden" name="odr_det_idx[]" style="padding-right:0px;" class="stock" odr_quantity="<?=$odr_quantity;?>" value="<?=$odr_det_idx?>"><span></span>
						<?if ($det_cnt>1){?>
							<td>
								<label class="ipt-chk chk2">
									<input type="<?=($det_cnt>1)? "checkbox":"hidden";?>" name="odr_det_idx[]" style="padding-right:0px;" class="stock" odr_quantity="<?=$odr_quantity;?>" value="<?=$odr_det_idx?>"><span></span>
								</label>
							</td>
						<?}?>
						<?}else{	//-- 18R_21 --------?>
							<input type="hidden" name="odr_det_idx" class="stock" odr_quantity="<?=$odr_quantity;?>" value="<?=$odr_det_idx?>">
						<?}?>
						<td><?=$i?></td>
						<?if ($part_type=="7"){?>
							<td colspan="6" class="t-lt"><?=get_cut($part_no,80,"..")?></td>
						<?}else{?>
							<td class="t-lt"><?=$part_no?></td>
							<td class="t-lt"><?=$manufacturer?></td>
							<td><?=$package?></td>
							<td>
								<?if ($loadPage == "18R_21"){ //교환일 경우에는 제작년도도 input으로 다시 표시?>
								<input type="text" name="fault_dc" maxlength="4" class="i-txt4 c-red2 onlynum" value="<?=$dc?>" style="width:38px"><?}else{?><?=$dc?><?}?>
							</td>	
							<td><?=$rhtype?></td>
							<td class="t-rt">
								<?if ($loadPage == "18R_21"){ //교환일 경우에는 unit price ?>
									$<?=$price==0?"":number_format($price,2)?>
								<?}else{?>
									<?=$supply_quantity==0?"-":number_format($supply_quantity)?>
								<?}?>
							</td>
						<?}?>
						<?if ($loadPage == "18R_21"){ //교환일 경우에는 교환 수량만 표시
												global $fault_select;
												
												//$fault_quantity = $fault_select =="1" ? $fault_quantity: $odr_quantity;
												?>
							<td class="c-blue"><input type="text" name="fault_quantity" class="i-txt4 c-red2 onlynum numfmt t-rt" maxlength="10" value="<?=$fault_quantity==0?"":number_format($fault_quantity)?>" style="width:58px"></td>
						<?}else{?>
							<? 
								$price_sum = $price*$supply_quantity;

								if(strpos($price_sum, ".") == false || strpos($price_sum, ".") == false)  
								{
									$price_sum= round_down($price_sum,2);
									$price_sum= number_format($price_sum,2);
								}
								else
								{
									$price_sum= round_down($price_sum,4);
								}
							?>
							<td class="t-rt">$<?=$price_val?></td>
							<td class="t-rt">$<?=$price_sum?></td>
						<?}?>
						<?=($period)?"<td class=''>".$period:(($part_type=="2"||$part_type=="5"||$part_type=="6")?"<td class='c-red'><span lang='ko'>확인</span>":"<td>Stock")?></td>
						
						<!--<?=($det_cnt>1)? "<td></td>":"";?>-->
						<tr class="bg-none">				
					<?if ($loadPage == "30_16"){?>
							<td><input type="hidden" name="odr_det_idx[]" value="<?=$odr_det_idx;?>"></td>
							<td class="c-red" colspan="2" style="text-align:left;">	
								부품상태 :
								<span class="c-blue"><?=GF_Common_GetSingleList("PARTCOND",$part_condition)?></span>&nbsp&nbsp
								포장상태 : 
								<span class="c-blue"><?=GF_Common_GetSingleList("PACKCOND1",$pack_condition1)?> / <?=GF_Common_GetSingleList("PACKCOND2",$pack_condition2)?> </span>
							</td>
						</tr>
						<?if(strlen($memo)>0){?>
						<tr class="noinput" >
							<td></td>
							<td colspan="10" style="text-align:left;"><strong class="c-black" >Memo : </strong><font color="#00759e"><?=$memo?></font> </td>
						</tr>
						<?}?>
					<?}?>
						<tr class="yesinput" style="display:none;">
							<td></td>
							<td colspan="10" style="text-align:left;">	
							부품상태 : 							
								<div class="select type4" lang="en" style="width:150px">
								<label  class="c-blue"><?=($part_condition)?GF_Common_GetSingleList("PARTCOND",$part_condition):"부품상태"?></label>
								<?=GF_Common_SetComboList("part_condition", "PARTCOND", "", 1, "True",  "", $part_condition , "");?>
								</div>						
							포장상태 :
								<div class="select type4" lang="en" style="width:75px">
										<label  class="c-blue"><?=($pack_condition1)?GF_Common_GetSingleList("PACKCOND1",$pack_condition1):"포장상태"?></label>
										<?=GF_Common_SetComboList("pack_condition1", "PACKCOND1", "", 1, "True",  "", $pack_condition1 , "");?>
								</div>
								<div class="select type4" lang="en" style="width:90px">
										<label  class="c-blue"><?=($pack_condition2)?GF_Common_GetSingleList("PACKCOND2",$pack_condition2):"포장상태"?></label>
										<?=GF_Common_SetComboList("pack_condition2", "PACKCOND2", "", 1, "True",  "", $pack_condition2 , "");?>
								</div>		
							</td>
						</tr>
						<tr class="yesinput"  style="display:none;">
							<td></td>
							<td colspan="10" style="text-align:left;"><strong class="c-black">Memo : </strong> <input type="text" class="i-txt3 c-blue" name="memo" value="<?=$memo?>" style="width:294px"></td>
						</tr>
						<tr>
							<td></td>
							<td colspan="10" class="img-cntrl-list" style="text-align:left;">
								<strong class="c-red">라벨/부품사진 </strong>
								<?for ($j = 1;$j <= 3; $j++ ){
									$tap_display = "";
									$file = replace_out($row["file$j"]);
									if ( $j ==1 || $file ){
										
									}
									else
									{
										
										$tap_display = "display:none;";
									}
									?>
								<div class="img-cntrl-wrap img_tap<?=$j?>_<?=$odr_det_idx?> img_sub_<?=$j?>" style="margin-top:10px;<?=$tap_display?>" >
									<?
									
									if($j>0)
									{								
										if($file !="")
										{									
											$display_b = "display:block;";
										}
										else
										{
											$display_b = "display:none;";
										}
										
										$plus_chk = "plus_chk".$j."_".$odr_det_idx;
										$minus_chk = "minus_chk".$j."_".$odr_det_idx;										
									}
									else
									{
										$display_b = "display:none;";
										$sel_chk = "";
									}
									?>
									<span class="img-wrap"><img alt="" id="fileimg<?=$odr_det_idx?>_<?=$j?>" <?=get_noimg_photo($file_path, $file, "/kor/images/file_pt.gif")?> style="border: 1px solid #00759e;" ></span>
									<input name="file_o<?=$j?>" id="file_o<?=$j?>" type="hidden" value="<?=$fileonly?>">
									<input name="file<?=$odr_det_idx?>_<?=$j?>" id="file<?=$odr_det_idx?>_<?=$j?>" f_number="<?=$j?>" odr_det_idx="<?=$odr_det_idx?>"" type="file" style="width:1px;height:1px">
									
									<a href="javascript:;" class="arrow_top <?=$plus_chk?>" style="<?=$display_b?>">+</a>
									<a href="javascript:;" class="arrow_bottom <?=$minus_chk?>" f_idx="<?=$odr_det_idx?>_<?=$j?>" f_number="<?=$j?>" f_odr_det_idx="<?=$odr_det_idx?>" style="<?=$display_b?>">-</a>
									
								</div>
								<?}?>
								<span style="font-size:11px;padding-left:10px;"><strong class="c-red">라벨/부품 사진을 첨부해 주십시오. 분쟁 발생 시 보호받을 수 있습니다.</strong></span>
							</td>							
						</tr>
					<?}elseif ($loadPage == "01_36"){ //------------------------------- 01_36  창고->도착-------------------------------------------------------------------------------------
					?>
						<td><?=$i?></td>
						<td class="t-lt"><?=$part_no?></td>
						<td class="t-lt"><?=$manufacturer?></td>
						<td><?=$package?></td>
						<td><?=$dc?></td>
						<td>
							<div class="select type6" lang="en" style="width:60px">
								<label><?=$rhtype==""?"":$rhtype?></label>
								<select name="rhtype[]">
									<option lang="en" <?if($rhtype=="None"){echo "selected";}?>></option>
									<option lang="en" <?if($rhtype=="RoHS"){echo "selected";}?>>RoHS</option>
									<option lang="en" <?if($rhtype=="HF"){echo "selected";}?>>HF</option>
								</select>
							</div>
						</td>
						<td class="t-rt"><?=$supply_quantity==0?"-":number_format($supply_quantity); //수량?></td>
						<td class="t-rt">$<?=$price_val?></td>
						<?
							$price_sum = $price*$supply_quantity;
							$price_sum = round_down($price_sum,4);
						?>
						<td class="t-rt">$<?=number_format($price_sum,4)?></td>
						<?
						if ($part_type=="2")
						{
							$day_val = "WK";
						}
						?>
						<td class=""><?=($period)? str_replace("WK","",$period).$day_val."":"Stock";?></td>	
					<!-- 부가내용 시작-->
					</tr>
					<tr class="bg-none">
						<td></td>
						<td colspan="13">
							<!-- 부품상태 ---------------->
							<table class="detail-table">
								<tbody>
									<tr>
										<th scope="row" style="width:220px">
											부품상태&nbsp;&nbsp;<div class="select type4" lang="en" style="width:150px">
											<label  class="c-blue"><?=($part_condition)?GF_Common_GetSingleList("PARTCOND",$part_condition):""?></label>
											<?=GF_Common_SetComboList("part_condition", "PARTCOND", "", 1, "True",  "", $part_condition , "", "", "part_condition");?>
											</div>
										</th>
										<th scope="row">
											포장상태&nbsp;&nbsp;<div class="select type4" lang="en" style="width:77px">
											<label  class="c-blue"><?=($pack_condition1)?GF_Common_GetSingleList("PACKCOND1",$pack_condition1):""?></label>
											<?=GF_Common_SetComboList("pack_condition1", "PACKCOND1", "", 1, "True",  "", $pack_condition1 , "");?></div>
											<div class="select type4" lang="en" style="width:90px">
											<label  class="c-blue"><?=($pack_condition2)?GF_Common_GetSingleList("PACKCOND2",$pack_condition2):""?></label>
											<?=GF_Common_SetComboList("pack_condition2", "PACKCOND2", "", 1, "True",  "", $pack_condition2 , "");?></div>
										</th>
									</tr>
									<tr>
										<td colspan="2" ><strong class="c-black">Memo&nbsp;&nbsp;</strong> <input type="text" class="i-txt3 c-blue" name="memo" value="" style="width:388px"></td>
									</tr>
								</tbody>
							</table>
							<!-- //부품상태 ---------------->
						</td>
					</tr>
					<!-- 부가내용 종료-->
					<?}elseif ($loadPage == "1304_accept"){ //------------------------------- 30_15  What's New : 결제 완료-------------------------------------------------------------------------------------


					?>
						<td><?=$i?></td>
						<td class="t-lt"><img src="/kor/images/nation_title2_<?=$nation?>.png" alt="<?=GF_Common_GetSingleList("NA",$nation)?>"></td>
						<?if($part_type=="7"){?>
							<td class="t-lt" colspan="5"><?=$part_no?></td>
						<?}else{?>
							<td class="t-lt"><?=$part_no?></td>
							<td class="t-lt"><?=$manufacturer?></td>
							<td><?=$package?></td>
							<td><?=$dc?></td>
							<td><?=$rhtype?></td>
						<?}?>
						<td class="t-rt"><?=$supply_quantity==0?"-":number_format($supply_quantity); //수량?></td>
						<td class="t-rt">$<?=$price_val?></td>
						
						<td class="t-rt c-blue"><?=$odr_quantity==0?"":number_format($odr_quantity); //발주수량?></td>
						<td class="t-rt c-red"><?=number_format($supply_quantity) //공급수량?></td>
						<?
						if ($part_type=="2")
						{
							$day_val = "WK";
						}
						?>
						<td class=""><?=($period)? str_replace("WK","",$period).$day_val."":"Stock";?></td>	
					<!-- 부가내용 시작-->
						<td >
						<?
						$com_idx = $rel_idx==0 ? $sell_mem_idx : $rel_idx;
						$company_nm = get_any("member","mem_nm_en", "mem_idx=$com_idx"); 	
						?>
						<a class="c-blue" href="javascript:layer_company_det('<?=$com_idx?>');"><?=cut_len($company_nm,8,".")?></a>
						</td>
					</tr>
					<!-- 변경 작업 2016.10.17 시작-->
					<tr class="bg-none">
						<td></td>
						<td colspan="13" style="text-align:left;">
							<!-- 부품상태 ---------------->							
								<?if(strlen($part_condition)>0 && $part_condition>0){?>									
									<span class="c-red">부품상태  : </span><span style="color:#00759e;"><?=GF_Common_GetSingleList("PARTCOND",$part_condition)?> </span>&nbsp&nbsp					
									<span class="c-red">포장상태 : </span><span style="color:#00759e;"><?=GF_Common_GetSingleList("PACKCOND1",$pack_condition1)?> / <?=GF_Common_GetSingleList("PACKCOND2",$pack_condition2)?> </span>	
								<?}?>							
							<!-- //부품상태 ---------------->
						</td>
					</tr>
					<?if(strlen($memo)>0){?>
					<tr class="bg-none">
						<td></td>
						<td colspan="13" style="text-align:left;">
							<strong class="c-black">Memo : </strong><span style="color:#00759e;"><?=$memo?> </span>		
						</td>
					</tr>
					<?}?>
					<!-- 변경 작업 2016.10.17 끝-->
			
					<!-- 부가내용 끝-->
					<!-- 부가내용 종료-->
					<?}elseif ($loadPage == "30_15"){ //------------------------------- 30_15  What's New : 결제 완료-------------------------------------------------------------------------------------
					?>
						<td><?=$i?></td>
						<?if($part_type=="7"){?>
							<td class="t-lt" colspan="5"><?=$part_no?></td>
						<?}else{?>
							<td class="t-lt"><?=$part_no?></td>
							<td class="t-lt"><?=$manufacturer?></td>
							<td><?=$package?></td>
							<td><?=$dc?></td>
							<td><?=$rhtype?></td>
						<?}?>
						<td class="t-rt"><?=$supply_quantity==0?"-":number_format($supply_quantity); //수량?></td>
						<td class="t-rt">$<?=$price_val?></td>
						<?
							$price_sum = $price*$supply_quantity;
							$price_sum = round_down($price_sum,4);
						?>
						<td class="t-rt">$<?=number_format($price_sum,4)?></td>
						<!--<td class="t-rt c-blue"><?=$odr_quantity==0?"":number_format($odr_quantity); //발주수량?></td>
						<td class="t-rt c-red"><?=number_format($supply_quantity) //공급수량?></td>-->
						<?
						if ($part_type=="2")
						{
							if ($period !="stock")
							{
								$day_val = "WK";
							}
							
						}
						?>
						<td class=""><?=($period)? "<span class='c-red'>".str_replace("WK","",$period).$day_val."</span>"."":"Stock";?></td>	
					<!-- 부가내용 시작-->
					</tr>
					<!-- 변경 작업 2016.10.17 시작-->
					<tr class="bg-none">
						<td></td>
						<td colspan="13" style="text-align:left;">
							<!-- 부품상태 ---------------->							
								<?if(strlen($part_condition)>0 && $part_condition>0){?>									
									<span class="c-red">부품상태  : </span><span style="color:#00759e;"><?=GF_Common_GetSingleList("PARTCOND",$part_condition)?> </span>&nbsp&nbsp					
									<span class="c-red">포장상태 : </span><span style="color:#00759e;"><?=GF_Common_GetSingleList("PACKCOND1",$pack_condition1)?> / <?=GF_Common_GetSingleList("PACKCOND2",$pack_condition2)?> </span>	
								<?}?>							
							<!-- //부품상태 ---------------->
						</td>
					</tr>
					<?if(strlen($memo)>0){?>
					<tr class="bg-none">
						<td></td>
						<td colspan="13" style="text-align:left;">
							<strong class="c-black">Memo : </strong><span style="color:#00759e;"><?=$memo?> </span>		
						</td>
					</tr>
					<?}?>
					<!-- 변경 작업 2016.10.17 끝-->
			
					<!-- 부가내용 끝-->

						<!------------------------------------2016-04-20 : 아래에서 30_15 제거------------------------------------------------------------------------------------------------------>
					<?}elseif  ($loadPage== "05_04_1" ||$loadPage== "30_10" || $loadPage== "30_20" || $loadPage=="31_06"|| $loadPage=="01_37" ||$loadPage == "21_04" ||$loadPage == "18R_05" ||$loadPage == "18R_06" ||$loadPage =="18R_08" ||$loadPage =="18R_16"||$loadPage =="18R_19"||$loadPage =="04_01"||$loadPage =="19_06"||$loadPage =="19_08"||$loadPage =="19_1_06" || $loadPage =="08_02" || $loadPage =="10_02" ||$loadPage=="10_04" || $loadPage =="13_02" || $loadPage =="13_02s" || $loadPage =="13_04" || $loadPage =="13_04s" || $loadPage =="02_02" || $loadPage =="03_02" || $loadPage== "30_23" || $loadPage =="18_1_04" || $loadPage=="19_1_05" || $loadPage=="30_14"){ //구매자 페이지에서 보여지는 송장 내용
						$com_idx = $rel_idx==0 ? $sell_mem_idx : $rel_idx;
						$company_nm = get_any("member","mem_nm_en", "mem_idx=$com_idx"); 	
						
						if ($loadPage == "30_20"|| $loadPage == "30_22" || $loadPage == "30_23") { 
							//선적 완료 페이지에서는 최근 history가 뭔지(수령/거절/수량부족 이면 안보여야함.)에 따라 checkbox가 보이고 안보이고 차이가 있다.) - JSJ
							$chkbox_visible = "Y";
							if(QRY_CNT("odr_history", "and odr_idx = $odr_idx and odr_det_idx= $odr_det_idx")>0){
								$recent_his_idx = get_any("odr_history" , "max(odr_history_idx)", "odr_idx = $odr_idx and odr_det_idx= $odr_det_idx");
							}else{
								$recent_his_idx = get_any("odr_history" , "max(odr_history_idx)", "odr_idx = $odr_idx");
							}
							
							if ($recent_his_idx) {
								$recent_status = get_any("odr_history" ,"status", "odr_history_idx = $recent_his_idx");
								if ($recent_status == $status || $recent_status == "9" || $recent_status == "10" || $recent_status == "15"){
									$chkbox_visible = "N";							
								}
							}
						} 
					?>
						<? //2016-05-10 : 18R_19 아래에서 option <td> 빼버림
						if ($loadPage =="04_01" || $loadPage=="30_20"){?>
						<?$det_cnt = QRY_CNT("odr_det"," and odr_idx=$odr_idx ");  //odr_det 수량?>
						<?if ($det_cnt>1){?>
						<td><label class="ipt-chk chk2">
						
						<?if($loadPage!="30_20"){?>
							<input type="checkbox" name="odr_det_idx[]" class="<?=($part_type=="2" && $period*1> 2) ? "endure":"stock"?>" value="<?=$odr_det_idx?>" part_type="<?=$part_type?>">
						<?}else if($loadPage=="30_20" &&$chkbox_visible=="Y"){ //2016-04-24 : 품목 1개일때는 옵션 숨기기
							$det_cnt = QRY_CNT("odr_det"," and odr_idx=$odr_idx ");  //odr_det 수량

						?>
						
							<input type="<?=($det_cnt>1)? "checkbox":"hidden";?>" name="odr_det_idx[]" class="stock" odr_quantity="<?=$odr_quantity;?>" value="<?=$odr_det_idx?>">
						
						<?}?>
						
						<span></span></label></td>
						<?
						}
						// 카운트가 1일때
						else
						{
						?>
						<input type="hidden" name="odr_det_idx[]" class="stock" odr_quantity="<?=$odr_quantity;?>" value="<?=$odr_det_idx?>">
						<?}?>

						<?}
						?>
						<?if($loadPage =="18R_19" || $loadPage=="19_1_05"){?>
							<input type="hidden" name="odr_det_idx[]" class="stock" value="<?=$odr_det_idx?>">
						<?}?>
						<td><?=$i?></td>
						<?
						$bottom_30_20 = $i;

						?>
						<?if ($loadPage !="18R_06" && $loadPage !="13_02s" && $loadPage != "03_02"){?><td>
						<?
							if($loadPage!="05_04_1" || ($loadPage=="05_04_1" && $sell_mem_idx != $_SESSION["MEM_IDX"])){
						?>
							<img src="/kor/images/nation_title2_<?=$nation?>.png" alt="<?=GF_Common_GetSingleList("NA",$nation)?>">
						<?}?></td><?}?>
						
						<?if ($part_type=="7"){?>
							<td colspan="8" class="t-lt"><?=get_cut($part_no,80,"..")?></td>
						<?}else{?>
						<?if($loadPage !="31_06"){?>
						<!--<input type="hidden" name="odr_det_idx" value="<?=$odr_det_idx?>"/>-->
						<?}?>
							<td class="t-lt"><?=cut_len($part_no,24,".");?></td>
							<td class="t-lt"><?=cut_len($manufacturer,20,".");?></td>
							<td><?=$package?></td>
							<td><?=$dc?></td>
							<td><?=$rhtype?></td>

							<?if($loadPage != "18R_19" && $loadPage!="19_1_05" && $loadPage!="19_1_06" && $loadPage!="30_14" ){?>
								<?if($loadPage == "30_10" || $loadPage == "13_04s" || $loadPage == "13_02s" || $loadPage == "03_02"){	//What'sNew(구매자:송장)
									//2016-12-25 : 수정발주서가 있는 경우에는 '실수량+공급수량
									$poa_cnt = get_any("odr_history","status_name", "odr_idx=$odr_idx  and (status_name='송장' or status_name='수정발주서' or status_name='발주서') order by odr_history_idx desc limit 1");	
									$qty = ($poa_cnt == "송장")? $part_stock+$supply_quantity : $part_stock+$odr_quantity;
								
								?>
									<?if($part_type=="2"){?>
										<?if ($del_chk=="0"){?>									
											<td class="t-rt" style="width:60px;"><?=$qty?></td>
										<?}else{?>
											<td class="t-rt" style="width:60px;">I</td>
										<?}?>
									<?}else{?>
										<td class="t-rt"><?=number_format($qty)?></td>	
									<?}?>	
									
								<?}else if($loadPage == "02_02"){?>									
									<td class="t-rt">0</td>	
								<?}else if($loadPage == "31_06"){?>			
									<?
										if ($del_chk=="0")
										{
											$part_stock="0";
											$part_2_stock="0";
										}
										else
										{
											$part_2_stock="I";
										}
									?>
									<?if ($part_type=="2"){?>
										<td class="t-rt"><?=$part_2_stock?></td>	
									<?}else{?>
										<td class="t-rt"><?=$part_stock==0?"0":number_format($part_stock)?></td>
									<?}?>
								<?}else{?>									
									<td class="t-rt"><?=$supply_quantity==0?"0":number_format($supply_quantity)?></td>							
								<?}?>
							<?}?>
						<?}?>
						<td class="t-rt">$<?=$price_val?></td>
						<?if ($loadPage !="19_08" && $loadPage !="18R_05" ){?>
						<td class="t-rt ">
						<!-- 발주수량/반품수량-->
							<?if($loadPage == "18_1_04"){?>
								<input type="text" name="fault_quantity" id="fault_quantity" class="i-txt4 c-red  onlynum numfmt t-rt" maxlength="10" Style="width:60px;" value="<?=$fault_quantity==0?"":number_format($fault_quantity)?>">
							<?}elseif($loadPage == "_18R_19" || $loadPage=="19_1_05" || $loadPage=="19_1_06" ){
									$fault_quantity = ($fault_quantity==0)? "0":number_format($fault_quantity);
									echo "<span class=\"c-red2\">".$fault_quantity."</span>";
								}
								elseif ($loadPage =="30_20" || $loadPage =="30_14" || $loadPage =="19_06" || $loadPage =="18R_16" || $loadPage =="18R_19" || $loadPage =="18R_06" || $loadPage =="01_37" )
								{
									$price_sum = $price*$supply_quantity;

									if(strpos($price_sum, ".") == false)  
									{
										$price_sum= round_down($price_sum,2);
										$price_sum= number_format($price_sum,2);
									}
									else
									{
										$price_sum= round_down($price_sum,4);
										$price_sum= number_format($price_sum,4);
									}
									echo "$".$price_sum;
								}								
								else{
									echo "<span class=\"c-blue\">".number_format($odr_quantity)."</span>";
								}?>

						<!--//발주수량-->
						</td>
						<?}?>
						<?if ($loadPage !="21_04" || $loadPage !="30_20" || $loadPage =="30_14"  ){?>
								<?if($loadPage!="02_02"&& $loadPage !="05_04_1" && $loadPage !="30_20" && $loadPage !="30_14"  && $loadPage !="13_04s" && $loadPage !="19_08" && $loadPage !="18R_05" && $loadPage !="19_06" && $loadPage !="18R_16" && $loadPage !="18R_19" && $loadPage !="18R_06" && $loadPage !="01_37"){?>
									<td class="t-rt c-red">
										<?if($part_type=="7"){?>
										$<?=number_format($price,2);?>
										<?}else{?>
										<?=$supply_quantity==0?"":number_format($supply_quantity)?>
										<?}?>
									</td>
								<?}?>
								<?if($loadPage!="19_1_05" && $loadPage!="19_1_06"  ){  //납기표기?>
								<?
								if ($part_type==2)
								{
									$day_val = "WK";
								}
								?>
								<?=($period)?(QRY_CNT("odr_history", "and  odr_idx = $odr_idx and status = 19 ")>0?"<td>Stock":"<td class='c-red'>".str_replace("WK","",$period).$day_val.""):(($part_type=="2"||$part_type=="5"||$part_type=="6")?"<td class='c-red'><span lang='ko'>확인</span>":"<td>Stock")?></td>
								<?}?>
						<?}?>
						<?if($loadPage=="19_1_05" || $loadPage=="19_1_06"  ){
							$fault_amt = get_any("odr_det a INNER JOIN part b ON a.part_idx = b.part_idx", "(a.fault_quantity * b.price)", "odr_idx = $odr_idx AND odr_det_idx = $odr_det_idx");
							if($loadPage !="30_14" || $loadPage !="30_20" || $loadPage !="30_14"){
							echo "<td class=\"t-rt\">$".number_format($fault_amt,2)."</td>";
							}
						}?>
						<?if ($loadPage!="31_06" && $loadPage!="02_02"){?>
						<?if ($loadPage !="18R_06" && $loadPage !="18R_19" && $loadPage!="19_1_05" && $loadPage != "03_02"&& $loadPage != "04_01" && $loadPage!="19_06" && $loadPage !="13_02s"){?>
						<td class="c-blue"><?
							if($loadPage!="05_04_1" || ($loadPage=="05_04_1" && $sell_mem_idx != $_SESSION["MEM_IDX"])){
						?><a href="javascript:layer_company_det(<?=$com_idx?>);" style="color:#00759e;"><?=cut_len($company_nm,8,".");?></a><?
							}?></td><?
						}?>
					</tr>
					<tr class="bg-none" id="detail_<?=$odr_det_idx;?>">
					<td></td>
					<td colspan="12" style="padding:0;">
						<table class="detail-table" style="margin:0;">
							<tbody>
								<?if ($loadPage != "05_04_1" && $loadPage != "08_02" && $loadPage !="10_02" && $loadPage!="10_04" && $loadPage != "13_04"   && $loadPage != "03_02" && $loadPage != "19_1_06" ){?>
									<?if(strlen($part_condition)>0 && $part_condition>0){?>
									<tr class="noinput">
										<th scope="row" colspan=2>&nbsp;부품상태&nbsp;:&nbsp;&nbsp;<span class="c-blue"><?=GF_Common_GetSingleList("PARTCOND",$part_condition)?></span>
										&nbsp;&nbsp;&nbsp;포장상태&nbsp;:&nbsp;&nbsp;<span class="c-blue"><?=GF_Common_GetSingleList("PACKCOND1",$pack_condition1)?> / <?=GF_Common_GetSingleList("PACKCOND2",$pack_condition2)?> </span></th>
									</tr>
									<?}?>
								<?}?>
								<?if ($loadPage != "03_02" && $loadPage!="05_04_1" && $loadPage!="13_04s"  && $loadPage != "19_1_06" && strlen($memo)>0){?>
								<tr class="noinput">
									<td colspan="2" ><strong class="c-black" >Memo : </strong><?=$memo;?> </td>
								</tr>
								<?}?>
								<?if ($loadPage == "13_04s" || $loadPage == "13_02s"){?>	
								<tr class="noinput">
									<td  ><strong class="c-black">사유 : </strong><?=$det_reason;?> </td>
								</tr>
								<?}?>
								<?if ( $loadPage =="21_04" ){?>
								<tr>
									<td colspan="4"  class="img-cntrl-list">
										<strong class="c-red">라벨/부품사진 </strong>
										<?
										$odr_history_idx= get_any("odr_history" , "odr_history_idx" , "odr_idx = $odr_idx and status = 21");
										$odr_his = get_odr_history($odr_history_idx);										
										for ($j = 1;$j <= 3; $j++ ){
											$file = $odr_his["file".$j];											
						?>
										<div class="img-cntrl-wrap">
										<span class="img-wrap"><a href="<?=get_noimg($file_path,$file,"#")?>" <?if ($file){?>target="_blank"<?}?>><img <?=get_noimg_photo($file_path, $file, "/kor/images/file_pt.gif")?> alt=""></a></span>											
										</div>
										<?}?>
									</td>
								</tr>
								<?}elseif ( $loadPage == "19_06" || $loadPage =="19_08"  ||$loadPage =="18R_08" || $loadPage =="18R_19" || $loadPage =="18R_16"  ||$loadPage == "18R_06" || $loadPage == "18R_05" || $loadPage == "30_20" || $loadPage == "18_1_04" || $loadPage == "30_14"){?>
								<?if ($row["file1"]){?>
								<tr>
									<td colspan="2"  class="img-cntrl-list">
										<strong class="c-red"><span>라벨/부품사진 </span></strong>
										<?					
										for ($j = 1;$j <= 3; $j++ ){
											$file = replace_out($row["file$j"]);		


								?>
										<div class="img-cntrl-wrap">
										<?if ($file){?>
										<span class="img-wrap" style="margin-top:10px;"><a href="<?=get_noimg($file_path,$file,"#")?>" <?if ($file){?>target="_blank"<?}?>><img <?=get_noimg_photo($file_path, $file, "/kor/images/file_pt.gif")?> alt=""></a></span>	
										<?}?>										
										</div>
										<?}?>
									</td>
								</tr>
								<?}?>
													
								<?}?>
								<?if ($loadPage == "30_15"){?>
								
								<tr class="yesinput" style="display:none;">
									<th scope="row">부품상태 : </th>
									<td style="width:131px">
										<div class="select type4" lang="en" style="width:110px">
										<label  class="c-blue"><?=($part_condition)?GF_Common_GetSingleList("PARTCOND",$part_condition):"부품상태"?></label>
										<?=GF_Common_SetComboList("part_condition", "PARTCOND", "", 1, "True",  "", $part_condition , "");?>
										</div>
									</td>
									<th scope="row">포장상태 : </th>
									<td>
									<div class="select type4" lang="en" style="width:77px">
											<label  class="c-blue"><?=($pack_condition1)?GF_Common_GetSingleList("PACKCOND1",$pack_condition1):"포장상태"?></label>
											<?=GF_Common_SetComboList("pack_condition1", "PACKCOND1", "", 1, "True",  "", $pack_condition1 , "");?>
									</div>
									<div class="select type4" lang="en" style="width:77px">
											<label  class="c-blue"><?=($pack_condition2)?GF_Common_GetSingleList("PACKCOND2",$pack_condition2):"포장상태"?></label>
											<?=GF_Common_SetComboList("pack_condition2", "PACKCOND2", "", 1, "True",  "", $pack_condition2 , "");?>
									</div>
									</td>
								</tr>
								<tr class="yesinput"  style="display:none;">
									<td colspan="4" ><strong class="c-black">Memo : </strong> <input type="text" class="i-txt3" name="memo" value="<?=$memo?>" style="width:294px"></td>
								</tr>
							
								<?}?>
							</tbody>
						</table>
					</td>
					<?}?>
				<?}?>
			</tr><!------------------------------ part 목록 끝 -------------------------------------------------->

			<?if ($loadPage == "30_22") { //수령(판매자) 개별 '완료'버튼 2016-04-25 : 삭제, odr 단위로 '완료(입금)' 처리
				
				?>
				<!--tr class="bg-none"><td colspan="<?=$colspan?>"><div class="btn-area t-rt">
				<?if (QRY_CNT("odr_history", "and odr_idx =$odr_idx and odr_det_idx = $odr_det_idx and status = 15") == 0 && QRY_CNT("odr_history", "and odr_idx =$odr_idx and odr_det_idx = $odr_det_idx and status = 6") > 0 ){?>
				<a href="#" class="complete"  odr_history_idx="<?=get_any("odr_history", "odr_history_idx" , "odr_idx =$odr_idx and odr_det_idx = $odr_det_idx and status = '6'")?>"><img src="/kor/images/btn_complete.gif" alt="완료"></a>
				<?}?>
				</div></td></tr-->
			<?}elseif($loadPage=="18_1_04"){ //------------------- 반품 선적 ------------------------------------------
					$ship = get_ship($ship_idx);
			?>
				<tr>
					<td colspan="13" class="t-ct">
						<hr class="dashline2">
						<img src="/kor/images/btn_shipping_info.gif" alt="선적정보">
					</td>
				</tr>
				<tr class="bg-none">
					<td colspan="13">
						<table class="detail-table mr-t0" align="center">
							<tbody>
								<tr>
									<td class="c-red2">운송회사&nbsp;:&nbsp;&nbsp;<img src="/kor/images/icon_<?=strtolower(GF_Common_GetSingleList("DLVR",$ship[ship_info]))?>.gif" alt=""> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;운송장번호&nbsp;:&nbsp;&nbsp;<input type="text" class="i-txt2 c-blue t-rt" name="delivery_no" id="delivery_no" style="width:96px"></td>						
								</tr>
								<tr>
									<td class="c-red2">반품 선적 서류 - <span lang="en">Download</span>&nbsp;:&nbsp;&nbsp;<a href="#" class="btn-view-sheet-18-1-05" odr_idx="<?=$odr_idx?>" odr_det_idx="<?=$odr_det_idx?>" for_readonly=""><img src="/kor/images/btn_none_commercial_invoice.gif" alt="Non-Commercial Invoice"></a> <a href="#" class="btn-pop-3018" ver="black"><img src="/kor/images/btn_packing_list.gif" alt="Packing List"></a> <a href="#" class="btn-pop-18-1-08"  ship_idx="<?=$ship[ship_idx]?>" ship_type="<?=$ship[ship_type]?>"><img src="/kor/images/btn_return_statment.gif" alt="반품 사유서"></a></td>
								</tr>
								<?if($ship[delivery_addr_idx] > 0){?>
									<tr>								
										<td lang="ko" colspan="2" bgcolor="#FFFFCC" style="text-align:left;">
											<?=GET_ODR_DELIVERY_ADDR($ship[delivery_addr_idx]);?>
											<!--
											<table class="table-type1-1" lang="ko">
												<tr>
													<td class="t-lt"><img src="/kor/images/nation_title_<?=$addr_row[nation];?>.png" alt="<?=GF_Common_GetSingleList("NA",$addr_row[nation])?>"></td>
												</tr>
												<tr>
													<td class="t-lt">회사명 : <?=$addr_row[com_name];?></td>
												</tr>
												<tr>l
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
									</tr>
								<?}?>
							</tbody>
						</table>
					</td>
				</tr>
				<?}?>

			<?				
			$ListNO--;		
			}	//$cnt(레코드 수) 만큼 반복 끝
			if ($loadPage=="04_01"){
				echo shipping_info($odr_idx);
			}
		?>
		</tbody>
<?	}
}
//***************************************************** //GET_ODR_DET_LIST **********************************************************************
function GET_ODR_DET_LIST_VT($loadPage, $part_type, $searchand){   //part_type별 odr list 출력 View 테이블 호출하는 '발주'창에서 사용
	global $file_path;
	if ($part_type){
		$searchand .= " and b.part_type =$part_type "; 
	}
	$cnt = QRY_CNT("odr_det a left outer join part b on  a.part_idx = b.part_idx ",$searchand);

	$result =QRY_ODR_DET_LIST(0,$searchand,0,"","asc");
	$i = 0;
	global $session_mem_idx;

	switch ($loadPage) {
	   case "05_04_v":
			$colspan="14";
	   break;
	 } // end of writch
	if ($cnt > 0){	
		while($row = mysql_fetch_array($result)){
			$i++;		
			$odr_det_idx = replace_out($row["odr_det_idx"]);
			$part_idx= replace_out($row["a.part_idx"]);
			$part_no= replace_out($row["part_no"]);
			$part_type= replace_out($row["part_type"]);
			$nation= replace_out($row["nation"]);
			$sell_mem_idx= replace_out($row["mem_idx"]);
			$manufacturer= replace_out($row["manufacturer"]);
			$package= replace_out($row["package"]);
			$dc= replace_out($row["dc"]);
			$rhtype= replace_out($row["rhtype"]);
			$quantity= replace_out($row["quantity"]);
			$period= replace_out($row["period"]);
			$odr_quantity= replace_out($row["odr_quantity"]);
			$supply_quantity= replace_out($row["supply_quantity"]);
			$fault_quantity= replace_out($row["fault_quantity"]);
			$part_condition= replace_out($row["part_condition"]);
			$pack_condition1= replace_out($row["pack_condition1"]);
			$pack_condition2= replace_out($row["pack_condition2"]);			 
			$memo= replace_out($row["memo"]);
			$file1= replace_out($row["file1"]);
			$file2= replace_out($row["file2"]);
			$file3= replace_out($row["file3"]);
			$file= replace_out($row["mem_idx"]);
			$rel_idx= replace_out($row["rel_idx"]);
			$price= replace_out($row["price"]);			
			$odr_idx = replace_out($row["odr_idx"]);			
			$amend_yn = replace_out($row["amend_yn"]);			
			$ship_idx= replace_out($row["ship_idx"]);			
			if ($part_type =="2"){
					$dc = "NEW";
					$quantity="";
			}
			if ($i == 1){
			?>
				<tbody id="tbd_<?=$part_type?>">
				<tr>
					<td colspan="<?=$colspan?>" class="title-box <?if ($part_type=="1"){?>first<?}?>" style="padding-top:0px;">
						<h3 class="title"><img src="/kor/images/stock_title0<?=$part_type?>.gif" alt="<?=GF_Common_GetSingleList("PART",$part_type)?>"></h3>
						<?if ($loadPage=="05_04"){?><div class="txt_stock" style="display: none; float:right; width:136px; padding:0 0 0 0;"><img src="/kor/images/txt_stock.gif" alt="재고수량 이하로 입력"></div><?}?>
					</td>
				</tr>
			<?
			} //end if($i==1)
			?>
				<tr id="tr_<?=$odr_det_idx?>">
					<td class="c-red pd-0">
						<?$del_possible_yn = (($part_type=="2"||$part_type=="5"||$part_type=="6") && $period !="" ) || ($part_type !="2" && $part_type != "5" && $part_type != "6") ? "Y":"N";
						if ($del_possible_yn =="Y" && $loadPage=="09_01" && $amend_yn=="N"){
								$del_possible_yn="N";
						}
						?>						
						
						<span id="del_1_<?=$odr_det_idx?>" style="display:<?if($del_possible_yn=="Y"){?>none<?}?>;"><img src="/kor/images/btn_delete2_1.gif" alt="삭제"></span>
						<span id="del_<?=$odr_det_idx?>" style="display:<?if($del_possible_yn=="N"){?>none<?}?>;"><button type="button" onclick="del('odr_det',<?=$odr_det_idx?>)"><img src="/kor/images/btn_delete2.gif" alt="삭제"></button></span>
					
					</td>
				</tr>
			<?
		}//end while
		?>
		</tbody>
		<?
	}//end if($cnt>0)
}
//***************************************************** //GET_ODR_DET_LIST_V2 *****************************************************************
function GET_ODR_DET_LIST_V2($searchand ,$loadPage , $for_readonly="", $temp_yn=0){   //sheet용
	global $charge_type;
	global $session_mem_idx;
	global $sheets_no;

?>
	<table>
	<thead>
		<tr>
			<th scope="col">No.</th>
			<th scope="col" class="t-lt" width="194px">Part No.</th>
			<th scope="col" class="t-lt" width="300px">Description</th>
			<th scope="col" class="t-rt" width="66px">Quantity</th>
			<?if ($for_readonly != "P"){?>
			<th scope="col" class="t-rt" width="66px">Unit Price</th>
			<th scope="col">Lead Time</th>
			<th scope="col" class="t-rt" width="73px">Amount</th>
			<?}?>
		</tr>
	</thead>
	<tbody>
<?
	$cnt = QRY_CNT("odr_det a left outer join part b on  a.part_idx = b.part_idx ",$searchand);							
	$result =QRY_ODR_DET_LIST(0,$searchand,0,"","asc");
	$tot = 0;
	while($row = mysql_fetch_array($result)){
			$i++;				
			$part_idx= replace_out($row["part_idx"]);
			$part_type= replace_out($row["part_type"]);
			$odr_idx= replace_out($row["odr_idx"]);
			if($temp_yn){ //2017-01-18 : '송장'(30_08) 작성단계에서 'INVOICE'에 임시테이블 데이터 보여주기
				$part_no= get_any("part_temp", "part_no", "odr_idx=$odr_idx and part_idx=$part_idx and type='after'");
				$manufacturer= get_any("part_temp", "manufacturer", "odr_idx=$odr_idx and part_idx=$part_idx and type='after'");
				$package= get_any("part_temp", "package", "odr_idx=$odr_idx and part_idx=$part_idx and type='after'");
				$dc= get_any("part_temp", "dc", "odr_idx=$odr_idx and part_idx=$part_idx and type='after'");
				$rhtype= get_any("part_temp", "rhtype", "odr_idx=$odr_idx and part_idx=$part_idx and type='after'");
			}else{
				$part_no= replace_out($row["part_no"]);
				$manufacturer= replace_out($row["manufacturer"]);
				$package= replace_out($row["package"]);
				$dc= replace_out($row["dc"]);
				$rhtype= replace_out($row["rhtype"]);
			}
			$nation= replace_out($row["nation"]);
			$manufacturer= replace_out($row["manufacturer"]);
			$package= replace_out($row["package"]);
			$dc= replace_out($row["dc"]);
			$rhtype= replace_out($row["rhtype"]);
			$quantity= replace_out($row["quantity"]);
			$odr_quantity= replace_out($row["odr_quantity"]);
			$supply_quantity= replace_out($row["supply_quantity"]);
			$fault_quantity= replace_out($row["fault_quantity"]);
			//$price= replace_out($row["price"]); //2016-05-27 : price 를 odr_price로 변경
			$price= replace_out($row["odr_price"]);
			$odr_det_idx = replace_out($row["odr_det_idx"]);	
			$part_condition = replace_out($row["part_condition"]);
			$pack_condition1 = replace_out($row["pack_condition1"]);
			$pack_condition2 = replace_out($row["pack_condition2"]);
			$memo = replace_out($row["memo"]);
			$period = replace_out($row["period"]);
			$pay_cnt = QRY_CNT("odr_history", "and odr_idx=$odr_idx AND status=5");
			if ($loadPage=="19_1_04"){
				$odr_quantity = $fault_quantity;
			}

			if ($loadPage=="12_07" && !$sheets_no){ //수정발주서 Sheet(Purchase Order Amendment)
				$odr_quantity = get_any("odr_det_temp" , "odr_quantity", "odr_det_idx= '$odr_det_idx' ");
			}

			if ($loadPage=="30_09" && !$sheets_no){ //수정발주서 Sheet(Purchase Order Amendment)
				$supply_quantity = get_any("odr_det_temp" , "supply_quantity", "odr_det_idx= '$odr_det_idx' ");
				$part_condition = get_any("odr_det_temp" , "part_condition", "odr_det_idx= '$odr_det_idx' ");
				$pack_condition1 = get_any("odr_det_temp" , "pack_condition1", "odr_det_idx= '$odr_det_idx' ");
				$pack_condition2 = get_any("odr_det_temp" , "pack_condition2", "odr_det_idx= '$odr_det_idx' ");
				$memo = get_any("odr_det_temp" , "memo", "odr_det_idx= '$odr_det_idx' ");				

			}

			//금액이 정수면 ,2 실수면 ,4 포멧 20161202 박정권
			if( ($price == (int)$price) )
			{					
				$price_val = number_format($price,2);
				$total_price = number_format(round_down($odr_quantity*$price,2),2);

			}
			else {			
				$price_val = $price;
				$total_price = $odr_quantity*$price;
			}
			
			if ($loadPage!="12_07_v"){ //수정발주서 Sheet(Purchase Order Amendment)
				$extra = "";
				if($part_condition) { $extra .=($extra==""?"<BR>":", "). GF_Common_GetSingleList_LANG("PARTCOND",$part_condition,"_en");}
				if($pack_condition1) { $extra .=($extra==""?"<BR>":", "). GF_Common_GetSingleList_LANG("PACKCOND1",$pack_condition1,"_en");}
				if($pack_condition2) { $extra .=($extra==""?"<BR>":"/ "). GF_Common_GetSingleList_LANG("PACKCOND2",$pack_condition2,"_en");}				
			}

			if ($part_type =="2"){
					$dc = "NEW";
					$quantity="";
				}

				if ($part_type =="7"){ //턴키------------------------------
				?>
				<tr>
					<td><?=$i?></td>
					<td class="t-lt" colspan="2"><?=get_cut($part_no,65,"..")?></td>
					<td class="t-rt"><?=$odr_quantity==0?"":number_format($odr_quantity)?></td>
					<td class="t-rt">$<?=$price_val?></td>
					<td><?=($period)?( QRY_CNT("odr_history", "and  odr_idx = $odr_idx and status = 19 ")>0?"Stock":$period):(($part_type=="2"||$part_type=="5"||$part_type=="6")?"<span lang='ko' class='c-red'>확인</span>":"Turnkey")?></td>
					<td class="t-rt"><?if ($loadPage!="18_2_09"){?>$<?=$total_price?><?}?></td>
				</tr>
				<?
				
				$sql = "select * from part where turnkey_idx = $part_idx order by part_idx";
				//echo $sql;
				$conn = dbconn();	
				$result_t=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
					while($row_t = mysql_fetch_array($result_t)){
						$k++;
						$price_t= replace_out($row_t["price"]);
						$part_no= replace_out($row_t["part_no"]);
						$manufacturer= replace_out($row_t["manufacturer"]);
						$package= replace_out($row_t["package"]);
						$dc= replace_out($row_t["dc"]);
						$rhtype= replace_out($row_t["rhtype"]);
						$quantity= replace_out($row_t["quantity"]);
						$odr_quantity_t= replace_out($row_t["odr_quantity"]);

						$part_idx = get_any("part" , "part_idx", "part_no= '$part_no' ");
				?>
						<tr>
							<td>T-<?=$k?></td>
							<td class="t-lt" ><?=$part_no?></td>
							<td class="t-lt"><?=$manufacturer?>, <?=$package?>, <?=$dc?>, <?=$rhtype?><?=$extra?></td>
							<td class="t-rt"><?=$odr_quantity_t==0?"":number_format($odr_quantity_t)?></td>
							<td class="t-rt"></td>
							<td>Turnkey</td>
							<td class="t-rt"></td>
						</tr>
					<?}?>
				
			<?
				}else{  //턴키가 아닐경우....
			?>
				<?if($loadPage == "30_17"){	//---- Commercial Invoice?>
					<tr>
						<td><?=$i?><input type="hidden" name="odr_det_3017[]" value="<?=$odr_det_idx?>"></td>
						<td class="t-lt"><?=$part_no?></td>
						<td class="t-lt"><?=$manufacturer?>, <?=$package?>, <?=$dc?>, <?=$rhtype?><?=$extra?></td>
						<td class="t-rt">
							<input type="text" class="i-txt2 onlynum numfmt t-rt" maxlength="10" name="odr_quantity[]" id="odr_qty_<?=$odr_det_idx;?>" value="<?=$odr_quantity==0?"":number_format($odr_quantity)?>" onblur="calcu_amount();" style="width:100%; ">
						</td>
						<td class="t-rt">
							<input type="text" class="i-txt2 t-rt" maxlength="8" name="unit_price[]" id="unit_price_<?=$odr_det_idx;?>" value="<?=$price==0?"":"$".$price_val?>" style="width:100%;">
						</td>
						<td><?=($period)?( QRY_CNT("odr_history", "and  odr_idx = $odr_idx and status = 19 ")>0?"Stock":$period):(($part_type=="2"||$part_type=="5"||$part_type=="6")?"<span lang='ko' class='c-red'>확인</span>":"Stock")?></td>
						<td class="t-rt">
							<input type="text" class="i-txt0 t-rt" maxlength="10" name="amount[]" id="amount_<?=$odr_det_idx;?>" value="$<?=$total_price;?>" style="width:70px;">
						</td>
					</tr>
				<?}else{ //---------- 공통(턴키 아니고, 30_17 아닌것) ------------
					//2016-09-04 : 판매자 송장(Invoice) 30_09 에서 Quantity는 발주수량이 아닌, '공급수량'
					global $pay_invoice;

					if($loadPage != "12_07" && $loadPage != "19_1_04"){//수정 발주서 Sheet(Purchase Order Amendment)
						$odr_quantity = ($supply_quantity)? $supply_quantity : $odr_quantity;
						$total_price = number_format(round_down($odr_quantity*$price,2),2);

					}

					if ($loadPage=="30_05")
					{
						$extra = "";

						$odr_quantity = (replace_out($row["odr_quantity"]))? replace_out($row["odr_quantity"]) : $odr_quantity;
						$total_price = number_format(round_down($odr_quantity*$price,2),2);

					}
					
				?>
					<tr>
						<td><?=$i?></td>
						<?

						if ($loadPage=="30_09" && !$sheets_no)
						{ 

							$invreg_chk2 = get_any("part", "invreg_chk", "part_idx=$part_idx");
							$tbl_where = "";
							if ($invreg_chk2 ==1)
							{
								$tbl = "part";
							}
							else
							{
								$tbl = "part_temp";
							}
							
						}
						else
						{
							if ($loadPage=="30_05" && $sheets_no)
							{
								$history_chk = QRY_CNT("odr_history", " and etc1 = '$sheets_no' and status = 2 and status_name='발주서' ");

								if ($history_chk)
								{
									$tbl_where = " and type='before'";
								}
								else
								{
									$tbl_where = " and type='after'";
								}
								$tbl = "part_temp";
							}
							else
							{
								$tbl = "part";
							}
							
						}
						$sql = "select * from ".$tbl." where part_idx = $part_idx ".$tbl_where ;
						//echo $sql;
						$conn = dbconn();	
						$result_part=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
						while($row_part = mysql_fetch_array($result_part)){							
							$part_no= replace_out($row_part["part_no"]);
							$manufacturer= replace_out($row_part["manufacturer"]);
							$package= replace_out($row_part["package"]);
							$dc= replace_out($row_part["dc"]);
							$rhtype= replace_out($row_part["rhtype"]);
						}
						?>
						<td class="t-lt"><?=$part_no?></td>
						<?if ($pay_invoice=="D"){?>
							<td class="t-lt"><?=$manufacturer?>, <?=$package?>, <?=$dc?>, <?=$rhtype?><?=$extra?></td>
						<?}else{?>
							<td class="t-lt"><?=$manufacturer?>, <?=$package?>, <?=$dc?>, <?=$rhtype?><?=$extra?></td>
						<?}?>
						<?if ($for_readonly == "P"){?>
						<td class="t-rt">
							<input type="text" class="i-txt2 onlynum numfmt t-rt" maxlength="10" name="odr_quantity[]" id="odr_qty_<?=$odr_det_idx;?>" value="<?=$odr_quantity==0?"":number_format($odr_quantity)?>"  style="width:100%; ">
						</td>
						<?}else{?>
							<td class="t-rt"><?=number_format($odr_quantity)?></td>
							<td class="t-rt">$<?=$price_val?></td>
							<?
							$day_val ="";
							if($part_type==2)
							{
								$day_val = "WK";
							}

							?>
							<td><?=($period)?( QRY_CNT("odr_history", "and  odr_idx = $odr_idx and status = 19 ")>0?"Stock":$period.$day_val):(($part_type=="2"||$part_type=="5"||$part_type=="6")?"<span lang='ko' class='c-red'>확인</span>":"Stock")?></td>
							<td class="t-rt">
								<?//2016-10-02 : 지속적... 계약금에서는 'Amount' 표시 무.
								//if ($loadPage!="18_2_09" && !($loadPage=="30_09" && $part_type=="2" && $pay_invoice=="D") ){
								//2017-05-08 교체
								if ($loadPage!="18_2_09" ){
									echo "$".$total_price;

								}
								?>
							</td>
						<?}?>
					</tr>
				<?}//end if($loadPage == "30_17")?>
			<? //end of 턴키
				}
				$part_no_val .= $part_idx.",";
				$tot = $tot + ($odr_quantity*$price);

			$ListNO--;		
			}

$odr_no = get_any("odr", "odr_no", "odr_idx=$odr_idx");
$odr_no_cnt = QRY_CNT("odr_history", "and  fault_odrno ='$odr_no'");

?>

<?if ($loadPage=="18_2_09" || ($loadPage=="19_1_04" && $odr_no_cnt == 0)){//부대비용일때 (판매자 책임. 구매자 반품후 환불 원할때)
//계산법 다시 듣고 수정하기!!
/** JSJ
$freight = $tot * 0.01;
$bankingchg = $tot * 0.001;
**/
$freight = get_any("odr", "buyer_delivery_fee", "odr_idx=$odr_idx");
$bankingchg = 0;

$tot =  $tot + $freight + $bankingchg ;
?>
	<tr><td><?=$i+1?></td><td colspan="2" class="t-lt"> Freight </td><td colspan="3">&nbsp; </td><td class="t-rt">$<?=number_format($freight,2)?></td></tr>
	<!--tr><td><?=$i+2?></td><td colspan="2" class="t-lt"> Banking Charge  </td><td colspan="3">&nbsp; </td><td class="t-rt">$<?=number_format($bankingchg,2)?></td></tr-->
	
<?}
$part_no_val = $part_no_val."-1";
?>

</tbody>
	</table>	
	<input type="hidden" name="part_no_val" id="part_no_val" value="<?=$part_no_val?>" />
	<?
		

if ($for_readonly != "P") {?>
	<ul class="total-price">
		<?
		global $row_buyer;
		global $row_seller;
		global $pay_invoice;	//뒤순서가 어떤 결제완료인지 파악 D:10%, F:90%


		$buyer_idx = $row_buyer['mem_idx'];

		$ship_idx = get_any("ship","delivery_addr_idx","odr_idx='$odr_idx'");
		
		//$ship_nation = get_any("delivery_addr","nation","delivery_addr_idx='$ship_idx'");
		if($ship_idx == 0 || $ship_idx == "")
		{
			$ship_nation = get_any("member","nation","mem_idx=$buyer_idx");
		}
		else
		{
			$ship_nation = get_any("delivery_addr","nation","delivery_addr_idx=$ship_idx");
		}	
		//echo $ship_nation."ASDFASDFASDFASDFASDFASDF";
		
		//히스토리 부분 송장클릭시 잘못나옴 
		$pay_cnt =QRY_CNT("odr_history", "and odr_idx = $odr_idx and status = 5");  // 기존에 이 odr로 pay 2번 한 적이 있는지. 있다면 지속에다가 + 수정 발주 들어간 것.

		if (!$pay_invoice)
		{
			if ($pay_cnt ==2)
			{
				$pay_invoice = "F";
			}
			else
			{
				$pay_invoice = "D";
			}
		}


		if ((($row_buyer["nation"] == 1 && $row_seller["nation"] ==1) || ($row_seller["nation"]==$ship_nation)) && ($loadPage=="30_09" || $loadPage=="19_1_04"))
		{	
			$tot_vat_minus = $tot;

			$vat_price = get_any("ship" ,"tax", "odr_idx=".$_GET['odr_idx']." limit 1");	//부가세

			if($vat_price==0)
			{
				$vat_price = get_any("tax" ,"tax_percent", "nation=$ship_nation ");	//부가세
			}
			
			if (($vat_price == (int)$vat_price))
			{
				$vat_price = number_format($vat_price);
			}
			else
			{
				$vat_price = number_format($vat_price,2);
			}
	
			$vat_val = $vat_price/100;
			$vat_plus =  $tot*$vat_val;	
			$tot = $tot + $vat_plus;
			$tot_val = $tot;

		}

		if( ($tot == (int)$tot) )
		{
			$total_val = $tot;
			$tot = round_down($tot,2);
			$tot_vat_minus = round_down($tot_vat_minus,2);
			$vat_plus = round_down($vat_plus,2);

			$tot = number_format($tot,2);
			$tot_vat_minus = number_format($tot_vat_minus,2);
			$vat_plus = number_format($vat_plus,2);
		}
		else {
			$total_val = $tot;
			$tot = round_down($tot,4);
			$tot_vat_minus = round_down($tot_vat_minus,4);
			$vat_plus = round_down($vat_plus,4);

			$tot = number_format($tot,4);
			$tot_vat_minus = number_format($tot_vat_minus,4);
			$vat_plus = number_format($vat_plus,4);
		}
		
		if ($pay_cnt ==2){	$searchand .= " and part_type = 2";}
		$sql = "select part_type, period from odr_det where 1=1 $searchand";		
		$conn = dbconn();	
		$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());		
		if ($result){
			$row = mysql_fetch_array($result);				
			$part_type = replace_out($row["part_type"]);
			//$period = replace_out($row["period"]); //JSJ 입고되면 odr_det 테이블의 period가 'stock'으로 바뀌므로 오류.
			//odr 의 period 가져오기
			$period = get_any("odr","period","odr_idx=$odr_idx");
		}


		//지속적(납기3주이상)--------------------------------------
		if ($part_type == 2 && $period*1 > 2 && $for_readonly=="" && $loadPage != "30_05"&& $loadPage != "12_07") { 
			
			if ($pay_invoice =="F"){	//잔금 계산-----
				
			?>
				<li class="sub"><strong>Sub Total :</strong><span>$<?=$tot_vat_minus?>	</li>
			<?
				$word ="Rest Amount(90%)";
				// tot의 90%를 무조건 하면 안되고, 수정 발주 된 내역이 있을 가능성도 있기 때문에 mybank에서 실제로 지불한 10%값을 가져와서  tot- 지불값 한 금액이 실제 지불해야 할 금액이다.
				$down = get_any("mybank" ,"charge_amt", "odr_idx=$odr_idx and mem_idx=".$_SESSION["MEM_IDX"]." and rel_idx = ".$_SESSION["REL_IDX"]);	

				$tot = str_replace(",","",$tot);
				$tot = round_down($tot,4) + round_down($down,4);   //더하기. ( 왜냐하면 down 자체가 마이너스 값이니까)
				if( ($down == (int)$down) )
				{
					$down = number_format($down,2);
				}
				else 
				{					
					$down = number_format($down,4);
				}
				$tax_name = get_any("tax", "tax_name", "nation=$row_seller[nation]");
				
			?>
				
				<li class="sub  c-red"><strong>Down Payment :</strong><span>-$<?=round_down(str_replace("-","",$down),4)?></span></li>	
				<li class="sub"><strong><?=$tax_name?> :</strong><span>$<?=$vat_plus?></span></li>			
			<?}else{	//계약금 계산-------		
				$tot = str_replace(",","",$tot_vat_minus);
				
				$tot = ($tot / 10);

				$tot = round_down($tot,4);

				$charge_type = "2";
				if( ($tot == (int)$tot) )
				{
					$tot = number_format($tot,2);
				}
				else
				{
					$tot = number_format($tot,4);
				}
				
				?>
				<li class="sub"><strong>Down Payment :</strong><span>$<?=$tot?>	</li>							
			<?}
		}else{

			$tax_name = get_any("tax", "tax_name", "nation=$row_seller[nation]");

		?>			
						
			<?

			if ((($row_buyer["nation"] == 1 && $row_seller["nation"] ==1) || ($row_seller["nation"]==$ship_nation)) && ($loadPage=="30_09" || $loadPage=="19_1_04"))
			{	

			?>
				<li class="sub"><strong>Sub Total :</strong><span id="sub_total">$<?=$tot_vat_minus?></span></li>	
				<li class="sub"><strong><?=$tax_name?> :</strong><span>$<?=$vat_plus?></span></li>		
			<?
			}
			else
			{				
			?>
				<li class="sub"><strong>Sub Total :</strong><span id="sub_total">$<?=$tot?></span></li>	
			<?			
			}
			?>
		<?}?>
		
		<?

		if($loadPage=="30_05" || $loadPage=="30_09"){
			//2016-11-25 : 아래 선불 배송비 입니다. - KSR

			$ship_idx = get_any("odr", "ship_idx", "1=1 and odr_idx=$odr_idx");
			$shipping_charge = get_any("ship", "shipping_charge", "ship_idx='$ship_idx'");

			if($shipping_charge>0){
				echo "<li class=\"sub\"><strong>Shipping Charge : </strong><span>$".number_format($shipping_charge,2)."</span></li>";
				$tot = (double)$total_val + (double)$shipping_charge;
				if( ($tot == (int)$tot) )
				{
					$tot = number_format($tot,2);
					$tot_vat_minus = number_format($tot_vat_minus,2);
					$vat_plus = number_format($vat_plus,2);
				}
				else {
					$tot = number_format($tot,4);
					$tot_vat_minus = number_format($tot_vat_minus,4);
					$vat_plus = number_format($vat_plus,4);
				}
			}
		}

		//보증금..
		$deposit_cnt = QRY_CNT("odr_history" , "and odr_idx=$odr_idx and (sell_mem_idx=".$_SESSION["MEM_IDX"]." or buy_mem_idx=".$_SESSION["MEM_IDX"].") and status_name = '송장'");	
		?>
		<?if ($_SESSION["DEPOSIT"]=="N" && $deposit_cnt>=1){?>
			<!-- 대표님 요청으로 display:none -->
			<li class="sub"><strong>Deposit :</strong><span>$1,000.00	</li>
		<?
			$deposit_val = (double)"1000";
			
			if ($pay_invoice=="D")
			{
				$tot = str_replace(",","",$tot);
				$tot = $tot+1000 + $shipping_charge  ;
			}
			else
			{				
				$tot = $total_val + (double)$shipping_charge + 1000;
			}
			
			if( ($tot == (int)$tot) )
			{
				$tot = number_format($tot,2);
				$tot_vat_minus = number_format($tot_vat_minus,2);
				$vat_plus = number_format($vat_plus,2);
			}
			else {
				$tot = number_format($tot,4);
				$tot_vat_minus = number_format($tot_vat_minus,4);
				$vat_plus = number_format($vat_plus,4);
			}
		}


		?>

		<input type="hidden" name="tot" id="tot_<?=$odr_idx?>" value="<?=$tot?>"></span></li>
		<?
/*
		if( (str_replace(",","",$tot) == (int)$tot) )
		{
			$tot = number_format($tot,2);
		}
		else {
			$tot = number_format($tot,4);
		}*/
		?>
		<li class="total"><strong>Total :</strong><span id="g_total">$<?=$tot?></span></li>
	
	</ul>
		<?
		$won_change = agency_won();
		
		if ($_GET['forread'] == "")
		{
			if ((($row_buyer["nation"] == 1 && $row_seller["nation"] ==1) || ($row_seller["nation"]==$ship_nation)) && $loadPage=="30_09" && ($_SESSION["MEM_IDX"]==$row_buyer["mem_idx"]))
			{	
		?>
			<ul class="total-price-ko">						
				<li class="total"><strong>Total  :</strong><span id="g_total">￦<?=number_format($won_change*$tot_val,2)?></span></li>	
			</ul>
		<?
			}
		}
		?>
	
	<?}?>
<?}
//-------------------------------------------------------------------GET_ODR_HISTORY_LIST ----------------------------------------------------------------------------------------/
function GET_ODR_HISTORY_LIST($loadPage, $odr_idx ,$odr_det_idx=""){
	global $session_mem_idx;
	global  $pay;
	global $status;

	$searchand = "and odr_idx = '$odr_idx' ";
	if ($odr_det_idx !=""){ //개별 History가 있다면....
		$searchand .= " and (odr_det_idx = '$odr_det_idx' or odr_det_idx = 0 or odr_det_idx is null) ";
	}

//	if ($loadPage == "01_37"||$loadPage == "09_03" ||$loadPage == "30_10" ||  $loadPage == "30_20" || $loadPage == "30_22" || $loadPage == "30_23"){ 
		$det_cnt = QRY_CNT("odr_det", $searchand);   //한 odr_idx당 odr_det 개수가 몇개인지 따라 1개이면 전체 다 표시. 한개 이상이면 odr_det=0 or null 인것만 표시
		if ($det_cnt >1) { 
			$searchand .= " and (odr_det_idx = 0 or odr_det_idx is NULL) ";
		}
//	}

	if (QRY_CNT("odr_history", "and odr_idx=$odr_idx and status=3")>0) {
		$amend_yn = "Y"; // 수정발주서 여부
		$startmodi = false;   //변수 초기화 
	}else{
		$amend_yn = "N";
	}

	if ($loadPage=="30_23")
	{
		$searchand .= " and odr_det_idx = '$odr_det_idx' and a.status = 6 ";
	}

	if ($loadPage == "31_04"){   //판매자 납기 페이지. 납기 top 1만 표시
		$searchand .= " and status = 1 and confirm_yn = 'N'";
		$result = QRY_ODR_HISTORY_LIST(1,$searchand , 1 ,"odr_history_idx ");
	}elseif ($loadPage == "31_06") {  //구매자 납기 확인 페이지
		$result = QRY_ODR_HISTORY_LIST(2,$searchand , 1 ,"odr_det_idx , odr_history_idx ");
		//2016-03-29
		$odr=get_odr($odr_idx);
		$odr_status = $odr[odr_status];
	}else{
		
		$result = QRY_ODR_HISTORY_LIST(0,$searchand , 1 ,"odr_history_idx ");

	}

	
?>
<!-- layer-step(거래단계 표기) -->
	<input type="hidden" name="odr_idx" id="odr_idx_<?=$loadPage?>" value="<?=$odr_idx?>">
	<input type="hidden" name="odr_status" id="odr_status_<?=$loadPage?>" value="<?=$odr_status?>">
	<input type="hidden" name="loadPage" id="loadPage" value="<?=$loadPage?>">
	<?if ($loadPage!="31_04" && $loadPage!="31_06"  && $loadPage!="19_1_05"){ //납기확인 전까지는 history 필요없댐, 환불완료 메시지창?>
	<?if ($status != 7){?>
	<div class="layer-step">
		<ol>
		<?					
			while($row = mysql_fetch_array($result)){
				
				$i++;				
				$odr_history_idx = replace_out($row["odr_history_idx"]);
				$reg_date_fmt= replace_out($row["reg_date_fmt"]);
				$status = replace_out($row["status"]);
				$status_name = replace_out($row["status_name"]);
				$reg_mem_idx = replace_out($row["reg_mem_idx"]);
				$etc1= replace_out($row["etc1"]);
				$etc2= replace_out($row["etc2"]);	
				$reason= replace_out($row["reason"]);	
				$file1= replace_out($row["file1"]);	
				$file2= replace_out($row["file2"]);
				$cls = "";
				$etc_change = "";
				if ($status == "3"){
					$startmodi = true;  //수정발주서 일때 표시 조건
					$red=" red";
					//$etc_change = "change_img";	//직접수령,다른운송업체 제외하고 이미지 출력 위한 변수
				}
				
				$cls = "class='$red'";
				
				//if ($amend_yn =="N" && $det_cnt >="1"|| $amend_yn == "Y" && $startmodi== true){ //JSJ 수정발주서 일경우 앞단계 미표시
				if ($amend_yn =="N" && $det_cnt >="1"|| $amend_yn == "Y"){ //2016-04-19 : 수정발주서 여부 상관없이 전체 히스토리 표시
					if ($status =="5") { $pay = $etc2;}
					if ($session_mem_idx != $reg_mem_idx)
					{
						$cls = "class='c1$red'";
						$etc_change = "change_img";
					}
					if ($status== "9" || $status== "10"  || $status =="24"){
						$cls = "class='c2$red'";
						if ($session_mem_idx == $reg_mem_idx){$cls = "";}
						$etc2 = ($etc2 == "1")? "-교환":(($etc2 == "2")? "-환불":($etc2==""?"":"-".$etc2));
					}


				
				?>
					<li <?=$cls?>>
						<span class="date"><?=$reg_date_fmt?></span>
						<strong class="status"><?=$status_name?></strong>
						<?
						if (($loadPage=="30_20" || $loadPage=="30_22" || $loadPage=="30_23" || $loadPage=="19_08" || $loadPage=="30_20_F" || $loadPage=="19_06" || $loadPage=="30_22_F" || $loadPage=="18R_16" || $loadPage=="18R_19" || $loadPage=="18R_08" || $loadPage=="18R_06" || $loadPage=="19_1_06") && ($status_name=="선적완료" || $status_name=="추가선적완료" || $status_name=="반품방법" || $status_name=="반품선적완료")){
							if ($etc2=="직접 수령")
							{	
						?>
							<span class="etc"><span ><?=$etc2?></span></span>
						<?}else{?>
							<span class="etc"><span ><?if ($etc2){echo openSheet($status, $etc2,$odr_idx,$etc_change,$odr_history_idx);}?></span></span>
						<?}?>
						<?}else{?>
							<span class="etc"><span ><?if ($etc1){echo openSheet($status, $etc1,$odr_idx,$etc_change,$odr_history_idx);}?>
								<?if ($status== "9" || $status== "10"  || $status =="11"){?>							
									<?=$etc2?>
								<?}?>
							</span></span>

						<?}?>
						
					</li>
			<?}
			}  //end of while
			?>
		</ol>
	</div>
	<?}else{
		//삭제를 위한 idx
		$odr_history_idx = get_any("odr_history", "odr_history_idx", "odr_idx = $odr_idx order by odr_history_idx desc limit 1");
	}?>

	<?} //end if($loadPage != "31_04") ?>
	<!-- //layer-step -->
	<?echo layerFile($loadPage,$reg_mem_idx , $reg_rel_idx , $odr_idx ,$odr_history_idx);
	  
}//------------------------------------------------------------------- //GET_ODR_HISTORY_LIST ----------------------------------------------------------------------------------------/
	function layerFile($loadPage,$reg_mem_idx , $reg_rel_idx , $odr_idx, $odr_history_idx){ // 상태 메세지...
		global  $pay;
		if ($loadPage == "31_04" || $loadPage == "31_06" || $loadPage == "02_02" || $loadPage == "03_02")
		{
			$style_css="style='border-top:0'";
		}

		?>
	<!-- layer-file -->
	<div class="layer-file" id="file_<?=$loadPage?>" <?=$style_css?>>
		<table>
			<tbody>
				<tr><?
					  //$reg_rel_idx = get_any("member", "rel_idx" , "mem_idx = $reg_mem_idx");	
					  $buy_rel_idx = get_any("odr", "rel_idx", "odr_idx = $odr_idx");
					  $sell_mem_idx = get_any("odr", "sell_mem_idx", "odr_idx = $odr_idx");
					  $sell_nation_idx = get_any("member", "nation", "mem_idx = $sell_mem_idx");
					  $buy_com_idx = $buy_rel_idx == 0 ? get_any("odr", "mem_idx", "odr_idx = $odr_idx") : $buy_rel_idx;
					  $result_mem =QRY_MEMBER_VIEW("idx",$buy_com_idx);
					  $row_mem = mysql_fetch_array($result_mem);
					  $buy_com_nation = $row_mem["nation"];
					  $buy_com_name = $row_mem["mem_nm_en"];	
					  global $file_path;
					   $odr_his=get_odr_history($odr_history_idx);
					   $odr_det_idx = $odr_his[odr_det_idx];
					   $odr_det = get_odr_det_each($odr_det_idx);
					   $fault_quantity = $odr_det[fault_quantity];
					   $file1 = $odr_his[file1];
					   $file2 = $odr_his[file2];
					   $etc1 = $odr_his[etc1];
					   $etc2 = $odr_his[etc2];
					   $with_deposit = $odr_his[with_deposit];
					   $return_method = $odr_his[return_method];
					   $fault_select = $odr_his[fault_select];
					   $fault_accept = $odr_his[fault_accept];
					   $memo = $odr_his[reason];
					   
					switch ($loadPage) {
						case "02_02":
					?>
						<td class="t-ct" style="font-size:14px;"><span class="c-red2" >판매자가 품목을 삭제하였습니다.</span></td>
						</tr></tbody></table></div>
					<?
						echo layerOrdListData($loadPage ,$odr_idx,$odr_det_idx);
						   break;
						case "06_02":							
						?>				
						<td class="t-ct">사유 : <span class="c-red2"><?=$memo?></span></td>
						</tr></tbody></table></div>
					<?	  
						   echo layerOrdListData($loadPage ,$odr_idx,$odr_det_idx);
						   break;
						case "03_02":?>
						<td class="company" style="width:33%;"><img src="/kor/images/nation_title_<?=$buy_com_nation?>.png" alt="<?=GF_Common_GetSingleList("NA",$buy_com_nation)?>"> </td>
						<td class="c-red2" style="width:33%;text-align:center;font-size:15px;">구매자가 품목을 삭제하였습니다.</td>
						<td style="width:33%;""></td>
						</tr></tbody></table></div>
					<?
							echo layerInvListData($loadPage ,$odr_idx,$odr_det_idx , $odr_history_idx);
							break;
						case "18R_19": //-------------------------------- 반품 선적 완료(18R_19) 운송정보 -------------------------
						$ship_idx = get_any("ship", "ship_idx", "odr_det_idx", $odr_det_idx);
						$ship = get_ship($ship_idx);
						?>
						<td class="company" colspan="2"><img src="/kor/images/nation_title_<?=$buy_com_nation?>.png" alt="<?=GF_Common_GetSingleList("NA",$buy_com_nation)?>"> <span class="name c-blue"><a href="javascript:layer_company_det('<?=$buy_com_idx?>');" class="c-blue"><?=$buy_com_name?></a></span></td>
						<td class="c-red2 t-rt">
							운송회사&nbsp;:&nbsp;&nbsp;<img src="/kor/images/icon_<?=strtolower(GF_Common_GetSingleList("DLVR",$ship[ship_info]))?>.gif" alt=""> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;운송장번호&nbsp;:&nbsp;&nbsp;<span class="c-blue"><?=$ship[delivery_no];?></span>
						</td>
					</tr>
					<tr>
						<td><?if ($fault_select){?><div class="re-select"><strong>선택</strong><?if ($fault_select=="1"){?><em>교환</em><?}else{?><em>반품</em><?}?></div><?}?></td>
						<td class="c-red2 t-ct">반품 선적이 완료되었습니다.</td>
						<?if ($return_method=="2"){?>
						<td class="c-red2 t-rt">반품 선적 서류 : <a class="btn-view-sheet-18-1-05" href="#"  odr_idx="<?=$odr_idx?>" odr_det_idx="<?=$odr_det_idx?>" for_readonly="Y"><img alt="Non-Commercial Invoice" src="/kor/images/btn_none_commercial_invoice.gif"></a> <a class="btn-view-sheet-18-1-05" href="#"  odr_idx="<?=$odr_idx?>" odr_det_idx="<?=$odr_det_idx?>" for_readonly="P"><img alt="Packing List" src="/kor/images/btn_packing_list.gif"></a></td>
						<?}else{?>
						<td class="t-ct w100 c-red">모든 처리가 완료되었습니다.</td>
						<?}?>
					
					</tr></tbody></table></div>
					<?	  
						   echo layerInvListData($loadPage ,$odr_idx,$odr_det_idx,$odr_history_idx); //18R_19
							break;
						case "19_1_05": //-------------------------------- 환불완료창 -------------------------
						$ship_idx = get_any("ship", "ship_idx", "odr_det_idx", $odr_det_idx);
						$ship = get_ship($ship_idx);
						?>
						<td class="company" colspan="2"><img src="/kor/images/nation_title_<?=$buy_com_nation?>.png" alt="<?=GF_Common_GetSingleList("NA",$buy_com_nation)?>"> <span class="name"><a href="javascript:layer_company_det('<?=$buy_com_idx?>'); " class="c-blue"><?=$buy_com_name?></a></span></td>
						<td class="c-red2 t-ct">환불(<span class="c-blue" lang="en">금액표시</span>)이 완료되었습니다.</td>
						<td class="t-rt"><div class="re-select"><strong>선택</strong><?if ($fault_select=="1"){?><em>교환</em><?}else{?><em>반품</em><?}?></div></td>
					</tr></tbody></table></div>
					<?	  
						   echo layerInvListData($loadPage ,$odr_idx,$odr_det_idx,$odr_history_idx); //18R_19
						   break;
					   case "30_06":?><!----------------------------- 30_06 : 판매자 '발주서' 탭 ---------------------------------------->
					<td class="company" style="width:33%">
						<img src="/kor/images/nation_title_<?=$buy_com_nation?>.png" alt="<?=GF_Common_GetSingleList("NA",$buy_com_nation)?>"> &nbsp&nbsp<span class="name"><a href="javascript:layer_company_det(<?=$buy_com_idx?>);" class="c-blue"><?=$buy_com_name?></a></span>
					</td>
					<td class="c-red2 " style="width:33%;text-align:center;font-size:15px;">
						발주서가 도착했습니다.
					</td>
					<td class="c-red2 w100 t-ct" style="width:33%;"></td>				
					</tr></tbody></table></div>
					<?	  
						   echo layerOrdListData($loadPage ,$odr_idx); //-- 실제 발주 목록 --------------//
						   break;
						  case "09_03":?>
					<td class="company" style="width:33%;"><img src="/kor/images/nation_title_<?=$buy_com_nation?>.png" alt="<?=GF_Common_GetSingleList("NA",$buy_com_nation)?>"> <span class="name"><a href="javascript:layer_company_det('<?=$buy_com_idx?>');" class="c-blue"><?=$buy_com_name?></a></span></td>
					<td class="c-red2" style="width:33%;text-align:center;font-size:15px;">수정발주서가 도착했습니다.</td>
					<td class="c-red2 w100 t-ct" style="width:33%;"></td>		
					</tr></tbody></table></div>
					<?	  
						   echo layerOrdListData($loadPage ,$odr_idx);
						   break;
						case "30_10":?>
					<td class="c-red2 t-ct" style="font-size:15px;">송장이 도착했습니다.</td>
					</tr></tbody></table></div>	
					<?
						   echo layerInvListData($loadPage ,$odr_idx);
						   break;	
						case "30_15":  //-----------------------------------------30_15 What's New : 결제 완료(판매자) ------------------------------------------------------------------

					?>
					<td class="company" style="width:33%;"><img src="/kor/images/nation_title_<?=$buy_com_nation?>.png" alt="<?=GF_Common_GetSingleList("NA",$buy_com_nation)?>"> 
					<span class="name c-blue">
					<a href="javascript:layer_company_det('<?=$buy_com_idx?>');" class="c-blue"><?=$buy_com_name?></a>
					</span></td>
					<td class="c-red2 " style="width:33%;text-align:center;font-size:14px;">
					<?
					$pay = str_replace("$","",$pay);		

					if( ($pay == (int)$pay) )
					{
						$pay_val = round_down($pay,2);
						$pay_val = number_format($pay,2);
					}
					else
					{
						$pay_val = round_down($pay,4);
						$pay_val = number_format($pay,4);
					}
					
					if($odr_his[charge_ty] == "D"){
						echo "계약금 [<strong class='c-blue'><span lang='en'>".$etc1."- $".str_replace("$","",$pay_val ); 
					}else if ($_SESSION["MEM_IDX"] == $odr_his[buy_mem_idx] && $with_deposit=="Y"){
						echo "보증금, 총 금액 (<strong class='c-blue'><span lang='en'>$"; 
						$deposit ="1000";
						echo number_format(floatval(trim(str_replace("입금","",str_replace("$","",$pay_val )))) + $deposit,2);
					}else{$deposit=0;
						/*
						if (strpos(preg_replace("/\s/",'',$pay),"[M/B]") >= 0)
						{
							$pay = str_replace("[M/B]","My Bank-",$pay);							
						}
						elseif (strpos(preg_replace("/\s/",'',$pay),"[W/T]") >= 0)
						{
							$pay = str_replace("[W/T]","은행송금-",$pay);
						}
						elseif (strpos(preg_replace("/\s/",'',$pay),"[C/C]") >= 0)
						{
							$pay = str_replace("[C/C]","신용카드-",$pay);
						}		*/	
						
						
						echo "총 금액 (<strong class='c-blue'><span lang='en'>".$etc1."- $".$pay_val; 
					}?></span></strong>] 결제가 완료되었습니다.</td>
					<td class="c-red2 w100 t-ct" style="width:33%;"></td>	
					</tr></tbody></table></div>	
					<?
							echo layerInvListData($loadPage ,$odr_idx,$odr_det_idx,$odr_history_idx);  //JSJ
						   break;	
						case "30_14":  //-----------------------------------------30_14 What's New : 결제 완료(구매자), 반품 부대비용 ---------------------------------------------------------------
					?>
					<td><?if ($fault_select){?><div class="re-select"><strong>선택</strong><?if ($fault_select=="1"){?><em>교환</em><?}else{?><em>반품</em><?}?></div><?}?></td>
					<td class="c-red2 w100 t-ct">
					<?if ($odr_idx>0){
						echo "부대비용 (<strong class='c-blue'><span lang='en'>".$etc1."- $".$pay;
					}else{
						echo "My Bank 충전 (<strong class='c-blue'><span lang='en'>US ".$etc1;	
					}
					?>	</span></strong>) 결제가 완료되었습니다.
					</td>
					</tr></tbody></table></div>	
					<?
							echo layerInvListData($loadPage ,$odr_idx, $odr_det_idx , $odr_history_idx);
						   break;	
						case "19_1_05":  //----------------------------------------------------------------------------------------------------------
					?>
					<td class="company"><img src="/kor/images/nation_title_<?=$buy_com_nation?>.png" alt="<?=GF_Common_GetSingleList("NA",$buy_com_nation)?>"> <span class="name c-blue"><a href="javascript:layer_company_det('<?=$buy_com_idx?>');" class="c-blue"><?=$buy_com_name?></a></span></td>
					<td class="c-red2 w100 t-ct">총 금액 (<strong class="c-blue"><span lang="en">$ <?=$pay?></span></strong>) 결제가 완료되었습니다.</td>
					</tr></tbody></table></div>	
					<?
						   echo layerInvListData($loadPage ,$odr_idx);
						   break;	
					case "30_20": //----------------------------------- What's New : 선적 완료(정상거래) --------------------------------------------------------------------------					
					$delivery_no	 = get_any("ship","delivery_no", "odr_idx = $odr_idx AND ship_type=1"); //2016-05-17 : add shipt_type
					$ship_info	 = get_any("ship","ship_info", "odr_idx = $odr_idx AND ship_type=1"); //2016-05-17 : add shipt_type

					$other_shop = get_any("odr_history","etc2", "odr_idx = $odr_idx and status=21");
					?>
					<?if ($ship_info!="6") {?>
						<td class="c-red2" style="font-size:14px;">운송회사 
						<?if ($ship_info=="5") {?>
							<span class="c-blue">: <?=$other_shop?></span>
						<?}else{?>
							<img src="/kor/images/icon_<?=strtolower(GF_Common_GetSingleList("DLVR",$ship_info))?>.gif" height="20" alt="" style="margin-bottom:2px;">
						<?}?>
						<?if ($ship_info!="6") {?>
						&nbsp;&nbsp;&nbsp;<span >운송장번호</span> : <span class="c-blue"><?=$delivery_no?></span></td>
						<?}?>
					<?}else{?>
						<td class="c-red2" style="font-size:14px;"><span><?=$other_shop?></span>
					<?}?>

					<?
					$ship_idx = get_any("ship","delivery_addr_idx","odr_idx='$odr_idx'");
		
					//$ship_nation = get_any("delivery_addr","nation","delivery_addr_idx='$ship_idx'");
					if($ship_idx == 0 || $ship_idx == "")
					{
						$ship_nation = get_any("member","nation","mem_idx=$buy_com_idx");
					}
					else
					{
						$ship_nation = get_any("delivery_addr","nation","delivery_addr_idx=$ship_idx");
					}	
					//$ship_nation = get_any("delivery_addr","nation","delivery_addr_idx=$ship_idx");
				
					if ($sell_nation_idx != $ship_nation)
					{
					?>
						<td class="c-red2 t-rt" style="font-size:14px;">선적서류<span lang="en"><!--Download--></span> <a href="#" class="btn-view-sheet-3011" for_readonly="Y"><img src="/kor/images/btn_commercial_invoice.gif" alt="Commercial Invoice"></a> <a href="#"  class="btn-view-sheet-3011" for_readonly="P"><img src="/kor/images/btn_packing_list.gif" alt="Packing List"></a></td>
					<?
					}
					?>
					
					</tr></tbody></table></div>	
					<?
						   echo layerInvListData($loadPage ,$odr_idx);
						   break;	
					case "30_20_F": //----------------------------------- What's New : 선적 완료(FAULT) --------------------------------------------------------------------------
					case "30_22_F": //----------------------------------- What's New : 수령(FAULT) --------------------------------------------------------------------------
						$delivery_no	= get_any("ship","delivery_no", "odr_idx = $odr_idx and odr_det_idx = $odr_det_idx AND ship_type=5");
						$ship_info	= get_any("ship","ship_info", "odr_idx = $odr_idx and odr_det_idx = $odr_det_idx AND ship_type=5");
					?>
						<td colspan="3" class="c-red2 t-rt">운송회사  <img src="/kor/images/icon_<?=strtolower(GF_Common_GetSingleList("DLVR",$ship_info))?>.gif" height="15" alt=""> &nbsp;&nbsp;&nbsp;운송장번호 : <span lang="en" class="c-blue"><?=$delivery_no?></span></td>
					</tr>
					<tr>
						<td class="c-red2"><?if ($fault_select){?><div class="re-select"><strong>선택</strong><em><?=GF_Common_GetSingleList("FAULT",$fault_select);?></em></div><?}?></td>
						<td class="c-red2 w100 t-ct" style="font-size:14px;"><?=($loadPage=="30_22_F")? "구매자가 제품을 문제없이 수령하였습니다.":"";?></td>
						<td class="c-red2 t-rt">선적서류 <span lang="en"><!--Download--></span> : <a href="#" class="btn-view-sheet-3011" for_readonly="Y"><img src="/kor/images/btn_commercial_invoice.gif" alt="Commercial Invoice"></a> <a href="#"  class="btn-view-sheet-3011" for_readonly="P"><img src="/kor/images/btn_packing_list.gif" alt="Packing List"></a></td>
						</tr></tbody></table></div>
						<?
							   echo layerInvListData($loadPage ,$odr_idx, $odr_det_idx, $odr_history_idx);
							   break;	
						   case "30_22":  //--------------------------  수령(구매자) 30_22 메세지 ------------------------------------------------?>
						<td class="company" style="width:33%;"><img src="/kor/images/nation_title_<?=$buy_com_nation?>.png" alt="<?=GF_Common_GetSingleList("NA",$buy_com_nation)?>"> <span class="name c-blue"><a href="javascript:layer_company_det('<?=$buy_com_idx?>');" class="c-blue"><?=$buy_com_name?></a></span></td>
						<td class="c-red2" style="width:33%;text-align:center;font-size:15px;">구매자가 제품을 문제없이 수령하였습니다.</td>							
						<td class="c-red2" style="width:33%;"></td>
					</tr></tbody></table></div>	
					<?
						   //echo layerOrdListData($loadPage ,$odr_idx); //JSJ
						   echo layerOrdListData($loadPage ,$odr_idx, $odr_det_idx); //2016-05-18
						   break;
					case "30_23": //--------------------------------------------- 수령 ----------------------------------------------------------------------
					?>
					<td class="company"></td>
					<td class="c-red2 w100 t-ct">제품을 문제없이 수령하였습니다.</td>
					</tr></tbody></table></div>	
					<?
						   echo layerInvListData($loadPage ,$odr_idx);
						   break;
					case "31_04":?>
					<td class="company" style="width:33%;">
						<img src="/kor/images/nation_title_<?=$buy_com_nation?>.png" alt="<?=GF_Common_GetSingleList("NA",$buy_com_nation)?>"> <span class="name"><!--<?=$buy_com_name?>--></span>
					</td>
					<td class="c-red2  t-ct" style="width:33%;font-size:14px;">납기 확인 바랍니다.</td>
					<td class="c-red2  t-ct" style="width:33%;"></td>	
					</tr></tbody></table></div>	
					<?
						   echo layerOrdListData($loadPage ,$odr_idx, $odr_det_idx);
						   break;
						   case "31_06":?><!----------------------------------------------------- 구매자 : 납기확인 완료 ------------------------------------------------------>
					<td class="c-red2 w100 t-ct" style="font-size:14px;">납기 확인이 완료되었습니다.</td>
					</tr></tbody></table></div>	
					<?
						   echo layerInvListData($loadPage ,$odr_idx);
						   break;
						   case "01_37":?>
					<td class="c-red2 t-ct">물품이 입고되었고 선적 준비 중입니다.<br><br>
					추가 공급 가능 수량: <span class="c-blue" lang="en">
					<?$add_capa=get_any("odr_history","etc1","odr_idx=$odr_idx and status=19");
					
					if ($add_capa){echo str_replace("EA","",$add_capa);}					
					?></span> <span lang="en">EA</span> </td>
					</tr></tbody></table></div>	
					<?	   echo layerInvListData($loadPage ,$odr_idx);
						   break;
						   case "18R_06":	//------------------------------------------------- 판매자 : '거절 ---------------------------------------------------------------------------

					?>
					<td class="company">
						<img src="/kor/images/nation_title_<?=$buy_com_nation?>.png" alt="<?=GF_Common_GetSingleList("NA",$buy_com_nation)?>"> <span class="name c-blue"><a href="javascript:layer_company_det('<?=$buy_com_idx?>');" class="c-blue"><?=$buy_com_name?></a></span>
					</td>
					<td class="c-red2 w100 t-ct">
						<?if(strlen($fault_select)>0){?>구매자가 <?=($fault_select=="1")? "교환":"반품";?>을 <?=($fault_accept=='Y')? "승인":"요청";?>하였습니다.<?}?>
					</td>
					<td><?if ($fault_select){?><div class="re-select"><strong>선택</strong><?if ($fault_select=="1"){?><em>교환</em><?}else{?><em>반품</em><?}?></div><?}?></td>
					</tr></tbody></table></div>
					<?
							echo layerInvListData($loadPage ,$odr_idx, $odr_det_idx , $odr_history_idx);
						   break;   
						   case "18R_08":	//------------------------------------------------- 구매자 : '거절' ---------------------------------------------------------------------------
					?>
							<!-- 2016-05-04 : 히스토리 아래(아이템 위쪽) 사진파일, memo 부분 삭제 -->
							<td></td>
							<td><?if ($fault_select){?><div class="re-select"><strong>선택</strong><?if ($fault_select=="1"){?><em>교환</em><?}else{?><em>반품</em><?}?></div><?}?></td>
							<td class="c-red2 w100 t-ct"><?if(strlen($fault_select)>0){?>판매자가 <?=($fault_select=="1")? "교환":"반품";?>을 요청하였습니다.<?}?></td>
							<?/**
							<td class="file t-rt">
								<span class="c-blue" lang="ko">파일 / 사진 : </span>
								<?if ($file1){?><a href="<?=get_noimg($file_path,$file1,"javascript:;")?>" <?if ($file1){?>target="_blank"<?}?>>File1</a><?}else{?>File1,<?}?> <?if ($file2){?><a href="<?=get_noimg($file_path,$file2,"javascript:;")?>" target="_blank">File2</a><?}else{?>File2<?}?>
								<span class="img-wrap"><?if ($file1){?><a href="<?=get_noimg($file_path,$file1,"/kor/images/file_pt.gif")?>" target="_blank"><img <?=get_noimg_photo($file_path, $file1, "/kor/images/file_pt.gif")?>  alt=""></a><?}else{?><img <?=get_noimg_photo($file_path, $file1, "/kor/images/file_pt.gif")?>  alt=""><?}?></span>
								<span class="img-wrap"><?if ($file2){?><a href="<?=get_noimg($file_path,$file1,"/kor/images/file_pt.gif")?>" target="_blank"><img <?=get_noimg_photo($file_path, $file2, "/kor/images/file_pt.gif")?> alt=""></a><?}else{?><img <?=get_noimg_photo($file_path, $file2, "/kor/images/file_pt.gif")?>  alt=""><?}?></span>
							</td>
							**/?>
						</tr>
						<!--tr>
							<td><?if ($fault_select){?><div class="re-select"><strong>선택</strong><?if ($fault_select=="1"){?><em>교환</em><?}else{?><em>반품</em><?}?></div><?}?></td>
							<td class="file-memo">Memo : <strong><?=$memo?></strong></td>
						</tr-->
						</tbody></table></div>
					<?		 echo layerInvListData($loadPage ,$odr_idx, $odr_det_idx , $odr_history_idx);
						   break;   
						   case "19_06": // ------------------------------------------------ 수량 부족(판매자) -----------------------------------------------------------------------------------------------------
						   case "19_08": // -------------------------------------------------수량 부족(구매자) -----------------------------------------------------------------------------------------------------
					?>
								<td class="company">
									<img src="/kor/images/nation_title_<?=$buy_com_nation?>.png" alt="<?=GF_Common_GetSingleList("NA",$buy_com_nation)?>"> <span class="name c-blue"><a href="javascript:layer_company_det('<?=$buy_com_idx?>');" class="c-blue"><?=$buy_com_name?></a></span>
								</td>
								<td class="c-red2 w100 t-ct" style="font-size:14px;">
									<?if(strlen($fault_select)>0){?><?=($loadPage=="19_06")? "구매자":"판매자";?>가 <?=($fault_select=="3")? "추가선적":"환불";?>을 <?=($fault_accept=='Y')? "승인":"요청";?>하였습니다.<?}?>
								</td>
								<td class="t-rt">
									<?if ($fault_select){?><div class="re-select"><strong>선택</strong><?if ($fault_select=="3"){?><em>추가선적</em><?}else{?><em>환불</em><?}?></div><?}?></td>
								</td>
								
							</tr>
							<!--tr>
								<td class="file t-rt">
								<span class="c-blue" lang="ko">파일 / 사진 : </span>
								<?if ($file1){?><a href="<?=get_noimg($file_path,$file1,"javascript:;")?>" <?if ($file1){?>target="_blank"<?}?>>File1</a><?}else{?>File1,<?}?> <?if ($file2){?><a href="<?=get_noimg($file_path,$file2,"javascript:;")?>" target="_blank">File2</a><?}else{?>File2<?}?>
								<span class="img-wrap"><?if ($file1){?><a href="<?=get_noimg($file_path,$file1,"/kor/images/file_pt.gif")?>" target="_blank"><img <?=get_noimg_photo($file_path, $file1, "/kor/images/file_pt.gif")?>  alt=""></a><?}else{?><img <?=get_noimg_photo($file_path, $file1, "/kor/images/file_pt.gif")?>  alt=""><?}?></span>
								<span class="img-wrap"><?if ($file2){?><a href="<?=get_noimg($file_path,$file1,"/kor/images/file_pt.gif")?>" target="_blank"><img <?=get_noimg_photo($file_path, $file2, "/kor/images/file_pt.gif")?> alt=""></a><?}else{?><img <?=get_noimg_photo($file_path, $file2, "/kor/images/file_pt.gif")?>  alt=""><?}?></span>
							</td>
							</tr>
							<tr>
							<td><?if ($fault_select){?><div class="re-select"><strong>선택</strong><?if ($fault_select=="3"){?><em>추가선적</em><?}else{?><em>환불</em><?}?></div><?}?></td>
								<td class="file-memo">Memo : <strong><?=$memo?></strong></td>
							</tr-->
							</tbody></table></div>
						 <?echo layerInvListData($loadPage ,$odr_idx,$odr_det_idx,$odr_history_idx);
								break;
							case "19_1_06": //-------------------------------------- 환불(19_1_16) -------------------------------------------------------?>
							<?
							$etc = str_replace("$","",$etc2);	

							if( ($etc == (int)$etc) )
							{
								$pay_val = round_down($etc,2);
								$pay_val = number_format($etc,2);
							}
							else
							{
								$pay_val = round_down($etc,4);
								$pay_val = number_format($etc,4);
							}
							?>
							<td><div class="re-select"><strong>선택</strong><em><?=GF_Common_GetSingleList("FAULT",$fault_select)?></em></div></td>
								<td class="c-red2 w100 t-ct" style="font-size:14px;">환불 (<strong class="c-blue"><span lang="en"><?=$etc1."- $".$pay_val?></span></strong>) 완료되었습니다.</td>
								<td class="t-rt"><!-- 수량부족 문구 삭제 2016-05-11
									<?if ($fault_quantity!=""){?>
									<div class="red-box"><input type="hidden" id="fault_quantity" value="<?=$fault_quantity?>"><span>부족 수량 개수 </span><strong lang="en"><?=str_replace("EA", "</strong><span lang='en'>EA",$fault_quantity."EA")?></strong></div><?}?>-->
								</td>
							</tr>
							</tbody></table></div>
						 <?echo layerInvListData($loadPage ,$odr_idx,$odr_det_idx,$odr_history_idx);
								break;
						   case "18R_16":	//------------------------------------- 반품 방법(구매자) ------------------------------------------------
						   $return_method = $odr_his[return_method];
						   //반품 배송방법 정보
						   $ship_idx = get_any("ship", "ship_idx", "odr_idx=$odr_idx and odr_det_idx = $odr_det_idx" );
						   $ship = get_ship($ship_idx);
						   if($ship[delivery_addr_idx] > 0){
							   $addr_row = get_delivery_addr($ship[delivery_addr_idx]);
						   }
						?>
							<td colspan="2">
								<table style="border:0; padding:5px;">
									<tr>
										<td Style="width:600px;" class="c-red2 t-lt">운송회사  <img src="/kor/images/icon_<?=strtolower(GF_Common_GetSingleList("DLVR",$ship[ship_info]))?>.gif" alt=""> &nbsp;&nbsp;&nbsp;<span lang="en"><font color='black'>Account No.</font></span> <span lang="en" class="c-blue"><?=$ship[ship_account_no]?></span></td>
									
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td><div class="re-select"><strong>선택</strong><em><?=$fault_select=="1"?"교환":"반품"?></em></div></td>
							<td class="c-red2 w100 t-ct"><span lang="ko"><input type="hidden" name="return_method" id="return_method" value="<?=$return_method?>"><?if ($return_method=="1"){ echo "반품포기";}?></span></td>
							<?if(strlen($ship[memo])>0){?><td colspan="2">Memo : <span class="c-red"><?=$ship[memo];?></span></td><?}?>
						</tr>
						</tbody></table></div>
					<?	     echo layerInvListData($loadPage ,$odr_idx,$odr_det_idx,$odr_history_idx);
						   break;
						   case "08_02":   //지연?>
						   <td class="c-red2 t-ct"><span lang="en">1Week</span> 자동연장 </td>
						   </tr></tbody></table></div>							
				   <?	    echo layerInvListData($loadPage ,$odr_idx,$odr_det_idx,$odr_history_idx);
						    break;
						   case "10_02":   //납기 연장?>
						   <td class="c-red2 t-ct">판매자가 <?=$etc1?> 더 연장 요청하였습니다.</td>
						   </tr></tbody></table></div>							
				   <?	    echo layerInvListData($loadPage ,$odr_idx,$odr_det_idx,$odr_history_idx);
						    break;
							case "13_04": // 취소 동의. 구매자에게 판매자 계약금 지급동의(JSJ) -----------------------------------------------------------------------------------------------------------
					?>
							<td class="t-ct w100 c-red">판매자가 취소 요청에 동의하였습니다. 판매자의 계약금은 구매자에게 지급됩니다. </td>
							</tr></tbody></table></div>	
							<?echo layerInvListData($loadPage ,$odr_idx,$odr_det_idx,$odr_history_idx);
						    break;
							case "13_04s": // 2016-04-13 : 판매자가 '송장' 단계에서 품목선택 취소 -----------------------------------------------------------------------------------------------------------
					?>
							<td class="t-ct w100 c-red" style="width:33%;text-align:center;font-size:15px;">판매자가 물품을 취소하였습니다.</td><!-- 2016-04-13 : 일단 메세지 없이 -->
							</tr></tbody></table></div>	
							<?echo layerInvListData($loadPage ,$odr_idx,$odr_det_idx,$odr_history_idx);
						    break;							
						   case "10_04":   //-------------------------------------------------------------납기 연장 확인 ------------------------------------------------
					?>
						   <td class="company"><img src="/kor/images/nation_title_<?=$buy_com_nation?>.png" alt="<?=GF_Common_GetSingleList("NA",$buy_com_nation)?>"> <span class="name c-blue"><a href="javascript:layer_company_det('<?=$buy_com_idx?>');" class="c-blue"><?=$buy_com_name?></a></span></td>
					<td class="c-red2 w100 t-ct">구매자가 연장 요청<?if ($fault_select=="Y"){echo "을 수락하였습";}else{echo " 확인중 입";}?>니다. </td>
						   </tr></tbody></table></div>							
				   <?	    echo layerInvListData($loadPage ,$odr_idx,$odr_det_idx,$odr_history_idx);
						    break;
							case "13_02": //취소?>
							<td class="company"><img src="/kor/images/nation_title_<?=$buy_com_nation?>.png" alt="<?=GF_Common_GetSingleList("NA",$buy_com_nation)?>"> <span class="name "><a href="javascript:layer_company_det('<?=$buy_com_idx?>');" class="c-blue"><?=$buy_com_name?></a></span></td>
					<td class="t-ct w100 c-red">판매자가 납기를 어겨 구매자가 거래를 취소하였습니다. <br><br>
					판매자의 계약금은 구매자에게 지급됩니다. </td>
					</tr></tbody></table></div>		
							<? echo layerInvListData($loadPage ,$odr_idx,$odr_det_idx,$odr_history_idx);
						    break;
							case "13_02s": //취소?>
							<td class="company" style="width:33%;"><img src="/kor/images/nation_title_<?=$buy_com_nation?>.png" alt="<?=GF_Common_GetSingleList("NA",$buy_com_nation)?>"> <span class="name"><a href="javascript:layer_company_det('<?=$buy_com_idx?>');" class="c-blue"><?=$buy_com_name?></a></span></td>
					<td class="c-red2" style="width:33%;text-align:center;font-size:15px;">구매자가 품목을 취소하였습니다.</td>	
					<td style="width:33%;"></td>
					</tr></tbody></table></div>		
							<? echo layerInvListData($loadPage ,$odr_idx,$odr_det_idx,$odr_history_idx);
						    break;
							case "04_01": //발주서 저장?>
							<td class="company"></td>
							</tr></tbody></table></div>		
						<?	echo layerInvListData($loadPage ,$odr_idx,$odr_det_idx,$odr_history_idx);
						   break;
					case "1304_accept": //수락?>
							<td class="company"></td>
							</tr></tbody></table></div>		
						<?	echo layerInvListData($loadPage ,$odr_idx,$odr_det_idx,$odr_history_idx);
						   break;
					   }?>
		
	
	<!-- //layer-file -->
	<?}

	//---------------------------------------------------------------------------------------------------------------------------------------------------------
	function layerOrdListData($loadPage ,$odr_idx , $odr_det_idx=""){ // History 목록에서의 odr_det 내역
		$turnkey_cnt = QRY_CNT("odr_det"," and odr_idx=$odr_idx and part_type=7 ");  //턴키
		$part_chk = QRY_CNT("odr_det"," and odr_idx=$odr_idx and (part_type=2 or part_type=5 or part_type=6) ");  //지속적, 해외, 국내
		
	?>
		<!-- layer-data -->
	<input type="hidden" name="odr_idx" id="odr_idx_<?=$loadPage?>" value="<?=$odr_idx?>">
	<div class="layer-data">
		<table class="stock-list-table">
			<thead>
				<tr>
					<th scope="col" class="t-no">No.</th>
					<?if ($loadPage=="02_02"){?><th scope="col" class="t-nation">Nation</th><?}?>
					<th scope="col" class="t-partno" style="width:250px;"><?=($turnkey_cnt>0)? "Title":"Part No.";?></th>
					<th scope="col" class="t-Manufacturer" style="width:180px;"><?=($turnkey_cnt>0)? "":"Manufacturer";?></th>
					<th scope="col" class="t-Package"><?=($turnkey_cnt>0)? "":"Package";?></th>
					<th scope="col" class="t-dc"><?=($turnkey_cnt>0)? "":"D/C";?></th>
					<th scope="col" class="t-rohs"><?=($turnkey_cnt>0)? "":"RoHS";?></th>
					<th scope="col" class="t-oty"><?=($turnkey_cnt>0)? "":"O'ty";?></th>
					<th scope="col" class="t-unitprice"><?=($turnkey_cnt>0)? "":"Unit Price";?></th>
					<?if ($loadPage == "30_22"){?>
					<th scope="col" class="t-amount">Amount</th>
					<?}else{?>					
					<th scope="col" class="delivery t-orderoty" lang="ko"><?=($turnkey_cnt>0)? "Price":"발주수량";?></th>
					<?if ($loadPage == "09_03" || ($part_chk >=1 && $loadPage != "31_04" && $loadPage != "02_02") ){?>
					<th scope="col" class="t-orderoty">공급수량</th>
					<?}?>
					<th scope="col" lang="ko" class="t-period">납기</th>
					<?}?>
				</tr>
			</thead>
			<?
				if ($odr_det_idx && $odr_det_idx !="0"){
					 $searchand = "and odr_det_idx=$odr_det_idx";
				}	
					for ($i = 1; $i<=7; $i++){
					echo GET_ODR_DET_LIST($loadPage,$i," and odr_idx=$odr_idx $searchand");
					}
			//----------------- 선적정보 -------------------------------------------
			//30_06 : 발주서(판매), 09_03 : 수정발주서
			if ($loadPage == "30_06" ||$loadPage=="09_03"){
			$result_odr = QRY_ODR_VIEW($odr_idx);    
			$row_odr = mysql_fetch_array($result_odr);
			$row_ship = get_ship($row_odr["ship_idx"]);
						
			?>
			
			<tr class="bg-none">
				<td></td>
				<td colspan="12" style="padding:0;padding-top:20px;">
					<table class="detail-table">
						<tbody>
							<tr>								
								<th scope="row" style="width:300px;padding-top:7px;">
									선적정보 : 
									<?
									if($row_ship["ship_info"]==5)
									{
									?>
										&nbsp<span class="c-blue">다른 운송업체</span> 
									<?
									}
									elseif($row_ship["ship_info"]==6)
									{
									?>
										&nbsp<span class="c-blue">직접수령</span> 
									<?
									}else{
									?>
										<span class="c-grey2">운송회사</span> &nbsp&nbsp<img src="/kor/images/icon_<?=strtolower(GF_Common_GetSingleList("DLVR",$row_ship["ship_info"]))?>.gif" style="margin-bottom:2px;" alt="" height="15">
									<?}?>
									<?
									if($row_ship["ship_info"]==5 || $row_ship["ship_info"]==6)
									{
									?>
										
									<?
									}
									elseif($row_ship["ship_info"]==6)
									{
									?>
										
									<?
									}else{
									?>
										<span lang="en"><font color='black'>&nbsp&nbspAccount No : </font></span>
										<span lang="en" class="c-blue"><?=$row_ship["ship_account_no"]?></span>									
									<?}?>
								</td>
								</th>
								
										
							</tr>
							<?if(strlen($row_ship["memo"])>0){?>
							<tr>
								<td colspan="2" ><strong class="c-black" >Memo : </strong><span class="c-blue"><?=$row_ship["memo"]?></span></td>
							</tr>
							<?}?>
							<?if($row_ship["insur_yn"]=="o"){?>
							<tr>
								<th colspan="2" scope="row">
									<span class="c-black">운송보험 :</span> <span lang="en">Yes</span>
								</th>
							</tr>
							<?}?>
							<?
								$ship_idx = get_any("ship", "ship_idx", "odr_idx=$odr_idx and odr_idx = $odr_idx" );
								$ship = get_ship($ship_idx);
							?>
							<?if($ship[delivery_addr_idx] > 0){?>

							<tr>
								<td scope="row" colspan="2" bgcolor="#FFFFCC" style="text-align:left;color:#000000;">배송지 변경</td>								
							</tr>
							<tr>								
								<td lang="ko" colspan="2" bgcolor="#FFFFCC" style="text-align:left;">
									<?=GET_ODR_DELIVERY_ADDR($ship[delivery_addr_idx]);?>
									<!--
									<table class="table-type1-1" lang="ko">
										<tr>
											<td class="t-lt"><img src="/kor/images/nation_title_<?=$addr_row[nation];?>.png" alt="<?=GF_Common_GetSingleList("NA",$addr_row[nation])?>"></td>
										</tr>
										<tr>
											<td class="t-lt">회사명 : <?=$addr_row[com_name];?></td>
										</tr>
										<tr>l
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
							</tr>
							<?}?>	
						</tbody>
					</table>
				</td>
			</tr>

			<?}//------------------------- //30_06 || 09_03 -------------------------------------?>
		</table>
	</div>


	<?if ($loadPage =="09_03"){
		echo shipping_info($odr_idx,$loadPage);
	}?>
	<!-- //layer-data -->
	<?if ($loadPage == "30_06"|| $loadPage== "09_03"){ //09_03:[판매자] '수정발주서'?>
	<?
	$etc1_val = get_any("odr_history","etc1","1=1 and odr_idx = '$odr_idx' and status_name='발주서'");
	?>
	<!-- layer-btn -->
	<div class="btn-area t-rt">
		<a href="#" class="btn-view-<?if($loadPage=="09_03"){?>amend-<?}?>sheet-forread" odr_idx="<?=$odr_idx?>" sheet_no="<?=$etc1_val?>"><img src="/kor/images/btn_order_confirm.gif" alt="발주서 확인"></a>
		<?if($loadPage== "09_03"){?>
		<!--<a href="#" class="btn-pop-0601"><img src="/kor/images/btn_cancel.gif" alt="취소"></a>-->
		<?}?>
	</div>
	<!-- //layer-btn -->
	<?}elseif ($loadPage =="30_22"){ //------------------------- 수령(판매자) 버튼 ----------------------------------------?>
		<div class="btn-area t-rt">
			<a href="#" class="btn_3022"  odr_idx="<?=$odr_idx?>"><img src="/kor/images/btn_deposit3.gif" alt="입금"></a>
		</div>
	<?}elseif ($loadPage =="02_02" || $loadPage =="06_02"){ //--------------------------------------------------------------?>
	<?$status = $loadPage =="30_22"? "6" : ($loadPage=="02_02"?"7":"8");
	
		if ($status !=6 || ($status==6 &&QRY_CNT("odr_history", "and odr_idx =$odr_idx and status=15")==0)){?>
		<div class="btn-area t-rt">
			<a href="#" class="complete"  odr_history_idx="<?=get_any("odr_history", "odr_history_idx" , "odr_idx =$odr_idx and status = $status")?>"><img src="/kor/images/btn_complete.gif" alt="완료"></a>
		</div>
	  <?}
			
	  }
	}
//---------------------- GET_ODR_DET_LIST, history 아래 버튼들---------------------------------------------------------------------------------------------------------------
	function layerInvListData($loadPage ,$odr_idx, $odr_det_idx="" , $odr_history_idx=""){ //호출 : 31_06, 13_04(구매:취소)
		global $session_mem_idx;	
		global $det_cnt;
		if ($odr_idx>0){
	?>
	<!-- layer-data -->
	<div class="layer-data" id="data_<?=$loadPage?>">
		<table class="stock-list-table" id="list_<?=$loadPage?>">
			<thead>
				<tr>
					<?if ($loadPage =="04_01" || $loadPage =="30_20"){?>
						<?if ($det_cnt > 1){?>
						<th scope="col" style="width:50px">Option</th>
						<?}?>
					<?}?>
					<th scope="col" class="t-no"  >No.</th>
					<?if ($loadPage!="18R_06" && $loadPage!="30_15" && $loadPage!="13_02s" && $loadPage != "03_02"){?><th scope="col" style="width:80px">Nation</th><?}?>
					<?
					if ($loadPage=="21_04" ){
						$part_no_style = "style='width:250px;'";
					}
					elseif( $loadPage=="30_20" || $loadPage=="30_10" || $loadPage=="30_15")
					{
						$part_no_style = "style='width:215px;'";
					}
					?>
					<th scope="col" class="t-partno" <?=$part_no_style?> >Part No.</th>					
					<th scope="col" class="t-Manufacturer" style="width:150px;">Manufacturer</th>
					<th scope="col" class="t-Package" style="width:80px;">Package</th>
					<th scope="col" class="t-dc" style="width:36px;">D/C</th>
					<th scope="col" class="t-rohs" style="width:36px;">RoHS</th>
					<?if($loadPage!="18R_19" && $loadPage!="19_1_05" && $loadPage!="19_1_06" && $loadPage != "30_14" && $loadPage != "30_22_F"){?><th scope="col" class="t-oty">O'ty</th><?}?>
					<th scope="col" class="t-unitprice" style="width:61px;">Unit Price</th>
					<?if ($loadPage=="21_04" || $loadPage=="30_15" || $loadPage=="30_20" || $loadPage=="30_14" || $loadPage == "19_06" || $loadPage == "18R_16" || $loadPage == "18R_19" || $loadPage == "18R_06"){?>
						<th scope="col" lang="en" class="t-amount" style="width:65px;">Amount</th>
						<?if ($loadPage=="30_15" || $loadPage=="30_20" || $loadPage=="30_14" || $loadPage == "19_06" || $loadPage == "18R_16" || $loadPage == "18R_19" || $loadPage == "18R_06"){?>
							<th scope="col" lang="ko" class="t-period" style="width:36px;">납기</th>
						<?}?>

					<?}else{?>
						<?if ($loadPage != "19_08" && $loadPage !="18R_05" && $loadPage !="19_06" && $loadpage != "18R_16" && $loadpage != "18R_19" && $loadPage != "18R_06" && $loadPage != "30_20_F" && $loadPage != "01_37"){?>
						<th scope="col" lang="ko" class="t-orderoty">
							<?if($loadPage == "18_1_04" || $loadPage == "18R_19" || $loadPage=="19_1_05" || $loadPage == "30_14"){?>반품수량
							<?}elseif($loadPage=="19_1_06"){?>환불수량
							<?}elseif($loadPage=="_30_20_F" || $loadPage=="30_22_F"){
								$fault_select = get_any("odr_history", "fault_select", "odr_history_idx=$odr_history_idx");
								echo ($fault_select=="1")? "교환수량":"부족수량";
							?>
							<?}else{?>발주수량<?}?>
						</th>
						<?}?>
						<?if($loadPage!="30_20_F" && $loadPage!="30_22_F" && $loadPage!="13_04s" && $loadPage != "19_08" && $loadPage !="18R_05" && $loadPage !="19_06" && $loadPage != "18R_16" && $loadpage != "18R_19" && $loadPage != "18R_06" && $loadPage != "01_37"){?><th scope="col" lang="ko" class="t-supplyoty">공급수량</th><?}?>
						<?if($loadPage=="30_20_F" || $loadPage == "30_22_F" || $loadPage=="01_37"){?><th scope="col" lang="en" class="t-amount" style="width:61px;">Amount</th><?}?>
						<?if($loadPage=="19_1_05" || $loadPage=="19_1_06"){?><th scope="col" lang="en" class="t-amount">Amount</th>
						<?}else{?><th scope="col" lang="ko" class="t-period">납기</th>
						<?}?>
					<?}?>
					<?if ($loadPage!="31_06" && $loadPage!="18R_06" && $loadPage!="04_01" && $loadPage!="03_02" && $loadPage!="30_15" && $loadPage!="18R_19" && $loadPage!="19_1_05" && $loadPage!="19_06" && $loadPage!="13_02s"){?>
						<th scope="col" class="t-company">Company</th>
					<?}?>
				</tr>
			</thead>
			<?	for ($i = 1; $i<=7; $i++){
				//echo GET_ODR_DET_LIST($loadPage,$i," and odr_idx=$odr_idx ".($odr_det_idx!="" && $odr_det_idx !="0"?"and odr_det_idx=$odr_det_idx":""));  //JSJ
				//2016-05-02 : 개별 History가 있는 아이템은 배제(odr_idx 만으로 호출 할 때...)
				//1. 'odr_det_idx NOT IN' 을 사용하기 위해서.. history 에서 odr_idx 중 odr_det_idx 있는 것만....
				$sql = "and odr_det_idx NOT IN (SELECT odr_det_idx FROM odr_history WHERE odr_det_idx > 0)";
				//아래 주석 2016-07-31 납기 받은게 품목 표기 않되서.. 
				//echo GET_ODR_DET_LIST($loadPage,$i," and odr_idx=$odr_idx ".($odr_det_idx!="" && $odr_det_idx !="0"?"and odr_det_idx=$odr_det_idx":"$sql"), "", $odr_history_idx);
				//위 에서 $sql 없이...
				echo GET_ODR_DET_LIST($loadPage,$i," and odr_idx=$odr_idx ".($odr_det_idx!="" && $odr_det_idx !="0"?"and odr_det_idx=$odr_det_idx":""), "", $odr_history_idx);
			}
			?>             
		</table>        
	</div>

	<?//--------------------------------------------------- 거절(18R_08), 수량부족 메세지 내역(주고, 받고) ---------------------------------------------------------------------------------------------
		if ($loadPage =="18R_08" || $loadPage =="18R_06" || $loadPage =="18R_16" || $loadPage =="18R_19" || $loadPage =="30_14" || $loadPage =="30_20_F" || $loadPage =="30_22_F" || $loadPage =="19_06" || $loadPage =="19_08" ){ 
			
	?>
	<div class="layer-data">
		<table class="stock-list-table">
			<tr class="bg-none">
				<td><hr class="dashline2"></td>
			</tr>
			<?
			//거절 메세지 순서대로 가져오기...
			$status = get_any("odr_history", "status", "odr_history_idx=$odr_history_idx");
			$result = QRY_RCD_MSG_LIST($odr_det_idx, $status);
			?>
			<tbody>
				<?
				$i=0;
				while($row = mysql_fetch_array($result)){
					$i++;
					$fault_select = $row["fault_select"];
					$fault_accept = $row["fault_accept"];
					$etc2 = $row["etc2"];
					$msg_history_idx = replace_out($row["odr_history_idx"]);
					$msg_reason_title = replace_out($row["reason_title"]);
					$msg_reason = $row["reason"];
					$msg_date = replace_out($row["reg_date"]);
					$fault_quantity = get_any("odr_det", "fault_quantity", "odr_det_idx=$odr_det_idx");
					
					if($i<2){
						$num = $i;
					}else{
						if($i%2 == 0){//짝수
							$num = intval($i/2);
							$color_tr = "background-color:#7030a0";
						}else{//홀수
							$num = intval($i/2)+1;
							$color_tr = "background-color:#808080";
						}
					}

					if($i%2 == 0){//짝수
						
						$color_tr = "background-color:#808080";
						
					}else{//홀수
						
						$color_tr = "background-color:#7030a0";
					}

				?>
				<tr>
					<td>
						<table Style="width:100%;">
							<tr>
								<td class="t-lt" lang="ko">
									<?if($i>1){?>
										<span style="padding-left:<?=($i-1)*30-23?>px;">└></span>
									<?}?>
									<span class="box-num" style="<?=$color_tr?>"><?=$num;?></span>
									<span class="c-red"><?if($fault_select>0 && $etc2 != ""){?>[<?=$etc2?>]<?}?></span>
									<span style="cursor:pointer;color:#00759e;" OnClick="show_msg(<?=$msg_history_idx;?>);"><?=$msg_reason_title?></span>
									<?if($fault_quantity > 0){?>
										<?if ($fault_select=='3' || $fault_select=='4'){?>
											<span class="c-red">[부족수량 : <?=$fault_quantity;?>EA]</span>
										<?}else{?>
											<span class="c-red">[거절수량 : <?=$fault_quantity;?>EA]</span>
										<?}?>										
									<?}?>
								</td>
								<td class="t-rt" lang="en" Style="width:100px; padding-right:5px;color:#00759e;"><?=date("j M Y");?></td>
							</tr>
							<tr id="msg_cont_<?=$msg_history_idx;?>" Style="display:none;">
								<td colspan="2" class="t-lt" lang="ko"><?=$msg_reason;?></td>
							</tr>
						</table>
					</td>
				</tr>
				<?}?>
			</tbody>
		</table>
	</div>
	<?}} //end of 메세지 표시할 loadPage?>


	<?
	global $bottom_30_20;
	if ($loadPage =="30_20" && $bottom_30_20>="1"){  //------------------------------ 30_20 버튼 (What's New : 선적완료) ----------------------------------------------------------------------------------------------
	?>
	<div id="guide_3020">
		<hr class="dashline2">	
		<p class="c-red2 t-ct mr-tb15">
			<img src="/kor/images/btn_notice.gif" alt="공지"><br><br>
			문제가 있는/문제가 없는 제품의 체크박스를 선택하고 진행을 원하는 버튼을 선택하십시오.
		</p>
	</div>
	<?}?>

	<!-- //layer-data -->
	<!-- layer-btn -->
	<?if ($odr_history_idx && !$odr_det_idx){$odr_det_idx = get_any("odr_history", "odr_det_idx" , "odr_history_idx = $odr_history_idx");}?>
	<div class="btn-area t-rt" odr_idx="<?=$odr_idx?>" odr_det_idx="<?=$odr_det_idx?>" odr_history_idx="<?=$odr_history_idx?>">		
	<?if ($loadPage == "30_10"){
			$rel_idx = get_any("odr", "case when sell_rel_idx = 0 then sell_mem_idx else sell_rel_idx end ","odr_idx = $odr_idx");
			$o_company_idx = get_any("assign", "o_company_idx", "rel_idx=$rel_idx and assign_type = 1");		
			$appoint_yn = get_any("ship" , "appoint_yn", "odr_idx = $odr_idx and ship_idx = 1");
	?>
		<a href="#" class="<?=$_SESSION["DEPOSIT"]=="Y"?($appoint_yn==""?"btn-view-sheet-3011":"btn-pop-1508"):"btn-pop-1706"?>" odr_idx="<?=$odr_idx?>" com_idx="<?=$_SESSION["COM_IDX"]?>" for_readonly="" o_company_idx="<?=$o_company_idx?>"><img src="/kor/images/btn_invoice_confirm.gif" alt="송장확인"></a>
		<!-- 2016-04-13 : '취소' 버튼 주석처리
		<?if(QRY_CNT("mybank", "and odr_idx = $odr_idx and charge_type ='3' and charge_method = '2' and put_money_yn is null")==0){?><a href="#" class="btn-pop-0701"><img src="/kor/images/btn_cancel.gif" alt="취소"></a><?}?>
		-->
	<?}elseif ($loadPage=="03_02"){?>
		<a href="#" class="complete" odr_history_idx="<?=$odr_history_idx?>"><img src="/kor/images/btn_complete.gif" alt="완료"></a>		
	<? //-------------------------------------------- 19_1_06 환불(구매자) 버튼 --------------------------------------------------------------------------
		}elseif ($loadPage=="19_1_06"){?>
		<a href="#" class="refund_comple" odr_idx="<?=$odr_idx;?>" odr_det_idx="<?=$odr_det_idx;?>" odr_history_idx="<?=$odr_history_idx?>"><img src="/kor/images/btn_complete.gif" alt="완료"></a>	
	<?}elseif ($loadPage=="31_06"){?><!------------------------------------------------------------ 31_06 버튼--------------------------------------->
		<a href="#" class="btn-order-periodconfirm"><img src="/kor/images/btn_order.gif" alt="발주"></a>
		<!--button type="button" class="btn-pop-0201"><img src="/kor/images/btn_delete2.gif" alt="삭제"></button-->
	<?}elseif ($loadPage =="08_02"||$loadPage =="10_04"){
	?><button type="button" class="<?=$loadPage=="10_04"?"sell-mn05":"btn-08-02"?>" history_idx="<?=$odr_history_idx;?>"><img src="/kor/images/btn_ok.gif" alt="확인"></button>
	<?}elseif ($loadPage =="13_02"){
	?><a href="#" class="btn-pop-1303" odr_history_idx="<?=$odr_history_idx?>"><img src="/kor/images/btn_accept.gif" alt="수락"></a>
	<?}elseif ($loadPage =="13_02s"){
	?><a href="#" class="btn-confirm-1304s" odr_history_idx="<?=$odr_history_idx?>"><img src="/kor/images/btn_complete.gif" alt="완료"></a>
	<?}elseif ($loadPage =="10_02"){
	?><a href="#" class="btn-pop-1003" odr_history_idx="<?=$odr_history_idx?>"><img src="/kor/images/btn_accept.gif" alt="수락"></a>
		<a href="#" class="btn-pop-1301"><img src="/kor/images/btn_order_cancel.gif" alt="발주 취소"></a>
	<?}elseif ($loadPage=="30_15"){ //----------------------------------------------------------------- 30_15 버튼 --------------------------------------------------------------------
		if ($session_mem_idx==get_any("odr", "sell_mem_idx", "odr_idx = $odr_idx")){
			$sql = "select part_type, period from odr_det where odr_idx= $odr_idx and part_type= 2";
			$conn = dbconn();	
			$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());		
			if ($result){
				$row = mysql_fetch_array($result);				
				$part_type = replace_out($row["part_type"]);
				$period = replace_out($row["period"]);			
			}			
			if ($part_type=="2" && $period*1 >2) {
				$pay_cnt = QRY_CNT("odr_history", "and odr_idx = $odr_idx and status = 5");
				if ($pay_cnt==2){    //판매자가 계약금을 지불 했으면 창고 버튼, 구매자가 잔금까지 다 치뤘으면 선적 버튼이 나온다. 
			?>	<a href="#" class="btn-pop-0135"><img src="/kor/images/btn_storage.gif" alt="창고"></a>
			<?}elseif($pay_cnt==3){
				?>
				<a href="#" class="btn-dialog-3016"><img src="/kor/images/btn_shipping.gif" alt="선적"></a>
				<?}else{//판매자가 계약금을 지불 안했으면 계약금 버튼이 나온다.?>
				<a href="#" class="btn-dialog-0129"><img src="/kor/images/btn_deposit.gif" alt="계약금"></a>
			  <?}
			}elseif(get_any("odr_history", "status", "odr_history_idx=$odr_history_idx")!="24"){	
				if ($_SESSION["DEPOSIT"]=="N") {
					
					if(QRY_CNT("mybank", "and mem_idx = ".$_SESSION["MEM_IDX"]." and rel_idx = ".$_SESSION["REL_IDX"]." and charge_type='8'")>0){?>
						<a href="javascript:alert_msg('입금확인중 입니다.');">
					<?}else{?>
					<a href="#" class="btn-pop-1706" odr_idx ="<?=$odr_idx?>"><?}?><img src="/kor/images/btn_deposit2.gif" alt="보증금"></a>	
				<?}else{?><a href="#" class="btn-dialog-3016"><img src="/kor/images/btn_shipping.gif" alt="선적"></a>
				
		<?		}	
			}
		}else{
			$status = get_any("odr","odr_status", "odr_idx=$odr_idx");
			if ($status == 5 || $status = 4 || $status ==20){?>
			<button type="button"  odr_history_idx="<?=get_any("odr_history","odr_history_idx","odr_idx= $odr_idx and status = 5 and confirm_yn = 'N'")?>" class="<?=get_any("odr_history", "status", "odr_history_idx=$odr_history_idx")!="24"?"btn-close":"complete"?>"><img src="/kor/images/btn_ok.gif" alt="확인"></button>
			<?}else{
					?>
				<button type="button" class="btn-pop-1904"><img src="/kor/images/btn_lack.gif" alt="수량부족"></button>
				<button type="button" class="btn-pop-18R04"><img src="/kor/images/btn_refuse.gif" alt="거절"></button>
				<button type="button" class="btn-dialog-3021"><img src="/kor/images/btn_receipt.gif" alt="수령"></button>
<?			}		
		}
	}elseif ($loadPage=="30_14"){ //----------- 결제 완료(구매자) CFO(confirm_yn='Y' 처리 ------------?>
		<button type="button"  odr_history_idx="<?=get_any("odr_history","odr_history_idx","odr_idx= $odr_idx and status = 5 and confirm_yn = 'N'")?>" class="completeOnly"><img src="/kor/images/btn_ok.gif" alt="확인"></button>
	<?
	}elseif($loadPage == "18R_19"){ //--------------------------------------- 반품 선적 완료(판매자) 18R_19 버튼들 ----------------------------------?>
	<?
		$fault_select = get_any("odr_history", "fault_select", "odr_history_idx=".$odr_history_idx);	
		$odr_det = get_odr_det_each($odr_det_idx);
		//일부(환불) or 전체(송장확인) 여부 판단. - 공급수량 합계와 fault 수량 합계 비교
		$supply_sum = get_any("odr_det","SUM(supply_quantity)", "odr_idx = $odr_idx");
		$fault_sum = get_any("odr_det","SUM(fault_quantity)", "odr_idx = $odr_idx");
		//odr 의 det 갯수와 history(환불) 갯수
		$det_cnt = QRY_CNT("odr_det", " and odr_idx = $odr_idx");
		$refund_cnt = QRY_CNT("odr_history", " and odr_idx = $odr_idx AND status=24")+1;

		

		if($fault_select=="2"){ //-- 반품 -------------
			?>
			<?if($supply_sum==$fault_sum && $det_cnt==$refund_cnt){ //전체?>
				<button type="button" class="btn-pop-18-2-08"><img src="/kor/images/btn_invoice_confirm.gif" alt="송장확인"></button>
			<?}else{  //일부?>
				<button type="button" class="btn-view-sheet-19-1-04" for_readonly="Y"><img src="/kor/images/btn_refund.gif" alt="환불"></button>				
			<?}?>
		<?}else{ // 반품이외(교환, 수량부족 등)?>
			<button type="button" class="btn-pop-18R20"><img src="/kor/images/btn_shipping.gif" alt="선적"></button>
		<?}?>
	<?}elseif($loadPage=="30_20"){//----------------------------------------------- 선적완료 30_20 -------------------------------------------------------------?> 
				<!--
				<button type="button" id="btn_3020_1" class="btn-pop-1904"><img src="/kor/images/btn_lack.gif" alt="수량부족"></button>
				<button type="button" id="btn_3020_2" class="btn-pop-18R04"><img src="/kor/images/btn_refuse.gif" alt="거절"></button>
				<button type="button" id="btn_3020_3" class="btn-dialog-3021"><img src="/kor/images/btn_receipt.gif" alt="수령"></button>
				-->
				<img id="btn_3020_1" src="/kor/images/btn_lack_1.gif" alt="수량부족">
				<img id="btn_3020_2" src="/kor/images/btn_refuse_1.gif" alt="거절">
				<img id="btn_3020_3" src="/kor/images/btn_receipt_1.gif" alt="수령">
	<?}elseif($loadPage=="30_20_F"){//-----------------------------------------------선적완료(fault) 30_20_F -------------------------------------------------------------?> 
				<img id="btn_3020_3" src="/kor/images/btn_receipt_1.gif" alt="수령">
	<?}elseif($loadPage=="30_22_F"){//-----------------------------------------------수령(fault) 30_22_F -------------------------------------------------------------?> 
				<!--img id="btn_3022_1" src="/kor/images/btn_deposit3.gif" alt="입금"-->
				<a href="#" class="btn_3022"  odr_idx="<?=$odr_idx?>"><img src="/kor/images/btn_deposit3.gif" alt="입금"></a>
	<?}elseif($loadPage=="01_37"){?>
			<!--a href="#" class="btn-dialog-0901"><img src="/kor/images/btn_order_edit.gif" alt="발주서 수정"></a-->
			<a href="#" class="btn-view-sheet-3011"><img src="/kor/images/btn_invoice_confirm.gif" alt="송장 확인"></a>
	<?}elseif(($loadPage == "18R_06"  || $loadPage == "19_06") && strpos($_SERVER["PHP_SELF"], "18R_05")==""){				
		$odr_his=get_odr_history($odr_history_idx);
	    $fault_select = $odr_his[fault_select];
		$fault_accept = $odr_his[fault_accept];
		 if ($fault_select=="1"){?><a href="#" class="btn-dialog-18R15" fault_select="1"><img src="/kor/images/btn_exchange.gif" alt="교환"></a>
		 <?}elseif($fault_select =="2"){?><a href="#" class="btn-dialog-18R15" fault_select="2"><img src="/kor/images/<?=($loadPage=="18R_06")? "btn_return_way":"btn_return";?>.gif" alt="반품"></a>
		 <?}elseif($fault_select =="3"){?><a href="#" class="btn-dialog-19_15_1"><img src="/kor/images/btn_add_shipping.gif" alt="추가선적"></a>
		 <?}elseif($fault_select =="4"){?><a href="#" class="btn-view-sheet-19-1-04"><img src="/kor/images/btn_refund.gif" alt="환불"></a>
		 <?}?>
		 <?if($fault_accept != "Y"){?><a href="#" class="btn-dialog-<?=$loadPage=="18R_06"?"18R07":"1906"?>"><img src="/kor/images/btn_answer.gif" alt="회신서"></a><?}?>
	<?}elseif($loadPage == "18R_08"){ //------------ 구매자 : 거절
			$fault_select = get_any("odr_history", "fault_select", "odr_history_idx=".$odr_history_idx);
			if($fault_select=="2"){?><a href="#" class="btn-dialog-return"><img src="/kor/images/btn_return.gif" alt="반품"><?}?>
		<a href="#" class="btn-dialog-18R09"><img src="/kor/images/btn_reply.gif" alt="답변서"></a>
	<?}elseif($loadPage == "19_08"){?>
		<a href="#" class="btn-dialog-1908" fault_quantity="<?=$fault_quantity?>"><img src="/kor/images/btn_reply.gif" alt="답변서"></a>
	<?}elseif($loadPage =="18R_16"){
		$return_method = get_any("odr_history", "return_method", "odr_history_idx=".$odr_history_idx);
		$fault_select = get_any("odr_history", "fault_select", "odr_history_idx=".$odr_history_idx);
		$cls =$return_method=="1" ? "btn-pop-18R18" : "btn-dialog-18-1-04";
	?>
		<a href="#" class="<?=$cls?>" return_method="<?=$return_method?>" fault_select="<?=$fault_select?>" odr_idx="<?=$odr_idx?>" odr_det_idx="<?=$odr_det_idx?>"><img src="/kor/images/btn_return_shipping.gif" alt="반품선적"></a>
	<?}elseif($loadPage =="13_04"){?>
	<a href="#" class="btn-pop-1305"><img src="/kor/images/btn_ok.gif" alt="확인"></a>
	<?}elseif($loadPage =="13_04s"){ //------------------------------ 13_04s -----------------------------------------?>
	<?
		$part_type_cnt = QRY_CNT("odr_det"," and part_type=2 and odr_idx = $odr_idx"); 

		if ($part_type_cnt>0)
		{
			$part_type ="2";
		}
	?>
		<a href="#" class="btn-confirm-1304s" odr_history_idx="<?=$odr_history_idx?>" part_type="<?=$part_type?>"><img src="/kor/images/btn_complete.gif" alt="완료"></a>	
		
	<?}elseif($loadPage =="1304_accept"){ //------------------------------ 13_04s -----------------------------------------
		$down_payment = get_any("odr_history", " etc2", "odr_idx=".$odr_idx." and charge_ty='D' limit 1");		
	?>
	<a href="#" class="btn-confirm-1304_accept" odr_idx="<?=$odr_idx?>" odr_history_idx="<?=$odr_history_idx?>" down_payment="<?=$down_payment?>"><img src="/kor/images/btn_deposit3.gif" alt="입금"></a>
	<?}?>
	</div>
<?	
}

	//----------------------------------- 선적 정보 -------------------------------------------------------------------
	function shipping_info($odr_idx, $loadPage=""){
		if ($odr_idx){
			$odr=get_odr($odr_idx);
			$ship = get_ship($odr[ship_idx]);
			$delivery_addr_idx= $ship[delivery_addr_idx];
			$ship_info= $ship[ship_info];
			$ship_account_no= $ship[ship_account_no];
			$insur_yn= $ship[insur_yn];
			$memo= $ship[memo];
			$sell_com_idx = $odr[sell_rel_idx] == "0" ? $odr[sell_mem_idx]:$odr[sell_rel_idx]; 
			$buy_com_idx = $odr[rel_idx] == "0" ? $odr[mem_idx]:$odr[rel_idx]; 
			$assign_idx = get_any("assign", "o_company_idx", "assign_type = 1 and rel_idx = $sell_com_idx");
			//2016-07-10 : 선불 배송비 관련 정보
			//국제 배송비 관련
			$dlvr_cnt = QRY_CNT("freight_charge"," and trade_type=0 and rel_idx = $sell_com_idx ");  //선불 배송비 등록여부
			/**
			$s_nation = get_any("member","nation", "mem_idx=$sell_com_idx");
			$dlvr_charge = get_any("freight_charge", "f_charge", "rel_idx = $sell_com_idx and trade_type=0 and f_dest_idx");
			$dlvr_company = get_any("freight_charge", "f_charge", "rel_idx = $sell_com_idx")
			**/
			if ($assign_idx){
				$buyer_assign_no = get_any("impship", "account_no", "rel_idx = $buy_com_idx and company_idx = $assign_idx");
			}
			$det_cnt = QRY_CNT("odr_det"," and odr_idx=$odr_idx ");  //odr_det 수량

			
		}

		if ($loadPage=="09_03" && $delivery_addr_idx){	//------------------------- 09_03(수정발주서) -------------------------------------------------?>
		<!--	<hr class="dashline2">
			<p class="t-ct"><img alt="배송지변경" src="/kor/images/btn_shipping_change.gif"></p>-->
			<!-- 2016-06-07 : 주석처리
			<table class="detail-table mr-l50">
				<tbody>
					<tr>
						<th scope="row" style="width:70px">선적정보 : </th>
						<td style="width:130px"><span class="c-grey2">운송회사</span> <img src="/kor/images/icon_<?=$ship_info?>.gif" alt="" height="10"></td>
						<th scope="row" style="width:80px"><span lang="en">Account No : </span></th>
						<td style="width:130px"><span lang="en"><?=$ship_account_no?></span></td>
						<th scope="row">운송보험 : </th>
						<td lang="en"><?=$insur_yn=="o"?"Yes":"No"?></td>
					</tr>
					<tr>
						<td colspan="6" lang="en"><strong class="c-black">Memo : </strong><?=$memo?></td>
					</tr>
				</tbody>
			</table>
			-->
			<?//echo GET_ODR_DELIVERY_ADDR($delivery_addr_idx);?>
		<?}elseif($loadPage=="18R_21"){ //------------- fault 선적(판매자)-------------------------------?>
			<tr class="bg-none">
                <td></td>				
				<td colspan="8">		
   					<table class="detail-table">
						<tbody>
							<tr>
								<td>
									<label class="ipt-chk chk2" Style="margin-left:38px;">
										<input <?if ($ship_info=="6") {echo "disabled";}?> type="checkbox" id="insur_yn" name="insur_yn" <?if ($insur_yn=="o"){echo "checked class='checked'";}?>><span></span> 운송보험
									</label>
									<span class="c-red" lang="en"> <?if ($insur_yn=="o"){echo ":&nbsp;&nbsp;Yes";}else{echo ":&nbsp;&nbsp;No";}?></span>
								</td>
							</tr>
							<tr >
								<td><label class="ipt-chk chk2 com-chck" Style="margin-left:38px;"><input type="checkbox" <?if ($ship_info=="6") {echo "disabled";}?> name="delivery_chg" id="delivery_chg"  <?if ($delivery_addr_idx){echo "checked class='checked'";}?>><span></span> 배송지 변경</label></td>
							</tr>
						</tbody>
					</table>                       
					<div class="company-info-wrap" style="display:<?if (!$delivery_addr_idx){echo"none";}?>">
						<?echo GET_CHG_ODR_DELIVERY_ADDR($delivery_addr_idx,$loadPage,$odr_idx);?>
					</div>
				</td>
			</tr>
		<?}elseif($loadPage!="09_03"){ //------------------------------------ 09_03(수정발주서) 외 그 나머지..--------------------------------------?>
			<?if ($loadPage=="09_01"){?>
				<tr class="bg-none">
					<td></td>
				</tr>
			<?}?>
			<tr class="bg-none">
                <td style="height:5px"></td>
				<?=($det_cnt>1)? "<td></td>":"";?>
				<td colspan="10" style="padding:0;">		
				 <div class="txt_option" style="display:none;margin-left:-580px;"><img src="/kor/images/txt_option.gif" alt="선적Option을 선택하여 발주서를 각각 발행할 수 있습니다.발주서 기준 최종 납기 제품과 일괄 배송됩니다." /></div>
   
					<table class="detail-table" style="margin-top:0;padding-top:20px;">
						<tbody>
							<?if ($loadPage == "05_04_1"){?>
							<tr>
								<th scope="row">선적정보 :</th>
								<td lang="en">
									<span class="c-grey2" lang="ko">운송회사</span>									
									<?if($ship_info){
										echo GF_Common_GetSingleList("DLVR",$ship_info);
									  }else{
										echo "없음";
										}?>								
								</td>
								<th scope="row"><span lang="en"><font color='black'>Account No.</font></span></th>
								<td lang="en"><?=$ship_account_no?></td>
							</tr>
							<?if(strlen($memo)>0){?>
							<tr>
								<td colspan="4" ><strong class="c-black" >Memo : </strong> <?=$memo?></td>
							</tr>
							<?}?>
							<tr>
								<td colspan="4">
									<?if ($insur_yn=="o"){echo "운송보험";}?>
								</td>
							</tr>
							<tr>
								<th scope="row"><?if ($delivery_addr_idx){echo "배송지 변경:";}?></th>
							</tr>
							</tbody>
						</table>                       
						
						<div class="company-info-wrap" style="display:<?if (!$delivery_addr_idx){echo"none";}?>">
							<?echo GET_ODR_DELIVERY_ADDR($delivery_addr_idx);?>
						</div>
							<?}else{?><!------------------ 05_04_1 이 아닐때 ------------------------------------------------------>
						
							<tr>
								<th scope="row" style="padding-left:3px;">선적정보 : 
									<span class="c-grey2">운송회사</span>									
										
										<?if($assign_idx){ $div_color="background-image:url(/kor/images/select5_bg.gif)"; }?>
										<div class="select type4" lang="en" style="width:110px;<?=$div_color?>">									
										<label class="c-blue text_lang"><?
										if($assign_idx){  //판매자 지정...
											echo GF_Common_GetSingleList("DLVR",$assign_idx);
										}elseif($ship_info){
											echo GF_Common_GetSingleList("DLVR",$ship_info);
										}
										?></label>
											<?
											echo GF_Common_SetComboListSrch("ship_info", "DLVR", "", 1, "True",  "", $assign_idx?$assign_idx:$ship_info ,$assign_idx?"disabled":"onchange='chg_ship_info(this)'","");
											?>
										</div>	
								</th>								
									<th scope="row" style="padding-left:3px;"><span lang="en" style="display:<?if ($ship_info == "5" || $ship_info == "6"){?>none<?}?>;"><font color='black'>Account No.</font></span></th>
									<td><input type="text" class="i-txt2 c-blue t-rt" name ="ship_account_no" id="ship_account_no" value="<?=$ship_account_no?$ship_account_no:$buyer_assign_no?>" style="width:92px;ime-mode:disabled;display:<?if ($ship_info == "5" || $ship_info == "6"){?>none<?}?>;"></td>
								
							</tr>
							<?if ($assign_idx!="" && $assign_idx!=0){?>
                            <tr>
                                
                                <td colspan="4"><span style="color: #666666; font-size:11px; padding-left:110px;">해당 운송업체로만 선적이 가능한 회사입니다.<input type="hidden" name="ship_info" value="<?=$assign_idx?$assign_idx:$ship_info?>"></span></td>
                            </tr>
							<?}?>
							<tr>
								<td colspan="4" style="padding-left:3px;"><strong class="c-black">Memo&nbsp;&nbsp;</strong> <input type="text" class="i-txt<?=$ship_info=="6" || $ship_info=="5"?"2":"5"?>" id ="memo" name="memo" maxlength="300" value="<?=$memo?>" style="width:350px;color:#00759e;"></td>
							</tr>
							<tr>
								<td  colspan="4"><label class="ipt-chk chk2" Style="margin-left:38px;"><input <?if ($ship_info=="6") {echo "disabled";}?> type="checkbox" id="insur_yn" name="insur_yn" <?if ($insur_yn=="o"){echo "checked class='checked'";}?>><span></span> 운송보험</label> <span class="c-red" lang="en"> <?if ($insur_yn=="o"){echo ": Yes";}else{echo ": No";}?></span></td>
							</tr>
							<tr >
								<td  colspan="4"><label class="ipt-chk chk2 com-chck" Style="margin-left:38px;"><input type="checkbox" <?if ($ship_info=="6") {echo "disabled";}?> name="delivery_chg" id="delivery_chg"  <?if ($delivery_addr_idx){echo "checked class='checked'";}?> onclick="javascript:add_change_sel('<?=$assign_idx?>');"><span></span> 배송지 변경</label></td>
							</tr>
						</tbody>
					</table>
					
					<div class="company-info-wrap" style="display:<?if (!$delivery_addr_idx){echo"none";}?>">
						<?echo GET_CHG_ODR_DELIVERY_ADDR($delivery_addr_idx,$loadPage,$odr_idx);?>
					</div>

					<?}?>
					
				</td>
			</tr>
			<?}
		}
	//------------------------------------------------------------------------------------------------------------------------------------------------
	function GET_ODR_DELIVERY_ADDR($delivery_addr_idx){
		global $row_seller;
		global $odr_idx;

		if ($delivery_addr_idx){
			
			$odr_idx_val = get_any("ship", "odr_idx", "delivery_addr_idx=".$delivery_addr_idx." and odr_idx='".$odr_idx."' limit 1");			
			$seller_idx = get_any("odr", "sell_mem_idx", "odr_idx=".$odr_idx_val);
			$seller_nation = get_any("member", "nation", "mem_idx=".$seller_idx);

			$result = QRY_DELIVERY_ADDR_VIEW($delivery_addr_idx);
			$row = mysql_fetch_array($result);
			if ($row){
				$mem_idx = replace_out($row["mem_idx"]);
				$save_yn = replace_out($row["save_yn"]);
				$nation = replace_out($row["nation"]);
				$com_name = replace_out($row["com_name"]);
				$manager = replace_out($row["manager"]);
				$pos_nm = replace_out($row["pos_nm"]);
				$depart_nm = replace_out($row["depart_nm"]);
				$com_type = replace_out($row["com_type"]);
				$tel = replace_out($row["tel"]);
				$fax = replace_out($row["fax"]);
				$hp = replace_out($row["hp"]);
				$email = replace_out($row["email"]);
				$homepage = replace_out($row["homepage"]);
				$zipcode = replace_out($row["zipcode"]);
				$dosi = replace_out($row["dosi"]);
				$nation = replace_out($row["nation"]);

				$sigungu = replace_out($row["sigungu"]);
				$addr = replace_out($row["addr"]);

				$tel_nation = explode("-",$tel);
				$fax_nation = explode("-",$fax);
				$hp_nation = explode("-",$hp);
	
				if ($seller_nation==$nation)
				{					
					$tel = str_replace($tel_nation[0]."-","0",$tel);
					$fax = str_replace($fax_nation[0]."-","0",$fax);
					$hp = str_replace($hp_nation[0]."-","0",$hp);
				}				
			}	
		}
		?>
		<table class="company-info-tb2" style="width:700px" align="">
				<tbody>
					<!--<tr>
						<th scope="row">회사구분 :</th>
						<td colspan="5"><?=GF_Common_GetSingleList("MEM",$com_type)?></td>
					</tr>-->
					<tr>
						<th scope="row" class="c-red">국가 :</th>
						<td colspan="5"><span><?=GF_Common_GetSingleList("NA",$nation)?></span></td>
					</tr>
					<tr>
						<th scope="row" class="c-red">회사명 :</th>
						<td colspan="5"><span ><?=$com_name?></span></td>
					</tr>
					<tr>
						<th scope="row" class="c-red">담당자/직책 :</th>
						<td colspan="5"><?=$manager?> / <?=$pos_nm?></td>
					</tr>
					<tr>
						<th scope="row" class="c-red">부서 :</th>
						<td colspan="5"><?=$depart_nm?></td>
					</tr>							
					<tr>
						<th scope="row" style="width:70px;"><span class="c-red">Tel :</span></th>
						<td><?=$tel?></td>
						<th scope="row" style="width:70px;"><span class="c-red">Fax :</span></th>
						<td><?=$fax?></td>
						<th scope="row" style="width:70px;" class="c-red">휴대전화 :</th>
						<td><?=$hp?></td>
					</tr>
					<tr>
						<th scope="row" class="c-red">주소 :</th>
						<td colspan="5"><span><?=$addr?></span></td>
					</tr>
					<tr>
						<th scope="row" class="c-red"><span>E-mail :</span></th>
						<td colspan="5"><?=$email?></td>
					</tr>
					<?if(strlen($homepage) > 0){?>
					<tr>
						<th scope="row" class="c-red">홈페이지 :</th>
						<td colspan="5"><?=$homepage?></td>
					</tr>					
					<?}?>
				</tbody>
			</table>
	<?}
	//****************************************************************************************************************************
	//****************** 배송지 변경 *********************************************************************************************
	//****************************************************************************************************************************
	function GET_CHG_ODR_DELIVERY_ADDR($delivery_addr_idx,$loadPage="",$odr_idx=""){


		if ($delivery_addr_idx){
			$result = QRY_DELIVERY_ADDR_VIEW($delivery_addr_idx);
			$row = mysql_fetch_array($result);
			if ($row){
				$mem_idx = replace_out($row["mem_idx"]);
				$save_yn = replace_out($row["save_yn"]);
				$nation = replace_out($row["nation"]);
				$com_name = replace_out($row["com_name"]);
				$manager = replace_out($row["manager"]);
				$pos_nm = replace_out($row["pos_nm"]);
				$depart_nm = replace_out($row["depart_nm"]);
				$com_type = replace_out($row["com_type"]);
				$tel = replace_out($row["tel"]);
				$fax = replace_out($row["fax"]);
				$hp = replace_out($row["hp"]);
				$email = replace_out($row["email"]);
				$homepage = replace_out($row["homepage"]);
				$zipcode = replace_out($row["zipcode"]);
				$dosi = replace_out($row["dosi"]);
				$dositxt = replace_out($row["dositxt"]);				
				$sigungu = replace_out($row["sigungu"]);				
				$addr = replace_out($row["addr"]);
				$addr_det = replace_out($row["addr_det"]);
			}	
		}else{
			$saved_cnt = QRY_CNT("delivery_addr", "and mem_idx=".$_SESSION["MEM_IDX"]." and save_yn='Y'");
		}


		//odr 정보
		$odr=get_odr($odr_idx);
		$sell_mem_idx = $odr[sell_mem_idx];
		$buy_mem_idx = $_SESSION["MEM_IDX"];
		//구매자, 판매자 국가
		$s_nation = get_any("member","nation", "mem_idx='$sell_mem_idx'");
		$b_nation = get_any("member","nation", "mem_idx='$buy_mem_idx'");
		$nation_name = get_any("code_group_detail","code_desc", "grp_code ='NA' and code_depth =1 and use_yn='Y' and dtl_code='$nation'");
		$nation_number = get_any("code_group_detail","code_desc_mt", "grp_code ='NA' and code_depth =1 and use_yn='Y' and dtl_code='$b_nation'");

		if ($nation=="")
		{
			$nation =$b_nation;
		}
		?>
	<script type="text/javascript">
			$(document).ready(function(){	
				//alert(<?=$delivery_addr_idx?>);
				<?if (!$delivery_addr_idx && $delivery_addr_idx !="0"){ ?>
						$(".company-info-wrap input,select").attr("disabled",true);
						$(".company-info-wrap select:eq(0)").attr("disabled",false);
						$("#ship_info").attr("disabled",false);						
						$(".company-info-wrap select:eq(1)").attr("disabled",true);		
						$(".company-info-wrap :hidden").attr("disabled",false);
						$("#ship_info_1916").attr("disabled",false);									
				<?}?>			
				$.ajax({ 
					type: "GET", 
					url: "/ajax/proc_ajax.php", 
					data: { actty : "NPT",
							actidx : <?=$nation?>
					},
						dataType : "text" ,
						async : false ,
						success: function(data){ 
							$(".post_val").empty();
							var zip_code_val="<?=$zipcode?>";
							var check_val = "";
							
							//alert($.trim(data));
							if ($.trim(data)!="")
							{
								if ($.trim(data)=="AUS" || $.trim(data)=="CAN" || $.trim(data)=="CHN" || $.trim(data)=="IND" || $.trim(data)=="JPN" || $.trim(data)=="KOR" || $.trim(data)=="TWN" || $.trim(data)=="USA" || $.trim(data)=="GBR")
								{
									$("#zipcode").css("background-color",'');
									$("#zipcode").attr("readonly",false);
								}
								else
								{
									if (trim(zip_code_val) =="")
									{
										check_val = "class=checked";
										$("#zipcode").attr("readonly",true);
										$("#zipcode").css("background-color",'rgb(235, 235, 228)');
										$("#zipcode").val(" ");
									}
									else
									{
										$("#zipcode").css("background-color",'');
										$("#zipcode").attr("readonly",false);
									}

									$(".post_val").append("<input type='checkbox' name='zipcode_no' id='zipcode_no' value='1' onclick='javascript:no_post(this)'; "+check_val+"><span></span>우편번호없음");
									
								}
							}										
							
						}
				});
				
			});
			
			<?if (!$delivery_addr_idx || $loadPage !="05_04"){?>
			chgnation($("#nation").val());
			<?}?>
			//회사구분 선택 ---------------------------------------------------------------
			$(".company-info-wrap select[name=com_type]").change(function(){
				$(".company-info-wrap select[name=nation]").attr("disabled",false);
				var part_type = $(this).val();
				switch(part_type){
					case("1"):	//유통회사
					case("2"):	//제조회사
						$(".indivi").show();
						$("#sp_com_nm").html("회사명");
						$("#sp_manager").html("담당자");
						$("#sp_depart_nm").html("부서");
						$("#sp_pos_nm").html("직책");
						$("#mst_tel").html("*");
					break;
					case("3"): //교육기관
						$(".indivi").show();
						$("#sp_com_nm").html("학교명");
						$("#sp_manager").html("담당자");
						$("#sp_depart_nm").html("학과");
						$("#sp_pos_nm").html("학년");
						$("#mst_tel").html("*");
					break; 
					case("4"): //개인
						$(".indivi").hide();
						$("#sp_manager").html("성명");
						$("#mst_tel").html("");
					break; 
					case ("5"): //학생
						$(".indivi").show();
						$("#sp_com_nm").html("학교명");
						$("#sp_manager").html("성명");
						$("#sp_depart_nm").html("학과");
						$("#sp_pos_nm").html("학년");
						$("#mst_tel").html("");
						break;
				}
				$(".company-info-wrap input,select").attr("disabled",false);
				if($(".company-info-wrap select[name=nation]").val() == "1" && $("#korea_chk").val()!="_en"){
					$(".company-info-wrap select[name=dosi], input[name=sigungu]").attr("disabled",true);
				}
			});
			//국가 선택(변경) ---------------------------------------------------------------
			$(".company-info-wrap select[name=nation]").change(function(){
				$(".company-info-wrap input,select").attr("disabled",false);
				if($(this).val() == "-1" && $("#korea_chk").val()!="_en"){	//한국일 경우
					$(".company-info-wrap select[name=dosi], input[name=sigungu]").attr("disabled",true);
					$(".company-info-wrap select[name=dosi]").css("color","00759e");
				}
			});
			//'저장'버튼 활성 체크 --------------------------------------------------
			$(".company-info-wrap input,select").change(function(){
				/**
				var val = $(this).val();
				var part_type = $(".company-info-wrap select[name=com_type]").val();
				var save_ok = false;
				if(MustChk() == true){
					save_ok = true;
				}
				**/

				if(MustChk() == true){
					$("#save_deact").hide();
					$(".delivery_save").show();					
				}else{
					$("#save_deact").show();
					$(".delivery_save").hide();
				}
			});
			$(".company-info-wrap input").keyup(function(){
				if(MustChk() == true){

					$("#save_deact").hide();
					$(".delivery_save").show();
					checkActive();
				}else{
					$("#save_deact").show();
					$(".delivery_save").hide();
				}
			});
			
			function MustChk()
			{	
				var f =  document.f_<?=$loadPage;?>;
				var com_type = $(".company-info-wrap select[name=com_type]").val();
				
				//공통 필수(회사구분,국가,성명(담당자),휴대전화,우편번호,도시,시군구,주소,email)

				if(f.com_type.value==""){ return "com_type";}
				if(f.nation.value==""){ return "nation";}
				if(f.manager.value==""){ return "manager";}
				if(f.hp.value==""){ return "hp";}
				if(f.zipcode.value==""){ return "zipcode";}
				//if(f.dosi.value=="" && f.dositxt.value==""){ return "dosi";}
				//if(f.sigungu.value==""){ return "sigungu";}
				if(f.addr.value==""){ return "addr";}
				if(f.email.value==""){ return "email";}
				//개인이 아닐 경우, 필수값 추가
				if(com_type != "4"){
					if(f.com_name.value==""){ return "com_name";}	//회사명(학교명)
					if(f.depart_nm.value==""){ return "depart_nm";}	//부서(학과)
					if(f.pos_nm.value==""){ return "pos_nm";}			//직책(학년)
					if(f.tel.value==""){ return "tel";}						//Tel
				}
				
				return true;
			}
			
			function call_zip(){
				var nation = $("#nation").val();
				var s_nation = $("#s_nation").val();
				var en_ok;
				if(nation == s_nation){
					frm_addr_en = "";
				}else{
					frm_addr_en = "addr";
				}
				openCommLayer('layer4','layerZipNew','?frm_name=f_<?=$loadPage;?>&frm_zip1=zipcode&frm_addr1=addr&frm_addr2=addr_det&frm_addr_en='+frm_addr_en);
			}


		</script>	
		
	<section id="delv_chg">
	<?
	if($delivery_addr_idx==0)
	{
		$delivery_addr_idx = "aaaa";
	}
	?>
	<input type="hidden" name ="delivery_addr_idx" id="delivery_addr_idx" value="<?=$delivery_addr_idx?>">
	<input type="hidden" name ="delivery_save_yn" id="delivery_save_yn" value="<?=$save_yn?>">
	<input type="hidden" name="delv_load" id="delv_load" value="<?=$loadPage;?>">
	<table class="company-info-tb" style="width:745px">
		<tbody>			
			<tr>
				<th scope="row"><strong class="c-red">*</strong> 회사구분</th>
				<td colspan="2">
					<div class="select type5" >
						<label class="c-blue"><?=($com_type)?GF_Common_GetSingleList("MEM",$com_type):""?></label>
						<?echo GF_Common_SetComboList("com_type", "MEM", "", 1, "True",  "", $com_type,"lang='ko'"  );?>
					</div>
				</td>
			</tr>
			<tr>
				<th scope="row"><strong class="c-red">*</strong> 국가</th>
				<td colspan="2">
									<div class="select type5" >
										<label ><?=($nation)?GF_Common_GetSingleList("NA",$nation):"Nation"?></label>
										<?=GF_Common_SetComboList("nation", "NA", "", 1, "True",  "", $nation , "onchange='chgnation(this.value);'");?>
									</div>
				</td>
			</tr>			
			<tr class="indivi">
				<th scope="row"><strong class="c-red">*</strong> <span id="sp_com_nm">회사명</span></th>
				<td colspan="2"><input class="i-txt3 c-blue" maxlength="30" type="text" name="com_name" style="width:215px" value="<?=$com_name?>"></td>
			</tr>
			<tr>
				<th scope="row"><strong class="c-red">*</strong> <span id="sp_manager">담당자</span></th>
				<td colspan="2"><input class="i-txt3 c-blue" type="text" maxlength="30" lang="ko" name="manager" style="width:215px" value="<?=$manager?>"></td>
			</tr>
			<tr class="indivi">
				<th scope="row"><strong class="c-red">*</strong> <span id="sp_depart_nm">부서</span></th>
				<td colspan="2"><input class="i-txt3 c-blue" type="text" name="depart_nm" lang="ko" style="width:215px" value="<?=$depart_nm?>"></td>
			</tr>
			<tr class="indivi">
				<th scope="row"><strong class="c-red">*</strong> <span id="sp_pos_nm">직책</span></th>
				<td colspan="2"><input class="i-txt3 c-blue" type="text" maxlength="30" lang="ko" name="pos_nm" style="width:215px" value="<?=$pos_nm?>"></td>
			</tr>
			<?			
				
				$tel_nation = explode("-",$tel);
				$fax_nation = explode("-",$fax);
				$hp_nation = explode("-",$hp);

				$tel_nation_val = $tel_nation[0];
				$fax_nation_val = $fax_nation[0];
				$hp_nation_val = $hp_nation[0];				

				$tel_num = str_replace($tel_nation[0]."-","",$tel);
				$fax_num = str_replace($fax_nation[0]."-","",$fax);
				$hp_num = str_replace($hp_nation[0]."-","",$hp);
			?>
			<tr>
				<th scope="row"><strong class="c-red" id="mst_tel">*</strong> <span lang="en">Tel</span></th>
				<td colspan="2"><input type="text" class="i-txt3 c-blue" lang="en" name="nation_nm" style="width:37px;text-align:right;"  maxlength="5" value="<?=$tel_nation_val?>-" readonly>&nbsp<input class="i-txt3 c-blue" name="tel" type="text" maxlength="15" lang='en' style="width:175px" value="<?=$tel_num?>"></td>
			</tr>
			<tr>
				<th scope="row"><strong class="c-red"></strong> <span lang="en">Fax</span></th>
				<td colspan="2"><input type="text" class="i-txt3 c-blue" lang="en" name="nation_nm" style="width:37px;text-align:right;"  maxlength="5" value="<?=$fax_nation_val?>-" readonly>&nbsp<input class="i-txt3 c-blue" name="fax"  type="text" maxlength="15" lang='en' style="width:175px" value="<?=$fax_num?>"></td>
			</tr>
			<tr>
				<th scope="row"><strong class="c-red">*</strong> 휴대전화</th>
				<td colspan="2"><input type="text" class="i-txt3 c-blue" lang="en" name="nation_nm" style="width:37px;text-align:right;"  maxlength="5" value="<?=$hp_nation_val?>-" readonly>&nbsp<input class="i-txt3 c-blue" name="hp" type="text" maxlength="15" lang='en' style="width:175px" value="<?=$hp_num?>"></td>
			</tr>
			<tr>
				<th scope="row"><strong class="c-red">*</strong> 우편번호</th>
				<td colspan="2">
					<input class="i-txt3 c-blue" id="zipcode" name="zipcode" type="text" onkeyup="zipcode_txt(this.value);" maxlength="10" style="width:215px"  lang='en' value="<?=$zipcode?>">
					<span class="c-red">&nbsp;&nbsp;
						<!--<span class="roadname_1" style="display:<?if ( $nation=="-1"){echo "none";}?>;"><img src="/kor/images/btn_roadname_1.gif" border=0 align=absmiddle alt="도로명주소"></span>
						<button type="button" onclick="call_zip();" class="roadname" style="display:<?if ($nation!="-1"){echo "none";}?>;"><img src="/kor/images/btn_roadname.gif" border=0 align=absmiddle alt="도로명주소"></button>-->
						<label class="ipt-chk chk2 c-blue post_val"></label><br>
					</span>
				</td>
			</tr>			
			<tr>
				<th scope="row"><strong class="c-red">*</strong> 주소</th>
				<td colspan="2"><input class="i-txt3 c-blue w50" name="addr_full" id="addr_full" onkeyup="detail_addr(this.value);" value="<?=$addr_det;?>" type="text" lang="ko"></td>
			</tr>
			<tr>
				<th scope="row" style="height:20px;"><strong class="c-red">*</strong>  주소확인</th>
				<td colspan="2" lang="en">
					<input type="hidden" class="i-txt3" name="addr" id="addr" value="<?=$addr?>" style="width:308px">
					<!--span class="c-blue" style="width:508px" id="sp_addr_en" lang="en"><u><?=$addr_en?></u></span-->
					<?
					$zip_code_val = "";
					if (trim($zipcode) != "")
					{
						$zip_code_val = $zipcode.",";
					}
					?>
					<span class="c-blue"  id="sp_addr" style="width:508px" ><?=$addr?></span>

				</td>
			</tr>
			<tr>
				<th scope="row"><strong class="c-red">*</strong> <span lang="en">E-mail</span></th>
				<td colspan="2"><input class="i-txt3 c-blue" name="email" type="text" maxlength="30" lang='en' style="width:215px"  value="<?=$email?>"></td>
			</tr>
			<tr>
				<th scope="row"><strong class="c-red"></strong> 홈페이지</th>
				<td colspan="2">
					<input class="i-txt3 c-blue" name="homepage" type="text" style="width:215px" lang='en' value="<?=$homepage?>">
				<span id="save_deact"><img src="/kor/images/btn_save_1.gif" alt="저장"></span><button style="display:none;" type="button" class="delivery_save"><img src="/kor/images/btn_save.gif" alt="저장" ></button> <?if($com_name){?><button type="button"  class="delivery_del"><img src="/kor/images/btn_delete3.gif" alt="삭제"></button><?}else{?><span><img src="/kor/images/btn_delete3_1.gif" alt="삭제"></span><?}?>
				</td>
			</tr>
			<tr>
				<td colspan="3">
					<?echo GET_MY_ODR_DELIVERY_ADDR_LIST($delivery_addr_idx,$loadPage,$odr_idx)?>
				</td>
			</tr>
		</tbody>
	</table>
	</section>
	<?}
	
	function GET_MY_ODR_DELIVERY_ADDR_LIST ($idx,$loadPage="",$odr_idx=""){
		$result =QRY_DELIVERY_ADDR_LIST(0,"and save_yn='Y' and mem_idx = ".$_SESSION["MEM_IDX"],0);
		$rowcnt = mysql_num_rows($result);
		if ($rowcnt>0){
			?>
			<table class="company-rank">
			<thead>
				<tr>
					<th scope="col" >No.</th>
					<th scope="col" >회사명 <span style="float:right;"><a href="javascript:new_addr();"><font color="white"><strong>새로작성</strong></font></a></span></th>
				</tr>
			</thead>
			<tbody>
				<?	
				 while($row = mysql_fetch_array($result)){
						$i++;
						$delivery_addr_idx = replace_out($row["delivery_addr_idx"]);
						$com_type = replace_out($row["com_type"]);
						$com_name = replace_out($row["com_name"]);
						$manager = replace_out($row["manager"]);
						if($com_type=="4" || $com_type=="5"){
							$com_name = $manager;
						}
				?>
				<tr >
					<td <?echo $idx == $delivery_addr_idx?"class='c-red'":""?> style="cursor:pointer;" onclick="delivery_load(<?=$delivery_addr_idx?>,'<?=$loadPage?>','<?=$odr_idx?>');"><?=$i?>.</td>
					<td <?echo $idx == $delivery_addr_idx?"class='c-red'":""?> style="cursor:pointer;" onclick="delivery_load(<?=$delivery_addr_idx?>,'<?=$loadPage?>','<?=$odr_idx?>');"><?=$com_name;?></td>
				</tr>
				<?}?>		
			</tbody>
			</table>	
	<?	}
	}	
//******************************************* [선불], [착불] 배송비 선택 화면 ************************************************************************************
function pay_dlvr($odr_idx, $sell_mem_idx, $b_nation){
		if ($odr_idx){
			$odr=get_odr($odr_idx);
			$ship = get_ship($odr[ship_idx]);
			$delivery_addr_idx= $ship[delivery_addr_idx];
			$ship_info= $ship[ship_info];
			$ship_account_no= $ship[ship_account_no];
			$insur_yn= $ship[insur_yn];
			$memo= $ship[memo];
			$sell_com_idx = $odr[sell_rel_idx] == "0" ? $odr[sell_mem_idx]:$odr[sell_rel_idx]; 
			$buy_com_idx = $odr[rel_idx] == "0" ? $odr[mem_idx]:$odr[rel_idx]; 
			$assign_idx = get_any("assign", "o_company_idx", "assign_type = 1 and rel_idx = $sell_com_idx");
			if ($assign_idx){
				$buyer_assign_no = get_any("impship", "account_no", "rel_idx = $buy_com_idx and company_idx = $assign_idx");
			}
			$det_cnt = QRY_CNT("odr_det"," and odr_idx=$odr_idx ");  //odr_det 수량
		}
?>
				<tr class="bg-none">
					<?=($det_cnt>1)? "<td></td>":"";?>
					<td colspan="11">
						<!-- 선불 -->
						<div class="delivery-check w50">
							<strong class="check-title"><label class="ipt-rd rd4" lang="ko"><input type="radio" name="dlvr_adv" value="Y"><span></span> 선불</label></strong>
							<div class="check-wrap">
								<table class="detail-table w100" style="margin:0;">
									<tbody>
										<tr>
											<th scope="row" class="va-t w65p">운송회사</th>
											<td colspan="3">
												<ul lang="en" class="list-type5">
												<?//운송회사 목록
													$delv_charge = get_delv_charge($sell_mem_idx, 0, $b_nation);
													//$ex_dest = explode(",", $delv_charge[f_dest_idx]);
													$ex_company = explode(",", $delv_charge["t_company_idx"]);
													$ex_charge = explode(",", $delv_charge["f_charge"]);
													for($k=0; $ex_company[$k]; $k++){
												?>
													<li>
														<label class="ipt-rd rd2 c-blue"><input type="radio" name="dlvr_corp" value="<?=$ex_company[$k];?>" dlvr_pay=<?=number_format($ex_charge[$k],2);?>
														corp_nm="<?=($ex_company[$k])?GF_Common_GetSingleList("DLVR",$ex_company[$k]):"";?>" onClick="dlvr_click(this);"><span></span>
														<?=($ex_company[$k])?GF_Common_GetSingleList("DLVR",$ex_company[$k]):"";?> :  $<?=number_format($ex_charge[$k],2);?>
														</label>
													</li>
													<?}?>
													<input type="hidden" name="dlvr_pay" id="dlvr_pay" value="">
												</ul>
											</td>
										</tr>
										<tr>
											<th scope="row" class="w65p">선적정보:</th>
											<td style="width:120pt;"><span class="c-grey2">운송회사 : </span> <span lang="en" id="sp_pay"></span></td>
											<th scope="row" class="w70p c-red"><span lang="en"><font color='black'>Account No.</font></span></th>
											<td><input type="text" name="dlvr_acc" id="dlvr_acc"  class="i-txt2 c-blue" style="width:92px"></td>
										</tr>
										<tr>
											<td colspan="4" ><strong class="c-black">Memo</strong> <input type="text" class="i-txt<?=$ship_info=="6" || $ship_info=="5"?"2":"5"?>" style="width:330px"></td>
										</tr>
										<tr>
											<td colspan="4"><label class="ipt-chk chk2 com-chck" Style="margin-left:38px;"><input type="checkbox" <?if ($ship_info=="6") {echo "disabled";}?> name="delivery_chg" id="delivery_chg"  <?if ($delivery_addr_idx){echo "checked class='checked'";}?> onclick="javascript:add_change_sel('<?=$assign_idx?>');"><span></span> 배송지 변경</label></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<!-- //선불 -->
						
						<!-- 착불 -->
						<div class="delivery-check w50">
							<strong class="check-title"><label class="ipt-rd rd4" lang="ko"><input type="radio" name="dlvr_adv" value="N"><span></span> 착불</label></strong>
							<div class="check-wrap">
								<table class="detail-table w100">
									<tbody>
										<tr>
											<th scope="row" class="w65p">
												선적정보:
											</th>
											<td class="w180p">
												<span class="c-grey2">운송회사</span>
													<?if($assign_idx){ $div_color="background-image:url(/kor/images/select5_bg.gif)"; }?>
													<div class="select type4" lang="en" style="width:110px;<?=$div_color?>">
														<label class="c-blue text_lang"><?
														if($assign_idx){  //판매자 지정...
															echo GF_Common_GetSingleList("DLVR",$assign_idx);
														}elseif($ship_info){
															echo GF_Common_GetSingleList("DLVR",$ship_info);
														}
														?></label>
															<?
															echo GF_Common_SetComboListSrch("ship_info", "DLVR", "", 1, "True",  "", $assign_idx?$assign_idx:$ship_info ,$assign_idx?"disabled":"onchange='chg_ship_info(this)'","");
															?>
													</div>
											</td>
											<th scope="row" class="w70p"><span lang="en" style="display:<?if ($ship_info == "5" || $ship_info == "6"){?>none<?}?>;"><font color='black'>Account No.</font></span></th>
											<td><input type="text" class="i-txt2 c-blue t-rt" name ="ship_account_no" id="ship_account_no" value="<?=$ship_account_no?$ship_account_no:$buyer_assign_no?>" style="width:92px;ime-mode:disabled;display:<?if ($ship_info == "5" || $ship_info == "6"){?>none<?}?>;"></td>
										</tr>
										<?if ($assign_idx!="" && $assign_idx!=0){?>
										<tr>
											
											<td colspan="4"><span style="color: #666666; font-size:11px; padding-left:110px;">해당 운송업체로만 선적이 가능한 회사입니다.<input type="hidden" name="ship_info" value="<?=$assign_idx?$assign_idx:$ship_info?>"></span></td>
										</tr>
										<?}?>
										<tr>
											<td colspan="4" style="padding-left:3px;"><strong class="c-black">Memo&nbsp;&nbsp;</strong> <input type="text" class="i-txt<?=$ship_info=="6" || $ship_info=="5"?"2":"5"?>" id ="memo" name="memo" maxlength="300" value="<?=$memo?>" style="width:350px;color:#00759e;"></td>
										</tr>
										<tr>
											<td  colspan="4"><label class="ipt-chk chk2" Style="margin-left:38px;"><input <?if ($ship_info=="6") {echo "disabled";}?> type="checkbox" id="insur_yn" name="insur_yn" <?if ($insur_yn=="o"){echo "checked class='checked'";}?>><span></span> 운송보험11111111111</label> <span class="c-red" lang="en"> <?if ($insur_yn=="o"){echo ": Yes";}else{echo ": No";}?></span></td>
										</tr>
										<tr>
											<td colspan="4"><label class="ipt-chk chk2 com-chck" Style="margin-left:38px;"><input type="checkbox" <?if ($ship_info=="6") {echo "disabled";}?> name="delivery_chg" id="delivery_chg"  <?if ($delivery_addr_idx){echo "checked class='checked'";}?> onclick="javascript:add_change_sel('<?=$assign_idx?>');"><span></span> 배송지 변경</label></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<!-- //착불 -->
					<div class="company-info-wrap" style="display:<?if (!$delivery_addr_idx){echo"none";}?>">
						<?echo GET_CHG_ODR_DELIVERY_ADDR($delivery_addr_idx,"05_04",$odr_idx);?>
					</div>
					</td>
				</tr>
<?
}
?>
