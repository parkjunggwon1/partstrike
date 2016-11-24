
<?
$searchand=" and rel_idx='$idx' ";
$cnt = QRY_CNT("member",$searchand);
$totalpage = QRY_TOTALPAGE($cnt,$recordcnt);

$result =QRY_LIST(" member ","all",$page,$searchand," mem_idx DESC");
if ($cnt>0){

?>
<table width="99%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td height="40" class="rtitle01"><img src="/admin/img/icon_02.gif" width="15" height="15" vspace="3" align="absmiddle" /> 직원</td>
	</tr>
</table>
<table width="99%" border="0" cellspacing="0" cellpadding="0"  background="/admin/img/boardbar_bg.gif">
	<tr>
		<td width="60"  height="27" align="center" class="btitle01" >번호</td>
		<td align="center" class="btitle01">직원ID</td>
		<td width="150"  align="center" class="btitle01">직원성명</td>
		<td width="100"  align="center" class="btitle01">부서</td>	
		<td width="100"  align="center" class="btitle01">직책</td>			
		<td width="150"  align="center" class="btitle01">등록일</td>
	</tr>
</table>
<?
$ListNO=$cnt-(($page-1)*$recordcnt);

while($row = mysql_fetch_array($result)){
	$mem_idx = replace_out($row["mem_idx"]);
	$mem_id = replace_out($row["mem_id"]);
	$mem_nm = replace_out($row["mem_nm_en"]);
	$depart_nm = replace_out($row["depart_nm_en"]);
	$pos_nm = replace_out($row["pos_nm_en"]);
	$hp = replace_out($row["hp"]);
	$reg_date = replace_out($row["reg_date"]);
?>
<table width="99%" border="0" cellspacing="0" cellpadding="0">
	<a href="javascript:win_open('member_popup.php?idx=<?=$mem_idx?>', 'member', '850', '530', '', '', '', '1')" id="go_<?=$mem_idx?>"></a>
	<tr>
		<td width="60" height="27" align="center"><?=$ListNO?></td>
		<td align="center" ><a href="#" onclick="gogo('<?=$mem_idx?>')"><?=$mem_id?></a></td>
		<td width="150" align="center" ><a href="#" onclick="gogo('<?=$mem_idx?>')"><?=$mem_nm?></a></td>
		<td width="100" align="center"><?=$depart_nm?></td>	
		<td width="100" align="center"><?=$pos_nm?></td>
		<td width="150" align="center"><?=$reg_date?></td>
	</tr>
	<tr>
		<td height="1" colspan="10" bgcolor="#dcd8d6"></td>
	</tr>
</table>
<? 
	$ListNO--;
} 
}

?>
<br>