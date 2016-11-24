<?
$mode = $_REQUEST['mode'];
$idx = $_REQUEST['idx'];
$page = $_REQUEST['page'];

$search = $_REQUEST['search'];
$strsearch = $_REQUEST['strsearch'];

include $_SERVER["DOCUMENT_ROOT"]."/admin/include/header.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.other.php";

$searchand = " and gubun='$mode'";
if ($strsearch){
	$searchand .= " and $search like '%$strsearch%'";
}
 
if ($mode){
	$result = QRY_BANNER_VIEW($mode);
	$row = mysql_fetch_array($result);
	if($row){
		$bn_title=replace_out($row["bn_title"]);
		$typ = "edit";
	}else{
		$typ = "write";
	}
	
}
?>
<script type="text/javascript">
<!--
	function check(){
		var f =  document.f;

		if (trim(f.bn_title.value)==""){
			alert("제목을 입력해주세요.");
			f.bn_title.focus();
			return;
		}
		
		f.encoding = "multipart/form-data";
		f.action = "banner_proc.php?<?=$param?>"
		f.submit();
	}

	function img_del(id,file,num){
		if (confirm("파일을 삭제하시겠습니까? ")==true){
			document.f.temp_file.value = file;
			document.f.target = "imgdelifr";
			document.f.action ="/include/filedelete1.php?mode=<?=$mode?>&file_idx="+id+"&num="+num;
			document.f.submit();
		}
	}

	function del(){
		if (confirm("삭제하시겠습니까?")==true){
			document.f.typ.value = "del";
			document.f.action = "banner_proc.php?<?=$param?>";
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
						<table width="99%" border="0" cellspacing="1" cellpadding="5" bgcolor="#e6e6e6">
							<tr>
								<td width="150" align="center" bgcolor="#f6f6f6" class="btitle02">제목</td>
								<td bgcolor="#FFFFFF"><input name="bn_title" type="text" maxlength="100" value="<?=$bn_title?>" class="inputtext">								
								</td>
							</tr>
							<!-- 파일 업로드 시작 -->
							<?
							if($mode=="NN001"){
								$si=1;
								$ei=5;	
							}else{
								$si=1;
								$ei=4;	
							}
							?>
							<?For ($i=$si;$i<=$ei;$i++){?>
								<?
								If($typ=="edit"){
									If ($row["bn_file".$i]){									
								?>
								<tr>
									<td align="center" bgcolor="#f6f6f6" class="btitle02">이미지<?=$i?> VIEW</td>
									<td  bgcolor="#FFFFFF" valign="middle">	    
									<?
									$file_kind = strtolower(substr(  $row["bn_file".$i], -3)) ;
									if(  $file_kind == "gif" or $file_kind == "jpeg" or  $file_kind == "jpg" or  $file_kind == "png" ){
									?>
									<img src="<?=$file_path?><?=$row["bn_file".$i]?>" ><br>
									<?  }  ?>		
									<a href="/include/filedownload.php?filename=<?=$row["bn_file".$i]?>&path=<?=$file_path?>"    target="_net" ><?=$row["bn_file".$i]?></a><!--target="_new"-->
									<input type="button" value="이미지 삭제" onclick="img_del('<?=$idx?>','<?=$row["bn_file".$i]?>','<?=$i?>');">	</td>
								</tr>
								<input type="hidden" name="file_o<?=$i?>" value="<?=$row["bn_file".$i]?>">
									<? } ?>
								<? } ?>

								<tr>
									<td align="center" bgcolor="#f6f6f6" class="btitle02">이미지<?=$i?></td>
									<td bgcolor="#FFFFFF"><input name="file<?=$i?>" type="file" class="inputtext">  
									<?if($mode=="DD001"){?><br>width="2580" height="610"<?}?>
									<?if($mode=="DD002"){?><br>width="230" height="191"<?}?>
									<?if($mode=="DD003"){?><br>width="514" height="585"<?}?>
									</td>
								</tr>
								<tr>
									<td width="150" align="center" bgcolor="#f6f6f6" class="btitle02">링크</td>
									<td bgcolor="#FFFFFF"><input name="bn_url<?=$i?>" type="text" maxlength="100" value="<?=$row["bn_url".$i]?>" class="inputtext">
									<br><strong>http://</strong> 를 반드시 입력하세요
								</td>
							<? } ?>
							<!-- 파일 업로드 끝 -->
					
							
						</form>
						</table>
						
						<br />
						<table width="99%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td height="40" align="center" class="rtitle01">
								<span class="btn1"><a href="javascript:check();">등록</a></span>
								<?If( $typ=="edit"){?><span class="btn1"><a href="javascript:del();">삭제</a></span><?}?>
								<span class="btn1"><a href="banner_list.php?<?=$param?>">목록</a></span>
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
<!--#include virtual="/admin/include/footer.asp" -->
