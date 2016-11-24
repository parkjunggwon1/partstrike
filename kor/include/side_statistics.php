	<?$rel_idx = $com_idx;?>
		<tbody>
			<tr class="bg-none">
				<td>
					<ul class="list-type4">
						<li><strong lang="ko">총 거래 금액 : </strong><span>$<?=odr_state("","S" , $rel_idx, "odr", "sum","6")?></span></li>
						<li><strong lang="ko">거래건수 : </strong><span><?=odr_state("","S" , $rel_idx, "odr", "count","6")?></span></li>
						<li><strong lang="ko">발주 취소  : </strong><span><?=odr_state("","S" , $rel_idx, "odr", "count","7,8")?></span></li>
						<li><strong lang="ko">거절  : </strong><span><?=odr_state("","S" , $rel_idx, "odr", "count","9")?></span></li>
						<li><strong lang="ko">수량 부족  : </strong><span><?=odr_state("","S" , $rel_idx, "odr", "count","10")?></span></li>
						<li class="c-red"><strong lang="ko">불량  : </strong><span><?=odr_state("","S" , $rel_idx, "fty", "count","12")?></span></li>
					</ul>
				</td>
				<td class="bg-dash">
					<ul class="list-type4">
						<li><strong lang="ko">총 거래 금액 : </strong><span>$<?=odr_state("M","S" , $rel_idx, "odr","sum", "6")?></span></li>
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
						<li><strong lang="ko">총 거래 금액 : </strong><span>$<?=odr_state("","B" , $rel_idx, "odr","sum", "6")?></span></li>
						<li><strong lang="ko">거래건수 : </strong><span><?=odr_state("","B" , $rel_idx, "odr","count", "6")?></span></li>
						<li><strong lang="ko">발주 취소  : </strong><span><?=odr_state("","B" , $rel_idx, "odr","count", "7,8")?></span></li>
						<li class="c-red"><strong lang="ko">부정신고  : </strong><span>0</span></li>
					</ul>
				</td>
				<td class="bg-dash">
					<ul class="list-type4">
						<li><strong lang="ko">총 거래 금액 : </strong><span>$<?=odr_state("M","B" , $rel_idx, "odr","sum", "6")?></span></li>
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
	if ($odr_type == "S") { $search_clause.=  "and (c.mem_idx = $com_idx or c.rel_idx = $com_idx) ";}
	else{$search_clause.=  "and (d.mem_idx = $com_idx or d.rel_idx = $com_idx) ";}
	
	$sql = "SELECT ".$calcul_type."( c.price * supply_quantity ) as price
			FROM ".$his_type."_history a
			LEFT OUTER JOIN odr_det b ON a.odr_det_idx = b.odr_det_idx
			LEFT OUTER JOIN part c ON b.part_idx = c.part_idx
			LEFT OUTER JOIN odr d ON a.odr_idx= d.odr_idx
			WHERE a.status in($status)  $search_clause
	";
//		echo $sql;
	$conn = dbconn();
	mysql_query( "SET NAMES utf8");		
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	$row = mysql_fetch_array($result);
	echo number_format(replace_out($row["price"]),$calcul_type =="sum"?"2":"0");
}
?>