<?
$mode = $_REQUEST['mode'];
$page = $_REQUEST['page'];
$search = $_REQUEST['search'];
$strsearch = $_REQUEST['strsearch'];

include $_SERVER["DOCUMENT_ROOT"]."/admin/include/header.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.member.php";

if ($strsearch){
	$searchand .= " and $search like '%$strsearch%'";
}

$cnt = QRY_CNT("member",$searchand);
$totalpage = QRY_TOTALPAGE($cnt,$recordcnt);
$result =QRY_MEMBER_LIST($recordcnt,$searchand,$page);
?>

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
						<input type="hidden" name="typ" value="<?=$typ?>">
						<input type="hidden" name="typaaa" value="한글">
						<table width="99%" border="0" cellspacing="0" cellpadding="0" background="/admin/img/boardbar_bg.gif">
							<tr>
								<td width="60" height="27" align="center" class="btitle01" ><input type="checkbox" name="alldelchk" onclick="alldel_chk(this.checked);" ></td>	
								<td width="60" height="27" align="center" class="btitle01" >번호</td>		
								<td align="center" class="btitle01">이름</td>
								<td width="220" align="center" class="btitle01">아이디</td>
								<td width="150" align="center" class="btitle01">날짜</td>
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
							$idx = replace_out($row["mem_idx"]);
							$mem_name = replace_out($row["mem_name"]);
							$mem_sex = replace_out($row["mem_sex"]);
							$mem_id = replace_out($row["mem_id"]);
							$reg_date = substr(replace_out($row["reg_date"]),0,10);
						?>
						<a href="member_write.php?<?=$param?>&idx=<?=$idx?>" id="go_<?=$idx?>"></a>
						<table width="99%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="60" height="27" align="center"><input type="checkbox" name="delchk[]" value="<?=$idx?>"></td>
								<td width="60" align="center"><?=$ListNO?></td>									
								<td align="center"><a href="#" onclick="gogo('<?=$idx?>')"><?=$mem_name?></a></td>
								<td width="220" align="center"><?=$mem_id?></td>
								<td width="150" align="center"><?=$reg_date?></td>
							</tr>
							<tr>
								<td height="1" colspan="9" bgcolor="#dcd8d6"></td>
							</tr>
						</table>
						<? 
							$ListNO--;
						} 
						?>
						</form>
						<br>
						<table width="99%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<Td width=120>&nbsp;</td>
								<td height="40" align="center">
								<?
								$addpara = "";
								$pageurl = "member_list.php";

								include $_SERVER["DOCUMENT_ROOT"]."/admin/include/paging_admin.php";

								?>
								</td>
								<td width="120" align="right"><span class="btn1"><a href="member_write.php?mode=<?=$mode?>&page=<?=$page?>">등록</a></span>
								<span class="btn1"><a href="javascript:del();">삭제</a></span>&nbsp; <!-- <?=$mode?><?=$page?><?=$cnt?> -->
								</td>
							</tr>
						</table>
						<br />
						<form name="searchfrm" method="post" action="member_list.php">
						<input type="hidden" name="mode" value="<?=$mode?>">
						<table width="99%" border="0" cellspacing="0" cellpadding="0" bgcolor="#f0f0f0">
							<tr>
								<td height="40" align="center">
								<select name="search">								
								<option value="mem_name" <?If ($search=="mem_name") {?> selected <? } ?>>이름</option>
								<option value="mem_id" <?If ($search=="mem_id") {?> selected <? } ?>>아이디</option>
								
								</select>
								<input type='text' name="strsearch" size='30' maxlength ='20' value="<?=$strsearch?>" onKeyPress="check_key(check_search);" style="font-size:9pt;height:21px;">	
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
