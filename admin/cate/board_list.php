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
	if ($mode =="BB009" || $mode =="BB010"){
		$result =QRY_BOARD_LIST_ORDER($recordcnt,$searchand,$page);
	}else{
		$result =QRY_BOARD_LIST($recordcnt,$searchand,$page);
	}
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
								<td width="200" align="center" class="btitle01">상호</td>
								<td align="center" class="btitle01">주소</td>
								<td width="150" align="center" class="btitle01">전화번호</td>
								<?if ($mode=="BB009" || $mode =="BB010") {?>
									<td width="100" align="center" class="btitle01">등록일자</td>
									<td width="50" align="center" class="btitle01">순서</td>
								<?}?>
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
							$idx = replace_out($row["bd_idx"]);
							$title = replace_out($row["bd_title"]);
							$title_sub = replace_out($row["bd_title_sub"]);
							$name = replace_out($row["bd_mem_name"]);
							$company = replace_out($row["bd_company"]);
							$bd_address = replace_out($row["bd_address"]);
							$bd_tel = replace_out($row["bd_tel"]);
							$comment_num = replace_out($row["bd_comment_num"]);
							$hit = replace_out($row["bd_hit"]);
							$log_date = substr(replace_out($row["reg_date"]),0,10);
							$file0 = replace_out($row["bd_file0"]);
							$site = replace_out($row["bd_site"]);
							$tel = replace_out($row["bd_tel"]);
							$bd_day = replace_out($row["bd_day"]);
							$bd_sort = replace_out($row["bd_sort"]);
							$recom = replace_out($row["bd_recom"]);
							$norecom = replace_out($row["bd_norecom"]);
							$report = replace_out($row["bd_report"]);
							if ($bd_sort == 0) {
								$bd_sort = "";
							}
							
							if ($mode=="AA003" and $site<>"") $title = $title." ($site)";
							if ($mode=="AA007") $log_date = $bd_day;

						?>
						<a href="board_write.php?<?=$param?>&idx=<?=$idx?>" id="go_<?=$idx?>"></a>
						<table width="99%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="60" height="27" align="center"><input type="checkbox" name="delchk[]" value="<?=$idx?>"></td>
								<td width="60" align="center"><?=$ListNO?></td>									
								<td width="200" align="center"><a href="#" onclick="gogo('<?=$idx?>')">
								<?=$company?></a></td>
								<td  align="center"><?=$bd_address?></td>
								<td width="150" align="center"><?=$bd_tel?></td>
								<?if ($mode=="BB009" || $mode =="BB010") {?>
								<td width="100" align="center"><?=$log_date?></td>
									<td width="50" align="center"><input type="text" name="sortorder_<?=$idx?>" value="<?=$bd_sort?>" maxlength="3" style="width:25px"></td>
								<?}?>
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
								$pageurl = "board_list.php";

								include $_SERVER["DOCUMENT_ROOT"]."/admin/include/paging_admin.php";

								?>
								</td>
								<td width="250" align="right"><span class="btn1"><a href="board_write.php?mode=<?=$mode?>&page=<?=$page?>">등록</a></span>
								<span class="btn1"><a href="javascript:del();">삭제</a></span>&nbsp; <!-- <?=$mode?><?=$page?><?=$cnt?> -->
								<?if ($mode=="BB009" || $mode =="BB010") {?>
								<span class="btn1"><a href="javascript:save();">순서저장</a></span>
								<?}?>
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
								<input type='text' name="strsearch" size='30' maxlength ='20' value="<?=$strsearch?>" onKeyPress="document.searchfrm.search.value=encodeURIComponent(document.searchfrm.search.value);check_key(check_search);" style="font-size:9pt;height:21px;">	
								<span class="btn1"><a href="javascript:document.searchfrm.search.value=encodeURIComponent(document.searchfrm.search.value);check_search();">SEARCH</a></span>
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

	function save(){
		var f = document.f;	
		var saveod=true;
		if ($("input[name^=delchk]:checked").length==0)
		{
			alert("순서를 저장할 항목을 선택해주세요.");
		}else{
			$("input[name^=delchk]:checked").each(function(key,delNode){
				if (saveod == true)
				{
					var $this = $(this).parent().parent().find("input[name^=sortorder]");
					if($this.val()=="")
					{
						$this.focus();
						alert("선택한 항목의 순서를 입력해주세요.");
						saveod = false;
						return;
					}
				}
				
			});
			if (saveod==true)
			{
				if (confirm("순서를 저장하시겠습니까?")==true){
					f.typ.value = "saveorder";
					f.action = "board_proc.php?<?=$param?>";
					f.encoding = "multipart/form-data";
					f.submit();			
				}
			}
			
		}
	}


//-->
</script>
