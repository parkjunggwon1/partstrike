<section class="box-type2" id="blackList">
	<div class="title-top">
		<h2><span lang="en">Black List</span></h2>
	</div>
	<div class="title-blck first">
		<h3>회사</h3>
		<?if($_SESSION["MEM_IDX"]){?>
		<a href="javascript:right_order();"><img src="/kor/images/btn_oderform.gif" alt="발주서"></a>
		<?}else{?>
		<a href="javascript:showajax('.col-right', 'side');"><img src="/kor/images/btn_close02.gif" alt="닫기"></a>
		<?}?>
	</div>
	<table class="stock-list-table">
		<thead>
			<tr>
				<th scope="col" style="width:14px">No.</th>
				<th scope="col" style="width:75px">Nation</th>
				<th scope="col" class="t-lt">Company</th>
				<th scope="col" lang="ko" style="width:70px">날짜</th>
			</tr>
		</thead>
	</table>
		<?
		
		
		for($i=1;$i<5;$i++){
		if($i==4){
			$searchand=" and black>3";
			$tit = "퇴출";
		}else{
			$searchand=" and black=$i";
			$tit = $i."차 경고";
		}
		$bgcolor_now="";
		$c = " a.* ";
		$c .= " ,(select code_desc from code_group_detail where grp_code='NA' and dtl_code=a.nation) as nation_txt ";
		$c .= " ,(select code_desc from code_group_detail where grp_code='NA' and dtl_code=a.dosi) as dosi_txt ";
		$c .= " ,(select code_desc from code_group_detail where grp_code='MEM' and dtl_code=a.mem_type) as mem_type_txt ";
		$c .= " ,(select count(*) from member where rel_idx=a.mem_idx) as rel_cnt ";
		$result =QRY_C_LIST($c," member a ","all","1",$searchand," mem_idx DESC");

		$cnt = QRY_CNT("member",$searchand);
		?>
	
			<div class="collapse-panel black-list<?if (!$cnt){?>s<?}?>">

				
			<?if (!$cnt){?>
			<h4 class="panel-hd a"><span>▶ <?=$tit?></span></h4>
			<?}else{?>
			<h4 class="panel-hd a"><a href="#">▶ <?=$tit?></a></h4>
			<div class="agency-list panel-bd">
				<table class="stock-list-table">
					<?
					
					
				
					$ListNO=$cnt-(($page-1)*$recordcnt);

					while($row = mysql_fetch_array($result)){
						$idx = replace_out($row["mem_idx"]);
						$mem_id = replace_out($row["mem_id"]);
						$mem_nm_en = replace_out($row["mem_nm_en"]);
						$pos_nm_en = replace_out($row["pos_nm_en"]);
						$depart_nm_en = replace_out($row["depart_nm_en"]);
						$reg_date = substr(replace_out($row["reg_date"]),0,10);
						
						$log_date = str_replace("-","-",substr(replace_out($row["reg_date"]),0,10));
						$date=date_create($log_date);
						$log_date_2=date_format($date,"d,M,Y");

						$nation= replace_out($row["nation"]);
						$filelogo= replace_out($row["filelogo"]);
						$tel= replace_out($row["tel"]);
						$fax= replace_out($row["fax"]);
						$zipcode= replace_out($row["zipcode"]);
						$addr_en= replace_out($row["addr_en"]);
						$email= replace_out($row["email"]);
						$skypeid = replace_out($row["skypeid"]);
						$homepage = replace_out($row["homepage"]);

						if ($bgcolor_now== "background-color:#f7f7f7;" ||$bgcolor_now == "" ) { 
							$bgcolor_now="background-color:#ffffff;";
						}else{
							$bgcolor_now ="background-color:#f7f7f7;"; 
						}
					?>
					<tr style="<?=$bgcolor_now?>">
						<td style="width:14px"><?=$ListNO?></td>
						<td style="width:75px"><img src="/kor/images/nation_title2_<?=$nation?>.png" alt=""></td>
						<td class="t-lt">
							<a href="javascript:side_company_info2('<?=$idx?>','blacklist')"><!--<img src="/upload/file/<?=$filelogo?>" alt="" style="height:12px" /> --><span lang="en" class="c-blue fs15"><?=$mem_nm_en?></span></a>
						</td>
						<td style="width:70px"><?=$log_date_2?></td>
					</tr>
					<!--<tr>
						<th scope="row">담당자 / 직책 :</th>
						<td colspan="3"><span lang="en"><?=$mem_nm_en?>/<?=$pos_nm_en?></span></td>
					</tr>
					<tr>
						<th scope="row">부서 :</th>
						<td colspan="3"><span lang="en"><?=$depart_nm_en?></span></td>
					</tr>
					<tr>
						<th scope="row"><span lang="en">Tel  :</span></th>
						<td><span lang="en"><?=$tel?></span></td>
						<th scope="row"><span lang="en">Fax  :</span></th>
						<td><span lang="en"><?=$fax?></span></td>
					</tr>
					<tr>
						<th scope="row">주소 :</th>
						<td colspan="3"><span lang="en"><?=$addr_en?> <?=$zipcode?></span></td>
					</tr>
					<tr>
						<th scope="row">E-Mail :</th>
						<td colspan="3"><span lang="en"><?=$email?></span></td>
					</tr>
					<tr>
						<th scope="row">홈페이지  :</th>
						<td colspan="3"><span lang="en"><?=$homepage?></span></td>
					</tr>
					<tr>
						<th scope="row"><span lang="en">Skype ID  :</span></th>
						<td colspan="3"><span lang="en"><?=$skypeid?></span></td>
					</tr>-->
					<?
						$ListNO--;
					}
					?>
						</table>

			</div>
						<?}?>

			</div>
			
		<?}?>
</section>
