<?
include $_SERVER["DOCUMENT_ROOT"]."/admin/include/header_index.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.member.php";

if ($idx){
	$result = QRY_MEMBER_VIEW("idx",$idx);
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
	$typ = "edit";

}
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td height="30" background="/admin/img/now_bg.gif" style="padding-left: 20px" class="now"><img src="/admin/img/icon.gif" width="9" height="7" /> HOME &gt; 회원관리  </td>
	</tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td valign="top">
		<table width="100%" border="0" cellspacing="1" cellpadding="4" bgcolor="#8e9194">
			<tr>
				<td align="center" bgcolor="#63676a">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td width="6" valign="top"><img src="/admin/img/t_01.gif" width="6" height="6" /></td>
						<td background="/admin/img/t_05.gif"></td>
						<td width="6" align="right" valign="top"><img src="/admin/img/t_02.gif" width="6" height="6" /></td>
					</tr>
					<tr>
						<td background="/admin/img/t_07.gif"></td>
						<td align="center" valign="top" bgcolor="#FFFFFF">

						<!--오른쪽 시작-->

						<br />
						<table width="99%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td height="40" class="rtitle01"><img src="/admin/img/icon_02.gif" width="15" height="15" vspace="3" align="absmiddle" /> 직원관리</td>
							</tr>
						</table>
						<table width="99%" border="0" cellspacing="1" cellpadding="5" bgcolor="#e6e6e6">
							<tr>
								<td  width="150" align="center" bgcolor="#f6f6f6" class="btitle02">아이디 </td>
								<td bgcolor="#FFFFFF" colspan="3"><?=$mem_id?></td>
							</tr>
							<!--<tr>
								<td  width="150" align="center" bgcolor="#f6f6f6" class="btitle02">패스워드 </td>
								<td bgcolor="#FFFFFF"><input name="mem_name" type="text"  class="inputtext" value='<?=$mem_name?>'  style="width:150px;" maxlength="20"></td>
								<td  width="150" align="center" bgcolor="#f6f6f6" class="btitle02">패스워드재입력 </td>
								<td bgcolor="#FFFFFF"><input name="mem_name" type="text"  class="inputtext" value='<?=$mem_name?>'  style="width:150px;" maxlength="20"></td>
							</tr>-->
							
							<tr>
								<td  width="150" align="center" bgcolor="#f6f6f6" class="btitle02">성명</td>
								<td bgcolor="#FFFFFF" width="35%"><?=$mem_nm?></td>
								<td  width="150" align="center" bgcolor="#f6f6f6" class="btitle02">성명 영문 </td>
								<td bgcolor="#FFFFFF" width="35%"><?=$mem_nm_eng?></td>
							</tr>							
							<tr>
								<td  width="150" align="center" bgcolor="#f6f6f6" class="btitle02">직책 </td>
								<td bgcolor="#FFFFFF"><?=$pos_nm?></td>
								<td  width="150" align="center" bgcolor="#f6f6f6" class="btitle02">직책 영문 </td>
								<td bgcolor="#FFFFFF"><?=$pos_nm_en?></td>
							</tr>						
							<tr>
								<td  width="150" align="center" bgcolor="#f6f6f6" class="btitle02">부서 </td>
								<td bgcolor="#FFFFFF"><?=$depart_nm?></td>
								<td  width="150" align="center" bgcolor="#f6f6f6" class="btitle02">부서 영문 </td>
								<td bgcolor="#FFFFFF"><?=$depart_nm_en?></td>
							</tr>							
							<tr>
								<td  width="150" align="center" bgcolor="#f6f6f6" class="btitle02">TEL </td>
								<td bgcolor="#FFFFFF" colspan="3"><?=$tel?></td>
							</tr>
							<tr>
								<td  width="150" align="center" bgcolor="#f6f6f6" class="btitle02">FAX </td>
								<td bgcolor="#FFFFFF" colspan="3"><?=$fax?></td>
							</tr>
							<tr>
								<td  width="150" align="center" bgcolor="#f6f6f6" class="btitle02">휴대전화 </td>
								<td bgcolor="#FFFFFF" colspan="3"><?=$hp?></td>
							</tr>
							<tr>
								<td  width="150" align="center" bgcolor="#f6f6f6" class="btitle02">E-mail </td>
								<td bgcolor="#FFFFFF" colspan="3"><?=$email?></td>
							</tr>
							<tr>
								<td  width="150" align="center" bgcolor="#f6f6f6" class="btitle02">Skype ID </td>
								<td bgcolor="#FFFFFF" colspan="3"><?=$skypeid?></td>
							</tr>							
							<tr>
								<td  width="150" align="center" bgcolor="#f6f6f6" class="btitle02">로그인횟수 </td>
								<td bgcolor="#FFFFFF" colspan="3"><?=$login_count?></td>
							</tr>
							<tr>
								<td  width="150" align="center" bgcolor="#f6f6f6" class="btitle02">등록일 </td>
								<td bgcolor="#FFFFFF" colspan="3"><?=$reg_date?></td>
							</tr>
							
						</table>
						<br />

						<table width="99%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td height="40" align="center" class="rtitle01">
								<span class="btn1"><a href="javascript:self.close();">닫기</a></span>
							
							<!-- 	<a href="javascript:checkaaaa();"> eeeee </a>  -->
								
								
								</td>
							</tr>
						</table>
						<br />
						<!--오른쪽 끝-->


						</td>
						<td background="/admin/img/t_08.gif"></td>
					</tr>
					<tr>
						<td><img src="/admin/img/t_03.gif" width="6" height="6" /></td>
						<td background="/admin/img/t_06.gif"></td>
						<td align="right"><img src="/admin/img/t_04.gif" width="6" height="6" /></td>
					</tr>
				</table></td>
			</tr>
		</table></td>
	</tr>
</table>
