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
	function fnSortCateogry(clss) {
        var sortkeys = document.getElementById('s');
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
    function doSortCategory() {
        var sortkeys = document.getElementById('s');
        sortkeys.multiple = true;
        for ( var ii=0; ii<sortkeys.options.length; ii++ ) {
            sortkeys.options[ii].selected = true;
        }
        f.submit();
    }

	 function go_page() {
		var f= document.f;
        f.action = "cate<?=$mode?>.php";
		f.target = "cate<?=$mode?>";
		f.submit();
    }	
//-->
</script>
</head>
<table border="0" bordercolor="white" bordercolordark="white" bordercolorlight="#666666" cellpadding=2 cellspacing=0 width="100%">
	<tr>
		<td height=20 align="center" colspan="2" ><b><?=$title2?> 순서 변경</b></td>
	</tr>
	<tr>
		<?
		
		If ($mode=="1"){
			$strsql="SELECT cate1_idx as idx, cate1_title as title from cate1 order by cate1_num";
		}ElseIf ($mode=="2"){
			$strsql="SELECT dtl_code as idx, code_desc as title from code_group_detail where grp_code='$cate1_code' and dtl_par_code =''  order by code_seq";
		}elseif ($mode=="3"){
			$strsql="SELECT dtl_code as idx, code_desc as title from code_group_detail where grp_code='$cate1_code' and dtl_par_code = '$cate2_code' order by code_seq";
		}

		$conn = dbconn();
		$result = mysql_query($strsql, $conn);
		?>
		<form method="post" name="f" action="sort_proc.php">
		<input type="hidden" name="mode" value="<?=$mode?>">		
		<input type="hidden" name="code" value="<?=$code?>">
		<input type="hidden" name="cate1_code" value=<?=$cate1_code?>>
		<input type="hidden" name="cate2_code" value=<?=$cate2_code?>>
		<input type="hidden" name="title2" value="<?=$title2?>">

		<td bgcolor="#FFFFFF" valign="top" colspan="2" > 
		<select NAME="s[]" id="s" multiple size="10" scrolling="yes" style="border-width:1; border-style:solid; border-color:#DADADA; background-color:#F9F9F9; font-size: 10pt; width: 305px;">
		<?
			$i = 0;
			while($d = mysql_fetch_array($result)){
				$i++;
				$idx = $d["idx"];
				$title = $d["title"];
				?>
				<option value="<?=$idx?>-<?=$i?>"><?=$title?></option>
		<?}?>
		</select>
		<td>
	</tr>
	<tr>
		<td>
		<br>
		<a href="javascript:fnSortCateogry('T');" title="맨위로"><span class="button1">▲</span></a>
		<a href="javascript:fnSortCateogry('U');" title="한단계위로"><span class="button1">∧</span></a>&nbsp;&nbsp;
		<a href="javascript:fnSortCateogry('D');" title="한단계아래로"><span class="button1">∨</span></a>
		<a href="javascript:fnSortCateogry('L');" title="맨아래로"><span class="button1">▼</span></a>
		</td>
		<td align="right">
		<br>
		
		<a href="javascript:doSortCategory();"><span class="button1">수정완료</span></a>
		<a href="javascript:go_page();"><span class="button1">이전페이지</span></a>
		</td>
		</form>
	</tr>
</table>
