<?
include $_SERVER["DOCUMENT_ROOT"]."/admin/include/header.php";

$result = QRY_BOARD_VIEW2($mode);
$row = mysql_fetch_array($result);

if($row){
	$idx = replace_out($row["bd_idx"]);	
	$content = replace_out($row["bd_content"]);
	$typ = "edit";
}else{           
	$typ = "write";
	$name = $_SESSION["ADMIN_NAME"];
}
?>
<script type="text/javascript" src="/admin/SE_/js/HuskyEZCreator.js" charset="utf-8"></script>
<script type="text/javascript">
<!--
	function check(){
		var f =  document.f;

		f.encoding = "multipart/form-data";
		f.action = "/admin/board/board_proc.php?<?=$param?>"
		f.submit();
	}
	
//-->
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td height="30" background="/admin/img/now_bg.gif" style="padding-left: 20px" class="now"><img src="/admin/img/icon.gif" width="9" height="7" /> HOME &gt; 사이트관리  </td>
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
						
						
						<form name="f" method="post">						
						<input type="hidden" name="typ" value="<?=$typ?>">
						<input type="hidden" name="mode" value="<?=$mode?>">
						<input type="hidden" name="idx" value="<?=$idx?>">
						<input type="hidden" name="title" value="<?=$title_text?>">
						<input type="hidden" name="list_url" value="/admin/agency/idblock.php">
						<table width="99%" border="0" cellspacing="1" cellpadding="5" bgcolor="#e6e6e6">							
							
							<tr>
								<td align="center" bgcolor="#f6f6f6" class="btitle02">가입차단 ID</td>
								<td bgcolor="#FFFFFF">								
								<textarea id="content" name="content" rows="10" cols="100" style="width:80%;"><?=$content?></textarea>
								<br>
								, (쉼표)로 구분합니다. 예) Admin, webmaster, master
								</td>
							</tr>
						</form>
						</table>
						
						<br />
						<table width="99%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td height="40" align="center" class="rtitle01">
								<span class="btn1"><a href="javascript:check();">확인</a></span>								
					
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
