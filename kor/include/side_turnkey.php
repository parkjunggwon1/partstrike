<section id="turnkeyList" class="box-type2">
	<div class="title-top">
		<h2>턴키목록</h2>
	</div>
	<div class="title-blck first">
		<h3>내용</h3>
		<?if($_SESSION["MEM_IDX"]){?>
		<a href="javascript:right_order();"><img src="/kor/images/btn_oderform.gif" alt="발주서"></a>
		<?}else{?>
		<a href="javascript:right_side();"><img src="/kor/images/btn_close02.gif" alt="닫기"></a>
		<?}?>
	</div>
	<table class="stock-list-table">
		<thead>
			<tr>
				<th scope="col" style="width:27px">No.</th>
				<th scope="col" class="t-lt">Part No.</th>
				<th scope="col" class="t-lt" style="width:100px">Manufacturer</th>
				<th scope="col" style="width:50px">Package</th>
				<th scope="col" style="width:25px">D/C</th>
				<th scope="col" style="width:25px">RoHS</th>
				<th scope="col" class="t-rt" style="width:47px; padding-right:5px">O'ty</th>
			</tr>
		</thead>
		<tbody>
		<?
		if ($turnkey_idx){
			$searchand = "";
			$searchand .= "and part_type = 7 and turnkey_idx =$turnkey_idx "; 
			$cnt2 = QRY_CNT("part",$searchand);				
			$result2 =QRY_PART_LIST(0,$searchand,$page, "part_idx");
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
					?>
			<tr>
				<td style="padding:5px 0px;"><?=$j?></td>
				<td class="t-lt"><?=$part_no?>.</td>
				<td class="t-lt"><?=$manufacturer?></td>
				<td><?=$package?></td>
				<td><?=$dc?></td>
				<td><?=$rhtype?></td>
				<td class="t-rt" style="padding-right:5px"><?echo number_format($quantity);?></td>
			</tr>
			<?
			}
			}else{
			?><tr>
					<td colspan="9">검색된 턴키 데이터가 없습니다.</td>
				</tr>
		  <?}
		}else{?>
		<tr>
				<td colspan="9">내용을 확인할 턴키를 먼저 선택해 주세요.</td>
			</tr>
		<?
		}?>
		</tbody>
	</table>
</section>
