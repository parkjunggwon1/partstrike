<section class="box-type2">
	<div class="title-top">
		<h2>대리점 정보</h2>
	</div>
	<?
	$agency_file1 = get_want("agency","agency_file1"," and idx='$idx'");
	$agency_name = get_want("agency","agency_name"," and idx='$idx'");
	$agency_homepage = get_want("agency","agency_homepage"," and idx='$idx'");
	
	?>
	<div class="title-blck first">
		<?if($_SESSION["MEM_IDX"]){?>
		<!--<a href="javascript:right_order();"><img src="/kor/images/btn_oderform.gif" alt="발주서"></a>-->
		<a href="javascript:right_order();"><img src="/kor/images/btn_oderform.gif" alt="발주서"></a>
		<?}else{?>
		<a href="javascript:showajax('.col-right', 'side');"><img src="/kor/images/btn_close02.gif" alt="닫기"></a>
		<?}?>
	</div>
	<div class="agency-list">
	<?if($agency_file1){?><h3 style="padding: 10px 0px;"><img src="/upload/file/<?=$agency_file1?>" alt="" width="75" height="18"> <span lang="en"><a href="<?=$agency_homepage?>" target="_blank"><?=$agency_name?></a></span></h3><?}?>
		<?if($nat){?><h4><img src="/kor/images/nation_title2_<?=$nat?>.png" alt="United Kimgdom"></h4><?}?>
		<ul>
			<?
			$searchand = " and a.agency_idx='$idx' and a.nation='$nat' and a.mem_idx=b.mem_idx";
			$result =QRY_LIST("agency a, member b","all",$page,$searchand," a.rel_idx DESC ");


			while($row = mysql_fetch_array($result)){
				$idx = replace_out($row["mem_idx"]);
				$rel_idx = replace_out($row["rel_idx"]);
				$mem_nm = replace_out($row["mem_nm"]);
				$mem_nm_en = replace_out($row["mem_nm_en"]);
				$pos_nm = replace_out($row["pos_nm"]);
				$pos_nm_en = replace_out($row["pos_nm_en"]);
				$depart_nm = replace_out($row["depart_nm"]);
				$depart_nm_en = replace_out($row["depart_nm_en"]);
				$hp = replace_out($row["hp"]);
				$fax = replace_out($row["fax"]);
				$zipcode = replace_out($row["zipcode"]);
				$addr = replace_out($row["addr"]);
				$addr_en = replace_out($row["addr_en"]);
				$email = replace_out($row["email"]);
				$homepage = replace_out($row["homepage"]);
				$skypeid = replace_out($row["skypeid"]);
				$log_date = substr(replace_out($row["reg_date"]),0,10);
				$filelogo = get_want("member","filelogo"," and mem_idx='$rel_idx'");
				$rel_name = get_want("member","mem_nm_en"," and mem_idx='$rel_idx'");
			?>

			<li>
				<table class="table-type2">
					<tbody>
						<tr>
							<th scope="row"><img src="/upload/file/<?=$filelogo?>" alt="" width="75" height="18"></th>
							<td colspan="3" class="c-blue"><span lang="en"><?=$rel_name?></span></td>
						</tr>

						<?if ($nat == $_SESSION["NATION"]){?>
						<tr>
							<th scope="row">담당자 / 직책 :</th>
							<td colspan="3"><span lang="ko"><?=$mem_nm?>/<?=$pos_nm?></span></td>
						</tr>
						<tr>
							<th scope="row">부서 :</th>
							<td colspan="3"><span lang="ko"><?=$depart_nm?></span></td>
						</tr>
						<tr>
							<th scope="row"><span lang="en">Tel  :</span></th>
							<td><span lang="en"><?=$hp?></span></td>
							<th scope="row"><span lang="en">Fax  :</span></th>
							<td><span lang="en"><?=$fax?></span></td>
						</tr>
						<tr>
							<th scope="row">주소 :</th>
							<td colspan="3"><span lang="ko"><?=$zipcode?> <?=$addr?></span></td>
						</tr>
						<?}else{?>
						<tr>
							<th scope="row">담당자 / 직책 :</th>
							<td colspan="3"><span lang="en"><?=$mem_nm_en?>/<?=$pos_nm_en?></span></td>
						</tr>
						<tr>
							<th scope="row">부서 :</th>
							<td colspan="3"><span lang="en"><?=$depart_nm_en?></span></td>
						</tr>
						<tr>
							<th scope="row"><span lang="en">Tel  :</span></th>
							<td><span lang="en"><?=$hp?></span></td>
							<th scope="row"><span lang="en">Fax  :</span></th>
							<td><span lang="en"><?=$fax?></span></td>
						</tr>
						<tr>
							<th scope="row">주소 :</th>
							<td colspan="3"><span lang="en"><?=$zipcode?> <?=$addr_en?></span></td>
						</tr>

						<?}?>
						<tr>
							<th scope="row" lang="en">E-mail :</th>
							<td colspan="3"><span lang="en"><?=$email?></span></td>
						</tr>
						<tr>
							<th scope="row">홈페이지  :</th>
							<td colspan="3"><span lang="en"><?=$homepage?></span></td>
						</tr>
						<tr>
							<th scope="row"><span lang="en">Skype ID  :</span></th>
							<td colspan="3"><span lang="en"><?=$skypeid?></span></td>
						</tr>
					</tbody>
				</table>
			</li>
			<? 
			} 
			?>

		</ul>
	</div>
</section>
