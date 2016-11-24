<?
include $_SERVER["DOCUMENT_ROOT"]."/admin/include/header.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.member.php";

$searchand=" and admin_gubun='member'";

$cnt = QRY_CNT("admin",$searchand);
$totalpage = QRY_TOTALPAGE($cnt,$recordcnt);
$result =QRY_LIST(" admin ",$recordcnt,$page,$searchand," admin_idx DESC");
?>
<script type="text/javascript" src="/include/calendar.js"></script>

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
						<br />
						<table width="99%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td height="40" class="rtitle01"><img src="/admin/img/icon_02.gif" width="15" height="15" vspace="3" align="absmiddle" /> <?=$title_text?></td>
								<td width="100" height="35" class="rtitle01" align="center"><p class="tblue">검색건수 : &nbsp;<?=$cnt?>&#13;</p></td>
								<!--<td align="right" class="btitle02" width="100">								
								<a href="javascript:down_excel('excel')"><span class="btn">엑셀 파일</span></a>
								</td>-->
							</tr>
						</table>
						
						<!--오른쪽 시작-->
						<table width="99%" border="0" cellspacing="0" cellpadding="0"  background="/admin/img/boardbar_bg.gif">
							<tr>
								<!--<td width="60" height="27" align="center" class="btitle01" ><input type="checkbox" name="alldelchk" onclick="alldel_chk(this.checked);" ></td>	-->
								<td width="60"  height="27" align="center" class="btitle01" >번호</td>
								<td align="center" class="btitle01">아이디</td>
								<td width="150"  align="center" class="btitle01">이름</td>
								<td width="150"  align="center" class="btitle01">직책</td>
								<td width="150"  align="center" class="btitle01">연락처</td>
								<td width="150"  align="center" class="btitle01">이메일</td>
								<td width="200"  align="center" class="btitle01">가입일</td>
								<td width="100"  align="center" class="btitle01">사용여부</td>
							</tr>
						</table>
						
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
							$idx = replace_out($row["admin_idx"]);
							$admin_gubun = replace_out($row["admin_gubun"]);	
							$admin_id = replace_out($row["admin_id"]);	
							$admin_name = replace_out($row["admin_name"]);	
							$admin_name_e = replace_out($row["admin_name_e"]);	
							$admin_pwd = replace_out($row["admin_pwd"]);	
							$admin_pos = replace_out($row["admin_pos"]);	
							$admin_pos_e = replace_out($row["admin_pos_e"]);	
							$admin_tel = replace_out($row["admin_tel"]);	
							$admin_mail = replace_out($row["admin_mail"]);	
							$admin_etc1 = replace_out($row["admin_etc1"]);	
							$reg_date = replace_out($row["reg_date"]);
						?>
						<table width="99%" border="0" cellspacing="0" cellpadding="0">
							<a href="admin_write.php?<?=$param?>&idx=<?=$idx?>" id="go_<?=$idx?>"></a>
							<tr>
								<!--<td width="60"  height="27" align="center"><input type="checkbox" name="delchk[]" value="<?=$idx?>"></td>-->
								<td width="60" height="27" align="center"><?=$ListNO?></td>
								<td align="center" ><a href="#" onclick="gogo('<?=$idx?>')"><?=$admin_id?></a></td>
								<td width="150" align="center"><?=$admin_name?>/<?=$admin_name_e?></td>
								<td width="150" align="center"><?=$admin_pos?>/<?=$admin_pos_e?></td>
								<td width="150" align="center"><?=$admin_tel?></td>								
								<td width="150" align="center" ><?=$admin_mail?></td>
								<td width="200" align="center"><?=$reg_date?></td>
								<td width="100" align="center" ><?=$admin_etc1?></td>
							</tr>
							<tr>
								<td height="1" colspan="10" bgcolor="#dcd8d6"></td>
							</tr>
						</table>
						<? 
							$ListNO--;
						} 
						?>
						<br>
						<table width="99%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<Td width=120>&nbsp;</td>
								<td height="40" align="center">
								<?
								$addpara = $param;

								include $_SERVER["DOCUMENT_ROOT"]."/admin/include/paging_admin.php";

								?>
								</td>
								<td width="120" align="right">
								<span class="btn1"><a href="admin_write.php?<?=$param?>">등록</a></span>
								<!--<span class="btn1"><a href="javascript:del();">삭제</a></span>&nbsp; -->
								</td>
							</tr>
						</table>
						<br />
						
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
<script type="text/javascript">
<!--
	function del(){
		
		if (confirm("삭제하시겠습니까?")==true){
			document.f.typ.value = "alldel";
			document.f.action = "member_proc.php?<?=$param?>";
			document.f.encoding = "multipart/form-data";
			document.f.submit();			
		}
	}
//-->
</script>
