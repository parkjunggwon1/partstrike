<?
include $_SERVER["DOCUMENT_ROOT"]."/admin/include/header.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.member.php";

if ($idx){
	$result = QRY_VIEW("admin"," and admin_idx='$idx'");
	$row = mysql_fetch_array($result);
	$admin_idx = replace_out($row["admin_idx"]);
	$admin_gubun = replace_out($row["admin_gubun"]);	
	$admin_id = replace_out($row["admin_id"]);	
	$admin_name = replace_out($row["admin_name"]);	
	$admin_name_e = replace_out($row["admin_name_e"]);	
	$admin_pwd = replace_out($row["admin_pwd"]);	
	$admin_pos = replace_out($row["admin_pos"]);	
	$admin_pos_e = replace_out($row["admin_pos_e"]);	
	$admin_tel = replace_out($row["admin_tel"]);	
	$admin_mail = replace_out($row["admin_mail"]);	
	$admin_etc1 = replace_out($row["admin_etc1"]);	
	$reg_date = replace_out($row["reg_date"]);	
	$typ = "edit";
}else{
	$typ = "write";
}
?>
<script type="text/javascript">
<!--
	function check(){
		var f =  document.f;
		
		if (trim(f.typ.value)=="write"){
			checkid('admin_id',f.admin_id.value,'아이디');
			if (checkvalid!=true){
				alert("아이디를 확인하세요");
				f.admin_id.focus();
				return;
			}	
		}
		if (nullchk_admin(f.admin_pwd,"비밀번호를 입력하세요.")== false) return ;		
		if (nullchk_admin(f.admin_pwd2,"비밀번호와 같게 입력하세요.")== false) return ;	
		if (trim(f.admin_pwd.value)!=trim(f.admin_pwd2.value) ){
			alert("비밀번호와 같게 입력하세요.");
			f.admin_pwd2.value="";
			f.admin_pwd2.focus();
			return;
		}
		if (nullchk_admin(f.admin_name,"이름을 입력하세요.")== false) return ;
		if (nullchk_admin(f.admin_name_e,"영문이름을 입력하세요.")== false) return ;
		if (nullchk_admin(f.admin_pos,"직책을 입력하세요.")== false) return ;
		if (nullchk_admin(f.admin_pos_e,"영문직책을 입력하세요.")== false) return ;
		if (nullchk_admin(f.admin_tel,"연락처를 입력하세요.")== false) return ;
		if (nullchk_admin(f.admin_mail,"이메일을 입력하세요.")== false) return ;
		
		f.action = "admin_proc.php?<?=$param?>"
		f.submit();
	}
	
	function del(){
		if (confirm("삭제하시겠습니까?")==true){
			document.f.typ.value = "del";
			document.f.action = "admin_proc.php?<?=$param?>";
			document.f.submit();
			
		}
	}
//-->
</script>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td height="30" background="/admin/img/now_bg.gif" style="padding-left: 20px" class="now"><img src="/admin/img/icon.gif" width="9" height="7" /> HOME &gt; <?=$title_menu?>  </td>
	</tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="208" valign="top"><!--메뉴-->
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
									<td  width="150" align="center" bgcolor="#f6f6f6" class="btitle02">아이디  </td>
									<td bgcolor="#FFFFFF">
									<?if($typ=="write"){?>
									<input name="admin_id" type="text" value="<?=$admin_id?>"  class="inputtext" style="width:150px;" maxlength="20" onblur="checkid('admin_id',this.value,'아이디');"><font color="#FF0000" id="checkspanadmin_id"></font>	
									<?}else{?>
									<?=$admin_id?> 
									<?}?>
									</td>
								</tr>
								<tr>
									<td  width="150" align="center" bgcolor="#f6f6f6" class="btitle02">비밀번호  </td>
									<td bgcolor="#FFFFFF"><input name="admin_pwd" type="password"  class="inputtext" value='<?=$admin_pwd?>' style="width:150px;" maxlength="20">
									&nbsp;&nbsp;<font color="#ffffff"><?=$admin_pwd?></font>
									</td>
								</tr>	
								<tr>
									<td  width="150" align="center" bgcolor="#f6f6f6" class="btitle02">비밀번호확인  </td>
									<td bgcolor="#FFFFFF"><input name="admin_pwd2" type="password"  class="inputtext" value='<?=$admin_pwd?>' style="width:150px;" maxlength="20"></td>
								</tr>
								<tr>
									<td  width="150" align="center" bgcolor="#f6f6f6" class="btitle02">이름 </td>
									<td bgcolor="#FFFFFF"><input name="admin_name" type="text"  class="inputtext" value='<?=$admin_name?>'  style="width:150px;" maxlength="20"></td>
								</tr>
								<tr>
									<td  width="150" align="center" bgcolor="#f6f6f6" class="btitle02">영문이름 </td>
									<td bgcolor="#FFFFFF"><input name="admin_name_e" type="text"  class="inputtext" value='<?=$admin_name_e?>'  style="width:150px;" maxlength="20"></td>
								</tr>	
								<tr>
									<td  width="150" align="center" bgcolor="#f6f6f6" class="btitle02">직책 </td>
									<td bgcolor="#FFFFFF"><input name="admin_pos" type="text"  class="inputtext" value='<?=$admin_pos?>'  style="width:150px;" maxlength="20"></td>
								</tr>	
								<tr>
									<td  width="150" align="center" bgcolor="#f6f6f6" class="btitle02">영문직책 </td>
									<td bgcolor="#FFFFFF"><input name="admin_pos_e" type="text"  class="inputtext" value='<?=$admin_pos_e?>'  style="width:150px;" maxlength="20"></td>
								</tr>	
								<tr>
									<td  width="150" align="center" bgcolor="#f6f6f6" class="btitle02">연락처 </td>
									<td bgcolor="#FFFFFF"><input name="admin_tel" type="text"  class="inputtext" value='<?=$admin_tel?>'  style="width:150px;" maxlength="20"></td>
								</tr>	
								<tr>
									<td  width="150" align="center" bgcolor="#f6f6f6" class="btitle02">이메일 </td>
									<td bgcolor="#FFFFFF"><input name="admin_mail" type="text"  class="inputtext" value='<?=$admin_mail?>'  style="width:150px;" maxlength="20"></td>
								</tr>	
								
								<tr>
									<td  width="150" align="center" bgcolor="#f6f6f6" class="btitle02">사용여부  </td>
									<td bgcolor="#FFFFFF"><label><input name="admin_etc1" type="radio"   value='Y' <?=($admin_etc1=='Y' or $admin_etc1=='')? "checked":"";?>>사용함</label>
									<label><input name="admin_etc1" type="radio"   value='N' <?=($admin_etc1=='N')? "checked":"";?>>사용안함</label>
									<br>*사용안함을 체크할 경우 로그인이 되지 않습니다</td>
								</tr>								
								<?if($typ=='edit'){?>								
								<tr>
									<td  width="150" align="center" bgcolor="#f6f6f6" class="btitle02">가입일시  </td>
									<td bgcolor="#FFFFFF"><?=$reg_date?> </td>
								</tr>
								<?}?>
							</table>
						</form>
						<br>
						<table width="99%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td height="40" align="center" class="rtitle01">
								<span class="btn1"><a href="javascript:check();">확인</a></span>
								<span class="btn1"><a href="admin_list.php?<?=$param?>">목록</a></span>
							
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
<script type="text/javascript">
<!--
var typ = "<?=$typ?>";
if (typ=="write"){
	var checkvalid = false;
}
var checkstrid = "";

function checkid(typ,val,txt){
	//"/ajax/checkid.asp?val=test&typ=admin_id&txt=아이디&m_idx=
	$('#checkspan'+typ).html("");
	//alert("val="+val+"&typ="+typ+"&txt="+txt+"&m_idx=<?=$idx?>")
	$.ajax({ 
		type: "POST", 
		url: "/ajax/check.php", 
		data: "val="+val+"&typ="+typ+"&txt="+txt+"&m_idx=<?=$idx?>", 
		dataType : "text" ,
		async : false ,
		success: function(msg){ 
			var msg = (msg);
			if (msg=="0"){				
				$('#checkspan'+typ).html("사용 가능한 "+txt+"입니다");
				$('#checkspan'+typ).fadeOut().fadeIn(200);
				checkvalid = true;
			}else{				
				$('#checkspan'+typ).html(msg);
				$('#checkspan'+typ).fadeOut().fadeIn(200);	
				checkvalid = false; checkstrid=msg;
			}
		}
	});
}

//-->
</script>