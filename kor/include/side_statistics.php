	<?$rel_idx = $com_idx;?>
	<?


	?>
		<tbody>
			<tr class="bg-none">
				<td>
					<ul class="list-type4">
						<li><strong lang="ko">총 거래 금액 : </strong>
							<span>
							<?
							$statis_sql = " select ";
							$statis_sql .= " cancel_odr,no_odr,qty_odr,sum(part.price * odr_det.supply_quantity) as price,count(*) as succ ";
							$statis_sql .= " from ";
							$statis_sql .= " ( ";
							$statis_sql .= "  select 	 ";
							$statis_sql .= " sum((select count(*) from odr_history where odr_history.odr_history_idx = a.odr_history_idx and status in (7,8))) as cancel_odr, ";
							$statis_sql .= " sum((select count(*) from odr_history where odr_history.odr_history_idx = a.odr_history_idx and status in (9))) as no_odr, ";
							$statis_sql .= " sum((select count(*) from odr_history where odr_history.odr_history_idx = a.odr_history_idx and status in (10))) as qty_odr, ";
							$statis_sql .= " a.odr_idx ";
							$statis_sql .= " FROM odr_history a "; 
							$statis_sql .= " WHERE ";
							$statis_sql .= " (a.sell_mem_idx = ".$rel_idx." and a.reg_mem_idx = ".$rel_idx.") ";
							$statis_sql .= " ) as history ";
							$statis_sql .= " left join odr_det on odr_det.odr_idx = history.odr_idx ";
							$statis_sql .= " left join part on part.part_idx = odr_det.part_idx ";
								
							$conn1 = dbconn();
							mysql_query( "SET NAMES utf8");		
							$result2=mysql_query($statis_sql,$conn1) or die ("SQL ERROR : ".mysql_error());
							$row2 = mysql_fetch_array($result2);
							echo "$".$row2['price'];
							?>								
							</span>
						</li>
						<li><strong lang="ko">거래건수 : </strong><span><?=$row2['succ']?></span></li>
						<li><strong lang="ko">발주 취소  : </strong><span><?=$row2['cancel_odr']?></span></li>
						<li><strong lang="ko">거절  : </strong><span><?=$row2['no_odr']?></span></li>
						<li><strong lang="ko">수량 부족  : </strong><span><?=$row2['qty_odr']?></span></li>
						<li class="c-red"><strong lang="ko">불량  : </strong><span><?=odr_state("","S" , $rel_idx, "fty", "count","12")?></span></li>
					</ul>
				</td>
				<td class="bg-dash">
					<ul class="list-type4">
						<li><strong lang="ko">총 거래 금액 : </strong>
							<span>
							<?
								$price_val = odr_state("M","S" , $rel_idx, "odr","sum", "6");
								if( ($price_val == (int)$price_val) )
								{									
									$price_val = round_down($price_val,2);
									$price_val = number_format($price_val,2);
								}
								else {
									$price_val = round_down($price_val,4);									
									$price_val = number_format($price_val,4);
								}

								echo "$".$price_val;
							?>								
							</span>
						</li>
						<!--<li><strong lang="ko">총 거래 금액 : </strong><span>$<?=odr_state("M","S" , $rel_idx, "odr","sum", "6")?></span></li>-->
						<li><strong lang="ko">거래건수 : </strong><span><?=odr_state("M","S" , $rel_idx, "odr","count", "6")?></span></li>
						<li><strong lang="ko">발주 취소  : </strong><span><?=odr_state("M","S" , $rel_idx, "odr","count", "7,8")?></span></li>
						<li><strong lang="ko">거절  : </strong><span><?=odr_state("M","S" , $rel_idx, "odr","count", "9")?></span></li>
						<li><strong lang="ko">수량 부족  : </strong><span><?=odr_state("M","S" , $rel_idx, "odr","count", "10")?></span></li>
						<li class="c-red"><strong lang="ko">불량  : </strong><span><?=odr_state("M","S" , $rel_idx, "odr","count", "12")?></span></li>
					</ul>
				</td>
			</tr>
		</tbody>
		<thead>
			<tr>
				<th colspan="2" scope="col" class="th2" lang="ko">구매</th>
			</tr>
			<tr>
				<th scope="col" class="th3">Total</th>
				<th scope="col" class="th3 line-lt" lang="ko">이번달</th>
			</tr>
		</thead>
		<tbody>
			<tr class="bg-none">
				<td>
					<ul class="list-type4">
						<li><strong lang="ko">총 거래 금액 : </strong>
							<span>
							<?
								$price_val = odr_state("","B" , $rel_idx, "odr","sum", "6");
								if( ($price_val == (int)$price_val) )
								{									
									$price_val = round_down($price_val,2);
									$price_val = number_format($price_val,2);
								}
								else {
									$price_val = round_down($price_val,4);									
									$price_val = number_format($price_val,4);
								}

								echo "$".$price_val;
							?>								
							</span>
						</li>
						<!--<li><strong lang="ko">총 거래 금액 : </strong><span>$<?=odr_state("","B" , $rel_idx, "odr","sum", "6")?></span></li>-->
						<li><strong lang="ko">거래건수 : </strong><span><?=odr_state("","B" , $rel_idx, "odr","count", "6")?></span></li>
						<li><strong lang="ko">발주 취소  : </strong><span><?=odr_state("","B" , $rel_idx, "odr","count", "7,8")?></span></li>
						<li class="c-red"><strong lang="ko">부정신고  : </strong><span>0</span></li>
					</ul>
				</td>
				<td class="bg-dash">
					<ul class="list-type4">
						<li><strong lang="ko">총 거래 금액 : </strong>
							<span>
							<?
								$price_val = odr_state("M","B" , $rel_idx, "odr","sum", "6");
								if( ($price_val == (int)$price_val) )
								{									
									$price_val = round_down($price_val,2);
									$price_val = number_format($price_val,2);
								}
								else {
									$price_val = round_down($price_val,4);									
									$price_val = number_format($price_val,4);
								}

								echo "$".$price_val;
							?>								
							</span>
						</li>
						<!--<li><strong lang="ko">총 거래 금액 : </strong><span>$<?=odr_state("M","B" , $rel_idx, "odr","sum", "6")?></span></li>-->
						<li><strong lang="ko">거래건수 : </strong><span><?=odr_state("M","B" , $rel_idx, "odr","count", "6")?></span></li>
						<li><strong lang="ko">발주 취소  : </strong><span><?=odr_state("","B" , $rel_idx, "odr","count", "7,8")?></span></li>
						<li class="c-red"><strong lang="ko">부정신고  : </strong><span>0</span></li>
					</ul>
				</td>
			</tr>
		</tbody>

<?
function odr_state($mon , $odr_type , $com_idx, $his_type, $calcul_type , $status){  //odr_type : B or S (buy or sell) , com_idx , $his_type : odr or fty , $status :발주 취소 : (7,8)  거절 : 9 , 수량 부족 : 10, 불량통보 : 12
	if ($mon){$search_clause = "AND a.reg_date >= date_add( '".date("Y-m-d")."', INTERVAL -1 MONTH ) ";}
	if ($odr_type == "S") { $search_clause.=  "and (a.sell_mem_idx=$com_idx and a.reg_mem_idx <> $com_idx) ";}
	else{$search_clause.=  "and (a.buy_mem_idx=$com_idx and a.reg_mem_idx = $com_idx ) ";}
	//$search_clause.=  "and (a.reg_mem_idx = $com_idx ) ";
	if ($calcul_type=="sum")
	{
		$sql_col = "( d.price * supply_quantity ) ";
	}
	else
	{
		$sql_col = "( * ) ";
	}
	$sql = "SELECT ".$calcul_type."".$sql_col." as price
			FROM ".$his_type."_history a
			LEFT OUTER JOIN odr b ON a.odr_idx= b.odr_idx
		    LEFT OUTER JOIN odr_det c ON b.odr_idx = c.odr_idx 
			LEFT OUTER JOIN part d ON c.part_idx = d.part_idx
			WHERE a.status in($status)  $search_clause
	";
	//	echo $sql;
	$conn = dbconn();
	mysql_query( "SET NAMES utf8");		
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	$row = mysql_fetch_array($result);
	if ($calcul_type=="sum")
	{
		return replace_out($row["price"]);
	}
	else
	{
		echo number_format(replace_out($row["price"]),$calcul_type =="sum"?"2":"0");
	}
	
}
?>