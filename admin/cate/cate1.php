<?
@header("Content-Type: text/html; charset=utf-8");
$gmnow = gmdate("D, d M Y H:i:s") . " GMT";
@header("Expires: 0"); // rfc2616 - Section 14.21
@header("Last-Modified: " . $gmnow);
@header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1
@header("Cache-Control: pre-check=0, post-check=0, max-age=0"); // HTTP/1.1
@header("Pragma: no-cache"); // HTTP/1.0

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
		if (f.title.value!="" && f.code.value!=""){
			f.submit();
		}else{
			if (f.code.value=="")
			{
				alert("유니크한 코드값을 먼저 입력해 주세요.");
				f.code.focus();
			}else{
				alert("대분류명을 입력해 주세요.");
				f.title.focus();
			}
		}
	}

	function go(ct1){
		parent.document.getElementById("cate2").src="cate2.php?cate1_code="+ct1;
		parent.document.getElementById("cate3").src="cate3.php?cate1_code="+ct1;
	}

	function del(code){		
		var f = document.f;
		if (confirm("삭제하시겠습니까?")==true){
			f.typ.value="del";
			f.code.value=code;
			parent.document.getElementById("cate2").src="cate2.php";
			parent.document.getElementById("cate3").src="cate3.php";
			f.action="cate1.php";
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
		f.code.value = code;
		
		f.edit_code.value = document.getElementById("edit_code"+idx).value;
		f.edit_title.value = document.getElementById("edit_title"+idx).value;
		f.action="cate1.php";
		f.submit();
		
	}
//-->
</script>
</head>
<?
$conn = dbconn();
//카테고리 수정
If ($typ=="edit" && $idx!="" && $edit_title!="" && $edit_code!=""){
	$sql = "update code_group set code_desc='".$edit_title."' ,grp_code='".$edit_code."' where grp_idx = '".$idx."'";	
//	echo $sql;
//	exit;
	mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
}
//카테고리 수정 끝

//카테고리 삭제

If ($typ=="del" && $code!=""){		
	$selsql = " select count(*) cnt from code_group_detail where grp_code='".$code."'";		
	
	$result=mysql_query($selsql,$conn) or die ("SQL ERROR(QRY_CNT) : ".mysql_error());
	
	$row=mysql_fetch_array($result);
	$total=$row[cnt];

	if ($total == 0) {
		$sql = "delete from code_group where grp_code='".$code."'";

	//	echo $sql;
	//	exit;
		mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
	}Else{
		Page_Msg("복구가 불가능합니다.하위 카테고리를 먼저 삭제해주세요");
	}
}
//카테고리 삭제 끝

//카테고리 등록
If ($title!=""){
	$sql = "insert into  code_group (grp_code,code_desc,use_yn)
			values('$code',   '$title','Y' )";
	$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
}
//카테고리 등록 끝
?>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" bgcolor="#FFFFFF" onload="document.f.title.focus();">
<form name="f" method="post" action="cate1.php" target="cate1">
<input type="hidden" name="edit_title" value="">
<input type="hidden" name="edit_code" value="">
<input type="hidden" name="code" value="">
<input type="hidden" name="typ" value="">
<input type="hidden" name="idx" value="">
<table width="100%" border=0 bgcolor="#FFFFFF">	
	<tr>
		<td  class="board02" colspan="3" style="height:60px;">
			<input type="text" name="code" size="15" style="line-height:14px;" >
			<input type="text" name="title" size="15" style="line-height:14px;" onkeypress="check_key(cateplus);">
			<a href="javascript: cateplus()"><span class="button1">추가</span></a><!--
			<a href="/admin/cate/sort.php?mode=1&code=" target="cate1"><span class="button1">순서변경</span></a>-->
		</td>
	</tr>
	<?
	$sql = "SELECT * from code_group order by grp_idx";
	
	$conn = dbconn();
	$result = mysql_query($sql, $conn);
	$i = 0;
	while($d = mysql_fetch_array($result)){
		$i++;
		$idx = $d["grp_idx"];
		$code = $d["grp_code"];
		$title = $d["code_desc"];?>

		<tr id="view_tr<?=$idx?>">
		<td class="board01" width="180" ><a href="javascript:go('<?=$code?>');">[<?=$code?>] <?=$title?></a></td>
		<td class="board01" width="15" align="center"><a href="javascript:edit('<?=$idx?>');"><span class="button2">edit</span></a></td>
		<td class="board01" width="15" align="center"><a href="javascript:del('<?=$code?>');"><span class="button2">delete</span></a></td>		
	</tr>
	<tr id="edit_tr<?=$idx?>" style="display:none" >
		<td class="board01" width="180" ><input type="text" name="edit_code<?=$idx?>" id="edit_code<?=$idx?>" value="<?=$code?>"  style="line-height:14px;width:100px"><input type="text" name="edit_title<?=$idx?>" id="edit_title<?=$idx?>" value="<?=$title?>"  style="line-height:14px;width:100px"></a></td>
		<td class="board01" width="15" align="center"><a href="javascript:ok('<?=$idx?>','<?=$code?>');"><span class="button2">ok</span></a></td>
		<td class="board01" width="15" align="center"><a href="javascript:cancel('<?=$idx?>');"><span class="button2">cancel</span></a></td>		
	</tr><?
	}	
	If ($i ==0){?>
	<tr>
		<td class="board02" colspan="3">등록된 카테고리가 없습니다</td>
	</tr>
	<?}?>	
</table>


</body>