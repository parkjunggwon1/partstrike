<?
$mode = $_REQUEST['mode'];
$page = $_REQUEST['page'];

$search = $_REQUEST['search'];
$strsearch = $_REQUEST['strsearch'];


include $_SERVER["DOCUMENT_ROOT"]."/admin/include/header.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.other.php";



$searchand = " and gubun='$mode'";
if ($strsearch){
	$searchand .= " and $search like '%$strsearch%'";
}

$cnt = QRY_CNT("popup",$searchand);
$totalpage = QRY_TOTALPAGE($cnt,$recordcnt);
$result =QRY_POPUP_LIST($recordcnt,$searchand,$page);

?>
<script type="text/javascript">
<!--	

	function popup_view(id){
		var p_top = document.getElementById("p_top"+id).value;
		var p_left = document.getElementById("p_left"+id).value;
		var p_wid = document.getElementById("p_wid"+id).value;
		var p_hei = document.getElementById("p_hei"+id).value;
		var scr_yn = document.getElementById("scr_yn"+id).value;
		var lay_yn = document.getElementById("lay_yn"+id).value;
		var p_wid2 = parseInt(p_wid)+10;
		var p_hei2 = parseInt(p_hei)+50;
		if(lay_yn=="y"){
			document.getElementById("popifr").src="popup.php?idx="+id;
			document.getElementById("popifr").style.width=p_wid2;
			document.getElementById("popifr").style.height=p_hei2;
			document.getElementById("popdiv").style.display="";
			document.getElementById("popdiv").style.top=p_top;
			document.getElementById("popdiv").style.left=p_left;
			document.getElementById("popdiv").style.width=p_wid;
			document.getElementById("popdiv").style.height=p_hei;
		}

		if(lay_yn=="n"){
			window.open("popup.php?idx="+id,"_blank","left="+p_left+",top="+p_top+",scrollbars="+scr_yn+",resizable=no,copyhistory=no,width="+p_wid2+",height="+p_hei2+"");
		}
	}
//-->
</script>
<div name="popdiv" id="popdiv" style="display:none;position:absolute; z-index:1; filter:alpha(opacity=100);">
<iframe name="popifr" id="popifr" src="<?=$url1?>"style="display:;position:absolute;z-index:1;" frameborder="0" ></iframe>
</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td height="30" background="/admin/img/now_bg.gif" style="padding-left: 20px" class="now"><img src="/admin/img/icon.gif" width="9" height="7" /> HOME &gt; 사이트관리</td>
	</tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="208" valign="top"><?
		  include $_SERVER["DOCUMENT_ROOT"]."/admin/include/lm.php";
		?></td>
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
						<br />
						<table width="99%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td height="40" class="rtitle01"><img src="/admin/img/icon_02.gif" width="15" height="15" vspace="3" align="absmiddle" /> 팝업관리</td>
							</tr>
						</table>
						<!--오른쪽 시작-->

						<table width="99%" border="0" cellspacing="0" cellpadding="0" background="/admin/img/boardbar_bg.gif">
							<tr>
								<td width="60" height="27" align="center" class="btitle01" >번호</td>								
								<td align="center" class="btitle01">제목</td>	
								<td width="150" align="center" class="btitle01">미리보기</td>
								<td width="100" align="center" class="btitle01">입력방법</td>
								<td width="100" align="center" class="btitle01">팝업종류</td>
								<td width="100" align="center" class="btitle01">적용여부</td>
								<td width="150" align="center" class="btitle01">등록일</td>								
								<!--<td width="70" align="center" class="btitle01">수정</td>
								<td width="70" align="center" class="btitle01">삭제</td>-->
							</tr>
						</table>
						
						<!--일반게시글 시작-->
						<?
						if ($cnt==0){
						?>
						<table width="99%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td height="50" align="center">등록 된 자료가 없습니다</td>
							</tr>
							<tr>
								<td height="1" colspan="9" bgcolor="#dcd8d6"></td>
							</tr>
						</table>
						<?
						}
						$ListNO=$cnt-(($page-1)*$recordcnt);

						while($row = mysql_fetch_array($result)){
							$idx = replace_out($row["idx"]);
							$title=replace_out($row["title"]);
							$content=replace_out($row["content"]);
							$log_date=replace_out($row["log_date"]);
							$p_top = replace_out($row["p_top"]); 
							$p_left = replace_out($row["p_left"]);   
							$p_wid = replace_out($row["p_wid"]);   
							$p_hei = replace_out($row["p_hei"]);     
							$lay_yn = replace_out($row["lay_yn"]);    
							$img_yn = replace_out($row["img_yn"]);  
							$scr_yn = replace_out($row["scr_yn"]);   
							$use_yn = replace_out($row["use_yn"]);    
							$url1 = replace_out($row["url1"]);
							$file1 = replace_out($row["file1"]);
							$lay_txt = r_want2($lay_yn,"y","레이어팝업","일반팝업");
							$img_txt = r_want2($img_yn,"y","IMAGE","HTML");
							$use_txt = r_want2($use_yn,"y","사용","사용안함");
							
						?>
						<input type="hidden" id="url<?=$idx?>" value="<?=$url1?>">
						<input type="hidden" id="p_top<?=$idx?>" value="<?=$p_top?>">
						<input type="hidden" id="p_left<?=$idx?>" value="<?=$p_left?>">
						<input type="hidden" id="p_wid<?=$idx?>" value="<?=$p_wid?>">
						<input type="hidden" id="p_hei<?=$idx?>" value="<?=$p_hei?>">
						<input type="hidden" id="lay_yn<?=$idx?>" value="<?=$lay_yn?>">
						<input type="hidden" id="scr_yn<?=$idx?>" value="<?=$scr_yn?>">
						<table width="99%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="60" height="32" align="center"><?=$ListNO?></td>								
								<td><a href="popup_write.php?<?=$param?>&idx=<?=$idx?>&typ=edit"><?=$title?></a>								
								</td>		
								<td width="150" align="center"><span class="btn1"><a href="javascript:popup_view('<?=$idx?>');">미리보기</a></span></td>	
								<td width="100" align="center"><?=$img_txt?></td>	
								<td width="100" align="center"><?=$lay_txt?></td>	
								<td width="100" align="center"><?=$use_txt?></td>	
								<td width="150" align="center"><?=$log_date?></td>								
								<!--<td width="70" align="center"><a href="javascript:edit('<%=idx%>');"><img src="/admin/img/btn_modify02.gif" width="35" height="18" border="0"></a></td>
								<td width="70" align="center"><a href="javascript:del('<%=idx%>');"><img src="/admin/img/btn_del02.gif" width="35" height="18" border="0"></a></td>-->
							</tr>
							<tr>
								<td height="1" colspan="9" bgcolor="#dcd8d6"></td>
							</tr>
						</table>
						<? 
							$ListNO--;
						} 
						?>
						
						<br>
						<table width="99%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td height="40" align="center"><?
								$addpara = "";
								$pageurl = "popup_list.php";

								include $_SERVER["DOCUMENT_ROOT"]."/admin/include/paging_admin.php";

								?></td>
								<td width="60" align="right"><span class="btn1"><a href="popup_write.php?<?=$param?>">등록</a></span></td>
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
				</table>
				</td>
			</tr>
		</table>
		</td>
	</tr>
</table>
<!--#include virtual="/admin/include/footer.asp" -->