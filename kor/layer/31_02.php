<?
@header("Content-Type: text/html; charset=utf-8");
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.part.php";
?>

<script src="/kor/js/jquery-1.11.3.min.js"></script>
<script src="/include/function.js"></script>
<script>ready();
$("#odr_quantity").keyup(function(e){
	maskoff();
	var $this = $(this).parent().next();
	var stock_qty = parseInt($("#quantity").val());
	if($(this).val()==""){
		$this.find("button").hide();
		$this.find("span").show();
	}else{
		$this.find("span").hide();
		$this.find("button").show();	
	}
	if(parseInt($(this).val()) > stock_qty){
		$(this).val("");
	}else{
		maskon();
	}
});
</script>

<div class="layer-hd">
	<h1>납기</h1>
	<a href="#" class="btn-close"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>
</div>
<div class="layer-content">
	<div class="layer-data mr-b15">
		<table class="stock-list-table">
			<thead>
				<tr>
					<th scope="col" class="t-no">No. </th>
					<th scope="col" class="t-nation">Nation</th>
					<th scope="col" class="t-partno" Style="width:230px;">Part No.</th>
					<th scope="col" class="t-Manufacturer">Manufacturer</th>
					<th scope="col" class="t-Package">Package</th>
					<th scope="col" class="t-dc">D/C</th>
					<th scope="col" class="t-rohs">RoHS</th>
					<th scope="col" class="t-oty">O'ty</th>
					<th scope="col" class="t-unitprice">Unit Price</th>
					<th scope="col" lang="ko" class="t-orderoty">발주수량</th>
					<th scope="col" lang="ko" style="width:50px">납기</th>
				</tr>
			</thead>
			<tbody>
			<?
			if ($part_idx){
				$i = 1;
				$result =QRY_PART_LIST(0,"and part_idx in ($part_idx)","");
				$row = mysql_fetch_array($result);		
				$part_type= replace_out($row["part_type"]);
				$part_idx= replace_out($row["part_idx"]);
				$part_no= replace_out($row["part_no"]);
				$nation= replace_out($row["nation"]);
				$manufacturer= replace_out($row["manufacturer"]);
				$package= replace_out($row["package"]);
				$dc= replace_out($row["dc"]);
				$rhtype= replace_out($row["rhtype"]);
				$quantity= replace_out($row["quantity"]);
				$price= replace_out($row["price"]);			
				$rel_idx = get_any("part","case when rel_idx = 0 then mem_idx else rel_idx end ","part_idx = $part_idx");
				if ($part_type =="2"){
					$dc = "NEW";
					$quantity="I";
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
				<tr>
					<td colspan="11" class="title-box first">
						<h3 class="title"><img src="/kor/images/stock_title0<?=$part_type?>.gif" alt="<?=GF_Common_GetSingleList("PART",$part_type)?>"></h3>
					</td>
				</tr>
				<tr>
					<td><?=$i?></td>
					<td><img src="/kor/images/nation_title2_<?=$nation?>.png" alt="<?=GF_Common_GetSingleList("NA",$nation)?>"></td>
					<td class="t-lt"><?=$part_no?></td>
					<td class="t-lt"><?=$manufacturer?></td>
					<td><?=$package?></td>
					<td><?=$dc?></td>
					<td><?=$rhtype?></td>
					<td class="t-rt">I<input type="hidden" name="quantity" id = "quantity"  value="<?=$quantity?>"></td>
					<td class="t-rt">$<?=$price_val?></td>
					<td>
						<input type="hidden" name="quantity" id="quantity" value="<?=$quantity;?>">
						<input type="hidden" name="part_idx" id = "part_idx"  value="<?=$part_idx?>">
						<input type="text" class="i-txt2 c-blue onlynum numfmt t-rt" id = "odr_quantity" name="odr_quantity" value=""  style="width:58px" maxlength="10">
					</td>
					<td class="pd-0">
					<span><img src="/kor/images/btn_ok_1.gif" alt="확인"></span>
					<button style="display:none;" type="button" class="btn-pop-3103" part_type="<?=$part_type?>"><img src="/kor/images/btn_ok.gif" alt="확인"></button></td>
				</tr>
				<?}?>
			</tbody>
		</table>
	</div>
</div>

