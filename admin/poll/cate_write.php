<?
$mode = $_REQUEST['mode'];
$idx = $_REQUEST['idx'];
$page = $_REQUEST['page'];

$search = $_REQUEST['search'];
$strsearch = $_REQUEST['strsearch'];

include $_SERVER["DOCUMENT_ROOT"]."/admin/include/header.php";

$searchand = " and gubun='$mode'";
if ($strsearch){
	$searchand .= " and $search like '%$strsearch%'";
}
 
if ($idx){
	$result = QRY_CATE_VIEW($idx);
	$row = mysql_fetch_array($result);
	$idx = replace_out($row["idx"]);	
	$title = replace_out($row["title"]);
	$display = replace_out($row["display"]);
	$sort = replace_out($row["sort"]);
	$typ = "edit";
}else{           
	$typ = "write";
	$sort = get_max_idx_plus("board_cate","sort");
}

?>
<script type="text/javascript">
<!--
	function check(){
		var f =  document.f;

		if (trim(f.title.value)==""){
			alert("카테고리명을 입력해주세요.");
			f.title.focus();
			return;
		}
		
		f.encoding = "multipart/form-data";
		f.action = "cate_proc.php?<?=$param?>"
		f.submit();
	}
	

	function del(){
		if (confirm("삭제하시겠습니까?")==true){
			document.f.typ.value = "del";
			document.f.action = "cate_proc.php?<?=$param?>";
			document.f.encoding = "multipart/form-data";
			document.f.submit();
			
		}
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
		<td width="208" valign="top">
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
						<form name="f" method="post">
						<input type="hidden" name="mode" value="<?=$mode?>">
						<input type="hidden" name="typ" value="<?=$typ?>">
						<input type="hidden" name="idx" value="<?=$idx?>">
						<table width="99%" border="0" cellspacing="1" cellpadding="5" bgcolor="#e6e6e6">
							<tr>
								<td width="150" align="center" bgcolor="#f6f6f6" class="btitle02">카테고리명</td>
								<td bgcolor="#FFFFFF"><input name="title" type="text" maxlength="30" value="<?=$title?>" class="inputtext"></td>
							</tr>
							<tr>
								<td width="150" align="center" bgcolor="#f6f6f6" class="btitle02">노출여부</td>
								<td bgcolor="#FFFFFF"><input type="radio" name="display" value="Y" <?if ($display=="Y" or $display==""){?>checked<?}?>>노출함 
								<input type="radio" name="display" value="N" <?if ($display=="N"){?>checked<?}?>>노출안함
								</td>
							</tr>
							<tr>
								<td width="150" align="center" bgcolor="#f6f6f6" class="btitle02">노출순서</td>
								<td bgcolor="#FFFFFF"><input name="sort" type="text" maxlength="100" value="<?=$sort?>" class="inputtext" onfocus="isNum(this)" onkeydown="isNum(this)" onkeypress="isNum(this)" onkeyup="isNum(this)" style="width:50px;">(숫자만입력가능,내림차순정렬입니다)</td>
							</tr>
						</form>
						</table>
						
						<br />
						<table width="99%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td height="40" align="center" class="rtitle01">
								<span class="btn1"><a href="javascript:check();">확인</a></span>
								<?If( $mode=="ZZ012"){?>
								<?If( $typ=="edit"){?><span class="btn1"><a href="javascript:del();">삭제</a></span><?}?><?}?>
								<span class="btn1"><a href="cate_list.php?<?=$param?>">목록</a></span>
								
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
