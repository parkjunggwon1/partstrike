<?
function GF_GET_BOARD_LIST($page, $mode, $recordcnt,$strsearch){
	global $viewpagecnt;

?>	
<SCRIPT LANGUAGE="JavaScript">
$(document).ready(function(){
	var recordcnt = document.getElementById("recordcnt").value;
	var mode = document.getElementById("mode").value
	$(".pagination a.link").click(function(){
			showajaxParam("#boardleftTop", "boardlist", "page="+$(this).attr("num")+"&wantcnt="+recordcnt+"&mode="+mode);

	});		

	$(".board-list tbody a").on("click",function(){
		$(".board-list tbody a").removeClass("c-blue");
		$(this).addClass("c-blue");
	});

	$('.onlyEngNum').keydown(function(event){ 		//ENG, 숫자만 입력하게.(.도 포함) 	
	
	  if (event.which && (event.which == 13 || event.which == 190 || event.which == 110 || event.which > 45 && event.which < 58 || event.which == 8 || event.which > 64 && event.which < 91|| event.which > 95 && event.which < 123 || event.which==229)) {	
		
	   } else { 
	   event.preventDefault(); 
	  } 
	});
 });


</SCRIPT>
<?
if ($strsearch){
	$searchand = $searchand." and bd_title like '%$strsearch%'";
}
$searchand = $searchand." and bd_gubun='$mode'";
$cnt = QRY_CNT("board",$searchand);
$totalpage = QRY_TOTALPAGE($cnt,$recordcnt);
$resultno =QRY_BOARD_LISTNO(10,$searchand);
$searchand = $searchand." and bd_notice!='Y'";
$result =QRY_BOARD_LIST($recordcnt,$searchand,$page);

?>
<?if($mode=="AA001"){?>
	<?if($_SESSION["MEM_IDX"]){?>
		<div class="f-rt"><a href="javascript:blacklist();"><img src="/kor/images/btn_blacklist.png" alt="Black List"></a></div>
	<?}else{?>
		<div class="f-rt"><img src="/kor/images/btn_blacklist_1.png" alt="Black List"></div>
	<?}?>	
<?}?>			

<section class="box-type5 srch1">
	<form name="searchfrm" id="searchfrm" method="post">
	<input type="hidden" id="mode" value="<?=$mode?>">
	<input type="hidden" id="recordcnt" value="<?=$recordcnt?>">
		<table>
			<tbody>
				<tr>
					<th scope="row" class="t-rt" style="width:80px">단어</th>
					<td>
						<input type="text" class="onlyEngNum" style="width:205px" lang="ko" name="strsearch" value="<?=$strsearch?>" onkeypress="check_key_board(board_sch);" >
					</td>
					<td><button type="button" onclick="board_sch();"><img src="/kor/images/btn_srch.gif" alt="검색" ></button></td>
				</tr>
			</tbody>
		</table>
	</form>
</section>

<section class="box-type1" >				

	<div class="hd-type-wrap">
		<table class="stock-list-table board-list">
			<thead>
				<tr>
					<th scope="col" lang="en" style="width:40px">No.</th>
					<?if($mode=="AA002" or $mode=="AA003"){?><th scope="col" style="width:80px">Nation</th><? } ?>
					<th scope="col" lang="en" class="t-lt">Subject</th>
					<th scope="col" lang="en" style="width:100px">Date</th>
				</tr>
			</thead>
			<tbody>
				<?if($mode=="AA003"){?>
				<tr>
					<td colspan="4" class="pd-0">
						<p class="panel1 t-lt" lang="ko">이 사이트에 적용되어야 한다고 생각되는 어떠한 개선사항이라도 제안할 수 있습니다.  <br>
						제안하신 의견이 좋은 의견이라고 판단되면 빠른 시일 내로 의견을 반영하도록 하겠습니다. </p>
					</td>
				</tr>
				<?}?>
				<?
				while($rowno = mysql_fetch_array($resultno)){
					$idx = replace_out($rowno["bd_idx"]);
					$title = replace_out($rowno["bd_title"]);
					$name = replace_out($rowno["bd_mem_name"]);
					$comment_num = replace_out($rowno["bd_comment_num"]);
					$hit = replace_out($rowno["bd_hit"]);
					$log_date = str_replace("-",".",substr(replace_out($rowno["reg_date"]),2,8));
					//$log_date = str_replace("-","-",substr(replace_out($rowno["reg_date"]),0,10));
					$date=date_create($log_date);
					$log_date_2=date_format($date,"d M Y");
					
					//$newimg = "";
					//if( strtotime(date("Y-m-d"))-strtotime($log_date)<=432000){
					//	$newimg="<img src='/images/common/icon_new01.gif'/>";
					//}
				?>	
				<tr>
					<td>[NOTICE]</td>
					<td class="t-lt" lang="ko"><a href="javascript: board_det(<?=$idx?>);"><?=get_cut($title,60,"...")?> <?=get_comment($comment_num)?></a></td>
					<td><?=$log_date_2?></td>
				</tr>
				<? } ?>
				<!--일반게시글 시작-->
				<?
				if ($cnt==0){
				?>
				<tr>
					<td colspan="5"></td>
				</tr>
				<?
				}
				$ListNO=$cnt-(($page-1)*$recordcnt);
				$i=0;
				while($row = mysql_fetch_array($result)){
					$i=$i+1;	
					$idx = replace_out($row["bd_idx"]);
					$mem_idx = replace_out($row["bd_mem_idx"]);
					$mode = replace_out($row["bd_gubun"]);
					$title = replace_out($row["bd_title"]);
					$name = replace_out($row["bd_mem_name"]);
					$comment_num = replace_out($row["bd_comment_num"]);
					$hit = replace_out($row["bd_hit"]);
					$secret = replace_out($row["bd_secret"]);
					$nation = replace_out($row["bd_mem_nation"]);
					if ($bgcolor == "background-color:#f7f7f7;" || $bgcolor=="") { 
						$bgcolor="background-color:#ffffff;";
					}else{
						$bgcolor ="background-color:#f7f7f7;";
					}
					$log_date = str_replace("-","-",substr(replace_out($row["reg_date"]),0,10));
					$date=date_create($log_date);
					$log_date_2=date_format($date,"d M Y");
					$ref = replace_out($row["bd_ref"]);
					$lev = replace_out($row["bd_lev"]);
					$step = replace_out($row["bd_step"]);
				?>
				<?if($lev>0){?>
				<tr style="<?=$bgcolor?>">
					<td>&nbsp;</td>
					<?if($mode=="AA002" or $mode=="AA003"){?><td>&nbsp;</td><? } ?>
					<td class="t-lt"  lang="ko">
					<?if($secret=="Y" and $_SESSION["MEM_IDX"]!=$mem_idx){?>
					<a href="javascript:alert_msg('비공개 글입니다')">
					<?}else{?>
					<a board_idx="<?=$idx?>" href="javascript: board_det(<?=$idx?>);">
					<?}?>
					<?if($step>1){?><?for($j=1;$j<$step;$j++){?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?}?><?}?>
					<?if($mem_idx=="0"){?><img src="/kor/images/board_arrow_blue.png"><?}else{?><img src="/kor/images/board_arrow_black.png"><?}?>
					<?=get_cut($title,60,"...")?> <?=get_comment($comment_num)?></a></td>
					<td><?//=$log_date?><?= $log_date_2?></td>
				</tr>
				<?}else{?>
				<tr style="<?=$bgcolor?>">
					<td><?=$ListNO?></td>
					<?if($mode=="AA002" or $mode=="AA003"){?><td><img src="/kor/images/nation_title2_<?=$nation?>.png" alt="United "></td><? } ?>
					<td class="t-lt"  lang="ko">
					<?if($secret=="Y" and $_SESSION["MEM_IDX"]!=$mem_idx){?>
					<a href="javascript:alert_msg('비공개 글입니다')">
					<?}else{?>
					<a board_idx="<?=$idx?>" href="javascript: board_det(<?=$idx?>);">
					<?}?>
					<?=get_cut($title,60,"...")?> <?=get_comment($comment_num)?></a></td>
					<td><?//=$log_date?><?= $log_date_2?></td>
				</tr>
				<?}?>
				<? 
					$ListNO--;
				} 
				?>
			</tbody>
		</table>
	</div>
	<?if($mode=="AA002" or $mode=="AA003"){?>
	<div class="btn-area">
		<a href="#" class="f-rt msg-02" mode="<?=$mode?>"><img src="/kor/images/btn_write.gif" alt="글쓰기" ></a>
		<!--<a href="javascript: board_write('<?=$mode?>','')" class="f-rt msg-02"><img src="/kor/images/btn_write.gif" alt="글쓰기" ></a>-->
	</div>
	<?}?>
	<div class="pagination">
		<? include $_SERVER["DOCUMENT_ROOT"]."/include/paging2.php"; ?>									
	</div>
</section>

<?}?>

<?
function GF_GET_BOARD_WRITE($mode, $board_idx){
	global $viewpagecnt;

?>	
<?
if($idx){
	$result = QRY_BOARD_VIEW($idx);
	$row = mysql_fetch_array($result);

	$typ="edit";
}else{
	$typ="write";
}
?>
<br>
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

<section class="box-type1 write-form">
	<div class="box-top">
		<h2>글쓰기</h2>
	</div>
	<form name="writefrm"  id="writefrm"  method="post">
	<input type="hidden" name="mode" value="<?=$mode?>">
	<input type="hidden" name="typ" id="typ" value="<?=$typ?>">
	<input type="hidden" name="idx" id="idx" value="<?=$idx?>">
	<input type="hidden" name="no" value="">
		<p class="panel1"><label class="ipt-chk chk4 f-rt" lang="ko"><input type="checkbox" name="secret" value="Y"><span></span>비공개</label>
			질문사항이 있다면, 게시판에 모국어로 글을 남겨주시기 바랍니다.</p>
		<table>
			<tbody>
				<tr>
					<th scope="row">제목 : </th>
					<td colspan="2"><input type="text" class="i-txt5" style="width:222px" name="title"></td>
				<tr>
					<td colspan="3" class="edit-col">
						<script type="text/javascript" src="/ckeditor/ckeditor.js"></script>
						<script>

						   CKEDITOR.replace('editor',{ 
								language : 'kor' ,
								width:'770', 										
								height:'150',
						   }); 
						</script>






						 <!-- <script type="text/javascript">
							$(document).ready(function() {
							  $('.summernote').summernote({
								height: 200,
								tabsize: 2,
								styleWithSpan: false
							  });
							});
						  </script>-->
						<textarea id="editor" name="content" rows="12" cols="125" ></textarea>
						<!--<textarea name="content" style="display:none"></textarea>
						<textarea name="ir1" id="ir1" style="width:600px;height:80px;display:none"><?=$content?></textarea>-->
					</td>
				</tr>
				<tr>
					<th scope="row">파일 / 사진 :</th>
					<td lang="en" class="img-cntrl-list">
					<?=fnFileBoard(1,2,"",$idx)?>
					</td>	
				</tr>
			</tbody>
		</table>
		<div class="btn-area t-rt">
			<button type="button" onclick="board_check();"><img src="/kor/images/btn_apply.gif" alt="등록"></button>
			<button type="button" onclick="board('<?=$mode?>');"><img src="/kor/images/btn_cancel.gif" alt="취소"></button>
		</div>
	</form>
</section>
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


//-->
</script>

<?}?>
