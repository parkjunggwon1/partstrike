<?if ($_SESSION["ADMIN_ID"]==""){ ?>
<script language="javascript">
<!--
alert("관리자 세션이 끊겼습니다. 다시 로그인 해주세요.");
location.href="/admin/index.php"
//-->
</script>
<? } ?>