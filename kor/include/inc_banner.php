<?
$bn_searchand = " and bn_gubun='$bn_mode' ";

$bn_sql = "SELECT * FROM 
			banner	
		WHERE
			1=1 $bn_searchand
		order by
			bn_idx DESC
		LIMIT 0,$top_cnt
		";
$bn_result=mysql_query($bn_sql,$conn) or die ("SQL ERROR : ".mysql_error());

while($bn_row = mysql_fetch_array($bn_result)){
	$bn_idx = replace_out($bn_row["bd_idx"]);
	$bn_file1 = replace_out($bn_row["bn_file1"]);
	$bn_url1 = replace_out($bn_row["bn_url1"]);
	$bn_file2 = replace_out($bn_row["bn_file2"]);
	$bn_url2 = replace_out($bn_row["bn_url2"]);
	$bn_file3 = replace_out($bn_row["bn_file3"]);
	$bn_url3= replace_out($bn_row["bn_url3"]);
	$bn_file4 = replace_out($bn_row["bn_file4"]);
	$bn_url4= replace_out($bn_row["bn_url4"]);
	$bn_file5 = replace_out($bn_row["bn_file5"]);
	$bn_url5= replace_out($bn_row["bn_url5"]);
?>
<?if($bn_file1){?><li><?if($bn_url1){?><a href="<?=$bn_url1?>"><?}?><img src="<?=$file_path?><?=$bn_file1?>" alt="" > <?if($bn_url1){?></a><?}?></li><?}?>
<?if($bn_file2){?><li><?if($bn_url2){?><a href="<?=$bn_url2?>"><?}?><img src="<?=$file_path?><?=$bn_file2?>" alt="" > <?if($bn_url2){?></a><?}?></li><?}?>
<?if($bn_file3){?><li><?if($bn_url3){?><a href="<?=$bn_url3?>"><?}?><img src="<?=$file_path?><?=$bn_file3?>" alt="" > <?if($bn_url3){?></a><?}?></li><?}?>
<?if($bn_file4){?><li><?if($bn_url4){?><a href="<?=$bn_url4?>"><?}?><img src="<?=$file_path?><?=$bn_file4?>" alt="" > <?if($bn_url4){?></a><?}?></li><?}?>
<?if($bn_file5){?><li><?if($bn_url5){?><a href="<?=$bn_url5?>"><?}?><img src="<?=$file_path?><?=$bn_file5?>" alt="" > <?if($bn_url5){?></a><?}?></li><?}?>
<? } ?>
