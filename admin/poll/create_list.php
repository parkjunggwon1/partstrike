<?
$mode = $_REQUEST['mode'];
$page = $_REQUEST['page'];

$search = $_REQUEST['search'];
$strsearch = $_REQUEST['strsearch'];


include $_SERVER["DOCUMENT_ROOT"]."/admin/include/header.php";


if ($strsearch){
	$searchand .= " and $search like '%$strsearch%'";
}
$recordcnt = "100";

$cnt = QRY_CNT("board_create",$searchand);
$totalpage = QRY_TOTALPAGE($cnt,$recordcnt);
$result =QRY_CREATE_LIST($recordcnt,$searchand,$page);

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
						<input type="hidden" name="idx" value="">
						<input type="hidden" name="flag" value="">
						<input type="hidden" name="values" value="">
						
						<table width="99%" border="0" cellspacing="0" cellpadding="0" background="/admin/img/boardbar_bg.gif">
							<tr>
								<td width="60" height="27" align="center" class="btitle01" >번호</td>	
								<td width="150" align="center" class="btitle01">카테고리</td>
								<td width="100" align="center" class="btitle01">구분코드</td>
								<td align="center" class="btitle01">게시판명</td>
								<td width="150" align="center" class="btitle01">노출여부</td>
								<td width="100" align="center" class="btitle01">리스트타입</td>
								<td width="100" align="center" class="btitle01">순서</td>
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
							$cate = replace_out($row["cate"]);
							$gubun = replace_out($row["gubun"]);
							$title = replace_out($row["title"]);
							$display = replace_out($row["display"]);
							$list_type = replace_out($row["list_type"]);
							$sort = replace_out($row["sort"]);

							$catetitle = QRY_CATE($cate);
							if ($catehtml1!=$catetitle){
								$catehtml1 = $catetitle;
								$catehtml2 = $catetitle;
							}else{
								$catehtml2 = "";
							}
						?>
						<a href="create_write.php?<?=$param?>&idx=<?=$idx?>" id="go_<?=$idx?>"></a>
						<table width="99%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="60" height="30" align="center"><?=$ListNO?></td>	
								<td width="150"  align="center"><?=$catehtml2?></td>
								<td width="100"  align="center"><?=$gubun?></td>
								<td align="center"><a href="#" onclick="gogo('<?=$idx?>')"><?=$title?></a></td>
								<td width="150" align="center">
								<select name="display_flag" onchange="flag_chg(this,'<?=$idx?>','display');">
									<option value="Y" <?If ($display=="Y") {?>selected<?}?>>Y</option>
									<option value="N" <?If ($display=="N") {?>selected<?}?>>N</option>
								</select>
								</td>
								<td width="100" align="center">
								<select name="list_flag" onchange="flag_chg(this,'<?=$idx?>','list_type');">
									<option value="list" <?If ($list_type=="list") {?>selected<?}?>>리스트</option>
									<option value="gallery" <?If ($list_type=="gallery") {?>selected<?}?>>갤러리</option>							
								</select>
								</td>
								<td width="100" align="center">
								<select name="sort_flag" onchange="flag_chg(this,'<?=$idx?>','sort');">
									<option value="" <?If($sort){?>selected<?}?>>::선택::</option>
									<?For($i=1;$i<=$cnt;$i++){?>
									<option value="<?=$i?>" <?If ($sort==$i) {?>selected<?}?>><?=$i?></option>
									<?}?>									
								</select>
								</td>
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
								$pageurl = "create_list.php";

								include $_SERVER["DOCUMENT_ROOT"]."/admin/include/paging_admin.php";

								?>
								</td>
								<td width="120" align="right"><span class="btn1"><a href="create_write.php?mode=<?=$mode?>&page=<?=$page?>">등록</a></span>
								</td>
							</tr>
						</table>
						<br />
						<form name="searchfrm" method="post" action="create_list.php">
						<input type="hidden" name="mode" value="<?=$mode?>">
						<table width="99%" border="0" cellspacing="0" cellpadding="0" bgcolor="#f0f0f0">
							<tr>
								<td height="40" align="center">
								<select name="search">								
								<option value="title" <?If ($search=="title") {?> selected <? } ?>>카테고리명</option>
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
<iframe name="proc" id="proc" src="" width="0" height="0" frameborder="0" title="프로시져 프레임"></iframe>

<?
include $_SERVER["DOCUMENT_ROOT"]."/admin/include/footer.php";
?>
<script type="text/javascript">
<!--
	function del(){
		if (confirm("삭제하시겠습니까?")==true){
			document.f.typ.value = "alldel";
			document.f.action = "create_proc.php?<?=$param?>";
			document.f.encoding = "multipart/form-data";
			document.f.submit();			
		}
	}

	function flag_chg(obj, idx, act){
		var val	= obj.value;
		
		document.f.values.value = val;
		document.f.idx.value = idx;
		document.f.flag.value = act;
		document.f.typ.value = "that";
		document.f.target = "proc"
		document.f.action = "create_proc.php";
		document.f.encoding = "multipart/form-data";
		document.f.submit();	
	}

	
//-->
</script>
