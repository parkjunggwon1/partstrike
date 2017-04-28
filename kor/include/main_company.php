<section id="partsTotal" class="box-type1">
				<div class="box-top">
					<h2 lang="en">Total</h2>
				</div>
				<div class="clear">
					<table class="total-table">
						<tbody>
							<tr>
								<th scope="row">총 가입 회사 :</th>
								<td lang="en"><?=number_format(QRY_CNT("member" ,"and rel_idx = 0 and mem_type in (1,2)"))?></td>
							</tr>
							<tr>
								<th scope="row">총 가입 회원 :</th>
								<td lang="en"><?=number_format(QRY_CNT("member" ,"and mem_type in (1,2)"))?></td>
							</tr>
							<tr>
								<th scope="row">총 거래 금액 :</th>
								<td lang="en">$<?=odr_price("")?>


<?function odr_price($mon){
	/** JSJ
	아래 소스는 '이번달'이 아니라, 최근 1개월 이다.-KSR
	if ($mon){$mon_clause = "AND a.reg_date >= date_add( '".date("Y-m-d")."', INTERVAL -1 MONTH ) ";}

	아래 소스는 '수령'이며 det단위 가져오는 것은 오류-KSR
	$sql = "SELECT sum( c.price * supply_quantity ) as price
			FROM odr_history a
			LEFT OUTER JOIN odr_det b ON a.odr_det_idx = b.odr_det_idx
			LEFT OUTER JOIN part c ON b.part_idx = c.part_idx
			WHERE a.status =6  $mon_clause
	";
	**/
	/**
	2017-04-18 KSR
	status 6=>수령, 15=>종료
	**/
	$strDate   = date("Y-m-d", mktime(0, 0, 0, intval(date('m')), 1, intval(date('Y'))  ));
	if ($mon){$mon_clause = "AND a.reg_date between date('".$strDate."') AND date('".date("Y-m-d")."')+1";}

	$sql = "SELECT sum( c.price * supply_quantity ) as price
			FROM odr_history a
			LEFT OUTER JOIN odr_det b ON a.odr_idx = b.odr_idx
			LEFT OUTER JOIN part c ON b.part_idx = c.part_idx
			WHERE a.status =15  $mon_clause
	";
	//	echo $sql;
	$conn = dbconn();
	mysql_query( "SET NAMES utf8");		
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	$row = mysql_fetch_array($result);
	echo number_format(replace_out($row["price"]),2);
}
?>
</td>
							</tr>
							<tr>
								<th scope="row">이번 달 거래 금액 :</th>
								<td lang="en">$<?=odr_price("M")?></td>
							</tr>
						</tbody>
					</table>
					<div class="company-bn">
						<ul>
							<?
							$bn_mode="NN001";
							$top_cnt = "1";
							include ($_SERVER["DOCUMENT_ROOT"]."/kor/include/inc_banner.php"); 
							?>
						</ul>
					</div>
				</div>
			</section>			
			<section id="partsTop1" class="box-type1">
				<div class="box-top">
					<h2>발주서 <span lang="en">Top 10</span></h2>
				</div>
				<div class="clear">
				<div class="box-type4">
					<table class="table-type1">
						<thead>
							<tr>
								<th scope="col" colspan="2" class="th1">판매</th>
							</tr>
							<tr>
								<th scope="col" lang="en" class="th2">Total</th>
								<th scope="col" class="th2">이번 달</th>
							</tr>
						</thead>
						<tbody>								
							<tr>
								<td>
									<ul class="list-type2">
									<?	rank_odr("sell_", "");?>
									</ul>
								</td>
								<td class="bg-dash">
									<ul class="list-type2">
									<?	rank_odr("sell_", "M");?>
									</ul>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="box-type4">
					<table class="table-type1">
						<thead>
							<tr>
								<th scope="col" colspan="2" class="th1">구매</th>
							</tr>
							<tr>
								<th scope="col" lang="en" class="th2">Total</th>
								<th scope="col" class="th2">이번 달</th>
							</tr>
						</thead>
						<tbody>								
							<tr>
								<td>
									<ul class="list-type2">
										<?	rank_odr("", "");?>
									</ul>
								</td>
								<td class="bg-dash">
									<ul class="list-type2">
										<?	rank_odr("", "M");?>
									</ul>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				</div>
			</section>

			<?function rank_odr($ty, $mon){
										if ($mon){$mon_clause = "where reg_date >= date_add( '".date("Y-m-d")."', INTERVAL -1 MONTH ) ";}
										$sql = "SELECT mb.mem_idx, mem_nm_en
												FROM (
												SELECT ".$ty."mem_idx, count( odr_idx ) AS cnt
												FROM (
												SELECT CASE WHEN ".$ty."rel_idx =0
												THEN ".$ty."mem_idx
												ELSE ".$ty."rel_idx
												END AS ".$ty."mem_idx, odr_idx
												FROM odr
												$mon_clause
												) AS bb
												GROUP BY ".$ty."mem_idx) AS tb
												LEFT OUTER JOIN member mb ON tb.".$ty."mem_idx = mb.mem_idx
												ORDER BY tb.cnt DESC ";
											//	echo $sql;
										$conn = dbconn();
										mysql_query( "SET NAMES utf8");		
										$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
										$i = 1;
										while($row = mysql_fetch_array($result)){
											$mem_idx= replace_out($row["mem_idx"]);
											$mem_nm= replace_out($row["mem_nm_en"]);
										?>
											<li style="background-color: <?=$i%2==0?"#f7f7f7":"#ffffff"?>;"><span class="num"><?=$i?>.</span><a href="javascript:main_company_det('<?=$mem_idx?>','M');"><?=$mem_nm?></a></li>
										<?
										$i++;
										}
									}
			?>