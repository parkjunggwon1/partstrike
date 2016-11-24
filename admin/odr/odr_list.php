<?
include $_SERVER["DOCUMENT_ROOT"]."/admin/include/header.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.odr.php";


$searchand=" and a.odr_no <>''";
if ($strsearch){
	$searchand .= " and $search like '%$strsearch%'";
}

$cnt = QRY_CNT("odr a ",$searchand);
$totalpage = QRY_TOTALPAGE($cnt,$recordcnt);

$c = "a.*, s.mem_idx s_mem_idx, s.mem_nm s_mem_nm ,s.mem_nm_en s_mem_nm_en, s.rel_idx s_rel_idx, s.nation s_nation,b.mem_idx b_mem_idx,b.mem_nm b_mem_nm,b.mem_nm_en b_mem_nm_en, b.rel_idx b_rel_idx, b.nation b_nation";
$tbl = "odr a 
left outer join member s on a.sell_mem_idx = s.mem_idx
left outer join member b on a.mem_idx = b.mem_idx
";



$result =QRY_C_LIST($c,$tbl,$recordcnt,$page,$searchand," a.odr_idx DESC");
?>

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
						<br />
						<table width="99%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td height="40" class="rtitle01"><img src="/admin/img/icon_02.gif" width="15" height="15" vspace="3" align="absmiddle" /> <?=$title_text?></td>
								<td width="100" height="35" class="rtitle01" align="center"><p class="tblue">검색건수 : &nbsp;<?=$cnt?>&#13;</p></td>
								<!--<td align="right" class="btitle02" width="100">								
								<a href="javascript:down_excel('excel')"><span class="btn">엑셀 파일</span></a>
								</td>-->
							</tr>
						</table>
						<!--오른쪽 시작-->
						<form name="f" method="post">
						<input type="hidden" name="typ" value="<?=$typ?>">
						<input type="hidden" name="mode" value="<?=$mode?>">
						<table width="99%" border="0" cellspacing="0" cellpadding="0"  background="/admin/img/boardbar_bg.gif">
							<tr>
								<td width="60" height="27" align="center" class="btitle01" ><input type="checkbox" name="alldelchk" onclick="alldel_chk(this.checked);" ></td>
								<td width="60"  height="27" align="center" class="btitle01" >번호</td>
								<td width="10%"  align="center" class="btitle01">날짜</td>
								<td width="10%"  align="center" class="btitle01">발주번호</td>
								<td width="15%"  align="center" class="btitle01">판매자</td>
								<td width="15%"  align="center" class="btitle01">구매자</td>
								<td align="center" class="btitle01">PartNo/단가/개수</td>
								<td width="10%"  align="center" class="btitle01">총금액</td>
								<td width="5%"  align="center" class="btitle01">진행상황</td>
								<td width="7%"  align="center" class="btitle01">발주서저장</td>								
							</tr>
						</table>						
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
							$idx = replace_out($row["odr_idx"]);
							$odr_idx = replace_out($row["odr_idx"]);
							$odr_det_idx = replace_out($row["odr_det_idx"]);
							$s_mem_idx = replace_out($row["s_mem_idx"]);
							$s_mem_nm = replace_out($row["s_mem_nm"]);
							$s_mem_nm_en = replace_out($row["s_mem_nm_en"]);
							$s_rel_idx = replace_out($row["s_rel_idx"]);
							$s_nation = replace_out($row["s_nation"]);
							$b_mem_idx = replace_out($row["b_mem_idx"]);
							$b_mem_nm = replace_out($row["b_mem_nm"]);
							$b_mem_nm_en = replace_out($row["b_mem_nm_en"]);
							$b_rel_idx = replace_out($row["b_rel_idx"]);
							$b_nation = replace_out($row["b_nation"]);
							$reg_mem_idx= replace_out($row["reg_mem_idx"]);
							$reg_date = substr(replace_out($row["reg_date"]),0,10);
							$odr_status = replace_out($row["odr_status"]);
							if ($odr_status =="0"){
								$odr_history_idx = get_any("odr_history", "max(odr_history_idx)", "odr_idx=$odr_idx");
								//echo $odr_history_idx;
								if ( $odr_history_idx){
									$odr_status = get_any("odr_history","status", "odr_history_idx = $odr_history_idx");
								}
							}
							$odr_no = replace_out($row["odr_no"]);
							$save_yn = replace_out($row["save_yn"]);
						?>
						<table width="99%" border="0" cellspacing="0" cellpadding="0">
							<a href="member_view.php?<?=$param?>&idx=<?=$idx?>" id="go_<?=$idx?>"></a>
							<tr>
								<td width="60"  height="27" align="center"><input type="checkbox" name="delchk[]" value="<?=$idx?>"></td>
								<td width="60" height="27" align="center"><?=$ListNO?></td>
								<td width="10%" align="center"><?=$reg_date?></td>
								<td width="10%" align="center"><a href="/admin/odr/odr_history_list.php?mode=ZZ002&search=a.odr_no&strsearch=<?=$odr_no?>" target="_blank"><?=get_any("odr","odr_no","odr_idx=$odr_idx")?></a></td>
								<td width="15%" align="center"><img src="/kor/images/nation_title2_<?=$s_nation?>.png"> <?=$s_mem_nm_en?><?if ($s_rel_idx!=0){echo " [".get_any("member", "mem_nm_en","mem_idx=$s_rel_idx")."]";}?></td>
								<td width="15%" align="center"><img src="/kor/images/nation_title_<?=$b_nation?>.png"> <?=$b_mem_nm_en?><?if ($b_rel_idx!=0){echo " [".get_any("member", "mem_nm_en","mem_idx=$b_rel_idx")."]";}?></td>
								<td align="center" class="tred" >
								<?
								$tot = 0;
								$sub_searchand = "and odr_idx = $odr_idx";

								if ($odr_det_idx){	$sub_searchand = "and odr_det_idx = $odr_det_idx";}
								$result2 =QRY_ODR_DET_LIST(0,$sub_searchand,0,"","asc");
								$cnt=mysql_num_rows($result2);
								$i = 0;
								while($row2 = mysql_fetch_array($result2)){
									$part_idx= replace_out($row2["a.part_idx"]);
									$part_type= replace_out($row2["part_type"]);
									$part_no= replace_out($row2["part_no"]);
									$odr_quantity= replace_out($row2["odr_quantity"]);
									$price= replace_out($row2["price"]);												
									$tot = $tot + $odr_quantity * $price;
									if ($cnt >1){ $i = $i + 1; }
									$br = $i > 1 ? "<BR><img src='/kor/images/stock_title0".$part_type."_s.gif'> ".$i.".":"<img src='/kor/images/stock_title0".$part_type."_s.gif'> ".$i.".";
									$br = str_replace("0.","",$br);
									?>								
									<?=$br?><u><?=$part_no?></u> &nbsp;&nbsp;$<?=number_format($price,2)?> &nbsp;&nbsp;<?=number_format($odr_quantity)?>
									
								<?}?>
								</td>
								<td width="10%" align="center">$<?=number_format($tot,2)?></td>
								<td width="5%" align="center"><?=GF_Common_GetSingleList("ORD",$odr_status)?></td>
								<td width="7%" align="center"><?=$save_yn?>
								</td>
									
							</tr>
							<tr>
								<td height="1" colspan="10" bgcolor="#dcd8d6"></td>
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

								include $_SERVER["DOCUMENT_ROOT"]."/admin/include/paging_admin.php";

								?>
								</td>
								<td width="120" align="right">
								<!--<span class="btn1"><a href="member_write.php?<?=$param?>">등록</a></span> -->
								<span class="btn1"><a href="javascript:del();">삭제</a></span>&nbsp;
								</td>
							</tr>
						</table>
						<br />
						<form name="searchfrm" method="post" >
						<input type="hidden" name="page" value="<?=$page?>">
						<table width="99%" border="0" cellspacing="0" cellpadding="0" bgcolor="#f0f0f0">
							<tr>
								<td height="40" align="center">
								<select name="search">								
								<option value="a.odr_no" <?If ($search=="a.odr_no") {?> selected <? } ?>>발주번호</option>
								<option value="s_mem_nm" <?If ($search=="s_mem_nm") {?> selected <? } ?>>판매자명</option>
								<option value="b_mem_nm" <?If ($search=="b_mem_nm") {?> selected <? } ?>>구매자명</option>
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
			document.f.typ.value = "alldel";
			document.f.action = "odr_proc.php?<?=$param?>";
			document.f.encoding = "multipart/form-data";
			document.f.submit();			
		}
	}


//-->
</script>

