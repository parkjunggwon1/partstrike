<?
include $_SERVER["DOCUMENT_ROOT"]."/admin/include/header.php";

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
	$content = replace_out($row["bd_content"]);
	$notice = replace_out($row["bd_notice"]);
	$file1 = replace_out($row["bd_file1"]);
	$start_date = replace_out($row["bd_start_date"]);
	$end_date = replace_out($row["bd_end_date"]);
	$log_date = substr(replace_out($row["reg_date"]),0,10);
	$cate = replace_out($row["bd_cate"]);
	$site = replace_out($row["bd_site"]);
	$company = replace_out($row["bd_company"]);
	$tel = replace_out($row["bd_tel"]);
	$bd_day = replace_out($row["bd_day"]);
	$typ = "edit";

}else{
	$typ = "write";
	$name = $_SESSION["ADMIN_NAME"];
	$bd_day = date('Y-m-d');
}

?>
<script type="text/javascript" src="/admin/SE_/js/HuskyEZCreator.js" charset="utf-8"></script>
<script type="text/javascript" src="/include/calendar.js"></script>
<script type="text/javascript">
<!--
	function check(){
		var f =  document.f;

		oEditors.getById["ir1"].exec("UPDATE_IR_FIELD", []);     //스마트에디터 삽입
	    f.content.value = document.getElementById("ir1").value;     //스마트에디터 삽입		

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
		f.action = "board_proc.php?<?=$param?>"
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
			document.f.action = "board_proc.php?<?=$param?>";
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
						<input type="hidden" name="list_url" value="board_list.php">
						<table width="99%" border="0" cellspacing="1" cellpadding="5" bgcolor="#e6e6e6">
							<?if(substr($mode,0,2)=="EE"){?>
							<tr>
								<td  width="150" align="center" bgcolor="#f6f6f6" class="btitle02">회원분류</td>
								<td bgcolor="#FFFFFF">
								<input type="checkbox" name="mem_type[]" value="99" checked>전체
								<input type="checkbox" name="mem_type[]" value="1">유통회사
								<input type="checkbox" name="mem_type[]" value="2">제조회사
								<input type="checkbox" name="mem_type[]" value="3">교육기관
								<input type="checkbox" name="mem_type[]" value="4">개인
								<input type="checkbox" name="mem_type[]" value="5">학생</td>
							</tr>	
							<?}?>
							<?if(substr($mode,0,2)=="XX"){?>
							<tr>
								<td  width="150" align="center" bgcolor="#f6f6f6" class="btitle02">회원</td>
								<td bgcolor="#FFFFFF">
								<input type="checkbox"  name="alldelchk" onclick="alldel_chk(this.checked);">전체
								<?
								$result1 =QRY_LIST(" admin ","all","1"," and admin_gubun='member' "," admin_idx DESC");
								while($row1 = mysql_fetch_array($result1)){
									$admin_idx = replace_out($row1["admin_idx"]);
									$admin_id = replace_out($row1["admin_id"]);	
									$admin_name = replace_out($row1["admin_name"]);	
								?>
								<input type="checkbox" name="delchk[]" value="<?=$admin_idx?>"><?=$admin_name?>&nbsp;
								<?}?>
								</td>
							</tr>	
							<?}?>
							<tr>
								<td  width="150" align="center" bgcolor="#f6f6f6" class="btitle02">작성자</td>
								<td bgcolor="#FFFFFF"><input name="name" type="text" value="<?=$name?>"  class="inputtext"></td>
							</tr>													
							<tr>
								<td width="150" align="center" bgcolor="#f6f6f6" class="btitle02">제목</td>
								<td bgcolor="#FFFFFF"><input name="title" type="text" maxlength="100" value="<?=$title?>" class="inputtext">
								<?if($mode=="AA007"){?>
								<input type="checkbox" name="notice" value="y" <?If(notice=="y"){?> checked <?}?>>공지글
								<?}?>
								</td>
							</tr>
							
							
							<?
								if(substr($mode,0,2)=="AA"){
									$si=1;
									$ei=1;
								}elseif(substr($mode,0,2)=="EE"){
									$si=1;
									$ei=2;
								}else{
									$si=1;
									$ei=1;
								}															
							?>
							<?For ($i=$si;$i<=$ei;$i++){?>
								<?
								If($idx){
									If ($row["bd_file".$i]){									
								?>
								<tr>
									<td align="center" bgcolor="#f6f6f6" class="btitle02"><?If ($i==0 || $mode == "BB014" || $mode=="BB015"){?>리스트이미지<?}else{?>첨부파일<?=$i?><? } ?></td>
									<td  bgcolor="#FFFFFF" valign="middle">	
									<img src="<?=$file_path?><?=$row["bd_file".$i]?>"><br>
									<a href="/include/filedownload.php?filename=<?=$row["bd_file".$i]?>&path=<?=$file_path?>" target="_net"><?=$row["bd_file".$i]?></a>
									<input type="button" value="첨부파일 삭제" onclick="img_del('<?=$idx?>','<?=$row["bd_file".$i]?>','<?=$i?>');">	
									
									</td>
								</tr>
								<input type="hidden" name="file_o<?=$i?>" value="<?=$row["bd_file".$i]?>">
									<? } ?>
								<? } ?>

								<tr>
									<td align="center" bgcolor="#f6f6f6" class="btitle02"><?If ($i==0){?>리스트이미지<?}else{?>첨부파일<?=$i?><? } ?></td>
									<td bgcolor="#FFFFFF"><input name="file<?=$i?>" type="file" class="inputtext"></td>
								</tr>
							<? } ?>
							
							<tr>
								<td align="center" bgcolor="#f6f6f6" class="btitle02">내용</td>
								<td bgcolor="#FFFFFF"><textarea name="content" style="display:none"></textarea>
								<textarea name="ir1" id="ir1" style="width:98%;height:200px;display:none;"><?=$content?></textarea></td>
							</tr>
							
							<?If ($mode=="AA100" or $style=="type3") {?>
							<tr>
								<td align="center" bgcolor="#f6f6f6" class="btitle02">등록일</td>
								<td bgcolor="#FFFFFF"><input name="bd_day" type="text" value="<?=$bd_day?>" maxlength="10"  class="inputtext" onclick="Calendar_D(this,event.clientX, event.clientY);"></td>
							</tr>
							<? } ?>
						</form>
						</table>
						
						<br />
						<table width="99%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td height="40" align="center" class="rtitle01">
								<span class="btn1"><a href="javascript:check();">등록</a></span>
								<?If($typ=="edit"){?><span class="btn1"><a href="javascript:del();">삭제</a></span><?}?>
								<span class="btn1"><a href="board_list.php?<?=$param?>">목록</a></span>
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

<script language="javascript">
  // 이미지업로드 경로
  var imagepath = "<?=$se_path?>";
  var hei = "300"
  var oEditors = [];
	nhn.husky.EZCreator.createInIFrame({
		oAppRef: oEditors,
		elPlaceHolder: "ir1",
		sSkinURI: "/admin/SE_/SEditorSkin.html",	
		htParams : {
			bUseToolbar : true,				// 툴바 사용 여부 (true:사용/ false:사용하지 않음)
			bUseVerticalResizer : true,		// 입력창 크기 조절바 사용 여부 (true:사용/ false:사용하지 않음)
			bUseModeChanger : true,			// 모드 탭(Editor | HTML | TEXT) 사용 여부 (true:사용/ false:사용하지 않음)
			fOnBeforeUnload : function(){
				//alert("아싸!");	
			}
		}, //boolean
		fOnAppLoad : function(){
			//예제 코드
			//oEditors.getById["ir1"].exec("PASTE_HTML", ["로딩이 완료된 후에 본문에 삽입되는 text입니다."]);
		},
		fCreator: "createSEditor2"
	});

</script>
