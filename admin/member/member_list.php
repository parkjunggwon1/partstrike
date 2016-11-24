<?
include $_SERVER["DOCUMENT_ROOT"]."/admin/include/header.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.member.php";
$mem_type = substr($mode,4,1);
if($mode=="CC011"){
	$searchand=" and del='1'";
}else if($mode=="CC012"){
	$searchand=" and black>0";
	if($cate==1 or $cate==2){
		$searchand=" and black=$cate";	
	}else if($cate==3){
		$searchand=" and black=$cate";	
	} 
}else{
	$searchand=" and mem_type='$mem_type'";
}
$searchand .= " and rel_idx='0' ";
if ($strsearch){
	$searchand .= " and $search like '%$strsearch%'";
}

if ($start1){
	$searchand .= " and reg_date >='$start1'";
}
if ($end1){
	$searchand .= " and reg_date <='$end1'";
}
if ($start2){
	$searchand .= " and login_date <'$start2'";
}
if ($end2){
	//$searchand .= " and login_date >'$end2'";
}
if ($search1){
	$searchand .= " and nation ='$search1'";
}
if ($search2){
	$searchand .= " and mem_type ='$search2'";
}
if ($search3){
	$searchand .= " and memfee ='$search3'";
}
if ($search4){
	$searchand .= " and deposit ='$search4'";
}
$param .= "&start1=$start1&end1=$end1&start2=$start2&end2=$end2&search1=$search1&search2=$search2&search3=$search3&search4=$search4";

$cnt = QRY_CNT("member",$searchand);
$totalpage = QRY_TOTALPAGE($cnt,$recordcnt);

$c = " a.* ";
$c .= " ,(select code_desc from code_group_detail where grp_code='NA' and dtl_code=a.nation) as nation_txt ";
$c .= " ,(select code_desc from code_group_detail where grp_code='NA' and dtl_code=a.dosi) as dosi_txt ";
$c .= " ,(select code_desc from code_group_detail where grp_code='MEM' and dtl_code=a.mem_type) as mem_type_txt ";
$c .= " ,(select count(*) from member where rel_idx=a.mem_idx) as rel_cnt ";


$result =QRY_C_LIST($c," member a ",$recordcnt,$page,$searchand,$mode=="CC011"?" del_date DESC":" mem_idx  DESC");
?>
<script type="text/javascript" src="/include/calendar.js"></script>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td height="30" background="/admin/img/now_bg.gif" style="padding-left: 20px" class="now"><img src="/admin/img/icon.gif" width="9" height="7" /> HOME &gt; <?=$title_menu?>  </td>
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
						<br />
						<table width="99%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td height="40" class="rtitle01"><img src="/admin/img/icon_02.gif" width="15" height="15" vspace="3" align="absmiddle" /> <?=$title_text?></td>
								<td width="100" height="35" class="rtitle01" align="center"><p class="tblue">검색건수 : &nbsp;<?=$cnt?>&#13;</p></td>
								<!--<td align="right" class="btitle02" width="100">								
								<a href="javascript:down_excel('excel')"><span class="btn">엑셀 파일</span></a>
								</td>-->
							</tr>
						</table>
						<form name="searchfrm" method="post" action="member_list.php?mode=<?=$mode?>">
						<input type="hidden" name="mode" value="<?=$mode?>">
						<input type="hidden" name="page" value="1">
						<table width="800" border="0" cellspacing="0" cellpadding="0" class="teduri">
						
							<tr>
								<td class="tgray02">
								가입일 
								<input type="text" name="start1" id="start1" size="15" readonly onclick="Calendar_D(this,event.clientX, event.clientY);"  class="inputtext" style="width:70px;" value="<?=$start1?>">
								~
								<input type="text" name="end1" id="end1" size="15" readonly onclick="Calendar_D(this,event.clientX, event.clientY);" class="inputtext" style="width:70px;"  value="<?=$end1?>">
								&nbsp;&nbsp;&nbsp;&nbsp;
								<span class="btn1"><a href="javascript:setSearchDate2('start1','end1',0);">오늘</a></span>
								<span class="btn1"><a href="javascript:setSearchDate2('start1','end1',7);">일주일</a></span>
								<span class="btn1"><a href="javascript:setSearchDate2('start1','end1',30);">한달</a></span>
								<span class="btn1"><a href="javascript:setSearchDate2('start1','end1',60);">두달</a></span>
								</td>
							</tr>
							<tr>
								<td class="tgray02">
								 미 접속일 
								<input type="text" name="start2" id="start2" size="15" readonly onclick="Calendar_D(this,event.clientX, event.clientY);"  class="inputtext" style="width:70px;" value="<?=$start2?>">
								~
								<input type="text" name="end2" id="end2" size="15" readonly onclick="Calendar_D(this,event.clientX, event.clientY);" class="inputtext" style="width:70px;"  value="<?=$end2?>">
								&nbsp;&nbsp;&nbsp;&nbsp;
								<span class="btn1"><a href="javascript:setSearchDate2('start2','end2',365);">1년</a></span>
								<span class="btn1"><a href="javascript:setSearchDate2('start2','end2',730);">2년</a></span>
								<span class="btn1"><a href="javascript:setSearchDate2('start2','end2',1095);">3년</a></span>
								</td>
							</tr>
							<tr>
								<td class="tgray02">
								<select name="search1">
								<option value="">국가</option>
								<?
								$result1 =QRY_LIST("code_group_detail","all","1"," and grp_code='NA' and code_depth='1' "," dtl_code ASC");
								while($row1 = mysql_fetch_array($result1)){
									$dtl_code= replace_out($row1["dtl_code"]);
									$code_desc= replace_out($row1["code_desc"]);
								?>
								<option value="<?=$dtl_code?>"  <?If ($dtl_code==$search1) {?> selected <? } ?>><?=$code_desc?></option>
								<?
								}
								?>
								</select>
								<select name="search2" size="1" id="search">
								<option value="" >회원구분</option>
								<?
								$result2 =QRY_LIST("code_group_detail","all","1"," and grp_code='MEM' and code_depth='1' "," dtl_code ASC");
								while($row2 = mysql_fetch_array($result2)){
									$dtl_code= replace_out($row2["dtl_code"]);
									$code_desc= replace_out($row2["code_desc"]);
								?>
								<option value="<?=$dtl_code?>" <?If ($dtl_code==$search2) {?> selected <? } ?>><?=$code_desc?></option>
								<?
								}
								?>
								</select> 
								<select name="search3" size="1" id="search">
								<option value="" >회원등급</option>
								<option value="0" <?If ($search3=="0") {?> selected <? } ?>>무료</option>
								<option value="1" <?If ($search3=="1") {?> selected <? } ?> >유료</option>
								</select> 
								<input type="checkbox" name="search4" value="1"  <?If ($search4==1) {?> checked <? } ?>>보증금
								</td>
							</tr>
							<tr>
								<td height="40" >
								<select name="search">								
								<option value="mem_nm" <?If ($search=="mem_nm") {?> selected <? } ?>>이름</option>
								<option value="mem_id" <?If ($search=="mem_id") {?> selected <? } ?>>아이디</option>
								</select>
								<input type='text' name="strsearch" size='30' maxlength ='20' value="<?=$strsearch?>" onKeyPress="check_key(check_search);" style="font-size:9pt;height:21px;">	
								<span class="btn1"><a href="javascript:check_search();">SEARCH</a></span>
								</td>
							</tr>
							<?if($mode=="CC012"){?>
							<tr>
								<td height="40" >
								<span class="btn1"><a href="member_list.php?mode=<?=$mode?>">전체</a></span>
								<span class="btn1"><a href="member_list.php?mode=<?=$mode?>&cate=1">1차경고</a></span>
								<span class="btn1"><a href="member_list.php?mode=<?=$mode?>&cate=2">2차경고</a></span>
								<span class="btn1"><a href="member_list.php?mode=<?=$mode?>&cate=3">3차경고</a></span>
								</td>
							</tr>
							<?}?>
						</table>
						</form>
						<br>
						<!--오른쪽 시작-->
						<form name="f" method="post">
						<input type="hidden" name="typ" value="<?=$typ?>">
						<input type="hidden" name="mode" value="<?=$mode?>">
						<table width="99%" border="0" cellspacing="0" cellpadding="0"  background="/admin/img/boardbar_bg.gif">
							<tr>
								<!--<td width="60" height="27" align="center" class="btitle01" ><input type="checkbox" name="alldelchk" onclick="alldel_chk(this.checked);" ></td>	-->
								<td width="60"  height="27" align="center" class="btitle01" >번호</td>
								<td width="100"  align="center" class="btitle01">국가</td>
								<td width="100"  align="center" class="btitle01">도시</td>
								<td align="center" class="btitle01">아이디</td>
								<td width="100"  align="center" class="btitle01">가입일</td>
								<td width="100"  align="center" class="btitle01">회사구분</td>
								<td width="100"  align="center" class="btitle01">회원등급</td>
								<?if($mode=="CC011"){?>
								<td width="300"  align="center" class="btitle01">탈퇴사유</td>
								<td width="120"  align="center" class="btitle01">탈퇴상태</td>
								<?}else{?>
								<td width="100"  align="center" class="btitle01">상호명</td>
								<td width="100"  align="center" class="btitle01">대표자명</td>
								<td width="150"  align="center" class="btitle01">이메일</td>
								<?}?>
								
							</tr>
						</table>
						
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
							$idx = replace_out($row["mem_idx"]);
							$mem_id = replace_out($row["mem_id"]);
							$mem_nm = replace_out($row["mem_nm"]);
							$pos_nm = replace_out($row["pos_nm"]);
							$reg_date = substr(replace_out($row["reg_date"]),0,10);
							$nation_txt= replace_out($row["nation_txt"]);
							$dosi_txt= replace_out($row["dosi_txt"]);
							$mem_type_txt= replace_out($row["mem_type_txt"]);
							$rel_cnt = replace_out($row["rel_cnt"]);
							$email = replace_out($row["email"]);
							$memfee_txt = r_want2(replace_out($row["memfee"]),"0","무료","유료");
							if($rel_cnt>0){$rel_cnt_html = "&nbsp;&nbsp;[$rel_cnt]";}else{$rel_cnt_html="";}
							$del_memo = replace_out($row["del_memo"]);
							$del_permit = replace_out($row["del_permit"]);
							
						?>
						<table width="99%" border="0" cellspacing="0" cellpadding="0">
							<a href="member_view.php?<?=$param?>&idx=<?=$idx?>" id="go_<?=$idx?>"></a>
							<tr>
								<!--<td width="60"  height="27" align="center"><input type="checkbox" name="delchk[]" value="<?=$idx?>"></td>-->
								<td width="60" height="27" align="center"><?=$ListNO?></td>
								<td width="100" align="center"><?=$nation_txt?></td>
								<td width="100" align="center"><?=$dosi_txt?></td>
								<td align="center" ><a href="#" onclick="gogo('<?=$idx?>')"><?=$mem_id?><?=$rel_cnt_html?></a></td>
								<td width="100" align="center"><?=$reg_date?></td>
								<td width="100" align="center"><?=$mem_type_txt?></td>
								<td width="100" align="center"><?=$memfee_txt?></td>
								<?if($mode=="CC011"){?>
								<td width="300"  align="center" ><?=$del_memo?></td>
								<td width="120"  align="center" ><?
									if($del_permit=="Y") { 
										  echo "탈퇴승인";
									  }else{
										  	  echo "<input type='hidden' name='del_permit' value='$del_permit'><select id='mem_$idx' onchange='changeVal(this , $idx)'><option value=''>탈퇴요청</option><option value='Y'>탈퇴승인</option></select>";
									  }	
									?></td>
								<?}else{?>
								<td width="100" align="center" ><?=$mem_nm?></td>
								<td width="100" align="center"><?=$pos_nm?></td>
								<td width="150" align="center" ><?=$email?></td>
								<?}?>
							</tr>
							<tr>
								<td height="1" colspan="10" bgcolor="#dcd8d6"></td>
							</tr>
						</table>
						<? 
							$ListNO--;
						} 
						?>
						</form>
						<br>
						<table width="99%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<Td width=120>&nbsp;</td>
								<td height="40" align="center">
								<?
								$addpara = $param;

								include $_SERVER["DOCUMENT_ROOT"]."/admin/include/paging_admin.php";

								?>
								</td>
								<td width="120" align="right">
								<!--<span class="btn1"><a href="member_write.php?<?=$param?>">등록</a></span>
								<span class="btn1"><a href="javascript:del();">삭제</a></span>&nbsp; -->
								</td>
							</tr>
						</table>
						<br />
						
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
<?
include $_SERVER["DOCUMENT_ROOT"]."/admin/include/footer.php";
?>
<script type="text/javascript">
<!--
	function del(){
		
		if (confirm("삭제하시겠습니까?")==true){
			document.f.typ.value = "alldel";
			document.f.action = "member_proc.php?<?=$param?>";
			document.f.encoding = "multipart/form-data";
			document.f.submit();			
		}
	}


	function changeVal(obj ,mem_idx){
		if (obj.value=="Y")
		{
			
			if(confirm("탈퇴 승인 처리 하시겠습니까?")){
				$.ajax({
					url: "/ajax/proc_ajax.php", 
					data: { actty : "RMTP", //remit Proc
					mem_idx : mem_idx
					},
					dataType : "html" ,
					async : false ,
					success: function(data){ 
						check_search();
					}
				});								
			}else{
				$("#mem_"+mem_idx+" option:eq(0)").attr("selected",true);
			}
		}
	}

//-->
</script>
