<div class="title-blck">
	<h3><img src="/kor/images/tit_mybox_white.gif" alt="My Box"></h3>
</div>
<div id="odr_mybox">
	<table class="stock-list-table">
		<thead>
			<tr>
				<th scope="col" style="width:14px">No.</th>
				<th scope="col" style="width:77px">Nation</th>
				<th scope="col" class="t-lt" style="width:100px">Part No.</th>
				<th scope="col" class="t-lt" style="width:70px">Manufacturer</th>
				<th scope="col" style="width:60px">Package</th>
				<th scope="col" style="width:24px">D/C</th>
				<th scope="col" style="width:25px">RoHS</th>
				<th scope="col" class="t-rt" style="width:42px">O'ty</th>
				<th scope="col" class="t-rt" style="width:42px">Unit Price</th>
				<th scope="col" class="delivery" lang="ko" style="width:29px">납기</th>
			</tr>
		</thead>
		<?
		$searchand1 = " AND a.part_idx = b.part_idx And a.mem_idx='".$_SESSION["MEM_IDX"]."'"; 
		if($style!="main"){
			$recordcnt = "all";
		}else{
			$recordcnt = "all";
		}
		$result =QRY_LIST(" mybox a, part b ",$recordcnt,"1",$searchand1," a.reg_date DESC");
		
			
			$i = 0;
			$criteria_idx = "";
			$bgcolor_now = "";

			while($row = mysql_fetch_array($result)){
				$i++;				
				$part_idx= replace_out($row["part_idx"]);
				$part_type= replace_out($row["part_type"]);
				$part_no= get_cut(replace_out($row["part_no"]),15,".");
				$sell_mem_idx= replace_out($row["mem_idx"]);
				$rel_idx= replace_out($row["rel_idx"]);
				$sell_com_idx = $rel_idx==0?$sell_mem_idx:$rel_idx;
				$nation= replace_out($row["nation"]);
				$manufacturer= get_cut(replace_out($row["manufacturer"]),10,".");
				$package= cutbyte(replace_out($row["package"]),10);
				$dc= cutbyte(replace_out($row["dc"]),4);
				$rhtype= cutbyte(replace_out($row["rhtype"]),4);
				$quantity= cutbyte(replace_out($row["quantity"]),10);
				$price= cutbyte(replace_out($row["price"]),10);	
				$already_idx = get_want("mybox","idx"," and mem_idx = '".$_SESSION["MEM_IDX"]."' and part_idx = '$part_idx'");
				if($already_idx){$already="1";}else{$already="";}
			
					if ($bgcolor_now== "background-color:#ffff99;" ||$bgcolor_now == "" ) { 
						$bgcolor_now="background-color:#ffffff;";
					}else{
						$bgcolor_now ="background-color:#ffff99;"; 
					}
				?>
				<?if ($part_type=="2" || $part_type=="5" || $part_type=="6"){?>
				<tbody class="btn-dialog-3102" href="javascript:;" sell_com_idx="<?=$sell_com_idx?>" sell_mem_idx="<?=$sell_mem_idx?>" id="<?=$part_idx?>" style="cursor:pointer;">
				<?}else{?>
				<tbody class="btn-order" href="javascript:;" sell_com_idx="<?=$sell_com_idx?>" sell_mem_idx="<?=$sell_mem_idx?>" id="<?=$part_idx?>" style="cursor:pointer;">
				<?}?>
				<?if($i>1){?><tr><td colspan='15' style='padding-top:20px; background-color:#FFFFFF;'></td></tr><?}?>
				<tr > 
					<td style="<?=$bgcolor_now?>" <? if($style=="main"){?>colspan="11"<? }else{ ?>colspan="10"<? } ?> class="title-box <?if ($part_type=="1"){?>first<?}?>" >
						<h3 class="title"><img src="/kor/images/stock_title0<?=$part_type?><? if($style!="main"){?>_s<?}?>.gif" alt="<?=GF_Common_GetSingleList("PART",$part_type)?>"></h3>
						
					</td>
				</tr>
				<tr style="<?=$bgcolor_now?>"> 
					<td>1</td>
					<td><img src="/kor/images/nation_title2_<?=$nation?>.png" alt="<?=GF_Common_GetSingleList("NA",$nation)?>"></td>
					<td class="t-lt"><?=$part_no?></td><!--<?=$sell_mem_idx?>:<?=$rel_idx?>:-->
					<td class="t-lt"><?=$manufacturer?></td>
					<td align="center"><?=$package?></td>
					<td align="center"><?=$dc?></td>
					<td align="center"><?=$rhtype?></td>
					<td class="t-rt"><?=$quantity==0?"":number_format($quantity)?></td>
					<td class="t-rt">$<?=number_format($price,2)?></td>
					
					<?if ($part_type=="2" || $part_type=="5" || $part_type=="6"){?>
							
							<?if ($style=="main"){?>
							<td>
							<a class="btn-dialog-3102" href="javascript:;" sell_com_idx="<?=$sell_com_idx?>" sell_mem_idx="<?=$sell_mem_idx?>" id="<?=$part_idx?>"><img alt="확인" src="/kor/images/btn_ok.gif"></a>
							</td>
							<?}else{?>
							<td class="delivery">
							<font color="#ff0000" lang="ko">확인</font>
							</td>
							<?}?>
					<?}else{?>
						<td>stock</td>
					<?if ($style=="main"){?>
						<td><a href="#layerPop3" class="btn-order" sell_com_idx="<?=$sell_com_idx?>" sell_mem_idx="<?=$sell_mem_idx?>" id="<?=$part_idx?>"><img src="/kor/images/btn_order.gif" alt="발주"></td>
					<?}?>
					<?}?>
					</td>
				</tr>
				</tbody>
				<?
				$criteria_idx = $criteria_now_idx;
				$bgcolor = $bgcolor_now;
				$ListNO--;		
				}
		
		?>
	</table>
</div>
