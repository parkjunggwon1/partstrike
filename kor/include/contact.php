<section class="box-type1" id="contactTop">
	<div class="box-top">
		<h2>본사</h2>
	</div>
	<?$result_parts = QRY_MEMBER_VIEW("idx",get_any("member", "min(mem_idx)", "mem_type = 0")); //파츠 회사 정보
	$row_parts = mysql_fetch_array($result_parts);
	?>

	<div class="panel2 contact-hd">
		<h3><img src="/kor/images/parts_logo02.png" alt="PARTStlike" ><span lang="en">www.PARTStrike.com</span></h3>		
		<?if ($_SESSION["MEM_IDX"]!=""){?><span>㈜<?=$row_parts["mem_nm"]?></span>
		<p style="padding-top:15px;">(우편번호: <?=$row_parts["zipcode"]?> ) <?=$row_parts["addr"]?>
		<?}else{?><span><?=$row_parts["mem_nm_en"]?></span>
		<p style="padding-top:15px;">
		<?=$row_parts["addr_en"]?>
		<?}?></p>
	</div>
	<table class="contact-list-table">
		<thead>
			<tr>
				<th scope="col" class="th2" style="width: 160px;">Region</th>
				<th scope="col" class="th2" style="width: 160px;">Tel</th>
				<th scope="col" class="th2" style="width: 160px;">Fax</th>
				<th scope="col" class="th2 t-lt" style="padding-left: 50px;">E-mail</th>
			</tr>
			</thead>
		<tbody>
			<?
			$c = " a.* ";
			$result =QRY_C_LIST($c,"headoffice a","all","1",$searchand," idx desc");
			
			while($row = mysql_fetch_array($result)){
				$idx = replace_out($row["idx"]);
				$nation = str_replace("\r\n", "<br/>" , $row["nation"]);
				$tel1 =str_replace("\r\n", "<br/>" , $row["tel1"]);
				$fax1 =str_replace("\r\n", "<br/>" , $row["fax1"]);
				$email1 = str_replace("\r\n", "<br/>" , $row["email1"]);

				if ($bgcolor == "background-color:#f7f7f7;" || $bgcolor=="") { 
					$bgcolor="background-color:#ffffff;";
				}else{
					$bgcolor ="background-color:#f7f7f7;";
				}
			?>
			<tr style="<?=$bgcolor?>">
				<td style="width: 160px;"><?=$nation?></td>
				<td style="width: 160px;"><?=$tel1?></td>
				<td style="width: 160px;"><?=$fax1?></td>
				<td class="t-lt" style="padding-left: 50px;"><?=$email1?></td>
			</tr>
			<? 
			} 
			?>
		</tbody>					
	</table>
</section>

<section class="box-type1" id="contactBottom">
	<div class="box-top">
		<h2><span lang="en">PARTStrike</span>연구소</h2>
	</div>
	<div class="panel2">
		<?

		$result =QRY_LIST("research","all","1",$searchand," idx desc");
		while($row = mysql_fetch_array($result)){
			$idx = replace_out($row["idx"]);
			$delivery = replace_out($row["delivery"]);
			$account_no = replace_out($row["account_no"]);
			$email = replace_out($row["email"]);
		?>
		<ul class="list-type3" lang="en" style="padding-top:15px;">
			<li><span lang="ko">운송회사 </span><img src="/kor/images/delivery_bn<?=$delivery?>.gif" alt="" style="width:75px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>Account No. : </span> <span class="c-blue"><?=$account_no?></span></li>
			<li lang="en" style="padding-top:15px;"><span>E-mail : </span><span class="c-blue"><?=$email?></span></li>
		</ul>
		<? 
		} 
		?>
	</div>
</section>