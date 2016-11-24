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
	$address = replace_out($row["bd_address"]);
	$site = replace_out($row["bd_site"]);
	$fax = replace_out($row["bd_fax"]);
	$bd_day = replace_out($row["bd_day"]);
	$bd_sort = replace_out($row["bd_sort"]);
	
	$typ = "edit";

}else{
	$typ = "write";
	$name = $_SESSION["ADMIN_NAME"];
	$bd_day = date('Y-m-d');
	$cate = 1;
}

?>
<script type="text/javascript">
<!--
	function check(){
		var f =  document.f;

//		oEditors.getById["ir1"].exec("UPDATE_IR_FIELD", []);     //스마트에디터 삽입
//	    f.content.value = document.getElementById("ir1").value;     //스마트에디터 삽입		

		if (trim(f.company.value)==""){
			alert("상호를 입력해주세요.");
			f.company.focus();
			return;
		}
		if ((trim(f.cate.value)=="") || (trim(f.cate.value)=="1" && trim(f.site.value)=="")){
			alert("지역을 선택해주세요.");
			f.cate.focus();
			return;
		}
		if (trim(f.tel.value)==""){
			alert("전화번호를 입력해주세요.");
			f.tel.focus();
			return;
		}
		if (trim(f.title.value)==""){
			alert("지도주소를 입력해주세요.");
			f.title.focus();
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
						<input type="hidden" name="bd_sort" value="<?=$bd_sort?>">
						<table width="99%" border="0" cellspacing="1" cellpadding="5" bgcolor="#e6e6e6">
							<?if ($mode=="AA008") {?>
							<tr>
								<td width="150" align="center" bgcolor="#f6f6f6" class="btitle02">상호</td>
								<td bgcolor="#FFFFFF"><input name="company" type="text" value="<?=$company?>"  class="inputtext"></td>
							</tr>	
							<tr>
								<td align="center" bgcolor="#f6f6f6" class="btitle02">지역</td>
								<td bgcolor="#FFFFFF"><input name="name" type="text" value="<?=$name?>"  class="inputtext"></td>
							</tr>	
							<tr>
								<td align="center" bgcolor="#f6f6f6" class="btitle02">전화번호</td>
								<td bgcolor="#FFFFFF"><input name="tel" type="text" value="<?=$tel?>"  class="inputtext"></td>
							</tr>	
							<?}else if($mode=="BB010" or $mode=="BB009") {?>
							<tr>
								<td width="150" align="center" bgcolor="#f6f6f6" class="btitle02">상호</td>
								<td bgcolor="#FFFFFF"><input name="company" type="text" value="<?=$company?>"  class="inputtext"></td>
							</tr>			
							<tr>
								<td align="center" bgcolor="#f6f6f6" class="btitle02">지역</td>
								<td bgcolor="#FFFFFF"><?=GF_Common_SetComboList("cate", "AREA", "", 1, "false",  "지역선택", $cate , "class='area'");?> 
								<?=GF_Common_SetComboList("site", "AREA", $cate, 2, "True",  "지역선택", $site , "");?>
								</td>
							</tr>
							<tr>
								<td align="center" bgcolor="#f6f6f6" class="btitle02">전화번호</td>
								<td bgcolor="#FFFFFF"><input name="tel" type="text" value="<?=$tel?>"  class="inputtext"></td>
							</tr>	
							<tr>
								<td align="center" bgcolor="#f6f6f6" class="btitle02">팩스</td>
								<td bgcolor="#FFFFFF"><input name="fax" type="text" value="<?=$fax?>"  class="inputtext"></td>
							</tr>
							<tr>
								<td align="center" bgcolor="#f6f6f6" class="btitle02">이메일</td>
								<td bgcolor="#FFFFFF"><input name="email" type="text" value="<?=$email?>"  class="inputtext"></td>
							</tr>
							<tr>
								<td align="center" bgcolor="#f6f6f6" class="btitle02">지도주소</td>
								<td bgcolor="#FFFFFF"><input name="title" type="text" value="<?=$title?>"  class="inputtext"></td>
							</tr>
							<tr>
								<td align="center" bgcolor="#f6f6f6" class="btitle02">실주소</td>
								<td bgcolor="#FFFFFF"><input name="address" type="text" value="<?=$address?>"  class="inputtext"></td>
							</tr>
							
							<?}else{?>
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
							<?}?>
							
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

	$("select.area").change(function(e){
		ChangeArea($(this));			
	});

	function ChangeArea($this){
		$.ajax({ 
			type: "GET", 
			url: "/ajax/proc_ajax.php", 
			data: { actty : "CA",
					actkind : "",
					actidx : $this.val()
			},
			dataType : "html" ,
			async : false ,
			success: function(data){ 
				$("select[name=site]").remove();
				$("select[name=cate]").after($(trim(data))); 

			}
		});
	}

</script>
