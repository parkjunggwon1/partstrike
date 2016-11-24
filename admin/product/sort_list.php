<?
include $_SERVER["DOCUMENT_ROOT"]."/admin/include/header.php";

if (!$mode){ $mode="BB001";}
if (!$cate){ $cate="1";}

?>
<script type="text/javascript">
<!--
	

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
		f.action = "sort_proc.php"
        f.submit();
    }
//-->
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td height="30" background="/admin/img/now_bg.gif" style="padding-left: 20px" class="now"><img src="/admin/img/icon.gif" width="9" height="7" /> HOME &gt; 사이트관리</td>
	</tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="208" valign="top">
		<?
		  include $_SERVER["DOCUMENT_ROOT"]."/admin/include/lm.php";
		?>
		</td>
		<td valign="top">
		<table width="100%" border="0" cellspacing="1" cellpadding="4" bgcolor="#8e9194">
			<tr>
				<td align="center" bgcolor="#63676a">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td width="6" valign="top"><img src="/admin/img/t_01.gif" width="6" height="6" /></td>
						<td background="/admin/img/t_05.gif"></td>
						<td width="6" align="right" valign="top"><img src="/admin/img/t_02.gif" width="6" height="6" /></td>
					</tr>
					<tr>
						<td background="/admin/img/t_07.gif"></td>
						<td align="center" valign="top" bgcolor="#FFFFFF">
						<br />
						<!--오른쪽 시작-->
						<table width="99%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td height="40" class="rtitle01"><img src="/admin/img/icon_02.gif" width="15" height="15" vspace="3" align="absmiddle" /> 제품순서관리</td>
							</tr>
						</table>
						<form name="f" method="post">
						<input type="hidden" name="mode" value="<?=$mode?>">
						<input type="hidden" name="cate" value="<?=$cate?>">
						<input type="hidden" name="s_count" value="">
						<table width="99%" border="0" cellspacing="1" cellpadding="1">
							<tr>
								<td valign="top">
								<!--카테코리-->		
							
								<table width="150" border="0" cellspacing="1" cellpadding="5" bgcolor="#e6e6e6">
								  <?for($i=1;$i<9;$i++){
										if($i=="1"){$title1="기본바시스템"; $mode2="BB001";}
										if($i=="2"){$title1="자전거캐리어"; $mode2="BB002";}
										if($i=="3"){$title1="짐받이캐리어"; $mode2="BB003";}
										if($i=="4"){$title1="자전거거치대"; $mode2="BB004";}										
										if($i=="5"){$title1="오토캠핑"; $mode2="BB007";}
										if($i=="7"){$title1="수상스포츠"; $mode2="BB008";}
										if($i=="8"){$title1="스키캐리어"; $mode2="BB005";}
										if ($i !=6){
									?>	
								  <tr>
									<th scope="col"><?=$title1?></th>
								  </tr>
								  <tr>
									<td>
									<?
										$searchand = " and dtl_code <> 'OP'";
										$result =QRY_CATEGORY_LIST($mode2,$searchand);
										if ($mode!="BB006" && !$product_type_idx) {$product_type_idx=1;}
										while($row = mysql_fetch_array($result)){
											$wh_product_type_idx = replace_out($row["product_type_idx"]);
											$product_type_name = replace_out($row["product_type_name"]);
											If(strcmp($wh_product_type_idx,$product_type_idx)==0){
												echo "<li style='font-weight: bold;'><a href='?mode=".$mode2."&product_type_idx=".$wh_product_type_idx."'>".$product_type_name."</a></li>\n";
											}else{
												echo "<li><a href='?mode=".$mode2."&product_type_idx=".$wh_product_type_idx."'>".$product_type_name."</a></li>\n";
											}
										}
									
									?>
										<br>
									</td>
								  </tr>
								  <?}}?>
								   <tr>
									<th scope="col">액세서리</th>
								  </tr>
								  <tr>
									<td>
										<li <?if($mode=="BB006"){?>style="font-weight: bold;"<?}?>><a href="?mode=BB006">액세서리</a></li>
										<!--<li <?if($mode=="BB006" and $cate=="A"){?>style="font-weight: bold;"<?}?>><a href="?mode=BB006&cate=A">기본바</a></li>
										<li <?if($mode=="BB006" and $cate=="B"){?>style="font-weight: bold;"<?}?>><a href="?mode=BB006&cate=B">자전거캐리어</a></li>
										<li <?if($mode=="BB006" and $cate=="C"){?>style="font-weight: bold;"<?}?>><a href="?mode=BB006&cate=C">짐받이캐리어</a></li>
										<li <?if($mode=="BB006" and $cate=="D"){?>style="font-weight: bold;"<?}?>><a href="?mode=BB006&cate=D">자전거거치대</a></li>
										<li <?if($mode=="BB006" and $cate=="E"){?>style="font-weight: bold;"<?}?>><a href="?mode=BB006&cate=E">자전거거치대</a></li><br>-->
									</td>
								  </tr>
								</table>						
							<!--//카테코리-->
							
							</td>
							<td width="600" align="center" valign="top">
							<table width="500" border="0" cellspacing="1" cellpadding="1" bgcolor="#e6e6e6">
								<tr>
									<td align="center" bgcolor="#f6f6f6" class="btitle02" >순서관리</td>
									
								</tr>							
								<tr>
									<td bgcolor="#FFFFFF" align="right">
									<select id="s[]" name="s[]" multiple="multiple" style="width:500px;height:600px">
										<?	
										$searchand = " and bd_gubun='$mode' and bd_blind<> 'Y'";	
										if($mode=="BB006"){
											 $searchand .= " and instr(bd_cate,'H') ";
										}else{
											 $searchand .= "  and product_type_idx= '$product_type_idx' ";
										}
										$sql = "
												SELECT * FROM 
													board	
												WHERE
													1=1 $searchand
												order by
													bd_sort ,bd_idx DESC
												";

										mysql_query( "SET NAMES utf8");	
										$result=mysql_query($sql,$conn) or die ("SQL ERROR : ".mysql_error());
										while($row = mysql_fetch_array($result)){
											$idx = replace_out($row["bd_idx"]);
											$title = replace_out($row["bd_title"]);
											$title_sub = replace_out($row["bd_title_sub"]);
											$cate = replace_out($row["bd_cate"]);
											$bd_sort = replace_out($row["bd_sort"]);
										?>
										<option value="<?=$idx?>">[<?=$idx?>]&nbsp;&nbsp;<strong><?=$title?></strong> [<?=$title_sub?>]</option>
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
								<td>*[] 안의 숫자는 상품의 고유 번호입니다. 참고 사항이며 상품 리스트 노출에 무관합니다.
							<br>
							* 저장 버튼을 누르지 않으면 적용되지 않습니다.</td>
							</tr>
							</table>
							
							<br>
							<br>
							<br>
							</td>
							<td width="60%" align="center" valign="top">
							<!--검색-->
							<!--<table border="0" cellspacing="1" cellpadding="0" width="100%">
								<tr>
									<td>
									<iframe src="sort_iframe.asp?cate=<%=cate%>&mode=<%=mode%>" width="100%" name="sort_iframe"  id="sort_iframe" onload="resizeHeight('sort_iframe')" frameborder="0" scrolling="auto"></iframe>
									</td>
								</tr>
								<tr>
									<td></td>
								</tr>
							</table>-->
							</td>
						</tr>
						</table>
						</form>						
						<br />
						<br />						
						<br />
						<br />
						<!--오른쪽 끝-->
						</td>
						<td background="/admin/img/t_08.gif"></td>
					</tr>
					<tr>
						<td><img src="/admin/img/t_03.gif" width="6" height="6" /></td>
						<td background="/admin/img/t_06.gif"></td>
						<td align="right"><img src="/admin/img/t_04.gif" width="6" height="6" /></td>
					</tr>
				</table></td>
			</tr>
		</table></td>
	</tr>
</table>
<!--#include virtual="/admin/include/footer.asp" -->
