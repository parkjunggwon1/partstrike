<% @LANGUAGE='VBSCRIPT' CODEPAGE='65001' %>
<%
	 Session.CodePage = 65001
  Response.Charset = "UTF-8"
   Response.Expires = -10000
   Server.ScriptTimeOut = 7200
%>
<%
	mb = 10
	DefaultPath = server.mappath("/") & "\upload\se"

	Set uploadform = Server.CreateObject("DEXT.FileUpload")
	uploadform.DefaultPath = DefaultPath

	uploadform.MaxFileLen = mb*1048576
	maxsize_mb = Round(uploadform.MaxFileLen/1048576,1)
	maxsize_kb = Round(uploadform.MaxFileLen/1024,1)

	if uploadform("update_image").FileLen > 10 Then
		imagepath = trim(uploadform("imagepath"))
		irid = trim(uploadform("id"))

		file_name = uploadform("update_image").FileName
		filetype = lcase(mid(file_name, InStrRev(file_name, ".")+1)) '확장자추출
		file_size = uploadform("update_image").FileLen

		If filetype <> "jpg" AND filetype <> "gif"  AND filetype <> "png" AND filetype <> "bmp" Then
			Page_Msg_Back "JPG, GIF, PNG, BMP 파일만 업로드 할수 있습니다."
			Response.end
		End If

		If file_size > uploadform.MaxFileLen Then
			Page_Msg_Back maxsize_mb&"MB("&maxsize_kb&"KB) 이상의 사이즈인 파일은 업로드하실 수 없습니다"		
			response.end
		end if	

	   DirectoryPath = server.mappath("/") & Replace(imagepath,"/","\")
	   strFileName = file_name
	   
	   '이미지파일 이름변경 작업 시작
	   req_time = datepart("h",Now)  & datepart("n",Now)  & datepart("s",Now)  '// 일시분
	   rnd_serial = right(session.sessionID,4)
	   order_id = req_time & rnd_serial & RndomString(6)
	   
	   strFileName = order_id &"."& filetype
	   '이미지파일 이름변경 작업 끝
	   
	   strFileWholePath = GetUniqueName(strFileName, DirectoryPath)

	   uploadform("update_image").SaveAs strFileWholePath

	   Set fs = server.CreateObject("Scripting.FileSystemObject")
	   strFileName = fs.GetFileName(strFileWholePath)

		With response
		  .write "<script language=javascript>" & vbNewLine
		  .write "  opener.parent.insertIMG('" & irid & "','" & strFileName & "');" & vbNewLine
		  .write "  self.close();" & vbNewLine
		  '.write "  parent.parent.oEditors.getById[""" & irid & """].exec(""SE_TOGGLE_IMAGEUPLOAD_LAYER"");" & vbNewLine
		  .write "</script>"  & vbNewLine
	   End With
	end if	




	Function GetUniqueName(byRef strFileName, DirectoryPath)
        Dim strName, strExt
		'response.write strFileName
        strName = Mid(strFileName, 1, InstrRev(strFileName, ".") - 1)
        strExt  = Mid(strFileName, InstrRev(strFileName, ".") + 1)

        Dim fso
        Set fso = Server.CreateObject("Scripting.FileSystemObject")

        Dim bExist : bExist = True
        '우선 같은이름의 파일이 존재한다고 가정
        Dim strFileWholePath : strFileWholePath = DirectoryPath & "\" & strName & "." & strExt
        '저장할 파일의 완전한 이름(완전한 물리적인 경로) 구성
        Dim countFileName : countFileName = 0
        '파일이 존재할 경우, 이름 뒤에 붙일 숫자를 세팅함.

        Do While bExist ' 우선 있다고 생각함.
            If (fso.FileExists(strFileWholePath)) Then ' 같은 이름의 파일이 있을 때
                countFileName = countFileName + 1 '파일명에 숫자를 붙인 새로운 파일 이름 생성
                strFileName = strName & "(" & countFileName & ")." & strExt
                strFileWholePath = DirectoryPath & "\" & strFileName
            Else
                bExist = False
            End If
        Loop
        GetUniqueName = strFileWholePath
    End Function

	Function RndomString(Cnt)  '랜덤숫자문자 엇기
		str = ""
		Randomize()

		For cntArr = 1 To Cnt
			flg = Int(Rnd() * 10)
			If flg > 5 Then
				tStr = Int(Rnd() * 10)   ' 숫자 넣기
			Else
				tStr = Int(Rnd() * 26) 
				tStr = Chr(asc("a") + tStr)  ' 문자 넣기
			End If
			str = str & tStr
		Next
		RndomString = str
	End Function

	Sub Page_Msg_Back(msg)
      with response
         .write "<script language='javascript'>" & vbNewLine
         .write "  alert('" & msg & "');" & vbNewLine
         .write "  history.back();" & vbNewLine
         .write "</script>" & vbNewLine
      End with
   End Sub
%>
