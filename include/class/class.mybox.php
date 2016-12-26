<?
function GET_MYBOX_PART($titleyn, $part_type, $page, $style,$recordcnt){   //$titleyn : 처음 랜더링 할때에는 tbody부분이 필요하고 5개씩 slidedown 추가하는 경우에는 tbody 타이틀바가 필요 없다.
	$searchand .= " AND a.part_idx = b.part_idx And a.mem_idx='".$_SESSION["MEM_IDX"]."'"; 
	$cnt = QRY_CNT(" mybox a, part b ",$searchand);							
	$totalpage = QRY_TOTALPAGE($cnt,$recordcnt);
	$result =QRY_LIST(" mybox a, part b ","all","1",$searchand," a.reg_date DESC");
	$i = 0;
	$ListNO=$cnt-(($page-1)*$recordcnt);
	$bgcolor="#ffff99";

	if ($cnt > 0){
		
		while($row = mysql_fetch_array($result)){
			$i++;				
			$part_idx= replace_out($row["part_idx"]);
			$part_type= replace_out($row["part_type"]);
			$part_no= cutbyte(replace_out($row["part_no"]),30);
			$sell_mem_idx= replace_out($row["mem_idx"]);
			$rel_idx= replace_out($row["rel_idx"]);
			$sell_com_idx = $rel_idx==0?$sell_mem_idx:$rel_idx;
			$nation= replace_out($row["nation"]);
			$manufacturer= cutbyte(replace_out($row["manufacturer"]),20);
			$package= cutbyte(replace_out($row["package"]),10);
			$dc= cutbyte(replace_out($row["dc"]),4);
			$rhtype= cutbyte(replace_out($row["rhtype"]),4);
			$quantity= cutbyte(replace_out($row["quantity"]),10);
			$price= cutbyte(replace_out($row["price"]),10);	
			$already_idx = get_want("mybox","idx"," and mem_idx = '".$_SESSION["MEM_IDX"]."' and part_idx = '$part_idx'");
			if($already_idx){$already="1";}else{$already="";}
			if ($part_type =="2"){
				$dc = "NEW";
				$quantity="";
			}
			if ($bgcolor=="#ffffff") { 
				$bgcolor="#ffff99";
			}else{
				$bgcolor="#ffffff";
			}

			if( ($price == (int)$price) )
			{					
				$price_val = round_down($price,2);
				$price_val = number_format($price,2);
			}
			else {			
				$price_val = $price;
			}
			?>
			<tbody id="tbd_<?=$part_type?>" >
			<?if($i>1){?><tr><td colspan='15' style='padding-top:20px; background-color:#FFFFFF;'></td></tr><?}?>
			<tr  style="background-color:<?=$bgcolor?>;">
				<td   <? if($style=="main"){?>colspan="11"<? }else{ ?>colspan="10"<? } ?> class="title-box first">
					<h3 class="title"><img src="/kor/images/stock_title0<?=$part_type?><? if($style!="main"){?>_s<?}?>.gif" alt="<?=GF_Common_GetSingleList("PART",$part_type)?>"></h3>
					<?if ($cnt > 5){?>
					<?}?>
				</td>
			</tr>
			<tr  style="background-color:<?=$bgcolor?>;">
				<td>1</td>
				<td><img src="/kor/images/nation_title2_<?=$nation?>.png" alt="<?=GF_Common_GetSingleList("NA",$nation)?>"></td>
				<td class="t-lt"><?=get_cut($part_no,15,".")?></td>
				<td class="t-lt"><?=get_cut($manufacturer,10,".")?></td>
				<td align="center"><?=$package?></td>
				<td align="center"><?=$dc?></td>
				<td align="center"><?=$rhtype?></td>
				<td class="t-rt"><?=$quantity==0?"":number_format($quantity)?></td>
				<td class="t-rt">$<?=$price_val?></td>
				
				<?if ($part_type=="2" || $part_type=="5" || $part_type=="6"){?>
						
						<?if ($style=="main"){?>
						<td class="pd-0 t-rt">
						<a class="btn-dialog-3102" href="javascript:;" sell_com_idx="<?=$sell_com_idx?>" sell_mem_idx="<?=$sell_mem_idx?>" id="<?=$part_idx?>"><img alt="확인" src="/kor/images/btn_ok.gif"></a></td>
						<td class="pd-0 t-rt">
						<a href="#layerPop3" class="btn-mybox" sell_com_idx="<?=$sell_com_idx?>" sell_mem_idx="<?=$sell_mem_idx?>" id="<?=$part_idx?>" work="del"><img src="/kor/images/btn_delete2.gif" alt="삭제"></a>
						</td>
						<?}else{?>
						<td class="delivery">
						<font color="#ff0000" lang="ko">확인</font>
						</td>
						<?}?>
				<?}else{?>
					<!--<td>stock</td>-->
				<?if ($style=="main"){?>
					<td class="pd-0 t-rt"><a href="#layerPop3" class="btn-order" sell_com_idx="<?=$sell_com_idx?>" sell_mem_idx="<?=$sell_mem_idx?>" id="<?=$part_idx?>"><img src="/kor/images/btn_order.gif" alt="발주"></a></td>
					<td class="pd-0 t-rt"><a href="#layerPop3" class="btn-mybox" sell_com_idx="<?=$sell_com_idx?>" sell_mem_idx="<?=$sell_mem_idx?>" id="<?=$part_idx?>" work="del"><img src="/kor/images/btn_delete2.gif" alt="삭제"></a></td>
				<?}?>
				<?}?>
				</td>
			</tr>
			</tbody>
			<?
			$ListNO--;		
			}
	
	}
}



function GET_MYBOX_TURNKEY(){
	$recordcnt="5";
	$searchand .= " AND a.part_type ='7' AND a.part_idx = b.part_idx And a.mem_idx='".$_SESSION["MEM_IDX"]."'"; 
	$cnt = QRY_CNT(" mybox a, part b ",$searchand);							
	$result =QRY_LIST(" mybox a, part b ",$recordcnt,1,$searchand," a.reg_date DESC");

	$i = 0;
	$ListNO=$cnt-(($page-1)*$recordcnt);
	if ($cnt > 0){
		?>
		<div class="date-box" lang="en"><span class="c2" lang="ko">턴키판매</span></div>
				<div class="stock-list-wrap">
					<table class="stock-list-table bg-type4">
						<thead>
							<tr>
								<th scope="col" style="width:28px">No.</th>
								<th scope="col" style="width:80px">Nation</th>
								<th scope="col" class="t-lt">Title</th>
								<th scope="col" style="width:80px">Price</th>
								<th scope="col" style="width:50px">&nbsp;</th>
							</tr>
						</thead>
		<?
		while($row = mysql_fetch_array($result)){
			$i++;		
			$turnkey_idx= replace_out($row["part_idx"]);
			$mem_idx= replace_out($row["mem_idx"]);
			$rel_idx= replace_out($row["rel_idx"]);
			$title= replace_out($row["part_no"]);
			$nation= replace_out($row["nation"]);
			$price= replace_out($row["price"]);

			?>
		<tbody>

		<tr>
			<td><?=$ListNO?></td>
			<td><img src="/kor/images/nation_title2_<?=$nation?>.png" alt=""/></td>
			<td class="t-lt"><a href="javascript:turnkey_det(<?=$turnkey_idx?>);"><?=get_cut($title,80)?></a></td>
			<td><?=number_format($price,2)?></td>
			<td  class="pd-0 t-rt"><a href="#"><img src="/kor/images/btn_order.gif" alt="발주"></a></td>
		</tr>
		</tbody>					
	<?
		$ListNO--;		
		}
		?>
		</table>
		</div>
	<?
	}?>
	
<?}

?>