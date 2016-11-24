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
		if(f.title.value==""){
			alert("차종을 입력해 주세요.");
			f.title.focus();
		}else if (f.start_year.value==""){
			alert("연식 시작년도를 입력해 주세요.");
			f.start_year.focus();
		}else {
			f.submit();
		}
	}

	 function check() {
        var f = document.f;
		if(f.product_type_name.value==""){
			alert("중분류명을 입력해 주세요.");
			f.product_type_name.focus();
		}else if(f.product_content.value==""){
			alert("컨텐츠를 입력해 주세요.");
			f.product_type_content.focus();
		}else{
			f.encoding = "multipart/form-data";
			f.action = "midcate_proc.php"
			f.submit();
		}
    }

	function go(para){
		parent.document.getElementById("cate3").src="cate3.php?"+para;
	}

	function del(idx){
		var f = document.f;
		if (confirm("정말 삭제하시겠습니까?")==true){
			f.idx.value = idx;
			f.typ.value="del";
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
		f.edit_title.value = document.getElementById("edit_title"+idx).value;
		f.edit_start_year.value = document.getElementById("edit_startyear"+idx).value;
		f.edit_end_year.value = document.getElementById("edit_endyear"+idx).value;
		f.action="cate2.php?typ=edit&code="+code;
		f.submit();
		
	}

	function go_sort(){
		var f = document.f;
		f.action = "sort.php"
		f.submit();
	}
//-->
</script>
<?

$conn = dbconn();
//카테고리 수정
If ($typ=="edit" && $idx!="" && $edit_title!=""){
	$sql = "update car set car_name='".$edit_title."', start_year = '$edit_start_year', end_year = '$edit_end_year' where car_idx='".$idx."'";	
	mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
}
//카테고리 수정 끝

//카테고리 삭제
If ($typ=="del" && $idx!=""){		
	$sql = "delete from product_type where product_type_idx = $idx";
	//echo $sql;
	//exit;
		mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
		Page_Parent_Msg_Url("삭제 되었습니다.","cate.php?gubun=$gubun");	
}
//카테고리 삭제 끝

//카테고리 등록
If ($title!=""){
	$sql = "insert into  car (company_idx,car_name,start_year,end_year, reg_date)
			values($cate1_code , '$title' , '$start_year', '$end_year', now())";
	$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
}
//카테고리 등록 끝

If ($gubun && $product_type_idx){
	$cnt = QRY_CNT("board_create", " and gubun='$gubun' and headyn='Y'");
	if ($cnt == 0){
		?>
		<table width="100%" border=0>
		<tr>
			<td class="board02">중분류 여부에 체크 하시고, 저장을 먼저 해주세요.</td>			
		</tr>
	</table>
	<?
	}else{?>
	<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" bgcolor="#FFFFFF" onload="document.f.product_type_name.focus();">
	<form name="f" method="post" action="cate2.php" target="cate2">
	<input type="hidden" name="gubun" value=<?=$gubun?>>
	<input type="hidden" name="product_type_idx" value=<?=$product_type_idx?>>
	<input type="hidden" name="typ" value="cate2">
	<input type="hidden" name="idx" value="">
													
							

	<table width="95%" border=0 cellspacing="1" style="margin-left:10px;margin-top:5px;" cellpadding="5" bgcolor="#e6e6e6">
		<?
		$sql = "select product_type_name ,product_content , filename0  from product_type where product_type_idx = $product_type_idx";
		$result = mysql_query($sql, $conn);
		$d = mysql_fetch_array($result);
		$product_type_name = $d["product_type_name"];
		$product_content = $d["product_content"];
		$filename0 = $d["filename0"];
		?>
		<tr>
			<td align="center" bgcolor="#f6f6f6" class="btitle02">
				중분류명</td><td bgcolor="#FFFFFF"><input type="text" name="product_type_name" size="10" value="<?=$product_type_name?>"> 
			</td>
		</tr>
			<tr>
			<td align="center"  bgcolor="#f6f6f6" class="btitle02">
				이미지</td><td bgcolor="#FFFFFF">
				<?If ($filename0){
				?><img src="<?=$file_path?><?=$filename0?>"><br><?}?>
				<input type="file" name="file0" size="10"> (이미지크기 : 228 X 171)
				<input type="hidden" name="file_o0" value="<?=$filename0?>">
			</td>
		</tr>
			<tr>
			<td align="center"  bgcolor="#f6f6f6" class="btitle02">
				컨텐츠</td><td bgcolor="#FFFFFF"><textarea cols="50" name="product_content" rows="6"><?=$product_content?></textarea>
			</td>
		</tr>
	</table>
	<table width="97%"><tr><td align="right" ><span class="btn1"><a href="javascript:del(<?=$product_type_idx?>);">삭제</a></span> <span class="btn1"><a href="javascript:check();">저장</a></span></td></tr></table>
	</form>
</body>

	<?
	}?>
<?}else{?>
	<table width="100%" border=0>
		<tr>
			<td class="board02">제품 종류를 먼저 선택해 주세요.</td>			
		</tr>
	</table>
<?}?>
