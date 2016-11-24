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
	$mem_level = replace_out($row["bd_mem_level"]);
	$blind = replace_out($row["bd_blind"]);	
	$cate = replace_out($row["bd_cate"]);		
	$day = replace_out($row["bd_day"]);		
	$pwd = replace_out($row["bd_pwd"]);		
	$content = replace_con_out($row["bd_content"]);
	$email = replace_out($row["bd_email"]);			
	$site = str_replace('"','',replace_out($row["bd_site"]));
	$address = replace_out($row["bd_address"]);
	$content1 = replace_out($row["bd_content1"]);
	$content2 = replace_out($row["bd_content2"]);
	$content3 = replace_out($row["bd_content3"]);
	$content4 = replace_out($row["bd_content4"]);
	$content5 = replace_out($row["bd_content5"]);
	$product_type_idx = replace_out($row["product_type_idx"]);		
	$notice = replace_out($row["bd_notice"]);
	$file0 = replace_out($row["bd_file0"]);
	$file1 = replace_out($row["bd_file1"]);
	$file2 = replace_out($row["bd_file2"]);
	$file3 = replace_out($row["bd_file3"]);
	$file4 = replace_out($row["bd_file4"]);
	$start_date = replace_out($row["bd_start_date"]);
	$end_date = replace_out($row["bd_end_date"]);
	$log_date = substr(replace_out($row["reg_date"]),0,10);
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
		var obj;
		 for (i = 1; i<=4 ;i++ )
		  {
			oEditors.getById["ir"+i].exec("UPDATE_IR_FIELD", []);     //스마트에디터 삽입
			obj = eval("f.content"+i);
			obj.value = document.getElementById("ir"+i).value;     //스마트에디터 삽입		
		  }
		  
		if (trim(f.title.value)==""){
			alert("제품코드를 입력해주세요.");
			f.title.focus();
			return;
		}		
		if (trim(f.mem_level.value)==""){
			alert("제품가격을 입력해주세요.");
			f.mem_level.focus();
			return;
		}
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
						<input type="hidden" name="param" value="<?=$param?>">	
						<input type="hidden" name="gopath" value="product">	
						
						<table width="99%" border="0" cellspacing="1" cellpadding="5" bgcolor="#e6e6e6">														
							<tr>
								<td align="center" bgcolor="#f6f6f6" class="btitle02">제품코드</td>
								<td bgcolor="#FFFFFF"><input name="title" type="text" value="<?=$title?>"  class="inputtext"> <input type="checkbox" name="blind" value="Y" <?if ($blind=="Y"){echo "checked";}?>>비노출</td>
							</tr>	
							
							<tr>
								<td width="150" align="center" bgcolor="#f6f6f6" class="btitle02">제품소제목</td>
								<td bgcolor="#FFFFFF"><input name="title_sub" type="text" value="<?=$title_sub?>"  class="inputtext"></td>
							</tr>								
							<tr>
								<td align="center" bgcolor="#f6f6f6" class="btitle02">제품가격</td>
								<td bgcolor="#FFFFFF"><input name="mem_level" type="text" value="<?=number_format($mem_level)?>"  class="inputtext"></td>
							</tr>	
							<?if ($mode == "BB006"){?>
							<tr>
									<td align="center" bgcolor="#f6f6f6" class="btitle02">설치지원옵션</td>
									<td bgcolor="#FFFFFF"><?=GF_Common_SetCheckboxList("checkbox", "cate[]", "FAQ", "", 1, $cate , "&nbsp;&nbsp;&nbsp;");?></td>
								</tr>	
							<?}else{?>
								<tr>
									<td align="center" bgcolor="#f6f6f6" class="btitle02">설치위치</td>
									<td bgcolor="#FFFFFF">
									<?if ($mode == "BB002") {
										echo GF_Common_SetComboList("cate", "LOC", "", 1, "False",  "위치선택", $cate , "");
									}else{
										echo "<SELECT id='cate' name='cate'><OPTION value='R'>지붕</OPTION></SELECT> ";	
									}?>
									</td>
								</tr>	
								<?if ($mode == "BB003") {?>
								<tr>
									<td align="center" bgcolor="#f6f6f6" class="btitle02">제품형태</td>
									<td bgcolor="#FFFFFF"><?=GF_Common_SetComboList("day", "PROTYPE", "", 1, "False",  "제품형태선택", $day , "");?></td>
								</tr>	
								<?}?>

								<tr>
									<td align="center" bgcolor="#f6f6f6" class="btitle02">지붕타입</td>
									<td bgcolor="#FFFFFF"><?=GF_Common_SetComboList("pwd", "ROOF", "", 1, "False",  "지붕타입선택", $pwd , "");?></td>
								</tr>	
								<tr>
									<td align="center" bgcolor="#f6f6f6" class="btitle02">제품 중분류</td>
									<td bgcolor="#FFFFFF"><?=GF_Category_SetComboList("product_type_idx", $mode, "True",  "중분류 선택", $product_type_idx , "");?></td>
								</tr>	
							<?}?>
							<tr>
								<td align="center" bgcolor="#f6f6f6" class="btitle02">제품설명</td>
								<td bgcolor="#FFFFFF"><textarea name="content" rows="5" cols="143"><?=$content?></textarea></td>
							</tr>
							<tr>
								<td align="center" bgcolor="#f6f6f6" class="btitle02">장착설명서</td>
								<td bgcolor="#FFFFFF"><input name="email" type="text" value="<?=$email?>"  class="inputtext"></td>
							</tr>	
							<tr>
								<td width="150" align="center" bgcolor="#f6f6f6" class="btitle02">장착동영상</td>
								<td bgcolor="#FFFFFF"><input name="site" type="text" maxlength="500" value="<?=$site?>" class="inputtext"></td>
							</tr>
							<tr>
								<td width="150" align="center" bgcolor="#f6f6f6" class="btitle02">구매하기URL</td>
								<td bgcolor="#FFFFFF"><input name="address" type="text" maxlength="500" value="<?=$address?>" class="inputtext"></td>
							</tr>
							<tr>
								<td width="150" align="center" bgcolor="#f6f6f6" class="btitle02">스펙</td>
								<td bgcolor="#FFFFFF"><textarea name="content1" style="display:none"></textarea>
								<textarea name="ir1" id="ir1" style="width:98%;height:200px;display:none;"><?=$content1?></textarea></td>
								</td>
							</tr>
	
	<tr>
								<td width="150" align="center" bgcolor="#f6f6f6" class="btitle02">상세설명</td>
								<td bgcolor="#FFFFFF"><textarea name="content2" style="display:none"></textarea>
								<textarea name="ir2" id="ir2" style="width:98%;height:200px;display:none;"><?=$content2?></textarea></td>
							</tr>
	
	<tr>
								<td width="150" align="center" bgcolor="#f6f6f6" class="btitle02">주의사항</td>
								<td bgcolor="#FFFFFF"><textarea name="content3" style="display:none"></textarea>
								<textarea name="ir3" id="ir3" style="width:98%;height:200px;display:none;"><?=$content3?></textarea></td>
							</tr>
	<tr style="display">
								<td width="150" align="center" bgcolor="#f6f6f6" class="btitle02">부속품</td>
								<td bgcolor="#FFFFFF"><textarea name="content4" style="display:none"></textarea>
								<textarea name="ir4" id="ir4" style="width:98%;height:200px;display:none;"><?=$content4?></textarea></td>
							</tr>
						<tr style="display">
								<td width="150" align="center" bgcolor="#f6f6f6" class="btitle02">관리자 메모</td>
								<td bgcolor="#FFFFFF"><textarea name="content5" style="display" cols="143" rows="5"><?=$content5?></textarea>
								</td>
							</tr>
							
							<?
							if ($style<>"type2" and $style<>"type3"){
								if($mode=="AA002"){
									$si=0;
									$ei=0;
								}elseif($mode=="AA003"){
									$si=2;
									$ei=1;
								}else{
									$si=0;
									$ei=4;
								}															
							?>
							<?For ($i=$si;$i<=$ei;$i++){?>
								<?
								If($idx){
									If ($row["bd_file".$i]){									
								?>
								<tr>
									<td align="center" bgcolor="#f6f6f6" class="btitle02"><?If ($i==0 || $mode == "BB014" || $mode=="BB015"){?>리스트이미지<?}else{?>리스트이미지<?=$i?><? } ?></td>
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
							<? } ?>
							
							
							
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
								<?If(typ=="edit"){?><span class="btn1"><a href="javascript:del();">삭제</a></span><?}?>
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
  var hei = "260"
  var oEditors = [];

  for (i = 1; i<=4 ;i++ )
  {
	  nhn.husky.EZCreator.createInIFrame({
		oAppRef: oEditors,
		elPlaceHolder: "ir"+i,
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
		
  }
	

</script>
