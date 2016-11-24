<?
//'다음글================================================================================================
$nextsql="select * from $tbl where $f1 > $idx $searchand order by $f1 asc LIMIT 1 ";

//echo $nextsql;
$nextresult = mysql_query($nextsql) or die ("SQL Error : ". mysql_error());
$nextrow=mysql_fetch_array($nextresult);

if (!$nextrow){
	$nexthref = "javascript:alert('다음글이 없습니다');";
	$nexttitle = "없음";
	$nextdate = "";
}else{
	$nextidx = $nextrow[$f1];
	$nexthref = "$view_url?ty=$ty&$param&idx=$nextidx&work=view";
	$nexttitle = $nextrow["bd_title"];
}

//'이전글================================================================================================
$prevsql="select  * from $tbl where $f1 < $idx $searchand order by $f1 desc LIMIT 1";
$prevresult = mysql_query($prevsql,$conn) or die ("SQL Error : ". mysql_error());
$prevrow=mysql_fetch_array($prevresult);

if (!$prevrow){
	$prevhref = "javascript:alert('이전글이 없습니다');";
	$prevtitle = "없음";
	$prevdate = "";
}else{
	$previdx = $prevrow[$f1];
	$prevhref = "$view_url?ty=$ty&$param&idx=$previdx&work=view";
	$prevtitle =$prevrow["bd_title"];
}

?>           
