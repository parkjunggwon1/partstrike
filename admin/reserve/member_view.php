<?
include $_SERVER["DOCUMENT_ROOT"]."/admin/include/header.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.board.php";


$searchand = " and bd_gubun='$mode'";
if ($strsearch){
	$searchand .= " and $search like '%$strsearch%'";
}
if ($idx){
	$result = QRY_BOARD_VIEW($idx);

	$row = mysql_fetch_array($result);

	$idx = replace_out($row["bd_idx"]);	
	$title = replace_out($row["bd_title"]);
	$title_sub = replace_out($row["bd_title_sub"]);
	$name = replace_out($row["bd_mem_name"]);
	$email = replace_out($row["bd_email"]);			
	$content = ($row["bd_content"]);
	$notice = replace_out($row["bd_notice"]);
	$file1 = replace_out($row["bd_file1"]);
	$start_date = replace_out($row["bd_start_date"]);
	$end_date = replace_out($row["bd_end_date"]);
	$log_date = substr(replace_out($row["reg_date"]),0,10);
	$cate = replace_out($row["bd_cate"]);
	$site = replace_out($row["bd_site"]);
	$company = replace_out($row["bd_company"]);
	$tel = replace_out($row["bd_tel"]);
	$typ = "edit";
}else{
	$typ = "write";
}
?>
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
					<tr background="/admin/img/t_05.gif">
						<td width="6" valign="top"><img src="/admin/img/t_01.gif" width="6" height="6" /></td>
						<td background="/admin/img/t_05.gif"><img src="/admin/img/t_05.gif" width="6" height="6" /></td>
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
						<table width="99%" border="0" cellspacing="1" cellpadding="5" bgcolor="#e6e6e6">
						<form name="f" method="post">
						<input type="hidden" name="typ" value="<?=$typ?>">
						<input type="hidden" name="idx" value="<?=$idx?>">
						<input type="hidden" name="comm_idx" value="">
							
							<table width="99%" border="0" cellspacing="1" cellpadding="5" bgcolor="#e6e6e6">
							
							
							<?if ($mode=="AA005") {?>
							<tr>
								<td width="150" align="center" bgcolor="#f6f6f6" class="btitle02">성함/업체명</td>
								<td bgcolor="#FFFFFF"><?=$company?></td>
							</tr>	
							<tr>
								<td align="center" bgcolor="#f6f6f6" class="btitle02">성함</td>
								<td bgcolor="#FFFFFF"><?=$name?></td>
							</tr>	
							<tr>
								<td align="center" bgcolor="#f6f6f6" class="btitle02">전화번호</td>
								<td bgcolor="#FFFFFF"><?=$tel?></td>
							</tr>	
							<?}else if($mode=="AA004" or $mode=="AA006") {?>
							<tr>
								<td width="150" align="center" bgcolor="#f6f6f6" class="btitle02">성함/업체명</td>
								<td bgcolor="#FFFFFF"><?=$company?></td>
							</tr>								
							<tr>
								<td align="center" bgcolor="#f6f6f6" class="btitle02">전화번호</td>
								<td bgcolor="#FFFFFF"><?=$tel?></td>
							</tr>	
							<tr>
								<td align="center" bgcolor="#f6f6f6" class="btitle02">이메일</td>
								<td bgcolor="#FFFFFF"><?=$email?></td>
							</tr>
							<tr>
								<td align="center" bgcolor="#f6f6f6" class="btitle02">사이트명</td>
								<td bgcolor="#FFFFFF"><?=$site?></td>
							</tr>
							<?}else{?>
							<tr>
								<td align="center" bgcolor="#f6f6f6" class="btitle02">작성자</td>
								<td bgcolor="#FFFFFF"><?=$name?></td>
							</tr>	
							<tr>
								<td width="150" align="center" bgcolor="#f6f6f6" class="btitle02">제목</td>
								<td bgcolor="#FFFFFF"><?If(notice=="y"){?>[공지]<?}?><?=$title?>
								</td>
							</tr>
							<?}?>
							<?if($mode=="AA002"){?>
							<tr>
								<td width="150" align="center" bgcolor="#f6f6f6" class="btitle02">제목설명</td>
								<td bgcolor="#FFFFFF"><?=$title_sub?></td>
							</tr>
							<tr>
								<td width="150" align="center" bgcolor="#f6f6f6" class="btitle02">분류</td>
								<td bgcolor="#FFFFFF"><?=$cate?></td>
							</tr>
							<? } ?>	
							<?if($mode=="AA002" or $mode=="AA003"){?>
							<tr>
								<td width="150" align="center" bgcolor="#f6f6f6" class="btitle02">링크</td>
								<td bgcolor="#FFFFFF"><?=$site?></td>
							</tr>
							<? } ?>						
							<?							
							if($mode=="AA002"){
								$si=0;
								$ei=0;
							}else{
								$si=1;
								$ei=3;
							}						
							?>
							<?For ($i=$si;$i<=$ei;$i++){?>
								<?
								If($idx){
									If ($row["bd_file".$i]){									
								?>
								<tr>
									<td align="center" bgcolor="#f6f6f6" class="btitle02"><?If ($i==0){?>리스트이미지<?}else{?>첨부파일<?=$i?><? } ?></td>
									<td  bgcolor="#FFFFFF" valign="middle">	
									<img src="<?=$file_path?><?=$row["bd_file".$i]?>"><br>
									<a href="/include/filedownload.asp?filename=<?=$row["bd_file".$i]?>&path=<?=$file_path?>" target="_net"><?=$row["bd_file".$i]?></a>
									</td>
								</tr>
								<input type="hidden" name="file_o<?=$i?>" value="<?=$row["bd_file".$i]?>">
									<? } ?>
								<? } ?>
							<? } ?>
							
							<tr <?if($mode=="AA002"){?>style="display:none;"<?}?>>
								<td align="center" bgcolor="#f6f6f6" class="btitle02" height="200">내용</td>
								<td bgcolor="#FFFFFF"><?=$content?></td>
							</tr>
							
							<?If ($mode=="AA100") {?>
							<tr>
								<td align="center" bgcolor="#f6f6f6" class="btitle02">등록일</td>
								<td bgcolor="#FFFFFF"><?=$log_date?></td>
							</tr>
							<? } ?>
						</table>
						<br />
						<br>
						<!--댓글관리
						<table width="99%" border="0" cellspacing="1" cellpadding="5" bgcolor="#e6e6e6">
							<tr>
								<td width="150" align="center" bgcolor="#f6f6f6" class="btitle02">댓글관리</td>
								<td bgcolor="#FFFFFF">
								<table width="620" border="0" cellspacing="0" cellpadding="0" >
									<%
									sql = " select * from board_comment where bc_bd_idx = "&idx
									Set rs = DBConn.Execute(sql)

									If Not(rs.eof Or rs.bof) then
										Do Until rs.eof
											comm_idx = replace_out(rs("bc_idx"))
											comm_name = replace_out(rs("bc_mem_name"))
											comment = replace_FCK_out(rs("bc_content"))
											comm_date = replace_out(rs("REG_DATE"))
											comm_IP = replace_out(rs("REG_IP"))
									%>
									<tr>
										<td><strong><%=comm_name%> [작성일:<%=comm_date%>] [IP:<%=comm_IP%>]</strong><br>
										<%=comment%><br></td>
									</tr>
									<tr>
										<td height="25" align="right"><span class="btn1"><a href="javascript:del_comm('<%=comm_idx%>')">삭제</a></span></td>
									</tr>
									<tr>
										<td height="1" bgcolor="#e6e6e6"></td>
									</tr>
									
									<%
										rs.movenext
										Loop
									End if
									%>									
									<tr>
										<td height="25"><input type="text" name="comment_name" value="운영자"></td>
									</tr>
									<tr>
										<td><textarea name="comment" cols="100" rows="8"></textarea></td>
									</tr>
									<tr>
										<td height="25" align="right"><span class="btn1"><a href="javascript:check_comm()">등록</a></span></td>
									</tr>
								</table>
								</td>
							</tr>						
						</form>
						</table>
						<br />
						<br>
						<!--댓글관리-->
						<span class="btn1"><a href="javascript:edit();">수정</a></span> 
						<span class="btn1"><a href="javascript:del();">삭제</a></span>
						<span class="btn1"><a href="board_list.php?<?=$param?>">목록</a></span><br />
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

<!--#include virtual="/admin/include/footer.asp" -->
<script type="text/javascript">
<!--
	function edit(){
		if (confirm("수정하시겠습니까?")==true){
			document.f.typ.value = "edit";
			document.f.action = "board_write.php?<?=$param?>";
			document.f.submit();
		}
	}

	function del(){
		if (confirm("삭제하시겠습니까?")==true){
			document.f.typ.value = "del";
			document.f.action = "board_proc.php?<?=$param?>";
			document.f.encoding = "multipart/form-data";
			document.f.submit();
			
		}
	}

	function check_comm(){					
		var f = document.f ;		
	
		if(trim(f.comment.value)=="" || trim(f.comment.value).length<3){
			alert("댓글 내용을 입력해 주세요.");
			f.comment.focus();

			return;
		}
		document.f.typ.value = "comm_write";
		document.f.action = "board_proc.php?<?=$param?>";
		document.f.encoding = "multipart/form-data";
		document.f.submit();
	 
	}

	function del_comm(id){
		if (confirm("댓글을 삭제하시겠습니까?")==true){
			document.f.comm_idx.value = id;
			document.f.typ.value = "comm_del";
			document.f.action = "board_proc.php?<?=$param?>";
			document.f.encoding = "multipart/form-data";
			document.f.submit();
			
		}
	}

//-->
</script>
