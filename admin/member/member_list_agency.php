<?
$searchand .= "and rel_idx = $idx "; 
$cnt = QRY_CNT("agency",$searchand);
$sql = "select a.*, b.mem_id, b.mem_nm_en, b.depart_nm_en,b.reg_date from agency a
		left outer join member b on a.mem_idx = b.mem_idx
		where a.rel_idx = $idx ";		
$conn = dbconn();
$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
$i = 0;
if($cnt>0){
?>
<table width="99%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td height="40" class="rtitle01"><img src="/admin/img/icon_02.gif" width="15" height="15" vspace="3" align="absmiddle" /> 대리점</td>
	</tr>
</table>
<table width="99%" border="0" cellspacing="0" cellpadding="0"  background="/admin/img/boardbar_bg.gif">
	<tr>
		<td width="60"  height="27" align="center" class="btitle01" >번호</td>
		<td align="center" class="btitle01">제조회사</td>
		<td width="150" align="center" class="btitle01">직원ID</td>
		<td width="150" align="center" class="btitle01">직원성명</td>
		<td width="150" align="center" class="btitle01">직책</td>			
		<td width="150" align="center" class="btitle01">등록일</td>
	</tr>
</table>
<?
$ListNO=$cnt-(($page-1)*$recordcnt);

while($row = mysql_fetch_array($result)){
	$i++;
	$agency_idx= replace_out($row["agency_idx"]);
	$agency_name= replace_out($row["agency_name"]);
	$mem_idx= replace_out($row["mem_idx"]);
	$mem_id= replace_out($row["mem_id"]);
	$mem_nm_en= replace_out($row["mem_nm_en"]);
	$depart_nm_en= replace_out($row["depart_nm_en"]);
	$reg_date= replace_out($row["reg_date"]);
?>
<table width="99%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="60" height="27" align="center"><?=$ListNO?></td>
		<td align="center" ><?=$agency_name?></td>
		<td width="150" align="center" ><?=$mem_id?></a></td>
		<td width="150" align="center" ><?=$mem_nm_en?></a></td>
		<td width="150" align="center"><?=$depart_nm_en?></td>	
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