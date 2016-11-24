<!--#include virtual="/admin/include/header.asp" -->
<!--#include virtual="/admin/include/menu.asp" -->
<!--#include virtual="/admin/etc/count_code.asp" -->

<%
If mode="" Then mode="CC002"
%>
<!--#include virtual="/admin/include/mode_title.asp"-->
<script type="text/javascript" src="/include/calendar.js"></script>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td height="30" background="/admin/img/now_bg.gif" style="padding-left: 20px" class="now"><img src="/admin/img/icon.gif" width="9" height="7" /> HOME &gt; 사이트관리</td>
	</tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="208" valign="top"><!--#include virtual="/admin/include/lm_count.asp" --></td>
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

						<!--오른쪽 시작-->						
						<br />
						<table width="99%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td height="40" class="rtitle01"><img src="/admin/img/icon_02.gif" width="15" height="15" vspace="3" align="absmiddle" /> <%=title_text%></td>
							</tr>
						</table>

						<!--검색-->		
						<form method=POST action="count.asp" name="frm">
						<input type="hidden" name="mode" value="<%=mode%>">
						<table width="99%" border="0" cellspacing="0" cellpadding="0" class="teduri">
							<TR>
								<TD Style="Border-right:0px;"> 
									<%=subTitle%>
								</TD>
								<TD Align="right">
									<%If mode = "nHour" Or mode = "nWeek" Or mode = "nDay" Then%>
										<INPUT TYPE="text" NAME="sDate" SIZE="15"  class="inputtext2" Value="<%=sDate%>" ReadOnly onclick="Calendar_D(this,event.clientX, event.clientY);"> 부터 
										<INPUT TYPE="text" NAME="eDate" SIZE="15"  class="inputtext2" Value="<%=eDate%>" ReadOnly onclick="Calendar_D(this,event.clientX, event.clientY);"> 까지&nbsp;
									<%ElseIf mode = "nMonth" Then%>
										<SELECT NAME="sYear">
											<%=strYear%>
										</SELECT>년 부터
										<SELECT NAME="eYear">
											<%=endYear%>
										</SELECT>년 까지
									<%ElseIf mode = "nYear" Then%>
									<%else%>
									<%End if%>
									<%If Mode <> "nYear" Then%>
									<span class="btn" onClick="document.frm.submit();">검색</span>
									<%End if%>
								</TD>
							</TR>	
							<tr>
								<td height="1" colspan="9" bgcolor="#dcd8d6"></td>
							</tr>
							<TR Height="22">
								<TD Style="border-right:0px;">총접속자 수 : <%=intRC%> 명</TD>
								<TD Align="right">
								<%
								Select Case Mode
									Case "nYear"
										Response.Write "전체 년도의 결과를 나타냅니다."
									Case "nMonth"
										Response.Write sYear & "년 부터 " & eYear & "년 까지의 결과를 나타냅니다."
									Case "nDay", "nWeek"
										Response.Write sYear & "년 " & sMonth & "월 부터 " & eYear & "년 " & eMonth & "월 까지의 결과를 나타냅니다."
									Case Else 'nHour
										Response.Write sYear & "년 " & sMonth & "월 " & sDay & "일 부터 " & eYaer & "년 " & eMonth & "월 " & eDay & "일 까지의 결과를 나타냅니다."
								End Select
								%>
								</TD>
							</TR>
						</table>
						<!--검색끝-->		
						<table width="99%" border="0" cellspacing="0" cellpadding="0" background="/admin/img/boardbar_bg.gif">
							<tr>
								<td width="300" height="27" align="center" class="btitle01" ><%=Title%></td>								
								<td align="center" class="btitle01">그래프</td>	
								<td width="150" align="center" class="btitle01">접속수</td>		
								
							</tr>
						</table>
						<!--일반게시글 시작-->
						
						<table width="99%" border="0" cellspacing="0" cellpadding="0"  class="teduri">
							<colgroup>
								<col width="280"/><col width=""/><col width="140"/>
							</colgroup>
							<%=strPrint%>
						</table>
						
						
						
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
