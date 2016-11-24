<?
$mode = $_REQUEST['mode'];
$page = $_REQUEST['page'];
$search = $_REQUEST['search'];
$strsearch = $_REQUEST['strsearch'];

include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.part.php";
include $_SERVER["DOCUMENT_ROOT"]."/admin/include/header.php";
if ($strsearch){
	$searchand = " and $search like '%$strsearch%'";
}
if ($cate==""){
	$cate = "1";
}
$recordcnt =100;
$searchand .= "and part_type =$cate "; 
$c = "a.*,b.mem_id";
$tbl = "part a left outer join member b on a.mem_idx = b.mem_idx";
$cnt = QRY_CNT($tbl,$searchand);							
$totalpage = QRY_TOTALPAGE($cnt,$recordcnt);
$result =QRY_C_LIST($c,$tbl,$recordcnt,$page,$searchand," a.part_idx DESC");

?>

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
						<?$part_type ="3"?>
						<form name="f" method="post">
						<table  border="0" cellspacing="1" cellpadding="1" align="left">
							<tr><?for ($i = 1; $i<=6; $i++){
							echo "<td class='".($cate==$i?"teduri":"")."'><img src='/kor/images/stock_title0".$i."_s.gif' onclick='ChgCate(".$i.");' style='cursor:pointer;'></td> ";
						}?></td></tr></table><br><br><br>
						<input type="hidden" name="typ" value="<?=$typ?>">
						<input type="hidden" name="typaaa" value="한글">
						<table width="99%" border="0" cellspacing="0" cellpadding="0" background="/admin/img/boardbar_bg.gif">
							<tr>
								<td width="60" height="27" align="center" class="btitle01" ><input type="checkbox" name="alldelchk" onclick="alldel_chk(this.checked);" ></td>	
								<td width="60" height="27" align="center" class="btitle01" >번호</td>
								<td width="150" align="center" class="btitle01">등록자 ID</td>
								<td width="150" align="center" class="btitle01">PART NO</td>
								<td  align="center" class="btitle01">Manufacturer</td>
								<td width="100" align="center" class="btitle01">Package</td>
								<td width="80" align="center" class="btitle01">D/C</td>
								<td width="80" align="center" class="btitle01">RoHS</td>
								<td width="100" align="center" class="btitle01">Q'ty</td>
								<td width="100" align="center" class="btitle01">Unit Price</td>
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
						<?}
						$ListNO=$cnt-(($page-1)*$recordcnt);
						while($row = mysql_fetch_array($result)){
							$part_idx= replace_out($row["part_idx"]);
							$part_no= replace_out($row["part_no"]);
							$manufacturer= replace_out($row["manufacturer"]);
							$package= replace_out($row["package"]);
							$dc= replace_out($row["dc"]);
							$rhtype= replace_out($row["rhtype"]);
							$quantity= replace_out($row["quantity"]);
							$price= replace_out($row["price"]);
							$turnkey_idx= replace_out($row["turnkey_idx"]);
							$mem_idx= replace_out($row["mem_idx"]);
							$mem_id= replace_out($row["mem_id"]);
							
						?>
						<table width="99%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="60" height="27" align="center"><input type="checkbox" name="delchk[]" value="<?=$part_idx?>"></td>
								<td width="60" align="center"><?=$ListNO?></td>	
								<td  width="150"align="center"><?=$mem_id?></td>
								<td width="150" align="center"><?=$part_no?></td>
								<td align="center"><?=$manufacturer?></td>
								<td width="100" align="center"><?=$package?></td>
								<td width="80" align="center"><?=$dc?></td>
								<td width="80" align="center"><?=$rhtype?></td>
								<td width="100" align="center"><?=$quantity==0?"":number_format($quantity)?></td>
								<td width="100" align="center">$<?=number_format($price,2)?></td>
							</tr>
							<tr>
								<td height="1" colspan="15" bgcolor="#dcd8d6"></td>
							</tr>
						</table>
						<? 
							$ListNO--;
						} 
						?>
						</form>
						<br>
						<table width="99%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<Td width=120>&nbsp;</td>
								<td height="40" align="center">
								<?
								$addpara = "";
								$pageurl = "part_list.php";

								include $_SERVER["DOCUMENT_ROOT"]."/admin/include/paging_admin.php";

								?>
								</td>
								<td width="120" align="right"><!--<span class="btn1"><a href="part_write.php?mode=<?=$mode?>&page=<?=$page?>">등록</a></span>-->
								<span class="btn1"><a href="javascript:del();">삭제</a></span>&nbsp; <!-- <?=$mode?><?=$page?><?=$cnt?> -->
								</td>
							</tr>
						</table>
						<br />
						<form name="searchfrm" method="post" action="part_list.php">
						<input type="hidden" name="mode" value="<?=$mode?>">
						<input type="hidden" name="cate" value="<?=$cate?>">
						<input type="hidden" name="page" value="<?=$page?>">
						<table width="99%" border="0" cellspacing="0" cellpadding="0" bgcolor="#f0f0f0">
							<tr>
								<td height="40" align="center">
								<select name="search">								
								<option value="mem_id" <?If ($search=="mem_id") {?> selected <? } ?>>등록자 ID</option>
								<option value="part_no" <?If ($search=="part_no") {?> selected <? } ?>>PART NO</option>
								
								</select>
								<input type='text' name="strsearch" size='30' maxlength ='20' value="<?=$strsearch?>" onKeyPress="check_key(check_search);" style="font-size:9pt;height:21px;">	
								<span class="btn1"><a href="javascript:check_search();">SEARCH</a></span>
								</td>
							</tr>
						</table>
						</form>
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
<script type="text/javascript">
<!--
	function del(){
		if (confirm("삭제하시겠습니까?")==true){
			document.f.typ.value = "allpartdel";
			document.f.action = "board_proc.php?<?=$param?>";
			document.f.encoding = "multipart/form-data";
			document.f.submit();			
		}
	}
	function ChgCate(idx){
		document.searchfrm.cate.value=idx;
		check_search();
	}
//-->
</script>
