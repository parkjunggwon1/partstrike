<section class="box-type2">
	<div class="title-top">
		<h2>회사정보</h2>
	</div>
	<?global $session_rel_idx, $session_mem_idx;?>
	<?
	if($rel_idx){
		$com_idx = $rel_idx;
	}else{
		$com_idx = $session_rel_idx == 0 ? $session_mem_idx : $session_rel_idx;
	}
	if ($com_idx){
		$result = QRY_MEMBER_VIEW("idx",$com_idx);
		$row = mysql_fetch_array($result);
		$mem_pwd = replace_out($row["mem_pwd"]);
		$mem_id = replace_out($row["mem_id"]);
		$mem_idx = replace_out($row["mem_idx"]);
		$rel_idx = replace_out($row["rel_idx"]);
		$mem_type = replace_out($row["mem_type"]);
		$nation = replace_out($row["nation"]);	
		$mem_nm = replace_out($row["mem_nm"]);	
		$mem_nm_en = replace_out($row["mem_nm_en"]);	
		$pos_nm = replace_out($row["pos_nm"]);
		$pos_nm_en = replace_out($row["pos_nm_en"]);
		$depart_nm = replace_out($row["depart_nm"]);
		$depart_nm_en = replace_out($row["depart_nm_en"]);
		$rel_nm = replace_out($row["rel_nm"]);
		$rel_nm_en = replace_out($row["rel_nm_en"]);
		$birthday = replace_out($row["birthday"]);
		$tel = replace_out($row["tel"]);
		$fax = replace_out($row["fax"]);
		$hp = replace_out($row["hp"]);
		$zipcode = replace_out($row["zipcode"]);
		$dosi = replace_out($row["dosi"]);
		$dosi_en = replace_out($row["dosi_en"]);
		$sigungu = replace_out($row["sigungu"]);
		$sigungu_en = replace_out($row["sigungu_en"]);
		$addr = replace_out($row["addr"]);
		$addr_en = replace_out($row["addr_en"]);
		$email = replace_out($row["email"]);
		$homepage = replace_out($row["homepage"]);
		$homepage_rel = replace_out($row["homepage_rel"]);
		$filelogo = replace_out($row["filelogo"]);
		
		$skypeId = replace_out($row["skypeId"]);
		if ($mem_birth)
		{ 
			$year = substr($mem_birth,0,4);
			$mon = substr($mem_birth,5,2);
			$day = substr($mem_birth,8,2);
		}
		$typ = "edit";
	}else{           
		$typ = "write";
	}
	global $file_path;
	?>
	<div class="title-blck first">		
		<?if($_SESSION["MEM_IDX"]){?>
			<?if($mode=="blacklist"){?>
				<a href="javascript: blacklist();"><img src="/kor/images/btn_close02.gif" alt="닫기"></a>
			<?}else{?>
				<a href="javascript:right_order();"><img src="/kor/images/btn_close02.gif" alt="발주서"></a>
			<?}?>			
		<?}else{?>
			<a href="javascript:right_side();"><img src="/kor/images/btn_close02.gif" alt="닫기"></a>
		<?}?>
	</div>
	<table class="table-type2">
		<tbody>
			<tr>
				<th scope="row"><a href="javascript:main_company_det('<?=$com_idx?>');"><img src="<?=$file_path.$filelogo?>" width="75px" height="18px" ></a></th>
				<td colspan="5"><a href="javascript:main_company_det('<?=$com_idx?>');"><?=$mem_nm?></a></td>
			</tr>
			<tr>
				<th scope="row">회사 구분 :</th>
				<td colspan="5"><?=GF_Common_GetSingleList("MEM",$mem_type)?></td>
			</tr>
			<tr>
				<th scope="row">대표자 :</th>
				<td colspan="5"><span lang="en"><?=$pos_nm?></span></td>
			</tr>
			<tr>
				<th scope="row"><span lang="en">Tel  :</span></th>
				<td><span lang="en"><?=$tel?></span></td>
				<th scope="row"><span lang="en">Fax  :</span></th>
				<td><span lang="en"><?=$fax?></span></td>
				<th scope="row">휴대전화  :</th>
				<td><span lang="en"><?=$hp?></span></td>
			</tr>
			<tr>
				<th scope="row">주소 :</th>
				<td colspan="5"><span lang="en"><?=$addr?></span></td>
			</tr>
			<tr>
				<th scope="row" lang="en">E-mail :</th>
				<td colspan="5"><span lang="en"><?=$email?></span></td>
			</tr>
			<tr>
				<th scope="row">홈페이지  :</th>
				<td colspan="5"><span lang="en"><?=$homepage?></span></td>
			</tr>
			<tr>
				<th scope="row"><span lang="en">Skype ID  :</span></th>
				<td colspan="5"><span lang="en"><?=$skypeId?></span></td>
			</tr>
		</tbody>
	</table>
	<table class="table-type3">
		<tbody>
			<tr>
				<td style="width:50%">
					<ul class="list-type4 mt-at">
						<li><strong>보증금 :</strong><span lang="en">$<?=GetDeposit($mem_idx, $rel_idx, "8")?></span></li>
						<li><strong>계약금 :</strong><span lang="en">$<?=GetDeposit($mem_idx, $rel_idx,"2,6")?></span></li>
						<li><strong lang="en">My Bank :</strong><span lang="en">$<?=SumMyBank($mem_idx, $rel_idx)?></span></li>
						<li><strong>재고품목 :</strong><span lang="en"><?=stock_cnt($mem_idx, $rel_idx)?></span></li>
					</ul>
				</td>
				<td class="bg-dash">
					<img src="/kor/images/nation_title_<?=$nation?>.png" alt="<?=GF_Common_GetSingleList("NA",$nation)?>"><br><br>가입일 : <?=get_any("member", "DATE_FORMAT(reg_date, '<span lang=en>%Y</span>년 <span lang=en>%m</span>월  <span lang=en>%d</span>일')","mem_idx=$com_idx")?>
				</td>
			</tr>
		</tbody>
	</table>
	
	<table class="stock-list-table">
		<thead>
			<tr>
				<th colspan="2" scope="col" lang="ko">발주서</th>
			</tr>
			<tr>
				<th colspan="2" scope="col" class="th2" lang="ko">판매</th>
			</tr>
			<tr>
				<th scope="col" class="th3">Total</th>
				<th scope="col" class="th3 line-lt" lang="ko">이번달</th>
			</tr>
		</thead>
		<?$rel_idx = $com_idx?>
		<?php include ($_SERVER["DOCUMENT_ROOT"]."/kor/include/side_statistics.php"); ?>
	</table>
</section>







