<?
include $_SERVER["DOCUMENT_ROOT"]."/admin/include/header.php";
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
		<td height="30" background="/admin/img/now_bg.gif" style="padding-left: 20px" class="now"><img src="/admin/img/icon.gif" width="9" height="7" /> HOME &gt; <?=$title_menu?>  </td>
	</tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="208" valign="top"><!--메뉴-->
		<?
		include $_SERVER["DOCUMENT_ROOT"]."/admin/include/lm.php";
		?>

		</td>
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
								<td height="40" class="rtitle01"><img src="/admin/img/icon_02.gif" width="15" height="15" vspace="3" align="absmiddle" /> <?=$title_text?></td>
							</tr>
						</table>
						<table width="99%" border="0" cellspacing="1" cellpadding="5" bgcolor="#e6e6e6">
							<tr>
								<td  width="150" align="center" bgcolor="#f6f6f6" class="btitle02">현재보증금 </td>
								<td bgcolor="#FFFFFF"> $3,000.00  </td>
								<td  width="150" align="center" bgcolor="#f6f6f6" class="btitle02">현재계약금 </td>
								<td bgcolor="#FFFFFF"> $3,000.00  </td>
								<td  width="150" align="center" bgcolor="#f6f6f6" class="btitle02">현재 My Bank  </td>
								<td bgcolor="#FFFFFF"> $100.00 </td>
								<td  width="150" align="center" bgcolor="#f6f6f6" class="btitle02">재고품목  </td>
								<td bgcolor="#FFFFFF">0000 개</td>
							</tr>
						<table>
						<br>
						<table width="99%" border="0" cellspacing="1" cellpadding="5" bgcolor="#e6e6e6">
							<tr>
								<td  width="150" align="center" bgcolor="#f6f6f6" class="btitle02">아이디 </td>
								<td bgcolor="#FFFFFF" colspan="3"><?=$mem_id?></td>
							</tr>
							<tr>
								<td  width="150" align="center" bgcolor="#f6f6f6" class="btitle02">국가 </td>
								<td bgcolor="#FFFFFF" colspan="3"><?=get_want("code_group_detail","code_desc"," and grp_code='NA' and dtl_code='$nation'")?></td>
							</tr>
							<tr>
								<td  width="150" align="center" bgcolor="#f6f6f6" class="btitle02">회사명 영문 </td>
								<td bgcolor="#FFFFFF" width="35%"><?=$mem_nm_en?> </td>
								<td  width="150" align="center" bgcolor="#f6f6f6" class="btitle02">회사명 모국어 </td>
								<td bgcolor="#FFFFFF"> <?=$mem_nm?></td>
							</tr>
							<tr>
								<td  width="150" align="center" bgcolor="#f6f6f6" class="btitle02">대표자명 영문</td>
								<td bgcolor="#FFFFFF"><?=$pos_nm_en?></td>
								<td  width="150" align="center" bgcolor="#f6f6f6" class="btitle02">대표자명 모국어</td>
								<td bgcolor="#FFFFFF"><?=$pos_nm?></td>
							</tr>
							<tr>
								<td  width="150" align="center" bgcolor="#f6f6f6" class="btitle02">학과/부서 영문 </td>
								<td bgcolor="#FFFFFF"><?=$depart_nm_en?></td>
								<td  width="150" align="center" bgcolor="#f6f6f6" class="btitle02">학과/부서 모국어 </td>
								<td bgcolor="#FFFFFF"><?=$depart_nm?></td>
							</tr>							
							<tr>
								<td  width="150" align="center" bgcolor="#f6f6f6" class="btitle02">전화번호 </td>
								<td bgcolor="#FFFFFF"><input name="tel" type="text"  class="inputtext" value='<?=$tel?>'  style="width:150px;" maxlength="20"></td>
								<td  width="150" align="center" bgcolor="#f6f6f6" class="btitle02">핸드폰 </td>
								<td bgcolor="#FFFFFF"><input name="hp" type="text"  class="inputtext" value='<?=$tel?>'  style="width:150px;" maxlength="20"></td>
							</tr>
							<tr>
								<td  width="150" align="center" bgcolor="#f6f6f6" class="btitle02">팩스 </td>
								<td bgcolor="#FFFFFF" colspan="3"><input name="fax" type="text"  class="inputtext" value='<?=$fax?>'  style="width:150px;" maxlength="20"></td>
							</tr>							
							<tr>
								<td  width="150" align="center" bgcolor="#f6f6f6" class="btitle02">우편번호 </td>
								<td bgcolor="#FFFFFF" colspan="3"><?=$zipcode?></td>
							</tr>
							<tr>
								<td  width="150" align="center" bgcolor="#f6f6f6" class="btitle02">도시 영문</td>
								<td bgcolor="#FFFFFF"><?=get_want("code_group_detail","code_desc"," and grp_code='NA' and dtl_code='$dosi_en'")?></td>
								<td  width="150" align="center" bgcolor="#f6f6f6" class="btitle02">도시 모국어 </td>
								<td bgcolor="#FFFFFF"><?=get_want("code_group_detail","code_desc"," and grp_code='NA' and dtl_code='$dosi'")?></td>
							</tr>
							<tr>
								<td  width="150" align="center" bgcolor="#f6f6f6" class="btitle02">시구군 영문</td>
								<td bgcolor="#FFFFFF"><?=get_want("code_group_detail","code_desc"," and grp_code='NA' and dtl_code='$sigungu_en'")?></td>
								<td  width="150" align="center" bgcolor="#f6f6f6" class="btitle02">시구군 모국어</td>
								<td bgcolor="#FFFFFF"><?=get_want("code_group_detail","code_desc"," and grp_code='NA' and dtl_code='$sigungu'")?></td>
							</tr>
							<tr>
								<td  width="150" align="center" bgcolor="#f6f6f6" class="btitle02">주소 </td>
								<td bgcolor="#FFFFFF"><?=$addr?></td>
								<td  width="150" align="center" bgcolor="#f6f6f6" class="btitle02">주소영문 </td>
								<td bgcolor="#FFFFFF"><?=$addr_en?></td>
							</tr>							
							<tr>
								<td  width="150" align="center" bgcolor="#f6f6f6" class="btitle02">이메일 </td>
								<td bgcolor="#FFFFFF"><?=$email?></td>
								<td  width="150" align="center" bgcolor="#f6f6f6" class="btitle02">홈페이지 </td>
								<td bgcolor="#FFFFFF"><?=$homepage?></td>
							</tr>							
							<tr>
								<td  width="150" align="center" bgcolor="#f6f6f6" class="btitle02">스카이프아이디 </td>
								<td bgcolor="#FFFFFF"><?=$skypeId?></td>
							</tr>							
							<tr>
								<td  width="150" align="center" bgcolor="#f6f6f6" class="btitle02">로고 </td>
								<td bgcolor="#FFFFFF"><?if($filelogo){?>
								<a href="<?=$file_path?><?=$filelogo?>" target="_img">
								<img src="<?=$file_path?><?=$filelogo?>" border="0" id="img1" onload="img_resize('img1','200','200')" >
								</a>
								<?}?></td>
								<td  width="150" align="center" bgcolor="#f6f6f6" class="btitle02">싸인 </td>
								<td bgcolor="#FFFFFF"><?if($filesign){?>
								<a href="<?=$file_path?><?=$filesign?>" target="_img">
								<img src="<?=$file_path?><?=$filesign?>" border="0" id="img2" onload="img_resize('img2','200','200')">
								</a>
								<?}?></td>
							</tr>							
							<tr>
								<td  width="150" align="center" bgcolor="#f6f6f6" class="btitle02">사업자등록증 </td>
								<td bgcolor="#FFFFFF"><?if($filereg_no){?>
								<a href="<?=$file_path?><?=$filereg_no?>" target="_img">
								<img src="<?=$file_path?><?=$filereg_no?>" border="0" id="img3" onload="img_resize('img3','300','300')"></a>
								<?}?></td>
							</tr>
							<tr>
								<td  width="150" align="center" bgcolor="#f6f6f6" class="btitle02">증명서1 </td>
								<td bgcolor="#FFFFFF"><?if($filecerti1){?>
								<a href="<?=$file_path?><?=$filecerti1?>" target="_img">
								<img src="<?=$file_path?><?=$filecerti1?>" border="0" id="img4" onload="img_resize('img4','200','200')"><?}?></td>
								<td  width="150" align="center" bgcolor="#f6f6f6" class="btitle02">증명서2 </td>
								<td bgcolor="#FFFFFF"><?if($filecerti2){?>
								<a href="<?=$file_path?><?=$filecerti2?>" target="_img">
								<img src="<?=$file_path?><?=$filecerti2?>" border="0" id="img5" onload="img_resize('img5','200','200')"><?}?></td>
							</tr>
							<tr>
								<td  width="150" align="center" bgcolor="#f6f6f6" class="btitle02">증명서1오픈여부 </td>
								<td bgcolor="#FFFFFF"><?=$certi1open_yn?></td>
								<td  width="150" align="center" bgcolor="#f6f6f6" class="btitle02">증명서2오픈여부 </td>
								<td bgcolor="#FFFFFF"><?=$certi2open_yn?></td>
							</tr>
							<tr>
								<td  width="150" align="center" bgcolor="#f6f6f6" class="btitle02">사무실/창고1 </td>
								<td bgcolor="#FFFFFF"><?if($filestore1){?>
								<a href="<?=$file_path?><?=$filestore1?>" target="_img">
								<img src="<?=$file_path?><?=$filestore1?>" border="0" id="img6" onload="img_resize('img6','200','200')"><?}?></td>
								<td  width="150" align="center" bgcolor="#f6f6f6" class="btitle02">사무실/창고2 </td>
								<td bgcolor="#FFFFFF"><?if($filestore2){?>
								<a href="<?=$file_path?><?=$filestore2?>" target="_img">
								<img src="<?=$file_path?><?=$filestore2?>"  border="0" id="img7" onload="img_resize('img7','200','200')"><?}?></td>
							</tr>							
							<tr>
								<td  width="150" align="center" bgcolor="#f6f6f6" class="btitle02">사무실/창고3 </td>
								<td bgcolor="#FFFFFF"><?if($filestore3){?>
								<a href="<?=$file_path?><?=$filestore2?>" target="_img">
								<img src="<?=$file_path?><?=$filestore3?>" border="0" id="img8" onload="img_resize('img8','200','200')"><?}?></td>
								<td  width="150" align="center" bgcolor="#f6f6f6" class="btitle02">사무실/창고4 </td>
								<td bgcolor="#FFFFFF"><?if($filestore4){?>
								<a href="<?=$file_path?><?=$filestore2?>" target="_img">
								<img src="<?=$file_path?><?=$filestore4?>" border="0" id="img9" onload="img_resize('img9','200','200')"><?}?></td>
							</tr>						
							
							<tr>
								<td  width="150" align="center" bgcolor="#f6f6f6" class="btitle02">로그인횟수 </td>
								<td bgcolor="#FFFFFF"><?=$login_count?></td>
								<td  width="150" align="center" bgcolor="#f6f6f6" class="btitle02">등록일 </td>
								<td bgcolor="#FFFFFF"><?=$reg_date?></td>
							</tr>
							
						</table>
						<br>
						<table width="99%" border="0" cellspacing="1" cellpadding="5" bgcolor="#e6e6e6">
							<tr>			
								<td  width="150" align="center" bgcolor="#f6f6f6" class="btitle02">은행명 </td>
								<td bgcolor="#FFFFFF"><?=$bank_name?></td>
								<td  width="150" align="center" bgcolor="#f6f6f6" class="btitle02">은행계좌 </td>
								<td bgcolor="#FFFFFF"><?=$bank_account?></td>
								<td  width="150" align="center" bgcolor="#f6f6f6" class="btitle02">수취인이름 </td>
								<td bgcolor="#FFFFFF" colspan="3"><?=$bank_user_name?></td>
							</tr>		
						</table>
						<br />
						
						<table width="99%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td height="40" align="center" class="rtitle01">
								<span class="btn1"><a href="member_write.php?<?=$param?>&idx=<?=$idx?>">수정</a></span>
								<span class="btn1"><a href="member_list.php?<?=$param?>">목록</a></span>
							
							<!-- 	<a href="javascript:checkaaaa();"> eeeee </a>  -->
								
								
								</td>
							</tr>
						</table>
						<br />
						<br />
						<br />
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
<?
include $_SERVER["DOCUMENT_ROOT"]."/admin/include/footer.php";
?>
