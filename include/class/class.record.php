<?
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.record.php";
$pay = "";
function GET_MyMember($this_mem_idx){
	$result =QRY_MYMEMBER_LIST($_SESSION["MEM_IDX"], $_SESSION["REL_IDX"]);
	$i = 0;
	while($row = mysql_fetch_array($result)){
			$i++;				
			$mem_idx= replace_out($row["mem_idx"]);
			$mem_name= replace_out($row["name"]);
			if($this_mem_idx == $mem_idx){ 
				$label = "<label lang='en'>$mem_name</label>\n";
				$option .= "<option lang='en' value='$mem_idx' selected>$mem_name</option>\n";
			}else{
				$option .= "<option lang='en' value='$mem_idx'>$mem_name</option>\n";
			}
	}
	echo $label."<select name='this_mem_idx' ".($i=="1"?"disabled":"")." id ='this_mem_idx' onchange=''>".$option."</select>";
}

//----------- 우측, 거래내역 영역 Data --------------------------------------------------
/*******************************************************************************
*** $odr_type : 'B'(Buy) or 'S'(Sell)
*******************************************************************************/
function GET_RCD_DET_LIST($part_type, $odr_type, $searchand ,$fr){
	if ($fr == "M"){  //from : main
		$colspan = $odr_type == "B"? "11" : "9";	
	}else{
		$colspan = $odr_type == "B"? "13" : "11";	
		//$searchand .= " and c.part_type = $part_type";
	}
	$searchand .= " and b.odr_det_idx <>'' ";
	$array_status = array();
	$array_real_status = array();
	//$result2 =QRY_RCD_DET_LIST(10,$searchand,1,"a.odr_idx desc, c.part_type asc");
	$result2 =QRY_RCD_DET_LIST(0,$searchand,1,"a.odr_idx desc, b.part_type ASC, b.odr_det_idx ASC"); //오름차순 정렬
	while($row2 = mysql_fetch_array($result2)){
		$odr_idx = replace_out($row2["odr_idx"]);
		$save_yn = replace_out($row2["save_yn"]);
		$odr_status= replace_out($row2["order_status"]);
		$kk = replace_out($row2["odr_det_idx"]);
	
		//최근 이력이 있거나 save_yn = 'Y'인 경우만 출력하기로.
		//$status = get_any("odr_history", "status", "odr_history_idx in (select max(odr_history_idx) from odr_history where odr_idx = trim('$odr_idx'))");
		$status = get_any("odr_history", "status", "odr_history_idx in (select max(odr_history_idx) from odr_history where odr_idx = trim('$odr_idx') and odr_det_idx is null or odr_det_idx='$kk') AND status NOT IN(90,15)"); //2016-04-04 상태 '종료' 미 노출
		//상태 16인게 저장에 있을경우 비 노출(구매화면) 2016-04-06
		
		$st16cnt = QRY_CNT("odr a INNER JOIN odr_det b ON(a.odr_idx=b.odr_idx)", "AND b.rel_det_idx = $kk AND a.save_yn='Y'");
		$chk = ($st16cnt>0 && $status==16 && $odr_type =="B")? false:true;

		//--------------------------------------------------------------
		if (($status && $chk) || ($odr_type =="B" && $save_yn =="Y")) {
			$odr_det_idx = replace_out($row2["odr_det_idx"]);
			$part_idx= replace_out($row2["a.part_idx"]);
			$part_type= replace_out($row2["part_type"]);
			$part_no= replace_out($row2["part_no"]);
			$nation= replace_out($row2["nation"]);
			$sell_mem_idx= replace_out($row2["mem_idx"]);
			$manufacturer= replace_out($row2["manufacturer"]);
			$package= replace_out($row2["package"]);
			$dc= replace_out($row2["dc"]);
			$rhtype= replace_out($row2["rhtype"]);
			$quantity= replace_out($row2["quantity"]);
			$period= replace_out($row2["period"]);
			$price= replace_out($row2["price"]);
			$odr_price= replace_out($row2["odr_price"]);
			$rel_idx= replace_out($row2["rel_idx"]);
			$odr_quantity= replace_out($row2["odr_quantity"]);
			$supply_quantity= replace_out($row2["supply_quantity"]);
			$odr_stock= replace_out($row2["odr_stock"]);
			$odr_det_status = replace_out($row2["odr_det_status"]);
		
			$com_idx = $rel_idx==0 ? $sell_mem_idx : $rel_idx;
			$company_nm = get_any("member","mem_nm_en", "mem_idx=$com_idx"); 	
			if ($part_type =="2"){
					$dc = "NEW";
					$quantity="";
				}
			//구매자 정보
			$odr = get_odr($odr_idx);
			$buy_mem_idx = $odr[mem_idx];
			$buy_rel_idx = $odr[rel_idx];		
			$buy_com_idx = ($buy_rel_idx ==0? $buy_mem_idx : $buy_rel_idx);
			$mem  =get_mem($buy_mem_idx);
			$buy_nation =  $mem[nation];
			$buy_company_nm = $mem[mem_nm_en];			
			
			$odr_det_idx_chk = get_any("odr_history","odr_det_idx", "odr_det_idx='$odr_det_idx' and status=6"); 

			//$j++;
			//2016-04-10 : 품목 구분별 일련번호
			if($old_part == $part_type){
				$j++;
			} else{
				$j=1;
			}
			$old_part = $part_type;
			$criteria_now_idx = $odr_idx; //$odr_type=="S"? $buy_mem_idx : $sell_mem_idx; //bgcolor회색,흰색 바꾸는 기준_idx : odr_idx  발주서 기준이다.
			
			if ($criteria_now_idx != $criteria_idx && $new_odr_det_idx_chk != $odr_det_idx_chk) {
				if ($bgcolor == "") { 
					$bgcolor_now="background-color:#ffffff;";
				}else{
					//$bgcolor_now ="background-color:#f7f7f7;";
					if ($odr_type=="B"){
						$bgcolor_now ="background-color:#ffff99;"; //2016-04-10 노란색
					}else{
						$bgcolor_now ="background-color:#dce6f2;"; //2016-10-09 옅은파란
					}
					
				}
			}

			if ($criteria_now_idx != $criteria_idx || $new_odr_det_idx_chk != $odr_det_idx_chk || $saved_part != $part_type){
		?>		
		<tr>
			<td colspan="<?=$colspan?>" class="title-box" >
				<?if ($odr_type == "S" && ($criteria_now_idx != $criteria_idx || $new_odr_det_idx_chk != $odr_det_idx_chk)){?><div class="nation2" lang="en"><img src="/kor/images/nation_title_<?=$buy_nation?>.png" alt="<?=$buy_company_nm?>">&nbsp;&nbsp;<a href="javascript:side_company_info2(<?=$buy_com_idx?>,'<?=$odr_type?>')" class="c-blue"><?=($status==1 || $status==16 || $status==7)? "&nbsp;":$buy_company_nm;?></a></div><?}?>
				<?if ($saved_part != $part_type || $criteria_now_idx != $criteria_idx || $new_odr_det_idx_chk != $odr_det_idx_chk){?>
				<h3 class="title"><img src="/kor/images/stock_title0<?=$part_type?><?if ($fr=="M"){echo "_s";}?>.gif" alt="<?=GF_Common_GetSingleList("PART",$part_type)?>"></h3>
				<?
				$saved_part = $part_type;	
				}?>
			</td>
		</tr>
		<?}?>
		<?// goMenuJump() splData[0] : status splData[1] : sellmem_idx splData[2] : (odr or fty ) splData[3] : validyn (72시간 적용)?>
		<?if($fr=="M" || $fr=="S"){
				//$goJump = "onclick=\"javascript:goMenuJump('".$status.":".$sell_mem_idx.":odr:Y')\" ";				
				$status_6 = "";
				
				/*if ($odr_det_status==6)
				{
					$status_6 = " and odr_det_idx='".$odr_det_idx."'  ";			
				}

				if ($odr_det_status==21 && $odr_type=="S")
				{
					$status_6 = " and odr_det_idx='".$odr_det_idx."'  ";				
				}*/

				$qrycnt = QRY_CNT("odr_history", "and odr_idx =".$odr_idx.$status_6." and reg_mem_idx <> ".$_SESSION["MEM_IDX"] ." and confirm_yn ='N'");
				$status = get_any("odr_history", "status" , "odr_history_idx = (SELECT max( odr_history_idx ) FROM odr_history WHERE odr_idx =$odr_idx )"); 
				if($page_val != $status && $status != "")
				{
					array_push($array_status, $status);
				}

				
				$result_arr = array_unique($array_status);				
				
				$num = array_count_values($array_status);
				foreach( $num as $key => $value ){

					if($key == $status)
					{
						if ($criteria_now_idx != $criteria_idx || $new_odr_det_idx_chk != $odr_det_idx_chk) {
							array_push($array_real_status, $status);
							
							$num_real = array_count_values($array_real_status);
							foreach( $num_real as $key => $value ){
								if($key == $status)
								{
									$page_val = $value;
								}
							}
							
						}
						
					}
				 
				}

				if ($qrycnt >0) { 		

					if ($status_now == $status) { 

						if ($criteria_now_idx != $criteria_idx) {
							
							$page = $page + 1;
						}
					}else{
						if ($criteria_now_idx != $criteria_idx) {
							
							$page = 1;
						}
					}
					$status_now = $status;
					
					if ($odr_det_status==6)
					{						
						$goJump = "style='cursor:pointer;padding:0;' onclick=\"javascript:goMenuJump('".$odr_det_status.":".$sell_mem_idx.":odr:Y:".$page."')\" ";
					}
					else
					{

						$goJump = "style='cursor:pointer;padding:0;' onclick=\"javascript:goMenuJump('".$status.":".$sell_mem_idx.":odr:Y:".$page."')\" ";
					}	
					
				
				}else{
					
					if ($odr_type =="B" && $save_yn =="Y"){
						$goJump = "title=\"저장\" style='cursor:pointer;padding:0;' onclick=\"javascript:openCommLayer('layer3','05_04', '?odr_idx=".$odr_idx."')\" ";
					}else{
						
						if ($odr_det_status==6)
						{
							$goJump = "title=\"".GF_Common_GetSingleList("ORD",$odr_det_status)."\" ";	
						}
						else
						{
							$goJump = "title=\"".GF_Common_GetSingleList("ORD",$status)."\" ";	
						}						
					}
				} 
			}

			if(strpos($odr_price, ".") == false)  
			{
				$price_val= number_format($odr_price,2);
			}				
			else
			{
				$price_val= $odr_price;
			}
			if ($odr_status==0 || $odr_status==1 || $odr_status==2 || $odr_status==3 || $odr_status==8 || $odr_status==16 || $odr_status==18 || $odr_status==19 || $odr_status==20 || $odr_status==31)
			{
				$total_price_value = round_down($odr_quantity*$odr_price,4);				
			}
			else
			{
				$total_price_value = round_down($supply_quantity*$odr_price,4);
				
			}

			
		?>
		<tr class="criteria" criteria_idx="<?=$criteria_now_idx?>" odr_det_idx_chk="<?=$odr_det_idx_chk?>">
			<td ><?$j = ($criteria_now_idx != $criteria_idx || $new_odr_det_idx_chk != $odr_det_idx_chk)? 1:$j;
			echo $j;?></td>
			<?if ($odr_type == "B"){?><td ><img src="/kor/images/nation_title<?=($odr_type=="B"?"2":"")?>_<?=$nation?>.png" alt="<?=GF_Common_GetSingleList("NA",$nation)?>"></td><?}?>
			<td class="t-lt" <?=$goJump?>><?=get_cut($part_no,($odr_type == "B"?"15":"25"),($fr=="S"?"":"."))?></td>
			<td class="t-lt" <?=$goJump?>><?=get_cut($manufacturer,($odr_type == "B"?"10":"20"),".")?></td>
			<td <?=$goJump?> ><?=$package;?></td>
			<td <?=$goJump?> ><?=$dc;?></td>
			<td <?=$goJump?> ><?=$rhtype?></td>
			<!--odr_stock으로 바꿈 2016-11-8-->
			
			<?if ($odr_status==0 || $odr_status==1 || $odr_status==2 || $odr_status==3 || $odr_status==8 || $odr_status==16 || $odr_status==18 || $odr_status==19 || $odr_status==20 || $odr_status==31){?>
				<?if ($part_type==2){?>
					<td  <?=$goJump?>  class="t-rt">I</td>
				<?}else{?>
					<td  <?=$goJump?>  class="t-rt"><?=$odr_stock<=0?"":number_format($odr_stock)?></td>
				<?}?>			
			<?}else if ($odr_status==7){?>
				<td  <?=$goJump?>  class="t-rt"><?=$odr_stock<=0?"":number_format($odr_stock)?></td>
			<?}else{?>
				<td  <?=$goJump?>  class="t-rt"><?=$supply_quantity<=0?"":number_format($supply_quantity)?></td>
			<?}?>
			<!--바꿈 2016-11-8-->
			<td  <?=$goJump?>  class="t-rt">$<?=$price_val?></td>
			<?if ($fr == "S"){?>	
				<?if ($odr_status==0 || $odr_status==1 || $odr_status==2 || $odr_status==3 || $odr_status==8 || $odr_status==16 || $odr_status==18 || $odr_status==19 || $odr_status==20 || $odr_status==31){?>
					<td  <?=$goJump?> class="t-rt c-blue" ><?=$odr_quantity<=0?"":number_format($odr_quantity)?></td>			
					<td  <?=$goJump?> class="t-rt c-red" ><?=$supply_quantity<=0?"":number_format($supply_quantity)?></td>
				<?}else if ($odr_status==7){?>
					<td  <?=$goJump?>  class="t-rt"><?=$odr_quantity<=0?"":number_format($odr_quantity)?></td>
					<td  <?=$goJump?> class="t-rt c-red" ><?=$supply_quantity<=0?"":number_format($supply_quantity)?></td>
				<?}else{?>
					<td  <?=$goJump?> class="t-rt" >$<?=number_format($total_price_value,4)?></td>
				<?}?>		
			
			<?}?>

			<?
				if($part_type =="2")
				{
					if ($period)
					{
						if ($period=="stock")
						{
							$period = str_replace("WK","",$period)."";
							$period_style="";
						}
						else
						{
							$period = str_replace("WK","",$period)."WK";
							$period_style="c-red";
						}
					}
					else
					{
						$period = "확인";
						$period_style="c-red";
					}
					
					
				}
			?>
			<td class="delivery" <?=$goJump?>><?=($period)?"<span class='$period_style'>".$period."</span>":(($part_type=="2"||$part_type=="5"||$part_type=="6")?"<span lang='ko' class='stock'>확인</span>":"Stock")?></td>
			<?if ($odr_type == "B") {  //--구매자 화면일경우?>
				<?//if ((($part_type=="2"||$part_type=="5"||$part_type=="6") && $period=="") || ($save_yn=="Y")){?>
				<?if ((($part_type=="2"||$part_type=="5"||$part_type=="6") && ($status ==1 || $status ==16 || $status ==7 )) || ($save_yn=="Y")){  //2016-04-04?>
				<td class="c-blue" >&nbsp;</td>
				<?}else{?>
				<td class="c-blue" onclick='side_company_info2(<?=$com_idx?>,"<?=$odr_type?>")' Style="cursor:pointer;"><?=get_cut($company_nm,7,".") //상호 노출?></td>
				<?}?>
			<?}?>
		</tr>
	
<?			$criteria_idx = $criteria_now_idx;
			$bgcolor = $bgcolor_now;
			$new_odr_det_idx_chk = $odr_det_idx_chk;
		}
   }
}
function GET_Order($odr_type,$this_mem_idx){
		?>
	<table class="stock-list-table">
		<thead>
			<tr>
				<th scope="col" style="width:14px">No.</th>
				<?if ($odr_type == "B"){?>
				<!--구매-->
					<th scope="col" style="width:77px">Nation</th>
					<th scope="col" class="t-lt" style="width:150px;">Part No.</th>
					<th scope="col" class="t-lt" style="width:<? echo ($odr_type == "S") ? '80px' : '80px' ?>">Manufacturer</th>
					<th scope="col" style="width:100px">Package</th>
					<th scope="col" style="width:26px">D/C</th>
					<th scope="col" style="width:25px">RoHS</th>
					<th scope="col" class="t-rt" style="width:60px">Q'ty</th>
					<th scope="col" class="t-rt" style="width:60px">Unit Price</th>
					<th scope="col" class="delivery" lang="ko" style="width:29px">납기</th>
					<th scope="col" style="width:38px">Company</th>
				<?}else{?>
				<!--판매-->
					<th scope="col" class="t-lt" style="width:170px;">Part No.</th>
					<th scope="col" class="t-lt" style="width:<? echo ($odr_type == "S") ? '120px' : '120px' ?>">Manufacturer</th>
					<th scope="col" style="width:60px">Package</th>
					<th scope="col" style="width:26px">D/C</th>
					<th scope="col" style="width:25px">RoHS</th>
					<th scope="col" class="t-rt" style="width:42px">Q'ty</th>
					<th scope="col" class="t-rt" style="width:42px">Unit Price</th>
					<th scope="col" class="delivery" lang="ko" style="width:29px">납기</th>
				<?}?>
			</tr>
		</thead>
		<tbody id="orderlist">
		<?	//for ($i = 1; $i<=6; $i++){
				//echo GET_RCD_DET_LIST($i , $odr_type, " and a.".($odr_type=="S"?"sell_":"")."mem_idx=$this_mem_idx ", "M");//JSJ
				echo GET_RCD_DET_LIST($i , $odr_type, " and a.".($odr_type=="S"?"sell_":"")."mem_idx=$this_mem_idx and b.odr_status NOT IN(99,15,30) ", "M"); //det 상태가 99(Log)가 아닌놈만
			//}?>
		</tbody>
	</table>
<?}

function GF_GET_REMIT_LIST($yr,$mon,$remit_ty,$mem_id, $mem_nm, $charge_method, $invoice_no,$page){
?>
<SCRIPT LANGUAGE="JavaScript">
	$(document).ready(function(){
		$(".pagination a.link").click(function(){
			var f = document.fr;
				var yr = $("#fr #yr option:selected").val();
				var mon = $("#mon option:selected").val();
				var remit_ty = $("#remit_ty").val();
				var mem_id = $("#remitlist #mem_id option:selected").val();
				var mem_nm = $("#remitlist #mem_nm option:selected").val();
				var charge_method = $("#remitlist #charge_method option:selected").val();
				var invoice_no = $("#remitlist #invoice_no option:selected").val();

				showajaxParam("#remitlist", "remitlist", "page="+$(this).attr("num")+"&yr="+yr+"&mon="+mon+"&remit_ty="+remit_ty+"&mem_id="+mem_id+"&mem_nm="+mem_nm+"&charge_method="+charge_method+"&invoice_no="+invoice_no); 
		});
		$("#remitlist select").change(function(){
			$(".myrecord").click();
		});
	});
</SCRIPT>

<?	
	$conn = dbconn();	
	$yr = $yr =="N/A"? "" : $yr;
	$mon = $mon =="N/A" ? "" : $mon;
	$mon = substr("0".$mon, -2);
	//echo $remit_ty;
	$remit_code = "1,9";//$remit_ty == "C"?"1":"9";
	global $session_com_idx;
	$bgcolor="#f7f7f7";
	
	 
	if ($yr > 0 && $mon > 0 ){
		$addClause = "and DATE_FORMAT(a.reg_date, '%Y-%m') = '$yr-$mon' ";
	}elseif ($yr > 0 ) {
		$addClause = "and DATE_FORMAT(a.reg_date, '%Y') = '$yr' ";
	}elseif ($mon > 0){
		$addClause = "and DATE_FORMAT(a.reg_date, '%m') = '$mon' ";
	}


	if ($mem_id){
			$addClause .= "and mem_id = '$mem_id' ";
	}
	if ($mem_nm){
			$addClause .= "and mem_nm = '$mem_nm' ";
	}
	if ($charge_method){
			$addClause .= "and charge_method = '$charge_method' ";
	}
	if ($invoice_no){
			$addClause .= "and invoice_no like '$invoice_no%' ";
	}

	//2016-06-02 : 아래 쿼리수정. MyBank 내역 쿼리조건이 전혀 맞지 않음 -ccolle
	/** JSJ
	$sql = "SELECT charge_type, mybank_idx, DATE_FORMAT(a.reg_date, '%Y년%m월%d일') reg_date, mem_id, case when b.rel_idx = 0 then mem_nm else concat(mem_nm,'/',pos_nm) end as mem_nm, case when charge_method = 1 then '신용카드' else '은행송금' end as charge_method_nm, charge_method, put_money_yn ,mybank_amt, invoice_no , charge_amt FROM mybank a left outer join member b 
			on a.mem_idx = b.mem_idx 
			where (a.mem_idx =$session_com_idx or a.rel_idx =$session_com_idx)
			and a.charge_type in ($remit_code) and mybank_yn != 'Y' ".$addClause.
			"order by mybank_idx desc";	
	**/

	$searchand ="and (a.mem_idx =$session_com_idx or a.rel_idx =$session_com_idx)
			and mybank_yn = 'Y' and charge_amt !=0 ".$addClause;
	$sql = "SELECT charge_type, mybank_idx, DATE_FORMAT(a.reg_date, '%Y %m %d') reg_date, mem_id, case when b.rel_idx = 0 then mem_nm else concat(mem_nm,'/',pos_nm) end as mem_nm, case when charge_method = 1 then '신용카드' else '은행송금' end as charge_method_nm, charge_method, put_money_yn ,mybank_amt, invoice_no , charge_amt FROM mybank a left outer join member b 
			on a.mem_idx = b.mem_idx 
			where 1=1 $searchand  
			order by mybank_idx desc";	
			
	?>	<table class="stock-list-table">
			<thead>
				<th scope="col" class="th2" lang="ko" style="width:91px">날짜</th>
				<th scope="col" class="th2 t-lt">
					<div class="select type2 opt1" style="width: 75px;">
						<label for="mem_id">User ID</label>
						<select name="mem_id" id="mem_id">
						<option value="" <?=$mem_id==""?"selected":""?>>User ID</option>
						</select>
					</div>
</th>
				<th scope="col" class="th2 t-lt" lang="ko">
					<div class="select type2 opt1" style="width: 90px;">
						<label for="mem_nm">성명/직함</label>
						<select name="mem_nm" id="mem_nm">
						<option value="" <?=$mem_nm==""?"selected":""?>>성명/직함</option>
						</select>
					</div>
				</th>				
				<th scope="col" class="th2" lang="ko">
					<div class="select type2 opt1" style="width: 85px;">
						<label for="charge_method">방법</label>
						<select name="charge_method" id="charge_method">
						<option value="" <?=$charge_method==""?"selected":""?>>방법</option>
						<option value="1" <?=$charge_method=="1"?"selected":""?>>신용카드</option>
						<option value="2" <?=$charge_method=="2"?"selected":""?>>은행송금</option>
						</select>
					</div></th>
				<!--<th scope="col" class="th2" lang="ko">내역</th>-->
				<th scope="col" class="th2">
					<div class="select type2 opt1" style="width: 100px;">
						<label for="invoice_no">Invoice No.</label>
						<select name="invoice_no" id="invoice_no">
						<option value="" <?=$invoice_no==""?"selected":""?>>Invoice No.</option>
						<option value="DPI" <?=$invoice_no=="DPI"?"selected":""?>>Down Payment Invoice No. </option>
						<option value="CMBI" <?=$invoice_no=="CMBI"?"selected":""?>>Charge My Bank Invoice No. </option>
						<option value="EI" <?=$invoice_no=="EI"?"selected":""?>>Escrow Invoice No. </option>
						<option value="DI" <?=$invoice_no=="DI"?"selected":""?>>Deposit Invoice No.</option>
						<option value="RI" <?=$invoice_no=="RI"?"selected":""?>>Refund Invoice No.</option>
						<option value="FI" <?=$invoice_no=="FI"?"selected":""?>>Fright Invoice No.</option>
						<option value="WI" <?=$invoice_no=="WI"?"selected":""?>>Withdrawal Invoice No.</option>
						<option value="RFI" <?=$invoice_no=="RFI"?"selected":""?>>Rework Fee Invoice No.</option>
						<option value="CFI" <?=$invoice_no=="CFI"?"selected":""?>>Compensation Fee Invoice No.</option>
						<option value="TFI" <?=$invoice_no=="TFI"?"selected":""?>>Test Fee Invoice No.</option>
						<option value="MFI" <?=$invoice_no=="MFI"?"selected":""?>>Membership Fee Invoice No.</option>
						</select>
					</div></th>
				<th scope="col" class="th2 t-rt" lang="ko">입금</th>
				<th scope="col" class="th2 t-rt" lang="ko">출금</th>
				<th scope="col" class="th2 t-rt" lang="ko">잔액</th>				
			</thead>
			<tbody>
			<?
				if(!$page){$page=1;}
				$recordcnt=15;
				$viewpagecnt =	10;

				$cnt = QRY_CNT("mybank a",$searchand);
				$totalpage = QRY_TOTALPAGE($cnt,$recordcnt);
				$startno = ($page-1) * $recordcnt;
				$limit = " LIMIT $startno,$recordcnt";
				
				$result=mysql_query($sql.$limit,$conn) or die ("SQL ERROR : ".mysql_error());
	$remit_cnt=mysql_num_rows($result);
	if ($remit_cnt > 0 ) {
		while($row = mysql_fetch_array($result)){
			$mybank_idx= replace_out($row["mybank_idx"]);
			$reg_date= replace_out($row["reg_date"]);
			$mem_id= replace_out($row["mem_id"]);
			$mem_nm= replace_out($row["mem_nm"]);
			$charge_method= replace_out($row["charge_method"]);
			$charge_type= replace_out($row["charge_type"]);
			$charge_method_nm= replace_out($row["charge_method_nm"]);
			$put_money_yn= replace_out($row["put_money_yn"]);
			$mybank_amt= replace_out($row["mybank_amt"]);
			$invoice_no= replace_out($row["invoice_no"]);
			$charge_amt= replace_out($row["charge_amt"]);
			if ($bgcolor=="#ffffff") { 
				$bgcolor="#f7f7f7";
			}else{
				$bgcolor="#ffffff";
			}
			$inv =explode("-",$invoice_no);
			$inv_real= preg_replace("/([0-9])+$/","",$inv[0]);
			if ($inv_real=="WI"){
				$layer_no ="23_23";
			}elseif ($inv_real=="CMBI"){
				$layer_no ="01_20";
			}
		?>
		
		<tr  style="background-color:<?=$bgcolor?>;">
			<td class="c-red2" lang="ko"><?=$reg_date?></td>
			<td class="t-lt"><?=get_cut($mem_id,15,".")?></td>
			<td class="t-lt" lang="ko"><?=$mem_nm?></td>
			
				<!--<td class="t-rt"  lang="ko"><?=GF_Common_GetSingleList("MYBK",$charge_type)?></td>-->
				<td ><?=$charge_method_nm?></td>
				<td class="c-blue2">
				<?if ($layer_no){?><a href='javascript:openCommLayer("layer5","<?=$layer_no?>","?invoice_no=<?=$invoice_no?>&forread=Y")'><?=$invoice_no?></a>
				<?}else{echo $invoice_no;}?>
				</td>
				<td class="c-blue2 t-rt"><?if ($charge_type =="1"){echo "$".number_format($charge_amt,2);}?></td>				
				<td class="c-red2 t-rt"><?if ($charge_type !="1"){echo "$-".number_format($charge_amt,2);}?></td>


				<td class="c-purple t-rt">$<?=number_format($mybank_amt,2)?></td>
			
		</tr>
		
		<?}
	  ?>
	  </tbody>
		</table>		
		<div class="pagination">
						<? include $_SERVER["DOCUMENT_ROOT"]."/include/paging2.php"; ?>									
					</div>
<?	}	
}




							
function GET_TURNKEY_ODRDET_LIST($odr_type,$searchand,$fr){
	$result2 =QRY_RCD_DET_LIST(5,$searchand,1);
	$cnt=mysql_num_rows($result2);
	if ($cnt > 0){?>
	<div class="date-box" lang="en"><span class="c2" lang="ko">턴키판매</span></div>
				<div class="stock-list-wrap">
					<table class="stock-list-table bg-type4">
						<thead>
							<tr>
								<th scope="col" style="width:23px">No.</th>
								<?if ($odr_type =="B"){?><th scope="col"style="width:80px">Nation</th><?}?>
								<th scope="col" class="t-lt">Title</th>
								<th scope="col" class="t-rt" style="width:110px">Price</th>
								<?if ($odr_type =="B"){?><th scope="col" style="width:50px">Company</th><?}?>
							</tr>
						</thead>
						<tbody>
			<?
				while($row2 = mysql_fetch_array($result2)){
						$odr_idx = replace_out($row2["odr_idx"]);
						$odr_det_idx = replace_out($row2["odr_det_idx"]);
						$part_idx= replace_out($row2["a.part_idx"]);
						$part_type= replace_out($row2["part_type"]);
						$part_no= replace_out($row2["part_no"]);
						$nation= replace_out($row2["nation"]);
						$sell_mem_idx= replace_out($row2["mem_idx"]);
						$price= replace_out($row2["price"]);
						$rel_idx= replace_out($row2["rel_idx"]);
						$odr_quantity= replace_out($row2["odr_quantity"]);
						$supply_quantity= replace_out($row2["supply_quantity"]);
						$com_idx = $rel_idx==0 ? $sell_mem_idx : $rel_idx;
						if ($com_idx){
						$company_nm = get_any("member","mem_nm_en", "mem_idx=$com_idx"); 				
						//구매자 정보
						$odr = get_odr($odr_idx);
						$buy_mem_idx = $odr[mem_idx];
						$buy_rel_idx = $odr[rel_idx];		
						$buy_com_idx = ($buy_rel_idx ==0? $buy_mem_idx : $buy_rel_idx);
						$mem  =get_mem($buy_mem_idx);
						$buy_nation =  $mem[nation];
						$buy_company_nm = $mem[mem_nm_en];
						$j++;			
						$criteria_now_idx = $odr_type=="S"? $buy_mem_idx : $sell_mem_idx; //bgcolor회색,흰색 바꾸는 기준_idx
						
						if ($criteria_now_idx != $criteria_idx) {
							if ($bgcolor == "") { 
								if ($odr_type=="B"){
									$bgcolor_now ="background-color:#ffff99;"; //2016-04-10 노란색
								}else{
									$bgcolor_now ="background-color:#dce6f2;"; //2016-10-09 옅은파란
								}
							}else{
								$bgcolor_now ="";
							}
						}
						if ($odr_type =="S"){
						?>
						<tr>
							<td class="title-box" colspan="3">
								<div class="mr-tb5"><img alt="Special Price Stock" src="/kor/images/nation_title_<?=$buy_nation?>.png"> <span class="c-blue" lang="en"><?=$buy_company_nm?></span></div>
							</td>
						</tr>
						<?}?>
						<tr class="criteria" criteria_idx="<?=$criteria_now_idx?>" style='cursor:pointer;'>
							<td><?=$j?></td>
							<?if ($odr_type =="B"){?><td><img src="/kor/images/nation_title2_<?=$nation?>.png"></td><?}?>
							<td class="t-lt"><?=get_cut($part_no,70,"..")?></td>							
							<td class="t-rt">US$<?=number_format($price,2)?></td>
							<?if ($odr_type =="B"){?><td><?=$company_nm?></td><?}?>
						</tr>
				<?}
				}
				?>
				</tbody>
					</table>
				</div>
		<?
	}
}

function GF_GET_TURNKEY_RCD_LIST($odr_type, $sch_part_no,$yr,$mon,$this_mem_idx,$page){
$colspan = $odr_type == "B"? "5" : "4";
?>
<?	
	
	if ($mon=="N/A"){
		$start = 1;
		$end = 12;		
	}else{
		$start = $mon;
		$end = $mon;
	}	
	
	if ($yr =="N/A"){
		$start_yr = "2015";
		$end_yr = date("Y");
	}else{
		$start_yr=$yr;
		$end_yr=$yr;
	}
	$conn = dbconn();	
	$k=1;
	for ($j = $start_yr; $j <= $end_yr; $j++) {  
	for ($i = $start; $i <= $end; $i++) {  
		$mki = substr("0$i" ,-2);
		$yr = $j;
		if ($sch_part_no){
			$sn = "and odr_idx in (select odr_idx from odr_det a left outer join part b on a.part_idx = b.part_idx and b.part_no like '%$sch_part_no%')";
		}
		
		$sql = "SELECT * FROM odr where  DATE_FORMAT(reg_date,'%Y-%m') = '$yr-$mki' and odr_no <> '' and invoice_no <> '' and ".($odr_type=="S"?"sell_":"")."mem_idx =$this_mem_idx and turnkey_idx is not null $sn";
		//echo $sql;
		$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
		$odr_cnt=mysql_num_rows($result);
		if ($odr_cnt>0) {
			
			if($k==1){
					?><div class="date-box" lang="en"><span class="c2" lang="ko">턴키판매</span></div>
			<div class="stock-list-wrap">
			<table class="stock-list-table bg-type4">
				<thead>
					<tr>
					<th scope="col" style="width:23px">No.</th>
					<?if ($odr_type == "B"){?><th scope="col"style="width:80px">Nation</th><?}?>
					<th scope="col" class="t-lt" style="width:480px">Title</th>
					<th scope="col" class="t-rt" style="width:110px">Price</th>
					<?if ($odr_type == "B"){?><th scope="col">Company</th><?}?>
					<th scope="col">&nbsp;</th>
				</tr>
			</thead>
					
					<?
			}
			while($row = mysql_fetch_array($result)){			
				$odr_idx = replace_out($row["odr_idx"]);
				
				//구매자 정보
				$buy_mem_idx = replace_out($row["mem_idx"]);
				$buy_rel_idx = replace_out($row["rel_idx"]);
				$buy_com_idx = ($buy_rel_idx ==0? $buy_mem_idx : $buy_rel_idx);
				$mem  =get_mem($buy_mem_idx);
				$buy_nation =  $mem[nation];
				$buy_company_nm = $mem[mem_nm_en];
				$searchand = "and odr_idx = $odr_idx ";
				if ($sch_part_no){
					$searchand .= "and part_no like '%$sch_part_no%'";
				}

				$result2 =QRY_ODR_DET_LIST(0,$searchand,0);
				
				while($row2 = mysql_fetch_array($result2)){
					$odr_det_idx = replace_out($row2["odr_det_idx"]);
					$part_idx= replace_out($row2["a.part_idx"]);
					$part_type= replace_out($row2["part_type"]);
					$part_no= replace_out($row2["part_no"]);
					$nation= replace_out($row2["nation"]);
					$sell_mem_idx= replace_out($row2["mem_idx"]);
					$manufacturer= replace_out($row2["manufacturer"]);
					$package= replace_out($row2["package"]);
					$dc= replace_out($row2["dc"]);
					$rhtype= replace_out($row2["rhtype"]);
					$quantity= replace_out($row2["quantity"]);
					$price= replace_out($row2["price"]);
					$period= replace_out($row2["period"]);
					$rel_idx= replace_out($row2["rel_idx"]);
					$odr_quantity= replace_out($row2["odr_quantity"]);
					$reg_date= replace_out($row2["reg_date"]);
					$supply_quantity= replace_out($row2["supply_quantity"]);
					$com_idx = $rel_idx==0 ? $sell_mem_idx : $rel_idx;
					if ($com_idx){
					$company_nm = get_any("member","mem_nm_en", "mem_idx=$com_idx"); 	
					$end_yn = QRY_CNT("odr_history", "and odr_idx = $odr_idx  and status in (6,15)") > 0 ? "Y": "N";  //종료까지 무사히 왔는지 여부
					$fty_exist_yn =  QRY_CNT("fty_history", "and odr_idx = $odr_idx and odr_det_idx = $odr_det_idx") > 0 ?"Y":"N";  //불량 통보에 대한 절차가 기존에 진행 된 적이 있는지 여부

					if ($part_type =="2"){
						$dc = "NEW";
						$quantity="";
					}
					if ($part_type == "7"){
					?>
					<tbody>
					<tr>
						<td class="step-cell" colspan="<?=$colspan?>"> 
							<?if ($saved_yrmon != $yr."-".$i){?>
								<div class="date-box" lang="en"><span><?=$yr?></span><span><?=$i?> <strong lang="ko">월</strong></span></div>					
							<?
								$saved_yrmon = 	$yr."-".$i;
					}?>
						<?echo get_layer_step($odr_idx, $odr_det_idx , "odr");?>
						</td>
					</tr>
					<tr>
						<td class="title-box" colspan="<?=$colspan?>">
						<?if ($odr_type=="S"){?>						
							<div class="mr-tb5"><a href="javascript:side_company_info2(<?=$buy_com_idx?>,'<?=$odr_type?>')"><img src="/kor/images/nation_title_<?=$buy_nation?>.png"> <span class="c-blue" lang="en"><?=$buy_company_nm?></span></a><a href="javascript:;" class="f-rt recordbt"><img src="/kor/images/btn_record.gif" alt="기록"></a></div>
							<h3 class="title"><img src="/kor/images/stock_title0<?=$part_type?>.gif" alt="<?=GF_Common_GetSingleList("PART",$part_type)?>"></h3>
						</td>
						<?}else{?>
							<h3 class="title"><img src="/kor/images/stock_title0<?=$part_type?>.gif" alt="<?=GF_Common_GetSingleList("PART",$part_type)?>"></h3><a href="javascript:;" class="f-rt recordbt"><img src="/kor/images/btn_record2.gif" alt="기록"></a>
						<?}?>
						</td>
					</tr>
					<tr>
					<td><?=$k?></td>
					<?if ($odr_type == "B"){?><td><img src="/kor/images/nation_title<?=($odr_type=="B"?"2":"")?>_<?=$nation?>.png" alt="<?=GF_Common_GetSingleList("NA",$nation)?>"></td><?}?>
					<td class="t-lt"><?=$part_no?></td>
					<td class="t-rt" <?if ($odr_type == "S"){?>colspan="2"<?}?>>$<?=number_format($price,2)?></td>
					<?if ($odr_type == "B"){?><td><?if ($end_yn=="Y"){?><div class="c-blue" style="cursor:pointer;" onclick="side_company_info2(<?=$com_idx?>,'<?=$odr_type?>')"><?=$company_nm?></div>
					<?
					$now_date = date("Y-m-d H:i:s", strtotime(date('Y-m-d').' - 6month')); 
					$reg_date = get_any("odr","reg_date" , "odr_idx = $odr_idx");
					$fault_valid_yn = $now_date<=$reg_date?"Y":"N";					
					if($fty_exist_yn =="N" && $fault_valid_yn =="Y"){
					?>
					<a href="#" odr_det_idx="<?=$odr_det_idx?>" class="btn-pop-2102"><img src="/kor/images/btn_badness.gif" alt="불량통보" class="badness" style="display:none;"></a>
					<?}else{?>
						<img src="/kor/images/btn_badness_1.gif" alt="불량통보" title="보증기간 만료" class="badness" style="display:none;">
					<?}?>
					<?}?></td><?}?>			
				</tr>
				</tbody>
				<?}
					$k++;		
					}
				}								
			}
		?>
		
	<?}
	}}?>
	</table>
	</div>	
<?}
//2016-11-13 : 거래가 완료된 주문만 표시(진행중인 주문은 미 표시)
function GF_GET_RECORD_LIST($odr_type, $sch_part_no,$yr,$mon,$this_mem_idx,$page){
	$colspan = $odr_type == "B"? "11" : "9";
	$bgcolor=$odr_type=="B"?"#ffff99":"#dce6f2";


?>

<SCRIPT LANGUAGE="JavaScript">
	$(document).ready(function(){
		$(".pagination a.link").click(function(){
			var f = document.fr;
				var yr = $("#fr #yr option:selected").val();
				var mon = $("#mon option:selected").val();
				var remit_ty = $("#remit_ty").val();
				showajaxParam("#remitlist", "remitlist", "page="+$(this).attr("num")+"&yr="+yr+"&mon="+mon+"&remit_ty="+remit_ty); 
		});
	});
</SCRIPT>

<div class="hd-type-wrap">
	<table class="stock-list-table bg-type4 main">
		<thead>
			<tr>
				<th scope="col" style="width:23px">No.</th>
				<?if ($odr_type == "B"){?><th scope="col" style="width:80px">Nation</th><?}?>
				<th scope="col" class="t-lt" style="width:150px;">Part No.</th>
				<th scope="col" class="t-lt" style="width:100px;">Manufacturer</th>
				<th scope="col" style="width:80px;">Package</th>
				<th scope="col" style="width:36px">D/C</th>
				<th scope="col" style="width:36px">RoHS</th>
				<th scope="col" class="t-rt" style="width:65px">Q'ty</th>
				<th scope="col" class="t-rt" style="width:65px">Unit Price</th>
				<th scope="col" class="t-rt" style="width:70px;padding-right:5px;">Amount</th>
				<?if ($odr_type == "B"){?><th scope="col" class="t-ct" style="width:70px;">Company</th><?}?>
			</tr>
		</thead>
<?		
	$mki = substr("0$mon" ,-2);
	if ($yr !="N/A" && $mon != "N/A"){
		$dateClause = "and DATE_FORMAT(reg_date,'%Y-%m') = '$yr-$mki'";		
	}elseif ($yr!= "N/A" && $mon == "N/A"){
		$dateClause = "and DATE_FORMAT(reg_date,'%Y') = '$yr'";		
	}elseif ($yr=="N/A" && $mon !="N/A"){
		$dateClause = "and DATE_FORMAT(reg_date,'%m') = '$mki'";		
	}else{
		$dateClause ="";
	}
		$conn = dbconn();			
		if ($sch_part_no){
			$sn = "and odr_idx in (select odr_idx from odr_det a left outer join part b on a.part_idx = b.part_idx and b.part_no like '%$sch_part_no%')";
		}
		
		$searchand = "and odr_status IN('6', '8','13','14','15','25','26','27','28','29','30') $dateClause and odr_no <> ''  and ".($odr_type=="S"?"sell_":"")."mem_idx =$this_mem_idx $sn";
		//2016-11-13 : 쿼리 수정(거래 완료된 주문만)
		//$sql = "SELECT * FROM odr where  odr_status <> 99 and DATE_FORMAT(reg_date,'%Y-%m') = '$yr-$mki' and odr_no <> '' and invoice_no <> '' and ".($odr_type=="S"?"sell_":"")."mem_idx =$this_mem_idx $sn order by odr.odr_idx desc";
		$sql = "SELECT * FROM odr where 1=1 $searchand order by odr.odr_idx desc";
		//echo $sql."<br><br>";

		if(!$page){$page=1;}
		$recordcnt=20;
		$viewpagecnt =	10;

		$cnt = QRY_CNT("odr a",$searchand);

		$totalpage = QRY_TOTALPAGE($cnt,$recordcnt);
		$startno = ($page-1) * $recordcnt;
		$limit = " LIMIT $startno,$recordcnt";
		
		$result=mysql_query($sql.$limit,$conn) or die ("SQL ERROR : ".mysql_error());
		$odr_cnt=mysql_num_rows($result);

		if ($odr_cnt>0) {?>
			<?
			while($row = mysql_fetch_array($result)){			//$result : odr
				$odr_idx = replace_out($row["odr_idx"]);
				
				//구매자 정보
				$buy_mem_idx = replace_out($row["mem_idx"]);
				$buy_rel_idx = replace_out($row["rel_idx"]);
				$nowyr =substr($row["reg_date"],0,4);
				$nowmon = substr($row["reg_date"],5,2);
				$buy_com_idx = ($buy_rel_idx ==0? $buy_mem_idx : $buy_rel_idx);
				$mem  =get_mem($buy_mem_idx);
				$buy_nation =  $mem[nation];
				$buy_company_nm = $mem[mem_nm_en];
				$searchand = "and odr_idx = $odr_idx ";
				if ($sch_part_no){
					$searchand .= "and part_no like '%$sch_part_no%'";
				}
				
				$result2 =QRY_ODR_DET_LIST(0,$searchand,0);     //$result2 : odr_det
				$cnt1=mysql_num_rows($result2);
				$y = 1;
				while($row2 = mysql_fetch_array($result2)){
					
					$odr_det_idx = replace_out($row2["odr_det_idx"]);
					$part_idx= replace_out($row2["a.part_idx"]);
					$part_type= replace_out($row2["part_type"]);
					$part_no= replace_out($row2["part_no"]);
					$nation= replace_out($row2["nation"]);
					$sell_mem_idx= replace_out($row2["mem_idx"]);
					$manufacturer= replace_out($row2["manufacturer"]);
					$package= replace_out($row2["package"]);
					$dc= replace_out($row2["dc"]);
					$rhtype= replace_out($row2["rhtype"]);
					$quantity= replace_out($row2["quantity"]);
					$price= replace_out($row2["price"]);
					$period= replace_out($row2["period"]);
					$rel_idx= replace_out($row2["rel_idx"]);
					$odr_quantity= replace_out($row2["odr_quantity"]);
					$reg_date= replace_out($row2["reg_date"]);
					$supply_quantity= replace_out($row2["supply_quantity"]);
					$odr_status= replace_out($row2["odr_status"]);
					$fault_quantity= replace_out($row2["fault_quantity"]);
					$com_idx = $rel_idx==0 ? $sell_mem_idx : $rel_idx;
					
					if( ($price == (int)$price) )
					{					
						$price_val = round_down($price,2);
						$price_val = number_format($price,2);
					}
					else {			
						$price_val = $price;
					}

					if ($com_idx ){

						$company_nm = get_any("member","mem_nm_en", "mem_idx=$com_idx"); 	
					
						$end_yn = QRY_CNT("odr_history", "and odr_idx = $odr_idx  and status in (6,15)") > 0 ? "Y": "N";  //종료까지 무사히 왔는지 여부
						$cancel_odr = QRY_CNT("odr_history", "and odr_idx = $odr_idx  and status in (8)") > 0 ? "Y": "N";  //취소주문인지 확인
						$cancel_in_odr = QRY_CNT("odr_history", "and odr_idx = $odr_idx  and status in (18)") > 0 ? "Y": "N";  //판매자 취소인지 구매자 취소인지 확인

						$fty_exist_yn =  QRY_CNT("fty_history", "and odr_idx = $odr_idx and odr_det_idx = $odr_det_idx") > 0 ?"Y":"N";  //불량 통보에 대한 절차가 기존에 진행 된 적이 있는지 여부
						
						if ($bgcolor=="#ffffff") { 
							$bgcolor=$odr_type=="B"?"#ffff99":"#dce6f2";
						}else{
							$bgcolor="#ffffff";
						}
						if ($part_type =="2"){
							$dc = "NEW";
							$quantity="";
						}
						//if ($part_type != "7"){	//턴키는 제외..??
						?>
						<tbody class="<?=$odr_type?>">
						<tr  style="background-color:#ffffff;">
							<td class="step-cell" colspan="<?=$colspan?>">
								<?if ($saved_yrmon != $nowyr."-".$nowmon){?>
									<div class="date-box" lang="en"><span><?=$nowyr?> <strong lang="ko">년</strong></span><span><?=$nowmon?> <strong lang="ko">월</strong></span></div>					
								<?
									$saved_yrmon = 	$nowyr."-".$nowmon;
						}?>
							<?echo get_layer_step($odr_idx, $odr_det_idx , "odr");?>
							</td>
						</tr>
						<?if($y==1){?>
						<tr  style="background-color:#ffffff;">
							<td class="title-box pd-r-not" colspan="<?=$colspan?>">
							<?if ($odr_type=="S"){?>						
								<div class="mr-tb5"><a href="javascript:side_company_info2('<?=$buy_com_idx?>','<?=$odr_type?>')"><img src="/kor/images/nation_title_<?=$buy_nation?>.png"> <span class="c-blue" lang="en"><?=$buy_company_nm?></span></a><a href="javascript:;" class="f-rt recordbt"><img src="/kor/images/btn_record.gif" alt="기록"></a></div>
								<h3 class="title"><img src="/kor/images/stock_title0<?=$part_type?>.gif" alt="<?=GF_Common_GetSingleList("PART",$part_type)?>"></h3>
							</td>
							<?}else{?>
								<h3 class="title"><img src="/kor/images/stock_title0<?=$part_type?>.gif" alt="<?=GF_Common_GetSingleList("PART",$part_type)?>"></h3><a href="javascript:;" class="f-rt recordbt" odr_det_idx="<?=$odr_det_idx?>"><img src="/kor/images/btn_record2.gif" alt="기록"></a>
							<?}?>
							</td>
						</tr>
						<?}?>
						<tr  style="background-color:#ffffff;">
							<td><?=$y?></td>
							<?if ($odr_type == "B"){?><td><img src="/kor/images/nation_title<?=($odr_type=="B"?"2":"")?>_<?=$nation?>.png" alt="<?=GF_Common_GetSingleList("NA",$nation)?>"></td><?}?>
							<td class="t-lt"><?=get_cut($part_no,"21",".")?></td>
							<td class="t-lt"><?=get_cut($manufacturer,"13",".")?></td>
							<td><?=$package?></td>
							<td><?=$dc?></td>
							<td><?=$rhtype?></td>						
							<!--16년 12월 27일 취소 시 발주수량 나머지 공급수량 고정 대표님 요청사항-->
							<?if ($cancel_odr=="Y" && $cancel_in_odr=="N"){?>
								<td class="t-rt"><?=$odr_quantity==0?"":number_format($odr_quantity)?></td>	
							<?}else{?>
								<td class="t-rt"><?=$supply_quantity==0?"":number_format($supply_quantity-$fault_quantity)?></td>	
							<?}?>									
							<td class="t-rt">$<?=$price_val?></td>
							<?if ($cancel_odr=="Y"){?>
								<?

								if ($cancel_in_odr=="Y")
								{
									$total_price_val = $supply_quantity*$price;
								}
								else
								{
									$total_price_val = $odr_quantity*$price;
								}							
								
								if ($total_price_val==(int)$total_price_val){								
									$total_price_val = number_format($total_price_val,2);
								}else{
									$total_price_val = number_format(round_down($total_price_val,4),4);
								}
								?>
								<td class="t-rt">$<?=$total_price_val?></td>
							<?}else{?>
								<?
								$total_price_val = ($supply_quantity-$fault_quantity)*$price;
								if ($total_price_val==(int)$total_price_val){								
									$total_price_val = number_format($total_price_val,2);
								}else{
									$total_price_val = number_format(round_down($total_price_val,4),4);
								}
								?>
								<td class="t-rt">$<?=$total_price_val?></td>
							<?}?>	
							
							<?if ($odr_type == "B"){?><td class="txt-r t-ct">
							<?if ($end_yn=="Y"){?>
							<div class="c-blue company_div" style="cursor:pointer;" onclick="side_company_info2(<?=$com_idx?>,'<?=$odr_type?>')">
								<?=get_cut($company_nm,"8",".")?>							
							</div>
							<?if ($cancel_odr=="Y"){?>
							<div class="c-blue company_div2" style="cursor:pointer;display: none;" onclick="side_company_info2(<?=$com_idx?>,'<?=$odr_type?>')">
								<?=get_cut($company_nm,"8",".")?>							
							</div>
							<?}?>
							<?
							$now_date = date("Y-m-d H:i:s", strtotime(date('Y-m-d').' - 6month')); 
							$reg_date = get_any("odr","reg_date" , "odr_idx = $odr_idx");
							$fault_valid_yn = $now_date<=$reg_date?"Y":"N";		
							if($fty_exist_yn =="N" && $fault_valid_yn =="Y"){
								$badness_chk = QRY_CNT("odr_history", "and odr_idx = $odr_idx  and status in (8)") > 0 ? "Y": "N";  //종료까지 무사히 왔는지 여부
								
								if($badness_chk =="N"){
							?>
							<a href="#" odr_det_idx="<?=$odr_det_idx?>" class="btn-pop-2102"><img src="/kor/images/btn_badness.gif" alt="불량통보" class="badness" style="display:none;"></a>
								<?}else{?>

								<?}?>
							<?}else{?>
								<!--<img src="/kor/images/btn_badness_1.gif" alt="불량통보" title="보증기간 만료" class="badness" style="display:none;">-->
							<?}?>
							<?}else{ ?> <div class="c-blue company_div2" style="cursor:pointer;" onclick="side_company_info2(<?=$com_idx?>,'<?=$odr_type?>')">
								<?=get_cut($company_nm,"8",".")?>							
							</div><?}?>

							</td>
							<?}?>			
						</tr>
					<?
					$fault_cnt = QRY_CNT("odr_history"," and odr_idx=$odr_idx and status=10 ");  //odr_det 수량

					if ($fault_cnt>=1)
					{
					?>

					<tr  style="background-color:#ffffff;">
						<td><?=$y+1?></td>
						<?if ($odr_type == "B"){?><td><img src="/kor/images/nation_title<?=($odr_type=="B"?"2":"")?>_<?=$nation?>.png" alt="<?=GF_Common_GetSingleList("NA",$nation)?>"></td><?}?>
						<td class="t-lt"><?=get_cut($part_no,"21",".")?></td>
						<td class="t-lt"><?=get_cut($manufacturer,"13",".")?></td>
						<td><?=$package?></td>
						<td><?=$dc?></td>
						<td><?=$rhtype?></td>	
						<td class="t-rt"><?=$fault_quantity==0?"":number_format($fault_quantity)?></td>	
						<td class="t-rt">$<?=$price_val?></td>						
						<?
						$total_price_val = $fault_quantity*$price;
						if ($total_price_val==(int)$total_price_val){								
							$total_price_val = number_format($total_price_val,2);
						}else{
							$total_price_val = number_format(round_down($total_price_val,4),4);
						}
						?>
						<td class="t-rt">$<?=$total_price_val?></td>							
						
						<?if ($odr_type == "B"){?><td class="txt-r t-ct">
						<?if ($end_yn=="Y"){?>
						<div class="c-blue company_div" style="cursor:pointer;" onclick="side_company_info2(<?=$com_idx?>,'<?=$odr_type?>')">
							<?=get_cut($company_nm,"8",".")?>							
						</div>
						<?if ($cancel_odr=="Y"){?>
						<div class="c-blue company_div2" style="cursor:pointer;display: none;" onclick="side_company_info2(<?=$com_idx?>,'<?=$odr_type?>')">
							<?=get_cut($company_nm,"8",".")?>							
						</div>
						<?}?>
						<?
						$now_date = date("Y-m-d H:i:s", strtotime(date('Y-m-d').' - 6month')); 
						$reg_date = get_any("odr","reg_date" , "odr_idx = $odr_idx");
						$fault_valid_yn = $now_date<=$reg_date?"Y":"N";		
						if($fty_exist_yn =="N" && $fault_valid_yn =="Y"){
							$badness_chk = QRY_CNT("odr_history", "and odr_idx = $odr_idx  and status in (8)") > 0 ? "Y": "N";  //종료까지 무사히 왔는지 여부
							
							if($badness_chk =="N"){
						?>
						<a href="#" odr_det_idx="<?=$odr_det_idx?>" class="btn-pop-2102"><img src="/kor/images/btn_badness.gif" alt="불량통보" class="badness" style="display:none;"></a>
							<?}else{?>

							<?}?>
						<?}else{?>
							<!--<img src="/kor/images/btn_badness_1.gif" alt="불량통보" title="보증기간 만료" class="badness" style="display:none;">-->
						<?}?>
						<?}else{ ?> <div class="c-blue company_div2" style="cursor:pointer;" onclick="side_company_info2(<?=$com_idx?>,'<?=$odr_type?>')">
							<?=get_cut($company_nm,"8",".")?>							
						</div><?}?>

						</td>
						<?}?>			
					</tr>
					<?	
					}
					?>


					<?if($y==$cnt1){?>
					<tr><td colspan='15' style='padding-top:20px; background-color:#FFFFFF;'></td></tr>
					<?}
					}
					$k++;
					}
					$y++;
				}
					
			}

			?>	<tr><td  colspan='15' style='padding-top:20px; background-color:#FFFFFF;' >
					<div class="pagination">
						<? include $_SERVER["DOCUMENT_ROOT"]."/include/paging2.php"; ?>									
					</div></td></tr>		
					<?
		//}?>
		
		</tbody></table>
	</div>	

<?}

function get_layer_step($odr_idx, $odr_det_idx, $his_ty){
	global $session_mem_idx,$pay;
	$searchand = " and odr_idx = $odr_idx and (odr_det_idx = '$odr_det_idx'  or odr_det_idx is null or odr_det_idx = 0)";
	$result = QRY_RCD_HISTORY_LIST(0,$searchand , 0 ,$his_ty, "odr_history_idx ");
	?>
		<div class="layer-step" lang="ko" style="display:none;">
			<ol>
			<?
			$cnt=mysql_num_rows($result);
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
				$blank = $cnt==$i ? " blank":"";   //맨 마지막 화살표 표시 여부
				if ($status =="5") { $pay = $etc1;}
				
				if ($session_mem_idx != $reg_mem_idx)
				{
					$cls = "class='c1".$blank."'";
					$etc_change = "change_img";
				}

				if ($status== "9" || $status== "10" ){
					$cls = "class='c1".$blank."'";
					if ($session_mem_idx == $reg_mem_idx){$cls = "";}
					if ($etc2){
						$etc2 = ($etc2 == "1")? "- 교환":(($etc2 == "2")? "- 환불":"- ".$etc2);
					}
				}
				if ($status== "15"){
						$cls = "class='c3".$blank."'";
				}
				if ($cls=="" && $blank!=""){
					$cls = "class='blank'";
				}


				if ($status_name=="완료")
				{
					$status_name = "<font color='red'>".$status_name."</font>";
				}

			?>
				<li <?=$cls?>>
					<span class="date"><?=$reg_date_fmt?></span>
					<strong class="status"><?=$status_name?></strong>
					<?
					if (($status_name=="선적완료" || $status_name=="추가선적완료" || $status_name=="반품방법" || $status_name=="반품선적완료")){
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
			<?
			}?>
			</ol>
		</div>
<?}
//-----------------------------------------------------------------------------------------------------------------------
function GET_RCD_HISTORY_LIST($loadPage, $odr_det_idx , $his_ty="odr"){
	global $session_mem_idx;
	global  $pay;	
	$searchand = "and odr_det_idx = '$odr_det_idx'";
	$result = QRY_RCD_HISTORY_LIST(0,$searchand , 1 ,$his_ty, $his_ty."_history_idx ");		
	$odr_idx = get_any("odr_det", "odr_idx", "odr_det_idx = $odr_det_idx");
?>
<!-- layer-step -->
	<input type="hidden" name="odr_idx" id="odr_idx_<?=$loadPage?>" value="<?=$odr_idx?>">
	<input type="hidden" name="loadPage" id="loadPage" value="<?=$loadPage?>">
	<div class="layer-step">
		<ol>
		<li>
				<span class="date"></span>
				<strong class="status record_history" odr_idx ="<?=$odr_idx?>" odr_det_idx = "<?=$odr_det_idx?>"><img src="/kor/images/img_icon_record.gif" alt="기록" title="기록" style="cursor:pointer;"></strong>
		</li>
		<?while($row = mysql_fetch_array($result)){
			$i++;				
			$odr_history_idx = replace_out($row["$his_ty"."_history_idx"]);
			$reg_date_fmt= replace_out($row["reg_date_fmt"]);
			$odr_idx = replace_out($row["odr_idx"]);
			$odr_det_idx = replace_out($row["odr_det_idx"]);
			$status = replace_out($row["status"]);
			$status_name = replace_out($row["status_name"]);
			$reg_mem_idx = replace_out($row["reg_mem_idx"]);
			$sell_mem_idx = replace_out($row["sell_mem_idx"]);
			$buy_mem_idx = replace_out($row["buy_mem_idx"]);
			
			$etc1= replace_out($row["etc1"]);
			$etc2= replace_out($row["etc2"]);	
			$reason= replace_out($row["reason"]);	
			$file1= replace_out($row["file1"]);	
			$file2= replace_out($row["file2"]);
			$cls = "class='c2 rec'";
			if ($status =="27") { $pay = $etc1;}
			if ($session_mem_idx == $reg_mem_idx){$cls = "class='rec'";}
			if ($reg_mem_idx != $sell_mem_idx && $reg_mem_idx != $buy_mem_idx){$cls = "class='rec c4'";}
		?>
			<li <?=$cls?>>
				<span class="date"><?=$reg_date_fmt?></span>
				<strong class="status"><?=$status_name?></strong>
				<span class="etc"><span lang="en"><?if ($etc1){?><?=$etc1?><?}?><?if ($etc2){?><?=$etc2?><?}?></span></span>
				
			</li>
		<?
		}		
	?>
		</ol>
	</div>
	<!-- //layer-step -->
	<?

	
	echo layerRecFile($loadPage,$reg_mem_idx , $reg_rel_idx , $odr_idx ,$his_ty , $odr_history_idx);
	  
}

function layerRecFile($loadPage,$reg_mem_idx , $reg_rel_idx , $odr_idx, $his_ty , $odr_history_idx){
		global  $pay;
		?>
	<!-- layer-file -->
	<div class="layer-file">
	<table>
		<tbody>
		<tr><?

			  //$reg_rel_idx = get_any("member", "rel_idx" , "mem_idx = $reg_mem_idx");	
			  $buy_rel_idx = get_any("odr", "rel_idx", "odr_idx = $odr_idx");
			  $buy_com_idx = $buy_rel_idx == 0 ? get_any("odr", "mem_idx", "odr_idx = $odr_idx") : $buy_rel_idx;
			  $result_mem =QRY_MEMBER_VIEW("idx",$buy_com_idx);
			  $row_mem = mysql_fetch_array($result_mem);
			  $buy_com_nation = $row_mem["nation"];
			  $buy_com_name = $row_mem["mem_nm_en"];					  
			  global $file_path;
			  
			   $fty_his = $his_ty =="odr"? get_odr_history($odr_history_idx) :get_fty_history($odr_history_idx);
			   $file1 = $fty_his[file1];
			   $file2 = $fty_his[file2];
			   $etc1 = $fty_his[etc1];
			   $etc2 = $fty_his[etc2];
			   $odr_det_idx = $fty_his[odr_det_idx];
			   $return_method = $fty_his[return_method];
			   $fault_select = $fty_his[fault_select];
			   $reason_ty = $fty_his[reason_ty];			   
			   $memo = $fty_his[reason];
			   $reg_mem_idx = $fty_his[reg_mem_idx];
				switch ($loadPage) {
					 case "21_07":
					 case "21_1_02":	 //판매 : 동의서				
				?>		
								<td class="file">
								<?if ($file1 || $file2) {?>
								<span class="c-blue" lang="ko">파일 / 사진 : </span>
								<?if ($file1){?><a href="<?=get_noimg($file_path,$file1,"javascript:;")?>" <?if ($file1){?>target="_blank"<?}?>>File1</a><?}else{?>File1,<?}?> <?if ($file2){?><a href="<?=get_noimg($file_path,$file2,"javascript:;")?>" target="_blank">File2</a><?}else{?>File2<?}?>
								<span class="img-wrap"><?if ($file1){?><a href="<?=get_noimg($file_path,$file1,"/kor/images/file_pt.gif")?>" target="_blank"><img <?=get_noimg_photo("../".$file_path, $file1, "/kor/images/file_pt.gif")?> alt=""></a><?}else{?><img <?=get_noimg_photo("../".$file_path, $file1, "/kor/images/file_pt.gif")?> alt=""><?}?></span>
								<span class="img-wrap"><?if ($file2){?><a href="<?=get_noimg($file_path,$file2,"/kor/images/file_pt.gif")?>" target="_blank"><img <?=get_noimg_photo("../".$file_path, $file2, "/kor/images/file_pt.gif")?> alt=""></a><?}else{?><img <?=get_noimg_photo("../".$file_path, $file2, "/kor/images/file_pt.gif")?> alt=""><?}?></span>
								<?}?>
							</td>
							<?if ($loadPage=="21_07"){?><td class="c-red2 w100 t-ct">회신서가 도착하였습니다.</td><?}?>
							<?if ($loadPage=="21_1_02"){?><td class="c-red2 w100 t-ct">동의서가 도착하였습니다.</td><?}?>
								<!--td class="file-memo"><?if ($memo && $loadPage=="21_1_02"){?>@@Memo: <strong><?=$memo?><?}?></strong></td-->
							</tr>
							</tbody></table></div>
				<?		 echo layerListData($loadPage ,$odr_idx,$odr_det_idx,$his_ty,$odr_history_idx);
					   break;  
				case "21_2_09":
					$ship_idx = get_any("odr_det", "ship_idx", "odr_idx ='$odr_idx' and odr_det_idx=odr_det_idx");
					$ship = get_ship($ship_idx);
					?>					
					<td class="company" rowspan="2"><img src="/kor/images/nation_title_<?=$buy_com_nation?>.png" alt="<?=GF_Common_GetSingleList("NA",$buy_com_nation)?>"> <span class="name"><?=$buy_com_name?></span></td>
					<td class="c-red2 t-rt">운송회사 : <img alt="" src="/kor/images/icon_<?=strtolower(GF_Common_GetSingleList("DLVR",$ship[ship_info]))?>.gif"> &nbsp;&nbsp;&nbsp;운송장번호 : <span class="c-blue" lang="en"><?=$ship[delivery_no]?></span></td>
				</tr>
				<tr>
					<td class="c-red2 t-rt">반품 선적 서류 : <a class="btn-view-sheet-18-1-05" href="#"  odr_idx="<?=$odr_idx?>" odr_det_idx="<?=$odr_det_idx?>" for_readonly="Y"><img alt="Non-Commercial Invoice" src="/kor/images/btn_none_commercial_invoice.gif"></a> <a class="btn-view-sheet-18-1-05" href="#"  odr_idx="<?=$odr_idx?>" odr_det_idx="<?=$odr_det_idx?>" for_readonly="P"><img alt="Packing List" src="/kor/images/btn_packing_list.gif"></a></td>
				</tr>
			</tbody></table></div>	
					<?
						   echo layerListData($loadPage ,$odr_idx,$odr_det_idx,$his_ty,$odr_history_idx);
						   break;	
				$cspan = 8;
				case "21_05":		//판매자(W/N) : 불량통보
				case "21_1_04":	//구매자(W/N) : 동의서
				case "21_1_09":
				case "21_3_10":
				case "21_7_02":
				case "21_4_10":
				case "21_4_11":
				?>
						<td class="company"><img src="/kor/images/nation_title_<?=$buy_com_nation?>.png" alt="<?=GF_Common_GetSingleList("NA",$buy_com_nation)?>"> <span class="name"><?=$buy_com_name?></span></td>
						<?if ($loadPage=="21_1_04"){?><td class="c-red2 w100 t-ct">동의서가 도착했습니다.</td><?}
						elseif ($loadPage =="21_1_09"){?><td class="c-red2 w100 t-ct">모든 처리가 완료되었습니다.</td><?}
						elseif ($loadPage =="21_4_10"){?><td class="c-red2 w100 t-ct">제품이 문제없이 도착하였습니다. </td><?}
						elseif ($loadPage =="21_4_11"){?><td class="c-red2 w100 t-ct">테스트 결과가 도착하였습니다. </td><?}
						elseif ($loadPage =="21_3_10"){
							if ($reason_ty =="6"){?>
							<td class="c-red2 w100 t-ct">부대비용, 위로금, 테스트 비용 (<span class="c-blue" lang="en">US$<?=$pay?></span>) 결제가 완료되었습니다.</td>
							<?}else{?>
							<td class="c-red2 w100 t-ct">위로금 (<span class="c-blue" lang="en">US$<?=$pay?></span>) 결제가 완료되었습니다. </td>
							<?}
						}elseif ($loadPage =="21_7_02"){?><td class="c-red2 w100 t-ct">상대방이 당신의 ‘연구소 의뢰’ 요청 동의를 거절하였습니다. </td><?}else{?>
						<!--td class="file t-rt">
							<span class="c-blue" lang="ko">파일 / 사진 : </span>
							<?if ($file1){?><a href="<?=get_noimg($file_path,$file1,"javascript:;")?>" <?if ($file1){?>target="_blank"<?}?>>File1</a><?}else{?>File1,<?}?> <?if ($file2){?><a href="<?=get_noimg($file_path,$file2,"javascript:;")?>" target="_blank">File2</a><?}else{?>File2<?}?>
							<span class="img-wrap"><?if ($file1){?><a href="<?=get_noimg($file_path,$file1,"/kor/images/file_pt.gif")?>" target="_blank"><img <?=get_noimg_photo("../".$file_path, $file1, "/kor/images/file_pt.gif")?> alt=""></a><?}else{?><img <?=get_noimg_photo("../".$file_path, $file1, "/kor/images/file_pt.gif")?> alt=""><?}?></span>
							<span class="img-wrap"><?if ($file2){?><a href="<?=get_noimg($file_path,$file2,"/kor/images/file_pt.gif")?>" target="_blank"><img <?=get_noimg_photo("../".$file_path, $file2, "/kor/images/file_pt.gif")?> alt=""></a><?}else{?><img <?=get_noimg_photo("../".$file_path, $file2, "/kor/images/file_pt.gif")?> alt=""><?}?></span>
						</td-->						
					</tr>
					<!--tr>
						<td><?if ($etc2){?><div class="re-select"><strong>선택</strong><?if ($etc2=="1"){?><em>교환</em><?}else{?><em>반품</em><?}?></div><?}?></td>
						<td class="file-memo">Memo: <strong><?=$memo?></strong></td-->
					<?}?>
					</tr>
					</tbody></table></div>
				<?		 echo layerListData($loadPage ,$odr_idx,$odr_det_idx,$his_ty,$odr_history_idx);
					   break;   
				case "21_14":?>
						<td rowspan="2" class="company"><img src="/kor/images/nation_title_<?=$buy_com_nation?>.png" alt="<?=GF_Common_GetSingleList("NA",$buy_com_nation)?>"> <span class="name"><?=$buy_com_name?></span></td>
						<td rowspan="2" class="c-red2 w100 t-ct">구매자가 종료를 요청하였습니다.</td>
						<td class="file t-rt">
							<span class="c-blue" lang="ko">파일 / 사진 : </span>
							<?if ($file1){?><a href="<?=get_noimg($file_path,$file1,"javascript:;")?>" <?if ($file1){?>target="_blank"<?}?>>File1</a><?}else{?>File1,<?}?> <?if ($file2){?><a href="<?=get_noimg($file_path,$file2,"javascript:;")?>" target="_blank">File2</a><?}else{?>File2<?}?>
							<span class="img-wrap"><?if ($file1){?><a href="<?=get_noimg($file_path,$file1,"/kor/images/file_pt.gif")?>" target="_blank"><img <?=get_noimg_photo("../".$file_path, $file1, "/kor/images/file_pt.gif")?> alt=""></a><?}else{?><img <?=get_noimg_photo("../".$file_path, $file1, "/kor/images/file_pt.gif")?> alt=""><?}?></span>
							<span class="img-wrap"><?if ($file2){?><a href="<?=get_noimg($file_path,$file2,"/kor/images/file_pt.gif")?>" target="_blank"><img <?=get_noimg_photo("../".$file_path, $file2, "/kor/images/file_pt.gif")?> alt=""></a><?}else{?><img <?=get_noimg_photo("../".$file_path, $file2, "/kor/images/file_pt.gif")?> alt=""><?}?></span>
						</td>
					</tr>
					<tr>
						<td class="file-memo">Memo: <strong><?=$memo?></strong></td>
					</tr>
					</tbody></table></div>
				<?		 echo layerListData($loadPage ,$odr_idx,$odr_det_idx,$his_ty,$odr_history_idx);
					break;
				case "21_16":
			    case "21_1_14": //구매(W/N) : 결제 완료
				case "21_6_03":
				case "21_5_12":
				case "21_5_13":
						if ($loadPage == "21_16"){	?>
							<td class="c-red2 w100 t-ct">모든 처리가 완료되었습니다.</td>
						<?}elseif ($loadPage == "21_5_12"){?>
							<td class="c-red2 w100 t-ct">제품이 문제없이 도착하였습니다. </td>
						<?}elseif ($loadPage == "21_5_13"){?>
							<td class="c-red2 w100 t-ct">테스트 결과가 도착하였습니다.  </td>
						<?}elseif ($loadPage =="21_1_14"){//--------------->결제완료(불량통보:구매자)
								if($reason_ty=='6'){//-->연구소의뢰?>
									<?if($reg_mem_idx == $buy_com_idx){?>
										<td class="c-red2 w100 t-ct">위로금, 테스트 비용 (<span class="c-blue" lang="en">US$<?=$pay?></span>) 결제가 완료되었습니다.</td>
									<?}else{?>
										<td class="c-red2 w100 t-ct">판매자의 재 작업 비용, 테스트비용 (<span class="c-blue" lang="en">US$<?=$pay?></span>) 결제가 완료되었습니다.</td>
									<?}?>
								<?}else{?>
									<td class="c-red2 w100 t-ct">총 금액, 부대비용, 재 작업 비용 (<span class="c-blue" lang="en">US$<?=$pay?></span>) 결제가 완료되었습니다.</td>
								<?}
						?>
						<?}elseif ($loadPage =="21_6_03"){?><td class="c-red2 w100 t-ct">판매자가 당신의 ‘종료’ 요청을 거절하였습니다. </td>
						<?}?>
					</tr>
					</tbody></table></div>

				<?		echo layerListData($loadPage ,$odr_idx,$odr_det_idx,$his_ty,$odr_history_idx);
					break;
				case "21_1_07":	//2016-10-19 연구소의뢰 위해 본사로 반품?>
						<td class="file"><span lang="ko"><?echo $return_method == "1" ? "반품포기" : "선적정보 : $etc1"?></span></td>
						<!--td class="file-memo">Memo: <strong><?=$memo?></strong></td-->
					</tr>
					</tbody></table></div>

				<?		echo layerListData($loadPage ,$odr_idx,$odr_det_idx,$his_ty,$odr_history_idx);
					break;
			 }
}


function layerListData($loadPage ,$odr_idx,$odr_det_idx ,$his_ty,$fty_history_idx=""){
			global $session_mem_idx,$file_path;
			$searchand =  "and b.odr_det_idx = $odr_det_idx";
			$result =QRY_RCD_DET_LIST(0,$searchand,0);
			$row = mysql_fetch_array($result);
			$colspan="9";
			
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
			$mem_idx= replace_out($row["mem_idx"]);
			$rel_idx= replace_out($row["rel_idx"]);
			$price= replace_out($row["price"]);			
			$odr_idx = replace_out($row["odr_idx"]);
			$reason_ty= replace_out($row["reason_ty"]);
			$ship_idx = replace_out($row["ship_idx"]);
			$com_idx = $rel_idx==0 ? $sell_mem_idx : $rel_idx;
			$company_nm = get_any("member","mem_nm_en", "mem_idx=$com_idx"); 						
			$i=1;
			if ($part_type =="2"){
					$dc = "NEW";
					$quantity="";
				}
			//구매자 정보
			$odr = get_odr($odr_idx);
			$buy_mem_idx = $odr[mem_idx];
			$buy_rel_idx = $odr[rel_idx];		
			$mem  =get_mem($buy_mem_idx);
			$buy_nation =  $mem[nation];
			$buy_company_nm = $mem[mem_nm_en];
			//히스토리 정보
			$fty_history = get_fty_history($fty_history_idx);
			$fty_reason_ty = $fty_history["reason_ty"];
	?>
	<!-- layer-data -->
	<div class="layer-data">
		<?if ($loadPage=="21_2_10"){?>
		<div class="layer-file">
		<table>
			<tbody>
				<tr>
					<td class="company"><img alt="United Kingdom" src="/kor/images/nation_title_<?=$buy_nation?>.png" alt="<?=$buy_company_nm?>"><?=$buy_company_nm?></span></td>
				</tr>
			</tbody>
		</table>
		</div>
		<?}?>
		<table class="stock-list-table" id="list_<?=$loadPage?>">
			<thead>
				<tr>
					<?if ($loadPage =="18R_19" || $loadPage =="04_01"|| $loadPage =="30_20"|| $loadPage=="21_2_09"){?><th scope="col" style="width:50px">Option</th><?}?>
					<th scope="col" style="width:23px">No.</th>
					<?if ($loadPage=="21_07" || $loadPage=="21_1_02"|| $loadPage=="21_1_07" || $loadPage=="21_1_14"|| $loadPage=="21_2_03" || $loadPage=="21_6_03"|| $loadPage=="21_5_12"|| $loadPage=="21_5_13"){?><th scope="col" style="width:80px">Nation</th><?}?>
					<th scope="col" class="t-lt">Part No.</th>
					<th scope="col" class="t-lt">Manufacture</th>
					<th scope="col">Package</th>
					<th scope="col">D/C</th>
					<th scope="col">RoHS</th>
					<th scope="col" class="t-rt">
						<?=($loadPage=="21_2_03")? "반품수량":"Q'ty";?>
					</th>
					<th scope="col" class="t-rt">Unit Price</th>
					<?if ($loadPage=="21_bla"){?>
						<th scope="col" lang="ko">발주수량</th>
						<th scope="col" lang="ko">공급수량</th>
						<th scope="col" lang="ko">납기</th>
					<?}else{?>
						<th scope="col" class="t-rt" lang="en">Amount</th>						
					<?}?>
					<?if ($loadPage=="21_07" || $loadPage=="21_1_02"|| $loadPage=="21_1_07"|| $loadPage=="21_1_14" || $loadPage=="21_2_03"|| $loadPage=="21_6_03"|| $loadPage=="21_5_12"|| $loadPage=="21_5_13"){?><th scope="col">Company</th><?}?>
				</tr>
			</thead>

			<tbody>
			<tr>
				<td colspan="<?=$colspan?>" class="title-box <?if ($part_type=="1"){?>first<?}?>">
					<h3 class="title"><img src="/kor/images/stock_title0<?=$part_type?>.gif" alt="<?=GF_Common_GetSingleList("PART",$part_type)?>"></h3>
				</td>
			</tr>
			<tr>
			<?if ($loadPage =="21_2_09"){?><td><label class="ipt-chk chk2"><input type="checkbox" name="odr_det_idx[]" value="<?=$odr_det_idx?>" class="checked" checked><span></span></label></td><?}?>
			<td><?=$i?></td>
			<?if ($loadPage =="21_07" || $loadPage=="21_1_02"|| $loadPage=="21_1_07"|| $loadPage=="21_1_14"|| $loadPage=="21_2_03"|| $loadPage=="21_6_03"|| $loadPage=="21_5_12"|| $loadPage=="21_5_13"){?><td><img src="/kor/images/nation_title2_<?=$nation?>.png" alt="<?=GF_Common_GetSingleList("NA",$nation)?>"></td><?}?>
			<td class="t-lt"><?=$part_no?></td>
			<td class="t-lt"><?=$manufacturer?></td>
			<td><?=$package?></td>
			<td><?=$dc?></td>
			<td><?=$rhtype?></td>
			<td class="t-rt"><?=$odr_quantity==0?"":number_format($odr_quantity)?></td>											
			<td class="t-rt">$<?=number_format($price,2)?></td>
			<td class="t-rt"><?=$odr_quantity==0?"":number_format($odr_quantity * $price)?></td>
			<?if ($loadPage =="21_07" || $loadPage=="21_1_02"|| $loadPage=="21_1_07"|| $loadPage=="21_1_14"|| $loadPage=="21_2_03"|| $loadPage=="21_6_03"|| $loadPage=="21_5_12"|| $loadPage=="21_5_13"){$sapn_add=2;?><td class="c-blue"><?=$company_nm?></td><?}?>
			</tr>
			<?if ($loadPage!= "21_2_10"){?>
			<tr class="bg-none">
					<td></td>
					<td colspan="8<?=+$sapn_add?>">
						<table class="detail-table">
							<tbody>
								<tr class="noinput">
									<th scope="row" style="width:70px">부품상태  : </th>
									<td><span lang="en"><?=GF_Common_GetSingleList("PARTCOND",$part_condition)?></span></td>
									<th scope="row" style="width:70px">포장상태 : </th>
									<td><span lang="en"><?=GF_Common_GetSingleList("PACKCOND1",$pack_condition1)?> <?=GF_Common_GetSingleList("PACKCOND2",$pack_condition2)?> </span></td>
								</tr>
								<tr class="noinput">
									<td colspan="4" lang="en"><strong class="c-red">Memo : </strong><?=$memo?> </td>
								</tr>
								<tr>
									<td colspan="4"  class="img-cntrl-list">
										<strong class="c-red">라벨/부품사진 :</strong>
										<?
										for ($i = 1;$i <= 3; $i++ ){
											$file = replace_out($row["file".$i]);						
						?>
										<div class="img-cntrl-wrap">
										<span class="img-wrap"><a href="<?=get_noimg($file_path,$file,"#")?>" <?if ($file){?>target="_blank"<?}?>><img <?=get_noimg_photo("../".$file_path, $file, "/kor/images/file_pt.gif")?> alt=""></a></span>											
										</div>
										<?}?>
									</td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>

				<?}?>
				<?if($loadPage=="21_2_03"){  //반품 선적(불량통보)
					//$ship = get_ship($ship_idx);
				?>
					<!--tr>
						<td colspan="11" class="t-ct">
							<hr class="dashline2">
							<img src="/kor/images/btn_shipping_info.gif" alt="선적정보">
						</td>
					</tr>
					<tr class="bg-none">
						<td>&nbsp;</td>
						<td colspan="10">
							<table class="detail-table mr-t0" align="center">
								<tbody>
									<tr>
										<td class="c-red2">운송회사 : <img src="/kor/images/icon_<?=strtolower(GF_Common_GetSingleList("DLVR",$ship[ship_info]))?>.gif" alt=""> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;운송장번호: <input type="text" class="i-txt2 c-blue" name="delivery_no" value="" style="width:96px"></td>						
									</tr>
									<tr>
										<td class="c-red2">반품 선적 서류 - <span lang="en">Download</span> : <a href="#" class="btn-view-sheet-18-1-05" odr_idx="<?=$odr_idx?>" odr_det_idx="<?=$odr_det_idx?>" for_readonly=""><img src="/kor/images/btn_none_commercial_invoice.gif" alt="Non-Commercial Invoice"></a> <a href="#" class="btn-pop-3018"><img src="/kor/images/btn_packing_list.gif" alt="Packing List"></a> <a href="#" class="btn-pop-18-1-08"  ship_idx="<?=$ship[ship_idx]?>" ship_type="<?=$ship[ship_type]?>"><img src="/kor/images/btn_return_statment.gif" alt="반품 사유서"></a></td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr-->
					<?}?>
			</tbody>
		</table>
	</div>
<?if ($loadPage=="21_05" || $loadPage=="21_07" || $loadPage=="21_1_02" || $loadPage=="21_1_04" || $loadPage=="21_1_14"){//------------- 메세지 주고 받고...?>
	<div class="layer-data">
		<table class="stock-list-table">
			<tr class="bg-none">
				<td><hr class="dashline2"></td>
			</tr>
			<?
			//불량통보 메세지 순서대로 가져오기...
			$result = QRY_FTY_MSG_LIST($odr_det_idx);
			?>
			<tbody>
				<?
				$i=0;
				while($row = mysql_fetch_array($result)){
					$i++;
					$fty_history_idx2 = $row["fty_history_idx"];
					$status = $row["status"];
					$reason_title = $row["reason_title"];
					$reason = $row["reason"];
					$reg_date = $row["reg_date"];
					if($i<2){
						$num = $i;
					}else{
						if($i%2 == 0){//짝수
							$num = intval($i/2);
						}else{//홀수
							$num = intval($i/2)+1;
						}
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
									<span class="box-num"><?=$num;?></span>
									<span class="c-red"><?if($status==13){?>[동의서]<?}?></span>
									<span style="cursor:pointer;" OnClick="show_msg(<?=$fty_history_idx2;?>);"><?=$reason_title?></span>
								</td>
								<td class="t-rt" lang="en" Style="width:100px; padding-right:5px;"><?=date("j F Y");?></td>
							</tr>
							<tr id="msg_cont_<?=$fty_history_idx2;?>" Style="display:none;">
								<td colspan="2" class="t-lt" lang="ko"><?=$reason;?></td>
							</tr>
						</table>
					</td>
				</tr>
				<?}?>
			</tbody>
		</table>
	</div>
<?}//------------------------- 메시지 주고 받고 끝.-----------?>
<?if ($loadPage=="21_2_09"){?>
	<hr class="dashline2">
	<p class="c-red2 t-ct mr-tb15">
		<img alt="공지" src="/kor/images/btn_notice.gif"><br><br>
		문제가 있는/문제가 없는 제품의 체크박스를 선택하고 진행을 원하는 버튼을 선택하십시오.
	</p>
<?}	if ($fty_history_idx){	$reason_ty =  get_any("fty_history", "reason_ty", "fty_history_idx=$fty_history_idx");}
?>
	<div class="btn-area t-rt" odr_idx="<?=$odr_idx?>" odr_det_idx="<?=$odr_det_idx?>" odr_det_idx="<?=$odr_det_idx?>">
	<?if ($loadPage =="21_05"|| $loadPage=="21_7_02"){?>
		<a href="#" class="btn-dialog-2106" odr_det_idx="<?=$odr_det_idx?>"><img src="/kor/images/btn_answer.gif" alt="회신서"></a>
	<?}elseif ($loadPage=="21_07" || $loadPage=="21_6_03"){?>
		<a href="#" class="btn-dialog-2108" odr_det_idx="<?=$odr_det_idx?>"><img src="/kor/images/btn_reply.gif" alt="답변서"></a>
	<?}elseif ($loadPage=="21_1_02" || $loadPage=="21_1_04"){
			/** 2016-10-24 주석처리 - 최근액션 동의 시가 아니라, 둘다 동의 했을 경우로 변경
			//최근 내가 한 action이 동의서라면  bpway = "Y" - JSJ
			if (get_any("fty_history","status", "fty_history_idx =(SELECT max(fty_history_idx) FROM `fty_history` where odr_idx =$odr_idx and odr_det_idx = $odr_det_idx and reg_mem_idx = $session_mem_idx)")=="13"){
					$bpway = "Y";
			}**/
			$bpway = (QRY_CNT("fty_history", "and status=13 and odr_idx=$odr_idx and odr_det_idx=$odr_det_idx")>1)? "Y":"N";	//2016-10-24
			$reason_ty =get_any("fty_history","reason_ty", "fty_history_idx =$fty_history_idx");
			if ($reason_ty== "4"){ //판매자 잘못
				$agree_sheet= "21-1-01";
			}elseif ($reason_ty =="6"){
				$agree_sheet= "21-4-01";  //R&D request
			}else{
				$agree_sheet= "21-3-01";  //구매자 잘못
			}
		?>
		<a href="#" class="btn-view-sheet-<?=$agree_sheet?>" odr_idx="<?=$odr_idx?>" odr_det_idx="<?=$odr_det_idx?>" bpway="<?=$bpway?>"><img src="/kor/images/btn_consent_form.gif" alt="동의서"></a>
	<?}elseif ($loadPage=="21_14"){?>
		<a href="#" class="btn-pop-21-6-02"><img src="/kor/images/btn_refuse.gif" alt="거절"></a>
		<a href="#" class="btn-pop-2115" odr_idx="<?=$odr_idx?>" odr_det_idx="<?=$odr_det_idx?>" odr_det_idx="<?=$odr_det_idx?>"><img src="/kor/images/btn_end.gif" alt="종료"></a>
	<?}elseif ($loadPage=="21_16"){?>
		<a href="#" class="comsucc" fty_history_idx="<?=$fty_history_idx?>"><img src="/kor/images/btn_complete.gif" alt="완료"></a>
	<?}elseif ($loadPage=="21_1_07"){ //What's New : 반품방법(불량통보)
		$return_method = get_any("fty_history", "return_method", "fty_history_idx=".$fty_history_idx);
		//$cls =$return_method=="1" ? "btn-pop-21-1-08" : "btn-dialog-21-2-03";
		$cls =$return_method=="1" ? "btn-pop-21-1-08" : "btn-dialog-21-5-06";	//2016-10-19 연구소의뢰 반품위해 '반품선적'창을 21-5-06의로 변경
	?>
		<a href="#" class="<?=$cls?>" return_method="<?=$return_method?>" odr_idx="<?=$odr_idx?>" odr_det_idx="<?=$odr_det_idx?>"><img alt="반품선적" src="/kor/images/btn_return_shipping.gif"></a>
	<?}elseif ($loadPage=="21_1_09"){?>
		<button class="btn-view-sheet-21-1-10" type="button"  odr_idx="<?=$odr_idx?>" odr_det_idx="<?=$odr_det_idx?>" ><img alt="송장확인" src="/kor/images/btn_invoice_confirm.gif"></button>
	<?}elseif($loadPage=="21_5_12" || $loadPage=="21_4_10"){	?>
		<button type="button" class="btn-close"><img src="/kor/images/btn_ok.gif" alt="확인"></button>
	<?}elseif($loadPage=="21_4_11" || $loadPage=="21_5_13"){?>
		<a class="btn-view-sheet-21-4-12" href="#" fty_history_idx="<?=$fty_history_idx?>"><img alt="Test Report" src="/kor/images/btn_test_report.gif"></a>
	<?}elseif ($loadPage=="21_3_10"){ //----------------> 판매 : 결재완료(불량통보)
		$mem_idx = get_any("odr","sell_mem_idx", "odr_idx =$odr_idx");
		$rel_idx = get_any("member", "rel_idx" ,"mem_idx = $mem_idx");
		$buy_idx = get_any("odr","mem_idx", "odr_idx =$odr_idx");
		$reg_mem_idx = get_any("fty_history", "reg_mem_idx" ,"fty_history_idx = $fty_history_idx");
		$pay_cnt = QRY_CNT("fty_history" , "and status = 27 and odr_idx=$odr_idx and odr_det_idx=$odr_det_idx");
		if ($reason_ty =="6") {	//테스트 의뢰 ?>
			<?if($reg_mem_idx==$buy_idx && $pay_cnt<2){?>
				<a href="#" class="btn-view-sheet-21-4-06" odr_idx ="<?=$odr_idx?>"  odr_det_idx="<?=$odr_det_idx?>"><img src="/kor/images/btn_payment.gif" alt="결제"></a>
			<?}else{?>
				<button type="button" class="btn-close"><img src="/kor/images/btn_ok.gif" alt="확인"></button>
			<?}?>
		<?}else{?>
			<button class="btn-pop-21-1-15" type="button"  odr_idx="<?=$odr_idx?>" odr_det_idx="<?=$odr_det_idx?>" mem_idx = "<?=$mem_idx?>" rel_idx = "<?=$rel_idx?>"><img alt="종료" src="/kor/images/btn_end.gif"></button>
		<?}?>
	<?}elseif ($loadPage=="21_1_14"){ //----------------> 구매 : 결제 완료(불량통보)
		$mem_idx = get_any("odr","mem_idx", "odr_idx =$odr_idx");
		$rel_idx = get_any("member", "rel_idx" ,"mem_idx = $mem_idx");
		$reg_mem_idx = get_any("fty_history", "reg_mem_idx" ,"fty_history_idx = $fty_history_idx");
		if ($fty_reason_ty =="6") { //테스트 의뢰
			//둘다 결재 했으면 "반품방법", 안했으면 "결제"를 표시 - 2016-10-24
				if (QRY_CNT("fty_history" , "and status = 27 and odr_idx=$odr_idx and odr_det_idx=$odr_det_idx") > 1){?>
					<a href="#" class="btn-pop-21-5-05" odr_idx ="<?=$odr_idx?>"  odr_det_idx="<?=$odr_det_idx?>"><img src="/kor/images/btn_return_way.gif" alt="반품방법"></a>
				<?}elseif($mem_idx==$reg_mem_idx){?>
					<button class="btn-close" type="button"><img alt="확인" src="/kor/images/btn_ok.gif"></button>
				<?}else{?>
					<a href="#" class="btn-view-sheet-21-4-06" odr_idx ="<?=$odr_idx?>"  odr_det_idx="<?=$odr_det_idx?>"><img src="/kor/images/btn_payment.gif" alt="결제"></a>
			    <?}?>
		<?}else{?>
		<a href="#" class="btn-pop-21-1-15" odr_idx="<?=$odr_idx?>" odr_det_idx="<?=$odr_det_idx?>" mem_idx = "<?=$mem_idx?>" rel_idx = "<?=$rel_idx?>"><img alt="종료" src="/kor/images/btn_end.gif"></a>
		<?}?>
	<?}elseif ($loadPage=="21_2_09"){
		if($reason_ty != "6"){ // 반품 선적 완료인데, 6이면 parts에 반품 선적 했다는 의미이므로. 버튼 없음.
			//메세지 보냈는지 여부를 먼저 판가름 해서 보냈다면 disable 처리. 안보냈으면 활성화 처리.
			$invoice_no = get_any("ship", "invoice_no", "ship_idx=".$ship_idx);
			$msg_yn = QRY_CNT("board", "and bd_mem_idx= ".$_SESSION["MEM_IDX"]." and bd_address='$invoice_no'") > 0 ? "Y":"N";
			
			if ($msg_yn=="Y"){?><img alt="PARTStrike" src="/kor/images/btn_parts_1.gif"><?}else{
			?>
		<button class="btn-pop-2001" type="button" his_type="<?=$his_ty?>" invoice_no="<?=$invoice_no?>" history_idx="<?=$fty_history_idx?>"><img alt="PARTStrike" src="/kor/images/btn_parts.gif"></button>
		<?}?>
		<button type="button" class="btn-dialog-21-2-10"   odr_idx="<?=$odr_idx?>" odr_det_idx="<?=$odr_det_idx?>"><img alt="수령" src="/kor/images/btn_receipt.gif"></button>
	<?	}
	  }?>
	</div>

<?}



function GET_RCD_DET_LIST_V2($searchand ,$loadPage , $for_readonly=""){   //sheet용?>
	<table>
	<thead>
		<tr>
			<th scope="col">No.</th>
			<th scope="col" class="t-lt">Part No.</th>
			<th scope="col" class="t-lt">Description</th>
			<th scope="col" class="t-rt">Quantity</th>
			<th scope="col" class="t-rt">Unit Price</th>
			<th scope="col">Lead Time</th>
			<th scope="col" class="t-rt">Amount</th>
		</tr>
	</thead>
	<tbody>
<?
	$cnt = QRY_CNT("odr_det a left outer join part b on  a.part_idx = b.part_idx ",$searchand);							
	$result =QRY_ODR_DET_LIST(0,$searchand,0);
	global $tot;
	$tot = 0;
	while($row = mysql_fetch_array($result)){
			$i++;				
			$part_idx= replace_out($row["a.part_idx"]);
			$part_type= replace_out($row["part_type"]);
			$odr_idx= replace_out($row["odr_idx"]);
			$part_no= replace_out($row["part_no"]);
			$nation= replace_out($row["nation"]);
			$manufacturer= replace_out($row["manufacturer"]);
			$package= replace_out($row["package"]);
			$dc= replace_out($row["dc"]);
			$rhtype= replace_out($row["rhtype"]);
			$quantity= replace_out($row["quantity"]);
			$odr_quantity= replace_out($row["odr_quantity"]);
			$price= replace_out($row["price"]);			
			$odr_det_idx = replace_out($row["odr_det_idx"]);	
			$part_condition = replace_out($row["part_condition"]);
			$pack_condition1 = replace_out($row["pack_condition1"]);
			$pack_condition2 = replace_out($row["pack_condition2"]);
			$memo = replace_out($row["memo"]);
			$period = replace_out($row["period"]);
			$sell_mem_idx = replace_out($row["mem_idx"]);			
			$tTy = $_SESSION["MEM_IDX"] == $sell_mem_idx ? "S" : "B";
			
			if ($part_type =="2"){
					$dc = "NEW";
					$quantity="";
				}

			if($part_condition) { $extra .=($extra==""?"<BR>":", "). GF_Common_GetSingleList("PARTCOND",$part_condition);}
			if($pack_condition1) { $extra .=($extra==""?"<BR>":", "). GF_Common_GetSingleList("PACKCOND1",$pack_condition1);}
			if($pack_condition2) { $extra .=($extra==""?"<BR>":", "). GF_Common_GetSingleList("PACKCOND2",$pack_condition2);}
			if($memo) { $extra .=($extra==""?"<BR>":", ").$memo;}
			?>
				<tr>
					<td><?=$i?></td>
					<td class="t-lt"><?=$part_no?></td>
					<td class="t-lt"><?=$manufacturer?>, <?=$package?>, <?=$dc?>, <?=$rhtype?><?=$extra?></td>
					<td class="t-rt"><?=$odr_quantity==0?"":number_format($odr_quantity)?></td>
					<td class="t-rt">$<?=number_format($price,2)?></td>
					<td><?=($period)?$period:(($part_type=="2"||$part_type=="5"||$part_type=="6")?"<span lang='ko' class='c-red'>확인</span>":"Stock")?></td>
					<td class="t-rt">
					<?if (!($loadPage == "21_4_06" && $tTy =="B")) {?>
						$<?=number_format($odr_quantity*$price,2)?>
					<?}?>
					
					</td>
				</tr>
			<?
				$tot = $tot + ($odr_quantity*$price);
			$ListNO--;		
			}
 $odr = get_odr($odr_idx);
?>
<?if ($loadPage=="21_1_01" || $loadPage=="21_1_10"){//동의서 일때
//계산법 다시 듣고 수정하기!!
$escrow = $tot >=3000 ? $tot *0.01 : "30";
$freight = $odr[faulty_delivery_fee]; //odr의 faulty_delivery_fee가 있으면 그값 없으면 넘기고.
$bankingchg = 30;
$reworkfee = $tot * 0.15;
$tot = $tot + $escrow + $freight + $bankingchg + $reworkfee;
?>
	<tr><td >&nbsp;</td><td colspan="2" class="t-lt">Seller is responsible for this return. So the seller agrees to pay the lists mentioned below.</td><td colspan="4">&nbsp;</td></tr>
	<tr><td><?=$i+1?></td><td colspan="2" class="t-lt"> Escrow Fee </td><td colspan="3">&nbsp; </td><td class="t-rt">$<?=number_format($escrow,2)?></td></tr>
	<tr><td><?=$i+2?></td><td colspan="2" class="t-lt"> Freight </td><td colspan="3">&nbsp; </td><td class="t-rt">$<?=number_format($freight,2)?></td></tr>
	<tr><td><?=$i+3?></td><td colspan="2" class="t-lt"> Banking Charge  </td><td colspan="3">&nbsp; </td><td class="t-rt">$<?=number_format($bankingchg,2)?></td></tr>
	<tr><td><?=$i+4?></td><td colspan="2" class="t-lt"> Rework Fee 15% </td><td colspan="3">&nbsp; </td><td class="t-rt">$<?=number_format($reworkfee,2)?></td></tr>
<?}elseif ($loadPage=="21_3_01" || $loadPage == "21_3_06"){ // 위로금 주는 동의서일때
	$tot = $tot * 0.15;
?>
	<tr><td >&nbsp;</td><td colspan="2" class="t-lt">Buyer is responsible for this return. So the seller agrees to pay the lists mentioned below.</td><td colspan="4">&nbsp;</td></tr>
	<tr><td><?=$i+1?></td><td colspan="2" class="t-lt"> Compensation Fee 15%</td><td colspan="3">&nbsp; </td><td class="t-rt">$<?=number_format($tot,2)?></td></tr>	
<?}elseif ($loadPage=="21_4_06"){ //--------------------- Invoice(연구소) --------------------------
	//2016-10-15 : Banking Charge 없음
	
	if ($tTy == "S"){ // seller ---------------------<<
	$freight = $odr[faulty_delivery_fee];
	$reworkfee = $tot * 0.2;
	$testfee = 1000;
	$tot = $tot + $freight + $reworkfee + $testfee;
	$i++;
?>
	<?if($freight>0){?>
	<tr><td><?=$i++;?></td><td></td><td class="t-lt"> Freight </td><td colspan="3">&nbsp; </td><td class="t-rt">$<?=number_format($freight,2)?></td></tr>
	<?}?>
	<tr><td><?=$i++;?></td><td></td><td class="t-lt"> Rework Fee 20% </td><td colspan="3">&nbsp; </td><td class="t-rt">$<?=number_format($reworkfee,2)?>  </td></tr>
	<tr><td><?=$i++;?></td><td></td><td class="t-lt"> Test Fee </td><td colspan="3">&nbsp; </td><td class="t-rt">$<?=number_format($testfee,2)?> </td></tr>	
<?	}else{	//buyer ----------------------------------<<
	$reworkfee = $tot * 0.2;
	$testfee = 1000;
	$tot =$reworkfee + $testfee;
	$i++;
?>
	<tr><td><?=$i++;?></td><td></td><td class="t-lt"> Compensation Fee 20%  </td><td colspan="3">&nbsp; </td><td class="t-rt">$<?=number_format($reworkfee,2)?>  </td></tr>
	<tr><td><?=$i++;?></td><td></td><td class="t-lt"> Test Fee </td><td colspan="3">&nbsp; </td><td class="t-rt">$<?=number_format($testfee,2)?> </td></tr>	
<?
	}
}elseif($loadPage =="21_4_01"){//Request R&D Center 판매자 동의서 ----------------------------------------------------------------------------------------------------------------------------------------
//$escrow = $tot >=3000 ? $tot *0.01 : "30"; //2016-10-11 삭제
$freight = $odr[faulty_delivery_fee];
$reworkfee = $tot * 0.2;	//연구소 보내니까 20%
$comp_fee =  $tot * 0.2;	//연구소 보내니까 20%

//$tot = $tot + $escrow + $freight + $bankingchg + $reworkfee;
$tot = $tot + $freight + $reworkfee + $comp_fee;
$i++;
?>
	<tr><td >&nbsp;</td><td colspan="2" class="t-lt">About the argument above, if the seller is responsible, Seller will pay the buyer.</td><td colspan="4">&nbsp;</td></tr>
	<!--tr><td><?=$i+1?></td><td colspan="2" class="t-lt"> Escrow Fee </td><td colspan="3">&nbsp; </td><td class="t-rt">$<?=number_format($escrow,2)?></td></tr-->
	<?if($freight>0){?>
	<tr><td><?=$i++;?></td><td></td><td class="t-lt"> Freight </td><td colspan="3">&nbsp; </td><td class="t-rt">$<?=number_format($freight,2)?></td></tr>
	<?}?>
	<!--tr><td><?=$i+3?></td><td colspan="2" class="t-lt"> Banking Charge  </td><td colspan="3">&nbsp; </td><td class="t-rt">$<?=number_format($bankingchg,2)?></td></tr-->
	<tr><td><?=$i++;?></td><td></td><td class="t-lt"> Rework Fee 20% </td><td colspan="3">&nbsp; </td><td class="t-rt">$<?=number_format($reworkfee,2)?></td></tr>
	<tr><td >&nbsp;</td><td colspan="2" class="t-lt">About the argument above, if the buyer is responsible, Buyer will pay the seller.</td><td colspan="4">&nbsp;</td></tr>
	<!--tr><td><?=$i+1?></td><td colspan="2"> Banking Charge  </td><td colspan="3">&nbsp; </td><td class="t-rt">$<?=number_format($bankingchg,2)?></td></tr-->
	<tr><td>1</td><td></td><td class="t-lt"> Compensation Fee 20% </td><td colspan="3">&nbsp; </td><td class="t-rt">$<?=number_format($comp_fee,2)?></td></tr>
	<tr><td >&nbsp;</td><td colspan="5" class="t-lt">
	Also, Test Fee US$1,000 will be charged only to the member who is responsible.
	Buyer must send the entire quantity to PARTStrike when it should be tested. Shipping fee will paid by PARTStrike for the moment after the result is being reported, PARTStrike will subtract the same amount with shipping fee from the responsible one's deposit. <br>
	<br>Members agrees to follow the result of the Test Report from PARTStrike for the above items.</td><td colspan="1">&nbsp;</td></tr>
<?}
?>
</tbody>
	</table>	

	<ul class="total-price">
		<li class="sub"><strong>Sub Total :</strong><span>
			$<?=number_format($tot,2)?>		
		<input type="hidden" name="tot" id="tot_<?=$odr_det_idx?>" value="<?=$tot?>"></span></li>		
		<li class="total"><strong>Total <?=$word?>:</strong><span>$<?=number_format($tot,2)?></span></li>
	</ul>

<? 	
  }



function fty_shipping_info($odr_det_idx){
		if ($odr_idx){
			$odr=get_odr($odr_idx);
			$delivery_addr_idx= $odr[delivery_addr_idx];
			$ship_info= $odr[ship_info];
			$ship_account_no= $odr[ship_account_no];
			$insur_yn= $odr[insur_yn];
			$memo= $odr[memo];
		}
		?>

		<tr >
				<th scope="row"><label class="ipt-rd rd c-red"><input type="radio" name="return_method" value="2" ><span></span> 선적정보 :</label></th>
				<td class="ship"><span class="c-grey2">운송회사</span>
					<div class="select type4" lang="en" style="width:70px">
						<label class="c-blue">선택</label>
						<?echo GF_Common_SetComboList("ship_info", "DLVR", "", 1, "True",  "", $ship_info , "");?>
					</div>
				</td>
				<th scope="row"><span lang="en" class="c-grey2">Account No.</span></th>
				<td  class="ship"><input type="text" class="i-txt2 c-blue" name ="ship_account_no" id="ship_account_no" value="<?=$ship_account_no?>" style="width:92px"></td>
			</tr>			
			<tr>
				<td colspan="4" class="pd-l20"><label class="ipt-chk chk2"><input type="checkbox" name="insur_yn" <?if ($insur_yn=="on"){echo "checked class='checked'";}?>><span></span> 운송보험</label></td>
			</tr>
			
			<tr>
				<td colspan="4" class="pd-l20"><label class="ipt-chk chk2  com-chck"><input type="checkbox"><span></span> 배송지 변경</label></td>			
			</tr>
			<tr>
				<td colspan="4" lang="en"><strong class="c-red">Memo</strong> <input type="text" class="i-txt2 c-blue" name="memo" value="" style="width:323px"></td>
			</tr>

			<tr class="bg-none">
				<td></td>
				<td colspan="13">			
					<table class="detail-table">
						<tbody>
							<tr>
								<th scope="row">선적정보 :</th>
								<td>
									<span class="c-grey2">운송회사</span>
									<div class="select type4" lang="en" style="width:70px">
										<label class="c-blue">선택</label>
											<?echo GF_Common_SetComboList("ship_info", "DLVR", "", 1, "True",  "", $ship_info , "");?>
										
									</div>
								</td>
								<th scope="row"><span lang="en">Account No.</span></th>
								<td><input type="text" class="i-txt2 c-blue t-rt" name ="ship_account_no" id="ship_account_no" value="<?=$ship_account_no?>" style="width:92px"></td>
							</tr>
							<tr>
								<td colspan="4" lang="en"><strong class="c-red">Memo</strong> <input type="text" class="i-txt2 c-blue" id ="memo" name="memo" value="<?=$memo?>" style="width:323px"></td>
							</tr>
							<tr>
								<td colspan="4"><label class="ipt-chk chk2"><input type="checkbox" name="insur_yn" <?if ($insur_yn=="on"){echo "checked class='checked'";}?>><span></span> 운송보험</label></td>
							</tr>
							<tr>
								<td colspan="4"><label class="ipt-chk chk2 com-chck"><input type="checkbox" name="delivery_chg" id="delivery_chg"  <?if ($delivery_addr_idx){echo "checked class='checked'";}?>><span></span> 배송지 변경</label></td>
							</tr>
						</tbody>
					</table>
					
					<div class="company-info-wrap" style="display:<?if (!$delivery_addr_idx){echo"none";}?>">
						<?echo GET_CHG_RCD_DELIVERY_ADDR($delivery_addr_idx);?>
					</div>
					
				</td>
			</tr>

	<?}
	

	function GET_CHG_RCD_DELIVERY_ADDR($delivery_addr_idx){
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
				$sigungu = replace_out($row["sigungu"]);
				$addr = replace_out($row["addr"]);
			}	
		}
		?>
	<input type="hidden" name ="delivery_addr_idx" id="delivery_addr_idx" value="<?=$delivery_addr_idx?>">
	<input type="hidden" name ="delivery_save_yn" id="delivery_save_yn" value="<?=$save_yn?>">
	<table class="company-info-tb" style="width:745px">
		<tbody>
			<tr>
				<th scope="row"><strong class="c-red">*</strong> 국가</th>
				<td colspan="2">
					<div class="select type5 bd2" lang="en" style="width: 215px;">
						<label class="c-blue"><?=($nation)?GF_Common_GetSingleList("NA",$nation):"국가"?></label>
						<?echo GF_Common_SetComboList("nation", "NA", "", 1, "True",  "", $nation  , "onchange='chgnation(this);'");?>
					</div>
				</td>
			</tr>
			<tr>
				<th scope="row"><strong class="c-red">*</strong> 회사명</th>
				<td colspan="2"><input class="i-txt5 c-blue" type="text" name="com_name" style="width:215px" value="<?=$com_name?>"></td>
			</tr>
			<tr>
				<th scope="row"><strong class="c-red">*</strong> 담당자</th>
				<td colspan="2"><input class="i-txt5 c-blue" type="text" name="manager" style="width:215px" value="<?=$manager?>"></td>
			</tr>
			<tr>
				<th scope="row"><strong class="c-red">*</strong> 직책</th>
				<td colspan="2"><input class="i-txt5 c-blue" type="text" name="pos_nm" style="width:215px" value="<?=$pos_nm?>"></td>
			</tr>
			<tr>
				<th scope="row"><strong class="c-red">*</strong> 부서</th>
				<td colspan="2"><input class="i-txt5 c-blue" type="text" name="depart_nm" style="width:215px" value="<?=$depart_nm?>"></td>
			</tr>
			<tr>
				<th scope="row"><strong class="c-red">*</strong> 회사구분</th>
				<td colspan="2">
					<div class="select type5 bd2" lang="en" style="width: 215px;">
						<label class="c-blue"><?=($com_type)?GF_Common_GetSingleList("MEM",$com_type):"회사구분"?></label>
						<?echo GF_Common_SetComboList("com_type", "MEM", "", 1, "True",  "", $com_type  , "");?>
					</div>
				</td>
			</tr>
			<tr>
				<th scope="row"><strong class="c-red">*</strong> <span lang="en">Tel</span></th>
				<td colspan="2"><input class="i-txt5 c-blue" name="tel" type="text" style="width:215px" value="<?=$tel?>"></td>
			</tr>
			<tr>
				<th scope="row"><strong class="c-red">*</strong> <span lang="en">Fax</span></th>
				<td colspan="2"><input class="i-txt5 c-blue" name="fax"  type="text" style="width:215px" value="<?=$fax?>"></td>
			</tr>
			<tr>
				<th scope="row"><strong class="c-red">*</strong> 휴대전화</th>
				<td colspan="2"><input class="i-txt5 c-blue" name="hp" type="text" style="width:215px" value="<?=$hp?>"></td>
			</tr>
			<tr>
				<th scope="row"><strong class="c-red">*</strong> <span lang="en">E-mail</span></th>
				<td colspan="2"><input class="i-txt5 c-blue" name="email" type="text" style="width:215px"  value="<?=$email?>"></td>
			</tr>
			<tr>
				<th scope="row"><strong class="c-red">*</strong> 홈페이지</th>
				<td colspan="2"><input class="i-txt5 c-blue" name="homepage" type="text" style="width:215px" value="<?=$homepage?>"></td>
			</tr>
			<tr>
				<th scope="row"><strong class="c-red">*</strong> 우편번호</th>
				<td colspan="2"><input class="i-txt5 c-blue" name="zipcode" type="text" style="width:215px"  value="<?=$zipcode?>"></td>
			</tr>
			<tr>
				<th scope="row"><strong class="c-red">*</strong> 도/시</th>
				<td colspan="2">
					<div class="select type5 bd2" lang="en" style="width: 215px;">
						<label><?=($dosi)?GF_Common_GetSingleList_LANG("NA",$dosi,""):"도/시"?></label>
						<?=GF_Common_SetComboList("dosi", "NA", $nation, 2, "True",  "", $dosi , "onchange='chgdosi(this);'");?>
					</div>
				</td>
			</tr>
			<tr>
				<th scope="row"><strong class="c-red">*</strong> 시/군/구</th>
				<td colspan="2">
					<div class="select type5 bd2" lang="en" style="width: 215px;">
						<label><?=($sigungu)?GF_Common_GetSingleList_LANG("NA",$sigungu,""):"시/군/구"?></label>
						<?=GF_Common_SetComboList("sigungu", "NA",  $dosi, 3, "True",  "", $sigungu , "onchange='chgsigungu(this);'");?>
					</div>
				</td>
			</tr>
			<tr>
				<th scope="row"><strong class="c-red">*</strong> 주소</th>
				<td><input class="i-txt5 c-blue w100" name="addr" value="<?=$addr?>" type="text"></td>
				<td style="width:120px"><button type="button" class="delivery_save"><img src="/kor/images/btn_save.gif" alt="저장"></button>	<button type="button"  class="delivery_del"><img src="/kor/images/btn_delete3.gif" alt="삭제"></button></td>
			</tr>
			<tr>
				<td colspan="3">
					<?echo GET_MY_RCD_DELIVERY_ADDR_LIST($delivery_addr_idx)?>
				</td>
			</tr>
		</tbody>
	</table>

	<?}
	
	function GET_MY_RCD_DELIVERY_ADDR_LIST ($idx){
		$result =QRY_DELIVERY_ADDR_LIST(0,"and save_yn='Y' and mem_idx = ".$_SESSION["MEM_IDX"],0);
		$rowcnt = mysql_num_rows($result);
		if ($rowcnt>0){
			?>
			<table class="company-rank">
			<thead>
				<tr>
					<th scope="col">No.</th>
					<th scope="col" lang="ko">회사명</th>
				</tr>
			</thead>
			<tbody>
				<?	
				 while($row = mysql_fetch_array($result)){
						$i++;				
						$delivery_addr_idx = replace_out($row["delivery_addr_idx"]);
						$com_name= replace_out($row["com_name"]);?>
				<tr >
					<td <?echo $idx == $delivery_addr_idx?"class='c-red'":""?> style="cursor:pointer;" onclick="delivery_load(<?=$delivery_addr_idx?>)"><?=$i?>.</td>
					<td <?echo $idx == $delivery_addr_idx?"class='c-red'":""?> style="cursor:pointer;" onclick="delivery_load(<?=$delivery_addr_idx?>)"><?=$com_name?></td>
				</tr>
				<?}?>		
			</tbody>
			</table>	
	<?	}
	}	
?>