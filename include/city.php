<?
include  $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?

$c=" a.CODE,a.name as countryname,b.district,b.name as cityname ";
$tbl="  Country a, City b ";
$cnt = "all";
$page="1";
$searchand=" and a.code=b.CountryCode ";
$ord=" a.CODE ,a.name ,b.district ,b.name ";
$result =QRY_C_LIST($c,$tbl,$cnt,$page,$searchand,$ord)

?>
<table border="1">
<tr>
	<td width="150">국가코드</td>
	<td>국가</td>
	<td>도</td>
	<td>시</td>
</tr>
<?
while($row = mysql_fetch_array($result)){
	$code = replace_out($row["CODE"]);
	$countryname = replace_out($row["countryname"]);
	$district = replace_out($row["district"]);
	$cityname = replace_out($row["cityname"]);
?>
<tr>
	<td><?=$code?></td>
	<td><?=$countryname?></td>
	<td><?=$district?></td>
	<td><?=$cityname?></td>
</tr>
<? } ?>
</table>