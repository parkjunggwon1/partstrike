<?
$mode = $_REQUEST['mode'];
$idx = $_REQUEST['idx'];
$page = $_REQUEST['page'];

$search = $_REQUEST['search'];
$strsearch = $_REQUEST['strsearch'];

include $_SERVER["DOCUMENT_ROOT"]."/admin/include/header.php";

$searchand = " and gubun='$mode'";
if ($strsearch){
	$searchand .= " and $search like '%$strsearch%'";
}
 
if ($idx){
	$result = QRY_CREATE_VIEW($idx);
	$row = mysql_fetch_array($result);
	$idx = replace_out($row["idx"]);		
	$gubun = replace_out($row["gubun"]);
	$cate = replace_out($row["cate"]);
	$title = replace_out($row["title"]);
	$list_type = replace_out($row["list_type"]);	
	$write_level = replace_out($row["write_level"]);
	$view_level = replace_out($row["view_level"]);
	$secret = replace_out($row["secret"]);
	$fileup = replace_out($row["fileup"]);	
	$comm = replace_out($row["comm"]);
	$point = replace_out($row["point"]);
	$display = replace_out($row["display"]);
	$sort = replace_out($row["sort"]);
	$headyn = replace_out($row["headyn"]);
	$headtext = replace_out($row["headtext"]);
	$typ = "edit";
}else{           
	$typ = "write";
	$cnt = get_count_plus("board_create",'');
	$gubun ="BB".sprintf("%03d", $cnt); 

}
?>
<script type="text/javascript">
<!--
	function check(){
		var f =  document.f;

		if (trim(f.title.value)==""){
			alert("카테고리명을 입력해주세요.");
			f.title.focus();
			return;
		}
		
		f.encoding = "multipart/form-data";
		f.action = "create_proc.php?<?=$param?>"
		f.submit();
	}
	

	function del(){
		if (confirm("삭제하시겠습니까?")==true){
			document.f.typ.value = "del";
			document.f.action = "create_proc.php?<?=$param?>";
			document.f.encoding = "multipart/form-data";
			document.f.submit();
			
		}
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
						<input type="text" name="sort" value="<?=$sort?>">
						<table width="99%" border="0" cellspacing="1" cellpadding="5" bgcolor="#e6e6e6">
							<tr>
								<td width="150" align="center" bgcolor="#f6f6f6" class="btitle02">구분코드</td>
								<td bgcolor="#FFFFFF"><input name="gubun" type="text" maxlength="5" value="<?=$gubun?>" class="inputtext" style="width:100px;" ></td>
							</tr>
							<tr>
								<td width="150" align="center" bgcolor="#f6f6f6" class="btitle02">카테고리</td>
								<td bgcolor="#FFFFFF">
								<select name="cate">
									<?
									$cntcate = QRY_CNT("board_cate","");
									$searchand =  "  ";
									$resultcate =QRY_CATE_LIST($recordcnt,$searchand,$page);
									while($rowcate = mysql_fetch_array($resultcate)){
										$cate_idx = replace_out($rowcate["idx"]);
										$cate_title = replace_out($rowcate["title"]);
										$cate_display = replace_out($rowcate["display"]);
										$cate_sort = replace_out($rowcate["sort"]);
									?>
									<option value="<?=$cate_idx?>" <?if ($cate_idx==$cate){?>selected<?}?>><?=$cate_title?></option>
									<? } ?>
								</select></td>
							</tr>
							<tr>
								<td width="150" align="center" bgcolor="#f6f6f6" class="btitle02">게시판명</td>
								<td bgcolor="#FFFFFF"><input name="title" type="text" maxlength="30" value="<?=$title?>" class="inputtext"></td>
							</tr>
							<tr>
								<td width="150" align="center" bgcolor="#f6f6f6" class="btitle02">말머리사용</td>
								<td bgcolor="#FFFFFF"><input type="radio" name="headyn" value="Y" <?if ($headyn=="Y" or $headyn==""){?>checked<?}?>>사용 
								<input type="radio" name="headyn" value="N" <?if ($headyn=="N"){?>checked<?}?>>사용안함</td>
							</tr>
							<tr>
								<td width="150" align="center" bgcolor="#f6f6f6" class="btitle02">말머리</td>
								<td bgcolor="#FFFFFF"><input name="headtext" type="text" maxlength="150" value="<?=$headtext?>" class="inputtext"> 빈칸없이 || 로 구분,예) 가입인사||등업신청||FAQ||Q&A </td>
							</tr>
							<tr>
								<td width="150" align="center" bgcolor="#f6f6f6" class="btitle02">리스트타입</td>
								<td bgcolor="#FFFFFF"><input type="radio" name="list_type" value="list" <?if($list_type=="list" or $list_type==""){?>checked<?}?>>리스트
								<input type="radio" name="list_type" value="gallery" <?if($list_type=="gallery"){?>checked<?}?>>갤러리
								</td>
							</tr>
							<tr>
								<td width="150" align="center" bgcolor="#f6f6f6" class="btitle02">작성권한</td>
								<td bgcolor="#FFFFFF">
								<input type="radio" name="write_level" value="0" <?if($write_level=="0" or $write_level==""){?>checked<?}?>>관리자전용
								<!--<input type="radio" name="write_level" value="3" <?if($write_level=="3"){?>checked<?}?>>비회원이상-->
								<input type="radio" name="write_level" value="1" <?if($write_level=="1"){?>checked<?}?>>준회원이상
								<input type="radio" name="write_level" value="2" <?if($write_level=="2"){?>checked<?}?>>정회원이상
								</td>
							</tr>
							<tr>
								<td width="150" align="center" bgcolor="#f6f6f6" class="btitle02">상세보기권한</td>
								<td bgcolor="#FFFFFF"><input type="radio" name="view_level" value="0" <?if($view_level=="0" or $view_level==""){?>checked<?}?>>관리자전용
								<input type="radio" name="view_level" value="1" <?if($view_level=="1"){?>checked<?}?>>준회원이상
								<input type="radio" name="view_level" value="2" <?if($view_level=="2"){?>checked<?}?>>정회원이상
								<input type="radio" name="view_level" value="3" <?if($view_level=="3"){?>checked<?}?>>비회원이상
								</td>
							</tr>
							<tr>
								<td width="150" align="center" bgcolor="#f6f6f6" class="btitle02">비밀글</td>
								<td bgcolor="#FFFFFF"><input type="checkbox" name="secret" value="Y" <?if($secret=="Y"){?>checked<?}?>>비밀글</td>
							</tr>
							<tr>
								<td width="150" align="center" bgcolor="#f6f6f6" class="btitle02">사용자첨부파일</td>
								<td bgcolor="#FFFFFF"><input type="checkbox" name="fileup" value="Y" <?if($fileup=="Y"){?>checked<?}?>> 첨부파일 (관리자에는 기본적으로 첨부파일 기능이 있습니다.)</td>
							</tr>
							<tr>
								<td width="150" align="center" bgcolor="#f6f6f6" class="btitle02">댓글</td>
								<td bgcolor="#FFFFFF"><input type="radio" name="comm" value="0" <?if($comm=="0" or $comm==""){?>checked<?}?>>댓글없음
								<input type="radio" name="comm" value="1" <?if($comm=="1"){?>checked<?}?>>댓글
								<input type="radio" name="comm" value="2" <?if($comm=="2"){?>checked<?}?>>댓글의댓글</td>
							</tr>
							<!--<tr>
								<td width="150" align="center" bgcolor="#f6f6f6" class="btitle02">포인트</td>
								<td bgcolor="#FFFFFF"><input type="radio" name="point" value="0" <?if($point=="0" or $point==""){?>checked<?}?>>포인트없음
								<input type="radio" name="point" value="1" <?if($point=="1"){?>checked<?}?>>포인트있음</td>
							</tr>-->
							<tr>
								<td width="150" align="center" bgcolor="#f6f6f6" class="btitle02">노출여부</td>
								<td bgcolor="#FFFFFF"><input type="radio" name="display" value="Y" <?if ($display=="Y" or $display==""){?>checked<?}?>>노출함 
								<input type="radio" name="display" value="N" <?if ($display=="N"){?>checked<?}?>>노출안함
								</td>
							</tr>							
						</form>
						</table>
						
						<br />
						<table width="99%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td height="40" align="center" class="rtitle01">
								<span class="btn1"><a href="javascript:check();">확인</a></span>
								<?If( $mode!="ZZ001"){?>
								<?If( $typ=="edit"){?><span class="btn1"><a href="javascript:del();">삭제</a></span><?}?>
								<span class="btn1"><a href="create_list.php?<?=$param?>">목록</a></span>
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
