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

		if (trim(f.comment.value)==""){
			alert("글을 입력하세요");
			f.comment.focus();
			return;
		}
		
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
<?
$searchand = " and gubun='board' and gubun_idx='$idx'";
$cnt = QRY_CNT("board_comment",$searchand);
$result =QRY_COMM_LIST($recordcnt,$searchand,$page);
?>

<table width="99%" border="0" cellspacing="1" cellpadding="5" bgcolor="#e6e6e6">
	<tr>
		<td width="150" align="center" bgcolor="#f6f6f6" class="btitle02">댓글관리</td>
		<td bgcolor="#FFFFFF">
		<form name="commf" method="post">
		<input type="hidden" name="typ" value="comm_write">
		<input type="hidden" name="mode" value="<?=$mode?>">
		<input type="hidden" name="cate" value="<?=$cate?>">
		<input type="hidden" name="gubun_idx" value="<?=$idx?>">
		<input type="hidden" name="comm_idx" value="">
		<input type="hidden" name="ref" value="<?=$idx?>">
		<input type="hidden" name="lev" value="0">
		<input type="hidden" name="step" value="0">
		<table width="80%" border="0" cellspacing="0" cellpadding="0" >
			
			<tr>
				<td height="25"><input type="text" name="comment_name" value="운영자"></td>
			</tr>
			<tr>
				<td><textarea name="comment" cols="130" rows="6"></textarea></td>
			</tr>
			<tr>
				<td height="30" align="right"><span class="btn1"><a href="javascript:check('commf');">등록</a></span></td>
			</tr>
			<tr>
				<td height="1" bgcolor="#e6e6e6"></td>
			</tr>
		</table>
		</form>
		
			<!--일반게시글 시작-->			
			<?
			$ListNO=$cnt-(($page-1)*$recordcnt);

			while($row = mysql_fetch_array($result)){
				$comm_idx = replace_out($row["idx"]);
				$name = replace_out($row["mem_name"]);
				$mem_level = replace_out($row["mem_level"]);
				$lev = replace_out($row["lev"]);
				$step = replace_out($row["step"]);
				$comment = replace_out($row["comment"]);
				$log_date = replace_out($row["reg_date"]);
			?>
			<form name="editf<?=$comm_idx?>" method="post">
			<input type="hidden" name="typ" value="comm_edit">
			<input type="hidden" name="mode" value="<?=$mode?>">
			<input type="hidden" name="cate" value="<?=$cate?>">
			<input type="hidden" name="gubun_idx" value="<?=$idx?>">
			<input type="hidden" name="comm_idx" value="<?=$comm_idx?>">
			<table width="80%" border="0" cellspacing="0" cellpadding="0" >
			<tr>
				<td height="35"><strong><?if($step>1){?>&nbsp;<img src="/admin/img/ico_reply.gif">&nbsp;<?}?><?=$name?> [<?=$log_date?>]</strong></td>
				<td height="35" align="right">
				<a href="javascript:edit_view('<?=$comm_idx?>')">수정</a>|
				<a href="javascript:del_comm('<?=$comm_idx?>')">삭제</a>|
				<?if ($cv_comm>1){?><span class="reply_write_btn" idx="<?=$comm_idx?>" lev="<?=$lev?>">쪽글달기</span><?}?>
				</td>
			</tr>
			<tr id="view_<?=$comm_idx?>" >
				<td colspan="2"><?=$comment?><br><br>
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
			<table width="80%" border="0" cellspacing="0" cellpadding="0" >
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

