<script type="text/javascript" src="/admin/se/js/HuskyEZCreator.js" charset="utf-8"></script>
<textarea name="content" style="display:none"></textarea>
<textarea name="ir1" id="ir1" style="width:98%;height:300px;display:none;"><%=content%></textarea>
<script language="javascript">
  // �̹������ε� ���
  var imagepath = "/Se_Up";
  var hei = "300"
  var oEditors = [];
	nhn.husky.EZCreator.createInIFrame({
		oAppRef: oEditors,
		elPlaceHolder: "ir1",
		sSkinURI: "/admin/se/seditorskin.html",	
		htParams : {
			bUseToolbar : true,				// ���� ��� ���� (true:���/ false:������� ����)
			bUseVerticalResizer : true,		// �Է�â ũ�� ������ ��� ���� (true:���/ false:������� ����)
			bUseModeChanger : true,			// ��� ��(Editor | HTML | TEXT) ��� ���� (true:���/ false:������� ����)
			fOnBeforeUnload : function(){
				//alert("�ƽ�!");	
			}
		}, //boolean
		fOnAppLoad : function(){
			//���� �ڵ�
			//oEditors.getById["ir1"].exec("PASTE_HTML", ["�ε��� �Ϸ�� �Ŀ� ������ ���ԵǴ� text�Դϴ�."]);
		},
		fCreator: "createSEditor2"
	});

  
</script>
