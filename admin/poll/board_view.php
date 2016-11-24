<?
$mode = $_REQUEST['mode'];
$idx = $_REQUEST['idx'];
$page = $_REQUEST['page'];

$search = $_REQUEST['search'];
$strsearch = $_REQUEST['strsearch'];

include $_SERVER["DOCUMENT_ROOT"]."/admin/include/header.php";

$searchand = " and bd_gubun='$mode'";
if ($strsearch){
	$searchand .= " and $search like '%$strsearch%'";
}
 
if ($idx){
	$result = QRY_BOARD_VIEW($idx);
	$row = mysql_fetch_array($result);
	//$idx = replace_out($row["bd_idx"]);	
	$title = replace_out($row["bd_title"]);
	$title_sub = replace_out($row["bd_title_sub"]);
	$name = replace_out($row["bd_mem_name"]);
	$mem_level = replace_out($row["bd_mem_level"]);
	$email = replace_out($row["bd_email"]);			
	$content = replace_out($row["bd_content"]);
	$notice = replace_out($row["bd_notice"]);	
	$log_date = substr(replace_out($row["reg_date"]),0,10);
	$cate = replace_out($row["bd_cate"]);
	$typ = "edit";
	
	if ($mem_level){
		$mem_level = sprintf('%02d', $mem_level);
	}
}else{           
	$typ = "write";
	$name = $_SESSION["ADMIN_NAME"];
	$bd_day = date('Y-m-d');
}

?>
<script type="text/javascript" src="/admin/SE_/js/HuskyEZCreator.js" charset="utf-8"></script>
<script type="text/javascript" src="/include/calendar.js"></script>
<script type="text/javascript">
<!--
	function check(){
		var f =  document.f;

		oEditors.getById["ir1"].exec("UPDATE_IR_FIELD", []);     //스마트에디터 삽입
	    f.content.value = document.getElementById("ir1").value;     //스마트에디터 삽입		

		//if (trim(f.title.value)==""){
		//	alert("제목을 입력해주세요.");
		//	f.title.focus();
		//	return;
		//}
		//if (trim(f.content.value)==""){
		//	alert("내용을 입력해주세요.");
		//	return;
		//}
		f.encoding = "multipart/form-data";
		f.action = "board_proc.php?<?=$param?>"
		f.submit();
	}
	
	

	function img_del(id,file,num){
		if (confirm("파일을 삭제하시겠습니까? ")==true){
			document.f.temp_file.value = file;
			document.f.target = "imgdelifr";
			document.f.action ="/include/filedelete1.php?mode=<?=$mode?>&file_idx="+id+"&num="+num;
			document.f.submit();
		}
	}

	function del(){
		if (confirm("삭제하시겠습니까?")==true){
			document.f.typ.value = "del";
			document.f.action = "board_proc.php?<?=$param?>";
			document.f.encoding = "multipart/form-data";
			document.f.submit();
			
		}
	}

	function srh_exe(obj){
		var idx = obj.value;
		alert(idx)
		location.href = "board_write.php?<?=$param?>&idx="+idx;
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

						<!--오른쪽 시작-->

						<br />
						<table width="99%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td height="40" class="rtitle01"><img src="/admin/img/icon_02.gif" width="15" height="15" vspace="3" align="absmiddle" /> <?=$title_text?></td>
							</tr>
						</table>
						
						<iframe name="imgdelifr" id="imgdelifr" src="" width="500" height="0" frameborder="0" title="이미지 삭제 프로시져 프레임"></iframe>						
						<form name="f" method="post">
						<input type="hidden" name="mode" value="<?=$mode?>">
						<input type="hidden" name="typ" value="<?=$typ?>">
						<input type="hidden" name="idx" value="<?=$idx?>">
						<input type="hidden" name="filecnt" value="5">
						<input type="hidden" name="temp_file" value="" title="단수이미지 삭제">
						<input type="hidden" name="path" value="<?=$file_path?>" title="이미지 삭제 경로">	
						<table width="99%" border="0" cellspacing="1" cellpadding="5" bgcolor="#e6e6e6">
							
							<tr>
								<td  width="150" align="center" bgcolor="#f6f6f6" class="btitle02"> 작성자  </td>
								<td bgcolor="#FFFFFF">
								<?if ($mem_level){?>
								[<font color="#0000ff"><?=get_this("code","title","code",$mem_level)?></font>]
								<?}?>
								<?=$name?></td>
							</tr>													
							<tr>
								<td width="150" align="center" bgcolor="#f6f6f6" class="btitle02">제목</td>
								<td bgcolor="#FFFFFF"><?If(notice=="y"){?> [공지] <?}?><?=$title?>
								
								</td>
							</tr>
							<!-- 파일 업로드 시작 -->
							<?
							if (substr($mode,0,2) != "ZZ") {
									$si=0;
									$ei=5;	
							?>
							<?For ($i=$si;$i<=$ei;$i++){?>
								<?
								If($idx){
									If ($row["bd_file".$i]){									
								?>
								<tr>
									<td align="center" bgcolor="#f6f6f6" class="btitle02"><?If ($i<5){?>이미지<?}else{?>첨부파일<? } ?></td>
									<td  bgcolor="#FFFFFF" valign="middle">	    
									<?
									$file_kind = strtolower(substr(  $row["bd_file".$i], -3)) ;
									if(  $file_kind == "gif" or $file_kind == "jpeg" or  $file_kind == "jpg" or  $file_kind == "png" ){
									?>
									<img src="<?=$file_path?><?=$row["bd_file".$i]?>"><br>
									<?  }  ?>		
									<a href="/include/filedownload.php?filename=<?=$row["bd_file".$i]?>&path=<?=$file_path?>"    target="_net" ><?=$row["bd_file".$i]?></a><!--target="_new"-->
									</td>
								</tr>
								<input type="hidden" name="file_o<?=$i?>" value="<?=$row["bd_file".$i]?>">
									<? } ?>
								<? } ?>

								
							<? } ?>
							<? } ?>
							<!-- 파일 업로드 끝 -->
							
							
							
							
							<tr>
								<td align="center" bgcolor="#f6f6f6" class="btitle02">내용</td>
								<td bgcolor="#FFFFFF"><textarea name="content" style="display:none"></textarea>
								<textarea name="ir1" id="ir1" style="width:98%;height:300px;display:none;"><?=$content?></textarea></td>
							</tr>
							
						</form>
						</table>
						
						<br />
						<?
						include "board_comment.php";
						?>

						<br>
						<table width="99%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td height="40" align="center" class="rtitle01">
								<span class="btn1"><a href="javascript:check();">확인</a></span>
								<?If( $mode!="ZZ001"){?>
								<?If( $typ=="edit"){?><span class="btn1"><a href="javascript:del();">삭제</a></span><?}?>
								<span class="btn1"><a href="board_list.php?<?=$param?>">목록</a></span>
								<?}?>
							<!-- 	<a href="javascript:checkaaaa();"> eeeee </a>  -->
								
								
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
