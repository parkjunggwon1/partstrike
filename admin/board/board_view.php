<?
$mode = $_REQUEST['mode'];
$idx = $_REQUEST['idx'];
$page = $_REQUEST['page'];

$search = $_REQUEST['search'];
$strsearch = $_REQUEST['strsearch'];

include $_SERVER["DOCUMENT_ROOT"]."/admin/include/header.php";

$searchand = " and bd_gubun='$mode'";
if ($strsearch){
	$searchand .= " and $search like '%$strsearch%'";
}
 
if ($idx){
	plushit("board","bd_hit","bd_idx",$idx);
	$result = QRY_BOARD_VIEW($idx);
	$row = mysql_fetch_array($result);
	//$idx = replace_out($row["bd_idx"]);	
	$title = replace_out($row["bd_title"]);
	$title_sub = replace_out($row["bd_title_sub"]);
	$name = replace_out($row["bd_mem_name"]);
	$mem_idx = replace_out($row["bd_mem_idx"]);
	$mem_level = replace_out($row["bd_mem_level"]);
	$email = replace_out($row["bd_email"]);			
	$content = replace_out($row["bd_content"]);
	$notice = replace_out($row["bd_notice"]);	
	$log_date = substr(replace_out($row["reg_date"]),0,10);
	$cate = replace_out($row["bd_cate"]);
	$typ = "edit";
	
	if ($mem_level){
		$mem_level = sprintf('%02d', $mem_level);
	}
}else{           
	$typ = "write";
	$name = $_SESSION["ADMIN_NAME"];
	$bd_day = date('Y-m-d');
}

?>
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

	function srh_exe(obj){
		var idx = obj.value;
		alert(idx)
		location.href = "board_write.php?<?=$param?>&idx="+idx;
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
						<input type="hidden" name="mode" value="<?=$mode?>">
						<input type="hidden" name="typ" value="<?=$typ?>">
						<input type="hidden" name="idx" value="<?=$idx?>">
						<input type="hidden" name="filecnt" value="5">
						<input type="hidden" name="temp_file" value="" title="단수이미지 삭제">
						<input type="hidden" name="path" value="<?=$file_path?>" title="이미지 삭제 경로">	
						<table width="99%" border="0" cellspacing="1" cellpadding="5" bgcolor="#e6e6e6">
							<?if(substr($mode,0,2)=="XX"){?>
							<tr>
								<td  width="150" align="center" bgcolor="#f6f6f6" class="btitle02">회원</td>
								<td bgcolor="#FFFFFF">
								<?
								$result1 =QRY_LIST(" board_send a, admin b ","all","1"," and bd_idx='$idx' and a.mem_idx=b.admin_idx "," a.mem_idx ");
								while($row1 = mysql_fetch_array($result1)){
									$admin_name = replace_out($row1["admin_name"]);
								?>
								<?=$admin_name?>&nbsp;
								<?}?>
								</td>
							</tr>	
							<?}?>
							<tr>
								<td  width="150" align="center" bgcolor="#f6f6f6" class="btitle02"> 작성자  </td>
								<td bgcolor="#FFFFFF">
								<?if ($mem_level){?>
								[<font color="#0000ff"><?=get_this("code","title","code",$mem_level)?></font>]
								<?}?>
								<?=$name?></td>
							</tr>													
							<tr>
								<td width="150" align="center" bgcolor="#f6f6f6" class="btitle02">제목</td>
								<td bgcolor="#FFFFFF"><?If(notice=="y"){?> [공지] <?}?><?=$title?>
								
								</td>
							</tr>
							<?if($cate){?>
							<tr>
								<td width="150" align="center" bgcolor="#f6f6f6" class="btitle02">분류</td>
								<td bgcolor="#FFFFFF"><?=GF_Common_GetSingleList("FAQ",$cate)?>
								
								</td>
							</tr>
							<?}?>
							<!-- 파일 업로드 시작 -->
							<?
							if (substr($mode,0,2) != "ZZ") {
									$si=0;
									$ei=5;	
							?>
							<?For ($i=$si;$i<=$ei;$i++){?>
								<?
								If($idx){
									If ($row["bd_file".$i]){									
								?>
								<tr>
									<td align="center" bgcolor="#f6f6f6" class="btitle02"><?if($mode == "BB014" || $mode=="BB015"){echo "리스트이미지";}else{echo "첨부파일";}?></td>
									<td  bgcolor="#FFFFFF" valign="middle">	    
									<?
									$file_kind = strtolower(substr(  $row["bd_file".$i], -3)) ;
									if(  $file_kind == "gif" or $file_kind == "jpeg" or  $file_kind == "jpg" or  $file_kind == "png" ){
									?>
									<img src="<?=$file_path?><?=$row["bd_file".$i]?>"><br>
									<?  }  ?>		
									<a href="/include/filedownload.php?filename=<?=$row["bd_file".$i]?>&path=<?=$file_path?>"    target="_net" ><?=$row["bd_file".$i]?></a><!--target="_new"-->
									</td>
								</tr>
								<input type="hidden" name="file_o<?=$i?>" value="<?=$row["bd_file".$i]?>">
									<? } ?>
								<? } ?>

								
							<? } ?>
							<? } ?>
							<!-- 파일 업로드 끝 -->
							
							
							
							
							<tr>
								<td align="center" bgcolor="#f6f6f6" class="btitle02">내용</td>
								<td bgcolor="#FFFFFF"><?=$content?></td>
							</tr>
							
						</form>
						</table>
						
						<br />
						<?
						include "board_comment.php";
						?>

						<br>
						<table width="99%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td height="40" align="center" class="rtitle01">
								<span class="btn1"><a href="javascript:edit();">수정</a></span>
								<?If( $mode!="ZZ001"){?>
								<?If( $typ=="edit"){?><span class="btn1"><a href="javascript:del();">삭제</a></span><?}?>
								<span class="btn1"><a href="board_list.php?<?=$param?>">목록</a></span>
								<?}?>
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

