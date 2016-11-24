<?
$searchand=" and rel_idx='$idx' ";
$cnt = QRY_CNT("impship",$searchand);
$totalpage = QRY_TOTALPAGE($cnt,$recordcnt);

$result =QRY_LIST(" impship ","all",$page,$searchand," impship_idx DESC");
if ($cnt>0){
?>
<table width="99%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td height="40" class="rtitle01"><img src="/admin/img/icon_02.gif" width="15" height="15" vspace="3" align="absmiddle" /> 수입선적정보</td>
	</tr>
</table>
<table width="99%" border="0" cellspacing="0" cellpadding="0"  background="/admin/img/boardbar_bg.gif">
	<tr>
		<td width="60"  height="27" align="center" class="btitle01" >번호</td>
		<td align="center" class="btitle01">운송회사</td>
		<td width="150"  align="center" class="btitle01">Account No.</td>
	</tr>
</table>
<?
$ListNO=$cnt-(($page-1)*$recordcnt);
$i=0;
while($row = mysql_fetch_array($result)){
	$i++;
	$impship_idx= replace_out($row["impship_idx"]);
	$company_idx= replace_out($row["company_idx"]);
	$account_no= replace_out($row["account_no"]);
	$order= replace_out($row["order"]);
?>
<table width="99%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="60" height="27" align="center"><?=$ListNO?></td>
		<td align="center" ><img src="/kor/images/delivery_bn<?=$company_idx?>.gif" alt=""/></td>
		<td width="150" align="center" ><?=$account_no?></td>
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
