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
<script type="text/javascript" src="/include/calendar.js"></script>
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
								<td height="40" class="rtitle01"><img src="/admin/img/icon_02.gif" width="15" height="15" vspace="3" align="absmiddle" /> 차종-제품연결</td>
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
								<td width="150" align="center" bgcolor="#f6f6f6" class="btitle02">회사</td>
								<td bgcolor="#FFFFFF"><?=GF_Common_SetComboList("company", "COMPANY", "", 1, "True",  "회사선택", "1" , "");?> <input name="site" type="text" maxlength="100" value="회사명 입력" ><input type="button" id="addCompany" name="addCompany" value="회사추가" style="background: #EAEAEA; font-size: 9pt;  padding-top: 1pt;height=7mm;width=18mm;cursor:hand;"/> </td>
							</tr>	
							<tr>
								<td align="center" bgcolor="#f6f6f6" class="btitle02">차종</td>
								<td bgcolor="#FFFFFF"><?=GF_Common_SetComboList("car", "COMPANY", "", 2, "True",  "차종선택", $car , "");?><input name="site" type="text" maxlength="100" value="차종 입력" > 연식: <input name="site" type="text" maxlength="100" value="연식 시작 입력" >~<input name="site" type="text" maxlength="100" value="연식 끝 입력" ><input type="button" id="addCompany" name="addCompany" value="차종추가" style="background: #EAEAEA; font-size: 9pt;  padding-top: 1pt;height=7mm;width=18mm;cursor:hand;"/> </td>
							</tr>
							<tr>
								<td align="center" bgcolor="#f6f6f6" class="btitle02">옵션</td>
								<td bgcolor="#FFFFFF">제품 종류 : <?=GF_Common_SetCheckboxList("checkbox", "product[]", "FAQ", "", 1, $product , "&nbsp;&nbsp;&nbsp;");?><br>
								설치 위치 (자전거 캐리어의 경우) : <?=GF_Common_SetCheckboxList("checkbox", "cate[]", "LOC", "", 1, $cate , "&nbsp;&nbsp;&nbsp;");?><br>
								지붕 타입 : <?=GF_Common_SetCheckboxList("checkbox", "pwd[]", "ROOF", "", 1, $pwd , "&nbsp;&nbsp;&nbsp;");?><br>
								제품 형태 (짐받이 캐리어의 경우) : <?=GF_Common_SetCheckboxList("checkbox", "day[]", "PROTYPE", "", 1, $day , "&nbsp;&nbsp;&nbsp;");?><br>
								</td>
							</tr>
							<tr>
								<td align="center" bgcolor="#f6f6f6" class="btitle02">선택된 제품</td>
								<td bgcolor="#FFFFFF"><select multiple style="width:650px" size="10"><option>기본바 시스템 - YI-130</option>
								<option>자전거캐리어(지붕형) - YI-701</option>
								<option>자전거캐리어(지붕형) - YI-0441</option>
								<option>짐받이캐리어(박스형) - YI-560</option>
								<option>액세서리 - 바</option>
								<option>액세서리 - 211루프</option>
								<option>액세서리 - 키마개</option>
								<option>액세서리 - 키커버</option>

								</select></td>
							</tr>
							<tr>
								<td align="center" bgcolor="#f6f6f6" class="btitle02">제품선택(기본바시스템)</td>
								<td bgcolor="#FFFFFF"><select multiple style="width:650px" size="10"><option>YI-130</option>
								<option>YI-131</option>
								<option>YI-132</option>
								<option>YI-133</option>
								<option>YI-134</option>
								<option>YI-135</option>
								<option>YI-136</option>
								</select><input type="button" id="addCompany" name="addCompany" value="선택하기" style="background: #EAEAEA; font-size: 9pt;  padding-top: 1pt;height=7mm;width=18mm;cursor:hand;"/></td>
							</tr>	
							<tr>
								<td align="center" bgcolor="#f6f6f6" class="btitle02">제품선택(자전거캐리어)</td>
								<td bgcolor="#FFFFFF"><select multiple style="width:650px" size="10"><option>지붕형 - YI-701</option>
								<option>지붕형 - YI-702</option>
								<option>지붕형 - YI-703</option>
								<option>지붕형 - YI-704</option>
								</select> <input type="button" id="addCompany" name="addCompany" value="선택하기" style="background: #EAEAEA; font-size: 9pt;  padding-top: 1pt;height=7mm;width=18mm;cursor:hand;"/></td>
							</tr>	
							<tr>
								<td align="center" bgcolor="#f6f6f6" class="btitle02">제품선택(짐받이캐리어)</td>
								<td bgcolor="#FFFFFF"><select multiple style="width:650px" size="10"><option>박스형 - YI-130</option>
								<option>일반형 - YI-204</option>
								<option>일반형 - YI-302</option>
								</select><input type="button" id="addCompany" name="addCompany" value="선택하기" style="background: #EAEAEA; font-size: 9pt;  padding-top: 1pt;height=7mm;width=18mm;cursor:hand;"/></td>
							</tr>	
							<tr>
								<td align="center" bgcolor="#f6f6f6" class="btitle02">제품선택(자전거거치대)</td>
								<td bgcolor="#FFFFFF"><select multiple style="width:650px" size="10"><option>YI-130</option>
								<option>YI-130</option>
								<option>YI-130</option>
								<option>YI-130</option>
								<option>YI-130</option>
								</select><input type="button" id="addCompany" name="addCompany" value="선택하기" style="background: #EAEAEA; font-size: 9pt;  padding-top: 1pt;height=7mm;width=18mm;cursor:hand;"/></td>
							</tr>	
							<tr>
								<td align="center" bgcolor="#f6f6f6" class="btitle02">스키캐리어</td>
								<td bgcolor="#FFFFFF"><select multiple style="width:650px" size="10"><option>YI-130</option>
								<option>YI-130</option>
								<option>YI-130</option>
								<option>YI-130</option>
								<option>YI-130</option>
								</select><input type="button" id="addCompany" name="addCompany" value="선택하기" style="background: #EAEAEA; font-size: 9pt;  padding-top: 1pt;height=7mm;width=18mm;cursor:hand;"/></td>
							</tr>	
							<tr>
								<td align="center" bgcolor="#f6f6f6" class="btitle02">제품선택(액세서리)</td>
								<td bgcolor="#FFFFFF"><select multiple style="width:650px" size="10"><option>바</option>
								<option>211루프</option>
								<option>키마개</option>
								<option>키커버</option>

								</select><input type="button" id="addCompany" name="addCompany" value="선택하기" style="background: #EAEAEA; font-size: 9pt;  padding-top: 1pt;height=7mm;width=18mm;cursor:hand;"/></td>
							</tr>	



	
							<?if($mode=="BB011"){?>
							
							<tr>
								<td width="150" align="center" bgcolor="#f6f6f6" class="btitle02">분류</td>
								<td bgcolor="#FFFFFF">
								<?=GF_Common_SetComboList("cate", "FAQ", "", 1, "True",  "분류선택", $cate , "");?>  </td>
							</tr>
							<? } ?>	
							<?if($mode=="AA002" or $mode=="AA003"){?>
							<tr>
								<td width="150" align="center" bgcolor="#f6f6f6" class="btitle02">링크</td>
								<td bgcolor="#FFFFFF"><input name="site" type="text" maxlength="100" value="<?=$site?>" class="inputtext"></td>
							</tr>
							<? } ?>	
							<!--
							<?
							if ($style<>"type2" and $style<>"type3"){
								if($mode=="AA002"){
									$si=0;
									$ei=0;
								}elseif($mode=="AA003"){
									$si=2;
									$ei=1;
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
							<? } ?>
							-->
							
							
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

