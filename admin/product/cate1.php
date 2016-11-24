<?
include $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
?>

<html>
<head>
<title><?=$headname?> 관리자페이지입니다</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<LINK href="/admin/style2.css" rel="StyleSheet" title="style" type="text/css">
<script language=javascript src='/include/function.js'></script>
 <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
<script type="text/javascript">
<!--
	function cateplus(){	
		var f = document.f;
		if (f.title.value!=""){
			f.submit();
		}else{
			alert("추가할 중분류명을 입력해주세요.");
			f.title.focus();
		}
	}

	function go(para){
		parent.document.getElementById("cate2").src="cate2.php?"+para;
	}

	function del(code){		
		var f = document.f;
		if (confirm("삭제하시겠습니까?")==true){
			parent.document.getElementById("cate2").src="cate2.php";
			f.action="cate1.php?typ=del&code="+code;
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

	function ok(code){
		var f = document.f;
		f.edit_title.value = document.getElementById("edit_title"+code).value;
		f.action="cate1.php?typ=edit&code="+code;
		f.submit();
		
	}

	function fnSortCateogry(clss) {
        var sortkeys = document.getElementById('s[]');
        var idx = sortkeys.selectedIndex
        if ( idx < 0 ) { return; }
        var optlen = sortkeys.options.length;
        var newidx = -1;
        switch(clss) {
            case 'T': newidx = 0; break;
            case 'U': newidx = idx-1; break;
            case 'D': newidx = idx+1; break;
            case 'L': newidx = optlen-1; break;
        }
        if ( newidx > optlen-1 || idx == newidx || newidx == -1     ) {
            return;
        }
        var oldtext  = sortkeys.options[idx].text;
        var oldvalue = sortkeys.options[idx].value;
        if ( clss == 'T' ) {
            while (idx > 0) {
                sortkeys.options[idx].text = sortkeys.options[idx-1].text;
                sortkeys.options[idx].value = sortkeys.options[idx-1].value;
                idx--;
            }
        }else if ( clss == 'L' ) { 
            while (idx < optlen-1) {
                sortkeys.options[idx].text = sortkeys.options[idx+1].text;
                sortkeys.options[idx].value = sortkeys.options[idx+1].value;
                idx++;
           }
        } else {
            sortkeys.options[idx].text = sortkeys.options[newidx].text;
            sortkeys.options[idx].value = sortkeys.options[newidx].value;
        }
        sortkeys.options[newidx].text = oldtext;
        sortkeys.options[newidx].value = oldvalue;
        sortkeys.selectedIndex = newidx;
    }

	 function check() {
        var sortkeys = document.getElementById('s[]');
        sortkeys.multiple = true;
        for ( var ii=0; ii<sortkeys.options.length; ii++ ) {
            sortkeys.options[ii].selected = true;
        }
		f.s_count.value = sortkeys.options.length;
		f.action = "midcate_proc.php"
        f.submit();
    }
//-->
jQuery(function ($) {		
		$("select[name^=s]").click(function(e){	
			var product_type_idx = $(this).find("option:selected").val().split(":")[0];			
			if (product_type_idx=="0")
			{
				alert("순서 저장이 먼저 필요합니다.");
			}else{
				parent.document.cate2.location.href="cate2.php?gubun=<?=$gubun?>&product_type_idx="+product_type_idx;
			}
		});

		$("input[name=mid_secret]").click(function(e){
			check();
		});
});
</script>
</head>
<?
$conn = dbconn();
//카테고리 수정
If ($typ=="edit" && $code!="" && $edit_title!=""){
	$sql = "update code_group_detail set code_desc='".$edit_title."' where grp_idx = 3 and dtl_code='".$code."'";	
	mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
}
//카테고리 수정 끝

//카테고리 삭제
If ($typ=="del" && $code!=""){		
	$selsql = " select count(*) cnt from car where company_idx='".$code."' ";		
	$result=mysql_query($selsql,$conn) or die ("SQL ERROR(QRY_CNT) : ".mysql_error());
	
	$row=mysql_fetch_array($result);
	$total=$row[cnt];

	if ($total == 0) {
		$sql = "delete from code_group_detail where grp_idx = 3 and dtl_code ='".$code."'";
		mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
	}Else{
		Page_Msg("복구가 불가능합니다.하위 카테고리를 먼저 삭제해주세요");
	}
}
//카테고리 삭제 끝

//카테고리 등록
If ($title!=""){
	$maxidx = get_max_plus_search("product_type", "sort", "and gubun = '$gubun'");

	if ($title=="액세서리"){
		$dtl_code = "OP";
	}else{
		$dtl_code = $maxidx;
	}	
	$sql = "insert into  product_type (gubun, dtl_code, product_type_name ,sort ,reg_date )
			values('$gubun', '$dtl_code', '$title' , $maxidx ,now() )";
	$result = mysql_query($sql,$conn) or die ("SQL Error : ". mysql_error());
}
//카테고리 등록 끝
?>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" bgcolor="#FFFFFF" onload="parent.document.cate2.location.href='cate2.php'">
<?if ($gubun){?>
						<form name="f" method="post">
						<input type="hidden" name="mode" value="<?=$mode?>">
						<input type="hidden" name="cate" value="<?=$cate?>">
						<input type="hidden" name="typ" value="cate1">
						<input type="hidden" name="s_count" value="">
						<table width="200" border="1" cellspacing="1" cellpadding="1" >
						<tr>
						<?$sql = "select headyn , headtext  ,secret
									from board_create where gubun = '$gubun'";
						  $result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
						  $row = mysql_fetch_array($result);
						  if ($row){
								$mid_ty = $row["headyn"];
								$mid_title = $row["headtext"];
								$mid_secret = $row["secret"];
						  }						  
						?>
						<td align="left" colspan="2" bgcolor="#f6f6f6" class="btitle02" style="padding-left:5px"><input name="mid_ty" type="checkbox" value="Y" <?if ($mid_ty=="Y"){echo "checked";}?>>중분류 노출 여부</td>					
						</tr>	
						<tr>
						<td align="left" bgcolor="#f6f6f6" class="btitle02" style="padding-left:5px">소제목</td><td>&nbsp;<input name="mid_title" value="<?=$mid_title?>" type="text" size="15"></td>					
						</tr>			
						<tr>
						<td align="left" bgcolor="#f6f6f6" class="btitle02" style="padding-left:5px">중분류</td><td> &nbsp;<input name="title" value="" type="text" size="10"><input type="button" name="save" value="추가" onclick="cateplus();"></td>					
						</tr>	
						
								<tr>
									<td bgcolor="#FFFFFF" align="left" colspan="2" >
									<?
										$sql = "";
											$sql .= " SELECT product_type_idx, gubun,  dtl_code, product_type_name, sort
														FROM product_type
														WHERE gubun = '$gubun'
													 order by sort";		
										//	echo $sql;
													 ?>
									<select id="s[]" name="s[]" multiple="multiple" style="width:300px;height:200px">
										<?				
											mysql_query( "SET NAMES utf8");	
											$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
											while($row = mysql_fetch_array($result)){
												$product_type_idx = replace_out($row["product_type_idx"]);
												$gubun = replace_out($row["gubun"]);
												
												$dtl_code = replace_out($row["dtl_code"]);
												$product_type_name = replace_out($row["product_type_name"]);
												$sort = replace_out($row["sort"]);
										?>
											<option value="<?=$product_type_idx.":".$dtl_code.":".$gubun.":".$product_type_name?>">&nbsp;&nbsp;<?=$product_type_name?></option>
										<? 
										} 
										?>
									</select>									
									<br>
									<span class="btn1"><a href="javascript:fnSortCateogry('T');" title="맨위로">▲</a></span>
									<span class="btn1"><a href="javascript:fnSortCateogry('U');" title="한단계위로">∧</a></span>&nbsp;&nbsp;
									<span class="btn1"><a href="javascript:fnSortCateogry('D');" title="한단계아래로">∨</a></span>
									<span class="btn1"><a href="javascript:fnSortCateogry('L');" title="맨아래로">▼</a></span>
									<span class="btn1"><a href="javascript:check();">저장</a></span>&nbsp;

									</td>
								</tr>									
							</table>
							<table>
							<tr>
								<td colspan="2" >
							<br>
							* 저장 버튼을 누르면 순서가 저장됩니다.</td>
							</tr>
							</table>
							
							<br>
						</form>						
						<br />
						<br />						
						<br />
						<br />
<?}else{?>
<table width="100%" border=0>
		<tr>
			<td class="board02" style="padding-left:20px;padding-top:15px;">제품 종류를 먼저 선택해 주세요.</td>			
		</tr>
	</table><?}
?>
</body>