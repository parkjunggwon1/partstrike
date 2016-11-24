<?
$mode = $_REQUEST['mode'];
$page = $_REQUEST['page'];

$search = $_REQUEST['search'];
$strsearch = $_REQUEST['strsearch'];


include $_SERVER["DOCUMENT_ROOT"]."/admin/include/header.php";
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td height="30" background="/admin/img/now_bg.gif" style="padding-left: 20px" class="now"><img src="/admin/img/icon.gif" width="9" height="7" /> HOME &gt; 제품 &gt; 제품 중분류 관리</td>
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
						<br />
						<table width="99%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td height="40" class="rtitle01"><img src="/admin/img/icon_02.gif" width="15" height="15" vspace="3" align="absmiddle" />   제품 중분류 관리</td>
								<td width="100" height="35" class="rtitle01" align="center"></td>
								<!--<td align="right" class="btitle02" width="100">								
								<a href="javascript:down_excel('excel')"><span class="btn">엑셀 파일</span></a>
								</td>-->
							</tr>
						</table>
						<!--오른쪽 시작-->
						<table width="99%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td>
								<table align="" width="865" border="0" cellspacing="0" cellpadding="0"  background="/admin/img/boardbar_bg.gif">
									<tr>
										<td width="330" height="27" align="center" class="btitle01" ><?=GF_Productty_SetComboList("gubun","True",  "== 제품 종류 선택 ==",  $gubun, "")?></td>
										<td width="430" align="center" class="btitle01">중분류 상세정보</td>
									</tr>
								</table>
								</td>
							</tr>
						</table>
						<table width="99%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td>
								<table align="" width="865" border="0" cellspacing="0" cellpadding="0" >
									<tr>
										<td width="200" style="border-right:1px solid #bbbbbb;border-left:1px solid #bbbbbb;"><iframe src="cate1.php?gubun=<?=$gubun?>" name="cate1" id="cate1" width="330" height="500" frameborder=0 scrolling="no"></iframe></td>	
										<td width="1" bgcolor="#000000"></td>
										<td width="400" style="border-right:1px solid #bbbbbb;"><iframe src="cate2.php" name="cate2" id="cate2" width="530" height="500" frameborder=0 scrolling="no"></iframe></td>
										<td width="1" bgcolor="#000000"></td>
									</tr>
									<tr>
									  <td height="1" colspan="7" bgcolor="#dcd8d6"></td>
									</tr>
								</table>
								</td>
							</tr>
						</table>
						<br>
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
				</table>
				</td>
			</tr>
		</table>
		</td>
	</tr>
</table>
<?
include $_SERVER["DOCUMENT_ROOT"]."/admin/include/footer.php";
?>

<script language="javascript">
jQuery(function ($) {		
		$("select[name=gubun]").change(function(e){	
			document.cate1.location.href="cate1.php?gubun="+$(this).val();			
		});		
});
</script>
