<%

If Trim(Request("sDate")) <> "" and Trim(Request("eDate")) <> "" Then
	sDate = Trim(Request("sDate"))
	eDate = Trim(Request("eDate"))
Else
	sDate = Date
	eDate = Date
End If

sYear = Year(sDate)
smonth = month(sDate)
sDay = Day(sDate)
eYear = Year(eDate)
emonth = month(eDate)
eDay = Day(eDate)

If mode = "nMonth" Then
	sYear = Trim(Request("sYear"))
	eYear = Trim(Request("eYear"))
	If sYear = "" Then	sYear = Year(Date)
	If eYear = "" Then	eYear = Year(Date)
End If

If mode = "nWeek" or mode = "nDay" Then
	subDate = Dateserial(eYear, emonth+1, 1)
	selDay = Day(DateAdd("d", -1, subDate))

	start_date = dateserial(sYear, smonth, "1")
	end_date = dateserial(eYear, emonth, selDay)
Else
	start_date = dateserial(sYear, smonth, sDay)
	end_date = dateserial(eYear, emonth, eDay)
End If

If DateDiff("d", start_date,  end_date) < 0 Then
	Call Page_Msg_Url("시작일이 종료일보다 늦습니다.","count.asp?mode="&mode)
End If

Select Case mode
	Case "nWeek"	 'Week ============================================================================================
		Title = "요일"

		FilterString = "convert(char(10), log_nDate, 20) between '"& start_date &"' and '"& end_date &"'"
		Result = SelectValueCommand(objRs, "Count(*)", "count_log", FilterString, "", "")

		intRC = CInt(objRs(0))
		Call CloseRS(objRs)

		For idx = 1 To 7
			FilterString = "log_nWeek= '"& idx &"'"
			FilterString = FilterString & " and convert(char(10), log_nDate, 20) between '"& start_date &"' and '"& end_date &"'"
			Result = SelectValueCommand(objRs, "Count(*)", "count_log", FilterString, "", "")

			Select Case idx
				Case 1	W = "<FONT COLOR=""#FF0000"">일</FONT>"
				Case 2	W = "월"
				Case 3	W = "화"
				Case 4	W = "수"
				Case 5	W = "목"
				Case 6	W = "금"
				Case 7	W = "<FONT COLOR=""#6600FF"">토</FONT>"
			End Select

			Do While Not objRs.EOF
				Counter = CInt(objRs(0))

				All_Count = intRC
				if All_Count < 1 Then		All_Count = 1
				Wid = Counter/All_Count * 100
'				If Wid < 1 Then	Wid = 1

				strPrint = strPrint & "<TR OnmouseOver=""this.style.backgroundColor='#F3F3F3';return true;""  OnmouseOut=""this.style.backgroundColor='';return true;"" Height=""25"">" & vbCRLF
				strPrint = strPrint & vbTab & "<TD Align=""center"" height=""35"">"& W &" 요일</TD>" & vbCRLF
				strPrint = strPrint & vbTab & "<TD><IMG SRC=""orange.gif"" WIDTH=""" & Wid & "%"" HEIGHT=""10"" BORDER=""0"" ALT="""" align=""absmiddle""> <A Style=""Font-SIZE:8pt"">"& Round(Wid, 2) &" %</A></TD>" & vbCRLF
				strPrint = strPrint & vbTab & "<TD Align=""center"">"& Counter &"</TD>" & vbCRLF
				strPrint = strPrint & "</TR>" & vbCRLF
				strPrint = strPrint & "<tr><td  colspan=3 height=1 bgcolor='#808080'></td></TR>" &vbCRLF
				objRs.moveNext
			Loop

			Call CloseRS(objRs)
		Next
	Case "nDay"	'Day ============================================================================================
		Title = "날짜"

		FilterString = "convert(char(10), log_nDate, 20) between '"& sDate &"' and '"& eDate &"'"
		Result = SelectValueCommand(objRs, "Count(*)", "count_log", FilterString, "", "")
		intRC = CInt(objRs(0))
		Call CloseRS(objRs)

		For idx = 1 To 31
			FilterString = "log_nDay= '"& idx &"'"
			FilterString = FilterString & " and convert(char(10), log_nDate, 20) between '"& sDate &"' and '"& eDate &"'"
			Result = SelectValueCommand(objRs, "Count(*)", "count_log", FilterString, "", "")

			If Len(idx) < 2 Then		idx = "0" & idx	

			Do While Not objRs.EOF
				Counter = Cint(objRs(0))

				All_Count = intRC
				if All_Count < 1 Then		All_Count = 1
				Wid = Counter/All_Count * 100
'				If Wid < 1 Then	Wid = 1

				strPrint = strPrint & "<TR OnmouseOver=""this.style.backgroundColor='#F3F3F3';return true;""  OnmouseOut=""this.style.backgroundColor='';return true;"" Height=""25"">" & vbCRLF
				strPrint = strPrint & vbTab & "<TD Align=""center"" height=""35"">"& idx &"일</TD>" & vbCRLF
				strPrint = strPrint & vbTab & "<TD><IMG SRC=""orange.gif"" WIDTH=""" & Wid & "%"" HEIGHT=""10"" BORDER=""0"" ALT="""" align=""absmiddle""> <A Style=""Font-SIZE:8pt"">"& Round(Wid, 2) &" %</A></TD>" & vbCRLF
				strPrint = strPrint & vbTab & "<TD Align=""center"">"& Counter &"</TD>" & vbCRLF
				strPrint = strPrint & "</TR>" & vbCRLF
				strPrint = strPrint & "<tr><td  colspan=3 height=1 bgcolor='#808080'></td></TR>" &vbCRLF
				objRs.moveNext
			Loop

			Call CloseRS(objRs)
		Next
	Case "nMonth"	'month ============================================================================================
		Title = "월"

		FilterString = "log_nYear between '"& sYear &"' and '"& eYear &"'"
		Result = SelectValueCommand(objRs, "Count(*)", "count_log", FilterString, "", "")
		intRC = CInt(objRs(0))
		Call CloseRS(objRs)

		For idx = 1 To 12
			FilterString = "log_nMonth= '"& idx &"'"
			FilterString = FilterString & " and log_nYear between '"& sYear &"' and '"& eYear &"'"

			Result = SelectValueCommand(objRs, "Count(*)", "count_log", FilterString, "", "")

			If Len(idx) < 2 Then		idx = "0" & idx	

			Do While Not objRs.EOF
				Counter = Cint(objRs(0))

				All_Count = intRC
				if All_Count < 1 Then		All_Count = 1
				Wid = Counter/All_Count * 100
'				If Wid < 1 Then	Wid = 1

				strPrint = strPrint & "<TR OnmouseOver=""this.style.backgroundColor='#F3F3F3';return true;""  OnmouseOut=""this.style.backgroundColor='';return true;"" Height=""25"">" & vbCRLF
				strPrint = strPrint & vbTab & "<TD Align=""center"" Align=""center"" height=""35"">"& idx &"월</TD>" & vbCRLF
				strPrint = strPrint & vbTab & "<TD><IMG SRC=""orange.gif"" WIDTH=""" & Wid & "%"" HEIGHT=""10"" BORDER=""0"" ALT="""" align=""absmiddle""> <A Style=""Font-SIZE:8pt"">"& Round(Wid, 2) &" %</A></TD>" & vbCRLF
				strPrint = strPrint & vbTab & "<TD Align=""center"">"& Counter &"</TD>" & vbCRLF
				strPrint = strPrint & "</TR>" & vbCRLF
				strPrint = strPrint & "<tr><td  colspan=3 height=1 bgcolor='#808080'></td></TR>" &vbCRLF
				objRs.moveNext
			Loop

			Call CloseRS(objRs)
		Next
	Case "nYear"	'Year ============================================================================================
		Title = "년"

		Result = SelectValueCommand(objRs, "Count(*)", "count_log", "", "", "")
		intRC = CInt(objRs(0))
		Call CloseRS(objRs)

		Result = SelectValueCommand(objRs, "log_nYear, Count(log_nYear)", "count_log", "", "log_nYear", "log_nYear DESC")

		If Result <> "Empty" Then
			Do While Not objRs.EOF
				log_nYear = CInt(objRs(0))
				Counter = CInt(objRs(1))

				All_Count = intRC
				if All_Count < 1 Then		All_Count = 1
				Wid = Counter/All_Count * 100
'				If Wid < 1 Then	Wid = 1

				strPrint = strPrint & "<TR OnmouseOver=""this.style.backgroundColor='#F3F3F3';return true;""  OnmouseOut=""this.style.backgroundColor='';return true;"" Height=""25"">" & vbCRLF
				strPrint = strPrint & vbTab & "<TD Align=""center""  height=""35"">"& log_nYear &"년</TD>" & vbCRLF
				strPrint = strPrint & vbTab & "<TD><IMG SRC=""orange.gif"" WIDTH=""" & Wid & "%"" HEIGHT=""10"" BORDER=""0"" ALT="""" align=""absmiddle""> <A Style=""Font-SIZE:8pt"">"& Round(Wid, 2) &" %</A></TD>" & vbCRLF
				strPrint = strPrint & vbTab & "<TD Align=""center"">"& Counter &"</TD>" & vbCRLF
				strPrint = strPrint & "</TR>" & vbCRLF
				strPrint = strPrint & "<tr><td  colspan=3 height=1 bgcolor='#808080'></td></TR>" &vbCRLF
				objRs.moveNext
			Loop

			Call CloseRS(objRs)
		Else
			strPrint = strPrint & "<TR OnmouseOver=""this.style.backgroundColor='#F3F3F3';return true;""  OnmouseOut=""this.style.backgroundColor='';return true;"" Height=""25"">" & vbCRLF
			strPrint = strPrint & vbTab & "<TD Align=""center""  height=""35"">"& log_nYear &"년</TD>" & vbCRLF
			strPrint = strPrint & vbTab & "<TD><IMG SRC=""orange.gif"" WIDTH=""1"" HEIGHT=""10"" BORDER=""0"" ALT="""" align=""absmiddle""></TD>" & vbCRLF
			strPrint = strPrint & vbTab & "<TD Align=""center"">0</TD>" & vbCRLF
			strPrint = strPrint & "</TR>" & vbCRLF
			strPrint = strPrint & "<tr><td  colspan=3 height=1 bgcolor='#808080'></td></TR>" &vbCRLF
		End If
	Case Else	'nHour ============================================================================================
		Title = "시간"

		start_date = dateserial(sYear, smonth, sDay)
		end_date = dateserial(eYear, emonth, eDay)

		FilterString = "convert(char(10), log_nDate, 20) between '"& start_date &"' and '"& end_date &"'"
		Result = SelectValueCommand(objRs, "Count(*)", "count_log", FilterString, "", "")
		intRC = CInt(objRs(0))
		Call CloseRS(objRs)
		
		For idx = 0 To 23
			FilterString = "log_nHour= '"& idx &"'"
			FilterString = FilterString & " and convert(char(10), log_nDate, 20) between '"& start_date &"' and '"& end_date &"'"

			Result = SelectValueCommand(objRs, "Count(*)", "count_log", FilterString, "", "")

			If Len(idx) < 2 Then		idx = "0" & idx	

			Do While Not objRs.EOF
				Counter = Cint(objRs(0))

				All_Count = intRC
				if All_Count < 1 Then		All_Count = 1
				Wid = Counter/All_Count * 100
'				If Wid < 1 Then	Wid = 1
				strPrint = strPrint & "<TR OnmouseOver=""this.style.backgroundColor='#F3F3F3';return true;""  OnmouseOut=""this.style.backgroundColor='';return true;"" Height=""25"">" & vbCRLF
				strPrint = strPrint & vbTab & "<TD Align=""center""  height=""35"">"& idx &"시 00분 ~ " & idx & "시 59분</TD>" & vbCRLF
				strPrint = strPrint & vbTab & "<TD><IMG SRC=""orange.gif"" WIDTH=""" & Wid & "%"" HEIGHT=""10"" BORDER=""0"" ALT="""" align=""absmiddle""> <A Style=""Font-SIZE:8pt"">"& Round(Wid, 2) &" %</A></TD>" & vbCRLF
				strPrint = strPrint & vbTab & "<TD Align=""center"">"& Counter &"</TD>" & vbCRLF
				strPrint = strPrint & "</TR>" & vbCRLF
				strPrint = strPrint & "<tr><td  colspan=3 height=1 bgcolor='#808080'></td></TR>" &vbCRLF
				objRs.moveNext
			Loop

			Call CloseRS(objRs)	'개체 닫기
		Next
End Select

Select Case mode
	Case "nHour"		subTitle =  "[시간별 접속 통계]"
	Case "nWeek"		subTitle =  "[요일별 접속 통계]"
	Case "nDay"			subTitle =  "[날짜별 접속 통계]"
	Case "nMonth"		subTitle =  "[월별 접속 통계]"
	Case "nYear"		subTitle =  "[년도별 접속 통계]"
	Case Else			subTitle =  "[시간별 접속 통계]"
End Select

' Start Year
For i = 2003 To Year(sDate)
	strYear = strYear & "<OPTION VALUE=" & i
	If CInt(sYear) = i Then		strYear = strYear & " selected "
	strYear = strYear &"> "& i &"</OPTION>" & vbCRLF
Next

' Start month
For i = 1 To 12
	strmonth = strmonth & "<OPTION VALUE=" & i
	If CInt(smonth) = i Then strmonth = strmonth & " selected "
	strmonth = strmonth & "> " & i & "</OPTION>" & vbCRLF
Next

' Start Day
For i = 1 To 31
	strDay = strDay & "<OPTION VALUE=" & i
	If CInt(sDay) = i Then strDay = strDay & " selected "
	strDay = strDay & "> " & i & "</OPTION>" & vbCRLF
Next

' End Year
For i = 2003 To Year(eDate)
	endYear = endYear & "<OPTION VALUE=" & i
	If CInt(eYear) = i Then		endYear = endYear & " selected "
	endYear = endYear &"> "& i &"</OPTION>" & vbCRLF
Next

' End month
For i = 1 To 12
	endmonth = endmonth & "<OPTION VALUE=" & i
	If CInt(emonth) = i Then endmonth = endmonth & " selected "
	endmonth = endmonth & "> " & i & "</OPTION>" & vbCRLF
Next

' End Day
For i = 1 To 31
	endDay = endDay & "<OPTION VALUE=" & i
	If CInt(eDay) = i Then endDay = endDay & " selected "
	endDay = endDay & "> " & i & "</OPTION>" & vbCRLF
Next


'데이터의 존재여부를 파악하고, 존재시 레코드의 전진과 후진이 가능하며, 오로지 읽기 전용으로 이용된다.
Function SelectValueCommand(rsInput, FieldName, TableName, FilterString, GroupField, OrderField)
	SQL = "select "& FieldName &" from " & TableName
	If FIlterString <> "" Then	SQL = SQL & " where " & FilterString 
	If GroupField <> "" Then	SQL = SQL & " group by " & GroupField
	If OrderField <> "" Then	SQL = SQL & " order by " & OrderField

	Set rsInput = Server.CreateObject("ADODB.RecordSet")	
	rsInput.Open SQL, dbConn, 3, 1

	If rsInput.EOF Then
		Result = "Empty"
		DBConn.Close
		Set DBConn = Nothing
	Else
		Result = "NotEmpty"
	End If
response.write sql
	SelectValueCommand = Result
End Function

Sub CloseRS(rsInput)
	rsInput.Close
	Set rsInput = Nothing
End Sub

Sub CloseDB()
	dbConn.Close
	Set dbConn = Nothing
End Sub
%>