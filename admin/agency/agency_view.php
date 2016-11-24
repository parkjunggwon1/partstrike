<?
if($idx){
$searchand = $searchand." and agency_idx='$idx'";	
?>
<!--오른쪽 시작-->
<table width="99%" border="0" cellspacing="0" cellpadding="0" >
	<tr><td>
	<?
	$i=0;
	$result_nation =QRY_C_LIST(" distinct(nation) ","agency",$recordcnt,$page,$searchand," idx desc");
	while($row_nation = mysql_fetch_array($result_nation)){
		$i=$i+1;
		$nation = $row_nation["nation"];
		if($i==1){$nation_1 = $nation;}
		
	?>
	<a href=""><img src="/kor/images/nation_title2_<?=$nation?>.png" border="0"></a>
	<? 	} 	?>
	</td></tr>
</table>
<br>

<table width="99%" border="0" cellspacing="0" cellpadding="0" >
	<tr>
		<td height="1" colspan="9" bgcolor="#dcd8d6"></td>
	</tr>
</table>						
<!--일반게시글 시작-->
<?
if($nat==""){ $nat=$nation_1; }
$searchand = " and a.agency_idx='$idx' and a.nation='$nat' and a.mem_idx=b.mem_idx ";
$result =QRY_LIST("agency a, member b","all",$page,$searchand," a.rel_idx DESC ");


while($row = mysql_fetch_array($result)){
	$idx = replace_out($row["mem_idx"]);
	$rel_idx = replace_out($row["rel_idx"]);
	$mem_nm = replace_out($row["mem_nm"]);
	$mem_nm_en = replace_out($row["mem_nm_en"]);
	$pos_nm_en = replace_out($row["pos_nm_en"]);
	$depart_nm_en = replace_out($row["depart_nm_en"]);
	$hp = replace_out($row["hp"]);
	$fax = replace_out($row["fax"]);
	$zipcode = replace_out($row["zipcode"]);
	$addr_en = replace_out($row["addr_en"]);
	$email = replace_out($row["email"]);
	$homepage = replace_out($row["homepage"]);
	$skypeid = replace_out($row["skypeid"]);
	$log_date = substr(replace_out($row["reg_date"]),0,10);
	$filelogo = get_want("member","filelogo"," and mem_idx='$rel_idx'");
	$rel_name = get_want("member","mem_nm_en"," and mem_idx='$rel_idx'");
?>

<table class="table-type2">
	<tbody>
		<tr>
			<th scope="row"><img src="/upload/file/<?=$filelogo?>" alt="" ></th>
			<td colspan="3"><span lang="en" class="c-blue fs15"><?=$rel_name?></span></td>
		</tr>
		<tr>
			<th scope="row">담당자 / 직책 :</th>
			<td colspan="3"><span lang="en"><?=$mem_nm_en?>/<?=$pos_nm_en?></span></td>
		</tr>
		<tr>
			<th scope="row">부서 :</th>
			<td colspan="3"><span lang="en"><?=$depart_nm_en?></span></td>
		</tr>
		<tr>
			<th scope="row"><span lang="en">Tel  :</span></th>
			<td><span lang="en"><?=$hp?></span></td>
			<th scope="row"><span lang="en">Fax  :</span></th>
			<td><span lang="en"><?=$fax?></span></td>
		</tr>
		<tr>
			<th scope="row">주소 :</th>
			<td colspan="3"><span lang="en"><?=$zipcode?> <?=$addr_en?></span></td>
		</tr>
		<tr>
			<th scope="row">E-Mail :</th>
			<td colspan="3"><span lang="en"><?=$email?></span></td>
		</tr>
		<tr>
			<th scope="row">홈페이지  :</th>
			<td colspan="3"><span lang="en"><?=$homepage?></span></td>
		</tr>
		<tr>
			<th scope="row"><span lang="en">Skype ID  :</span></th>
			<td colspan="3"><span lang="en"><?=$skypeid?></span></td>
		</tr>
	</tbody>
</table>
<? 
} 
}
?>