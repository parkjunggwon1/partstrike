<?
include $_SERVER["DOCUMENT_ROOT"]."/admin/include/header.php";

if ($idx){
	$result = QRY_VIEW("agency"," and idx='$idx'");
	$row = mysql_fetch_array($result);

	$idx = replace_out($row["idx"]);
	$rel_idx = replace_out($row["rel_idx"]);
	$mem_idx = replace_out($row["mem_idx"]);
	$agency_idx = replace_out($row["agency_idx"]);
	$agency_name = replace_out($row["agency_name"]);
	$agency_file1 = replace_out($row["agency_file1"]);
	$agency_homepage = replace_out($row["agency_homepage"]);
	$log_date = substr(replace_out($row["reg_date"]),0,10);
	$typ = "edit";

}else{
	$typ = "write";
}

?>
<script type="text/javascript">
<!--
	function check(){
		var f =  document.f;

		//if (trim(f.title.value)==""){
		//	alert("제목을 입력해주세요.");
		//	f.title.focus();
		//	return;
		//}
		//if (trim(f.content.value)==""){
		//	alert("내용을 입력해주세요.");
		//	return;
		//}
		f.encoding = "multipart/form-data";
		f.action = "agency_proc.php?<?=$param?>"
		f.submit();
	}

	function img_del(id,filename,num){
		if (confirm("파일을 삭제하시겠습니까? ")==true){
			document.f.temp_file.value = filename
			document.f.target = "imgdelifr";
			document.f.action ="/include/filedelete1.php?mode=<?=$mode?>&file_idx="+id+"&num="+num;
			document.f.submit();
		}
	}

	function del(){
		if (confirm("삭제하시겠습니까?")==true){
			document.f.typ.value = "del";
			document.f.action = "agency_proc.php?<?=$param?>";
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
						<iframe name="imgdelifr" id="imgdelifr" src="" width="500" height="0" frameborder="0" title="이미지 삭제 프로시져 프레임"></iframe>						
						<form name="f" method="post">
						<input type="hidden" name="typ" value="<?=$typ?>">
						<input type="hidden" name="idx" value="<?=$idx?>">
						<input type="hidden" name="filecnt" value="5">
						<input type="hidden" name="temp_file" value="" title="단수이미지 삭제">
						<input type="hidden" name="path" value="<?=$file_path?>" title="이미지 삭제 경로">	
						<input type="hidden" name="list_url" value="agency_list.php">
						<table width="99%" border="0" cellspacing="1" cellpadding="5" bgcolor="#e6e6e6">							
							<?
							$si=1;
							$ei=1;
							?>
							<?For ($i=$si;$i<=$ei;$i++){?>
								<?
								If($idx){
									If ($row["agency_file".$i]){									
								?>
								<tr>
									<td align="center" bgcolor="#f6f6f6" class="btitle02">로고</td>
									<td  bgcolor="#FFFFFF" valign="middle">	
									<img src="<?=$file_path?><?=$row["agency_file".$i]?>"><br>
									<a href="/include/filedownload.php?filename=<?=$row["agency_file".$i]?>&path=<?=$file_path?>" target="_net"><?=$row["agency_file".$i]?></a>
									<input type="button" value="첨부파일 삭제" onclick="img_del('<?=$idx?>','<?=$row["agency_file".$i]?>','<?=$i?>');">	
									
									</td>
								</tr>
								<input type="hidden" name="file_o<?=$i?>" value="<?=$row["agency_file".$i]?>">
									<? } ?>
								<? } ?>

								<tr>
									<td align="center" bgcolor="#f6f6f6" class="btitle02">로고</td>
									<td bgcolor="#FFFFFF"><input name="file<?=$i?>" type="file" class="inputtext"></td>
								</tr>
							<? } ?>													
							<tr>
								<td width="150" align="center" bgcolor="#f6f6f6" class="btitle02">제조회사</td>
								<td bgcolor="#FFFFFF"><input name="agency_name" type="text" maxlength="100" value="<?=$agency_name?>" class="inputtext"></td>
							</tr>
							<tr>
								<td width="150" align="center" bgcolor="#f6f6f6" class="btitle02">홈페이지</td>
								<td bgcolor="#FFFFFF"><input name="agency_homepage" type="text" maxlength="100" value="<?=$agency_homepage?>" class="inputtext"></td>
							</tr>
						</form>
						</table>
						
						<br />
						<table width="99%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td height="40" align="center" class="rtitle01">
								<span class="btn1"><a href="javascript:check();">등록</a></span>
								<?If(typ=="edit"){?><span class="btn1"><a href="javascript:del();">삭제</a></span><?}?>
								<span class="btn1"><a href="agency_list.php?<?=$param?>">목록</a></span>
								</td>
							</tr>
						</table>
						<br />
						<br />
						<br />
						<br />
						<!--오른쪽 끝-->
						<?
						include $_SERVER["DOCUMENT_ROOT"]."/admin/agency/agency_view.php";
						?>
	

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


