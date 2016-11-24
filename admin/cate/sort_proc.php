<?
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
?>

<?

for ($i =0; $i < count($s); $i++) {  
	$split = explode("-",$s[$i]);
	$sql = "update code_group_detail set code_seq ='".($i+1)."' where grp_code = '".$cate1_code."' and dtl_code = ".$split[0];	
	//echo $sql;
	mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
	
}
  
?>
<form name="f" method="post" >
<input type="hidden" name="mode" value="<?=$mode?>">
<input type="hidden" name="code" value="<?=$code?>">
<input type="hidden" name="cate1_code" value="<?=$cate1_code?>">
<input type="hidden" name="cate2_code" value="<?=$cate2_code?>">
<input type="hidden" name="title2" value="<?=$title2?>">
</form>
<script type="text/javascript">
<!--
	 alert("수정 완료 하였습니다.");
	 f.action = "sort.php"
	 f.submit();
//-->
</script>
 
  

 

