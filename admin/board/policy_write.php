<?
include $_SERVER["DOCUMENT_ROOT"]."/admin/include/header.php";

$result = QRY_BOARD_VIEW2($mode);
$row = mysql_fetch_array($result);

if($row){
	$idx = replace_out($row["bd_idx"]);	
	$title = replace_out($row["bd_title"]);
	$content = replace_out($row["bd_content"]);
	$typ = "edit";
}else{           
	$typ = "write";
	$name = $_SESSION["ADMIN_NAME"];
}
?>
<script type="text/javascript" src="/admin/SE_/js/HuskyEZCreator.js" charset="utf-8"></script>
<script type="text/javascript">
<!--
	function check(){
		var f =  document.f;

		f.encoding = "multipart/form-data";
		f.action = "board_proc.php?<?=$param?>"
		f.submit();
	}
	
//-->
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td height="30" background="/admin/img/now_bg.gif" style="padding-left: 20px" class="now"><img src="/admin/img/icon.gif" width="9" height="7" /> HOME &gt; 사이트관리  </td>
	</tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="208" valign="top"><!--메뉴-->
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

						<!--오른쪽 시작-->

						<br />
						<table width="99%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td height="40" class="rtitle01"><img src="/admin/img/icon_02.gif" width="15" height="15" vspace="3" align="absmiddle" /> <?=$title_text?></td>
							</tr>
						</table>
						
						
						<form name="f" method="post">
						<input type="hidden" name="mode" value="<?=$mode?>">
						<input type="hidden" name="typ" value="<?=$typ?>">
						<input type="hidden" name="idx" value="<?=$idx?>">
						<input type="hidden" name="title" value="<?=$title_text?>">
						<input type="hidden" name="list_url" value="/admin/board/policy_write.php">
						<table width="99%" border="0" cellspacing="1" cellpadding="5" bgcolor="#e6e6e6">							
							
							<tr>
								<td align="center" bgcolor="#f6f6f6" class="btitle02">내용</td>
								<td bgcolor="#FFFFFF">
								

								<script type="text/javascript" src="/ckeditor/ckeditor.js"></script>
								<script>
/**
								   CKEDITOR.replace('editor',{ 
										language : 'kor' ,
										width:'770', 										
										height:'800',
								   }); 
	--*/							</script>



								<textarea id="content" name="content" rows="20" cols="100"  style="width:100%;"><?=$content?></textarea>
								
								<!--<textarea name="content" style="display:none"></textarea>
								<textarea name="ir1" id="ir1" style="width:98%;height:300px;display:none;"><?=$content?></textarea>--></td>
							</tr>
						</form>
						</table>
						
						<br />
						<table width="99%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td height="40" align="center" class="rtitle01">
								<span class="btn1"><a href="javascript:check();">확인</a></span>								
					
								</td>
							</tr>
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
<?
include $_SERVER["DOCUMENT_ROOT"]."/admin/include/footer.php";
?>

<script language="javascript">
  // 이미지업로드 경로
  var imagepath = "<?=$se_path?>";
  var hei = "350"
  var oEditors = [];
	nhn.husky.EZCreator.createInIFrame({
		oAppRef: oEditors,
		elPlaceHolder: "ir1",
		sSkinURI: "/admin/SE_/SEditorSkin.html",	
		htParams : {
			bUseToolbar : true,				// 툴바 사용 여부 (true:사용/ false:사용하지 않음)
			bUseVerticalResizer : false,		// 입력창 크기 조절바 사용 여부 (true:사용/ false:사용하지 않음)
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
