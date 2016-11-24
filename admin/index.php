<?
include $_SERVER["DOCUMENT_ROOT"]."/admin/include/header_index.php";

?>
<script type="text/javascript">
<!--	
	function check(){
		var f=document.f;
		if(trim(f.adminid.value)==""){
			alert("아이디를 입력해주세요.");
			f.adminid.focus();
			return;
		}
		if(trim(f.adminpwd.value)==""){
			alert("비밀번호를 입력해주세요.");
			f.adminpwd.focus();
			return;
		}
		f.target = "proc"
		f.action = "log_ok.php"
		f.submit();		
	}
	
//-->
</script>
<iframe name="proc" id="proc" src="" width="500" height="0" frameborder="0"></iframe>
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
<form name="f" method="post">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="335" align="center" background="img/loginbg02.gif"><table width="500" height="335" border="0" cellspacing="0" cellpadding="0" background="img/loginbg.gif">
          <tr>
            <td height="133">&nbsp;</td>
          </tr>
          <tr>
            <td align="right" valign="top"><!--로그인 테이블시작-->
              <table width="330" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td height="24"><input name="adminid" type="text" onkeypress="check_key(check);" class="" style="width:150; border-width:0; border-style:solid; border-color:#d4d4d4; background-color:#d4d4d4; font-size: 9pt;font-color:#000000"></td>
                  <td width="140" rowspan="2"><a href="javascript:check();"><img src="img/btn_login.gif" alt="" width="118" height="58" border="0"></a></td>
                </tr>
                <tr>
                  <td height="40"><input name="adminpwd" type="password" onkeypress="check_key(check);" class="" style="width:150; border-width:0; border-style:solid; border-color:#d4d4d4; background-color:#d4d4d4; font-size: 9pt;font-color:#000000"></td>
                </tr>
              </table>
              <!--로그인 테이블 끝-->
              <table width="450" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td height="24">&nbsp;</td>
                </tr>
                <tr>
                  <td align="right" style="padding-right:10">사이트 관리자 페이지로 접속하기 위한 관리자 로그인 페이지입니다.<br>
                    관리자 아이디와 관리자 비밀번호를 입력하여 주시기기 바랍니다.</td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td height="72">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
 <form>
</table>
