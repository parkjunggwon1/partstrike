<?
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";

?>

<html>
<head>
<title><?=$headname?> 관리자페이지입니다</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<LINK href="/admin/style2.css" rel="StyleSheet" title="style" type="text/css">
<script language=javascript src='/include/function.js'></script>
<script type="text/javascript">
<!--
	function cateplus(){	
		var f = document.f;
		if (f.title.value!=""){
			f.submit();
		}
	}

	function chgLang(lang){
		var f = document.f;
		f.lang.value= lang;
		f.submit();
			
	}

	function go(ct1,ct2){
		parent.document.getElementById("cate3").src="cate3.php?cate1_code="+ct1+"&cate2_code="+ct2;
		parent.document.getElementById("cate4").src="cate4.php?cate1_code=&cate2_code=";
	}

	function del(code){
		var f = document.f;
		if (confirm("삭제하시겠습니까?")==true){
			f.typ.value="del";
			f.code.value=code;
			parent.document.getElementById("cate2").src="cate2.php";
			parent.document.getElementById("cate3").src="cate3.php";
			f.action="cate2.php";
			f.submit();

		}		
	}

	function edit(idx){		
		document.getElementById("view_tr"+idx).style.display = "none";
		document.getElementById("edit_tr"+idx).style.display = "";		
	}

	function cancel(idx){
		var f = document.f;
		document.getElementById("view_tr"+idx).style.display = "";
		document.getElementById("edit_tr"+idx).style.display = "none";		
	}

	function ok(idx,code){
		var f = document.f;
		f.idx.value = idx;
		f.typ.value = "edit";
		f.cate1_code.value = code;
		f.edit_title.value = document.getElementById("edit_title"+idx).value;
		f.action="cate2.php";
		f.submit();
		
	}

	function go_sort(idx,code,code2){
		var f = document.f;
		f.mode.value = idx;
		f.cate1_code.value = code;
		f.cate2_code.value = code2;
		f.action="sort.php";
		f.submit();
		
	}

	
//-->
</script>

<?
$conn = dbconn();
$title2=get_any("code_group" , "code_desc" ,"grp_code='$cate1_code' ");
//카테고리 수정
	
If ($typ=="edit" && $idx!="" && $edit_title!=""){
	$sql = "update code_group_detail set code_desc$lang ='".$edit_title."' where grp_code = '".$cate1_code."' and dtl_code = $idx";	

	mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
}
//카테고리 수정 끝

//카테고리 삭제
If ($typ=="del" && $code!=""){		
	$selsql = " select count(*) cnt from code_group_detail where grp_code='".$cate1_code."' and dtl_par_code='$code'";		
	$result=mysql_query($selsql,$conn) or die ("SQL ERROR(QRY_CNT) : ".mysql_error());
	
	$row=mysql_fetch_array($result);
	$total=$row[cnt];

	if ($total == 0) {
		$sql = "delete from code_group_detail where grp_code='".$cate1_code."' and dtl_code='".$code."'";

		mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
	}Else{
		Page_Msg("복구가 불가능합니다.하위 카테고리를 먼저 삭제해주세요");
	}
}
//카테고리 삭제 끝

//카테고리 등록
If ($title!=""){

	$code =get_any ( "code_group_detail", "ifnull(max(dtl_code*1)+1,1) ", "grp_code = '$cate1_code' limit 1");
	$grp_idx = get_any("code_group","grp_idx", " grp_code='".$cate1_code."' ");
	$sql = "insert into  code_group_detail (grp_idx, grp_code, dtl_code, code_seq, code_depth,  code_desc$lang, use_yn)
			values($grp_idx , '$cate1_code' , '$code','$code',1, '$title', 'Y')";
		
	$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
}
//카테고리 등록 끝

If ($cate1_code!=""){?>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" bgcolor="#FFFFFF" onload="document.f.title.focus();">
<form name="f" method="post" action="cate2.php" target="cate2">
<input type="hidden" name="mode" value="MM">
<input type="hidden" name="typ" value="">
<input type="hidden" name="code" value=<?=$cate1_code?>>
<input type="hidden" name="lang" value=<?=$lang?>>
<input type="hidden" name="cate1_code" value=<?=$cate1_code?>>
<input type="hidden" name="cate2_code" value=<?=$cate2_code?>>
<input type="hidden" name="title2" value=<?=$title2?>>
<input type="hidden" name="edit_title" value="">
<input type="hidden" name="edit_start_year" value="">
<input type="hidden" name="edit_end_year" value="">
<input type="hidden" name="idx" value="">
<table width="100%" border=0>
	
	<tr>
		<td class="board02" colspan="3" style="height:60px;">
			<input type="text" name="title" size="10" onkeypress="check_key(cateplus);" >
			<a href="javascript: cateplus()"><span class="button1">추가</span></a>
			<a href="javascript:go_sort(2 , '<?=$cate1_code?>' ,'')" target="cate2"><span class="button1">순서변경</span></a>
			<?if ($lang==""){?>
				<a href="javascript: chgLang('_en')"><span class="button1">영문</span></a>
			<?}elseif($lang=="_en"){?>
				<a href="javascript: chgLang('')"><span class="button1">한글</span></a>
			<?}?>
		</td>
	</tr>
	<tr>
		<td class="board02" colspan="3"><strong><?=$title2?></strong>을(를) 선택하셨습니다</td>
	</tr>
	<?
	$sql = "SELECT * from code_group_detail where grp_code='$cate1_code' and dtl_par_code ='' order by code_seq ";	

	$result = mysql_query($sql, $conn);
	$seq = 0;
	while($d = mysql_fetch_array($result)){
		$seq++;
			$idx = $d["dtl_code"];
			$code1 = $d["grp_code"];
			$code = $d["dtl_code"];
			$title = $d["code_desc$lang"];
		?>
		<tr id="view_tr<?=$idx?>">
		<td class="board01" width="180" ><a href="javascript:go('<?=$code1?>','<?=$code?>');">[<?=$seq?>] <?=$title?></a></td>
		<td class="board01" width="15" align="center"><a href="javascript:edit('<?=$idx?>');"><span class="button2">edit</span></a></td>
		<td class="board01" width="15" align="center"><a href="javascript:del('<?=$code?>');"><span class="button2">delete</span></a></td>		
	</tr>
	<tr id="edit_tr<?=$idx?>" style="display:none">
		<td class="board01" width="180" ><input type="text" name="edit_title<?=$idx?>" id="edit_title<?=$idx?>" value="<?=$title?>" style="line-height:14px;"></a></td>
		<td class="board01" width="15" align="center"><a href="javascript:ok('<?=$idx?>','<?=$code1?>');"><span class="button2">ok</span></a></td>
		<td class="board01" width="15" align="center"><a href="javascript:cancel('<?=$idx?>');"><span class="button2">cancel</span></a></td>		
	</tr>
	<?
	
	}
	if ($seq == 0){
	?>
	<tr>
		<td class="board02" colspan="3">등록된 카테고리가 없습니다</td>
	</tr>
	<?}?>
</table>
</form>
<?}else{?>
	<table width="100%" border=0>
		<tr>
			<td class="board02">카테고리 종류를 먼저 선택해주세요</td>			
		</tr>
	</table>
<?}?>
