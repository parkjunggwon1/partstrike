<?
include $_SERVER["DOCUMENT_ROOT"]."/admin/include/header.php";
if ($search){
	$searchand = " and nation = '$search'";
}
$cnt = QRY_CNT("exchange",$searchand);
$totalpage = QRY_TOTALPAGE($cnt,$recordcnt);
$searchand .= " and a.admin_idx=b.admin_idx ";

$result =QRY_C_LIST(" a.*,b.admin_name,b.admin_pos"," exchange a, admin b",$recordcnt,$page,$searchand," idx desc");

?>
<script type="text/javascript">
<!--

	function check(obj,typ,txt){
		var f = eval("document."+obj);
		if (nullchk_admin(f.exchange_out,"전신환 매도율 선택하세요.")== false) return ;
		if (nullchk_admin(f.exchange_in,"전신환 매입율 입력하세요.")== false) return ;
		
		f.typ.value=typ;
		f.target = "_self";
		f.action = "/admin/agency/exchange_proc.php";
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
								<td height="40" class="rtitle01"><img src="/admin/img/icon_02.gif" width="15" height="15" vspace="3" align="absmiddle" />   <?=$title_text?></td>
								<td width="100" height="35" class="rtitle01" align="center"><p class="tblue">검색건수 : &nbsp;<?=$cnt?>&#13;</p></td>
								<!--<td align="right" class="btitle02" width="100">								
								<a href="javascript:down_excel('excel')"><span class="btn">엑셀 파일</span></a>
								</td>-->
							</tr>
						</table>
						<!--오른쪽 시작-->
						<form name="f" method="post">
						<input type="hidden" name="typ" value="">
						<input type="hidden" name="mode" value="<?=$mode?>">
						<table width="99%" border="0" cellspacing="0" cellpadding="0" background="/admin/img/boardbar_bg.gif">
							<tr>
								<td width="250" height="27" align="center" class="btitle01">전신환 매도율(보내실 때)</td>
								<td width="250" align="center" class="btitle01">전신환 매입율(받으실 때)</td>
								<td width="250" align="center" class="btitle01">저장</td>
							</tr>
						</table>	
						<table width="99%" border="0" cellspacing="0" cellpadding="0">
							<tr>								
								<td width="180" align="center">US$1.00   =
<input name="exchange_out" type="text" maxlength="10" value="<?=$exchange_out?>" class="inputtext">원</td>
								<td width="180" align="center">US$1.00   =
<input name="exchange_in" type="text" maxlength="10" value="<?=$exchange_in?>" class="inputtext">원</td>

								<td width="180" align="center"><span class="btn1"><a href="javascript: check('f','write','저장');">저장</a></span></td>
							</tr>
							<tr>
								<td height="1" colspan="9" bgcolor="#dcd8d6"></td>
							</tr>
						</table>
						</form>
						<br>
						<table width="99%" border="0" cellspacing="0" cellpadding="0" background="/admin/img/boardbar_bg.gif">
							<tr>
								<td width="70" align="center" class="btitle01">번호</td>
								<td width="250" height="27" align="center" class="btitle01">전신환 매도율(보내실 때)</td>
								<td width="250" align="center" class="btitle01">전신환 매입율(받으실 때)</td>
								<td width="250" align="center" class="btitle01">담당자/직함</td>
								<td width="150" align="center" class="btitle01">등록일</td>
							</tr>
						</table>					
						<!--일반게시글 시작-->
						<?
						if ($cnt==0){
						?>
						<table width="99%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td height="50" align="center">등록 된 자료가 없습니다</td>
							</tr>
							<tr>
								<td height="1" colspan="9" bgcolor="#dcd8d6"></td>
							</tr>
						</table>
						<?
						}
						$ListNO=$cnt-(($page-1)*$recordcnt);

						while($row = mysql_fetch_array($result)){
							$idx = replace_out($row["idx"]);
							$exchange_out = replace_out($row["exchange_out"]);
							$exchange_in = replace_out($row["exchange_in"]);
							$reg_date = replace_out($row["reg_date"]);
							$admin_name = replace_out($row["admin_name"]);
							$admin_pos = replace_out($row["admin_pos"]);
						?>
						<table width="99%" border="0" cellspacing="0" cellpadding="0">
							<tr>								
								<td height="35" width="70" align="center"><?=$ListNO?></td>
								<td width="250" align="center"><?=number_format($exchange_out,2)?></td>
								<td width="250" align="center"><?=number_format($exchange_in,2)?></td>
								<td width="250" align="center"><?=$admin_name?>/<?=$admin_pos?></td>
								<td width="150" align="center"><?=$reg_date?></td>
							</tr>
							<tr>
								<td height="1" colspan="9" bgcolor="#dcd8d6"></td>
							</tr>
						</table>
						</form>
						<? 
							$ListNO--;
						} 
						?>
						<br>
						<table width="99%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td height="40" align="center">
								<?
								$addpara = "";
								$pageurl = "tax_list.php";

								include $_SERVER["DOCUMENT_ROOT"]."/admin/include/paging_admin.php";

								?>
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
