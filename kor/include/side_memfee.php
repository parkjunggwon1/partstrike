<script type="text/javascript">
<!--
	function asdf(){
		showajax(".col-right", "side_order");
	}
//-->
</script>
<?
$invoice_no = get_want("mybank","invoice_no"," and mybank_idx='$idx'");
?>
<section id="turnkeyList" class="box-type2">
	<div class="title-top">
		<h2>회원가입비</h2>
	</div>
	<div class="title-blck first">
		<h3>기록</h3>
		<a href="javascript:asdf()"><img src="/kor/images/btn_oderform.gif" alt="발주서"></a>
	</div>
	<table class="stock-list-table bgno">
		<thead>
			<tr>
				<th scope="col" style="width:14px">No.</th>
				<th scope="col" lang="ko" style="width:75px">가입일</th>
				<th scope="col" class="t-lt" style="width:85px; padding-left:5px;">UserID</th>
				<th scope="col" lang="ko" class="t-lt">성명/직책</th>
				<th scope="col" lang="ko" style="width:50px">방법</th>
				<th scope="col" lang="ko" style="width:70px">Invoice No.</th>
				<th scope="col" lang="ko" class="t-rt" style="width:55px; padding-right:5px;">회원가입비</th>
			</tr>
		</thead>
		<tbody>
		<?
		$searchand .= " AND invoice_no='$invoice_no' and a.mem_idx=b.mem_idx"; 
		$result =QRY_LIST(" mybank a, member b ","all","1",$searchand," a.mem_idx ");

		
		$i=0;
		while($row = mysql_fetch_array($result)){
			$i++;				
			$reg_date= substr(replace_out($row["reg_date"]),0,10);
			$mem_id= cutbyte(replace_out($row["mem_id"]),15);
			$invoice_no= replace_out($row["invoice_no"]);
			$mem_nm_en= replace_out($row["mem_nm_en"]);
			$pos_nm_en= replace_out($row["pos_nm_en"]);
			$charge_method= replace_out($row["charge_method"]);
			$charge_amt= replace_out($row["charge_amt"]);
			$tot =$tot+$charge_amt;

			if ($charge_method=="1"){
				$charge_method="신용카드";
			}
			if ($charge_method=="2"){
				$charge_method="입금";
			}
			if ($charge_method=="mybank"){
				$charge_method=$charge_method;
			}
			?>
			
			
			<tr>
				<td style="padding:5px 0;"><?=$i?></td>
				<td><?=substr($reg_date,0,4)?><span lang="ko">년</span> <?=substr($reg_date,5,2)?><span lang="ko">월</span> <?=substr($reg_date,8,2)?><span lang="ko">일</span></td>
				<td class="t-lt" style="padding-left:5px;"><?=$mem_id?></td>
				<td class="t-lt"><?=$mem_nm_en?>/<?=$pos_nm_en?></td>
				<td><?=$charge_method?></td>
				<td><?=$invoice_no?></td>
				<td class="t-rt" style="padding-right:5px;">$<?=number_format($charge_amt,2)?></td>				
			</tr>
			<?
			$ListNO--;		
			}
	
		?>
		</tbody>
		<tfoot>
		<tr>
			<td colspan="6" class="td3"><span style="margin-right:-54px">Total Amount</span></td>
			<td class="t-rt td3" style="padding-right:5px;">$<?=number_format($tot,2)?></td>
		</tr>
		</tfoot>
	</table>
	<div class="mr-tb15">
		
	</div>
</section>
