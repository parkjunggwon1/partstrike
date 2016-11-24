<?
include $_SERVER["DOCUMENT_ROOT"]."/admin/include/header_index.php";
?>
<script type="text/javascript">
<!--
	function check(frm){
		var f= eval("document."+frm);
		if (nullchk(f.comment_title,"제목을 입력하세요.")== false) return ;
		if (nullchk(f.comment_name,"작성자를 입력하세요.")== false) return ;		
		if (nullchk(f.comment_comment,"내용을 입력하세요.")== false) return ;

		f.encoding = "multipart/form-data";
		f.action = "board_proc.php"
		f.submit();
	}
//-->
</script>
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
				<td height="40" class="rtitle01"><img src="/admin/img/icon_02.gif" width="15" height="15" vspace="3" align="absmiddle" /> 댓글달기</td>
			</tr>
		</table>
		<form name="commf" method="post">
		<input type="hidden" name="typ" value="comm_write">
		<input type="hidden" name="typ2" value="popup">
		<input type="hidden" name="send_idx" value="<?=$mem_idx?>">
		<input type="hidden" name="mode" value="<?=$mode?>">
		<input type="hidden" name="ref" value="<?=$ref?>">
		<input type="hidden" name="ref2" value="<?=$ref2?>">
		<input type="hidden" name="lev" value="<?=$lev?>">
		<input type="hidden" name="step" value="<?=$step?>">
		<input type="hidden" name="comm_idx" value="">
		<table width="99%" border="0" cellspacing="1" cellpadding="5" bgcolor="#e6e6e6">		
			<tr>
				<td width="150" align="center" bgcolor="#f6f6f6" class="btitle02">제목</td>
				<td bgcolor="#FFFFFF"><input name="comment_title" type="text" maxlength="100" value="<?=$comment_title?>" class="inputtext"></td>
			</tr>
			<tr>
				<td  width="150" align="center" bgcolor="#f6f6f6" class="btitle02">작성자</td>
				<td bgcolor="#FFFFFF"><input name="comment_name" type="text" value="<?=$_SESSION["ADMIN_NAME"]?>"  class="inputtext"></td>
			</tr>													
			
			<?
			if($mode=="EE001"){
				$si=1;
				$ei=2;
			}														
			?>
			<?For ($i=$si;$i<=$ei;$i++){?>
				<tr>
					<td align="center" bgcolor="#f6f6f6" class="btitle02">첨부파일<?=$i?></td>
					<td bgcolor="#FFFFFF"><input name="file<?=$i?>" type="file" class="inputtext"></td>
				</tr>
			<? } ?>
			
			<tr>
				<td align="center" bgcolor="#f6f6f6" class="btitle02">내용</td>
				<td bgcolor="#FFFFFF"><textarea name="comment_comment" style="width:98%;height:150px;display:"></textarea>
			</tr>
		</table>
		<table width="99%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td height="40" align="center" class="rtitle01"><span class="btn1"><a href="javascript:check('commf');">등록</a></span>	</td>
			</tr>
		</table>
		</form>
		</td>
		<td background="/admin/img/t_08.gif"></td>
	</tr>
	<tr>
		<td><img src="/admin/img/t_03.gif" width="6" height="6" /></td>
		<td background="/admin/img/t_06.gif"></td>
		<td align="right"><img src="/admin/img/t_04.gif" width="6" height="6" /></td>
	</tr>
</table>