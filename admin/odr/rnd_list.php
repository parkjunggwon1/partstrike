<?
include $_SERVER["DOCUMENT_ROOT"]."/admin/include/header.php";
include $_SERVER["DOCUMENT_ROOT"]."/sql/sql.odr.php";


$searchand=" and a.odr_no <>'' and fty_history_idx <> '' and h.status IN(25,28,14,30) and h.reason_ty='6' ";
if ($strsearch){
	$searchand .= " and $search like '%$strsearch%'";
}

$cnt = QRY_CNT_GROUP("odr a 
					left outer join fty_history h  on a.odr_idx = h.odr_idx 
					left outer join member s on a.sell_mem_idx = s.mem_idx
					left outer join member b on a.mem_idx = b.mem_idx", $searchand, " h.odr_det_idx");
$totalpage = QRY_TOTALPAGE($cnt,$recordcnt);

$c = "h.*,s.mem_idx s_mem_idx, s.mem_nm s_mem_nm ,s.mem_nm_en s_mem_nm_en, s.rel_idx s_rel_idx, s.nation s_nation,b.mem_idx b_mem_idx,b.mem_nm b_mem_nm,b.mem_nm_en b_mem_nm_en, b.rel_idx b_rel_idx, b.nation b_nation, a.odr_idx, a.odr_no";
$tbl = "odr a 
		left outer join fty_history h  on a.odr_idx = h.odr_idx
		left outer join member s on a.sell_mem_idx = s.mem_idx
		left outer join member b on a.mem_idx = b.mem_idx
		";



$result =QRY_C_LIST_GROUP($c,$tbl,$recordcnt,$page,$searchand," h.odr_det_idx");
?>
<div name="popdiv" id="popdiv" style="display:none;position:absolute; z-index:1; filter:alpha(opacity=100);">
<iframe name="popifr" id="popifr" src="<?=$url1?>"style="display:;position:absolute;z-index:1;" frameborder="0" ></iframe>
</div>

<input type="hidden" id="url<?=$idx?>" value="<?=$url1?>">
<input type="hidden" id="p_top<?=$idx?>" value="<?=$p_top?>">
<input type="hidden" id="p_left<?=$idx?>" value="<?=$p_left?>">
<input type="hidden" id="p_wid<?=$idx?>" value="<?=$p_wid?>">
<input type="hidden" id="p_hei<?=$idx?>" value="<?=$p_hei?>">
<input type="hidden" id="lay_yn<?=$idx?>" value="<?=$lay_yn?>">
<input type="hidden" id="scr_yn<?=$idx?>" value="<?=$scr_yn?>">
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
						<!--오른쪽 시작-->
						<form name="f" method="post">
						<input type="hidden" name="typ" value="<?=$typ?>">
						<input type="hidden" name="mode" value="<?=$mode?>">
						<table width="99%" border="0" cellspacing="0" cellpadding="0"  background="/admin/img/boardbar_bg.gif">
							<tr>
								<!--<td width="60" height="27" align="center" class="btitle01" ><input type="checkbox" name="alldelchk" onclick="alldel_chk(this.checked);" ></td>	-->
								<td width="60"  height="27" align="center" class="btitle01" >번호</td>
								<td width="100"  align="center" class="btitle01">날짜</td>
								<td width="100"  align="center" class="btitle01">발주번호</td>
								<td width="15%"  align="center" class="btitle01">판매자</td>
								<td width="15%"  align="center" class="btitle01">구매자</td>
								<td align="center" class="btitle01">PartNo/단가/개수</td>
								<!--td width="150"  align="center" class="btitle01">총금액</td-->
								<td width="100"  align="center" class="btitle01">현재상태</td>
								<td width="150"  align="center" class="btitle01">업무처리</td>
								
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
							$odr_idx = replace_out($row["odr_idx"]);
							$odr_det_idx = replace_out($row["odr_det_idx"]);
							$fty_history_idx = replace_out($row["fty_history_idx"]);
							$s_mem_idx = replace_out($row["s_mem_idx"]);
							$s_mem_nm = replace_out($row["s_mem_nm"]);
							$s_mem_nm_en = replace_out($row["s_mem_nm_en"]);
							$s_rel_idx = replace_out($row["s_rel_idx"]);
							$s_nation = replace_out($row["s_nation"]);
							$b_mem_idx = replace_out($row["b_mem_idx"]);
							$b_mem_nm = replace_out($row["b_mem_nm"]);
							$b_mem_nm_en = replace_out($row["b_mem_nm_en"]);
							$b_rel_idx = replace_out($row["b_rel_idx"]);
							$b_nation = replace_out($row["b_nation"]);
							$reg_mem_idx= replace_out($row["reg_mem_idx"]);
							$reg_date = substr(replace_out($row["reg_date"]),0,10);
							$status = replace_out($row["status"]);
							$reason_ty = replace_out($row["reason_ty"]);
							$etc1 = replace_out($row["etc1"]);
							$odr_no = replace_out($row["odr_no"]);
							$confirm_yn = replace_out($row["confirm_yn"]);

						?>
						<table width="99%" border="0" cellspacing="0" cellpadding="0">
							<a href="member_view.php?<?=$param?>&idx=<?=$idx?>" id="go_<?=$idx?>"></a>
							<tr>
								<!--<td width="60"  height="27" align="center"><input type="checkbox" name="delchk[]" value="<?=$idx?>"></td>-->
								<td width="60" height="27" align="center"><?=$ListNO?></td>
								<td width="100" align="center"><?=$reg_date?></td>
								<td width="100" align="center"><a href="javascript:setVal('<?=$odr_no?>');"><?=get_any("odr","odr_no","odr_idx=$odr_idx")?></a></td>
								<td width="15%" align="center"><img src="/kor/images/nation_title2_<?=$s_nation?>.png"> <?=$s_mem_nm_en?><?if ($s_rel_idx!=0){echo " [".get_any("member", "mem_nm_en","mem_idx=$s_rel_idx")."]";}?></td>
								<td width="15%" align="center"><img src="/kor/images/nation_title_<?=$b_nation?>.png"> <?=$b_mem_nm_en?><?if ($b_rel_idx!=0){echo " [".get_any("member", "mem_nm_en","mem_idx=$b_rel_idx")."]";}?></td>
								<td align="center" class="tred" >
								<?
								$tot = 0;

								$sub_searchand = "and odr_idx = $odr_idx";

								if ($odr_det_idx){	$sub_searchand = "and odr_det_idx = $odr_det_idx";}
								$result2 =QRY_ODR_DET_LIST(0,$sub_searchand,0,"","asc");
								$cnt=mysql_num_rows($result2);
								$i = 0;
								while($row2 = mysql_fetch_array($result2)){
									$part_idx= replace_out($row2["a.part_idx"]);
									$part_type= replace_out($row2["part_type"]);
									$part_no= replace_out($row2["part_no"]);
									$odr_quantity= replace_out($row2["odr_quantity"]);
									$price= replace_out($row2["price"]);		
									$ship_idx= replace_out($row2["ship_idx"]);	
									$tot = $tot + $odr_quantity * $price;
									if ($cnt >1){ $i = $i + 1; }
									$br = $i > 1 ? "<BR><img src='/kor/images/stock_title0".$part_type."_s.gif'> ".$i.".":"<img src='/kor/images/stock_title0".$part_type."_s.gif'> ".$i.".";
									$br = str_replace("0.","",$br);
									?>								
									<?=$br?><u><?=$part_no?></u> &nbsp;&nbsp;$<?=number_format($price,2)?> &nbsp;&nbsp;<?=number_format($odr_quantity)?>
									
								<?}?>
								</td>
								<!--td width="150" align="center">$<?=number_format($tot,2)?></td-->
								<td width="100" align="center"><?=GF_Common_GetSingleList("ORD",$status)?><?if ($etc1){echo "<br>".$etc1;}?></td>
								<td width="150" align="center">
									<select id="fty_his_<?=$fty_history_idx;?>" onchange="changeTestVal(this , <?=$fty_history_idx;?>, <?=$ship_idx;?>)" Style="width:100px;">
										<option value=''></option>
										<?if($status != "28" && $status != "14"){?><option value='28'>수령</option><?}?>
										<?if($status == "28"){?><option value='OK'>TEST결과 공지</option><?}?>
									</select>
								</td>
								<!--td width="150" align="center">
								<?if ($status == "13"){							
									  chk_putin($odr_idx, "13",$s_mem_idx,$fty_history_idx);
									  chk_putin($odr_idx, "11",$b_mem_idx,$fty_history_idx);
									}						
									if ($status == "27"){							
									  chk_putin($odr_idx, "11",$b_mem_idx,$fty_history_idx);
									}						
								  if ($status =="25" && $reason_ty=="6"){   //TEST 해달라고 파츠스트라이크에 물건을 보낸 경우.
									if($confirm_yn=="Y") { 
										  echo "수령";
									  }else{
										  echo "<input type='hidden' name='confirm_yn' value='$confirm_yn'><select id='fty_his_".$fty_history_idx."' onchange='changeTestVal(this , $fty_history_idx)'><option value=''>미수령</option><option value='Y'>수령</option></select>";
									  }
								  }
								  if ($status =="28" &&  $reason_ty=="6"){	//TESTING중.
									if($confirm_yn=="Y") { 
										  echo "TEST완료";
									  }else{
										  echo "<span class='btn1'><a href='javascript:popup_view(".$fty_history_idx.",".$ship_idx.");'>TEST결과공지</a></span>";
									  }
								  }
								?></td-->
									
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
								$addpara = "";

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
						<form name="searchfrm" method="post" >
						<input type="hidden" name="page" value="<?=$page?>">
						<table width="99%" border="0" cellspacing="0" cellpadding="0" bgcolor="#f0f0f0">
							<tr>
								<td height="40" align="center">
								<select name="search">								
								<option value="a.odr_no" <?If ($search=="a.odr_no") {?> selected <? } ?>>발주번호</option>
								<option value="s.mem_nm" <?If ($search=="s.mem_nm") {?> selected <? } ?>>판매자명</option>
								<option value="b.mem_nm" <?If ($search=="b.mem_nm") {?> selected <? } ?>>구매자명</option>
								</select>
								<input type='text' name="strsearch" size='30' maxlength ='20' value="<?=$strsearch?>" onKeyPress="check_key(check_search);" style="font-size:9pt;height:21px;">	
								<span class="btn1"><a href="javascript:check_search();">SEARCH</a></span>
								</td>
							</tr>
						</table>
						</form>
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
			document.f.action = "odr_proc.php?<?=$param?>";
			document.f.encoding = "multipart/form-data";
			document.f.submit();			
		}
	}

	function changeTestVal(obj, fty_history_idx, ship_idx){
		if (obj.value=="28")
		{
			if(confirm("정말 수령 처리 하시겠습니까?")){
				$.ajax({
					url: "/ajax/proc_ajax.php", 
					data: { actty : "RT", //Receive Test Part
					actidx : fty_history_idx
					},
					dataType : "html" ,
					async : false ,
					success: function(data){ 
						check_search();
					}
				});								
			}else{
				$("#fty_his_"+fty_history_idx+" option:eq(0)").attr("selected",true);
			}
		}else if(obj.value!=""){ //테스트 결과통보 : 'OK' or 'FAIL'
			popup_view(fty_history_idx, ship_idx);
		}
	}

	function popup_view(his_idx, ship_idx){
		var p_top = 100;
		var p_left = "40%";
		var p_wid = 530;
		var p_hei = 400;
		var scr_yn = "no";
		var lay_yn = "y";
		var p_wid2 = parseInt(p_wid)+10;
		var p_hei2 = parseInt(p_hei)+50;
		if(lay_yn=="y"){
			document.getElementById("popifr").src="test_notify.php?fty_history_idx="+his_idx+"&ship_idx="+ship_idx+"&fty_history_idx="+his_idx;
			document.getElementById("popifr").style.width=p_wid2;
			document.getElementById("popifr").style.height=p_hei2;
			document.getElementById("popdiv").style.display="";
			document.getElementById("popdiv").style.top=p_top;
			document.getElementById("popdiv").style.left=p_left;
			document.getElementById("popdiv").style.width=p_wid;
			document.getElementById("popdiv").style.height=p_hei;
		}

		if(lay_yn=="n"){
			window.open("test_notify.php?idx="+id+"&fty_history_idx="+his_idx,"_blank","left="+p_left+",top="+p_top+",scrollbars="+scr_yn+",resizable=no,copyhistory=no,width="+p_wid2+",height="+p_hei2+"");
		}
	}
//-->
</script>


<?
function chk_putin($odr_idx, $charge_type,$mem_idx, $fty_history_idx){
  if ($fty_history_idx) {
		$fty_history_idx = "and fty_history_idx = $fty_history_idx ";
  }
  $sql = "select * from mybank where odr_idx = $odr_idx $fty_history_idx and charge_type in($charge_type) and mem_idx = $mem_idx";			
// echo $sql;
  $result_mybank=mysql_query($sql);
  $row_mybank = mysql_fetch_array($result_mybank);
  if ($row_mybank){
	  if ($charge_type == "8"){
		  $sub_title = "<br><font color='blue'>판매자 보증금</font> :<br>";
	  }elseif($charge_type == "2"){
		  $sub_title = "<br><font color='blue'>판매자 계약금</font> :<br>";
	  }
	  $mybank_idx =$row_mybank[mybank_idx];
	  $put_money_yn =$row_mybank[put_money_yn];
	  $charge_method =$row_mybank[charge_method];
	  $charge_type =$row_mybank[charge_type];
	  
	  if (!$sub_title && $charge_type == "2"){
	  	  $sub_title = "<br><font color='blue'>구매자 계약금</font> :<br>";
	  }
	  echo $sub_title;
	  $file1 =$row_mybank[file1];
	  echo $charge_method == "1"? "신용카드":($charge_method=="2"?"<a href='/upload/file/$file1' target='_blank'>입금</a>":$charge_method)." / ";
	  if ($charge_method == "2") {
		  if($put_money_yn=="Y") { 
			  echo "입금 완료";
		  }else{
			  echo "<input type='hidden' name='put_money_yn' value='$put_money_yn'><select id='depo_$mybank_idx' onchange='changeVal(this , $mybank_idx)'><option value=''>입금확인중</option><option value='Y'>입금완료</option></select>";
		  }
	  }else{
		  echo "결제 완료";
	  }
  }else{
	   if ($charge_type != "8"){
			echo "";
	   }
  }
}


?>