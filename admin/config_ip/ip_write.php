<?
include $_SERVER["DOCUMENT_ROOT"]."/admin/include/header.php";

$sql = "select * from config_ip";
$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
$row = mysql_fetch_array($result);

?>
<script type="text/javascript" src="/admin/SE_/js/HuskyEZCreator.js" charset="utf-8"></script>
<script type="text/javascript" src="/include/calendar.js"></script>
<script type="text/javascript">
<!--
	function check(){
		var f =  document.f;

		if (trim(f.cf_intercept_ip.value)==""){
			alert("IP를 입력해주세요.");
			f.cf_intercept_ip.focus();
			return;
		}

		f.action = "ip_proc.php?<?=$param?>"
		f.submit();
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
								<td height="40" class="rtitle01"><img src="/admin/img/icon_02.gif" width="15" height="15" vspace="3" align="absmiddle" /> IP차단관리</td>
							</tr>
						</table>
											
						<form name="f" method="post">
						<input type="hidden" name="mode" value="<?=$mode?>">

						<table width="99%" border="0" cellspacing="1" cellpadding="5" bgcolor="#e6e6e6">

							<tr>
								<td width="150" align="center" bgcolor="#f6f6f6" class="btitle02">접근차단 IP</td>
								<td bgcolor="#FFFFFF">
									<textarea class=ed name='cf_intercept_ip' rows='5' style='width:99%;'><?=$row[cf_intercept_ip]?> </textarea><br>입력된 IP의 컴퓨터는 접근할 수 없음.<br>123.123.+ 도 입력 가능. (엔터로 구분)
								</td>
							</tr>
							
						</form>
						</table>
						
						<br />
						<table width="99%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td height="40" align="center" class="rtitle01">
								<span class="btn1"><a href="javascript:check();">확인</a></span>
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