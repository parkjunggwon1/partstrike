<?
$mode = $_REQUEST['mode'];
$page = $_REQUEST['page'];

$search = $_REQUEST['search'];
$strsearch = $_REQUEST['strsearch'];


include $_SERVER["DOCUMENT_ROOT"]."/admin/include/header.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.other.php";



$searchand = " and bn_gubun='$mode'";
if ($strsearch){
	$searchand .= " and $search like '%$strsearch%'";
}

$cnt = QRY_CNT("banner",$searchand);
$totalpage = QRY_TOTALPAGE($cnt,$recordcnt);
$result =QRY_BANNER_LIST($recordcnt,$searchand,$page);

?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td height="30" background="/admin/img/now_bg.gif" style="padding-left: 20px" class="now"><img src="/admin/img/icon.gif" width="9" height="7" /> HOME &gt; 사이트관리</td>
	</tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="208" valign="top"><?
		  include $_SERVER["DOCUMENT_ROOT"]."/admin/include/lm.php";
		?></td>
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
						<table width="99%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td height="40" class="rtitle01"><img src="/admin/img/icon_02.gif" width="15" height="15" vspace="3" align="absmiddle" /> <?=$title_text?></td>
								
							</tr>
						</table>
						<!--오른쪽 시작-->
						<%If Left(mode,2)="BB" then%>
						<table border="0" style="float:left;padding-left:20px;width:300px;height:150px;" class="teduri">
							<tr>
								<td width="70%">
								<table width="100%" border="0" cellspacing="0" cellpadding="0" class="teduri" style="width:200px;height:100px;">
									<tr>
										<td align="center">배너1</td>
									</tr>
								</table>
								</td>
								<td width="30%">
								<table width="100%" border="0" cellspacing="0" cellpadding="0" class="teduri" style="width:100px;height:100px;">
									<tr>
										<td align="center">배너2</td>
									</tr>											
								</table>
								</td>
							
							</tr>
							<tr>
								<td width="70%" height="">
								<table width="100%" border="0" cellspacing="0" cellpadding="0" class="teduri" style="width:200px;height:200px;">
									<tr>
										<td align="center">배너3</td>
									</tr>
								</table>
								</td>
								<td width="30%" >
								
								</td>
							</tr>
							
						</table>
						<%end if%>
						<form name="f" method="post">
						<input type="hidden" name="typ" value="<%=typ%>">
						<input type="hidden" name="delchk" value="0">
						<table width="99%" border="0" cellspacing="0" cellpadding="0" background="/admin/img/boardbar_bg.gif">
							<tr>
								<td width="60" height="27" align="center" class="btitle01" ><input type="checkbox" name="alldelchk" onclick="alldel_chk(this.checked);" ></td>	
								<td width="60" height="27" align="center" class="btitle01" >번호</td>
								<td align="center" class="btitle01">제목</td>
								<td width="120" align="center" class="btitle01">날짜</td>
							</tr>
						</table>						
						<!--일반게시글 시작-->
						<%						
						' 자료가 없을때 
						if sqlrs.bof or sqlrs.eof then	
						%>
						<table width="99%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td height="50" align="center">등록 된 자료가 없습니다</td>
							</tr>
							<tr>
								<td height="1" colspan="9" bgcolor="#dcd8d6"></td>
							</tr>
						</table>
						<%  
						' 자료가 있을때
						else
							ListNO=cnt-((Page-1)*RecordCnt)
							sqlrs.Move (page - 1) * recordcnt

							Do Until sqlrs.EOF
						  
								'값을 가져온다
								idx = replace_out(sqlrs("sec"))
								bn_title = replace_out(sqlrs("bn_title"))
								bn_file1 = replace_out(sqlrs("bn_file1"))
								bn_date = Left(replace_out(sqlrs("bn_date")),10)	
								bn_cate = replace_out(sqlrs("bn_cate"))
								
								
						%>
						<a href="banner_write.asp?<%=param%>&idx=<%=idx%>" id="go_<%=idx%>"></a>
						<table width="99%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="60" height="30" align="center">								
								<input type="checkbox" name="delchk" value="<%=idx%>"></td>	
								<td width="60" height="30" align="center"><%=ListNO%></td>	
								<td align="center"><a href="javascript:gogo('<%=idx%>')"><%=bn_title%></a></td>
								<td width="120" align="center"><%=bn_date%></td>
							</tr>
							<tr>
								<td height="1" colspan="9" bgcolor="#dcd8d6"></td>
							</tr>
						</table>
						<%		sqlrs.movenext
								listno=listno-1
							   Loop
							End If

							sqlrs.Close
							Set sqlrs = nothing
						%>
						</form>
						<br>
						<table width="99%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<Td width=120>&nbsp;</td>
								<td height="40" align="center"><%
								addpara = ""
								pageurl = "banner_list.asp"
								%>
								<!--#include virtual="/admin/include/paging_admin.asp" --></td>
								
								<td width="120" align="right">
								<%If Left(mode,4)<>"BB00" then%>
								<span class="btn1"><a href="banner_write.asp?mode=<%=mode%>&page=<%=page%>">등록</a></span>
								<span class="btn1"><a href="javascript:del();">삭제</a></span>
								<%End if%>&nbsp;
								</td>
							</tr>
						</table>
						<br />
						<form name="searchfrm" method="post" action="banner_list.asp">
						<input type="hidden" name="mode" value="<%=mode%>">
						<table width="99%" border="0" cellspacing="0" cellpadding="0" bgcolor="#f0f0f0">
							<tr>
								<td height="40" align="center">
								<select name="search">	
								<option value="name" <%If search="name" Then%> selected <%End If%>>작성자</option>
								<option value="subject" <%If search="subject" Then%> selected <%End If%>>제목</option>
								<option value="contents" <%If search="contents" Then%> selected <%End If%>>내용</option>
								
								</select>
								<input type='text' name="strsearch" size='30' maxlength ='20' value="<%=strsearch%>" onKeyPress="check_key(check_search);" style="font-size:9pt;height:21px;">	
								<span class="btn1"><a href="javascript:check_search();">SEARCH</a></span>
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
				</table>
				</td>
			</tr>
		</table>
		</td>
	</tr>
</table>
<!--#include virtual="/admin/include/footer.asp" -->
<script type="text/javascript">
<!--
	function del(){
		if (confirm("삭제하시겠습니까?")==true){
			document.f.typ.value = "alldel";
			document.f.action = "banner_proc.asp?<%=param%>";
			document.f.encoding = "multipart/form-data";
			document.f.submit();			
		}
	}
//-->
</script>
