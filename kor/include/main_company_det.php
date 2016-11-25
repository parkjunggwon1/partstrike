<?if($rel_idx){
		$com_idx = $rel_idx;
		$fr = $mem_type;
	}else{
		$com_idx = $session_rel_idx == 0 ? $session_mem_idx : $session_rel_idx;
	}
	if ($com_idx){
		$result = QRY_MEMBER_VIEW("idx",$com_idx);
		$row = mysql_fetch_array($result);
		$idx = replace_out($row["mem_idx"]);
		$mem_type = replace_out($row["mem_type"]);	
		$mem_id = replace_out($row["mem_id"]);	
		$mem_pwd = replace_out($row["mem_pwd"]);	
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
		$email = replace_out($row["email"]);
		$fax = replace_out($row["fax"]);	
		$hp = replace_out($row["hp"]);	
		$zipcode = replace_out($row["zipcode"]);	
		$dosi = replace_out($row["dosi"]);	
		$dosi_en = replace_out($row["dosi_en"]);	
		$sigungu = replace_out($row["sigungu"]);
		$sigungu_en = replace_out($row["sigungu_en"]);
		$addr = replace_out($row["addr"]);
		$addr_en = replace_out($row["addr_en"]);		
		$homepage = replace_out($row["homepage"]);
		$homepage_rel = replace_out($row["homepage_rel"]);
		$skypeId = replace_out($row["skypeId"]);
		$rel_idx = replace_out($row["rel_idx"]);
		$rel_id = replace_out($row["rel_id"]);
		$filelogo = replace_out($row["filelogo"]);
		$filesign = replace_out($row["filesign"]);
		$filereg_no = replace_out($row["filereg_no"]);
		$filecerti1 = replace_out($row["filecerti1"]);
		$filecerti2 = replace_out($row["filecerti2"]);
		$certi1open_yn = replace_out($row["certi1open_yn"]);
		$certi2open_yn = replace_out($row["certi2open_yn"]);
		$filestore1 = replace_out($row["filestore1"]);
		$filestore2 = replace_out($row["filestore2"]);
		$filestore3 = replace_out($row["filestore3"]);
		$filestore4 = replace_out($row["filestore4"]);
		$bank_name = replace_out($row["bank_name"]);
		$bank_account = replace_out($row["bank_account"]);
		$bank_user_name = replace_out($row["bank_user_name"]);
		$login_count = replace_out($row["login_count"]);
		$reg_date = replace_out($row["reg_date"]);
		
		
		if ($mem_birth)
		{ 
			$year = substr($mem_birth,0,4);
			$mon = substr($mem_birth,5,2);
			$day = substr($mem_birth,8,2);
		}
		$typ = "edit";
		global $file_path;
	}
	?><div class="col-left">
			<section class="box-type1" style="height:225px">
				<div class="box-top">
					<h2>회사정보</h2>
				</div>
				<table class="table-type2">
					<tbody>
						<tr>
							<th scope="row"><img src="<?=$file_path.$filelogo?>" alt="" style="width:75px; height:18px;"></th>
							<td colspan="5"> <?=$nation==$_SESSION["NATION"]?$mem_nm:$mem_nm_en?></td>
						</tr>
						<tr>
							<th scope="row">회사 구분 :</th>
							<td colspan="5"><span lang="en"><?=($_SESSION["NATION"]==$nation)?GF_Common_GetSingleList("MEM",$mem_type):GF_Common_GetSingleList_LANG("MEM",$mem_type,'_en')?></span></td>
						</tr>
						<tr>
							<th scope="row">대표자 :</th>
							<td colspan="5"><span lang="en"><?=($_SESSION["NATION"]==$nation)?$pos_nm:$pos_nm_en?></span></td>
						</tr>
						<tr>
							<th scope="row"><span lang="en">Tel  :</span></th>
							<td style="width:256px"><span lang="en"><?=$tel?></span></td>
							<th scope="row"><span lang="en">Fax  :</span></th>
							<td style="width:204px"><span lang="en"><?=$fax?></span></td>
							<th scope="row">휴대전화  :</th>
							<td><span lang="en"><?=$hp?></span></td>
						</tr>
						<tr>
							<th scope="row">주소 :</th>
							<td colspan="5"><?=$nation==$_SESSION["NATION"]?"<span lang='ko'>".$addr." ".$addr_det:"<span lang='en'>".$addr_det_en." ".$addr_en?></span></td>
						</tr>
						<tr>
							<th scope="row" lang="en">E-mail :</th>
							<td><span lang="en"><?=$email?></span></td>
							<td colspan="4">
								<?if ($nation=='1' && $_SESSION["NATION"]){?>
								<span class="c-red">전자세금계산서 <span lang="en">E-Mail :</span></span> <span lang="en">kyunghee@digitaldream.kr</span>
								<?}?>
							</td>
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
			</section>
			<div class="clear">
			<section class="box-type8" style="min-height:143px">
				<div class="box-top">
					<h2>수입 선적 정보</h2>
				</div>
				<table class="stock-list-table">
					<tbody>
					<?
						$searchand=" and rel_idx='$idx' ";
						$result_imp =QRY_LIST(" impship ","all","1",$searchand," impship_idx DESC");
						while($row_imp = mysql_fetch_array($result_imp)){
							$i++;
							$impship_idx= replace_out($row_imp["impship_idx"]);
							$company_idx= replace_out($row_imp["company_idx"]);
							$account_no= replace_out($row_imp["account_no"]);
							$order= replace_out($row_imp["order"]);
						?>
						<tr style="background-color: <?=$i%2==0?"#f7f7f7":"#ffffff"?>;">
							<td style="width:25px"><?=$i?></td>
							<td style="width:80px"><img src="/kor/images/delivery_bn<?=$company_idx?>.gif" alt="" style="width:75px; height:18px;"></td>
							<td class="t-lt"style="width:110px" ><?=GF_Common_GetSingleList("DLVR",$company_idx)?> Account No.</td>
							<td class="t-lt">: <span class="c-blue"><?=$account_no?></span></td>
						</tr>
						<?}?>
					</tbody>
				</table>
			</section>	
			<section class="box-type8" style="min-height:143px;" >
				<div class="box-top">
					<h2>판매자 지정 운송회사</h2>
				</div>               
				<table class="table-type2 mr-t30" style="width:auto; margin:auto"><!--margin-top:65px; margin-left:85px;-->
					<tbody>
						<tr>
							<th scope="row">국제무역</th>
							<td style="width:80px;"><img src="/kor/images/delivery_bn2.gif" alt="" style="width:75px; height:18px;"></td>
						</tr>
						<tr>
							<th scope="row">국내거래</th>
							<td style="width:80px;"><img src="/kor/images/delivery_bn1.gif" alt="" style="width:75px; height:18px;"></td>
						</tr>
					</tbody>
				</table>               
			</section>
			</div>
			<section class="box-type1" style="min-height:215px">
				<div class="box-top">
					<h2>대리점</h2>
				</div>
				<table class="stock-list-table bgno">
					<thead>
						<tr>
							<th scope="col" class="th2" style="width:25px">No.</th>
							<th scope="col" class="th2" style="width:45px; padding:0 5px;">Logo</th>
							<th scope="col" class="th2 t-lt" style="width:180px" lang="ko">제조회사</th>
							<th scope="col" class="th2 t-lt" lang="ko">담당자/직책</th>
							<th scope="col" class="th2" style="width:100px" >Tel</th>
							<th scope="col" class="th2 t-lt" style="width:165px" >E-mail</th>
						</tr>
						</thead>
					<tbody>

<?
					$sql = "select a.*, b.mem_id, b.mem_nm_en, b.depart_nm_en,b.reg_date,b.tel, b.email from agency a
							left outer join member b on a.mem_idx = b.mem_idx
							where a.rel_idx = $idx ";		
							//echo $sql;
					$conn = dbconn();
					$i = 0;
					$result_agency=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());


					while($row_agency = mysql_fetch_array($result_agency)){
						$i++;
						$agency_idx= replace_out($row_agency["agency_idx"]);
						$agency_name= replace_out($row_agency["agency_name"]);
						$mem_idx= replace_out($row_agency["mem_idx"]);
						$mem_id= replace_out($row_agency["mem_id"]);
						$mem_nm_en= replace_out($row_agency["mem_nm_en"]);
						$depart_nm_en= replace_out($row_agency["depart_nm_en"]);
						$reg_date= replace_out($row_agency["reg_date"]);
						$agency_file1 = replace_out($row_agency["agency_file1"]);						
						$tel = replace_out($row_agency["tel"]);	
						$email = replace_out($row_agency["email"]);
						?>					
						<tr style="background-color: <?=$i%2==0?"#f7f7f7":"#ffffff"?>;">
							<td><?=$i?></td>
							<td style="width:45px; padding-right:5px;"><img src="<?=get_noimg($file_path, $agency_file1, "/kor/images/file_pt.gif")?>" alt="" style="width:75px; height:18px;"></td>
							<td class="t-lt" style="padding-right:5px;"><?=$agency_name?></td>
							<td class="t-lt"><?=$mem_nm_en?>/<?=$depart_nm_en?></td>
							<td><?=$tel?></td>
							<td class="t-lt"><?=$email?></td>
						</tr>
						<?}?>
					</tbody>
				</table>
			</section>
		</div>
		<div class="col-right">
			<?php include ($_SERVER["DOCUMENT_ROOT"]."/kor/include/side_credit_info.php"); ?>
		</div>
		<div class="clear-both"></div>
		<section class="box-type9">
			<div class="box-top">
				<h2>직원</h2>
			</div>
			<!-- 리스트 -->
			<div class="box-type10-list clear">
<?
		$searchand = "and rel_idx = $com_idx"; 
		
		$result_mem=QRY_MEMBER_LIST("", $searchand, "");
		
		while($row_mem= mysql_fetch_array($result_mem)){
			$i++;
			$mem_idx= replace_out($row_mem["mem_idx"]);
			$mem_id= replace_out($row_mem["mem_id"]);
			$mem_nm_en= replace_out($row_mem["mem_nm_en"]);
			$depart_nm_en= replace_out($row_mem["depart_nm_en"]);
			$nation = replace_out($row_mem["nation"]);	
			$tel= replace_out($row_mem["tel"]);
			$fax= replace_out($row_mem["fax"]);
			$homepage= replace_out($row_mem["homepage"]);
			$email= replace_out($row_mem["email"]);
			$skypeId= replace_out($row_mem["skypeId"]);
			$amount = get_want("mybank","charge_amt"," and mem_idx='$mem_idx' and charge_type='14'");
			if ($amount){
			?>

				<div class="box-type10">
					<table class="table-type2 mr-a0">
						<tbody>
							<tr>
								<th scope="row" style="width:70px">성명 :</th>
								<td><span lang="en"><?=$mem_nm_en?>/<?=$pos_nm_en?></span></td>
							</tr>
							<tr>
								<th scope="row">부서 :</th>
								<td><span lang="en"><?=$depart_nm_en?></span></td>
							</tr>
							<tr>
								<th scope="row"><span lang="en">Tel  :</span></th>
								<td style="width:256px"><span lang="en"><?=$tel?></span></td>
							</tr>
							<tr>
								<th scope="row"><span lang="en">Fax  :</span></th>
								<td style="width:256px"><span lang="en"><?=$fax?></span></td>
							</tr>
							<tr>
								<th scope="row">홈페이지 :</th>
								<td><span lang="en"><?=$depart_nm_en?></span></td>
							</tr>
							<tr>
								<th scope="row"><span lang="en">E-mail :</span></th>
								<td><span lang="en"><?=$email?></span></td>
							</tr>
							<tr>
								<th scope="row"><span lang="en">Skype ID  :</span></th>
								<td><span lang="en"><?=$skypeId?></span></td>
							</tr>
						</tbody>
					</table>
				</div>		
		<?}}?>
			</div>
			<!-- //리스트 -->			
		</section>




