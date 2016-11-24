<?
include $_SERVER["DOCUMENT_ROOT"]."/admin/include/header.php";
if ($search){
	$searchand = " and nation = '$search'";
}

$cnt = QRY_CNT("headoffice",$searchand);
$totalpage = QRY_TOTALPAGE($cnt,$recordcnt);
$result =QRY_LIST("headoffice",$recordcnt,$page,$searchand," idx desc");
?>
<script type="text/javascript">
<!--

	function check(obj,typ,txt){
		var f = eval("document."+obj);
		if (nullchk_admin(f.nation,"국가를 선택하세요.")== false) return ;
		if (nullchk_admin(f.tel1,"전화번호를 입력하세요.")== false) return ;
		
		f.typ.value=typ;
		f.target = "_self";
		f.action = "/admin/agency/headoffice_proc.php";
		f.submit();
	}
//-->
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td height="30" background="/admin/img/now_bg.gif" style="padding-left: 20px" class="now"><img src="/admin/img/icon.gif" width="9" height="7" /> HOME &gt; 사이트관리</td>
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
						<br />
						<table width="99%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td height="40" class="rtitle01"><img src="/admin/img/icon_02.gif" width="15" height="15" vspace="3" align="absmiddle" />   <?=$title_text?></td>
								<td width="100" height="35" class="rtitle01" align="center"><p class="tblue">검색건수 : &nbsp;<?=$cnt?>&#13;</p></td>
								<!--<td align="right" class="btitle02" width="100">								
								<a href="javascript:down_excel('excel')"><span class="btn">엑셀 파일</span></a>
								</td>-->
							</tr>
						</table>
						<!--오른쪽 시작-->
						<form name="f" method="post">
						<input type="hidden" name="typ" value="">
						<input type="hidden" name="mode" value="<?=$mode?>">
						<table width="99%" border="0" cellspacing="0" cellpadding="0" background="/admin/img/boardbar_bg.gif">
							<tr>
								<td height="27" align="center" class="btitle01" >국가명</td>
								<td width="250" align="center" class="btitle01">Tel</td>
								<td width="250" align="center" class="btitle01">Fax</td>								
								<td width="250" align="center" class="btitle01">Email</td>
								<td width="100" align="center" class="btitle01">저장</td>
							</tr>
						</table>	
						<table width="99%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td height="50" align="center">
								<select name="nation">
								<option value="">국가선택</option>
								<?
								$result1 =QRY_LIST("code_group_detail","all","1"," and grp_code='NA' and code_depth='1' "," dtl_code ASC");
								while($row1 = mysql_fetch_array($result1)){
									$dtl_code= replace_out($row1["dtl_code"]);
									$code_desc= replace_out($row1["code_desc"]);
								?>
								<option value="<?=$dtl_code?>"  <?If ($dtl_code==$search1) {?> selected <? } ?>><?=$code_desc?></option>
								<?
								}
								?>
								</select>
								</td>	
								<td width="250" align="center">
								1.<input name="tel1" type="text" maxlength="50" value="<?=$tel1?>" class="inputtext" style="width:200px;"><br>
								2.<input name="tel2" type="text" maxlength="50" value="<?=$tel1?>" class="inputtext" style="width:200px;"></td>
								<td width="250" align="center">
								<input name="fax1" type="text" maxlength="50" value="<?=$fax1?>" class="inputtext" style="width:200px;"></td>
								<td width="250" align="center">
								1.<input name="email1" type="text" maxlength="50" value="<?=$email1?>" class="inputtext" style="width:200px;"><br>
								2.<input name="email2" type="text" maxlength="50" value="<?=$email2?>" class="inputtext" style="width:200px;"></td>
								<td width="100" align="center"><span class="btn1"><a href="javascript: check('f','write','저장');">추가</a></span></td>
							</tr>
							<tr>
								<td height="1" colspan="9" bgcolor="#dcd8d6"></td>
							</tr>
						</table>
						</form>
						<br>
						<table width="99%" border="0" cellspacing="0" cellpadding="0" background="/admin/img/boardbar_bg.gif">
							<tr>
								<td height="27" align="center" class="btitle01" >국가명</td>
								<td width="250" align="center" class="btitle01">Tel</td>
								<td width="250" align="center" class="btitle01">Fax</td>								
								<td width="250" align="center" class="btitle01">Email</td>
								<td width="100" align="center" class="btitle01">상태변경</td>
							</tr>
						</table>					
						<!--일반게시글 시작-->
						<?
						if ($cnt==0){
						?>
						<table width="99%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td height="50" align="center">등록 된 자료가 없습니다</td>
							</tr>
							<tr>
								<td height="1" colspan="9" bgcolor="#dcd8d6"></td>
							</tr>
						</table>
						<?
						}
						$ListNO=$cnt-(($page-1)*$recordcnt);

						while($row = mysql_fetch_array($result)){
							$idx = replace_out($row["idx"]);
							$nation = replace_out($row["nation"]);
							$tel1 = replace_out($row["tel1"]);
							$tel2 = replace_out($row["tel2"]);
							$fax1 = replace_out($row["fax1"]);
							$fax2 = replace_out($row["fax2"]);
							$email1 = replace_out($row["email1"]);
							$email2 = replace_out($row["email2"]);
						?>
						<form name='f<?=$idx?>' method="post">
						<input type="hidden" name="typ" value="">
						<input type="hidden" name="mode" value="<?=$mode?>">
						<input type="hidden" name="idx" value="<?=$idx?>">
						<table width="99%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td  height="50" align="center">
								<select name="nation">
								<option value="">국가선택</option>
								<?
								$result1 =QRY_LIST("code_group_detail","all","1"," and grp_code='NA' and code_depth='1' "," dtl_code ASC");
								while($row1 = mysql_fetch_array($result1)){
									$dtl_code= replace_out($row1["dtl_code"]);
									$code_desc= replace_out($row1["code_desc"]);
								?>
								<option value="<?=$dtl_code?>"  <?If ($dtl_code==$nation) {?> selected <? } ?>><?=$code_desc?></option>
								<?
								}
								?>
								</select>
								</td>	
								<td width="250" align="center">
								1.<input name="tel1" type="text" maxlength="50" value="<?=$tel1?>" class="inputtext" style="width:200px;"><br>
								2.<input name="tel2" type="text" maxlength="50" value="<?=$tel1?>" class="inputtext" style="width:200px;"></td>
								<td width="250" align="center">
								<input name="fax1" type="text" maxlength="50" value="<?=$fax1?>" class="inputtext" style="width:200px;" ></td>
								<td width="250" align="center">
								1.<input name="email1" type="text" maxlength="50" value="<?=$email1?>" class="inputtext" style="width:200px;"><br>
								2.<input name="email2" type="text" maxlength="50" value="<?=$email2?>" class="inputtext" style="width:200px;"></td>
								<td width="100" align="center">
								<span class="btn1"><a href="javascript: check('f<?=$idx?>','edit','수정');">수정</a></span>
								<span class="btn1"><a href="javascript: check('f<?=$idx?>','del','삭제');">삭제</a></span></td>
							</tr>
							<tr>
								<td height="1" colspan="9" bgcolor="#dcd8d6"></td>
							</tr>
						</table>
						</form>
						<? 
							$ListNO--;
						} 
						?>
						<br>
						<table width="99%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td height="40" align="center">
								<?
								$addpara = "";
								$pageurl = "headoffice.php";

								include $_SERVER["DOCUMENT_ROOT"]."/admin/include/paging_admin.php";

								?>
								</td>
							</tr>
						</table>
						<br />
						<form name="searchfrm" method="post" action="headoffice.php?mode=<?=$mode?>">
						<input type="hidden" name="mode" value="<?=$mode?>">
						<input type="hidden" name="page" value="">
						<table width="99%" border="0" cellspacing="0" cellpadding="0" bgcolor="#f0f0f0">
							<tr>
								<td height="40" align="center">
								<select name="search">								
								<?
								$result1 =QRY_LIST("code_group_detail","all","1"," and grp_code='NA' and code_depth='1' "," dtl_code ASC");
								while($row1 = mysql_fetch_array($result1)){
									$dtl_code= replace_out($row1["dtl_code"]);
									$code_desc= replace_out($row1["code_desc"]);
								?>
								<option value="<?=$dtl_code?>"  <?If ($dtl_code==$search) {?> selected <? } ?>><?=$code_desc?></option>
								<?
								}
								?>
								</select>
								<!--<input type='text' name="strsearch" size='30' maxlength ='20' value="<?=$strsearch?>" onKeyPress="check_key(check_search);" style="font-size:9pt;height:21px;">	-->
								<span class="btn1"><a href="javascript:check_search();">SEARCH</a></span>
								</td>
							</tr>
						</table>
						</form>
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
				</table>
				</td>
			</tr>
		</table>
		</td>
	</tr>
</table>
<?
include $_SERVER["DOCUMENT_ROOT"]."/admin/include/footer.php";
?>
