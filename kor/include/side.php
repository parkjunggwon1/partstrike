<section id="noticePreview" class="box-type2">
	<div class="title-top">
		<h2>공지사항</h2>
	</div>
	<ul class="list-type1">
		<?
		$result =QRY_LIST("board","10","1"," and bd_gubun='AA001' and bd_lev='0'"," bd_idx DESC");
		$cnt=mysql_num_rows($result);
		$i=$cnt;
		$j=1;
		while($row = mysql_fetch_array($result)){			
			$idx = replace_out($row["bd_idx"]);
			$mode = replace_out($row["bd_gubun"]);
			$title = replace_out($row["bd_title"]);
		?>
		<li style="background-color: <?=$j%2==0?"#f7f7f7":"#ffffff"?>;"><span class="num"><?=$i?>.</span><a href="javascript:boardview('<?=$mode?>','<?=$idx?>','<?=$main?>')" lang="ko"><?=get_cut($title,"40","..")?></a></li>
		<?
		$j++;
		$i=$i-1;	
		}?>
	</ul>
</section>
<section id="partsTop2" class="box-type3">
	<div class="box-top">
		<h2>인기부품 <span lang="en">Top 10</span></h2>
	</div>
	<table class="table-type1">
		<thead>
			<tr>
				<th scope="col" lang="en" class="th2">Total</th>
				<th scope="col" class="th2">이번 달</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><ul class="list-type2">
						<?rank_part("T");				
							?>
									
					</ul></td>
				<td><ul class="list-type2">
						<?rank_part("M");?>
					</ul></td>
			</tr>
		</tbody>
	</table>
</section>


<?function rank_part($mon){
	/*if ($mon){$mon_clause = "AND  a.reg_date >= date_add( '".date("Y-m-d")."', INTERVAL -1 MONTH ) ";}
	$sql = "SELECT part_no, sum( bb.price * bb.supply_quantity ) AS price
			FROM (

			SELECT c.part_no, c.price, supply_quantity
			FROM odr_history a
			LEFT OUTER JOIN odr_det b ON a.odr_det_idx = b.odr_det_idx
			LEFT OUTER JOIN part c ON b.part_idx = c.part_idx
			WHERE a.status =6 $mon_clause
			) AS bb
			GROUP BY part_no
			ORDER BY price DESC ";

		//	echo $sql;
	*/
	$sql = "select * from populpart where period = '$mon' order by sort";
	$conn = dbconn();
	mysql_query( "SET NAMES utf8");		
	$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
	$i = 1;
	while($row = mysql_fetch_array($result)){
		$part_no = replace_out($row["partno"]);
		$price = replace_out($row["price"]);

		if ( $part_no !=""){
		?>
			<li style="background-color: <?=$i%2==0?"#f7f7f7":"#ffffff"?>;"><span class="num"><?=$i?>.</span><?=$part_no?><span class="price f-rt">$<?=number_format($price)?></span></li>

		<?
		$i++;
		}
	}
}
?>
