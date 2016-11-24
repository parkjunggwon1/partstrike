<?
include $_SERVER["DOCUMENT_ROOT"]."/admin/include/header.php";

//echo	$_SESSION["ADMIN_ID"];
//echo 	$_SESSION["ADMIN_NAME"];
//echo 	$_SESSION["ADMIN_GUBUN"];
?>
<script type="text/javascript">
<!--
	function check(){
		var f = document.f;
		if (trim(f.id.value) == ""){
			alert("아이디를 입력하세요");
			f.id.value="";
			f.id.focus();
			return;
		}
		if (trim(f.name.value) == ""){
			alert("이름을 입력하세요");
			f.name.value="";
			f.name.focus();
			return;
		}	
		if (trim(f.mail.value) == ""){
			alert("이메일을 입력하세요");
			f.mail.value="";
			f.mail.focus();
			return;
		}
		if (trim(f.tel.value) == ""){
			alert("전화번호를 입력하세요");
			f.tel.value="";
			f.tel.focus();
			return;
		}
		if (trim(f.now_pwd.value) == ""){
			alert("현재 비밀번호를 입력하세요");
			f.now_pwd.value="";
			f.now_pwd.focus();
			return;
		}
		if (trim(f.chg_pwd.value) == ""){
			alert("변경할 비밀번호를 입력하세요");
			f.chg_pwd.value="";
			f.chg_pwd.focus();
			return;
		}
		if (trim(f.chg_pwd2.value) == ""){
			alert("변경할 비밀번호를 한번 더 입력하세요");
			f.chg_pwd2.value="";
			f.chg_pwd2.focus();
			return;
		}
		if (trim(f.chg_pwd.value) != trim(f.chg_pwd2.value)){
			alert("비밀번호가 일치하지 않습니다");
			f.chg_pwd.value="";
			f.chg_pwd2.value="";
			f.chg_pwd2.focus();
			return;
		}
		f.target="proc";
		f.action="change_proc.php"
		f.submit();
	}
//-->
</script>
<iframe name="proc" id="proc" src="" width="0" height="0" title="관리자 정보변경"></iframe>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td height="30" background="/admin/img/now_bg.gif" style="padding-left: 20px" class="now"><img src="/admin/img/icon.gif" width="9" height="7" /> HOME &gt; 관리자 정보</td>
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
				<td align="left" bgcolor="#63676a">
				<table width="1000" border="0" cellspacing="0" cellpadding="0">
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
								<td height="40" class="rtitle01"><img src="/admin/img/icon_02.gif" width="15" height="15" vspace="3" align="absmiddle" /> 관리자 정보 변경</td>
							</tr>
						</table>
						<table width="99%" border="0" cellspacing="1" cellpadding="5" bgcolor="#e6e6e6">
						<form name="f" method="post">						
							<tr>
								<td width="200" align="center" bgcolor="#f6f6f6" class="btitle02">아이디</td>
								<td bgcolor="#FFFFFF"><?=$_SESSION["ADMIN_ID"]?></td>
							</tr>
							<tr>
								<td width="200" align="center" bgcolor="#f6f6f6" class="btitle02">변경 아이디</td>
								<td bgcolor="#FFFFFF"><input name="id" type="text" maxlength="30" value="<?=$_SESSION["ADMIN_ID"]?>" class="" style="width:50%; border-width:1; border-style:solid; border-color:#cccccc; background-color:#ffffff; font-size: 9pt;"></td>
							</tr>
							<tr>
								<td width="200" align="center" bgcolor="#f6f6f6" class="btitle02">이름</td>
								<td bgcolor="#FFFFFF"><input name="name" type="text" maxlength="30" value="<?=$_SESSION["ADMIN_NAME"]?>" class="" style="width:50%; border-width:1; border-style:solid; border-color:#cccccc; background-color:#ffffff; font-size: 9pt;"></td>
							</tr>		
							<tr>
								<td width="200" align="center" bgcolor="#f6f6f6" class="btitle02">이메일</td>
								<td bgcolor="#FFFFFF"><input name="mail" type="text" maxlength="30" value="<?=$_SESSION["ADMIN_MAIL"]?>" class="" style="width:50%; border-width:1; border-style:solid; border-color:#cccccc; background-color:#ffffff; font-size: 9pt;"></td>
							</tr>
							<tr>
								<td width="200" align="center" bgcolor="#f6f6f6" class="btitle02">전화번호</td>
								<td bgcolor="#FFFFFF"><input name="tel" type="text" maxlength="30" value="<?=$_SESSION["ADMIN_TEL"]?>" class="" style="width:50%; border-width:1; border-style:solid; border-color:#cccccc; background-color:#ffffff; font-size: 9pt;"></td>
							</tr>

							<?$ship_info = get_any("admin","ship_info", "admin_id='".$_SESSION["ADMIN_ID"]."'");
							  $ship_account_no = get_any("admin","ship_account_no", "admin_id='".$_SESSION["ADMIN_ID"]."'");
							?>

							<tr>
								<td width="200" align="center" bgcolor="#f6f6f6" class="btitle02">선적정보</td>
								<td bgcolor="#FFFFFF"><?echo GF_Common_SetComboList("ship_info", "DLVR", "", 1, "True",  "선택", $ship_info , "");?> <input type="text" class="" name ="ship_account_no" id="ship_account_no" value="<?=$ship_account_no?>" style="width:42%; border-width:1; border-style:solid; border-color:#cccccc; background-color:#ffffff; font-size: 9pt;"></td>
							</tr>
							<tr>
								<td align="center" bgcolor="#f6f6f6" class="btitle02">현재 비밀번호</td>
								<td bgcolor="#FFFFFF"><input name="now_pwd" type="password" maxlength="30" value="" class="" style="width:50%; border-width:1; border-style:solid; border-color:#cccccc; background-color:#ffffff; font-size: 9pt;"></td>
							</tr>
							<tr>
								<td align="center" bgcolor="#f6f6f6" class="btitle02">변경 비밀번호</td>
								<td bgcolor="#FFFFFF"><input name="chg_pwd" type="password" maxlength="30" value="" class="" style="width:50%; border-width:1; border-style:solid; border-color:#cccccc; background-color:#ffffff; font-size: 9pt;"></td>
							</tr>
							<tr>
								<td align="center" bgcolor="#f6f6f6" class="btitle02">변경 비밀번호 확인</td>
								<td bgcolor="#FFFFFF"><input name="chg_pwd2" type="password" maxlength="30" value="" class="" style="width:50%; border-width:1; border-style:solid; border-color:#cccccc; background-color:#ffffff; font-size: 9pt;"></td>
							</tr>
							
						</form>
						</table>
						<br />
						<table width="99%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td height="40" align="center" class="rtitle01">
								<a href="javascript:check();"><span class="btn">등록</span></a>
								
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
