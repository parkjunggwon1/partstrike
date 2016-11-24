<?
include  $_SERVER["DOCUMENT_ROOT"]."/include/dbopen.php";
include  $_SERVER["DOCUMENT_ROOT"]."/sql/sql.board.php";

?>
<?
if($ref){
	$typ="comm_write";
	$ttl="답변";
}else{
	
	$typ="write";
	if($mode=="EE001"){
		$ttl="<span lang='en'>Message</span>";	
	}else{
		$ttl="<span lang='ko'>글쓰기</span>";
	}
	
}
?>

<script type="text/javascript">
<!--
	function board_check(){
		var f =  document.writefrm;

		if (trim(f.title.value)==""){
			alert("제목을 입력해주세요.");
			f.title.focus();
			return;
		}
		f.target="proc";
		f.action = "/kor/proc/board_proc.php?<?=$param?>";
		f.encoding = "multipart/form-data";
		f.submit();
	}


//-->
</script>

<?function fnFileBoard($start,$end, $colspan,$idx){
				
	for ($i = $start;$i<= $end; $i++){
		
			if ($idx){
			$result = QRY_BOARD_VIEW($idx);
			$row = mysql_fetch_array($result);
				if ($row){
					$fileonly = replace_out($row["bd_file".$i]);
					$filename = "/upload/file/".replace_out($row["bd_file".$i]);
					$certiopen_yn = replace_out($row["certi".($i-3)."open_yn"]);
				}	
			}
			if ($fileonly==""){$filename = "/kor/images/file_pt.gif";}
		?>
		
		<div class="img-cntrl-wrap">
			<span class="img-wrap"><img alt="" id="fileimg<?=$i?>" src="<?=$filename?>" width="72" height="58"></span>
			<input name="file_o<?=$i?>" id="file_o<?=$i?>" type="hidden" value="<?=$fileonly?>">
			<input name="file<?=$i?>" id="file<?=$i?>" type="file" style="display:none;">
			<button type="button" class="editimgbtn"><img src="/kor/images/btn_img_edit.gif" alt="편집"></button>
			<button type="button" class="delimgbtn"><img src="/kor/images/btn_img_del.gif" alt="삭제"></button>
		</div>									
									
	<?}
}?>

<div class="layer-hd">
	<h1><?=$ttl?></h1>
	<a href="#" class="btn-close"><img src="/kor/images/btn_layer_close_w.png" alt="close"></a>
</div>
<div class="layer-content">
	<form name="writefrm"  id="writefrm"  method="post" class="msg-write-form">
	<input type="hidden" name="mode" value="<?=$mode?>">
	<input type="hidden" name="typ" id="typ" value="<?=$typ?>">
	<input type="hidden" name="idx" id="idx" value="<?=$idx?>">
	<input type="hidden" name="ref" value="<?=$ref?>">
	<input type="hidden" name="ref2" value="<?=$ref2?>">
	<input type="hidden" name="lev" value="<?=$lev?>">
	<input type="hidden" name="step" value="<?=$step?>">
	<input type="hidden" name="no" value="">
		<?if($mode=="EE001"){?>
		<?}else{?>
		<p class="panel1"><label class="ipt-chk chk4 f-rt" lang="ko"><input type="checkbox" name="secret" value="Y"><span></span>비공개</label>
			질문사항이 있다면, 게시판에 모국어로 글을 남겨주시기 바랍니다.</p>
		<?}?>
		<table>
			<tbody>
				<tr>
					<th scope="row" style="width:42px">제목 : </th>
					<td><input type="text" class="i-txt4" style="width:500px" name="title" maxlength="70"></td>
				</tr>
				<tr>
					<td colspan="2" class="edit-col">
						<script type="text/javascript" src="/ckeditor/ckeditor.js"></script>
						<script>

						     CKEDITOR.replace('editor1',{ 
								language : 'kor' ,
								width:'890', 										
								height:'150',
						   }); 
							//이미지 업로드창 : 기본값을 '업로드 탭'으로..2016-02-19 by ccolle..
							CKEDITOR.on('dialogDefinition', function( ev ) {
								// Take the dialog window name and its definition from the event data.
								var dialogName = ev.data.name;
								var dialogDefinition = ev.data.definition;

								if ( dialogName == 'image' ) {
									dialogDefinition.onShow = function() {
										// This code will open the Link tab.
										this.selectPage( 'Upload' );
									};
								}
							});
						</script>
						<textarea id="editor1" name="content" rows="12" cols="140" class="ckeditor"></textarea>
					</td>
				</tr>
			</tbody>
		</table>
		<!--<table>
			<tbody>
				<tr>
					<th scope="row" style="width:90px">파일 / 사진 :</th>
					<td lang="en" class="img-cntrl-list">
					<?=fnFileBoard(1,2,"",$idx)?>
					</td>
				</tr>
			</tbody>
		</table>-->
		<?if($mode=="EE001"){?>
		<div class="btn-area t-rt">
			<span><img src="/kor/images/btn_transmit_1.gif" alt="전송" id="sub"></span>
			<button style="display:none;" type="button" onclick="board_check();"><img src="/kor/images/btn_transmit.gif" alt="전송"></button>
		</div>
		<?}else{?>
		<div class="btn-area t-rt">
			<span><img src="/kor/images/btn_apply_1.gif" alt="등록" id="sub"></span>
			<button style="display:none;" type="button" onclick="board_check();"><img src="/kor/images/btn_apply.gif" alt="등록"></button>
		</div>
		<?}?>
	</form>
</div>		<!--	<button type="button"  class="msg-03"><img src="/kor/images/btn_list.gif" alt="목록"></button>-->

<iframe name="proc" id="proc" src="" width="0" height="0" frameborder="00"></iframe>		
<script type="text/javascript">
<!--
$(document).ready(function(){
 $(".editimgbtn").click(function () {
		$(this).prev().click();
	});
 $("input[type=file]").change(function(){		
	 if ($(this).val()){
		var f =  document.writefrm; 	
		
		f.typ.value="imgfileup";		 
		f.no.value = $(this).attr("name").replace("file","");
		f.target="proc";
		f.action = "/kor/proc/board_proc.php?<?=$param?>";
		f.encoding = "multipart/form-data";
		f.submit();						 
	 }
 });
 $(".delimgbtn").click(function () {
		if (confirm('정말 삭제하시겠습니까?'))
		{
			var f = document.writefrm;
			var no_val = $(this).prev().prev().attr("name").replace("file","");
			f.no.value = no_val;
			f.typ.value="imgfiledel";
			var formData = $("#writefrm").serialize(); 
			$.ajax({
				url: "/kor/proc/board_proc.php", 
				data: formData,
				encType:"multipart/form-data",
				success: function (data) {	
					if (trim(data) == "SUCCESS"){									
						$("#fileimg"+no_val).attr("src", "/kor/images/file_pt.gif");
						$("#file_o"+no_val).val("");
					}else{
						alert(data);
					}
				}
		});		
		}
	});

});


$("#writefrm input:text").keyup(function(){
	
	var f =  document.writefrm;
	if (f.title.value!=""){
		$("#writefrm .t-rt span").hide();
		$("#writefrm .t-rt button").show();
	}else{
		$("#writefrm .t-rt button").hide();	
		$("#writefrm .t-rt span").show();
	}
});
//-->
</script>
