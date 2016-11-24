<?
$mode = $_REQUEST['mode'];
$page = $_REQUEST['page'];

$search = $_REQUEST['search'];
$strsearch = $_REQUEST['strsearch'];


include $_SERVER["DOCUMENT_ROOT"]."/admin/include/header.php";
if ($strsearch){
	$searchand = " and $search like '%$strsearch%'";
}

if ($mode=="AA003"){
	$searchand = $searchand." and (gubun='board' or gubun='board_comment')";

	$cnt = QRY_REPORT_CNT($searchand);
	$totalpage = QRY_TOTALPAGE($cnt,$recordcnt);
	$result =QRY_REPORT_LIST($recordcnt,$searchand,$page);
}else {
	$searchand = $searchand." and bd_gubun='$mode'";	

	$cnt = QRY_CNT("board",$searchand);
	$totalpage = QRY_TOTALPAGE($cnt,$recordcnt);
	$resultno =QRY_BOARD_LISTNO(10,$searchand);
	$result =QRY_BOARD_LIST($recordcnt,$searchand,$page);
}
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
								<td width="120" align="center" class="btitle01">제품사진</td>
								<td width="80" align="center" class="btitle01">제품코드</td>
								<td align="center" class="btitle01">제품 소제목</td>
								<td width="100" align="center" class="btitle01">가격</td>
								<?if ($mode!="BB006"){?>
									<td width="100" align="center" class="btitle01">설치위치</td>
									<td width="100" align="center" class="btitle01">지붕타입</td>
								<?}?>
								<td width="100" align="center" class="btitle01">날짜</td>
								<td width="50" align="center" class="btitle01">조회수</td>
								
							</tr>
						</table>
						<!--공지사항 시작-->
						<?
						while($rowno = mysql_fetch_array($resultno)){
							$idx = replace_out($rowno["bd_idx"]);
							$title = replace_out($rowno["bd_title"]);
							$title_sub = replace_out($rowno["bd_title_sub"]);
							$mem_level = replace_out($row["bd_mem_level"]);
							$hit = replace_out($rowno["bd_hit"]);
							$log_date = substr(replace_out($rowno["reg_date"]),0,10);
							$recom = replace_out($rowno["bd_recom"]);
							$norecom = replace_out($rowno["bd_norecom"]);
							$report = replace_out($rowno["bd_report"]);
							
						?>
						<a href="board_view.php?<?=$param?>&idx=<?=$idx?>" id="go_<?=$idx?>"></a>
						<table width="99%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="60">&nbsp;</td>
								<td width="60" height="27" align="center">[공지]</td>	
								<td align="center"><a href="#" onclick="gogo('<?=$idx?>')"><?=$title?><?=get_comment($comment_num)?></a></td>
								<td width="150" align="center"><?=$name?></td>
								<td width="80" align="center"><?=$log_date?></td>
								<td width="50" align="center"><?=$hit?></td>
								<td width="50" align="center"><?=$report?></td>
								<td width="50" align="center"><?=$recom?></td>
								<td width="50" align="center"><?=$norecom?></td>
							</tr>
							<tr>
								<td height="1" colspan="10" bgcolor="#dcd8d6"></td>
							</tr>
						</table>
						<? } ?>
						<!--공지글 끝-->

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
							$idx = replace_out($row["bd_idx"]);
							$title = replace_out($row["bd_title"]);
							$title_sub = replace_out($row["bd_title_sub"]);
							$mem_level = replace_out($row["bd_mem_level"]);
							$cate = replace_out($row["bd_cate"]);
							$hit = replace_out($row["bd_hit"]);
							$log_date = substr(replace_out($row["reg_date"]),0,10);
							$file0 = replace_out($row["bd_file0"]);
							$site = replace_out($row["bd_site"]);
							$tel = replace_out($row["bd_tel"]);
							$bd_day = replace_out($row["bd_day"]);
							$pwd = replace_out($row["bd_pwd"]);
							$bd_sort = replace_out($row["bd_sort"]);
							$recom = replace_out($row["bd_recom"]);
							$norecom = replace_out($row["bd_norecom"]);
							$report = replace_out($row["bd_report"]);
							
							if ($mode=="AA003" and $site<>"") $title = $title." ($site)";
							if ($mode=="AA007") $log_date = $bd_day;

						?>
						<a href="board_view.php?<?=$param?>&idx=<?=$idx?>" id="go_<?=$idx?>"></a>

					
						<table width="99%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="60" height="27" align="center"><input type="checkbox" name="delchk[]" value="<?=$idx?>"></td>
								<td width="60" align="center"><?=$ListNO?></td>	
								<td width="120" align="center" height="110"><img src="<?=$file_path?><?=$file0?>" border="0" width="100" height="100"></td>
								<td width="80"  align="center"><a href="#" onclick="gogo('<?=$idx?>')"><?=$title?></a></td>
								<td align="center"><a href="#" onclick="gogo('<?=$idx?>')"><?=$title_sub?></a></td>
								<td width="100" align="center"><?=number_format($mem_level)?>원</td>
								<?if ($mode!="BB006"){?>
								<td width="100" align="center"><?=GF_Common_GetSingleList("LOC",$cate);?></td>
								<td width="100" align="center"><?=GF_Common_GetSingleList("ROOF",$pwd);?></td>
								<?}?>
								<td width="100" align="center"><?=$log_date?></td>
								<td width="50" align="center"><?=$hit?></td>
							</tr>
							<tr>
								<td height="1" colspan="10" bgcolor="#dcd8d6"></td>
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
								$pageurl = "board_list.php";

								include $_SERVER["DOCUMENT_ROOT"]."/admin/include/paging_admin.php";

								?>
								</td>
								<td width="120" align="right"><span class="btn1"><a href="board_write.php?mode=<?=$mode?>&page=<?=$page?>">등록</a></span>
								<span class="btn1"><a href="javascript:del();">삭제</a></span>&nbsp; <!-- <?=$mode?><?=$page?><?=$cnt?> -->
								</td>
							</tr>
						</table>
						<br />
						<form name="searchfrm" method="post" action="board_list.php">
						<input type="hidden" name="mode" value="<?=$mode?>">
						<table width="99%" border="0" cellspacing="0" cellpadding="0" bgcolor="#f0f0f0">
							<tr>
								<td height="40" align="center">
								<select name="search">								
								<option value="bd_title" <?If ($search=="bd_title") {?> selected <? } ?>>제목</option>
								<option value="bd_content" <?If ($search=="bd_content") {?> selected <? } ?>>내용</option>
								
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
			document.f.action = "board_proc.php?<?=$param?>";
			document.f.encoding = "multipart/form-data";
			document.f.submit();			
		}
	}
//-->
</script>
