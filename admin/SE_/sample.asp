<script type="text/javascript" src="/admin/se/js/HuskyEZCreator.js" charset="utf-8"></script>
<textarea name="content" style="display:none"></textarea>
<textarea name="ir1" id="ir1" style="width:98%;height:300px;display:none;"><%=content%></textarea>
<script language="javascript">
  // 이미지업로드 경로
  var imagepath = "/Se_Up";
  var hei = "300"
  var oEditors = [];
	nhn.husky.EZCreator.createInIFrame({
		oAppRef: oEditors,
		elPlaceHolder: "ir1",
		sSkinURI: "/admin/se/seditorskin.html",	
		htParams : {
			bUseToolbar : true,				// 툴바 사용 여부 (true:사용/ false:사용하지 않음)
			bUseVerticalResizer : true,		// 입력창 크기 조절바 사용 여부 (true:사용/ false:사용하지 않음)
			bUseModeChanger : true,			// 모드 탭(Editor | HTML | TEXT) 사용 여부 (true:사용/ false:사용하지 않음)
			fOnBeforeUnload : function(){
				//alert("아싸!");	
			}
		}, //boolean
		fOnAppLoad : function(){
			//예제 코드
			//oEditors.getById["ir1"].exec("PASTE_HTML", ["로딩이 완료된 후에 본문에 삽입되는 text입니다."]);
		},
		fCreator: "createSEditor2"
	});

  
</script>
