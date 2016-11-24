<script type="text/javascript">
<!--
	jQuery(function ($) {		
		$('.reply_write_btn').click(function(event){		
			var f= document.comm2f;
			var idx = $(this).attr('idx');			
			var lev = $(this).attr('lev');

			$("#reply_"+idx).append( $("#reply_write") ); 
			if (f.ref.value==idx){
				$("#reply_write").toggle();
			}else{
				$("#reply_write").show();
			}
			f.ref.value=idx;
			f.lev.value=lev;
		});
	});	

	function check(frm){
		var f= eval("document."+frm);
		if (nullchk(f.comment_title,"제목을 입력하세요.")== false) return ;
		if (nullchk(f.comment_name,"작성자를 입력하세요.")== false) return ;		
		if (nullchk(f.comment_comment,"내용을 입력하세요.")== false) return ;

		f.encoding = "multipart/form-data";
		f.action = "board_proc.php"
		f.submit();
	}
	
	
	function del_comm(id){
		if (confirm("댓글을 삭제하시겠습니까?")==true){
			document.commf.comm_idx.value = id;
			document.commf.typ.value = "comm_del";
			document.commf.action = "board_proc.php?<?=$param?>";
			document.commf.encoding = "multipart/form-data";
			document.commf.submit();
			
		}
	}
	
	function edit_view(id){
		document.getElementById("view_"+id).style.display = "none"
		document.getElementById("edit_"+id).style.display = ""
	}
//-->
</script>
<!--댓글관리-->
<table width="99%" border="0" cellspacing="1" cellpadding="5" bgcolor="#e6e6e6">
	<tr>
		<td width="150" align="center" bgcolor="#f6f6f6" class="btitle02">댓글관리</td>
		<td bgcolor="#FFFFFF">
		<form name="commf" method="post">
		<input type="hidden" name="typ" value="comm_write">
		<input type="hidden" name="send_idx" value="<?=$mem_idx?>">
		<input type="hidden" name="mode" value="<?=$mode?>">
		<input type="hidden" name="ref" value="<?=$idx?>">
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
				<td bgcolor="#FFFFFF"><textarea name="comment_comment" style="width:98%;height:100px;display:"></textarea>
			</tr>
		</table>
		<table width="99%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td>&nbsp;</td>
				<td width="100" height="40" align="center" class="rtitle01"><span class="btn1"><a href="javascript:check('commf');">등록</a></span>	</td>
			</tr>
		</table>
		</form>
		<table width="99%" border="0" cellspacing="0" cellpadding="0" >
				<tr>
					<td height="1" bgcolor="#e6e6e6"></td>
				</tr>
			
			</table>
<!--댓글리스트 시작-->
<?
$result_reply =QRY_LIST("board","all",$page," and bd_ref='$idx' and bd_lev!=0", " bd_lev , reg_date ");	
while($row_reply = mysql_fetch_array($result_reply)){
	$comm_idx = replace_out($row_reply["bd_idx"]);
	$name = replace_out($row_reply["bd_mem_name"]);
	$title = replace_out($row_reply["bd_title"]);
	$comment = replace_out($row_reply["bd_content"]);
	$log_date = replace_out($row_reply["reg_date"]);
	$file1 = replace_out($row_reply["bd_file1"]);
	$file2 = replace_out($row_reply["bd_file2"]);
	$lev = replace_out($row_reply["bd_lev"]);
	$step = replace_out($row_reply["bd_step"]);
?>
			<form name="editf<?=$comm_idx?>" method="post">
			<input type="hidden" name="typ" value="comm_edit">
			<input type="hidden" name="send_idx" value="<?=$mem_idx?>">
			<input type="hidden" name="mode" value="<?=$mode?>">
			<input type="hidden" name="ref" value="<?=$idx?>">
			<input type="hidden" name="ref2" value="<?=$comm_idx?>">
			<input type="hidden" name="comm_idx" value="<?=$comm_idx?>">
			<table width="99%" border="0" cellspacing="0" cellpadding="0" >
			<tr>
				<td ><strong><?if($step>1){?>&nbsp;<img src="/admin/img/ico_reply.gif">&nbsp;<?}?><?=$name?> [<?=$log_date?>]</strong></td>				
				<td align="right">
				<a href="javascript:win_open('comment.php?mode=<?=$mode?>&ref=<?=$idx?>&ref2=<?=$comm_idx?>&lev=<?=$lev?>&step=<?=$step?>&mem_idx=<?=$mem_idx?>', 'comment', '600', '408', '', '', scroll, '1')"><?=$comm_idx?>댓글달기</a>
				| <a href="javascript:del_comm('<?=$comm_idx?>')">삭제</a>
				</td>
			</tr>
			<tr>
				<td  height="30" colspan="2"><?=$title?></td>
			</tr>
			<tr>
				<td colspan="2">
				
				<?=$comment?><br>
				<?if($file1){?><a href="/include/filedownload.php?filename=<?=$file1?>&path=<?=$file_path?>"    target="_net" ><?=$file1?></a><br><?}?>
				<?if($file2){?><a href="/include/filedownload.php?filename=<?=$file2?>&path=<?=$file_path?>"    target="_net" ><?=$file2?></a><br><?}?>
				<br>
				</td>
			</tr>
			</table>
			<table width="80%" border="0" cellspacing="0" cellpadding="0"  id="edit_<?=$comm_idx?>" style="display:none; ">
				<tr >
					<td colspan="2"><textarea name="comment" cols="130" rows="3"><?=$comment?></textarea><br><br>
					</td>
				</tr>
				<tr>
					<td height="30" align="right"  colspan="2"><span class="btn1"><a href="javascript:check('editf<?=$comm_idx?>');">등록</a></span></td>
				</tr>
			</table>
			<div id="reply_<?=$comm_idx?>"></div>
			<table width="99%" border="0" cellspacing="0" cellpadding="0" >
				<tr>
					<td height="1" bgcolor="#e6e6e6"></td>
				</tr>
			
			</table>
			</form>
<? 
	$ListNO--;
} ?>	
			
		</td>
	</tr>						

</table>
<br />
<br>
<!--댓글관리-->
<div id="reply_write" style="display:none">
<form name="comm2f" method="post">
<input type="hidden" name="typ" value="comm_write">
<input type="hidden" name="mode" value="<?=$mode?>">
<input type="hidden" name="cate" value="<?=$cate?>">
<input type="hidden" name="gubun_idx" value="<?=$idx?>">
<input type="hidden" name="ref" value="">
<input type="hidden" name="lev" value="">
<input type="hidden" name="step" value="1">
<table width="620" border="0" cellspacing="0" cellpadding="0" >
	<tr>
		<td height="1" bgcolor="#e6e6e6"></td>
	</tr>
	<tr>
		<td height="25"><input type="text" name="comment_name" value="운영자"></td>
	</tr>
	<tr>
		<td><textarea name="comment" cols="130" rows="3"></textarea></td>
	</tr>
	<tr>
		<td height="30" align="right"><span class="btn1"><a href="javascript:check('comm2f');">등록</a></span></td>
	</tr>
	<tr>
		<td height="1" bgcolor="#e6e6e6"></td>
	</tr>
</table>
</form>
</div>

