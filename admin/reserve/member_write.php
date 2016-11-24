<?
$mode = $_REQUEST['mode'];
$idx = $_REQUEST['idx'];
$page = $_REQUEST['page'];

$search = $_REQUEST['search'];
$strsearch = $_REQUEST['strsearch'];

include $_SERVER["DOCUMENT_ROOT"]."/admin/include/header.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.member.php";

if ($strsearch){
	$searchand .= " and $search like '%$strsearch%'";
}
 
if ($idx){
	$result = QRY_MEMBER_VIEW("idx",$idx);
	$row = mysql_fetch_array($result);
	$idx = replace_out($row["mem_idx"]);	
	$mem_name = replace_out($row["mem_name"]);
	$mem_sex = replace_out($row["mem_sex"]);
	$mem_birthday = replace_out($row["mem_birthday"]);
	$mem_gubun = replace_out($row["mem_gubun"]);			
	$mem_id = replace_out($row["mem_id"]);
	$mem_pwd = replace_out($row["mem_pwd"]);
	$mem_nickname = replace_out($row["mem_nickname"]);
	$mem_mail1 = replace_out($row["mem_mail1"]);
	$mem_mail2 = replace_out($row["mem_mail2"]);
	$mem_photo = replace_out($row["mem_photo"]);
	$mem_level = replace_out($row["mem_level"]);
	$mem_class = replace_out($row["mem_class"]);
	$mem_board_num = replace_out($row["mem_board_num"]);
	$mem_comm_num = replace_out($row["mem_comm_num"]);
	$reg_date = replace_out($row["reg_date"]);
	$edit_date = replace_out($row["edit_date"]);
	$login_date = replace_out($row["login_date"]);
	$typ = "edit";

}else{           
	$typ = "write";
}

?>

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
						<iframe name="imgdelifr" id="imgdelifr" src="" width="500" height="100" frameborder="0" title="이미지 삭제 프로시져 프레임"></iframe>						
						<form name="f" method="post">
						<input type="hidden" name="mode" value="<?=$mode?>">
						<input type="hidden" name="typ" value="<?=$typ?>">
						<input type="hidden" name="idx" value="<?=$idx?>">
						<input type="hidden" name="filecnt" value="1">
						<input type="hidden" name="temp_file" value="" title="단수이미지 삭제">
						<input type="hidden" name="path" value="<?=$file_path?>" title="이미지 삭제 경로">	
						<table width="99%" border="0" cellspacing="1" cellpadding="5" bgcolor="#e6e6e6">
							<tr>
								<td align="center" bgcolor="#f6f6f6" class="btitle02">이름</td>
								<td bgcolor="#FFFFFF"><input name="mem_name" type="text" value="<?=$mem_name?>"  class="inputtext" style="width:150px;"></td>
							</tr>	
							<tr>
								<td align="center" bgcolor="#f6f6f6" class="btitle02">성별</td>
								<td bgcolor="#FFFFFF"><input type="radio" name="mem_sex" value="M" <?if($mem_sex=="M" or $mem_sex==""){?>checked<?}?>>남자
								<input type="radio" name="mem_sex" value="F" <?if($mem_sex=="F"){?>checked<?}?>>여자
								</td>
							</tr>	
							<tr>
								<td align="center" bgcolor="#f6f6f6" class="btitle02">생년월일</td>
								<td bgcolor="#FFFFFF"><input name="mem_birthday" type="text" value="<?=$mem_birthday?>"  class="inputtext" style="width:150px;"></td>
							</tr>
							<tr>
								<td align="center" bgcolor="#f6f6f6" class="btitle02">아이디</td>
								<td bgcolor="#FFFFFF">
								<?if ($typ=="write") {?>
								<input name="mem_id" type="text" value="<?=$mem_id?>"  class="inputtext" style="width:150px;" onblur="checkid('id',this.value,'아이디');" >
								<font color="#FF0000" id="checkspanid"> </font><br>
								* 6자 이상, 12자 이하/ 영문, 숫자만 사용 가능합니다.
								<?} else {?>
								<?=$mem_id?>
								<?}?>
								</td>
							</tr>

							<tr>
								<td align="center" bgcolor="#f6f6f6" class="btitle02">비밀번호</td>
								<td bgcolor="#FFFFFF"><input name="mem_pwd" type="password" value="<?=$mem_pwd?>"  class="inputtext" style="width:150px;"  onblur="checkid('pwd',this.value,'비밀번호');" >
								<font color="#FF0000" id="checkspanpwd"> </font><br>
								* 비밀번호는 6~12자 사이의 영문, 숫자로 조합된 문자로 입력하세요</td>
							</tr>
							<tr>
								<td align="center" bgcolor="#f6f6f6" class="btitle02">비밀번호확인</td>
								<td bgcolor="#FFFFFF"><input name="mem_pwd2" type="password" value="<?=$mem_pwd?>"  class="inputtext" style="width:150px;" >
								<br>
								* 비밀번호와 같게 입력하세요</td>
							</tr>
							<tr>
								<td align="center" bgcolor="#f6f6f6" class="btitle02">닉네임</td>
								<td bgcolor="#FFFFFF"><input name="mem_nickname" type="text"  value="<?=$mem_nickname?>"  class="inputtext" style="width:150px;"  onblur="checkid('nickname',this.value,'닉네임');">
								<font color="#FF0000" id="checkspannickname"> </font><br>
								* 2자 이상 10자 이하로 입력하셔야 합니다</td>
							</tr>	
							<tr>
								<td align="center" bgcolor="#f6f6f6" class="btitle02">이메일</td>
								<td bgcolor="#FFFFFF">
									<input name="mem_mail1" type="text" style="width:200px;" value="<?=$mem_mail1?>" class="inputtext" onblur="checkid('email','','이메일');">
									@
									<select name="mem_mail2"    id="select" onchange="checkid('email','','이메일');" >
									<option value="hanmail.net"  <?if( $mem_mail2 == "hanmail.net" ){?> selected <?} ?>  >hanmail.net</option>
									<option value="yahoo.co.kr"  <?if( $mem_mail2 == "yahoo.co.kr" ){?> selected <?} ?>     >yahoo.co.kr</option>
									<option value="naver.com"    <?if( $mem_mail2 == "naver.com" ){?> selected <?} ?>              >naver.com</option>
									<option value="nate.com"      <?if( $mem_mail2 == "nate.com" ){?> selected <?} ?>            >nate.com</option>
									<option value="lycos.co.kr"    <?if( $mem_mail2 == "lycos.co.kr" ){?> selected <?} ?>              >lycos.co.kr</option>
									<option value="hanmir.com"     <?if( $mem_mail2 == "hanmir.com" ){?> selected <?} ?>             >hanmir.com</option>
									<option value="netian.com"     <?if( $mem_mail2 == "netian.com" ){?> selected <?} ?>             >netian.com</option>
									<option value="dreamwiz.com"   <?if( $mem_mail2 == "dreamwiz.com" ){?> selected <?} ?>               >dreamwiz.com</option>
									<option value="hotmail.com"   <?if( $mem_mail2 == "hotmail.com" ){?> selected <?} ?>               >hotmail.com</option>
									<option value="korea.com"     <?if( $mem_mail2 == "korea.com" ){?> selected <?} ?>             >korea.com</option>
									<option value="empal.com"     <?if( $mem_mail2 == "empal.com" ){?> selected <?} ?>             >empal.com</option>
									<option value="hanafos.com"    <?if( $mem_mail2 == "hanafos.com" ){?> selected <?} ?>              >hanafos.com</option>
									<option value="chol.com"       <?if( $mem_mail2 == "chol.com" ){?> selected <?} ?>           >chol.com</option>
									<option value="unitel.co.kr"   <?if( $mem_mail2 == "unitel.co.kr" ){?> selected <?} ?>               >unitel.co.kr</option>
									<option value="arreo.com"      <?if( $mem_mail2 == "arreo.com" ){?> selected <?} ?>            >arreo.com</option>
									<option value="netsgo.com"     <?if( $mem_mail2 == "netsgo.com" ){?> selected <?} ?>             >netsgo.com</option>
									<option value="kornet.net"     <?if( $mem_mail2 == "kornet.net" ){?> selected <?} ?>             >kornet.net</option>
									<option value="freechal.com"   <?if( $mem_mail2 == "freechal.com" ){?> selected <?} ?>               >freechal.com</option>
									<option value="paran.com"     <?if( $mem_mail2 == "paran.com" ){?> selected <?} ?>             >paran.com</option>
									<option value="empas.com"    <?if( $mem_mail2 == "empas.com" ){?> selected <?} ?>              >empas.com</option>
									<option value="gmail.com"    <?if( $mem_mail2 == "gmail.com" ){?> selected <?} ?>              >gmail.com</option>
									</select>
								<font color="#FF0000" id="checkspanemail"> </font><br>
								* 올바른형식의 이메일을 입력하세요. 아이디/비밀번호 분실시 찾을 수 있습니다.</td>
							</tr>
							<tr>
								<td align="center" bgcolor="#f6f6f6" class="btitle02">사진</td>
								<td bgcolor="#FFFFFF">
								<?if($mem_photo){?><img src="<?=$file_path.$mem_photo?>" width="100"><br>
								<input type="button" value="첨부파일 삭제" onclick="img_del('<?=$idx?>','<?=$mem_photo?>','');"><br>
								<?}?>
								<input name="file0" type="file"  value="<?=$mem_photo?>"  class="inputtext"></td>
							</tr>	
							<tr>
								<td align="center" bgcolor="#f6f6f6" class="btitle02">등급</td>
								<td bgcolor="#FFFFFF">
								<select name="mem_level">
									<?
									$codesql = "SELECT * FROM code WHERE gubun='XX001' order by code DESC";
									$coderesult=mysql_query($codesql,$conn) or die ("SQL ERROR : ".mysql_error());
									
									while($coderow = mysql_fetch_array($coderesult)){
										$level_code = replace_out($coderow["code"]);
										$level_title = replace_out($coderow["title"]);
									?>
									<option value="<?=$level_code?>" <?if($mem_level==$level_code){?>selected<?}?>><?=$level_title?></option>
									<? } ?>
								</select></td>
							</tr>
							<tr>
								<td align="center" bgcolor="#f6f6f6" class="btitle02">회원구분</td>
								<td bgcolor="#FFFFFF">
								<input type="radio" name="mem_class" value="1" <?if($mem_class=="1" or $mem_class==""){?>checked<?}?>>준회원
								<input type="radio" name="mem_class" value="2" <?if($mem_class=="2"){?>checked<?}?>>정회원</td>
							</tr>
							<?if ($typ=="edit"){?>
							<tr>
								<td align="center" bgcolor="#f6f6f6" class="btitle02">게시글갯수</td>
								<td bgcolor="#FFFFFF"><input name="mem_board_num" type="text" value="<?=$mem_board_num?>"  class="inputtext" style="width:150px;"></td>
							</tr>
							<tr>
								<td align="center" bgcolor="#f6f6f6" class="btitle02">댓글갯수</td>
								<td bgcolor="#FFFFFF"><input name="mem_comm_num" type="text" value="<?=$mem_comm_num?>"  class="inputtext" style="width:150px;"></td>
							</tr>
							<tr>
								<td align="center" bgcolor="#f6f6f6" class="btitle02">가입일시</td>
								<td bgcolor="#FFFFFF"><input name="reg_date" type="text" value="<?=$reg_date?>"  class="inputtext" style="width:150px;"></td>
							</tr>
							<tr>
								<td align="center" bgcolor="#f6f6f6" class="btitle02">수정일시</td>
								<td bgcolor="#FFFFFF"><input name="edit_date" type="text" value="<?=$edit_date?>"  class="inputtext" style="width:150px;"></td>
							</tr>
							<tr>
								<td align="center" bgcolor="#f6f6f6" class="btitle02">마지막로그인일시</td>
								<td bgcolor="#FFFFFF"><input name="login_date" type="text" value="<?=$login_date?>"  class="inputtext" style="width:150px;"></td>
							</tr>
							<?}?>
						</form>
						</table>
						
						<br />
						<table width="99%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td height="40" align="center" class="rtitle01">
								<span class="btn1"><a href="javascript:check();">확인</a></span>
								<?If( $typ=="edit"){?><span class="btn1"><a href="javascript:del();">삭제</a></span><?}?>
								<span class="btn1"><a href="member_list.php?<?=$param?>">목록</a></span>
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


<script language="javascript">
<!--
var typ = "<?=$typ?>";
if (typ=="write"){
	var checkvalid = false;
	var checkvalpwd = false;
	var checkvalnickname = false;
	var checkvalemail = false;		
}else{
	var checkvalpwd = true;
	var checkvalnickname = true;
	var checkvalemail = true;
}
var checkstrid = "";
var checkstrpwd = "";
var checkstrnickname = "";
var checkstremail = "";

function checkid(typ,val,txt){
	if (typ=="email"){
		val=document.f.mem_mail1.value+"@"+document.f.mem_mail2.value;
	}
	//"/ajax/checkid.asp?id="+id
	$('#checkspan'+typ).html("");
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
				if(typ=='id') checkvalid = true;
				if(typ=='pwd') checkvalpwd = true;
				if(typ=='nickname') checkvalnickname = true;
				if(typ=='email') checkvalemail = true;
			}else{				
				$('#checkspan'+typ).html(msg);
				$('#checkspan'+typ).fadeOut().fadeIn(200);	
				if(typ=='id') checkvalid = false; checkstrid=msg;
				if(typ=='pwd') checkvalpwd = false; checkstrpwd=msg;
				if(typ=='nickname') checkvalnickname = false; checkstrnickname=msg;
				if(typ=='email') checkvalemail = false; checkstremail=msg;			
			}
		}
	});
}


//-->
</script>	
<script type="text/javascript">
<!--
	
	function check(){
		var f =  document.f;
		var typ="<?=$typ?>";
		
		if (trim(f.mem_name.value)==""){
			alert("이름을 입력해주세요.");
			f.mem_name.focus();
			return;
		}
		if (typ=="write"){
			checkid('id',f.mem_id.value,'아이디');
			if (checkvalid!=true){
				alert("아이디를 확인하세요");
				f.mem_id.focus();
				return;
			}	
		}
		
		
		checkid('pwd',f.mem_pwd.value,'비밀번호');
		if (checkvalpwd!=true){
			alert("비밀번호를 확인하세요");
			f.mem_pwd.focus();
			return;
		}

		if (trim(f.mem_pwd2.value)=="" || trim(f.mem_pwd.value)!=trim(f.mem_pwd2.value)){
			alert("비밀번호와 같게 입력하세요.");
			f.mem_pwd2.focus();
			return;
		}

		checkid('nickname',f.mem_nickname.value,'닉네임');
		if (checkvalnickname!=true){
			alert("닉네임을 확인하세요");
			f.mem_nickname.focus();
			return;
		}
		checkid('email','','이메일');
		if (checkvalemail!=true){
			alert("이메일을 확인하세요");
			f.mem_email.focus();
			return;
		}

		
		f.encoding = "multipart/form-data";
		f.action = "member_proc.php?<?=$param?>"
		f.submit();
	}
	
	function del(){
		if (confirm("삭제하시겠습니까?")==true){http://samlotto.co.kr/admin/member/member_list.php?mode=YY001
			document.f.typ.value = "del";
			document.f.action = "member_proc.php?<?=$param?>";
			document.f.encoding = "multipart/form-data";
			document.f.submit();
			
		}
	}

	function img_del(id,file,num){
		if (confirm("파일을 삭제하시겠습니까? ")==true){
			document.f.temp_file.value = file;
			document.f.target = "imgdelifr";
			document.f.action ="/include/filedelete1.php?mode=YY001&file_idx="+id+"&num="+num;
			document.f.submit();
		}
	}
//-->
</script>