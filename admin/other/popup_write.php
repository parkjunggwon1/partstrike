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
 
if ($idx){
	$result = QRY_POPUP_VIEW($idx);
	$row = mysql_fetch_array($result);
	$title=replace_out($row["title"]);
	$content=replace_out($row["content"]);
	$log_date=replace_out($row["log_date"]);
	$p_top = replace_out($row["p_top"]); 
	$p_left = replace_out($row["p_left"]);   
	$p_wid = replace_out($row["p_wid"]);   
	$p_hei = replace_out($row["p_hei"]);     
	$lay_yn = replace_out($row["lay_yn"]);    
	$img_yn = replace_out($row["img_yn"]);  
	$scr_yn = replace_out($row["scr_yn"]);   
	$use_yn = replace_out($row["use_yn"]);    
	$url1 = replace_out($row["url1"]);
	$file1 = replace_out($row["file1"]);
	$start_date = replace_out($row["start_date"]);
	$start_time = replace_out($row["start_time"]);
	$end_date = replace_out($row["end_date"]);
	$end_time = replace_out($row["end_time"]);
	$typ = "edit";
}else{           
	$typ = "write";
	$name = $_SESSION["ADMIN_NAME"];
	$bd_day = date('Y-m-d');
}

?>
<script type="text/javascript" src="/include/calendar.js"></script>
<script type="text/javascript" src="/admin/SE_/js/HuskyEZCreator.js" charset="utf-8"></script>
<script type="text/javascript">
<!--
	function check(){
		var f =  document.f;

		oEditors.getById["ir1"].exec("UPDATE_IR_FIELD", []);     //스마트에디터 삽입
	    f.content.value = document.getElementById("ir1").value;     //스마트에디터 삽입		

		if (trim(f.title.value)==""){
			alert("제목을 입력해주세요.");
			f.title.focus();
			return;
		}
		
		f.encoding = "multipart/form-data";
		f.action = "popup_proc.php";
		f.submit();
	}

	function img_del(id,file,num){
		if (confirm("이미지를 삭제하시겠습니까? ")==true){
			document.f.temp_file.value = file;
			document.f.target = "imgdelifr";
			document.f.action ="/include/filedelete1.php?file_idx="+id+"&num="+num;
			document.f.submit();
		}
	}

	function del(){
		if (confirm("삭제하시겠습니까?")==true){
			document.f.typ.value = "del";
			document.f.action = "popup_proc.php";
			document.f.encoding = "multipart/form-data";
			document.f.submit();
			
		}
	}
//-->
</script>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td height="30" background="/admin/img/now_bg.gif" style="padding-left: 20px" class="now"><img src="/admin/img/icon.gif" width="9" height="7" /> HOME &gt; 기타관리</td>
	</tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="208" valign="top"><?
		include $_SERVER["DOCUMENT_ROOT"]."/admin/include/lm.php";
		?></td>
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
								<td height="40" class="rtitle01"><img src="/admin/img/icon_02.gif" width="15" height="15" vspace="3" align="absmiddle" /> 팝업관리</td>
							</tr>
						</table>
						<table width="99%" border="0" cellspacing="1" cellpadding="5" bgcolor="#e6e6e6">
						<form name="f" method="post">
						<input type="hidden" name="mode" value="<?=$mode?>">
						<input type="hidden" name="typ" value="<?=$typ?>">
						<input type="hidden" name="page" value="<?=$page?>">
						<input type="hidden" name="idx" value="<?=$idx?>">
						<input type="hidden" name="file_o1" value="<?=$file1?>">
						<input type="hidden" name="filecnt" value="1">
						<input type="hidden" name="temp_file" value="" title="단수이미지 삭제">
						<input type="hidden" name="path" value="<?=$file_path?>" title="이미지 삭제 경로">
							
							<tr>
								<td width="150" align="center" bgcolor="#f6f6f6" class="btitle02">제목</td>
								<td bgcolor="#FFFFFF"><input name="title" type="text" maxlength="35" value="<?=$title?>" class="" style="width:50%; border-width:1; border-style:solid; border-color:#cccccc; background-color:#ffffff; font-size: 9pt;">							
								</td>
							</tr>
							<tr>
								<td align="center" bgcolor="#f6f6f6" class="btitle02">TOP</td>
								<td bgcolor="#FFFFFF"><input type="text" name="p_top" size="4"  maxlength="4" value="<?=$p_top?>" style="border-width:1; border-style:solid; border-color:#cccccc; background-color:#ffffff; font-size: 9pt;"> px</td>
							</tr>
							<tr>
								<td align="center" bgcolor="#f6f6f6" class="btitle02">LEFT</td>
								<td bgcolor="#FFFFFF"><input type="text" name="p_left" size="4"  maxlength="4" value="<?=$p_left?>" style="border-width:1; border-style:solid; border-color:#cccccc; background-color:#ffffff; font-size: 9pt;"> px</td>
							</tr>
							<tr>
								<td align="center" bgcolor="#f6f6f6" class="btitle02">WIDTH</td>
								<td bgcolor="#FFFFFF"><input type="text" name="p_wid" size="4"  maxlength="4" value="<?=$p_wid?>" style="border-width:1; border-style:solid; border-color:#cccccc; background-color:#ffffff; font-size: 9pt;"> px</td>
							</tr>
							<tr>
								<td align="center" bgcolor="#f6f6f6" class="btitle02">HEIGHT</td>
								<td bgcolor="#FFFFFF"><input type="text" name="p_hei" size="4"  maxlength="4" value="<?=$p_hei?>" style="border-width:1; border-style:solid; border-color:#cccccc; background-color:#ffffff; font-size: 9pt;"> px</td>
							</tr>
							<tr>
								<td align="center" bgcolor="#f6f6f6" class="btitle02">시작일자 및 시간</td>
								<td bgcolor="#FFFFFF"><input type="text" name="start_date" id="start_date" size="15" readonly onclick="Calendar_D(this,event.clientX, event.clientY);"  class="inputtext" style="width:70px;" value="<?=$start_date?>">
								<input type="text" name="start_time" id="start_time" size="15" class="inputtext" style="width:30px;" value="<?=$start_time?>"> * 24시간 형식으로 입력 
								</td>
							</tr>
							<tr>
								<td align="center" bgcolor="#f6f6f6" class="btitle02">종료일자 및 시간</td>
								<td bgcolor="#FFFFFF"><input type="text" name="end_date" id="end_date" size="15" readonly onclick="Calendar_D(this,event.clientX, event.clientY);"  class="inputtext" style="width:70px;" value="<?=$end_date?>">
								<input type="text" name="end_time" id="end_time" size="15" class="inputtext" style="width:30px;" value="<?=$end_time?>"> * 24시간 형식으로 입력 
								</td>
							</tr>
							<tr>
								<td align="center" bgcolor="#f6f6f6" class="btitle02">스크롤바사용</td>
								<td bgcolor="#FFFFFF"><input type="radio" name="scr_yn" value="y" <?If ($scr_yn=="y"){?>checked<?}?>>사용함
								<input type="radio" name="scr_yn" value="n" <?If ($scr_yn!="y" or $scr_yn==""){?>checked<?}?>>사용안함</td>
							</tr>
							<input type="hidden" name="lay_yn" value="n">
							<!--<tr>
								<td align="center" bgcolor="#f6f6f6" class="btitle02">팝업종류</td>
								<td bgcolor="#FFFFFF"><input type="radio" name="lay_yn" value="y" <?If ($lay_yn=="y"){?>checked<?}?>>레이어팝업
								<input type="radio" name="lay_yn" value="n" <?If ($lay_yn!="y" or $lay_yn==""){?>checked<?}?>>일반창팝업</td>
							</tr>-->
							<tr>
								<td align="center" bgcolor="#f6f6f6" class="btitle02">입력방법</td>
								<td bgcolor="#FFFFFF"><input type="radio" name="img_yn" value="y" <?If ($img_yn=="y" or $img_yn==""){?>checked<?}?>>이미지
								<input type="radio" name="img_yn" value="n" <?If ($img_yn!="y"){?>checked<?}?>>HTML<br>						
								&nbsp;&nbsp;&nbsp;이미지 : 편집기의 내용은 적용되지 않습니다.<br>
								&nbsp;&nbsp;&nbsp;HTML : 이미지 및 링크는 적용 되지 않습니다.</td>
							</tr>
							<tr>
								<td align="center" bgcolor="#f6f6f6" class="btitle02">사용여부</td>
								<td bgcolor="#FFFFFF"><input type="radio" name="use_yn" value="y" <?If ($use_yn=="y"){?>checked<?}?>>사용함
								<input type="radio" name="use_yn" value="n" <?If ($use_yn!="y" or $use_yn==""){?>checked<?}?>>사용안함</td>
							</tr>
							<!-- 파일 업로드 시작 -->
							<?
							$si=1;
							$ei=1;	
							?>
							<?For ($i=$si;$i<=$ei;$i++){?>
								<?
								If($idx){
									If ($row["file".$i]){									
								?>
								<tr>
									<td align="center" bgcolor="#f6f6f6" class="btitle02">이미지</td>
									<td  bgcolor="#FFFFFF" valign="middle">	    
									<?
									$file_kind = strtolower(substr(  $row["file".$i], -3)) ;
									if(  $file_kind == "gif" or $file_kind == "jpeg" or  $file_kind == "jpg" or  $file_kind == "png" ){
									?>
									<img src="<?=$file_path?><?=$row["file".$i]?>"><br>
									<?  }  ?>		
									<a href="/include/filedownload.php?filename=<?=$row["file".$i]?>&path=<?=$file_path?>"    target="_net" ><?=$row["file".$i]?></a><!--target="_new"-->
									<input type="button" value="이미지 삭제" onclick="img_del('<?=$idx?>','<?=$row["file".$i]?>','<?=$i?>');">	</td>
								</tr>
								<input type="hidden" name="file_o<?=$i?>" value="<?=$row["file".$i]?>">
									<? } ?>
								<? } ?>

								<tr>
									<td align="center" bgcolor="#f6f6f6" class="btitle02">이미지</td>
									<td bgcolor="#FFFFFF"><input name="file<?=$i?>" type="file" class="inputtext">  
									</td>
								</tr>
							<? } ?>
							<!-- 파일 업로드 끝 -->
							<tr>
								<td align="center" bgcolor="#f6f6f6" class="btitle02">링크</td>
								<td bgcolor="#FFFFFF"><input name="url1" type="text" class="" value="<?=$url1?>" style="width:70%; border-width:1; border-style:solid; border-color:#cccccc; background-color:#ffffff; font-size: 9pt;"></td>
							</tr>													
							<iframe name="imgdelifr" id="imgdelifr" src="" width="0" height="0" title="이미지 삭제 프로시져 프레임"></iframe>
							<tr>
								<td align="center" bgcolor="#f6f6f6" class="btitle02">내용</td>
								<td bgcolor="#FFFFFF"><textarea name="content" style="display:none"></textarea>
								<textarea name="ir1" id="ir1" style="width:98%;height:400px;display:none;"><?=$content?></textarea></td>
							</tr>
						</form>
						</table>
						<br />
						<table width="99%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td height="40" align="center" class="rtitle01">
								<span class="btn1"><a href="javascript:check();">등록</a></span>
								<?If( $typ=="edit"){?><span class="btn1"><a href="javascript:del();">삭제</a></span><?}?>
								<span class="btn1"><a href="popup_list.php?<?=$param?>">목록</a></span>
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
  var hei = "350"
  var oEditors = [];
	nhn.husky.EZCreator.createInIFrame({
		oAppRef: oEditors,
		elPlaceHolder: "ir1",
		sSkinURI: "/admin/SE_/SEditorSkin.html",	
		htParams : {
			bUseToolbar : true,				// 툴바 사용 여부 (true:사용/ false:사용하지 않음)
			bUseVerticalResizer : false,		// 입력창 크기 조절바 사용 여부 (true:사용/ false:사용하지 않음)
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
