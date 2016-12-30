<?
	include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.member.php";
	function GF_GET_MEM_DATA($rel_idx, $mem_type,$idx){?>
	<form name="f1" id="f1">
	<!-- form1 -->
	<input type="hidden" name="rel_idx" id="rel_idx" value="<?=$rel_idx?>">
	<input type="hidden" name="mem_type" id="mem_type" value="<?=$mem_type?>">
	<input type="hidden" id="hid_nation" name="hid_nation" value="<?=get_any("member", "nation", "mem_idx =$rel_idx")?>">
	<?
	if ($idx){
		$result = QRY_MEMBER_VIEW("idx",$idx);
		$row = mysql_fetch_array($result);
		$mem_pwd = replace_out($row["mem_pwd"]);
		$mem_id = replace_out($row["mem_id"]);
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
?>

<div class="box-top">
	<span class="left-btn"><a href="javascript:showajaxParam('.col-left', 'joinus' , 'mode=edit&rel_idx=<?=$rel_idx?>');"><img src="/kor/images/btn_back.gif" alt="이전"></a></span>
	<h2><?=get_variable_name($mem_type,"직원")?></h2>
</div>


<table class="join-form-table">
	<colgroup>
		<col style="width:141px">
		<col style="width:215px">
		<col style="width:25px">
		<col style="width:215px">
	</colgroup>
	<tbody>
		<tr>
			<th scope="row"><strong class="c-red">*</strong> <?=get_variable_name($mem_type,"직원")?> <span lang="en">ID</span></th>
			<td><input type="text" name="mem_id" class="i-txt3 c-blue" lang="en"   <?if ($typ=="write"){?>onblur="checkid('id',this.value,'아이디');"<?}?> value="<?=$mem_id?>" <?=$typ=="edit"?"readonly":""?>></td>
			<td>&nbsp;</td>
			<td><button type="button"><span id="checkspanid">* <span lang="en">ID</span>는 <span lang="en">5~15</span>자 사이의 영문+숫자</span></button></td>
		</tr>
		<tr>
			<th scope="row"><strong class="c-red">*</strong> <span lang="en">Password</span></th>
			<td><input type="password" name= "mem_pwd" lang="en"  value="" class="i-txt3 c-blue"></td>
			<td>&nbsp;</td>
			<td><?if ($typ=="edit"){?><button type="button">* Password 변경시에만 입력</button><?}?></td>
		</tr>
		<tr>
			<th scope="row"><strong class="c-red">*</strong> <span lang="en">Password</span> 재 입력</th>
			<td><input type="password" name="mem_pwd2" lang="en"  class="i-txt3 c-blue"></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<th scope="row"><strong class="c-red">*</strong> 성명</th>
			<td><input type="text" class="i-txt3 c-blue" placeholder="English" lang="en" name="mem_nm_en" value="<?=$mem_nm_en?>"></td>
			<td class="t-ct">/</td>
			<td><input type="text" class="i-txt3 c-blue" placeholder="모국어" lang="ko" name="mem_nm" value="<?=$mem_nm?>"></td>
		</tr>
		<tr>
			<th scope="row"><strong class="c-red">*</strong> 직책</th>
			<td><input type="text" class="i-txt3 c-blue" placeholder="English" lang="en" name="pos_nm_en" value="<?=$pos_nm_en?>"></td>
			<td class="t-ct">/</td>
			<td><input type="text" class="i-txt3 c-blue" placeholder="모국어" lang="ko" name="pos_nm" value="<?=$pos_nm?>"></td>

		</tr>
		<tr>
			<th scope="row"><strong class="c-red">*</strong> <?=get_variable_name($mem_type,"부서");?></th>
			<td><input type="text" class="i-txt3 c-blue" placeholder="English" lang="en" name="depart_nm_en" value="<?=$depart_nm_en?>"></td>
			<td class="t-ct">/</td>
			<td><input type="text" class="i-txt3 c-blue" placeholder="모국어" lang="ko" name="depart_nm" value="<?=$depart_nm?>"></td>
		</tr>
		<tr>
			<th scope="row"><strong class="c-red">*</strong> <span lang="en">Tel</span></th>
			<td><input type="text" class="i-txt3 c-blue" name="tel" lang="en"  value="<?=$tel?>"></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<th scope="row"><span lang="en">Fax</span></th>
			<td><input type="text" class="i-txt3 c-blue"  name="fax" lang="en"  value="<?=$fax?>"></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<th scope="row">휴대전화</th>
			<td><input type="text" class="i-txt3 c-blue"  name="hp" lang="en" value="<?=$hp?>"></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
				<th scope="row"><strong class="c-red">*</strong> <span lang="en">E-mail</span></th>
				<td><input type="text" class="i-txt3 c-blue" name="email" lang="en" value="<?=$email?>"></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<?if ($mem_type =="0"){?>
			<tr>
				<th scope="row">담당국가</th>
				<td class="related-nation-list">
				<input type="hidden" name ="show_assign_nation" value="Y">
									<? //국가명 반복(추가된것 제외)
									$result = QRY_FREIGHT_NATION2($rel_idx);
									for ($i=0; $row = mysql_fetch_array($result); $i++) {
										$nation = $row["code_desc"];
										$na_code = $row["dtl_code"];
										$my_saved_cnt = QRY_CNT("manage"," and mem_idx = '$idx' and assign_nation = $na_code ");  //기 등록여부(내가 담당중인지)
										$tot_saved_cnt = QRY_CNT("manage"," and mem_idx !='$idx' and assign_nation = $na_code ");  //기 등록여부(다른사람 포함)
										$chk ="";
										if ($my_saved_cnt > 0 ){
											$chk  ="checked class='checked'";
										}elseif ($tot_saved_cnt>0){
											$chk ="disabled";
										}
									?>
									<li>
										<label class="ipt-chk chk2" lang="en">
											<input name="assign_nation[]" type="checkbox" value="<?=$na_code;?>" <?=$chk?>>
											<span></span><?=$nation;?>
										</label>
									</li>
									<? } ?>
								</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td> 
			</tr>
			<?}?>
			<tr>
				<th scope="row"><span lang="en">Skype ID</span></th>
				<td><input type="text" class="i-txt3 c-blue" lang="en" name="skypeId" value="<?=$skypeId?>"></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
	</tbody>
</table>
<div class="btn-area t-rt">
	<span><img src="/kor/images/btn_turn_save_1.gif" alt="저장"></span>
	<span style="display:none;"><img src="/kor/images/btn_turn_save.gif" alt="저장" style="cursor:pointer;" onclick="check();"></span>
</div>
<input type="hidden" name="typ" value="<?=$typ?>">
<input type="hidden" name="idx" id="idx" value="<?=$idx?>">

<hr class="dashline">
<table class="stock-list-table bgno">
	<thead>
		<tr>
			<th scope="col" class="th2" style="width:43px">No.</th>
			<th scope="col" class="th2 t-lt" style="width:181px"><span lang="ko"><?=get_variable_name($mem_type,"직원")?></span> ID</th>
			<th scope="col" class="th2 t-lt"><span lang="ko"><?=get_variable_name($mem_type,"직원")?>  성명/직책</span></th>
			<th scope="col" class="th2" style="width:51px"></th>
			<th scope="col" class="th2" style="width:51px"></th>
		</tr>
	</thead>
	<tbody>
	<?
		$searchand .= "and rel_idx = $rel_idx "; 

		$cnt = QRY_CNT("member",$searchand);
		$result=QRY_MEMBER_LIST("", $searchand, "");
		$i = 0;
		
		if ($cnt > 0){
		while($row = mysql_fetch_array($result)){
			$i++;
			$mem_idx= replace_out($row["mem_idx"]);
			$mem_id= replace_out($row["mem_id"]);
			$mem_nm= replace_out($row["mem_nm"]);
			$depart_nm= replace_out($row["depart_nm"]);
			?>
		<tr>
			<td><?=$i?></td>
			<td class="t-lt c-blue"><?=$mem_id?></td>
			<td class="t-lt c-blue" lang="ko"><?=$mem_nm?> / <?=$depart_nm?></td>
			<td><img src="/kor/images/btn_delete.gif" alt="삭제" style="cursor:pointer;" onclick="del('member','<?=$mem_idx?>');"></td>
			<td class="pd-r0"><img src="/kor/images/btn_edit.gif" alt="편집" style="cursor:pointer;" onclick="edit('member','<?=$mem_idx?>');"></td>
		</tr>
		<?}
		}else{
	?><tr>
			<td colspan="5"><!--등록된 데이터가 없습니다.--></td>
		</tr>
	<?	}?>
	</tbody>
</table>
<!-- //form1 -->
</form>
<?
}

function GF_GET_IMPSHIP_DATA($rel_idx, $idx){
	?><form name="f2" id="f2">
			<input type="hidden" name="rel_idx" value="<?=$rel_idx?>">
			<input type="hidden" name="typ" value="impship">
			
<?
	if ($idx){
		$result = QRY_IMPSHIP_VIEW($idx);
		$row = mysql_fetch_array($result);
		$idx = replace_out($row["impship_idx"]);
		$company_idx = replace_out($row["company_idx"]);
		$account_no = replace_out($row["account_no"]);	
	}

	?>
	<script type="text/javascript">
	<!--
			$(".option-table input[name=account_no]").keyup(function(){
				if($(this).val()!=""){
					$(this).parent().next().find("span:eq(0)").hide();
					$(this).parent().next().find("span:eq(1)").show();
				}else{
					$(this).parent().next().find("span:eq(1)").hide();
					$(this).parent().next().find("span:eq(0)").show();
				}
		});


	//-->
	</script>

<div class="box-top">
		<h2>수입 선적 정보</h2>
	</div>
	<table class="option-table">
		<tbody>
			<tr>
				<th scope="row" style="width:168px">운송회사</th>
				<td style="width:142px">
					<div class="select type6 bdb" lang="en" style="width:100px">
						<label class="c-blue"><?=($idx)?GF_Common_GetSingleList("DLVR",$company_idx):"";?></label>
						<?=GF_Common_SetComboList("company_idx", "DLVR", "", 1, "True",  "", $company_idx , "");?>
					</div>
				</td>
				<th scope="row" style="width:110px"><span lang="en">Account No.</span></th>
				<td><input type="text" class="i-txt3 c-blue" name="account_no" style="width:162px" value="<?=$account_no?>"></td>
				<td style="width:51px">
				<span><img src="/kor/images/btn_turn_save_1.gif" alt="저장"></span>
				<span style="display:none;"><img src="/kor/images/btn_turn_save.gif" alt="저장" style="cursor:pointer;" onclick="check_impship();"></span>
				</td>
			</tr>
		</tbody>
	</table>
	<input type="hidden" name="idx" value="<?=$idx?>">
	<hr class="dashline">
	<table class="stock-list-table bgno">
		<thead>
			<tr>
				<th scope="col" class="th2" style="width:43px">No.</th>
				<th scope="col" class="th2"><span lang="ko">운송회사</span></th>
				<th scope="col" class="th2">Account No.</th>
				<th scope="col" class="th2" style="width:51px"></th>
				<th scope="col" class="th2" style="width:51px"></th>
			</tr>
		</thead>
		<tbody>
			<?
			$searchand .= "and rel_idx = $rel_idx "; 
			$cnt = QRY_CNT("impship",$searchand);
			$result=QRY_IMPSHIP_LIST(10, $searchand, 1);
			$i = 0;
			if ($cnt > 0){
			while($row = mysql_fetch_array($result)){
				$i++;
				$impship_idx= replace_out($row["impship_idx"]);
				$company_idx= replace_out($row["company_idx"]);
				$account_no= replace_out($row["account_no"]);
				$order= replace_out($row["order"]);
				?>
			<tr>
				<td><?=$i?></td>
				<td><img src="/kor/images/delivery_bn<?=$company_idx?>.gif" alt=""/></td>
				<td class="c-blue"><?=$account_no?></td>
				<td><img src="/kor/images/btn_delete.gif" alt="삭제"  style="cursor:pointer;" onclick="del('impship', '<?=$impship_idx?>');"></td>
				<td class="pd-r0"><img src="/kor/images/btn_edit.gif" alt="편집" style="cursor:pointer;" onclick="edit('impship','<?=$impship_idx?>');"></td>
			</tr>
			<?}
			}else{
		?><tr>
				<td colspan="5"><!--등록된 데이터가 없습니다.--></td>
			</tr>
		<?	}?>
			
		</tbody>
	</table>
	<!-- //form2 -->
	</form>	
	<?
			
}


function GF_GET_AGENCY_DATA($rel_idx, $idx){?>

<form name="f3" id="f3">
<input type="hidden" name="rel_idx" value="<?=$rel_idx?>">
<input type="hidden" name="typ" value="agency">
<?
	if ($idx){
		$result = QRY_VIEW("agency"," and idx='$idx'");
		$row = mysql_fetch_array($result);
		$idx = replace_out($row["idx"]);
		$agency_idx = replace_out($row["agency_idx"]);
		$agency_name = replace_out($row["agency_name"]);
		$mem_idx = replace_out($row["mem_idx"]);	
	}

	?>

	<script type="text/javascript">
	<!--
		$(document).ready(function(){
			$("#f3 .option-table #idx").change(function(){				
					if($(this).val()==""){
						$("#f3 .option-table #agency_name").val("");
						$("#f3 .option-table #agency_name").show();
						$("#f3 .option-table #idx").parent().hide();
						$("#f3 .option-table").find("td:last span:eq(1)").hide();
						$("#f3 .option-table").find("td:last span:eq(0)").show();
						
					}else{
						$("#f3 .option-table #agency_name").val($(this).find("option:selected").text());
						$("#f3 .option-table #agency_name").hide();
						if ($("#f3 .option-table #mem_idx option:selected").val()!="")
						{
							$("#f3 .option-table").find("td:last span:eq(0)").hide();
							$("#f3 .option-table").find("td:last span:eq(1)").show();
							
						}else{
							
						}
					}
			});
			/** 2016-10-08 **/
			$("#f3 #chk_direct_id").click(function(){
				if($(this).is(':checked')){
					$("#f3 .option-table #agency_name").val("");
					$("#f3 .option-table #agency_name").show();
					$("#f3 .option-table #idx").parent().hide()
					$("#f3 .option-table").find("td:last span:eq(1)").hide();
					$("#f3 .option-table").find("td:last span:eq(0)").show();
				}else{
					$("#f3 .option-table #idx").parent().show()
					$("#f3 .option-table #agency_name").val("");
					$("#f3 .option-table #agency_name").hide();
					$("#f3 .option-table").find("td:last span:eq(1)").show();
					$("#f3 .option-table").find("td:last span:eq(0)").hide();				
				}
			});


			$("#f3 .option-table #mem_idx").change(function(){
					if ($(this).val()!= "" && ($("#f3 .option-table #idx option:selected").val()!="" || ($("#f3 .option-table #idx option:selected").val()=="" && $("#f3 .option-table #agency_name").val()!=""))){
						$("#f3 .option-table").find("td:last span:eq(0)").hide();
						$("#f3 .option-table").find("td:last span:eq(1)").show();
					}else{
						$("#f3 .option-table").find("td:last span:eq(1)").hide();
						$("#f3 .option-table").find("td:last span:eq(0)").show();
					}
			});

			$("#f3 .option-table #agency_name").keyup(function(){
				if ($(this).val() != "" && $("#f3 .option-table #mem_idx").val()!="")
				{
					$("#f3 .option-table").find("td:last span:eq(0)").hide();
					$("#f3 .option-table").find("td:last span:eq(1)").show();
				}else{
					$("#f3 .option-table").find("td:last span:eq(1)").hide();
					$("#f3 .option-table").find("td:last span:eq(0)").show();
				}
			});


		});

	//-->
	</script>
	<div class="box-top">
		<h2>대리점</h2>
	</div>
	<div><p class="c-red t-ct pd-tb20"> - 공식 대리점만 등록바랍니다. 등록된 제조회사가 없을시 본사 담당자에게 등록신청 바랍니다. -
</p></div>
	<table class="option-table">
		<tbody>
			<tr>
				<th scope="row" style="width:168px">제조회사</th>
				<td style="width:280px">
				<!--자동완성-->
				<!--<?include $_SERVER["DOCUMENT_ROOT"]."/include/agency_db.php";?>
				<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
				<script type="text/javascript" src="/jquery/autocomplete/jquery.autocomplete.js"></script>
				<link rel="stylesheet" type="text/css" href="/jquery/autocomplete/jquery.autocomplete.css"/>

				<script type="text/javascript">
				 $(document).ready(function() {
				  $("#agency_search").autocomplete(goods,{
				   matchContains: true
				  });
				 });
				</script>-->
				<div class="select type6 bdb" lang="en" style="width:200px">
				<label class="c-blue"><?=($agency_idx)?get_any("agency","agency_name","idx=$agency_idx"):"";?></label>
				<?=AGENCY_SetComboList("idx",$_SESSION["REL_IDX"],True, "", $agency_idx, "")?>
				</div>
				<input type="text" name="agency_name" class="i-txt3 c-blue" value="<?=$agency_name?>" style="width:200px;display:none;" id="agency_name" >
				<!--<input type="checkbox" name="idx" id="chk_direct_id" value="1" style="position:relative;left:auto;top:auto;vertical-align:middle" /> <label for="">직접입력</label>-->
				<!--자동완성-->
				</td>
				<th scope="row" style="width:110px"><?=get_variable_name($mem_type,"직원")?><span lang="en">ID</span> (담당자)</th>
				<td>
					<div class="select type6 bdb" lang="en" style="width:142px">
						<label class="c-blue"><?=($idx)?get_any("member","mem_id","mem_idx=$mem_idx"):"";?></label>
						<?=MANAGER_SetComboList("mem_idx",$rel_idx,True, "", $mem_idx, "")?>
					</div>
				</td>
				<td style="width:51px">
				<span><img src="/kor/images/btn_turn_save_1.gif" alt="저장"></span>
				<span style="display:none;"><img src="/kor/images/btn_turn_save.gif" alt="저장" style="cursor:pointer;" onclick="check_agency();"></span>
				</td>
			</tr>
		</tbody>
	</table>
	<input type="hidden" name="idx" value="<?=$idx?>">
	<hr class="dashline">
	<table class="stock-list-table bgno">
		<thead>
			<tr>
				<th scope="col" class="th2" style="width:43px">No.</th>
				<th scope="col" class="th2"><span >Logo</span></th>
				<th scope="col" class="th2 t-lt" style="width:181px"><span lang="ko">제조회사</span></th>
				<th scope="col" class="th2 t-lt" style="width:140px"><span lang="ko"><?=get_variable_name($mem_type,"직원")?></span> ID</th>
				<th scope="col" class="th2 t-lt"><span lang="ko"><?=get_variable_name($mem_type,"직원")?> 성명/직책</span></th>
				<th scope="col" class="th2" style="width:51px"></th>
				<th scope="col" class="th2" style="width:51px"></th>
			</tr>
		</thead>
		<tbody>
		<?
		$searchand .= "and rel_idx = $rel_idx "; 
		$cnt = QRY_CNT("agency",$searchand);
		$sql = "select a.*, b.mem_id, b.mem_nm_en,depart_nm_en,agency_file1 from agency a
				left outer join member b on a.mem_idx = b.mem_idx
				where a.rel_idx = $rel_idx ";		

//				echo $sql;
		$conn = dbconn();
		$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
		$i = 0;
		if ($cnt > 0){
		while($row = mysql_fetch_array($result)){
			$i++;
			$agency_idx= replace_out($row["idx"]);
			$agency_name= replace_out($row["agency_name"]);
			$mem_idx= replace_out($row["mem_idx"]);
			$mem_id= replace_out($row["mem_id"]);
			$mem_nm_en= replace_out($row["mem_nm_en"]);
			$depart_nm_en= replace_out($row["depart_nm_en"]);
			$agency_file1= replace_out($row["agency_file1"]);
			?>
			<tr>
				<td><?=$i?></td>
				<td height="25" width="82"><img src="/upload/file/<?=$agency_file1?>" height="18" width="75" /></td>
				<td class="c-blue t-lt"><?=$agency_name?></td>
				<td class="t-lt"><?=$mem_id?></td>
				<td class="c-blue t-lt"><?=$mem_nm_en?>/<?=$depart_nm_en?></td>
				<td><img src="/kor/images/btn_delete.gif" alt="삭제" style="cursor:pointer;" onclick="del('agency', '<?=$agency_idx?>');" ></td>
				<td class="pd-r0"><img src="/kor/images/btn_edit.gif" alt="편집" style="cursor:pointer;" onclick="edit('agency','<?=$agency_idx?>');"></td>
			</tr>
		<?}
		}else{
	?><tr>
			<td colspan="6"><!--등록된 데이터가 없습니다.--></td>
		</tr>
	<?	}?>
		</tbody>
	</table>
	<!-- //form3 -->
</form>

<?
}

function GF_GET_ASSIGN_DATA($rel_idx, $assign_type){
	$result = QRY_ASSIGN_LIST($rel_idx, $assign_type);					
	$cnt=mysql_num_rows($result);	
	if ($assign_type == "1"){
			$row = mysql_fetch_array($result);
			if ($cnt >0){
				$o_company_idx = replace_out($row["o_company_idx"]);
				$i_company_idx = replace_out($row["i_company_idx"]);
				$assign_idx= replace_out($row["assign_idx"]);
			}?>
			<td>
				<span lang="ko">운송회사</span>
			<div class="select type8 bdb" lang="en" style="width:142px">									
				<label class="c-blue"><?=($o_company_idx)?GF_Common_GetSingleList("DLVR",$o_company_idx):"";?></label>
				<?=GF_Common_SetComboList("o_company_idx$assign_type", "DLVR", "", 1, "True",  "", $o_company_idx , "");?>
			</div>
			</td>
			<td class="line-lt">
				<span lang="ko">운송회사</span>
			<div class="select type8 bdb" lang="en" style="width:142px">									
				<label class="c-blue"><?=($i_company_idx)?GF_Common_GetSingleList("DLDO",$i_company_idx):"";?></label>
				<?=GF_Common_SetComboList("i_company_idx$assign_type", "DLDO", get_any("member", "nation", "mem_idx=$rel_idx"), 2, "True",  "", $i_company_idx , "");?>
			</div>
			</td>
			
	<?}else{		
				$i = 0;
				for ($i = 1 ; $i <= 3 ; $i++){
					if ($i <= $cnt){
						$row = mysql_fetch_array($result);
						$assign_idx= replace_out($row["assign_idx"]);
						$nation= replace_out($row["nation"]);
						$o_company_idx= replace_out($row["o_company_idx"]);
						$i_company_idx= replace_out($row["i_company_idx"]);
						$o_cost= replace_out($row["o_cost"])==0?"":replace_out($row["o_cost"]);
						$i_cost= replace_out($row["i_cost"])==0?"":replace_out($row["i_cost"]);
						$sort= replace_out($row["sort"]);
					}else{
						$assign_idx= "";
						$nation= "";
						$o_company_idx= "";
						$i_company_idx= "";
						$o_cost= "";
						$i_cost= "";
						$sort= "";
					}?>					
					<tr>
						<td><input type='hidden' name='assign_idx[]' value='<?=$assign_idx?>'>
						<?if ($i ==1){?>
							<div class="select type8 bdb" lang="en" style="width:122px">
								<label><?=($nation)?GF_Common_GetSingleList("NA",$nation):"";?></label>
								<?=GF_Common_SetComboList("nation", "NA", "", 1, "True",  "", $nation , "");?>
							</div>
							<?}?>
						</td>
						<td>
							<div class="select type8 bdb" lang="en" style="width:92px">
								<label><?=($o_company_idx)?GF_Common_GetSingleList("DLVR",$o_company_idx):"";?></label>
								<?=GF_Common_SetComboList("o_company_idx".$assign_type."[]", "DLVR", "", 1, "True",  "", $o_company_idx , "");?>
							</div>
						</td>
						<td class="c-red">$ <input type="text" name="o_cost[]" class="i-txt3 c-red onlynum numfmt" value="<?=$o_cost?>" style="width:48px"></td>
						<td class="line-lt">
							<div class="select type8 bdb" lang="en" style="width:92px">
								<label><?=($i_company_idx)?GF_Common_GetSingleList("DLDO",$i_company_idx):"";?></label>
								<?=GF_Common_SetComboList("i_company_idx".$assign_type."[]", "DLDO", get_any("member", "nation", "mem_idx=$rel_idx"), 2, "True",  "", $i_company_idx , "");?>
							</div>
						</td>
						<td class="c-red">$ <input type="text" name="i_cost[]" class="i-txt3 c-red onlynum numfmt" value="<?=number_format($i_cost)?>" style="width:48px"></td>
					</tr>
					<?
			}
		}

}
//2016-06-22 배송비 등록 내용(국제 or 국내)
function GF_GET_ASSIGN_DATA2($rel_idx, $trade_type){

	$result = QRY_FREIGHT_DLVR($rel_idx, $trade_type);
	if($trade_type==1){
		$sel_ty = "DLDO";
		$lang = "ko";
	}else{
		$sel_ty = "DLVR";
		$lang = "en";
	}
		
	for ($i=0; $row = mysql_fetch_array($result); $i++) {
		$freight_idx = $row["freight_idx"]; 
		$f_dest_idx = $row["f_dest_idx"];
		$t_company_idx =$row["t_company_idx"];
		$f_charge =$row["f_charge"];
		$ex_dest = explode(",", $f_dest_idx);
		$ex_company = explode(",", $t_company_idx);
		$ex_charge = explode(",", $f_charge);
?>	
	<tr id="saved_<?=$freight_idx;?>">
		<td lang="<?=$lang;?>">
			<?if(strpos($f_dest_idx, ",") == false){?>
				<label class="c-red"><?=($f_dest_idx)?GF_Common_GetSingleList("NA",$f_dest_idx):"";?></label>
			<?}else{?>

				<?for($k=0; $ex_dest[$k]; $k++){?>
				<label class="c-red"><?=($k==0)? "":", ";?><?=($ex_dest[$k])?GF_Common_GetSingleList("NA",$ex_dest[$k]):"";?></label>
				<?}?>
			<?}?>
		</td>
		<td>
			<label class="c-red" lang="<?=$lang;?>">
				<?for($k=0; $ex_company[$k]; $k++){
					if($k>0) echo "<br>";
				?>
				<?=($ex_company[$k])?GF_Common_GetSingleList($sel_ty,$ex_company[$k]):"";?>
				<?}?>
			</label>
		</td>
		<td>
			<?for($k=0; $ex_charge[$k]; $k++){
				if($k>0) echo "<br>";
			?>
			$<?=number_format($ex_charge[$k],2);?>
			<?}?>
		</td>
		<td>
			<button type="button" class="edit_f" idx="<?=$freight_idx;?>" trade_type="<?=$trade_type;?>"><img src="/kor/images/btn_edit.gif" alt="편집"></button>
			<button type="button" class="ss" onClick="del_freight(<?=$trade_type;?>,<?=$freight_idx;?>);"><img src="/kor/images/btn_delete.gif" alt="삭제"></button>	
		</td>
	</tr>
<?
	} //end for

} // end function
?>
